@extends('layouts.default')
@section('content')

  <div class="container" id="author">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Galerija</a></li>
        <li class="breadcrumb-item"><a href="/{{ $author->categories->unique()->first()->slug }}">{{ $author->categories->unique()->first()->title }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $author->name }}</li>
      </ol>
    </nav>

    <!-- Author info -->
    <div class="row">

      @if($author->img)
      <div class="col-md-3 col-sm-6">
        <img class="img-fluid" src="{{ asset('storage/'.$author->img) }}" alt="">
      </div>
      @endif

      <div class="col-md-9 col-sm-6 text-secondary">
        <h4>{{ $author->name }}</h4>
        @if($author->description)
          <p>{{ $author->description }}</p>
        @endif
      </div>

    </div>

    <div class="row">
      <!-- Related works -->
      <!-- Navigation -->
      <ul class="nav mainmenu position-relative nav-x-scroll mx-3 d-block">
        @foreach($author->categories->unique() as $category)
          @if($category->childs->count())
            <li class="nav-item dropdown {{ ($category->slug == $initCategory->slug ? 'active' : '') }}">
              <a class="nav-link text-secondary dropdown-toggle" href="#" data-swipe="{{ $category->slug }}">
                {{ $category->title }}
              </a>
            </li>
          @else
            <li class="nav-item {{ ($category->slug == $initCategory->slug ? 'active' : '') }}">
              <a class="nav-link text-secondary" href="#" data-swipe="{{ $category->slug }}">{{ $category->title }}</a>
            </li>
          @endif
        @endforeach
      </ul>
    </div>



    <div class="row">
      <!-- Products -->

      @foreach($author->categories->unique() as $category)

        <!-- Product cards -->
        <div class="card-columns mx-3 mt-3">
          @foreach($author->products as $product)
            <a href="/{{ $initCategory->slug }}/{{ $product->slug }}">
              <div class="card" data-aos="fade-up" id="{{ $product->id }}">
                <img class="card-img" src="{{ Voyager::image($product->getThumbnail(json_decode($product->image)[0], 'thumb-300')) }}" title="{{ $product->views }}"/>
              </div>
            </a>
          @endforeach
        </div>

      @endforeach

    </div>

  </div>

  @push('scripts')
    <script type="text/javascript">

    </script>
  @endpush

@stop
