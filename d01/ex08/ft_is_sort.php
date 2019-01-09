<?php
    function ft_is_sort(array $tab) {
        $copy = array();
        $sort = $tab;
        foreach ($tab as $value) {
            $copy[] = $value;
        }
        sort($sort);
        if ($copy != $sort)
            return false;
        return true;
    }
