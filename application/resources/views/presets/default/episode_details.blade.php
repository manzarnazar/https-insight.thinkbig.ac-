@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
    $socialIcons = getContent('social_icon.element',false);
    $verified    = getContent('verified.content',true);
@endphp


<section class="latest-podcast pt-60">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title text-dark">{{@$episode->podcast->title}}({{@$episode->podcast->category->name}})</h3>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center align-items-center mt-1">
            <div class="col-lg-4">
                <div class="latest-episode-item__thumb">

                    @if ($episode->link == null)
                        @if ($extension == 'mp3')
                        <div class="single-topic">
                            <div class="single-topic__thumb">
                                <img src="{{getImage(getFilePath('podcastEpisode').'/' . @$episode->image_path .'/'. @$episode->image )}}" alt="">
                            </div>
                            <div class="single-topic__content">
                                <div class="audio-player">
                                <div class="timeline">
                                    <div class="progress"></div>
                                </div>
                                <div class="controls">
                                    <div class="play-container">
                                    <div class="toggle-play play">
                                    </div>
                                    </div>
                                    <div class="time">
                                    <div class="current">0:00</div>
                                    <div class="divider">/</div>
                                    <div class="length"></div>
                                    </div>
                                    <div class="name"> {{__($episode->title)}} </div>
                                    <div class="volume-container">
                                    <div class="volume-button">
                                        <div class="volume icono-volumeMedium"></div>
                                    </div>

                                    <div class="volume-slider">
                                        <div class="volume-percentage"></div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>


                        </div>
                        @elseif($extension == "mp4")
                        <div class="single-topic video-details">
                                <img src="{{getImage(getFilePath('podcastEpisode').'/' . @$episode->image_path .'/'. @$episode->image )}}" alt="">
                                <div class="popup-vide-wrap">
                                    <div class="video-main">
                                        <div class="promo-video">
                                            <div class="waves-block">
                                                <div class="waves wave-1"></div>
                                                <div class="waves wave-2"></div>
                                                <div class="waves wave-3"></div>
                                            </div>
                                        </div>
                                        <a class="play-video popup_video" data-fancybox="" href="{{getImage(getFilePath('podcastEpisode').'/' .$episode->file_path .'/'. $episode->filename )}}">
                                            <span class="play-btn"> <i class="fa fa-play"></i></span>
                                        </a>
                                    </div>
                                </div>


                        </div>
                        @endif

                    @else

                    <div class="latest-episode-item__thumb position-relative">
                        <div >
                            <img class="epi-img" src="{{getImage(getFilePath('podcastEpisode').'/' . @$episode->image_path .'/'. @$episode->image )}}" alt="">
                            <div class="popup-vide-wrap">
                                <div class="video-main">
                                    <div class="promo-video">
                                        <div class="waves-block">
                                            <div class="waves wave-1"></div>
                                            <div class="waves wave-2"></div>
                                            <div class="waves wave-3"></div>
                                        </div>
                                    </div>
                                    <a class="play-video popup_video" data-fancybox="" href="{{$episode->link}}">
                                        <span class="play-btn"> <i class="fa fa-play"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                </div>
            </div>


            <div class="col-lg-8">
                <div class="latest-episode-item__info">
                    <div class="top d-flex align-tems-center mb-1">
                        @if ($duration == ' ')

                        @elseif ($duration != '')
                        <small class="time me-4">
                            <i class="fa-solid fa-clock"></i>
                            {{$duration}}
                        </small>
                        @endif

                        <small>@lang('Episode') <span class="badge">{{@$episode_number}}</span></small>

                        <div class="latest-episode-bottom d-flex ms-3">
                            <a href="javascript:void(0)" class="bi-headphones me-3">
                                <i class="fa-solid fa-headphones"></i> <span>{{@$episode->listen_count}}</span>
                            </a>

                            @if(!$existBookmark)
                            <a href="{{route('user.podcast.bookmark.add', $episode->id)}}" class="bi-heart me-2">
                                <i class="fa-regular fa-bookmark"></i> <span>{{@$bookmark}}</span>
                            </a>
                            @else
                            <a href="{{route('user.podcast.bookmark.add', $episode->id)}}" class="bi-heart me-2">
                                <i class="fa-solid fa-bookmark"></i> <span>{{@$bookmark}}</span>
                            </a>

                            @endif


                        </div>
                    </div>

                    <h2 class=" mb-2">
                        {{@$episode->title}}
                    </h2>
                    <p class="mb-3">{{@$episode->description}}</p>



                    @if($episode->podcast->user)
                    <div class="bottom-influencer d-flex align-items-center">
                        <div class="profile-block d-flex me-3">

                            @if($episode->podcast->user)
                                <img src="{{ getImage(getFilePath('userProfile').'/'.@$episode->podcast->user->image) }}" class="profile-block-image img-fluid" alt="">
                            @endif

                            <div>
                                {{ucfirst(@$episode->podcast->user->firstname)}} {{ucfirst(@$episode->podcast->user->lastname)}}
                                    @if(@$episode->podcast->varified == 1)
                                    <img src="{{getImage(getFilePath('frontend').'/verified/'. @$verified->data_values->verify_img)}}" class="verified-image img-fluid" alt="verified">
                                    @endif
                                <h5>
                                    @if($episode->podcast->user->designation != null)
                                        {{ucfirst(@$episode->podcast->user->designation)}}
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =================== Meet podcasts Here ================== -->
<section class="topics-area meet-podcasts py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h3 class="section-title text-dark">@lang('More Episodes')</h3>
                </div>
            </div>
        </div>
        <div class="row d-flex">

            @forelse($totalEpisode->load('podcast') as $item)
            
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
                <p>@lang('No Episode Found')</p>
            @endforelse


        </div>
    </div>
