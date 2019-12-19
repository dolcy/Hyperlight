<?php

declare(strict_types=1);

namespace Hyperlight\Domain;

use Cycle\Annotated;
use Cycle\Schema;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Hyperlight\Config\DataConnector;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;

class SchemaProcessor
{
    /**
     * Set connector
     *
     * @var DataConnector
     */
    private $connector;

    /**
     * Inject DataConnector as $connector
     *
     * @param DataConnector $connector
     */
    public function __construct(DataConnector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Locate class files via finder
     *
     * @return Finder
     */
    public function locateFile(): Finder
    {
        // set class finder
        return (new Finder())->files()->in([__DIR__]);
    }

    /**
     * Creates and compiles instance of schema registry
     *
     * @return array
     */
    public function compile(): array
    {
        // set finder and annotation class loader
        $classLocator = new ClassLocator($this->locateFile());
        AnnotationRegistry::registerLoader('class_exists');

        // Process and compile schema registry
        return (new Schema\Compiler())->compile(new Schema\Registry($this->connector->abstractor()), [
            new Annotated\Embeddings($classLocator), // embeddable entities
            new Annotated\Entities($classLocator), // annotated entities
            new Schema\Generator\ResetTables(), // schema, remove columns
            new Schema\Generator\GenerateRelations(), // entity relations
            new Schema\Generator\ValidateEntities(), // entity schema validator
            new Schema\Generator\RenderTables(), // declare table schemas
            new Schema\Generator\RenderRelations(), // relation keys and indexes
            new Schema\Generator\SyncTables(), // sync table changes to database
            new Schema\Generator\GenerateTypecast(), // typecast non string columns
        ]);
    }
}
