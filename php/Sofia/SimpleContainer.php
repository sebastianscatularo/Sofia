<?php

namespace Sofia;

use ReflectionClass;

class SimpleContainer  implements Container {
    private $container = array();
    public function register($id, $className, $methodFactory = null) {
        $this->container[$id]["ClassName"] = $className;
        if($methodFactory) {
            $this->container[$id]["MethodFactory"] = $methodFactory;
        }
    }

    public function inject($id, array $dependencies) {
        $this->container[$id]["Dependencies"] = $dependencies;
    }

    public function get($id) {
        if($this->container[$id]["Instance"]) {
            return $this->container[$id]["Instance"];
        }
        
        $dependencies = array();
        if($this->container[$id]["Dependencies"]) {
            foreach($this->container[$id]["Dependencies"] as $dependency) {
                $dependencies[] = $this->get($dependency);
            }
        }

        $class = new ReflectionClass($this->container[$id]["ClassName"]);
        
        $this->container[$id]["Instance"] = $class->newInstanceArgs($dependencies);
        return $this->container[$id]["Instance"];
    }
}