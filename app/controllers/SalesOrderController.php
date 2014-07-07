<?php

class SalesOrderController extends AvelcaController {

	public function __construct(\SalesOrder $Model)
	{
		parent::__construct($Model);
	}

	
	public function retrieveRecords()
	{
		$user = Sentry::getUser();
		$group_id = $user->groups()->first()->id;
		
		if($group_id == 1)
		{
			return SalesOrder::all();
		}
		else
		{
			return SalesOrder::where('customer_id', '=', $user->id)->get();
		}
	}
}