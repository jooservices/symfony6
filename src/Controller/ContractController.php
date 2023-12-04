<?php

namespace App\Controller;

use App\ApiModel\Resource\Contract\ContractDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\ApiModel\Resource\Errors\HttpError;
use App\ODM\ContractService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContractController extends AbstractController
{
    public function __construct(private readonly ContractService $service)
    {
    }

    #[Route(
        path: '/api/contracts/{contractUuid}',
        name: 'retrieveContractByUuid',
        methods: 'GET',
    )]
    #[OA\Get(
        operationId: 'retrieveContractByUuid',
        summary: "Retrieve contract by contract uuid",
        tags: ['contract'],
        parameters: [
            new OA\Parameter(
                name: 'contractUuid',
                description: 'Contract uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'contract01')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contract',
                content: new OA\JsonContent(ref: new Model(type: ContractDto::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function retrieve(string $contractUuid): JsonResponse
    {
        $contract = $this->service->getContractByUuid($contractUuid);

        if ($contract instanceof JsonResponse) {
            return $contract;
        }

        return $this->json($contract);
    }

    #[Route(
        path: '/api/contracts/',
        name: 'retrieveContractsByAccountUuid',
        methods: 'GET',
    )]
    #[OA\Get(
        operationId: 'retrieveContractsByAccountUuid',
        summary: "Retrieve contracts by account uuid",
        tags: ['contract'],
        parameters: [
            new OA\Parameter(
                name: 'accountUuid',
                description: 'Account uuid',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'account01')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contracts',
                content: new OA\JsonContent(ref: new Model(type: ContractDto::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function retrieveByAccountUid(Request $request): JsonResponse
    {
        if (!$request->query->has('accountUuid')) {
            return $this->json(new HttpError('accountUuid is required'), 400);
        }

        $contracts = $this->service->getContracts($request->query->get('accountUuid'));

        if ($contracts instanceof JsonResponse) {
            return $contracts;
        }

        return $this->json($contracts);
    }

    #[Route(
        path: '/api/contracts',
        name: 'createContract',
        methods: 'POST',
    )]
    public function create(): JsonResponse
    {
        return $this->json([], 201);
    }

    #[Route(
        path: '/api/contracts',
        name: 'updateContract',
        methods: 'PUT',
    )]
    public function update(): JsonResponse
    {
        return $this->json([], 204);
    }

    #[Route(
        path: '/api/contracts',
        name: 'deleteContract',
        methods: 'DELETE',
    )]
    public function delete(): JsonResponse
    {
        return $this->json([], 204);
    }
}
