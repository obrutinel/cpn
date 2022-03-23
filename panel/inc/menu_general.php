<div class="sidebar" id="sidebar">
	<ul class="nav nav-list">
	
	<?php
	
		$file = basename($_SERVER["SCRIPT_FILENAME"], '.php');
		$navParent = (empty($data->parent)? $_GET['parent']:$data->parent);
		$navType = (empty($data->type)? $_GET['type']:$data->type);
		$navID = $data->id; 
		
	?>

		<li <?=(in_array($navType, array('home')) || in_array($navID, array(1)) || in_array($navParent, array(1,6,7))?'class="open"':'')?>>
			<a href="#" class="dropdown-toggle"><i class="fa fa-home"></i> <span class="menu-text">Accueil</span><b class="arrow icon-angle-down"></b></a>
			<ul class="submenu" <?=(in_array($navType, array('home')) || in_array($navID, array(1)) || in_array($navParent, array(1,6,7))?'style="display: block;"':'')?>>
				<?=pageLink(1, 'Accueil')?>
				<?=listLink(1, 'Slider', 'slide', 'picture-o')?>
				<?=pageLink(9, 'Bloc libre')?>
			</ul>
		</li>
		<?=pageLink(2, 'Qui sommes-nous')?>
        <li <?=(in_array($navType, array('list-secteur', 'sousbloc', 'bloc_1', 'bloc_2', 'bloc_3')) || $navID == 3 || $navParent == 3?'class="open"':'')?>>
            <a href="#" class="dropdown-toggle"><i class="fa fa-list"></i> <span class="menu-text">Secteurs d'activité</span><b class="arrow icon-angle-down"></b></a>
            <ul class="submenu" <?=(in_array($navType, array('list-news', 'sousbloc', 'bloc_1', 'bloc_2', 'bloc_3')) || $navID == 3 || $navParent == 3?'style="display: block;"':'')?>>
                <?=pageLink(3, 'Page')?>
                <?=listLink(3, 'Liste', 'secteur')?>
            </ul>
        </li>
        <li <?=(in_array($navType, array('list-reference', 'sousref', 'ref_1', 'ref_2')) || $navID == 4 || $navParent == 4?'class="open"':'')?>>
            <a href="#" class="dropdown-toggle"><i class="fa fa-list"></i> <span class="menu-text">Références</span><b class="arrow icon-angle-down"></b></a>
            <ul class="submenu" <?=(in_array($navType, array('list-news', 'sousref', 'ref_1', 'ref_2')) || $navID == 4 || $navParent == 4?'style="display: block;"':'')?>>
                <?=pageLink(4, 'Page')?>
                <?=listLink(4, 'Liste', 'reference')?>
            </ul>
        </li>
        <li <?=(in_array($navType, array('list-actualite')) || $navID == 5 || $navParent == 5?'class="open"':'')?>>
            <a href="#" class="dropdown-toggle"><i class="fa fa-newspaper-o"></i> <span class="menu-text">Actualités</span><b class="arrow icon-angle-down"></b></a>
            <ul class="submenu" <?=(in_array($navType, array('list-news')) || $navID == 5 || $navParent == 5?'style="display: block;"':'')?>>
                <?=pageLink(5, 'Page')?>
                <?=listLink(5, 'Liste', 'actualite')?>
            </ul>
        </li>
        <li <?=(in_array($navType, array('list-inscription')) || $navID == 6 || $navParent == 6?'class="open"':'')?>>
            <a href="#" class="dropdown-toggle"><i class="fa fa-edit"></i> <span class="menu-text">Contact</span><b class="arrow icon-angle-down"></b></a>
            <ul class="submenu" <?=(in_array($navType, array('list-inscription')) || $navID == 6 || $navParent == 6?'style="display: block;"':'')?>>
                <?=pageLink(6, 'Page')?>
                <?=listLink(6, 'Liste', 'demande-contact')?>
            </ul>
        </li>
        <?=listLink(70, 'Liste', 'logo')?>
		<li>&nbsp;</li>
		<?=pageLink(7, 'Mentions légales')?>
		<?=pageLink(8, 'Politique de conf.')?>
		<li>&nbsp;</li>
		<?=staticLink('general','Autres Informations', 'info-circle')?>

		<?php

		if ($_SESSION['wagaia_user']['login'] == 'wagaia') {
			echo '<li>&nbsp;</li>';
			echo staticLink('manager','Manager', 'cogs');
		}

		?>

		<li><a class="site" href="<?=HTTP;?>accueil" target="_blank"><i class="fa fa-globe"></i>Voir le site</a></li>
	</ul>
</div>