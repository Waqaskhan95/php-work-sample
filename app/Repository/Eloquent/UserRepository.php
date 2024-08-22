<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Models\RoleFollow;
use App\Models\RosterTeam;
use Spatie\Permission\Models\Role;
use App\Models\UserTeam;
use App\Models\BlockAccount;
use App\Models\Role as ModelRole;
use App\Models\ModelHasRole;
use App\Models\UserFollower;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\AtheleteResource;
use App\Http\Resources\ModelHasRoleResource;
use App\Http\Resources\RosterResource;
use App\Models\PasswordReset as PasswordResetModel;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct(User $model)
    {
       parent::__construct($model);
    }

    public function getUserByEmail($email) {
        return $this->model->where('email', $email)->first();
    }

    public function getToken($request) {
        return PasswordResetModel::where('token', $request->token)->first();
    }

    public function deleteToken($token) {
        PasswordResetModel::where('token', $token)->delete();
    }



    public function add(Request $request) {
       $user = $this->model;

       $user->first_name = $request->first_name;
       $user->last_name = $request->last_name;
       $user->name = $request->first_name ." ". $request->last_name;
       $user->email = $request->email;
       $user->role_id = $request->role_id;
       $user->phone_number = $request->phone_number ?? null;
       $user->password = Hash::make($request->password);
       $user->email_verified_at = now();

       $user->save();

       $role = Role::find($request->role_id);
       $user->assignRole($role);
       return $user;
    }

    public function checkLogin(Request $request) {
        $user = $this->getUserByEmail($request->email);
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return[
                'error' => ['The provided credentials are incorrect.'],
            ];
        }

        if(!$user->email_verified_at) {
            return ['user' => null , 'email' => $user->email, 'id' => $user->id];    
        }
        if(Auth::attempt($request->all()))
        {
            $checkUser = Auth::getLastAttempted();
            Auth::login($checkUser);
            $token = Auth::user()->createToken('LaravelAuthApp')->accessToken;
            return [
                'token' => $token, 
                'user' => new UserResource(Auth::user()), 
                'message' => 'User Logged In successfully',
                'status' => 200 
            ];
        }

        return [ 'error' =>'Invalid email/password.','status' => 401];
    }

    public function verifyAndUpdatePassword($request)
    {
        
        $code = $this->getToken($request); 
        
        $user = $this->getUserByEmail($code->email);  

        $this->updatePassword($request, $user->id);

        $this->deleteToken($code->token);
        
        return response()->json(['status'=>true,'message'=>'Password changed successfully']);
    }

    public function updatePassword($request, $id) {
        $user = $this->model->find($id);
        if($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return $user;
    }

    public function followUser($request){
        try {
            $user = $this->model->find($request->user_id);
            if($user){
                $follower = RoleFollow::where('user_id', $request->user_id)->where('follower_id', auth()->user()->id)->first();
                if($follower){
                    $follower->delete();
                    return response()->json(['message' => 'You have stopped following ' . $user->name ,'status' => 200]);
                }
                RoleFollow::create([
                    'user_id' => $request->user_id,
                    'follower_id' => auth()->user()->id,
                ]);
                return response()->json(['message' => 'You have started following ' . $user->name ,'status' => 200]);
            }
            return response()->json(['message' => 'User doesnot exist' ,'status' => 500]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
    public function updateProfile(Request $request) {

       $user = auth()->user();
        if ($request->has('first_name')) {
            $user->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $user->last_name = $request->last_name;
        }

        if ($request->has('first_name') && $request->has('last_name')) {
            $user->name = $request->first_name ." ". $request->last_name;
        }

        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }

        if ($request->has('address')) {
            $user->address = $request->address;
        }

        if ($request->has('image')) {
            $imageFile = $request->image;
            $avatar = saveFile($imageFile, 'user/images', $imageFile->getClientOriginalName());
            $user->avatar = $avatar['path'];
        }

        if ($request->bio) {
            $user->bio = $request->bio;
        }

        // dd($request->image);
        $user->save();

        if ($request->has('team_name')) {
             $team = UserTeam::where('user_id',auth()->user()->id)->first();

             if ($team) {
                
                $team->team_name = $request->team_name;
                
                if ($request->has('team_category_id')) {
                    $team->category_id = $request->team_category_id;
                }

                if ($request->has('race_id')) {
                    $team->race_id = $request->race_id;
                }

                if ($request->has('sanctioning_body')) {
                    $team->sanctioning_body = $request->sanctioning_body;
                }

                if ($request->has('racing_age')) {
                    $team->racing_age = $request->racing_age;
                }

                if ($request->has('tags')) {
                    $team->tags = $request->tags;
                }

                if ($request->has('event_links')) {
                     $team->event_links = $request->event_links;
                }

                $team->save();

             }else{

                UserTeam::create([
                    'user_id' => auth()->user()->id,
                    'team_name' => $request->team_name,
                    'category_id' => $request->team_category_id,
                    'race_id'   => $request->race_id,
                    'sanctioning_body' => $request->sanctioning_body,
                    'racing_age'    => $request->racing_age,
                    'tags'  => $request->tags,
                    'event_links' => $request->event_links,
                ]);
             }
        }

        return $user;
    }

    public function changePassword(Request $request) {
        $user = Auth::user();
        if (Hash::check($request->input('old_password'), $user->password)) {
            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
            return [
                'message' => 'Password updated successfully',
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Old password is incorrect',
                'status'=> 302
            ];
        }
    }

    public function getUsersByRoleType(Request $request) {
        $users = $this->model->where('role_id',$request->role_id)->get();
        return [
            'data' => UserResource::collection($users),
            'status' => 200
        ];
    }

    public function toggleToRosterTeam(Request $request) {
        $checkRoster = RosterTeam::where('user_id',auth()->user()->id)->where('member_id',$request->user_id)->first(); 
        if ($checkRoster) {
            $checkRoster->delete();

            return [
                'data' => $checkRoster,
                'message' => 'Roster Removed Successfully',
                'status' => 200
            ];

        }else{
           $roster = RosterTeam::create([
            'user_id' => auth()->user()->id,
            'member_id' => $request->user_id
            ]);
            return [
                'data' => $roster,
                'message' => 'Added To Roster Successfully',
                'status' => 200
            ]; 
        }
        
    }

    public function getMyRosters(Request $request) {
        $rosters = RosterTeam::where('user_id',auth()->user()->id)->get();

        return [
            'data' => RosterResource::collection($rosters),
            'status' => 200
        ];
    }

    public function getMyFollowers(Request $request) {
        $users = UserFollower::where('user_id',auth()->user()->id)->pluck('from_user');

        $followers = $this->model->whereIn('id',$users)->get();
        return [
            'data' => UserResource::collection($followers),
            'status' => 200
        ];
    }

    public function getMyFollowings(Request $request) {
        $users = UserFollower::where('from_user',auth()->user()->id)->pluck('user_id');

        $followings = $this->model->whereIn('id',$users)->get();
        return [
            'data' => UserResource::collection($followings),
            'status' => 200
        ];
    }

    public function toggleFollowUser(Request $request) {
        $checkIfExist = UserFollower::where('user_id',$request->user_id)->where('from_user',auth()->user()->id)->first();
        if ($checkIfExist) {
            $checkIfExist->delete();

            return [
                'message' => 'Un-followed user successfully',
                'status'  => 200
            ];

        }else{
            UserFollower::create([
                'user_id'   => $request->user_id,
                'from_user' => auth()->user()->id
            ]);

            return [
                'message' => 'followed user successfully',
                'status'  => 200
            ];
        }
        
    }

    public function checkFollow(Request $request) {
        $checkIfExist = UserFollower::where('user_id',$request->user_id)->where('from_user',auth()->user()->id)->first();
        return [
            'data' => $checkIfExist,
            'status' => 200
        ];
    }

    public function getProfile(Request $request) {
        $user = auth()->user();

        return [
            'data' => new UserResource($user),
            'status' => 200
        ];
    }

    public function getAllUsers(Request $request) {
        $users = $this->model;
        $users = $users->paginate(env('APP_PAGINATE',10));
        $result = UserResource::collection($users)->response()->getData(true); 

        return [
            'data' => paginate($result),
            'status' => 200
        ];
    }

    public function addTeam(Request $request) {
        $user = auth()->user();
        $team = UserTeam::where('user_id',$user->id)->first();
        if ($team) {
            $team->team_name = $request->team_name;
                
                if ($request->has('category_id')) {
                    $team->category_id = $request->category_id;
                }

                if ($request->has('race_id')) {
                    $team->race_id = $request->race_id;
                }

                if ($request->has('sanctioning_body')) {
                    $team->sanctioning_body = $request->sanctioning_body;
                }

                if ($request->has('racing_age')) {
                    $team->racing_age = $request->racing_age;
                }

                if ($request->has('tags')) {
                    $team->tags = $request->tags;
                }

                if ($request->has('event_links')) {
                     $team->event_links = $request->event_links;
                }

                if ($request->has('location')) {
                     $team->location = $request->location;
                }

                if ($request->has('lat')) {
                     $team->lat = $request->lat;
                }

                if ($request->has('lng')) {
                     $team->lng = $request->lng;
                }

                $team->save();

                return [
                    'data' => $team ,
                    'message' => 'Team Updated Successfully',
                    'status' => 200
                ];

        }else{
            $team = UserTeam::create([
                        'user_id' => auth()->user()->id,
                        'team_name' => $request->team_name ?? null,
                        'category_id' => $request->category_id ?? null,
                        'race_id'   => $request->race_id ?? null,
                        'sanctioning_body' => $request->sanctioning_body ?? null,
                        'racing_age'    => $request->racing_age ?? null,
                        'tags'  => $request->tags ?? null,
                        'event_links' => $request->event_links ?? null,
                        'location' => $request->location ?? null,
                        'lat' => $request->lat ?? null,
                        'lng' => $request->lng ?? null,
                    ]);


            return [ 
                'data'      => $team ,
                'message'   => 'Team Added Successfully',
                'status'    => 200
            ];

        }
    }

    public function getTeamDetails(Request $request) {
        $team = UserTeam::with('category')->where('user_id',auth()->user()->id)->first();
        return [
            'data' => $team,
            'status' => 200
        ];
    }

    public function setRole(Request $request) {
        $user = $this->model->find(auth()->user()->id);
        $role = Role::find($request->role_id);
        $user->assignRole($role);

        return [
            'message'   => 'User Role Added Successfully',
            'status'    => 200
        ];
    }

    public function getMyRoles(Request $request) {
        $user = auth()->user();

        $roles = ModelHasRole::with('role')->where('model_id',auth()->user()->id)->get();

        return [
            'data' => ModelHasRoleResource::collection($roles),
            'status' => 200
        ];
    }

    public function SwitchBetweenRoles(Request $request) {
        $user = auth()->user();
        $user->role_id = $request->role_id;
        $user->save();
        $token = $user->createToken('LaravelAuthApp')->accessToken;
        return [
            'token' => $token, 
            'user' => new UserResource(Auth::user()), 
            'message' => 'User switched Successfully',
            'status' => 200 
        ];
    }

    public function getUserProfile($id) {
        $user = $this->model->find($id);

        if ($user) {
            return [
                'data' => new UserResource($user),
                'status' => 200
            ];
        }else{
            return [
                'error' => 'User Doesnot Found',
                'status' => 200
            ];
        }
    }

    public function getAtheletes(Request $request) {
        $users = $this->model->where('role_id',ModelRole::ATHELETE);

        $users = $users->get();
        return [
            'data' => AtheleteResource::collection($users),
            'status' => 200
        ];
    }

    public function getMyAtheletes(Request $request) {
        $users = $this->model->where('role_id',ModelRole::ATHELETE);
        $checkMyFollowers = UserFollower::where('from_user',auth()->user()->id)->pluck('user_id')->toArray();
        if (count($checkMyFollowers)) {
            $users = $users->whereIn('id',$checkMyFollowers);
            $users = $users->get();
            $data = AtheleteResource::collection($users);
        }else{
            $data = null;
        }
        return [
            'data' => $data,
            'status' => 200
        ];
    }

    public function blockAccount(Request $request) {
        
        $account = BlockAccount::create([
            'from_user' => auth()->user()->id,
            'to_user'   => $request->user_id,
            'reason'    => $request->reason ?? null
        ]);


        return [
            'message' => 'User Blocked Successfully',
            'data' => $account,
            'status' => 200
        ];
    }

    public function getFeaturedAtheletes(Request $request) {
        $getUsers = $this->model->whereHas('videos')->take(6)->inRandomOrder()->get();
        return [
            'data' => UserResource::collection($getUsers),
            'status' => 200
        ];
    }
}