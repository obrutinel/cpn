<?php

use Wagaia\Lang;
use Wagaia\Lib;

/*
|---------------------------------------------
| LIEN PAGE
|---------------------------------------------
*/

function pageLink($id, $titre, $icon='edit') {

    return '<li class="'.activeLink($id).'"><a href="pages.php?show=edit&amp;id='.$id.'"><i class="fa fa-'.$icon.'"></i> <span class="menu-text">'.$titre.'</span></a></li>';
}

/*
|---------------------------------------------
| LIEN LISTE
|---------------------------------------------
*/

function listLink($parent_id, $titre, $list_type=null, $icon='list-alt') {
    global $type, $parent;
    return '<li '.($type == $list_type && $parent == $parent_id? ' class="active"' : null) .'><a href="pages.php?show=list&amp;parent='.$parent_id.(!empty($list_type) ? '&type='.$list_type : null).'&primary"><i class="fa fa-'.$icon.'"></i> '.$titre.'</a></li>';
}

/*
|---------------------------------------------
| LIEN STATIC
|---------------------------------------------
*/

function staticLink($nom, $titre, $icon='edit') {

    return  '<li class="'.activeLink($nom).'"><a class="'.$nom.'" href="'.$nom.'.php?id='.$nom.'"><i class="fa fa-'.$icon.'"></i> <span class="menu-text"> '.$titre.' </span> </a> </li>';
}

/*
|---------------------------------------------
| IMAGE EXISTE ?
|---------------------------------------------
| $image = l'entrée image dans la DB

*/

function findImage($image) {

    if (is_file(IMG_FOLDER. $image)) {
        return IMG_FOLDER. $image;
    }
    return null;
}

/*
|---------------------------------------------
| IMAGE URL
|---------------------------------------------
| $image = l'entrée image dans la DB
*/

function srcImage($image) {

    if (findImage($image)) {
        return IMG_URL .$image;
    }
    return null;
}

/*
|---------------------------------------------
| IMAGE TAG AVEC URL
|---------------------------------------------
| $image = l'entrée image dans la DB
| $text = texte pour <alt>
*/

function showImage($image, $text=null) {

    $img = srcImage($image);
    if ($img) {
        return '<img src="'.$img.'" alt="'.$text.'" class="img-responsive" />';
    }
    return null;
}

/*
|---------------------------------------------
| RETROUVER UNE INFO GLOBALE
|---------------------------------------------
| $value = la valeur dans $data->global
| ex.utilisation : info('phone') retourne '0442 54 35'
*/

function info($value, $break=false) {
    global $data;
    return nl2br($break ? str_replace(',','<br>', $data->global[$value]->value) : $data->global[$value]->value);
}

/*
|---------------------------------------------
| RETROUVER L'URL d'un élément de la NAV
|---------------------------------------------
| $value = la valeur 'type' dans stdClass $nav
| ex.utilisation : nav_url('contact') retourne 'contact'
*/

function nav_url($value) {

    $element = nav_get($value);

    if ($element) {
        return $element->nav_url;
    }
    return null;
}

function nav_get($value) {

    global $nav, $lg;
	
    $filter = is_int($value) ? 'page_id' : 'type';

    $element = array_filter($nav[$lg], function($val) use ($value, $filter) {
        return $val->{$filter} == $value;
    });

    if (!empty($element)) {
        return current($element);
    }
    return null;
}

function nav_link($value, $class=null) {

    global $lg, $website_lg;
    $element = nav_get($value);
	
    if ($element) {
        return "<a href='".(count($website_lg)>1 ? $lg.'/' : null)."{$element->nav_url}'".($class ? ' class="{$class}"' : null).">{$element->nav_title}</a>";
    }
    return null;
}

function getLink($value, $full = true, $text = null, $class = null) {
	
	global $db;
	
	$filter = is_int($value) ? 'b.page_id' : 'a.type';
	
	$sql = "SELECT b.* FROM wagaia_pages a LEFT JOIN wagaia_pages_data b ON a.id = b.page_id WHERE ".$filter." = '".$value."'";
	$page = $db->get($sql);
	
	if($full) {
		if(empty($text)) $text = $page->nav_title;
		$output = '<a href="'.HTTP.$page->nav_url.'" class="'.$class.'">'.$text.'</a>';
	}
	else $output = HTTP.$page->nav_url;
	
	return $output;
	
}



/*
|---------------------------------------------
| FONCTION VALEURS JCROP
|---------------------------------------------
| Récupère les valeurs pour la fonction Jcrop
*/

