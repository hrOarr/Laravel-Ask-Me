<?php

namespace App\Classes;

class Url
{
   private static $slug;
   private static $str;

   public static function get_slug($str){
      self::$slug = self::clean_string($str);
      return self::$slug;
   }
   
   // SEO friendly slug

   private static function clean_string($str)
    {
        $str = strtolower(strip_tags(trim($str)));

        // Preserve escaped octets.
        $str = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $str);

        // Remove percent signs that are not part of an octet.
        $str = str_replace('%', '', $str);

        // Restore octets.
        $str = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $str);
        $str = preg_replace('/&.+?;/', '', $str); // kill entities
        $str = str_replace('.', '-', $str);

        $str = preg_replace('/[^%a-z0-9 _-]/', '', $str);
        $str = preg_replace('/\s+/', '-', $str);
        $str = preg_replace('|-+|', '-', $str);
        $str = trim($str, '-');

        return $str;
    }
}