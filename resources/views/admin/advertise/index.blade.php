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
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Type')</th>
                                <th scope="col">@lang('Click')</th>
	                            <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ads as $ad)
	                        <tr>
	                            <td data-label="@lang('Title')">
	                                {{ __($ad->title) }}
	                            </td>
	                            <td data-label="@lang('Type')">
	                                {{ __($ad->type) }}
	                            </td>
	                            <td data-label="@lang('Click')">
	                                {{ __($ad->click) }}
	                            </td>
	                            <td data-action="@lang('Action')">
	                                <button class="icon-btn editBtn" data-action="{{ route('admin.advertise.edit',$ad->id) }}" data-type="{{ $ad->type }}" @if(@$ad->content->link) data-link="{{ $ad->content->link }}"@endif @if(@$ad->content->image)data-image="{{ asset('assets/images/ads/'.$ad->content->image) }}"@endif @if(@$ad->content->script)data-script="{{ $ad->content->script }}"@endif data-title="{{ $ad->title }}"><i class="la la-pen"></i></button>
	                                <button class="icon-btn btn--danger removeBtn" data-id="{{ $ad->id }}"><i class="la la-trash"></i></button>
	                            </td>
	                        </tr>
	                        @empty
	                        <tr>
	                            <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
	                        </tr>
	                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                    {{ $ads->links('admin.partials.paginate') }}
                </div>
        </div>
    </div>
</div>

      <!-- Modal -->
<div class="modal fade" id="addAdvertise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Add Advertise')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.advertise.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>@lang('Ttile')</label>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
                <select class="form-control" id="type" name="type" required>
                    <option value="">-- @lang('Select One') --</option>
                    <option value="banner">@lang('Banner')</option>
                    <option value="script">@lang('Script')</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="link" placeholder="@lang('Link')" class="form-control link">
            </div>
            <div class="form-group image">
                <label>@lang('Choose file')</label>
                <input type="file" class="form-control" name="image">
            </div>

            <div class="form-group">
                <textarea rows="6" class="form-control script" name="script" placeholder="@lang('Write Your Script')"></textarea>
            </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn--primary">@lang('Create Advertise')</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editmodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Advertise')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="mb-2 image">
      		<img src="">
      	</div>
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Ttile</label>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
                <select class="form-control" id="type2" name="type">
                    <option value="">-- @lang('Select One') --</option>
                    <option value="banner">@lang('Banner')</option>
                    <option value="script">@lang('Script')</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="link" placeholder="@lang('Link')" class="form-control link2">
            </div>
            <div class="form-group">
                <textarea rows="6" class="form-control script2" name="script" placeholder="@lang('Write Your Script')"></textarea>
            </div>
            <div class="form-group image2">
                <label>@lang('Choose file')</label>
                <input type="file" class="form-control" name="image">
            </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn--primary">@lang('Edit Advertise')</button>
      </div>
    </form>
    </div>
  </div>
</div>

{{-- REMOVE METHOD MODAL --}}
<div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Advertise Removal Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.advertise.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this advertise?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<button class="btn btn--primary" data-toggle="modal" data-target="#addAdvertise"><i class="la la-plus"></i> @lang('Add Advertise')</button>
@endpush
@push('script')
<script type="text/javascript">
    (function($){
        "use strict";
        $('#type').change(function(){
            if ($(this).val() == 'script') {

                $('.link').hide();
                $('.image').hide();
                $('.script').show();
            }else{
                $('.link').show();
                $('.image').show();
                $('.script').hide();
            }
        }).change();
    })(jQuery);
</script>
<script type="text/javascript">
    (function($){
        "use strict";
        $('#type2').change(function(){
            if ($(this).val() == 'script') {
                $('.link2').hide();
                $('.image2').hide();
                $('.script2').show();
            }else if($(this).val() == 'banner'){
                $('.link2').show();
                $('.image2').show();
                $('.script2').hide();
            }
        }).change();
    })(jQuery);
</script>
<script type="text/javascript">
    (function($){
        "use strict";
        $(".editBtn").on('click',function(){
            var modal = $("#editmodal");
            modal.find('img').attr('src',`${$(this).data('image')}`);
            modal.find('select[name=type]').val($(this).data('type'));
            modal.find('input[name=link]').val($(this).data('link'));
            modal.find('input[name=title]').val($(this).data('title'));
            modal.find('textarea[name=script]').val($(this).data('script'));
            modal.find('form').attr('action',$(this).data('action'));
            modal.modal('show');
            if ($(this).data('type') == 'script') {
                $('.link2').hide();
                $('.image2').hide();
                $('.script2').show();
            }else{
                $('.link2').show();
                $('.image2').show();
                $('.script2').hide();
            }
        });

        $('.removeBtn').on('click', function() {
            var modal = $('#removeModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
