<?php
/**
* Internationalisation file for the Forum extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Active Discussion|Active Discussions}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Active Discussion|Active Discussions}} about: '''[[$2]]'''",

	/* Heading Bar */
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Thread<br />in this Forum|Threads<br />in this Forum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Active<br />Discussion|Active<br />Discussions}}</span>',

	/* Forum:Special (Index) */
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading You can edit it<span>',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|thread|threads}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|post|posts}}',
	'forum-specialpage-board-lastpostby' => 'Last post by',
	'forum-specialpage-policies-edit' => 'Edit',
	'forum-specialpage-policies' => 'Forum Policies / FAQ',
	'forum-policies-and-faq' => "==Forum policies==
Before contributing to the {{SITENAME}} Forums, please keep in mind a few best practices for conduct:

'''Be nice and treat people with respect.'''
: People from all around the world read and edit this wiki and its forums. Like any other collaborative project, not everyone will agree all the time. Keep discussions civil and be open minded about differing opinions. We're all here because we love the same topic.

'''Try to find existing discussions first, but don't be afraid to start a new thread.'''
:Please take a moment to sift through the {{SITENAME}} Forum boards to see if a discussion already exists about something you want to talk about. If you can't find what you're looking for, jump right in and start a new discussion!

'''Ask for help.'''
:Notice something that doesn't seem right? Or do you have a question? Ask for help here on the forums! If you need help from Wikia staff, please reach out on [[w:c:community|Community Central]] or via [[Special:Contact]].

'''Have fun!'''
:The {{SITENAME}} community is happy to have you here. We look forward to seeing you around as we discuss this topic we all love.

==Forum FAQ==
'''How do I stay on top of discussions I'm interested in?'''
: With a Wikia user account, you can follow specific conversations and then receive notification messages (either on-site or via email) when a discussion has more activity. Be sure to [[Special:UserSignup|sign up for a Wikia account]] if you don't already have one.

'''How do I remove vandalism?'''
: If you notice some spam or vandalism on a thread, hover your mouse over the offending text. You'll see a \"More\" button appear. Inside the \"More\" menu, you'll find \"Remove\". This will allow you to remove the vandalism and optionally inform an admin.

'''What are Kudos?'''
: If you find a particular discussion or reply interesting, well thought out, or amusing you can show direct appreciation by giving it Kudos. They can be helpful in voting situations, too.

'''What are Topics?'''
: Topics allow you to link a forum discussion with a wiki article. It's another way to keep Forums organized and to help people find interesting discussions. For example, a Forum thread tagged with \"Lord Voldemort\" will appear at the bottom of the \"Lord Voldemort\" article.",

	/* Forum Board */

	'forum-board-title' => '$1 board',
	'forum-board-topic-title' => 'Discussions about $1',
	'forum-board-topics' => 'Topics',
	'forum-board-thread-follow' => 'Follow',
	'forum-board-thread-following' => 'Following',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Message|Messages}}',
	'forum-board-new-message-heading' => 'Start a Discussion',

	'forum-no-board-selection-error' => '← Please select a board to post to',

	/* Forum Thread */
	'forum-thread-reply-placeholder' => 'Post a reply',
	'forum-thread-reply-post' => 'Reply',
	'forum-thread-deleted-return-to' => 'Return to $1 board',

	/* Sorting */
	'forum-sorting-option-newest-replies' => 'Most Recent Replies',
	'forum-sorting-option-popular-threads' => 'Most Popular',
	'forum-sorting-option-most-replies' => 'Most Active in 7 Days',
	'forum-sorting-option-newest-threads' => 'Newest Threads',
	'forum-sorting-option-oldest-threads' => 'Oldest Threads',

	/* New Discussion */
	'forum-discussion-post' => 'Post',
	'forum-discussion-highlight' => 'Highlight this discussion',
	'forum-discussion-placeholder-title' => 'What do you want to talk about?',
	'forum-discussion-placeholder-message' => 'Post a new message to the $1 board',
	'forum-discussion-placeholder-message-short' => 'Post a new message',

	/* Notification */
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|replied}} to your thread on the $3 board',
	'forum-notification-user2-reply-to-your' => '$1 and $2 replied to your thread on the $3 board',
	'forum-notification-user3-reply-to-your' => '$1 and others replied to your thread the $3 board',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|replied}} on the $3 board',
	'forum-notification-user2-reply-to-someone' => '$1 and $2 replied on the $3 board',
	'forum-notification-user3-reply-to-someone' => '$1 and others replied on the $3 board',

	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|left}} a new message on the $2 board',

	/* Mail message */
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME wrote a new thread on $WIKI\'s $BOARDNAME board.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME wrote a new thread on $WIKI\'s $BOARDNAME board.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME replied to your thread on $WIKI\'s $BOARDNAME board',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME replied on $WIKI\'s $BOARDNAME board',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME replied on $WIKI\'s $BOARDNAME board',
	'forum-mail-notification-html-greeting' => 'Hi $1,',
	'forum-mail-notification-html-button' => 'See the conversation',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hi $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

