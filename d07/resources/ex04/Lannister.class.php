<?php
    class Lannister {
        function sleepWith($people) {
            $class = get_class($people);
            $parent = get_parent_class($people);
            if ($class && $parent) {
                if ($parent === "Lannister") {
                    if ($class === "Cersei") echo static::getCerseiMsg() . "\n";
                    else echo static::getNoMsg() . "\n";
                } else if ($parent === "Stark") {
                    echo static::getYesMsg() . "\n";
                }
            }
        }

        function getNoMsg() {
            return "Not even if I'm drunk !";
        }

        function getCerseiMsg() {
            return "Not even if I'm drunk !";
        }

        function getYesMsg() {
            return "Let's do this.";
        }
    }
