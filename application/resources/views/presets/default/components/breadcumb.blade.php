<section class="breadcumb bg-img">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb__wrapper">
                    <h2 class="breadcumb__title">{{__($pageTitle)}}</h2>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item"><a href="{{route('home')}}" class="breadcumb__link"> <i class="las la-home"></i> @lang('Home')</a> </li>
                        <li class="breadcumb__item"><i class="fas fa-arrow-right"></i></li>
                        <li class="breadcumb__item"> <span class="breadcumb__item-text"> {{__($pageTitle)}} </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
