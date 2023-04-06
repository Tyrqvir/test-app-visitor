<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        '@DoctrineAnnotation' => true,
        'get_class_to_class_keyword' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'yoda_style' => true,
        'class_attributes_separation' => [
            'elements' => ['method' => 'one', 'property' => 'one', 'trait_import' => 'one']
        ],
        'declare_strict_types' => true,
        'modernize_types_casting' => true,
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'strict_comparison' => true,
        'ternary_to_null_coalescing' => true,
        'global_namespace_import' => false,
    ])
    ->setFinder($finder)
;
