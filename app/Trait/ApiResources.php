<?php

namespace  App\Trait;

trait ApiResources
{
    protected function ok($message)

    {
        return $this->success($message, 200);
    }


    public function success( $message = null, $code = 200)
    {
        return response()->json([
            'message' => $message,
            'status ' => $code,
        ], $code);
    }
}
