<?php

use Wagaia\Tables;
use Wagaia\Lib;

$Wagaia->reset();

/*
|---------------------------------------------
| ANALYSE DE L'URL
|---------------------------------------------
*/

$url = $Wagaia->request();
$u = urldecode($url['last']);
$lg = (in_array($url['first'], $website_lg)) ? $url['first'] : 'fr';
if($u == 'tradiqual') $u = '';

/*
|---------------------------------------------
| PAGINATION
|---------------------------------------------
*/

// MAIL ADMIN (pour toute les notifications)
//$dataG = $db->get("SELECT * FROM wagaia_global WHERE lg = '".$lg."' AND name = 'email_notif'");
//if(!empty($dataG)) define('MAIL_ADMIN', $dataG->value);
//else define('MAIL_ADMIN', 'obrutinel@wagaia.com');

/*
|---------------------------------------------
| TROUVER LA BONNE PAGE
|---------------------------------------------
*/
$current_page = 1;
if(Lib::digital($u)) {
	$current_page = $u;
	array_pop($url['explode']);
	$u = urldecode(end($url['explode']));
}

$sql = "SELECT a.image, a.image2, a.color, a.type, a.parent, a.date, b.* FROM ".Tables::$pages." a 
			LEFT JOIN ".Tables::$pages_data." b ON a.id = b.page_id 
			WHERE ".($u !='index.php' && !empty($u) && $u!= $lg ? "b.nav_url='".$u."'" : 'a.type = "home"'). " AND IFNULL(a.temp, 0) = 0 AND b.lg = '".$lg."'";
$data = $db->get($sql);


if($data) {

	switch($data->type) {

		case 'home' :
		
			$is_home = true;
			
			$data->slider = $Wagaia->getByType('slide', 1)->list;
			$data->bloc = $Wagaia->getPage(9);

			$data->bloc_secteur = $Wagaia->getPage(3);
            $data->secteurs = $Wagaia->getByType('secteur')->list;

			$data->bloc_reference = $Wagaia->getPage(4);

            $data->logo = $Wagaia->getPage(70);
            $data->logos = $Wagaia->getByType('logo')->list;

		break;

        case 'list-secteur' :

            $data->secteurs = $Wagaia->getByType('secteur')->list;

        break;

        case 'secteur' :

            $data->bloc_1 = $Wagaia->getByType('bloc_1', $data->id)->list;
            if(!empty($data->bloc_1)) $data->bloc_1_list = $Wagaia->getByType('sousbloc_1', $data->bloc_1[0]->id)->list;

            $data->bloc_2 = $Wagaia->getByType('bloc_2', $data->id)->list;
            if(!empty($data->bloc_2)) $data->bloc_2_list = $Wagaia->getByType('sousbloc_2', $data->bloc_2[0]->id)->list;

            $data->bloc_3 = $Wagaia->getByType('bloc_3', $data->id)->list;
            if(!empty($data->bloc_3)) $data->bloc_3_list = $Wagaia->getByType('sousbloc_3', $data->bloc_3[0]->id)->list;

            $data->bloc_4 = $Wagaia->getByType('bloc_4', $data->id)->list;
            if(!empty($data->bloc_4)) $data->bloc_4_list = $Wagaia->getByType('sousbloc_4', $data->bloc_4[0]->id)->list;

        break;

        case 'list-reference' :

            $data->references = $Wagaia->getByType('reference')->list;

        break;

        case 'reference' :
			
            $data->ref_1 = $Wagaia->getByParent($data->id)->list;

        break;
		
        case 'list-actualites' :

            $data->actualites = $Wagaia->getByType('actualite')->list;

		break;

	}


	$view = (!empty($data->type) && is_file(VIEW.$data->type.'.php')) ? $data->type :  'page';

	if(!is_file( VIEW . $view.'.php')) {
		$log->abort();
	}
}
else {

    // SI AUCUNE PAGE
    $data = new stdClass();
    $data->titre = 'Page non trouvée';
    $log->abort();
}

/*
|---------------------------------------------
| COMPOSER LA NAVIGATION
|---------------------------------------------
*/

$nav = $Wagaia->globalNav();
$menu = $nav[$lg];

/*
|---------------------------------------------
| AJOUTER LES INFOS GLOBALES
|---------------------------------------------
*/

$data->global = $db->select("select * from ".Tables::$global ." where lg='".$lg."'", 'name');
$data->social = $db->select("select url, name from ".Tables::$social ." where lg='".$lg."'", 'name');
$data->config = $db->select("select * from ".Tables::$config, 'name');

/*
|---------------------------------------------
| META TAGS
|---------------------------------------------
*/

$meta = $Wagaia::metatags($data);

/*
|---------------------------------------------
| BREADCRUMB
|---------------------------------------------
*/

//$breadcrumb = $Wagaia->breadcrumb($data->page_id, '', 'breadcrumb');

?>