<?php

namespace GergelyPolonkai\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CodeChunkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language')
            ->add('title')
            ->add('content')
            ->add('description', 'ckeditor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GergelyPolonkai\FrontBundle\Entity\CodeChunk'
        ));
    }

    public function getName()
    {
        return 'gergelypolonkai_frontbundle_codechunktype';
    }
}
