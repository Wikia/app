<?php
/*

 Defines a subset of parser functions that operate with strings.

 {{#len:value}}

 Returns the length of the given value.
 See: http://php.net/manual/function.strlen.php


 {{#pos:value|key|offset}}

 Returns the first position of key inside the given value, or an empty string.
 If offset is defined, this method will not search the first offset characters.
 See: http://php.net/manual/function.strpos.php


 {{#rpos:value|key}}

 Returns the last position of key inside the given value, or -1 if the key is
 not found. When using this to search for the last delimiter, add +1 to the
 result to retreive position after the last delimiter. This also works when
 the delimiter is not found, because "-1 + 1" is zero, which is the beginning
 of the given value.
 See: http://php.net/manual/function.strrpos.php


 {{#sub:value|start|length}}

 Returns a substring of the given value with the given starting position and
 length. If length is omitted, this returns the rest of the string.
 See: http://php.net/manual/function.substr.php


 {{#pad:value|length|with|direction}}

 Returns the value padded to the certain length with the given with string.
 If the with string is not given, spaces are used for padding. The direction
 may be specified as: 'left', 'center' or 'right'.
 See: http://php.net/manual/function.str-pad.php


 {{#replace:value|from|to}}

 Returns the given value with all occurences of 'from' replaced with 'to'.
 See: http://php.net/manual/function.str-replace.php


 {{#explode:value|delimiter|position}}

 Splits the given value into pieces by the given delimiter and returns the
 position-th piece. Empty string is returned if there are not enough pieces.
 Note: Pieces are counted from 0.
 Note: A negative value can be used to count pieces from the end, instead of
 counting from the beginning. The last piece is at position -1.
 See: http://php.net/manual/function.explode.php


 {{#urlencode:value}}

 URL-encodes the given value.
 See: http://php.net/manual/function.urlencode.php


 {{#urldecode:value}}

 URL-decodes the given value.
 See: http://php.net/manual/function.urldecode.php


 Copyright (c) 2008 Ross McClure & Juraj Simlovic
  http://www.mediawiki.org/wiki/User:Algorithm
  http://www.mediawiki.org/wiki/User:jsimlo

 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.

*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'StringFunctions',
	'version' => '2.0.3', // Nov 30, 2008
	'author' => array( 'Ross McClure', 'Juraj Simlovic' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:StringFunctions',
	'descriptionmsg' => 'stringfunctions-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgParserTestFiles[] = $dir . "/strFunctionsParserTests.txt";
$wgExtensionMessagesFiles['StringFunctions'] = $dir . 'StringFunctions.i18n.php';
$wgExtensionMessagesFiles['StringFunctionsMagic'] = $dir . 'StringFunctions.i18n.magic.php';
$wgAutoloadClasses['ExtStringFunctions']     = $dir . 'StringFunctions_body.php';

$wgHooks['ParserFirstCallInit'][] = 'wfStringFunctions';

$wgStringFunctionsLimitSearch  = 30;
$wgStringFunctionsLimitReplace = 30;
$wgStringFunctionsLimitPad     = 100;

function wfStringFunctions( &$parser ) {
	$parser->setFunctionHook( 'len', array( 'ExtStringFunctions', 'runLen' ) );
	$parser->setFunctionHook( 'pos', array( 'ExtStringFunctions', 'runPos' ) );
	$parser->setFunctionHook( 'rpos', array( 'ExtStringFunctions', 'runRPos' ) );
	$parser->setFunctionHook( 'sub', array( 'ExtStringFunctions', 'runSub' ) );
	$parser->setFunctionHook( 'pad', array( 'ExtStringFunctions', 'runPad' ) );
	$parser->setFunctionHook( 'replace', array( 'ExtStringFunctions', 'runReplace' ) );
	$parser->setFunctionHook( 'explode', array( 'ExtStringFunctions', 'runExplode' ) );
	$parser->setFunctionHook( 'urldecode', array( 'ExtStringFunctions', 'runUrlDecode' ) );

	return true;
}

