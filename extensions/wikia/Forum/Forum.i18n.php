<?php
$messages = array();

$messages['en'] = array(
	'forum-desc' => "Wikia's Special:Forum extension",
	'forum-disabled-desc' => "Wikia's Special:Forum extension; disabled",
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '$1 {{PLURAL:$1|Active Discussion|Active Discussions}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Active Discussion|Active Discussions}} about: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Thread<br />in this Forum|Threads<br />in this Forum}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Active<br />Discussion|Active<br />Discussions}}</span>',
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
:Notice something that doesn't seem right? Or do you have a question? Ask for help here on the forums! If you need help from FANDOM staff, please reach out on [[w:c:community|Community Central]] or via [[Special:Contact]].

'''Have fun!'''
:The {{SITENAME}} community is happy to have you here. We look forward to seeing you around as we discuss this topic we all love.

==Forum FAQ==
'''How do I stay on top of discussions I'm interested in?'''
: With a FANDOM user account, you can follow specific conversations and then receive notification messages (either on-site or via email) when a discussion has more activity. Be sure to [[Special:UserSignup|sign up for a FANDOM account]] if you don't already have one.

'''How do I remove vandalism?'''
: If you notice some spam or vandalism on a thread, hover your mouse over the offending text. You'll see a \"More\" button appear. Inside the \"More\" menu, you'll find \"Remove\". This will allow you to remove the vandalism and optionally inform an admin.

'''What are Kudos?'''
: If you find a particular discussion or reply interesting, well thought out, or amusing you can show direct appreciation by giving it Kudos. They can be helpful in voting situations, too.

'''What are Topics?'''
: Topics allow you to link a forum discussion with a wiki article. It's another way to keep Forums organized and to help people find interesting discussions. For example, a Forum thread tagged with ''Lord Voldemort'' will appear at the bottom of the ''Lord Voldemort'' article.",
	'forum-board-title' => '$1 board',
	'forum-board-topic-title' => 'Discussions about $1',
	'forum-board-topics' => 'Topics',
	'forum-board-thread-follow' => 'Follow',
	'forum-board-thread-following' => 'Following',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Message|Messages}}',
	'forum-board-new-message-heading' => 'Start a Discussion',
	'forum-no-board-selection-error' => '← Please select a board to post to',
	'forum-thread-reply-placeholder' => 'Post a reply',
	'forum-thread-reply-post' => 'Reply',
	'forum-thread-deleted-return-to' => 'Return to $1 board',
	'forum-sorting-option-newest-replies' => 'Most Recent Replies',
	'forum-sorting-option-popular-threads' => 'Most Popular',
	'forum-sorting-option-most-replies' => 'Most Active in 7 Days',
	'forum-sorting-option-newest-threads' => 'Newest Threads',
	'forum-sorting-option-oldest-threads' => 'Oldest Threads',
	'forum-discussion-post' => 'Post',
	'forum-discussion-highlight' => 'Highlight this discussion',
	'forum-discussion-placeholder-title' => 'What do you want to talk about?',
	'forum-discussion-placeholder-message' => 'Post a new message to the $1 board',
	'forum-discussion-placeholder-message-short' => 'Post a new message',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|replied}} to your thread on the $3 board',
	'forum-notification-user2-reply-to-your' => '$1 and $2 replied to your thread on the $3 board',
	'forum-notification-user3-reply-to-your' => '$1 and others replied to your thread the $3 board',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|replied}} on the $3 board',
	'forum-notification-user2-reply-to-someone' => '$1 and $2 replied on the $3 board',
	'forum-notification-user3-reply-to-someone' => '$1 and others replied on the $3 board',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|left}} a new message on the $2 board',
	'forum-wiki-activity-msg' => 'on the $1',
	'forum-wiki-activity-msg-name' => '$1 board',
	'forum-activity-module-heading' => 'Forum Activity',
	'forum-related-module-heading' => 'Related Threads',
	'forum-activity-module-posted' => '$1 posted a reply $2',
	'forum-activity-module-started' => '$1 started a discussion $2',
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
	'forum-board-history-title' => 'board history',
	'forum-specialpage-oldforum-link' => 'Old forum Archives',
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
	'forum-board-destination-empty' => '(Please select board)',
	'forum-board-title-validation-invalid' => 'Board name contains invalid characters',
	'forum-board-title-validation-length' => 'Board name should be at least 4 characters long',
	'forum-board-title-validation-exists' => 'A Board of the same name already exists',
	'forum-board-validation-count' => 'The maximum number of boards is $1',
	'forum-board-description-validation-length' => 'Please write a description for this board',
	'forum-board-id-validation-missing' => 'Board id is missing',
	'forum-board-no-board-warning' => 'There is no Forum Board with that title. Please try again or check out this list of Forum Boards.',
	'forum-related-discussion-heading' => 'Discussions about $1',
	'forum-related-discussion-new-post-button' => 'Start a Discussion',
	'forum-related-discussion-new-post-tooltip' => 'Start a new discussion about $1',
	'forum-related-discussion-total-replies' => '$1 messages',
	'forum-related-discussion-see-more' => 'See more discussions',
	'forum-confirmation-board-deleted' => '"$1" has been deleted.',
	'forum-token-mismatch' => "Oops! Token doesn't match",
	'right-forumadmin' => 'Has admin access to the forums',
	'right-forumoldedit' => 'Can edit the old, archived forums',
	'right-boardedit' => 'Edit Forum board information',
);

$messages['qqq'] = array(
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
	'forum-policies-and-faq' => 'Missing documentation',
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
	'forum-related-discussion-heading' => 'Section heading for related discussion section.  $1 is article that this section will be on.',
	'forum-related-discussion-new-post-button' => 'Text of the button that appears in the related forums module at the bottom of article pages.',
	'forum-related-discussion-new-post-tooltip' => 'Text of the button that appears in the related forums module at the bottom of article pages. Parameters:
* $1 is the title of the article',
	'forum-related-discussion-total-replies' => 'Label showing total number of replies in a discussion.  $1 is number of replies',
	'forum-related-discussion-see-more' => 'See More link to topic page',
	'forum-confirmation-board-deleted' => 'Board delete confirmation message. $1 is board name',
	'forum-token-mismatch' => "Shown when hidden token (to prevent hijacking) sent to the backend doesn't match the one stored in user's session",
);

$messages['ang'] = array(
	'forum-specialpage-policies-edit' => 'Adihtan',
);

$messages['ar'] = array(
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
	'forum-related-discussion-heading' => 'نقاشات حول $1',
	'forum-related-discussion-new-post-button' => 'ابدأ نقاشًا جديدًا',
	'forum-related-discussion-new-post-tooltip' => 'ابدأ نقاشًا جديدًا عن $1',
	'forum-related-discussion-total-replies' => '$1 رسائل',
	'forum-related-discussion-see-more' => 'رؤية المزيد من النقاشات',
	'forum-confirmation-board-deleted' => '"$1" قد حُذفت.',
	'forum-token-mismatch' => 'عفوا! الرمز المميز لا يتطابق',
);

$messages['az'] = array(
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
);

$messages['bg'] = array(
	'forum-forum-title' => 'Форум',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-policies-edit' => 'Редактиране',
	'forum-admin-delete-and-merge-button-label' => 'Изтриване и обединяване',
);

$messages['br'] = array(
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
	'forum-related-discussion-heading' => 'Kaozioù diwar-benn $1',
	'forum-related-discussion-new-post-button' => 'Kregiñ gant ur gaoz',
	'forum-related-discussion-new-post-tooltip' => 'Kregiñ gant ur gaoz nevez diwaer-benn $1',
	'forum-related-discussion-total-replies' => '$1 kemennadenn',
	'forum-related-discussion-see-more' => "Gwelet muioc'h a gaozioù",
	'forum-confirmation-board-deleted' => 'Dilamet eo bet "$1".',
	'forum-token-mismatch' => 'Pop ! Ar jedouer ne glot ket',
);

$messages['bto'] = array(
	'forum-specialpage-policies-edit' => 'Balyowan',
	'forum-mail-notification-html-greeting' => 'Unta $1,',
	'forum-mail-notification-subject' => '$1 -- $2',
);

$messages['ca'] = array(
	'forum-desc' => 'Extensió Especial:Forum de Wikia',
	'forum-disabled-desc' => 'Extensió Especial:Forum de Wikia; desactivada',
	'forum-forum-title' => 'Índex',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Tema actiu|Temes actius}}',
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|Tema actiu|Temes actius}} sobre: $2',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Tema<br> en aquest fòrum|Temes<br> en aquest fòrum}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Tema<br> Actiu|Temes<br> Actius}}</span>',
	'forum-specialpage-heading' => 'Fòrum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Pots editar-ho<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|tema|temes}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|missatge|missatges}}',
	'forum-specialpage-board-lastpostby' => 'Últim missatge escrit per',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Polítiques del Fòrum / FAQ',
	'forum-policies-and-faq' => "==Polítiques del fòrum==
Abans de contribuir al fòrum de {{SITENAME}} tingues en compte les següents pràctiques:

'''Tracta a la gent amb respecte i no tinguis males intencions.'''
: Persones de tot arreu llegeixen i editen en aquest wiki i aquest fòrum. Com qualsevol projecte col·laboratiu, no tothom estarà d'acord permanentment amb el que es discuteixi, així que obra la teva ment a diferents opinions. Estem aquí perquè ens agrada el mateix.

'''Intenta trobar discussions existents primer, però no tinguis por de iniciar un nou tema.'''
: Si us plau, dedica un moment en visitar els subfòrums d'aquest wiki i veure si ja existeix una discussió sobre el que vols parlar. Si no pots trobar el que busques, comença un nou tema!

'''Demana ajuda.'''
: Alguna cosa no es veu com ho hauria de fer? Tens alguna pregunta? Demana ajuda aquí, al fòrum! Si necessites ajuda de l'Staff de Wikia, pots anar a la nostra [[w:c:ca|Comunitat Central]] o preguntar a través de [[special:contact|Especial:Contactar]].

'''Diverteix-te!'''
: La comunitat de {{SITENAME}} s'alegra de que estiguis aquí. Volem veure't parlar sobre el tema que més ens agrada, endevina quin...

==Preguntes freqüents sobre el fòrum==
'''Com puc seguir les discussions a les que estic interessat?'''
: Amb un compte d'usuari de Wikia pots seguir converses específiques i rebre notificacions (a través del wiki o per correu) quan un tema tingui més activitat. [[Special:UserSignup|Crea un compte de Wikia]] si encara no ho has fet.

'''Com esborro el vandalisme?'''
: Si trobes missatges inadequats o vandalisme en un fil, passa el cursor sobre el text, veuràs que apareix un botó anomenat \"Més accions\". Dins del menú que es desplega a \"Més accions\", trobaràs \"Retirar\". Aquesta acció et permetrà retirar el vandalisme i avisar a un administrador si ho consideres necessari.

'''Què significa que estic a favor d'un missatge?'''
: Si trobes interessant un missatge, estàs d'acord amb el seu contingut o simplement recolzes el contingut d'aquest, mostra-ho als altres fent clic a l'icona amb el polze amunt. Pot ser molt útil per a votacions.

'''Temes, fils, conversacions, de què parles?'''
: Vegem, un fil és un conjunt de missatges sobre un mateix tema. Quan inicies una discussió sobre alguna cosa específica, estàs iniciant un fil. Cada fil es compon de missatge que van deixant els usuaris, i tots aquests tenen en comú que tracten sobre el mateix tema. A vegades, quan ens referim a un fil decidim que és un tema o una discussió, es pot anomenar de les dues maneres, així que tingues clar pel context a què ens estem referint.

'''Dins un fil hi ha temes?'''
: Sona confós, veritat? És fàcil, al final d'un fil trobaràs un apartat que defineix les coses sobre les que s'està parlant en aquest fil, aquests són els temes. És una forma de mantenir organitzats els fils del fòrum. Aquí podràs afegir els articles sobre els que estàs parlant. Per exemple, si etiquetes aquest fil amb l'etiqueta \"Lord Voldermort\", apareixerà aquest article al final de la discussió, però com pot ser que tingueu tant valor com per parlar de l'\"Innominable\"?!",
	'forum-board-title' => 'Subfòrum $1',
	'forum-board-topic-title' => 'Temes sobre $1',
	'forum-board-topics' => 'Temes',
	'forum-board-thread-follow' => 'Seguir',
	'forum-board-thread-following' => 'Seguint',
	'forum-board-thread-kudos' => '$1 a favor',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|resposta|respostes}}',
	'forum-board-new-message-heading' => 'Obrir un tema nou',
	'forum-no-board-selection-error' => '← Si us plau selecciona un subfòrum per a publicar-hi',
	'forum-thread-reply-placeholder' => 'Publicar una resposta',
	'forum-thread-reply-post' => 'Respondre',
	'forum-thread-deleted-return-to' => 'Tornar al subfòrum $1',
	'forum-sorting-option-newest-replies' => 'Temes respostos recentment',
	'forum-sorting-option-popular-threads' => 'Més actius',
	'forum-sorting-option-most-replies' => 'Més actius els últims 7 dies',
	'forum-sorting-option-newest-threads' => 'Temes més nous',
	'forum-sorting-option-oldest-threads' => 'Temes més antics',
	'forum-discussion-post' => 'Publicar',
	'forum-discussion-highlight' => 'Destacar aquest tema',
	'forum-discussion-placeholder-title' => 'Sobre què vols parlar?',
	'forum-discussion-placeholder-message' => 'Publicar un nou tema al subfòrum $1',
	'forum-discussion-placeholder-message-short' => 'Publicar un missatge nou',
	'forum-notification-user1-reply-to-your' => '$1 ha respost al teu tema al subfòrum $3',
	'forum-notification-user2-reply-to-your' => '$1 i $2 han respost al teu tema del subfòrum $3',
	'forum-notification-user3-reply-to-your' => '$1 i altres usuaris han respost al teu tema del subfòrum $3',
	'forum-notification-user1-reply-to-someone' => '$1 ha respost al subfòrum $3',
	'forum-notification-user2-reply-to-someone' => '$1 i $2 han respost al subfòrum $3',
	'forum-notification-user3-reply-to-someone' => '$1 i altres usuaris han respost al subfòrum $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 ha deixat un missatge nou al subfòrum $2',
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
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Veure la conversació</a></p>
<p>L\'Equip de Wikia</p>
___________________________________________<br>
* Troba ajuda i consells a la Central de Wikia: http://ca.wikia.com 
* Vols rebre menys missatges de Wikia? Pots modificar les teves subscripcions a email aquí: http://ca.wikia.com/Especial:Preferències',
	'forum-wiki-activity-msg' => 'al $1',
	'forum-wiki-activity-msg-name' => 'subfòrum $1',
	'forum-activity-module-heading' => 'Activitat del fòrum',
	'forum-related-module-heading' => 'Temes relacionats',
	'forum-activity-module-posted' => '$1 ha publicat una resposta $2',
	'forum-activity-module-started' => '$1 ha obert un nou tema $2',
	'forum-contributions-line' => '[[$1|$2]] al [[$3|subfòrum$4]]',
	'forum-recentchanges-new-message' => 'al [[$1|subfòrum $2]]',
	'forum-recentchanges-edit' => 'missatge editat',
	'forum-recentchanges-removed-thread' => 'ha esborrat el tema "[[$1|$2]]" del [[$3|subfòrum $4]]',
	'forum-recentchanges-removed-reply' => 'ha esborrat una resposta a "[[$1|$2]]" del [[$3|subfòrum $4]]',
	'forum-recentchanges-restored-thread' => 'ha restaurat el tema "[[$1|$2]]" del [[$3|subfòrum $4]]',
	'forum-recentchanges-restored-reply' => 'ha restaurat una resposta a "[[$1|$2]]" del [[$3|subfòrum $4]]',
	'forum-recentchanges-deleted-thread' => 'ha esborrat el tema "[[$1|$2]]" del [[$3|subfòrum $4]]',
	'forum-recentchanges-deleted-reply' => 'ha esborrat una resposta al tema "[[$1|$2]]" del [[$3|subfòrum $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Un missatge',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subfòrum',
	'forum-recentchanges-thread-group' => '$1 al [[$2|subfòrum $3]]',
	'forum-recentchanges-history-link' => 'historial del subfòrum',
	'forum-recentchanges-thread-history-link' => 'Historial del tema',
	'forum-recentchanges-closed-thread' => 'ha tancat el tema "[[$1|$2]]" a [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'ha reobert el tema "[[$1|$2]]" a [[$3|$4]]',
	'forum-board-history-title' => 'historial del subfòrum',
	'forum-specialpage-oldforum-link' => 'Arxiu del fòrum antic',
	'forum-admin-page-breadcrumb' => "Panell d'administració de subfòrums",
	'forum-admin-create-new-board-label' => 'Crear nou subfòrum',
	'forum-admin-create-new-board-modal-heading' => 'Crear un nou subfòrum',
	'forum-admin-create-new-board-title' => 'Títol del subfòrum',
	'forum-admin-create-new-board-description' => 'Descripció del subfòrum',
	'forum-admin-edit-board-modal-heading' => 'Editar subfòrum: $1',
	'forum-admin-edit-board-title' => 'Títol del subfòrum',
	'forum-admin-edit-board-description' => 'Descripció del subfòrum',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Esborrar subfòrum: $1',
	'forum-admin-delete-board-title' => 'Si us plau, confirma-ho escrivint el nom del subfòrum que vols esborrar:',
	'forum-admin-merge-board-warning' => "Els temes d'aquest subfòrum seran fusionats amb el subfòrum existent.",
	'forum-admin-merge-board-destination' => 'Selecciona un subfòrum per a fusionar-lo amb:',
	'forum-admin-delete-and-merge-button-label' => 'Esborrar i fusionar',
	'forum-admin-link-label' => 'Administrar subfòrums',
	'forum-autoboard-title-1' => 'Discussió General',
	'forum-autoboard-body-1' => 'Aquest subfòrum és per a discussions generals sobre el wiki.',
	'forum-autoboard-title-2' => 'Notícies i Anuncis',
	'forum-autoboard-body-2' => 'Notícies i anuncis',
	'forum-autoboard-title-3' => 'Novetats a $WIKINAME',
	'forum-autoboard-body-3' => "Vols compartir alguna cosa que s'hagi publicat en aquest wiki, o felicitar a algú per alguna contribució? Aquest n'és el lloc!",
	'forum-autoboard-title-4' => 'Preguntes i Respostes',
	'forum-autoboard-body-4' => 'Tens una pregunta sobre el wiki? Fes-les aquí!',
	'forum-autoboard-title-5' => 'Jocs i Diversió',
	'forum-autoboard-body-5' => 'Aquest subbfòrum és per a discussions vàries, un lloc per a passar-hi l\'estona amb els teus amics de $WIKINAME.',
	'forum-board-destination-empty' => '(Si us plau selecciona un subfòrum)',
	'forum-board-title-validation-invalid' => 'El títol del subfòrum conté caràcters invàlids',
	'forum-board-title-validation-length' => 'El títol del subfòrum ha de tenir almenys 4 caràcters',
	'forum-board-title-validation-exists' => 'Ja existeix un subfòrum amb el mateix títol',
	'forum-board-validation-count' => 'El número màxim de subfòrums és $1',
	'forum-board-description-validation-length' => 'Si us plau, escriu una descripció per aquest subfòrum',
	'forum-board-id-validation-missing' => "L'id del subfòrum no existeix",
	'forum-board-no-board-warning' => 'No hem pogut trobar un subfòrum amb aquest títol. Aquí hi ha la llista de subfòrums.',
	'forum-related-discussion-heading' => 'Fils del fòrum sobre $1',
	'forum-related-discussion-new-post-button' => 'Comença un tema',
	'forum-related-discussion-new-post-tooltip' => 'Comença un tema sobre $1',
	'forum-related-discussion-total-replies' => '$1 missatges',
	'forum-related-discussion-see-more' => 'Veure més temes',
	'forum-confirmation-board-deleted' => '"$1" ha estat esborrat.',
	'forum-token-mismatch' => 'Ops! No coincideix amb la fitxa',
);

$messages['ce'] = array(
	'forum-discussion-post' => 'Хаам',
	'forum-contributions-line' => '[[$1|$2]] дакъанехь [[$3|$4]]',
	'forum-recentchanges-new-message' => '[[$1|дакъанехь $2]]',
	'forum-recentchanges-edit' => 'табина хаам',
	'forum-recentchanges-deleted-reply-title' => 'Хаам',
);

$messages['cs'] = array(
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
	'forum-related-discussion-heading' => 'Diskuze na téma: $1',
	'forum-related-discussion-new-post-button' => 'Zahájit diskusi',
	'forum-related-discussion-new-post-tooltip' => 'Zahájit novou diskusi o $1',
	'forum-related-discussion-total-replies' => '$1{{PLURAL:$1|zpráva|zprávy|zpráv}}',
	'forum-related-discussion-see-more' => 'Zobrazit více diskuzí',
	'forum-confirmation-board-deleted' => '"$1" bylo smazáno.',
);

$messages['de'] = array(
	'forum-desc' => 'Forum-Erweiterung von Wikia',
	'forum-disabled-desc' => 'Forum-Erweiterung von Wikia; deaktiviert',
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '{{PLURAL:$1|Eine aktive Diskussion|$1 aktive Diskussionen}}',
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|aktive Diskussion|aktive Diskussionen}} über: $2',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Diskussionsfaden<br>in diesem Forum|Diskussionsfäden<br>in diesem Forum}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Aktive<br>Diskussion|Aktive<br>Diskussionen}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => 'Willkommen im {{SITENAME}}-Forum!',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|Diskussionsfaden|Diskussionsfäden}} mit insgesamt',
	'forum-specialpage-board-posts' => '{{PLURAL:$1|einer Antwort|$1 Antworten}}',
	'forum-specialpage-board-lastpostby' => 'Letzter Beitrag von',
	'forum-specialpage-policies-edit' => 'Bearbeiten',
	'forum-specialpage-policies' => 'Regeln und FAQ',
	'forum-policies-and-faq' => "==Foren-Richtlinien==
Denke bitte daran, dich an die bestehenden Forenregeln zu halten, wenn du dich in den Foren von {{SITENAME}} engagierst:

