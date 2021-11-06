<?php

namespace application\core;

use application\lib\Db;
use application\core\View;

class Router
{

	protected $page;
	protected $path;
    protected $routes = [];

	public function __construct($path)
	{	
		$this->path = $path;
		$this->page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$this->page = mb_substr($this->page, strlen($path));
	}

	public function run()
	{
		$this->routes = require'application/config/routes.php';
		if (isset($this->routes[$this->page])) {
			$path_controller = 'application\controllers\\' . $this->routes[$this->page]['controller'] . 'Controller';
			if (class_exists($path_controller)) {
				$action = $this->routes[$this->page]['action'].'Action';
			    if (method_exists($path_controller, $action)) {
                    $controller = new $path_controller($this->path);
                    $controller->$action();
                } else {
                    View::error(404);
                }
			} else {
				View::error(404);
			}
		} else {
            View::error(404);
        }
	}
}