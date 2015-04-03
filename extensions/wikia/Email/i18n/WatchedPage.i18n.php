<?php
$messages = array();

$messages['en'] = array(
	'emailext-watchedpage-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-anonymous-editor' => 'A Wikia fan',
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
	'emailext-watchedpage-diff-button-text' => 'Text for button that, when clicked, navigates to the diff page referencing this change.',
	'emailext-watchedpage-article-link-text' => 'Call to action to visit the article page. $1 -> article url, $2 -> article title.',
	'emailext-watchedpage-view-all-changes' => 'Call to action to visit history of the article page. $1 -> article history url, $2 -> article title',
	'emailext-watchedpage-unfollow-text' => 'Asks the user if they want to stop following this page and provides a link to unfollow the page. $1 -> unfollow url, $2 article title',
);

$messages['de'] = array(
	'emailext-watchedpage-subject' => '$1 wurde auf {{SITENAME}} von $2 bearbeitet',
	'emailext-watchedpage-salutation' => 'Hallo $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] wurde auf [{{SERVER}} {{SITENAME}}] bearbeitet. Sieh es dir an!'''
",
	'emailext-watchedpage-anonymous-editor' => 'Ein Wikia-Fan',
	'emailext-watchedpage-diff-button-text' => 'Änderungen vergleichen',
	'emailext-watchedpage-article-link-text' => "[$1 Unter '''$2''' siehst du, was es Neues gibt]",
	'emailext-watchedpage-view-all-changes' => "[$1 Alle Änderungen an '''$2''' ansehen]",
	'emailext-watchedpage-unfollow-text' => 'Du möchtest diese Updates nicht mehr erhalten? Klicke [$1 hier], um $2 auf {{SITENAME}} nicht mehr zu folgen.',
);

$messages['es'] = array(
	'emailext-watchedpage-subject' => 'La página $1 en {{SITENAME}} ha sido editada por $2.',
	'emailext-watchedpage-salutation' => 'Hola, $1;',
	'emailext-watchedpage-article-edited' => "'''La página [$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido editada. ¡Revisa los cambios!!'''",
	'emailext-watchedpage-anonymous-editor' => 'Fan de Wikia',
	'emailext-watchedpage-diff-button-text' => 'Mostrar cambios',
	'emailext-watchedpage-article-link-text' => "[$1 Visita la página '''$2''' para ver qué hay nuevo].",
	'emailext-watchedpage-view-all-changes' => "[$1 Ver todos los cambios realizados en '''$2'''].",
	'emailext-watchedpage-unfollow-text' => '¿Ya no tienes interés en recibir estas actualizaciones? Haz clic [$1 aquí] para dejar de seguir la página $2 en {{SITENAME}}.',
);

$messages['fr'] = array(
	'emailext-watchedpage-subject' => '$2 a modifié 1 $ sur {{SITENAME}}.',
	'emailext-watchedpage-salutation' => 'Bonjour $1,',
	'emailext-watchedpage-article-edited' => "'''Quelqu'un a modifié [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez les modifications !'''",
	'emailext-watchedpage-anonymous-editor' => 'Fan de Wikia',
	'emailext-watchedpage-diff-button-text' => 'Comparer les modifications',
	'emailext-watchedpage-article-link-text' => "[$1 Rendez-vous sur '''$2''' pour voir ce qui a été modifié]",
	'emailext-watchedpage-view-all-changes' => "[$1 Afficher toutes les modifications apportées à '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'Vous ne souhaitez plus être informé de ces mises à jour ? Cliquez [$1 ici] pour ne plus suivre $2 sur {{SITENAME}}.',
);

$messages['it'] = array(
	'emailext-watchedpage-subject' => '$1 su {{SITENAME}} è stato modificato da $2.',
	'emailext-watchedpage-salutation' => 'Ciao $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] su [{{SERVER}} {{SITENAME}}] è stato modificato. Dacci un'occhiata!'''",
	'emailext-watchedpage-anonymous-editor' => 'Fan di Wikia',
	'emailext-watchedpage-diff-button-text' => 'Mostra cambiamenti',
	'emailext-watchedpage-article-link-text' => "[$1 Clicca su '''$2''' per vedere cosa c'è di nuovo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Vedi tutte le modifiche a '''$2''']",
	'emailext-watchedpage-unfollow-text' => "Non t'interessa più ricevere questi aggiornamenti? Clicca [$1 qui] per smettere di seguire $2 su {{SITENAME}}.",
);

$messages['ja'] = array(
	'emailext-watchedpage-subject' => '$2さんが{{SITENAME}}の$1を編集しました。',
	'emailext-watchedpage-salutation' => '$1さん',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}] の[$1 $2]に編集が加えられたようです。チェックしてみてましょう！'''",
	'emailext-watchedpage-anonymous-editor' => 'ウィキアファン',
	'emailext-watchedpage-diff-button-text' => '変更を比較する',
	'emailext-watchedpage-article-link-text' => "[$1 '''$2'''にアクセスして新しい内容をご確認ください]",
	'emailext-watchedpage-view-all-changes' => "[$1 '''$2'''へのすべての変更を見る]",
	'emailext-watchedpage-unfollow-text' => 'このような更新情報の受信をご希望でない場合は、[$1 こちら] をクリックして{{SITENAME}}の$2のフォローを解除してください。',
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
);

