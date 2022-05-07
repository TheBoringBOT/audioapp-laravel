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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class SoundController extends Controller {


	// Get all the sounds and add likes

	public function getAllSounds() {
		$soundData = Sound::all();
		if ( Auth::check() ) {
			$user = Auth::user();

			$likes   = $user->likes()->get()->toArray();
			$likeIds = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );


			// Checking if song is liked and adding new key value liked => true or false to sounds collection
			$soundData->map( function ( $i ) use ( $likeIds, $user ) {
				in_array( $i->id, $likeIds ) ? $i['liked'] = true : $i['liked'] = false;

				// Added sound uploader username to each sound
				$i['creator'] = User::find( $i->user_id )->name;
			} );

		} else {
			$soundData->map( function ( $i ) {
				// Added sound uploader username to each sound
				$i['creator'] = User::find( $i->user_id )->name;
			} );
		}


		return $soundData;
	}

	// Get all the sounds the user uploaded
	public function getUserSounds( $args ) {


		$user      = Auth::user();
		$soundData = Sound::where( 'user_id', $user->id )->get();

		$likes   = $user->likes()->get()->toArray();
		$likeIds = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );


		// Checking if song is liked and adding new key value liked => true or false to sounds collection
		$soundData->map( function ( $i ) use ( $likeIds, $args ) {
			in_array( $i->id, $likeIds ) ? $i['liked'] = true : $i['liked'] = false;
			// Added sound uploader username to each sound
			$i['creator'] = User::find( $i->user_id )->name;
			if ( $args === 'dashboard' ) {
				$i['edit'] = true;
			}
		} );


		return $soundData;

	}

	// Get all sounds liked by user
	public function getUserLikedSounds() {

		$soundData = Sound::all();
		if ( Auth::check() ) {
			$user = Auth::user();

			$likes   = $user->likes()->get()->toArray();
			$likeIds = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );

			$soundData->map( function ( $key, $i ) use ( $likeIds, $soundData, $user ) {
				if ( in_array( $key->id, $likeIds ) ) {
					//					$soundData->filter( function ( $value, $key ) use ( $remove ) {
					//						return $value['id'] != $remove;
					//					} );
					$soundData->forget( $i );
				}
				// Added sound uploader username to each sound
				$i['creator'] = User::find( $i->user_id )->name;

			} );
		}


		return $soundData;

	}


	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */
	public function index() {

		$popularTags = Sound::popularTags( 5 );
		$sounds      = Sound::all()->take( 9 );
		if ( Auth::check() ) {
			$user    = Auth::user();
			$likes   = $user->likes()->get()->toArray();
			$likeIds = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );
			// Checking if song is liked and adding new key value liked => true or false to sounds collection
			$sounds->map( function ( $i ) use ( $likeIds ) {
				in_array( $i->id, $likeIds ) ? $i['liked'] = true : $i['liked'] = false;
				// Added sound uploader username to each sound
				$i['creator'] = User::find( $i->user_id )->name;
			}

			);

		} else {
			// Checking if song is liked and adding new key value liked => true or false to sounds collection
			$sounds->map( function ( $i ) {

				$i['creator'] = User::find( $i->user_id )->name;
			} );
		}

		return Inertia::render( 'Frontend/Sounds', [
			'canLogin'    => Route::has( 'login' ),
			'canRegister' => Route::has( 'register' ), //			'laravelVersion' => Application::VERSION,
			'phpVersion'  => PHP_VERSION,
			'soundData'   => $sounds,
			'popularTags' => array_keys( $popularTags )
		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */

	public function dashboard() {
		$s = $this->getuserSounds( 'dashboard' );


		return Inertia::render( 'Backend/Dashboard', [
			'soundData' => $s,

		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */

	public function userLikedSoundsPage() {

		return Inertia::render( 'Backend/LikedSounds', [
			'soundData' => $this->getUserLikedSounds(),

		] );
	}

	//	/**
	//	 * Display a listing of the resource.
	//	 *
	//	 * @return \Illuminate\Http\Response
	//	 */
	public function create() {

		// Get all tags used in list to choose when uploading
		$allTags = Sound::allTags();

		//  dd($allTags);


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

		//		                                   dd($request->tags);
		// Get user id
		$userId = auth()->user()->id;

		// Validation
		$request->validate( [
			'name'        => 'required |string|min:1|max:100',
			'description' => 'required |string|min:1|max:200',
			'sound_file'  => 'required |file|mimes:audio/mpeg,wav',

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

		// Create Sound in DB
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

		return Redirect::route( 'upload' );


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
		$soundData['creator']     = User::find( $soundData->user_id )->name;
		if ( Auth::check() ) {
			$user = User::find( auth()->user()->id );
			$user && $user->hasLiked( $soundData ) ? $soundData['liked'] = true : $soundData['liked'] = false;
		}


		$tags = explode( ',', $soundData->tagList );


		return Inertia::render( 'Frontend/SoundItem', [
			'canLogin'    => Route::has( 'login' ),
			'canRegister' => Route::has( 'register' ),

			'soundData' => $soundData,
			'tags'      => $tags,
			'likes'     => $likes,


		] );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Sound $song
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $sound ) {


		$s = Sound::find( $sound );

		//get tags
		$tags      = explode( ',', $s->tagList );
		$tagsGroup = DB::table( 'taggable_tags' )->whereIn( 'name', $tags )->get()->map( function ( $tag ) {
			return [
				'value' => $tag->tag_id,
				'label' => $tag->name,
			];
		} )->toArray();


		//		dd( $tagsGroup );

		return Inertia::render( 'Backend/EditSound', [
			'sound'   => [
				'id'          => $s->id,
				'name'        => $s->name,
				'description' => $s->description,

			],
			'tags'    => $tagsGroup,
			'allTags' => Sound::allTags()
		] );




	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Sound $sound
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Sound $sound ) {


		// Get user id
		$userId = auth()->user()->id;
		// Validation
		$request->validate( [
			'name'        => 'required|string|min:1|max:100',
			'description' => 'required|string|min:1|max:200',
			'sound_file'  => 'file|mimes:audio/mpeg,wav',

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


		$s = Sound::findOrFail( $request->id );


		if ( $request->hasFile( 'sound_file' ) ) {
			// Create Sound in DB
			$s->update( [
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
		} else {
			$s->update( [
				'user_id'     => $userId,
				'name'        => $request->get( 'name' ),
				'description' => $request->get( 'description' ),
				'slug'        => $slug,
			] );
		}
		// retag the sound
		$s->retag( $request->tags );

		return Redirect::route( 'dashboard' );


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

		$search = $request->keyword;
		// Check tags that match keyword
		$tagsLikeKeyword = Tag::where( 'name', 'LIKE', "%{$search}%" )->pluck( 'name' )->toArray();
		$tagsToString    = implode( ', ', $tagsLikeKeyword );
		// Get any soundData with found tags
		$soundWithTags = Sound::withAnyTags( $tagsToString )->pluck( 'id' )->toArray();
		//Query soundData matching keyword or matching the soundData with found tags
		$soundData = Sound::where( 'name', 'LIKE', "%{$search}%" )->OrWhereIn( 'id', $soundWithTags )->get();


		if ( Auth::check() ) {
			$user = Auth::user();

			$likes   = $user->likes()->get()->toArray();
			$likeIds = array_map( function ( $ar ) { return $ar['likeable_id']; }, $likes );
			// Checking if song is liked and adding new key value liked => true or false to sounds collection
			$soundData->map( function ( $i ) use ( $likeIds ) {
				in_array( $i->id, $likeIds ) ? $i['liked'] = true : $i['liked'] = false;
				// Added sound uploader username to each sound
				$i['creator'] = User::find( $i->user_id )->name;
			}


			);



		} else {
			// Checking if song is liked and adding new key value liked => true or false to sounds collection
			$soundData->map( function ( $i ) {

				$i['creator'] = User::find( $i->user_id )->name;
			} );
		}


		$popularTags = Sound::popularTags( 5 );


		return inertia( 'Frontend/Sounds', [
			'soundData'   => $soundData,
			'keyword'     => $search,
			'popularTags' => array_keys( $popularTags ),

		] );

	}

	// get author page
	public function author( $authorId ) {

		$author      = User::find( $authorId );
		$popularTags = Sound::popularTags( 5 );
		$sounds      = Sound::all()->where( 'user_id', $author->id );
		$authorName  = $author->name;


		$sounds->each( function ( $item ) {
			$item->push( [ 'creator' => 'fuck' ] );
		} );

		$sounds->map( function ( $i ) use ( $authorName ) {
			// Added sound uploader username to each sound
			$i['creator'] = $authorName;
		} );


		return Inertia::render( 'Frontend/Author', [
			'canLogin'    => Route::has( 'login' ),
			'canRegister' => Route::has( 'register' ), //			'laravelVersion' => Application::VERSION,
			'phpVersion'  => PHP_VERSION,
			'soundData'   => $sounds,
			'author'      => $author,
			'popularTags' => array_keys( $popularTags )
		] );
	}

	// delete sound
	public function destroy( $sound ) {

		try {
			$soundData         = Sound::find( $sound );
			$deleteTaggedSound = DB::table( 'taggable_taggables' )->where( 'taggable_id', $soundData->id )->delete();
			if ( $deleteTaggedSound ) {
				$response = $soundData->delete();
			}

		} //catch exception
		catch ( Exception $e ) {

			return response()->json( [ 'error' => $e->getMessage() ] );
		}

		return response()->json( [ 'success' => $response ] );



	}


}
