@extends('layouts.default')
@section('content')

<div id="authors" class="container">

  <!--<div class="card-columns">
    @foreach(App\Author::get() as $author)
      <div class="card border-0">
        <img class="card-img-top" src="{{ asset('storage/'.$author->img) }}" alt="">
        <div class="card-body p-2">
          <h4 class="card-title mb-0">
            {{ $author->name }}
          </h4>
        </div>
      </div>
    @endforeach
  </div>-->

  <div class="row" id="search">
    <div class="container mb-2">
      <input class="form-control" type="text" placeholder="Paieška...">
    </div>
  </div>

  <div class="row" id="authors">
    @foreach(App\Author::with('products')->get()->sortBy('namedata-aos=fade-up ') as $author)

      @if($author->products->count())
      <div class="col-lg-4 col-md-6 col-12">

        <div class="card border-0" data-search="{{ $author->name }}">
          <img class="card-img-top" src="{{ asset('storage/'.$author->img) }}" alt="">
          <div class="card-body p-2">
            <a href="{{ url('/autorius/'.$author->id) }}" class="text-secondary stretched-link">
              <h4 class="card-title mb-0">
                {{ strtoupper($author->name) }}
              </h4>
            </a>
          </div>
        </div>

      </div>
      @endif
    @endforeach
  </div>

</div>

@push('scripts')
  <script type="text/javascript">
    // Author search
    $(window).on('load', function () {
      $('#search input').on('keyup', function(){

        var value = $(this).val().toLowerCase();
        $('#authors .card').filter(function(){
          $(this).toggle($(this).data('search').toLowerCase().indexOf(value) > -1)
        });

      });
    });
  </script>
@endpush

@stop
