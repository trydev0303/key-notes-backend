<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('sign_up',             [AuthController::class, 'sign_up']);
Route::post('social_sign_up',      [Authcontroller::class, 'socialSignUp']);

Route::post('verify_otp',          [AuthController::class, 'verifyOtp']);
Route::post('resend_otp',          [AuthController::class, 'resendOtp']);
Route::post('login',               [AuthController::class, 'login']);
Route::post('social_login',        [Authcontroller::class, 'socialLogin']);
Route::post('forgot_password',     [AuthController::class, 'forgotPassword']);
Route::post('reset_password',      [AuthController::class, 'resetPassword']);

Route::post('push_notify', [AuthController::class, 'pushNotify']);

Route::middleware(['auth:api'])->group(function () {
    Route::group(['middleware' => ['userStatus']], function () {
        Route::get('get_profile',          [AuthController::class, 'getProfile']);
        Route::post('edit_profile',        [AuthController::class, 'editProfile']);
        Route::post('change_password',     [AuthController::class, 'changePassword']);
        Route::get('logout',               [AuthController::class, 'logout']);
        Route::get('delete_account',       [AuthController::class, 'deleteAccount']);

        Route::post('get_all_users',       [UserController::class, 'getAllUsers']);
        Route::post('share_recording',     [UserController::class, 'shareRecording']);
        Route::post('get_share_list',      [UserController::class, 'getShareRecordingList']);

        Route::post('create_recording',         [UserController::class, 'createRecording']);
        Route::post('add_highlight',            [UserController::class, 'addHighlight']);
        Route::post('update_recording',         [UserController::class, 'updateRecording']);
        Route::post('delete_recording',         [UserController::class, 'deleteRecording']);
        Route::post('add_recording_note',       [UserController::class, 'addRecordingNote']);
        Route::post('delete_recording_notes',   [UserController::class, 'deleteRecordingNotes']);
        Route::post('get_all_recording',        [UserController::class, 'getAllRecording']);
        Route::post('get_recording_detail',     [UserController::class, 'getRecordingDetails']);

        Route::post('create_folder',            [UserController::class, 'createfolder']);
        Route::post('move_recording',           [UserController::class, 'moveRecording']);
        Route::post('delete_folder',            [UserController::class, 'deleteFolder']);
        Route::post('edit_folder',              [UserController::class, 'editFolder']);
        Route::post('get_all_folder',           [UserController::class, 'getAllFolder']);
        Route::post('get_folder_detail',        [UserController::class, 'getFolderDetail']);
        Route::post('create_note',              [UserController::class, 'create_note']);

        Route::get('get_chat',                  [UserController::class, 'getSupportChat']);
        Route::post('contact_support',          [UserController::class, 'contactSupport']);
        Route::post('get_user_notifications',   [UserController::class, 'getUserNotifications']);

        Route::post('purchase_subscription',    [SubscriptionController::class, 'purchaseSubscription']);

        // setting security
        Route::post('setting_security_edit',       [AuthController::class, 'settinSecurityEdit']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
