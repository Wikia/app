<?php

$messages = array();

$messages['en'] = array(
	'user-page' => 'User page',
	'wall-no-title' => 'No title',
	'wall-message-loadmore' => 'View all $1 replies',
	'wall-message-wall' => 'Message Wall',
	'wall-message-wall-short' => 'Wall',
	'wall-message-unfollow' => 'Unfollow',
	'wall-message-following' => 'Following',
	'wall-message-follow' => 'Follow',

	'wall-message-undoremove' => 'Undo',
	'wall-message-edited' => '<a href="$3" >Edited by</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'My Wall',
	'wall-toolbar-history' => 'History',
	
	'wall-message-remove-notify' => 'Notify admin',
	'wall-message-delete-notify' => 'Notify admin',
	'wall-message-remove' => 'Remove',
	'wall-message-rev-delete' => 'Revision delete',

	'wall-message-elseswall' => "$1's Wall",
	'wall-message-no-permission' => 'You don\'t have permissions to perfom this action on the message',
	
	'wall-thread-removed' => 'Removed',
	'wall-thread-deleted' => 'Deleted',

	'wall-tab-wall-title' => 'User Wall:',
	'wall-default-title' => 'Message from',
	'wall-no-title-warning' => '&larr; You did not specify any title',
	'wall-desc' => 'User talk page replacement',
	'wall-disabled-desc' => 'Message Wall functionality for pages without Wall extension',
	'wall-placeholder-topic' => 'What\'s this about?',
	'wall-placeholder-message' => "Post a new message to $1's wall",
	'wall-placeholder-message-anon' => "Post a new message to this wall",
	'wall-placeholder-reply' => "Post a reply",
	'wall-post-message' => 'Post message',
	'wall-error-creating-brick-article' => "Error while trying to create new message. Error code: $1",
	'wall-button-to-show-brick-comment-form' => "Comment",
	'wall-button-to-preview-comment' => "Preview",
	'wall-button-to-cancel-preview' => "Edit",
	'wall-button-to-submit-comment' => "Post",
	'wall-button-to-submit-reply' => "Reply",
	'wall-button-to-submit-comment-no-topic' => "Post without title",
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

	'wall-confirm-monobook-remove' => "Please tell us why you would like to remove this. \n\nThe original post and your summary will still appear in the wiki's history. \n",
	'wall-confirm-monobook-admin' => "Please tell us why you would like to delete this. \n\nThe original post and your summary will still appear in the wiki's history. \n",
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
	'wall-action-admin-thread-confirm-info' => "This thread and your summary will still appear in the wiki's history",
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
	
	'wn-user1-reply-you-your-wall' => '$1 replied to your message on your Wall',
	'wn-user2-reply-you-your-wall' => '$1 and $2 replied to your message on your Wall',
	'wn-user3-reply-you-your-wall' => '$1 and others replied to your message on your Wall',
	'wn-user1-reply-self-your-wall' => '$1 replied to a message on your Wall',
	'wn-user2-reply-self-your-wall' => '$1 and $2 replied to a message on your Wall',
	'wn-user3-reply-self-your-wall' => '$1 and others replied to a message on your Wall',
	'wn-user1-reply-other-your-wall' => '$1 replied to $2\'s message on your Wall',
	'wn-user2-reply-other-your-wall' => '$1 and $2 replied to $3\'s message on your Wall',
	'wn-user3-reply-other-your-wall' => '$1 and others replied to $2\'s message on your Wall',
	'wn-user1-reply-you-other-wall' => '$1 replied to your message on $2\'s Wall',
	'wn-user2-reply-you-other-wall' => '$1 and $2 replied to your message on $3\'s Wall',
	'wn-user3-reply-you-other-wall' => '$1 and others replied to your message on $3\'s Wall',
	'wn-user1-reply-self-other-wall' => '$1 replied to a message on $2\'s Wall',
	'wn-user2-reply-self-other-wall' => '$1 and $2 replied to a message on $3\'s Wall',
	'wn-user3-reply-self-other-wall' => '$1 and others replied to a message on $2\'s Wall',
	'wn-user1-reply-other-other-wall' => '$1 replied to $2\'s message on $3\'s Wall',
	'wn-user2-reply-other-other-wall' => '$1 and $2 replied to $3\'s message on $4\'s Wall',
	'wn-user3-reply-other-other-wall' => '$1 and others replied to $2\'s message on $3\'s Wall',
	'wn-user1-reply-you-a-wall' => '$1 replied to your message',
	'wn-user2-reply-you-a-wall' => '$1 and $2 replied to your message',
	'wn-user3-reply-you-a-wall' => '$1 and others replied to your message',
	'wn-user1-reply-self-a-wall' => '$1 replied to a message',
	'wn-user2-reply-self-a-wall' => '$1 and $2 replied to a message',
	'wn-user3-reply-self-a-wall' => '$1 and others replied to a message',
	'wn-user1-reply-other-a-wall' => '$1 replied to $2\'s message',
	'wn-user2-reply-other-a-wall' => '$1 and $2 replied to $3\'s message',
	'wn-user3-reply-other-a-wall' => '$1 and others replied to $3\'s message',
	'wn-newmsg-onmywall' => '$1 left a new message on your Wall',
	'wn-newmsg' => 'You left a new message on $1\'s Wall',
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
	
	'tog-enotifwallthread' => '...someone replies to a Message Wall thread I follow',
	'tog-enotifmywall' => '...someone posts a new message on my Wall',
	
	'wall-deleted-msg-pagetitle' => 'Message deleted',
	'wall-deleted-msg-text' => 'The message you are trying to reach has been deleted.',
	'wall-deleted-msg-return-to' => 'Return to $1\'s Wall.',
	'wall-deleted-msg-view' => '(View/Restore)',

	'wall-view-revert' => 'View/Revert',
	
	'wall-recentchanges-article-link-new-message' => 'on <a href="$1">$2\'s wall</a>',
	'wall-recentchanges-comment-new-message' => '(new: "$1")',
	'wall-recentchanges-comment-new-message-group' => '(new <a href="$2">"$3"</a> with "$1")',
	'wall-recentchanges-new-reply' => '(reply: "$1")',
	'wall-recentchanges-new-reply-group' => '(reply: "$1" on <a href="$2">"$3"</a>)',
	'wall-recentchanges-edit' => '(edited message)',
	
	'wall-recentchanges-wall-removed-thread' => ' removed thread "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-removed-reply' => ' removed reply from "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-restored-thread' => ' restored thread "<a href="$1">$2</a>" on <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-restored-reply' => ' restored reply on "<a href="$1">$2</a>" on <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-deleted-thread' => ' deleted thread "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-wall-deleted-reply' => ' deleted reply from "<a href="$1">$2</a>" from <a href="$3">$4\'s wall</a>',

	'wall-recentchanges-deleted-reply-title' => 'A reply on message wall',
	'wall-recentchanges-namespace-selector-message-wall' => 'Message Wall',
	'wall-recentchanges-wall-group' => '$1 on <a href="$2">$3\'s wall</a>',
	'wall-recentchanges-wall-history-link' => 'Wall History',
	'wall-recentchanges-thread-history-link' => 'Thread History',
	'wall-recentchanges-wall-unrecognized-log-action' => 'Unrecognized log action',
	
	'wall-contributions-wall-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> on <a href="$3">$4\'s wall</a>',
	
	'wall-whatlinkshere-wall-line' => '<a href="$1">$2</a> on <a href="$3">$4\'s wall</a>',
	
	'wall-message-not-found' => 'This message could not be found. If you see this error, please contact Wikia at [[Special:Contact]] and provide as much detail as possible about how this bug can be reproduced. Thank you!',

	'wall-message-staff-text' => 'This user is a member of Wikia staff',

	'wall-ipballowusertalk' => "Allow this user to post on their own Message Wall while blocked", 
	'wall-ipbwatchuser' => "Watch this user's profile and follow their Message Wall",
	
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
	
	'wall-history-title' => 'Wall History',
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
	'wall-thread-history-title' => 'Thread History',
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

	'tog-enotifwallthread-v2' => '...someone replies to a Message Wall thread I follow',
	'tog-enotifmywall-v2' => '...someone posts a new message on my Wall',
  
	'wallshowsource-toggle-v2' => 'Enable View source option on Message Wall posts',
	'wallshowsource-toggle' => 'Enable View source on Message Wall posts',
	'walldelete-toggle' => 'Enable Revision delete on Message Wall posts',
);

$messages['qqq'] = array(
	'wall-recentchanges-article-link-new-message' => "$1 is link to user's wall page $2 is username (wall owner)",
	'wall-recentchanges-wall-delete' => "$1 is link to deleted message, $2 is title of the message, $3 is link to wall owner's wall and $4 is the owner's username",
	'wall-contributions-wall-line' => "$1 - timestamp linked to thread page; 2 - diff link or text; 3 - hist link; 4 - thread page url address; 5 - message title; 6 - user's wall url address; 7 - wall owner's username; 8 - new flag",
	'wall-whatlinkshere-wall-line' => '$1 - link to wall message page; $2 - title of the message; $3 - link to wall page; $4 - wall owner username',
);
