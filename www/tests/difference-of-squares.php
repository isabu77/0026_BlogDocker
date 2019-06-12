<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
function squareOfSums($val)
{
    $res = 0;
    for ($i=0 ; $i <= $val ; $i++){
        $res += $i;
    }
    return ($res**2);
}

function sumOfSquares($val)
{
    $res = 0;
    for ($i=0 ; $i <= $val ; $i++){
        $res += $i**2;
    }
    return ($res);
}

function difference($val)
{
    return squareOfSums($val) - sumOfSquares($val);
}



