<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>@yield("title", "Lily Sprite Images")</title>
    <link rel="stylesheet" href="/css/art.css" type="text/css"/>
    @yield("head")
  </head>
  <body>
    <img id="top_image" src="/images/Title.png" alt="Lily Sprite Photography Main Image"/>
    @yield("content")
    <footer>
      <p>Copyright LilySprite 2015. All rights reserved. Unauthorized copying, distribution, or reproduction of any of these works is strictly prohibited.</p>
    </footer>
  </body>
</html>