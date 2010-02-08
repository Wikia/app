<?php
/**
 * Blogs extension message file
 */

$messages = array();
$messages['en'] = array(
	'article-comments-anonymous' => 'Anonymous user',
	'article-comments-comments' => 'Comments',
	'article-comments-post' => 'Post comment',
	'article-comments-delete' => 'delete',
	'article-comments-edit' => 'edit',
	'article-comments-history' => 'history',
	'article-comments-error' => 'Comment could not be saved',
	'article-comments-undeleted-comment' => 'Undeleted comment for blog page $1',
	'article-comments-rc-comment' => 'Article comment ([[$1]])',
	'article-comments-rc-comments' => 'Article comments ([[$1]])',
	'article-comments-dsc' => 'Newest first',
	'article-comments-asc' => 'Newest last',
	'article-comments-login' => "<a href=\"$1\">Log in</a> to comment",
	'article-comments-zero-comments' => 'No comments yet!',
	'article-comments-toc-item' => 'Comments',
	'article-comments-comment-cannot-add' => 'You cannot add a comment to the article.',
	'enotif_subject_article_comment' => '$PAGEEDITOR has commented on "$PAGETITLE" on {{SITENAME}}',
	'enotif_body_article_comment' => 'Dear $WATCHINGUSERNAME,

$PAGEEDITOR made a comment on "$PAGETITLE". 

To see the comment thread, follow the link below:
$PAGETITLE_URL 

Please visit and edit often...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>
Dear $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR made a comment on "$PAGETITLE".
<br /><br />
To see the comment thread, follow this link: <a href="$PAGETITLE_URL">$PAGETITLE</a> 
<br /><br />
Please visit and edit often...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li>Want to control which emails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">{{ns:special}}:Preferences<a>.</li>
</ul>
</p>',
);

$messages['fi'] = array(
	'article-comments-zero-comments' => "Ei kommentteja vielä!",
	'article-comments-post' => "Lähetä kommentti",
	'article-comments-comments' => "Kommentit",
	'article-comments-dsc' => "Uusimmat ensin",
	'article-comments-asc' => "Uusimmat viimeisenä",
	'article-comments-login' => "<a href=\"$1\">Kirjaudu sisään</a> kommetoidaksesi",
	'article-comments-anonymous' => "Anonyymi käyttäjä",
	'article-comments-delete' => "poista",
	'article-comments-history' => "historiasta",
	'article-comments-undeleted-comment' => "Kommenttia ei poistettu blogisivulta $1"
);

$messages['de'] = array(
	'article-comments-zero-comments' => 'Noch keine Kommentare!',
	'article-comments-post' => 'Kommentieren',
	'article-comments-comments' => 'Kommentare',
	'article-comments-dsc' => 'Neue Beiträge oben',
	'article-comments-asc' => 'Neue Beiträge unten',
	'article-comments-login' => 'Zum Kommentieren <a href="$1">anmelden</a>.',
	'article-comments-anonymous' => 'Unangemeldeter Benutzer',
	'article-comments-delete' => 'löschen',
	'article-comments-undeleted-comment' => 'Kommentar zu Blog-Beitrag $1 wiederhergestellt.',
);

$messages['es'] = array(
	'article-comments-zero-comments' => '¡No hay comentarios aún!',
	'article-comments-post' => 'Dejar comentario',
	'article-comments-comments' => 'Comentarios',
	'article-comments-dsc' => 'Nuevos comentarios al principio',
	'article-comments-asc' => 'Nuevos comentarios al final',
	'article-comments-login' => '<a href="$1">Identifícate</a> para dejar un comentario',
	'article-comments-anonymous' => 'Usuario anónimo',
	'article-comments-delete' => '(borrar)',
	'article-comments-history' => '(Historial)',
	'article-comments-edit' => '(editar)',
	'article-comments-undeleted-comment' => 'Comentario no borrado para la página del blog $1',
);

$messages['ja'] = array(
	'article-comments-zero-comments' => 'まだコメントはありません',
	'article-comments-post' => 'コメントを投稿',
	'article-comments-comments' => 'コメント',
	'article-comments-dsc' => '新しいコメントから表示',
	'article-comments-asc' => '古いコメントから表示',
	'article-comments-login' => 'コメントするには<a href="$1">ログイン</a>する必要があります',
	'article-comments-anonymous' => '匿名利用者',
	'article-comments-delete' => '削除',
	'article-comments-history' => '履歴',
	'article-comments-undeleted-comment' => 'ブログの記事 $1 へのコメントを復帰',
);

$messages['fa'] = array(
	'article-comments-zero-comments' => 'هیچ نظری نوشته نشده است!',
	'article-comments-post' => 'ارسال نظر',
	'article-comments-comments' => 'نظرات',
	'article-comments-login' => 'برای نظر دادن <a href="$1">وارد سیستم شوید</a>.',
	'article-comments-anonymous' => 'کاربر گمنام',
	'article-comments-delete' => 'حذف',
	'article-comments-history' => 'تاریخچه',
	'article-comments-undeleted-comment' => 'نظر برای صفحۀ وبلاگ $1 احیاء شد',
);

$messages['fr'] = array(
	'article-comments-zero-comments' => 'Encore aucun commentaire.',
	'article-comments-post' => 'Ajouter un commentaire',
	'article-comments-comments' => 'Commentaires',
	'article-comments-dsc' => 'Nouveaux messages en premier',
	'article-comments-asc' => 'Nouveaux messages en dernier',
	'article-comments-login' => '<a href="$1">Indentifiez-vous</a> pour faire un commenaire',
	'article-comments-anonymous' => 'Utilisateur anonyme',
	'article-comments-delete' => 'Supprimer',
	'article-comments-undeleted-comment' => 'Commentaire de l\'article de blog $1 restauré',
);

$messages['it'] = array(
	'article-comments-zero-comments' => 'Nessun commento!',
	'article-comments-post' => 'Lascia un commento',
	'article-comments-comments' => 'Commenti',
	'article-comments-dsc' => 'Dal più recente',
	'article-comments-asc' => 'Dal più vecchio',
	'article-comments-login' => '<a href="$1">Accedi per lasciare un commenti</a>',
	'article-comments-anonymous' => 'Utente anonimo',
	'article-comments-delete' => 'Cancella',
	'article-comments-undeleted-comment' => 'Commenti non cancellati della pagina $1',
);

$messages['pl'] = array(
	'article-comments-zero-comments' => 'Nikt jeszcze nie skomentował!',
	'article-comments-post' => 'Wyślij komentarz',
	'article-comments-comments' => 'Komentarze',
	'article-comments-dsc' => 'Najnowsze pierwsze',
	'article-comments-asc' => 'Najnowsze ostatnie',
	'article-comments-login' => '<a href="$1">Zaloguj się</a>, aby komentować',
	'article-comments-anonymous' => 'Anonimowy użytkownik',
	'article-comments-delete' => 'usuń',
	'article-comments-edit' => 'edytuj',
	'article-comments-history' => 'historia',
	'article-comments-undeleted-comment' => 'Usunięcie komentarza na stronie $1 blogu.',
);
