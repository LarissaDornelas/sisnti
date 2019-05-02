<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHistoricTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('historic', function(Blueprint $table)
		{
			$table->foreign('task_id', 'fk_historico_chamado')->references('id')->on('task')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('historic', function(Blueprint $table)
		{
			$table->dropForeign('fk_historico_chamado');
		});
	}

}
