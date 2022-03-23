<?php use Wagaia\Lang; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<base href="<?=HTTP?>panel/"/>
	<meta charset="utf-8" />
	<title>Panel d'adminstration - CPN</title>
	<meta name="description" content="Dynamic tables and grids using jqGrid plugin" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- basic styles -->
	<!-- page specific plugin styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.full.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
	<!--<link rel="stylesheet" href="assets/css/datepicker.css" />-->
	<link rel="stylesheet" href="assets/css/ui.jqgrid.css" />
	<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
	<link rel="stylesheet" href="assets/css/chosen.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="assets/css/daterangepicker.css" />
	<link rel="stylesheet" href="assets/css/colorpicker.css" />
	<link rel="stylesheet" href="assets/css/colorbox.css" />
	<link rel="stylesheet" href="assets/css/jquery.gritter.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
	<!--<link rel="stylesheet" href="assets/css/select2.css" />-->

	<link rel="stylesheet" href="assets/css/ace-fonts.css" />
	<link rel="stylesheet" href="assets/css/ace.min.css" />
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
	<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="assets/css/panel.css" />
	<!-- ace settings handler -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.js"></script>
	<script src="assets/js/ace-extra.min.js"></script>
	<script src="js/functions.js"></script>
	<script src="assets/js/ace-elements.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/fr.js"></script>
	<!--<script src="assets/js/select2.min.js"></script>-->
	<script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
	<script src="assets/js/ace.min.js"></script>
		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		  <![endif]-->
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		  <![endif]-->
		  <!-- inline styles related to this page -->
		  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<!-- basic scripts -->
		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->
		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/typeahead-bs2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.fr.min.js"></script>
<!--<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/locales/bootstrap-datepicker.fr.js"></script>-->
<!--<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>
<script src="assets/js/jquery.colorbox-min.js"></script>
<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/jquery.color.js" type="text/javascript"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>
<script src="assets/js/flot/jquery.flot.min.js"></script>
<script src="assets/js/flot/jquery.flot.pie.min.js"></script>
<script src="assets/js/flot/jquery.flot.resize.min.js"></script>
<script src="assets/js/bootstrap-tag.min.js"></script>
<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/markdown/markdown.min.js"></script>
<script src="assets/js/markdown/bootstrap-markdown.min.js"></script>
<script src="assets/js/jquery.hotkeys.min.js"></script>
<script src="assets/js/jquery.gritter.min.js"></script>
<script src="assets/js/bootstrap-wysiwyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>
<script src="js/jquery.Jcrop.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/vader/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="js/jquery.Jcrop.css" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo HTTP;?>panel/css/fontawesome-iconpicker.min.css" type="text/html">
<link href="<?php echo HTTP;?>Wagaia/panel/panel.css" rel="stylesheet">
<script type="text/javascript">
	function showCoords(c)
	{
		jQuery('#x1').val(c.x);
		jQuery('#y1').val(c.y);
		jQuery('#w').val(c.w);
		jQuery('#h').val(c.h);
	};
</script>
</head>
<body>
	<div class="navbar navbar-default" id="navbar">
		<script type="text/javascript">
			try{ace.settings.check('navbar' , 'fixed')}catch(e){}
		</script>
		<div class="navbar-container" id="navbar-container">
			<div class="navbar-header pull-left">
				<a href="index.php" class="navbar-brand">
					<small>
						<i class="icon-leaf"></i>
						ADMIN - CPN
					</small>
				</a><!-- /.brand -->
			</div><!-- /.navbar-header -->
			<div class="navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<li class="light-blue">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="assets/avatars/avatar5.png" alt="Jason's Photo" />
							<span class="user-info">
								<small>Bienvenue,</small>
								<?php echo $_SESSION['wagaia_user']['nom']?>
							</span>
							<i class="icon-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="logout.php">
									<i class="icon-off"></i>
									D&eacute;connexion
								</a>
							</li>
						</ul>
					</li>
				</ul><!-- /.ace-nav -->
			</div><!-- /.navbar-header -->
		</div><!-- /.container -->
	</div>
	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>
		<div class="main-container-inner">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
			<?php include(ABSPATH.'panel/inc/menu_general.php'); ?>
			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<script type="text/javascript">
						try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
					</script>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="index.php">Accueil</a>
						</li>
						<li>
							CPN
						</li>
					</ul><!-- .breadcrumb -->
				</div>
				<div class="page-content">