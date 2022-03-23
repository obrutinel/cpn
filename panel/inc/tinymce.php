<script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/tinymce.min.js"></script>

<script>

    $(function() {

        let baseHref = location.protocol+'//'+window.location.hostname+'/';

        tinymce.init({
            selector: ".textarea",
            theme: "silver",
            width: '100%',
            height: '500',
            menubar : false,
            plugins: [
				"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"table directionality emoticons template paste textpattern"
            ],
            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontsizeselect",
            toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media responsivefilemanager | insertdatetime preview | forecolor backcolor",
            toolbar3: "table | hr removeformat | subscript superscript | fullscreen | ltr rtl | spellchecker | nonbreaking restoredraft | | custombutton | code",
            textcolor_map:["004f9a", "Bleu", "373941", "Gris", "993300","Burnt orange","333300","Dark olive","003300","Dark green","003366","Dark azure","000080","Navy Blue","333399","Indigo","333333","Very dark gray",
					"800000","Maroon","FF6600","Orange","808000","Olive","008000","Green","008080","Teal","0000FF","Blue","666699","Grayish blue","808080","Gray","FF0000","Red","FF9900","Amber","99CC00","Yellow green",
					"339966","Sea green","33CCCC","Turquoise","3366FF","Royal blue","800080","Purple","999999","Medium gray","FF00FF","Magenta","FFCC00","Gold","FFFF00","Yellow","00FF00","Lime","00FFFF",
					"Aqua","00CCFF","Sky blue","993366","Red violet","FFFFFF","White","00384e","fond","00384e","fond", "3b9bd9", "bleu", "406a7a", "bleur clair", "c7342e", "rouge"],
            image_advtab: true ,
            language: "fr_FR",
            language_url : baseHref+"panel/js/responsivefilemanager/tinymce/langs/fr_FR.js",
			convert_urls: true,
			relative_urls: false,
			remove_script_host: false,
            content_css: baseHref+"panel/assets/css/style_tiny.css",
            external_filemanager_path: "js/responsivefilemanager/filemanager/",
            filemanager_title:"Filemanager" ,
            external_plugins: {
              "filemanager" : baseHref+"panel/js/responsivefilemanager/filemanager/plugin.min.js",
              "responsivefilemanager" : baseHref+"panel/js/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js"
            }
    });

});

</script>
