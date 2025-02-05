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
                                <h3 class="contact__title"> @lang('Payment for') {{@$podcast->title}} @lang('subscription\'s package') </h3>
                                <form action="{{route('user.deposit.insert')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="method_code">
                                    <input type="hidden" name="currency">
                                    <div class="row gy-md-4 gy-5">
                                        <input type="text" hidden id='podcast_id' value = "{{@$podcast->id}}" name ="id">

                                        <div class="form-group">
                                            <label class="form-label">@lang('Select subscription type')</label>
                                            <select class="form-control form--control" name="subscription_type" required id="subscription_type">
                                                <option value="">@lang('Select One')</option>
                                                <option value="1" @selected(old('subscription_type')==1)>@lang('Monthly')</option>
                                                <option value="2" @selected(old('subscription_type')==2)>@lang('Yearly')</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label class="form-label">@lang('Select Payment Gateway')</label>
                                            <select class="form-control form--control" name="gateway" required>
                                                <option value="">@lang('Select One')</option>
                                                <option value="deposit_wallet">@lang('Balance - '){{ $general->cur_sym }}{{showAmount($balance)}}</option>
                                                @foreach($gatewayCurrency as $data)
                                                <option value="{{$data->method_code}}" @selected(old('gateway')==$data->method_code)
                                                    data-gateway="{{ $data }}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">@lang('Amount')</label>
                                            <div class="input-group">
                                                <input type="number" step="any" name="amount" class="form-control form--control country-curency"
                                                    value="" autocomplete="off" required id="amount" readonly>
                                                <span class="input-group-text">{{ $general->cur_text }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-3 preview-details d-none">
                                            <span>@lang('Limit')</span>
                                            <span><span class="min fw-bold">0</span> {{__($general->cur_text)}} - <span
                                                    class="max fw-bold">0</span> {{__($general->cur_text)}} , </span>

                                            <span>@lang('Charge')</span>
                                            <span><span class="charge fw-bold">0</span> {{__($general->cur_text)}} ,</span>

                                            <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span>
                                                {{__($general->cur_text)}} </span>

                                        </div>
                                        <button type="submit" class="btn btn--base w-100 mt-3">@lang('Save')</button>

                                    </div>
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
<script src="{{asset('assets/admin/js/jquery.form.min.js')}}"></script>

<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {

            $("#subscription_type").on('change', function () {
                var subscriptionType = $(this).find(':selected').val();
                var podcastId = `{{@$podcast->id}}`;
                if (subscriptionType != null && podcastId != null) {
                    fnSubscriptionType(subscriptionType, podcastId);
                }

                if($('#amount').val() != null )
                {
                    $('select[name=gateway]').change();
                        $('.amount').text(parseFloat($('#amount').val()).toFixed(2));
                }
            }).change();

        });


        function fnSubscriptionType(subscriptionType, podcastId) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('user.subscription-calculation')}}",
                type: "post",
                data: {
                    subscriptionType, podcastId
                },
                success: function (response) {
                    var alertStatus = "";
                    if (response.errors) {
                        iziToast.error({
                            message: response.errors,
                            position: "topRight"
                        });
                    } else {
                        $('#amount').val(response);
                    }
                }

            });

        }


    })(jQuery);

</script>

<script>
    (function ($) {
        "use strict";
        $('select[name=gateway]').change(function () {
            if (!$('select[name=gateway]').val()) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            var resource = $('select[name=gateway] option:selected').data('gateway');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate)
            if (resource.method.crypto == 1) {
                var toFixedDigit = 8;
                $('.crypto_currency').removeClass('d-none');
            } else {
                var toFixedDigit = 2;
                $('.crypto_currency').addClass('d-none');
            }
            $('.min').text(parseFloat(resource.min_amount).toFixed(2));
            $('.max').text(parseFloat(resource.max_amount).toFixed(2));
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
            var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
            $('.payable').text(payable);
            var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(toFixedDigit);
            $('.final_amo').text(final_amo);
            if (resource.currency != '{{ $general->cur_text }}') {
                var rateElement = `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span></span>`;
                $('.rate-element').html(rateElement)
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
            $('.base-currency').text(resource.currency);
            $('.method_currency').text(resource.currency);
            $('input[name=currency]').val(resource.currency);
            $('input[name=method_code]').val(resource.method_code);
            // $('input[name=amount]').on('input');
        });
        // $('input[name=amount]').on('input', function () {
        //     $('select[name=gateway]').change();
        //     $('.amount').text(parseFloat($(this).val()).toFixed(2));
        // });



    })(jQuery);
</script>



@endpush
