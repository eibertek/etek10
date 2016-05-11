<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Games\TCGBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;


class FiltersTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('base64', array($this, 'base64_encode')),
        );
    }

    public function base64_encode($string)
    {
        return base64_encode($string);
    }

    public function getName()
    {
        return 'AdminBundle';
    }
}