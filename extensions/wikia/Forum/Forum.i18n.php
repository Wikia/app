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
* $1 - the number of kudos a thread has received
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

/** Old English (Ænglisc)
 * @author Espreon
 */
$messages['ang'] = array(
	'forum-specialpage-policies-edit' => 'Adihtan',
);

/** Arabic (العربية)
 * @author Claw eg
 */
$messages['ar'] = array(
	'forum-forum-title' => 'منتدى',
	'forum-active-threads' => '$1 {{PLURAL:$1|نقاش نشط|نقاشات نشطة}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|نقاش نشط|نقاشات نشطة}} عن: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|موضوع<br />في هذا المنتدى|مواضيع<br />في هذا المنتدى}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|نقاش<br />نشط|نقاشات<br />نشطة}}</span>',
	'forum-specialpage-heading' => 'منتدى',
	'forum-specialpage-blurb-heading' => '<span style="display:none">عنوان-دعاية-صفحة خاصة-منتدى يمكنك تعديله<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|موضوع|مواضيع}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|تعديل|تعديلات}}',
	'forum-specialpage-board-lastpostby' => 'آخر تعديل بواسطة',
	'forum-specialpage-policies-edit' => 'تعديل',
	'forum-specialpage-policies' => 'سياسات المنتدى / أسئلة وإجابات',
	'forum-policies-and-faq' => "==سياسات المنتدى==
قبل المساهمة في منتدى {{SITENAME}}، رجاءً ضع في الاعتبار ممارسات سلوك أفضل قليلة:

'''كن طيبًا وعامل الناس باحترام.'''
: أشخاص من جميع أنحاء العالم يقرؤون ويحرورن هذه الويكي ومنتدياتها. ومثل أي مشروع تعاوني، لن يتفق جميع الناس دائمًا. اجعل النقاشات متحضرة وكن واعيًا لاختلاف الآراء. إننا جميعًا هنا لأننا نحب نفس الموضوع.

'''حاول إيجاد نقاش موجود أولاً، لكن لا تقلق حيال بدأ موضوع جديد.'''
:رجاءً استغرق لحظة بالتدقيق خلال لوحات  منتدى {{SITENAME}} لرؤية إن كان النقاش موجود فعلاً عن شيء تود التحدث عنه. إن لم تستطع إيجاد ما تبحث عنه، لا تتردد وابدأ نقاشًا جديدًا!

'''اطلب المساعدة.'''
:لاحظت شيئًا ما لا يبدو صحيحًا؟ أو لديك سؤال؟ اطلب المساعدة على المنتديات! إن كنت تحتاج مساعدة من طاقم ويكيا، من فضلك تواصل معنا على [[w:c:community|المجتمع المركزي]] أو عبر [[Special:Contact]].

'''استمتع!'''
:إن مجتمع {{SITENAME}} سعيد بوجودك هنا. نتطلع إلى رؤيتك تناقش الموضوع الذي نحبه جميعًا.

==أسئلة وإجابات المنتدى==
'''كيف أبقى على قمة النقاشات التي أهتم بها؟'''
: بحساب مستخدم ويكيا، يمكنك متابعة محادثات محددة ثم تلقي رسائل إشعارات (إما على الموقع أو عبر البريد الإلكتروني) عندما يكون النقاش أكثر نشاطًا. تأكد من أنك [[Special:UserSignup|سجلت حسابًا بويكيا]] إن لم يكن لديك حساب فعلاً.

'''كيف أمحو التخريب؟'''
: إن لاحظت بعض المساهمات غير المرغوب بها أو بعض التخريب على موضوع، قم بتحريك فأرتك على النص المخالف. سترى زر \"المزيد\" يظهر. بداخل قائمة \"المزيد\"، ستجد \"إزالة\". سيسمح لك هذا بإزالة التخريب وسيبلغ إدرايًا بشكل اختياري.

'''ما هي الشهرة؟'''
: إن وجدت نقاشًا محددًا أو رد مثير للاهتمام، أو مدروس، أو مسلٍ يمكنك أن تظهر تقديرًا بواسطة إعطاءه شهرةً. إنهم مفيدون في حالات التصويت أيضًا.

'''ما هي المواضيع؟'''
: تسمح لك المواضيع بربط نقاش منتدى بمقالة ويكي. إنها طريقة أخرى لإبقاء المنتديات منظمة ولمساعدة الناس في إيجاد نقاشات مثيرة للاهتمام.على سبيل المثال، موضوع منتدى موسوم بـ\"لورد فولديمورت\" سيظهر أسفل مقالة \"لورد فولديمورت\".",
	'forum-board-title' => '$1 مجلس',
	'forum-board-topic-title' => 'نقاشات حول $1',
	'forum-board-topics' => 'مواضيع',
	'forum-board-thread-follow' => 'اتبع',
	'forum-board-thread-following' => 'مُتابَع',
	'forum-board-thread-kudos' => '$1 شهرة',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|رسالة|رسائل}}',
	'forum-board-new-message-heading' => 'ابدأ نقاشًا جديدًا',
	'forum-no-board-selection-error' => '← رجاءً اختر لوحة للنشر',
	'forum-thread-reply-placeholder' => 'أرسل ردًا',
	'forum-thread-reply-post' => 'رد',
	'forum-thread-deleted-return-to' => 'العودة إلى لوحة $1',
	'forum-sorting-option-newest-replies' => 'الردود الأخيرة',
	'forum-sorting-option-popular-threads' => 'الأكثر شعبية',
	'forum-sorting-option-most-replies' => 'الأكثر نشاطا في 7 أيام',
	'forum-sorting-option-newest-threads' => 'أحدث النقاشات',
	'forum-sorting-option-oldest-threads' => 'أقدم النقاشات',
	'forum-discussion-post' => 'منشور',
	'forum-discussion-highlight' => 'تسليط الضوء على هذا النقاش',
	'forum-discussion-placeholder-title' => 'عما تريد أن تتحدث؟',
	'forum-discussion-placeholder-message' => 'نشر رسالة جديدة على جدار $1',
	'forum-discussion-placeholder-message-short' => 'إرسال رسالة جديدة',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|رد|ردت|رد}} على موضوعك على لوحة $3',
	'forum-notification-user2-reply-to-your' => '$1 و $2 قاما بالرد على موضوع على لوحة $3',
	'forum-notification-user3-reply-to-your' => '$1 وآخرون قاموا بالرد على موضوعك على لوحة $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|رد|ردت|رد}} على لوحة $3',
	'forum-notification-user2-reply-to-someone' => '$1 و $2 قاما بالرد على لوحة $3',
	'forum-notification-user3-reply-to-someone' => '$1 وآخرون ردوا على لوحة $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|ترك|تركت|ترك}} رسالة جديدة على لوحة $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME {{GENDER:$AUTHOR_NAME|كتب|كتبت|كتب}} موضوعًا جديدًا على لوحة $WIKI $BOARDNAME.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME {{GENDER:$AUTHOR_NAME|رد|ردت|رد}} موضوعًا جديدًا على لوحة $WIKI $BOARDNAME.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME {{GENDER:$AUTHOR_NAME|رد|ردت|رد}} موضوعًا جديدًا على لوحة $WIKI $BOARDNAME.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME {{GENDER:$AUTHOR_NAME|رد|ردت|رد}} موضوعًا جديدًا على لوحة $WIKI $BOARDNAME.',
	'forum-mail-notification-html-greeting' => 'مرحبا $1،',
	'forum-mail-notification-html-button' => 'مشاهدة المحادثة',
	'forum-mail-notification-subject' => '$1--$2',
	'forum-mail-notification-body' => 'مرحبًا $WATCHER،

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

رؤية المحادثة: ($MESSAGE_LINK)

فريق ويكيا

