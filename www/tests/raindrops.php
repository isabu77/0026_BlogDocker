<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
function raindrops($num)
{
    $string = !($num % 3) ? 'Pling' : '';
    $string .= !($num % 5) ? 'Plang' : '';
    $string .= !($num % 7) ? 'Plong' : '';
    return $string ? $string : strval($num);
}
