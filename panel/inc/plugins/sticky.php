<?php

/*-----------------------------------
* Module Sticky (article en vedette)
* -----------------------------------
* Traitements globaux
*/



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once($_SESSION['abspath'] .'vendor/autoload.php');


use Wagaia\Tables;
use Wagaia\Lib;

if ($_POST) {

    /*---------------------------------
    * Traite les suppressions
    * ----------------------------- */

    if (isset($_POST['ajax'])) {

        extract($_POST);
        $json_response = [];

        $db->query('delete from '.Tables::$sticky .' where id='.$id);
        $json_response['message'] = 'Position supprimé';

        Lib::json($json_response);

    } else {

        /*---------------------------------
         * Traite la requête POST classique
         * ----------------------------- */

        $db->query("delete from ". Tables::$sticky . " where page_id=".$id);
        $position = $db->get('select max(position) as position from '.Tables::$sticky)->position;

        if(isset($sticky)) {
            $db->query("insert into ".Tables::$sticky .'(position, page_id) values ('.($position+1).','.$id.')' );
        }
    }

} else {

    /*---------------------------------
     * ADMINISTRATION
     * ----------------------------- */

        // Créé la table automatiquement

    if (!$db->is_table(Tables::$sticky)) {
        $db->query('CREATE TABLE `'.Tables::$sticky.'` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `page_id` INT UNSIGNED NULL,
            `position` INT UNSIGNED NULL,
            PRIMARY KEY (`id`),
            INDEX `position` (`position`),
            CONSTRAINT `FK__wagaia_pages_sticky` FOREIGN KEY (`page_id`) REFERENCES `wagaia_pages` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /*-------------------------------------
     * GESTION DU STATUT AU SEIN D'UNE PAGE
     * ------------------------------------ */

    if (!empty($_GET['id'])) {

        $sticky = $db->count(Tables::$sticky, 'page_id',$identifiant);

        ?>
        <div class="col-xs-3 col-sm-3">
            <h3 class="header blue lighter smaller clear">
                <i class="ace-icon fa fa-calendar-o smaller-90"></i>
                Pages à la une
            </h3>
            <input type="checkbox" name="sticky" <?= !empty($sticky) ? ' checked' : true;?> /> Mettre en avant
            <?php

        } else {

        /*-------------------------------------
        * LISTE ET POSITIONNEMENT
        * ------------------------------------ */

        require_once('../header.php');
        $stickies = $db->select("select a.titre, a.image, b.* from ". Tables::$pages . " a join ". Tables::$sticky ." b on a.id=b.page_id order by b.position");

        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <div id="pagelist-nav">
                        Pages à la une
                    </div>

                    <?php

                    if ($stickies) { ?>

                        <input type="hidden" name="content_type" value="sticky" />

                        <table id="list_sortable" class="table dataTable table-striped table-bordered table-hover">

                            <thead>
                                <th class="id"></th>
                                <th></th>
                                <th>Titre</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="stickies">

                                <?php
                                foreach($stickies as $v) { ?>
                                    <tr class="sticky-<?=$v->id;?>">
                                        <td class="id">
                                            <input type="hidden" name='order[<?= $v->id;?>]' class="order">
                                        </td>
                                        <td style="width:60px;">
                                            <?= is_file(IMG_FOLDER .$v->image) ?  '<img src="'.IMG_URL .'thumbs/'.$v->image.'" style="width:50px;" />' : null ?>
                                        </td>
                                        <td><?= $v->titre;?></td>
                                        <td>
                                            <a title="Modifier la page <?php echo  $v->titre; ?>" data-toggle="tooltip" href="pages.php?show=edit&id=<?= $v->page_id;?>" class="btn btn-xs btn-info"><i class="icon-pencil bigger-120"></i></a>
                                            <a data-id="<?=$v->id;?>" title="Supprimer la page <?= $v->titre; ?>" data-placement="top" rel="tooltip" href="#" role="button" data-target="#myModal<?php echo $v->id;?>" data-toggle="modal" class="delete btn btn-xs btn-danger"><i class="icon-trash bigger-120"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } ?>

                </div>
            </div>
        </div>
        <script src="<?php echo HTTP;?>panel/js/wagaia_sortable.js"></script>
        <script>

        /*-------------------------------------
        *   SUPPRESSION JS
        * ------------------------------------ */


            $.fn.deleteSticky = function ()
            {

                $(this).click(function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data-id');


                    console.log("ajax&id=" + $(this).attr('data-id'));
                    $.ajax({
                        url: $('base').attr('href') + 'inc/plugins/sticky.php',
                        type: 'POST',
                        dataType:'json',
                        data: "ajax&id=" + id,
                        success: function(result) {
                            $('tr.sticky-'+id).remove();
                            console.log(result);

                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var result = ' Error status : '+ xhr.status+ ", Thrown Error : "+ thrownError +", Error : "+ xhr.responseText;
                            console.log(result);

                        }
                    });

                });
            }

            $('#stickies a.delete').deleteSticky();

        </script>
        <?php

        require_once('../footer.php');

    }
}