<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->dateTime('openingDate');
			$table->date('forecastService')->nullable();
			$table->dateTime('finishDate')->nullable();
			$table->text('description', 65535);
			$table->text('note', 65535)->nullable();
			$table->string('patrimony', 45)->nullable();
			$table->text('solution', 65535)->nullable();
			$table->boolean('internal');
			$table->integer('taskPriority_id')->unsigned()->nullable()->index('fk_id_prioridade');
			$table->integer('taskStatus_id')->unsigned()->index('fk_id_status');
			$table->integer('taskCategory_id')->unsigned()->index('fk_id_categoria');
			$table->integer('taskLocal_id')->unsigned()->index('fk_chamado_local_chamado1');
			$table->bigInteger('client_id')->unsigned()->index('fk_chamado_usuarios_cliente');
			$table->bigInteger('manager_id')->unsigned()->nullable()->index('fk_chamado_usuarios_responsavel');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task');
	}

}
