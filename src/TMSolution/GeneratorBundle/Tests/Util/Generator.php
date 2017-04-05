<?php

namespace TMSolution\GeneratorBundle\Test\Util;

/**
 * Description of Generator
 *
 * @author Mariusz
 */
class Generator {

    protected $engine;

    public function __construct(Twig_LoaderInterface $engine) {

        $this->engine = $engine;
    }

    public function generate($template, $data) {
        return $this->engine->render($template, $data);
    }

}
