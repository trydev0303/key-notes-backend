<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/ruf', function () {
    return view('testing');
});

Route::get('/', function () {
    return view('auth/login');
});




Route::get('terms_conditions', function(){
    return view('terms_conditions');
});
Route::group(array('prefix' => "admin/"), function () {
    Route::group(['middleware' => 'auth:web'], function () {
    Route::get('dashboard',                       [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('all/user',                        [AdminController::class, 'allUser'])->name('all.user');
    Route::get('change/password/view',            [AdminController::class, 'changePasswordView']);
    Route::get('export',                          [AdminController::class, 'Export'])->name('export');

    Route::get('user/detail/view/{type}/{id}',    [AdminController::class, 'userDetailView']);
    Route::post('profile/update',                 [AdminController::class, 'profileUpdate'])->name('edit.profile');
    Route::post('change/password',                [AdminController::class, 'changePassword'])->name('change.password');
    Route::post('status/change',                  [AdminController::class, 'statusChange']);
    Route::post('delete/user',                    [AdminController::class, 'deleteUser']);
    Route::get('support',                         [AdminController::class, 'support'])->name('support');
    Route::get('chat/{id}/{user_id}',             [AdminController::class, 'chat']);
    Route::post('send_message',                   [AdminController::class, 'sendMessage'])->name('send.message');
    Route::post('support_change_status',          [AdminController::class, 'supportChangeStatus'])->name('support.change.status');

    Route::get('notification',                    [AdminController::class, 'Notification'])->name('notification');
    Route::post('add_notification',               [AdminController::class, 'addNotification'])->name('add.notification');
    Route::get('delete_notification/{id}',        [AdminController::class, 'deleteNotification'])->name('delete.notification');
    });
});

Auth::routes();
