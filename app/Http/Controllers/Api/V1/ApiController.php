<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Trait\ApiResources;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResources;
    public function include(string $relationship)
    {
        $param = request()->get('include');
        if (!isset($param)) {
            return false;
        }
        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}
