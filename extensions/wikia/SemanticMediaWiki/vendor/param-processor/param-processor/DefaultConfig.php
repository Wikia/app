<?php

/**
 * This file assigns the default values to all ParameterProcessor settings.
 *
 * @licence GNU GPL v2+
 */

$GLOBALS['egValidatorSettings'] = array(
	'errorListMinSeverity' => 'minor',
);

$GLOBALS['wgParamDefinitions'] = array(
	'boolean' => array(
		'string-parser' => '\ValueParsers\BoolParser',
		'validation-callback' => 'is_bool',
	),
	'float' => array(
		'string-parser' => '\ValueParsers\FloatParser',
		'validation-callback' => function( $value ) {
			return is_float( $value ) || is_int( $value );
		},
		'validator' => '\ValueValidators\RangeValidator',
	),
	'integer' => array(
		'string-parser' => '\ValueParsers\IntParser',
		'validation-callback' => 'is_int',
		'validator' => '\ValueValidators\RangeValidator',
	),
	'string' => array(
		'validator' => '\ValueValidators\StringValidator',
		'definition' => '\ParamProcessor\Definition\StringParam',
	),
	'dimension' => array(
		'definition' => '\ParamProcessor\Definition\DimensionParam',
		'validator' => '\ValueValidators\DimensionValidator',
	),
);
