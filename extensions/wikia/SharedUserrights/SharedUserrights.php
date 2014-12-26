<?php
/**
* SharedUserrights -- manage global rights stored in shared database
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Lucas 'TOR' Garczewski <tor@wikia.com>
* @author: Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
*
* @copyright Copyright (C) 2008 Lucas 'TOR' Garczewski, Wikia, Inc.
* @copyright Copyright (C) 2010 Maciej Błaszkowski (Marooned), Wikia, Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
* @todo: display global rights in Listusers
*
*/

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SharedUserrights.\n";
	exit(1) ;
}

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'SharedUserrights',
	'author' => array(
		'Lucas \'TOR\' Garczewski <tor@wikia.com>',
		'Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>'
	),
	'descriptionmsg' => 'shareduserrights-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SharedUserrights',
);

//i18n
$wgExtensionMessagesFiles['SharedUserrights'] = __DIR__ . '/SharedUserrights.i18n.php';

if (!empty($wgSharedDB)) {
	$wgHooks['UserEffectiveGroups'][] = 'UserRights::userEffectiveGroups';
	$wgHooks['UserRights::groupCheckboxes'][] = 'UserRights::groupCheckboxes';
	$wgHooks['UserRights::showEditUserGroupsForm'][] = 'UserRights::showEditUserGroupsForm';
	$wgHooks['UserAddGroup'][] = 'UserRights::addGlobalGroup';
	$wgHooks['UserRemoveGroup'][] = 'UserRights::removeGlobalGroup';
	$wgHooks['UserLoadGroups'][] = 'UserRights::onUserLoadGroups';
	$wgAutoloadClasses['UserRights'] = "$IP/extensions/wikia/SharedUserrights/SharedUserrights.class.php";
}

$wgExtensionCredits['other'][] = array(
	'name' => 'Shared UserRights' ,
	'author' => array("[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]", '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'description' => 'Easy global user rights administration'
);
