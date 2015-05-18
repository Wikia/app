<?php
$messages = array();

$messages['en'] = [
	'emailext-forum-subject' => 'There is a new discussion on $1 on {{SITENAME}}.',
	'emailext-forum-summary' => "'''There is a new discussion on [$1 $2] on [{{SERVER}} {{SITENAME}}].'''",
	'emailext-forum-button-label' => 'See the discussion',
	'emailext-forum-reply-subject' => '$1 on {{SITENAME}} has new replies.',
	'emailext-forum-reply-summary' => "'''[$2 $1] on [{{SERVER}} {{SITENAME}}] has new replies.'''",
	'emailext-forum-reply-link-label' => 'Read the reply',
	'emailext-forum-reply-view-all' => '[$1 See the entire discussion.]'
];

$messages['qqq'] = [
	'emailext-forum-subject' => 'Subject for email that is fired when new thread is created. $1 -> Forum board name where thread was created.',
	'emailext-forum-summary' => "Message to the user that new forum thread was created. $1 -> thread url, $2 -> thread name",
	'emailext-forum-button-label' => 'Text for button that, when clicked, navigates to the new forum thread.',
	'emailext-forum-reply-summary' => 'Information about the new replies in thread. $1 is the thread subject.',
    'emailext-forum-reply-link-label' => 'Link to the post, permalink.',
    'emailext-forum-reply-view-all' => 'Link to the thread page.'
];
