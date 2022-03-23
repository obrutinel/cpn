<?php

$redirect = HTTP. 'panel/pages.php';


if (isset($_GET['act'])) {

	switch($_GET['act']) {

		case 'delete_value':

		f_delete();
			header("Location: ".$redirect.'?show=list'.($parent ? '&parent='.$parent : null) . ($type ? '&type='.$type : null));
		break;

		case 'add_value':
			$last = f_add();
			header("Location: ".$redirect."?show=edit&id=".$last);
		break;

        case 'add':
            //header("Location: ".$redirect."?show=edit&id=".$last);
            break;

        case 'add_ref':
            //header("Location: ".$redirect."?show=edit&id=".$last);
            break;

		case 'delete_photo':
			f_delete_photo();
			header("Location: ".$redirect."?show=edit&id=".$_GET['id']);
		break;
		
		case 'delete_photo_2':
			f_delete_photo_2();
			header("Location: ".$redirect."?show=edit&id=".$_GET['id']);
		break;
	}
}

if (isset($_POST['submit_form'])) {

	switch($_POST['submit_form']) {

		case 'add_value':

		    if(empty($_POST['bloctype']))   $error[] = "Veuillez selectionner un type de bloc";
		    if(empty($_POST['title']))      $error[] = "Veuillez renseigner un titre";

		    if(empty($error)) {

		        $sql = "INSERT INTO wagaia_pages (titre, parent, type) VALUES (
                            '" . $db->escape($_POST['title']) . "',
                            '" . $db->escape($_GET['parent']) . "',
                            '" . $db->escape($_POST['bloctype']) . "'
                        )";
		        $db->query($sql);
		        $lastID = $db->last_id();

		        $sql = "INSERT INTO wagaia_pages_data (page_id, titre, lg) VALUES (
                            " .$lastID. ", '" . $db->escape($_POST['title']) . "', 'fr'
                        )";
		        $db->query($sql);

                header("Location: ".$redirect."?show=list&parent=".$_GET['parent']."&type=sousbloc");
                exit;

            }


        break;

        case 'add_value_ref':

            if(empty($_POST['bloctype']))   $error[] = "Veuillez selectionner un type de bloc";
            if(empty($_POST['title']))      $error[] = "Veuillez renseigner un titre";

            if(empty($error)) {

                $sql = "INSERT INTO wagaia_pages (titre, parent, type) VALUES (
                            '" . $db->escape($_POST['title']) . "',
                            '" . $db->escape($_GET['parent']) . "',
                            '" . $db->escape($_POST['bloctype']) . "'
                        )";
                $db->query($sql);
                $lastID = $db->last_id();

                $sql = "INSERT INTO wagaia_pages_data (page_id, titre, lg) VALUES (
                            " .$lastID. ", '" . $db->escape($_POST['title']) . "', 'fr'
                        )";
                $db->query($sql);

                header("Location: ".$redirect."?show=list&parent=".$_GET['parent']."&type=sousref");
                exit;

            }


        break;

		case 'edit_value':

		$param = f_edit();
		if($param) $param = '&gps=nok';

		if (isset($_POST['simg']) or isset($_POST['simg2']) or isset($_POST['s2'])) {
			
			if(isset($_POST['simg'])) {
				f_modif_img();
			}
			
			if(isset($_POST['simg2'])) {
				f_modif_img_2();
			}

			header("Location: ".$redirect."?show=edit&id=".$_POST['id'].$param);
			
		} else {

		    if($parent == 47)
                header("Location: " . $redirect . "?show=list&content_type=list" . ($parent ? '&parent=' . $parent : null));
            else
                header("Location: " . $redirect . "?show=list&content_type=list" . ($parent ? '&parent=' . $parent : null) . (!empty($_POST['type']) ? '&type=' . $_POST['type'] : null));

		}

		break;

	}
}