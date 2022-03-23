
$(document).ready(function() {

    $('.dropdown > a').click(function(){
        location.href = this.href; 
    });

});

function responsiveTable(target) {

		// var target = conteneur cible, exemple : $('.container').find('table');
		var w = $(window).width(), t = target;
		$('.responsive-table').remove();

		if(w<480) { // ajustez la valeur ou le set de valeurs, en fonction de ce qu'ils vous faut
			$(t).each(function(index) {

				var vals = [];

				$(this).find('td').each(function() {
					vals.push($(this).html());
				});

				$('<div class="responsive-table table-'+index+'">').insertAfter(t);
				$(vals).each(function(i,v) {
					$('<div class="col-xs-12">'+v+'</div>').appendTo('.table-'+index);
				});

				$(this).hide();

			});
	} else {
		t.show();
	}

}

responsiveTable($('table:not(.notrep)'));

$(window).on('resize', function() {
	responsiveTable($('table:not(.notrep)'));
});
