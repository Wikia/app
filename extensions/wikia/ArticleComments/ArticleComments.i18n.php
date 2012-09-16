<?php
/**
 * Article Comments extension message file
 *
 * Also be aware that many oasis specific i18n messages for comments
 * reside in extensions/wikia/Oasis/Oasis.i18n.php
 */

$messages = array();$messages['en'] = array(
	'article-comments-anonymous' => 'Anonymous user',
	'article-comments-comments' => 'Comments ($1)',
	'article-comments-post' => 'Post comment',
	'article-comments-cancel' => 'Cancel',
	'article-comments-delete' => 'delete',
	'article-comments-edit' => 'edit',
	'article-comments-history' => 'history',
	'article-comments-error' => 'Comment could not be saved',
	'article-comments-undeleted-comment' => 'Undeleted comment for blog page $1',
	'article-comments-rc-comment' => 'Article comment (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Article comments ([[$1]])',
	'article-comments-fblogin' => 'Please <a href="$1" rel="nofollow">log in and connect with Facebook</a> to post a comment on this wiki!',
	'article-comments-fbconnect' => 'Please <a href="$1">connect this account with Facebook</a> to comment!',
	'article-comments-rc-blog-comment' => 'Blog comment (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blog comments ([[$1]])',
	'article-comments-login' => 'Please <a href="$1">log in</a> to post a comment on this wiki.',
	'article-comments-toc-item' => 'Comments',
	'article-comments-comment-cannot-add' => 'You cannot add a comment to the article.',
	'article-comments-vote' => 'Vote up',
	'article-comments-reply' => 'Reply',
	'article-comments-show-all' => 'Show all comments',
	'article-comments-prev-page' => 'Prev',
	'article-comments-next-page' => 'Next',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'The parent article / parent comment has been deleted.',
	'article-comments-empty-comment' => "You can't post an empty comment. <a href='$1'>Delete it instead?</a>",

	'wikiamobile-article-comments-header' => 'comments <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Load more',
	'wikiamobile-article-comments-prev' => 'Load previous',
	'wikiamobile-article-comments-none' => 'No comments',
	'wikiamobile-article-comments-view' => 'View replies',
	'wikiamobile-article-comments-replies' => 'replies',
	'wikiamobile-article-comments-post-reply' => 'Post a reply',
	'wikiamobile-article-comments-post' => 'Post',
	'wikiamobile-article-comments-placeholder' => 'Post a comment',
	'wikiamobile-article-comments-show' => 'Show',
	'wikiamobile-article-comments-login-post' => 'Please log in to post a comment.',

	'enotif_subject_article_comment' => '$PAGEEDITOR has commented on "$PAGETITLE" on {{SITENAME}}',
	'enotif_body_article_comment' => 'Hi $WATCHINGUSERNAME,

There\'s a new comment at $PAGETITLE on {{SITENAME}}. Use this link to see all of the comments: $PAGETITLE_URL#WikiaArticleComments

- Wikia Community Support

___________________________________________
* Find help and advice on Community Central: http://community.wikia.com
* Want to receive fewer messages from us? You can unsubscribe or change your email preferences here: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hi $WATCHINGUSERNAME,
<br /><br />
There\'s a new comment at $PAGETITLE on {{SITENAME}}. Use this link to see all of the comments: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia Community Support
<br /><br />
___________________________________________
<ul>
<li>Find help and advice on Community Central: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Want to receive fewer messages from us? You can unsubscribe or change your email preferences here: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** Message documentation (Message documentation)
 * @author Lizlux
 * @author Siebrand
 */
$messages['qqq'] = array(
	'article-comments-anonymous' => 'Anonymous users are logged out / un-authenticated users.',
	'article-comments-post' => 'This is the text of a submit button to post a new article comment.',
	'article-comments-cancel' => 'Cancel/stop editing an article comment.',
	'article-comments-delete' => 'Click this button to delete the comment. It will take you to a page where you can confirm the deletion.',
	'article-comments-edit' => 'Click this button to edit the message.  A box will appear to with the message text for editing.',
	'wikiamobile-article-comments-header' => "The header of the Comments section shown in Wikia's mobile skin. Parameters:
* $1 is the number of the comments.",
	'wikiamobile-article-comments-view' => 'Message to open all replies to a comment. Parameters: $1 is the number of comments.',
	'wikiamobile-article-comments-replies' => 'Messege in Top Bar in a modal with all replies to comment',
	'wikiamobile-article-comments-show' => 'Label for the link that will reveal the list of comments, keep it as short as possible',
	'enotif_body_article_comment' => 'This is an email sent to inform a user that a page they are following has a new comment posted.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'article-comments-anonymous' => 'Anonieme gebruiker',
	'article-comments-comments' => 'Opmerkings ($1)',
	'article-comments-post' => 'Pos kommentaar',
	'article-comments-delete' => 'skrap',
	'article-comments-edit' => 'wysig',
	'article-comments-history' => 'geskiedenis',
	'article-comments-reply' => 'Antwoord',
	'article-comments-show-all' => 'Wys alle kommentaar',
	'article-comments-prev-page' => 'Vorige',
	'article-comments-next-page' => 'Volgende',
	'article-comments-page-spacer' => '&#160...&#160',
);

/** Arabic (العربية)
 * @author DRIHEM
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
	'article-comments-anonymous' => 'مستخدم مجهول',
	'article-comments-comments' => 'التعليقات ($1)',
	'article-comments-post' => 'أرسل تعليقا',
	'article-comments-cancel' => 'إلغاء',
	'article-comments-delete' => 'حذف',
	'article-comments-edit' => 'تعديل',
	'article-comments-history' => 'التاريخ',
	'article-comments-error' => 'تعذّر حفظ التعليق',
	'article-comments-undeleted-comment' => 'تعليق غير محذوف من المدونة $1',
	'article-comments-rc-comment' => 'تعليق المقال (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'تعليقات المقال ([[$1]])',
	'article-comments-fblogin' => 'الرجاء <a href="$1" rel="nofollow">تسجيل الدخول عن طريق Facebook</a> لإضافة تعليق على هذا الويكي!',
	'article-comments-fbconnect' => 'الرجاء <a href="$1">ربط هذا الحساب مع Facebook</a> من أجل التعليق!',
	'article-comments-rc-blog-comment' => 'تعليق المدونة (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'تعليقات المدونة ([[$1]])',
	'article-comments-login' => 'الرجاء <a href="$1">تسجيل الدخول</a> لإضافة تعليق على هذا الويكي.',
	'article-comments-toc-item' => 'تعليقات',
	'article-comments-comment-cannot-add' => 'لا يمكنك إضافة تعليق إلى هذا المقال.',
	'article-comments-vote' => 'التصويت حتى',
	'article-comments-reply' => 'الرد',
	'article-comments-show-all' => 'إظهار كافة التعليقات',
	'article-comments-prev-page' => 'سابق',
	'article-comments-next-page' => 'تالي',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'تم حذف المقالة الأصلية / التعليق الأصلي.',
	'article-comments-empty-comment' => "لا يمكنك إضافة تعليق فارغ. <a href='$1'>هل تريد حذفه بدلا من ذلك؟</a>",
	'wikiamobile-article-comments-header' => 'تعليقات <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'تحميل المزيد',
	'wikiamobile-article-comments-prev' => 'تحميل السابقة',
	'wikiamobile-article-comments-none' => 'لا تعليقات',
	'wikiamobile-article-comments-view' => 'عرض الردود',
	'wikiamobile-article-comments-replies' => 'الردود',
	'wikiamobile-article-comments-post-reply' => 'نشر الرد',
	'wikiamobile-article-comments-post' => 'عرض',
	'wikiamobile-article-comments-placeholder' => 'أرسل تعليقا',
	'wikiamobile-article-comments-show' => 'أظهر',
	'wikiamobile-article-comments-login-post' => 'الرجاء تسجيل الدخول لإضافة تعليق.',
	'enotif_subject_article_comment' => '$PAGEEDITOR قام بالتعليق على "$PAGETITLE" على {{SITENAME}}',
	'enotif_body_article_comment' => 'عزيزي $WATCHINGUSERNAME،

$PAGEEDITOR قدم تعليقا على "$PAGETITLE".

لمشاهدة موضوع التعليق، أتبع الرابط أدناه:
$PAGETITLE_URL

الرجاء قم بزيارتنا والتعديل غالبا...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>عزيزي $WATCHINGUSERNAME،
<br /><br />
$PAGEEDITOR قدم تعليقا على "$PAGETITLE".
<br /><br />
لمشاهدة موضوع التعليق، أتبع الرابط التالي: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
الرجاء قم بزيارتنا والتعديل غالبا...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>هل تريد التحكم في رسائل البريد المرسلة إليك؟ <a href="{{fullurl:Special:Preferences}}">قم بتحديث التفضيلات الخاصة بك<a>.</li>
</ul>
</p>',
);

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 */
$messages['as'] = array(
	'article-comments-cancel' => 'বাতিল কৰক',
	'article-comments-delete' => 'বিলোপ কৰক',
	'article-comments-edit' => 'সম্পাদনা কৰক',
	'article-comments-history' => 'ইতিহাস',
	'article-comments-prev-page' => 'পূৰ্বৱৰ্তী',
	'article-comments-next-page' => 'পৰৱৰ্তী',
	'wikiamobile-article-comments-show' => 'দেখুৱাওক',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'article-comments-cancel' => 'İmtina',
	'article-comments-delete' => 'sil',
	'article-comments-edit' => 'redaktə',
	'article-comments-history' => 'Tarix',
	'article-comments-toc-item' => 'Şərhlər',
	'article-comments-reply' => 'Yenidən',
	'article-comments-next-page' => 'Növbəti',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'article-comments-anonymous' => 'Anónymer Benutzer',
	'article-comments-comments' => 'Kómmentar ($1)',
	'article-comments-post' => 'An Kómmentar obgeem',
	'article-comments-cancel' => 'Obbrechen',
	'article-comments-delete' => 'léschen',
	'article-comments-edit' => 'werkeln',
	'article-comments-history' => 'Versiónen',
	'article-comments-error' => 'Da Kómmentar hod néd gspeicherd wern kenner',
	'article-comments-undeleted-comment' => 'Kómmentar zum Blog-Beitrog $1 is wiaderhergstöd worn.',
	'article-comments-rc-comment' => 'Artiké Kómmentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artiké Kómmentare ([[$1]])',
	'article-comments-fblogin' => 'Bittscheh <a href="$1" rel="nofollow">eihloggen und mid Facebook vabinden</a>, um an Kómmentar in dém Wiki z\' schreim!',
	'article-comments-fbconnect' => 'Bittscheh <a href="$1">dés Kontó mid Facebook vaknypfm</a>, um an Kómmentar obzgeem',
	'article-comments-rc-blog-comment' => 'Blog-Kómmentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blog-Kómmentare ([[$1]])',
	'article-comments-login' => 'Zum Kómmentirn <a href="$1">åmöden</a>.',
	'article-comments-toc-item' => 'Kómmentare',
	'article-comments-comment-cannot-add' => 'Du kåst an Kómmentar zum Artiké dazuadoah.',
	'article-comments-vote' => 'Obstimmer',
	'article-comments-reply' => 'Åntworten',
	'article-comments-show-all' => 'Olle Kómmentare zoang',
	'article-comments-prev-page' => 'Vurherige',
	'article-comments-next-page' => 'Naxde',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Da ywergordnate Artiké / ywergordnate Kómmentar is gleschd worn.',
	'article-comments-empty-comment' => 'A laarer Kómmentar is néd méglé. <a href="$1">Sóid man léschen?</a>',
	'enotif_subject_article_comment' => '$PAGEEDITOR hod "$PAGETITLE" auf {{SITENAME}} kómmentird.',
	'enotif_body_article_comment' => 'Servas $WATCHINGUSERNAME,

$PAGEEDITOR hod an Kómmentar zua "$PAGETITLE" obgeem.

Um an Kómmentar-Thread åzschauh, fóig \'m untensteeherden Link:
$PAGETITLE_URL

Bittscheh kumm vorbei und dua vü midorweiden.

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Servas $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR hod an Kómmentar zua "$PAGETITLE" obgeem.
<br /><br />
Um an Kómmentar-Thread åzschauh, fóig dém Link do: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Bittscheh kumm vorbei und dua vü werkeln ...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Wüst da åschauh, wöche E-Mails du dahoiden host? <a href="{{fullurl:Special:Preferences}}">Stö deine Eihstöungen eih<a>.</li>
</ul>
</p>',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'article-comments-anonymous' => 'Анонимен потребител',
	'article-comments-comments' => 'Коментари ($1)',
	'article-comments-cancel' => 'Отказване',
	'article-comments-delete' => 'изтриване',
	'article-comments-edit' => 'редактиране',
	'article-comments-history' => 'история',
	'article-comments-toc-item' => 'Коментари',
	'article-comments-reply' => 'Отговор',
	'article-comments-show-all' => 'Показване на всички коментари',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'article-comments-anonymous' => 'Implijer dizanv',
	'article-comments-comments' => 'Evezhiadennoù - $1',
	'article-comments-post' => 'Lakaat un evezhiadenn',
	'article-comments-cancel' => 'Nullañ',
	'article-comments-delete' => 'diverkañ',
	'article-comments-edit' => 'kemmañ',
	'article-comments-history' => 'istor',
	'article-comments-error' => "N'eus ket bet gellet enrollañ an evezhiadenn",
	'article-comments-undeleted-comment' => 'Diziverket eo bet an evezhiadenn evit pajenn ar blog $1',
	'article-comments-rc-comment' => 'Evezhiadenn war pajenn (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Evezhiadennoù war pajenn ([[$1]])',
	'article-comments-fblogin' => '<a href="$1">Kevreañ dre Facebook ha bezañ liammet outañ</a> evit lakaat un evezhiadenn war ar wiki-mañ !',
	'article-comments-fbconnect' => '<a href="$1">Liammit ar gont-mañ ouzh Facebook</a> evit lakaat evezhiadennoù !',
	'article-comments-rc-blog-comment' => 'Evezhiadenn war ar blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Evezhiadennoù war ar blog ([[$1]])',
	'article-comments-login' => '<a href="$1">Ret eo kevreañ</a> evit lezel ur gemennadenn war ar wiki-mañ.',
	'article-comments-toc-item' => 'Evezhiadennoù',
	'article-comments-comment-cannot-add' => "N'hallit ket lakaat un evezhiadenn war ar pennad-mañ.",
	'article-comments-reply' => 'Respont',
	'article-comments-show-all' => 'Diskouez an holl evezhiadennoù',
	'article-comments-prev-page' => 'Kent',
	'article-comments-next-page' => "War-lerc'h",
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Diverket eo bet ar bajenn kar / an evezhiadenn kar.',
	'article-comments-empty-comment' => "N'hallit ket degas un evezhiadenn c'houllo. <a href='$1'>Diverkañ anezhi ?</a>",
	'wikiamobile-article-comments-none' => 'Evezhiaden ebet',
	'wikiamobile-article-comments-view' => 'Gwelet ar respontoù',
	'wikiamobile-article-comments-replies' => 'respontoù',
	'wikiamobile-article-comments-post-reply' => 'Kas ur respont',
	'wikiamobile-article-comments-post' => 'Kas',
	'wikiamobile-article-comments-placeholder' => 'Ouzhpennañ un evezhiadenn',
	'wikiamobile-article-comments-show' => 'Diskouez',
	'enotif_subject_article_comment' => 'Un evezhiadenn zo bet graet gant $PAGEEDITOR diwar-benn "$PAGETITLE" war {{SITENAME}}',
	'enotif_body_article_comment' => '$WATCHINGUSERNAME ker,

Graet ez eus bet un evezhiadenn gant $PAGEEDITOR war "$PAGETITLE".

Evit sellet ouzh an neudennad, klikit war al liamm a-is :
$PAGETITLE_URL

Trugarez da vont d\'ober un tro ha da gemer perzh ingal...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>$WATCHINGUSERNAME ker,
<br /><br />
Graet ez eus bet un evezhiadenn gant $PAGEEDITOR war "$PAGETITLE".
<br /><br />
Evit sellet ouzh an neudennad, klikit war al liamm-mañ : <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Trugarez da vont d\'ober un tamm tro ha da gemer perzh ingal...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Ha c\'hoant hoc\'h eus da chom mestr war ar posteloù a resevit ? <a href="{{fullurl:Special:Preferences}}">Cheñchit ho penndibaboù<a>.</li>
</ul>
</p>',
);

/** Czech (česky)
 * @author Darth Daron
 * @author Jezevec
 * @author Jkjk
 * @author Mr. Richard Bolla
 * @author Vks
 */
$messages['cs'] = array(
	'article-comments-anonymous' => 'Anonymní uživatel',
	'article-comments-comments' => 'Komentáře ($1)',
	'article-comments-post' => 'Přidat komentář',
	'article-comments-cancel' => 'Zrušit',
	'article-comments-delete' => 'smazat',
	'article-comments-edit' => 'upravit',
	'article-comments-history' => 'Historie',
	'article-comments-error' => 'Komentář nemohl být uložen',
	'article-comments-undeleted-comment' => 'Obnovený komentář pro stránku blogu $1',
	'article-comments-rc-comment' => 'Komentář k článku (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Komentáře k článku ([[$1]])',
	'article-comments-fblogin' => 'Pro přidávání komentářů na této wiki se prosím <a href="$1">přihlašte a propojte s Facebookem</a>!',
	'article-comments-fbconnect' => 'Pro komentování připojte <a href="$1">váš Facebook účet</a>!',
	'article-comments-rc-blog-comment' => 'Komentář blogu (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Komentáře blogu ([[$1]])',
	'article-comments-login' => 'Pro přidání komentáře se prosím <a href="$1">přihlašte</a>.',
	'article-comments-toc-item' => 'Komentáře',
	'article-comments-comment-cannot-add' => 'Nelze přidat komentář k článku.',
	'article-comments-vote' => 'Zahlasovat',
	'article-comments-reply' => 'Odpovědět',
	'article-comments-show-all' => 'Zobrazit všechny komentáře',
	'article-comments-prev-page' => 'Předchozí',
	'article-comments-next-page' => 'Další',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Nadřazený článek / komentář byl odstraněn.',
	'article-comments-empty-comment' => "Nelze odeslat prázdný komentář. <a href='$1'>Chcete ho místo toho odstranit?</a>",
	'wikiamobile-article-comments-header' => 'Komentáře <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Nahrát více',
	'wikiamobile-article-comments-prev' => 'Načíst předchozí',
	'wikiamobile-article-comments-none' => 'Žádné komentáře',
	'wikiamobile-article-comments-view' => 'Ukázat odpovědi',
	'wikiamobile-article-comments-replies' => 'odpovědi',
	'wikiamobile-article-comments-post-reply' => 'Odpovědět',
	'wikiamobile-article-comments-post' => 'Poslat',
	'wikiamobile-article-comments-placeholder' => 'Přidat komentář',
	'wikiamobile-article-comments-show' => 'Ukázat',
	'wikiamobile-article-comments-login-post' => 'Prosím, přihlašte se, abyste mohli odesílat komentáře.',
	'enotif_subject_article_comment' => '$PAGEEDITOR přidal komentář "$PAGETITLE" na {{SITENAME}}.',
	'enotif_body_article_comment' => 'Vážený $WATCHINGUSERNAME,

$PAGEEDITOR přidal komentář na "$PAGETITLE".

Pro zobrazení klikněte na níže uvedený odkaz:
$PAGETITLE_URL

Prosím navštěvujte a editujte často...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Váženýr $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR přidal komentář na "$PAGETITLE".
<br /><br />
Pro zobrazení klikněte na tento odkaz: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Prosíme navštěvujte a editujte často...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Chcete nastavit, které e-maily budete dostávat? <a href="{{fullurl:Special:Preferences}}">Aktualizujte své předvolby<a>.</li>
</ul>
</p>',
);

/** Danish (dansk)
 * @author Sarrus
 */
$messages['da'] = array(
	'article-comments-anonymous' => 'Anonym bruger',
	'article-comments-comments' => 'Kommentarer ($1)',
	'article-comments-cancel' => 'Fortryd',
	'article-comments-delete' => 'slet',
);

/** German (Deutsch)
 * @author Avatar
 * @author Claudia Hattitten
 * @author Geitost
 * @author Inkowik
 * @author LWChris
 * @author Metalhead64
 * @author PtM
 * @author SVG
 */
$messages['de'] = array(
	'article-comments-anonymous' => 'Unangemeldeter Benutzer',
	'article-comments-comments' => 'Kommentare ($1)',
	'article-comments-post' => 'Kommentieren',
	'article-comments-cancel' => 'Abbrechen',
	'article-comments-delete' => 'löschen',
	'article-comments-edit' => 'bearbeiten',
	'article-comments-history' => 'Versionen',
	'article-comments-error' => 'Kommentar konnte nicht gespeichert werden',
	'article-comments-undeleted-comment' => 'Kommentar zu Blog-Beitrag $1 wiederhergestellt.',
	'article-comments-rc-comment' => 'Artikel Kommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artikel Kommentare ([[$1]])',
	'article-comments-fblogin' => 'Bitte <a href="$1" rel="nofollow">einloggen und mit Facebook verbinden</a>, um einen Kommentar in diesem Wiki zu schreiben!',
	'article-comments-fbconnect' => 'Bitte <a href="$1">dieses Konto mit Facebook verknüpfen</a>, um zu kommentieren!',
	'article-comments-rc-blog-comment' => 'Blog-Kommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blog-Kommentare ([[$1]])',
	'article-comments-login' => 'Zum Kommentieren <a href="$1">anmelden</a>.',
	'article-comments-toc-item' => 'Kommentare',
	'article-comments-comment-cannot-add' => 'Du kannst keinen Kommentar zum Artikel hinzufügen.',
	'article-comments-vote' => 'Abstimmen',
	'article-comments-reply' => 'Antworten',
	'article-comments-show-all' => 'Alle Kommentare anzeigen',
	'article-comments-prev-page' => 'Vorherige',
	'article-comments-next-page' => 'Nächste',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Der übergeordnete Artikel / übergeordnete Kommentar wurde gelöscht.',
	'article-comments-empty-comment' => 'Ein leerer Kommentar ist nicht möglich. <a href="$1">Stattdessen löschen?</a>',
	'wikiamobile-article-comments-header' => 'Kommentare (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Weitere laden',
	'wikiamobile-article-comments-prev' => 'Vorherige laden',
	'wikiamobile-article-comments-none' => 'Keine Kommentare',
	'wikiamobile-article-comments-view' => 'Antworten zeigen',
	'wikiamobile-article-comments-replies' => 'Antworten',
	'wikiamobile-article-comments-post-reply' => 'Antworten',
	'wikiamobile-article-comments-post' => 'Abschicken',
	'wikiamobile-article-comments-placeholder' => 'Kommentieren',
	'wikiamobile-article-comments-show' => 'Zeigen',
	'wikiamobile-article-comments-login-post' => 'Bitte melde dich zum Kommentieren an.',
	'enotif_subject_article_comment' => '$PAGEEDITOR hat "$PAGETITLE" auf {{SITENAME}} kommentiert',
	'enotif_body_article_comment' => 'Hallo $WATCHINGUSERNAME,

Es gibt zu $PAGETITLE auf {{SITENAME}} einen neuen Kommentar. Verwende diesen Link, um alle Kommentare anzusehen: $PAGETITLE_URL#WikiaArticleComments

– Wikia Community Team

___________________________________________
* Bekomme Hilfe und Ratschläge auf Community Central: http://community.wikia.com
* Willst du weniger Nachrichten von uns erhalten? Du kannst die Benachrichtigung abbestellen oder deine E-Mail-Einstellungen hier ändern: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hallo $WATCHINGUSERNAME,
<br /><br />
Es gibt zu $PAGETITLE auf {{SITENAME}} einen neuen Kommentar. Verwende diesen Link, um alle Kommentare anzusehen: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
– Wikia Community Team
<br /><br />
___________________________________________
<ul>
<li>Bekomme Hilfe und Ratschläge auf Community Central: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Willst du weniger Nachrichten von uns erhalten? Du kannst die Benachrichtigung abbestellen oder deine E-Mail-Einstellungen hier ändern: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Claudia Hattitten
 */
$messages['de-formal'] = array(
	'article-comments-comment-cannot-add' => 'Sie können keinen Kommentar zum Artikel hinzufügen.',
	'enotif_body_article_comment' => 'Hallo $WATCHINGUSERNAME,

$PAGEEDITOR hat einen Kommentar zu "$PAGETITLE" abgegeben.

Um den Kommentar-Thread anzusehen, folgen Sie dem unten stehenden Link:
$PAGETITLE_URL

Bitte besuchen und bearbeiten Sie das Wiki bald wieder...

Wikia',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'article-comments-anonymous' => 'Karbero anonim',
	'article-comments-comments' => 'Vatışi ($1)',
	'article-comments-post' => 'Mışewri bıvurne',
	'article-comments-cancel' => 'Bıterkne',
	'article-comments-delete' => 'besterne',
	'article-comments-edit' => 'bıvurne',
	'article-comments-history' => 'Ravêrden',
	'article-comments-error' => 'Mışewre qeyd nêbı',
	'article-comments-rc-comments' => 'Vatışê wesiqe da ([[$1]])',
	'article-comments-rc-blog-comments' => 'Vatışê Blog da ([[$1]])',
	'article-comments-toc-item' => 'Vatışi',
	'article-comments-vote' => 'Rey çek',
	'article-comments-reply' => 'Cewab bıde',
	'article-comments-show-all' => 'Cıwaba pêron bımocne',
	'article-comments-prev-page' => 'Verên',
	'article-comments-next-page' => 'Bahdoyên',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'vatışê <span class=cnt id=wkArtCnt>$1</span>i',
	'wikiamobile-article-comments-more' => 'Zewbi buwane',
	'wikiamobile-article-comments-prev' => 'Bahdoyêni buwane',
	'wikiamobile-article-comments-none' => 'Vatış çıno',
	'wikiamobile-article-comments-view' => 'Cewabi bıvin',
	'wikiamobile-article-comments-replies' => 'cewabi',
	'wikiamobile-article-comments-post-reply' => 'Cewab bırşe',
	'wikiamobile-article-comments-post' => 'Bırş',
	'wikiamobile-article-comments-placeholder' => 'Mışewre bırşe',
	'wikiamobile-article-comments-show' => 'Bımocne',
	'wikiamobile-article-comments-login-post' => 'Mışewre rıştışi rê şıma ra recay ma qeyd bê',
	'enotif_body_article_comment-HTML' => '<p>Bırayo  $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR ena vatış "$PAGETITLE".
<br /><br />
weşte şıma {{SITENAME}} şi se: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
teneye vındere u bahdo bıvurne
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Şıma qayıle bewni re mesacan de xo se şı re? <a href="{{fullurl:Special:Preferences}}">newekerdışe malumata<a>.</li>
</ul>
</p>',
);

/** Greek (Ελληνικά)
 * @author Evropi
 */
$messages['el'] = array(
	'article-comments-comments' => 'Σχόλια ($1)',
	'article-comments-post' => 'Δημοσίευση σχολίου',
	'article-comments-delete' => 'διαγραφή',
	'article-comments-edit' => 'επεξεργασία',
	'article-comments-history' => 'ιστορικό',
	'article-comments-error' => 'Δεν ήταν δυνατή η αποθήκευση του σχολίου',
	'article-comments-rc-comment' => 'Σχόλιο άρθρου (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Σχόλια άρθρου ([[$1]])',
	'article-comments-toc-item' => 'Σχόλια',
	'article-comments-comment-cannot-add' => 'Δεν μπορείτε να προσθέσετε σχόλιο για το άρθρο.',
	'article-comments-reply' => 'Απάντηση',
	'article-comments-show-all' => 'Εμφάνιση όλων των σχολίων',
	'article-comments-prev-page' => 'Προηγ',
	'article-comments-next-page' => 'Επόμενο',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-empty-comment' => "Δεν μπορείτε να δημοσιεύσετε ένα κενό σχόλιο. <a href='$1'>Θέλετε να το διαγράψτε αυτό αντ' αυτού;</a>",
);

/** Esperanto (Esperanto)
 * @author Tradukisto
 */
$messages['eo'] = array(
	'article-comments-edit' => 'redakti',
	'article-comments-toc-item' => 'Komentoj',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Benfutbol10
 * @author DJ Nietzsche
 * @author VegaDark
 */
$messages['es'] = array(
	'article-comments-anonymous' => 'Usuario anónimo',
	'article-comments-comments' => 'Comentarios ($1)',
	'article-comments-post' => 'Dejar comentario',
	'article-comments-cancel' => 'Cancelar',
	'article-comments-delete' => '(borrar)',
	'article-comments-edit' => '(editar)',
	'article-comments-history' => '(Historial)',
	'article-comments-error' => 'El comentario no pudo ser guardado',
	'article-comments-undeleted-comment' => 'Comentario no borrado para la página del blog $1',
	'article-comments-rc-comment' => 'Comentario de artículo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Comentarios de artículo ([[$1]])',
	'article-comments-fblogin' => 'Por favor, <a href="$1">identifícate y conéctate con Facebook</a> para dejar un comentario en este wiki.',
	'article-comments-fbconnect' => 'Por favor, <a href="$1">conecta esta cuenta con Facebook</a> para dejar un comentario.',
	'article-comments-rc-blog-comment' => 'Comentario de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentarios de blog ([[$1]])',
	'article-comments-login' => '<a href="$1">Identifícate</a> para dejar un comentario',
	'article-comments-toc-item' => 'Comentarios',
	'article-comments-comment-cannot-add' => 'No puedes añadir comentarios aquí',
	'article-comments-vote' => 'Votar',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos los comentarios',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Siguiente',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'El artículo raíz / comentario raíz ha sido borrado.',
	'article-comments-empty-comment' => "No puedes dejar un comentario en blanco. <a href='$1'>¿Quieres borrarlo?</a>",
	'wikiamobile-article-comments-header' => 'Comentarios (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Cargar más',
	'wikiamobile-article-comments-prev' => 'Cargar el anterior',
	'wikiamobile-article-comments-none' => 'No hay comentarios',
	'wikiamobile-article-comments-view' => 'Ver respuestas',
	'wikiamobile-article-comments-replies' => 'respuestas',
	'wikiamobile-article-comments-post-reply' => 'Publicar una respuesta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Dejar un comentario',
	'wikiamobile-article-comments-show' => 'Mostrar',
	'wikiamobile-article-comments-login-post' => 'Inicia sesión para publicar un comentario.',
	'enotif_subject_article_comment' => '$PAGEEDITOR ha comentado en "$PAGETITLE" en {{SITENAME}}',
	'enotif_body_article_comment' => 'Hola $WATCHINGUSERNAME,

Hay un nuevo comentario en la página $PAGETITLE de {{SITENAME}}. Usa este enlace para ver todos los comentarios: $PAGETITLE_URL#WikiaArticleComments

- Equipo Comunitario de Wikia

___________________________________________
* Encuentra ayuda y consejos en la Central Hispana: http://es.wikia.com
* ¿Quieres recibir pocos mensajes de nosotros? Puedes darte de baja o cambiar tus preferencias de correo electrónico aquí: http://es.wikia.com/Especial:Preferencias',
	'enotif_body_article_comment-HTML' => '<p>Hola $WATCHINGUSERNAME,
<br /><br />
Hay un nuevo comentario en la página $PAGETITLE de {{SITENAME}}. Usa este enlace para ver todos los comentarios: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Equipo Comunitario de Wikia
<br /><br />
___________________________________________
<ul>
<li>Encuentra ayuda y consejos en la Central Hispana: <a href="http://es.wikia.com">http://es.wikia.com</a><li>
<li>¿Quieres recibir pocos mensajes de nosotros? Puedes darte de baja o cambia tus preferencias de correo electrónico aquí: <a href="http://es.wikia.com/Especial:Preferencias">http://es.wikia.com/wiki/Especial:Preferencias</a></li>
</ul>
</p>',
);

/** Estonian (eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'article-comments-anonymous' => 'Anonüümne kasutaja',
	'article-comments-comments' => 'Kommentaar ($1)',
	'article-comments-post' => 'Kommenteeri',
	'article-comments-cancel' => 'Tühista',
	'article-comments-delete' => 'kustuta',
	'article-comments-edit' => 'redigeeri',
	'article-comments-history' => 'ajalugu',
	'article-comments-error' => 'Kommentaari ei õnnestu salvestada',
	'article-comments-toc-item' => 'Kommentaarid',
	'article-comments-reply' => 'Vasta',
	'article-comments-show-all' => 'Vaata kõiki kommentaare',
	'article-comments-prev-page' => 'Eelmine',
	'article-comments-next-page' => 'Järgmine',
	'wikiamobile-article-comments-none' => 'Kommentaare ei ole',
	'wikiamobile-article-comments-replies' => 'vastused',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'article-comments-anonymous' => 'Lankide anonimoa',
	'article-comments-comments' => 'Iruzkinak ($1)',
	'article-comments-post' => 'Iruzkina idatzi',
	'article-comments-delete' => 'ezabatu',
	'article-comments-edit' => 'aldatu',
	'article-comments-history' => 'historia',
	'article-comments-reply' => 'Erantzun',
	'article-comments-show-all' => 'Iruzkin guztiak erakutsi',
	'article-comments-prev-page' => 'Aurrekoa',
	'article-comments-next-page' => 'Hurrengoa',
	'article-comments-page-spacer' => '&#160...&#160',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Wayiran
 * @author جواد
 */
$messages['fa'] = array(
	'article-comments-anonymous' => 'کاربر گمنام',
	'article-comments-comments' => '($1) نظرات',
	'article-comments-post' => 'ارسال نظر',
	'article-comments-cancel' => 'انصراف',
	'article-comments-delete' => 'حذف',
	'article-comments-edit' => 'ویرایش',
	'article-comments-history' => 'تاریخچه',
	'article-comments-error' => 'نشد که نظر ذخیره شود',
	'article-comments-undeleted-comment' => 'نظر برای صفحۀ وبلاگ $1 احیاء شد',
	'article-comments-rc-comment' => 'نظر مقاله (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'نظرات مقاله ([[$1]])',
	'article-comments-fblogin' => 'برای فرستادن نظر در این ویکی لطفاً <a href="$1">به فیس‌بوک وارد و متصل شوید</a>!',
	'article-comments-rc-blog-comment' => 'نظر وبلاگ (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'نظرات وبلاگ ([[$1]])',
	'article-comments-login' => 'برای نظر دادن <a href="$1">وارد سامانه شوید</a>.',
	'article-comments-toc-item' => 'نظرات',
	'article-comments-comment-cannot-add' => 'شما نمی‌توانید به مقاله نظری را اضافه کنید.',
	'article-comments-reply' => 'پاسخ',
	'article-comments-show-all' => 'نمایش همهٔ نظرات',
	'article-comments-prev-page' => 'قبلی',
	'article-comments-next-page' => 'بعدی',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'مقالهٔ مادر / نظر مادر حذف شده است.',
	'article-comments-empty-comment' => "شما نمی‌توانید یک نظر خالی بفرستید. <a href='$1'>به‌جایش حذف شود؟</a>",
	'wikiamobile-article-comments-replies' => 'پاسخ‌ها',
	'wikiamobile-article-comments-show' => 'نمایش',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Ilkea
 * @author Lukkipoika
 * @author Nike
 * @author Tm T
 * @author Tofu II
 */
$messages['fi'] = array(
	'article-comments-anonymous' => 'Anonyymi käyttäjä',
	'article-comments-comments' => 'Kommentit ($1)',
	'article-comments-post' => 'Lähetä kommentti',
	'article-comments-cancel' => 'Peruuta',
	'article-comments-delete' => 'poista',
	'article-comments-edit' => 'muokkaa',
	'article-comments-history' => 'historiasta',
	'article-comments-error' => 'Kommenttia ei voitu tallentaa',
	'article-comments-undeleted-comment' => 'Kommenttia ei poistettu blogisivulta $1',
	'article-comments-rc-comment' => 'Artikkelin kommentti (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artikkelin kommentit ([[$1]])',
	'article-comments-fblogin' => 'Voisitko <a href="$1" rel="nofollow">kirjautua sisään ja yhdistää Facebookiin</a> kommentoidaksesi tätä wikiä!',
	'article-comments-fbconnect' => 'Voisitko <a href="$1">yhdistää tämän käyttäjätilin Facebookiin</a> kommentoidaksesi!',
	'article-comments-rc-blog-comment' => 'Blogin kommentti (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blogin kommentit ([[$1]])',
	'article-comments-login' => '<a href="$1">Kirjaudu sisään</a> kommetoidaksesi',
	'article-comments-toc-item' => 'Kommentit',
	'article-comments-comment-cannot-add' => 'Et voi lisätä kommenttia tähän artikkeliin.',
	'article-comments-vote' => 'Äänestä',
	'article-comments-reply' => 'Vastaus',
	'article-comments-show-all' => 'Näytä kaikki kommentit',
	'article-comments-prev-page' => 'Edell.',
	'article-comments-next-page' => 'Seuraava',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Ylemmän tason artikkeli/kommentti on poistettu.',
	'article-comments-empty-comment' => "Et voi lähettää tyhjää kommenttia. <a href='$1'>Poistaisitko kommentin sen sijaan?</a>",
	'wikiamobile-article-comments-header' => '<span class=cnt id=wkArtCnt>$1</span> kommenttia',
	'wikiamobile-article-comments-more' => 'Lataa lisää',
	'wikiamobile-article-comments-prev' => 'Lataa edelliset',
	'wikiamobile-article-comments-none' => 'Ei kommentteja',
	'wikiamobile-article-comments-view' => 'Näytä kommentit',
	'wikiamobile-article-comments-replies' => 'Vastaukset',
	'wikiamobile-article-comments-post-reply' => 'Lähetä vastaus',
	'wikiamobile-article-comments-post' => 'Lähetä',
	'wikiamobile-article-comments-placeholder' => 'Lähetä kommentti',
	'wikiamobile-article-comments-show' => 'Näytä',
	'wikiamobile-article-comments-login-post' => 'Kirjaudu sisään kommentoidaksesi.',
	'enotif_subject_article_comment' => '$PAGEEDITOR on kommentoinut: "$PAGETITLE" {{SITENAME}}ssä.',
	'enotif_body_article_comment' => 'Hyvä $WATCHINGUSERNAME,

$PAGEEDITOR teki kommentin sivulle "$PAGETITLE".

Nähdäksesi kommentin paina:
$PAGETILE_URL

Vieraile ja muokkaa usein...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Arvoisa $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR teki kommentin sivulle "$PAGETITLE".
<br /><br />
Seuraa tätä linkkiä nähdäksesi kommenttisäikeen: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Vieraile ja muokkaa usein...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Haluatko valita, että mitkä sähköpostiviestit sinä vastaanotat? <a href="{{fullurl:Special:Preferences}}">Päivitä asetuksiasi<a>.</li>
</ul>
</p>',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'article-comments-anonymous' => 'Dulnevndur brúkari',
	'article-comments-comments' => 'Viðmerkingar ($1)',
	'article-comments-post' => 'Send tína viðmerking',
	'article-comments-cancel' => 'Angrað',
	'article-comments-delete' => 'strikað',
	'article-comments-edit' => 'rætta',
	'article-comments-history' => 'søga',
	'article-comments-error' => 'Viðmerkingin kundi ikki verða goymd',
	'article-comments-reply' => 'Svara',
	'article-comments-show-all' => 'Vís allar viðmerkingar',
	'article-comments-prev-page' => 'Áðrenn',
	'article-comments-next-page' => 'Næsta',
	'article-comments-page-spacer' => '&#160...&#160',
);

/** French (français)
 * @author Crochet.david
 * @author Gomoko
 * @author Verdy p
 * @author Wyz
 * @author Zetud
 */
$messages['fr'] = array(
	'article-comments-anonymous' => 'Utilisateur anonyme',
	'article-comments-comments' => 'Commentaires ($1)',
	'article-comments-post' => 'Ajouter un commentaire',
	'article-comments-cancel' => 'Annuler',
	'article-comments-delete' => 'supprimer',
	'article-comments-edit' => 'modifier',
	'article-comments-history' => 'historique',
	'article-comments-error' => 'Le commentaire n’a pas pu être enregistré',
	'article-comments-undeleted-comment' => 'Commentaire pour la page de blog $1 restauré',
	'article-comments-rc-comment' => 'Commentaire d’article (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Commentaires d’article ([[$1]])',
	'article-comments-fblogin' => 'Veuillez <a href="$1">vous connecter et relier Facebook</a> pour poster un commentaire sur ce wiki !',
	'article-comments-fbconnect' => 'Veuillez <a href="$1">relier ce compte avec Facebook</a> pour commenter !',
	'article-comments-rc-blog-comment' => 'Commentaire de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Commentaires de blog ([[$1]])',
	'article-comments-login' => 'Veuillez vous <a href="$1">connecter</a> pour laisser un commentaire sur ce wiki.',
	'article-comments-toc-item' => 'Commentaires',
	'article-comments-comment-cannot-add' => 'Vous ne pouvez pas ajouter de commentaire à cet article.',
	'article-comments-vote' => 'Intéressant',
	'article-comments-reply' => 'Répondre',
	'article-comments-show-all' => 'Afficher tous les commentaires',
	'article-comments-prev-page' => 'Précédent',
	'article-comments-next-page' => 'Suivant',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'La page ou le commentaire parent a été effacé.',
	'article-comments-empty-comment' => "Vous ne pouvez pas poster un commentaire vide. <a href='$1'>Le supprimer ?</a>",
	'wikiamobile-article-comments-header' => 'Commentaires (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Lire la suite',
	'wikiamobile-article-comments-prev' => 'Charger le précédent',
	'wikiamobile-article-comments-none' => 'Aucun commentaire',
	'wikiamobile-article-comments-view' => 'Afficher les réponses',
	'wikiamobile-article-comments-replies' => 'réponses',
	'wikiamobile-article-comments-post-reply' => 'Envoyer une réponse',
	'wikiamobile-article-comments-post' => 'Envoyer',
	'wikiamobile-article-comments-placeholder' => 'Envoyer un commentaire',
	'wikiamobile-article-comments-show' => 'Afficher',
	'wikiamobile-article-comments-login-post' => 'Veuillez vous connecter pour poster un commentaire.',
	'enotif_subject_article_comment' => '$PAGEEDITOR a commenté « $PAGETITLE » sur {{SITENAME}}',
	'enotif_body_article_comment' => '$WATCHINGUSERNAME,

Un nouveau commentaire a été laissé sur « $PAGETITLE » sur {{SITENAME}}. Utilisez ce lien pour voir tous les commentaires : $PAGETITLE_URL#WikiaArticleComments

— L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : http://communaute.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>$WATCHINGUSERNAME,
<br /><br />
Un nouveau commentaire a été laissé sur « $PAGETITLE » sur {{SITENAME}}. Utilisez ce lien pour voir tous les commentaires : $PAGETITLE_URL#WikiaArticleComments
<br /><br />
— L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="http://communaute.wikia.com/Special:Preferences">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'article-comments-anonymous' => 'Usuario anónimo',
	'article-comments-comments' => 'Comentarios ($1)',
	'article-comments-post' => 'Publicar un comentario',
	'article-comments-cancel' => 'Cancelar',
	'article-comments-delete' => 'borrar',
	'article-comments-edit' => 'editar',
	'article-comments-history' => 'historial',
	'article-comments-error' => 'O comentario non se puido gardar',
	'article-comments-undeleted-comment' => 'Comentario restaurado da páxina de blogue "$1"',
	'article-comments-rc-comment' => 'Comentario de artigo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Comentarios de artigo ([[$1]])',
	'article-comments-fblogin' => '<a href="$1" rel="nofollow">Acceda ao sistema e conecte co Facebook</a> para publicar un comentario neste wiki!',
	'article-comments-fbconnect' => '<a href="$1">Conecte esta conta co Facebook</a> para comentar!',
	'article-comments-rc-blog-comment' => 'Comentario de blogue (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentarios de blogue ([[$1]])',
	'article-comments-login' => '<a href="$1">Acceda ao sistema</a> para publicar un comentario neste wiki.',
	'article-comments-toc-item' => 'Comentarios',
	'article-comments-comment-cannot-add' => 'Non pode engadir un comentario ao artigo.',
	'article-comments-vote' => 'Votar positivamente',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos os comentarios',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Seguinte',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'O artigo ou comentario raíz foi borrado.',
	'article-comments-empty-comment' => "Non pode enviar un comentario baleiro. <a href='$1'>Quere borralo?</a>",
	'wikiamobile-article-comments-header' => 'comentarios (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Cargar máis',
	'wikiamobile-article-comments-prev' => 'Cargar os anteriores',
	'wikiamobile-article-comments-none' => 'Sen comentarios',
	'wikiamobile-article-comments-view' => 'Ollar as respostas',
	'wikiamobile-article-comments-replies' => 'respostas',
	'wikiamobile-article-comments-post-reply' => 'Publicar unha resposta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Publicar un comentario',
	'wikiamobile-article-comments-show' => 'Mostrar',
	'wikiamobile-article-comments-login-post' => 'Acceda ao sistema para publicar un comentario.',
	'enotif_subject_article_comment' => '$PAGEEDITOR fixo un comentario sobre "$PAGETITLE" en {{SITENAME}}',
	'enotif_body_article_comment' => 'Boas, $WATCHINGUSERNAME:

Hai un novo comentario na páxina "$PAGETITLE" de {{SITENAME}}. Use esta ligazón para botar un ollo a todos os comentarios:
$PAGETITLE_URL#WikiaArticleComments

- O equipo comunitario de Wikia

___________________________________________
* Atope axuda e consellos na central da comunidade: http://community.wikia.com
* Quere recibir menos mensaxes nosas? Pode cancelar a subscrición ou cambiar as preferencias de correo electrónico aquí: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Boas, $WATCHINGUSERNAME:
<br /><br />
Hai un novo comentario na páxina "$PAGETITLE" de {{SITENAME}}. Use esta ligazón para botar un ollo a todos os comentarios:
$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- O equipo comunitario de Wikia
<br /><br />
___________________________________________
<ul>
<li>Atope axuda e consellos na central da comunidade: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Quere recibir menos mensaxes nosas? Pode cancelar a subscrición ou cambiar as preferencias de correo electrónico aquí: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** Hebrew (עברית)
 * @author Ofekalef
 * @author Yova
 */
$messages['he'] = array(
	'article-comments-anonymous' => 'משתמש אנונימי',
	'article-comments-comments' => 'תגובות ($1)',
	'article-comments-post' => 'פרסם תגובה',
	'article-comments-cancel' => 'ביטול',
	'article-comments-delete' => 'מחיקה',
	'article-comments-edit' => 'עריכה',
	'article-comments-history' => 'היסטוריה',
	'article-comments-error' => 'לא ניתן היה לשמור את התגובה',
	'article-comments-fblogin' => 'אנא <a href="$1" rel="nofollow">התחבר בעזרת פייסבוק</a> על מנת לפרסם תגובה בוויקי זו!',
	'article-comments-show-all' => 'הצגת כל התגובות',
);

/** Hungarian (magyar)
 * @author Dani
 * @author TK-999
 */
$messages['hu'] = array(
	'article-comments-anonymous' => 'Névtelen felhasználó',
	'article-comments-comments' => 'Hozzászólások ($1)',
	'article-comments-post' => 'Hozzászólás elküldése',
	'article-comments-cancel' => 'Mégse',
	'article-comments-delete' => 'törlés',
	'article-comments-edit' => 'szerkesztés',
	'article-comments-history' => 'laptörténet',
	'article-comments-error' => 'A hozzászólást nem lehet elmenteni',
	'article-comments-undeleted-comment' => 'A(z) $1 bloglap hozzászólása vissza lett állítva',
	'article-comments-rc-comment' => 'Cikkhez tartozó hozzászólás (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Cikkhez tartozó hozzászólások ([[$1]])',
	'article-comments-fblogin' => 'Kérlek, <a href="$1" rel="nofollow">lépj be és kösd össze felhasználódat a Facebookal</a>, hogy hozzászólást írhass ezen a wikin!',
	'article-comments-fbconnect' => 'Kérjük, hozzászólás küldéséhez <a href="$1">kapcsolja össze ezt a fiókot a Facebookkal</a>.',
	'article-comments-rc-blog-comment' => 'Blog hozzászólás (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blog hozzászólások ([[$1]])',
	'article-comments-login' => 'Kérjük, <a href="$1">jelentkezzen be</a> hozzászólás küldéséhez.',
	'article-comments-toc-item' => 'Hozzászólások',
	'article-comments-comment-cannot-add' => 'Nem írhatsz hozzászólást a szócikkhez.',
	'article-comments-vote' => 'Szavazás',
	'article-comments-reply' => 'Válasz',
	'article-comments-show-all' => 'Összes hozzászólás',
	'article-comments-prev-page' => 'Előző',
	'article-comments-next-page' => 'Következő',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Az anyacikket / anyamegjegyzést kitörölték',
	'article-comments-empty-comment' => "Üres megjegyzés nem írható. <a href='$1'>Szeretné kitörölni?</a>",
	'wikiamobile-article-comments-header' => '<span class="cnt" id="wkArtCnt">$1</span> hozzászólás',
	'wikiamobile-article-comments-more' => 'Több betöltése',
	'wikiamobile-article-comments-prev' => 'Előző betöltése',
	'wikiamobile-article-comments-none' => 'Nincsenek hozzászólások',
	'wikiamobile-article-comments-view' => 'Válaszok megtekintése',
	'wikiamobile-article-comments-replies' => 'válasz',
	'wikiamobile-article-comments-post-reply' => 'Válasz beküldése',
	'wikiamobile-article-comments-post' => 'Küldés',
	'wikiamobile-article-comments-placeholder' => 'Hozzászólás elküldése',
	'wikiamobile-article-comments-show' => 'Megjelenítés',
	'wikiamobile-article-comments-login-post' => 'Kérünk, jelentkezz be a hozzászóláshoz.',
	'enotif_subject_article_comment' => '$PAGEEDITOR hozzászólt a(z) "$PAGETITLE oldalhoz a(z) {{SITENAME}}-n.',
	'enotif_body_article_comment' => 'Kedves $WATCHINGUSERNAME,

$PAGEEDITOR hozzászólt a(z) "$PAGETITLE" oldalhoz.

A hozzászólások megtekintéséhez kövesd az alábbi hivatkozást:
$PAGETITLE_URL

Kérünk, látogass és szerkessz gyakran...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Kedves $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR hozzászólt a(z) "$PAGETITLE" laphoz.
<br /><br />
A hozzászólások megteknitéséhez kövesd ezt a hivatkozást: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Kérünk, látogass és szerkessz gyakran!
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Szeretnéd szabályozni az érkező e&ndash;maileket?  <a href="{{fullurl:Special:Preferences}}">Konfiguráld beállításaidban<a>.</li>
</ul>
</p>',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'article-comments-anonymous' => 'Usator anonyme',
	'article-comments-comments' => 'Commentos ($1)',
	'article-comments-post' => 'Adjunger commento',
	'article-comments-cancel' => 'Cancellar',
	'article-comments-delete' => 'deler',
	'article-comments-edit' => 'modificar',
	'article-comments-history' => 'historia',
	'article-comments-error' => 'Le commento non poteva esser salveguardate',
	'article-comments-undeleted-comment' => 'Commento in pagina de blog $1 restaurate',
	'article-comments-rc-comment' => 'Commentario de articulo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Commentarios de articulo ([[$1]])',
	'article-comments-fblogin' => 'Per favor <a href="$1">aperi session e connecte con Facebook</a> pro publicar un commento in iste wiki!',
	'article-comments-fbconnect' => 'Per favor <a href="$1">connecte iste conto con Facebook</a> pro commentar!',
	'article-comments-rc-blog-comment' => 'Commento de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Commentos de blog ([[$1]])',
	'article-comments-login' => 'Per favor <a href="$1">aperi session</a> pro publicar un commento in iste wiki.',
	'article-comments-toc-item' => 'Commentos',
	'article-comments-comment-cannot-add' => 'Tu non pote adjunger un commento a iste articulo.',
	'article-comments-vote' => 'Votar positivemente',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Monstrar tote le commentos',
	'article-comments-prev-page' => 'Previe',
	'article-comments-next-page' => 'Proxime',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Le commento/articulo genitor ha essite delite.',
	'article-comments-empty-comment' => "Non es possibile publicar un commento vacue. <a href='$1'>Deler lo?</a>",
	'wikiamobile-article-comments-header' => 'commentos (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Cargar plus',
	'wikiamobile-article-comments-prev' => 'Cargar precedente',
	'wikiamobile-article-comments-none' => 'Nulle commento',
	'wikiamobile-article-comments-view' => 'Vider responsas',
	'wikiamobile-article-comments-replies' => 'responsas',
	'wikiamobile-article-comments-post-reply' => 'Adjunger un responsa',
	'wikiamobile-article-comments-post' => 'Inviar',
	'wikiamobile-article-comments-placeholder' => 'Publicar un commento',
	'wikiamobile-article-comments-show' => 'Monstrar',
	'wikiamobile-article-comments-login-post' => 'Per favor aperi session pro commentar.',
	'enotif_subject_article_comment' => '$PAGEEDITOR ha commentate "$PAGETITLE" sur {{SITENAME}}',
	'enotif_body_article_comment' => 'Car $WATCHINGUSERNAME,

$PAGEEDITOR lassava un commento sur "$PAGETITLE".

Pro vider le filo de commentos, seque le ligamine sequente:
$PAGETITLE_URL

Per favor visita e modifica sovente...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Car $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR lassava un commento in "$PAGETITLE".
<br /><br />
Pro vider le filo de commentos, seque iste ligamine: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Per favor visita e modifica sovente...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Vole determinar qual emails tu recipe? <a href="{{fullurl:Special:Preferences}}">Actualisa tu preferentias<a>.</li>
</ul>
</p>',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 */
$messages['id'] = array(
	'article-comments-anonymous' => 'Pengguna anonim',
	'article-comments-comments' => 'Komentar ($1)',
	'article-comments-post' => 'Kirim komentar',
	'article-comments-cancel' => 'Batalkan',
	'article-comments-delete' => 'hapus',
	'article-comments-edit' => 'sunting',
	'article-comments-history' => 'versi',
	'article-comments-error' => 'Komentar tidak dapat disimpan',
	'article-comments-undeleted-comment' => 'Batalkan hapus komentar untuk halaman blog $1',
	'article-comments-toc-item' => 'Komentar',
	'article-comments-comment-cannot-add' => 'Anda tidak dapat menambahkan komentar ke artikel',
	'article-comments-vote' => 'Memberikan suara',
	'article-comments-reply' => 'Balas',
	'article-comments-show-all' => 'Perlihatkan semua komentar',
	'article-comments-prev-page' => 'Sebelumnya',
	'article-comments-next-page' => 'Selanjutnya',
);

/** Ingush (ГӀалгӀай)
 * @author Sapral Mikail
 */
$messages['inh'] = array(
	'article-comments-cancel' => 'ДIадаккха',
	'article-comments-delete' => 'дIадаккха',
	'article-comments-edit' => 'хувца',
	'article-comments-history' => 'искар',
);

/** Italian (italiano)
 * @author Beta16
 * @author Geitost
 * @author Leviathan 89
 * @author Minerva Titani
 * @author Ximo17
 */
$messages['it'] = array(
	'article-comments-anonymous' => 'Utente anonimo',
	'article-comments-comments' => 'Commenti ($1)',
	'article-comments-post' => 'Lascia un commento',
	'article-comments-cancel' => 'Annulla',
	'article-comments-delete' => 'cancella',
	'article-comments-edit' => 'modifica',
	'article-comments-history' => 'cronologia',
	'article-comments-error' => 'Il commento non è stato salvato',
	'article-comments-undeleted-comment' => 'Commenti non cancellati della pagina $1',
	'article-comments-rc-comment' => 'Commento dell\'articolo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Commenti articolo ([[$1]])',
	'article-comments-fblogin' => 'Per favore <a href="$1" rel="nofollow">accedi a Facebook</a> per commentare su questa wiki!',
	'article-comments-fbconnect' => 'Per favore <a href="$1">connetti questo account a Facebook</a> per commentare!',
	'article-comments-rc-blog-comment' => 'Commento blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Commenti blog ([[$1]])',
	'article-comments-login' => 'Per favore <a href="$1">accedi</a> per postare un commento su questa wiki.',
	'article-comments-toc-item' => 'Commenti',
	'article-comments-comment-cannot-add' => "Non puoi commentare l'articolo",
	'article-comments-vote' => 'Vota',
	'article-comments-reply' => 'Rispondi',
	'article-comments-show-all' => 'Mostra tutti i commenti',
	'article-comments-prev-page' => 'Prec',
	'article-comments-next-page' => 'Succ',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => "L'articolo / commento padre è stato cancellato.",
	'article-comments-empty-comment' => "Non puoi inserire un commento vuoto. <a href='$1'>Vuoi cancellarlo invece?</a>",
	'wikiamobile-article-comments-header' => 'Commenti (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Caricane altri',
	'wikiamobile-article-comments-prev' => 'Carica precedenti',
	'wikiamobile-article-comments-none' => 'Nessun commento',
	'wikiamobile-article-comments-view' => 'Visualizza risposte',
	'wikiamobile-article-comments-replies' => 'risposte',
	'wikiamobile-article-comments-post-reply' => 'Rispondi',
	'wikiamobile-article-comments-post' => 'Posta',
	'wikiamobile-article-comments-placeholder' => 'Commenta',
	'wikiamobile-article-comments-show' => 'Mostra',
	'wikiamobile-article-comments-login-post' => 'Effettua il login per lasciare un commento.',
	'enotif_subject_article_comment' => '$PAGEEDITOR ha commentato su "$PAGETITLE" su {{SITENAME}}',
	'enotif_body_article_comment' => 'Caro $WATCHINGUSERNAME,

$PAGEEDITOR ha commentato su "$PAGETITLE".

Per vedere il commento, seguire il link qui sotto:
$PAGETITLE_URL

Per favore continua a visitare e contribuire spesso...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Caro $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR ha commentato su "$PAGETITLE".
<br /><br />
Per vedere il commento, seguire il link: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Per favore continua a visitare e contribuire spesso...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Vuoi scegliere quali e-mail ricevere? <a href="{{fullurl:Special:Preferences}}">Aggiorna le tue preferenze<a>...</a> </a></li>
</ul>
</p>',
);

/** Japanese (日本語)
 * @author 2nd-player
 * @author Schu
 * @author Shirayuki
 * @author Tommy6
 */
$messages['ja'] = array(
	'article-comments-anonymous' => '匿名利用者',
	'article-comments-comments' => 'コメント ($1)',
	'article-comments-post' => 'コメントを投稿',
	'article-comments-cancel' => '中止',
	'article-comments-delete' => '削除',
	'article-comments-edit' => '編集',
	'article-comments-history' => '履歴',
	'article-comments-error' => 'コメントを保存できませんでした',
	'article-comments-undeleted-comment' => 'ブログの記事 $1 へのコメントを復帰',
	'article-comments-rc-comment' => '記事コメント（<span class="plainlinks">[$1 $2]</span>）',
	'article-comments-rc-comments' => '記事コメント（[[$1]]）',
	'article-comments-fblogin' => 'コメントするには<a href="$1" rel="nofollow">ログインしてアカウントを Facebook に接続してください</a>。',
	'article-comments-fbconnect' => 'コメントするには<a href="$1">アカウントを Facebook に接続してください</a>。',
	'article-comments-rc-blog-comment' => 'ブログコメント（<span class="plainlinks">[$1 $2]</span>）',
	'article-comments-rc-blog-comments' => 'ブログコメント（[[$1]]）',
	'article-comments-login' => 'コメントするには<a href="$1">ログイン</a>する必要があります',
	'article-comments-toc-item' => 'コメント',
	'article-comments-comment-cannot-add' => 'この記事にはコメントを追加できません。',
	'article-comments-vote' => '投票する',
	'article-comments-reply' => '返信する',
	'article-comments-show-all' => '全てのコメントを表示',
	'article-comments-prev-page' => '前',
	'article-comments-next-page' => '次',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '親記事/親コメントが削除されました',
	'article-comments-empty-comment' => "空コメントを投稿することはできません。<a href='$1'>コメントを削除しますか？</a>",
	'wikiamobile-article-comments-post-reply' => '返信を投稿',
	'wikiamobile-article-comments-post' => '投稿',
	'wikiamobile-article-comments-placeholder' => 'コメントを投稿',
	'wikiamobile-article-comments-show' => '表示',
	'enotif_subject_article_comment' => '{{SITENAME}} のページ「$PAGETITLE」に $PAGEEDITOR がコメントを投稿しました',
	'enotif_body_article_comment' => '$WATCHINGUSERNAMEさん、

$PAGETITLE に $PAGEEDITOR がコメントをつけました。

コメントを見るには次のURLにアクセスしてください:
$PAGETITLE_URL

Wikia',
	'enotif_body_article_comment-HTML' => '<p>$WATCHINGUSERNAMEさん、
<br /><br />
$PAGETITLE に $PAGEEDITOR がコメントをつけました。
<br /><br />
コメントを見るには次のURLにアクセスしてください:<br />
<a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Wikia
</p>',
);

/** Khmer (ភាសាខ្មែរ)
 * @author T-Rithy
 */
$messages['km'] = array(
	'article-comments-cancel' => 'បោះបង់',
	'article-comments-delete' => 'លប់',
	'article-comments-edit' => 'កែប្រែ',
	'article-comments-history' => 'ប្រវត្តិ',
	'article-comments-error' => 'មតិនេះមិនត្រូវបានរក្សាទុកទេ',
	'article-comments-toc-item' => 'មតិ',
	'article-comments-reply' => 'ឆ្លើយតប',
	'article-comments-prev-page' => 'មុន​',
	'article-comments-next-page' => 'បន្ទាប់',
);

/** Korean (한국어)
 * @author Cafeinlove
 */
$messages['ko'] = array(
	'article-comments-anonymous' => '익명 사용자',
	'article-comments-cancel' => '취소',
	'article-comments-delete' => '삭제',
	'article-comments-edit' => '편집',
	'article-comments-history' => '역사',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'article-comments-anonymous' => 'Nameloose Metmaacher',
	'article-comments-comments' => 'Aanmärkonge ($1)',
	'article-comments-post' => 'Aanmärkong dobei donn',
	'article-comments-delete' => 'fottschmieße',
	'article-comments-edit' => 'ändere',
	'article-comments-history' => 'Ällder Versione',
	'article-comments-error' => 'Di Aanmärkong kunnte mer nit faßhallde.',
	'article-comments-rc-comment' => 'Aanmärkong zom Atikel (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Aanmärkonge zom Atikel ([[$1]])',
	'article-comments-rc-blog-comment' => 'Aanmärkong zom <i lang="en">blog</i> (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Aanmärkonge zom <i lang="en">blog</i> ([[$1]])',
	'article-comments-toc-item' => 'Aanmärkunge',
	'article-comments-comment-cannot-add' => 'Do kanns kein Aanmärkong zom Atikel maache',
	'article-comments-reply' => 'Antwoote',
	'article-comments-show-all' => 'All de Aanmärkonge zeije',
	'article-comments-prev-page' => 'Vörije',
	'article-comments-next-page' => 'Nächsde',
	'article-comments-page-spacer' => '&#160...&#160',
	'enotif_subject_article_comment' => '$PAGEEDITOR hädd_en Aanmärkong zoh "$PAGETITLE" op {{SITENAME}} jemaat.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'article-comments-delete' => 'jê bibe',
	'article-comments-edit' => 'biguherîne',
	'article-comments-history' => 'dîrok',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'article-comments-anonymous' => 'Anonyme Benotzer',
	'article-comments-comments' => 'Bemierkungen ($1)',
	'article-comments-post' => 'Bemierkung derbäisetzen',
	'article-comments-cancel' => 'Ofbriechen',
	'article-comments-delete' => 'läschen',
	'article-comments-edit' => 'änneren',
	'article-comments-history' => 'Versiounen',
	'article-comments-error' => "D'Bemierkung konnt net gespäichert ginn",
	'article-comments-undeleted-comment' => "Restauréiert Bemierkung dir d'Blog-Säit $1",
	'article-comments-rc-comment' => 'Bemierkung vum Artikel (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Bemierkunge vum Artikel ([[$1]])',
	'article-comments-fblogin' => '<a href="$1">Loggt Iech an a verbannt mat Facebook</a> fir eng Bemierkung op dëser Wiki ze schreiwen!',
	'article-comments-toc-item' => 'Bemierkungen',
	'article-comments-comment-cannot-add' => 'Dir däerft keng Bemierkung bäi den Artikel derbäisetzen.',
	'article-comments-reply' => 'Äntwerten',
	'article-comments-show-all' => 'All Bemierkunge weisen',
	'article-comments-prev-page' => 'Vireg',
	'article-comments-next-page' => 'Nächst',
	'wikiamobile-article-comments-none' => 'Keng Bemierkungen',
	'wikiamobile-article-comments-view' => 'Äntwerte kucken',
	'wikiamobile-article-comments-replies' => 'Äntwerten',
	'wikiamobile-article-comments-show' => 'Weisen',
);

/** Lezghian (лезги)
 * @author Migraghvi
 */
$messages['lez'] = array(
	'article-comments-anonymous' => 'ТIвар къалур тавунвай иштиракчи',
	'article-comments-comments' => 'КЪейдер ($1)',
	'article-comments-post' => 'КЪейд ттун',
	'article-comments-cancel' => 'Гьич авун',
	'article-comments-delete' => 'Алудун',
	'article-comments-edit' => 'Дуьзар хъувун',
	'article-comments-history' => 'Тарих',
	'article-comments-error' => 'КЪейд хуьз жезвач',
	'article-comments-undeleted-comment' => 'Блогдин $1 ччина алуд тавунвай къейд',
	'article-comments-toc-item' => 'КЪейдер',
	'article-comments-comment-cannot-add' => 'Квевай макъаладиз къейд алава ийиз ихтияр авайд ттуш.',
	'article-comments-vote' => 'Сес гун',
	'article-comments-reply' => 'Жаваб гун',
	'article-comments-show-all' => 'Вири къейдер къалурун',
	'article-comments-prev-page' => 'Вилик алатай',
	'article-comments-next-page' => 'Къведай',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Асул макъала/асул къейд алуднава.',
	'wikiamobile-article-comments-more' => 'Мадни ппарун',
	'wikiamobile-article-comments-prev' => 'Вилик алатай ппарун',
	'wikiamobile-article-comments-none' => 'КЪейдер авайд ттуш',
	'enotif_body_article_comment-HTML' => '<p>Играми $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR къейд ттуна "$PAGETITLE".
<br /><br />
А къейддиз килигун патал иниз элячIа: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Викия
<br /><hr />
<ul>
<li>КЪвезвай email-ин низамарунар дегишиз кIанзава ниl? <a href="{{fullurl:Special:Preferences}}">Жуван низамарунар цIийи хъия<a>.</li>
</ul>
</p>',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'article-comments-anonymous' => 'Anoniminis vartotojas',
	'article-comments-comments' => 'Komentarai ( $1 )',
	'article-comments-post' => 'Rašyti komentarą',
	'article-comments-cancel' => 'Atšaukti',
	'article-comments-delete' => 'ištrinti',
	'article-comments-edit' => 'redaguoti',
	'article-comments-history' => 'istorija',
	'article-comments-error' => 'Komentaras negali būti išsaugotas',
	'article-comments-rc-blog-comment' => 'Blog\'o komentaras (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => "Blog'o komentarai ([[$1]])",
	'article-comments-login' => 'Prašome <a href="$1">prisijungti</a> kad galėtumėte rašyti šioje wiki.',
	'article-comments-toc-item' => 'Komentarai',
	'article-comments-comment-cannot-add' => 'Jūs negalite pridėti komentarą į ši straipsnį.',
	'article-comments-reply' => 'Atsakyti',
	'article-comments-show-all' => 'Rodyti visus komentarus',
	'article-comments-prev-page' => 'Ankstesnis',
	'article-comments-next-page' => 'Sekantis',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'komentarai <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Įkelti daugiau',
	'wikiamobile-article-comments-prev' => 'Įkelti ankstesni',
	'wikiamobile-article-comments-none' => 'Nėra komentarų',
	'wikiamobile-article-comments-post' => 'Rašyti',
	'wikiamobile-article-comments-placeholder' => 'Rašyti komentarą',
	'wikiamobile-article-comments-show' => 'Rodyti',
);

/** Lushai (Mizo ţawng)
 * @author RMizo
 */
$messages['lus'] = array(
	'article-comments-anonymous' => 'Hmangtu hming lang lo',
	'article-comments-comments' => 'Tuihnihna ($1)',
	'article-comments-post' => 'Tuihnih rawh le',
	'article-comments-cancel' => 'Sûtna',
	'article-comments-delete' => 'paihna',
	'article-comments-edit' => 'siamţhatna',
	'article-comments-history' => 'chanchin',
	'article-comments-error' => 'I tuihnihna a dahţhat theih loh tlat',
	'article-comments-rc-comment' => 'Thuziak tuihnihna (<span class="plainlinks"> [$1 $2]</span>',
	'article-comments-rc-comments' => 'Thuziak tuihnihna ([[$1]])',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'article-comments-anonymous' => 'Анонимен корисник',
	'article-comments-comments' => 'Коментари ($1)',
	'article-comments-post' => 'Објави коментар',
	'article-comments-cancel' => 'Откажи',
	'article-comments-delete' => 'избриши',
	'article-comments-edit' => 'уреди',
	'article-comments-history' => 'историја',
	'article-comments-error' => 'Коментарот не може да се зачува',
	'article-comments-undeleted-comment' => 'Вратен избришаниот коментар на блоговската страница $1',
	'article-comments-rc-comment' => 'Коментар на статија (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Коментари на статија ([[$1]])',
	'article-comments-fblogin' => '<a href="$1">Најавете се и поврзете се со Facebook</a> за да коментирате на ова вики!',
	'article-comments-fbconnect' => '<a href="$1">Поврзете ја сметката со Facebook</a> за да коментирате!',
	'article-comments-rc-blog-comment' => 'Блоговски коментар (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Блоговски коментари ([[$1]])',
	'article-comments-login' => '<a href="$1">Најавете се</a> за да коментирате на ова вики.',
	'article-comments-toc-item' => 'Коментари',
	'article-comments-comment-cannot-add' => 'Не можете да додавате комнтари во статијата.',
	'article-comments-vote' => 'Гласај „За“',
	'article-comments-reply' => 'Одговори',
	'article-comments-show-all' => 'Сите коментари',
	'article-comments-prev-page' => 'Претходна',
	'article-comments-next-page' => 'Следна',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Матичната статија / матичниот коментар е избришан.',
	'article-comments-empty-comment' => "Не можете да објавите празен коментар. <a href='$1'>Да го избришам?</a>",
	'wikiamobile-article-comments-header' => 'коментари (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Вчитај уште',
	'wikiamobile-article-comments-prev' => 'Вчитај претходни',
	'wikiamobile-article-comments-none' => 'Нема коментари',
	'wikiamobile-article-comments-view' => 'Погл. одговори',
	'wikiamobile-article-comments-replies' => 'одговори',
	'wikiamobile-article-comments-post-reply' => 'Дајте одговор',
	'wikiamobile-article-comments-post' => 'Објави',
	'wikiamobile-article-comments-placeholder' => 'Објави коментар',
	'wikiamobile-article-comments-show' => 'Прикажи',
	'wikiamobile-article-comments-login-post' => 'Најавете се за да можете да коментирате.',
	'enotif_subject_article_comment' => '$PAGEEDITOR коментираше на „$PAGETITLE“ на {{SITENAME}}',
	'enotif_body_article_comment' => 'Здраво $WATCHINGUSERNAME,

Има нов коментар на страницата $PAGETITLE на {{SITENAME}}. Сите коментари ќе ги најдете тука: $PAGETITLE_URL#WikiaArticleComments

- Поддршка за заедницата на Викија

___________________________________________
* Помош и совети за Викија ќе добиете во Центарот на заедницата: http://community.wikia.com
* Сакате да добивате помалку пораки од нас? Тука можете да ја откажете претплатата или да ги измените поставките за е-пошта: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Здраво $WATCHINGUSERNAME,
<br /><br />
Има нов коментар на страницата $PAGETITLE на {{SITENAME}}. Сите коментари ќе ги најдете тука: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Поддршка за заедницата на Викија
<br /><br />
___________________________________________
<ul>
<li>омош и совети за Викија ќе добиете во Центарот на заедницата: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Сакате да добивате помалку пораки од нас? Тука можете да ја откажете претплатата или да ги измените поставките за е-пошта: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'article-comments-anonymous' => 'അജ്ഞാത ഉപയോക്താവ്',
	'article-comments-comments' => 'അഭിപ്രായങ്ങൾ ($1)',
	'article-comments-post' => 'അഭിപ്രായം പ്രസിദ്ധീകരിക്കുക',
	'article-comments-delete' => 'മായ്ക്കുക',
	'article-comments-edit' => 'തിരുത്തുക',
	'article-comments-history' => 'നാൾവഴി',
	'article-comments-error' => 'അഭിപ്രായം സേവ് ചെയ്യാൻ കഴിഞ്ഞില്ല',
	'article-comments-rc-comment' => 'ലേഖനത്തെക്കുറിച്ചുള്ള അഭിപ്രായം (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'ലേഖനത്തെക്കുറിച്ചുള്ള അഭിപ്രായങ്ങൾ ([[$1]])',
	'article-comments-toc-item' => 'അഭിപ്രായങ്ങൾ',
	'article-comments-reply' => 'മറുപടി',
	'article-comments-show-all' => 'എല്ലാ അഭിപ്രായങ്ങളും പ്രദർശിപ്പിക്കുക',
	'article-comments-prev-page' => 'മുമ്പ്',
	'article-comments-next-page' => 'അടുത്തത്',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'article-comments-anonymous' => 'Pengguna tanpa nama',
	'article-comments-comments' => 'Ulasan ($1)',
	'article-comments-post' => 'Kirim ulasan',
	'article-comments-cancel' => 'Batalkan',
	'article-comments-delete' => 'hapuskan',
	'article-comments-edit' => 'sunting',
	'article-comments-history' => 'sejarah',
	'article-comments-error' => 'Ulasan tidak dapat disimpan',
	'article-comments-undeleted-comment' => 'Ulasan yang dinyahhapuskan untuk laman blog $1',
	'article-comments-rc-comment' => 'Ulasan rencana (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Ulasan rencana ([[$1]])',
	'article-comments-fblogin' => 'Sila <a href="$1">log masuk dan bersambung dengan Facebook</a> untuk mengirimkan ulasan di wiki ini!',
	'article-comments-fbconnect' => 'Sila <a href="$1">sambungkan akaun ini dengan Facebook</a> untuk mengulas!',
	'article-comments-rc-blog-comment' => 'Ulasan blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Ulasan blog ([[$1]])',
	'article-comments-login' => 'Sila <a href="$1">log masuk</a> untuk mengirim ulasan di wiki ini.',
	'article-comments-toc-item' => 'Ulasan',
	'article-comments-comment-cannot-add' => 'Anda tidak boleh mengirim ulasan kepada rencana ini.',
	'article-comments-vote' => 'Undi setuju',
	'article-comments-reply' => 'Balas',
	'article-comments-show-all' => 'Tunjukkan semua ulasan',
	'article-comments-prev-page' => 'Sebelumnya',
	'article-comments-next-page' => 'Seterusnya',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Rencana induk / ulasan induk telah dihapuskan.',
	'article-comments-empty-comment' => "Anda tidak boleh mengirim ulasan kososng. <a href='$1'>Nak padamkan atau tak?</a>",
	'wikiamobile-article-comments-header' => 'komen (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Muatkan lagi',
	'wikiamobile-article-comments-prev' => 'Muatkan yang sebelumnya',
	'wikiamobile-article-comments-none' => 'Tiada komen',
	'wikiamobile-article-comments-view' => 'Baca balasan',
	'wikiamobile-article-comments-replies' => 'balasan',
	'wikiamobile-article-comments-post-reply' => 'Balas',
	'wikiamobile-article-comments-post' => 'Hantar',
	'wikiamobile-article-comments-placeholder' => 'Hantar ulasan',
	'wikiamobile-article-comments-show' => 'Paparkan',
	'wikiamobile-article-comments-login-post' => 'Sila log masuk untuk berkomen.',
	'enotif_subject_article_comment' => '$PAGEEDITOR telah mengulas "$PAGETITLE" di {{SITENAME}}',
	'enotif_body_article_comment' => '$WATCHINGUSERNAME,

Terdapat komen baru pada $PAGETITLE di {{SITENAME}}. Ikut pautan ini untuk melihat semua komen: $PAGETITLE_URL#WikiaArticleComments

- Bantuan Komuniti Wikia

___________________________________________
* Dapatkan bantuan dan nasihat di Pusat Komuniti: http://community.wikia.com
* Ingin mengurangkan penerimaan pesanan daripada kami? Anda boleh berhenti melanggan atau menukar keutamaan anda di sini: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>$WATCHINGUSERNAME,
<br /><br />
Terdapat komen baru pada $PAGETITLE di {{SITENAME}}. Ikut pautan ini untuk melihat semua komen: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Bantuan Komuniti Wikia
<br /><br />
___________________________________________
<ul>
<li> Dapatkan bantuan dan nasihat di Pusat Komuniti: <a href="http://community.wikia.com">http://community.wikia.com</a></li>
<li> Ingin mengurangkan penerimaan pesanan daripada kami? Anda boleh berhenti melanggan atau menukar keutamaan anda di sini: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'article-comments-edit' => 'دچی‌ین',
	'article-comments-history' => 'تاریخچه',
	'article-comments-undeleted-comment' => 'نظر صفحۀ وبلاگ $1 وسّه احیاء بیّه',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'article-comments-anonymous' => 'Anonym bruker',
	'article-comments-comments' => 'Kommentarer ($1)',
	'article-comments-post' => 'Post kommentar',
	'article-comments-cancel' => 'Avbryt',
	'article-comments-delete' => 'slett',
	'article-comments-edit' => 'rediger',
	'article-comments-history' => 'historikk',
	'article-comments-error' => 'Kommentaren kunne ikke lagres',
	'article-comments-undeleted-comment' => 'Angret slettning av kommetar for bloggsiden $1',
	'article-comments-rc-comment' => 'Artikkelkommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artikkelkommentarer ([[$1]])',
	'article-comments-fblogin' => 'Vennligst <a href="$1">logg inn og koble deg til Facebook</a> for å poste en kommentar på denne wikien!',
	'article-comments-fbconnect' => 'Vennligst <a href="$1">koble denne kontoen til Facebook</a> for å kommentere!',
	'article-comments-rc-blog-comment' => 'Bloggkommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Bloggkommentarer ([[$1]])',
	'article-comments-login' => 'Vennligst <a href="$1">logg inn</a> for å kommentere på denne wikien.',
	'article-comments-toc-item' => 'Kommentarer',
	'article-comments-comment-cannot-add' => 'Du kan ikke legge en kommentar til artikkelen.',
	'article-comments-vote' => 'Stem opp',
	'article-comments-reply' => 'Svar',
	'article-comments-show-all' => 'Vis alle kommentarer',
	'article-comments-prev-page' => 'Forrige',
	'article-comments-next-page' => 'Neste',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Overordnet artikkel/overordnet kommentar har blitt slettet.',
	'article-comments-empty-comment' => "Du kan ikke poste en tom kommentar. <a href='$1'>Slette den istedenfor?</a>",
	'wikiamobile-article-comments-header' => 'kommentarer (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Last inn mer',
	'wikiamobile-article-comments-prev' => 'Last forrige',
	'wikiamobile-article-comments-none' => 'Ingen kommentarer',
	'wikiamobile-article-comments-view' => 'Vis svar',
	'wikiamobile-article-comments-replies' => 'svar',
	'wikiamobile-article-comments-post-reply' => 'Post et svar',
	'wikiamobile-article-comments-post' => 'Post',
	'wikiamobile-article-comments-placeholder' => 'Post en kommentar',
	'wikiamobile-article-comments-show' => 'Vis',
	'wikiamobile-article-comments-login-post' => 'Vennligst logg inn for å poste en kommentar.',
	'enotif_subject_article_comment' => '$PAGEEDITOR har kommentert «$PAGETITLE» på {{SITENAME}}',
	'enotif_body_article_comment' => 'Hei $WATCHINGUSERNAME,

Det er en ny kommentar til $PAGETITLE på {{SITENAME}}. Bruk denne lenken for å se alle kommentarene: $PAGETITLE_URL#WikiaArticleComments

- Wikia fellesskapssupporten

___________________________________________
* Finn hjelp og råd på Fellesskapssentralen: http://community.wikia.com
* Vil du motta færre meldinger fra oss? Du kan avslutte abonnementet eller endre e-postinnstillingene dine her: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hei $WATCHINGUSERNAME,
<br /><br />
Det er en ny kommentar til $PAGETITLE på {{SITENAME}}. Bruk denne lenken for å se alle kommentarene: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia fellesskapssupporten
<br /><br />
___________________________________________
<ul>
<li>Finn hjelp og råd på Fellesskapssentralen: <a href="http://community.wikia.com">http://community.wikia.com</a></li>
<li>Vil du motta færre meldinger fra oss? Du kan avslutte abonnementet eller endre e-postinnstillingene dine her: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'article-comments-anonymous' => 'Anonieme gebruiker',
	'article-comments-comments' => 'Opmerkingen ($1)',
	'article-comments-post' => 'Opmerking plaatsen',
	'article-comments-cancel' => 'Annuleren',
	'article-comments-delete' => 'verwijderen',
	'article-comments-edit' => 'bewerken',
	'article-comments-history' => 'geschiedenis',
	'article-comments-error' => 'De opmerking kon niet opgeslagen worden',
	'article-comments-undeleted-comment' => 'Heeft een opmerking op blogpagina $1 teruggeplaatst',
	'article-comments-rc-comment' => 'Opmerking bij pagina (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Opmerkingen bij pagina ([[$1]])',
	'article-comments-fblogin' => '<a href="$1">Meld u aan en verbind met Facebook</a> om een opmerking in deze wiki te plaatsen.',
	'article-comments-fbconnect' => '<a href="$1">Verbind deze gebruiker met Facebook</a> om opmerkingen te plaatsen.',
	'article-comments-rc-blog-comment' => 'Opmerking bij blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Opmerkingen bij blog ([[$1]])',
	'article-comments-login' => '<a href="$1">Meld u aan</a> om een opmerking in deze wiki te kunnen plaatsen.',
	'article-comments-toc-item' => 'Opmerkingen',
	'article-comments-comment-cannot-add' => 'U kunt geen opmerkingen bij de pagina plaatsen.',
	'article-comments-vote' => 'Positief beoordelen',
	'article-comments-reply' => 'Antwoorden',
	'article-comments-show-all' => 'Alle opmerkingen weergeven',
	'article-comments-prev-page' => 'Vorige',
	'article-comments-next-page' => 'Volgende',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'De bovenliggende pagina is verwijderd.',
	'article-comments-empty-comment' => "U kunt geen opmerking zonder inhoud plaatsen. <a href='$1'>In plaats daarvan verwijderen?</a>",
	'wikiamobile-article-comments-header' => 'opmerkingen <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Meer laden',
	'wikiamobile-article-comments-prev' => 'Vorige laden',
	'wikiamobile-article-comments-none' => 'Geen reacties',
	'wikiamobile-article-comments-view' => 'Antwoorden bekijken',
	'wikiamobile-article-comments-replies' => 'antwoorden',
	'wikiamobile-article-comments-post-reply' => 'Reactie plaatsen',
	'wikiamobile-article-comments-post' => 'Opslaan',
	'wikiamobile-article-comments-placeholder' => 'Opmerking plaatsen',
	'wikiamobile-article-comments-show' => 'Weergeven',
	'wikiamobile-article-comments-login-post' => 'Meld u aan om te reageren.',
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
<li>Wilt u bepalen welke e-mails u ontvangt? <a href="{{fullurl:{{ns:special}}:Preferences}}">Pas dan uw Voorkeuren aan<a>.</li>
</ul>
</p>',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'article-comments-comment-cannot-add' => 'Je kunt geen opmerkingen bij de pagina plaatsen.',
	'article-comments-empty-comment' => "Je kunt geen opmerking zonder inhoud plaatsen. <a href='$1'>In plaats daarvan verwijderen?</a>",
	'enotif_body_article_comment-HTML' => '<p>Hoi $WATCHINGUSERNAME,
<br /><br />
$ PAGEEDITOR heeft een opmerking geplaatst bij "$PAGETITLE".
<br /><br />
Je kunt de discussie bekijken via de volgende verwijzing: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Kom alsjeblieft vaak langs en bewerk veelvuldig...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Wilt je bepalen welke e-mails je ontvangt? <a href="{{fullurl:{{ns:special}}:Preferences}}">Pas dan je Voorkeuren<a> aan.</li>
</ul>
</p>',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'article-comments-anonymous' => 'Uoagmeldede Benudza',
	'article-comments-cancel' => 'Uffhere',
	'article-comments-delete' => 'lesche',
	'article-comments-edit' => 'bearwaide',
	'article-comments-history' => 'Gschischd',
	'article-comments-reply' => 'Oandwoade',
	'wikiamobile-article-comments-show' => 'Zaische',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 * @author Woytecr
 */
$messages['pl'] = array(
	'article-comments-anonymous' => 'Anonimowy użytkownik',
	'article-comments-comments' => 'Komentarze ($1)',
	'article-comments-post' => 'Wyślij komentarz',
	'article-comments-cancel' => 'Anuluj',
	'article-comments-delete' => 'usuń',
	'article-comments-edit' => 'edytuj',
	'article-comments-history' => 'historia',
	'article-comments-error' => 'Komentarz nie mógł zostać zapisany.',
	'article-comments-undeleted-comment' => 'Przywrócony komentarz na blogu $1',
	'article-comments-rc-comment' => 'Komentarz  (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Komentarze ([[$1]])',
	'article-comments-fblogin' => '<a href="$1" rel="nofollow">Zaloguj się i połącz przez Facebook</a> aby zostawić komentarz na tej wiki',
	'article-comments-fbconnect' => '<a href="$1">Połącz to konto z Facebookiem</a> aby dodać komentarz',
	'article-comments-rc-blog-comment' => 'Komentarz (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Komentarze ([[$1]])',
	'article-comments-login' => '<a href="$1">Zaloguj się</a>, aby komentować',
	'article-comments-toc-item' => 'Komentarze',
	'article-comments-comment-cannot-add' => 'Nie możesz dodać komentarza do tego artykułu',
	'article-comments-vote' => 'Zagłosuj',
	'article-comments-reply' => 'Odpowiedz',
	'article-comments-show-all' => 'Pokaż wszystkie komentarze',
	'article-comments-prev-page' => 'Poprzednia',
	'article-comments-next-page' => 'Następna',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Główny artykuł / komentarz został usunięty',
	'article-comments-empty-comment' => "Nie możesz zapisać pustego komentarza <a href='$1'>Usunąć?</a>",
	'wikiamobile-article-comments-header' => 'komentarze <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Załaduj więcej',
	'wikiamobile-article-comments-prev' => 'Załaduj poprzednie',
	'wikiamobile-article-comments-none' => 'Brak komentarzy',
	'wikiamobile-article-comments-view' => 'Pokaż odpowiedzi',
	'wikiamobile-article-comments-replies' => 'odpowiedzi',
	'wikiamobile-article-comments-post-reply' => 'Publikuj odpowiedź',
	'wikiamobile-article-comments-post' => 'Publikuj',
	'wikiamobile-article-comments-placeholder' => 'Wyślij komentarz',
	'wikiamobile-article-comments-show' => 'Pokaż',
	'wikiamobile-article-comments-login-post' => 'Zaloguj się aby dodać komentarz.',
	'enotif_subject_article_comment' => '$PAGEEDITOR skomentował "$PAGETITLE" na {{SITENAME}}',
	'enotif_body_article_comment' => 'Witaj $WATCHINGUSERNAME,

Na {{SITENAME}} pojawił się nowy komentarz na stronie $PAGETITLE . Użyj tego linku aby zobaczyć wszystkie komentarze: $PAGETITLE_URL#WikiaArticleComments

- Zespół Wikii

___________________________________________
* Aby uzyskać dodatkową pomoc od społeczności Wikii, odwiedź http://spolecznosc.wikia.com
* W celu zmiany ustawień powiadomień e-mail, odwiedź http://spolecznosc.wikia.com/wiki/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Witaj $WATCHINGUSERNAME,
<br /><br />
Na {{SITENAME}} pojawił się nowy komentarz na stronie $PAGETITLE . Użyj tego linku aby zobaczyć wszystkie komentarze: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Zespół Wikii
<br /><br />
___________________________________________
<ul>
<li>Aby uzyskać dodatkową pomoc od społeczności Wikii, odwiedź <a href="http://spolecznosc.wikia.com">Centrum Społeczności</a>.</li>
<li>W celu zmiany ustawień powiadomień e-mail, odwiedź <a href="http://spolecznosc.wikia.com/wiki/Special:Preferences">tą stronę</a>.</li>
</ul>
</p>',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'article-comments-anonymous' => 'ورکنومی کارن',
	'article-comments-comments' => 'تبصرې ($1)',
	'article-comments-cancel' => 'ناګارل',
	'article-comments-delete' => 'ړنګول',
	'article-comments-edit' => 'سمول',
	'article-comments-history' => 'پېښليک',
	'article-comments-toc-item' => 'تبصرې',
	'article-comments-reply' => 'ځوابول',
	'article-comments-show-all' => 'ټولې تبصرې ښکاره کول',
	'article-comments-prev-page' => 'پخوانی',
	'article-comments-next-page' => 'راتلونکی',
	'wikiamobile-article-comments-view' => 'ځوابونه کتل',
	'wikiamobile-article-comments-replies' => 'ځوابونه',
	'wikiamobile-article-comments-post-reply' => 'يو ځواب ورکول',
	'wikiamobile-article-comments-show' => 'ښکاره کول',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author SandroHc
 * @author Waldir
 */
$messages['pt'] = array(
	'article-comments-anonymous' => 'Utilizador anónimo',
	'article-comments-comments' => 'Comentários ($1)',
	'article-comments-post' => 'Publicar comentário',
	'article-comments-cancel' => 'Cancelar',
	'article-comments-delete' => 'eliminar',
	'article-comments-edit' => 'editar',
	'article-comments-history' => 'histórico',
	'article-comments-error' => 'Não foi possível gravar o comentário',
	'article-comments-undeleted-comment' => 'Comentário recuperado para a página de blogue $1',
	'article-comments-rc-comment' => 'Comentário de artigo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Comentários de artigo ([[$1]])',
	'article-comments-fblogin' => 'Por favor, <a href="$1">autentique-se e ligue-se ao Facebook</a> para publicar um comentário nesta wiki!',
	'article-comments-fbconnect' => 'Por favor <a href="$1">associe esta conta ao Facebook</a> para comentar!',
	'article-comments-rc-blog-comment' => 'Comentário de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentários de blogue ([[$1]])',
	'article-comments-login' => 'Por favor, <a href="$1">autentique-se</a> para publicar um comentário nesta wiki.',
	'article-comments-toc-item' => 'Comentários',
	'article-comments-comment-cannot-add' => 'Não pode adicionar um comentário ao artigo.',
	'article-comments-vote' => 'Voto positivo',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos os comentários',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Próximo',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'O artigo raiz / comentário raiz foi apagado.',
	'article-comments-empty-comment' => "Não pode publicar um comentário vazio. <a href='$1'>Quer apagá-lo?</a>",
	'wikiamobile-article-comments-header' => 'comentários (<span class=cnt id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Ler mais',
	'wikiamobile-article-comments-prev' => 'Ler anteriores',
	'wikiamobile-article-comments-none' => 'Sem comentários',
	'wikiamobile-article-comments-view' => 'Ver respostas',
	'wikiamobile-article-comments-replies' => 'respostas',
	'wikiamobile-article-comments-post-reply' => 'Publicar uma resposta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Publicar um comentário',
	'wikiamobile-article-comments-show' => 'Mostrar',
	'wikiamobile-article-comments-login-post' => 'Inicie sessão antes de publicar um comentário.',
	'enotif_subject_article_comment' => '$PAGEEDITOR comentou "$PAGETITLE" na {{SITENAME}}',
	'enotif_body_article_comment' => 'Olá $WATCHINGUSERNAME,

Existe um novo comentário em $PAGETITLE na {{SITENAME}}. Usa este link para ver todos os comentários: $PAGETITLE_URL#WikiaArticleComments

- Suporte da Comunidade da Wikia

___________________________________________
* Encontra ajuda e conselhos na Central da Comunidade: http://community.wikia.com
* Desejas receber menos mensagens nossas? Podes des-subscrever ou alterar as tuas preferências de e-mail aqui: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Caro $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR fez um comentário em "$PAGETITLE".
<br /><br />
Para ver a lista de discussão do comentário, siga este link: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Por favor, visite e edite muitas vezes...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Quer controlar os e-mails que recebe? <a href="{{fullurl:Special:Preferences}}">Actualize as suas preferências<a>.</li>
</ul>
</p>',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Caio1478
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'article-comments-anonymous' => 'Usuário anônimo',
	'article-comments-comments' => 'Comentários ($1)',
	'article-comments-post' => 'Postar comentário',
	'article-comments-cancel' => 'Cancelar',
	'article-comments-delete' => 'apagar',
	'article-comments-edit' => 'editar',
	'article-comments-history' => 'histórico',
	'article-comments-error' => 'O comentário não pôde ser salvo.',
	'article-comments-undeleted-comment' => 'Comentário não deletado para a página do blog $1',
	'article-comments-rc-comment' => 'Comentário do artigo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Comentário do artigo ([[$1]])',
	'article-comments-fblogin' => 'Por favor, <a href="$1">efetue o login e conecte-se com o Facebook</a> para postar um comentário sobre esta wiki!',
	'article-comments-fbconnect' => 'Por favor <a href="$1">ligue essa conta com o Facebook</a> para comentar!',
	'article-comments-rc-blog-comment' => 'Comentário de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentário de blog ([[$1]])',
	'article-comments-login' => 'Por favor, <a href="$1">efetue o login</a> para postar um comentário sobre este wiki.',
	'article-comments-toc-item' => 'Comentários',
	'article-comments-comment-cannot-add' => 'Você não pode adicionar um comentário ao artigo.',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos os comentários',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Próximo',
	'article-comments-page-spacer' => '& # 160... & # 160',
	'article-comments-delete-reason' => '',
	'article-comments-empty-comment' => 'Você não pode postar um comentário vazio. <a href="$1">Excluí-lo em vez disso?</a>',
	'wikiamobile-article-comments-none' => 'Sem comentários',
	'wikiamobile-article-comments-view' => 'Ver respostas',
	'wikiamobile-article-comments-replies' => 'respostas',
	'wikiamobile-article-comments-post' => 'Postar',
	'wikiamobile-article-comments-placeholder' => 'Postar um comentário',
	'wikiamobile-article-comments-show' => 'Mostrar',
	'enotif_subject_article_comment' => 'Comentou sobre "$ PAGETITLE" em {{SITENAME}} $PAGEEDITOR',
	'enotif_body_article_comment' => 'Caro $ WATCHINGUSERNAME,

 $ PAGEEDITOR fez um comentário sobre "$ PAGETITLE".

 Para ver a lista de discussão do comentário, clique no link abaixo:
 $ PAGETITLE_URL

 Visite e edite muitas vezes ...

 Wikia',
	'enotif_body_article_comment-HTML' => '<p> Caro $ WATCHINGUSERNAME,
<br /><br />
 $ PAGEEDITOR fez um comentário sobre "$ PAGETITLE".
<br /><br />
 Para ver a lista de discussão do comentário, siga este link: <a href="$PAGETITLE_URL">$ PAGETITLE</a>
<br /><br />
 Visite e edite muitas vezes ...
<br /><br />
 Wikia
<br /><hr />
<ul>
<li> Quer controlar os emails que você recebe? <a href="{{fullurl:Special:Preferences}}">atualize suas preferências</a> <a>.</a> </li>
</ul>
</p>',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'article-comments-anonymous' => 'Utilizator anonim',
	'article-comments-comments' => 'Comentarii ($1)',
	'article-comments-post' => 'Postează comentariu',
	'article-comments-delete' => 'şterge',
	'article-comments-edit' => 'editează',
	'article-comments-history' => 'istoric',
	'article-comments-toc-item' => 'Comentarii',
	'article-comments-reply' => 'Răspunde',
	'article-comments-show-all' => 'Afişează toate comentariile',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-empty-comment' => "Nu poţi posta un comentariu gol. <a href='$1'>Îl ştergi, în schimb?</a>",
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'article-comments-cancel' => 'Annulle',
	'article-comments-toc-item' => 'Commende',
	'article-comments-reply' => 'Respunne',
);

/** Russian (русский)
 * @author Express2000
 * @author Kuzura
 */
$messages['ru'] = array(
	'article-comments-anonymous' => 'Анонимный участник',
	'article-comments-comments' => 'Комментарии ($1)',
	'article-comments-post' => 'Оставить комментарий',
	'article-comments-cancel' => 'Отменить',
	'article-comments-delete' => 'удалить',
	'article-comments-edit' => 'править',
	'article-comments-history' => 'история',
	'article-comments-error' => 'Комментарий не может быть сохранён',
	'article-comments-undeleted-comment' => 'Восстановить комментарий на странице блога $1',
	'article-comments-rc-comment' => 'Комментарий к статье (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Комментарии к статье ([[$1]])',
	'article-comments-fblogin' => 'Пожалуйста <a href="$1" rel="nofollow">войдите в систему и войдите на Facebook</a>, чтобы оставлять комментарии на этой вики!',
	'article-comments-fbconnect' => 'Пожалуйста, <a href="$1">подключите свою учётную запись к Facebook</a>, чтобы комментировать!',
	'article-comments-rc-blog-comment' => 'Комментарий к блогу (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Комментарии к блогу ([[$1]])',
	'article-comments-login' => 'Пожалуйста, <a href="$1">войдите в систему</a>, чтобы оставлять комментарии на этой вики',
	'article-comments-toc-item' => 'Комментарии',
	'article-comments-comment-cannot-add' => 'Вы не можете добавить комментарий к этой статье',
	'article-comments-vote' => 'Голосовать за',
	'article-comments-reply' => 'Ответить',
	'article-comments-show-all' => 'Показать все комментарии',
	'article-comments-prev-page' => 'Пред.',
	'article-comments-next-page' => 'След.',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Родительская статьи / родительский комментарий был удален',
	'article-comments-empty-comment' => "Вы не можете добавить пустой комментарий. <a href='$1'>Удалить его?</a>",
	'wikiamobile-article-comments-header' => 'комментарии (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Загрузить больше',
	'wikiamobile-article-comments-prev' => 'Загрузить предыдущие',
	'wikiamobile-article-comments-none' => 'Нет комментариев',
	'wikiamobile-article-comments-view' => 'Просмотр ответов',
	'wikiamobile-article-comments-replies' => 'ответы',
	'wikiamobile-article-comments-post-reply' => 'Оставить ответ',
	'wikiamobile-article-comments-post' => 'Оставить',
	'wikiamobile-article-comments-placeholder' => 'Оставить комментарий',
	'wikiamobile-article-comments-show' => 'Показать',
	'wikiamobile-article-comments-login-post' => 'Пожалуйста войдите, чтобы оставить комментарий.',
	'enotif_subject_article_comment' => '$PAGEEDITOR прокомментировал "$ PAGETITLE" на {{SITENAME}}',
	'enotif_body_article_comment' => 'Привет $WATCHINGUSERNAME,

Новый комментарий был добавлен к странице $PAGETITLE на {{SITENAME}}. Вы можете посмотреть все комментарии по этой ссылке: $PAGETITLE_URL#WikiaArticleComments

- Команда Викия

___________________________________________
* Вы можете найти помощь и совет на Центральной Вики: http://community.wikia.com
* Хотите контролировать, какие электронные письма вы хотите получать? Вы можете настроить рассылку или отписаться от неё на странице личных настроек: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Привет $WATCHINGUSERNAME,
<br /><br />
Новый комментарий был добавлен к странице $PAGETITLE на {{SITENAME}}. Uы можете посмотреть все комментарии по этой ссылке:  $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Команда Викия
<br /><br />
___________________________________________
<ul>
<li>Вы можете найти помощь и совет на Центральной Вики: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Хотите контролировать, какие электронные письма вы хотите получать? Вы можете настроить рассылку или отписаться от неё на странице личных настроек: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
);

/** Serbo-Croatian (srpskohrvatski / српскохрватски)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'article-comments-anonymous' => 'Anonimni korisnik',
	'article-comments-comments' => 'Komentari ($1)',
	'article-comments-post' => 'Pošalji komentar',
	'article-comments-cancel' => 'Odustani',
	'article-comments-delete' => 'obriši',
	'article-comments-edit' => 'uredi',
	'article-comments-history' => 'historija',
	'article-comments-error' => 'Komentar se ne može snimiti',
	'article-comments-undeleted-comment' => 'Odbrisan komentar za stranicu bloga $1',
	'article-comments-rc-comment' => 'Komentar članka (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Komentari članka ([[$1]])',
	'article-comments-fblogin' => 'Molimo <a href="$1" rel="nofollow">prijavite se i povežite sa Facebookom</a> kako bi poslali komentar na ovu wiki!',
	'article-comments-fbconnect' => 'Molimo <a href="$1">povežite ovaj račun s Facebookom</a> kako bi komentirali!',
	'article-comments-rc-blog-comment' => 'Komentar nloga (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Komentari bloga ([[$1]])',
	'article-comments-login' => 'Molimo <a href="$1">prijavite se</a> kako biste poslali komentar na ovu wiki.',
	'article-comments-toc-item' => 'Komentari',
	'article-comments-comment-cannot-add' => 'Ne možete dodati komentar na članak.',
	'article-comments-reply' => 'Odgovori',
	'article-comments-show-all' => 'Pokaži sve komentare',
	'article-comments-prev-page' => 'Pret',
	'article-comments-next-page' => 'Slijed',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Matični članak / matični komentar je bio izbrisan.',
	'article-comments-empty-comment' => "Ne možete poslati prazni komentar. <a href='$1'>Umjesto toga ga izbrisati?</a>",
	'enotif_subject_article_comment' => '$PAGEEDITOR je komentirao/la "$PAGETITLE" na {{SITENAME}}',
	'enotif_body_article_comment' => 'Cijenjeni/a $WATCHINGUSERNAME,

$PAGEEDITOR je komentirao/la "$PAGETITLE".

Da vidite thread komentara, pratite donji link:
$PAGETITLE_URL

Dolazite i uređujte često...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Cijenjeni/a $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR je komentirao/la "$PAGETITLE".
<br /><br />
Da vidite thread komentara, pratite ovaj link: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Molimo dolazite i komentirajte često...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Želite kontrolirate koje e-mail poruke primate? <a href="{{fullurl:Special:Preferences}}">Ažurirajte svoje postavke<a>.</li>
</ul>
</p>',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'article-comments-delete' => 'මකන්න',
	'article-comments-edit' => 'සංස්කරණය කරන්න',
	'article-comments-history' => 'ඉතිහාසය',
);

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'article-comments-anonymous' => 'Анониман корисник',
	'article-comments-comments' => 'Коментари ($1)',
	'article-comments-post' => 'Постави коментар',
	'article-comments-cancel' => 'Откажи',
	'article-comments-delete' => 'обриши',
	'article-comments-edit' => 'уреди',
	'article-comments-history' => 'историја',
	'article-comments-error' => 'Не могу да сачувам коментар',
	'article-comments-undeleted-comment' => 'Коментар је враћен на страницу на блогу $1',
	'article-comments-rc-comment' => 'Коментар на чланку (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Коментари на чланку ([[$1]])',
	'wikiamobile-article-comments-post' => 'Постави',
	'wikiamobile-article-comments-placeholder' => 'Постави коментар',
);

/** Swedish (svenska)
 * @author Geitost
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'article-comments-anonymous' => 'Anonym användare',
	'article-comments-comments' => 'Kommentarer ($1)',
	'article-comments-post' => 'Skicka kommentar',
	'article-comments-cancel' => 'Avbryt',
	'article-comments-delete' => 'radera',
	'article-comments-edit' => 'redigera',
	'article-comments-history' => 'historik',
	'article-comments-error' => 'Kommentaren kunde inte sparas',
	'article-comments-undeleted-comment' => 'Återställd kommentar för bloggsidan $1',
	'article-comments-rc-comment' => 'Artikelkommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artikelkommentarer ([[$1]])',
	'article-comments-fblogin' => 'Var god <a href="$1">logga in och anslut dig till Facebook</a> för att posta en kommentar på den här wikin!',
	'article-comments-fbconnect' => 'Var god <a href="$1">anslut detta konto till Facebook</a> för att kommentera!',
	'article-comments-rc-blog-comment' => 'Bloggkommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Bloggkommentarer ([[$1]])',
	'article-comments-login' => 'Var god <a href="$1">logga in</a> för att posta en kommentar på den här wikin.',
	'article-comments-toc-item' => 'Kommentarer',
	'article-comments-comment-cannot-add' => 'Du kan inte lägga till en kommentar till artikeln.',
	'article-comments-vote' => 'Rösta upp',
	'article-comments-reply' => 'Svara',
	'article-comments-show-all' => 'Visa alla kommentarer',
	'article-comments-prev-page' => 'Föreg',
	'article-comments-next-page' => 'Nästa',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Överordnade artikeln/kommentaren har tagits bort.',
	'article-comments-empty-comment' => "Du kan inte skriva en tom kommentar. <a href='$1'>Ta bort det istället?</a>",
	'wikiamobile-article-comments-header' => 'Kommentarer (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Läs in fler',
	'wikiamobile-article-comments-prev' => 'Läs in föregående',
	'wikiamobile-article-comments-none' => 'Inga kommentarer',
	'wikiamobile-article-comments-view' => 'Visa svar',
	'wikiamobile-article-comments-replies' => 'svar',
	'wikiamobile-article-comments-post-reply' => 'Skicka ett svar',
	'wikiamobile-article-comments-post' => 'Skriv',
	'wikiamobile-article-comments-placeholder' => 'Skriv en kommentar',
	'wikiamobile-article-comments-show' => 'Visa',
	'wikiamobile-article-comments-login-post' => 'Logga in för att skriva en kommentar.',
	'enotif_subject_article_comment' => '$PAGEEDITOR har kommenterat "$PAGETITLE" på {{SITENAME}}',
	'enotif_body_article_comment' => 'Kära $WATCHINGUSERNAME,

$PAGEEDITOR har lagt in en kommentar på "$PAGETITLE".

För att se kommentartråden, följ länken nedan:
$PAGETITLE_URL

Besök oss och redigera ofta...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Kära $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR har kommenterat på "$PAGETITLE".
<br /><br />
För att se kommentartråden, följ denna länk: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Vänligen besök och redigera ofta...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Vill du kontrollera vilka e-postmeddelanden du får? <a href="{{fullurl:Special:Preferences}}">Uppdatera dina inställningar.<a>.</li>
</ul>
</p>',
);

/** Telugu (తెలుగు)
 * @author Praveen Illa
 * @author Veeven
 */
$messages['te'] = array(
	'article-comments-anonymous' => 'అజ్ఞాత వాడుకరి',
	'article-comments-comments' => 'వ్యాఖ్యలు ($1)',
	'article-comments-post' => 'వ్యాఖ్యానించండి',
	'article-comments-cancel' => 'రద్దుచేయి',
	'article-comments-delete' => 'తొలగించు',
	'article-comments-edit' => 'సవరించు',
	'article-comments-history' => 'చరిత్ర',
	'article-comments-rc-blog-comments' => 'బ్లాగు వ్యాఖ్యలు ([[$1]])',
	'article-comments-toc-item' => 'వ్యాఖ్యలు',
	'article-comments-comment-cannot-add' => 'ఈ వ్యాసానికి మీరు వ్యాఖ్యని చేర్చలేరు.',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-none' => 'వ్యాఖ్యలు లేవు',
	'wikiamobile-article-comments-show' => 'చూపించు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'article-comments-anonymous' => 'Hindi nagpapakilalang tagagamit',
	'article-comments-comments' => 'Mga puna ($1)',
	'article-comments-post' => 'Magpaskil ng puna',
	'article-comments-cancel' => 'Huwag ituloy',
	'article-comments-delete' => 'burahin',
	'article-comments-edit' => 'baguhin',
	'article-comments-history' => 'kasaysayan',
	'article-comments-error' => 'Hindi masagip ang puna',
	'article-comments-undeleted-comment' => 'Hindi naburang puna para sa pahina ng blog na $1',
	'article-comments-rc-comment' => 'Puna sa artikulo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Mga puna sa artikulo ([[$1]])',
	'article-comments-fblogin' => 'Mangyaring <a href="$1">lumagda at umugnay sa Facebook</a> upang makapagpaskil ng isang puna sa wiking ito!',
	'article-comments-fbconnect' => 'Mangyaring <a href="$1">iugnay ang akawnt na ito sa Facebook</a> upang makapagbigay ng puna!',
	'article-comments-rc-blog-comment' => 'Puna sa blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Mga puna sa blog ([[$1]])',
	'article-comments-login' => 'Mangyaring <a href="$1">log in</a> upang makapagpaskil ng isang puna sa wiking ito.',
	'article-comments-toc-item' => 'Mga puna',
	'article-comments-comment-cannot-add' => 'Hindi ka makapagdaragdag ng isang puna sa artikulo.',
	'article-comments-vote' => 'Bumotong paitaas',
	'article-comments-reply' => 'Tumugon',
	'article-comments-show-all' => 'Ipakita ang lahat ng mga puna',
	'article-comments-prev-page' => 'Nakaraan',
	'article-comments-next-page' => 'Kasunod',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Nabura ang magulang ng artikulo / magulang ng puna.',
	'article-comments-empty-comment' => "Hindi ka makapagpapaskil ng puna na walang laman. <a href='$1'>Burahin na lang ito?</a>",
	'wikiamobile-article-comments-header' => 'mga puna <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Magkarga pa',
	'wikiamobile-article-comments-prev' => 'Ikarga ang dati',
	'wikiamobile-article-comments-none' => 'Walang mga puna',
	'wikiamobile-article-comments-view' => 'Tingnan ang mga tugon',
	'wikiamobile-article-comments-replies' => 'mga tugon',
	'wikiamobile-article-comments-post-reply' => 'Magpaskil ng isang tugon',
	'wikiamobile-article-comments-post' => 'Ipaskil',
	'wikiamobile-article-comments-placeholder' => 'Magpaskil ng puna',
	'wikiamobile-article-comments-show' => 'Ipakita',
	'wikiamobile-article-comments-login-post' => 'Mangyaring lumagda upang makapagpaskil ng isang puna.',
	'enotif_subject_article_comment' => 'Pumuna ang $PAGEEDITOR sa "$PAGETITLE" sa {{SITENAME}}',
	'enotif_body_article_comment' => 'Minamahal na $WATCHINGUSERNAME,

Nagbigay ng puna si $PAGEEDITOR sa "$PAGETITLE".

Upang matingnan ang bagting ng puna, sundan ang kawing na nasa ibaba:
$PAGETITLE_URL

Mangyaring dumalaw at mamatnugot ng madalas...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Minamahal na $WATCHINGUSERNAME,
<br /><br />
Nagbigay ng puna si $PAGEEDITOR sa "$PAGETITLE".
<br /><br />
Upang matanaw ang sinulid ng puna, sundan ang kawing na ito: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Mangyaring dumalaw at mamatnugot ng madalas...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Nais mo bang tabanan kung anong mga e-liham ang tatanggapin? <a href="{{fullurl:Special:Preferences}}">Isapanahon ang mga Nais mo<a>.</li>
</ul>
</p>',
);

/** толышә зывон (толышә зывон)
 * @author Erdemaslancan
 * @author Гусейн
 */
$messages['tly'] = array(
	'article-comments-cancel' => 'Ләғв кардеј',
	'article-comments-delete' => 'рәдд кардеј',
	'article-comments-edit' => 'сәрост кардеј',
	'article-comments-history' => 'тарых',
	'article-comments-toc-item' => 'Мындәриҹот',
	'article-comments-prev-page' => 'Навы.',
	'wikiamobile-article-comments-show' => 'Нишо дој',
);

/** Turkish (Türkçe)
 * @author 82-145
 * @author Gizemb
 */
$messages['tr'] = array(
	'article-comments-anonymous' => 'Anonim kullanıcı',
	'article-comments-comments' => 'Yorum ($1)',
	'article-comments-post' => 'Yorum yap',
	'article-comments-cancel' => 'İptal',
	'article-comments-delete' => 'sil',
	'article-comments-edit' => 'değiştir',
	'article-comments-history' => 'geçmiş',
	'article-comments-error' => 'Yorum kaydedilemedi',
	'article-comments-toc-item' => 'Yorumlar',
	'article-comments-comment-cannot-add' => 'Bu maddeye yorum ekleyemezsiniz.',
	'article-comments-reply' => 'Yanıtla',
	'article-comments-show-all' => 'Tüm yanıtları göster',
	'article-comments-prev-page' => 'Önceki',
	'article-comments-next-page' => 'Sonraki',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'article-comments-anonymous' => 'Аноним кулланучы',
	'article-comments-comments' => 'Фикерләр ($1)',
	'article-comments-post' => 'Фикер калдырырга',
	'article-comments-cancel' => 'Баш тарту',
	'article-comments-delete' => 'бетерү',
	'article-comments-edit' => 'үзгәртү',
	'article-comments-history' => 'тарих',
	'article-comments-error' => 'Фикер саклана алмый',
	'article-comments-undeleted-comment' => '$1 блогы сәхифәсендәге фикерне кире кайтару',
	'article-comments-rc-comment' => '(<span class="plainlinks">[$1 $2]</span>) мәкаләсенә фикер',
	'article-comments-rc-comments' => '[[$1]] мәкаләсенә фикер',
	'article-comments-fblogin' => 'Зинһар өчен, <a href="$1" rel="nofollow">системага яки Facebookка керегез</a> һәм бу викида фикер калдырыгыз!',
	'article-comments-fbconnect' => 'Зинһар, фикер калдырыр өчен <a href="$1">хисап язмагызны Facebook белән бәйләгез</a>!',
	'article-comments-rc-blog-comment' => '(<span class="plainlinks">[$1 $2]</span>) блогына фикер',
	'article-comments-rc-blog-comments' => '([[$1]]) блогына фикерләр',
	'article-comments-login' => 'Бу викида фикер калдырыр өчен, зинһар,  <a href="$1">системага керегез</a>',
	'article-comments-toc-item' => 'Фикерләр',
	'article-comments-comment-cannot-add' => 'Сез бу мәкалә фикер калдыра алмыйсыз',
	'article-comments-vote' => '- өчен тавыш бирергә',
	'article-comments-reply' => 'Җавап бирергә',
	'article-comments-show-all' => 'Бөтен фикерләрне күрсәтергә',
	'article-comments-prev-page' => 'Алдагы',
	'article-comments-next-page' => 'Киләсе',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Баш мәкалә/ баш фикер бетерелгән иде.',
	'article-comments-empty-comment' => "Сез буш фикер өсти алмыйсыз. <a href='$1'>Бетерергәме аны?</a>",
	'wikiamobile-article-comments-header' => 'фикерләр <span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => 'Күбрәк йөкләү',
	'wikiamobile-article-comments-prev' => 'Алдагыларын йөкләү',
	'wikiamobile-article-comments-none' => 'Шәрехләр юк',
	'wikiamobile-article-comments-view' => 'Җавапларны карау',
	'wikiamobile-article-comments-replies' => 'җаваплар',
	'wikiamobile-article-comments-post-reply' => 'Җавап калдырырга',
	'wikiamobile-article-comments-post' => 'Калдырырга',
	'wikiamobile-article-comments-placeholder' => 'Фикер калдырырга',
	'wikiamobile-article-comments-show' => 'Күрсәтергә',
	'wikiamobile-article-comments-login-post' => 'Фикер калдырыр өчен, зинһар, керегез.',
	'enotif_subject_article_comment' => '$PAGEEDITOR {{SITENAME}} сәхифәсендә "$PAGETITLE" битен шәрехләде',
	'enotif_body_article_comment' => 'Хөрмәтле $WATCHINGUSERNAME,


$PAGEEDITOR "$PAGETITLE" мәкаләсендә шәрехләмә калдырды.

Шәрехләмәне карар өчен, бу сылтама аша узыгыз:
$PAGETITLE_URL

Викия',
	'enotif_body_article_comment-HTML' => '<p>Кадерле $WATCHINGUSERNAME,
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

/** Ukrainian (українська)
 * @author A1
 */
$messages['uk'] = array(
	'article-comments-delete' => 'вилучити',
	'article-comments-edit' => 'редагувати',
	'article-comments-history' => 'історія',
	'article-comments-error' => 'неможливо зберегти коментар',
	'article-comments-undeleted-comment' => 'Відновити коментар на сторінці блогу $1',
	'article-comments-rc-comment' => 'Коментар до статті (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Коментарі до статті ([[$1]])',
	'wikiamobile-article-comments-more' => 'Завантажити більше',
	'wikiamobile-article-comments-prev' => 'Завантажити попередні',
	'wikiamobile-article-comments-none' => 'немає коментарів',
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'article-comments-cancel' => 'Heitta pätand',
	'article-comments-delete' => 'čuta poiš',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'article-comments-anonymous' => 'Thành viên vô danh',
	'article-comments-comments' => 'Bình luận ($1)',
	'article-comments-post' => 'Gửi bình luận',
	'article-comments-cancel' => 'Hủy bỏ',
	'article-comments-delete' => 'xóa',
	'article-comments-edit' => 'sửa đổi',
	'article-comments-history' => 'lịch sử',
	'article-comments-error' => 'Bình luận không thể được lưu',
	'article-comments-undeleted-comment' => 'Hồi phục bình luận cho trang blog $1',
	'article-comments-rc-comment' => 'Bình luận bài viết (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Bình luận bài viết ([[$1]])',
	'article-comments-fblogin' => 'Xin vui lòng <a href="$1" rel="nofollow">đăng nhập và kết nối với Facebook</a> để đăng một bình luận trên wiki này!',
	'article-comments-fbconnect' => 'Xin vui lòng <a href="$1">kết nối tài khoản này với Facebook</a> để bình luận!',
	'article-comments-rc-blog-comment' => 'Bình luận Blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Bình luận Blog ([[$1]])',
	'article-comments-login' => 'Xin vui lòng <a href="$1">đăng nhập</a> để đăng một bình luận trên wiki này.',
	'article-comments-toc-item' => 'Bình luận',
	'article-comments-comment-cannot-add' => 'Bạn không thể thêm bình luận cho bài viết.',
	'article-comments-vote' => 'Bình chọn',
	'article-comments-reply' => 'Trả lời',
	'article-comments-show-all' => 'Hiển thị tất cả các bình luận',
	'article-comments-prev-page' => 'Kế trước',
	'article-comments-next-page' => 'Tiếp theo',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Bài viết gốc / bình luận gốc đã bị xóa.',
	'article-comments-empty-comment' => "Bạn không thể đăng một bình luận rỗng. <a href='$1'>Xóa nó thay thế?</a>",
	'wikiamobile-article-comments-header' => 'Bình luận (<span id=wkArtCnt>$1</span>)',
	'wikiamobile-article-comments-more' => 'Nạp thêm',
	'wikiamobile-article-comments-prev' => 'Tải bản trước',
	'wikiamobile-article-comments-none' => 'Không có bình luận',
	'wikiamobile-article-comments-view' => 'Xem hồi âm',
	'wikiamobile-article-comments-replies' => 'hồi âm',
	'wikiamobile-article-comments-post-reply' => 'Viết một hồi âm',
	'wikiamobile-article-comments-post' => 'Gửi',
	'wikiamobile-article-comments-placeholder' => 'Viết một bình luận',
	'wikiamobile-article-comments-show' => 'Hiển thị',
	'wikiamobile-article-comments-login-post' => 'Vui lòng đăng nhập để viết bình luận.',
	'enotif_subject_article_comment' => '$PAGEEDITOR đã bình luận trên "$PAGETITLE" trên {{SITENAME}}',
	'enotif_body_article_comment' => 'Xin chào $WATCHINGUSERNAME,

$PAGEEDITOR đã có một bình luận trên trang "$PAGETITLE".

Để xem các chủ đề thảo luận, xin theo liên kết dưới đây:
$PAGETITLE_URL

Xin hãy truy cập và sửa đổi thường xuyên...

Wikia',
	'enotif_body_article_comment-HTML' => '<p>Xin chào $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR đã có một bình luận trên trang "$PAGETITLE".
<br /><br />
Để xem các chủ đề thảo luận, theo liên kết này: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Xin hãy truy cập và sửa đổi thường xuyên...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Muốn kiểm soát email mà bạn nhận được? <a href="{{fullurl:Special:Preferences}}">Nâng cấp Tùy chọn của bạn<a>.</li>
</ul>
</p>',
);

/** Simplified Chinese (‪中文（简体）‬)
 * @author Anakmalaysia
 * @author Dimension
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'article-comments-anonymous' => '匿名用户',
	'article-comments-comments' => '评论（$1）',
	'article-comments-post' => '发表评论',
	'article-comments-cancel' => '取消',
	'article-comments-delete' => '删除',
	'article-comments-edit' => '编辑',
	'article-comments-history' => '历史',
	'article-comments-error' => '无法保存注释',
	'article-comments-undeleted-comment' => '博客页$1被撤消删除的评论',
	'article-comments-rc-comment' => '条目评论(<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => '文章评论([[$1]])',
	'article-comments-fblogin' => '请<a href="$1" rel="nofollow">登陆并连接到Facebook</a>以在本维基上发表评论！',
	'article-comments-fbconnect' => '请<a href="$1">将该账户联结到Facebook</a>进行评论！',
	'article-comments-rc-blog-comment' => '博客评论(<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '博客评论([[$1]])',
	'article-comments-login' => '请<a href="$1">登陆</a>以在本维基上发表评论 ^_^',
	'article-comments-toc-item' => '评论',
	'article-comments-comment-cannot-add' => '不能将注释添加到文章中。',
	'article-comments-vote' => '投票',
	'article-comments-reply' => '答复',
	'article-comments-show-all' => '显示所有注释',
	'article-comments-prev-page' => '上一页',
	'article-comments-next-page' => '下一页',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '源条目/源评论已被删除。',
	'article-comments-empty-comment' => "您不能发布空白评论。<a href='$1'>是否删除它？</a>",
	'wikiamobile-article-comments-header' => '<span class=cnt id=wkArtCnt>$1</span>条评论',
	'wikiamobile-article-comments-more' => '加载更多',
	'wikiamobile-article-comments-prev' => '加载前项',
	'wikiamobile-article-comments-none' => '暂无评论',
	'wikiamobile-article-comments-view' => '查看回复',
	'wikiamobile-article-comments-replies' => '回复',
	'wikiamobile-article-comments-post-reply' => '发表回复',
	'wikiamobile-article-comments-post' => '发布',
	'wikiamobile-article-comments-placeholder' => '发表评论',
	'wikiamobile-article-comments-show' => '展开',
	'wikiamobile-article-comments-login-post' => '请登录以发表评论。',
	'enotif_subject_article_comment' => '$PAGEEDITOR在{{SITENAME}}上对"$PAGETITLE"发表了评论',
	'enotif_body_article_comment' => '亲爱的$WATCHINGUSERNAME，

$PAGEEDITOR对"$PAGETITLE"做出了评论。

依下方链接查看此评论：
$PAGETITLE_URL

请常来访问和编辑……

Wikia',
	'enotif_body_article_comment-HTML' => '<p>亲爱的$WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR在"$PAGETITLE"上做出了评论。
<br /><br />
依如下链接查看评论：<a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
敬请常来访编辑……
<br /><br />
Wikia
<br /><hr />
<ul>
<li>想管理你将收到何种邮件？ <a href="{{fullurl:Special:Preferences}}">更新偏好设置<a>.</li>
</ul>
</p>',
);

/** Traditional Chinese (‪中文（繁體）‬)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'article-comments-anonymous' => '匿名用戶',
	'article-comments-comments' => '評論 ( $1 )',
	'article-comments-post' => '發表評論',
	'article-comments-cancel' => '取消',
	'article-comments-delete' => '刪除',
	'article-comments-edit' => '編輯',
	'article-comments-history' => '歷史',
	'article-comments-error' => '評論無法儲存',
	'article-comments-undeleted-comment' => '恢復部落格文章 $1 的評論',
	'article-comments-rc-comment' => '文章評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => '文章評論 ([[$1]])',
	'article-comments-fblogin' => '請 <a href="$1" rel="nofollow">登入並連接Facebook</a> 來在這個wiki發表評論',
	'article-comments-fbconnect' => '請 <a href="$1">把這個帳號與Facebook連結</a> 來評論',
	'article-comments-rc-blog-comment' => '部落格評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '部落格評論 （[[ $1 ]])',
	'article-comments-login' => '請 <a href="$1">登入</a> 以在此wiki上張貼評論。',
	'article-comments-toc-item' => '評論',
	'article-comments-comment-cannot-add' => '您不能在這篇文章中增加評論。',
	'article-comments-vote' => '參與投票',
	'article-comments-reply' => '回覆',
	'article-comments-show-all' => '顯示所有評論',
	'article-comments-prev-page' => '前一筆',
	'article-comments-next-page' => '下一頁',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-empty-comment' => "你不能發佈空的評論。<a href='$1'>要刪除它嗎？</a>",
	'wikiamobile-article-comments-header' => '評論<span class=cnt id=wkArtCnt>$1</span>',
	'wikiamobile-article-comments-more' => '載入更多',
	'wikiamobile-article-comments-prev' => '載入前面的',
	'wikiamobile-article-comments-none' => '沒有評論',
	'enotif_subject_article_comment' => '$PAGEEDITOR 在 {{SITENAME}}的文章 "$PAGETITLE"中發表評論',
);

