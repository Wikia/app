<?php
/**
 * LockDownEnglishPages -- prevents non-staff users from editing the English
 * interface messages on the Inteface Messages Wiki
 *
 * @file
 * @ingroup Extensions
 * @version 0.1
 * @date 6 July 2011
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 * @see http://bugzilla.shoutwiki.com/show_bug.cgi?id=54
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'Lock Down English Pages',
	'version' => '0.1',
	'author' => 'Jack Phoenix',
	'description' => 'Prevents non-staff users from editing the English interface messages',
	'url' => 'https://www.mediawiki.org/wiki/Extension:LockDownEnglishPages',
);

$wgHooks['userCan'][] = 'wfLockDownEnglishPages';
function wfLockDownEnglishPages( &$title, &$user, $action, &$result ) {
	// We want to prevent editing of MediaWiki pages for users who have the
	// editinterface right but who are not staff when the action is 'edit'
	if (
		$title->getNamespace() == NS_MEDIAWIKI &&
		$user->isAllowed( 'editinterface' ) &&
		!in_array( 'staff', $user->getEffectiveGroups() ) &&
		$action == 'edit'
	)
	{
		$pageTitle = $title->getDBkey();
		if (
			preg_match( '/\/en/', $pageTitle ) || // page title has /en in it
			!preg_match( '/\//', $pageTitle ) // page title has no / in it
		)
		{
			$result = false;
			return false;
		}
	}
	return true;
}