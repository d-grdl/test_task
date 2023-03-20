<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTagRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:tags,name',
        ];
    }
}
