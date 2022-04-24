<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::inertia( '/', 'Frontend/Home' )->name( 'home' );

Route::get( '/sounds', [ \App\Http\Controllers\SoundController::class, 'index' ] )->name( 'sounds' );

// Sound item page
Route::get( '/sound/{id}', [ \App\Http\Controllers\SoundController::class, 'show' ] )->name( 'sound.item' );
// About page
Route::inertia( '/about', 'Frontend/About' )->name( 'about' );
// Contact page
Route::inertia( '/contact', 'Frontend/Contact' )->name( 'contact' );

Route::get( '/dashboard', [
	\App\Http\Controllers\SoundController::class,
	'dashboard'
] )->middleware( [ 'auth', 'verified' ] )->name( 'dashboard' );


//Upload Sound page
Route::get( '/upload', [ \App\Http\Controllers\SoundController::class, 'create' ] )->middleware( [
	'auth',
	'verified'
] )->name( 'upload' );

//Upload post Sound
Route::post( '/dashboard/upload', [ \App\Http\Controllers\SoundController::class, 'store' ] )->middleware( [
	'auth',
	'verified'
] )->name( 'upload.store' );


/* === Modifying data in Database routes  === */

// toggle sound like
Route::post( '/like/{id}', [ \App\Http\Controllers\SoundController::class, 'likeSound' ] )->middleware( [
	'auth',
	'verified'
] )->name( 'like' );

// Update sound plays
Route::post( 'play/{id}', [ \App\Http\Controllers\SoundController::class, 'updatePlays' ] )->name( 'play' );

// Search sounds

Route::get( '/search', [ \App\Http\Controllers\SoundController::class, 'search' ] )->name( 'search' );

// Download Sound
Route::get( '/download/{id}', [ \App\Http\Controllers\SoundController::class, 'download' ] )->name( 'download' );

require __DIR__ . '/auth.php';
