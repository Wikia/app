<?php
$messages = array();

$messages['en'] = array(
	'emailext-watchedpage-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-anonymous-editor' => 'A Wikia fan',
	'emailext-watchedpage-no-summary' => 'No edit summary was given',
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-article-link-text' => "[$1 Head over to '''$2''' to see what's new]",
	'emailext-watchedpage-view-all-changes' => "[$1 View all changes to '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'No longer interested in receiving these updates? Click [$1 here] to unfollow $2 on {{SITENAME}}.',
);

$messages['qqq'] = array(
	'emailext-watchedpage-subject' => 'Subject line for watched article email. $1 -> article name, $2 -> username of user who edited the article',
	'emailext-watchedpage-salutation' => "Email greeting. $1 is the recipient's username.",
	'emailext-watchedpage-article-edited' => 'Message to the user that an article they are following has been edited. $1 -> article url, $2 -> article title, $3 -> wikia url',
	'emailext-watchedpage-anonymous-editor' => 'Phrase used in place of a username when the page was edited by an anonymous (logged out) user.',
	'emailext-watchedpage-no-summary' => 'Message shown when the editor did not leave an edit summary',
	'emailext-watchedpage-diff-button-text' => 'Text for button that, when clicked, navigates to the diff page referencing this change.',
	'emailext-watchedpage-article-link-text' => 'Call to action to visit the article page. $1 -> article url, $2 -> article title.',
	'emailext-watchedpage-view-all-changes' => 'Call to action to visit history of the article page. $1 -> article history url, $2 -> article title',
	'emailext-watchedpage-unfollow-text' => 'Asks the user if they want to stop following this page and provides a link to unfollow the page. $1 -> unfollow url, $2 article title',
);

$messages['de'] = array(
	'emailext-watchedpage-subject' => '{{SITENAME}}: Die Seite „$1“ wurde von $2 bearbeitet',
	'emailext-watchedpage-salutation' => 'Hallo $1,',
	'emailext-watchedpage-article-edited' => "'''Die [{{SERVER}} {{SITENAME}}]-Seite [$1 $2] wurde bearbeitet. Sieh es dir an!'''",
	'emailext-watchedpage-anonymous-editor' => 'Ein Wikia-Fan',
	'emailext-watchedpage-diff-button-text' => 'Änderungen vergleichen',
	'emailext-watchedpage-article-link-text' => "[$1 Unter '''$2''' siehst du, was es Neues gibt]",
	'emailext-watchedpage-view-all-changes' => "[$1 Alle Änderungen an '''$2''' ansehen]",
	'emailext-watchedpage-unfollow-text' => 'Du möchtest diese Updates nicht mehr erhalten? Klicke [$1 hier], um $2 auf {{SITENAME}} nicht mehr zu folgen.',
	'emailext-watchedpage-no-summary' => 'Es wurde keine Zusammenfassung der Bearbeitung angegeben.',
);

$messages['es'] = array(
	'emailext-watchedpage-subject' => 'La página $1 en {{SITENAME}} ha sido editada por $2.',
	'emailext-watchedpage-salutation' => 'Hola, $1;',
	'emailext-watchedpage-article-edited' => "'''La página [$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido editada. ¡Revisa los cambios!'''",
	'emailext-watchedpage-anonymous-editor' => 'Un fan de Wikia',
	'emailext-watchedpage-diff-button-text' => 'Mostrar cambios',
	'emailext-watchedpage-article-link-text' => "[$1 Visita la página '''$2''' para ver qué hay de nuevo].",
	'emailext-watchedpage-view-all-changes' => "[$1 Ver todos los cambios realizados en '''$2'''].",
	'emailext-watchedpage-unfollow-text' => '¿Ya no tienes interés en recibir estas actualizaciones? Haz clic [$1 aquí] para dejar de seguir la página $2 en {{SITENAME}}.',
	'emailext-watchedpage-no-summary' => 'Resumen de ediciones no fue entregado',
);

$messages['fr'] = array(
	'emailext-watchedpage-subject' => '$2 a modifié $1 sur {{SITENAME}}.',
	'emailext-watchedpage-salutation' => 'Bonjour $1,',
	'emailext-watchedpage-article-edited' => "'''Quelqu'un a modifié [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez les modifications !'''",
	'emailext-watchedpage-anonymous-editor' => 'Un fan de Wikia',
	'emailext-watchedpage-diff-button-text' => 'Comparer les modifications',
	'emailext-watchedpage-article-link-text' => "[$1 Rendez-vous sur '''$2''' pour voir ce qui a été modifié]",
	'emailext-watchedpage-view-all-changes' => "[$1 Affichez toutes les modifications apportées à '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'Vous ne souhaitez plus être informé de ces mises à jour ? Cliquez [$1 ici] pour ne plus suivre $2 sur {{SITENAME}}.',
	'emailext-watchedpage-no-summary' => "Aucun résumé des modifications n'a été fourni.",
);

$messages['it'] = array(
	'emailext-watchedpage-subject' => '$1 di {{SITENAME}} è stato modificato da $2',
	'emailext-watchedpage-salutation' => 'Ciao, $1.',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] di [{{SERVER}} {{SITENAME}}] è stato modificato. Dacci un'occhiata!'''",
	'emailext-watchedpage-anonymous-editor' => 'Un fan di Wikia',
	'emailext-watchedpage-diff-button-text' => 'Mostra cambiamenti',
	'emailext-watchedpage-article-link-text' => "[$1 Clicca su '''$2''' per vedere cosa c'è di nuovo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Vedi tutte le modifiche a '''$2''']",
	'emailext-watchedpage-unfollow-text' => "Non t'interessa più ricevere questi aggiornamenti? Clicca [$1 qui] per smettere di seguire $2 su {{SITENAME}}.",
	'emailext-watchedpage-no-summary' => 'Non è stato fornito un riassunto delle modifiche',
);

