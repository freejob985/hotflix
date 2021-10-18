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
    							<th scope="col">@lang('Title')</th>
    							<th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Version')</th>
    							<th scope="col">@lang('Action')</th>
    						</tr>
    					</thead>
    					<tbody>
    						@forelse($episodes as $episode)
    						<tr>
    							<td data-label="@lang('Title')">{{ __($episode->title) }}</td>
    							<td data-label="@lang('Status')">
    								@if($episode->status == 1)
    								<span class="badge badge--success">@lang('Active')</span>
    								@else
    								<span class="badge badge--danger">@lang('Deactive')</span>
    								@endif
    							</td>
                                <td data-label="Version">
                                    @if($episode->version == 0)
                                    <span class="badge badge--success">@lang('Free')</span>
                                    @else
                                    <span class="badge badge--primary">@lang('Paid')</span>
                                    @endif
                                </td>
    							<td data-label="@lang('Action')">
    								<button class="icon-btn mr-1 editBtn" data-title="{{ $episode->title }}" data-version="{{ $episode->version }}" data-image="{{ getImage('assets/images/item/episode/'.$episode->image) }}" data-action="{{ route('admin.item.editEpisode',$episode->id) }}" data-toggle="tooltip" title="" data-original-title="Edit">
    									@lang('Edit')
    								</button>
    								@if($episode->status == 1)
    								<a href="{{ route('admin.item.episodeStatus',$episode->id) }}" class="icon-btn btn--danger mr-1">
    									@lang('Deactive')
    								</a>
    								@else
    								<a href="{{ route('admin.item.episodeStatus',$episode->id) }}" class="icon-btn btn--success mr-1">
    									@lang('Active')
    								</a>
    								@endif
    								@if($episode->video)
    								<a href="{{ route('admin.item.episode.updateVideo',$episode->id) }}" class="icon-btn btn--info">
    									@lang('Update Video')
    								</a>
    								@else
    								<a href="{{ route('admin.item.episode.addVideo',$episode->id) }}" class="icon-btn btn--warning">
    									@lang('Upload Video')
    								</a>
    								@endif
    							</td>
    						</tr>
    						@empty
    						<tr>
    							<td colspan="100%" class="text-center">@lang('Item Not Found')</td>
    						</tr>
    						@endforelse
    					</tbody>
    				</table>
    			</div>
    		</div>
    		<div class="card-footer py-4">
    			{{ $episodes->links('admin.partials.paginate') }}
    		</div>
    	</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('Add New Episode')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.item.addEpisode',$item->id) }}" method="post" enctype="multipart/form-data">
      	@csrf
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>@lang('Thumbnail Image')</label>
	        	<div class="image-upload">
	        		<div class="thumb">
	        			<div class="avatar-preview">
	        				<div class="profilePicPreview" style="background-image: url({{ getImage('') }})">
	        					<button type="button" class="remove-image"><i class="fa fa-times"></i></button>
	        				</div>
	        			</div>
	        			<div class="avatar-edit">
	        				<input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
	        				<label for="profilePicUpload1" class="bg--success">@lang('Upload Thumbnail Image')</label>
	        			</div>
	        		</div>
	        	</div>
	        </div>
	        <div class="form-group">
	        	<label>@lang('Video Title')</label>
	        	<input type="text" name="title" class="form-control" placeholder="Video Title">
	        </div>
            <div class="form-group">
                <label>@lang('Version')</label>
                <select class="form-control" name="version">
                    <option value="0">@lang('Free')</option>
                    <option value="1">@lang('Paid')</option>
                </select>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
	        <button type="submit" class="btn btn--primary">@lang('Save changes')</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('Edit Episode')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data">
      	@csrf
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>@lang('Thumbnail Image')</label>
	        	<div class="image-upload">
	        		<div class="thumb">
	        			<div class="avatar-preview">
	        				<div class="profilePicPreview" style="background-image: url({{ getImage('') }})">
	        					<button type="button" class="remove-image"><i class="fa fa-times"></i></button>
	        				</div>
	        			</div>
	        			<div class="avatar-edit">
	        				<input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
	        				<label for="profilePicUpload2" class="bg--success">@lang('Upload Thumbnail Image')</label>
	        			</div>
	        		</div>
	        	</div>
	        </div>
	        <div class="form-group">
	        	<label>@lang('Video Title')</label>
	        	<input type="text" name="title" class="form-control" placeholder="@lang('Video Title')">
	        </div>
            <div class="form-group">
                <label>@lang('Version')</label>
                <select class="form-control" name="version">
                    <option value="0">@lang('Free')</option>
                    <option value="1">@lang('Paid')</option>
                </select>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
	        <button type="submit" class="btn btn--primary">@lang('Save changes')</button>
	      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('breadcrumb-plugins')
<button class="btn btn--success addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New Episode')</button>
@endpush
@push('script')
<script type="text/javascript">
    (function($){
        "use strict"
    	$('.addBtn').click(function(){
    		var modal = $('#addModal').modal('show');
    	});
    	$('.editBtn').click(function(){
    		var modal = $('#editModal');
    		modal.find('input[name=title]').val($(this).data('title'));
    		modal.find('.profilePicPreview').attr('style',`background-image:url(${$(this).data('image')})`);
            modal.find('select').val($(this).data('version'));
    		modal.find('form').attr('action',$(this).data('action'));
    		modal.modal('show');
    	});
    })(jQuery);
</script>
@endpush