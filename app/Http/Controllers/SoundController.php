<?php

namespace App\Http\Controllers;

use App\Models\Sound;
use App\Models\Tag;
use Cviebrock\EloquentTaggable\Taggable;
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

		$soundData = Sound::all();
		$user      = User::find( 1 );
		$likes     = $user->likes()->get()->toArray();
		$likeIds   = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );

		$popularTags = Sound::popularTags( 5 );


		return Inertia::render( 'Frontend/Home', [
			'canLogin'        => Route::has( 'login' ),
			'canRegister'     => Route::has( 'register' ), //			'laravelVersion' => Application::VERSION,
			'phpVersion'      => PHP_VERSION,
			'soundData'       => $soundData,
			'currentUserData' => $likeIds,
			'popularTags'     => array_keys( $popularTags )
		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */

	public function dashboard() {

		//TODO add liked soundData to soundData array


		$soundData = Sound::all();


		//		dd( $soundData );

		return Inertia::render( 'Backend/Dashboard', [

			'soundData' => $soundData,

		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */
	public function create() {

		// Get all tags for used with soundData
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

			// Folder location for soundData under user id
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
		$soundData = Sound::create( [
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


		// Add tags for uploaded sound
		$soundData->tag( $request->tags );



	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * @return \Illuminate\Http\
	 */
	public function show( $sound ) {


		$soundData = Sound::find( $sound );

		$likes = $soundData->likers()->count();
		// format numbers and push back into array
		$soundData['sample_rate'] = number_format( ( $soundData['sample_rate'] / 1000 ), 1 ) . ' khz';
		$currentUser              = User::find( Auth::id() );
		$hasUserLike              = null;
		$currentUserData          = [ 'userLikedSound' => null ];
		if ( $currentUser ) {
			$hasUserLike     = $currentUser->hasLiked( $sound );
			$currentUserData = [ 'userLikedSound' => $hasUserLike ];
		}


		$tags = explode( ',', $soundData->tagList );


		return Inertia::render( 'Frontend/SoundItem', [
			'canLogin'    => Route::has( 'login' ),
			'canRegister' => Route::has( 'register' ),

			'soundData'       => $soundData,
			'tags'            => $tags,
			'likes'           => $likes,
			'hasUserLike'     => $hasUserLike,
			'currentUserData' => $currentUserData,

		] );
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
	 * record likes of soundData
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * //     * @return \Illuminate\Http\Response
	 */
	public function likeSound( $sound ) {


		$user = User::find( Auth::id() );

		$thisSound = Sound::find( $sound );
		$response  = $user->toggleLike( $thisSound );

		return response()->json( [ 'success' => $response ] );


	}

	/**
	 * record plays of soundData
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * //     * @return \Illuminate\Http\Response
	 */
	public function updatePlays( $sound ) {


		$thisSound         = Sound::find( $sound );
		$currentPlaysCount = $thisSound['plays'];
		dd( $currentPlaysCount );
		$response = $thisSound->update( [ 'plays' => $thisSound['plays'] + 1 ] );

		return response()->json( [ 'success' => $response ] );

	}

	/**
	 * Download  soundData
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * //     * @return \Illuminate\Http\Response
	 */

	public function download( $sound ) {


		$s = Sound::find( $sound );
		// add download coutn to database
		$s->increment( 'downloads', 1 );

		$filepath = public_path( $s['file_url'] );


		return response()->download( $filepath );


	}

	/**
	 * Search  soundData
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * //     * @return \Illuminate\Http\Response
	 */

	public function search( Request $request ) {


		$user        = User::find( 1 );
		$likes       = $user->likes()->get()->toArray();
		$likeIds     = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );
		$popularTags = Sound::popularTags( 5 );


		$search = $request->keyword;
		// Check tags that match keyword
		$tagsLikeKeyword = Tag::where( 'name', 'LIKE', "%{$search}%" )->pluck( 'name' )->toArray();
		$tagsToString    = implode( ', ', $tagsLikeKeyword );
		// Get any soundData with found tags
		$soundWithTags = Sound::withAnyTags( $tagsToString )->pluck( 'id' )->toArray();
		//Query soundData matching keyword or matching the soundData with found tags
		$soundData = Sound::where( 'name', 'LIKE', "%{$search}%" )->OrWhereIn( 'id', $soundWithTags )->get()->toArray();


		return inertia( 'Frontend/Home', [
			'soundData'       => $soundData,
			'keyword'         => $search,
			'currentUserData' => $likeIds,
			'popularTags'     => array_keys( $popularTags ),

		] );

	}


}
