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
	'wall-message-edited' => '<a href="$3" >Edited by</a> <a class="username" href="$1">$2</a>',
	'wall-message-mywall' => 'My Wall',
	'wall-message-elseswall' => "$1's Wall",

	'wall-tab-wall-title' => 'User Wall:',
	'wall-default-title' => 'Message from',
	'wall-no-title-warning' => '&larr; You did not specify any title',
	'wall-desc' => 'User talk page replacement',
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
	'wall-message-source' => 'Source View',
	'wall-message-edit' => "Edit",
	'wall-message-more' => 'More', 
	'wall-message-delete' => "Delete",
	'wall-delete-reason' => "User/admin action",
	'wall-user-talk-page-archive-anchor' => 'See archived talk page',
	'wall-user-talk-archive-page-title' => 'User_talk_archive',

	'wall-delete-title' => 'Delete message',
	'wall-delete-confirm' => 'Are you sure you want to delete this message?',
	'wall-delete-confirm-thread' => 'Are you sure you want to delete this message? Doing so will delete all responses.',
	'wall-delete-confirm-ok' => 'Yes, Delete',
	'wall-delete-confirm-cancel' => 'Cancel',
	
	'wall-notifications' => 'Notifications',
	'wall-notifications-all' => 'All Notifications',
	'wall-notifications-markasread' => 'Mark all as read',
	'wall-notifications-markasread-all-wikis' => 'All wikis',
	'wall-notifications-markasread-this-wiki' => 'This wiki',
	'wall-notifications-empty' => 'There are no notifications',
	'wall-notifications-loading' => 'Loading notifications',
	'wall-notifications-reminder' => 'You have <span>$1</span> unread {{PLURAL:$1|notification|notifications}}',
		
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
	
	'wall-sorting-newest-threads' => 'Newest threads',
	'wall-sorting-oldest-threads' => 'Oldest threads',
	'wall-sorting-newest-replies' => 'Newest replies',
	'wall-sorting-most-active' => 'Most active',
	'wall-sorting-archived' => 'Archived',
	
	'tog-enotifwallthread' => 'Email me when someone replies on a Message Wall thread I\'m following.',
	'tog-enotifmywall' => 'Email me when somebody writes a new message on my Message Wall.',
	
	'wall-deleted-msg-pagetitle' => 'Message deleted',
	'wall-deleted-msg-text' => 'The message you are trying to reach has been deleted.',
	'wall-deleted-msg-return-to' => 'Return to $1\'s Wall.',

	'wall-view-revert' => 'View/Revert',
	
	'wall-recentchanges-article-link-new-message' => 'on <a href="$1">$2\'s wall</a>',
	'wall-recentchanges-comment-new-message' => '(new: "$1")',
	'wall-recentchanges-comment-new-message-group' => '(new <a href="$2">"$3"</a> with "$1")',
	'wall-recentchanges-new-reply' => '(reply: "$1")',
	'wall-recentchanges-new-reply-group' => '(reply: "$1" on <a href="$2">"$3"</a>)',
	'wall-recentchanges-edit' => '(edited message)',
	'wall-recentchanges-deleted-thread' => ' deleted entire thread "<a href="$1" class="new">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-deleted-reply' => ' deleted reply from "<a href="$1" class="new">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-restored-thread' => ' restored thread "<a href="$1" class="new">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-restored-reply' => ' restored reply on "<a href="$1" class="new">$2</a>" from <a href="$3">$4\'s wall</a>',
	'wall-recentchanges-deleted-reply-title' => 'A reply on message wall',
	'wall-recentchanges-namespace-selector-message-wall' => 'Message Wall',
	'wall-recentchanges-wall-group' => '<a href="$1">Message Wall:$2</a>',

	'wall-message-not-found' => 'This message could not be found. If you see this error please contact Wikia at [[Special:Contact]] and provide as much details as possible about how this bug can be reproduced. Thank You!',

	'wall-message-staff-text' => 'This user is a member of Wikia staff',

	'wall-ipballowusertalk' => "Allow this user to post on their own Message Wall while blocked", 
	'wall-ipbwatchuser' => "Watch this user's profile and follow their Message Wall",
	
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
	'wallshowsource-toggle' => 'Enable View source on Message Wall posts'
);

$messages['qqq'] = array(
	'wall-recentchanges-article-link-new-message' => "$1 is link to user's wall page $2 is username (wall owner)",
	'wall-recentchanges-delete' => "$1 is link to deleted message, $2 is title of the message, $3 is link to wall owner's wall and $4 is the owner's username",
);
