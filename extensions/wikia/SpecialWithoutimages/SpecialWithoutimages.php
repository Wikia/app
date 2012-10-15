<?php
/**
 * @file
 * @ingroup SpecialPage
 */

$dir = dirname(__FILE__) . '/';

// autoloader
$wgAutoloadClasses['SpecialWithoutimages'] = $dir . 'SpecialWithoutimages.class.php';
$wgAutoloadClasses['WithoutimagesPage'] = $dir . 'WithoutimagesPage.class.php';

// i18n
$wgExtensionMessagesFiles['Withoutimages'] = $dir . 'SpecialWithoutimages.i18n.php';
$wgExtensionMessagesFiles['WithoutimagesAliases'] = $dir . 'SpecialWithoutimages.alias.php';

// special page
$wgSpecialPages['Withoutimages'] = 'SpecialWithoutimages';
$wgSpecialPageGroups['Withoutimages'] = 'maintenance';

// hooks
$wgHooks['wgQueryPages'][] = 'efRegisterWithoutimagesPage';
function efRegisterWithoutimagesPage( &$wgQueryPages ) {
	$wgQueryPages[] = array( 'WithoutimagesPage', 'Withoutimages' );
	return true;
}