See the conversation: ($MESSAGE_LINK)

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
___________________________________________<br />
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

 	'forum-autoboard-title-3' => 'New on $1',
	'forum-autoboard-body-3' => "Want to share something that's just been posted on this wiki, or congratulate somebody for an outstanding contribution? This is the place!",

	'forum-autoboard-title-4' => 'Questions and Answers',
	'forum-autoboard-body-4' => 'Got a question about the wiki, or the topic? Ask your questions here!',

	'forum-autoboard-title-5' => 'Fun and Games',
	'forum-autoboard-body-5' => 'This board is for off-topic conversation -- a place to hang out with your $1 friends.',

	/* board creation validation messages */
	'forum-board-destination-empty' => '(Please select board)',

	'forum-board-title-validation-invalid' => 'Board name contains invalid characters',
	'forum-board-title-validation-length' => 'Board name should be at least 4 characters long',
	'forum-board-title-validation-exists' => 'A Board of the same name already exists',
	'forum-board-validation-count' => 'The maximum number of boards is $1',

	'forum-board-description-validation-length' => 'Please write a description for this board',
	'forum-board-id-validation-missing' => 'Board id is missing',

	'forum-board-no-board-warning' => 'We couldn\'t find a board with that title.  Here\'s the list of forum boards.',

	/* old forum notification */
	'forum-old-notification-message' => 'This Forum has been archived',
	'forum-old-notification-navigation-button' => 'Visit the new Forums',

	/* messages for Related Discussions Module on Article page */
	'forum-related-discussion-heading' => 'Discussions about $1',
	'forum-related-discussion-new-post-button' => 'Start a Discussion',
	'forum-related-discussion-new-post-tooltip' => 'Start a new discussion about $1',
	'forum-related-discussion-total-replies' => '$1 messages',
	'forum-related-discussion-zero-state-creative' => 'You can find discussions about everything related to this wiki on [[Special:Forum|{{SITENAME}} Forum!]]',
	'forum-related-discussion-see-more' => 'See more discussions',
	'forum-confirmation-board-deleted' => '"$1" has been deleted.',
);

