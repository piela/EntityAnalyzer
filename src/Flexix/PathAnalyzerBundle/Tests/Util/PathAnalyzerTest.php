<?php

namespace Flexix\PathAnalyzerBundle\Tests\Util;

use Flexix\PathAnalyzerBundle\Util\PathAnalyzer;
use Symfony\Component\Yaml\Yaml;
use Flexix\MapperBundle\Util\ApplicationMapper;
use Flexix\MapperBundle\Util\EntityMapper;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/Flexix/PrototypeBundle/Tests/Util/PathAnalyzerTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class PathAnalyzerTest extends TestCase {

    const _NAMESPACE = 'admin';
    const _applicationPath = 'admin/some/other/path';
    const _entitiesPath = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';
    
    

  

    public function testAnalyze() {

        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $appliactionMapper = new ApplicationMapper($mapperConfiguration['flexix_mapper']['applications']);
        $entityMapper = new EntityMapper($mapperConfiguration['flexix_mapper']['entities']);
        $PathAnalyzer = new PathAnalyzer($appliactionMapper, $entityMapper);
        $PathAnalyze = $PathAnalyzer->analyze(self::_applicationPath,self::_entitiesPath,self::_ID);
        $patternPathAnalyze = unserialize(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'serializedPathAnalyze'));
        $this->assertEquals($patternPathAnalyze, $PathAnalyze);
    }

}
