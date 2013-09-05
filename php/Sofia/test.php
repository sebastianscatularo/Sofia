<?php

require_once "Container.php";
require_once "SimpleContainer.php";

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


$container = new SimpleContainer();

$container->register("mock","Mock");
$container->register("args", "Args");
$container->injectString("args", "Some String injected");
$container->injectObject("mock", "args");
//$container->inject("mock", array("Object"=>array("args")));
$mock = $container->get("mock");
$args = $container->get("args");

var_dump($mock);
echo "<br>";
var_dump($args);
