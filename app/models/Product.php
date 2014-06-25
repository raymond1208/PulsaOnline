<?php
class Product extends Eloquent {

	/* Soft Delete */
	protected $softDelete = true;

	/* Eloquent */
	public $table = "products";
	public $timestamps = true;

	

	

	/* Disabled Basic Actions */
	public static $disabledActions = array();

	/* Route */
	public $route = 'product';

	/* Mass Assignment */
	protected $fillable = array(
		'name',
'price',
'is_available'
		);
	protected $guarded = array('id');

	/* Rules */
	public static $rules = array(
		'name' => 'required',
'price' => 'required',
'is_available' => 'required'
		);

	/* Database Structure */
	public static function structure()
	{
		$fields = array(
			'name' => array(
			'type' => 'text',
			'onIndex' => true
		),
'price' => array(
			'type' => 'number',
			'onIndex' => true
		),
'is_available' => array(
			'type' => 'radio',
			'onIndex' => true,
			'inline' => true,
			'values' => array(
			'Yes' => 'Yes',
			'No' => 'No'
			)
)
			);

		return compact('fields');
	}


}