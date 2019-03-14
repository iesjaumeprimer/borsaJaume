<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEmpresesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('empreses', function(Blueprint $table)
		{
			$table->foreign('id', 'users_empresas_foreign')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('empreses', function(Blueprint $table)
		{
			$table->dropForeign('users_empresas_foreign');
		});
	}

}
