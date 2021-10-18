@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
    	<div class="card">
    			<form action="{{ route('admin.item.store') }}" method="post" enctype="multipart/form-data">
    				@csrf
    		<div class="card-body">
    				<div class="form-row">
    					<div class="form-group col-md-4">
    						<label>@lang('Portrait Image')</label>
    						<div class="image-upload">
    							<div class="thumb">
    								<div class="avatar-preview">
    									<div class="profilePicPreview" style="background-image: url({{ getImage('') }})">
    										<button type="button" class="remove-image"><i class="fa fa-times"></i></button>
    									</div>
    								</div>
    								<div class="avatar-edit">
    									<input type="file" class="profilePicUpload" name="portrait" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
    									<label for="profilePicUpload1" class="bg--success">@lang('Upload Portrait Image')</label>
    								</div>
    							</div>
    						</div>
    					</div>
    					<div class="form-group col-md-8">
    						<label>@lang('Landscape Image')</label>
    						<div class="image-upload">
    							<div class="thumb">
    								<div class="avatar-preview">
    									<div class="profilePicPreview" style="background-image: url({{ getImage('') }})">
    										<button type="button" class="remove-image"><i class="fa fa-times"></i></button>
    									</div>
    								</div>
    								<div class="avatar-edit">
    									<input type="file" class="profilePicUpload" name="landscape" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
    									<label for="profilePicUpload2" class="bg--success">@lang('Upload Landscape Image')</label>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    				<div class="form-row">
    					<div class="form-group col-md-4">
    						<label>@lang('Title')</label>
    						<input type="text" name="title" class="form-control" placeholder="@lang('Title')" value="{{ old('title') }}">
    					</div>
                        <div class="form-group col-md-4">
                            <label>@lang('Item Type')</label>
                            <select class="form-control" name="item_type">
                                <option value="1">@lang('Single Item')</option>
                                <option value="2">@lang('Episode Item')</option>
                                <option value="3">@lang('Trailer Item')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 version">
                            <label>@lang('Version')</label>
                            <select class="form-control" name="version">
                                <option value="0">@lang('Free')</option>
                                <option value="1">@lang('Paid')</option>
                            </select>
                        </div>
    				</div>
    				<div class="form-row">
    					<div class="form-group col-md-6">
    						<label>@lang('Category')</label>
    						<select class="form-control" name="category" id="cat">
    							<option value="">-- @lang('Select One') --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                @endforeach
    						</select>
    					</div>
    					<div class="form-group col-md-6">
    						<label>@lang('Sub Category')</label>
    						<select class="form-control" name="sub_category_id">
    							<option value="">-- @lang('Select One') --</option>
    						</select>
    					</div>
    				</div>
    				<div class="form-row">
    					<div class="form-group col-md-6">
    						<label>@lang('Preview Text')</label>
    						<textarea class="form-control" name="preview_text" rows="5" placeholder="@lang('Preview Text')">{{ old('preview_text') }}</textarea>
    					</div>
    					<div class="form-group col-md-6">
    						<label>@lang('Description')</label>
    						<textarea class="form-control" name="description" rows="5" placeholder="@lang('Description')">{{ old('description') }}</textarea>
    					</div>
    				</div>
    				<div class="form-row">
    					<div class="form-group col-md-4">
    						<label>@lang('Director')</label>
    						<input type="text" name="director" class="form-control" placeholder="@lang('Director')" value="{{ old('director') }}">
    					</div>
    					<div class="form-group col-md-4">
    						<label>@lang('Producer')</label>
    						<input type="text" name="producer" class="form-control" placeholder="@lang('Producer')" value="{{ old('producer') }}">
    					</div>
                        <div class="form-group col-md-4">
                            <label>@lang('Ratings') <small class="text--primary">(@lang('maximum 10 star')</small></label>
                            <div class="input-group">
                                <input type="text" name="ratings" class="form-control" placeholder="Ratings" value="{{ old('ratings') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="las la-star"></i></span>
                                </div>
                            </div>
                        </div>
    				</div>
    				<div class="form-row">
    					<div class="form-group col-md-6">
    						<label class="form-control-label">@lang('Casts')</label>
    						<small class="ml-2 mt-2 text-facebook">@lang('Separate multiple by') <code>,</code>(@lang('comma')) @lang('or') <code>@lang('enter')</code> @lang('key')</small>

    						<select name="casts[]" class="form-control select2-auto-tokenize" placeholder="@lang('Add short words which better describe your site')" multiple="multiple" required>

    						</select>
    					</div>
    					<div class="form-group col-md-6">
    						<label>@lang('Tags')</label>
    						<small class="ml-2 mt-2 text-facebook">@lang('Separate multiple by') <code>,</code>(@lang('comma')) @lang('or') <code>@lang('enter')</code> @lang('key')</small>

    						<select name="tags[]" class="form-control select2-auto-tokenize" placeholder="@lang('Add short words which better describe your site')" multiple="multiple" required>

                            </select>
    					</div>
    				</div>
    		</div>
            <div class="card-footer">
                <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
            </div>
    			</form>
    	</div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<a href="{{ route('admin.item.index') }}" class="btn btn-sm btn--primary"><i class="la la-fw la-backward"></i> @lang('Go Back')</a>
@endpush
@push('script')
<script type="text/javascript">

(function($){
    "use strict"
    $('#cat').change(function(){
        var cat_id=$(this).val();
        var div=$(this).parent();
        var op = " ";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url: '{{ route("admin.subCat") }}',
            data:{'id':cat_id},
            success:function(data){
                $('select[name=sub_category_id]').html('<option value="" >-- Select One --</option>');
                $.each(data, function(idx, subCat) {
                    $('select[name=sub_category_id]').append('<option value="'+ subCat.id +'">'+ subCat.name +'</option>');
                });

            },
            error:function(){

            },
        });
    });
    $('select[name=item_type]').change(function(){
        console.log($(this).val());
        if ($(this).val() == '1') {
            $('.version').removeClass('d-none');
        }else{
            $('.version').addClass('d-none');
        }
    });
    $('select[name=version]').val('{{ old('version') }}');
    $('select[name=category]').val('{{ old('category') }}');
    $('select[name=sub_category_id]').val('{{ old('sub_category_id') }}');
})(jQuery);
</script>
@endpush