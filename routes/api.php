<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GlobalController;
use App\Http\Controllers\Api\SocialMediaLoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StreamingController;
use App\Http\Controllers\Api\OpenTokController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\RosterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GlobalNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/get-all-roles', [GlobalController::class, 'getAllRoles'])->name('get-all-roles');
Route::POST('/register', [AuthController::class, 'register'])->name('register');
Route::POST('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forget/password', [AuthController::class, 'reset'])->name('reset-password');
Route::post('set/password', [AuthController::class, 'setPassword'])->name('set-password');
Route::get('authorize/{provider}/redirect', [SocialMediaLoginController::class, 'redirectToProvider'])->name('socail-redirect');
Route::get('authorize/{provider}/callback', [SocialMediaLoginController::class, 'handleProviderCallback'])->name('socail-callback');
Route::get('get-plan-by-role/{role}', [GlobalController::class, 'getPlanByRole'])->name('get-plan-by-role');
Route::get('get-all-parent-categories', [GlobalController::class, 'getAllParentCategories'])->name('get-all-parent-categories');
Route::get('get-sub-categories-by-parent/{category}', [GlobalController::class, 'getSubCategoryByParent'])->name('get-sub-categories-by-parent');
Route::get('get-all-brands', [GlobalController::class, 'getAllBrands'])->name('get-all-brands');
Route::get('get-all-countries', [GlobalController::class, 'getAllCountries'])->name('get-all-countries');
Route::get('get-states-by-country', [GlobalController::class, 'getStateByCountry'])->name('get-states-by-country');
Route::get('get-cities-by-state', [GlobalController::class, 'getCityByState'])->name('get-cities-by-state');
Route::get('get-all-colors', [GlobalController::class, 'getAllColors'])->name('get-all-colors');
Route::get('get-all-sizes', [GlobalController::class, 'getAllSizes'])->name('get-all-sizes');
Route::get('get-all-products', [ProductController::class, 'getAllProducts'])->name('get-all-products')->middleware('optional.auth');
Route::post('start-stream', [StreamingController::class, 'startStream']);
Route::post('stop-stream', [StreamingController::class, 'stopStream']);
Route::get('get-product-by-id/{productId}', [ProductController::class, 'getProductById'])->name('get-product-by-id')->middleware('optional.auth');
Route::get('get-users-by-role-type', [RosterController::class, 'getUsersByRoleType'])->name('get-users-by-role-type');

Route::get('opentok/session', [OpenTokController::class, 'createSession']);
Route::post('opentok/token', [OpenTokController::class, 'generateToken']);

Route::get('list-videos', [VideoController::class, 'listVideos'])->name('list-videos');
Route::get('get-recent-shorts', [VideoController::class, 'getRecentShort'])->name('get-recent-shorts');
Route::get('get-user-videos/{user}', [VideoController::class, 'getUserVideos'])->name('get-user-videos');
Route::get('get-user-shorts/{user}', [VideoController::class, 'getUserShorts'])->name('get-user-shorts');
Route::get('video-detail/{video}', [VideoController::class, 'videoDetail'])->name('video-detail');
Route::get('related-videos/{video}', [VideoController::class, 'relatedVideos'])->name('related-videos');
Route::post('add-view-on-video/{video}', [VideoController::class, 'addViewOnVideo'])->name('add-view-on-video');
Route::get('event-list', [EventController::class, 'getEventList'])->name('event-list');
Route::get('event-detail/{event}', [EventController::class, 'eventDetail'])->name('event-detail');
Route::get('get-user-profile/{user}', [UserController::class, 'getUserProfile'])->name('get-user-profile');
Route::get('get-atheletes', [UserController::class, 'getAtheletes'])->name('get-atheletes');
Route::get('get-featured-atheletes', [UserController::class, 'getFeaturedAtheletes'])->name('get-featured-atheletes');

