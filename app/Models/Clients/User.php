<?php

namespace App\Models\Clients;

use App\Enums\Clients\GenderTypes;
use App\Models\Social\Post;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

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
        $username=str_replace(' ','_',$value);
        $userRows  = $this->getAllUserSameName($username);
        $countUser = count($userRows) + 1;
        $this->attributes['username'] =($countUser > 1) ? "{$username}_{$countUser}" : $username;
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


    public function updateUser($user,$userId)
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



}
