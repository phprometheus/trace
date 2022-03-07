<?php

declare(strict_types=1);

namespace Phprometheus\Trace;

use LogicException;

class TraceContext
{
    private static ?TraceContext $instance = null;

    private string $traceID;

    private function __construct(?string $traceID = null)
    {
        if (! $traceID) {
            $traceID = bin2hex(random_bytes(16));
        }
        $this->traceID = $traceID;
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function newFromID(?string $traceID = null): self
    {
        if (self::$instance !== null) {
            throw new LogicException('Trace already exists');
        }

        self::$instance = new self($traceID);
        return self::$instance;
    }

    public function traceID(): string
    {
        return $this->traceID;
    }
}
