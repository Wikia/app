<?php
/**
 * Extension to to retrieve information about a user such as email address and ID.
 *
 * @file
 * @ingroup Extensions
 * @version 1.2
 * @author Tim Starling, modified by Piotr Molski (MoLi)
 * @copyright © 2006 Tim Starling
 * @licence GNU General Public Licence
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Lookup User',
	'version' => '1.2',
	'author' => 'Tim Starling, modified by Piotr Molski (MoLi) for Wikia (moli@wikia-inc.com)',
	'description' => 'Retrieve information about a user such as email address and ID',
	'url' => 'http://www.mediawiki.org/wiki/Extension:LookupUser',
	'descriptionmsg' => 'lookupuser-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['LookupUser'] = $dir . 'LookupUser.i18n.php';
$wgExtensionAliasesFiles['LookupUser'] = $dir . 'LookupUser.alias.php';
$wgAutoloadClasses['LookupUserPage'] = $dir . 'LookupUser.body.php';
$wgSpecialPages['LookupUser'] = 'LookupUserPage';
// Special page group for MW 1.13+
$wgSpecialPageGroups['LookupUser'] = 'users';

// small stuff week --nAndy
global $wgAjaxExportList;
$wgAjaxExportList[] = "LookupUserPage::loadAjaxContribData";
$wgAjaxExportList[] = "LookupUserPage::requestApiAboutUser";

// Hooked function
$wgHooks['ContributionsToolLinks'][] = 'efLoadLookupUserLink';

/**
 * Add a link to Special:LookupUser from Special:Contributions/USERNAME
 * if the user has 'lookupuser' permission
 *
 * @param integer $id
 * @param Title $nt
 *
 * @return bool true
 */
function efLoadLookupUserLink( $id, $nt, &$links ) {
	global $wgUser;
	if ( $wgUser->isAllowed( 'lookupuser' ) && $id !== 0 ) {
		$links[] = Linker::linkKnown(
			SpecialPage::getTitleFor( 'LookupUser' ),
			wfMsgHtml( 'lookupuser' ),
			array(),
			array( 'target' => $nt->getText() )
		);
	}
	return true;
}
