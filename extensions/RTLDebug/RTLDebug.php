<?php

/**
 * Debugging RTL support is difficult because the effects of choosing the wrong
 * direction for an HTML element depend on the text that that element contains.
 * If the text entirely consists of characters with a strong direction, the
 * display will seem OK regardless of what direction is set on the element, but
 * if you add neutrals (such as punctation), it will break, and if you add
 * characters with both directions, then it will break badly.
 *
 * Thus, it helps to have a visual tool which displays whether a given HTML
 * element is designated RTL or LTR. This extension provides two such features:
 *
 *   * After the page is loaded, all RTL elements will be coloured red, and all
 *     LTR elements will be coloured green.
 *
 *   * An "English (RTL)" option is added to the language options. If this
 *     language is selected in user preferences, all user interface text will
 *     be backwards: naht rehtar kcah SSC a htiw tpecxe siht ekil fo dniK
 *     .noitcerid txet lacigol eht gnisrever
 */


$wgResourceModules['ext.rtlDebug'] = array(
	'scripts' => 'rtl-debug.js',
	'styles' => 'rtl-debug.css',
	'remoteExtPath' => 'RTLDebug',
	'localBasePath' => dirname( __FILE__ ),
);

$wgHooks['BeforePageDisplay'][] = 'wfRtlDebug_BeforePageDisplay';
$wgExtraLanguageNames['en-rtl'] = 'English (RTL)';

function wfRtlDebug_BeforePageDisplay( &$out, &$skin ) {
	$out->addModules( 'ext.rtlDebug' );
	if ( $out->getLang()->getCode() == 'en-rtl' ) {
		$out->addInlineStyle( '* { unicode-bidi: bidi-override; }' );
	}
	return true;
}

