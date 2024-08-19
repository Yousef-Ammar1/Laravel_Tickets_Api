<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{
    public function mappedAttributes()
    {
        $attributeMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'user_id',
        ];

        $attributesToUpdate = [];

        foreach ($attributeMap as $requestKey => $attributeKey) {
            if ($this->has($requestKey)) {
                $attributesToUpdate[$attributeKey] = $this->input($requestKey);
            }
        }

        return $attributesToUpdate;
    }



    public function messages(): array
    {
        return [
            'data.attributes.status' => 'The data.attributes.status must be one of the following values: A, C, X, H.',
        ];
    }
}
