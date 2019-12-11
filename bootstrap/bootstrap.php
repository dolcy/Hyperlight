<?php
// bootstrap.php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\User;
use Cycle\Annotated;
use Cycle\ORM;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\ORM as Cycle;
use Cycle\ORM\Schema;
use Cycle\Schema as Blueprint;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Spiral\Database;

// dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// dsn host,db settings
$dbHost = getenv('DB_HOST');
$dbData = getenv('DB_DATABASE');

// data config
$dbal = new Database\DatabaseManager(
    new Database\Config\DatabaseConfig([
        'default'     => 'default',
        'databases'   => [
            'default' => ['connection' => 'mysql']
        ],
        'connections' => [
          'mysql' => [
              'driver'  => Database\Driver\MySQL\MySQLDriver::class,
              'connection' => 'mysql:host=' . $dbHost . ';' . 'dbname=' . $dbData,
              'username'   => 'root',
              'password'   => '',
          ],
            'sqlite' => [
                'driver'  => Database\Driver\SQLite\SQLiteDriver::class,
                'connection' => 'sqlite:database.db',
                'username'   => '',
                'password'   => '',
            ]
        ]
    ])
);

// initiate orm service
$orm = new Cycle(new ORM\Factory($dbal));

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
$u = new User();
$u->setName("James Bond");
//$u = $orm->getRepository(User::class)->findByPK(3);
print_r($u);
//
$t = new ORM\Transaction($orm);
$t->persist($u);
$t->run();
