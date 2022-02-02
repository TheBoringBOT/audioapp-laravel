<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundTagsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {


		if ( ! Schema::hasTable( 'sound_tags' ) ) {
			Schema::create( 'sound_tags', function ( Blueprint $table ) {
				$table->id();
				$table->foreignId( 'tag_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
				$table->foreignId( 'sound_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
				$table->timestamps();
			} );
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'sound_tags' );
	}
}
