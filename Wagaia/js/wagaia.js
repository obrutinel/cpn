jQuery(document).ready(function($) {
	
	// Formulaire de recherche Accueil
	if($('.select-theme-multiple').length > 0) {
		$('.select-theme-multiple').select2();
	}
	
	
	if($('.same-height').length > 0) {
		$('.same-height').matchHeight();
	}
	
	if ($('.custom-select').length > 0) {
		$('.custom-select').selectize();
	}

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

                    $('<div class="responsive-table table-'+index+' row">').insertAfter(t);
                    $(vals).each(function(i,v) {
                        $('<div class="col-xs-12">'+v+'</div>').appendTo('.table-'+index);
                    });

                    $(this).hide();

                });
        } else {
            t.show();
        }

    }

    responsiveTable($('table'));

    $(window).on('resize', function() {
        responsiveTable($('table'));
    });



    var token = function() {
        if ($('#token').length > 0) {
            return $('#token').text();
        }
    },
    base_url = function() {
        return $('base').attr('href');
    },
    ajax_url = function() {
        return $('base').attr('href') +'Wagaia/ajax.php';
    },
    // Afficher une alerte
    setAlert = function(message, type) {
        alert = (typeof type == 'undefined' || type == 'alert') ? 'danger' : 'success';
        $('#AjaxResponse').html('<div class="pi-alert pi-alert-'+alert+'" style="margin:20px 0 -20px 0;padding:8px 15px"><p>'+message+'</p></div>');
    },
    // Afficher une alerte
    pushMessage = function(container, message, type) {
        alert = (typeof type == 'undefined' || type == 'alert') ? 'danger' : 'success';
        container.html('<div class="pi-alert pi-alert-'+alert+'"><p>'+message+'</p></div>');
    },
    clearAlert = function() {
        $('#AjaxResponse').html('');
    };


    // NEWSLETTER
	$('#newsletter form').submit(function(e) {
		e.preventDefault();
		
		var email = $(this).find('#email').val();
		console.log(email);
		 
		$.ajax({
			url : 'panel/ajax/newsletter.php',
			type : 'POST',
			data : 'email=' + email,
			success: function(result) {
				$('#newsletter').html('Félicitation ! <br />Votre inscription a bien été prise en compte.').addClass('success');
			}
		});
	   
	});


    /*$('#newsletter form').submit(function(e) {
        e.preventDefault();
        console.log('Newsletter submit');
        alert('Newsletter submit');
        var email = $('#email').val(), r = $('#response-ajax');
        if (email == '') {
            pushMessage(r, "Vous devez indiquez une adresse e-mail valide", 'alert');
            return false;
        }

        $.ajax({
            url: ajax_url(),
            type: 'POST',
            dataType:'json',
            data: "case=subscribe&object=newsletter&_token="+token()+"&email="+email,
            success: function(result) {
                console.log(result);
                pushMessage(r, result.message, result.messageType);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var result = ' Error status : '+ xhr.status+ ", Thrown Error : "+ thrownError +", Error : "+ xhr.responseText;
                pushMessage(r, "Une erreur s'est produite", 'alert');
            }
        });
    });*/

});