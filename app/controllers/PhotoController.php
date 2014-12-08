<?php

class PhotoController extends BaseController {

    /**
     * Constructor - ensure call to base class constructor
     */
    public function __construct() {

        parent::__construct();

    }


    public function getNew() {

        $galleries = Gallery::all();
        $users = User::all();

        return View::make(
            'new_photo', 
             array(
               'galleries'=>$galleries,
               'users'=>$users
             )
        );

    }

    /**
     * Upload new Photo/Thumbnail to a gallery
     */
    public function postNew() {

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
 
            $gallery = Gallery::find(Input::get("gallery"));

            echo $gallery->name . "<br/>";

            $photo = new Photo();
            $photo->caption = Input::get('caption');

            //set the name of the file
            $filename = Input::file('image')->getClientOriginalName();
            echo $filename . "<br/>";

            //Upload the file
            Input::file('image')->move(base_path() . "/public/images", $filename);
            $photo->file = $filename;

            $filename = Input::file('thumb')->getClientOriginalName();

            echo $filename . "<br/>";
            Input::file('thumb')->move(base_path() . "/public/images", $filename);
            $photo->thumb = $filename;
            $photo->gallery_id = $gallery->id;

            $photo->save();

	    if ($gallery->restricted) {

                $userList = Input::get('userList');
                foreach ($userList as $userId) {
                    $user = User::find($userId);
                    $photo->users()->save($user);
                }        

            }

        } else {
            return Redirect::to('photo/new')
                ->withErrors($validation)
                ->withInput();
        }

    }


}