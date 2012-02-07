<?php 

$messages = array();

$messages['en'] = array( 
	'wall-no-title' => 'No title',
	'wall-message-loadmore' => 'View all $1 replies', // needs PLURAL support
	'wall-message-wall' => 'Message Wall',
	'wall-message-wall-shorten' => 'wall',
	'wall-message-unfollow' => 'Unfollow', // assuming this has the same context and meaning as Unfollow for any other case, why isn't that msg re-used? 
	'wall-message-following' => 'Following', // ditto
	'wall-message-follow' => 'Follow', // ditto

	'wall-message-undoremove' => 'Undo',
	'wall-message-edited' => '<a href="$3" >Edited by</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'My wall',
	'wall-toolbar-history' => 'History',
	
	'wall-message-remove-notify' => 'Notify admin',
	'wall-message-delete-notify' => 'Notify admin', // this message is repeated -- why? is there a difference in context? could we not have one "wall-message-notify"?
	'wall-message-remove' => 'Remove',
	'wall-message-rev-delete' => 'Revision delete',

	'wall-message-elseswall' => "$1's wall", // needs GENDER support
	'wall-message-no-permission' => 'You don\'t have permissions to perfom this action on the message',
	
	'wall-thread-removed' => 'Removed',
	'wall-thread-deleted' => 'Deleted',

	'wall-default-title' => 'Message from', // @FIXME user name should be a parameter in the message 
	'wall-no-title-warning' => '&larr; You did not specify any title', // entity should be UTF8 character instead
	'wall-desc' => 'User talk page replacement',
	'wall-disabled-desc' => 'Message Wall functionality for pages without wall extension', // pages? did you mean "wikis"?
	'wall-placeholder-topic' => 'What\'s this about?',
	'wall-placeholder-message' => "Post a new message to $1's wall", // needs GENDER support
	'wall-placeholder-message-anon' => "Post a new message to this wall",
	'wall-placeholder-reply' => "Post a reply",
	'wall-button-to-preview-comment' => "Preview",
	'wall-button-to-cancel-preview' => "Edit",
	'wall-button-to-submit-comment' => "Post",
	'wall-button-to-submit-reply' => "Reply",
	'wall-button-to-submit-comment-no-topic' => "Post without title", // is this correct English? "with no title" or "without a title", perhaps?
	'wall-button-save-changes' => 'Save changes',
	'wall-button-cancel-changes' => 'Cancel',
	'wall-button-done-source' => 'Done',
	'wall-message-edit' => "Edit",
	'wall-message-more' => 'More', 
	'wall-message-delete' => "Delete",
	'wall-message-remove' => "Remove",
	'wall-message-removed-thread-because' => "$1 removed this thread because:", // needs gender support
	'wall-message-deleted-thread-because' => "$1 deleted this thread because:", // needs gender support
	'wall-message-restore-thread' => "Restore Thread",
	'wall-message-removed-reply-because' => "$1 removed this reply because:", // needs gender support
	'wall-message-deleted-reply-because' => "$1 deleted this reply because:", // needs gender support, patchwork, reason should be a parameter
	'wall-message-restore-reply' => "Restore Reply",
	'wall-delete-reason' => "User/admin action",
	'wall-user-talk-page-archive-anchor' => 'See archived talk page',
	'wall-user-talk-archive-page-title' => 'User_talk_archive', // why the underscores?

	'wall-action-all-confirm-cancel' => 'Cancel',
	'wall-action-all-confirm-notify' => 'Notify an admin', // again, this seems like a duplicate of the message(s) above, is the context different?

	'wall-action-remove-reply-title' => 'Remove this reply',
	'wall-action-remove-thread-title' => 'Remove this thread',

	'wall-confirm-monobook-remove' => "Please tell us why you would like to remove this. \n\nThe original post and your summary will still appear in the wiki's history. \n", // do not end messages in new-line!
	'wall-confirm-monobook-admin' => "Please tell us why you would like to delete this. \n\nThe original post and your summary will still appear in the wiki's history. \n", // do not end messages in new-line!
	'wall-confirm-monobook-restore' => "Please tell us why you would like to restore this \n", // do not end messages in new-line!
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
	
	'wn-user1-reply-you-your-wall' => '$1 replied to your message on your wall', // needs gender support
	'wn-user2-reply-you-your-wall' => '$1 and $2 replied to your message on your wall', // needs gender support
	'wn-user3-reply-you-your-wall' => '$1 and others replied to your message on your wall', // needs gender support
	'wn-user1-reply-self-your-wall' => '$1 replied to a message on your wall', // needs gender support
	'wn-user2-reply-self-your-wall' => '$1 and $2 replied to a message on your wall',
	'wn-user3-reply-self-your-wall' => '$1 and others replied to a message on your wall',
	'wn-user1-reply-other-your-wall' => '$1 replied to $2\'s message on your wall',
	'wn-user2-reply-other-your-wall' => '$1 and $2 replied to $3\'s message on your wall',
	'wn-user3-reply-other-your-wall' => '$1 and others replied to $2\'s message on your wall',
	'wn-user1-reply-you-other-wall' => '$1 replied to your message on $2\'s wall', // needs gender support
	'wn-user2-reply-you-other-wall' => '$1 and $2 replied to your message on $3\'s wall',
	'wn-user3-reply-you-other-wall' => '$1 and others replied to your message on $3\'s wall',
	'wn-user1-reply-self-other-wall' => '$1 replied to a message on $2\'s wall', // needs gender support
	'wn-user2-reply-self-other-wall' => '$1 and $2 replied to a message on $3\'s wall',
	'wn-user3-reply-self-other-wall' => '$1 and others replied to a message on $2\'s wall',
	'wn-user1-reply-other-other-wall' => '$1 replied to $2\'s message on $3\'s wall',
	'wn-user2-reply-other-other-wall' => '$1 and $2 replied to $3\'s message on $4\'s wall',
	'wn-user3-reply-other-other-wall' => '$1 and others replied to $2\'s message on $3\'s wall',
	'wn-user1-reply-you-a-wall' => '$1 replied to your message', // needs gender support
	'wn-user2-reply-you-a-wall' => '$1 and $2 replied to your message',
	'wn-user3-reply-you-a-wall' => '$1 and others replied to your message',
	'wn-user1-reply-self-a-wall' => '$1 replied to a message', // needs gender support
	'wn-user2-reply-self-a-wall' => '$1 and $2 replied to a message',
	'wn-user3-reply-self-a-wall' => '$1 and others replied to a message',
	'wn-user1-reply-other-a-wall' => '$1 replied to $2\'s message', // needs gender support
	'wn-user2-reply-other-a-wall' => '$1 and $2 replied to $3\'s message',
	'wn-user3-reply-other-a-wall' => '$1 and others replied to $3\'s message',
	'wn-newmsg-onmywall' => '$1 left a new message on your wall', // needs gender support
	'wn-newmsg' => 'You left a new message on $1\'s wall', // needs gender support (for sender)
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
	 // three dots are not an ellipsis (two below)
	'tog-enotifwallthread' => '...someone replies to a Message Wall thread I follow',
	'tog-enotifmywall' => '...someone posts a new message on my wall',
	
	'wall-deleted-msg-pagetitle' => 'Message deleted',
	'wall-deleted-msg-text' => 'The message you are trying to reach has been deleted.',
	'wall-deleted-msg-return-to' => 'Return to $1\'s wall.',
	'wall-deleted-msg-view' => '(View/Restore)',
	
	'wall-recentchanges-article-link-new-message' => 'on <a href="$1">$2\'s wall</a>',
	'wall-recentchanges-comment-new-message' => '(new: "$1")',
	'wall-recentchanges-new-reply' => '(reply: "$1")',
	'wall-recentchanges-edit' => '(edited message)',
	// for all 6 below: links could've been done via wikitext, perhaps? also, why isn't the user performing the action a param in the message?
	// concatenation should be avoided if possible to allow word order changes
	'wall-recentchanges-wall-removed-thread' => ' removed thread "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-removed-reply' => ' removed reply from "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-restored-thread' => ' restored thread "<a href="$1">$2</a>" on <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-restored-reply' => ' restored reply on "<a href="$1">$2</a>" on <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-deleted-thread' => ' deleted thread "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-deleted-reply' => ' deleted reply from "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',

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
	'wall-removed-thread-undo' => 'This thread has been removed. $1', //$1 = undo link
	'wall-removed-reply-undo' => 'This reply has been removed. $1',
	'wall-removed-reply' => 'This reply has been removed',

	'wall-deleted-thread-undo' => 'This thread has been deleted. $1', //$1 = undo link
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
	'wall-thread-history-thread-created' => '$1 $2 created this thread', // needs geneder support (also true for those below)
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
	'mail-notification-html-signature' => '-- $1 ($2)',

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
	'prefs-wall' => 'Wall',

	'tog-enotifwallthread-v2' => '...someone replies to a Message Wall thread I follow', // three dots are not an ellipsis
	'tog-enotifmywall-v2' => '...someone posts a new message on my Wall',
  
	'wallshowsource-toggle-v2' => 'Enable View source option on Message Wall posts', // if "view source" is a button, this should reference the relevant label message via {{int:msg-name}}
	'wallshowsource-toggle' => 'Enable View source on Message Wall posts', // ditto
	'walldelete-toggle' => 'Enable Revision delete on Message Wall posts', // ditto
);

