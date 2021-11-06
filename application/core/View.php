<?php

namespace application\core;

class View
{

	public function render($vars = [])
	{
		extract($vars);
		$ppath = 'application/views/blocks/'.$vars['block'].'.php';
		if (file_exists($ppath)) {
			ob_start();
			require $ppath;
			$content = ob_get_clean();
			require 'application/views/layots/template.php';
		}
	}

	public function renderBlock($vars = [])
	{
		extract($vars);
		$ppath = 'application/views/blocks/'.$vars['block'].'.php';
		if (file_exists($ppath)) {
			ob_start();
			require $ppath;
			$content = ob_get_clean();
			return $content;
		}
	}

	public static function error($code, $error = null)
	{
		http_response_code($code);
		$ppath = 'application/views/errors/'.$code.'.php';
		if (file_exists($ppath)) {
			require $ppath;
		}
		exit;
	}

	public function message($status, $message) 
	{
		exit(json_encode(['status' => $status, 'message' => $message]));
	}

}