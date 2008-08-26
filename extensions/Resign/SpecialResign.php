<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to allow users to remove their permissions.
 * Should be included as the latest extension that sets user groups.
 *
 * @addtogroup Extensions
 *
 * @author Rotem Liss
 */

$wgExtensionCredits['specialpage'][] = array(
	'author' => 'Rotem Liss',
	'svn-date' => '$LastChangedDate: 2008-05-31 03:03:00 +0000 (Sat, 31 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 35631 $',
	'name' => 'Resign',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Resign',
	'description' => 'Gives users the ability to remove their permissions',
	'descriptionmsg' => 'resign-desc',
);

# Add resign permission for every group set in the database
foreach( $wgGroupPermissions as $key => $value ) {
	if( !in_array( $key, $wgImplicitGroups ) ) {
		$wgGroupPermissions[$key]['resign'] = true;
	}
}
$wgAvailableRights[] = 'resign';

# Add log action
$wgLogActions['rights/resign'] = 'resign-logentry';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ResignPage'] = $dir . 'SpecialResign.i18n.php';
$wgAutoloadClasses['ResignPage'] = $dir . 'SpecialResign_body.php';
$wgSpecialPages['Resign'] = 'ResignPage';
$wgSpecialPageGroups['Resign'] = 'users';
