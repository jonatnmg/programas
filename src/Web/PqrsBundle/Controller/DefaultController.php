<?php

namespace Web\PqrsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Web\PqrsBundle\Entity\Pqrs;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Pqrs/Default/index.html.twig');
    }
    public function principalAction(Request $request)
    {
        $usuario = $this->getUser();
        $id = $usuario->getId();
        $nombre_completo = $usuario->getNombre()." ".$usuario->getApellidos();
                
        return $this->render('@Pqrs/Default/nuevo.html.twig', array (
            "nombre_usuario" => $nombre_completo
        ));
    }
    public function procesarAction(Request $request)
    {        
        $metodo = $request->getMethod();
        
        if ($metodo == 'POST') 
        {
            $nm = ($request->get('name'));
            $orden = ($request->get('orden'));
            $est = $request->get('estado');
            $id = $request->get('idEnviado',0); //id = 0 => insert nuevo
            $iud = $request->get('iud',0); //iud = 0 => Nuevo, 1 => Modificar, iud = 2 => Eliminar 

            if ($id == 0 && $iud == 0) //NUEVO
            {
                $em = $this->getDoctrine()->getManager();
                $duplicado = $em->getRepository('PqrsBundle:Pqrs')->findOneByNombre("$nm");

                if ($duplicado != null)
                   $datos[]  = array ("msg" => utf8_encode("Registro duplicado"));
                
                if ($duplicado == null) //Devuelve null si no encuentrada nada en la consulta
                {
                    $pqrs = new Pqrs();
                    $pqrs->setOrden($orden);
                    $pqrs->setEstado($est);
                    $pqrs->setNombre($nm);
                    $em->persist($pqrs);
                    $em->flush();              

                    $idNuevo = $pqrs->getId();

                    if (isset($idNuevo))
                    {                    
                        $datos[]  = array ("msg" => "Guardado correctamente");
                    }
                    else
                    {
                        $datos[]  = array ("msg" => utf8_encode("Error al guardar"));                        
                    }
                }
            }            
            else if ($id > 0 && $iud == 1) //MODIFICAR
            {
                $datos[]  = array ("msg" => $this->modificar($id,$nm,$orden,$est));
                             
            }
            else if ($id > 0 && $iud == 2) //ELIMINAR
            {
               $em = $this->getDoctrine()->getManager();
                $eliminar = $em->getRepository('PqrsBundle:Pqrs')->DeletePQRS($id); 
                               
                if ($eliminar > 0)
                {
                   $datos[]  = array ("msg" => "Eliminado correctamente");
                }
                else
                {
                    $datos[]  = array ("msg" => ("Error al eliminar"));
                }
            }            
          return new Response(json_encode($datos), 200, array('Content-Type'=>'application/json'));              
        }  
    }
    
    public function todopqrsAction(Request $request)
    {
        $metodo = $request->getMethod();
        
        if ($metodo == 'POST') 
        {
            $em = $this->getDoctrine()->getManager();
            $search_array = json_encode($request->get("search"));
            $separar = explode('"', $search_array);            
            $search = $separar[3]; //CONTIENE EL VALOR
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);           
            $todo_PQRS = $em->getRepository('PqrsBundle:Pqrs')->FindTodasLosPQRS($search, $start, $length);
            $recordsFiltered = 1;
            
            if ($todo_PQRS)
            {
                foreach($todo_PQRS as $dato)
                {
                    if ($dato['estado'] == false ){ $estado = "Inactivo"; }                    
                    else {                    $estado = "Activo";       }

                    $datos["data"][] = array("id" => $dato['id'],"nombre" => $dato['nombre'],"estado" => $estado,"orden" => $dato['orden']);
                    $recordsFiltered++;
                }
                
                $recordsTotal = $em->getRepository('PqrsBundle:Pqrs')->CountTodosLosPQRS();
                
                $datos["recordsFiltered"] = $recordsFiltered;
                $datos["recordsTotal"] = $recordsTotal[0]["total"];                
            }
            else
            {
                $recordsFiltered = 0 ;
                $recordsTotal = $em->getRepository('PqrsBundle:Pqrs')->CountTodosLosPQRS();
                
                $datos["recordsFiltered"] = $recordsFiltered;
                $datos["recordsTotal"] = $recordsTotal[0]["total"];   
                $datos["data"] = array("data" => $todo_PQRS);
            }
            
            return new Response (json_encode($datos)); 
        }
    }
    public function modificar($id,$nombre,$orden,$estado)
    {
        $em = $this->getDoctrine()->getManager();
        $modificar = $em->getRepository('PqrsBundle:Pqrs')->UpdatePQRS($id,$nombre,$orden,$estado); 
        
        if ($modificar > 0)
        {
            return "Modificado correctamente";
        }
        else
        {
            return "Sin modificar"; 
        }
    }
}
