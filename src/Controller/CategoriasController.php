<?php

namespace App\Controller;

use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriasController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/categorias", name="categorias")
     */
    public function index()
    {
        return $this->render('categorias/index.html.twig', [
            'controller_name' => 'CategoriasController',
        ]);
    }

    /**
     * @return array
     * @Template("categorias/listar_topo.html.twig")
     */
    public function listar_topo()
    {
        $categorias = $this->em->getRepository(Categoria::class)->findAll();

        return [
            'categorias' => $categorias
        ];
    }
}
