<?php
namespace App\Services;

use Illuminate\Http\Response;

class Service
{
    protected function successResponse($message, $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'code' => $code,
            'message' => $message,
        ], $code);
    }

    protected function errorResponse($message, $status = "Error", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'code' => $code,
        ], $code);
    }
}