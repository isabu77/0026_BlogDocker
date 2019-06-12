<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
function isPangram($string)
{
    /**
     * solution de Kevin :
     */
    $letters = str_split(strtolower($string));

    /**
     * solution trouvée sur 
     * https://github.com/exercism/php/blob/master/exercises/pangram/example.php
     */
    //$string = str_replace(['-', ' '], '', mb_strtolower($string));
    //$letters = preg_split('//u', $string);
    $alphabet = str_split('abcdefghijklmnopqrstuvwxyz');
    return count(array_intersect($alphabet, $letters)) === count($alphabet);
}
