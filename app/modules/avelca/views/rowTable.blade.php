<?php $user = Sentry::getUser(); ?>

@foreach($records as $record)
<tr>
	@foreach($indexFields as $field => $structure)
	<td class="text-center">
		{{ App\Modules\Avelca\Controllers\AvelcaController::viewIndexContent($record, $structure, $field) }}		
	</td>
	@endforeach
	<td class="text-center" id="actionColumn">

		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-fw fa-list"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu text-left" role="menu">
				@if($user->hasAccess($routeName.'.view'))
				@if( ! in_array('view', $disabledActions) )
				@if(File::exists(app_path().'/views/admin/'.$routeName.'/view.blade.php'))
				<li><a href="{{ URL::to('admin/'.$routeName.'/view/'.$record->id) }}">View</a></li>
				@else
				<li><a href="#" data-toggle="modal" data-target="#modal_views_{{ $record->id }}">View</a></li>
				@endif
				@endif
				@endif
				
				@if($user->hasAccess($routeName.'.edit'))
				@if( ! in_array('edit', $disabledActions) )
				@if(File::exists(app_path().'/views/admin/'.$routeName.'/edit.blade.php'))
				<li><a href="{{ URL::to('admin/'.$routeName.'/edit/'.$record->id) }}">Update</a></li>
				@else
				<li><a href="#" data-toggle="modal" data-target="#modal_edit_{{ $record->id }}">Update</a></li>
				@endif
				@endif
				@endif
				
				@if($user->hasAccess($routeName.'.delete'))
				@if( ! in_array('delete', $disabledActions) )
				@if(File::exists(app_path().'/views/admin/'.$routeName.'/delete.blade.php'))
				<li><a href="{{ URL::to('admin/'.$routeName.'/delete/'.$record->id) }}">Remove</a></li>
				@else
				<li><a href="#" data-toggle="modal" data-target="#modal_delete_{{ $record->id }}">Remove</a></li>
				@endif
				@endif
				@endif
				
				@if( count($actionButtons) > 0)
				
				@if( ! in_array('view', $disabledActions) && ! in_array('edit', $disabledActions) && ! in_array('delete', $disabledActions) )
				<li class="divider"></li>
				@endif

				@foreach($actionButtons as $action_button => $url)
				<?php
				$url = explode('|', $url);
				$param = '';

				if(count($url) > 1)
				{
					$parameters = explode('/', $url[1]);
					for($i = 0; $i < count($parameters); $i++)
					{
						if($i == 0)
						{
							$param .= '/';
						}
						$param .= $record->$parameters[$i];

						if($i != count($parameters))
						{
							$param .= '/';
						}
					}
				}
				?>
				@if($user->hasAccess($routeName.'.'.$url[0]))
				<li><a href="{{ URL::to('admin/'.$routeName.'/'.$url[0].$param) }}">{{ $action_button }}</a></li>
				@endif

				@endforeach
				@endif

				<?php $customView = 'admin.'.$routeName.'.menu.action'; ?>
				@if(View::exists($customView))
				@include($customView)
				@endif
			</ul>
		</div>

	</td>
</tr>
@endforeach