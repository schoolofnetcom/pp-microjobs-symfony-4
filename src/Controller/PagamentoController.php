<?php

namespace App\Controller;

use Moip\Auth\BasicAuth;
use Moip\Moip;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagamentoController extends Controller
{
    const TOKEN_MOIP = "DKSAHVW51B3OMDAY7UF0438TVUKIE5UK";
    const CHAVE_MOIP = "KWB9TGRKPSZL1BBQCDP91PMRX7ZCN6KJUXDJQVEO";
    /**
     * @Route("/pagamento", name="pagamento")
     */
    public function index()
    {

        $moip = new Moip(new BasicAuth(self::TOKEN_MOIP, self::CHAVE_MOIP), Moip::ENDPOINT_SANDBOX);

        dump($moip);

        return $this->render('pagamento/index.html.twig', [
            'controller_name' => 'PagamentoController',
        ]);
    }
}
