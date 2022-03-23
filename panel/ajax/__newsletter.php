<?php

	require_once('../../vendor/autoload.php');

	use Wagaia\Tables;
	use Wagaia\Lib;

	echo 'ok';

	if(!empty($_POST)) {
		$db->query("INSERT INTO wagaia_newsletter_user (mail, created_at) VALUES ('".$db->escape($_POST['email'])."', NOW())");
	}


/*
$db->transaction();

extract($_POST);

$json_response = [];

switch($_POST['content_type']) {

	case 'equipe':
		foreach($_POST['order'] as $k=>$v) {
			$db->query("update wagaia_equipe set position='".$v."' where id='".$k."'");
		}
		break;

	case 'sticky' :
		if (!empty($_POST['order'])) {
			foreach($_POST['order'] as $k=>$v) {
				$db->query("update ".Tables::$sticky." set position='".$v."' where id='".$k."'");
			}
		}
		$json_response = ["Stickies updated"];
		break;
		
	case 'produit':
		foreach($_POST['order'] as $k=>$v) {
			$db->query("UPDATE wagaia_produit SET position_theme_{$_POST['content_id']} = '".$v."' WHERE ids_theme LIKE '%".$_POST['content_id']."%' AND id = '".$k."'");
		}
		break;		

	default :

	if (!empty($_POST['order'])) {
		
		if($_POST['content_type'] == 'subpage') {
			
			foreach($_POST['order'] as $k=>$v) {
				$db->query("update ".Tables::$pages." set position='".$v."' where id='".$k."'");
			}
			
		}
		else {
		
			foreach($_POST['order'] as $k=>$v) {
				$db->query("update ".Tables::$pages." set position='".$v."' where id='".$k."' and type='".$_POST['content_type']."'");
			}
		}
	}
}
$db->commit();

Lib::json($json_response);*/