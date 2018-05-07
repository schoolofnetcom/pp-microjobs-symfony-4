<?php

namespace App\Controller;

use App\Entity\Contratacoes;
use App\Entity\Servico;
use App\Entity\Usuario;
use App\Form\ServicoType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class ServicosController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/servicos", name="servicos")
     */
    public function index()
    {
        return $this->render('servicos/index.html.twig', [
            'controller_name' => 'ServicosController',
        ]);
    }

    /**
     * @Route("/painel/servicos/cadastrar", name="cadastrar_job")
     * @Template("servicos/novo-micro-jobs.html.twig")
     */
    public function cadastrar(Request $request, UserInterface $user)
    {
        $servico = new Servico();
        $form = $this->createForm(ServicoType::class, $servico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagem = $servico->getImagem();
            $nome_arquivo = md5(uniqid()) . "." . $imagem->guessExtension();
            $imagem->move(
                $this->getParameter('caminho_img_job'),
                $nome_arquivo
            );
            $servico->setImagem($nome_arquivo);


            $servico->setUsuario($user);

            $servico->setValor(30.00);
            $servico->setStatus("A");

            $this->em->persist($servico);
            $this->em->flush();

            $this->addFlash("success", "Cadastrado com sucesso!");
            return $this->redirectToRoute('painel');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/painel/servico/excluir/{id}", name="excluir_servico")
     */
    public function excluir(Servico $servico)
    {
        $servico->setStatus("E");
        $this->em->persist($servico);
        $this->em->flush();

        $this->addFlash("success", "Excluído com sucesso!");
        return $this->redirectToRoute('painel');
    }

    /**
     * @Route("/contratar-servico/{id}/{slug}", name="contratar_servico")
     */
    public function contratar_servico(Servico $servico, UserInterface $user)
    {
        //TODO: VERIFICAR ACESSO SOMENTE SE LOGADO

        $contratacao = new Contratacoes();
        $contratacao->setValor($servico->getValor())
            ->setCliente($user)
            ->setFreelancer($servico->getUsuario())
            ->setServico($servico)
            ->setStatus("A");

        $this->em->persist($contratacao);
        $this->em->flush();

        $this->get('email')->enviar(
            $user->getNome() . ' - Contratação de serviço',
            [$user->getEmail() => $user->getNome()],
            'emails/servicos/contratacao_cliente.html.twig', [
                'servico' => $servico,
                'cliente' => $user
            ]
        );

        $this->get('email')->enviar(
            $servico->getUsuario()->getNome() . ', Parabéns!',
            [$servico->getUsuario()->getEmail() => $servico->getUsuario()->getNome()],
            'emails/servicos/contratacao_freelancer.html.twig', [
                'servico' => $servico,
                'cliente' => $user
            ]
        );

        $this->addFlash("success", "Serviço foi contratado!");
        return $this->redirectToRoute('default');
    }

    /**
     * @Route("/painel/servicos/listar-compras", name="listar_compras")
     * @Template("servicos/listar-compras.html.twig")
     */
    public function listar_compras(UserInterface $user)
    {
        $usuario = $this->em->getRepository(Usuario::class)->find($user);

        return [
            'compras' => $usuario->getCompras()
        ];
    }

    /**
     * @Route("/painel/servicos/listar-vendas", name="listar_vendas")
     * @Template("servicos/listar-vendas.html.twig")
     */
    public function listar_vendas(UserInterface $user)
    {
        $usuario = $this->em->getRepository(Usuario::class)->find($user);

        return [
            'vendas' => $usuario->getVendas()
        ];
    }
}
