<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /*
     * Format error json output format
     */
    protected function prepareJsonResponse($request, Exception $e)
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $headers = $this->isHttpException($e) ? $e->getHeaders() : [];

        $output = array_merge(
            ['code' => $e->getStatusCode()],
            $this->convertExceptionToArray($e));
        return new JsonResponse(
            $output, $status, $headers,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Determined auth failed redirect url in terms of guard type 
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $guards = $exception->guards();
        $routeName = 'login';
        foreach ($guards as $k => $guard) {
            if ($guard == 'admin') {
                $routeName = 'admin.login';
            }
        }
        return $request->expectsJson()
                    ? response()->json(
                        [
                            'code'  => 401,
                            'message' => $exception->getMessage(),
                        ], 401)
                    : redirect()->guest(route($routeName));
    }
}
