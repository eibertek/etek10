<?php

namespace Etk\Bundle\SFPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class registroType extends AbstractType
{
    
  
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sfpNombre','text', array('label' => 'Registro:'))
            ->add('sfpFecha', 'text' , array('label' => 'Fecha:', 'attr' => ['id'=>'spfFecha']))
//            ->add('sfpCuenta', 'text', array('label' => 'Cuenta:','required' => false))
            ->add('sfpTipo', 'choice', array(
                'choices'  => array('+' => '+', '-' => '-'),
                'empty_data'  => '+'
            ))               
            ->add('sfpMonto', 'number', array('label' => 'Monto:'))
            ->add('sfpMoneda', 'moneda_selector')
            ->add('sfpDescripcion', 'text', array('label' => 'Descripcion:','required' => false))
            ->add('uniqueToken', 'hidden', array('data' => uniqid('form_')))    
            ->add('Guardar','submit')                
//            ->add('sfpFechaAlta')
//            ->add('sfpFechaEditado')
//            ->add('sfpIdUsuario')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Etk\Bundle\SFPBundle\Entity\registro'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'etk_bundle_sfpbundle_registro';
    }
}