$messages['qqq'] = array(
	'wall-recentchanges-article-link-new-message' => "$1 is link to user's wall page $2 is username (wall owner)",
	
	'wall-recentchanges-wall-delete' => "$1 is link to deleted message, $2 is title of the message, $3 is link to wall owner's wall and $4 is the owner's username",
	'wall-contributions-wall-line' => "$1 - timestamp linked to thread page; 2 - diff link or text; 3 - hist link; 4 - thread page url address; 5 - message title; 6 - user's wall url address; 7 - wall owner's username; 8 - new flag",
	'wall-whatlinkshere-wall-line' => '$1 - link to wall message page; $2 - title of the message; $3 - link to wall page; $4 - wall owner username',

	'wall-no-title' => "fallback wall message title for deleted message which are not accessible in archive", 
	'wall-message-loadmore' => "See all the messages in the thread, $1 is the number of messages",
	'wall-message-wall' => "Name of the feature",
	'wall-message-wall-shorten' => "Name of the feature when it's used with a possessive, as in John's wall",
	'wall-message-unfollow' => "stop subscribing to notifications for this thread",
	'wall-message-following' => "currently subscribed to notifications for this thread",
	'wall-message-follow' => "subscribe to notifications for this thread",

	'wall-message-undoremove' => "undo the action that you just took",

	'wall-message-edited' => "$1 is the username who edited the message, $2 user page URL, $3 diff url ",
	'wall-message-mywall' => "It is display when you are on thread page which is on your owne wall", 
	'wall-toolbar-history' => "Link in the toolbar to see the history of the wall or thread",
	
	'wall-message-remove-notify' => "In the remove-message modal box, checkbox for telling the admin about the removal",
	'wall-message-delete-notify' => "In the delete-message modal box, checkbox for telling the admin about the deletion",
	'wall-message-remove' => "Dropdown menu on a message, option to remove the message from the wall",
	'wall-message-rev-delete' => "Dropdown menu for staff, option to revision-delete the message",
	'wall-message-elseswall' => "Link to a user's wall, $1 is the username",
	'wall-message-no-permission' => "Error message when a non-admin or staff tries to delete or revision-delete a message",
	
	'wall-thread-removed' => "In parentheses at the top of a removed thread page, next to the title",
	'wall-thread-deleted' => "In parentheses at the top of a deleted thread page, next to the title",

	'wall-default-title' => "Default title if the user doesn't give a new thread a title",
	'wall-no-title-warning' => "Error message when a user tries to post a thread without a title",
	'wall-desc' => 'Extension description which shows in special version', 
	'wall-disabled-desc' => 'Extension description which shows in special version (wall disabled)', 
	'wall-placeholder-topic' => "Entry field for title of a new thread",
	'wall-placeholder-message' => "Entry field for the first message of a new thread, $1 is the wall owner",
	'wall-placeholder-message-anon' => "Entry field for the first message of a new thread, wall owner is anon",
	'wall-placeholder-reply' => "Entry field for posting a reply to a thread",
	'wall-button-to-preview-comment' => "Link to preview a message",
	'wall-button-to-cancel-preview' => "Link to cancel a preview and go back to editing",
	'wall-button-to-submit-comment' => "Button to post the first message of a new thread",
	'wall-button-to-submit-reply' => "Button to post a reply to a thread",
	'wall-button-to-submit-comment-no-topic' => "Button to post a new thread after getting an error message for not having a title",
	'wall-button-save-changes' => "Button to save edits to a message",
	'wall-button-cancel-changes' => "Button to cancel an edit to a message",
	'wall-button-done-source' => "Button to close the source view for a message",
	'wall-message-edit' => "Menu item to edit a message",
	'wall-message-more' => "Top of the menu for each message", 
	'wall-message-delete' => "Menu item to delete a message",
	'wall-message-remove' => "Menu item to remove a message",
	'wall-message-removed-thread-because' => "Summary at the top of a removed thread page, $1 is the user who removed the thread",
	'wall-message-deleted-thread-because' => "Summary at the top of a deleted thread page, $1 is the user who deleted the thread",
	'wall-message-restore-thread' => "Button to restore a thread on a removed thread page",
	'wall-message-removed-reply-because' => "Summary at the top of a removed reply page, $1 is the user who removed the reply",
	'wall-message-deleted-reply-because' => "Summary at the top of a deleted reply page, $1 is the user who deleted the reply",
	'wall-message-restore-reply' => "Button to restore a reply on a removed reply page",
	'wall-delete-reason' => "default user/admin action",
	'wall-user-talk-page-archive-anchor' => "Link on a Message Wall page to the user's old talk page archive",
	'wall-user-talk-archive-page-title' => "Title on a user's talk page archive",

	'wall-action-all-confirm-cancel' => "Button to cancel on a remove or delete message modal box",
	'wall-action-all-confirm-notify' => "Option to notify an admin on a remove or deleted reply modal box",

	'wall-action-remove-reply-title' => "Title of the modal box for removing a reply",
	'wall-action-remove-thread-title' => "Title of the modal box for removing a thread",

	'wall-confirm-monobook-remove' => "Explanation of the remove modal box for Monobook users, puts extra info in because Monobook users don't see the complete modal box",
	'wall-confirm-monobook-admin' => "Explanation of the delete modal box for Monobook users, puts extra info in because Monobook users don't see the complete modal box",
	'wall-confirm-monobook-restore' => "Asks for a summary for restoring a message or reply for Monoboo users",
	'wall-delete-error-title' => "Title of error message for Monobook",
	'wall-delete-error-content' => "Error message for trying to delete a message that has already been deleted",
	
	'wall-confirm-monobook-lack-of-reason' => "Error message for Monobook users who try to remove a message without writing a summary",

	'wall-action-remove-confirm' => "Asks for summary in the remove modal box",
	'wall-action-remove-thread-confirm-info' => "Explanation in the remove modal box that the thread and summary will still appear in the history",
	'wall-action-remove-reply-confirm-info' => "Explanation in the remove modal box that the reply and summary will still appear in the history",	
	'wall-action-remove-confirm-ok' => "Button in the remove modal box",
	
	'wall-action-admin-thread-title' => "Title of the delete thread modal box",
	'wall-action-admin-reply-title' => "Title of the delete reply modal box",

	'wall-action-admin-confirm' => "Asks for summary in the delete modal box",
	'wall-action-admin-thread-confirm-info' => "Explanation in the delete modal box that the thread and summary will still appear in the history",
	'wall-action-admin-reply-confirm-info' => "Explanation in the delete modal box that the reply and summary will still appear in the history",

	'wall-action-admin-confirm-ok' => "Button in the delete modal box",

	'wall-action-restore-thread-title' => "Button to restore a thread",
	'wall-action-restore-reply-title' => "Button to restore a reply",

	'wall-action-restore-confirm' => "Asks for summary in the restore modal box",
	'wall-action-restore-confirm-ok' => "Button in the restore modal box",
	
	'wall-action-rev-thread-title' => "Title of revision delete thread modal box",
	'wall-action-rev-reply-title' => "Title of revision delete reply moal box",

	'wall-action-rev-reply-confirm' => "Confirmation for revision delete reply modal",
	'wall-action-rev-thread-confirm' => "Confirmation for revision delete thread modal",
	'wall-action-rev-confirm-ok' => "Button for confirming revision delete",
	
	'wall-notifications' => "Title of notification dropdown",
	'wall-notifications-all' => "Text in notification dropdown menu",
	'wall-notifications-markasread' => "Option in notification dropdown menu to mark all threads as read",
	'wall-notifications-markasread-all-wikis' => "Option to mark all cross-wiki notifications as read",
	'wall-notifications-markasread-this-wiki' => "Option to mark only this wiki's notifications as read",
	'wall-notifications-empty' => "Message for empty notification dropdown",
	'wall-notifications-loading' => "Message in the notification dropdown while notifications are loading",
	'wall-notifications-reminder' => "Notification reminder that appears at the top right if user scrolls down without looking at notification dropdown, uses pluralization",
	'wall-notifications-wall-disabled' => 'It shows when the wall is turned off during loading of notification', 
	
	'wn-user1-reply-you-your-wall' => "Notification when someone replies on your wall, $1 is username",
	'wn-user2-reply-you-your-wall' => "Notification when 2 users reply on your wall, $1 and $2 are usernames who replied",
	'wn-user3-reply-you-your-wall' => "Notification when 3 or more users reply on your wall, $1 is first username who replied",
	'wn-user1-reply-self-your-wall' => "Notification when a user replies to a thread that user started, $1 is username",
	'wn-user2-reply-self-your-wall' => "Notification when 2 users reply to a thread that one of them started, $1 and $2 are usernames who replied",
	'wn-user3-reply-self-your-wall' => "Notification when 3 or more users reply to a thread that one of them started, $1 is first username who replied",
	'wn-user1-reply-other-your-wall' => "Notification, $1 is user replying, $2 is user who started the thread",
	'wn-user2-reply-other-your-wall' => "Notification, $1 and $2 are users replying, $3 is user who started the thread",
	'wn-user3-reply-other-your-wall' => "Notification, $1 is first user replying, $2 is user who started the thread",
	'wn-user1-reply-you-other-wall' => "Notification, $1 is user replying to a thread you started, $2 is wall owner",
	'wn-user2-reply-you-other-wall' => "Notification, $1 and $2 are users replying to a thread you started, $3 is wall owner",
	'wn-user3-reply-you-other-wall' => "Notification, $1 is first user replying to a thread you started, $3 is wall owner",
	'wn-user1-reply-self-other-wall' => "Notification, $1 is user replying to a thread that user started, $2 is wall owner",
	'wn-user2-reply-self-other-wall' => "Notification, $1 and $2 are users replying to a thread that one of them started, $3 is wall owner",
	'wn-user3-reply-self-other-wall' => "Notification when 3 or more users reply to a thread that one of them started, $1 is first user who replied, $2 is wall owner",
	'wn-user1-reply-other-other-wall' => "Notification, $1 is user replying, $2 is user who started the thread, $3 is wall owner",
	'wn-user2-reply-other-other-wall' => "Notification, $1 and $2 are users replying, $3 is user who started the thread, $4 is wall owner",
	'wn-user3-reply-other-other-wall' => "Notification when 3 or more users reply to a thread, $1 is first user who replied, $2 is user who started the thread, $3 is wall owner", 
	'wn-user1-reply-you-a-wall' => "Notification, $1 is user who replied to a thread you started",
	'wn-user2-reply-you-a-wall' => "Notification, $1 and $2 are users who replied to a thread you started",
	'wn-user3-reply-you-a-wall' => "Notification when 3 or more users reply to a thread you started, $1 is first user who replied",
	'wn-user1-reply-self-a-wall' => "Notification, $1 is user who replied to a message that that user started on his or her own wall",
	'wn-user2-reply-self-a-wall' => "Notification, $1 and $2 are users who replied to a message that one of them started on his or her own wall",
	'wn-user3-reply-self-a-wall' => "Notification when 3 or more users reply to a thread that one of them started on his or her own wall, $1 is first user who replied",
	'wn-user1-reply-other-a-wall' => "Notification when wall owner is one of the users involved, $1 is user who replied, $2 started the thread",
	'wn-user2-reply-other-a-wall' => "Notification when wall owner is one of the users involved, $1 and $2 are users who replied, $3 started the thread",
	'wn-user3-reply-other-a-wall' => "Notification when 3 or more users reply and wall owner is one of the users involved, $1 is first user who replied, $3 started the thread",
	'wn-newmsg-onmywall' => "Notification, $1 started a new thread on your wall",
	'wn-newmsg' => "Notification when you follow a user's wall and start a new thread on that user's wall, $1 is wall owner",
	'wn-newmsg-on-followed-wall' => "Notification when you follow a user's wall, $1 is user who started a new thread, $2 is wall owner",
	
	'wn-admin-thread-deleted' => "Admin notification of a removed thread, $1 is wall owner",
	'wn-admin-reply-deleted' => "Admin notification of a removed reply, $1 is wall owner",
	'wn-owner-thread-deleted' => "Notification for wall owner of removed thread", 
	'wn-owner-reply-deleted' => "Notification for wall owner of removed reply",
	
	'wall-sorting-newest-threads' => "Sorting option, newest threads first",
	'wall-sorting-oldest-threads' => "Sorting option, oldest threads first",
	'wall-sorting-newest-replies' => "Sorting option, threads with newest replies first",
	'wall-sorting-most-active' => "Sorting option, most active threads first (deprecated)",
	'wall-sorting-archived' => "Sorting option, show archived threads (not built yet)",
	
	'tog-enotifwallthread' => "Email preference option, checkbox to receive email when there's a reply to a followed thread",
	'tog-enotifmywall' => "Email preference option, checkbox to receive email when there's a new thread on your wall",
	
	'wall-deleted-msg-pagetitle' => "Confirmation that a thread has been deleted",
	'wall-deleted-msg-text' => "Error message when a user follows a link to a deleted thread",
	'wall-deleted-msg-return-to' => "Link to return to user's wall when you try to follow a link to a deleted thread, $1 is wall owner",
	'wall-deleted-msg-view' => "Option for admins and staff to view and restore a deleted thread",
	
	'wall-recentchanges-article-link-new-message' => "Recent changes item, $2 is wall owner",
	'wall-recentchanges-comment-new-message' => "Recent changes item, $1 is beginning of message",
	'wall-recentchanges-new-reply' => "Recent changes item, $1 is beginning of reply",
	'wall-recentchanges-edit' => "Recent changes item, default summary for editing a message",
	
	'wall-recentchanges-wall-removed-thread' => "Recent changes item, $2 is thread title, $4 is wall owner",
	'wall-recentchanges-wall-removed-reply' => "Recent changes item, $2 is thread title, $4 is wall owner",
	'wall-recentchanges-wall-restored-thread' => "Recent changes item, $2 is thread title, $4 is wall owner",
	'wall-recentchanges-wall-restored-reply' => "Recent changes item, $2 is thread title, $4 is wall owner",
	'wall-recentchanges-wall-deleted-thread' => "Recent changes item, $2 is thread title, $4 is wall owner",
	'wall-recentchanges-wall-deleted-reply' => "Recent changes item, $2 is thread title, $4 is wall owner",

	'wall-recentchanges-deleted-reply-title' => 'fallback reply title for deleted replies  are not accessible in archive', 
	'wall-recentchanges-namespace-selector-message-wall' => "Recent changes, item in namespace dropdown",
	'wall-recentchanges-wall-group' => "Grouped recent changes item, $1 is thread title, $3 is wall owner",
	'wall-recentchanges-wall-history-link' => "Recent changes, link to wall history for items about removed and deleted threads",
	'wall-recentchanges-thread-history-link' => "Recent changes, link to thread history for items about removed replies", 
	
	'wall-contributions-wall-line' => "Contributions item, $5 is timestamp, $6 is diff link if applicable, $7 is history link, $8 is N if it's a new thread, $2 is thread title, $4 is wall owner",
	
	'wall-whatlinkshere-wall-line' => "What links here item, $2 is thread title, $4 is wall owner",
	
	'wall-message-not-found' => "Error message if user tries to visit a thread that doesn't exist",

	'wall-message-staff-text' => "tooltip for Wikia staff signature",

	'wall-ipballowusertalk' => "checkbox on Special:Block",
	'wall-ipbwatchuser' => "checkbox on Special:Block",
	
	/* Wall WikiActivity */
	'wall-wiki-activity-on' => "Wiki Activity item, $1 is wall owner",
	'wall-wiki-activity-wall-owner' => "Wiki Activity item, $1 is wall owner",
	
	/* Wall removed msg */
	'wall-removed-thread-undo' => "Confirmation message after removing a thread, $1 is Undo link",
	'wall-removed-reply-undo' => "Confirmation message after removing a reply, $1 is Undo link",
	'wall-removed-reply' => "Confirmation message after removing a thread",

	'wall-deleted-thread-undo' => "Confirmation message after deleting a thread, $1 is Undo link",
	'wall-deleted-reply-undo' => "Confirmation message after deleting a reply, $1 is Undo link",
	'wall-deleted-reply' => "Confirmation message after deleting a reply",

	/* Wall Level History */
	'wall-history' => "toolbar link to wall history",
	'wall-history-username-full' => "username on wall history page, $1 is preferred name, $2 is username",
	'wall-history-username-short' => "username on wall history page, $2 is username",
	
	'wall-history-title' => "heading on wall history page",
	'wall-history-who-involved-wall-title' => "heading on who's involved box on wall history page",
	'wall-history-who-involved-thread-title' => "heading on who's involved box on thread history page",
	'wall-history-thread-created' => "wall history item, $1 is thread title, $2 is username",
	'wall-history-thread-removed' => "wall history item, $1 is thread title, $2 is username",
	'wall-history-thread-restored' => "wall history item, $1 is thread title, $2 is username",
	'wall-history-thread-admin-deleted' => "wall history item, $1 is thread title, $2 is username",
	'wall-history-sorting-newest-first' => "sorting option, view newest changes first",
	'wall-history-sorting-oldest-first' => "sorting option, view oldest changes first",
	
	'wall-history-summary-label' => "wall history page, heading for summary item",
	
	'wall-history-rail-wall' => "wall history page, who's involved box - link to user's wall",
	'wall-history-rail-contribs' => "wall history page, who's involved box - link to user's contributions list",
	'wall-history-rail-block' => "wall history page, who's involved box - link for admins to block user",
	
	'wall-history-action-view' => "wall history page, link to view removed thread",
	'wall-history-action-restore' => "wall history page, link to restore removed thread",
	'wall-history-action-thread-history' => "wall history page, link to view thread history",
	
	/* Thread Level History */
	'wall-thread-history-title' => "heading on thread history page",
	'wall-thread-history-thread-created' => "thread history page, $1 is thread title, $2 is username",
	'wall-thread-history-reply-created' => "thread history page item, $1 is preferred name, $2 is username",

	'wall-thread-history-thread-removed' => "thread history page item, $1 is preferred name, $2 is username",
	'wall-thread-history-reply-removed' => "thread history page item, $1 is preferred name, $2 is username, $3 is username, $5 is number of the reply",
	'wall-thread-history-thread-restored' => "thread history page item, $1 is preferred name, $2 is username",
	'wall-thread-history-reply-restored' => "thread history page item, $1 is preferred name, $2 is username, $3 is username, $5 is number of the reply",
	'wall-thread-history-thread-deleted' => "thread history page item, $1 is preferred name, $2 is username",

	'wall-thread-history-thread-edited' => "thread history page item, $1 is preferred name, $2 is username, $3 is username, $5 is number of the reply",
	'wall-thread-history-reply-edited' => "thread history page item, $1 is preferred name, $2 is username, $3 is username, $5 is number of the reply",

	'wall-history-action-restore-reply' => "thread history page, link to restore reply",
	'wall-history-action-restore-thread' => "thread history page, link to restore thread",

	'wall-message-not-found-in-db' => "Error message",
	
	/* Mail message */

	'mail-notification-new-someone' => 'email notification, $AUTHOR_NAME is user, $WIKI is wiki name',
	'mail-notification-new-your' => 'email notification, $AUTHOR_NAME is user, $WIKI is wiki name',

	'mail-notification-reply-your' => 'email notification, $AUTHOR_NAME is user, $WIKI is wiki name',
	'mail-notification-reply-his' => 'email notification, $AUTHOR_NAME is user, $WIKI is wiki name',
	'mail-notification-reply-someone' => 'email notification, $AUTHOR_NAME is user, $PARENT_AUTHOR_NAME is user who started the thread, $WIKI is wiki name', 

	'mail-notification-html-greeting' => "email notification greeting, $1 is username",
	'mail-notification-html-button' => "email notification, button to visit the thread",
	'mail-notification-html-signature' => "email notification, $1 is preferred name, $2 is username",

	'mail-notification-subject' => "email notification title, $1 is thread title, $2 is wiki",

	'mail-notification-html-footer-line3' => "email notification footer with links to Twitter, Facebook, YouTube, Wikia staff blog",
	'mail-notification-html-footer-line1' => "email notification footer with link to Community Central",
	'mail-notification-html-footer-line2' => "email notification footer with link to preferences",

	'mail-notification-body' => "email notification body text", 
	'mail-notification-body-HTML' => "email notification body text with HTML",
	
	/* Preferences */
	'prefs-wall' => "preferences, heading for section about Wall e-mails",

	'tog-enotifwallthread-v2' => "preferences checkbox",
	'tog-enotifmywall-v2' => "preferences checkbox",
  
	'wallshowsource-toggle-v2' => "preferences checkbox",
	'wallshowsource-toggle' => "preferences checkbox",
	'walldelete-toggle' => "preferences checkbox",
);
