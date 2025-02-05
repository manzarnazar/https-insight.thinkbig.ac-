@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                @include($activeTemplate.'components.sidebar')
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="dashboard-body">
                    <div class="row gy-4 justify-content-center">
                        <div class="col-lg-12 ">
                            <div class="dashboard_profile text-center">
                                <div class="dashboard_profile__details">
                                    <div class="dashboard_profile_wrap">
                                        <div class="profile_photo mb-2">
                                            <img id="imageUpload" src="{{ getImage(getFilePath('userProfile').'/'.auth()->user()->image,getFileSize('userProfile')) }}" alt="agent">
                                        </div>
                                        <div class="profile-details">
                                            <ul>
                                                <li>
                                                    <p><span>@lang('Full Name'):</span>{{auth()->user()->firstname}} {{auth()->user()->lastname}}</p>
                                                    <p><span>@lang('Email'):</span>{{auth()->user()->email}}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="user-profile">
                                <form class="register" action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-lg-12">
                                            <h4 class="mb-1">@lang('Personal Information')</h4>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="first_name" class="form--label required"> @lang('Firstname')</label>
                                                <input type="text" class="form--control" id="first_name" type="text" name="firstname" value="{{$user->firstname}}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="last_name" class="form--label required"> @lang('Lastname')</label>
                                                <input type="text" class="form--control" id="last_name" type="text" name="lastname" value="{{$user->lastname}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username" class="form--label required"> @lang('Username')</label>
                                                <input type="text" class="form--control" id="username" placeholder="@lang('Username')" name="username" value="{{$user->username}}" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username" class="form--label required">@lang('Email Address')</label>
                                                <input type="email" class="form--control" id="email" placeholder="@lang('Email Address')" name="email" value="{{$user->email}}" readonly required>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username" class="form--label required">@lang('Mobile')</label>
                                                <input type="text" class="form--control" id="email"  name="mobile" value="{{@$user->mobile}}" readonly required>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="country" class="form--label">@lang('Country')</label>
                                                <input type="text" class="form--control" id="country" name="country" value="{{@$user->address->country}}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="state" class="form--label">@lang('State')</label>
                                                <input type="text" class="form--control" id="state" name="state" value="{{@$user->address->state}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="city" class="form--label">@lang('City')</label>
                                                <input type="text" class="form--control" id="city" name="city" value="{{@$user->address->city}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="zip" class="form--label">@lang('Zip Code')</label>
                                                <input type="text" class="form--control" id="zip" name="zip" value="{{@$user->address->zip}}" step="any">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="designation" class="form--label">@lang('Designation')</label>
                                                <input type="text" class="form--control" id="designation" name="designation" value="{{@$user->designation}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="facebook_url" class="form--label">@lang('Facebook Url')</label>
                                                <input type="text" class="form--control" id="facebook_url" name="facebook_url" value="{{@$user->facebook_url}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="twitter_url" class="form--label">@lang('Twitter Url')</label>
                                                <input type="text" class="form--control" id="twitter_url" name="twitter_url" value="{{@$user->twitter_url}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="linkedin_url" class="form--label">@lang('LinkedIn Url')</label>
                                                <input type="text" class="form--control" id="linkedin_url" name="linkedin_url" value="{{@$user->linkedin_url}}">
                                            </div>
                                        </div>

                                        <div class="row mt-5 justify-content-end">
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                            </div>
                                        </div>
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
