@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                @include($activeTemplate.'components.sidebar')
            </div>
            <div class="col-xl-9 ">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="dashboard-body border-box">


                                    @if ($episode->link == null)
                                        @if($extension == "mp3")
                                        <div class="music-player">
                                            <div class="cover">
                                                <img src="{{getImage(getFilePath('podcastEpisode').'/' . @$episode->image_path .'/'. @$episode->image )}}" alt="">
                                            </div>
                                            <div class="titre mt-3">
                                                <h1 class="audio_header">{{__($episode->title)}}</h1>
                                                <p class="description">
                                                    {{Illuminate\Support\Str::limit(@$episode->description,120)}}
                                                </p>

                                            </div>
                                            <div class="lecteur">

                                                <audio style="width: 100%;" class="fc-media">
                                                    <source src="{{getImage(getFilePath('podcastEpisode').'/' .$episode->file_path .'/'. $episode->filename )}}" type="audio/mp3"/>
                                                </audio>


                                            </div>
                                        </div>
                                        @elseif($extension == "mp4")


                                        <div class="latest-episode-item__thumb position-relative">
                                            <div class="">
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
                                        </div>
                                        <div class="latest-episode-item__content mt-4">
                                            <h5>{{__($episode->title)}}</h5>
                                            <p>{{Illuminate\Support\Str::limit(@$episode->description,120)}}</p>
                                        </div>


                                        @endif

                                    @else

                                    <div class="latest-episode-item__thumb position-relative">
                                        <div class="">
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
                                                    <a class="play-video popup_video" data-fancybox="" href="{{$episode->link}}">
                                                        <span class="play-btn"> <i class="fa fa-play"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="latest-episode-item__content mt-4">
                                        <h5>{{__($episode->title)}}</h5>
                                        <p>{{Illuminate\Support\Str::limit(@$episode->description,120)}}</p>
                                    </div>
                                    @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>

.audio_header {
    margin: 0;
    font-size: 17px;
    font-weight: 500;
    color: #ffffff;
    padding: 0 10%;
}
.description{
    padding: 0 10%;
    color: #cdcdcd;
}


