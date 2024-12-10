<?php

namespace App\Repositories;

use App\Interface\RepositoryInterface\CategoryInterface\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function list(): Collection
    {
        return Category::all();
    }

    public function getById(int $id): Category
    {
        return Category::query()->findOrFail($id);
    }

    public function store(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Category::query()->findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Category::query()->findOrFail($id)->delete();
    }
}
