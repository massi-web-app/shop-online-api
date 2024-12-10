<?php

namespace App\Http\Requests\CategoryRequests;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|min:3|max:100",
            "ename" => "required_without:search_url|string|min:3|max:150",
            "search_url" => "required_without:ename|string|min:3|max:150",
            "image" => "nullable|image|mimes:jpg,jpeg,png|max:2024",
            "parent_id" => "nullable|integer|exists:categories,id",
            "notShow" => "nullable|boolean"
        ];
    }

    public function attributes(): array
    {
        return [
            "ename" => "نام لاتین",
            'search_url' => 'url دسته',
            'image' => 'تصویر دسته',
            "parent_id" => 'دسته والد'
        ];
    }
}
