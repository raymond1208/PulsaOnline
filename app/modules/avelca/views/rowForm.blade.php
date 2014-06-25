@foreach($createFields as $field => $structure)
<div class="form-group">
	{{ App\Modules\Avelca\Controllers\AvelcaController::label($field, $structure, $rules) }}
	{{ App\Modules\Avelca\Controllers\AvelcaController::field($field, $structure, $rules) }}
</div>
@endforeach

