<?php

namespace App\Controller\Api;

use App\Manager\UserManager;
use App\Service\ExternalUserHttpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(
        private UserManager $userManager,
        private ExternalUserHttpService $externalUserHttpService
    ) {}

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $users = $this->userManager->findAll();
        return $this->json($users);
    }

    #[Route('/{id}', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function get(int $id): JsonResponse
    {
        $user = $this->userManager->findUser($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }
        return $this->json($user);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->userManager->createUser($data['email'], $data['name']);
        return $this->json($user, 201);
    }

    #[Route('/{id}', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $user = $this->userManager->findUser($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }
        $data = json_decode($request->getContent(), true);
        $user = $this->userManager->updateUser($user, $data['email'], $data['name']);
        return $this->json($user);
    }

    #[Route('/{id}', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->userManager->findUser($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }
        $this->userManager->deleteUser($user);
        return $this->json(null, 204);
    }

    #[Route('/external/{id}', methods: ['GET'])]
    public function getExternal(int $id): JsonResponse
    {
        try {
            $user = $this->externalUserHttpService->getUser($id);

            $this->userManager->createUser($user['email'], $user['name']);


            return $this->json($user);
        } catch (\RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], 502);
        }
    }
}
