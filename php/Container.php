<?php

namespace Sofia;

interface Container {
    public function register($id, $className, $methodFactory = null);
    public function inject($id, array $dependencies);
    public function get($id);
}