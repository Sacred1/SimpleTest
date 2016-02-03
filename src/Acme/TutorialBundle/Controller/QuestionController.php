<?php

namespace Acme\TutorialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\TutorialBundle\Entity\Question;
use Acme\TutorialBundle\Form\CreateQuestionForm;
use Acme\TutorialBundle\Form\EditQuestionForm;

/**
 * Question controller.
 *
 * @Route("admin/question")
 */
class QuestionController extends Controller
{
    /**
     * Lists all Question entities.
     *
     * @Route("/", name="question_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('AcmeTutorialBundle:Question')->findAll();

        return $this->render('question/index.html.twig',
            [
                'questions' => $questions,
            ]);
    }

    /**
     * Creates a new Question entity.
     *
     * @Route("/new", name="question_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $levels = $this->get('model.level')->getAllLevelAsArray();

        $form = $this->createForm(new CreateQuestionForm($levels));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $q = $this->get('model.question')->create($form->getData());

            return $this->redirectToRoute('question_show', ['id' => $q->getId()]);
        }

        return $this->render('question/new.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

    /**
     * Finds and displays a Question entity.
     *
     * @Route("/{id}", name="question_show")
     * @Method("GET")
     */
    public function showAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);

        return $this->render('question/show.html.twig',
            [
                'question'    => $question,
                'delete_form' => $deleteForm->createView(),
            ]);
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     * @Route("/{id}/edit", name="question_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id, Request $request)
    {

        $levels = $this->get('model.level')->getAllLevel();
        $question = $this->get('model.question')->getQuestionById($id);

        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm(new EditQuestionForm($levels), $question);
        $editForm->handleRequest($request);

        if ($editForm->isValid() && $editForm->isSubmitted()) {

            $q = $this->get('model.question')->update($editForm->getData(), $question);

            return $this->redirectToRoute('question_index');
        }

        return $this->render('question/edit.html.twig',
            [
                'question'    => $question,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]);
    }

    /**
     * Deletes a Question entity.
     *
     * @Route("/{id}", name="question_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Question $question)
    {
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }

        return $this->redirectToRoute('question_index');
    }

    /**
     * Creates a form to delete a Question entity.
     *
     * @param Question $question The Question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('question_delete', ['id' => $question->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
