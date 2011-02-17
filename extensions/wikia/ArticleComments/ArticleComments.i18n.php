<?php
/**
 * Article Comments extension message file
 *
 * Also be aware that many oasis specific i18n messages for comments
 * reside in extensions/wikia/Oasis/Oasis.i18n.php
 */

$messages = array();
$messages['en'] = array(
	'article-comments-anonymous' => 'Anonymous user',
	'article-comments-comments' => 'Comments ($1)',
	'article-comments-post' => 'Post comment',
	'article-comments-delete' => 'delete',
	'article-comments-edit' => 'edit',
	'article-comments-history' => 'history',
	'article-comments-error' => 'Comment could not be saved',
	'article-comments-undeleted-comment' => 'Undeleted comment for blog page $1',
	'article-comments-rc-comment' => 'Article comment ([[$1]])',
	'article-comments-rc-comments' => 'Article comments ([[$1]])',
	'article-comments-fblogin' => 'Please <a href="$1">log in and connect with Facebook</a> to post a comment on this wiki!',
	'article-comments-fbconnect' => 'Please <a href="$1">connect this account with Facebook</a> to comment!',
	'article-comments-rc-blog-comment' => 'Blog comment ([[$1]])',
	'article-comments-rc-blog-comments' => 'Blog comments ([[$1]])',
	'article-comments-login' => 'Please <a href="$1">log in</a> to post a comment on this wiki.',
	'article-comments-toc-item' => 'Comments',
	'article-comments-comment-cannot-add' => 'You cannot add a comment to the article.',
	'article-comments-reply' => 'Reply',
	'article-comments-show-all' => 'Show all comments',
	'article-comments-prev-page' => 'Prev',
	'article-comments-next-page' => 'Next',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'The parent article / parent comment has been deleted.',
	'article-comments-empty-comment' => "You can't post an empty comment. <a href='$1'>Delete it instead?</a>",
	'enotif_subject_article_comment' => '$PAGEEDITOR has commented on "$PAGETITLE" on {{SITENAME}}',
	'enotif_body_article_comment' => 'Dear $WATCHINGUSERNAME,

$PAGEEDITOR made a comment on "$PAGETITLE". 

To see the comment thread, follow the link below:
$PAGETITLE_URL 

Please visit and edit often...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Dear $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR made a comment on "$PAGETITLE".
<br /><br />
To see the comment thread, follow this link: <a href="$PAGETITLE_URL">$PAGETITLE</a> 
<br /><br />
Please visit and edit often...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Want to control which emails you receive? <a href="{{fullurl:Special:Preferences}}">Update your Preferences<a>.</li>
</ul>
</p>',
);

/** German (Deutsch) */
$messages['de'] = array(
	'article-comments-anonymous' => 'Unangemeldeter Benutzer',
	'article-comments-comments' => 'Kommentare ($1)',
	'article-comments-post' => 'Kommentieren',
	'article-comments-delete' => 'löschen',
	'article-comments-undeleted-comment' => 'Kommentar zu Blog-Beitrag $1 wiederhergestellt.',
	'article-comments-login' => 'Zum Kommentieren <a href="$1">anmelden</a>.',
);

/** Spanish (Español) */
$messages['es'] = array(
	'article-comments-anonymous' => 'Usuario anónimo',
	'article-comments-comments' => 'Comentarios ($1)',
	'article-comments-post' => 'Dejar comentario',
	'article-comments-delete' => '(borrar)',
	'article-comments-edit' => '(editar)',
	'article-comments-history' => '(Historial)',
	'article-comments-undeleted-comment' => 'Comentario no borrado para la página del blog $1',
	'article-comments-login' => '<a href="$1">Identifícate</a> para dejar un comentario',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'article-comments-anonymous' => 'کاربر گمنام',
	'article-comments-comments' => 'نظرات',
	'article-comments-post' => 'ارسال نظر',
	'article-comments-delete' => 'حذف',
	'article-comments-history' => 'تاریخچه',
	'article-comments-undeleted-comment' => 'نظر برای صفحۀ وبلاگ $1 احیاء شد',
	'article-comments-login' => 'برای نظر دادن <a href="$1">وارد سیستم شوید</a>.',
);

/** Finnish (Suomi) */
$messages['fi'] = array(
	'article-comments-anonymous' => 'Anonyymi käyttäjä',
	'article-comments-comments' => 'Kommentit ($1)',
	'article-comments-post' => 'Lähetä kommentti',
	'article-comments-delete' => 'poista',
	'article-comments-history' => 'historiasta',
	'article-comments-undeleted-comment' => 'Kommenttia ei poistettu blogisivulta $1',
	'article-comments-login' => '<a href="$1">Kirjaudu sisään</a> kommetoidaksesi',
);

