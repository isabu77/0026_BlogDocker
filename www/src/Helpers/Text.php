<?php
namespace App\Helpers;

/**
 *  Classe Text   
 * @var string
 * @access public
 * @static
 **/
class Text
{
    /**
     *  extrait du contenu
     * @param string
     * @param int
     * @return string
     * @access public
     * @static
     **/
    public static function excerpt(string $content, int $limit = 100): string
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }
        // limite + un mot pour ne pas couper le dernier mot
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}
