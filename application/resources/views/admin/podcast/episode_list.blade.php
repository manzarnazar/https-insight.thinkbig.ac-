@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('S.L')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Podcast')</th>
                                <th>@lang('File Type')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($episodeList as $item)
                           <tr>
                            <td>{{ __(@$loop->index + 1) }}</td>
                            <td>{{__(@$item->title)}}</td>
                            <td>{{__(@$podcast->title)}}</td>
                            <td>
                                @php echo @$item->statusBadge(@$item->status); @endphp 
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn--primary updateCity" data-path="{{$item->image_path}}" data-image="{{$item->image}}" data-id="{{$item->id}}" data-title="{{$item->title}}"  data-description="{{$item->description}}" data-toggle="tooltip" data-placement="bottom" title="@lang('Edit')"><i class="las la-edit"></i></button>

                                <button class="btn btn-sm btn--danger confirmationBtn me-1" data-toggle="tooltip" data-placement="bottom" title="@lang('Delete Episode')"  data-question="@lang('Are you sure to delete the episode from this system?')" data-action="{{route('admin.podcast.episode.delete', $item->id)}}">
                                    <i class="las la-trash"></i>
                                </button>

                                <x-confirmation-modal></x-confirmation-modal>
                            </td>
                           </tr>
                           @empty
                           <tr>
                            <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                        </tr>
                           @endforelse
                        </tbody>
                    </table><!-- table end -->

                    @if ($episodeList->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($episodeList) @endphp
                    </div>
                    @endif
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>




{{-- Update METHOD MODAL --}}
<div id="updateCityModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Podcast Episode')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.podcast.episode.update')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">@lang('Title')</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('Episode Title')">
                    </div>


                    <div class="form-group">
                        <label for="description">@lang('Description')</label>
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <p>@lang('Current Image')</p>
                        <img id="image_path" src="" alt="">
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="image">@lang('Episode Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                            <input type="file" class="form-control" id="image"  name="image">
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                </div>

            </form>
        </div>
    </div>
</div>



@endsection

@push('style')
    <style>
        #image_path{
            height: 200px;
            width: 200px;
        }
    </style>
@endpush

@push('script')
<script>
    (function($){
        "use strict";



    $('.updateCity').on('click', function() {
        var modal = $('#updateCityModel');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=title]').val($(this).data('title'));

        var imagePath = "{{getFilePath('podcastEpisode')}}"+'/'+$(this).data('path')+'/'+$(this).data('image');
        var websiteUrl = "{{ url('/') }}/";
        var image = websiteUrl  + imagePath;
        modal.find('#image_path').attr('src',image);

        modal.find('textarea[name=description]').val($(this).data('description'))
        modal.modal('show');
    });
    })(jQuery);
</script>
@endpush


