<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 project.
 *
 * (c) 2019-2023 Benni Mack
 *               Simon Gilli
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CodingStandards;

use PhpCsFixer\Config;

class CsFixerConfig extends Config implements CsFixerConfigInterface
{
    /**
     * @var string
     */
    protected static $defaultHeader = <<<EOF
        {header}

        It is free software; you can redistribute it and/or modify it under
        the terms of the GNU General Public License, either version 2
        of the License, or any later version.

        For the full copyright and license information, please read the
        LICENSE.txt file that was distributed with this source code.

        The TYPO3 project - inspiring people to share!
        EOF;

    /**
     * @var array<string, array<string, mixed>|bool>
     */
    protected static $typo3Rules = [
        '@DoctrineAnnotation' => true,
        '@PER' => true,
        'array_syntax' => ['syntax' => 'short'],
        'cast_spaces' => ['space' => 'none'],
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'none'],
        'declare_parentheses' => true,
        'dir_constant' => true,
        'function_to_constant' => ['functions' => ['get_called_class', 'get_class', 'get_class_this', 'php_sapi_name', 'phpversion', 'pi']],
        'function_typehint_space' => true,
        'modernize_strpos' => true,
        'modernize_types_casting' => true,
        'native_function_casing' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_namespace_whitespace' => true,
        'no_null_property_initialization' => true,
        'no_short_bool_cast' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_singleline' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_nullsafe_operator' => true,
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
        'php_unit_construct' => ['assertions' => ['assertEquals', 'assertSame', 'assertNotEquals', 'assertNotSame']],
        'php_unit_mock_short_will_return' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'phpdoc_no_access' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'return_type_declaration' => ['space_before' => 'none'],
        'single_quote' => true,
        'single_space_around_construct' => true,
        'single_line_comment_style' => ['comment_types' => ['hash']],
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'whitespace_after_comma_in_array' => ['ensure_single_space' => true],
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    ];

    public function __construct(string $name = 'TYPO3')
    {
        parent::__construct($name);
    }

    public static function create(): static
    {
        $static = new static();
        $static
            ->setRiskyAllowed(true)
            ->setRules(static::$typo3Rules)
        ;
        $static->getFinder()
            ->exclude([
                '.build',
                'typo3temp',
                'var',
                'vendor',
            ])
        ;

        return $static;
    }

    /**
     * @param array<string, mixed> $rules
     */
    public function addRules(array $rules): static
    {
        $rules = array_replace_recursive($this->getRules(), $rules);
        $this->setRules($rules);

        return $this;
    }

    public function setHeader(
        string $header = 'This file is part of the TYPO3 CMS project.',
        bool $replaceAll = false
    ): static {
        if (!$replaceAll) {
            $header = str_replace('{header}', $header, static::$defaultHeader);
        }

        $rules = $this->getRules();
        $rules['header_comment'] = [
            'header' => $header,
            'comment_type' => 'comment',
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ];
        $this->setRules($rules);

        return $this;
    }
}
