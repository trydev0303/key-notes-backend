<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Recording;
use App\Models\Folder;
use App\Models\FolderFiles;
use App\Models\SupportChat;
use App\Models\Support;
use App\Models\UserNotification;

use App\Models\Notification;
use App\Models\RecordingHighlight;
use App\Models\RecordingNote;
use App\Models\ShareRecording;

class AuthController extends Controller
{
    public function sign_up(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'   => 'required',
            'last_name'    => 'required',
            'email'        => 'required',
            'password'     => 'required',
            'device_type'  => 'required',
            'device_token' => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $usercheck = User::where('email', $request->email)->first();
        $otp = mt_rand(1000, 9999);
        if ($usercheck) {
            if ($usercheck->is_verified == 0) {
                $usercheck->first_name    = $request->first_name;
                $usercheck->last_name     = $request->last_name;
                $usercheck->device_type   = $request->device_type;
                $usercheck->device_token  = $request->device_token;
                $usercheck->device_model  = $request->device_model;
                $usercheck->otp           = $otp;
                $usercheck->save();

                $userName = $request->get('first_name');
                $html     =  view('templates.emails.welcome', compact('otp', 'userName'))->render();
                $subject  = 'Key-Notes OTP!';
                sendEmail($request->get('email'), $subject, $html);
                return successRes(200, 'User register successfully!', $usercheck);
            } else {
                return errorRes(400, 'The email has already been taken.');
            }
        } else {
            $user = new User();
            $user->first_name    = $request->first_name;
            $user->last_name     = $request->last_name;
            $user->email         = $request->email;
            $user->password      = Hash::make($request->password);
            $user->role          = 1;
            $user->otp           = $otp;
            $user->device_type   = $request->device_type;
            $user->device_token  = $request->device_token;


            if (isset($request->device_model)) {
                $user->device_model  = $request->device_model;
            }

            if ($request->profile_image) {
                $file = $request->file('profile_image');
                $name = time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $name);

                $user->profile_image = $name;
            }else{
                $user->profile_image  = 'user_default.jpg';
            }

            $userName = $request->get('first_name');
            $html     =  view('templates.emails.welcome', compact('otp', 'userName'))->render();
            $subject  = 'Key-Notes OTP!';
            sendEmail($request->get('email'), $subject, $html);

            $user->save();
            return successRes(200, 'User register successfully!', $user);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp'   => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $check_user  = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if ($check_user) {
            $now = now();
            $accessToken = $check_user->createToken('authToken')->accessToken;
            $update      =  User::where('email', $request->email)->update(['is_verified' => 1, 'email_verified_at' => $now, 'otp' => null, 'remember_token' => $accessToken]);
            $user        =  User::find($check_user->id);
            $user['token'] = $accessToken;

            return successRes(200, 'OTP verified successfully!', $user);
        } else {
            return errorRes(400, 'Invalid OTP');
        }
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $otp = mt_rand(1000, 9999);
        $user = User::where('email', $request->email)->update(['otp' => $otp]);
        if ($user) {

            $userData = User::where('email', $request->email)->first();
            $userName = $userData->first_name;
            $html     =  view('templates.emails.resend_otp', compact('otp', 'userName'))->render();
            $subject  = 'Key-Notes Resend OTP!';
            sendEmail($request->get('email'), $subject, $html);

            return successRes(200, 'OTP resend successfully!', $otp);
        } else {
            return errorRes(400, 'Email does not exist!');
        }
    }

    public function pushNotify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $user = User::where('email', $request->email)->update(['is_notify' => 1]);
        if ($user) {
            return successRes(200, 'push notification successfully!', $user);
        } else {
            return errorRes(400, 'Email does not exist!');
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'        => 'required',
            'password'     => 'required',
            'device_type'  => 'required',
            'device_token' => 'required',
            'device_model' => 'required',
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user_detail = User::where('email', $request->email)->first();

            // if ($user_detail->status != 1) {
            //     return errorRes(400, 'Your Account has been deactivated by admin!');
            // }

            if ($user_detail->status == 2) {
                return errorRes(510, 'Sorry, Your Account has been suspended by admin!');
            }

            if ($user_detail->status == 3) {
                return errorRes(510, 'Sorry, Your Account has been deactivate by admin!');
            }

            if ($user_detail->is_verified == 1) {

                $user_detail->login_type = 2;

                $user_detail->device_type  = $request->device_type;
                $user_detail->device_token = $request->device_token;
                $user_detail->device_model = $request->device_model;
                $user_detail->country = $request->country;
                $user_detail->location = $request->location;
                $user_detail->is_online    = 1;
                $user_detail->last_login   =  now();
                $user_detail->save();

                $token = $user_detail->createToken('authToken')->accessToken;
                $user_detail->remember_token = $token;
                $user_detail->save();

                $user_detail        = User::where('email', $request->email)->first();
                $user_detail->token = $token;

                return successRes(200, 'User Login Successfully', $user_detail);
            } else {
                $otp = rand(1000, 9999);
                $user_detail->otp          = $otp;
                $user_detail->device_type  = $request->device_type;
                $user_detail->device_token = $request->device_token;
                $user_detail->device_model = $request->device_model;
                $user_detail->save();

                $userName = $user_detail->first_name;
                $html     =  view('templates.emails.resend_otp', compact('otp', 'userName'))->render();
                $subject  = 'Key-Notes OTP!';
                sendEmail($request->get('email'), $subject, $html);

                return errorRes(201, 'Please verify your account before login!', $user_detail);
            }
        } else {
            return errorRes(400, 'Invalid Credentials');
        }
    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required',
            // 'last_name'     => 'required',
            'email'        => 'required',
            'device_type'  => 'required',
            'device_token' => 'required',
            'device_model' => 'required',
            'social_login_type' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $user_detail = User::where('email', $request->email)->first();
        if ($user_detail) {

            // if ($user_detail->status != 1) {
            //     return errorRes(400, 'Your Account has been deactivated by admin!');
            // }

            if ($user_detail->status == 2) {
                return errorRes(510, 'Sorry, Your Account has been suspended by admin!');
            }

            if ($user_detail->status == 3) {
                return errorRes(510, 'Sorry, Your Account has been deactivate by admin!');
            }
            $user_detail->login_type = 1;
            $user_detail->is_verified = 1;
            $user_detail->social_login_type = $request->social_login_type;

            $user_detail->device_type  = $request->device_type;
            $user_detail->device_token = $request->device_token;
            $user_detail->device_model = $request->device_model;
            $user_detail->country = $request->country;
            $user_detail->location = $request->location;
            $user_detail->is_online    = 1;
            $user_detail->last_login   =  now();
            $user_detail->save();

            $token = $user_detail->createToken('authToken')->accessToken;
            $user_detail->remember_token = $token;
            $user_detail->save();

            $user_detail        = User::where('email', $request->email)->first();
            $user_detail->token = $token;

            return successRes(200, 'User Login Successfully', $user_detail);
        } else {
            $user = new User();
            $user->first_name    = $request->first_name;
            $user->last_name     = $request->last_name;
            $user->email         = $request->email;
            $user->is_verified = 1;
            $user->role          = 1;
            $user->login_type    = 1;
            $user->email_verified_at = now();
            $user->country = $request->country;
            $user->location = $request->location;
            $user->social_login_type = $request->social_login_type;
            $user->device_type   = $request->device_type;
            $user->device_token  = $request->device_token;
            $user->device_model  =  $request->device_model;
            $user->is_online     =  1;
            $user->profile_image = 'user_default.jpg';
            $user->last_login   =  now();
            $user->save();

            $token = $user->createToken('authToken')->accessToken;
            $user->remember_token = $token;
            $user->save();

            $user        = User::where('email', $request->email)->first();
            $user->token = $token;

            return successRes(200, 'User Login Successfully', $user);
        }
    }

    public function getProfile(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user) {
            return successRes(200, 'User profile fetched successfully', $user);
        } else {
            return errorRes(404, 'User not found');
        }
    }

    public function editProfile(Request $request)
    {
        $user = User::where("id", Auth::id())->first();
        if ($user) {
            if (isset($request->first_name)) {
                $user->first_name = $request->first_name;
            }
            if (isset($request->last_name)) {
                $user->last_name = $request->last_name;
            }
            if (isset($request->phone)) {
                $user->phone = $request->phone;
            }
            if (isset($request->date_of_birth)) {
                $user->date_of_birth = $request->date_of_birth;
            }
            if (isset($request->short_bio)) {
                $user->short_bio = $request->short_bio;
            }
            if (isset($request->email)) {
                $check = User::where("email", $request->email)->first();
                if ($check) {
                    return errorRes(400, 'Email already exist');
                }
                $user->email = $request->email;
            }

            if (isset($request->profile_image)) {
                $file = $request->file('profile_image');
                $name = time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $name);
                $user->profile_image = $name;
            }
            $user->save();
            return successRes(200, 'Profile edit successfully', $user);
        } else {
            return errorRes(404, 'User not found');
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $check = Hash::check($request->old_password, Auth::user()->password);
        if ($check) {
            $user = User::where('id', Auth::id())->first();
            $user->password = bcrypt($request->new_password);
            $user->save();
            return successRes(200, 'Password saved successfully', $user);
        } else {
            return errorRes(400, 'Incorrect old password');
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $otp = mt_rand(1000, 9999);
        $user = User::where('email', '=', $request->email)->update(['otp' => $otp]);
        if ($user) {
            $user = User::firstWhere('email', '=', $request->email);

            $userName = $user->first_name;
            $html     = view('templates.emails.forgot_password', compact('otp', 'userName'))->render();
            $subject  = 'Key-Notes Forgot OTP!';
            sendEmail($request->get('email'), $subject, $html);

            return successRes(200, 'OTP sent successfully!', $user);
        } else {
            return errorRes(400, 'Email does not exist!');
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'            => 'required',
            'password'         => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $user  = User::where('email', $request->email)->first();
        if ($user) {
            $password           = $request->get('password');
            $user               = User::where('email', $request->email)->first();
            $user->password     = bcrypt($password);
            $user->save();

            return successRes(200, 'Password saved successfully!', $user);
        } else {
            return errorRes(400, 'Email does not exist!');
        }
    }

    public function logout(Request $request)
    {
        $device_token_null   = User::where('id', Auth::id())->update([
            'remember_token' => null,
            'is_online'      => 0
        ]);
        $token = $request->user()->token();
        $token->revoke();

        $user = User::where('id', Auth::id())->first();

        return successRes(200, 'You have been successfully logged out!', $user);
    }

    public function deleteAccount(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);

        if ($user) {
            Recording::where('user_id', $userId)->delete();
            FolderFiles::where('user_id', $userId)->delete();
            Folder::where('user_id', $userId)->delete();
            UserNotification::where('receiver_id', $userId)->delete();
            RecordingHighlight::where('user_id', $userId)->delete();
            RecordingNote::where('user_id', $userId)->delete();
            ShareRecording::where('user_id', $userId)->delete();
            Notification::where('user_id', $userId)->delete();

            $support = Support::where('user_id', $userId)->first();
            if ($support) {
                SupportChat::where('support_id', $support->id)->delete();
                $support->delete();
            }
            $user->delete();
            return successRes(200, 'Account successfully deleted!');
        } else {
            return errorRes(200, 'User not found');
        }
    }

    public function settinSecurityEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $user = User::find(Auth::id());
        if ($user) {
            if($request->type == 'face_id'){
                $user->is_face_id = $request->value;
            }
            if($request->type == 'remember_me'){
                $user->is_remember = $request->value;
            }
            if($request->type == 'touch_id'){
                $user->is_touch_id = $request->value;
            }
            if($request->type == 'notification_preference'){
                $user->is_notify = $request->value;
            }
            if($request->type == 'email_notification'){
                $user->is_email_notify = $request->value;
            }
            $user->save();
            return successRes(200, 'Success!', $user);
        } else {
            return errorRes(400, 'User not found!');
        }
    }
}