___________________________________________
* يمكنك إيجاد المساعدة والنصائح على المجتمع المركزي: http://community.wikia.com
* أتريد استقبال رسائل أقل من؟ يمكنك إلغاء الاشتراك أو تغيير تفضيلات بريدك الإلكتروني من هنا: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'مرحبا $WATCHER،
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">مشاهدة المحادثة</a></p>
<p>فريق ويكيا</p>
___________________________________________<br />
* يمكنك البحث عن النصائح والمساعدة في المجتمع المركزي: http://community.wikia.com
* تريد تلقي رسائل أقل منا؟ يمكنك إلغاء الاشتراك أو تغيير
تفضيلات بريدك الإلكتروني هنا: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'على $1',
	'forum-wiki-activity-msg-name' => '$1 لوحة',
	'forum-activity-module-heading' => 'نشاط المنتدى',
	'forum-related-module-heading' => 'مواضيع ذات صلة',
	'forum-activity-module-posted' => '$1 رد على $2',
	'forum-activity-module-started' => 'بدأ $1 نقاشًا $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> على <a href="$3">جدار $4</a>',
	'forum-recentchanges-new-message' => 'على <a href="$1">$2 لوحة</a>',
	'forum-recentchanges-edit' => '(تم تعديل الرسالة)',
	'forum-recentchanges-removed-thread' => 'قام بحذف النقاش "[[$1|$2]]"  من [[$3|جدار $4]]',
	'forum-recentchanges-removed-reply' => 'حذف الرد من  "[[$1|$2]]" من [[$3|جدار $4]]',
	'forum-recentchanges-restored-thread' => 'استعاد النقاش "[[$1|$2]]" إلى [[$3|جدار $4]]',
	'forum-recentchanges-restored-reply' => 'استعاد الرد من "[[$1|$2]]" إلى [[$3|جدار $4]]',
	'forum-recentchanges-deleted-thread' => 'قام بحذف النقاش "[[$1|$2]]"  من [[$3|جدار $4]]',
	'forum-recentchanges-deleted-reply' => 'حذف الرد من  "[[$1|$2]]" من [[$3|جدار $4]]',
	'forum-recentchanges-deleted-reply-title' => 'رسالة',
	'forum-recentchanges-namespace-selector-message-wall' => 'لوحة المنتدى',
	'forum-recentchanges-thread-group' => 'على <a href="$1">$2 لوحة</a>', # Fuzzy
	'forum-recentchanges-history-link' => 'تاريخ اللوحة',
	'forum-recentchanges-thread-history-link' => 'تاريخ النقاش',
	'forum-recentchanges-closed-thread' => 'أغلق النقاش "[[$1|$2]]" من [[$3|جدار $4]]',
	'forum-recentchanges-reopened-thread' => 'أعاد فتح النقاش "[[$1|$2]]" من [[$3|جدار $4]]',
	'forum-board-history-title' => 'تاريخ اللوحة',
	'forum-specialpage-oldforum-link' => 'أرشيف منتدى قديم',
	'forum-admin-page-breadcrumb' => 'إدارة لوحة الإدارة',
	'forum-admin-create-new-board-label' => 'إنشاء لوحة جديدة',
	'forum-admin-create-new-board-modal-heading' => 'أنشئ لوحة جديدة',
	'forum-admin-create-new-board-title' => 'عنوان اللوحة',
	'forum-admin-create-new-board-description' => 'وصف اللوحة',
	'forum-admin-edit-board-modal-heading' => 'تحرير اللوحة: $1',
	'forum-admin-edit-board-title' => 'عنوان اللوحة',
	'forum-admin-edit-board-description' => 'وصف اللوحة',
	'forum-admin-delete-and-merge-board-modal-heading' => 'حذف اللوحة: $1',
	'forum-admin-delete-board-title' => 'الرجاء التأكيد بكتابة اسم اللوحة التي تريد حذفها:',
	'forum-admin-merge-board-warning' => 'سيتم دمج المواضيع على هذه اللوحة مع لوحة موجودة.',
	'forum-admin-merge-board-destination' => 'اختر لوحة لدمجها مع:',
	'forum-admin-delete-and-merge-button-label' => 'حذف ودمج',
	'forum-admin-link-label' => 'إدارة اللوحات',
	'forum-autoboard-title-1' => 'نقاش عام',
	'forum-autoboard-body-1' => 'هذه اللوحة للمحادثات العامة حول الويكي.',
	'forum-autoboard-title-2' => 'أخبار وإعلانات',
	'forum-autoboard-body-2' => 'أخبار عاجلة ومعلومات!',
	'forum-autoboard-title-3' => 'جديد على $1',
	'forum-autoboard-body-3' => 'ترغب في مشاركة شيء قد نشرت للتو في هذا الويكي، أو تهنئة شخص لمساهمة بارزة؟ إنك في المكان المناسب!',
	'forum-autoboard-title-4' => 'أسئلة وأجوبة',
	'forum-autoboard-body-4' => 'لديك سؤال عن الويكي، أو الموضوع؟ اطرح أسئلتك هنا!',
	'forum-autoboard-title-5' => 'مرح وألعاب',
	'forum-autoboard-body-5' => 'هذه اللوحة للمحادثات خارج الموضوع -- مكان لتقضية الوقت مع أصدقائك $1.',
	'forum-board-destination-empty' => '(الرجاء تحديد لوحة)',
	'forum-board-title-validation-invalid' => 'اسم اللوحة يحتوي على أحرف غير صالحة',
	'forum-board-title-validation-length' => 'اسم اللوحة يجب أن يكون على الأقل 4 أحرف.',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'forum-forum-title' => 'Форум',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-policies-edit' => 'Редактиране',
	'forum-admin-delete-and-merge-button-label' => 'Изтриване и обединяване',
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
	'forum-policies-and-faq' => "==Forumsrichtlinien==
Bevor du auf den {{SITENAME}}-Foren aktiv wirst, beachte bitte einige gute Methoden zur Durchführung:

'''Sei freundlich und behandle Menschen respektvoll.'''
: Menschen aus der ganzen Welt lesen und bearbeiten dieses Wiki und seine Foren. Wie bei jedem anderen kollaborativen Projekt wird nicht jeder die ganze Zeit mit anderen in Übereinstimmung sein. Halte Diskussionen höflich und sei offen für unterschiedliche Meinungen. Wir alle sind hier, weil wir das gleiche Thema mögen.

'''Versuche zuerst, vorhandene Diskussionen zu finden, aber scheue nicht das Starten eines neuen Threads.'''
:Nimm dir Zeit für das Durchsuchen der {{SITENAME}}-Forumboards, um zu erfahren, ob eine Diskussion bereits vorhanden ist über ein Thema, über das du sprechen willst. Falls du nicht das finden kannst, wonach du suchst, starte einfach eine neue Diskussion!

'''Bitte um Hilfe.'''
:Ist etwas nicht richtig? Oder hast du eine Frage? Bitte hier in den Foren um Hilfe! Falls du Hilfe von den Wikia-Mitarbeitern benötigst, kontaktiere bitte [[w:c:community|Community Central]] oder [[Special:Contact]].

'''Hab Spaß!'''
:Die {{SITENAME}}-Gemeinschaft ist froh, dass du hier bist. Wir diskutieren dieses Thema, das wir alle mögen.

==Häufig gestellte Fragen==
'''Wie bleibe ich bei Diskussionen auf dem neuesten Stand, an denen ich interessiert bin?'''
: Mit einem Wikia-Benutzerkonto kannst du spezielle Konversationen verfolgen und dann Benachrichtigungen erhalten (entweder per Webseite oder E-Mail), wenn eine Diskussion lebhaft ist. [[Special:UserSignup|Erstelle ein Wikia-Benutzerkonto]], wenn du noch keines hast.

'''Wie entferne ich Vandalismus?'''
: Falls du Spam oder Vandalismus in einem Thread entdeckt hast, fahre mit deiner Maus über den betroffenen Text. Du siehst die Schaltfläche „Mehr“. Innerhalb dieses Menüs findest du „Entfernen“. Dies ermöglicht dir das Entfernen von Vandalismus und optional die Kontaktierung eines Administrators.

'''Was sind Lobe?'''
: Wenn du eine bestimmte Diskussion oder Antwort interessant, durchdacht oder lustig findest, kannst du direkte Anerkennung zeigen, indem du Lobe abgibst. Das kann auch für die Beurteilung von Situationen hilfreich sein.

'''Was sind Themen?'''
: Themen ermöglichen dir, eine Forumdiskussion mit einem Wikiartikel zu verlinken. Es ist ein anderer Weg, um Foren organisiert zu halten und um Menschen beim Auffinden interessanter Diskussionen zu helfen. Zum Beispiel ist ein Forumthread, der mit „Lord Voldemort“ getaggt ist, unten auf dem Artikel „Lord Voldemort“ sichtbar.",
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
	'forum-admin-page-breadcrumb' => 'Board-Verwaltung',
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

