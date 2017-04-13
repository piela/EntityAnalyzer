<?php

namespace Flexix\SampleEntitiesBundle\Controller;

use Flexix\SampleEntitiesBundle\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Productcategory controller.
 *
 * @Route("productcategory")
 */
class ProductCategoryController extends Controller {

    /**
     * Lists all productCategory entities.
     *
     * @Route("/", name="productcategory_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $productCategories = $em->getRepository('FlexixSampleEntitiesBunProductCategorydle:ProductCategory')->findAll();

        return $this->render('productcategory/index.html.twig', array(
                    'productCategories' => $productCategories,
        ));
    }

    /**
     * Creates a new productCategory entity.
     *
     * @Route("/new", name="productcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $productCategory = new Productcategory();
        $form = $this->createForm('Flexix\SampleEntitiesBundle\Form\ProductCategoryType', $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //asnsodf
            $em = $this->getDoctrine()->getManager();
            $em->persist($productCategory);
            $em->flush();
            return $this->redirectToRoute('productcategory_show', array('id' => $productCategory->getId()));
        }

        return $this->render('productcategory/new.html.twig', array(
                    'productCategory' => $productCategory,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productCategory entity.
     *
     * @Route("/{id}", name="productcategory_show")
     * @Method("GET")
     */
    public function showAction(ProductCategory $productCategory) {
        $deleteForm = $this->createDeleteForm($productCategory);

        return $this->render('productcategory/show.html.twig', array(
                    'productCategory' => $productCategory,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productCategory entity.
     *
     * @Route("/{id}/edit", name="productcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProductCategory $productCategory) {
        $deleteForm = $this->createDeleteForm($productCategory);
        $editForm = $this->createForm('Flexix\SampleEntitiesBundle\Form\ProductCategoryType', $productCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productcategory_edit', array('id' => $productCategory->getId()));
        }

        return $this->render('productcategory/edit.html.twig', array(
                    'productCategory' => $productCategory,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productCategory entity.
     *
     * @Route("/{id}", name="productcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProductCategory $productCategory) {
        $form = $this->createDeleteForm($productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productCategory);
            $em->flush();
        }

        return $this->redirectToRoute('productcategory_index');
    }

    /**
     * Creates a form to delete a productCategory entity.
     *
     * @param ProductCategory $productCategory The productCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCategory $productCategory) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('productcategory_delete', array('id' => $productCategory->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
