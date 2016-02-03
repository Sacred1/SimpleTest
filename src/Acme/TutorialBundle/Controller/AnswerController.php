<?php

namespace Acme\TutorialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\TutorialBundle\Entity\Answer;
use Acme\TutorialBundle\Form\CreateAnswerForm;
use Acme\TutorialBundle\Form\EditAnswerForm;

/**
 * Answer controller.
 *
 * @Route("admin/answer")
 */
class AnswerController extends Controller
{
    /**
     * Lists all Answer entities.
     *
     * @Route("/", name="answer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $answers = $em->getRepository('AcmeTutorialBundle:Answer')->findAll();

        return $this->render('answer/index.html.twig',
            [
                'answers' => $answers,
            ]);
    }

    /**
     * Creates a new Answer entity.
     *
     * @Route("/new", name="answer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $questions = $this->get('model.question')->getAllQuestionAsArray();
        $form = $this->createForm(new CreateAnswerForm($questions));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $q = $this->get('model.answer')->create($form->getData());

            return $this->redirectToRoute('answer_show', ['id' => $q->getId()]);
        }

        return $this->render('answer/new.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

    /**
     * Finds and displays a Answer entity.
     *
     * @Route("/{id}", name="answer_show")
     * @Method("GET")
     */
    public function showAction(Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);

        return $this->render('answer/show.html.twig',
            [
                'answer'      => $answer,
                'delete_form' => $deleteForm->createView(),
            ]);
    }

    /**
     * Displays a form to edit an existing Answer entity.
     *
     * @Route("/{id}/edit", name="answer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id, Request $request)
    {

        $questions = $this->get('model.question')->getAllQuestion();
        $answer = $this->get('model.answer')->getAnswerById($id);

        $deleteForm = $this->createDeleteForm($answer);
        $editForm = $this->createForm(new EditAnswerForm($questions), $answer);
        $editForm->handleRequest($request);

        if ($editForm->isValid() && $editForm->isSubmitted()) {

            $q = $this->get('model.question')->update($editForm->getData(), $answer);

            return $this->redirectToRoute('answer_index');
        }

        return $this->render('answer/edit.html.twig',
            [
                'answer'      => $answer,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]);
    }

    /**
     * Deletes a Answer entity.
     *
     * @Route("/{id}", name="answer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Answer $answer)
    {
        $form = $this->createDeleteForm($answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($answer);
            $em->flush();
        }

        return $this->redirectToRoute('answer_index');
    }

    /**
     * Creates a form to delete a Answer entity.
     *
     * @param Answer $answer The Answer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Answer $answer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('answer_delete', ['id' => $answer->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
