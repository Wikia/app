<?php 

$messages = array();

$messages['en'] = array( 
	'wall-no-title' => 'No title',
	'wall-tab-wall-title' => 'Message Wall:$1',
	'wall-message-loadmore' => 'View all $1 {{PLURAL:$1|reply|replies}}', 
	'wall-message-wall' => 'Message Wall',
	'wall-message-wall-shorten' => 'wall',

	'wall-message-unfollow' => 'Unfollow',

	'wall-message-undoremove' => 'Undo',
	'wall-message-edited' => '<a href="$3" >Edited by</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'My wall',
	'wall-toolbar-history' => 'History',
	
	'wall-message-notify' => 'Notify admin',
	'wall-message-remove' => 'Remove',
	'wall-message-rev-delete' => 'Revision delete',

	'wall-message-elseswall' => "$1's wall", 
	'wall-message-no-permission' => 'You don\'t have permissions to perfom this action on the message',
	
	'wall-thread-removed' => 'Removed',
	'wall-thread-deleted' => 'Deleted',

	'wall-default-title' => 'Message from $1', 
	'wall-no-title-warning' => '← You did not specify any title',
	'wall-desc' => 'User talk page replacement',
	'wall-disabled-desc' => 'Message Wall functionality for wikis without wall extension', 
	'wall-placeholder-topic' => 'What\'s this about?',
	'wall-placeholder-message' => "Post a new message to $1's wall",
	'wall-placeholder-message-anon' => "Post a new message to this wall",
	'wall-placeholder-reply' => "Post a reply",
	'wall-button-to-preview-comment' => "Preview",
	'wall-button-to-cancel-preview' => "Edit",
	'wall-button-to-submit-comment' => "Post",
	'wall-button-to-submit-reply' => "Reply",
	'wall-button-to-submit-comment-no-topic' => "Post without a title",
	'wall-button-save-changes' => 'Save changes',
	'wall-button-cancel-changes' => 'Cancel',
	'wall-button-done-source' => 'Done',
	'wall-message-edit' => "Edit",
	'wall-message-more' => 'More', 
	'wall-message-delete' => "Delete",
	'wall-message-remove' => "Remove",
	'wall-message-removed-thread-because' => "$1 removed this thread because:",
	'wall-message-deleted-thread-because' => "$1 deleted this thread because:",
	'wall-message-restore-thread' => "Restore Thread",
	'wall-message-removed-reply-because' => "$1 removed this reply because:",
	'wall-message-deleted-reply-because' => "$1 deleted this reply because:", 
	'wall-message-restore-reply' => "Restore Reply",
	'wall-delete-reason' => "User/admin action",
	'wall-user-talk-page-archive-anchor' => 'See archived talk page',
	'wall-user-talk-archive-page-title' => 'User_talk_archive', 

	'wall-action-all-confirm-cancel' => 'Cancel',
	'wall-action-all-confirm-notify' => 'Notify an admin',  

	'wall-action-remove-reply-title' => 'Remove this reply',
	'wall-action-remove-thread-title' => 'Remove this thread',

	'wall-confirm-monobook-remove' => "Please tell us why you would like to remove this. \n\nThe original post and your summary will still appear in the wiki's history.", 
	'wall-confirm-monobook-admin' => "Please tell us why you would like to delete this. \n\nThe original post and your summary will still appear in the wiki's history.", 
	'wall-confirm-monobook-restore' => "Please tell us why you would like to restore this \n",
	'wall-delete-error-title' => 'Error',
	'wall-delete-error-content' => 'Message was deleted previously and it no longer exists.',
	
	'wall-confirm-monobook-lack-of-reason' => 'Please provide a summary for removing this thread/reply.',

	'wall-action-remove-confirm' => 'Please tell us why you would like to remove this:',
	'wall-action-remove-thread-confirm-info' => "This thread and your summary will still appear in the wiki's history.",
	'wall-action-remove-reply-confirm-info' => "This reply and your summary will still appear in the wiki's history.",	
	'wall-action-remove-confirm-ok' => 'Remove',
	
	'wall-action-admin-thread-title' => 'Delete this thread',
	'wall-action-admin-reply-title' => 'Delete this reply',

	'wall-action-admin-confirm' => 'Please tell us why you would like to delete this:',
	'wall-action-admin-thread-confirm-info' => "This thread and your summary will still appear in the wiki's history", // identical to 'wall-action-remove-thread above, why the duplicate?
	'wall-action-admin-reply-confirm-info' => "This thread and your summary will still appear in the wiki's history. Only admins will be able to view this thread.",

	'wall-action-admin-confirm-ok' => 'Delete',

	'wall-action-restore-thread-title' => 'Restore this thread',
	'wall-action-restore-reply-title' => 'Restore this reply',

	'wall-action-restore-confirm' => 'Please tell us why you would like to restore this:',
	'wall-action-restore-confirm-ok' => 'Restore',
	
	'wall-action-rev-thread-title' => 'Revision delete this thread?',
	'wall-action-rev-reply-title' => 'Revision delete this reply?',

	'wall-action-rev-reply-confirm' => 'Are you sure you want to delete this message?',
	'wall-action-rev-thread-confirm' => 'Are you sure you want to revision delete this thread and all of its history from the wiki? This cannot be undone.',
	'wall-action-rev-confirm-ok' => 'Yes, Delete',
	
	'wall-notifications' => 'Notifications',
	'wall-notifications-all' => 'All Notifications',
	'wall-notifications-markasread' => 'Mark all as read',
	'wall-notifications-markasread-all-wikis' => 'All wikis',
	'wall-notifications-markasread-this-wiki' => 'This wiki',
	'wall-notifications-empty' => 'There are no notifications',
	'wall-notifications-loading' => 'Loading notifications',
	'wall-notifications-reminder' => 'You have <span>$1</span> unread {{PLURAL:$1|notification|notifications}}',
	'wall-notifications-wall-disabled' => 'Message Wall has been disabled on this Wiki. Unable to load notifications.',
	
	'wn-user1-reply-you-your-wall' => '$1 replied to your message on your wall', 
	'wn-user2-reply-you-your-wall' => '$1 and $2 replied to your message on your wall', 
	'wn-user3-reply-you-your-wall' => '$1 and others replied to your message on your wall', 
	'wn-user1-reply-self-your-wall' => '$1 replied to a message on your wall', 
	'wn-user2-reply-self-your-wall' => '$1 and $2 replied to a message on your wall',
	'wn-user3-reply-self-your-wall' => '$1 and others replied to a message on your wall',
	'wn-user1-reply-other-your-wall' => '$1 replied to $2\'s message on your wall',
	'wn-user2-reply-other-your-wall' => '$1 and $2 replied to $3\'s message on your wall',
	'wn-user3-reply-other-your-wall' => '$1 and others replied to $2\'s message on your wall',
	'wn-user1-reply-you-other-wall' => '$1 replied to your message on $2\'s wall', 
	'wn-user2-reply-you-other-wall' => '$1 and $2 replied to your message on $3\'s wall',
	'wn-user3-reply-you-other-wall' => '$1 and others replied to your message on $3\'s wall',
	'wn-user1-reply-self-other-wall' => '$1 replied to a message on $2\'s wall', 
	'wn-user2-reply-self-other-wall' => '$1 and $2 replied to a message on $3\'s wall',
	'wn-user3-reply-self-other-wall' => '$1 and others replied to a message on $2\'s wall',
	'wn-user1-reply-other-other-wall' => '$1 replied to $2\'s message on $3\'s wall',
	'wn-user2-reply-other-other-wall' => '$1 and $2 replied to $3\'s message on $4\'s wall',
	'wn-user3-reply-other-other-wall' => '$1 and others replied to $2\'s message on $3\'s wall',
	'wn-user1-reply-you-a-wall' => '$1 replied to your message', 
	'wn-user2-reply-you-a-wall' => '$1 and $2 replied to your message',
	'wn-user3-reply-you-a-wall' => '$1 and others replied to your message',
	'wn-user1-reply-self-a-wall' => '$1 replied to a message', 
	'wn-user2-reply-self-a-wall' => '$1 and $2 replied to a message',
	'wn-user3-reply-self-a-wall' => '$1 and others replied to a message',
	'wn-user1-reply-other-a-wall' => '$1 replied to $2\'s message', 
	'wn-user2-reply-other-a-wall' => '$1 and $2 replied to $3\'s message',
	'wn-user3-reply-other-a-wall' => '$1 and others replied to $3\'s message',
	'wn-newmsg-onmywall' => '$1 left a new message on your wall', 
	'wn-newmsg' => 'You left a new message on $1\'s wall', 
	'wn-newmsg-on-followed-wall' => '$1 left a new message on $2\'s wall.',
	
	'wn-admin-thread-deleted' => 'Thread removed from $1\'s wall', 
	'wn-admin-reply-deleted' => 'Reply removed from thread on $1\'s wall', 
	'wn-owner-thread-deleted' => 'Thread removed from your wall', 
	'wn-owner-reply-deleted' => 'Reply removed from thread on your wall', 
	
	'wall-sorting-newest-threads' => 'Newest threads',
	'wall-sorting-oldest-threads' => 'Oldest threads',
	'wall-sorting-newest-replies' => 'Newest replies',
	'wall-sorting-most-active' => 'Most active',
	'wall-sorting-archived' => 'Archived',

	'tog-enotifwallthread' => '…someone replies to a Message Wall thread I follow',
	'tog-enotifmywall' => '…someone posts a new message on my wall',
	
	'wall-deleted-msg-pagetitle' => 'Message deleted',
	'wall-deleted-msg-text' => 'The message you are trying to reach has been deleted.',
	'wall-deleted-msg-return-to' => 'Return to $1\'s wall.',
	'wall-deleted-msg-view' => '(View/Restore)',
	
	'wall-recentchanges-article-link-new-message' => 'on <a href="$1">$2\'s wall</a>',
	'wall-recentchanges-comment-new-message' => '(new: "$1")',
	'wall-recentchanges-new-reply' => '(reply: "$1")',
	'wall-recentchanges-edit' => '(edited message)',
	
	'wall-recentchanges-wall-removed-thread' => 'removed thread "[[$1|$2]]" from [[$3|$4\'s wall]]',
	'wall-recentchanges-wall-removed-reply' => 'removed reply from "[[$1|$2]]" from [[$3|$4\'s wall]]',
	'wall-recentchanges-wall-restored-thread' => 'restored thread "[[$1|$2]]" on [[$3|$4\'s wall]]',
	'wall-recentchanges-wall-restored-reply' => 'restored reply on "[[$1|$2]]" on [[$3|$4\'s wall]]',
	'wall-recentchanges-wall-deleted-thread' => 'deleted thread "[[$1|$2]]" from [[$3|$4\'s wall]]',
	'wall-recentchanges-wall-deleted-reply' => 'deleted reply from "[[$1|$2]]" from [[$3|$4\'s wall]]',

	'wall-recentchanges-deleted-reply-title' => 'A reply on message wall',
	'wall-recentchanges-namespace-selector-message-wall' => 'Message Wall',
	'wall-recentchanges-wall-group' => '$1 on <a href="$2">$3\'s wall</a>',
	'wall-recentchanges-wall-history-link' => 'wall history',
	'wall-recentchanges-thread-history-link' => 'thread history',
	
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> on <a href="$3">$4\'s wall</a>',
	
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> on <a href="$3">$4\'s wall</a>',
	
	'wall-message-not-found' => 'This message could not be found. If you see this error, please contact Wikia at [[Special:Contact]] and provide as much detail as possible about how this bug can be reproduced. Thank you!',

	'wall-message-staff-text' => 'This user is a member of Wikia staff',

	'wall-ipballowusertalk' => "Allow this user to post on their own Message Wall while blocked", 
	'wall-ipbwatchuser' => "Watch this user's profile and follow their Message Wall",
	
	/* Wall WikiActivity */
	'wall-wiki-activity-on' => 'on $1',
	'wall-wiki-activity-wall-owner' => '$1\'s wall',
	
	/* Wall removed msg */
	'wall-removed-thread-undo' => 'This thread has been removed. $1',
	'wall-removed-reply-undo' => 'This reply has been removed. $1',
	'wall-removed-reply' => 'This reply has been removed',

	'wall-deleted-thread-undo' => 'This thread has been deleted. $1',
	'wall-deleted-reply-undo' => 'This reply has been deleted. $1',
	'wall-deleted-reply' => 'This reply has been deleted',

	/* Wall Level History */
	'wall-history' => 'History',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	
	'wall-history-title' => 'wall history',
	'wall-history-who-involved-wall-title' => "Who's involved on this wall?",
	'wall-history-who-involved-thread-title' => "Who's involved in this thread?",
	'wall-history-thread-created' => '$1 created by $2',
	'wall-history-thread-removed' => '$1 removed by $2',
	'wall-history-thread-restored' => '$1 restored by $2',
	'wall-history-thread-admin-deleted' => '$1 deleted by $2',
	'wall-history-sorting-newest-first' => 'Newest first',
	'wall-history-sorting-oldest-first' => 'Oldest first',
	
	'wall-history-summary-label' => 'Summary',
	
	'wall-history-rail-wall' => 'wall',
	'wall-history-rail-contribs' => 'contribs',
	'wall-history-rail-block' => 'block',
	
	'wall-history-action-view' => 'view',
	'wall-history-action-restore' => 'restore',
	'wall-history-action-thread-history' => 'thread history',
	
	/* Thread Level History */
	'wall-thread-history-title' => 'thread history',
	'wall-thread-history-thread-created' => '$1 $2 created this thread', 
	'wall-thread-history-reply-created' => '$1 $2 left a reply',

	'wall-thread-history-thread-removed' => '$1 $2 removed this thread',
	'wall-thread-history-reply-removed' => "$1 $2 removed $3's reply $5",
	'wall-thread-history-thread-restored' => '$1 $2 restored this thread',
	'wall-thread-history-reply-restored' => "$1 $2 restored $3's reply $5",
	'wall-thread-history-thread-deleted' => '$1 $2 deleted this thread',

	'wall-thread-history-thread-edited' => "$1 $2 edited $3's message $5",
	'wall-thread-history-reply-edited' => "$1 $2 edited $3's message $5",

	'wall-history-action-restore-reply' => 'restore reply',
	'wall-history-action-restore-thread' => 'restore thread',

	'wall-message-not-found-in-db' => 'We could not find this wall message in our database, sorry.',
	
	/* Mail message */

	'mail-notification-new-someone' => '$AUTHOR_NAME wrote a new message on $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME left you a new message on $WIKI.',

	'mail-notification-reply-your' => '$AUTHOR_NAME replied to your message on $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME replied to a message on $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME replied to $PARENT_AUTHOR_NAME\'s message on $WIKI.',

	'mail-notification-html-greeting' => 'Hi $1,',
	'mail-notification-html-button' => 'See the conversation',

	'mail-notification-subject' => '$1 -- $2',

'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',	


	'mail-notification-html-footer-line1' => 'To check out the latest happenings on Wikia, visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Want to control which emails you receive? Go to your <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',

'mail-notification-body' => 'Hi $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

See the conversation($MESSAGE_LINK)
 
The Wikia Team

___________________________________________
* Find help and advice on Community Central: http://community.wikia.com
* Want to receive fewer messages from us? You can unsubscribe or change
your email preferences here: http://community.wikia.com/Special:Preferences',

	'mail-notification-body-HTML' => 'Hi $WATCHER,
			<p>$SUBJECT.</p> 
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p> 			
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">See the conversation</a></p>
			<p>The Wikia Team</p>
___________________________________________<br>
* Find help and advice on Community Central: http://community.wikia.com
* Want to receive fewer messages from us? You can unsubscribe or change
your email preferences here: http://community.wikia.com/Special:Preferences',
	
	/* Preferences */
	'prefs-email-wall-v2' => 'Message Wall',

	'tog-enotifwallthread-v2' => 'Email me…',
  
	'tog-enotifmywall-every' => 'For every message & reply',
	'tog-enotifmywall-sincevisited' => 'Once per thread since my last visit',
	'tog-enotifmywall-reminder' => 'With a daily reminder email', 
	'tog-enotifmywall-noemail' => 'Never. Do not send me any Message Wall emails',

	'wallshowsource-toggle-v2' => 'Enable {{int:user-action-menu-view-source}} option on Message Wall posts',
	'wallshowsource-toggle' => 'Enable {{int:user-action-menu-view-source}} on Message Wall posts',
	'walldelete-toggle' => 'Enable Revision delete on Message Wall posts',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'wall-no-title' => 'fallback wall message title for deleted message which are not accessible in archive',
	'wall-message-loadmore' => 'See all the messages in the thread. Parameters:
* $1 is the number of messages.',
	'wall-message-wall' => 'Name of the feature',
	'wall-message-wall-shorten' => "Name of the feature when it's used with a possessive, as in John's wall",
	'wall-message-unfollow' => 'stop subscribing to notifications for this thread',
	'wall-message-undoremove' => 'undo the action that you just took',
	'wall-message-edited' => 'Parameters:
* $1 is the user who edited the message
* $2 is user page URL
* $3 is a diff URL.',
	'wall-message-mywall' => 'It is display when you are on thread page which is on your owne wall',
	'wall-toolbar-history' => 'Link in the toolbar to see the history of the wall or thread',
	'wall-message-notify' => 'In the remove/delete-message modal box, checkbox for telling the admin about the removal',
	'wall-message-remove' => 'Menu item to remove a message',
	'wall-message-rev-delete' => 'Dropdown menu for staff, option to revision-delete the message',
	'wall-message-elseswall' => "Link to a user's wall. Parameters:
* $1 is the username (GENDER is supported)",
	'wall-message-no-permission' => 'Error message when a non-admin or staff tries to delete or revision-delete a message',
	'wall-thread-removed' => 'In parentheses at the top of a removed thread page, next to the title',
	'wall-thread-deleted' => 'In parentheses at the top of a deleted thread page, next to the title',
	'wall-default-title' => "Default title if the user doesn't give a new thread a title",
	'wall-no-title-warning' => 'Error message when a user tries to post a thread without a title',
	'wall-desc' => 'Extension description which shows in special version',
	'wall-disabled-desc' => 'Extension description which shows in special version (wall disabled)',
	'wall-placeholder-topic' => 'Entry field for title of a new thread',
	'wall-placeholder-message' => 'Entry field for the first message of a new thread. Parameters:
* $1 is the wall owner (GENDER is supported in this message).',
	'wall-placeholder-message-anon' => 'Entry field for the first message of a new thread, wall owner is anon',
	'wall-placeholder-reply' => 'Entry field for posting a reply to a thread',
	'wall-button-to-preview-comment' => 'Link to preview a message',
	'wall-button-to-cancel-preview' => 'Link to cancel a preview and go back to editing',
	'wall-button-to-submit-comment' => 'Button to post the first message of a new thread',
	'wall-button-to-submit-reply' => 'Button to post a reply to a thread',
	'wall-button-to-submit-comment-no-topic' => 'Button to post a new thread after getting an error message for not having a title',
	'wall-button-save-changes' => 'Button to save edits to a message',
	'wall-button-cancel-changes' => 'Button to cancel an edit to a message',
	'wall-button-done-source' => 'Button to close the source view for a message',
	'wall-message-edit' => 'Menu item to edit a message',
	'wall-message-more' => 'Top of the menu for each message',
	'wall-message-delete' => 'Menu item to delete a message',
	'wall-message-removed-thread-because' => 'Summary at the top of a removed thread page. Parameters:
* $1 is the user who removed the thread (GENDER is supported in this message).',
	'wall-message-deleted-thread-because' => 'Summary at the top of a deleted thread page. Parameters:
* $1 is the user who deleted the thread (GENDER is supported in this message).',
	'wall-message-restore-thread' => 'Button to restore a thread on a removed thread page',
	'wall-message-removed-reply-because' => 'Summary at the top of a removed reply page. Parameters:
* $1 is the user who removed the reply (GENDER is supported in this message).',
	'wall-message-deleted-reply-because' => 'Summary at the top of a deleted reply page. Parameters:
* $1 is the user who deleted the reply (GENDER is supported in this message).',
	'wall-message-restore-reply' => 'Button to restore a reply on a removed reply page',
	'wall-delete-reason' => 'default user/admin action',
	'wall-user-talk-page-archive-anchor' => "Link on a Message Wall page to the user's old talk page archive",
	'wall-user-talk-archive-page-title' => "Title on a user's talk page archive",
	'wall-action-all-confirm-cancel' => 'Button to cancel on a remove or delete message modal box',
	'wall-action-all-confirm-notify' => 'Option to notify an admin on a remove or deleted reply modal box',
	'wall-action-remove-reply-title' => 'Title of the modal box for removing a reply',
	'wall-action-remove-thread-title' => 'Title of the modal box for removing a thread',
	'wall-confirm-monobook-remove' => "Explanation of the remove modal box for Monobook users, puts extra info in because Monobook users don't see the complete modal box",
	'wall-confirm-monobook-admin' => "Explanation of the delete modal box for Monobook users, puts extra info in because Monobook users don't see the complete modal box",
	'wall-confirm-monobook-restore' => 'Asks for a summary for restoring a message or reply for Monoboo users',
	'wall-delete-error-title' => 'Title of error message for Monobook',
	'wall-delete-error-content' => 'Error message for trying to delete a message that has already been deleted',
	'wall-confirm-monobook-lack-of-reason' => 'Error message for Monobook users who try to remove a message without writing a summary',
	'wall-action-remove-confirm' => 'Asks for summary in the remove modal box',
	'wall-action-remove-thread-confirm-info' => 'Explanation in the remove modal box that the thread and summary will still appear in the history',
	'wall-action-remove-reply-confirm-info' => 'Explanation in the remove modal box that the reply and summary will still appear in the history',
	'wall-action-remove-confirm-ok' => 'Button in the remove modal box',
	'wall-action-admin-thread-title' => 'Title of the delete thread modal box',
	'wall-action-admin-reply-title' => 'Title of the delete reply modal box',
	'wall-action-admin-confirm' => 'Asks for summary in the delete modal box',
	'wall-action-admin-thread-confirm-info' => 'Explanation in the delete modal box that the thread and summary will still appear in the history',
	'wall-action-admin-reply-confirm-info' => 'Explanation in the delete modal box that the reply and summary will still appear in the history',
	'wall-action-admin-confirm-ok' => 'Button in the delete modal box',
	'wall-action-restore-thread-title' => 'Button to restore a thread',
	'wall-action-restore-reply-title' => 'Button to restore a reply',
	'wall-action-restore-confirm' => 'Asks for summary in the restore modal box',
	'wall-action-restore-confirm-ok' => 'Button in the restore modal box',
	'wall-action-rev-thread-title' => 'Title of revision delete thread modal box',
	'wall-action-rev-reply-title' => 'Title of revision delete reply moal box',
	'wall-action-rev-reply-confirm' => 'Confirmation for revision delete reply modal',
	'wall-action-rev-thread-confirm' => 'Confirmation for revision delete thread modal',
	'wall-action-rev-confirm-ok' => 'Button for confirming revision delete',
	'wall-notifications' => 'Title of notification dropdown',
	'wall-notifications-all' => 'Text in notification dropdown menu',
	'wall-notifications-markasread' => 'Option in notification dropdown menu to mark all threads as read',
	'wall-notifications-markasread-all-wikis' => 'Option to mark all cross-wiki notifications as read',
	'wall-notifications-markasread-this-wiki' => "Option to mark only this wiki's notifications as read",
	'wall-notifications-empty' => 'Message for empty notification dropdown',
	'wall-notifications-loading' => 'Message in the notification dropdown while notifications are loading',
	'wall-notifications-reminder' => 'Notification reminder that appears at the top right if user scrolls down without looking at notification dropdown, uses pluralization',
	'wall-notifications-wall-disabled' => 'It shows when the wall is turned off during loading of notification',
	'wn-user1-reply-you-your-wall' => 'Notification when someone replies on your wall. Parameters:
* $1 is a username (GENDER is supported in this message).',
	'wn-user2-reply-you-your-wall' => "Notification when 2 users reply on the logged in user's wall. Parameters:
* $1 and $2 are names of users that replied (GENDER is supported in this message).",
	'wn-user3-reply-you-your-wall' => "Notification when 3 or more users reply on the logged in user's wall. Parameters:
* $1 is the first user who replied (GENDER is supported in this message).",
	'wn-user1-reply-self-your-wall' => 'Notification when a user replies to a thread that user started. Parameters:
* $1 is a username (GENDER is supported in this message).',
	'wn-user2-reply-self-your-wall' => 'Notification when 2 users reply to a thread that one of them started. Parameters:
* $1 and $2 are names of users that replied (GENDER is supported in this message).',
	'wn-user3-reply-self-your-wall' => 'Notification when 3 or more users reply to a thread that one of them started. Parameters:
* $1 is the first user who replied (GENDER is supported in this message).',
	'wn-user1-reply-other-your-wall' => 'Notification. Parameters:
* $1 is user replying (GENDER is supported in this message).
* $2 is user who started the thread (GENDER is supported in this message).',
	'wn-user2-reply-other-your-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying
* $3 is user who started the thread.',
	'wn-user3-reply-other-your-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is first user replying, $2 is user who started the thread.',
	'wn-user1-reply-you-other-wall' => 'Notification.GENDER is supported in this message. Parameters: 
* $1 is user replying to a thread you started
* $2 is wall owner.',
	'wn-user2-reply-you-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying to a thread you started
* $3 is wall owner.',
	'wn-user3-reply-you-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is first user replying to a thread you started
* $3 is wall owner.',
	'wn-user1-reply-self-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is user replying to a thread that user started
* $2 is wall owner.',
	'wn-user2-reply-self-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying to a thread that one of them started
* $3 is wall owner.',
	'wn-user3-reply-self-other-wall' => 'Notification when 3 or more users reply to a thread that one of them started. GENDER is supported in this message. Parameters:
* $1 is first user who replied
* $2 is wall owner.',
	'wn-user1-reply-other-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is user replying
* $2 is user who started the thread
* $3 is wall owner.',
	'wn-user2-reply-other-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying
* $3 is user who started the thread
* $4 is wall owner.',
	'wn-user3-reply-other-other-wall' => 'Notification when 3 or more users reply to a thread, $1 is first user who replied, $2 is user who started the thread, $3 is wall owner(you can use GENDER in this message)',
	'wn-user1-reply-you-a-wall' => 'Notification, $1 is user who replied to a thread you started(you can use GENDER in this message)',
	'wn-user2-reply-you-a-wall' => 'Notification, $1 and $2 are users who replied to a thread you started(you can use GENDER in this message)',
	'wn-user3-reply-you-a-wall' => 'Notification when 3 or more users reply to a thread you started, $1 is first user who replied(you can use GENDER in this message)',
	'wn-user1-reply-self-a-wall' => 'Notification, $1 is user who replied to a message that that user started on his or her own wall(you can use GENDER in this message)',
	'wn-user2-reply-self-a-wall' => 'Notification, $1 and $2 are users who replied to a message that one of them started on his or her own wall(you can use GENDER in this message)',
	'wn-user3-reply-self-a-wall' => 'Notification when 3 or more users reply to a thread that one of them started on his or her own wall, $1 is first user who replied(you can use GENDER in this message)',
	'wn-user1-reply-other-a-wall' => 'Notification when wall owner is one of the users involved. Parameters:
* $1 is user who replied
* $2 started the thread(you can use GENDER in this message)',
	'wn-user2-reply-other-a-wall' => 'Notification when wall owner is one of the users involved, $1 and $2 are users who replied, $3 started the thread(you can use GENDER in this message)',
	'wn-user3-reply-other-a-wall' => 'Notification when 3 or more users reply and wall owner is one of the users involved, $1 is first user who replied, $3 started the thread(you can use GENDER in this message)',
	'wn-newmsg-onmywall' => 'Notification, $1 started a new thread on your wall',
	'wn-newmsg' => "Notification when you follow a user's wall and start a new thread on that user's wall, $1 is wall owner",
	'wn-newmsg-on-followed-wall' => "Notification when you follow a user's wall, $1 is user who started a new thread, $2 is wall owner",
	'wn-admin-thread-deleted' => 'Admin notification of a removed thread, $1 is wall owner',
	'wn-admin-reply-deleted' => 'Admin notification of a removed reply, $1 is wall owner',
	'wn-owner-thread-deleted' => 'Notification for wall owner of removed thread',
	'wn-owner-reply-deleted' => 'Notification for wall owner of removed reply',
	'wall-sorting-newest-threads' => 'Sorting option, newest threads first',
	'wall-sorting-oldest-threads' => 'Sorting option, oldest threads first',
	'wall-sorting-newest-replies' => 'Sorting option, threads with newest replies first',
	'wall-sorting-most-active' => 'Sorting option, most active threads first (deprecated)',
	'wall-sorting-archived' => 'Sorting option, show archived threads (not built yet)',
	'tog-enotifwallthread' => "Email preference option, checkbox to receive email when there's a reply to a followed thread",
	'tog-enotifmywall' => "Email preference option, checkbox to receive email when there's a new thread on your wall",
	'wall-deleted-msg-pagetitle' => 'Confirmation that a thread has been deleted',
	'wall-deleted-msg-text' => 'Error message when a user follows a link to a deleted thread',
	'wall-deleted-msg-return-to' => "Link to return to user's wall when you try to follow a link to a deleted thread, $1 is wall owner",
	'wall-deleted-msg-view' => 'Option for admins and staff to view and restore a deleted thread',
	'wall-recentchanges-article-link-new-message' => 'Recent changes item, $2 is wall owner',
	'wall-recentchanges-comment-new-message' => 'Recent changes item, $1 is beginning of message',
	'wall-recentchanges-new-reply' => 'Recent changes item, $1 is beginning of reply',
	'wall-recentchanges-edit' => 'Recent changes item, default summary for editing a message',
	'wall-recentchanges-wall-removed-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is wall owner
* $5 is optional username and you can use it with GENDER parameter',
	'wall-recentchanges-wall-removed-reply' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is wall owner
* $5 is optional username and you can use it with GENDER parameter',
	'wall-recentchanges-wall-restored-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is wall owner
* $5 is optional username and you can use it with GENDER parameter',
	'wall-recentchanges-wall-restored-reply' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is wall owner
* $5 is optional username and you can use it with GENDER parameter',
	'wall-recentchanges-wall-deleted-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is wall owner
* $5 is optional username, you can use it with GENDER parameter',
	'wall-recentchanges-wall-deleted-reply' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is wall owner
* $5 is optional username and you can use it with GENDER parameter',
	'wall-recentchanges-deleted-reply-title' => 'fallback reply title for deleted replies  are not accessible in archive',
	'wall-recentchanges-namespace-selector-message-wall' => 'Recent changes, item in namespace dropdown',
	'wall-recentchanges-wall-group' => 'Grouped recent changes item. Parameters:
* $1 is thread title
* $3 is wall owner',
	'wall-recentchanges-wall-history-link' => 'Recent changes, link to wall history for items about removed and deleted threads',
	'wall-recentchanges-thread-history-link' => 'Recent changes, link to thread history for items about removed replies',
	'wall-contributions-wall-line' => "Contributions item. Parameters:
* $5 is timestamp
* $6 is diff link if applicable
* $7 is history link
* $8 is N if it's a new thread
* $2 is thread title
* $4 is wall owner",
	'wall-whatlinkshere-wall-line' => 'What links here item. Parameters:
* $2 is thread title
* $4 is wall owner',
	'wall-message-not-found' => "Error message if user tries to visit a thread that doesn't exist",
	'wall-message-staff-text' => 'tooltip for Wikia staff signature',
	'wall-ipballowusertalk' => 'checkbox on Special:Block',
	'wall-ipbwatchuser' => 'checkbox on Special:Block',
	'wall-wiki-activity-on' => 'Wiki Activity item. Parameters:
* $1 is wall owner',
	'wall-wiki-activity-wall-owner' => 'Wiki Activity item. Parameters:
* $1 is wall owner',
	'wall-removed-thread-undo' => 'Confirmation message after removing a thread. Parameters:
* $1 is Undo link',
	'wall-removed-reply-undo' => 'Confirmation message after removing a reply. Parameters:
* $1 is Undo link',
	'wall-removed-reply' => 'Confirmation message after removing a thread',
	'wall-deleted-thread-undo' => 'Confirmation message after deleting a thread. Parameters:
* $1 is Undo link',
	'wall-deleted-reply-undo' => 'Confirmation message after deleting a reply. Parameters:
* $1 is Undo link',
	'wall-deleted-reply' => 'Confirmation message after deleting a reply',
	'wall-history' => 'toolbar link to wall history',
	'wall-history-username-full' => 'username on wall history page. Parameters:
* $1 is preferred name
* $2 is username',
	'wall-history-username-short' => 'username on wall history page. Parameters:
* $2 is username',
	'wall-history-title' => 'heading on wall history page',
	'wall-history-who-involved-wall-title' => "heading on who's involved box on wall history page",
	'wall-history-who-involved-thread-title' => "heading on who's involved box on thread history page",
	'wall-history-thread-created' => 'wall history item. Parameters:
* $1 is thread title
* $2 is username',
	'wall-history-thread-removed' => 'wall history item. Parameters:
* $1 is thread title
* $2 is username',
	'wall-history-thread-restored' => 'wall history item. Parameters:
* $1 is thread title
* $2 is username',
	'wall-history-thread-admin-deleted' => 'wall history item. Parameters:
* $1 is thread title
* $2 is username',
	'wall-history-sorting-newest-first' => 'sorting option, view newest changes first',
	'wall-history-sorting-oldest-first' => 'sorting option, view oldest changes first',
	'wall-history-summary-label' => 'wall history page, heading for summary item',
	'wall-history-rail-wall' => "wall history page, who's involved box - link to user's wall",
	'wall-history-rail-contribs' => "wall history page, who's involved box - link to user's contributions list",
	'wall-history-rail-block' => "wall history page, who's involved box - link for admins to block user",
	'wall-history-action-view' => 'wall history page, link to view removed thread',
	'wall-history-action-restore' => 'wall history page, link to restore removed thread',
	'wall-history-action-thread-history' => 'wall history page, link to view thread history',
	'wall-thread-history-title' => 'heading on thread history page',
	'wall-thread-history-thread-created' => 'thread history page. GENDER is supported in this message. Parameters:
* $1 is thread title
* $2 is username.',
	'wall-thread-history-reply-created' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username.',
	'wall-thread-history-thread-removed' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username.',
	'wall-thread-history-reply-removed' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username
* $3 is username
* $5 is number of the reply.',
	'wall-thread-history-thread-restored' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username',
	'wall-thread-history-reply-restored' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username
* $3 is username
* $5 is number of the reply.',
	'wall-thread-history-thread-deleted' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username.',
	'wall-thread-history-thread-edited' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username
* $3 is username
* $5 is number of the reply.',
	'wall-thread-history-reply-edited' => 'thread history page item. GENDER is supported in this message. Parameters:
* $1 is preferred name
* $2 is username
* $3 is username
* $5 is number of the reply.',
	'wall-history-action-restore-reply' => 'Thread history page, link to restore reply.',
	'wall-history-action-restore-thread' => 'Thread history page, link to restore thread.',
	'wall-message-not-found-in-db' => 'Error message.',
	'mail-notification-new-someone' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-new-your' => 'Rmail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-reply-your' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-reply-his' => 'Email notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-reply-someone' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is a user name
* $PARENT_AUTHOR_NAME is user who started the thread
* $WIKI is wiki name.',
	'mail-notification-html-greeting' => 'E-mail notification greeting. Parameters:
* $1 is a username.',
	'mail-notification-html-button' => 'Email notification, button to visit the thread.',
	'mail-notification-subject' => 'Email notification title. Parameters:
* $1 is thread title
* $2 is wiki.',
	'mail-notification-html-footer-line3' => 'E-mail notification footer with links to Twitter, Facebook, YouTube and Wikia staff blog.',
	'mail-notification-html-footer-line1' => 'Email notification footer with link to Community Central.',
	'mail-notification-html-footer-line2' => 'E-mail notification footer with link to preferences.',
	'mail-notification-body' => 'E-mail notification body text.',
	'mail-notification-body-HTML' => 'E-mail notification body text with HTML.',
	'prefs-email-wall-v2' => 'Preferences header.',
	'tog-enotifwallthread-v2' => 'Preferences combobox name.',
	'tog-enotifmywall-every' => 'Preferences combobox option.',
	'tog-enotifmywall-sincevisited' => 'Preferences combobox option.',
	'tog-enotifmywall-reminder' => 'Preferences combobox option.',
	'tog-enotifmywall-noemail' => 'Preferences combobox option.',
	'wallshowsource-toggle-v2' => 'Preferences checkbox.',
	'wallshowsource-toggle' => 'Preferences checkbox.',
	'walldelete-toggle' => 'Preferences checkbox.',
);

