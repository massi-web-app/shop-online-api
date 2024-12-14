<?php

namespace App\Interface\RepositoryInterface\CategoryInterface;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function list(bool $only_trashed = false);

    public function getById(int $id): Category;

    public function store(array $data): Category;

    public function update(Category $category, array $data): bool;

    public function delete(int $id): bool;

    public function multiDelete(array $ids, bool $forceDelete = false): bool;
}
