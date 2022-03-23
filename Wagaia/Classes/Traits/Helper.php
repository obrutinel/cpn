<?php

namespace Wagaia\Traits;


trait Helper
{
    public static function truncate($text, $chars = 120) {

        if (strlen($text) <= $chars) {
            return $text;
        }

        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";

        return $text;

    }

}