{{ Form::open(array('class' => 'form-horizontal', 'url' => URL::to('admin/'.$routeName.'/create'), 'enctype' =>  "$enctype")) }}

@include('avelca::rowForm')

@if( ! empty($formItem) )

<hr>

<!-- New Row -->
<div class="well" id="new_row">
	<?php
	$Model = str_singular(studly_case($formItem));
	$indexFields = $Model::structure()['fields']; 
	$item_name = ucwords(str_singular(str_replace('_',' ',$formItem)));
	?>

	@foreach($indexFields as $field => $structure)
	@if( $structure['type'] != 'fk' && $field != 'status_id')
	

	
	<div class="form-group">
		{{ App\Modules\Avelca\Controllers\AvelcaController::label($field, $structure) }}
		{{ App\Modules\Avelca\Controllers\AvelcaController::field($field, $structure) }}
	</div>
	
	
	@endif
	@endforeach
	<div class="form-group">
		<div class="col-md-4 col-md-offset-3">
			<a href="javascript:;" class="btn btn" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;" id="add_row"><i class="glyphicon glyphicon-plus"></i> Add</a>
		</div>
	</div>
</div>
<!-- End New Row -->

<hr>

<div class="table-responsive">

	<?php
	$Model = str_singular(studly_case($formItem));
	$indexFields = $Model::structure()['fields']; 
	$item_name = ucwords(str_singular(str_replace('_',' ',$formItem)));
	?>

	<table class="table table-striped table-bordered" id="table_item_create">
		<thead>
			<tr>
				@foreach($indexFields as $field => $structure)
				@if( $structure['type'] != 'fk' && $field != 'status_id')
				<th class="text-center">{{ App\Modules\Avelca\Controllers\AvelcaController::tableHeader($field, $structure) }}</th>
				@endif
				@endforeach
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

@endif
<hr>

<div class="form-group">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn
		@if( ! empty($formItem))
		{{ 'pull-right' }}
		@endif
		" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;"><i class="fa fa-save fa-fw"></i> Save</button>
	</div>
</div>

{{ Form::close() }}

<?php $customView = 'admin.'.$routeName.'.additional.create'; ?>
@if(View::exists($customView))
@include($customView)
@endif