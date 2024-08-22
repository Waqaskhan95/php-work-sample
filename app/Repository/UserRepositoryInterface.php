<?php

namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\FollowUserRequest;

interface UserRepositoryInterface
{
   public function add(Request $request);
   public function checkLogin(Request $request);
   public function followUser(FollowUserRequest $request);
   
   public function updateProfile(Request $request);
   public function changePassword(Request $request);
   public function getUsersByRoleType(Request $request);
   public function toggleToRosterTeam(Request $request);
   public function getMyRosters(Request $request);
   public function toggleFollowUser(Request $request);
   public function getMyFollowers(Request $request);
   public function getMyFollowings(Request $request);
   public function checkFollow(Request $request);
   public function getProfile(Request $request);
   public function getAllUsers(Request $request);
   public function addTeam(Request $request);
   public function getTeamDetails(Request $request);
   public function setRole(Request $request);
   public function getMyRoles(Request $request);
   public function SwitchBetweenRoles(Request $request);
   public function getUserProfile($id);
   public function getAtheletes(Request $request);
   public function getMyAtheletes(Request $request);
   public function blockAccount(Request $request);
   public function getFeaturedAtheletes(Request $request);
}