<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TooManyRequestsHttpException) {
            $retryAfter = $exception->getHeaders()['Retry-After'] ?? null;
            $imit  = $exception->getHeaders()['X-RateLimit-Limit'] ?? null;
            // dd($exception->getHeaders());
            if ($imit === 3) {
                $message = 'You have been blocked for 15 minutes. Please try again later.';
            } elseif ($imit === 6) {
                $message = 'You have been blocked for 45 minutes. Please try again later.';
            } else {
                $message = 'Too many requests. Please try again later.';
            }

            return response()->view('errors.blocked', compact('message'), 429);
        }

        return parent::render($request, $exception);
    }

}
