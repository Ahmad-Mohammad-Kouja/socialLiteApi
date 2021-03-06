<?php

namespace App\Http\Controllers\Clients;

use App\Classes\FileClass;
use App\Classes\ResponseHelper;
use App\Classes\StringConstant;
use App\Enums\Social\SocialProviderTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Users\LoginRequest;
use App\Http\Requests\Clients\Users\ProfileRequest;
use App\Http\Requests\Clients\Users\RegisterRequest;
use App\Http\Requests\Clients\Users\socialLoginRequest;
use App\Models\Clients\User;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    private  $users;

    /**
     * UserController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->users = $user;
    }

    public function register(RegisterRequest $request)
    {
        $user=$request->only('email','name','password');
        $user['username']=$user['name'];
		$user['image']=$request->get('image',StringConstant::$defaultUserImage);
		if(!FileClass::checkExistFile($user['image']))
		    return ResponseHelper::errorNotAllowed('Enter valid Image url');
        $user=$this->users->createUser($user);
        if(empty($user))
            return ResponseHelper::isEmpty('registering fail');
        $user=$this->users->login(['email' => $user->email , 'password' => $request->get('password')]);
        return ResponseHelper::insert($user);
    }

    public  function login(LoginRequest $request)
    {

        $user=$this->users->login(['email'=>$request->get('email') , 'password' => $request->get('password')]);
        if(empty($user))
            return ResponseHelper::isEmpty('login fail');
        return ResponseHelper::select($user);
    }

    public  function socialLogin(socialLoginRequest $request)
    {

        $provider=$request->get('provider');

        $socialUser=$this->users->getUserFromSocialToken($request->get('social_token'),$provider);
        if(empty($socialUser))
            return ResponseHelper::isEmpty('operation fail');
        $user=$this->users->findOrCreateSocialUser($socialUser,$provider);
        return ResponseHelper::select($user);
    }

    public function profile(ProfileRequest $request)
    {
        if($request->has('user_id'))
        $userId=$request->get('user_id');
        else $userId=$request->user()->id;

        $userProfile=$this->users->getProfile(['id'=>$userId]);
        if(empty($userProfile))
            return ResponseHelper::isEmpty('data not found');
        return ResponseHelper::select($userProfile);

    }

}
