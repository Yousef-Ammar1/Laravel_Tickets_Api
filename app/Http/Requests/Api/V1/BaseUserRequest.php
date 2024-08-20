<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = [])
    {
        $attributeMap = array_merge([
            'data.attributes.name' => 'name',
            'data.attributes.email' => 'email',
            'data.attributes.password' => 'password',
            'data.attributes.isManager' => 'is_manager',
        ], $otherAttributes);



        $attributesToUpdate = [];

        foreach ($attributeMap as $requestKey => $attributeKey) {
            if ($this->has($requestKey)) {
                $value = $this->input($requestKey);

                if ($value === 'password') {
                    $value = bcrypt($value);
                }


                $attributesToUpdate[$attributeKey] = $value;
            }
        }

        return $attributesToUpdate;
    }
}