'''Sei freundlich und behandle andere mit Respekt.'''
: Dieses Wiki und die zugehörigen Foren werden von Menschen aus der ganzen Welt gelesen und bearbeitet. Wie in jedem anderen Gemeinschaftsprojekt wird auch hier nicht immer jeder einer Meinung sein. Bleibe bei Diskussionen höflich und anderen Meinungen gegenüber aufgeschlossen. Wir sind alle hier, weil wir dieselben Themen toll finden.

'''Versuche immer zuerst bereits existierende Diskussionen zu finden, aber scheue dich auch nicht davor, einen neuen Thread anzulegen.'''
:Nimm dir bitte einen Augenblick Zeit, um die verschiedenen Unterforen auf {{SITENAME}} durch zu gehen und herauszufinden, ob es bereits Diskussionen zu dem Thema gibt, über das du dich gerne austauschen möchtest! Wenn du das, was du suchst, nirgends finden kannst, springe einfach ins kalte Wasser und beginne eine neue Diskussion!

'''Bitte um Hilfe.'''
:Ist dir etwas aufgefallen, was so deiner Meinung nach nicht richtig ist? Oder hast du eine Frage? Bitte hier in den Foren um Hilfe! Wenn du Unterstützung von FANDOM-Mitarbeitern brauchst, nimm in der [[w:c:de.community|Community Deutschland]] oder über [[Spezial:Kontakt]] Kontakt zu uns auf.

'''Viel Spaß!'''
:Die Community {{SITENAME}} freut sich total, dass du jetzt hier bist. Wir können es kaum erwarten, mehr von dir zu erfahren und mit dir die Themen zu diskutieren, die uns allen am Herzen liegen.

==Forum FAQ==
'''Wie bleibe ich bei Diskussionen am Ball, die mich besonders interessieren?'''
: Mit einem Benutzerkonto bei FANDOM kannst du bestimmten Konversationen folgen und (entweder online oder per E-Mail) Benachrichtigungen erhalten, sobald die Diskussion weitergeht. [[Spezial:Anmelden|Melde sich also für ein FANDOM-Benutzerkonto an]], falls du das nicht sowieso schon getan hast.

'''Wie entferne ich Vandalismus?'''
: Wenn Du in einem Diskussionsfaden auf Spam oder Vandalismus triffst, kannst du deine Maus über den betreffenden Text bewegen, bis die Schaltfläche \"Mehr\" erscheint. Im Menü \"Mehr\" findest du den Menüpunkt \"Entfernen\". Darüber kannst du den betreffenden, unpassenden Text entfernen und optional auch gleich einen Admin darüber unterrichten.

'''Wie funktioniert das mit dem Lob für Beiträge?'''
: Wenn du eine bestimmte Diskussion oder Antwort besonders interessant, durchdacht oder amüsant findest, kannst du deine Wertschätzung dafür direkt zeigen, indem du ein Lob hinterlässt. Lob kann auch in Situationen, in denen abgestimmt werden soll, hilfreich sein.

'''Was sind Themen?'''
: Mithilfe von Themen kannst du eine Forendiskussion mit einem Wiki-Artikel verknüpfen. Es ist eine andere Möglichkeit, um die Foren zu organisieren und den Benutzern dabei zu helfen, interessante Diskussionen zu finden. Ein Forum, für den der Tag \"Lord Voldemort\" vergeben wurde, erscheint beispielsweise am Ende des Artikels zu \"Lord Voldemort\".",
	'forum-board-title' => '$1',
	'forum-board-topic-title' => 'Diskussionen über $1',
	'forum-board-topics' => 'Themen',
	'forum-board-thread-follow' => 'folgen',
	'forum-board-thread-following' => 'folge ich',
	'forum-board-thread-kudos' => '&nbsp;&nbsp;$1&nbsp;Zustimmungen',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Beitrag|Beiträge}}',
	'forum-board-new-message-heading' => 'Diskussion erstellen',
	'forum-no-board-selection-error' => '← Bitte wähle ein Forum aus, in dem du das Posten möchtest',
	'forum-thread-reply-placeholder' => 'Antwort posten',
	'forum-thread-reply-post' => 'Posten',
	'forum-thread-deleted-return-to' => 'Zum Forum „$1“ zurückkehren',
	'forum-sorting-option-newest-replies' => 'Neuste zuerst',
	'forum-sorting-option-popular-threads' => 'Beliebteste zuerst',
	'forum-sorting-option-most-replies' => 'Aktivste zuerst',
	'forum-sorting-option-newest-threads' => 'Neuste',
	'forum-sorting-option-oldest-threads' => 'Älteste',
	'forum-discussion-post' => 'Posten',
	'forum-discussion-highlight' => 'Hervorheben',
	'forum-discussion-placeholder-title' => 'Über welches Thema möchtest du diskutieren?',
	'forum-discussion-placeholder-message' => 'Neue Nachricht im Forum „$1“ posten',
	'forum-discussion-placeholder-message-short' => 'Neue Nachricht verfassen',
	'forum-notification-user1-reply-to-your' => '$1 hat eine Antwort im Forum „$3“ gepostet',
	'forum-notification-user2-reply-to-your' => '$1 und $2 haben Antworten im Forum „$3“ gepostet',
	'forum-notification-user3-reply-to-your' => '$1 und andere Benutzer haben Antworten im Forum „$3“ gepostet',
	'forum-notification-user1-reply-to-someone' => '$1 postete eine Antwort im Forum „$3“',
	'forum-notification-user2-reply-to-someone' => '$1 und $2 haben Antworten im Forum „$3“ gepostet',
	'forum-notification-user3-reply-to-someone' => '$1 und andere Benutzer haben Antworten im Forum „$3“ gepostet',
	'forum-notification-newmsg-on-followed-wall' => '$1 hat eine Antwort im Forum „$2“ gepostet',
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
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Link zum Diskussionsfaden</a></p>
			<p>The Wikia Team</p>
___________________________________________<br>
* Community-Wiki: http://de.community.wikia.com
* E-Mail-Einstellungen ändern? {{CANONICALURL:Special:Preferences}}',
	'forum-wiki-activity-msg' => 'im Forum „$1“',
	'forum-wiki-activity-msg-name' => '$1',
	'forum-activity-module-heading' => 'Neueste Forenbeiträge',
	'forum-related-module-heading' => 'Ähnliche Diskussionsfäden',
	'forum-activity-module-posted' => '$1 verfasste eine Antwort $2',
	'forum-activity-module-started' => '$1 erstellte neuen Diskussionsfaden $2',
	'forum-contributions-line' => '[[$1|$2]] im Forum [[$3|„$4“]]',
	'forum-recentchanges-new-message' => 'im [[$1|Forum „$2“]]',
	'forum-recentchanges-edit' => 'nachbearbeitet',
	'forum-recentchanges-removed-thread' => 'entfernte den Diskussionsfaden "[[$1|$2]]" aus dem Forum [[$3|„$4“]]',
	'forum-recentchanges-removed-reply' => 'entfernte die Antwort "[[$1|$2]]" aus dem Forum [[$3|„$4“]]',
	'forum-recentchanges-restored-thread' => 'stellte den Diskussionsfaden "[[$1|$2]]" im Forum [[$3|„$4“]] wieder her',
	'forum-recentchanges-restored-reply' => 'stellte die Antwort "[[$1|$2]]" im Forum [[$3|„$4“]] wieder her',
	'forum-recentchanges-deleted-thread' => 'löschte den Diskussionsfaden "[[$1|$2]]" aus dem Forum [[$3|„$4“]]',
	'forum-recentchanges-deleted-reply' => 'löschte die Antwort "[[$1|$2]]" im [[$3|Forum „$4“]]',
	'forum-recentchanges-deleted-reply-title' => 'einen Forenbeitrag',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forum',
	'forum-recentchanges-thread-group' => '$1 im Forum [[$2|„$3“]]',
	'forum-recentchanges-history-link' => 'Versionsgeschichte',
	'forum-recentchanges-thread-history-link' => 'Versionen',
	'forum-recentchanges-closed-thread' => 'schloss den Diskussionsfaden "[[$1|$2]]" im Forum „[[$3|$4]]“',
	'forum-recentchanges-reopened-thread' => 'eröffnete den Diskussionsfaden "[[$1|$2]]" im Forum „[[$3|$4]]“ erneut',
	'forum-board-history-title' => 'Versionsgeschichte',
	'forum-specialpage-oldforum-link' => 'Foren-Archiv ansehen',
	'forum-admin-page-breadcrumb' => 'Foren-Administration',
	'forum-admin-create-new-board-label' => 'Erstelle ein neues Forum',
	'forum-admin-create-new-board-modal-heading' => 'Erstelle ein neues Forum',
	'forum-admin-create-new-board-title' => 'Foren-Titel',
	'forum-admin-create-new-board-description' => 'Beschreibung',
	'forum-admin-edit-board-modal-heading' => 'Forum „$1“ bearbeiten',
	'forum-admin-edit-board-title' => 'Foren-Titel',
	'forum-admin-edit-board-description' => 'Beschreibung',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Forum „$1“ löschen',
	'forum-admin-delete-board-title' => 'Wenn du das Forum wirklich löschen möchtest, gib den Namen des Forums erneut ein:',
	'forum-admin-merge-board-warning' => 'Die Diskussionsfäden in diesem Forum werden in ein bestehendes Forum übertragen.',
	'forum-admin-merge-board-destination' => 'Wähle ein Forum, in das die Diskussionsfäden übertragen werden sollen:',
	'forum-admin-delete-and-merge-button-label' => 'Löschen und zusammenlegen',
	'forum-admin-link-label' => 'Foren-Administration',
	'forum-autoboard-title-1' => 'Generelle Diskussion',
	'forum-autoboard-body-1' => 'Dieses Forum ist für generelle Konversationen über das Wiki.',
	'forum-autoboard-title-2' => 'Neuigkeiten und Bekanntmachungen',
	'forum-autoboard-body-2' => 'Dieses Forum ist für Neuigkeiten und Bekanntmachungen.',
	'forum-autoboard-title-3' => 'Neu in $1',
	'forum-autoboard-body-3' => 'Du möchtest etwas teilen, dass gerade erst im Wiki erstellt wurde, oder jemandem für eine großartige Bearbeitung danken?',
	'forum-autoboard-title-4' => 'Fragen und Antworten',
	'forum-autoboard-body-4' => 'Hast du eine Frage über das Wiki oder das Thema selbst? Dann stelle sie hier!',
	'forum-autoboard-title-5' => 'Off-Topic',
	'forum-autoboard-body-5' => 'Dieses Board ist für Off-Topic-Konversationen – Ein Platz zum Rumhängen mit deinen $1-Freunden.',
	'forum-board-destination-empty' => '(Bitte wähle ein Forum aus)',
	'forum-board-title-validation-invalid' => 'Der Foren-Name enthält ungültige Zeichen.',
	'forum-board-title-validation-length' => 'Der Foren-Name sollte mindestens vier Buchstaben lang sein.',
	'forum-board-title-validation-exists' => 'Ein Forum unter diesem Namen existiert bereits.',
	'forum-board-validation-count' => 'Du kannst maximal $1 Foren anlegen.',
	'forum-board-description-validation-length' => 'Bitte gib eine Beschreibung für dieses Forum an.',
	'forum-board-id-validation-missing' => 'Die Foren-ID fehlt',
	'forum-board-no-board-warning' => 'Es gibt kein Forum mit diesem Titel. Versuche es bitte noch einmal oder sieh dir diese Liste der existierenden Foren an.',
	'forum-related-discussion-heading' => 'Diskussionen über $1',
	'forum-related-discussion-new-post-button' => 'Eine Diskussion beginnen',
	'forum-related-discussion-new-post-tooltip' => 'Eine Diskussion über „$1“ beginnen',
	'forum-related-discussion-total-replies' => '$1 Nachrichten',
	'forum-related-discussion-see-more' => 'Weitere Diskussionen',
	'forum-confirmation-board-deleted' => '"$1" wurde gelöscht.',
	'forum-token-mismatch' => 'Upps! Token stimmt nicht überein.',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => 'Has admin access to the forums',
	'right-forumoldedit' => 'Can edit the old, archived forums',
	'right-boardedit' => 'Edit Forum board information',
);

$messages['el'] = array(
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Ενεργή Συζήτηση|Ενεργές Συζητήσεις}} για: '''[[$2]]'''",
	'forum-active-threads' => '$1 {{PLURAL:$1|Ενεργή Συζήτηση|Ενεργές Συζητήσεις}}',
	'forum-activity-module-heading' => 'Δραστηριότητα Αγοράς',
	'forum-activity-module-posted' => 'Ο $1 δημοσίευσε μία απάντηση $2',
	'forum-activity-module-started' => '$1 ξεκίνησε μία συζήτηση $2',
	'forum-admin-create-new-board-description' => 'Περιγραφή Πίνακα',
	'forum-admin-create-new-board-label' => 'Δημιουργήστε Νέο Πίνακα Περιεχομένων',
	'forum-admin-create-new-board-modal-heading' => 'Δημιουργήστε ένα νέο πίνακα',
	'forum-admin-create-new-board-title' => 'Όνομα Πίνακα',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Διαγραφή Πίνακα: $1',
	'forum-admin-delete-and-merge-button-label' => 'Διαγραφή και Συγχώνευση',
	'forum-admin-delete-board-title' => 'Παρακαλούμε επιβεβαιώστε πληκτρολογώντας το όνομα του πίνακα που θέλετε να διαγράψετε:',
	'forum-admin-edit-board-description' => 'Περιγραφή Πίνακα',
	'forum-admin-edit-board-modal-heading' => 'Επεξεργασία Πίνακα: $1',
	'forum-admin-edit-board-title' => 'Όνομα Πίνακα',
	'forum-admin-link-label' => 'Διαχειριστείτε τους Πίνακες',
	'forum-admin-merge-board-destination' => 'Διαλέξτε έναν πίνακα για να συγχωνευτεί:',
	'forum-admin-merge-board-warning' => 'Οι συζητήσεις σε αυτόν τον πίνακα θα συγχωνευτούν σε έναν υπάρχων πίνακα.',
	'forum-admin-page-breadcrumb' => 'Διαχείριση των Πινάκων Περιεχομένων από τους Διαχειριστές',
	'forum-autoboard-body-1' => 'Αυτός ο πίνακας είναι για γενικές συζητήσεις στο wiki.',
	'forum-autoboard-body-2' => 'Σημαντικά νέα και πληροφορίες!',
	'forum-autoboard-body-3' => 'Θέλετε να μοιραστείτε κάτι που μόλις ανακοινώθηκε σε αυτό το wiki, ή να συγχαρείτε κάποιον για μία υπέροχη συνεισφορά; Εδώ είναι το σωστό μέρος!',
	'forum-autoboard-body-4' => 'Έχετε απορείες σε σχέση με το wiki ή το θέμα του; Δημοσιεύστε τις ερωτήσεις σας εδώ!',
	'forum-autoboard-body-5' => 'Αυτός ο πίνακας είναι για εκτός-θέματος σθζητήσεις -- ένα μέρος για να περάσετε καλά με τους $1 φίλους σας.',
	'forum-autoboard-title-1' => 'Γενικές Συζητήσεις',
	'forum-autoboard-title-2' => 'Νέα και Ανακοινώσεις',
	'forum-autoboard-title-3' => 'Νέα στο $1',
	'forum-autoboard-title-4' => 'Ερωτήσεις και Απαντήσεις',
	'forum-autoboard-title-5' => 'Πλάκα και Παιχνίδια',
	'forum-board-description-validation-length' => 'Παρακαλούμε περιγράψτε αυτόν τον πίνακα',
	'forum-board-destination-empty' => '(Παρακαλούμε επιλέξτε πίνακα)',
	'forum-board-history-title' => 'ιστορικό πίνακα',
	'forum-board-id-validation-missing' => 'Το id του πίνακα λείπει',
	'forum-board-new-message-heading' => 'Ξεκινήστε μία συζήτηση',
	'forum-board-no-board-warning' => 'Δεν μπορέσαμε να βρούμε ένα πίνακα με αυτό το όνομα. Εδώ είναι μία λίστα με τους πίνακες.',
	'forum-board-thread-follow' => 'Ακολουθήστε',
	'forum-board-thread-following' => 'Ακολουθείτε',
	'forum-board-thread-kudos' => '$1 Έπαινοι',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Μήνυμα|Μηνύματα}}',
	'forum-board-title-validation-exists' => 'Ένας πίνακας με το ίδιο όνομα υπάρχει ήδη',
	'forum-board-title-validation-invalid' => 'Το όνομα του πίνακα αποτελείται από μη-αναγνωρίσιμους χαρακτήρες',
	'forum-board-title-validation-length' => 'Το όνομα του πίνακα πρέπει να περιέχει τουλάχιστον 4 χαρακτήρες',
	'forum-board-title' => '$1 πίνακας',
	'forum-board-topic-title' => 'Συζητήσεις σχετικά με $1',
	'forum-board-topics' => 'Θέματα',
	'forum-board-validation-count' => 'Το ανώτατο όριο πινάκων είναι $1',
	'forum-confirmation-board-deleted' => 'Το "$1" διεγράφη.',
	'forum-contributions-line' => '[[$1|$2]] στον [[$3|$4 πίνακα]]',
	'forum-discussion-highlight' => 'Επισημάνετε αυτή τη συζύτηση',
	'forum-discussion-placeholder-message-short' => 'Αναρτήστ ένα νέο μήνυμα',
	'forum-discussion-placeholder-message' => 'Αναρτήστε νέο μήνυμα στον πίνακα $1',
	'forum-discussion-placeholder-title' => 'Σχετικά με τί θέλετε να μιλήσετε;',
	'forum-discussion-post' => 'Ανάρτηση',
	'forum-forum-title' => 'Αγορά',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Ενεργή<br />Συζήτηση|Ενεργές<br />Συζητήσεις}}</span>',
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Συζήτηση<br />σε αυτή την αγορά|Συζητήσεις<br />σε αυτή την αγορά}}</span>',
	'forum-no-board-selection-error' => '← Παρακαλούμε επιλέξτε πίνακα για ανάρτηση',
	'forum-notification-newmsg-on-followed-wall' => 'Ο $1 {{GENDER:$1|άφησε}} ένα νέο μήνυμα στον πίνακα $2',
	'forum-notification-user1-reply-to-someone' => 'Ο $1 {{GENDER:$1|απάντησε}} στον πίνακα $3',
	'forum-notification-user1-reply-to-your' => 'Ο $1 {{GENDER:$1|απάντησε}} στη συζήτησή σας στον πίνακα $3',
	'forum-notification-user2-reply-to-someone' => 'Οι $1 και $2 απάντησαν στον πίνακα $3',
	'forum-notification-user2-reply-to-your' => 'Οι $1 και $2 απάντησαν στη συζήτησή σας στον πίνακα $3',
	'forum-notification-user3-reply-to-someone' => 'Ο $1 και άλλοι απάντησαν στον πίνακα $3',
	'forum-notification-user3-reply-to-your' => 'Ο $1 και άλλοι απάντησαν στη συζήτησή σας στον πίνακα $3',
	'forum-recentchanges-closed-thread' => 'έκλεισε τη συζήτηση "[[$1|$2]]" από [[$3|$4]]',
	'forum-recentchanges-deleted-reply-title' => 'Μία ανάρτηση',
	'forum-recentchanges-deleted-reply' => 'διέγραψε την απάντηση από "[[$1|$2]]" από τον [[$3|$4 Πίνακα]]',
	'forum-recentchanges-deleted-thread' => 'διέγραψε τη συζήτηση "[[$1|$2]]" από τον [[$3|$4 Πίνακα]]',
	'forum-recentchanges-edit' => 'επεξεργάστηκε μήνυμα',
	'forum-recentchanges-history-link' => 'Ιστορικό πίνακα',
	'forum-recentchanges-namespace-selector-message-wall' => 'Πίνακας Αγοράς',
	'forum-recentchanges-new-message' => 'στον [[$1|$2 Πίνακα]]',
	'forum-recentchanges-removed-reply' => 'απομάκρυνε την απάντηση από "[[$1|$2]]" από τον [[$3|$4 Πίνακα]]',
	'forum-recentchanges-removed-thread' => 'απομάκρυνε τη συζήτηση "[[$1|$2]]" από τον [[$3|Πίνακα $4]]',
	'forum-recentchanges-reopened-thread' => 'ξανάνοιξε τη συζήτηση "[[$1|$2]]" από [[$3|$4]]',
	'forum-recentchanges-restored-reply' => 'επανέφερε την απάντηση "[[$1|$2]]" στον [[$3|Πίνακα $4]]',
	'forum-recentchanges-restored-thread' => 'επανέφερε τη συζήτηση "[[$1|$2]]" στον [[$3|Πίνακα $4]]',
	'forum-recentchanges-thread-group' => '$1 στον [[$2|$3 Πίνακα]]',
	'forum-recentchanges-thread-history-link' => 'ιστορία συζήτησης',
	'forum-related-discussion-heading' => 'Συζητήσεις για $1',
	'forum-related-discussion-new-post-button' => 'Ξεκινήστε Μία Συζήτηση',
	'forum-related-discussion-new-post-tooltip' => 'Ξεκινήστε μία νέα συζητηση για $1',
	'forum-related-discussion-see-more' => 'Δείτε περισσότερες συζητήσεις',
	'forum-related-discussion-total-replies' => '$1 μυνήματα',
	'forum-related-module-heading' => 'Σχετικές Συζητήσεις',
	'forum-sorting-option-most-replies' => 'Πιό Ενεργές σε 7 Ημέρες',
	'forum-sorting-option-newest-replies' => 'Τελευταίες Απαντήσεις',
	'forum-sorting-option-newest-threads' => 'Νεότερες Συζητήσεις',
	'forum-sorting-option-oldest-threads' => 'Παλαιότερες Συζητήσεις',
	'forum-sorting-option-popular-threads' => 'Πιο Δημοφιλής',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Μπορείτε να το επεξεργαστείτε<span>',
	'forum-specialpage-board-lastpostby' => 'Τελευταία ανάρτηση από',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|ανάρτηση|αναρτήσεις}}',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|συζήτηση|συζητήσεις}}',
	'forum-specialpage-heading' => 'Αγορά',
	'forum-specialpage-oldforum-link' => 'Αρχεία Της Παλιάς Αγοράς',
	'forum-specialpage-policies-edit' => 'Επεξεργασία',
	'forum-specialpage-policies' => 'Κανόνες της Αγοράς / ΣΕ',
	'forum-thread-deleted-return-to' => 'Γυρίστε στον πίνακα $1',
	'forum-thread-reply-placeholder' => 'Αναρτήστε μία απάντηση',
	'forum-thread-reply-post' => 'Απάντηση',
	'forum-wiki-activity-msg-name' => '$1 πίνακας',
	'forum-wiki-activity-msg' => 'στον $1',
);

