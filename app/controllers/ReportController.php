<?php

class ReportController extends \BaseController {

	public function getIndex()
	{
		$user = Sentry::getUser();

		if ($user->hasAccess('report.best-seller-product'))
		{
			
			$startdate = date('Y-m-').'1';
			$enddate   = date('Y-m-').'31';
		
			$data['indexFields'] = Product::join('sales_order_items', 'products.id', '=', 'sales_order_items.product_id')
		   ->select('products.name', 'sales_order_items.phone', 'sales_order_items.id', 'sales_order_items.created_at')
		   ->where('sales_order_items.created_at', '>', $startdate)
		   ->where('sales_order_items.created_at', '<', $enddate)
		   ->groupBy('sales_order_items.id')
		   ->orderBy('sales_order_items.id', 'desc')
		   ->get(); 
		   
			//echo "Function getIndex";
			return View::make('admin.report.best-seller-product', $data);
		}
	}

	public function getBestSellerProduct()
	{
  
		  $startdate = Input::get('start_date') ? Input::get('start_date') : date('Y-m-').'1';
		  $enddate   = Input::get('end_date') ? Input::get('end_date') : date('Y-m-').'31';
		  
		  $data['indexFields'] = Product::join('sales_order_items', 'products.id', '=', 'sales_order_items.product_id')
		   ->select('products.name', 'sales_order_items.phone', 'sales_order_items.id', 'sales_order_items.created_at')
		   ->where('sales_order_items.created_at', '>', $startdate)
		   ->where('sales_order_items.created_at', '<', $enddate)
		   ->groupBy('sales_order_items.id')
		   ->orderBy('sales_order_items.id', 'desc')
		   ->get();  
		   
		  //echo "getBestSellerProduct";

		  return View::make('admin.report.best-seller-product', $data);
	}
	
	public function postIndex()
	{
		return $this->getBestSellerProduct();
	}
	
}
