<?php

namespace App\Repositories\CategoryRepository;

use App\Helper\Helper;
use App\Interface\RepositoryInterface\CategoryInterface\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $pageSize = 10;

    public function list(bool $only_trashed = false)
    {
        if ($only_trashed) {
            return Category::query()->onlyTrashed()->paginate($this->pageSize);
        }
        return Category::query()->paginate($this->pageSize);
    }

    public function getById(int $id): Category
    {
        return Category::withTrashed()->findOrFail($id);
    }

    public function store(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(int $id): bool
    {
        return Category::query()->findOrFail($id)->delete();
    }

    public function multiDelete(array $ids, bool $forceDelete = false): bool
    {
        if ($forceDelete) {
            $temp = Category::query()->withTrashed()->whereIn('id', $ids);
            $categories = $temp;
            foreach ($temp->get() as $key => $value) {
                $fullAddressName = 'files/images/' . $value->img;
                Helper::removeFile($fullAddressName);
            }
            $categories->forceDelete();
            return true;
        }
        return Category::query()->whereIn('id', $ids)->delete();
    }
}
