<?php

namespace Web\TipoasignacionBundle\Entity;
use Doctrine\ORM\EntityRepository;

class TipoAsignacionRepository extends EntityRepository
{
    public function FindTodasLosTiposAsignacion($search, $start, $length)
    {
        $em = $this->getEntityManager();
            $dql = "SELECT t.nombre, t.estado";
            $dql.= " FROM TipoasignacionBundle:TipoAsignacion t";
            $dql.= " WHERE t.nombre LIKE '".$search."%' ";
            $dql.= " ORDER BY t.nombre ASC";
        $consulta = $em->createQuery($dql);
        $consulta->setMaxResults($length);
        $consulta->setFirstResult($start);
        
        return $consulta->getArrayResult();
    }
}