<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string','required','max:255'],
            'description' => ['string','required'],
            'image' => ['image','required','nullable', 'mimes:jpg,png,jpeg','max:2048'],
            'isActive'=>['required'],
            'isComment'=>['required'],
            'isSharable'=>['required'],
            'category_id'=>['exists:categories,id'],
            'author_id'=>['exists:users,id'],
            'tags'=>['string','nullable'],
        ];
    }
}
