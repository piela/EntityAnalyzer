<?php

namespace TMSolution\ControllerConfigurationBundle\Util;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class ConfigurationInterface {
    public function get($property);
    public function has($property);
    public function getData();
}
