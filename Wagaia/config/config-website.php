<?php

/* ----------------------------------
|  CONFIGURATION GLOBALE DU SITE
------------------------------------- */

/* Les variables qui vont être déclarés ici doivent
 * passer par une première déclaration dans (global)
 * faut de quoi l'autoload n'en aura pas connaissance */

global  $project,
		$site_name,
        $web_folder,
        $website_lg,
        $lg,
        $K,
        $contact_options,
        $contact_sources,
        $social_networks,
        $global_info,
        $jcrop_config,
        $order_by,
        $options,
        $options_disable,
        $type_limit,
        $notification,
        $jcrop_exclude;

$project = 'CPN';
$site_name = 'CPN';
$web_folder = is_localhost() ? $project : '';

/* --------------------------------------------------------------------------
|  Multi langue par défaut, si une langue, ne la laisser qu'elle dans array()
----------------------------------------------------------------------------- */
$website_lg = ['fr'];
$lg = 'fr';

$localhost = array(

    'path'=> $_SERVER['DOCUMENT_ROOT'] . '/'.$project . '/Wagaia/', // dossier équivalent de __DEV__ sur le serveur de production
    'path_http' => 'http://'.$_SERVER['SERVER_NAME'].'/'.$project . '/Wagaia/',
    'abspath'=> $_SERVER['DOCUMENT_ROOT'],
    'fileManager'=>true,
    'database'=> array(
        'host'=>'localhost',
        'user'=>'root',
        'pass'=>'root',
        'db'=> 'cpn-agence',
        ),
    'website' => array(
        'folder'=>'/',
        'filemanager'=>'/'.$project,
        'name'=>$project,
        'http'=> 'http://'.$_SERVER['SERVER_NAME'].'/',
        'path'=> $_SERVER['DOCUMENT_ROOT'].'/',
        'filemanager_upload_path'=>$_SERVER['DOCUMENT_ROOT'].'upload/filemanager',
        ),
    'escape'=>true,

    );


$server = array(
    'path'=> $_SERVER['DOCUMENT_ROOT'] . '/'.$web_folder.'Wagaia/', // dossier équivalent de __DEV__ sur le serveur de production
    'abspath'=> $_SERVER['DOCUMENT_ROOT'] . '/'.$web_folder,
    'database'=> array(
        'host'=>'dtsuzkfcpna22.mysql.db',
        'user'=>'dtsuzkfcpna22',
        'db'=> 'dtsuzkfcpna22',
        'pass'=>'dJHgVBVaMB8p',
        ),
    'website' => array(
        'folder'=>'/'.$web_folder,
        'filemanager'=>'',
        'name'=> $project,
        'http'=> 'https://cpnagence.wagaia.fr/'.$web_folder,
        'path'=> $_SERVER['DOCUMENT_ROOT'] . '/',
        'filemanager_upload_path'=> $_SERVER['DOCUMENT_ROOT'],
        ),
    'escape'=>true,
    );

/*
|---------------------------------------------
| Messages renvoyés par les plugins
|---------------------------------------------
*/
$notification = [];

/*
|---------------------------------------------
| Variables site
|---------------------------------------------
*/

# Voir traduction contactOption_
$contact_options = []; // Options dans le form. de contact
# Voir traduction contactSource_
$contact_sources = []; // Vous nous avez connu par ?
# Les réseaux sociaux
$social_networks  = ['facebook', 'twitter', 'instagram', 'linkedin'];//'facebook', 'twitter', 'instagram'


/* --------------------------------------------------------------------------
|  Informations générales, clé=>position, le nom affiché est dans traductions
----------------------------------------------------------------------------- */
$global_info  = [
    'baseline' => 'Baseline',
    'texte' => 'A propos de nous (texte 1)',
    'texte2' => 'A propos de nous (texte 2)',
	'adresse' => 'Adresse',
	'email' => 'Email',
	'email_notif' => 'Email (notification)',
	'phone' => 'Téléphone'
];

$order_by = [
    //'news' => 'date desc',
];

