<?php

namespace Web\TipoasignacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Web\TipoasignacionBundle\Entity\TipoAsignacion;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Tipoasignacion/Default/index.html.twig');
    }    
    public function principalAction()
    {
        return $this->render('@Tipoasignacion/Default/nuevo.html.twig');
    }
    public function guardarAction(Request $request)
    {        
        $metodo = $request->getMethod();
        
        if ($metodo == 'POST') 
        {
            $nm = ($request->get('nombre'));
            $desc = ($request->get('desc'));
            $est = $request->get('estado');
            $id = $request->get('id',0); //id = 0 => insert nuevo
            $iud = $request->get('iud',0); //iud = 1 => Modificar, iud = 2 => Eliminar 

            if ($id == 0)
            {
                $em = $this->getDoctrine()->getManager();
                $duplicado = $em->getRepository('TipoasignacionBundle:TipoAsignacion')->findOneByNombre("$nm");

                if ($duplicado != null)
                   $datos[]  = array ("msg" => utf8_encode("Registro duplicado"));

                if ($duplicado == null) //Devuelve null si no encuentrada nada en la consulta
                {
                    $tipo = new TipoAsignacion();
                    $tipo->setDescripcion($desc);
                    $tipo->setEstado($est);
                    $tipo->setNombre($nm);
                    $em->persist($tipo);
                    $em->flush();              

                    $idNuevo = $tipo->getId();

                    if (isset($idNuevo))
                    {                    
                        $datos[]  = array ("msg" => $duplicado);
                    }
                    else
                    {
                        $datos[]  = array ("msg" => utf8_encode("Error al guardar"));
                    }
                }
            } 
          return new Response(json_encode($datos), 200, array('Content-Type'=>'application/json'));              
        }  
    }
}