/** Spanish (Español)
 * @author Benfutbol10
 */
$messages['es'] = array(
	'wall-tab-wall-title' => 'Muro de mensajes:$1',
	'wall-message-loadmore' => 'Ver todas las $1 respuestas',
	'wall-message-wall' => 'Muro de mensajes',
	'wall-message-wall-shorten' => 'muro',
	'wall-message-unfollow' => 'Dejar de seguir',
	'wall-message-undoremove' => 'Deshacer',
	'wall-message-edited' => '<a href="$3" >Editado por</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Mi muro',
	'wall-toolbar-history' => 'Historial',
	'wall-message-notify' => 'Notificar a un admin',
	'wall-message-remove' => 'Quitar',
	'wall-message-rev-delete' => 'Revisión borrada',
	'wall-message-elseswall' => 'muro de $1',
	'wall-thread-removed' => 'Retirado',
	'wall-thread-deleted' => 'Borrado',
	'wall-default-title' => 'Mensaje de $1',
	'wall-placeholder-reply' => 'Dejar una respuesta',
	'wall-button-to-preview-comment' => 'Previsualizar',
	'wall-button-to-cancel-preview' => 'Editar',
	'wall-button-to-submit-comment' => 'Publicar',
	'wall-button-to-submit-reply' => 'Responder',
	'wall-button-to-submit-comment-no-topic' => 'Publicar sin título',
	'wall-button-save-changes' => 'Guardar cambios',
	'wall-button-cancel-changes' => 'Cancelar',
	'wall-button-done-source' => 'Hecho',
	'wall-message-edit' => 'Editar',
	'wall-message-more' => 'Más',
	'wall-message-delete' => 'Eliminar',
	'wall-message-removed-thread-because' => '$1 retiró este tema porque:',
	'wall-message-deleted-thread-because' => '$1 eliminó este tema porque:',
	'wall-message-restore-thread' => 'Restaurar tema',
	'wall-message-removed-reply-because' => '$1 retiró esta respuesta porque:',
	'wall-message-deleted-reply-because' => '$1 eliminó esta respuesta porque:',
	'wall-message-restore-reply' => 'Restaurar respuesta',
	'wall-user-talk-archive-page-title' => 'Archivo_de_discusión',
	'wall-action-all-confirm-cancel' => 'Cancelar',
	'wall-action-all-confirm-notify' => 'Notificar a un admin',
	'wall-confirm-monobook-remove' => 'Por favor, dinos por qué quieres retirar esto.

El mensaje original y tu resumen aparecerán en el historial del wiki.',
	'wall-confirm-monobook-admin' => 'Por favor, dinos por qué quieres borrar esto.

El mensaje original y tu resumen aparecerá en el historial del wiki.',
	'wall-delete-error-title' => 'Error',
	'wall-action-remove-confirm' => 'Por favor, dinos por qué quieres retirar esto:',
	'wall-action-remove-confirm-ok' => 'Retirar',
	'wall-action-admin-thread-title' => 'Borrar este tema',
	'wall-action-admin-reply-title' => 'Borrar esta respuesta',
	'wall-action-admin-confirm' => 'Por favor, dinos por qué quieres borrar esto:',
	'wall-action-admin-confirm-ok' => 'Borrar',
	'wall-action-restore-confirm' => 'Por favor, dinos por qué quieres restaurar esto:',
	'wall-action-rev-confirm-ok' => 'Sí, bórralo',
	'wall-notifications' => 'Notificaciones',
	'wall-notifications-empty' => 'No hay notificaciones',
	'wall-notifications-loading' => 'Cargando notificaciones',
	'wall-notifications-reminder' => 'Tienes <span>$1</span> {{PLURAL:$1|notificación|notificaciones}} sin leer',
	'wn-user1-reply-you-your-wall' => '$1 respondió a tu mensaje en tu Muro',
	'wall-sorting-newest-threads' => 'Nuevos temas',
	'wall-sorting-oldest-threads' => 'Temas antiguos',
	'wall-sorting-newest-replies' => 'Nuevas respuestas',
	'wall-sorting-most-active' => 'Temas más activos',
	'wall-sorting-archived' => 'Archivado',
	'tog-enotifwallthread' => '...alguien responde a un tema que sigo.',
	'tog-enotifmywall' => '...alguien deja un nuevo mensaje en mi muro.',
	'wall-deleted-msg-pagetitle' => 'Mensaje borrado',
	'wall-deleted-msg-return-to' => 'Volver al Muro de $1.',
	'wall-recentchanges-article-link-new-message' => 'en el <a href="$1">muro de $2</a>',
	'wall-recentchanges-namespace-selector-message-wall' => 'Muro de mensajes',
	'wall-recentchanges-wall-group' => '$1 en el <a href="$2">Muro de $3</a>',
	'wall-recentchanges-wall-history-link' => 'Historial del muro',
	'wall-recentchanges-thread-history-link' => 'Historial del tema',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> en el <a href="$3">Muro de $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> en el <a href="$3">muro de $4</a>',
	'wall-message-not-found' => 'Este mensaje no pudo ser encontrado. Si ves este error, por favor, contacta con Wikia a través de [[Especial:Contactar]] y aporta todos los detalles que puedas dar sobre cómo puede reproducirse este error. ¡Gracias!',
	'wall-message-staff-text' => 'Este usuario es miembro del Staff de Wikia',
	'wall-ipballowusertalk' => 'Permitir a este usuario dejar mensajes en su propio Muro de mensajes mientras está bloqueado',
	'wall-ipbwatchuser' => 'Seguir el perfil de este usuario y seguir su Muro de mensajes',
	'wall-wiki-activity-on' => 'en $1',
	'wall-wiki-activity-wall-owner' => 'muro de $1',
	'wall-history' => 'Historial',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'Historial del muro',
	'wall-history-who-involved-wall-title' => '¿Quiénes participaron de este muro?',
	'wall-history-who-involved-thread-title' => '¿Quiénes participaron de este tema?',
	'wall-history-thread-created' => '$1 creado por $2',
	'wall-history-thread-removed' => '$1 quitado por $2',
	'wall-history-thread-restored' => '$1 restaurado por $2',
	'wall-history-thread-admin-deleted' => '$1 borrado por $2',
	'wall-history-sorting-newest-first' => 'Más nuevos primero',
	'wall-history-sorting-oldest-first' => 'Más antiguos primero',
	'wall-history-summary-label' => 'Resumen',
	'wall-history-rail-wall' => 'muro',
	'wall-history-rail-contribs' => 'contribuciones',
	'wall-history-rail-block' => 'bloquear',
	'wall-history-action-view' => 'ver',
	'wall-history-action-restore' => 'restaurar',
	'wall-history-action-thread-history' => 'historial del tema',
	'wall-thread-history-title' => 'Historial del tema',
	'mail-notification-html-greeting' => 'Hola $1,',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/es_wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia.es" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://es.wikia.com/wiki/Blog:Noticias_de_Wikia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Para comprobar las últimas novedades en Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a>',
	'mail-notification-html-footer-line2' => '¿Quieres controlar los emails que recibes? Ve a tus <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferencias</a>',
	'mail-notification-body' => 'Hola $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Ver la conversación($MESSAGE_LINK)
 
El equipo de Wikia

___________________________________________
* Encuentra la ayuda y los consejos que necesitas en la Central de Wikia en español: http://es.wikia.com
* ¿Quieres recibir menos mensajes de nosotros? Puedes cambiar tus preferencias con respecto a los emails aquí: http://es.wikia.com/wiki/Especial:Preferencias',
	'mail-notification-body-HTML' => 'Hola $WATCHER,
			<p>$SUBJECT.</p> 
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p> 			
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Ver la conversación</a></p>
			<p>El equipo de Wikia</p>
___________________________________________<br>
* Encuentra la ayuda y los consejos que necesitas en la Central de Wikia en español: http://es.wikia.com
* ¿Quieres recibir menos mensajes de nosotros? Puedes cambiar tus preferencias con respecto a los emails aquí: http://es.wikia.com/wiki/Especial:Preferencias',
	'prefs-email-wall-v2' => 'Muro de mensajes',
	'tog-enotifmywall-noemail' => 'Nunca. No mandarme ningún email sobre el Muro de mensajes',
);

/** French (Français)
 * @author Wyz
 */
