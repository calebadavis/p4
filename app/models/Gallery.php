<?php

class Gallery extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
    * Gallery has many Photos
    */
    public function photos() {

        return $this->hasMany('Photo');

    }

    /*
     * Helper for _master.blade.php navigation bar 'you_are_here' class id
     */
    public static function navInfo($loc) {

        $ret = array();

        $ret["gal"] = ($loc == "gal");
        $ret["home"] = ($loc == "home");
        $ret["about"] = ($loc == "about");
        $ret["login"] = ($loc == "login");
        $ret["signup"] = ($loc == "signup");
        $ret["admin"] = ($loc == "admin");

        return $ret;

    }

}