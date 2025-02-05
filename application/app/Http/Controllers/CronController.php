<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function deactivateSubscription()
    {
        $subscriptions = Subscription::orderBy('created_at', 'DESC')->where('expire_date','<', now())->take(100)->get();
        foreach($subscriptions as $item)
        {
            $item->status = 0;
            $item->save();
        }
    }
}
