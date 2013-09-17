Sofia
=====

Simple and Small Dependency Injector

```php

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
```
