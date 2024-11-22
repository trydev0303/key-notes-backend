<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderFiles extends Model
{
    use HasFactory;
    public function recordings()
    {
        return $this->belongsTo(Recording::class, "recording_id");
    }  
}
