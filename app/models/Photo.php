<?php

class Photo extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
     * Photo belongs to Gallery
     * Define an inverse one-to-many relationship.
     */
    public function gallery() {

        return $this->belongsTo('Gallery');

    }

    public function users() {

        return $this->belongsToMany('User');

    }

}