<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImagesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'files' => 'array',
        ];
    }
}
