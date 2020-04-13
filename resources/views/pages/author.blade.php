@extends('layouts.default')
@section('content')

  <div class="container" id="author">
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

      <!-- Swipe stuff -->
      <div id="mySwipe" class="swipe mt-3">
        <div class="swipe-wrap">
          @foreach($author->categories->unique() as $category)
          <div class="category-swipe" id="{{ $category->slug }}">

            <!-- Product cards -->
            <div class="card-columns mx-3">
              @foreach($author->products as $product)
                <div class="card" data-aos="fade-up" id="{{ $product->id }}">
                  <img class="card-img" src="{{ asset('storage/images/thumbs'.substr(json_decode($product->images)[0], 7)) }}"/>
                </div>
              @endforeach
            </div>

          </div>
          @endforeach
        </div>
      </div>

    </div>

  </div>

  @include('includes.popup')

  @push('scripts')
    <script type="text/javascript">
      // 1. Swipe init and callback
      window.mySwipe = new Swipe(document.getElementById('mySwipe'), {
        draggable: true,
        callback: function(index, elem, dir){
          var newCat = $(elem).attr('id');

          // Scroll nav-x-scroll navigation to newCat
          curLi = $(elem).parent();
          newLi = $('.nav-x-scroll').find('[data-swipe='+newCat+']').parent();

          newX = newLi.offset().left - curLi.offset().left;

          curScrollX = $('.nav-x-scroll').scrollLeft();
          newScrollX = newX + curScrollX;

          // Remove half nav width
          newScrollX -= $('.nav-x-scroll').width() / 2;

          // Add half li width
          newScrollX += newLi.width() / 2;

          // Substract padding left
          newScrollX -= 16;

          // Excecute the scrolling
          $('.nav-x-scroll').animate({
            scrollLeft: newScrollX + 'px'
          }, 300);

          // Slide magicLine to new position
          $('.nav.mainmenu .nav-item.active').removeClass('active');
          // Assign active class to new cat for magicLine
          $('.nav .nav-item [data-swipe='+newCat+']').closest('.nav-item').addClass('active');
          // Slide magicLine to the new swiped cat
          mainMagicLine.refresh();

          // Close all opened submenus(except current)
          $('.submenu-block:not([data-dropdown='+newCat+'])').slideUp();
          // Open sub menu if newly swiped cat has one
          $('.submenu .submenu-block[data-dropdown='+newCat+']').slideDown();
        }
      });
      // 3. MagicLine init
      // Init magicLine when page fully loaded to get exact position to appear
      $(window).on('load', function () {
        mainMagicLine = new MagicLine($('.mainmenu'));
      });
      // 8. Init imagePopup modal plugin
      $('.card').on('click', function(){
        imagePopup($(this));
      });
    </script>
  @endpush

@stop
