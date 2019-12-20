<?php

declare(strict_types=1);

use Cycle\ORM;
use Hyperlight\Domain\User\User;
use function Siler\Dotenv\init;
use Siler\Route;

/**
 * initial bootstrap
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * error handler
 */
require_once __DIR__ . '/_error.php';

/**
 *  debug log
 */
require_once __DIR__ . '/_debug.php';

/**
 * init dotenv
 */
init(__DIR__ . '/../');

/**
 * initialize cycle orm
 */
require_once __DIR__ . '/_cycle.php';

// temporary route test
Route\get('/', function (): void {
    echo 'Fantastic. We are green on root.<br><br>';
});

// temporary orm test
$user = new User();
$user->setName('Jason Bourne');
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($user);

$transactor = new ORM\Transaction($orm);
$transactor->persist($user);
$transactor->run();
