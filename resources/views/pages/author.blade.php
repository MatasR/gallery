@extends('layouts.default')
@section('content')

  <div class="container" id="author">
    <!-- Author info -->
    <div class="row bg-warning">

      <div class="col-md-3 col-sm-6">
        <img class="img-fluid" src="{{ asset('storage/'.$author->img) }}" alt="">
      </div>

      <div class="col-md-9 col-sm-6">
        <h4>{{ $author->name }}</h4>
        <p>
          {{ $author->description }}
        </p>
      </div>

    </div>

    <div class="row bg-info">
      <!-- Related works -->
      <!-- Navigation -->
      <h4>Kategorijos</h4>
      <ul>
        @foreach($author->categories->unique() as $category)
          <li>{{ $category->title }}</li>
        @endforeach
      </ul>
      <!-- Cards columns -->
      <h4>Produktai</h4>
      <ul>
        @foreach($author->products as $product)
          <li>{{ $product->title }}</li>
        @endforeach
      </ul>
    </div>

  </div>

@stop
