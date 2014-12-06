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

}