$messages['en-gb'] = array(
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
);

$messages['es'] = array(
	'forum-desc' => 'Extensión Especial:Foro de Wikia',
	'forum-disabled-desc' => 'Extensión Especial:Foro de Wikia; desactivada',
	'forum-forum-title' => 'Índice',
	'forum-active-threads' => '$1 {{PLURAL:$1|Tema activo|Temas activos}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Tema activo|Temas activos}} sobre: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Tema<br> en este foro|Temas<br> en este foro}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Tema<br> Activo|Temas<br> Activos}}</span>',
	'forum-specialpage-heading' => 'Foro',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Puedes editarlo<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|tema|temas}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|mensaje|mensajes}}',
	'forum-specialpage-board-lastpostby' => 'Último mensaje escrito por',
	'forum-specialpage-policies-edit' => 'Editar',
	'forum-specialpage-policies' => 'Políticas del Foro / FAQ',
	'forum-policies-and-faq' => "==Políticas del foro==
Antes de contribuir en el foro de {{SITENAME}}, ten en cuenta las siguientes prácticas:

'''Trata a la gente con respeto y no tengas malas intenciones.'''

:Personas de todos los lugares del mundo leen y editan en este wiki y este foro. Como cualquier proyecto colaborativo, no todo el mundo va a estar de acuerdo permanentemente con lo que se discuta así que abre tu mente a diferentes opiniones. Estamos aquí porque nos gusta lo mismo.

'''Intenta encontrar discusiones existentes primero, pero no tengas miedo de iniciar un nuevo tema.'''
:Por favor, tómate un momento para visitar los subforos de este wiki y ver si ya existe una discusión sobre lo que quieres hablar. Si no puedes encontrar lo que buscas, ¡comienza un nuevo tema!

'''Pide ayuda.'''
:¿Algo no se ve como debería? ¿Tienes alguna pregunta? ¡Pide ayuda aquí, en el foro! Si necesitas ayuda del Staff de FANDOM, puedes ir a nuestra [[w:c:comunidad|Comunidad Central]] o preguntar a través de [[Especial:Contactar]].

'''¡Diviértete!'''
La comunidad de {{SITENAME}} se alegra de que estés aquí. Queremos verte hablar sobre el tema que más nos gusta, adivina cuál...

==Preguntas frecuentes sobre el foro==
'''¿Cómo puedo seguir las discusiones en las que estoy interesado?'''
:Con una cuenta de usuario de FANDOM puedes seguir conversaciones específicas y recibir notificaciones (a través del wiki o por correo) cuando un tema tenga más actividad. Crea una cuenta en FANDOM si aún no lo hiciste.

'''¿Cómo borro los vandalismos?'''
:Si descubres mensajes inadecuados, o vandalismo en un hilo, pasa el cursor sobre el texto, verás que aparece un botón llamado \"Más acciones\". Dentro del menú que se despliega en \"Más acciones\", encontrarás \"Retirar\". Esa acción te permitirá retirar el vandalismo y avisar a un administrador si lo consideras necesario.

'''¿Qué significa que estoy a favor de un mensaje?'''
:Si encuentras interesante un mensaje, estás de acuerdo con su contenido o simplemente apoyas el contenido del mismo, muéstraselo a los demás haciendo clic en el icono con el pulgar arriba. Puede ser algo muy útil para votaciones.

'''Temas, hilos, conversaciones, ¿de qué hablas?'''
:Veamos, un hilo es un conjunto de mensajes sobre un mismo tema. Cuando inicias una discusión sobre algo específico, estás iniciando un hilo. Cada hilo se compone de mensajes que van dejando los usuarios, y todos estos tienen en común que tratan sobre el mismo tema. A veces, cuando nos referimos a un hilo decimos que es un tema o una discusión, se puede llamar de ambas formas, ten claro por el contexto a qué nos estamos refiriendo.

'''¿Dentro de un hilo hay temas?'''
:Suena confuso ¿verdad? Es fácil, al final de un hilo encontrarás un apartado que define las cosas sobre las que se está hablando en ese hilo, esos son los temas. Es una forma de mantener organizados los hilos del foro. Ahí podrás añadir los artículos sobre los que se está hablando. Por ejemplo, si etiquetas ese hilo con la etiqueta \"Lord Voldermort\", aparecerá reseñado ese artículo al final de la discusión, ¡pero no sabemos cómo podéis tener tanto valor como para hablar sobre El-Que-No-Debe-Ser-Nombrado.",
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
	'forum-notification-user1-reply-to-your' => '$1 contestó a tu tema en el subforo $3',
	'forum-notification-user2-reply-to-your' => '$1 y $2 contestaron en tu tema del subforo $3',
	'forum-notification-user3-reply-to-your' => '$1 y otros usuarios contestaron en tu tema del subforo $3',
	'forum-notification-user1-reply-to-someone' => '$1 contestó en el subforo $3',
	'forum-notification-user2-reply-to-someone' => '$1 y $2 contestaron en el subforo $3',
	'forum-notification-user3-reply-to-someone' => '$1 y otros usuarios contestaron en el subforo $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 dejó un nuevo mensaje en el subforo $2',
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
___________________________________________<br>
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
	'forum-autoboard-title-1' => 'Discusión General',
	'forum-autoboard-body-1' => 'Este subforo es para discusiones generales acerca del wiki.',
	'forum-autoboard-title-2' => 'Noticias y Anuncios',
	'forum-autoboard-body-2' => 'Noticias y Anuncios',
	'forum-autoboard-title-3' => 'Lo nuevo en $1',
	'forum-autoboard-body-3' => '¿Quieres compartir algo que ha sido publicado en este wiki, o felicitar a alguien por alguna contribución? ¡Este es el lugar!',
	'forum-autoboard-title-4' => 'Preguntas y Respuestas',
	'forum-autoboard-body-4' => '¿Tienes una pregunta acerca del wiki? ¡Haz tus preguntas aquí!',
	'forum-autoboard-title-5' => 'Juegos y Diversión',
	'forum-autoboard-body-5' => 'Este subforo es para discusiones varias, un lugar para pasar el rato con tus amigos de $1.',
	'forum-board-destination-empty' => '(Por favor selecciona un subforo)',
	'forum-board-title-validation-invalid' => 'El título del subforo contiene caracteres inválidos',
	'forum-board-title-validation-length' => 'El título del subforo debe tener al menos 4 caracteres',
	'forum-board-title-validation-exists' => 'Ya existe un subforo con el mismo título',
	'forum-board-validation-count' => 'El número máximo de subforos es $1',
	'forum-board-description-validation-length' => 'Por favor escribe una descripción para esta subforo',
	'forum-board-id-validation-missing' => 'El id del subforo no existe',
	'forum-board-no-board-warning' => 'No existe ningún subforo con ese título. Por favor, intenta de nuevo o revisa la lista de subforos.',
	'forum-related-discussion-heading' => 'Hilos del foro sobre $1',
	'forum-related-discussion-new-post-button' => 'Comienza un tema',
	'forum-related-discussion-new-post-tooltip' => 'Comienza un tema acerca de $1',
	'forum-related-discussion-total-replies' => '$1 mensajes',
	'forum-related-discussion-see-more' => 'Ver más temas',
	'forum-confirmation-board-deleted' => '"$1" ha sido borrado.',
	'forum-token-mismatch' => '¡Oops! El token no coincide.',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => 'Has admin access to the forums',
	'right-forumoldedit' => 'Can edit the old, archived forums',
	'right-boardedit' => 'Edit Forum board information',
);

$messages['eu'] = array(
	'forum-board-topics' => 'Gaiak',
	'forum-board-thread-replies' => '{{PLURAL:$1|Mezu bat|$1 mezu}}',
	'forum-thread-reply-post' => 'Erantzun',
	'forum-related-discussion-total-replies' => '$1 mezu',
	'forum-related-discussion-see-more' => 'Ikusi eztabaida gehiago',
);

$messages['fa'] = array(
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
);

$messages['fi'] = array(
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
	'forum-related-discussion-heading' => 'Keskusteluja aiheesta $1',
	'forum-related-discussion-new-post-button' => 'Aloita keskustelu',
	'forum-related-discussion-new-post-tooltip' => 'Aloita uusi keskustelu aiheesta $1',
	'forum-related-discussion-total-replies' => '$1 viestiä',
	'forum-related-discussion-see-more' => 'Katso lisää keskusteluja',
	'forum-confirmation-board-deleted' => '"$1" on poistettu.',
);

$messages['fr'] = array(
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
	'forum-policies-and-faq' => "==Règles des forums==
Avant de contribuer aux forums de {{SITENAME}}, veuillez garder à l'esprit quelques bonnes pratiques à suivre :

'''Soyez courtois et traitez les gens avec respect.'''
:Des gens du monde entier lisent et modifient ce wiki et ses forums. Comme pour tout autre projet participatif, tout le monde ne sera pas toujours d'accord. Faites en sorte que les discussions restent polies et soyez ouvert aux opinions différentes des vôtres. Nous sommes tous ici parce que le même sujet nous passionne.

'''Commencez par chercher si des discussions existent, mais n'ayez pas peur d'en créer une nouvelle.'''
:Veuillez prendre un peu de temps pour parcourir les sous-forums de {{SITENAME}} afin de voir si une discussion sur quelque chose dont vous souhaitez parler existe déjà. Si vous ne trouvez pas ce que vous cherchez, lancez une nouvelle discussion !

'''Demandez de l'aide.'''
:Vous avez remarqué quelque chose qui ne vous semble pas normal ? Ou vous avez une question ? Demandez de l'aide ici sur les forums ! Si vous avez besoin de l'aide de l'équipe FANDOM, rendez-vous au [[w:fr:Accueil|Centre des communautés]] ou utilisez Special:Contact.

'''Amusez-vous !'''
:La communauté {{SITENAME}} est heureuse que vous soyez là. Nous espérons vous voir régulièrement participer aux discussions sur le sujet que nous aimons tous.

==FAQ sur les forums==
'''Comment suivre les discussions qui m'intéressent ?'''
: Avec un compte utilisateur FANDOM, vous pouvez suivre des conversations spécifiques et recevoir des notifications (soit sur le site soit par e-mail) lorsqu'une discussion enregistre plus d'activité. Si vous n'avez pas encore de compte FANDOM, [[Special:UserSignup|créez-en un dès maintenant]].

'''Comment puis-je retirer le vandalisme ?'''
: Si vous remarquez du spam ou du vandalisme dans une discussion, placez votre souris sur le texte incriminé. Vous verrez un bouton Plus apparaître. Dans le menu Plus, vous trouverez l'option Retirer. Cela vous permettra de retirer le message et d'en informer éventuellement un administrateur.

'''Que sont les sélections ?'''
: Si vous trouvez une discussion ou une réponse particulièrement intéressante, bien tournée ou amusante, vous pouvez montrer que vous l'appréciez en la sélectionnant. Les sélections peuvent être également utiles dans les situations de vote.

'''Que sont les rubriques ?'''
: Les rubriques permettent de lier une discussion du forum à un article de wiki. Il s'agit d'un moyen de s'assurer que le forum reste structuré et d'aider les gens à trouver des discussions intéressantes. Par exemple, une discussion du forum peut porter la marque « Voldemort », ce qui la fera apparaître en bas de l'article « Voldemort ».",
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
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les e-mails que vous recevez ? Rendez-vous sur vos <a href="http://communaute.wikia.com/Special:Preferences">préférences</a></li>
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
	'forum-board-no-board-warning' => "Aucun sous-forum portant ce titre n'existe. Veuillez réessayer ou consulter cette liste de sous-forums.",
	'forum-related-discussion-heading' => 'Discussions à propos de « $1 »',
	'forum-related-discussion-new-post-button' => 'Démarrer une discussion',
	'forum-related-discussion-new-post-tooltip' => 'Démarrer une nouvelle discussion à propos de « $1 »',
	'forum-related-discussion-total-replies' => '$1 messages',
	'forum-related-discussion-see-more' => 'Voir plus de discussions',
	'forum-confirmation-board-deleted' => '« $1 » a été supprimé.',
	'forum-token-mismatch' => 'Oups ! Le jeton ne correspond pas',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => 'Has admin access to the forums',
	'right-forumoldedit' => 'Can edit the old, archived forums',
	'right-boardedit' => 'Edit Forum board information',
);

$messages['fy'] = array(
	'forum-forum-title' => 'Foarum',
	'forum-specialpage-heading' => 'Foarum',
	'forum-specialpage-policies-edit' => 'Bewurkje',
	'forum-mail-notification-html-greeting' => 'Hallo $1,',
	'forum-mail-notification-subject' => '$1 -- $2',
);

$messages['gl'] = array(
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
	'forum-related-discussion-heading' => 'Conversas sobre "$1"',
	'forum-related-discussion-new-post-button' => 'Comezar un debate',
	'forum-related-discussion-new-post-tooltip' => 'Comezar un novo debate sobre "$1"',
	'forum-related-discussion-total-replies' => '$1 mensaxes',
	'forum-related-discussion-see-more' => 'Ver máis debates',
	'forum-confirmation-board-deleted' => 'Borrouse "$1".',
	'forum-token-mismatch' => 'Vaites! O pase non coincide',
);

$messages['he'] = array(
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
);

$messages['hu'] = array(
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
);

