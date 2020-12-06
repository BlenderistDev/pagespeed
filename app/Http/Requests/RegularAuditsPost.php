<?php

namespace App\Http\Requests;

use App\Rules\CronString;
use Illuminate\Foundation\Http\FormRequest;

class RegularAuditsPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'active_url'],
            'minute' => ['required', new CronString()],
            'hour' => ['required', new CronString()],
            'month_day' => ['required', new CronString()],
            'month' => ['required', new CronString()],
            'week_day' => ['required', new CronString()],
        ];
    }
}
