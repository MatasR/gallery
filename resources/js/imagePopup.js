(function(){

  imagePopup = function(card){

    allignImage(card);

    var id = card.attr('id');

    // Nusiust id per ajax ir gaut more product info
    $.ajax({
      type: 'GET',
      url: '/ajax/modal/'+id,
      data: '_token = '+$('meta[name="_token"]').attr('content'),
      success: function(data) {
        insertData(data);
        $('.image-popup').modal('show');
      }
    });

  };

  // Insert new product data to modal html
  function insertData(data){
    $('.image-popup').find('h2').text(data.title);
    $('.image-popup').find('img').attr('src', data.image);
  }

  // On same click make that the modal image would be at the same position as card image for a very nice transition effect
  function allignImage(card){// Still on progress (card img position abs)

    // 1.
    var position = {};
    position.top = card.offset().top - $(document).scrollTop();
    //position.left = card.offset().left;

    //console.log('Before: ');
    //console.log(position);

    // Remove margin from both positions
    position.top -= 16;
    //position.left -= 16;// Will need this when two cols at least

    //console.log('After: ');
    //console.log(position);

    // 2.
    var modal = $('.image-popup');
    modal.css(position).delay(400).animate({
      top: 0,
      //left: 0
    });

    modal.find('.modal-body, .modal-footer').slideUp().delay(300).slideDown(300);

    // We should not use animate, css better

    //var modalImage = $('.image-popup').find('img');

    //modalImage.css(position);

    // 1. Calc the card position
    // 2. Move modal to the card's possition
    // 3. Excetute transition

    // Later
    //what this function should do:
    // 1. Make modal position absolute
    // 2. Align it with the card
    // 3. Excetute the transition
    // 4. Remove position absolute
  }

}());
