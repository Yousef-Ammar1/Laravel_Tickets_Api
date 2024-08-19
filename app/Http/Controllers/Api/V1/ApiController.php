<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Trait\ApiResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    use ApiResources;
    protected $policyClass;




    public function include(string $relationship)
    {
        $param = request()->get('include');
        if (!isset($param)) {
            return false;
        }
        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }


    public function isAble($ability, $targetModel)
    {
        // This will either allow the action or throw an exception
        Gate::authorize($ability, $targetModel);

        // If it doesn't throw an exception, return true
        return true;
    }
}
