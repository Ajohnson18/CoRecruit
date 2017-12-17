<?php

    function safe($string) {
        $string = str_replace('"', '\"', $string);
        $string = str_replace("'", "\'", $string);
        return $string;
    }

?>