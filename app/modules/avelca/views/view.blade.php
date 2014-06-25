<!-- Modal -->
<div class="modal fade" id="modal_view_{{ $record->id }}">
	<div class="modal-dialog {{ $modalDialog }}">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal_edit">View {{ get_class($Model) }}</h4>
			</div>
			<div class="modal-body">
				{{ Form::model($record, array('class' => 'form-horizontal')) }}
				@include('avelca::rowView')

				<?php $customView = 'admin.'.$routeName.'.additional.view'; ?>
				@if(View::exists($customView))
				@include($customView)
				@endif
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>