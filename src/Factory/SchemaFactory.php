<?php

declare(strict_types=1);

namespace Hyperlight\Factory;

use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Schema;
use Hyperlight\Domain\User\User;

class SchemaFactory
{
    /**
     * Creates schema with properties
     *
     * @param  $orm
     * @return $orm
     */
    public function generate($orm)
    {

        // schema mapping
        return $orm->withSchema(new Schema([
            'user' => [
                Schema::MAPPER      => Mapper::class, // default POPO mapper
                Schema::ENTITY      => User::class,
                Schema::DATABASE    => 'default',
                Schema::TABLE       => 'users',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS     => [
                    'id'   => 'id',  // property => column
                    'name' => 'name'
                ],
                Schema::TYPECAST    => [
                    'id' => 'int'
                ],
                Schema::RELATIONS   => []
            ]
        ]));
    }
}