function jcrop($force_type=null) {

    global $jcrop_config, $type;

    if ($force_type) {
        $type = $force_type;
    }

    $crop = [];

    if (array_key_exists($type, $jcrop_config)) {

        list($crop['w'], $crop['h']) = $jcrop_config[$type];

        $ratio = 3;

        $crop['max_w'] = (int) $crop['w']*$ratio;
        $crop['max_h'] = (int) $crop['h']*$ratio;
    }

    return $crop;
}


function link_equipe($page_id) { ?>
    <li>
        <a href="#" class="dropdown-toggle"><i class="fa fa-users"></i> <span class="menu-text">Équipe</span><b class="arrow icon-angle-down"></b></a>
        <ul class="submenu">
            <?php echo  pageLink($page_id,'Page');?>
            <?php echo  staticLink('equipe','Membres');?>
        </ul>
    </li>
    <?php
}

function activeLink($id) {

    return (!empty($_GET['id']) && $_GET['id']==$id ? 'active':'');
}

function navActive($id, $nav_id, $class="active") {

    echo $id == $nav_id ? $class:'';
}

function cleanInput($input) {
    $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
            );

    $output = preg_replace($search, '', $input);
    return $output;
}


function f_check_login() {
	if(!empty($_SESSION['wagaia_user']) || !empty($_SESSION['client'])) return true;
	return false;
}


/*
|---------------------------------------------
| AFFICHER LES MOIS EN LETTRES
|---------------------------------------------
*/

function months() {

    return array(

        '01' => 'Janvier',
        '02' => 'Février',
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mai',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Août',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre',
        );
}

function getMonthName($month) {

    $months = months();

    if (array_key_exists($month, $months)) {
        return $months[$month];
    }
    return false;
}

function language_tabs() {

    global $website_lg;

    if (count($website_lg)>1) { ?>
        <ul id="myTab" class="nav nav-tabs">
            <?php
            foreach($website_lg as $k=>$v) { ?>

                <li class="<?=  $v=='fr' ?'active': null;?>">
                    <a href="#lang_<?= $v;?>" data-toggle="tab" aria-expanded="true">&nbsp;&nbsp;&nbsp;<?= Lang::$lg[$v];?>
                        <img src="assets/img/<?= $v;?>.png" alt="" style="padding: 0 0 2px;" />
                    </a>
                </li>
                <?php
            } ?>
        </ul>
        <?php
    }
}

/*
|---------------------------------------------
| AFFICHER DES NOTIFICATIONS APPLICATION
|---------------------------------------------
|
*/

function session_notification($notification) {
    if (!empty($_SESSION['notification'][$notification])) { ?>
        <div class="space-12"></div>
        <?php
        foreach($_SESSION['notification'][$notification] as $k=>$v) { ?>
            <div class="alert alert-<?=$k;?>">
                <?php
                foreach($v as $v) {
                    echo '<p>'. $v .'</p>';
                } ?>
            </div>
            <?php
        }
        $_SESSION['notification'][$notification] = [];
    }
}

/*
|---------------------------------------------
| CLASS HELPERS
|---------------------------------------------
*/

function trans($t, $plural = false) {
    return Lang::trans($t, $plural);
}

function plural($t, $count=false) {
    return Lang::trans($t, $count);
}

// Callback pour la vérification des mots de passe
function hashed_equals($a, $b) {
    return substr_count($a ^ $b, "\0") * 2 === strlen($a . $b);
}

// Cross-Site-Request-Forgery prevention token
function csrf() { ?>
    <div id="token" class="hidden"><?=Lib::sessionToken();?></div>
    <?php
}

// Debuggage d'une variable
function dump($data, $title=false) {
    return Lib::dump($data, $title=false);
}

// Fonction auxiliaire pour dump()
function p ($a, $title) {

    echo "<tr><td><pre>".$a['file']."</pre></td><td><pre>".$a['line']."</pre></td><td><pre>".$a['function']."</pre></td><td><pre style='max-width:600px;'>";

    if($title) {
        array_pop($a['args']);
    }
    foreach($a['args'] as $arg) {

        if(is_array($arg) or is_object($arg)) {
            print_r($arg);
        } else {
            var_dump($arg);
        }
    }
    echo "</pre></td></tr>";
}

// Cette fonction affiche les equivalents de date('F') en français
function ddate ($format) {

    $array = array(
        'Monday'    => 'Lundi',
        'Tuesday'   => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday'  => 'Jeudi',
        'Friday'    => 'Vendredi',
        'Saturday'  => 'Samedi',
        'Sunday'    => 'Dimanche',
        'Mon'       => 'Lun',
        'Tue'       => 'Mar',
        'Wed'       => 'Mer',
        'Thu'       => 'Jeu',
        'Fri'       => 'Ven',
        'Sat'       => 'Sam',
        'Sun'       => 'Dim',
        'January'   => 'Janvier',
        'February'  => 'Février',
        'March'     => 'Mars',
        'May'       => 'Mai',
        'June'      => 'Juin',
        'July'      => 'Juillet',
        'August'    => 'Août',
        'September' => 'Septembre',
        'October'   => 'Octobre',
        'November'  => 'Novembre',
        'December'  => 'Décembre'
        );

    return strtr(date($format),$array);

}

