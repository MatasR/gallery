@extends('layouts.default')
@section('content')

@php ( isset($initCategory) ? $cat = $initCategory : '' )

<div id="home" class="container p-0">

  <!-- Main category navigation -->
  <ul class="nav mainmenu position-relative justify-content-center mx-3">
    @foreach(App\Category::get()->where('parent_id', '') as $category)
      @if($category->childs->count())
      <li class="nav-item dropdown {{ ($category->slug == $cat->slug || $category->childs->where('slug', $cat->slug)->count() ? 'active' : '') }}">
          <a class="nav-link dropdown-toggle text-secondary"  data-toggle="dropdown" href="#">
            {{ $category->title }}
          </a>
          <div class="dropdown-menu">
            @foreach($category->childs as $child)
              <a class="dropdown-item {{ ($child->slug == $cat->slug ? 'active' : '') }}" href="/{{ $child->slug }}">
                {{ $child->title }}
              </a>
            @endforeach
          </div>
        </li>
      @else
        <li class="nav-item {{ ($category->slug == $cat->slug ? 'active' : '') }}">
          <a class="nav-link text-secondary" href="/{{ $category->slug }}">{{ $category->title }}</a>
        </li>
      @endif
    @endforeach
  </ul>

  <!-- Products list -->

  <div class="card-columns mx-3 mt-3">
    @foreach($products as $product)
      <a href="/{{ $cat->slug }}/{{ $product->slug }}">
        <div id="{{ $product->id }}" class="card text-dark text-center border-0">
          <img class="card-img" src="{{ Voyager::image($product->getThumbnail(json_decode($product->image)[0], 'thumb-300')) }}"/>
          <div class="card-body p-2">
            <h5 class="card-title mb-0">{{ $product->title }}</h5>
          </div>
        </div>
      </a>
    @endforeach
  </div>

  {{ $products->links() }}

</div>

  @push('scripts')
    <script type="text/javascript">



    </script>
  @endpush

@stop
