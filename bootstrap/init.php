<?php

declare(strict_types=1);

namespace Hyperlight\Bootstrap;

use Hyperlight\Bootstrap\Loader\DataLoader;
use Hyperlight\Bootstrap\Loader\ErrorLoader;
use Hyperlight\Bootstrap\Loader\LogLoader;
use function Siler\Dotenv\init;

/**
 * bootstrap autloader
 */
require_once(__DIR__ . '/../vendor/autoload.php');

/**
 * error handler via whoops
 */
$error = new ErrorLoader();
$error->load();

/**
 *  create logging instance; storage/hyperlight.log
 */
 $logger = new LogLoader();
 $logger->load();

/**
 * initialize dotenv directory
 */
init(__DIR__ . '/../');

/**
 * loads persistence data
 */
$orm = new DataLoader();
$orm = $orm->load();
