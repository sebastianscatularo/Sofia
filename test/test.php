<?php

require_once "../php/Sofia/Container.php";
require_once "../php/Sofia/AbstractContainer.php";
require_once "../php/Sofia/SimpleContainer.php";

use Sofia\SimpleContainer;

class SimpleClass {
    private $string;
    private $number;
    private $boolean;

    public function __construct($string, $number, $boolean) {
        $this->string = $string;
        $this->number = $number;
        $this->boolean = $boolean;
    }

    public function getString() {
        return $this->string;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getBool() {
        return $this->boolean;
    }    
}

class MethodFactoryClass {
    public static function getInstance() {
        return new static();
    }
}

class ComposedClass {
    private $simpleClass;
    private $methodFactory;

    public function __construct(SimpleClass $simpleClass, MethodFactoryClass $methodFactoryClass) {
        $this->simpleClass = $simpleClass;
        $this->methodFacotry = $methodFactoryClass;
    }

    public function getSimpleClass() {
        return $this->simpleClass;
    }

    public function getMethodFactoryClass() {
        return $this->methodFactory;
    }
}

/** 
 * Examples!
*/
echo "<h1> Test </h1>";
try {
    echo "<h2> Started </h2>";
    $container = new SimpleContainer();
    $container->register("simpleClass","SimpleClass");
    $container->register("methodFactory","MethodFactoryClass", "getInstance");
    $container->register("composedClass", "ComposedClass");

    $container->injectString("simpleClass", "String Value");
    $container->injectNumber("simpleClass", 100);
    $container->injectBoolean("simpleClass", true);

    $container->injectObject("composedClass", "simpleClass");
    $container->injectObject("composedClass", "methodFactory");

    $simpleClass = $container->get("simpleClass");
    $methodFactory = $container->get("methodFactory");
    $composedObject = $container->get("composedClass");
    
    if($simpleClass instanceof SimpleClass) {
        if(is_string($simpleClass->getString())) {
            echo "String injected: " . $simpleClass->getString() . "<br/>";
        } else {
            echo "Filed injecting string";
        }
        if (is_numeric($simpleClass->getNumber())) {
            echo "Number injected: " . $simpleClass->getNumber() . "<br/>";
        } else {
            echo "Filed injecting numeric";
        }
        if (is_bool($simpleClass->getBool())) {
            echo "Boolean injected: " . $simpleClass->getBool() . "<br/>";
        } else {
            echo "Filed injecting boolean";
        }
    } else {
        throw new \Exception("simple class is not a SimpleClass instance");
    };
    if($methodFactory instanceof MethodFactoryClass) {
        echo "Class instance created successful with method factory <br/>";
    } else {
        throw new \Exception("fail method factory instance");
    }
    if($composedObject instanceof ComposedClass) {
        echo "Composed Class instance created successful <br/>";
    } else {
        throw new \Exception("fail composed class instance");
    }
    
} catch(\Exception $e) {
    echo "<h2>Test failed</h2>\n";
    echo "<h3>Trace: </h3>\n";
    print_r($e);
}