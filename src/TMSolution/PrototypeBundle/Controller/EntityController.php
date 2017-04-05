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

    protected $configurationFactory;

    public function __construct(ContainerInterface $container, ControllerConfigurationFactoryInterface $configurationFactory) {
        $this->container = $container;
        $this->configurationFactory = $configurationFactory;
    }

    public function listAction(Request $request) {
        //form z lexika 
        $driver = $this->getDriver($request, self::_LIST);
        $this->isActionAllowed($driver);
        $result = $this->invokeModelMethod($driver, self::_LIST, [$driver->getEntityClass(), $request->query]);
        $data = [];
        $this->addResultToData($driver, self::_LIST, $data, $result);
        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    public function newAction(Request $request) {

        $driver = $this->getDriver($request, self::_NEW);
        $this->isActionAllowed($driver);
        $entityClass = $driver->getEntityClass();
        $entity = $this->createEntity($entityClass);
        $this->denyAccessUnlessGranted(self::_NEW, $this->getSecurityTicket($driver, $entity));
        $form = $this->createForm($driver->getFormTypeClass(), $entity, ['action' => $this->getFormActionUrl($driver)]);
        $result = $this->invokeModelMethod($driver, self::_NEW, [$entity], true);

        $data = [];
        $this->addResultToData($driver, self::_NEW, $data, $result);

        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'form' => $form->createView(),
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    public function createAction(Request $request) {

        $driver = $this->getDriver($request, self::_CREATE);
        $this->isActionAllowed($driver);
        $entityClass = $driver->getEntityClass();
        $entity = $this->createEntity($entityClass);
        $this->denyAccessUnlessGranted(self::_CREATE, $this->getSecurityTicket($driver, $entity));
        $form = $this->createForm($driver->getFormTypeClass(), $entity);
        $form->handleRequest($request);
        $data = ['entity' => $entity];

        if ($form->isValid()) {

            //save
            $result = $this->invokeModelMethod($driver, self::_CREATE, [$entity]);
            $data['id'] = $entity->getId();
            $this->addResultToData($driver, self::_CREATE, $data, $result);

            if ($driver->shouldRedirect()) {

                $view = $this->redirectView($this->getUrlToRedirect($driver, $data), 301);
                return $this->handleView($view);
            }
        }

        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'form' => $form->createView(),
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function getAction(Request $request, $id) {

        $driver = $this->getDriver($request, self::_GET);
        $this->isActionAllowed($driver);
        //find
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id]);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_GET, $this->getSecurityTicket($driver, $entity));
        $data = [];
        $data['entity'] = $entity;
        $this->addResultToData($driver, self::_GET, $data, $entity);

        $deleteForm = $this->createDeleteForm($request, $entity);

        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'delete_form' => $deleteForm->createView()
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, $id) {

        $driver = $this->getDriver($request, self::_EDIT);
        $this->isActionAllowed($driver);
        //find
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id]);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_EDIT, $this->getSecurityTicket($driver, $entity));

        $data = [];
        $data['entity'] = $entity;
        $this->addResultToData($driver, self::_EDIT, $data, $entity);

        $deleteForm = $this->createDeleteForm($request, $entity);
        $editForm = $this->createForm($driver->getFormTypeClass(), $entity, ['action' => $this->getFormActionUrl($driver, ['id' => $entity->getId()])]);

        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'delete_form' => $deleteForm->createView(),
                    'form' => $editForm->createView(),
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function updateAction(Request $request, $id) {

        $driver = $this->getDriver($request, self::_UPDATE);
        $this->isActionAllowed($driver);
        //find
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id]);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_UPDATE, $this->getSecurityTicket($driver, $entity));

        $data = [];
        $this->addResultToData($driver, self::_GET, $data, $entity);

        $deleteForm = $this->createDeleteForm($request, $entity);
        $editForm = $this->createForm($driver->getFormTypeClass(), $entity, ['action' => $this->getFormActionUrl($driver, ['id' => $entity->getId()])]);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            //update
            $result = $this->invokeModelMethod($driver, self::_UPDATE, [$entity]);
            $data['id'] = $entity->getId();
            $this->addResultToData($driver, self::_UPDATE, $data, $result);

            if ($driver->shouldRedirect()) {

                $view = $this->redirectView($this->getUrlToRedirect($driver, [$data]), 301);
                return $this->handleView($view);
            }
        }

        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'delete_form' => $deleteForm->createView(),
                    'form' => $editForm->createView(),
                ])
                ->setTemplate($driver->getTemplate());

        return $this->handleView($view);
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, $id) {

        $driver = $this->getDriver($request, self::_DELETE);
        $this->isActionAllowed($driver);
        $entity = $this->invokeModelMethod($driver, self::_GET, [$driver->getEntityClass(), $id]);
        $this->checkEntityExists($driver, $entity);
        $this->denyAccessUnlessGranted(self::_DELETE, $this->getSecurityTicket($driver, $entity));

        $form = $this->createDeleteForm($request, $entity);
        $form->handleRequest($request);

        $data = [];

        if ($form->isValid()) {

            $result = $this->invokeModelMethod($driver, self::_DELETE, [$entity]);
            $this->addResultToData($driver, self::_UPDATE, $data, $result);
        }

        $view = $this->redirectView($this->getUrlToRedirect($driver, $data), 301);
        return $this->handleView($view);
    }

    private function createDeleteForm($request, $entity) {

        $driver = $this->getDriver($request, self::_DELETE);
        $url = $this->generateUrl('delete', ["applicationPath" => $driver->getApplicationPath(), "entitiesPath" => $driver->getEntitiesPath(), "id" => $entity->getId()]);
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

    protected function isActionAllowed($driver) {

        if (!$driver->isActionAllowed()) {
            throw new \NotFoundHttpException('Action not allowed');
        }
    }

    protected function addResultToData($driver, $modelName, &$data, $result) {
        if ($driver->hasModel($modelName)) {
            if ($driver->returnResultToView($modelName)) {
                $data[$driver->getResultParameter($modelName)] = $result;
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


        $urlParameters = ['applicationPath' => $driver->getApplicationPath(), 'entitiesPath' => $driver->getEntitiesPath()];
        $redirectionParameters = $this->getRedirectionRouteParameters($driver, $data);
        $parameters = array_merge($urlParameters, $redirectionParameters);

        return $this->generateUrl($driver->getRedirectionRoute(), $parameters);
    }

    protected function getFormActionParameters($formAction) {

        if (is_array($formAction)) {

            if (!array_key_exists('routeName', $formAction)) {
                throw new Exception('Parameter "routeName" for "formAciton" doesn\'t exists ');
            }

            if (array_key_exists('parameters', $formAction)) {
                return $formAction['parameters'];
            }
        }
        return [];
    }

    protected function getFormActionUrl($driver, $extraParameters = []) {

        $formAction = $driver->getFormAction();
        $urlParameters = ['applicationPath' => $driver->getApplicationPath(), 'entitiesPath' => $driver->getEntitiesPath()];

        if ($formAction) {
            $urlParameters = array_merge($urlParameters,$this->getFormActionParameters($formAction), $extraParameters);
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

}
