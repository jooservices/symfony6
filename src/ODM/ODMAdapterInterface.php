<?php

namespace App\ODM;

interface ODMAdapterInterface
{
    public function list(array $options): array;

    public function item(string $id): array;

    public function update(string $id, array $data): array;

    public function create(array $data): array;

    public function delete(string $id): bool;
}
