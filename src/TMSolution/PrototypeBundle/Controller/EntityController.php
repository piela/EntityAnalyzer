<?php

namespace TMSolution\PrototypeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfigurationFactoryInterface;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\PrototypeBundle\Util\ControllerDriver;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Prototype controller.
 * 
 */
class EntityController extends FOSRestController {

    const _LIST = 'list';
    const _NEW = 'new';
    const _CREATE = 'create';
    const _GET = 'get';
    const _EDIT = 'edit';
    const _UPDATE = 'update';
    const _DELETE = 'delete';
    const APPLICATION_PATH = 'application_path';
    const ENTITIES_PATH = 'entities_path';

    protected $configurationFactory;
    protected $requestStack;
    protected $defaultAdapter;

    public function __construct(ContainerInterface $container, ControllerConfigurationFactoryInterface $configurationFactory, $requestStack, $defaultAdapter) {
        $this->container = $container;
        $this->configurationFactory = $configurationFactory;
        $this->requestStack = $requestStack;
        $this->defaultAdapter = $defaultAdapter;
    }

    public function listAction(Request $request, $action) {

        $driver = $this->getDriver($request, $action);

        $this->isActionAllowed($driver, $request);
        $entityClass = $driver->getEntityClass();
        $adapter = $this->getAdapter($driver);
        $entity = $this->createEntity($entityClass);
        $formTypeClass = $this->getFormTypeClass($driver, false);
        $form = null;

        if ($formTypeClass) {

            $form = $this->createForm($this->getFormTypeClass($driver), $entity, ['method' => $this->getFormMethod($driver), 'action' => $this->getFormActionUrl($driver)]);
            $form->handleRequest($request);
        }

        $result = $this->invokeModelMethod($driver, self::_LIST, [$driver->getEntityClass(), $request, $form], true);
        $adapter = $this->getAdapter($result);
        $view = $this->view($adapter->getData(), 200)
                ->setTemplateVar($this->getTemplateVar($driver))
                ->setTemplateData($adapter->getTemplateData(['driver' => $driver, 'is_xml_http' => $request->isXmlHttpRequest()]))
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    public function filterAction(Request $request, $action) {

        $driver = $this->getDriver($request, $action);
        $this->isActionAllowed($driver, $request);
        $entityClass = $driver->getEntityClass();
        $adapter = $this->getAdapter($driver);
        $entity = $this->createEntity($entityClass);
        $adapter->setObject($entity);
        $this->denyAccessUnlessGranted(self::_LIST, $this->getSecurityTicket($driver, $entity));
        $form = $this->createForm($this->getFormTypeClass($driver), $entity, ['method' => $this->getFormMethod($driver), 'action' => $this->getFormActionUrl($driver)]);
        $result = $this->invokeModelMethod($driver, self::_LIST, [$entity], true);
        $form->handleRequest($request);


        $view = $this->view($adapter->getData(), 200)
                ->setTemplateVar($this->getTemplateVar($driver))
                ->setTemplateData($adapter->getTemplateData([
                    'driver' => $driver,
                    'form' => $form->createView(),
                    'is_xml_http' => $request->isXmlHttpRequest()
                ]))
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    public function newAction(Request $request, $action) {

        $driver = $this->getDriver($request, $action);
        $this->isActionAllowed($driver, $request);
        $entityClass = $driver->getEntityClass();
        $adapter = $this->getAdapter($driver);
        $entity = $this->createEntity($entityClass);
        $adapter->setObject($entity);
        $this->denyAccessUnlessGranted(self::_NEW, $this->getSecurityTicket($driver, $entity));
        $form = $this->createForm($this->getFormTypeClass($driver), $entity, ['method' => $this->getFormMethod($driver), 'action' => $this->getFormActionUrl($driver)]);
        $result = $this->invokeModelMethod($driver, self::_NEW, [$entity], true);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //save
            $result = $this->invokeModelMethod($driver, self::_CREATE, [$entity, $request, $form]);
            $data['id'] = $entity->getId();
            $this->addResultToData($driver, self::_CREATE, $data, $result, false, $this->getDataParameter($driver, self::_CREATE));

            if ($driver->shouldRedirect()) {

                $view = $this->redirectView($this->getUrlToRedirect($driver, $data), 301);
                return $this->handleView($view);
            }
        }

        $view = $this->view($adapter->getData(), 200)
                ->setTemplateVar($this->getTemplateVar($driver))
                ->setTemplateData($adapter->getTemplateData([
                            'driver' => $driver,
                            'form' => $form->createView(),
                            'is_xml_http' => $request->isXmlHttpRequest()
                ]))
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function getAction(Request $request, $action, $id) {

        $driver = $this->getDriver($request, $action);
        $this->isActionAllowed($driver, $request);
        $adapter = $this->getAdapter($driver);
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id, $request]);
        $adapter->setObject($entity);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_GET, $this->getSecurityTicket($driver, $entity));
//        $data = [];
//        
//        $this->addResultToData($driver, self::_GET, $data, $entity, false, $this->getDataParameter($driver, self::_GET));

