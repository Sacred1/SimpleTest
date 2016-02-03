<?php

namespace Acme\TutorialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="Acme\TutorialBundle\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text_answer", type="string", length=255)
     */
    private $textAnswer;

    /**
     * @var bool
     *
     * @ORM\Column(name="correct_answer", type="boolean")
     */
    private $correctAnswer;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set textAnswer
     *
     * @param string $textAnswer
     * @return Answer
     */
    public function setTextAnswer($textAnswer)
    {
        $this->textAnswer = $textAnswer;

        return $this;
    }

    /**
     * Get textAnswer
     *
     * @return string 
     */
    public function getTextAnswer()
    {
        return $this->textAnswer;
    }

    /**
     * Set correctAnswer
     *
     * @param boolean $correctAnswer
     * @return Answer
     */
    public function setCorrectAnswer($correctAnswer)
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }

    /**
     * Get correctAnswer
     *
     * @return boolean 
     */
    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Question"))
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
     */
    protected $question;

    /**
     * Set question
     *
     * @param \Acme\TutorialBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(\Acme\TutorialBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Acme\TutorialBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
