<?php
/** Internationalization file for /extensions/wikia/Email/i18n/Forum extension. */
$messages = [];

$messages['en'] = [
	'emailext-forum-subject' => 'There is a new discussion on $1 on {{SITENAME}}.',
	'emailext-forum-summary' => 'There is a new discussion on [$1 $2] on [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-button-label' => 'See the discussion',
	'emailext-forum-reply-subject' => '$1 on {{SITENAME}} has new replies.',
	'emailext-forum-reply-summary' => '[$2 $1] on [{{SERVER}} {{SITENAME}}] has new replies.',
	'emailext-forum-reply-link-label' => 'Read the reply',
	'emailext-forum-reply-view-all' => '[$1 See the entire discussion.]',
	'emailext-forumreply-unfollow-text' => 'No longer interested in receiving these updates? Click [$1 here] to unfollow [$2 this discussion] on [{{SERVER}} {{SITENAME}}].',
];

$messages['qqq'] = [
	'emailext-forum-subject' => 'Subject for email that is fired when new thread is created. $1 -> Forum board name where thread was created.',
	'emailext-forum-summary' => 'Message to the user that new forum thread was created. $1 -> thread url, $2 -> thread name',
	'emailext-forum-button-label' => 'Text for button that, when clicked, navigates to the new forum thread.',
	'emailext-forum-reply-subject' => 'Information about the new replies in thread. It goes to an email subject. $1 is the thread subject.',
	'emailext-forum-reply-summary' => 'Information about the new replies in thread. $1 is the thread subject.',
	'emailext-forum-reply-link-label' => 'Link to the post, permalink.',
	'emailext-forum-reply-view-all' => 'Link to the thread page.',
	'emailext-forumreply-unfollow-text' => 'Asks the user if they want to stop following this discussion and provides a link to unfollow the discussion. $1 -> unfollow url, $2 discussion url',
];

$messages['de'] = [
	'emailext-forum-subject' => 'Im Forum $1 auf der Seite {{SITENAME}} wurde eine neue Diskussion gestartet.',
	'emailext-forum-summary' => 'Im Forum [$1 $2] auf der Seite [{{SERVER}} {{SITENAME}}] wurde eine neue Diskussion gestartet.',
	'emailext-forum-button-label' => 'Diskussion anzeigen',
	'emailext-forum-reply-subject' => 'Zu $1 auf der Seite {{SITENAME}} wurden neue Antworten eingestellt.',
	'emailext-forum-reply-summary' => 'Zu [$2 $1] auf der Seite [{{SERVER}} {{SITENAME}}] wurden neue Antworten eingestellt.',
	'emailext-forum-reply-link-label' => 'Antwort lesen',
	'emailext-forum-reply-view-all' => '[$1 Gesamte Diskussion ansehen.]',
	'emailext-forumreply-unfollow-text' => 'Du möchtest diese Updates nicht mehr erhalten? Klicke [$1 hier], um [$2 dieser Diskussion] auf der Seite {[{{SERVER}} {{SITENAME}}] nicht mehr zu folgen.',
];

$messages['es'] = [
	'emailext-forum-subject' => 'Hay una nueva discusión sobre $1 en {{SITENAME}}.',
	'emailext-forum-summary' => 'Hay una nueva discusión sobre [$1 $2] en [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-button-label' => 'Ver la discusión',
	'emailext-forum-reply-subject' => 'La página $1 en {{SITENAME}} tiene respuestas nuevas.',
	'emailext-forum-reply-summary' => '[$2 $1] en [{{SERVER}} {{SITENAME}}] tiene respuestas nuevas.',
	'emailext-forum-reply-link-label' => 'Leer la respuesta',
	'emailext-forum-reply-view-all' => '[$1 Ver la discusión completa.]',
	'emailext-forumreply-unfollow-text' => '¿Ya no tienes interés en recibir estas actualizaciones? Haz clic [$1 aquí] para dejar de seguir [$2 esta] discusión sobre [{{SERVER}} {{SITENAME}}].',
];

