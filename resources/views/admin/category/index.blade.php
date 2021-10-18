@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td data-label="@lang('Name')">{{ __($category->name) }}</td>
                                <td data-label="@lang('Status')">
                                    @if($category->status == 1)
                                        <span class="badge badge--success font-weight-normal text--small">@lang('active')</span>
                                        </span>
                                        @else
                                        <span class="badge badge--danger font-weight-normal text--small">@lang('inactive')</span>
                                        </span>
                                        @endif

                                </td>
                                <td data-label="@lang('Action')">
                                    <button class="icon-btn btn--primary editBtn" data-name="{{ $category->name }}" data-action="{{ route('admin.category.update',$category->id) }}"><i class="la la-pen"></i></button>
                                    @if($category->status == 1)
                                    <a href="{{ route('admin.category.status',$category->id) }}" class="icon-btn btn--danger mr-1"> <i class="la la-eye"></i> </a>
                                    @else
                                    <a href="{{ route('admin.category.status',$category->id) }}" class="icon-btn btn--success mr-1"> <i class="la la-eye-slash"></i> </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                    {{ $categories->links('admin.partials.paginate') }}
                </div>
        </div>
    </div>
</div>
{{-- Edit Modal --}}
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Edit Category') </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="m-0">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Category Name')</label>
                        <input type="text" name="name" class="form-control" placeholder="@lang('App Name')" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Add Category')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>@lang('Category Name')</label>
                <input type="text" name="name" class="form-control" placeholder="@lang('Category Name')" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
        <button type="submit" class="btn btn--primary">@lang('Add Category')</button>
      </div>
  </form>
    </div>
  </div>
</div>
@endsection


@push('breadcrumb-plugins')
<button class="icon-btn btn--primary" data-toggle="modal" data-target="#addModal"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</button>
@endpush

@push('script')

<script>
    (function($){
        "use strict"
        $('.removeBtn').on('click', function() {
            var modal = $('#removeModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });

        $('.editBtn').on('click',function(){
            var modal = $("#editModal");
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=link]').val($(this).data('link'));
            modal.find('form').attr('action',$(this).data('action'));
            modal.modal('show');
        });
    })(jQuery);
</script>

@endpush
