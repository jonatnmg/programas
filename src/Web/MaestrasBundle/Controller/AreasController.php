<?php

namespace Web\MaestrasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Web\MaestrasBundle\Entity\Areas;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AreasController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Maestras/Areas/index.html.twig');
    }
    public function principalAction()
    {
        $usuario = $this->getUser();
        $id = $usuario->getId();
        $nombre_completo = $usuario->getNombre()." ".$usuario->getApellidos();
        
        return $this->render('@Maestras/Areas/nuevo.html.twig', array (
            "nombre_usuario" => $nombre_completo
        ));
    }
    public function procesarAction(Request $request)
    {        
        $metodo = $request->getMethod();
        
        if ($metodo == 'POST') 
        {
            $nm = ($request->get('name'));
            $desc = ($request->get('desc'));
            $est = $request->get('estado');
            $id = $request->get('idEnviado',0); //id = 0 => insert nuevo
            $iud = $request->get('iud',0); //iud = 0 => Nuevo, 1 => Modificar, iud = 2 => Eliminar 

            if ($id == 0 && $iud == 0) //NUEVO
            {
                $em = $this->getDoctrine()->getManager();
                $duplicado = $em->getRepository('MaestrasBundle:Areas')->findOneByNombre($nm);

                if ($duplicado != null)
                   $datos[]  = array ("msg" => utf8_encode("Registro duplicado"));
                
                if ($duplicado == null) //Devuelve null si no encuentrada nada en la consulta
                {
                    $insertar = new Areas();
                    $insertar->setDescripcion($desc);
                    $insertar->setEstado($est);
                    $insertar->setNombre($nm);
                    $em->persist($insertar);
                    $em->flush();              

                    $idNuevo = $insertar->getId();

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
               $datos[]  = array ("msg" => $this->modificar($id,$nm,$desc,$est));                             
            }
            else if ($id > 0 && $iud == 2) //ELIMINAR
            {
                $em = $this->getDoctrine()->getManager();
                $eliminar = $em->getRepository('MaestrasBundle:Areas')->Delete($id); 
                               
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
    public function listaAction(Request $request)
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
            $todo = $em->getRepository('MaestrasBundle:Areas')->FindTodas($search, $start, $length);
            $recordsFiltered = 1;
            
            if ($todo)
            {
                foreach($todo as $dato)
                {
                    if ($dato['estado'] == false ){ $estado = "Inactivo"; }                    
                    else {                    $estado = "Activo";       }

                    $datos["data"][] = array("id" => $dato['id'],"nombre" => $dato['nombre'],"estado" => $estado,"descripcion" => $dato['descripcion']);
                    $recordsFiltered++;
                }
                
                $recordsTotal = $em->getRepository('MaestrasBundle:Areas')->CountTodos();                
                $datos["recordsFiltered"] = $recordsFiltered;
                $datos["recordsTotal"] = $recordsTotal[0]["total"];                
            }
            else
            {
                $recordsFiltered = 0 ;
                $recordsTotal = $em->getRepository('MaestrasBundle:Areas')->CountTodos();                
                $datos["recordsFiltered"] = $recordsFiltered;
                $datos["recordsTotal"] = $recordsTotal[0]["total"];   
                $datos["data"] = array("data" => $todo);
            }            
            return new Response (json_encode($datos)); 
        }
    }
    public function modificar($id,$nombre,$descripcion,$estado)
    {
        $em = $this->getDoctrine()->getManager();
        $modificar = $em->getRepository('MaestrasBundle:Areas')->Update($id,$nombre,$descripcion,$estado); 
        
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
