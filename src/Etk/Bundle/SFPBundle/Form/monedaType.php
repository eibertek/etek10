<?php

namespace Etk\Bundle\SFPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class monedaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sfpPrincipal','checkbox', array('label' => 'Es Principal:','required' => false))
            ->add('sfpFecha', 'text' , array('label' => 'Fecha:', 'attr' => ['id'=>'spfFecha']))
            ->add('sfpCaracter', 'text', array('label' => 'Signo:'))
            ->add('sfpRelacionDolar', 'number', array('label' => 'Valor Dolar:'))
            ->add('sfpDescripcion', 'text', array('label' => 'Descripcion:','required' => false))
            ->add('Guardar','submit')                 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Etk\Bundle\SFPBundle\Entity\moneda'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'etk_bundle_sfpbundle_moneda';
    }
}
