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
        'uses' => 'UserController@getSignup'
    )
);

/**
 * Process the submission of a new user signup
 * (see the get route for '/signup' and the view 'signup')
 */
Route::post(
    '/signup', 
    array(
        'before' => 'csrf', 
        'uses' => 'UserController@postSignup'
    )
);

/**
 * Display the user login form
 * (not allowed if already logged-in)
 */
Route::get(
    '/login',
    array(
        'before' => 'guest',
        'uses' => 'UserController@getLogin'
    )
);

/**
 * Process the submission of login
 * (see the get route for '/login' and the view 'login')
 */

Route::post('/login', 
    array(
        'before' => 'csrf', 
        'uses' => 'UserController@postLogin'
    )
);

/**
 * Log current user out - no need for form UI, 
 * just an Auth call and redirect
 */
Route::get('/logout', 'UserController@getLogout');

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

