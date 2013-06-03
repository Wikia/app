<?php

$messages = array();

$messages['en'] = array(
	'wn-user1-reply-you-your-wall' => '$1 replied to your message on your wall',
	'wn-user2-reply-you-your-wall' => '$1 and $2 replied to your message on your wall',
	'wn-user3-reply-you-your-wall' => '$1 and others replied to your message on your wall',
	'wn-user1-reply-self-your-wall' => '$1 replied to a message on your wall',
	'wn-user2-reply-self-your-wall' => '$1 and $2 replied to a message on your wall',
	'wn-user3-reply-self-your-wall' => '$1 and others replied to a message on your wall',
	'wn-user1-reply-other-your-wall' => '$1 replied to $2\'s message on your wall',
	'wn-user2-reply-other-your-wall' => '$1 and $2 replied to $3\'s message on your wall',
	'wn-user3-reply-other-your-wall' => '$1 and others replied to $2\'s message on your wall',
	'wn-user1-reply-you-other-wall' => '$1 replied to your message on $2\'s wall',
	'wn-user2-reply-you-other-wall' => '$1 and $2 replied to your message on $3\'s wall',
	'wn-user3-reply-you-other-wall' => '$1 and others replied to your message on $3\'s wall',
	'wn-user1-reply-self-other-wall' => '$1 replied to a message on $2\'s wall',
	'wn-user2-reply-self-other-wall' => '$1 and $2 replied to a message on $3\'s wall',
	'wn-user3-reply-self-other-wall' => '$1 and others replied to a message on $2\'s wall',
	'wn-user1-reply-other-other-wall' => '$1 replied to $2\'s message on $3\'s wall',
	'wn-user2-reply-other-other-wall' => '$1 and $2 replied to $3\'s message on $4\'s wall',
	'wn-user3-reply-other-other-wall' => '$1 and others replied to $2\'s message on $3\'s wall',
	'wn-user1-reply-you-a-wall' => '$1 replied to your message',
	'wn-user2-reply-you-a-wall' => '$1 and $2 replied to your message',
	'wn-user3-reply-you-a-wall' => '$1 and others replied to your message',
	'wn-user1-reply-self-a-wall' => '$1 replied to a message',
	'wn-user2-reply-self-a-wall' => '$1 and $2 replied to a message',
	'wn-user3-reply-self-a-wall' => '$1 and others replied to a message',
	'wn-user1-reply-other-a-wall' => '$1 replied to $2\'s message',
	'wn-user2-reply-other-a-wall' => '$1 and $2 replied to $3\'s message',
	'wn-user3-reply-other-a-wall' => '$1 and others replied to $3\'s message',
	'wn-newmsg-onmywall' => '$1 left a new message on your wall',
	'wn-newmsg' => 'You left a new message on $1\'s wall',
	'wn-newmsg-on-followed-wall' => '$1 left a new message on $2\'s wall',

	'wn-admin-thread-deleted' => 'Thread removed from $1\'s wall',
	'wn-admin-reply-deleted' => 'Reply removed from thread on $1\'s wall',
	'wn-owner-thread-deleted' => 'Thread removed from your wall',
	'wn-owner-reply-deleted' => 'Reply removed from thread on your wall',

	'mail-notification-new-someone' => '$AUTHOR_NAME wrote a new message on $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME left you a new message on $WIKI.',

	'mail-notification-reply-your' => '$AUTHOR_NAME replied to your message on $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME replied to a message on $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME replied to $PARENT_AUTHOR_NAME\'s message on $WIKI.',

	'mail-notification-html-greeting' => 'Hi $1,',
	'mail-notification-html-button' => 'See the conversation',

	'mail-notification-subject' => '$1 -- $2',

'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',


	'mail-notification-html-footer-line1' => 'To check out the latest happenings on Wikia, visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Want to control which emails you receive? Go to your <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',

'mail-notification-body' => 'Hi $WATCHER,

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

	'mail-notification-body-HTML' => 'Hi $WATCHER,
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

/** Message documentation (Message documentation)
 * @author Metalhead64
 * @author PtM
 * @author SandroHc
 * @author Shirayuki
 * @author Siebrand
 * @author Wyz
 */
$messages['qqq'] = array(
	'wn-user1-reply-you-your-wall' => 'Notification when someone replies on your wall. Parameters:
* $1 is a username (GENDER is supported in this message).',
	'wn-user2-reply-you-your-wall' => "Notification when 2 users reply on the logged in user's wall. Parameters:
* $1 and $2 are names of users that replied (GENDER is supported in this message).",
	'wn-user3-reply-you-your-wall' => "Notification when 3 or more users reply on the logged in user's wall. Parameters:
* $1 is the first user who replied (GENDER is supported in this message).",
	'wn-user1-reply-self-your-wall' => 'Notification when a user replies to a thread that user started. Parameters:
* $1 is a username (GENDER is supported in this message).',
	'wn-user2-reply-self-your-wall' => 'Notification when 2 users reply to a thread that one of them started. Parameters:
* $1 and $2 are names of users that replied (GENDER is supported in this message).',
	'wn-user3-reply-self-your-wall' => 'Notification when 3 or more users reply to a thread that one of them started. Parameters:
* $1 is the first user who replied (GENDER is supported in this message).',
	'wn-user1-reply-other-your-wall' => 'Notification. Parameters:
* $1 is user replying (GENDER is supported in this message).
* $2 is user who started the thread (GENDER is supported in this message).',
	'wn-user2-reply-other-your-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying
* $3 is user who started the thread.',
	'wn-user3-reply-other-your-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is first user replying, $2 is user who started the thread.',
	'wn-user1-reply-you-other-wall' => 'Notification.GENDER is supported in this message. Parameters:
* $1 is user replying to a thread you started
* $2 is wall owner.',
	'wn-user2-reply-you-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying to a thread you started
* $3 is wall owner.',
	'wn-user3-reply-you-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is first user replying to a thread you started
* $3 is wall owner.',
	'wn-user1-reply-self-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is user replying to a thread that user started
* $2 is wall owner.',
	'wn-user2-reply-self-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying to a thread that one of them started
* $3 is wall owner.',
	'wn-user3-reply-self-other-wall' => 'Notification when 3 or more users reply to a thread that one of them started. GENDER is supported in this message. Parameters:
* $1 is first user who replied
* $2 is wall owner.',
	'wn-user1-reply-other-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 is user replying
* $2 is user who started the thread
* $3 is wall owner.',
	'wn-user2-reply-other-other-wall' => 'Notification. GENDER is supported in this message. Parameters:
* $1 and $2 are users replying
* $3 is user who started the thread
* $4 is wall owner.',
	'wn-user3-reply-other-other-wall' => 'Notification when 3 or more users reply to a thread, $1 is first user who replied, $2 is user who started the thread, $3 is wall owner(you can use GENDER in this message)',
	'wn-user1-reply-you-a-wall' => 'Notification, $1 is user who replied to a thread you started(you can use GENDER in this message)',
	'wn-user2-reply-you-a-wall' => 'Notification, $1 and $2 are users who replied to a thread you started(you can use GENDER in this message)',
	'wn-user3-reply-you-a-wall' => 'Notification when 3 or more users reply to a thread you started, $1 is first user who replied(you can use GENDER in this message)',
	'wn-user1-reply-self-a-wall' => 'Notification, $1 is user who replied to a message that that user started on his or her own wall(you can use GENDER in this message)',
	'wn-user2-reply-self-a-wall' => 'Notification, $1 and $2 are users who replied to a message that one of them started on his or her own wall(you can use GENDER in this message)',
	'wn-user3-reply-self-a-wall' => 'Notification when 3 or more users reply to a thread that one of them started on his or her own wall, $1 is first user who replied(you can use GENDER in this message)',
	'wn-user1-reply-other-a-wall' => 'Notification when wall owner is one of the users involved. Parameters:
* $1 is user who replied
* $2 started the thread(you can use GENDER in this message)',
	'wn-user2-reply-other-a-wall' => 'Notification when wall owner is one of the users involved, $1 and $2 are users who replied, $3 started the thread(you can use GENDER in this message)',
	'wn-user3-reply-other-a-wall' => 'Notification when 3 or more users reply and wall owner is one of the users involved, $1 is first user who replied, $3 started the thread(you can use GENDER in this message)',
	'wn-newmsg-onmywall' => 'Notification, $1 started a new thread on your wall',
	'wn-newmsg' => "Notification when you follow a user's wall and start a new thread on that user's wall, $1 is wall owner",
	'wn-newmsg-on-followed-wall' => "Notification when you follow a user's wall, $1 is user who started a new thread, $2 is wall owner",
	'wn-admin-thread-deleted' => 'Admin notification of a removed thread, $1 is wall owner',
	'wn-admin-reply-deleted' => 'Admin notification of a removed reply, $1 is wall owner',
	'wn-owner-thread-deleted' => 'Notification for wall owner of removed thread',
	'wn-owner-reply-deleted' => 'Notification for wall owner of removed reply',
	'mail-notification-new-someone' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-new-your' => 'Rmail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-reply-your' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-reply-his' => 'Email notification. Parameters:
* $AUTHOR_NAME is user
* $WIKI is wiki name.',
	'mail-notification-reply-someone' => 'E-mail notification. Parameters:
* $AUTHOR_NAME is a user name
* $PARENT_AUTHOR_NAME is user who started the thread
* $WIKI is wiki name.',
	'mail-notification-html-greeting' => 'E-mail notification greeting. Parameters:
* $1 is a username.
{{Identical|Hi}}',
	'mail-notification-html-button' => 'Email notification, button to visit the thread.',
	'mail-notification-subject' => 'Email notification title. Parameters:
* $1 is thread title
* $2 is wiki.',
	'mail-notification-html-footer-line3' => 'E-mail notification footer with links to Twitter, Facebook, YouTube and Wikia staff blog.',
	'mail-notification-html-footer-line1' => 'Email notification footer with link to Community Central.',
	'mail-notification-html-footer-line2' => 'E-mail notification footer with link to preferences.',
	'mail-notification-body' => 'E-mail notification body text.',
	'mail-notification-body-HTML' => 'E-mail notification body text with HTML.',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
	'wn-user1-reply-you-your-wall' => 'قام $1 بالرد على رسالتك على جدارك',
	'wn-user2-reply-you-your-wall' => 'قام كلا من $1 و $2 بالرد على رسالتك في جدارك',
	'wn-user3-reply-you-your-wall' => 'قام  $1 و آخرون بالرد على رسالتك على جدارك',
	'wn-user1-reply-self-your-wall' => 'قام $1 بالرد على رسالة على جدارك',
	'wn-user2-reply-self-your-wall' => 'قام كلا من $1 و $2 بالرد على رسالة في جدارك',
	'wn-user3-reply-self-your-wall' => 'قام  $1 و آخرون بالرد على رسالة على جدارك',
	'wn-user1-reply-other-your-wall' => 'قام $1 بالرد على رسالة $2 على جدارك',
	'wn-user2-reply-other-your-wall' => 'قام كلا من $1 و $2 بالرد على رسالة $3 في جدارك',
	'wn-user3-reply-other-your-wall' => 'قام  $1 و آخرون بالرد على رسالة $2 على جدارك',
	'wn-user1-reply-you-other-wall' => 'قام $1 بالرد على رسالتك على جدار $2',
	'wn-user2-reply-you-other-wall' => 'قام كلا من $1 و $2 بالرد على رسالتك في جدار $3',
	'wn-user3-reply-you-other-wall' => 'قام  $1 و آخرون بالرد على رسالتك على جدار $3',
	'wn-user1-reply-self-other-wall' => 'قام $1 بالرد على رسالة على جدار $2',
	'wn-user2-reply-self-other-wall' => 'قام كلا من $1 و $2 بالرد على رسالة في جدار $3',
	'wn-user3-reply-self-other-wall' => 'قام  $1 و آخرون بالرد على رسالة على جدار $2',
	'wn-user1-reply-other-other-wall' => 'قام $1 بالرد على رسالة $2 على جدار $3',
	'wn-user2-reply-other-other-wall' => 'قام كلا من $1 و $2 بالرد على رسالة $3 في جدار $4',
	'wn-user3-reply-other-other-wall' => 'قام  $1 و آخرون بالرد على رسالة $2 على جدار $3',
	'wn-user1-reply-you-a-wall' => 'قام $1 بالرد على رسالتك',
	'wn-user2-reply-you-a-wall' => 'قام كلا من $1 و $2 بالرد على رسالتك',
	'wn-user3-reply-you-a-wall' => 'قام $1 و آخرون بالرد على رسالتك',
	'wn-user1-reply-self-a-wall' => 'قام $1 بالرد على رسالة',
	'wn-user2-reply-self-a-wall' => 'قام كلا من $1 و $2 بالرد على رسالة',
	'wn-user3-reply-self-a-wall' => 'قام $1 و آخرون بالرد على رسالة',
	'wn-user1-reply-other-a-wall' => 'قام $1 بالرد على رسالة $2',
	'wn-user2-reply-other-a-wall' => 'قام كلا من $1 و $2 بالرد على رسالة $3',
	'wn-user3-reply-other-a-wall' => 'قام $1 و آخرون بالرد على رسالة $3',
	'wn-newmsg-onmywall' => 'قام  $1 بترك رسالة جديدة على جدارك',
	'wn-newmsg' => 'تركت رسالة جديدة على جدار $1',
	'wn-newmsg-on-followed-wall' => 'قام  $1 بترك رسالة جديدة على جدار $2',
	'wn-admin-thread-deleted' => 'تم حذف النقاش من جدار $1',
	'wn-admin-reply-deleted' => 'تمت إزالة الرد من النقاش على جدار $1',
	'wn-owner-thread-deleted' => 'تم حذف النقاش من جدارك',
	'wn-owner-reply-deleted' => 'تمت إزالة الرد عن جدارك',
	'mail-notification-new-someone' => 'كتب $AUTHOR_NAME رسالة جديدة على $WIKI.',
	'mail-notification-new-your' => 'ترك $AUTHOR_NAME رسالة جديدة على $WIKI.',
	'mail-notification-reply-your' => 'رد $AUTHOR_NAME على رسالتك في $WIKI.',
	'mail-notification-reply-his' => 'رد $AUTHOR_NAME على رسالة في $WIKI.',
	'mail-notification-reply-someone' => 'رد $AUTHOR_NAME على رسالة $PARENT_AUTHOR_NAME في $WIKI.',
	'mail-notification-html-greeting' => 'مرحبا $1،',
	'mail-notification-html-button' => 'مشاهدة المحادثة',
	'mail-notification-html-footer-line1' => 'للتحقق من آخر الأحداث في ويكيا، قم بزيارة <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'تريد التحكم في رسائل البريد التي تتلقاها منا؟ انتقل إلى <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">تفضيلاتك</a>',
	'mail-notification-body' => 'مرحبا $WATCHER،


$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

شاهد النقاش ($MESSAGE_LINK)

فريق ويكيا

___________________________________________
* البحث عن النصائح والمساعدة في مركز المجتمع: http://community.wikia.com
* تريد تلقي رسائل أقل منا؟ يمكنك إلغاء الاشتراك أو تغيير
تفضيلات بريدك الإلكتروني هنا: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'مرحبا $WATCHER،
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">شاهد النقاش</a></p>
			<p>فريق ويكيا</p>
___________________________________________<br />
* البحث عن النصائح والمساعدة في مركز المجتمع: http://community.wikia.com
* تريد تلقي رسائل أقل منا؟ يمكنك إلغاء الاشتراك أو تغيير
تفضيلات بريدك الإلكتروني هنا: http://community.wikia.com/Special:Preferences',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'wn-user1-reply-you-a-wall' => "$1 en deus respontet d'ho kemennadenn",
	'wn-user2-reply-you-a-wall' => "$1 ha $2 o deus respontet d'ho kemennadenn",
	'wn-user3-reply-you-a-wall' => "$1 ha re all o deus respontet d'ho kemennadenn",
	'wn-user1-reply-self-a-wall' => "$1 en deus respontet d'ur gemennadenn",
	'wn-user2-reply-self-a-wall' => "$1 ha $2 o deus respontet d'ur gemennadenn",
	'wn-user3-reply-self-a-wall' => "$1 ha re all o deus respontet d'ur gemennadenn",
	'wn-user1-reply-other-a-wall' => '$1 en deus respontet da gemennadenn $2',
	'wn-user2-reply-other-a-wall' => '$1 ha $2 o deus respontet da gemennadenn $3',
	'wn-user3-reply-other-a-wall' => '$1 ha re all o deus respontet da gemennadenn $3',
	'wn-newmsg-onmywall' => '$1 en deus lezet ur gemennadenn war ho moger',
	'wn-newmsg' => 'Lezet ho peus ur gemennadenn nevez war moger $1',
	'wn-newmsg-on-followed-wall' => '$1 en deus lezet ur gemennadenn nevez war moger $2',
	'wn-admin-thread-deleted' => 'Neudennad lamet diouzh moger $1',
	'mail-notification-html-greeting' => "Demat deoc'h $1,",
	'mail-notification-html-button' => 'Gwelet ar gaoz',
);

/** Catalan (català)
 * @author BroOk
 * @author Erdemaslancan
 */
$messages['ca'] = array(
	'wn-user1-reply-you-your-wall' => '$1 ha respost el teu missatge al teu Mur',
	'wn-user2-reply-you-your-wall' => '$1 i $2 han respost al teu missatge al teu Mur',
	'wn-user3-reply-you-your-wall' => '$1 i altres han respost el teu missatge al teu Mur',
	'wn-user1-reply-self-your-wall' => '$1 ha respost un missatge al teu Mur',
	'wn-user2-reply-self-your-wall' => '$1 i $2 han respost un missatge al teu Mur',
	'wn-user3-reply-self-your-wall' => '$1 i altres han respost un missatge al teu Mur',
	'wn-user1-reply-other-your-wall' => '$1 ha respost el missatge de $2 al teu Mur',
	'wn-user2-reply-other-your-wall' => '$1 i $2 han respost el missatge de $3 al teu Mur',
	'wn-user3-reply-other-your-wall' => '$1 i altres han respost el missatge de $2 al teu Mur',
	'wn-user1-reply-you-other-wall' => '$1 ha respost el teu missatge al mur de $2',
	'wn-user2-reply-you-other-wall' => '$1 i $2 han respost el teu missatge al mur de $3',
	'wn-user3-reply-you-other-wall' => '$1 i altres han respost el teu missatge al mur de $3',
	'wn-user1-reply-self-other-wall' => '$1 ha respost un missatge al mur de $2',
	'wn-user2-reply-self-other-wall' => '$1 i $2 han respost un missatge al mur de $3',
	'wn-user3-reply-self-other-wall' => '$1 i altres han respost un missatge al mur de $2',
	'wn-user1-reply-other-other-wall' => '$1 ha respost el missatge de $2 al mur de $3',
	'wn-user2-reply-other-other-wall' => '$1 i $2 han respost el missatge de $3 al mur de $4',
	'wn-user3-reply-other-other-wall' => '$1 i altres han respost el missatge de $2 al mur de $3',
	'wn-user1-reply-you-a-wall' => '$1 ha respost el teu missatge',
	'wn-user2-reply-you-a-wall' => '$1 i $2 han respost el teu missatge',
	'wn-user3-reply-you-a-wall' => '$1 i altres han respost el teu missatge',
	'wn-user1-reply-self-a-wall' => '$1 ha respost un missatge',
	'wn-user2-reply-self-a-wall' => '$1 i $2 han respost un missatge',
	'wn-user3-reply-self-a-wall' => '$1 i altres han respost un missatge',
	'wn-user1-reply-other-a-wall' => '$1 ha respost el missatge de $2',
	'wn-user2-reply-other-a-wall' => '$1 i $2 han respost el missatge de $3',
	'wn-user3-reply-other-a-wall' => '$1 i altres han respost el missatge de $3',
	'wn-newmsg-onmywall' => '$1 ha deixat un missatge nou al teu mur',
	'wn-newmsg' => 'Has deixat un missatge nou al mur de $1',
	'wn-newmsg-on-followed-wall' => '$1 ha deixat un missatge nou al mur de $2',
	'wn-admin-thread-deleted' => 'Tema retirat del mur de $1',
	'wn-admin-reply-deleted' => 'Resposta retirada del tema al mur de $1',
	'wn-owner-thread-deleted' => 'Tema retirat del teu mur',
	'wn-owner-reply-deleted' => 'Resposta retirada del tema del teu mur',
	'mail-notification-new-someone' => '$AUTHOR_NAME ha escrit un missatge nou a $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME t\'ha deixat un missatge nou a $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME ha respost el teu missatge a $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME ha respost a un missatge a $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME ha respost el missatge de $PARENT_AUTHOR_NAME a $WIKI.',
	'mail-notification-html-greeting' => 'Hola $1,',
	'mail-notification-html-button' => 'Veure la conversació',
	'mail-notification-html-footer-line1' => 'Per a comprovar les últimes novetats de Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://ca.wikia.com">ca.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vols controlar els emails que reps? Vés a les teves <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferències</a>',
	'mail-notification-body' => 'Hola $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Veure la conversació($MESSAGE_LINK)

L\'equip de Wikia

___________________________________________
* Troba l\'ajuda i els consells que necessites a la Central de Wikia en català: http://ca.wikia.com
* Vols rebre menys missatges de nosaltres? Pots canviar les teves preferències respecte als emails aquí: http://ca.wikia.com/wiki/Especial:Preferències',
	'mail-notification-body-HTML' => 'Hola $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Veure la conversació</a></p>
<p>L\'equip de Wikia</p>
___________________________________________<br />
* Troba l\'ajuda i els consells que necessites a la Central de Wikia en català: http://ca.wikia.com
* Vols rebre menys missatges de nosaltres? Pots canviar les teves preferències respecte als emails aquí: http://ca.wikia.com/wiki/Especial:Preferències',
);

/** Czech (česky)
 * @author Chmee2
 * @author Vks
 */
$messages['cs'] = array(
	'mail-notification-new-someone' => 'Na $WIKI $AUTHOR_NAME napsal novou zprávu.',
	'mail-notification-new-your' => '$AUTHOR_NAME vám nechal novou zprávu na $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME odpověděl na vaši zprávu na $WIKI.',
	'mail-notification-html-greeting' => 'Ahoj $1,',
);

/** German (Deutsch)
 * @author Arkondi
 * @author Dennis07
 * @author Geitost
 * @author Inkowik
 * @author Metalhead64
 * @author MtaÄ
 * @author PtM
 */
$messages['de'] = array(
	'wn-user1-reply-you-your-wall' => '$1 hat dir auf deiner Nachrichtenseite geantwortet',
	'wn-user2-reply-you-your-wall' => '$1 und $2 haben dir auf deiner Nachrichtenseite geantwortet',
	'wn-user3-reply-you-your-wall' => '$1 und weitere haben dir auf deiner Nachrichtenseite geantwortet',
	'wn-user1-reply-self-your-wall' => '$1 hat auf deiner Nachrichtenseite geantwortet',
	'wn-user2-reply-self-your-wall' => '$1 und $2 haben auf deiner Nachrichtenseite geantwortet',
	'wn-user3-reply-self-your-wall' => '$1 und weitere haben auf deiner Nachrichtenseite geantwortet',
	'wn-user1-reply-other-your-wall' => '$1 hat bei dir auf $2s Nachricht geantwortet',
	'wn-user2-reply-other-your-wall' => '$1 und $2 haben bei dir auf $3s Nachricht geantwortet',
	'wn-user3-reply-other-your-wall' => '$1 und weitere haben bei dir auf $2s Nachricht geantwortet',
	'wn-user1-reply-you-other-wall' => '$1 hat bei $2 auf deine Nachricht geantwortet',
	'wn-user2-reply-you-other-wall' => '$1 und $2 haben bei $3 auf deine Nachricht geantwortet',
	'wn-user3-reply-you-other-wall' => '$1 und weitere haben bei $3 auf deine Nachricht geantwortet',
	'wn-user1-reply-self-other-wall' => '$1 hat auf $2s Nachrichtenseite geantwortet',
	'wn-user2-reply-self-other-wall' => '$1 und $2 haben auf $3s Nachrichtenseite geantwortet',
	'wn-user3-reply-self-other-wall' => '$1 und weitere haben auf $2s Nachrichtenseite geantwortet',
	'wn-user1-reply-other-other-wall' => '$1 hat bei $3 auf $2s Nachricht geantwortet',
	'wn-user2-reply-other-other-wall' => '$1 und $2 haben bei $4 auf $3s Nachricht geantwortet',
	'wn-user3-reply-other-other-wall' => '$1 und weitere haben bei $3 auf $2s Nachricht geantwortet',
	'wn-user1-reply-you-a-wall' => '$1 hat auf deine Nachricht geantwortet',
	'wn-user2-reply-you-a-wall' => '$1 und  $2 haben auf deine Nachricht geantwortet',
	'wn-user3-reply-you-a-wall' => '$1 und andere haben auf deine Nachricht geantwortet',
	'wn-user1-reply-self-a-wall' => '$1 hat auf eine Nachricht geantwortet',
	'wn-user2-reply-self-a-wall' => '$1 und  $2 haben auf eine Nachricht geantwortet',
	'wn-user3-reply-self-a-wall' => '$1 und andere haben auf eine Nachricht geantwortet',
	'wn-user1-reply-other-a-wall' => '$1 hat auf $2s Nachricht geantwortet',
	'wn-user2-reply-other-a-wall' => '$1 und $2 haben auf $3s Nachricht geantwortet',
	'wn-user3-reply-other-a-wall' => '$1 und weitere haben auf $3s Nachricht geantwortet',
	'wn-newmsg-onmywall' => '$1 hat dir eine neue Nachricht hinterlassen',
	'wn-newmsg' => 'Du hast $1 eine neue Nachricht hinterlassen',
	'wn-newmsg-on-followed-wall' => '$1 hat $2 eine neue Nachricht hinterlassen',
	'wn-admin-thread-deleted' => 'Thread von $1s Nachrichtenseite entfernt',
	'wn-admin-reply-deleted' => 'Antwort aus Thread auf $1s Nachrichtenseite entfernt',
	'wn-owner-thread-deleted' => 'Thread von deiner Nachrichtenseite entfernt',
	'wn-owner-reply-deleted' => 'Antwort aus Thread auf deiner Nachrichtenseite entfernt',
	'mail-notification-new-someone' => '$AUTHOR_NAME hat eine neue Nachricht auf $WIKI geschrieben.',
	'mail-notification-new-your' => '$AUTHOR_NAME hat dir eine neue Nachricht auf $WIKI geschrieben.',
	'mail-notification-reply-your' => '$AUTHOR_NAME hat auf deine Nachricht im $WIKI geantwortet.',
	'mail-notification-reply-his' => '$AUTHOR_NAME hat auf eine Nachricht im $WIKI geantwortet.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME hat auf $PARENT_AUTHOR_NAMEs Nachricht im $WIKI geantwortet.',
	'mail-notification-html-greeting' => 'Hallo $1,',
	'mail-notification-html-button' => 'Diskussion einsehen',
	'mail-notification-html-footer-line1' => 'Bleib auf dem Laufenden und besuche unser Community-Wiki unter <a style="color:#2a87d5;text-decoration:none;" href="http://de.community.wikia.com">de.community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Möchtest du deine E-Mail-Einstellungen ändern? Besuche <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">deine Einstellungen</a>',
	'mail-notification-body' => 'Hallo $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

--$AUTHOR

Siehe Diskussion ($MESSAGE_LINK)

Das Wikia-Team

___________________________________________
 * Hilfe und Beratung im Community-Wiki finden: http://de.community.wikia.com
 * Weniger Nachrichten von uns erhalten? Abmelden oder Ändern der
 E-Mail-Einstellungen hier: http://de.community.wikia.com/Spezial:Einstellungen',
	'mail-notification-body-HTML' => 'Hallo $WATCHER,

<p>$SUBJECT</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>--$AUTHOR_SIGNATURE</p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Siehe Diskussion</a></p>
<p>Das Wikia-Team</p>

___________________________________________<br />
 * Hilfe und Beratung im Community-Wiki finden: http://de.community.wikia.com
 * Weniger Nachrichten von uns erhalten? Abmelden oder Ändern der
 E-Mail-Einstellungen hier: http://de.community.wikia.com/Spezial:Einstellungen',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Gorizon
 * @author Mirzali
 */
$messages['diq'] = array(
	'mail-notification-html-greeting' => 'Merheba $1,',
);

/** Spanish (español)
 * @author AnakngAraw
 * @author Armando-Martin
 * @author Benfutbol10
 * @author Bola
 * @author Rubenwap
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'wn-user1-reply-you-your-wall' => '$1 respondió a tu mensaje en tu Muro',
	'wn-user2-reply-you-your-wall' => '$1 y $2 respondieron a tu mensaje en tu Muro',
	'wn-user3-reply-you-your-wall' => '$1 y otros respondieron a tu mensaje en tu Muro',
	'wn-user1-reply-self-your-wall' => '$1 respondió a un mensaje en tu Muro',
	'wn-user2-reply-self-your-wall' => '$1 y $2 respondieron a un mensaje en tu Muro',
	'wn-user3-reply-self-your-wall' => '$1 y otros respondieron a un mensaje en tu Muro',
	'wn-user1-reply-other-your-wall' => '$1 respondió al mensaje de $2 en tu Muro',
	'wn-user2-reply-other-your-wall' => '$1 y $2 respondieron al mensaje de $3 en tu Muro',
	'wn-user3-reply-other-your-wall' => '$1 y otros respondieron al mensaje de $2 en tu Muro',
	'wn-user1-reply-you-other-wall' => '$1 respondió a tu mensaje en el muro de $2',
	'wn-user2-reply-you-other-wall' => '$1 y $2 respondieron a tu mensaje en el muro de $3',
	'wn-user3-reply-you-other-wall' => '$1 y otros respondieron a tu mensaje en el muro de $3',
	'wn-user1-reply-self-other-wall' => '$1 respondió a un mensaje en el muro de $2',
	'wn-user2-reply-self-other-wall' => '$1 y $2 respondieron a un mensaje en el muro de $3',
	'wn-user3-reply-self-other-wall' => '$1 y otros respondieron a un mensaje en el muro de $2',
	'wn-user1-reply-other-other-wall' => '$1 respondió al mensaje de $2 en el muro de $3',
	'wn-user2-reply-other-other-wall' => '$1 y $2 respondieron al mensaje de $3 en el muro de $4',
	'wn-user3-reply-other-other-wall' => '$1 y otros respondieron al mensaje de $2 en el muro de $3',
	'wn-user1-reply-you-a-wall' => '$1 respondió a tu mensaje',
	'wn-user2-reply-you-a-wall' => '$1 y $2 respondieron a tu mensaje',
	'wn-user3-reply-you-a-wall' => '$1 y otros respondieron a tu mensaje',
	'wn-user1-reply-self-a-wall' => '$1 respondió a un mensaje',
	'wn-user2-reply-self-a-wall' => '$1 y $2 respondieron a un mensaje',
	'wn-user3-reply-self-a-wall' => '$1 y otros respondieron a un mensaje',
	'wn-user1-reply-other-a-wall' => '$1 respondió al mensaje de $2',
	'wn-user2-reply-other-a-wall' => '$1 y $2 respondieron al mensaje de $3',
	'wn-user3-reply-other-a-wall' => '$1 y otros respondieron al mensaje de $3',
	'wn-newmsg-onmywall' => '$1 dejó un mensaje nuevo en tu muro',
	'wn-newmsg' => 'Dejaste un mensaje nuevo en el muro de $1',
	'wn-newmsg-on-followed-wall' => '$1 dejó un mensaje nuevo en el muro de $2',
	'wn-admin-thread-deleted' => 'Tema retirado del muro de $1',
	'wn-admin-reply-deleted' => 'Respuesta retirada del tema en el muro de $1',
	'wn-owner-thread-deleted' => 'Tema retirado de tu muro',
	'wn-owner-reply-deleted' => 'Respuesta retirada del tema en tu muro',
	'mail-notification-new-someone' => '$AUTHOR_NAME escribió un mensaje nuevo en $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME te dejó un mensaje nuevo en $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME respondió a tu mensaje en $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME respondió a un mensaje en $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME respondió al mensaje de $PARENT_AUTHOR_NAME en $WIKI.',
	'mail-notification-html-greeting' => 'Hola $1,',
	'mail-notification-html-button' => 'Ver la conversación',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/es_wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia.es" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://es.wikia.com/wiki/Blog:Noticias_de_Wikia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Para comprobar las últimas novedades en Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a>',
	'mail-notification-html-footer-line2' => '¿Quieres controlar los correos electrónicos que recibes? Ve a tus <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferencias</a>',
	'mail-notification-body' => 'Hola $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Ver la conversación($MESSAGE_LINK)

El equipo de Wikia

___________________________________________
* Encuentra la ayuda y los consejos que necesitas en la Central de Wikia en español: http://es.wikia.com
* ¿Quieres recibir menos mensajes de nosotros? Puedes cambiar tus preferencias con respecto a los emails aquí: http://es.wikia.com/wiki/Especial:Preferencias',
	'mail-notification-body-HTML' => 'Hola $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Ver la conversación</a></p>
			<p>El equipo de Wikia</p>
___________________________________________<br />
* Encuentra la ayuda y los consejos que necesitas en la Central de Wikia en español: http://es.wikia.com
* ¿Quieres recibir menos mensajes de nosotros? Puedes cambiar tus preferencias con respecto a los emails aquí: http://es.wikia.com/wiki/Especial:Preferencias',
);

/** Finnish (suomi)
 * @author Ilkea
 * @author Lukkipoika
 * @author Nike
 * @author Silvonen
 */
$messages['fi'] = array(
	'wn-user1-reply-you-your-wall' => '$1 vastasi viestiisi seinälläsi',
	'wn-user2-reply-you-your-wall' => '$1 ja $2 vastasivat viestiisi seinälläsi',
	'wn-user3-reply-you-your-wall' => '$1 ja muut vastasivat viestiisi seinälläsi',
	'wn-user1-reply-self-your-wall' => '$1 vastasi viestiin seinälläsi',
	'wn-user2-reply-self-your-wall' => '$1 ja $2 vastasivat viestiin seinälläsi',
	'wn-user3-reply-self-your-wall' => '$1 ja muut vastasivat viestiin seinälläsi',
	'wn-user1-reply-other-your-wall' => '$1 vastasi $2:n viestiin seinälläsi',
	'wn-user2-reply-other-your-wall' => '$1 ja $2 vastasivat $3:n viestiin seinälläsi',
	'wn-user3-reply-other-your-wall' => '$1 ja muut vastasivat $2:n viestiin seinälläsi',
	'wn-user1-reply-you-other-wall' => '$1 vastasi viestiisi $2:n seinällä',
	'wn-user2-reply-you-other-wall' => '$1 ja $2 vastasivat viestiisi $3:n seinällä',
	'wn-user3-reply-you-other-wall' => '$1 ja muut vastasivat viestiisi $3:n seinällä',
	'wn-user1-reply-self-other-wall' => '$1 vastasi viestiin $2:n seinällä',
	'wn-user2-reply-self-other-wall' => '$1 ja $2 vastasivat viestiin $3:n seinällä',
	'wn-user3-reply-self-other-wall' => '$1 ja muut vastasivat viestiin $2:n seinällä',
	'wn-user1-reply-other-other-wall' => '$1 vastasi $2:n viestiin $3:n seinällä',
	'wn-user2-reply-other-other-wall' => '$1 ja $2 vastasivat $3:n viestiin $4:n seinällä',
	'wn-user3-reply-other-other-wall' => '$1 ja muut vastasivat $2:n viestiin $3:n seinällä',
	'wn-user1-reply-you-a-wall' => '$1 vastasi viestiisi',
	'wn-user2-reply-you-a-wall' => '$1 ja $2 vastasivat viestiisi',
	'wn-user3-reply-you-a-wall' => '$1 ja muut vastasivat viestiisi',
	'wn-user1-reply-self-a-wall' => '$1 vastasi viestiin',
	'wn-user2-reply-self-a-wall' => '$1 ja $2 vastasivat viestiin',
	'wn-user3-reply-self-a-wall' => '$1 ja muut vastasivat viestiin',
	'wn-user1-reply-other-a-wall' => '$1 vastasi $2:n viestiin',
	'wn-user2-reply-other-a-wall' => '$1 ja $2 vastasivat $3:n viestiin',
	'wn-user3-reply-other-a-wall' => '$1 ja muut vastasivat $3:n viestiin',
	'wn-newmsg-onmywall' => '$1 jätti uuden viestin seinällesi',
	'wn-newmsg' => 'Jätit uuden viestin $1:n seinälle',
	'wn-newmsg-on-followed-wall' => '$1 jätti uuden viestin $2:n seinälle.', # Fuzzy
	'wn-admin-thread-deleted' => 'Keskustelu poistettu $1:n seinältä',
	'wn-admin-reply-deleted' => 'Vastaus poistettu keskustelusta $1:n seinältä',
	'wn-owner-thread-deleted' => 'Keskustelu poistettu seinältäsi',
	'wn-owner-reply-deleted' => 'Vastaus poistettu keskustelusta seinältäsi',
);

/** French (français)
 * @author Gomoko
 * @author McDutchie
 * @author Wyz
 */
$messages['fr'] = array(
	'wn-user1-reply-you-your-wall' => '$1 a répondu à votre message sur votre mur',
	'wn-user2-reply-you-your-wall' => '$1 et $2 ont répondu à votre message sur votre mur',
	'wn-user3-reply-you-your-wall' => '$1, entre autres, a répondu à votre message sur votre mur',
	'wn-user1-reply-self-your-wall' => '$1 a répondu à un message sur votre mur',
	'wn-user2-reply-self-your-wall' => '$1 et $2 ont répondu à un message sur votre mur',
	'wn-user3-reply-self-your-wall' => '$1, entre autres, a répondu à un message sur votre mur',
	'wn-user1-reply-other-your-wall' => '$1 a répondu au message de $2 sur votre mur',
	'wn-user2-reply-other-your-wall' => '$1 et $2 ont répondu au message de $3 sur votre mur',
	'wn-user3-reply-other-your-wall' => '$1, entre autres, a répondu au message de $2 sur votre mur',
	'wn-user1-reply-you-other-wall' => '$1 a répondu à votre message sur le mur de $2',
	'wn-user2-reply-you-other-wall' => '$1 et $2 ont répondu à votre message sur le mur de $3',
	'wn-user3-reply-you-other-wall' => '$1, entre autres, a répondu à votre message sur le mur de $3',
	'wn-user1-reply-self-other-wall' => '$1 a répondu à un message sur le mur de $2',
	'wn-user2-reply-self-other-wall' => '$1 et $2 ont répondu à un message sur le mur de $3',
	'wn-user3-reply-self-other-wall' => '$1, entre autres, a répondu à un message sur le mur de $2',
	'wn-user1-reply-other-other-wall' => '$1 a répondu au message de $2 sur le mur de $3',
	'wn-user2-reply-other-other-wall' => '$1 et $2 ont répondu au message de $3 sur le mur de $4',
	'wn-user3-reply-other-other-wall' => '$1, entre autres, a répondu au message de $2 sur le mur de $3',
	'wn-user1-reply-you-a-wall' => '$1 a répondu à votre message',
	'wn-user2-reply-you-a-wall' => '$1 et $2 ont répondu à votre message',
	'wn-user3-reply-you-a-wall' => '$1, entre autres, a répondu à votre message',
	'wn-user1-reply-self-a-wall' => '$1 a répondu à un message',
	'wn-user2-reply-self-a-wall' => '$1 et $2 ont répondu à un message',
	'wn-user3-reply-self-a-wall' => '$1, entre autres, a répondu à un message',
	'wn-user1-reply-other-a-wall' => '$1 a répondu au message de $2',
	'wn-user2-reply-other-a-wall' => '$1 et $2 ont répondu au message de $3',
	'wn-user3-reply-other-a-wall' => '$1, entre autres, a répondu au message de $3',
	'wn-newmsg-onmywall' => '$1 a laissé un nouveau message sur votre mur',
	'wn-newmsg' => 'Vous avez laissé un nouveau message sur le mur de $1',
	'wn-newmsg-on-followed-wall' => '$1 a laissé un nouveau message sur le mur de $2',
	'wn-admin-thread-deleted' => 'Fil retiré du mur de $1',
	'wn-admin-reply-deleted' => 'Réponse retirée du fil sur le mur de $1',
	'wn-owner-thread-deleted' => 'Fil retiré de votre mur',
	'wn-owner-reply-deleted' => 'Réponse retirée du fil sur votre mur',
	'mail-notification-new-someone' => '$AUTHOR_NAME a écrit un nouveau message sur $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME vous a laissé un nouveau message sur $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME a répondu à votre message sur $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME a répondu à un message sur $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME a répondu au message de $PARENT_AUTHOR_NAME sur $WIKI.',
	'mail-notification-html-greeting' => 'Bonjour $1,',
	'mail-notification-html-button' => 'Voir la conversation',
	'mail-notification-subject' => '$1 — $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia_fr" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
<a href="http://www.facebook.com/wikia.fr" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
<a href="http://communaute.wikia.com/wiki/Blog:Actualit%C3%A9_Wikia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Pour connaître les derniers évènements sur Wikia, visitez <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vous souhaitez contrôler les courriels que vous recevez ? Allez à vos <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Préférences</a>',
	'mail-notification-body' => 'Bonjour $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

— $AUTHOR

voir la conversation($MESSAGE_LINK)

L’équipe Wikia

___________________________________________
* Trouvez de l’aide et des conseils sur le wiki des communautés : http://communaute.wikia.com
* Vous souhaitez recevoir moins de messages de notre part ? Vous pouvez vous désinscrire ou modifier
vos préférence de courriel ici : http://communaute.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Bonjour $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>— $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Voir la conversation</a></p>
<p>L’équipe Wikia</p>
___________________________________________<br />
* Trouvez de l’aide et des conseils sur le wiki des communautés : http://communaute.wikia.com
* Vous souhaitez recevoir moins de messages de notre part ? Vous pouvez vous désinscrire ou
modifier vos préférence de courriel ici : http://communaute.wikia.com/Special:Preferences',
);

/** Galician (galego)
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'wn-user1-reply-you-your-wall' => '$1 respondeu á súa mensaxe no seu muro',
	'wn-user2-reply-you-your-wall' => '$1 e $2 responderon á súa mensaxe no seu muro',
	'wn-user3-reply-you-your-wall' => '$1 e outros responderon á súa mensaxe no seu muro',
	'wn-user1-reply-self-your-wall' => '$1 respondeu a unha mensaxe no seu muro',
	'wn-user2-reply-self-your-wall' => '$1 e $2 responderon a unha mensaxe no seu muro',
	'wn-user3-reply-self-your-wall' => '$1 e outros responderon a unha mensaxe no seu muro',
	'wn-user1-reply-other-your-wall' => '$1 respondeu á mensaxe de $2 no seu muro',
	'wn-user2-reply-other-your-wall' => '$1 e $2 responderon á mensaxe de $3 no seu muro',
	'wn-user3-reply-other-your-wall' => '$1 e outros responderon á mensaxe de $2 no seu muro',
	'wn-user1-reply-you-other-wall' => '$1 respondeu á súa mensaxe no muro de $2',
	'wn-user2-reply-you-other-wall' => '$1 e $2 responderon á súa mensaxe no muro de $3',
	'wn-user3-reply-you-other-wall' => '$1 e outros responderon á súa mensaxe no muro de $3',
	'wn-user1-reply-self-other-wall' => '$1 respondeu a unha mensaxe no muro de $2',
	'wn-user2-reply-self-other-wall' => '$1 e $2 responderon a unha mensaxe no muro de $3',
	'wn-user3-reply-self-other-wall' => '$1 e outros responderon a unha mensaxe no muro de $2',
	'wn-user1-reply-other-other-wall' => '$1 respondeu á mensaxe de $2 no muro de $3',
	'wn-user2-reply-other-other-wall' => '$1 e $2 responderon á mensaxe de $3 no muro de $4',
	'wn-user3-reply-other-other-wall' => '$1 e outros responderon á mensaxe de $2 no muro de $3',
	'wn-user1-reply-you-a-wall' => '$1 respondeu á súa mensaxe',
	'wn-user2-reply-you-a-wall' => '$1 e $2 responderon á súa mensaxe',
	'wn-user3-reply-you-a-wall' => '$1 e outros responderon á súa mensaxe',
	'wn-user1-reply-self-a-wall' => '$1 respondeu a unha mensaxe',
	'wn-user2-reply-self-a-wall' => '$1 e $2 responderon a unha mensaxe',
	'wn-user3-reply-self-a-wall' => '$1 e outros responderon a unha mensaxe',
	'wn-user1-reply-other-a-wall' => '$1 respondeu á mensaxe de $2',
	'wn-user2-reply-other-a-wall' => '$1 e $2 responderon á mensaxe de $3',
	'wn-user3-reply-other-a-wall' => '$1 e outros responderon á mensaxe de $3',
	'wn-newmsg-onmywall' => '$1 deixou unha nova mensaxe no seu muro',
	'wn-newmsg' => 'Vostede deixou unha nova mensaxe no muro de $1',
	'wn-newmsg-on-followed-wall' => '$1 deixou unha nova mensaxe no muro de $2',
	'wn-admin-thread-deleted' => 'Fío eliminado no muro de $1',
	'wn-admin-reply-deleted' => 'Resposta eliminada do fío no muro de $1',
	'wn-owner-thread-deleted' => 'Fío eliminado no seu muro',
	'wn-owner-reply-deleted' => 'Resposta eliminada do fío no seu muro',
	'mail-notification-new-someone' => '$AUTHOR_NAME escribiu unha nova mensaxe en $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME deixoulle unha nova mensaxe en $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME respondeu á súa mensaxe en $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME respondeu a unha mensaxe en $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME respondeu á mensaxe de $PARENT_AUTHOR_NAME en $WIKI.',
	'mail-notification-html-greeting' => 'Boas, $1:',
	'mail-notification-html-button' => 'Ollar a conversa',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Para botar unha ollada aos últimos acontecementos en Wikia, visite <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Quere controlar os correos electrónicos que recibe? Vaia ás súas <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferencias</a>',
	'mail-notification-body' => 'Boas $WATCHER:

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Ollar a conversa($MESSAGE_LINK)

O equipo de Wikia

___________________________________________
* Atope axuda e consellos na central da comunidade: http://community.wikia.com
* Quere recibir menos mensaxes nosas? Pode cancelar a subscrición ou cambiar
as preferencias de correo electrónico aquí: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Boas $WATCHER:
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
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'wn-user1-reply-you-your-wall' => '$1 válaszolt az üzenetedre az üzenőfaladon',
	'wn-user2-reply-you-your-wall' => '$1 és $2 válaszolt az üzenetedre az üzenőfaladon',
	'wn-user3-reply-you-your-wall' => '$1 és mások válaszoltak az üzenetedre az üzenőfaladon',
	'wn-user1-reply-self-your-wall' => '$1 válaszolt egy üzenetre az üzenőfaladon',
	'wn-user2-reply-self-your-wall' => '$1 és $2 válaszolt egy üzenetre az üzenőfaladon',
	'wn-user3-reply-self-your-wall' => '$1 és mások válaszoltak egy üzenetre az üzenőfaladon',
	'wn-user1-reply-other-your-wall' => '$1 válaszolt $2 üzenetére az üzenőfaladon',
	'wn-user2-reply-other-your-wall' => '$1 és $2 válaszolt $3 üzenetére az üzenőfaladon',
	'wn-user3-reply-other-your-wall' => '$1 és mások válaszoltak $2 üzenetére az üzenőfaladon',
	'wn-user1-reply-you-other-wall' => '$1 válaszolt az üzenetedre $2 üzenőfalán',
	'wn-user2-reply-you-other-wall' => '$1 és $2 válaszolt az üzenetedre $3 üzenőfalán',
	'wn-user3-reply-you-other-wall' => '$1 és mások válaszoltak az üzenetedre $3 üzenőfalán',
	'wn-user1-reply-self-other-wall' => '$1 válaszolt egy üzenetre $2 üzenőfalán',
	'wn-user2-reply-self-other-wall' => '$1 és $2 válaszolt egy üzenetre $3 üzenőfalán',
	'wn-user3-reply-self-other-wall' => '$1 és mások válaszoltak egy üzenetre $2 üzenőfalán',
	'wn-user1-reply-other-other-wall' => '$1 válaszolt $2 üzenetére $3 üzenőfalán',
	'wn-user2-reply-other-other-wall' => '$1 és $2 válaszolt $3 üzenetére $4 üzenőfalán',
	'wn-user3-reply-other-other-wall' => '$1 és mások válaszoltak $2 üzenetére $3 üzenőfalán',
	'wn-user1-reply-you-a-wall' => '$1 válaszolt az üzenetedre',
	'wn-user2-reply-you-a-wall' => '$1 és $2 válaszolt az üzenetedre',
	'wn-user3-reply-you-a-wall' => '$1 és mások válaszoltak az üzenetedre',
	'wn-user1-reply-self-a-wall' => '$1 válaszolt egy üzenetre',
	'wn-user2-reply-self-a-wall' => '$1 és $2 válaszolt egy üzenetre',
	'wn-user3-reply-self-a-wall' => '$1 és mások válaszoltak egy üzenetre',
	'wn-user1-reply-other-a-wall' => '$1 válaszolt $2 üzenetére',
	'wn-user2-reply-other-a-wall' => '$1 és $2 válaszolt $3 üzenetére',
	'wn-user3-reply-other-a-wall' => '$1 és mások válaszoltak $3 üzenetére',
	'wn-newmsg-onmywall' => '$1 új üzenetet hagyott az üzenőfaladon',
	'wn-newmsg' => 'Új üzenetet hagytál $1 üzenőfalán',
	'wn-newmsg-on-followed-wall' => '$1 új üzenetet hagyott $2 üzenőfalán',
	'wn-admin-thread-deleted' => 'Beszélgetésfolyam eltávolítása $1 üzenőfaláról',
	'wn-admin-reply-deleted' => 'Egy választ eltávolítottak egy beszélgetésfolyamból $1 üzenőfalán',
	'wn-owner-thread-deleted' => 'Egy beszélgetésfolyamot eltávolítottak az üzenőfaladról',
	'wn-owner-reply-deleted' => 'Egy választ eltávolítottak egy beszélgetésfolyamból az üzenőfaladon',
	'mail-notification-new-someone' => '$AUTHOR_NAME új üzenetet írt a(z) $WIKI wikin.',
	'mail-notification-new-your' => '$AUTHOR_NAME új üzenetet hagyott neked a(z) $WIKI wikin.',
	'mail-notification-reply-your' => '$AUTHOR_NAME válaszolt az üzenetedre a(z) $WIKI wikin.',
	'mail-notification-reply-his' => '$AUTHOR_NAME válaszolt egy üzenetre a(z) $WIKI wikin.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME válaszolt $PARENT_AUTHOR_NAME üzenetére a(z) $WIKI wikin.',
	'mail-notification-html-greeting' => 'Szia, $1!',
	'mail-notification-html-button' => 'Tekintsd meg a beszélgetést!',
	'mail-notification-html-footer-line1' => 'A Wikia legfrissebb eseményeinek megtekintéséhez látogass el a <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> oldalra.',
	'mail-notification-html-footer-line2' => 'Szeretnéd módosítani a kapott e-mailekre vonatkozó beállításaidat? Változtass a <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">beállításaidon</a>',
	'mail-notification-body' => 'Szia, $WATCHER!

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Tekintsd meg a beszélgetést!($MESSAGE_LINK)

A Wikia csapat

___________________________________________
* Segítséget és tanácsot a Community Central wikin találsz: http://community.wikia.com
* Kevesebb üzenetet szeretnél tőlünk? Itt leiratkozhatsz vagy megváltoztathatod az e-mailekre vonatkozó beállításaidat: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hi $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Tekintsd meg a beszélgetést!</a></p>
			<p>A Wikia csapat</p>
___________________________________________<br />
* Segítséget és tanácsot a Community Central wikin találsz: http://community.wikia.com
* Kevesebb üzenetet szeretnél tőlünk? Itt leiratkozhatsz, vagy megváltoztathatod az e-mailekre vonatkozó beállításaidat: http://community.wikia.com/Special:Preferences',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wn-user1-reply-you-your-wall' => '$1 respondeva a tu message sur tu muro',
	'wn-user2-reply-you-your-wall' => '$1 e $2 respondeva a tu message sur tu muro',
	'wn-user3-reply-you-your-wall' => '$1 e alteres respondeva a tu message sur tu muro',
	'wn-user1-reply-self-your-wall' => '$1 respondeva a un message sur tu muro',
	'wn-user2-reply-self-your-wall' => '$1 e $2 respondeva a un message sur tu muro',
	'wn-user3-reply-self-your-wall' => '$1 e alteres respondeva a un message sur tu muro',
	'wn-user1-reply-other-your-wall' => '$1 respondeva al message de $2 sur tu muro',
	'wn-user2-reply-other-your-wall' => '$1 e $2 respondeva al message de $3 sur tu muro',
	'wn-user3-reply-other-your-wall' => '$1 e alteres respondeva al message de $2 sur tu muro',
	'wn-user1-reply-you-other-wall' => '$1 respondeva a tu message sur le muro de $2',
	'wn-user2-reply-you-other-wall' => '$1 e $2 respondeva a tu message sur le muro de $3',
	'wn-user3-reply-you-other-wall' => '$1 e alteres respondeva a tu message sur le muro de $3',
	'wn-user1-reply-self-other-wall' => '$1 respondeva a un message sur le muro de $2',
	'wn-user2-reply-self-other-wall' => '$1 e $2 respondeva a un message sur le muro de $3',
	'wn-user3-reply-self-other-wall' => '$1 e alteres respondeva a un message sur le muro de $2',
	'wn-user1-reply-other-other-wall' => '$1 respondeva al message de $2 sur le muro de $3',
	'wn-user2-reply-other-other-wall' => '$1 e $2 respondeva al message de $3 sur le muro de $4',
	'wn-user3-reply-other-other-wall' => '$1 e alteres respondeva al message de $2 sur le muro de $3',
	'wn-user1-reply-you-a-wall' => '$1 respondeva a tu message',
	'wn-user2-reply-you-a-wall' => '$1 e $2 respondeva a tu message',
	'wn-user3-reply-you-a-wall' => '$1 e alteres respondeva a tu message',
	'wn-user1-reply-self-a-wall' => '$1 respondeva a un message',
	'wn-user2-reply-self-a-wall' => '$1 e $2 respondeva a un message',
	'wn-user3-reply-self-a-wall' => '$1 e alteres respondeva a un message',
	'wn-user1-reply-other-a-wall' => '$1 respondeva al message de $2',
	'wn-user2-reply-other-a-wall' => '$1 e $2 respondeva al message de $3',
	'wn-user3-reply-other-a-wall' => '$1 e alteres respondeva al message de $3',
	'wn-newmsg-onmywall' => '$1 lassava un nove message sur tu muro',
	'wn-newmsg' => 'Tu lassava un nove message sur le muro de $1',
	'wn-newmsg-on-followed-wall' => '$1 lassava un nove message sur le muro de $2',
	'wn-admin-thread-deleted' => 'Discussion removite del muro de $1',
	'wn-admin-reply-deleted' => 'Responsa removite de un discussion sur le muro de $1',
	'wn-owner-thread-deleted' => 'Discussion removite de tu muro',
	'wn-owner-reply-deleted' => 'Responsa removite de un discussion sur tu muro',
	'mail-notification-new-someone' => '$AUTHOR_NAME scribeva un nove message in $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME te lassava un nove message in $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME respondeva a tu message in $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME respondeva a un message in $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME respondeva al message de $PARENT_AUTHOR_NAME in $WIKI.',
	'mail-notification-html-greeting' => 'Salute $1,',
	'mail-notification-html-button' => 'Vider le conversation',
	'mail-notification-html-footer-line1' => 'Pro cognoscer le ultime evenimentos in Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vole seliger le e-mails que tu recipe? Face lo in tu <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferentias</a>',
	'mail-notification-body' => 'Salute $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Vide le conversation($MESSAGE_LINK)

Le equipa de Wikia

___________________________________________
* Adjuta e consilios in le Centro del Communitate: http://community.wikia.com
* Vole reciper minus messages de nos? Tu pote disabonar te o cambiar le
tue preferentias de e-mail: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Salute $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Vide le conversation</a></p>
			<p>Le equipa de Wikia</p>
___________________________________________<br />
* Adjuta e consilios in le Centro del Communitate: http://community.wikia.com
* Vole reciper minus messages de nos? Tu pote disabonar te o cambiar le
tue preferentias de e-mail: http://community.wikia.com/Special:Preferences',
);

/** Japanese (日本語)
 * @author Shirayuki
 * @author Tommy6
 * @author Whym
 */
$messages['ja'] = array(
	'wn-user1-reply-you-your-wall' => '$1 があなたのウォールのあなたのメッセージに返信しました',
	'wn-user2-reply-you-your-wall' => '$1 と $2 があなたのウォールのあなたのメッセージに返信しました',
	'wn-user3-reply-you-your-wall' => '$1 とその他複数があなたのウォールのあなたのメッセージに返信しました',
	'wn-user1-reply-self-your-wall' => '$1 があなたのウォールのメッセージに返信しました',
	'wn-user2-reply-self-your-wall' => '$1 と $2 があなたのウォールのメッセージに返信しました',
	'wn-user3-reply-self-your-wall' => '$1 とその他複数があなたのウォールのメッセージに返信しました',
	'wn-user1-reply-other-your-wall' => '$1 があなたのウォールの $2 からのメッセージに返信しました',
	'wn-user2-reply-other-your-wall' => '$1 と $2 があなたのウォールの $3 からのメッセージに返信しました',
	'wn-user3-reply-other-your-wall' => '$1 とその他複数があなたのウォールの $2 からのメッセージに返信しました',
	'wn-user1-reply-you-other-wall' => '$1 が $2 のウォールのあなたのメッセージに返信しました',
	'wn-user2-reply-you-other-wall' => '$1 と $2 が $3 のウォールのあなたのメッセージに返信しました',
	'wn-user3-reply-you-other-wall' => '$1 とその他複数が $3 のウォールのあなたのメッセージに返信しました',
	'wn-user1-reply-self-other-wall' => '$1 が $2 のウォールのメッセージに返信しました',
	'wn-user2-reply-self-other-wall' => '$1 と $2 が $3 のウォールのメッセージに返信しました',
	'wn-user3-reply-self-other-wall' => '$1 とその他複数が $2 のウォールのメッセージに返信しました',
	'wn-user1-reply-other-other-wall' => '$1 が $3 のウォールの $2 からのメッセージに返信しました',
	'wn-user2-reply-other-other-wall' => '$1 と $2 が $4 のウォールの $3 からのメッセージに返信しました',
	'wn-user3-reply-other-other-wall' => '$1 とその他複数が $3 のウォールの $2 からのメッセージに返信しました',
	'wn-user1-reply-you-a-wall' => '$1 があなたのメッセージに返信しました',
	'wn-user2-reply-you-a-wall' => '$1 と $2 があなたのメッセージに返信しました',
	'wn-user3-reply-you-a-wall' => '$1 とその他複数があなたのメッセージに返信しました',
	'wn-user1-reply-self-a-wall' => '$1 がメッセージに返信しました',
	'wn-user2-reply-self-a-wall' => '$1 と $2 がメッセージに返信しました',
	'wn-user3-reply-self-a-wall' => '$1 とその他複数がメッセージに返信しました',
	'wn-user1-reply-other-a-wall' => '$1 が $2 からのメッセージに返信しました',
	'wn-user2-reply-other-a-wall' => '$1 と $2 が $3 からのメッセージに返信しました',
	'wn-user3-reply-other-a-wall' => '$1 とその他複数が $3 からのメッセージに返信しました',
	'wn-newmsg-onmywall' => '$1 があなたのウォールに新しいメッセージを投稿しました',
	'wn-newmsg' => 'あなたが $1 のウォールに新しいメッセージを投稿しました',
	'wn-newmsg-on-followed-wall' => '$1 が $2 のウォールに新しいメッセージを投稿しました',
	'wn-admin-thread-deleted' => '$1 のウォールからスレッドが削除されました',
	'wn-admin-reply-deleted' => '$1 のウォールのスレッドから返信が削除されました',
	'wn-owner-thread-deleted' => 'あなたのウォールからスレッドが削除されました',
	'wn-owner-reply-deleted' => 'あなたのウォールのスレッドから返信が削除されました',
	'mail-notification-new-someone' => '$AUTHOR_NAME が $WIKI で新しいメッセージを投稿しました。',
	'mail-notification-new-your' => '$AUTHOR_NAME が $WIKI であなたに新しいメッセージを投稿しました。',
	'mail-notification-reply-your' => '$AUTHOR_NAME が $WIKI であなたのメッセージに返信しました。',
	'mail-notification-reply-his' => '$AUTHOR_NAME が $WIKI でメッセージに返信しました。',
	'mail-notification-reply-someone' => '$AUTHOR_NAME が $WIKI で $PARENT_AUTHOR_NAME からのメッセージに返信しました。',
	'mail-notification-html-greeting' => '$1 さん、',
	'mail-notification-html-button' => 'スレッドを見る',
	'mail-notification-html-footer-line1' => 'ウィキアの最新情報は <a style="color:#2a87d5;text-decoration:none;" href="http://ja.wikia.com/">ja.wikia.com</a> で確認できます。',
	'mail-notification-html-footer-line2' => 'メール通知に関する設定は<a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">個人設定</a>のページで行えます。',
	'mail-notification-body' => '$WATCHERさん、

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

スレッドを見るにはこちら ($MESSAGE_LINK)

ウィキアチーム

___________________________________________
* ヘルプが必要ですか？: http://ja.wikia.com/
* メール通知に関する設定はこちら: http://ja.wikia.com/wiki/Special:Preferences',
	'mail-notification-body-HTML' => '$WATCHERさん、<br />
<p>$SUBJECT</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">スレッドを見るにはこちら</a></p>
<p>ウィキアチーム</p>
___________________________________________<br />
<p>* フォローの設定を変更する:<br />
http://ja.wikia.com/wiki/Special:Following</p>',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wn-user1-reply-you-your-wall' => '$1 ви одговори на пораката на вашиот ѕид',
	'wn-user2-reply-you-your-wall' => '$1 и $2 ви одговорија на пораката на вашиот ѕид',
	'wn-user3-reply-you-your-wall' => '$1 и други ви одговорија на пораката на вашиот ѕид',
	'wn-user1-reply-self-your-wall' => '$1 одговори на порака на вашиот ѕид',
	'wn-user2-reply-self-your-wall' => '$1 и $2 одговорија на порака на вашиот ѕид',
	'wn-user3-reply-self-your-wall' => '$1 и други одговорија на порака на вашиот ѕид',
	'wn-user1-reply-other-your-wall' => '$1 одговори на пораката на $2 на вашиот ѕид',
	'wn-user2-reply-other-your-wall' => '$1 и $2 одговорија на пораката на $3 на вашиот ѕид',
	'wn-user3-reply-other-your-wall' => '$1 и други одговорија на пораката на $2 на вашиот ѕид',
	'wn-user1-reply-you-other-wall' => '$1 ви одговори на пораката на ѕидот на $2',
	'wn-user2-reply-you-other-wall' => '$1 и $2 ви одговорија на пораката на ѕидот на $3',
	'wn-user3-reply-you-other-wall' => '$1 и други ви одговорија на пораката на ѕидот на $3',
	'wn-user1-reply-self-other-wall' => '$1 одговори на порака на ѕидот на $2',
	'wn-user2-reply-self-other-wall' => '$1 и $2 одговорија на порака на ѕидот на $3',
	'wn-user3-reply-self-other-wall' => '$1 и други одговорија на порака на ѕидот на $2',
	'wn-user1-reply-other-other-wall' => '$1 одговори на пораката на $2 на ѕидот на $3',
	'wn-user2-reply-other-other-wall' => '$1 и $2 одговорија на пораката на $3 на ѕидот на $4',
	'wn-user3-reply-other-other-wall' => '$1 и други одговорија на пораката на $2 на ѕидот на $3',
	'wn-user1-reply-you-a-wall' => '$1 ви одговори на пораката',
	'wn-user2-reply-you-a-wall' => '$1 и $2 ви одговорија на пораката',
	'wn-user3-reply-you-a-wall' => '$1 и други ви одговорија на пораката',
	'wn-user1-reply-self-a-wall' => '$1 одговори на порака',
	'wn-user2-reply-self-a-wall' => '$1 и $2 одговорија на порака',
	'wn-user3-reply-self-a-wall' => '$1 и други одговорија на порака',
	'wn-user1-reply-other-a-wall' => '$1 одговори на пораката на $2',
	'wn-user2-reply-other-a-wall' => '$1 и $2 одговорија на пораката на $3',
	'wn-user3-reply-other-a-wall' => '$1 и други одговорија на пораката на $3',
	'wn-newmsg-onmywall' => '$1 ви остави порака на вашиот ѕид',
	'wn-newmsg' => 'Оставивте порака на ѕидот на $1',
	'wn-newmsg-on-followed-wall' => '$1 остави нова порака на ѕидот на $2',
	'wn-admin-thread-deleted' => 'Нишката е отстранета од ѕидот на $1',
	'wn-admin-reply-deleted' => 'Одговорот е отстранет од нишката на ѕидот на $1',
	'wn-owner-thread-deleted' => 'Нишката е отстранета од вашиот ѕид',
	'wn-owner-reply-deleted' => 'Одговорот е отстранет од нишка на вашиот ѕид',
	'mail-notification-new-someone' => '$AUTHOR_NAME напиша нова порака на $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME ви остави порака на $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME одговори на вашата порака на $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME одговори на порака на $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME одговори на пораката на $PARENT_AUTHOR_NAME на $WIKI.',
	'mail-notification-html-greeting' => 'Здраво $1,',
	'mail-notification-html-button' => 'Погледајте го разговорот',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'За да ги проследите најновите случувања на Викија, посетете ја страницата <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Сакате да одберете кои пораки да ги добивате? Појдете на вашите <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Нагодувања</a>',
	'mail-notification-body' => 'Hi $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Погледајте го разговорот($MESSAGE_LINK)

Екипата на Викија

___________________________________________
* Помош и совети ќе добиете на Центарот на заедницата: http://community.wikia.com
* Сакате да добивате помалку пораки од нас? Можете да се отпишете или да ги смените
нагодувањата за е-пошта на: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Здраво $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Погледајте го разговорот</a></p>
			<p>Екипата на Викија</p>
___________________________________________<br />
* Помош и совети ќе добиете на Центарот на заедницата: http://community.wikia.com
* Сакате да добивате помалку пораки од нас? Можете да се отпишете или да ги смените
нагодувањата за е-пошта на: http://community.wikia.com/Special:Preferences',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wn-user1-reply-you-your-wall' => '$1 membalas pesanan anda di papan anda',
	'wn-user2-reply-you-your-wall' => '$1 dan $2 membalas pesanan anda di papan anda',
	'wn-user3-reply-you-your-wall' => '$1 dan lain-lain membalas pesanan anda di papan anda',
	'wn-user1-reply-self-your-wall' => '$1 membalas pesanan di papan anda',
	'wn-user2-reply-self-your-wall' => '$1 dan $2 membalas pesanan di papan anda',
	'wn-user3-reply-self-your-wall' => '$1 dan lain-lain membalas pesanan di papan anda',
	'wn-user1-reply-other-your-wall' => '$1 membalas pesanan $2 di papan anda',
	'wn-user2-reply-other-your-wall' => '$1 dan $2 membalas pesanan $3 di papan anda',
	'wn-user3-reply-other-your-wall' => '$1 dan lain-lain membalas pesanan $2 di papan anda',
	'wn-user1-reply-you-other-wall' => '$1 membalas pesanan anda di papan $2',
	'wn-user2-reply-you-other-wall' => '$1 dan $2 membalas pesanan anda di papan $3',
	'wn-user3-reply-you-other-wall' => '$1 dan lain-lain membalas pesanan anda di papan $3',
	'wn-user1-reply-self-other-wall' => '$1 membalas pesanan di papan $2',
	'wn-user2-reply-self-other-wall' => '$1 dan $2 membalas pesanan di papan $3',
	'wn-user3-reply-self-other-wall' => '$1 dan lain-lain membalas pesanan di papan $2',
	'wn-user1-reply-other-other-wall' => '$1 membalas pesanan $2 di papan $3',
	'wn-user2-reply-other-other-wall' => '$1 dan $2 membalas pesanan $3 di papan $4',
	'wn-user3-reply-other-other-wall' => '$1 dan lain-lain membalas pesanan $2 di papan $3',
	'wn-user1-reply-you-a-wall' => '$1 membalas pesanan anda',
	'wn-user2-reply-you-a-wall' => '$1 dan $2 membalas pesanan anda',
	'wn-user3-reply-you-a-wall' => '$1 dan lain-lain membalas pesanan anda',
	'wn-user1-reply-self-a-wall' => '$1 membalas suatu pesanan',
	'wn-user2-reply-self-a-wall' => '$1 dan $2 membalas suatu pesanan',
	'wn-user3-reply-self-a-wall' => '$1 dan lain-lain membalas suatu pesanan',
	'wn-user1-reply-other-a-wall' => '$1 membalas pesanan $2',
	'wn-user2-reply-other-a-wall' => '$1 dan $2 membalas pesanan $3',
	'wn-user3-reply-other-a-wall' => '$1 dan lain-lain membalas pesanan $3',
	'wn-newmsg-onmywall' => '$1 meninggalkan pesanan baru di papan anda',
	'wn-newmsg' => 'Anda meninggalkan pesanan baru di papan $1',
	'wn-newmsg-on-followed-wall' => '$1 meninggalkan pesanan baru di papan $2',
	'wn-admin-thread-deleted' => 'Tred dibuang dari papan $1',
	'wn-admin-reply-deleted' => 'Balasan dibuang dari tred di papan $1',
	'wn-owner-thread-deleted' => 'Tred dibuang dari papan anda',
	'wn-owner-reply-deleted' => 'Balasan dibuang dari tred di papan anda',
	'mail-notification-new-someone' => '$AUTHOR_NAME menulis pesanan baru di $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME meninggalkan pesanan baru kepada anda di $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME membalas pesanan anda di $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME membalas suatu pesanan di $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME membalas pesanan $PARENT_AUTHOR_NAME di $WIKI.',
	'mail-notification-html-greeting' => 'Apa khabar $1,',
	'mail-notification-html-button' => 'Lihat perbualan',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Untuk meninjau perkembangan terkini di Wikia, lawati <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Ingin mengawal e-mel yang anda terima? Pergi ke <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Keutamaan</a> anda',
	'mail-notification-body' => 'Apa khabar $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Lihat perbualan($MESSAGE_LINK)

Pasukan Wikia

___________________________________________
* Dapatkan bantuan dan nasihat di Community Central: http://community.wikia.com
* Tak nak terima banyak pesanan daripada kami? Anda boleh berhenti melanggan atau
ubah keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hi $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Lihat perbualan</a></p>
<p>Pasukan Wikia</p>
___________________________________________<br />
* Dapatkan bantuan dan nasihat di Community Central: http://community.wikia.com
* Tak nak terima banyak pesanan daripada kami? Anda boleh berhenti melanggan atau
ubah keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author EvenT
 * @author Wouterkoch
 */
$messages['nb'] = array(
	'wn-user1-reply-you-your-wall' => '$1 svarte på beskjeden din på beskjedtavlen din',
	'wn-user2-reply-you-your-wall' => '$1 og $2 svarte på beskjeden din på beskjedtavlen din',
	'wn-user3-reply-you-your-wall' => '$1 og andre svarte på beskjeden din på beskjedtavlen din',
	'wn-user1-reply-self-your-wall' => '$1 svarte på en beskjed på beskjedtavlen din',
	'wn-user2-reply-self-your-wall' => '$1 og $2 svarte på en beskjed på beskjedtavlen din',
	'wn-user3-reply-self-your-wall' => '$1 og andre svarte på en beskjed på beskjedtavlen din',
	'wn-user1-reply-other-your-wall' => '$1 svarte på $2 sin beskjed på beskjedtavlen din',
	'wn-user2-reply-other-your-wall' => '$1 og $2 svarte på $3 sin beskjed på beskjedtavlen din',
	'wn-user3-reply-other-your-wall' => '$1 og andre svarte på $2 sin beskjed på beskjedtavlen din',
	'wn-user1-reply-you-other-wall' => '$1 svarte på beskjeden din på $2 sin beskjedtavle',
	'wn-user2-reply-you-other-wall' => '$1 og $2 svarte på en beskjed på $3 sin beskjedtavle',
	'wn-user3-reply-you-other-wall' => '$1 og andre svarte på beskjeden din på $3 sin beskjedtavle',
	'wn-user1-reply-self-other-wall' => '$1 svarte på en beskjed på $2 sin beskjedtavle',
	'wn-user2-reply-self-other-wall' => '$1 og $2 svarte på en beskjed på $3 sin beskjedtavle',
	'wn-user3-reply-self-other-wall' => '$1 og andre svarte på en beskjed på $2 sin beskjedtavle',
	'wn-user1-reply-other-other-wall' => '$1 svarte på $2 sin beskjed på $3 sin beskjedtavle',
	'wn-user2-reply-other-other-wall' => '$1 og $2 svarte på $3 sin beskjed på $4 sin beskjedtavle',
	'wn-user3-reply-other-other-wall' => '$1 og andre svarte på $2 sin beskjed på $3 sin beskjedtavle',
	'wn-user1-reply-you-a-wall' => '$1 svarte på beskjeden din',
	'wn-user2-reply-you-a-wall' => '$1 og $2 svarte på beskjeden din',
	'wn-user3-reply-you-a-wall' => '$1 og andre svarte på beskjeden din',
	'wn-user1-reply-self-a-wall' => '$1 svarte på en beskjed',
	'wn-user2-reply-self-a-wall' => '$1 og $2 svarte på en beskjed',
	'wn-user3-reply-self-a-wall' => '$1 og andre svarte på en beskjed',
	'wn-user1-reply-other-a-wall' => '$1 svarte på $2 sin beskjed',
	'wn-user2-reply-other-a-wall' => '$1 og $2 svarte på $3 sin beskjed',
	'wn-user3-reply-other-a-wall' => '$1 og andre svarte på $3 sin beskjed',
	'wn-newmsg-onmywall' => '$1 la igjen en beskjed på tavlen din',
	'wn-newmsg' => 'Du la igjen en beskjed på $1 sin beskjedtavle',
	'wn-newmsg-on-followed-wall' => '$1 la igjen en ny beskjed på $2 sin beskjedtavle',
	'wn-admin-thread-deleted' => 'Tråd fjernet fra $1 sin beskjedtavle',
	'wn-admin-reply-deleted' => 'Svaret fjernet fra tråden på $1 sin beskjedtavle',
	'wn-owner-thread-deleted' => 'Tråd fjernet fra beskjedtavlen din',
	'wn-owner-reply-deleted' => 'Svar fjernet fra tråden på beskjedtavlen din',
	'mail-notification-new-someone' => '$AUTHOR_NAME skrev en ny beskjed på $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME la igjen en ny beskjed til deg på $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME svarte på beskjeden din på $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME svarte på en beskjed på $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME svarte på $PARENT_AUTHOR_NAME sin beskjed på $WIKI.',
	'mail-notification-html-greeting' => 'Hei $1,',
	'mail-notification-html-button' => 'Se samtalen',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line1' => 'For å sjekke ut de siste hendelsene på Wikia, besøk <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vil du kontrollere hvilke e-post du mottar? Gå til <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">innstillingene dine</a>',
	'mail-notification-body' => 'Hei $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Se samtalen($MESSAGE_LINK)

Wikia-teamet

___________________________________________
* Finn hjelp og råd på Fellesskapssentralen: http://community.wikia.com
* Vil du motta færre meldinger fra oss? Du kan avslutte abonnementet eller
endre e-post-innstillingene dine her: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hei $WATCHER,
 <p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Se samtalen</a></p>
<p>Wikia-teamet</p>
___________________________________________<br />
* Finn hjelp og råd på Fellesskapssentralen: http://community.wikia.com
* Vil du motta færre meldinger fra oss? Du kan avslutte abonnementet eller
endre e-post-innstillingene dine her: http://community.wikia.com/Special:Preferences',
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author Flightmare
 * @author Randykitty
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 * @author Wiki13
 */
$messages['nl'] = array(
	'wn-user1-reply-you-your-wall' => '$1 heeft geantwoord op uw bericht op uw prikbord',
	'wn-user2-reply-you-your-wall' => '$1 en $2 hebben geantwoord op uw bericht op uw prikbord',
	'wn-user3-reply-you-your-wall' => '$1 en anderen hebben geantwoord op uw bericht op uw prikbord',
	'wn-user1-reply-self-your-wall' => '$1 heeft geantwoord op een bericht op uw prikbord',
	'wn-user2-reply-self-your-wall' => '$1 en $2 hebben geantwoord op een bericht op uw prikbord',
	'wn-user3-reply-self-your-wall' => '$1 en anderen hebben geantwoord op een bericht op uw prikbord',
	'wn-user1-reply-other-your-wall' => '$1 heeft geantwoord op een bericht van $2 op uw prikbord',
	'wn-user2-reply-other-your-wall' => '$1 en $2 hebben geantwoord op een bericht van $3 op uw prikbord',
	'wn-user3-reply-other-your-wall' => '$1 en anderen hebben geantwoord op een bericht van $2 op uw prikbord',
	'wn-user1-reply-you-other-wall' => '$1 heeft geantwoord op uw bericht op het prikbord van $2',
	'wn-user2-reply-you-other-wall' => '$1 en $2 hebben geantwoord op uw bericht op het prikbord van $3',
	'wn-user3-reply-you-other-wall' => '$1 en anderen hebben geantwoord op uw bericht op het prikbord van $3',
	'wn-user1-reply-self-other-wall' => '$1 heeft geantwoord op een bericht op het prikbord van $2',
	'wn-user2-reply-self-other-wall' => '$1 en $2 hebben geantwoord op een bericht op het prikbord van $3',
	'wn-user3-reply-self-other-wall' => '$1 en anderen hebben geantwoord op een bericht op het prikbord van $2',
	'wn-user1-reply-other-other-wall' => '$1 heeft geantwoord op een bericht van $2 op het prikbord van $3',
	'wn-user2-reply-other-other-wall' => '$1 en $2 hebben geantwoord op een bericht van $3 op het prikbord van $4',
	'wn-user3-reply-other-other-wall' => '$1 en anderen hebben geantwoord op een bericht van $2 op het prikbord van $3',
	'wn-user1-reply-you-a-wall' => '$1 heeft uw bericht beantwoord',
	'wn-user2-reply-you-a-wall' => '$1 en $2 hebben uw bericht beantwoord',
	'wn-user3-reply-you-a-wall' => '$1 en anderen hebben uw bericht beantwoord',
	'wn-user1-reply-self-a-wall' => '$1 heeft een bericht beantwoord',
	'wn-user2-reply-self-a-wall' => '$1 en $2 hebben een bericht beantwoord',
	'wn-user3-reply-self-a-wall' => '$1 en anderen hebben een bericht beantwoord',
	'wn-user1-reply-other-a-wall' => '$1 heeft een bericht van $2 beantwoord',
	'wn-user2-reply-other-a-wall' => '$1 en $2 hebben een bericht van $3 beantwoord',
	'wn-user3-reply-other-a-wall' => '$1 en anderen hebben geantwoord op een bericht van $3',
	'wn-newmsg-onmywall' => '$1 heeft een nieuw bericht geplaatst op uw prikbord',
	'wn-newmsg' => 'U hebt een nieuw bericht geplaatst op het prikbord van $1',
	'wn-newmsg-on-followed-wall' => '$1 heeft een nieuw bericht geplaatst op het prikbord van $2',
	'wn-admin-thread-deleted' => 'De draad is verwijderd van het prikbord van $1',
	'wn-admin-reply-deleted' => 'Het antwoord is verwijderd uit de draad op het prikbord van $1',
	'wn-owner-thread-deleted' => 'De draad is verwijderd van uw prikbord',
	'wn-owner-reply-deleted' => 'Het antwoord is verwijderd uit de draad op uw prikbord',
	'mail-notification-new-someone' => '$AUTHOR_NAME heeft een nieuw bericht geschreven op $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME heeft een nieuw bericht voor u achtergelaten op $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME heeft uw bericht beantwoord op $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME heeft een bericht beantwoord op $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME heeft een bericht van $PARENT_AUTHOR_NAME beantwoord op $WIKI.',
	'mail-notification-html-greeting' => 'Hallo $1,',
	'mail-notification-html-button' => 'Zie het gesprek',
	'mail-notification-html-footer-line1' => 'Ga naar <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> om de laatste ontwikkelingen bij Wikia te volgen',
	'mail-notification-html-footer-line2' => 'Wilt u bepalen welke e-mails u krijgt? Ga naar uw [{{fullurl:{{ns:special}}:Preferences}} voorkeuren]',
	'mail-notification-body' => 'Hallo $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTEUR

Zie het overleg ($MESSAGE_LINK)

Het Wikia-team
___________________________________________
* Vind hulp en advies op de Gemeenschapswiki: http://community.wikia.com
* Wilt u minder berichten ontvangen van ons? U kunt zich afmelden of uw
e-mailvoorkeuren wijzigen: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hallo $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>--$AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Zie het gesprek the conversation</a></p>
<p>Het Wikia-team</p>
___________________________________________<br />
 * Vind hulp en advies op Community Central: http://community.wikia.com
 * Wilt u minder berichten ontvangen van ons? U kunt hier afmelden of uw
e-mailvoorkeuren wijzingen: http://community.wikia.com/Special:Preferences',
);

/** Polish (polski)
 * @author Ankry
 * @author BeginaFelicysym
 * @author Debeet
 * @author Sovq
 */
$messages['pl'] = array(
	'wn-user1-reply-you-your-wall' => '$1 odpowiedział na Twoją wiadomość na Twojej tablicy',
	'wn-user2-reply-you-your-wall' => '$1 i $2 odpowiedzieli na Twoją wiadomość na Twojej tablicy',
	'wn-user3-reply-you-your-wall' => '$1 i inni odpowiedzieli na Twoją wiadomość na Twojej tablicy',
	'wn-user1-reply-self-your-wall' => '$1 odpowiedział na wiadomość na Twojej tablicy',
	'wn-user2-reply-self-your-wall' => '$1 i $2 odpowiedzieli na wiadomość na Twojej tablicy',
	'wn-user3-reply-self-your-wall' => '$1 i inni odpowiedzieli na wiadomość na Twojej tablicy',
	'wn-user1-reply-other-your-wall' => '$1 odpowiedział na wiadomość $2 na Twojej tablicy',
	'wn-user2-reply-other-your-wall' => '$1 i $2 odpowiedzieli na wiadomość od $3 na Twojej tablicy',
	'wn-user3-reply-other-your-wall' => '$1 i inni odpowiedzieli na wiadomość od $2 na Twojej tablicy',
	'wn-user1-reply-you-other-wall' => '$1 odpowiedział na Twoją wiadomość na tablicy użytkownika $2',
	'wn-user2-reply-you-other-wall' => '$1 i $2 odpowiedzieli na Twoją wiadomość na tablicy użytkownika $3',
	'wn-user3-reply-you-other-wall' => '$1 i inni odpowiedzieli na Twoją wiadomość na tablicy użytkownika $3',
	'wn-user1-reply-self-other-wall' => '$1 odpowiedział na wiadomość na tablicy użytkownika $2',
	'wn-user2-reply-self-other-wall' => '$1 i $2 odpowiedzieli na wiadomość na tablicy użytkownika $3',
	'wn-user3-reply-self-other-wall' => '$1 i inni odpowiedzieli na wiadomość na tablicy użytkownika $2',
	'wn-user1-reply-other-other-wall' => '$1 odpowiedział na wiadomość $2 na tablicy użytkownika $3',
	'wn-user2-reply-other-other-wall' => '$1 i $2 odpowiedzieli na wiadomość od $3 na tablicy użytkownika $4',
	'wn-user3-reply-other-other-wall' => '$1 i inni odpowiedzieli na wiadomość od $2 na tablicy użytkownika $3',
	'wn-user1-reply-you-a-wall' => '$1 odpowiedział na Twoją wiadomość',
	'wn-user2-reply-you-a-wall' => '$1 i $2 odpowiedzieli na Twoją wiadomość',
	'wn-user3-reply-you-a-wall' => '$1 i inni odpowiedzieli na Twoją wiadomość',
	'wn-user1-reply-self-a-wall' => '$1 odpowiedział na wiadomość',
	'wn-user2-reply-self-a-wall' => '$1 i $2 odpowiedzieli na wiadomość',
	'wn-user3-reply-self-a-wall' => '$1 i inni odpowiedzieli na wiadomość',
	'wn-user1-reply-other-a-wall' => '$1 odpowiedział na wiadomość $2',
	'wn-user2-reply-other-a-wall' => '$1 i $2 odpowiedzieli na wiadomość od $3',
	'wn-user3-reply-other-a-wall' => '$1 i inni odpowiedzieli na wiadomość od $3',
	'wn-newmsg-onmywall' => '$1 zostawił nową wiadomość na Twojej tablicy',
	'wn-newmsg' => 'Zostawiłeś nową wiadomość na tablicy użytkownika $1',
	'wn-newmsg-on-followed-wall' => '$1 zostawił nową wiadomość na tablicy użytkownika  $2',
	'wn-admin-thread-deleted' => 'Wątek skasowany z tablicy użytkownika $1',
	'wn-admin-reply-deleted' => 'Odpowiedź skasowano z wątku na tablicy $1',
	'wn-owner-thread-deleted' => 'Wątek skasowano z Twojej tablicy',
	'wn-owner-reply-deleted' => 'Odpowiedź usunięto z wątku na Twojej tablicy',
	'mail-notification-new-someone' => '$AUTHOR_NAME napisał(a) nową wiadomość na $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME zostawił(a) Ci wiadomość na $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME odpowiedział(a) na Twoją wiadomość na $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME odpowiedział(a) na wiadomość na $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME odpowiedział(a) na wiadomość użytkownika $PARENT_AUTHOR_NAME na $WIKI.',
	'mail-notification-html-greeting' => 'Witaj $1,',
	'mail-notification-html-button' => 'Przejdź do wiadomości',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>

<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>

<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>

<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Aby dowiedzieć się co nowego na Wikii, odwiedź <a style="color:#2a87d5;text-decoration:none;" href="http://spolecznosc.wikia.com">spolecznosc.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Chcesz zmienić ustawienia przysyłanych wiadomości? Idź do swoich <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferencji</a>',
	'mail-notification-body' => 'Witaj $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Przejdź do wiadomości($MESSAGE_LINK)

Zespół Wikii

___________________________________________
* Znajdź pomoc w Centrum Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Witaj $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Przejdź do wiadomości</a></p>
<p>Zespół Wikii</p>
___________________________________________<br />
* Znajdź pomoc w Centrum Społeczności: http://spolecznosc.wikia.com
* Nie chcesz otrzymywać wiadomości? Możesz zmienić ustawienia tutaj: http://community.wikia.com/Special:Preferences',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'mail-notification-html-greeting' => 'سلامونه $1،',
);

/** Portuguese (português)
 * @author Luckas
 * @author Malafaya
 * @author SandroHc
 */
$messages['pt'] = array(
	'wn-user1-reply-self-a-wall' => '$1 respondeu á mensagem',
	'wn-newmsg' => 'Você deixou uma nova mensagem no mural de $1',
	'wn-admin-thread-deleted' => 'Tópico removido do mural de $1',
	'mail-notification-new-someone' => '$AUTHOR_NAME escreveu uma nova mensagem na $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME deixou-te uma nova mensagem na $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME respondeu á tua mensagem na $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME respondeu a uma mensagem na $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME respondeu á mensagem de $PARENT_AUTHOR_NAME na $WIKI.',
	'mail-notification-html-greeting' => 'Olá $1,',
	'mail-notification-html-button' => 'Ver a conversação',
	'mail-notification-body' => 'Olá $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Veja a conversação($MESSAGE_LINK)

A Equipa da Wikia

___________________________________________
* Encontre ajuda e conselhos na Central da Comunidade: http://community.wikia.com
* Quer receber menos mensagens nossas? Você pode parar de subscrever ou alterar as
suas preferências de e-mail aqui: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Olá $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Veja a conversação</a></p>
			<p>The Wikia Team</p>
___________________________________________<br />
* Encontre ajuda e conselhos na Central da Comunidade: http://community.wikia.com
* Quer receber menos mensagens nossas? Você pode parar de subscrever ou alterar as
suas preferências de e-mail aqui: http://community.wikia.com/Special:Preferences',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Caio1478
 * @author Luckas
 * @author Luckas Blade
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'mail-notification-body' => 'Oi $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Veja a conversa($MESSAGE_LINK)

A Equipe Wikia

___________________________________________
* Procure ajuda e conselho na Wikia Português do Brasil: http://pt-br.wikia.com
* Quer receber menos mensagens de nós? Você pode cancelar sua inscrição ou alterar
suas preferências de email aqui: http://pt-br.wikia.com/wiki/Especial:Preferências',
	'mail-notification-body-HTML' => 'Olá $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Veja a conversa</a></p>
<p>A Equipe Wikia</p>
___________________________________________<br>
* Procure ajuda e conselho na Wikia Português do Brasil: http://pt-br.wikia.com
* Quer receber menos mensagens de nós? Você pode cancelar sua inscrição ou alterar
suas preferências de email aqui: http://pt-br.wikia.com/wiki/Especial:Preferências', # Fuzzy

);

/** Russian (русский)
 * @author DCamer
 * @author Eleferen
 * @author Express2000
 * @author Kuzura
 */
$messages['ru'] = array(
	'wn-user1-reply-you-your-wall' => '$1ответил на ваше сообщение на вашей стене',
	'wn-user2-reply-you-your-wall' => '$1 и $2 ответили на ваше сообщение на вашей стене',
	'wn-user3-reply-you-your-wall' => '$1 и другие ответили на ваше сообщение на вашей стене',
	'wn-user1-reply-self-your-wall' => '$1 ответил на сообщение на вашей стене',
	'wn-user2-reply-self-your-wall' => '$1 и $2 ответили на сообщение на вашей стене',
	'wn-user3-reply-self-your-wall' => '$1 и другие ответили на сообщение на вашей стене',
	'wn-user1-reply-other-your-wall' => '$1 ответил на сообщение $2 на вашей стене',
	'wn-user2-reply-other-your-wall' => '$1 и $2 ответили на сообщение $3 на вашей стене',
	'wn-user3-reply-other-your-wall' => '$1 и другие ответили на сообщение $2 на вашей стене',
	'wn-user1-reply-you-other-wall' => '$1 ответил на ваше сообщение на стене $2',
	'wn-user2-reply-you-other-wall' => '$1 и $2 ответили на ваше сообщение на стене $3',
	'wn-user3-reply-you-other-wall' => '$1 и другие ответили на ваше сообщение на стене $3',
	'wn-user1-reply-self-other-wall' => '$1 ответил на сообщение на стене $2',
	'wn-user2-reply-self-other-wall' => '$1 и $2 ответили на сообщение на стене $3',
	'wn-user3-reply-self-other-wall' => '$1 и другие ответили на сообщение на стене $2',
	'wn-user1-reply-other-other-wall' => '$1 ответил на сообщение $2 на стене $3',
	'wn-user2-reply-other-other-wall' => '$1 и $2 ответили на сообщение $3 на стене $4',
	'wn-user3-reply-other-other-wall' => '$1 и другие ответили на сообщение $2 на стене $3',
	'wn-user1-reply-you-a-wall' => '$1 ответил на ваше сообщение',
	'wn-user2-reply-you-a-wall' => '$1 и $2 ответили на ваше сообщение',
	'wn-user3-reply-you-a-wall' => '$1 и другие ответили на ваше сообщение',
	'wn-user1-reply-self-a-wall' => '$1 ответил на сообщение',
	'wn-user2-reply-self-a-wall' => '$1 и $2 ответили на сообщение',
	'wn-user3-reply-self-a-wall' => '$1 и другие ответили на сообщение',
	'wn-user1-reply-other-a-wall' => '$1 ответил на сообщение $2',
	'wn-user2-reply-other-a-wall' => '$1 и $2 ответили на сообщение $3',
	'wn-user3-reply-other-a-wall' => '$1 и другие ответили на сообщение $3',
	'wn-newmsg-onmywall' => '$1 оставил новое сообщение на вашей стене',
	'wn-newmsg' => 'Вы оставили новое сообщение на стене $1',
	'wn-newmsg-on-followed-wall' => '$1 оставил новое сообщение на стене $2.',
	'wn-admin-thread-deleted' => 'Тема была удалена со стены $1',
	'wn-admin-reply-deleted' => 'Ответ был удалён из темы на стене $1',
	'wn-owner-thread-deleted' => 'Одна из тем на вашей стене была удалена',
	'wn-owner-reply-deleted' => 'На вашей стене из темы был удалён ответ',
	'mail-notification-new-someone' => '$AUTHOR_NAME написал новое сообщение на $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME оставил вам новое сообщение на $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME ответил на ваше сообщение на $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME ответил на сообщение на $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME ответил на сообщение $PARENT_AUTHOR_NAME на $WIKI.',
	'mail-notification-html-greeting' => 'Здравствуйте $1,',
	'mail-notification-html-button' => 'Смотрите обсуждение',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Чтобы узнать о последних событиях на Викия, посетите <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Чтобы настроить уведомления по email, перейдите на страницу <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">личных настроек</a>',
	'mail-notification-body' => 'Hi $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Смотрите обсуждение ($MESSAGE_LINK)

Команда Викия

___________________________________________
* Найти помощь и совет можно на Community Central (http://community.wikia.com) и Вики Сообщества (http://ru.community.wikia.com)
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Уважаемый $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Смотрите обсуждение</a></p>
<p>Команда Викия</p>
___________________________________________<br />
* Найти помощь и совет можно на Community Central: http://community.wikia.com
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
);

/** Swedish (svenska)
 * @author Cybjit
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'wn-user1-reply-you-your-wall' => '$1 svarade på ditt meddelande på din vägg',
	'wn-user2-reply-you-your-wall' => '$1 och $2 svarade på ditt meddelande på din vägg',
	'wn-user3-reply-you-your-wall' => '$1 och andra svarade på ditt meddelande på din vägg',
	'wn-user1-reply-self-your-wall' => '$1 svarade på ett meddelande på din vägg',
	'wn-user2-reply-self-your-wall' => '$1 och $2 svarade på ett meddelande på din vägg',
	'wn-user3-reply-self-your-wall' => '$1 och andra svarade på ett meddelande på din vägg',
	'wn-user1-reply-other-your-wall' => '$1 svarade på $2s meddelande på din vägg',
	'wn-user2-reply-other-your-wall' => '$1 och $2 svarade på $3s meddelande på din vägg',
	'wn-user3-reply-other-your-wall' => '$1 och andra svarade på $2s meddelande på din vägg',
	'wn-user1-reply-you-other-wall' => '$1 svarade på ditt meddelande på $2s vägg',
	'wn-user2-reply-you-other-wall' => '$1 och $2 svarade på ditt meddelande på $3s vägg',
	'wn-user3-reply-you-other-wall' => '$1 och andra svarade på ditt meddelande på $3s vägg',
	'wn-user1-reply-self-other-wall' => '$1 svarade på ett meddelande på $2s vägg',
	'wn-user2-reply-self-other-wall' => '$1 och $2 svarade på ett meddelande på $3s vägg',
	'wn-user3-reply-self-other-wall' => '$1 och andra svarade på ett meddelande på $2s vägg',
	'wn-user1-reply-other-other-wall' => '$1 svarade på $2s meddelande på $3s vägg',
	'wn-user2-reply-other-other-wall' => '$1 och $2 svarade på $3s meddelande på $4s vägg',
	'wn-user3-reply-other-other-wall' => '$1 och andra svarade på $2s meddelande på $3s vägg',
	'wn-user1-reply-you-a-wall' => '$1 svarade på ditt meddelande',
	'wn-user2-reply-you-a-wall' => '$1 och $2 svarade på ditt meddelande',
	'wn-user3-reply-you-a-wall' => '$1 och andra svarade på ditt meddelande',
	'wn-user1-reply-self-a-wall' => '$1 svarade på ett meddelande',
	'wn-user2-reply-self-a-wall' => '$1 och $2 svarade på ett meddelande',
	'wn-user3-reply-self-a-wall' => '$1 och andra svarade på ett meddelande',
	'wn-user1-reply-other-a-wall' => '$1 svarade på $2s meddelande',
	'wn-user2-reply-other-a-wall' => '$1 och $2 svarade på $3s meddelande',
	'wn-user3-reply-other-a-wall' => '$1 och andra svarade på $3s meddelande',
	'wn-newmsg-onmywall' => '$1 lämnade ett nytt meddelande på din vägg',
	'wn-newmsg' => 'Du lämnade ett nytt meddelande på $1s vägg',
	'wn-newmsg-on-followed-wall' => '$1 lämnade ett nytt meddelande på $2s vägg',
	'wn-admin-thread-deleted' => 'Tråd togs bort från $1s vägg',
	'wn-admin-reply-deleted' => 'Svar togs bort från tråden på $1s vägg',
	'wn-owner-thread-deleted' => 'Tråd togs bort från din vägg',
	'wn-owner-reply-deleted' => 'Svar togs bort från tråden på din vägg',
	'mail-notification-new-someone' => '$AUTHOR_NAME skrev ett nytt meddelande på $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME lämnade ett nytt meddelande till dig på $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME svarade på ditt meddelande på $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME svarade på ett meddelande på $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME svarade på $PARENT_AUTHOR_NAMEs meddelande på $WIKI.',
	'mail-notification-html-greeting' => 'Hej $1,',
	'mail-notification-html-button' => 'Se konversationen',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'För att kolla in de senaste händelserna på Wikia, besök <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Vill du kontrollera vilka e-postmeddelanden du får? Gå till dina <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Inställningar</a>',
	'mail-notification-body' => 'Hej $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Se konversationen ($MESSAGE_LINK)

Wikia-teamet

___________________________________________
* Hitta hjälp och råd på Gemenskapscentralen: http://community.wikia.com
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra
dina e-postinställningar här: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Hej $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Se konversationen</a></p>
			<p>Wikia-teamet</p>
___________________________________________<br />
* Hitta hjälp och råd på Gemenskapscentralen: http://community.wikia.com
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra
dina e-postinställningar här: http://community.wikia.com/Special:Preferences',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'wn-user1-reply-you-your-wall' => 'Tumugon si $1 sa mensahe mo na nasa ibabaw ng iyong dingding',
	'wn-user2-reply-you-your-wall' => 'Tumugon sina $1 at $2 sa mensahe mo na nasa ibabaw ng iyong dingding',
	'wn-user3-reply-you-your-wall' => 'Tumugon si $1 at iba pa sa iyong mensahe na nasa ibabaw ng dingding mo',
	'wn-user1-reply-self-your-wall' => 'Tumugon si $1 sa isang mensahe na nasa ibabaw ng iyong dingding',
	'wn-user2-reply-self-your-wall' => 'Tumugon sina $1 at $2 sa isang mensahe na nasa ibabaw ng iyong dingding',
	'wn-user3-reply-self-your-wall' => 'Tumugon si $1 at iba pa sa isang mensahe na nasa ibabaw ng dingding mo',
	'wn-user1-reply-other-your-wall' => 'Tumugon si $1 sa mensahe ni $2 na nasa ibabaw ng iyong dingding',
	'wn-user2-reply-other-your-wall' => 'Tumugon sina $1 at $2 sa mensahe ni $3 na nasa ibabaw ng iyong dingding',
	'wn-user3-reply-other-your-wall' => 'Tumugon si $1 at iba pa sa mensahe ni $2 na nasa ibabaw ng dingding mo',
	'wn-user1-reply-you-other-wall' => 'Tumugon si $1 sa mensahe mo na nasa ibabaw ng dingding ni $2',
	'wn-user2-reply-you-other-wall' => 'Tumugon sina $1 at $2 sa mensahe mo na nasa ibabaw ng dingding ni $3',
	'wn-user3-reply-you-other-wall' => 'Tumugon si $1 at iba pa sa iyong mensahe na nasa ibabaw ng dingding ni $3',
	'wn-user1-reply-self-other-wall' => 'Tumugon si $1 sa isang mensaheng nasa ibabaw ng dingding ni $2',
	'wn-user2-reply-self-other-wall' => 'Tumugon sina $1 at $2 sa isang mensaheng nasa ibabaw ng dingding ni $3',
	'wn-user3-reply-self-other-wall' => 'Tumugon si $1 at iba pa sa isang mensaheng nasa ibabaw ng dingding ni $2',
	'wn-user1-reply-other-other-wall' => 'Tumugon si $1 sa mensahe ni $2 na nasa ibabaw ng dingding ni $3',
	'wn-user2-reply-other-other-wall' => 'Tumugon sina $1 at $2 sa mensahe ni $3 na nasa ibabaw ng dingding ni $4',
	'wn-user3-reply-other-other-wall' => 'Tumugon si $1 at iba pa sa mensahe ni $2 na nasa ibabaw ng dingding ni $3',
	'wn-user1-reply-you-a-wall' => 'Tumugon si $1 sa mensahe mo',
	'wn-user2-reply-you-a-wall' => 'Tumugon sina $1 at $2 sa mensahe mo',
	'wn-user3-reply-you-a-wall' => 'Tumugon si $1 at iba pa sa mensahe mo',
	'wn-user1-reply-self-a-wall' => 'Tumugon si $1 sa isang mensahe',
	'wn-user2-reply-self-a-wall' => 'Tumugon sina $1 at $2 sa isang mensahe',
	'wn-user3-reply-self-a-wall' => 'Tumugon si $1 at iba pa sa isang mensahe',
	'wn-user1-reply-other-a-wall' => 'Tumugon si $1 sa mensahe ni $2',
	'wn-user2-reply-other-a-wall' => 'Tumugon sina $1 at $2 sa isang mensahe ni $3',
	'wn-user3-reply-other-a-wall' => 'Tumugon si $1 at iba pa sa mensahe ni $3',
	'wn-newmsg-onmywall' => 'Nag-iwan si $1 ng isang bagong mensahe sa ibabaw ng dingding mo',
	'wn-newmsg' => 'Nag-iwan ka ng isang bagong mensahe sa ibabaw ng dingding ni $1',
	'wn-newmsg-on-followed-wall' => 'Nag-iwan si $1 ng isang bagong mensahe sa ibabaw ng dingding ni $2',
	'wn-admin-thread-deleted' => 'Tinanggal ang sinulid mula sa dingding ni $1',
	'wn-admin-reply-deleted' => 'Tinanggal ang tugon mula sa sinulid na nasa ibabaw ng dingding ni $1',
	'wn-owner-thread-deleted' => 'Tinanggal ang sinulid mula sa dingding mo',
	'wn-owner-reply-deleted' => 'Tinanggal ang tugon mula sa sinulid na nasa ibabaw ng dingding mo',
	'mail-notification-new-someone' => 'Nagsulat si $AUTHOR_NAME ng isang bagong mensahe sa $WIKI.',
	'mail-notification-new-your' => 'Nag-iwan si $AUTHOR_NAME ng isang bagong mensahe sa $WIKI.',
	'mail-notification-reply-your' => 'Tumugon si $AUTHOR_NAME sa isang mensahe mong nasa $WIKI.',
	'mail-notification-reply-his' => 'Tumugon si $AUTHOR_NAME sa isang mensahe na nasa $WIKI.',
	'mail-notification-reply-someone' => 'Si $AUTHOR_NAME ay tumugon sa mensahe ni $PARENT_AUTHOR_NAME na nasa $WIKI.',
	'mail-notification-html-greeting' => 'Kumusta $1,',
	'mail-notification-html-button' => 'Tingnan ang pag-uusap',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'mail-notification-html-footer-line1' => 'Upang matingnan ang pinaka huling mga kaganapan sa Wikia, dalawin ang <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Nais mong kontrolin ang tinatanggap mong mga e-liham? Pumunta sa iyong <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Mga nais</a>',
	'mail-notification-body' => 'Kumusta $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Tingnan ang pag-uusap($MESSAGE_LINK)

Ang Pangkat ng Wikia

___________________________________________
* Maghanap ng tulong at payo sa Lunduyan ng Pamayanan: http://community.wikia.com
* Nais tumanggap ng mas kakaunting mga mensahe mula sa amin? Maaari kang huwag nang magpasipi o baguhin
ang iyong mga kanaisan ng elektronikong liham dito: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Kumusta $WATCHER,
<p>$SUBJECT.</p>
<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
<p>$MESSAGE_HTML</p>
<p>-- $AUTHOR_SIGNATURE<p>
<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Tingnan ang pag-uusap</a></p>
<p>Ang Pangkat ng Wikia</p>
___________________________________________<br />
* Maghanap ng tulong at payo sa Lunduyan ng Pamayanan: http://community.wikia.com
* Nais tumanggap ng mas kakaunting mga mensahe mula sa amin? Maaari kang huwag nang magpasipi o baguhin
ang iyong mga kanaisan ng elektronikong liham dito: http://community.wikia.com/Special:Preferences',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
);

/** Ukrainian (українська)
 * @author Pig1995z
 * @author Wildream
 */
$messages['uk'] = array(
	'wn-user1-reply-you-your-wall' => '$1 відповів(ла) на ваше повідомлення на стіні',
	'wn-user2-reply-you-your-wall' => '$1 та $2 відповіли на повідомлення на вашій стіні',
	'wn-user3-reply-you-your-wall' => '$1 та інші відповіли на повідомлення на вашій стіні',
	'wn-user1-reply-self-your-wall' => '$1 відповів на повідомлення на вашій стіні',
	'wn-user2-reply-self-your-wall' => '$1 та $2 відповіли на повідомлення на вашій стіні',
	'wn-user3-reply-self-your-wall' => '$1 та інші на повідомлення на вашій сторінці',
	'wn-user1-reply-other-your-wall' => '$1 відповів на повідомлення $2 на вашій стіні',
	'wn-user2-reply-other-your-wall' => '$1 та $2 відповіли на повідомлення $3 на вашій стіні',
	'wn-user3-reply-other-your-wall' => '$1 та інші на повідомлення $2 на вашій стіні',
	'wn-user1-reply-you-other-wall' => '$1 відповів на ваше повідомлення на стіні $2',
	'wn-user2-reply-you-other-wall' => '$1 та $2 відповіли на ваше повідомлення на стіні $3',
	'wn-user3-reply-you-other-wall' => '$1 та інші відповіли на ваше повідомлення на стіні $3',
	'wn-user1-reply-self-other-wall' => '$1 відповів на повідомлення на стіні $2',
	'wn-user2-reply-self-other-wall' => '$1 та $2 відповіли на повідомлення на стіні $3',
	'wn-user3-reply-self-other-wall' => '$1 та інші відповіли на повідомлення на стіні $2',
	'wn-user1-reply-other-other-wall' => '$1 відповів на повідомлення $2 на стіні $3',
	'wn-user2-reply-other-other-wall' => '$1 та $2 відповіли на повідомлення $3 на стіні $4',
	'wn-user3-reply-other-other-wall' => '$1 та інші відповіли на повідомлення $2 на стіні $3',
	'wn-user1-reply-you-a-wall' => '$1відповів на ваше повідомлення',
	'wn-user2-reply-you-a-wall' => '$1 і  $2  відповіли на ваше повідомлення',
	'wn-user3-reply-you-a-wall' => '$1 та інші відповіли на ваше повідомлення',
	'wn-user1-reply-self-a-wall' => '$1відповів на повідомлення',
	'wn-user2-reply-self-a-wall' => '$1 і  $2  відповіли на повідомлення',
	'wn-user3-reply-self-a-wall' => '$1 та інші відповіли на повідомлення',
	'wn-user1-reply-other-a-wall' => '$1відповів на повідомлення $2',
	'wn-user2-reply-other-a-wall' => '$1 і  $2  відповіли на повідомлення $3',
	'wn-user3-reply-other-a-wall' => '$1 та інші відповіли на повідомлення $3',
	'wn-newmsg-onmywall' => '$1 залишив нове повідомлення на вашій стіні',
	'wn-newmsg' => 'Ви залишили нове повідомлення на стіні користувача $1',
	'wn-newmsg-on-followed-wall' => '$1 залишив нове повідомлення на стіні $2',
	'wn-admin-thread-deleted' => 'Обговорення було видалене зі стіни $1',
	'wn-admin-reply-deleted' => 'Відповідь була видалена зі стіни $1',
	'wn-owner-thread-deleted' => 'Обговорення було видалене з вашої стіни',
	'wn-owner-reply-deleted' => 'Відповідь була видалена з вашої стіни',
	'mail-notification-new-someone' => '$AUTHOR_NAME написав нове повідомлення на $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME залишив вам нове повідомлення на $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME відповів на ваше повідомлення на $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME відповів на повідомлення на $WIKI.',
	'mail-notification-html-greeting' => 'Привіт $1,',
	'mail-notification-html-button' => 'Дивіться обговорення',
	'mail-notification-html-footer-line1' => 'Відвідайте <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> , щоб дізнатися про останні події на Вікія.',
	'mail-notification-html-footer-line2' => 'Щоб налаштувати сповіщення по email, перейдіть на сторінку <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',
	'mail-notification-body' => 'Привіт, $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

See the conversation($MESSAGE_LINK)

Команда Вікія

___________________________________________
* Ви можете знайти допомогу, та поради на (http://community.wikia.com) та Вики Сообщества (http://ru.community.wikia.com)
* Хочете отримувати менше таких повідомленнь? Ви можете відмовитися від розсилки даних повідомлень, або внести в неї корективи на сторінці власних налаштуваннь: http://community.wikia.com/Special:Preferences',
	'mail-notification-body-HTML' => 'Привіт, $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">See the conversation</a></p>
			<p>Команда Вікія</p>
___________________________________________<br />
* Ви можете знайти допомогу, та поради на (http://community.wikia.com) та Вики Сообщества (http://ru.community.wikia.com)
* Хочете отримувати менше таких повідомленнь? Ви можете відмовитися від розсилки даних повідомлень, або внести в неї корективи на сторінці власних налаштуваннь: http://community.wikia.com/Special:Preferences',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'wn-user1-reply-you-your-wall' => '$1 trả lời tin nhắn của bạn trên tường của bạn',
	'wn-user2-reply-you-your-wall' => '$1 và $2 trả lời tin nhắn của bạn trên tường của bạn',
	'wn-user3-reply-you-your-wall' => '$1 và những người khác trả lời tin nhắn của bạn trên tường của bạn',
	'wn-user1-reply-self-your-wall' => '$1 trả lời một tin nhắn trên tường của bạn',
	'wn-user2-reply-self-your-wall' => '$1 và $2 trả lời một tin nhắn trên tường của bạn',
	'wn-user3-reply-self-your-wall' => '$1 và những người khác trả lời một tin nhắn trên tường của bạn',
	'wn-user1-reply-other-your-wall' => '$1 trả lời tin nhắn của $2 trên tường của bạn',
	'wn-user2-reply-other-your-wall' => '$1 và $2 trả lời tin nhắn của $3 trên tường của bạn',
	'wn-user3-reply-other-your-wall' => '$1 và những người khác trả lời tin nhắn của $2 trên tường của bạn',
	'wn-user1-reply-you-other-wall' => '$1 trả lời tin nhắn của bạn trên tường của $2',
	'wn-user2-reply-you-other-wall' => '$1 và $2 trả lời tin nhắn của bạn trên tường của $3',
	'wn-user3-reply-you-other-wall' => '$1 và những người khác trả lời tin nhắn của bạn trên tường của $3',
	'wn-user1-reply-self-other-wall' => '$1 trả lời một tin nhắn trên tường của $2',
	'wn-user2-reply-self-other-wall' => '$1 và $2 trả lời một tin nhắn trên tường của $3',
	'wn-user3-reply-self-other-wall' => '$1 và những người khác trả lời một tin nhắn trên tường của $2',
	'wn-user1-reply-other-other-wall' => '$1 trả lời tin nhắn của $2 trên tường của $3',
	'wn-user2-reply-other-other-wall' => '$1 và $2 trả lời tin nhắn của $3 trên tường của $4',
	'wn-user3-reply-other-other-wall' => '$1 và những người khác trả lời tin nhắn của $2 trên tường của $3',
	'wn-user1-reply-you-a-wall' => '$1 trả lời tin nhắn của bạn',
	'wn-user2-reply-you-a-wall' => '$1 và $2 trả lời tin nhắn của bạn',
	'wn-user3-reply-you-a-wall' => '$1 và những người khác trả lời tin nhắn của bạn',
	'wn-user1-reply-self-a-wall' => '$1 trả lời một tin nhắn',
	'wn-user2-reply-self-a-wall' => '$1 và $2 trả lời một tin nhắn',
	'wn-user3-reply-self-a-wall' => '$1 và những người khác trả lời một tin nhắn',
	'wn-user1-reply-other-a-wall' => '$1 trả lời tin nhắn của $2',
	'wn-user2-reply-other-a-wall' => '$1 và $2 trả lời tin nhắn của $3',
	'wn-user3-reply-other-a-wall' => '$1 và những người khác trả lời tin nhắn của $3',
	'wn-newmsg-onmywall' => '$1 đã để lại một tin nhắn mới trên tường của bạn',
	'wn-newmsg' => 'Bạn đã để lại một tin nhắn mới trên tường của $1',
	'wn-newmsg-on-followed-wall' => '$1 đã để lại một tin nhắn mới trên tường của $2.', # Fuzzy
	'wn-admin-thread-deleted' => 'Luồng đã được gỡ bỏ khỏi tường của $1',
	'wn-admin-reply-deleted' => 'Hồi âm đã được gỡ bỏ từ luồng trên tường của $1',
	'wn-owner-thread-deleted' => 'Luồng đã được gỡ bỏ từ tường của bạn',
	'wn-owner-reply-deleted' => 'Hồi âm đã được gỡ bỏ từ luồng trên tường của bạn',
	'mail-notification-new-someone' => '$AUTHOR_NAME đã viết một tin nhắn mới trên $WIKI.',
	'mail-notification-new-your' => '$AUTHOR_NAME đã để lại cho bạn một tin nhắn mới trên $WIKI.',
	'mail-notification-reply-your' => '$AUTHOR_NAME đã trả lời tin nhắn của bạn trên $WIKI.',
	'mail-notification-reply-his' => '$AUTHOR_NAME đã trả lời một tin nhắn trên $WIKI.',
	'mail-notification-reply-someone' => '$AUTHOR_NAME đã trả lời tin nhắn của $PARENT_AUTHOR_NAME trên $WIKI.',
	'mail-notification-html-greeting' => 'Chào $1,',
	'mail-notification-html-button' => 'Xem cuộc hội thoại',
	'mail-notification-subject' => '$1 -- $2',
	'mail-notification-html-footer-line1' => 'Để kiểm tra những diễn biến và thay đổi mới nhất về Wikia, hãy truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>
Để nhận được sự hỗ trợ cho ngôn ngữ của bạn, truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://vi.wikia.com">vi.wikia.com</a>',
	'mail-notification-html-footer-line2' => 'Muốn kiểm soát những email mà bạn nhận được? <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Tùy chọn</a>',
	'mail-notification-body' => 'Xin chào $WATCHER,

$SUBJECT

$METATITLE

$MESSAGE_NO_HTML

-- $AUTHOR

Xem cuộc hội thoại($MESSAGE_LINK)

Wikia Team

___________________________________________
* Tìm kiếm sự trợ giúp và lời khuyên tại Cộng đồng Trung tâm: http://community.wikia.com
* Nhận được sự hỗ trợ từ ngôn ngữ của bạn tại Wikia Tiếng Việt: http://vi.wikia.com
* Muốn nhận ít thư thông báo hơn từ chúng tôi? Bạn có thể bỏ chọn hoặc thay đổi
 tuỳ chọn thư điện tử của bạn ở đây: http://vi.wikia.com/wiki/Đặc_biệt:Tùy_chọn',
	'mail-notification-body-HTML' => 'Chào $WATCHER,
			<p>$SUBJECT.</p>
			<p><a href="$MESSAGE_LINK">$METATITLE</a></p>
			<p>$MESSAGE_HTML</p>
			<p>-- $AUTHOR_SIGNATURE<p>
			<p><a style="padding: 4px 10px;background-color: #006CB0; color: #FFF !important;text-decoration: none;" href="$MESSAGE_LINK">Xem cuộc hội thoại</a></p>
			<p>Wikia Team</p>
___________________________________________<br />
* Tìm kiếm sự trợ giúp và lời khuyên tại Cộng đồng Trung tâm: http://community.wikia.com
* Nhận được sự hỗ trợ từ ngôn ngữ của bạn tại Wikia Tiếng Việt: http://vi.wikia.com
* Muốn nhận ít thư thông báo hơn từ chúng tôi? Bạn có thể bỏ chọn hoặc thay đổi
 tuỳ chọn thư điện tử của bạn ở đây: http://vi.wikia.com/wiki/Đặc_biệt:Tùy_chọn',
 );

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Sam Wang
 * @author Yfdyh000
 * @author 乌拉跨氪
 */
$messages['zh-hans'] = array(
	'wn-user1-reply-you-your-wall' => '$1在您的信息墙上回复了您',
	'wn-user2-reply-you-your-wall' => '$1和$2在您的信息墙上回复了您',
	'wn-user3-reply-you-your-wall' => '$1等人在您的信息墙上回复了您',
	'wn-user1-reply-self-your-wall' => '$1在您的墙上回复了信息',
	'wn-user2-reply-other-your-wall' => '$1和$2在您的信息墙上回复了$3',
	'wn-user1-reply-you-other-wall' => '$1在$2的信息墙上回复了您',
	'wn-user1-reply-self-other-wall' => '$1在$2的信息墙上做出了回复',
	'wn-user1-reply-other-other-wall' => '$1在$3的信息墙上回复了$2',
	'wn-user2-reply-other-other-wall' => '$1和$2在$4的信息墙上回复了$3',
	'wn-user1-reply-you-a-wall' => '$1回复了你的信息',
	'wn-user1-reply-other-a-wall' => '$1回复了$2',
	'wn-newmsg-onmywall' => '$1在您的墙上留言了',
	'wn-newmsg-on-followed-wall' => '$1在$2的墙上留言了',
	'mail-notification-html-greeting' => '嗨！$1,',
);

