<?php

use Wagaia\Lang;

/*
|---------------------------------------------
| REDIMENSIONNEMENT JCROP
|---------------------------------------------
*/
require(ABSPATH .'panel/inc/jcrop_form.php');

?>



<form name="main_f" method="post" action="pages.php" enctype="multipart/form-data" autocomplete="off" style="padding-top:20px;">
    <input type="hidden" name="resized_temp_w" value="<?= $resized_img ? $temp_width : null;?>">
    <input type="hidden" name="resized_temp_h" value="<?= $resized_img ? $temp_height : null;?>">
	
	<div class="pull-left">
		<label id="status">
			<input type="checkbox" name="temp" class="ace ace-switch ace-switch-4 btn-rotate" <?= empty($data->temp) ? 'checked' : null;?> />
			<span class="lbl"></span>
		</label>
	</div>

    <div class="pull-right">
		<?php if(!empty($parent)) : ?>
			<?php if (!in_array($data->type, $options_disable['btn_ajouter_un_enregistrement']['type']) && !in_array($data->parent, $options_disable['btn_ajouter_un_enregistrement']['parent'])) : ?>
				<button class="btn btn-default" name="addAndNew" type="submit"><i class="icon-plus bigger-110"></i>Enregistrer et ajouter une nouvel enregistrement</button>
			<?php endif; ?>
			<button class="btn btn-warning" name="s1" type="submit"><i class="icon-ok bigger-110"></i>Enregistrer et sortir</button>
		<?php endif; ?>
   
		<button class="btn btn-danger" name="s2" type="submit"><i class="icon-ok bigger-110"></i>Enregistrer</button>
    </div>

    <div class="tabbable <?= $data->type;?>">

        <div>

            <input type="hidden" name="submit_form" id="submit_form" value="edit_value">
            <input type="hidden" name="id" value="<?= $identifiant;?>">

            <input type="hidden" name="parent" value="<?= $data->parent;?>">
            <input type="hidden" name="type" value="<?= $data->type;?>">

            <?php

                /*
                |---------------------------------------------
                | REDIMENSIONNEMENT JCROP
                |---------------------------------------------
                */

                if ($jcrop) { ?>
                    <div class="form-group">
                        <h3 class="header blue lighter smaller">
                            <i class="ace-icon fa fa-picture-o smaller-90"></i>
                            Photo
                        </h3>

                        <i>Taille <?= in_array($data->type, $jcrop_exclude) ? 'recommandée' : 'min.'?> : <?= $jcrop['w'] .'x'.$jcrop['h'];?> pixels</i><br>
                        <?= $image;?>
                    </div>
                    <?php }

                /*
                |---------------------------------------------
                | OPTIONS
                |---------------------------------------------
                */
                include(ABSPATH . 'panel/inc/plugins/plugins.php'); ?>

                <div class="row">
                    <div class="col-sm-12" style="margin-top:20px;z-index:0;">

                        <div class="tabbable">
                            <?= language_tabs(); ?>
                            <div class="tab-content">
                                <?php

                                foreach($website_lg as $k=>$v) { ?>

                                    <input name='page_id[]' type="hidden" value="<?=  $data->content[$v]->page_id;?>">
                                    <input type="hidden" name="page_data_id[]" value="<?=$data->content[$v]->id;?>"/>

                                    <div class="tab-pane fade <?=  $v==LOCALE ? 'active in': null;?>" id="lang_<?= $v;?>">
                                        <input name='lg[]' type="hidden" value="<?= $v;?>">

                                        <?php
                                        /*
                                        |--------------------------------------------------------
                                        | Titre
                                        |--------------------------------------------------------
                                        */
                                        $visibility = (in_array($type, $options_disable['titre']['type']) or in_array($data->id, $options_disable['titre']['page'])) ? 'hidden' : null; ?>

                                        <div class="<?=$visibility;?>">
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <h3 class="header blue smaller">Titre
                                                        <?php /*if(in_array($data->id, array(9))) { ?>
                                                            <small>(englobé de &lt;span&gt; pour ne pas mettre en gras &lt;/span&gt;)</small>
                                                        <?php }*/ ?>
                                                    </h3>
                                                    <?php if($data->type == 'slide') { ?>
                                                        <textarea type="text" name="titre[]" rows="3" class="form-control col-sm-11 texte_lang_<?= $v;?>"><?= stripslashes($data->content[$v]->titre);?></textarea>
                                                    <?php } else { ?>
                                                        <input type="text" name="titre[]" value="<?= stripslashes($data->content[$v]->titre);?>" class="form-control col-sm-11 texte_lang_<?= $v;?>">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        /*
                                        |--------------------------------------------------------
                                        | Sous-titre
                                        |--------------------------------------------------------
                                        */
                                        $visibility = !in_array($type, $options['has_subtitle']['type']) ? 'hidden' : null; 
										$title = "Sous-titre";
                                        if($data->type == 'list-secteur') $title = "Titre accueil";
                                        if($data->type == 'list-reference') $title = "Titre accueil";
                                        if($data->type == 'list-logo') $title = "Titre accueil";
                                        if($data->type == 'contact') $title = "Carte";
                                        if($data->type == 'sousref_1') $title = "Macaron";
                                        if($data->type == 'sousref_2') $title = "Macaron";
                                        if($data->type == 'sousref_3') $title = "Macaron";

										?>
                                        <div class="<?=$visibility;?>">
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <h3 class="header blue smaller"><?=$title?>
                                                        <?php if($data->type == 'list-secteur' || $data->type == 'list-reference' || $data->type == 'list-logo') { ?>
                                                            <small>(englobé de &lt;span&gt; pour ne pas mettre en gras &lt;/span&gt;)</small>
                                                        <?php } ?>
                                                    </h3>
                                                    <?php if($data->type == 'contact') { ?>
                                                        <textarea class="form-control col-sm-11 texte_lang_<?= $v;?>" rows="5" name="sous_titre[]"><?=stripslashes($data->content[$v]->sous_titre)?></textarea>
                                                    <?php } else { ?>
                                                        <input type="text" name="sous_titre[]" value="<?= stripslashes($data->content[$v]->sous_titre);?>" class="form-control col-sm-11 texte_lang_<?= $v;?>">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        /*
                                        |--------------------------------------------------------
                                        | Lien sous forme de texte
                                        |--------------------------------------------------------
                                        */
                                        $visibility = empty($data->nav_direct_link) && !in_array($type, $options['has_link']['type']) ? ' hidden' : null; ?>

                                        <div class="has_link<?=$visibility;?>">
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h3 class="header blue smaller">Lien</h3>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label no-padding-right" for="link_url_<?=$v;?>"> Url :</label>
                                                        <div class="col-sm-8">
                                                            <input placeholder="http://" type="text" id="link_url_<?=$v;?>" name="link_url[]" value="<?= stripslashes($data->content[$v]->link_url);?>" class="plugin-url form-control col-sm-11 texte_lang_<?= $v;?>">
                                                        </div>
                                                    </div>
                                                    <div class="space-4"></div>
                                                    <div class="form-group texte">
                                                        <label class="col-sm-2 control-label no-padding-right" for="link_text_<?=$v;?>"> Texte :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" id="link_text_<?=$v;?>" name="link_text[]" value="<?= stripslashes($data->content[$v]->link_text);?>" class="form-control col-sm-11 texte_lang_<?= $v;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="info-url"></div>
                                            </div>

                                    </div>

                                    <?php
                                        /*
                                        |--------------------------------------------------------
                                        | Texte court
                                        |--------------------------------------------------------
                                        */
                                        $visibility = (!empty($data->nav_direct_link) or !in_array($type, $options['has_intro']['type'])) ? 'hidden' : null; 
										$title = "Texte court";
                                        if($data->type == 'contact') $title = "Coordonnées";
										?>
                                        <div class="<?=$visibility;?>">
                                            <div class="space-4"></div>											
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h3 class="header blue smaller"><?=$title?></h3>
                                                    <?php if($data->type == 'contact') { ?>
                                                        <textarea class="textarea form-control input-limiter" id="intro_<?=$v;?>" name="intro[]"><?= stripslashes($data->content[$v]->intro);?></textarea>
                                                    <?php } else { ?>
                                                        <textarea style="height: 100px" class="form-control input-limiter" id="intro_<?=$v;?>" name="intro[]"><?= stripslashes($data->content[$v]->intro);?></textarea>
                                                    <?php } ?>
                                                </div>
												<?php if (array_key_exists($type, $options['limit_input']) && !empty($options['limit_input'][$type]['intro'])) { ?>
													 <div class="col-sm-12">
														Caractères maximum : <span class="chars_count" id="intro_<?=$v;?>_chars_left"></span>
													</div>
												<?php } ?>
                                            </div>
                                    </div>

                                    <?php
                                        /*
                                        |--------------------------------------------------------
                                        | Texte principal
                                        |--------------------------------------------------------
                                        */
			
                                        $visibility = (!empty($data->nav_direct_link) or (in_array($type, $options_disable['texte']['type']) or (in_array($data->id, $options_disable['texte']['page'])))) ? 'hidden' : null;
										$title = "Texte";
										if($data->type == 'product') $title = "Ingrédients";
										?>
                                        <div class="<?=$visibility;?>">
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h3 class="header blue smaller"><?=$title?></h3>
													<?php if(in_array($type, $options_disable['tinymce']['type']) or (in_array($data->id, $options_disable['tinymce']['page']))) { ?>
														<textarea class="form-control" id="texte_<?=$v;?>" style="width:100%;height:200px" rows="7" name="texte[]"><?= stripslashes($data->content[$v]->texte);?></textarea>
													<?php } else { ?>
														<textarea class="textarea form-control" id="texte_<?=$v;?>" style="width:100%;height:200px" rows="7" name="texte[]"><?= stripslashes($data->content[$v]->texte);?></textarea>
													<?php } ?>
                                                </div>
                                            </div>
                                            <?php
                                            if (array_key_exists($type, $options['limit_input']) && !empty($options['limit_input'][$type]['texte'])) { ?>
                                            <div class="chars_count" id="texte_<?=$v;?>_chars_left"></div>
                                            <?php
                                        } ?>
                                        </div>

                                        <?php
                                        /*
                                        |--------------------------------------------------------
                                        | Traitements perso liés uniquement au site en cours
                                        |--------------------------------------------------------
                                        */
                                        include (ABSPATH . 'Wagaia/panel/page-lg.php');

                                        /*
                                        |--------------------------------------------------------
                                        | BLOCS
                                        |--------------------------------------------------------
                                        */
                                        if(in_array($type, $options['has_blocs']['type'])) {
                                            include(ABSPATH . 'panel/inc/plugins/blocs.php');
                                        }

                                        /*
                                        |--------------------------------------------------------
                                        | ATTACHMENTS
                                        |--------------------------------------------------------
                                        */
                                        if(in_array($type, $options['has_attachments']['type'])) {
                                            include(ABSPATH . 'panel/inc/plugins/attachments.php');
                                        }

                                        /*
                                        |--------------------------------------------------------
                                        | META
                                        |--------------------------------------------------------
                                        */
                                        $visibility = (!empty($data->nav_direct_link) or (in_array($type, $options_disable['meta']['type']) or (in_array($data->id, $options_disable['meta']['page'])))) ? 'hidden' : null; ?>
                                        <div class="<?=$visibility;?>" style="margin: 10px;">

                                            <h3 class="header blue lighter smaller clear">
                                                Meta
                                            </h3>

                                            <?php

                                            if (empty($data->nav_no_link)) { ?>

                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label no-padding-right" for="meta_titre_<?=$v;?>"> M&eacute;ta titre :</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="meta_titre_<?=$v;?>" name="meta_titre[]" value="<?= stripslashes($data->content[$v]->meta_titre);?>" class="form-control col-sm-12 texte_lang_<?= $v;?>">
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label no-padding-right" for="meta_key_<?=$v;?>"> M&eacute;ta mots cl&eacute;s :</label>
                                                    <div class="col-sm-4">
                                                        <textarea id="meta_key_<?=$v;?>" name="meta_key[]" class="form-control col-sm-12 texte_lang_<?= $v;?>"><?= stripslashes($data->content[$v]->meta_key);?></textarea>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label no-padding-right" for="meta_desc_<?=$v;?>"> M&eacute;ta description :</label>
                                                    <div class="col-sm-4">
                                                        <textarea id="meta_desc_<?=$v;?>" name="meta_desc[]" class="form-control col-sm-12 texte_lang_<?= $v;?>"><?= stripslashes($data->content[$v]->meta_desc);?></textarea>
                                                    </div>
                                                </div>

                                                <?php
                                            } ?>

                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="nav_title_<?=$v;?>"> Titre dans la navigation :</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="nav_title_<?=$v;?>" name="nav_title[]" value="<?= $data->content[$v]->nav_title;?>" class="form-control col-sm-12 texte_lang_<?= $v;?>">
                                                </div>
                                            </div>
                                            <div class="space-4"></div>
                                            <?php $visibility = (in_array($type, $options_disable['url']['type']) or in_array($data->id, $options_disable['url']['page'])) ? 'hidden' : null; ?>
                                            <div class="form-group <?=$visibility;?>">
                                                <label class="col-sm-2 control-label no-padding-right" for="nav_url_<?=$v;?>"> URL :</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="nav_url_<?=$v;?>" name="nav_url[]" value="<?= $data->content[$v]->nav_url;?>" class="form-control col-sm-12 texte_lang_<?= $v;?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- tab-pane -->
                                    <?php
                                }  ?>
                            </div><!-- tab-content -->
                        </div><!-- tabbable -->
                        <div style="clear:both;"></div>
                    </div><!-- col-sm-12 -->
                </div><!-- row -->
            </div>
        </div>
    </form>

    <script src="<?= HTTP;?>panel/js/fontawesome-iconpicker.js"></script>
    <script>
        $(function() {
			
            $('.action-create').on('click', function() {
                $('.icp-auto').iconpicker();
            }).trigger('click');
		
			$('.input-limiter').inputlimiter({
				limit: 100,
				remText: 'Vous pouvez encore utiliser %n caractère%s.',
				remFullText: 'Vous avez atteint le nombre maximum de caractère',
				limitText: '(%n caractères max)'
			});

        });
    </script>

    </div><!-- main_container -->