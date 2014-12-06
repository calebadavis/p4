<!doctype html>
<html lang="en">
<?php include("includes/header.php"); ?>
  <body id="Artwork">
    <h1>Paintings and Drawings</h1>
<?php include("includes/site_nav.php");?>
<?php include("includes/breadcrumb_nav.php"); ?>
<?php
   $fancybox_group_name = "art_slides";
   $image_list_fname = "art_list.csv";
   include("includes/gallery.php");
?>
<?php include("includes/comments.php"); ?>
<?php include("includes/footer.php"); ?>
  </body>
</html>
