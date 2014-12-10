<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>@yield("title", "Lily Sprite Images")</title>
    <link rel="stylesheet" href="/css/art.css" type="text/css"/>
    @yield("head")
  </head>
  <body>
@if(Session::get('flash_message'))
    <div class='flash-message'>{{ Session::get('flash_message') }}</div>
@endif
    <img id="top_image" src="/images/Title.png" alt="Lily Sprite Photography Main Image"/>
    <hr id="begin-site-nav"/>
    <nav id="site-nav">
      <ul>
        <li 
          id="Home"
@if ($navInfo["home"])
          class="youarehere"
@endif
        >
          <a href="/">Home</a>
        </li>
@foreach ($galleries as $gal)
@if ( !($gal->restricted) || (Auth::check())) 
        <li 
          id="{{$gal->name}}" 
@if ($navInfo["gal"])
@if ($gal->id == $gallery->id)
              class="youarehere"
@endif
@endif
        >
          <a href="/gallery/{{$gal->id}}">{{$gal->name}}</a>
        </li>
@endif
@endforeach
	<li 
          id="About"
@if ($navInfo["about"])
            class="youarehere"
@endif
        >
          <a href="/about">About Lily</a>
        </li>
        <li
@if(Auth::check())
          id="Logout"
        >
          <a href='/logout'>Log out {{ Auth::user()->email; }}</a>
        </li>
@else
          id="Signup"
@if ($navInfo["signup"])
          class="youarehere"
@endif
        > 
          <a href='/signup'>Sign up</a>
        </li>
        <li 
          id="Log In"
@if ($navInfo["login"])
          class="youarehere"
@endif
        >
          <a href='/login'>Log in</a>
        </li>
@endif
@if (Auth::check() && Auth::user()->admin)
	<li 
          id="Admin"
@if ($navInfo["admin"])
            class="youarehere"
@endif
        >
          <a href="/admin/galleryAction">Admin</a>
        </li>
@endif
      </ul>
    </nav>

    <hr id="end-site-nav"/>

    @yield("content")
    <footer>
      <p>Copyright LilySprite 2015. All rights reserved. Unauthorized copying, distribution, or reproduction of any of these works is strictly prohibited.</p>
    </footer>
  </body>
</html>
