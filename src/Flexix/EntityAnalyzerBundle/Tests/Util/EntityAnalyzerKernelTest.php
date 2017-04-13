<?php

namespace Flexix\EntityAnalyzerBundle\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Flexix\EntityAnalyzerBundle\Util\EntityAnalyzer;


/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class EntityAnalyzerKrenelTest extends KernelTestCase {

    static protected $entityAnalyzer;

    static public function setUpBeforeClass() {
        self::bootKernel();
        $orm = static::$kernel->getContainer()
                ->get('doctrine');

        $entityClass = 'Flexix\SampleEntitiesBundle\Entity\ProductDefinition';
        self::$entityAnalyzer = new EntityAnalyzer($orm, $entityClass);
    }

    public function testGetEntityAnalyze() {
        $this->assertInstanceOf('Flexix\EntityAnalyzerBundle\Util\EntityAnalyze', self::$entityAnalyzer->getEntityAnalyze());
    }
    
    

   

}
