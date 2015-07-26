<?php

namespace Etk\Bundle\SFPBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Etk\Bundle\SFPBundle\Entity\moneda;

/**
 * Description of MonedaToIdTransformer
 *
 * @author Mariano
 */
class MonedaToIdTransformer implements DataTransformerInterface {
    
    
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
    
    public function reverseTransform($moneda) {
        return $moneda;
    }
    
    public function transform($id) {
        return $id;
    }
}
