<?php

namespace Etk\Bundle\NoticiasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoticiasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      /*  private $nombre;
        private $descripcion;
        private $fecha;
        private $fechapublicacion;
        private $titulo;
        private $subtitulo;
        private $cuerpo;
        private $createddate;
        private $modifieddate;
        private $id;
        private $userid;
*/
        $builder
            ->add('nombre', 'text')
            ->add('descripcion', 'text')
            ->add('fecha', 'text')
            ->add('titulo', 'text')
            ->add('subtitulo', 'text')
            ->add('cuerpo', 'text')
      //      ->add('userId', 'entity')
            ->add('userId', 'entity', array(
                'class' => 'EtkUsuariosBundle:Usuarios',
                'property' => 'username',
            ))
            ->add('Guardar','submit')
            ->getForm()
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Etk\Bundle\NoticiasBundle\Entity\Noticias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'etk_bundle_noticiasbundle_noticias';
    }
}
