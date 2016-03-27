<?php
/**    
 * Response.php
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

namespace Framework\Response;

class ResponseRedirect extends Response {
    public function __construct($url, $code = 302)
    {
	$this->code = $code;
        $this->setHeader('Location', $url);
        
        return $this;
    }
} 
