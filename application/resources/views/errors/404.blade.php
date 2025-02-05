@php
    $pages          = App\Models\Page::all();
    $contact        = getContent('contact_us.content',true);
    $socialIcons     = getContent('social_icon.element',false);
    $policyPages    = getContent('policy_pages.element',false,null,true);
    $cookie         = getContent('cookie.data',true);

@endphp
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> @lang('WavePodes')</title>
    <!-- Favicon -->
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}"/>

    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset($activeTemplateTrue.'/images/logo/favicon.png')}}">
    <!-- Bootstrap -->

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <!-- Custom Animation -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom-animation.css')}}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
    <!-- line awesome -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
</head>
<body>

<!--==================== Preloader Start ====================-->
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
<!--==================== Preloader End ====================-->

<!--==================== Overlay Start ====================-->
<div class="body-overlay"></div>
<div class="body-overlay-search"></div>
<!--==================== Overlay End ====================-->

<!--==================== Sidebar Overlay End ====================-->
<div class="sidebar-overlay"></div>
<!--==================== Sidebar Overlay End ====================-->

<!-- ==================== Scroll to Top End Here ==================== -->
<a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
<!-- ==================== Scroll to Top End Here ==================== -->

<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb bg-img">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb__wrapper">
                    <h2 class="breadcumb__title">@lang('404 Error')</h2>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item"><a href="{{route('home')}}" class="breadcumb__link"> <i class="las la-home"></i> @lang('Home')</a> </li>
                        <li class="breadcumb__item"><i class="fas fa-arrow-right"></i></li>
                        <li class="breadcumb__item"> <span class="breadcumb__item-text"> @lang('404 Error') </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->

<section class="account py-80">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="error-wrap text-center">
                        <figure>
                            <img src="{{asset($activeTemplateTrue.'images/thumbs/404.png')}}" alt="error_img">
                        </figure>
                        <h2 class="error-wrap__title">@lang('Page Not Found')</h2>
                        <p class="error-wrap__desc">@lang('Page you are looking have been deleted or does not exist')</p>
                        <a href="{{route('home')}}" class="btn btn--base">@lang('Go Home')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area section-bg-light bg-img">
    <div class="pb-30 pt-120">
        <div class="container">
            <div class="row justify-content-center gy-5">
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{route('home')}}"> <img src="{{getImage('assets/images/general/logo.png')}}" alt=""></a>
                        </div>
                        <p class="footer-item__desc"> {{Illuminate\Support\Str::limit(__(@$contact->data_values->description), 150)}} </p>
                        <ul class="social-list">
                            @foreach ($socialIcons as $item)
                                <li class="social-list__item"><a href="" class="social-list__link text-white"> @php
                                    echo $item->data_values->social_icon;
                                @endphp </a> </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-xl-1 d-xl-block d-none"></div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Userful Link')</h5>
                        <ul class="footer-menu">
                            @foreach ($pages as $page)
                            <li class="footer-menu__item"><a href="{{route('pages',$page->slug)}}" class="footer-menu__link">{{__(@$page->name)}}</a></li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Important Link')</h5>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $item)
                            <li class="footer-menu__item"><a href="{{route('policy.pages',[slug($item->data_values->title),$item->id])}}" class="footer-menu__link">{{__($item->data_values->title)}} </a></li>
                            @endforeach
                            <li class="footer-menu__item"><a href="{{route('cookie.policy')}}" class="footer-menu__link">@lang('Cookie & Policy') </a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-xl-1 d-xl-block d-none"></div>
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Contact With Us')</h5>
                        <ul class="footer-contact-menu">
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{__(@$contact->data_values->address)}}</p>
                                </div>
                            </li>
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{__($contact->data_values->email_address)}}</p>
                                </div>
                            </li>
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{__($contact->data_values->contact_number)}} </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-md-12 text-center text-white">
                    <div class="bottom-footer-text text-white">  @php  echo $contact->data_values->website_footer; @endphp </div>
                </div>
            </div>
        </div>
    </div>

  </footer>


  <!-- ==================== Footer End Here ==================== -->


<!-- Jquery js -->
<script src="{{asset('assets/common/js/jquery-3.6.4.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>

<!-- Popper js -->
<script src="{{asset($activeTemplateTrue.'js/popper.min.js')}}"></script>

<!-- Slick js -->
<script src="{{asset($activeTemplateTrue.'js/slick.min.js')}}"></script>
<!-- Magnific Popup js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
<!-- Viewport js -->
<script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>

 <!-- main js -->
 <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>
</body>
</html>
