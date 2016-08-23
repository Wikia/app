<?php
/**
* Internationalisation file for the Forum extension.
*
* @addtogroup Languages
*/

$messages = [];

$messages['en'] = [
	'forum-desc' => 'Wikia\'s Special:Forum extension',
	'forum-disabled-desc' => 'Wikia\'s Special:Forum extension; disabled',
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

	/* WikiActivity */
	'forum-wiki-activity-msg' => 'on the $1',
	'forum-wiki-activity-msg-name' => '$1 board',

	/* Forum Activity and Related Module */
	'forum-activity-module-heading' => 'Forum Activity',
	'forum-related-module-heading' => 'Related Threads',
	'forum-activity-module-posted' => '$1 posted a reply $2',
	'forum-activity-module-started' => '$1 started a discussion $2',

	/* Contribution/RC */
	'forum-contributions-line' => '[[$1|$2]] on the [[$3|$4 board]]',

	'forum-recentchanges-new-message' => 'on the [[$1|$2 Board]]',
	'forum-recentchanges-edit' => 'edited message',
	'forum-recentchanges-removed-thread' => 'removed thread "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-removed-reply' => 'removed reply from "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-restored-thread' => 'restored thread "[[$1|$2]]" to the [[$3|$4 Board]]',
	'forum-recentchanges-restored-reply' => 'restored reply on "[[$1|$2]]" to the [[$3|$4 Board]]',
	'forum-recentchanges-deleted-thread' => 'deleted thread "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-deleted-reply' => 'deleted reply from "[[$1|$2]]" from the [[$3|$4 Board]]',
	'forum-recentchanges-deleted-reply-title' => 'A post',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forum Board',
	'forum-recentchanges-thread-group' => '$1 on the [[$2|$3 Board]]',
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

	'forum-related-discussion-see-more' => 'See more discussions',
	'forum-confirmation-board-deleted' => '"$1" has been deleted.',
	'forum-token-mismatch' => 'Oops! Token doesn\'t match',

	/* rights */
	'right-forumadmin' => 'Has admin access to the forums',
	'right-forumoldedit' => 'Can edit the old, archived forums',
	'right-boardedit' => 'Edit Forum board information',
];

/** Message documentation (Message documentation)
 * @author Elseweyr
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = [
	'forum-desc' => '{{desc}}',
	'forum-disabled-desc' => '{{desc}}',
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
	'forum-activity-module-posted' => 'Parameters:
* $1 is username,
* $2 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-activity-module-started' => 'Displays user activity in the Forum Activity module. Parameters:
* $1 is the username
* $2 is a translated time statement such as "20 seconds ago" or "20 hours ago" or "20 days ago"',
	'forum-contributions-line' => 'Contributions item. Parameters:
* $2 is the thread title
* $4 is the board title',
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
* $1 is the thread title link
* $2 is page name of the board on which the thread is posted
* $3 is title of the board on which the thread is posted',
	'forum-recentchanges-history-link' => 'Link to board history for items about removed and deleted threads on recent changes.
{{Identical|Board history}}',
	'forum-recentchanges-thread-history-link' => 'Link to thread history for items about removed replies on recent changes.',
	'forum-recentchanges-closed-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is thread owner
* $5 is optional username and you can use it with GENDER parameter',
	'forum-recentchanges-reopened-thread' => 'Recent changes item. Parameters:
* $2 is thread title
* $4 is thread owner
* $5 is optional username and you can use it with GENDER parameter',
	'forum-board-history-title' => 'Heading on the board history page.
{{Identical|Board history}}',
	'forum-specialpage-oldforum-link' => 'Text of link to old archived forums.',
	'forum-admin-page-breadcrumb' => 'Breadcrumb heading',
	'forum-admin-create-new-board-label' => 'Button label to create a new forum board',
	'forum-admin-create-new-board-modal-heading' => 'Modal heading for create a new board dialog',
	'forum-admin-create-new-board-title' => 'Form input label for board title.
{{Identical|Bad title}}',
	'forum-admin-create-new-board-description' => 'Form input label board description.
{{Identical|Board description}}',
	'forum-admin-edit-board-modal-heading' => 'Heading on the board editing modal. Parameters:
* $1 is the board title.',
	'forum-admin-edit-board-title' => 'Text next to the inputbox to edit the board title in the board editing modal.
{{Identical|Bad title}}',
	'forum-admin-edit-board-description' => 'Text next to the inputbox to edit the board description in the board editing modal.
{{Identical|Board description}}',
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
	'forum-related-discussion-see-more' => 'See More link to topic page',
	'forum-confirmation-board-deleted' => 'Board delete confirmation message. $1 is board name',
	'forum-token-mismatch' => "Shown when hidden token (to prevent hijacking) sent to the backend doesn't match the one stored in user's session",
];

/** Old English (Ænglisc)
 * @author Espreon
 */
$messages['ang'] = [
	'forum-specialpage-policies-edit' => 'Adihtan',
];

/** Arabic (العربية)
 * @author Claw eg
 * @author Test Create account
 */
$messages['ar'] = [
	'forum-desc' => "Wikia's Special:إضافات المنتدى",
	'forum-disabled-desc' => "Wikia's Special:إضافات المنتدى; معطلة",
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
	'forum-mail-notification-new-your' => '$AUTHOR_NAME {{GENDER:$AUTHOR_NAME|كتب|كتبت|كتب}} موضوعًا جديدًا على لوحة $WIKI $BOARDNAME.',
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
	'forum-contributions-line' => '[[$1|$2]] على [[$3|جدار $4]]',
	'forum-recentchanges-new-message' => 'على [[$1|$2 لوحة]]',
	'forum-recentchanges-edit' => 'تم تعديل الرسالة',
	'forum-recentchanges-removed-thread' => 'قام بحذف النقاش "[[$1|$2]]"  من [[$3|جدار $4]]',
	'forum-recentchanges-removed-reply' => 'حذف الرد من  "[[$1|$2]]" من [[$3|جدار $4]]',
	'forum-recentchanges-restored-thread' => 'استعاد النقاش "[[$1|$2]]" إلى [[$3|جدار $4]]',
	'forum-recentchanges-restored-reply' => 'استعاد الرد من "[[$1|$2]]" إلى [[$3|جدار $4]]',
	'forum-recentchanges-deleted-thread' => 'قام بحذف النقاش "[[$1|$2]]"  من [[$3|جدار $4]]',
	'forum-recentchanges-deleted-reply' => 'حذف الرد من  "[[$1|$2]]" من [[$3|جدار $4]]',
	'forum-recentchanges-deleted-reply-title' => 'رسالة',
	'forum-recentchanges-namespace-selector-message-wall' => 'لوحة المنتدى',
	'forum-recentchanges-thread-group' => '$1 على [[$2|لوحة $3]]',
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
	'forum-board-title-validation-exists' => 'لوحة موجودة بنفس الاسم فعلاً',
	'forum-board-validation-count' => 'الحد الأقصى لعدد اللوحات هو $1',
	'forum-board-description-validation-length' => 'الرجاء كتابة وصف لهذه اللوحة',
	'forum-board-id-validation-missing' => 'معرف اللوحة مفقود',
	'forum-board-no-board-warning' => 'لم نستطع إيجاد لوحة بهذا العنوان. إليك قائمة لوحات المنتدى.',
	'forum-old-notification-message' => 'لقد تم أرشفة هذا المنتدى',
	'forum-old-notification-navigation-button' => 'قم بزيارة المنتديات الجديدة',
	'forum-related-discussion-heading' => 'نقاشات حول $1',
	'forum-related-discussion-new-post-button' => 'ابدأ نقاشًا جديدًا',
	'forum-related-discussion-new-post-tooltip' => 'ابدأ نقاشًا جديدًا عن $1',
	'forum-related-discussion-total-replies' => '$1 رسائل',
	'forum-related-discussion-see-more' => 'رؤية المزيد من النقاشات',
	'forum-confirmation-board-deleted' => '"$1" قد حُذفت.',
	'forum-token-mismatch' => 'عفوا! الرمز المميز لا يتطابق',
];

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = [
	'forum-forum-title' => 'Forum',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-policies-edit' => 'Redaktə',
	'forum-board-topics' => 'Mövzular',
	'forum-board-thread-follow' => 'İzləyin',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Message|Mesajlar}}',
	'forum-thread-reply-post' => 'Geri göndər',
	'forum-mail-notification-html-greeting' => 'Salam $1,',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-autoboard-title-5' => 'Əyləncə və oyunlar',
	'forum-related-discussion-total-replies' => '$1 mesajlar',
];

/** Bulgarian (български)
 * @author Agilight
 * @author DCLXVI
 */
$messages['bg'] = [
	'forum-forum-title' => 'Форум',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-policies-edit' => 'Редактиране',
	'forum-admin-delete-and-merge-button-label' => 'Изтриване и обединяване',
];

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Gwenn-Ael
 */
$messages['br'] = [
	'forum-forum-title' => 'Forom',
	'forum-active-threads' => '$1 {{PLURAL:$1|Kendiviz oberiant|Kendivizoù oberiant}}',
	'forum-active-threads-on-topic' => '$1 {{PLURAL:$1|Kendiviz oberiant|Kendivizoù oberiant}} diwar-benn "[[$2]]"',
	'forum-specialpage-heading' => 'Forom',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|neudennad}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|kemennadenn}}',
	'forum-specialpage-board-lastpostby' => 'Kemennadenn diwezhañ gant',
	'forum-specialpage-policies-edit' => 'Aozañ',
	'forum-specialpage-policies' => 'Reolennoù ar forom / FAG',
	'forum-board-title' => 'Isforom $1',
	'forum-board-topic-title' => 'Kaozioù diwar-benn $1',
	'forum-board-topics' => 'Danvezioù',
	'forum-board-thread-follow' => 'Heuliañ',
	'forum-board-thread-following' => 'O Heuliañ',
	'forum-board-thread-replies' => "{{PLURAL:$1|1 c'hemennad|$1 kemennadoù}}",
	'forum-board-new-message-heading' => 'Kregiñ gant ur gaoz',
	'forum-thread-reply-placeholder' => 'Postañ ur respont',
	'forum-thread-reply-post' => 'Respont',
	'forum-thread-deleted-return-to' => "Distreiñ d'an isforom $1",
	'forum-sorting-option-newest-replies' => 'Respontoù diwezhañ',
	'forum-sorting-option-popular-threads' => 'Gwellañ-deuet',
	'forum-sorting-option-most-replies' => 'Ar re oberiantañ er 7 devezh diwezhañ',
	'forum-sorting-option-newest-threads' => 'Neudennadoù nevesañ',
	'forum-sorting-option-oldest-threads' => 'Neudennadoù koshañ',
	'forum-discussion-post' => 'Postañ',
	'forum-discussion-highlight' => "Dreistlinennañ ar c'hendiviz-mañ",
	'forum-discussion-placeholder-title' => "Eus petra e fell deoc'h kaozeal ?",
	'forum-discussion-placeholder-message' => 'Postañ ur gemennadenn nevez en isforom $1',
	'forum-discussion-placeholder-message-short' => 'Postañ ur gemennadenn nevez',
	'forum-notification-user1-reply-to-your' => "$1 {{GENDER:$1|en deus|he deus}} respontet d'ho neudennad en isforom $3",
	'forum-notification-user2-reply-to-your' => "$1 ha $2 o deus respontet d'ho neudennad en isforom $3",
	'forum-notification-user3-reply-to-your' => "$1 ha re all o deus respontet d'ho neudennad en isforom $3",
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|en deus|he deus}} respontet en isforom $3',
	'forum-notification-user2-reply-to-someone' => '$1 ha $2 o deus respontet en isforom $3',
	'forum-notification-user3-reply-to-someone' => '$1 ha re all o deus respontet en isforom $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|en deus|he deus}} lezet ur gemennadenn nevez er rann $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME en deus digoret un neudennad nevez en isforom $BOARDNAME e $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME en deus digoret un neudennad nevez en isforom $BOARDNAME e $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME en deus respontet d\'ho neudennad en isforom $BOARDNAME e $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME en deus respontet en isforom $BOARDNAME e $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME en deus respontet en isforom $BOARDNAME e $WIKI',
	'forum-mail-notification-html-greeting' => "Demat deoc'h $1,",
	'forum-mail-notification-html-button' => 'Gwelet ar gaoz',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Salud deoc\'h $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Gwelet ar c\'hendiviz :($MESSAGE_LINK)

Skipailh Wikia

___________________________________________
* Kavit skoazell hag alioù e : http://community.wikia.com
* Fellout a ra deoc\'h resev nebeutoc\'h a gemennadennoù diganeoc\'h ? Gallout a rit digoumanantiñ pe cheñch ho tibarzhioù postel amañ : http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'war an $1',
	'forum-wiki-activity-msg-name' => 'rann $1',
	'forum-activity-module-heading' => 'Oberiantiz ar forom',
	'forum-related-module-heading' => 'Neudennadoù liammet',
	'forum-activity-module-posted' => '$1 en deus postet ur respont $2',
	'forum-activity-module-started' => '$1 en deus kroget gant ur gaoz $2',
	'forum-contributions-line' => '[[$1|$2]] e [[$3|isforom $4]]',
	'forum-recentchanges-new-message' => 'en [[$1|isforom $2]]',
	'forum-recentchanges-edit' => 'kemennadenn aozet',
	'forum-recentchanges-deleted-reply-title' => 'Ur gemennadenn',
	'forum-recentchanges-namespace-selector-message-wall' => 'Isforom',
	'forum-recentchanges-history-link' => 'istor an isforom',
	'forum-recentchanges-thread-history-link' => 'istor an neudennad',
	'forum-recentchanges-closed-thread' => 'serriñ an neudennad "[[$1|$2]]" gant [[$3|$4]]',
	'forum-board-history-title' => 'istor an isforom',
	'forum-specialpage-oldforum-link' => 'Dielloù kozh ar forom',
	'forum-admin-page-breadcrumb' => 'Merañ an isforomoù',
	'forum-admin-create-new-board-label' => 'Krouiñ ur rann nevez',
	'forum-admin-create-new-board-modal-heading' => 'Krouiñ ur rann nevez',
	'forum-admin-create-new-board-title' => 'Titl ar rann',
	'forum-admin-create-new-board-description' => 'Deskrivadur ar rann',
	'forum-admin-edit-board-modal-heading' => 'Aozañ ar rann : $1',
	'forum-admin-edit-board-title' => 'Titl ar rann',
	'forum-admin-edit-board-description' => 'Deskrivadur ar rann',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Dilemel ar rann : $1',
	'forum-admin-delete-board-title' => "Kadarnait, mar plij, o vizskrivañ anv an isforom a fell deoc'h dilemel :",
	'forum-admin-merge-board-warning' => 'Kendeuzet e vo neudennadoù an isforom-mañ e-barzh un isforom zo anezhañ dija.',
	'forum-admin-merge-board-destination' => 'Dibabit un isforom da gendeuziñ gantañ :',
	'forum-admin-delete-and-merge-button-label' => 'Dilemel ha kendeuziñ',
	'forum-admin-link-label' => 'Merañ isforomoù',
	'forum-autoboard-title-1' => 'Kaoz hollek',
	'forum-autoboard-body-1' => 'Ar rann-mañ zo evit kaozioù hollek diwar-benn ar wiki.',
	'forum-autoboard-title-2' => 'Nevezentioù ha kemennoù',
	'forum-autoboard-title-3' => 'Nevez war $1',
	'forum-autoboard-title-4' => 'Goulennoù ha Respontoù',
	'forum-autoboard-title-5' => "Dudi ha c'hoarioù",
	'forum-board-destination-empty' => '(Diuzit un isforom, mar plij)',
	'forum-board-title-validation-invalid' => 'Arouezennoù direizh zo en anv en isforom',
	'forum-board-title-validation-length' => '4 arouezenn da nebeutañ a rank bezañ en anv an isforom',
	'forum-board-title-validation-exists' => 'Un isforom anvet evel-se zo anezhañ dija',
	'forum-board-validation-count' => 'An niver uhelañ a isforomoù zo $1',
	'forum-board-description-validation-length' => 'Skrivit ur deskrivadur evit ar rann-mañ, mar plij',
	'forum-board-id-validation-missing' => 'Diank eo anaouder an isforom',
	'forum-board-no-board-warning' => "N'omp ket bet evit kavout un isforom gant an titl-se. Setu amañ ur roll eus an isforomoù.",
	'forum-old-notification-message' => 'Diellet eo bet ar forom-mañ',
	'forum-old-notification-navigation-button' => 'Gweladenniñ ar foromoù nevez',
	'forum-related-discussion-heading' => 'Kaozioù diwar-benn $1',
	'forum-related-discussion-new-post-button' => 'Kregiñ gant ur gaoz',
	'forum-related-discussion-new-post-tooltip' => 'Kregiñ gant ur gaoz nevez diwaer-benn $1',
	'forum-related-discussion-total-replies' => '$1 kemennadenn',
	'forum-related-discussion-see-more' => "Gwelet muioc'h a gaozioù",
	'forum-confirmation-board-deleted' => 'Dilamet eo bet "$1".',
	'forum-token-mismatch' => 'Pop ! Ar jedouer ne glot ket',
];

/** Iriga Bicolano (Iriga Bicolano)
 * @author Filipinayzd
 */
$messages['bto'] = [
	'forum-specialpage-policies-edit' => 'Balyowan',
	'forum-mail-notification-html-greeting' => 'Unta $1,',
	'forum-mail-notification-subject' => '$1 -- $2',
];

/** Catalan (català)
 * @author Fitoschido
 * @author Grondin
 * @author Unapersona
 */
$messages['ca'] = [
	'forum-desc' => 'Extensió Especial:Forum de Wikia',
	'forum-disabled-desc' => 'Extensió Especial:Forum de Wikia; desactivada',
	'forum-forum-title' => 'Fòrum',
	'forum-active-threads' => '$1 {{PLURAL:$1|discussió activa|discussions actives}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|discussió activa|discussions actives}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|fil<br />en aquest fòrum|fils<br />en aquest fòrum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|discussió activa|discussions actives}}</span>',
	'forum-specialpage-heading' => 'Fòrum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Podeu editar-lo<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|fil|fils}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|entrada|entrades}}',
	'forum-specialpage-board-lastpostby' => 'Última tramesa per',
	'forum-specialpage-policies-edit' => 'Edita',
	'forum-specialpage-policies' => 'Política del fòrum / FAQ',
	'forum-policies-and-faq' => "== Polítiques del fòrum ==
Abans de contribuir als fòrums de {{SITENAME}}, tingueu en compte algunes bones pràctiques de conducta:

'''Ser agradable i tractar les persones amb respecte. '''
: Gent de tot el món pot llegir i editar aquest wiki i els seus fòrums. Com qualsevol altre projecte col·laboratiu, no tothom estarà d'acord amb tu sempre. S'han de mantenir debats civils i de ment oberta sobre diferents opinions. Tots estem aquí perquè ens agrada el mateix tema.

'''Intenta trobar debats existents en primer lloc, però no tinguis por de començar un nou fil. '''
: Abans d'iniciar un nou fil, assegura't que no n'hi ha cap de semblant a {{SITENAME}}. Si no trobeu el que busqueu, enceta un debat nou!

'''Demanar ajuda. '''
: Hi ha alguna cosa que et costa fer? O tens alguna pregunta? Demana ajuda aquí als fòrums! Si necessites ajuda del personal de Wikia, si us plau, contacta a la [[w:c:community|Comunitat Central]] o a [[Special:Contact]].

'''Diverteix-te! '''
: La comunitat de {{SITENAME}} és feliç de tenir-te aquí. Esperem veure't sovint als fòrums!.

== PMF del Fòrum==
'''Com puc mantenir-me informat sobre debats en els quals hi estic interessat?'''
: Amb un compte d'usuari de Wikia, pots seguir converses concretes i llavors rebre missatges de notificació (presencials o per correu electrònic) quan una discussió té més activitat. [[Special:UserSignup|Crea't un compte de Wikia]], si no en tens un!

'''Com puc eliminar el vandalisme? '''
: Si notes algun missatge spam o vandalisme en un fil, posa el ratolí sobre el text en qüestió. Veuràs un botó ''Més'' que aparèixer. Dins el menú ''Més'', trobaràs ''Eliminar''. Això et permetrà treure el comentari i, opcionalment, informar-ne als administradors.

'''Què són els temes? '''
: Els temes permeten enllaçar un fòrum de discussió amb un article de la wiki. És una altra manera per mantenir fòrums organitzats i per ajudar a les persones a trobar discussions interessants. Per exemple, un fil de fòrum etiquetat amb \"Lord Voldemort\" apareixerà a la part inferior de l'article \"Lord Voldemort\".",
	'forum-board-title' => '$1 Junta',
	'forum-board-topic-title' => 'Discussions sobre $1',
	'forum-board-topics' => 'Fils de discussió',
	'forum-board-thread-follow' => 'Segueix',
	'forum-board-thread-following' => 'Seguint',
	'forum-board-thread-kudos' => '$1 Felicitacions',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|missatge|missatges}}',
	'forum-board-new-message-heading' => 'Inicia una discussió',
	'forum-no-board-selection-error' => '← Si us plau seleccioni un lloc per penjar el fil',
	'forum-thread-reply-placeholder' => 'Deixar una resposta',
	'forum-thread-reply-post' => 'Contesta',
	'forum-thread-deleted-return-to' => 'Torna al board $1',
	'forum-sorting-option-newest-replies' => 'Respostes més recents',
	'forum-sorting-option-popular-threads' => 'Més popular',
	'forum-sorting-option-most-replies' => 'Més actius en 7 dies',
	'forum-sorting-option-newest-threads' => 'Nous fils',
	'forum-sorting-option-oldest-threads' => 'Discussions antigues',
	'forum-discussion-post' => 'Publicar',
	'forum-discussion-highlight' => 'Destaca aquesta discussió',
	'forum-discussion-placeholder-title' => 'De què vols parlar?',
	'forum-discussion-placeholder-message' => 'Publica un missatge nou en el mur $1',
	'forum-discussion-placeholder-message-short' => 'Penja un missatge nou',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|ha respost}} un fil teu al mur $3',
	'forum-notification-user2-reply-to-your' => "$1 i $2 t'han respost al mur $3",
	'forum-notification-user3-reply-to-your' => "$1 i altres t'han respost al mur $3",
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|ha respost}} al mur $3',
	'forum-notification-user2-reply-to-someone' => '$1 i $2 han respost al mur $3',
	'forum-notification-user3-reply-to-someone' => '$1 i altres han respost al mur $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|ha penjat}} un nou missatge al mur $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME ha iniciat un fil al mur $BOARDNAME de $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME ha iniciat un fil al mur $BOARDNAME de $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME t\'ha respost al mur $BOARDNAME de $WIKI.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME ha respost al mur $BOARDNAME de $WIKI.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME ha respost al mur $BOARDNAME de $WIKI.',
	'forum-mail-notification-html-greeting' => 'Hola, $1:',
	'forum-mail-notification-html-button' => 'Veure la discussió',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hola $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Veure la conversa: ($MESSAGE_LINK)

L\'Equip de Wikia

___________________________________________
* Vés a la Comunitat Central anglesa:
http://community.wikia.com
* Vés a la Comunitat Central catalana:
http://ca.wikia.com
* No vols rebre missatges de Wikia? Us podeu donar de baixa seguint l\'enllaç següent: http://ca.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hola $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Veure la discussió</a></p>
<p>L\'equip de Wikia</p>
___________________________________________<br />
* Vés a la Comunitat Central anglesa:
http://community.wikia.com
* Vés a la Comunitat Central catalana:
http://ca.wikia.com
* No vols rebre missatges de Wikia? Us podeu donar de baixa seguint l\'enllaç següent: http://ca.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'A $1',
	'forum-wiki-activity-msg-name' => 'M$1ur',
	'forum-activity-module-heading' => 'Activitat del fòrum',
	'forum-related-module-heading' => 'Temes relacionats',
	'forum-activity-module-posted' => '$1 ha respost fa $2',
	'forum-activity-module-started' => '$1 ha iniciat una discussió fa $2',
	'forum-contributions-line' => '[[$1|$2]] al [[$3|mur $4]]',
	'forum-recentchanges-new-message' => 'Al [[$1|mur $2]]',
	'forum-recentchanges-edit' => 'Missatge editat',
	'forum-recentchanges-removed-thread' => 'Retirat el fil "[[$1|$2]]" del [[$3|mur $4]]',
	'forum-recentchanges-removed-reply' => 'Retirada la resposta "[[$1|$2]]" del [[$3|mur $4]]',
	'forum-recentchanges-restored-thread' => 'El fil "[[$1|$2]]" del [[$3|mur $4]] s\'ha restaurat',
	'forum-recentchanges-restored-reply' => 'La resposta "[[$1|$2]]" al [[$3|mur $4]] s\'ha restaurat',
	'forum-recentchanges-deleted-thread' => 'El fil "[[$1|$2]]" del [[$3|mur $4]] s\'ha esborrat',
	'forum-recentchanges-deleted-reply' => 'La resposta "[[$1|$2]]" del [[$3|mur $4]] s\'ha retirat',
	'forum-recentchanges-deleted-reply-title' => 'Una publicació',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subfòrum',
	'forum-recentchanges-thread-group' => '$1 al <a href="$2">mur $3</a>',
	'forum-recentchanges-history-link' => 'Historial del mur',
	'forum-recentchanges-thread-history-link' => 'Historial del fil',
	'forum-recentchanges-closed-thread' => 'El fil "[[$1|$2]]" de [[$3|$4]] s\'ha tancat',
	'forum-recentchanges-reopened-thread' => 'El fil "[[$1|$2]]" de [[$3|$4]] s\'ha reobert',
	'forum-board-history-title' => 'Historial del Mur',
	'forum-specialpage-oldforum-link' => 'Arxius del Fòrum',
	'forum-admin-page-breadcrumb' => 'Gestió Administrativa del Mur',
	'forum-admin-create-new-board-label' => 'Crear nou mur',
	'forum-admin-create-new-board-modal-heading' => 'Crea un nou mur',
	'forum-admin-create-new-board-title' => 'Títol del mur',
	'forum-admin-create-new-board-description' => 'Descripció del mur',
	'forum-admin-edit-board-modal-heading' => 'Modifica el Mur: $1',
	'forum-admin-edit-board-title' => 'Títol del mur',
	'forum-admin-edit-board-description' => 'Descripció del mur',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Suprimir el mur $1',
	'forum-admin-delete-board-title' => 'Confirmeu escrivint el nom del mur que voleu suprimir:',
	'forum-admin-merge-board-warning' => 'Els fils en aquest mur es fusionaran en un mur existent.',
	'forum-admin-merge-board-destination' => 'Trieu una mur per fusionar:',
	'forum-admin-delete-and-merge-button-label' => 'Elimina i trasllada',
	'forum-admin-link-label' => 'Gestionar murs',
	'forum-autoboard-title-1' => 'Discussió general',
	'forum-autoboard-body-1' => 'Aquest mur és per les discussions generals sobre el wiki.',
	'forum-autoboard-title-2' => 'Notícies i anuncis',
	'forum-autoboard-body-2' => 'Últimes notícies i informació!',
	'forum-autoboard-title-3' => 'Nou a $1',
	'forum-autoboard-body-3' => "Vols compartir una cosa que només s'ha penjat en aquest wiki, o felicitar a algú per una aportació rellevant? Aquest és el lloc!",
	'forum-autoboard-title-4' => 'Preguntes i respostes',
	'forum-autoboard-body-4' => 'Tens una pregunta sobre el Wiki? Fes la teva pregunta aquí!',
	'forum-autoboard-title-5' => 'Diversió i jocs',
	'forum-autoboard-body-5' => 'Aquest mur és per converses off-topic -- un lloc per parlar amb els teus amics de $1!',
	'forum-board-destination-empty' => '(Seleccioneu un subfòrum)',
	'forum-board-title-validation-invalid' => 'El nom del mur conté caràcters no vàlids',
	'forum-board-title-validation-length' => 'El nom del mur ha de ser com a mínim de 4 cràcters',
	'forum-board-title-validation-exists' => 'Ja existeix un tema amb el mateix nom',
	'forum-board-validation-count' => 'El nombre màxim de temes és $1',
	'forum-board-description-validation-length' => 'Si us plau, escriu una descripció per aquest tema',
	'forum-board-id-validation-missing' => 'Falta la id del tema',
	'forum-board-no-board-warning' => 'No hem trobat un tema amb aquest nom. Aquí hi ha la llista de temes del fòrum.',
	'forum-old-notification-message' => 'Aquest Fòrum ha estat arxivat',
	'forum-old-notification-navigation-button' => 'Visita el nou Fòrum',
	'forum-related-discussion-heading' => 'Discussions sobre $1',
	'forum-related-discussion-new-post-button' => 'Inicia una discussió',
	'forum-related-discussion-new-post-tooltip' => 'Enceteu un debat nou sobre $1',
	'forum-related-discussion-total-replies' => '$1 missatges',
	'forum-related-discussion-see-more' => 'Mostra més discussions',
	'forum-confirmation-board-deleted' => "S'ha suprimit “$1”.",
	'forum-token-mismatch' => 'Ops! No coincideix amb la fitxa',
];

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = [
	'forum-discussion-post' => 'Хаам',
	'forum-contributions-line' => '[[$1|$2]] дакъанехь [[$3|$4]]',
	'forum-recentchanges-new-message' => '[[$1|дакъанехь $2]]',
	'forum-recentchanges-edit' => 'табина хаам',
	'forum-recentchanges-deleted-reply-title' => 'Хаам',
];

/** Czech (čeština)
 * @author Aktron
 * @author Darth Daron
 * @author H4nek
 */
$messages['cs'] = [
	'forum-forum-title' => 'Fórum',
	'forum-active-threads' => '$1 {{PLURAL:$1|aktivní diskuze|aktivní diskuze|aktivních diskuzí}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|aktivní diskuze|aktivní diskuze|aktivních diskuzí}} o: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|vlákno<br />na tomto fóru|vlákna<br />na tomto fóru|vláken<br />na tomto fóru}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|aktivní<br />diskuze|aktivní<br />diskuze|aktivních<br />diskuzí}}</span>',
	'forum-specialpage-heading' => 'Fórum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Můžete to upravit<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|vlákno|vlákna|vláken}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|příspěvek|příspěvky|příspěvků}}',
	'forum-specialpage-board-lastpostby' => 'Poslední příspěvek od',
	'forum-specialpage-policies-edit' => 'Upravit',
	'forum-specialpage-policies' => 'Pravidla na fóra/FAQ',
	'forum-board-topic-title' => 'Diskuze o $1',
	'forum-board-topics' => 'Témata',
	'forum-board-thread-follow' => 'Sledovat',
	'forum-board-thread-following' => 'Sledováno',
	'forum-board-new-message-heading' => 'Začít novou diskusi',
	'forum-thread-reply-placeholder' => 'Odpovědět',
	'forum-thread-reply-post' => 'Odpovědět',
	'forum-sorting-option-newest-replies' => 'Poslední odpovědi',
	'forum-sorting-option-popular-threads' => 'Nejpopulárnější',
	'forum-sorting-option-most-replies' => 'Nejaktivnější za 7 dní',
	'forum-sorting-option-newest-threads' => 'Nejnovější vlákna',
	'forum-sorting-option-oldest-threads' => 'Nejstarší vlákna',
	'forum-discussion-post' => 'Poslat',
	'forum-discussion-highlight' => 'Zvýraznit tuto diskuzi',
	'forum-discussion-placeholder-title' => 'O čem chcete mluvit?',
	'forum-discussion-placeholder-message-short' => 'Napsat novou zprávu',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|odpověděl|odpověděla}} na vaše vlákno v subfóru $3',
	'forum-notification-user2-reply-to-your' => '$1 a $2 odpověděli na vaše vlákno v subfóru $3',
	'forum-notification-user3-reply-to-your' => '$1 a další odpověděli na vaše vlákno v subfóru $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|odpověděl|odpověděla}} v subfóru $3',
	'forum-notification-user2-reply-to-someone' => '$1 a $2 odpověděli v subfóru $3',
	'forum-notification-user3-reply-to-someone' => '$1 a další odpověděli v subfóru $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|napsal|napsala}} novou zprávu v subfóru $2',
	'forum-mail-notification-html-greeting' => 'Ahoj $1,',
	'forum-mail-notification-html-button' => 'Zobrazit konverzaci',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-activity-module-heading' => 'Aktivita fóra',
	'forum-related-module-heading' => 'Související vlákna',
	'forum-recentchanges-edit' => 'upravená zpráva',
	'forum-recentchanges-removed-thread' => 'vlákno "[[$1|$2]]" bylo z [[$3|$4]] odstraněno',
	'forum-recentchanges-deleted-reply-title' => 'post',
	'forum-autoboard-body-4' => 'Máte dotaz ohledně wiki nebo tématu? Ptejte se tady!',
	'forum-autoboard-title-5' => 'Zábava a hry',
	'forum-old-notification-navigation-button' => 'Navštivte nová Fóra',
	'forum-related-discussion-heading' => 'Diskuze na téma: $1',
	'forum-related-discussion-new-post-button' => 'Zahájit diskusi',
	'forum-related-discussion-new-post-tooltip' => 'Zahájit novou diskusi o $1',
	'forum-related-discussion-total-replies' => '$1{{PLURAL:$1|zpráva|zprávy|zpráv}}',
	'forum-related-discussion-see-more' => 'Zobrazit více diskuzí',
	'forum-confirmation-board-deleted' => '"$1" bylo smazáno.',
];

