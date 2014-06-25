<?php
class Bank extends Eloquent {

	/* Soft Delete */
	protected $softDelete = true;

	/* Eloquent */
	public $table = "banks";
	public $timestamps = true;

	

	/* Disabled Basic Actions */
	public static $disabledActions = array();

	/* Route */
	public $route = 'bank';

	/* Mass Assignment */
	protected $fillable = array(
		'name',
'owner',
'bank_account'
		);
	protected $guarded = array('id');

	/* Rules */
	public static $rules = array(
		'name' => 'required',
'owner' => 'required',
'bank_account' => 'required'
		);

	/* Database Structure */
	public static function structure()
	{
		$fields = array(
			'name' => array(
			'type' => 'text',
			'onIndex' => true
		),
'owner' => array(
			'type' => 'text',
			'onIndex' => true
		),
'bank_account' => array(
			'type' => 'text',
			'onIndex' => true
		)
			);

		return compact('fields');
	}


}