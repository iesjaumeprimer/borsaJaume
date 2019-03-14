<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOfertesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ofertes', function(Blueprint $table)
		{
			$table->foreign('id_empresa', 'empresa_foreign')->references('id')->on('empreses')->onUpdate('CASCADE')->onDelete('SET NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ofertes', function(Blueprint $table)
		{
			$table->dropForeign('empresa_foreign');
		});
	}

}