/** Spanish (español)
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'forum-forum-title' => 'Foro',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Tema activo|Temas activos}}',
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|Tema activo|Temas activos}} sobre: [[$2]]',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Tema<br /> en este foro|Temas<br /> en este foro}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Tema<br /> Activo|Temas<br /> Activos}}</span>',
	'forum-specialpage-heading' => 'Foro',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Puedes editarlo<span>',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|tema|temas}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|mensaje|mensajes}}',
	'forum-specialpage-board-lastpostby' => 'Último mensaje escrito por',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas del Foro / FAQ',
	'forum-policies-and-faq' => "==Políticas del foro== Antes de contribuir en el foro de {{SITENAME}} ten en cuenta las siguientes prácticas: '''Trata a la gente con respeto y no tengas malas intenciones.''' : Personas de todos los lugares del mundo leen y editan en este wiki y este foro. Como cualquier proyecto colaborativo, no todo el mundo va a estar de acuerdo permanentemente con lo que se discuta así que abre tu mente a diferentes opiniones. Estamos aquí porque nos gusta lo mismo. '''Intenta encontrar discusiones existentes primero, pero no tengas miedo de iniciar un nuevo tema.''' :Por favor, tómate un momento para visitar los subforos de este wiki y ver si ya existe una discusión sobre lo que quieres hablar. Si no puedes encontrar lo que buscas, ¡comienza un nuevo tema! '''Pide ayuda.''' :¿Algo no se ve como debería? ¿Tienes alguna pregunta? ¡Pide ayuda aquí, en el foro! Si necesitas ayuda del Staff de Wikia, puedes ir a nuestra [[w:c:community|Comunidad Central]] o preguntar a través de [[Special:Contact|Especial:Contactar]]. '''¡Diviértete!''' :La comunidad de {{SITENAME}} se alegra de que estés aquí. Queremos verte hablar sobre el tema que más nos gusta, adivina cuál... ==Preguntas frecuentes sobre el foro== '''¿Cómo puedo seguir las discusiones en las que estoy interesado?''' : Con una cuenta de usuario de Wikia puedes seguir conversaciones específicas y recibir notificaciones (a través del wiki o por correo) cuando un tema tenga más actividad. [[Special:UserSignup|Crea una cuenta en Wikia]] si aún no lo hiciste. '''¿Cómo borro los vandalismos?''' : Si descubres mensajes inadecuados, o vandalismo en un hilo, pasa el cursor sobre el texto, verás que aparece un botón llamado \"Más acciones\". Dentro del menú que se despliega en \"Más acciones\", encontrarás \"Retirar\". Esa acción te permitirá retirar el vandalismo y avisar a un administrador si lo consideras necesario. '''¿Qué significa que estoy a favor de un mensaje?''' : Si encuentras interesante un mensaje, estás de acuerdo con su contenido o simplemente apoyas el contenido del mismo, muéstraselo a los demás haciendo clic en el icono con el pulgar arriba. Puede ser algo muy útil para votaciones. '''Temas, hilos, conversaciones, ¿de qué hablas?''' : Veamos, un hilo es un conjunto de mensajes sobre un mismo tema. Cuando inicias una discusión sobre algo específico, estás iniciando un hilo. Cada hilo se compone de mensajes que van dejando los usuarios, y todos estos tienen en común que tratan sobre el mismo tema. A veces, cuando nos referimos a un hilo decimos que es un tema o una discusión, se puede llamar de ambas formas, ten claro por el contexto a qué nos estamos refiriendo. '''¿Dentro de un hilo hay temas?''' : Suena confuso ¿verdad? Es fácil, al final de un hilo encontrarás un apartado que define las cosas sobre las que se está hablando en ese hilo, esos son los temas. Es una forma de mantener organizados los hilos del foro. Ahí podrás añadir los artículos sobre los que se está hablando. Por ejemplo, si etiquetas ese hilo con la etiqueta \"Lord Voldermort\", aparecerá reseñado ese artículo al final de la discusión, ¡pero no sabemos cómo podéis tener tanto valor como para hablar sobre ''El-Que-No-Debe-Ser-Nombrado''!",
	'forum-board-title' => 'Subforo $1',
	'forum-board-topic-title' => 'Temas sobre $1',
	'forum-board-topics' => 'Temas',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Siguiendo',
	'forum-board-thread-kudos' => '$1 a favor',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|respuesta|respuestas}}',
	'forum-board-new-message-heading' => 'Abrir un nuevo tema',
	'forum-no-board-selection-error' => '← Por favor selecciona un subforo para publicar en él',
	'forum-thread-reply-placeholder' => 'Publicar una respuesta',
	'forum-thread-reply-post' => 'Contestar',
	'forum-thread-deleted-return-to' => 'Volver al subforo $1',
	'forum-sorting-option-newest-replies' => 'Temas respondidos recientemente',
	'forum-sorting-option-popular-threads' => 'Más activos',
	'forum-sorting-option-most-replies' => 'Más activos en los últimos 7 días',
	'forum-sorting-option-newest-threads' => 'Temas más nuevos',
	'forum-sorting-option-oldest-threads' => 'Temas más antiguos',
	'forum-discussion-post' => 'Publicar',
	'forum-discussion-highlight' => 'Destacar este tema',
	'forum-discussion-placeholder-title' => '¿Sobre qué quieres hablar?',
	'forum-discussion-placeholder-message' => 'Publicar un nuevo tema en el subforo $1',
	'forum-discussion-placeholder-message-short' => 'Publicar un mensaje nuevo',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|contestó}} a tu tema en el subforo $3',
	'forum-notification-user2-reply-to-your' => '$1 y $2 contestaron en tu tema del subforo $3',
	'forum-notification-user3-reply-to-your' => '$1 y otros usuarios contestaron en tu tema del subforo $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|contestó}} en el subforo $3',
	'forum-notification-user2-reply-to-someone' => '$1 y $2 contestaron en el subforo $3',
	'forum-notification-user3-reply-to-someone' => '$1 y otros usuarios contestaron en el subforo $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|dejó}} un nuevo mensaje en el subforo $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME abrió un nuevo tema en el subforo $BOARDNAME de $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME abrió un nuevo tema en el subforo $BOARDNAME de $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME contestó a tu mensaje en el subforo $BOARDNAME de $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME respondió en el subforo $BOARDNAME de $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME contestó en el subforo $BOARDNAME de $WIKI',
	'forum-mail-notification-html-greeting' => 'Hola $1,',
	'forum-mail-notification-html-button' => 'Ver la conversación',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hola $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Ver la conversación($MESSAGE_LINK)

El Equipo de Wikia

___________________________________________
* Encuentra ayuda y consejos en la Comunidad Hispana: http://comunidad.wikia.com
* ¿Quieres recibir menos mensajes de Wikia? Puedes modificar tus suscripciones a email aquí: http://comunidad.wikia.com/Especial:Preferencias',
	'forum-mail-notification-body-HTML' => 'Hola $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Ver la conversación</a></p>
			<p>El Equipo de Wikia</p>
___________________________________________ <br />
* Encuentra ayuda y consejos en la Comunidad Hispana: http://comunidad.wikia.com
* ¿Quieres recibir menos mensajes de Wikia? Puedes modificar tus suscripciones a email aquí: http://comunidad.wikia.com/Especial:Preferencias',
	'forum-wiki-activity-msg' => 'en el $1',
	'forum-wiki-activity-msg-name' => 'subforo $1',
	'forum-activity-module-heading' => 'Actividad del foro',
	'forum-related-module-heading' => 'Temas relacionados',
	'forum-activity-module-posted' => '$1 publicó una respuesta $2',
	'forum-activity-module-started' => '$1 abrió un nuevo tema $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> en el <a href="$3">subforo $4</a>',
	'forum-recentchanges-new-message' => 'en el <a href="$1">subforo $2</a>',
	'forum-recentchanges-edit' => '(mensaje editado)',
	'forum-recentchanges-removed-thread' => 'borró el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-removed-reply' => 'borró una respuesta en "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-restored-thread' => 'restauró el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-restored-reply' => 'restauró una respuesta en "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-deleted-thread' => 'borró el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-deleted-reply' => 'borró una respuesta en el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Un mensaje',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subforo',
	'forum-recentchanges-thread-group' => '$1 en el <a href="$2">subforo $3</a>',
	'forum-recentchanges-history-link' => 'historial del subforo',
	'forum-recentchanges-thread-history-link' => 'Historial del tema',
	'forum-recentchanges-closed-thread' => 'cerró el tema "[[$1|$2]]" en [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'reabrió el tema "[[$1|$2]]" en [[$3|$4]]',
	'forum-board-history-title' => 'historial del subforo',
	'forum-specialpage-oldforum-link' => 'Archivo del antiguo foro',
	'forum-admin-page-breadcrumb' => 'Panel de administración de subforos',
	'forum-admin-create-new-board-label' => 'Crear nuevo subforo',
	'forum-admin-create-new-board-modal-heading' => 'Crear un nuevo subforo',
	'forum-admin-create-new-board-title' => 'Título del subforo',
	'forum-admin-create-new-board-description' => 'Descripción del subforo',
	'forum-admin-edit-board-modal-heading' => 'Editar subforo: $1',
	'forum-admin-edit-board-title' => 'Título del subforo',
	'forum-admin-edit-board-description' => 'Descripción del subforo',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Borrar subforo: $1',
	'forum-admin-delete-board-title' => 'Por favor confirma escribiendo el nombre del subforo que quieres borrar:',
	'forum-admin-merge-board-warning' => 'Los temas en este subforo serán fusionados con el subforo existente.',
	'forum-admin-merge-board-destination' => 'Selecciona un subforo para fusionarlo con:',
	'forum-admin-delete-and-merge-button-label' => 'Borrar y fusionar',
	'forum-admin-link-label' => 'Administrar subforos',
	'forum-autoboard-title-1' => 'Discusión general',
	'forum-autoboard-body-1' => 'Este subforo es para discusiones generales acerca del wiki.',
	'forum-autoboard-title-2' => 'Noticias y anuncios',
	'forum-autoboard-body-2' => '¡Últimas noticias e información!',
	'forum-autoboard-title-3' => 'Lo nuevo en $1',
	'forum-autoboard-body-3' => '¿Quieres compartir algo que ha sido publicado en este wiki, o felicitar a alguien por alguna contribución? ¡Este es el lugar!',
	'forum-autoboard-title-4' => 'Preguntas y respuestas',
	'forum-autoboard-body-4' => '¿Tienes una pregunta acerca del wiki? ¡Haz tus preguntas aquí!',
	'forum-autoboard-title-5' => 'Juegos y diversión',
	'forum-autoboard-body-5' => 'Este subforo es para discusiones varias, un lugar para pasar el rato con tus amigos de $1.',
	'forum-board-destination-empty' => '(Por favor selecciona un subforo)',
	'forum-board-title-validation-invalid' => 'El título del subforo contiene caracteres inválidos',
	'forum-board-title-validation-length' => 'El título del subforo debe tener al menos 4 caracteres',
	'forum-board-title-validation-exists' => 'Ya existe un subforo con el mismo título',
	'forum-board-validation-count' => 'El número máximo de subforos es $1',
	'forum-board-description-validation-length' => 'Por favor escribe una descripción para esta subforo',
	'forum-board-id-validation-missing' => 'El id del subforo no existe',
	'forum-board-no-board-warning' => 'No pudimos encontrar un subforo con ese título. Aquí está la lista de subforos.',
	'forum-old-notification-message' => 'Este foro ha sido archivado',
	'forum-old-notification-navigation-button' => 'Visita el nuevo foro',
	'forum-related-discussion-heading' => 'Temas sobre $1',
	'forum-related-discussion-new-post-button' => 'Comienza un tema',
	'forum-related-discussion-new-post-tooltip' => 'Comienza un tema acerca de $1',
	'forum-related-discussion-total-replies' => '$1 mensajes',
	'forum-related-discussion-zero-state-creative' => '¡Puedes encontrar temas acerca de cualquier asunto relacionado con este wiki en su [[Special:Forum|Foro]]!',
	'forum-related-discussion-see-more' => 'Ver más temas',
	'forum-confirmation-board-deleted' => '"$1" ha sido borrado.',
);

/** French (français)
 * @author Crochet.david
 * @author Gomoko
 */
