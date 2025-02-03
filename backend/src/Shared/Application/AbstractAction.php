<?php

namespace Shared\Application;

use Illuminate\Support\Facades\Log;
use Throwable;

abstract class AbstractAction
{
    protected function executeWithLogging(callable $callback, string $context): mixed
    {
        try {
            return $callback();
        } catch (Throwable $exception) {
            Log::error("Hiba történt a {$context} végrehajtása közben: " . $exception->getMessage(), [
                'exception' => $exception
            ]);
            throw $exception;
        }
    }
}
