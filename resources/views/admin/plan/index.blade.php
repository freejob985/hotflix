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
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                <tr>
                                    <td data-label="Name">{{ $plan->name }}</td>
                                    <td data-label="Price">{{ getAmount($plan->pricing) }} {{ $general->cur_text }}</td>
                                    <td data-label="Duration">{{ $plan->duration }}</td>
                                    <td data-label="Status">
                                        @if($plan->status == 1)
                                        <span class="badge badge--success font-weight-normal text--small">Active</span>
                                        @else
                                        <span class="badge badge--warning font-weight-normal text--small">Deactive</span>
                                        @endif
                                    </td>
                                    <td data-label="Action">
                                        <button class="icon-btn mr-1 editBtn" data-name="{{ $plan->name }}" data-pricing="{{ getAmount($plan->pricing) }}" data-duration="{{ $plan->duration }}" data-icon="{{ $plan->icon }}" data-action="{{ route('admin.plan.update',$plan->id) }}"><i class="la la-pen"></i></button>
                                        @if($plan->status == 1)
                                        <a href="{{ route('admin.plan.status',$plan->id) }}" class="icon-btn btn--danger text-white"><i class="la la-eye"></i></a>
                                        @else
                                        <a href="{{ route('admin.plan.status',$plan->id) }}" class="icon-btn btn--success text-white"><i class="la la-eye-slash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center">Plan Not Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">

                </div>
            </div><!-- card end -->
        </div>
    </div>


<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{ route('admin.plan.store') }}" method="post">
      <div class="modal-body">
        	@csrf
        	<div class="form-group">
        		<label>Plan Name</label>
        		<input type="text" name="name" placeholder="Plan Name" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>Plan Price</label>
        		<input type="text" name="price" placeholder="Plan Price" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>Subscription Duration</label>
        		<div class="input-group">
        			<input type="text" name="duration" placeholder="Subscription Duration" class="form-control">
        			<div class="input-group-append">
        				<span class="input-group-text">Days</span>
        			</div>
        		</div>
        	</div>
        	<div class="form-group">
        		<label>Icon</label>
        		<div class="input-group has_append">
        			<input type="text" class="form-control" name="icon" required>
        			<div class="input-group-append">
        				<button type="button" class="btn btn-outline-secondary iconPicker"
        				data-icon="fas fa-home" role="iconpicker"></button>
        			</div>
        		</div>
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn--primary">Create</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="post">
      <div class="modal-body">
            @csrf
            <div class="form-group">
                <label>Plan Name</label>
                <input type="text" name="name" placeholder="Plan Name" class="form-control">
            </div>
            <div class="form-group">
                <label>Plan Price</label>
                <input type="text" name="price" placeholder="Plan Price" class="form-control">
            </div>
            <div class="form-group">
                <label>Subscription Duration</label>
                <div class="input-group">
                    <input type="text" name="duration" placeholder="Subscription Duration" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">Days</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Icon</label>
                <div class="input-group has_append">
                    <input type="text" class="form-control" name="icon" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary iconPicker"
                        data-icon="fas fa-home" role="iconpicker"></button>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn--primary">Update</button>
      </div>
        </form>
    </div>
  </div>
</div>

@endsection


@push('breadcrumb-plugins')
    <button class="icon-btn addBtn"><i class="la la-plus"></i>Add New</button>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush
@push('script')
<script type="text/javascript">
	$('.addBtn').click(function(){
		var modal = $('#addModal');
		modal.modal('show');
	});
    $('.editBtn').click(function(){
        var modal = $('#updateModal');
        modal.find('input[name=name]').val($(this).data('name'));
        modal.find('input[name=price]').val($(this).data('pricing'));
        modal.find('input[name=duration]').val($(this).data('duration'));
        modal.find('input[name=icon]').val($(this).data('icon'));
        modal.find('form').attr('action',$(this).data('action'));
        modal.modal('show');
    });
    $('#updateModal').on('shown.bs.modal', function (e) {
        $(document).off('focusin.modal');
    });
    $('#addModal').on('shown.bs.modal', function (e) {
        $(document).off('focusin.modal');
    });
	$('.iconPicker').iconpicker({
            align: 'center', // Only in div tag
            arrowClass: 'btn-danger',
            arrowPrevIconClass: 'fas fa-angle-left',
            arrowNextIconClass: 'fas fa-angle-right',
            cols: 10,
            footer: true,
            header: true,
            icon: 'fas fa-bomb',
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom', // Only in button tag
            rows: 5,
            search: false,
            searchText: 'Search icon',
            selectedClass: 'btn-success',
            unselectedClass: ''
        }).on('change', function (e) {
            $(this).parent().siblings('input[name=icon]').val(`<i class="${e.icon}"></i>`);
        });
</script>
@endpush