$messages['fr'] = array(
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Discussion Active|Discussions Actives}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Discussion active|Discussions actives}} sur : '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Discussion<br />dans ce forum|Discussions<br />dans ce forum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Discussion<br />Active|Discussions<br />Actives}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Vous pouvez le modifier<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|discussion|discussions}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|note|notes}}',
	'forum-specialpage-board-lastpostby' => 'Dernier message par',
	'forum-specialpage-policies-edit' => 'Modifier',
	'forum-specialpage-policies' => 'Politiques du forum / FAQ',
	'forum-policies-and-faq' => "==Politique du forum==
Avant de participer aux forums de {{SITENAME}}, veuillez garder à l’esprit quelques bonnes pratiques de conduite :

'''Soyez poli et traitez les gens avec respect.'''
: Des personnes du monde entier lisent et modifient ce wiki et ses forums. Comme pour tout autre projet collaboratif, tout le monde n’est pas tout le temps d’accord. Restez courtois dans les discussions et ayez l’esprit ouvert aux différents avis. Nous sommes là parce que nous aimons le même sujet.

'''Essayez d’abord de trouver des discussions existantes, mais n’ayez pas peur de démarrer une nouvelle discussion.'''
:Veuillez prendre un moment pour parcourir les tableaux des forums de {{SITENAME}} pour voir si une discussion existe déjà sur quelque chose dont vous voulez parler. Si vous ne pouvez pas trouver ce que vous cherchez, sautez le pas et démarrez une nouvelle discussion !

'''Demandez de l’aide.'''
:Vous avez remarqué quelque chose qui ne vous semble pas correct ? Ou vous avez une question ? Demandez de l’aide ici sur les forums ! Si vous avez besoin de l’aide de l’équipe de Wikia, veuillez aller sur [[w:c:community|le centre de la communauté]] ou passer par [[Special:Contact]].

'''Amusez-vous !'''
:La communauté de {{SITENAME}} est heureuse de vous voir ici. Nous sommes impatients de vous rencontrer par là car nous discutons de ce sujet que nous aimosn tous.

==FAQ du forum==
'''Comment rester à jour sur les discussions qui m’intéressent ?'''
: Avec un compte utilisateur de Wikia, vous pouvez suivre des conversations spécifiques et donc recevoir des messages de notification (soit dans le suite, soit via courriel) quand une discussion a davantage d’activité. Assurez-vous de [[Special:UserSignup|vous inscrire pour un compte Wikia]] si vous n’en avez pas encore un.

'''Comment supprimer le vandalisme ?'''
: Si vous remarquez du pourriel ou du vandalisme sur une discussion, passez votre souris sur le texte concerné. Vous verrez apparaître un bouton « Plus ». Dans le menu « Plus », vous trouverez « Supprimer ». Cela vous permettra de supprimer le vandalisme ou éventuellement d’informer un administrateur.

'''Qu’est-ce que les Kudos?'''
: Si vous trouvez une discussion particulière ou une réponse intéressante, bien pensée ou amusante, vous pouvez lui manifester une appréciation directe en lui donnant des Kudos. Ils peuvent être utiles dans des situations de vote, également.

'''Qu’est-ce que les sujets ?'''
: Les sujets vous permettent de lier une discussion du forum avec un article du wiki. C’est un autre moyen d’organiser les forums et d’aider les gens à trouver des discussions intéressantes. Par exemple, une discussion du forum marquée avec \"Lord Voldemort\" apparaîtra en vas de l’article \"Lord Voldemort\".",
	'forum-board-title' => 'section $1',
	'forum-board-topic-title' => 'Discussions au sujet de $1',
	'forum-board-topics' => 'Sujets',
	'forum-board-thread-follow' => 'Suivre',
	'forum-board-thread-following' => 'Suivi',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Message|Messages}}',
	'forum-board-new-message-heading' => 'Démarrer une Discussion',
	'forum-no-board-selection-error' => 'Veuillez sélectionner une section sur laquelle publier',
	'forum-thread-reply-placeholder' => 'Envoyer une réponse',
	'forum-thread-reply-post' => 'Répondre',
	'forum-thread-deleted-return-to' => 'Revenir à la section $1',
	'forum-sorting-option-newest-replies' => 'Dernières réponses',
	'forum-sorting-option-popular-threads' => 'Plus populaires',
	'forum-sorting-option-most-replies' => 'Plus actifs en 7 jours',
	'forum-sorting-option-newest-threads' => 'Discussions les plus récentes',
	'forum-sorting-option-oldest-threads' => 'Discussions les plus anciennes',
	'forum-discussion-post' => 'Envoyer',
	'forum-discussion-highlight' => 'Mettre en évidence cette discussion',
	'forum-discussion-placeholder-title' => 'De quoi voulez-vous parler ?',
	'forum-discussion-placeholder-message' => 'Publier un nouveau message dans la section $1',
	'forum-discussion-placeholder-message-short' => 'Créer un nouveau message',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|a répondu}} à votre discussion dans la section $3',
	'forum-notification-user2-reply-to-your' => '$1 et $2 ont répondu à votre discussion dans la section $3',
	'forum-notification-user3-reply-to-your' => '$1 et d’autres ont répondu à votre discussion dans la section $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|a répondu}} dans la section $3',
	'forum-notification-user2-reply-to-someone' => '$1 et $2 ont répondu dans la section $3',
	'forum-notification-user3-reply-to-someone' => '$1 et d’autres ont répondu dans la section $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|a laissé}} un nouveau message dans la section $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME a ouvert une nouvelle discussion dans la section $BOARDNAME de $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME a ouvert une nouvelle discussion dans la section $BOARDNAME de $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME a répondu à votre discussion dans la section $BOARDNAME de $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME a répondu dans la section $BOARDNAME de $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME a répondu dans la section $BOARDNAME de $WIKI',
	'forum-mail-notification-html-greeting' => 'Bonjour $1,',
	'forum-mail-notification-html-button' => 'Voir la conversation',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Bonjour $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Afficher la conversation : ($MESSAGE_LINK)

L’équipe Wikia

