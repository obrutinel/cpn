<?php
	require('vendor/autoload.php');
	require('Wagaia/config/queries.php');
?>

<!DOCTYPE html>
<html lang="fr-FR">

	<head>

		<title><?=$meta->title?> - <?=$site_name?></title>
		<meta name="description" content="<?=$meta->desc?>"/>
		<meta name="keywords" content="<?=$meta->keys?>"/>
		<link rel="shortcut icon" href="<?=ASSETS?>img/favicon.png">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="<?=ASSETS?>css/bootstrap.min.css">
		<!--<link rel="stylesheet" href="<?=ASSETS?>css/font-awesome.min.css">-->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Playfair+Display:400,700,900,900i|Poppins:400,500,600,800|Roboto:400,500,700,900">
		<link rel="stylesheet" href="<?=ASSETS?>css/animate.min.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/cubeportfolio.min.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/jquery.fancybox.min.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/settings.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/style.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/blue.css">
		<link rel="stylesheet" href="<?=ASSETS?>css/custom.css">

	</head>

	<body class="<?=$data->type?>">
	
		<a href="javascript:void(0)" class="scrollToTop"><i class="fa fa-angle-up"></i></a>

		<div class="loader">
			<div class="spinner centered">
				<div class="spinner-container container1">
					<div class="circle1"></div>
					<div class="circle2"></div>
					<div class="circle3"></div>
					<div class="circle4"></div>
				</div>
				<div class="spinner-container container2">
					<div class="circle1"></div>
					<div class="circle2"></div>
					<div class="circle3"></div>
					<div class="circle4"></div>
				</div>
			</div>
		</div>
		
		<header class="site-header">
			<div class="top-header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-2 logo-col">
							<a class="navbar-brand fixedlogo" href="<?=HTTP?>">
							<img src="<?=ASSETS?>img/logo-blank.jpg" alt="logo" class="logo-scrolled">
							</a>
						</div>
						<div class="col-md-6 offset-md-0 col-lg-6 offset-lg-0 border-bt-blue txt-top-header">
							<p><?=info('baseline')?></p>
						</div>
						<div class="col-7 offset-5 col-md-5 col-md-55 offset-md-0 col-lg-4 offset-lg-0 border-bt-blue right-th">
							<p>
                                <?php if(!empty(info('phone'))) { ?>
                                    <a href="tel:<?=info('phone')?>">
                                        <i class="fa fa-phone" aria-hidden="true"></i> <?=info('phone')?>
                                    </a>
                                <?php } ?>
                                <?php if(!empty(info('email'))) { ?>
                                    <a href="mailto:<?=info('email')?>"><i class="fa fa-envelope" aria-hidden="true"></i> <?=info('email')?></a>
                                <?php } ?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<nav class="navbar topmenu navbar-expand-lg transparent-bg fixedmenu">
				<div class="container-fluid">
				
					<button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#wenav">
						<span> </span>
						<span> </span>
						<span> </span>
					</button>
					
					<div class="collapse navbar-collapse" id="wenav">
						<ul class="navbar-nav mx-auto">
						
							<li class="nav-item static active">
								<a class="nav-link" href="<?=HTTP?>"> <i class="fa fa-home" aria-hidden="true"></i> </a>
							</li>
                            <?php foreach($menu as $nav) { ?>
                                <?php if($nav->children) { ?>
                                    <li class="nav-item dropdown<?=($nav->page_id == $data->id || $data->parent == $nav->page_id?' active':'')?>">
                                        <a href="<?=HTTP.$nav->nav_url?>" class="nav-link dropdown-toggle_ <?=(!empty($nav->children)?'has_children':'')?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$nav->nav_title?></a>
                                        <div class="dropdown-menu primary">
                                            <?php foreach($nav->children as $child) {  ?>
                                                <a class="dropdown-item" href="<?=HTTP.$child->nav_url?>"><?=$child->nav_title?></a>
                                            <?php } ?>
                                        </div>
                                    </li>
                                <?php } else { ?>
                                    <li class="nav-item<?=($nav->page_id == $data->id?' active':'')?>">
                                        <a href="<?=HTTP.$nav->nav_url?>" class="nav-link"><?=$nav->nav_title?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
						</ul>
					</div>
					
				</div>
			</nav>
		</header>

        <?php $log->error ? $log->alert() : include(ABSPATH.'Wagaia/views/'.$view.'.php'); ?>
		
		<footer>
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-12 border-top-blue">
						<div class="footer-shadow"></div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row padding-top">
				
					<div class="col-md-4 col-sm-12 footer_panel heading_space wow fadeIn" data-wow-delay="300ms">
						<h3 class="heading bottom30">À propos de nous<span class="divider-left"></span></h3>
						<?php if(!empty(info('texte'))) { ?>
							<p class="logo-txt cpn-footer">
								<a href="#" class="footer_logo">
									<img src="<?=ASSETS?>img/logo-footer-1.png" alt="" class="cpn-footer">
								</a>
								<span><?=info('texte')?></span>
							</p>
						<?php } ?>
						<?php if(!empty(info('texte2'))) { ?>
							<p class="logo-txt">
								<a href="https://www.retailplace.eu/" class="footer_logo" target="_blank">
									<img src="<?=ASSETS?>img/logo-footer-2.png" alt="">
								</a>
								<span><?=info('texte2')?></span>
							</p>
						<?php } ?>
					</div>
					
					<div class="col-md-4 col-sm-12 footer_panel heading_space wow fadeIn" data-wow-delay="350ms">
						<h3 class="heading bottom30">Navigation<span class="divider-left"></span></h3>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<ul class="links">
									<li><?=getLink(2)?></li>
									<li><?=getLink(3)?></li>
									<li><?=getLink(4)?></li>
									<li><?=getLink(5)?></li>
									<li><?=getLink(6)?></li>
									<li><?=getLink(7)?></li>
									<li><?=getLink(8)?></li>
							</div>
						</div>
					</div>
					
					<div class="col-md-4 col-sm-12 footer_panel heading_space wow fadeIn" data-wow-delay="400ms">
						<h3 class="heading bottom30">Contact <span class="divider-left"></span></h3>
						

						<?php if(!empty(info('adresse'))) { ?>
							<p class="address"><i class="fa fa-map-marker"></i><?=info('adresse')?></p>
						<?php } ?>
						<?php if(!empty(info('phone'))) { ?>
							<p class="address">
								<i class="fa fa-phone"></i>
								<a href="tel:<?=info('phone')?>">
									<?=info('phone')?>
								</a>
							</p>
						<?php } ?>
						<?php if(!empty(info('email'))) { ?>
							<p class="address">
								<i class="fa fa-envelope-o"></i>
								<a href="mailto:<?=info('email')?>"><?=info('email')?></a>
							</p>
						<?php } ?>

						<ul class="social_icon top25">
							<?php if(!empty($data->social['facebook']->url)) { ?>
								<li><a href="<?=$data->social['facebook']->url?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<?php } ?>
							<?php if(!empty($data->social['twitter']->url)) { ?>
								<li><a href="<?=$data->social['twitter']->url?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<?php } ?>
							<?php if(!empty($data->social['instagram']->url)) { ?>
								<li><a href="<?=$data->social['instagram']->url?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
							<?php } ?>
							<?php if(!empty($data->social['linkedin']->url)) { ?>
								<li><a href="<?=$data->social['linkedin']->url?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
							<?php } ?>
						</ul>
					</div>
					
				</div>
			</div>
		</footer>
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<p>Copyright &copy; <?=date('Y')?> CPN</p>
					</div>
					<div class="col-md-6 text-right">
						<p><a href="https://www.wagaia.com/" target="_blank">
							<img src="https://www.wagaia.com/wagaia-creation-site-marseille.png" alt="Création site internet Marseille - Wagaia" title="Création site internet Marseille - Wagaia">
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>


		<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="<?=ASSETS?>js/popper.min.js"></script>
		<script src="<?=ASSETS?>js/bootstrap.min.js"></script>

		<script src="<?=ASSETS?>js/jquery.appear.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.1/metisMenu.min.js"></script>

		<script src="<?=ASSETS?>js/jquery.matchHeight-min.js"></script>
		<script src="<?=ASSETS?>js/owl.carousel.min.js"></script>
		<script src="<?=ASSETS?>js/jquery-countTo.js"></script>
		<script src="<?=ASSETS?>js/parallaxie.js"></script>
		<script src="<?=ASSETS?>js/jquery.cubeportfolio.min.js"></script>
		<script src="<?=ASSETS?>js/jquery.fancybox.min.js"></script>
		<script src="<?=ASSETS?>js/morphext.min.js"></script>
		<script src="<?=ASSETS?>js/particles.min.js"></script>
		<script src="<?=ASSETS?>js/wow.min.js"></script>

		<script src="<?=ASSETS?>js/revolution/jquery.themepunch.tools.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/jquery.themepunch.revolution.min.js"></script>

		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.actions.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.carousel.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.kenburn.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.layeranimation.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.migration.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.navigation.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.parallax.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.slideanims.min.js"></script>
		<script src="<?=ASSETS?>js/revolution/extensions/revolution.extension.video.min.js"></script>
		<script src="<?=ASSETS?>js/functions.js"></script>
		<script src="<?=ASSETS?>js/custom.js"></script>

        <?php if(!empty($data->config['analytics']->value)) : ?>
            <?=$data->config['analytics']->value?>
        <?php endif; ?>

        <script src="//www.google.com/recaptcha/api.js" async defer></script>

    </body>

</html>