<?php

use Stringy\Stringy as S;
use Intervention\Image\ImageManagerStatic as Image;
use Wagaia\Tables;
use Wagaia\Lib;


/*
|---------------------------------------------
| AJOUT : TRAITEMENT $_POST
|---------------------------------------------
*/

function f_add() {


	global $db, $website_lg, $type, $parent;

	$table = Tables::$pages;
	$max = $db->get('select max(position) as position from '.$table);
	
	if($type == 'sousref_1') {
		$items = $db->select("SELECT * FROM ".$table);
		foreach($items as $item) {
			$sql = "UPDATE ".$table." SET position = (position+1) WHERE id = ".$item->id;
			$db->query($sql);
		}
		
		$newPosition = 0;
	}
	else $newPosition = $max->position+1;

	$db->query("INSERT INTO ".$table." (temp, type, position, date, parent) values (0, '".$type."', ".($newPosition). ', NOW(), '.$parent.")");
	$last = $db->last_id();
	
	if(in_array($type, array('category', 'category-solution'))) {
		$db->query("INSERT INTO wagaia_popup (page_id) VALUES (".$last.")");
	}

	$q = "INSERT INTO ".Tables::$pages_data." (page_id, lg) values ";
	foreach($website_lg as $k=>$v) {
		$s[] = "(".$last.", '".$v."')";
	}
	$db->query($q. implode(',',$s));

	return $last;
}


/*
|---------------------------------------------
| EDITION : TRAITEMENT $_POST
|---------------------------------------------
*/

function f_edit() {
	
	global $db, $website_lg, $options, $redirect;

	extract($_POST);

	$table = Tables::$pages;
	$table_data = Tables::$pages_data;

	$db->transaction();
	

	//$db->query("UPDATE ".$table." SET titre = '".$db->escape($_POST['titre'][0])."', type='".$type."', ".(isset($icone) ? 'icon="'.$icone.'" ' : null)." temp = 0 WHERE id='".$id."'");
	$db->query("UPDATE ".$table." SET titre = '".$db->escape($_POST['titre'][0])."', type='".$type."' WHERE id='".$id."'");

	foreach($website_lg as $k=>$v) {

		$q = "update ".$table_data." set
		titre='".$db->escape($_POST['titre'][$k])."',
		sous_titre='".$db->escape($_POST['sous_titre'][$k])."',
		intro='".$db->escape($_POST['intro'][$k])."',
		texte='".$db->escape($_POST['texte'][$k])."',
		link_text='".$db->escape($_POST['link_text'][$k])."',
		link_url='".$db->escape($_POST['link_url'][$k])."',
		meta_desc='".$db->escape($_POST['meta_desc'][$k])."',
		meta_titre='".$db->escape($_POST['meta_titre'][$k])."',
		meta_key='".$db->escape($_POST['meta_key'][$k])."',";

		$nav_title = empty($_POST['nav_title'][$k]) ? $_POST['titre'][$k] : $_POST['nav_title'][$k];
		$nav_url = empty($_POST['nav_url'][$k]) ? $nav_title : $_POST['nav_url'][$k];


		$url = S::create($nav_url)->slugify();

		// Eviter la dupplication d'url
		$urls = $db->get('select count(b.id) as count from '. $table_data . ' b, '.$table.' a where nav_url="'.$url.'" and lg="'.$v.'" and a.id=b.page_id and b.page_id!='.$id);

		if (!empty($urls->count)) {
			$url = $id.'-'.$url;
		}

		$q.= "nav_title='".$db->escape($nav_title)."', nav_url='".$url."' where page_id='".$id."' and lg='".$v."'";
		$db->query($q);
	}

	// TRAITEMENTS Options et perso
	include(ABSPATH . 'panel/inc/plugins/plugins.php');
	include(ABSPATH . 'Wagaia/panel/page-lg.php');

	$db->commit();

	if(($_FILES && $_FILES['image']['error'] == 0) && $id) {
		f_add_photo($id, $type);
	}

	if(($_FILES && $_FILES['image2']['error'] == 0) && $id) {
		f_add_photo_2($id, $type);
	}
	
	if (isset($addAndNew)) {
		header("Location: ".$redirect."?show=edit&id=". f_add());
		exit;
	}
}



/*
|---------------------------------------------
| TRAITEMENTS DES IMAGES
|---------------------------------------------
| Les fonctionnalités de traitement d'image utilsent la classe ImageIntevention
| http://image.intervention.io/
*/


/*
|---------------------------------------------
| AJOUT ET REDIMENSIONNEMENT INITIAL
|---------------------------------------------
*/

