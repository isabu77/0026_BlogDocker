<?php
//
// Calculates the date and time exactly 1 Giga seconds later.
function from(\DateTime $from)
{
    return (clone $from)->modify((10 ** 9) . ' sec');

    //$gs = clone $from;
   // return $gs->add(new DateInterval('PT1000000000S'));
}