$messages['id'] = array(
	'forum-forum-title' => 'Forum',
	'forum-specialpage-board-lastpostby' => 'Terakhir dikirim oleh',
	'forum-specialpage-policies-edit' => 'Sunting',
	'forum-specialpage-policies' => 'Forum kebijakan/FAQ',
	'forum-policies-and-faq' => "==Kebijakan Forum==
Sebelum berkontribusi di forum {{SITENAME}}, harap di ingat beberapa hal yang harus di praktikkan sebelum melakukan.

'''Bersikaplah baik dan memperlakukan orang lain lebih hormat'''
:Semua orang di seluruh dunia membaca dan menyunting wiki ini dan forumnya. Seperti proyek kolaborasi lainnya, tidak semua orang akan setuju setiap saat. Harap menjaga diskusi dengan sopan dan terbuka dalam beberapa tentang perbedaan pendapat. Kita semua disini menyukai topik yang sama. 

'''Cobalah mencari diskusi yang sudah ada terlebih dahulu, tetapi jangan takut untuk memulai diskusi yang baru'''
:Diharapkan untuk meluangkan waktu untuk melihat-lihat di papan forum {{SITENAME}} untuk melihat diskusi tentang pertanyaanmu terlebih dahulu, Jika anda tidak menemukan diskusi yang anda cari, silahkan memulai diskusi yang baru!

'''Minta bantuan'''
:Jika anda melihat sesuatu yang sesuatu yang aneh? Atau anda punya pertanyaan? Tanya saja untuk bantuan di forum! Jika Anda membutuhkan bantuan dari Staf FANDOM, tolong kontak kami di [[w:c:community|Community Central]] atau melalui [[Special:Contact]].

'''Selamat menikmati!'''
:{{SITENAME}} sangat bahagia dengan kehadiran anda disini. Kami sangat jika anda ada disekeliling saat kita bersama mendiskusikan topik yang kita sukai.

==Forum FAQ==
'''Bagaimana saya tetap ada di diskusi yang saya sukai?'''
:Dengan sebuah akun pengguna FANDOM, anda bisa mengikuti percakapan yang spesifik dan menerima pesan pemberitahuan (kemungkinan di website atau melalui email) disaat ada diskusi yang sedang aktif. Anda harus mendaftar [[Special:UserSignup|mendaftar untuk akun fandom]] jika anda belum mendaftar.

'''Bagaimana saya menghapus vandalisme?'''
:Jika anda melihat beberapa spam atau vandalisme di panel diskusi, arahkan mouse anda ke halaman yang anda lihat sedang terjadi. Anda akan melihat sebuah button \"Lagi\" akan muncul. Didalam menu \"lagi\", anda akan menemukan kata \"Hapus\". Ini akan membuat anda bisa menghapus vandalisme dan juga memberitahukan kepada admin.

'''Apakah itu Pujian?\"
:Jika anda menemukan diskusi atau jawaban tertentu yang dikira anda menarik, yang sangat mendetail anda bisa memberikan pujian langsung dengan memberikan pujian. Pujian juga membantu dalam suasana undian suara, juga.

'''Apakah itu Topik?'''
:Topik akan memberikan anda untuk mengaitkan forum diskusi dengan artikel wiki. Itu adalah cara yang terbaik agar Forum tetap terorganisasi dan membantu orang lain menemukan diskusi yang menarik. Contohnya, sebuah forum yang di tag \"Lord Voldemort\" akan muncul dibawah kategori artikelnya.",
	'forum-board-topics' => 'Topik',
	'forum-board-thread-follow' => 'Ikuti',
	'forum-board-thread-following' => 'Mengikuti',
	'forum-board-thread-kudos' => '$1 Pujian',
	'forum-board-new-message-heading' => 'Memulai diskusi',
	'forum-no-board-selection-error' => 'Pilih papan diskusi untuk mengirimkan ke',
	'forum-thread-reply-placeholder' => 'Kirim balasan',
	'forum-thread-reply-post' => 'Balasan',
	'forum-sorting-option-newest-replies' => 'Balasan yang paling baru',
	'forum-sorting-option-popular-threads' => 'Paling populer',
	'forum-sorting-option-most-replies' => 'Paling aktif dalam 7 hari',
	'forum-sorting-option-newest-threads' => 'Diskusi Terbaru',
	'forum-sorting-option-oldest-threads' => 'Diskusi Terlama',
	'forum-discussion-post' => 'Kirim',
	'forum-discussion-highlight' => 'Menyorotkan diskusi ini',
	'forum-discussion-placeholder-title' => 'Apa yang anda ingin bicarakan tentang?',
	'forum-discussion-placeholder-message' => 'Mengirimkan pesan baru ke panel $1',
	'forum-discussion-placeholder-message-short' => 'Kirim pesan baru',
	'forum-activity-module-heading' => 'Aktivitas Forum',
	'forum-related-module-heading' => 'Diskusi Terkait',
	'forum-related-discussion-new-post-button' => 'Memulai diskusi',
	'forum-related-discussion-new-post-tooltip' => 'Memulai diskusi baru tentang $1',
	'forum-desc' => 'FANDOM ekstensi Special:Forum',
	'forum-disabled-desc' => 'FANDOM ekstensi Special:Forum; terputus',
	'forum-active-threads' => '$1 {{PLURAL:$1|Diskusi Aktif|Diskusi Aktif}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|Diskusi Aktif|Diskusi Aktif}} tentang: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Diskusi<br/>di forum ini|Panel diskusi<br/>di forum ini}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|Aktif<br />Diskusi|Aktif<br />Diskusi}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-halamanistimewa-blurb-heading Anda bisa menyuntingnya<span>',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|panel diskusi|Panel diskusi}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|Kirim|Kiriman}}',
	'forum-board-title' => '$1 panel diskusi',
	'forum-board-topic-title' => 'Diskusi tentang $1',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Pesan|Pesan}}',
	'forum-thread-deleted-return-to' => 'Kembali ke panel $1',
	'forum-notification-user1-reply-to-your' => '$1 telah menjawab diskusi anda di panel $3',
	'forum-notification-user2-reply-to-your' => '$1 dan $2 telah menjawab diskusi anda di panel diskusi',
	'forum-notification-user3-reply-to-your' => '$1 dan yang lainnya menjawab diskusi anda di panel $3',
	'forum-notification-user1-reply-to-someone' => '$1 telah menjawab diskusi di panel $3',
	'forum-notification-user2-reply-to-someone' => '$1 dan $2 telah menjawab di panel $3',
	'forum-notification-user3-reply-to-someone' => '$1 dan yang lain telah menjawab di panel $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 telah meninggalkan pesan baru di panel $2',
	'forum-wiki-activity-msg' => 'pada $1',
	'forum-wiki-activity-msg-name' => 'panel $1',
	'forum-activity-module-posted' => '$1 telah mengirimkan balasan $2',
	'forum-activity-module-started' => '$1 telah memulai diskusi $2',
	'forum-contributions-line' => '[[$1|$2]] pada [[$3|panel $4]]',
	'forum-recentchanges-new-message' => 'pada [[$1|panel $2]]',
	'forum-recentchanges-edit' => 'pesan yang disunting',
	'forum-recentchanges-removed-thread' => 'menghapus diskusi "[[$1|$2]]" dari [[$3|Panel $4]]',
	'forum-recentchanges-removed-reply' => 'menghapus balasan dari "[[$1|$2]]" dari [[$3|Panel $4]]',
	'forum-recentchanges-restored-thread' => 'diskusi telah di pulihkan "[[$1|$2]]" pada [[$3|Panel $4]]',
	'forum-recentchanges-restored-reply' => 'balasan telah dipulihkan pada "[[$1|$2]]" dari [[$3|Panel $4]]',
	'forum-recentchanges-deleted-thread' => 'menghapus diskusi "[[$1|$2]]" dari [[$3|Panel $4]]',
	'forum-recentchanges-deleted-reply' => 'menghapus balasan dari "[[$1|$2]]" dari [[$3|Panel $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Kiriman',
	'forum-recentchanges-namespace-selector-message-wall' => 'Panel Forum',
	'forum-recentchanges-thread-group' => '$1 pada [[$2|Panel $3]]',
	'forum-recentchanges-history-link' => 'riwayat panel',
	'forum-recentchanges-thread-history-link' => 'riwayat diskusi',
	'forum-recentchanges-closed-thread' => 'diskusi ditutup "[[$1|$2]]" dari [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'diskusi dibuka lagi "[[$1|$2]]" dari [[$3|$4]]',
	'forum-board-history-title' => 'riwayat panel',
	'forum-specialpage-oldforum-link' => 'Arsip forum lama',
	'forum-admin-page-breadcrumb' => 'Panel Manajemen Pengurus',
	'forum-admin-create-new-board-label' => 'Membuat Panel Baru',
	'forum-admin-create-new-board-modal-heading' => 'Membuat panel baru',
	'forum-admin-create-new-board-title' => 'Judul Panel',
	'forum-admin-create-new-board-description' => 'Deskripsi Panel',
	'forum-admin-edit-board-modal-heading' => 'Menyunting Panel: $1',
	'forum-admin-edit-board-title' => 'Judul Panel',
	'forum-admin-edit-board-description' => 'Deskripsi Panel',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Hapus Panel: $1',
	'forum-admin-delete-board-title' => 'Harap konfirmasikan nama panel yang ingin anda hapus:',
	'forum-admin-merge-board-warning' => 'Diskusi panel di forum akan digabung dengan panel yang sudah ada.',
	'forum-admin-merge-board-destination' => 'Pilih panel untuk digabungkan ke:',
	'forum-admin-delete-and-merge-button-label' => 'Hapus dan Gabungkan',
	'forum-admin-link-label' => 'Mengelola Panel',
	'forum-autoboard-title-1' => 'Diskusi Umum',
	'forum-autoboard-body-1' => 'Panel ini untuk percakapan umum tentang wiki.',
	'forum-autoboard-title-2' => 'Berita dan Pengumuman',
	'forum-autoboard-body-2' => 'Berita terbaru dan informasi!',
	'forum-autoboard-title-3' => 'Baru pada $1',
	'forum-autoboard-body-3' => 'Ingin berbagi sesuatu yang telah di kirim di wiki ini, atau mengucapkan selamat kepada seseorang dengan kontribusinya yang luar biasa? Inilah tempatnya!',
	'forum-autoboard-title-4' => 'Pertanyaan dan Jawaban',
	'forum-autoboard-body-4' => 'Punya pertanyaan tentang wiki, atau topik? Ajukan pertanyaan anda disini!',
	'forum-autoboard-title-5' => 'Minat dan Permainan',
	'forum-autoboard-body-5' => 'Panel ini adalah untuk percakapan diluar topik -- sebuah tempat untuk berkumpul dengan teman-teman anda $1.',
	'forum-board-destination-empty' => '(Silahkan pilih panel)',
	'forum-board-title-validation-invalid' => 'Nama panel berisi karakter yang tidak valid',
	'forum-board-title-validation-length' => 'Nama Panel harus minimal 4 karakter',
	'forum-board-title-validation-exists' => 'Sebuah panel dengan nama yang sama sudah ada',
	'forum-board-validation-count' => 'Jumlah maksimum panel adalah $1',
	'forum-board-description-validation-length' => 'Silahkan menulis deskripsi untuk panel ini',
	'forum-board-id-validation-missing' => 'Panel id telah menghilang',
	'forum-board-no-board-warning' => 'Tidak ada panel forum dengan nama judul tersebut. Silahkan coba lagi atau cek daftar Panel Forum.',
	'forum-related-discussion-heading' => 'Diskusi tentang $1',
	'forum-related-discussion-total-replies' => 'pesan $1',
	'forum-related-discussion-see-more' => 'Lihat diskusi selengkapnya',
	'forum-confirmation-board-deleted' => '"$1" telah dihapus.',
	'forum-token-mismatch' => 'Ups! token tidak sesuai',
	'right-forumadmin' => 'Pengurus memiliki askes ke forum',
	'right-forumoldedit' => 'Dapt menyunting arsip forum, yang lama',
	'right-boardedit' => 'Menyunting informasi panel Forum',
);

$messages['it'] = array(
	'forum-forum-title' => 'Forum',
	'forum-specialpage-heading' => 'Forum',
	'forum-policies-and-faq' => "== Politiche sui forum ==
Prima di contribuire ai Forum di {{SITENAME}}, tieni a mente alcune buone pratiche di condotta:

'''Sii gentile e tratta le persone con rispetto.'''
: Le persone di tutto il mondo leggono e modificano questa wiki e i suoi forum. Proprio come ogni altro progetto in collaborazione, non tutti saranno sempre d'accordo. Mantieni le discussioni su un tono civile e sii aperto mentalmente alle opinioni differenti. Siamo qui perché amiamo tutti lo stesso argomento.

'''Prova prima a trovare discussioni già esistenti, ma non avere timore di avviarne una nuova.'''
: Dedica un momento per cercare tra i sottoforum di {{SITENAME}} per vedere se esiste già una discussione su qualcosa di cui vuoi parlare. Se non trovi ciò che stai cercando, buttati e avvia una nuova discussione!

'''Chiedi aiuto.'''
: Noti qualcosa che non sembra giusto? O hai una domanda? Chiedi aiuto qui nei forum! Se hai bisogno di assistenza da parte del personale FANDOM, contattaci sulla [[w:it:|Wiki della Community]] o tramite [[Special:Contact]].

'''Divertiti!'''
: La comunità di {{SITENAME}} è lieta di averti qui. Non vediamo l'ora che partecipi alle discussioni di questo argomento che tutti amiamo.

== Domande frequenti sui forum ==
'''Come posso restare aggiornato sulle discussioni a cui sono interessato?'''
: Con un account utente FANDOM, puoi seguire conversazioni specifiche e ricevere messaggi di notifica (sul sito o per e-mail) quando una discussione contiene altre attività. Accertati di [[Special:UserSignup|registrarti a un account FANDOM]] se non lo hai già fatto.

'''Come posso rimuovere il vandalismo?'''
: Se noti della spam o del vandalismo su un thread, passa il mouse sopra il testo offensivo. Sarà visualizzato un pulsante \"Altro\". All'interno del menu \"Altro\", troverai \"Rimuovi\". Ciò ti consentirà di rimuovere il vandalismo e, opzionalmente, di informare un amministratore.

'''Cosa sono i Kudos?'''
: Se trovi una particolare discussione o risposta interessante, ben ponderata o divertente, puoi dimostrare il tuo apprezzamento assegnandole dei Kudos. Essi sono utili anche per votare.

'''Cosa sono gli argomenti?'''
: Gli argomenti ti consentono di collegare la discussione su un forum a un articolo della wiki. Rappresentano un altro modo per tenere organizzati i Forum e aiutare le persone a trovare discussioni interessanti. Ad esempio, una conversazione di forum taggata con ''Lord Voldemort'' sarà visualizzato in fondo all'articolo ''Lord Voldemort''.",
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|discussione attiva|discussioni attive}} su: $2',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|discussione attiva|discussioni attive}}',
	'forum-activity-module-heading' => 'Attività del Forum',
	'forum-activity-module-posted' => '$1 ha inserito una risposta $2',
	'forum-activity-module-started' => '$1 ha iniziato una discussione $2',
	'forum-admin-create-new-board-description' => 'Descrizione del sottoforum',
	'forum-admin-create-new-board-label' => 'Crea nuovo sottoforum',
	'forum-admin-create-new-board-modal-heading' => 'Crea un nuovo sottoforum',
	'forum-admin-create-new-board-title' => 'Titolo del sottoforum',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Cancella il sottoforum: $1',
	'forum-admin-delete-and-merge-button-label' => 'Cancella e sposta',
	'forum-admin-delete-board-title' => 'Per favore conferma inserendo il nome del sottoforum che vuoi cancellare:',
	'forum-admin-edit-board-description' => 'Descrizione del sottoforum',
	'forum-admin-edit-board-modal-heading' => 'Modifica il sottoforum: $1',
	'forum-admin-edit-board-title' => 'Titolo del sottoforum',
	'forum-admin-link-label' => 'Gestisci i sottoforum',
	'forum-admin-merge-board-destination' => 'Scegli un sottoforum in cui spostarle:',
	'forum-admin-merge-board-warning' => 'Le discussioni di questo sottoforum saranno spostate in un altro sottoforum.',
	'forum-admin-page-breadcrumb' => 'Amministrazione dei sottoforum',
	'forum-autoboard-body-1' => 'Questo sottoforum è per le discussioni generali sulla wiki.',
	'forum-autoboard-body-2' => 'Notizie e informazioni importanti!',
	'forum-autoboard-body-3' => 'Vuoi condividere qualcosa che è stato appena pubblicato su questa wiki o complimentarti con qualcuno per un suo contributo notevole? Questo è il posto giusto!',
	'forum-autoboard-body-4' => 'Hai una domanda sulla wiki o sul suo argomento? Fai qui le tue domande!',
	'forum-autoboard-body-5' => 'Questo sottoforum è per le discussioni off-topic, un posto per frequentare i tuoi amici di $1.',
	'forum-autoboard-title-1' => 'Discussioni generali',
	'forum-autoboard-title-2' => 'Notizie e annunci',
	'forum-autoboard-title-3' => 'Novità su $1',
	'forum-autoboard-title-4' => 'Domande e risposte',
	'forum-autoboard-title-5' => 'Divertimento',
	'forum-board-description-validation-length' => 'Per favore scrivi una descrizione per questo sottoforum',
	'forum-board-destination-empty' => '(Per favore scegli un sottoforum)',
	'forum-board-history-title' => 'cronologia del sottoforum',
	'forum-board-id-validation-missing' => 'Il sottoforum non esiste',
	'forum-board-new-message-heading' => 'Inizia una discussione',
	'forum-board-no-board-warning' => 'Non esiste nessun sottoforum con quel titolo. Per favore, riprova o controlla questa lista di sottoforum.',
	'forum-board-thread-follow' => 'Segui',
	'forum-board-thread-following' => 'Seguita',
	'forum-board-thread-kudos' => '$1 Kudos',
	'forum-board-thread-replies' => '{{PLURAL:$1|$1 risposta|$1 risposte}}',
	'forum-board-title-validation-exists' => 'Esiste già un sottoforum con questo nome',
	'forum-board-title-validation-invalid' => 'Il nome del sottoforum contiene caratteri non validi',
	'forum-board-title-validation-length' => 'Il nome del sottoforum deve contenere almeno 4 caratteri',
	'forum-board-title' => 'Sottoforum - $1',
	'forum-board-topic-title' => 'Discussioni su $1',
	'forum-board-topics' => 'Argomenti',
	'forum-board-validation-count' => 'Il numero massimo di sottoforum è $1',
	'forum-confirmation-board-deleted' => '"$1" è stato cancellato.',
	'forum-contributions-line' => '[[$1|$2]] nel [[$3|sottoforum $4]]',
	'forum-discussion-highlight' => 'Evidenzia questa discussione',
	'forum-discussion-placeholder-message-short' => 'Pubblica un nuovo post',
	'forum-discussion-placeholder-message' => 'Inserisci un nuovo messaggio nel sottoforum $1',
	'forum-discussion-placeholder-title' => 'Di cosa vuoi parlare?',
	'forum-discussion-post' => 'Inserisci',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Discussione<br> Attiva|Discussioni<br> Attive}}</span>',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Discussione<br> in questo Forum|Discussioni<br> in questo Forum}}</span>',
	'forum-no-board-selection-error' => '← Per favore scegli un sottoforum in cui scrivere',
	'forum-notification-newmsg-on-followed-wall' => '$1 ha lasciato un messaggio nel sottoforum $2',
	'forum-notification-user1-reply-to-someone' => '$1 ha risposto nel sottoforum $3',
	'forum-notification-user1-reply-to-your' => '$1 ha risposto alla tua discussione nel sottoforum $3',
	'forum-notification-user2-reply-to-someone' => '$1 e $2 hanno risposto nel sottoforum $3',
	'forum-notification-user2-reply-to-your' => '$1 e $2 hanno risposto alla tua discussione nel sottoforum $3',
	'forum-notification-user3-reply-to-someone' => '$1 e altri utenti hanno risposto nel sottoforum $3',
	'forum-notification-user3-reply-to-your' => '$1 e altri utenti hanno risposto alla tua discussione nel sottoforum $3',
	'forum-recentchanges-closed-thread' => 'ha chiuso la discussione "[[$1|$2]]" in [[$3|$4]]',
	'forum-recentchanges-deleted-reply-title' => 'un post',
	'forum-recentchanges-deleted-reply' => 'ha cancellato una risposta da "[[$1|$2]]" nel [[$3|sottoforum $4]]',
	'forum-recentchanges-deleted-thread' => 'ha cancellato la discussione "[[$1|$2]]" dal [[$3|sottoforum $4]]',
	'forum-recentchanges-edit' => 'messaggio modificato',
	'forum-recentchanges-history-link' => 'cronologia del sottoforum',
	'forum-recentchanges-namespace-selector-message-wall' => 'Sottoforum',
	'forum-recentchanges-new-message' => 'nel [[$1|sottoforum $2]]',
	'forum-recentchanges-removed-reply' => 'ha rimosso una risposta da "[[$1|$2]]" nel [[$3|sottoforum $4]]',
	'forum-recentchanges-removed-thread' => 'ha rimosso la discussione "[[$1|$2]]" dal [[$3|sottoforum $4]]',
	'forum-recentchanges-reopened-thread' => 'ha riaperto la discussione "[[$1|$2]]" in [[$3|$4]]',
	'forum-recentchanges-restored-reply' => 'ha ripristinato una risposta a "[[$1|$2]]" nel [[$3|sottoforum $4]]',
	'forum-recentchanges-restored-thread' => 'ha ripristinato la discussione "[[$1|$2]]" nel [[$3|sottoforum $4]]',
	'forum-recentchanges-thread-group' => '$1 nel [[$2|sottoforum $3]]',
	'forum-recentchanges-thread-history-link' => 'cronologia della discussione',
	'forum-related-discussion-heading' => 'Discussioni su $1',
	'forum-related-discussion-new-post-button' => 'Inizia una discussione',
	'forum-related-discussion-new-post-tooltip' => 'Inizia una nuova discussione su $1',
	'forum-related-discussion-see-more' => 'Vedi altre discussioni',
	'forum-related-discussion-total-replies' => '$1 messaggi',
	'forum-related-module-heading' => 'Discussioni correlate',
	'forum-sorting-option-most-replies' => 'Più attive negli ultimi 7 giorni',
	'forum-sorting-option-newest-replies' => 'Risposte più recenti',
	'forum-sorting-option-newest-threads' => 'Discussioni più recenti',
	'forum-sorting-option-oldest-threads' => 'Discussioni più vecchie',
	'forum-sorting-option-popular-threads' => 'Più popolari',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Puoi modificarlo<span>',
	'forum-specialpage-board-lastpostby' => 'Ultimo post di',
	'forum-specialpage-board-posts' => '{{formatnum:$1}} {{PLURAL:$1|post|post}}',
	'forum-specialpage-board-threads' => '{{formatnum:$1}} {{PLURAL:$1|discussione|discussioni}}',
	'forum-specialpage-oldforum-link' => 'Archivi del vecchio forum',
	'forum-specialpage-policies-edit' => 'Modifica',
	'forum-specialpage-policies' => 'Politiche del Forum / FAQ',
	'forum-thread-deleted-return-to' => 'Torna al sottoforum $1',
	'forum-thread-reply-placeholder' => 'Inserisci una risposta',
	'forum-thread-reply-post' => 'Rispondi',
	'forum-wiki-activity-msg-name' => 'sottoforum $1',
	'forum-wiki-activity-msg' => 'nel $1',
	'forum-desc' => "L'estensione Speciale:Forum di FANDOM",
	'forum-disabled-desc' => "L'estensione Speciale:Forum di FANDOM; disabilitata",
	'forum-specialpage-blurb' => '',
	'forum-token-mismatch' => 'Ops! Il token non corrisponde',
	'right-forumadmin' => 'Ha accesso da amministratore al forum',
	'right-forumoldedit' => 'Può modificare i vecchi forum archiviati',
	'right-boardedit' => 'Modificare la descrizione dei sottoforum',
);

$messages['ja'] = array(
	'forum-forum-title' => 'フォーラム',
	'forum-active-threads' => '$1 件のスレッドがアクティブです',
	'forum-active-threads-on-topic' => "'''[[$2]]'''を話題にしてるスレッドでアクティブなものは $1 件です",
	'forum-header-total-threads' => '<em>$1</em><span>件のスレッドが<br />このフォーラムにあります</span>',
	'forum-header-active-threads' => '<em>$1</em><span>件のスレッドが<br />アクティブです</span>',
	'forum-specialpage-heading' => 'フォーラム',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading こちらを編集できます</span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|件|件}} のスレッド',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|件|件}} の投稿があります',
	'forum-specialpage-board-lastpostby' => '最終投稿者:',
	'forum-specialpage-policies-edit' => '編集',
	'forum-specialpage-policies' => 'フォーラムポリシー／FAQ',
	'forum-policies-and-faq' => "==フォーラムポリシー==
{{SITENAME}}のフォーラムに投稿する際は、以下のことにご留意ください。

'''礼儀正しく、親切に'''
: このWikiやフォーラムは、世界中のユーザーが閲覧、編集します。多くの人が協力し合って作り上げる様々なプロジェクトに、意見の不一致はつきものです。話し合いではマナーを守って、異なる意見を受け入れる寛容性を持ちましょう。このフォーラムの参加者は、共通のテーマに強い関心を持って集まっているということを心に留めておいてください。

'''既存のスレッドを探しつつも、新しいスレッドを気軽に立てましょう'''
: 投稿したい話題について既にスレッドが存在しないか、まずは{{SITENAME}}のフォーラム内を探してみてください。見つからなかったときには、新しいスレッドを作成してみましょう。

'''助けを求めましょう'''
: 何かおかしなことに気付いた場合や質問がある場合は、フォーラムで助けを求めてみましょう。FANDOMスタッフによるサポートが必要な場合は、[[w:c:ja.community|コミュニティ・セントラル]]または[[特別:お問い合わせ]]からご連絡ください。

'''楽しむことを大切に'''
: {{SITENAME}}のコミュニティではメンバーを歓迎します。共通のテーマに強い関心を持つメンバーからの投稿をお待ちしています。

==フォーラムについてのよくある質問==
'''関心のあるスレッドの最新情報を得るにはどうすればいいですか？'''
: FANDOMユーザーアカウントを作成すると、特定のスレッドをフォローして、そのスレッドが更新されたときにサイト上でまたはメールで通知を受け取ることができます。FANDOMアカウントをまだお持ちでない場合は、この機会にぜひ[[Special:UserSignup|作成]]してください。

'''荒らし行為を排除するにはどうすればいいですか？'''
: スレッド内でスパムや荒らしを見つけた場合は、そのテキストにカーソルを合わせてください。表示された「その他」ボタンをクリックしてメニューから「除去」を選択すると、荒らし投稿を除去し、必要に応じてアドミンに報告することができます。

'''「イイね！」とは何ですか？'''
: 興味深い、よく考えられている、おもしろい、といったスレッドや返信を見つけたら、「イイね！」をクリックして、そのスレッドや返信に対する好感度を表現することができます。このボタンは、投票機能の代わりにもなります。

'''「トピック」とは何ですか？'''
: トピックを使用すると、フォーラムのスレッドとWikiの記事をリンクさせることができます。こうすることでフォーラムが整理され、ユーザーが興味のあるスレッドを見つけやすくなります。たとえば、フォーラムのスレッドに「ヴォルデモート卿」というトピックを付けると、「ヴォルデモート卿」の記事の下部にそのスレッドが表示されます。",
	'forum-board-title' => '$1板',
	'forum-board-topic-title' => '$1 に関連するスレッド',
	'forum-board-topics' => 'タグ',
	'forum-board-thread-follow' => 'フォローする',
	'forum-board-thread-following' => 'フォロー中',
	'forum-board-thread-kudos' => 'イイね！$1 件',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|件|件}} の返信',
	'forum-board-new-message-heading' => 'スレッドを作成',
	'forum-no-board-selection-error' => '← 投稿する掲示板を選択してください',
	'forum-thread-reply-placeholder' => '返信を投稿',
	'forum-thread-reply-post' => '返信',
	'forum-thread-deleted-return-to' => '$1板に戻る',
	'forum-sorting-option-newest-replies' => '新しい返信のついたスレッドを表示',
	'forum-sorting-option-popular-threads' => '人気のスレッドを表示',
	'forum-sorting-option-most-replies' => '最近7日間でアクティブなものを表示',
	'forum-sorting-option-newest-threads' => '新しいスレッドを表示',
	'forum-sorting-option-oldest-threads' => '前のスレッドを表示',
	'forum-discussion-post' => '投稿',
	'forum-discussion-highlight' => 'このスレッドをハイライトする',
	'forum-discussion-placeholder-title' => 'スレッドタイトルを入力',
	'forum-discussion-placeholder-message' => '$1板に投稿するメッセージを入力',
	'forum-discussion-placeholder-message-short' => '投稿するメッセージを入力',
	'forum-notification-user1-reply-to-your' => '$1 が $3板 であなたが作成したスレッドに返信を投稿しました',
	'forum-notification-user2-reply-to-your' => '$1 と $2 が $3板 であなたが作成したスレッドに返信を投稿しました',
	'forum-notification-user3-reply-to-your' => '$1 とその他複数の人が $3 であなたが作成したスレッドに返信を投稿しました',
	'forum-notification-user1-reply-to-someone' => '$1 が $3板 で返信を投稿しました',
	'forum-notification-user2-reply-to-someone' => '$1 と $2 が $3板 で返信を投稿しました',
	'forum-notification-user3-reply-to-someone' => '$1 とその他複数が $3 で返信を投稿しました',
	'forum-notification-newmsg-on-followed-wall' => '$1 が $2板 で新しいスレッドを作成しました',
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
	'forum-recentchanges-removed-thread' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] からスレッド「[[$1|$2]]」を除去しました',
	'forum-recentchanges-removed-reply' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] のスレッド「[[$1|$2]]」から返信を除去しました',
	'forum-recentchanges-restored-thread' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] にスレッド「[[$1|$2]]」を元に戻しました',
	'forum-recentchanges-restored-reply' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] のスレッド「[[$1|$2]]」の返信を元に戻しました',
	'forum-recentchanges-deleted-thread' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] からスレッド「[[$1|$2]]」を削除しました',
	'forum-recentchanges-deleted-reply' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] のスレッド「[[$1|$2]]」から返信を削除しました',
	'forum-recentchanges-deleted-reply-title' => '投稿',
	'forum-recentchanges-namespace-selector-message-wall' => 'フォーラムの掲示板',
	'forum-recentchanges-thread-group' => '$1 -- [[$2|$3板]]',
	'forum-recentchanges-history-link' => '掲示板の履歴',
	'forum-recentchanges-thread-history-link' => 'スレッドの履歴',
	'forum-recentchanges-closed-thread' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] のスレッド「[[$1|$2]]」を閉じました',
	'forum-recentchanges-reopened-thread' => '{{Gender:$5|さん|さん}} が[[$3|$4板]] のスレッド「[[$1|$2]]」を再開しました',
	'forum-board-history-title' => '掲示板の履歴',
	'forum-specialpage-oldforum-link' => '旧フォーラムのアーカイブ',
	'forum-admin-page-breadcrumb' => 'アドミン用掲示板管理ページ',
	'forum-admin-create-new-board-label' => '新しい掲示板を作成',
	'forum-admin-create-new-board-modal-heading' => '新しい掲示板を作成',
	'forum-admin-create-new-board-title' => '掲示板のタイトル',
	'forum-admin-create-new-board-description' => 'この掲示板について',
	'forum-admin-edit-board-modal-heading' => '掲示板を編集: $1',
	'forum-admin-edit-board-title' => '掲示板のタイトル',
	'forum-admin-edit-board-description' => 'この掲示板について',
	'forum-admin-delete-and-merge-board-modal-heading' => '掲示板を削除: $1',
	'forum-admin-delete-board-title' => '確認のため、削除する掲示板の名称を入力してください:',
	'forum-admin-merge-board-warning' => 'この掲示板にあるスレッドは、既存の掲示板に統合されます。',
	'forum-admin-merge-board-destination' => '統合先の掲示板を選択:',
	'forum-admin-delete-and-merge-button-label' => '削除および統合',
	'forum-admin-link-label' => '掲示板の管理',
	'forum-autoboard-title-1' => '総合',
	'forum-autoboard-body-1' => 'この掲示板は、このWikiに関する話題全般にご利用ください。',
	'forum-autoboard-title-2' => 'ニュースとお知らせ',
	'forum-autoboard-body-2' => '最新ニュースと最新情報！',
	'forum-autoboard-title-3' => '$1の最新投稿',
	'forum-autoboard-body-3' => '最近のこのWikiでの投稿をシェアしたり、気に入った他のユーザーからの投稿を紹介しませんか？ここはそんなことに最適な場です。',
	'forum-autoboard-title-4' => '質問と回答',
	'forum-autoboard-body-4' => 'このWiki、サイト内のテーマに関する質問はこちら。',
	'forum-autoboard-title-5' => '雑談',
	'forum-autoboard-body-5' => 'サイトのテーマから外れる話題はこちらへ。$1のユーザー同士の交流にどうぞ。',
	'forum-board-destination-empty' => '（掲示板を選択）',
	'forum-board-title-validation-invalid' => '掲示板名に不適切な文字が含まれています',
	'forum-board-title-validation-length' => '掲示板名は4文字以上にしてください',
	'forum-board-title-validation-exists' => '同名の掲示板が既に存在します',
	'forum-board-validation-count' => '掲示板の最大数は $1 です',
	'forum-board-description-validation-length' => 'この掲示板についての説明を入力してください',
	'forum-board-id-validation-missing' => '掲示板のIDが見つかりません',
	'forum-board-no-board-warning' => '指定されたタイトルのボードは見つかりませんでした。もう一度お試しになるか、フォーラムのボード一覧をご確認ください。',
	'forum-related-discussion-heading' => '$1 に関連するスレッド',
	'forum-related-discussion-new-post-button' => 'スレッドを作成',
	'forum-related-discussion-new-post-tooltip' => '$1 に関するスレッドを作成',
	'forum-related-discussion-total-replies' => '$1 件の投稿',
	'forum-related-discussion-see-more' => 'さらにスレッドを見る',
	'forum-confirmation-board-deleted' => '「$1」を削除しました。',
	'forum-token-mismatch' => 'おっと! トークンが一致しません',
	'forum-desc' => 'FANDOM の特別: フォーラム拡張',
	'forum-disabled-desc' => 'FANDOM の特別: フォーラム拡張;無効',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => 'フォーラムでアドミンの権限を持つ',
	'right-forumoldedit' => '旧フォーラムのアーカイブを編集することができます',
	'right-boardedit' => 'フォーラムのボードの情報を編集できる',
);

$messages['kn'] = array(
	'forum-specialpage-policies-edit' => 'ಸಂಪಾದಿಸಿ',
	'forum-thread-reply-post' => 'ಉತ್ತರಿಸಿ',
);

$messages['ko'] = array(
	'forum-desc' => '위키아 특수기능:포럼 확장 기능',
	'forum-disabled-desc' => '위키아 특수기능:포럼 확장 기능; 비활성',
	'forum-forum-title' => '포럼',
	'forum-active-threads' => '현재 {{FORMATNUM:$1}}개의 주제 활성화됨',
	'forum-active-threads-on-topic' => '$2에 대해 활성화된 토론이 {{FORMATNUM:$1}}개 있습니다.',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>총 토론<br />개 보유</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>총 토론<br />개 진행중</span>',
	'forum-specialpage-heading' => '포럼',
	'forum-specialpage-board-threads' => '모든 주제 $1개',
	'forum-specialpage-board-posts' => '글 $1개',
	'forum-specialpage-board-lastpostby' => '마지막 기여한 사용자:',
	'forum-specialpage-policies-edit' => '편집',
	'forum-specialpage-policies' => '포럼 운영 정책 / 자주 묻는 질문',
	'forum-policies-and-faq' => "== 포럼 운영 정책 ==
{{SITENAME}} 포럼에 참여하시기 전에 다음 사항들에 주의해주세요.

'''토론에 참여하는 다른 사용자들을 존중해주세요.'''
: 불특정 다수가 이 위키의 내용을 보고 기여하며 토론에 참여합니다. 여느 협업 프로젝트가 그렇듯이 모든 사람이 늘 한 의견에 동의하지는 않습니다. 항상 열린 마음으로 냉정하게 토론에 임해주시기 바랍니다. 이 위키에 기여해주시는 사용자 분들은 모두 한 주제에 대해 열정을 가지고 계시기 때문에 모였습니다.

'''이미 진행중인 토론이 있다면 새 주제가 아니라 그 곳에서 토론에 참여해주세요. 토론 주제가 아직 만들어지지 않았다면 새 주제를 만들어주시면 됩니다.'''
: 새 토론을 시작하기 전에 {{SITENAME}} 포럼에 이미 존재하는 토론이 있는지 살펴봐주세요. 이미 진행중인 토론이 있다면 그 곳에 참여하는 것이 여러 사람들의 의견을 하나로 모으기에 더 좋습니다. 만약 찾는 토론이 없다면 바로 새 주제를 시작해주시면 됩니다.

'''도움이 필요하다면 도움을 요청하세요.'''
: 질문이 있으시거나 뭔가 올바르지 않은 상황을 목격하셨나요? 포럼에서 다른 사용자에게 도움을 요청하세요! 만약 위키아 스탭의 도움이 필요한 경우 [[Special:Contact|문의 양식]]을 통해 도움을 요청할 수 있습니다.

'''즐기세요!'''
: {{SITENAME}} 포럼에서 선호하는 주제를 공유하는 사람들과 즐거운 시간 보내시기 바랍니다!

== 포럼에 대해 자주 묻는 질문 ==
'''관심 있는 주제를 주시하려면 어떻게 해야 하나요?'''
: 위키아에 계정이 있다면 주제를 '주시'해서 해당 주제의 변경점을 이메일이나 사이트에서 바로 알림받을 수 있습니다.

'''문서 훼손 행위를 되돌리려면 어떻게 해야 하나요?'''
: 포럼 글에 스팸 등의 문서 훼손 행위를 목격하셨다면 해당 글에 마우스를 올린 후에 나타나는 '도구' 버튼을 눌러주세요. '도구' 버튼을 누른 후에 나타나는 메뉴에서 '숨기기' 메뉴를 선택하시면 문서 훼손 행위를 없앨 수 있고 추가적으로 관리자에게 알릴 수도 있습니다.

'''추천 기능에 대해 알려주세요.'''
: 흥미로운 주제나 질 좋은 답글이 있다면 '추천' 버튼을 눌러 다른 사용자들에게 추천할 수 있습니다. 

'''태그 기능에 대해 알려주세요.'''
: 위키 내의 특정한 문서에 대하여 토론하고 있다면 해당 글을 토론 주제에 '태그'할 수 있습니다. 이렇게 태그한 토론 주제들은 해당 문서 아래에 보여지게 되며 다른 사용자들이 참여하기에 용이하게 해주고 포럼을 좀 더 조직적으로 관리할 수 있도록 해줍니다. 예를 들어 '볼드모트 경'을 토론 주제에 태그한다면 해당 글은 '볼드모트 경' 문서 아래에 보여지게 됩니다.",
	'forum-board-title' => '$1 게시판',
	'forum-board-topic-title' => '$1에 대한 토론',
	'forum-board-topics' => '태그',
	'forum-board-thread-follow' => '주시',
	'forum-board-thread-following' => '주시하는 중',
	'forum-board-thread-kudos' => '추천 $1회',
	'forum-board-thread-replies' => '답글 $1개',
	'forum-board-new-message-heading' => '새 주제를 시작하세요.',
	'forum-no-board-selection-error' => '← 이 글을 게시할 게시판을 선택하세요.',
	'forum-thread-reply-placeholder' => '답글 쓰기',
	'forum-thread-reply-post' => '답글 작성',
	'forum-thread-deleted-return-to' => '$1 게시판으로 돌아가기',
	'forum-sorting-option-newest-replies' => '최근 답글순',
	'forum-sorting-option-popular-threads' => '인기순',
	'forum-sorting-option-most-replies' => '7일간 활동도순',
	'forum-sorting-option-newest-threads' => '최근순',
	'forum-sorting-option-oldest-threads' => '오래된순',
	'forum-discussion-post' => '게시',
	'forum-discussion-highlight' => '이 글을 강조하기',
	'forum-discussion-placeholder-title' => '메시지 제목',
	'forum-discussion-placeholder-message' => '$1 게시판에 새 메시지 남기기',
	'forum-discussion-placeholder-message-short' => '새 메시지 남기기',
	'forum-notification-user1-reply-to-your' => '$1님께서 $3 게시판에 회원님께서 게시하신 주제에 답글을 달았습니다.',
	'forum-notification-user2-reply-to-your' => '$1님과 $2님께서 $3 게시판에 회원님께서 게시한 주제에 답글을 달았습니다.',
	'forum-notification-user3-reply-to-your' => '$1님과 다른 분들께서 $3 게시판에 회원님이 게시판 주제에 답글을 달았습니다.',
	'forum-notification-user1-reply-to-someone' => '$1님께서 $3 게시판에 있는 주제에 답글을 달았습니다.',
	'forum-notification-user2-reply-to-someone' => '$1님과 $2님께서 $3 게시판에 있는 주제에 답글을 달았습니다.',
	'forum-notification-user3-reply-to-someone' => '$1님과 다른 분들께서 $3 게시판에 있는 주제에 답글을 달았습니다.',
	'forum-notification-newmsg-on-followed-wall' => '$1님께서 $2 게시판에 새 주제를 시작했습니다.',
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
	'forum-mail-notification-body-HTML' => '$WATCHER님 안녕하세요.
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">글 보기</a></p>
			<p>위키아 팀 드림</p>
___________________________________________<br>
* 중앙 커뮤니티에서 도움말과 조언을 찾아볼 수 있습니다. http://community.wikia.com
* 위키아에서 받는 메일을 줄이고 싶으신가요? 다음 링크에서 설정하실 수 있습니다. http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => '$1의 새 주제',
	'forum-wiki-activity-msg-name' => '$1 게시판',
	'forum-activity-module-heading' => '최근 포럼 활동',
	'forum-related-module-heading' => '관련 토론',
	'forum-activity-module-posted' => '$2 $1 사용자가 답글을 추가함',
	'forum-activity-module-started' => '$2 $1 사용자가 새 주제를 시작함',
	'forum-contributions-line' => '[[$3|$4 게시판]]의 [[$1|$2]] 글',
	'forum-recentchanges-new-message' => '[[$1|$2 게시판]] 에 남긴 새 주제',
	'forum-recentchanges-edit' => '메시지 수정됨',
	'forum-recentchanges-removed-thread' => '[[$3|$4 게시판]]에 있는 "[[$1|$2]]" 글을 숨김',
	'forum-recentchanges-removed-reply' => '[[$3|$4 게시판]]에 있는 "[[$1|$2]]" 글에 달린 답글을 숨김',
	'forum-recentchanges-restored-thread' => '[[$3|$4 게시판]]에 있는 "[[$1|$2]]" 글을 복구함',
	'forum-recentchanges-restored-reply' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 글에 있는 답글을 복구함',
	'forum-recentchanges-deleted-thread' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 주제가 삭제됨',
	'forum-recentchanges-deleted-reply' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 주제에 달린 답글이 삭제됨',
	'forum-recentchanges-deleted-reply-title' => '글',
	'forum-recentchanges-namespace-selector-message-wall' => '포럼 게시판',
	'forum-recentchanges-thread-group' => '[[$2|$3 게시판]]의 글 $1',
	'forum-recentchanges-history-link' => '게시판 역사',
	'forum-recentchanges-thread-history-link' => '주제 역사',
	'forum-board-history-title' => '게시판 역사',
	'forum-specialpage-oldforum-link' => '옛 포럼 보존문서',
	'forum-admin-page-breadcrumb' => '게시판 관리',
	'forum-admin-create-new-board-label' => '새 게시판 생성',
	'forum-admin-create-new-board-modal-heading' => '새 게시판 생성하기',
	'forum-admin-create-new-board-title' => '게시판 이름',
	'forum-admin-create-new-board-description' => '게시판 설명',
	'forum-admin-edit-board-modal-heading' => '게시판 수정하기: $1',
	'forum-admin-edit-board-title' => '게시판 이름',
	'forum-admin-edit-board-description' => '게시판 설명',
	'forum-admin-delete-and-merge-board-modal-heading' => '게시판 삭제하기: $1',
	'forum-admin-delete-board-title' => '게시판을 정말로 삭제하시려면 다음 칸에 게시판 이름을 입력하세요:',
	'forum-admin-merge-board-warning' => '이 게시판의 글들이 다른 게시판에 병합됩니다.',
	'forum-admin-merge-board-destination' => '병합할 게시판:',
	'forum-admin-delete-and-merge-button-label' => '삭제 및 병합',
	'forum-admin-link-label' => '게시판 관리',
	'forum-autoboard-title-1' => '종합 토론',
	'forum-autoboard-body-1' => '이 게시판은 위키의 일반적인 토론을 위한 공간입니다.',
	'forum-autoboard-title-2' => '새 소식과 공지사항',
	'forum-autoboard-body-2' => '새 소식과 정보를 얻고 싶다면 이 게시판을 방문해보세요.',
	'forum-autoboard-title-3' => '$1의 최근 동향',
	'forum-autoboard-body-3' => '이 위키에 갓 기여한 내용이나 엄청난 기여를 한 사용자를 칭찬하고 싶으시다면 이 곳에서 해주세요.',
	'forum-autoboard-title-4' => '질문과 답변',
	'forum-autoboard-body-4' => '이 위키나 특정한 주제에 대한 질문이 있으시다면 이 곳에서 답변을 얻으세요.',
	'forum-autoboard-title-5' => '자유게시판',
	'forum-autoboard-body-5' => '이 위키의 주제를 벗어나서 자유롭게 글을 게시할 수 있는 공간입니다.',
	'forum-board-destination-empty' => '(게시판 선택 필요)',
	'forum-board-title-validation-invalid' => '게시판 이름에 들어갈 수 없는 문자가 사용되었습니다.',
	'forum-board-title-validation-length' => '게시판 이름은 최소 4글자여야 합니다.',
	'forum-board-title-validation-exists' => '이미 이 위키에 존재하는 게시판의 이름을 입력하셨습니다. 다른 이름으로 시도해주세요.',
	'forum-board-validation-count' => '게시판은 최대 $1개까지만 만들 수 있습니다.',
	'forum-board-description-validation-length' => '게시판의 설명을 입력해주세요.',
	'forum-board-id-validation-missing' => '게시판 고유 번호(ID)를 불러오지 못했습니다.',
	'forum-board-no-board-warning' => '입력하신 이름을 가진 게시판이 이 위키에 없습니다. 다음은 이 위키의 포럼에 존재하는 모든 게시판의 목록입니다.',
	'forum-related-discussion-heading' => '$1에 대한 포럼 토론',
	'forum-related-discussion-new-post-button' => '새 주제 시작하기',
	'forum-related-discussion-new-post-tooltip' => '$1에 대한 새 토론을 포럼에서 시작합니다.',
	'forum-related-discussion-total-replies' => '$1개의 토론',
	'forum-related-discussion-see-more' => '포럼에서 더 많은 토론 보기',
	'forum-confirmation-board-deleted' => "'$1' 게시판이 삭제되었습니다.",
	'forum-recentchanges-closed-thread' => '[[$3|$4 게시판]]에서 "[[$1|$2]]" 주제를 닫음',
	'forum-recentchanges-reopened-thread' => '[[$3|$4 게시판]]의 "[[$1|$2]]" 글을 염',
	'forum-specialpage-blurb-heading' => '{{SITENAME}} 포럼에 오신 것을 환영합니다!',
);

$messages['ku-latn'] = array(
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
);

$messages['lb'] = array(
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
	'forum-related-discussion-heading' => 'Diskussiounen iwwer $1',
	'forum-related-discussion-new-post-button' => 'Eng Diskussioun ufänken',
	'forum-related-discussion-new-post-tooltip' => 'Eng nei Diskussioun iwwer $1 ufänken',
	'forum-related-discussion-total-replies' => '$1 Messagen',
	'forum-related-discussion-see-more' => 'Kuckt méi Diskussiounen',
	'forum-confirmation-board-deleted' => '"$1" gouf geläscht.',
);

$messages['lol'] = array(
	'forum-desc' => 'crwdns63259:0crwdne63259:0',
	'forum-disabled-desc' => 'crwdns63260:0crwdne63260:0',
	'forum-forum-title' => 'crwdns63261:0crwdne63261:0',
	'forum-active-threads' => 'crwdns63262:0{PLURAL:$1|Active Discussion|Active Discussions}crwdne63262:0',
	'forum-active-threads-on-topic' => 'crwdns63263:0{PLURAL:$1|Active Discussion|Active Discussions}crwdne63263:0',
	'forum-header-total-threads' => 'crwdns63264:0crwdne63264:0',
	'forum-header-active-threads' => 'crwdns63265:0crwdne63265:0',
	'forum-specialpage-heading' => 'crwdns63266:0crwdne63266:0',
	'forum-specialpage-blurb-heading' => 'crwdns63267:0crwdne63267:0',
	'forum-specialpage-blurb' => 'crwdns63268:0crwdne63268:0',
	'forum-specialpage-board-threads' => 'crwdns63269:0{PLURAL:$1|thread|threads}crwdne63269:0',
	'forum-specialpage-board-posts' => 'crwdns63270:0{PLURAL:$1|post|posts}crwdne63270:0',
	'forum-specialpage-board-lastpostby' => 'crwdns63271:0crwdne63271:0',
	'forum-specialpage-policies-edit' => 'crwdns63272:0crwdne63272:0',
	'forum-specialpage-policies' => 'crwdns63273:0crwdne63273:0',
	'forum-policies-and-faq' => 'crwdns66313:0{{SITENAME}}crwdnd66313:0{{SITENAME}}crwdnd66313:0{{SITENAME}}crwdne66313:0',
	'forum-board-title' => 'crwdns63275:0crwdne63275:0',
	'forum-board-topic-title' => 'crwdns63276:0crwdne63276:0',
	'forum-board-topics' => 'crwdns63277:0crwdne63277:0',
	'forum-board-thread-follow' => 'crwdns63278:0crwdne63278:0',
	'forum-board-thread-following' => 'crwdns63279:0crwdne63279:0',
	'forum-board-thread-kudos' => 'crwdns63280:0crwdne63280:0',
	'forum-board-thread-replies' => 'crwdns63281:0{PLURAL:$1|Message|Messages}crwdne63281:0',
	'forum-board-new-message-heading' => 'crwdns63282:0crwdne63282:0',
	'forum-no-board-selection-error' => 'crwdns63283:0crwdne63283:0',
	'forum-thread-reply-placeholder' => 'crwdns63284:0crwdne63284:0',
	'forum-thread-reply-post' => 'crwdns63285:0crwdne63285:0',
	'forum-thread-deleted-return-to' => 'crwdns63286:0crwdne63286:0',
	'forum-sorting-option-newest-replies' => 'crwdns63287:0crwdne63287:0',
	'forum-sorting-option-popular-threads' => 'crwdns63288:0crwdne63288:0',
	'forum-sorting-option-most-replies' => 'crwdns63289:0crwdne63289:0',
	'forum-sorting-option-newest-threads' => 'crwdns63290:0crwdne63290:0',
	'forum-sorting-option-oldest-threads' => 'crwdns63291:0crwdne63291:0',
	'forum-discussion-post' => 'crwdns63292:0crwdne63292:0',
	'forum-discussion-highlight' => 'crwdns63293:0crwdne63293:0',
	'forum-discussion-placeholder-title' => 'crwdns63294:0crwdne63294:0',
	'forum-discussion-placeholder-message' => 'crwdns63295:0crwdne63295:0',
	'forum-discussion-placeholder-message-short' => 'crwdns63296:0crwdne63296:0',
	'forum-notification-user1-reply-to-your' => 'crwdns63297:0{GENDER:$1|replied}crwdne63297:0',
	'forum-notification-user2-reply-to-your' => 'crwdns63298:0crwdne63298:0',
	'forum-notification-user3-reply-to-your' => 'crwdns63299:0crwdne63299:0',
	'forum-notification-user1-reply-to-someone' => 'crwdns63300:0{GENDER:$1|replied}crwdne63300:0',
	'forum-notification-user2-reply-to-someone' => 'crwdns63301:0crwdne63301:0',
	'forum-notification-user3-reply-to-someone' => 'crwdns63302:0crwdne63302:0',
	'forum-notification-newmsg-on-followed-wall' => 'crwdns63303:0{GENDER:$1|left}crwdne63303:0',
	'forum-wiki-activity-msg' => 'crwdns63304:0crwdne63304:0',
	'forum-wiki-activity-msg-name' => 'crwdns63305:0crwdne63305:0',
	'forum-activity-module-heading' => 'crwdns63306:0crwdne63306:0',
	'forum-related-module-heading' => 'crwdns63307:0crwdne63307:0',
	'forum-activity-module-posted' => 'crwdns63308:0crwdne63308:0',
	'forum-activity-module-started' => 'crwdns63309:0crwdne63309:0',
	'forum-contributions-line' => 'crwdns63310:0crwdne63310:0',
	'forum-recentchanges-new-message' => 'crwdns63311:0crwdne63311:0',
	'forum-recentchanges-edit' => 'crwdns63312:0crwdne63312:0',
	'forum-recentchanges-removed-thread' => 'crwdns63313:0crwdne63313:0',
	'forum-recentchanges-removed-reply' => 'crwdns63314:0crwdne63314:0',
	'forum-recentchanges-restored-thread' => 'crwdns63315:0crwdne63315:0',
	'forum-recentchanges-restored-reply' => 'crwdns63316:0crwdne63316:0',
	'forum-recentchanges-deleted-thread' => 'crwdns63317:0crwdne63317:0',
	'forum-recentchanges-deleted-reply' => 'crwdns63318:0crwdne63318:0',
	'forum-recentchanges-deleted-reply-title' => 'crwdns63319:0crwdne63319:0',
	'forum-recentchanges-namespace-selector-message-wall' => 'crwdns63320:0crwdne63320:0',
	'forum-recentchanges-thread-group' => 'crwdns63321:0crwdne63321:0',
	'forum-recentchanges-history-link' => 'crwdns63322:0crwdne63322:0',
	'forum-recentchanges-thread-history-link' => 'crwdns63323:0crwdne63323:0',
	'forum-recentchanges-closed-thread' => 'crwdns63324:0crwdne63324:0',
	'forum-recentchanges-reopened-thread' => 'crwdns63325:0crwdne63325:0',
	'forum-board-history-title' => 'crwdns63326:0crwdne63326:0',
	'forum-specialpage-oldforum-link' => 'crwdns63327:0crwdne63327:0',
	'forum-admin-page-breadcrumb' => 'crwdns63328:0crwdne63328:0',
	'forum-admin-create-new-board-label' => 'crwdns63329:0crwdne63329:0',
	'forum-admin-create-new-board-modal-heading' => 'crwdns63330:0crwdne63330:0',
	'forum-admin-create-new-board-title' => 'crwdns63331:0crwdne63331:0',
	'forum-admin-create-new-board-description' => 'crwdns63332:0crwdne63332:0',
	'forum-admin-edit-board-modal-heading' => 'crwdns63333:0crwdne63333:0',
	'forum-admin-edit-board-title' => 'crwdns63334:0crwdne63334:0',
	'forum-admin-edit-board-description' => 'crwdns63335:0crwdne63335:0',
	'forum-admin-delete-and-merge-board-modal-heading' => 'crwdns63336:0crwdne63336:0',
	'forum-admin-delete-board-title' => 'crwdns63337:0crwdne63337:0',
	'forum-admin-merge-board-warning' => 'crwdns63338:0crwdne63338:0',
	'forum-admin-merge-board-destination' => 'crwdns63339:0crwdne63339:0',
	'forum-admin-delete-and-merge-button-label' => 'crwdns63340:0crwdne63340:0',
	'forum-admin-link-label' => 'crwdns63341:0crwdne63341:0',
	'forum-autoboard-title-1' => 'crwdns63342:0crwdne63342:0',
	'forum-autoboard-body-1' => 'crwdns63343:0crwdne63343:0',
	'forum-autoboard-title-2' => 'crwdns63344:0crwdne63344:0',
	'forum-autoboard-body-2' => 'crwdns63345:0crwdne63345:0',
	'forum-autoboard-title-3' => 'crwdns63346:0crwdne63346:0',
	'forum-autoboard-body-3' => 'crwdns63347:0crwdne63347:0',
	'forum-autoboard-title-4' => 'crwdns63348:0crwdne63348:0',
	'forum-autoboard-body-4' => 'crwdns63349:0crwdne63349:0',
	'forum-autoboard-title-5' => 'crwdns63350:0crwdne63350:0',
	'forum-autoboard-body-5' => 'crwdns63351:0crwdne63351:0',
	'forum-board-destination-empty' => 'crwdns63352:0crwdne63352:0',
	'forum-board-title-validation-invalid' => 'crwdns63353:0crwdne63353:0',
	'forum-board-title-validation-length' => 'crwdns63354:0crwdne63354:0',
	'forum-board-title-validation-exists' => 'crwdns63355:0crwdne63355:0',
	'forum-board-validation-count' => 'crwdns63356:0crwdne63356:0',
	'forum-board-description-validation-length' => 'crwdns63357:0crwdne63357:0',
	'forum-board-id-validation-missing' => 'crwdns63358:0crwdne63358:0',
	'forum-board-no-board-warning' => 'crwdns71013:0crwdne71013:0',
	'forum-related-discussion-heading' => 'crwdns63360:0crwdne63360:0',
	'forum-related-discussion-new-post-button' => 'crwdns63361:0crwdne63361:0',
	'forum-related-discussion-new-post-tooltip' => 'crwdns63362:0crwdne63362:0',
	'forum-related-discussion-total-replies' => 'crwdns63363:0crwdne63363:0',
	'forum-related-discussion-see-more' => 'crwdns63364:0crwdne63364:0',
	'forum-confirmation-board-deleted' => 'crwdns63365:0crwdne63365:0',
	'forum-token-mismatch' => 'crwdns63366:0crwdne63366:0',
	'right-forumadmin' => 'crwdns63367:0crwdne63367:0',
	'right-forumoldedit' => 'crwdns63368:0crwdne63368:0',
	'right-boardedit' => 'crwdns63369:0crwdne63369:0',
);

$messages['lrc'] = array(
	'forum-specialpage-policies-edit' => 'ويرايشت',
	'forum-board-thread-follow' => 'نهاگردی',
	'forum-board-thread-following' => 'د حالت نهاگردی',
	'forum-thread-reply-post' => 'جؤاو ده ئن',
);

$messages['lv'] = array(
	'forum-forum-title' => 'Forums',
	'forum-specialpage-heading' => 'Forums',
	'forum-specialpage-policies' => 'Forums politika / FAQ',
	'forum-activity-module-heading' => 'Forums Aktivitātes',
	'forum-recentchanges-namespace-selector-message-wall' => 'Forums Valdes',
	'forum-specialpage-oldforum-link' => 'Vecie forums Arhīvs',
);

$messages['mk'] = array(
	'forum-forum-title' => 'Форум',
	'forum-token-mismatch' => 'Упс! Шифрата не се совпаѓа',
);

$messages['ms'] = array(
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
	'forum-related-discussion-heading' => 'Perbincangan tentang $1',
	'forum-related-discussion-new-post-button' => 'Mulakan sebuah Perbincangan',
	'forum-related-discussion-new-post-tooltip' => 'Memulakan perbincangan baru tentang $1',
	'forum-related-discussion-total-replies' => '$1 pesanan',
	'forum-related-discussion-see-more' => 'Lihat lebih banyak perbincangan',
	'forum-confirmation-board-deleted' => '"$1" telah dihapuskan.',
	'forum-token-mismatch' => 'Eh! Token tak sepadan',
);

$messages['nl'] = array(
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
	'forum-board-new-message-heading' => 'Nieuwe discussie starten',
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
	'forum-discussion-highlight' => 'Discussie uitlichten',
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
	'forum-related-discussion-heading' => 'Oveleg over $1',
	'forum-related-discussion-new-post-button' => 'Overleg starten',
	'forum-related-discussion-new-post-tooltip' => 'Begin een nieuwe overleg over $1',
	'forum-related-discussion-total-replies' => '{{PLURAL:$1|Eén bericht|$1 berichten}}',
	'forum-related-discussion-see-more' => 'Meer discussies bekijken',
	'forum-confirmation-board-deleted' => '"$1" is verwijderd.',
	'forum-token-mismatch' => 'Het token komt niet overeen',
);

$messages['oc'] = array(
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
);

$messages['pl'] = array(
	'forum-desc' => 'Rozszerzenie Wikii Specjalna:Forum',
	'forum-disabled-desc' => 'Rozszerzenie Wikii Specjalna:Forum; wyłączone',
	'forum-forum-title' => 'Forum',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Aktywny wątek|Aktywne wątki|Aktywnych wątków}}',
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|Aktywna dyskusja|Aktywnych dyskusji}} o: $2',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Wątek<br /> na tym forum|Wątki<br /> na tym forum|Wątków<br /> na tym forum}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Aktywny<br /> wątek|Aktywne<br /> wątki|Aktywnych<br /> wątków}}</span>',
	'forum-specialpage-heading' => 'Forum',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Edytuj<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|wątek|wątki|wątków}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|wiadomość|wiadomości}}',
	'forum-specialpage-board-lastpostby' => 'Ostatni wpis dodany przez',
	'forum-specialpage-policies-edit' => 'Edytuj',
	'forum-specialpage-policies' => 'Zasady forum / FAQ',
	'forum-policies-and-faq' => '==Zasady użytkowania forum==
Zanim zaczniesz publikować na Forach {{SITENAME}}, pamiętaj o kilku ogólnych wskazówkach dotyczących korzystania z nich:

„Bądź miły i traktuj ludzi z szacunkiem.”
: Ludzie z całego świata mogą czytać i edytować artykuły na tej wiki i forach z nią związanych. Jak w przypadku każdego projektu opartego na wzajemnej współpracy, nie zawsze wszyscy się ze sobą zgadzają. Biorąc udział w dyskusji warto być uprzejmym i otwartym na inne poglądy. W końcu jesteśmy tutaj, bo interesujemy się tym samym i to samo kochamy.

„Zawsze najpierw sprawdź, czy nie istnieje już dyskusja na dany temat, ale nigdy nie bój się zakładać nowych wątków.”
:Poświęć chwilę na przejrzenie forum {{SITENAME}} i sprawdź, czy ktoś już nie pisał na temat, który chcesz poruszyć. Jeżeli nic takiego nie możesz znaleźć, śmiało rozpocznij nowy wątek!

„Proś o pomoc.”
:Zaważyłeś, że coś jest nie tak? Masz jakieś pytanie? Śmiało pytaj na forum! Jeżeli potrzebujesz pomocy pracowników portalu FANDOM, skontaktuj się z nami przez [[w:c:community|Centrum Społeczności]] lub [[Special:Contact]].

„Baw się dobrze!”
:Społeczność {{SITENAME}} gości Cię z przyjemnością. Z radością zobaczymy Twój wkład w dyskusje prowadzone na tej wiki.

==FAQ==
„W jaki sposób mogę być na bieżąco z dyskusjami, które mnie interesują?”
: Posiadając konto użytkownika portalu FANDOM, możesz obserwować konkretne rozmowy i otrzymywać wiadomości z powiadomieniami (na stronie lub przez e-mail) dotyczącymi aktywności w dyskusji. [[Special:UserSignup|Załóż konto w FANDOM]], jeżeli jeszcze tego nie zrobiłeś.

„Jak mogę walczyć z wandalizmem?”
: Jeżeli zauważysz w jakimś wątku spam lub wandalizm, najedź kursorem na problematyczny tekst. Powinien pojawić się przycisk „Więcej” – kliknij na niego i z menu rozwijanego wybierz „Usuń”. W ten sposób usuniesz dany tekst oraz będziesz miał możliwość poinformować o nim administratora.

„Czym jest OKejka (Kudos)?”
: Jeżeli uznasz jakąś dyskusję lub odpowiedź za interesującą, wyjątkowo trafną lub zabawną, możesz wyrazić swoje uznanie dla autora przyznając OKejkę (w wersji angielskiej Kudos). OKejki bardzo przydają się również przy głosowaniach.

„Czym są Tematy?”
: Tematy pozwalają na powiązanie dyskusji z forum z artykułem na wiki. Ułatwia to zachowanie porządku na Forach i pomaga użytkownikom znaleźć ciekawe dyskusje. Na przykład: wątek na forum o tagu „Lord Voldemort” pojawi się pod artykułem „Lord Voldemort” na wiki.',
	'forum-board-title' => 'Subforum $1',
	'forum-board-topic-title' => 'Dyskusje o $1',
	'forum-board-topics' => 'Tematy',
	'forum-board-thread-follow' => 'Obserwuj',
	'forum-board-thread-following' => 'Obserwowany',
	'forum-board-thread-kudos' => '$1 {{PLURAL:$1|OKejka|OKejki|OKejek}}',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|Wiadomość|Wiadomości}}',
	'forum-board-new-message-heading' => 'Rozpocznij dyskusję',
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
___________________________________________<br>
* Znajdź pomoc w Centrum Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'na $1',
	'forum-wiki-activity-msg-name' => 'subforum $1',
	'forum-activity-module-heading' => 'Aktywność na Forum',
	'forum-related-module-heading' => 'Powiązane wątki',
	'forum-activity-module-posted' => '$1 napisał(a) odpowiedź $2',
	'forum-activity-module-started' => '$1 rozpoczął dyskusję $2',
	'forum-contributions-line' => '[[$1|$2]] na [[$3|subforum $4]]',
	'forum-recentchanges-new-message' => 'na [[$1|subforum $2]]',
	'forum-recentchanges-edit' => 'edytowano wiadomość',
	'forum-recentchanges-removed-thread' => '{{GENDER:$5|usunął|usunęła}} wątek "[[$1|$2]]" z [[$3|subforum $4]]',
	'forum-recentchanges-removed-reply' => '{{GENDER:$5|usunął|usunęła}} odpowiedź z "[[$1|$2]]" na [[$3|subforum $4]]',
	'forum-recentchanges-restored-thread' => '{{GENDER:$5|przywrócił|przywróciła}} wątek "[[$1|$2]]" na [[$3|subforum $4]]',
	'forum-recentchanges-restored-reply' => '{{GENDER:$5|przywrócił|przywróciła}} odpowiedź w "[[$1|$2]]" na [[$3|subforum $4]]',
	'forum-recentchanges-deleted-thread' => '{{GENDER:$5|skasował|skasowała}} wątek "[[$1|$2]]" z [[$3|subforum $4]]',
	'forum-recentchanges-deleted-reply' => '{{GENDER:$5|skasował|skasowała}} odpowiedź z "[[$1|$2]]" z [[$3|subforum $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Wiadomość',
	'forum-recentchanges-namespace-selector-message-wall' => 'Subforum',
	'forum-recentchanges-thread-group' => '$1 na [[$2|subforum $3]]',
	'forum-recentchanges-history-link' => 'historia subforum',
	'forum-recentchanges-thread-history-link' => 'historia wątku',
	'forum-recentchanges-closed-thread' => '{{GENDER:$5|zamknął|zamknęła}} wątek "[[$1|$2]]" w [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => '{{GENDER:$5|reaktywował|reaktywowała}} wątek "[[$1|$2]]" w [[$3|$4]]',
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
	'forum-autoboard-title-2' => 'Nowości i ogłoszenia',
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
	'forum-board-no-board-warning' => 'Nie odnaleziono subforum o tym tytule. Spróbuj ponownie albo przejrzyj listę dostępnych subforów.',
	'forum-related-discussion-heading' => 'Dyskusje o artykule $1',
	'forum-related-discussion-new-post-button' => 'Rozpocznij dyskusję',
	'forum-related-discussion-new-post-tooltip' => 'Rozpocznij nową dyskusję o $1',
	'forum-related-discussion-total-replies' => '$1 wiadomości',
	'forum-related-discussion-see-more' => 'Zobacz więcej dyskusji',
	'forum-confirmation-board-deleted' => '"$1" został usunięty.',
	'forum-token-mismatch' => 'Ups! Token nie pasuje',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => 'Has admin access to the forums',
	'right-forumoldedit' => 'Can edit the old, archived forums',
	'right-boardedit' => 'Edit Forum board information',
);

$messages['ps'] = array(
	'forum-specialpage-policies-edit' => 'سمول',
	'forum-specialpage-policies' => 'د فورم تگلارې/ډ ځ پ',
	'forum-thread-reply-post' => 'ځوابول',
	'forum-mail-notification-html-greeting' => 'سلامونه $1،',
);

$messages['pt'] = array(
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
	'forum-policies-and-faq' => "==Políticas do fórum==
Antes de contribuir para os fóruns de {{SITENAME}}, por favor, tenha em mente algumas práticas de conduta recomendadas:

'''Seja educado e trate as pessoas com respeito.'''
: Pessoas do mundo todo leem e editam esta wiki e seus fóruns. Como qualquer outro projeto colaborativo, nem todos concordam o tempo todo. Mantenha as discussões civilizadas e seja receptivo à opiniões divergentes. Todos nós estamos aqui porque amamos o mesmo tema.

'''Tente primeiro encontrar discussões existentes, mas não tenha medo de iniciar um novo tópico.'''
: Por favor dê uma olhada nos fóruns de {{SITENAME}} para ver se uma discussão já existe sobre o tópico que você busca. Se você não encontrar o que procura, inicie uma nova discussão!

'''Peça ajuda.'''
Você vê algo que não está certo? Ou você tem uma pergunta? Peça ajuda aqui no fórum! Se precisar de ajuda do staff do FANDOM, por favor entre em contato na [[w:c:comunidade |Central da comunidade]] ou através de [[Especial:Contact]].

'''Divirta-se!'''
 A comunidade {{SITENAME}} está feliz em ter você aqui. Estamos ansiosos para vê-lo novamente para discutirmos este tópico que todos nós amamos.

==Perguntas frequentes do Fórum==
'''Como eu permaneço atualizado sobre as discussões que me interessam?'''
: Com uma conta de usuário do FANDOM, você pode seguir conversas específicas e receber mensagens de notificação (no site ou via e-mail) quando uma discussão tem mais atividade. Certifique-se de [[Especial:Criar uma conta|registrar-se para uma conta no FANDOM]] se você ainda não tem uma.

'''Como faço para remover vandalismo?'''
: Se você notar algum spam ou vandalismo em uma discussão, passe o mouse sobre o texto ofensivo. Você verá um botão \"Mais\". Dentro do menu \"Mais\", você encontrará \"Remover\". Isso permite que você remova o vandalismo e, opcionalmente, informe a um administrador.

'''O que são Kudos?'''
: Se você encontrar uma discussão ou uma resposta interessante, bem bolada ou divertida você pode dar os parabéns através de Kudos. Eles também podem ser úteis em situações de voto.

'''O que são tópicos?'''
: Os tópicos permitem que você vincule uma discussão do fórum com um artigo da wiki. É outra maneira de manter os fóruns organizados e ajudar as pessoas a encontrar discussões interessantes. Por exemplo, uma discussão de fórum contendo ''Lord Voldemort'' será exibida na parte inferior do artigo ''Lord Voldemort.''.",
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
	'forum-activity-module-started' => '$1 iniciou uma discussão $2',
	'forum-contributions-line' => '[[$1|$2]] no [[$3|painel $4]]',
	'forum-recentchanges-new-message' => 'no [[$1|Painel $2]]',
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
	'forum-recentchanges-history-link' => 'histórico do painel',
	'forum-recentchanges-thread-history-link' => 'histórico do tópico',
	'forum-recentchanges-closed-thread' => 'conversa encerrada "[[$1|$2]]" de [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'conversa reaberta"[[$1|$2]]" de [[$3|$4]]',
	'forum-board-history-title' => 'histórico do painel',
	'forum-specialpage-oldforum-link' => 'Arquivos antigos do Fórum',
	'forum-admin-page-breadcrumb' => 'Quadro do Admin de Gerência',
	'forum-admin-create-new-board-label' => 'Criar novo quadro',
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
	'forum-autoboard-body-1' => 'Esse quadro é para conversas gerais sobre a wiki.',
	'forum-autoboard-title-2' => 'Notícias e Anunciamentos',
	'forum-autoboard-body-2' => 'Notícias urgentes e informação!',
	'forum-autoboard-title-3' => 'Novos no $1',
	'forum-autoboard-body-3' => 'Quer compartilhar algo que acabou de ser postado nessa wiki, ou parabenizar alguém por um ótima contribuição? Está no lugar certo!',
	'forum-autoboard-title-4' => 'Perguntas e Respostas',
	'forum-autoboard-body-4' => 'Tem uma pergunta sobre a wiki ou o tópico? Pergunte aqui!',
	'forum-autoboard-title-5' => 'Diversão e Jogos',
	'forum-autoboard-body-5' => 'Esse quadro é para conversas fora do tópico -- um lugar para se divertir com os seus $1 amigos.',
	'forum-board-destination-empty' => '(Por favor selecione um quadro)',
	'forum-board-title-validation-invalid' => 'O nome do painel contém caracteres inválidos',
	'forum-board-title-validation-length' => 'O nome do painel deve ter pelo menos 4 caracteres',
	'forum-board-title-validation-exists' => 'Um painel com esse nome já existe',
	'forum-board-validation-count' => 'O número máximo de painéis é $1.',
	'forum-board-description-validation-length' => 'Escreva uma descrição para este painel',
	'forum-board-id-validation-missing' => 'O id do painel está indisponível.',
	'forum-board-no-board-warning' => 'Não há nenhum fórum com esse título. Por favor, tente novamente ou confira esta lista de fóruns.',
	'forum-related-discussion-heading' => 'Discussões sobre $1',
	'forum-related-discussion-new-post-button' => 'Iniciar uma Discussão',
	'forum-related-discussion-new-post-tooltip' => 'Iniciar uma nova discussão sobre $1',
	'forum-related-discussion-total-replies' => '$1 mensagens',
	'forum-related-discussion-see-more' => 'Veja mais discussões',
	'forum-confirmation-board-deleted' => '"$1" foi excluído.',
	'forum-desc' => 'Extensão Especial:Forum da Wikia',
	'forum-disabled-desc' => 'Extensão Especial:Forum da Wikia; desativado',
	'forum-specialpage-blurb' => '',
	'forum-token-mismatch' => 'Opa! Token não corresponde',
	'right-forumadmin' => 'Tem acesso de administrador para os fóruns',
	'right-forumoldedit' => 'Pode editar os fóruns antigos, arquivados',
	'right-boardedit' => 'Editar informações no Fórum',
);

$messages['ru'] = array(
	'forum-desc' => 'Расширение Special:Forum',
	'forum-disabled-desc' => 'Расширение Special:Forum отключено',
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|активное обсуждение|активных обсуждения|активных обсуждений}}',
	'forum-active-threads-on-topic' => '{{FORMATNUM:$1}} {{PLURAL:$1|активное обсуждение|активных обсуждения|активных обсуждений}} о $2',
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Тема<br> на форуме|Темы<br> на форуме|Тем<br> на форуме}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Активное<br> обсуждение|Активных<br> обсуждения|Активных<br> обсуждений}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Вы можете править это<span>',
	'forum-specialpage-board-threads' => '$1 {{PLURAL:$1|тема|темы|тем}}',
	'forum-specialpage-board-posts' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
	'forum-specialpage-board-lastpostby' => 'Последнее сообщение от',
	'forum-specialpage-policies-edit' => 'Править',
	'forum-specialpage-policies' => 'Правила Форума / Справка',
	'forum-policies-and-faq' => '==Правила форума==
Перед тем, как начать участие на форуме {{SITENAME}}, ознакомьтесь с правилами:

""Будьте вежливы и относитесь к другим участникам с уважением.""
: Эту вики и форум посещают и редактируют люди из разных стран. Как и в любом другом совместном проекте, здесь возможны разногласия. Придерживайтесь вежливой манеры общения и будьте готовы выслушать чужие мнения. Помните, что мы все здесь потому, что нам интересна одна и та же тема.

\'\'\'Постарайтесь сначала найти нужную вам тему среди уже существующих, но если её нет, то смело создавайте новую.\'\'\' 
: Уделите несколько минут, чтобы просмотреть список тем на форуме {{SITENAME}} и проверить, нет ли там нужной вам темы. Если вы не можете найти то, что подходит вам, смело начинайте новую тему!

""Обращайтесь за помощью.""
: Заметили ошибку? У вас возник вопрос? Спросите прямо на форуме. Если вам нужна помощь сотрудников Фэндома, зайдите на [[w:c:ru.community|Вики Сообщества]] или напишите нам через [[Служебная:Contact]].

""Получайте удовольствие!""
: Мы рады, что вы стали частью сообщества {{SITENAME}}, и надеемся, что вы примете активное участие в обсуждениях нашей любимой темы. 

==FAQ форума==
""Как следить за интересными мне темами?""
: Если у вас есть учётная запись на Фэндоме, то вы можете отслеживать темы и получать уведомления (на вики или по электронной почте) о новых ответах. Если у вас ещё нет аккаунта, [[Служебная:UserSignup|создайте его прямо сейчас]].

""Как бороться с вандализмом?""
: Если среди ответов в теме вы заметили спам или вандализм, наведите курсор на проблемный текст и нажмите на появившуюся кнопку «Больше». В открывшемся меню выберите «Удалить». Так вы удалите проблемный ответ и, по желанию, уведомите администратора вики.

""Что такое «Мне нравится»?""
: Если какая-то тема или ответ показался вам интересным, хорошо продуманным или забавным, вы можете оценить его, поставив отметку «Мне нравится». Эти отметки также могут пригодиться для голосований.

""Что такое общие темы?""
: Общие темы позволяют связывать темы форума со статьями, к которым они относятся. Они помогают организовать форум и найти участникам нужные им темы. Например, внизу статьи «Лорд Волан-де-Морт» появится обсуждение с общей темой «Лорд Волан-де-Морт».',
	'forum-board-title' => 'Главная тема: $1',
	'forum-board-topic-title' => 'Обсуждение $1',
	'forum-board-topics' => 'Темы',
	'forum-board-thread-follow' => 'Следить',
	'forum-board-thread-following' => 'Отслеживание',
	'forum-board-thread-kudos' => '$1 "Мне нравится"',
	'forum-board-thread-replies' => '$1 {{PLURAL:$1|ответ|ответа|ответов}}',
	'forum-board-new-message-heading' => 'Создать тему',
	'forum-no-board-selection-error' => '← Пожалуйста, выберите главную тему',
	'forum-thread-reply-placeholder' => 'Оставить ответ',
	'forum-thread-reply-post' => 'Ответить',
	'forum-thread-deleted-return-to' => 'Вернуться к гл. теме $1',
	'forum-sorting-option-newest-replies' => 'С новыми ответами',
	'forum-sorting-option-popular-threads' => 'Самые популярные',
	'forum-sorting-option-most-replies' => 'Самые активные за 7 дней',
	'forum-sorting-option-newest-threads' => 'Новые темы',
	'forum-sorting-option-oldest-threads' => 'Старые темы',
	'forum-discussion-post' => 'Опубликовать',
	'forum-discussion-highlight' => 'Сообщить всем об этой теме',
	'forum-discussion-placeholder-title' => 'Что вы хотите обсудить?',
	'forum-discussion-placeholder-message' => 'Оставить сообщение в главной теме: $1',
	'forum-discussion-placeholder-message-short' => 'Оставить новое сообщение',
	'forum-notification-user1-reply-to-your' => '$1 {{GENDER:$1|ответил|ответила}} в вашей теме в $3',
	'forum-notification-user2-reply-to-your' => '$1 и $2 ответили в вашей теме в $3',
	'forum-notification-user3-reply-to-your' => '$1 и другие ответили в вашей теме в $3',
	'forum-notification-user1-reply-to-someone' => '$1 {{GENDER:$1|ответил|ответила}} в главной теме $3',
	'forum-notification-user2-reply-to-someone' => '$1 и $2 ответили на главной теме $3',
	'forum-notification-user3-reply-to-someone' => '$1 и другие ответили в главной теме $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 {{GENDER:$1|оставил|оставила}} новое сообщение на главной теме $2',
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
	'forum-mail-notification-body-HTML' => 'Привет, $WATCHER
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Посмотреть обсуждение</a></p>
			<p>Команда Викия</p>
___________________________________________<br>
* Найти помощь и поддержку можно на Центральной Вики Сообщества: http://community.wikia.com
* Хотите получать меньше уведомлений? Вы можете настроить рассылку на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'на $1',
	'forum-wiki-activity-msg-name' => 'гл. тема $1',
	'forum-activity-module-heading' => 'Активность на форуме',
	'forum-related-module-heading' => 'Близкие темы',
	'forum-activity-module-posted' => '$1 оставил ответ $2',
	'forum-activity-module-started' => '$1 создал тему $2',
	'forum-contributions-line' => '[[$1|$2]] в [[$3|Главной теме $4]]',
	'forum-recentchanges-new-message' => 'в главной теме [[$1|$2]]',
	'forum-recentchanges-edit' => 'сообщение исправлено',
	'forum-recentchanges-removed-thread' => 'удалил тему "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-recentchanges-removed-reply' => 'удалил ответ в теме "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-recentchanges-restored-thread' => 'восстановил тему "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-recentchanges-restored-reply' => 'восстановил ответ в теме "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-recentchanges-deleted-thread' => 'удалил тему "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-recentchanges-deleted-reply' => 'удалил ответ в теме "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-recentchanges-deleted-reply-title' => 'Опубликовать',
	'forum-recentchanges-namespace-selector-message-wall' => 'Гл. тема Форума',
	'forum-recentchanges-thread-group' => '$1 в главной теме [[$2|$3]]',
	'forum-recentchanges-history-link' => 'история гл. темы',
	'forum-recentchanges-thread-history-link' => 'история темы',
	'forum-recentchanges-closed-thread' => 'закрыл тему "[[$1|$2]]" в [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'вновь открыл "[[$1|$2]]" в гл. теме [[$3|$4]]',
	'forum-board-history-title' => 'история гл. темы',
	'forum-specialpage-oldforum-link' => 'Архив старого Форума',
	'forum-admin-page-breadcrumb' => 'Управление главными темами',
	'forum-admin-create-new-board-label' => 'Создать новую гл. тему',
	'forum-admin-create-new-board-modal-heading' => 'Создание гл. темы',
	'forum-admin-create-new-board-title' => 'Название главной темы',
	'forum-admin-create-new-board-description' => 'Описание главной темы',
	'forum-admin-edit-board-modal-heading' => 'Править гл. тему: $1',
	'forum-admin-edit-board-title' => 'Название главной темы',
	'forum-admin-edit-board-description' => 'Описание главной темы',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Удалить гл. тему: $1',
	'forum-admin-delete-board-title' => 'Подтвердите ваши действия, написав название гл. темы, которую желаете удалить:',
	'forum-admin-merge-board-warning' => 'Темы из этой главной темы будут добавлены в другую главную тему.',
	'forum-admin-merge-board-destination' => 'Выберете тему для объединения:',
	'forum-admin-delete-and-merge-button-label' => 'Удалить и объединить',
	'forum-admin-link-label' => 'Править гл. темы',
	'forum-autoboard-title-1' => 'Общая тема',
	'forum-autoboard-body-1' => 'Эта тема предназначена для обсуждений разных тем о вики.',
	'forum-autoboard-title-2' => 'Новости и объявления',
	'forum-autoboard-body-2' => 'Новости и информация для участников вики!',
	'forum-autoboard-title-3' => 'Новое для $1',
	'forum-autoboard-body-3' => 'Хотите поделиться чем-нибудь, что можно опубликовать на вики, или просто поздравить участников за отличную статью?',
	'forum-autoboard-title-4' => 'Вопросы и ответы',
	'forum-autoboard-body-4' => 'Есть вопросы о вики или статьях? Задай их здесь!',
	'forum-autoboard-title-5' => 'Общение',
	'forum-autoboard-body-5' => 'Эта тема предназначена для любых разговоров - отличное место, чтобы просто поболтать с друзьями из $1.',
	'forum-board-destination-empty' => '(Выберите гл. тему)',
	'forum-board-title-validation-invalid' => 'Название главной темы содержит некорректные символы',
	'forum-board-title-validation-length' => 'Название главной темы не может быть короче 4 символов',
	'forum-board-title-validation-exists' => 'Главная тема с таким названием уже существует',
	'forum-board-validation-count' => 'Количество гл. тем не может быть больше $1',
	'forum-board-description-validation-length' => 'Пожалуйста, дайте описание этой главной теме',
	'forum-board-id-validation-missing' => 'Отсутствует идентификатор раздела',
	'forum-board-no-board-warning' => 'Главной темы с таким названием нет. Повторите попытку или просмотрите список тем форума.',
	'forum-related-discussion-heading' => 'Обсуждение статьи «$1»',
	'forum-related-discussion-new-post-button' => 'Начать обсуждение',
	'forum-related-discussion-new-post-tooltip' => 'Начать обсуждение статьи «$1»',
	'forum-related-discussion-total-replies' => '$1 сообщений',
	'forum-related-discussion-see-more' => 'Другие обсуждения',
	'forum-confirmation-board-deleted' => '"$1" была удалена.',
	'forum-token-mismatch' => 'Символ не соответствует',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => 'Имеет доступ статуса администратора на форуме',
	'right-forumoldedit' => 'Может редактировать архивы старого форума',
	'right-boardedit' => 'Редактирование главных тем форума',
);

$messages['sr-ec'] = array(
	'forum-thread-reply-post' => 'Одговори',
	'forum-sorting-option-popular-threads' => 'Најпопуларније',
	'forum-sorting-option-most-replies' => 'Најактивније у протеклих 7 дана.',
	'forum-discussion-post' => 'Постави',
	'forum-discussion-placeholder-message-short' => 'Пошаљите нову поруку',
	'forum-token-mismatch' => 'Упс! Жетон се не поклапа.',
);

$messages['sv'] = array(
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
	'forum-related-discussion-heading' => 'Diskussioner om $1',
	'forum-related-discussion-new-post-button' => 'Starta en diskussion',
	'forum-related-discussion-new-post-tooltip' => 'Starta en ny diskussion om $1',
	'forum-related-discussion-total-replies' => '$1 meddelanden',
	'forum-related-discussion-see-more' => 'Se fler diskussioner',
	'forum-confirmation-board-deleted' => '"$1" har raderats.',
	'forum-token-mismatch' => 'Hoppsan! Koden stämmer inte överens',
);

$messages['ta'] = array(
	'forum-forum-title' => 'கருத்துக்களம்',
);

$messages['te'] = array(
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
	'forum-related-discussion-heading' => '$1 గురించిన చర్చలు',
	'forum-related-discussion-new-post-button' => 'ఓ చర్చను మొదలుపెట్టండి',
	'forum-related-discussion-new-post-tooltip' => '$1 గురించి ఓ కొత్త చర్చను మొదలు పెట్టండి',
	'forum-related-discussion-total-replies' => '$1 సందేశాలు',
	'forum-related-discussion-see-more' => 'మరిన్ని చర్చలను చూడండి',
	'forum-confirmation-board-deleted' => '"$1" తొలగించబడింది.',
);

$messages['tr'] = array(
	'forum-specialpage-policies-edit' => 'Düzenle',
	'forum-specialpage-policies' => 'Forum İlkeleri / SSS',
);

$messages['tyv'] = array(
	'forum-forum-title' => 'Шуулган',
	'forum-specialpage-heading' => 'Шуулган',
);

$messages['uk'] = array(
	'forum-desc' => 'Вікіа Спеціальна: Розширення форуму',
	'forum-disabled-desc' => 'Вікіа Спеціальна: Розширення форуму; інвалідів',
	'forum-forum-title' => 'Форум',
	'forum-active-threads' => '{{FORMATNUM:$1}} {{PLURAL:$1|Активна дискусія|Активних дискусій}}',
	'forum-active-threads-on-topic' => "{{FORMATNUM:$1}} {{PLURAL:$1|Активна дискусія|активних дискусії|Активних дискусій}}, пов'язаних з $2",
	'forum-header-total-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Тема<br> на Форумі|Теми<br> на Форумі|Тем<br> на Форумі}}</span>',
	'forum-header-active-threads' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Активна<br> дискусія|Активних<br> дискусії|Активних<br> дискусій}}</span>',
	'forum-specialpage-heading' => 'Форум',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading Ви можете редагувати це<span>',
	'forum-specialpage-board-threads' => '{{formatnum:$1}} {{PLURAL:$1|обговорення|обговорень}}',
	'forum-specialpage-board-posts' => '{{formatnum:$1}} {{PLURAL:$1|повідомлення|повідомлень}}',
	'forum-specialpage-board-lastpostby' => 'Останнє повідомлення від',
	'forum-specialpage-policies-edit' => 'Редагувати',
	'forum-specialpage-policies' => 'Правила Форума/Довідка',
	'forum-policies-and-faq' => "==Правила і Рекомендації==
Перед тим, як розпочати свою діяльність на Форумі {{SITENAME}}, будь ласка, зверніть увагу на наші правила і рекомендації:

'''Будьте чемними та поважайте інших користувачів.'''
: Люди зі всього світу переглядають та редагують цю вікі і форум. Як і на будь-якому іншому спільному проекті, тут можуть виникати розбіжності у поглядах. Притримуйтесь конструктивної дискусії і будьте готові вислухати чужі думки. Пам'ятайте: ми тут, тому що ми маємо спільні інтереси.

'''Приєднуйтесь до вже існуючих дискусій, та не бійтесь розпочати свою.'''
:Будь ласка, знайдіть час, щоб переглянути існуючі дискусії на Форумі {{SITENAME}}, щоб знайти обговорення, що підходять саме Вам. Якщо ж Ви не можете знайти їх - зайдіть на головну сторінку Форума, виберіть одну з головних тем - і створіть свою дискусію!

'''Попросіть допомоги.'''
:Помітили помилку? Чи маєте певні запитання? Попросіть допомоги тут, на Форумі! Якщо вам потрібна допомога від Співробітників Вікія, зверніться до них на [[w:c:community|Центральній Вікі Спільноти]] або через [[Special:Contact|контактну форму]].

'''Отримуйте задовлення!'''
:Спільнота {{SITENAME}} рада бачити Вас тут. Ми завжди готові подискутувати з вами на теми, які ми всі любимо.

==Довідка==
'''Як я можу відслідковувати дискусії, що зацікавили мене?'''
: Якщо Ви маєте обліковий запис Вікія, ви можете відслідковувати обговорення, що зацікавили Вас за допомогою повідомлень, що з'являються в мережі Вікія, або надсилаються на E-mail. Якщо в Вас немає облікового запису Вікія -  [[Special:UserSignup|створіть його]].

'''Як я можу боротися з вандалізмом?'''
: Якщо Ви помітили вандалізм або спам у одному з повідомлень, наведіть на нього курсор миші. Потим, натисніть на кнопку \"Більше\", що з'явиться, і виберіть пункт \"Видалити\". Так Ви зможете видалити вандальне повідомлення і сповістити адміністратора вікі про це.

'''Що таке \"Подобається\"?'''
: Якщо Ви знайшли дискусію чи повідомлення, що дійсно зацікавило Вас, Ви можете наочно продемонструвати свою прихильність, відмітивши це повідомлення, як таке, що Вам \"Подобається\". Ці відмітки також можуть бути корисними, якщо на Форумі проводиться голосування.

'''Що таке \"Спільні теми?'''
: \"Спільні теми\" - це функція, що дозволяє Вам відсортувати дискусії по сторінкам, до яких вони відносяться. Це ще один чудовий спосіб зробити теми Форума більш легкодоступними для пошуку. На приклад, дискусії зі спільною темою \"Світ\", будуть відображені в кінці сторінки з назвою \"Світ\".",
	'forum-board-title' => 'Головна тема: $1',
	'forum-board-topic-title' => 'Обговорення $1',
	'forum-board-topics' => 'Теми',
	'forum-board-thread-follow' => 'Слідкувати',
	'forum-board-thread-following' => 'Спостереження',
	'forum-board-thread-kudos' => '$1 "Подобається"',
	'forum-board-thread-replies' => '$1 повідомлень',
	'forum-board-new-message-heading' => 'Розпочати дискусію',
	'forum-no-board-selection-error' => '← Будь ласка, оберіть головну тему',
	'forum-thread-reply-placeholder' => 'Залишити повідомлення',
	'forum-thread-reply-post' => 'Відповісти',
	'forum-thread-deleted-return-to' => 'Повернутися до головної теми $1',
	'forum-sorting-option-newest-replies' => 'Найновіші',
	'forum-sorting-option-popular-threads' => 'Найпопулярніші',
	'forum-sorting-option-most-replies' => 'Найбільш активні за 7 днів',
	'forum-sorting-option-newest-threads' => 'Найновіші потоки',
	'forum-sorting-option-oldest-threads' => 'Найстаріші потоки',
	'forum-discussion-post' => 'Публікація',
	'forum-discussion-highlight' => 'Оповістити всіх про цю дискусію',
	'forum-discussion-placeholder-title' => 'Про що ви хочете повідомити?',
	'forum-discussion-placeholder-message' => 'Залишити нове повідомлення в головній темі $1',
	'forum-discussion-placeholder-message-short' => 'Залишити нове повідомлення',
	'forum-notification-user1-reply-to-your' => '$1 залишив повідомлення в Вашій темі  $3',
	'forum-notification-user2-reply-to-your' => '$1 і $2 відповіли в Вашій темі $3',
	'forum-notification-user3-reply-to-your' => '$1 та інші відповіли в Вашій темі в $3',
	'forum-notification-user1-reply-to-someone' => '$1 відповів в головній темі $3',
	'forum-notification-user2-reply-to-someone' => '$1 і $2 відповіли в головній темі $3',
	'forum-notification-user3-reply-to-someone' => '$1 та інші залишили повідомлення в головній темі $3',
	'forum-notification-newmsg-on-followed-wall' => '$1 залишив нове повідомлення в головній темі $2',
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
	'forum-mail-notification-body-HTML' => 'Hi $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Переглянути обговорення</a></p>
			<p>Команда Вікія</p>
___________________________________________<br>
* Ви можете знайти підтримку і допомогу на Центральній Вікі Спільноти: http://community.wikia.com
* Хочете отримувати менше таких повідомлень? Ви можете налаштувати розсилку службових повідомлень на сторінці персональних налаштувань: http://community.wikia.com/Special:Preferences',
	'forum-wiki-activity-msg' => 'на $1',
	'forum-wiki-activity-msg-name' => 'головна тема $1',
	'forum-activity-module-heading' => 'Активність на Форумі',
	'forum-related-module-heading' => 'Близькі за темою',
	'forum-activity-module-posted' => '$1 залишив відповідь $2',
	'forum-activity-module-started' => '$1 розпочав дискусію $2',
	'forum-contributions-line' => '$5 ($6 | $7) $8 <a href="$1">$2</a> на темі Форума <a href="$3">$4</a>',
	'forum-recentchanges-new-message' => 'в головній темі [[$1|$2]]',
	'forum-recentchanges-edit' => 'повідомлення відредаговано',
	'forum-recentchanges-removed-thread' => 'видалив обговорення "[[$1|$2]]" з головної теми [[$3|$4]]',
	'forum-recentchanges-removed-reply' => 'видалив повідомлення з теми "[[$1|$2]]" в головній темі [[$3|$4]]',
	'forum-recentchanges-restored-thread' => 'відновив обговорення "[[$1|$2]]" в головній темі [[$3|$4]]',
	'forum-recentchanges-restored-reply' => 'відновив повідомлення "[[$1|$2]]" в головній темі [[$3|$4]]',
	'forum-recentchanges-deleted-thread' => 'видалив обговорення "[[$1|$2]]" з головної теми [[$3|$4]]',
	'forum-recentchanges-deleted-reply' => 'видалив повідомлення "[[$1|$2]]" в головній темі [[$3|$4]]',
	'forum-recentchanges-deleted-reply-title' => 'Публікація',
	'forum-recentchanges-namespace-selector-message-wall' => 'Головна тема Форума',
	'forum-recentchanges-thread-group' => '$1 в головній темі [[$2|$3]]',
	'forum-recentchanges-history-link' => 'історія головної теми',
	'forum-recentchanges-thread-history-link' => 'історія обговорення',
	'forum-recentchanges-closed-thread' => 'завершив обговорення "[[$1|$2]]" в [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'повторно розпочав обговорення "[[$1|$2]]" в головній темі [[$3|$4]]',
	'forum-board-history-title' => 'Історія головної теми',
	'forum-specialpage-oldforum-link' => 'Архів старого Форума',
	'forum-admin-page-breadcrumb' => 'Налаштування головних тем',
	'forum-admin-create-new-board-label' => 'Створити нову головну тему',
	'forum-admin-create-new-board-modal-heading' => 'Створення нової головної теми',
	'forum-admin-create-new-board-title' => 'Назва головної теми',
	'forum-admin-create-new-board-description' => 'Опис головної теми',
	'forum-admin-edit-board-modal-heading' => 'Редагувати тему $1',
	'forum-admin-edit-board-title' => 'Назва головної теми',
	'forum-admin-edit-board-description' => 'Опис головної теми',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Видалити тему $1',
	'forum-admin-delete-board-title' => 'Підтвердіть свої дії, вказавши назву головної теми, що буде видалена:',
	'forum-admin-merge-board-warning' => 'Дискусії з цієї головної теми будуть збережені в іншій головній темі.',
	'forum-admin-merge-board-destination' => "Оберіть тему для об'єднанная:",
	'forum-admin-delete-and-merge-button-label' => "Видалити і об'єднати",
	'forum-admin-link-label' => 'Редагувати головні теми',
	'forum-autoboard-title-1' => 'Загальна тема',
	'forum-autoboard-body-1' => 'Ця тема призначена для різноманітних дискусій щодо вікі.',
	'forum-autoboard-title-2' => 'Новини та оголошення',
	'forum-autoboard-body-2' => 'Свіжі новини та різноманітна інформація для користувачів!',
	'forum-autoboard-title-3' => 'Нове на $WIKINAME',
	'forum-autoboard-body-3' => 'Хочете поділитися цікавою інфорамацією чи привітати користувача, який створив відмінну статтю? Вам сюди!',
	'forum-autoboard-title-4' => 'Запитання та відповіді',
	'forum-autoboard-body-4' => 'Є запитання про вікі чи про вміст сторінок? Задайте свої запитання тут!',
	'forum-autoboard-title-5' => 'Спілкування та веселощі',
	'forum-autoboard-body-5' => 'Ця тема створена для будь-яких розмов - чудове місце для спілкування зі своїми друзями з $WIKINAME!',
	'forum-board-destination-empty' => '(Оберіть головну тему)',
	'forum-board-title-validation-invalid' => 'Назва головної теми включає в себе символи, що не підтримуються',
	'forum-board-title-validation-length' => 'Довжина назви головної теми має бути більша чотирьох символів',
	'forum-board-title-validation-exists' => 'Головна тема за такою назвою вже існує',
	'forum-board-validation-count' => 'Кількість головних тем не може бути більше $1',
	'forum-board-description-validation-length' => 'Будь ласка, вкажіть опис даної теми',
	'forum-board-id-validation-missing' => 'Неможливо знайти id головної теми',
	'forum-board-no-board-warning' => 'Головної теми з такою назвою не існує. Ось список існуючих головних тем:',
	'forum-related-discussion-heading' => 'Обговорення $1',
	'forum-related-discussion-new-post-button' => 'Розпочати дискусію',
	'forum-related-discussion-new-post-tooltip' => 'Розпочати нве обговорення щодо $1',
	'forum-related-discussion-total-replies' => '$1 повідомлень',
	'forum-related-discussion-see-more' => 'Інші дискусії',
	'forum-confirmation-board-deleted' => '"$1" була видалена.',
	'forum-token-mismatch' => 'Йой! Знак не збігається',
);

