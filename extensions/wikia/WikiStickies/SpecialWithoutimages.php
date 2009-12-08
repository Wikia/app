<?php
/**
 * @file
 * @ingroup SpecialPage
 */

$dir = dirname(__FILE__) . '/';

// autoloader
$wgAutoloadClasses['WithoutimagesPage'] = $dir . 'SpecialWithoutimages.class.php';

// i18n
$wgExtensionAliasesFiles['Withoutimages'] = $dir . 'SpecialWithoutimages.alias.php';
$wgExtensionMessagesFiles['Withoutimages'] = $dir . 'SpecialWithoutimages.i18n.php';

// special page
$wgSpecialPages['Withoutimages'] = array( 'SpecialPage', 'Withoutimages' );
$wgSpecialPageGroups['Withoutimages'] = 'maintenance';
function wfSpecialWithoutimages() {
	list( $limit, $offset ) = wfCheckLimits();

	wfLoadExtensionMessages( 'Withoutimages' );
	$wpp = new WithoutimagesPage();

	$wpp->doQuery( $offset, $limit );
}

// hooks
$wgHooks['wgQueryPages'][] = 'efRegisterWithoutimagesPage';
function efRegisterWithoutimagesPage( &$wgQueryPages ) {
	$wgQueryPages[] = array( 'WithoutimagesPage', 'Withoutimages' );
	return true;
}
