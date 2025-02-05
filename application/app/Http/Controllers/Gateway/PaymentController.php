<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Episode;
use App\Models\GatewayCurrency;
use App\Models\Plan;
use App\Models\Podcast;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{

    public function payment($id)
    {

        if(!auth()->check()){
            return to_route('user.login');
        }

        $episode = Episode::findOrFail($id);

        $podcastId = $episode->podcast_id;
        $userId = auth()->user()->id;

        $check = Subscription::where('user_id', $userId)->where('podcast_id', $podcastId)->where('expire_date','<', now())->orderBy('id', 'DESC')->first();

        if($check)
        {
            $notify[] = ['success', 'Already subscribed'];
            return redirect()->route('podcast.details', ['id' => $id])->withNotify($notify);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';

        $balance = auth()->user()->balance;

       $podcast = Podcast::findOrFail($podcastId);

        return view($this->activeTemplate . 'user.payment.payment', compact('gatewayCurrency', 'pageTitle','episode', 'balance', 'podcast'));
    }

    public function podcastSubscriptionPayment($id)
    {
        if(!auth()->check()){
            return to_route('user.login');
        }

        $podcast = Podcast::findOrFail($id);
        $userId = auth()->user()->id;

        $check = Subscription::where('user_id', $userId)->where('podcast_id', $id)->where('expire_date', '>', now())->orderBy('id', 'DESC')->get();

        if($check->count() > 0)
        {
            $notify[] = ['success', 'Already subscribed'];
            return redirect()->back()->withNotify($notify);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';

        $balance = auth()->user()->balance;
        return view($this->activeTemplate . 'user.payment.payment', compact('gatewayCurrency', 'pageTitle','balance', 'podcast'));
    }

    public function subscriptionAmountCalculation(Request $request)
    {
        $subscriptionType   = $request->subscriptionType;
        $podcastId          = $request->podcastId;
        $podcast            = Podcast::findOrFail($podcastId);

        $general = gs();
        $price = '';
        if($subscriptionType == 1){
            $price = $podcast->monthly_price;
            $price = showAmount($price,2);
        }else{
            $price = $podcast->yearly_price;
            $price = showAmount($price,2);
        }
        return Response($price);
    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
            })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Add Balance Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {

        $user = auth()->user();

        if($request->gateway == 'deposit_wallet'){
            $request->validate([
                'amount' => 'required|numeric|gt:0'
            ]);

            $balance = $user->balance;
            if($request->gateway == 'deposit_wallet' && $balance < $request->amount)
            {
                $notify[] = ['error', 'You don\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

        }else{
            $request->validate([
                'amount' => 'required|numeric|gt:0',
                'method_code' => 'required',
                'currency' => 'required',
            ]);
        }

        if($request->id)
        {
            $pocdcast = Podcast::findOrFail($request->id);
            if(!$pocdcast)
            {
                $notify[] = ['error', 'Something went wrong.'];
                return back()->withNotify($notify);
            }


            if($request->subscription_type == 1){
                if($pocdcast->monthly_price != $request->amount )
                {
                    $notify[] = ['error', 'Monthly subscription amount not match'];
                    return back()->withNotify($notify);
                }
            }else if($request->subscription_type == 2){
                if($pocdcast->yearly_price != $request->amount)
                {
                    $notify[] = ['error', 'Yearly subscription amount not match'];
                    return back()->withNotify($notify);
                }
            }


            if($request->gateway == 'deposit_wallet'){

                $subscriptions = new Subscription();
                $subscriptions->user_id = $user->id;
                $subscriptions->podcast_id = $request->id;
                $subscriptions->subscription_type = $request->subscription_type;
                $subscriptions->price = $request->amount;

                if($request->subscription_type == 1)
                {
                    $subscriptions->expire_date = now()->addDays(30);
                }else if($request->subscription_type == 2){
                    $subscriptions->expire_date = now()->addDays(365);
                }

                $subscriptions->details = 'Subscription buy via net balance';
                $subscriptions->status = 1;
                $pocdcast = Podcast::findOrFail($request->id);
                $subscriptions->podcast_title = $pocdcast->title;
                $subscriptions->save();


                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = $request->amount;
                $transaction->post_balance = $user->balance;
                $transaction->subscription_id	 = $subscriptions->id;
                $transaction->charge = 0;
                $transaction->trx_type = '-';
                $transaction->details = 'Subscription buy via net balance';
                $transaction->trx = getTrx();
                $transaction->remark = 'subscription_from_wallet';
                $transaction->save();

                $user->balance = $user->balance-$request->amount;
                $user->save();

                // Podcast creator increment balance
                if($pocdcast)
                {
                    $creatorId = $pocdcast->creator_id;
                    $creator = User::findOrFail($creatorId);
                    $creator->balance = $creator->balance + $request->amount;
                    $creator->save();
                }

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Subscription buy via net balance';
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();

                return to_route('user.home');
            }else{

                $gate = GatewayCurrency::whereHas('method', function ($gate) {
                    $gate->where('status', 1);
                })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
                if (!$gate) {
                    $notify[] = ['error', 'Invalid gateway'];
                    return back()->withNotify($notify);
                }

                if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
                    $notify[] = ['error', 'Please follow deposit limit'];
                    return back()->withNotify($notify);
                }

                $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
                $payable = $request->amount + $charge;
                $final_amo = $payable * $gate->rate;

                $data = new Deposit();
                $data->user_id = $user->id;
                $data->method_code = $gate->method_code;
                $data->method_currency = strtoupper($gate->currency);
                $data->amount = $request->amount;
                $data->charge = $charge;
                $data->rate = $gate->rate;
                $data->final_amo = $final_amo;
                $data->btc_amo = 0;
                $data->btc_wallet = "";
                $data->trx = getTrx();
                $data->try = 0;
                $data->podcast_id = $pocdcast->id;
                $data->subscription_type = $request->subscription_type;
                $data->status = 0;
                $data->save();
                session()->put('Track', $data->trx);
                return to_route('user.deposit.confirm');
            }

        }else{

            $gate = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', 1);
            })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
            if (!$gate) {
                $notify[] = ['error', 'Invalid gateway'];
                return back()->withNotify($notify);
            }

            if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
                $notify[] = ['error', 'Please follow deposit limit'];
                return back()->withNotify($notify);
            }

            $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
            $payable = $request->amount + $charge;
            $final_amo = $payable * $gate->rate;

            $data = new Deposit();
            $data->user_id = $user->id;
            $data->method_code = $gate->method_code;
            $data->method_currency = strtoupper($gate->currency);
            $data->amount = $request->amount;
            $data->charge = $charge;
            $data->rate = $gate->rate;
            $data->final_amo = $final_amo;
            $data->btc_amo = 0;
            $data->btc_wallet = "";
            $data->trx = getTrx();
            $data->try = 0;
            $data->podcast_id = 0;
            $data->subscription_type = 0;
            $data->status = 0;
            $data->save();
            session()->put('Track', $data->trx);
            return to_route('user.deposit.confirm');
        }

    }


    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status',0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit,$isManual = null)
    {
        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;

            if($deposit->podcast_id != 0 || $deposit->subscription_type != 0){

                $podcastId = $deposit->podcast_id;

                $podcast = Podcast::findOrFail($podcastId);
                if($podcast->creator_id != 0){
                    $creator = User::findOrFail($podcast->creator_id);
                    $creator->balance = $creator->balance + $deposit->amount;
                    $creator->save();
                }


                $subscriptions = new Subscription();
                $subscriptions->user_id = $deposit->user_id;
                $subscriptions->podcast_id = $deposit->podcast_id;
                $subscriptions->subscription_type = $deposit->subscription_type;
                $subscriptions->price = $deposit->amount;

                if($deposit->subscription_type == 1)
                {
                    $subscriptions->expire_date = now()->addDays(30);
                }else if($deposit->subscription_type == 2){
                    $subscriptions->expire_date = now()->addDays(365);
                }

                $subscriptions->details = 'Subscription buy via ' . $deposit->gatewayCurrency()->name;
                $subscriptions->status = 1;
                $pocdcast = Podcast::findOrFail($deposit->podcast_id);
                $subscriptions->podcast_title = $pocdcast->title;
                $subscriptions->save();

                $user = User::findOrFail($deposit->user_id);

                $transaction = new Transaction();
                $transaction->user_id = $deposit->user_id;
                $transaction->amount = $deposit->amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge = $deposit->charge;
                $transaction->trx_type = '-';
                $transaction->details = 'Subscription buy via ' . $deposit->gatewayCurrency()->name;
                $transaction->trx = $deposit->trx;
                $transaction->remark = 'subscription_via_gateway';
                $transaction->save();

                if (!$isManual) {
                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Subscription buy via '.$deposit->gatewayCurrency()->name;
                    $adminNotification->click_url = urlPath('admin.deposit.successful');
                    $adminNotification->save();
                }

                notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance)
                ]);

            }else
            {

                $user = User::find($deposit->user_id);
                $user->balance += $deposit->amount;
                $user->save();

                $transaction = new Transaction();
                $transaction->user_id = $deposit->user_id;
                $transaction->subscription_id = 0;
                $transaction->amount = $deposit->amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge = $deposit->charge;
                $transaction->trx_type = '+';
                $transaction->details = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
                $transaction->trx = $deposit->trx;
                $transaction->remark = 'deposit';
                $transaction->save();

                if (!$isManual) {
                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Deposit successful via '.$deposit->gatewayCurrency()->name;
                    $adminNotification->click_url = urlPath('admin.deposit.successful');
                    $adminNotification->save();
                }

                notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance)
                ]);

            }
            $deposit->save();
        }
    }

    public function manualDepositConfirm()
    {

        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method','gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {

        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = 2;
        $data->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Deposit request from '.$data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'rate' => showAmount($data->rate),
            'trx' => $data->trx
        ]);

        $notify[] = ['success', 'You have deposit request has been taken'];
        return to_route('user.deposit.history')->withNotify($notify);
    }


}
