<?php
    require_once 'Vertex.class.php';
    Class Vector {
        public static $verbose = false;
        private $_x;
        private $_y;
        private $_z;
        private $_w = 0;

        public function getX() { return $this->_x; }
        public function getY() { return $this->_y; }
        public function getZ() { return $this->_z; }
        public function getW() { return $this->_w; }

        function doc() {
            if (file_exists("Vector.doc.txt")) {
                return file_get_contents("Vector.doc.txt");
            }
            return "";
        }

        function __construct(array $arr) {
            $dest = $arr['dest'];
            if (array_key_exists('orig', $arr)) $orig = $arr['orig'];
            else $orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
            $this->_x = $dest->getX() - $orig->getX();
            $this->_y = $dest->getY() - $orig->getY();
            $this->_z = $dest->getZ() - $orig->getZ();
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
            return 'Vector( x:' . number_format((float)$this->_x, 2, '.', '') . ', y:' . number_format((float)$this->_y, 2, '.', '') . ', z:' . number_format((float)$this->_z, 2, '.', '') . ', w:' . number_format((float)$this->_w, 2, '.', '') . ' )';
        }

        function magnitude() {
            return sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2));
        }

        function normalize() {
            $magnitude = $this->magnitude();
            return new Vector(
                array('dest' => new Vertex(
                    array(
                        'x' => $this->_x / $magnitude,
                        'y' => $this->_y / $magnitude,
                        'z' => $this->_z / $magnitude
                        )
                    )
                )
            );
        }

        function add(Vector $rhs) {
            return new Vector(
                array('dest' => new Vertex(
                    array(
                        'x' => $this->_x + $rhs->getX(),
                        'y' => $this->_y + $rhs->getY(),
                        'z' => $this->_z + $rhs->getZ()
                        )
                    )
                )
            );
        }

        function sub(Vector $rhs) {
            return new Vector(
                array('dest' => new Vertex(
                    array(
                        'x' => $this->_x - $rhs->getX(),
                        'y' => $this->_y - $rhs->getY(),
                        'z' => $this->_z - $rhs->getZ()
                        )
                    )
                )
            );
        }

        function opposite() {
            return new Vector(
                array('dest' => new Vertex(
                    array(
                        'x' => $this->_x * -1,
                        'y' => $this->_y * -1,
                        'z' => $this->_z * -1
                        )
                    )
                )
            );
        }

        function scalarProduct($k) {
            return new Vector(
                array('dest' => new Vertex(
                    array(
                        'x' => $this->_x * $k,
                        'y' => $this->_y * $k,
                        'z' => $this->_z * $k
                        )
                    )
                )
            );
        }

        function dotProduct(Vector $rhs) {
            $x = $this->_x * $rhs->getX();
            $y = $this->_y * $rhs->getY();
            $z = $this->_z * $rhs->getZ();
            return ($x + $y + $z);
        }

        function cos(Vector $rhs) {
            return (($this->_x * $rhs->getX() + $this->_y * $rhs->getY() + $this->_z * $rhs->getZ())
                / sqrt((pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)) *
                (pow($rhs->getX(), 2) + pow($rhs->getY(), 2) + pow($rhs->getZ(), 2))));
        }

        function crossProduct(Vector $rhs) {
            return new Vector(
                array('dest' => new Vertex(
                    array(
                        'x' => $this->_y * $rhs->getZ() - $this->_z * $rhs->getY(),
                        'y' => $this->_z * $rhs->getX() - $this->_x * $rhs->getZ(),
                        'z' => $this->_x * $rhs->getY() - $this->_y * $rhs->getX()
                        )
                    )
                )
            );
        }
    }
