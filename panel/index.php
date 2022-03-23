<?php
require_once('../vendor/autoload.php');
include('inc/settings.php');

if(!f_check_login()) {
	header("Location: login.php");
} else {
	include('inc/header.php'); ?>
	<div id="content_news">
		<h2 id="content_header">Bienvenue dans votre espace personnel</h2>
		<br /><br />
	</div>
	<?php
	include('inc/footer.php');
}