<?php

namespace Acme\TutorialBundle\Model;

use Doctrine\ORM\EntityManager;

class LevelModel
{

    protected $em;
    private $levelRepo;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->levelRepo = $this->em->getRepository('AcmeTutorialBundle:Level');
    }

    public function getAllLevel()
    {
        return $this->levelRepo->findAll();
    }

    public function getAllLevelAsArray()
    {
        $array = [];
        foreach ($this->levelRepo->findAll() as $f) {
            $array[$f->getId()] = $f->getName();
        }

        return $array;
    }
}