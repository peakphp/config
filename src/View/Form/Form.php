<?php
namespace Peak\View\Form;

use Peak\Exception;
use Peak\View\Helper;

/**
 * Link helper
 */
class Form extends Helper
{

    /**
     * $_data
     * @var array
     */
    protected $_data = [];

    /**
     * Form errors
     * @var array
     */
    protected $_errors = [];

    /**
     * Set also the data
     * 
     * @param array $data
     */
    public function __construct($data = [], $errors = [])
    {
        parent::__construct();
        $this->setData($data);
        $this->setErrors($errors);
    }
    
    /**
     * Set data
     */
    public function setData($data)
    {
        $d = [];
        if(is_object($data)) {
            foreach($data as $k => $v) {
                $d[$k] = $v;
            }
        }
        else {
            $d = $data;
        }

        $this->_data = $d;
        return $this;
    }

    /**
     * Set errors
     * @param
     */
    public function setErrors($errors)
    {
        $this->_errors = $errors;
        return $this;
    }

    /**
     * Load a form control
     * 
     * @param  string $type   
     * @param  string $name   
     * @param  array  $options
     * @return object       
     */
    public function control($type, $name, $options = [])
    {
        $cname = 'Peak\View\Form\Control\\'.$type;

        $data = $this->get($name);
        $error = $this->getError($name);

        if(class_exists($cname)) {
            return new $cname($name, $data, $options, $error);
        }
        else {
            throw new Exception('Form control type '.$type.' not found');
        }
    }

    /**
     * Get a data value if exists
     * 
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        $name = strtolower($name);
        if(is_array($this->_data) && array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return null;
    }

    /**
     * Get error
     * @param  string $name 
     * @return string       
     */
    public function getError($name)
    {
        if(is_array($this->_errors) && array_key_exists($name, $this->_errors)) {
            return $this->_errors[$name];
        }
        return null;
    }
}