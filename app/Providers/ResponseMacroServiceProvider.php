<?php

namespace App\Providers;

use App\Services\System\Validation\Response as ResponseValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function (?array $result = null, int|string $status = 200, array $headers = []): JsonResponse {
            return response()->json([
                'ok' => true,
                'timestamp' => Carbon::now(),
                'result' => $result,
            ], ResponseValidation::httpCode($status), $headers);
        });

        Response::macro('errors', function (?array $result = null, int|string $status = 400, array $headers = []): JsonResponse {
            return response()->json([
                'ok' => false,
                'timestamp' => Carbon::now(),
                'errors' => $result,
            ], ResponseValidation::httpCode($status), $headers);
        });

        Response::macro('error', function (?string $error = null, int|string $status = 400, array $headers = []): JsonResponse {
            return response()->json([
                'ok' => false,
                'timestamp' => Carbon::now(),
                'error' => $error,
            ], ResponseValidation::httpCode($status), $headers);
        });

        Response::macro('message', function (string $message = null, int|string $status = 200, array $headers = []): JsonResponse {
            return response()->json([
                'ok' => true,
                'timestamp' => Carbon::now(),
                'message' => $message,
            ], ResponseValidation::httpCode($status), $headers);
        });
    }
}
