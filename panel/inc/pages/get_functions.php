<?php

use Wagaia\Tables;
use Wagaia\Lib;

function f_delete()
{
	global $db, $Wagaia;

	extract($_GET);

    // Supression des élements enfants - 3 sous niveaux
	$level1 = $db->select("SELECT * FROM wagaia_pages WHERE parent = ".$id);
	if(!empty($level1)) {
	    foreach($level1 as $lev1) {
            $level2 = $db->select("SELECT * FROM wagaia_pages WHERE parent = ".$lev1->id);
            if(!empty($level2)) {
                foreach($level2 as $lev2) {

                    $file_name = $lev2->image;
                    if(file_exists(IMG_FOLDER.$file_name) && !is_dir(IMG_FOLDER.$file_name)) {
                        unlink(IMG_FOLDER.$file_name);
                        unlink(IMG_FOLDER.'min_'.$file_name);
                    }
                    $db->query("DELETE FROM wagaia_pages WHERE id = ".$lev2->id);

                }
            }

            $file_name = $lev1->image;
            if(file_exists(IMG_FOLDER.$file_name) && !is_dir(IMG_FOLDER.$file_name)) {
                unlink(IMG_FOLDER.$file_name);
                unlink(IMG_FOLDER.'min_'.$file_name);
            }
            $db->query("DELETE FROM wagaia_pages WHERE id = ".$lev1->id);
        }
    }

    $data = $db->get("SELECT * FROM wagaia_pages WHERE id = ".$id);

    $file_name = $data->image;
    if(file_exists(IMG_FOLDER.$file_name) && !is_dir(IMG_FOLDER.$file_name)) {
        unlink(IMG_FOLDER.$file_name);
        unlink(IMG_FOLDER.'min_'.$file_name);
    }
    $db->query("DELETE FROM wagaia_pages WHERE id = ".$data->id);


    /*
	$data = $db->get("SELECT * FROM ".Tables::$pages." where id='".$id."'");
	$db->query("DELETE FROM ".Tables::$pages." where id='".$id."'");


	$file_name = $data->image;
	if(file_exists(IMG_FOLDER.$file_name) && !is_dir(IMG_FOLDER.$file_name)) {
		unlink(IMG_FOLDER.$file_name);
		unlink(IMG_FOLDER.'min_'.$file_name);
	}*/

	$Wagaia->reset();

}

function f_delete_photo()
{
	global $db;

	$table = Tables::$pages;

	extract($_GET);

	$file_name = $db->get("SELECT image FROM ".$table." where id='".$id."'")->image;

	$files = array($file_name, 'tmp_'.$file_name);

	foreach($files as $file) {
		if(is_file(IMG_FOLDER.$file)) {
			unlink(IMG_FOLDER.$file);
			unlink(IMG_FOLDER.'thumbs/'.$file);
			unlink(IMG_FOLDER.'big/'.$file);
		}
	}

	$db->query("UPDATE ".$table." SET image = NULL WHERE id='".$id."'");
}

function f_delete_photo_2()
{
	global $db;

	$table = Tables::$pages;

	extract($_GET);

	$file_name = $db->get("SELECT image2 FROM ".$table." where id='".$id."'")->image2;

	$files = array($file_name, 'tmp_'.$file_name);

	foreach($files as $file) {
		if(is_file(IMG_FOLDER.$file)) {
			unlink(IMG_FOLDER.$file);
			unlink(IMG_FOLDER.'thumbs/'.$file);
			unlink(IMG_FOLDER.'big/'.$file);
		}
	}

	$db->query("UPDATE ".$table." SET image2 = NULL WHERE id='".$id."'");
}

?>