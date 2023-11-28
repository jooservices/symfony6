<?php

namespace App\ODM\Adapter;

use App\ODM\ODMAdapterInterface;

class AccountLocalApi implements ODMAdapterInterface
{
    public function __construct()
    {
    }

    public function list(array $options): array
    {
    }

    public function item(string $id): array
    {
    }

    public function update(string $id, array $data): array
    {
        return [];
    }

    public function create(array $data): array
    {
        return [];
    }

    public function delete(string $id): bool
    {
        return true;
    }
}
