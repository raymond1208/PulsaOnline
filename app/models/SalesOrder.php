<?php
class SalesOrder extends Eloquent {

	/* Soft Delete */
	protected $softDelete = true;

	public static $modalDialog = 'large';
	
	/* Eloquent */
	public $table = "sales_orders";
	public $timestamps = true;

	public static $formItem = "sales_order_items";


				public function sales_order_items()
				{
					return $this->hasMany('SalesOrderItem');
				}
				

	
	public static function boot()
	{
		parent::boot();
	 
		static::creating(function($record)
		{
			$record->code = 'SO-'.date('Y-m-d-H-i-s');
			$record->is_paid = 'No';
		});
	}
	

	/* Disabled Basic Actions */
	public static $disabledActions = array();

	/* Route */
	public $route = 'sales-order';

	/* Mass Assignment */
	protected $fillable = array(
		'code',
'sales_date',
'bank_id', 'is_paid'
		);
	protected $guarded = array('id');

	/* Rules */
	public static $rules = array(
'sales_date' => 'required',
'bank_id' => 'required'
		);

	/* Database Structure */
	public static function structure()
	{
		$fields = array(
			'code' => array(
			'type' => 'text',
			'fillable' => false,
			'onIndex' => true
		),
'sales_date' => array(
			'type' => 'datepicker',
			'onIndex' => true
		),
'bank_id' => array(
			'type' => 'select',
			'onIndex' => true
	,'table' => 'banks'
),
'is_paid' => array(
			'type' => 'radio',
			'fillable' => false,
			'values' => array(
			'Yes' => 'Yes',
			'No' => 'No'
			),
			'inline' => true,
			'onIndex' => true
)
			);

		return compact('fields');
	}


}