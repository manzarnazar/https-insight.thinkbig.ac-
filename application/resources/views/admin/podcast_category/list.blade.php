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
                                <th>@lang('Name')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($podcastCategory as $item)
                           <tr>
                            <td>{{__($item->name)}}</td>
                            <td> @php echo $item->statusBadge($item->status); @endphp</td>
                            <td>
                                <div class="button--group">
                                    <button type="button" class="btn btn-sm btn--primary updateCity" data-id="{{$item->id}}" data-name="{{$item->name}}" data-status ="{{$item->status}}" data-toggle="tooltip" data-placement="bottom" title="@lang('Edit')"><i class="las la-edit"></i></button>
                                </div>
                            </td>
                           </tr>
                           @empty
                           <tr>
                            <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                        </tr>
                           @endforelse
                        </tbody>
                    </table><!-- table end -->
                    @if ($podcastCategory->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($podcastCategory) @endphp
                    </div>
                    @endif

                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>


{{-- Add METHOD MODAL --}}
<div id="cityModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Add Podcast Category')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label  for="store_name"> @lang('Name'):</label>
                        <input type="text" id="store_name" class="form-control" name="name" placeholder="@lang('Category Name')" required>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="image_upload">@lang('Podcast Category Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                            <input type="file" class="form-control" id="image_upload"  name="image" required accept=".jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div class="form-group">
                        <label> @lang('Status')</label>
                        <label class="switch m-0">
                            <input type="checkbox" class="toggle-switch" name="status">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Update METHOD MODAL --}}
<div id="updateCityModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Podcast Category')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.category.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label  for="update_name"> @lang('Category name'):</label>
                        <input type="text" id="update_name" class="form-control" name="name">
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="image_upload">@lang('Podcast Category Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                            <input type="file" class="form-control" id="image_upload"  name="image" required accept=".jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div class="form-group">
                        <label> @lang('Status')</label>
                        <label class="switch m-0" for="statuss">
                            <input type="checkbox" class="toggle-switch" name="status" id="statuss">
                            <span class="slider round"></span>
                        </label>
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
@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn--primary addCity"><i class="las la-plus"></i>@lang('Add
    New')</button>
@endpush
@push('script')
<script>
    (function($){
        "use strict";

        $('.addCity').on('click', function() {
        $('#cityModel').modal('show');
    });


    $('.updateCity').on('click', function() {
        var modal = $('#updateCityModel');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=name]').val($(this).data('name'));
        modal.find('input[name=status]').prop('checked', $(this).data('status') == 1 ? true : false );
        modal.find('input[name=status]').val($(this).data('status') == 1 ? 1 : 0);
        modal.modal('show');
    });
    })(jQuery);
</script>
@endpush
