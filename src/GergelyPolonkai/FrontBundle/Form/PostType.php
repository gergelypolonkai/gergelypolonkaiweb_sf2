<?php

namespace GergelyPolonkai\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('draft', null, array('required' => false))
            ->add('updateDate', 'checkbox', array('property_path' => false, 'required' => false, 'label' => 'Update creation date'))
            ->add('content', 'ckeditor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GergelyPolonkai\FrontBundle\Entity\Post'
        ));
    }

    public function getName()
    {
        return 'gergelypolonkai_frontbundle_posttype';
    }
}
