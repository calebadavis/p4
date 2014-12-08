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

Route::get('/', function()
{
	return View::make('hello');
});


Route::get('gallery/{id}', 'GalleryController@display');

Route::get('uploadFile', function(){
    return View::make('upload_file');
});


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