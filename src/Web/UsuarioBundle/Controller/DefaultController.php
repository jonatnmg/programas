<?php

namespace Web\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Usuario/Default/index.html.twig');
    }
    
    public function loginAction(Request $request)
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        
        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR,
                $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );
        
        return $this->render('@Usuario:Default:login.html.twig', array(
                'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
                'error' => $error
        ));
    }
}
