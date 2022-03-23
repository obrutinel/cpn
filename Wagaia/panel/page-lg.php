<?php

	/*
	|---------------------------------------------
	| Traitemens sur mesure pour le site en cours sur la partie Edition PAGE / INFOS GLOBALES
	| Si pas nécessaire - laisser vide
	|---------------------------------------------
	*/

	// On développe les scénarios dont on a besoin

	if ($_POST) {
		
		if($type == 'step') {
			
			$db->query("UPDATE wagaia_pages SET pictos = NULL WHERE id = ".$_POST['id']);
			if(!empty($_POST['group_picto'])) {
				$strIds = implode(',', $_POST['group_picto']);
				$db->query("UPDATE wagaia_pages SET pictos = '".$strIds."' WHERE id = ".$_POST['id']);
			}
			
		}
		
		
		if(in_array($type, array('category', 'category-solution'))) {
			
			$sql = "UPDATE wagaia_pages SET color = '".$_POST['color']."' WHERE id = ".$_POST['id'];
			$db->query($sql);
		}


	}
	
	
	if($type == 'step') {
		
		$pictos = $db->select("SELECT * FROM wagaia_dico_picto");
		if(!empty($data->pictos)) {
			$tabIdsPicto = explode(',', $data->pictos);
		}
		
	}
	

?>

	<?php if($type == 'step') { ?>
		<div class="form-group">
			<div class="col-sm-12">
				<h3 class="header blue smaller">Pictos</h3>
				<div class="control-group">
					<?php foreach($pictos as $p) { ?>
						<div class="checkbox">
							<label>
								<input name="group_picto[]" type="checkbox" class="ace" <?=(in_array($p->id, $tabIdsPicto)?'checked="checked"':'')?> value="<?=$p->id?>">
								<span class="lbl"> <?=$p->libelle?></span>
							</label>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<?php if(in_array($type, array('category', 'category-solution'))) { ?>
	
		<div class="form-group">
			<div class="col-sm-12">
				<h3 class="header blue smaller"> Couleur</h3>
				<input type="text" id="color-picker" name="color" value="<?=$data->color?>" />
			</div>
		</div>
		<div class="space-4"></div>
		
		<div class="form-group">
			<div class="col-sm-12">
				<h3 class="header blue smaller"><i class="ace-icon fa fa-picture-o smaller-90"></i> Vignette</h3>
				<i>Taille min. : 375x225 pixels</i>
				<?=$image2?>
			</div>
		</div>
	<?php } ?>