  <head>
    <meta charset="utf-8"/>
    <title id="tit">dummy title</title>
    <link rel="stylesheet" href="css/art.css" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"> </script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox.js"> </script>
    <script type="text/javascript">
      $(document).ready(function() {
        var head_title = $('body').attr('id');
        $('#tit').text(head_title);
        $("nav ul li ul li a").text(head_title);
        $('nav #' + head_title).attr('class', 'youarehere');
        $("ul.gallery li a").fancybox({});
      });
    </script>
  </head>
