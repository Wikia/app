<?php
/**
 * Minify bundles the YUI CSS compressor by Julien Lecomte and Isaac Schlueter with
 * the JSMin Javascript compressor by Douglass Crockford and Ryan Grove.
 *
 * When installed it automatically catches calls to RawPage.php and pre-compresses the
 * CSS and Javascript output generated there.  This can significantly reduce the size of
 * CSS and Javascript files that are dynamically returned by Mediawiki, such as
 * Mediawiki:Common.css and Mediawiki:Common.js.  However, it does not affect the static
 * files living in /skins/, etc.
 */

$wgExtensionCredits['other'][] = array(
	'name'            => 'Minify',
	'version'         => '0.8.1', // June 26, 2009
	'descriptionmsg'  => 'minify-desc',
	'author'          => 'Robert Rohde',
	'url'             => 'https://www.mediawiki.org/wiki/Extension:Minify',
	'path'            => __FILE__,
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['Minify'] = $dir . 'Minify_body.php';
$wgAutoloadClasses['JSMin'] = $dir . 'jsmin.php';

$wgHooks['RawPageViewBeforeOutput'][] = 'wfMinify';
$wgExtensionMessagesFiles['Minify'] = $dir . 'Minify.i18n.php';

function wfMinify( &$rawPage, &$text ) {

	$minify = new Minify( $text );
	$text = $minify->run();

	return true;
}
