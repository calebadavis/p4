<?php

class MigrateController extends BaseController {

    /**
     * Constructor - ensure call to base class constructor
     */
    public function __construct() {

        parent::__construct();

    }

    /**
     * Helper function - converts a CSV-based gallery into new DB format
     */
    private function _migrateCSV($fname, $galName) {

    	$gal = new Gallery();
	$gal->name = $galName;
	$gal->save();

        $CSVPath = public_path()."/".$fname;
        echo $CSVPath . "<br/>";

        $file = fopen($CSVPath, 'r');
        while (($line = fgetcsv($file)) != FALSE) {
            list($f, $t) = $line;
            $photo = new Photo();
            $photo->gallery_id = $gal->id;
            $photo->file = $f;
            $photo->thumb = "Thumb" . $f;
            $photo->caption = $t;
            $photo->save();
        }
        fclose($file);

    }

    /**
     * Default 'get' method for migration
     * http://<base>/migrate/index
     *
     * There are four hardcoded galleries to migrate:
     * photo_list.csv, fantasy.csv, creative.csv, and portraits.csv
     */
    public function getIndex() {
        $oldGalleries = array(
            "Portraits" => "portraits.csv",
            "Creative" => "creative.csv",
            "Fantasy" => "fantasy.csv",
            "Modeling" => "photo_list.csv"
        );

	foreach ($oldGalleries as $galName => $fname) {
            echo "Migrating gallery " . $galName . " using file " . $fname . ":<br/>";
            $this->_migrateCSV($fname, $galName);
        }

        // Don't forget the restricted gallery!
        $restricted = new Gallery();
        $restricted->name = "Restricted";
        $restricted->restricted = TRUE;
        $restricted->save();

        // For testing purposes, add a couple users:

        $user = new User();
        $user->email = "kldx234@gmail.com";
        $user->password = Hash::make('dummy');
        $user->first_name = "Lily";
        $user->last_name = "Dolan";
        $user->admin = TRUE;
        $user->save();

        $user = new User();
        $user->email = "caleb.davis@gmail.com";
        $user->password = Hash::make('dummy');
        $user->first_name = "Caleb";
        $user->last_name = "Davis";
        $user->save();
    }

}