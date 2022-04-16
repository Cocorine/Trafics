<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\Helpers\ExceptionTrait;

class Handler extends ExceptionHandler
{

    use ExceptionTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            return false;
        });
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            return $this->apiExceptions($request,$e);
        }

        return parent::render($request, $e);
    }

}
