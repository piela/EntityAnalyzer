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
class PrototypeController extends FOSRestController {

    const _LIST = 'list';
    const _QUERY = 'query';
    const _NEW = 'new';
    const _CREATE = 'create';
    const _SHOW = 'show';
    const _EDIT = 'edit';
    const _UPDATE = 'update';
    const _DELETE = 'delete';

    protected $configurationFactory;

    public function __construct(ContainerInterface $container, ControllerConfigurationFactoryInterface $configurationFactory) {
        $this->container = $container;
        $this->configurationFactory = $configurationFactory;
    }

//    /**
//     * Lists all product entities.
//     *
//     */
//    public function listAction($request) {
//        $config = $this->get("prototype.config_factory")->createConfig($request);
//        $config->getApplication();
//        $config->createEntity();
//        $config->getEntityClass();
//        $config->getSearchFormType();
//        $config->createSearchQuery();
//        $config->getFormType();
//        $config->getFormTypeClass();
//        $config->getModel();
//        $config->getTemplate('list');
//        $config->getRedirectStrategy('list');
//    }
//
//    /**
//     * Lists all product entities.
//     *
//     */
//    public function queryAction($request) {
//        $config = $this->get("prototype.config_factory")->createConfig($request);
//        $config->getApplication();
//        $config->createEntity();
//        $config->getEntityClass();
//        $config->getSearchFormType();
//        $config->createSearchQuery();
//        $config->getFormType();
//        $config->getFormTypeClass();
//        $config->getModel();
//        $config->getTemplate('list');
//        $config->getRedirectStrategy('list');
//    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request) {

        $driver = $this->getDriver($request, self::_NEW);
        $this->isActionAllowed($driver);
        $entityClass = $driver->getEntityClass();
        $entity = $this->createEntity($entityClass);
        $this->denyAccessUnlessGranted(self::_NEW, $this->getSecurityTicket($driver, $entity));
        $form = $this->createForm($driver->getFormTypeClass(), $entity);
        $result = $this->invokeModelMethod($driver, [$entity]);
        $data=  [];
        $this->addResultToData($driver, $data, $result);
        $view = $this->view($data, 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'form' => $form->createView(),
                ])
                ->setTemplate($driver->getTemplate('new'));

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

        if ($form->isValid()) {

            $result = $this->invokeModelMethod($driver, [$entity]);
            $data=  [];
            $data['id']=$entity->getId();
            $this->addResultToData($driver, $data, $result);
            
            if ($driver->shouldRedirect()) {
                return $this->redirectView($this->generateUrl('some_route'),$driver->getRedirectRoute($data), 301);
            }
        }

        $view = $this->view([
                    'entity' => $entity
                        ], 200)
                ->setTemplateData([
                    'driver' => $driver,
                    'form' => $form->createView(),
                ])
                ->setTemplate($driver->getTemplate('new'));
        return $this->handleView($view);
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Request $request, $id) {
        $config = $this->createConfiguration($request);
        $entity = $config->getModel()->findOneById($id);
        $this->denyAccessUnlessGranted(__FUNCTION__, $entity);
        $deleteForm = $this->createDeleteForm($entity);
        return $this->render($config->getTemplate("show"), array(
                    'entity' => entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, $id) {
        $config = $this->createConfiguration($request);
        $entity = $config->getModel()->findOneById($id);
        $this->denyAccessUnlessGranted(__FUNCTION__, $entity);
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm($config->getFormTypeClass(), $entity);
        return $this->render($config->getTemplate("edit"), array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $config = $this->createConfiguration($request);
        $entity = $config->getModel()->findOneById($id);
        $this->denyAccessUnlessGranted(__FUNCTION__, $entity);
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm($config->getFormTypeClass(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $config->getModel()->update($entity);
            return $this->redirectToRoute($config->getRedirectStrategy('update'), array('id' => $entity->getId()));
        }

        return $this->render($config->getTemplate("edit"), array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $config = $this->createConfiguration($request, self::DELETE);
        $entity = $config->getModel()->findOneById($id);
        $this->denyAccessUnlessGranted(__FUNCTION__, $entity);
        $form = $this->createDeleteForm($entity);
        $form->submit($request);

        if ($form->isValid()) {
            $config->getModel()->remove($entity);
        }

        return $this->redirectToRoute('test_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($config, $entity) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($config->getRedirectStrategy('delete'), array('id' => $entity->getId())))
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

    protected function invokeModelMethod($driver, $arguments = []) {

        $model = $driver->getModel();
        if ($model) {
            if ($model['type'] == 'class') {
                $className = $model['name'];
                $object = new $className;
            } else if ($model['type'] == 'service') {
                $object = $this->get($model['name']);
            }

            return call_user_func(array($object, $model['method']), $arguments);
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

    protected function addResultToData($driver, &$data, $result) {
        if ($driver->returnResultToView()) {
            $data[$driver->getResultParameter()] = $result;
        }
    }

    protected function getSecurityTicket($driver, $object) {
        $ticket = $this->get('tm_solution_prototype.ticket');
        $ticket->setDriver($driver);
        $ticket->setObject($object);
        return $ticket;
    }

//call_user_func
}
