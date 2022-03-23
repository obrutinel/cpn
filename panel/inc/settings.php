<?php
session_start();

// main settings
 if (is_localhost()) {
	define("C_MAIN_DIR", '/volume1/web/'.$project.'/');
	define("C_MAIN_URL","http://Wagaia/".$project."/");
} else {
	define("C_MAIN_DIR", $_SERVER['DOCUMENT_ROOT'].'/');
	define("C_MAIN_URL",HTTP);
}

define("C_HQ_DIR", C_MAIN_DIR."panel/");
define("C_HQ_URL", C_MAIN_URL."panel/");
define("C_LANGUAGE_DEFAULT","fr");
define("C_TITLE","Panel d'administration - ".$project);
define("C_TITRE_PRINCIPAL",$project);
define("C_MAIL_FL","jsabat@wagaia.com");

define("C_ADMIN_ON_SITE",50);
define("C_ADMIN_ON_HQ",50);


// statics settings
define("C_UPLOAD_PHOTO_DIR",C_MAIN_DIR."upload/");
define("C_UPLOAD_PHOTO_URL",C_MAIN_URL."upload/");
define("C_UPLOAD_DOC_DIR",C_MAIN_DIR."upload/");
define("C_UPLOAD_DOC_URL",C_MAIN_URL."upload/");



//open

define("C_OPEN_ON_HQ",30);

//newsletter

define("C_NEWSLETTER_USER_ON_HQ",90);

define("C_LETTER_ON_HQ",30);

define("C_NEWSLETTER_PHOTO_DIR", C_MAIN_DIR."data/letter/images/");

define("C_NEWSLETTER_PHOTO_URL", C_MAIN_URL."data/letter/images/");

define("C_NEWSLETTER_ATTACH_DIR", C_MAIN_DIR."data/letter/attachments/");

define("C_NEWSLETTER_ATTACH_URL", C_MAIN_URL."data/letter/attachments/");

define("C_NEWSLETTER_PHOTO_MAX_WIDTH",900);

define("C_NEWSLETTER_PHOTO_MAX_HEIGHT",900);

define("C_NEWSLETTER_PHOTO_MIN_WIDTH",100);

define("C_NEWSLETTER_PHOTO_MIN_HEIGHT",100);

define("C_EMAILS_PER_SENT",10);

define("C_NEWSLETTER_UNSUBSCRIBE_SUBJ",'D&eacute;sinscription de la newsletter');

define("C_MAIL_FROM",'noreply@wagaia.com');

define("C_MAIL_FROM_NAME",'');

define("C_MAIL_SMTP_SERVER",'smtp.orange.fr');

define("C_MAIL_LANG",'en');

define("C_MAIL_CHARSET",'UTF-8');

?>
