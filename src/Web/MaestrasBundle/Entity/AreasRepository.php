<?php

namespace Web\MaestrasBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AreasRepository extends EntityRepository
{
    public function FindTodas($search, $start, $length)
    {
        $em = $this->getEntityManager();
            $dql = "SELECT p.nombre, p.estado,p.descripcion, p.id";
            $dql.= " FROM MaestrasBundle:Areas p";
            $dql.= " WHERE p.nombre LIKE '".$search."%' ";
            $dql.= " ORDER BY p.nombre ASC";
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults($length);
        $consulta->setFirstResult($start);
        
        return $consulta->getArrayResult();
    }
    
    public function CountTodos()
    {
        $em = $this->getEntityManager();
            $dql = "SELECT COUNT(p.id) as total ";
            $dql.= " FROM MaestrasBundle:Areas p";           
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults(1);
        return $consulta->getArrayResult();
    }
    
    public function Delete($id)
    {
        $em = $this->getEntityManager();
            $dql = " DELETE MaestrasBundle:Areas p ";           
            $dql.= " WHERE p.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
    
    public function Update($id,$nombre,$descripcion,$estado)
    {
        $em = $this->getEntityManager();
            $dql = " UPDATE MaestrasBundle:Areas p ";
            $dql.= " SET p.nombre = :nombre, p.estado = :estado, p.descripcion = :descripcion";
            $dql.= " WHERE p.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setParameter('nombre',$nombre);
        $consulta->setParameter('descripcion',$descripcion);
        $consulta->setParameter('estado',$estado);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
}