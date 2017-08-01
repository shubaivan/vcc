<?php

namespace AppBundle\Security;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiUserAuthenticator extends AbstractGuardAuthenticator
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

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'success' => false,
            'errors' => ['username and/or password parameters are missing or no user found'],
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function getCredentials(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
        } catch (\Exception $e) {
            throw new CustomUserMessageAuthenticationException('Can not decode request body');
        }

        if (isset($requestContent['username']) && isset($requestContent['password'])) {
            $username = $requestContent['username'];
            $password = $requestContent['password'];

            return ['username' => $username, 'password' => $password];
        }

        throw new BadCredentialsException('username and/or password parameter is missing');
        return null;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];

        return $userProvider->loadUserByUsername($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $plainPassword);

        if (!$isPasswordValid) {
            throw new BadCredentialsException('username and/or password is wrong');
        }

        if (is_a($user, 'AppBundle\Entity\User') && !$user->isEnabled()) {
            throw new CustomUserMessageAuthenticationException('Account locked. Please contact Efrito service center.');
        }

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['success' => false, 'errors' => [$exception->getMessage()]]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
        $s = '';
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
