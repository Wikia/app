<?php
$messages = array();

$messages['en'] = array(
	'emailext-wallmessage-owned-subject' => 'You have a new message on {{SITENAME}}: $1',
	'emailext-wallmessage-following-subject' => '$1 has a new message on {{SITENAME}}: $2',
	'emailext-wallmessage-owned-summary' => "'''You have a new message on [{{SERVER}} {{SITENAME}}]: [$1 $2]'''",
	'emailext-wallmessage-following-summary' => "'''$1 has a new message on [{{SERVER}} {{SITENAME}}]: [$2 $3]'''",
	'emailext-wallmessage-full-conversation' => 'Full conversation',
	'emailext-wallmessage-recent-messages' => '[$1 All recent messages on $2]',
	'emailext-wallmessage-reply-subject' => 'There is a new reply to $1 on {{SITENAME}}',
	'emailext-wallmessage-reply-summary' => "'''There is a new reply to [$1 $2] on [{{SERVER}} {{SITENAME}}]'''",
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

$messages['de'] = array(
	'emailext-wallmessage-owned-subject' => '$1 hat dir auf der Seite {{SITENAME}} eine neue Nachricht geschickt.',
	'emailext-wallmessage-following-subject' => '$1 hat $2 auf der Seite {{SITENAME}} eine neue Nachricht geschickt.',
	'emailext-wallmessage-owned-summary' => "'''Hast du ein Glück! [$1 $2] hat dir auf der Seite [{{SERVER}} {{SITENAME}}] eine neue Nachricht geschickt.'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] hat $3 auf der Seite [{{SERVER}} {{SITENAME}}] eine neue Nachricht geschickt.'''",
	'emailext-wallmessage-full-conversation' => 'Gesamter Gesprächsverlauf',
	'emailext-wallmessage-recent-messages' => '[$1 Alle neuen Nachrichten auf $2]',
);

$messages['es'] = array(
	'emailext-wallmessage-owned-subject' => '$1 te escribió un mensaje nuevo en {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 le escribió a $2 un mensaje nuevo en {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] te escribió un mensaje nuevo en [{{SERVER}} {{SITENAME}}]. ¡Qué suerte tienes!'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] le escribió a $3 un mensaje nuevo en [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Conversación completa',
	'emailext-wallmessage-recent-messages' => '[$1 Todos los mensajes recientes sobre $2]',
);

$messages['fr'] = array(
	'emailext-wallmessage-owned-subject' => '$1 vous a laissé un nouveau message sur {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 a laissé un nouveau message à $2 sur {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] vous a laissé un nouveau message sur [{{SERVER}} {{SITENAME}}]. Hourra !'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] a laissé un nouveau message à $3 sur [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Voir la conversation',
	'emailext-wallmessage-recent-messages' => '[$1 Tous les messages récents sur $2]',
);

$messages['it'] = array(
	'emailext-wallmessage-owned-subject' => '$1 ti ha scritto un nuovo messaggio in {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 ha scritto un nuovo messaggio per $2 in {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] ti ha scritto un nuovo messaggio in [{{SERVER}} {{SITENAME}}]. Urrà!'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] ha scritto un nuovo messaggio per $3 in [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Conversazione completa',
	'emailext-wallmessage-recent-messages' => '[$1 Tutti i messaggi recenti in $2]',
);

$messages['ja'] = array(
	'emailext-wallmessage-owned-subject' => '$1さんが{{SITENAME}}で新しいメッセージを投稿しました',
	'emailext-wallmessage-following-subject' => '$1さんが$2さんに{{SITENAME}}で新しいメッセージを投稿しました',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2]さんが[{{SERVER}} {{SITENAME}}]で新しいメッセージを投稿しました。'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2]さんが$3さんに[{{SERVER}} {{SITENAME}}]で新しいメッセージを投稿しました。'''",
	'emailext-wallmessage-full-conversation' => 'スレッド全体を見る',
	'emailext-wallmessage-recent-messages' => '[$1 $2の最近のメッセージをすべて見る]',
);

$messages['nl'] = array(
	'emailext-wallmessage-owned-subject' => '$1 wrote you a new message on {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 wrote $2 a new message on {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] wrote you a new message on [{{SERVER}} {{SITENAME}}]. Lucky you!'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] wrote $3 a new message on [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Full conversation',
	'emailext-wallmessage-recent-messages' => '[$1 All recent messages on $2]',
);

$messages['pl'] = array(
	'emailext-wallmessage-owned-subject' => '$1 napisał do ciebie nową wiadomość na {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 napisał do $2 nową wiadomość na {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] napisał do ciebie nową wiadomość na [{{SERVER}} {{SITENAME}}]. Wspaniale!'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] napisał do $3 nową wiadomość na [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Pełna rozmowa',
	'emailext-wallmessage-recent-messages' => '[$1 Wszystkie najnowsze wiadomości na $2]',
);

$messages['pt'] = array(
	'emailext-wallmessage-owned-subject' => '$1 escreveu-lhe uma mensagem nova na {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 escreveu uma mensagem nova para $2 na {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] escreveu-lhe uma mensagem nova na [{{SERVER}} {{SITENAME}}]. Que sorte!'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] escreveu uma mensagem nova para $3 na [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Conversa completa',
	'emailext-wallmessage-recent-messages' => '[$1 Todas as mensagens recentes no $2]',
);

$messages['ru'] = array(
	'emailext-wallmessage-owned-subject' => '$1 оставил(а) вам новое сообщение на {{SITENAME}}',
	'emailext-wallmessage-following-subject' => '$1 оставил(а) участнику $2 новое сообщение на {{SITENAME}}',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2] оставил(а) вам новое сообщение на [{{SERVER}} {{SITENAME}}]. Вот так удача!'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2] оставил(а) участнику $3 новое сообщение на [{{SERVER}} {{SITENAME}}].'''",
	'emailext-wallmessage-full-conversation' => 'Обсуждение полностью',
	'emailext-wallmessage-recent-messages' => '[$1 Все недавние сообщения на $2]',
);

$messages['zh-hans'] = array(
	'emailext-wallmessage-owned-subject' => '$1在{{SITENAME}}上给您留言了',
	'emailext-wallmessage-following-subject' => '$1在{{SITENAME}}上给$2留言了',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2]在[{{SERVER}} {{SITENAME}}]上给您留言了。真幸运！'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2]在[{{SERVER}} {{SITENAME}}]上给$3留言了。'''",
	'emailext-wallmessage-full-conversation' => '完整对话',
	'emailext-wallmessage-recent-messages' => '[$1$2上最近的所有留言]',
);

$messages['zh-tw'] = array(
	'emailext-wallmessage-owned-subject' => '$1在{{SITENAME}}上給你留言了',
	'emailext-wallmessage-following-subject' => '$1在{{SITENAME}}上給$2留言了',
	'emailext-wallmessage-owned-summary' => "'''[$1 $2]在[{{SERVER}} {{SITENAME}}]上給你留言了。好幸運喔！'''",
	'emailext-wallmessage-following-summary' => "'''[$1 $2]在[{{SERVER}} {{SITENAME}}]上給$3留言了。'''",
	'emailext-wallmessage-full-conversation' => '完整對話',
	'emailext-wallmessage-recent-messages' => '[$1$2上最近的所有留言]',
);

