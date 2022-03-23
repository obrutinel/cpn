
</div><!-- /.page-content -->


</div><!-- /.main-content -->

</div>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
	<i class="icon-double-angle-up icon-only bigger-110"></i>
</a>




<script src="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/i18n/jquery.spectrum-fr.min.js"></script>

<script type="text/javascript">
	jQuery(function($) {

		$('.input-file').ace_file_input({
			no_file:'Choisissez un document ...',
			btn_choose:'Choisissez',
			btn_change:'Modifier',
			droppable: false,
			onchange: null,
                thumbnail:false, //| true | large
                whitelist:'gif|png|jpg|jpeg',
                blacklist:'exe|php'
        });
	
		$("#color-picker").spectrum({
			preferredFormat: "hex3",
			showInput: true,
			allowEmpty:true
		});

        $('[rel="datepicker"]').datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            language: "fr-FR"
        });

        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#myTab a[href="' + hash + '"]').tab('show');

	});
</script>


<script type="text/javascript">
	jQuery(function($) {
		var colorbox_params = {
			reposition:true,
			scalePhotos:true,
			scrolling:false,
			previous:'<i class="icon-arrow-left"></i>',
			next:'<i class="icon-arrow-right"></i>',
			close:'&times;',
			current:'{current} of {total}',
			maxWidth:'100%',
			maxHeight:'100%',
			onOpen:function(){
				document.body.style.overflow = 'hidden';
			},
			onClosed:function(){
				document.body.style.overflow = 'auto';
			},
			onComplete:function(){
				$.colorbox.resize();
			}
		};

		$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
				$("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>");//let's add a custom loading icon

			});



	$(function () {
		$('[rel=tooltip]').tooltip();
	});

</script>

<?php
		// Lorsqu'on a besoin de CE DONT a besoin est pas du fourre-tout

		$footer = 'footer_common.php'; // le TOUT

		include ($footer);

		?>
</body>
</html>
