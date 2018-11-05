<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Socialite;
use App\Models\SocialProvider;
use App\User;
use App\Mail\LoginMail;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
	/**
	* Redirect the user to the provider authentication page.
	*
	* @return \Illuminate\Http\Response
	*/
	public function redirectToProvider($provider_name)
	{
		// return Socialite::driver('facebook')->fields([
  //           'first_name', 'last_name', 'email', 'gender', 'birthday'
  //       ])->scopes([
  //           'email', 'user_birthday'
  //       ])->redirect();
	  	return Socialite::driver($provider_name)->redirect();
	}

	/**
	* Obtain the user information from GitHub.
	*
	* @return \Illuminate\Http\Response
	*/
	public function handleProviderCallback($provider_name)
	{
		// $facebook_user = Socialite::driver('facebook')->fields([
  //           'first_name', 'last_name', 'email', 'gender', 'birthday'
  //       ])->user();
  //       dd($facebook_user);
		
	    $user = Socialite::driver($provider_name)->user();
	    
	    // All Providers
		// $user->getId();
		// $user->getNickname();
		// $user->getName();
		// $user->getEmail();
		// $user->getAvatar();

	    $userProvider = SocialProvider::where('provider_id' , $user->getId())->first();

	    if($userProvider){
	    	$existUser = User::find($userProvider->user_id);
	    }else{
	    	$existUser = User::where('email' , $user->getEmail())->first();
	    	
	    	if(!$existUser){
	    		$existUser = new User();
	    		$existUser->name = $user->getName();
	    		$existUser->email = $user->getEmail();
	    		$existUser->password = bcrypt($user->getId());
	    		$existUser->save();
	    		Mail::to('mid90120@gmail.com')->queue(new LoginMail($existUser));
	    	}

	    	$userProvider = new SocialProvider();
	    	$userProvider->provider_id = $user->getId();
	    	$userProvider->provider_name = $provider_name;
	    	$userProvider->user_id = $existUser->id;
	    	$userProvider->save();
	    }

	    $attempt = Auth::attempt(['email' => $existUser->email , 'password' => $user->getId()]);
    	
    	return redirect('/home');

	}
}
