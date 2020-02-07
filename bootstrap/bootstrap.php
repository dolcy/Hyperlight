<?php

declare(strict_types=1);

namespace Hyperlight\Bootstrap;

use Cycle\ORM;
use Hyperlight\Domain\User\User;

// include main init file for app
require_once(__DIR__ . '/init.php');

// include routes
require_once(__DIR__ . '/../src/routes.php');

// temporary orm test
$user = new User();
$user->setName('The Mandalorian');
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($user);

$transactor = new ORM\Transaction($orm);
$transactor->persist($user);
$transactor->run();
