<?php

namespace App\Rules;

use App\Models\ProductImage;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnePrimaryImageRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $counter = 0;
        foreach ($value as $image) {
           if ($image['is_primary'])
               $counter++;
           if ($counter >= 2)
               $fail('Only one image can be primary.');
        }
    }
}
