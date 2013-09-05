<?php

require_once "../php/Sofia/Container.php";
require_once "../php/Sofia/AbstractContainer.php";
require_once "../php/Sofia/SimpleContainer.php";

use Sofia\SimpleContainer;

class Args {
    public function Args($string) {
        $this->string = $string;
    }
}

class Mock {
    public function Mock(Args $args) {
        $this->args = $args;
    }
}

class StaticClass {
    public static function doSomething(Args $args) {
        return $args;
    }
}


$container = new SimpleContainer();

$container->register("mock","Mock");
$container->register("static","StaticClass", "doSomething");
$container->register("args", "Args");
$container->injectString("args", "Some String injected");
$container->injectObject("mock", "args");
$container->injectObject("static", "args");
//$container->inject("mock", array("Object"=>array("args")));
$mock = $container->get("mock");
$args = $container->get("args");
$stat = $container->get("static");

var_dump($mock);
echo "<hr>";
var_dump($args);
echo "<hr>";
var_dump($stat);