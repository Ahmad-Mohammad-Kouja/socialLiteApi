<?php

namespace App\Models\Clients;

use App\Classes\FileClass;
use App\Classes\StringConstant;
use App\Enums\Clients\GenderTypes;
use App\Enums\General\FileTypes;
use App\Enums\General\StorageTypes;
use App\Enums\Social\SocialProviderTypes;
use App\Models\Social\Post;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Laravel\Socialite\Facades\Socialite;

class User extends Authenticatable
{
    use  HasApiTokens,Notifiable,SoftDeletes,CastsEnums;


    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email','username','password','gender','image'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','email_verified_at','updated_at','deleted_at'
    ];


    protected $dates=['created_at','updated_at','deleted_at'];

    protected $enumCasts = [
        'gender' => GenderTypes::class
    ];

    protected $casts=[
        'created_at' =>'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];




    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setUserNameAttribute($value)
    {
        $this->attributes['username'] = $this->generateUserName($value);
    }


    public function post()
    {
        return $this->hasMany(Post::class);
    }


    public  function createUser($user)
    {
      return  User::create($user);
    }

    public function login($credentials)
    {
        $user=null;
        if(Auth::attempt($credentials))
        {
            $user=Auth::user();
            $user->token_api=$user->createToken('api')->accessToken;
        }
        return $user;

    }

    public function getUserById($userId)
    {
        return User::find($userId);
    }

    public function getUser(array $filter)
    {
        return User::where($filter)
            ->first();
    }


    public function updateUser($userId,$user)
    {
        return User::where('id',$userId)
            ->update($user);
    }

    public function deleteUser($userId)
    {
        return User::where('id',$userId)
            ->delete();
    }

    private function getAllUserSameName($name)
    {
       return User::whereRaw("username REGEXP '^{$name}(_[0-9]*)?$'")->get();
    }

    public  function getUserFromSocialToken($token, $provider)
    {
        $user=null;
        try {
            $user=Socialite::driver($provider)->userFromToken($token);
        }
        catch (\Exception $e)
        {
            return null;
        }
        return $user;
    }


    public  function findOrCreateSocialUser($providerUser, $provider)
    {

        $user = User::getUser(['email'=>$providerUser->getEmail()]);

        $avatar = $providerUser->getAvatar();
        if ($provider == SocialProviderTypes::facebook)
            $avatar = str_replace('normal', 'large', $avatar);

        if (empty($user)) {

            $username = User::generateUserName($providerUser->getName());
            $profilePic = FileClass::getFileFromUrl(StringConstant::getFileName(FileTypes::photo,$username,
                'png'),$avatar,StringConstant::getShortPath(StorageTypes::user,FileTypes::photo));

            $user = User::create([
                'email' => $providerUser->getEmail(),
                'password' => Hash::make('abc'),
                'username' => $username,
                'image' => $profilePic,
                'gender' => GenderTypes::male,
                //'facebook_token' => ($provider == 'facebook') ? $providerUser->token : null,
                //'google_token' => ($provider == 'google') ? $providerUser->token : null,
            ]);
        } else {
            $deletedFile=FileClass::deleteFile($user->image);
            $profilePic = FileClass::getFileFromUrl(StringConstant::getFileName(FileTypes::photo,$user->id,
                'png'),$avatar,StringConstant::getShortPath(StorageTypes::user,FileTypes::photo));
            User::updateUser($user->id, [
                //'facebook_token' => ($provider == 'facebook') ? $providerUser->token : null,
               // 'google_token' => ($provider == 'google') ? $providerUser->token : null,
                'image' => $profilePic,
            ]);
        }
        $user->refresh();
        Auth::loginUsingId($user->id);
        $user->tokenAPI = $user->createToken('socialite')->accessToken;
        return $user;
    }

    public function generateUserName($name)
    {
        $username=str_replace(' ','_',$name);
        $userRows  = $this->getAllUserSameName($username);
        $countUser = count($userRows) + 1;
        return ($countUser > 1) ? "{$username}_{$countUser}" : $username;
    }


}
