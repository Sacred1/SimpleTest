<?php

namespace Acme\TutorialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function adminAction()
    {
        return $this->render('AcmeTutorialBundle:Default:admin.html.twig');
    }

    public function listLevelsAction()
    {
        $levels = $this->get('model.level')->getAllLevel();
        $questions = $this->get('model.question')->getAllQuestion();

        return $this->render('AcmeTutorialBundle:Default:listLevels.html.twig',
            ["questions" => $questions, "levels" => $levels]);
    }


    public function listQuestionsAction($id)
    {
        $questions = $this->get('model.question')->getQuestionAndAnswerByLevel($id);
        dump($questions);
        exit;
    }
}
