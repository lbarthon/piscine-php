<?php
    class UnholyFactory {
        private $_absorbed = array();

        function absorb($fighter) {
            $parent = get_parent_class($fighter);
            if ($parent && $parent === "Fighter") {
                if (!in_array($fighter, $this->_absorbed)) {
                    $this->_absorbed[] = $fighter;
                    echo "(Factory absorbed a fighter of type " . $fighter->getName() . ")\n";
                } else {
                    echo "(Factory already absorbed a fighter of type " . $fighter->getName() . ")\n";
                }
            } else {
                echo "(Factory can't absorb this, it's not a fighter)\n";
            }
        }

        function fabricate($str) {
            foreach ($this->_absorbed as $absorbed) {
                if ($absorbed->getName() === $str) {
                    echo "(Factory fabricates a fighter of type " . $str . ")\n";
                    return clone $absorbed;
                }
            }
            echo "(Factory hasn't absorbed any fighter of type " . $str . ")\n";
            return null;
        }
    }
