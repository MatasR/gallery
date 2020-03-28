(function(){

  imagePopup = function(card){

    var id = card.attr('id');

    // Nusiust id per ajax ir gaut more product info
    $.ajax({
      type: 'GET',
      url: '/ajax/product/'+id,
      data: '_token = '+$('meta[name="_token"]').attr('content'),
      success: function(data) {
        console.log(data);
      }
    });

  };

}());
