<?php

/* ----------------------------------
|  CECI EST NECESSAIRE PARTOUT
-------------------------------------
| on ne touche rien ici sauf si on veut
| affecter le fonctionnement global
*/

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE);

header('Content-Type: text/html; charset=utf-8');

setlocale(LC_ALL, 'fr_FR', 'French');

use Wagaia\Wagaia;
use Wagaia\Database;
use Wagaia\Lib;
use Wagaia\Logger;

global $K, $db, $Wagaia, $log;

include ('config-website.php');


/* ----------------------------------
|  CONFIGURATION BUILD
------------------------------------- */
# voir config-website.php

$K = json_decode(json_encode(is_localhost() ? $localhost : array_merge($localhost, $server)));

/* ----------------------------------
|  DATABASE CONNECTION
------------------------------------- */

define('DB_SERVER', $K->database->host);
define('DB_USER', $K->database->user);
define('DB_PASS',$K->database->pass);
define('DB_NAME',$K->database->db);

/* ----------------------------------
|  GLOBAL VARIABLES
------------------------------------- */

define('LOCALE', $lg);
define('DEVPATH', $K->path);
define('PROJECT',$project);
define('WEB_FOLDER',$web_folder);
define('ABSPATH', $K->abspath.'/');
define('HTTP',$K->website->http);
define('IMG_FOLDER', ABSPATH . 'upload/');
define('UPLOAD_FOLDER', IMG_FOLDER);
define('IMG_URL', HTTP . 'upload/');
define('UPLOAD_URL', IMG_URL);
define('VIEW', ABSPATH . 'Wagaia/views/');
define('ASSETS', HTTP . 'Wagaia/views/assets/');
define('PDF_FOLDER', ABSPATH . 'upload/pdf/');

/* ----------------------------------
|  PROJECT VARIABLES
------------------------------------- */

define('MAIL_ADMIN', 'obrutinel@wagaia.com');

define('URL_ACCOUNT_AI', HTTP.'compte-alterimmo/');
define('URL_ACCOUNT_PB', HTTP.'compte-proprietaire/');

define('AGENT_IMG_PATH_PROFILE', IMG_FOLDER.'agent/profil/');
define('AGENT_IMG_URL_PROFILE', IMG_URL.'agent/profil/');
define('AGENT_IMG_PATH_DOCUMENT', IMG_FOLDER.'agent/document/');
define('AGENT_IMG_URL_DOCUMENT', IMG_URL.'agent/document/');

define('USER_IMG_PATH_PROFILE', IMG_FOLDER.'user_pb/profil/');
define('USER_IMG_URL_PROFILE', IMG_URL.'user_pb/profil/');
define('USER_IMG_PATH_SIGNATURE', IMG_FOLDER.'user_pb/signature/');
define('USER_IMG_URL_SIGNATURE', IMG_URL.'user_pb/signature/');

define('PROPERTY_IMG_PATH', IMG_FOLDER.'property/photo/');
define('PROPERTY_IMG_URL', IMG_URL.'property/photo/');
define('PROPERTY_DOC_PATH', IMG_FOLDER.'property/document/');
define('PROPERTY_DOC_URL', IMG_URL.'property/document/');

/* ----------------------------------
|  RECAPTCHA
------------------------------------- */
define('SITE_KEY', '6LfeQKUUAAAAACJ1UxkzSiI3vuakid5LF-YFSG5s');
define('SECRET_KEY', '6LfeQKUUAAAAAK88ZNKsZ8sWBeZK2wXw5D792IUs');

/* ----------------------------------
|  MAIL SMTP
------------------------------------- */

define('MAIL_FROM', 'contact@alterimmo.com');

if(is_localhost()) {

    define('MAIL_SMTP', 'smtp.mailtrap.io');
    define('MAIL_PORT', 2525);
    define('MAIL_USERNAME', '8ca0190758d13b');
    define('MAIL_PASSWORD', 'aac8a0f2c47ef0');

}
else {

    // !!! Problème sur OVH !!! ///
    // La fonction mail() est utilisé PAS swiftmailer

    //define('MAIL_SMTP', 'ssl0.ovh.net');
    //define('MAIL_PORT', 587);
    //define('MAIL_USERNAME', 'info@monalterimmo.com');
    //define('MAIL_PASSWORD', 'MAI11042019');

}


function is_localhost() {
    return in_array($_SERVER['HTTP_HOST'], array('localhost:4554','localhost','127.0.0.1','192.168.1.72','wagaia'))  or strstr($_SERVER['HTTP_HOST'],'.test');
}

$_SESSION['abspath'] = ABSPATH;

$db     = new Database();
$Wagaia = new Wagaia();
$log    = new Logger();