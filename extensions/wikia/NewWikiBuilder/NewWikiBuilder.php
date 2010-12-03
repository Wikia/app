<?php
if (!defined('MEDIAWIKI')) {
        echo "To install my extension, put the following line in LocalSettings.php:\n
require_once('" . __FILE__ . "');";
        exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'NewWikiBuilder',
	'author' => 'Nick Sullivan',
	'description' => 'Wizard to walk new founders through the wiki setup process',
	'version' => '0.0.1',
);

// New user right, required to use the extension.
$wgAvailableRights[] = 'newwikibuilder';
$wgGroupPermissions['*']['newwikibuilder'] = false;
$wgGroupPermissions['sysop']['newwikibuilder'] = true;
$wgGroupPermissions['bureaucrat']['newwikibuilder'] = true;
$wgGroupPermissions['staff']['newwikibuilder'] = true;

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['NewWikiBuilder'] = $dir . 'NewWikiBuilder.body.php';
$wgExtensionMessagesFiles['NewWikiBuilder'] = $dir . 'NewWikiBuilder.i18n.php';
$wgExtensionAliasesFiles['NewWikiBuilder'] = $dir . 'NewWikiBuilder.alias.php';
$wgSpecialPages['NewWikiBuilder'] = 'NewWikiBuilder';

// Set up API extensions
$NWBApiExtensions = array(
	'uploadlogo' => 'ApiUploadLogo',
	'foundersettings' => 'ApiFounderSettings',
	'createmultiplepages' => 'ApiCreateMultiplePages',
);
foreach ($NWBApiExtensions as $action => $classname){
	$wgAutoloadClasses[$classname] = $dir . $classname . '.php';
	$wgAPIModules[$action] = $classname;
}

/* UPDATE: This is no longer used.
//removes category [[Category:New pages]] if any non-category content is saved to the page
$wgHooks['EditPage::attemptSave'][] = 'fnMarkAsSeen';
function fnMarkAsSeen( $editpage){
	global $wgContLang;

        if( Title::newFromRedirect( $editpage->textbox1 ) != NULL )return true;

	// WTF, this doesn't work. wfMsg Comes through as "<nwb-new-pages>" 
	// $newPagesCat = "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . wfMsg("nwb-new-pages") .  "]]";
	$newPagesCat = "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . "New pages" .  "]]";
	if (strstr($editpage->textbox1, $newPagesCat) === false ){
		// This text doesn't have a "New pages" category. Don't bother.
		return true;
	}

	// Check to see if there is any non-category content
	$textWithoutCat = trim(str_replace($newPagesCat, '', $editpage->textbox1 ));
	if (!empty($textWithoutCat)){
		$editpage->textbox1 = $textWithoutCat;
	}

        return true;
}
*/
