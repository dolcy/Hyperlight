<?php

declare(strict_types=1);

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

// register error handler
$whoops = new Whoops();
$whoops->prependHandler(new PrettyPageHandler());
$whoops->register();
