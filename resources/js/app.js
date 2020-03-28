require('./bootstrap');

/*custom JS content

1. Swipe init and callback
2. Swipe link navigation
3. MagicLine init
4. Mainmenu links opens submenu
5. Submenu navigation
6. Submenu remove link .active on mainmenu link click if its has .dropdown and .active*/

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

// 6. Submenu remove link .active on mainmenu link click if it has .dropdown and .active
$('.mainmenu').on('click', '.nav-item.dropdown.active .nav-link', function(){
  var cat = $(this).data('swipe');
  $('.nav.submenu [data-dropdown='+cat+'] .nav-item.active').removeClass('active');
});
