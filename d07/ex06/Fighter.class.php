<?php
    abstract class Fighter {
        private $_name;

        public function getName() {
            return $this->_name;
        }

        function __construct($str) {
            $this->_name = $str;
        }

        abstract function fight($target);
    }
