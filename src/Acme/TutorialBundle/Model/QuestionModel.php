<?php

namespace Acme\TutorialBundle\Model;

use Doctrine\ORM\EntityManager;

class QuestionModel
{
    protected $em;
    private $questionRepo;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->questionRepo = $this->em->getRepository('AcmeTutorialBundle:Question');
    }

    public function getAllQuestion()
    {
        return $this->questionRepo->findAll();
    }

    public function getAllQuestionAsArray()
    {
        $array = [];
        foreach ($this->questionRepo->findAll() as $f) {
            $array[$f->getId()] = $f->getTitle();
        }

        return $array;
    }


    public function getQuestionById($id)
    {
        return $this->questionRepo->find($id);
    }

    public function getQuestionAndAnswerByLevel($id)
    {
        return $this->questionRepo->findQuestionAndAnswerByLevel($id);

    }

    public function create(array $data)
    {
        $level = $this->em->getRepository('AcmeTutorialBundle:Level')->findOneById($data['level']);

        return $this->em->getRepository('AcmeTutorialBundle:Question')->create($data['title'], $level);
    }

    public function update($data, $question)
    {

        $level = $this->em->getRepository('AcmeTutorialBundle:Level')->findOneById($data->getLevel()->getId());

        return $this->em->getRepository('AcmeTutorialBundle:Question')->update($question, $level);
    }
}