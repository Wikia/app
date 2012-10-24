<?php
/**
* Internationalisation file for the Forum extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'forum-forum-title' => 'Forum',
	'forum-total-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Discussion in this Forum|Threads in this Discussions}}',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Active Discussion|Active Discussions}}',
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|Active Discussion|Active Discussions}} about: $2',

	/* Heading Bar */
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Thread<br> in this Forum|Threads<br> in this Forum}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Active<br> Discussion|Active<br> Discussions}}</span>',

	/* Forum:Special (Index) */
	'forum-specialpage-blurb-heading' => 'Welcome to {{SITENAME}} Forum!',
	'forum-specialpage-blurb' => 'This is an early demo of Wikia\'s new Forum feature. If you\'ve got ideas or questions about the feature, please start a thread on the [[Board:General Discussion|General Discussion board]]. Have fun!',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|thread|threads}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|post|posts}}',
	'forum-specialpage-board-lastpostby' => 'Last post by',

	/* Forum Board */
	'forum-board-title' => '$1 board',
	'forum-board-topics' => 'Topics',
	'forum-board-thread-follow' => 'Follow',
	'forum-board-thread-following' => 'Following',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 Replies',
	'forum-board-thread-unfollow' => 'Unfollow',
	'forum-board-new-message-heading' => 'Start a Discussion',

	/* Forum Thread */
	'forum-thread-title' => '$1 board',
	'forum-thread-reply-placeholder' => 'Post a reply',
	'forum-thread-reply-post' => 'Reply',
	'forum-thread-deleted-return-to' => 'Return to $1 board',

	/* Sorting */
	'forum-sorting-option-newest-replies' => 'Most Recent',
	'forum-sorting-option-popular-threads' => 'Most Popular',
	'forum-sorting-option-most-replies' => 'Most Active in 7 Days',

	/* New Discussion */
	'forum-discussion-post' => 'Post',
	'forum-discussion-highlight' => 'Highlight this discussion',
	'forum-discussion-placeholder-title' => 'What do you want to talk about?',
	'forum-discussion-placeholder-message' => 'Post a new message to the $1 board',

	/* Notification */
	'forum-notification-user1-reply-to-your' => '$1 replied to your thread on the $3 board',
	'forum-notification-user2-reply-to-your' => '$1 and $2 replied to your thread on the $3 board',
	'forum-notification-user3-reply-to-your' => '$1 and others replied to your thread the $3 board',
	'forum-notification-user1-reply-to-someone' => '$1 replied on the $3 board',
	'forum-notification-user2-reply-to-someone' => '$1 and $2 replied on the $3 board',
	'forum-notification-user3-reply-to-someone' => '$1 and others replied on the $3 board',
	
	'forum-notification-newmsg-on-followed-wall' => '$1 left a new message on the $2 board',

	/* Mail message */
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME wrote a new thread on $WIKI\'s $BOARDNAME board.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME wrote a new thread on $WIKI\'s $BOARDNAME board.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME replied to your thread on $WIKI\'s $BOARDNAME board',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME replied on $WIKI\'s $BOARDNAME board',
	'forum-mail-notification-html-greeting' => 'Hi $1,',
	'forum-mail-notification-html-button' => 'See the conversation',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hi $WATCHER,

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

	'forum-mail-notification-body-HTML' => 'Hi $WATCHER,
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

	/* WikiActivity */
	'forum-wiki-activity-msg' => 'on the $1',
	'forum-wiki-activity-msg-name' => '$1 board',
	
	/* Forum Activity and Related Module */
	'forum-activity-module-heading' => 'Forum Activity',
	'forum-related-module-heading' => 'Related Threads',
	'forum-activity-module-posted' => '$1 posted a reply $2',
	'forum-activity-module-started' => '$1 started a discussion $2',

	/* Forum Participation Module */
	'forum-participation-module-heading' => 'Who\'s Here',
	'forum-participation-module-kudos' => 'gave [[$1|kudos]] $2',
	'forum-participation-module-posted' => 'posted a <a href="$1">reply</a> $2',
	'forum-participation-module-started' => 'started a <a href="$1">discussion</a> $2',

	/* Contribution/RC */
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> on the <a href="$3">$4 board</a>',

	'forum-recentchanges-new-message' => 'on the <a href="$1">$2 Board</a>',
	'forum-recentchanges-edit' => '(edited message)',
	'forum-recentchanges-removed-thread' => 'removed thread "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-removed-reply' => 'removed reply from "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-restored-thread' => 'restored thread "[[$1|$2]]" to the [[$3|$4 Board]]',
	'forum-recentchanges-restored-reply' => 'restored reply on "[[$1|$2]]" to the [[$3|$4 Board]]',
	'forum-recentchanges-deleted-thread' => 'deleted thread "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-deleted-reply' => 'deleted reply from "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-deleted-reply-title' => 'A post',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forum Board',
	'forum-recentchanges-thread-group' => '$1 on the <a href="$2">$3 Board</a>',
	'forum-recentchanges-history-link' => 'board history',
	'forum-recentchanges-thread-history-link' => 'thread history',
	'forum-recentchanges-closed-thread' => 'closed thread "[[$1|$2]]" from [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'reopened thread "[[$1|$2]]" from [[$3|$4]]',

	/* history */

	'forum-board-history-title' => 'board history',

	/* Old version of forum */
	'forum-specialpage-oldforum-link' => 'Old forum Archives',

	'forum-admin-link-label' => 'Manage Boards',

	'forum-autoboard-title-1' => 'General Discussion',
	'forum-autoboard-body-1' => 'This board is for general conversations about the wiki.',

	'forum-autoboard-title-2' => 'News and Announcements',
 	'forum-autoboard-body-2' => 'Breaking news and information!',

 	'forum-autoboard-title-3' => 'New on $WIKINAME',
	'forum-autoboard-body-3' => "Want to share something that's just been posted on the wiki, or congratulate somebody for an outstanding contribution?",

	'forum-autoboard-title-4' => 'Questions and Answers',
	'forum-autoboard-body-4' => 'Got a question about the wiki, or the topic? Ask your questions here!',

	'forum-autoboard-title-5' => 'Fun and Games',
	'forum-autoboard-body-5' => 'This board is for off-topic conversation -- a place to hang out with your $WIKINAME friends.'
);

