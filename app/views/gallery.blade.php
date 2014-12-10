@extends("_master")

@section("title")
    {{$gallery->name}}
@stop

@section("head")
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"> </script>
    <script type="text/javascript" src="/js/fancybox/jquery.fancybox.js"> </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("ul.gallery li a").fancybox({});
      });
    </script>

@stop

@section("content")
    <nav id="breadcrumb">
      <ul>
        <li>
          <a href="/">Home</a>
          <ul>
            <li><a href="#">{{$gallery->name}}</a></li>
          </ul>
        </li>
      </ul>
    </nav>

    <ul class="gallery">
      @foreach($gallery->photos as $photo)
      @if ($photo->permitted(Auth::user()))
      <li>
        <a href="/images/{{$photo->file}}" title="{{$photo->caption}}" data-fancybox-group="{{$gallery->name}}_slides">
          <img src="/images/{{$photo->thumb}}" alt="{{$photo->caption}}"/>
          <br/>{{$photo->caption}}
        </a>
      </li>
      @endif
      @endforeach
    </ul>
@stop