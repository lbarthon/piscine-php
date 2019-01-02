<?php
    function ft_is_sort(array $tab) {
        $sort = $tab;
        sort($sort);
        if ($tab != $sort)
            return false;
        else
            return true;
    }

