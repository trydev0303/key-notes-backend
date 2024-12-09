<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Support;
use App\Models\SupportChat;
use App\Models\Folder;
use App\Models\FolderFiles;
use App\Models\Recording;
use App\Models\Notification;
use App\Models\UserNotification;
use App\Models\RecordingHighlight;
use App\Models\RecordingNote;
use App\Models\ShareRecording;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  public function dashboard(Request $request)
  {
    $allUsers        = User::where('role', 1)->count();
    $paidUsers       = 0;

    $allActiveUsers = User::where(['role' => 1, 'status' => 1])->count();
    $allInactiveUsers = User::where('role', 1)->whereIn('status', [2, 3])->count();

    $paidSubscribers  = 0;
    $freeSubscribers  = User::where(['role' => 1])->count();



    return view('admin/dashboard/dashboard', compact('freeSubscribers', 'paidSubscribers', 'allUsers', 'paidUsers', 'allActiveUsers', 'allInactiveUsers'));
  }

  public function allUser(Request $request)
  {

    $allUsers = User::where('role', 1)->where('is_verified', 1)->orderBy('id', 'desc')->get();
    return view('admin/user_management/user', compact('allUsers'));
  }

  public function changePasswordView(Request $request)
  {
    return view('admin/change-password');
  }

  public function userDetailView(Request $request)
  {
    $user = User::find($request->id);
    return view('admin/user_management/user_details_edit', compact('user'));
  }

  public function profileUpdate(Request $request)
  {

    $user_update = User::find($request->user_id);

    if (!$user_update) {
      return back()->with('error', 'User not found');
    }

    if ($request->type == 1) {
      $user_update->first_name = $request->first_name;
      $user_update->email      = $request->email;
      $user_update->last_name  = $request->last_name ?? null;
      $user_update->status     = $request->status;

      if ($request->file('profile_image')) {
        $file = $request->file('profile_image');
        $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
        $file->move("uploads", $name);
        $user_update->profile_image = $name;
      }
      $user_update->save();
      return redirect(route('all.user'))->with('success', 'Profile updated Successfully');

    } else {
      $request->validate([
        'password'         => 'required',
        'confirm_password' => 'required|same:password',
      ]);
      $user_update->update(['password' => bcrypt($request->password)]);
      return back()->with('success', 'Successfully updated password');
    }
  }

  public function changePassword(Request $request)
  {
    $request->validate([
      'old_password'     => 'required',
      'password'         => 'required',
      'confirm_password' => 'required|same:password',
    ]);

    $user = User::find(Auth::id());

    if (!Hash::check($request->old_password, $user->password)) {
      return back()->with('error', 'Old password is entered wrong');
    }

    $user->update(['password' => bcrypt($request->password)]);

    return back()->with('success', 'Password changed successfully.');
  }

  public function export()
  {
    $date = now()->format('d-m-Y_H:i');
    $xlsxFileName = 'users_report_' . $date . '.xlsx';

    return Excel::download(new UsersExport, $xlsxFileName);
  }

  public function addNotification(Request $request)
  {
    $notification              = new Notification;
    $notification->user_id     = Auth::id();
    $notification->title       = $request->title;
    $notification->type        = $request->type;
    $notification->description = $request->description;
    $notification->save();

    // active_user     == 1
    // inactive_user   == 2
    // paid_subcribers == 3
    // free_subcribers == 4

    if ($notification->type == 1) {
      $user = User::where(['role' => 1, 'status' => 1])->get();
    } elseif ($notification->type == 2) {
      $user = User::where(['role' => 1, 'status' => 0])->get();
    } elseif ($notification->type == 3) {
      $user = User::where(['role' => 1, 'status' => 1])->get();
    } elseif ($notification->type == 4) {
      $user = User::where(['role' => 1, 'status' => 1])->get();
    }

    foreach ($user as $key => $value) {
        if($value->is_notify === 1){
            $user_notification               = new UserNotification;
            $user_notification->sender_id    = Auth::id();
            $user_notification->receiver_id  = $value->id;
            $user_notification->title        = $request->title;
            $user_notification->type         = $request->type;
            $user_notification->notification = $request->description;
            $user_notification->save();
        }
        if($value->is_email_notify === 1){
            $userName = $value->first_name;
            $title = $request->title;
            $description = $request->description;
            $html     = view('templates.emails.send_notification', compact('userName', 'title', 'description'))->render();
            $subject  = 'Key-Notes Notification!';
            sendEmail($value->email, $subject, $html);
        }
    }
    return back()->with('success', 'Successfully Add Notification');
  }

  public function deleteNotification(Request $request)
  {
    Notification::find($request->id)->delete();
    return back()->with('success', 'Successfully deleted Notification');
  }

  public function statusChange(Request $request)
  {
    $user = User::find($request->user_id);
    if ($user->status == 1 ||  $user->status == 2 ||  $user->status == 0) {
      $user->status = 3;
    } else {
      $user->status = 1;
    }
    $user->updated_at = now();
    $user->save();
    return response()->json(['status' => $user->status]);
  }

  public function deleteUser(Request $request)
  {
    $user = User::find($request->user_id);

    if ($user) {

      Recording::where('user_id', $request->user_id)->delete();
      FolderFiles::where('user_id', $request->user_id)->delete();
      Folder::where('user_id', $request->user_id)->delete();
      UserNotification::where('receiver_id', $request->user_id)->delete();

      RecordingHighlight::where('user_id', $request->user_id)->delete();
      RecordingNote::where('user_id', $request->user_id)->delete();
      ShareRecording::where('user_id', $request->user_id)->delete();

      $support = Support::where('user_id', $request->user_id)->first();
      if ($support) {
        SupportChat::where('support_id', $support->id)->delete();
        $support->delete();
      }

      $user->delete();

      return redirect()->route('all.user')->with('success', 'Successfully Deleted User');
    } else {
      return redirect()->route('all.user')->with('error', 'User not found');
    }
  }

  public function support(Request $request)
  {
    $allSupport = Support::with('user_detail')->orderBy('created_at', 'desc')->get();
    return view('admin/support', compact('allSupport'));
  }

  public function Notification(Request $request)
  {
    $allNotification = Notification::orderBy('created_at', 'desc')->get();
    return view('admin/notification', compact('allNotification'));
  }

  public function Chat(Request $request)
  {
    $chat = SupportChat::with('user_detail')->where('support_id', $request->id)->get();
    $user_id = $request->user_id;
    $support_id = $request->id;
    return view('admin/user_management/chat', compact('chat', 'support_id', 'user_id'));
  }

  public function sendMessage(Request $request)
  {
    $support = Support::find(number_format($request->supportId))->first();
    $message = SupportChat::create([
      'sender_id'   => Auth::id(),
      'support_id'  => $request->supportId,
      'receiver_id' => $request->user_id,
      'message'     => $request->message,
    ]);
    $support->update(['status' => 1]);
    return response()->json(["status" => 200, "message" => $request->message]);
  }

  public function supportChangeStatus(Request $request)
  {
    $support = Support::find($request->support_id);
    $support->status = $support->status == 1 ? 2 : 1;
    $support->save();
    return response()->json(['status' => $support->status]);
  }

}
