<?php

namespace TMSolution\EntityAnalyzerBundle\Controller;

use TMSolution\EntityAnalyzerBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class PrototypeController extends Controller {

    public function __construct(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * Lists all product entities.
     *
     */
    public function listAction(Request $request) {
        $config = $this->get("prototype.config")->create($request);
        $config->getApplication();
        $config->createEntity();
        $config->getEntityClass();
        $config->getSearchFormType();
        $config->getFormType();
        $config->getFormTypeClass();
        $config->getModel();
        $config->getTemplate('list');
        $config->getRedirectStrategy('list');
    }

    /**
     * Lists all product entities.
     *
     */
    public function queryAction(Request $request) {
        $config = $this->get("prototype.config")->create($request);
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
        $config = $this->getConfig($request);
        $entity = $config->createEnity();
        $form = $this->createForm($config->getFormTypeClass(), $entity);
        return $this->render($config->getTemplate("new"), array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function createAction(Request $request) {
        $config = $this->getConfig($request);
        $entity = $config->createEnity();
        $form = $this->createForm($config->getFormTypeClass(), $entity);
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
        $config = $this->getConfig($request);
        $entity = $config->getModel()->findOneById($id);
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
        $config = $this->getConfig($request);
        $entity = $config->getModel()->findOneById($id);
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
        $config = $this->getConfig($request);
        $entity = $config->getModel()->findOneById($id);
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
        $config = $this->getConfig($request);
        $entity = $config->getModel()->findOneById($id);
        $form = $this->createDeleteForm($entity);
        $form->submit($request);
        if ( $form->isValid()) {
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
    private function createDeleteForm($config,$entity) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($config->getRedirectStrategy('delete'), array('id' => $entity->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    protected function getConfig(Request $request) {
        return $this->get("prototype.config")->create($request);
    }

}
