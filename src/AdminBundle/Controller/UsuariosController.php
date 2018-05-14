<?php
/**
 * Created by PhpStorm.
 * User: gilso_nb9zlec
 * Date: 10/05/2018
 * Time: 03:13
 */

namespace App\AdminBundle\Controller;


use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsuariosController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/usuarios/listar", name="admin_listar_usuarios")
     * @Template("@Admin/usuarios/listar.html.twig")
     */
    public function listar(Request $request)
    {
        $status = $request->get("status");

        if ($status === "" || is_null($status)) {
            $usuarios = $this->em->getRepository(Usuario::class)->findAll();
        } else {
            $usuarios = $this->em->getRepository(Usuario::class)->findBy(['status' => $status]);
        }

        return [
            'usuarios' => $usuarios,
            'status' => $status
        ];
    }

}