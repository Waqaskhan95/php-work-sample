<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;

class SocialMediaLoginController extends Controller
{
    public function redirectToProvider($provider) {
        $resultUrl = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return response()->json(['url'=> $resultUrl],200);
    }

    public function handleProviderCallback($provider) {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                $token = Auth::user()->createToken('LaravelAuthApp')->accessToken; 
                return [
                    'token' => $token, 
                    'user' => new UserResource(Auth::user()), 
                    'message' => 'Logged In successfully',
                    'status' => 200 
                ];
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> $provider,
                    'role_id'   => 4,
                    'password' => encrypt('my-'.$provider)
                ]);
                Auth::login($newUser);
                $token = Auth::user()->createToken('LaravelAuthApp')->accessToken; 
                return [
                    'token' => $token, 
                    'user' => new UserResource(Auth::user()), 
                    'message' => 'Logged In successfully',
                    'status' => 200 
                ];
            }
        } catch (Exception $e) {
            return response()->json(['status' => 200 , 'message' => $e->getMessage()]);
        }
    }
}
