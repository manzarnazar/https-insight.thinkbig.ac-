<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('includes.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <!-- Custom Animation -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom-animation.css')}}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css?v=1')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/icono.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    @stack('style-lib')

    @stack('style')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>
<body>

    {{-- <div id="loading">
        <div id="loading-center">
           <div id="loading-center-absolute">
              <div class="object" id="object_one"></div>
              <div class="object" id="object_two"></div>
              <div class="object" id="object_three"></div>
              <div class="object" id="object_four"></div>
           </div>
        </div>
     </div> --}}

    <div class="body-overlay"></div>
    <div class="body-overlay-search"></div>

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
    <!-- ==================== Scroll to Top End Here ==================== -->

     @include($activeTemplate.'components.header')
     @if(request()->route()->uri !='/')
        @include($activeTemplate.'components.breadcumb')
     @endif

    @yield('content')

    @include($activeTemplate.'components.footer')

@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card cookie text-center hide" >
      <div class="cookies-card__icon bg--base">
        <i class="las la-cookie-bite"></i>
      </div>
      <p class="mt-4 cookies-card__content text-dark">{{ $cookie->data_values->short_desc }} <a class="text-white" href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
      <div class="cookies-card__btn mt-4">
        <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
      </div>
    </div>
  <!-- cookies dark version end -->
  @endif



<script src="{{asset('assets/common/js/jquery-3.6.4.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/popper.min.js')}}"></script>
<!-- Slick js -->
<script src="{{asset($activeTemplateTrue.'/js/slick.min.js')}}"></script>
<!-- Magnific Popup js -->
<script src="{{asset($activeTemplateTrue.'/js/jquery.magnific-popup.min.js')}}"></script>
<!-- Viewport js -->
<script src="{{asset($activeTemplateTrue.'/js/viewport.jquery.js')}}"></script>

 <!-- main js -->
 <script src="{{asset($activeTemplateTrue.'/js/main.js')}}"></script>


@stack('script-lib')

@stack('script')

@include('includes.plugins')

@include('includes.notify')


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        var inputElements = $('input,select');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });

    })(jQuery);
</script>

</body>
</html>
