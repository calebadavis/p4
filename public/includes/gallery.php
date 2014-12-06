    <ul class="gallery">
<?php
       // This assumes global variables 'fancybox_group_name' and 'image_list_fname'
       function slide_item($fname, $title, $thumb_fname, $fb_group) {
          echo "      <li>\n        <a href=\"$fname\" title=\"$title\" data-fancybox-group=\"$fb_group\">\n          <img src=\"$thumb_fname\" alt=\"$title\"/>\n          <br/>$title\n        </a>\n      </li>\n";
        }
        $img_prefix = "images/";
        $file = fopen($image_list_fname, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
          //list($images[], $titles[]) = $line;
          list($f, $t) = $line;
          slide_item($img_prefix . $f, $t, $img_prefix . "Thumb" . $f, $fancybox_group_name);
        }
        fclose($file);
?>
    </ul>
