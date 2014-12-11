<?php

class AdminController extends BaseController {

    /**
     * Constructor - ensure call to base class constructor
     */
    public function __construct() {

        parent::__construct();

    }

    /**
     * To initiate an admin function (create/modify/delete photo),
     * bring up the admin gallery selection page.
     * This route uses the 'auth' filter to ensure a logged-in user, and
     * the custom 'adminUser' filter to ensure that user is an admin
     */
    public function getGalleryAction() {

        $galleries = Gallery::all();
        return View::make(
            'admin_gallery_select', 
             array(
                 'navInfo'=>Gallery::navInfo("admin"),
                 'galleries'=>$galleries
             )
        );
    }

    /**
     * Process post data from submission of the main admin 'select gallery'
     * view. 
     */
    public function postGalleryAction() {
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

    public function getModifyPhoto($galleryId) {

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

    public function postModifyPhoto() {

        try {

    	   $photo = Photo::find(Input::get("photoId"));
           $photo->caption = Input::get('caption');
           $photo->save();

           if ($photo->gallery->restricted) {
               $photo->users()->detach();
               $userList = Input::get('userList');
               $photo->users()->attach($userList);
           }

           return Redirect::to('/admin/modifyPhoto/' . $photo->gallery_id)
               ->with('flash_message', 'Successfully modified photo');

        } catch (Exception $e) {

            return Redirect::to('/admin/galleryAction')
                ->with('flash_message', 'An error occurred setting new photo attributes.');

        }
    }

    public function getNewPhoto($galleryId) {
        return View::make(
            'admin_new_photo',
            array(
                'navInfo'=>Gallery::navInfo("admin"),
                'galleries'=>Gallery::all(),
                'galleryId'=>$galleryId
            )
        );
    }

    public function postNewPhoto($galleryId) {

        $imageFile = Input::file('file');
        $thumbFile = Input::file('thumb');
        $imageFname = $imageFile->getClientOriginalName();
        $thumbFname = $thumbFile->getClientOriginalName();

        /* Validation: */
	$rules = array(
            'file' => 'image|required|unique:photos',
            'thumb' => 'image|required|unique:photos',
            'filename' => 'unique:photos,file',
            'thumbname' => 'unique:photos,thumb'
        );
 
        $inputs = array(
            'file' => $imageFile,
            'thumb' => $thumbFile,
            'filename' => $imageFname,
            'thumbname' => $thumbFname
        );

        $validation = Validator::make($inputs, $rules);
 
        if( $validation->fails() ) {
            return Redirect::to('/admin/newPhoto/' . $galleryId)
                ->with('flash_message', 'Invalid image/thumbnail')
                ->withInput()
                ->withErrors($validation);
        }

        try {

            $gallery = Gallery::find($galleryId);

            $photo = new Photo();
            $photo->caption = Input::get('caption');
            $photo->gallery_id = $galleryId;

            /* Handle the main image file: */
            Input::file('file')->move(base_path() . "/public/images", $imageFname);
            $photo->file = $imageFname;

            /* Handle the thumbnail: */
            Input::file('thumb')->move(base_path() . "/public/images", $thumbFname);
            $photo->thumb = $thumbFname;

            $photo->save();

            if ($gallery->restricted) {
                $userList = Input::get('userList');
                $photo->users()->attach($userList);
            }

            return Redirect::to('/admin/newPhoto/' . $galleryId)
                ->with('flash_message', 'Photo published!');

        } catch (Exception $e) {
            return Redirect::to('/admin/newPhoto/' . $galleryId)
                ->with('flash_message', 'Failed to publish photo: ' . $e->getMessage())
                ->withInput();
        }

    }

    public function getDeletePhoto($galleryId) {

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

    public function postDeletePhoto() {
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

}