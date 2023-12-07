<?php

namespace App\Controller\Account;

use App\ApiModel\Resource\Address\AddressDto;
use App\ApiModel\Resource\Address\AddressFilter;
use App\ApiModel\Resource\Address\AddressList;
use App\ApiModel\Resource\Error\HttpError;
use App\ODM\AddressService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AccountAddressController extends AbstractController
{
    public function __construct(private readonly AddressService $addressService)
    {
    }

    #[Route(
        path: '/api/accounts/{accountUid}/addresses',
        name: 'addressCreate',
        methods: 'POST',
    )]
    #[OA\Post(
        operationId: 'addressCreate',
        summary: "Create address",
        requestBody: new OA\RequestBody(
            description: 'Address entity - uid will be overwritten',
            content: new OA\JsonContent(ref: new Model(type: AddressDto::class))
        ),
        tags: ['address'],
        parameters: [
            new OA\Parameter(
                name: 'accountUid',
                description: 'Account Uid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'a93ff1ff-09ff-480c-9bc4-2a8da9bd22ae')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'New address',
                content: new OA\JsonContent(ref: new Model(type: AddressDto::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function create(#[MapRequestPayload] AddressDto $dto, string $accountUid): JsonResponse
    {
        $address = $this->addressService->create($dto, $accountUid);

        if ($address instanceof JsonResponse) {
            return $address;
        }

        return $this->json($address);
    }

    #[Route(
        path: '/api/accounts/{accountUid}/addresses/{addressUid}',
        name: 'addressUpdate',
        methods: 'PUT',
    )]
    #[OA\Put(
        operationId: 'addressUpdate',
        summary: "Update address",
        requestBody: new OA\RequestBody(
            description: 'Address entity',
            content: new OA\JsonContent(ref: new Model(type: AddressDto::class))
        ),
        tags: ['address'],
        parameters: [
            new OA\Parameter(
                name: 'accountUid',
                description: 'Account uid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'a93ff1ff-09ff-480c-9bc4-2a8da9bd22ae')
            ),
            new OA\Parameter(
                name: 'addressUid',
                description: 'Address uid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'a93ff1ff-09ff-480c-9bc4-2a8da9bd2312')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Update address',
                content: new OA\JsonContent(ref: new Model(type: AddressDto::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function update(#[MapRequestPayload] AddressDto $dto, string $addressUid, string $accountUid): JsonResponse
    {
        $address = $this->addressService->update($dto, $addressUid, $accountUid);
        
        if ($address instanceof JsonResponse) {
            return $address;
        }

        return $this->json($address);
    }

    #[Route(
        path: '/api/accounts/{accountUid}/addresses',
        name: 'addressListingByAccount',
        methods: 'GET',
    )]
    #[OA\Get(
        operationId: 'addressListingByAccount',
        summary: "Listing addresses by account",
        tags: ['account'],
        parameters: [
            new OA\Parameter(
                name: 'accountUid',
                description: 'Account Uid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: 'account01')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Addresses list',
                content: new OA\JsonContent(ref: new Model(type: AddressList::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Not found',
                content: new OA\JsonContent(ref: new Model(type: HttpError::class))
            ),
        ]
    )]
    public function list(string $accountUid): JsonResponse
    {
        $dto = new AddressFilter(['accountUid' => $accountUid]);
        $data = $this->addressService->list($dto);

        if ($data instanceof JsonResponse) {
            return $data;
        }

        return $this->json($data);
    }

    #[Route(
        path: '/api/accounts/{accountUid}/addresses/{addressUid}',
        name: 'deleteAddress',
        methods: 'DELETE',
    )]
    public function delete(): JsonResponse
    {
        return $this->json([], 204);
    }
}
