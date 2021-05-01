<?php
namespace Coalition;

class ConfigRepository implements \ArrayAccess
{
    public $container = array();
    // private $fileName = "test_arr.txt";
    /**
     * ConfigRepository Constructor
     */
    public function __construct($init = array())
    {
       if(isset($init))
       {
            $this->container = $init;
       }
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Determine whether the config array contains the given key
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key,$this->container);
    }

    /**
     * Set a value on the config array
     *
     * @param string $key
     * @param mixed  $value
     * @return \Coalition\ConfigRepository
     */
    public function set($key, $value)
    {
        if(!is_array($value))
        {
            $this->$container[$key]=$value;
        }
        else
        {
            foreach ($value as $tmpKey => $tmpValue) {
                array_push($this->$container[$key], $tmpValue);    
            }
        }

        return $this;
    }

    /**
     * Get an item from the config array
     *
     * If the key does not exist the default
     * value should be returned
     *
     * @param string     $key
     * @param null|mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if(isset($this->container[$key]))
        {
            return $this->container[$key];    
        }
        else
        {
            return $default;
        }
    }

    /**
     * Remove an item from the config array
     *
     * @param string $key
     * @return \Coalition\ConfigRepository
     */
    public function remove($key)
    {
        unset($this->container[$key]);
        return $this;
    }

    /**
     * Load config items from a file or an array of files
     *
     * The file name should be the config key and the value
     * should be the return value from the file
     * 
     * @param array|string The full path to the files $files
     * @return void
     */
    public function load($files)
    {
        $tmpFiles = array();
        if(!is_array($files))
        {
            $tmpFiles[]=$files;
        }
        else
        {
            $tmpFiles=$files;
        }

        foreach ($tmpFiles as $key => $fileName) {
            $tmpFinalKey = explode(".",basename($fileName));
            $tmpFinalKey = $tmpFinalKey[0];
            $this->container[$tmpFinalKey]= include $fileName;
        }
    }
}