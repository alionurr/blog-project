<?php


class Slugger
{
    public static function createSlug($string){
        $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ");//turkish letters
        $english   = array("i", "g", "u", "s", "o", "c", "I");//english cooridinators letters

        $finalTitle = str_replace($turkish, $english, $string);//replace php function
        $finalTitle = strtolower($finalTitle);

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $finalTitle);
        $slug=preg_replace('/-$/', '', $slug);

        return $slug;
    }
}