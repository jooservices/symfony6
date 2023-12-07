<?php

namespace App\ApiModel\Resource;

use Knp\Component\Pager\Pagination\PaginationInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;

#[OA\Schema(required: [
    'totalPages',
    'totalRecords',
    'pageSize',
    'currentPage',
    'nextPage',
])]
class PagingMeta
{
    #[OA\Property(description: 'Count of all pages of the result', example: 2, nullable: false)]
    public int $totalPages = 1;

    #[OA\Property(description: 'Count of all records of the result', example: 23, nullable: false)]
    public int $totalRecords = 0;

    #[OA\Property(description: 'Current page size', example: 20, nullable: false)]
    public int $pageSize = 20;

    #[OA\Property(description: 'Current page', example: 1, nullable: false)]
    public int $currentPage = 1;

    #[OA\Property(description: 'Next page number', example: 2, nullable: true)]
    public ?int $nextPage = null;

    #[OA\Property(description: 'Previous page number', example: null, nullable: true)]
    public ?int $prevPage = null;

    public static function create(PaginationInterface $pagination): self
    {
        $obj = new self();
        $obj->setUp($pagination->getCurrentPageNumber(), $pagination->getItemNumberPerPage(), $pagination->getTotalItemCount());

        return $obj;
    }

    #[Ignore]
    public function setUp(int $currentPage, int $pageSize, int $totalRecords): static
    {
        $this->totalRecords = $totalRecords;
        $this->pageSize     = $pageSize;
        $this->currentPage  = $currentPage;
        $this->totalPages   = $pageSize === 0 ? 1 : (int) ceil($totalRecords / $pageSize);
        $this->nextPage     = $this->currentPage < $this->totalPages ? $this->currentPage + 1 : null;
        $this->prevPage     = ($currentPage > 1) ? ($currentPage - 1) : null;

        return $this;
    }
}
