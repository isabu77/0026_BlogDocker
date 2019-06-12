<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
function isIsogram($word)
{
    $word = str_replace(['-', ' '], '', mb_strtolower($word));
    $letters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
    return count($letters) === count(array_unique($letters));
}