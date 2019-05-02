<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('task', function(Blueprint $table)
		{
			$table->foreign('taskLocal_id', 'fk_chamado_local_chamado1')->references('id')->on('taskLocal')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('manager_id', 'fk_chamado_usuarios_responsavel')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('client_id', 'fk_chamado_usuarios_solicitante')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('taskCategory_id', 'fk_id_categoria')->references('id')->on('taskCategory')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('taskPriority_id', 'fk_id_prioridade')->references('id')->on('taskPriority')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('taskStatus_id', 'fk_id_status')->references('id')->on('taskStatus')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('task', function(Blueprint $table)
		{
			$table->dropForeign('fk_chamado_local_chamado1');
			$table->dropForeign('fk_chamado_usuarios_responsavel');
			$table->dropForeign('fk_chamado_usuarios_solicitante');
			$table->dropForeign('fk_id_categoria');
			$table->dropForeign('fk_id_prioridade');
			$table->dropForeign('fk_id_status');
		});
	}

}
