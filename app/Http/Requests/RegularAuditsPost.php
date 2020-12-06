<?php

namespace App\Http\Requests;

use App\Rules\CronTabString;
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
            'minute' => ['required', new CronTabString(59)],
            'hour' => ['required', new CronTabString(23)],
            'month_day' => ['required', new CronTabString(31)],
            'month' => ['required', new CronTabString(12)],
            'week_day' => ['required', new CronTabString(7)],
        ];
    }
}
