@extends('layouts.default')
@section('content')

<div id="home" class="container p-0">

  <!-- Main category navigation -->
  <ul class="nav mainmenu position-relative nav-x-scroll mx-3 d-block">
    @foreach(App\Category::get()->where('parent_id', '') as $category)
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




















      // I am gonna just put this code right here
      // because i dont wanna run in on about us page

      /*custom JS content

      1. Swipe init and callback
      2. Swipe link navigation
      3. MagicLine init
      4. Mainmenu links opens submenu
      5. Submenu navigation
      6. Init custom isotope grid
      7. Submenu remove link .active on mainmenu link click if its has .dropdown and .active*/

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

      // 2. Swipe link navigation
      // Navigation for swipejs
      $('.nav [data-swipe]').on('click', function(){
        // Get clicked cat slug
        newCat = $(this).data('swipe');
        // Count cat card index in swipe-wrap
        cardIndex = $('.swipe-wrap .category-swipe#'+newCat).index();
        // Slide swipejs
        window.mySwipe.slide(cardIndex, 400);
      });

      // 3. MagicLine init
      // Init magicLine when page fully loaded to get exact position to appear
      $(window).on('load', function () {
        mainMagicLine = new MagicLine($('.mainmenu'));
      });

      // 4. Mainmenu links opens submenu
      //Submenu show
      $('.mainmenu .dropdown-toggle').on('click', function(){
        cat = $(this).data('swipe');
        $('.submenu-block:not([data-dropdown='+cat+'])').slideUp();
        $('.submenu-block[data-dropdown='+cat+']').slideDown();
      });
      //Submenu close
      $('.mainmenu .nav-link:not(.dropdown-toggle)').on('click', function(){
        $('.submenu-block').slideUp();
      });

      // 5. Submenu navigation
      // Submenu Scroll nav-x-scroll navigation to newSubCat
      $('.nav.submenu .nav-link').click( function(){

        var newLi = $(this).parent();

        // Target is the Middle
        targetOffset = $('.nav.submenu.nav-x-scroll').width() / 2 - newLi.width() / 2;

        // Current li possition
        currentOffset = newLi.offset().left;

        // Calc the diff in offsets
        difference = currentOffset - targetOffset;

        // Currently scrolled
        currentScroll = $('.nav.submenu.nav-x-scroll').scrollLeft();

        // Add target scroll to currentScroll
        scroll = difference + currentScroll;

        // Substract padding left
        scroll -= 16;

        // Excecute the scrolling
        $('.nav.submenu.nav-x-scroll').animate({
          scrollLeft: scroll + 'px'
        }, 300);

        // Assign active class to newly selected sub menu item
        $('.nav.submenu .nav-item.active').removeClass('active');
        newLi.addClass('active');
      });

      // 6. Init custom isotope grid
      // only for those who have submenu (is parent)
      $('.category-swipe[is-parent]').each(function(index, element){
        $(element).customIsotope();
      });

      // 7. Submenu remove link .active on mainmenu link click if it has .dropdown and .active
      $('.mainmenu').on('click', '.nav-item.dropdown.active .nav-link', function(){
        var cat = $(this).data('swipe');
        $('.nav.submenu [data-dropdown='+cat+'] .nav-item.active').removeClass('active');
      });
    </script>
  @endpush

@stop
