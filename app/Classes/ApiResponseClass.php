<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{

    public static function rollback($e, $message = 'Something went wrong! Process not completed')
    {
        DB::rollBack();
        return self::throw($e, $message);
    }

    public static function throw($e, $message = "Something went wrong! Process not completed")
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }

    public static function sendResponse($result, $message, $code = 200): JsonResponse
    {

        $response = [
            'success' => true,
        ];
        if ($result) {
            $response['data'] = $result->collection;
            $response['meta'] = [[
                'current_page' => $result->currentPage(),
                'last_page' => $result->lastPage(),
                'per_page' => $result->perPage(),
                'total' => $result->total(),
            ],
                'links' => [
                    'first' => $result->url(1),
                    'last' => $result->url($result->lastPage()),
                    'prev' => $result->previousPageUrl(),
                    'next' => $result->nextPageUrl(),
                ]];
        }
        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);

    }

}