/** German (Deutsch)
 * @author Das Schäfchen
 * @author Metalhead64
 */
$messages['de'] = [
	'forum-desc' => 'Forum-Erweiterung von Wikia',
	'forum-disabled-desc' => 'Forum-Erweiterung von Wikia; deaktiviert',
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '{{PLURAL:$1|Eine aktive Diskussion|$1 aktive Diskussionen}}',
	'forum-active-threads-on-topic' => "{{PLURAL:$1|Eine aktive Diskussion|$1 aktive Diskussionen}} über: '''[[$2]]'''",
	'forum-header-total-threads' => '<span>{{PLURAL:$1|Ein Thread<br />in diesem Forum|<em>$1</em> Threads<br />in diesem Forum}}</span>',
	'forum-header-active-threads' => '<span>{{PLURAL:$1|Eine aktive<br />Diskussion|<em>$1</em> aktive<br />Diskussionen}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Du kannst es bearbeiten<span>',
	'forum-specialpage-board-threads' => '{{PLURAL:$1|Ein Thread|$1 Threads}}',
	'forum-specialpage-board-posts' => '{{PLURAL:$1|Ein Beitrag|$1 Beiträge}}',
	'forum-specialpage-board-lastpostby' => 'Letzter Beitrag von',
	'forum-specialpage-policies-edit' => 'Bearbeiten',
	'forum-specialpage-policies' => 'Forumrichtlinien / Häufig gestellte Fragen',
	'forum-policies-and-faq' => "== Forumsrichtlinien ==
Bevor du auf den {{SITENAME}}-Foren aktiv wirst, beachte bitte einige gute Methoden zur Durchführung:

'''Sei freundlich und behandle Menschen respektvoll.'''
: Menschen aus der ganzen Welt lesen und bearbeiten dieses Wiki und seine Foren. Wie bei jedem anderen kollaborativen Projekt wird nicht jeder die ganze Zeit mit anderen in Übereinstimmung sein. Halte Diskussionen höflich und sei offen für unterschiedliche Meinungen. Wir alle sind hier, weil wir das gleiche Thema mögen.

'''Versuche zuerst, vorhandene Diskussionen zu finden, aber scheue nicht das Starten eines neuen Threads.'''
: Nimm dir Zeit für das Durchsuchen der {{SITENAME}}-Forumboards, um zu erfahren, ob eine Diskussion bereits vorhanden ist über ein Thema, über das du sprechen willst. Falls du nicht das finden kannst, wonach du suchst, starte einfach eine neue Diskussion!

'''Bitte um Hilfe.'''
: Ist etwas nicht richtig? Oder hast du eine Frage? Bitte hier in den Foren um Hilfe! Falls du Hilfe von den Wikia-Mitarbeitern benötigst, kontaktiere bitte [[w:c:community|Community Central]] oder [[Special:Contact]].

'''Hab Spaß!'''
: Die {{SITENAME}}-Gemeinschaft ist froh, dass du hier bist. Wir diskutieren dieses Thema, das wir alle mögen.

== Häufig gestellte Fragen ==
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
	'forum-contributions-line' => '[[$1|$2]] auf dem [[$3|Board $4]]',
	'forum-recentchanges-new-message' => 'auf dem [[$1|Board $2]]',
	'forum-recentchanges-edit' => 'Nachricht bearbeitet',
	'forum-recentchanges-removed-thread' => 'Thread „[[$1|$2]]“ vom [[$3|Board $4]] entfernt',
	'forum-recentchanges-removed-reply' => 'Antwort von „[[$1|$2]]“ aus dem [[$3|Board $4]] entfernt',
	'forum-recentchanges-restored-thread' => 'Thread „[[$1|$2]]“ auf dem [[$3|Board $4]] wiederhergestellt',
	'forum-recentchanges-restored-reply' => 'Antwort auf „[[$1|$2]]“ auf dem [[$3|Board $4]] wiederhergestellt',
	'forum-recentchanges-deleted-thread' => 'Thread „[[$1|$2]]“ vom [[$3|Board $4]] gelöscht',
	'forum-recentchanges-deleted-reply' => 'Antwort von „[[$1|$2]]“ vom [[$3|Board $4]] gelöscht',
	'forum-recentchanges-deleted-reply-title' => 'Ein Beitrag',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forumboard',
	'forum-recentchanges-thread-group' => '$1 auf dem [[$2|Board „$3“]]',
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
	'forum-related-discussion-see-more' => 'Weitere Diskussionen ansehen',
	'forum-confirmation-board-deleted' => '„$1“ wurde gelöscht.',
	'forum-token-mismatch' => 'Upps! Token stimmt nicht überein.',
];

/** British English (British English)
 * @author Captaindogfish
 * @author Shirayuki
 */
$messages['en-gb'] = [
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
: Topics allow you to link a forum discussion with a wiki article. It's another way to keep Forums organised and to help people find interesting discussions. For example, a Forum thread tagged with \"Lord Voldemort\" will appear at the bottom of the \"Lord Voldemort\" article.",
	'forum-recentchanges-thread-group' => '$1 on the [[$2|$3 Board]]',
];

/** Spanish (español)
 * @author Fitoschido
 * @author Macofe
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = [
	'forum-desc' => 'Extensión Especial:Foro de Wikia',
	'forum-disabled-desc' => 'Extensión Especial:Foro de Wikia; desactivada',
	'forum-forum-title' => 'Foro',
	'forum-active-threads' => '$1 {{PLURAL:$1|tema activo|temas activos}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Tema activo|Temas activos}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|tema|temas}}<br /> en este foro</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Tema<br />activo|Temas<br />activos}}</span>',
	'forum-specialpage-heading' => 'Foro',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Puedes editarlo<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|tema|temas}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|mensaje|mensajes}}',
	'forum-specialpage-board-lastpostby' => 'Último mensaje escrito por',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas del foro / P+F',
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
	'forum-mail-notification-html-greeting' => 'Hola, $1:',
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
	'forum-contributions-line' => '[[$1|$2]] en el [[$3|subforo $4]]',
	'forum-recentchanges-new-message' => 'en el [[$1|subforo $2]]',
	'forum-recentchanges-edit' => 'mensaje editado',
	'forum-recentchanges-removed-thread' => 'borró el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-removed-reply' => 'borró una respuesta en "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-restored-thread' => 'restauró el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-restored-reply' => 'restauró una respuesta en "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-deleted-thread' => 'borró el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-deleted-reply' => 'borró una respuesta en el tema "[[$1|$2]]" del [[$3|subforo $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Un mensaje',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subforo',
	'forum-recentchanges-thread-group' => '$1 en el [[$2|subforo $3]]',
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
	'forum-board-destination-empty' => '(Selecciona un subforo)',
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
	'forum-related-discussion-see-more' => 'Ver más temas',
	'forum-confirmation-board-deleted' => '"$1" ha sido borrado.',
	'forum-token-mismatch' => '¡Oops! El token no coincide.',
];

/** Basque (euskara)
 * @author Subi
 */
$messages['eu'] = [
	'forum-board-topics' => 'Gaiak',
	'forum-board-thread-replies' => '{{PLURAL:$1|Mezu bat|$1 mezu}}',
	'forum-thread-reply-post' => 'Erantzun',
	'forum-related-discussion-total-replies' => '$1 mezu',
	'forum-related-discussion-see-more' => 'Ikusi eztabaida gehiago',
];

/** Persian (فارسی)
 * @author Ebraminio
 * @author Movyn
 * @author Reza1615
 */
$messages['fa'] = [
	'forum-forum-title' => 'فروم',
	'forum-specialpage-heading' => 'فروم',
	'forum-specialpage-board-lastpostby' => 'آخرین ارسال توسط',
	'forum-specialpage-policies-edit' => 'ویرایش',
	'forum-specialpage-policies' => 'قوانین انجمن / FAQ',
	'forum-board-topic-title' => 'بحث‌ها پیرامون $1',
	'forum-board-topics' => 'تاپیکها',
	'forum-board-thread-follow' => 'دنبال‌کردن',
	'forum-board-thread-following' => 'دنبال‌کردن',
	'forum-board-new-message-heading' => 'آغاز یک بحث',
	'forum-no-board-selection-error' => 'لطفا یک انجمن برای ارسال انتخاب کنید←',
	'forum-thread-reply-placeholder' => 'ارسال پاسخ',
	'forum-thread-reply-post' => 'پاسخ دادن',
	'forum-thread-deleted-return-to' => 'بازگشت به انجمن $1',
	'forum-sorting-option-newest-replies' => 'بیشترین پاسخ‌های اخیر',
	'forum-sorting-option-popular-threads' => 'پر طرفدارترین‌ها',
	'forum-sorting-option-most-replies' => 'بیشترین فعالیت در ۷ روز اخیر',
	'forum-sorting-option-newest-threads' => 'موضوع‌های جدید',
	'forum-sorting-option-oldest-threads' => 'موضوع‌های قدیمی‌تر',
	'forum-discussion-post' => 'ارسال',
	'forum-discussion-placeholder-title' => 'درباره چه چیزی می‌خواهید بحث کنید؟',
	'forum-discussion-placeholder-message' => 'ارسال پیغام جدید در انجمن $1',
	'forum-discussion-placeholder-message-short' => 'ارسال پیغام جدید',
	'forum-mail-notification-html-button' => 'دیدن مکالمه',
	'forum-activity-module-heading' => 'فعالیت‌های انجمن',
	'forum-related-module-heading' => 'موضوعات مشابه',
	'forum-recentchanges-deleted-reply-title' => 'یک ارسال',
	'forum-recentchanges-namespace-selector-message-wall' => 'انجمن',
	'forum-recentchanges-history-link' => 'تاریخچه انجمن',
	'forum-recentchanges-thread-history-link' => 'تاریخچه موضوع',
	'forum-board-history-title' => 'تاریخچه انجمن',
	'forum-admin-create-new-board-label' => 'ساخت انجمن جدید',
	'forum-admin-create-new-board-modal-heading' => 'ساخت انجمن جدید',
	'forum-admin-create-new-board-title' => 'نام انجمن',
	'forum-admin-create-new-board-description' => 'توضیح انجمن',
	'forum-admin-edit-board-modal-heading' => 'ویرایش انجمن: $1',
	'forum-admin-edit-board-title' => 'عنوان انجمن',
	'forum-admin-edit-board-description' => 'توضیح انجمن',
	'forum-admin-delete-and-merge-board-modal-heading' => 'حذف انجمن: $1',
	'forum-related-discussion-new-post-button' => 'اغاز یک بحث',
	'forum-related-discussion-total-replies' => '$1 پیغام',
	'forum-related-discussion-see-more' => 'مشاهده بحث‌های بیشتر',
];

/** Finnish (suomi)
 * @author Elseweyr
 */
$messages['fi'] = [
	'forum-forum-title' => 'Foorumi',
	'forum-active-threads' => '$1 {{PLURAL:$1|aktiivinen keskustelu|aktiivista keskustelua}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|aktiivinen keskustelu|aktiivista keskustelua}} aiheesta '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|keskustelu<br />tässä Foorumissa|keskustelua<br />tässä Foorumissa}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|aktiivinen<br />keskustelu|aktiivista<br />keskustelua}}</span>',
	'forum-specialpage-heading' => 'Foorumi',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Sinä voit muokata tätä<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|keskustelu|keskustelua}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|viesti|viestiä}}',
	'forum-specialpage-board-lastpostby' => 'Viimeisimmän viestin kirjoitti',
	'forum-specialpage-policies-edit' => 'Muokkaa',
	'forum-specialpage-policies' => 'Foorumin säännöt / UKK',
	'forum-policies-and-faq' => "==Foorumin säännöt==
Ennen kuin alat käyttää {{SITENAME}}n Foorumeja, pidäthän mielessä muutamat hyvän käytöksen periaatteet:

'''Ole ystävällinen ja kunnioittavainen muita kohtaan.'''
:Tässä wikissä ja sen foorumeissa on muokkaajia ympäri Suomea ja mahdollisesti muualtakin. Kuten muissakin yhteistyöhankkeissa, kaikki eivät voi olla asioista koko ajan samaa mieltä. Pysy kohteliaana ja avoimena muille mielipiteille. Olemme kaikki täällä, koska pidämme samasta aiheesta.

'''Yritä ensiksi löytää olemassaolevia keskusteluja, mutta älä pelkää luoda uusia.'''
:Ole hyvä ja selaa hetki {{SITENAME}}n Foorumin keskustelupalstoja nähdäksesi, mikäli keskusteluja mieleisesi aiheesta on mahdollisesti jo käynnissä. Jos et löydä etsimääsi, heittäydy sekaan ja aloita uusi keskustelu!

'''Pyydä apua.'''
:Huomasitko jotakin, mikä ei vaikuttanut olevan ihan kohdallaan, vai onko sinulla kysyttävää? Pyydä Foorumissa apua! Jos tarvitset apua Wikian henkilökunnalta, ota yhteyttä heihin [[w:c:community|Community Central]]in [[Special:Contact]] -sivun kautta.

'''Pidä hauskaa!'''
:{{SITENAME}}n yhteisö iloitsee läsnäolostati. Toivottavasti näemme sinut jatkossakin, kun kokoonnumme keskustelemaan suosikkiaiheestamme.

==Foorumin UKK==
'''Miten pysyn kärryillä keskusteluista, jotka kiinnostavat minua?'''
:Wikian käyttäjätilillä voit seurata tiettyjä keskusteluja ja saada tiedotteita keskusteluiden aktiviteetista joko itse sivustolla tai sähköpostitse. [[Special:UserSignup|Luohan siis itsellesi tili]], mikäli sinulla ei sellaista vielä ole!

'''Miten poistan vandalismia?'''
:Jos huomaat keskustelussa spämmiä tai vandalismia, vie osoitin sääntöjä rikkovan tekstin päälle. Näet \"Lisää\" -napin ilmestyvän. \"Lisää\" -valikon sisältä löydät vaihtoehdon \"Poista\", mikä poistaa vandalismin ja tarjoaa mahollisuuden ilmoittaa siitä ylläpitäjälle.

'''Mitä Kehut ovat?'''
:Jos pidät tiettyä keskustelua tai viestiä mielenkiintoisena, hyvin perusteltuna tai huvittavana, voit osoittaa arvostuksesi antamalla kehu. Kehut voivat olla avuksi myös äänestystilanteissa.

'''Mitä Aiheet ovat?'''
:Aiheiden avulla voit linkittää foorumikeskustelun tiettyyn wikiartikkeliin. Se on tapa pitää Foorumeja järjestyksessä ja auttaa käyttäjiä löytämään kiinnostavia keskusteluja. Esimerkiksi Lord Voldemortilla tagattu keskustelu ilmestyy Lord Voldemortin artikkelin alareunaan.",
	'forum-board-title' => '$1',
	'forum-board-topic-title' => 'Keskusteluja aiheesta $1',
	'forum-board-topics' => 'Aiheet',
	'forum-board-thread-follow' => 'Seuraa',
	'forum-board-thread-following' => 'Seurattu',
	'forum-board-thread-kudos' => '$1 kehua',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|viesti|viestiä}}',
	'forum-board-new-message-heading' => 'Aloita keskustelu',
	'forum-no-board-selection-error' => '← Valitse keskustelupalsta',
	'forum-thread-reply-placeholder' => 'Lähetä vastaus',
	'forum-thread-reply-post' => 'Vastaa',
	'forum-thread-deleted-return-to' => 'Palaa palstalle $1',
	'forum-sorting-option-newest-replies' => 'Viimeisimmät vastaukset',
	'forum-sorting-option-popular-threads' => 'Suosituimmat',
	'forum-sorting-option-most-replies' => 'Viimeisen 7 päivän aktiivisimmat',
	'forum-sorting-option-newest-threads' => 'Uusimmat keskustelut',
	'forum-sorting-option-oldest-threads' => 'Vanhimmat keskustelut',
	'forum-discussion-post' => 'Luo keskustelu',
	'forum-discussion-highlight' => 'Korosta tämä keskustelu',
	'forum-discussion-placeholder-title' => 'Mistä haluat keskustella?',
	'forum-discussion-placeholder-message' => 'Kirjoita uusi viesti $1 -palstalle',
	'forum-discussion-placeholder-message-short' => 'Lähetä uusi viesti',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|vastasi}} keskusteluusi $3 -palstalla',
	'forum-notification-user2-reply-to-your' => '$1 ja $2 vastasivat keskusteluusi $3 -palstalla',
	'forum-notification-user3-reply-to-your' => '$1 ja muutama muu vastasivat keskusteluusi $3 -palstalla',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|vastasi}} $3 -palstalla',
	'forum-notification-user2-reply-to-someone' => '$1 ja $2 vastasivat $3 -palstalla',
	'forum-notification-user3-reply-to-someone' => '$1 ja muutama muu vastasivat $3 -palstalla',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|jätti}} uuden viestin $2 -palstalle',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME aloitti uuden keskustelun $WIKIn $BOARDNAME -palstalla.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME aloitti uuden keskustelun $WIKIn $BOARDNAME -palstalla.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME vastasi keskusteluusi $WIKIn $BOARDNAME -palstalla',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME vastasi $WIKIn $BOARDNAME -palstalla',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME vastasi $WIKIn $BOARDNAME -palstalla',
	'forum-mail-notification-html-greeting' => 'Hei $1,',
	'forum-mail-notification-html-button' => 'Näe keskustelu',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hei $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Näe keskustelu: ($MESSAGE_LINK)

Wikia -tiimi

___________________________________________
* Löydä apua ja neuvoja Yhteisöwikiltä: http://yhteiso.wikia.com
* Haluatko saada vähemmäm viestejä meiltä? Voit peruuttaa tilauksen tai muuttaa sähköpostiasetuksia täällä: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hei $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Näe keskustelu</a></p>
<p>Wikia-tiimi</p>
___________________________________________<br />
* Löydä apua ja neuvoja Yhteisöwikiltä: http://yhteiso.wikia.com
* Haluatko saada vähemmäm viestejä meiltä? Voit peruuttaa tilauksen tai muuttaa sähköpostiasetuksia täällä: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'palstalla $1',
	'forum-wiki-activity-msg-name' => '$1',
	'forum-activity-module-heading' => 'Foorumitoiminta',
	'forum-related-module-heading' => 'Tähän liittyvät keskustelut',
	'forum-activity-module-posted' => '$1 vastasi $2',
	'forum-activity-module-started' => '$1 aloitti keskustelun $2',
	'forum-contributions-line' => '[[$1|$2]] palstalla [[$3|$4]]',
	'forum-recentchanges-new-message' => '[[$1|$2 -palstalla]]',
	'forum-recentchanges-edit' => 'muokkasi viestiä',
	'forum-recentchanges-removed-thread' => 'poisti keskustelun "[[$1|$2]]" palstalta [[$3|$4]]',
	'forum-recentchanges-removed-reply' => 'poisti vastauksen [[$3|$4 -palstan]] keskustelusta "[[$1|$2]]"',
	'forum-recentchanges-restored-thread' => 'palautti keskustelun "[[$1|$2]]" [[$3|$4 -palstalle]]',
	'forum-recentchanges-restored-reply' => 'palautti vastauksen [[$3|$4 -palstan]] keskusteluun "[[$1|$2]]"',
	'forum-recentchanges-deleted-thread' => 'poisti [[$3|$4 -palstan]] keskustelun "[[$1|$2]]"',
	'forum-recentchanges-deleted-reply' => 'poisti vastauksen [[$3|$4 -palstan]] keskustelusta "[[$1|$2]]"',
	'forum-recentchanges-deleted-reply-title' => 'Viesti',
	'forum-recentchanges-namespace-selector-message-wall' => 'Keskustelupalsta',
	'forum-recentchanges-thread-group' => '$1 palstalla [[$2|$3]]',
	'forum-recentchanges-history-link' => 'palstan historia',
	'forum-recentchanges-thread-history-link' => 'keskusteluhistoria',
	'forum-recentchanges-closed-thread' => 'sulki ketjun "[[$1|$2]]" palstalla [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'uudelleenavasi ketjun "[[$1|$2]]" palstalla [[$3|$4]]',
	'forum-board-history-title' => 'palstan historia',
	'forum-specialpage-oldforum-link' => 'Foorumiarkisto',
	'forum-admin-page-breadcrumb' => 'Palstojen hallinta ylläpitäjiä varten',
	'forum-admin-create-new-board-label' => 'Luo Palsta',
	'forum-admin-create-new-board-modal-heading' => 'Luo uusi keskustelupalsta',
	'forum-admin-create-new-board-title' => 'Palstan otsikko',
	'forum-admin-create-new-board-description' => 'Palstan kuvaus',
	'forum-admin-edit-board-modal-heading' => 'Muokkaa palstaa $1',
	'forum-admin-edit-board-title' => 'Palstan otsikko',
	'forum-admin-edit-board-description' => 'Palstan kuvaus',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Poista palsta: $1',
	'forum-admin-delete-board-title' => 'Vahvista kirjoittamalla poistettavan palstan nimi:',
	'forum-admin-merge-board-warning' => 'Tämän palstan ketjut yhdistetään olemassaolevaan palstaan.',
	'forum-admin-merge-board-destination' => 'Valitse keskustelpalsta, johon yhdistetään:',
	'forum-admin-delete-and-merge-button-label' => 'Poista ja yhdistä',
	'forum-admin-link-label' => 'Hallinnoi palstoja',
	'forum-autoboard-title-1' => 'Yleinen keskustelu',
	'forum-autoboard-body-1' => 'Tämä palsta on wikiä koskevia yleisiä keskusteluja varten.',
	'forum-autoboard-title-2' => 'Uutiset ja tiedotteet',
	'forum-autoboard-body-2' => 'Kuumat uutiset ja tiedot!',
	'forum-autoboard-title-3' => 'Uutta sivustolla $1',
	'forum-autoboard-body-3' => 'Haluatko jakaa jotakin, mikä julkaistiin tässä wikissä, tai kehua jonkun muokkauksia? Tämä on oikea paikka!',
	'forum-autoboard-title-4' => 'Kysymyksiä ja vastauksia',
	'forum-autoboard-body-4' => 'Onko sinulla kysysttävää wikistä tai tästä aiheesta? Esitä kysymyksesi täällä!',
	'forum-autoboard-title-5' => 'Hupi ja pelit',
	'forum-autoboard-body-5' => 'Tämä palsta on aiheeseen liittymätöntä keskustelua varten -- paikka, jossa voit hengailla $1 -ystäviesi kanssa.',
	'forum-board-destination-empty' => '(ole hyvä ja valitse palsta)',
	'forum-board-title-validation-invalid' => 'Palstan nimi sisältää virheellisiä merkkejä',
	'forum-board-title-validation-length' => 'Palstan nimen tulisi olla vähintään 4 merkin pituinen',
	'forum-board-title-validation-exists' => 'Samanniminen palsta on jo olemassa',
	'forum-board-validation-count' => 'Palstojen maksimimäärä on $1',
	'forum-board-description-validation-length' => 'Laadi kuvaus tälle palstalle',
	'forum-board-id-validation-missing' => 'Palstan ID puuttuu',
	'forum-board-no-board-warning' => 'Emme löytäneet palstaa sillä nimellä. Tässä on luettelo foorumin palstoista.',
	'forum-old-notification-message' => 'Tämä Foorumi on arkistoitu',
	'forum-old-notification-navigation-button' => 'Vieraile uusissa Foorumeissa',
	'forum-related-discussion-heading' => 'Keskusteluja aiheesta $1',
	'forum-related-discussion-new-post-button' => 'Aloita keskustelu',
	'forum-related-discussion-new-post-tooltip' => 'Aloita uusi keskustelu aiheesta $1',
	'forum-related-discussion-total-replies' => '$1 viestiä',
	'forum-related-discussion-see-more' => 'Katso lisää keskusteluja',
	'forum-confirmation-board-deleted' => '"$1" on poistettu.',
];

/** French (français)
 * @author Crochet.david
 * @author Gomoko
 * @author Wyz
 */
$messages['fr'] = [
	'forum-desc' => 'Extension Special:Forum de Wikia',
	'forum-disabled-desc' => 'Extension Special:Forum de Wikia ; désactivée',
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|discussion active|discussions actives}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|discussion active|discussions actives}} à propos de « '''[[$2]]''' »",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|discussion<br />sur ce forum|discussions<br />sur ce forum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|discussion<br />active|discussions<br />actives}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Vous pouvez le modifier<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|discussion|discussions}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|message|messages}}',
	'forum-specialpage-board-lastpostby' => 'Dernier message de',
	'forum-specialpage-policies-edit' => 'Modifier',
	'forum-specialpage-policies' => 'Règles du forum / FAQ',
	'forum-policies-and-faq' => "==Règles du forum==
Avant de contribuer sur le forum de {{SITENAME}}, veuillez garder à l’esprit quelques bonnes pratiques à suivre :

'''Soyez gentil et traitez les gens avec respect.'''
: Des gens venant de partout dans le monde lisent et modifient ce wiki et son forum. Comme pour tout autre projet collaboratif, tout le monde ne sera pas toujours d’accord. Faites en sorte que les discussions restent polies et soyez ouvert vis-à-vis des opinions différentes des vôtres. Nous sommes tous ici parce que nous aimons le même sujet.

'''Commencez par essayer de trouver des discussions existantes, mais n’ayez pas peur d’en créer une nouvelle.'''
: Veuillez prendre un peu de temps pour parcourir les sous-forums de {{SITENAME}} pour voir si une discussion sur quelque chose dont vous souhaitez parler existe déjà. Si vous ne trouvez pas ce que vous cherchez, lancez-vous et démarrez une nouvelle discussion !

'''Demandez de l'aide.'''
: Vous avez constaté quelque chose qui ne vous paraît pas normal ? Ou vous avez une question ? Demandez de l’aide ici sur le forum ! Si vous avez besoin de l’aide de l’équipe de Wikia, allez sur le [[w:c:community|wiki des communauté]] ou utilisez [[Special:Contact]].

'''Amusez-vous !'''
: La communauté de {{SITENAME}} est heureuse de vous avoir ici. Nous espérons vous voir dans le coin alors que nous discutons de ce sujet que nous aimons tous.

==FAQ du forum==
'''Comment suivre les discussions qui m’intéressent ?'''
: Avec un compte utilisateur Wikia, vous pouvez suivre des conversations en particulier et recevoir des messages de notification (soit sur le site soit par courriel) quand une discussion est complétée. Assurez-vous de [[Special:UserSignup|créer un compte Wikia]] si vous n’en avez pas déjà un.

'''Comment puis-je retirer le vandalisme ?'''
: Si vous constatez du spam ou du vandalisme sur une discussion, placez votre souris sur le texte incriminé. Vous verrez un bouton « Plus » apparaître. Dans le menu « Plus », vous trouverez « Retirer ». Cela vous permettra de retirer le message et d’en informer éventuellement un administrateur.

'''Que sont les sélections ?'''
: Si vous trouvez une discussion particulière ou une réponse intéressante, bien tournée ou amusante, vous pouvez montrer votre appréciation en la sélectionnant. Elles peuvent être également utiles dans les situations de vote.

'''Que sont les rubriques ?'''
: Les rubriques vous permettent de lier une discussion du forum avec un article du wiki. C’est un autre moyen de garder le forum organisé et d’aider les gens à trouver des discussions intéressantes. Par exemple, une discussion du forum marquée avec « Voldemort » apparaîtra en bas de l’article « Voldemort ».",
	'forum-board-title' => 'Sous-forum $1',
	'forum-board-topic-title' => 'Discussions à propos de « $1 »',
	'forum-board-topics' => 'Sujets',
	'forum-board-thread-follow' => 'Suivre',
	'forum-board-thread-following' => 'Suivi',
	'forum-board-thread-kudos' => '{{PLURAL:$1|1 sélection|$1 sélections}}',
	'forum-board-thread-replies' => '{{PLURAL:$1|1 message|$1 messages}}',
	'forum-board-new-message-heading' => 'Démarrer une discussion',
	'forum-no-board-selection-error' => '← Veuillez sélectionner un sous-forum sur lequel poster',
	'forum-thread-reply-placeholder' => 'Envoyer une réponse',
	'forum-thread-reply-post' => 'Répondre',
	'forum-thread-deleted-return-to' => 'Retourner au sous-forum $1',
	'forum-sorting-option-newest-replies' => 'Réponses les plus récentes',
	'forum-sorting-option-popular-threads' => 'Les plus populaires',
	'forum-sorting-option-most-replies' => 'Les plus actifs durant les 7 derniers jours',
	'forum-sorting-option-newest-threads' => 'Fils les plus récents en premier',
	'forum-sorting-option-oldest-threads' => 'Fils les plus anciens en premier',
	'forum-discussion-post' => 'Envoyer',
	'forum-discussion-highlight' => 'Épingler la discussion',
	'forum-discussion-placeholder-title' => 'De quoi souhaitez-vous discuter ?',
	'forum-discussion-placeholder-message' => 'Envoyer un nouveau message sur le sous-forum $1',
	'forum-discussion-placeholder-message-short' => 'Envoyer un nouveau message',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|a répondu}} à votre fil sur le sous-forum $3',
	'forum-notification-user2-reply-to-your' => '$1 et $2 ont répondu à votre fil sur le sous-forum $3',
	'forum-notification-user3-reply-to-your' => '$1, entre autres, a répondu à votre fil sur le sous-forum $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|a répondu}} sur le sous-forum $3',
	'forum-notification-user2-reply-to-someone' => '$1 et $2 ont répondu sur le sous-forum $3',
	'forum-notification-user3-reply-to-someone' => '$1, entre autres, a répondu sur le sous-forum $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|a laissé}} un nouveau message sur le sous-forum $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME a ouvert une nouvelle discussion sur le sous-forum $BOARDNAME de $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME a ouvert une nouvelle discussion sur le sous-forum $BOARDNAME de $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME a répondu à votre discussion sur le sous-forum $BOARDNAME de $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME a répondu sur le sous-forum $BOARDNAME de $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME a répondu sur le sous-forum $BOARDNAME de $WIKI',
	'forum-mail-notification-html-greeting' => 'Bonjour $1,',
	'forum-mail-notification-html-button' => 'Voir la conversation',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Bonjour $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

— $AUTHOR

Voir la conversation ($MESSAGE_LINK)

— L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://community.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.',
	'forum-mail-notification-body-HTML' => 'Bonjour $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>— $AUTHOR_SIGNATURE</p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Voir la conversation</a></p>

