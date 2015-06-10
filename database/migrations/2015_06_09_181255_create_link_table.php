<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLinkTable
 */
class CreateLinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('link', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('favorites');
			$table->mediumText('from_url');
			$table->mediumText('from_url_hostname');
			$table->mediumText('to_url');
			$table->mediumText('anchor_text');
			$table->string('link_status');
			$table->string('type');
			$table->bigInteger('bl_dom');
			$table->integer('dom_pop');
			$table->integer('power');
			$table->integer('trust');
			$table->integer('power_trust');
			$table->bigInteger('alexa')->nullable();
			$table->string('ip');
			$table->string('country');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('link');
	}

}
