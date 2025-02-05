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
                            <h3 class="account-form__title mb-2">@lang('New Episode') </h3>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title" class="form--label">@lang('Title')</label>
                                        <input type="text" class="form--control" name="title" id="title" placeholder="@lang('Episode Title')">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="podcast" class="form--label">@lang('Podcast')</label>
                                        <select name="podcast_id" class="form--control">
                                            @foreach ($podcasts as $item)
                                                <option value="{{$item->id}}">{{__(@$item->title)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label  class="form--label">@lang('Description')</label>
                                    <textarea type="text" class="form--control" name="description"  placeholder="@lang('Write somethings ...')"></textarea>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="file-type-select">@lang('File Type')</label>
                                    <select class="form--control form-control" id="file-type-select" name="file_type_select" required>
                                        <option value="1" {{ old('file_type_select')== 1 ? 'selected':'' }}>@lang('Link / URL')</option>
                                        <option value="2" {{ old('file_type_select')== 2 ? 'selected':'' }}>@lang('Audio(From Device)')</option>
                                        <option value="3" {{ old('file_type_select')== 3 ? 'selected':'' }}>@lang('Video(From Device)')</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6" id="link_url">
                                    <label for="link" class="font-weight-bold">@lang('Video
                                        Link')</label>
                                    <input type="url" name="link" pattern="https?://.*" id="link"
                                                value="{{old('link')}}" class="form-control form--control "
                                                placeholder="@lang('https://www.youtube.com/embed/example')"
                                                maxlength="255">
                                </div>
                                <div class="form-group col-sm-6 d-none" id="from_browser">
                                    <label id="file-label" for="file-input">@lang('File type')</label>
                                    <input id="file-input" class="form--control form-control" type="file" name="filename" accept=".mp3" />
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">@lang('Image')</label>
                                    <input class="form--control" name="image" type="file" id="image" accept=".jpeg, .png,.jpg">

                                </div>
                            </div>



                            <div class="form-group my-3">
                                <input class="form-check-input" type="checkbox" id="exampleCheckbox" name="is_special" value="1" >
                                <label class="form-check-label" for="exampleCheckbox">
                                    @lang('Special Episode')
                                </label>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn--base btn-sm mt-4">@lang('Create Episode') </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $('#file-type-select').change(function(){
        var type = $(this).val();
        console.log(type);
        if (type == 1) {
            $("#link_url").removeClass('d-none');
            $("#from_browser").addClass('d-none');
            $("#file-label").addClass('d-none');
            $("#file-input").addClass('d-none');
        }
            else if( type == 2) {
            $("#link_url").addClass('d-none');
            $("#file-label").removeClass('d-none');
            $("#file-input").removeClass('d-none');
            $("#from_browser").removeClass('d-none');
            $('#file-label').text('File type audio and .mp3');
            $('#file-input').attr('accept', '.mp3');
        } else if( type == 3){
            $("#from_browser").removeClass('d-none');
            $("#file-label").removeClass('d-none');
            $("#file-input").removeClass('d-none');
            $("#link_url").addClass('d-none');
            $('#file-label').text('File type video and .mp4');
            $('#file-input').attr('accept', '.mp4');
        }
    }).change();
</script>
@endpush