___________________________________________
* Trouver de l’aide et des conseils dans le Centre de la communauté : http://community.wikia.com
* Vous voulez recevoir moins de messages de notre part ? Vous pouvez vous désabonner ou modifier vos préférences de courriel ici: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Bonjour $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">See the conversation</a></p>
<p>L’équipe Wikia</p>
___________________________________________<br />
* Trouver de l’aide ou des conseils dans le Centre de la communauté : http://community.wikia.com
* Vous voulez recevoir moins de messages de notre part ? Vous pouvez vous désabonner ou modifier vos préférences de courriel ici : http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'sur le $1',
	'forum-wiki-activity-msg-name' => 'section $1',
	'forum-activity-module-heading' => 'Activité du forum',
	'forum-related-module-heading' => 'Discussions connexes',
	'forum-activity-module-posted' => '$1 a posté une réponse $2',
	'forum-activity-module-started' => '$1 a démarré une discussion $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> dans la <a href="$3">section $4</a>',
	'forum-recentchanges-new-message' => 'dans la <a href="$1">Section $2</a>',
	'forum-recentchanges-edit' => '(message modifié)',
	'forum-recentchanges-removed-thread' => 'discussion « [[$1|$2]] » supprimée de la [[$3|Section $4]]',
	'forum-recentchanges-removed-reply' => 'réponse à « [[$1|$2]] » supprimée dans la [[$3|Section $4]]',
	'forum-recentchanges-restored-thread' => 'discussion « [[$1|$2]] » restaurée dans la [[$3|Section $4]]',
	'forum-recentchanges-restored-reply' => 'réponse à « [[$1|$2]] » rétablie dans la [[$3|Section $4]]',
	'forum-recentchanges-deleted-thread' => 'discussion « [[$1|$2]] » supprimée dans la [[$3|Section $4]]',
	'forum-recentchanges-deleted-reply' => 'réponse à « [[$1|$2]] » supprimé dans la [[$3|Section $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Une note',
	'forum-recentchanges-namespace-selector-message-wall' => 'Section du forum',
	'forum-recentchanges-thread-group' => '$1 dans la <a href="$2">Section $3</a>',
	'forum-recentchanges-history-link' => 'historique de la section',
	'forum-recentchanges-thread-history-link' => 'historique de la discussion',
	'forum-recentchanges-closed-thread' => 'discussion « [[$1|$2]] » fermée par [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'discussion « [[$1|$2]] » réouverte par [[$3|$4]]',
	'forum-board-history-title' => 'historique de la discussion',
	'forum-specialpage-oldforum-link' => 'Anciennes Archives du forum',
	'forum-admin-page-breadcrumb' => 'Administrer la gestion des sections',
	'forum-admin-create-new-board-label' => 'Créer une nouvelle section',
	'forum-admin-create-new-board-modal-heading' => 'Créer une nouvelle section',
	'forum-admin-create-new-board-title' => 'Titre de la section',
	'forum-admin-create-new-board-description' => 'Description de la section',
	'forum-admin-edit-board-modal-heading' => 'Modifier la section : $1',
	'forum-admin-edit-board-title' => 'Titre de la section',
	'forum-admin-edit-board-description' => 'Description de la section',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Supprimer la section : $1',
	'forum-admin-delete-board-title' => 'Veuillez confirmer en tapant le nom de la section que vous voulez supprimer :',
	'forum-admin-merge-board-warning' => 'Les discussions dans cette section seront fusionnées dans une section existante.',
	'forum-admin-merge-board-destination' => 'Choisir une section avec laquelle fusionner :',
	'forum-admin-delete-and-merge-button-label' => 'Supprimer et renommer',
	'forum-admin-link-label' => 'Gérer les sections',
	'forum-autoboard-title-1' => 'Discussion générale',
	'forum-autoboard-body-1' => 'Cette section est destinée aux conversations générales sue le wiki.',
	'forum-autoboard-title-2' => 'Nouvelles et annonces',
	'forum-autoboard-body-2' => 'Dernières nouvelles et informations !',
	'forum-autoboard-title-3' => 'Nouveau sur $1',
	'forum-autoboard-body-3' => 'Vous voulez partager quelque chose qui vient d’être publié sur ce wiki, ou féliciter quelqu’un pour une contribution marquante ? C’est le bon endroit !',
	'forum-autoboard-title-4' => 'Questions et réponses',
	'forum-autoboard-body-4' => 'Vous avez une question sur le wiki, ou sur le sujet ? Posez vos questions ici !',
	'forum-autoboard-title-5' => 'Jeux et divertissements',
	'forum-autoboard-body-5' => 'Cette section est réservée aux discussions hors-sujet — un endroit pour traîner avec vos amis de $1.',
	'forum-board-destination-empty' => '(veuillez sélectionner une section)',
	'forum-board-title-validation-invalid' => 'Le nom de la section contient des caractères non valides',
	'forum-board-title-validation-length' => 'Le nom de la section doit avoir au moins 4 caractères de long',
	'forum-board-title-validation-exists' => 'Une section avec ce nom existe déjà',
	'forum-board-validation-count' => 'Le nombre maximum de sections est de $1',
	'forum-board-description-validation-length' => 'Veuillez écrire une description de cette section',
	'forum-board-id-validation-missing' => 'L’identifiant de la section est absent',
	'forum-board-no-board-warning' => 'Impossible de trouver une section avec ce titre. Voici la liste des sections du forum.',
	'forum-old-notification-message' => 'Ce Forum a été archivé',
	'forum-old-notification-navigation-button' => 'Visitez les nouveaux Forums',
	'forum-related-discussion-heading' => 'Discussions au sujet de $1',
	'forum-related-discussion-new-post-button' => 'Démarrer une Discussion',
	'forum-related-discussion-new-post-tooltip' => 'Démarrer une nouvelle discussion sur $1',
	'forum-related-discussion-total-replies' => '$1 messages',
	'forum-related-discussion-zero-state-creative' => 'Vous pouvez trouver des discussions sur tout ce qui est relatif à ce wiki sur le [[Special:Forum|{{SITENAME}} Forum !]]',
	'forum-related-discussion-see-more' => 'Voir plus de discussions',
	'forum-confirmation-board-deleted' => '« $1 » a été supprimée.',
);

/** Galician (galego)
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'forum-forum-title' => 'Foro',
	'forum-specialpage-heading' => 'Foro',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Podes editalo<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|fío|fíos}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|publicación|publicacións}}',
	'forum-specialpage-board-lastpostby' => 'Última publicación de',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas do for / Preguntas máis frecuentes',
	'forum-board-title' => '$1 taboleiro',
	'forum-board-topic-title' => 'Conversas sobre $1',
	'forum-board-topics' => 'Temas',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Seguindo',
	'forum-board-thread-kudos' => '$1 a favor',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|mensaxe|mensaxes}}',
	'forum-board-new-message-heading' => 'Comezar un debate',
	'forum-no-board-selection-error' => '← Por favor, selecciona un taboleiro para publicar para',
	'forum-thread-reply-placeholder' => 'Publicar unha resposta',
	'forum-thread-reply-post' => 'Responder',
	'forum-thread-deleted-return-to' => 'Volver ó taboleiro $1',
	'forum-sorting-option-newest-replies' => 'Respostas máis recentes',
	'forum-sorting-option-popular-threads' => 'Máis popular',
	'forum-sorting-option-most-replies' => 'Máis activo durante 7 días',
	'forum-sorting-option-newest-threads' => 'Fíos máis novos primeiro',
	'forum-sorting-option-oldest-threads' => 'Fíos máis vellos primeiro',
	'forum-discussion-post' => 'Publicar',
	'forum-discussion-highlight' => 'Destacar este debate',
	'forum-discussion-placeholder-title' => 'Sobre que queres falar?',
	'forum-discussion-placeholder-message' => 'Publicar unha nova mensaxe no taboleiro $1',
	'forum-discussion-placeholder-message-short' => 'Publicar unha nova mensaxe',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|respondeu}} ó teu fío no taboleiro $3',
	'forum-notification-user2-reply-to-your' => '$1 e $2 responderon ó teu fío no taboleiro $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|respondeu}} no subforo $3',
	'forum-notification-user2-reply-to-someone' => '$1 e $2 responderon no taboleiro $3',
	'forum-notification-user3-reply-to-someone' => '$1 y outras persoas responderon no taboleiro $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|deixou}} unha nova mensaxe no taboleiro $2',
	'forum-mail-notification-html-greeting' => 'Ola $1,',
	'forum-mail-notification-html-button' => 'Ver a conversa',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-wiki-activity-msg' => 'no $1',
	'forum-wiki-activity-msg-name' => 'subforo $1',
	'forum-activity-module-heading' => 'Actividade do foro',
	'forum-related-module-heading' => 'Fíos relacionados',
	'forum-activity-module-posted' => '$1 publicou unha resposta $2',
	'forum-activity-module-started' => '$1 empezou unha conversa $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> no <a href="$3">subforo $4</a>',
	'forum-recentchanges-new-message' => 'no <a href="$1">subforo $2</a>',
	'forum-recentchanges-edit' => '(mensaxe editada)',
	'forum-recentchanges-removed-thread' => 'eliminou o fío "[[$1|$2]]" do [[$3|muro de $4]]',
	'forum-recentchanges-removed-reply' => 'eliminou a resposta "[[$1|$2]]" do [[$3|muro de $4]]',
	'forum-recentchanges-restored-thread' => 'restaurou o fío "[[$1|$2]]" no [[$3|muro de $4]]',
	'forum-recentchanges-restored-reply' => 'restaurou a resposta "[[$1|$2]]" no [[$3|muro de $4]]',
	'forum-recentchanges-deleted-thread' => 'eliminou o fío "[[$1|$2]]" do [[$3|muro de $4]]',
	'forum-recentchanges-deleted-reply' => 'eliminou a resposta "[[$1|$2]]" do [[$3|muro de $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Unha publicacións',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subforo',
	'forum-recentchanges-thread-group' => 'no $1<a href="$2">subforo $3</a>',
	'forum-recentchanges-history-link' => 'historial do subforo',
	'forum-recentchanges-thread-history-link' => 'historial do fío',
	'forum-recentchanges-closed-thread' => 'eliminou o fío "[[$1|$2]]" do [[$3|muro de $4]]',
	'forum-recentchanges-reopened-thread' => 'reabriu o fío "[[$1|$2]]" en [[$3|$4]]',
	'forum-board-history-title' => 'historial do subforo',
	'forum-specialpage-oldforum-link' => 'Arquivo do foro antigo',
	'forum-admin-page-breadcrumb' => 'Panel de administración dos subforos',
	'forum-admin-create-new-board-label' => 'Crear un novo subforo',
	'forum-admin-create-new-board-modal-heading' => 'Crear un novo subforo',
	'forum-admin-create-new-board-title' => 'Título do subforo',
	'forum-admin-create-new-board-description' => 'Descrición do subforo',
	'forum-admin-edit-board-modal-heading' => 'Editar o subforo: $1',
	'forum-admin-edit-board-title' => 'Título do subforo',
	'forum-admin-edit-board-description' => 'Descrición do subforo',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Borrar o subforo: $1',
	'forum-admin-merge-board-destination' => 'Selecciona un subforo para fusionalo con:',
	'forum-admin-delete-and-merge-button-label' => 'Borrar e fusionar',
	'forum-admin-link-label' => 'Administrar os subforos',
	'forum-autoboard-title-1' => 'Conversa xeral',
	'forum-autoboard-body-1' => 'Este subforo é para conversas xerais sobre a wiki.',
	'forum-autoboard-title-2' => 'Noticias e anuncios',
	'forum-autoboard-body-2' => 'Últimas noticias e informacións!',
	'forum-autoboard-title-3' => 'O novo en $1',
	'forum-autoboard-title-4' => 'Preguntas e respostas',
	'forum-autoboard-title-5' => 'Xogos e diversión',
	'forum-autoboard-body-5' => 'Este subforo é para conversas varias. Un lugar para pasar o rato cos teus amigos de $1.',
	'forum-board-destination-empty' => '(Por favor selecciona un subforo)',
	'forum-board-title-validation-invalid' => 'O nome do subforo contén caracteres inválidos',
	'forum-board-title-validation-length' => 'O nome do subforo debe ter polo menos 4 caracteres',
	'forum-board-title-validation-exists' => 'Xa existe un subforo co mesmo nome',
	'forum-board-validation-count' => 'O número máximo de subforos é de $1',
	'forum-board-description-validation-length' => 'Por favor escribe unha descrición para este subforo',
	'forum-board-id-validation-missing' => 'Falta o id do subforo',
	'forum-board-no-board-warning' => 'Non puidemos atopar un subforo con ese título. Aquí está a lista de subforos.',
	'forum-old-notification-message' => 'Este foro foi arquivado',
	'forum-old-notification-navigation-button' => 'Visita o novo foro',
	'forum-related-discussion-heading' => 'Conversas sobre $1',
	'forum-related-discussion-new-post-button' => 'Comezar un debate',
	'forum-related-discussion-new-post-tooltip' => 'Comenzar un novo debate sobre $1',
	'forum-related-discussion-total-replies' => '$1 mensaxes',
	'forum-related-discussion-see-more' => 'Ver máis debates',
	'forum-confirmation-board-deleted' => 'Borrouse "$1".',
);

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 */
$messages['id'] = array(
	'forum-discussion-placeholder-message-short' => 'Kirim pesan baru',
);

