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
 *
 * @author Mariusz
 */
class RequestAnalyzerTest extends TestCase {

    
    
    const _NAMESPACE='admin';
    const _APPLICATION_PATH='admin/some/other/path';
    const _ENTITIES_PATH='/discount/2/measure-unit/3/payment-frequency';
    
    
    static protected $request;

    public static function setupBeforeClass() {
        self::$request = Request::create(
                    '/hello-world', 'GET', 
                    [
                    'applicationPath' => self::_APPLICATION_PATH,
                    'entitiesPath' => self::_ENTITIES_PATH
                    ]);
    }

    public function testAnalyze() {
        
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__.'testMapper.yml'));
        $appliactionMapper=new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['appliactions']);
        $entityMapper=new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $requestAnalyze=new RequestAnalyzer($appliactionMapper,$entityMapper);
        $this->assertInstanceof('TMSolution\PrototypeBundle\Util\RequestAnalyze',$requestAnalyze->analyze(self::$request));
        $this->assertInstanceof('TMSolution\PrototypeBundle\Util\RequestAnalyze',$requestAnalyze->analyze(self::$request));
        
    }
    
   

}
