<?php

# This file is generated, changes you make will be lost.
# Make your changes in src/Sprocket.pre instead.
                

namespace App;

class Sprocket {
        use AccessorTrait;

        private $bar;

    private function __get_bar() {
        return $this->bar . " got";
        
    }

    private function __set_bar($value) {
        $this->bar = strtoupper($value);
        
    }

    }