/** Japanese (日本語)
 * @author BryghtShadow
 */
$messages['ja'] = array(
	'forum-forum-title' => 'フォーラム',
	'forum-specialpage-heading' => 'フォーラム',
	'forum-specialpage-policies-edit' => '編集',
	'forum-board-thread-follow' => 'フォローする',
	'forum-board-thread-following' => 'フォロー中',
	'forum-thread-reply-placeholder' => '返信を投稿',
	'forum-thread-reply-post' => '返信',
	'forum-discussion-post' => '投稿',
	'forum-mail-notification-html-greeting' => '$1 さん、',
	'forum-mail-notification-html-button' => 'スレッドを見る',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'forum-forum-title' => 'Forum',
	'forum-specialpage-policies-edit' => 'Bewerken',
	'forum-specialpage-policies' => 'Forumbeleid / FAQ',
	'forum-board-topics' => 'Onderwerpen',
	'forum-board-thread-follow' => 'Volgen',
	'forum-board-thread-following' => 'Wordt gevolgd',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|bericht|berichten}}',
	'forum-board-new-message-heading' => 'Nieuw onderwerp starten',
	'forum-no-board-selection-error' => '← Selecteer een board voor uw bericht',
	'forum-thread-reply-placeholder' => 'Reactie plaatsen',
	'forum-thread-reply-post' => 'Reageren',
	'forum-thread-deleted-return-to' => 'Terug naar het board $1',
	'forum-sorting-option-newest-replies' => 'Recente reacties',
	'forum-sorting-option-popular-threads' => 'Meest populaire',
	'forum-sorting-option-most-replies' => 'Meest actief in afgelopen week',
	'forum-sorting-option-newest-threads' => 'Nieuwste onderwerpen',
	'forum-sorting-option-oldest-threads' => 'Oudste onderwerpen',
	'forum-discussion-post' => 'Opslaan',
	'forum-discussion-highlight' => 'Onderwerp uitlichten',
	'forum-discussion-placeholder-title' => 'Waar wilt u over praten?',
	'forum-discussion-placeholder-message' => 'Nieuw bericht plaatsen op het board $1',
	'forum-discussion-placeholder-message-short' => 'Nieuw bericht plaatsen',
	'forum-mail-notification-html-greeting' => 'Hallo $1,',
	'forum-mail-notification-html-button' => 'Zie het gesprek',
	'forum-mail-notification-subject' => '$1 - $2',
);

/** Russian (русский)
 * @author Okras
 */
$messages['ru'] = array(
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '$1 {{PLURAL:$1|активная дискуссия|активных дискуссии}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|активная дискуссия|активных дискуссии}} оː '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Тема<br />на этом форуме|Темы<br />на этом форуме}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Активное<br />обсуждение|Активные<br />обсуждения}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Вы можете редактировать его<span>',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|тема|темы|тем}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
	'forum-specialpage-board-lastpostby' => 'Последнее сообщение от',
	'forum-specialpage-policies-edit' => 'Править',
	'forum-specialpage-policies' => 'Правила форума / ЧаВо',
	'forum-policies-and-faq' => "== Правила форума ==
Перед тем, как писать на форумы {{SITENAME}}, пожалуйста, учитывайте несколько полезных правил поведения:

'''Будьте вежливы и относитесь к людям с уважением.'''
: Люди со всего мира читают и редактируют вики и их форумы. Как и в любом другом совместном проекте, не всегда все друг с другом согласны. Ведите мирное обсуждения и будьте открыты для различных мнений. Мы все здесь потому, что нам интересны одинаковые темы.

'''Сначала пробуйте найти существующие обсуждения, но не бойтесь начать и новую тему.'''
: Пожалуйста, потратьте некоторое время, чтобы просмотреть разделы форума {{SITENAME}}, чтоб проверить, нет ли уже начатых обсуждений того, о чём вы хотели бы поговорить. Если же вы не можете найти то, что вы ищете, смело начинайте новую дискуссию!

'''Обращайтесь за помощью.'''
: Обнаружили что-то, что вам кажется неверным? Или у вас есть вопрос? Попросите помощи здесь, на форумах! Если вам нужна помощь сотрудников Викии, пожалуйста, зайдите на [[w:c:community|Community Central]] или [[Special:Contact]].

'''Получайте удовольствие!'''
: Сообщество {{SITENAME}} радо видеть вас здесь. Мы с нетерпением ждем встречи с вами, поскольку мы обсуждаем тему, которую все любим.

 == ЧаВо форума ==
'''Как мне следить за обсуждениями, которые мне интересны?'''
: С учётной записью Викии вы можете следить за определёнными обсуждениями и получать уведомления (на сайте или по электронной почте), когда в обсуждении что-то происходит. Не забудьте [[Special:UserSignup|зарегистрировать учётную запись Викии]], если у вас её еще нет.

'''Как исправить вандализма?'''
: Если вы заметили какой-то спам или проявления вандализма в теме, наведите мышку на нарушающий текст. Вы увидите появившуюся кнопку «Подробнее». Внутри меню «Подробнее» вы найдёте «Удалить». Это позволит вам удалить последствия вандализма и при необходимости проинформировать администратора.

'''Что такое «Мне нравится»?'''
: Если вы считаете конкретное обсуждение или ответ интересным, хорошо продуманным или забавным, вы можете отметить это, поставив «Мне нравится». Они также могут быть полезны при голосовании.

'''Что такое темы?'''
: Темы позволяют вам связать обсуждения на форуме с вики-статьёй. Это ещё один способ держать форумы организованными и помочь людям найти интересные дискуссии. К примеру тема форума, отмеченная как «Лорд Волдеморт» появится в нижней части статьи «Лорд Волдеморт».",
	'forum-board-title' => 'раздел ̩$1',
	'forum-board-topic-title' => 'Обсуждения о $1',
	'forum-board-topics' => 'Темы',
	'forum-board-thread-follow' => 'Подписаться',
	'forum-board-thread-following' => 'Подписки',
	'forum-board-thread-kudos' => '$1 «Мне нравится»',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
	'forum-board-new-message-heading' => 'Начать обсуждение',
	'forum-no-board-selection-error' => '← Выберите раздел форума для отправки',
	'forum-thread-reply-placeholder' => 'Ответить',
	'forum-thread-reply-post' => 'Ответить',
	'forum-thread-deleted-return-to' => 'Вернуться в раздел $1',
	'forum-sorting-option-newest-replies' => 'Последние ответы',
	'forum-sorting-option-popular-threads' => 'Самые популярные',
	'forum-sorting-option-most-replies' => 'Наиболее активные за 7 дней',
	'forum-sorting-option-newest-threads' => 'Новые темы',
	'forum-sorting-option-oldest-threads' => 'Старые темы',
	'forum-discussion-post' => 'Сообщение',
	'forum-discussion-highlight' => 'Выделить это обсуждение',
	'forum-discussion-placeholder-title' => 'О чём вы хотите поговорить?',
	'forum-discussion-placeholder-message' => 'Создать новое сообщение в разделе $1',
	'forum-discussion-placeholder-message-short' => 'Создать новое сообщение',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|ответил|ответила}} в вашей теме в разделе $3',
	'forum-notification-user2-reply-to-your' => '$1 и $2 ответили в вашей теме в разделе $3',
	'forum-notification-user3-reply-to-your' => '$1 и другие ответили в вашей теме в разделе $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|ответил|ответила}} в разделе $3',
	'forum-notification-user2-reply-to-someone' => '$1 и $2 ответили в разделе $3',
	'forum-notification-user3-reply-to-someone' => '$1 и другие ответили в разделе $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|оставил|оставила}} новое сообщение в разделе $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME создал новую тему на $WIKI в разделе $BOARDNAME.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME создал новую тему на $WIKI в разделе $BOARDNAME.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME ответил на $WIKI в разделе $BOARDNAME.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME ответил на $WIKI в разделе $BOARDNAME.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME ответил на $WIKI в разделе $BOARDNAME.',
	'forum-mail-notification-html-greeting' => 'Привет, $1,',
	'forum-mail-notification-html-button' => 'Посмотреть обсуждение',
	'forum-mail-notification-subject' => '$1 — $2',
	'forum-mail-notification-body' => 'Привет, $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Смотрите обсуждение: ($MESSAGE_LINK)

