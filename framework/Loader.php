<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
var_dump('Hello!');


class Loader{
	protected static $instance = null;
	protected static $namespaces = array();
	
	
	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	
	public static function load($classname){
		// @TODO: Add here some registered $namespaces processing...
		$str_pos = strpos ($classname , '\\');
		$sub_str = substr($classname, 0, $str_pos + 1);
				
		if(isset(self::$namespaces[$sub_str])){
			$path = substr_replace($classname, self::$namespaces[$sub_str], 0, $str_pos);
			$path = str_replace("\\","/", $path) . '.php';
			
			if(file_exists($path)){
				include_once($path);
			}
			return;
		}
		
		$path = str_replace('Framework','',$classname);
		$path = __DIR__ . str_replace("\\","/", $path) . '.php';
		if(file_exists($path)){
			include_once($path);
		}
	}
	
	
	private function __construct(){
		// Init
		spl_autoload_register(array(__CLASS__, 'load'));
	}
	
	
	private function __clone(){
		// lock
	}
	
	
	public static function addNamespacePath($name, $path){
		//@TODO: Add here your code
		$path = realpath($path);
		self::$namespaces[$name] = $path;
	}
}
Loader::getInstance();
