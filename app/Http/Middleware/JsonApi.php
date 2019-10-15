<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class JsonApi
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        if($request->getMethod() === 'OPTIONS') {
            $response = new LaravelResponse();
            self::setHeaders($request, $response);
            return $response->setStatusCode(204);
        }

        $request->headers->set('Accept', 'application/json');

        /** @var SymfonyResponse $response */
        $response = $next($request);

        self::setHeaders($request, $response);

        return $response;
    }

    private static function setHeaders(Request $request, SymfonyResponse $response): void
    {
        $headerTranslation = [
            'Access-Control-Allow-Origin' => 'Origin',
            'Access-Control-Allow-Methods' => 'Access-Control-Request-Method',
            'Access-Control-Allow-Headers' => 'Access-Control-Request-Headers',
        ];
        $requestHeaders = $request->headers;
        $responseHeaders = $response->headers;

        foreach ($headerTranslation as $responseHeaderName => $requestHeaderName) {
            if (!$responseHeaders->has($responseHeaderName)  && $requestHeaders->has($requestHeaderName)) {
                $responseHeaders->set($responseHeaderName, $requestHeaders->get($requestHeaderName));
            }
        }
    }
}
