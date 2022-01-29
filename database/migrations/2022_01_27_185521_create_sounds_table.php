<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create( 'sounds', function ( Blueprint $table ) {
			$table->id();
			$table->unsignedBigInteger( 'user_id' );
			$table->string( 'name' );
			$table->text( 'description' );
			$table->time( 'duration' );
			$table->smallInteger( 'bit_depth' );
			$table->smallInteger( 'bit_rate' );
			$table->string( 'file_url' );
			$table->integer( 'likes' );
			$table->integer( 'plays' );
			$table->timestamps();
		} );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       	Schema::dropIfExists( 'sounds' );
    }
}