<p>— L’équipe Wikia</p>
<br /><hr />
<ul>
<li><a href="http://community.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="http://community.wikia.com/Special:Preferences">préférences</a></li>
</ul>',
	'forum-wiki-activity-msg' => 'sur le $1',
	'forum-wiki-activity-msg-name' => 'sous-forum $1',
	'forum-activity-module-heading' => 'Activité du forum',
	'forum-related-module-heading' => 'Discussions connexes',
	'forum-activity-module-posted' => '$1 a envoyé une réponse $2',
	'forum-activity-module-started' => '$1 a démarré une discussion $2',
	'forum-contributions-line' => '[[$1|$2]] sur le [[$3|sous-forum $4]]',
	'forum-recentchanges-new-message' => 'sur le [[$1|sous-forum $2]]',
	'forum-recentchanges-edit' => 'message modifié',
	'forum-recentchanges-removed-thread' => 'a retiré la discussion «&nbsp;[[$1|$2]]&nbsp;» du [[$3|sous-forum $4]]',
	'forum-recentchanges-removed-reply' => 'a retiré une réponse à «&nbsp;[[$1|$2]]&nbsp;» sur le [[$3|sous-forum $4]]',
	'forum-recentchanges-restored-thread' => 'a restauré la discussion «&nbsp;[[$1|$2]]&nbsp;» sur le [[$3|sous-forum $4]]',
	'forum-recentchanges-restored-reply' => 'a restauré une réponse à «&nbsp;[[$1|$2]]&nbsp;» sur le [[$3|sous-forum $4]]',
	'forum-recentchanges-deleted-thread' => 'a supprimé la discussion «&nbsp;[[$1|$2]]&nbsp;» sur le [[$3|sous-forum $4]]',
	'forum-recentchanges-deleted-reply' => 'a supprimé une réponse à «&nbsp;[[$1|$2]]&nbsp;» sur le [[$3|sous-forum $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Un message',
	'forum-recentchanges-namespace-selector-message-wall' => 'Sous-forum',
	'forum-recentchanges-thread-group' => '$1 sur le [[$2|sous-forum $3]]',
	'forum-recentchanges-history-link' => 'historique du sous-forum',
	'forum-recentchanges-thread-history-link' => 'historique de la discussion',
	'forum-recentchanges-closed-thread' => 'a fermé la discussion «&nbsp;[[$1|$2]]&nbsp;» de [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'a rouvert la discussion «&nbsp;[[$1|$2]]&nbsp;» de [[$3|$4]]',
	'forum-board-history-title' => 'historique du sous-forum',
	'forum-specialpage-oldforum-link' => "Archives de l'ancien forum",
	'forum-admin-page-breadcrumb' => 'Administration des sous-forums',
	'forum-admin-create-new-board-label' => 'Créer un nouveau sous-forum',
	'forum-admin-create-new-board-modal-heading' => 'Créer un nouveau sous-forum',
	'forum-admin-create-new-board-title' => 'Titre du sous-forum',
	'forum-admin-create-new-board-description' => 'Description du sous-forum',
	'forum-admin-edit-board-modal-heading' => 'Modifier sous-forum : $1',
	'forum-admin-edit-board-title' => 'Titre du sous-forum',
	'forum-admin-edit-board-description' => 'Description du sous-forum',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Supprimer le sous-forum : $1',
	'forum-admin-delete-board-title' => 'Veuillez confirmer en saisissant le nom du sous-forum que vous souhaitez supprimer :',
	'forum-admin-merge-board-warning' => 'Les discussions de ce sous-forum seront fusionnées avec un sous-forum existant.',
	'forum-admin-merge-board-destination' => 'Choisissez un sous-forum avec lequel fusionner :',
	'forum-admin-delete-and-merge-button-label' => 'Supprimer et fusionner',
	'forum-admin-link-label' => 'Gérer les sous-forums',
	'forum-autoboard-title-1' => 'Discussion générale',
	'forum-autoboard-body-1' => 'Ce sous-forum est destiné aux conversations générales sur le wiki.',
	'forum-autoboard-title-2' => 'Actualité et annonces',
	'forum-autoboard-body-2' => 'Actualité et informations brûlantes !',
	'forum-autoboard-title-3' => 'Nouveau sur $1',
	'forum-autoboard-body-3' => "Vous souhaitez partager quelque chose que vous venez de publier sur le wiki ou féliciter quelqu'un pour une contribution extraordinaire ?",
	'forum-autoboard-title-4' => 'Questions et réponses',
	'forum-autoboard-body-4' => "Vous avez une question à propos du wiki ou du sujet qu'il traite ? Posez vos questions ici !",
	'forum-autoboard-title-5' => 'Détente',
	'forum-autoboard-body-5' => 'Ce sous-forum est destiné aux conversations hors sujet &mdash; un endroit où traîner avec vos amis de $1.',
	'forum-board-destination-empty' => '(Veuillez sélectionner un sous-forum)',
	'forum-board-title-validation-invalid' => 'Le nom du sous-forum contient des caractères non valides',
	'forum-board-title-validation-length' => 'Le nom du sous-forum doit faire au moins 4 caractères',
	'forum-board-title-validation-exists' => 'Un sous-forum avec ce nom existe déjà',
	'forum-board-validation-count' => 'Le nombre maximum de sous-forums est $1',
	'forum-board-description-validation-length' => 'Veuillez écrire une description pour ce sous-forum',
	'forum-board-id-validation-missing' => "Il manque l'id du sous-forum",
	'forum-board-no-board-warning' => "Nous n'avons pas pu trouver un sous-forum avec ce titre. Voici la liste des sous-forums.",
	'forum-old-notification-message' => 'Ce forum a été archivé',
	'forum-old-notification-navigation-button' => 'Visiter le nouveau forum',
	'forum-related-discussion-heading' => 'Discussions à propos de « $1 »',
	'forum-related-discussion-new-post-button' => 'Démarrer une discussion',
	'forum-related-discussion-new-post-tooltip' => 'Démarrer une nouvelle discussion à propos de « $1 »',
	'forum-related-discussion-total-replies' => '$1 messages',
	'forum-related-discussion-see-more' => 'Voir plus de discussions',
	'forum-confirmation-board-deleted' => '« $1 » a été supprimé.',
	'forum-token-mismatch' => 'Oups ! Le jeton ne correspond pas',
];

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = [
	'forum-forum-title' => 'Foarum',
	'forum-specialpage-heading' => 'Foarum',
	'forum-specialpage-policies-edit' => 'Bewurkje',
	'forum-mail-notification-html-greeting' => 'Hallo $1,',
	'forum-mail-notification-subject' => '$1 -- $2',
];

/** Galician (galego)
 * @author Elisardojm
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = [
	'forum-forum-title' => 'Foro',
	'forum-active-threads' => '$1 {{PLURAL:$1|debate activo|debates activos}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|debate activo|debates activos}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em> <span>{{PLURAL:$1|fío<br />neste foro|fíos<br />neste foro}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|debate<br />activo|debates<br />activos}}</span>',
	'forum-specialpage-heading' => 'Foro',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Podes editalo<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|fío|fíos}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|publicación|publicacións}}',
	'forum-specialpage-board-lastpostby' => 'Última publicación de',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas do foro/Preguntas máis frecuentes',
	'forum-policies-and-faq' => "==Políticas do foro==
Antes de colaborar nos foros de {{SITENAME}} teña en conta as seguintes prácticas:

'''Trate á xente con respecto e non teña malas intencións.'''
:Persoas de todos os lugares do mundo len e editan este wiki e os seus foros. Como calquera outro proxecto colaborativo, non todo o mundo estará de acordo permanentemente co que se discuta, así que abra a súa mente a diferentes opinións. Estamos aquí porque nos gusta o mesmo tema.

'''Intente buscar entre as conversas existentes primeiro, pero non teña medo de iniciar un novo tema.'''
:Por favor, tome un momento para visitar os subforos deste wiki e ver se xa existe un debate sobre o que quere falar. Se non atopa o que busca, comeza unha nova conversa!

'''Pida axuda.'''
:Algo non se ve como debería? Ten algunha pregunta? Pida axuda aquí, no foro! Se necesita a axuda do persoal de Wikia, pode ir á nosa [[w:c:community|central da comunidade]] ou preguntar a través de [[Special:Contact|Contacto]].

'''Divírtase!'''
:A comunidade de {{SITENAME}} alégrase de que estea aquí. Queremos ver como fala sobre o tema que máis nos gusta.

==Preguntas frecuentes sobre o foro==
'''Como podo seguir as conversas nas que teño interese?'''
:Cunha conta de usuario de Wikia pode seguir conversas específicas e recibir notificacións (a través do wiki ou por correo electrónico) cando un tema teña máis actividade. [[Special:UserSignup|Cree unha conta en Wikia]] se aínda non o fixo.

'''Como borro os vandalismos?'''
:Se descobre mensaxes inadecuadas ou vandalismo nun fío, pasa o cursor sobre o texto. Verá que aparece un botón co texto \"Máis\". Dentro do menú que se desprega, atopará a opción \"Eliminar\". Isto permite retirar o vandalismo e avisar a un administrador se o considera necesario.

'''Que son os eloxios?'''
:Se atopa unha mensaxe ou resposta interesante, ben razoada ou simplemente apoia o seu contido, pódello mostrar aos demais dando un eloxio. Poden ser moi útiles tamén durante as votacións.

'''Que son os temas?'''
:Os temas permiten ligar as conversas do foro cun artigo do wiki. É outra forma de manter organizado o foro e axudar a outras persoas a atopar conversas interesantes. Por exemplo, un fío do foro coa etiqueta \"Lord Voldemort\" aparecerá ao final do artigo \"Lord Voldemort\".",
	'forum-board-title' => 'Taboleiro "$1"',
	'forum-board-topic-title' => 'Conversas sobre "$1"',
	'forum-board-topics' => 'Temas',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Seguindo',
	'forum-board-thread-kudos' => '$1 eloxios',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|mensaxe|mensaxes}}',
	'forum-board-new-message-heading' => 'Comezar un debate',
	'forum-no-board-selection-error' => '← Seleccione un taboleiro no que publicar',
	'forum-thread-reply-placeholder' => 'Publicar unha resposta',
	'forum-thread-reply-post' => 'Responder',
	'forum-thread-deleted-return-to' => 'Volver ao taboleiro "$1"',
	'forum-sorting-option-newest-replies' => 'Respostas máis recentes',
	'forum-sorting-option-popular-threads' => 'Máis populares',
	'forum-sorting-option-most-replies' => 'Máis activos nos últimos 7 días',
	'forum-sorting-option-newest-threads' => 'Fíos máis novos',
	'forum-sorting-option-oldest-threads' => 'Fíos máis vellos',
	'forum-discussion-post' => 'Publicar',
	'forum-discussion-highlight' => 'Destacar este debate',
	'forum-discussion-placeholder-title' => 'Sobre que quere falar?',
	'forum-discussion-placeholder-message' => 'Publicar unha nova mensaxe no taboleiro "$1"',
	'forum-discussion-placeholder-message-short' => 'Publicar unha nova mensaxe',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|respondeu}} ao seu fío no taboleiro "$3"',
	'forum-notification-user2-reply-to-your' => '$1 e $2 responderon ao seu fío no taboleiro "$3"',
	'forum-notification-user3-reply-to-your' => '$1 e outras persoas responderon ao seu fío no taboleiro "$3"',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|respondeu}} no taboleiro "$3"',
	'forum-notification-user2-reply-to-someone' => '$1 e $2 responderon no taboleiro "$3"',
	'forum-notification-user3-reply-to-someone' => '$1 e outras persoas responderon no taboleiro "$3"',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|deixou}} unha nova mensaxe no taboleiro "$2"',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME escribiu un novo fío no taboleiro "$BOARDNAME" de $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME escribiu un novo fío no taboleiro "$BOARDNAME" de $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME respondeu ao seu fío no taboleiro "$BOARDNAME" de $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME respondeu no taboleiro "$BOARDNAME" de $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME respondeu no taboleiro "$BOARDNAME" de $WIKI',
	'forum-mail-notification-html-greeting' => 'Boas, $1:',
	'forum-mail-notification-html-button' => 'Ver a conversa',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Boas $WATCHER:

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Ollar a conversa: ($MESSAGE_LINK)

O equipo de Wikia

___________________________________________
* Atope axuda e consellos na central da comunidade: http://community.wikia.com
* Quere recibir menos mensaxes nosas? Pode cancelar a subscrición ou cambiar
as preferencias de correo electrónico aquí: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Boas $WATCHER:
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Ollar a conversa</a></p>
<p>O equipo de Wikia</p>
___________________________________________<br />
* Atope axuda e consellos na central da comunidade: http://community.wikia.com
* Quere recibir menos mensaxes nosas? Pode cancelar a subscrición ou cambiar
as preferencias de correo electrónico aquí: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'en "$1"',
	'forum-wiki-activity-msg-name' => 'taboleiro "$1"',
	'forum-activity-module-heading' => 'Actividade do foro',
	'forum-related-module-heading' => 'Fíos relacionados',
	'forum-activity-module-posted' => '$1 publicou unha resposta $2',
	'forum-activity-module-started' => '$1 empezou unha conversa $2',
	'forum-contributions-line' => '[[$1|$2]] no [[$3|taboleiro "$4"]]',
	'forum-recentchanges-new-message' => 'no [[$1|taboleiro "$2"]]',
	'forum-recentchanges-edit' => 'mensaxe editada',
	'forum-recentchanges-removed-thread' => 'eliminou o fío "[[$1|$2]]" do [[$3|taboleiro "$4"]]',
	'forum-recentchanges-removed-reply' => 'eliminou a resposta "[[$1|$2]]" do [[$3|taboleiro "$4"]]',
	'forum-recentchanges-restored-thread' => 'restaurou o fío "[[$1|$2]]" no [[$3|taboleiro "$4"]]',
	'forum-recentchanges-restored-reply' => 'restaurou a resposta "[[$1|$2]]" no [[$3|taboleiro "$4"]]',
	'forum-recentchanges-deleted-thread' => 'borrou o fío "[[$1|$2]]" do [[$3|taboleiro "$4"]]',
	'forum-recentchanges-deleted-reply' => 'borrou a resposta "[[$1|$2]]" do [[$3|taboleiro "$4"]]',
	'forum-recentchanges-deleted-reply-title' => 'Unha publicación',
	'forum-recentchanges-namespace-selector-message-wall' => 'Taboleiro do foro',
	'forum-recentchanges-thread-group' => '"$1" no [[$2|taboleiro "$3"]]',
	'forum-recentchanges-history-link' => 'historial do taboleiro',
	'forum-recentchanges-thread-history-link' => 'historial do fío',
	'forum-recentchanges-closed-thread' => 'pechou o fío "[[$1|$2]]" de [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'reabriu o fío "[[$1|$2]]" de [[$3|$4]]',
	'forum-board-history-title' => 'historial do taboleiro',
	'forum-specialpage-oldforum-link' => 'Arquivos antigos do foro',
	'forum-admin-page-breadcrumb' => 'Panel de administración dos taboleiros',
	'forum-admin-create-new-board-label' => 'Crear un novo taboleiro',
	'forum-admin-create-new-board-modal-heading' => 'Crear un novo taboleiro',
	'forum-admin-create-new-board-title' => 'Título do taboleiro',
	'forum-admin-create-new-board-description' => 'Descrición do taboleiro',
	'forum-admin-edit-board-modal-heading' => 'Editar o taboleiro: $1',
	'forum-admin-edit-board-title' => 'Título do taboleiro',
	'forum-admin-edit-board-description' => 'Descrición do taboleiro',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Borrar o taboleiro: $1',
	'forum-admin-delete-board-title' => 'Escriba o nome do taboleiro que quere borrar para confirmar:',
	'forum-admin-merge-board-warning' => 'Os fíos deste taboleiro han fusionarse cun taboleiro existente.',
	'forum-admin-merge-board-destination' => 'Seleccione o taboleiro co que fusionar:',
	'forum-admin-delete-and-merge-button-label' => 'Borrar e fusionar',
	'forum-admin-link-label' => 'Administrar os taboleiros',
	'forum-autoboard-title-1' => 'Conversa xeral',
	'forum-autoboard-body-1' => 'Este taboleiro é para conversas xerais sobre o wiki.',
	'forum-autoboard-title-2' => 'Noticias e anuncios',
	'forum-autoboard-body-2' => 'Últimas noticias e informacións!',
	'forum-autoboard-title-3' => 'Novo en $1',
	'forum-autoboard-body-3' => 'Quere compartir algo que se publicou recentemente no wiki ou darlle os parabéns a alguén por unha contribución extraordinaria. Este é o lugar!',
	'forum-autoboard-title-4' => 'Preguntas e respostas',
	'forum-autoboard-body-4' => 'Ten algunha dúbida sobre o wiki ou sobre o tema? Formule aquí as súas preguntas!',
	'forum-autoboard-title-5' => 'Xogos e diversión',
	'forum-autoboard-body-5' => 'Este taboleiro é para conversas varias. Un lugar para botar un anaco cos seus amigos de $1.',
	'forum-board-destination-empty' => '(Seleccione un taboleiro)',
	'forum-board-title-validation-invalid' => 'O nome do taboleiro contén caracteres non válidos',
	'forum-board-title-validation-length' => 'O nome do taboleiro debe ter, polo menos, 4 caracteres',
	'forum-board-title-validation-exists' => 'Xa existe un taboleiro co mesmo nome',
	'forum-board-validation-count' => 'O número máximo de taboleiros é $1',
	'forum-board-description-validation-length' => 'Escribe unha descrición para este taboleiro',
	'forum-board-id-validation-missing' => 'Falta o identificador do taboleiro',
	'forum-board-no-board-warning' => 'Non puidemos atopar un taboleiro con ese título. Aquí está a lista de taboleiros.',
	'forum-old-notification-message' => 'Este foro foi arquivado',
	'forum-old-notification-navigation-button' => 'Visitar o novo foro',
	'forum-related-discussion-heading' => 'Conversas sobre "$1"',
	'forum-related-discussion-new-post-button' => 'Comezar un debate',
	'forum-related-discussion-new-post-tooltip' => 'Comezar un novo debate sobre "$1"',
	'forum-related-discussion-total-replies' => '$1 mensaxes',
	'forum-related-discussion-see-more' => 'Ver máis debates',
	'forum-confirmation-board-deleted' => 'Borrouse "$1".',
	'forum-token-mismatch' => 'Vaites! O pase non coincide',
];

/** Hebrew (עברית)
 * @author Guycn2
 * @author LaG roiL
 */
$messages['he'] = [
	'forum-forum-title' => 'פורום',
	'forum-specialpage-heading' => 'פורום',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|נושא אחד|נושאים}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|פוסט אחד|פוסטים}}',
	'forum-specialpage-board-lastpostby' => 'הודעה אחרונה',
	'forum-specialpage-policies-edit' => 'עריכה',
	'forum-specialpage-policies' => 'מדיניות / שאלות ותשובות',
	'forum-board-topic-title' => 'דיונים על $1',
	'forum-board-topics' => 'נושאים',
	'forum-board-thread-follow' => 'מעקב',
	'forum-board-thread-following' => 'הפסקת מעקב',
	'forum-board-thread-kudos' => '$1 {{PLURAL:תודה אחת|תודות}}',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|הודעה אחת|הודעות}}',
	'forum-board-new-message-heading' => 'פתיחת דיון חדש',
	'forum-thread-reply-placeholder' => '{{GENDER:הגב|הגיבי}}',
	'forum-thread-reply-post' => '{{GENDER:הגב|הגיבי}}',
	'forum-discussion-placeholder-message-short' => 'פרסום הודעה חדשה',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|הגיב|הגיבה}} לנושא בפורום $3',
	'forum-notification-user2-reply-to-your' => '$1 ו$2 הגיבו לנושא בפורום $3',
	'forum-notification-user3-reply-to-your' => '$1 ואחרים הגיבו לנושא בפורום $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|הגיב|הגיבה}} בפורום $3',
	'forum-notification-user2-reply-to-someone' => '$1 ו$2 הגיבו בפורום $3',
	'forum-notification-user3-reply-to-someone' => '$1 ואחרים הגיבו בפורום $3',
	'forum-mail-notification-html-greeting' => 'שלום, $1.',
	'forum-recentchanges-thread-group' => '$1 ב[[$2|לוח של $3]]',
	'forum-confirmation-board-deleted' => '"$1" נמחק.',
];

/** Hungarian (magyar)
 * @author TK-999
 * @author Tacsipacsi
 */
$messages['hu'] = [
	'forum-forum-title' => 'Fórum',
	'forum-active-threads' => '$1 aktív beszélgetés',
	'forum-active-threads-on-topic' => "$1 aktív beszélgetés erről a témáról: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>beszélgetésfolyam<br />ezen a fórumon</span>',
	'forum-header-active-threads' => '<em>$1</em><span>aktív<br />beszélgetés</span>',
	'forum-specialpage-heading' => 'Fórum',
	'forum-specialpage-board-threads' => '$1 beszélgetésfolyam',
	'forum-specialpage-board-posts' => '$1 hozzászólás',
	'forum-specialpage-board-lastpostby' => 'Utoljára hozzászólt:',
	'forum-specialpage-policies-edit' => 'Szerkesztés',
	'forum-specialpage-policies' => 'A fórum szabályai / GYIK',
];

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 * @author Fate Kage
 */
$messages['id'] = [
	'forum-forum-title' => 'Forum',
	'forum-specialpage-board-lastpostby' => 'Postingan terakhir oleh',
	'forum-specialpage-policies-edit' => 'Sunting',
	'forum-specialpage-policies' => 'Kebijakan Forum / FAQ',
	'forum-policies-and-faq' => "==Kebijakan forum==
Sebelum berkontribusi ke Forum {{SITENAME}}, harap diingat beberapa praktek terbaik untuk dilakukan:

'''Bersikap baik dan memperlakukan orang dengan hormat.'''
:Orang-orang dari seluruh dunia membaca dan mengedit di wiki ini dan forumnya. Seperti proyek kolaborasi lainnya, tidak semua orang akan setuju sepanjang waktu. Jauhkan diskusi sipil dan berpikiran terbuka tentang perbedaan pendapat. Kita semua di sini karena kita mencintai topik yang sama.

'''Cobalah untuk menemukan diskusi yang ada pertama, tapi jangan takut untuk memulai lembaran baru.'''
:Silakan luangkan waktu menyaring melalui papan forum {{SITENAME}} untuk melihat apakah diskusi sudah ada tentang sesuatu yang Anda ingin bicarakan. Jika Anda tidak dapat menemukan apa yang Anda cari, melompatlah dan memulai diskusi baru!

'''Minta bantuan.'''
:Menemukan sesuatu yang tidak benar? Atau apakah Anda memiliki pertanyaan? MMintalah bantuan di sini di forum! Jika Anda membutuhkan bantuan dari staf Wikia, silakan menuju pada [[w:c:community|Pusat Komunitas]] atau melalui [[Special:Contact]].

'''Selamat bersenang-senang!'''
:Komunitas {{SITENAME}} senang untuk memiliki Anda di sini. Kami berharap dapat melihat Anda di sekitar seperti yang kita bahas pada topik ini kita semua saling mencintai.

==Forum FAQ==
'''Bagaimana saya tetap di atas diskusi yang menarik bagi saya?'''
:Dengan akun pengguna Wikia, Anda dapat mengikuti percakapan tertentu dan kemudian menerima pesan pemberitahuan (baik di tempat atau melalui surel) saat diskusi memiliki lebih banyak aktivitas. Pastikan untuk [[Special:UserSignup|mendaftar akun Wikia]] jika Anda belum memilikinya.

'''Bagaimana cara menghapus vandalisme?'''
:Jika Anda melihat beberapa spam atau vandalisme pada lembar diskusi, bawa tetikus Anda ke teks yang bermasalah. Anda akan melihat \"Lebih\" tombol yang muncul. Di dalam menu \"Lebih\", Anda akan menemukan \"Hapus\". Ini akan memungkinkan Anda untuk menghapus vandalisme dan lebih disarankan menginformasikan admin.

'''Apa itu Pujian?'''
:Jika Anda menemukan diskusi tertentu atau ingin membalas menarik, dipikirkan dengan baik, atau menghibur Anda dapat menunjukkan penghargaan langsung dengan memberikan Pujian. Mereka dapat membantu dalam situasi pemungutan suara juga.

'''Apa itu Topik?'''
:Topik memungkinkan Anda untuk menghubungkan diskusi forum dengan artikel wiki. Ini cara lain untuk menjaga Forum terorganisir dan membantu orang menemukan diskusi yang menarik. Sebagai contoh, sebuah lembar dengan lebel \"Lord Voldemort\" akan muncul di bagian bawah artikel \"Lord Voldemort\".",
	'forum-board-topics' => 'Topik-topik',
	'forum-board-thread-follow' => 'Ikuti',
	'forum-board-thread-following' => 'Mengikuti',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-new-message-heading' => 'Mulai Diskusi',
	'forum-no-board-selection-error' => '← Silakan pilih dinding untuk posting ke',
	'forum-thread-reply-placeholder' => 'Kirimkan balasan',
	'forum-thread-reply-post' => 'Balas',
	'forum-sorting-option-newest-replies' => 'Balasan Terbaru',
	'forum-sorting-option-popular-threads' => 'Paling Populer',
	'forum-sorting-option-most-replies' => 'Paling Aktif dalam 7 Hari',
	'forum-sorting-option-newest-threads' => 'Lembar Terbaru',
	'forum-sorting-option-oldest-threads' => 'Lembar Terlama',
	'forum-discussion-post' => 'Kirim',
	'forum-discussion-highlight' => 'Sorot diskusi ini',
	'forum-discussion-placeholder-title' => 'Apa yang Anda ingin bicarakan?',
	'forum-discussion-placeholder-message' => 'Mengirim pesan baru ke dinding $1',
	'forum-discussion-placeholder-message-short' => 'Kirim pesan baru',
	'forum-activity-module-heading' => 'Aktivitas Forum',
	'forum-related-module-heading' => 'Lembar Terkait',
	'forum-related-discussion-new-post-button' => 'Mulai Diskusi',
	'forum-related-discussion-new-post-tooltip' => 'Mulai diskusi baru tentang $1',
];

/** Italian (italiano)
 * @author Gloria sah
 */
$messages['it'] = [
	'forum-forum-title' => 'Forum',
	'forum-specialpage-heading' => 'Forum',
];

/** Japanese (日本語)
 * @author BryghtShadow
 * @author Tommy6
 */
$messages['ja'] = [
	'forum-forum-title' => 'フォーラム',
	'forum-active-threads' => '$1 件のスレッドがアクティブです',
	'forum-active-threads-on-topic' => "'''[[$2]]'''を話題にしてるスレッドでアクティブなものは $1 件です",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|件}}のスレッドが<br />このフォーラムにあります</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|件}}のスレッドが<br />アクティブです</span>',
	'forum-specialpage-heading' => 'フォーラム',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading こちらを編集できます</span>',
	'forum-specialpage-board-threads' => '$1 件のスレッドに',
	'forum-specialpage-board-posts' => '$1 件の投稿があります',
	'forum-specialpage-board-lastpostby' => '最終投稿者:',
	'forum-specialpage-policies-edit' => '編集',
	'forum-specialpage-policies' => 'フォーラムポリシー / FAQ',
	'forum-policies-and-faq' => "== フォーラムポリシー ==
{{SITENAME}} フォーラムに投稿するにあたり、以下のことに留意してください:

'''敬意を持ち、親切かつ丁寧に他者に対応しましょう。'''
:様々な世界の人がこのウィキアやフォーラムを閲覧、編集します。人々が協力し合って作り上げる形式の他のプロジェクト同様、全ての参加者の意見が常に一致するわけではありません。礼儀正しい議論を忘れず、異なる意見を受け入れる柔軟性を持ちましょう。ここにいる参加者は皆、同じ話題に興味があって集まっているということを忘れないでください。

'''新しいスレッドを作ることを恐れる必要はありません。しかし、その前にまずは既存のスレッドを探してみましょう。'''
:あなたが投稿したい話題について、既に同様のスレッドが存在しないか、まずはフォーラムの各板内を探してみてください。見つからなかった時には、どうぞ遠慮なくスレッドを作成してください。

'''助けを求める。'''
:何かおかしなことに気が付いたとき、疑問があるときには、遠慮なくフォーラムに投稿し助けを求めましょう。ウィキアスタッフによる支援が必要な時は、[[w:c:community|コミュニティー・セントラル]]か[[Special:Contact]]に連絡してください。

'''楽しみましょう。'''
:{{SITENAME}}へようこそ。同じ話題に興味を持った者同士として、あなたと語り合えること楽しみに待っています。

== フォーラムFAQ ==
'''興味を持った話題の最新情報を常に知るにはどうすればいいですか？'''
:ウィキアのアカウントを作成すると、特定のスレッドをフォローし、そのスレッドに何か動きがあった時に通知を受け取る（サイト上での通知もしくはEメールによる通知のいずれでも）ことができるようになります。ウィキアのアカウントをまだ作成していないのであれば、[[Special:UserSignup|この機会にぜひ作成してください]]。

'''荒らしを排除するにはどうすればいいですか？'''
:スレッド上でスパムや荒らしを見かけた際には、その投稿にマウスカーソルをかざしてください。すると、「その他」ボタンが表示されます。「その他」をクリックして表示されるメニューから「除去」を選択すると、荒らしをスレッドから除去し必要であれば管理者に知らせることができます。

'''「いいね」ってなんですか？'''
:興味深い、おもしろい、よく考えられている、といったスレッドや返信を見かけた時には、「いいね」を押すことでそのスレッドや返信を直接評価できます。また、投票機能代わりにも利用できます。

'''タグってなんですか？'''
:タグを使用すると、フォーラムのスレッドとウィキの記事をつなげることができます。またこの機能は、フォーラムを体系化し、閲覧者が興味のあるスレッドを探す手助けとなるものです。例えば、フォーラムのスレッドに「ヴェネチア」というタグをつけると、「ヴェネチア」という名称の記事の下部にそのスレッドが表示されます。",
	'forum-board-title' => '$1板',
	'forum-board-topic-title' => '$1 に関連するスレッド',
	'forum-board-topics' => 'タグ',
	'forum-board-thread-follow' => 'フォローする',
	'forum-board-thread-following' => 'フォロー中',
	'forum-board-thread-kudos' => '$1 いいね',
	'forum-board-thread-replies' => '$1 件の返信',
	'forum-board-new-message-heading' => 'スレッドを作成',
	'forum-no-board-selection-error' => '← 投稿する板を選択してください',
	'forum-thread-reply-placeholder' => '返信を投稿',
	'forum-thread-reply-post' => '返信',
	'forum-thread-deleted-return-to' => '$1板に戻る',
	'forum-sorting-option-newest-replies' => '新しい返信のついたスレッドから表示',
	'forum-sorting-option-popular-threads' => '人気のスレッドから表示',
	'forum-sorting-option-most-replies' => '最近7日間でアクティブなものから表示',
	'forum-sorting-option-newest-threads' => '新しいスレッドから表示',
	'forum-sorting-option-oldest-threads' => '古いスレッドから表示',
	'forum-discussion-post' => '投稿',
	'forum-discussion-highlight' => 'このスレッドをハイライトする',
	'forum-discussion-placeholder-title' => 'スレッドタイトルを入力',
	'forum-discussion-placeholder-message' => '$1板に投稿するメッセージを入力',
	'forum-discussion-placeholder-message-short' => '投稿するメッセージを入力',
	'forum-notification-user1-reply-to-your' => '$1 が $3板 であなたが作成したスレッドに返信を{{GENDER:$1|投稿}}しました',
	'forum-notification-user2-reply-to-your' => '$1 と $2 が $3板 であなたが作成したスレッドに返信を投稿しました',
	'forum-notification-user3-reply-to-your' => '$1 とその他複数が $3 であなたが作成したスレッドに返信を投稿しました',
	'forum-notification-user1-reply-to-someone' => '$1 が $3板 で返信を{{GENDER:$1|投稿}}しました',
	'forum-notification-user2-reply-to-someone' => '$1 と $2 が $3板 で返信を投稿しました',
	'forum-notification-user3-reply-to-someone' => '$1 とその他複数が $3 で返信を投稿しました',
	'forum-notification-newmsg-on-followed-wall' => '$1 が $2板 で新しいスレッドを{{GENDER:$1|作成}}しました',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME が $WIKI の $BOARDNAME板 で新しいスレッドを作成しました。',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME が $WIKI の $BOARDNAME板 で新しいスレッドを作成しました。',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME が $WIKI の $BOARDNAME板で あなたが作成したスレッドに返信を投稿しました。',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME が $WIKI の $BOARDNAME板 で返信を投稿しました。',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME が $WIKI の $BOARDNAME板 で返信を投稿しました。',
	'forum-mail-notification-html-greeting' => '$1 さん、',
	'forum-mail-notification-html-button' => 'スレッドを見る',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => '$WATCHER さん、

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

スレッドを見る: ($MESSAGE_LINK)

