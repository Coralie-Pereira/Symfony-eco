<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    /**
     * Route de la page de connexion
     */
    public const LOGIN_ROUTE = 'app_login';

    /**
     * Constructeur de la classe
     *
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    /**
     * Fonction pour authentifier l'utilisateur
     *
     * @param Request $request
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        // Récupère l'email à partir de la requête
        $email = $request->request->get('email', '');

        // Enregistre le dernier nom d'utilisateur dans la session
        $request->getSession()->set(Security::LAST_USERNAME, $email);

        // Crée un objet Passport avec les informations de l'utilisateur
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                // Ajoute un badge de jeton CSRF
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                // Ajoute un badge pour se souvenir de l'utilisateur
                new RememberMeBadge(),
            ]
        );
    }

    /**
     * Gère le succès de l'authentification
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Récupère le chemin de redirection depuis la session s'il existe
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Redirige vers une route par défaut si aucun chemin de redirection n'est défini
        return new RedirectResponse($this->urlGenerator->generate('app_challenge_list'));

        // Lance une exception si la redirection par défaut n'est pas définie (pour un traitement ultérieur)
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    /**
     * Retourne l'URL de la page de connexion
     *
     * @param Request $request
     * @return string
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
