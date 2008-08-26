<?php

/**
 * SiteWideMessages
 *
 * A SiteWideMessages extension for MediaWiki
 * Provides an interface for sending messages seen on all wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-01-09
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/SiteWideMessages/SpecialSiteWideMessages.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'sitewidemessages'			=> 'Site wide messages',	//the name displayed on Special:SpecialPages
		'swm-page-title-editor'		=> 'Site wide messages :: Editor',
		'swm-page-title-preview'	=> 'Site wide messages :: Preview',
		'swm-page-title-send'		=> 'Site wide messages :: Send',
		'swm-page-title-sent'		=> 'Site wide messages :: Sent',
		'swm-page-title-dismiss'	=> 'Site wide messages :: Dismiss',
		'swm-page-title-list'		=> 'Site wide messages :: List',
		'swm-label-preview'			=> 'Preview',
		'swm-label-edit'			=> 'Edit',
		'swm-label-remove'			=> 'Remove',
		'swm-label-sent'			=> 'Sent',
		'swm-label-list'			=> 'List',
		'swm-label-recipient'		=> 'Recipient',
		'swm-label-expiration'		=> 'Expiration time',
		'swm-label-mode-all'		=> 'All users',
		'swm-label-mode-user'		=> 'Selected user',
		'swm-label-mode-wiki'		=> 'Active users on wiki',
		'swm-label-mode-hub'		=> 'Active users on hub',
		'swm-label-mode-hub-hint'	=> '<i>Note that all options below are more time consuming and will be queued in TaskManager.</i>',
		'swm-label-mode-group'		=> 'Users belonging to the group',
		'swm-label-mode-group-hint'	=> '<i>Pick a group from drop down or write name by hand to overwrite drop down selection.</i>',
		'swm-label-content'			=> 'Content',
		'swm-label-comment'			=> 'Comment',
		'swm-label-dismissed'		=> 'Dismissed',
		'swm-button-preview'		=> '[ Preview ]',
		'swm-button-send'			=> '[ Send ]',
		'swm-button-save'			=> '[ Save ]',
		'swm-button-new'			=> '[ New ]',
		'swm-msg-sent-ok'			=> '<h3>The message has been sent.</h3>',
		'swm-msg-sent-err'			=> '<h3>The message has NOT been sent.</h3>See error log for more informations.',
		'swm-msg-remove'			=> 'Are you sure you want to remove this message? This can not be undone!',
		'swm-days'					=> 'never,hour,hours,day,days',	//[0] => never expire, [1] => 1 hour, [2] => 2 hours and more, [3] => 1 day, [4] => 2 days and more
		'swm-expire-options'		=> '0,1h,6h,12h,1,3,7,14,30,60',	//0 = never
		'swm-expire-info'			=> 'This message will expire on $1.',
		'swm-link-dismiss'			=> 'dismiss this message',
		'swm-dismiss-content'		=> '<p>The message was dismissed.</p><p>%s</p>',
		'swm-list-no-messages'		=> 'No messages.',
		'swm-list-table-id'			=> 'ID',
		'swm-list-table-sender'		=> 'Sender',
		'swm-list-table-wiki'		=> 'Wiki',
		'swm-list-table-recipient'	=> 'Recipient',
		'swm-list-table-group'		=> 'Group',
		'swm-list-table-expire'		=> 'Expire',
		'swm-list-table-date'		=> 'Send date',
		'swm-list-table-removed'	=> 'Removed',
		'swm-list-table-content'	=> 'Content',
		'swm-list-table-tools'		=> 'Tools',
		'swm-yes'					=> 'Yes',
		'swm-no'					=> 'No',
		'swm-error-no-such-wiki'	=> 'There is no such wiki!',
		'swm-error-no-such-user'	=> "Specified user doesn't exist.",
		'swm-error-empty-message'	=> 'Enter the content of the message.',
		'swm-error-empty-group'		=> 'Enter the name of the group.'
	)
);
?>