<?php
/**
 @ Extension based on SpecialContributions for archived revisions
 @ Modifications made to SpecialContributions.php
 @ copyright © 2007 Aaron Schulz
 */

$wgExtensionCredits['specialpage'][] = array(
	'author' => 'Aaron Schulz',
	'version' => preg_replace('/^.* (\d\d\d\d-\d\d-\d\d) .*$/', '\1', '$LastChangedDate: 2008-02-27 14:13:10 +0000 (Wed, 27 Feb 2008) $'), #just the date of the last change
	'name' => 'Deleted user contributions',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DeletedContributions',
	'description' => 'Gives sysops the ability to browse a user\'s deleted edits',
	'descriptionmsg' => 'deletedcontributions-desc',
);

# Internationalisation
$wgExtensionMessagesFiles['DeletedContributions'] = dirname(__FILE__) . '/DeletedContributions.i18n.php';
$wgExtensionFunctions[] = 'efLoadDeletedContribs';

$wgHooks['ContributionsToolLinks'][] = 'wfLoadContribsLink';
$wgHooks['SpecialPageExecuteBeforeHeader'][] = 'wfDeletedContributionsMessages';

/**
 * Add a "Deleted contributions" link to Special:Contributions for sysops.
 */
function wfLoadContribsLink( $id, $nt, &$links ) {
	global $wgUser;
	if( $wgUser->isAllowed( 'deletedhistory' ) ) {
		wfLoadExtensionMessages( 'DeletedContributions' );

		$links[] = $wgUser->getSkin()->makeKnownLinkObj(
			SpecialPage::getTitleFor( 'DeletedContributions', $nt->getDBkey() ),
			wfMsgHtml( 'deletedcontributions' )
		);
	}
	return true;
}

function wfDeletedContributionsMessages( $specialpage, $par, $func ) {
	if( $specialpage->name() == 'DeletedContributions' ) {
		wfLoadExtensionMessages( 'DeletedContributions' );
		$specialpage->setHeaders(); // set again so that it actually has the fucking message
	}
	return true;
}

# Load once IndexPager and stuff is loaded
function efLoadDeletedContribs() {
	require( dirname( __FILE__ ) . '/DeletedContributions_body.php' );
}

$wgSpecialPages['DeletedContributions'] = array( 'SpecialPage', 'DeletedContributions', 'deletedhistory',
		/*listed*/ true, /*function*/ false, /*file*/ false );