ウィキア
___________________________________________
* ウィキアの最新情報は ja.community.wikia.com で確認できます。
* メールの受信に関する設定は以下のページで行えます: http://ja.community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => '$WATCHER さん、
<p>$SUBJECT</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">スレッドを見る</a></p>
<p>ウィキア</p>
___________________________________________<br />
* ウィキアの最新情報は ja.community.wikia.com で確認できます。<br />
* メールの受信に関する設定は以下のページで行えます: http://ja.community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => '-- $1',
	'forum-wiki-activity-msg-name' => '$1板',
	'forum-activity-module-heading' => 'フォーラムアクティビティ',
	'forum-related-module-heading' => '関連スレッド',
	'forum-activity-module-posted' => '$1 による返信の投稿: $2',
	'forum-activity-module-started' => '$1 によるスレッドの作成: $2',
	'forum-contributions-line' => '[[$1|$2]] -- [[$3|$4板]]',
	'forum-recentchanges-new-message' => '-- [[$1|$2板]]',
	'forum-recentchanges-edit' => 'メッセージを編集',
	'forum-recentchanges-removed-thread' => 'が[[$3|$4板]]からスレッド「[[$1|$2]]」を除去しました',
	'forum-recentchanges-removed-reply' => 'が[[$3|$4板]]のスレッド「[[$1|$2]]」から返信を除去しました',
	'forum-recentchanges-restored-thread' => 'が[[$3|$4板]]にスレッド「[[$1|$2]]」を復帰しました',
	'forum-recentchanges-restored-reply' => 'が[[$3|$4板]]のスレッド「[[$1|$2]]」に返信を復帰しました',
	'forum-recentchanges-deleted-thread' => 'が[[$3|$4板]]からスレッド「[[$1|$2]]」を削除しました',
	'forum-recentchanges-deleted-reply' => 'が[[$3|$4板]]のスレッド「[[$1|$2]]」から返信を削除しました',
	'forum-recentchanges-deleted-reply-title' => '投稿',
	'forum-recentchanges-namespace-selector-message-wall' => 'フォーラムの板',
	'forum-recentchanges-thread-group' => '$1 -- [[$2|$3板]]',
	'forum-recentchanges-history-link' => '板の履歴',
	'forum-recentchanges-thread-history-link' => 'スレッドの履歴',
	'forum-recentchanges-closed-thread' => 'が[[$3|$4板]]のスレッド「[[$1|$2]]」を閉じました',
	'forum-recentchanges-reopened-thread' => 'が[[$3|$4板]]のスレッド「[[$1|$2]]」を再開しました',
	'forum-board-history-title' => '板の履歴',
	'forum-specialpage-oldforum-link' => '旧フォーラムのアーカイブ',
	'forum-admin-page-breadcrumb' => '管理者用板管理ページ',
	'forum-admin-create-new-board-label' => '新しい板を作成',
	'forum-admin-create-new-board-modal-heading' => '新しい板を作成',
	'forum-admin-create-new-board-title' => '板名',
	'forum-admin-create-new-board-description' => '板の概要',
	'forum-admin-edit-board-modal-heading' => '板を編集: $1',
	'forum-admin-edit-board-title' => '板名',
	'forum-admin-edit-board-description' => '板の概要',
	'forum-admin-delete-and-merge-board-modal-heading' => '板を削除: $1',
	'forum-admin-delete-board-title' => '確認のため、削除する板の名称を入力してください:',
	'forum-admin-merge-board-warning' => '板内のスレッドは既存の板に統合されます。',
	'forum-admin-merge-board-destination' => '統合先の板を選択:',
	'forum-admin-delete-and-merge-button-label' => '削除および統合',
	'forum-admin-link-label' => '板の管理',
	'forum-autoboard-title-1' => '総合',
	'forum-autoboard-body-1' => 'この板では、このウィキアに関する話題全般を取り扱います。',
	'forum-autoboard-title-2' => 'ニュースとお知らせ',
	'forum-autoboard-body-2' => 'サイトに関するニュースとお知らせ',
	'forum-autoboard-title-3' => '$1の最新投稿紹介',
	'forum-autoboard-body-3' => '最近行われた投稿やすぐれた投稿をするユーザを紹介したいときはこちらへ。',
	'forum-autoboard-title-4' => '質問と回答',
	'forum-autoboard-body-4' => 'このサイトやサイトのテーマに関する質問はこちら。',
	'forum-autoboard-title-5' => '雑談',
	'forum-autoboard-body-5' => 'サイトのテーマから外れる話題はこちらへ。$1のユーザ同士の交流にどうぞ。',
	'forum-board-destination-empty' => '（板を選択）',
	'forum-board-title-validation-invalid' => '板名に不適切な文字が含まれています',
	'forum-board-title-validation-length' => '板名は4文字以上にしてください',
	'forum-board-title-validation-exists' => '同名の板が既に存在します',
	'forum-board-validation-count' => '板の最大数は $1 です',
	'forum-board-description-validation-length' => 'この板の概要を入力してください',
	'forum-board-id-validation-missing' => '板IDが見つかりません',
	'forum-board-no-board-warning' => '指定された名称の板は見つかりませんでした。板の一覧を表示します。',
	'forum-old-notification-message' => 'こちらは旧フォーラムのアーカイブです',
	'forum-old-notification-navigation-button' => '新しいフォーラムにアクセスする',
	'forum-related-discussion-heading' => '$1 に関連するスレッド',
	'forum-related-discussion-new-post-button' => 'スレッドを作成',
	'forum-related-discussion-new-post-tooltip' => '$1 に関するスレッドを作成',
	'forum-related-discussion-total-replies' => '$1 件の投稿',
	'forum-related-discussion-see-more' => 'さらにスレッドを見る',
	'forum-confirmation-board-deleted' => '「$1」を削除しました。',
	'forum-token-mismatch' => 'おっと! トークンが一致しません',
];

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = [
	'forum-specialpage-policies-edit' => 'ಸಂಪಾದಿಸಿ',
	'forum-thread-reply-post' => 'ಉತ್ತರಿಸಿ',
];

/** Korean (한국어)
 * @author Miri-Nae
 * @author 관인생략
 * @author 아라
 */
$messages['ko'] = [
	'forum-desc' => '위키아 특수기능:포럼 확장 기능',
	'forum-disabled-desc' => '위키아 특수기능:포럼 확장 기능; 비활성',
	'forum-forum-title' => '포럼',
	'forum-active-threads' => '활성화된 토론 $1개',
	'forum-active-threads-on-topic' => "다음 주제에 대한 활발한 토론 $1개: '''[[$2]]'''",
	'forum-header-total-threads' => '이 포럼에는 <em>$1</em>개의<br />토론이 있습니다',
	'forum-header-active-threads' => '활발한 토론 <em>$1</em>개가<br />있습니다',
	'forum-specialpage-heading' => '포럼',
	'forum-specialpage-board-threads' => '토론 $1개',
	'forum-specialpage-board-posts' => '글 $1개',
	'forum-specialpage-board-lastpostby' => '마지막 글 작성:',
	'forum-specialpage-policies-edit' => '편집',
	'forum-specialpage-policies' => '포럼 정책 및 FAQ',
	'forum-policies-and-faq' => "==포럼 운영 정책==
{{SITENAME}} 포럼에 참여하시기 전에 다음 사항들에 주의해주세요.

'''토론에 참여하는 다른 사용자들을 존중해주세요.'''
:불특정 다수가 이 위키의 내용을 보고 기여하며 토론에 참여합니다. 여느 협업 프로젝트가 그렇듯이 모든 사람이 늘 한 의견에 동의하지는 않습니다. 항상 열린 마음으로 냉정하게 토론에 임해주시기 바랍니다. 이 위키에 기여해주시는 사용자 분들은 모두 한 주제에 대해 열정을 가지고 계시기 때문에 모였습니다.

'''이미 진행중인 토론이 있다면 새 주제가 아니라 그 곳에서 토론에 참여해주세요. 토론 주제가 아직 만들어지지 않았다면 새 주제를 만들어주시면 됩니다.'''
:새 토론을 시작하기 전에 {{SITENAME}} 포럼에 이미 존재하는 토론이 있는지 살펴봐주세요. 이미 진행중인 토론이 있다면 그 곳에 참여하는 것이 여러 사람들의 의견을 하나로 모으기에 더 좋습니다. 만약 찾는 토론이 없다면 바로 새 주제를 시작해주시면 됩니다.

'''도움이 필요하다면 도움을 요청하세요.'''
:질문이 있으시거나 뭔가 올바르지 않은 상황을 목격하셨나요? 포럼에서 다른 사용자에게 도움을 요청하세요! 만약 위키아 스탭의 도움이 필요한 경우 문의 양식을 통해 도움을 요청할 수 있습니다.

'''즐기세요!'''
:{{SITENAME}} 포럼에서 선호하는 주제를 공유하는 사람들과 즐거운 시간 보내시기 바랍니다!

==포럼에 대해 자주 묻는 질문==
'''관심 있는 주제를 주시하려면 어떻게 해야 하나요?'''
:위키아에 계정이 있다면 주제를 '주시'해서 해당 주제의 변경점을 이메일이나 사이트에서 바로 알림받을 수 있습니다.

'''문서 훼손 행위를 되돌리려면 어떻게 해야 하나요?'''
:포럼 글에 스팸 등의 문서 훼손 행위를 목격하셨다면 해당 글에 마우스를 올린 후에 나타나는 '도구' 버튼을 눌러주세요. '도구' 버튼을 누른 후에 나타나는 메뉴에서 '숨기기' 메뉴를 선택하시면 문서 훼손 행위를 없앨 수 있고 추가적으로 관리자에게 알릴 수도 있습니다.

'''추천 기능에 대해 알려주세요.'''
:흥미로운 주제나 질 좋은 답글이 있다면 '추천' 버튼을 눌러 다른 사용자들에게 추천할 수 있습니다.

'''태그 기능에 대해 알려주세요.'''
:위키 내의 특정한 문서에 대하여 토론하고 있다면 해당 글을 토론 주제에 '태그'할 수 있습니다. 이렇게 태그한 토론 주제들은 해당 문서 아래에 보여지게 되며 다른 사용자들이 참여하기에 용이하게 해주고 포럼을 좀 더 조직적으로 관리할 수 있도록 해줍니다. 예를 들어 '볼드모트 경'을 토론 주제에 태그한다면 해당 글은 '볼드모트 경' 문서 아래에 보여지게 됩니다.", # Fuzzy
	'forum-board-title' => '$1 게시판',
	'forum-board-topic-title' => '$1에 대한 토론',
	'forum-board-topics' => '주제',
	'forum-board-thread-follow' => '주시하기',
	'forum-board-thread-following' => '주시 중',
	'forum-board-thread-kudos' => '추천 $1개',
	'forum-board-thread-replies' => '댓글 $1개',
	'forum-board-new-message-heading' => '토론 시작하기',
	'forum-no-board-selection-error' => '← 글을 작성할 게시판을 선택해주세요.',
	'forum-thread-reply-placeholder' => '댓글 달기',
	'forum-thread-reply-post' => '댓글',
	'forum-thread-deleted-return-to' => '$1 게시판으로 돌아가기',
	'forum-sorting-option-newest-replies' => '가장 최근 댓글',
	'forum-sorting-option-popular-threads' => '인기순',
	'forum-sorting-option-most-replies' => '최근 7일 댓글순',
	'forum-sorting-option-newest-threads' => '최근 스레드',
	'forum-sorting-option-oldest-threads' => '오래된 스레드',
	'forum-discussion-post' => '게시물',
	'forum-discussion-highlight' => '이 토론 강조하기',
	'forum-discussion-placeholder-title' => '무엇에 대해 얘기하고 싶나요?',
	'forum-discussion-placeholder-message' => '$1 게시판에 새 글을 작성합니다',
	'forum-discussion-placeholder-message-short' => '새로운 메시지를 작성합니다',
	'forum-notification-user1-reply-to-your' => '$1님이 $3 게시판에 있는 당신의 토론에 덧글을 남겼습니다.',
	'forum-notification-user2-reply-to-your' => '$1님과 $2님이 $3 게시판에 있는 당신의 토론에 덧글을 남겼습니다.',
	'forum-notification-user3-reply-to-your' => '$1님과 다른 사용자들이 $3 게시판에 있는 당신의 토론에 덧글을 남겼습니다',
	'forum-notification-user1-reply-to-someone' => '$1님이 $3 게시판에 덧글을 {{GENDER:$1|남겼습니다}}.',
	'forum-notification-user2-reply-to-someone' => '$1님과 $2님이 $3 게시판에 덧글을 남겼습니다',
	'forum-notification-user3-reply-to-someone' => '$1님과 다른 사용자들이 $3 게시판에 덧글을 남겼습니다',
	'forum-notification-newmsg-on-followed-wall' => '$1 사용자가 $2 게시판에 새 메시지를 남겼습니다',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME 사용자가 $WIKI의 $BOARDNAME 게시판에 새 토론을 작성했습니다.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME 사용자가 $WIKI의 $BOARDNAME 게시판에 새 토론을 작성했습니다.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME님이 당신이 $WIKI의 $BOARDNAME 게시판에 작성한 토론에 덧글을 남겼습니다',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME님이 $WIKI의 $BOARDNAME 게시판에 덧글을 남겼습니다',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME님이 $WIKI의 $BOARDNAME 게시판에 덧글을 남겼습니다',
	'forum-mail-notification-html-greeting' => '안녕하세요, $1 사용자 님?',
	'forum-mail-notification-html-button' => '대화 내역 보기',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => '안녕하세요, $WATCHER 사용자 님?

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

대화를 확인하세요: ($MESSAGE_LINK)

위키아 팀

___________________________________________
* 중앙 커뮤니티에서 도움을 구하세요: http://community.wikia.com
* 알림을 받고 싶지 않으신가요? 이곳에서 알림 설정을 변경할 수 있습니다: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => '안녕하세요, $WATCHER 사용자 님?
<p>$SUBJECT</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_NO_HTML</p>
<p>-- $AUTHOR</p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">대화를 확인하세요</a></p>
<p>위키아 팀</p>
___________________________________________<br />
* 중앙 커뮤니티에서 도움을 구하세요: http://community.wikia.com
* 알림을 받고 싶지 않으신가요? 이곳에서 알림 설정을 변경할 수 있습니다: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => '$1 게시판에서',
	'forum-wiki-activity-msg-name' => '$1 게시판',
	'forum-activity-module-heading' => '포럼 활동',
	'forum-related-module-heading' => '관련 토론',
	'forum-activity-module-posted' => '$1 사용자가 $2에 덧글을 남겼습니다',
	'forum-activity-module-started' => '$1 사용자가 $2에 토론을 시작했습니다',
	'forum-contributions-line' => '[[$3|$4 board]] 게시판의 [[$1|$2]]',
	'forum-recentchanges-new-message' => '[[$1|$2 게시판]]에서',
	'forum-recentchanges-edit' => '메시지 편집',
	'forum-recentchanges-removed-thread' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 토론 삭제',
	'forum-recentchanges-removed-reply' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 댓글 삭제',
	'forum-recentchanges-restored-thread' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 토론 복구',
	'forum-recentchanges-restored-reply' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 댓글 복구',
	'forum-recentchanges-deleted-thread' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 토론 삭제',
	'forum-recentchanges-deleted-reply' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 댓글 삭제',
	'forum-recentchanges-deleted-reply-title' => '글',
	'forum-recentchanges-namespace-selector-message-wall' => '포럼 게시판',
	'forum-recentchanges-thread-group' => '[[$2|$3 게시판]]의 $1',
	'forum-recentchanges-history-link' => '게시판 역사',
	'forum-recentchanges-thread-history-link' => '토론 역사',
	'forum-board-history-title' => '게시판 역사',
	'forum-specialpage-oldforum-link' => '과거 포럼 보관',
	'forum-admin-page-breadcrumb' => '관리자 게시판 관리',
	'forum-admin-create-new-board-label' => '새 게시판 만들기',
	'forum-admin-create-new-board-modal-heading' => '새 게시판 만들기',
	'forum-admin-create-new-board-title' => '게시판 이름',
	'forum-admin-create-new-board-description' => '게시판 설명',
	'forum-admin-edit-board-modal-heading' => '게시판 편집: $1',
	'forum-admin-edit-board-title' => '게시판 이름',
	'forum-admin-edit-board-description' => '게시판 설명',
	'forum-admin-delete-and-merge-board-modal-heading' => '게시판 삭제: $1',
	'forum-admin-delete-board-title' => '삭제할 게시판의 이름을 입력하면 완전히 삭제할 수 있습니다:',
	'forum-admin-merge-board-warning' => '이 게시판에 속한 주제는 다른 게시판에 병합될 것입니다.',
	'forum-admin-merge-board-destination' => '병합할 게시판을 선택해주세요:',
	'forum-admin-delete-and-merge-button-label' => '삭제 및 병합',
	'forum-admin-link-label' => '게시판 관리',
	'forum-autoboard-title-1' => '종합 토론',
	'forum-autoboard-body-1' => '이 게시판은 위키에 대한 일반적인 것들을 토론할 수 있는 게시판입니다.',
	'forum-autoboard-title-2' => '새로운 소식',
	'forum-autoboard-body-2' => '모두에게 알릴 만한 소식이 왔어요!',
	'forum-autoboard-title-3' => '$1 뉴스',
	'forum-autoboard-body-3' => '방금 올라온 게시글, 혹은 누군가의 위대한 기여를 다른 사람들에게 알리고 싶나요? 그럼 이곳으로 오세요!',
	'forum-autoboard-title-4' => '질문과 답변',
	'forum-autoboard-body-4' => '위키에 대해 궁금한 것들은 이곳에서 물어보세요!',
	'forum-autoboard-title-5' => '재밌게 놀아요',
	'forum-autoboard-body-5' => '이 게시판은 특정한 주제가 없습니다 -- $1의 친구들과 즐거운 시간을 보내세요.',
	'forum-board-destination-empty' => '(게시판을 선택해주세요)',
	'forum-board-title-validation-invalid' => '게시판 이름에 잘못된 글자가 포함되어 있습니다',
	'forum-board-title-validation-length' => '게시판 이름은 최소 네 글자 이상이어야 합니다',
	'forum-board-title-validation-exists' => '같은 이름의 게시판이 이미 존재합니다',
	'forum-board-validation-count' => '만들 수 있는 게시판 수는 $1개가 최대입니다',
	'forum-board-description-validation-length' => '게시판에 대한 설명을 입력해주세요',
	'forum-board-id-validation-missing' => '게시판 ID가 없습니다',
	'forum-board-no-board-warning' => '해당 이름의 게시판을 찾을 수 없습니다. 아래는 게시판의 목록입니다.',
	'forum-old-notification-message' => '이 포럼은 보관되었습니다',
	'forum-old-notification-navigation-button' => '새로운 포럼을 방문해보세요',
	'forum-related-discussion-heading' => '$1에 대한 토론',
	'forum-related-discussion-new-post-button' => '토론 시작하기',
	'forum-related-discussion-new-post-tooltip' => '$1에 대한 새로운 토론 시작하기',
	'forum-related-discussion-total-replies' => '메시지 $1개',
	'forum-related-discussion-see-more' => '더 많은 토론 보기',
	'forum-confirmation-board-deleted' => '"$1" 게시판이 삭제되었습니다.',
];

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 * @author George Animal
 */
$messages['ku-latn'] = [
	'forum-forum-title' => 'Forum',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-policies-edit' => 'Biguherîne',
	'forum-board-thread-follow' => 'Bişopîne',
	'forum-board-thread-following' => 'Te şopandin',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Peyam}}',
	'forum-mail-notification-html-greeting' => 'Silav $1,',
	'forum-autoboard-title-4' => 'Pirs û Bersiv',
	'forum-related-discussion-total-replies' => '$1 peyam',
	'forum-related-discussion-see-more' => 'Zêdetir gotûbêjan bibîne',
	'forum-confirmation-board-deleted' => '$1 hat jêbirin.',
];

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = [
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '{{PLURAL:$1|Eng aktiv Diskussioun|$1 aktiv Diskussiounen}}',
	'forum-active-threads-on-topic' => "{{PLURAL:$1|Eng aktiv Diskussioun|$1 aktiv Diskussiounen}} iwwer: '''[[$2]]'''",
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|Rubrik|Rubriken}}',
	'forum-specialpage-policies-edit' => 'Änneren',
	'forum-board-topic-title' => 'Diskussiounen iwwer $1',
	'forum-board-topics' => 'Themen',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Message|Messagen}}',
	'forum-board-new-message-heading' => 'Eng Diskussioun ufänken',
	'forum-thread-reply-post' => 'Äntwerten',
	'forum-sorting-option-most-replies' => 'Am aktivsten an de leschte 7 Deeg',
	'forum-mail-notification-html-greeting' => 'Salut $1,',
	'forum-mail-notification-subject' => '$1 – $2',
	'forum-activity-module-started' => '$1 huet eng Diskussioun $2 ugefaang',
	'forum-recentchanges-edit' => 'Message geännert',
	'forum-autoboard-title-1' => 'Allgemeng Diskussioun',
	'forum-autoboard-title-3' => 'Nei op $1',
	'forum-old-notification-message' => 'Dëse Forum gouf archivéiert',
	'forum-related-discussion-heading' => 'Diskussiounen iwwer $1',
	'forum-related-discussion-new-post-button' => 'Eng Diskussioun ufänken',
	'forum-related-discussion-new-post-tooltip' => 'Eng nei Diskussioun iwwer $1 ufänken',
	'forum-related-discussion-total-replies' => '$1 Messagen',
	'forum-related-discussion-see-more' => 'Kuckt méi Diskussiounen',
	'forum-confirmation-board-deleted' => '"$1" gouf geläscht.',
];

/** Northern Luri (لوری مینجایی)
 * @author Mogoeilor
 */
$messages['lrc'] = [
	'forum-specialpage-policies-edit' => 'ويرايشت',
	'forum-board-thread-follow' => 'نهاگردی',
	'forum-board-thread-following' => 'د حالت نهاگردی',
	'forum-thread-reply-post' => 'جؤاو ده ئن',
];

/** Latvian (latviešu)
 * @author Sg ghost
 */
$messages['lv'] = [
	'forum-forum-title' => 'Forums',
	'forum-specialpage-heading' => 'Forums',
	'forum-specialpage-policies' => 'Forums politika / FAQ',
	'forum-activity-module-heading' => 'Forums Aktivitātes',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forums Valdes',
	'forum-specialpage-oldforum-link' => 'Vecie forums Arhīvs',
];

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = [
	'forum-forum-title' => 'Форум',
	'forum-token-mismatch' => 'Упс! Шифрата не се совпаѓа',
];

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author SNN95
 */
$messages['ms'] = [
	'forum-desc' => 'Sambungan Special:Forum Wikia',
	'forum-disabled-desc' => 'Sambungan Special:Forum Wikia; dimatikan',
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Perbincangan yang Aktif|Perbincangan yang aktif}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Perbincangan yang Aktif|Perbincangan yang aktif}} tentang: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Kiriman<br />dalam Forum ini|Kiriman<br />dalam Forum ini}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Perbincangan<br />yang Aktif|Perbincangan<br />yang Aktif}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Anda boleh menyuntingnya<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|kiriman|kiriman}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|kiriman|kiriman}}',
	'forum-specialpage-board-lastpostby' => 'Kiriman terakhir oleh',
	'forum-specialpage-policies-edit' => 'Sunting',
	'forum-specialpage-policies' => 'Polisi Forum / FAQ',
	'forum-policies-and-faq' => "==Dasar-dasar forum==
Sebelum menyumbang kepada forum-forum {{SITENAME}}, sila ingati tatatertib kami:

'''Berbudi bahasa dan saling menghormati.'''
: Wiki ini dan forumnya dibaca dan disunting oleh orang ramai dari seluruh duni. Seperti mana-mana projek kerjasama yang lain, sudah semestinya terdapat perselisihan. Berbincanglah dengan tertib dan sentiasa membuka minda kepada pendapat yang berbeza-beza. Kita semua di sini kerana kita semua menggemari topik yang sama.

'''Cari perbincangan sedia ada dahulu, tetapi jangan segan untuk membuka perbincangan baru.'''
:Sila luangkan sedikit masa untuk meneliti papan-papan Forum {{SITENAME}} untuk memastikan sama ada sudah sedia adanya topik yang ingin anda bincangkan. Jika tidak dijumpainya, silakan membuka perbincangan baru!

'''Minta bantuan.'''
:Perasan akan sesuatu yang tak kena? Atau adakah anda ada soalan? Mintalah bantuan di forum! Jika anda memerlukan bantuan daripada kakitangan Wikia, sola hubungi kami di [[w:c:community|Community Central]] atau melalui [[Special:Contact]].

'''Berseronoklah!'''
:Komuniti {{SITENAME}} gembira menyambut kehadiran anda. Kami tidak sabar berjumpa dengan anda di mana-mana sambil membincangkan topik kesukaan kita ini.

==FAQ Forum==
'''Bagaimana untuk mengikuti perkembangan perbincangan yang saya minati?'''
: Dengan akaun pengguna Wikia, anda boleh mengikuti perbincangan tertentu serta menerima pesanan pemberitahuan (sama ada di tapak atau melalui e-mel) sesekali terdapat perkembangan baru dalam perbincangan itu. Pastikan anda [[Special:UserSignup|mendaftar untuk akaun Wikia]] jika masih belum ada.

'''Bagaimana untuk membasmi laku musnah?'''
: Jika anda terjumpa spam atau kesan laku musnah (vandalisme) pada sesebuah laman perbincangan, alihkan tetikus kepada bahan berkenaan. Anda akan melihat munculnya butang \"Lagi\". Di dalam menu \"Lagi\", anda akan mendapati \"Buang\". Ini akan membolehkan anda untuk membuang kesan laku musnah dan juga membuat pilihan untuk memaklumkan admin.

'''Apakah itu Kudos?'''
: Jika anda mendapati suatu perbincangan atau balasan yang menarik, bijak atau mencuit hati, anda boleh memujinya dengan Kudos. Ianya juga berguna dalam mengundi.

'''Apakah itu Topik?'''
: Topik membolehkan anda untuk memautkan perbincangan forum dengan rencana wiki. Inilah satu lagi cara untuk memastikan kekemasan susun atur Forum serta membantu orang mencari perbincangan menarik. Cth. pautan ke laman Forum yang berteg \"Lord Voldemort\" akan tersiar di bawah rencana \"Lord Voldemort\".",
	'forum-board-title' => 'Papan $1',
	'forum-board-topic-title' => 'Perbincangan tentang $1',
	'forum-board-topics' => 'Topik',
	'forum-board-thread-follow' => 'Ikuti',
	'forum-board-thread-following' => 'Mengikuti',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Mesej|Mesej}}',
	'forum-board-new-message-heading' => 'Mulakan sebuah Perbincangan',
	'forum-no-board-selection-error' => '← Sila pilih papan untuk mengirim',
	'forum-thread-reply-placeholder' => 'Kirimkan jawapan',
	'forum-thread-reply-post' => 'Jawapan',
	'forum-thread-deleted-return-to' => 'Kembali ke papan $1',
	'forum-sorting-option-newest-replies' => 'Jawapan Paling Terkini',
	'forum-sorting-option-popular-threads' => 'Paling Terkenal',
	'forum-sorting-option-most-replies' => 'Paling Aktif dalam 7 Hari',
	'forum-sorting-option-newest-threads' => 'Kiriman Terbaru',
	'forum-sorting-option-oldest-threads' => 'Kiriman Terdahulu',
	'forum-discussion-post' => 'Kiriman',
	'forum-discussion-highlight' => 'Mengetengahkan perbincangan ini',
	'forum-discussion-placeholder-title' => 'Apa yang anda mahu bincangkan?',
	'forum-discussion-placeholder-message' => 'Kirimkan pesanan baru kepada papan $1',
	'forum-discussion-placeholder-message-short' => 'Kirimkan pesanan baru',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|menjawab}} atas kriman anda di papan $3',
	'forum-notification-user2-reply-to-your' => '$1 dan $2 menjawab atas kiriman anda di papan $3',
	'forum-notification-user3-reply-to-your' => '$1 dan yang lain menjawab atas kiriman anda di papan $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|menjawab}} atas papan $3',
	'forum-notification-user2-reply-to-someone' => '$1 dan $2 menjawab di atas papan $3',
	'forum-notification-user3-reply-to-someone' => '$1 dan yang lain menjawab di atas papan $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|meninggalkan}} satu pesanan baru diatas papan $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME telah menulis kiriman baru di atas papan $BOARDNAME $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME telah menulis kiriman baru di atas papan $BOARDNAME $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME telah menjawab kiriman anda di atas papan $BOARDNAME $WIKI.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME telah menjawab di atas papan $BOARDNAME $WIKI.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME telah menjawab di atas papan $BOARDNAME $WIKI.',
	'forum-mail-notification-html-greeting' => 'Hai $1,',
	'forum-mail-notification-html-button' => 'Lihat perbualan',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hi $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Lihat perbualan: ($MESSAGE_LINK)

Kumpulan Wikia

___________________________________________
* Dapatkan bantuan dan nasihat di Pusat Komuniti: http://community.wikia.com
* Mahu menerima sedikit mesej daripada kami? Anda boleh berhenti melanggan atau mengubah
keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hai $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Lihat perbualan</a></p>
<p>Kumpulan Wikia</p>
___________________________________________<br />
* Dapatkan bantuan dan nasihat di Pusat Komuniti: http://community.wikia.com
* Mahu menerima sedikit mesej daripada kami? Anda boleh berhenti melanggan atau mengubah
keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'di $1',
	'forum-wiki-activity-msg-name' => 'Papan $1',
	'forum-activity-module-heading' => 'Aktiviti Forum',
	'forum-related-module-heading' => 'Kiriman yang Berkaitan',
	'forum-activity-module-posted' => '$1 telah mengirimkan jawapan $2',
	'forum-activity-module-started' => '$1 telah memulakan perbincangan $2',
	'forum-contributions-line' => '[[$1|$2]] di [[$3|papan $4]]',
	'forum-recentchanges-new-message' => 'di [[$1|Papan $2]]',
	'forum-recentchanges-edit' => 'pesanan diubah',
	'forum-recentchanges-removed-thread' => 'kiriman "[[$1|$2]]" dibuang daripada [[$3|Papan $4]]',
	'forum-recentchanges-removed-reply' => 'jawapan daripada "[[$1|$2]]" dibuang daripada [[$3|Papan $4]]',
	'forum-recentchanges-restored-thread' => 'kiriman "[[$1|$2]]" dipulihkan ke [[$3|Papan $4]]',
	'forum-recentchanges-restored-reply' => 'kiriman pada "[[$1|$2]]" dipulihkan ke [[$3|Papan $4]]',
	'forum-recentchanges-deleted-thread' => 'kiriman "[[$1|$2]]" dibuang daripada [[$3|Papan $4]]',
	'forum-recentchanges-deleted-reply' => 'jawapan daripada "[[$1|$2]]" dibuang daripada [[$3|Papan $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Satu kiriman',
	'forum-recentchanges-namespace-selector-message-wall' => 'Papan Forum',
	'forum-recentchanges-thread-group' => '$1 di [[$2|Papan $3]]',
	'forum-recentchanges-history-link' => 'sejarah papan',
	'forum-recentchanges-thread-history-link' => 'sejarah kiriman',
	'forum-recentchanges-closed-thread' => 'kiriman "[[$1|$2]]" ditutup dari [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'kiriman "[[$1|$2]]" dibuka semula dari [[$3|$4]]',
	'forum-board-history-title' => 'sejarah papan',
	'forum-specialpage-oldforum-link' => 'Arkib forum terdahulu',
	'forum-admin-page-breadcrumb' => 'Pengurusan Papan Tadbir',
	'forum-admin-create-new-board-label' => 'Cipta Papan Baru',
	'forum-admin-create-new-board-modal-heading' => 'Cipta papan baru',
	'forum-admin-create-new-board-title' => 'Tajuk Papan',
	'forum-admin-create-new-board-description' => 'Penerangan Papan',
	'forum-admin-edit-board-modal-heading' => 'Sunting Papan: $1',
	'forum-admin-edit-board-title' => 'Tajuk Papan',
	'forum-admin-edit-board-description' => 'Penerangan Papan',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Hapus Papan: $1',
	'forum-admin-delete-board-title' => 'Sila sahkan dengan menaip nama papan yang anda hendak padam:',
	'forum-admin-merge-board-warning' => 'Kiriman di papan ini akan bergabung dengan papan yang sedia ada.',
	'forum-admin-merge-board-destination' => 'Pilih papan yang mahu digabungkan:',
	'forum-admin-delete-and-merge-button-label' => 'Hapus dan Gabung',
	'forum-admin-link-label' => 'Uruskan Papan',
	'forum-autoboard-title-1' => 'Perbincangan Umum',
	'forum-autoboard-body-1' => 'Papan ini adalah untuk perbualan umum tentang wiki.',
	'forum-autoboard-title-2' => 'Berita dan Pengumuman',
	'forum-autoboard-body-2' => 'Berita dan terkini maklumat!',
	'forum-autoboard-title-3' => 'Baru pada $1',
	'forum-autoboard-body-3' => 'Ingin berkongsi sesuatu yang hanya telah dipaparkan pada wiki ini, atau mengucapkan tahniah kepada seseorang atas sumbangan yang cemerlang? Inilah tempatnya!',
	'forum-autoboard-title-4' => 'Soalan & Jawapan',
	'forum-autoboard-body-4' => 'Ada soalan tentang wiki, atau topik? Hantar soalan anda di sini!',
	'forum-autoboard-title-5' => 'Keseronokkan dan Permainan',
	'forum-autoboard-body-5' => 'Papan ini adalah untuk topik di luar perbualan -- tempat untuk lepak dengan kawan-kawan $1 anda.',
	'forum-board-destination-empty' => '(Sila pilih papan)',
	'forum-board-title-validation-invalid' => 'Nama papan mengandungi aksara yang tidak sah',
	'forum-board-title-validation-length' => 'Nama papan hendaklah sekurang-kurangnya 4 aksara panjang',
	'forum-board-title-validation-exists' => 'Papan yang mempunyai nama yang sama telah wujud',
	'forum-board-validation-count' => 'Bilangan maksimum papan sebanyak $1',
	'forum-board-description-validation-length' => 'Sila tulis penerangan bagi papan ini',
	'forum-board-id-validation-missing' => 'ID papan yang tidak wujud',
	'forum-board-no-board-warning' => 'Kami tidak boleh mencari sebuah papan dengan judul tersebut.  Berikut adalah senarai papan forum.',
	'forum-old-notification-message' => 'Forum ini telah diarkibkan',
	'forum-old-notification-navigation-button' => 'Lawati Forum baru',
	'forum-related-discussion-heading' => 'Perbincangan tentang $1',
	'forum-related-discussion-new-post-button' => 'Mulakan sebuah Perbincangan',
	'forum-related-discussion-new-post-tooltip' => 'Memulakan perbincangan baru tentang $1',
	'forum-related-discussion-total-replies' => '$1 pesanan',
	'forum-related-discussion-see-more' => 'Lihat lebih banyak perbincangan',
	'forum-confirmation-board-deleted' => '"$1" telah dihapuskan.',
	'forum-token-mismatch' => 'Eh! Token tak sepadan',
];