$messages['fr'] = [
	'emailext-forum-subject' => 'Une nouvelle discussion a été ajoutée à $1 sur {{SITENAME}}.',
	'emailext-forum-summary' => 'Une nouvelle discussion a été ajoutée à [$1 $2] sur [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-button-label' => 'Voir la discussion',
	'emailext-forum-reply-subject' => '$1 sur {{SITENAME}} a de nouvelles réponses.',
	'emailext-forum-reply-summary' => '[$2 $1] sur [{{SERVER}} {{SITENAME}}] a de nouvelles réponses.',
	'emailext-forum-reply-link-label' => 'Lire les réponses',
	'emailext-forum-reply-view-all' => '[$1 Afficher toute la discussion]',
	'emailext-forumreply-unfollow-text' => 'Vous ne souhaitez plus être informé de ces mises à jour ? Cliquez [$1 ici] pour ne plus suivre [$2 cette discussion] sur [{{SERVER}} {{SITENAME}}].',
];

$messages['it'] = [
	'emailext-forum-subject' => 'C\'è una nuova discussione in $1 della {{SITENAME}}.',
	'emailext-forum-summary' => 'C\'è una nuova discussione in [$1 $2] della [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-button-label' => 'Vedi la discussione',
	'emailext-forum-reply-subject' => '$1 su {{SITENAME}} ha delle nuove risposte.',
	'emailext-forum-reply-summary' => '[$2 $1] su [{{SERVER}} {{SITENAME}}] ha delle nuove risposte.',
	'emailext-forum-reply-link-label' => 'Leggi le risposte',
	'emailext-forum-reply-view-all' => '[$1 Vedi l\'intera discussione.]',
	'emailext-forumreply-unfollow-text' => 'Non t\'interessa più ricevere questi aggiornamenti? Clicca [$1 qui] per smettere di seguire [$2 questa discussione] su [{{SERVER}} {{SITENAME}}].',
];

$messages['ja'] = [
	'emailext-forum-subject' => '{{SITENAME}}の$1に新しいスレッドが追加されました',
	'emailext-forum-summary' => '[{{SERVER}} {{SITENAME}}]の[$1 $2]に新しいスレッドが追加されました。',
	'emailext-forum-button-label' => 'スレッドを見る',
	'emailext-forum-reply-subject' => '{{SITENAME}}の$1に新しい返信があります',
	'emailext-forum-reply-summary' => '[{{SERVER}} {{SITENAME}}]の[$2 $1]に新しい返信があります。',
	'emailext-forum-reply-link-label' => '返信を読む',
	'emailext-forum-reply-view-all' => '[$1 スレッド全体を見る]',
	'emailext-forumreply-unfollow-text' => 'このような更新情報の受信をご希望でない場合は、[$1 こちら]をクリックして[{{SERVER}} {{SITENAME}}]の[$2 このスレッド]のフォローを解除してください。',
];

$messages['nl'] = [
	'emailext-forum-subject' => 'There is a new discussion on $1 on {{SITENAME}}.',
	'emailext-forum-summary' => 'There is a new discussion on [$1 $2] on [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-button-label' => 'See the discussion',
	'emailext-forum-reply-subject' => '$1 on {{SITENAME}} has new replies.',
	'emailext-forum-reply-summary' => '[$2 $1] on [{{SERVER}} {{SITENAME}}] has new replies.',
	'emailext-forum-reply-link-label' => 'Read the reply',
	'emailext-forum-reply-view-all' => '[$1 See the entire discussion.]',
	'emailext-forumreply-unfollow-text' => 'No longer interested in receiving these updates? Click [$1 here] to unfollow [$2 this discussion] on [{{SERVER}} {{SITENAME}}].',
];

