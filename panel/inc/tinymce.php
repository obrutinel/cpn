

<script>

    var allowed_keys = [8, 13, 16, 17, 18, 20, 33, 34, 35,36, 37, 38, 39, 40, 46];
    var chars_without_html = 0;

    $(function() {

        var tinymce_lg = $('.tab-pane.active').attr('data-lg');

        // Cette fonction va limiter le nombre de chars pour un textarea spécifié dans $options['limit_input']['type']
        // en ne prenant pas en compte les tags HTML
        // A vérifier si ça fonctionne en multi-langues (c'était fait dans le cadre d'un mono langue)

        <?php
        /*if (array_key_exists($type, $options['limit_input'])) {

            foreach($options['limit_input'][$type] as $key=>$limit) { ?>
                var <?=$key;?>_max_chars    = <?=$limit;?>; //max characters
                var <?=$key;?>_max_for_html = <?=$limit;?>*3; //max characters for html tags

                function <?=$key;?>_alarmChars() {

                    var tinymce_lg = $('.tab-pane.active').attr('data-lg');

                    if(chars_without_html > (<?=$key;?>_max_chars - 25)){
                        $('#<?=$key;?>_'+tinymce_lg+'_chars_left').css('color','red');
                    }else{
                        $('#<?=$key;?>_'+tinymce_lg+'_chars_left').css('color','gray');
                    }
                }

                <?php
            }
        }*/ ?>

        tinymce.init({
            selector: ".textarea",
            theme: "modern",
            width: '100%',
            menubar : false,
            plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
            ],

            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontsizeselect",
            toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media responsivefilemanager | insertdatetime preview | forecolor backcolor",
            toolbar3: "table | hr removeformat | subscript superscript | fullscreen | ltr rtl | spellchecker | nonbreaking restoredraft code",
            textcolor_map:["004f9a", "Bleu", "373941", "Gris", "993300","Burnt orange","333300","Dark olive","003300","Dark green","003366","Dark azure","000080","Navy Blue","333399","Indigo","333333","Very dark gray",
					"800000","Maroon","FF6600","Orange","808000","Olive","008000","Green","008080","Teal","0000FF","Blue","666699","Grayish blue","808080","Gray","FF0000","Red","FF9900","Amber","99CC00","Yellow green",
					"339966","Sea green","33CCCC","Turquoise","3366FF","Royal blue","800080","Purple","999999","Medium gray","FF00FF","Magenta","FFCC00","Gold","FFFF00","Yellow","00FF00","Lime","00FFFF",
					"Aqua","00CCFF","Sky blue","993366","Red violet","FFFFFF","White", "3F51B5", "Bleu", "5C6BC0", "Violet clair", "3F51B5", "Violet clair"],
			fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 20pt 22pt 24pt 28pt 30pt 32pt 34pt 36pt",
            image_advtab: true ,
            language: "fr_FR",
            language_url :"<?php echo HTTP;?>panel/js/tinymce/langs/fr_FR.js",
            document_base_url: "<?php echo HTTP;?>",
            relative_urls: false,
            remove_script_host: false,
            content_css:"<?php echo HTTP;?>panel/assets/css/style_tiny.css?v=2",
            external_filemanager_path:"js/filemanager/",
            filemanager_title:"Filemanager" ,
            filemanager_title:"Filemanager" ,
            external_plugins: {
              "filemanager" : "<?php echo HTTP;?>panel/js/filemanager/plugin.min.js",
              "responsivefilemanager" : "<?php echo HTTP;?>panel/js/responsivefilemanager/plugin.min.js"
          },

          setup: function(ed) {
            ed.on("KeyDown", function(ed,evt) {
                whtml = tinyMCE.activeEditor.getContent();

                without_html = whtml.replace(/(<([^>]+)>)/ig,"");
                without_html = without_html.replace(/&(acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);/ig,'$1');
                without_html = without_html.replace(/&hellip;/ig,'...');
                without_html = without_html.replace(/&rsquo;/ig,'\'');
                without_html = $.trim(without_html.replace(/&([A-za-z]{2})(?:lig);/ig,'$1'));

                chars_without_html = without_html.length;
                chars_with_html    = whtml.length;

                    wordscount = without_html.split(/[ ]+/).length;  // Just to get the wordcount, in case...

                    var key = ed.keyCode;

                    <?php

                    /*if (array_key_exists($type, $options['limit_input'])) { ?>

                        var tinymce_lg = $('.tab-pane.active').attr('data-lg');

                        <?php

                        foreach($options['limit_input'][$type] as $key=>$limit) { ?>

                            $('#<?=$key;?>_'+tinymce_lg+'_chars_left').html(<?=$key;?>_max_chars - chars_without_html);

                            if(allowed_keys.indexOf(key) != -1){
                                <?=$key;?>_alarmChars();
                                return;
                            }

                            if (chars_with_html > (<?=$key;?>_max_chars + <?=$key;?>_max_for_html)){
                                ed.stopPropagation();
                                ed.preventDefault();
                            }else if (chars_without_html > <?=$key;?>_max_chars-1 && key != 8 && key != 46){
                                //alert('Characters limit!');
                                ed.stopPropagation();
                                ed.preventDefault();
                            }
                            <?=$key;?>_alarmChars();

                            <?php
                        }
                    } */?>
                }
                );
        }

    });

<?php

if (array_key_exists($type, $options['limit_input'])) {

    /*foreach($options['limit_input'][$type] as $key=>$limit) { ?>

        var <?=$key;?>_whtml, <?=$key;?>_without_html;

        <?=$key;?>_whtml = $("#<?=$key;?>_"+tinymce_lg).text();

        <?=$key;?>_without_html = <?=$key;?>_whtml.replace(/(<([^>]+)>)/ig,"");
        <?=$key;?>_without_html = <?=$key;?>_without_html.replace(/&(acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);/ig,'$1');
        <?=$key;?>_without_html = <?=$key;?>_without_html.replace(/&hellip;/ig,'...');
        <?=$key;?>_without_html = <?=$key;?>_without_html.replace(/&rsquo;/ig,'\'');
        <?=$key;?>_without_html = $.trim(<?=$key;?>_without_html.replace(/&([A-za-z]{2})(?:lig);/ig,'$1'));

        var chars_without_html = <?=$key;?>_without_html.length;

        <?php

        foreach($website_lg as $l=>$lg) { ?>
            $('#<?=$key;?>_<?=$lg;?>_chars_left').html(<?=$key;?>_max_chars - chars_without_html);
            <?php
        }
        ?>
        <?=$key;?>_alarmChars();

        <?php
    }*/
} ?>


var simpleMce_settings = {
    selector: ".simpleMce",
    theme: "modern",
    width: '100%',
    menubar : false,
    plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
    ],

    toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | cut copy paste",
    language: "fr_FR",
    language_url :"<?php echo HTTP;?>panel/tinymce/langs/fr_FR.js",
    document_base_url: "<?php echo HTTP;?>",
    relative_urls: false,
    remove_script_host: false,
    content_css:"<?php echo HTTP;?>panel/css/style_tiny.css",
};

tinymce.init(simpleMce_settings);

});

</script>