/** Dutch (Nederlands)
 * @author Arent
 * @author AvatarTeam
 * @author Flightmare
 * @author Siebrand
 * @author Sjoerddebruin
 * @author Southparkfan
 */
$messages['nl'] = [
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Actief overleg|Actieve overleggen}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Actief overleg|Actieve overleggen}} over: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Draad<br />in dit forum|Draden<br />in dit forum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Actieve<br />Discussie|Actieve<br />Discussies}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading U kunt het bewerken<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|draad|draden}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|bericht|berichten}}',
	'forum-specialpage-board-lastpostby' => 'Laatste bericht door',
	'forum-specialpage-policies-edit' => 'Bewerken',
	'forum-specialpage-policies' => 'Forumbeleid / FAQ',
	'forum-policies-and-faq' => "==Forumbeleid==

Houd alstublieft een aantal richtlijnen met betrekking tot gedrag in gedachten voordat u bijdraagt aan de forums van {{SITENAME}}:

'''Ben aardig tegen mensen en behandel ze respectvol.'''
: Mensen van over de hele wereld lezen en bewerken deze wiki en de bijbehorende forums. Net als in ieder project waarin wordt samengewerkt, kan niet iedereen het altijd met elkaar eens zijn. Houd overleg beleefd en sta open over andere meningen. We zijn hier allemaal omdat we om hetzelfde onderwerp geven.

'''Probeer eerst bestaand overleg te vinden, maar heb geen angst om een nieuw overleg te starten.'''
:Neem over de tijd om door de forums van {{SITENAME}} te bladeren en kijk of er al een bestaand overleg is over het onderwerp dat u wilt bespreken. Als u niets kunt vinden, begin dan een nieuw overleg!

'''Vraag om hulp.'''
:Ziet u iets dat niet klopt? Hebt u een vraag? Vraag hier op de forums om hulp! Als u hulp nodig hebt van medewerkers van Wikia, ga dan alstublieft naar [[w:c:community|Community Central]] of gebruik [[Special:Contact|de contactpagina]].

'''Veel plezier!'''
:De {{SITENAME}}-gemeenschap is blij dat u er bent. We zien u graag vaak terug bij dit onderwerp waar we allemaal om geven.

==Veel gestelde vragen over het forum ==
'''Hoe blijf ik op de hoogte over overleg waar ik in geïnteresseerd ben?'''
: Als u een Wikiagebruiker hebt, kunt u specifiek overleg volgen en meldingen krijgen (op de website zelf of via e-mail) als er wijzigingen in het overleg zijn. Zorg dat u een [[Special:UserSignup|Wikiagebruiker registreert]] als u er niet al een hebt.

'''Hoe verwijder ik vandalisme?'''
: Als u ergens spam of vandalisme ziet in een overleg, beweeg dan met de muisaanwijzer over de tekst. U ziet dan een menu \"Meer\" verschijnen. Binnen het menu \"Meer\" ziet u \"Verwijderen\" staan. Zo kunt u vandalisme verwijderen en eventueel een beheerder waarschuwen.

'''Wat zijn Kudos?'''
: Als u een overleg of een reactie interessant, weloverwogen, of amusant vindt, dan kunt u uw waardering uitspreken door er Kudos aan te geven. Dit kan ook handig zijn als er gestemd wordt.

'''Wat zijn onderwerpen?'''
: Onderwerpen maken het mogelijk dat u een overleg op het forum koppelt aan een wikipagina. Het is een andere manier om forums te organiseren en om mensen te helpen interessant overleg te vinden. Als er bijvoorbeeld een forumonderwerp  is gelabeld met \"Heer Voldemort\" verschijnt het onderaan de pagina \"Heer Voldemort\".",
	'forum-board-title' => 'Prikbord $1',
	'forum-board-topic-title' => 'Discussies over $1',
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
	'forum-sorting-option-newest-threads' => 'Nieuwste overleg',
	'forum-sorting-option-oldest-threads' => 'Oudste onderwerpen',
	'forum-discussion-post' => 'Opslaan',
	'forum-discussion-highlight' => 'Onderwerp uitlichten',
	'forum-discussion-placeholder-title' => 'Waar wilt u over praten?',
	'forum-discussion-placeholder-message' => 'Nieuw bericht plaatsen op het board $1',
	'forum-discussion-placeholder-message-short' => 'Nieuw bericht plaatsen',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|heeft}} geantwoord in uw onderwerp op het prikbord $3',
	'forum-notification-user2-reply-to-your' => '$1 en $2 hebben gereageerd op uw onderwerp op het prikbord $3',
	'forum-notification-user3-reply-to-your' => '$1 en anderen hebben gereageerd op uw onderwerp op het prikbord $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|heeft}} gereageerd op uw onderwerp op het prikbord $3',
	'forum-notification-user2-reply-to-someone' => '$1 en $2 hebben gereageerd op het prikbord $3',
	'forum-notification-user3-reply-to-someone' => '$1 en anderen hebben gereageerd op het prikbord $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|heeft}} een nieuw bericht geplaatst op het prikbord $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME schreef een nieuwe draad op het $BOARDNAME bord van $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME schreef een nieuwe draad op het $BOARDNAME bord van $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME heeft gereageerd op uw draad op het $BOARDNAME bord van $WIKI.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME heeft gereageerd op het $BOARDNAME bord van $WIKI.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME heeft gereageerd op het $BOARDNAME bord van $WIKI.',
	'forum-mail-notification-html-greeting' => 'Hallo $1,',
	'forum-mail-notification-html-button' => 'Zie het gesprek',
	'forum-mail-notification-subject' => '$1 - $2',
	'forum-mail-notification-body' => 'Hallo $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Zie die conversatie: ($MESSAGE_LINK)

Het Wikia-team
___________________________________________
* Vind hulp en advies op de Gemeenschapswiki: http://community.wikia.com
* Wilt u minder berichten ontvangen van ons? U kunt zich afmelden of uw
e-mailvoorkeuren wijzigen: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hallo $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>--$AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Zie de conversatie</a></p>
<p>Het Wikia-team</p>
___________________________________________<br />
 * Vind hulp en advies op Community Central: http://community.wikia.com
 * Wilt u minder berichten ontvangen van ons? U kunt hier afmelden of uw
e-mailvoorkeuren wijzingen: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'op de $1',
	'forum-wiki-activity-msg-name' => 'prikbord $1',
	'forum-activity-module-heading' => 'Forumactiviteit',
	'forum-related-module-heading' => 'Gerelateerd overleg',
	'forum-activity-module-posted' => '$1 heeft $2 gereageerd',
	'forum-activity-module-started' => '$1 heeft $2 een onderwerp geplaatst',
	'forum-contributions-line' => '[[$1|$2]] op het [[$3|prikbord $4]]',
	'forum-recentchanges-new-message' => 'op het [[$1|prikbord $2]]',
	'forum-recentchanges-edit' => 'bericht bewerkt',
	'forum-recentchanges-removed-thread' => 'heeft het overleg "[[$1|$2]]" van het [[$3|$4 bord]] verwijderd',
	'forum-recentchanges-removed-reply' => 'heeft het antwoord "[[$1|$2]]" van het [[$3|$4 bord]] verwijderd',
	'forum-recentchanges-restored-thread' => 'overleg "[[$1|$2]]" van het [[$3|$4 bord]] hersteld',
	'forum-recentchanges-restored-reply' => 'heeft het antwoord "[[$1|$2]]" op het [[$3|$4 bord]] teruggeplaatst',
	'forum-recentchanges-deleted-thread' => 'overleg "[[$1|$2]]" van het [[$3|$4 bord]] verwijderd',
	'forum-recentchanges-deleted-reply' => 'heeft het antwoord "[[$1|$2]]" van het [[$3|$4 bord]] verwijderd',
	'forum-recentchanges-deleted-reply-title' => 'Een bericht',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forumprikbord',
	'forum-recentchanges-thread-group' => '$1 op het [[$2|$3 bord]]',
	'forum-recentchanges-history-link' => 'bordgeschiedenis',
	'forum-recentchanges-thread-history-link' => 'overleggeschiedenis',
	'forum-recentchanges-closed-thread' => 'overleg "[[$1|$2]]" van [[$3|$4]] gesloten',
	'forum-recentchanges-reopened-thread' => 'heeft het overleg "[[$1|$2]]" van [[$3|$4]] heropend',
	'forum-board-history-title' => 'bordgeschiedenis',
	'forum-specialpage-oldforum-link' => 'Oude forumarchieven',
	'forum-admin-page-breadcrumb' => 'Bordbeheer beheren',
	'forum-admin-create-new-board-label' => 'Nieuw bord aanmaken',
	'forum-admin-create-new-board-modal-heading' => 'Nieuw bord aanmaken',
	'forum-admin-create-new-board-title' => 'Bordnaam',
	'forum-admin-create-new-board-description' => 'Bordbeschrijving',
	'forum-admin-edit-board-modal-heading' => 'Bord wijzigen: $1',
	'forum-admin-edit-board-title' => 'Bordnaam',
	'forum-admin-edit-board-description' => 'Bordbeschrijving',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Bord verwijderen: $1',
	'forum-admin-delete-board-title' => 'Bevestig door de naam te typen van het bord dat u wilt verwijderen:',
	'forum-admin-merge-board-warning' => 'Het overleg op dit bord wordt samengevoegd met een bestaand bord.',
	'forum-admin-merge-board-destination' => 'Kies een bord om vandaan samen te voegen:',
	'forum-admin-delete-and-merge-button-label' => 'Verwijderen en samenvoegen',
	'forum-admin-link-label' => 'Borden beheren',
	'forum-autoboard-title-1' => 'Algemeen overleg',
	'forum-autoboard-body-1' => 'Dit bord bevat algemeen overleg over de wiki.',
	'forum-autoboard-title-2' => 'Nieuws en aankondigingen',
	'forum-autoboard-body-2' => 'Belangrijk nieuws en informatie!',
	'forum-autoboard-title-3' => 'Nieuw op $1',
	'forum-autoboard-body-3' => 'Wilt u iets delen dat zojuist op de deze wiki is geplaatst, of wilt u iemand feliciteren met een geweldige bijdrage? Dit is de juiste plaats!',
	'forum-autoboard-title-4' => 'Vragen en Antwoorden',
	'forum-autoboard-body-4' => 'Hebt u een vraag over de wiki, of het onderwerp? Stel uw vragen hier!',
	'forum-autoboard-title-5' => 'Pret en spelletjes',
	'forum-autoboard-body-5' => 'Dit bord bevat overleg dat niet over de wiki gaat. Een plek om samen te komen met uw vrienden van $1.',
	'forum-board-destination-empty' => '(Selecteer een bord)',
	'forum-board-title-validation-invalid' => 'De bordnaam bevat ongeldige tekens.',
	'forum-board-title-validation-length' => 'De bordnaam moet tenminste vier tekens bevatten.',
	'forum-board-title-validation-exists' => 'Er bestaat al een bord met dezelfde naam.',
	'forum-board-validation-count' => 'Het maximale aantal borden is $1',
	'forum-board-description-validation-length' => 'Geef een beschrijving op voor dit bord',
	'forum-board-id-validation-missing' => 'Het bord-ID ontbreekt.',
	'forum-board-no-board-warning' => 'Er is geen bord gevonden met die naam. Hier is een lijst met forumborden.',
	'forum-old-notification-message' => 'Dit forum is gearchiveerd',
	'forum-old-notification-navigation-button' => 'Bezoek de nieuwe fora',
	'forum-related-discussion-heading' => 'Oveleg over $1',
	'forum-related-discussion-new-post-button' => 'Overleg starten',
	'forum-related-discussion-new-post-tooltip' => 'Begin een nieuwe overleg over $1',
	'forum-related-discussion-total-replies' => '{{PLURAL:$1|Eén bericht|$1 berichten}}',
	'forum-related-discussion-see-more' => 'Meer discussies bekijken',
	'forum-confirmation-board-deleted' => '"$1" is verwijderd.',
	'forum-token-mismatch' => 'Het token komt niet overeen',
];

/** Occitan (occitan)
 * @author Cedric31
 * @author Hulothe
 */
$messages['oc'] = [
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|discussion activa|discussions activas}}',
	'forum-active-threads-on-topic' => '$1 {{PLURAL:$1|discussion activa|discussions activas}}  a prepaus de : « [[$2]] »',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|discussion|discussions}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|messatge|messatges}}',
	'forum-specialpage-board-lastpostby' => 'Darrièr messatge de',
	'forum-specialpage-policies-edit' => 'Modificar',
	'forum-specialpage-policies' => 'Règlas del forum / FAQ',
	'forum-board-title' => 'Sosforum $1',
	'forum-board-topic-title' => 'Discussions a prepaus de « $1 »',
	'forum-board-topics' => 'Subjèctes',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Seguiment',
	'forum-board-thread-kudos' => '{{PLURAL:$1|1 seleccion|$1 seleccions}}',
	'forum-board-thread-replies' => '{{PLURAL:$1|1 messatge|$1 messatges}}',
	'forum-board-new-message-heading' => 'Començar una discussion',
	'forum-no-board-selection-error' => '← Seleccionatz un sosforum sul qual postar',
	'forum-thread-reply-placeholder' => 'Mandar una responsa',
	'forum-thread-reply-post' => 'Respondre',
	'forum-thread-deleted-return-to' => 'Tornar al sosforum $1',
	'forum-sorting-option-newest-replies' => 'Responsas las mai recentas',
	'forum-sorting-option-popular-threads' => 'Los mai populars',
	'forum-sorting-option-most-replies' => 'Los mai actius pendent los 7 darrièrs jorns',
	'forum-sorting-option-newest-threads' => 'Fials los mai recents en primièr',
	'forum-sorting-option-oldest-threads' => 'Fials los mai ancians en primièr',
	'forum-discussion-post' => 'Mandar',
	'forum-discussion-highlight' => 'Espingolar la discussion',
	'forum-discussion-placeholder-message-short' => 'Mandar un messatge novèl',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|a respondut}} a vòstre fial sul sosforum $3',
	'forum-mail-notification-html-greeting' => 'Bonjorn $1,',
	'forum-mail-notification-html-button' => 'Veire la conversacion',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-wiki-activity-msg' => 'sul $1',
	'forum-wiki-activity-msg-name' => 'sosforum $1',
	'forum-activity-module-heading' => 'Activitat del forum',
	'forum-related-module-heading' => 'Discussions connèxas',
	'forum-activity-module-started' => '$1 a començat una discussion $2',
	'forum-recentchanges-new-message' => 'sul <a href="$1">sosforum $2</a>',
	'forum-recentchanges-edit' => '(messatge modificat)',
	'forum-recentchanges-deleted-reply-title' => 'Un messatge',
	'forum-recentchanges-namespace-selector-message-wall' => 'Sosforum',
	'forum-recentchanges-thread-group' => '$1 sul <a href="$2">sosforum $3</a>',
	'forum-recentchanges-history-link' => 'istoric del sosforum',
	'forum-recentchanges-thread-history-link' => 'istoric de la discussion',
	'forum-recentchanges-closed-thread' => 'a tampat la discussion «&nbsp;[[$1|$2]]&nbsp;» de [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'a redobèrt la discussion «&nbsp;[[$1|$2]]&nbsp;» de [[$3|$4]]',
	'forum-board-history-title' => 'istoric del sosforum',
	'forum-specialpage-oldforum-link' => "Archius de l'ancian forum",
	'forum-admin-page-breadcrumb' => 'Administracion dels sosforums',
	'forum-admin-create-new-board-label' => 'Crear un novèl sosforum',
	'forum-admin-create-new-board-modal-heading' => 'Crear un novèl sosforum',
	'forum-admin-create-new-board-title' => 'Títol del sosforum',
	'forum-admin-create-new-board-description' => 'Descripcion del sosforum',
	'forum-admin-edit-board-modal-heading' => 'Modificar sosforum : $1',
	'forum-admin-edit-board-title' => 'Títol del sosforum',
	'forum-admin-edit-board-description' => 'Descripcion del sosforum',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Suprimir lo sosforum : $1',
	'forum-admin-delete-and-merge-button-label' => 'Suprimir e fusionar',
	'forum-admin-link-label' => 'Gerir los sosforums',
	'forum-autoboard-title-1' => 'Discussion generala',
	'forum-autoboard-title-3' => 'Novèl sus $1',
	'forum-autoboard-title-5' => 'Jòcs e lésers',
	'forum-board-destination-empty' => '(Seleccionatz un sosforum)',
	'forum-related-discussion-new-post-button' => 'Començar una discussion',
	'forum-related-discussion-total-replies' => '$1 messatges',
];

/** Polish (polski)
 * @author Chrumps
 * @author Cotidianis
 * @author Pan Cube
 * @author Pio387
 * @author Py64
 * @author Rzuwig
 * @author Vuh
 */
$messages['pl'] = [
	'forum-desc' => 'Rozszerzenie Wikii Specjalna:Forum',
	'forum-disabled-desc' => 'Rozszerzenie Wikii Specjalna:Forum; wyłączone',
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Aktywny wątek|Aktywne wątki|Aktywnych wątków}}',
	'forum-active-threads-on-topic' => "{{FORMATNUM:$1}} {{PLURAL:$1|Aktywna dyskusja|Aktywnych dyskusji}} o: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Wątek<br /> na tym forum|Wątki<br /> na tym forum|Wątków<br /> na tym forum}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Aktywny<br /> wątek|Aktywne<br /> wątki|Aktywnych<br /> wątków}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Edytuj<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|wątek|wątki|wątków}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|wiadomość|wiadomości}}',
	'forum-specialpage-board-lastpostby' => 'Ostatni wpis dodany przez',
	'forum-specialpage-policies-edit' => 'Edytuj',
	'forum-specialpage-policies' => 'Zasady forum / FAQ',
	'forum-policies-and-faq' => "==Zasady forum==
Zanim rozpoczniesz dyskusję na forum, pamiętaj o przestrzeganiu kilku zasad:

'''Szanuj innych użytkowników'''
:Ludzie z różnych miejsc korzystają z tej wiki i jej forum. Jak w każdym innym projekcie, w którym współpraca odgrywa ogromną rolę nie wszyscy będą zawsze się ze sobą zgadzać. Pamiętaj aby prowadzić dyskusje w wyważony i obiektywny sposób. Łączy nas zamiłowanie do tematu wiki.

'''Przeszukaj forum zanim rozpoczniesz nową dyskusję'''
:Jeśli chcesz założyć nowy wątek, upewnij się, że podobny temat nie został już podjęty a odpowiedź na Twoje pytanie nie została już udzielona. Jeśli nie - nie bój się rozpocząć nowej dyskusji.

'''Pytaj o pomoc'''
:Zauważyłeś, że coś nie działa poprawnie? Być może masz pytania? Poproś o pomoc na forum. Jeśli potrzebujesz pomocy bezpośrednio od Wikii skontaktuj się z nami poprzez [[w:c:spolecznosc|Centrum Społeczności]] albo [[Specjalna:Kontakt]].

'''Baw się dobrze'''
:Społeczność {{SITENAME}} cieszy się, że jesteś jej częścią. Chcemy, abyś częściej wpadał aby podyskutować na temat tej wiki, który interesuje nas wszystkich.

==FAQ==
'''Jak śledzić dyskusje, które mnie interesują?'''
:Jeśli założyłeś konto na Wikii możesz obserwować określone wątki i otrzymywać powiadomienia (na stronie lub poprzez e-mail) gdy pojawią się odpowiedzi w danej dyskusji. [[Special:UserSignup|Załóż konto]] jeśli jeszcze go nie posiadasz.

'''Jak cofać wandalizm?'''
:Jeśli widzisz spam lub wandalizm na forum, możesz usunąć go poprzez najechanie kursorem myszy na tekst wiadomości, pojawi się wtedy d dolnym rogu wiadomości menu \"Więcej\". W tym menu wybrać możesz opcję \"Usuń\". To pozwoli Ci usunąć złą wiadomości i (opcjonalnie) poinformować administratora.

'''Czym są OKejki?'''
:Jeśli dany wątek lub odpowiedź Ci się spodobała, możesz wyrazić swoją aprobatę poprzez danie OKejki. Mogą one być także przydatne w głosowaniach na forum.

'''Czym są tematy?'''
:Tematy pozwolą Ci zsynchronizować wątek na forum z konkretnym artykułem. To sposób na zorganizowanie forum i ułatwienie innym odnalezienia ciekawych dyskusji na dany temat. Przykładowo, wątek o temacie \"Lord Voldemort\" pojawi się u dołu artykułu \"Lord Voldemort\"", # Fuzzy
	'forum-board-title' => 'Subforum $1',
	'forum-board-topic-title' => 'Dyskusje na temat $1',
	'forum-board-topics' => 'Tematy',
	'forum-board-thread-follow' => 'Obserwuj',
	'forum-board-thread-following' => 'Obserwowany',
	'forum-board-thread-kudos' => '$1 OKejek',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Wiadomość|Wiadomości}}',
	'forum-board-new-message-heading' => 'Rozpocznij nową dyskusję',
	'forum-no-board-selection-error' => '← Wybierz subforum',
	'forum-thread-reply-placeholder' => 'Napisz odpowiedź',
	'forum-thread-reply-post' => 'Odpowiedz',
	'forum-thread-deleted-return-to' => 'Powróć do subforum $1',
	'forum-sorting-option-newest-replies' => 'Ostatnio edytowane',
	'forum-sorting-option-popular-threads' => 'Najpopularniejsze',
	'forum-sorting-option-most-replies' => 'Najaktywniejsze',
	'forum-sorting-option-newest-threads' => 'Najnowsze wątki',
	'forum-sorting-option-oldest-threads' => 'Najstarsze wątki',
	'forum-discussion-post' => 'Publikuj',
	'forum-discussion-highlight' => 'Wyróżnij ten wątek',
	'forum-discussion-placeholder-title' => 'Temat wiadomości',
	'forum-discussion-placeholder-message' => 'Napisz nową wiadomość na subforum $1',
	'forum-discussion-placeholder-message-short' => 'Dodaj nową wiadomość',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|odpowiedział|odpowiedziała}} na Twój wątek na subforum $3',
	'forum-notification-user2-reply-to-your' => '$1 i $2 odpowiedzieli na Twój wątek na subforum $3',
	'forum-notification-user3-reply-to-your' => '$1 i inni odpowiedzieli na Twój wątek na subforum $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|odpowiedział|odpowiedziała}} na subforum $3',
	'forum-notification-user2-reply-to-someone' => '$1 i $2 odpowiedzieli na subforum $3',
	'forum-notification-user3-reply-to-someone' => '$1 i inni odpowiedzieli na subforum $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|zostawił|zostawiła}} nową wiadomość na subforum $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME utworzył(a) nowy wątek na subforum $BOARDNAME na $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME utworzył(a) nowy wątek na subforum $BOARDNAME na $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME odpowiedział(a) na Twój wątek na subforum $BOARDNAME na $WIKI',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME odpowiedział(a) na subforum $BOARDNAME na $WIKI',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME odpowiedział(a) na subforum $BOARDNAME na $WIKI',
	'forum-mail-notification-html-greeting' => 'Witaj $1,',
	'forum-mail-notification-html-button' => 'Przejdź do wiadomości',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Witaj $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Przejdź do wiadomości($MESSAGE_LINK)

Zespół Wikii

___________________________________________
* Znajdź pomoc w Centrum Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Witaj $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Przejdź do wiadomości</a></p>
<p>Zespół Wikii</p>
___________________________________________<br />
* Znajdź pomoc w Centrum Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'na $1',
	'forum-wiki-activity-msg-name' => 'subforum $1',
	'forum-activity-module-heading' => 'Aktywność na Forum',
	'forum-related-module-heading' => 'Podobne wątki',
	'forum-activity-module-posted' => '$1 napisał(a) odpowiedź $2',
	'forum-activity-module-started' => '$1 rozpoczął dyskusję $2',
	'forum-contributions-line' => '[[$1|$2]] na [[$3|subforum $4]]',
	'forum-recentchanges-new-message' => 'na [[$1|subforum $2]]',
	'forum-recentchanges-edit' => 'edytowano wiadomość',
	'forum-recentchanges-removed-thread' => 'usunięto wątek "[[$1|$2]]" z [[$3|tablicy użytkownika $4]]',
	'forum-recentchanges-removed-reply' => '{{GENDER:$5|usunął|usunęła}} odpowiedź z "[[$1|$2]]" na [[$3|subforum $4]]', # Fuzzy
	'forum-recentchanges-restored-thread' => '{{GENDER:$5|przywrócił|przywróciła}} wątek "[[$1|$2]]" na [[$3|subforum $4]]', # Fuzzy
	'forum-recentchanges-restored-reply' => '{{GENDER:$5|przywrócił|przywróciła}} odpowiedź w "[[$1|$2]]" na [[$3|subforum $4]]', # Fuzzy
	'forum-recentchanges-deleted-thread' => '{{GENDER:$5|skasował|skasowała}} wątek "[[$1|$2]]" z [[$3|subforum $4]]', # Fuzzy
	'forum-recentchanges-deleted-reply' => '{{GENDER:$5|skasował|skasowała}} odpowiedź z "[[$1|$2]]" z [[$3|subforum $4]]', # Fuzzy
	'forum-recentchanges-deleted-reply-title' => 'Wiadomość',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subforum',
	'forum-recentchanges-thread-group' => '$1 na [[$2|subforum $3]]',
	'forum-recentchanges-history-link' => 'historia subforum',
	'forum-recentchanges-thread-history-link' => 'historia wątku',
	'forum-recentchanges-closed-thread' => '{{GENDER:$5|zamknął|zamknęła}} wątek "[[$1|$2]]" w [[$3|$4]]', # Fuzzy
	'forum-recentchanges-reopened-thread' => '$5 {{GENDER:$5|reaktywował|reaktywowała}} wątek "[[$1|$2]]" w [[$3|$4]]', # Fuzzy
	'forum-board-history-title' => 'Historia subforum',
	'forum-specialpage-oldforum-link' => 'Archiwum poprzedniego forum',
	'forum-admin-page-breadcrumb' => 'Administracja forum',
	'forum-admin-create-new-board-label' => 'Utwórz nowe subforum',
	'forum-admin-create-new-board-modal-heading' => 'Utwórz nowe subforum',
	'forum-admin-create-new-board-title' => 'Tytuł subforum',
	'forum-admin-create-new-board-description' => 'Opis subforum',
	'forum-admin-edit-board-modal-heading' => 'Edytuj subforum: $1',
	'forum-admin-edit-board-title' => 'Tytuł subforum',
	'forum-admin-edit-board-description' => 'Opis subforum',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Usuń subforum: $1',
	'forum-admin-delete-board-title' => 'Potwierdź wpisując nazwę subforum, które chcesz usunąć:',
	'forum-admin-merge-board-warning' => 'Wątki z tego subforum zostaną dołączone do istniejącego subforum.',
	'forum-admin-merge-board-destination' => 'Połącz z subforum:',
	'forum-admin-delete-and-merge-button-label' => 'Usuń i połącz',
	'forum-admin-link-label' => 'Zarządzanie forum',
	'forum-autoboard-title-1' => 'Dyskusja ogólna',
	'forum-autoboard-body-1' => 'To subforum służy ogólnej dyskusji o wiki.',
	'forum-autoboard-title-2' => 'Wiadomości i ogłoszenia',
	'forum-autoboard-body-2' => 'Najnowsze wiadomości i informacje!',
	'forum-autoboard-title-3' => 'Nowości na $1',
	'forum-autoboard-body-3' => 'Chcesz podzielić się czymś co właśnie zostało dodane do wiki albo pogratulować komuś świetnej roboty?',
	'forum-autoboard-title-4' => 'Pytania i odpowiedzi',
	'forum-autoboard-body-4' => 'Masz pytanie na temat wiki lub jej tematu? Pytaj tutaj!',
	'forum-autoboard-title-5' => 'Off-topic',
	'forum-autoboard-body-5' => 'To subforum służy dyskusji na inne tematy. Miejsce, w którym możesz pogadać ze swoimi znajomymi z $1.',
	'forum-board-destination-empty' => '(Wybierz subforum)',
	'forum-board-title-validation-invalid' => 'Nazwa subforum zawiera niewłaściwe znaki',
	'forum-board-title-validation-length' => 'Nazwa subforum powinna mieć co najmniej 4 znaki',
	'forum-board-title-validation-exists' => 'Subforum o tej nazwie już istnieje',
	'forum-board-validation-count' => 'Maksymalna liczba subforów to $1',
	'forum-board-description-validation-length' => 'Wprowadź opis tego subforum',
	'forum-board-id-validation-missing' => 'Nie odnaleziono ID subforum',
	'forum-board-no-board-warning' => 'Nie odnaleziono subforum o tym tytule. Oto lista dostępnych.',
	'forum-old-notification-message' => 'To forum zostało zarchiwizowane',
	'forum-old-notification-navigation-button' => 'Odwiedź nowe forum',
	'forum-related-discussion-heading' => 'Dyskusje o artykule $1',
	'forum-related-discussion-new-post-button' => 'Rozpocznij dyskusję',
	'forum-related-discussion-new-post-tooltip' => 'Rozpocznij nową dyskusję o $1',
	'forum-related-discussion-total-replies' => '$1 wiadomości',
	'forum-related-discussion-see-more' => 'Zobacz więcej dyskusji',
	'forum-confirmation-board-deleted' => '"$1" został usunięty.',
	'forum-token-mismatch' => 'Ups! Token nie pasuje',
];

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = [
	'forum-specialpage-policies-edit' => 'سمول',
	'forum-specialpage-policies' => 'د فورم تگلارې/ډ ځ پ',
	'forum-thread-reply-post' => 'ځوابول',
	'forum-mail-notification-html-greeting' => 'سلامونه $1،',
];

/** Portuguese (português)
 * @author Imperadeiro98
 * @author Josep Maria 15.
 * @author Vitorvicentevalente
 */
