<?php

/*
|---------------------------------------------
| CHOIX D'UNE ÎCONE : optionnel
|---------------------------------------------
*/

if(in_array($type, $options['has_icons']['type'])) {

	include_once(ABSPATH . 'panel/inc/plugins/icon.php');

}

/*
|---------------------------------------------
| CHOIX D'UNE DATE (optionnel)
|---------------------------------------------
*/

if(in_array($type, $options['has_datepicker']['type'])) {

	include_once(ABSPATH . 'panel/inc/plugins/datepicker.php');

}

/*
|---------------------------------------------
| GESTION DE PLUSIEURS DATES (optionnel)
|---------------------------------------------
*/

if(in_array($type, $options['has_multiple_datepicker']['type'])) {

	include_once(ABSPATH . 'panel/inc/plugins/multiple_datepicker.php');

}

/*
|---------------------------------------------
| CHAMP PRIX (optionnel)
|---------------------------------------------
*/

if(in_array($type, $options['has_price']['type'])) {

	include_once(ABSPATH . 'panel/inc/plugins/price.php');

}

/*
|---------------------------------------------
| CHAMP STICKY (optionnel)
|---------------------------------------------
*/

if(in_array($type, $options['sticky']['type'])) {

	include_once(ABSPATH . 'panel/inc/plugins/sticky.php');

}

/*
|---------------------------------------------
| Fonctionnalités du panel relatives au site
| en cours uniquement
|---------------------------------------------
*/
include_once(ABSPATH . 'Wagaia/panel/page-global.php');

/*
|---------------------------------------------
| Traitements des options Multi-lg
|---------------------------------------------
*/
if(in_array($type, $options['has_attachments']['type'])) {
	include_once(ABSPATH . 'panel/inc/plugins/attachments_global.php');
}
if(in_array($type, $options['has_blocs']['type'])) {
	include_once(ABSPATH . 'panel/inc/plugins/blocs_global.php');
}

?>