function paginate($item_per_page, $current_page, $total_records, $total_pages, $page_url)
{
    $pagination = '';
	
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){
        $pagination .= '<ul class="pagination text-center">';
       
        $right_links    = $current_page + 6;
        $previous       = $current_page - 6; //previous link
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link
       
        if($current_page > 1){
            $previous_link = ($previous==0)?1:$previous;
            $pagination .= '<li class="first"><a href="'.$page_url.'&page=1" title="First"><<</a></li>'; //first link
            $pagination .= '<li><a href="'.$page_url.'&page='.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                    if($i > 0){
                        $pagination .= '<li><a href="'.$page_url.'&page='.$i.'">'.$i.'</a></li>';
                    }
                }  
            $first_link = false; //set first link to false
        }
       
        if($first_link){ //if current active page is first link
            $pagination .= '<li class="disabled"><a herf="#">'.$current_page.'</a></li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="disabled"><a herf="#">'.$current_page.'</a></li>';
        }else{ //regular current link
            $pagination .= '<li class="active"><a href="#">'.$current_page.'</a></li>';
        }
               
        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li><a href="'.$page_url.'&page='.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){
                $next_link = ($i > $total_pages)? $total_pages : $i;
                $pagination .= '<li><a href="'.$page_url.'&page='.$next_link.'" >&gt;</a></li>'; //next link
                $pagination .= '<li class="last"><a href="'.$page_url.'&page='.$total_pages.'" title="Last">>></a></li>'; //last link
        }
       
        $pagination .= '</ul>';
    }
	
    return $pagination; //return pagination links
}


function getPoints($adresse, $cp = '', $ville = '') {
	
	$api = simplexml_load_file("https://maps.googleapis.com/maps/api/geocode/xml?address=" . urlencode($adresse) . "&sensor=true&key=AIzaSyDUcfXvgck8UO1mOii1CFXJ4ITS8Hx4aoI");
	
    if ($api->status == "OK")
    	return $api->result->geometry->location->lat . ',' . $api->result->geometry->location->lng;
    else {
		$api = simplexml_load_file("https://maps.googleapis.com/maps/api/geocode/xml?address=" . urlencode($cp.' '.$ville) . "&sensor=true&key=AIzaSyDUcfXvgck8UO1mOii1CFXJ4ITS8Hx4aoI");
		if ($api->status == "OK")
			return $api->result->geometry->location->lat . ',' . $api->result->geometry->location->lng;
		else {
			$api = simplexml_load_file("https://maps.googleapis.com/maps/api/geocode/xml?address=" . urlencode($cp) . "&sensor=true&key=AIzaSyDUcfXvgck8UO1mOii1CFXJ4ITS8Hx4aoI");
			if ($api->status == "OK")
				return $api->result->geometry->location->lat . ',' . $api->result->geometry->location->lng;
			else
				return false;	
		}
	}
}

function isValidDate($date) {
  return 1 === preg_match(
    '~^(((0[1-9]|[12]\\d|3[01])\\/(0[13578]|1[02])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)\\/(0[13456789]|1[012])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])\\/02\\/((19|[2-9]\\d)\\d{2}))|(29\\/02\\/((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$~',
    $date
  );
}



function sendMail($sujet, $contenu, $to, $fichier = null) {

	/*$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
	  ->setUsername('8ca0190758d13b')
	  ->setPassword('aac8a0f2c47ef0');*/
	  
	$mailer = Swift_MailTransport::newInstance();
	$message = Swift_Message::newInstance()
		->setCharset('utf-8')
        ->setSubject($sujet.' - CPN')
		->setFrom(['contact@cpnagence.fr' => 'CPN'])
		->setTo($to)
		->setBody($contenu, 'text/html');
		
	if(!empty($fichier)) {
		$message->attach(Swift_Attachment::fromPath($fichier));
	}
		
	$mailer->send($message);
	
}

function randomPassword() {

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function checkPropertyUserPB($property_id, $user_id) {

    global $db;

    $check = $db->get("SELECT * FROM wagaia_property WHERE id = ".$db->escape($property_id)." AND user_id = ".$db->escape($user_id));
    if(!empty($check)) return true;

    return false;
}

function formatSurface($surface) {
    if(!empty($surface)) {
        $surface = (float)$surface;
        return number_format($surface, 0);
    }

}

?>