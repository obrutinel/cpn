<?php

use Wagaia\Tables;

// Le type du parent
$parentType = $db->get(sprintf("select type, titre from ".Tables::$pages." where id=%d", $parent));

$sortie = null;
$has_list = array_key_exists($type, $options['has_list']['type']) ? true : false;
$has_slider = (in_array($parent, $options['has_slider']['parent']) or in_array($type, $options['has_slider']['type'])) ? true : false;


// Navigation pour les listes
include (ABSPATH.'panel/inc/plugins/page-list-nav.php');

if ($type && $type == 'slider' && $parentType) { ?>
	<h2>Photos pour <?=$parentType->titre;?></h2>
	<?php
}

if ($pages) { ?>

	<div id="AjaxResponse"></div>
	<input type="hidden" name="content_type" value="<?php echo $type;?>">
	<input type="hidden" name="content_id" value="<?=$parent?>">
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table <?= !in_array($type,$options_disable['sortable']) ? 'id="list_sortable"' : null;?> class="table dataTable table-striped table-bordered table-hover">
					<?php
					$custom_list = ABSPATH . 'Wagaia/panel/lists/'.$type.'.php';
					include(is_file($custom_list) ? $custom_list : 'list-loop.php');
					?>
				</table>
				
				<?php
				
				if($type == 'produit') {
					echo paginate($item_per_page, $page_number, $totalPages, $total_pages, 'pages.php?show=list&content_type=list&parent=37&type=produit');
				}
				
				?>
				
			</div><!-- /.table-responsive -->
		</div><!-- /span -->
	</div><!-- /row -->
	<?php

	foreach($data as $k=>$v) { ?>

		<div id="myModal<?= $v->id;?>" class="modal fade" tabindex="-1" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header no-padding">
						<div class="table-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="white">&times;</span>
							</button>
							Supprimer un enregistrement
						</div>
					</div>
					<div class="modal-body">
						<p><strong>Attention :</strong> toutes les pages directement liées à cet celle-ci (comme sous-catégories, produits) seront également supprimées.</p>
						<p>&Ecirc;tes-vous sur de vouloir supprimer cet enregistrement ?</p>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
						<a class="btn btn-primary" href="pages.php?act=delete_value&id=<?=$v->id.($parent ? '&parent='.$parent : null).($type ? '&type='.$type : null);?>">Supprimer</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

} else { ?>
	<div class="alert alert-warning">Aucun enregistrement</div>
	<?php
} ?>

</div>

