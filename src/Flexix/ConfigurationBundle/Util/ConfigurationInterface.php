<?php

namespace Flexix\ConfigurationBundle\Util;


interface ConfigurationInterface {
    public function get($property);
    public function has($property);
    public function getData();
}
