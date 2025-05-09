<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\DTOs\ApiResponseDto;
use App\Services\ApiResponseService;
use App\Enums\ApiStatusEnum;
use App\Exceptions\ApiResponseException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * Enable CORS.
         */
		 $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $response = app(ApiResponseService::class);

        $exceptions->render(
            fn(ValidationException $exception, $request) => ($response)(
                ApiResponseDto::from([
                    "status" => false,
                    "errors" => $exception->validator->errors()->all()
                ]),
                ApiStatusEnum::BAD_REQUEST
            )
        );

        $exceptions->render(
            fn(QueryException $exception, $request) => ($response)(
                ApiResponseDto::from([
                    "status" => false,
                    "errors" => [
                        "Bro wrote the wrong database query. Backend skills issue",
                        $exception->getMessage()
                    ]
                ]),
                ApiStatusEnum::INTERNAL_SERVER_ERROR
            )
        );

        $exceptions->render(
            fn(OutOfBoundsException $exception, $request) => ($response)(
                ApiResponseDto::from([
                    "status" => false,
                    "errors" => [
                        "Ayyo, looks like your backend messed up the array structure.",
                        $exception->getMessage()
                    ]
                ]),
                ApiStatusEnum::UNPROCESSABLE_ENTITY
            )
        );

        $exceptions->render(
            fn(BadMethodCallException $exception, $request) => ($response)(
                ApiResponseDto::from([
                    "status" => false,
                    "errors" => [
                        "Are you sure backend bro? The method you called doesn't exist.",
                        $exception->getMessage()
                    ]
                ]),
                ApiStatusEnum::NOT_FOUND
            )
        );

        $exceptions->render(
            fn(NotFoundHttpException $exception, $request) => ($response)(
                ApiResponseDto::from([
                    "status" => false,
                    "errors" => [$exception->getMessage()]
                ]),
                ApiStatusEnum::NOT_FOUND
            )
        );

        $exceptions->render(
            fn(ApiResponseException $exception, $request) => ($response)(
                ApiResponseDto::from([
                    "status" => false,
                    "errors" => $exception->getAllMessage()
                ]),
                $exception->getStatus()
            )
        );

        $exceptions->render(function (Exception $exception, $request) use ($response) {
            if ($request->is('*')) {

                if (
                    $exception->getMessage() == "Route [login] not defined." ||
                    $exception->getMessage() == "Unauthenticated."
                ) {
                    $errors = ["Unauthorization."];
                    $status = ApiStatusEnum::UNAUTHORIZED;
                }

                return ($response)(
                    ApiResponseDto::from([
                        "status" => false,
                        "errors" => $errors ?? [
                            "Your backend is dumb, bro.",
                            $exception->getMessage()
                        ]
                    ]),
                    $status ?? ApiStatusEnum::INTERNAL_SERVER_ERROR
                );
            }
        });
    })->create();
