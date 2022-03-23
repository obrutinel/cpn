<?php

require('../vendor/autoload.php');
require_once('inc/settings.php');

use Stringy\Stringy as S;
use Wagaia\Tables;
use League\Csv\Reader;
use League\Csv\CharsetConverter;

if (!f_check_login()) {
    header("Location: login.php");
    exit;
}

require_once('inc/header.php');



//Warning: If your CSV document was created or is read on a Macintosh computer, add the following lines before using the library to help PHP detect line ending.
if(!ini_get("auto_detect_line_endings")) {
    ini_set("auto_detect_line_endings", '1');
}
/*
if (!empty($_POST) && $_POST['valider'] == 'geoloc') {
	
	$sessions = $db->select("SELECT * FROM wagaia_session WHERE is_geo = 0");
	
	foreach($sessions as $session) {
		
		if(!empty($session->adr_complete)) {
			
			//echo 'ID: '.$session->id.' ->'.$session->adr_complete;
		
		
			$urlWebServiceGoogle = 'https://maps.google.com/maps/api/geocode/json?address=%s&sensor=false&language=fr&key=AIzaSyAtyhFv6gPRgrCHYIcLzohwXGA2LpnCD4c';
			$fullAddr = $session->adr_complete;

			$url = vsprintf($urlWebServiceGoogle, urlencode($fullAddr));
			$response = json_decode(file_get_contents($url));
			
			
			
			//echo ' ====> '.$response->status.'<br />';
			
			if($response->status == 'OK') {

				$lat = str_replace(',', '.', $response->results[0]->geometry->location->lat);
				$lng = str_replace(',', '.', $response->results[0]->geometry->location->lng);
				
				$adr_complete = $response->results[0]->formatted_address;
				
				if(in_array('street_number', $response->results[0]->address_components[0]->types)) {
					$adr_numero = $response->results[0]->address_components[0]->long_name;
				}
				
				if(in_array('route', $response->results[0]->address_components[0]->types)) {
					$adr_rue = $response->results[0]->address_components[1]->long_name;
				}
				if(in_array('route', $response->results[0]->address_components[1]->types)) {
					$adr_rue = $response->results[0]->address_components[1]->long_name;
				}
				
				
				$sql = "UPDATE wagaia_session SET 
							adr_complete = '".$db->escape($adr_complete)."',
							adr_numero = '".$adr_numero."',
							adr_rue = '".$db->escape($adr_rue)."',
							lat = '".$lat."',
							lng = '".$lng."',
							is_geo = 1
						WHERE id = ".$session->id;
				$db->query($sql);
				
			}

		}

	}
	
	$successGeoloc = true;
}
*/

if (!empty($_POST) && $_POST['valider'] == 'import') {
	
	$success = 'false';

	$path = UPLOAD_FOLDER.'csv';
	$storage = new \Upload\Storage\FileSystem($path);
	$file = new \Upload\File('fichier', $storage);
	
	$new_filename = uniqid();
	$file->setName($new_filename);
	
	try {
		
		$file->upload();
		
		$csv = new SplFileObject($path.'/'.$new_filename.'.csv', 'r');
		$csv->setFlags(SplFileObject::READ_CSV);
		$csv->setCsvControl(';', '"', '"');
		$csv = new LimitIterator($csv, 1);
		
		$encoder = (new CharsetConverter())->inputEncoding('WINDOWS-1252');
		$records = $encoder->convert($csv);
		
		
		$i = $nbNewClient = $nbUpdateClient = 0;


		foreach($records as $row) {

		    /*echo '<pre>';
		    print_r($row);
		    echo '</pre>';*/

			if(!empty($row[0])) {
			
				// On vérifie si le client existe déjà ou pas

                $client = \Wagaia\Client::where('mail', $row[5])->first();

                if(empty($client)) {

                    // Vérifier si l'adresse mail existe déjà

                    $nbNewClient++;
                }
                else {

                    if(!empty($row[1])) $client->lastname = $row[1];
                    if(!empty($row[2])) $client->firstname = $row[2];
                    if(!empty($row[3])) $client->category = $row[3];
                    if(!empty($row[4])) $client->phone = $row[4];
                    if(!empty($row[6])) $client->adress_1 = $row[6];
                    if(!empty($row[7])) $client->adress_2 = $row[7];
                    if(!empty($row[8])) $client->zipcode = $row[8];
                    if(!empty($row[9])) $client->city = $row[9];

                    $client->save();

                    $nbUpdateClient++;

                }

                $i++;

			}

		}
		
		$success = true;
		
	} catch (\Exception $e) {
		$errors = $file->getErrors();
	}
}

?>


<form name="main_f" method="POST" action="import-csv.php" enctype="multipart/form-data" autocomplete="off">

	<?php if($success) : ?>
		<div class="alert alert-success">
			<p><?=$i?> lignes ont été importé avec succès dont <?=$nbNewClient?> nouveaux client et <?=$nbUpdateClient?> mises à jour.</p>
		</div>
	<?php endif; ?>

    <?php if(!empty($errors)) : ?>
        <div class="alert alert-danger">
            <p><?=$errors?></p>
        </div>
    <?php endif; ?>

	<div class="space-12"></div>
	<div class="form-group">
        <h3 class="header blue smaller">Selectionnez votre fichier : <small>(format .CSV)</small></h3>
		<div class="col-sm-6">

			<p>
				Veuillez utiliser un fichier CSV séparé par des ";".<br /><br /><br />
				<a href="<?=HTTP?>upload/csv/exemple-import.csv" target="_blank">Fichier CSV d'exemple</a>
			</p>
			
			<input type="file" name="fichier" class="form-control" />
		</div>
	</div>
	<div class="space-6"></div>
	<div class="form-group">
		<div class="col-sm-12">
			<button class="btn btn-info" name="valider" value="import" type="submit"><i class="icon-ok bigger-110"></i>Valider</button>
		</div>
	</div>

</form>
	

<?php require_once('inc/footer.php'); ?>