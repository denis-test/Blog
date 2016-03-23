<?php
namespace Framework;

use Framework\Router\Router;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\AuthRequredException;
use Framework\Exception\BadResponseTypeException;
use Framework\Exception\DatabaseException;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\DI\Service;

/**    
 * Application.php
 * 
 * PHP version 5
 *
 * @category   Category Name
 * @package    Package Name
 * @subpackage Subpackage name
 * @author     dimmask <ddavidov@mindk.com>
 * @copyright  2011-2013 mindk (http://mindk.com). All rights reserved.
 * @license    http://mindk.com Commercial
 * @link       http://mindk.com
 */

class Application
{
	private $response;
	
        /**
         * 
         * @param type $config
         */
	public function __construct($config = null)
	{
		//service::init();
		\Loader::addNamespacePath('CMS\\',__DIR__.'/../src/CMS');
		
		service::set('configuration', function(){
						return new \Framework\Configuration();
					});
					
		service::get('configuration')->loadFile($config);
		
		service::set('db', function (){
						return new \Framework\Connection(service::get('configuration')->get('pdo'));
					});
		service::set('router', function (){
						return new \Framework\Router\Router();
					});
		service::set('request', function (){
						return new \Framework\Request\Request();
					});
		service::set('security', function (){
						return new \Framework\Security\Security();
					});
		service::set('session', function (){
						return new \Framework\Session\Session();
					});
		service::set('renderer', function (){
						return new \Framework\Renderer\Renderer(service::get('configuration')->get('main_layout'));
					});
		
		
		service::get('session');
		
	}
	
        /**
         * 
         * @throws HttpNotFoundException
         * @throws BadResponseTypeException
         */
	public function run()
	{
		$route = service::get('router')->parseRoute(service::get('request')->get('uri'));
		
		try{
			if(empty($route)) {
				throw new HttpNotFoundException('Route not found', 404);
			}
			
			$controllerReflection = new \ReflectionClass($route['controller']);
		        
		    $action = $route['action'] . 'Action';
		    
		    if($controllerReflection->hasMethod($action)){
				$controller = $controllerReflection->newInstance();
		        $actionReflection = $controllerReflection->getMethod($action);
		        $this->response = $actionReflection->invokeArgs($controller, $route['params']);
			        
		        if($this->response instanceof Response){
			    	$this->response->send();
		        } else {
			        throw new BadResponseTypeException('Result is not instance of Response');
		        }
	        }else{
		        throw new HttpNotFoundException('The method or controller not found', 404);
		    }
		}
		catch(BadResponseTypeException $e){
			$e->getResponse()->send();
        }
        catch(HttpNotFoundException $e){
			$e->getResponse()->send();
        }
        catch(DatabaseException $e){
	    	$e->getMessage();
        }
        catch(AuthRequredException $e){
	    	$e->getResponse()->send();
        }
        catch(\Exception $e){
	        $e->getMessage();
        }
    }
} 
