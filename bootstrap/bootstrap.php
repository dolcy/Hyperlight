<?php

declare(strict_types=1);

use Cycle\ORM;
use Cycle\ORM\Schema;
use Hyperlight\Config\DataConnector;
use Hyperlight\Domain\SchemaProcessor;
use Hyperlight\Domain\User\User;
use Hyperlight\Factory\SchemaFactory;
use function Siler\Dotenv\init;
use Siler\Route;

// require autoload
require_once __DIR__ . '/../vendor/autoload.php';

// error handler
$whoops = new \Whoops\Run();
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

// init dotenv via siler helper
init(__DIR__ . '/../');

// initial root route
Route\get('/', function (): void {
    echo 'Fantastic. We are green on root.<br><br>';
});

// iniitate database connector
$persistence = new DataConnector();
$orm = $persistence->connect();

// generate schema properties
$schemaFactory = new SchemaFactory($persistence);
$orm = $schemaFactory->generate($orm);

// instantiate schema processor
$schema = new SchemaProcessor($persistence);

// compile dbal registry options
$schema = $schema->compile();

// create new schema with compiled registry
$orm = $orm->withSchema(new Schema($schema));

// create and persist users
$user = new User();
$user->setName('Flash Gordon');
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($user);

$transactor = new ORM\Transaction($orm);
$transactor->persist($user);
$transactor->run();
