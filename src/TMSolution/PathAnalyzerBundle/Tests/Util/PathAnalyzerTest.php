<?php

namespace TMSolution\PathAnalyzerBundle\Tests\Util;

use TMSolution\PathAnalyzerBundle\Util\PathAnalyzer;
use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\MapperBundle\Util\EntityMapper;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/PathAnalyzerTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class PathAnalyzerTest extends TestCase {

    const _NAMESPACE = 'admin';
    const _applicationPath = 'admin/some/other/path';
    const _entitiesPath = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';
    
    

  

    public function testAnalyze() {

        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $appliactionMapper = new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['applications']);
        $entityMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $PathAnalyzer = new PathAnalyzer($appliactionMapper, $entityMapper);
        $PathAnalyze = $PathAnalyzer->analyze(self::_applicationPath,self::_entitiesPath,self::_ID);
        $patternPathAnalyze = unserialize(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'serializedPathAnalyze'));
        $this->assertEquals($patternPathAnalyze, $PathAnalyze);
    }

}
