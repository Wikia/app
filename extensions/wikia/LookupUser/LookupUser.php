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
 * @param array $links
 * @param IContextSource $context
 * @return bool true
 */
function efLoadLookupUserLink( $id, $nt, &$links, IContextSource $context ) {
	if ( $context->getUser()->isAllowed( 'lookupuser' ) && $id !== 0 ) {
		$links[] = Linker::linkKnown(
			GlobalTitle::newFromText( 'LookupUser', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID ),
			$context->msg( 'lookupuser' )->escaped(), /* text */
			[], /* attributes */
			[ 'target' => $nt->getText() ] /* query string */
		);
	}
	return true;
}
