<?php

namespace App\Http\Controllers;

use App\Models\Sound;
use  Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

use getID3;


class SoundController extends Controller {


	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */
	public function index() {

		$audio = Sound::all();

		return Inertia::render( 'Frontend/Home', [
			'canLogin'    => Route::has( 'login' ),
			'canRegister' => Route::has( 'register' ),
			//			'laravelVersion' => Application::VERSION,
			'phpVersion'  => PHP_VERSION,
			'audio'       => $audio

		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */

	public function dashboard() {

		//TODO add liked sounds to audio array


		$audio = Sound::all();


		//		dd( $audio );

		return Inertia::render( 'Backend/Dashboard', [

			'audio' => $audio,

		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */
	public function create() {

		// Get all tags for used with sounds
		$allTags = Sound::allTags();

		return Inertia::render( 'Backend/UploadSound', [ 'allTags' => $allTags ] );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {


		// Get user id
		$userId = auth()->user()->id;

		// Validation
		$request->validate( [
			'name'        => 'required |string|min:1|max:100',
			'description' => 'required |string|min:1|max:200',
			'sound_file'  => 'required |file|mimes:audio/mp3,wav',

		] );

		// Create slug for assets using the name from request
		$slug = SlugService::createSlug( Sound::class, 'slug', $request->name );


		// Upload sound file
		if ( $request->hasFile( 'sound_file' ) ) {

			$audioFile = $request->sound_file;

			// Initialize id3 engine
			// Initialize id3 engine
			$id3       = new getID3();
			$audioData = $id3->analyze( $audioFile );


			$bit_depth        = $audioData['audio']['bits_per_sample'];
			$duration_seconds = $audioData['playtime_seconds'];
			$duration_string  = $audioData['playtime_string'];
			$bit_rate         = $audioData['audio']['bitrate'];
			$sample_rate      = $audioData['audio']['sample_rate'];
			$file_size        = $audioData['filesize'];

			// Folder location for sounds under user id
			$sound_location = 'uploads/' . $userId . '/sounds';

			// Check if folder exists, make if not
			if ( ! file_exists( $sound_location ) ) {
				Storage::makeDirectory( $sound_location );

			}

			// This will return "mp3" not the file name
			$audioType     = $audioFile->getClientOriginalExtension();
			$audioFileName = uniqid() . '_' . $slug . '.' . $audioType;

			$audioFile->move( $sound_location, $audioFileName );
			$file_url = '/' . $sound_location . '/' . $audioFileName;



		}

		// Create Screenplay in DB
		$sound = Sound::create( [
			'user_id'          => $userId,
			'name'             => $request->get( 'name' ),
			'description'      => $request->get( 'description' ),
			'slug'             => $slug,
			'duration_seconds' => $duration_seconds,
			'duration_string'  => $duration_string,
			'file_size'        => $file_size,
			'bit_depth'        => $bit_depth,
			'bit_rate'         => $bit_rate,
			'sample_rate'      => $sample_rate,
			'file_url'         => $file_url,


		] );


		$sound->tag( $request->tags );




	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Sound $song
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( Sound $song ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Sound $song
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Sound $song ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Sound $sound
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Sound $sound ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Sound $song
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Sound $song ) {
		//
	}


	/**
	 * record likes of sounds
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * //     * @return \Illuminate\Http\Response
	 */
	public function likeSound( $sound ) {


		$thisSound = Sound::find( '8' );
		$response  = auth()->user()->toggleLike( $thisSound );

		return response()->json( [ 'success' => $response ] );

	}


}