Команда Викия

___________________________________________
* Найти помощь и совет можно на Community Central: http://community.wikia.com
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Привет, $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Посмотреть обсуждение</a></p>
<p>Команда Викия</p>
___________________________________________<br />
* Найти помощь и совет можно на Community Central: http://community.wikia.com
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'на $1',
	'forum-wiki-activity-msg-name' => 'Раздел ̩$1',
	'forum-activity-module-heading' => 'Активность на форуме',
	'forum-related-module-heading' => 'Связанные темы',
	'forum-activity-module-posted' => '$1 опубликовал ответ $2',
	'forum-activity-module-started' => '$1 начал обсуждение $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> в разделе <a href="$3">$4</a>',
	'forum-recentchanges-new-message' => 'в <a href="$1">разделе $2</a>',
	'forum-recentchanges-edit' => '(отредактированное сообщение)',
	'forum-recentchanges-removed-thread' => 'удалена тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-removed-reply' => 'удалён ответ «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-restored-thread' => 'восстановлена тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-restored-reply' => 'восстановлен ответ «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-deleted-thread' => 'удалена тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-deleted-reply' => 'удалён ответ «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-deleted-reply-title' => 'Сообщение',
	'forum-recentchanges-namespace-selector-message-wall' => 'Раздел форума',
	'forum-recentchanges-thread-group' => '$1 в <a href="$2">разделе $3</a>',
	'forum-recentchanges-history-link' => 'история раздела',
	'forum-recentchanges-thread-history-link' => 'история темы',
	'forum-recentchanges-closed-thread' => 'закрыта тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'снова открыта тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-board-history-title' => 'история раздела',
	'forum-specialpage-oldforum-link' => 'Старые архивы форума',
	'forum-admin-page-breadcrumb' => 'Панель управления разделом',
	'forum-admin-create-new-board-label' => 'Создать новый раздел',
	'forum-admin-create-new-board-modal-heading' => 'Создать новый раздел',
	'forum-admin-create-new-board-title' => 'Название раздела',
	'forum-admin-create-new-board-description' => 'Описание раздела',
	'forum-admin-edit-board-modal-heading' => 'Редактировать раздел: $1',
	'forum-admin-edit-board-title' => 'Название раздела',
	'forum-admin-edit-board-description' => 'Описание раздела',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Удаление раздела: $1',
	'forum-admin-delete-board-title' => 'Пожалуйста, подтвердите, введя имя раздела, который вы хотите удалить:',
	'forum-admin-merge-board-warning' => 'Темы в этом разделе будут перенесены в существующий раздел.',
	'forum-admin-merge-board-destination' => 'Выберите раздел, в который будет сделан перенос:',
	'forum-admin-delete-and-merge-button-label' => 'Удалить и объединить',
	'forum-admin-link-label' => 'Управление разделами',
	'forum-autoboard-title-1' => 'Общее обсуждение',
	'forum-autoboard-body-1' => 'Этот раздел предназначен для общих разговоров о вики.',
	'forum-autoboard-title-2' => 'Новости и объявления',
	'forum-autoboard-body-2' => 'Последние новости и информация!',
	'forum-autoboard-title-3' => 'Новое на $1',
	'forum-autoboard-body-3' => 'Хотите поделиться чем-то, что только что было размещено в этой вики, или поблагодарить кого-то за выдающийся вклад? Здесь подходящее место для этого!',
	'forum-autoboard-title-4' => 'Вопросы и ответы',
	'forum-autoboard-body-4' => 'Есть вопрос о вики или теме? Задайте свои вопросы здесь!',
	'forum-autoboard-title-5' => 'Развлечения и игры',
	'forum-autoboard-body-5' => 'Этот раздел предназначен для свободного общения, где можно поболтать со своими друзьями с $1.',
	'forum-board-destination-empty' => '(Пожалуйста, выберите раздел)',
	'forum-board-title-validation-invalid' => 'Название раздела содержит недопустимые символы',
	'forum-board-title-validation-length' => 'Название раздела должно содержать как минимум 4 символа',
	'forum-board-title-validation-exists' => 'Раздел с таким названием уже существует',
	'forum-board-validation-count' => 'Максимальное количество разделов — $1',
	'forum-board-description-validation-length' => 'Пожалуйста, введите описание для этого раздела',
	'forum-board-id-validation-missing' => 'Отсутствует идентификатор раздела',
	'forum-board-no-board-warning' => 'Мы не смогли найти раздел с таким названием. Вот список разделов форума.',
	'forum-old-notification-message' => 'Этот форум был заархивирован.',
	'forum-old-notification-navigation-button' => 'Посетите новые форумы',
	'forum-related-discussion-heading' => 'Обсуждения о $1',
	'forum-related-discussion-new-post-button' => 'Начать обсуждение',
	'forum-related-discussion-new-post-tooltip' => 'Начать новое обсуждение о $1',
	'forum-related-discussion-total-replies' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
	'forum-related-discussion-zero-state-creative' => 'Вы можете найти обсуждения обо всём, связанном с этим вики-проектом на [[Special:Forum|Форуме {{SITENAME}}!]]',
	'forum-related-discussion-see-more' => 'Посмотреть другие обсуждения',
	'forum-confirmation-board-deleted' => '«$1» был удалён.',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|aktiv diskussion|aktiva diskussioner}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|aktiv diskussion|aktiva diskussioner}} om: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|tråd<br />i detta forum|trådar<br />i detta forum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|aktiv<br />diskussion|aktiva<br />diskussioner}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Du kan redigera den<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|tråd|trådar}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|inlägg}}',
	'forum-specialpage-board-lastpostby' => 'Senaste inlägget av',
	'forum-specialpage-policies-edit' => 'Redigera',
	'forum-specialpage-policies' => 'Forumpolicy / Vanliga frågor',
	'forum-board-topic-title' => 'Diskussioner om $1',
	'forum-board-topics' => 'Ämnen',
	'forum-board-thread-follow' => 'Följ',
	'forum-board-thread-following' => 'Följer',
	'forum-board-thread-kudos' => '$1 beröm',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|meddelande|meddelanden}}',
	'forum-board-new-message-heading' => 'Starta en diskussion',
	'forum-thread-reply-placeholder' => 'Skicka ett svar',
	'forum-thread-reply-post' => 'Svara',
	'forum-sorting-option-popular-threads' => 'Mest populära',
	'forum-sorting-option-newest-threads' => 'Nyaste trådarna',
	'forum-sorting-option-oldest-threads' => 'Äldsta trådarna',
	'forum-discussion-post' => 'Skicka',
	'forum-discussion-placeholder-title' => 'Vad vill du prata om?',
	'forum-discussion-placeholder-message-short' => 'Skicka ett nytt meddelande',
	'forum-mail-notification-html-greeting' => 'Hej $1,',
	'forum-mail-notification-html-button' => 'Se konversationen',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-wiki-activity-msg' => 'på $1',
	'forum-activity-module-heading' => 'Forumaktivitet',
	'forum-related-module-heading' => 'Relaterade trådar',
	'forum-activity-module-started' => '$1 startade en diskussion $2',
	'forum-recentchanges-edit' => '(redigerat meddelande)',
	'forum-recentchanges-deleted-reply-title' => 'Ett inlägg',
	'forum-recentchanges-closed-thread' => 'stängde tråden "[[$1|$2]]" från [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'öppna tråden "[[$1|$2]]" från [[$3|$4]]',
	'forum-specialpage-oldforum-link' => 'Gamla forumarkiv',
	'forum-admin-delete-and-merge-button-label' => 'Radera och slå ihop',
	'forum-autoboard-title-1' => 'Allmän diskussion',
	'forum-autoboard-title-2' => 'Nyheter och meddelanden',
	'forum-autoboard-body-2' => 'Heta nyheter och information!',
	'forum-autoboard-title-3' => 'Nytt på $1',
	'forum-autoboard-title-4' => 'Frågor och svar',
	'forum-autoboard-body-4' => 'Har du en fråga om wikin eller trådens ämne? Ställ dina frågor här!',
	'forum-autoboard-title-5' => 'Kul och spel',
	'forum-old-notification-message' => 'Detta forum har arkiverats',
	'forum-old-notification-navigation-button' => 'Besök de nya forumen',
	'forum-related-discussion-heading' => 'Diskussioner om $1',
	'forum-related-discussion-new-post-button' => 'Starta en diskussion',
	'forum-related-discussion-new-post-tooltip' => 'Starta en ny diskussion om $1',
	'forum-related-discussion-total-replies' => '$1 meddelanden',
	'forum-related-discussion-zero-state-creative' => 'Du kan hitta diskussioner om allting relaterat till denna wiki på [[Special:Forum|{{SITENAME}}s forum!]]',
	'forum-related-discussion-see-more' => 'Se fler diskussioner',
	'forum-confirmation-board-deleted' => '"$1" har raderats.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 */
