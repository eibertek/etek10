<?php

namespace Etk\ApiBundle\Service;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent as FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class PreDispatch
{
    public function onKernelController(FilterControllerEvent $event) {
        if(HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $controllers = $event->getController();
            if(is_array($controllers)) {
                $controller = $controllers[0];

                if(is_object($controller) && method_exists($controller, 'preExecute')) {
                    $controller->preExecute();
                }
            }
        }
    }
}