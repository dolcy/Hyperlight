<?php

declare(strict_types=1);

use Cycle\ORM;
use Hyperlight\Domain\User\User;
use function Siler\Dotenv\init;
use Siler\Route;

// require autoload
require_once __DIR__ . '/../vendor/autoload.php';

// error handler
require_once __DIR__ . '/_error.php';

// init dotenv via siler helper
init(__DIR__ . '/../');

// initial root route
Route\get('/', function (): void {
    echo 'Fantastic. We are green on root.<br><br>';
});

// initiate cycle orm
require_once __DIR__ . '/_cycle.php';

// temporary orm test
$user = new User();
$user->setName('Jason Bourne');
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($user);

$transactor = new ORM\Transaction($orm);
$transactor->persist($user);
$transactor->run();