$messages['fr'] = array(
	'wall-no-title' => 'Sans titre',
	'wall-tab-wall-title' => 'Mur de discussion : $1',
	'wall-message-loadmore' => 'Voir {{PLURAL:$1|une réponse|les $1 réponses}}',
	'wall-message-wall' => 'Mur de discussion',
	'wall-message-wall-shorten' => 'mur',
	'wall-message-unfollow' => 'Ne plus suivre',
	'wall-message-undoremove' => 'Annuler',
	'wall-message-edited' => '<a href="$3" >Modifié par</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Mon mur',
	'wall-toolbar-history' => 'Historique',
	'wall-message-notify' => 'Avertir les administrateurs',
	'wall-message-remove' => 'Retirer',
	'wall-message-rev-delete' => 'Supprimer les versions',
	'wall-message-elseswall' => 'mur de $1',
	'wall-message-no-permission' => 'Vous n’avez pas les droits pour réaliser cette action sur le message',
	'wall-thread-removed' => 'Retiré',
	'wall-thread-deleted' => 'Supprimé',
	'wall-default-title' => 'Message de $1',
	'wall-no-title-warning' => '← Vous n’avez indiqué aucun titre',
	'wall-desc' => 'Remplacement de la page de discussion utilisateur',
	'wall-disabled-desc' => 'Fonctionnalité Mur de discussion pour les wikis sans l’extension mur',
	'wall-placeholder-topic' => 'De quoi souhaitez-vous discuter ?',
	'wall-placeholder-message' => 'Envoyer un nouveau message sur le mur de $1',
	'wall-placeholder-message-anon' => 'Envoyer un nouveau message sur ce mur',
	'wall-placeholder-reply' => 'Envoyer une réponse',
	'wall-button-to-preview-comment' => 'Aperçu',
	'wall-button-to-cancel-preview' => 'Modifier',
	'wall-button-to-submit-comment' => 'Envoyer',
	'wall-button-to-submit-reply' => 'Répondre',
	'wall-button-to-submit-comment-no-topic' => 'Envoyer sans titre',
	'wall-button-save-changes' => 'Enregistrer les modifications',
	'wall-button-cancel-changes' => 'Annuler',
	'wall-button-done-source' => 'Terminé',
	'wall-message-edit' => 'Modifier',
	'wall-message-more' => 'Plus',
	'wall-message-delete' => 'Supprimer',
	'wall-message-removed-thread-because' => '$1 a retiré ce fil pour la raison :',
	'wall-message-deleted-thread-because' => '$1 a supprimé ce fil pour la raison :',
	'wall-message-restore-thread' => 'Restaurer le fil',
	'wall-message-removed-reply-because' => '$1 a retiré cette réponse pour la raison :',
	'wall-message-deleted-reply-because' => '$1 a supprimé cette réponse pour la raison :',
	'wall-message-restore-reply' => 'Restaurer la réponse',
	'wall-delete-reason' => 'Action admin/utilisateur',
	'wall-user-talk-page-archive-anchor' => 'Voir la page de discussion archivée',
	'wall-user-talk-archive-page-title' => 'archive_discussion_utilisateur',
	'wall-action-all-confirm-cancel' => 'Annuler',
	'wall-action-all-confirm-notify' => 'Avertir un administrateur',
	'wall-action-remove-reply-title' => 'Retirer cette réponse',
	'wall-action-remove-thread-title' => 'Retirer ce fil',
	'wall-confirm-monobook-remove' => 'Veuillez indiquer pourquoi vous voulez son retrait.

Le message original et votre résumé seront toujours visibles dans l’historique du wiki.',
	'wall-confirm-monobook-admin' => 'Veuillez indiquer pourquoi vous voulez sa suppression.

Le message original et votre résumé seront toujours visibles dans l’historique du wiki.',
	'wall-confirm-monobook-restore' => 'Veuillez indiquer pourquoi vous voulez sa restauration',
	'wall-delete-error-title' => 'Erreur',
	'wall-delete-error-content' => 'Le message a été supprimé et n’existe plus.',
	'wall-confirm-monobook-lack-of-reason' => 'Veuillez indiquer un résumé pour la suppression de ce fil/cette réponse.',
	'wall-action-remove-confirm' => 'Veuillez indiquer pourquoi vous voulez son retrait :',
	'wall-action-remove-thread-confirm-info' => 'Ce fil et votre résumé seront toujours visibles dans l’historique du wiki.',
	'wall-action-remove-reply-confirm-info' => 'Cette réponse et votre résumé seront toujours visibles dans l’historique du wiki.',
	'wall-action-remove-confirm-ok' => 'Retirer',
	'wall-action-admin-thread-title' => 'Supprimer ce fil',
	'wall-action-admin-reply-title' => 'Supprimer cette réponse',
	'wall-action-admin-confirm' => 'Veuillez indiquer pourquoi vous voulez sa suppression :',
	'wall-action-admin-thread-confirm-info' => 'Ce fil et votre résumé seront toujours visibles dans l’historique du wiki.',
	'wall-action-admin-reply-confirm-info' => 'Ce fil et votre résumé seront toujours visibles dans l’historique du wiki. Seuls les administrateurs pourront voir ce fil.',
	'wall-action-admin-confirm-ok' => 'Supprimer',
	'wall-action-restore-thread-title' => 'Restaurer ce fil',
	'wall-action-restore-reply-title' => 'Restaurer cette réponse',
	'wall-action-restore-confirm' => 'Veuillez indiquer pourquoi vous voulez sa restauration :',
	'wall-action-restore-confirm-ok' => 'Restaurer',
	'wall-action-rev-thread-title' => 'Supprimer les versions de ce fil ?',
	'wall-action-rev-reply-title' => 'Supprimer les versions de cette réponse ?',
	'wall-action-rev-reply-confirm' => 'Êtes-vous sûr(e) de vouloir supprimer ce message ?',
	'wall-action-rev-thread-confirm' => 'Êtes-vous sûr(e) de vouloir supprimer les versions de ce fil et toute son historique de ce wiki ? Ce ne peut pas être annulé.',
	'wall-action-rev-confirm-ok' => 'Oui, supprimer',
	'wall-notifications' => 'Notifications',
	'wall-notifications-all' => 'Notifications',
	'wall-notifications-markasread' => 'Marquer toutes lues',
	'wall-notifications-markasread-all-wikis' => 'Tous les wikis',
	'wall-notifications-markasread-this-wiki' => 'Ce wiki',
	'wall-notifications-empty' => 'Il n’y a pas de notifications',
	'wall-notifications-loading' => 'Chargement des notifications',
	'wall-notifications-reminder' => 'Vous avez {{PLURAL:$1|notification|notifications}} <span>$1</span> {{PLURAL:$1|non lue|non lues}}',
	'wall-notifications-wall-disabled' => 'Le Mur de discussion a été désactivé sur ce wiki. Impossible de charger les notifications.',
	'wn-user1-reply-you-your-wall' => '$1 a répondu à votre message sur votre mur',
	'wn-user2-reply-you-your-wall' => '$1 et $2 ont répondu à votre message sur votre mur',
	'wn-user3-reply-you-your-wall' => '$1, entre autres, a répondu à votre message sur votre mur',
	'wn-user1-reply-self-your-wall' => '$1 a répondu à un message sur votre mur',
	'wn-user2-reply-self-your-wall' => '$1 et $2 ont répondu à un message sur votre mur',
	'wn-user3-reply-self-your-wall' => '$1, entre autres, a répondu à un message sur votre mur',
	'wn-user1-reply-other-your-wall' => '$1 a répondu au message de $2 sur votre mur',
	'wn-user2-reply-other-your-wall' => '$1 et $2 ont répondu au message de $3 sur votre mur',
	'wn-user3-reply-other-your-wall' => '$1, entre autres, a répondu au message de $2 sur votre mur',
	'wn-user1-reply-you-other-wall' => '$1 a répondu à votre message sur le mur de $2',
	'wn-user2-reply-you-other-wall' => '$1 et $2 ont répondu à votre message sur le mur de $3',
	'wn-user3-reply-you-other-wall' => '$1, entre autres, a répondu à votre message sur le mur de $3',
	'wn-user1-reply-self-other-wall' => '$1 a répondu à un message sur le mur de $2',
	'wn-user2-reply-self-other-wall' => '$1 et $2 ont répondu à un message sur le mur de $3',
	'wn-user3-reply-self-other-wall' => '$1, entre autres, a répondu à un message sur le mur de $2',
	'wn-user1-reply-other-other-wall' => '$1 a répondu au message de $2 sur le mur de $3',
	'wn-user2-reply-other-other-wall' => '$1 et $2 ont répondu au message de $3 sur le mur de $4',
	'wn-user3-reply-other-other-wall' => '$1, entre autres, a répondu au message de $2 sur le mur de $3',
	'wn-user1-reply-you-a-wall' => '$1 a répondu à votre message',
	'wn-user2-reply-you-a-wall' => '$1 et $2 ont répondu à votre message',
	'wn-user3-reply-you-a-wall' => '$1, entre autres, a répondu à votre message',
	'wn-user1-reply-self-a-wall' => '$1 a répondu à un message',
	'wn-user2-reply-self-a-wall' => '$1 et $2 ont répondu à un message',
	'wn-user3-reply-self-a-wall' => '$1, entre autres, a répondu à un message',
	'wn-user1-reply-other-a-wall' => '$1 a répondu au message de $2',
	'wn-user2-reply-other-a-wall' => '$1 et $2 ont répondu au message de $3',
	'wn-user3-reply-other-a-wall' => '$1, entre autres, a répondu au message de $3',
	'wn-newmsg-onmywall' => '$1 a laissé un nouveau message sur votre mur',
	'wn-newmsg' => 'Vous avez laissé un nouveau message sur le mur de $1',
	'wn-newmsg-on-followed-wall' => '$1 a laissé un nouveau message sur le mur de $2',
	'wn-admin-thread-deleted' => 'Fil retiré du mur de $1',
	'wn-admin-reply-deleted' => 'Réponse retirée du fil sur le mur de $1',
	'wn-owner-thread-deleted' => 'Fil retiré de votre mur',
	'wn-owner-reply-deleted' => 'Réponse retirée du fil sur votre mur',
	'wall-sorting-newest-threads' => 'Fils du plus récent au plus ancien',
	'wall-sorting-oldest-threads' => 'Fils du plus ancien au plus récent',
	'wall-sorting-newest-replies' => 'Réponses de la plus récente à la plus ancienne',
	'wall-sorting-most-active' => 'Du plus actif au moins actif',
	'wall-sorting-archived' => 'Archivées',
	'tog-enotifwallthread' => '…quelqu’un répond à un fil de mur que je suis',
	'tog-enotifmywall' => '…quelqu’un envoie un nouveau message sur mon mur',
	'wall-deleted-msg-pagetitle' => 'Message supprimé',
	'wall-deleted-msg-text' => 'Le message que vous essayez de consulter a été effacé.',
	'wall-deleted-msg-return-to' => 'Revenir au mur de $1.',
	'wall-deleted-msg-view' => '(Visualiser/Restaurer)',
	'wall-recentchanges-article-link-new-message' => 'sur le <a href="$1">mur de $2</a>',
	'wall-recentchanges-comment-new-message' => '(nouveau : « $1 »)',
	'wall-recentchanges-new-reply' => '(réponse : « $1 »)',
	'wall-recentchanges-edit' => '(message modifié)',
	'wall-recentchanges-wall-removed-thread' => 'a retiré le fil « [[$1|$2]] » du [[$3|mur de $4]]',
	'wall-recentchanges-wall-removed-reply' => 'a retiré une réponse à « [[$1|$2]] » sur le [[$3|mur de $4]]',
	'wall-recentchanges-wall-restored-thread' => 'a restauré le fil « [[$1|$2]] » sur le [[$3|mur de $4]]',
	'wall-recentchanges-wall-restored-reply' => 'a restauré une réponse à « [[$1|$2]]» sur le [[$3|mur de $4]]',
	'wall-recentchanges-wall-deleted-thread' => 'a supprimé le fil « [[$1|$2]] » du [[$3|mur de $4]]',
	'wall-recentchanges-wall-deleted-reply' => 'a supprimé une réponse à « [[$1|$2]] » du [[$3|mur de $4]]',
	'wall-recentchanges-deleted-reply-title' => 'Une réponse sur le mur',
	'wall-recentchanges-namespace-selector-message-wall' => 'Mur de discussion',
	'wall-recentchanges-wall-group' => '« $1 » sur le <a href="$2">mur de $3</a>',
	'wall-recentchanges-wall-history-link' => 'historique du mur',
	'wall-recentchanges-thread-history-link' => 'historique du fil',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> sur le <a href="$3">mur de $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> sur le <a href="$3">mur de $4</a>',
	'wall-message-not-found' => 'Impossible de trouver ce message. Si vous voyez cette erreur, veuillez contacter Wikia via [[Special:Contact]] et donner autant de détails que possible sur comment reproduire ce bug. Merci !',
	'wall-message-staff-text' => 'Cet utilisateur est membre du staff de Wikia',
	'wall-ipballowusertalk' => 'Permettre à cet utilisateur de poster sur son Mur de discussion pendant le blocage',
	'wall-ipbwatchuser' => 'Voir le profil de cet utilisateur et suivre son Mur de discussion',
	'wall-wiki-activity-on' => 'sur $1',
	'wall-wiki-activity-wall-owner' => 'mur de $1',
	'wall-removed-thread-undo' => 'Ce fil a été retiré. $1',
	'wall-removed-reply-undo' => 'Cette réponse a été retirée. $1',
	'wall-removed-reply' => 'Cette réponse a été retirée',
	'wall-deleted-thread-undo' => 'Ce fil a été supprimé. $1',
	'wall-deleted-reply-undo' => 'Cette réponse a été supprimée. $1',
	'wall-deleted-reply' => 'Cette réponse a été supprimée',
	'wall-history' => 'Historique',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'historique du mur',
	'wall-history-who-involved-wall-title' => 'Qui a participé sur ce mur ?',
	'wall-history-who-involved-thread-title' => 'Qui a participé à ce fil ?',
	'wall-history-thread-created' => '$1 créé par $2',
	'wall-history-thread-removed' => '$1 retiré par $2',
	'wall-history-thread-restored' => '$1 restauré par $2',
	'wall-history-thread-admin-deleted' => '$1 supprimé par $2',
	'wall-history-sorting-newest-first' => 'Les plus récents en premier',
	'wall-history-sorting-oldest-first' => 'Les plus anciens en premier',
	'wall-history-summary-label' => 'Résumé',
	'wall-history-rail-wall' => 'mur',
	'wall-history-rail-contribs' => 'contributions',
	'wall-history-rail-block' => 'bloquer',
	'wall-history-action-view' => 'visualiser',
	'wall-history-action-restore' => 'restaurer',
	'wall-history-action-thread-history' => 'historique du fil',
	'wall-thread-history-title' => 'historique du fil',
	'wall-thread-history-thread-created' => '$1 $2 a créé ce fil',
	'wall-thread-history-reply-created' => '$1 $2 a laissé une réponse',
	'wall-thread-history-thread-removed' => '$1 $2 a retiré ce fil',
	'wall-thread-history-reply-removed' => '$1 $2 a retiré la réponse $5 de $3',
	'wall-thread-history-thread-restored' => '$1 $2 a restauré ce fil',
	'wall-thread-history-reply-restored' => '$1 $2 a restauré la réponse $5 de $3',
	'wall-thread-history-thread-deleted' => '$1 $2 a supprimé ce fil',
	'wall-thread-history-thread-edited' => '$1 $2 a modifié le message $5 de $3',
	'wall-thread-history-reply-edited' => '$1 $2 a modifié le message $5 de $3',
	'wall-history-action-restore-reply' => 'restaurer la réponse',
	'wall-history-action-restore-thread' => 'restaurer le fil',
	'wall-message-not-found-in-db' => 'Impossible de trouver ce message dans notre base de données, désolé.',
	'mail-notification-new-someone' => '$AUTHOR_NAME a écrit un nouveau message sur $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME vous a laissé un nouveau message sur $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME a répondu à votre message sur $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME a répondu à un message sur $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME a répondu au message de $PARENT_AUTHOR_NAME sur $WIKI.',
	'mail-notification-html-greeting' => 'Bonjour $1,',
	'mail-notification-html-button' => 'Voir la conversation',
	'mail-notification-subject' => '$1 — $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia_fr" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
<a href="http://www.facebook.com/wikia.fr" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
<a href="http://communaute.wikia.com/wiki/Blog:Actualit%C3%A9_Wikia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Pour connaître les derniers évènements sur Wikia, visitez <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vous souhaitez contrôler les courriels que vous recevez ? Allez à vos <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Préférences</a>',
	'mail-notification-body' => 'Bonjour $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
— $AUTHOR

voir la conversation($MESSAGE_LINK)
 
L’équipe Wikia

___________________________________________
* Trouvez de l’aide et des conseils sur le wiki des communautés : http://communaute.wikia.com
* Vous souhaitez recevoir moins de messages de notre part ? Vous pouvez vous désinscrire ou modifier
vos préférence de courriel ici : http://communaute.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Bonjour $WATCHER,
<p>$SUBJECT.</p> 
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>— $AUTHOR_SIGNATURE<p> 			
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Voir la conversation</a></p>
<p>L’équipe Wikia</p>
___________________________________________<br />
* Trouvez de l’aide et des conseils sur le wiki des communautés : http://communaute.wikia.com
* Vous souhaitez recevoir moins de messages de notre part ? Vous pouvez vous désinscrire ou
modifier vos préférence de courriel ici : http://communaute.wikia.com/Special:Preferences',
	'prefs-email-wall-v2' => 'Mur de discussion',
	'tog-enotifwallthread-v2' => 'M’envoyer un courriel quand…',
	'tog-enotifmywall-every' => 'Pour chaque message et réponse',
	'tog-enotifmywall-sincevisited' => 'Un par fil depuis ma dernière visite',
	'tog-enotifmywall-reminder' => 'Avec un courriel de rappel quotidien',
	'tog-enotifmywall-noemail' => 'Jamais. Ne m’envoyer aucun courriel de Mur de discussion.',
	'wallshowsource-toggle-v2' => "Activer l'option « Mode source » pour les messages du Mur de discussion",
	'wallshowsource-toggle' => 'Permettre la vue en mode source pour les messages de Mur de discussion',
	'walldelete-toggle' => 'Permettre la suppression des versions pour les messages du Mur de discussion',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wall-no-title' => 'Без наслов',
	'wall-tab-wall-title' => 'Ѕид за пораки: $1',
	'wall-message-loadmore' => 'Прикажи {{PLURAL:$1|го одговорот|ги сите $1 одговори}}',
	'wall-message-wall' => 'Ѕид за пораки',
	'wall-message-wall-shorten' => 'ѕид',
	'wall-message-unfollow' => 'Престани со следење',
	'wall-message-undoremove' => 'Врати',
	'wall-message-edited' => '<a href="$3" >Уредил:</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Мојот ѕид',
	'wall-toolbar-history' => 'Историја',
	'wall-message-notify' => 'Извести администратор',
	'wall-message-remove' => 'Отстрани',
	'wall-message-rev-delete' => 'Бришење на ревизија',
	'wall-message-elseswall' => 'ѕидот на $1',
	'wall-message-no-permission' => 'Немате дозволи за да го извршите ова дејство врз пораката',
	'wall-thread-removed' => 'Отстрането',
	'wall-thread-deleted' => 'Избришано',
	'wall-default-title' => 'Порака од $1',
	'wall-no-title-warning' => '← Не наведовте никаков наслов',
	'wall-desc' => 'Замена за корисничка страница за разговори',
	'wall-disabled-desc' => 'Функција „Ѕид за пораки“ на викијата без додаток за ѕид',
	'wall-placeholder-topic' => 'За што се работи?',
	'wall-placeholder-message' => 'Напишете нова порака на ѕидот на $1',
	'wall-placeholder-message-anon' => 'Објавете нова порака на овој ѕид',
	'wall-placeholder-reply' => 'Дајте одговор',
	'wall-button-to-preview-comment' => 'Преглед',
	'wall-button-to-cancel-preview' => 'Уреди',
	'wall-button-to-submit-comment' => 'Објави',
	'wall-button-to-submit-reply' => 'Одговори',
	'wall-button-to-submit-comment-no-topic' => 'Порака без наслов',
	'wall-button-save-changes' => 'Зачувај промени',
	'wall-button-cancel-changes' => 'Откажи',
	'wall-button-done-source' => 'Готово',
	'wall-message-edit' => 'Уреди',
	'wall-message-more' => 'Повеќе',
	'wall-message-delete' => 'Избриши',
	'wall-message-removed-thread-because' => '$1 ја отстрани нишкава бидејќи:',
	'wall-message-deleted-thread-because' => '$1 ја избриша нишкава бидејќи:',
	'wall-message-restore-thread' => 'Врати нишка',
	'wall-message-removed-reply-because' => '$1 го отстрани одговоров бидејќи:',
	'wall-message-deleted-reply-because' => '$1 го избриша одговоров бидејќи:',
	'wall-message-restore-reply' => 'Врати одговор',
	'wall-delete-reason' => 'Корисничка/администраторска дејство',
	'wall-user-talk-page-archive-anchor' => 'Погл. архивирана страница за разговор',
	'wall-user-talk-archive-page-title' => 'Архива_на_кориснички_разговори',
	'wall-action-all-confirm-cancel' => 'Откажи',
	'wall-action-all-confirm-notify' => 'Извести администратор',
	'wall-action-remove-reply-title' => 'Отстрани го одговоров',
	'wall-action-remove-thread-title' => 'Отстрани ја нишкава',
	'wall-confirm-monobook-remove' => 'Кажете ни зошто сакате да го избришете ова. 

Изворната објава и вашиот опис сепак ќе фигурираат во историјата на викито.',
	'wall-confirm-monobook-admin' => 'Кажете ни зошто сакате да го избришете ова. 

Изворната објава и вашиот опис сепак ќе фигурираат во историјата на викито.',
	'wall-confirm-monobook-restore' => 'Кажете ни зошто сакате да го вратите ова',
	'wall-delete-error-title' => 'Грешка',
	'wall-delete-error-content' => 'Пораката е претходно избришана и затоа повеќе не постои.',
	'wall-confirm-monobook-lack-of-reason' => 'Дајте опис (образложение) на отстранувањето на оваа нишка/одговор.',
	'wall-action-remove-confirm' => 'Кажете ни зошто сакате да го избришете ова:',
	'wall-action-remove-thread-confirm-info' => 'Оваа нишка и вашиот опис сепак ќе фигурираат во историјата на викито.',
	'wall-action-remove-reply-confirm-info' => 'Оваа нишка и вашиот опис сепак ќе фигурираат во историјата на викито.',
	'wall-action-remove-confirm-ok' => 'Отстрани',
	'wall-action-admin-thread-title' => 'Избриши ја нишкава',
	'wall-action-admin-reply-title' => 'Избриши го одговоров',
	'wall-action-admin-confirm' => 'Кажете ни зошто сакате да го избришете ова:',
	'wall-action-admin-thread-confirm-info' => 'Оваа нишка и вашиот опис сепак ќе фигурираат во историјата на викито.',
	'wall-action-admin-reply-confirm-info' => 'Оваа нишка и вашиот опис сепак ќе фигурираат во историјата на викито. Нишката ќе биде видлива само за администратори.',
	'wall-action-admin-confirm-ok' => 'Избриши',
	'wall-action-restore-thread-title' => 'Врати ја нишкава',
	'wall-action-restore-reply-title' => 'Врати го одговоров',
	'wall-action-restore-confirm' => 'Кажете ни зошто сакате да го вратите ова:',
	'wall-action-restore-confirm-ok' => 'Врати',
	'wall-action-rev-thread-title' => 'Да избришам ревизии на нишкава?',
	'wall-action-rev-reply-title' => 'Да избришам ревизии на одговоров?',
	'wall-action-rev-reply-confirm' => 'Дали сте сигурни дека сакате да ја избришете поракава?',
	'wall-action-rev-thread-confirm' => 'Дали сте сигурни дека сакате да го избришете ревизиите на оваа нишка со сета нејзина историја? Ова дејство е неповратно.',
	'wall-action-rev-confirm-ok' => 'Да, бриши',
	'wall-notifications' => 'Известувања',
	'wall-notifications-all' => 'Сите известувања',
	'wall-notifications-markasread' => 'Означи ги сите како прочитани',
	'wall-notifications-markasread-all-wikis' => 'Сите викија',
	'wall-notifications-markasread-this-wiki' => 'Ова вики',
	'wall-notifications-empty' => 'Нема известувања',
	'wall-notifications-loading' => 'Вчитувам известувања',
	'wall-notifications-reminder' => 'Имате <span>$1</span> {{PLURAL:$1|непрочитано известување|непрочитани известувања}}',
	'wall-notifications-wall-disabled' => 'Ѕидот за пораки е оневозможен на ова Вики. Не можам да ги вчитам известувањата.',
	'wn-user1-reply-you-your-wall' => '$1 ви одговори на пораката на вашиот ѕид',
	'wn-user2-reply-you-your-wall' => '$1 и $2 ви одговорија на пораката на вашиот ѕид',
	'wn-user3-reply-you-your-wall' => '$1 и други ви одговорија на пораката на вашиот ѕид',
	'wn-user1-reply-self-your-wall' => '$1 одговори на порака на вашиот ѕид',
	'wn-user2-reply-self-your-wall' => '$1 и $2 одговорија на порака на вашиот ѕид',
	'wn-user3-reply-self-your-wall' => '$1 и други одговорија на порака на вашиот ѕид',
	'wn-user1-reply-other-your-wall' => '$1 одговори на пораката на $2 на вашиот ѕид',
	'wn-user2-reply-other-your-wall' => '$1 и $2 одговорија на пораката на $3 на вашиот ѕид',
	'wn-user3-reply-other-your-wall' => '$1 и други одговорија на пораката на $2 на вашиот ѕид',
	'wn-user1-reply-you-other-wall' => '$1 ви одговори на пораката на ѕидот на $2',
	'wn-user2-reply-you-other-wall' => '$1 и $2 ви одговорија на пораката на ѕидот на $3',
	'wn-user3-reply-you-other-wall' => '$1 и други ви одговорија на пораката на ѕидот на $3',
	'wn-user1-reply-self-other-wall' => '$1 одговори на порака на ѕидот на $2',
	'wn-user2-reply-self-other-wall' => '$1 и $2 одговорија на порака на ѕидот на $3',
	'wn-user3-reply-self-other-wall' => '$1 и други одговорија на порака на ѕидот на $2',
	'wn-user1-reply-other-other-wall' => '$1 одговори на пораката на $2 на ѕидот на $3',
	'wn-user2-reply-other-other-wall' => '$1 и $2 одговорија на пораката на $3 на ѕидот на $4',
	'wn-user3-reply-other-other-wall' => '$1 и други одговорија на пораката на $2 на ѕидот на $3',
	'wn-user1-reply-you-a-wall' => '$1 ви одговори на пораката',
	'wn-user2-reply-you-a-wall' => '$1 и $2 ви одговорија на пораката',
	'wn-user3-reply-you-a-wall' => '$1 и други ви одговорија на пораката',
	'wn-user1-reply-self-a-wall' => '$1 одговори на порака',
	'wn-user2-reply-self-a-wall' => '$1 и $2 одговорија на порака',
	'wn-user3-reply-self-a-wall' => '$1 и други одговорија на порака',
	'wn-user1-reply-other-a-wall' => '$1 одговори на пораката на $2',
	'wn-user2-reply-other-a-wall' => '$1 и $2 одговорија на пораката на $3',
	'wn-user3-reply-other-a-wall' => '$1 и други одговорија на пораката на $3',
	'wn-newmsg-onmywall' => '$1 ви остави порака на вашиот ѕид',
	'wn-newmsg' => 'Оставивте порака на ѕидот на $1',
	'wn-newmsg-on-followed-wall' => '$1 остави нова порака на ѕидот на $2.',
	'wn-admin-thread-deleted' => 'Нишката е отстранета од ѕидот на $1',
	'wn-admin-reply-deleted' => 'Одговорот е отстранет од нишката на ѕидот на $1',
	'wn-owner-thread-deleted' => 'Нишката е отстранета од вашиот ѕид',
	'wn-owner-reply-deleted' => 'Одговорот е отстранет од нишка на вашиот ѕид',
	'wall-sorting-newest-threads' => 'Најнови нишки',
	'wall-sorting-oldest-threads' => 'Најстари нишки',
	'wall-sorting-newest-replies' => 'Најнови одговори',
	'wall-sorting-most-active' => 'Најактивни',
	'wall-sorting-archived' => 'Архивирани',
	'tog-enotifwallthread' => '…некој ќе одговори на нишка на Ѕидот што ја следам',
	'tog-enotifmywall' => '…некој ќе објави нова порака на мојот ѕид',
	'wall-deleted-msg-pagetitle' => 'Пораката е избришана',
	'wall-deleted-msg-text' => 'Пораката што сакате да ја добиете е избришана.',
	'wall-deleted-msg-return-to' => 'Назад кон ѕидот на $1.',
	'wall-deleted-msg-view' => '(Погл./Врати)',
	'wall-recentchanges-article-link-new-message' => 'на <a href="$1">ѕидот на $2</a>',
	'wall-recentchanges-comment-new-message' => '(ново: „$1“)',
	'wall-recentchanges-new-reply' => '(одговор: „$1“)',
	'wall-recentchanges-edit' => '(изменета порака)',
	'wall-recentchanges-wall-removed-thread' => 'ја отстрани нишката „[[$1|$2]]“ од [[$3|ѕидот на $4]]',
	'wall-recentchanges-wall-removed-reply' => 'отстрани одговор од „[[$1|$2]]“ на [[$3|ѕидот на $4]]',
	'wall-recentchanges-wall-restored-thread' => 'ја врати нишката „[[$1|$2]]“ на [[$3|ѕидот на $4]]',
	'wall-recentchanges-wall-restored-reply' => 'го врати одговорот „[[$1|$2]]“ на [[$3|ѕидот на $4]]',
	'wall-recentchanges-wall-deleted-thread' => 'ја избриша нишката „[[$1|$2]]“ од [[$3|ѕидот на $4]]',
	'wall-recentchanges-wall-deleted-reply' => 'избриша одговор од „[[$1|$2]]“ на [[$3|ѕидот на $4]]',
	'wall-recentchanges-deleted-reply-title' => 'Одговор на ѕидот за пораки',
	'wall-recentchanges-namespace-selector-message-wall' => 'Ѕид за пораки',
	'wall-recentchanges-wall-group' => '$1 на <a href="$2">ѕидот на $3</a>',
	'wall-recentchanges-wall-history-link' => 'историја на ѕидот',
	'wall-recentchanges-thread-history-link' => 'историја на нишката',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> на <a href="$3">ѕидот на $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> на  <a href="$3">ѕидот на $4</a>',
	'wall-message-not-found' => 'Не можев да ја пронајдам пораката. Ако ја гледате оваа грешка, обратете се на Викија на страницата [[Special:Contact]] и наведете што повеќе подробности, за да знаат како да ја повторат оваа грешка. Ви благодариме!',
	'wall-message-staff-text' => 'Овој корисник е член на персоналот на Викија',
	'wall-ipballowusertalk' => 'Дозволи му на овој корисник да објавува на својот Ѕид за пораки додека е блокиран',
	'wall-ipbwatchuser' => 'Набљудувај го профилот на корисникот и следи го неговиот Ѕид за пораки',
	'wall-wiki-activity-on' => 'на $1',
	'wall-wiki-activity-wall-owner' => 'ѕидот на $1',
	'wall-removed-thread-undo' => 'Оваа нишка е отстранета. $1',
	'wall-removed-reply-undo' => 'Овој одговор е отстранет. $1',
	'wall-removed-reply' => 'Овој одговор е отстранет',
	'wall-deleted-thread-undo' => 'Оваа нишка е избришана. $1',
	'wall-deleted-reply-undo' => 'Овој одговор е избришан. $1',
	'wall-deleted-reply' => 'Овој одговор е избришан',
	'wall-history' => 'Историја',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'историја на ѕидот',
	'wall-history-who-involved-wall-title' => 'Кој е вклучен во разговорот на ѕидов?',
	'wall-history-who-involved-thread-title' => 'Кој е вклучен во разговорот во нишкава?',
	'wall-history-thread-created' => '$1 создадено од $2',
	'wall-history-thread-removed' => '$1 отстрането од $2',
	'wall-history-thread-restored' => '$1 вратено од $2',
	'wall-history-thread-admin-deleted' => '$1 избришано од $2',
	'wall-history-sorting-newest-first' => 'Прво најновите',
	'wall-history-sorting-oldest-first' => 'Прво најстарите',
	'wall-history-summary-label' => 'Опис',
	'wall-history-rail-wall' => 'ѕид',
	'wall-history-rail-contribs' => 'придонеси',
	'wall-history-rail-block' => 'блокирај',
	'wall-history-action-view' => 'прегл.',
	'wall-history-action-restore' => 'врати',
	'wall-history-action-thread-history' => 'историја на нишката',
	'wall-thread-history-title' => 'историја на нишката',
	'wall-thread-history-thread-created' => '$1 $2 ја создаде нишкава',
	'wall-thread-history-reply-created' => '$1 $2 даде одговор',
	'wall-thread-history-thread-removed' => '$1 $2 ја отстрани нишкава',
	'wall-thread-history-reply-removed' => '$1 $2 го отстрани одговорот бр. $5 на $3',
	'wall-thread-history-thread-restored' => '$1 $2 ја врати нишкава',
	'wall-thread-history-reply-restored' => '$1 $2 го врати одговорот бр. $5 на $3',
	'wall-thread-history-thread-deleted' => '$1 $2 ја избриша нишкава',
	'wall-thread-history-thread-edited' => '$1 $2 ја измени пораката бр. $5 на $3',
	'wall-thread-history-reply-edited' => '$1 $2 ја измени пораката бр. $5 на $3',
	'wall-history-action-restore-reply' => 'врати одговор',
	'wall-history-action-restore-thread' => 'врати нишка',
	'wall-message-not-found-in-db' => 'Нажалост, не можевме да ја пронајдеме пораката во базата.',
	'mail-notification-new-someone' => '$AUTHOR_NAME напиша нова порака на $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME ви остави порака на $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME одговори на вашата порака на $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME одговори на порака на $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME одговори на пораката на $PARENT_AUTHOR_NAME на $WIKI.',
	'mail-notification-html-greeting' => 'Здраво $1,',
	'mail-notification-html-button' => 'Погледајте го разговорот',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'За да ги проследите најновите случувања на Викија, посетете ја страницата <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Сакате да одберете кои пораки да ги добивате? Појдете на вашите <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Нагодувања</a>',
	'mail-notification-body' => 'Hi $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Погледајте го разговорот($MESSAGE_LINK)
 
Екипата на Викија

___________________________________________
* Помош и совети ќе добиете на Центарот на заедницата: http://community.wikia.com
* Сакате да добивате помалку пораки од нас? Можете да се отпишете или да ги смените
нагодувањата за е-пошта на: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Здраво $WATCHER,
			<p>$SUBJECT.</p> 
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p> 			
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Погледајте го разговорот</a></p>
			<p>Екипата на Викија</p>
___________________________________________<br />
* Помош и совети ќе добиете на Центарот на заедницата: http://community.wikia.com
* Сакате да добивате помалку пораки од нас? Можете да се отпишете или да ги смените
нагодувањата за е-пошта на: http://community.wikia.com/Special:Preferences',
	'prefs-email-wall-v2' => 'Ѕид за пораки',
	'tog-enotifwallthread-v2' => 'Испраќај ми е-пошта…',
	'tog-enotifmywall-every' => 'За секоја порака и одговор',
	'tog-enotifmywall-sincevisited' => 'Еднаш на секоја нишка појавена од мојата последна посета',
	'tog-enotifmywall-reminder' => 'Со потсетник еднаш дневно',
	'tog-enotifmywall-noemail' => 'Никогаш. Не ми испраќај е-пошта за пораки на Ѕидот',
	'wallshowsource-toggle-v2' => 'Овозможи ја можноста {{int:user-action-menu-view-source}} на објавите на Ѕидот за пораки',
	'wallshowsource-toggle' => 'Овозможи {{int:user-action-menu-view-source}} на пораките на Ѕидот за пораки',
	'walldelete-toggle' => 'Овозможи бришење на ревизии на објави на Ѕидот за пораки',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wall-no-title' => 'Tiada tajuk',
	'wall-tab-wall-title' => 'Papan Pesanan:$1',
	'wall-message-loadmore' => 'Lihat kesemua $1 balasan',
	'wall-message-wall' => 'Papan Pesanan',
	'wall-message-wall-shorten' => 'papan',
	'wall-message-unfollow' => 'Berhenti mengikut',
	'wall-message-undoremove' => 'Nyahbuat',
	'wall-message-edited' => '<a href="$3" >Disunting oleh</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Papanku',
	'wall-toolbar-history' => 'Sejarah',
	'wall-message-notify' => 'Beritahu pentadbir',
	'wall-message-remove' => 'Buang',
	'wall-message-rev-delete' => 'Hapuskan semakan',
	'wall-message-elseswall' => 'Papan $1',
	'wall-message-no-permission' => 'Anda tidak diberi izin untuk melakukan tindakan ini pada pesanan ini',
	'wall-thread-removed' => 'Dibuang',
	'wall-thread-deleted' => 'Dihapuskan',
	'wall-default-title' => 'Pesanan dari $1',
	'wall-no-title-warning' => '← Anda tidak memberikan sebarang tajuk',
	'wall-desc' => 'Ganti laman perbincangan pengguna',
	'wall-disabled-desc' => 'Kefungsian Papan Pesanan untuk wiki tanpa sambungan papan',
	'wall-placeholder-topic' => 'Ini pasal apa?',
	'wall-placeholder-message' => 'Poskan pesanan baru pada papan $1',
	'wall-placeholder-message-anon' => 'Poskan pesanan baru pada papan ini',
	'wall-placeholder-reply' => 'Balas',
	'wall-button-to-preview-comment' => 'Pralihat',
	'wall-button-to-cancel-preview' => 'Sunting',
	'wall-button-to-submit-comment' => 'Poskan',
	'wall-button-to-submit-reply' => 'Balas',
	'wall-button-to-submit-comment-no-topic' => 'Poskan tanpa tajuk',
	'wall-button-save-changes' => 'Simpan perubahan',
	'wall-button-cancel-changes' => 'Batalkan',
	'wall-button-done-source' => 'Siap',
	'wall-message-edit' => 'Sunting',
	'wall-message-more' => 'Lagi',
	'wall-message-delete' => 'Hapuskan',
	'wall-message-removed-thread-because' => '$1 membuang tred ini kerana:',
	'wall-message-deleted-thread-because' => '$1 menghapuskan tred ini kerana:',
	'wall-message-restore-thread' => 'Pulihkan Tred',
	'wall-message-removed-reply-because' => '$1 membuang balasan ini kerana:',
	'wall-message-deleted-reply-because' => '$1 menghapuskan balasan ini kerana:',
	'wall-message-restore-reply' => 'Pulihkan Balasan',
	'wall-delete-reason' => 'Tindakan pengguna/pentadbir',
	'wall-user-talk-page-archive-anchor' => 'Lihat arkib laman perbincangan',
	'wall-user-talk-archive-page-title' => 'Arkib_perbincangan_pengguna',
	'wall-action-all-confirm-cancel' => 'Batalkan',
	'wall-action-all-confirm-notify' => 'Beritahu pentadbir',
	'wall-action-remove-reply-title' => 'Buang balasan ini',
	'wall-action-remove-thread-title' => 'Buang tred ini',
	'wall-confirm-monobook-remove' => 'Sila terangkan sebab anda ingin membuangnya. 

Pos yang asal dan ringkasan anda akan kekal dalam sejarah wiki.',
	'wall-confirm-monobook-admin' => 'Sila terangkan sebab anda ingin menghapuskannya. 

Pos yang asal dan ringkasan anda akan kekal dalam sejarah wiki.',
	'wall-confirm-monobook-restore' => 'Sila terangkan sebab anda ingin memulihkannya',
	'wall-delete-error-title' => 'Ralat',
	'wall-delete-error-content' => 'Pesanan ini tidak wujud lagi kerana dihapuskan dahulu.',
	'wall-confirm-monobook-lack-of-reason' => 'Sila berikan ringkasan sebab menggugurkan tred/balasan ini.',
	'wall-action-remove-confirm' => 'Sila terangkan sebab anda ingin membuangnya:',
	'wall-action-remove-thread-confirm-info' => 'Tred ini dan ringkasan anda akan kekal dalam sejarah wiki.',
	'wall-action-remove-reply-confirm-info' => 'Balasan ini dan ringkasan anda akan kekal dalam sejarah wiki.',
	'wall-action-remove-confirm-ok' => 'Buang',
	'wall-action-admin-thread-title' => 'Hapuskan tred ini',
	'wall-action-admin-reply-title' => 'Hapuskan balasan ini',
	'wall-action-admin-confirm' => 'Sila terangkan sebab anda ingin menghapuskannya:',
	'wall-action-admin-thread-confirm-info' => 'Tred ini dan ringkasan anda akan kekal dalam sejarah wiki',
	'wall-action-admin-reply-confirm-info' => 'Tred ini dan ringkasan anda akan kekal dalam sejarah wiki. Hanya para pentadbir yang boleh melihat tred ini.',
	'wall-action-admin-confirm-ok' => 'Hapuskan',
	'wall-action-restore-thread-title' => 'Pulihkan tred ini',
	'wall-action-restore-reply-title' => 'Pulihkan balasan ini',
	'wall-action-restore-confirm' => 'Sila terangkan sebab anda ingin memulihkannya:',
	'wall-action-restore-confirm-ok' => 'Pulihkan',
	'wall-action-rev-thread-title' => 'Hapuskan semakan tred ini?',
	'wall-action-rev-reply-title' => 'Hapuskan semakan balasan ini?',
	'wall-action-rev-reply-confirm' => 'Adakah anda benar-benar ingin menghapuskan pesanan ini?',
	'wall-action-rev-thread-confirm' => 'Adakah anda benar-benar ingin menghapuskan semakan pada tred ini dan segala sejarahnya dari wiki ini? Selepas dihapuskan, ia tidak boleh dipulihkan.',
	'wall-action-rev-confirm-ok' => 'Ya, Hapuskan',
	'wall-notifications' => 'Pemberitahuan',
	'wall-notifications-all' => 'Semua Pemberitahuan',
	'wall-notifications-markasread' => 'Tanda semua sebagai sudah dibaca',
	'wall-notifications-markasread-all-wikis' => 'Semua wiki',
	'wall-notifications-markasread-this-wiki' => 'Wiki ini',
	'wall-notifications-empty' => 'Tiada pemberitahuan',
	'wall-notifications-loading' => 'Pemberitahuan sedang dimuatkan',
	'wall-notifications-reminder' => 'Anda mempunyai <span>$1</span> pemberitahuan yang belum dibaca',
	'wall-notifications-wall-disabled' => 'Papan Pesanan telah dimatikan di Wiki ini. Pemberitahuan tidak dapat dimuatkan.',
	'wn-user1-reply-you-your-wall' => '$1 membalas pesanan anda di papan anda',
	'wn-user2-reply-you-your-wall' => '$1 dan $2 membalas pesanan anda di papan anda',
	'wn-user3-reply-you-your-wall' => '$1 dan lain-lain membalas pesanan anda di papan anda',
	'wn-user1-reply-self-your-wall' => '$1 membalas pesanan di papan anda',
	'wn-user2-reply-self-your-wall' => '$1 dan $2 membalas pesanan di papan anda',
	'wn-user3-reply-self-your-wall' => '$1 dan lain-lain membalas pesanan di papan anda',
	'wn-user1-reply-other-your-wall' => '$1 membalas pesanan $2 di papan anda',
	'wn-user2-reply-other-your-wall' => '$1 dan $2 membalas pesanan $3 di papan anda',
	'wn-user3-reply-other-your-wall' => '$1 dan lain-lain membalas pesanan $2 di papan anda',
	'wn-user1-reply-you-other-wall' => '$1 membalas pesanan anda di papan $2',
	'wn-user2-reply-you-other-wall' => '$1 dan $2 membalas pesanan anda di papan $3',
	'wn-user3-reply-you-other-wall' => '$1 dan lain-lain membalas pesanan anda di papan $3',
	'wn-user1-reply-self-other-wall' => '$1 membalas pesanan di papan $2',
	'wn-user2-reply-self-other-wall' => '$1 dan $2 membalas pesanan di papan $3',
	'wn-user3-reply-self-other-wall' => '$1 dan lain-lain membalas pesanan di papan $2',
	'wn-user1-reply-other-other-wall' => '$1 membalas pesanan $2 di papan $3',
	'wn-user2-reply-other-other-wall' => '$1 dan $2 membalas pesanan $3 di papan $4',
	'wn-user3-reply-other-other-wall' => '$1 dan lain-lain membalas pesanan $2 di papan $3',
	'wn-user1-reply-you-a-wall' => '$1 membalas pesanan anda',
	'wn-user2-reply-you-a-wall' => '$1 dan $2 membalas pesanan anda',
	'wn-user3-reply-you-a-wall' => '$1 dan lain-lain membalas pesanan anda',
	'wn-user1-reply-self-a-wall' => '$1 membalas suatu pesanan',
	'wn-user2-reply-self-a-wall' => '$1 dan $2 membalas suatu pesanan',
	'wn-user3-reply-self-a-wall' => '$1 dan lain-lain membalas suatu pesanan',
	'wn-user1-reply-other-a-wall' => '$1 membalas pesanan $2',
	'wn-user2-reply-other-a-wall' => '$1 dan $2 membalas pesanan $3',
	'wn-user3-reply-other-a-wall' => '$1 dan lain-lain membalas pesanan $3',
	'wn-newmsg-onmywall' => '$1 meninggalkan pesanan baru di papan anda',
	'wn-newmsg' => 'Anda meninggalkan pesanan baru di papan $1',
	'wn-newmsg-on-followed-wall' => '$1 meninggalkan pesanan baru di papan $2.',
	'wn-admin-thread-deleted' => 'Tred dibuang dari papan $1',
	'wn-admin-reply-deleted' => 'Balasan dibuang dari tred di papan $1',
	'wn-owner-thread-deleted' => 'Tred dibuang dari papan anda',
	'wn-owner-reply-deleted' => 'Balasan dibuang dari tred di papan anda',
	'wall-sorting-newest-threads' => 'Tred terbaru',
	'wall-sorting-oldest-threads' => 'Tred terlama',
	'wall-sorting-newest-replies' => 'Balasan terbaru',
	'wall-sorting-most-active' => 'Paling aktif',
	'wall-sorting-archived' => 'Dalam arkib',
	'tog-enotifwallthread' => '…seseorang membalas tred Papan Pesanan yang saya ikuti',
	'tog-enotifmywall' => '…seseorang mengeposkan pesanan baru di papan saya',
	'wall-deleted-msg-pagetitle' => 'Pesanan dihapuskan',
	'wall-deleted-msg-text' => 'Pesanan yang anda cuba capai itu telah dihapuskan.',
	'wall-deleted-msg-return-to' => 'Kembali ke papan $1.',
	'wall-deleted-msg-view' => '(Lihat/Pulihkan)',
	'wall-recentchanges-article-link-new-message' => 'di <a href="$1">papan $2</a>',
	'wall-recentchanges-comment-new-message' => '(baru: "$1")',
	'wall-recentchanges-new-reply' => '(balasan: "$1")',
	'wall-recentchanges-edit' => '(pesanan tersunting)',
	'wall-recentchanges-wall-removed-thread' => 'membuang tred "[[$1|$2]]" dari [[$3|papan $4]]',
	'wall-recentchanges-wall-removed-reply' => 'membuang balasan "[[$1|$2]]" dari [[$3|papan $4]]',
	'wall-recentchanges-wall-restored-thread' => 'memulihkan tred "[[$1|$2]]" pada [[$3|papan $4]]',
	'wall-recentchanges-wall-restored-reply' => 'memulihkan balasan "[[$1|$2]]" pada [[$3|papan $4]]',
	'wall-recentchanges-wall-deleted-thread' => 'menghapuskan tred "[[$1|$2]]" dari [[$3|papan $4]]',
	'wall-recentchanges-wall-deleted-reply' => 'menghapuskan balasan "[[$1|$2]]" dari [[$3|papan $4]]',
	'wall-recentchanges-deleted-reply-title' => 'Satu balasan di papan pesanan',
	'wall-recentchanges-namespace-selector-message-wall' => 'Papan Pesanan',
	'wall-recentchanges-wall-group' => '$1 di <a href="$2">papan $3</a>',
	'wall-recentchanges-wall-history-link' => 'sejarah papan',
	'wall-recentchanges-thread-history-link' => 'sejarah tred',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> pada <a href="$3">papan $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> di <a href="$3">papan $4</a>',
	'wall-message-not-found' => 'Pesanan ini tidak dapat dijumpai. Jika anda melihat ralat ini, sila hubungi Wikia di [[Special:Contact]] dan terangkan dengan cukup terperinci tentang bagaimana pepijat ini boleh dihasilkan semula.',
	'wall-message-staff-text' => 'Pengguna ini ialah seorang ahli kakitangan Wikia',
	'wall-ipballowusertalk' => 'Benarkan pengguna ini untuk mengepos di Papan Pesanan sendiri ketika disekat',
	'wall-ipbwatchuser' => 'Pantau profil pengguna ini dan ikuti Papan Pesanannya',
	'wall-wiki-activity-on' => 'di $1',
	'wall-wiki-activity-wall-owner' => 'papan $1',
	'wall-removed-thread-undo' => 'Tred ini telah dibuang. $1',
	'wall-removed-reply-undo' => 'Balasan ini telah dibuang. $1',
	'wall-removed-reply' => 'Balasan ini telah dibuang.',
	'wall-deleted-thread-undo' => 'Tred ini telah dihapuskan. $1',
	'wall-deleted-reply-undo' => 'Tred ini telah dihapuskan. $1',
	'wall-deleted-reply' => 'Balasan ini telah dihapuskan',
	'wall-history' => 'Sejarah',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'sejarah papan',
	'wall-history-who-involved-wall-title' => 'Siapa yang terlibat di papan ini?',
	'wall-history-who-involved-thread-title' => 'Siapa yang terlibat di tred ini?',
	'wall-history-thread-created' => '$1 dibuat oleh $2',
	'wall-history-thread-removed' => '$1 dibuang oleh $2',
	'wall-history-thread-restored' => '$1 dipulihkan oleh $2',
	'wall-history-thread-admin-deleted' => '$1 dihapuskan oleh $2',
	'wall-history-sorting-newest-first' => 'Terbaru dahulu',
	'wall-history-sorting-oldest-first' => 'Terlama dahulu',
	'wall-history-summary-label' => 'Ringkasan',
	'wall-history-rail-wall' => 'papan',
	'wall-history-rail-contribs' => 'sumb.',
	'wall-history-rail-block' => 'sekat',
	'wall-history-action-view' => 'paparkan',
	'wall-history-action-restore' => 'pulihkan',
	'wall-history-action-thread-history' => 'sejarah tred',
	'wall-thread-history-title' => 'sejarah tred',
	'wall-thread-history-thread-created' => '$1 $2 membuat tred ini',
	'wall-thread-history-reply-created' => '$1 $2 meninggalkan balasan',
	'wall-thread-history-thread-removed' => '$1 $2 membuang tred ini',
	'wall-thread-history-reply-removed' => '$1 $2 membuang balasan $3 $5',
	'wall-thread-history-thread-restored' => '$1 $2 memulihkan tred ini',
	'wall-thread-history-reply-restored' => '$1 $2 memulihkan balasan $3 $5',
	'wall-thread-history-thread-deleted' => '$1 $2 menghapuskan tred ini',
	'wall-thread-history-thread-edited' => '$1 $2 menyunting pesanan $3 $5',
	'wall-thread-history-reply-edited' => '$1 $2 menyunting pesanan $3 $5',
	'wall-history-action-restore-reply' => 'pulihkan balasan',
	'wall-history-action-restore-thread' => 'pulihkan tred',
	'wall-message-not-found-in-db' => 'Maaf, kami tidak menjumpai pesanan ini dalam pangkalan data kami.',
	'mail-notification-new-someone' => '$AUTHOR_NAME menulis pesanan baru di $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME meninggalkan pesanan baru kepada anda di $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME membalas pesanan anda di $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME membalas suatu pesanan di $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME membalas pesanan $PARENT_AUTHOR_NAME di $WIKI.',
	'mail-notification-html-greeting' => 'Apa khabar $1,',
	'mail-notification-html-button' => 'Lihat perbualan',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Untuk meninjau perkembangan terkini di Wikia, lawati <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Ingin mengawal e-mel yang anda terima? Pergi ke <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Keutamaan</a> anda',
	'mail-notification-body' => 'Apa khabar $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Lihat perbualan($MESSAGE_LINK)
 
Pasukan Wikia

___________________________________________
* Dapatkan bantuan dan nasihat di Community Central: http://community.wikia.com
* Tak nak terima banyak pesanan daripada kami? Anda boleh berhenti melanggan atau 
ubah keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hi $WATCHER,
<p>$SUBJECT.</p> 
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p> 			
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Lihat perbualan</a></p>
<p>Pasukan Wikia</p>
___________________________________________<br />
* Dapatkan bantuan dan nasihat di Community Central: http://community.wikia.com
* Tak nak terima banyak pesanan daripada kami? Anda boleh berhenti melanggan atau 
ubah keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
	'prefs-email-wall-v2' => 'Papan Pesanan',
	'tog-enotifwallthread-v2' => 'E-mel saya…',
	'tog-enotifmywall-every' => 'Untuk setiap pesanan & balasan',
	'tog-enotifmywall-sincevisited' => 'Sekali setred sejak kunjungan terkini saya',
	'tog-enotifmywall-reminder' => 'Dengan e-mel peringatan harian',
	'tog-enotifmywall-noemail' => 'Jangan sesekali hantar e-mel Papan Pesanan kepada saya',
	'wallshowsource-toggle-v2' => 'Hidupkan pilihan {{int:user-action-menu-view-source}} pada pos-pos Papan Pesanan',
	'wallshowsource-toggle' => 'Hidupkan {{int:user-action-menu-view-source}} pada pos-pos Papan Pesanan',
	'walldelete-toggle' => 'Hidupkan ciri Hapus semakan pada pos-pos Papan Pesanan',
);