</section>

<!-- =================== Meet podcasts Here ================== -->

@endsection
@push('fbComment')
	@php echo loadExtension('fb-comment') @endphp
@endpush




@push('script')
<script>

var path = `{{@$episode->file_path}}`;
var filename = `{{@$episode->filename}}`;
var audioPath = "{{getFilePath('podcastEpisode')}}"+'/'+path+'/'+filename;
var websiteUrl = "{{ url('/') }}/";
var audioFilePath = websiteUrl  + audioPath;


const audioPlayer = document.querySelector(".audio-player");
const audio = new Audio(audioFilePath);


console.dir(audio);

audio.addEventListener(
  "loadeddata",
  () => {
    audioPlayer.querySelector(".time .length").textContent = getTimeCodeFromNum(
      audio.duration
    );
    audio.volume = .75;
  },
  false
);

const timeline = audioPlayer.querySelector(".timeline");
timeline.addEventListener("click", e => {
  const timelineWidth = window.getComputedStyle(timeline).width;
  const timeToSeek = e.offsetX / parseInt(timelineWidth) * audio.duration;
  audio.currentTime = timeToSeek;
}, false);

const volumeSlider = audioPlayer.querySelector(".controls .volume-slider");
volumeSlider.addEventListener('click', e => {
  const sliderWidth = window.getComputedStyle(volumeSlider).width;
  const newVolume = e.offsetX / parseInt(sliderWidth);
  audio.volume = newVolume;
  audioPlayer.querySelector(".controls .volume-percentage").style.width = newVolume * 100 + '%';
}, false)

setInterval(() => {
  const progressBar = audioPlayer.querySelector(".progress");
  progressBar.style.width = audio.currentTime / audio.duration * 100 + "%";
  audioPlayer.querySelector(".time .current").textContent = getTimeCodeFromNum(
    audio.currentTime
  );
}, 500);

