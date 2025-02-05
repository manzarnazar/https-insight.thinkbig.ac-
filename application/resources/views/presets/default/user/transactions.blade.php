@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 pe-xl-4">
                @include($activeTemplate.'components.sidebar')
            </div>
            <div class="col-xl-9 col-lg-12">
                <div class="dashboard-body">
                    <div class="dashboard-body__bar">
                        <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                    </div>
                    <div class="row gy-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="order-wrap">
                                <form action="" >
                                    <div class="row justify-content-end align-items-center">
                                        <div class="section-bg-white">
                                            <div class="row justify-content-end align-items-center mb-4">
                                                <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                                                    <label>@lang('Transaction Number')</label>
                                                    <input type="text" name="search" value="{{ request()->search }}" placeholder="@lang('Transaction') " aria-label="Username" aria-describedby="basic-addon1"                           class="form--control">


                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 mb-3">

                                                    <label  class="form-label" for="gateway">@lang('Amount Type')</label>
                                                    <select name="type" class="select form--control" id="gateway">
                                                        <option value="">@lang('All')</option>
                                                        <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                                        <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                                                    </select>


                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 mb-3">

                                                    <label class="form-label" for="gateway">@lang('Remark')</label>
                                                    <select class="select form--control" name="remark">
                                                        <option value="">@lang('Any')</option>
                                                        @foreach($remarks as $remark)
                                                        <option value="{{ $remark->remark }}" @selected(request()->remark ==
                                                            $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                                        @endforeach
                                                    </select>



                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6">
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn--base">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th>@lang('Transaction No.')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Remaining Balance')</th>
                                            <th>@lang('Completed')</th>
                                            <th>@lang('Trx Information')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $trx)
                                    <tr>
                                        <td>
                                            <strong>{{ $trx->trx }}</strong>
                                        </td>


                                        <td class="budget">
                                            <span
                                                class="fw-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                                {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text
                                                }}
                                            </span>
                                        </td>

                                        <td class="budget">
                                            {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                        </td>

                                        <td>
                                            {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at)
                                            }}
                                        </td>


                                        <td>{{ __($trx->details) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($transactions->hasPages())
                        <div class="card-footer text-end">
                            {{ $transactions->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
