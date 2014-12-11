<?php

class MigrateController extends BaseController {

    /**
     * Constructor - ensure call to base class constructor
     */
    public function __construct() {

        parent::__construct();

    }

    /**
     * Special method that gets triggered if the user enters a URL for a method that does not exist
     *
     * @return String
     */
    public function missingMethod($parameters = array()) {

        return 'Method "'.$parameters[0].'" not found';

    }

    /**
     * Helper function - converts a CSV-based gallery into new DB format
     */
    private function _migrateCSV($fname, $galName, $fullName, $imageFile) {

    	$gal = new Gallery();
	$gal->name = $galName;
        $gal->fullName = $fullName;
        $gal->image = $imageFile;
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
            "Portraits" => array("portraits.csv", "Portraits", "MainButtonsPortrait.png"),
            "Creative" => array("creative.csv", "Creative Photography", "MainButtonsCreative.png"),
            "Fantasy" => array("fantasy.csv", "Fantasy Edits", "MainButtonsEdits.png"),
            "Modeling" => array("photo_list.csv", "Modeling", "MainButtonsModel.png")
        );

	foreach ($oldGalleries as $galName => $attribs) {
            echo "Migrating gallery " . $galName . " using file " . $attribs[0] . ":<br/>";
            $this->_migrateCSV($attribs[0], $galName, $attribs[1], $attribs[2]);
        }

        // Don't forget the restricted gallery!
        $restricted = new Gallery();
        $restricted->name = "Restricted";
        $restricted->fullName = "Restricted Images";
        $restricted->image = "MainButtonsRestricted.png";
        $restricted->restricted = TRUE;
        $restricted->save();

        // For testing purposes, add a couple users:

        $user = new User();
        $user->email = "kldx234@gmail.com";
        $user->password = Hash::make('dummy1');
        $user->first_name = "Lily";
        $user->last_name = "Dolan";
        $user->admin = TRUE;
        $user->save();

        $user = new User();
        $user->email = "caleb.davis@gmail.com";
        $user->password = Hash::make('dummy2');
        $user->first_name = "Caleb";
        $user->last_name = "Davis";
        $user->save();
    }

}