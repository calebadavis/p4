<?php

class GalleryController extends BaseController {

    /**
     * Constructor - ensure call to base class constructor
     */
    public function __construct() {

        parent::__construct();

    }

    public function display($galleryId) {

        $galleries = Gallery::all();
        $gallery = null;
        foreach($galleries as $gal) {
            if ($gal->id == $galleryId) {
                $gallery=$gal;
                break;
            }
        }

        return View::make(
            'gallery', 
             array(
                 'isGal'   =>TRUE,
                 'isHome'  =>FALSE,
                 'isAbout' =>FALSE,
                 'isLogin' =>FALSE,
                 'isSignup'=>FALSE,
                 'isAdmin' =>FALSE,
                 'gallery'=>$gallery,
                 'galleries'=>$galleries
             )
        );
    }
}