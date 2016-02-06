<?php
namespace Framework;

class Application {
	public function run(){
		var_dump('public function run()');
		$pc = new \Blog\Controller\PostController();
	}
} 
