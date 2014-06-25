<?php namespace App\Modules\Avelca_User\Models;

class Group extends \Eloquent {

	protected $softDelete = true;

	/* Eloquent */
	protected $table = "groups";
	public $timestamps = true;
		
}