<?php

if(!function_exists("success_response")){
function success_response($data, $message=null, $status = 200)
{
    return response()->json([
        'message' => $message,
        'data' => $data,
    ], $status);
}
}

function error_response($data, $message =null, $status = 400)
{
    return response()->json([
        'message' => $message,
        'data' => $data,
    ], $status);
}
