<?php

namespace Games\TCGBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class CardType extends AbstractType
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
           $builder->add('Title', null, Array('label'=>'Titulo:'));
           $builder->add('Subtitle', null, Array('label'=>'Subtitulo:', 'required'=>false));           
           $builder->add('Description', null, Array('label'=>'Descripción:', 'required'=>false));                      
           $builder->add('Leyend', null, Array('label'=>'Leyenda:', 'required'=>false));                      
           $builder->add('Life', null, Array('label'=>'Vida:', 'required'=>false));                      
           $builder->add('Energy', null, Array('label'=>'Energia:', 'required'=>false));                      
           $builder->add('Defense', null, Array('label'=>'Defensa:', 'required'=>false));                      
           $builder->add('Attack', null, Array('label'=>'Ataque:', 'required'=>false));                      
           $builder->add('Image', 'file', Array('label'=>'Imagen:', 'required'=>false));                                 
           $builder->add('Guardar','submit');
           $builder->getForm();
/*      private 'StringId' => string '' (length=0)
      private 'Life' => float 10000
      private 'Energy' => float 4
      private 'Defense' => float 2000
      private 'Attack' => float 2000
      private 'Title' => string 'Carta Suprema' (length=13)
      private 'Image' => resource(434, stream)
      private 'Subtitle' => string 'Esta cartas es de prueba' (length=24)
      private 'Description' => string 'Carta de Prueba' (length=15)
      private 'Leyend' => string 'Probando la carta' (length=17)        
 * */
     }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Games\TCGBundle\Entity\card',
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



    
    