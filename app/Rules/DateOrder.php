<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateOrder implements ValidationRule
{
    private $startDate;

    /**
     * Create a new rule instance.
     *
     * @param  string  $startDate
     * @return void
     */
    public function __construct(string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strtotime($value) <= strtotime($this->startDate)) {
            $fail('The end date must be a date after the start date.');
        }
    }
}
