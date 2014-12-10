<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
    $galleries = Gallery::all();
    return View::make(
        'index', 
        array(
            'navInfo'=>Gallery::navInfo("home"),
            'galleries'=>$galleries
        )
    );

});

Route::get('about', function() {
    $galleries = Gallery::all();
    return View::make(
        'about', 
        array(
            'navInfo'=>Gallery::navInfo("about"),
            'galleries'=>$galleries
        )
    );

});


/**
 * Display a particular photo gallery (by id).
 */
Route::get('gallery/{id}', 'GalleryController@display');


/**
 * Display the new user signup form
 * (not allowed if already signed in)
 */
Route::get('/signup',
    array(
        'before' => 'guest',
        function() {
            $galleries = Gallery::all();
            return View::make(
                'signup', 
                array(
                  'navInfo'=>Gallery::navInfo("signup"),
                  'galleries'=>$galleries
                )
            );
        }
    )
);

/**
 * Process the submission of a new user signup
 * (see the get route for '/signup' and the view 'signup')
 */
Route::post('/signup', 
    array(
        'before' => 'csrf', 
        function() {

            $user = new User();
            $user->email    = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            # Try to add the user 
            try {
                $user->save();
            }
            # Fail
            catch (Exception $e) {
                return Redirect::to('/signup')->with('flash_message', 'Sign up failed; please try again.')->withInput();
            }

            # Log the user in
            Auth::login($user);

            return Redirect::to('/')->with('flash_message', 'Welcome to Lily Sprite Images!');

        }
    )
);

/**
 * Display the user login form
 * (not allowed if already logged-in)
 */
Route::get('/login',
    array(
        'before' => 'guest',
        function() {
            $galleries = Gallery::all();
            return View::make(
                'login',
                array(
                  'navInfo'=>Gallery::navInfo("login"),
                  'galleries'=>$galleries
                )
            );
        }
    )
);

/**
 * Process the submission of login
 * (see the get route for '/login' and the view 'login')
 */

Route::post('/login', 
    array(
        'before' => 'csrf', 
        function() {

            $credentials = Input::only('email', 'password');

            if (Auth::attempt($credentials, $remember = true)) {
                return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
            }
            else {
                return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
            }

            return Redirect::to('login');
        }
    )
);

/**
 * Log current user out - no need for form UI, 
 * just an Auth call and redirect
 */
Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/')->with('flash_message', 'Logged-out!');

});


/**
 * To initiate an admin function (create/modify/delete photo),
 * bring up the admin gallery selection page.
 * This route uses the 'auth' filter to ensure a logged-in user, and
 * the custom 'adminUser' filter to ensure that user is an admin
 */
Route::get('/admin/galleryAction',
    array(
        'before' => 'auth|adminUser',
        function() {
            $galleries = Gallery::all();
            return View::make(
                'admin_gallery_select',
                array(
                  'navInfo'=>Gallery::navInfo("admin"),
                  'galleries'=>$galleries
                )
            );
        }
    )
);

/**
 * Process post data from submission of the main admin 'select gallery'
 * view. 
 */
Route::post(
    '/admin/galleryAction',
    array(
        'before' => 'csrf|auth|adminUser', 
        function() {
            $galleryId = Input::get("gallery");
            $action = Input::get("action");
            if ($action == "new") {
                return Redirect::to('/admin/newPhoto/' . $galleryId);
            } else if ($action == "modify") {
                return Redirect::to('/admin/modifyPhoto/' . $galleryId);
            } else if ($action == "delete") {
                return Redirect::to('/admin/deletePhoto/' . $galleryId);
            }
        }
    )
);

/**
 * Admin route to manipulate a photo in a specific gallery.
 */
Route::get('/admin/modifyPhoto/{galleryId}',
    array(
        'before' => 'auth|adminUser',
        function($galleryId) {
            try {
                $gallery = Gallery::findOrFail($galleryId);
                if ($gallery->photos->count() < 1) {
                    return Redirect::to('/admin/galleryAction')
                        ->with('flash_message', 'No photos to modify!');
                }
                return View::make(
                    'admin_modify_photo',
                    array(
                      'navInfo'=>Gallery::navInfo("admin"),
                      'galleries'=>Gallery::all(),
                      'galleryId'=>$galleryId
                    )
                );
            } catch (Exception $e) {
                return Redirect::to('/admin/galleryAction')
                    ->with('flash_message', 'Problem accessing gallery!');
            }

        }
    )
);

/**
 * Admin route to create a new photo in a specific gallery.
 */
Route::get('/admin/newPhoto/{galleryId}',
    array(
        'before' => 'auth|adminUser',
        function($galleryId) {
            return View::make(
                'admin_new_photo',
                array(
                  'navInfo'=>Gallery::navInfo("admin"),
                  'galleries'=>Gallery::all(),
                  'galleryId'=>$galleryId
                )
            );
        }
    )
);

