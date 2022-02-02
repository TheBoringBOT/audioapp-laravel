<?php

namespace App\Http\Controllers;

use App\Models\Sound;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use getID3;


class SoundController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return Inertia::render( 'Backend/UploadSound' );
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

//			dd( $audioFileName );


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

			'bit_depth'   => $bit_depth,
			'bit_rate'    => $bit_rate,
			'sample_rate' => $sample_rate,
			'file_url'    => $file_url,


		] );

	//	$screenplay->genre()->attach( $request->genre );




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
	 * @param  \App\Models\Sound $song
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Sound $song ) {
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
}
