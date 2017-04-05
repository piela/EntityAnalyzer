<?php

namespace TMSolution\GeneratorBundle\Util;

/**
 * Description of Generator
 *
 * @author Mariusz
 */
class Template {

    public static function load($templatePath) {
        return file_get_contents($templatePath);
    }
    
    public static function save($filename, $template) {
        return file_put_contents($filename, $template);
    }

}
