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
                                <th>@lang('Category')</th>
                                <th>@lang('Creator')</th>
                                <th>@lang('Total Episodes')</th>
                                <th>@lang('Monthly Price')</th>
                                <th>@lang('Yearly Price')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($podcasts as $item)
                           <tr>
                            <td>{{ __($loop->index + 1) }}</td>
                            <td>{{__($item->title)}}</td>
                            <td>{{__(@$item->category->name)}}</td>
                            <td>
                                @if($item->user)
                                    {{__(@$item->user->fullname)}}
                                @else
                                    @lang('Admin')
                                @endif
                            </td>
                            <td>{{@$item->episode->count()}}</td>
                            <td>{{showAmount(@$item->monthly_price, 2)}}</td>
                            <td>{{showAmount(@$item->yearly_price, 2)}}</td>
                            <td class="text-end">
                                <a href="{{route('admin.podcast.episode.list', $item->id)}}" class="btn btn-sm btn--primary me-1" data-toggle="tooltip" data-placement="bottom" title="@lang('View Episode')"><i class="las la-eye text--shadow"></i></a>
                                <button type="button" class="btn btn-sm btn--primary updateCity" data-id="{{$item->id}}" data-title="{{$item->title}}" data-categoryId="{{$item->category_id}}" data-description="{{$item->description}}" data-monthly_price="{{showAmount($item->monthly_price,2)}}" data-yearly_price="{{showAmount($item->yearly_price, 2)}}" data-path="{{$item->path}}" data-image="{{$item->image}}"
                                             data-toggle="tooltip" data-placement="bottom" title="@lang('Edit')"><i class="las la-edit"></i></button>

                                <button class="btn btn-sm btn--danger confirmationBtn me-1" data-toggle="tooltip" data-placement="bottom" title="@lang('Delete Podcast')"  data-question="@lang('Are you sure to delete the podcast from this system?')" data-action="{{route('admin.podcast.delete', $item->id)}}">
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

                    @if ($podcasts->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($podcasts) @endphp
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
                <h5 class="modal-title"> @lang('Add Podcast')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.podcast.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label> @lang('Podcast Title'):</label>
                        <input type="text" class="form-control" name="title" placeholder="@lang('Podcast Title')" required>
                    </div>

                    <div class="form-group">
                        <label> @lang('Podcast Category'):</label>
                        <select name="category_id"  class="form-control" required>
                            @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> @lang('Monthly Price'):</label>
                        <input type="number" class="form-control" name="monthly_price" placeholder="@lang('Monthly Price')" step="any">
                    </div>

                    <div class="form-group">
                        <label> @lang('Yearly Price'):</label>
                        <input type="number" class="form-control" name="yearly_price" placeholder="@lang('Yearly Price')" step="any">
                    </div>

                    <div class="form-group">
                        <label> @lang('Podcast Description'):</label>
                        <textarea rows="10" cols="10" class="form-control" name="description" placeholder="@lang('Write podcast description')" required></textarea>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="image_upload">@lang('Podcast Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                            <input type="file" class="form-control" id="image_upload"  name="image" required accept=".jpg,.jpeg,.png">
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



{{-- Update METHOD MODAL --}}
<div id="updateCityModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Podcast')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.podcast.list.update')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">@lang('Title')</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('Podcast Title')">
                    </div>

                    <div class="form-group">
                        <label for="category">@lang('Category')</label>
                        <select name="category" id="category" class="form-control" required>
                            @foreach ($categories as $item)
                                <option value="{{$item->id}}">{{__($item->name)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> @lang('Monthly Price'):</label>
                        <input type="number" class="form-control" name="monthly_price" placeholder="@lang('Monthly Price')" step="any">
                    </div>

                    <div class="form-group">
                        <label> @lang('Yearly Price'):</label>
                        <input type="number" class="form-control" name="yearly_price" placeholder="@lang('Yearly Price')" step="any">
                    </div>

                    <div class="form-group">
                        <p>@lang('Current Image')</p>
                        <img  id="image_path" alt="">
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="image">@lang('Podcast Thumb Image') (@lang('.jpg, .png, .jpeg'))</label>
                            <input type="file" class="form-control" id="image"  name="podcast_image" accept=".jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">@lang('Description')</label>
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>

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
        $('.addCity').on('click', function() {
        $('#cityModel').modal('show');
    });


    $('.updateCity').on('click', function() {
        var modal = $('#updateCityModel');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=title]').val($(this).data('title'));
        modal.find('input[name=monthly_price]').val($(this).data('monthly_price'));
        modal.find('input[name=yearly_price]').val($(this).data('yearly_price'));
        var categoryId = $(this).data('categoryid');
        modal.find('select[name=category]').val(categoryId);
        modal.find('textarea[name=description]').val($(this).data('description'));
        var imagePath = "{{getFilePath('podcast')}}"+'/'+$(this).data('path')+'/'+$(this).data('image');
        var websiteUrl = "{{ url('/') }}/";
        var image = websiteUrl  + imagePath;
        modal.find('#image_path').attr('src',image);
        modal.modal('show');
    });
    })(jQuery);
</script>
@endpush
