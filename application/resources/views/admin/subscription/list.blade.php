@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('S.L')</th>
                                <th>@lang('Podcast Title')</th>
                                <th>@lang('Subscriber name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Expire Date')<br>@lang('Remaining Days')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $item)
                            <tr>
                                <td>
                                    <span class="fw-bold"> <span class="text-primary"> {{ @$loop->index + 1 }} </span> </span>
                                </td>

                                <td>
                                    {{__(@$item->podcast->title)}}
                                </td>

                                <td>
                                    {{__(@$item->user->fullname)}}
                                </td>
                                <td>
                                    {{__(showAmount(@$item->price,2))}}
                                </td>
                                <td>
                                    @if($item->subscription_type == 1)
                                     @lang('Monthly')
                                    @elseif($item->subscription_type == 2)
                                        @lang('Yearly')
                                    @endif
                                </td>
                                <td>
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
                    </table><!-- table end -->

                    @if($subscriptions->hasPages())
                    <div class="card-footer py-4">
                        {{ $subscriptions->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>


@endsection

