<?php

namespace Web\MaestrasBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CargoRepository extends EntityRepository
{
    public function FindTodas($search, $start, $length)
    {
        $em = $this->getEntityManager();
            $dql = "SELECT p.nombre, p.estado,p.descripcion, p.id";
            $dql.= " FROM MaestrasBundle:Cargo p";
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
            $dql.= " FROM MaestrasBundle:Cargo p";           
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults(1);
        return $consulta->getArrayResult();
    }
    
    public function Delete($id)
    {
        $em = $this->getEntityManager();
            $dql = " DELETE MaestrasBundle:Cargo p ";           
            $dql.= " WHERE p.id = :id ";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id',$id);
        $consulta->setMaxResults(1);
        
        return $consulta->getArrayResult();
    }
    
    public function Update($id,$nombre,$descripcion,$estado)
    {
        $em = $this->getEntityManager();
            $dql = " UPDATE MaestrasBundle:Cargo p ";
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
    
    //Ejemplo consulta solo un resultado 
    public function findOfertaDelDia($ciudad)
    {
        $fechaPublicacion = new \DateTime('today');
        $fechaPublicacion->setTime(23, 59, 59);
        
        $em = $this->getEntityManager();
        
        $dql = 'SELECT o, c, t
            FROM OfertaBundle:Oferta o
            JOIN o.ciudad c JOIN o.tienda t
            WHERE o.revisada = true
            AND o.fecha_publicacion < :fecha
            AND c.slug = :ciudad
            ORDER BY o.fecha_publicacion DESC';
        
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('fecha', $fechaPublicacion);
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);
        
        return $consulta->getSingleResult();
    }
}