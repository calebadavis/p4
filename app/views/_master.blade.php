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
    <hr id="begin-site-nav"/>
    <nav id="site-nav">
      <ul>
        <li 
          id="Home"
@if ($isHome)
          class="youarehere"
@endif
        >
          <a href="/">Home</a>
        </li>
@foreach ($galleries as $gal)
        <li 
          id="{{$gal->name}}" 
@if ($isGal)
@if ($gal->id == $gallery->id)
              class="youarehere"
@endif
@endif
        >
          <a href="/gallery/{{$gal->id}}">{{$gal->name}}</a>
        </li>
@endforeach
	<li 
          id="About"
@if ($isAbout)
            class="youarehere"
@endif
        >
          <a href="/about">About Me</a>
        </li>
      </ul>
    </nav>

    <hr id="end-site-nav"/>

    @yield("content")
    <footer>
      <p>Copyright LilySprite 2015. All rights reserved. Unauthorized copying, distribution, or reproduction of any of these works is strictly prohibited.</p>
    </footer>
  </body>
</html>
