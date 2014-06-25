<?php

class DashboardController extends BaseController {

	public function getIndex()
	{
		$user = Sentry::getUser();
		$group_id = $user->groups()->first()->id;

		if ($group_id == 1 && $user->hasAccess('dashboard'))
		{
			return View::make('dashboard.index');
		}
		
		if ($group_id == 2 && $user->hasAccess('dashboard'))
		{
			return View::make('dashboard.customerindex');
		}
		
	}
}