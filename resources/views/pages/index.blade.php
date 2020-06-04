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
  <!-- Submenu navigation (required to be under separate div cause of nav-x-scroll) -->
  <!--<ul class="nav submenu nav-x-scroll mx-3 d-block">
    @foreach(App\Category::get()->where('parent_id', '') as $category)
      @if($category->childs->count())
        <div class="submenu-block position-relative" data-dropdown="{{ $category->slug }}">
          @foreach($category->childs as $child)
            <li class="nav-item d-inline-block" data-filter="{{ $child->slug }}">
              <a class="nav-link text-secondary" href="#{{ $category->slug }}-{{ $child->slug }}">
                {{ $child->title }}
              </a>
            </li>
          @endforeach
        </div>
      @endif
    @endforeach
  </ul>-->

  <!-- Products list -->

  <div class="card-columns mx-3 mt-3">
    {{-- @foreach($initCategory->products->merge($initCategory->childs_products) as $product) --}}
    {{-- https://stackoverflow.com/questions/30420505/how-can-i-paginate-a-merged-collection-in-laravel-5 --}}
    @foreach($products as $product)
      <a href="/{{ $cat->slug }}/{{ $product->slug }}">
        <div id="{{ $product->id }}" class="card text-white text-center border-0">
          <img class="card-img" src="{{ Voyager::image($product->getThumbnail(json_decode($product->image)[0], 'thumb-300')) }}"/>
        </div>
      </a>
    @endforeach
  </div>

  {{ $products->links() }}
  <!--<button data-page="1" class="load-more btn btn-outline-secondary col-12">Load more</button>-->

</div>

@include('includes.popup')

  @push('scripts')
    <script type="text/javascript">
      // I am gonna just put this code right here
      // because i dont wanna run it on about us page

      // 8. Init imagePopup modal plugin
      $('.card').on('click', function(){
        imagePopup($(this));
      });

    </script>
  @endpush

@stop
