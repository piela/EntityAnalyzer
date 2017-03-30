<?php

namespace TMSolution\MapperBundle\Tests\Util;

use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\EntityMapper;
use \PHPUnit\Framework\TestCase;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/MapperBundle/Tests/Util/EntityMapperTest.php
 * @author Mariusz
 */
class EntityMapperTest extends TestCase {

    const _ALIAS = 'measure-unit';
    const _NOT_EXISTED_ALIAS = 'not-existed-measure-unit';
    const _BUNDLE_NAME = 'tm_solution_entity_analyzer';
    const _CONFLICTED_BUNDLE_NAME = 'tm_solution_sample_entities';
    const _ENTITY_CLASS = 'TMSolution\EntityAnalyzerBundle\Entity\MeasureUnit';
    const _NOT_EXISTED_ENTITY_CLASS = 'NotExistedTMSolution\EntityAnalyzerBundle\Entity\MeasureUnit';

    public static function setupBeforeClass() {
        
    }

    public function testGetEntityClass() {
        
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $applicationMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $entityClass = $applicationMapper->getEntityClass(self::_ALIAS, [self::_BUNDLE_NAME]);
        $this->assertEquals(self::_ENTITY_CLASS, $entityClass);
    }

    /**
     * @expectedException TMSolution\MapperBundle\Exceptions\MoreThanOneEntityClassForAlias
     */
    public function testGetEntityClass_MoreThanOneEntityClassForAliasException() {
        
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $applicationMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $applicationMapper->getEntityClass(self::_ALIAS, [self::_BUNDLE_NAME, self::_CONFLICTED_BUNDLE_NAME]);
    }

    /**
     * @expectedException TMSolution\MapperBundle\Exceptions\TMSolution\MapperBundle\Exceptions\NoEntityClassForAlias;
     */
    public function testGetEntityClass_NoEntityClassForAliasException() {
       
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $applicationMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $applicationMapper->getEntityClass(self::_NOT_EXISTED_ALIAS, [self::_BUNDLE_NAME, self::_CONFLICTED_BUNDLE_NAME]);
    }

    public function testGetAlias() {
       
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $applicationMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $entityClass = $applicationMapper->getAlias(self::_ENTITY_CLASS, [self::_BUNDLE_NAME]);
        $this->assertEquals(self::_ALIAS, $entityClass);
    }

    /**
     * @expectedException TMSolution\MapperBundle\Exceptions\NoAliasForEntityClass; 
     */
    public function testGetAliasExcepiton() {
        
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $applicationMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $applicationMapper->getAlias(_NOT_EXISTED_ENTITY_CLASS, [self::_BUNDLE_NAME, self::_CONFLICTED_BUNDLE_NAME]);
    }

}