        $deleteForm = $this->createDeleteForm($request, $entity);

        $view = $this->view($adapter->getData(), 200)
                ->setTemplateVar($this->getTemplateVar($driver))
                ->setTemplateData($adapter->getTemplateData([
                            'driver' => $driver,
                            'delete_form' => $deleteForm->createView(),
                            'is_xml_http' => $request->isXmlHttpRequest()
                ]))
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, $action, $id) {

        $driver = $this->getDriver($request, $action);
        $this->isActionAllowed($driver, $request);
        //find
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id, $request]);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_EDIT, $this->getSecurityTicket($driver, $entity));


        $deleteForm = $this->createDeleteForm($request, $entity);

        $form = $this->createForm($this->getFormTypeClass($driver), $entity, ['method' => $this->getFormMethod($driver), 'action' => $this->getFormActionUrl($driver, ['id' => $entity->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = [];
            $result = $this->invokeModelMethod($driver, self::_UPDATE, [$entity, $request, $form]);
            $data['id'] = $entity->getId();
            $this->addResultToData($driver, self::_UPDATE, $data, $result);

            if ($driver->shouldRedirect()) {

                $view = $this->redirectView($this->getUrlToRedirect($driver, [$data]), 301);
                return $this->handleView($view);
            }
        }
        $view = $this->view($entity, 200)
                ->setTemplateVar($this->getTemplateVar($driver))
                ->setTemplateData([
                    'driver' => $driver,
                    'delete_form' => $deleteForm->createView(),
                    'form' => $form->createView(),
                    'is_xml_http' => $request->isXmlHttpRequest()
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, $action, $id) {

        $driver = $this->getDriver($request, $action);
        $this->isActionAllowed($driver, $request);
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id, $request]);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_DELETE, $this->getSecurityTicket($driver, $entity));

        $form = $this->createDeleteForm($request, $entity);
        $form->handleRequest($request);

        $data = [];

        if ($form->isValid()) {

            $result = $this->invokeModelMethod($driver, self::_DELETE, [$entity]);
            $this->addResultToData($driver, self::_UPDATE, $data, $result, false, $this->getDataParameter($driver, self::_DELETE));
        }

        $view = $this->redirectView($this->getUrlToRedirect($driver, $data), 301);
        return $this->handleView($view);
    }

    private function createDeleteForm($request, $entity) {

        $driver = $this->getDriver($request, self::_DELETE);
        $url = $this->generateUrl('delete', [self::APPLICATION_PATH => $driver->getApplicationPath(), self::ENTITIES_PATH => $driver->getEntitiesPath(), "id" => $entity->getId()]);
        return $this->createFormBuilder()
                        ->setAction($url)
                        ->setMethod('DELETE')
                        ->getForm();
    }

    protected function getDriver(Request $request, $action) {
        $driver = $this->createConfiguration($request, $action);
        return new ControllerDriver($driver);
    }

    protected function createConfiguration($request, $action) {
        return $this->configurationFactory->createConfiguration($request, new ControllerConfiguration(), $action);
    }

    protected function getModelObject($model) {

        if ($model['type'] == 'class') {
            $className = $model['name'];
            $object = new $className;
        } else if ($model['type'] == 'service') {
            $object = $this->get($model['name']);
        }

        return $object;
    }

    protected function invokeModelMethod($driver, $modelName, $arguments = [], $optional = false) {


        if ($driver->hasModel($modelName)) {

            $model = $driver->getModel($modelName);
            if ($model) {
                $object = $this->getModelObject($model);
                $arguments[] = $driver;
                return call_user_func_array(array($object, $model['method']), $arguments);
            }
        } else {
            if (!$optional) {
                throw new \Exception(sprintf("Model: \"%s\" doesn\'t exists", $modelName));
            }
        }
    }

    protected function createEntity($entityClass) {
        return new $entityClass;
    }

    protected function isActionAllowed($driver, $request) {

        if ($this->checkActionAllowed($driver, $request)) {
            return true;
        } else {

            throw new NotFoundHttpException('Action not allowed');
        }
    }

    protected function checkActionAllowed($driver, $request) {

        $actionAllowed = $driver->getActionAllowed();

        if (is_array($actionAllowed)) {

            if (in_array('xhttp', $actionAllowed)) {

                if ($request->isXmlHttpRequest()) {
                    return true;
                }
            }

            if (in_array('inner', $actionAllowed)) {

                if ($this->requestStack->getParentRequest()) {
                    return true;
                }
            }
        } else if ($actionAllowed == true) {
            return true;
        }


        return false;
    }

    protected function isRequestTypeAllowed($driver, $request) {

        if (!$this->isXHTTP($driver, $request) && !$this->isInner($driver, $request)) {
            throw new NotFoundHttpException('Action not allowed');
        }
    }

    protected function getDataParameter($driver, $model) {
        if ($driver->hasModelDataParameter($model)) {
            return $driver->getModelDataParameter($model);
        }
    }

    protected function addResultToData($driver, $modelName, &$data, $result, $required = false, $dataParameter = null) {
        if ($driver->hasModel($modelName)) {
            $resultParameter = $driver->getResultParameter($modelName);
            if ($resultParameter) {

                if ($dataParameter) {
                    if (is_array($result) && array_key_exists($dataParameter, $result)) {
                        $data[$resultParameter] = $result[$dataParameter];
                    }
                } else {

                    $data[$resultParameter] = $result;
                }
            } else {

                if ($required) {
                    throw new \Exception('Model "%s" must result parameter. Set paremter name in config - result_parameter', $modelName);
                }
            }
        }

        return $data;
    }

    protected function getSecurityTicket($driver, $object) {
        $ticket = $this->get('tm_solution_prototype.ticket');
        $ticket->setDriver($driver);
        $ticket->setObject($object);
        return $ticket;
    }

    protected function getRedirectionRouteParameters($driver, $data) {

        $definedParameters = $driver->getRedirectionRouteParameters();
        $resultParameters = [];
        if ($definedParameters) {
            foreach ($definedParameters as $parameter) {
                if (array_key_exists($parameter, $data)) {
                    $resultParameters[$parameter] = $data[$parameter];
                } else {
                    throw new \Exception(sprintf('Parameter %s for action needed, check configuration of your action', $parameter));
                }
            }
        }

        return $resultParameters;
    }

    protected function getUrlToRedirect($driver, $data) {


        $urlParameters = [self::APPLICATION_PATH => $driver->getApplicationPath(), self::ENTITIES_PATH => $driver->getEntitiesPath()];
        $redirectionParameters = $this->getRedirectionRouteParameters($driver, $data);
        $parameters = array_merge($urlParameters, $redirectionParameters);

        return $this->generateUrl($driver->getRedirectionRoute(), $parameters);
    }

    protected function getFormActionParameters($formAction) {

        if (is_array($formAction)) {

            if (!array_key_exists('route_name', $formAction)) {
                throw new \Exception('Parameter "route_name" for form "action" doesn\'t exists ');
            }

            if (array_key_exists('parameters', $formAction)) {
                return $formAction['parameters'];
            }
        }
        return [];
    }

    protected function getFormMethod($driver) {
        if ($driver->hasFormMethod()) {
            return $driver->getFormMethod();
        } else {
            return 'POST';
        }
    }

    protected function getFormActionUrl($driver, $extraParameters = []) {

        $formAction = $driver->getFormAction();
        $urlParameters = [self::APPLICATION_PATH => $driver->getApplicationPath(), self::ENTITIES_PATH => $driver->getEntitiesPath()];

        if ($formAction) {
            $urlParameters = array_merge($urlParameters, $this->getFormActionParameters($formAction), $extraParameters);
            $uri = $this->generateUrl($formAction, $urlParameters);
        }

        return $uri;
    }

    protected function checkEntityExists($driver, $entity) {

        $entityClass = $driver->getEntityClass();
        if (!$entity || !($entity instanceof $entityClass )) {
            throw new \Exception('Entity doesn\'t exists');
        }
    }

    protected function getFormTypeClass($driver, $required = true) {
        if ($driver->hasFormTypeClass()) {

            return $driver->getFormTypeClass();
        } else {
            if ($required == true) {
                throw new \Exception('There is no form_type in configuration');
            }
        }
    }

    protected function getTemplateVar($driver) {
        if ($driver->getTemplateVar()) {

            return $driver->getTemplateVar();
        }
        return 'data';
    }

    protected function getAdapter($driver) {

        $adapter = $driver->getAdapter();
        if ($adapter) {
            return $this->get($adapter);
        } else {
            return $this->defaultAdapter;
        }
    }

}