/** Message documentation (Message documentation)
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'forum-forum-title' => 'The main title for the forum.
{{Identical|Forum}}',
	'forum-active-threads' => 'Total number of active threads in a forum board. Appears above the list of all threads in a forum board. Parameters:
* $1 is the number of active threads',
	'forum-active-threads-on-topic' => 'Total number of active threads in a forum topic. Appears above the list of all threads in a forum topic. Parameters:
* $1 is the number of active threads
* $2 is the name of the topic',
	'forum-header-total-threads' => 'Total number of threads in a forum. Appears above the list of boards on the main Forum page next to the page title. Parameters:
* $1 is the number of threads',
	'forum-header-active-threads' => 'Total number of threads in a forum. Appears above the list of boards on the main Forum page next to the page title. Parameters:
* $1 is the number of active threads',
	'forum-specialpage-heading' => 'The title of the forum special page. Used at the top of the main forum page.
{{Identical|Forum}}',
	'forum-specialpage-blurb-heading' => 'Heading for the introduction text. This for wikis to change to be used in combination with forum-specialpage-blurb to add text to the bottom of Special:Forum.',
	'forum-specialpage-blurb' => 'A optional short description of the forum.  By default, this should be blank, and should not be translated.  It is for wikis to decide to change this message.',
	'forum-specialpage-board-threads' => 'The count of threads on a board. Parameters: * $1 - the number of threads.',
	'forum-specialpage-board-posts' => 'The count of posts on a board. Parameters: * $1 - the number of posts.',
	'forum-specialpage-board-lastpostby' => 'Displayed on the list of boards on the main forum special page, showing which user most recently posted on the listed board.',
	'forum-specialpage-policies-edit' => 'Edit button on modal with forum policies.
{{Identical|Edit}}',
	'forum-specialpage-policies' => 'Button label for forum policies',
	'forum-policies-and-faq' => 'Default policies and faq',
	'forum-board-title' => 'Appears in the header of board page. $1 is the title of the board.',
	'forum-board-topic-title' => 'The title of the topic page. Parameters:
* $1 is the title of the topic',
	'forum-board-topics' => 'Topics title used in the path at the top of a topic thread list.
{{Identical|Topic}}',
	'forum-board-thread-follow' => 'Text of the link to start following a thread.
{{Identical|Follow}}',
	'forum-board-thread-following' => 'Text of the link to stop following a thread.
{{Identical|Following}}',
	'forum-board-thread-kudos' => 'The number of kudos a thread has received which is displayed next to the thread link on lists.

Parameters:
* $1 -the number of kudos a thread has received
{{Identical|Kudos}}',
	'forum-board-thread-replies' => 'The number of replies a thread has received which is displayed next to the thread link on lists. Parameters:
* $1 the number of replies a thread has received',
	'forum-board-new-message-heading' => 'Title of the start a new thread input box.',
	'forum-no-board-selection-error' => 'Error message displayed when trying to create a new thread without selecting a board to post it to. Appears next to a dropdown list of available boards.',
	'forum-thread-reply-placeholder' => 'Placeholder text shown in reply text box.',
	'forum-thread-reply-post' => 'Text of the submit button when replying to thread posts.
{{Identical|Reply}}',
	'forum-thread-deleted-return-to' => 'Message shown when a user has deleted a thread. $1 is the name of the board the deleted thread was on.',
	'forum-sorting-option-newest-replies' => 'Sorting option for listing threads ordered by most recent replies.',
	'forum-sorting-option-popular-threads' => 'Sorting option for listing threads ordered by popularity.',
	'forum-sorting-option-most-replies' => 'Sorting option for listing threads by number of replies.',
	'forum-sorting-option-newest-threads' => 'Sorting option, newest threads first',
	'forum-sorting-option-oldest-threads' => 'Sorting option, oldest threads first',
	'forum-discussion-post' => 'Text of the submit button when creating a new thread.
{{Identical|Post}}',
	'forum-discussion-highlight' => 'Checkbox option to highlight a discussion displayed when creating a thread.',
	'forum-discussion-placeholder-title' => 'Placeholder text shown in an input box when creating a thread.',
	'forum-discussion-placeholder-message' => 'Placeholder text shown in an input box when creating a thread. Paramaters:
* $1 is the title of the board the thread will be posted to',
	'forum-discussion-placeholder-message-short' => 'Display on topic page inside new discussion body textarea',
	'forum-notification-user1-reply-to-your' => 'Notification when someone replies on your thread. Parameters:
* $1 is the username of the user that left the message (GENDER is supported in this message).
* $3 is the name of the board that the reply was left on.
* $4 is the username of the registered user seeing this message (for GENDER support).',
	'forum-notification-user2-reply-to-your' => "Notification when 2 users reply on the logged in user's thread. Parameters:
* $1 and $2 are names of users that replied (GENDER is supported in this message).
* $3 is the name of the board that the reply was left on.
* $4 is the username of the registered user seeing this message (for GENDER support).",
	'forum-notification-user3-reply-to-your' => "Notification when 3 or more users reply on the logged in user's thread. Parameters:
* $1 is the first user who replied (GENDER is supported in this message).
* $3 is the name of the board that the reply was left on.
* $4 is the username of the registered user seeing this message (for GENDER support).",
	'forum-notification-user1-reply-to-someone' => 'Notification message displayed when a user replies to a thread. Parameters:
* $1 is the name of the user replying
* $3 is the title of the board that the reply was posted to',
	'forum-notification-user2-reply-to-someone' => 'Notification message displayed when two users reply to a thread. Parameters:
* $1 is the name of the user replying
* $2 is the name of the other user replying
* $3 is the title of the board that the reply was posted to',
	'forum-notification-user3-reply-to-someone' => 'Notification message displayed when three or more users reply to a thread. Parameters:
* $1 is the name of the user replying
* $3 is the title of the board that the reply was posted to',
	'forum-notification-newmsg-on-followed-wall' => 'Notification message displayed when a user posts a new message to two a board the logged-in user is following. Parameters:
* $1 is the name of the user posting the message
* $2 is the title of the board that the message was posted to',
	'forum-mail-notification-new-someone' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name
* $BOARDNAME is the title of the board',
	'forum-mail-notification-new-your' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name
* $BOARDNAME is the title of the board',
	'forum-mail-notification-reply-your' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name
* $BOARDNAME is the title of the board',
	'forum-mail-notification-reply-his' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name
* $BOARDNAME is the title of the board',
	'forum-mail-notification-reply-someone' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name
* $BOARDNAME is the title of the board',
	'forum-mail-notification-html-greeting' => 'E-mail notification greeting. Parameters:
* $1 is the username',
	'forum-mail-notification-html-button' => 'Email notification, text of the button the user can click to visit the thread.',
	'forum-mail-notification-subject' => 'Email notification subject. Parameters:
* $1 - the thread title
* $2 - the wiki name',
	'forum-mail-notification-body' => 'E-mail notification body text.',
	'forum-mail-notification-body-HTML' => 'E-mail notification body text with HTML.',
	'forum-wiki-activity-msg' => 'Link to the board a thread is posted to, used for entries on the WikiActivity special page. Parameters:
* $1 is a link to the board',
	'forum-wiki-activity-msg-name' => 'Text of the link to the board a thread is posted to used for entries on the WikiActivity special page. Parameters:
* $1 is the board title',
	'forum-activity-module-heading' => 'Forum Activity right rail module heading',
	'forum-related-module-heading' => 'Related Threads right rail module heading.',
	'forum-activity-module-posted' => '$1 is username, $2 is url to user page, $3 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-activity-module-started' => 'Displays user activity in the Forum Activity module. Parameters:
* $1 is the username
* $2 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-contributions-line' => "Contributions item. Parameters:
* $5 is the timestamp
* $6 is the diff link if applicable
* $7 is the history link
* $8 is N if it's a new thread
* $2 is the thread title
* $4 is the board title",
	'forum-recentchanges-new-message' => 'The text added after the article link on recent changes entries. Parameters:
* $2 is the board title',
	'forum-recentchanges-edit' => 'Default edit summary text on recent changes',
	'forum-recentchanges-removed-thread' => 'Recent changes item. Parameters:
* $2 is the thread title
* $4 is the board the thread is posted to
* $5 is an optional username of the performer that can be used with GENDER',
	'forum-recentchanges-removed-reply' => 'Recent changes item. Parameters:
* $2 is the thread title
* $4 is the board the thread is posted to
* $5 is an optional username of the performer that can be used with GENDER',
	'forum-recentchanges-restored-thread' => 'Recent changes item. Parameters:
* $2 is the thread title
* $4 is the board the thread is posted to
* $5 is an optional username of the performer that can be used with GENDER',
	'forum-recentchanges-restored-reply' => 'Recent changes item. Parameters:
* $2 is the thread title
* $4 is the board the thread is posted to
* $5 is an optional username of the performer that can be used with GENDER',
	'forum-recentchanges-deleted-thread' => 'Recent changes item. Parameters:
* $2 is the thread title
* $4 is the board the thread is posted to
* $5 is an optional username of the performer that can be used with GENDER',
	'forum-recentchanges-deleted-reply' => 'Recent changes item. Parameters:
* $2 is the thread title
* $4 is the board the thread is posted to
* $5 is an optional username of the performer that can be used with GENDER',
	'forum-recentchanges-deleted-reply-title' => 'Fallback reply title for deleted replies on recent changes.
{{Identical|Post}}',
	'forum-recentchanges-namespace-selector-message-wall' => 'Item in namespace dropdown on recent changes',
	'forum-recentchanges-thread-group' => 'Grouped recent changes item. Parameters:
* $1 is the thread title
* $2 is link to the board on which the thread is posted
* $3 is title of the board on which the thread is posted',
	'forum-recentchanges-history-link' => 'Link to board history for items about removed and deleted threads on recent changes.',
	'forum-recentchanges-thread-history-link' => 'Link to thread history for items about removed replies on recent changes.',
	'forum-recentchanges-closed-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is thread owner
* $5 is optional username and you can use it with GENDER parameter',
	'forum-recentchanges-reopened-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is thread owner
* $5 is optional username and you can use it with GENDER parameter',
	'forum-board-history-title' => 'Heading on the board history page.',
	'forum-specialpage-oldforum-link' => 'Text of link to old archived forums.',
	'forum-admin-page-breadcrumb' => 'Breadcrumb heading',
	'forum-admin-create-new-board-label' => 'Button label to create a new forum board',
	'forum-admin-create-new-board-modal-heading' => 'Modal heading for create a new board dialog',
	'forum-admin-create-new-board-title' => 'Form input label for board title',
	'forum-admin-create-new-board-description' => 'Form input label board description',
	'forum-admin-edit-board-modal-heading' => 'Heading on the board editing modal. Parameters:
* $1 is the borad title.',
	'forum-admin-edit-board-title' => 'Text next to the inputbox to edit the board title in the board editing modal.',
	'forum-admin-edit-board-description' => 'Text next to the inputbox to edit the board description in the board editing modal.',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Heading for delete and merge dialog. $1 is board name',
	'forum-admin-delete-board-title' => 'Label for board name verification for deletion',
	'forum-admin-merge-board-warning' => 'Help text letting users know that threads under a deleted board needs to be merged to existing board',
	'forum-admin-merge-board-destination' => 'Label for board selection dropdown to merge to',
	'forum-admin-delete-and-merge-button-label' => 'Delete and Merge button label',
	'forum-admin-link-label' => 'A call-to-action label for link that will take wiki admins to forum board admin page',
	'forum-autoboard-title-1' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-1' => 'Description for default board.The length of this message needs to be between 4 and 255.',
	'forum-autoboard-title-2' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-2' => 'Description for default board.The length of this message needs to be between 4 and 255.',
	'forum-autoboard-title-3' => 'Title for default board.The length of this message needs to be between 4 and 40. $1 is the site name.',
	'forum-autoboard-body-3' => 'Description for default board.The length of this message needs to be between 4 and 255.',
	'forum-autoboard-title-4' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-4' => 'Description for default board.The length of this message needs to be between 4 and 255.',
	'forum-autoboard-title-5' => 'Title for default board.The length of this message needs to be between 4 and 40.',
	'forum-autoboard-body-5' => 'Description for default board.The length of this message needs to be between 4 and 255. $1 is the site name.',
	'forum-board-destination-empty' => 'Default text of the dropdown list of available boards for a user to post a new thread to.',
	'forum-board-title-validation-invalid' => 'Display on board create in case of validation error',
	'forum-board-title-validation-length' => 'Display on board create in case of validation error',
	'forum-board-title-validation-exists' => 'Display on board create in case of validation error',
	'forum-board-validation-count' => 'Display on board create in case of validation error. $1 is the maximum number of boards allowed.',
	'forum-board-description-validation-length' => 'Display on board create in case of validation error',
	'forum-board-id-validation-missing' => 'User should not see this message unless they hack the wiki.  Nevertheless, it is a validation error when it is not provided.',
	'forum-board-no-board-warning' => 'Warning displayed when a board was not found. Displayed as a warning message at the top of the Forum page listing all the boards',
	'forum-old-notification-message' => 'Notification displayed on old archived forum pages.',
	'forum-old-notification-navigation-button' => 'Link to the new forums that appears at the top of old archived forum pages.',
	'forum-related-discussion-heading' => 'Section heading for related discussion section.  $1 is article that this section will be on.',
	'forum-related-discussion-new-post-button' => 'Text of the button that appears in the related forums module at the bottom of article pages.',
	'forum-related-discussion-new-post-tooltip' => 'Text of the button that appears in the related forums module at the bottom of article pages. Parameters:
* $1 is the title of the article',
	'forum-related-discussion-total-replies' => 'Label showing total number of replies in a discussion.  $1 is number of replies',
	'forum-related-discussion-zero-state-creative' => 'Text displayed in the related forums module at the bottom of article pages if there are currently no discussions about that article.',
	'forum-related-discussion-see-more' => 'See More link to topic page',
	'forum-confirmation-board-deleted' => 'Board delete confirmation message. $1 is board name',
);

/** Catalan (català)
 * @author Grondin
 */
