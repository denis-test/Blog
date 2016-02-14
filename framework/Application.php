<?php
namespace Framework;

/*
 * Class Application
 */
class Application {
	public function run(){
		$router = new Router(include('../app/config/routes.php'));
		$route =  $router->parseRoute($_SERVER['REQUEST_URI']);
		if(!empty($route)){
			echo 'Route was found';
		} else {
			echo 'Route was not found';
		}
	}
} 
