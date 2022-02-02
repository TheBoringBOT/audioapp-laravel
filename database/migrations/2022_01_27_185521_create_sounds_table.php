<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'sounds', function ( Blueprint $table ) {
			$table->id();
			$table->unsignedBigInteger( 'user_id' );
			$table->string( 'name' );
			$table->text( 'description' );
			$table->string( 'slug' );
			$table->time( 'duration_seconds' );
			$table->string( 'duration_string' );
			$table->string( 'file_size' );
			$table->tinyInteger( 'bit_depth' );
			$table->integer( 'bit_rate' );
			$table->integer( 'sample_rate' );
			$table->string( 'file_url' );
			$table->integer( 'likes' )->default(0);
			$table->integer( 'plays' )->default(0);
			$table->timestamps();



		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'sounds' );
	}
}
