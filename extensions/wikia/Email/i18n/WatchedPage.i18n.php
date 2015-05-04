<?php
$messages = array();

$messages['en'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-article-protected-subject' => '$1 on {{SITENAME}} has been protected by $2',
	'emailext-watchedpage-article-unprotected-subject' => '$1 on {{SITENAME}} has been unprotected by $2',
	'emailext-watchedpage-article-renamed-subject' => '$1 on {{SITENAME}} has been renamed by $2',
	'emailext-watchedpage-article-deleted-subject' => '$1 on {{SITENAME}} has been deleted by $2',
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-article-protected' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been protected. Check it out!'''",
	'emailext-watchedpage-article-unprotected' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been unprotected. Check it out!'''",
	'emailext-watchedpage-article-renamed' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been renamed. Check it out!'''",
	'emailext-watchedpage-article-deleted' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been deleted.'''",
	'emailext-watchedpage-no-summary' => 'No edit summary was given',
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-deleted-button-text' => 'See article',
	'emailext-watchedpage-article-link-text' => "[$1 Head over to '''$2''' to see what's new]",
	'emailext-watchedpage-view-all-changes' => "[$1 View all changes to '''$2''']",
);

// TODO qqq
$messages['qqq'] = array(
	'emailext-watchedpage-article-edited-subject' => 'Subject line for watched article email. $1 -> article name, $2 -> username of user who edited the article',
	'emailext-watchedpage-salutation' => "Email greeting. $1 is the recipient's username.",
	'emailext-watchedpage-article-edited' => 'Message to the user that an article they are following has been edited. $1 -> article url, $2 -> article title, $3 -> wikia url',
	'emailext-watchedpage-no-summary' => 'Message shown when the editor did not leave an edit summary',
	'emailext-watchedpage-diff-button-text' => 'Text for button that, when clicked, navigates to the diff page referencing this change.',
	'emailext-watchedpage-article-link-text' => 'Call to action to visit the article page. $1 -> article url, $2 -> article title.',
	'emailext-watchedpage-view-all-changes' => 'Call to action to visit history of the article page. $1 -> article history url, $2 -> article title',
);

$messages['de'] = array(
	'emailext-watchedpage-article-edited-subject' => '{{SITENAME}}: Die Seite „$1“ wurde von $2 bearbeitet',
	'emailext-watchedpage-salutation' => 'Hallo $1,',
	'emailext-watchedpage-article-edited' => "'''Die [{{SERVER}} {{SITENAME}}]-Seite [$1 $2] wurde bearbeitet. Sieh es dir an!'''",
	'emailext-watchedpage-diff-button-text' => 'Änderungen vergleichen',
	'emailext-watchedpage-article-link-text' => "[$1 Unter '''$2''' siehst du, was es Neues gibt]",
	'emailext-watchedpage-view-all-changes' => "[$1 Alle Änderungen an '''$2''' ansehen]",
	'emailext-watchedpage-no-summary' => 'Es wurde keine Zusammenfassung der Bearbeitung angegeben.',
);

$messages['es'] = array(
	'emailext-watchedpage-article-edited-subject' => 'La página $1 en {{SITENAME}} ha sido editada por $2.',
	'emailext-watchedpage-salutation' => 'Hola, $1;',
	'emailext-watchedpage-article-edited' => "'''La página [$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido editada. ¡Revisa los cambios!'''",
	'emailext-watchedpage-diff-button-text' => 'Mostrar cambios',
	'emailext-watchedpage-article-link-text' => "[$1 Visita la página '''$2''' para ver qué hay de nuevo].",
	'emailext-watchedpage-view-all-changes' => "[$1 Ver todos los cambios realizados en '''$2'''].",
	'emailext-watchedpage-no-summary' => 'Resumen de ediciones no fue entregado',
);

$messages['fr'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2 a modifié $1 sur {{SITENAME}}.',
	'emailext-watchedpage-salutation' => 'Bonjour $1,',
	'emailext-watchedpage-article-edited' => "'''Quelqu'un a modifié [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez les modifications !'''",
	'emailext-watchedpage-diff-button-text' => 'Comparer les modifications',
	'emailext-watchedpage-article-link-text' => "[$1 Rendez-vous sur '''$2''' pour voir ce qui a été modifié]",
	'emailext-watchedpage-view-all-changes' => "[$1 Affichez toutes les modifications apportées à '''$2''']",
	'emailext-watchedpage-no-summary' => "Aucun résumé des modifications n'a été fourni.",
);

$messages['it'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 di {{SITENAME}} è stato modificato da $2',
	'emailext-watchedpage-salutation' => 'Ciao, $1.',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] di [{{SERVER}} {{SITENAME}}] è stato modificato. Dacci un'occhiata!'''",
	'emailext-watchedpage-diff-button-text' => 'Mostra cambiamenti',
	'emailext-watchedpage-article-link-text' => "[$1 Clicca su '''$2''' per vedere cosa c'è di nuovo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Vedi tutte le modifiche a '''$2''']",
	'emailext-watchedpage-no-summary' => 'Non è stato fornito un riassunto delle modifiche',
);

