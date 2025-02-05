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
                    <div class="row gy-4">
                        <div class="col-xl-9 col-lg-10">
                            <div class="contactus-form">
                                <h3 class="contact__title"> @lang('Withdraw Balance ')</h3>
                                <form action="{{route('user.withdraw.money')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">@lang('Withdraw Approach')</label>

                                        <select class="select form--control" name="method_code" required>
                                            <option value="">@lang('Select Gateway')</option>
                                            @foreach($withdrawMethod as $data)
                                            <option value="{{ $data->id }}" data-resource="{{$data}}"> {{__($data->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Amount')</label>
                                        <div class="input-group country-code">
                                                    <span class="input-group-text">{{ $general->cur_text }}</span>

                                                    <input type="number" step="any" name="amount" class="form-control form--control mobile-code" aria-describedby="basic-addon1" value="{{ old('amount') }}" autocomplete="off" required>
                                                </div>
                                    </div>
                                    <div class="mt-3 preview-details d-none">

                                        <span>@lang('Limit')</span>
                                        <span><span class="min fw-bold">0</span> {{__($general->cur_text)}} - <span
                                                class="max fw-bold">0</span> {{__($general->cur_text)}} , </span>

                                        <span>@lang('Charge')</span>
                                        <span><span class="charge fw-bold">0</span> {{__($general->cur_text)}} ,</span>

                                        <span>@lang('Receivable')</span> <span><span class="receivable fw-bold"> 0</span>
                                            {{__($general->cur_text)}} ,</span>

                                        <span>@lang('In') <span class="base-currency"></span></span>
                                        <strong class="final_amo">0</strong>

                                    </div>
                                    <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('select[name=method_code]').change(function () {
            if (!$('select[name=method_code]').val()) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            var resource = $('select[name=method_code] option:selected').data('resource');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate)
            var toFixedDigit = 2;
            $('.min').text(parseFloat(resource.min_limit).toFixed(2));
            $('.max').text(parseFloat(resource.max_limit).toFixed(2));
            var amount = parseFloat($('input[name=amount]').val());
            if (!amount) {
                amount = 0;
            }
            if (amount <= 0) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            $('.preview-details').removeClass('d-none');

            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
            $('.charge').text(charge);
            if (resource.currency != '{{ $general->cur_text }}') {
                var rateElement = `<span>@lang('Conversion Rate')</span> <span class="fw-bold">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span>`;
                $('.rate-element').html(rateElement);
                $('.rate-element').removeClass('d-none');
                $('.in-site-cur').removeClass('d-none');
                $('.rate-element').addClass('d-flex');
                $('.in-site-cur').addClass('d-flex');
            } else {
                $('.rate-element').html('')
                $('.rate-element').addClass('d-none');
                $('.in-site-cur').addClass('d-none');
                $('.rate-element').removeClass('d-flex');
                $('.in-site-cur').removeClass('d-flex');
            }
            var receivable = parseFloat((parseFloat(amount) - parseFloat(charge))).toFixed(2);
            $('.receivable').text(receivable);
            var final_amo = parseFloat(parseFloat(receivable) * rate).toFixed(toFixedDigit);
            $('.final_amo').text(final_amo);
            $('.base-currency').text(resource.currency);
            $('.method_currency').text(resource.currency);
            $('input[name=amount]').on('input');
        });
        $('input[name=amount]').on('input', function () {
            var data = $('select[name=method_code]').change();
            $('.amount').text(parseFloat($(this).val()).toFixed(2));
        });
    })(jQuery);
</script>
@endpush
