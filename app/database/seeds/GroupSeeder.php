<?php
 
use App\Modules\Avelca_User\Models\Group;

class GroupSeeder extends Seeder {
 
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
		 
			$groups = array(
			array(
				'name' => 'Customer',
				'permissions' => json_encode($all_permissions)
			)
			);
		 
			// Create or Update Group
			for($i = 0; $i < count($groups); $i++)
			{
				$group = Group::firstOrNew(array('name' => $groups[$i]['name']));
				$group->permissions = $groups[$i]['permissions'];
				$group->save();
			}
	}
 
}