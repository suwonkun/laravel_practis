<?php

namespace App\Http\Requests;

use App\Rules\UpdateUniqueSectionName;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['max:255','required','string',new UpdateUniqueSectionName($this->company->id, $this->section)]
        ];
    }
}
