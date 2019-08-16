<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemSettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('systemSetting', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('adminUser', 45);
			$table->string('adminPassword', 45);
			$table->integer('requestMax');
			$table->integer('limitReoppening');
			$table->boolean('active');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('systemSetting');
	}

}
