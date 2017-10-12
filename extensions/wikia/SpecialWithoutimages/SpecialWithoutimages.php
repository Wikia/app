<?php
/**
 * @file
 * @ingroup SpecialPage
 */
 
$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'SpecialWithoutimages',
	'author' => 'Wikia',
	'descriptionmsg' => 'withoutimages-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialWithoutimages',
);

$dir = dirname(__FILE__) . '/';

// autoloader
$wgAutoloadClasses['SpecialWithoutimages'] = $dir . 'SpecialWithoutimages.class.php';
$wgAutoloadClasses['WithoutimagesPage'] = $dir . 'WithoutimagesPage.class.php';

// i18n

// special page
$wgSpecialPages['Withoutimages'] = 'SpecialWithoutimages';
$wgSpecialPageGroups['Withoutimages'] = 'maintenance';

// hooks
$wgHooks['wgQueryPages'][] = 'efRegisterWithoutimagesPage';
function efRegisterWithoutimagesPage( &$wgQueryPages ) {
	$wgQueryPages[] = array( 'WithoutimagesPage', 'Withoutimages' );
	return true;
}
