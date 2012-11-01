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
	'forum-specialpage-heading' => '{{SITENAME}} Forum',
	'forum-specialpage-blurb-heading' => 'Welcome to {{SITENAME}} Forum!',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '{{formatnum:$1}} {{PLURAL:$1|thread|threads}}',
	'forum-specialpage-board-posts' => '{{formatnum:$1}} {{PLURAL:$1|post|posts}}',
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
	
	/* board admin page messages */
	'forum-admin-page-heading' => '{{SITENAME}} Board Admin',
	'forum-admin-page-breadcrumb' => 'Admin Board Management',
	'forum-admin-create-new-board-label' => 'Create New Board',
	'forum-admin-create-new-board-modal-heading' => 'Create a new board',
	'forum-admin-create-new-board-title' => 'Board Title',
	'forum-admin-create-new-board-description' => 'Board Description',
	
	'forum-admin-edit-board-modal-heading' => 'Edit Board: $1',
	'forum-admin-edit-board-title' => 'Board Title',
	'forum-admin-edit-board-description' => 'Board Description',
	
	'forum-admin-delete-and-merge-board-modal-heading' => 'Delete Board: $1',
	'forum-admin-delete-board-title' => 'Please confirm by typing the name of the board that you want to delete:',
	'forum-admin-merge-board-warning' => 'The threads on this board will be merged into an existing board.',
	'forum-admin-merge-board-destination' => 'Choose a board to merge to:',
	'forum-admin-delete-and-merge-button-label' => 'Delete and Merge',

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
	'forum-autoboard-body-5' => 'This board is for off-topic conversation -- a place to hang out with your $WIKINAME friends.',
	
	/* board creation validation messages */

	'forum-board-destination-empty' => '(Please select board)',
	
	'forum-board-title-validation-invalid' => 'Board name contains invalid characters',
	'forum-board-title-validation-length' => 'Board name should be at least 4 characters long',
	'forum-board-title-validation-exists' => 'A Board of the same name already exists',
	'forum-board-validation-count' => 'The maximum number of boards is $1',
	
	'forum-board-description-validation-length' => 'Please write a description for this board',
	'forum-board-id-validation-missing' => 'Board id is missing',

	'forum-board-destination-validation-missing' => 'You need to choose a board to merge',
	'forum-board-title-validation-compare-error' => 'You need typing in the name of the board you are deleting',
	
	'forum-board-no-board-warning' => 'We couldn\'t find a board with that title.  Here\'s the list of forum boards.',
);

$messages['qqq'] = array(
	'forum-forum-title' => 'The main title for the forum.',
	'forum-board-title' => 'appears in the header of board page',

	'forum-specialpage-title' => 'Appears as the main title of the forum and also in the browser title bar.',
	'forum-specialpage-blurb-heading' => 'Heading for the introduction text.',
	'forum-specialpage-blurb' => 'A optional short description of the forum.  By default, this should be blank, and should not be translated.  It is for wikis to decide to change this message.',
	'forum-specialpage-board-threads' => 'The count of threads on a board. Parameters: * $1 - the number of threads.  Use formatnum for local formatting.',
	'forum-specialpage-board-posts' => 'The count of posts on a board. Parameters: * $1 - the number of posts.  Use formatnum for local formatting.',
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
	'forum-admin-create-new-board-label' => 'Button label to create a new forum board',
	'forum-autoboard-title-1' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-1' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-2' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-2' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-3' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-3' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-4' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-4' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-autoboard-title-5' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-5' => 'Description for default board.The length of this message needs to be between 4 and 255.',

	'forum-admin-page-heading' => 'Page label and heading for board admin page',
	'forum-admin-page-breadcrumb' => 'Breadcrumb heading',
	'forum-admin-create-new-board-label' => 'Call to action on creating new board',
	'forum-admin-create-new-board-modal-heading' => 'Modal heading for create a new board dialog',
	'forum-admin-create-new-board-title' => 'Form input label for board title',
	'forum-admin-create-new-board-description' => 'Form input label board description',
	
	'forum-admin-delete-and-merge-board-modal-heading' => 'Heading for delete and merge dialog. $1 is board name',
	'forum-admin-delete-board-title' => 'Label for board name verification for deletion',
	'forum-admin-merge-board-warning' => 'Help text letting users know that threads under a deleted board needs to be merged to existing board',
	'forum-admin-merge-board-destination' => 'Label for board selection dropdown to merge to',
	'forum-admin-delete-and-merge-button-label' => 'Delete and Merge button label',
	
	'forum-board-title-validation-invalid' => 'Display on board create in case of validation error ',
	'forum-board-title-validation-length' => 'Display on board create in case of validation error ',
	'forum-board-title-validation-exists' => 'Display on board create in case of validation error ',
	'forum-board-title-validation-compare-error' => 'Display on board create in case of validation error ',
	'forum-board-validation-count' => 'Display on board create in case of validation error ',
	 
	'forum-board-description-validation-length' => 'Display on board create in case of validation error ',
	'forum-board-destination-validation-missing' => 'Display on board create in case of validation error ',
	'forum-board-id-validation-missing' => 'User should not see this message unless they hack the wiki.  Nevertheless, it is a validation error when it is not provided.',
	
);
