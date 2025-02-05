<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>

    @include('includes.seo')



    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{asset('assets/common/css/all.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}" />

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



    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/media-player.css') }}">

    @stack('style-lib')

    @stack('style')


    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>

<body>
    <div id="loading">
        <div id="loading-center">
           <div id="loading-center-absolute">
              <div class="object" id="object_one"></div>
              <div class="object" id="object_two"></div>
              <div class="object" id="object_three"></div>
              <div class="object" id="object_four"></div>
           </div>
        </div>
     </div>

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
    <div class="page-wrapper">
        @yield('content')
    </div>

    @include($activeTemplate.'components.footer')

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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

    <script src="{{ asset($activeTemplateTrue.'js/jquery.validate.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/mediaelement-and-player.min.js') }}"></script>



    @stack('script-lib')

    @include('includes.notify')

    @include('includes.plugins')


    @stack('script')


    <script>
        (function ($) {
            "use strict";
            $(".langSel").on("change", function () {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

        })(jQuery);

    </script>


    <script>
        (function ($) {
            "use strict";

            $('form').on('submit', function () {
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            });

            var inputElements = $('[type=text],[type=password],select,textarea');
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


            $('.showFilterBtn').on('click',function(){
                $('.responsive-filter-card').slideToggle();
            });


            let headings = $('.table th');
            let rows = $('.table tbody tr');
            let columns
            let dataLabel;

            $.each(rows, function (index, element) {
                columns = element.children;
                if (columns.length == headings.length) {
                    $.each(columns, function (i, td) {
                    dataLabel = headings[i].innerText;
                    $(td).attr('data-label', dataLabel)
                    });
                }
            });

        })(jQuery);

    </script>

</body>

</html>