Route::post(
    '/admin/newPhoto/{galleryId}',
    array(
        'before' => 'csrf|auth|adminUser',
        function($galleryId) {

            echo "GalleryId: " . $galleryId;

            /*
	     * Validate
	     */
	    $rules = array(
                'image' => 'image',
                'thumb' => 'image'
            );
 
            $inputs = array(
                'image' => Input::file('image'),
                'thumb' => Input::file('thumb')
            );

            $validation = Validator::make($inputs, $rules);
 
            if( $validation->passes() ) {
 
                try {

                    $gallery = Gallery::find($galleryId);

                    $photo = new Photo();
                    $photo->caption = Input::get('caption');
                    $photo->gallery_id = $galleryId;

                    /*
                     * Handle the main image file:
                     */
                    $filename = Input::file('image')->getClientOriginalName();

                    try {
                        /* Should throw exception */
                        Photo::where('file', '=', $filename)->firstOrFail();

                        /* Reaching this line means there's already a photo with that filename */
                        return Redirect::to('/admin/newPhoto/' . $galleryId)
                            ->with('flash_message', 'Publish failed: File "' . $filename . '" already exists.')
                            ->withInput();

                    } catch (Exception $e) {
                    }

                    Input::file('image')->move(base_path() . "/public/images", $filename);
                    $photo->file = $filename;

                    /*
                     * Handle the thumbnail:
                     */
                    $filename = Input::file('thumb')->getClientOriginalName();
                    try {
                        /* Should throw exception */
                        Photo::where('thumb', '=', $filename)->firstOrFail();

                        /* Reaching this line means there's already a photo with that filename */
                        return Redirect::to('/admin/newPhoto/' . $galleryId)
                            ->with('flash_message', 'Publish failed: File "' . $filename . '" already exists.')
                            ->withInput();

                    } catch (Exception $e) {
                    }
                    Input::file('thumb')->move(base_path() . "/public/images", $filename);
                    $photo->thumb = $filename;

                    $photo->save();

                    if ($gallery->restricted) {
                        $userList = Input::get('userList');
                        $photo->users()->attach($userList);
                    }

                } catch (Exception $e) {
                    return Redirect::to('/admin/newPhoto/' . $galleryId)
                        ->with('flash_message', 'Failed to publish photo: ' . $e->getMessage())
                        ->withInput();
                }

                return Redirect::to('/admin/newPhoto/' . $galleryId)
                        ->with('flash_message', 'Photo published!');

            } else {

                return Redirect::to('/admin/newPhoto/' . $galleryId)
                    ->with('flash_message', 'Invalid image/thumbnail')
                    ->withInput();
            }
        }
    )
);

Route::post(
    '/admin/modifyPhoto',
    array(
        'before' => 'csrf|auth|adminUser',
        function() {

                $photo = Photo::find(Input::get("photoId"));

                $photo->caption = Input::get('caption');

                $photo->save();

                if ($photo->gallery->restricted) {
                    $userList = Input::get('userList');
                    $photo->users()->attach($userList);
                }

                return Redirect::to('/');

        }
    )
);

/**
 * Admin route to select and delete a photo from a specific gallery.
 */
Route::get('/admin/deletePhoto/{galleryId}',
    array(
        'before' => 'auth|adminUser',
        function($galleryId) {
            try {
                $gallery = Gallery::findOrFail($galleryId);
                if ($gallery->photos->count() < 1) {
                    return Redirect::to('/admin/galleryAction')
                        ->with('flash_message', 'No photos to delete!');
                }
                return View::make(
                    'admin_delete_photo',
                    array(
                      'navInfo'=>Gallery::navInfo("admin"),
                      'galleries'=>Gallery::all(),
                      'galleryId'=>$galleryId
                    )
                );
            } catch (Exception $e) {
                return Redirect::to('/admin/galleryAction')
                    ->with('flash_message', 'Problem accessing gallery!');
            }
        }
    )
);

Route::post(
    '/admin/deletePhoto',
    array(
        'before' => 'csrf|auth|adminUser',
        function() {
            try {
                $photo = Photo::find(Input::get("photoId"));

                $galleryId = $photo->gallery_id;

                /* Delete the main photo image file: */
                $filename = $photo->file;
                try {

                    File::delete(public_path() . "/images/" . $filename);

                } catch (Exception $e) {
                    /* File delete failure is not catastrophic - keep deleting if possible */
                }

		/* Delete the thumbnail image file */
                $filename = $photo->thumb;
                try {

                    File::delete(public_path() . "/images/" . $filename);

                } catch (Exception $e) {
                    /* Thumbnail delete failure is not catastrophic - keep deleting if possible */
                }

                $photo->users()->detach();
		$photo->delete();

            } catch (Exception $e) {

                    return Redirect::to('/admin/deletePhoto/' . $galleryId)
                        ->with('flash_message', 'Failed to delete photo: ' . $e->getMessage())
                        ->withInput();
            }

            return Redirect::to('/admin/deletePhoto/' . $galleryId)
                ->with('flash_message', 'Photo deleted!');
        }
    )
);






/**
 * Administrative actions on photos in a gallery are handled implicitly
 * by the PhotoController
 */
Route::controller('photo', 'PhotoController');


/**
* Migrate old format CSV galleries into new DB style
* Note: This migrating of data is different from Laravel 'Migrations'.
* (Implicit Routing)
*/
Route::controller('migrate', 'MigrateController');


Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Paste\Pre::render($results);

});

Route::get('/crud-test', function() {

	$gallery = new Gallery();
	$gallery->name = "Foo Gallery";
	$gallery->save();

	$photo = new Photo();
        $photo->file = "images/pic1.jpg";
        $photo->thumb = "images/pic1_thumb.jpg";
        $photo->caption = "Photographer: Lily<br/>Model: Kathy Ireland";
        $photo->gallery_id = $gallery->id;
	$photo->save();

        $photo = Photo::first();
        $gallery = $photo->gallery;

	echo $photo->file."<br/>";
        echo $photo->thumb."<br/>";
	echo $photo->caption."<br/>";
        echo $gallery->name."<br/>";
        $photo->delete();
	$gallery->delete();
});