<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Section;

class UniqueSectionName implements Rule
{
    protected $companyId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($companyId)
    {
        $this->companyId = $companyId;
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
        return !Section::where('company_id', $this->companyId)
            ->where('name', $value)
            ->exists();
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
