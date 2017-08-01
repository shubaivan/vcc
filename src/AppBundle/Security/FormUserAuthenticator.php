<?php

namespace AppBundle\Security;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class FormUserAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * LoginController constructor.
     *
     * @param Router              $router
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(Router $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getMethod() === 'POST' && $request->getRequestUri() === $this->router->generate('login')) {
            $username = $request->request->get('username');
            $request->getSession()->set(Security::LAST_USERNAME, $username);

            $password = $request->request->get('password');

            return ['username' => $username, 'password' => $password];
        }

        return null;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];

        try {
            $user = $userProvider->loadUserByUsername($username);
        } catch (\Exception $e) {
            throw new BadCredentialsException('login.username.or.password.wrong');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $plainPassword);

        if (empty($user->getPassword()) || !$isPasswordValid) {
            throw new BadCredentialsException('login.username.or.password.wrong');
        }

        if (is_a($user, 'AppBundle\Entity\User') && !$user->isEnabled()) {
            throw new CustomUserMessageAuthenticationException('Account locked. Please contact Efrito service center.');
        }

        return true;
    }

    public function supportsRememberMe()
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('dashboard'));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
}
