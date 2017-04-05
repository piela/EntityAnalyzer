<?php

namespace TMSolution\EntityAnalyzerBundle\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TMSolution\EntityAnalyzerBundle\Util\EntityAnalyzer;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class EntityAnalyzerTest extends KernelTestCase {

    static protected $entityAnalyzer;

    static public function setUpBeforeClass() {
        self::bootKernel();
        $orm = static::$kernel->getContainer()
                ->get('doctrine');

        $entityClass = 'TMSolution\SampleEntitiesBundle\Entity\ProductDefinition';
        self::$entityAnalyzer = new EntityAnalyzer($orm, $entityClass);
    }

    public function testGetEntityAnalyze() {
        $this->assertInstanceOf('TMSolution\EntityAnalyzerBundle\Util\EntityAnalyze', self::$entityAnalyzer->getEntityAnalyze());
    }

   

}
