<?php

class ReportController extends \BaseController {

	public function getIndex()
	{
		$user = Sentry::getUser();

		if ($user->hasAccess('report.best-seller-product'))
		{
			
			$startdate = date('Y-m-').'1';
			$enddate   = date('Y-m-').'31';
		
			
			
			$data['bestsellers'] = Product::join('sales_order_items', 'products.id', '=', 'sales_order_items.product_id')
		   ->select('products.name', DB::raw('COUNT(sales_order_items.id) as jumlah_kode'))
		   ->where('sales_order_items.created_at', '>', $startdate)
		   ->where('sales_order_items.created_at', '<', $enddate)
		   ->groupBy('products.name')
		   ->orderBy('jumlah_kode', 'desc')
		   ->get(); 
		   
			//echo "Function getIndex";
			return View::make('admin.report.best-seller-product', $data);
		}
	}

	public function getBestSellerProduct()
	{
  
		  $startdate = Input::get('start_date') ? Input::get('start_date') : date('Y-m-').'1';
		  $enddate   = Input::get('end_date') ? Input::get('end_date') : date('Y-m-').'31';
		  
		  $data['bestsellers'] = Product::join('sales_order_items', 'products.id', '=', 'sales_order_items.product_id')
		   ->select('products.name', DB::raw('COUNT(sales_order_items.id) as jumlah_kode'))
		   ->where('sales_order_items.created_at', '>', $startdate)
		   ->where('sales_order_items.created_at', '<', $enddate)
		   ->groupBy('products.name')
		   ->orderBy('jumlah_kode', 'desc')
		   ->get();  
		   
		  //echo "getBestSellerProduct";

		  return View::make('admin.report.best-seller-product', $data);
	}
	
	public function postIndex()
	{
		return $this->getBestSellerProduct();
	}
	
}
