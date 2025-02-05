@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
    $latests = App\Models\Frontend::where('data_keys','blog.element')->orderBy('id','desc')->limit(3)->get();
    $socialIcons    = getContent('social_icon.element',false);
@endphp

<section class="blog-detials py-60">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details">

                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <img src="{{__(getImage(getFilePath('blog').'/'.@$blog->data_values->blog_image))}}" alt="Blog_image">
                        </div>
                        <div class="blog-item__content">
                            <ul class="text-list inline">
                                <li class="text-list__item"> <span class="text-list__item-icon">@php echo @$blog->data_values->author_icon; @endphp </span> {{__(@$blog->data_values->author)}} </li>
                                <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span> {{\Carbon\Carbon::parse(@$blog->created_at)->format('d M Y')}}</li>
                            </ul>
                        </div>
                    </div>
                   <div class="blog-details__content">
                        <h3 class="blog-details__title">{{__(@$blog->data_values->title)}}</h3>
                        <div class="blog-details__desc"> @php echo @$blog->data_values->description @endphp </div>

                        <div class="blog-details__share mt-4 d-flex align-items-center flex-wrap mb-4">
                            <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h5>
                            <ul class="social-list">
                                <li class="social-list__item"><a
                                        href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{slug($blog->data_values->title)}}"
                                        class="social-list__link active"><i class="fab fa-facebook-f"></i></a> </li>
                                <li class="social-list__item"><a
                                        href="https://twitter.com/intent/tweet?status={{slug($blog->data_values->title)}}+{{ Request::url() }}"
                                        class="social-list__link active"> <i class="fab fa-twitter"></i></a></li>
                                <li class="social-list__item"><a
                                        href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{slug($blog->data_values->title)}}&source=propertee"
                                        class="social-list__link active"> <i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>

                   </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- ============================= Blog Details Sidebar Start ======================== -->
<div class="blog-sidebar-wrapper">

    <div class="blog-sidebar">
        <h5 class="blog-sidebar__title"> @lang('Hot Topics')</h5>
        <span class="hr-line"></span>
        <span class="border"></span>

        @forelse ($latests as $item)
        <div class="latest-blog">
            <div class="latest-blog__thumb">
                <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}"> <img src="{{__(getImage(getFilePath('frontend').'/blog/'. @$item->data_values->blog_image))}}" alt=""></a>
            </div>
            <div class="latest-blog__content">
                <h6 class="latest-blog__title"><a href="{{ route('blog.details', ['slug' => slug(@$item->data_values->title), 'id' => $item->id])}}">{{__(@$item->data_values->title)}}</a></h6>
                <span class="latest-blog__date">{{\Carbon\Carbon::parse(@$blog->created_at)->format('d M Y')}}</span>
            </div>
        </div>
        @empty
        <p>@lang('No content available')</p>
        @endforelse
    </div>

</div>
<!-- ============================= Blog Details Sidebar End ======================== -->
            </div>
        </div>
    </div>
</section>
@endsection
@push('style')
<style>
    .blog-details__desc ul, ol{
        margin: 20px 40px;
    }
    .blog-details__desc ul li{
        list-style: disc;
        font-family: var(--body-font); 
    }
</style>
@endpush