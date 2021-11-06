<?php

namespace application\core;

use application\core\View;

abstract class Controller
{
	public $path;
    public $userstatus;

	public function __construct($path) 
	{
        $this->path = $path;
	    $this->userstatus = ((isset($_SESSION['auth'])) && ($_SESSION['auth'] == 1)) ? 1 : 0;
	}

}