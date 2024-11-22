<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\File;
use FFMpeg\Format\Audio\Mp3;

class Recording extends Model
{
    use HasFactory;

    public function notes()
    {
        return $this->hasMany(RecordingNote::class);
    }
    public function notes_detail()
    {
        return $this->hasMany(RecordingNote::class, "recording_id");
    }
    public function recording_highlights()
    {
        return $this->hasMany(RecordingHighlight::class, "recording_id");
    }
    public function user_detail()
    {
        return $this->belongsTo(User::class ,'user_id');
    }
}
