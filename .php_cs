<?php

declare(strict_types=1);
/**
 * php_cs rules
 */
return PhpCsFixer\Config::create()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->files()
            ->in(__DIR__ . '/bootstrap')
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
            ->append([__FILE__])
            ->notName('DefaultRuleProvider.php')
    )
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_indentation' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'no_alias_functions' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'not_operator_with_space' => true,
        'return_type_declaration' => true,
        'phpdoc_to_return_type' => true,
        'void_return' => true,
        'no_empty_phpdoc' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_test_annotation' => true,
        'phpdoc_trim' => true,
    ]);
