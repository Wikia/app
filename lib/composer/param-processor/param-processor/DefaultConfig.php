<?php

/**
 * This file assigns the default values to all ParameterProcessor settings.
 *
 * @licence GNU GPL v2+
 */

use ParamProcessor\Definition\DimensionParam;
use ParamProcessor\Definition\StringParam;
use ValueParsers\BoolParser;
use ValueParsers\FloatParser;
use ValueParsers\IntParser;
use ValueValidators\DimensionValidator;
use ValueValidators\RangeValidator;
use ValueValidators\StringValidator;

$GLOBALS['egValidatorSettings'] = [
	'errorListMinSeverity' => 'minor',
];

$GLOBALS['wgParamDefinitions'] = [
	'boolean' => [
		'string-parser' => BoolParser::class,
		'validation-callback' => 'is_bool',
	],
	'float' => [
		'string-parser' => FloatParser::class,
		'validation-callback' => function( $value ) {
			return is_float( $value ) || is_int( $value );
		},
		'validator' => RangeValidator::class,
	],
	'integer' => [
		'string-parser' => IntParser::class,
		'validation-callback' => 'is_int',
		'validator' => RangeValidator::class,
	],
	'string' => [
		'validator' => StringValidator::class,
		'definition' => StringParam::class,
	],
	'dimension' => [
		'definition' => DimensionParam::class,
		'validator' => DimensionValidator::class,
	],
];
