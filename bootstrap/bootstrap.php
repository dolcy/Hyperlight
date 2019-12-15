<?php

declare(strict_types=1);

// bootstrap.php
require_once __DIR__ . '/../vendor/autoload.php';

use Cycle\Annotated;
use Cycle\ORM;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Schema;
use Cycle\Schema as Blueprint;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Hyperlight\Config\DataConnector;
use Hyperlight\Domain\User\User;
use Siler\Route;

// dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$whoops = new \Whoops\Run();
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

// root
Route\get('/', function (): void {
    echo 'Fantastic. We are green on root.<br><br>';
});

// iniitate database connector
$db = new DataConnector();
$orm = $db->connect();
$dbal = $db->abstractor();

echo '<pre>';
print_r($dbal);
echo '</pre>';

// schema mapping
$orm = $orm->withSchema(new ORM\Schema([
    'user' => [
        ORM\Schema::MAPPER      => Mapper::class, // default POPO mapper
        ORM\Schema::ENTITY      => User::class,
        ORM\Schema::DATABASE    => 'default',
        ORM\Schema::TABLE       => 'users',
        ORM\Schema::PRIMARY_KEY => 'id',
        ORM\Schema::COLUMNS     => [
            'id'   => 'id',  // property => column
            'name' => 'name'
        ],
        Schema::TYPECAST    => [
            'id' => 'int'
        ],
        Schema::RELATIONS   => []
    ]
]));

// set data finder
$finder = (new \Symfony\Component\Finder\Finder())->files()->in([__DIR__ . '/../src']);
$classLocator = new \Spiral\Tokenizer\ClassLocator($finder);

// autoload annotations
AnnotationRegistry::registerLoader('class_exists');

$schema = (new Blueprint\Compiler())->compile(new Blueprint\Registry($dbal), [
    new Annotated\Embeddings($classLocator),            // register embeddable entities
    new Annotated\Entities($classLocator),              // register annotated entities
    new Blueprint\Generator\ResetTables(),       // re-declared table schemas (remove columns)
    new Blueprint\Generator\GenerateRelations(), // generate entity relations
    new Blueprint\Generator\ValidateEntities(),  // make sure all entity schemas are correct
    new Blueprint\Generator\RenderTables(),      // declare table schemas
    new Blueprint\Generator\RenderRelations(),   // declare relation keys and indexes
    new Blueprint\Generator\SyncTables(),        // sync table changes to database
    new Blueprint\Generator\GenerateTypecast(),  // typecast non string columns
]);

$orm = $orm->withSchema(new Schema($schema));

// create and persist users
$user = new User();
$user->setName('Steve Austin');
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($user);

$transactor = new ORM\Transaction($orm);
$transactor->persist($user);
$transactor->run();