$messages['pl'] = [
	'emailext-forum-subject' => 'Na forum $1 na {{SITENAME}} pojawiła się nowa dyskusja.',
	'emailext-forum-summary' => 'Na forum [$1 $2] na [{{SERVER}} {{SITENAME}}]  pojawiła się nowa dyskusja.',
	'emailext-forum-button-label' => 'Zobacz dyskusję',
	'emailext-forum-reply-subject' => 'Pojawiły się nowe odpowiedzi w $1 na {{SITENAME}}.',
	'emailext-forum-reply-summary' => 'Pojawiły się nowe odpowiedzi w [$2 $1] na [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-reply-link-label' => 'Przeczytaj odpowiedź',
	'emailext-forum-reply-view-all' => '[$1 Zobacz pełną dyskusję.]',
	'emailext-forumreply-unfollow-text' => 'Nie chcesz już otrzymywać powiadomień? Kliknij [$1 tutaj], aby przestać śledzić  [$2 tę dyskusję] na [{{SERVER}} {{SITENAME}}].',
];

$messages['pt'] = [
	'emailext-forum-subject' => 'Há uma nova discussão em $1 na {{SITENAME}}.',
	'emailext-forum-summary' => 'Há uma nova discussão em [$1 $2] na [{{SERVER}} {{SITENAME}}].',
	'emailext-forum-button-label' => 'Ver a discussão',
	'emailext-forum-reply-subject' => '$1 na {{SITENAME}} tem novas respostas.',
	'emailext-forum-reply-summary' => ' [$2 $1] na [{{SERVER}} {{SITENAME}}] tem novas respostas.',
	'emailext-forum-reply-link-label' => 'Leia a resposta',
	'emailext-forum-reply-view-all' => '[$1 Ver toda a discussão.]',
	'emailext-forumreply-unfollow-text' => 'Você não deseja mais receber essas atualizações? Clique [$1 aqui] para deixar de seguir [$2 esta discussão] na [{{SERVER}} {{SITENAME}}].',
];

$messages['ru'] = [
	'emailext-forum-subject' => 'Новое обсуждение в разделе $1 на {{SITENAME}}',
	'emailext-forum-summary' => 'В разделе [$1 $2] на [{{SERVER}} {{SITENAME}}] появилось новое обсуждение.',
	'emailext-forum-button-label' => 'Просмотреть обсуждение',
	'emailext-forum-reply-subject' => 'В теме «$1» на {{SITENAME}} появились новые ответы',
	'emailext-forum-reply-summary' => 'В теме [$2 $1] на [{{SERVER}} {{SITENAME}}] появились новые ответы.',
	'emailext-forum-reply-link-label' => 'Прочитать ответ',
	'emailext-forum-reply-view-all' => '[$1 Просмотреть обсуждение полностью.]',
	'emailext-forumreply-unfollow-text' => 'Не хотите больше получать эти сообщения? Нажмите [$1 здесь], чтобы перестать следить за [$2 обсуждением] на [{{SERVER}} {{SITENAME}}].',
];

$messages['zh-hans'] = [
	'emailext-forum-subject' => '在{{SITENAME}}网站的$1论坛上，大家正在对一个新的话题进行讨论。',
	'emailext-forum-summary' => '在[{{SERVER}} {{SITENAME}}]网站的[$1 $2]页面，大家正在对一个新的话题进行讨论。',
	'emailext-forum-button-label' => '查看讨论内容',
	'emailext-forum-reply-subject' => '{{SITENAME}}上的$1有新的回复。',
	'emailext-forum-reply-summary' => '[{{SERVER}} {{SITENAME}}]上的[$2 $1]有新的回复。',
	'emailext-forum-reply-link-label' => '阅读回复',
	'emailext-forum-reply-view-all' => '[$1 查看完整讨论]',
	'emailext-forumreply-unfollow-text' => '不想再收到这类更新？点击[$1 这里]取消关注[{{SERVER}} {{SITENAME}}]网站上的[$2 这个讨论]。',
];

