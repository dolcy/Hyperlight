<?php

declare(strict_types=1);

namespace Hyperlight\Bootstrap;

use Cycle\ORM;
use Hyperlight\Domain\User\User;
use Siler\Route;

// include main init file
require_once(__DIR__ . '/init.php');

// temporary route test
Route\get('/', function (): void {
    echo 'Fantastic. We are green on root.<br><br>';
});

// temporary orm test
$user = new User();
$user->setName('The Witcher');
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($user);

$transactor = new ORM\Transaction($orm);
$transactor->persist($user);
$transactor->run();
