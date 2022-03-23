 $(function() {

    // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
      ui.children().each(function() {
        $(this).width($(this).width());
      });
      return ui;
    };

    $("#list_sortable tbody").sortable({
      helper: fixHelper,
      stop: function(event, ui) {

        var inputs = $('#list_sortable').find('input.order');
        var content_type = $('input[name=content_type]').val();
        var content_id = $('input[name=content_id]').length > 0 ? $('input[name=content_id]').val() : null;

       $(inputs).each(function(index) {
        console.log(index);
          $(this).val(index);
       });

      $.ajax({
                    url:  $('base').attr('href') + 'ajax.php',
                    type: 'POST',
                    dataType:'json',
                    data: "case=order&content_id="+content_id+"&content_type="+content_type+"&"+($(inputs).serialize()),
                    success: function(result) {
                      console.log(result);
                    },
               error: function (xhr, ajaxOptions, thrownError) {
                console.log(result);
                }
        });

    }
    }).disableSelection();

     $(".sortable tbody").sortable({
         helper: fixHelper,
         stop: function(event, ui) {

             var inputs = $('.sortable').find('input.order');
             var content_type = $('input[name=content_type]').val();
             var content_id = $('input[name=content_id]').length > 0 ? $('input[name=content_id]').val() : null;

             $(inputs).each(function(index) {
                 console.log(index);
                 $(this).val(index);
             });

             $.ajax({
                 url:  $('base').attr('href') + 'ajax.php',
                 type: 'POST',
                 dataType:'json',
                 data: "case=order&content_id="+content_id+"&content_type="+content_type+"&"+($(inputs).serialize()),
                 success: function(result) {
                     console.log(result);
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     console.log(result);
                 }
             });

         }
     }).disableSelection();






});