function f_add_photo($id, $type) {

	global $db, $jcrop_exclude;

	$jcrop = jcrop();

	if (!is_dir(IMG_FOLDER . '/thumbs')) {
		mkdir(IMG_FOLDER . '/thumbs', 755, true);
	}

	$f_file = $_FILES['image'];

	if (!empty($f_file['tmp_name']) && $jcrop) {

		$path_parts = pathinfo($f_file['name']);
		$ext = $path_parts['extension'];
		$randomName = md5(time().rand()).'.'.$ext;

		// Redimensionnement avec jcrop
		$prefix = 'tmp_';
		$w = $jcrop['max_w'];
		$h = $jcrop['max_h'];

		// Redimensionnement simple avec limite supérieure
		if (in_array($type, $jcrop_exclude)) {
			$prefix = '';
			$w = $jcrop['w'];
			$h = $jcrop['h'];
		}

		/*if(Image::make($f_file['tmp_name'])->resize($w, $h, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		})->encode('jpg')->save(IMG_FOLDER. $prefix . $randomName.'.jpg', 80)) {*/
		
		if(Image::make($f_file['tmp_name'])->save(IMG_FOLDER. $prefix . $randomName, 100)) {

			if ($prefix != 'tmp_') {
				
				// Thumb
				Image::make(IMG_FOLDER. $randomName)->resize(400, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save(IMG_FOLDER. 'thumbs/' . $randomName, 100);
			}

			$db->query("UPDATE wagaia_pages SET image = '".$randomName."' where id='".$id."'");
		}
	}
}

function f_add_photo_2($id, $type) {

	global $db, $jcrop_exclude;

	$jcrop = jcrop();

	if (!is_dir(IMG_FOLDER . '/thumbs')) {
		mkdir(IMG_FOLDER . '/thumbs', 755, true);
	}

	$f_file = $_FILES['image2'];
	

	if (!empty($f_file['tmp_name']) && $jcrop) {
		
		$path_parts = pathinfo($f_file['name']);
		$ext = $path_parts['extension'];
		$randomName = md5(time().rand()).'.'.$ext;


		// Redimensionnement avec jcrop
		$prefix = 'tmp_';
		$w = $jcrop['max_w'];
		$h = $jcrop['max_h'];

		// Redimensionnement simple avec limite supérieure
		if (in_array($type, $jcrop_exclude)) {
			$prefix = '';
			$w = $jcrop['w'];
			$h = $jcrop['h'];
		}

		/*if(Image::make($f_file['tmp_name'])->resize($w, $h, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		})->encode('jpg')->save(IMG_FOLDER. $prefix . $randomName.'.jpg', 80)) {*/
		
		if(Image::make($f_file['tmp_name'])->encode('jpg')->save(IMG_FOLDER.$prefix.$randomName, 100)) {

			if ($prefix != 'tmp_') {
				
				// Thumb
				Image::make(IMG_FOLDER. $randomName)->resize(400, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save(IMG_FOLDER. 'thumbs/' . $randomName, 100);
			}

			$db->query("UPDATE wagaia_pages SET image2 = '".$randomName."' where id='".$id."'");
		}
	}
}


/*
|---------------------------------------------
| REDIMENSIONNEMENT JCROP
|---------------------------------------------
*/

function f_modif_img() {

	global $db, $jcrop_config;

	extract($_POST);


	$i = $db->get("SELECT image, type FROM ".Tables::$pages." where id='".$id."'");

	$image = $i->image;

	if ($image) {

		$tempFile = IMG_FOLDER.'tmp_'.$image;

		if (is_file($tempFile)) {
			
			// Big
			Image::make($tempFile)->save(IMG_FOLDER.'big/'.$image, 100);
			
			if(Image::make($tempFile)->crop((int)$wimage, (int)$himage, (int)$x1image, (int)$y1image)->resize($wiimage, $heimage, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save(IMG_FOLDER. $image, 100)) {

				$thumb_size = !empty($i->type) && array_key_exists($i->type.'_thumb', $jcrop_config) ? $jcrop_config[$i->type.'_thumb'] : 100;


				// Thumb
				Image::make(IMG_FOLDER. $image)->resize($thumb_size, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save(IMG_FOLDER. 'thumbs/' . $image, 100);

				unlink($tempFile);


			}
		}
	}

}

function f_modif_img_2() {

	
	global $db, $jcrop_config;

	extract($_POST);


	$i = $db->get("SELECT image2, type FROM ".Tables::$pages." where id='".$id."'");

	$image = $i->image2;

	if ($image) {

		$tempFile = IMG_FOLDER.'tmp_'.$image;

		if (is_file($tempFile)) {
			
			// Big
			Image::make($tempFile)->save(IMG_FOLDER.'big/'.$image, 100);
			
			if(Image::make($tempFile)->crop((int)$wimage, (int)$himage, (int)$x1image, (int)$y1image)->resize($wiimage, $heimage, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save(IMG_FOLDER. $image, 100)) {

				$thumb_size = !empty($i->type) && array_key_exists($i->type.'_thumb', $jcrop_config) ? $jcrop_config[$i->type.'_thumb'] : 100;


				// Thumb
				Image::make(IMG_FOLDER. $image)->resize($thumb_size, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save(IMG_FOLDER. 'thumbs/' . $image, 100);

				unlink($tempFile);


			}
		}
	}

}


?>