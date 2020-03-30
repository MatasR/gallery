(function(){

  $.fn.customIsotope = function(text){

    var grid = $(this);
    var cat = $(this).attr('id');

    // Hide all except filter
    $('.submenu').on('click', '[data-filter]', function(){
      var filter = $(this).data('filter');

      grid.find('.card.'+filter).show();
      grid.find('.card:not(.'+filter+')').hide();
    });

    // Show all (filter *), should work only if .active
    $('.mainmenu').on('click', '.nav-item.active [data-swipe='+cat+']', function(){// dont want to work
      grid.find('.card').show();
    });

  };

}());
