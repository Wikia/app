<?php
/**
 * Internationalisation file for extension InlineScripts.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Victor Vasiliev
 */
$messages['en'] = array(
	'inlinescripts-desc' => 'Provides a build into wikitext scripting language',

	'inlinescripts-exception-unexceptedtoken' => 'Unexpected token $1 at line $2: expected $3',
	'inlinescripts-exception-unclosedstring' => 'Unclosed string at char $1',
	'inlinescripts-exception-unrecognisedtoken' => 'Unrecognized token at char $1',
	'inlinescripts-exception-toomanytokens' => 'Exceeded tokens limit',
	'inlinescripts-exception-toomanyevals' => 'Exceeded evaluations limit at line $1',
	'inlinescripts-exception-recoverflow' => 'Too deep abstract syntax tree',
	'inlinescripts-exception-notanarray' => 'Tried to get an element of a non-array at line $1',
	'inlinescripts-exception-outofbounds' => 'Got out of array bounds at line $1',
	'inlinescripts-exception-notenoughargs' => 'Not enough arguments for function at line $1',
	'inlinescripts-exception-dividebyzero' => 'Division by zero at line $1',
	'inlinescripts-exception-break' => '"break" called outside of foreach at line $1',
	'inlinescripts-exception-continue' => '"continue" called outside of foreach at line $1',
	'inlinescripts-exception-emptyidx' => 'Trying to get a value of an empty index at line $1',
	'inlinescripts-exception-unknownvar' => 'Trying to use an undeclared variable at line $1',
);

// == Magic words ==

$magicWords = array();

$magicWords['en'] = array(
	'script' => array( 0, 'script' ),
	'inline' => array( 0, 'inline' ),
);
