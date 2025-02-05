@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                @include($activeTemplate.'components.sidebar')
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="dashboard-body">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('S.L')</th>
                                <th>@lang('Podcast Title')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Expire Date')<br>@lang('Remaining Days')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $item)
                            <tr>
                                <td class="text-center">
                                    <span class="fw-bold"> <span class="text-primary"> {{ @$loop->index + 1 }} </span> </span>
                                </td>

                                <td class="text-center">
                                    {{__(@$item->podcast_title)}}
                                </td>

                                <td class="text-center">
                                    {{__(showAmount(@$item->price,2))}}
                                </td>
                                <td class="text-center">
                                    @if($item->subscription_type == 1)
                                     @lang('Monthly')
                                    @elseif($item->subscription_type == 2)
                                        @lang('Yearly')
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->expire_date > now())
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Inactive')</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->status == 1)
                                    {{showDateTime($item->expire_date)}}<br>
                                    {{ \Carbon\Carbon::parse($item->expire_date)->diffForHumans()}}
                                    @else
                                    @php echo $item->statusBadge($item->status); @endphp
                                    @endif
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
            </div>
            @if($subscriptions->hasPages())
            <div class="card-footer text-end">
                {{ $subscriptions->links() }}
            </div>
            @endif

        </div>
    </div>
</div>


@endsection


