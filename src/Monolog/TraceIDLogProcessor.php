<?php

declare(strict_types=1);

namespace Phprometheus\Trace\Monolog;

use Phprometheus\Trace\TraceContext;

/**
 * Monolog plugin. Adds `trace_id` to log extras.
 */
class TraceIDLogProcessor
{
    public function __construct(private TraceContext $traceContext)
    {
    }

    public function __invoke(array $record): array
    {
        if (! isset($record['extra']['trace_id']) || strlen($record['extra']['trace_id'])) {
            $record['extra']['trace_id'] = $this->traceContext->traceID();
        }
        return $record;
    }
}