$messages['vi'] = array(
	'forum-desc' => 'Trang đặc biệt của Wikia: mở rộng Diễn đàn',
	'forum-disabled-desc' => 'Trang đặc biệt của Wikia: mở rộng Diễn đàn; vô hiệu',
	'forum-forum-title' => 'Diễn đàn',
	'forum-active-threads' => '$1 Thảo luận hoạt động',
	'forum-active-threads-on-topic' => "$1 Thảo luận hoạt động về: '''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span>{{PLURAL:$1|Chủ đề<br />trong diễn đàn này|Chủ đề<br />trong diễn đàn này}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span>{{PLURAL:$1|thảo luận<br />hoạt động|thảo luận<br />hoạt động}}</span>',
	'forum-specialpage-heading' => 'Diễn đàn',
	'forum-specialpage-blurb-heading' => '<span style="display:none">diễn đàn-trang đặc biệt-lời giới thiệu-Nhóm bạn có thể chỉnh sửa nó<span></span></span>',
	'forum-specialpage-board-threads' => '$1 luồng',
	'forum-specialpage-board-posts' => '$1 bài đăng',
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
	'forum-board-title' => 'Bảng $1',
	'forum-board-topic-title' => 'Thảo luận về $1',
	'forum-board-topics' => 'Chủ đề',
	'forum-board-thread-follow' => 'Theo dõi',
	'forum-board-thread-following' => 'Dừng theo dõi',
	'forum-board-thread-kudos' => '$1 nổi bật',
	'forum-board-thread-replies' => '$1 thông điệp',
	'forum-board-new-message-heading' => 'Bắt đầu một cuộc thảo luận',
	'forum-no-board-selection-error' => '← Xin vui lòng chọn bảng để đăng lên',
	'forum-thread-reply-placeholder' => 'Viết trả lời',
	'forum-thread-reply-post' => 'Trả lời',
	'forum-thread-deleted-return-to' => 'Trở lại bảng $1',
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
	'forum-wiki-activity-msg-name' => '$1 bảng',
	'forum-activity-module-heading' => 'Hoạt động gần đây trên diễn đàn',
	'forum-related-module-heading' => 'Luồng liên quan',
	'forum-activity-module-posted' => '$1 gửi một trả lời cách đây $2',
	'forum-activity-module-started' => '$1 bắt đầu một cuộc thảo luận cách đây $2',
	'forum-contributions-line' => '[[$1|$2]] trên [[$3|tường của $4]]',
	'forum-recentchanges-new-message' => 'trên [[$1|bảng $2]]',
	'forum-recentchanges-edit' => 'sửa đổi tin nhắn',
	'forum-recentchanges-removed-thread' => 'dời bỏ luồng "[[$1|$2]]" từ các [[$3|bảng $4]]',
	'forum-recentchanges-removed-reply' => 'dời bỏ trả lời từ "[[$1|$2]]" từ [[$3|bảng $4]]',
	'forum-recentchanges-restored-thread' => 'khôi phục luồng "[[$1|$2]]" từ [[$3|bảng $4]]',
	'forum-recentchanges-restored-reply' => 'khôi phục trả lời trên "[[$1|$2]]" tại [[$3|bảng $4]]',
	'forum-recentchanges-deleted-thread' => 'Xóa luồng "[[$1|$2]]" từ [[$3|bảng $4]]',
	'forum-recentchanges-deleted-reply' => 'dời bỏ trả lời từ "[[$1|$2]]" từ [[$3|bảng $4]]',
	'forum-recentchanges-deleted-reply-title' => 'Một bài đăng',
	'forum-recentchanges-namespace-selector-message-wall' => 'Bảng diễn đàn',
	'forum-recentchanges-thread-group' => '$1 trên [[$2|bảng $3]]',
	'forum-recentchanges-history-link' => 'lịch sử board',
	'forum-recentchanges-thread-history-link' => 'lịch sử luồng',
	'forum-recentchanges-closed-thread' => 'đóng chủ đề "[[$1|$2]]" từ [[$3|$4]]',
	'forum-recentchanges-reopened-thread' => 'mở lại luồng "[[$1|$2]]" từ [[$3|$4]]',
	'forum-board-history-title' => 'lịch sử bảng',
	'forum-specialpage-oldforum-link' => 'Các diễn đàn cũ lưu trữ',
	'forum-admin-page-breadcrumb' => 'Trình quản lý bảng Bảo quản viên',
	'forum-admin-create-new-board-label' => 'Tạo bảng mới',
	'forum-admin-create-new-board-modal-heading' => 'Tạo bảng mới',
	'forum-admin-create-new-board-title' => 'Tiêu đề bảng',
	'forum-admin-create-new-board-description' => 'Mô tả bảng',
	'forum-admin-edit-board-modal-heading' => 'Sửa đổi bảng: $1',
	'forum-admin-edit-board-title' => 'Tiêu đề bảng',
	'forum-admin-edit-board-description' => 'Mô tả bảng',
	'forum-admin-delete-and-merge-board-modal-heading' => 'Xóa bảng: $1',
	'forum-admin-delete-board-title' => 'Xin vui lòng xác nhận bằng cách gõ tên của Board mà bạn muốn xóa:',
	'forum-admin-merge-board-warning' => 'Các luồng trên bảng này sẽ được sáp nhập vào một bảng sẵn có khác.',
	'forum-admin-merge-board-destination' => 'Chọn một bảng để hợp nhất:',
	'forum-admin-delete-and-merge-button-label' => 'Xóa và hợp nhất',
	'forum-admin-link-label' => 'Quản lý bảng',
	'forum-autoboard-title-1' => 'Thảo luận chung',
	'forum-autoboard-body-1' => 'Bảng này dành cho những vấn đề thảo luận chung trên wikia.',
	'forum-autoboard-title-2' => 'Tin tức và thông báo',
	'forum-autoboard-body-2' => 'Thông tin và tin tức cập nhật!',
	'forum-autoboard-title-3' => 'Mới trên $1',
	'forum-autoboard-body-3' => 'Bạn muốn chia sẻ điều gì đó vừa được đăng tải trên wikia này, hay chúc mừng ai đó vì đóng góp ngoạn mục của họ? Đây là chính là nơi để bạn thực hiện điều đó!',
	'forum-autoboard-title-4' => 'Hỏi và đáp',
	'forum-autoboard-body-4' => 'Có câu hỏi về wikia, hoặc thắc mắc về chủ đề? Đặt câu hỏi của bạn tại đây!',
	'forum-autoboard-title-5' => 'Vui chơi và tán gẫu',
	'forum-autoboard-body-5' => 'Bảng này dành cho những thảo luận ngoài chủ đề -- một nơi để tự do thảo luận với bạn bè $1 của bạn.',
	'forum-board-destination-empty' => '(Xin vui lòng chọn bảng)',
	'forum-board-title-validation-invalid' => 'Tên bảng chứa ký tự không hợp lệ',
	'forum-board-title-validation-length' => 'Tên bảng phải chứa ít nhất 4 ký tự',
	'forum-board-title-validation-exists' => 'Một bảng với tên như thế này đã tồn tại',
	'forum-board-validation-count' => 'Số lượng bảng tối đa là $1',
	'forum-board-description-validation-length' => 'Xin vui lòng viết mô tả cho bảng này',
	'forum-board-id-validation-missing' => 'ID bảng này bị thiếu',
	'forum-board-no-board-warning' => 'Chúng tôi không thể tìm thấy bảng nào với tiêu đề đó. Dưới đây là danh sách các bảng diễn đàn.',
	'forum-related-discussion-heading' => 'Thảo luận về $1',
	'forum-related-discussion-new-post-button' => 'Bắt đầu một cuộc thảo luận',
	'forum-related-discussion-new-post-tooltip' => 'Bắt đầu một cuộc thảo luận mới về $1',
	'forum-related-discussion-total-replies' => '$1 thông điệp',
	'forum-related-discussion-see-more' => 'Xem thêm các cuộc thảo luận',
	'forum-confirmation-board-deleted' => "'''$1''' đã bị xóa.",
);