const playBtn = audioPlayer.querySelector(".controls .toggle-play");
playBtn.addEventListener(
  "click",
  () => {
    if (audio.paused) {
      playBtn.classList.remove("play");
      playBtn.classList.add("pause");
      audio.play();
    } else {
      playBtn.classList.remove("pause");
      playBtn.classList.add("play");
      audio.pause();
    }
  },
  false
);

audioPlayer.querySelector(".volume-button").addEventListener("click", () => {
  const volumeEl = audioPlayer.querySelector(".volume-container .volume");
  audio.muted = !audio.muted;
  if (audio.muted) {
    volumeEl.classList.remove("icono-volumeMedium");
    volumeEl.classList.add("icono-volumeMute");
  } else {
    volumeEl.classList.add("icono-volumeMedium");
    volumeEl.classList.remove("icono-volumeMute");
  }
});

function getTimeCodeFromNum(num) {
  let seconds = parseInt(num);
  let minutes = parseInt(seconds / 60);
  seconds -= minutes * 60;
  const hours = parseInt(minutes / 60);
  minutes -= hours * 60;

  if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
  return `${String(hours).padStart(2, 0)}:${minutes}:${String(
    seconds % 60
  ).padStart(2, 0)}`;
}

</script>


@endpush

@push("style")
<style>
.audio-player {
  height: 50px;
  width: 100%;
  background: #444;
  box-shadow: 0 0 20px 0 #000a;
  font-family: arial;
  color: white;
  font-size: 0.75em;
  overflow: hidden;
  display: grid;
  grid-template-rows: 6px auto;
}
.audio-player .timeline {
  background: white;
  width: 100%;
  position: relative;
  cursor: pointer;
  box-shadow: 0 2px 10px 0 #0008;
}
.audio-player .timeline .progress {
  background: hsl(var(--base-two));
  width: 0%;
  height: 100%;
  transition: 0.25s;
}
.audio-player .controls {
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    padding: 0 20px;
    background: hsl(var(--base));
}
.audio-player .controls > * {
  display: flex;
  justify-content: center;
  align-items: center;
}
.audio-player .controls .toggle-play.play {
  cursor: pointer;
  position: relative;
  left: 0;
  height: 0;
  width: 0;
  border: 7px solid #0000;
  border-left: 13px solid white;
}
.audio-player .controls .toggle-play.play:hover {
  transform: scale(1.1);
}
.audio-player .controls .toggle-play.pause {
  height: 15px;
  width: 20px;
  cursor: pointer;
  position: relative;
}
.audio-player .controls .toggle-play.pause:before {
  position: absolute;
  top: 0;
  left: 0px;
  background: white;
  content: "";
  height: 15px;
  width: 3px;
}
.audio-player .controls .toggle-play.pause:after {
  position: absolute;
  top: 0;
  right: 8px;
  background: white;
  content: "";
  height: 15px;
  width: 3px;
}
.audio-player .controls .toggle-play.pause:hover {
  transform: scale(1.1);
}
.audio-player .controls .time {
  display: flex;
}
.audio-player .controls .time > * {
  padding: 2px;
}
.audio-player .controls .volume-container {
  cursor: pointer;
  position: relative;
  z-index: 2;
}
.audio-player .controls .volume-container .volume-button {
  height: 26px;
  display: flex;
  align-items: center;
}
.audio-player .controls .volume-container .volume-button .volume {
  transform: scale(0.7);
}
.audio-player .controls .volume-container .volume-slider {
  position: absolute;
  left: -3px;
  top: 15px;
  z-index: -1;
  width: 0;
  height: 15px;
  background: white;
  box-shadow: 0 0 20px #000a;
  transition: 0.25s;
}
.audio-player .controls .volume-container .volume-slider .volume-percentage {
  background: hsl(var(--base-two));
  height: 100%;
  width: 75%;
}
.audio-player .controls .volume-container:hover .volume-slider {
  left: -123px;
  width: 120px;
}

</style>
@endpush
