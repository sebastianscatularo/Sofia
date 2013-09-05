<?php

namespace Sofia;

interface Container {
    public function register($id, $className, $methodFactory = null);
    public function inject($id, array $dependencies);
    public function injectObject($id, $object);
    public function injectString($id, $string);
    public function injectNumber($id, $number);
    public function injectBoolean($id, $boolean);
    public function get($id);
}