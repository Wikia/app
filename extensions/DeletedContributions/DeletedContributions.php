<?php
/**
 * Extension based on SpecialContributions for archived revisions
 * Modifications made to SpecialContributions.php
 * @copyright © 2007 Aaron Schulz
 */

$wgExtensionCredits['specialpage'][] = array(
	'author' => 'Aaron Schulz',
	'svn-date' => '$LastChangedDate: 2008-07-15 08:54:15 +0000 (Tue, 15 Jul 2008) $',
	'svn-revision' => '$LastChangedRevision: 37682 $',
	'name' => 'Deleted user contributions',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DeletedContributions',
	'description' => 'Gives sysops the ability to browse a user\'s deleted edits',
	'descriptionmsg' => 'deletedcontributions-desc',
);

# Internationalisation
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DeletedContributions'] = $dir . 'DeletedContributions.i18n.php';
$wgExtensionAliasesFiles['DeletedContributions'] = $dir . 'DeletedContributions.i18n.alias.php';

$wgAutoloadClasses['DeletedContributionsPage'] 
	= $wgAutoloadClasses['DeletedContributionsPage']
	= $dir . 'DeletedContributions_body.php';

$wgHooks['ContributionsToolLinks'][] = 'wfLoadDeletedContribsLink';
$wgSpecialPages['DeletedContributions'] = 'DeletedContributionsPage';
$wgSpecialPageGroups['DeletedContributions'] = 'users';

/**
 * Add a "Deleted contributions" link to Special:Contributions for sysops.
 */
function wfLoadDeletedContribsLink( $id, $nt, &$links ) {
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
