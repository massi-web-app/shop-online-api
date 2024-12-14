<?php

namespace App\Http\Controllers\Admin;

use App\Classes\ApiResponseClass;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\RemoveCategoryRequest;
use App\Http\Requests\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\CategoryRequests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Interface\RepositoryInterface\CategoryInterface\CategoryRepositoryInterface;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        if (filter_var($request->query('only_trashed'),FILTER_VALIDATE_BOOLEAN)===true){
            $data=$this->categoryRepository->list(true);
            return ApiResponseClass::sendResponse(CategoryResource::collection($data), "List of Categories");
        }
        $data = $this->categoryRepository->list();

        return ApiResponseClass::sendResponse(CategoryResource::collection($data), "List of Categories");
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['img'] = Helper::upload($request, 'files/images', 'image');
            $this->categoryRepository->store($data);
            return ApiResponseClass::sendResponse(null, "Category Create Successfully", 201);
        } catch (Exception $exception) {
            return ApiResponseClass::rollback($exception, "Server has go an error");
        }
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['img'] = Helper::upload($request, 'files/images', 'image');
            $this->categoryRepository->update($category, $data);
            return ApiResponseClass::sendResponse(null, "Category Update Successfully");
        } catch (Exception $exception) {
            return ApiResponseClass::rollback($exception, "Server has go an error");
        }

    }

    public function destroy(int $categoryId)
    {
        $category = $this->categoryRepository->getById($categoryId);
        if ($category->deleted_at) {
            $category->forceDelete();
            return ApiResponseClass::sendResponse(null, "Category Delete Successfully");
        }
        $category->delete();
        return ApiResponseClass::sendResponse(null, "Category move to trash Successfully");
    }

    public function removeCategories(RemoveCategoryRequest $request)
    {
        $ids=$request->validated();
        if (filter_var($request->query('force_trashed'),FILTER_VALIDATE_BOOLEAN)===true){
            $this->categoryRepository->multiDelete($ids,true);
            return ApiResponseClass::sendResponse(null, "Category Delete Successfully");
        }
        $this->categoryRepository->multiDelete($ids,false);
        return ApiResponseClass::sendResponse(null, "Category move to trash Successfully");

    }


}