/** French (Français) */
$messages['fr'] = array(
	'article-comments-anonymous' => 'Utilisateur anonyme',
	'article-comments-comments' => 'Commentaires ($1)',
	'article-comments-post' => 'Ajouter un commentaire',
	'article-comments-delete' => 'Supprimer',
	'article-comments-undeleted-comment' => "Commentaire de l'article de blog $1 restauré",
	'article-comments-login' => '<a href="$1">Indentifiez-vous</a> pour faire un commenaire',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'article-comments-anonymous' => 'Utente anonimo',
	'article-comments-comments' => 'Commenti ($1)',
	'article-comments-post' => 'Lascia un commento',
	'article-comments-delete' => 'Cancella',
	'article-comments-undeleted-comment' => 'Commenti non cancellati della pagina $1',
	'article-comments-login' => '<a href="$1">Accedi per lasciare un commenti</a>',
);

/** Japanese (日本語) */
$messages['ja'] = array(
	'article-comments-anonymous' => '匿名利用者',
	'article-comments-comments' => 'コメント ($1)',
	'article-comments-post' => 'コメントを投稿',
	'article-comments-delete' => '削除',
	'article-comments-history' => '履歴',
	'article-comments-undeleted-comment' => 'ブログの記事 $1 へのコメントを復帰',
	'article-comments-login' => 'コメントするには<a href="$1">ログイン</a>する必要があります',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'article-comments-anonymous' => 'Anonieme gebruiker',
	'article-comments-comments' => 'Opmerkingen ($1)',
	'article-comments-post' => 'Opmerking plaatsen',
	'article-comments-delete' => 'verwijderen',
	'article-comments-edit' => 'bewerken',
	'article-comments-history' => 'geschiedenis',
	'article-comments-error' => 'De opmerking kon niet opgeslagen worden',
	'article-comments-undeleted-comment' => 'Heeft een opmerking op blogpagina $1 teruggeplaatst',
	'article-comments-rc-comment' => 'Opmerking bij pagina ([[$1]])',
	'article-comments-rc-comments' => 'Opmerkingen bij pagina ([[$1]])',
	'article-comments-fblogin' => '<a href="$1">Meld u aan en verbind met Facebook</a> om een opmerking in deze wiki te plaatsen.',
	'article-comments-fbconnect' => '<a href="$1">Verbind deze gebruiker met Facebook</a> om opmerkingen te plaatsen.',
	'article-comments-rc-blog-comment' => 'Opmerking bij blog ([[$1]])',
	'article-comments-rc-blog-comments' => 'Opmerkingen bij blog ([[$1]])',
	'article-comments-login' => '<a href="$1">Meld u aan</a> om een opmerking in deze wiki te kunnen plaatsen.',
	'article-comments-toc-item' => 'Opmerkingen',
	'article-comments-comment-cannot-add' => 'U kunt geen opmerkingen bij de pagina plaatsen.',
	'article-comments-reply' => 'Antwoorden',
	'article-comments-show-all' => 'Alle opmerkingen weergeven',
	'article-comments-prev-page' => 'Vorige',
	'article-comments-next-page' => 'Volgende',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'De bovenliggende pagina is verwijderd.',
	'article-comments-empty-comment' => "U kunt geen opmerking zonder inhoud plaatsen. <a href='$1'>In plaats daarvan verwijderen?</a>",
	'enotif_subject_article_comment' => '$PAGEEDITOR heeft een opmerking geplaatst bij "$PAGETITLE" op {{SITENAME}}',
	'enotif_body_article_comment' => 'Beste $WATCHINGUSERNAME,

$ PAGEEDITOR heeft een opmerking geplaatst bij "$PAGETITLE".

U kunt de discussie bekijken via de volgende verwijzing:
$PAGETITLE_URL

Kom alstublieft vaak langs en bewerk veelvuldig...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Beste $WATCHINGUSERNAME,
<br /><br />
$ PAGEEDITOR heeft een opmerking geplaatst bij "$PAGETITLE".
<br /><br />
U kunt de discussie bekijken via de volgende verwijzing: <a href="$PAGETITLE_URL">$PAGETITLE</a> 
<br /><br />
Kom alstublieft vaak langs en bewerk veelvuldig...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Wilt u bepalen welke e-mails u ontvangt? <a href="{{fullurl:{{ns:special}}:Preferences}}">Pas dan uw Voorkeuren<a> aan.</li>
</ul>
</p>',
);

/** Polish (Polski) */
$messages['pl'] = array(
	'article-comments-anonymous' => 'Anonimowy użytkownik',
	'article-comments-comments' => 'Komentarze ($1)',
	'article-comments-post' => 'Wyślij komentarz',
	'article-comments-delete' => 'usuń',
	'article-comments-edit' => 'edytuj',
	'article-comments-history' => 'historia',
	'article-comments-undeleted-comment' => 'Usunięcie komentarza na stronie $1 blogu.',
	'article-comments-login' => '<a href="$1">Zaloguj się</a>, aby komentować',
);

