<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Etk\Bundle\SFPBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Etk\Bundle\SFPBundle\Form\DataTransformer\MonedaToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonedaSelectorType extends AbstractType
{
    
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    } 
    
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new MonedaToIdTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $monedas = $this->om
            ->getRepository('EtkSFPBundle:moneda')
            ->findAll();
        $choices= Array();
        foreach($monedas as $moneda){
            $choices[$moneda->getSfpIdMoneda()] = $moneda->getSfpCaracter();
        }
        $resolver->setDefaults(array(
            'choices'  => $choices,
            'expanded' => false,
            'multiple' => false,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'moneda_selector';
    }
    
}