Route::middleware(['auth:api'])->group(function(){
	Route::get('/get-profile', [AuthController::class, 'getProfile'])->name('get-profile');
	Route::POST('/update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
	Route::POST('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
	Route::post('add-product', [ProductController::class, 'AddProduct'])->name('add-product');
	Route::post('toggle-product-wishlist/{product}', [ProductController::class, 'toggleProductWishlist'])->name('toggle-product-wishlist');
	Route::get('get-my-wishlist', [ProductController::class, 'getMyWishlist'])->name('get-my-wishlist');
	Route::post('add-product-rating/{product}', [ProductController::class, 'addProductRating'])->name('add-product-rating');
	Route::get('get-my-product-rating/{product}', [ProductController::class, 'getMyProductRating'])->name('get-my-product-rating');
	Route::get('get-my-products', [ProductController::class, 'getMyProducts'])->name('get-my-products');
	Route::post('delete-product/{product}', [ProductController::class, 'deleteProduct'])->name('delete-product');
	Route::post('add-event', [EventController::class, 'addEvent'])->name('add-event');
	Route::post('edit-event/{event}', [EventController::class, 'editEvent'])->name('edit-event');
	Route::post('add-video', [VideoController::class, 'addVideo'])->name('add-video');
	Route::post('toggle-video-like/{video}', [VideoController::class, 'toggleVideoLike'])->name('toggle-video-like');
	Route::post('toggle-comment-like/{comment}', [VideoController::class, 'toggleCommentLike'])->name('toggle-comment-like');
	Route::post('toggle-comment-dislike/{comment}', [VideoController::class, 'toggleCommentDislike'])->name('toggle-comment-dislike');
	Route::post('add-short', [VideoController::class, 'addShort'])->name('add-short');
	Route::post('add-comment', [VideoController::class, 'addComment'])->name('add-comment');
	Route::post('add-timestamp-comment', [VideoController::class, 'addTimeStampComment'])->name('add-timestamp-comment');
	Route::post('edit-comment/{comment}', [VideoController::class, 'editComment'])->name('edit-comment');
	Route::post('delete-comment/{comment}', [VideoController::class, 'deleteComment'])->name('delete-comment');
	Route::post('add-order', [OrderController::class, 'addOrder'])->name('add-order');
	Route::post('follow-user', [UserController::class, 'followUser'])->name('follow-user');
	Route::post('add-event-to-it-chain', [EventController::class, 'eventToItChain'])->name('add-event-to-it-chain');
	Route::get('get-my-it-chain', [EventController::class, 'getMyItChain'])->name('get-my-it-chain');
	Route::post('initiate-conversation/{user}', [ConversationController::class, 'initiateConversation'])->name('initiate-conversation');
	Route::get('get-my-conversations', [ConversationController::class, 'getMyConversations'])->name('get-my-conversations');
	Route::get('get-conversation-messages', [ConversationController::class, 'getConversationMessages'])->name('get-conversation-messages');
	Route::post('sent-message-conversation', [ConversationController::class, 'sentMessageOnConversation'])->name('sent-message-conversation');
	Route::post('toggle-to-roster-team', [RosterController::class, 'toggleToRosterTeam'])->name('toggle-to-roster-team');
	Route::get('get-my-rosters', [RosterController::class, 'getMyRosters'])->name('get-my-rosters');
	Route::post('toggle-follow-user', [UserController::class, 'toggleFollowUser'])->name('toggle-follow-user');
	Route::get('get-my-followers', [UserController::class, 'getMyFollowers'])->name('get-my-followers');
	Route::get('get-my-followings', [UserController::class, 'getMyFollowings'])->name('get-my-followings');
	Route::get('check-follow', [UserController::class, 'checkFollow'])->name('check-follow');
	Route::post('add-team', [UserController::class, 'addTeam'])->name('add-team');
	Route::get('get-team-details', [UserController::class, 'getTeamDetails'])->name('get-team-details');
	Route::get('get-my-orders', [OrderController::class, 'getMyOrders'])->name('get-my-orders');
	Route::get('order-detail/{order}', [OrderController::class, 'orderDetail'])->name('order-detail');
	Route::post('assign-role',[UserController::class, 'setRole'])->name('assign-role');
	Route::get('get-my-roles',[UserController::class, 'getMyRoles'])->name('get-my-roles');
	Route::post('switch-between-roles',[UserController::class, 'SwitchBetweenRoles'])->name('switch-between-roles');
	Route::get('get-my-views-analytics',[VideoController::class, 'getMyViewsAnalytics'])->name('get-my-views-analytics');
	Route::get('get-my-notifications',[GlobalNotificationController::class, 'getMyNotifications'])->name('get-my-notifications');
	Route::get('get-my-recent-notifications',[GlobalNotificationController::class, 'getMyRecentNotifications'])->name('get-my-recent-notifications');
	Route::get('get-unseen-notifications',[GlobalNotificationController::class,'getUnseenNotifications'])->name('get-unseen-notifications');
	Route::post('seen-all-notifications',[GlobalNotificationController::class, 'seenAllNotifications'])->name('seen-all-notifications');
	Route::post('seen-notification/{id}',[GlobalNotificationController::class, 'seenNotification'])->name('seen-notification');
	Route::post('clear-notifications',[GlobalNotificationController::class, 'clearNotifications'])->name('clear-notifications');
	Route::get('get-my-unseen-notification-count',[GlobalNotificationController::class, 'getMyUnseenNotitificationCount'])->name('get-my-unseen-notification-count');
	Route::get('get-my-atheletes', [UserController::class, 'getMyAtheletes'])->name('get-my-atheletes');
	Route::post('block-account',[UserController::class, 'blockAccount'])->name('block-account');

	// admin apis 
	Route::get('get-all-users', [UserController::class, 'getAllUsers'])->name('get-all-users');
});