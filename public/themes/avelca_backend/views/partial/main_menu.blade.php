<!-- Auto Detect Model -->
{{ App\Modules\Avelca\Controllers\AvelcaController::mainNavigation() }}
<!-- End Auto Detect Model -->

<?php $customView = 'reportsMenu'; ?>
@if(View::exists($customView) && $user->hasAccess('report.best-seller-product'))
<li>
	<a href="#"><i class="glyphicon glyphicon-stats"></i> Report<span class="fa arrow"></span></a>
	<ul class="nav nav-second-level">
		@include($customView)		
	</ul>
</li>
@endif