<?php

namespace Wagaia;

use \DateTime;

class Lib
{
    /*
    |---------------------------------------------
    | Entier positif non zéro
    |---------------------------------------------
    | str $val : la valeur à vérifier
    */

    public static function digital($val)
    {
        if (!is_bool($val) && preg_match('/^[1-9](?:\d+)?+$/', $val)) {
            return $val;
        }
        return false;
    }


    /*
    |---------------------------------------------
    | Suppression recursive de répertoires
    |---------------------------------------------
    | avec tout leur contenu
    |
    | str $dir : le répertoire
    */


    public static function removeDir($dir = null)
    {
        if ($dir && is_dir($dir)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }
            rmdir($dir);
        }
    }

    // Trouve le nombre d'un limitateur d'itération
    public static function limiter ($number, $division) {

        if($number % $division != 0) {
            $number += $division - ($number % $division);
        }
        return $number/$division;
    }

    // Affiche une date MySQL au format de lecture
    public static function date ($input, $format='d/m/Y') {

        if ($input != '0000-00-00' && !empty($input)) {
            return date($format, strtotime($input));
        }
        return null;
    }

    // Convertir une date
    public static function dateConvert ($input, $from, $to) {

        $date = DateTime::createFromFormat($from, $input);
        return $date ? $date->format($to) : null;
    }

    public static function date_diff ($date1, $date2)
    {
        $datetime1 = date_create($date1);
        $datetime2 = date_create($date2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->days;
    }

    public static function timestamp ()
    {
        return date('Y-m-d H:i:s');
    }


    /*
    |---------------------------------------------
    | Aplatir un array
    |---------------------------------------------
    | array $array : assoc ou stdClass
    | str $key : clé de tri
    |
    | pour obtenir un array de valeurs simple
    */

    public static function flatten(array $array, $key, $preserveKey = false)
    {
        if (!$array or !$key) {
            return null;
        }

        $flattened = array();

        if(is_array($array)) {

            foreach($array as $k=>$v) {
                $ob = is_object($v) ? true : false;
                $val = $ob ? $v->$key : $v[$key];
                $key_val = $preserveKey ? ($ob ? $v->$preserveKey : $v[$preserveKey]) : $k;
                $flattened[$key_val] = $val;
            }

        } elseif(is_object($array)) {

            foreach($array as $v) {
                if ($preserveKey) {
                    $flattened[$v->{$preserveKey}] = $v->{$key};
                } else {
                    $flattened[] = $v->{$key};
                }
            }
        }

        return $flattened;
    }



    public static function json($json)
    {
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($json);
    }

    public static function token()
    {
        return hash('ripemd320', session_id().time().mt_rand(5, 15));
    }

    public static function sessionToken()
    {
        if(empty($_SESSION['token'])) {
            $_SESSION['token'] =  Lib::token();
        }
        return $_SESSION['token'];
    }


    /*
    |---------------------------------------------
    | FONCTION DUMP
    |---------------------------------------------
    | Debug variable avec traçage
    */

    public static function dump($data, $title=false) {



        if ($title) {

            echo '<h3 style="background:#F1A0A0;padding:10px;">'.$title.'</h3>';
        }


        $b = debug_backtrace();

        array_shift($b);

        $a = array_shift($b);


       // array_shift($b);

        echo "<table class='table dump'><thead><tr><th>File</th><th>Line</th><th>Function</th><th>Args</th></tr></thead><tbody>";

        p($a, $title);


        foreach($b as $val) {
            p($val, $title);
        }

        echo "</tbody></table>";

        //print_r($b);
        //echo "</pre>";
    }


    /*
    |---------------------------------------------
    | GENERER UN CODE ALEATOIRE
    |---------------------------------------------
    */

    public static function generateRandomString($length = 10) {
        return substr(str_shuffle(uniqid()."0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public static function hashed_equals($a, $b) {
        return substr_count($a ^ $b, "\0") * 2 === strlen($a . $b);
    }

    public static function createPassword($value = null, $length = 6)
    {
        $password = [];

        if(empty($value)) $password['password'] = Lib::generateRandomString($length);
        else $password['password'] = $value;

        $password['hash'] = password_hash($password['password'], PASSWORD_BCRYPT);

        return $password;
    }

    public static function createToken() {
        return bin2hex(random_bytes(8));
    }

    /*
    |---------------------------------------------
    | VALIDATION
    |---------------------------------------------
    */

    // Email address verification, do not edit.
    public static function isEmail($email) {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
    }

    public static function isDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function isZipCode($zipCode) {
        return (preg_match('#^[0-9]{5}$#',$zipCode));
    }

}