<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return true;
    }

    public function getCredentials(Request $request) # FIRST
    {
        $credentials = [
            'email'       => $request->request->get('email'),
            'password'    => $request->request->get('password'),
            '_csrf_token' => $request->request->get('_csrf_token')
        ];

        $request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider) # SECOND
    {
        // TODO: Implement getUser() method.
    }

    public function checkCredentials($credentials, UserInterface $user) # THIRD
    {
        // TODO: Implement checkCredentials() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey) # FORTH
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }
}
