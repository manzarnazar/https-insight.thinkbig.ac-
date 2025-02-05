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
                                <th>@lang('Episode Title')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookmarks as $item)
                            <tr>
                                <td>
                                    <span class="fw-bold"> <span class="text-primary"> {{ @$loop->index + 1 }} </span> </span>
                                </td>

                                <td class="text-center">
                                    {{__(@$item->bookmark->title)}}
                                </td>
                                <td class="text-end">
                                    <a href="{{route('podcast.details', $item->episode_id)}}"
                                        class="btn btn--base btn--sm">
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
            </div>
            @if($bookmarks->hasPages())
            <div class="card-footer text-end">
                {{ $bookmarks->links() }}
            </div>
            @endif
        </div>
    </div>
</div>


@endsection


