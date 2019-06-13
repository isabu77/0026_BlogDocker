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
        // pour oter les balise html :
        $content = strip_tags($content);

        // si la chaine est plus petite que la limite, on la rend entière
        if (mb_strlen($content) <= $limit) {
            return $content;
        }

        // pour ne pas couper le dernier mot, on cherche le premier espace derrière la limite
        // $limit-1 pour gérer le cas d'un espace en position 100
        $lastSpace = mb_strpos($content, ' ', $limit-1);

        // cas d'une chaine sans espaces :
        if ($lastSpace == null)
            return mb_substr($content, 0, 36) . '...';

        // autres cas : on tronque à la limite et ajout des '...'
        return mb_substr($content, 0, $lastSpace) . '...';
        
    }
}
