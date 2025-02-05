@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row justify-content-center">
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
                                <div class="row ">
                                    <div class="col-md-4 mb-3">
                                        <div class="new-ticket ">
                                            <a href="{{route('ticket.open') }}" class="btn btn--base">@lang('Create Ticket')<i class="las la-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                    <table class="table table--responsive--lg">
                                        <thead>
                                            <tr>
                                                <th>@lang('Subject')</th>
                                                <th>@lang('Importance')</th>
                                                <th>@lang('Latest Response')</th>
                                                <th>@lang('Status')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($supports as $support)
                                            <tr>
                                                <td> <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                                <td data-label="Description">
                                                    @if($support->priority == 1)
                                                       @lang('Low')
                                                    @elseif($support->priority == 2)
                                                        @lang('Medium')
                                                    @elseif($support->priority == 3)
                                                        @lang('High')<
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
                                                <td>
                                                    @php echo $support->statusBadge; @endphp
                                                </td>

                                                <td>
                                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--base btn-sm">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                               </div>
                               {{$supports->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
