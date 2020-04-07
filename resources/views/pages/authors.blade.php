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

  <div class="row">
    @foreach(App\Author::orderby('name')->get() as $author)
    <div class="col-lg-3 col-md-4 col-6">

      <div class="card border-0">
        <img class="card-img-top" src="{{ asset('storage/'.$author->img) }}" alt="">
        <div class="card-body p-2">
          <a href="{{ url('/autorius/'.$author->id) }}" class="text-secondary stretched-link">
            <h4 class="card-title mb-0">
              {{ $author->name }}
            </h4>
          </a>
        </div>
      </div>

    </div>
    @endforeach
  </div>

</div>

@stop
