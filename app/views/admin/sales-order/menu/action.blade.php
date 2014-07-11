<?php $user = Sentry::getUser(); ?>

@if($user->hasAccess($routeName.'.approve'))
	@if( ! in_array('approve', $disabledActions) )
		@if ($record->is_paid == 'No')
			<li><a href="{{ URL::to('admin/'.$routeName.'/approve/'.$record->id) }}">Approve</a></li>
		@endif
	@endif
@endif

@if($user->hasAccess($routeName.'.approve'))
	@if( ! in_array('unapprove', $disabledActions) )
		@if ($record->is_paid == 'Yes')
			<li><a href="{{ URL::to('admin/'.$routeName.'/unapprove/'.$record->id) }}">Unapprove</a></li>
		@endif
	@endif
@endif
