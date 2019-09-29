<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\AuthService;

class LoginController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * LoginController constructor.
     * @param AuthService $authService
     * @param UserRepository $userRepository
     */
    public function __construct(AuthService $authService, UserRepository $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/login", name="login")
     */
    public function indexAction(Request $request)
    {
        if (
            false === $request->request->get('username', false) ||
            false === $request->request->get('password', false)
        ) {
            return new JsonResponse([
                'error' => true,
                'data' => 'Missing credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->userRepository->findOneBy([
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        ]);

        if ($this->authService->userNeedsResetPassword($user)) {
            return new JsonResponse([
                'error' => true,
                'data' => 'User password is older than 28 days'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'error' => false,
            'data' => [
                $user->toArray()
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }
}
