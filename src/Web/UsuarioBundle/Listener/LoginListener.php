<?php

namespace Web\UsuarioBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener {
 
    public function onSecutiryInteractiveLogin (InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $usuario = $event->getAuthenticationToken()->getUser();
        $rol = $event->getAuthenticationToken()->getRoles();        
    }    
}