$messages['xw-3171'] = array(
	'forum-desc' => 'Wikia 的 Special:Forum 擴充套件',
	'forum-disabled-desc' => 'Wikia 的 Special:Forum 擴充套件，已停用',
	'forum-forum-title' => '論壇',
	'forum-active-threads' => '$1 {{PLURAL:$1|條活躍討論串|條活躍討論串}}',
	'forum-active-threads-on-topic' => "$1 {{PLURAL:$1|條活躍討論串|條活躍討論串}}關於：'''[[$2]]'''",
	'forum-header-total-threads' => '<em>$1</em><span> {{PLURAL:$1|條討論串<br />於此論壇|條討論串<br />於此論壇}}</span>',
	'forum-header-active-threads' => '<em>$1</em><span> {{PLURAL:$1|條活躍的<br />討論串|條活躍的<br />討論串}}</span>',
	'forum-specialpage-heading' => '論壇',
	'forum-specialpage-blurb-heading' => '<span style="display:none">forum-specialpage-blurb-heading 您可以編輯它<span>',
	'forum-specialpage-blurb' => '',
	'forum-specialpage-board-threads' => '$1 條{{PLURAL:$1|thread|討論串}}',
	'forum-specialpage-board-posts' => '$1 篇{{PLURAL:$1|文章|文章}}',
	'forum-specialpage-board-lastpostby' => '最後發佈由',
	'forum-specialpage-policies-edit' => '編輯',
	'forum-specialpage-policies' => '論壇政策/常見問題',
	'forum-policies-and-faq' => "==論壇政策==
在編輯{{SITENAME}}的論壇之前,請仔細閱讀以下指導內容:

'''請尊重他人.'''
:全世界的wiki使用者都可以自由在論壇上進行編輯。 就如同編輯許多wiki一樣，不是每個人都會具有相同的想法。所以請保持開放性的討論但同時也尊重其他人的想法。不要忘記，我們聚在一起是為了共同的一個感興趣的話題。

'''尋找已經存在的話題或者創建新的話題'''
:請大致瀏覽{{SITENAME}}社群的論壇版塊，看看是不是已經有其他人發表過類似的話題。如果沒有，那就趕快發起一個新的討論吧！

'''尋求幫助'''
:發現有些地方不對勁？或是有問題要問？趕快來論壇看一下吧！ 如果你需要尋求FANDOM員工的幫助，請訪問[[w:c:zh.community|社區中心]]或者[[Special:Contact|發送郵件]]給我們。

'''暢所欲言'''
:{{SITENAME}}社群非常歡迎你的參與！趕快發起你感興趣的話題，讓大家一起參與討論吧！

==論壇問與答==
'''我如何能夠關注一個討論？ '''
: 通過使用FANDOM的帳戶，你可以關注某個話題。當這個話題更新以後，你會通過郵件或者線上消息收到通知。請一定確定首先要[[Special:UserSignup|註冊一個FANDOM帳戶]]。

'''如何刪除一些破壞內容?'''
: 在討論頁面上，你可以按一下\"更多\"按鈕，之後選擇\"移除\"選項。這允許你刪除某個討論內容同時也會告知管理員這項操作。

'''「贊」是什麼？ '''
: 如果你發現某個話題非常有趣，可以通過點「贊」來告訴其他人。在投票類的話題中，這個功能將同樣適用。

'''話題是什麼？ '''
: 話題允許你將一篇wiki文章和論壇討論做連結。它是另外一種幫助管理員組織論壇內容並且吸引使用者參與討論的方式。比如說，以\"佛地魔\"為標籤的所有討論都將在\"佛地魔\"的文章中出現。",
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
	'forum-board-no-board-warning' => '這個標題的論壇板面不存在。 請再試一次或查看論壇板面清單。',
	'forum-related-discussion-heading' => '關於 $1 的討論',
	'forum-related-discussion-new-post-button' => '開始一個討論',
	'forum-related-discussion-new-post-tooltip' => '發起關於 $1 的討論',
	'forum-related-discussion-total-replies' => '$1 條訊息',
	'forum-related-discussion-see-more' => '請參考更多討論',
	'forum-confirmation-board-deleted' => ' "$1" 已被删除。',
	'forum-token-mismatch' => '哎呀 ！標記不匹配',
	'right-forumadmin' => '對論壇有管理員訪問權限',
	'right-forumoldedit' => '可以編輯舊的存檔論壇',
	'right-boardedit' => '編輯論壇的面板訊息。',
);