$messages['ca'] = array(
	'forum-active-threads' => '$1 {{PLURAL:$1|discussió activa|discussions actives}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|discussió activa|discussions actives}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|fil<br />en aquest fòrum|fils<br />en aquest fòrum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|discussió activa|discussions actives}}</span>',
	'forum-specialpage-heading' => 'Fòrum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Podeu editar-lo<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|fil|fils}}',
	'forum-specialpage-board-lastpostby' => 'Última tramesa per',
	'forum-specialpage-policies-edit' => 'Edita',
	'forum-specialpage-policies' => 'Política del fòrum / FAQ',
	'forum-board-new-message-heading' => 'Inicia una discussió',
	'forum-thread-reply-placeholder' => 'Deixar una resposta',
	'forum-thread-reply-post' => 'Contesta',
	'forum-confirmation-board-deleted' => "S'ha suprimit “$1”.",
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '{{PLURAL:$1|Eine aktive Diskussion|$1 aktive Diskussionen}}',
	'forum-active-threads-on-topic' => "{{PLURAL:$1|Eine aktive Diskussion|$1 aktive Diskussionen}} über: '''[[$2]]'''",
	'forum-header-total-threads' => '<span>{{PLURAL:$1|Ein Thread<br />in diesem Forum|<em>$1</em> Threads<br />in diesem Forum}}</span>',
	'forum-header-active-threads' => '<span>{{PLURAL:$1|Eine aktive<br />Diskussion|<em>$1</em> aktive<br />Diskussionen}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Du kannst es bearbeiten<span>',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '{{PLURAL:$1|Ein Thread|$1 Threads}}',
	'forum-specialpage-board-posts' => '{{PLURAL:$1|Ein Beitrag|$1 Beiträge}}',
	'forum-specialpage-board-lastpostby' => 'Letzter Beitrag von',
	'forum-specialpage-policies-edit' => 'Bearbeiten',
	'forum-specialpage-policies' => 'Forumrichtlinien / Häufig gestellte Fragen',
	'forum-board-title' => 'Board „$1“',
	'forum-board-topic-title' => 'Diskussionen über $1',
	'forum-board-topics' => 'Themen',
	'forum-board-thread-follow' => 'Folgen',
	'forum-board-thread-following' => 'Nicht mehr folgen',
	'forum-board-thread-kudos' => '$1 Lobe',
	'forum-board-thread-replies' => '{{PLURAL:$1|Eine Nachricht|$1 Nachrichten}}',
	'forum-board-new-message-heading' => 'Eine Diskussion starten',
	'forum-no-board-selection-error' => '← Bitte wähle ein Board aus',
	'forum-thread-reply-placeholder' => 'Eine Antwort hinterlassen',
	'forum-thread-reply-post' => 'Antworten',
	'forum-thread-deleted-return-to' => 'Zurück zu $1',
	'forum-sorting-option-newest-replies' => 'Die meisten letzten Antworten',
	'forum-sorting-option-popular-threads' => 'Am beliebtesten',
	'forum-sorting-option-most-replies' => 'Am aktivsten in den letzten 7 Tagen',
	'forum-sorting-option-newest-threads' => 'Neueste Threads',
	'forum-sorting-option-oldest-threads' => 'Älteste Threads',
	'forum-discussion-post' => 'Speichern',
	'forum-discussion-highlight' => 'Diese Diskussion hervorheben',
	'forum-discussion-placeholder-title' => 'Über was willst du sprechen?',
	'forum-discussion-placeholder-message' => 'Eine neue Nachricht auf dem Board $1 hinterlassen',
	'forum-discussion-placeholder-message-short' => 'Eine neue Nachricht hinterlassen',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|antwortete}} auf deinen Thread auf dem Board $3',
	'forum-notification-user2-reply-to-your' => '$1 und $2 antworteten auf deinen Thread auf dem Board $3',
	'forum-notification-user3-reply-to-your' => '$1 und andere antworteten auf deinen Thread auf dem Board $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|antwortete}} auf dem Board $3',
	'forum-notification-user2-reply-to-someone' => '$1 und $2 antworteten auf dem Board $3',
	'forum-notification-user3-reply-to-someone' => '$1 und andere antworteten auf dem Board $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|hinterließ}} eine neue Nachricht auf dem Board $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME schrieb einen neuen Thread auf dem Board $BOARDNAME von $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME schrieb einen neuen Thread auf dem Board $BOARDNAME von $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME antwortete auf deinen Thread auf dem Board $BOARDNAME von $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME antwortete auf dem Board $BOARDNAME von $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME antwortete auf dem Board $BOARDNAME von $WIKI',
	'forum-mail-notification-html-greeting' => 'Hallo $1,',
	'forum-mail-notification-html-button' => 'Die Konversation ansehen',
	'forum-mail-notification-subject' => '$1 – $2',
	'forum-mail-notification-body' => 'Hallo $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Die Konversation ansehen: ($MESSAGE_LINK)

