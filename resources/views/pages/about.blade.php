@extends('layouts.default')
@section('content')

<div class="" id="about-us">

  <img class="img-fluid" src="{{ asset('img/about.jpg')}}"/>

  <div class="container">

    <div class="row">

      <!-- ABOUT -->
      <div class="col-sm-6">

        <h2 class="display-4 text-sm-center my-3 my-sm-5 text-secondary">Apie mus</h2>

        <p class="p-sm-2 p-lg-4 px-2 px-sm-3 mb-0" id="about-us-desc">
          VILNIUS. ŽVĖRYNAS. „MAŽOJI GALERIJA“. Jau 20 metų gyvuojančioje meno galerijoje, lankytojas suras rūpestingai parinktas profesionalių dailininkų tapybos, grafikos, keramikos, skulptūros ir autorinės juvelyrikos kolekcijas. Padedame renkantis meno kūrinius interjerams, atliekame užsakymus. VISKAS ĮMANOMA – REIKIA TIK NORĖTI…
        </p>

      </div>

      <!-- CONTACTS -->
      <div class="col-sm-6">

        <h2 class="display-4 text-sm-center my-3 my-sm-5 text-secondary">Kontaktai</h2>

        <div class="container">

          <table class="table mb-0">
            <tbody>
              <tr>
                <td class="text-right border-0">El. paštas:</td>
                <td class="border-0"><a href="mailto:info@smallgallery.net">info@smallgallery.net</a></td>
              </tr>
              <tr>
                <td class="text-right">Adresas:</td>
                <td><a href="https://www.google.lt/maps/place/Latvi%C5%B3+g.+19a,+Vilnius" target="_blank">Latvių g. 19A-1, Vilnius</a></td>
              </tr>
              <tr>
                <td class="text-right">Volanda:</td>
                <td><a href="tel:+370 682 62796">+370 682 62796</a></td>
              </tr>
              <tr>
                <td class="text-right">Ignė:</td>
                <td><a href="tel:+370 698 41160">+370 698 41160</a></td>
              </tr>
            </tbody>
          </table>

        </div>

      </div>

    </div>

    <blockquote class="blockquote text-center mt-3 mb-4">

      <p class="mb-1">
        Lauksime jūsų apsilankant!
      </p>
      <footer class="blockquote-footer">I-V 10-18 val.<br>VI 11-16 val.</footer>

    </blockquote>

    <div id="map" class="map-container mb-3"></div>

  </div>

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