$messages['pt'] = [
	'forum-forum-title' => 'Fórum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Discussão ativa|Discussões ativas}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Discussão ativa|Discussões ativas}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Conversa<br />nesse Fórum|Conversas<br />nesse Fórum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Ativa<br />Discussão|Ativas<br />Discussões}}</span>',
	'forum-specialpage-heading' => 'Fórum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Você pode editar<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|conversa|conversas}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|postagem|postagens}}',
	'forum-specialpage-board-lastpostby' => 'Última postagem do',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas do Fórum / FAQ',
	'forum-policies-and-faq' => "==Políticas do Fórum==
Antes de contribuir nos Fóruns do {{SITENAME}}, por favor, fique ciente dessas condutas:

'''Seja amigável e trate as pessoas com respeito.'''
: Pessoas do mundo todo lêem e editam essa wiki e os fóruns. Como qualquer outro trabalho colaborativo, nem todo mundo vai concordar o tempo todo. Mantenha as discussões civilizadas e tenha uma mente aberta sobre opiniões diferentes. Nós estamos aqui porque amamos o mesmo tópico.

'''Tente encontrar discussões existentes primeiro, mas não tenha medo de começar uma nova conversa.'''
:Por favor, dê uma olhada pelos Fóruns do {{SITENAME}} para ver se uma discussão já existe sobre o que você quer falar. Se você não achar nenhuma, vá em frente e comece uma nova discussão!

'''Peça ajuda.'''
:Viu alguma coisa que não está certa? Ou tem uma pergunta? Peça ajuda aqui nos fóruns! Se você precisar de ajuda da equipe da Wikia, por favor entre em contato com [[w:c:community|Comunidade Central]] ou via [[Special:Contact]].

'''Divirta-se!'''
:A comunidade do {{SITENAME}} fica feliz em tê-lo aqui. Esperamos vê-lo por aqui enquanto discutimos esse tópico que amamos.

==Fórum FAQ==
'''Como eu posso ficar conectado às discussões que me interessam?'''
: Com uma conta de usuário da Wikia, você pode seguir conversas específicas e receber mensagens de notificação (no próprio site ou via e-mail) quando a discussão tiver mais atividade. Tenha certeza de [[Special:UserSignup|crie uma conta na Wikia]] se você já não tiver uma.

'''Como eu removo vandalismo?'''
: Se você notar vandalismo ou spam, passe o mouse por cima do texto ofensivo. Você vai ver o botão \"Mais\" aparecer. Dentro do menu do botão \"Mais\", você vai encontrar \"Remover\". Isso permitirá que você remova o vandalismo e informe o administrador, se quiser.

'''O que são Kudos?'''
: Se você achar uma certa discussão ou uma resposta interessante, bem pensada ou engraçada, você pode mostrar que gostou distribuindo Kudos. Eles podem ser interessantes para votações, também.

'''O que são tópicos?'''
: Tópicos permitem que você associe uma discussão do fórum com um artigo da wiki. É uma outra maneira de manter os Fóruns organizados e ajudar as pessoas a encontrar discussões interessantes. Por exemplo, uma conversa no Fórum com a etiqueta \"Lord Voldemort\" vai aparecer embaixo do artigo \"Lord Voldemort\".",
	'forum-board-title' => '$1 quadro',
	'forum-board-topic-title' => 'Discussões sobre $1',
	'forum-board-topics' => 'Tópicos',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Seguindo',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Mensagem|Mensagens}}',
	'forum-board-new-message-heading' => 'Começar uma Discussão',
	'forum-no-board-selection-error' => '← Por favor, selecione um quadro para postar',
	'forum-thread-reply-placeholder' => 'Postar uma resposta',
	'forum-thread-reply-post' => 'Responder',
	'forum-thread-deleted-return-to' => 'Voltar para o quadro $1',
	'forum-sorting-option-newest-replies' => 'Respostas mais recentes',
	'forum-sorting-option-popular-threads' => 'Mais Popular',
	'forum-sorting-option-most-replies' => 'Mais ativo essa semana',
	'forum-sorting-option-newest-threads' => 'Conversas mais recentes',
	'forum-sorting-option-oldest-threads' => 'Conversas mais antigas',
	'forum-discussion-post' => 'Postar',
	'forum-discussion-highlight' => 'Destacar essa discussão',
	'forum-discussion-placeholder-title' => 'sobre o que você quer falar?',
	'forum-discussion-placeholder-message' => 'Postar uma nova mensagem no quadro $1',
	'forum-discussion-placeholder-message-short' => 'Postar uma nova mensagem',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|respondeu}} à sua converse no quadro $3',
	'forum-notification-user2-reply-to-your' => '$1 e $2 responderam à sua conversa no quadro $3',
	'forum-notification-user3-reply-to-your' => '$1 e outros responderam à sua converse no quadro $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|responderam}} no quadro $3',
	'forum-notification-user2-reply-to-someone' => '$1 e $2 responderam no quadro $3',
	'forum-notification-user3-reply-to-someone' => '$1 e outros responderam no quadro $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|deixou}} uma mensagem no quadro $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME começou uma nova conversa no quadro $BOARDNAME $WIKI\\.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME começou uma nova converse no quadro $BOARDNAME $WIKI\\.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME respondeu à sua converse no quadro $BOARDNAME $WIKI\\.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME respondeu no quadro $BOARDNAME $WIKI\\.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME respondeu no quadro $BOARDNAME $WIKI\\.',
	'forum-mail-notification-html-greeting' => 'Olá $1,',
	'forum-mail-notification-html-button' => 'Veja a conversa',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Olá $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Veja a conversa: ($MESSAGE_LINK)

Equipe Wikia

___________________________________________
* Encontre ajuda e conselho na Comunidade Central: http://community.wikia.com
* Quer receber menos mensagens? Você pode cancelar ou mudar as suas preferências de email aqui: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Olá $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Veja a conversa</a></p>
<p>The Wikia Team</p>
___________________________________________<br />
* Encontre ajuda e conselho na Comunidade Central: http://community.wikia.com
* Quer receber menos mensagens? Você pode cancelar ou mudar as suas preferências de email aqui: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'no $1',
	'forum-wiki-activity-msg-name' => 'quadro $1',
	'forum-activity-module-heading' => 'Atividade no Fórum',
	'forum-related-module-heading' => 'Conversas relacionadas',
	'forum-activity-module-posted' => '$1 postou uma resposta $2',
	'forum-activity-module-started' => '$1 começou uma discussão $2',
	'forum-contributions-line' => '[[$1|$2]] no [[$3|quadro $4]]',
	'forum-recentchanges-new-message' => 'no [[$1|Quadro $2]]',
	'forum-recentchanges-edit' => 'mensagem editada',
	'forum-recentchanges-removed-thread' => 'conversa removida "[[$1|$2]]" no [[$3|$4 Quadro]]',
	'forum-recentchanges-removed-reply' => 'resposta removida "[[$1|$2]]" no [[$3|$4 Quadro]]',
	'forum-recentchanges-restored-thread' => 'conversa restaurada "[[$1|$2]]" no [[$3|$4 Quadro]]',
	'forum-recentchanges-restored-reply' => 'conversa restaurada "[[$1|$2]]" no [[$3|$4 Quadro]]',
	'forum-recentchanges-deleted-thread' => 'conversa deletada "[[$1|$2]]" no [[$3|$4 Quadro]]',
	'forum-recentchanges-deleted-reply' => 'resposta deletada "[[$1|$2]]" no [[$3|$4 Quadro]]',
	'forum-recentchanges-deleted-reply-title' => 'Uma postagem',
	'forum-recentchanges-namespace-selector-message-wall' => 'Quadro do Fórum',
	'forum-recentchanges-thread-group' => '$1 no [[$2|$3 Quadro]]',
	'forum-recentchanges-history-link' => 'histórico do quadro',
	'forum-recentchanges-thread-history-link' => 'histórico da conversa',
	'forum-recentchanges-closed-thread' => 'conversa encerrada "[[$1|$2]]" de [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'conversa reaberta"[[$1|$2]]" de [[$3|$4]]',
	'forum-board-history-title' => 'histórico do quadro',
	'forum-specialpage-oldforum-link' => 'Arquivos antigos do Fórum',
	'forum-admin-page-breadcrumb' => 'Quadro do Admin de Gerência',
	'forum-admin-create-new-board-label' => 'Criar novo quadro',
	'forum-admin-create-new-board-modal-heading' => 'Crie um novo quadro',
	'forum-admin-create-new-board-title' => 'Título do Quadro',
	'forum-admin-create-new-board-description' => 'Descrição do Quadro',
	'forum-admin-edit-board-modal-heading' => 'Editar Quadro: $1',
	'forum-admin-edit-board-title' => 'Título do Quadro',
	'forum-admin-edit-board-description' => 'Descrição do Quadro',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Deletar Quadro: $1',
	'forum-admin-delete-board-title' => 'Por favor, digite o nome do quadro que você quer deletar para confirmar:',
	'forum-admin-merge-board-warning' => 'As conversas nesse quadro vão ser incorporadas em um quadro existente.',
	'forum-admin-merge-board-destination' => 'Escolha um quadro para incorporar:',
	'forum-admin-delete-and-merge-button-label' => 'Delete e Incorpore',
	'forum-admin-link-label' => 'Gerenciar Quadros',
	'forum-autoboard-title-1' => 'Discussão Geral',
	'forum-autoboard-body-1' => 'Esse quadro é para conversas gerais sobre a wiki.',
	'forum-autoboard-title-2' => 'Notícias e Anúncios',
	'forum-autoboard-body-2' => 'Notícias urgentes e informação!',
	'forum-autoboard-title-3' => 'Novos no $1',
	'forum-autoboard-body-3' => 'Quer compartilhar algo que acabou de ser postado nessa wiki, ou parabenizar alguém por um ótima contribuição? Está no lugar certo!',
	'forum-autoboard-title-4' => 'Perguntas e Respostas',
	'forum-autoboard-body-4' => 'Tem uma pergunta sobre a wiki ou o tópico? Pergunte aqui!',
	'forum-autoboard-title-5' => 'Diversão e Jogos',
	'forum-autoboard-body-5' => 'Esse quadro é para conversas fora do tópico -- um lugar para se divertir com os seus $1 amigos.',
	'forum-board-destination-empty' => '(Por favor selecione um quadro)',
	'forum-board-title-validation-invalid' => 'Nome do quadro contém caracteres inválidos',
	'forum-board-title-validation-length' => 'Nome do quadro deve ter 4 caracteres no mínimo',
	'forum-board-title-validation-exists' => 'Um Quadro com o mesmo nome já existe.',
	'forum-board-validation-count' => 'O número máximo de quadros é $1',
	'forum-board-description-validation-length' => 'Por favor, descreva esse quadro',
	'forum-board-id-validation-missing' => 'Id do quadro está faltando',
	'forum-board-no-board-warning' => 'Nós não conseguimos encontrar um quadro com esse nome. Aqui está a lista dos quadros do fórum.',
	'forum-old-notification-message' => 'Este fórum foi arquivado',
	'forum-old-notification-navigation-button' => 'Visite os novos Fóruns',
	'forum-related-discussion-heading' => 'Discussões sobre $1',
	'forum-related-discussion-new-post-button' => 'Comece uma Discussão',
	'forum-related-discussion-new-post-tooltip' => 'Comece uma discussão sobre $1',
	'forum-related-discussion-total-replies' => '$1 mensagem',
	'forum-related-discussion-see-more' => 'Veja mais discussões',
	'forum-confirmation-board-deleted' => '"$1" foi deletado.',
];

/** Brazilian Portuguese (português do Brasil)
 * @author Caio1478
 * @author Fasouzafreitas
 * @author TheGabrielZaum
 * @author Tuliouel
 */
$messages['pt-br'] = [
	'forum-desc' => 'Extensão Especial:Forum da Wikia',
	'forum-disabled-desc' => 'Extensão Especial:Forum da Wikia; desativado',
	'forum-forum-title' => 'Fórum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Discussão Ativa|Discussões Ativas}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Discussão Ativa|Discussões Ativas}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Tópico<br />neste Fórum|Tópicos<br />neste Fórum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Ativa<br />Discussão|Ativas<br />Discussões}}</span>',
	'forum-specialpage-heading' => 'Fórum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Você pode editar isto.<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|tópico|tópicos}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|post|posts}}',
	'forum-specialpage-board-lastpostby' => 'Último post por',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas do Fórum / FAQ',
	'forum-board-title' => 'Painel $1',
	'forum-board-topic-title' => 'Discussões sobre $1',
	'forum-board-topics' => 'Tópicos',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Seguindo',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Mensagem|Mensagens}}',
	'forum-board-new-message-heading' => 'Iniciar uma Discussão',
	'forum-no-board-selection-error' => '← Selecione um painel para postar uma conversa',
	'forum-thread-reply-placeholder' => 'Postar uma resposta',
	'forum-thread-reply-post' => 'Responder',
	'forum-thread-deleted-return-to' => 'Voltar para o painel $1',
	'forum-sorting-option-newest-replies' => 'Respostas Mais Recentes',
	'forum-sorting-option-popular-threads' => 'Mais Popular',
	'forum-sorting-option-most-replies' => 'Mais Ativo em 7 Dias',
	'forum-sorting-option-newest-threads' => 'Novos Tópicos',
	'forum-sorting-option-oldest-threads' => 'Tópicos Antigos',
	'forum-discussion-post' => 'Postar',
	'forum-discussion-highlight' => 'Destacar esta discussão',
	'forum-discussion-placeholder-title' => 'Sobre o que você quer falar?',
	'forum-discussion-placeholder-message' => 'Postar uma nova mensagem no painel $1',
	'forum-discussion-placeholder-message-short' => 'Postar uma nova mensagem',
	'forum-activity-module-posted' => '$1 postou uma resposta $2',
	'forum-activity-module-started' => '$1 iniciou uma discussão $2',
	'forum-contributions-line' => '[[$1|$2]] no [[$3|painel $4]]',
	'forum-recentchanges-new-message' => 'no [[$1|Painel $2]]',
	'forum-recentchanges-edit' => 'mensagem editada',
	'forum-recentchanges-history-link' => 'histórico do painel',
	'forum-recentchanges-thread-history-link' => 'histórico do tópico',
	'forum-board-history-title' => 'histórico do painel',
	'forum-admin-create-new-board-modal-heading' => 'Criar um novo painel',
	'forum-admin-create-new-board-title' => 'Título do Painel',
	'forum-admin-create-new-board-description' => 'Descrição do Painel',
	'forum-admin-edit-board-modal-heading' => 'Editar Painel: $1',
	'forum-admin-edit-board-title' => 'Título do Painel',
	'forum-admin-edit-board-description' => 'Descrição do Painel',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Excluir Painel: $1',
	'forum-admin-delete-board-title' => 'Por favor, confirme digitando o nome do painel que você deseja excluir:',
	'forum-admin-merge-board-warning' => 'Os tópicos neste painel serão fundidos em um painel existente.',
	'forum-admin-merge-board-destination' => 'Escolha um painel para fundir com:',
	'forum-admin-delete-and-merge-button-label' => 'Excluir e Fundir',
	'forum-admin-link-label' => 'Gerenciar Paineis',
	'forum-autoboard-title-1' => 'Discussão Geral',
	'forum-autoboard-title-2' => 'Notícias e Anunciamentos',
	'forum-autoboard-title-4' => 'Perguntas e Respostas',
	'forum-autoboard-title-5' => 'Diversão e Jogos',
	'forum-board-title-validation-invalid' => 'O nome do painel contém caracteres inválidos',
	'forum-board-title-validation-length' => 'O nome do painel deve ter pelo menos 4 caracteres',
	'forum-board-title-validation-exists' => 'Um painel com esse nome já existe',
	'forum-board-validation-count' => 'O número máximo de painéis é $1.',
	'forum-board-description-validation-length' => 'Escreva uma descrição para este painel',
	'forum-board-id-validation-missing' => 'O id do painel está indisponível.',
	'forum-board-no-board-warning' => 'Não pudemos encontrar um painel com esse título. Aqui está uma lista de painéis no fórum.',
	'forum-old-notification-message' => 'Este fórum foi arquivado',
	'forum-old-notification-navigation-button' => 'Visite os novos Fóruns',
	'forum-related-discussion-heading' => 'Discussões sobre $1',
	'forum-related-discussion-new-post-button' => 'Iniciar uma Discussão',
	'forum-related-discussion-new-post-tooltip' => 'Iniciar uma nova discussão sobre $1',
	'forum-related-discussion-total-replies' => '$1 mensagens',
	'forum-related-discussion-see-more' => 'Veja mais discussões',
	'forum-confirmation-board-deleted' => '"$1" foi excluído.',
];

/** Russian (русский)
 * @author Okras
 * @author Капитан Джон Шепард
 */
$messages['ru'] = [
	'forum-desc' => 'Вікі Спеціальна: Розширення форуму',
	'forum-disabled-desc' => 'Вікі Спеціальна: Розширення форуму; інвалідів',
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '$1 {{PLURAL:$1|активная дискуссия|активных дискуссии}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|активная дискуссия|активных дискуссии}} оː '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Тема<br />на этом форуме|Темы<br />на этом форуме}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Активное<br />обсуждение|Активные<br />обсуждения}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Вы можете редактировать его<span>',
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
	'forum-contributions-line' => '[[$1|$2]] в разделе [[$3|$4]]',
	'forum-recentchanges-new-message' => 'в [[$1|разделе $2]]',
	'forum-recentchanges-edit' => 'отредактированное сообщение',
	'forum-recentchanges-removed-thread' => 'удалена тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-removed-reply' => 'удалён ответ «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-restored-thread' => 'восстановлена тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-restored-reply' => 'восстановлен ответ «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-deleted-thread' => 'удалена тема «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-deleted-reply' => 'удалён ответ «[[$1|$2]]» в разделе [[$3|$4]]',
	'forum-recentchanges-deleted-reply-title' => 'Сообщение',
	'forum-recentchanges-namespace-selector-message-wall' => 'Раздел форума',
	'forum-recentchanges-thread-group' => '$1 в [[$2|разделе $3]]',
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
	'forum-related-discussion-see-more' => 'Посмотреть другие обсуждения',
	'forum-confirmation-board-deleted' => '«$1» был удалён.',
	'forum-token-mismatch' => 'Символ не соответствует',
];

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Aktron
 * @author Milicevic01
 */
$messages['sr-ec'] = [
	'forum-thread-reply-post' => 'Одговори',
	'forum-sorting-option-popular-threads' => 'Најпопуларније',
	'forum-sorting-option-most-replies' => 'Најактивније у протеклих 7 дана.',
	'forum-discussion-post' => 'Постави',
	'forum-discussion-placeholder-message-short' => 'Пошаљите нову поруку',
	'forum-token-mismatch' => 'Упс! Жетон се не поклапа.',
];

/** Swedish (svenska)
 * @author Lokal Profil
 * @author WikiPhoenix
 */
$messages['sv'] = [
	'forum-desc' => 'Wikia-tillägget Special:Forum',
	'forum-disabled-desc' => 'Wikia-tillägget Special:Forum; inaktiverat',
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
	'forum-policies-and-faq' => "==Forumpolicy==
Innan du bidrar till {{SITENAME}}s forum, var god lägg dessa punkter på minnet om hur man ska uppföra sig:

'''Var vänlig och behandla folk med respekt.'''
: Folk från hela världen läser och redigerar denna wiki och dess forum. Precis som i andra samarbetsprojekt kommer inte alla överens hela tiden. Håll hänsynsfulla diskussioner och var fördomsfri mot andra åsikter. Vi är alla här eftersom vi gillar samma ämne.

'''Försök att hitta befintliga diskussioner först, men var inte rädd att starta en ny tråd.'''
: Ta dig en stund att titta igenom forumen på {{SITENAME}} för att se om en diskussion redan finns om det du vill prata om. Om du inte kan hitta vad du letar efter, kasta dig in och starta en ny diskussion!

'''Fråga efter hjälp.'''
: Ser du någonting som inte verkar rätt? Eller har du en fråga? Fråga efter hjälp på forumen! Om du behöver hjälp från personalen på Wikia kan du vända dig till [[w:c:community|Gemenskapscentralen]] eller [[Special:Contact]].

'''Ha kul!'''
: Gemenskapen på {{SITENAME}} är glad att du är här. Vi ser framåt att träffa dig när vi diskuterar detta ämne vi alla älskar.

==Vanliga frågor om forumet==
'''Hur håller jag koll på diskussioner jag är intresserade i?'''
: Med ett användarkonto på Wikia kan du följa valda konversationer och sedan få meddelanden (antingen på webbsidan eller via e-post) när en diskussion har mer aktivitet. Se till att [[Special:UserSignup|registrera ett Wikia-konto]] om du inte redan har ett.

'''Hur tar jag bort vandalism?'''
: Om du ser spam eller vandalism på en tråd kan du lägga muspekaren på den stötande texten. Då kommer en knapp dyka upp som säger \"Mer\". I menyn som dyker upp när du trycker på \"Mer\" kommer du hitta \"Ta bort\". Detta kommer att låta dig ta bort vandalismen och alternativt meddela en administratör.

'''Vad är beröm?'''
: Om du tycker att en speciell diskussion eller svar är intressant, väl genomtänkt eller underhållande kan du visa din uppskattning direkt genom att ge den beröm. Det kan också vara hjälpsamt i röstningssituationer.

'''Vad är ämnen?'''
: Ämnen låter dig länka en forumdiskussion med en wikiartikel. Det är ett annat sätt att hålla forumet organiserat och för att hjälpa folk hitta intressanta diskussioner. Till exempel; en forumtråd taggad med \"Lord Voldemort\" kommer att dyka upp längst ned i artikeln om \"Lord Voldemort\".",
	'forum-board-title' => 'underforumet $1',
	'forum-board-topic-title' => 'Diskussioner om $1',
	'forum-board-topics' => 'Ämnen',
	'forum-board-thread-follow' => 'Följ',
	'forum-board-thread-following' => 'Följer',
	'forum-board-thread-kudos' => '$1 beröm',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|meddelande|meddelanden}}',
	'forum-board-new-message-heading' => 'Starta en diskussion',
	'forum-no-board-selection-error' => '← Välj ett underforum att göra inlägg på',
	'forum-thread-reply-placeholder' => 'Skicka ett svar',
	'forum-thread-reply-post' => 'Svara',
	'forum-thread-deleted-return-to' => 'Tillbaka till underforumet $1',
	'forum-sorting-option-newest-replies' => 'Senaste svaren',
	'forum-sorting-option-popular-threads' => 'Mest populära',
	'forum-sorting-option-most-replies' => 'Mest aktiva i 7 dagar',
	'forum-sorting-option-newest-threads' => 'Nyaste trådarna',
	'forum-sorting-option-oldest-threads' => 'Äldsta trådarna',
	'forum-discussion-post' => 'Skicka',
	'forum-discussion-highlight' => 'Belys denna diskussion',
	'forum-discussion-placeholder-title' => 'Vad vill du prata om?',
	'forum-discussion-placeholder-message' => 'Gör ett nytt inlägg på underforumet $1',
	'forum-discussion-placeholder-message-short' => 'Skicka ett nytt meddelande',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|svarade}} på din tråd i underforumet $3',
	'forum-notification-user2-reply-to-your' => '$1 och $2 svarade på din tråd i underforumet $3',
	'forum-notification-user3-reply-to-your' => '$1 och andra svarade på din tråd i underforumet $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|svarade}} på underforumet $3',
	'forum-notification-user2-reply-to-someone' => '$1 och $2 svarade på underforumet $3',
	'forum-notification-user3-reply-to-someone' => '$1 och andra svarade på underforumet $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|lämnade}} ett nytt meddelande på underforumet $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME gjorde en ny tråd på $WIKIs underforum $BOARDNAME.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME gjorde en ny tråd på $WIKIs underforum $BOARDNAME.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME svarade på din tråd på $WIKIs underforum $BOARDNAME.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME svarade på $WIKIs underforum $BOARDNAME.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME svarade på $WIKIs underforum $BOARDNAME.',
	'forum-mail-notification-html-greeting' => 'Hej $1,',
	'forum-mail-notification-html-button' => 'Se konversationen',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hej $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Se diskussionen: ($MESSAGE_LINK)

Wikia-teamet

___________________________________________
* Hitta svar, råd och mer på Community Central: http://community.wikia.com
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra dina e-postadressinställningar här: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hej $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Se konversationen</a></p>
<p>Wikia-teamet</p>
___________________________________________<br />
* Hitta svar, råd och mer på Community Central: http://community.wikia.com
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra dina e-postadressinställningar här: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'på $1',
	'forum-wiki-activity-msg-name' => 'Underforumet $1',
	'forum-activity-module-heading' => 'Forumaktivitet',
	'forum-related-module-heading' => 'Relaterade trådar',
	'forum-activity-module-posted' => '$1 svarade $2',
	'forum-activity-module-started' => '$1 startade en diskussion $2',
	'forum-contributions-line' => '[[$1|$2]] i [[$3|underforumet $4]]',
	'forum-recentchanges-new-message' => 'i [[$1|underforumet $2]]',
	'forum-recentchanges-edit' => 'redigerat meddelande',
	'forum-recentchanges-removed-thread' => 'tog bort tråden "[[$1|$2]]" från [[$3|underforumet $4]]',
	'forum-recentchanges-removed-reply' => 'tog bort svar från "[[$1|$2]]" från [[$3|underforumet $4]]',
	'forum-recentchanges-restored-thread' => 'återställde tråden "[[$1|$2]]" till [[$3|underforumet $4]]',
	'forum-recentchanges-restored-reply' => 'återställde svar på "[[$1|$2]]" till [[$3|underforumet $4]]',
	'forum-recentchanges-deleted-thread' => 'raderade tråden "[[$1|$2]]" från [[$3|underforumet $4]]',
	'forum-recentchanges-deleted-reply' => 'raderade svar från "[[$1|$2]]" från [[$3|underforumet $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Ett inlägg',
	'forum-recentchanges-namespace-selector-message-wall' => 'Underforum',
	'forum-recentchanges-thread-group' => '$1 i [[$2|$3-forumet]]',
	'forum-recentchanges-history-link' => 'underforumshistorik',
	'forum-recentchanges-thread-history-link' => 'trådhistorik',
	'forum-recentchanges-closed-thread' => 'stängde tråden "[[$1|$2]]" från [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'öppna tråden "[[$1|$2]]" från [[$3|$4]]',
	'forum-board-history-title' => 'underforumshistorik',
	'forum-specialpage-oldforum-link' => 'Gamla forumarkiv',
	'forum-admin-page-breadcrumb' => 'Underforumshantering för administratörer',
	'forum-admin-create-new-board-label' => 'Skapa nytt underforum',
	'forum-admin-create-new-board-modal-heading' => 'Skapa ett nytt underforum',
	'forum-admin-create-new-board-title' => 'Underforumsrubrik',
	'forum-admin-create-new-board-description' => 'Underforumsbeskrivning',
	'forum-admin-edit-board-modal-heading' => 'Redigera underforum: $1',
	'forum-admin-edit-board-title' => 'Underforumsrubrik',
	'forum-admin-edit-board-description' => 'Underforumsbeskrivning',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Radera underforum: $1',
	'forum-admin-delete-board-title' => 'Var god bekräfta genom att ange namnet på underforumet du vill radera:',
	'forum-admin-merge-board-warning' => 'Trådarna i detta underforum kommer att slås samman i ett befintligt underforum.',
	'forum-admin-merge-board-destination' => 'Välj ett underforum att slå samman:',
	'forum-admin-delete-and-merge-button-label' => 'Radera och slå ihop',
	'forum-admin-link-label' => 'Hantera underforum',
	'forum-autoboard-title-1' => 'Allmän diskussion',
	'forum-autoboard-body-1' => 'Detta underforum är för allmänna konversationer om wikin.',
	'forum-autoboard-title-2' => 'Nyheter och meddelanden',
	'forum-autoboard-body-2' => 'Heta nyheter och information!',
	'forum-autoboard-title-3' => 'Nytt på $1',
	'forum-autoboard-body-3' => 'Vill du dela någonting som precis har lagts upp på wikin eller gratulera någon för ett enastående bidrag? Detta är den rätta platsen!',
	'forum-autoboard-title-4' => 'Frågor och svar',
	'forum-autoboard-body-4' => 'Har du en fråga om wikin eller trådens ämne? Ställ dina frågor här!',
	'forum-autoboard-title-5' => 'Kul och spel',
	'forum-autoboard-body-5' => 'Detta underforum är för konversationer som wikin inte handlar om -- ett ställe att hänga med din vänner på $1.',
	'forum-board-destination-empty' => '(Välj underforum)',
	'forum-board-title-validation-invalid' => 'Underforumets namn innehåller ogiltiga tecken',
	'forum-board-title-validation-length' => 'Underforumets namn bör vara minst 4 tecken långt',
	'forum-board-title-validation-exists' => 'Ett underforum med samma namn finns redan',
	'forum-board-validation-count' => 'Maximala antalet underforum är $1',
	'forum-board-description-validation-length' => 'Ange en beskrivning för detta underforum',
	'forum-board-id-validation-missing' => 'Underforumets ID saknas',
	'forum-board-no-board-warning' => 'Vi kunde inte hitta ett underforum med den rubriken. Här är en lista över underforum.',
	'forum-old-notification-message' => 'Detta forum har arkiverats',
	'forum-old-notification-navigation-button' => 'Besök de nya forumen',
	'forum-related-discussion-heading' => 'Diskussioner om $1',
	'forum-related-discussion-new-post-button' => 'Starta en diskussion',
	'forum-related-discussion-new-post-tooltip' => 'Starta en ny diskussion om $1',
	'forum-related-discussion-total-replies' => '$1 meddelanden',
	'forum-related-discussion-see-more' => 'Se fler diskussioner',
	'forum-confirmation-board-deleted' => '"$1" har raderats.',
	'forum-token-mismatch' => 'Hoppsan! Koden stämmer inte överens',
];

/** Tamil (தமிழ்)
 * @author ElangoRamanujam
 */
$messages['ta'] = [
	'forum-forum-title' => 'கருத்துக்களம்',
];

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Ravichandra
 */
