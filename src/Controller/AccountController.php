<?php

namespace App\Controller;

use App\ApiModel\Resource\Account\AccountDto;
use App\ApiModel\Resource\Errors\HttpError;
use App\ODM\AccountService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends AbstractController
{
    public function __construct(private readonly AccountService $service)
    {
    }

    #[Route(
        path: '/api/accounts/{accountUuid}',
        name: 'retrieveAccountByUuid',
        methods: 'GET',
    )]
    #[OA\Get(
        operationId: 'retrieveAccountByUuid',
        summary: "Retrieve account by account uuid",
        tags: ['account'],
        parameters: [
            new OA\Parameter(
                name: 'accountUuid',
                description: 'Account uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'account01')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Account',
                content: new OA\JsonContent(ref: new Model(type: AccountDto::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function retrieve(string $accountUuid): JsonResponse
    {
        $account = $this->service->getAccountByUuid($accountUuid);

        return $this->json($account);
    }

    #[Route(
        path: '/api/accounts/',
        name: 'retrieveAccountByEmail',
        methods: 'GET',
    )]
    #[OA\Get(
        operationId: 'accountRetrieve',
        summary: "Retrieve accounts by email",
        tags: ['account'],
        parameters: [
            new OA\Parameter(
                name: 'email',
                description: 'Email',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'john.doe@example.com')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Account',
                content: new OA\JsonContent(ref: new Model(type: AccountDto::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function retrieveByEmail(Request $request): JsonResponse
    {
        if (!$request->query->has('email')) {
            return $this->json(new HttpError('Email is required'), 400);
        }

        $accountDto = $this->service->getAccounts($request->query->get('email'));

        return $this->json($accountDto);
    }

    #[Route(
        path: '/api/accounts',
        name: 'createAccount',
        methods: 'POST',
    )]
    public function create(): JsonResponse
    {
        return $this->json([], 201);
    }

    #[Route(
        path: '/api/accounts',
        name: 'updateAccount',
        methods: 'PUT',
    )]
    public function update(): JsonResponse
    {
        return $this->json([], 204);
    }

    #[Route(
        path: '/api/accounts',
        name: 'updateAccount',
        methods: 'DELETE',
    )]
    public function delete(): JsonResponse
    {
        return $this->json([], 204);
    }
}