$messages['ja'] = array(
	'emailext-watchedpage-subject' => '$2さんが{{SITENAME}}の$1を編集しました。',
	'emailext-watchedpage-salutation' => '$1さん',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}] の[$1 $2]に編集が加えられたようです。最新の記事をチェックしてみてましょう！'''",
	'emailext-watchedpage-anonymous-editor' => 'ウィキアファン',
	'emailext-watchedpage-diff-button-text' => '変更を比較する',
	'emailext-watchedpage-article-link-text' => "[$1 '''$2'''にアクセスして最新の内容を確認する]",
	'emailext-watchedpage-view-all-changes' => "[$1 '''$2'''で行われたすべての変更を見る]",
	'emailext-watchedpage-unfollow-text' => 'このような更新情報の受信をご希望でない場合は、<br />[$1 こちら] をクリックして{{SITENAME}}の$2のフォローを解除してください。',
	'emailext-watchedpage-no-summary' => '編集の要約はありません。',
);

$messages['nl'] = array(
	'emailext-watchedpage-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-anonymous-editor' => 'A Wikia fan',
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-article-link-text' => "[$1 Head over to '''$2''' to see what's new]",
	'emailext-watchedpage-view-all-changes' => "[$1 View all changes to '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'No longer interested in receiving these updates? Click [$1 here] to unfollow $2 on {{SITENAME}}.',
	'emailext-watchedpage-no-summary' => 'No edit summary was given',
);

$messages['pl'] = array(
	'emailext-watchedpage-subject' => 'Użytkownik $2 dokonał edycji $1 na {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Cześć $1,',
	'emailext-watchedpage-article-edited' => "'''Dokonano edycji [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-anonymous-editor' => 'Fan portalu Wikia',
	'emailext-watchedpage-diff-button-text' => 'Porównaj zmiany',
	'emailext-watchedpage-article-link-text' => "[$1 Przejdź do '''$2''' i zobacz co się zmieniło]",
	'emailext-watchedpage-view-all-changes' => "[$1 Zobacz wszystkie zmiany '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'Nie jesteś już zainteresowany otrzymywaniem powiadomień? Kliknij [$1 tutaj], aby zrezygnować ze śledzenia $2 na {{SITENAME}}.',
	'emailext-watchedpage-no-summary' => 'Brak podsumowania zmian',
);

$messages['pt'] = array(
	'emailext-watchedpage-subject' => '$1 foi editado por $2 na {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Olá $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] em [{{SERVER}} {{SITENAME}}] foi editado. Confira!'''",
	'emailext-watchedpage-anonymous-editor' => 'Um fã da Wikia',
	'emailext-watchedpage-diff-button-text' => 'Comparar mudanças',
	'emailext-watchedpage-article-link-text' => "[$1 Vá para '''$2''' para ver o que há de novo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Visualizar todas as alterações de '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'Você não deseja mais receber essas atualizações? Clique [$1 aqui] para deixar de seguir $2 na {{SITENAME}}.',
	'emailext-watchedpage-no-summary' => 'Não foi dado nenhum resumo',
);

$messages['ru'] = array(
	'emailext-watchedpage-subject' => '$2 отредактировал(а) страницу $1 на {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Здравствуйте, $1!',
	'emailext-watchedpage-article-edited' => "'''Страница [$1 $2] на [{{SERVER}} {{SITENAME}}] была отредактирована. Посмотрите правки!'''",
	'emailext-watchedpage-anonymous-editor' => 'Фанат Викия',
	'emailext-watchedpage-diff-button-text' => 'Сравнить изменения',
	'emailext-watchedpage-article-link-text' => "[$1 Для просмотра новых правок перейдите к «'''$2'''».]",
	'emailext-watchedpage-view-all-changes' => "[$1 Просмотрите все правки статьи «'''$2'''».]",
	'emailext-watchedpage-unfollow-text' => 'Не хотите больше получать эти сообщения? Перейдите [$1 по ссылке], чтобы перестать следить за страницей «$2» на {{SITENAME}}.',
	'emailext-watchedpage-no-summary' => 'Участник не дал пояснений к данной правке.',
);

$messages['zh-hans'] = array(
	'emailext-watchedpage-subject' => '{{SITENAME}}上的$1由$2进行编辑过',
	'emailext-watchedpage-salutation' => '$1，您好！',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]上的[$1 $2]已被编辑过。快来查看吧！'''",
	'emailext-watchedpage-anonymous-editor' => 'Wikia粉丝',
	'emailext-watchedpage-diff-button-text' => '查看更改之处',
	'emailext-watchedpage-article-link-text' => "[$1 到'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看'''$2'''上的所有更改]",
	'emailext-watchedpage-unfollow-text' => '不想再接收这类更新内容？点击[$1 这里]取消对{{SITENAME}}上$2页面的关注。',
	'emailext-watchedpage-no-summary' => '没有编辑概要',
);

$messages['zh-tw'] = array(
	'emailext-watchedpage-subject' => '{{SITENAME}}上的$1由$2進行編輯過',
	'emailext-watchedpage-salutation' => '$1，您好！',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]上的[$1 $2]已被編輯。快來查看吧！'''",
	'emailext-watchedpage-anonymous-editor' => 'Wikia粉絲',
	'emailext-watchedpage-diff-button-text' => '查看更改之處',
	'emailext-watchedpage-article-link-text' => "[$1 到'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看'''$2'''上的所有更改]",
	'emailext-watchedpage-unfollow-text' => '不想再接收這類更新内容？点击[$1 這裡]取消對{{SITENAME}}上$2頁面的關注。',
	'emailext-watchedpage-no-summary' => '沒有編輯概要',
);

