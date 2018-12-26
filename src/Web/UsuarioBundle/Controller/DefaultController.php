<?php

namespace Web\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $usuario = $this->getUser();
        $id = $usuario->getId();
        $alertas = 5;
        $nombre_completo = $usuario->getNombre()." ".$usuario->getApellidos();
        
        return $this->render('@Usuario/Default/dashboard.html.twig', array (
            "nombre_usuario" => $nombre_completo,
            "alertas" => $alertas
        ));
    }
    
    public function abrirLoginAction()
    {
        return $this->render('@Usuario/Default/login.html.twig', array(
                'last_username' => "",
                'error' => null,
        ));
     }
    
    public function loginAction(Request $request)
    {
        //Llamamos al servicio de autenticacion
        $authenticationUtils = $this->get('security.authentication_utils');

        // conseguir el error del login si falla
        $error = $authenticationUtils->getLastAuthenticationError();

        // ultimo nombre de usuario que se ha intentado identificar
        $lastUsername = $authenticationUtils->getLastUsername();
                
        return $this->render('@Usuario/Default/login.html.twig', array(
                'last_username' => $lastUsername,
                'error' => $error,
        ));
    }
}
