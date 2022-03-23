<thead>
	<tr>
		<!--<th>#</th>-->
		<?php
		$th = false;
		if (array_key_exists($type, $jcrop_config)) {
			$th = true; ?>
			<th></th>
			<?php
		} ?>
		<th>Titre</th>
		<?php
		if ($has_list) { ?>
			<th><?= $options['has_list']['type'][$type]['title'];?></th>
			<?php
		} ?>
		<th>Action</th>
	</tr>
</thead>

<tbody>

	<?php
	
	foreach($data as $k=>$v) { ?>

		<tr>
			<!--<td style="width:40px;"><?=$v->id;?></td>-->
			<?php
			if ($th) { ?>
				<td style="width:60px;">
					<?= is_file(IMG_FOLDER .$v->image) ?  '<img src="'.IMG_URL .'thumbs/'.$v->image.'" style="width:50px;" />' : null ?>
				</td>
				<?php
			} ?>
			<td><input type="hidden" name='order[<?php echo $v->id;?>]' class="order" value=""><?= empty($v->titre) ? '{ Sans titre }' : $v->titre; ?> - <?=$v->position;?></td>

			<?php
			if ($has_list) { ?>
				<td><?=$v->contains;?> </td>
				<?php
			} ?>
			<td style="width:220px;" class="nowrap">
				<div class="action-buttons">
					<a title="Modifier la page <?php echo  $v->titre; ?>" data-toggle="tooltip" href="pages.php?show=edit&id=<?php echo $v->id;?>" class="btn btn-xs btn-info"><i class="icon-pencil bigger-120"></i></a>
					<?php
					if ($has_list) { ?>
						<a title="<?= $options['has_list']['type'][$type]['title'] .' pour '. $v->titre;?>" data-placement="top" data-toggle="tooltip" href="pages.php?show=list&parent=<?php echo $v->id;?>&type=<?=$options['has_list']['type'][$type]['name'];?>" class="btn btn-xs btn-success"><i class="fa fa-th-large bigger-120"></i></a>
						<?php
					}

					if ($has_slider) { ?>
					
						<a title="Galerie photos <?php echo $v->titre;?>" data-placement="top" data-toggle="tooltip" href="pages.php?show=list&parent=<?php echo $v->id;?>&type=<?=$typeSlider?>" class="btn btn-xs btn-success"><i class="icon-picture bigger-120"></i></a>
						<?php
					} ?>

                    <?php if($v->parent != 47) { ?>
					    <a title="Supprimer la page <?= $v->titre; ?>" data-placement="top" rel="tooltip" href="#" role="button" data-target="#myModal<?php echo $v->id;?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="icon-trash bigger-120"></i></a>
                    <?php } ?>
				</div>
			</td>
		</tr>

		<?php
	} ?>
</tbody>