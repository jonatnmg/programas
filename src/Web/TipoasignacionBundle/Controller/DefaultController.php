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
    public function procesarAction(Request $request)
    {        
        $metodo = $request->getMethod();
        
        if ($metodo == 'POST') 
        {
            $nm = ($request->get('nombre'));
            $desc = ($request->get('desc'));
            $est = $request->get('estado');
            $id = $request->get('idEnviado',0); //id = 0 => insert nuevo
            $iud = $request->get('iud',0); //iud = 0 => Nuevo, 1 => Modificar, iud = 2 => Eliminar 

            if ($id == 0 && $iud == 0) //NUEVO
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
                $eliminar = $em->getRepository('TipoasignacionBundle:TipoAsignacion')->DeleteTiposAsignacion($id); 
                               
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
    
    public function todotipoasignacionAction(Request $request)
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
            $todo_tipo_asig = $em->getRepository('TipoasignacionBundle:TipoAsignacion')->FindTodasLosTiposAsignacion($search, $start, $length);
            $recordsFiltered = 1;
            
            if ($todo_tipo_asig)
            {
                foreach($todo_tipo_asig as $tipo)
                {
                    if ($tipo['estado'] == false ){ $estado = "Inactivo"; }                    
                    else {                    $estado = "Activo";       }

$datos["data"][] = array("id" => $tipo['id'],"nombre" => $tipo['nombre'],"estado" => $estado,"descripcion" => $tipo['descripcion'],"max"=>$start);
                    $recordsFiltered++;
                }
                
                $recordsTotal = $em->getRepository('TipoasignacionBundle:TipoAsignacion')->CountTodosLosTiposAsignacion();
                
                $datos["recordsFiltered"] = $recordsFiltered;
                $datos["recordsTotal"] = $recordsTotal[0]["total"];                
            }
            else
            {
                $recordsFiltered = 0 ;
                $recordsTotal = $em->getRepository('TipoasignacionBundle:TipoAsignacion')->CountTodosLosTiposAsignacion();
                
                $datos["recordsFiltered"] = $recordsFiltered;
                $datos["recordsTotal"] = $recordsTotal[0]["total"];   
                $datos["data"] = array("data" => $todo_tipo_asig);
            }
            
            return new Response (json_encode($datos)); 
        }
    }
    public function modificar($id,$nombre,$descripcion,$estado)
    {
        $em = $this->getDoctrine()->getManager();
        $modificar = $em->getRepository('TipoasignacionBundle:TipoAsignacion')->UpdateTiposAsignacion($id,$nombre,$descripcion,$estado); 
        
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
