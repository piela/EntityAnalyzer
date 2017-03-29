<?php

namespace TMSolution\ConfigurationBundle\Util;


class ConfigurationInterface {
    public function get($property);
    public function has($property);
    public function getData();
}
