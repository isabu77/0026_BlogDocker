<?php
//
// This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
// convenience to get you started writing code faster.
//
class Bob
{
    /**
     * Respond to an input string
     *
     * @param string $str
     * @return string
     */
    public function respondTo($statement)
    {
        // correction de Kevin :
        if (ctype_upper($statement) || (strtoupper($statement) === $statement && preg_match('/[A-Z]/', $statement)))
            return "Whoa, chill out!";

        if(substr(trim($statement), -1) === '?')
            return "Sure.";

        if (!trim($statement)) 
            return 'Fine. Be that way!';
        
        return "Whatever.";
    }

 /*     correction trouvée sur 
        https://exercism.io/tracks/php/exercises/bob/solutions/d7a9428801f1401fbb060f6a57b83b48
         if ($this->isEmpty($statement)) {
            return "Fine. Be that way!";
        } else if ($this->isShouting($statement)) {
            return "Whoa, chill out!";
        } else if ($this->isQuestion($statement)) {
            return "Sure.";
        } else {
            return "Whatever.";
        }
    
    private function isQuestion($statement) {
        if (str_split(trim($statement))[strlen(trim($statement)) - 1] == "?") {
            return true;
        }
        return false;
    }

    private function isShouting($statement) {
        if (mb_strtoupper($statement) == $statement && 
            preg_match("/[a-z]/i", $statement) > 0) {
            return true;
        }
        return false;
    }

    private function isEmpty($statement) {
        if (trim(preg_replace("/\s+/u", "", $statement)) == "") {
            return true;
        }
        return false;
    }
    */ 
}
