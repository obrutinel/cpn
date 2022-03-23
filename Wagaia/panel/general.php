<?php

/*
|---------------------------------------------
| Traitemens sur mesure pour le site en cours
| sur la partie Générale (footer, global, etc...)
| Si pas nécessaire - laisser vide
|---------------------------------------------
*/

// Les champs supplémentaires qu'il vous faut
//$columns = array('prefooter_title', 'prefooter_text');
$columns = false;
// Créer automatiquement les champs
if ($columns) {
    foreach($columns as $col) {
        if (!$db->column(Tables::$global, $col)) {
            $db->query('ALTER TABLE '.Tables::$global.' ADD COLUMN `'.$col.'` TEXT NOT NULL');
        }
    }

// Mise à jour
    if ($_POST) {

        extract($_POST);

        $db->transaction();

        foreach($columns as $col) {
            $q = "update ".Tables::$global." set `".$col."`='".$db->escape(${$col})."'";
            $db->query($q);
        }
        $db->commit();

    }
    // Champs formulaire

//$cols = $db->get("SELECT prefooter_title, prefooter_text from ".$table);

}
?>