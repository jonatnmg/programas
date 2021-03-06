<?php

namespace Web\TipoasignacionBundle\Entity;
use Doctrine\ORM\EntityRepository;

class TipoAsignacionRepository extends EntityRepository
{
    public function FindTodasLosTiposAsignacion($search, $start, $length)
    {
        $em = $this->getEntityManager();
            $dql = "SELECT t.nombre, t.estado,t.descripcion, t.id";
            $dql.= " FROM TipoasignacionBundle:TipoAsignacion t";
            $dql.= " WHERE t.nombre LIKE '".$search."%' ";
            $dql.= " ORDER BY t.nombre ASC";
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults($length);
        $consulta->setFirstResult($start);
        
        return $consulta->getArrayResult();
    }
    
    public function CountTodosLosTiposAsignacion()
    {
        $em = $this->getEntityManager();
            $dql = "SELECT COUNT(t.id) as total ";
            $dql.= " FROM TipoasignacionBundle:TipoAsignacion t";           
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults(1);
        return $consulta->getArrayResult();
    }
    
    public function DeleteTiposAsignacion($id)
    {
        $em = $this->getEntityManager();
            $dql = " DELETE TipoasignacionBundle:TipoAsignacion t ";           
            $dql.= " WHERE t.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
    
    public function UpdateTiposAsignacion($id,$nombre,$descripcion,$estado)
    {
        $em = $this->getEntityManager();
            $dql = " UPDATE TipoasignacionBundle:TipoAsignacion t ";
            $dql.= " SET t.nombre = :nombre, t.estado = :estado, t.descripcion = :descripcion";
            $dql.= " WHERE t.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setParameter('nombre',$nombre);
        $consulta->setParameter('descripcion',$descripcion);
        $consulta->setParameter('estado',$estado);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
}