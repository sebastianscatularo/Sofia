<?php

namespace Sofia;

use ReflectionClass;

abstract class AbstractContainer implements Container {
    /**
     * Array of class metadata and singleton instances
     */
    private $container = array();
    
    /**
     * Method to register class data
     * 
     * @package Sofia
     * @author Sebastian Scatualro <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $className Class name included namespace if is necesary
     * @param string $methodFactory Static method to create a new instance
     * @return void
    */
    public function register($id, $className, $methodFactory = null) {
        $this->container[$id]["ClassName"] = $className;
        $this->container[$id]["MethodFactory"] = $methodFactory;
        $this->container[$id]["Instance"] = null;
        $this->container[$id]["Dependencies"] = null;
    }

    /** 
     * Method to set dependency relation between two or more classes
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param String $id Class identifier
     * @param array $dependencies Array of dependencies
     * @example array (
     *              array("Object" => "id"),
     *              array("String" => "value"),
     *              array("Number" => "value"),
     *              array("Bool" => "value")
     *          )
     * NOTE "respect the order"
     * @return void
    */
    public function inject($id, array $dependencies) {
        $this->container[$id]["Dependencies"] = $dependencies;
    }
    
    /** 
     * Method to set dependency relation between two classes
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected class identifier
     * @return void
    */
    public function injectObject($id, $object) {
        $this->container[$id]["Dependencies"][] = array("Object" => $object);
    }

    /** 
     * Method to set dependency relation between a class and String value
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected String value
     * @return void
    */
    public function injectString($id, $string) {
        $this->container[$id]["Dependencies"][] = array("String" => $string);
    }

    /** 
     * Method to set dependency relation between a class and Number value
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected Number value
     * @return void
    */
    public function injectNumber($id, $number) {
        $this->container[$id]["Dependencies"][] = array("Number" => $number);
    }

    /** 
     * Method to set dependency relation between a class and Boolean value
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected Boolean value
     * @return void
    */
    public function injectBoolean($id, $boolean) {
        $this->container[$id]["Dependencies"][] = array("Bool" => $boolean);
    }

    /** 
     * Method to get a new instance 
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @return object Object instance related to class identifier
    */
    public function get($id) {
        if($this->container[$id]["Instance"]) {
            return $this->container[$id]["Instance"];
        }
        
        $dependencies = array();
        if($this->container[$id]["Dependencies"]) {
            foreach($this->container[$id]["Dependencies"] as $dependency) {
                if(key($dependency) === "Object") {
                    $dependencies[] = $this->get($dependency["Object"]);
                } else if (key($dependency) === "String") {
                    $dependencies[] = $dependency["String"];
                } else if (key($dependency) === "Number") {
                    $dependencies[] = $dependency["Number"];
                } else if (key($dependency) === "Bool") {
                    $dependencies[] = $dependency["Bool"];
                }
            }
        }

        $class = new ReflectionClass($this->container[$id]["ClassName"]);
        $instance = null;
        
        if($this->container[$id]["MethodFactory"]) {
            $method = $this->container[$id]["MethodFactory"];
            $instance = $class->getMethod($method)->invokeArgs(null, $dependencies);
        } else {
            $instance = $class->newInstanceArgs($dependencies);
        }

        $this->container[$id]["Instance"] = $instance;
        return $instance;
    }    
}