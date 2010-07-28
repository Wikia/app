<?php
/**
 * @file
 * @ingroup SpecialPage
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Withoutimages',
	'author' => 'Emil Podlaszewski',
	'descriptionmsg' => 'withoutimages-desc',
);

$dir = dirname(__FILE__) . '/';

// autoloader
$wgAutoloadClasses['SpecialWithoutimages'] = $dir . 'SpecialWithoutimages.class.php';
$wgAutoloadClasses['WithoutimagesPage'] = $dir . 'WithoutimagesPage.class.php';

// i18n
$wgExtensionAliasesFiles['Withoutimages'] = $dir . 'SpecialWithoutimages.alias.php';
$wgExtensionMessagesFiles['Withoutimages'] = $dir . 'SpecialWithoutimages.i18n.php';

// special page
$wgSpecialPages['Withoutimages'] = 'SpecialWithoutimages';
$wgSpecialPageGroups['Withoutimages'] = 'maintenance';

// hooks
$wgHooks['wgQueryPages'][] = 'efRegisterWithoutimagesPage';
function efRegisterWithoutimagesPage( &$wgQueryPages ) {
	$wgQueryPages[] = array( 'WithoutimagesPage', 'Withoutimages' );
	return true;
}