/** Norwegian Bokmål (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'wall-thread-removed' => 'Fjernet',
	'wall-thread-deleted' => 'Slettet',
	'wall-no-title-warning' => '← Du oppga ikke en tittel',
	'wall-placeholder-topic' => 'Hva handler dette om?',
	'wall-button-to-preview-comment' => 'Forhåndsvisning',
	'wall-button-to-submit-comment' => 'Post',
	'wall-button-cancel-changes' => 'Avbryt',
	'wall-button-done-source' => 'Ferdig',
	'wall-message-edit' => 'Rediger',
	'wall-message-more' => 'Mer',
	'wall-message-delete' => 'Slett',
	'wall-history-summary-label' => 'Sammendrag',
	'wall-history-rail-wall' => 'vegg',
	'wall-history-rail-contribs' => 'bidrag',
	'mail-notification-html-greeting' => 'Hei $1,',
	'mail-notification-html-button' => 'Se samtalen',
	'mail-notification-subject' => '$1 -- $2',
	'tog-enotifwallthread-v2' => 'Send meg e-post når...',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'wall-no-title' => 'Geen koptekst',
	'wall-tab-wall-title' => 'Berichtenmuur:$1',
	'wall-message-loadmore' => '{{PLURAL:$1|Reactie|Alle $1 reacties}} weergeven',
	'wall-message-wall' => 'Berichtenmuur',
	'wall-message-wall-shorten' => 'muur',
	'wall-message-unfollow' => 'Niet langer volgen',
	'wall-message-undoremove' => 'Ongedaan maken',
	'wall-message-edited' => '<a href="$3" >Bewerkt door</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Mijn muur',
	'wall-toolbar-history' => 'Geschiedenis',
	'wall-message-notify' => 'Beheerder informeren',
	'wall-message-remove' => 'Verwijderen',
	'wall-message-rev-delete' => 'Versies verwijderen',
	'wall-message-elseswall' => 'Muur van $1',
	'wall-message-no-permission' => 'U hebt geen rechten om deze handeling op het bericht uit te voeren',
	'wall-thread-removed' => 'Verwijderd',
	'wall-thread-deleted' => 'Verwijderd',
	'wall-default-title' => 'Bericht van $1',
	'wall-no-title-warning' => '← U hebt geen koptekst opgegeven',
	'wall-desc' => "Vervanging voor de overlegpagina's van gebruikers",
	'wall-disabled-desc' => "Berichtenmuurfunctie voor wiki's zonder de uitbreiding Wall",
	'wall-placeholder-topic' => 'Waar gaat dit over?',
	'wall-placeholder-message' => 'Nieuw bericht plaatsen op de muur van $1',
	'wall-placeholder-message-anon' => 'Nieuw bericht op deze muur plaatsen',
	'wall-placeholder-reply' => 'Reactie plaatsen',
	'wall-button-to-preview-comment' => 'Voorvertoning',
	'wall-button-to-cancel-preview' => 'Bewerken',
	'wall-button-to-submit-comment' => 'Opslaan',
	'wall-button-to-submit-reply' => 'Beantwoorden',
	'wall-button-to-submit-comment-no-topic' => 'Bericht plaatsen zonder koptekst',
	'wall-button-save-changes' => 'Wijzigingen opslaan',
	'wall-button-cancel-changes' => 'Annuleren',
	'wall-button-done-source' => 'Afgerond',
	'wall-message-edit' => 'Bewerken',
	'wall-message-more' => 'Meer',
	'wall-message-delete' => 'Verwijderen',
	'wall-message-removed-thread-because' => '$1 heeft deze draad verwijderd om de volgende reden:',
	'wall-message-deleted-thread-because' => '$1 heeft deze draad verwijderd om de volgende reden:',
	'wall-message-restore-thread' => 'Draad terugplaatsen',
	'wall-message-removed-reply-because' => '$1 heeft dit antwoord verwijderd om de volgende reden:',
	'wall-message-deleted-reply-because' => '$1 heeft dit antwoord verwijderd om de volgende reden:',
	'wall-message-restore-reply' => 'Antwoord terugplaatsen',
	'wall-delete-reason' => 'Gebruikers- of beheerdershandeling',
	'wall-user-talk-page-archive-anchor' => 'Zie gearchiveerde overlegpagina',
	'wall-user-talk-archive-page-title' => 'Gearchiveerde_overlegpagina',
	'wall-action-all-confirm-cancel' => 'Annuleren',
	'wall-action-all-confirm-notify' => 'Beheerder informeren',
	'wall-action-remove-reply-title' => 'Dit antwoord verwijderen',
	'wall-action-remove-thread-title' => 'Deze draad verwijderen',
	'wall-confirm-monobook-remove' => 'Geef aan waarom u dit wilt verwijderen.

Het oorspronkelijke bericht en uw bewerkingssamenvatting blijven nog wel in de geschiedenis van de wiki staan.',
	'wall-confirm-monobook-admin' => 'Geef aan waarom u dit wilt verwijderen.

Het oorspronkelijke bericht en uw bewerkingssamenvatting blijven nog wel in de geschiedenis van de wiki staan.',
	'wall-confirm-monobook-restore' => 'Geef aan waarom u dit terug wilt plaatsen',
	'wall-delete-error-title' => 'Fout',
	'wall-delete-error-content' => 'Het bericht is verwijderd en bestaat niet langer.',
	'wall-confirm-monobook-lack-of-reason' => 'Geef een reden op voor het verwijderen van deze draad of dit antwoord.',
	'wall-action-remove-confirm' => 'Geef een reden op waarom u dit wilt verwijderen:',
	'wall-action-remove-thread-confirm-info' => 'Deze draad en uw opgave van reden blijven nog wel beschikbaar in de geschiedenis van de wiki.',
	'wall-action-remove-reply-confirm-info' => 'Dit antwoord en uw reden blijven nog wel beschikbaar in geschiedenis van de wiki.',
	'wall-action-remove-confirm-ok' => 'Verwijderen',
	'wall-action-admin-thread-title' => 'Deze draad verwijderen',
	'wall-action-admin-reply-title' => 'Dit antwoord verwijderen',
	'wall-action-admin-confirm' => 'Geef een reden op waarom u dit wilt verwijderen:',
	'wall-action-admin-thread-confirm-info' => 'Deze draad en uw opgave van reden blijven nog wel beschikbaar in de geschiedenis van de wiki.',
	'wall-action-admin-reply-confirm-info' => 'Deze draad en uw opgave van reden blijven nog wel beschikbaar in de geschiedenis van de wiki. Alleen beheerders kunnen deze draad nog bekijken.',
	'wall-action-admin-confirm-ok' => 'Verwijderen',
	'wall-action-restore-thread-title' => 'Deze draad terugplaatsen',
	'wall-action-restore-reply-title' => 'Dit antwoord terugplaatsen',
	'wall-action-restore-confirm' => 'Geef een reden op waarom u dit terug wilt plaatsen:',
	'wall-action-restore-confirm-ok' => 'Terugplaatsen',
	'wall-action-rev-reply-confirm' => 'Weet u zeker dat u dit bericht wilt verwijderen?',
	'wall-action-rev-confirm-ok' => 'Ja, verwijderen',
	'wall-notifications' => 'Meldingen',
	'wall-notifications-all' => 'Alle meldingen',
	'wall-notifications-markasread' => 'Alles als gelezen markeren',
	'wall-notifications-markasread-all-wikis' => "Alle wiki's",
	'wall-notifications-markasread-this-wiki' => 'Deze wiki',
	'wall-notifications-empty' => 'Er zijn geen meldingen',
	'wall-notifications-reminder' => 'U hebt <span>$1</span> ongelezen {{PLURAL:$1|melding|meldingen}}',
	'wn-user1-reply-you-your-wall' => '$1 heeft geantwoord op uw bericht op uw muur',
	'wn-user2-reply-you-your-wall' => '$1 en $2 hebben geantwoord op uw bericht op uw muur',
	'wn-user3-reply-you-your-wall' => '$1 en anderen hebben geantwoord op uw bericht op uw muur',
	'wn-user1-reply-self-your-wall' => '$1 heeft geantwoord op een bericht op uw muur',
	'wn-user2-reply-self-your-wall' => '$1 en $2 hebben geantwoord op een bericht op uw muur',
	'wn-user3-reply-self-your-wall' => '$1 en anderen hebben geantwoord op een bericht op uw muur',
	'wn-user1-reply-other-your-wall' => '$1 heeft geantwoord op een bericht van $2 op uw muur',
	'wn-user2-reply-other-your-wall' => '$1 en $2 hebben geantwoord op een bericht van $3 op uw muur',
	'wn-user3-reply-other-your-wall' => '$1 en anderen hebben geantwoord op een bericht van $2 op uw muur',
	'wn-user1-reply-you-other-wall' => '$1 heeft geantwoord op uw bericht op de muur van $2',
	'wn-user2-reply-you-other-wall' => '$1 en $2 hebben geantwoord op uw bericht op de muur van $3',
	'wn-user3-reply-you-other-wall' => '$1 en anderen hebben geantwoord op uw bericht op de muur van $3',
	'wn-user1-reply-self-other-wall' => '$1 heeft geantwoord op een bericht op de muur van $2',
	'wn-user2-reply-self-other-wall' => '$1 en $2 hebben geantwoord op een bericht op de muur van $3',
	'wn-user3-reply-self-other-wall' => '$1 en anderen hebben geantwoord op een bericht op de muur van $2',
	'wn-user1-reply-other-other-wall' => '$1 heeft geantwoord op een bericht van $2 op de muur van $3',
	'wn-user2-reply-other-other-wall' => '$1 en $2 hebben geantwoord op een bericht van $3 op de muur van $4',
	'wn-user3-reply-other-other-wall' => '$1 en anderen hebben geantwoord op een bericht van $2 op de muur van $3',
	'wn-user1-reply-you-a-wall' => '$1 heeft uw bericht beantwoord',
	'wn-user2-reply-you-a-wall' => '$1 en $2 hebben uw bericht beantwoord',
	'wn-user3-reply-you-a-wall' => '$1 en anderen hebben uw bericht beantwoord',
	'wn-user1-reply-self-a-wall' => '$1 heeft een bericht beantwoord',
	'wn-user2-reply-self-a-wall' => '$1 en $2 hebben een bericht beantwoord',
	'wn-user3-reply-self-a-wall' => '$1 en anderen hebben een bericht beantwoord',
	'wn-user1-reply-other-a-wall' => '$1 heeft een bericht van $2 beantwoord',
	'wn-user2-reply-other-a-wall' => '$1 en $2 hebben een bericht van $3 beantwoord',
	'wn-user3-reply-other-a-wall' => '$1 en anderen hebben geantwoord op een bericht van $3',
	'wn-newmsg-onmywall' => '$1 heeft een nieuw bericht geplaatst op uw muur',
	'wn-newmsg' => 'U hebt een nieuw bericht geplaatst op de muur van $1',
	'wn-newmsg-on-followed-wall' => '$1 heeft een nieuw bericht geplaatst op de muur van $2',
	'wn-admin-thread-deleted' => 'De draad is verwijderd van de muur van $1',
	'wn-admin-reply-deleted' => 'Het antwoord is verwijderd uit de draad op de muur van $1',
	'wn-owner-thread-deleted' => 'De draad is verwijderd van uw muur',
	'wn-owner-reply-deleted' => 'Het antwoord is verwijderd uit de draad op uw muur',
	'wall-sorting-newest-threads' => 'Nieuwste draden',
	'wall-sorting-oldest-threads' => 'Oudste draden',
	'wall-sorting-most-active' => 'Meest actief',
	'wall-sorting-archived' => 'Gearchiveerd',
	'wall-deleted-msg-pagetitle' => 'Het bericht is verwijderd',
	'wall-recentchanges-comment-new-message' => '(nieuw: "$1")',
	'wall-recentchanges-new-reply' => '(antwoord: "$1")',
	'wall-recentchanges-edit' => '(bericht bewerkt)',
	'wall-recentchanges-namespace-selector-message-wall' => 'Berichtenmuur',
	'wall-wiki-activity-on' => 'op $1',
	'wall-wiki-activity-wall-owner' => 'Muur van $1',
	'wall-history' => 'Geschiedenis',
	'wall-history-sorting-newest-first' => 'Nieuwste eerst',
	'wall-history-sorting-oldest-first' => 'Oudste eerst',
	'wall-history-summary-label' => 'Samenvatting',
	'wall-history-rail-wall' => 'muur',
	'wall-history-rail-contribs' => 'bijdragen',
	'wall-history-rail-block' => 'blokkeren',
	'wall-history-action-view' => 'bekijken',
	'mail-notification-html-greeting' => 'Hallo $1,',
	'tog-enotifwallthread-v2' => 'E-mail mij...',
	'tog-enotifmywall-every' => 'Voor elk bericht & antwoord',
);

/** Polish (Polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'wall-no-title' => 'Brak tytułu',
	'wall-tab-wall-title' => 'Tablica Wiadomości:$1',
	'wall-message-loadmore' => 'Zobacz wszystkie odpowiedzi ({{PLURAL:$1|$1 odpowiedź|$1 odpowiedzi}})',
	'wall-message-wall' => 'Tablica Wiadomości',
	'wall-message-wall-shorten' => 'tablica',
	'wall-message-unfollow' => 'Nie obserwuj',
	'wall-message-undoremove' => 'Cofnij',
	'wall-message-edited' => '<a href="$3" >Edytowane przez</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Moja Tablica',
	'wall-toolbar-history' => 'Historia',
	'wall-message-notify' => 'Powiadom administratora',
	'wall-message-remove' => 'Usuń',
	'wall-message-rev-delete' => 'Usunięcie pełnej wersji',
	'wall-message-elseswall' => 'Tablica $1',
	'wall-message-no-permission' => 'Nie masz uprawnień do tej akcji',
	'wall-thread-removed' => 'Usunięto',
	'wall-thread-deleted' => 'Skasowano',
	'wall-default-title' => 'Wiadomość od $1',
	'wall-no-title-warning' => '← Nie podano tytułu',
	'wall-desc' => 'Alternatywa dla stron dyskusji użytkownika',
	'wall-disabled-desc' => 'Funkcjonalność Tablicy Wiadomości dla stron nie korzystających z tego rozszerzenia',
	'wall-placeholder-topic' => 'Temat wiadomości',
	'wall-placeholder-message' => 'Napisz nową wiadomość na Tablicy $1',
	'wall-placeholder-message-anon' => 'Publikuj nową wiadomość na tej Tablicy',
	'wall-placeholder-reply' => 'Odpowiedz',
	'wall-button-to-preview-comment' => 'Podgląd',
	'wall-button-to-cancel-preview' => 'Edytuj',
	'wall-button-to-submit-comment' => 'Publikuj',
	'wall-button-to-submit-reply' => 'Odpowiedz',
	'wall-button-to-submit-comment-no-topic' => 'Publikuj bez tytułu',
	'wall-button-save-changes' => 'Zapisz zmiany',
	'wall-button-cancel-changes' => 'Anuluj',
	'wall-button-done-source' => 'Gotowe',
	'wall-message-edit' => 'Edytuj',
	'wall-message-more' => 'Więcej',
	'wall-message-delete' => 'Skasuj',
	'wall-message-removed-thread-because' => '$1 usunął ten wątek ponieważ:',
	'wall-message-deleted-thread-because' => '$1 skasował ten wątek ponieważ:',
	'wall-message-restore-thread' => 'Przywróć Wątek',
	'wall-message-removed-reply-because' => '$1 usunął tę odpowiedź ponieważ:',
	'wall-message-deleted-reply-because' => '$1 skasował tę odpowiedź ponieważ:',
	'wall-message-restore-reply' => 'Przywróć Odpowiedź',
	'wall-delete-reason' => 'Decyzja użytkownika/administratora',
	'wall-user-talk-page-archive-anchor' => 'Zobacz zarchiwizowaną stronę dyskusji',
	'wall-user-talk-archive-page-title' => 'Dyskusja_użytkownika_archiwum',
	'wall-action-all-confirm-cancel' => 'Anuluj',
	'wall-action-all-confirm-notify' => 'Powiadom administratora',
	'wall-action-remove-reply-title' => 'Usuń tę odpowiedź',
	'wall-action-remove-thread-title' => 'Usuń ten wątek',
	'wall-confirm-monobook-remove' => 'Proszę podaj powód usunięcia. 

Ten wątek i jego historia nadal będą dostępne w historii wiki.',
	'wall-confirm-monobook-admin' => 'Proszę podaj powód skasowania. 

Ten wątek i jego historia nadal będą dostępne w historii wiki.',
	'wall-confirm-monobook-restore' => 'Proszę podaj powód przywrócenia',
	'wall-delete-error-title' => 'Błąd',
	'wall-delete-error-content' => 'Wiadomość została wcześniej skasowana i nie jest dostępna.',
	'wall-confirm-monobook-lack-of-reason' => 'Proszę podaj powód usunięcia wątku/odpowiedzi.',
	'wall-action-remove-confirm' => 'Proszę podaj powód usunięcia:',
	'wall-action-remove-thread-confirm-info' => 'Ten wątek i opis zmian będą dostępne w historii wiki.',
	'wall-action-remove-reply-confirm-info' => 'Ta odpowiedź i opis zmian będą dostępne w historii wiki.',
	'wall-action-remove-confirm-ok' => 'Usuń',
	'wall-action-admin-thread-title' => 'Skasuj ten wątek',
	'wall-action-admin-reply-title' => 'Skasuj tę odpowiedź',
	'wall-action-admin-confirm' => 'Proszę podaj powód skasowania wiadomości:',
	'wall-action-admin-thread-confirm-info' => 'Ten wątek i opis zmian będą dostępne w historii wiki',
	'wall-action-admin-reply-confirm-info' => 'Ten wątek i jego historia nadal będą dostępne w historii wiki. Tylko administratorzy będą mogli wyświetlić ten wątek.',
	'wall-action-admin-confirm-ok' => 'Skasuj',
	'wall-action-restore-thread-title' => 'Przywróć ten wątek',
	'wall-action-restore-reply-title' => 'Przywróć tę odpowiedź',
	'wall-action-restore-confirm' => 'Proszę podaj powód przywrócenia:',
	'wall-action-restore-confirm-ok' => 'Przywróć',
	'wall-action-rev-thread-title' => 'Usunąć pełną wersję tego wątku?',
	'wall-action-rev-reply-title' => 'Usunąć pełną wersję tej odpowiedzi?',
	'wall-action-rev-reply-confirm' => 'Na pewno usunąć tę wiadomość?',
	'wall-action-rev-thread-confirm' => 'Na pewno chcesz usunąć pełną wersję tego wątku i całą historię? Tej operacji nie można cofnąć.',
	'wall-action-rev-confirm-ok' => 'Tak, Usuń',
	'wall-notifications' => 'Powiadomienia',
	'wall-notifications-all' => 'Wszystkie powiadomienia',
	'wall-notifications-markasread' => 'Oznacz wszystkie jako przeczytane',
	'wall-notifications-markasread-all-wikis' => 'Wszystkie wiki',
	'wall-notifications-markasread-this-wiki' => 'Ta wiki',
	'wall-notifications-empty' => 'Brak powiadomień',
	'wall-notifications-loading' => 'Trwa ładowanie powiadomień',
	'wall-notifications-reminder' => 'Masz <span>$1</span> {{PLURAL:$1|nieprzeczytane powiadomienie|nieprzeczytane powiadomienia|nieprzeczytanych powiadomień}}',
	'wall-notifications-wall-disabled' => 'Tablica Wiadomości została wyłączona na tej wiki. Nie załadowano powiadomień.',
	'wn-user1-reply-you-your-wall' => '$1 odpowiedział na Twoją wiadomość na Twojej Tablicy',
	'wn-user2-reply-you-your-wall' => '$1 i $2 odpowiedzieli na Twoją wiadomość na Twojej Tablicy',
	'wn-user3-reply-you-your-wall' => '$1 i inni odpowiedzieli na Twoją wiadomość na Twojej Tablicy',
	'wn-user1-reply-self-your-wall' => '$1 odpowiedział na wiadomość na Twojej Tablicy',
	'wn-user2-reply-self-your-wall' => '$1 i $2 odpowiedzieli na wiadomość na Twojej Tablicy',
	'wn-user3-reply-self-your-wall' => '$1 i inni odpowiedzieli na wiadomość na Twojej Tablicy',
	'wn-user1-reply-other-your-wall' => '$1 odpowiedział na wiadomość $2 na Twojej Tablicy',
	'wn-user2-reply-other-your-wall' => '$1 i $2 odpowiedzieli na wiadomość od $3 na Twojej Tablicy',
	'wn-user3-reply-other-your-wall' => '$1 i inni odpowiedzieli na wiadomość od $2 na Twojej Tablicy',
	'wn-user1-reply-you-other-wall' => '$1 odpowiedział na Twoją wiadomość na Tablicy $2',
	'wn-user2-reply-you-other-wall' => '$1 i $2 odpowiedzieli na Twoją wiadomość na Tablicy $3',
	'wn-user3-reply-you-other-wall' => '$1 i inni odpowiedzieli na Twoją wiadomość na Tablicy $3',
	'wn-user1-reply-self-other-wall' => '$1 odpowiedział na wiadomość na Tablicy $2',
	'wn-user2-reply-self-other-wall' => '$1 i $2 odpowiedzieli na wiadomość na Tablicy $3',
	'wn-user3-reply-self-other-wall' => '$1 i inni odpowiedzieli na wiadomość na Tablicy $2',
	'wn-user1-reply-other-other-wall' => '$1 odpowiedział na wiadomość $2 na Tablicy $3',
	'wn-user2-reply-other-other-wall' => '$1 i $2 odpowiedzieli na wiadomość od $3 na Tablicy $4',
	'wn-user3-reply-other-other-wall' => '$1 i inni odpowiedzieli na wiadomość od $2 na Tablicy $3',
	'wn-user1-reply-you-a-wall' => '$1 odpowiedział na Twoją wiadomość',
	'wn-user2-reply-you-a-wall' => '$1 i $2 odpowiedzieli na Twoją wiadomość',
	'wn-user3-reply-you-a-wall' => '$1 i inni odpowiedzieli na Twoją wiadomość',
	'wn-user1-reply-self-a-wall' => '$1 odpowiedział na wiadomość',
	'wn-user2-reply-self-a-wall' => '$1 i $2 odpowiedzieli na wiadomość',
	'wn-user3-reply-self-a-wall' => '$1 i inni odpowiedzieli na wiadomość',
	'wn-user1-reply-other-a-wall' => '$1 odpowiedział na wiadomość $2',
	'wn-user2-reply-other-a-wall' => '$1 i $2 odpowiedzieli na wiadomość od $3',
	'wn-user3-reply-other-a-wall' => '$1 i inni odpowiedzieli na wiadomość od $3',
	'wn-newmsg-onmywall' => '$1 zostawił nową wiadomość na Twojej Tablicy',
	'wn-newmsg' => 'Zostawiłeś nową wiadomość na Tablicy $1',
	'wn-newmsg-on-followed-wall' => '$1 zostawił nową wiadomość na Tablicy użytkownika  $2.',
	'wn-admin-thread-deleted' => 'Wątek skasowany z Tablicy użytkownika $1',
	'wn-admin-reply-deleted' => 'Odpowiedź skasowano z wątku na Tablicy $1',
	'wn-owner-thread-deleted' => 'Wątek skasowano z Twojej Tablicy',
	'wn-owner-reply-deleted' => 'Odpowiedź usunięto z wątku na Twojej Tablicy',
	'wall-sorting-newest-threads' => 'Najnowsze wątki',
	'wall-sorting-oldest-threads' => 'Najstarsze wątki',
	'wall-sorting-newest-replies' => 'Najnowsze odpowiedzi',
	'wall-sorting-most-active' => 'Najaktywniejsze',
	'wall-sorting-archived' => 'Zarchiwizowane',
	'tog-enotifwallthread' => '...ktoś odpowie na obserwowany wątek na Tablicy Wiadomości',
	'tog-enotifmywall' => '...ktoś napisze nową wiadomość na mojej tablicy',
	'wall-deleted-msg-pagetitle' => 'Wiadomość skasowano',
	'wall-deleted-msg-text' => 'Wiadomość, którą próbujesz otworzyć została skasowana.',
	'wall-deleted-msg-return-to' => 'Powrót do  tablicy użytkownika $1.',
	'wall-deleted-msg-view' => '(pokaż/przywróć)',
	'wall-recentchanges-article-link-new-message' => 'na <a href="$1">tablicy użytkownika $2</a>',
	'wall-recentchanges-comment-new-message' => '(nowa: "$1")',
	'wall-recentchanges-new-reply' => '(odpowiedź: "$1")',
	'wall-recentchanges-edit' => '(edytowano wiadomość)',
	'wall-recentchanges-wall-removed-thread' => 'usunięto wątek "[[$1|$2]]" z [[$3|Tablicy $4]]',
	'wall-recentchanges-wall-removed-reply' => 'usunięto odpowiedź w "[[$1|$2]]" z [[$3|Tablicy $4]]',
	'wall-recentchanges-wall-restored-thread' => 'przywrócono wątek "[[$1|$2]]" na [[$3|Tablicy $4]]',
	'wall-recentchanges-wall-restored-reply' => 'przywrócono odpowiedź w "[[$1|$2]]" na [[$3|Tablicy $4]]',
	'wall-recentchanges-wall-deleted-thread' => 'skasowano wątek "[[$1|$2]]" z [[$3|Tablicy $4]]',
	'wall-recentchanges-wall-deleted-reply' => 'skasowano odpowiedź w "[[$1|$2]]" z [[$3|Tablicy $4]]',
	'wall-recentchanges-deleted-reply-title' => 'Odpowiedź na tablicy wiadomości',
	'wall-recentchanges-namespace-selector-message-wall' => 'Tablica Wiadomości',
	'wall-recentchanges-wall-group' => '$1 na <a href="$2">Tablicy $3</a>',
	'wall-recentchanges-wall-history-link' => 'historia tablicy',
	'wall-recentchanges-thread-history-link' => 'historia wątku',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> na <a href="$3">Tablicy $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> na <a href="$3">Tablicy $4</a>',
	'wall-message-not-found' => 'Nie odnaleziono wiadomości. Gdy zobaczysz ten błąd proszę powiadom nas przez [[Special:Contact]] podając możliwie dużo informacji na temat okoliczności, abyśmy  mogli odtworzyć błąd. Dziękujemy!',
	'wall-message-staff-text' => 'Ten użytkownik jest pracownikiem Wikii',
	'wall-ipballowusertalk' => 'Pozwól temu użytkownikowi dodawać wiadomości na własnej tablicy, kiedy jest zablokowany',
	'wall-ipbwatchuser' => 'Obserwuj profil tego użytkownika i jego tablicę',
	'wall-wiki-activity-on' => 'na $1',
	'wall-wiki-activity-wall-owner' => 'Tablica użytkownika $1',
	'wall-removed-thread-undo' => 'Wątek został usunięty. $1',
	'wall-removed-reply-undo' => 'Odpowiedź ta została usunięta. $1',
	'wall-removed-reply' => 'Odpowiedź ta została usunięta',
	'wall-deleted-thread-undo' => 'Wątek został usunięty. $1',
	'wall-deleted-reply-undo' => 'Ta odpowiedź została skasowana. $1',
	'wall-deleted-reply' => 'Ta odpowiedź została skasowana',
	'wall-history' => 'Historia',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'Historia Tablicy',
	'wall-history-who-involved-wall-title' => 'Kto edytował na tej tablicy?',
	'wall-history-who-involved-thread-title' => 'Kto edytował ten wątek?',
	'wall-history-thread-created' => '$1 utworzony przez $2',
	'wall-history-thread-removed' => '$1 usunięty przez $2',
	'wall-history-thread-restored' => '$1 przywrócony przez $2',
	'wall-history-thread-admin-deleted' => '$1 skasowany przez $2',
	'wall-history-sorting-newest-first' => 'Od najnowszych',
	'wall-history-sorting-oldest-first' => 'Od najstarszych',
	'wall-history-summary-label' => 'Podsumowanie',
	'wall-history-rail-wall' => 'tablica',
	'wall-history-rail-contribs' => 'edycje',
	'wall-history-rail-block' => 'zablokuj',
	'wall-history-action-view' => 'pokaż',
	'wall-history-action-restore' => 'przywróć',
	'wall-history-action-thread-history' => 'historia wątku',
	'wall-thread-history-title' => 'Historia Wątku',
	'wall-thread-history-thread-created' => '$1 $2 {{GENDER:$2|utworzył|utworzyła|utworzył}} ten wątek',
	'wall-thread-history-reply-created' => '$1 $2 {{GENDER:$2|zostawił|zostawiła|zostawił}} odpowiedź',
	'wall-thread-history-thread-removed' => '$1 $2 {{GENDER:$2|usunął|usunęła|usunął}} ten wątek',
	'wall-thread-history-reply-removed' => '$1 $2 {{GENDER:$2|usunął|usunęła|usunął}} odpowiedź $5 użytkownika $3',
	'wall-thread-history-thread-restored' => '$1 $2 {{GENDER:$2|przywrócił|przywróciła|przywrócił}} ten wątek',
	'wall-thread-history-reply-restored' => '$1 $2 {{GENDER:$2|przywrócił|przywróciła|przywrócił}} odpowiedź $5 użytkownika $3',
	'wall-thread-history-thread-deleted' => '$1 $2 {{GENDER:$2|skasował|skasowała|skasował}} ten wątek',
	'wall-thread-history-thread-edited' => '$1 $2 {{GENDER:$2|edytował|edytowała|edytował}} wiadomość $5 użytkownika $3',
	'wall-thread-history-reply-edited' => '$1 $2 {{GENDER:$2|edytował|edytowała|edytował}} wiadomość $5 użytkownika $3',
	'wall-history-action-restore-reply' => 'przywróć odpowiedź',
	'wall-history-action-restore-thread' => 'przywróć wątek',
	'wall-message-not-found-in-db' => 'Nie odnaleziono tej wiadomości w bazie danych, przepraszamy.',
	'mail-notification-new-someone' => '$AUTHOR_NAME napisał nową wiadomość na $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME zostawił Ci wiadomość na $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME odpowiedział na Twoją wiadomość na $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME odpowiedział na wiadomość na $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME odpowiedział na wiadomość użytkownika $PARENT_AUTHOR_NAME na $WIKI.',
	'mail-notification-html-greeting' => 'Witaj $1,',
	'mail-notification-html-button' => 'Przejdź do wiadomości',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
 
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
 
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
 
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Aby dowiedzieć się co nowego na Wikii, odwiedź <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Chcesz zmienić ustawienia przysyłanych wiadomości? Idź do swoich <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferencji</a>',
	'mail-notification-body' => 'Witaj $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Przejdź do wiadomości($MESSAGE_LINK)
 
Zespół Wikia

___________________________________________
* Znajdź pomoc na Wiki Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Witaj $WATCHER,
<p>$SUBJECT.</p> 
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p> 			
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Przejdź do wiadomości</a></p>
<p>Zespół Wikia</p>
___________________________________________<br />
* Znajdź pomoc na Wiki Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
	'prefs-email-wall-v2' => 'Tablica Wiadomości',
	'tog-enotifwallthread-v2' => 'Wyślij e-mail gdy…',
	'tog-enotifmywall-every' => 'Dla każdej wiadomości i odpowiedzi',
	'tog-enotifmywall-sincevisited' => 'Raz na każdy zmieniony wątek od moich ostatnich odwiedzin',
	'tog-enotifmywall-reminder' => 'Z przypomnieniem raz na dzień',
	'tog-enotifmywall-noemail' => 'Nigdy. Nie wysyłaj powiadomień dotyczących zmian na Tablicy Wiadomości',
	'wallshowsource-toggle-v2' => 'Włącz {{int:user-action-menu-view-source}} dla wpisów na Tablicy Wiadomości',
	'wallshowsource-toggle' => 'Włącz {{int:user-action-menu-view-source}} dla wpisów na Tablicy Wiadomości',
	'walldelete-toggle' => 'Włącz opcję usuwania pełnych wersji wiadomości na Tablicy Wiadomości',
);

/** Russian (Русский)
 * @author Express2000
 * @author Kuzura
 */
