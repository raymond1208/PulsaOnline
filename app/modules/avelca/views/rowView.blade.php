
@foreach($fields as $field => $structure)
<div class="form-group">
	{{ App\Modules\Avelca\Controllers\AvelcaController::label($field, $structure) }}
	<div class="col-md-9">
		<p class="form-control-static">
			{{ App\Modules\Avelca\Controllers\AvelcaController::viewIndexContent($record, $structure, $field) }}		
		</p>
	</div>
</div>
@endforeach

@if( ! empty($formItem))

<?php
$Model = str_singular(studly_case($formItem));
$indexFields = $Model::structure()['fields']; 
?>

<div class="table-responsive" id="list_page">

	<table class="table table-striped table-bordered" id="table_item">
		<thead>
			<tr>
				@foreach($indexFields as $field => $structure)
				@if( $structure['type'] != 'fk')
				<th class="text-center">{{ App\Modules\Avelca\Controllers\AvelcaController::tableHeader($field, $structure) }}</th>
				@endif
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($record->$formItem()->get() as $record_item)
			<tr>
				@foreach($indexFields as $field => $structure)
				@if( $structure['type'] != 'fk')
				<td>{{ App\Modules\Avelca\Controllers\AvelcaController::viewIndexContent($record_item, $structure, $field) }}</td>
				@endif
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

<?php $customView = 'admin.'.$routeName.'.additionalView'; ?>
@if(View::exists($customView))
@include($customView)
@endif

@endif