<?php

namespace App\Http\Responses;

class ApiResponse{
    public static function success($message, $statusCode, $data = []){
        return response()->json([
            'message' => $message,
            'data' => $data,
            'statusCode' => $statusCode,
            'error' => false
        ], $statusCode);
    }

    public static function error($message, $statusCode, $data = []){
        return response()->json([
            'message' => $message,
            'statusCode' => $statusCode,
            'data' => $data,
            'error' => true
        ]);
    }
}