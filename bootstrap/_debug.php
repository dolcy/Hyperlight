<?php

declare(strict_types=1);

use Siler\Monolog as Log;

/**
 * register logging
 */
Log\handler(Log\stream(__DIR__ . '/../storage/hyperlight.log'));
Log\error('error', ['level' => 'error']);
