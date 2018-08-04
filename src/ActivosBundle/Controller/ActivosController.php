<?Php

namespace ActivosBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivosController
{
    public function numberAction()
    {
        $number = rand(0, 100);
        return new Response('<html><body> Eso es un Número random: '.$number.'</body></html>');
    }
}