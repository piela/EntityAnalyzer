<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use Symfony\Component\Yaml\Yaml;
use TMSolution\PrototypeBundle\Util\ControllerDriver;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\PrototypeBundle\Sample\SampleLogger;
use TMSolution\PrototypeBundle\Controller\PrototypeController;
use TMSolution\MapperBundle\Util\EntityMapper;
use TMSolution\ConfigurationBundle\Util\Configuration;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfigurationFactory;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzer;
use Symfony\Component\HttpFoundation\Request;
use \PHPUnit\Framework\TestCase;

/**
 * 
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/ControllerDriverTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>,TomDyg
 */
class ControllerDriverTest extends TestCase {

    const _ALIAS = 'payment-frequency';
    const _APPLICATION_PATH = 'admin/some/other/path';
    const _ENTITIES_PATH = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';
    const _MODEL_NAME = 'get';

    static protected $expected_entity_name = 'TMSolution\EntityAnalyzerBundle\Entity\PaymentFrequency';
    static protected $expected_application_path = 'admin/some/other/path';
    static protected $expected_entities_path = 'discount/2/measure-unit/3/payment-frequency';
    static protected $expected_result_parameter = 'productCategory';
    static protected $expected_form_type = 'TMSolution\WizardBundle\Form\ViewTypeType';
    static protected $expected_form_action = 'delete';
    static protected $expected_widget_template = 'viewtype\delete.html.twig';
    static protected $expected_model_array = array(
        'name' => 'some_model',
        'method' => 'findOneById',
        'return_result_to_view' => true,
        'result_parameter' => 'productCategory',
        'type' => 'service'
    );
    static protected $expected_route_name = 'list';
    static protected $mapperConfiguration;
    static protected $prototypeConfiguration;
    static protected $developerConfiguration;
    static protected $controllerDriver;
    static protected $request;

    public static function setupBeforeClass() {

        $configuration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testConfiguration.yml'));
        $controllerConfiguration = new ControllerConfiguration($configuration['tm_solution_prototype']['base']);
        self::$controllerDriver = new ControllerDriver($controllerConfiguration);

        self::$request = new Request(['id' => self::_ID], [], [
            'application_path' => self::_APPLICATION_PATH,
            'entities_path' => self::_ENTITIES_PATH
        ]);
        self::$mapperConfiguration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml');
        self::$prototypeConfiguration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testPrototypeConfiguration.yml');
        self::$developerConfiguration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testDeveloperConfiguration.yml');
    }

    protected function getDeleteActionConfiguration() {
        $configuration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testConfiguration.yml'));
        $controllerConfiguration = new ControllerConfiguration($configuration['tm_solution_prototype']['actions']['delete']);
        return new ControllerDriver($controllerConfiguration);
    }

    protected function getDriver() {

        $mapperConfiguration = Yaml::parse(self::$mapperConfiguration);

        $appliactionMapper = new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['applications']);

        $entityMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);

        $requestAnalyzer = new RequestAnalyzer($appliactionMapper, $entityMapper);

        $prototypeConfiguration = Yaml::parse(self::$prototypeConfiguration);
        $developerConfiguration = Yaml::parse(self::$developerConfiguration);

        $baseConfiguration = new Configuration($prototypeConfiguration['tm_solution_prototype']);
        $configurationFactory = new ControllerConfigurationFactory($baseConfiguration, $requestAnalyzer);
        $developerConfiguration = new Configuration($developerConfiguration['tm_solution_prototype']);
        $configurationFactory->addConfiguration($developerConfiguration, self::_APPLICATION_PATH, self::_ALIAS);
        $controllerConfiguration = new ControllerConfiguration($configurationFactory->createConfiguration(self::$request, new ControllerConfiguration(), 'new'));
        return new ControllerDriver($controllerConfiguration);
    }

    public function testIsActionAllowed() {

        $this->assertTrue(self::$controllerDriver->isActionAllowed());
    }

    public function testGetEntityClass() {

        $controllerDriver = $this->getDriver();
        $this->assertEquals($controllerDriver->getEntityClass(), self::$expected_entity_name);
    }

    public function testGetApplicationPath() {

        $controllerDriver = $this->getDriver();
        $applicationPath = $controllerDriver->getApplicationPath();
        $this->assertEquals($applicationPath, self::$expected_application_path);
    }

    public function testGetEntitiesPath() {

        $controllerDriver = $this->getDriver();
        $entitiesPath = $controllerDriver->getEntitiesPath();
        $this->assertEquals($entitiesPath, self::$expected_entities_path);
    }

    public function testReturnResultToView() {

        $this->assertTrue(self::$controllerDriver->returnResultToView(self::_MODEL_NAME));
    }

    public function testGetResultParameter() {

        $this->assertEquals(self::$controllerDriver->getResultParameter(self::_MODEL_NAME), self::$expected_result_parameter);
    }

    public function testShouldRedirect() {
        $controllerDriver = $this->getDeleteActionConfiguration();
        $this->assertTrue($controllerDriver->shouldRedirect());
    }

    public function testGetRedirectionRouteParameters() {

        $controllerDriver = $this->getDeleteActionConfiguration();
        $this->assertEquals($controllerDriver->getRedirectionRouteParameters(), []);
    }

    public function testGetModel() {

        $model = self::$controllerDriver->getModel(self::_MODEL_NAME);
        $this->assertEquals($model, self::$expected_model_array);
    }

    public function testHasModel() {
        $this->assertTrue(self::$controllerDriver->hasModel(self::_MODEL_NAME));
    }

    public function testGetFormTypeClass() {
        $controllerDriver = $this->getDeleteActionConfiguration();
        $this->assertEquals($controllerDriver->getFormTypeClass(), self::$expected_form_type);  
    }

    public function testGetFormAction() {
        $controllerDriver = $this->getDeleteActionConfiguration();
        $this->assertEquals($controllerDriver->getFormAction(), self::$expected_form_action);
    }

    public function testGetTemplate() { 
        $controllerDriver = $this->getDeleteActionConfiguration();
        $this->assertEquals($controllerDriver->getTemplate(), self::$expected_widget_template);
    }

}