Das Wikia-Team

___________________________________________
* Bekomme Hilfe und Ratschläge auf Community Central: http://community.wikia.com
* Möchtest du weniger Nachrichten von uns erhalten? Du kannst dich von den E-Mail-Benachrichtigungen
abmelden oder deine E-Mail-Einstellungen hier ändern: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hallo $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Die Konversation ansehen</a></p>
<p>Das Wikia-Team</p>
___________________________________________<br />
* Bekomme Hilfe und Ratschläge auf Community Central: http://community.wikia.com
* Möchtest du weniger Nachrichten von uns erhalten? Du kannst dich von den E-Mail-Benachrichtigungen
abmelden oder deine E-Mail-Einstellungen hier ändern: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'auf dem Board $1',
	'forum-wiki-activity-msg-name' => 'Board „$1“',
	'forum-activity-module-heading' => 'Forumaktivität',
	'forum-related-module-heading' => 'Ähnliche Threads',
	'forum-activity-module-posted' => '$1 hinterließ eine Antwort $2',
	'forum-activity-module-started' => '$1 startete eine Diskussion $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> auf dem <a href="$3">Board $4</a>',
	'forum-recentchanges-new-message' => 'auf dem <a href="$1">Board $2</a>',
	'forum-recentchanges-edit' => '(Nachricht bearbeitet)',
	'forum-recentchanges-removed-thread' => 'Thread „[[$1|$2]]“ vom [[$3|Board $4]] entfernt',
	'forum-recentchanges-removed-reply' => 'Antwort von „[[$1|$2]]“ aus dem [[$3|Board $4]] entfernt',
	'forum-recentchanges-restored-thread' => 'Thread „[[$1|$2]]“ auf dem [[$3|Board $4]] wiederhergestellt',
	'forum-recentchanges-restored-reply' => 'Antwort auf „[[$1|$2]]“ auf dem [[$3|Board $4]] wiederhergestellt',
	'forum-recentchanges-deleted-thread' => 'Thread „[[$1|$2]]“ vom [[$3|Board $4]] gelöscht',
	'forum-recentchanges-deleted-reply' => 'Antwort von „[[$1|$2]]“ vom [[$3|Board $4]] gelöscht',
	'forum-recentchanges-deleted-reply-title' => 'Ein Beitrag',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forumboard',
	'forum-recentchanges-thread-group' => '$1 auf dem <a href="$2">Board „$3“</a>',
	'forum-recentchanges-history-link' => 'Boardverlauf',
	'forum-recentchanges-thread-history-link' => 'Threadverlauf',
	'forum-recentchanges-closed-thread' => 'Thread „[[$1|$2]]“ von [[$3|$4]] geschlossen',
	'forum-recentchanges-reopened-thread' => 'Thread „[[$1|$2]]“ von [[$3|$4]] wieder eröffnet',
	'forum-board-history-title' => 'Boardverlauf',
	'forum-specialpage-oldforum-link' => 'Archive alter Foren',
	'forum-admin-create-new-board-label' => 'Neues Board erstellen',
	'forum-admin-create-new-board-modal-heading' => 'Ein neues Board erstellen',
	'forum-admin-create-new-board-title' => 'Boardtitel',
	'forum-admin-create-new-board-description' => 'Boardbeschreibung',
	'forum-admin-edit-board-modal-heading' => 'Board bearbeiten: $1',
	'forum-admin-edit-board-title' => 'Boardtitel',
	'forum-admin-edit-board-description' => 'Boardbeschreibung',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Board löschen: $1',
	'forum-admin-delete-board-title' => 'Bitte bestätige durch die Eingabe des Boardnamens die Löschung:',
	'forum-admin-merge-board-warning' => 'Die Threads auf diesem Board werden in einen vorhandenen Board zusammengeführt.',
	'forum-admin-merge-board-destination' => 'Wähle ein Board zum Zusammenführen aus:',
	'forum-admin-delete-and-merge-button-label' => 'Löschen und zusammenführen',
	'forum-admin-link-label' => 'Boards verwalten',
	'forum-autoboard-title-1' => 'Allgemeine Diskussionen',
	'forum-autoboard-body-1' => 'Dieses Board ist für allgemeine Konversationen über das Wiki.',
	'forum-autoboard-title-2' => 'Nachrichten und Ankündigungen',
	'forum-autoboard-body-2' => 'Eilmeldungen und Informationen!',
	'forum-autoboard-title-3' => 'Neu auf $1',
	'forum-autoboard-body-3' => 'Willst du etwas teilen, das soeben auf diesem Wiki gepostet wurde oder jemanden für einen herausragenden Beitrag beglückwünschen? Das ist der richtige Ort!',
	'forum-autoboard-title-4' => 'Fragen und Antworten',
	'forum-autoboard-body-4' => 'Hast du eine Frage über das Wiki oder das Thema? Stelle deine Fragen hier!',
	'forum-autoboard-title-5' => 'Spaß und Spiele',
	'forum-autoboard-body-5' => 'Dieses Board ist für Off-Topic-Konversationen – Ein Platz zum Rumhängen mit deinen $1-Freunden.',
	'forum-board-destination-empty' => '(Bitte Board auswählen)',
	'forum-board-title-validation-invalid' => 'Der Boardname enthält ungültige Zeichen',
	'forum-board-title-validation-length' => 'Der Boardname sollte mindestens 4 Zeichen lang sein',
	'forum-board-title-validation-exists' => 'Ein Board mit dem gleichen Namen ist bereits vorhanden',
	'forum-board-validation-count' => 'Die maximale Anzahl von Boards ist $1',
	'forum-board-description-validation-length' => 'Bitte gib eine Beschreibung für dieses Board ein',
	'forum-board-id-validation-missing' => 'Die Boardkennung fehlt',
	'forum-board-no-board-warning' => 'Es konnte kein Board mit diesem Titel gefunden werden. Hier ist eine Liste der Forumboards.',
	'forum-old-notification-message' => 'Dieses Forum wurde archiviert',
	'forum-old-notification-navigation-button' => 'Die neuen Foren besuchen',
	'forum-related-discussion-heading' => 'Diskussionen über $1',
	'forum-related-discussion-new-post-button' => 'Eine Diskussion starten',
	'forum-related-discussion-new-post-tooltip' => 'Eine neue Diskussion über $1 starten',
	'forum-related-discussion-total-replies' => '$1 Nachrichten',
	'forum-related-discussion-zero-state-creative' => 'Du kannst Diskussionen über alles mit Bezug zu diesem Wiki im [[Special:Forum|{{SITENAME}}-Forum]] finden!',
	'forum-related-discussion-see-more' => 'Weitere Diskussionen ansehen',
	'forum-confirmation-board-deleted' => '„$1“ wurde gelöscht.',
);

