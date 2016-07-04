<?php

namespace ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\App;
use ShopBundle\Form\AppType;

/**
 * App controller.
 *
 * @Route("/app")
 */
class AppController extends Controller
{
    /**
     * Lists all App entities.
     *
     * @Route("/", name="app_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $apps = $em->getRepository('ShopBundle:App')->findAll();

        return $this->render('ShopBundle:App:index.html.twig', array(
            'apps' => $apps,
        ));
    }

    /**
     * Creates a new App entity.
     *
     * @Route("/new", name="app_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $app = new App();
        $form = $this->createForm('ShopBundle\Form\AppType', $app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($app);
            $em->flush();

            return $this->redirectToRoute('app_show', array('id' => $app->getId()));
        }

        return $this->render('ShopBundle:App:new.html.twig', array(
            'app' => $app,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a App entity.
     *
     * @Route("/{id}", name="app_show")
     * @Method("GET")
     */
    public function showAction(App $app)
    {
        $deleteForm = $this->createDeleteForm($app);

        return $this->render('ShopBundle:App:show.html.twig', array(
            'app' => $app,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing App entity.
     *
     * @Route("/{id}/edit", name="app_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, App $app)
    {
        $deleteForm = $this->createDeleteForm($app);
        $editForm = $this->createForm('ShopBundle\Form\AppType', $app);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($app);
            $em->flush();

            return $this->redirectToRoute('app_edit', array('id' => $app->getId()));
        }

        return $this->render('ShopBundle:App:edit.html.twig', array(
            'app' => $app,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a App entity.
     *
     * @Route("/{id}", name="app_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, App $app)
    {
        $form = $this->createDeleteForm($app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($app);
            $em->flush();
        }

        return $this->redirectToRoute('app_index');
    }

    /**
     * Creates a form to delete a App entity.
     *
     * @param App $app The App entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(App $app)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_delete', array('id' => $app->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}