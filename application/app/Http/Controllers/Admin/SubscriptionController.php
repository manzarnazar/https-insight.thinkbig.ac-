<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(){
        $pageTitle = 'Subscription List';
        $subscriptions = Subscription::with('podcast', 'user')->latest()->paginate(getPaginate());
        return view('admin.subscription.list',compact('subscriptions','pageTitle'));
    }
}
