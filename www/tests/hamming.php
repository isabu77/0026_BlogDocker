<?php
function distance(string $string1, string $string2)
{
    if (strlen($string1) != strlen($string2)){
        throw new \Exception('Erreur ! ');
    }
    // strtolower passe une chaine en minuscules
    // str_pad complète une chaine jusqu'à une taille donnée
    // str_split convertit une chaine en tableau
    // array_diff_assoc — Calcule la différence de deux tableaux, en prenant aussi en compte les clés
    return count(array_diff_assoc(str_split(str_pad(strtolower($string1),strlen($string2)-strlen($string1),' ')), 
                                    str_split(str_pad(strtolower($string2),strlen($string1)-strlen($string2),' '))));
    
    //return count(array_diff_assoc(str_split($string1), str_split($string2)));
/*     
    $ret = 0;
    for ($i = 0 ; $i < strlen($string1); $i++){
        if ($string1[$i] != $string2[$i]){
            $ret++;
        }
    }
    return($ret); 
*/
}