@extends('layouts.default')
@section('content')

  <!-- Main category navigation -->
  <ul class="nav isotope-filters justify-content-center position-relative" id="magicLineNavbar">
    @foreach(App\Category::get()->where('parent_id', '') as $category)
      @if($category->childs->count())
        <li class="nav-item dropdown">
          <a class="nav-link text-secondary dropdown-toggle {{ ($category->slug == $initCategory->slug ? 'active' : '') }}" href="#" data-toggle="dropdown" data-swipe="{{ $category->slug }}">
            {{ $category->title }}
          </a>
          <div class="dropdown-menu">
            @foreach($category->childs as $child)
              <a class="dropdown-item" href="#" data-swipe="{{ $child->slug }}">{{ $child->title }}</a>
            @endforeach
          </div>
        </li>
      @else
        <li class="nav-item {{ ($category->slug == $initCategory->slug ? 'active' : '') }}">
          <a class="nav-link text-secondary" href="#" data-swipe="{{ $category->slug }}">{{ $category->title }}</a>
        </li>
      @endif
    @endforeach
  </ul>

  <!-- Products list -->

  <!-- SwipeJS plugin -->
  <div id="mySwipe" class="swipe mt-3">
    <div class="swipe-wrap">
      @foreach(App\Category::with('products', 'childs_products')->get()->where('parent_id', '') as $category)
      <div class="category-swipe" id="{{ $category->slug }}">

        <div class="card-columns px-1">
          @foreach($category->products->merge($category->childs_products) as $product)
            <div data-aos="fade-up" class="card text-white text-center {{ ($product->category->parent?$product->category->parent->slug:'') }} {{ $product->category->slug }}">
              <img class="card-img" src="{{ asset('storage/'.$product->image->src) }}"/>
              <div class="card-img-overlay">
                <h4 class="card-title font-weight-normal rounded-bottom position-absolute fixed-bottom mb-0 py-2">
                  {{ $product->title }}
                </h4>
              </div>
            </div>
          @endforeach
        </div>

      </div>
      @endforeach
    </div>
  </div>

  @push('scripts')
    <script type="text/javascript">
      window.mySwipe = new Swipe(document.getElementById('mySwipe'), {
        draggable: true,
        callback: function(index, elem, dir){
          var newCategory = $(elem).attr('id');
          console.log(newCategory);
          $('.nav .nav-item.active').removeClass('active');
          $('.nav .nav-item [data-swipe='+newCategory+']').closest('.nav-item').addClass('active');
          magicLine.refresh();
        }
      });

      // Navigation for swipejs
      $('.nav [data-swipe]').on('click', function(){
        // Get clicked cat slug
        newCat = $(this).data('swipe');
        // Count cat card index in swipe-wrap
        cardIndex = $('.swipe-wrap .category-swipe#'+newCat).index();
        // Slide swipejs
        window.mySwipe.slide(cardIndex, 400);
      });

      // Reik padaryt, kad pasileistu tik pilnai uzsikrovus + fade animation
      // nes dabar bugina ir netiksliai atsistoja
      var magicLine = new MagicLine();
    </script>
  @endpush

@stop
