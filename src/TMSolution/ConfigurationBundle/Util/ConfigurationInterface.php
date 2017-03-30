<?php

namespace TMSolution\ConfigurationBundle\Util;


interface ConfigurationInterface {
    public function get($property);
    public function has($property);
    public function getData();
}