$messages['ru'] = array(
	'wall-no-title' => 'Без названия',
	'wall-tab-wall-title' => 'Стена участника:$1',
	'wall-message-loadmore' => 'Просмотреть $1 {{PLURAL:$1|ответ|ответа|ответов}}',
	'wall-message-wall' => 'Обсуждение участника',
	'wall-message-wall-shorten' => 'обсуждение',
	'wall-message-unfollow' => 'Не следить',
	'wall-message-undoremove' => 'Восстановить',
	'wall-message-edited' => '<a href="$3" >Отредактировал </a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Моя стена',
	'wall-toolbar-history' => 'История',
	'wall-message-notify' => 'Уведомить администратора',
	'wall-message-remove' => 'Удалить',
	'wall-message-rev-delete' => 'Просмотреть удалённое',
	'wall-message-elseswall' => 'Стена $1',
	'wall-message-no-permission' => 'У вас нет прав выполнять это действие над сообщением',
	'wall-thread-removed' => 'Удалено',
	'wall-thread-deleted' => 'Удалить',
	'wall-default-title' => 'Сообщение от $1',
	'wall-no-title-warning' => '← Вы не указали название темы',
	'wall-desc' => 'Замена страницы обсуждения участника',
	'wall-disabled-desc' => 'Стена обсуждения функциональна для страниц без подключения Стены',
	'wall-placeholder-topic' => 'Тема сообщения',
	'wall-placeholder-message' => 'Оставить сообщение на стене участника $1',
	'wall-placeholder-message-anon' => 'Оставить новое сообщение на этой стене',
	'wall-placeholder-reply' => 'Ответить',
	'wall-button-to-preview-comment' => 'Предпросмотр',
	'wall-button-to-cancel-preview' => 'Править',
	'wall-button-to-submit-comment' => 'Оставить сообщение',
	'wall-button-to-submit-reply' => 'Оставить ответ',
	'wall-button-to-submit-comment-no-topic' => 'Оставить сообщение без заголовка',
	'wall-button-save-changes' => 'Сохранить изменения',
	'wall-button-cancel-changes' => 'Отмена',
	'wall-button-done-source' => 'Сделано',
	'wall-message-edit' => 'Править',
	'wall-message-more' => 'Больше',
	'wall-message-delete' => 'Удалить',
	'wall-message-removed-thread-because' => '$1 удалил эту тему, причина:',
	'wall-message-deleted-thread-because' => '$1 удалил эту тему, причина:',
	'wall-message-restore-thread' => 'Восстановить тему',
	'wall-message-removed-reply-because' => '$1 удалил этот ответ, причина:',
	'wall-message-deleted-reply-because' => '$1 удалил этот ответ, причина:',
	'wall-message-restore-reply' => 'Восстановить ответ',
	'wall-delete-reason' => 'Действия участника/администратора',
	'wall-user-talk-page-archive-anchor' => 'Просмотреть заархивированные страницы обсуждения',
	'wall-user-talk-archive-page-title' => 'Архив_обсуждения_участника',
	'wall-action-all-confirm-cancel' => 'Отмена',
	'wall-action-all-confirm-notify' => 'Уведомить администратора',
	'wall-action-remove-reply-title' => 'Удалить этот ответ',
	'wall-action-remove-thread-title' => 'Удалить эту тему',
	'wall-confirm-monobook-remove' => 'Пожалуйста, напишите, почему вы хотите удалить это.

Оригинал сообщения и ваш комментарий останутся в истории вики.',
	'wall-confirm-monobook-admin' => 'Пожалуйста, напишите, почему вы хотите удалить это.

Оригинал сообщения и ваш комментарий останутся в истории вики.',
	'wall-confirm-monobook-restore' => 'Пожалуйста, укажите, почему вы хотите восстановить это',
	'wall-delete-error-title' => 'Ошибка',
	'wall-delete-error-content' => 'Сообщение было удалено и больше не существует.',
	'wall-confirm-monobook-lack-of-reason' => 'Пожалуйста, оставьте комментарий к удалению этой темы/ответа.',
	'wall-action-remove-confirm' => 'Пожалуйста, укажите, почему вы хотите удалить это:',
	'wall-action-remove-thread-confirm-info' => 'Эта тема и ваш комментарий останутся в истории вики.',
	'wall-action-remove-reply-confirm-info' => 'Этот ответ и ваш комментарий останутся в истории вики.',
	'wall-action-remove-confirm-ok' => 'Удалить',
	'wall-action-admin-thread-title' => 'Удалить эту тему',
	'wall-action-admin-reply-title' => 'Удалить этот ответ',
	'wall-action-admin-confirm' => 'Пожалуйста, укажите, почему вы хотите удалить это:',
	'wall-action-admin-thread-confirm-info' => 'Эта тема и ваш комментарий останутся в истории вики.',
	'wall-action-admin-reply-confirm-info' => 'Этот ответ и ваш комментарий останутся в истории вики. Только администраторы смогут просматривать эту тему.',
	'wall-action-admin-confirm-ok' => 'Удалить',
	'wall-action-restore-thread-title' => 'Восстановить эту тему',
	'wall-action-restore-reply-title' => 'Восстановить этот ответ',
	'wall-action-restore-confirm' => 'Пожалуйста, укажите, почему вы хотите восстановить это:',
	'wall-action-restore-confirm-ok' => 'Восстановить',
	'wall-action-rev-thread-title' => 'Пересмотреть удаление этой темы?',
	'wall-action-rev-reply-title' => 'Пересмотреть удаление этого ответа?',
	'wall-action-rev-reply-confirm' => 'Вы уверены, что хотите удалить это сообщение?',
	'wall-action-rev-thread-confirm' => 'Вы уверены, что хотите удалить эту тему и всю историю её изменений из вики? Это действие нельзя будет отменить.',
	'wall-action-rev-confirm-ok' => 'Да, удалить',
	'wall-notifications' => 'Уведомления',
	'wall-notifications-all' => 'Все уведомления',
	'wall-notifications-markasread' => 'Отметить всё, как прочитанное',
	'wall-notifications-markasread-all-wikis' => 'Все викии',
	'wall-notifications-markasread-this-wiki' => 'Эта вики',
	'wall-notifications-empty' => 'Нет уведомлений',
	'wall-notifications-loading' => 'Загрузка уведомлений',
	'wall-notifications-reminder' => 'У вас <span>$1</span> {{PLURAL:$1|непрочитанное уведомление|непрочитанных уведомлений}}',
	'wall-notifications-wall-disabled' => 'Стена обсуждения была отключена на этой вики. Уведомления загрузить невозможно.',
	'wn-user1-reply-you-your-wall' => '$1 ответил на ваше сообщение на стене $2',
	'wn-user2-reply-you-your-wall' => '$1 и $2 ответили на ваше сообщение на вашей стене',
	'wn-user3-reply-you-your-wall' => '$1 и другие ответили на ваше сообщение на вашей стене',
	'wn-user1-reply-self-your-wall' => '$1 ответил на сообщение на вашей стене',
	'wn-user2-reply-self-your-wall' => '$1 и $2 ответили на сообщение на вашей стене',
	'wn-user3-reply-self-your-wall' => '$1 и другие ответили на сообщение на вашей стене',
	'wn-user1-reply-other-your-wall' => '$1 ответил на сообщение $2 на вашей стене',
	'wn-user2-reply-other-your-wall' => '$1 и $2 ответили на сообщение $3 на вашей стене',
	'wn-user3-reply-other-your-wall' => '$1 и другие ответили на сообщение $2 на вашей стене',
	'wn-user1-reply-you-other-wall' => '$1 ответил на ваше сообщение на стене $2',
	'wn-user2-reply-you-other-wall' => '$1 и $2 ответили на ваше сообщение на стене $3',
	'wn-user3-reply-you-other-wall' => '$1 и другие ответили на ваше сообщение на стене $3',
	'wn-user1-reply-self-other-wall' => '$1 ответил на сообщение на стене $2',
	'wn-user2-reply-self-other-wall' => '$1 и $2 ответили на сообщение на стене $3',
	'wn-user3-reply-self-other-wall' => '$1 и другие ответили на сообщение на стене $2',
	'wn-user1-reply-other-other-wall' => '$1 ответил на сообщение $2 на стене $3',
	'wn-user2-reply-other-other-wall' => '$1 и $2 ответили на сообщение $3 на стене $4',
	'wn-user3-reply-other-other-wall' => '$1 и другие ответили на сообщение $2 на стене $3',
	'wn-user1-reply-you-a-wall' => '$1 ответил на ваше сообщение',
	'wn-user2-reply-you-a-wall' => '$1 и $2 ответили на ваше сообщение',
	'wn-user3-reply-you-a-wall' => '$1 и другие ответили на ваше сообщение',
	'wn-user1-reply-self-a-wall' => '$1 ответил на сообщение',
	'wn-user2-reply-self-a-wall' => '$1 и $2 ответили на сообщение',
	'wn-user3-reply-self-a-wall' => '$1 и другие ответили на сообщение',
	'wn-user1-reply-other-a-wall' => '$1 ответил на сообщение $2',
	'wn-user2-reply-other-a-wall' => '$1 и $2 ответили на сообщение $3',
	'wn-user3-reply-other-a-wall' => '$1 и другие ответили на сообщение $3',
	'wn-newmsg-onmywall' => '$1 оставил новое сообщение на вашей стене',
	'wn-newmsg' => 'Вы оставили новое сообщение на стене $1',
	'wn-newmsg-on-followed-wall' => '$1 оставил новое сообщение на стене $2.',
	'wn-admin-thread-deleted' => 'Тема была удалена со стены $1',
	'wn-admin-reply-deleted' => 'Ответ был удалён из темы на стене $1',
	'wn-owner-thread-deleted' => 'Одна из тем на вашей стене была удалена',
	'wn-owner-reply-deleted' => 'На вашей стене из темы был удалён ответ',
	'wall-sorting-newest-threads' => 'Новые темы',
	'wall-sorting-oldest-threads' => 'Старые темы',
	'wall-sorting-newest-replies' => 'Новые ответы',
	'wall-sorting-most-active' => 'Самые активные',
	'wall-sorting-archived' => 'Архив',
	'tog-enotifwallthread' => '...если кто-то ответил на тему на Стене обсуждения, за которой я слежу',
	'tog-enotifmywall' => '...если кто-то оставил новое сообщение на моей Стене обсуждения',
	'wall-deleted-msg-pagetitle' => 'Сообщение удалено',
	'wall-deleted-msg-text' => 'Сообщение, которое вы пытаетесь найти, было удалено.',
	'wall-deleted-msg-return-to' => 'Вернуться на стену участника $1.',
	'wall-deleted-msg-view' => '(Просмотреть/Восстановить)',
	'wall-recentchanges-article-link-new-message' => 'на <a href="$1">стене $2</a>',
	'wall-recentchanges-comment-new-message' => '(новых: "$1")',
	'wall-recentchanges-new-reply' => '(ответ: "$1")',
	'wall-recentchanges-edit' => '(сообщение исправлено)',
	'wall-recentchanges-wall-removed-thread' => 'удалена тема "[[$1|$2]]" на [[$3|стене $4]]',
	'wall-recentchanges-wall-removed-reply' => 'удалён ответ в теме "[[$1|$2]]" на [[$3|стене $4]]',
	'wall-recentchanges-wall-restored-thread' => 'восстановлена тема "[[$1|$2]]" на [[$3|стене $4]]',
	'wall-recentchanges-wall-restored-reply' => 'восстановлен ответ в теме "[[$1|$2]]" на [[$3|стене $4]]',
	'wall-recentchanges-wall-deleted-thread' => 'удалена тема "[[$1|$2]]" на [[$3|стене $4]]',
	'wall-recentchanges-wall-deleted-reply' => 'удалён ответ в теме "[[$1|$2]]" на [[$3|стене $4]]',
	'wall-recentchanges-deleted-reply-title' => 'Ответ на стене обсуждения',
	'wall-recentchanges-namespace-selector-message-wall' => 'Стена обсуждения',
	'wall-recentchanges-wall-group' => 'Тема $1 на <a href="$2">стене $3</a>',
	'wall-recentchanges-wall-history-link' => 'История обсуждения',
	'wall-recentchanges-thread-history-link' => 'История темы',
	'wall-contributions-wall-line' => '$5 ($6 | $7) Тема $8 <a href="$1">$2</a> на <a href="$3">стене $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> на <a href="$3">стене $4</a>',
	'wall-message-not-found' => 'Сообщение не было найдено. Если вы считаете, что произошла ошибка, то свяжитесь с сотрудниками Викия через страницу [[Special:Contact]] и сообщите подробности, чтобы мы могли решить проблему. Спасибо!',
	'wall-message-staff-text' => 'Этот участник является сотрудником Викия',
	'wall-ipballowusertalk' => 'Разрешить этому участнику оставлять сообщение на своей стене, когда он заблокирован',
	'wall-ipbwatchuser' => 'Отслеживать страницу участника и его стену обсуждения',
	'wall-wiki-activity-on' => 'на $1',
	'wall-wiki-activity-wall-owner' => 'Стена $1',
	'wall-removed-thread-undo' => 'Эта тема была удалена. $1',
	'wall-removed-reply-undo' => 'Этот ответ был удалён. $1',
	'wall-removed-reply' => 'Этот ответ был удалён',
	'wall-deleted-thread-undo' => 'Эта тема была удалена. $1',
	'wall-deleted-reply-undo' => 'Этот ответ был удалён. $1',
	'wall-deleted-reply' => 'Этот ответ был удалён',
	'wall-history' => 'История',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'История обсуждения',
	'wall-history-who-involved-wall-title' => 'Кто участвует в этом обсуждении?',
	'wall-history-who-involved-thread-title' => 'Кто участвует в этой теме?',
	'wall-history-thread-created' => '$1 создал $2',
	'wall-history-thread-removed' => '$1 удалил $2',
	'wall-history-thread-restored' => '$1 восстановил $2',
	'wall-history-thread-admin-deleted' => '$1 удалил $2',
	'wall-history-sorting-newest-first' => 'Новые в начало',
	'wall-history-sorting-oldest-first' => 'Старые в начало',
	'wall-history-summary-label' => 'Комментарий',
	'wall-history-rail-wall' => 'стена',
	'wall-history-rail-contribs' => 'вклад',
	'wall-history-rail-block' => 'заблокировать',
	'wall-history-action-view' => 'просмотр',
	'wall-history-action-restore' => 'восстановить',
	'wall-history-action-thread-history' => 'история темы',
	'wall-thread-history-title' => 'история темы',
	'wall-thread-history-thread-created' => '$2 создал тему $1',
	'wall-thread-history-reply-created' => '$1 $2 оставил сообщение',
	'wall-thread-history-thread-removed' => '$1 $2 удалил эту тему',
	'wall-thread-history-reply-removed' => '$1 $2 удалил $3 сообщение $5',
	'wall-thread-history-thread-restored' => '$1 $2 удалил эту тему',
	'wall-thread-history-reply-restored' => '$1 $2 восстановил $3 ответ $5',
	'wall-thread-history-thread-deleted' => '$1 $2 удалил эту тему',
	'wall-thread-history-thread-edited' => '$1 $2 отредактировал $3 сообщение $5',
	'wall-thread-history-reply-edited' => '$1 $2 отредактировал $3 сообщение $5',
	'wall-history-action-restore-reply' => 'восстановить ответ',
	'wall-history-action-restore-thread' => 'восстановить тему',
	'wall-message-not-found-in-db' => 'Мы не смогли найти эту сообщение стены в нашей базе данных, извините.',
	'mail-notification-new-someone' => '$AUTHOR_NAME написал новое сообщение на $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME оставил вам новое сообщение на $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME ответил на ваше сообщение на $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME ответил на сообщение на $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME ответил на сообщение $PARENT_AUTHOR_NAME на $WIKI.',
	'mail-notification-html-greeting' => 'Здравствуйте $1,',
	'mail-notification-html-button' => 'Смотрите обсуждение',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Чтобы узнать о последних событиях на Викия, посетите <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Чтобы настроить уведомления по email, перейдите на страницу <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">личных настроек</a>',
	'mail-notification-body' => 'Hi $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Смотрите обсуждение ($MESSAGE_LINK)
 
Команда Викия

___________________________________________
* Найти помощь и совет можно на Community Central (http://community.wikia.com) и Вики Сообщества (http://ru.community.wikia.com)
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hi $WATCHER,
			<p>$SUBJECT.</p> 
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p> 			
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Смотрите обсуждение</a></p>
			<p>Команда Викия</p>
___________________________________________<br>
* Найти помощь и совет можно на Community Central (http://community.wikia.com) и Вики Сообщества (http://ru.community.wikia.com)
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'prefs-email-wall-v2' => 'Стена обсуждения',
	'tog-enotifwallthread-v2' => 'Отправлять мне email...',
	'tog-enotifmywall-every' => 'о каждом сообщении и ответе',
	'tog-enotifmywall-sincevisited' => 'только о теме, которую я посещал последней',
	'tog-enotifmywall-reminder' => 'с ежедневным напоминанием',
	'tog-enotifmywall-noemail' => 'не отправлять мне эл. письма со Стены обсуждения',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'wall-no-title' => 'Ingen titel',
	'wall-tab-wall-title' => 'Meddelandevägg:$1',
	'wall-message-loadmore' => 'Visa alla $1 {{PLURAL:$1|svar|svar}}',
	'wall-message-wall' => 'Meddelandevägg',
	'wall-message-wall-shorten' => 'vägg',
	'wall-message-unfollow' => 'Sluta följ',
	'wall-message-undoremove' => 'Ångra',
	'wall-message-edited' => '<a href="$3" >Redigerades av</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Min vägg',
	'wall-toolbar-history' => 'Historik',
	'wall-message-notify' => 'Meddela admin',
	'wall-message-remove' => 'Ta bort',
	'wall-message-rev-delete' => 'Revisionsradering',
	'wall-message-elseswall' => '$1s vägg',
	'wall-message-no-permission' => 'Du har inte behörighet att utföra denna åtgärd på meddelandet',
	'wall-thread-removed' => 'Togs bort',
	'wall-thread-deleted' => 'Raderades',
	'wall-default-title' => 'Meddelande från $1',
	'wall-no-title-warning' => '← Du inte angav någon titel',
	'wall-desc' => 'Ersättning av användardiskussionssida',
	'wall-disabled-desc' => 'Funktionalitet av meddelandeväggen för wikis utan väggtillägget',
	'wall-placeholder-topic' => 'Vad handlar detta om?',
	'wall-placeholder-message' => 'Skicka ett nytt meddelande till $1s vägg',
	'wall-placeholder-message-anon' => 'Skicka ett nytt meddelande till denna vägg',
	'wall-placeholder-reply' => 'Skicka ett svar',
	'wall-button-to-preview-comment' => 'Förhandsgranska',
	'wall-button-to-cancel-preview' => 'Redigera',
	'wall-button-to-submit-comment' => 'Skicka',
	'wall-button-to-submit-reply' => 'Svara',
	'wall-button-to-submit-comment-no-topic' => 'Skicka utan en titel',
	'wall-button-save-changes' => 'Spara ändringar',
	'wall-button-cancel-changes' => 'Avbryt',
	'wall-button-done-source' => 'Färdig',
	'wall-message-edit' => 'Redigera',
	'wall-message-more' => 'Mer',
	'wall-message-delete' => 'Radera',
	'wall-message-removed-thread-because' => '$1 tog bort denna tråd eftersom:',
	'wall-message-deleted-thread-because' => '$1 raderade denna tråd eftersom:',
	'wall-message-restore-thread' => 'Återställ tråd',
	'wall-message-removed-reply-because' => '$1 tog bort detta svar eftersom:',
	'wall-message-deleted-reply-because' => '$1 raderade detta svar eftersom:',
	'wall-message-restore-reply' => 'Återställ svar',
	'wall-delete-reason' => 'Användare/administratörsåtgärd',
	'wall-user-talk-page-archive-anchor' => 'Se arkiverad diskussionssida',
	'wall-user-talk-archive-page-title' => 'Arkiv_för_användardiskussion',
	'wall-action-all-confirm-cancel' => 'Avbryt',
	'wall-action-all-confirm-notify' => 'Meddela en administratör',
	'wall-action-remove-reply-title' => 'Ta bort detta svar',
	'wall-action-remove-thread-title' => 'Ta bort denna tråd',
	'wall-confirm-monobook-remove' => 'Berätta för oss varför du vill ta bort detta.

Originalinlägget och din sammanfattning kommer fortfarande att visas i wikins historik.',
	'wall-confirm-monobook-admin' => 'Berätta för oss varför du vill radera detta.

Originalinlägget och din sammanfattning kommer fortfarande att visas i wikins historik.',
	'wall-confirm-monobook-restore' => 'Berätta för oss varför du skulle vilja återställa detta',
	'wall-delete-error-title' => 'Fel',
	'wall-delete-error-content' => 'Meddelandet togs bort tidigare och det finns inte längre.',
	'wall-confirm-monobook-lack-of-reason' => 'Skriv en sammanfattning för att ta bort denna tråd/svar.',
	'wall-action-remove-confirm' => 'Berätta för oss varför du vill ta bort detta:',
	'wall-action-remove-thread-confirm-info' => 'Denna tråd och din sammanfattning kommer fortfarande att visas i wikins historik.',
	'wall-action-remove-reply-confirm-info' => 'Detta svar och din sammanfattning kommer fortfarande att visas i wikins historik.',
	'wall-action-remove-confirm-ok' => 'Ta bort',
	'wall-action-admin-thread-title' => 'Radera denna tråd',
	'wall-action-admin-reply-title' => 'Radera detta svar',
	'wall-action-admin-confirm' => 'Berätta för oss varför du vill ta bort detta:',
	'wall-action-admin-thread-confirm-info' => 'Denna tråd och din sammanfattning kommer fortfarande att visas i wikins historik',
	'wall-action-admin-reply-confirm-info' => 'Denna tråd och din sammanfattning kommer fortfarande att visas i wikins historik. Endast administratörer kommer att kunna se denna tråd.',
	'wall-action-admin-confirm-ok' => 'Radera',
	'wall-action-restore-thread-title' => 'Återställ denna tråd',
	'wall-action-restore-reply-title' => 'Återställ detta svar',
	'wall-action-restore-confirm' => 'Berätta för oss varför du skulle vilja återställa detta:',
	'wall-action-restore-confirm-ok' => 'Återställ',
	'wall-action-rev-thread-title' => 'Revisionsradera denna tråd?',
	'wall-action-rev-reply-title' => 'Revisionsradera detta svar?',
	'wall-action-rev-reply-confirm' => 'Är du säker på att du vill ta bort detta meddelande?',
	'wall-action-rev-thread-confirm' => 'Är du säker på att du vill revisionsradera denna tråd och all dess historik från wikin? Detta kan inte ångras.',
	'wall-action-rev-confirm-ok' => 'Ja, radera',
	'wall-notifications' => 'Meddelanden',
	'wall-notifications-all' => 'Alla meddelanden',
	'wall-notifications-markasread' => 'Markera alla som lästa',
	'wall-notifications-markasread-all-wikis' => 'Alla wikis',
	'wall-notifications-markasread-this-wiki' => 'Denna wiki',
	'wall-notifications-empty' => 'Det finns inga meddelanden',
	'wall-notifications-loading' => 'Läser in meddelanden',
	'wall-notifications-reminder' => 'Du har <span>$1</span> {{PLURAL:$1|oläst meddelande|olästa meddelanden}}',
	'wall-notifications-wall-disabled' => 'Meddelandevägg har inaktiverats på denna wiki. Det gick inte att läsa in meddelanden.',
	'wn-user1-reply-you-your-wall' => '$1 svarade på ditt meddelande på din vägg',
	'wn-user2-reply-you-your-wall' => '$1 och $2 svarade på ditt meddelande på din vägg',
	'wn-user3-reply-you-your-wall' => '$1 och andra svarade på ditt meddelande på din vägg',
	'wn-user1-reply-self-your-wall' => '$1 svarade på ett meddelande på din vägg',
	'wn-user2-reply-self-your-wall' => '$1 och $2 svarade på ett meddelande på din vägg',
	'wn-user3-reply-self-your-wall' => '$1 och andra svarade på ett meddelande på din vägg',
	'wn-user1-reply-other-your-wall' => '$1 svarade på $2s meddelande på din vägg',
	'wn-user2-reply-other-your-wall' => '$1 och $2 svarade på $3s meddelande på din vägg',
	'wn-user3-reply-other-your-wall' => '$1 och andra svarade på $2s meddelande på din vägg',
	'wn-user1-reply-you-other-wall' => '$1 svarade på ditt meddelande på $2s vägg',
	'wn-user2-reply-you-other-wall' => '$1 och $2 svarade på ditt meddelande på $3s vägg',
	'wn-user3-reply-you-other-wall' => '$1 och andra svarade på ditt meddelande på $3s vägg',
	'wn-user1-reply-self-other-wall' => '$1 svarade på ett meddelande på $2s vägg',
	'wn-user2-reply-self-other-wall' => '$1 och $2 svarade på ett meddelande på $3s vägg',
	'wn-user3-reply-self-other-wall' => '$1 och andra svarade på ett meddelande på $2s vägg',
	'wn-user1-reply-other-other-wall' => '$1 svarade på $2s meddelande på $3s vägg',
	'wn-user2-reply-other-other-wall' => '$1 och $2 svarade på $3s meddelande på $4s vägg',
	'wn-user3-reply-other-other-wall' => '$1 och andra svarade på $2s meddelande på $3s vägg',
	'wn-user1-reply-you-a-wall' => '$1 svarade på ditt meddelande',
	'wn-user2-reply-you-a-wall' => '$1 och $2 svarade på ditt meddelande',
	'wn-user3-reply-you-a-wall' => '$1 och andra svarade på ditt meddelande',
	'wn-user1-reply-self-a-wall' => '$1 svarade på ett meddelande',
	'wn-user2-reply-self-a-wall' => '$1 och $2 svarade på ett meddelande',
	'wn-user3-reply-self-a-wall' => '$1 och andra svarade på ett meddelande',
	'wn-user1-reply-other-a-wall' => '$1 svarade på $2s meddelande',
	'wn-user2-reply-other-a-wall' => '$1 och $2 svarade på $3s meddelande',
	'wn-user3-reply-other-a-wall' => '$1 och andra svarade på $3s meddelande',
	'wn-newmsg-onmywall' => '$1 lämnade ett nytt meddelande på din vägg',
	'wn-newmsg' => 'Du lämnade ett nytt meddelande på $1s vägg',
	'wn-newmsg-on-followed-wall' => '$1 lämnade ett nytt meddelande på $2s vägg.',
	'wn-admin-thread-deleted' => 'Tråd togs bort från $1s vägg',
	'wn-admin-reply-deleted' => 'Svar togs bort från tråden på $1s vägg',
	'wn-owner-thread-deleted' => 'Tråd togs bort från din vägg',
	'wn-owner-reply-deleted' => 'Svar togs bort från tråden på din vägg',
	'wall-sorting-newest-threads' => 'Nyaste trådarna',
	'wall-sorting-oldest-threads' => 'Äldsta trådarna',
	'wall-sorting-newest-replies' => 'Senaste svaren',
	'wall-sorting-most-active' => 'Mest aktiva',
	'wall-sorting-archived' => 'Arkiverade',
	'tog-enotifwallthread' => '…någon svarar på en meddelandeväggstråd som jag följer',
	'tog-enotifmywall' => '...någon skickar ett nytt meddelande på min vägg',
	'wall-deleted-msg-pagetitle' => 'Meddelandet togs bort',
	'wall-deleted-msg-text' => 'Meddelande som du försöker komma åt har tagits bort.',
	'wall-deleted-msg-return-to' => 'Tillbaka till $1s vägg.',
	'wall-deleted-msg-view' => '(Visa/återställ)',
	'wall-recentchanges-article-link-new-message' => 'på <a href="$1">$2s vägg</a>',
	'wall-recentchanges-comment-new-message' => '(nya: "$1")',
	'wall-recentchanges-new-reply' => '(svar: "$1")',
	'wall-recentchanges-edit' => '(redigerat meddelande)',
	'wall-recentchanges-wall-removed-thread' => 'tog bort tråden "[[$1|$2]]" från [[$3|$4s vägg]]',
	'wall-recentchanges-wall-removed-reply' => 'tog bort svar från "[[$1|$2]]" från [[$3|$4s vägg]]',
	'wall-recentchanges-wall-restored-thread' => 'återställde tråden "[[$1|$2]]" på [[$3|$4s vägg]]',
	'wall-recentchanges-wall-restored-reply' => 'återställde svaret på "[[$1|$2]]" på [[$3|$4s vägg]]',
	'wall-recentchanges-wall-deleted-thread' => 'tog bort tråden "[[$1|$2]]" från [[$3|$4s vägg]]',
	'wall-recentchanges-wall-deleted-reply' => 'tog bort svar från "[[$1|$2]]" från [[$3|$4s vägg]]',
	'wall-recentchanges-deleted-reply-title' => 'Ett svar på meddelandeväggen',
	'wall-recentchanges-namespace-selector-message-wall' => 'Meddelandevägg',
	'wall-recentchanges-wall-group' => '$1 på <a href="$2">$3s vägg</a>',
	'wall-recentchanges-wall-history-link' => 'vägghistorik',
	'wall-recentchanges-thread-history-link' => 'trådhistorik',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> på <a href="$3">$4s vägg</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> på <a href="$3">$4s vägg</a>',
	'wall-message-not-found' => 'Detta meddelandet kunde inte hittas. Om du ser felet, var god kontakta Wikia på [[Special:Contact]] och ge så mycket information som möjligt om hur detta fel kan återges. Tack!',
	'wall-message-staff-text' => 'Denna användare är medlem i Wikias personal',
	'wall-ipballowusertalk' => 'Tillåt denna användare att göra inlägg på sin eget meddelandevägg när den är blockerad',
	'wall-ipbwatchuser' => 'Bevaka denna användares profil och följ dennes meddelandevägg',
	'wall-wiki-activity-on' => 'på $1',
	'wall-wiki-activity-wall-owner' => '$1s vägg',
	'wall-removed-thread-undo' => 'Denna tråd har tagits bort. $1',
	'wall-removed-reply-undo' => 'Detta svar har tagits bort. $1',
	'wall-removed-reply' => 'Detta svar har tagits bort',
	'wall-deleted-thread-undo' => 'Denna tråd har raderats. $1',
	'wall-deleted-reply-undo' => 'Detta svar har raderats. $1',
	'wall-deleted-reply' => 'Detta svar har raderats',
	'wall-history' => 'Historik',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'vägghistorik',
	'wall-history-who-involved-wall-title' => 'Vem är inblandade på denna vägg?',
	'wall-history-who-involved-thread-title' => 'Vem är inblandade i denna tråd?',
	'wall-history-thread-created' => '$1 skapades av $2',
	'wall-history-thread-removed' => '$1 togs bort $2',
	'wall-history-thread-restored' => '$1 återställdes av $2',
	'wall-history-thread-admin-deleted' => '$1 raderades av $2',
	'wall-history-sorting-newest-first' => 'Senaste först',
	'wall-history-sorting-oldest-first' => 'Äldst först',
	'wall-history-summary-label' => 'Sammanfattning',
	'wall-history-rail-wall' => 'vägg',
	'wall-history-rail-contribs' => 'bidrag',
	'wall-history-rail-block' => 'blockeringar',
	'wall-history-action-view' => 'visa',
	'wall-history-action-restore' => 'återställ',
	'wall-history-action-thread-history' => 'trådhistorik',
	'wall-thread-history-title' => 'trådhistorik',
	'wall-thread-history-thread-created' => '$1 $2 skapade denna tråd',
	'wall-thread-history-reply-created' => '$1 $2 lämnade ett svar',
	'wall-thread-history-thread-removed' => '$1 $2 tog bort denna tråd',
	'wall-thread-history-reply-removed' => '$1 $2 tog bort $3s svar $5',
	'wall-thread-history-thread-restored' => '$1 $2 återställde denna tråd',
	'wall-thread-history-reply-restored' => '$1 $2 återställde $3s svar $5',
	'wall-thread-history-thread-deleted' => '$1 $2 raderade denna tråd',
	'wall-thread-history-thread-edited' => '$1 $2 redigerade $3s meddelande $5',
	'wall-thread-history-reply-edited' => '$1 $2 redigerade $3s meddelande $5',
	'wall-history-action-restore-reply' => 'återställ svar',
	'wall-history-action-restore-thread' => 'återställ tråd',
	'wall-message-not-found-in-db' => 'Vi kunde inte hitta denna meddelandevägg i vår databas, beklagar.',
	'mail-notification-new-someone' => '$AUTHOR_NAME skrev ett nytt meddelande på $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME lämnade ett nytt meddelande till dig på $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME svarade på ditt meddelande på $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME svarade på ett meddelande på $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME svarade på $PARENT_AUTHOR_NAMEs meddelande på $WIKI.',
	'mail-notification-html-greeting' => 'Hej $1,',
	'mail-notification-html-button' => 'Se konversationen',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'För att kolla in de senaste händelserna på Wikia, besök <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vill du kontrollera vilka e-postmeddelanden du får? Gå till dina <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Inställningar</a>',
	'mail-notification-body' => 'Hej $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Se konversationen ($MESSAGE_LINK)
 
Wikia-teamet

___________________________________________
* Hitta hjälp och råd på Gemenskapscentralen: http://community.wikia.com
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra
dina e-postinställningar här: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hej $WATCHER,
			<p>$SUBJECT.</p> 
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p> 			
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Se konversationen</a></p>
			<p>Wikia-teamet</p>
___________________________________________<br />
* Hitta hjälp och råd på Gemenskapscentralen: http://community.wikia.com
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra
dina e-postinställningar här: http://community.wikia.com/Special:Preferences',
	'prefs-email-wall-v2' => 'Meddelandevägg',
	'tog-enotifwallthread-v2' => 'Skicka e-post till mig...',
	'tog-enotifmywall-every' => 'För varje meddelande & svar',
	'tog-enotifmywall-sincevisited' => 'En gång per tråd sedan mitt senaste besök',
	'tog-enotifmywall-reminder' => 'Med en daglig påminnelse via e-post',
	'tog-enotifmywall-noemail' => 'Aldrig. Skicka inte någon e-post om meddelandeväggen',
	'wallshowsource-toggle-v2' => 'Aktivera alternativet {{int:user-action-menu-view-source}} på inlägg i meddelandeväggen',
	'wallshowsource-toggle' => 'Aktivera {{int:user-action-menu-view-source}} på inlägg i meddelandeväggen',
	'walldelete-toggle' => 'Aktivera revisionsradering på inlägg i meddelandeväggen',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'wall-no-title' => 'Không có tiêu đề',
	'wall-tab-wall-title' => 'Tường tin nhắn:$1',
	'wall-message-loadmore' => 'Xem tất cả $1 {{PLURAL:$1|hồi âm|hồi âm}}',
	'wall-message-wall' => 'Tường tin nhắn',
	'wall-message-wall-shorten' => 'tường',
	'wall-message-unfollow' => 'Không theo dõi',
	'wall-message-undoremove' => 'Hoàn tác',
	'wall-message-edited' => '<a href="$3" >Sửa đổi bởi</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'Tường của tôi',
	'wall-toolbar-history' => 'Lịch sử',
	'wall-message-notify' => 'Thông báo cho bảo quản viên',
	'wall-message-remove' => 'Dời bỏ',
	'wall-message-rev-delete' => 'Bản đã xóa',
	'wall-message-elseswall' => 'tường của $1',
	'wall-message-no-permission' => 'Bạn không có quyền để thực hiện thao tác này trên tin nhắn',
	'wall-thread-removed' => 'Đã dời bỏ',
	'wall-thread-deleted' => 'Đã xóa',
	'wall-default-title' => 'Tin nhắn từ $1',
	'wall-no-title-warning' => '← Bạn chưa xác định bất kỳ tiêu đề nào',
	'wall-desc' => 'Thay thế trang Thảo luận Thành viên',
	'wall-disabled-desc' => 'Tính năng Tường tin nhắn cho những wiki không có phần tường mở rộng',
	'wall-placeholder-topic' => 'Tin nhắn này về vấn đề gì?',
	'wall-placeholder-message' => 'Gửi một tin nhắn mới đến tường của $1',
	'wall-placeholder-message-anon' => 'Gửi một tin nhắn mới đến tường này',
	'wall-placeholder-reply' => 'Viết trả lời',
	'wall-button-to-preview-comment' => 'Xem thử',
	'wall-button-to-cancel-preview' => 'Sửa đổi',
	'wall-button-to-submit-comment' => 'Gửi',
	'wall-button-to-submit-reply' => 'Trả lời',
	'wall-button-to-submit-comment-no-topic' => 'Gửi và bỏ qua tiêu đề',
	'wall-button-save-changes' => 'Lưu các thay đổi',
	'wall-button-cancel-changes' => 'Hủy bỏ',
	'wall-button-done-source' => 'Đã xong',
	'wall-message-edit' => 'Sửa đổi',
	'wall-message-more' => 'Nhiều hơn',
	'wall-message-delete' => 'Xóa',
	'wall-message-removed-thread-because' => '$1 dời bỏ luồng này bởi vì:',
	'wall-message-deleted-thread-because' => '$1 đã xóa luồng này bởi vì:',
	'wall-message-restore-thread' => 'Khôi phục Luồng',
	'wall-message-removed-reply-because' => '$1 đã dời bỏ hồi âm này bởi vì:',
	'wall-message-deleted-reply-because' => '$1 đã xóa hồi âm này bởi vì:',
	'wall-message-restore-reply' => 'Khôi phục lại hồi âm',
	'wall-delete-reason' => 'Thao tác Thành viên/bảo quản viên',
	'wall-user-talk-page-archive-anchor' => 'Xem thảo luận lưu trữ',
	'wall-user-talk-archive-page-title' => 'Lưu_Thảo luận_Thành_viên',
	'wall-action-all-confirm-cancel' => 'Hủy bỏ',
	'wall-action-all-confirm-notify' => 'Thông báo cho một bảo quản viên',
	'wall-action-remove-reply-title' => 'Dời bỏ hồi âm này',
	'wall-action-remove-thread-title' => 'Dời bỏ luồng này',
	'wall-confirm-monobook-remove' => 'Xin vui lòng cho chúng tôi biết lý do tại sao bạn muốn dời bỏ điều này. 

Các bản gốc và tóm tắt của bạn vẫn sẽ xuất hiện trong lịch sử của wiki.',
	'wall-confirm-monobook-admin' => 'Xin vui lòng cho chúng tôi biết lý do tại sao bạn muốn xóa bỏ điều này. 

Các bản gốc và tóm tắt của bạn vẫn sẽ xuất hiện trong lịch sử của wiki.',
	'wall-confirm-monobook-restore' => 'Xin vui lòng cho chúng tôi biết lý do tại sao bạn muốn khôi phục lại tin nhắn này',
	'wall-delete-error-title' => 'Lỗi',
	'wall-delete-error-content' => 'Tin nhắn đã bị xóa bỏ trước đó và nó không còn tồn tại.',
	'wall-confirm-monobook-lack-of-reason' => 'Vui lòng cung cấp một dòng tóm tắt cho việc loại bỏ luồng/hồi âm này.',
	'wall-action-remove-confirm' => 'Xin vui lòng cho chúng tôi biết lý do tại sao bạn muốn loại bỏ điều này:',
	'wall-action-remove-thread-confirm-info' => 'Luồng này và tóm tắt của bạn sẽ vẫn xuất hiện trong lịch sử của wiki.',
	'wall-action-remove-reply-confirm-info' => 'Hồi âm này và tóm tắt của bạn vẫn sẽ xuất hiện trong lịch sử của wiki.',
	'wall-action-remove-confirm-ok' => 'Dời bỏ',
	'wall-action-admin-thread-title' => 'Xóa luồng này',
	'wall-action-admin-reply-title' => 'Xóa hồi âm này',
	'wall-action-admin-confirm' => 'Xin vui lòng cho chúng tôi biết lý do tại sao bạn muốn xóa bỏ điều này:',
	'wall-action-admin-thread-confirm-info' => 'Luồng này và tóm tắt của bạn sẽ vẫn xuất hiện trong lịch sử của wiki.',
	'wall-action-admin-reply-confirm-info' => 'Luồng này và tóm tắt của bạn vẫn sẽ xuất hiện trong lịch sử của wiki. Chỉ có bảo quản viên mới có thể xem luồng này.',
	'wall-action-admin-confirm-ok' => 'Xóa',
	'wall-action-restore-thread-title' => 'Khôi phục luồng này',
	'wall-action-restore-reply-title' => 'Khôi phục hồi âm này',
	'wall-action-restore-confirm' => 'Xin vui lòng cho chúng tôi biết lý do tại sao bạn muốn khôi phục lại điều này:',
	'wall-action-restore-confirm-ok' => 'Khôi phục',
	'wall-action-rev-reply-confirm' => 'Bạn có chắc bạn muốn xóa tin nhắn này không?',
	'wall-action-rev-thread-confirm' => 'Bạn có chắc bạn muốn xóa luồng này và tất cả lịch sử của nó từ wiki? Điều này không thể hoàn tác được.',
	'wall-action-rev-confirm-ok' => 'Vâng, xóa bỏ',
	'wall-notifications' => 'Thông điệp',
	'wall-notifications-all' => 'Mọi Tin nhắn',
	'wall-notifications-markasread' => 'Đánh dấu đọc tất cả',
	'wall-notifications-markasread-all-wikis' => 'Tất cả wiki',
	'wall-notifications-markasread-this-wiki' => 'Wiki này',
	'wall-notifications-empty' => 'Không có tin nhắn nào',
	'wall-notifications-loading' => 'Tải tin nhắn',
	'wall-notifications-reminder' => 'Bạn có <span>$1</span> {{PLURAL:$1|tin nhắn|tin nhắn}} chưa đọc',
	'wall-notifications-wall-disabled' => 'Tường tin nhắn đã bị vô hiệu hóa trên wiki này. Không thể tải được tin nhắn.',
	'wn-user1-reply-you-your-wall' => '$1 trả lời tin nhắn của bạn trên tường của bạn',
	'wn-user2-reply-you-your-wall' => '$1 và $2 trả lời tin nhắn của bạn trên tường của bạn',
	'wn-user3-reply-you-your-wall' => '$1 và những người khác trả lời tin nhắn của bạn trên tường của bạn',
	'wn-user1-reply-self-your-wall' => '$1 trả lời một tin nhắn trên tường của bạn',
	'wn-user2-reply-self-your-wall' => '$1 và $2 trả lời một tin nhắn trên tường của bạn',
	'wn-user3-reply-self-your-wall' => '$1 và những người khác trả lời một tin nhắn trên tường của bạn',
	'wn-user1-reply-other-your-wall' => '$1 trả lời tin nhắn của $2 trên tường của bạn',
	'wn-user2-reply-other-your-wall' => '$1 và $2 trả lời tin nhắn của $3 trên tường của bạn',
	'wn-user3-reply-other-your-wall' => '$1 và những người khác trả lời tin nhắn của $2 trên tường của bạn',
	'wn-user1-reply-you-other-wall' => '$1 trả lời tin nhắn của bạn trên tường của $2',
	'wn-user2-reply-you-other-wall' => '$1 và $2 trả lời tin nhắn của bạn trên tường của $3',
	'wn-user3-reply-you-other-wall' => '$1 và những người khác trả lời tin nhắn của bạn trên tường của $3',
	'wn-user1-reply-self-other-wall' => '$1 trả lời một tin nhắn trên tường của $2',
	'wn-user2-reply-self-other-wall' => '$1 và $2 trả lời một tin nhắn trên tường của $3',
	'wn-user3-reply-self-other-wall' => '$1 và những người khác trả lời một tin nhắn trên tường của $2',
	'wn-user1-reply-other-other-wall' => '$1 trả lời tin nhắn của $2 trên tường của $3',
	'wn-user2-reply-other-other-wall' => '$1 và $2 trả lời tin nhắn của $3 trên tường của $4',
	'wn-user3-reply-other-other-wall' => '$1 và những người khác trả lời tin nhắn của $2 trên tường của $3',
	'wn-user1-reply-you-a-wall' => '$1 trả lời tin nhắn của bạn',
	'wn-user2-reply-you-a-wall' => '$1 và $2 trả lời tin nhắn của bạn',
	'wn-user3-reply-you-a-wall' => '$1 và những người khác trả lời tin nhắn của bạn',
	'wn-user1-reply-self-a-wall' => '$1 trả lời một tin nhắn',
	'wn-user2-reply-self-a-wall' => '$1 và $2 trả lời một tin nhắn',
	'wn-user3-reply-self-a-wall' => '$1 và những người khác trả lời một tin nhắn',
	'wn-user1-reply-other-a-wall' => '$1 trả lời tin nhắn của $2',
	'wn-user2-reply-other-a-wall' => '$1 và $2 trả lời tin nhắn của $3',
	'wn-user3-reply-other-a-wall' => '$1 và những người khác trả lời tin nhắn của $3',
	'wn-newmsg-onmywall' => '$1 đã để lại một tin nhắn mới trên tường của bạn',
	'wn-newmsg' => 'Bạn đã để lại một tin nhắn mới trên tường của $1',
	'wn-newmsg-on-followed-wall' => '$1 đã để lại một tin nhắn mới trên tường của $2.',
	'wn-admin-thread-deleted' => 'Luồng đã gỡ bỏ khỏi tường của $1',
	'wn-admin-reply-deleted' => 'Trả lời đã gỡ bỏ từ luồng trên tường của $1',
	'wn-owner-thread-deleted' => 'Luồng đã gỡ bỏ từ tường của bạn',
	'wn-owner-reply-deleted' => 'Trả lời đã gỡ bỏ từ luồng trên tường của bạn',
	'wall-sorting-newest-threads' => 'Luồng mới nhất',
	'wall-sorting-oldest-threads' => 'Luồng cũ nhất',
	'wall-sorting-newest-replies' => 'Hồi âm mới nhất',
	'wall-sorting-most-active' => 'Tích cực nhất',
	'wall-sorting-archived' => 'Lưu trữ',
	'tog-enotifwallthread' => '…một ai đó trả lời vào luồng của Tường tin nhắn mà tôi theo dõi',
	'tog-enotifmywall' => '…một ai đó gửi tin nhắn mới trên tường của tôi',
	'wall-deleted-msg-pagetitle' => 'Tin nhắn đã xóa',
	'wall-deleted-msg-text' => 'Tin nhắn mà bạn cố gắng xem đã bị xóa',
	'wall-deleted-msg-return-to' => 'Trở về tường của $1.',
	'wall-deleted-msg-view' => '(Xem/Khôi phục)',
	'wall-recentchanges-article-link-new-message' => 'trên <a href="$1">tường của $2</a>',
	'wall-recentchanges-comment-new-message' => '(mới: "$1")',
	'wall-recentchanges-new-reply' => '(trả lời: "$1")',
	'wall-recentchanges-edit' => '(sửa đổi tin nhắn)',
	'wall-recentchanges-wall-removed-thread' => 'dời bỏ luồng "[[$1|$2]]" từ [[$3|tường của $4]]',
	'wall-recentchanges-wall-removed-reply' => 'dời bỏ trả lời từ "[[$1|$2]]" từ [[$3|tường của $4]]',
	'wall-recentchanges-wall-restored-thread' => 'khôi phục luồng "[[$1|$2]]" từ [[$3|tường của $4]]',
	'wall-recentchanges-wall-restored-reply' => 'khôi phục trả lời trên "[[$1|$2]]" trên [[$3|tường của $4]]',
	'wall-recentchanges-wall-deleted-thread' => 'xóa luồng "[[$1|$2]]" từ [[$3|tường của $4]]',
	'wall-recentchanges-wall-deleted-reply' => 'xóa bỏ trả lời từ "[[$1|$2]]" từ [[$3|tường của $4]]',
	'wall-recentchanges-deleted-reply-title' => 'Một hồi âm trên tường tin nhắn',
	'wall-recentchanges-namespace-selector-message-wall' => 'Tường tin nhắn',
	'wall-recentchanges-wall-group' => '$1 trên <a href="$2">tường của $3</a>',
	'wall-recentchanges-wall-history-link' => 'lịch sử tường',
	'wall-recentchanges-thread-history-link' => 'lịch sử luồng',
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> trên <a href="$3">tường của $4</a>',
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> trên <a href="$3">tường của $4</a>',
	'wall-message-not-found' => 'Tin nhắn này không thể tìm thấy. Nếu bạn thấy lỗi này, xin vui lòng liên hệ với Wikia tại [[Special:Contact]] và cung cấp càng nhiều chi tiết càng tốt về lỗi này sẽ được sửa chữa như thế nào. Cảm ơn bạn!',
	'wall-message-staff-text' => 'Người dùng này là một nhân viên Wikia',
	'wall-ipballowusertalk' => 'Cho phép người dùng này viết trên Tường tin nhắn của họ trong khi bị khóa',
	'wall-ipbwatchuser' => 'Xem hồ sơ của người dùng này và làm theo Tường tin nhắn của họ',
	'wall-wiki-activity-on' => 'trên $1',
	'wall-wiki-activity-wall-owner' => 'tường của $1',
	'wall-removed-thread-undo' => 'Luồng này đã bị gỡ bỏ. $1',
	'wall-removed-reply-undo' => 'Hồi âm này đã bị gỡ bỏ. $1',
	'wall-removed-reply' => 'Hồi âm này đã bị dời bỏ',
	'wall-deleted-thread-undo' => 'Luồng này đã bị xóa. $1',
	'wall-deleted-reply-undo' => 'Hồi âm này đã bị xóa. $1',
	'wall-deleted-reply' => 'Hồi âm này đã bị gỡ bỏ',
	'wall-history' => 'Lịch sử',
	'wall-history-username-full' => '<a href="$3">$1</a> <a href="$3" class="username"><small>$2</small></a>',
	'wall-history-username-short' => '<a href="$2">$1</a>',
	'wall-history-title' => 'lịch sử tường',
	'wall-history-who-involved-wall-title' => 'Ai đã tham gia trên tường này?',
	'wall-history-who-involved-thread-title' => 'Ai đã tham gia trong luồng này?',
	'wall-history-thread-created' => '$1 tạo bởi $2',
	'wall-history-thread-removed' => '$1 dời bỏ bởi $2',
	'wall-history-thread-restored' => '$1 khôi phục bởi $2',
	'wall-history-thread-admin-deleted' => '$1 xóa bởi $2',
	'wall-history-sorting-newest-first' => 'Mới nhất trước',
	'wall-history-sorting-oldest-first' => 'Cũ nhất trước',
	'wall-history-summary-label' => 'Tóm tắt',
	'wall-history-rail-wall' => 'tường',
	'wall-history-rail-contribs' => 'đóng góp',
	'wall-history-rail-block' => 'cấm',
	'wall-history-action-view' => 'xem',
	'wall-history-action-restore' => 'khôi phục',
	'wall-history-action-thread-history' => 'lịch sử luồng',
	'wall-thread-history-title' => 'lịch sử luồng',
	'wall-thread-history-thread-created' => '$1 $2 tạo ra luồng này',
	'wall-thread-history-reply-created' => '$1 $2 để lại hồi âm',
	'wall-thread-history-thread-removed' => '$1 $2 dời bỏ luồng này',
	'wall-thread-history-reply-removed' => '$1 $2 dời bỏ hồi âm của $3 $5',
	'wall-thread-history-thread-restored' => '$1 $2 khôi phục luồng này',
	'wall-thread-history-reply-restored' => '$1 $2 khôi phục hồi âm của $3 $5',
	'wall-thread-history-thread-deleted' => '$1 $2 xóa luồng này',
	'wall-thread-history-thread-edited' => '$1 $2 sửa đổi tin nhắn của $3 $5',
	'wall-thread-history-reply-edited' => '$1 $2 sửa đổi tin nhắn của $3 $5',
	'wall-history-action-restore-reply' => 'khôi phục trả lời',
	'wall-history-action-restore-thread' => 'khôi phục luồng',
	'wall-message-not-found-in-db' => 'Chúng tôi không thể tìm thấy tường tin nhắn này trong cơ sở dữ liệu của chúng tôi, xin lỗi.',
	'mail-notification-new-someone' => '$AUTHOR_NAME viết một tin nhắn mới trên $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME để lại cho bạn một tin nhắn mới trên $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME trả lời tin nhắn của bạn trên $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME trả lời một tin nhắn trên $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME trả lời tin nhắn của $PARENT_AUTHOR_NAME trên $WIKI.',
	'mail-notification-html-greeting' => 'Chào $1,',
	'mail-notification-html-button' => 'Xem cuộc hội thoại',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line1' => 'Để kiểm tra những diễn biến và thay đổi mới nhất về Wikia, hãy truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>
Để nhận được sự hỗ trợ cho ngôn ngữ của bạn, truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://vi.wikia.com">vi.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Muốn kiểm soát những email mà bạn nhận được? <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Tùy chọn</a>',
	'mail-notification-body' => 'Xin chào $WATCHER,
	
$SUBJECT
			
$METATITLE
		
$MESSAGE_NO_HTML
			
-- $AUTHOR

Xem cuộc hội thoại($MESSAGE_LINK)
 
Wikia Team

___________________________________________
* Tìm kiếm sự trợ giúp và lời khuyên tại Cộng đồng Trung tâm: http://community.wikia.com
* Nhận được sự hỗ trợ từ ngôn ngữ của bạn tại Wikia Tiếng Việt: http://vi.wikia.com
* Muốn nhận ít thư thông báo hơn từ chúng tôi? Bạn có thể bỏ chọn hoặc thay đổi
 tuỳ chọn thư điện tử của bạn ở đây: http://vi.wikia.com/wiki/Đặc_biệt:Tùy_chọn',
	'mail-notification-body-HTML' => 'Chào $WATCHER,
			<p>$SUBJECT.</p> 
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p> 			
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Xem cuộc hội thoại</a></p>
			<p>Wikia Team</p>
___________________________________________<br />
* Tìm kiếm sự trợ giúp và lời khuyên tại Cộng đồng Trung tâm: http://community.wikia.com
* Nhận được sự hỗ trợ từ ngôn ngữ của bạn tại Wikia Tiếng Việt: http://vi.wikia.com
* Muốn nhận ít thư thông báo hơn từ chúng tôi? Bạn có thể bỏ chọn hoặc thay đổi
 tuỳ chọn thư điện tử của bạn ở đây: http://vi.wikia.com/wiki/Đặc_biệt:Tùy_chọn',
	'prefs-email-wall-v2' => 'Tường tin nhắn',
	'tog-enotifwallthread-v2' => 'Gửi thư điện tử cho tôi…',
	'tog-enotifmywall-every' => 'Cho mỗi tin nhắn & hồi âm',
	'tog-enotifmywall-sincevisited' => 'Mỗi lần một luồng kể từ lần cuối cùng tôi đăng nhập',
	'tog-enotifmywall-reminder' => 'Với thư điện tử thông báo hằng ngày',
	'tog-enotifmywall-noemail' => 'Không. Đừng gửi cho tôi bất kỳ email nào về Tường tin nhắn',
	'wallshowsource-toggle-v2' => 'Kích hoạt {{int:user-action-menu-view-source}} tùy chọn trên những bài viết Tường tin nhắn',
	'wallshowsource-toggle' => 'Kích hoạt {{int:user-action-menu-view-source}} trên những bài viết Tường tin nhắn',
);

