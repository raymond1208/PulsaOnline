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

		$records = new SalesOrder;

		$c = get_class($this->Model);
		$indexFields = $c::structure()['fields'];
		$records = $this->Model;

		foreach ($indexFields as $field => $structure) 
		{
			if (Input::has($field)) 
			{
				$records = $records->where($field, '=', Input::get($field));
			}
		}

		if($group_id != 1)
		{
			$records = $records->where('customer_id', '=', $user->id);
		}


		foreach ($indexFields as $field => $structure) {
			if (Input::has($field)) {
				$records = $records->where($field, '=', Input::get($field));
			}
		}
		
		if($group_id != 1)
		{
			$records = $records->where('customer_id', '=', $user->id);
		}
	

		return $records->get();
	}
	
	public function getApprove($id)
	{
		SalesOrder::where('id', '=', $id)->update(array('is_paid' => 'Yes'));
		SalesOrderItem::where('sales_order_id', '=', $id)->update(array('status_id' => 1));
		
		return \Redirect::to(URL::previous())->with('status', get_class($this->Model).' successfully approved.');
	}
	
	public function getUnapprove($id)
	{
		SalesOrder::where('id', '=', $id)->update(array('is_paid' => 'No'));
		
		return \Redirect::to(URL::previous())->with('status', get_class($this->Model).' successfully un-approved.');
	}
	
	
	
}