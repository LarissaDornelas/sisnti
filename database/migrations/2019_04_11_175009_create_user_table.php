<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	protected $table = 'user';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('username', 45)->unique('cpf_UNIQUE');
			$table->string('name', 150);
			$table->string('email', 100);
			$table->string('cpf', 45)->nullable();
			$table->string('phone', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
