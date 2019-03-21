<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlumnosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 25);
			$table->string('apellidos', 50);
			$table->string('domicilio', 80);
			$table->string('telefono', 25)->nullable();
			$table->boolean('info');
			$table->boolean('bolsa');
			$table->string('cv_enlace', 80)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alumnos');
	}

}
