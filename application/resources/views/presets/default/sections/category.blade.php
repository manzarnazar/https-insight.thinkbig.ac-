@php
    $content = getContent('category.content',true);
    $categories = App\Models\Category::orderBy('created_at','asc')->with('podcast')->get();

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
            @foreach ($categories as $item)
            <div class="col-lg-3">
                <div class="single-topic mb-2">
                    <div class="single-topic__thumb">
                        <img src="{{getImage(getFilePath('category').'/' . @$item->path .'/'. @$item->image )}}" alt="">
                    </div>
                    <div class="single-topic__content">
                        <a class="title category-title" href="{{route('podcast.episodes',$item->id)}}">
                            {{Illuminate\Support\Str::limit($item->name,20)}}
                        </a>

                        <a href="{{route('category.podcast',$item->id)}}" class="btn btn--sm btn-category">{{@$item->podcast->count()}} @lang('Episodes') </a>

                    </div>
                </div>
            </div>
            @endforeach

        </div>


    </div>
</section>
