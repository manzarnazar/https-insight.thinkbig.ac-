@php
    $content        = getContent('banner.content',true);
    $elements       = getContent('banner.element',false);
    $creators       = App\Models\Podcast::where('creator_id','!=',0)->with('user')->get();
    $categories       = App\Models\Category::get();
    $socialIcons    = getContent('social_icon.element',false);
@endphp

<section class="banner-area bg-img">
	<div class="container">
		<div class="row gy-4 align-items-center justify-content-start">
			<div class="col-lg-12">
				<div class="banner__content text-left">
					<h2> {{__(@$content->data_values->heading)}} </h2>
					<p>{{__(@$content->data_values->subheading)}}</p>
                    <div class="banner-search">

                        <div class="header-search-wrap">
                            <form>
                                <div class="search-box position-relative">
                                    <input type="text" name="searchTerm" id="searchTerm" class="form--control pr-0" placeholder="@lang('Search Podcasts ...')"  autocomplete="off">
                                    <div class="search-wrap" id="search-results"></div>
                                </div>
                            </form>



                        </div>

                    </div>
					<a class="btn btn--base" href="{{route('podcast')}}">{{__(@$content->data_values->button)}}</a>
				</div>
			</div>
		</div>
		<div class="podcast-team-area mt-5">
			<div class="container">
				<div class="row podcast-team-slider justify-content-center">
                    @foreach ($creators as $item)
                    <div class="podcast-team-single">
						<div class="podcast-team-single__thumb">
							<img src="{{getImage(getFilePath('userProfile').'/'.@$item->user->image)}}" alt="">
						</div>

						<div class="podcast-team-single__content">
							<div class="podcast-team-single__content name">
								<h4>{{__(@$item->user->firstname)}} {{__(@$item->user->lastname)}}</h4>
							</div>
							<div class="podcast-team-single__content-tags">
								<span class="btn btn--ssm">{{__(@$item->user->designation)}}</span>

							</div>
							<ul class="social-list">

                                <li class="social-list__item">
                                    <a href="{{@$item->user->facebook_url}}" class="social-list__link text-white">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>

                                <li class="social-list__item">
                                    <a href="{{@$item->user->twitter_url}}" class="social-list__link text-white">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>

                                <li class="social-list__item">
                                    <a href="{{@$item->user->linkedin_url}}" class="social-list__link text-white">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>

							</ul>
						</div>
					</div>
                    @endforeach


				</div>
			</div>
		</div>
	</div>
</section>

@push('script')

<script>

    $(document).ready(function() {
        $('#searchTerm').on('keyup', function() {
            var searchTerm = $(this).val();
            if (searchTerm.length >= 1) {
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: {
                        searchTerm: searchTerm
                    },
                    success: function(response) {
                        var results = '';
                        var websiteUrl = "{{ url('/') }}/";

                        $.each(response, function(index, value) {
                            results += '<p><a href="' + websiteUrl + 'podcast/' + value.id + '">' + value.title + '</a></p>';
                        });
                        $('#search-results').html(results);
                    }
                });
            } else {
                $('#search-results').empty();
            }
        });
    });

</script>
@endpush

