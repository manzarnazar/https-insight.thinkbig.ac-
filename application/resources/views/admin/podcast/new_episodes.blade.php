@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form id="upload-form" method="POST" enctype="multipart/form-data">
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
                                            <input type="file" class="form-control" id="podcast_image"  name="podcast_image" accept=".jpg,.jpeg,.png">
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
                                            <input type="file" class="form-control" id="image"  name="image" accept=".jpg,.jpeg,.png" required>
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

                <div class="progress" style="display: none">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
            </div>
        </div>

    </div>

    @endsection


    @push('script')
        <script src="{{asset('assets/admin/js/jquery.form.min.js')}}"></script>

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


                $('#upload-form').submit(function(e) {
                    e.preventDefault();
                    
                    var fileInput = $('#file-input');
                    var file_type_select = $('#file-type-select').val();
                    var progressBar = $('.progress-bar');
                    var errorMessage = $('#error-message');

                    if(file_type_select != 1){
                        if (fileInput[0].files.length === 0) {
                            Swal.fire({
                                title: 'Please select a file.',
                                icon: 'error',
                                position: 'top-right',
                                customClass: {
                                    heightAuto: false,
                                    popup: 'swal2-toast',
                                    icon: 'swal2-icon',
                                    title: 'swal2-title',
                                },
                                width: '350px',
                                padding: '20px',
                                heightAuto: false,
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                
                            });
                            return;
                        }



                        var file = fileInput[0].files[0];
                    
                        if (file.size > 100 * 1024 * 1024) {
                            Swal.fire({
                                title: 'File size exceeds the limit of 100 MB.',
                                icon: 'error',
                                position: 'top-right',
                                customClass: {
                                    heightAuto: false,
                                    popup: 'swal2-toast',
                                    icon: 'swal2-icon',
                                    title: 'swal2-title',
                                },
                                width: '350px',
                                padding: '20px',
                                heightAuto: false,
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                
                            });
                            return;
                        }


                    }
                    
                    var add_new_podcast = $('#add_new_podcast').val();

                    if(add_new_podcast == 1)
                    {
                        var formData = new FormData();
                        formData.append('add_new_podcast', $('#add_new_podcast').val());
                        formData.append('new_podcast_title', $('#new_podcast_title').val());
                        formData.append('new_podcast_category_id', $('#new_podcast_category_id').val());
                        formData.append('new_podcast_description', $('#new_podcast_description').val());
                        formData.append('monthly_price', $('#monthly_price').val());
                        formData.append('yearly_price', $('#yearly_price').val());
                        formData.append('podcast_image', $('#podcast_image')[0].files[0]);
                        formData.append('title', $('#title').val());
                        formData.append('description', $('#description').val());
                        formData.append('image', $('#image')[0].files[0]);
                        formData.append('file_type_select', $('#file-type-select').val());
                        var file_type_select = $('#file-type-select').val();
                        var add_new_podcast = $('#add_new_podcast').val();
                        var new_podcast_title = $('#new_podcast_title').val();
                        var new_podcast_category_id = $('#new_podcast_category_id').val();
                        var new_podcast_description = $('#new_podcast_description').val();
                        var monthly_price = $('#monthly_price').val();
                        var yearly_price = $('#yearly_price').val();
                        var podcast_image = $('#podcast_image').val();
                        var title = $('#title').val();
                        var description = $('#description').val();
                        var image = $('#image').val();
                        if(file_type_select == 1)
                        {
                            var link = $('#link').val();
                            formData.append('link', $('#link').val());
                        }
                        if(file_type_select == 2 || file_type_select == 3)
                        {
                            formData.append('filename', $('#file-input')[0].files[0]);
                        }                     
                        formData.append('is_premium', $('#is_premium').val());
                    }
                    else
                    {
                        var formData = new FormData();
                        formData.append('podcast_id', $('#podcast_id').val());
                        formData.append('title', $('#title').val());
                        formData.append('description', $('#description').val());
                        formData.append('image', $('#image')[0].files[0]);
                        formData.append('file_type_select', $('#file-type-select').val());
   
                        var podcast_id = $('#podcast_id').val();
                        var title = $('#title').val();
                        var description = $('#description').val();
                        var image = $('#image').val();
                        var file_type_select = $('#file-type-select').val();
                        var is_premium = $('#is_premium').val();
                        if(file_type_select == 1)
                        {
                            var link = $('#link').val();
                            formData.append('link', $('#link').val());
                        }
                        if(file_type_select == 2 || file_type_select == 3)
                        {
                            formData.append('filename', $('#file-input')[0].files[0]);
                        } 
                        formData.append('is_premium', $('#is_premium').val());
                    }

                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                    $.ajax({
                        url: '{{ route("admin.podcast.new.episode.store") }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                        var xhr = $.ajaxSettings.xhr();
                        xhr.upload.onprogress = function(e) {
                            if (e.lengthComputable) {
                            var percentComplete = (e.loaded / e.total) * 100;
                            progressBar.width(percentComplete + '%').attr('aria-valuenow', percentComplete);
                            }
                        };
                        return xhr;
                        },
                        success: function(data) {
                            progressBar.width('0%').attr('aria-valuenow', 0);
                            fileInput.val('');
                            errorMessage.text('');
                            Swal.fire({
                                title: data.success,
                                icon: 'success',
                                position: 'top-right',
                                customClass: {
                                    heightAuto: false,
                                    popup: 'swal2-toast',
                                    icon: 'swal2-icon',
                                    title: 'swal2-title',
                                },
                                width: '350px',
                                padding: '20px',
                                heightAuto: false,
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });
                            window.location.replace("{{ route('admin.podcast.list') }}");
                            
                        },
                        error: function(xhr, status, error) {

                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                var errors = Object.values(xhr.responseJSON.errors);
                                errors.forEach(function(error) {
                                    console.log(error);
                                    Swal.fire({
                                        title: error,
                                        icon: 'error',
                                        position: 'top-right',
                                        customClass: {
                                            heightAuto: false,
                                            popup: 'swal2-toast',
                                            icon: 'swal2-icon',
                                            title: 'swal2-title',
                                        },
                                        width: '350px',
                                        padding: '20px',
                                        heightAuto: false,
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                    });
                                });

                            } else {
                                Swal.fire({
                                        title: 'Something wrong. Try again.',
                                        icon: 'error',
                                        position: 'top-right',
                                        customClass: {
                                            heightAuto: false,
                                            popup: 'swal2-toast',
                                            icon: 'swal2-icon',
                                            title: 'swal2-title',
                                        },
                                        width: '350px',
                                        padding: '20px',
                                        heightAuto: false,
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                    });
                            }
                        },
                        beforeSend: function() {
                        progressBar.parent().show();
                        },
                        complete: function() {
                        progressBar.parent().hide();
                        }

                        
                    });
                });

            })(jQuery);
        </script>
    @endpush



