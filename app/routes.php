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


/*
 * Main index page
 */
Route::get('/', function() {
    return View::make(
        'index', 
        array(
            'navInfo'=>Gallery::navInfo("home"),
            'galleries'=>Gallery::all()
        )
    );
});

/*
 * 'About Lily' bio page
 */
Route::get('about', function() {
    return View::make(
        'about', 
        array(
            'navInfo'=>Gallery::navInfo("about"),
            'galleries'=>Gallery::all()
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


Route::get(
    '/admin/galleryAction', 
    array(
        'before' => 'auth|adminUser', 
        'uses' => 'AdminController@getGalleryAction'
    )
);

Route::post(
    '/admin/galleryAction', 
    array(
        'before' => 'auth|adminUser',
        'uses' => 'AdminController@postGalleryAction'
    )
);


/**
 * Admin route to manipulate a photo in a specific gallery.
 */
Route::get(
    '/admin/modifyPhoto/{galleryId}',
    array(
        'before' => 'auth|adminUser',
        'uses' => 'AdminController@getModifyPhoto'
    )
);

Route::post(
    '/admin/modifyPhoto',
    array(
        'before' => 'csrf|auth|adminUser',
        'uses' => 'AdminController@postModifyPhoto'
    )
);

/**
 * Admin route to create a new photo in a specific gallery.
 */
Route::get('/admin/newPhoto/{galleryId}',
    array(
        'before' => 'auth|adminUser',
        'uses' => 'AdminController@getNewPhoto'
    )
);

Route::post(
    '/admin/newPhoto/{galleryId}',
    array(
        'before' => 'csrf|auth|adminUser',
        'uses' => 'AdminController@postNewPhoto'
    )
);

/**
 * Admin route to select and delete a photo from a specific gallery.
 */
Route::get('/admin/deletePhoto/{galleryId}',
    array(
        'before' => 'auth|adminUser',
        'uses' => 'AdminController@getDeletePhoto'
    )
);

Route::post(
    '/admin/deletePhoto',
    array(
        'before' => 'csrf|auth|adminUser',
	'uses' => 'AdminController@postDeletePhoto'
    )
);


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