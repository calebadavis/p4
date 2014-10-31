<!doctype html>
<html lang="en">
<?php include("includes/header.php"); ?>
  <body id="Modeling">
    <img id="top_image" src="images/Title.png" alt="Lily Sprite Photography Main Image"/>
<?php include("includes/site_nav.php"); ?>
<?php include("includes/breadcrumb_nav.php"); ?>
<?php
   $fancybox_group_name = "photo_slides";
   $image_list_fname = "photo_list.csv";
   include("includes/gallery.php");
?>
<?php include("includes/comments.php"); ?>
<?php include("includes/footer.php"); ?>
  </body>
</html>
