@php
    $pages          = App\Models\Page::all();
    $contact        = getContent('contact_us.content',true);
    $socialIcons    = getContent('social_icon.element',false);
    $policyPages    = getContent('policy_pages.element',false,null,true);
    $cookie         = getContent('cookie.data',true);

@endphp
<footer class="footer-area section-bg-light bg-img">
    <div class="pb-30 pt-120">
        <div class="container">
            <div class="row justify-content-center gy-5">
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{route('home')}}"> <img src="{{getImage('assets/images/general/logo.png')}}" alt=""></a>
                        </div>
                        <p class="footer-item__desc">{{ Illuminate\Support\Str::limit(__(@$contact->data_values->description), 150) }}</p>
                        <ul class="social-list">
                            @foreach ($socialIcons as $item)
                                <li class="social-list__item"><a href="{{$item->data_values->url}}" class="social-list__link text-white" target="_blank"> @php
                                    echo $item->data_values->social_icon;
                                @endphp </a> </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-xl-1 d-xl-block d-none"></div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Important Link')</h5>
                        <ul class="footer-menu">
                            
                            @foreach ($policyPages as $link)
                            <li class="footer-menu__item"><a href="{{ route('policy.pages',[slug($link->data_values->title),$link->id]) }}" class="footer-menu__link">{{ __($link->data_values->title) }}</a></li>
                            @endforeach
                            <li class="footer-menu__item"><a href="{{route('cookie.policy')}}" class="footer-menu__link">@lang('Cookie & Policy') </a></li>


                        </ul>
                    </div>
                </div>
                <div class="col-xl-1 d-xl-block d-none"></div>
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">{{__($contact->data_values->title)}}</h5>
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
                                    <p>{{__(@$contact->data_values->email_address)}}</p>
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
