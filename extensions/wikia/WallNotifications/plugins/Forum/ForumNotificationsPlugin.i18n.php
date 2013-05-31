<?php

$messages = array();

$messages['en'] = array(
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
);
