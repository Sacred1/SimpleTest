<?php

namespace Acme\TutorialBundle\Model;

use Doctrine\ORM\EntityManager;

class AnswerModel
{

    protected $em;
    private $answerRepo;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->answerRepo = $this->em->getRepository('AcmeTutorialBundle:Answer');
    }

    public function getAnswerById($id)
    {
        return $this->answerRepo->find($id);
    }


    public function create(array $data)
    {
        $question = $this->em->getRepository('AcmeTutorialBundle:Question')->findOneById($data['question']);

        return $this->em->getRepository('AcmeTutorialBundle:Answer')->create($data, $question);
    }

}