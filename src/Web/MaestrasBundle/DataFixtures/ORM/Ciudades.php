<?php

namespace Web\MaestrasBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Web\MaestrasBundle\Entity\Ciudad;

class Ciudades extends AbstractFixture implements OrderedFixtureInterface
{    
    public function getOrder()
    {
        return 1;
    }
    
    public function load(ObjectManager $manager)
    {
        $ciudades = array(
            array('nombre' => 'Barrancabermeja', 'estado' => 1 ),
            array('nombre' => 'Bucaramanga', 'estado' => 1 ),
            array('nombre' => 'Garzon', 'estado' => 1 ),
            array('nombre' => 'Necocli', 'estado' => 1 ),            
            array('nombre' => 'Villanueva', 'estado' => 1 ),
            );
                
        foreach ($ciudades as $ciudad)
        {
            $entidad = new Ciudad();
            $entidad->setNombre($ciudad['nombre']);            
            $entidad->setEstado($ciudad['estado']);
            
            $manager->persist($entidad);
        }
        
        $manager->flush();
    }
}