<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_order_items', function($table)
		{
			$table->bigIncrements("id")->unsigned();
			$table->integer("sales_order_id")->unsigned();
$table->string("phone");
$table->integer("product_id")->unsigned();
$table->integer("price")->unsigned();
$table->integer("status_id")->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales_order_items');
	}

}
