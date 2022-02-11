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

Route::get( '/', [ \App\Http\Controllers\SoundController::class, 'index' ] )->name( 'home' );

// Sound item page
Route::get( '/sound/{id}', [ \App\Http\Controllers\SoundController::class, 'show' ] )->name( 'sound.item' );


Route::get( '/dashboard', [
	\App\Http\Controllers\SoundController::class,
	'dashboard'
] )->middleware( [ 'auth', 'verified' ] )->name( 'dashboard' );


//Upload Sound page
Route::get( '/dashboard/upload', [ \App\Http\Controllers\SoundController::class, 'create' ] )->middleware( [
	'auth',
	'verified'
] )->name( 'upload' );

//Upload post Sound
Route::post( '/dashboard/upload', [ \App\Http\Controllers\SoundController::class, 'store' ] )->middleware( [
	'auth',
	'verified'
] )->name( 'upload.store' );


// toggle sound like
Route::post( 'like/{id}', [ \App\Http\Controllers\SoundController::class, 'likeSound' ] )->middleware( [
	'auth',
	'verified'
] )->name( 'like' );


require __DIR__ . '/auth.php';
