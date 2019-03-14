<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResponsablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responsables', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nombre', 25);
			$table->string('apellidos', 50);
			$table->string('email', 50);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('responsables');
	}

}
