<?php
class Status extends Eloquent {

	/* Soft Delete */
	protected $softDelete = true;

	/* Eloquent */
	public $table = "statuses";
	public $timestamps = true;

	

	

	/* Disabled Basic Actions */
	public static $disabledActions = array();

	/* Route */
	public $route = 'status';

	/* Mass Assignment */
	protected $fillable = array(
		'name'
		);
	protected $guarded = array('id');

	/* Rules */
	public static $rules = array(
		'name' => 'required'
		);

	/* Database Structure */
	public static function structure()
	{
		$fields = array(
			'name' => array(
			'type' => 'text',
			'onIndex' => true
		)
			);

		return compact('fields');
	}


}