$messages['pl'] = array(
	'emailext-watchedpage-subject' => 'Dokonano edycji $1 na {{SITENAME}} przez $2.',
	'emailext-watchedpage-salutation' => 'Cześć $1,',
	'emailext-watchedpage-article-edited' => "'''Dokonano edycji [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-anonymous-editor' => 'Wikia fan',
	'emailext-watchedpage-diff-button-text' => 'Porównaj zmiany',
	'emailext-watchedpage-article-link-text' => "[$1 Przejdź do '''$2''' i zobacz co się zmieniło]",
	'emailext-watchedpage-view-all-changes' => "[$1 Zobacz wszystkie zmiany ''''$2''']",
	'emailext-watchedpage-unfollow-text' => 'Nie jesteś już zainteresowany otrzymywaniem powiadomień? Kliknij [$1 tutaj], aby zrezygnować ze śledzenia $2 na {{SITENAME}}.',
);

$messages['pt'] = array(
	'emailext-watchedpage-subject' => '$1 na {{SITENAME}} foi editado por $2',
	'emailext-watchedpage-salutation' => 'Olá $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] em [{{SERVER}} {{SITENAME}}] foi editado. Confira!'''",
	'emailext-watchedpage-anonymous-editor' => 'Um fã da Wikia',
	'emailext-watchedpage-diff-button-text' => 'Comparar mudanças',
	'emailext-watchedpage-article-link-text' => "[$1 Vá para '''$2''' para ver o que há de novo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Visualizar todas as alterações de '''$2''']",
	'emailext-watchedpage-unfollow-text' => 'Você não deseja mais receber essas atualizações? Clique em [$1 aqui] para deixar de seguir $2 em {{SITENAME}}.',
);

$messages['ru'] = array(
	'emailext-watchedpage-subject' => '$2 отредактировал(а) страницу «$1» на {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Здравствуйте, $1!',
	'emailext-watchedpage-article-edited' => "'''Страница [$1 «$2»] на [{{SERVER}} {{SITENAME}}] была отредактирована. Посмотрите правки!'''",
	'emailext-watchedpage-anonymous-editor' => 'Фанат Викия',
	'emailext-watchedpage-diff-button-text' => 'Сравнить изменения',
	'emailext-watchedpage-article-link-text' => "[Чтобы просмотреть новые правки, $1 перейдите к странице «'''$2'''».]",
	'emailext-watchedpage-view-all-changes' => "[$1 Просмотрите все правки статьи «'''$2'''».]",
	'emailext-watchedpage-unfollow-text' => 'Не хотите больше получать эти сообщения? Нажмите [$1 сюда], чтобы перестать следить за страницей «$2» на {{SITENAME}}.',
);

$messages['zh-hans'] = array(
	'emailext-watchedpage-subject' => '{{SITENAME}}上的$1由$2进行编辑过',
	'emailext-watchedpage-salutation' => '$1，您好，',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]上的[$1 $2]已被编辑。快来查看吧！'''",
	'emailext-watchedpage-anonymous-editor' => '一个Wikia粉丝',
	'emailext-watchedpage-diff-button-text' => '更改比较',
	'emailext-watchedpage-article-link-text' => "[$1 到'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看'''$2'''上的所有更改]",
	'emailext-watchedpage-unfollow-text' => '不再想接收这类更新内容？点击[$1 这里]取消对{{SITENAME}}上的$2页面的关注。',
);

$messages['zh-tw'] = array(
	'emailext-watchedpage-subject' => '{{SITENAME}}上的$1由$2進行編輯過',
	'emailext-watchedpage-salutation' => '$1，您好，',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]上的[$1 $2]已被編輯。快來查看吧！'''",
	'emailext-watchedpage-anonymous-editor' => '一個Wikia粉絲',
	'emailext-watchedpage-diff-button-text' => '更改比較',
	'emailext-watchedpage-article-link-text' => "[$1 到'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看'''$2'''上的所有更改]",
	'emailext-watchedpage-unfollow-text' => '不再想接收這類更新内容？按一下[$1 這裡]取消對{{SITENAME}}上的$2頁面的關注。',
);

