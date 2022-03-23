<?php

require('../vendor/autoload.php');
require_once('inc/settings.php');

use Wagaia\Tables;
use Wagaia\Lib;
use Wagaia\Lang;

if(!f_check_login()) {
	header("Location: login.php");
	exit;
}

if (!empty($_POST)) {

	$db->transaction();
	foreach($website_lg as $k=>$v) {

		# INFORMATIONS GLOBALES
		if (isset($global_info)) {
			foreach($global_info as $key=>$value) {
				$db->query("update ".Tables::$global." set value='".$db->escape($_POST[$key][$k])."' where lg='".$v."' and name='".$key."'");
			}
		}
		# RESEAUX SOCIAUX
		if (isset($social_networks)) {
			foreach($social_networks as $n) {
				$db->query("update ".Tables::$social." set url='".$db->escape($_POST[$n][$k])."' where lg='".$v."' and name='".$n."'");
			}
		}
	}
	# GOOGLE ANALYTICS
	$db->query("update " . Tables::$config ." set value='".$db->escape($_POST['analytics'])."' where name='analytics'");
//	$db->query("update " . Tables::$config ." set value='".$db->escape(htmlspecialchars($_POST['analytics']))."' where name='analytics'");

	$db->commit();
}

$data = new stdClass;

// Gestion automatisée des Informations globales
if (isset($global_info)) {
	foreach($website_lg as $k=>$v) {
		$db->transaction();
		foreach($global_info as $key=>$val) {
			if(!$db->get("select count(*) as total from ".Tables::$global ." where name='".$key."' and lg='".$v."'")->total) {
				$db->query("insert into ".Tables::$global ." (name, lg, libelle) values('".$key."', '".$v."', '".$val."') ");
			}
		}
		$db->commit();
	}
	$data->global = $db->select("SELECT * from ".Tables::$global ." order by position");
}



	// Gestion automatisée des liens Réseaux sociaux
if (isset($social_networks)) {
	foreach($website_lg as $k=>$v) {
		$db->transaction();
		foreach($social_networks as $n) {
			if(!$db->get("select count(*) as total from ".Tables::$social ." where name='".$n."' and lg='".$v."'")->total) {
				$db->query("insert into ".Tables::$social ." (name, lg) values('".$n."', '".$v."') ");
			}
		}
		$db->commit();
	}
	$data->social = $db->select("SELECT * from ".Tables::$social ." order by name");
}

require_once('inc/header.php');

?>

<div class="page-header">


	<div style="float:left; width:600px">
		<h1><?php echo $site_name;?>
			<small>
				>> Informations générales
			</small>
		</h1>
	</div>

	<div style="width:1000px; padding:0; margin:0; height:40px"></div>

</div>
<form name="main_f" method="post" action="general.php" enctype="multipart/form-data" autocomplete="off">
	<div class="tabbable">
		<?= language_tabs(); ?>
		<div class="tab-content">
			<button class="btn btn-danger pull-right" name="s2" type="submit"><i class="icon-ok bigger-110"></i>Enregistrer</button>
			<?php
			foreach($website_lg as $k=>$v) { ?>
				<div class="tab-pane fade <?=  $v==LOCALE ? 'active in': null;?>" id="lang_<?= $v;?>">
					<input name='lg[]' type="hidden" value="<?php echo $v;?>">
					<?php

					// dump($global_info);
					if (isset($global_info)) {
						$global = array_filter($data->global, function($val) use ($v) { return $val->lg == $v; });
						//dump($global);
						foreach($global_info as $key=>$value) {
							$titre = $value;
							$name = $key;
							$value = current(array_filter($global, function($val) use ($key) { return $val->name == $key; }))->value;
							?>
							<div class="space-4"></div>
							<div class="form-group">
								<div class="col-sm-10">
									<h3 class="header blue smaller"><?= trans($titre);?></h3>
									<?php
									if(strstr($name, 'text')) { ?>
										<textarea rows="5" name="<?=$name;?>[]" class="form-control col-sm-11 texte_lang_<?= $key;?>"><?= $value;?></textarea>
										<?php
									} else { ?>
										<input type="text" name="<?=$name;?>[]" class="form-control col-sm-11 texte_lang_<?= $key;?>" value="<?= $value;?>">
										<?php
									} ?>
								</div>
							</div>
							<?php
						}
					}

					if (!empty($social_networks)) { ?>
						<div class="space-4"></div>
						<div class="form-group">
							<div class="col-sm-10">
								<h3 class="header blue lighter smaller">
									<i class="ace-icon fa fa-share-alt smaller-90"></i> Réseaux sociaux
								</h3>
								<?php
								$social = array_filter($data->social, function($val) use ($v) {
									return $val->lg == $v;
								});

								foreach($social as $s) { ?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="<?=$s->name.'_'.$v;?>"> <?= ucfirst($s->name);?></label>
										<div class="col-sm-10"><input type="text" id="<?=$s->name.'_'.$v;?>" name="<?=$s->name;?>[]" value="<?= $s->url;?>" class="col-sm-12 form-control"></div>
									</div><?php
								} ?>
							</div>
						</div>
						<?php
					} ?>
				</div>
				<?php
			} ?>

			<?php include(ABSPATH . 'Wagaia/panel/general.php');

			# GOOGLE ANALYTICS
			$analytics = $db->get("select value from ".Tables::$config ." where name='analytics'")->value;

			?>

			<div class="space-4"></div>
			<div class="form-group">
				<div class="col-sm-10">
					<h3 class="header blue lighter smaller">
					<i class="ace-icon fa fa-line-chart smaller-90"></i> Google Analytics
					</h3>
					<textarea rows="5" name="analytics" class="form-control col-sm-11"><?=$analytics;?></textarea>
				</div>
			</div>
		</div>
	</div>
</form>

<?php require_once('inc/footer.php');?>