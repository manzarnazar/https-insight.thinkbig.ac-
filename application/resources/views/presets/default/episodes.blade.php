@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="trending-episode-area py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title">@lang('Episodes List')</h3>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @forelse ($episodes as $item)
            <div class="col-lg-4 mb-3">
                <div class="single-trending-episode">

                    <div class="single-trending-episode__thumb">
                        <img src="{{getImage(getFilePath('podcastEpisode').'/' . @$item->image_path .'/'. @$item->image )}}" alt="episode_img">
                    </div>

                    <div class="single-trending-episode__info">
                        <h5 class="my-3">
                            <a class="title" href="{{route('podcast.details', $item->id)}}">
                               {{Illuminate\Support\Str::limit($item->title,30)}}
                            </a>
                        </h5>

                        <div class="profile-block d-flex mb-2">
                            @if($item->podcast->user)
                                <img src="{{ getImage(getFilePath('userProfile').'/'. @$item->podcast->user->image) }}" class="profile-block-image img-fluid" alt="login">
                                <div>
                                    {{__(@$item->podcast->user->fullname)}}

                                    <h5> {{__(@$item->podcast->user->designation)}} </h5>
                                </div>
                            @else
                            <div>
                                @lang('Admin')
                            </div>
                            @endif

                        </div>

                        <p class="mb-0"> @php echo substr($item->description,0,90).''; @endphp </p>

                        <div class="latest-episode-bottom  justify-content-between mt-3">
                            <a href="javascript:void(0)" class="bi-headphones me-1">
                                <i class="fa-solid fa-headphones"></i> <span> {{__($item->listen_count)}} </span>
                            </a>

                            <a href="{{route('user.podcast.bookmark.add', $item->id)}}" class="bi-heart me-2">
                                <i class="fa-solid fa-bookmark"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            @empty

            @endforelse



        @if ($episodes->hasPages())
        <div class=" py-4">
            @php echo paginateLinks($episodes) @endphp
        </div>
        @endif

        </div>
    </div>
</section>

@endsection
