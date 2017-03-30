<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use TMSolution\PrototypeBundle\Util\RequestAnalyzer;
use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\MapperBundle\Util\EntityMapper;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/RequestAnalyzerTest.php
 * @author Mariusz
 */
class RequestAnalyzerTest extends TestCase {

    const _NAMESPACE = 'admin';
    const _APPLICATION_PATH = 'admin/some/other/path';
    const _ENTITIES_PATH = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';
    
    static protected $request;

    public static function setupBeforeClass() {
        self::$request = new Request(['id' => self::_ID], [/* post */], [
            'applicationPath' => self::_APPLICATION_PATH,
            'entitiesPath' => self::_ENTITIES_PATH
        ]);
    }

    public function testAnalyze() {

        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $appliactionMapper = new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['applications']);
        $entityMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $requestAnalyzer = new RequestAnalyzer($appliactionMapper, $entityMapper);
        $requestAnalyze = $requestAnalyzer->analyze(self::$request);
        $patternRequestAnalyze = unserialize(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'serializedRequestAnalyze'));
        var_dump($patternRequestAnalyze);
        $this->assertEquals($patternRequestAnalyze, $requestAnalyze);
    }

}
