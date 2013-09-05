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
    
    public function injectObject($id, $object) {
        $this->container[$id]["Dependencies"][] = array("Object" => $object);
    }

    public function injectString($id, $string) {
        $this->container[$id]["Dependencies"][] = array("String" => $string);
    }

    public function injectNumber($id, $number) {
        $this->container[$id]["Dependencies"][] = array("Number" => $number);
    }

    public function injectBoolean($id, $boolean) {
        $this->container[$id]["Dependencies"][] = array("Bool" => $boolean);
    }

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
        
        $this->container[$id]["Instance"] = $class->newInstanceArgs($dependencies);
        return $this->container[$id]["Instance"];
    }
}