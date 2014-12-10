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

    /**
     * Determine if the user is allowed to view the photo
     */
    public function permitted($user) {
        $ret = TRUE;
        if ($this->gallery->restricted) {
            $ret = FALSE;
            foreach($this->users as $candidate) {
                if ($candidate->id == $user->id) {
                    $ret = TRUE;
                    break;
                }
            }
        }
        return $ret;
    }

}