<?php
/**
 * TrustedMath extension for MediaWiki. Enables LaTeX equations without OCaml.
 */

/*

Copyright (C) 2011 by Bryan Tong Minh

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

$wgExtensionCredits['parserhooks'][] = array(
	'path' => __FILE__,
	'name' => 'TrustedMath',
	'url' => 'https://www.mediawiki.org/wiki/Extension:TrustedMath',
	'author' => 'Bryan Tong Minh',
	'descriptionmsg' => 'trustedmath-desc',
);

$dir = dirname( __FILE__ );
$wgAutoloadClasses['TrustedMath'] = "$dir/TrustedMath_body.php";
$wgAutoloadClasses['TrustedMathHooks'] = "$dir/TrustedMathHooks.php";

$wgExtensionMessagesFiles['TrustedMath'] = "$dir/TrustedMath.i18n.php";
$wgExtensionMessagesFiles['TrustedMathNamespaces'] = "$dir/TrustedMath.namespaces.php";

$wgExtensionFunctions[] = 'TrustedMathHooks::initGlobals';
$wgHooks['ParserFirstCallInit'][] = 'TrustedMathHooks::onParserFirstCallInit';
$wgHooks['CanonicalNamespaces'][] = 'TrustedMathHooks::initNamespace';
#Broken
#$wgHooks['ParserAfterStrip'][] = 'TrustedMathHooks::onParserAfterStrip';

define( 'NS_TRUSTEDMATH', 262 );
define( 'NS_TRUSTEDMATH_TALK', 263 );

// Path to latex
$wgTrustedMathLatexPath = null;
// Path to dvipng
$wgTrustedMathDviPngPath = null;
// Output path. If left null defaults to images/math
$wgTrustedMathDirectory = null;
// Environment variables required for latex and dvipng
// When using Windows set to array( 'USERPROFILE' => $path ) with $path 
// something writable for the webserver
$wgTrustedMathEnvironment = array();
// URL to the math directory
$wgTrustedMathPath = null;
// Allow math in <math> tags
$wgTrustedMathUnsafeMode = false;


