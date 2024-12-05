<?php

if (!function_exists("success_response")) {
    function success_response($data, $message = null, $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
if (function_exists("error_response")) {
    function error_response($data, $message = null, $status = 400)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