$messages['yi'] = array(
	'forum-recentchanges-edit' => 'רעדאקטירטע מעלדונג',
);

$messages['zh-hans'] = array(
	'forum-desc' => 'Wikia的Special:Forum extension',
	'forum-disabled-desc' => 'Wikia的Special:Forum extension已禁用',
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
	'forum-policies-and-faq' => "==论坛规定==
在编辑{{SITENAME}}论坛之前,请仔细阅读以下指导内容:

'''请尊重他人.'''
:全世界的维基用户都可以自由在论坛上进行编辑。就如同其他合作性的项目一样，不是每个人都会具有相同的想法。所以请保持开放性的讨论但同时也尊重其他人的观点。不要忘记，我们相聚在这里是为了共同的一个话题。

'''寻找已经存在的话题或者创建新的话题'''
:请大致浏览{{SITENAME}}论坛版块，看看是不是已经有其他人发表过类似的话题。如果没有，那就赶快发起一个新的讨论吧！

'''寻求帮助'''
:发现有些地方不对劲？或是有问题要问？赶快来论坛看一下吧！如果你需要寻求FANDOM员工的帮助，请访问[[w:c:zh.community|社区中心]]或者[[Special:Contact|发送邮件]]给我们。

'''畅所欲言'''
:{{SITENAME}}社区非常高兴有你的参与！赶快发起你感兴趣的话题，让大家一起参与讨论吧！

==论坛问与答==
'''我如何能够关注一个讨论？'''
: 通过使用FANDOM的帐户，你可以关注某个话题。当这个话题更新以后，你会通过邮件或者在线消息收到通知。请一定确定首先要[[Special:UserSignup|注册一个FANDOM帐户]]。

'''如何删除一些破坏内容?'''
: 在讨论的页面上，你可以点击\"更多\"按钮，之后点击\"移除\"选项。这允许你删除某个讨论内容同时也会告知管理员这项操作。

'''“赞”是什么？'''
: 如果你发现某个话题非常有趣，可以通过点“赞”来告诉其他人。在投票类的话题中，这个功能将同样适用。

'''话题是什么？'''
: 话题将允许你把论坛的讨论帖链接到文章页中去。它是另外一种帮助组织论坛内容并且吸引用户讨论的方式。比如说，以\"伏地魔\"为标签的所有讨论都将在出现在\"伏地魔\"的文章中出现。",
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
	'forum-mail-notification-body-HTML' => '您好$WATCHER,
<p>$SUBJECT.</p>
<p><a href=\\"$MESSAGE_LINK\\">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style=\\"padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;\\" href=\\"$MESSAGE_LINK\\">查看讨论n</a></p>
<p>Wikia团队</p>
___________________________________________<br />
* 登陆Wikia中文社区中心寻求帮助: http://zh.community.wikia.com
* 不希望收到我们的邮件通知？您可以点击这里进行更改: http://zh.community.wikia.com/Special:Preferences',
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
	'forum-board-no-board-warning' => '这个标题的论坛版块不存在。请再试一次或查看论坛版块列表。',
	'forum-related-discussion-heading' => '关于$1的讨论',
	'forum-related-discussion-new-post-button' => '开始讨论',
	'forum-related-discussion-new-post-tooltip' => '开始讨论$1',
	'forum-related-discussion-total-replies' => '$1条信息',
	'forum-related-discussion-see-more' => '参阅更多讨论',
	'forum-confirmation-board-deleted' => '“$1”已被删除。',
	'forum-token-mismatch' => '哎呀 ！标记不匹配',
	'forum-specialpage-blurb' => '',
	'right-forumadmin' => '对论坛有管理员访问权限',
	'right-forumoldedit' => '可以编辑旧的存档的论坛内容',
	'right-boardedit' => '编辑论坛面板信息',
);

