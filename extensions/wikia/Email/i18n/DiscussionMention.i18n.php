<?php
$messages = array();

$messages['en'] = array(
	'emailext-discussionmention-subject' => 'You have a new mention on $1 Discussions',
	'emailext-discussionmention-summary' => "'''You were mentioned by [$1 $2] on $3 Discussions: [$4 See what they said]'''",
	'emailext-discussionmention-conversation' => 'Join the conversation',
);

$messages['qqq'] = array(
	'emailext-wallmessage-owned-subject' => 'Email subject when another user wrote a new message on your wall. $1 is the wall message title.',
	'emailext-wallmessage-following-subject' => "Email subject when a user wrote a new message on another user's wall, and you are following the thread. $1 is the name of the wall owner (user), $2 is the wall message title.",
	'emailext-wallmessage-owned-summary' => 'Text describing that another user wrote a new message on your wall. $1 is a URL to the wall message thread, $2 is the wall message title.',
	'emailext-wallmessage-following-summary' => "Text describing that a user wrote a new message on another user's wall. $1 is the wall owner (user), $2 is a URL to the wall message thread, $3 is the wall message title.",
	'emailext-wallmessage-full-conversation' => 'Text for button that, when clicked, navigates to the full message wall conversation',
	'emailext-wallmessage-recent-messages' => "Call to action to view all recent messages on the user's message wall. $1 -> link to message wall, $2 message wall name",
	'emailext-wallmessage-reply-subject' => 'Email subject when a reply was made to a wall thread the user is following. $1 is the wall message title.',
	'emailext-wallmessage-reply-summary' => 'Text describing that a reply was made to a wall thread the user is following. $1 is a URL to the wall message thread, $1 is the wall message title.',
);
