<?php
/**    
 * NotBlank.php
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

namespace Framework\Validation\Filter;

class NotBlank implements ValidationFilterInterface {
    public $error = null;
    
    /**
     * 
     * @param type $value
     * @return type
     */
    public function isValid($value){
        $result = !empty($value);
        
        if (!$result) {
            $this->error = 'The field must not be blank';
        }

        return $result;
    }
    
    /**
     * 
     * @return type
     */
    public function getError()
    {
        return $this->error;
    }
} 
