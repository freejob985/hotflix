@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Item')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sliders as $slider)
                                <tr>
                                    <td data-label="@lang('Item')">
                                        {{ $slider->item->title }}
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="icon-btn editBtn" data-item="{{ $slider->item->id }}"
                                                data-image="{{ getImage('assets/images/slider/'.$slider->image) }}"
                                                data-caption_status="{{ $slider->caption_show }}"
                                                data-action="{{ route('admin.sliders.update',$slider->id) }}">
                                            <i class="las la-pen text--shadow"></i>
                                        </button>
                                        <button class="icon-btn btn--danger removeBtn" data-id="{{ $slider->id }}">
                                            <i class="las la-trash text--shadow"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Slider Not Found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $sliders->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Slider')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.sliders.add') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Select Item')</label>
                            <select name="item" class="form-control">
                                <option value="">-- @lang('Select One') --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Thumbnail Image')</label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                             style="background-image: url({{ getImage('') }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1"
                                               accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--success">@lang('Upload Thumbnail Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>jpeg, jpg</b>. @lang('Image will
                                            be resized into') 2500x1080px </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Slider')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Thumbnail Image')</label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2"
                                               accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="bg--success">@lang('Upload Thumbnail
                                            Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>jpeg, jpg</b>. @lang('Image will
                                            be resized into') 2500x1080px </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Remove Slider')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.sliders.remove') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <h5 class="text-center">@lang('Are you sure to delete this item?')</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i> @lang('Add New')
    </button>
@endpush
@push('script')
    <script type="text/javascript">
        $('.addBtn').click(function () {
            $('#addModal').modal('show');
        });
        $('.removeBtn').click(function () {
            var modal = $('#removeModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });
        $('.editBtn').click(function () {
            var modal = $('#editModal');
            modal.find('.profilePicPreview').attr('style', `background-image: url(${$(this).data('image')})`);
            if ($(this).data('caption_status') == 0) {
                modal.find('.toggle').addClass('btn--danger off').removeClass('btn--success');
                modal.find('input[name="caption_show"]').prop('checked', false);
            } else {
                modal.find('.toggle').removeClass('btn--danger off').addClass('btn--success');
                modal.find('input[name="caption_show"]').prop('checked', true);
            }
            modal.find('form').attr('action', $(this).data('action'));
            modal.modal('show');
        });
    </script>
@endpush
