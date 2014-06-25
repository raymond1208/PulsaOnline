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
			'dashboard.customer'
		);
	 
		$all_permissions = array();
		foreach ($permissions as $permission) {
			$all_permissions[$permission] = 1;
		}
	 
		$groups = array(
		array(
			'name' => 'Customer',
			'permissions' => json_encode($all_permissions)
		)
		);
	 
		for($i = 0; $i < count($groups); $i++)
		{
			Group::whereName($groups[$i]['name'])->forceDelete();
			Group::create($groups[$i]);
		}
	
	}

}