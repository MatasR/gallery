(function() {

  var nav, theLine;

  // Define our constructor
  MagicLine = function(elem) {

    // Define as global var for animateMenu menu access later
    nav = elem;

    var active = nav.find('.active').length ? nav.find('.active') : nav.find('.nav-item').first();

    // Create the magic line (global var for latter animateMenu access)
    theLine = $('<div ddata-aos="flip-left" data-aos-duration="1000"></div>').attr('class', 'magic-line');
    theLine.css('left', active.position().left).css('width', active.css('width'));

    // Append the magic line to main navigation
    nav.append(theLine);

    // EVENTS
    // Mouseenter/Mouseleave -> move magicLine
    $(nav).on('mouseenter', 'li', function(e) {
        e.preventDefault();
        animateMenu($(this));
    });
    $(nav).on('mouseleave', 'li', function(e) {
        e.preventDefault();
        animateMenu();
    });

  }

  // Define method "refresh"
  MagicLine.prototype.refresh = animateMenu;

  // ANIMATE function
  function animateMenu(dest = nav.find('.active').length ? nav.find('.active') : nav.first()){

    var leftPos = dest.position().left;
    // Fix for nav-scroll-x plugin
    var scrollLeft = nav.scrollLeft();
    var newWidth = dest.css('width');

    theLine.stop().animate({
        left: leftPos + scrollLeft + 'px',
        width: newWidth
    }, 300, "swing");
  }


}());
