<?php

namespace MRGear\PersianNormalizer\Middleware;

use Closure;
use Illuminate\Http\Request;
use MRGear\PersianNormalizer\Facade\Normalizer;

class PersianNormalizerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the entire request data
        $inputs = $request->all();

        // Normalize the request data
        $normalizedData = Normalizer::normalizeAll($inputs);

        // Merge the normalized data back into the request
        $request->merge($normalizedData);

        return $next($request);
    }
}
