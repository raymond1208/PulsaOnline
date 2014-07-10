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
			$salesorder = SalesOrder::orderBy('id', 'desc');
			
			if($salesorder->count() == 0)
			{			
				$next_id = 1;
			}
			else
			{
				$salesorder = $salesorder->first();
				$next_id = ($salesorder->id) + 1;
			}
			
			$record->code = 'SO-'.date('y').'-'.$next_id;
			$record->is_paid = 'No';
			
			$record->customer_id = Sentry::getUser()->id;
			
			$data = array(
						'code' => $record->code,
						'date' => $record->sales_date,
                        'is_paid' => $record->is_paid
						);
			
					Mail::pretend(array('html' => 'avelca_user::emails.notification'), $data, function($message)
					{
						$message->from(Setting::meta_data('general','administrator_email')->value, Setting::meta_data('general','organization')->value.' Administrator')->subject('New Transaction Notification');
						$message->to('internship_rj@avelca.com', 'Pulsa Online Owner')->subject('New Transaction Notification');
					});
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
),

	'customer_id' => array(
			'type' => 'select',
			'fillable' => false,
			'onIndex' => true,
			'table' => 'users'
		)
			);
			
		return compact('fields');
	}


}