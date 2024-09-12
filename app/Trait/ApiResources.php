<?php

namespace App\Trait;

trait ApiResources
{
    protected function ok($message, $data = [])
    {
        return $this->success($message, $data, 200);
    }


    protected function success($message = null, $data, $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status ' => $code,
        ], $code);
    }


    protected function error($errors = [], $code = null)
    {
        if (is_string($errors)) {
            return response()->json([
                'message' => $errors,
                'status ' => $code,
            ], $code);
        }

        return response()->json([
            'errors' => $errors,
        ]);
    }
}
