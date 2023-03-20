<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:25|max:5000',
            'embedded_content' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'integer',
            'images' => 'array|between:0,5',
            'images.*' => 'integer',
        ];
    }
}
