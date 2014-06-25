<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		/* Wajib Jika Ada Tambahan Group */
		AvelcaController::createAdministratorPermissions();
	 
		/* Groups */
		$permissions = array(
			'dashboard',
			'sales-order',
			'sales-order.create',
			'sales-order.view'
		);
	 
		$all_permissions = array();
		foreach ($permissions as $permission) {
			$all_permissions[$permission] = 1;
		}
	 
	 	// Create the group
		$group = Sentry::getGroupProvider()->create(array(
			'name'        => 'Customer',
			'permissions' => $all_permissions
			));
	
	}

}