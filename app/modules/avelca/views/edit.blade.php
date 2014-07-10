<!-- Modal -->
<div class="modal fade" id="modal_edit_{{ $record->id }}">
	<div class="modal-dialog {{ $modalDialog }}">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal_edit">Update {{ $name }}</h4>
			</div>
			<div class="modal-body">
				{{ Form::model($record, array('enctype' =>  "$enctype", 'class' => 'form-horizontal', 'url' => URL::to('admin/'.$routeName.'/edit', $record->id))) }}
				@include('avelca::rowFormEdit')

				<?php $customView = 'admin.'.$routeName.'.additional.edit'; ?>
				@if(View::exists($customView))
				@include($customView)
				@endif
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;"><i class="fa fa-save fa-fw"></i> Save changes</button>
			</div>
			{{ Form::close() }}

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_approve_{{ $record->id }}">
	<div class="modal-dialog {{ $modalDialog }}">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal_edit">Approve {{ get_class($Model) }}</h4>
			</div>
			<div class="modal-body">
				hahah
				

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