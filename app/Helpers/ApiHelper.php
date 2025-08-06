<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiHelper
{
    /**
     * Standard API response
     * @param mixed $data
     * @param string $success
     * @return JsonResponse
     */
    public static function apiResponse($data, bool $success = true, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => $success,
        ], $statusCode);
    }

    /**
     * Pagination API response
     * @param mixed $data
     * @param mixed $items
     * @return JsonResponse
     */
    public static function paginationApiResponse($data, $items): JsonResponse
    {
        return new JsonResponse([
            'data'  =>  $items,
            'total' =>  $data->total(),
            'perPage' =>  $data->perPage(),
            'currentPage' =>  $data->currentPage(),
            'lastPage' =>  $data->lastPage(),
            'next' =>  $data->nextPageUrl(),
            'previous' =>  $data->previousPageUrl(),
        ], Response::HTTP_OK);
    }
}
