<?php

namespace TMSolution\MapperBundle\Tests\Generator;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TMSolution\MapperBundle\Generator\Mapper;

class MapperTest extends KernelTestCase  {

    protected static $classMapper;

    static public function setUpBeforeClass() {
        self::bootKernel();
        $manager = static::$kernel->getContainer()->get('doctrine')->getManager();
        self::$classMapper = new Mapper(__DIR__ . DIRECTORY_SEPARATOR . 'mapper.yml', $manager);
    }

    public function testUpdateConfigFile() {
        self::$classMapper->updateConfigFile();
    }

}
