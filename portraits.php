<!doctype html>
<html lang="en">
<?php include("includes/header.php"); ?>
  <body id="Portraits">
    <img id="top_image" src="images/Title.png" alt="Lily Sprite Photography Main Image"/>
<?php include("includes/site_nav.php"); ?>
<?php include("includes/breadcrumb_nav.php"); ?>
<?php
   $fancybox_group_name = "portrait_slides";
   $image_list_fname = "portraits.csv";
   include("includes/gallery.php");
?>
<?php include("includes/footer.php"); ?>
  </body>
</html>
