<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\FolderFiles;
use App\Models\Recording;
use App\Models\RecordingHighlight;
use App\Models\RecordingNote;
use App\Models\ShareRecording;
use App\Models\Support;
use App\Models\SupportChat;
use App\Models\User;
use App\Models\UserNotification;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Jobs\ProcessTranscription;


class UserController extends Controller
{
    public function createRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'           => 'required',
            'recording_name' => 'required|unique:recordings,recording_name,',
            "duration"       => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $recording = new Recording();
        if ($request->file) {
            $file = $request->file('file');
            $name = time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('recordings'), $name);
            $recording->recording = $name;
        }
        $recording->user_id           = Auth::id();
        $recording->duration          = $request->duration;
        $recording->transcription_box = $request->transcription_box ?? null;
        $recording->recording_name    = $request->recording_name;
        $recording->save();

        ProcessTranscription::dispatch($recording->id);

        return successRes(200, 'Recording created successfully!', $recording);
    }

    public function addHighlight(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'recording_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $recordingCheck = Recording::find($request->recording_id);

        if (!$recordingCheck) {
            return errorRes(400, 'Recording not found');
        }
        $data = array();
        foreach ($request->data as $key => $value) {
            $recording = new RecordingHighlight();
            if (isset($value['file'])) {
                $file = $value['file'];
                $name = rand() . "." . $file->getClientOriginalExtension();
                $file->move(public_path('recording_highlights'), $name);
                $recording->file      = $name;
            }
            $recording->user_id       = Auth::id();
            $recording->recording_id  = $request->recording_id;
            if (isset($value['highlight'])) {
                $recording->highlight     = $value['highlight'];
            }
            if (isset($value['time'])) {
                $recording->time          = $value['time'];
            }
            if (isset($value['start_time'])) {
                $recording->start_time          = $value['start_time'];
            }

            $recording->save();
            $data[] = $recording;
        }

        return successRes(200, 'Highlights added successfully!', $data);
    }
    public function create_note(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'recording_highlight_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $recordingCheck = RecordingHighlight::where('id', $request->recording_highlight_id)->first();

        if (!$recordingCheck) {
            return errorRes(400, 'Recording highlight not found');
        }

        $recordingCheck->note = $request->note;
        $recordingCheck->save();

        return successRes(200, 'Highlights note added successfully!', $recordingCheck);
    }
    public function updateRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recording_id'      => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $recording = Recording::where(['id' => $request->recording_id, 'user_id' => Auth::id()])->first();
        if ($recording) {
            $recording->transcription_box = $request->transcription_box;
            if (isset($request->recording_name)) {
                $nameCheck = Recording::where(['recording_name' => $request->recording_name])->first();
                if ($nameCheck) {
                    return errorRes(400, "The recording name has already been taken.");
                }
                $recording->recording_name    = $request->recording_name;
            }
            $recording->highlight         = $request->highlight;
            $recording->save();

            return successRes(200, 'Successfully updated Recording details!', $recording);
        }
        return errorRes(400, 'Recording not found');
    }

    public function deleteRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recording_id' => 'required',
            'type'         => 'required'
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $recordingIds   = explode(',', $request->recording_id);
        $recordingCount = count($recordingIds);
        $pluralSuffix   = $recordingCount > 1 ? 's' : '';

        if ($request->type == 1) {

            FolderFiles::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            $message = "Successfully remove {$recordingCount} recording{$pluralSuffix}.";
        } elseif ($request->type == 2) {

            RecordingHighlight::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            $message = "Successfully deleted {$recordingCount} recording highlight{$pluralSuffix}.";
        } elseif ($request->type == 3) {

            RecordingNote::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            $message = "Successfully deleted {$recordingCount} recording note{$pluralSuffix}.";
        } else {
            $record = Recording::where('user_id', Auth::id())->whereIn('id', $recordingIds)->first();
            $filePath = public_path('recordings/' . $record->recording);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            RecordingHighlight::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            RecordingNote::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            FolderFiles::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            ShareRecording::where('user_id', Auth::id())->whereIn('recording_id', $recordingIds)->delete();
            Recording::where('user_id', Auth::id())->whereIn('id', $recordingIds)->delete();

            $message = "Successfully deleted {$recordingCount} recording{$pluralSuffix}.";
        }
        return successRes(200, $message);
    }

    public function addRecordingNote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recording_id'      => 'required',
            // 'note'              => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $recording = Recording::where(['id' => $request->recording_id])->first();
        if ($recording) {
            $note               = new RecordingNote;
            $note->recording_id = $request->recording_id;
            $note->user_id      = Auth::id();
            $note->note         = $request->note;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('notes'), $name);
                $note->file = $name;
            }

            $note->save();
            return successRes(200, 'Successfully add recording note!', $note);
        }
        return errorRes(400, 'Recording not found');
    }

    public function deleteRecordingNotes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recording_id'      => 'required'
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $deletedCount = RecordingNote::where('user_id', Auth::id())->where('recording_id', $request->recording_id)->delete();

        // Check if any records were deleted
        if ($deletedCount > 0) {
            return successRes(200, "Successfully deleted $deletedCount Record Note(s)"); // Custom success handler
        }
        return errorRes(400, "No Record Notes found for the given ID");
    }

    public function createFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_name'           => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $folder = new Folder();

        if ($request->hasFile('folder_image')) {
            $file = $request->file('folder_image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('folder_image'), $name);
            $folder->folder_image = $name;
        }

        $folder->user_id     = Auth::id();
        $folder->folder_name = $request->folder_name;
        $folder->save();

        return successRes(200, 'Folder created successfully!', $folder);
    }

    public function moveRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_id'    => 'required',
            'recording_id' => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $folderCheck = Folder::where('user_id', Auth::id())
            ->where('id', $request->folder_id)
            ->first();
        if ($folderCheck) {
            $fileIds         = explode(',', $request->recording_id);
            $folderFilesData = array();
            foreach ($fileIds as $value) {
                $folderFiles = new FolderFiles();
                $folderFiles->user_id       = Auth::id();
                $folderFiles->folder_id     = $request->folder_id;
                $folderFiles->recording_id  = $value;
                $folderFiles->save();
                $folderFilesData[] = $folderFiles;
            }

            $fileCount    = count($fileIds);
            $pluralSuffix = $fileCount > 1 ? 's' : '';

            $message = "Successfully added {$fileCount} file{$pluralSuffix}.";
            return successRes(200, $message, $folderFilesData);
        }
        return errorRes(400, "Folder not found");
    }

    public function deleteFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required'
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $folder = Folder::where('user_id', Auth::id())
            ->where('id', $request->folder_id)
            ->first();

        if ($folder) {
            FolderFiles::where('user_id', Auth::id())
                ->where('folder_id', $request->folder_id)
                ->delete();

            $folder->delete();
            return successRes(200, "Successfully deleted Folder");
        }
        return errorRes(400, "Folder not found");
    }

    public function editFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $folder = Folder::where('user_id', Auth::id())
            ->where('id', $request->folder_id)
            ->first();
        if ($folder) {
            $folder->folder_name = $request->folder_name;
            if ($request->hasFile('folder_image')) {
                $file = $request->file('folder_image');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('folder_image'), $name);
                $folder->folder_image = $name;
            }
            $folder->save();
            return successRes(200, "Successfully edit Folder", $folder);
        }
        return errorRes(400, "Folder not found");
    }

    public function getAllRecording(Request $request)
    {
        $query = Recording::with('notes')->where('user_id', Auth::id());
        // $filter = $request->filter;
        // if ($filter) {
        //     if ($filter == 'yesterday') {
        //         $query->whereDate('created_at', now()->subDay());
        //     } elseif ($filter == 'last_7_days') {
        //         $query->where('created_at', '>', now()->subDays(7));
        //     } elseif ($filter == 'last_month') {
        //         $query->where('created_at', '>', now()->subMonth());
        //     } elseif ($filter == 'newest_to_oldest') {
        //         $query->latest();
        //     } elseif ($filter == 'oldest_to_newest') {
        //         $query->oldest();
        //     }
        // }

        if ($request->has('period')) {
            $period = $request->period;
            if ($period === 'yesterday') {
                $query->whereDate('created_at', now()->subDay());
            } elseif ($period === 'last_7_days') {
                $query->where('created_at', '>', now()->subDays(7));
            } elseif ($period === 'last_month') {
                $query->where('created_at', '>', now()->subMonth());
            }
        }

        // Order filter (asc, desc)
        if ($request->has('sortType')) {
            $order = $request->sortType;
            if ($order === 'asc') {
                $query->oldest(); // Oldest to newest
            } elseif ($order === 'desc') {
                $query->latest(); // Newest to oldest
            }
        }


        $recordings = $query->get()->each(function ($recording) {
            $recording->recording_id = $recording->id;
        });

        if ($recordings->isNotEmpty()) {
            return successRes(200, "Successfully retrieved all recordings", $recordings);
        }
        return errorRes(200, 'No recordings found');
    }

    public function getAllFolder(Request $request)
    {
        $query  = Folder::with('user_detail', 'folder_recordings')->where('user_id', Auth::id());
        $type   = $request->type;
        $filter = $request->data;

        if ($type) {
            if ($type == 'by_size') {
                $query->take($filter);
            } elseif ($type == 'by_date') {
                $query->whereDate('created_at', $filter);
            } elseif ($type == 'by_name') {
                $query->where('folder_name', 'like', '%' . $filter . '%');
            } elseif ($type == 'by_ascending') {
                $query->orderBy('id', 'asc');
            } elseif ($type == 'by_descending') {
                $query->orderBy('id', 'desc');
            }
        }
        $folders = $query->get();

        if ($folders->isNotEmpty()) {
            return successRes(200, "Successfully retrieved all folders", $folders);
        }
        return errorRes(200, 'No folders found');
    }

    public function getFolderDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $folder = Folder::with('user_detail', 'folder_detail.recordings.notes_detail')->where('id', $request->folder_id)->first();
        if ($folder) {
            return successRes(200, "Successfully featched Folder", $folder);
        }
        return errorRes(200, "Folder not found");
    }

    public function contactSupport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $user = User::find(Auth::id());

        if (!$user) {
            return errorRes(400, "User not found");
        }

        $support = Support::where('user_id', Auth::id())->first();

        if (!$support) {
            $support = Support::create(['user_id' => Auth::id()]);
        }
        $admin = User::where('role', 0)->first();
        $message = SupportChat::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $admin->id,
            'support_id'  => $support->id,
            'message'     => $request->message,
        ]);

        $support->update(['status' => 1]);

        return successRes(200, "Successfully send message", $message);
    }

    public function getUserNotifications(Request $request)
    {
        $notifications = UserNotification::where(['status' => 1, 'receiver_id' => Auth::id()])->orderBy('created_at', 'desc')->get();
        if ($notifications->isNotEmpty()) {
            return successRes(200, "Successfully fetched notifications", $notifications);
        }
        return errorRes(200, "User notifications not found");
    }

    public function editUserNotification(Request $request){
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $notification = UserNotification::where(['id' => $request->notification_id, 'receiver_id' => Auth::id()])->first();
        if($notification){
            $notification->type = '2';
            $notification->save();
            return successRes(200, "Successfully edit notification", $notification);
        }
        return errorRes(400, "Folder not found");
    }

    public function deleteUserNotification(Request $request){
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required'
        ]);
        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $notification = UserNotification::where(['id' => $request->notification_id, 'receiver_id' => Auth::id()])->delete();
        return successRes(200, $notification);
    }

    public function getRecordingDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recording_id' => 'required',
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }
        $recording = Recording::with(['notes.user', 'user_detail'])->where('id', $request->recording_id)->first();
        if (!$recording) {
            return errorRes(400, 'Recording not found');
        }

        if(!isset($recording->recording)){
            return errorRes(400, 'Recording file not found');
        }

        // $recording['converted_url']        = $this->convertHighlightsToMp3($recording->id, 1);
        $recording['recording_highlights'] = $this->convertHighlightsToMp3($recording->id, 2);

        return successRes(200, 'Recording details retrieved successfully', $recording);
    }

    public function getAllUsers(Request $request)
    {
        $query  = User::where(['status' => 1, 'role' => 1]);
        $search = $request->search;

        if ($search) {
            $query->where('email', 'like', '%' . $search . '%');
        }
        $users = $query->get();

        $fileCount    = count($users);
        $pluralSuffix = $fileCount > 1 ? 's' : '';

        if ($users->isNotEmpty()) {
            return successRes(200, "Successfully fetched {$fileCount} user{$pluralSuffix}.", $users);
        }
        return errorRes(200, "Users not found");
    }

    public function shareRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rec_id'                        => 'required',
            'share_user_list'               => 'required|array',
            'share_user_list.*.receiver_id' => 'required',
            'share_user_list.*.type'        => 'required'
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $userId    = Auth::id();
        $shareType = ($request->rec_type == 1) ? 'recording_id' : 'highlight_id';
        $msg       = ($request->rec_type == 1) ? "Recording" : "Recording Highlight";

        $sharedRecord = ShareRecording::where('user_id', $userId)
            ->where($shareType, $request->rec_id)->exists();

        if (!$sharedRecord) {
            $record = ($request->rec_type == 1) ? Recording::find($request->rec_id) : RecordingHighlight::find($request->rec_id);
            if ($record) {
                $successfulShares = 0;

                foreach ($request->share_user_list as $receiver) {

                    $share              = new ShareRecording;
                    $share->user_id     = Auth::id();
                    $share->receiver_id = $receiver['receiver_id'];
                    $share->status      = $receiver['type'];
                    $share->{$request->rec_type == 1 ? 'recording_id' : 'highlight_id'} = $request->rec_id;
                    $share->save();
                    $successfulShares++;
                }
                return successRes(200, "Successfully Share {$msg} for {$successfulShares} Users");
            }
            return errorRes(200, "{$msg} not found");
        }
        return errorRes(409, "This {$msg} is already shared by the same user");
    }

    public function getShareRecordingList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'  => 'required|in:1,2'
        ]);

        if ($validator->fails()) {
            return errorHandle($validator);
        }

        $query = ShareRecording::where('receiver_id', Auth::id());
        if ($request->type == 1) {
            $query->with(['sender_detail', 'recording_detail'])->whereNotNull('recording_id');
        } else {
            $query->with(['sender_detail', 'recording_highlight_detail'])->whereNotNull('highlight_id');
        }

        $msg = ($request->type == 1) ? "Recording" : "Recording Highlight";

        $data = $query->get();

        $recordCount = $data->count();
        $pluralSuffix = $recordCount !== 1 ? 's' : '';

        if ($recordCount > 0) {
            foreach ($data as $key => $value) {
                if ($request->type == 2 && isset($value['recording_highlight_detail']['id'])) {
                    $value['recording_highlight_detail']['converted_url']  = $this->convertToMp3($value['recording_highlight_detail']['id'], 2);
                }
                if ($request->type == 1  && isset($value['recording_detail']['id'])) {
                    $value['recording_detail']['converted_url']  = $this->convertToMp3($value['recording_detail']['id'], 1);
                }
            }
            return successRes(200, "Successfully fetched {$recordCount} {$msg}{$pluralSuffix}.", $data);
        }
        return errorRes(200, "{$msg} not found");
    }

    public function convertToMp3($id = false, $type = false)
    {
        $highlightUrls = [];
        $mp3Format = new Mp3();
        if ($type == 2 && $id) {
            $highlight = RecordingHighlight::find($id);
            $audioFilePath = public_path('recording_highlights/') . $highlight->file;

            if (!$highlight) {
                return $highlightUrls;
            }

            if (File::exists($audioFilePath)) {
                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries'  => env('FFMPEG_BINARY'),
                    'ffprobe.binaries' => env('FFPROBE_BINARY'),
                ]);
                $convertedFileName = $highlight->file . '.mp3';
                $convertedFilePath = public_path('recording_highlights/') . $convertedFileName;

                $audio = $ffmpeg->open($audioFilePath);
                $audio->save($mp3Format, $convertedFilePath);

                $highlightUrls['mp3'] = File::exists($convertedFilePath) ? asset('recording_highlights/' . $convertedFileName) : '';
            }
            return $highlightUrls;
        }
        if ($type == 1 && $id) {
            $highlight = Recording::find($id);

            if (!$highlight) {
                return $highlightUrls;
            }

            $audioFilePath = public_path('recordings/') . $highlight->recording;
            if (File::exists($audioFilePath)) {
                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries'  => env('FFMPEG_BINARY'),
                    'ffprobe.binaries' => env('FFPROBE_BINARY'),
                ]);

                $convertedFileName = $highlight->recording . '.mp3';
                $convertedFilePath = public_path('recordings/') . $convertedFileName;

                $audio = $ffmpeg->open($audioFilePath);
                // $mp3Format = new Mp3();
                $audio->save($mp3Format, $convertedFilePath);

                $highlightUrls['mp3'] = File::exists($convertedFilePath) ? asset('recordings/' . $convertedFileName) : '';
            }
            return $highlightUrls;
        }
    }

    public function getSupportChat(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return errorRes(200, "User not found");
        }

        $support = Support::where('user_id', Auth::id())->first();
        if (!$support) {
            return errorRes(200, "Chat Not Found");
        }

        $data = SupportChat::where('support_id', $support->id)->get();

        if (!$data) {
            return errorRes(200, "Support Chat Not Found");
        }

        return successRes(200, "Successfully retrieved chat", $data);
    }

    public function convertHighlightsToMp3($id = false, $type = false)
    {
        if ($type == 2 && $id) {
            $highlights = RecordingHighlight::where('recording_id', $id)->get();
            $convertedUrls = [];

            // foreach ($highlights as $highlight) {
            //     $audioFilePath = public_path('recording_highlights/') . $highlight->file;
            //     $supportedFormats = ['wav', 'aac', 'ogg']; // Example of supported formats

            //     $highlightUrls = [];
            //     if (File::exists($audioFilePath)) {
            //         $ffmpeg = FFMpeg::create();

            //         foreach ($supportedFormats as $format) {
            //             $convertedFileName = $highlight->file . '_' . $format . '.mp3';
            //             $convertedFilePath = public_path('recording_highlights/') . $convertedFileName;

            //             // Convert to MP3 format
            //             $audio = $ffmpeg->open($audioFilePath);
            //             $mp3Format = new Mp3();
            //             $audio->save($mp3Format, $convertedFilePath);

            //             $highlightUrls[$format] = File::exists($convertedFilePath) ? asset('recording_highlights/' . $convertedFileName) : '';
            //         }
            //     }

            //     $highlight->urls = $highlightUrls;
            //     $convertedUrls[] = $highlight;
            // }

            return $highlights;
        } else {
            $recording = Recording::find($id);
            if (!$recording) {
                return [];
            }

            $audioFilePath = public_path('recordings/') . $recording->recording;
            $supportedFormats = ['wav', 'aac', 'ogg']; // Example of supported formats
            $convertedUrl = [];
            if (File::exists($audioFilePath)) {
                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries'  => 'D:\Work\Real_Project\key-notes-backend\storage\ffmpeg\bin\ffmpeg.exe',
                    'ffprobe.binaries' => 'D:\Work\Real_Project\key-notes-backend\storage\ffmpeg\bin\ffprobe.exe',
                ]);

                foreach ($supportedFormats as $format) {
                    $convertedFileName = $recording->recording . '_' . $format . '.mp3';
                    $convertedFilePath = public_path('recordings/') . $convertedFileName;

                    // Convert to MP3 format
                    $audio = $ffmpeg->open($audioFilePath);
                    $mp3Format = new Mp3();
                    $audio->save($mp3Format, $convertedFilePath);

                    $convertedUrl[$format] = File::exists($convertedFilePath) ? asset('recordings/' . $convertedFileName) : '';
                }
            }
            return $convertedUrl;
        }
    }

}
