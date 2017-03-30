<?php

namespace TMSolution\PrototypeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prototype controller.
 * 
 */
class PrototypeController extends Controller {

    const _LIST = 'list';
    const _NEW = 'new';
    const _CREATE = 'create';
    const _SHOW = 'show';
    const _EDIT = 'edit';
    const _UPDATE = 'update';
    const _DELETE = 'delete';
    
    public function __construct(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * Lists all product entities.
     *
     */
    public function listAction(Request $request) {
        $config = $this->get("prototype.config_factory")->createConfig($request);
        $config->getApplication();
        $config->createEntity();
        $config->getEntityClass();
        $config->getSearchFormType();
        $config->createSearchQuery();
        $config->getFormType();
        $config->getFormTypeClass();
        $config->getModel();
        $config->getTemplate('list');
        $config->getRedirectStrategy('list');
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request) {
       dump($request);
       die();
        $config = $this->createConfig($request);
        $entity = $config->createEnity();
        $this->denyAccessUnlessGranted(__FUNCTION__, $entity);
        $form = $this->createForm($config->getFormTypeClass(), $entity);
        return $this->render($config->getTemplate('new'), array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function createAction(Request $request) {
        $config = $this->createConfig($request,__FUNCTION__);
        $entity = $config->createEnity();
        $this->denyAccessUnlessGranted(__FUNCTION__, $entity);
        $form = $this->createForm($config->get(), $entity);
        $form->submit($request);
        if ($form->isValid()) {
            $config->getModel()->save($entity);
            return $this->redirectToRoute($config->getRedirectStrategy('create'), array('id' => $entity->getId()));
        }
        return $this->render($config->getTemplate("new"), array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Request $request, $id) {
        $config = $this->createConfig($request);
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
        $config = $this->createConfig($request);
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
        $config = $this->createConfig($request);
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
        $config = $this->createConfig($request, self::DELETE);
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

//    protected function createConfig(Request $request, $action) {
//        return $this->get("tm_solution_prototype.controller_configuration_factory")->createConfig($request, $action);
//    }

}
