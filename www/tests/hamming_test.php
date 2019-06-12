<?php
use PHPUnit\Framework\TestCase;

require "hamming.php";

class HammingComparatorTest extends TestCase
{
    public function testNoDiffBetweenIdenticalStrands()
    {
        $this->assertEquals(0, distance('a', 'a'));
    }
    public function testCompleteHammingDistanceOfSingleNucleotedStrands()
    {
        $this->assertEquals(1, distance('b', 'c'));
    }
    public function testCompleteHammingDistanceForSmallStrand()
    {
        $this->assertEquals(2, distance('ab', 'cd'));
    }
    public function testSmallHammingDistance()
    {
        $this->assertEquals(1, distance('at', 'bt'));
    }
    public function testHammingDistanceWithDifferentLength()
    {
        //$this->expectException(\Exception::class);
        $this->expectExceptionMessage("Les 2 chaines doivent avoir la même longueur");
        $this->assertEquals(4, distance('GGACG', 'AGGACGTGG'));
    }

}
