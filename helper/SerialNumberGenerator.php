<?php

namespace CodeYourFuture\Helper;

use \Rundiz\SerialNumberGenerator\SerialNumberGenerator as Keygen;

class SerialNumberGenerator extends Keygen{
    
    public function __construct() {
        parent::__construct();
        $this->numberChunks = 4;
        $this->numberLettersPerChunk = 4;
    }
}