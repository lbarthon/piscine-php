<?php
    function ft_split($str) {
        $array = explode(" ", $str);
        if ($array != null) {
            $array = array_filter($array);
            sort($array);
        }
        return ($array);
    }
?>