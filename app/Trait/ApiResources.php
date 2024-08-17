<?php

namespace  App\Trait;

trait ApiResources
{
    protected function ok($message, $data = [])

    {
        return $this->success($message, $data, 200);
    }


    public function success( $message = null, $data, $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status ' => $code,
        ], $code);
    }


    public function error( $message = null, $code = 400)
    {
        return response()->json([
            'message' => $message,
            'status ' => $code,
        ], $code);
    }
}
