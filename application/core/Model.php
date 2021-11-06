<?php

namespace application\core;

use application\services\Db;

abstract class Model extends Router
{
    public $db;
    
    public function __construct() {
        $this->db = new Db;
    }

}