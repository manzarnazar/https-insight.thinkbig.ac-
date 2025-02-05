<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);  
    }

    public function statusBadge($status){
        $html = '';
        if($this->file_type == 1){
            $html = '<span class="badge badge--success">'.trans('Link').'</span>';
        }else if($this->file_type == 2){
            $html = '<span class="badge badge--primary">'.trans('Audio').'</span>';
        }else if($this->file_type == 3){
            $html = '<span class="badge badge--warning">'.trans('Video').'</span>';
        }

        return $html;
    }
}
