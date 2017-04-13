<?php

namespace Flexix\EntityAnalyzerBundle\Tests\Util;

use Symfony\Component\Yaml\Yaml;
use \Flexix\EntityAnalyzerBundle\Util\EntityAnalyzer;
use \Flexix\EntityAnalyzerBundle\Util\EntityAnalyze;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class EntityAnalyzeKrenelTest extends KernelTestCase {

    static protected $entityAnalyzer;
    static protected $orm;

    static public function setUpBeforeClass() {
        self::bootKernel();
        self::$orm = static::$kernel->getContainer()
                ->get('doctrine');

        $entityClass = 'Flexix\SampleEntitiesBundle\Entity\ProductDefinition';
        self::$entityAnalyzer = new EntityAnalyzer(self::$orm, $entityClass);
    }

//    public function testDump() {
//
//        $entityAnalyze = self::$entityAnalyzer->getEntityAnalyze();
//        $yaml = Yaml::dump($entityAnalyze->dump(), 7);
//        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'productDefiniton.yml', $yaml);
//    }
//
//    public function testDump2() {
//
//
//        $entityClass = 'Flexix\SampleEntitiesBundle\Entity\Transaction';
//        $entityAnalyzer = new EntityAnalyzer(self::$orm, $entityClass);
//        $entityAnalyze = $entityAnalyzer->getEntityAnalyze();
//        $yaml = Yaml::dump($entityAnalyze->dump(), 7);
//        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'transaction.yml', $yaml);
//    }
//
//    public function testMetadata() {
//
//        $entityAnalyze = self::$entityAnalyzer->getEntityAnalyze();
//        //   var_dump($entityAnalyze);
//    }

}
