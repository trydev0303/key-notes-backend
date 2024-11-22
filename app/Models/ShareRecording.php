<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareRecording extends Model
{
    use HasFactory;
    public function recording_detail()
    {
        return $this->belongsTo(Recording::class, "recording_id");
    }
   
    public function user_detail()
    {
        return $this->belongsTo(User::class, "receiver_id");
    }
    public function sender_detail() 
    {
        return $this->belongsTo(User::class, "user_id");
    }  
   
    public function recording_highlight_detail()
    {
        return $this->belongsTo(RecordingHighlight::class, "highlight_id");
    }
}
