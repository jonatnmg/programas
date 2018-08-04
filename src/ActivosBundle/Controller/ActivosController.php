<?Php

namespace Activos\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivosController
{
    public function numberAction()
    {
        $number = rand(0, 100);
        return new Response('<html><body> Número: '.$number.'</body></html>');
    }
}