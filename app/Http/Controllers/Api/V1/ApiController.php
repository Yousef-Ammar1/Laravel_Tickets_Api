<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Trait\ApiResources;
use Illuminate\Auth\AuthenticationException;
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
        try {
            Gate::authorize($ability, $targetModel);
            return true;

            
        } catch (AuthenticationException $e) {
            return false;
        }
        // This will either allo w the action or throw an exception

        // If it doesn't throw an exception, return true
    }
}
