<script type="text/javascript">

	jQuery(function($) {
		$( "[rel=datepicker]" ).datepicker({
			showOtherMonths: true,
			selectOtherMonths: false,
			language: "fr-FR"
		});
	});
	
	
	tinymce.init({
		selector: '.tiny-basic',
		height: 250,
		menubar: false,
		statusbar: false,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor textcolor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code wordcount'
		],
		toolbar: 'bold italic backcolor | link | undo redo | formatselect | alignleft aligncenter alignright alignjustify | bullist | removeformat',
		language_url: "<?=HTTP?>panel/js/tinymce/langs/fr_FR.js",
		content_css: "<?=HTTP?>panel/assets/css/style_tiny.css"
	});

    tinymce.init({
        selector: '.tiny-medium',
        height: 250,
        menubar: false,
        statusbar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code wordcount'
        ],
        toolbar: 'bold italic backcolor | link | undo redo | formatselect | alignleft aligncenter alignright alignjustify | bullist | removeformat | responsivefilemanager | code',
        language_url: "<?=HTTP?>panel/js/tinymce/langs/fr_FR.js",
        content_css: "<?=HTTP?>panel/assets/css/style_tiny.css",
        external_filemanager_path:"js/filemanager/",
        filemanager_title:"Filemanager" ,
        filemanager_title:"Filemanager" ,
        external_plugins: {
            "filemanager" : "<?=HTTP?>panel/js/filemanager/plugin.min.js",
            "responsivefilemanager" : "<?=HTTP?>panel/js/responsivefilemanager/plugin.min.js"
        },
    });
	
</script>

<script type="text/javascript">
	jQuery(function($){

		function showErrorAlert (reason, detail) {
			var msg='';
			if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
			else {
				console.log("error uploading file", reason, detail);
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
				'<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		}
	});
</script>

