jQuery(function($) {

    /* ------------------------------------
    *  GESTION DU JCROP
    * ------------------------------------ */

    var wi_w = $('#wi').val();
    var wi_h = $('#he').val();

    var temp_w = $('input[name="resized_temp_w"]').val();
    var temp_h = $('input[name="resized_temp_h"]').val();

    var api;
    var ratio = parseFloat(wi_w/wi_h).toFixed(3);

    $('#crop_image').Jcrop({
        onChange: showCoords,
        onSelect: showCoords,
        aspectRatio: ratio,
        minSize:[wi_w,wi_h],
        boxWidth: 1100,
        boxHeight: 800

    },function(){
        api = this;
        api.setSelect([130,65,130+350,65+285]);
        api.setOptions({ bgFade: true, allowResize: true, trueSize: [temp_w, temp_h] });
        api.ui.selection.addClass('jcrop-selection');
    });


    /* ------------------------------------
    *  GESTION DE LA VISIBILITE DE LA PAGE
    * ------------------------------------ */

    $('#status').off().on('click', function() {
      var status = $(this).find('input').is(':checked') ? 0 : 1;
      var content_id = $('input[name=id]').val();

      $.ajax({
        url: $('base').attr('href') + 'ajax.php',
        type: 'POST',
        data: "content_id="+content_id+"&content_type=status&status="+status,
        success: function(result) {

          $('#AjaxResponse').html(result);
      },
      error: function (xhr, ajaxOptions, thrownError) {

        $('#AjaxResponse').html('<div class="alert alert-danger" style="margin-top:10px;padding:8px 15px">Une erreur est survenue</div>').delay(4000).fadeOut(function() {$('#SearchResponse').html(''); });
    }
});
  });


/*
| -------------------------------
| TESTE UNE CHAINE URL
| --------------------------------
    Will match :
    ------------
    http://www.foufos.gr
    https://www.foufos.gr
    http://foufos.gr
    http://www.foufos.gr/kino
    http://www.t.co
    http://t.co
    http://werer.gr
    www.foufos.gr

    Will NOT match :
    ----------------
    www.foufos
    http://www.foufos
    http://foufos
*/

  function ValidURL(str) {

       var expression = /https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,}?/gi;
       var regex = new RegExp(expression);

      if (str.match(regex)) {
       return true;
    }
    return false;
}
$('input.plugin-url').on('keyup', function() {
    var valid = ValidURL($(this).val());
    $(this).css('border','1px solid '+ (valid ? 'green' : 'red'));
});


});