$messages['zh-hant'] = [
	'emailext-forum-subject' => '在{{SITENAME}}的$1論壇上,大家正在對一個新的話題進行討論。',
	'emailext-forum-summary' => '\'\'\'在[{{SERVER}} {{SITENAME}}]的[$1 $2]上，大家正在討論一個新的話題。\'\'\'',
	'emailext-forum-button-label' => '查看討論內容',
	'emailext-forum-reply-subject' => '{{SITENAME}}上的$1有新的回覆。',
	'emailext-forum-reply-summary' => '\'\'\'[{{SERVER}} {{SITENAME}}]上的[$2 $1]有新的回覆。\'\'\'',
	'emailext-forum-reply-link-label' => '閱讀回覆',
	'emailext-forum-reply-view-all' => '[$1 查看完整討論。]',
	'emailext-forumreply-unfollow-text' => '不想再收到這類更新的訊息？按一下[$1這裡]取消在[{{SERVER}} {{SITENAME}}]監視[$2 這個討論]。',
];

$messages['zh-tw'] = [
	'emailext-forum-subject' => '在{{SITENAME}}的$1論壇上,大家正在對一個新的話題進行討論。',
	'emailext-forum-summary' => '\'\'\'在[{{SERVER}} {{SITENAME}}]的[$1 $2]上，大家正在討論一個新的話題。\'\'\'',
	'emailext-forum-button-label' => '查看討論',
	'emailext-forum-reply-subject' => '{{SITENAME}}上的$1有新的回覆。',
	'emailext-forum-reply-summary' => '\'\'\'[{{SERVER}} {{SITENAME}}]上的[$2 $1]有新的回覆。\'\'\'',
	'emailext-forum-reply-link-label' => '閲讀回覆',
	'emailext-forum-reply-view-all' => '[$1 查看整個討論內容]',
	'emailext-forumreply-unfollow-text' => '不想再收到這類更新的訊息？按一下[$1這裡]取消在[{{SERVER}} {{SITENAME}}]監視[$2 這個討論]。',
];

$messages['ko'] = [
	'emailext-forum-button-label' => '토론 보기',
	'emailext-forum-reply-link-label' => '댓글 보기',
	'emailext-forum-reply-subject' => '{{SITENAME}}의 $1 토론에 새 댓글이 있습니다',
	'emailext-forum-reply-summary' => '\'\'\'[{{SERVER}} {{SITENAME}}]의 [$2 $1] 토론에 새 댓글이 있습니다.\'\'\'',
	'emailext-forum-reply-view-all' => '[$1 토론 내용 전체 보기]',
	'emailext-forum-subject' => '{{SITENAME}}의 $1에 새 토론이 있습니다',
	'emailext-forum-summary' => '\'\'\'[{{SERVER}} {{SITENAME}}]의 [$1 $2]에 새 토론이 있습니다.\'\'\'',
	'emailext-forumreply-unfollow-text' => '더 이상 이에 관한 이메일 알림을 받고 싶지 않으신가요? [$1 이곳]에서 [{{SERVER}} {{SITENAME}}]의 [$2 토론]을 주시 해제하실 수 있습니다.',
];

$messages['zh-hk'] = [
	'emailext-forum-button-label' => '查看討論內容',
	'emailext-forum-reply-link-label' => '閱讀回覆',
	'emailext-forum-reply-subject' => '{{SITENAME}}上的$1有新的回覆。',
	'emailext-forum-reply-summary' => '\'\'\'[{{SERVER}} {{SITENAME}}]上的[$2 $1]有新的回覆。\'\'\'',
	'emailext-forum-reply-view-all' => '[$1 查看完整討論。]',
	'emailext-forum-subject' => '在{{SITENAME}}的$1論壇上,大家正在對一個新的話題進行討論。',
	'emailext-forum-summary' => '\'\'\'在[{{SERVER}} {{SITENAME}}]的[$1 $2]上，大家正在討論一個新的話題。\'\'\'',
	'emailext-forumreply-unfollow-text' => '不想再收到這類更新的訊息？按一下[$1這裡]取消在[{{SERVER}} {{SITENAME}}]監視[$2 這個討論]。',
];

