@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="account py-60">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Forgot Your Password') </h3>

                        </div>
                        <form action="{{ route('user.password.email') }}" method="POST">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="form--label">@lang('Email Address')</label>
                                        <input type="text" class="form--control form--control" name="value" value="{{ old('value') }}" required autofocus="off">

                                     </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Forgot Password')</button>
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