$messages['qqq'] = array(
	'forum-forum-title' => 'The main title for the forum.',
	'forum-board-title' => 'appears in the header of board page',

	'forum-specialpage-title' => 'Appears as the main title of the forum and also in the browser title bar.',
	'forum-specialpage-blurb-heading' => 'Heading for the introduction text.',
	'forum-specialpage-blurb' => 'A short description of the forum.',
	'forum-specialpage-board-threads' => 'The count of threads on a board. Parameters: * $1 - the number of threads.',
	'forum-specialpage-board-posts' => 'The count of posts on a board. Parameters: * $1 - the number of posts.',
	'forum-specialpage-board-lastpostby' => '',

	'forum-notification-user1-reply-to-your' => 'Notification when someone replies on your thread. Parameters:
* $1 is a username (GENDER is supported in this message).',
	'forum-notification-user2-reply-to-your' => "Notification when 2 users reply on the logged in user's thread. Parameters:
* $1 and $2 are names of users that replied (GENDER is supported in this message).",
	'forum-notification-user3-reply-to-your' => "Notification when 3 or more users reply on the logged in user's thread. Parameters:
* $1 is the first user who replied (GENDER is supported in this message).",

	'forum-activity-module-heading' => 'Forum Activity right rail module heading',
	'forum-activity-module-posted' => '$1 is username, $2 is url to user page, $3 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-participation-module-heading' => 'Forum Participation right rail module heading.  Informal, and state "there are these people here"',
	'forum-participation-module-kudos' => 'Gives state of kudos user activity by event and time.  $1 is a url link to the kudos event page.  $2 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-participation-module-posted' => 'Gives state of posted user activity by event and time.  $1 is a url link to the posted event page.  $2 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-participation-module-started' => 'Gives state of started user activity by event and time.  $1 is a url link to the started event page.  $2 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	
	'forum-recentchanges-closed-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is thread owner
* $5 is optional username and you can use it with GENDER parameter',
	'forum-recentchanges-reopened-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is thread owner
* $5 is optional username and you can use it with GENDER parameter',

	'forum-admin-link-label' => 'a call-to-action label for link that will take wiki admins to forum board admin page',
	
	'forum-autoboard-title-1' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-1' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-2' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-2' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-3' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-3' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-4' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-4' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-5' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-5' => 'Description for default board.The length of this message needs to be between 4 and 255.'
);
