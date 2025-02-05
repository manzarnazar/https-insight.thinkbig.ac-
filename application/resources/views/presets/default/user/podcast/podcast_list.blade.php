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

                    <div class="row ">
                        <div class="col-md-12 mb-3 justify-content-end">
                            <div class="escro-search-wrapper">
                                <form action="" autocomplete="off">
                                    <div class="header-search-wrap">
                                        <div class="search-box header-search-hide-show">
                                            <input type="text" name="search" value="{{request()->search}}" class="form--control pr-0" placeholder="@lang('Search Podcasts')">
                                            <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('#SL')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Total Episodes')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($podcasts as $key=>$item)
                            <tr>
                                <td data-label="SL">{{++$key}}</td>
                                <td data-label="Title">{{__(@$item->title)}}</td>
                                <td data-label="Category">{{__(@$item->category->name)}}</td>
                                <td> {{@$item->episode->count()}} </td>
                                <td data-label="Action">

                                    <button type="button" class="btn btn-primary btn--sm editBtn" data-bs-toggle="modal" data-id="{{$item->id}}" data-title="{{__($item->title)}}" data-description="{{__($item->description)}}" data-categoryId="{{$item->category_id}}" data-bs-target="#editModal">
                                        <i class="las la-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn--sm btn--danger confirmationBtn" data-toggle="tooltip" data-placement="bottom" title="@lang('Delete Episode')"  data-question="@lang('Are you sure to delete the episode from this system?')" data-action="{{route('user.podcast.delete', $item->id)}}">
                                        <i class="las la-trash"></i>
                                    </button>
    
                                    <x-confirmation-modal></x-confirmation-modal>

                                </td>


                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($podcasts->hasPages())
            <div class="card-footer py-4">
                @php echo paginateLinks($podcasts) @endphp
            </div>
            @endif
        </div>
    </div>
</div>




  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Update Podcast')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('user.podcast.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <div class="col-sm-12">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="title" class="form--label">@lang('Title')</label>
                            <input type="text" class="form--control" name="title" id="title" placeholder="@lang('Podcast Title')">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="category" class="form--label">@lang('Category')</label>
                            <select name="category" class="form--control" id="category">
                                @foreach ($categories as $item)
                                    <option value="{{$item->id}}">{{__($item->name)}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="description" class="form--label">@lang('Description')</label>
                            <textarea name="description" class="form--control" id="description" cols="30" rows="10" placeholder="@lang('write something ...')"></textarea>

                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="image" class="form-label">@lang('Podcast Image') (@lang('.jpg, .png, .jpeg'))</label>
                            <input type="file" class="form--control" id="image"  name="image" required accept=".jpeg, .png,.jpg">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
                    </div>

                </div>
            </form>
        </div>

      </div>
    </div>
  </div>

@endsection

@push('style')
  <style>
    .btn--sm {
        padding: 3px 10px !important;
        border-radius: 3px;
        margin: 0 0;
    }
  </style>
@endpush

@push('script')

<script>
    (function($){

        "use strict";
        $('.editBtn').on('click',function(){
            var modal = $('#editModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=title]').val($(this).data('title'));
            var categoryId = $(this).data('categoryid');

            modal.find('select[name=category]').val(categoryId);
            modal.find('textarea[name=description]').val($(this).data('description'));
            modal.show();
        })
    })(jQuery);
</script>

@endpush
