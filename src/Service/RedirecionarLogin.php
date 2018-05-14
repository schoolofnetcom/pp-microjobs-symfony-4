<?php
/**
 * Created by PhpStorm.
 * User: gilso_nb9zlec
 * Date: 10/05/2018
 * Time: 02:06
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class RedirecionarLogin implements AuthenticationSuccessHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $role = $token->getRoles()[0];

        if ($role->getRole() == "ROLE_ADMIN") {
            $retorno = new RedirectResponse($this->router->generate('admin_default'));
        } else {
            $retorno = new RedirectResponse($this->router->generate('painel'));
        }

        return $retorno;
    }
}