<?php

/*---------------------------------
* Module Pièces jointes
* ---------------------------------
* Intégration par langue
*/

use Wagaia\Tables;
use Wagaia\Lib;

if (!$_POST) {

    $data->attachments = $db->select("select * from ".Tables::$attachments." where page_data_id=".$data->content[$v]->id);

    ?>

    <div class="space-4"></div>
    <div class="form-group attachments">
        <div class="col-sm-12">
            <h3 class="header blue lighter smaller">
                <i class="ace-icon fa fa-file-o smaller-90"></i>
                Fichier <!--<i class="add-attachment fa fa-plus-circle"></i>-->
            </h3>
        </div>
        <div class="col-sm-6 input-files-titles">
            <div><input type="text" name="attachment_title[<?=$k;?>][]" class="form-control" placeholder="Titre" /></div>
        </div>
        <div class="col-sm-6 input-files" data-lg="<?=$k;?>">
            <input class="input-file" name="document[<?=$k;?>][]" type="file">
        </div>

        <div class="col-sm-12">
            <?php

            session_notification('has_attachments');

            if (!empty($data->attachments)) { ?>
                <table class="table table-condensed table-hover table-striped" id="existing-attachments">
                    <?php
                    foreach($data->attachments as $attachment) { ?>
                        <tr class="attachment-<?=$attachment->id;?>">
                            <td><?= $attachment->title;?></td>
                            <td>
                                <a target="_blank" href="<?=IMG_URL . $attachment->filename;?>"><?=$attachment->filename_original;?></a>
                            </td>
                            <td class="delete">
                                <button data-id="<?=$attachment->id;?>" class="btn btn-danger btn-xs"><i class="icon-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                    } ?>
                </table>
                <?php
            } ?>
        </div>
    </div>
    <div class="space-4"></div>
    <div style="clear:both;"></div>
    <?php
} ?>