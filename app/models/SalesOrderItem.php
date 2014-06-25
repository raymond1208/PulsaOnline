<?php
class SalesOrderItem extends Eloquent {

	/* Soft Delete */
	protected $softDelete = true;

	/* Eloquent */
	public $table = "sales_order_items";
	public $timestamps = true;

	/* Trigger */
	public static $trigger = 'product_id';
	public static $triggerFields = array('price');
	

	public static $formParent = "sales_order";


				public function sales_order()
				{
					return $this->belongsTo('SalesOrder');
				}
				

	/* Disabled Basic Actions */
	public static $disabledActions = array();

	/* Route */
	public $route = 'sales-order-item';

	/* Mass Assignment */
	protected $fillable = array(
		'sales_order_id',
'phone',
'product_id',
'price',
'status_id'
		);
	protected $guarded = array('id');

	/* Rules */
	public static $rules = array(
		'phone' => 'required',
'product_id' => 'required',
'price' => 'required',
'status_id' => 'required'
		);

	/* Database Structure */
	public static function structure()
	{
		$fields = array(
			'sales_order_id' => array(
			'type' => 'fk',
			'onIndex' => false,
			'fillable' => false,
			'editable' => false
		),
'phone' => array(
			'type' => 'text',
			'onIndex' => true
		),
'product_id' => array(
			'type' => 'select',
			'onIndex' => true,
			'table' => 'products',
			'conditions' => array(
							array(
								'is_available',
								'=',
								'Yes'
								)
							)
					),
'price' => array(
			'type' => 'number',
			'onIndex' => true
		),
'status_id' => array(
			'type' => 'select',
			'onIndex' => true
	,'table' => 'statuses'
)
			);

		return compact('fields');
	}


}