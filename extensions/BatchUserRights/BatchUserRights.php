<?php
/**
 * Special page to allow adding user group membership to a large number of users at once.
 * (such as adding a couple of hundred people to the "beta" user group).
 *
 * @file
 * @ingroup SpecialPage
 * @version 1.1 (r43851)
 * @author Sean Colombo
 * @link http://www.mediawiki.org/wiki/Extension:BatchUserRights Documentation
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'BatchUserRights',
	'version' => '1.1.2',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'batchuserrights-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:BatchUserRights',
);

set_time_limit( 0 );
// New user right, required to access Special:BatchUserRights
$wgAvailableRights[] = 'batchuserrights';
$wgGroupPermissions['bureaucrat']['batchuserrights'] = true;

// User groups which can be added through Special:BatchUserRights
$wgBatchUserRightsGrantableGroups = array();

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['BatchUserRights'] = $dir . 'BatchUserRights.i18n.php';
$wgExtensionMessagesFiles['BatchUserRightsAliases'] = $dir . 'BatchUserRights.alias.php';
$wgAutoloadClasses['SpecialBatchUserRights'] = $dir . 'BatchUserRights_body.php';
$wgSpecialPages['BatchUserRights'] = 'SpecialBatchUserRights';
