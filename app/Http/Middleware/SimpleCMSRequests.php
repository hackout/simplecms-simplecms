<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;

class SimpleCMSRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->makeLanguage($request);
        Event::dispatch('simplecms.backend.request', [$request, false]);
        return $next($request);
    }

    /**
     * 设置语言
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @return void
     */
    protected function makeLanguage(Request $request): void
    {
        if (!$locale = $request->header('X-Accept-Language')) {
            $locale = $request->header('Accept-Language', config('app.locale'));
        }
        App::setLocale($locale);
    }
}
