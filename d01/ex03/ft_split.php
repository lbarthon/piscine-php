<?php
    function filter($var) {
        return ($var !== "" && $var !== null && $var !== false);
    }

    function ft_split($str) {
        $array = explode(" ", $str);
        if ($array != null) {
            $array = array_filter($array, 'filter');
            sort($array, SORT_STRING);
        }
        return ($array);
    }
