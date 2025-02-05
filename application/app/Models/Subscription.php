<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    public function podcast()
    {
        return $this->belongsTo(Podcast::class, 'podcast_id', 'id');  
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');  
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }else{
            $html = '<span class="badge badge--warning">'.trans('Inactive').'</span>';
        }

        return $html;
    }
}
