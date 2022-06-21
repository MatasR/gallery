@extends('layouts.default')
@section('content')

<div id="authors" class="container">

  <div class="row" id="search">
    <div class="container mb-2">
      <input class="form-control" type="text" placeholder="Paieška...">
    </div>
  </div>

  <div class="row" id="authors">
    @foreach($authors->sortBy('surname') as $author)
      @if($author->products->count())
      <div class="col-lg-4 col-md-6 col-12">

        <div class="card border-0" data-search="{{ $author->name }} {{ $author->surname }}">
          <div class="card-body p-2">
            <a href="{{ url('/autorius/'.$author->slug) }}" class="text-secondary stretched-link">
              <h4 class="card-title mb-0">
                <b>{{ strtoupper($author->surname) }}</b>
                <div class="text-capitalize">{{ mb_strtolower($author->name) }}</div>
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
