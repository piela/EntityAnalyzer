<?php

namespace TMSolution\MapperBundle\Tests\Util;

use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use \PHPUnit\Framework\TestCase;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/MapperBundle/Tests/Util/ApplicationMapperTest.php
 * @author Mariusz
 */
class ApplicationMapperTest extends TestCase {

    const _APPLICATION_NAME='admin';
    
    
   
    public static function setupBeforeClass() {
    }

    public function testGetBundles() {
        
        $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'testMapper.yml'));
        $appliactionMapper=new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['applications']);
        $bundles=$appliactionMapper->getBundles(self::_APPLICATION_NAME);
        $this->assertEquals(2,count($bundles));
        $this->assertEquals('tm_solution_entity_analyzer',$bundles[0]);
        
    }
    
   

}
