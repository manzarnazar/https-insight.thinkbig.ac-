@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard py-80 section-bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    @include($activeTemplate . 'components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12">
                    <div class="dashboard-body">

                        <div class="row gy-4 justify-content-center">
                            <div class="col-lg-12">
                                <div class="order-wrap">

                                    <table class="table table--responsive--lg">
                                        <thead>
                                            <tr>
                                                <th>@lang('#SL')</th>
                                                <th>@lang('Title')</th>
                                                <th>@lang('Podcast ')</th>
                                                <th>@lang('File Type')</th>
                                                <th>@lang('Total Listening')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($episodes as $key=>$item)
                                                <tr>
                                                    <td data-label="@lang('#SL')">{{ ++$key }}</td>
                                                    <td data-label="@lang('Title')">{{ __(@$item->title) }}</td>
                                                    <td data-label="@lang('Podcast ')">{{ __(@$item->podcast->title) }}</td>
                                                    <td data-label="@lang('File Type')">
                                                        @if ($item->file_type == 1)
                                                            <span class="badge bg--base">@lang('Link')</span>
                                                        @elseif($item->file_type == 2)
                                                            <span class="badge bg-info">@lang('Audio')</span>
                                                        @elseif($item->file_type == 3)
                                                            <span class="badge bg-success">@lang('Video')</span>
                                                        @endif
                                                    </td>
                                                    <td data-label="@lang('Total Listening')">{{ __(@$item->listen_count) }}</td>
                                                    <td data-label="@lang('Action')" class="">
                                                        <a class="btn btn-primary btn--sm"
                                                            href="{{ route('user.podcast.episode.audio', $item->id) }}">
                                                            <i class="las la-play-circle"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-primary btn--sm editBtn"
                                                            data-bs-toggle="modal" data-id="{{ $item->id }}"
                                                            data-title="{{ __($item->title) }}"
                                                            data-description="{{ __($item->description) }}"
                                                            data-categoryId="{{ $item->category_id }}"
                                                            data-bs-target="#editModal">

                                                            <i class="las la-edit"></i>
                                                        </button>

                                                        <button type="button"
                                                            class="btn btn--sm btn--danger confirmationBtn"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="@lang('Delete Episode')" data-question="@lang('Are you sure to delete the episode from this system?')"
                                                            data-action="{{ route('user.podcast.episode.delete', $item->id) }}">
                                                            <i class="las la-trash"></i>
                                                        </button>

                                                        <x-confirmation-modal></x-confirmation-modal>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-muted text-center" colspan="100%">
                                                        {{ __(@$emptyMessage) }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($episodes->hasPages())
                                <div class="card-footer py-4">
                                    @php echo paginateLinks($episodes) @endphp
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Update Episode')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.podcast.episodes.list') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-sm-12">
                                <input type="hidden" name="id">
                                <div class="form-group">
                                    <label for="title" class="form--label">@lang('Title')</label>
                                    <input type="text" class="form--control" name="title" id="title"
                                        placeholder="@lang('Podcast Title')">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description" class="form--label">@lang('Description')</label>
                                    <textarea name="description" class="form--control" id="description" cols="30" rows="10"
                                        placeholder="@lang('write something ...')"></textarea>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">@lang('Episode Image') (@lang('.jpg, .png, .jpeg'))</label>
                                    <input type="file" class="form--control" id="image" name="image" accept=".jpeg, .png,.jpg">

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
        .audio {
            width: 100%;
        }

        .btn--sm {
            padding: 3px 10px !important;
            border-radius: 3px;
            margin: 0 0;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {

            "use strict";
            $('.editBtn').on('click', function() {
                var modal = $('#editModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=title]').val($(this).data('title'));
                modal.find('textarea[name=description]').val($(this).data('description'));
                modal.show();
            })
        })(jQuery);
    </script>
@endpush
