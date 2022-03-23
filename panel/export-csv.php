<?php

	header("Content-Type: text/plain");
	header("Content-disposition: attachment; filename=export-newsletter.csv");

	ini_set('memory_limit','512M');

	require_once('../vendor/autoload.php');
	require_once('inc/settings.php');


	if (!f_check_login()) {
		header("Location: login.php");
		exit;
	}


	
	$inscrits = $db->select("SELECT * FROM wagaia_newsletter");
	

	$out = fopen('PHP://output', 'w');
	
	foreach($inscrits as $inscrit):
		fputcsv($out, array(
			$inscrit->email
		));
	endforeach;
	
	fclose($out);
