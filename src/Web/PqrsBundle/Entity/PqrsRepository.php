<?php
namespace Web\PqrsBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PqrsRepository extends EntityRepository
{
    public function FindTodasLosPQRS($search, $start, $length)
    {
        $em = $this->getEntityManager();
            $dql = "SELECT p.nombre, p.estado,p.orden, p.id";
            $dql.= " FROM PqrsBundle:Pqrs p";
            $dql.= " WHERE p.nombre LIKE '".$search."%' ";
            $dql.= " ORDER BY p.nombre ASC";
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults($length);
        $consulta->setFirstResult($start);
        
        return $consulta->getArrayResult();
    }
    
    public function CountTodosLosPQRS()
    {
        $em = $this->getEntityManager();
            $dql = "SELECT COUNT(p.id) as total ";
            $dql.= " FROM PqrsBundle:Pqrs p";           
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults(1);
        return $consulta->getArrayResult();
    }
    
    public function DeletePQRS($id)
    {
        $em = $this->getEntityManager();
            $dql = " DELETE PqrsBundle:Pqrs p ";           
            $dql.= " WHERE p.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
    
    public function UpdatePQRS($id,$nombre,$orden,$estado)
    {
        $em = $this->getEntityManager();
            $dql = " UPDATE PqrsBundle:Pqrs p ";
            $dql.= " SET p.nombre = :nombre, p.estado = :estado, p.orden = :orden";
            $dql.= " WHERE p.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setParameter('nombre',$nombre);
        $consulta->setParameter('orden',$orden);
        $consulta->setParameter('estado',$estado);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
}