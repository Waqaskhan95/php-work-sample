<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserListByRoleRequest;
use App\Http\Requests\RosterTeamRequest;
use App\Repository\UserRepositoryInterface;

class RosterController extends Controller
{
    protected $userRepository;

    function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getUsersByRoleType(UserListByRoleRequest $request) {
        try {
          $users = $this->userRepository->getUsersByRoleType($request);
          return response()->json($users);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function toggleToRosterTeam(RosterTeamRequest $request) {
        try {
          $users = $this->userRepository->toggleToRosterTeam($request);
          return response()->json($users);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getMyRosters(Request $request) {
        try {
          $users = $this->userRepository->getMyRosters($request);
          return response()->json($users);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
