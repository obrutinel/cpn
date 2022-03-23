<?php

ini_set('memory_limit','512M');

require_once('../vendor/autoload.php');
require_once('inc/settings.php');

use Wagaia\Tables;
use Wagaia\Lib;

if (!f_check_login()) {
	header("Location: login.php");
	exit;
}

$table = Tables::$pages;

include (ABSPATH.'panel/inc/vars.php');

if ($identifiant) {

	$data = $db->get(sprintf("SELECT * FROM ".$table." WHERE id=%d", $identifiant));

	if (!$data) {
		$log->abort()->alert();

	} else {
		$data->content = $db->select("SELECT * FROM ".Tables::$pages_data." WHERE page_id='".$identifiant."'", 'lg');

			// Le type du parent
		$data->parentType = !empty($data->parent) ? $db->get(sprintf("select type, titre from ".$table." where id=%d", $data->parent)): null;

		if (!$type) {
			$type = $data->type;
		}

		if (!$parent) {
			$parent = $data->parent;
		}
	}
}

/*
|---------------------------------------------
| INSTANCIER JCROP (si besoin)
|---------------------------------------------
| ./Wagaia/config-website.php - $jcrop
*/
$jcrop = jcrop();

require_once('inc/pages/post_functions.php');
require_once('inc/pages/get_functions.php');
require_once('inc/pages/actions.php');
require_once('inc/header.php');
	

/*
|---------------------------------------------
| LISTE DE PAGES
|---------------------------------------------
*/
$add_to_list = false;

if (!$identifiant) {

	$add_to_list = true;
	$typeSlider = 'slider';
	
	//if($parent == 23) $add_to_list = false;
	
	// PAGINATION (uniquement pour Produit)
	/*if($type == 'produit') {
		
		$item_per_page = 15;
				
		if(isset($_GET["page"])) {
			$page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			if(!is_numeric($page_number)){ die('Invalid page number!'); }
		} else {
			$page_number = 1;
		}
		
		$page_position = (($page_number-1) * $item_per_page);
		
		$addLimitSql = " LIMIT ".$page_position.", ".$item_per_page;
	}*/



	    /*$q = "SELECT b.titre, b.sous_titre, b.intro, a.id, a.date, a.image, a.parent
	            FROM wagaia_pages a 
	            LEFT JOIN wagaia_pages_data b ON a.id = b.page_id
	            WHERE type IN('bloc_1', 'bloc_2', 'bloc_3') AND parent = ".$_GET['parent'];*/



    // Récupération du type parent
    // Qui permet d'avoir un type différent pour le slider
    $elemParent = $db->get("SELECT * FROM " . $table . " WHERE type = '" . $type . "'");
    if (!empty($elemParent)) {
        $typeSlider = $elemParent->type . '-slider';
    }

    $q = "SELECT b.titre, b.sous_titre, b.intro, a.id, a.date, a.image, a.parent, a.position ";
    if ($type && array_key_exists($type, $options['has_list']['type'])) {

        $q .= ",
    (SELECT count(c.id) from " . $table . " c where type='" . $options['has_list']['type'][$type]['name'] . "' and parent=a.id)  as contains,
    @ids:=(SELECT CONCAT_WS(',', a.id, GROUP_CONCAT(c.id)) as ids from " . $table . " c where type='" . $options['has_list']['type'][$type]['name'] . "' and parent=a.id) as ids";
    }

    if($type == 'sousbloc') {
        $addSQl = "AND type IN('bloc_1', 'bloc_2', 'bloc_3')";
        $q .= " FROM " . $table . " a join " . Tables::$pages_data . " b on a.id=b.page_id where a.parent='" . $parent . "' and b.lg='" . LOCALE . "'" .$addSQl. " ORDER BY ";
    }
    elseif($type == 'sousref') {
        $addSQl = "AND type IN('ref_1', 'ref_2', 'ref_3')";
        $q .= " FROM " . $table . " a join " . Tables::$pages_data . " b on a.id=b.page_id where a.parent='" . $parent . "' and b.lg='" . LOCALE . "'" .$addSQl. " ORDER BY ";
    }
    else {
        $q .= " FROM " . $table . " a join " . Tables::$pages_data . " b on a.id=b.page_id where a.parent='" . $parent . "' and b.lg='" . LOCALE . "'" . ($type ? ' and a.type="' . $type . '"' . $addSql : null) . " ORDER BY ";
    }


    $q .= ($type && array_key_exists($type, $order_by)) ? $order_by[$type] : 'position';
	 
	//if($type == 'sousref_1') $q .= ' DESC';


    echo $q .= $addLimitSql;

	
	$data = $db->select($q);
	
	
	$pages = count($data);
	
	//if($type == 'produit') $total_pages = ceil($totalPages/$item_per_page);
	
	
	// Si on a atteint le nombre max, on cache le bouton "Ajouter"
	if(($type && array_key_exists($type, $type_limit) && $type_limit[$type] <= $pages)) $add_to_list = false;
	
	// Si le bouton "Ajouter" est désactivé
	if(in_array($type, $options_disable['btn_ajouter_un_enregistrement']['type'])) 		 $add_to_list = false;
	if(in_array($data->id, $options_disable['btn_ajouter_un_enregistrement']['page'])) 	 $add_to_list = false;
	if(in_array($_GET['parent'], $options_disable['btn_ajouter_un_enregistrement']['parent'])) $add_to_list = false;

	/*if (($type && array_key_exists($type, $type_limit) && $type_limit[$type] >= $pages) || in_array($type, $options_disable['btn_ajouter_un_enregistrement']['type']) || in_array($data->id, $options_disable['btn_ajouter_un_enregistrement']['page'])) {
		$add_to_list = false;
	}*/
	
}


if ($parent && $add_to_list) { ?>

    <?php if($type == 'sousbloc' && $_GET['act'] != 'add') { ?>

        <div class="pull-right">
            <a class="btn btn-info" href="pages.php?act=add<?php echo ($parent ? '&parent='.$parent : null).($type ? "&type=". $type : null);?>">
                <i class="icon-plus bigger-110"></i>Ajouter un enregistrement
            </a>
            <div class="space-4"></div>
        </div>

    <?php } elseif($type == 'sousref' && $_GET['act'] != 'add_ref') { ?>

            <div class="pull-right">
                <a class="btn btn-info" href="pages.php?act=add_ref<?php echo ($parent ? '&parent='.$parent : null).($type ? "&type=". $type : null);?>">
                    <i class="icon-plus bigger-110"></i>Ajouter un enregistrement
                </a>
                <div class="space-4"></div>
            </div>

    <?php } elseif($_GET['act'] != 'add' && $_GET['act'] != 'add_ref') { ?>

        <div class="pull-right">
            <a class="btn btn-info" href="pages.php?act=add_value&show=edit<?php echo ($parent ? '&parent='.$parent : null).($type ? "&type=". $type : null);?>">
                <i class="icon-plus bigger-110"></i>Ajouter un enregistrement
            </a>
            <div class="space-4"></div>
        </div>

    <?php } ?>

	<?php } else echo '<br /><br />';

	$log->alert();

	if($_GET['act'] == 'add') include_once('inc/pages/add.php');
	elseif($_GET['act'] == 'add_ref') include_once('inc/pages/add_ref.php');
	else include_once('inc/pages/' . ($identifiant ? 'edit' : 'list').'.php');

	require_once('inc/pages/footer.php');
	require_once('inc/footer.php');