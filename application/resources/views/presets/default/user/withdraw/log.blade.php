@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 pe-xl-4">
                @include($activeTemplate.'components.sidebar')
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="dashboard-body">
                    <div class="row ">
                        <div class="col-md-12 mb-3 justify-content-end">
                            <div class="escro-search-wrapper">
                                <form action="" autocomplete="off">
                                    <div class="header-search-wrap">
                                        <div class="search-box header-search-hide-show">
                                            <input type="text" name="search" value="{{request()->search}}" class="form--control pr-0" placeholder="@lang('Trx search')">
                                            <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('Payment Gateway')</th>
                                <th data-label="Amount" class="text-center">@lang('Amount')</th>
                                <th data-label="Conversation" class="text-center">@lang('Currency Exchange')</th>
                                <th data-label="Trx" class="text-center">@lang('Trx')</th>
                                <th data-label="Initiated" class="text-center">@lang('Initiated')</th>
                                <th data-label="status" class="text-center">@lang('Trx Status')</th>
                                <th data-label="Details">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdraws as $withdraw)
                            <tr>
                                <td>
                                    <span class="fw-bold"><span class="text-primary"> {{
                                            __(@$withdraw->method->name) }} </span></span>
                                </td>

                                <td class="text-center">

                                    <strong title="@lang('Amount after charge')">
                                        {{ showAmount($withdraw->amount-$withdraw->charge) }} {{
                                        __($general->cur_text) }}
                                    </strong>

                                </td>
                                <td class="text-center">

                                    <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency)
                                        }}</strong>
                                </td>

                                <td class="text-center">{{__($withdraw->trx)}}</td>

                                <td class="text-center">
                                    {{ showDateTime($withdraw->created_at) }}
                                </td>

                                <td class="text-center">
                                    @php echo $withdraw->statusBadge @endphp
                                </td>
                                <td>
                                    <button type="button" class="btn btn--base btn--sm detailBtn " data-toggle="modal" data-target="#exampleModalCenter" data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                        @if ($withdraw->status == 3)
                                        data-admin_feedback="{{ $withdraw->admin_feedback }}"
                                        @endif>
                                        <i class="fas fa-eye"></i>
                                    </button>


                                </td>
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
            @if($withdraws->hasPages())
            <div class="card-footer text-end">
                {{$withdraws->links()}}
            </div>
            @endif



        </div>
    </div>
</div>

{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData">

                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');
            var userData = $(this).data('user_data');
            var html = ``;
            userData.forEach(element => {
                if (element.type != 'file') {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                }
            });
            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);

            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush
