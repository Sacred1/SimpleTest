<?php

namespace Acme\TutorialBundle\Form;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateQuestionForm extends AbstractType
{

    public function __construct($level)
    {
        $this->level = $level;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('level', 'choice', ['choices' => $this->level]);
        $builder->add('title', 'text');
    }

}
