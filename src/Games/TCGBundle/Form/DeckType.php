<?php

namespace Games\TCGBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class DeckType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /*     ->add('activate', 'checkbox', array(
                'label'    => 'Active',
                'required' => false,
                'mapped'=>false
            ));
        * */
           $builder->add('Name', null, Array('label'=>'Nombre del Mazo:'));
           $builder->add('Active', 'checkbox', Array('label'=>'Activo:'));           
           $builder->add('Premium', 'checkbox', Array('label'=>'Premium:', 'required'=>false));                      
           $builder->add('Guardar','submit');
           $builder->getForm();
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Games\TCGBundle\Entity\deck',
            'activar' => false,
            'banear' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'etk_bundle_usuariosbundle_usuarios';
    }
    
}



    
    