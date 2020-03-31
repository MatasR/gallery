@extends('layouts.default')
@section('content')

  <img class="img-fluid" src="{{ asset('img/about.jpg')}}"/>

  <div class="container bg-primary">

    <div class="row">

      <div class="col-6">

        <h2 class="display-4 bg-success text-center my-5 text-secondary">Apie mus</h2>

        <p class="p-3 mb-0">
          VILNIUS. ŽVĖRYNAS. „MAŽOJI GALERIJA“. Jau 20 metų gyvuojančioje meno galerijoje, lankytojas suras rūpestingai parinktas profesionalių dailininkų tapybos, grafikos, keramikos, skulptūros ir autorinės juvelyrikos kolekcijas. Padedame renkantis meno kūrinius interjerams, atliekame užsakymus. VISKAS ĮMANOMA – REIKIA TIK NORĖTI…
        </p>

      </div>

      <div class="col-6">

        <h2 class="display-4 text-center my-5 text-secondary">Kontaktai</h2>

        <div class="row">

          <div class="col text-right">

            <ul class="list-group list-group-flush">
              <li class="list-group-item">El. paštas:</li>
              <li class="list-group-item">Adresas:</li>
              <li class="list-group-item">Volanda:</li>
              <li class="list-group-item">Ignė:</li>
            </ul>

          </div>

          <div class="col">

            <ul class="list-group list-group-flush">
              <li class="list-group-item">info@smallgallery.net</li>
              <li class="list-group-item">Latvių g. 19A-1, Vilnius</li>
              <li class="list-group-item">+370 682 62796</li>
              <li class="list-group-item">+370 698 41160</li>
            </ul>

          </div>

        </div>

      </div>

    </div>

    <p class="lead text-center my-4">
      Lauksime jūsų apsilankant!
    </p>

    <div id="map" class="map-container mb-3"></div>

  </div>

  @push('scripts')
    <script type="text/javascript">
    // Init google map
      function initMap(){
        // The location of Uluru
        var uluru = {lat: 54.695039, lng: 25.250156};
        // The map, centered at Uluru
        var map = new google.maps.Map(document.getElementById('map'), {zoom: 16, center: uluru});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
      }
    </script>
  @endpush

@stop