$messages['te'] = [
	'forum-forum-title' => 'వేదిక',
	'forum-active-threads' => '$1 {{PLURAL:$1|చురుగ్గా ఉన్న చర్చ|చురుగ్గా ఉన్న చర్చలు}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|చురుగ్గా ఉన్న చర్చ|చురుగ్గా ఉన్న చర్చలు}} - ఈ అంశం గురించి: '''[[$2]]'''",
	'forum-specialpage-heading' => 'వేదిక',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|తీగ|తీగలు}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|టపా|టపాలు}}',
	'forum-specialpage-board-lastpostby' => 'చివరి టపా చేసినది',
	'forum-specialpage-policies-edit' => 'మార్చు',
	'forum-specialpage-policies' => 'వేదిక విధానాలు / FAQ',
	'forum-policies-and-faq' => "==వేదిక విధానాలు==
{{SITENAME}} వేదికల్లో పాల్గొనే ముందు, అక్కడి నడవడిక విషయమై కొన్ని ఉత్తమ పద్ధతులను మనసులో పెట్టుకోండి.

'''చక్కగా, ప్రజల పట్ల మర్యాదగా ఉండండి.'''
: ప్రపంచవ్యాప్తంగా ఉన్న ప్రజలు ఈ వికీలోను, ఇక్కడి వేదికల్లోనూ చదవడం రాయడం చేస్తూంటారు. సామూహిక కార్యక్రమాలన్నింటిలో లానే, ప్రతీసారీ ప్రతీ ఒక్కరూ ఏకాభిప్రాయానికి రారు. చర్చల్లో మర్యాదగా ఉండండి. భిన్నాభిప్రాయాలను స్వాగతించండి. ఒకే అంశాన్ని ఇష్టపడేవాళ్లం కాబట్టే మనందరం ఇక్కడకు చేరాం.

'''ఈసరికే జరిగిన చర్చల కోసం చూడండి. అయితే కొత్త తీగను మొదలుపెట్టడానికి వెనకాడకండి.'''
:ఒక్క నిముషం సమయం తీసుకోండి. మీరు చర్చించదలచిన విషయంపై {{SITENAME}} వేదిక బోర్డులలో ఈసరికే ఏదైనా చర్చ జరిగిందేమో చూడండి. మీకు కావలసినది దొరక్కపోతే, వెంటనే రంగంలోకి దూకండి, కొత్త చర్చను మొదలుపెట్టండి!

'''సాయం అడగండి.'''
:ఏదైనా సరిగ్గా ఉన్నట్టు అనిపించలేదా? ఏదైనా సందేహముందా? ఇక్కడ, వేదికల్లో సాయం అడగండి! Wikia సిబ్బంది నుండి సాయం అసరమైతే, [[w:c:community|సముదాయ కేంద్రం]] లేదా [[Special:Contact]] ద్వారా సంప్రదించండి.

'''పండగ చేసుకోండి!'''
:మీరిక్కడికి రావడం {{SITENAME}} సముదాయానికి సంతోషంగా ఉంది. మనందరం ఇష్టపడే ఈ అంశం గురించి చేసే చర్చలో మీరు పాల్గొనడం కోసం మేం ఎదురుచూస్తూంటాం.

==వేదిక FAQ==
'''నాకు ఆసక్తి ఉన్న చర్చల పట్ల తాజా సమాచారం ఎప్పటికప్పుడు నాకు ఎలా తెలుస్తుంది?'''
: Wikia వాడుకరి ఖాతా ఉంటే, మీరు ఎంచుకున్న చర్చలను అనుసరించవచ్చు. తాజాగా చర్చ ఏమైనా జరిగితే మీకు వార్తా సందేశాలు వస్తాయి (సైటులోగానీ, ఈమెయిలు ద్వారాగానీ). మీకు Wikia ఖాతా లేకపోతే, [[Special:UserSignup|ఖాతా తెరవండి]].

'''దుశ్చర్యను తొలగించడం ఎలా?'''
: ఏదైనా తీగలో దుశ్చర్యగానీ, స్పాముగానీ కనిపిస్తే, సదరు పాఠ్యం మీదకు మీ మౌసును తీసుకుపోండి. \"మరింత\" అనే బొత్తాం ఒకటి కనిపిస్తుంది. \"మరింత\" మెనూలో, \"తీసివెయ్యి\" అనే లింకు కనిపిస్తుంది. దీని సాయంతో దుశ్చర్యను తీసెయ్యవచ్చు. కావాలనుకుంటే నిర్వాహకునికి సమాచారం ఇవ్వవచ్చు కూడాను.

'''ఈభలేలు ఏమిటి?'''
: ఏదైనా చర్చగానీ, జవాబుగానీ ఆసక్తికరంగా ఉన్నా, ఆలోచనాత్మకంగా ఉన్నా, ముచ్చటగొలుపుతున్నా మీ మెప్పును వెంటనే భలే ఇవ్వడం ద్వారా చెప్పెయ్యవచ్చు. వోటేసే సందర్భాల్లో కూడా అది ఉపయోగపడుతుంది.

'''అంశాలంటే ఏమిటి?'''
: వేదిక చర్చలను వికీ వ్యాసానికి అనుసంధించడానికి అంశాలు పనికొస్తాయి. వేదికలను ఒక పద్ధతిలో పెట్టేందుకు, ప్రజలు తమకిష్టమైన చర్చలను తేలిగ్గా కనుక్కునేలా చేసేందుకు ఇదో పద్ధతి. ఉదాహరణకు, \"ఆంధ్ర ప్రదేశ్ విభజన\" అనే అంశం కలిగిన వేదిక తీగ \"ఆంధ్ర ప్రదేశ్ విభజన\" అనే వ్యాసపు అడుగున కనిపిస్తుంది.",
	'forum-board-title' => '$1 బోర్డు',
	'forum-board-topic-title' => '$1 గురించి చర్చలు',
	'forum-board-topics' => 'అంశాలు',
	'forum-board-thread-follow' => 'అనుసరించు',
	'forum-board-thread-following' => 'అనుసరిస్తున్నారు',
	'forum-board-thread-kudos' => '$1 భలేలు',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|సందేశం|సందేశాలు}}',
	'forum-board-new-message-heading' => 'చర్చను మొదలుపెట్టండి',
	'forum-no-board-selection-error' => '← టపాయించడానికి ఓ బోర్డును ఎంచుకోండి',
	'forum-thread-reply-placeholder' => 'జవాబివ్వండి',
	'forum-thread-reply-post' => 'జవాబివ్వు',
	'forum-thread-deleted-return-to' => 'తిరిగి $1 బోర్డుకు వెళ్ళండి',
	'forum-sorting-option-newest-replies' => 'ఇట్టీవలి జవాబులు',
	'forum-sorting-option-popular-threads' => 'అత్యంత ప్రజారంజకమైన',
	'forum-sorting-option-most-replies' => '7 రోజుల్లో అత్యంత చురుగ్గా ఉన్న',
	'forum-sorting-option-newest-threads' => 'సరికొత్త తీగలు',
	'forum-sorting-option-oldest-threads' => 'అతిపాత తీగలు',
	'forum-discussion-post' => 'పంపించు',
	'forum-discussion-highlight' => 'ఈ చర్చను ఉద్యోతించు',
	'forum-discussion-placeholder-title' => 'మీరు దేని గురించి మాట్లాడాలనుకుంటున్నారు?',
	'forum-discussion-placeholder-message' => 'బోర్డు $1 కి కొత్ సందేశాన్ని పంపించండి',
	'forum-discussion-placeholder-message-short' => 'కొత్త సందేశాన్ని పంపించండి',
	'forum-notification-user1-reply-to-your' => '$3 బోర్డులో మీ తీగకు $1 {{GENDER:$1|జవాబిచ్చారు}}',
	'forum-notification-user2-reply-to-your' => '$3 బోర్డులో మీ తీగకు $1, $2 జవాబిచ్చారు',
	'forum-notification-user3-reply-to-your' => '$3 బోర్డులో మీ తీగకు $1, మరి కొందరు జవాబిచ్చారు',
	'forum-notification-user1-reply-to-someone' => '$3 బోర్డులో $1 {{GENDER:$1|జవాబిచ్చారు}}',
	'forum-notification-user2-reply-to-someone' => '$3 బోర్డులో $1, $2 జవాబిచ్చారు',
	'forum-notification-user3-reply-to-someone' => '$3 బోర్డులో $1, మరి కొందరు జవాబిచ్చారు',
	'forum-notification-newmsg-on-followed-wall' => '$2 బోర్డులో $1 ఓ కొత్త సందేశాన్ని {{GENDER:$1|పెట్టారు}}',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME,  $WIKI లోని $BOARDNAME బోర్డులో ఓ కొత్త తీగను రాసారు.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME,  $WIKI లోని $BOARDNAME బోర్డులో ఓ కొత్త తీగను రాసారు.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME,  $WIKI లో $BOARDNAME బోర్డులోని మీ తీగకు జవాబిచ్చారు.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME,  $WIKI లోని $BOARDNAME బోర్డులో జవాబిచ్చారు.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME,  $WIKI లోని $BOARDNAME బోర్డులో జవాబిచ్చారు',
	'forum-mail-notification-html-greeting' => 'హలో $1,',
	'forum-mail-notification-html-button' => 'సంభాషణ చూదండి',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'హల్లో $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

సంభాషణ చూడండి: ($MESSAGE_LINK)

Wikia బృందం

___________________________________________
* సముదాయ కేంద్రంలో సహాయం పొందండి: http://community.wikia.com
* మా దగ్గర నుండి సందేశాలు తక్కువగా రావాలనుకుంటున్నారా? చందా విరమించవచ్చు లేదా మీ ఈమెయిలు అభిరుచులను మార్చుకోవచ్చు: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => 'Hi $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">సంభాషణ చూడండి</a></p>
<p>Wikia బృందం</p>
___________________________________________<br />
* సముదాయ కేంద్రంలో సహాయం పొందండి: http://community.wikia.com
* మా దగ్గర నుండి సందేశాలు తక్కువగా రావాలనుకుంటున్నారా? చందా విరమించవచ్చు లేదా మీ ఈమెయిలు అభిరుచులను మార్చుకోవచ్చు: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => '$1 లో',
	'forum-wiki-activity-msg-name' => 'బోర్డు $1',
	'forum-activity-module-heading' => 'వేదిక కార్యకలాపాలు',
	'forum-related-module-heading' => 'సంబంధిత తీగలు',
	'forum-activity-module-posted' => '$2, $1 జవాబిచ్చారు',
	'forum-activity-module-started' => '$2 $1 ఓ చర్చను మొదలుపెట్టారు',
	'forum-contributions-line' => '[[$1|$2]], [[$3|$4 బోర్డు]]లో',
	'forum-recentchanges-new-message' => '[[$1|$2 బోర్డు]]లో',
	'forum-recentchanges-edit' => 'సరిదిద్దిన సందేశం',
	'forum-recentchanges-removed-thread' => '[[$3|$4 బోర్డు]] నుండి "[[$1|$2]]" తీగ తొలగించబడింది',
	'forum-recentchanges-removed-reply' => '[[$3|$4 బోర్డు]] నుండి "[[$1|$2]]" జవాబు తొలగించబడింది',
	'forum-recentchanges-restored-thread' => '[[$3|$4 బోర్డు]] లోకి "[[$1|$2]]" తీగ పునస్థాపించబడింది',
	'forum-recentchanges-restored-reply' => '[[$3|$4 బోర్డు]] లోకి "[[$1|$2]]" జవాబు పునస్థాపించబడింది',
	'forum-recentchanges-deleted-thread' => '[[$3|$4 బోర్డు]] నుండి "[[$1|$2]]" తీగ తొలగించబడింది',
	'forum-recentchanges-deleted-reply' => '[[$3|$4 బోర్డు]] నుండి "[[$1|$2]]" జవాబు తొలగించబడింది',
	'forum-recentchanges-deleted-reply-title' => 'ఓ టపా',
	'forum-recentchanges-namespace-selector-message-wall' => 'వేదిక బోర్డు',
	'forum-recentchanges-thread-group' => '[[$2|$3 బోర్డు]] లో $1',
	'forum-recentchanges-history-link' => 'బోర్డు చరిత్ర',
	'forum-recentchanges-thread-history-link' => 'తీగ చరిత్ర',
	'forum-recentchanges-closed-thread' => '[[$3|$4]] లోని తీగ "[[$1|$2]]" ముగించబడింది',
	'forum-recentchanges-reopened-thread' => '[[$3|$4]] లోని తీగ "[[$1|$2]]" తిరిగి తెరవబడింది',
	'forum-board-history-title' => 'బోర్డు చరిత్ర',
	'forum-specialpage-oldforum-link' => 'పాత చర్చాస్థల భాండాగారాలు',
	'forum-admin-create-new-board-label' => 'కొత్త బోర్డును సృష్టించు',
	'forum-admin-create-new-board-modal-heading' => 'ఓ కొత్త బోర్డును సృష్టించు',
	'forum-admin-create-new-board-title' => 'బోర్డు శీర్షిక',
	'forum-admin-create-new-board-description' => 'బోర్డు వివరణ',
	'forum-admin-edit-board-title' => 'బోర్డు శీర్షిక',
	'forum-admin-edit-board-description' => 'బోర్డు వివరణ',
	'forum-admin-delete-and-merge-board-modal-heading' => 'బోర్డును తొలగించు: $1',
	'forum-admin-delete-board-title' => 'మీరు తొలగించదలచిన బోర్డు పేరును టైపించి నిర్ధారించండి:',
	'forum-admin-merge-board-warning' => 'ఈ బోర్డులోని తీగలు వేరే బోర్డులోకి విలీనం చెయ్యబడతాయి.',
	'forum-admin-merge-board-destination' => 'విలీనం చేసేందుకు ఒక బోర్డును ఎంచుకోండి:',
	'forum-admin-delete-and-merge-button-label' => 'తొలగించి, విలీనం చెయ్యి',
	'forum-admin-link-label' => 'బోర్డుల నిర్వహణ',
	'forum-autoboard-title-1' => 'సాధారణ చర్చ',
	'forum-autoboard-body-1' => 'ఈ బోర్డు వికీ గురించిన సాధారణ చర్చల కోసం.',
	'forum-autoboard-title-2' => 'వార్తలు, ప్రకటనలు',
	'forum-autoboard-body-2' => 'తాజా వార్తలు, సమాచారం!',
	'forum-autoboard-title-3' => '$1 లో కొత్తగా',
	'forum-autoboard-title-4' => 'ప్రశ్నలు జవాబులూ',
	'forum-autoboard-body-4' => 'వికీ గురించి గానీ, అంశం గురించిగానీ ప్రశ్నలేమైనా ఉన్నాయా? ఇక్కడ అడగండి!',
	'forum-autoboard-title-5' => 'ఆటా పాటా',
	'forum-autoboard-body-5' => 'ఈ బోర్డు విషయేతర సంభాషణ కోసం -- మీ $1 మిత్రులతో సరదాగా కాలక్షేపం చేసేందుకు.',
	'forum-board-destination-empty' => '(బోర్డును ఎంచుకోండి)',
	'forum-board-title-validation-invalid' => 'బోర్డు పేరులో చెల్లని కారెక్టర్లున్నాయి',
	'forum-board-title-validation-length' => 'బోర్డు పేరు కనీసం 4 కారెక్టర్ల నిడివి ఉండాలి',
	'forum-board-title-validation-exists' => 'ఇదే పేరుతో మరో బోర్డు ఈసరికే ఉంది',
	'forum-board-validation-count' => 'గరిష్ఠ బోర్డుల సంఖ్య $1',
	'forum-board-description-validation-length' => 'ఈ బోర్డుకు ఒక వివరణ రాయండి',
	'forum-board-id-validation-missing' => 'బోర్డు ఐడీ లేదు',
	'forum-board-no-board-warning' => 'ఆ శీర్షికతో ఉన్న బోర్డు మాకు కనబడలేదు. వేదిక బోర్డుల జాబితా ఇదిగోండి.',
	'forum-old-notification-message' => 'ఈ చర్చాస్థలం భద్రపరచబడింది',
	'forum-old-notification-navigation-button' => 'కొత్త వేదికలను చూడండి',
	'forum-related-discussion-heading' => '$1 గురించిన చర్చలు',
	'forum-related-discussion-new-post-button' => 'ఓ చర్చను మొదలుపెట్టండి',
	'forum-related-discussion-new-post-tooltip' => '$1 గురించి ఓ కొత్త చర్చను మొదలు పెట్టండి',
	'forum-related-discussion-total-replies' => '$1 సందేశాలు',
	'forum-related-discussion-see-more' => 'మరిన్ని చర్చలను చూడండి',
	'forum-confirmation-board-deleted' => '"$1" తొలగించబడింది.',
];

/** Turkish (Türkçe)
 * @author Incelemeelemani
 */
$messages['tr'] = [
	'forum-specialpage-policies-edit' => 'Düzenle',
	'forum-specialpage-policies' => 'Forum İlkeleri / SSS',
];

/** Tuvinian (тыва дыл)
 * @author Agilight
 */
$messages['tyv'] = [
	'forum-forum-title' => 'Шуулган',
	'forum-specialpage-heading' => 'Шуулган',
];

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Капитан Джон Шепард
 */
$messages['uk'] = [
	'forum-desc' => 'Вікіа Спеціальна: Розширення форуму',
	'forum-disabled-desc' => 'Вікіа Спеціальна: Розширення форуму; інвалідів',
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '$1 {{PLURAL:$1|активне обговорення|активні обговорення|активних обговорень}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|активне обговорення|активні обговорення|активних обговорень}} про: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Тема<br />у цьому  форумі|Теми<br />у цьому форумі|Тем<br />у цьому форумі}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|активне<br /> обговорення|активні<br /> обговорення|активних<br /> обговорень}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Ви не можете це редагувати<span>',
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
	'forum-contributions-line' => '[[$1|$2]] на [[$3|стіні $4]]',
	'forum-recentchanges-new-message' => 'на [[$1|стіні $2]]',
	'forum-recentchanges-edit' => 'відредаговане повідомлення',
	'forum-recentchanges-removed-thread' => 'вилучено тему "[[$1|$2]]" із [[$3|стіни $4]]',
	'forum-recentchanges-removed-reply' => 'вилучено відповідь із "[[$1|$2]]" на [[$3|стіні $4]]',
	'forum-recentchanges-restored-thread' => 'відновлено тему "[[$1|$2]]" на [[$3|стіну $4]]',
	'forum-recentchanges-restored-reply' => 'відновлено відповідь на "[[$1|$2]]" до [[$3|стіни $4]]',
	'forum-recentchanges-deleted-thread' => 'вилучено тему "[[$1|$2]]" із [[$3|стіни $4]]',
	'forum-recentchanges-deleted-reply' => 'вилучено відповідь із "[[$1|$2]]" з [[$3|стіни $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Допис',
	'forum-recentchanges-namespace-selector-message-wall' => 'Стіна форуму',
	'forum-recentchanges-thread-group' => '$1 на [[$2|стіні $3]]',
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
	'forum-related-discussion-see-more' => 'Переглянути більше обговорень',
	'forum-confirmation-board-deleted' => '"$1" було видалено.',
	'forum-token-mismatch' => 'Йой! Знак не збігається',
];

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author Dinhxuanduyet
 * @author Rémy Lee
 */
$messages['vi'] = [
	'forum-desc' => 'Trang đặc biệt của Wikia: mở rộng Diễn đàn',
	'forum-disabled-desc' => 'Trang đặc biệt của Wikia: mở rộng Diễn đàn; vô hiệu',
	'forum-forum-title' => 'Diễn đàn',
	'forum-active-threads' => '$1 {{PLURAL:$1|Active Discussion|Thảo luận hoạt động}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Thảo luận hoạt động|Thảo luận hoạt động}} về: '''[[$2]]'' '",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Chủ đề<br />trong diễn đàn này|Chủ đề<br />trong diễn đàn này}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|thảo luận<br />hoạt động|thảo luận<br />hoạt động}}</span>',
	'forum-specialpage-heading' => 'Diễn đàn',
	'forum-specialpage-blurb-heading' => '<span style="display:none">diễn đàn-trang đặc biệt-lời giới thiệu-Nhóm bạn có thể chỉnh sửa nó<span></span></span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|chủ đề|chủ đề}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|lần gửi|lần gửi}}',
	'forum-specialpage-board-lastpostby' => 'Viết lần cuối bởi',
	'forum-specialpage-policies-edit' => 'Sửa đổi',
	'forum-specialpage-policies' => 'Chính sách diễn đàn / Câu thường hỏi',
	'forum-policies-and-faq' => "== Chính sách diễn đàn ==
Trước khi đóng góp cho các diễn đàn trên {{SITENAME}}, hãy ghi nhớ một vài điều khi tham gia:

'''Hãy tôn trọng, lịch sự với mọi người'''
: Mọi người từ khắp thế giới đọc và chỉnh sửa wiki này và các diễn đàn của wiki. Giống như bất kỳ dự án hợp tác khác, không phải tất cả mọi người sẽ đồng ý theo mọi thời điểm. Giữ cuộc thảo luận nhân sự và được quyền suy nghĩ đầu óc về ý kiến khác nhau. Chúng tôi ở đây bởi vì chúng tôi đang cùng một chủ đề.

'''Hãy cố gắng tìm kiếm các cuộc thảo luận đầu tiên, nhưng đừng ngại để bắt đầu một chủ đề mới'''
: Xin vui lòng mất một chút thời gian để nghiên cứu tỉ mỉ thông qua diễn đàn {{SITENAME}} để xem nếu một cuộc thảo luận đã tồn tại về một cái gì đó mà bạn muốn nói. Nếu bạn không thể tìm thấy những gì bạn đang tìm kiếm, xin hãy bắt đầu một chủ đề mới để mọi người thảo luận.

'''Yêu cầu để được giúp đỡ'''
:Nếu bạn gặp trường hợp mà có vẻ không đúng? Hoặc bạn có một câu hỏi cần giải quyết? Hãy gửi những yêu cầu mới cho diễn đàn hoặc nếu bạn cần sự giúp đỡ của nhân viên Wikia, có lẽ hãy liên lạc tại [[w:c:community|trung tâm cộng đồng]], hoặc ghé thăm [http://vi.wikia.com trung tâm cộng đồng tiếng Việt], thao tác [[Special:Contact|liên lạc]] với nhân viên.

'''Niềm vui khi tham gia!'''
: Cộng đồng {{SITENAME}} rất hoan nghênh khi có bạn ở đây. Chúng tôi mong được nhìn thấy bạn xung quanh như chúng tôi đang thảo luận về chủ đề này.

==Những câu hỏi thường gặp==
'''Làm thế nào để tôi có thể nằm trên đầu trang của các cuộc thảo luận tôi quan tâm đến?'''
: Với trương mục người dùng Wikia, bạn có thể làm theo các cuộc hội thoại cụ thể và sau đó nhận thư thông báo (hoặc trang web, qua email) khi một cuộc thảo luận cần có thêm hoạt động. Hãy chắc chắn rằng [[Special:UserSignup|bạn đã đăng kí người dùng Wikia]] nếu bạn chưa có, tài khoản giúp bạn che giấu địa chỉ IP và không bị lộ trong cuộc thảo luận.

'''Làm thế nào để loại bỏ phá hoại?'''
: Nếu bạn thấy một số thư spam hoặc phá hoại trên một chủ đề, di chuyển chuột qua đề mục báo cáo vi phạm. Bạn sẽ thấy một nút \"Thêm\" xuất hiện. Bên trong trình đơn \"Nhiều hơn\", bạn sẽ tìm thấy \"Loại bỏ\". Điều này sẽ cho phép bạn để loại bỏ phá hoại và tùy chọn thông báo cho một bảo quản viên.

'''Nổi bật là gì?'''
: Nếu bạn tìm thấy một cuộc thảo luận cụ thể hoặc trả lời thú vị, hoặc bạn có thể thấy sự đánh giá trực tiếp bằng cách cho nó thêm nổi bật. Nó có thể hữu ích trong những tình huống, bỏ phiếu chủ đề.

'''Các chủ đề là gì?'''
: Chủ đề cho phép bạn liên kết một diễn đàn thảo luận với một bài viết wiki. Nó cũng là một cách để giữ cho diễn đàn, tổ chức và giúp mọi người tìm thấy cuộc thảo luận thú vị. Ví dụ, một chủ đề diễn đàn được dán nhãn \"Lord Voldemort\" sẽ xuất hiện ở dưới cùng của bài viết \"Lord Voldemort\".",
	'forum-board-title' => 'Board $1',
	'forum-board-topic-title' => 'Thảo luận về $1',
	'forum-board-topics' => 'Các chủ đề',
	'forum-board-thread-follow' => 'Theo dõi',
	'forum-board-thread-following' => 'Dừng theo dõi',
	'forum-board-thread-kudos' => '$1 nổi bật',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|tin nhắn|tin nhắn}}',
	'forum-board-new-message-heading' => 'Bắt đầu một cuộc thảo luận',
	'forum-no-board-selection-error' => '← Xin vui lòng chọn một Board để gửi',
	'forum-thread-reply-placeholder' => 'Viết trả lời',
	'forum-thread-reply-post' => 'Trả lời',
	'forum-thread-deleted-return-to' => 'Trở lại board $1',
	'forum-sorting-option-newest-replies' => 'Đặt bài trả lời',
	'forum-sorting-option-popular-threads' => 'Phổ biến nhất',
	'forum-sorting-option-most-replies' => 'Tích cực nhất trong 7 ngày',
	'forum-sorting-option-newest-threads' => 'Luồng mới nhất',
	'forum-sorting-option-oldest-threads' => 'Luồng cũ nhất',
	'forum-discussion-post' => 'Gửi',
	'forum-discussion-highlight' => 'Làm nổi bật cuộc thảo luận này',
	'forum-discussion-placeholder-title' => 'Bạn muốn chia sẻ điều gì về?',
	'forum-discussion-placeholder-message' => 'Gửi một tin nhắn mới đến tường $1 này',
	'forum-discussion-placeholder-message-short' => 'Gửi một tin nhắn mới',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|trả lời}} trong chủ đề của bạn trên board $3',
	'forum-notification-user2-reply-to-your' => '$1 và $2 phản hồi đến chủ đề của bạn trên board $3',
	'forum-notification-user3-reply-to-your' => '$1 và những người khác trả lời đến chủ đề của bạn trên board $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|phản hồi}} trên board $3',
	'forum-notification-user2-reply-to-someone' => '$1 và $2 phản hồi trên board $3',
	'forum-notification-user3-reply-to-someone' => '$1 và những người khác phản hồi trên board $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|đăng}} một bài viết mới trên board $2',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME đã viết một chủ đề mới tại board $BOARDNAME trên $WIKI.',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME đã viết một chủ đề mới tại board $BOARDNAME trên $WIKI.',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME trả lời chủ đề của bạn tại board $BOARDNAME trên $WIKI.',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME trả lời tại board $BOARDNAME trên $WIKI.',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME đã phản hồi tại board $BOARDNAME trên $WIKI.',
	'forum-mail-notification-html-greeting' => 'Chào $1,',
	'forum-mail-notification-html-button' => 'Xem cuộc hội thoại',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => 'Hi $WATCHER,

 $SUBJECT

 $METATITLE

 $MESSAGE_NO_HTML

-$AUTHOR

Xem cuộc trò chuyện: ($MESSAGE_LINK)

Đội Wikia

___________________________________________
*Để nhận được sự hỗ trợ tư vấn cho ngôn ngữ của bạn, truy cập http://congdong.wikia.com
*Muốn nhận được ít thư từ chúng tôi? Bạn có thể bỏ đăng ký hoặc thay đổi tuỳ chọn email của bạn ở đây: http://congdong.wikia.com/Đặc_biệt:Tùy_chọn',
	'forum-mail-notification-body-HTML' => 'Chào $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>--$AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Xem cuộc trò chuyện</a></p>
<p>Wikia Team</p>
___________________________________________<br />
*Để nhận được sự hỗ trợ và tư vấn cho ngôn ngữ của bạn, truy cập http://congdong.wikia.com
*Muốn nhận được ít thư từ chúng tôi? Bạn có thể bỏ đăng ký hoặc thay đổi tuỳ chọn email của bạn ở đây: http://congdong.wikia.com/Đặc_biệt:Tùy_chọn',
	'forum-wiki-activity-msg' => 'trên $1',
	'forum-wiki-activity-msg-name' => 'Board $1',
	'forum-activity-module-heading' => 'Hoạt động gần đây trên diễn đàn',
	'forum-related-module-heading' => 'Chủ đề liên quan',
	'forum-activity-module-posted' => '$1 gửi một trả lời cách đây $2',
	'forum-activity-module-started' => '$1 bắt đầu một cuộc thảo luận cách đây $2',
	'forum-contributions-line' => '[[$1|$2]] trên [[$3|tường của $4]]',
	'forum-recentchanges-new-message' => 'trên các [[$1|Board $2]]',
	'forum-recentchanges-edit' => 'sửa đổi tin nhắn',
	'forum-recentchanges-removed-thread' => 'dời bỏ các chủ đề "[[$1|$2]]" từ các [[$3|Board $4]]',
	'forum-recentchanges-removed-reply' => 'dời bỏ trả lời từ "[[$1|$2]]" từ [[$3|Board $4]]',
	'forum-recentchanges-restored-thread' => 'khôi phục các chủ đề "[[$1|$2]]" từ [[$3|Board $4]]',
	'forum-recentchanges-restored-reply' => 'khôi phục trả lời trên "[[$1|$2]]" tại [[$3|board $4]]',
	'forum-recentchanges-deleted-thread' => 'Xóa chủ đề "[[$1|$2]]" từ các [[$3|board $4]]',
	'forum-recentchanges-deleted-reply' => 'dời bỏ trả lời từ "[[$1|$2]]" từ [[$3|board $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Một bài đăng',
	'forum-recentchanges-namespace-selector-message-wall' => 'Diễn đàn Board',
	'forum-recentchanges-thread-group' => '$1 trên các [[$2| Board $3]]',
	'forum-recentchanges-history-link' => 'lịch sử board',
	'forum-recentchanges-thread-history-link' => 'lịch sử chủ đề',
	'forum-recentchanges-closed-thread' => 'đóng chủ đề "[[$1|$2]]" từ [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'Mở lại chủ đề "[[$1|$2]]" từ [[$3|$4]]',
	'forum-board-history-title' => 'lịch sử board',
	'forum-specialpage-oldforum-link' => 'Các diễn đàn cũ lưu trữ',
	'forum-admin-page-breadcrumb' => 'Quản lý Board',
	'forum-admin-create-new-board-label' => 'Tạo Board mới',
	'forum-admin-create-new-board-modal-heading' => 'Tạo một board mới',
	'forum-admin-create-new-board-title' => 'Tiêu đề Board',
	'forum-admin-create-new-board-description' => 'Mô tả của Board',
	'forum-admin-edit-board-modal-heading' => 'Chỉnh sửa Board: $1',
	'forum-admin-edit-board-title' => 'Tiêu đề Board',
	'forum-admin-edit-board-description' => 'Mô tả của Board',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Xóa Board: $1',
	'forum-admin-delete-board-title' => 'Xin vui lòng xác nhận bằng cách gõ tên của Board mà bạn muốn xóa:',
	'forum-admin-merge-board-warning' => 'Các chủ đề trên Board này sẽ được sáp nhập vào một Board hiện tại.',
	'forum-admin-merge-board-destination' => 'Chọn một Board để nhập đến:',
	'forum-admin-delete-and-merge-button-label' => 'Xóa và hợp nhất',
	'forum-admin-link-label' => 'Quản lý Board',
	'forum-autoboard-title-1' => 'Thảo luận chung',
	'forum-autoboard-body-1' => 'Board này là dành cho cuộc hội thoại chung về wiki.',
	'forum-autoboard-title-2' => 'Tin tức và thông báo',
	'forum-autoboard-body-2' => 'Tin tức nóng hổi và thông tin!',
	'forum-autoboard-title-3' => 'Mới trên $1',
	'forum-autoboard-body-3' => 'Bạn muốn chia sẻ điều gì đó vừa được đăng tải trên wiki này, hay chúc mừng ai đó cho một đóng góp xuất sắc nhất? Đây là nơi!',
	'forum-autoboard-title-4' => 'Câu hỏi và câu trả lời',
	'forum-autoboard-body-4' => 'Có một câu hỏi về wiki, hoặc chủ đề? Đặt câu hỏi của bạn ở đây!',
	'forum-autoboard-title-5' => 'Vui vẻ và trò chơi',
	'forum-autoboard-body-5' => 'Board này cho ra chủ đề hội thoại -- một nơi để vui chơi với bạn bè $1 của bạn.',
	'forum-board-destination-empty' => '(Xin vui lòng chọn board)',
	'forum-board-title-validation-invalid' => 'Tên Board chứa ký tự không hợp lệ',
	'forum-board-title-validation-length' => 'Tên Board nên chứa ít nhất 4 ký tự',
	'forum-board-title-validation-exists' => 'Tên của một Board bị trùng khớp với tên đã tồn tại',
	'forum-board-validation-count' => 'Số lượng tối đa của board là $1',
	'forum-board-description-validation-length' => 'Xin vui lòng viết một miêu tả cho board này',
	'forum-board-id-validation-missing' => 'ID của Board này bị thiếu',
	'forum-board-no-board-warning' => 'Chúng tôi không thể tìm thấy một board với tiêu đề đó. Dưới đây là danh sách các board diễn đàn.',
	'forum-old-notification-message' => 'Diễn đàn này đã được lưu trữ',
	'forum-old-notification-navigation-button' => 'Truy cập vào các diễn đàn mới',
	'forum-related-discussion-heading' => 'Thảo luận về $1',
	'forum-related-discussion-new-post-button' => 'Bắt đầu một cuộc thảo luận',
	'forum-related-discussion-new-post-tooltip' => 'Bắt đầu một cuộc thảo luận mới về $1',
	'forum-related-discussion-total-replies' => '$1 tin nhắn',
	'forum-related-discussion-see-more' => 'Xem thêm các cuộc thảo luận',
	'forum-confirmation-board-deleted' => "'''$1''' đã bị xóa.",
];

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = [
	'forum-recentchanges-edit' => 'רעדאקטירטע מעלדונג',
];

/** Chinese (中文)
 * @author Wikia
 */
$messages['zh'] = [
	'forum-forum-title' => '论坛',
	'forum-active-threads' => '$1 {{PLURAL:$1|条活跃讨论|条活跃讨论}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|条活跃讨论|条活跃讨论}}关于: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|条帖子<br />在此论坛上|条帖子<br />在此论坛上}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|条活跃<br />讨论|条活跃<br />讨论}}</span>',
	'forum-specialpage-heading' => '论坛',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading 您可以编辑<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|条帖子|条帖子}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|条话题|条话题}}',
	'forum-specialpage-board-lastpostby' => '最后发帖者',
	'forum-specialpage-policies-edit' => '编辑',
	'forum-specialpage-policies' => '论坛公约/问与答',
	'forum-policies-and-faq' => "==论坛公约==
