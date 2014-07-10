<?php $user = Sentry::getUser(); ?>

@if($user->hasAccess($routeName.'.approve'))
	@if( ! in_array('approve', $disabledActions) )
		<li><a href="{{ URL::to('admin/'.$routeName.'/approve/'.$record->id) }}">Approve</a></li>
	@endif
@endif

@if($user->hasAccess($routeName.'.approve'))
	@if( ! in_array('approve', $disabledActions) )
		<li><a href="{{ URL::to('admin/'.$routeName.'/unapprove/'.$record->id) }}">Un Approve</a></li>
	@endif
@endif
