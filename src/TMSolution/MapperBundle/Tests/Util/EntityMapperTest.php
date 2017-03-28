<?php

namespace TMSolution\MapperBundle\Test\Util;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TMSolution\MapperBundle\Util\ClassMapper;

class EntityMapperTest extends KernelTestCase {

    protected static $classMapper;

    static public function setUpBeforeClass() {
        self::bootKernel();
        $entities = ['tm_solution_entity_analyzer' =>
        ['discount' => 'TMSolution\EntityAnalyzerBundle\Entity\Discount',
        'measureunit' => 'TMSolution\EntityAnalyzerBundle\Entity\MeasureUnit',
        'paymentfrequency' => 'TMSolution\EntityAnalyzerBundle\Entity\PaymentFrequency',
        'product' => 'TMSolution\EntityAnalyzerBundle\Entity\Product',
        'productcategory' => 'TMSolution\EntityAnalyzerBundle\Entity\ProductCategory',
        'productdefinition' => 'TMSolution\EntityAnalyzerBundle\Entity\ProductDefinition',
        'productdictionary' => 'TMSolution\EntityAnalyzerBundle\Entity\ProductDictionary',
        'productprice' => 'TMSolution\EntityAnalyzerBundle\Entity\ProductPrice',
        'transaction' => 'TMSolution\EntityAnalyzerBundle\Entity\Transaction',
        'transactionstatus' => 'TMSolution\EntityAnalyzerBundle\Entity\TransactionStatus',
        'transactiontype' => 'TMSolution\EntityAnalyzerBundle\Entity\TransactionType'],
        'tm_solution_sample_entities' =>
        ['discount' => 'TMSolution\SampleEntitiesBundle\Entity\Discount',
        'measureunit' => 'TMSolution\SampleEntitiesBundle\Entity\MeasureUnit',
        'paymentfrequency' => 'TMSolution\SampleEntitiesBundle\Entity\PaymentFrequency',
        'product' => 'TMSolution\SampleEntitiesBundle\Entity\Product',
        'productcategory' => 'TMSolution\SampleEntitiesBundle\Entity\ProductCategory',
        'productdefinition' => 'TMSolution\SampleEntitiesBundle\Entity\ProductDefinition',
        'productdictionary' => 'TMSolution\SampleEntitiesBundle\Entity\ProductDictionary',
        'productprice' => 'TMSolution\SampleEntitiesBundle\Entity\ProductPrice',
        'transaction' => 'TMSolution\SampleEntitiesBundle\Entity\Transaction',
        'transactionstatus' => 'TMSolution\SampleEntitiesBundle\Entity\TransactionStatus',
        'transactiontype' => 'TMSolution\SampleEntitiesBundle\Entity\TransactionType']];
//      $entities = static::$kernel->getContainer()->getParameter('tm_solution_class_mapper.map');
        self::$classMapper = new ClassMapper($entities);
    }

    public function testGetEntityClass() {
        $entityClass = self::$classMapper->getEntityClass('productcategory', 'tm_solution_entity_analyzer');
        $this->assertEquals('TMSolution\EntityAnalyzerBundle\Entity\ProductCategory', $entityClass);
    }

    public function testGetName() {
        $name = self::$classMapper->getName('TMSolution\EntityAnalyzerBundle\Entity\ProductCategory', 'tm_solution_entity_analyzer');
        $this->assertEquals('productcategory', $name);
    }

}
