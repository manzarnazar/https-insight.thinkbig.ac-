@php
$content = getContent('about.content',true);
$pages = App\Models\Page::all();

@endphp

<div class="about-section  py-80">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="section-title-wrap mb-2">
                        <h4 class="section-title">{{__(@$content->data_values->subheading)}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-thumb">
                    <div class="about-thumb__inner">

                        <img src="{{getImage(getFilePath('frontend').'/about/'. @$content->data_values->about_image)}}" alt="image">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-right-content">
                    <div class="section-heading">
                        <h3 class="section-heading__title ">{{__(@$content->data_values->heading)}}</h3>
                        <p class="section-heading__desc mb-30">{{__(@$content->data_values->description)}}</p>

                        @foreach ($pages as $page)
                            @if ($page->slug == 'about')
                            <a href="{{route('pages',$page->slug)}}" class="btn btn--base">Enter</a>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>