在编辑{{SITENAME}}论坛之前,请阅读以下指导内容:

'''请尊重他人.'''
:全世界的维基用户都可以自由在论坛上进行编辑。就如同编辑许多维基一样，不是每个人都会具有相同的想法。所以请保持开放性的讨论但同时也尊重其他人的观点。不要忘记，我们聚在这里是因为我们为了共同的一个话题。

'''寻找存在的话题或者创建新的话题'''
:请大致浏览{{SITENAME}}论坛，看看是不是已经有其他人发表过类似的话题。如果没有，那就赶快发起一个新的讨论吧！

'''寻求帮助'''
:发现有些地方不对劲？或是有问题要问？赶快登陆论坛吧！如果你需要寻求维基员工的帮助，请登陆[[w:c:zh.community|社区中心]]或者[http://zh.community.wikia.com/wiki/Special:Contact 发送邮件]给我们。

'''畅所欲言'''
:{{SITENAME}}社区非常高兴有你的参与！赶快发起你感兴趣的话题，让大家一起参与讨论吧！

==论坛问与答==
'''我如何能够关注一个讨论？'''
: 通过使用维基的帐户，你可以关注某个话题。当这个话题更新以后，你会通过邮件或者在线消息收到通知。请一定确定首先要[[Special:UserSignup|注册一个维基帐户]]。

'''如何删除一些破坏内容?'''
: 在讨论的页面上，你可以点击\"更多\"按钮，之后点击\"移除\"选项。这允许你删除某个讨论内容同时也会告知管理员这项操作。

'''“赞”是什么？'''
: 如果你发现某个话题非常有趣，可以通过点“赞”来告诉其他人。

'''话题是什么？'''
: 话题允许你引导其他用户讨论维基上相同的主题类别或者编辑功能。比如说，以\"哈利波特\"为标签的所有讨论都将在出现在\"哈利波特\"文章\"中。", # Fuzzy
	'forum-board-title' => '$1个论坛条目',
	'forum-board-topic-title' => '关于$1的讨论',
	'forum-board-topics' => '话题',
	'forum-board-thread-follow' => '关注',
	'forum-board-thread-following' => '已关注',
	'forum-board-thread-kudos' => '$1赞',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|条消息|条消息}}',
	'forum-board-new-message-heading' => '发起讨论',
	'forum-no-board-selection-error' => '← 请选择你要发布讨论的条目',
	'forum-thread-reply-placeholder' => '发布回复',
	'forum-thread-reply-post' => '回复',
	'forum-thread-deleted-return-to' => '返回$1',
	'forum-sorting-option-newest-replies' => '最新回复',
	'forum-sorting-option-popular-threads' => '流行帖子',
	'forum-sorting-option-most-replies' => '7天之内最新回复',
	'forum-sorting-option-newest-threads' => '新帖',
	'forum-sorting-option-oldest-threads' => '旧贴',
	'forum-discussion-post' => '发布',
	'forum-discussion-highlight' => '突出此次讨论',
	'forum-discussion-placeholder-title' => '你想讨论的是？',
	'forum-discussion-placeholder-message' => '在$1上发布帖子',
	'forum-discussion-placeholder-message-short' => '发布一条新消息',
	'forum-notification-user1-reply-to-your' => '$1在$3上{{GENDER:$1|回复}}了你的帖子',
	'forum-notification-user2-reply-to-your' => '$1和$2在$3上回复了你的帖子',
	'forum-notification-user3-reply-to-your' => '$1和其他人在$3上回复了你的帖子',
	'forum-notification-user1-reply-to-someone' => '$1在$3进行{{GENDER:$1|回复}}',
	'forum-notification-user2-reply-to-someone' => '$1和$2在$3进行回复',
	'forum-notification-user3-reply-to-someone' => '$1和其他人在$3上进行回复',
	'forum-notification-newmsg-on-followed-wall' => '$1在$2上{{GENDER:$1|留了}}一条信息',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME在$WIKI\\的$BOARDNAME上发布了一条帖子',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME在$WIKI\\的$BOARDNAME上发布了一条帖子',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME在$WIKI\\的$BOARDNAME上回复了你的帖子',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME在$WIKI\\的$BOARDNAME上有回复',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME在$WIKI\\的$BOARDNAME上有回复',
	'forum-mail-notification-html-greeting' => '您好，$1,',
	'forum-mail-notification-html-button' => '查看讨论',
	'forum-mail-notification-subject' => '$1 -- $2',
	'forum-mail-notification-body' => '您好$WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

查看讨论: ($MESSAGE_LINK)

维基团队

___________________________________________
* 登陆维基中文社区中心寻求帮助: http://zh.community.wikia.com
* 不希望收到我们的邮件通知？您可以点击这里进行更改: http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => '您好$WATCHER,
<p>$SUBJECT.</p>
<p><a href=\\"$MESSAGE_LINK\\">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style=\\"padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;\\" href=\\"$MESSAGE_LINK\\">查看讨论n</a></p>
<p>维基团队</p>
___________________________________________<br />
* 登陆维基中文社区中心寻求帮助: http://zh.community.wikia.com
* 不希望收到我们的邮件通知？您可以点击这里进行更改: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => '在$1上',
	'forum-wiki-activity-msg-name' => '$1',
	'forum-activity-module-heading' => '论坛活动',
	'forum-related-module-heading' => '相关帖子',
	'forum-activity-module-posted' => '$1回复了$2',
	'forum-activity-module-started' => '$1发起了话题$2',
	'forum-contributions-line' => '[[$1|$2]]在[[$3|$4上]]',
	'forum-recentchanges-new-message' => '在[[$1|$2上]]',
	'forum-recentchanges-edit' => '编辑信息',
	'forum-recentchanges-removed-thread' => '从[[$3|$4]]移除"[[$1|$2]]"',
	'forum-recentchanges-removed-reply' => '从[[$3|$4]]的"[[$1|$2]]"移除回复',
	'forum-recentchanges-restored-thread' => '恢复[[$3|$4]]上的"[[$1|$2]]"',
	'forum-recentchanges-restored-reply' => '恢复[[$3|$4]]的"[[$1|$2]]"相关回复',
	'forum-recentchanges-deleted-thread' => '从[[$3|$4]]上删除帖子"[[$1|$2]]"',
	'forum-recentchanges-deleted-reply' => '删除[[$3|$4]]的"[[$1|$2]]"的相关回复',
	'forum-recentchanges-deleted-reply-title' => '一条发布的信息',
	'forum-recentchanges-namespace-selector-message-wall' => '论坛条目',
	'forum-recentchanges-thread-group' => '$1在[[$2|$3上]]',
	'forum-recentchanges-history-link' => '条目创建历史',
	'forum-recentchanges-thread-history-link' => '帖子创建历史',
	'forum-recentchanges-closed-thread' => '在[[$3|$4]]上关闭帖子"[[$1|$2]]"',
	'forum-recentchanges-reopened-thread' => '在[[$3|$4]]上重新开放帖子"[[$1|$2]]"',
	'forum-board-history-title' => '论坛条目历史',
	'forum-specialpage-oldforum-link' => '旧论坛存档',
	'forum-admin-page-breadcrumb' => '管理员设置',
	'forum-admin-create-new-board-label' => '创建新的条目',
	'forum-admin-create-new-board-modal-heading' => '创建新的条目',
	'forum-admin-create-new-board-title' => '标题',
	'forum-admin-create-new-board-description' => '描述',
	'forum-admin-edit-board-modal-heading' => '编辑条目: $1',
	'forum-admin-edit-board-title' => '标题',
	'forum-admin-edit-board-description' => '描述',
	'forum-admin-delete-and-merge-board-modal-heading' => '删除条目: $1',
	'forum-admin-delete-board-title' => '请输入条目名称以确认你确实希望删除它:',
	'forum-admin-merge-board-warning' => '这些帖子将被合并在另外一个条目里.',
	'forum-admin-merge-board-destination' => '选择条目进行合并:',
	'forum-admin-delete-and-merge-button-label' => '删除以及合并',
	'forum-admin-link-label' => '管理论坛条目',
	'forum-autoboard-title-1' => '常规讨论',
	'forum-autoboard-body-1' => '在这里发表与此维基相关的常规话题。',
	'forum-autoboard-title-2' => '公告区',
	'forum-autoboard-body-2' => '所有最新的消息都在这里!',
	'forum-autoboard-title-3' => '$1新鲜事',
	'forum-autoboard-body-3' => '想分享这个维基上的最新进展？或者想赞许某位用户的用心编辑？这里是最合适的地方!',
	'forum-autoboard-title-4' => '问与答',
	'forum-autoboard-body-4' => '对这个维基有疑问？赶快发帖吧。',
	'forum-autoboard-title-5' => '灌水区',
	'forum-autoboard-body-5' => '来这里认识$1上的新朋友吧！一起灌灌水！',
	'forum-board-destination-empty' => '(请选择条目)',
	'forum-board-title-validation-invalid' => '条目包含无效字符',
	'forum-board-title-validation-length' => '条目名称至少四个字符',
	'forum-board-title-validation-exists' => '同样的条目名称已存在',
	'forum-board-validation-count' => '最多允许创建$1个条目',
	'forum-board-description-validation-length' => '请描述这个条目',
	'forum-board-id-validation-missing' => '条目缺失',
	'forum-board-no-board-warning' => '我们找不到相关条目。请查阅论坛条目列表。',
	'forum-old-notification-message' => '这个论坛已经被存档',
	'forum-old-notification-navigation-button' => '访问新的论坛',
	'forum-related-discussion-heading' => '关于$1的讨论',
	'forum-related-discussion-new-post-button' => '发起讨论',
	'forum-related-discussion-new-post-tooltip' => '发起关于$1的最新讨论',
	'forum-related-discussion-total-replies' => '$1条信息',
	'forum-related-discussion-see-more' => '查看更多讨论',
	'forum-confirmation-board-deleted' => '"$1"已经被删除。',
];

/** Simplified Chinese (中文（简体）‎)
 * @author Byfserag
 * @author Dimension
 * @author Ffaarr
 * @author Hzy980512
 * @author Liuxinyu970226
 * @author Liye
 * @author User670839245
 * @author Yfdyh000
 * @author 御坂美琴
 */
$messages['zh-hans'] = [
	'forum-desc' => 'Wikia的 特殊:论坛 扩展',
	'forum-disabled-desc' => 'Wikia的 特殊:论坛 扩展；已禁用',
	'forum-forum-title' => '论坛',
	'forum-active-threads' => '$1{{PLURAL:$1|条活跃讨论|条活跃讨论}}',
	'forum-active-threads-on-topic' => "$1{{PLURAL:$1|条活跃讨论|条活跃讨论}}有关：'''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>在此论坛上<br />条帖子</span>',
	'forum-header-active-threads' => '<em>$1</em><span>条活跃的<br />讨论</span>',
	'forum-specialpage-heading' => '论坛',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading 您可以编辑它<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|thread|threads}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|帖子|帖子}}',
	'forum-specialpage-board-lastpostby' => '最后发帖者',
	'forum-specialpage-policies-edit' => '编辑',
	'forum-specialpage-policies' => '论坛方针/常见问题',
	'forum-policies-and-faq' => "==论坛公约==
在编辑{{SITENAME}}论坛之前，请阅读以下指导内容：

'''请尊重他人。'''
:全世界的维基用户都可以自由在论坛上进行编辑。就如同编辑许多维基一样，不是每个人都会具有相同的想法。所以请保持开放性的讨论但同时也尊重其他人的观点。不要忘记，我们聚在这里是因为我们为了共同的一个话题。

'''寻找存在的话题或者创建新的话题。'''
:请大致浏览{{SITENAME}}论坛，看看是不是已经有其他人发表过类似的话题。如果没有，那就赶快发起一个新的讨论吧！

'''寻求帮助。'''
:发现有些地方不对劲？或是有问题要问？赶快登陆论坛吧！如果你需要寻求维基员工的帮助，请登陆[[w:c:community|社区中心]]或者[[Special:Contact|发送邮件]]给我们。

'''畅所欲言！'''
:{{SITENAME}}社区非常高兴有你的参与！赶快发起你感兴趣的话题，让大家一起参与讨论吧！

==论坛问与答==
'''我如何能够关注一个讨论？'''
: 通过使用维基的帐户，你可以关注某个话题。当这个话题更新以后，你会通过邮件或者在线消息收到通知。请一定确定首先要[[Special:UserSignup|注册一个维基帐户]]。

'''如何删除一些破坏内容?'''
: 在讨论的页面上，你可以点击\"更多\"按钮，之后点击\"移除\"选项。这允许你删除某个讨论内容同时也会告知管理员这项操作。

'''“赞”是什么？'''
: 如果你发现某个话题非常有趣，可以通过点“赞”来告诉其他人。

'''话题是什么？'''
: 话题允许你引导其他用户讨论维基上相同的主题类别或者编辑功能。比如说，以\"哈利波特\"为标签的所有讨论都将在出现在\"哈利波特\"文章\"中。",
	'forum-board-title' => '$1板面',
	'forum-board-topic-title' => '有关$1的讨论',
	'forum-board-topics' => '主题',
	'forum-board-thread-follow' => '关注',
	'forum-board-thread-following' => '关注中',
	'forum-board-thread-kudos' => '$1荣誉',
	'forum-board-thread-replies' => '$1条信息',
	'forum-board-new-message-heading' => '发起讨论',
	'forum-no-board-selection-error' => '← 请选择你要发布讨论的板块',
	'forum-thread-reply-placeholder' => '发表回复',
	'forum-thread-reply-post' => '回复',
	'forum-thread-deleted-return-to' => '返回$1板块',
	'forum-sorting-option-newest-replies' => '最新回复',
	'forum-sorting-option-popular-threads' => '最多回复',
	'forum-sorting-option-most-replies' => '7天内最活跃',
	'forum-sorting-option-newest-threads' => '最新的帖子',
	'forum-sorting-option-oldest-threads' => '最旧的帖子',
	'forum-discussion-post' => '发布',
	'forum-discussion-highlight' => '高亮此讨论',
	'forum-discussion-placeholder-title' => '您希望谈论些什么？',
	'forum-discussion-placeholder-message' => '发送一条新信息至$1板面',
	'forum-discussion-placeholder-message-short' => '创建新消息',
	'forum-notification-user1-reply-to-your' => '$1在$3板块{{GENDER:$1|回复了}}您的帖子',
	'forum-notification-user2-reply-to-your' => '$1和$2在$3的讨论版上回复了你',
	'forum-notification-user3-reply-to-your' => '$1与其他用户回复了您在$3板块的帖子',
	'forum-notification-user1-reply-to-someone' => '$1在$3板块{{GENDER:$1|作出回答}}',
	'forum-notification-user2-reply-to-someone' => '$1和$2在$3的讨论板上做出了回复',
	'forum-notification-user3-reply-to-someone' => '$1等人$3讨论版上做出了回复',
	'forum-notification-newmsg-on-followed-wall' => '$1在$2板块发送了一条消息',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME在$WIKI的$BOARDNAME板块写了一个新回复。',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME在$WIKI的$BOARDNAME板块写了一个新回复。',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME在$WIKI的$BOARDNAME板块回复了您的帖子',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME在$WIKI的$BOARDNAME板块作出回答',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME在$WIKI的$BOARDNAME板块作出回答',
	'forum-mail-notification-html-greeting' => 'Hi $1，',
	'forum-mail-notification-html-button' => '查看会话',
	'forum-mail-notification-subject' => '$1——$2',
	'forum-mail-notification-body' => '嗨！$WATCHER

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

见对话：（$MESSAGE_LINK）

Wikia团队

___________________________________________
* 在社群中心寻求帮助和建议：http://community.wikia.com
* 希望订阅来自我们的少量信息？您可通过下面链接退订或更改您的电子邮件设置：http://community.wikia.com/Special:Preferences',
	'forum-mail-notification-body-HTML' => '嗨！$WATCHER
<p>$SUBJECT。</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">见对话</a></p>
<p>Wikia团队</p>
___________________________________________<br />
* 在社群中心寻求帮助和建议：http://community.wikia.com
* 希望订阅来自我们的少量信息？您可通过下面链接退订或更改您的电子邮件设置：http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => '在$1',
	'forum-wiki-activity-msg-name' => '$1板面',
	'forum-activity-module-heading' => '论坛活动',
	'forum-related-module-heading' => '相关讨论',
	'forum-activity-module-posted' => '$1在$2发布了一条回复',
	'forum-activity-module-started' => '$1发起了讨论$2',
	'forum-contributions-line' => '[[$1|$2]]在[[$3|$4板面]]',
	'forum-recentchanges-new-message' => '在[[$1|$2板面]]',
	'forum-recentchanges-edit' => '编辑信息',
	'forum-recentchanges-removed-thread' => '已从[[$3|$4 板块]]移除回复“[[$1|$2]]”',
	'forum-recentchanges-removed-reply' => '从[[$3|$4板块]]的“[[$1|$2]]”移除回复',
	'forum-recentchanges-restored-thread' => '恢复帖子“[[$1|$2]]”至[[$3|$4板块]]',
	'forum-recentchanges-restored-reply' => '恢复在“[[$1|$2]]”的回复至[[$3|$4板块]]',
	'forum-recentchanges-deleted-thread' => '从[[$3|$4板块]]删除帖子“[[$1|$2]]”',
	'forum-recentchanges-deleted-reply' => '从[[$3|$4板块]]删除来自“[[$1|$2]]”的回复',
	'forum-recentchanges-deleted-reply-title' => '一个主题',
	'forum-recentchanges-namespace-selector-message-wall' => '论坛讨论区',
	'forum-recentchanges-thread-group' => '$1 在[[$2|$3 板块]]',
	'forum-recentchanges-history-link' => '板面历史',
	'forum-recentchanges-thread-history-link' => '帖子历史',
	'forum-recentchanges-closed-thread' => '从[[$3|$4]]关闭帖子“[[$1|$2]]”',
	'forum-recentchanges-reopened-thread' => '从[[$3|$4]]重启帖子“[[$1|$2]]”',
	'forum-board-history-title' => '板面历史',
	'forum-specialpage-oldforum-link' => '旧论坛存档',
	'forum-admin-page-breadcrumb' => '管理员面板管理',
	'forum-admin-create-new-board-label' => '创建新板面',
	'forum-admin-create-new-board-modal-heading' => '创建新板面',
	'forum-admin-create-new-board-title' => '板块标题',
	'forum-admin-create-new-board-description' => '版块描述',
	'forum-admin-edit-board-modal-heading' => '编辑板块：$1',
	'forum-admin-edit-board-title' => '板块标题',
	'forum-admin-edit-board-description' => '版块描述',
	'forum-admin-delete-and-merge-board-modal-heading' => '删除板块：$1',
	'forum-admin-delete-board-title' => '请输入板块名以确认您想删除：',
	'forum-admin-merge-board-warning' => '此版块的帖子将与一个现有版块合并。',
	'forum-admin-merge-board-destination' => '选择板块合并至：',
	'forum-admin-delete-and-merge-button-label' => '删除与合并',
	'forum-admin-link-label' => '管理版块',
	'forum-autoboard-title-1' => '一般讨论',
	'forum-autoboard-body-1' => '此板块是有关于此wiki的一般话题。',
	'forum-autoboard-title-2' => '新闻和公告',
	'forum-autoboard-body-2' => '重大消息信息',
	'forum-autoboard-title-3' => '$1上的新鲜事',
	'forum-autoboard-body-3' => '想要分享刚在此wiki上发出的内容，或者想表扬某人作出的杰出贡献吗？就在这里！',
	'forum-autoboard-title-4' => '问答',
	'forum-autoboard-body-4' => '对这个wiki或者这个主题有问题？在这里提问！',
	'forum-autoboard-title-5' => '娱乐与游戏',
	'forum-autoboard-body-5' => '此板块用于题外话——可以与你的 $1 朋友闲聊的地方。',
	'forum-board-destination-empty' => '（请选择面板）',
	'forum-board-title-validation-invalid' => '版块名称包含无效字符',
	'forum-board-title-validation-length' => '板块名应至少4个字符长',
	'forum-board-title-validation-exists' => '已存在同名板块',
	'forum-board-validation-count' => '板块最多可以有$1个',
	'forum-board-description-validation-length' => '请写下此板块的描述',
	'forum-board-id-validation-missing' => '板块ID丢失',
	'forum-board-no-board-warning' => '我们找不到那个标题的板块。这里是论坛板块列表。',
	'forum-old-notification-message' => '本论坛已存档',
	'forum-old-notification-navigation-button' => '访问新论坛',
	'forum-related-discussion-heading' => '关于$1的讨论',
	'forum-related-discussion-new-post-button' => '开始讨论',
	'forum-related-discussion-new-post-tooltip' => '开始讨论$1',
	'forum-related-discussion-total-replies' => '$1条信息',
	'forum-related-discussion-see-more' => '参阅更多讨论',
	'forum-confirmation-board-deleted' => '“$1”已被删除。',
	'forum-token-mismatch' => '呀！令牌不匹配',
];

/** Traditional Chinese (中文（繁體）‎)
 * @author Cwlin0416
 * @author Ffaarr
 * @author LNDDYL
 * @author Liuxinyu970226
 */
$messages['zh-hant'] = [
	'forum-desc' => 'Wikia 的 Special:Forum 擴充套件',
	'forum-disabled-desc' => 'Wikia 的 Special:Forum 擴充套件，已停用',
	'forum-forum-title' => '論壇',
	'forum-active-threads' => '$1 {{PLURAL:$1|條活躍討論串|條活躍討論串}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|條活躍討論串|條活躍討論串}}關於：'''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span> {{PLURAL:$1|條討論串<br />於此論壇|條討論串<br />於此論壇}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span> {{PLURAL:$1|條活躍的<br />討論串|條活躍的<br />討論串}}</span>',
	'forum-specialpage-heading' => '論壇',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading 您可以編輯它<span>',
	'forum-specialpage-board-threads' => '$1 條{{PLURAL:$1|thread|討論串}}',
	'forum-specialpage-board-posts' => '$1 篇{{PLURAL:$1|文章|文章}}',
	'forum-specialpage-board-lastpostby' => '最後發佈由',
	'forum-specialpage-policies-edit' => '編輯',
	'forum-specialpage-policies' => '論壇政策/常見問題',
	'forum-policies-and-faq' => "==论坛公约==
在编辑{{SITENAME}}论坛之前,请阅读以下指导内容:

'''请尊重他人.'''
:全世界的維基使用者都可以自由在論壇上進行編輯。就如同編輯許多維基一樣，不是每個人都會具有相同的想法。所以請保持開放性的討論，但同時也尊重其他人的觀點。不要忘记，我們聚在這裡因為我們為了共同的一個話題。

'''尋找存在的話題或者建立新的話題'''
:請大致瀏覽{{SITENAME}}論壇，看看是不是已经有其他人發表過類似的話題。如果没有，那就趕快發起一個新的討論吧！

'''尋求幫助'''
:發現有些地方不對勁？或是有問題要問？趕快來論壇發問吧！如果你需要尋求維基員工的幫助，請到[[w:c:zh.community|社區中心]]或者[http://zh.community.wikia.com/wiki/Special:Contact 發送郵件]给我們。

'''暢所欲言'''
:{{SITENAME}}社區非常高興有你的参與！趕快發起你感兴興趣的話题，讓大家一起參與討論吧！

==論壇問與答==
'''我如何能够關注一個討論？'''
: 有维基的帳號的使用者，可以關注某個话题。當這個話題更新時，你會透過電子郵件或在線消息收到通知。請一定確定首先要[[Special:UserSignup|註册一個維基帳號]]。

'''如何删除一些破壞内容?'''
: 在討論的頁面上，你可以點選\"更多\"按钮，之言點選\"移除\"選項。這允許你删除某個討論内容同時也可以選擇告知管理員這項操作。

''' \"讚\" 是什麼？'''
: 如果你發現某個話題非常有趣，可以透過點 \"讚\" 来告訴其他人。

'''主題是什麼？'''
: 主題允許你引導一個論壇討論與一個維基文章連結。這是另一個組織論壇文章的方式，也幫助使用者們找到該討論。例如，以\"哈利波特\"為標籤的討論，會出弄在\"哈利波特\"文章\"的底部。", # Fuzzy
	'forum-board-title' => '$1 討論板',
	'forum-board-topic-title' => '關於 $1 的討論',
	'forum-board-topics' => '主題',
	'forum-board-thread-follow' => '關注',
	'forum-board-thread-following' => '關注中',
	'forum-board-thread-kudos' => '$1 讚',
	'forum-board-thread-replies' => '$1 則訊息',
	'forum-board-new-message-heading' => '發起討論',
	'forum-no-board-selection-error' => '← 請選擇你要發布討論的討論板',
	'forum-thread-reply-placeholder' => '發表回覆',
	'forum-thread-reply-post' => '回覆',
	'forum-thread-deleted-return-to' => '返回 $1 討論板',
	'forum-sorting-option-newest-replies' => '最新回覆',
	'forum-sorting-option-popular-threads' => '最多回覆',
	'forum-sorting-option-most-replies' => '在 7 天內最活躍',
	'forum-sorting-option-newest-threads' => '最新的討論串',
	'forum-sorting-option-oldest-threads' => '最舊的討論串',
	'forum-discussion-post' => '發表',
	'forum-discussion-highlight' => '突出顯示此討論',
	'forum-discussion-placeholder-title' => '您希望討論些什麼？',
	'forum-discussion-placeholder-message' => '發布新訊息至 $1 討論板',
	'forum-discussion-placeholder-message-short' => '發布新訊息',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|回覆了}} 你在討論板 $3 上的討論串',
	'forum-notification-user2-reply-to-your' => '$1 和 $2 在 $3 討論板上回覆了你的討論串',
	'forum-notification-user3-reply-to-your' => '$1 和其他人回覆了你在 $3 討論板上的討論串',
	'forum-notification-user1-reply-to-someone' => '$1 在 $3 討論板上{{GENDER:$1|回覆了}}',
	'forum-notification-user2-reply-to-someone' => '$1 和 $2 在 $3 討論板上回覆了',
	'forum-notification-user3-reply-to-someone' => '$1 和其他人在 $3 board 上回覆了。',
	'forum-notification-newmsg-on-followed-wall' => '$1 在 $2 討論板上{{GENDER:$1|留下}}新的訊息。',
	'forum-mail-notification-new-someone' => '$AUTHOR_NAME 在 $WIKI 的 $BOARDNAME 討論板上開啟了一個新的討論串。',
	'forum-mail-notification-new-your' => '$AUTHOR_NAME 在 $WIKI 的 $BOARDNAME 討論板上開啟了一個新的討論串。',
	'forum-mail-notification-reply-your' => '$AUTHOR_NAME 回覆了你在 $WIKI 的 $BOARDNAME 討論板上的討論串',
	'forum-mail-notification-reply-his' => '$AUTHOR_NAME 在 $WIKI\'s $BOARDNAME 討論板回覆了。',
	'forum-mail-notification-reply-someone' => '$AUTHOR_NAME 在 $WIKI 的 $BOARDNAME 討論板回覆了。',
	'forum-mail-notification-html-greeting' => 'Hi $1，',
	'forum-mail-notification-html-button' => '查看對話',
	'forum-mail-notification-subject' => '$1——$2',
	'forum-wiki-activity-msg' => '在 $1',
	'forum-wiki-activity-msg-name' => '$1 討論板',
	'forum-activity-module-heading' => '論壇活動',
	'forum-related-module-heading' => '相關討論',
	'forum-activity-module-posted' => '$1 在 $2 發布了一條回覆',
	'forum-activity-module-started' => '$1 在 $2 發起了一個討論',
	'forum-contributions-line' => '[[$1|$2]] 在 [[$3|$4 討論板]]',
	'forum-recentchanges-new-message' => '在[[$1|$2 討論板]]',
	'forum-recentchanges-edit' => '編輯訊息',
	'forum-recentchanges-removed-thread' => ' 從[[$3|$4 討論板]]移除討論串 "[[$1|$2]]"',
	'forum-recentchanges-removed-reply' => '從[[$3|$4 討論板]]移除 "[[$1|$2]]"討論串',
	'forum-recentchanges-restored-thread' => '將討論串 "[[$1|$2]]" 儲存到 [[$3|$4 討論板]]',
	'forum-recentchanges-restored-reply' => '在[[$3|$4 討論板]]儲存對 "[[$1|$2]]" 的回覆',
	'forum-recentchanges-deleted-thread' => '從[[$3|$4 討論板]]刪除討論串"[[$1|$2]]"',
	'forum-recentchanges-deleted-reply' => '從[[$3|$4 討論板]]刪除"[[$1|$2]]"的回覆',
	'forum-recentchanges-deleted-reply-title' => '一個主題',
	'forum-recentchanges-namespace-selector-message-wall' => '論壇討論板',
	'forum-recentchanges-thread-group' => '位於[[$2|$3 討論板]]的 $1',
	'forum-recentchanges-history-link' => '討論板歷史',
	'forum-recentchanges-thread-history-link' => '討論串歷史',
	'forum-recentchanges-closed-thread' => '關閉[[$3|$4]]的討論串 "[[$1|$2]]"',
	'forum-recentchanges-reopened-thread' => '重新開啟 [[$3|$4]] 的討論串 "[[$1|$2]]"',
	'forum-board-history-title' => '討論板歷史',
	'forum-specialpage-oldforum-link' => '舊論壇存檔',
	'forum-admin-page-breadcrumb' => '管理員討論板管理',
	'forum-admin-create-new-board-label' => '建立新討論板',
	'forum-admin-create-new-board-modal-heading' => '建立一個新的討論板',
	'forum-admin-create-new-board-title' => '討論板標題',
	'forum-admin-create-new-board-description' => '討論板描述',
	'forum-admin-edit-board-modal-heading' => '編輯討論板: $1',
	'forum-admin-edit-board-title' => '討論板標題',
	'forum-admin-edit-board-description' => '討論板描述',
	'forum-admin-delete-and-merge-board-modal-heading' => '刪除討論板：$1',
	'forum-admin-delete-board-title' => '請鍵入您想要刪除的板的名稱來確認您想要刪除：',
	'forum-admin-merge-board-warning' => '這個討論板的討論串會併入一個現有的討論板',
	'forum-admin-merge-board-destination' => '選擇一個要併入的討論板:',
	'forum-admin-delete-and-merge-button-label' => '刪除並合併',
	'forum-admin-link-label' => '管理討論板',
	'forum-autoboard-title-1' => '一般性討論',
	'forum-autoboard-body-1' => '這個討論板是討論這個 wiki 上的一般性話題',
	'forum-autoboard-title-2' => '新聞和公告',
	'forum-autoboard-body-2' => '最新消息和資訊 ！',
	'forum-autoboard-title-3' => '$1 的新事物',
	'forum-autoboard-body-3' => '想要分享 wiki 上新增的內容，或表揚其他人的傑出貢獻嗎？就在這裡 ！',
	'forum-autoboard-title-4' => '問題與解答',
	'forum-autoboard-body-4' => '有關於這個 wiki 或這個主題的問題嗎？在這裡提出你的問題！',
	'forum-autoboard-title-5' => '娛樂和遊戲',
	'forum-autoboard-body-5' => '這個討論板是與本站主題不相關的聊天－可以和你的 $1 朋友一起閒逛。',
	'forum-board-destination-empty' => ' (請選擇討論板)',
	'forum-board-title-validation-invalid' => '討論板名稱包含無效字元',
	'forum-board-title-validation-length' => '討論板名稱應至少 4 個字元以上',
	'forum-board-title-validation-exists' => '已存在相同名稱的討論板',
	'forum-board-validation-count' => '討論板的上限數量是 $1',
	'forum-board-description-validation-length' => '請寫此討論板的描述',
	'forum-board-id-validation-missing' => '討論板 ID 消失',
	'forum-board-no-board-warning' => '我們無法找到該標題的討論板。這是論壇上討論板的清單。',
	'forum-old-notification-message' => '本論壇已存檔',
	'forum-old-notification-navigation-button' => '訪問新論壇',
	'forum-related-discussion-heading' => '關於 $1 的討論',
	'forum-related-discussion-new-post-button' => '發起討論',
	'forum-related-discussion-new-post-tooltip' => '發起關於 $1 的討論',
	'forum-related-discussion-total-replies' => '$1 條訊息',
	'forum-related-discussion-see-more' => '請參考更多討論',
	'forum-confirmation-board-deleted' => ' "$1" 已被删除。',
];