$messages['uk'] = array(
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '$1 {{PLURAL:$1|активне обговорення|активні обговорення|активних обговорень}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|активне обговорення|активні обговорення|активних обговорень}} про: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Тема<br />у цьому  форумі|Теми<br />у цьому форумі|Тем<br />у цьому форумі}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|активне<br /> обговорення|активні<br /> обговорення|активних<br /> обговорень}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Ви не можете це редагувати<span>',
	'forum-specialpage-blurb' => 'опис форуму',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|тема|теми|тем}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|допис|дописи|дописів}}',
	'forum-specialpage-board-lastpostby' => 'Останнє повідомлення від',
	'forum-specialpage-policies-edit' => 'Змінити',
	'forum-specialpage-policies' => 'Політика форуму / ЧаП',
	'forum-policies-and-faq' => "==Форумна політика==
Перед своєю участю на форумах {{SITENAME}}, запам'ятайте найкращі практичні вказівки для роботи:

'''Будьте приємними і ставтеся з повагою до людей.'''
: Люди з усього світу читають і редагують це вікі та його форуми. Як і у будь-яких інших спільних проектах, не кожний погоджується з усім весь час. Зберігайте обговорення цікавим і необразливим та будьте відритими для інших думок. Ми всі тут, тому що ми також любимо цю тему.

'''Спробуйте знайти наявні обговорення спочатку, але не бійтеся при цьому розпочату нову тему.'''
:Виділіть хвилинку, аби просіяти стіни форуму {{SITENAME}} якщо обговорення вже існує про те, що ви хочете розповісти. Якщо ви не можете знайти, що вам потрібно, перейдіть праворуч та розпочніть нове обговорення!

'''Просіть допомоги.'''
:Помітили щось таке, що здається не вірним? Або маєте питання? Попросіть допомоги на форумах! Якщо вам потрібна допомога від персоналу Вікія, зверніться на  [[w:c:community|Community Central]] або через [[Special:Contact]].

'''Насолоджуйтеся!'''
:Громада {{SITENAME}} - щаслива, коли ви тут. Ми з нетерпінням чекаємо, коли ва обговорюєте ту є тему, яку ми всі любимо.

==Форумні ЧаП==
'''Як залишатися на вершині цікавих для мене обговорень?'''
: З профілем користувача Вікія ви можете стежити за конкретними розмовами і отримувати повідомлення із сповіщеннями (як на сайті, так і на електронну пошту), коли дискусія має більше діяльності. Переконайтеся, що ви [[Special:UserSignup|зареєструвалися для профілю Вікія]].

'''Як я можу вилучити вандалізм?'''
: Якщо ви помітили спам або вандалізм у темі, наведіть курсор миші на цей текст. Ви побачите кнопку \"Більше\". У середині меню \"Більше\" ви знайдете \"Вилучити\". Це дозволить вам вилучити вандалізм та повідомити про вилучення адміністратора.

'''Що таке пошана?'''
: Якщо ви виявите окреме обговорення або відповідь цікавими для вас, добре обдуманими або кумедними, ви можете показати пряме схвалення, давши пошану. Вона також допомагає у ситуаціях голосування.

'''Що таке теми?'''
: Теми дозволяють вам вказати посилання на обговорення форуму з статтею вікі. Це - інший шлях для збереження форумів упорядкованими і для допомоги людям у пошуці цікавих обговорень. Наприклад, форумна тема позначена як  \"Лорд Волдеморт\" появиться внизу статті \"Лорд Волдеморт\".",
	'forum-board-title' => '$1 дошка',
	'forum-board-topic-title' => 'Обговорення про $1',
	'forum-board-topics' => 'Теми',
	'forum-board-thread-follow' => 'Підписатись',
	'forum-board-thread-following' => 'Підписки',
	'forum-board-thread-kudos' => '$1 вшанувань',
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
	'forum-mail-notification-body' => 'Привіт $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Подивіться розмову: ($MESSAGE_LINK)

Команда Вікії

___________________________________________
* Ви можете знайти допомогу та поради на (http://community.wikia.com)
* Хочете отримувати менше таких повідомлень? Ви можете відмовитися від розсилки даних повідомлень, або внести в неї корективи на сторінці власних налаштувань: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Привіт, $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Подивіться розмову</a></p>
<p>Команда Вікія</p>
___________________________________________<br />
* Ви можете знайти допомогу та поради на (http://community.wikia.com)
* Хочете отримувати менше таких повідомленнь? Ви можете відмовитися від розсилки даних повідомлень, або внести в неї корективи на сторінці власних налаштуваннь: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'на $1',
	'forum-wiki-activity-msg-name' => 'стіна $1',
	'forum-activity-module-heading' => 'Діяльність форуму',
	'forum-related-module-heading' => 'Схожі потоки',
	'forum-activity-module-posted' => '$1 відправив відповідь $2',
	'forum-activity-module-started' => '$1 розпочав обговорення $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> на <a href="$3">стіні $4</a>',
	'forum-recentchanges-new-message' => 'на <a href="$1">стіні $2</a>',
	'forum-recentchanges-edit' => '(відредаговане повідомлення)',
	'forum-recentchanges-removed-thread' => 'вилучено тему "[[$1|$2]]" із [[$3|стіни $4]]',
	'forum-recentchanges-removed-reply' => 'вилучено відповідь із "[[$1|$2]]" на [[$3|стіні $4]]',
	'forum-recentchanges-restored-thread' => 'відновлено тему "[[$1|$2]]" на [[$3|стіну $4]]',
	'forum-recentchanges-restored-reply' => 'відновлено відповідь на "[[$1|$2]]" до [[$3|стіни $4]]',
	'forum-recentchanges-deleted-thread' => 'вилучено тему "[[$1|$2]]" із [[$3|стіни $4]]',
	'forum-recentchanges-deleted-reply' => 'вилучено відповідь із "[[$1|$2]]" з [[$3|стіни $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Допис',
	'forum-recentchanges-namespace-selector-message-wall' => 'Стіна форуму',
	'forum-recentchanges-thread-group' => '$1 на <a href="$2">стіні $3</a>',
	'forum-recentchanges-history-link' => 'історія стіни',
	'forum-recentchanges-thread-history-link' => 'історія тем',
	'forum-recentchanges-closed-thread' => 'закрита тема "[[$1|$2]]" із [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'наново відкрита тема "[[$1|$2]]" із [[$3|$4]]',
	'forum-board-history-title' => 'історія стіни',
	'forum-specialpage-oldforum-link' => 'Архіви старого форуму',
	'forum-admin-page-breadcrumb' => 'Управління адміністративною стіною',
	'forum-admin-create-new-board-label' => 'Створити нову стіну',
	'forum-admin-create-new-board-modal-heading' => 'Створити нову стіну',
	'forum-admin-create-new-board-title' => 'Назва стіни',
	'forum-admin-create-new-board-description' => 'Опис стіни',
	'forum-admin-edit-board-modal-heading' => 'Редагувати стіну: $1',
	'forum-admin-edit-board-title' => 'Назва стіни',
	'forum-admin-edit-board-description' => 'Опис стіни',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Видалити стіну: $1',
	'forum-admin-delete-board-title' => 'Будь ласка, підтвердіть, ввівши назву стіни, яку ви хочете видалити:',
	'forum-admin-merge-board-warning' => 'Теми на цій стіні будуть злиті з наявною стіною.',
	'forum-admin-merge-board-destination' => 'Виберіть стіну для злиття із:',
	'forum-admin-delete-and-merge-button-label' => 'Видалити і з’єднати',
	'forum-admin-link-label' => 'Управління дошкою',
	'forum-autoboard-title-1' => 'Загальне обговорення',
	'forum-autoboard-body-1' => 'Ця дошка для загальних розмов про вікі.',
	'forum-autoboard-title-2' => 'Новини і анонси',
	'forum-autoboard-body-2' => 'Останні новини та інформація!',
	'forum-autoboard-title-3' => 'Нове на $1',
	'forum-autoboard-body-3' => 'Хочете поширити щось, що вже опубліковане на цьому вікі, або привітати когось за вагомий внесок? Ось місце для цього!',
	'forum-autoboard-title-4' => 'Питання та відповіді',
	'forum-autoboard-body-4' => 'Маєте питання про вікі або нову тему? Задавайте свої запитання тут!',
	'forum-autoboard-title-5' => 'Ігри та розваги',
	'forum-autoboard-body-5' => 'Ця стіна є для розмов поза темою - місце, де ви можете теревенити з $1 вашими друзями.',
	'forum-board-destination-empty' => '(Будь ласка, виберіть стіну)',
	'forum-board-title-validation-invalid' => 'Назва стіни містить неприпустимі символи',
	'forum-board-title-validation-length' => 'Назва стіни має мати принаймні 4 символи',
	'forum-board-title-validation-exists' => 'Стіна з такою назвою вже існує',
	'forum-board-validation-count' => 'Максимальне число стін - $1',
	'forum-board-description-validation-length' => 'Будь ласка, напишіть опис для цієї стіни',
	'forum-board-id-validation-missing' => 'ІД стіни не вистачає',
	'forum-board-no-board-warning' => 'Ми не змогли знайти стіни з цим заголовком. Ось тут список стін форуму.',
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
