<?php

namespace Etk\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsuariosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text')
            ->add('apellido', 'text')
            ->add('email', 'email')
            ->add('username', 'text')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('activate', 'checkbox', array(
                'label'    => 'Active',
                'required' => false,
                'mapped'=>false
            ));
           $builder->add('Guardar','submit');
            if($options['activar']){           
                $builder->add('Activar','button');
            }
            if($options['banear']){                       
                $builder->add('Banear','button');
            }
           $builder->add('Borrar','button');
           $builder->getForm();
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Etk\Bundle\UsuariosBundle\Entity\Usuarios',
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



    
    