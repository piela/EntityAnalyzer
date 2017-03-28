<?php

namespace TMSolution\EntityAnalyzerBundle\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TMSolution\EntityAnalyzerBundle\Util\EntityAnalyzer;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz
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

    public function testGetEntityAnalyzeBody() {
        var_dump(self::$entityAnalyzer->getEntityAnalyze());
    }

}
