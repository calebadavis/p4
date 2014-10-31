<!doctype html>
<html lang="en">
  <head>
    <title>Lily Sprite Images</title>
    <meta charset="utf-8"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        var nav_loc = $('body').attr('id');
        $('nav #' + nav_loc).attr('class', 'youarehere');
      });
    </script>
    <link rel="stylesheet" href="css/art.css" type="text/css"/>
  </head>
  <body id="Home">
    <img id="top_image" src="images/Title.png" alt="Lily Sprite Photography Main Image"/>
<?php include("includes/site_nav.php");?>
    <main>
      <!-- <h2>Galleries:</h2> -->
      <section id="galleries">
        <a href="portraits.php"><img id="portraits_example" src="images/MainButtonsPortrait.png" alt="Portrait Photography example"/></a><br/>
        <a href="creative.php"><img id="creative_example" src="images/MainButtonsCreative.png" alt="Creative Photography example"/></a><br/>
        <a href="fantasy.php"><img id="fantasy_example" src="images/MainButtonsEdits.png" alt="Fantasy Photography example"/></a><br/>
        <a href="photo_gallery.php"><img id="model_example" src="images/MainButtonsModel.png" alt="In front of the camera example"/></a><br/>
      </section>
    </main>
<?php include("includes/footer.php"); ?>
  </body>
</html>
