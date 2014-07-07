<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomersIdToSalesOrder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	 
	public function up()
	{
		Schema::table('sales_orders', function($table)
		{
			$table->integer("customer_id");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	 
	public function down()
	{
		//
		Schema::table('sales_orders', function($table)
		{
			$table->dropColumn("customer_id");
		});
	}

}
