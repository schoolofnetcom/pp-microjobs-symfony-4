<?php
/**
 * Created by PhpStorm.
 * User: gilso_nb9zlec
 * Date: 10/05/2018
 * Time: 04:12
 */

namespace App\AdminBundle\Controller;


use App\Entity\Contratacoes;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RelatoriosController extends Controller
{

    //TODO: Criar Controller base
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/relatorios/faturamento", name="admin_relatorio_faturamento")
     */
    public function faturamento(Request $request)
    {
        $exportar = $request->get("exportar");

        $faturamento = $this->em->getRepository(Contratacoes::class)->retornaFaturamento();

        if($exportar === "pdf") {
            $html = $this->renderView("@Admin/relatorios/relatorio_faturamento.html.twig", [
                'faturamento' => $faturamento
            ]);

            $dompdf = $this->get('dompdf');
            $dompdf->streamHtml($html, "relatorio_faturamento.pdf");

        } else {
            return $this->render("@Admin/relatorios/faturamento.html.twig", [
                'faturamento' => $faturamento
            ]);
        }
    }

}