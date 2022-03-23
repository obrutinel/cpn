<?php

	require('../../vendor/autoload.php');


    $search = $db->escape($_GET['search']);

    $sql = "SELECT c.name, c2.zip_code, c2.slug, COUNT(*) as nb FROM wagaia_dico_city c 
              LEFT JOIN wagaia_dico_city c2 ON c.id = c2.id 
              WHERE c.zip_code LIKE '".$search."%' OR c.name LIKE '%".$search."%'
              GROUP BY c.name ORDER BY c2.zip_code ASC LIMIT 2";
    $results = $db->select($sql);

    foreach($results as $res) {

        if($res->nb > 1) {

            $res->libelle = $res->name.' (Toutes la ville)';
            $res->type = 'all';

            $sql = "SELECT * FROM wagaia_dico_city WHERE slug LIKE '".$res->slug."'";
            $details = $db->select($sql);
            if(!empty($details)) {

                foreach($details as $d) {

                    $data = new StdClass();
                    $data->name = $d->name;
                    $data->zip_code = $d->zip_code;
                    $data->slug = $d->zip_code;
                    $data->libelle = $d->name.' ('.$d->zip_code.')';

                    $results[] = $data;

                }

            }

        }
        else {
            $res->libelle = $res->name.' - '.$res->zip_code;
            $res->slug = $res->zip_code;
        }

    }

    echo json_encode($results);
