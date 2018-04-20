<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UsuariosController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function index()
    {
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }

    /**
     * @Route("/usuarios/login", name="login")
     * @Template("usuarios/login.html.twig")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $user_name = $authUtils->getLastUsername();

        return [
            'last_username' => $user_name,
            'error' => $error
        ];
    }

    /**
     * @Route("/usuario/cadastrar", name="cadastrar_usuario")
     * @Template("usuarios/registro.html.twig")
     */
    public function cadastrar(Request $request, \Swift_Mailer $mailer)
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            $senha_cript = $encoder->encodePassword($usuario, $form->getData()->getPassword());
            $usuario->setSenha($senha_cript);

            $token = md5(uniqid());
            $usuario->setToken($token);

            $usuario->setRoles("ROLE_ADMIN");

            $this->em->persist($usuario);
            $this->em->flush();

            $mensagem = (new \Swift_Message($usuario->getNome() . ", ative sua conta no MicroJobs Son"))
                ->setFrom('noreply@email.com')
                ->setTo([$usuario->getEmail() => $usuario->getNome()])
                ->setBody($this->renderView("emails/usuarios/registro.html.twig", [
                    'nome' => $usuario->getNome(),
                    'token' => $usuario->getToken()
                ]), 'text/html');

            $mailer->send($mensagem);

            $this->addFlash("success", "Cadastrado com sucesso! Verifique seu e-mail para completar o cadastro!");
            return $this->redirectToRoute("default");
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/usuario/ativar-conta/{token}", name="email_ativar_conta")
     */
    public function ativar_conta($token)
    {
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['token' => $token]);
        $usuario->setStatus(true);
        $this->em->persist($usuario);
        $this->em->flush();

        $this->addFlash("success", "Cadastro foi ativado com sucesso! Informe seu e-mail e senha para acessar o sistema!");
        return $this->redirectToRoute("login");
    }
}
