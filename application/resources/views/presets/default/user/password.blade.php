@extends($activeTemplate.'layouts.master')

@section('content')

<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                @include($activeTemplate.'components.sidebar')
            </div>
            <div class="col-xl-9 col-lg-12">
                <div class="dashboard-body">
                    <div class="row gy-4">
                        <div class="col-xl-10 col-lg-10">
                            <div class="user-profile">
                                <form action="" method="post">
                                    @csrf
                                    <div class="col-sm-12">
                                        <label for="current_password" class="form--label">@lang('Current Password')</label>
                                        <div class="input-group">
                                            <sapn class="input--icon">
                                                <i class="fa-solid fa-eye-slash  toggle-password-change"  data-target="current_password"></i>
                                            </sapn>
                                            <input class="form-control form--control" name="current_password" type="password" id="current_password">
                                        </div>
                                    </div>


                                    <div class="col-sm-12 mb-2">
                                        <label for="password" class="form--label">@lang('Confirm Password')</label>
                                        <div class="input-group">
                                            <sapn class="input--icon">
                                                <i class="fa-solid fa-eye-slash  toggle-password-change"  data-target="password"></i>
                                            </sapn>
                                            <input class="form-control form--control" name="password" type="password" id="password" required autocomplete="current-password">

                                            @if($general->secure_password)
                                            <div class="input-popup">
                                                <p class="error lower">@lang('1 small letter minimum')</p>
                                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                                <p class="error number">@lang('1 number minimum')</p>
                                                <p class="error special">@lang('1 special character minimum')</p>
                                                <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-sm-12 mb-2">
                                        <label for="current_password" class="form--label">@lang('Confirm Password')</label>
                                        <div class="input-group">
                                            <sapn class="input--icon">
                                                <i class="fa-solid fa-eye-slash  toggle-password-change"  data-target="password_confirmation"></i>
                                            </sapn>
                                            <input class="form-control form--control" name="password_confirmation" type="password" id="password_confirmation" required autocomplete="current-password">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });

        @endif
    })(jQuery);
</script>
@endpush

@push('script')
    <script>
      "use strict";
        (function ($) {

            $(".toggle-password-change").click(function() {
                var targetId = $(this).data("target");
                var target = $("#" + targetId);
                var icon = $(this);
                if (target.attr("type") === "password") {
                    target.attr("type", "text");
                    icon.removeClass("fa-eye-slash");
                    icon.addClass("fa-eye");
                } else {
                    target.attr("type", "password");
                    icon.removeClass("fa-eye");
                    icon.addClass("fa-eye-slash");
                }
            });

        })(jQuery);

    </script>
@endpush
