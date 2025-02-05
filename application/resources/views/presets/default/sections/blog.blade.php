@php
    if(request()->url() == url('/').'/blog'){
        $blogs = getContent('blog.element',false,10);
    }else{
        $blogs = getContent('blog.element',false,3);
    }

  $content = getContent('blog.content',true);
  $latests = App\Models\Frontend::where('data_keys','blog.element')->orderBy('id','desc')->limit(3)->get();
@endphp


@if(request()->url() == url('/').'/blog')

    <div class="blog py-80">
        <div class="container">
            <div class="row gy-4 justify-content-end">
                <div class="col-lg-8">
                    <div class="row gy-4">

                        @foreach ($blogs as $blog)
                        <div class="col-lg-6 col-md-6">
                            <div class="blog-item">
                                <div class="blog-item__thumb">
                                    <a href="{{route('blog.details',['slug'=>slug(@$blog->data_values->title),'id'=>$blog->id])}}" class="blog-item__thumb-link">
                                        <img src="{{getImage(getFilePath('blog').'/'.'thumb_'.@$blog->data_values->blog_image)}}" alt="">
                                    </a>
                                </div>
                                <div class="blog-item__content">
                                    <ul class="text-list inline">
                                        <li class="text-list__item"> <span class="text-list__item-icon">@php echo @$blog->data_values->author_icon; @endphp</span> {{__($blog->data_values->author)}}</li>
                                        <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span> {{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}} </li>
                                    </ul>
                                    <h4 class="blog-item__title"><a href="{{route('blog.details',['slug'=>slug($blog->data_values->title),'id'=>$blog->id])}}" class="blog-item__title-link">{{__(@$blog->data_values->title)}}</a></h4>
                                    <a href="{{route('blog.details',['slug'=>slug($blog->data_values->title),'id'=>$blog->id])}}" class="btn--simple">@lang('Read more') <span class="btn--simple__icon"><i class="fas fa-arrow-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- ============================= Blog Details Sidebar Start ======================== -->
                    <div class="blog-sidebar-wrapper">

                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title"> @lang('Latest Topics')</h5>
                            <span class="hr-line"></span>
                            <span class="border"></span>

                            @foreach ($latests as $item)
                            <div class="latest-blog">
                                <div class="latest-blog__thumb">
                                    <a href="{{ route('blog.details', ['slug' => slug(@$item->data_values->title), 'id' => $item->id])}}"> <img src="{{__(getImage(getFilePath('frontend').'/blog/'.@$item->data_values->blog_image))}}" alt=""></a>
                                </div>
                                <div class="latest-blog__content">
                                    <h6 class="latest-blog__title"><a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">{{__(@$item->data_values->title)}}</a></h6>
                                    <span class="latest-blog__date">{{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@else

<section class="trending-episode-area py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title">{{@$content->data_values->heading}}</h3>
                </div>
            </div>
        </div>
        <div class="row gy-4">

            @forelse ($blogs as $blog)
            <div class="col-lg-4 col-md-4">
                <div class="blog-item">
                    <div class="blog-item__thumb">
                        <a href="{{route('blog.details',['slug'=>slug(@$blog->data_values->title),'id'=>$blog->id])}}" class="blog-item__thumb-link">
                            <img src="{{getImage(getFilePath('frontend').'/blog/'. @$blog->data_values->blog_image)}}" alt="">
                        </a>
                    </div>
                    <div class="blog-item__content">
                        <ul class="text-list inline">
                            <li class="text-list__item"> <span class="text-list__item-icon">@php echo @$blog->data_values->author_icon; @endphp</span> {{__(@$blog->data_values->author)}}</li>
                            <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span> {{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}} </li>
                        </ul>
                        <h4 class="blog-item__title"><a href="{{route('blog.details',['slug'=>slug(@$blog->data_values->title),'id'=>$blog->id])}}" class="blog-item__title-link">{{__(@$blog->data_values->title)}}</a></h4>
                        <a href="{{route('blog.details',['slug'=>slug($blog->data_values->title),'id'=>$blog->id])}}" class="btn--simple">@lang('Read more') <span class="btn--simple__icon"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
            @empty

            @endforelse

        </div>


        <div class="text-end">
            <a href="{{request()->url('/').'/blog'}}" class="btn btn--base mt-4">@lang('View More')</a>
        </div>
    </div>
</section>

@endif
