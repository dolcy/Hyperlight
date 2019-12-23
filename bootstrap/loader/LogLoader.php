<?php

declare(strict_types=1);

namespace Hyperlight\Bootstrap\Loader;

use Siler\Monolog as Log;

class LogLoader
{
    public function load(): void
    {
        // register logging
        Log\handler(Log\stream(__DIR__ . '/../../storage/hyperlight.log'));
        Log\error('error', ['level' => 'error']);
    }
}