.music-player {
    display: block;
    position: relative;
    width: 500px;
    min-height: 600px;
    margin: auto;
    padding-bottom:50px;
    border-radius: 0 0 10px 10px;
    background: transparent linear-gradient(to bottom,rgb(251 251 255 / 90%) 50%,rgb(0 102 204) 70%) repeat scroll 0 0;
    box-shadow: 1px 10px 20px 5px #ececec;
}
.cover {
    float: left;
    width: 100%;
    height: 66%;
}
.cover img {
    display: block;
    top: 8%;
    left: 14%;
    width: 100%;
    margin: auto;
    text-align: center;
    height: 297px;
    object-fit: cover;
    border-radius: 10px 10px 0px 0px;
}
.titre {
    float: left;
    width: 100%;
}
.lecteur {
    width: 100%;
    display: block;
    height: auto;
    position: relative;
    float: left;
}
.mejs__button>button:focus {
    outline: 0px dotted #999;
}
.mejs__container {
    position: relative;
    background-color: transparent;
    min-width: auto !important;
}
.mejs__controls {
    padding: 0 10%;
    background: transparent !important;
    display: block;
    position: relative;
}
.mejs__controls div {
    display: block;
    float: left;
    position: relative;
}
.mejs__controls .mejs__playpause-button {
    position: absolute !important;
    right: 84%;
    top: 185%;
    width: 40px;
}
.mejs__controls .mejs__playpause-button button {
    display: block;
    width: 40px;
    height: 40px;
    padding: 0;
    border: 0;
    font-family: FontAwesome;
    font-size: 23px;
    color: #ffffff;
    background: transparent;
    padding: 0;
    margin: 0;
}
.mejs__controls .mejs__play button:before{
    content:"\f04b";
}
.mejs__controls .mejs__pause button:before{
    content:"\f04c";
}
.mejs__controls .mejs__volume-button button {
    display: block;
    width: 40px;
    height: 40px;
    padding: 0;
    border: 0;
    font-family: FontAwesome;
    font-size: 20px;
    color: #ffffff;
    background: transparent;
    margin: 0;
    padding: 0;
}
.mejs__controls .mejs__mute button:before {
    content: "\f028";
}
.mejs__controls .mejs__unmute button:before {
    content: "\f026";
}
.mejs__button.mejs__playpause-button.mejs__replay button {
    display: block;
    width: 40px;
    height: 40px;
    padding: 0;
    border: 0;
    font-family: FontAwesome;
    font-size: 20px;
    color: #ffffff;
    background: transparent;
    margin: 0;
    padding: 0;
}
.mejs__button.mejs__playpause-button.mejs__replay button:before {
    content: "\f04b";
}
.mejs__controls .mejs__time {
    width: 100%;
    margin-top: 7%;
    margin-bottom: 3%;
    color: #fff;
    height: auto;
    padding: 0;
    overflow: visible;
    min-width: 100%;
}
.mejs__controls .mejs__time span {
    font-size: 15px;
}
.mejs__controls span.mejs__duration {
    float: right;
    text-align: right;
    color: #ccc;
}
.mejs__controls span.mejs__currenttime {
    font-weight: 700;
    float: left;
}
.mejs__controls .mejs__time-rail {
    width: 100%;
    margin: 0;
}
.mejs__controls .mejs__time-rail span {
    position: absolute;
    top: 0;
    width: 100%;
    height: 4px;
    border-radius: 50px;
    cursor: pointer;
}
.mejs__controls .mejs__time-rail .mejs__time-loaded {
    background: rgba(255,255,255,0.2);
}
.mejs__controls .mejs__time-rail .mejs__time-float {
    display: none;
    top: -40px;
    width: 40px;
    height: 25px;
    margin-left: 0px;
    text-align: center;
    font-size: 10px;
    background: #fff;
    border: 0;
}
.mejs__controls .mejs__time-rail .mejs__time-float-current {
    display: block;
    position: relative;
    top: 0;
    margin: 0;
    line-height: 26px;
    color: #100d28;
}
.mejs__controls .mejs__time-rail .mejs__time-float-corner {
    top: auto;
    bottom: -9px;
    left: 50%;
    width: 0;
    height: 0;
    border-top: 6px solid #fff;
    border-right: 6px solid transparent;
    border-left: 6px solid transparent;
}
.mejs__controls .mejs__time-rail .mejs__time-current {
    background: #5BBB95 none repeat scroll 0 0;
}
.mejs__controls .mejs__time-handle {
    display: none;
}
.mejs__controls .mejs__volume-button {
    position: relative;
    position: absolute !important;
    top: 74px;
    right: 76%;
    width: 40px;
    height: 40px;
}
.mejs__controls .mejs__horizontal-volume-slider {
    display: block;
    position: absolute !important;
    position: relative;
    top: 70px;
    right: 10%;
    width: 60px;
    height: 4px;
    margin-top: 18px;
    border-radius: 50px;
    line-height: 11px;
}
.mejs__controls .mejs__horizontal-volume-slider .mejs__horizontal-volume-total,
.mejs__controls .mejs__horizontal-volume-slider .mejs__horizontal-volume-current {
    position: absolute;
    top: 1px;
    left: -260px;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.1);
}
.mejs__controls .mejs__horizontal-volume-slider .mejs__horizontal-volume-current {
    background: #fff;
}



[type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
    cursor: pointer;
    /* padding: 30px; */
    z-index: 99;
}


</style>

@endpush

@push('script')
<script>
    var audio = {
    init: function() {        
    var $that = this;        
        $(function() {            
            $that.components.media();        
        });    
    },
    components: {        
        media: function(target) {            
            var media = $('audio.fc-media', (target !== undefined) ? target : 'body');            
            if (media.length) {                
                media.mediaelementplayer({                    
                    audioHeight: 40,
                    features : ['playpause', 'current', 'duration', 'progress', 'volume', 'tracks', 'fullscreen'],
                    alwaysShowControls      : true,
                    timeAndDurationSeparator: '<span></span>',
                    iPadUseNativeControls: true,
                    iPhoneUseNativeControls: true,
                    AndroidUseNativeControls: true                
                });            
            }        
        },
            
    },
};
audio.init();
</script>

@endpush