/** French (français)
 * @author Crochet.david
 */
$messages['fr'] = array(
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Discussion Active|Discussions Actives}}',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Discussion<br />Active|Discussions<br />Actives}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-board-lastpostby' => 'Dernier message par',
	'forum-specialpage-policies-edit' => 'Modifier',
	'forum-board-topic-title' => 'Discussions au sujet de $1',
	'forum-board-topics' => 'Sujets',
	'forum-board-thread-follow' => 'Suivre',
	'forum-board-thread-following' => 'Suivi',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Message|Messages}}',
	'forum-board-new-message-heading' => 'Démarrer une Discussion',
	'forum-thread-reply-placeholder' => 'Envoyer une réponse',
	'forum-thread-reply-post' => 'Répondre',
	'forum-sorting-option-newest-replies' => 'Dernières réponses',
	'forum-sorting-option-popular-threads' => 'Plus populaires',
	'forum-sorting-option-most-replies' => 'Plus actifs en 7 jours',
	'forum-discussion-post' => 'Envoyer',
	'forum-discussion-highlight' => 'Mettre en évidence cette discussion',
	'forum-discussion-placeholder-title' => 'De quoi voulez-vous parler ?',
	'forum-discussion-placeholder-message-short' => 'Créer un nouveau message',
	'forum-mail-notification-html-greeting' => 'Bonjour $1,',
	'forum-mail-notification-html-button' => 'Voir la conversation',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-wiki-activity-msg' => 'sur le $1',
	'forum-activity-module-heading' => 'Activité du forum',
	'forum-activity-module-posted' => '$1 a posté une réponse $2',
	'forum-activity-module-started' => '$1 a démarré une discussion $2',
	'forum-recentchanges-edit' => '(message modifié)',
	'forum-specialpage-oldforum-link' => 'Anciennes Archives du forum',
	'forum-admin-delete-and-merge-button-label' => 'Supprimer et renommer',
	'forum-autoboard-title-1' => 'Discussion générale',
	'forum-autoboard-title-2' => 'Nouvelles et annonces',
	'forum-autoboard-body-2' => 'Dernières nouvelles et informations !',
	'forum-autoboard-title-3' => 'Nouveau sur $1',
	'forum-autoboard-title-4' => 'Questions et réponses',
	'forum-autoboard-title-5' => 'Jeux et divertissements',
	'forum-old-notification-message' => 'Ce Forum a été archivé',
	'forum-old-notification-navigation-button' => 'Visitez les nouveaux Forums',
	'forum-related-discussion-heading' => 'Discussions au sujet de $1',
	'forum-related-discussion-new-post-button' => 'Démarrer une Discussion',
	'forum-related-discussion-new-post-tooltip' => 'Démarrer une nouvelle discussion sur $1',
	'forum-related-discussion-total-replies' => '$1 messages',
	'forum-related-discussion-see-more' => 'Voir plus de discussions',
	'forum-confirmation-board-deleted' => '« $1 » a été supprimée.',
);

