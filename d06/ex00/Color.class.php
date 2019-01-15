<?php
    Class Color {
        public static $verbose = False;
        public $red = 0;
        public $green = 0;
        public $blue = 0;

        public static function doc() {
            if (file_exists("Color.doc.txt")) {
                return file_get_contents("Color.doc.txt");
            }
            return "";
        }

        private static function addSpaces($nbr, $len = 3) {
            $var = (string)$nbr;
            while (strlen($var) < $len) {
                $var = ' ' . $var;
            }
            return $var;
        }

        function __construct(array $arr) {
            if (array_key_exists('red', $arr) && array_key_exists('green', $arr) && array_key_exists('blue', $arr)) {
                $this->red = (int)$arr['red'];
                $this->green = (int)$arr['green'];
                $this->blue = (int)$arr['blue'];
            } else if (array_key_exists('rgb', $arr)) {
                $this->blue = $arr['rgb'] % 256;
                $arr['rgb'] /= 256;
                $this->green = $arr['rgb'] % 256;
                $arr['rgb'] /= 256;
                $this->red = $arr['rgb'] % 256;
            }
            if (self::$verbose) {
                echo $this . " constructed.\n";
            }
        }

        function __destruct() {
            if (self::$verbose) {
                echo $this . " destructed.\n";
            }
        }

        function __toString() {
            return 'Color( red: ' . $this->addSpaces($this->red) . ', green: ' . $this->addSpaces($this->green) . ', blue: ' . $this->addSpaces($this->blue) . ' )';
        }

        function add(Color $color) {
            return new Color( array(
                'red' => $this->red + $color->red,
                'green' => $this->green + $color->green,
                'blue' => $this->blue + $color->blue
            ) );
        }

        function sub(Color $color) {
            return new Color( array(
                'red' => $this->red - $color->red,
                'green' => $this->green - $color->green,
                'blue' => $this->blue - $color->blue
            ) );
        }

        function mult($nbr) {
            return new Color( array(
                'red' => $this->red * $nbr,
                'green' => $this->green * $nbr,
                'blue' => $this->blue * $nbr
            ) );
        }
    }
