<?php

namespace App\Rules;

use App\Models\Section;
use Illuminate\Contracts\Validation\Rule;

class UpdateUniqueSectionName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($companyId, $section)
    {
        $this->companyId = $companyId;
        $this->section = $section;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $section = Section::where('company_id', $this->companyId)
            ->where('name', $value)
            ->first();

        return $section === null || $this->section->name === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '同じ名前の部署が既に存在します。';
    }
}
