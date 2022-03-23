<?php
require_once('../vendor/autoload.php');

use Wagaia\Tables;
use Wagaia\Lib;

if(!f_check_login()) {
    header("Location: login.php");
    exit;
}

$db->transaction();

extract($_POST);

$json_response = [];

switch($_POST['content_type']) {

    case 'status':
        $db->query("UPDATE wagaia_pages SET temp = ".$_POST['status']." WHERE id = '".$_POST['content_id']."'");
    break;

    case 'sticky' :
        if (!empty($_POST['order'])) {
            foreach($_POST['order'] as $k=>$v) {
                $db->query("update ".Tables::$sticky." set position='".$v."' where id='".$k."'");
            }
        }
        $json_response = ["Stickies updated"];
    break;

    case 'service':
        foreach($_POST['order'] as $k=>$v) {
            $db->query("UPDATE wagaia_service SET position = '".$v."' WHERE id = '".$k."'");
        }
    break;

    case 'service_description':
        foreach($_POST['order'] as $k=>$v) {
            $db->query("UPDATE wagaia_service_description SET position = '".$v."' WHERE id = '".$k."'");
        }
    break;

    default :

        if (!empty($_POST['order'])) {

            if($_POST['content_type'] == 'subpage') {

                foreach($_POST['order'] as $k=>$v) {
                    $db->query("update ".Tables::$pages." set position='".$v."' where id='".$k."'");
                }

            }
            elseif($_POST['content_type'] == 'sousref') {

                foreach($_POST['order'] as $k=>$v) {
                    $db->query("update ".Tables::$pages." set position='".$v."' where parent = ".$_POST['content_id']." AND id='".$k."'");
                }

            }
            else {

                foreach($_POST['order'] as $k=>$v) {
                    $db->query("update ".Tables::$pages." set position='".$v."' where id='".$k."' and type='".$_POST['content_type']."'");
                }
            }
        }
}
$db->commit();

Lib::json($json_response);