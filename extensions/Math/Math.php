<?php
/**
 * MediaWiki math extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Tomasz Wegrzanowski
 * @author Brion Vibber
 * @copyright © 2002-2011 various MediaWiki contributors
 * @license GPLv2 license; info in main package.
 * @link http://www.mediawiki.org/wiki/Extension:Math Documentation
 * @see https://bugzilla.wikimedia.org/show_bug.cgi?id=14202
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point to MediaWiki.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Math',
	'version' => '1.0',
	'author' => array( 'Tomasz Wegrzanowski', 'Brion Vibber', '...' ),
	'descriptionmsg' => 'math-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Math',
);

/**@{
 * Maths constants
 */
define( 'MW_MATH_PNG',    0 );
define( 'MW_MATH_SIMPLE', 1 ); /// @deprecated
define( 'MW_MATH_HTML',   2 ); /// @deprecated
define( 'MW_MATH_SOURCE', 3 );
define( 'MW_MATH_MODERN', 4 ); /// @deprecated
define( 'MW_MATH_MATHML', 5 ); /// @deprecated
/**@}*/

/** For back-compat */
$wgUseTeX = false;

/** Location of the texvc binary */
$wgTexvc = '/usr/bin/texvc'; # WIKIA CHANGE
/**
 * Texvc background color
 * use LaTeX color format as used in \special function
 * for transparent background use value 'Transparent' for alpha transparency or
 * 'transparent' for binary transparency.
 */
$wgTexvcBackgroundColor = 'transparent';

/**
 * Normally when generating math images, we double-check that the
 * directories we want to write to exist, and that files that have
 * been generated still exist when we need to bring them up again.
 *
 * This lets us give useful error messages in case of permission
 * problems, and automatically rebuild images that have been lost.
 *
 * On a big site with heavy NFS traffic this can be slow and flaky,
 * so sometimes we want to short-circuit it by setting this to false.
 */
$wgMathCheckFiles = true;

/**
 * The URL path of the math directory. Defaults to "{$wgUploadPath}/math".
 *
 * See http://www.mediawiki.org/wiki/Manual:Enable_TeX for details about how to
 * set up mathematical formula display.
 */
$wgMathPath = false;

/**
 * The filesystem path of the math directory.
 * Defaults to "{$wgUploadDirectory}/math".
 *
 * See http://www.mediawiki.org/wiki/Manual:Enable_TeX for details about how to
 * set up mathematical formula display.
 */
$wgMathDirectory = false;

/**
 * Experimental option to use MathJax library to do client-side math rendering
 * when JavaScript is available. In supporting browsers this makes nice output
 * that's scalable for zooming, printing, and high-resolution displays.
 *
 * Not guaranteed to be stable at this time.
 */
$wgUseMathJax = true;

////////// end of config settings.

$wgDefaultUserOptions['math'] = MW_MATH_SOURCE; // SUS-4529 - use front-end rendering

$wgExtensionFunctions[] = 'MathHooks::setup';
$wgHooks['ParserFirstCallInit'][] = 'MathHooks::onParserFirstCallInit';
$wgHooks['GetPreferences'][] = 'MathHooks::onGetPreferences';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'MathHooks::onLoadExtensionSchemaUpdates';
$wgHooks['ParserTestTables'][] = 'MathHooks::onParserTestTables';
$wgHooks['ParserTestParser'][] = 'MathHooks::onParserTestParser';

$wgAutoloadClasses['MathHooks'] = __DIR__ . '/Math.hooks.php';
$wgAutoloadClasses['MathRenderer'] = __DIR__ . '/Math.body.php';

$wgExtensionMessagesFiles['Math'] = __DIR__ . '/Math.i18n.php';

$wgParserTestFiles[] = __DIR__ . '/mathParserTests.txt';

$moduleTemplate = array(
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'Math/modules',
);

$wgResourceModules['ext.math.mathjax'] = array(
	'scripts' => array(
		'MathJax/MathJax.js',
		'MathJax/jax/input/TeX/config.js',
		'MathJax/jax/output/HTML-CSS/config.js',
		'MathJax/jax/element/mml/jax.js',
		'MathJax/extensions/TeX/noErrors.js',
		'MathJax/extensions/TeX/noUndefined.js',
		'MathJax/jax/input/TeX/jax.js',
		'MathJax/extensions/TeX/AMSmath.js',
		'MathJax/extensions/TeX/AMSsymbols.js',
		'MathJax/extensions/TeX/boldsymbol.js',
		'MathJax/extensions/TeX/mathchoice.js',
		'MathJax/jax/output/HTML-CSS/jax.js',
		'MathJax/jax/output/HTML-CSS/autoload/mtable.js',
		'MathJax-custom/extensions/wiki2jax.js',
		'MathJax-custom/extensions/TeX/texvc.js'
	),
	'group' => 'ext.math.mathjax',
) + $moduleTemplate;

$wgResourceModules['ext.math.mathjax.enabler'] = array(
	'scripts' => 'ext.math.mathjax.enabler.js',
) + $moduleTemplate;
