@extends('layouts.default')
@section('content')

  <div class="container" id="product">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Galerija</a></li>
        <li class="breadcrumb-item"><a href="/{{ $cat->slug }}">{{ $cat->title }}</a></li>
        @if($product->author)
          <li class="breadcrumb-item"><a href="/autorius/{{ $product->author->slug }}">{{ $product->author->name }} {{ $product->author->surname }}</a></li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
      </ol>
    </nav>

    <div class="row justify-content-center">
      <div class="col-auto">
        @if(json_decode($product->image))
          <img class="img-fluid mb-3" src="{{ Voyager::image(json_decode($product->image)[0]) }}" alt="">
        @else
          <img class="img-fluid mb-3" src="https://user-images.githubusercontent.com/101482/29592647-40da86ca-875a-11e7-8bc3-941700b0a323.png"/>
        @endif
      </div>
    </div>

    @if($product->author)
      <div class="row mb-3">
        <div class="col-12">
          <a href="/autorius/{{ $product->author->slug }}" class="text-secondary">{{ $product->author->name }} {{ $product->author->surname }}</a>
        </div>
      </div>
    @endif

    @if($product->short_desc)
      <p class="mb-3">
        {{ $product->short_desc }}
      </p>
    @endif

    @if (Auth::user() && ( Auth::user()->hasRole('admin') || Auth::user()->hasRole('user') ))
      <p class="mb-3">
        Peržiūrų: <b>{{ $product->views }}</b>
      </p>
    @endif

    <div class="row pb-3">

      <div class="col-12">

        <a href="/apie-mus" class="btn btn-info btn-lg rounded-pill mr-2" role="button" aria-pressed="true">Kreiptis</a>
        @if (Auth::user() && ( Auth::user()->hasRole('admin') || Auth::user()->hasRole('user') ))
          <a href="/admin/products/{{ $product->id }}" class="btn btn-secondary btn-lg rounded-pill" role="button" aria-pressed="true">Redaguoti</a>
        @endif

      </div>

    </div>

  </div>

  @push('scripts')
    <script type="text/javascript">
      // Init drift image zoom
      new Drift(document.querySelector("img"), {
        containInline: true,
        sourceAttribute: 'src',
        inlinePane: true,
        //zoomFactor: 3
      });
    </script>
  @endpush

@stop
