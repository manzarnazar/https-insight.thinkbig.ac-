@php
    $content = getContent('subscribe.content',true);

@endphp

<section class="subscribe-section section-bg py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="subscribe-wrap text-center">
                    <h2> {{__(@$content->data_values->heading)}} </h2>
                    <p> {{__(@$content->data_values->subheading)}} </p>
                    <form action="{{route('subscribe')}}" method="post">
                        @csrf
                        <div class="subscribe-wrap__input">
                            <input type="email" name="email" class="form--control" placeholder="@lang('Enter Your Mail')">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
