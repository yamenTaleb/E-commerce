<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidOrderQuantityRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $item) {
            if ($item['quantity'] > $item['product_quantity']) {
                $fail("The quantity for {$item['product_name']} cannot be greater than {$item['product_quantity']}.");
            }
        }
    }
}
