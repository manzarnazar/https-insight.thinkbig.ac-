@php
    $content = getContent('podcast.content',true);
    $podcasts = App\Models\Podcast::orderBy('created_at','asc')->with('episode')->limit(3)->get();

@endphp

<section class="topics-area pt-60 mb-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title">{{__(@$content->data_values->heading)}}</h3>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($podcasts as $item)
            <div class="col-lg-4">
                <div class="single-topic mb-2">
                    <div class="single-topic__thumb">
                        <img src="{{getImage(getFilePath('podcast').'/' . @$item->path .'/'. @$item->image )}}" alt="">
                    </div>
                    <div class="single-topic__content">
                        <a class="title" href="{{route('podcast.episodes',$item->id)}}">
                            {{Illuminate\Support\Str::limit($item->title,20)}}
                        </a>
                        <p class="mb-3">{{Illuminate\Support\Str::limit(@$item->description,90)}}</p>
                        <a href="{{route('podcast.episodes', $item->id)}}" class="btn btn--sm">{{@$item->episode->count()}} @lang('Episodes') </a>

                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="text-end">
            <a href="{{route('podcast')}}" class="btn btn--base  mt-4">@lang('View More')</a>
        </div>
    </div>
</section>
