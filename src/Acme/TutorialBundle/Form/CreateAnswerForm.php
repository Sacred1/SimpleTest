<?php

namespace Acme\TutorialBundle\Form;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateAnswerForm extends AbstractType
{

    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textAnswer')
            ->add('correctAnswer', 'choice', ['choices' => [
                '0'=>'false',
                "1"=>'true'
            ]])
            ->add('question', 'choice', ['choices' => $this->question]);

    }

}
