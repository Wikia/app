<?php
/**
 * Internationalisation file for extension WikiScripts.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Victor Vasiliev
 */
$messages['en'] = array(
	'wikiscripts-desc' => 'Provides a build into wikitext scripting language',

	'wikiscripts-call-frommodule' => '$1::$2 called by $3::$4 at line $5',
	'wikiscripts-call-fromwikitext' => '$1::$2 called by wikitext',
	'wikiscripts-call-parse' => 'parse( "$1" )',

	'wikiscripts-error' => 'Following parsing {{plural:$1|error|errors}} detected:',
	'wikiscripts-codelocation' => 'in module $1 at line $2',

	'wikiscripts-exception-unexceptedtoken' => 'Unexpected token $2 $1: expected $3 (parser state $4)',
	'wikiscripts-exception-unclosedstring' => 'Unclosed string $1',
	'wikiscripts-exception-unrecognisedtoken' => 'Unrecognized token $1',
	'wikiscripts-exception-toomanytokens' => 'Exceeded tokens limit',
	'wikiscripts-exception-toomanyevals' => 'Exceeded evaluations limit $1',
	'wikiscripts-exception-recoverflow' => 'Too deep abstract syntax tree',
	'wikiscripts-exception-notanarray' => 'Tried to get or set an element of a non-array $1',
	'wikiscripts-exception-outofbounds' => 'Got out of array bounds $1',
	'wikiscripts-exception-notenoughargs' => '$3 arguments required for function $2; $4 supplied ($1)',
	'wikiscripts-exception-dividebyzero' => 'Division by zero $1',
	'wikiscripts-exception-break' => '"break" called outside of foreach $1',
	'wikiscripts-exception-continue' => '"continue" called outside of foreach $1',
	'wikiscripts-exception-emptyidx' => 'Trying to get a value of an empty index $1',
	'wikiscripts-exception-unknownvar' => 'Trying to use an undeclared variable $2 $1',
	'wikiscripts-exception-unknownfunction' => 'Trying to use an unnknown built-in function $2 $1',
	'wikiscripts-exception-notlist' => 'Trying to append an element to the end of \'\'associated\'\' array $1',
	'wikiscripts-exception-appendyield' => 'Trying to use append and yield in the same function $1',
	'wikiscripts-exception-assocbadmerge' => 'Trying to merge an assoicated array with a non-array $1',

	'wikiscripts-exception-notenoughargs-user' => 'Not enough arguments for function $2::$3 $1',
	'wikiscripts-exception-nonexistent-module' => 'Call to non-existent module $2 $1',
	'wikiscripts-exception-unknownfunction-user' => 'Trying to use an unnknown user function $2::$3 $1',
	'wikiscripts-exception-recursion' => 'Function loop detected when calling function $2::$3 $1',
	'wikiscripts-exception-toodeeprecursion' => 'The maximum function nesting limit of $2 exceeded $1',

	'wikiscripts-transerror-notenoughargs-user' => 'Not enough arguments for function $1::$2',
	'wikiscripts-transerror-nonexistent-module' => 'Call to non-existent module $1',
	'wikiscripts-transerror-unknownfunction-user' => 'Trying to use an unnknown user function $1::$2',
	'wikiscripts-transerror-recursion' => 'Function loop detected when calling function $1::$2',
	'wikiscripts-transerror-nofunction' => 'Missing function name when invoking the script',
	'wikiscripts-transerror-toodeeprecursion' => 'The maximum function nesting limit of $1 exceeded',
);
