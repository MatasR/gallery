@extends('layouts.default')
@section('content')

<div class="container p-0">

  <!-- Main category navigation -->
  <ul class="nav mainmenu position-relative nav-x-scroll mx-3 d-block">
    @foreach(App\Category::get()->where('parent_id', '') as $category)
      @if($category->childs->count())
        <li class="nav-item dropdown {{ ($category->slug == $initCategory->slug ? 'active' : '') }}">
          <a class="nav-link text-secondary dropdown-toggle" href="#" data-swipe="{{ $category->slug }}">
            {{ $category->title }}
          </a>
          <!--
          <div class="dropdown-menu">
            @foreach($category->childs as $child)
              <a class="dropdown-item" href="#" data-swipe="{{ $child->slug }}">{{ $child->title }}</a>
            @endforeach
          </div>
          -->
        </li>
      @else
        <li class="nav-item {{ ($category->slug == $initCategory->slug ? 'active' : '') }}">
          <a class="nav-link text-secondary" href="#" data-swipe="{{ $category->slug }}">{{ $category->title }}</a>
        </li>
      @endif
    @endforeach
  </ul>
  <!-- Submenu navigation (required to be under separate div cause of nav-x-scroll) -->
  <ul class="nav submenu nav-x-scroll mx-3 d-block">
    @foreach(App\Category::get()->where('parent_id', '') as $category)
      @if($category->childs->count())
        <div class="submenu-block position-relative" data-dropdown="{{ $category->slug }}">
          @foreach($category->childs as $child)
            <li class="nav-item d-inline-block" data-filter="{{ $child->slug }}">
              <a class="nav-link text-secondary" href="#">
                {{ $child->title }}
              </a>
            </li>
          @endforeach
        </div>
      @endif
    @endforeach
  </ul>

  <!-- Products list -->
  <!-- SwipeJS plugin -->
  <div id="mySwipe" class="swipe mt-3">
    <div class="swipe-wrap">
      @foreach(App\Category::with('products', 'childs_products')->get()->where('parent_id', '') as $category)
      <div class="category-swipe" id="{{ $category->slug }}" {{ $category->childs->count() ? 'is-parent' : '' }}>

        <div class="card-columns mx-3">
          @foreach($category->products->merge($category->childs_products) as $product)
            <div {{ ($category->slug == $initCategory->slug ? 'data-aos=fade-up' : '') }} id="{{ $product->id }}" class="card text-white text-center border-0 {{ ($product->category->parent?$product->category->parent->slug:'') }} {{ $product->category->slug }}">
              <img class="card-img" src="{{ asset('storage/'.$product->image->src) }}"/>
              <!--<div class="card-img-overlay">
                <h4 class="card-title font-weight-normal position-absolute fixed-bottom mb-0 py-2">
                  {{ $product->title }}
                </h4>
              </div>-->
            </div>
          @endforeach
        </div>

      </div>
      @endforeach
    </div>
  </div>

</div>

@include('includes.popup')

  @push('scripts')
    <script type="text/javascript">
      // Init imagePopup modal plugin
      $('.card').on('click', function(){
        imagePopup($(this));
      });
    </script>
  @endpush

@stop
