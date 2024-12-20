<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreContainerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required', 'string', 'min:3',
            ],
            'name' => [
                'required', 'string', 'min:3',
            ],
        ];
    }
}
