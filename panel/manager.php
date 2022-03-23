<?php

require('../vendor/autoload.php');
require_once('inc/settings.php');

use Stringy\Stringy as S;
use Wagaia\Tables;

if(!$check = f_check_login()) {
	header("Location: login.php");
	exit;
}

$table = "wagaia_global";
$response = "Rien, rien... ça fait rien du tout !";
$case = null;

$db->transaction();


if (!empty($_POST)) {

	extract($_POST);

	switch($case) {

		case 'page' :

		$db->query("insert into ".Tables::$pages." (titre, type, is_nav, is_primary, parent, pull_children)
			values ('".$db->escape($titre)."','".S::create($type)->slugify()."',
			".(isset($is_nav) ? 1 : 'NULL') .",
			".(isset($is_primary) ? 1 : 'NULL') .",
			".(!empty($parent) ? $parent : 'NULL') .",
			".(isset($pull_children) ? 1 : 'NULL') .")");
		$page_id = $db->last_id();

		foreach($website_lg as $k=>$v) {
			$db->query("insert into ".Tables::$pages_data." (titre, lg, page_id, nav_url, nav_title) values ('".$db->escape($titre)."','".$v."','".$page_id."','".S::create($titre)->slugify()."','".$db->escape($titre)."')");
		}

		$response = "Nouvelle page créée. Id : <strong>" . $page_id."</strong>";
		break;

		case 'password' :
		$response = '';
		if (!empty($password)) {
			$db->query("update ".Tables::$admin." set passwd='".md5($password)."', passwd2='".$password."' where login='admin'");
			$response.= "Le mot de passe client a été modifié pour : <strong>" . $password."</strong><br>";
		}
		if (!empty($password_wagaia)) {
			$db->query("update ".Tables::$admin." set passwd='".md5($password_wagaia)."' where login='wagaia'");
			$response.= "Le mot de passe Wagaia a été modifié pour : <strong>" . $password_wagaia."</strong>";
		}


	}

}

if (isset($_GET['empty'])) {

	$db->query('SET FOREIGN_KEY_CHECKS=0;');
	$db->query('delete from '.Tables::$pages);
	$db->query('truncate table '.Tables::$pages);
	$db->query('truncate table '.Tables::$pages_data);
	$db->query('truncate table '.Tables::$global);
	$db->query('truncate table '.Tables::$social);
	$db->query('update '.Tables::$config ." set value='' where name='analytics'");

	/*if ($db->is_table('wagaia_newsletter')) {
		$db->query('truncate table wagaia_newsletter');
		$db->query('truncate table wagaia_newsletter_attach');
		$db->query('truncate table wagaia_newsletter_close');
		$db->query('truncate table wagaia_newsletter_erreur');
		$db->query('truncate table wagaia_newsletter_error');
		$db->query('truncate table wagaia_newsletter_image');
		$db->query('truncate table wagaia_newsletter_list');
		$db->query('truncate table wagaia_newsletter_nosent');
		$db->query('truncate table wagaia_newsletter_open');
		$db->query('truncate table wagaia_newsletter_open_links');
		$db->query('truncate table wagaia_newsletter_open_list');
		$db->query('truncate table wagaia_newsletter_per_list');
		$db->query('truncate table wagaia_newsletter_relance');
		$db->query('truncate table wagaia_newsletter_sent');
		$db->query('truncate table wagaia_newsletter_user');
	}*/
	$db->query('SET FOREIGN_KEY_CHECKS=1;');

	$response = 'Toutes les pages ont été effacées';
}

$db->commit();


require_once('inc/header.php');

function m($var=null)
{
	return 'manager.php?'.$var;
}
?>

<a class="btn btn-success" href="<?=m('page');?>"><i class="icon-ok bigger-110"></i>Nouvelle page</a>
<a class="btn btn-danger" role="button" data-toggle="modal" href="manager.php#myModal"><i class="icon-ok bigger-110"></i>Vider toutes les pages</a>
<a class="btn btn-warning" href="<?=m('password');?>"><i class="icon-ok bigger-110"></i>Mot de passe</a>

<form name="main_f" method="post" action="manager.php" enctype="multipart/form-data" autocomplete="off">
	<div class="tabbable">
		<div class="tab-content">
			<?php
			if ($_POST or isset($_GET['empty'])) { ?>
				<div class="alert alert-success"><?= $response;?></div>
				<?php
			} else { ?>
				<div class="col-offset-11 text-right">
					<button class="btn btn-success" type="submit"><i class="icon-ok bigger-110"></i>Enregistrer</button>
				</div><?php
			}

			if (isset($_GET['page'])) {
				$case ='page'; ?>
				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-10">
						<h3 class="header blue smaller">Nom de la page</h3>
						<input type="text" name="titre" class="form-control">
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-5">
						<h3 class="header blue smaller">Type</h3>
						<input type="text" name="type" class="form-control">
					</div>
					<div class="col-sm-5">
						<h3 class="header blue smaller">Parent</h3>
						<input type="text" name="parent" class="form-control" placeholder="NULL | int">
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-10">
						<h3 class="header blue smaller">Navigation</h3>
						<div class="col-sm-2">
							<input type="checkbox" name="is_nav"> Dans la navigation
						</div>
						<div class="col-sm-2">
							<input type="checkbox" name="is_primary"> Dans le menu principal
						</div>
						<div class="col-sm-2">
							<input type="checkbox" name="pull_children"> Afficher le sous-menu
						</div>
					</div>
				</div><?php
			}

			if (isset($_GET['password'])) {
				$case = 'password'; ?>

				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-10">
						<h3 class="header blue smaller">Mot de passe client</h3>
						<input type="text" name="password" class="form-control">
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-10">
						<h3 class="header blue smaller">Mot de passe Wagaia</h3>
						<input type="text" name="password_wagaia" class="form-control">
					</div>
				</div><?php
			} ?>
		</div>
		<input type="hidden" name='case' value="<?=$case;?>"/>
	</form>
	<div id="myModal" class="modal fade" tabindex="-1" >
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
					<p style="font-size:18px;"><strong>Attention :</strong> toutes les pages du site seront remises à zéro !</p>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
					<a class="btn btn-danger" href="<?=m('empty');?>">J'y vais, je l'explose !</a>
				</div>
			</div>
		</div>
	</div>
	<?php require_once('inc/footer.php'); ?>