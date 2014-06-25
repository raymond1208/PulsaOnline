<?php

class PermissionSeeder extends Seeder {

	public function run()
	{
		
		/* Products */
		$permissions = array(
			"product",
			"product.index",
			"product.create",
			"product.view",
			"product.edit",
			"product.delete"
			);

Permission::whereIn("name", $permissions)->delete();

foreach ($permissions as $permission)
{
	Permission::create(array("name" => $permission));
}


		/* Report */
		$permissions = array(
			"report",
			"report.index",
			"report.create",
			"report.view",
			"report.edit",
			"report.delete",
			"report.best-seller-product"
			);

Permission::whereIn("name", $permissions)->delete();

foreach ($permissions as $permission)
{
	Permission::create(array("name" => $permission));
}

		/* Banks */
		$permissions = array(
			"bank",
			"bank.index",
			"bank.create",
			"bank.view",
			"bank.edit",
			"bank.delete"
			);

Permission::whereIn("name", $permissions)->delete();

foreach ($permissions as $permission)
{
	Permission::create(array("name" => $permission));
}


		/* Sales Orders */
		$permissions = array(
			"sales-order",
			"sales-order.index",
			"sales-order.create",
			"sales-order.view",
			"sales-order.edit",
			"sales-order.delete"
			);

Permission::whereIn("name", $permissions)->delete();

foreach ($permissions as $permission)
{
	Permission::create(array("name" => $permission));
}


		/* Statuses */
		$permissions = array(
			"status",
			"status.index",
			"status.create",
			"status.view",
			"status.edit",
			"status.delete"
			);

Permission::whereIn("name", $permissions)->delete();

foreach ($permissions as $permission)
{
	Permission::create(array("name" => $permission));
}


	} /* public function run */
} /* class */