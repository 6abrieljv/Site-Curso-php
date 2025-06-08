<?php
namespace App\Utils;

class StringUtils
{
    public static function slugify(string $text): string
    {
        // Substitui acentos e caracteres especiais
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        // Converte para minúsculas
        $text = strtolower($text);
        // Remove caracteres que não são letras, números ou espaços/hífens
        $text = preg_replace('/[^a-z0-9_ \-]/', '', $text);
        // Substitui espaços e underscores por hífens
        $text = preg_replace('/[\s_]+/', '-', $text);
        // Remove hífens duplicados
        $text = preg_replace('/-+/', '-', $text);
        // Remove hífens do início e do fim
        $text = trim($text, '-');

        return $text;
    }
}