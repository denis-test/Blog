<?php
/**
 * Length.php
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

class Length implements ValidationFilterInterface {
    protected $min;
    protected $max;
    protected $error = null;

    /**
     * @param $min
     * @param $max
     */
    public function __construct($min, $max){
        $this->min = $min;
        $this->max = $max;
    }
    
    /**
     * 
     * @param type $value
     * @return type
     */
    public function isValid($value){
        $result = (strlen($value)>=$this->min) && (strlen($value)<=$this->max);

        if (!$result) {
            $this->error = 'The length should be no less than '.$this->min.' and not more than '.$this->max;
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
