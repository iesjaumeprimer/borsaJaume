<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlumnosCiclosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnos_ciclos', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('id_alumno')->unsigned()->index('id_alumno');
			$table->integer('id_ciclo')->unsigned()->index('id_ciclo');
			$table->integer('any');
			$table->boolean('validado');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alumnos_ciclos');
	}

}