/** Japanese (日本語)
 * @author BryghtShadow
 */
$messages['ja'] = array(
	'forum-board-thread-following' => 'フォロー中',
);

/** Russian (русский)
 * @author Okras
 */
$messages['ru'] = array(
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '$1 {{PLURAL:$1|активная дискуссия|активных дискуссии}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|активная дискуссия|активных дискуссии}} оː '''[[$2]]'''",
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|тема|темы|тем}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
	'forum-specialpage-board-lastpostby' => 'Последнее сообщение от',
	'forum-specialpage-policies-edit' => 'Править',
	'forum-specialpage-policies' => 'Правила форума / ЧаВо',
	'forum-board-topics' => 'Темы',
	'forum-thread-reply-post' => 'Ответить',
	'forum-sorting-option-newest-replies' => 'Последние ответы',
	'forum-sorting-option-popular-threads' => 'Самые популярные',
	'forum-sorting-option-most-replies' => 'Наиболее активные за 7 дней',
	'forum-sorting-option-newest-threads' => 'Новые темы',
	'forum-sorting-option-oldest-threads' => 'Старые темы',
	'forum-discussion-post' => 'Сообщение',
	'forum-discussion-placeholder-message-short' => 'Создать новое сообщение',
	'forum-related-module-heading' => 'Связанные темы',
	'forum-recentchanges-edit' => '(отредактированное сообщение)',
	'forum-admin-delete-and-merge-button-label' => 'Удалить и объединить',
	'forum-autoboard-title-3' => 'Новое на $1',
	'forum-autoboard-title-4' => 'Вопросы и ответы',
	'forum-autoboard-title-5' => 'Развлечения и игры',
	'forum-old-notification-navigation-button' => 'Посетите новые форумы',
	'forum-related-discussion-heading' => 'Обсуждения о $1',
	'forum-related-discussion-new-post-button' => 'Начать обсуждение',
	'forum-related-discussion-new-post-tooltip' => 'Начать новое обсуждение о $1',
	'forum-related-discussion-total-replies' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 */
$messages['uk'] = array(
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '$1 {{PLURAL:$1|активне обговорення|активні обговорення|активних обговорень}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|активне обговорення|активні обговорення|активних обговорень}} про: '''[[$2]]'''",
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|активне<br /> обговорення|активні<br /> обговорення|активних<br /> обговорень}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Ви не можете це редагувати<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|тема|теми|тем}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|допис|дописи|дописів}}',
	'forum-specialpage-board-lastpostby' => 'Останнє повідомлення від',
	'forum-specialpage-policies-edit' => 'Змінити',
	'forum-specialpage-policies' => 'Політика форуму / ЧаП',
	'forum-board-title' => '$1 дошка',
	'forum-board-topic-title' => 'Обговорення про $1',
	'forum-board-topics' => 'Теми',
	'forum-board-thread-follow' => 'Підписатись',
	'forum-board-thread-following' => 'Підписки',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|повідомлення|повідомлення|повідомлень}}',
	'forum-board-new-message-heading' => 'Розпочати обговорення',
	'forum-no-board-selection-error' => '← Будь ласка, виберіть стіну для публікації',
	'forum-thread-reply-placeholder' => 'Опублікувати відповідь',
	'forum-thread-reply-post' => 'Відповісти',
	'forum-thread-deleted-return-to' => 'Повернутися до стіни $1',
	'forum-sorting-option-newest-replies' => 'Останні відповіді',
	'forum-sorting-option-popular-threads' => 'Найпопулярніші',
	'forum-sorting-option-most-replies' => 'Найактивніші за 7 днів',
	'forum-sorting-option-newest-threads' => 'Найновіші потоки',
	'forum-sorting-option-oldest-threads' => 'Найстаріші потоки',
	'forum-discussion-post' => 'Допис',
	'forum-discussion-highlight' => 'Виділити цю дискусію',
	'forum-discussion-placeholder-title' => 'Про що ви хочете поговорити?',
	'forum-discussion-placeholder-message' => 'Опублікувати повідомлення на стіні $1',
	'forum-discussion-placeholder-message-short' => 'Опублікувати нове повідомлення',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|відповів|відповіла}} у вашій темі на стіні $3',
	'forum-notification-user2-reply-to-your' => '$1 та $2 відповіли у вашій темі на стіні $3',
	'forum-notification-user3-reply-to-your' => '$1 та інші відповіли у вашій темі на стіні $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|відповів|відповіла}} на стіні $3',
	'forum-notification-user2-reply-to-someone' => '$1 і $2 відповів на стіні $3',
	'forum-notification-user3-reply-to-someone' => '$1 та інші відповіли на стіні $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|залишив|залишила}} нове повідомлення на стіні $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME почав нову тему на стіні $BOARDNAME у $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME почав нову тему на стіні $BOARDNAME у $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME відповів на вашу тему на стіні $BOARDNAME у  $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME відповів на стіні $BOARDNAME у  $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME відповів на стіні $BOARDNAME у  $WIKI',
	'forum-mail-notification-html-greeting' => 'Привіт $1,',
	'forum-mail-notification-html-button' => 'Переглянути розмову',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-wiki-activity-msg' => 'на $1',
	'forum-wiki-activity-msg-name' => 'стіна $1',
	'forum-activity-module-heading' => 'Діяльність форуму',
	'forum-related-module-heading' => 'Схожі потоки',
	'forum-activity-module-posted' => '$1 відправив відповідь $2',
	'forum-activity-module-started' => '$1 розпочав обговорення $2',
	'forum-recentchanges-edit' => '(відредаговане повідомлення)',
	'forum-admin-delete-and-merge-button-label' => 'Видалити і з’єднати',
	'forum-admin-link-label' => 'Управління дошкою',
	'forum-autoboard-title-1' => 'Загальне обговорення',
	'forum-autoboard-body-1' => 'Ця дошка для загальних розмов про вікі.',
	'forum-autoboard-title-2' => 'Новини і анонси',
	'forum-autoboard-body-2' => 'Останні новини та інформація!',
	'forum-autoboard-title-3' => 'Нове на $1',
	'forum-autoboard-title-4' => 'Питання та відповіді',
	'forum-autoboard-body-4' => 'Маєте питання про вікі або нову тему? Задавайте свої запитання тут!',
	'forum-autoboard-title-5' => 'Ігри та розваги',
	'forum-board-destination-empty' => '(Будь ласка, виберіть стіну)',
	'forum-old-notification-message' => 'Цей форум вже заархівований',
	'forum-old-notification-navigation-button' => 'Відвідайте нові форуми',
	'forum-related-discussion-heading' => 'Обговорення про $1',
	'forum-related-discussion-new-post-button' => 'Розпочати обговорення',
	'forum-related-discussion-new-post-tooltip' => 'Почати нове обговорення про $1',
	'forum-related-discussion-total-replies' => '$1 повідомлень',
	'forum-related-discussion-zero-state-creative' => 'Ви можете знайти обговорення всього, що відноситься до цієї вікі, на [[Special:Forum|форумі {{SITENAME}}!]]',
	'forum-related-discussion-see-more' => 'Переглянути більше обговорень',
	'forum-confirmation-board-deleted' => '"$1" було видалено.',
);
