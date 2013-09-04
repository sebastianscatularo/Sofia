<?php

require_once "Container.php";
require_once "SimpleContainer.php";

use Sofia\SimpleContainer;

class Args {
    public function __construct() {
        $this->args = "Some arg";
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
$container->inject("mock", array("args"));
$mock = $container->get("mock");
$args = $container->get("args");

var_dump($mock);
echo "<br>";
var_dump($args);
