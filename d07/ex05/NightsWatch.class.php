<?php
    class NightsWatch {
        private $_members = array();

        function recruit($member) {
            $this->_members[] = $member;
        }

        function fight() {
            foreach ($this->_members as $member) {
                $implements = class_implements($member);
                if ($implements && in_array("IFighter", $implements)) {
                    $member->fight();
                }
            }
        }
    }