$messages['ja'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2さんが{{SITENAME}}の$1を編集しました。',
	'emailext-watchedpage-salutation' => '$1さん',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}] の[$1 $2]に編集が加えられたようです。最新の記事をチェックしてみてましょう！'''",
	'emailext-watchedpage-diff-button-text' => '変更を比較する',
	'emailext-watchedpage-article-link-text' => "[$1 '''$2'''にアクセスして最新の内容を確認する]",
	'emailext-watchedpage-view-all-changes' => "[$1 '''$2'''で行われたすべての変更を見る]",
	'emailext-watchedpage-no-summary' => '編集の要約はありません。',
);

$messages['nl'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-article-link-text' => "[$1 Head over to '''$2''' to see what's new]",
	'emailext-watchedpage-view-all-changes' => "[$1 View all changes to '''$2''']",
	'emailext-watchedpage-no-summary' => 'No edit summary was given',
);

$messages['pl'] = array(
	'emailext-watchedpage-article-edited-subject' => 'Użytkownik $2 dokonał edycji $1 na {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Cześć $1,',
	'emailext-watchedpage-article-edited' => "'''Dokonano edycji [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-diff-button-text' => 'Porównaj zmiany',
	'emailext-watchedpage-article-link-text' => "[$1 Przejdź do '''$2''' i zobacz co się zmieniło]",
	'emailext-watchedpage-view-all-changes' => "[$1 Zobacz wszystkie zmiany '''$2''']",
	'emailext-watchedpage-no-summary' => 'Brak podsumowania zmian',
);

$messages['pt'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 foi editado por $2 na {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Olá $1,',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] em [{{SERVER}} {{SITENAME}}] foi editado. Confira!'''",
	'emailext-watchedpage-diff-button-text' => 'Comparar mudanças',
	'emailext-watchedpage-article-link-text' => "[$1 Vá para '''$2''' para ver o que há de novo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Visualizar todas as alterações de '''$2''']",
	'emailext-watchedpage-no-summary' => 'Não foi dado nenhum resumo',
);

$messages['ru'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2 отредактировал(а) страницу $1 на {{SITENAME}}',
	'emailext-watchedpage-salutation' => 'Здравствуйте, $1!',
	'emailext-watchedpage-article-edited' => "'''Страница [$1 $2] на [{{SERVER}} {{SITENAME}}] была отредактирована. Посмотрите правки!'''",
	'emailext-watchedpage-diff-button-text' => 'Сравнить изменения',
	'emailext-watchedpage-article-link-text' => "[$1 Для просмотра новых правок перейдите к «'''$2'''».]",
	'emailext-watchedpage-view-all-changes' => "[$1 Просмотрите все правки статьи «'''$2'''».]",
	'emailext-watchedpage-no-summary' => 'Участник не дал пояснений к данной правке.',
);

$messages['zh-hans'] = array(
	'emailext-watchedpage-article-edited-subject' => '{{SITENAME}}上的$1由$2进行编辑过',
	'emailext-watchedpage-salutation' => '$1，您好！',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]上的[$1 $2]已被编辑过。快来查看吧！'''",
	'emailext-watchedpage-diff-button-text' => '查看更改之处',
	'emailext-watchedpage-article-link-text' => "[$1 到'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看'''$2'''上的所有更改]",
	'emailext-watchedpage-no-summary' => '没有编辑概要',
);

$messages['zh-tw'] = array(
	'emailext-watchedpage-article-edited-subject' => '{{SITENAME}}上的$1由$2進行編輯過',
	'emailext-watchedpage-salutation' => '$1，您好！',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]上的[$1 $2]已被編輯。快來查看吧！'''",
	'emailext-watchedpage-diff-button-text' => '查看更改之處',
	'emailext-watchedpage-article-link-text' => "[$1 到'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看'''$2'''上的所有更改]",
	'emailext-watchedpage-no-summary' => '沒有編輯概要',
);