/* -------------------------------------------
|  OPTIONS JCROP
---------------------------------------------*/
$jcrop_config = [
	'slide' => [1920, 1080],
	'bloc' => [445, 296],
	'secteur' => [350, 233],
	'actualite' => [960, 640],
	'sousbloc_2' => [225, 170],
	'sousbloc_4' => [225, 170],
	'sousref_1' => [225, 170],
	'sousref_2' => [150, 90],
	'sousref_3' => [540, 408],
	'logo' => [225, 90],
];

// Pas de crop forcé, permet l'upload non restrictif
// d'images verticales et horizontales; si la taille est
// supérieure aux dimensions, le redimensionnement la calera,
// si elle en est inférieure, il laissera telle qu'elle
$jcrop_exclude = ['logo', 'sousref_2'];

/* -------------------------------------------
|  Options pour l'espace édition dans le panel
---------------------------------------------- */
$options = [
    'equipe' => false, // sinon ID de la page - PAS MIS EN PLACE !
    'has_slider' => ['parent' => [],'type' => []],
    'has_list' => [
        'type' => [
			'bloc_1' => ['name' => 'sousbloc_1', 'title' => 'Liste'],
			'bloc_2' => ['name' => 'sousbloc_2', 'title' => 'Liste'],
			'bloc_3' => ['name' => 'sousbloc_3', 'title' => 'Liste'],
			'ref_1' => ['name' => 'sousref_1', 'title' => 'Liste'],
			'ref_2' => ['name' => 'sousref_2', 'title' => 'Liste']
        ]
    ],
    'has_icons'         => ['parent' => [],'type' => []], // sélecteur d'icône
    'has_datepicker'    => ['parent' => [],'type' => ['actualite']], // sélecteur de date
    'has_multiple_datepicker' => ['parent' => [],'type' => []], // ajout de plusieurs dates sur une page
    'has_link'          => ['type'=> ['slide', 'bloc', 'logo']], // ajout d'un lien
    'has_price'         => ['type'=> []], // champ prix,
    'has_attachments'   => ['type'=> []], // Fichiers téléchargeables et leur type (s'il faut le restreindre), multi-lg ['type'=>['slider-video' => ['mp4','webm']]]
    'has_blocs'         => ['type'=> []], // Blocs internes, multi-lg
    'has_intro'         => ['type'=> ['actualite', 'secteur', 'sousref_1', 'sousref_2', 'sousref_3', 'contact']], // Texte court
    'has_subtitle'      => ['type'=> ['slide', 'bloc', 'list-secteur', 'list-reference', 'secteur', 'sousbloc_2', 'sousbloc_4', 'list-logo', 'contact', 'sousref_1', 'sousref_2', 'sousref_3']], // Sous-Titre,
    'has_masonry' 		=> ['type'=> []],
    'sticky'            => ['type'=> []],
    'limit_input' => [
		//'sticker' => ['intro' => 100],
	]
];

$options_disable = [
    'titre'     => ['page' => [],'type' =>  ['home']],
    'meta'      => ['page' => [],'type' =>  ['slide', 'bloc', 'bloc_1', 'bloc_2', 'bloc_3', 'sousbloc_1', 'sousbloc_2', 'sousbloc_4', 'sousbloc_3', 'ref_1', 'sousref_1', 'sousref_2', 'sousref_3', 'logo', 'list-logo']],
    'texte'     => ['page' => [],'type' =>  ['home', 'slide', 'list-actualite', 'bloc_1', 'bloc_2', 'bloc_3', 'sousbloc_1', 'sousbloc_2', 'sousbloc_4', 'list-secteur', 'list-reference', 'ref_1', 'sousref_1', 'sousref_2', 'sousref_3', 'logo', 'list-logo']],
    'tinymce'   => ['page' => [],'type' =>  ['slide']],
    'url'       => ['page' => [],'type' =>  ['home']],
    'sortable'  => ['type'=> []],
	
	'btn_ajouter_un_enregistrement' => ['parent' => [], 'page' => [], 'type'=> ['bloc', 'bloc_1', 'bloc_2', 'bloc_3']]
];


/* -------------------------------------------
| Limiter le nombre de pages enfants par type
--------------------------------------------- */
$type_limit = ['home-bloc' => 2];


/* -------------------------------------------
| Admin / Destinataire des emails
--------------------------------------------- */
define('TO_ADMIN', 'obrutinel@wagaia.com');