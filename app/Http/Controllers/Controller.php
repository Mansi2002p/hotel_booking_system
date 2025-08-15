<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function sendResponse($status, $message, $result = null, $pagination = null)
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $result,
        ];
        if ($pagination) {
            $response['pagination'] = $pagination;
        }
        return response()->json($response, 200);
    }

    public function sendDetailsResponse($status, $message, $result = null)
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data_set' => $result,
        ];

        return response()->json($response, 200);
    }



    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $error,
            'data' => null,
        ];

        return response()->json($response, $code);
    }
}
