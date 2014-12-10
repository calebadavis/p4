@extends("_master")

@section("content")
    <main>
      <!-- <h2>Galleries:</h2> -->
      <section id="galleries">
        <a href="/gallery/1"><img id="portraits_example" src="images/MainButtonsPortrait.png" alt="Portrait Photography example"/></a><br/>
        <a href="/gallery/2"><img id="creative_example" src="images/MainButtonsCreative.png" alt="Creative Photography example"/></a><br/>
        <a href="/gallery/3"><img id="fantasy_example" src="images/MainButtonsEdits.png" alt="Fantasy Photography example"/></a><br/>
        <a href="/gallery/4"><img id="model_example" src="images/MainButtonsModel.png" alt="In front of the camera example"/></a><br/>
@if (Auth::check())
        <a href="/gallery/5"><img id="restricted_example" src="images/MainButtonsRestricted.png" alt="Restricted Images"/></a><br/>
@endif
      </section>
    </main>
@stop