$messages['zh-hant'] = array(
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
	'forum-policies-and-faq' => "==論壇政策==
在編輯{{SITENAME}}的論壇之前,請仔細閱讀以下指導內容:

'''請尊重他人.'''
:全世界的wiki使用者都可以自由在論壇上進行編輯。 就如同編輯許多wiki一樣，不是每個人都會具有相同的想法。所以請保持開放性的討論但同時也尊重其他人的想法。不要忘記，我們聚在一起是為了共同的一個感興趣的話題。

'''尋找已經存在的話題或者創建新的話題'''
:請大致瀏覽{{SITENAME}}社群的論壇版塊，看看是不是已經有其他人發表過類似的話題。如果沒有，那就趕快發起一個新的討論吧！

'''尋求幫助'''
:發現有些地方不對勁？或是有問題要問？趕快來論壇看一下吧！ 如果你需要尋求FANDOM員工的幫助，請訪問[[w:c:zh.community|社區中心]]或者[[Special:Contact|發送郵件]]給我們。

'''暢所欲言'''
:{{SITENAME}}社群非常歡迎你的參與！趕快發起你感興趣的話題，讓大家一起參與討論吧！

==論壇問與答==
'''我如何能夠關注一個討論？ '''
: 通過使用FANDOM的帳戶，你可以關注某個話題。當這個話題更新以後，你會通過郵件或者線上消息收到通知。請一定確定首先要[[Special:UserSignup|註冊一個FANDOM帳戶]]。

'''如何刪除一些破壞內容?'''
: 在討論頁面上，你可以按一下\"更多\"按鈕，之後選擇\"移除\"選項。這允許你刪除某個討論內容同時也會告知管理員這項操作。

'''「贊」是什麼？ '''
: 如果你發現某個話題非常有趣，可以通過點「贊」來告訴其他人。在投票類的話題中，這個功能將同樣適用。

'''話題是什麼？ '''
: 話題允許你將一篇wiki文章和論壇討論做連結。它是另外一種幫助管理員組織論壇內容並且吸引使用者參與討論的方式。比如說，以\"佛地魔\"為標籤的所有討論都將在\"佛地魔\"的文章中出現。",
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
	'forum-board-no-board-warning' => '這個標題的論壇板面不存在。 請再試一次或查看論壇板面清單。',
	'forum-related-discussion-heading' => '關於 $1 的討論',
	'forum-related-discussion-new-post-button' => '發起討論',
	'forum-related-discussion-new-post-tooltip' => '發起關於 $1 的討論',
	'forum-related-discussion-total-replies' => '$1 條訊息',
	'forum-related-discussion-see-more' => '請參考更多討論',
	'forum-confirmation-board-deleted' => ' "$1" 已被删除。',
	'forum-specialpage-blurb' => '',
	'forum-token-mismatch' => '哎呀 ！標記不匹配',
	'right-forumadmin' => '對論壇有管理員訪問權限',
	'right-forumoldedit' => '可以編輯舊的存檔論壇',
	'right-boardedit' => '編輯論壇的面板訊息。',
);

