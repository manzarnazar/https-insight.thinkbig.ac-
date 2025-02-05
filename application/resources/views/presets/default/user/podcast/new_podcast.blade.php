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
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('New Podcast') </h3>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title" class="form--label">@lang('Title')</label>
                                        <input type="text" class="form--control" name="title" id="title" placeholder="@lang('Podcast Title')">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="category" class="form--label">@lang('Category')</label>
                                        <select name="category_id" class="form--control" id="">
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{__($item->name)}}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description" class="form--label">@lang('Monthly Price')</label>
                                        <input type="number" class="form--control" name="monthly_price" id="">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description" class="form--label">@lang('Yearly Price')</label>
                                        <input type="number" class="form--control" name="yearly_price" id="">

                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description" class="form--label">@lang('Description')</label>
                                        <textarea name="description" class="form--control" id="description" cols="30" rows="10" placeholder="@lang('write something ...')"></textarea>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="formFile" class="form-label">@lang('Podcast Image') (@lang('.jpg, .png, .jpeg'))</label>
                                    <input type="file" class="form--control" id="image"  name="image" required accept=".jpeg, .png,.jpg">

                                </div>

                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
