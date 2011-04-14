<?php

$messages = array();

$messages['en'] = array(
	'chat-desc' => '[[Special:Chat|Live chat]]',
	'chat-no-login' => 'You must be logged in to chat.',
	'chat-no-login-text' => 'Please login to chat.',
	'chat-default-topic' => 'Welcome to the $1 chat',

	// Possible errors when trying to kick/ban a user:
	'chat-ban-cant-ban-moderator' => "You cannot kick/ban another Chat Moderator.",
	'chat-ban-already-banned' => '$1 is already banned from chat on this wiki.',
	'chat-ban-you-need-permission' => 'You do not have the $1 permission which is required to kick/ban a user.',
	'chat-ban-requires-usertoban-parameter' => '\'$1\' is required but was not found in the request.',

	'chat-you-are-banned' => 'Permissions error.',
	// TODO: link to list of admins
	'chat-you-are-banned-text' => 'Sorry, you do not have permission to chat on this wiki.  If you think this was a mistake or would like to be reconsidered, please contact an administrator.',
	'chat-room-is-not-on-this-wiki' => 'The chat room you are attempting to enter does not appear to exist on this wiki.',
	'chat-kick-log-reason' => 'Kick/banned from the chat for this wiki by $1. Please contact them for more info.',
	'chat-headline' => '$1 Chat',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Start a Chat',
	'chat-whos-here' => "Who's here ($1)",
	'chat-join-the-chat' => 'Join the Chat',
	'chat-edit-count' => '$1 Edits',
	'chat-member-since' => 'Member since $1'
);
