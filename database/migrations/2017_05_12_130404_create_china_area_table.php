<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChinaAreaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('china_area', function(Blueprint $table)
		{
			$table->smallInteger('id', true)->unsigned();
			$table->smallInteger('parent_id')->unsigned()->default(0)->index('parent_id');
			$table->string('name', 120)->default('');
			$table->boolean('type')->default(2)->index('type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('china_area');
	}

}
