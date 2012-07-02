<?php
/**
 * Messages for SemanticNotifyMe extension.
 *
 * @file
 */

$messages = array();

/**
 * English
 */
$messages['en'] = array(
	'notifyme' => 'Notify Me',
	'smw_notifyme' => 'Notify Me',

	'smw_qi_addNotify' => 'Notify me',
	'smw_qi_tt_addNotify' => 'Notify me when article-updates meet query condition',
	'smw_nm_tt_query' => 'Add #ask query to Notify Me',
	'smw_nm_tt_qtext' => 'Support query in {{#ask syntax',
	'smw_nm_tt_nmm' => 'Notify Me Manager enable you to control your notifications',
	'smw_nm_tt_clipboard' => 'Copies your RSS Feed URL to the clipboard so it can easily be inserted into any RSS reader',

	'smw_nm_proc_pagenotexist' => 'The category / instance / property page in query may not exists.',
	'smw_nm_proc_subqueryhint' => 'The query contains subquery, which may affect the precision of notifications.',
	'smw_nm_proc_enablehint' => 'You can enable the query in NotifyMe manager later.',
	'smw_nm_proc_notlogin' => 'You have not logged in yet, please log in and retry again. Thanks.',
	'smw_nm_proc_createfail' => "Notify create failed!\n\n$1\n\nPlease check the query and retry again",
	'smw_nm_proc_savefail' => 'Fail to save query. Please retry later.',
	'smw_nm_proc_nonoti' => 'No notifications available.',
	'smw_nm_proc_statesucc' => 'States updated successfully!',
	'smw_nm_proc_stateerr' => 'States updated error!',
	'smw_nm_proc_delegatesucc' => 'Delegates updated successfully!',
	'smw_nm_proc_delegateerr' => 'Delegates updated error!',
	'smw_nm_proc_reportsucc' => 'Report all updated successfully!',
	'smw_nm_proc_reporterr' => 'Report all updated error!',
	'smw_nm_proc_showsucc' => 'Show all updated successfully!',
	'smw_nm_proc_showerr' => 'Show all updated error!',
	'smw_nm_proc_delsucc' => 'Notification(s) deleted successfully!',
	'smw_nm_proc_delerr' => 'Notification(s) deleted error!',

	'smw_nm_hint_delete' => "\r\nPage $1 has been deleted.\r\nReason : $2",
	'smw_nm_hint_delete_html' => "<P>Page $1 has been deleted.<br/>Reason : <font color='red'> $2 </font></P>",
	'smw_nm_hint_notmatch_html' => "<P>Notify Me: $1 does not match this page now.</P>",
	'smw_nm_hint_change' => "\r\nSemantic attributes are changed in page $1.",
	'smw_nm_hint_change_html' => "Semantic attributes are changed in page <a href='$1'>$2</a>.<br/>",
	'smw_nm_hint_match' => "\r\nPage $1 matches NotifyMe '$2' now.",
	'smw_nm_hint_match_html' => "Page $1 matches \"<b>$2</b>\" now.<br/>",
	'smw_nm_hint_nomatch' => "\r\nPage $1 does not match NotifyMe '$2' now.",
	'smw_nm_hint_nomatch_html' => "Page $1 does not match \"<b>$2</b>\" now.<br/>",
	'smw_nm_hint_submatch' => "\r\nSub page $1 changed, $2 matches NotifyMe '$3' now.",
	'smw_nm_hint_submatch_html' => "Sub page $1 changed, $2 matches \"<b>$3</b>\" now.<br/>",
	'smw_nm_hint_subnomatch' => "\r\nSub page $1 changed, page $2 does not match NotifyMe '$3' now.",
	'smw_nm_hint_subnomatch_html' => "Sub page $1 changed, $2 does not match \"<b>$3</b>\" now.<br/>",
	'smw_nm_hint_notification_html' => '<p><b>Semantic changes from last revision:</b><br/><span style="font-size: 8pt;">$1</span></P>',
	'smw_nm_hint_nmtable_html' => "<P><table class=\"smwtable\"><tr><th>Semantic type</th><th>Name</th><th>Action</th><th>Deleted</th><th>Added</th></tr>$1</table></P>",
	'smw_nm_hint_item_html' => "<br/>All current items for \"<b>$1</b>\":<br/>$2<br/>",
	'smw_nm_hint_modifier' => "\r\nThis change is from $1.",
	'smw_nm_hint_modifier_html' => "<br/>This change is from $1.",

	'smw_nm_hint_mail_title' => '[SMW Notification] Page "$1" changed, from $2',
	'smw_nm_hint_mail_body' => "Dear Mr./Mrs. $1,\r\n$2\r\n\r\nSincerely yours,\r\nSMW NotifyMe Bot",
	'smw_nm_hint_mail_body_html' => "Dear Mr./Mrs. $1,<br/>$2<br/><br/>Sincerely yours,<br/>SMW NotifyMe Bot",

	'smw_nm_ajax_mailupdate' => 'Update NotifyMe mail setting successfully!',
	'smw_nm_ajax_fail' => 'Operation failed, please retry later.',

	'smw_nm_special_closepreview' => 'Close Preview',
	'smw_nm_special_query_title' => 'Notify Me Query',
	'smw_nm_special_manager' => 'Notify Me Manager',
	'smw_nm_special_enablemail' => 'Enable \'Notify Me\' by E-mail ',
	'smw_nm_special_emailsetting' => " (Please enable your email account in '<a href=\"$1\">$2</a>'. )",
	'smw_nm_special_feed' => 'RSS Feed',
	'smw_nm_special_nologin' => 'You have not logged in, please login first. Thanks.',
	'smw_nm_special_name' => 'Name',
	'smw_nm_special_tt_name' => 'Name of the notification',
	'smw_nm_special_report' => 'Report all',
	'smw_nm_special_tt_report' => 'Report all semantic attribes\\\' change of monitored pages',
	'smw_nm_special_show' => 'Show all',
	'smw_nm_special_tt_show' => 'Show all query results with notifications',
	'smw_nm_special_delegate' => 'Delegate',
	'smw_nm_special_tt_delegate' => 'Delegate users to recieve NotifyMe, separated by comma',
	'smw_nm_special_query' => 'Query String',
	'smw_nm_special_tt_query' => 'Full query string, with {{#ask syntax, format=table, link=all',
	'smw_nm_special_tt_preview' => 'Show full preview of your query results',
	'smw_nm_special_preview' => 'Preview Results',
	'smw_nm_special_tt_add' => 'Add this notification to you NotifyMe',
	'smw_nm_special_add' => 'Add to NotifyMe',
	'smw_nm_special_tt_reset' => 'Resets the entire query',
	'smw_nm_special_reset' => 'Reset Query',

	'smw_nm_special_tt_delete' => 'Select notifications to be deleted',
	'smw_nm_special_delete' => 'Delete?',
	'smw_nm_special_tt_enable' => 'Current state of notification. Enabled?',
	'smw_nm_special_enable' => 'Enabled?',
	'smw_nm_special_all' => 'ALL',
	'smw_nm_special_none' => 'NONE',
	'smw_nm_special_update' => 'Update',
	'smw_nm_special_tt_delupdate' => 'Delete the checked notifications',
	'smw_nm_special_tt_reportupdate' => 'Report all semantic attributes\\\' change on checked notifications',
	'smw_nm_special_tt_showupdate' => 'Show all query results on checked notifications',
	'smw_nm_special_tt_enableupdate' => 'Update the states of your notifications, enable or disable them',
	'smw_nm_special_tt_delegateupdate' => 'Update delegates',
	
	'smw_nm_special_feedtitle' => 'Track the most recent changes to $1 in this feed.',
);
