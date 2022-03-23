<?php

use Wagaia\Tables;

/*----------------------------------
 * BLOCS PAR LANGUE
 * ---------------------------------
 */

    $data->blocs = $db->select("select * from ".Tables::$blocs." where page_data_id=".$data->content[$v]->id); ?>

    <div class="space-4"></div>
    <div class="form-group">
        <div class="col-sm-12">
            <h3 class="header blue lighter smaller">
                <i class="ace-icon fa fa-calendar-o smaller-90"></i>
                <?= trans($type.'_OptionBlocs');?>
            </h3>
            <button class="WagaiaAddBloc btn btn-sm btn-success"/>Ajouter un bloc</button>
        </div>
    </div>
    <div data-lg='<?=$v;?>' id="WagaiaBlocs_<?=$v;?>" data-lg='<?=$v;?>' class="form-group WagaiaBlocs">
        <?php
        if (!empty($data->blocs)) {
            $i=1;
            foreach($data->blocs as $bloc) { ?>
                <div class="col-sm-6">
                    <h4 class="header blue smaller">Bloc N° <?=$i;?> <button class="wagaia-delete-bloc pull-right btn btn-danger btn-xs"><i class="fa fa-minus"></i></button></h4>
                    <input class="form-control" type="text" name="bloc_titre[<?=$v;?>][]" value="<?=$bloc->titre;?>"/><br>
                    <textarea class="form-control simpleMce" rows="5" name="bloc_texte[<?=$v;?>][]"><?= $bloc->texte;?></textarea>
                </div>
                <?php
                ++$i;
            }
        } ?>
    </div>
    <div style="clear:both;"></div>