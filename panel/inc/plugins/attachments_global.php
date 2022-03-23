<?php

/*---------------------------------
* Module Pièces jointes
* ---------------------------------
* Traitements globaux
*/

use Wagaia\Tables;
use Wagaia\Lib;
use Symfony\Component\HttpFoundation\Request;


// A reinseigner par vous-mêmes en fonction des types globaux que vous validez
/*
$mime_types = [
    'mp4'   => 'video/mp4',
    'webm'  => 'video/webm',
    'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .DOCX
    'pdf'   => 'application/pdf', // PDF
    'odt'   => 'application/vnd.oasis.opendocument.text', // OpenOffice .odt,
    'doc'   => 'application/msword' // .doc
];*/


    if ($_POST) {

        $_SESSION['notification']['has_attachments'] = [];

    /* -------------------------------------
    *   Traite les suppressions en mode AJAX
    * ------------------------------------- */

    if (isset($_POST['ajax'])) {

        require_once('../../../vendor/autoload.php');

        extract($_POST);
        $json_response = [];

        $attachment  = $db->get('select * from '.Tables::$attachments .' where id='.$id);

        if ($attachment) {
            if (is_file(UPLOAD_FOLDER . $attachment->filename)) {
               unlink(UPLOAD_FOLDER . $attachment->filename);
           }
           $db->query('delete from '.Tables::$attachments .' where id='.$id);
           $json_response['message'] = 'Fichier supprimé';
       } else {
        $json_response['error'] = true;
        $json_response['message'] = 'Fichier inconnu';
    }

    Lib::json($json_response);

} else {

    /*-------------------------------
    * Traite la requête $_POST
    * ----------------------------- */

    $request = Request::createFromGlobals();

    // Les fichiers en cours de téléchargement
    $files = $request->files->get('document');


    //    dump($validation);

    if(!empty($files)) {

        // Par défaut on ne valide pas
        $validation = false;

        // Si le type qui a l'option a des extensions indiquées, alors on les valide
        if (!empty($type) && is_array($options['has_attachments']['type'][$type])) { // File validation
            $validation = true;
        }

        // Les pièces jointes sont disponibles par langue
        foreach($website_lg as $k=>$v) {

            // Loop dans les fichiers
            foreach($files[$k] as $d=>$file) {

                // Cette vérification est nécessaire car en théorie on peut charger
                // une pièce-jointe pour langue['fr'] mais pas pour langue['en'] par ex
                if (!empty($file)) {

                    // Par défaut : ça ne doit pas passer
                    $valid = false;

                    $ext = $file->guessExtension();

                    // Si validation nécessaire et que l'extension est dans le
                    // set et qu'elle correspond au mime type : on autorise
                    if(
                        $validation &&
                        in_array($ext, $options['has_attachments']['type'][$type]) &&
                        array_key_exists($ext, $mime_types) &&
                        $file->getMimeType() == $mime_types[$ext]
                        )
                    {
                        $valid = true;

                    // Sinon : envoyer une notification
                    } else {

                        $_SESSION['notification']['has_attachments']['danger'][] = 'Attention! Le fichier téléchargé doit être de type : ' . implode(', ', array_values($options['has_attachments']['type'][$type]));

                    }

                    // Si validation nécessaire et fichier validé
                    // OU pas de validation : traiter les fichiers
                    if (!$validation or ($validation && $valid)) {

                        // génération d'un nom de fichier unique
                        //$filename = hash('ripemd320', time(). $file->getClientOriginalName());
                        $filename = time();

                        $db->query("insert into ".Tables::$attachments." (page_data_id, title, filename, filename_original) values ('".$_POST['page_data_id'][$k]."',
                        '".$db->escape($attachment_title[$k][$d])."', '".$filename.".".$ext."', '".$db->escape($file->getClientOriginalName())."')");

                        $file->move(UPLOAD_FOLDER, $filename.'.'.$ext);
                    }

                }
            }
        }
    }
}

} else {

    // Créé la table automatiquement

    if (!$db->is_table(Tables::$attachments)) {
        $db->query('CREATE TABLE `'.Tables::$attachments.'` (
         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
         `page_data_id` int(10) unsigned DEFAULT NULL,
         `title` TINYTEXT NULL DEFAULT NULL AFTER `page_data_id`,
         `filename` VARCHAR(256) NULL,
         `filename_original` TEXT NULL DEFAULT NULL,
         PRIMARY KEY (`id`),
         KEY `FK_wagaia_attachments_wagaia_pages_data` (`page_data_id`),
         CONSTRAINT `FK_wagaia_attachments_wagaia_pages_data` FOREIGN KEY (`page_data_id`) REFERENCES `wagaia_pages_data` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /*---------------------------------
    * Traitement JS
    * ----------------------------- */
    ?>

    <script>
        $(function() {

            // Ajouter un fichier
            // ------------------
            $('i.add-attachment').click(function() {
                var c = $(this).parents('div.attachments'), inputs = c.find('div.input-files'), lg = inputs.attr('data-lg'), titles = c.find('div.input-files-titles'), el = titles.find('div:first').clone();

                titles.append(el).find('input:last').val('');
                inputs.append('<input class="input-file" name="document['+lg+'][]" type="file">');
                inputs.find('input.input-file:last').ace_file_input({
                    no_file:'Choisissez un fichier ...',
                    btn_choose:'Choisissez',
                    btn_change:'Modifier'
                });
            });

            // Supprimer un fichier
            // --------------------
            $.fn.deleteAttachment = function ()
            {

                $(this).click(function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data-id');


                    console.log("ajax&id=" + $(this).attr('data-id'));
                    $.ajax({
                        url: $('base').attr('href') + 'inc/plugins/attachments_global.php',
                        type: 'POST',
                        dataType:'json',
                        data: "ajax&id=" + id,
                        success: function(result) {
                            $('tr.attachment-'+id).remove();
                            console.log(result);

                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var result = ' Error status : '+ xhr.status+ ", Thrown Error : "+ thrownError +", Error : "+ xhr.responseText;
                            console.log(result);

                        }
                    });

                });
            }

            $('#existing-attachments td.delete button').deleteAttachment();
        });
    </script>
    <?php
} ?>