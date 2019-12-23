<?php

declare(strict_types=1);

namespace Hyperlight\Bootstrap\Loader;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

class ErrorLoader
{
    public function load(): void
    {
        // instantiate new whoops
        $whoops = new Whoops();
        $whoops->prependHandler(new PrettyPageHandler());
        $whoops->register();
    }
}
