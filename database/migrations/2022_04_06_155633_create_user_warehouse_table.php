<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use App\Models\User;

class CreateUserWarehouseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_warehouse', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->integer('user_id')->index('user_warehouse_user_id');
			$table->integer('warehouse_id')->index('user_warehouse_warehouse_id');
		});

		 // assigned Warehouses to users
		 $warehouses = Warehouse::where('deleted_at', null)->pluck('id')->toArray();
		 $users = User::where('deleted_at', null)->get();

		 foreach ($users as $user) {
			 $user->assignedWarehouses()->sync($warehouses);
		 }

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_warehouse');
	}

}
