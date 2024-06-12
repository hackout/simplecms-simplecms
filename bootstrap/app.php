<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SimpleCMSRequests;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use SimpleCMS\Framework\Exceptions\SimpleException;
use SimpleCMS\Framework\Services\RequestLogService;
use SimpleCMS\Framework\Http\Middleware\CheckPermission;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            SimpleCMSRequests::class
        ]);
        $middleware->alias([
            'role' => CheckPermission::class
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->ajax()) {
                return json_redirect();
            }
            $aliasName = head(explode('.', $request->route()->getName()));
            return route($aliasName . '.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (SimpleException $e) {
            (new RequestLogService)->makeLog(request(), false);
            if (request()->ajax()) {
                return json_error($e->getMessage());
            }
        });
        $exceptions->render(function (ValidationException $e) {
            (new RequestLogService)->makeLog(request(), false);
            if (request()->ajax()) {
                return json_error($e->getMessage());
            }
        });
    })->create();