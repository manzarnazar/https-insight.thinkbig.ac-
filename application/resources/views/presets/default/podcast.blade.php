@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="trending-episode-area py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title">@lang('Podcasts')</h3>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @forelse ($podcasts as $item)
            <div class="col-lg-4  mb-4">
                <div class="single-trending-episode">


                    <div class="single-trending-episode__thumb mb-3">
                        <img src="{{getImage(getFilePath('podcast').'/' . @$item->path .'/'. @$item->image )}}" alt="">
                    </div>


                    <div class="single-trending-episode__info">
                        <h5 class="mb-2">
                            <a class="title" href="{{route('podcast.episodes',$item->id)}}">
                                {{__($item->title)}}
                            </a>
                        </h5>

                        <div class="profile-block d-flex mb-2">
                            @if($item->user && $item->user->image != null)
                                    <img src="{{ getImage(getFilePath('userProfile').'/'.@ $item->user->image) }}" class="profile-block-image img-fluid" alt="">
                                @endif


                            <div>
                                @if(@$item->user)
                                {{__(@$item->user->fullname)}}

                                <h5>{{__(@$item->user->designation)}}</h5>
                                @endif
                            </div>
                        </div>

                        <p class="mb-0">{{Illuminate\Support\Str::limit($item->description,90)}}</p>

                        <div class="latest-episode-bottom d-flex justify-content-between flex-wrap mt-3">
                            <a href="{{route('podcast.episodes',$item->id)}}" class="btn btn-base btn--sm mt-2">{{@$item->episode->count()}} @lang('Episodes')</a>
                            <a href="{{route('user.subscription.payment', $item->id)}}" class="btn btn-base btn--sm mt-2">@lang('Subscribe')</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                {{__($emptyMessage)}}
            @endforelse

            @if ($podcasts->hasPages())
            <div class=" py-4">
                @php echo paginateLinks($podcasts) @endphp
            </div>
            @endif


        </div>
    </div>
</section>

@endsection
