<?php

namespace App\Rules;

use App\Exceptions\CronStringException;
use Cron\FieldFactory;
use Illuminate\Contracts\Validation\Rule;

class CronString implements Rule
{
    /**
     * Позиция атрибута в cron строке
     */
    private array $attributePosition = [
        'minute' => 0,
        'hour' => 1,
        'month_day' => 2,
        'month' => 3,
        'week_day' => 4,
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $fieldFactory = new FieldFactory();
        $position = $this->attributePosition[$attribute] ?? false;
        if ($position === false) {
            throw new CronStringException('attribute not found');
        }
        $field = $fieldFactory->getField($position);
        return $field->validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "Некорректное значение";
    }
}
