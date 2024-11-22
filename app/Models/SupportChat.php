<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user_detail()
    {
        return $this->belongsTo(User::class ,'sender_id');
    }
}
