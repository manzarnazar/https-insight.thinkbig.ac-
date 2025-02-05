<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    public function bookmark()
    {
        return $this->belongsTo(Episode::class, 'episode_id', 'id');  
    }
}
