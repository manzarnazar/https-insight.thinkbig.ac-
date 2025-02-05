@php
    $content        = getContent('latest_episodes.content',true);
    $verified       = getContent('verified.content',true);
    $episodes       = App\Models\Episode::with(['podcast','podcast.user'])->orderBy('created_at','desc')->limit(2)->get();
@endphp

<section class="latest-podcast pt-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title">{{@$content->data_values->heading}}</h3>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">

            @foreach ($episodes as $item)
            <div class="col-lg-6 col-12 mb-4">
                <div class="latest-episode-item">
                    <div class="latest-episode-item__thumb">
                        <div class="image-wrap">
                            <img src="{{getImage(getFilePath('podcastEpisode').'/' . @$item->image_path .'/'. @$item->image )}}" alt="">
                            <div class="popup-vide-wrap-latest">
                                <div class="video-main">
                                    <div class="promo-video">
                                        <div class="waves-block">
                                            <div class="waves wave-1"></div>
                                            <div class="waves wave-2"></div>
                                            <div class="waves wave-3"></div>
                                        </div>
                                    </div>
                                    <a class="play-video"  href="{{route('podcast.details',$item->id)}}">
                                        <i class="fa fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <a href="{{route('user.payment', $item->id)}}" class="btn btn--sm">@lang('Subscribe')</a>
                        </div>
                    </div>

                    @php
                    if($item->link == null)
                    {
                        $path = getFilePath('podcastEpisode').'/' .$item->file_path .'/'. $item->filename;
                        $getID3 = new getID3;
                        $fileInfo = $getID3->analyze($path);
                        $duration = $fileInfo['playtime_seconds'];
                        $hours = floor($duration / 3600);
                        $minutes = floor(($duration / 60) % 60);
                        $seconds = $duration % 60;
                        $duration = sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
                    }
                    else{
                        $duration = ' ';
                    }

                    @endphp

                    <div class="latest-episode-item__info">
                        <div class="top d-flex mb-1">
                            @if ($duration != ' ')
                            <small class="time me-4">
                                <i class="fa-solid fa-clock"></i>
                                {{__($duration)}}
                            </small>
                            @endif

                            <small>@lang('Episode')  <span class="badge">{{__(@$item->podcast->episode_count)}}</span></small>
                        </div>

                        <h5 class=" mb-2">
                            <a class="title" href="{{route('podcast.details', $item->id)}}">{{__($item->title)}}</a>
                        </h5>

                        <div class="profile-block d-flex mb-2">
                            @if (@$item->podcast->creator_id != 0 )
                            <img src="{{ getImage(getFilePath('userProfile').'/'. @$item->podcast->user->image) }}" class="profile-block-image img-fluid" alt="creator_img">
                            @endif
                            <div>
                                @if (@$item->podcast->creator_id ==0)
                                    @lang('Admin')
                                @else
                                {{__(@$item->podcast->user->fullname)}}
                                   @if(@$item->podcast->varified == 1)
                                   <img src="{{getImage(getFilePath('frontend').'/verified/'. @$verified->data_values->verify_img)}}" class="verified-image img-fluid" alt="verified">
                                   @endif

                                <h5>{{__(@$item->podcast->user->designation)}}</h5>
                                @endif
                            </div>
                        </div>

                        <p class="mb-0">@php echo substr($item->description,0,90).''; @endphp</p>

                        <div class="latest-episode-bottom justify-content-between mt-3">
                            <a href="javascript:void(0)" class="bi-headphones me-1">
                                <i class="fa-solid fa-headphones"></i> <span>{{__(@$item->listen_count)}}</span>
                            </a>
                            <a href="{{route('user.podcast.bookmark.add', $item->id)}}" class="badge">
                                <i class="fa-solid fa-bookmark"></i>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>

