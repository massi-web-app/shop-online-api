<?php

namespace App\Interface\RepositoryInterface\CategoryInterface;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function list(): Collection;

    public function getById(int $id): Category;

    public function store(array $data): Category;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
