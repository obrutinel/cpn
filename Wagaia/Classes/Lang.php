<?php

namespace Wagaia;

class Lang
{
	public static $lg = array(
		'fr' => 'Français',
		'en' => 'English',
		'vn' => 'Tiếng Việt',
		'ru' => 'Руский',
		'ar' => '‫العربية',
		'cn' => '‫中文'
		);
    /*
    |---------------------------------------------
    | Traductions
    |---------------------------------------------
    | Sur le principe de Symfony translation sauf qu'ici on cherche dans une variable globale traduction array $trans /config/traductions.php,
	| ex : ['term'] => mot|mots' (ou 'mot')
	| (str) $mot - le mot à traduire
	| (int) $plural - entier, pour pluriel ou singulier
	| 2 helpers dans /panel/lib/functions.php : trans & plural
    */

	public static function trans($term, $plural=false)
    {
        global $trans, $lg;
				
        $t = null;

        if (array_key_exists($term, $trans[$lg])) {

            $traduction = $term = $trans[$lg][$term];


            if (strpos($traduction, '|')) {

                $t = explode('|', $traduction);
                $term = current($t);

            }

            if ($plural && is_array($t) && ($plural > 1)) {
                return $t[1];
            }

        }
        return $term;
    }
}
