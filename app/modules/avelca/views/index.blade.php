@extends('layouts/default')

@section('content')

<?php $user = Sentry::getUser(); ?>

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
			<li class="active">{{ $name }}</li>
		</ol>

		<?php $customView = 'admin.'.$routeName.'.index'; ?>
		@if(View::exists($customView))
		@include($customView)
		@else


		<div class="page-header">
			<h1>
				{{ $name }}
				<small>List ooo</small>

				<span class="pull-right">	
					@if($user->hasAccess($routeName.'.create'))
					@if( ! in_array('create', $disabledActions) )
					<a href="#" class="btn" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;" id="new_button">
						<i class="fa fa-plus fa-fw"></i>
						Create New
					</a>
					@endif
					@endif
				</span>
			</h1>
		</div>

		<div class="table-responsive" id="list_page">

			<span class="text-left">

				<a href="#" id="filter" class="btn btn-default"><i class="fa fa-filter fa-fw"></i><span class="caret"></span></a>

				@if( count($mainButtons) > 0)
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-fw fa-th"></i> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu multi-level">
						@foreach($mainButtons as $action_button => $urls)
						@if( is_array($urls) )
						<li class="divider"></li>
						<li class="dropdown-submenu"><a tabindex="-1" href="#">{{ $action_button }}</a>
							<ul class="dropdown-menu">
								@foreach($urls as $url => $key)
								@if($user->hasAccess($routeName.'.'.$key))
								<li><a href="{{ URL::to('admin/'.$routeName.'/'.$key) }}">{{ $url }}</a></li>
								@endif
								@endforeach
							</ul>
						</li>
						@else
						@if($user->hasAccess($routeName.'.'.$urls))
						<li><a href="{{ URL::to('admin/'.$routeName.'/'.$urls) }}">{{ $action_button }}</a></li>
						@endif
						@endif
						@endforeach

						<?php $customView = 'admin.'.$routeName.'.menu.main'; ?>
						@if(View::exists($customView))
						@include($customView)
						@endif
					</ul>
				</div>
				@endif

				<p>&nbsp;</p>
			</span>

			<form class="form-horizontal well" role="form" style="display: none;">
				<legend>Filter</legend>
				@foreach($indexFields as $field => $structure)
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">{{ App\Modules\Avelca\Controllers\AvelcaController::tableHeader($field, $structure) }}</label>
					<div class="col-sm-4" id="{{ $field.'_filter' }}"></div>
				</div>
				@endforeach
			</form>

			<table class="datatable table table-striped table-bordered">
				<thead>
					<tr>
						@foreach($indexFields as $field => $structure)
						<th class="text-center">{{ App\Modules\Avelca\Controllers\AvelcaController::tableHeader($field, $structure) }}</th>
						@endforeach
						<td id="actionColumn">&nbsp;</td>
					</tr>
				</thead>
				<tbody>
					<?php $customView = 'admin.'.$routeName.'.rowTable'; ?>
					@if(View::exists($customView))
					@include($customView)
					@else
					@include('avelca::rowTable')
					@endif
				</tbody>
				<tfoot>
					<tr>
						@foreach($indexFields as $field => $structure)
						<th>&nbsp;</th>
						@endforeach
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
		</div>

		<?php $customView = 'admin.'.$routeName.'.additional.index'; ?>
		@if(View::exists($customView))
		@include($customView)
		@endif

		<div id="create_page" style="display: none;">
			<?php $customView = 'admin.'.$routeName.'.create'; ?>
			@if(View::exists($customView))
			@include($customView)
			@else
			@include('avelca::create')
			@endif
		</div>

		@foreach($records as $record)
		@include('avelca::view')
		@include('avelca::edit')
		@include('avelca::delete')
		@endforeach

	</div>
</div>

<?php $customView = 'admin.'.$routeName.'.js.datatable'; ?>
@if(View::exists($customView))
@include($customView)
@else
@include('avelca::js.datatable')
@endif

<?php $customView = 'admin.'.$routeName.'.js.script'; ?>
@if(View::exists($customView))
@include($customView)
@else
@include('avelca::js.script')
@endif


@endif
@stop
