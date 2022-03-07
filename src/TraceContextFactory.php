<?php

declare(strict_types=1);

namespace Phprometheus\Trace;

use Psr\Http\Message\ServerRequestInterface;

class TraceContextFactory
{
    private const PROPAGATION_HEADERS = [
        'x-trace-id',
        'x-traceid',
        'x-b3-traceid'
    ];

    public function __invoke(ServerRequestInterface $request): TraceContext
    {
        $headers = array_filter(
            $request->getHeaders(),
            fn(array $contents, string $key) => in_array(strtolower($key), self::PROPAGATION_HEADERS, true),
            ARRAY_FILTER_USE_BOTH
        );
        $headers = array_shift($headers);
        if (! $headers) {
            return TraceContext::instance();
        }

        $headerValue = array_shift($headers);
        if ($headerValue) {
            return TraceContext::newFromID($headerValue);
        }

        return TraceContext::instance();
    }
}
