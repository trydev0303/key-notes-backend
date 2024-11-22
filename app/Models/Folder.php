<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    public function folder_recordings()
    {
        return $this->hasMany(FolderFiles::class);
    }
    public function user_detail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function folder_detail()
    {
        return $this->hasMany(FolderFiles::class);
    }
}
