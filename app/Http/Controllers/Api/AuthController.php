<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\UserRepositoryInterface;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\SetNewPasswordRequest;
use App\Notifications\PasswordResetRequestNotification;
use App\Models\PasswordReset;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    protected $userRepository;

    function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserRequest $request) {
        
        try {
          $user = $this->userRepository->add($request);  
          return response()->json([ 'message' => 'User Registered Successfully Please Verify', 'user' => $user, 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }  
    }

    public function login(LoginRequest $request) {
        $data = $this->userRepository->checkLogin($request);
        return response()->json($data);
    }

    public function reset(PasswordResetRequest $request) {
        
        $user = $this->userRepository->getUserByEmail($request->email);

        if(!$user) {
            return response()->json(['message' => 'Email is not registered','status' => false]);
        }
        $passwordReset = $this->generateToken($user->email);
        

        if ($user && $passwordReset){
            $user->notify( new PasswordResetRequestNotification($user, $passwordReset->token) );
        }
        return response()->json(['status'=>true , 'message' => 'We have sent you a verification code!' ]);
    }

    public function generateToken($email)
    {
        return PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'token' => rand(0, 9999),
                'created_at' => now()
            ]
        );
    }

    public function setPassword(SetNewPasswordRequest $request)
    {
        return $this->userRepository->verifyAndUpdatePassword($request);
    }

    public function updateProfile(Request $request) {
        
        try {
           $user = $this->userRepository->updateProfile($request);
           return response()->json([ 'message' => 'User Profile Successfully Updated', 'user' => new UserResource($user), 'status' => 200 ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function changePassword(ChangePasswordRequest $request) {
        try {
           $user = $this->userRepository->changePassword($request);
           return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }  
    }

    public function getProfile(Request $request) {
        try {
           $user = $this->userRepository->getProfile($request);
           return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }
}
