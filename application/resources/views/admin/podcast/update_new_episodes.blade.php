@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.podcast.new.episode.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mt-2">
                                <h5 class="ps-3">@lang('New Episode')</h5>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="fw-bold">@lang('Add new podcast')</label>
                                                <label class="switch m-0">
                                                    <input type="checkbox" class="toggle-switch" id="add_new_podcast" name="add_new_podcast" value="{{old('add_new_podcast')}}" >
                                                    <span class="slider round"></span>
                                                </label>                            
                                            </div>
                                        </div>

                                        <div class="col-lg-6" id="previous_podcast">
                                            <div class="form-group">
                                                <label for="podcast_id" class="font-weight-bold">@lang('Podacst')</label>
                                                <select name="podcast_id" id="podcast_id" class="form-control">
                                                    @foreach($podcast as $item)
                                                    <option value="{{@$item->id}}">{{@$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                        <div class="row">

                                            <div class="col-lg-6 col-md-6 new_podcast">
                                                <div class="form-group">
                                                    <label for="new_podcast_title" class=" font-weight-bold required">@lang('Podcast Title'):</label>
                                                        <input type="text" class="form-control" name="new_podcast_title" id="new_podcast_title" value='{{old('new_podcast_title')}}'>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6 col-md-6 new_podcast">
                                                <div class="form-group">
                                                    <label  class="font-weight-bold required">@lang('Podcast Category'):</label>
                                                    <select name="new_podcast_category_id" id="new_podcast_category_id" class="form-control">
                                                        <option value="" selected="">@lang('Select One')
                                                        </option>
                                                        @foreach($podcastCategory as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 new_podcast">
                                                <div class="form-group">
                                                    <label>@lang('Podcast Description')</label>
                                                    <textarea class="form-control" rows="10" cols="30"
                                                        name="new_podcast_description" id="new_podcast_description"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group new_podcast">
                                                <label> @lang('Monthly Price'):</label>
                                                <input type="number" id="monthly_price" class="form-control" name="monthly_price" placeholder="@lang('Monthly Price')" step="any">
                                            </div>
                        
                                            <div class="form-group new_podcast">
                                                <label> @lang('Yearly Price'):</label>
                                                <input type="number" class="form-control" id="yearly_price" name="yearly_price" placeholder="@lang('Yearly Price')" step="any">
                                            </div>

                                            <div class="form-group new_podcast">
                                                <label for="image">@lang('Podcast Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                                                <input type="file" class="form-control" id="podcast_image"  name="podcast_image">
                                            </div>

                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="title" class="font-weight-bold">@lang('Episode Title')</label>
                                                <input type="text" name="title" id="title" value="{{old('title')}}"
                                                    class="form-control " placeholder="@lang('Enter episode title')"
                                                    maxlength="255" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>@lang('Description')</label>
                                                <textarea class="form-control" rows="10" cols="30"
                                                    name="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label for="image">@lang('Episode Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                                                <input type="file" class="form-control" id="image"  name="image" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="file-type-select">@lang('File Type')</label>
                                                <select class="form-control" id="file-type-select" name="file_type_select" required>
                                                    <option value="1" {{ old('file_type_select')== 1 ? 'selected':'' }}>@lang('Link / URL')</option>
                                                    <option value="2" {{ old('file_type_select')== 2 ? 'selected':'' }}>@lang('Audio(From Device)')</option>
                                                    <option value="3" {{ old('file_type_select')== 3 ? 'selected':'' }}>@lang('Video(From Device)')</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8" id="link_url">
                                                <label for="link" class="font-weight-bold">@lang('Video
                                                    Link')</label>
                                                <input type="url" name="link" pattern="https?://.*" id="link"
                                                            value="{{old('link')}}" class="form-control "
                                                            placeholder="@lang('https://www.youtube.com/embed/example')"
                                                            maxlength="255">
                                            </div>
                                            <div class="form-group col-md-8 d-none" id="from_browser">
                                                <label id="file-label" for="file-input">@lang('File type')</label>
                                                <input id="file-input" class="form-control" type="file" name="filename" accept=".mp3" />
                                            </div>
                                        </div>



                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="fw-bold">@lang('Is Premium')</label>
                                                <label class="switch m-0">
                                                    <input type="checkbox" class="toggle-switch"  name="is_premium" >
                                                    <span class="slider round"></span>
                                                </label>                            
                                            </div>
                                        </div>
                                        


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-end">
                        <div class="col-lg-12 ">
                            <div class="form-group float-end p-3">
                                <button type="submit" class="btn btn--primary btn-block btn-lg"><i
                                        class="fa fa-fw fa-paper-plane"></i> @lang('Create Episode')</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    @endsection



    @push('script')
        <script>
            (function ($) {
                "use strict";

                $("#add_new_podcast").on('click', function () {
                    if($(this).is(":checked"))
                    {
                        $('.new_podcast').removeClass('d-none');
                        $('#previous_podcast').addClass('d-none');
                        $('#podcast_id').removeAttr('required');
                        $('#podcast_id').val('');

                        $('#new_podcast_title').attr('required', true);
                        $('#new_podcast_description').attr('required', true);
                        $('#new_podcast_category_id').attr('required', true);
                        $('#podcast_image').attr('required', true);

                    }else{
                        $('#previous_podcast').removeClass('d-none');
                        $('#podcast_id').attr('required', true);

                        $('.new_podcast').addClass('d-none');
                        $('#new_podcast_title').attr('required', false);
                        $('#new_podcast_description').attr('required', false);
                        $('#new_podcast_category_id').attr('required', false);
                        $('#podcast_image').attr('required', false);
                    }
                });

                if($("#add_new_podcast").is(":checked"))
                {
                    $('.new_podcast').removeClass('d-none');
                    $('#previous_podcast').addClass('d-none');
                    $('#podcast_id').removeAttr('required');
                    $('#podcast_id').val('');

                    $('#new_podcast_title').attr('required', true);
                    $('#new_podcast_description').attr('required', true);
                    $('#new_podcast_category_id').attr('required', true);
                }else{
            
                    $('.new_podcast').addClass('d-none');
                    $('#previous_podcast').removeClass('d-none');
                    $('#podcast_id').attr('required', true);

                    $('#new_podcast_title').attr('required', false);
                    $('#new_podcast_description').attr('required', false);
                    $('#new_podcast_category_id').attr('required', false);

                }



                $('#file-type-select').change(function(){
                    var type = $(this).val();
                    console.log(type);
                    if (type == 1) {
                        $("#link_url").removeClass('d-none');
                        $("#from_browser").addClass('d-none');
                        $("#file-label").addClass('d-none');
                        $("#file-input").addClass('d-none');
                        $('#file-input').attr('required', false);
                        $('#link').attr('required', true);
                    }
                     else if( type == 2) {
                        $("#link_url").addClass('d-none');
                        $("#file-label").removeClass('d-none');
                        $("#file-input").removeClass('d-none');
                        $("#from_browser").removeClass('d-none');
                        $('#file-label').text('File type audio and .mp3');
                        $('#file-input').attr('accept', '.mp3');
                        $('#file-input').attr('required', true);
                        $('#link').attr('required', false);
                    } else if( type == 3){
                        $("#from_browser").removeClass('d-none');
                        $("#file-label").removeClass('d-none');
                        $("#file-input").removeClass('d-none');
                        $("#link_url").addClass('d-none');
                        $('#file-label').text('File type video and .mp4');
                        $('#file-input').attr('accept', '.mp4');
                        $('#file-input').attr('required', true);
                        $('#link').attr('required', false);
                    }
                }).change();

            })(jQuery);
        </script>
    @endpush



