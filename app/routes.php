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
    return View::make('index', array(
        'navInfo'=>Gallery::navInfo("home"), 
        'galleries'=>Gallery::all()
    ));
});

/*
 * 'About Lily' bio page
 */
Route::get('about', function() {
    return View::make('about', array(
       'navInfo'=>Gallery::navInfo("about"), 
       'galleries'=>Gallery::all()));
});

/**
 * Display a particular photo gallery (by id).
 */
Route::get('gallery/{id}', 'GalleryController@display');

/**
 * Sign up a new user
 * (not allowed if already signed in)
 */
Route::get ('/signup', 'UserController@getSignup');
Route::post('/signup', 'UserController@postSignup');

/**
 * Display the user login form
 * (not allowed if already logged-in)
 */
Route::get( '/login', 'UserController@getLogin');
Route::post('/login', 'UserController@postLogin');

/**
 * Log current user out - no need for form UI, 
 * just an Auth call and redirect
 */
Route::get('/logout', 'UserController@getLogout');

/**
 * RESTful resource controller for password resets.
 * The entry point to this functionality is in the 'UserController' 
 * 'getLogin' and 'postLogin' (a 'reset' checkbox triggers the reset 
 * e-mail to the user). Once the user clicks on the e-mail link, 
 * this 'RemindersController' handles the rest of the password reset.
 */
Route::controller('password', 'RemindersController');


/**
 * The launching point for all administrative tasks - gallery selection
 */
Route::get( '/admin/galleryAction', 'AdminController@getGalleryAction');
Route::post('/admin/galleryAction', 'AdminController@postGalleryAction');

/**
 * Admin route to modify a photo in a specific gallery.
 */
Route::get( '/admin/modifyPhoto/{galleryId}', 'AdminController@getModifyPhoto');
Route::post('/admin/modifyPhoto',             'AdminController@postModifyPhoto');

/**
 * Admin route to create a new photo in a specific gallery.
 */
Route::get( '/admin/newPhoto/{galleryId}', 'AdminController@getNewPhoto');
Route::post('/admin/newPhoto/{galleryId}', 'AdminController@postNewPhoto');

/**
 * Admin route to select and delete a photo from a specific gallery.
 */
Route::get( '/admin/deletePhoto/{galleryId}', 'AdminController@getDeletePhoto');
Route::post('/admin/deletePhoto',             'AdminController@postDeletePhoto');

/**
* Migrate old format CSV galleries into new DB style
* Note: This migrating of data is different from Laravel 'Migrations'.
* (Implicit Routing). This route will be commented out in production.
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

