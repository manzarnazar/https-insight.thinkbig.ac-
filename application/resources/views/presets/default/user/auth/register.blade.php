@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $policyPages = getContent('policy_pages.element',false,null,true);
@endphp

<section class="account py-60">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-6">

                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Sign Up Your Account') </h3>
                            <p class="account-form__desc">@lang('Please Provide your valid informations to register!')</p>
                        </div>
                        <form action="{{route('user.register')}}" method="POST">
                            @csrf
                            @if(session()->get('reference') != null)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                    <input type="text" name="referBy" id="referenceBy" class="form-control form--control" value="{{session()->get('reference')}}" readonly>
                                </div>
                            </div>
                            @endif

                            <div class="row gy-3">
                                <div class="col-sm-12">
                                     <div class="form-group">
                                        <label for="username" class="form--label"> @lang('Username')</label>
                                        <input type="text" class="form-control form--control checkUser" name="username" id="name" value="{{ old('username') }}" required placeholder=" @lang('Username')">
                                        <small class="text-danger usernameExist"></small>
                                     </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="form--label">@lang('Email Address')</label>
                                        <input type="email" class="form-control form--control checkUser" name="email" id="email" placeholder="@lang('Email Address')">
                                     </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form--label">@lang('Country')</label>
                                        <div class="col-sm-12">
                                            <select name="country" class="select form-control form--control">
                                                @foreach($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                                @endforeach
                                            </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                        <label class="form--label">@lang('Phone')</label>

                                        <div class="input-group ">
                                            <span class="input-group-text mobile-code">
                                            </span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control mobile-code checkUser" required>
                                        </div>
                                        <small class="text-danger mobileExist"></small>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <sapn class="input--icon">
                                            <i class="fa-solid fa-eye-slash toggle-password-change" data-target="password"></i>
                                        </sapn>
                                        <input id="password" name="password" type="password"  class="form-control form--control checkUser">
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
                                <div class="col-sm-6">
                                    <label for="password_confirmation" class="form--label">@lang('Confirm Password')</label>
                                    <div class="input-group">
                                        <sapn class="input--icon">
                                            <i class="fa-solid fa-eye-slash toggle-password-change" data-target="password_confirmation"></i>
                                        </sapn>
                                        <input id="password_confirmation" name="password_confirmation" type="password"  class="form-control form--control checkUser">
                                    </div>
                                </div>
                                @if ($general->agree)
                                <div class="col-sm-12">
                                    <div class="form--check">
                                        <input class="d-none" type="checkbox" value="" id="remember">
                                        <div class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                            <label for="agree">@lang('I agree with') @foreach($policyPages as $policy) <a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}">{{ __($policy->data_values->title) }}</a> @if(!$loop->last), @endif @endforeach</label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Sign Up')</button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Already Have An Account?') <a href="{{route('user.login')}}" class="have-account__link text--base">@lang('Login Now')</a></p>
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

<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="las la-times"></i>
        </span>
      </div>
      <div class="modal-body">
        <h6 class="text-center">@lang('You already have an account please Login ')</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
        <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
      </div>
    </div>
  </div>
</div>
@endsection
@push('style')
<style>
    .country-code .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
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


            @if($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });

                $('[name=password]').focus(function () {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function () {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });


            @endif

            $('.checkUser').on('focusout',function(e){
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response.data != false){
                    $(`.${response.type}Exist`).text(`${response.type} already exist`);
                  }else{
                    $(`.${response.type}Exist`).text('');
                  }
                });
            });
        })(jQuery);

    </script>
@endpush
