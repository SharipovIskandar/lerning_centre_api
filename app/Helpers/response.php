<?php

if (!function_exists('success_response')) {
    function success_response($data = null, $message = null, $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}

if (!function_exists('error_response')) {
    function error_response($data = null, $message = null, $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}

