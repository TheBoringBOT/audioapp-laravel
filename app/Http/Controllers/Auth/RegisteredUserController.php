<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Intervention\Image\Facades\Image;


class RegisteredUserController extends Controller {
	/**
	 * Display the registration view.
	 *
	 * @return \Inertia\Response
	 */
	public function create() {
		return Inertia::render( 'Auth/Register' );
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store( Request $request ) {


		$image_path = null;

		$request->validate( [
			'name'        => 'required|string|max:255',
			'email'       => 'required|string|email|max:255|unique:users',
			'description' => 'required|string|min:25|max:300',
			'avatar'      => 'mimes:jpeg,jpg,png,gif|required|max:10000',
			'password'    => [ 'required', 'confirmed', Rules\Password::defaults() ],
		] );


		if ( $request->avatar ) {
			// Create slug for assets using the title from request

			// Rename the Image file and save in the folder
			$image      = $request->file( 'avatar' );
			$image_name = uniqid() . '_' . $request->name . '.jpg';

			$imgFile = Image::make( $image->getRealPath() );


			//  (default uploaded image)

			$imgFile->resize( 300, null, function ( $constraint ) {
				$constraint->aspectRatio();
			} )->save( 'images/profile/' . 'large_' . $image_name );

			// create 1x image
			$imgFile->resize( 150, null, function ( $constraint ) {
				$constraint->aspectRatio();
			} )->save( 'images/profile/' . 'small_' . $image_name );


			// Image path for database
			$image_path = 'images/profile/' . 'large_' . $image_name;

		}


		$user = User::create( [
			'name'        => $request->name,
			'email'       => $request->email,
			'description' => $request->description,
			'avatar'      => '/' . $image_path,
			'password'    => Hash::make( $request->password ),
		] );

		event( new Registered( $user ) );

		Auth::login( $user );

		return redirect( RouteServiceProvider::HOME );
	}
}
