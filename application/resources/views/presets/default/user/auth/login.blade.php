@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="account py-60">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Sign In Your Account') </h3>
                            <p class="account-form__desc">@lang('Please input your username and password and login to your account to get access to your dashboard.')</p>
                        </div>
                        <form action="{{route('user.login')}}" method="POST" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="username" class="form--label"> @lang('Username or Email')</label>
                                        <input type="text" name="username" value="{{old('username')}}" class="form--control" id="username" placeholder=" @lang('Username')">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label for="your-password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <sapn class="input--icon">
                                            <i class="fa-solid fa-eye-slash  toggle-password-change"  data-target="password"></i>
                                        </sapn>
                                        <input class="form-control form--control" name="password" type="password" id="your-password" placeholder="Enter Your Password">
                                    </div>
                                </div>

                                <x-captcha></x-captcha>

                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">
                                            <input class="form-check-input" name="remember" type="checkbox" value="" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">@lang('Remember me') </label>
                                        </div>
                                        <a href="{{route('user.password.request')}}" class="forgot-password text--base">@lang('Forgot Your Password?')</a>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Sign In')</button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Don\'t Have An Account?') <a href="{{route('user.register')}}" class="have-account__link text--base">@lang('Create Account')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



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
