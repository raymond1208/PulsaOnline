<?php

class DashboardController extends BaseController {

	public function getIndex()
	{
		$user = Sentry::getUser();
		$group_id = $user->groups()->first()->id;

		if ($group_id == 1 && $user->hasAccess('dashboard'))
		{
			//kode 1 adalah untuk administrator
			$data['sales_orders'] = SalesOrder::all();			
			
		   return View::make('dashboard.index', $data);
		}
		
		if ($group_id == 2 && $user->hasAccess('dashboard'))
		{
			//kode 2 adalah untuk konsumen
			return View::make('dashboard.customerindex');
		}
		
	}
}