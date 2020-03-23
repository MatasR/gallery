(function() {

  // Define our constructor
  this.MagicLine = function() {

    // Find required elements
    mainNav = $('#magicLineNavbar');
    active = mainNav.find('.active');

    // Create the magic line
    theLine = $('<li></li>').attr('id', 'magic-line');
    theLine.css('left', active.position().left).css('width', active.css('width'));

    // Append the magic line to main navigation
    mainNav.append(theLine);

    // EVENTS
    // Mouseenter/Mouseleave -> move magicLine
    $(mainNav).on('mouseenter', 'li', function(e) {
        e.preventDefault();
        animateMenu($(this));
    });
    $(mainNav).on('mouseleave', 'li', function(e) {
        e.preventDefault();
        animateMenu();
    });

  }

  // Define method "refresh"
  MagicLine.prototype.refresh = animateMenu;

  // ANIMATE function
  function animateMenu(dest = mainNav.find('.active')){

    leftPos = dest.position().left + 'px';
    newWidth = dest.css('width');

    theLine.stop().animate({
        left: leftPos,
        width: newWidth
    }, 300, "swing");
  }

}());
