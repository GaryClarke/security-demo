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
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
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

    /**
     * Should this authenticator be used for this request?
     *
     * @param Request $request
     * @return bool|void
     */
    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request) # FIRST
    {
        $credentials = [
            'email'       => $request->request->get('email'),
            'password'    => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        $request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

        return $credentials;
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * @param array $credentials
     * @param UserProviderInterface $userProvider
     * @return object|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider) # SECOND
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']])
            ?? throw new UsernameNotFoundException(sprintf('User "%s" not found', $credentials['email']));

        return $user;
    }

    /**
     * Check credentials
     *
     * Check csrf token is valid
     * Check password is valid
     *
     * @param array $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user) # THIRD$
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }


    /**
     * What should happen once the user is authenticated?
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|void|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey) # FOURTH
    {
        dd($token);
        // 1. Try to redirect the user to their original intended path

        // 2. Redirect the user to a welcome page / home page
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }
}
