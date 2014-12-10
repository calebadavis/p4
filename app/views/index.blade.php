@extends("_master")

@section("content")
    <main>
      <!-- <h2>Galleries:</h2> -->
      <section id="galleries">

@foreach (Gallery::all() as $gallery)
@if(( !($gallery->restricted)) || (Auth::check()) )
<a href="/gallery/{{$gallery->id}}"><img src="images/{{$gallery->image}}" alt="{{$gallery->fullName}} example"/></a><br/>
@endif
@endforeach
      </section>
    </main>
@stop