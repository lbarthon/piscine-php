<?php
    require_once 'Color.class.php';
    Class Vertex {
        public static $verbose = false;
        private $_x;
        private $_y;
        private $_z;
        private $_w = 1.0;
        private $_color;

        public function getX() { return $this->_x; }
        public function getY() { return $this->_y; }
        public function getZ() { return $this->_z; }
        public function getW() { return $this->_w; }
        public function getColor() { return $this->_color; }
    
        public function setX($val) { $this->_x = $val; }
        public function setY($val) { $this->_y = $val; }
        public function setZ($val) { $this->_z = $val; }
        public function setW($val) { $this->_w = $val; }
        public function setColor($val) { $this->_color = $val; }

        function doc() {
            if (file_exists("Vertex.doc.txt")) {
                return file_get_contents("Vertex.doc.txt");
            }
            return "";
        }

        function __construct(array $arr) {
            $this->_x = $arr['x'];
            $this->_y = $arr['y'];
            $this->_z = $arr['z'];
            if (array_key_exists('w', $arr)) $this->_w = $arr['w'];
            if (array_key_exists('color', $arr)) $this->_color = $arr['color'];
            else $this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
            if (self::$verbose) {
                echo $this . " constructed\n";
            }
        }

        function __destruct() {
            if (self::$verbose) {
                echo $this . " destructed\n";
            }
        }

        function __toString() {
            if (self::$verbose) {
                return 'Vertex( x: ' . number_format((float)$this->_x, 2, '.', '') . ', y: ' . number_format((float)$this->_y, 2, '.', '') . ', z:' . number_format((float)$this->_z, 2, '.', '') . ', w:' . number_format((float)$this->_w, 2, '.', '') . ', ' . $this->_color . ' )';
            } else {
                return 'Vertex( x: ' . number_format((float)$this->_x, 2, '.', '') . ', y: ' . number_format((float)$this->_y, 2, '.', '') . ', z:' . number_format((float)$this->_z, 2, '.', '') . ', w:' . number_format((float)$this->_w, 2, '.', '') . ' )';
            }
        }
    }