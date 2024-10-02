<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptchaToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = Http::asForm()
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('recaptcha.secret'),
                'response' => $request->recaptcha_token,
                'remoteip' => $request->ip(),
            ])
            ->object();

        if ($response->success === false) {
            dd('failed');
        }

        if ($response->score <= 0.8) {
            dd('recaptcha failed');
        }

        return $next($request);
    }
}
