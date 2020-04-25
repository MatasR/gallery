(function(){

  $.fn.customIsotope = function(text){

    var grid = $(this);
    var cat = $(this).data('id');

    // Hide all except filter
    $('.submenu-block[data-dropdown='+cat+']').on('click', '[data-filter]', function(){
      var filter = $(this).data('filter');

      grid.find('.card.'+filter).show();
      grid.find('.card:not(.'+filter+')').hide();

      //make swipe-wrap element's height same as newCat category-swipe element's height
      $('.swipe-wrap').css('height', grid.height());
    });

    // Show all (filter *), should work only if .active
    $('.mainmenu').on('click', '.nav-item.active [data-swipe='+cat+']', function(){// dont want to work
      grid.find('.card').show();

      //make swipe-wrap element's height same as newCat category-swipe element's height
      $('.swipe-wrap').css('height', grid.height());
    });

  };

}());
