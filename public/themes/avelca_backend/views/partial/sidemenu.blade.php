<?php $user = Sentry::getUser(); ?>

<ul class="nav" id="side-menu">

	<li>
		<a href="{{ URL::to('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
	</li>

	@include('partial.main_menu')

</ul>
<!-- /#side-menu -->


