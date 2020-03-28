(function(){

  imagePopup = function(card){

    var id = card.attr('id');

    // Nusiust id per ajax ir gaut more product info
    $.ajax({
      type: 'GET',
      url: '/ajax/product/'+id,
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

}());
