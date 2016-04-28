<?php
/**
 * Article Comments extension message file
 *
 * Also be aware that many oasis specific i18n messages for comments
 * reside in extensions/wikia/Oasis/Oasis.i18n.php
 */

$messages = [];

$messages['en'] = [
	'article-comments-desc' => 'Article comments for wiki pages',
	'article-comments-file-page' => "[[$1|Comment from $2]] on [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comment from $2]] on [[$3|$4]] post on [[$5|$6's]] blog",

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
	'article-comments-login' => 'Please [[Special:UserLogin|log in]] to post a comment on this wiki.',
	'article-comments-toc-item' => 'Comments',
	'article-comments-comment-cannot-add' => 'You cannot add a comment to the article.',
	'article-comments-vote' => 'Vote up',
	'article-comments-reply' => 'Reply',
	'article-comments-show-all' => 'Show all comments',
	'article-comments-prev-page' => 'Prev',
	'article-comments-next-page' => 'Next',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'The parent article / parent comment has been deleted.',
	'article-comments-empty-comment' => "You can't post an empty comment. [$1 Delete it instead?]",
	'article-comments-show-more' => 'Show more comments',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comment|Comments}}',
	'wikiamobile-article-comments-header' => 'Comments',
	'wikiamobile-article-comments-more' => 'Load more',
	'wikiamobile-article-comments-prev' => 'Load previous',
	'wikiamobile-article-comments-none' => 'No comments',
	'wikiamobile-article-comments-view' => 'View replies',
	'wikiamobile-article-comments-replies' => 'replies',
	'wikiamobile-article-comments-post-reply' => 'Post a reply',
	'wikiamobile-article-comments-post' => 'Post',
	'wikiamobile-article-comments-placeholder' => 'Post a comment',
	'wikiamobile-article-comments-login-post' => 'Please log in to post a comment.',
	'wikiamobile-article-comments-post-fail' => 'Failed to save comment, please try again later',

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
];

/** Message documentation (Message documentation)
 * @author Hamilton Abreu
 * @author Lizlux
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = [
	'article-comments-desc' => '{{desc}}',
	'article-comments-file-page' => 'Format of the file usage (see [[MediaWiki:Linkstoimage]]) entry on the file page if the file is used in an article comment.
Parameters:
* $1 -Title text of the comment that includes the image.
* $2 - Username of the user who left the comment that includes the image. Supports GENDER
* $3 - Page name of parent article.',
	'article-blog-comments-file-page' => 'Format of the file usage (see [[MediaWiki:Linkstoimage]]) entry on the file page if the file is used in a blog comment.
Parameters:
* $1 - Title text of the comment includes the image.
* $2 - Username of the user who left the comment that includes the image. Supports GENDER
* $3 - Title text of the blog that has the specific comment.
* $4 - Name of the blog post.
* $5 - Title text of the blog page of the author of the blog post (not the blog comment).
* $6 - Username of the author of the blog post (not the blog comment). Supports GENDER.',
	'article-comments-anonymous' => 'Anonymous users are logged out / un-authenticated users.
{{Identical|Anonymous user}}',
	'article-comments-comments' => '{{Identical|Comment}}',
	'article-comments-post' => 'This is the text of a submit button to post a new article comment.
{{Identical|Post comment}}',
	'article-comments-cancel' => 'Cancel/stop editing an article comment.
{{Identical|Cancel}}',
	'article-comments-delete' => 'Click this button to delete the comment. It will take you to a page where you can confirm the deletion.
{{Identical|Delete}}',
	'article-comments-edit' => 'Click this button to edit the message.  A box will appear to with the message text for editing.
{{Identical|Edit}}',
	'article-comments-history' => '{{Identical|History}}',
	'article-comments-rc-blog-comments' => '{{Identical|Blog comment}}',
	'article-comments-toc-item' => '{{Identical|Comment}}',
	'article-comments-reply' => '{{Identical|Reply}}',
	'article-comments-next-page' => '{{Identical|Next}}',
	'article-comments-show-more' => 'Label for the button that shows more comments',
	'wikiamobile-article-comments-counter' => 'Number of comments + word Comments to display in WM page header',
	'wikiamobile-article-comments-header' => "The header of the Comments section shown in Wikia's mobile skin.
{{Identical|Comment}}",
	'wikiamobile-article-comments-more' => 'Label on a button to load next page of comments.
{{Identical|Load more}}',
	'wikiamobile-article-comments-prev' => 'Label on a button to load previous page of comments',
	'wikiamobile-article-comments-none' => 'Message displayed to user if there are no comments on a page after opening a section with comments',
	'wikiamobile-article-comments-view' => 'Message to open all replies to a comment. Parameters:
* $1 - the number of comments',
	'wikiamobile-article-comments-replies' => 'Message in Top Bar in a modal with all replies to comment.
{{Identical|Reply}}',
	'wikiamobile-article-comments-post-reply' => 'Label on a button to post a reply to comment',
	'wikiamobile-article-comments-post' => 'Label on a button to post a comment.
{{Identical|Post}}',
	'wikiamobile-article-comments-placeholder' => 'This is an input placeholder displayed when no text is in given input.
{{Identical|Post comment}}',
	'wikiamobile-article-comments-login-post' => 'Message shown to a user if he tries to post a comment on a wiki where login is obligatory to edit.
This is shown in small pop up message in red.',
	'wikiamobile-article-comments-post-fail' => 'Message shown to a user when saving his comment failed.
This is shown in small pop up message in red.',
	'enotif_body_article_comment' => '{{doc-singularthey}}
This is an email sent to inform a user that a page they are following has a new comment posted.',
];

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = [
	'article-comments-anonymous' => 'Anonieme gebruiker',
	'article-comments-comments' => 'Opmerkings ($1)',
	'article-comments-post' => 'Pos kommentaar',
	'article-comments-cancel' => 'Kanselleer',
	'article-comments-delete' => 'skrap',
	'article-comments-edit' => 'wysig',
	'article-comments-history' => 'geskiedenis',
	'article-comments-reply' => 'Antwoord',
	'article-comments-show-all' => 'Wys alle kommentaar',
	'article-comments-prev-page' => 'Vorige',
	'article-comments-next-page' => 'Volgende',
	'article-comments-page-spacer' => '&#160...&#160',
];

/** Old English (Ænglisc)
 * @author Espreon
 */
$messages['ang'] = [
	'article-comments-edit' => 'adihtan',
];

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 * @author DRIHEM
 * @author Gagnabil
 * @author Kuwaity26
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = [
	'article-comments-file-page' => "[[$1|تعليق من $2]] on [[$3]]",
	'article-blog-comments-file-page' => "[[$1|التعليق من  $2  ]] في [[$3| $4 ]] على [[$5|  $6 في مدونة]]",
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
	'article-comments-login' => 'الرجاء [[Special:UserLogin|تسجيل الدخول]] لإضافة تعليق على هذا الويكي.',
	'article-comments-toc-item' => 'تعليقات',
	'article-comments-comment-cannot-add' => 'لا يمكنك إضافة تعليق إلى هذا المقال.',
	'article-comments-vote' => 'التصويت بالإيجاب',
	'article-comments-reply' => 'رد',
	'article-comments-show-all' => 'إظهار كافة التعليقات',
	'article-comments-prev-page' => 'السابق',
	'article-comments-next-page' => 'التالي',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'تم حذف المقالة الأصلية / التعليق الأصلي.',
	'article-comments-empty-comment' => "لا يمكنك إضافة تعليق فارغ. [$1 هل تريد حذفه بدلا من ذلك؟]",
	'article-comments-show-more' => 'أظهر المزيد من التعليقات',
	'wikiamobile-article-comments-counter' => '{{PLURAL:$1|تعليق|تعليقات}} $1',
	'wikiamobile-article-comments-header' => 'تعليقات',
	'wikiamobile-article-comments-more' => 'تحميل المزيد',
	'wikiamobile-article-comments-prev' => 'تحميل السابقة',
	'wikiamobile-article-comments-none' => 'لا تعليقات',
	'wikiamobile-article-comments-view' => 'عرض الردود',
	'wikiamobile-article-comments-replies' => 'الردود',
	'wikiamobile-article-comments-post-reply' => 'نشر الرد',
	'wikiamobile-article-comments-post' => 'إرسال',
	'wikiamobile-article-comments-placeholder' => 'أرسل تعليقا',
	'wikiamobile-article-comments-login-post' => 'الرجاء تسجيل الدخول لإضافة تعليق.',
	'wikiamobile-article-comments-post-fail' => 'فشل في حفظ التعليق، الرجاء المحاولة مرة أخرى لاحقاً',
	'enotif_subject_article_comment' => '$PAGEEDITOR قام بالتعليق على "$PAGETITLE" على {{SITENAME}}',
	'enotif_body_article_comment' => 'مرحبا $WATCHINGUSERNAME،

$PAGEEDITOR قدم تعليقا على $PAGETITLE في {{SITENAME}}. إستخدم هذا الرابط لترى جميع التعليقات: $PAGETITLE_URL#WikiaArticleComments

- فريق دعم مجتمع ويكيا

___________________________________________
* زر موقع ويكيا العربي لكي تجد المساعدة والنصائح: http://ar.wikia.com
* تريد تلقي رسائل أقل منا؟ يمكنك إلغاء الاشتراك أو تغيير تفضيلات البريد الإلكتروني الخاص بك هنا:  http://ar.wikia.com/خاص:تفضيلات',
	'enotif_body_article_comment-HTML' => 'مرحبا $WATCHINGUSERNAME،
<br /><br />
هنالك تعليق جديد على $PAGETITLE في {{SITENAME}}. إستخدم هذا الرابط لترى جميع التعليقات: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- فريق دعم مجتمع ويكيا
<br /><br />
___________________________________________
<ul>
<li>* زر موقع ويكيا العربي لكي تجد المساعدة والنصائح:  <a href="http://ar.wikia.com">http://ar.wikia.com</a>
<li>
<li>* تريد تلقي رسائل أقل منا؟ يمكنك إلغاء الاشتراك أو تغيير تفضيلات البريد الإلكتروني الخاص بك هنا:  <a href="http://ar.wikia.com/خاص:تفضيلات">http://ar.wikia.com/خاص:تفضيلات</a></li>
</ul>
</p>',
];

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = [
	'article-comments-delete' => 'ܫܘܦ',
	'article-comments-edit' => 'ܫܚܠܦ',
	'article-comments-history' => 'ܬܫܥܝܬܐ',
	'article-comments-prev-page' => 'ܕܩܕܡ',
	'article-comments-next-page' => 'ܕܒܬܪ',
];

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 */
$messages['as'] = [
	'article-comments-cancel' => 'বাতিল কৰক',
	'article-comments-delete' => 'বিলোপ কৰক',
	'article-comments-edit' => 'সম্পাদনা কৰক',
	'article-comments-history' => 'ইতিহাস',
	'article-comments-prev-page' => 'পূৰ্বৱৰ্তী',
	'article-comments-next-page' => 'পৰৱৰ্তী',
];

/** Azerbaijani (azərbaycanca)
 * @author AZISS
 * @author Cekli829
 * @author Mushviq Abdulla
 */
$messages['az'] = [
	'article-comments-file-page' => "[[$3]] səhifəsində [[$1|$2 tərəfindən]] şərh edildi",
	'article-comments-anonymous' => 'Anonim iştirakçı',
	'article-comments-comments' => 'Şərhlər ($1)',
	'article-comments-post' => 'Şərh göndər',
	'article-comments-cancel' => 'İmtina',
	'article-comments-delete' => 'sil',
	'article-comments-edit' => 'redaktə',
	'article-comments-history' => 'Tarix',
	'article-comments-error' => 'Şərh qeyd edilə bilmir',
	'article-comments-rc-comment' => 'Məqalə şərhi (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Məqalə şərhləri ([[$1]])',
	'article-comments-fbconnect' => 'Şərh etmək üçün lütfən <a href="$1">Facebook hesabı ilə hesabınızı</a> əlaqələndirin!',
	'article-comments-rc-blog-comment' => 'Bloq şərhi (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Bloq şərhləri ([[$1]])',
	'article-comments-toc-item' => 'Şərhlər',
	'article-comments-vote' => 'Səs ver',
	'article-comments-reply' => 'Geri göndər',
	'article-comments-show-all' => 'Bütün şərhləri göstər',
	'article-comments-prev-page' => 'Öncəki',
	'article-comments-next-page' => 'Növbəti',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'Şərhlər',
	'wikiamobile-article-comments-none' => 'Şərh yoxdur',
	'wikiamobile-article-comments-replies' => 'cavablar',
	'wikiamobile-article-comments-post-reply' => 'Cavab göndər',
];

/** South Azerbaijani (تۆرکجه)
 * @author E THP
 * @author Koroğlu
 */
$messages['azb'] = [
	'article-comments-post' => 'باخیش گؤندر',
	'article-comments-cancel' => 'وازگئچ',
	'article-comments-delete' => 'سیل',
	'article-comments-edit' => 'دَییشدیر',
	'article-comments-history' => 'گئچمیش',
	'article-comments-toc-item' => 'باخیش‌لار',
	'article-comments-reply' => 'یئنیدن',
	'article-comments-prev-page' => 'اؤنجه‌کی',
	'article-comments-next-page' => 'سونراکی',
	'wikiamobile-article-comments-header' => 'باخیش‌لار',
	'wikiamobile-article-comments-more' => 'آردی‌سی',
	'wikiamobile-article-comments-none' => 'باخیش‌سیز',
	'wikiamobile-article-comments-view' => 'یانیت‌لارا باخ',
	'wikiamobile-article-comments-replies' => 'یانیت‌لار',
	'wikiamobile-article-comments-post-reply' => 'بیر یانیت گؤندر',
	'wikiamobile-article-comments-post' => 'گؤندر',
	'wikiamobile-article-comments-placeholder' => 'باخیش گؤندر',
];

/** Bashkir (башҡортса)
 * @author Ләйсән
 * @author ҒатаУлла
 */
$messages['ba'] = [
	'article-comments-anonymous' => 'Аноним ҡулланыусылар',
	'article-comments-comments' => 'Фекерҙәр ($1)',
	'article-comments-post' => 'Фекер яҙырға',
	'article-comments-cancel' => 'Кире алырға',
	'article-comments-delete' => 'юйырға',
	'article-comments-edit' => 'үҙгәртергә',
	'article-comments-history' => 'тарих',
	'article-comments-error' => 'Фекер һаҡлана алмай',
	'article-comments-undeleted-comment' => '$1 блогы битендәге фекерҙе кире ҡайтарыу',
	'article-comments-rc-comment' => '(<span class="plainlinks">[$1 $2]</span>) мәҡәләһенә фекер',
	'article-comments-rc-comments' => '[[$1]] мәҡәләһенә фекер',
	'article-comments-fblogin' => 'Зинһар, был вики-проектта фекер ҡалдырыу өсөн <a href="$1" rel="nofollow">системаға йәки Facebookка керегеҙ</a> һәм !',
	'article-comments-fbconnect' => 'Зинһар, фекер ҡалдырыр өсөн <a href="$1">иҫәп яҙыуығыҙҙы Facebook менән бәйләгеҙ</a>!',
	'article-comments-rc-blog-comment' => '(<span class="plainlinks">[$1 $2]</span>) блогына фекер',
	'article-comments-rc-blog-comments' => '([[$1]]) блогына фекерҙәр',
	'article-comments-login' => 'Был вики-проектта фекер ҡалдырыу өсөн, зинһар,  [[Special:UserLogin|системаға керегеҙ]]',
	'article-comments-toc-item' => 'Фекерҙәр',
	'article-comments-comment-cannot-add' => 'Һеҙ был мәҡәлә өсөн фекер ҡалдыра алмыйһығыҙ',
	'article-comments-vote' => '- өсөн тауыш бирергә',
	'article-comments-reply' => 'Яуап бирергә',
	'article-comments-show-all' => 'Бөтә  фекерҙәрҙе күрһәтергә',
	'wikiamobile-article-comments-view' => 'Яуаптарҙы ҡарау',
	'wikiamobile-article-comments-replies' => 'Яуаптар',
];

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = [
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
	'article-comments-login' => 'Zum Kómmentirn [[Special:UserLogin|åmöden]].',
	'article-comments-toc-item' => 'Kómmentare',
	'article-comments-comment-cannot-add' => 'Du kåst an Kómmentar zum Artiké dazuadoah.',
	'article-comments-vote' => 'Obstimmer',
	'article-comments-reply' => 'Åntworten',
	'article-comments-show-all' => 'Olle Kómmentare zoang',
	'article-comments-prev-page' => 'Vurherige',
	'article-comments-next-page' => 'Naxde',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Da ywergordnate Artiké / ywergordnate Kómmentar is gleschd worn.',
	'article-comments-empty-comment' => 'A laarer Kómmentar is néd méglé. [$1 Sóid man léschen?]',
	'enotif_subject_article_comment' => '$PAGEEDITOR hod "$PAGETITLE" auf {{SITENAME}} kómmentird.',
	'enotif_body_article_comment' => 'Servas $WATCHINGUSERNAME,

$PAGEEDITOR hod an Kómmentar zua "$PAGETITLE" obgeem.

Um an Kómmentar-Thread åzschauh, fóig \'m untensteeherden Link:
$PAGETITLE_URL

Bittscheh kumm vorbei und dua vü midorweiden.

Wikia', # Fuzzy
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
</p>', # Fuzzy
];

/** Bikol Central (Bikol Central)
 * @author Geopoet
 */
$messages['bcl'] = [
	'article-comments-file-page' => "[[$1|Komento gikan ki $2]] kan [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Komento gikan ki $2]] kan [[$3|$4]] pinaskil kan [[$5|$6's]] blog",
	'article-comments-anonymous' => 'Dai midbid na paragamit',
	'article-comments-comments' => 'Mga Komento ($1)',
	'article-comments-post' => 'Ipaskil an komento',
	'article-comments-cancel' => 'Kanselaron',
	'article-comments-delete' => 'puraon',
	'article-comments-edit' => 'liwatón',
	'article-comments-history' => 'historiya',
	'article-comments-error' => 'An komento dae tabi maipagtatagama',
	'article-comments-undeleted-comment' => 'Dae pinagpurang komento para sa blog pahina $1',
	'article-comments-rc-comment' => 'Komento sa artikulo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Mga komento sa artikulo ([[$1]])',
	'article-comments-fblogin' => 'Tabi man <a href="$1" rel="nofollow">maglaog asin ikonekta sa Facebook</a> tanganing makapaskil nin komento sa wiking ini!',
	'article-comments-fbconnect' => 'Tabi man <a href="$1">ikonekta ining panindog sa Facebook</a> tanganing makakomento!',
	'article-comments-rc-blog-comment' => 'Komento sa Blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Mga komento sa Blog ([[$1]])',
	'article-comments-login' => 'Tabi man [[Special:UserLogin|maglaog]] tanganing makapaskil nin komento sa wiking ini.',
	'article-comments-toc-item' => 'Mga Komento',
	'article-comments-comment-cannot-add' => 'Ika dae tabi makakadugang nin sarong komento sa artikulo.',
	'article-comments-vote' => 'Magboto pataas',
	'article-comments-reply' => 'Kasimbagan',
	'article-comments-show-all' => 'Ipatanaw an gabos na mga komento',
	'article-comments-prev-page' => 'Nakaagi',
	'article-comments-next-page' => 'Masunod',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'An magurang na artikulo/magurang na komento pinagpura na.',
	'article-comments-empty-comment' => "Ika dae makakapaskil nin daeng laman na komento. [$1 Puraon ta na lugod ini?]",
	'wikiamobile-article-comments-header' => 'mga komento',
	'wikiamobile-article-comments-more' => 'Magkarga pa nin dugang',
	'wikiamobile-article-comments-prev' => 'Ikarga an nakaagi',
	'wikiamobile-article-comments-none' => 'Mayong mga komento',
	'wikiamobile-article-comments-view' => 'Tanawon an mga kasimbagan',
	'wikiamobile-article-comments-replies' => 'mga kasimbagan',
	'wikiamobile-article-comments-post-reply' => 'Magpaskil nin sarong kasimbagan',
	'wikiamobile-article-comments-post' => 'Magpaskil',
	'wikiamobile-article-comments-placeholder' => 'Magpaskil nin komento',
	'wikiamobile-article-comments-login-post' => 'Tabi man maglaog tanganing makapagpaskil nin komento.',
	'wikiamobile-article-comments-post-fail' => 'Nagpalya an pagtagama nin komento, tabi man prubare giraray aban-aban',
	'enotif_subject_article_comment' => 'An $PAGEEDITOR nagkomento sa "$PAGETITLE" kan {{SITENAME}}',
	'enotif_body_article_comment' => 'Hi $WATCHINGUSERNAME, 

Igwa nin sarong baguhong komento sa $PAGETITLE kan {{SITENAME}}. Gamita ining sugpunan tanganing hilngon an gabos na mga komento: $PAGETITLE_URL#WikiaArticleComments 

- Pankomunidad na suporta kan Wikia ___________________________________________ 
* Hanapa an katabangan asin abiso kan Sentral na Pankomunidad sa: http://community.wikia.com 
* Muya mong maresibe nin kadikiton na mga mensahe gikan samuya? Ika makakahale kan subskripsyon o baguhon an saimong e-surat na mga kamuyahan digde sa:http://community.wikia.com/Special:Mga Kamuyahan',
	'enotif_body_article_comment-HTML' => '<p>Hi $WATCHINGUSERNAME,
<br /><br /> 
Igwa nin sarong baguhong komento sa $PAGETITLE kan {{SITENAME}}. Gamita ining sugpunan tanganing hilngon an gabos na mga komento: $PAGETITLE_URL#WikiaArticleComments
<br /><br /> 

- Pankomunidad na suporta kan Wikia 
<br /><br />
___________________________________________ 
<ul>
<li>Hanapa an katabangan asin abiso kan Sentral na Pankomunidad sa: <a href="http://community.wikia.com">http://community.wikia.com</a><li> 
<li>Muya mong maresibe nin kadikiton na mga mensahe gikan samuya? Ika makakahale kan subskripsyon o baguhon an saimong e-surat na mga kamuyahan digde sa:<a href="http://community.wikia.com/Special:Mga Kamuyahan">http://community.wikia.com/Special:Mga Kamuyahan</a></li>
</ul>
</p>',
];

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = [
	'article-comments-anonymous' => 'Анонимен потребител',
	'article-comments-comments' => 'Коментари ($1)',
	'article-comments-cancel' => 'Отказване',
	'article-comments-delete' => 'изтриване',
	'article-comments-edit' => 'редактиране',
	'article-comments-history' => 'история',
	'article-comments-error' => 'Коментарът не може да бъде съхранен',
	'article-comments-toc-item' => 'Коментари',
	'article-comments-reply' => 'Отговор',
	'article-comments-show-all' => 'Показване на всички коментари',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-none' => 'Няма коментари',
	'wikiamobile-article-comments-placeholder' => 'Публикуване на коментар',
	'wikiamobile-article-comments-post-fail' => 'Неуспех при съхраняването на коментара, опитайте отново по-късно',
];

/** Western Balochi (بلوچی رخشانی)
 * @author Baloch Afghanistan
 */
$messages['bgn'] = [
	'article-comments-cancel' => 'کنسیل',
	'article-comments-delete' => 'پاک کورتین',
	'article-comments-edit' => 'ایڈیٹ',
	'article-comments-history' => 'تاریخچه',
	'article-comments-reply' => 'جواب',
	'article-comments-prev-page' => 'دیمتیرین',
	'article-comments-next-page' => 'دیگرین',
	'article-comments-page-spacer' => '&#160...&#160',
];

/** Bengali (বাংলা)
 * @author Aftab1995
 * @author Aftabuzzaman
 * @author Tauhid16
 */
$messages['bn'] = [
	'article-comments-anonymous' => 'নামহীন ব্যবহারকারী',
	'article-comments-comments' => 'মন্তব্যসমূহ ($1)',
	'article-comments-post' => 'মন্তব্য প্রকাশ করুন',
	'article-comments-cancel' => 'বাতিল',
	'article-comments-delete' => 'অপসারণ',
	'article-comments-edit' => 'সম্পাদনা',
	'article-comments-history' => 'ইতিহাস',
	'article-comments-error' => 'মন্তব্য সংরক্ষণ করা সম্ভব নয়',
	'article-comments-toc-item' => 'মন্তব্যসমূহ',
	'article-comments-comment-cannot-add' => 'এই নিবন্ধনে আপনি কোনো মন্তব্য যুক্ত করেতে পারবেননা।',
	'article-comments-vote' => 'পক্ষে ভোট দিন',
	'article-comments-reply' => 'উত্তর',
	'article-comments-show-all' => 'সকল মন্তব্য দেখাও',
	'article-comments-prev-page' => 'পূর্ব',
	'article-comments-next-page' => 'পর',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'মন্তব্যসমূহ',
	'wikiamobile-article-comments-more' => 'আরও লোড করুন',
	'wikiamobile-article-comments-prev' => 'পূর্বেরটি লোড করুন',
	'wikiamobile-article-comments-none' => 'কোন মন্তব্য নেই',
	'wikiamobile-article-comments-view' => 'ফিরতি বার্তাসমূহ দেখাও',
	'wikiamobile-article-comments-replies' => 'ফিরতি বার্তাসমূহ',
	'wikiamobile-article-comments-post-reply' => 'ফিরতি বার্তা লেখুন',
	'wikiamobile-article-comments-post' => 'পোস্ট',
	'wikiamobile-article-comments-placeholder' => 'মন্তব্য প্রকাশ করুন',
	'wikiamobile-article-comments-login-post' => 'মন্তব্য করার জন্য দয়া করে প্রবেশ করুন',
	'wikiamobile-article-comments-post-fail' => 'মন্তব্য সংরক্ষণ করা সম্ভব হয়নি দয়া করে পরে চেষ্টা করুন',
];

/** Tibetan (བོད་ཡིག)
 * @author YeshiTuhden
 */
$messages['bo'] = [
	'article-comments-post' => 'དཔྱད་གཏམ་སྤེལ་བ་',
	'article-comments-error' => 'དཔྱད་གཏམ་ཉར་ཚགས་མི་ཐབས།',
	'article-comments-toc-item' => 'དཔྱད་གཏམ་',
	'article-comments-reply' => 'ལན་སློག།',
	'article-comments-show-all' => 'དཔྱད་གཏམ་ཚང་མ་སྟོན།',
];

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = [
	'article-comments-file-page' => "[[$1|Evezhiadenn eus $2]] war [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Displegadenn $2]] e [[$3|$4]] a  zo bet embannet war blog [[$5|$6]]",
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
	'article-comments-login' => '[[Special:UserLogin|Ret eo kevreañ]] evit lezel ur gemennadenn war ar wiki-mañ.',
	'article-comments-toc-item' => 'Evezhiadennoù',
	'article-comments-comment-cannot-add' => "N'hallit ket lakaat un evezhiadenn war ar pennad-mañ.",
	'article-comments-vote' => 'Votiñ a-du',
	'article-comments-reply' => 'Respont',
	'article-comments-show-all' => 'Diskouez an holl evezhiadennoù',
	'article-comments-prev-page' => 'Kent',
	'article-comments-next-page' => "War-lerc'h",
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Diverket eo bet ar bajenn kar / an evezhiadenn kar.',
	'article-comments-empty-comment' => "N'hallit ket degas un evezhiadenn c'houllo. [$1 Diverkañ anezhi ?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Evezhiadenn}}',
	'wikiamobile-article-comments-header' => 'Displegadennoù',
	'wikiamobile-article-comments-more' => "Lenn muioc'h",
	'wikiamobile-article-comments-prev' => 'Kargañ an hini kent',
	'wikiamobile-article-comments-none' => 'Evezhiaden ebet',
	'wikiamobile-article-comments-view' => 'Gwelet ar respontoù',
	'wikiamobile-article-comments-replies' => 'respontoù',
	'wikiamobile-article-comments-post-reply' => 'Kas ur respont',
	'wikiamobile-article-comments-post' => 'Kas',
	'wikiamobile-article-comments-placeholder' => 'Ouzhpennañ un evezhiadenn',
	'wikiamobile-article-comments-login-post' => 'Kevreit evit postañ un displegadenn',
	'wikiamobile-article-comments-post-fail' => "C'hwitet eo enrolladur an displegadenn, adkrogit ganti diwezhatoc'h",
	'enotif_subject_article_comment' => 'Un evezhiadenn zo bet graet gant $PAGEEDITOR diwar-benn "$PAGETITLE" war {{SITENAME}}',
	'enotif_body_article_comment' => '$WATCHINGUSERNAME ker,

Graet ez eus bet un evezhiadenn nevez gant $PAGEEDITOR war "$PAGETITLE".

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
</p>', # Fuzzy
];

/** Iriga Bicolano (Iriga Bicolano)
 * @author Filipinayzd
 */
$messages['bto'] = [
	'article-comments-edit' => 'balyowan',
	'article-comments-history' => 'kasaysayan',
];

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Anskar
 * @author Marcmpujol
 * @author Solde
 * @author Unapersona
 */
$messages['ca'] = [
	'article-comments-desc' => "Comentaris d'article per pàgines wiki",
	'article-comments-file-page' => "[[$1|Comentari de $2]] a [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comentari de $2]] en la publicació [[$3|$4]] en el bloc de [[$5|$6]]",
	'article-comments-anonymous' => 'Usuari anònim',
	'article-comments-comments' => 'Comentaris ($1)',
	'article-comments-post' => 'Deixar comentari',
	'article-comments-cancel' => 'Cancel·la',
	'article-comments-delete' => 'elimina',
	'article-comments-edit' => 'modifica',
	'article-comments-history' => 'historial',
	'article-comments-error' => "El comentari no s'ha pogut desar",
	'article-comments-undeleted-comment' => 'Comentari no eliminat de la pàgina del bloc $1',
	'article-comments-rc-comment' => 'Comentari de l\'article (<span class="plainlinks">[$1  $2]</span>)',
	'article-comments-rc-comments' => "Comentaris d'article ([[$1]])",
	'article-comments-fblogin' => 'Si us plau <a href="$1" rel="nofollow"> identifiqueu-vos i connecteu-vos amb Facebook</a> per enviar un comentari en aquest wiki!',
	'article-comments-fbconnect' => 'Si us plau, <a href="$1">connecta aquest compte amb Facebook</a> per deixar un comentari.',
	'article-comments-rc-blog-comment' => 'Comentari de bloc (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentaris de bloc ([[$1]])',
	'article-comments-login' => '[[Special:UserLogin|Identifica\'t]] per deixar un comentari.',
	'article-comments-toc-item' => 'Comentaris',
	'article-comments-comment-cannot-add' => 'No pots afegir comentaris en aquest article.',
	'article-comments-vote' => 'Votar',
	'article-comments-reply' => 'Respon',
	'article-comments-show-all' => 'Mostra tots els comentaris',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Següent',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => "L'article / comentari arrel ha estat suprimit.",
	'article-comments-empty-comment' => "No pots deixar un comentari en blanc. [$1 Vols esborrar-lo?]",
	'article-comments-show-more' => 'Mostrar més comentaris',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comentari|Comentaris}}',
	'wikiamobile-article-comments-header' => 'Comentaris',
	'wikiamobile-article-comments-more' => 'Carregar més',
	'wikiamobile-article-comments-prev' => "Carregar l'anterior",
	'wikiamobile-article-comments-none' => 'No hi ha comentaris',
	'wikiamobile-article-comments-view' => 'Veure les respostes',
	'wikiamobile-article-comments-replies' => 'respostes',
	'wikiamobile-article-comments-post-reply' => 'Publicar una resposta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Deixar un comentari',
	'wikiamobile-article-comments-login-post' => 'Inicia sessió per publicar un comentari.',
	'wikiamobile-article-comments-post-fail' => 'Error al guardar el comentari, si us plau, intenta-ho de nou',
	'enotif_subject_article_comment' => '$PAGEEDITOR ha comentat en "$PAGETITLE" en {{SITENAME}}',
	'enotif_body_article_comment' => 'Hola $WATCHINGUSERNAME,

Hi ha un nou comentari en la pàgina $PAGETITLE de {{SITENAME}}. Utilitza aquest enllaç per veure tots els comentaris: $PAGETITLE_URL#WikiaArticleComments

- Equip Comunitari de Wikia

___________________________________________
* Troba ajuda i consells en la Central Catalana: http://ca.wikia.com
* Vols rebre menys missatges de nosaltres? Pots donar-te de baixa o canviar les teves preferències d\'adreça electrònica aquí: http://ca.wikia.com/Especial:Preferències',
	'enotif_body_article_comment-HTML' => '<p>Hola $WATCHINGUSERNAME,
<br /><br />
Hi ha un nou comentari en la pàgina $PAGETITLE de {{SITENAME}}. Utilitza aquest enllaç per veure tots els comentaris: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Equip Comunitari de Wikia
<br /><br />

___________________________________________
<ul>
<li>Troba ajuda i consells en la Central Catalana: <a href="http://ca.wikia.com">http://ca.wikia.com</a>
<li>
<li>Vols rebre menys missatges de nosaltres? Pots donar-te de baixa o canviar les teves preferències d\'adreça electrònica aquí: <a href="http://ca.wikia.com/Especial:Preferències">http://ca.wikia.com/wiki/Especial:Preferències</a></li>
</ul>
</p>',
];

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = [
	'article-comments-cancel' => 'Цаоьшу',
	'article-comments-delete' => 'дӀаяккха',
	'article-comments-history' => 'истори',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Къамел|Къамелаш}}',
];

/** Central Kurdish (کوردیی ناوەندی)
 * @author Calak
 */
$messages['ckb'] = [
	'article-comments-edit' => 'دەستکاری',
	'article-comments-history' => 'مێژوو',
];

/** Czech (čeština)
 * @author Aktron
 * @author Darth Daron
 * @author Jezevec
 * @author Jkjk
 * @author Mr. Richard Bolla
 * @author Vks
 */
$messages['cs'] = [
	'article-comments-desc' => 'Komentáře k wikistránkám',
	'article-comments-file-page' => '[[$1|Komentář od $2]] ke článku [[$3]]',
	'article-blog-comments-file-page' => '[[$1|Komentář od uživatele $2]] na příspěvek [[$3|$4]] na blogu uživatele [[$5|$6\'s]]',
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
	'article-comments-login' => 'Pro přidání komentáře se prosím [[Special:UserLogin|přihlašte]].',
	'article-comments-toc-item' => 'Komentáře',
	'article-comments-comment-cannot-add' => 'Nelze přidat komentář k článku.',
	'article-comments-vote' => 'Zahlasovat',
	'article-comments-reply' => 'Odpovědět',
	'article-comments-show-all' => 'Zobrazit všechny komentáře',
	'article-comments-prev-page' => 'Předchozí',
	'article-comments-next-page' => 'Další',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Nadřazený článek / komentář byl odstraněn.',
	'article-comments-empty-comment' => "Nelze odeslat prázdný komentář. [$1 Chcete ho místo toho odstranit?]",
	'article-comments-show-more' => 'Zobrazit další komentáře',
	'wikiamobile-article-comments-header' => 'Komentáře',
	'wikiamobile-article-comments-more' => 'Nahrát více',
	'wikiamobile-article-comments-prev' => 'Načíst předchozí',
	'wikiamobile-article-comments-none' => 'Žádné komentáře',
	'wikiamobile-article-comments-view' => 'Ukázat odpovědi',
	'wikiamobile-article-comments-replies' => 'odpovědi',
	'wikiamobile-article-comments-post-reply' => 'Odpovědět',
	'wikiamobile-article-comments-post' => 'Poslat',
	'wikiamobile-article-comments-placeholder' => 'Přidat komentář',
	'wikiamobile-article-comments-login-post' => 'Prosím, přihlašte se, abyste mohli odesílat komentáře.',
	'enotif_subject_article_comment' => '$PAGEEDITOR přidal komentář "$PAGETITLE" na {{SITENAME}}.',
	'enotif_body_article_comment' => 'Vážený $WATCHINGUSERNAME,

$PAGEEDITOR přidal komentář na "$PAGETITLE".

Pro zobrazení klikněte na níže uvedený odkaz:
$PAGETITLE_URL

Prosím navštěvujte a editujte často...

Wikia', # Fuzzy
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
</p>', # Fuzzy
];

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Robin Owain
 * @author Thefartydoctor
 */
$messages['cy'] = [
	'article-comments-file-page' => "[[$1|Sylw gan $2]] ar [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Sylw gan $2]] ar [[$3|$4]] bost ar y blog [[$5|$6]]",
	'article-comments-anonymous' => 'Defnyddiwr anhysbys',
	'article-comments-comments' => 'Sylwadau ($1)',
	'article-comments-post' => 'Postio sylw',
	'article-comments-cancel' => 'Canslo',
	'article-comments-delete' => 'dileu',
	'article-comments-edit' => 'golygu',
	'article-comments-history' => 'hanes',
	'article-comments-error' => 'Dydyn ni ddim yn gallu achub y sylw.',
	'article-comments-undeleted-comment' => 'Sylw ddim yn dileu am tudalen blog $1',
	'article-comments-rc-comment' => 'Sylw erthygl (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Sylw erthygl ([[$1]])',
	'article-comments-fblogin' => '<a href="$1" rel="nofollow">Mewngofnodi a chysylltu gyda Facebook</a> os ydych chi eisiau gwneud sylw ar y wici hwn!',
	'article-comments-fbconnect' => '<a href="$1>Cysylltu y cyfrif hwn gyda Facebook</a> os ydych chi eisiau gwneud sylw!',
	'article-comments-rc-blog-comment' => 'Sylw blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Sylwadau blog ([[$1]])',
	'article-comments-login' => '[[Special:UserLogin|Mewngofnodi]] os ydych chi eisiau postio sylw ar y wici hwn.',
	'article-comments-toc-item' => 'Sylwadau',
	'article-comments-comment-cannot-add' => 'Dydych chi ddim yn gallu creu sylw ar yr erthygl hon.',
	'article-comments-vote' => "Dw i'n hoffi hwn.",
	'article-comments-reply' => 'Ateb',
	'article-comments-show-all' => 'Amlygu pob sylw',
	'article-comments-prev-page' => 'Cynt',
	'article-comments-next-page' => 'Nesaf',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => "Mae'r erthygl / sylw wreiddiol wedi cael ei dileu.",
	'article-comments-empty-comment' => "Dydych chi ddim yn gallu postio sylw gwag. [$1 Dileu efallai?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Sylw|Sylwadau}}',
	'wikiamobile-article-comments-header' => 'Sylwadau',
	'wikiamobile-article-comments-more' => 'Darllenwch mwy',
	'wikiamobile-article-comments-prev' => 'Darllenwch cynt',
	'wikiamobile-article-comments-none' => 'Nid oes sylwadau',
	'wikiamobile-article-comments-view' => 'Darllenwch atebion',
	'wikiamobile-article-comments-replies' => 'Atebion',
	'wikiamobile-article-comments-post-reply' => 'Postio ateb',
	'wikiamobile-article-comments-post' => 'Postio',
	'wikiamobile-article-comments-placeholder' => 'Postio sylw',
	'wikiamobile-article-comments-login-post' => 'Mewngofnodi i bostio sylw.',
	'wikiamobile-article-comments-post-fail' => "Ni lwyddwyd rhoi'r sylw ar gadw, ceisiwch eto'n ddiweddarach os gwelwch yn dda.",
	'enotif_subject_article_comment' => 'Mae $PAGEEDITOR wedi sylw ar "$PAGETITLE" ar {{SITENAME}}',
	'enotif_body_article_comment' => 'Helo $WATCHINGUSERNAME,

Mae sylw newydd ar $PAGETITLE ar {{SITENAME}}. Defnyddwch y linc hwn i weld pob sylw:
$PAGETITLE_URL#WikiaArticleComments

- Y Tîm Wikia

___________________________________________
* Ffeindiwch help a chwnsel ar Community Central: http://community.wikia.com
* Ydych chi eisiau cael llai neges ohonon ni? Dych chi\'n gallu stopio\'ch tanysgrifiad neu newid eich dewisiadau ebost yma: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Helo $WATCHINGUSERNAME,
<br /><br />
Mae sylw newydd ar $PAGETITLE ar {{SITENAME}}. Defnyddwch y linc hwn i weld pob sylw: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Y Tîm Wikia
<br /><br />
___________________________________________
<ul>
<li>Ffeindiwch help a chwnsel ar Community Central: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Ydych chi eisiau cael llai neges ohonon ni? Dych chi\'n gallu stopio\'ch tanysgrifiad neu newid eich dewisiadau ebost yma:  <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Danish (dansk)
 * @author Sarrus
 */
$messages['da'] = [
	'article-comments-anonymous' => 'Anonym bruger',
	'article-comments-comments' => 'Kommentarer ($1)',
	'article-comments-cancel' => 'Fortryd',
	'article-comments-delete' => 'slet',
	'article-comments-edit' => 'redigér',
	'article-comments-reply' => 'Svar',
	'wikiamobile-article-comments-none' => 'Ingen kommentarer',
];

/** German (Deutsch)
 * @author Avatar
 * @author Claudia Hattitten
 * @author Das Schäfchen
 * @author Geitost
 * @author Inkowik
 * @author LWChris
 * @author Luke081515
 * @author Metalhead64
 * @author PtM
 * @author SVG
 */
$messages['de'] = [
	'article-comments-desc' => 'Artikelkommentare für Wikiseiten',
	'article-comments-file-page' => "[[$1|Kommentar von $2]] zu [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Kommentar von $2]] zum Artikel [[$3|$4]] im Blog von [[$5|$6]]",
	'article-comments-anonymous' => 'Unangemeldeter Benutzer',
	'article-comments-comments' => 'Kommentare ($1)',
	'article-comments-post' => 'Kommentieren',
	'article-comments-cancel' => 'Abbrechen',
	'article-comments-delete' => 'löschen',
	'article-comments-edit' => 'bearbeiten',
	'article-comments-history' => 'Versionen',
	'article-comments-error' => 'Kommentar konnte nicht gespeichert werden',
	'article-comments-undeleted-comment' => 'Kommentar zu Blog-Beitrag $1 wiederhergestellt.',
	'article-comments-rc-comment' => 'Artikel-Kommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artikel-Kommentare ([[$1]])',
	'article-comments-fblogin' => 'Bitte <a href="$1" rel="nofollow">anmelden und mit Facebook verbinden</a>, um einen Kommentar in diesem Wiki zu schreiben!',
	'article-comments-fbconnect' => 'Bitte <a href="$1">dieses Konto mit Facebook verknüpfen</a>, um zu kommentieren!',
	'article-comments-rc-blog-comment' => 'Blog-Kommentar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blog-Kommentare ([[$1]])',
	'article-comments-login' => 'Zum Kommentieren [[Special:UserLogin|anmelden]].',
	'article-comments-toc-item' => 'Kommentare',
	'article-comments-comment-cannot-add' => 'Du kannst keinen Kommentar zum Artikel hinzufügen.',
	'article-comments-vote' => 'Abstimmen',
	'article-comments-reply' => 'Antworten',
	'article-comments-show-all' => 'Alle Kommentare anzeigen',
	'article-comments-prev-page' => 'Vorherige',
	'article-comments-next-page' => 'Nächste',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Der übergeordnete Artikel / übergeordnete Kommentar wurde gelöscht.',
	'article-comments-empty-comment' => 'Ein leerer Kommentar ist nicht möglich. [$1 Stattdessen löschen?]',
	'article-comments-show-more' => 'Weitere Kommentare anzeigen',
	'wikiamobile-article-comments-counter' => '{{PLURAL:$1|Ein Kommentar|$1 Kommentare}}',
	'wikiamobile-article-comments-header' => 'Kommentare',
	'wikiamobile-article-comments-more' => 'Weitere laden',
	'wikiamobile-article-comments-prev' => 'Vorherige laden',
	'wikiamobile-article-comments-none' => 'Keine Kommentare',
	'wikiamobile-article-comments-view' => 'Antworten zeigen',
	'wikiamobile-article-comments-replies' => 'Antworten',
	'wikiamobile-article-comments-post-reply' => 'Antworten',
	'wikiamobile-article-comments-post' => 'Abschicken',
	'wikiamobile-article-comments-placeholder' => 'Kommentieren',
	'wikiamobile-article-comments-login-post' => 'Bitte melde dich an, um Kommentare zu schreiben.',
	'wikiamobile-article-comments-post-fail' => 'Der Kommentar konnte nicht gespeichert werden, bitte versuche es später erneut.',
	'enotif_subject_article_comment' => '$PAGEEDITOR hat "$PAGETITLE" auf {{SITENAME}} kommentiert',
	'enotif_body_article_comment' => 'Hallo $WATCHINGUSERNAME,

es gibt zu $PAGETITLE auf {{SITENAME}} einen neuen Kommentar. Verwende diesen Link, um alle Kommentare anzusehen: $PAGETITLE_URL#WikiaArticleComments

– Wikia Community Team

___________________________________________
* Bekomme Hilfe und Ratschläge auf Community Central: http://community.wikia.com
* Willst du weniger Nachrichten von uns erhalten? Du kannst die Benachrichtigung abbestellen oder deine E-Mail-Einstellungen hier ändern: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hallo $WATCHINGUSERNAME,
<br /><br />
es gibt zu $PAGETITLE auf {{SITENAME}} einen neuen Kommentar. Verwende diesen Link, um alle Kommentare anzusehen: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
– Wikia Community Team
<br /><br />
___________________________________________
<ul>
<li>Bekomme Hilfe und Ratschläge auf Community Central: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Willst du weniger Nachrichten von uns erhalten? Du kannst die Benachrichtigung abbestellen oder deine E-Mail-Einstellungen hier ändern: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author Claudia Hattitten
 */
$messages['de-formal'] = [
	'article-comments-comment-cannot-add' => 'Sie können keinen Kommentar zum Artikel hinzufügen.',
	'enotif_body_article_comment' => 'Hallo $WATCHINGUSERNAME,

$PAGEEDITOR hat einen Kommentar zu "$PAGETITLE" abgegeben.

Um den Kommentar-Thread anzusehen, folgen Sie dem unten stehenden Link:
$PAGETITLE_URL

Bitte besuchen und bearbeiten Sie das Wiki bald wieder...

Wikia', # Fuzzy
];

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = [
	'article-comments-anonymous' => 'Karbero bêname',
	'article-comments-comments' => 'Vatışi ($1)',
	'article-comments-post' => 'Mışewrey bıvurne',
	'article-comments-cancel' => 'Bıtexelne',
	'article-comments-delete' => 'bestere',
	'article-comments-edit' => 'bıvurne',
	'article-comments-history' => 'tarix',
	'article-comments-error' => 'Mışewre qeyd nêbi',
	'article-comments-rc-comment' => 'Vatışê wesiqe (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Vatışê wesiqe da ([[$1]])',
	'article-comments-rc-blog-comments' => 'Vatışê Blog da ([[$1]])',
	'article-comments-toc-item' => 'Vatışi',
	'article-comments-vote' => 'Rey çek',
	'article-comments-reply' => 'Cewab bıde',
	'article-comments-show-all' => 'Cıwaba pêron bımocne',
	'article-comments-prev-page' => 'Verên',
	'article-comments-next-page' => 'Bahdoyên',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'vatışê',
	'wikiamobile-article-comments-more' => 'Zêde bar ke',
	'wikiamobile-article-comments-prev' => 'Bahdoyêni buwane',
	'wikiamobile-article-comments-none' => 'Mışewreyi çıniyê',
	'wikiamobile-article-comments-view' => 'Cewabi bıvin',
	'wikiamobile-article-comments-replies' => 'cewabi',
	'wikiamobile-article-comments-post-reply' => 'Yew cewab bırışe',
	'wikiamobile-article-comments-post' => 'Bırışe',
	'wikiamobile-article-comments-placeholder' => 'Mışewre bırışe',
	'wikiamobile-article-comments-login-post' => 'Seba mışewrekerdene rê şıma gani qeyd bê.',
	'enotif_body_article_comment-HTML' => '<p>Merheba $WATCHINGUSERNAME,
<br /><br />
{{SITENAME}} de be nameyê $PAGETITLE ra yew mışewre esto. Seba vênayışê mışewreyan rê nê gıreyi bıgurenê: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Peştiya Cemaetê Wikiya
<br /><br />
___________________________________________
<ul>
<li>Merkezê Cemaeti ra şıma şenê peşti bıgêrê: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Şıma wazenê ke ma ra şenıkêr mesac bıgêrê? Tercihanê xoyê ke na adrese derê, inan ra abonemanê xo bıxelenê ya zi bıvurnê: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Greek (Ελληνικά)
 * @author Evropi
 * @author Glavkos
 */
$messages['el'] = [
	'article-comments-file-page' => "[[$1|Σχόλιο από $2]] στο [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Σχόλιο από  $2]] on [[$3|$4]] αναρτήθηκε στο [[$5|$6's]] blog",
	'article-comments-anonymous' => 'Ανώνυμος χρήστης',
	'article-comments-comments' => 'Σχόλια ($1)',
	'article-comments-post' => 'Δημοσίευση σχολίου',
	'article-comments-cancel' => 'Ακύρωση',
	'article-comments-delete' => 'διαγραφή',
	'article-comments-edit' => 'επεξεργασία',
	'article-comments-history' => 'ιστορικό',
	'article-comments-error' => 'Δεν ήταν δυνατή η αποθήκευση του σχολίου',
	'article-comments-undeleted-comment' => 'Επαναφερμένο σχόλιο για την σελίδα blog $1',
	'article-comments-rc-comment' => 'Σχόλιο άρθρου (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Σχόλια άρθρου ([[$1]])',
	'article-comments-fbconnect' => 'Παρακαλούμε <a href="$1">συνδέστε αυτό τον λογαριασμό με το Facebook</a> για να σχολιάσετε!',
	'article-comments-rc-blog-comment' => 'Σχόλιο σε blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Σχόλια blog ([[$1]])',
	'article-comments-login' => 'Παρακαλώ [[Special:UserLogin|συνδεθ]] για να αναρτήσετε σχόλιο σε αυτό το wiki.',
	'article-comments-toc-item' => 'Σχόλια',
	'article-comments-comment-cannot-add' => 'Δεν μπορείτε να προσθέσετε σχόλιο για το άρθρο.',
	'article-comments-vote' => 'Ψηφοφορία μέχρι',
	'article-comments-reply' => 'Απάντηση',
	'article-comments-show-all' => 'Εμφάνιση όλων των σχολίων',
	'article-comments-prev-page' => 'Προηγούμενο',
	'article-comments-next-page' => 'Επόμενο',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Το κύριο άρθρο/κύριο σχόλιο έχει διαγραφεί.',
	'article-comments-empty-comment' => "Δεν μπορείτε να δημοσιεύσετε ένα κενό σχόλιο. [$1 Αντ'αυτού να το διαγράψετε;]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Σχόλιο|Σχόλια}}',
	'wikiamobile-article-comments-header' => 'Σχόλια',
	'wikiamobile-article-comments-more' => 'Φορτώστε περισσότερα',
	'wikiamobile-article-comments-prev' => 'Φορτώστε τα προηγούμενα',
	'wikiamobile-article-comments-none' => 'Δεν υπάρχουν σχόλια',
	'wikiamobile-article-comments-view' => 'Προβολή απαντήσεων',
	'wikiamobile-article-comments-replies' => 'απαντήσεις',
	'wikiamobile-article-comments-post-reply' => 'Δημοσιεύσατε μια απάντηση',
	'wikiamobile-article-comments-post' => 'Δημοσιεύστε',
	'wikiamobile-article-comments-placeholder' => 'Δημοσίευση σχολίου',
	'wikiamobile-article-comments-login-post' => 'Παρακαλώ συνδεθείτε για να αναρτήσετε ένα σχόλιο.',
	'wikiamobile-article-comments-post-fail' => 'Αποτυχία αποθήκευσης σχολίου, παρακαλώ δοκιμάστε ξανά αργότερα \\',
	'enotif_subject_article_comment' => '$PAGEEDITOR έχει σχολιάσει στο "$PAGETITLE" στο {{SITENAME}}',
];

/** British English (British English)
 * @author Caliburn
 */
$messages['en-gb'] = [
	'article-comments-cancel' => 'Cancel',
	'article-comments-delete' => 'delete',
	'article-comments-edit' => 'edit',
	'article-comments-history' => 'history',
	'article-comments-vote' => 'Vote up',
	'article-comments-reply' => 'Reply',
];

/** Esperanto (Esperanto)
 * @author Objectivesea
 * @author Tradukisto
 */
$messages['eo'] = [
	'article-comments-anonymous' => 'Anonima uzanto',
	'article-comments-comments' => 'Komentoj ($2)', # Fuzzy
	'article-comments-post' => 'Komenti',
	'article-comments-cancel' => 'Malŝalti',
	'article-comments-delete' => 'forigi',
	'article-comments-edit' => 'redakti',
	'article-comments-history' => 'historio',
	'article-comments-error' => 'La komento ne povis esti konservita',
	'article-comments-login' => 'Bonvolu [[Special:UserLogin|ensaluti]] por komenti ĉe ĉi-vikio.',
	'article-comments-toc-item' => 'Komentoj',
	'article-comments-comment-cannot-add' => 'Vi ne povas aldoni komenton al la artikolo.',
	'article-comments-vote' => 'Voĉdoni supren',
	'article-comments-reply' => 'Respondi',
	'article-comments-show-all' => 'Montri ĉiujn komentojn',
	'article-comments-prev-page' => 'Antaŭa',
	'article-comments-next-page' => 'Sekva',
	'wikiamobile-article-comments-none' => 'Neniuj komentoj',
];

/** Spanish (español)
 * @author Armando-Martin
 * @author Benfutbol10
 * @author DJ Nietzsche
 * @author Fitoschido
 * @author Ihojose
 * @author Macofe
 * @author VegaDark
 */
$messages['es'] = [
	'article-comments-desc' => 'Comentarios de artículo para páginas del wiki',
	'article-comments-file-page' => "[[$1|Comentario de $2]] en [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comentario de $2]] en la publicación [[$3|$4]] en el blog de [[$5|$6]]",
	'article-comments-anonymous' => 'Usuario anónimo',
	'article-comments-comments' => 'Comentarios ($1)',
	'article-comments-post' => 'Dejar comentario',
	'article-comments-cancel' => 'Cancelar',
	'article-comments-delete' => 'borrar',
	'article-comments-edit' => 'editar',
	'article-comments-history' => 'historial',
	'article-comments-error' => 'No se pudo guardar el comentario',
	'article-comments-undeleted-comment' => 'Comentario no borrado para la página del blog $1',
	'article-comments-rc-comment' => 'Comentario de artículo (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Comentarios de artículo ([[$1]])',
	'article-comments-fblogin' => 'Por favor, <a href="$1">identifícate y conéctate con Facebook</a> para dejar un comentario en este wiki.',
	'article-comments-fbconnect' => 'Por favor, <a href="$1">conecta esta cuenta con Facebook</a> para dejar un comentario.',
	'article-comments-rc-blog-comment' => 'Comentario de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentarios de blog ([[$1]])',
	'article-comments-login' => '[[Special:UserLogin|Identifícate]] para dejar un comentario',
	'article-comments-toc-item' => 'Comentarios',
	'article-comments-comment-cannot-add' => 'No puedes añadir comentarios aquí',
	'article-comments-vote' => 'Votar',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos los comentarios',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Siguiente',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'El artículo raíz / comentario raíz ha sido borrado.',
	'article-comments-empty-comment' => "No puedes dejar un comentario en blanco. [$1 ¿Quieres borrarlo?]",
	'article-comments-show-more' => 'Mostrar más comentarios',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comentario|Comentarios}}',
	'wikiamobile-article-comments-header' => 'Comentarios',
	'wikiamobile-article-comments-more' => 'Cargar más',
	'wikiamobile-article-comments-prev' => 'Cargar el anterior',
	'wikiamobile-article-comments-none' => 'No hay comentarios',
	'wikiamobile-article-comments-view' => 'Ver respuestas',
	'wikiamobile-article-comments-replies' => 'respuestas',
	'wikiamobile-article-comments-post-reply' => 'Publicar una respuesta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Dejar un comentario',
	'wikiamobile-article-comments-login-post' => 'Inicia sesión para publicar un comentario.',
	'wikiamobile-article-comments-post-fail' => 'Error al guardar el comentario, por favor inténtalo nuevamente',
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
];

/** Estonian (eesti)
 * @author KalmerE.
 */
$messages['et'] = [
	'article-comments-anonymous' => 'Anonüümne kasutaja',
	'article-comments-comments' => 'Kommentaar ($1)',
	'article-comments-post' => 'Kommenteeri',
	'article-comments-cancel' => 'Tühista',
	'article-comments-delete' => 'kustuta',
	'article-comments-edit' => 'redigeeri',
	'article-comments-history' => 'ajalugu',
	'article-comments-error' => 'Kommentaari ei õnnestu salvestada',
	'article-comments-rc-comments' => 'Artikli kommentaarid ([[$1]])',
	'article-comments-fblogin' => 'Palun <a href="$1" rel="nofollow">logi sisse ja ühenda Facebookiga</a> selle viki kommenteerimiseks!',
	'article-comments-fbconnect' => 'Palun <a href="$1">ühendage kasutajakonto Facebookiga</a> kommenteerimiseks!',
	'article-comments-rc-blog-comment' => 'Blogi kommentaar (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blogi kommentaarid ([[$1]])',
	'article-comments-login' => 'Palun [[Special:UserLogin|logi sisse]] viki kommenteerimiseks.',
	'article-comments-toc-item' => 'Kommentaarid',
	'article-comments-comment-cannot-add' => 'Sa ei saa artiklile lisada kommentaari.',
	'article-comments-vote' => 'Anna hääl',
	'article-comments-reply' => 'Vasta',
	'article-comments-show-all' => 'Vaata kõiki kommentaare',
	'article-comments-prev-page' => 'Eelmine',
	'article-comments-next-page' => 'Järgmine',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'kommentaarid',
	'wikiamobile-article-comments-more' => 'Loe edasi',
	'wikiamobile-article-comments-prev' => 'Loe eelmisi',
	'wikiamobile-article-comments-none' => 'Kommentaare ei ole',
	'wikiamobile-article-comments-view' => 'Vaata vastuseid',
	'wikiamobile-article-comments-replies' => 'vastused',
	'wikiamobile-article-comments-post-reply' => 'Postita vastus',
	'wikiamobile-article-comments-post' => 'Postitus',
	'wikiamobile-article-comments-placeholder' => 'Postita kommentaar',
	'wikiamobile-article-comments-login-post' => 'Palun logi sisse kommenteerimiseks.',
	'wikiamobile-article-comments-post-fail' => 'Kommentaari salvestamine ebaõnnestus, palun proovi hiljem uuesti',
	'enotif_subject_article_comment' => '$PAGEEDITOR on kommenteerinud "$PAGETITLE" {{SITENAME}}',
];

/** Basque (euskara)
 * @author An13sa
 * @author Subi
 */
$messages['eu'] = [
	'article-comments-anonymous' => 'Lankide anonimoa',
	'article-comments-comments' => 'Iruzkinak ($1)',
	'article-comments-post' => 'Iruzkina idatzi',
	'article-comments-cancel' => 'Utzi',
	'article-comments-delete' => 'ezabatu',
	'article-comments-edit' => 'aldatu',
	'article-comments-history' => 'historia',
	'article-comments-toc-item' => 'Iruzkinak',
	'article-comments-reply' => 'Erantzun',
	'article-comments-show-all' => 'Iruzkin guztiak erakutsi',
	'article-comments-prev-page' => 'Aurrekoa',
	'article-comments-next-page' => 'Hurrengoa',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-show-more' => 'Erakutsi iruzkin gehiago',
	'wikiamobile-article-comments-counter' => '{{PLURAL:$1|Iruzkin bat|$1 iruzkin}}',
	'wikiamobile-article-comments-header' => 'Iruzkinak',
	'wikiamobile-article-comments-more' => 'Gehiago kargatu',
	'wikiamobile-article-comments-prev' => 'Kargatu aurrekoak',
	'wikiamobile-article-comments-none' => 'Ez dago iruzkinik',
	'wikiamobile-article-comments-view' => 'Erantzunak ikusi',
	'wikiamobile-article-comments-replies' => 'erantzunak',
];

/** Extremaduran (estremeñu)
 * @author Henares
 */
$messages['ext'] = [
	'article-comments-history' => 'estoria',
];

/** Persian (فارسی)
 * @author BlueDevil
 * @author Ebraminio
 * @author Huji
 * @author Movyn
 * @author Wayiran
 * @author جواد
 * @author پاناروما
 */
$messages['fa'] = [
	'article-comments-desc' => 'کامنت برای مقالات صفحات ویکی',
	'article-comments-file-page' => "[[$1|کامنت از $2]] در [[$3]]",
	'article-blog-comments-file-page' => "[[$1|کامنت از $2]] در [[$3|$4]] post on [[$5|$6's]] وبلاگ",
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
	'article-comments-fbconnect' => 'لطفاً <a href="<span class=" notranslate"="">$1 ">این حساب را به فیس بوک متصل کنید</a> تا نظر بدهید!',
	'article-comments-rc-blog-comment' => 'نظر وبلاگ (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'نظرات وبلاگ ([[$1]])',
	'article-comments-login' => 'برای نظر دادن [[Special:UserLogin|وارد سامانه شوید]].',
	'article-comments-toc-item' => 'نظرات',
	'article-comments-comment-cannot-add' => 'شما نمی‌توانید به مقاله نظری را اضافه کنید.',
	'article-comments-vote' => 'رای موافق',
	'article-comments-reply' => 'پاسخ',
	'article-comments-show-all' => 'نمایش همهٔ نظرات',
	'article-comments-prev-page' => 'قبلی',
	'article-comments-next-page' => 'بعدی',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'مقالهٔ مادر / نظر مادر حذف شده است.',
	'article-comments-empty-comment' => "شما نمی‌توانید یک نظر خالی بفرستید. [$1 به‌جایش حذف شود؟]",
	'article-comments-show-more' => 'نمایش کامنت‌های بیشتر',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|کامنت|کامنت‌ها}}',
	'wikiamobile-article-comments-header' => 'نظرها',
	'wikiamobile-article-comments-more' => 'ادامه مطلب',
	'wikiamobile-article-comments-prev' => 'بارگیری قبلی',
	'wikiamobile-article-comments-none' => 'بدون نظر',
	'wikiamobile-article-comments-view' => 'مشاهده پاسخ‌ها',
	'wikiamobile-article-comments-replies' => 'پاسخ‌ها',
	'wikiamobile-article-comments-post-reply' => 'ارسال پاسخ',
	'wikiamobile-article-comments-post' => 'ارسال',
	'wikiamobile-article-comments-placeholder' => 'ارسال نظر',
	'wikiamobile-article-comments-login-post' => 'لطفاً برای ارسال نظر به سامانه وارد شوید.',
	'wikiamobile-article-comments-post-fail' => 'کامنت ذخیره نشد، لطفا بعدا دوباره امتحان کنید.',
	'enotif_subject_article_comment' => '$PAGEEDITOR کامنتی برای "$PAGETITLE" در {{SITENAME}} گذاشته است',
];

/** Finnish (suomi)
 * @author Centerlink
 * @author Elseweyr
 * @author Ilkea
 * @author Lukkipoika
 * @author Nike
 * @author Tm T
 * @author Tofu II
 */
$messages['fi'] = [
	'article-comments-file-page' => "[[$1|Kommentti käyttäjältä $2]] sivulla [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Käyttäjän $2 kommentti]] käyttäjän [[$5|$6]] blogimerkinnästä [[$3|$4]].",
	'article-comments-anonymous' => 'Anonyymi käyttäjä',
	'article-comments-comments' => 'Kommentit ($1)',
	'article-comments-post' => 'Lähetä kommentti',
	'article-comments-cancel' => 'Peruuta',
	'article-comments-delete' => 'poista',
	'article-comments-edit' => 'muokkaa',
	'article-comments-history' => 'historia',
	'article-comments-error' => 'Kommenttia ei voitu tallentaa',
	'article-comments-undeleted-comment' => 'Kommenttia ei poistettu blogisivulta $1',
	'article-comments-rc-comment' => 'Artikkelin kommentti (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Artikkelin kommentit ([[$1]])',
	'article-comments-fblogin' => 'Ole hyvä ja <a href="$1" rel="nofollow">kirjaudu sisään yhdistyäksesi Facebookiin</a> ja kommentoidaksesi tässä wikissä!',
	'article-comments-fbconnect' => 'Ole hyvä ja <a href="$1">yhdistä tämä käyttäjätili Facebookiin</a> kommentoidaksesi!',
	'article-comments-rc-blog-comment' => 'Blogin kommentti (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blogin kommentit ([[$1]])',
	'article-comments-login' => '[[Special:UserLogin|Kirjaudu sisään]] kommetoidaksesi tässä wikissä.',
	'article-comments-toc-item' => 'Kommentit',
	'article-comments-comment-cannot-add' => 'Et voi lisätä kommenttia tähän artikkeliin.',
	'article-comments-vote' => 'Äänestä ylös',
	'article-comments-reply' => 'Vastaa',
	'article-comments-show-all' => 'Näytä kaikki kommentit',
	'article-comments-prev-page' => 'Edell.',
	'article-comments-next-page' => 'Seuraava',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Ylemmän tason artikkeli/kommentti on poistettu.',
	'article-comments-empty-comment' => "Et voi lähettää tyhjää kommenttia. [$1 Haluatko sen sijaan poistaa sen?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|kommentti|kommenttia}}',
	'wikiamobile-article-comments-header' => 'Kommentit',
	'wikiamobile-article-comments-more' => 'Lataa lisää',
	'wikiamobile-article-comments-prev' => 'Lataa edelliset',
	'wikiamobile-article-comments-none' => 'Ei kommentteja',
	'wikiamobile-article-comments-view' => 'Näytä vastaukset',
	'wikiamobile-article-comments-replies' => 'vastaukset',
	'wikiamobile-article-comments-post-reply' => 'Lähetä vastaus',
	'wikiamobile-article-comments-post' => 'Lähetä',
	'wikiamobile-article-comments-placeholder' => 'Lähetä kommentti',
	'wikiamobile-article-comments-login-post' => 'Kirjaudu sisään kommentoidaksesi.',
	'wikiamobile-article-comments-post-fail' => 'Kommenttia ei voitu tallentaa, yritä myöhemmin uudelleen',
	'enotif_subject_article_comment' => '$PAGEEDITOR on kommentoinut artikkelia "$PAGETITLE" {{SITENAME}}ssä.',
	'enotif_body_article_comment' => 'Hei $WATCHINGUSERNAME,

{{SITENAME}}n sivulla $PAGETITLE on uusi kommentti. Nähdäksesi kaikki kommentit, seuraa linkkiä:
$PAGETITLE_URL#WikiaArticleComments

- Wikia Community Support

___________________________________________
* Apua ja neuvoja löydät Community Centralilta: http://community.wikia.com
* Haluatko vähemmän sähköpostia meiltä? Voit muuttaa asetuksiasi täällä:
http://community.wikia.com/wiki/Toiminnot:Asetukset',
	'enotif_body_article_comment-HTML' => '<p>Hei $WATCHINGUSERNAME,
<br /><br />
{{SITENAME}}n sivulla $PAGETITLE on uusi kommentti. Seuraa tätä linkkiä nähdäksesi kaikki kommentit: 
$PAGETITLE_URL#WikiaArticleComments
<br /><br />

- Wikia Community Support
___________________________________________
<ul>
<li>Löydä apua ja neuvoja Yhteisöwikiltä: <a href="http://yhteiso.wikia.com">http://yhteiso.wikia.com</a><li>
<li>Haluatko saada meiltä vähemmän viestejä? Voit muuttaa sähköpostiasetuksesi täällä: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = [
	'article-comments-file-page' => "[[$1|Viðmerking frá $2]] hin [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Viðmerking frá $2]] hin [[$3|$4]] sum innslag á [[$5|$6's]] blogginum",
	'article-comments-anonymous' => 'Dulnevndur brúkari',
	'article-comments-comments' => 'Viðmerkingar ($1)',
	'article-comments-post' => 'Send tína viðmerking',
	'article-comments-cancel' => 'Angrað',
	'article-comments-delete' => 'strikað',
	'article-comments-edit' => 'rætta',
	'article-comments-history' => 'søga',
	'article-comments-error' => 'Viðmerkingin kundi ikki verða goymd',
	'article-comments-toc-item' => 'Viðmerkingar',
	'article-comments-reply' => 'Svara',
	'article-comments-show-all' => 'Vís allar viðmerkingar',
	'article-comments-prev-page' => 'Áðrenn',
	'article-comments-next-page' => 'Næsta',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-none' => 'Ongar viðmerkingar',
	'wikiamobile-article-comments-view' => 'Vís svar',
	'wikiamobile-article-comments-replies' => 'svar',
	'wikiamobile-article-comments-post-reply' => 'Send eitt svar',
	'wikiamobile-article-comments-post' => 'Skriva',
	'wikiamobile-article-comments-placeholder' => 'Skriva eina viðmerking',
];

/** French (français)
 * @author 0x010C
 * @author Crochet.david
 * @author Gomoko
 * @author Jgaignerot
 * @author Verdy p
 * @author Wyz
 * @author Zetud
 */
$messages['fr'] = [
	'article-comments-desc' => 'Commentaires d’article pour des pages du wiki',
	'article-comments-file-page' => "[[$1|Commentaire de $2]] sur [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Commentaire de $2]] sur [[$3|$4]] publié sur le blog de [[$5|$6]]",
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
	'article-comments-fbconnect' => 'Veuillez <a href="$1">relier ce compte à Facebook</a> pour commenter !',
	'article-comments-rc-blog-comment' => 'Commentaire de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Commentaires de blog ([[$1]])',
	'article-comments-login' => 'Veuillez vous [[Special:UserLogin|connecter]] pour laisser un commentaire sur ce wiki.',
	'article-comments-toc-item' => 'Commentaires',
	'article-comments-comment-cannot-add' => "Vous ne pouvez pas ajouter de commentaire à l'article.",
	'article-comments-vote' => 'Intéressant',
	'article-comments-reply' => 'Répondre',
	'article-comments-show-all' => 'Afficher tous les commentaires',
	'article-comments-prev-page' => 'Précédent',
	'article-comments-next-page' => 'Suivant',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'La page ou le commentaire parent a été effacé.',
	'article-comments-empty-comment' => "Vous ne pouvez pas poster un commentaire vide. [$1 Le supprimer ?]",
	'article-comments-show-more' => 'Afficher plus de commentaires',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|commentaire|commentaires}}',
	'wikiamobile-article-comments-header' => 'Commentaires',
	'wikiamobile-article-comments-more' => 'Lire la suite',
	'wikiamobile-article-comments-prev' => 'Charger le précédent',
	'wikiamobile-article-comments-none' => 'Aucun commentaire',
	'wikiamobile-article-comments-view' => 'Afficher les réponses',
	'wikiamobile-article-comments-replies' => 'réponses',
	'wikiamobile-article-comments-post-reply' => 'Envoyer une réponse',
	'wikiamobile-article-comments-post' => 'Envoyer',
	'wikiamobile-article-comments-placeholder' => 'Envoyer un commentaire',
	'wikiamobile-article-comments-login-post' => 'Veuillez vous connecter pour poster un commentaire.',
	'wikiamobile-article-comments-post-fail' => 'Échec de l’enregistrement du commentaire, veuillez réessayer plus tard',
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
];

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = [
	'article-comments-comments' => 'Opmerkings ($1)',
	'article-comments-cancel' => 'Annulearje',
	'article-comments-delete' => 'fuortsmite',
	'article-comments-edit' => 'bewurkje',
	'article-comments-history' => 'skiednis',
	'article-comments-toc-item' => 'Opmerkings',
	'article-comments-prev-page' => 'Foarige',
	'article-comments-next-page' => 'Folgjende',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|opmerking|opmerkings}}',
	'wikiamobile-article-comments-header' => 'Opmerkings',
	'wikiamobile-article-comments-more' => 'Mear laden',
];

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = [
	'article-comments-file-page' => "[[$1|Comentario de $2]] en [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comentario de $2]] en [[$3|$4]], publicado no blogue de [[$5|$6]]",
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
	'article-comments-login' => '[[Special:UserLogin|Acceda ao sistema]] para publicar un comentario neste wiki.',
	'article-comments-toc-item' => 'Comentarios',
	'article-comments-comment-cannot-add' => 'Non pode engadir un comentario ao artigo.',
	'article-comments-vote' => 'Votar positivamente',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos os comentarios',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Seguinte',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'O artigo ou comentario raíz foi borrado.',
	'article-comments-empty-comment' => "Non pode enviar un comentario baleiro. [$1 Quere borralo?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|comentario|comentarios}}',
	'wikiamobile-article-comments-header' => 'Comentarios',
	'wikiamobile-article-comments-more' => 'Cargar máis',
	'wikiamobile-article-comments-prev' => 'Cargar os anteriores',
	'wikiamobile-article-comments-none' => 'Sen comentarios',
	'wikiamobile-article-comments-view' => 'Ollar as respostas',
	'wikiamobile-article-comments-replies' => 'respostas',
	'wikiamobile-article-comments-post-reply' => 'Publicar unha resposta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Publicar un comentario',
	'wikiamobile-article-comments-login-post' => 'Acceda ao sistema para publicar un comentario.',
	'wikiamobile-article-comments-post-fail' => 'Erro ao gardar o comentario; inténteo de novo máis tarde',
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
];

/** Gujarati (ગુજરાતી)
 * @author KartikMistry
 */
$messages['gu'] = [
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|ટીપ્પણી|ટીપ્પણીઓ}}',
];

/** Hawaiian (Hawai`i)
 * @author Kolonahe
 */
$messages['haw'] = [
	'article-comments-post' => 'Kākau',
	'article-comments-cancel' => 'Hoʻōki',
	'article-comments-delete' => 'holoi',
	'article-comments-edit' => 'hoʻololi',
	'article-comments-history' => 'mōʻaukala',
	'article-comments-error' => 'Hiki ʻole ke mālama ʻia ka manaʻo',
	'article-comments-rc-comment' => 'Manaʻo ʻatikala (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Manaʻo ʻatikala ([[$1]])',
	'article-comments-rc-blog-comment' => 'Manaʻo bologa (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Manaʻo bologa ([[$1]])',
	'article-comments-toc-item' => 'Manaʻo',
	'article-comments-show-all' => 'Hōʻike piha i nā manaʻo',
	'article-comments-prev-page' => 'ʻAoʻao ma mua',
	'article-comments-next-page' => 'ʻAoʻao aʻe',
	'wikiamobile-article-comments-header' => 'Manaʻo',
	'wikiamobile-article-comments-post' => 'Kākau',
	'wikiamobile-article-comments-placeholder' => 'Kākau i ka manaʻo',
	'wikiamobile-article-comments-login-post' => 'ʻEʻe no ke kākau manaʻo ʻana, ke ʻoluʻolu.',
];

/** Hebrew (עברית)
 * @author LaG roiL
 * @author Ofekalef
 * @author Yova
 */
$messages['he'] = [
	'article-comments-anonymous' => 'משתמש אנונימי',
	'article-comments-comments' => 'תגובות ($1)',
	'article-comments-post' => 'פרסם תגובה',
	'article-comments-cancel' => 'ביטול',
	'article-comments-delete' => 'מחיקה',
	'article-comments-edit' => 'עריכה',
	'article-comments-history' => 'היסטוריה',
	'article-comments-error' => 'לא ניתן היה לשמור את התגובה',
	'article-comments-rc-comments' => 'תגובות ערכים ([[$1]])',
	'article-comments-fblogin' => 'אנא <a href="$1" rel="nofollow">התחבר בעזרת פייסבוק</a> על מנת לפרסם תגובה בוויקי זו!',
	'article-comments-fbconnect' => 'נא <a href="$1">לקשר את חשבון זה לפייסבוק</a> על מנת להגיב!',
	'article-comments-login' => 'נא [[Special:UserLogin|להיכנס לחשבון]] על מנת לפרסם תגובה.',
	'article-comments-toc-item' => 'תגובות',
	'article-comments-comment-cannot-add' => 'אינך יכול להוסיף תגובה לערך',
	'article-comments-reply' => 'הגב',
	'article-comments-show-all' => 'הצגת כל התגובות',
	'article-comments-prev-page' => 'הקודם',
	'article-comments-next-page' => 'הבא',
	'article-comments-empty-comment' => "לא ניתן לפרסם תגובה ריקה. [$1 האם ברצונכם למוחקה?]",
	'article-comments-show-more' => 'הצגת עוד תגובות',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|תגובה אחת|תגובות}}',
	'wikiamobile-article-comments-header' => 'תגובות',
	'wikiamobile-article-comments-more' => 'טעינת עוד',
	'wikiamobile-article-comments-prev' => 'טעינת הדף הקודם',
	'wikiamobile-article-comments-none' => 'אין תגובות',
	'wikiamobile-article-comments-view' => 'הצגת תשובות',
	'wikiamobile-article-comments-replies' => 'תשובות',
	'wikiamobile-article-comments-post-reply' => 'הגב',
	'wikiamobile-article-comments-post' => 'פרסום',
	'wikiamobile-article-comments-placeholder' => 'פרסום תגובה',
	'wikiamobile-article-comments-login-post' => 'נא להיכנס לחשבון על מנת להגיב.',
	'wikiamobile-article-comments-post-fail' => 'תגובתך לא נשמרה. נא לנסות שוב.',
	'enotif_subject_article_comment' => '$PAGEEDITOR הגיב על "$PAGETITLE" ב-{{SITENAME}}',
	'enotif_body_article_comment' => 'שלום, $WATCHINGUSERNAME,

ישנה תגובה חדשה בדף $PAGETITLE ב-{{SITENAME}}. נא להשתמש בקישור זה להצגת כל התגובות: $PAGETITLE_URL#WikiaArticleComments

- תמיכה קהילתית, ויקיה 

___________________________________________
* עזרה וייעוץ במרכז הקהילה: http://community.wikia.com
* רוצים פחות הודעות מאיתנו? ניתן לבטל את המנוי או לשנות את העדפות הדוא"ל כאן: http://community.wikia.com/Special:Preferences',
];

/** Hindi (हिन्दी)
 * @author Kush rohra
 */
$messages['hi'] = [
	'article-comments-anonymous' => 'बेनामी उपयोगकर्ता',
	'article-comments-comments' => 'टिप्पणियाँ ( $1 )',
	'article-comments-post' => 'टिप्पणी पोस्ट',
	'article-comments-cancel' => 'रद्द करें',
	'article-comments-delete' => 'हटाएँ',
	'article-comments-edit' => 'संपादित करें',
	'article-comments-history' => 'इतिहास',
	'article-comments-error' => 'टिप्पणी को सहेजा नहीं जा सका',
	'article-comments-toc-item' => 'टिप्पणियाँ',
	'article-comments-comment-cannot-add' => 'आप लेख के लिए एक टिप्पणी जोड़ें नहीं कर सकता।',
	'article-comments-vote' => 'ऊपर वोट',
	'article-comments-reply' => 'उत्तर दें',
	'article-comments-show-all' => 'सभी टिप्पणियाँ दिखाएँ',
	'article-comments-prev-page' => 'पिछली',
	'article-comments-next-page' => 'अगला',
	'article-comments-delete-reason' => 'जनक टिप्पणी नष्ट कर दिया गया है।',
	'wikiamobile-article-comments-more' => 'भार अधिक',
	'wikiamobile-article-comments-prev' => 'पिछले लोड',
	'wikiamobile-article-comments-none' => 'नहीं 
टिप्पणी',
	'wikiamobile-article-comments-view' => '
उत्तरों देखने के',
	'wikiamobile-article-comments-replies' => 'जवाब',
	'wikiamobile-article-comments-post-reply' => 'एक उत्तर पोस्ट',
	'wikiamobile-article-comments-post' => 'पोस्ट',
	'wikiamobile-article-comments-placeholder' => 'टिप्पणी पोस्ट करें',
	'wikiamobile-article-comments-login-post' => 'कृपया एक टिप्पणी पोस्ट करने में लॉग इन करें।',
	'wikiamobile-article-comments-post-fail' => 'टिप्पणी को बचाने के लिए, कृपया बाद में पुन: प्रयास करें विफल रहा',
];

/** Hunsrik (Hunsrik)
 * @author Paul Beppler
 */
$messages['hrx'] = [
	'article-comments-edit' => 'beoorbeite',
	'article-comments-history' => 'Versione',
	'article-comments-vote' => 'Abstimme',
	'article-comments-reply' => 'Antworte',
	'article-comments-show-all' => 'All Kommentare oonzeiche',
	'article-comments-prev-page' => 'Vorriche',
	'article-comments-next-page' => 'Nächst',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'Kommentare',
	'wikiamobile-article-comments-more' => 'Weitre loode',
	'wikiamobile-article-comments-prev' => 'Voariche loode',
	'wikiamobile-article-comments-none' => 'Ken Kommentare',
	'wikiamobile-article-comments-view' => 'Antworte zeiche',
	'wikiamobile-article-comments-replies' => 'Antworte',
	'wikiamobile-article-comments-post-reply' => 'Antworte',
	'wikiamobile-article-comments-post' => 'Abschicke',
	'wikiamobile-article-comments-placeholder' => 'Kommentiere',
	'wikiamobile-article-comments-login-post' => 'Bittschön meld dich an, um Kommentare zu schreibe.',
	'wikiamobile-article-comments-post-fail' => 'Der Kommentar konnte net gespeichert sin. Bittschön versuch das später wieder erneit.',
	'enotif_subject_article_comment' => '$PAGEEDITOR hot "$PAGETITLE" uff {{SITENAME}} kommentiert',
];

/** Hungarian (magyar)
 * @author Csega
 * @author Dani
 * @author TK-999
 * @author Tacsipacsi
 */
$messages['hu'] = [
	'article-comments-file-page' => "[[$1|$2 hozzászólása]] a(z) [[$3]] lapon",
	'article-blog-comments-file-page' => "[[$1|$2 hozzászólása]] a(z) [[$3|$4]] bejegyzéshez [[$5|$6]] blogján",
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
	'article-comments-login' => 'Kérjük, [[Special:UserLogin|jelentkezz be]] hozzászólás beküldéséhez.',
	'article-comments-toc-item' => 'Hozzászólások',
	'article-comments-comment-cannot-add' => 'Nem írhatsz hozzászólást a szócikkhez.',
	'article-comments-vote' => 'Szavazás',
	'article-comments-reply' => 'Válasz',
	'article-comments-show-all' => 'Összes hozzászólás',
	'article-comments-prev-page' => 'Előző',
	'article-comments-next-page' => 'Következő',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Az anyacikket / anyamegjegyzést törölték.',
	'article-comments-empty-comment' => "Nem írhatsz üres megjegyzést. [$1 Szeretnéd törölni?]",
	'article-comments-show-more' => 'Több megjegyzés',
	'wikiamobile-article-comments-counter' => '$1 megjegyzés',
	'wikiamobile-article-comments-header' => 'Hozzászólások',
	'wikiamobile-article-comments-more' => 'Több betöltése',
	'wikiamobile-article-comments-prev' => 'Előző betöltése',
	'wikiamobile-article-comments-none' => 'Nincsenek hozzászólások',
	'wikiamobile-article-comments-view' => 'Válaszok megtekintése',
	'wikiamobile-article-comments-replies' => 'válaszok',
	'wikiamobile-article-comments-post-reply' => 'Válasz beküldése',
	'wikiamobile-article-comments-post' => 'Küldés',
	'wikiamobile-article-comments-placeholder' => 'Hozzászólás elküldése',
	'wikiamobile-article-comments-login-post' => 'Kérünk, jelentkezz be a hozzászóláshoz.',
	'wikiamobile-article-comments-post-fail' => 'Nem sikerült elmenteni a hozzászólást; kérlek, próbáld újra később.',
	'enotif_subject_article_comment' => '$PAGEEDITOR hozzászólt a(z) "$PAGETITLE oldalhoz a(z) {{SITENAME}}-n.',
	'enotif_body_article_comment' => 'Szia $WATCHINGUSERNAME!

Van egy új hozzászólás a(z) „$PAGETITLE” oldalon. Ezen a linken az összes hozzászólást láthatod: $PAGETITLE_URL#WikiaArticleComments

- Wikia Community Support


___________________________________________
* Segítség és tanácsok a Közösségi Központban: http://community.wikia.com
* Kevesebb levelet szeretnél kapni? Leiratkozhatsz vagy módosíthatod az e-mail beállításaidat itt: http://community.wikia.com/Special:Preferences',
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
</p>', # Fuzzy
];

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = [
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
	'article-comments-login' => 'Per favor [[Special:UserLogin|aperi session]] pro publicar un commento in iste wiki.',
	'article-comments-toc-item' => 'Commentos',
	'article-comments-comment-cannot-add' => 'Tu non pote adjunger un commento a iste articulo.',
	'article-comments-vote' => 'Votar positivemente',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Monstrar tote le commentos',
	'article-comments-prev-page' => 'Previe',
	'article-comments-next-page' => 'Proxime',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Le commento/articulo genitor ha essite delite.',
	'article-comments-empty-comment' => "Non es possibile publicar un commento vacue. [$1 Deler lo?]",
	'wikiamobile-article-comments-header' => 'commentos',
	'wikiamobile-article-comments-more' => 'Cargar plus',
	'wikiamobile-article-comments-prev' => 'Cargar precedente',
	'wikiamobile-article-comments-none' => 'Nulle commento',
	'wikiamobile-article-comments-view' => 'Vider responsas',
	'wikiamobile-article-comments-replies' => 'responsas',
	'wikiamobile-article-comments-post-reply' => 'Adjunger un responsa',
	'wikiamobile-article-comments-post' => 'Inviar',
	'wikiamobile-article-comments-placeholder' => 'Publicar un commento',
	'wikiamobile-article-comments-login-post' => 'Per favor aperi session pro commentar.',
	'enotif_subject_article_comment' => '$PAGEEDITOR ha commentate "$PAGETITLE" sur {{SITENAME}}',
	'enotif_body_article_comment' => 'Car $WATCHINGUSERNAME,

$PAGEEDITOR lassava un commento sur "$PAGETITLE".

Pro vider le filo de commentos, seque le ligamine sequente:
$PAGETITLE_URL

Per favor visita e modifica sovente...

Wikia', # Fuzzy
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
</p>', # Fuzzy
];

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author C5st4wr6ch
 * @author Fate Kage
 * @author Riemogerz
 */
$messages['id'] = [
	'article-comments-desc' => 'Komentar artikel untuk halaman wiki',
	'article-comments-file-page' => "[[$1|Komentar dari $2]] pada [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Komentar dari $2]] di [[$3|$4]] posting di [[$5|$6]] blog",
	'article-comments-anonymous' => 'Pengguna anonim',
	'article-comments-comments' => 'Komentar ($1)',
	'article-comments-post' => 'Kirim komentar',
	'article-comments-cancel' => 'Batalkan',
	'article-comments-delete' => 'hapus',
	'article-comments-edit' => 'sunting',
	'article-comments-history' => 'riwayat',
	'article-comments-error' => 'Komentar tidak dapat disimpan',
	'article-comments-undeleted-comment' => 'Batalkan hapus komentar untuk halaman blog $1',
	'article-comments-rc-comment' => 'Komentar artikel (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Komentar artikel ([[$1]])',
	'article-comments-fblogin' => 'Silakan <a href="$1" rel="nofollow">masuk log dan terhubung dengan Facebook</a> untuk mengirim komentar pada wiki ini!',
	'article-comments-fbconnect' => 'Silakan <a href="$1">hubungkan akun ini dengan Facebook</a> untuk berkomentar!',
	'article-comments-rc-blog-comment' => 'Komentar blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Komentar blog ([[$1]])',
	'article-comments-login' => 'Silakan [[Special:UserLogin|masuk]] untuk mengirim komentar pada wiki ini.',
	'article-comments-toc-item' => 'Komentar',
	'article-comments-comment-cannot-add' => 'Anda tidak dapat menambahkan komentar ke artikel',
	'article-comments-vote' => 'Memberikan suara',
	'article-comments-reply' => 'Balas',
	'article-comments-show-all' => 'Perlihatkan semua komentar',
	'article-comments-prev-page' => 'Sebelumnya',
	'article-comments-next-page' => 'Selanjutnya',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Artikel induk / komentar induk telah dihapus.',
	'article-comments-empty-comment' => "Anda tidak dapat mengirim komentar kosong. [$1 Hapus saja?]",
	'article-comments-show-more' => 'Tampilkan komentar lainnya',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|komentar|komentar}}',
	'wikiamobile-article-comments-header' => 'Komentar',
	'wikiamobile-article-comments-more' => 'Muat lebih',
	'wikiamobile-article-comments-prev' => 'Muat sebelumnya',
	'wikiamobile-article-comments-none' => 'Tidak ada komentar',
	'wikiamobile-article-comments-view' => 'Lihat balasan',
	'wikiamobile-article-comments-replies' => 'balasan',
	'wikiamobile-article-comments-post-reply' => 'Kirimkan balassan',
	'wikiamobile-article-comments-post' => 'Kirim',
	'wikiamobile-article-comments-placeholder' => 'Kirim komentar',
	'wikiamobile-article-comments-login-post' => 'Silakan masuk log untuk mengirimkan komentar.',
	'wikiamobile-article-comments-post-fail' => 'Gagal untuk menyimpan komentar, silakan coba lagi nanti',
	'enotif_subject_article_comment' => '$PAGEEDITOR telah berkomentar pada "$PAGETITLE" pada {{SITENAME}}',
	'enotif_body_article_comment' => 'Hai $WATCHINGUSERNAME,

Ada komentar baru pada $PAGETITLE di {{SITENAME}}. Gunakan pranala ini untuk melihat semua komentar: $PAGETITLE_URL#WikiaArticleComments

-Komunitas Dukungan Wikia

___________________________________________
 * Temukan bantuan dan saran di Pusat Komunitas: http://community.wikia.com
* Ingin menerima lebih sedikit pesan dari kami? Anda dapat berhenti berlangganan atau mengubah preferensi surel Anda di sini: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hai $WATCHINGUSERNAME,
<br /><br />
Ada komentar baru di $PAGETITLE pada {{SITENAME}}. Gunakan pranala ini untuk melihat semua komentar: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Dukungan Komunitas Wikia
<br /><br />
___________________________________________
<ul>
<li>Menemukan bantuan dan saran di Pusat Komunitas: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Ingin menerima lebih sedikit pesan dari kami? Anda dapat berhenti berlangganan atau mengubah pengaturan email Anda di sini: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Ingush (ГӀалгӀай)
 * @author Sapral Mikail
 */
$messages['inh'] = [
	'article-comments-comments' => 'Дашхамаш ($1)',
	'article-comments-post' => 'Дашхам ле',
	'article-comments-cancel' => 'Эшац',
	'article-comments-delete' => 'д|аяккха',
	'article-comments-edit' => 'хувца',
	'article-comments-history' => 'тархьар',
	'article-comments-toc-item' => 'Дашхамаш',
	'wikiamobile-article-comments-header' => 'Дашхамаш',
	'wikiamobile-article-comments-post' => 'Дита',
	'wikiamobile-article-comments-placeholder' => 'Дашхам ле',
];

/** Italian (italiano)
 * @author Beta16
 * @author Geitost
 * @author Leviathan 89
 * @author Lucas2
 * @author Minerva Titani
 * @author PeppeAeco
 * @author TecnoMaster
 * @author Viscontino
 * @author Ximo17
 */
$messages['it'] = [
	'article-comments-desc' => 'commenti della pagina wiki',
	'article-comments-file-page' => "[[$1|Commento da $2]] su [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Commento di $2]] su [[$3|$4]] nel blog di [[$5|$6]]",
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
	'article-comments-login' => 'Per favore [[Special:UserLogin|accedi]] per postare un commento su questa wiki.',
	'article-comments-toc-item' => 'Commenti',
	'article-comments-comment-cannot-add' => "Non puoi commentare l'articolo",
	'article-comments-vote' => 'Vota',
	'article-comments-reply' => 'Rispondi',
	'article-comments-show-all' => 'Mostra tutti i commenti',
	'article-comments-prev-page' => 'Prec',
	'article-comments-next-page' => 'Succ',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => "L'articolo / commento padre è stato cancellato.",
	'article-comments-empty-comment' => "Non puoi inserire un commento vuoto. [$1 Vuoi cancellarlo invece?]",
	'article-comments-show-more' => 'mostra altri commenti',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|commento|commenti}}',
	'wikiamobile-article-comments-header' => 'Commenti',
	'wikiamobile-article-comments-more' => 'Caricane ancora',
	'wikiamobile-article-comments-prev' => 'Carica precedenti',
	'wikiamobile-article-comments-none' => 'Nessun commento',
	'wikiamobile-article-comments-view' => 'Visualizza risposte',
	'wikiamobile-article-comments-replies' => 'risposte',
	'wikiamobile-article-comments-post-reply' => 'Rispondi',
	'wikiamobile-article-comments-post' => 'Posta',
	'wikiamobile-article-comments-placeholder' => 'Commenta',
	'wikiamobile-article-comments-login-post' => 'Effettua il login per lasciare un commento.',
	'wikiamobile-article-comments-post-fail' => 'Fallito nel salvataggio del commento, si prega di riprovare più tardi',
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
];

/** Japanese (日本語)
 * @author 2nd-player
 * @author Barrel0116
 * @author Plover-Y
 * @author Schu
 * @author Shirayuki
 * @author Tommy6
 */
$messages['ja'] = [
	'article-comments-file-page' => "[[$3]]での[[$1|$2からのコメント]]",
	'article-blog-comments-file-page' => "[[$5|$6のブログ]]の記事「[[$3|$4]]」での[[$1|$2からのコメント]]",
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
	'article-comments-login' => 'コメントするには[[Special:UserLogin|ログイン]]する必要があります',
	'article-comments-toc-item' => 'コメント',
	'article-comments-comment-cannot-add' => 'この記事にはコメントを追加できません。',
	'article-comments-vote' => '投票する',
	'article-comments-reply' => '返信する',
	'article-comments-show-all' => '全てのコメントを表示',
	'article-comments-prev-page' => '前',
	'article-comments-next-page' => '次',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '親記事/親コメントが削除されました',
	'article-comments-empty-comment' => "空コメントを投稿することはできません。[$1 コメントを削除しますか？]",
	'wikiamobile-article-comments-header' => 'コメント',
	'wikiamobile-article-comments-more' => '続きを読み込む',
	'wikiamobile-article-comments-prev' => 'これより前を読み込む',
	'wikiamobile-article-comments-none' => 'コメントなし',
	'wikiamobile-article-comments-view' => '返信を見る',
	'wikiamobile-article-comments-replies' => '返信',
	'wikiamobile-article-comments-post-reply' => '返信を投稿',
	'wikiamobile-article-comments-post' => '投稿',
	'wikiamobile-article-comments-placeholder' => 'コメントを投稿',
	'wikiamobile-article-comments-login-post' => 'コメントを投稿するにはログインする必要があります。',
	'wikiamobile-article-comments-post-fail' => 'コメントの保存に失敗しました。のちほどもう一度お試しください。',
	'enotif_subject_article_comment' => '{{SITENAME}} のページ「$PAGETITLE」に $PAGEEDITOR がコメントを投稿しました',
	'enotif_body_article_comment' => 'こんにちは、$WATCHINGUSERNAMEさん、

{{SITENAME}}の $PAGETITLE に $PAGEEDITOR がコメントをつけました。

全てのコメントを見るには、次のURLにアクセスしてください:
$PAGETITLE_URL

- Wikiaコミュニティーサポート
___________________________________________
* コミュニティセントラルでヘルプやアドバイスを読む: http://ja.community.wikia.com
* わたしたちから受け取るメッセージを減らしたいですか？ こちらで、あなたの受け取るメールの解除・変更を設定することができます: http://ja.community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>$WATCHINGUSERNAMEさん、こんにちは。
<br /><br />
{{SITENAME}}の$PAGETITLEに、新たなコメントがつきました。このリンクから、すべてのコメントが閲覧できます：$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- ウィキア コミュニティ サポート
<br /><br />
___________________________________________
<ul>
<li>コミュニティセントラル上のヘルプやアドバイスを見つける：<a href="http://ja.community.wikia.com">http://ja.community.wikia.com</a><li>
<li>私たちからのメッセージを受け取りたくないですか？あなたは、設定から受信設定を変更することができます: <a href="http://ja.community.wikia.com/Special:Preferences">http://ja.community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Georgian (ქართული)
 * @author DevaMK
 * @author GeorgeBarnick
 * @author MIKHEIL
 */
$messages['ka'] = [
	'article-comments-anonymous' => 'ანონიმი მომხმარებელი',
	'article-comments-comments' => 'კომენტარები ($1)',
	'article-comments-cancel' => 'გაუქმება',
	'article-comments-delete' => 'წაშლა',
	'article-comments-edit' => 'რედაქტირება',
	'article-comments-history' => 'ისტორია',
	'article-comments-toc-item' => 'კომენტარები',
	'article-comments-reply' => 'პასუხი',
	'article-comments-show-all' => 'ნახოთ ყველა კომენტარი',
	'article-comments-show-more' => 'მეტი კომენტარების ნახვა',
	'wikiamobile-article-comments-header' => 'კომენტარები',
];

/** Khmer (ភាសាខ្មែរ)
 * @author T-Rithy
 */
$messages['km'] = [
	'article-comments-cancel' => 'បោះបង់',
	'article-comments-delete' => 'លប់',
	'article-comments-edit' => 'កែប្រែ',
	'article-comments-history' => 'ប្រវត្តិ',
	'article-comments-error' => 'មតិនេះមិនត្រូវបានរក្សាទុកទេ',
	'article-comments-toc-item' => 'មតិ',
	'article-comments-reply' => 'ឆ្លើយតប',
	'article-comments-prev-page' => 'មុន​',
	'article-comments-next-page' => 'បន្ទាប់',
];

/** Kannada (ಕನ್ನಡ)
 * @author Dimension10
 */
$messages['kn'] = [
	'article-comments-file-page' => "[[$3]] ಅಲ್ಲಿ [[$1|$2 ಇಂದ ಟಿಪ್ಪಣಿ]]",
	'article-blog-comments-file-page' => "[[$5|$6 ಇನ ]] ಬ್ಲಾಗ್ ಅಲ್ಲಿ [[$3|$4]] ಪೋಸ್ಟ್ ಮೇಲೆ [[$1|$2 ಇಂದ ಟಿಪ್ಪಣಿ]]",
	'article-comments-anonymous' => 'ಅನಾಮಿಕ ಸದಸ್ಯ',
	'article-comments-comments' => 'ಟಿಪ್ಪಣಿಗಳು ($1)',
	'article-comments-post' => 'ಟಿಪ್ಪಣಿ ಹಾಕಿ',
	'article-comments-cancel' => 'ರದ್ದು ಮಾಡು',
	'article-comments-delete' => 'ಅಳಿಸಿ',
	'article-comments-edit' => 'ಸಂಪಾದಿಸಿ',
	'article-comments-history' => 'ಇತಿಹಾಸ',
	'article-comments-error' => 'ಟಿಪ್ಪಣಿ ಅನ್ನು ಉಳಿಸಲಿಕ್ಕೆ ಆಗಲಿಲ್ಲ',
	'article-comments-undeleted-comment' => '$1 ಬ್ಲಾಗ್ ಪುಟ ಇಗೆ ಟಿಪ್ಪಣಿ ಇನ ಅಳಿಸುದನ್ನ ರದ್ದು ಮಾಡಿದು',
	'article-comments-rc-comment' => 'ಪುಟಕ್ಕೆ ತಿಪನ್ನಿ (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'ಪುಟಕ್ಕೆ ತಿಪನ್ನಿಗಳು ([[$1]])',
	'article-comments-fblogin' => 'ಈ ವಿಕಿಗೆ ಟಿಪ್ಪಣಿ ಹಾಕಲಿಕ್ಕೆ ದೈವಿತ್ತು <a href="$1" rel="nofollow">ಲಾಗ್ ಇನ್ ಮಾಡಿಕೊಂಡು ಫೇಸ್ಬುಕ್ ಒಟ್ಟಿಗೆ ಕನೆಕ್ಟ್ ಮಾಡಿ</a>!',
	'article-comments-fbconnect' => 'ದೈವಿತ್ತು ಟಿಪ್ಪಣಿ ಹಾಕಲಿಕ್ಕೆ <a href="$1">ಈ ಖಾತೆ ವನ್ನು ಫೇಸ್ಬುಕ್ ಒಟ್ಟಿಗೆ ಕನೆಕ್ಟ್ ಮಾಡಿ</a>!',
	'article-comments-rc-blog-comment' => 'ಬ್ಲಾಗ್ ಇಗೆ  ಟಿಪ್ಪಣಿ (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'ಬ್ಲಾಗ್ ಇಗೆ  ಟಿಪ್ಪಣಿ ([[$1]])',
	'article-comments-login' => 'ದೈವಿತ್ತು ಈ ವಿಕಿಗೆ ಟಿಪ್ಪಣಿ ಹಾಕಲಿಕ್ಕೆ [[Special:UserLogin|ಲಾಗ್ ಇನ್]] ಮಾಡಿ.',
	'article-comments-toc-item' => 'ಟಿಪ್ಪಣಿಗಳು',
	'article-comments-comment-cannot-add' => 'ನಿಮಗೆ ಈ ಪುಟಕ್ಕೆ ಟಿಪ್ಪಣಿ ಹಾಕಲಿಕ್ಕೆ ಆಗುದಿಲ್ಲ.',
	'article-comments-vote' => 'ಉಪ್ವೊಟ್',
	'article-comments-reply' => 'ಉತ್ತರ ಕೊಡು',
	'article-comments-show-all' => 'ಯಲ್ಲವೂ ಟಿಪ್ಪಣಿಗಳನ್ನ ತೋರಿಸು',
	'article-comments-prev-page' => 'ಮೊದ್ದಲಿದು',
	'article-comments-next-page' => 'ಆದಮೆಲಿದು',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'ಅಭಿಭಾವಕ ಟಿಪ್ಪಣಿ ಅಥವಿ ಪುಟ ನಷ್ಟ ಆಗಿ ಹೋಗಿದೆ',
	'article-comments-empty-comment' => "ಕಾಳಿ ಟಿಪ್ಪಣಿ ಹಾಕಲ್ಕ್ಕೆ ಇಲ್ಲ! [$1 ಅದರ ಬೋದ್ದಳು ಅದನ್ನ ಅಳಿಸುತೀರ?]",
	'wikiamobile-article-comments-header' => 'ಟಿಪ್ಪಣಿಗಳು',
	'wikiamobile-article-comments-more' => 'ಇನ್ನೂ ತೋರಿಸಿ',
	'wikiamobile-article-comments-prev' => 'ಮೊದಲಿದ್ದು ತೋರಿಸಿ',
	'wikiamobile-article-comments-none' => 'ಒಂದು ಟಿಪ್ಪಣಿ ಇಲ್ಲ',
	'wikiamobile-article-comments-view' => 'ಉತ್ತರಗಳನ್ನ ನೋಡಿ',
	'wikiamobile-article-comments-replies' => 'ಉತ್ತರಗಳು',
	'wikiamobile-article-comments-post-reply' => 'ಉತ್ತರ ಕೊಡಿ!',
	'wikiamobile-article-comments-post' => 'ಪೋಸ್ಟ್ ಮಡಿ',
	'wikiamobile-article-comments-placeholder' => 'ಒಂದು ಟಿಪ್ಪಣಿ ಹಾಕಿ',
	'wikiamobile-article-comments-login-post' => 'ದೈವಿತ್ತು ಟಿಪ್ಪಣಿ ಹಾಕಲಿಕ್ಕೆ ಲಾಗ್ ಇನ್ ಆಗಿ.',
	'wikiamobile-article-comments-post-fail' => 'ಟಿಪ್ಪಣಿ ವನ್ನು ಉಳಿಸಲಿಕ್ಕೆ ಆಗಲಿಲ್ಲ. ದೈವಿತ್ತು ಸ್ವಲ್ಪ ಹೊತ್ತು ಆದಮೇಲೆ ಪ್ರಯತ್ನ ಮಾದಿ.',
	'enotif_subject_article_comment' => ' {{SITENAME}}  ಅಲ್ಲಿ $PAGETITLE ಮೇಲೆ   $PAGEEDITOR ಟಿಪ್ಪಣಿ ಹಾಕಿದಾರೆ',
	'enotif_body_article_comment' => 'ನಮಸ್ಕಾರ $WATCHINGUSERNAME, 

{{SITENAME}} ಅಲ್ಲಿ $PAGETITLE ಮೇಲೆ ಒಂದು ಹೊಸ ಟಿಪ್ಪಣಿ ಉನ್ತು. ಈ ಲಿಂಕ್ ಅಣ್ಣ ಯಲ್ಲವೂ ಟಿಪ್ಪಣಿಗಳ್ಳನ್ನು ನೋಡಲಿಕ್ಕೆ ಉಪಯೋಗ ಮಾಡಿ: $PAGETITLE_URL#WikiaArticleComments  

ವಿಕಿಯದ ಸಮಾಜ ಸಂರಕ್ಷಣ    
______________________________________________ 
* ಸಮಾಜ ಕೇಂದ್ರದಲ್ಲಿ ಸಹಾಯತೆ ಮತ್ತು ಸಲಹ ತೆಕ್ಕೊಳ್ಳಿ. http://community.wikia.com             
* ನಮ್ಮಿಂದ ಕಡಿಮೆ ಪತ್ರಗಳು ಬೆಕ? ಕ್ಯಬರಹ ರದ್ದು ಮಾಡು ಅಥವಾ ನಿಮ್ಮ ಈಮೇಯ್ಲ್ ಅದ್ಯತಗಳನ್ನು ಇಲ್ಲಿ ಬದಲಾಯಿಸು : http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p> ನಮಸ್ಕಾರ $WATCHINGUSERNAME,
 <br /><br /> 
{{SITENAME}} ಅಲ್ಲಿ  $PAGETITLE ಮೇಲೆ ಒಂದು ಹೊಸ ಟಿಪ್ಪಣಿ ಉಂಟು. ಈ ಲಿಂಕ್ ಅನ್ನು ಉಪಯೋಗ ಮಡಿ: $PAGETITLE_URL#WikiaArticleComments        
<br /><br /> 
 - ವಿಕಿಯ ಸಮಾಜ ಸಮರ್ಥನ  
__________________________      
<ul>
<li> ಸಮಾಜ ಕೇಂದ್ರದಲ್ಲಿ ಸಹಯತೆ ಮತ್ತು ಸಲಹಾ ತೆಕೊಳ್ಳಿ : <a href="http://community.wikia.com">http://community.wikia.com</a>.       <li>   
<li>ನಮ್ಮಿಂದ ಕಡಿಮೆ ಪತ್ರಗಳು ಬೆಕ? ಕ್ಯಬರಹ ರದ್ದು ಮಾಡು ಅಥವಾ ನಿಮ್ಮ ಈಮೇಯ್ಲ್ ಅದ್ಯತಗಳನ್ನು ಇಲ್ಲಿ ಬದಲಾಯಿಸು : <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>    
</ul> 
</p>',
];

/** Korean (한국어)
 * @author Cafeinlove
 * @author Gusdud25
 * @author Hym411
 * @author Leehoy
 * @author Miri-Nae
 * @author Revi
 * @author 아라
 * @author 한글화담당
 */
$messages['ko'] = [
	'article-comments-desc' => '위키 페이지의 문서 댓글',
	'article-comments-file-page' => "[[$3]]에 남겨진 [[$1|$2 사용자의 댓글]]",
	'article-blog-comments-file-page' => "[[$5|$6의]] [[$3|블로그 글, $4]]에 남겨진 [[$1|$2 사용자의 댓글]]",
	'article-comments-anonymous' => '익명 사용자',
	'article-comments-comments' => '덧글 ($1)',
	'article-comments-post' => '덧글 남기기',
	'article-comments-cancel' => '취소',
	'article-comments-delete' => '삭제',
	'article-comments-edit' => '편집',
	'article-comments-history' => '역사',
	'article-comments-error' => '덧글을 저장할 수 없습니다',
	'article-comments-undeleted-comment' => '블로그 글 $1의 삭제되지 않은 댓글',
	'article-comments-rc-comment' => '문서 댓글 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => '문서 댓글 ([[$1]])',
	'article-comments-fblogin' => '이 위키에 덧글을 남기려면 <a href="$1" rel="nofollow">로그인하고 페이스북과 연결</a>하세요!',
	'article-comments-fbconnect' => '덧글을 남기려면 <a href="$1">이 계정을 페이스북과 연걸</a>하세요!',
	'article-comments-rc-blog-comment' => '블로그 댓글 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '블로그 댓글 ([[$1]])',
	'article-comments-login' => '이 글에 덧글을 남기려면 [[Special:UserLogin|로그인]]하세요.',
	'article-comments-toc-item' => '댓글',
	'article-comments-comment-cannot-add' => '문서에 덧글을 추가할 수 없습니다.',
	'article-comments-vote' => '투표하기',
	'article-comments-reply' => '답글',
	'article-comments-show-all' => '모든 댓글 보기',
	'article-comments-prev-page' => '이전',
	'article-comments-next-page' => '다음',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '상위 문서 / 상위 덧글이 삭제되었습니다.',
	'article-comments-empty-comment' => "빈 덧글은 남길 수 없습니다. [$1 대신 삭제하겠습니까?]",
	'article-comments-show-more' => '더 많은 코멘트 보기',
	'wikiamobile-article-comments-counter' => '{{PLURAL:$1|의견}} $1개',
	'wikiamobile-article-comments-header' => '댓글',
	'wikiamobile-article-comments-more' => '더 불러오기',
	'wikiamobile-article-comments-prev' => '이전 불러오기',
	'wikiamobile-article-comments-none' => '댓글 없음',
	'wikiamobile-article-comments-view' => '댓글 보기',
	'wikiamobile-article-comments-replies' => '댓글',
	'wikiamobile-article-comments-post-reply' => '답변 게시',
	'wikiamobile-article-comments-post' => '게시',
	'wikiamobile-article-comments-placeholder' => '댓글 남기기',
	'wikiamobile-article-comments-login-post' => '덧글을 남기려면 로그인하세요.',
	'wikiamobile-article-comments-post-fail' => '덧글을 저장하는 데에 실패했습니다, 나중에 다시 시도해주세요',
	'enotif_subject_article_comment' => '$PAGEEDITOR님이 {{SITENAME}}의 "$PAGETITLE"에 덧글을 남겼습니다',
	'enotif_body_article_comment' => '$WATCHINGUSERNAME님 안녕하세요,

{{SITENAME}}의 $PAGETITLE 에서 새 덧글이 있습니다. 모든 덧글을 보려면 다음 링크를 사용하세요: $PAGETITLE_URL#WikiaArticleComments

- 위키아 커뮤니티 지원

___________________________________________
* 중앙 커뮤니티에서 도움을 구하세요: http://community.wikia.com
* 알림을 그만 받고 싶으신가요? 여기서 구독을 취소하거나 이메일 환경 설정을 바꿀 수 있습니다: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>안녕하세요.
<br /><br />
{{SITENAME}}의 $PAGETITLE에 새로운 덧글이 있습니다. 다음 링크를 통해 모든 덧글을 확인하세요:
$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- 위키아 커뮤니티 지원
<br /><br />
___________________________________________
<ul>
<li>중앙 커뮤니티에서 도움을 구하세요: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>알림을 그만 받고 싶으신가요? 여기서 구독을 취소하거나 이메일 환경 설정을 바꿀 수 있습니다: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Karachay-Balkar (къарачай-малкъар)
 * @author Iltever
 */
$messages['krc'] = [
	'article-comments-anonymous' => 'Аноним',
];

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = [
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
];

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 * @author George Animal
 */
$messages['ku-latn'] = [
	'article-comments-cancel' => 'Betal bike',
	'article-comments-delete' => 'jê bibe',
	'article-comments-edit' => 'biguherîne',
	'article-comments-history' => 'dîrok',
	'article-comments-toc-item' => 'Şîrove',
	'article-comments-reply' => 'Bersiv bide',
	'article-comments-next-page' => 'Pêşve',
];

/** Kyrgyz (Кыргызча)
 * @author Growingup
 */
$messages['ky'] = [
	'article-comments-cancel' => 'Жокко чыгаруу',
	'article-comments-delete' => 'өчүрүү',
	'article-comments-edit' => 'оңдоо',
	'article-comments-history' => 'тарых',
	'article-comments-toc-item' => 'Комментарийлер',
	'article-comments-reply' => 'Жооп берүү',
	'article-comments-next-page' => 'Кийинки',
	'wikiamobile-article-comments-post' => 'Калтыруу',
];

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 * @author Soued031
 */
$messages['lb'] = [
	'article-comments-file-page' => "[[$1|Bemierkung vum $2]] iwwer [[$3]]",
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
	'article-comments-comment-cannot-add' => 'Dir däerft keng Bemierkung bei den Artikel derbäisetzen.',
	'article-comments-vote' => 'Stëmmt of',
	'article-comments-reply' => 'Äntwerten',
	'article-comments-show-all' => 'All Bemierkunge weisen',
	'article-comments-prev-page' => 'Vireg',
	'article-comments-next-page' => 'Nächst',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-show-more' => 'Méi Bemierkunge weisen',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Bemierkung|Bemierkungen}}',
	'wikiamobile-article-comments-header' => 'Bemierkungen',
	'wikiamobile-article-comments-more' => 'Méi lueden',
	'wikiamobile-article-comments-prev' => 'Virege lueden',
	'wikiamobile-article-comments-none' => 'Keng Bemierkungen',
	'wikiamobile-article-comments-view' => 'Äntwerte kucken',
	'wikiamobile-article-comments-replies' => 'Äntwerten',
	'wikiamobile-article-comments-placeholder' => 'Bemierkung derbäisetzen',
	'wikiamobile-article-comments-post-fail' => "D'Bemierkung konnt net gespäichert ginn, probéiert w.e.g. méi spéit nach eng Kéier",
];

/** Lezghian (лезги)
 * @author Lezgia
 * @author Migraghvi
 */
$messages['lez'] = [
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
	'wikiamobile-article-comments-header' => 'Жузунар',
	'wikiamobile-article-comments-more' => 'Мадни ппарун',
	'wikiamobile-article-comments-prev' => 'Вилик алатай ппарун',
	'wikiamobile-article-comments-none' => 'КЪейдер авайд ттуш',
	'wikiamobile-article-comments-view' => 'Жавабриз килигин',
	'wikiamobile-article-comments-replies' => 'Хвекьун',
	'wikiamobile-article-comments-post-reply' => 'Хвекьун тун',
	'wikiamobile-article-comments-post' => 'Тун',
	'wikiamobile-article-comments-placeholder' => 'Жузунар тун',
	'wikiamobile-article-comments-login-post' => 'Гьахьа жузунар тун паталди',
	'wikiamobile-article-comments-post-fail' => 'Жузунар хуьз ханач гьахь ахпа',
	'enotif_subject_article_comment' => '$PAGEEDITOR жузунарна "$PAGETITLE"  ина {{SITENAME}}',
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
</p>', # Fuzzy
];

/** Northern Luri (لوری مینجایی)
 * @author Mogoeilor
 */
$messages['lrc'] = [
	'article-comments-anonymous' => 'كارور ناشناس',
	'article-comments-comments' => 'ویر و باوریا ($1)',
	'article-comments-post' => 'ویر و باورتونه فریشنار بکیت',
	'article-comments-cancel' => 'انجوم شیوسن',
	'article-comments-delete' => 'پاكسا كردن',
	'article-comments-edit' => 'ويرايشت',
	'article-comments-history' => 'ويرگار',
	'article-comments-error' => 'ویر و باور شما اماییه نبوئه',
	'article-comments-toc-item' => 'ویر و باوریا',
	'article-comments-comment-cannot-add' => 'شما نتونید نظر د ای گوتار اضاف بکید.',
	'article-comments-vote' => 'رایا ری وه بالا رئتنه',
	'article-comments-reply' => 'جؤاو ده ئن',
	'article-comments-show-all' => 'همه ویر و باوریا نه نشو بیه',
	'article-comments-prev-page' => 'دما',
	'article-comments-next-page' => 'نها',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'ویر و باوریا',
	'wikiamobile-article-comments-more' => 'بيشتر سواركرد كو',
	'wikiamobile-article-comments-prev' => 'دمایی نه سوار کو',
	'wikiamobile-article-comments-none' => 'بی نظر',
	'wikiamobile-article-comments-view' => 'درحاستیانه بویئنیت',
	'wikiamobile-article-comments-replies' => 'جؤاويا',
	'wikiamobile-article-comments-post-reply' => 'یه گل جواو بفرسنیت',
	'wikiamobile-article-comments-post' => 'فریشنار',
	'wikiamobile-article-comments-placeholder' => 'یه گل نظر بفرسنیت',
	'wikiamobile-article-comments-login-post' => 'خواهش می کیم سی نظر دیئن وارد سیستم بویئت',
];

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Mantak111
 * @author Robotukas11
 * @author Vilius
 */
$messages['lt'] = [
	'article-comments-anonymous' => 'Anoniminis vartotojas',
	'article-comments-comments' => 'Komentarai ( $1 )',
	'article-comments-post' => 'Rašyti komentarą',
	'article-comments-cancel' => 'Atšaukti',
	'article-comments-delete' => 'ištrinti',
	'article-comments-edit' => 'redaguoti',
	'article-comments-history' => 'istorija',
	'article-comments-error' => 'Komentaras negali būti išsaugotas',
	'article-comments-rc-comments' => '↓Straipsnio komentarai ([[$1]])',
	'article-comments-rc-blog-comment' => 'Blog\'o komentaras (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => "Blog'o komentarai ([[$1]])",
	'article-comments-login' => 'Prašome [[Special:UserLogin|prisijungti]] kad galėtumėte rašyti šioje wiki.',
	'article-comments-toc-item' => 'Komentarai',
	'article-comments-comment-cannot-add' => 'Jūs negalite pridėti komentarą į ši straipsnį.',
	'article-comments-vote' => '↓Balsuoti teigiamai',
	'article-comments-reply' => 'Atsakyti',
	'article-comments-show-all' => 'Rodyti visus komentarus',
	'article-comments-prev-page' => 'Ankstesnis',
	'article-comments-next-page' => 'Kitas',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'Komentarai',
	'wikiamobile-article-comments-more' => 'Įkelti daugiau',
	'wikiamobile-article-comments-prev' => 'Įkelti ankstesni',
	'wikiamobile-article-comments-none' => 'Nėra komentarų',
	'wikiamobile-article-comments-view' => '↓Žiūrėti atsakymus',
	'wikiamobile-article-comments-replies' => '↓atsakymai',
	'wikiamobile-article-comments-post-reply' => 'Skelbti atsakymą',
	'wikiamobile-article-comments-post' => 'Rašyti',
	'wikiamobile-article-comments-placeholder' => 'Rašyti komentarą',
	'wikiamobile-article-comments-login-post' => 'Prašome prisijungti, kad paskelbtumėte komentarą',
	'wikiamobile-article-comments-post-fail' => 'Nepavyko įrašyti komentarą, prašome pabandyti vėliau',
	'enotif_subject_article_comment' => '$PAGEEDITOR pakomentavo „$PAGETITLE“ {{SITENAME}}',
];

/** Mizo (Mizo ţawng)
 * @author RMizo
 */
$messages['lus'] = [
	'article-comments-anonymous' => 'Hmangtu hming lang lo',
	'article-comments-comments' => 'Tuihnihna ($1)',
	'article-comments-post' => 'Tuihnih rawh le',
	'article-comments-cancel' => 'Sûtna',
	'article-comments-delete' => 'paihna',
	'article-comments-edit' => 'siamţhatna',
	'article-comments-history' => 'chanchin',
	'article-comments-error' => 'I tuihnihna a dahţhat theih loh tlat',
	'article-comments-rc-comment' => 'Thuziak tuihnihna (<span class="plainlinks"> [$1 $2]</span>', # Fuzzy
	'article-comments-rc-comments' => 'Thuziak tuihnihna ([[$1]])',
];

/** Latvian (latviešu)
 * @author Papuass
 * @author Sg ghost
 * @author Srolanh
 */
$messages['lv'] = [
	'article-comments-file-page' => "[[$1|Komentārs no $2]] par [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Komentārs no $2 ]] , [[$3| $4 ]] post par [[$5|  $6 ir]] blog",
	'article-comments-anonymous' => 'Anonīms lietotājs',
	'article-comments-comments' => 'Komentāri ( $1 )',
	'article-comments-post' => 'Publicēt komentāru',
	'article-comments-cancel' => 'Atcelt',
	'article-comments-delete' => 'dzēst',
	'article-comments-edit' => 'labot',
	'article-comments-history' => 'vēsture',
	'article-comments-error' => 'Komentēt nevar saglabāt',
	'article-comments-undeleted-comment' => 'Dzēšana komentārs blogu lapā $1',
	'article-comments-rc-comment' => 'Panta komentārs (<span class="plainlinks">[$1 $2] </span>)',
	'article-comments-rc-comments' => 'Panta Komentāri ([[$1]])',
	'article-comments-fblogin' => 'Lūdzu <a href="<span class=" notranslate"="" translate="no">$1" rel ="nofollow"> pieteikties un izveidot savienojumu ar Facebook</a> post komentāru par šo wiki!',
	'article-comments-fbconnect' => 'Lūdzu <a href="<span class=" notranslate"="" translate="no">$1"> šī konta savienojumu ar Facebook</a> komentārus!',
	'article-comments-rc-blog-comment' => 'Panta komentārs (<span class="plainlinks">[$1 $2] </span>)',
	'article-comments-rc-blog-comments' => 'Blog komentārus ([[$1]])',
	'article-comments-login' => 'Lūdzu [[Special:UserLogin|pieteikties]] post komentāru par šo viki.',
	'article-comments-toc-item' => 'Komentāri',
	'article-comments-comment-cannot-add' => 'Nevar pievienot komentāru rakstu.',
	'article-comments-vote' => 'Balsot līdz',
	'article-comments-reply' => 'Atbildēt',
	'article-comments-show-all' => 'Apskatīt visus komentārus',
	'article-comments-prev-page' => 'Iepr',
	'article-comments-next-page' => 'Nākamais',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Mātes raksts / mātes komentārs ir izdzēsts.',
	'article-comments-empty-comment' => "Jūs nevarat ievietot tukšu komentāru. [$1 Dzēst tā vietā?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Komentārs|Komentāri}}',
	'wikiamobile-article-comments-header' => 'Komentāri',
	'wikiamobile-article-comments-more' => 'Ielādēt vairāk',
	'wikiamobile-article-comments-prev' => 'Ielādētu iepriekšēja',
	'wikiamobile-article-comments-none' => 'Nav komentāru',
	'wikiamobile-article-comments-view' => 'Apskatīt atbildes',
	'wikiamobile-article-comments-replies' => 'atbildes',
	'wikiamobile-article-comments-post-reply' => 'Publicēt atbildi',
	'wikiamobile-article-comments-post' => 'Publicēt',
	'wikiamobile-article-comments-placeholder' => 'Publicēt komentāru',
	'wikiamobile-article-comments-login-post' => 'Lūdzu, piesakieties lai ievietotu komentāru.',
	'wikiamobile-article-comments-post-fail' => 'Neizdevās saglabāt komentāru, lūdzu, mēģiniet vēlreiz vēlāk',
	'enotif_subject_article_comment' => '$PAGEEDITOR komentēja ir "$PAGETITLE" uz {{SITENAME}}',
	'enotif_body_article_comment' => 'Hi $WATCHINGUSERNAME,

Nav jaunu komentāru pie $PAGETITLE par {{SITENAME}}. Izmantojiet šīs saites, lai redzētu visus komentāri: $PAGETITLE_URL#WikiaArticleComments

- Vikija Kopienas

 ______________________
* Atrast palīdzību un konsultācijas par Kopienas Centrālās: http://community.wikia.com
* Vēlos saņemt mazāk ziņu no mums? Jūs varat atsaukt vai mainīt savu e-pasta preferences šeit: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hi $WATCHINGUSERNAME,
<br /><br />
Nav jaunu komentāru pie $PAGETITLE par {{SITENAME}}. Izmantojiet šīs saites, lai redzētu visus komentāri: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Vikija Kopienas
<br /><br />
 ______________________
<ul>
<li>Atrast palīdzību un konsultācijas par Kopienas Centrālās: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>vai Vēlaties saņemt mazāk ziņu no mums? Jūs varat atsaukt vai mainīt savu e-pasta preferences šeit: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = [
	'article-comments-file-page' => "[[$1|Komentar sekang $2]] nang [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Komentar sekang $2]] nang [[$3|$4]] sing diposting nang blog [[$5|$6's]]",
	'article-comments-anonymous' => 'Panganggo anonim',
	'article-comments-comments' => 'Komentar ($1)',
	'article-comments-post' => 'Ngirimna komentar',
	'article-comments-cancel' => 'Batalna',
	'article-comments-delete' => 'busek',
	'article-comments-edit' => 'nyunting',
	'article-comments-history' => 'riwayat',
	'article-comments-error' => 'Komentar ora teyeng disimpen',
	'article-comments-undeleted-comment' => 'Mbatalna komentar kanggo kaca blog $1',
	'article-comments-rc-comment' => 'Komentar artikel (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Komentar artikel ([[$1]])',
	'article-comments-fblogin' => 'Monggo <a href="$1" rel="nofollow">mlebu log lan nyambung nganggo Facebook</a> kanggo ngirimna komentar nang wiki kiye!',
	'article-comments-fbconnect' => 'Monggo <a href="$1">nyambungna akun kiye karo Facebook</a> kanggo kirim komentar!',
	'article-comments-rc-blog-comment' => 'Komentar blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Komentar blog ([[$1]])',
	'article-comments-login' => 'Monggo [[Special:UserLogin|mlebu log]] kanggo ngirimna komentar nang wiki kiye.',
	'article-comments-toc-item' => 'Komentar',
	'article-comments-comment-cannot-add' => 'Rika ora teyeng nambahna komentar maring artikel.',
	'article-comments-vote' => 'Aweh swara',
	'article-comments-reply' => 'Bales',
	'article-comments-show-all' => 'Tidokna kabeh komentar',
	'article-comments-prev-page' => 'Sedurunge',
	'article-comments-next-page' => 'Seuwise',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Artikel induk/komentar induk uwis dibusek.',
	'article-comments-empty-comment' => "Rika ora teyeng ngirimna komentar kosong. [$1 Arep dibusek baen?]",
	'wikiamobile-article-comments-header' => 'komentar',
];

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = [
	'article-comments-desc' => 'Коментари за статии на викистраници',
	'article-comments-file-page' => "[[$1|Коментар од $2]] на [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Коментар од $2]] на објава од [[$3|$4]] на блогот на [[$5|$6]]",
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
	'article-comments-login' => '[[Special:UserLogin|Најавете се]] за да коментирате на ова вики.',
	'article-comments-toc-item' => 'Коментари',
	'article-comments-comment-cannot-add' => 'Не можете да додавате комнтари во статијата.',
	'article-comments-vote' => 'Гласај „За“',
	'article-comments-reply' => 'Одговори',
	'article-comments-show-all' => 'Сите коментари',
	'article-comments-prev-page' => 'Претходна',
	'article-comments-next-page' => 'Следна',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Матичната статија / матичниот коментар е избришан.',
	'article-comments-empty-comment' => "Не можете да објавите празен коментар. [$1 Да го избришам?]",
	'article-comments-show-more' => 'Дај уште коментари',
	'wikiamobile-article-comments-counter' => '{{PLURAL:$1|Еден коментар|$1 коментари}}',
	'wikiamobile-article-comments-header' => 'коментари',
	'wikiamobile-article-comments-more' => 'Вчитај уште',
	'wikiamobile-article-comments-prev' => 'Вчитај претходни',
	'wikiamobile-article-comments-none' => 'Нема коментари',
	'wikiamobile-article-comments-view' => 'Погл. одговори',
	'wikiamobile-article-comments-replies' => 'одговори',
	'wikiamobile-article-comments-post-reply' => 'Дајте одговор',
	'wikiamobile-article-comments-post' => 'Објави',
	'wikiamobile-article-comments-placeholder' => 'Објави коментар',
	'wikiamobile-article-comments-login-post' => 'Најавете се за да можете да коментирате.',
	'wikiamobile-article-comments-post-fail' => 'Не успеав да го зачувам коментарот. Обидете се подоцна.',
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
];

/** Malayalam (മലയാളം)
 * @author Kavya Manohar
 * @author Praveenp
 */
$messages['ml'] = [
	'article-comments-anonymous' => 'അജ്ഞാത ഉപയോക്താവ്',
	'article-comments-comments' => 'അഭിപ്രായങ്ങൾ ($1)',
	'article-comments-post' => 'അഭിപ്രായം പ്രസിദ്ധീകരിക്കുക',
	'article-comments-cancel' => 'റദ്ദാക്കുക',
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
];

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = [
	'article-comments-anonymous' => 'अनामिक सदस्य',
	'article-comments-comments' => 'टिप्पण्या ($1)',
	'article-comments-cancel' => 'रद्द करा',
	'article-comments-delete' => 'वगळा',
	'article-comments-edit' => 'संपादन करा',
	'article-comments-history' => 'इतिहास',
	'article-comments-error' => 'टिप्पण्या जतन करता आल्या नाहीत',
	'article-comments-toc-item' => 'आभिप्राय',
	'article-comments-comment-cannot-add' => 'या लेखात आपण टिप्पणी जोडू शकत नाही.',
	'article-comments-reply' => 'उत्तर',
	'article-comments-show-all' => 'सर्व अभिप्राय दाखवा',
	'article-comments-prev-page' => 'मागील',
	'article-comments-next-page' => 'पुढील',
	'wikiamobile-article-comments-header' => 'शेरे',
	'wikiamobile-article-comments-more' => 'अधिक प्रभारण करा',
	'wikiamobile-article-comments-prev' => 'मागील प्रभारण',
	'wikiamobile-article-comments-none' => 'अभिप्राय नाहीत',
	'wikiamobile-article-comments-view' => 'उत्तरे दर्शवा',
	'wikiamobile-article-comments-replies' => 'उत्तरे',
];

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = [
	'article-comments-desc' => 'Komen rencana untuk laman wiki',
	'article-comments-file-page' => "[[$1|Ulasan oleh $2]] di [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Ulasan oleh $2]] pada pos [[$3|$4]] di blog [[$5|$6]]",
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
	'article-comments-login' => 'Sila [[Special:UserLogin|log masuk]] untuk mengirim ulasan di wiki ini.',
	'article-comments-toc-item' => 'Ulasan',
	'article-comments-comment-cannot-add' => 'Anda tidak boleh mengirim ulasan kepada rencana ini.',
	'article-comments-vote' => 'Undi setuju',
	'article-comments-reply' => 'Balas',
	'article-comments-show-all' => 'Tunjukkan semua ulasan',
	'article-comments-prev-page' => 'Sebelumnya',
	'article-comments-next-page' => 'Seterusnya',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Rencana induk / ulasan induk telah dihapuskan.',
	'article-comments-empty-comment' => "Anda tidak boleh mengirim ulasan kososng. [$1 Nak padamkan atau tak?]",
	'article-comments-show-more' => 'Paparkan lebih banyak komen',
	'wikiamobile-article-comments-counter' => '$1 Komen',
	'wikiamobile-article-comments-header' => 'komen',
	'wikiamobile-article-comments-more' => 'Muatkan yang selanjutnya',
	'wikiamobile-article-comments-prev' => 'Muatkan yang sebelumnya',
	'wikiamobile-article-comments-none' => 'Tiada komen',
	'wikiamobile-article-comments-view' => 'Baca balasan',
	'wikiamobile-article-comments-replies' => 'balasan',
	'wikiamobile-article-comments-post-reply' => 'Balas',
	'wikiamobile-article-comments-post' => 'Hantar',
	'wikiamobile-article-comments-placeholder' => 'Hantar ulasan',
	'wikiamobile-article-comments-login-post' => 'Sila log masuk untuk berkomen.',
	'wikiamobile-article-comments-post-fail' => 'Komen tidak dapat disimpan; sila cuba lagi nanti',
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
];

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = [
	'article-comments-file-page' => "[[$1|Kumment minn $2]] fuq [[$3]]",
	'article-comments-anonymous' => 'Utent anonimu',
	'article-comments-comments' => 'Kummenti ($1)',
	'article-comments-post' => 'Ħalli kumment',
	'article-comments-cancel' => 'Ikkanċella',
	'article-comments-delete' => 'ħassar',
	'article-comments-edit' => 'editja',
	'article-comments-history' => 'kronoloġija',
	'article-comments-error' => 'Il-kumment ma setax jiġi ssejvjat',
	'article-comments-rc-comments' => 'Kummenti tal-artiklu ([[$1]])',
	'article-comments-fblogin' => 'Jekk jogħġbok <a href="$1" rel="nofollow">idħol bil-Facebook</a> sabiex tibgħat kumment fuq din il-wiki!',
	'article-comments-fbconnect' => 'jekk jogġbok <a href="$1">qabbad dan il-kont mal-Facebook</a> sabiex tikkummenta!',
	'article-comments-rc-blog-comment' => 'Kumment tal-blogg (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Kummenti tal-blogg ([[$1]])',
	'article-comments-login' => 'Jekk jogħġbok [[Special:UserLogin|idħol]] sabiex tibgħat kumment fuq din il-wiki.',
	'article-comments-toc-item' => 'Kummenti',
	'article-comments-comment-cannot-add' => 'Ma tistax iżżid kumment lill-artiklu.',
	'article-comments-vote' => 'Ivvota',
	'article-comments-reply' => 'Irrispondi',
	'article-comments-show-all' => 'Uri l-kummenti kollha',
	'article-comments-prev-page' => "Ta' qabel",
	'article-comments-next-page' => 'Li jmiss',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-empty-comment' => "Ma tistax tibgħat kumment vojt. [$1 Trid tħassru minflok?]",
	'wikiamobile-article-comments-header' => 'kummenti',
	'wikiamobile-article-comments-more' => "Tella' iktar",
	'wikiamobile-article-comments-prev' => "Tella' ta' qabel",
	'wikiamobile-article-comments-none' => 'L-ebda kumment',
	'wikiamobile-article-comments-view' => 'Ara r-risposti',
	'wikiamobile-article-comments-replies' => 'risposti',
	'wikiamobile-article-comments-post-reply' => 'Ibgħat risposta',
	'wikiamobile-article-comments-placeholder' => 'Ibgħat kumment',
	'wikiamobile-article-comments-login-post' => 'Jekk jogħġbok idħol fil-kont sabiex tikkummenta.',
	'wikiamobile-article-comments-post-fail' => "Il-kumment ma setax jiġi ssejvjat, jekk jogħġbok erġa' pprova",
	'enotif_subject_article_comment' => '$PAGEEDITOR ħalla kumment fuq "$PAGETITLE" fuq {{SITENAME}}',
];

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = [
	'article-comments-edit' => 'دچی‌ین',
	'article-comments-history' => 'تاریخچه',
	'article-comments-undeleted-comment' => 'نظر صفحۀ وبلاگ $1 وسّه احیاء بیّه',
];

/** Min Nan Chinese (Bân-lâm-gú)
 * @author Ianbu
 */
$messages['nan'] = [
	'article-comments-file-page' => "由 $2]] 佇 [[$3]] 發表的[[$1|評論",
	'article-blog-comments-file-page' => "佇[[$5|$6]]部落格的文章[[$3|$4]]有[[$1|來自$2的評論]]。",
	'article-comments-anonymous' => '無名氏用者',
	'article-comments-comments' => '評論 ( $1 )',
	'article-comments-post' => '發表評論',
	'article-comments-cancel' => '取消',
	'article-comments-delete' => '刣掉',
	'article-comments-edit' => 'siu-kái',
	'article-comments-history' => 'Le̍k-sú',
	'article-comments-error' => '無法保存評論',
	'article-comments-undeleted-comment' => '恢復部落格文章 $1 的評論',
	'article-comments-rc-comment' => '文章評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => '文章評論 ([[$1]])',
	'article-comments-fblogin' => '請 <a href="$1" rel="nofollow">登入，並且連接Facebook</a> 來這个wiki發表評論',
	'article-comments-fbconnect' => '請 <a href="$1">先共這个口座佮Facebook連結</a>，才來評論',
	'article-comments-rc-blog-comment' => '部落格評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '部落格評論([[$1]])',
	'article-comments-login' => '請先 [[Special:UserLogin|登入]]，才通佇這个wiki貼評論。',
	'article-comments-toc-item' => '評論',
	'article-comments-comment-cannot-add' => '你袂當佇這篇文章加評論。',
	'article-comments-vote' => '參加投票',
	'article-comments-reply' => '回覆',
	'article-comments-show-all' => '顯示所有的評論',
	'article-comments-prev-page' => 'chêng',
	'article-comments-next-page' => 'ē 1 ê',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '原條目/原評論已經予儂刣掉。',
	'article-comments-empty-comment' => "你袂當發佈空的評論。[$1 敢欲刣掉？]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|評論}}',
	'wikiamobile-article-comments-header' => '評論',
	'wikiamobile-article-comments-more' => '載較濟咧',
	'wikiamobile-article-comments-prev' => '載頭前的',
	'wikiamobile-article-comments-none' => '無儂評論',
	'wikiamobile-article-comments-view' => '看回覆',
	'wikiamobile-article-comments-replies' => '回覆',
	'wikiamobile-article-comments-post-reply' => '貼回覆',
	'wikiamobile-article-comments-post' => '貼',
	'wikiamobile-article-comments-placeholder' => '發表評論',
	'wikiamobile-article-comments-login-post' => '請登入了後，才發表評論。',
	'wikiamobile-article-comments-post-fail' => '保存評論失敗，請等一下才閣試',
	'enotif_subject_article_comment' => '$PAGEEDITOR 佇 {{SITENAME}}的文章 "$PAGETITLE"內底發表評論',
];

/** Neapolitan (Napulitano)
 * @author C.R.
 */
$messages['nap'] = [
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Commento|Cummente}}',
];

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Danmichaelo
 * @author Event
 * @author Laaknor
 */
$messages['nb'] = [
	'article-comments-file-page' => "[[$1|Kommentarer fra $2]] på [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Kommentar fra $2]] den [[$3|$4]] som innlegg på [[$5|$6s]] blogg",
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
	'article-comments-login' => 'Vennligst [[Special:UserLogin|logg inn]] for å kommentere på denne wikien.',
	'article-comments-toc-item' => 'Kommentarer',
	'article-comments-comment-cannot-add' => 'Du kan ikke legge en kommentar til artikkelen.',
	'article-comments-vote' => 'Stem opp',
	'article-comments-reply' => 'Svar',
	'article-comments-show-all' => 'Vis alle kommentarer',
	'article-comments-prev-page' => 'Forrige',
	'article-comments-next-page' => 'Neste',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Overordnet artikkel/overordnet kommentar har blitt slettet.',
	'article-comments-empty-comment' => "Du kan ikke poste en tom kommentar. [$1 Slette den istedenfor?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|kommentar|kommentarer}}',
	'wikiamobile-article-comments-header' => 'kommentarer',
	'wikiamobile-article-comments-more' => 'Last inn mer',
	'wikiamobile-article-comments-prev' => 'Last forrige',
	'wikiamobile-article-comments-none' => 'Ingen kommentarer',
	'wikiamobile-article-comments-view' => 'Vis svar',
	'wikiamobile-article-comments-replies' => 'svar',
	'wikiamobile-article-comments-post-reply' => 'Post et svar',
	'wikiamobile-article-comments-post' => 'Post',
	'wikiamobile-article-comments-placeholder' => 'Post en kommentar',
	'wikiamobile-article-comments-login-post' => 'Vennligst logg inn for å poste en kommentar.',
	'wikiamobile-article-comments-post-fail' => 'Feilet lagring av kommentar, prøv igjen senere',
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
];

/** Nepali (नेपाली)
 * @author सरोज कुमार ढकाल
 */
$messages['ne'] = [
	'article-comments-anonymous' => 'अज्ञात  प्रयोगकर्ता',
	'article-comments-comments' => 'टिप्पणीहरू ($1)',
	'article-comments-post' => 'टिप्पणी पोष्ट गर्ने',
	'article-comments-cancel' => 'रद्द',
	'article-comments-delete' => 'मेट्ने',
	'article-comments-edit' => 'सम्पादन गर्ने',
	'article-comments-history' => 'इतिहास',
	'article-comments-error' => 'टिप्पणी सङ्ग्रह गर्न सकिएन',
	'article-comments-reply' => 'जवाफ दिने',
	'article-comments-show-all' => 'सबै टिप्पणीहरू देखाउने',
	'article-comments-prev-page' => 'अघिल्लो',
	'article-comments-next-page' => 'अर्को',
	'wikiamobile-article-comments-header' => 'टिप्पणीहरु',
	'wikiamobile-article-comments-more' => 'थप पढ्ने',
	'wikiamobile-article-comments-prev' => 'पहिलेको खोल्नुहोस्',
	'wikiamobile-article-comments-none' => 'कुनै पनि टिप्पणीहरू छैनन्',
	'wikiamobile-article-comments-view' => 'जवाफहरू हेर्ने',
	'wikiamobile-article-comments-replies' => 'उत्तरहरु',
	'wikiamobile-article-comments-post-reply' => 'उत्तर दिने',
	'wikiamobile-article-comments-post' => 'पोष्ट',
	'wikiamobile-article-comments-placeholder' => 'टिप्पणी पोष्ट गर्ने',
];

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = [
	'article-comments-file-page' => "[[$1|Reactie van $2]] op [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Reactie van $2]] op bericht [[$3|$4]] op het blog van [[$5|$6]]",
	'article-comments-anonymous' => 'Anonieme gebruiker',
	'article-comments-comments' => 'Opmerkingen ($1)',
	'article-comments-post' => 'Reactie plaatsen',
	'article-comments-cancel' => 'Annuleren',
	'article-comments-delete' => 'verwijderen',
	'article-comments-edit' => 'bewerken',
	'article-comments-history' => 'geschiedenis',
	'article-comments-error' => 'De reactie kon niet worden opgeslagen',
	'article-comments-undeleted-comment' => 'Reactie teruggeplaatst op blogpagina $1',
	'article-comments-rc-comment' => 'Reactie bij pagina (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Opmerkingen bij pagina ([[$1]])',
	'article-comments-fblogin' => '<a href="$1">Meld u aan en verbind met Facebook</a> om een opmerking in deze wiki te plaatsen.',
	'article-comments-fbconnect' => '<a href="$1">Verbind deze gebruiker met Facebook</a> om opmerkingen te plaatsen.',
	'article-comments-rc-blog-comment' => 'Reactie bij blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Opmerkingen bij blog ([[$1]])',
	'article-comments-login' => '[[Special:UserLogin|Meld u aan]] om een opmerking in deze wiki te kunnen plaatsen.',
	'article-comments-toc-item' => 'Opmerkingen',
	'article-comments-comment-cannot-add' => 'U kunt geen opmerkingen bij de pagina plaatsen.',
	'article-comments-vote' => 'Positief beoordelen',
	'article-comments-reply' => 'Antwoorden',
	'article-comments-show-all' => 'Alle opmerkingen weergeven',
	'article-comments-prev-page' => 'Vorige',
	'article-comments-next-page' => 'Volgende',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'De bovenliggende pagina is verwijderd.',
	'article-comments-empty-comment' => "U kunt geen opmerking zonder inhoud plaatsen. [$1 In plaats daarvan verwijderen?]",
	'article-comments-show-more' => 'Meer reacties weergeven',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Reactie|Reacties}}',
	'wikiamobile-article-comments-header' => 'Reacties',
	'wikiamobile-article-comments-more' => 'Meer laden',
	'wikiamobile-article-comments-prev' => 'Vorige laden',
	'wikiamobile-article-comments-none' => 'Geen reacties',
	'wikiamobile-article-comments-view' => 'Antwoorden bekijken',
	'wikiamobile-article-comments-replies' => 'antwoorden',
	'wikiamobile-article-comments-post-reply' => 'Reactie plaatsen',
	'wikiamobile-article-comments-post' => 'Opslaan',
	'wikiamobile-article-comments-placeholder' => 'Reactie plaatsen',
	'wikiamobile-article-comments-login-post' => 'Meld u aan om te reageren.',
	'wikiamobile-article-comments-post-fail' => 'Het opslaan van de reactie is mislukt. Probeer het later opnieuw.',
	'enotif_subject_article_comment' => '$PAGEEDITOR heeft een opmerking geplaatst bij "$PAGETITLE" op {{SITENAME}}',
	'enotif_body_article_comment' => 'Hallo $WATCHINGUSERNAME,

Er is een nieuwe reactie bij $PAGETITLE op {{SITENAME}}. Gebruik de volgende koppeling om alle reacties te bekijken: $PAGETITLE_URL#WikiaArticleComments

- Wikia Community Support

___________________________________________
* Voor hulp en advies op Community Central gaat u naar http://community.wikia.com
* Wilt u minder berichten van ons ontvangen? Schrijf u dan uit of wijzig uw e-mailvoorkeuren: http://community.wikia.com/wiki/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hallo $WATCHINGUSERNAME,
<br /><br />
Er is een nieuwe reactie bij $PAGETITLE op {{SITENAME}}. Gebruik de volgende koppeling om alle reacties te bekijken: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia Community Support
<br /><br />
___________________________________________
<ul>
<li>Voor hulp en advies op Community Central gaat u naar <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Wilt u minder berichten van ons ontvangen? Schrijf u dan uit of wijzig uw e-mailvoorkeuren op <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = [
	'article-comments-comment-cannot-add' => 'Je kunt geen opmerkingen bij de pagina plaatsen.',
	'article-comments-empty-comment' => "Je kunt geen reactie zonder inhoud plaatsen. [$1 In plaats daarvan verwijderen?]",
	'enotif_body_article_comment-HTML' => '<p>Hoi $WATCHINGUSERNAME,
<br /><br />
Er is een nieuwe reactie bij $PAGETITLE op {{SITENAME}}. Gebruik de volgende koppeling om alle reacties te bekijken: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia Community Support
<br /><br />
___________________________________________
<ul>
<li>Voor hulp en advies op Community Central ga je naar <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Wil je minder berichten van ons ontvangen? Schrijf je dan uit of wijzig je e-mailvoorkeuren op <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = [
	'article-comments-file-page' => "[[$1|Comentari de $2]] a [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comentari de $2]] sus [[$3|$4]] publicat sul blog de [[$5|$6]]",
	'article-comments-anonymous' => 'Utilizaire anonim',
	'article-comments-comments' => 'Comentaris ($1)',
	'article-comments-post' => 'Apondre un comentari',
	'article-comments-cancel' => 'Anullar',
	'article-comments-delete' => 'suprimir',
	'article-comments-edit' => 'modificar',
	'article-comments-history' => 'istoric',
	'article-comments-error' => 'Lo comentari a pas pogut èsser enregistrat',
	'article-comments-undeleted-comment' => 'Comentari per la pagina de blog $1 restablit',
	'article-comments-rc-comment' => 'Comentari d\'article (<span class="plainlinks">[$1  $2]</span>)',
	'article-comments-rc-comments' => "Comentaris d'article ([[$1]])",
	'article-comments-rc-blog-comment' => 'Comentari de blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentaris de blog ([[$1]])',
	'article-comments-toc-item' => 'Comentaris',
	'article-comments-comment-cannot-add' => 'Podètz pas apondre cap de comentari a aqueste article.',
	'article-comments-vote' => 'Interessant',
	'article-comments-reply' => 'Respondre',
	'article-comments-show-all' => 'Afichar totes los comentaris',
	'article-comments-prev-page' => 'Precedent',
	'article-comments-next-page' => 'Seguent',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comentari|Comentaris}}',
	'wikiamobile-article-comments-header' => 'Comentaris',
	'wikiamobile-article-comments-more' => 'Legir la seguida',
	'wikiamobile-article-comments-prev' => 'Cargar lo precedent',
	'wikiamobile-article-comments-none' => 'Pas cap de comentari',
	'wikiamobile-article-comments-view' => 'Afichar las responsas',
	'wikiamobile-article-comments-replies' => 'responsas',
	'wikiamobile-article-comments-post-reply' => 'Mandar una responsa',
	'wikiamobile-article-comments-post' => 'Mandar',
	'wikiamobile-article-comments-placeholder' => 'Mandar un comentari',
	'wikiamobile-article-comments-login-post' => 'Connectatz-vos per postar un comentari.',
	'enotif_subject_article_comment' => '$PAGEEDITOR a comentat « $PAGETITLE » sus {{SITENAME}}',
];

/** Palatine German (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = [
	'article-comments-anonymous' => 'Uoagmeldede Benudza',
	'article-comments-cancel' => 'Uffhere',
	'article-comments-delete' => 'lesche',
	'article-comments-edit' => 'bearwaide',
	'article-comments-history' => 'Gschischd',
	'article-comments-reply' => 'Oandwoade',
];

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Devwebtel
 * @author Pio387
 * @author Sovq
 * @author VerMa
 * @author Wedkarski
 * @author Woytecr
 */
$messages['pl'] = [
	'article-comments-desc' => 'Komentarze dla stron na wiki',
	'article-comments-file-page' => "[[$1|Komentarz użytkownika $2]] w artykule [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Komentarz użytkownika $2]] we wpisie [[$3|$4]] na blogu użytkownika [[$5|$6]]",
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
	'article-comments-login' => '[[Special:UserLogin|Zaloguj się]], aby komentować na tej wiki.',
	'article-comments-toc-item' => 'Komentarze',
	'article-comments-comment-cannot-add' => 'Nie możesz dodać komentarza do tego artykułu',
	'article-comments-vote' => 'Zagłosuj',
	'article-comments-reply' => 'Odpowiedz',
	'article-comments-show-all' => 'Pokaż wszystkie komentarze',
	'article-comments-prev-page' => 'Poprzednia',
	'article-comments-next-page' => 'Następna',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Główny artykuł / komentarz został usunięty',
	'article-comments-empty-comment' => "Nie możesz zapisać pustego komentarza [$1 Usunąć?]",
	'article-comments-show-more' => 'Załaduj więcej komentarzy',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Komentarz|Komentarze|Komentarzy}}',
	'wikiamobile-article-comments-header' => 'Komentarze',
	'wikiamobile-article-comments-more' => 'Załaduj więcej',
	'wikiamobile-article-comments-prev' => 'Załaduj poprzednie',
	'wikiamobile-article-comments-none' => 'Brak komentarzy',
	'wikiamobile-article-comments-view' => 'Pokaż odpowiedzi',
	'wikiamobile-article-comments-replies' => 'odpowiedzi',
	'wikiamobile-article-comments-post-reply' => 'Publikuj odpowiedź',
	'wikiamobile-article-comments-post' => 'Publikuj',
	'wikiamobile-article-comments-placeholder' => 'Wyślij komentarz',
	'wikiamobile-article-comments-login-post' => 'Zaloguj się aby dodać komentarz.',
	'wikiamobile-article-comments-post-fail' => 'Nie udało się zapisać komentarza, spróbuj ponownie później',
	'enotif_subject_article_comment' => '$PAGEEDITOR skomentował "$PAGETITLE" na {{SITENAME}}',
	'enotif_body_article_comment' => 'Witaj $WATCHINGUSERNAME,

Na {{SITENAME}} pojawił się nowy komentarz na stronie $PAGETITLE. Użyj tego linku aby zobaczyć wszystkie komentarze: $PAGETITLE_URL#WikiaArticleComments

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
];

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = [
	'article-comments-file-page' => "[[$1|Coment da $2]] ai [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Coment da $2]] ai [[$3|$4]] spedì dzor lë scartari ëd [[$5|$6]]",
	'article-comments-anonymous' => 'Utent anònim',
	'article-comments-comments' => 'Coment ($1)',
	'article-comments-post' => "Coment a l'artìcol",
	'article-comments-cancel' => 'Scancela',
	'article-comments-delete' => 'scancelé',
	'article-comments-edit' => 'modìfica',
	'article-comments-history' => 'stòria',
	'article-comments-error' => "Ël coment a l'ha pa podù esse salvà",
	'article-comments-undeleted-comment' => 'Coment ripristinà për pàgina dë scartari $1',
	'article-comments-rc-comment' => 'Coment d\'artìcol (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => "Coment d'artìcol ([[$1]])",
	'article-comments-fblogin' => 'Për piasì, ch\'a <a href="$1" rel="nofollow">intra ant ël sistema e ch\'as colega a Facebook</a> për mandé un coment dzora sta wiki!',
	'article-comments-fbconnect' => 'Për piasì <a href="$1">colega sto cont con Facebook</a> për comenté!',
	'article-comments-rc-blog-comment' => 'Coment dë scartari (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Coment dë scartari ([[$1]])',
	'article-comments-login' => 'Për piasì, ch\'a [[Special:UserLogin|intra ant ël sistema]] për mandé un coment dzora sta wiki.',
	'article-comments-toc-item' => 'Coment',
	'article-comments-comment-cannot-add' => 'It peule pa gionté un coment a la vos.',
	'article-comments-vote' => 'Anteressant',
	'article-comments-reply' => 'Rësponde',
	'article-comments-show-all' => 'Smon-e tùit ij coment',
	'article-comments-prev-page' => 'Andaré',
	'article-comments-next-page' => 'Apress',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => "L'artìcol pare o ël coment pare a l'é stàit ësganfà.",
	'article-comments-empty-comment' => "A peul pa mandé un coment veuid. [$1 Sganfelo, pitòst?]",
	'wikiamobile-article-comments-header' => 'coment',
	'wikiamobile-article-comments-more' => "Caria anco'",
	'wikiamobile-article-comments-prev' => 'Carié ël precedent',
	'wikiamobile-article-comments-none' => 'Gnun coment',
	'wikiamobile-article-comments-view' => 'Smon-e le rispòste',
	'wikiamobile-article-comments-replies' => 'rispòste',
	'wikiamobile-article-comments-post-reply' => 'Mandé na rispòsta',
	'wikiamobile-article-comments-post' => 'Spediss',
	'wikiamobile-article-comments-placeholder' => 'Manda un coment',
	'wikiamobile-article-comments-login-post' => "Për piasì, ch'a intra ant ël sistema për mandé un coment.",
	'wikiamobile-article-comments-post-fail' => 'Falì a salvé un coment, për piasì preuva torna pi tard',
	'enotif_subject_article_comment' => '$PAGEEDITOR a l\'ha comentà dzor "$PAGETITLE" dzor {{SITENAME}}',
	'enotif_body_article_comment' => "Cerea \$WATCHINGUSERNAME,

A-i é un neuv coment a \$PAGETITLE dzora {{SITENAME}}. Ch'a deuvra sa liura për vëdde tùit ij coment:
\$PAGETITLE_URL#WikiaArticleComments

- L'echip d'agiut ëd la Comunità Wikia

___________________________________________
* Ch'a truva d'agiut e 'd consèj a la sentral dla comunità: http://community.wikia.com
* Veul-lo arsèive men ëd mëssagi da noi? A peul disabonesse o modifiché ij sò gust ëd pòsta eletrònica ambelessì: http://community.wikia.com/Special:Preferences",
	'enotif_body_article_comment-HTML' => '<p>Cerea $WATCHINGUSERNAME,
<br /><br />
A-i é un neuv coment a $PAGETITLE dzora {{SITENAME}}. Ch\'a deuvra sa liura për vëdde tùit ij coment:
<br /><br />
- Echip d\'agiut ëd la Comunità Wikia
<br /><br />
___________________________________________
<ul>
<li>Ch\'a treuva d\'agiut e ëd consèj a la sentral dla comunità: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Veul-lo arsèive men mëssagi da noi? A peul ëscancelé l\'abonament o modifiché ij sò gust ëd pòsta eletrònica ambelessì: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = [
	'article-comments-desc' => 'د ويکي مخونو لپاره د ليکنې تبصرې',
	'article-comments-file-page' => "په [[$3]][[$1|تبصره د $2 لخوا]]",
	'article-blog-comments-file-page' => "[[$1|د $2 لخوا تبصره]] په [[$3|$4]] ليکنې [[$5|$6's]] بلاگ",
	'article-comments-anonymous' => 'ورکنومی کارن',
	'article-comments-comments' => 'تبصرې ($1)',
	'article-comments-post' => 'تبصره کول',
	'article-comments-cancel' => 'ناگارل',
	'article-comments-delete' => 'ړنگول',
	'article-comments-edit' => 'سمول',
	'article-comments-history' => 'پېښليک',
	'article-comments-error' => 'تبصره مو نه شي خوندي کېدلی',
	'article-comments-rc-comments' => 'د ليکنې تبصرې ([[$1]])',
	'article-comments-rc-blog-comment' => 'بلاگ تبصره (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'د بلاگ تبصرې ([[$1]])',
	'article-comments-login' => 'دلته د يوې تبصرې د خپرولو لپاره لطفاً [[Special:UserLogin|غونډال ته ننوځۍ]].',
	'article-comments-toc-item' => 'تبصرې',
	'article-comments-comment-cannot-add' => 'تاسې دې ليکنه کې يوه تبصره نه شی ورگډولی.',
	'article-comments-vote' => 'مثبته رايه',
	'article-comments-reply' => 'ځوابول',
	'article-comments-show-all' => 'ټولې تبصرې ښکاره کول',
	'article-comments-prev-page' => 'پخوانی',
	'article-comments-next-page' => 'راتلونکی',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-show-more' => 'نورې تبصرې ښکاره کول',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|تبصره|تبصرې}}',
	'wikiamobile-article-comments-header' => 'تبصرې',
	'wikiamobile-article-comments-more' => 'نور برسېرول',
	'wikiamobile-article-comments-prev' => 'پخوانی برسېرول',
	'wikiamobile-article-comments-none' => 'بې تبصرې',
	'wikiamobile-article-comments-view' => 'ځوابونه کتل',
	'wikiamobile-article-comments-replies' => 'ځوابونه',
	'wikiamobile-article-comments-post-reply' => 'يو ځواب ورکول',
	'wikiamobile-article-comments-placeholder' => 'يوه تبصره ليکل',
	'wikiamobile-article-comments-login-post' => 'د يوې تبصرې د ليکلو لپاره لطفاً غونډال ته ننوځۍ.',
];

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Leon saudanha
 * @author Malafaya
 * @author Pttraduc
 * @author SandroHc
 * @author Vitorvicentevalente
 * @author Waldir
 */
$messages['pt'] = [
	'article-comments-file-page' => "[[$1|Comentário de $2]] em [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comentar do  $2  ]] na [[$3| $4 ]] post sobre [[$5|  $6 do]] blog",
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
	'article-comments-rc-blog-comment' => 'Comentário de blogue (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Comentários de blogue ([[$1]])',
	'article-comments-login' => 'Por favor, [[Special:UserLogin|autentique-se]] para publicar um comentário nesta wiki.',
	'article-comments-toc-item' => 'Comentários',
	'article-comments-comment-cannot-add' => 'Não pode adicionar um comentário ao artigo.',
	'article-comments-vote' => 'Voto positivo',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos os comentários',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Próximo',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'O artigo raiz / comentário raiz foi apagado.',
	'article-comments-empty-comment' => "Não pode publicar um comentário vazio. [$1 Quer apagá-lo?]",
	'article-comments-show-more' => 'Mostrar mais comentários',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comentário|Comentários}}',
	'wikiamobile-article-comments-header' => 'comentários',
	'wikiamobile-article-comments-more' => 'Ler mais',
	'wikiamobile-article-comments-prev' => 'Ler anteriores',
	'wikiamobile-article-comments-none' => 'Sem comentários',
	'wikiamobile-article-comments-view' => 'Ver respostas',
	'wikiamobile-article-comments-replies' => 'respostas',
	'wikiamobile-article-comments-post-reply' => 'Publicar uma resposta',
	'wikiamobile-article-comments-post' => 'Publicar',
	'wikiamobile-article-comments-placeholder' => 'Publicar um comentário',
	'wikiamobile-article-comments-login-post' => 'Inicie sessão antes de publicar um comentário.',
	'wikiamobile-article-comments-post-fail' => 'Falha ao gravar o comentário, tente novamente mais tarde, por favor',
	'enotif_subject_article_comment' => '$PAGEEDITOR comentou "$PAGETITLE" na {{SITENAME}}',
	'enotif_body_article_comment' => 'Olá $WATCHINGUSERNAME,

Há um comentário novo em $PAGETITLE na {{SITENAME}}. Use este link para ver todos os comentários: $PAGETITLE_URL#WikiaArticleComments

- Apoio da Comunidade Wikia

___________________________________________
* Encontra ajuda e conselhos na Central da Comunidade: http://community.wikia.com
* Quer receber menos mensagens nossas? Pode alterar as suas preferências de mensagens aqui: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p> Olá $ WATCHINGUSERNAME,
<br /> <br />
Há um novo comentário em US $ PAGETITLE em {{SITENAME}}. Use este link para ver todos os comentários: $ PAGETITLE_URL # WikiaArticleComments
<br /> <br />
- Suporte Comunidade Wikia 
<br /> <br />
___________________________________________
<ul>
<li> Procure ajuda e aconselhamento sobre a Comunidade Central: <a href="http://community.wikia.com"> http://community.wikia.com </ a> <li>
<li> Quer receber menos mensagens de nós? Você pode cancelar ou alterar suas preferências de e-mail aqui: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ ul>
</ p>',
];

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Caio1478
 * @author Fasouzafreitas
 * @author Guilhermemau
 * @author JM Pessanha
 * @author Luckas
 * @author Luckas Blade
 * @author TheGabrielZaum
 */
$messages['pt-br'] = [
	'article-comments-desc' => 'Comentários de artigos para páginas wiki',
	'article-comments-file-page' => "[[$1|Comentário de $2]] em [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Comentário de $2]] na publicação [[$3|$4]] do blog [[$5| $6's]]",
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
	'article-comments-login' => 'Por favor, [[Special:UserLogin|efetue o login]] para postar um comentário sobre este wiki.',
	'article-comments-toc-item' => 'Comentários',
	'article-comments-comment-cannot-add' => 'Você não pode adicionar um comentário ao artigo.',
	'article-comments-vote' => 'Votar',
	'article-comments-reply' => 'Responder',
	'article-comments-show-all' => 'Mostrar todos os comentários',
	'article-comments-prev-page' => 'Anterior',
	'article-comments-next-page' => 'Próximo',
	'article-comments-page-spacer' => '& # 160...&#160',
	'article-comments-delete-reason' => 'O artigo raiz / comentário raiz foi deletado.',
	'article-comments-empty-comment' => 'Você não pode postar um comentário vazio. [$1 Excluí-lo em vez disso?]',
	'article-comments-show-more' => 'Mostrar mais comentários',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comentário|Comentários}}',
	'wikiamobile-article-comments-header' => 'Comentários',
	'wikiamobile-article-comments-more' => 'Carregar mais',
	'wikiamobile-article-comments-prev' => 'Carregar o anterior',
	'wikiamobile-article-comments-none' => 'Sem comentários',
	'wikiamobile-article-comments-view' => 'Ver respostas',
	'wikiamobile-article-comments-replies' => 'respostas',
	'wikiamobile-article-comments-post-reply' => 'Postar uma resposta',
	'wikiamobile-article-comments-post' => 'Postar',
	'wikiamobile-article-comments-placeholder' => 'Postar um comentário',
	'wikiamobile-article-comments-login-post' => 'Autentifique-se para postar um comentário.',
	'wikiamobile-article-comments-post-fail' => 'Falha ao salvar o comentário, por favor, tente novamente mais tarde',
	'enotif_subject_article_comment' => 'Comentou sobre "$ PAGETITLE" em {{SITENAME}} $PAGEEDITOR',
	'enotif_body_article_comment' => 'Olá $ WATCHINGUSERNAME,

Há um novo comentário em $PAGETITLE no {{SITENAME}}. Use esse link para ver todos os comentários: $PAGETITLE_URL#WikiaArticleComments

- Suporte da Comunidade da Wikia

___________________________________________
* Encontre ajuda e conselhos na Central da Comunidade: http://comunidade.wikia.com
* Quer receber menos mensagens de nós? Você pode cancelar a inscrição ou alterar suas preferências de e-mail aqui: http://comunidade.wikia.com/Especial:Preferências',
	'enotif_body_article_comment-HTML' => '<p>Olá $ WATCHINGUSERNAME,
<br /><br />
Há um novo comentário em $PAGETITLE no {{SITENAME}}. Use esse link para ver todos os comentários: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Suporte da Comunidade Wikia
<br /><br />
___________________________________________
<ul>
<li>Encontre ajuda e conselhos na Central da Comunidade: http://comunidade.wikia.com</a><li>
<li>Quer receber menos mensagens de nós? Você pode cancelar a inscrição ou alterar suas preferências de e-mail aqui: <a href="http://comunidade.wikia.com/Especial:Preferências">http://comunidade.wikia.com/Especial:Preferências</a></li>
</ul>
</p>',
];

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = [
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
	'article-comments-empty-comment' => "Nu poţi posta un comentariu gol. [$1 Îl ştergi, în schimb?]",
];

/** tarandíne (tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = [
	'article-comments-desc' => "Commende d'a vôsce pe le pàggene uicchi",
	'article-comments-file-page' => "[[$1|Commende da $2]] sus a [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Commende da $2]] sus a [[$3|$4]] mannate sus a 'u blog [[$5|$6's]]",
	'article-comments-anonymous' => 'Utinde anonime',
	'article-comments-comments' => 'Commende $1',
	'article-comments-post' => "Mitte 'nu commende",
	'article-comments-cancel' => 'Annulle',
	'article-comments-delete' => 'scangille',
	'article-comments-edit' => 'cange',
	'article-comments-history' => 'cunde',
	'article-comments-error' => "Non g'è state possibbele ccu salve 'u commende",
	'article-comments-undeleted-comment' => "Commende no scangellate p'a pàgene $1 d'u blog",
	'article-comments-rc-comment' => 'Commende d\'a vôsce (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => "Commende d'a vôsce ([[$1]])",
	'article-comments-fblogin' => 'Pe piacere <a href="$1" rel="nofollow">tràse e connettite cu Feisbuk</a> pe mannà \'nu commende sus a stu messàgge sus a sta uicchi!',
	'article-comments-fbconnect' => 'Please <a href="$1">tràse jndr\'à stu cunde cu Feisbuk</a> pe commendà!',
	'article-comments-rc-blog-comment' => 'Commende d\'u blog (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => "Commende d'u blog ([[$1]])",
	'article-comments-login' => 'Pe piacere [[Special:UserLogin|tràse]] pe mannà \'nu commende sus a sta uicchi.',
	'article-comments-toc-item' => 'Commende',
	'article-comments-comment-cannot-add' => "Tu non ge puè aggiungere 'nu commende a 'a vôsce.",
	'article-comments-vote' => 'Vote',
	'article-comments-reply' => 'Respunne',
	'article-comments-show-all' => 'Vide tutte le commènde',
	'article-comments-prev-page' => 'Prec',
	'article-comments-next-page' => 'Prossime',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => "'A vôsce / commende padre ha state scangellate.",
	'article-comments-empty-comment' => "Tu non ge puè mannà 'nu commende vacande. [$1 Scangillale allore?]",
	'article-comments-show-more' => 'Fà vedè cchiù commende',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Commende}}',
	'wikiamobile-article-comments-header' => 'commende',
	'wikiamobile-article-comments-more' => 'Careche le otre',
	'wikiamobile-article-comments-prev' => "Careche 'u precedende",
	'wikiamobile-article-comments-none' => 'Nisciune commende',
	'wikiamobile-article-comments-view' => 'Vide le resposte',
	'wikiamobile-article-comments-replies' => 'resposte',
	'wikiamobile-article-comments-post-reply' => "Manne 'na resposte",
	'wikiamobile-article-comments-post' => 'Messàgge',
	'wikiamobile-article-comments-placeholder' => "Mitte 'nu commende",
	'wikiamobile-article-comments-login-post' => "Pe piacere tràse pe lassà 'nu commende",
	'wikiamobile-article-comments-post-fail' => 'Commende da reggistrà fallite, pe piacere pruève arrete',
	'enotif_subject_article_comment' => '$PAGEEDITOR ave commendate sus a "$PAGETITLE" sus a {{SITENAME}}',
	'enotif_body_article_comment' => "Cià \$WATCHINGUSERNAME,

Stè 'nu commende nuève sus a \$PAGETITLE sus a {{SITENAME}}. Ause stu collegamende pe 'ndrucà tutte sus a le commende: \$PAGETITLE_URL#WikiaArticleComments

- Uicchia Comunitate de Supporte

___________________________________________
* Iacchie aijute e consiglie sus 'a Comunitate Cendrale: http://community.wikia.com
* Vuè avè mene messàgge da nuje? Allore scangillate o cange le preferenze de l'email aqquà: http://community.wikia.com/Special:Preferences",
	'enotif_body_article_comment-HTML' => '<p>Cià $WATCHINGUSERNAME,
<br /><br />
Ste \'nu commende nuève sus a $PAGETITLE sus a {{SITENAME}}. Ause stu collegamende pe \'ndrucà tutte sus a le commende: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Uicchie Comunitate de Supporte
<br /><br />
___________________________________________
<ul>
<li>Pe acchià aijute e consiglie sus \'a Comunitate Cendrale: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Vuè avè mene messàgge da nuje? Te puè scangellà o cangià le preferenze de l\'email toje aqquà: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Russian (русский)
 * @author DCamer
 * @author Express2000
 * @author Kuzura
 * @author Okras
 */
$messages['ru'] = [
	'article-comments-file-page' => "[[$1|Комментарий от $2]] на [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Комментарий от $2]] на пост [[$3|$4</> в блоге [[$5|$6]]",
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
	'article-comments-login' => 'Пожалуйста, [[Special:UserLogin|войдите в систему]], чтобы оставлять комментарии на этой вики',
	'article-comments-toc-item' => 'Комментарии',
	'article-comments-comment-cannot-add' => 'Вы не можете добавить комментарий к этой статье',
	'article-comments-vote' => 'Голосовать за',
	'article-comments-reply' => 'Ответить',
	'article-comments-show-all' => 'Показать все комментарии',
	'article-comments-prev-page' => 'Пред.',
	'article-comments-next-page' => 'След.',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Родительская статьи / родительский комментарий был удален',
	'article-comments-empty-comment' => "Вы не можете добавить пустой комментарий. [$1 Удалить его?]",
	'article-comments-show-more' => 'Показать больше комментариев',
	'wikiamobile-article-comments-counter' => '$1 комментари{{PLURAL:$1|й|ев|я}}',
	'wikiamobile-article-comments-header' => 'комментарии',
	'wikiamobile-article-comments-more' => 'Загрузить больше',
	'wikiamobile-article-comments-prev' => 'Загрузить предыдущие',
	'wikiamobile-article-comments-none' => 'Нет комментариев',
	'wikiamobile-article-comments-view' => 'Просмотр ответов',
	'wikiamobile-article-comments-replies' => 'ответы',
	'wikiamobile-article-comments-post-reply' => 'Оставить ответ',
	'wikiamobile-article-comments-post' => 'Оставить',
	'wikiamobile-article-comments-placeholder' => 'Оставить комментарий',
	'wikiamobile-article-comments-login-post' => 'Пожалуйста войдите, чтобы оставить комментарий.',
	'wikiamobile-article-comments-post-fail' => 'Не удалось сохранить комментарий, повторите попытку позже',
	'enotif_subject_article_comment' => '$PAGEEDITOR прокомментировал "$ PAGETITLE" на {{SITENAME}}',
	'enotif_body_article_comment' => 'Привет $WATCHINGUSERNAME,

Новый комментарий был добавлен к странице $PAGETITLE на {{SITENAME}}. Вы можете посмотреть все комментарии по этой ссылке: $PAGETITLE_URL#WikiaArticleComments

- Команда Викия

___________________________________________
* Найти помощь и совет можно на Community Central (http://community.wikia.com) и Вики Сообщества (http://ru.community.wikia.com)
* Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на странице личных настроек: http://community.wikia.com/Special:Preferences',
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
];

/** Sanskrit (संस्कृतम्)
 * @author NehalDaveND
 */
$messages['sa'] = [
	'article-comments-cancel' => 'निरस्यताम्',
	'article-comments-delete' => 'अपाक्रियताम्',
	'article-comments-edit' => 'सम्पाद्यताम्',
	'article-comments-history' => 'इतिहासः',
	'article-comments-toc-item' => 'टिप्पणी',
	'article-comments-prev-page' => 'पूर्वतनम्',
	'article-comments-next-page' => 'अग्रिमम्',
	'article-comments-page-spacer' => '&#160...&#160',
	'wikiamobile-article-comments-header' => 'टिप्पणी',
	'wikiamobile-article-comments-more' => 'अधिकम् अवारोप्यताम्',
	'wikiamobile-article-comments-prev' => 'पूर्वतनम् अवारोप्यताम्',
	'wikiamobile-article-comments-none' => 'टिप्पण्यः न सन्ति',
];

/** Scots (Scots)
 * @author John Reid
 */
$messages['sco'] = [
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Comment|Comments}}',
];

/** Serbo-Croatian (srpskohrvatski / српскохрватски)
 * @author OC Ripper
 */
$messages['sh'] = [
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
	'article-comments-login' => 'Molimo [[Special:UserLogin|prijavite se]] kako biste poslali komentar na ovu wiki.',
	'article-comments-toc-item' => 'Komentari',
	'article-comments-comment-cannot-add' => 'Ne možete dodati komentar na članak.',
	'article-comments-reply' => 'Odgovori',
	'article-comments-show-all' => 'Pokaži sve komentare',
	'article-comments-prev-page' => 'Pret',
	'article-comments-next-page' => 'Slijed',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Matični članak / matični komentar je bio izbrisan.',
	'article-comments-empty-comment' => "Ne možete poslati prazni komentar. [$1 Umjesto toga ga izbrisati?]",
	'enotif_subject_article_comment' => '$PAGEEDITOR je komentirao/la "$PAGETITLE" na {{SITENAME}}',
	'enotif_body_article_comment' => 'Cijenjeni/a $WATCHINGUSERNAME,

$PAGEEDITOR je komentirao/la "$PAGETITLE".

Da vidite thread komentara, pratite donji link:
$PAGETITLE_URL

Dolazite i uređujte često...

Wikia', # Fuzzy
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
</p>', # Fuzzy
];

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = [
	'article-comments-delete' => 'මකන්න',
	'article-comments-edit' => 'සංස්කරණය කරන්න',
	'article-comments-history' => 'ඉතිහාසය',
];

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Aktron
 * @author Milicevic01
 * @author Rancher
 * @author Милан Јелисавчић
 */
$messages['sr-ec'] = [
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
	'article-comments-toc-item' => 'Коментари',
	'article-comments-comment-cannot-add' => 'Не можете додати коментар на чланак.',
	'article-comments-vote' => 'Гласај',
	'article-comments-reply' => 'Одговори',
	'article-comments-show-all' => 'Прикажи све коментаре',
	'article-comments-prev-page' => 'Претходно',
	'article-comments-next-page' => 'Следеће',
	'wikiamobile-article-comments-header' => 'Коментари',
	'wikiamobile-article-comments-more' => 'Учитај још',
	'wikiamobile-article-comments-prev' => 'Учитај претходно',
	'wikiamobile-article-comments-none' => 'Нема коментара',
	'wikiamobile-article-comments-view' => 'Прикажи одговоре',
	'wikiamobile-article-comments-replies' => 'одговори',
	'wikiamobile-article-comments-post-reply' => 'Одговори',
	'wikiamobile-article-comments-post' => 'Постави',
	'wikiamobile-article-comments-placeholder' => 'Постави коментар',
	'wikiamobile-article-comments-login-post' => 'Да би оставили коментар морате бити пријављени.',
];

/** Swedish (svenska)
 * @author Geitost
 * @author Jopparn
 * @author WikiPhoenix
 */
$messages['sv'] = [
	'article-comments-desc' => 'Artikelkommentarer för wikisidor',
	'article-comments-file-page' => "[[$1|Kommentar från $2]] den [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Kommentar från $2]] den [[$3|$4]] som inlägg på [[$5|$6s]] blogg",
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
	'article-comments-login' => 'Var god [[Special:UserLogin|logga in]] för att posta en kommentar på den här wikin.',
	'article-comments-toc-item' => 'Kommentarer',
	'article-comments-comment-cannot-add' => 'Du kan inte lägga till en kommentar till artikeln.',
	'article-comments-vote' => 'Rösta upp',
	'article-comments-reply' => 'Svara',
	'article-comments-show-all' => 'Visa alla kommentarer',
	'article-comments-prev-page' => 'Föreg',
	'article-comments-next-page' => 'Nästa',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Överordnade artikeln/kommentaren har tagits bort.',
	'article-comments-empty-comment' => "Du kan inte skriva en tom kommentar. [$1 Radera det istället?]",
	'article-comments-show-more' => 'Visa fler kommentarer',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|kommentar|kommentarer}}',
	'wikiamobile-article-comments-header' => 'Kommentarer',
	'wikiamobile-article-comments-more' => 'Läs in fler',
	'wikiamobile-article-comments-prev' => 'Läs in föregående',
	'wikiamobile-article-comments-none' => 'Inga kommentarer',
	'wikiamobile-article-comments-view' => 'Visa svar',
	'wikiamobile-article-comments-replies' => 'svar',
	'wikiamobile-article-comments-post-reply' => 'Skicka ett svar',
	'wikiamobile-article-comments-post' => 'Skicka',
	'wikiamobile-article-comments-placeholder' => 'Skicka en kommentar',
	'wikiamobile-article-comments-login-post' => 'Logga in för att skicka en kommentar.',
	'wikiamobile-article-comments-post-fail' => 'Misslyckades att spara kommentar, var god försök igen senare',
	'enotif_subject_article_comment' => '$PAGEEDITOR har kommenterat "$PAGETITLE" på {{SITENAME}}',
	'enotif_body_article_comment' => 'Hej $WATCHINGUSERNAME,

Det finns en ny kommentar på PAGETITLE på {{SITENAME}}. Använd denna länk för att se alla kommentarer.
$PAGETITLE_URL#WikiaArticleComments

Besök oss och redigera ofta...

- Wikia Gemenskapssupport

___________________________________________
* Hitta hjälp och råd på Gemenskapscentralen: http://community.wikia.com
* Vill du få färre meddelanden från oss? Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra din e-postadress här: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hej $WATCHINGUSERNAME,
<br /><br />
Det finns en ny kommentar på PAGETITLE på {{SITENAME}}. Använd denna länk för att se alla kommentarer.
$PAGETITLE_URL#WikiaArticleComments
<br /><br />
Besök oss och redigera ofta...
<br /><br />
- Wikia Gemenskapssupport
<br /><br />
___________________________________________
<ul>
<li>Hitta hjälp och råd på Gemenskapscentralen: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Vill du få färre meddelanden från oss? Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra din e-postadress här: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Silesian (ślůnski)
 * @author Krol111
 */
$messages['szl'] = [
	'article-comments-cancel' => 'Uodćepej',
	'article-comments-delete' => 'wyćep',
	'article-comments-edit' => 'sprowjej',
	'article-comments-history' => 'gyszichta',
	'article-comments-toc-item' => 'Kůmyntorze:',
	'article-comments-next-page' => 'Dalij',
];

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Praveen Illa
 * @author Ravichandra
 * @author Veeven
 * @author రహ్మానుద్దీన్
 */
$messages['te'] = [
	'article-comments-file-page' => "[[$3]] పై [[$1|$2 వ్యాఖ్య]]",
	'article-blog-comments-file-page' => "[[$5|$6]] బ్లాగులోని [[$3|$4]] టపా పై [[$1|$2 వ్యాఖ్య]]",
	'article-comments-anonymous' => 'అజ్ఞాత వాడుకరి',
	'article-comments-comments' => 'వ్యాఖ్యలు ($1)',
	'article-comments-post' => 'వ్యాఖ్యానించండి',
	'article-comments-cancel' => 'రద్దుచేయి',
	'article-comments-delete' => 'తొలగించు',
	'article-comments-edit' => 'సవరించు',
	'article-comments-history' => 'చరిత్ర',
	'article-comments-error' => 'వ్యాఖ్యను భద్రపరచలేకపోయాం',
	'article-comments-undeleted-comment' => 'బ్లాగు పేజీ $1 లో తొలగించబడని వ్యాఖ్య',
	'article-comments-rc-comment' => 'వ్యాసపు వ్యాఖ్య (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'వ్యాసపు వ్యాఖ్యలు ([[$1]])',
	'article-comments-fblogin' => 'ఈ వికీలో వ్యాఖ్యానించేందుకు <a href="$1" rel="nofollow">లాగినయ్యాక, ఫేస్‍బుక్ తో కనెక్టవండి</a>!',
	'article-comments-fbconnect' => 'వ్యాఖ్యానించేందుకు <a href="$1">ఈ ఖాతాను ఫేస్‍బుక్ తో కనెక్టు చెయ్యండి</a>!',
	'article-comments-rc-blog-comment' => 'బ్లాగు వ్యాఖ్య (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'బ్లాగు వ్యాఖ్యలు ([[$1]])',
	'article-comments-login' => 'ఈ వికీలో వ్యాఖ్యానించేందుకు [[Special:UserLogin|లాగినవండి]].',
	'article-comments-toc-item' => 'వ్యాఖ్యలు',
	'article-comments-comment-cannot-add' => 'ఈ వ్యాసానికి మీరు వ్యాఖ్యని చేర్చలేరు.',
	'article-comments-vote' => 'వోటెయ్యండి',
	'article-comments-reply' => 'జవాబివ్వు',
	'article-comments-show-all' => 'వ్యాఖ్యలన్నిటినీ చూపించు',
	'article-comments-prev-page' => 'గత',
	'article-comments-next-page' => 'తరువాతి',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'మాతృ వ్యాసం/మాతృ వ్యాఖ్య తొలగించబడింది.',
	'article-comments-empty-comment' => "ఖాళీవ్యాఖ్యను పంపించలేరు. [$1 దాన్ని తొలగిస్తారా?]",
	'article-comments-show-more' => 'మరిన్ని వ్యాఖ్యలను చూపించు',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|వ్యాఖ్య|వ్యాఖ్యలు}}',
	'wikiamobile-article-comments-header' => 'వ్యాఖ్యలు',
	'wikiamobile-article-comments-more' => 'మరిన్ని చూపించు',
	'wikiamobile-article-comments-prev' => 'గత వ్యాఖ్యలను చూపించు',
	'wikiamobile-article-comments-none' => 'వ్యాఖ్యలు లేవు',
	'wikiamobile-article-comments-view' => 'జవాబులు చూపించు',
	'wikiamobile-article-comments-replies' => 'జవాబులు',
	'wikiamobile-article-comments-post-reply' => 'జవాబివ్వండి',
	'wikiamobile-article-comments-post' => 'పంపించు',
	'wikiamobile-article-comments-placeholder' => 'వ్యాఖ్యానించండి',
	'wikiamobile-article-comments-login-post' => 'వ్యాఖ్యానించేందుకు లాగినవండి.',
	'wikiamobile-article-comments-post-fail' => 'వ్యాఖ్యను భద్రపరచలేకపోయాం, మళ్ళీ ప్రయత్నించండి',
	'enotif_subject_article_comment' => '{{SITENAME}} లో "$PAGETITLE" పై $PAGEEDITOR వ్యాఖ్యానించారు',
];

/** Thai (ไทย)
 * @author Panan2544
 */
$messages['th'] = [
	'article-comments-desc' => 'ความคิดเห็นต่อบทความสำหรับหน้าเว็บวิกิ',
	'article-comments-file-page' => "[[$1| ความคิดเห็นจาก $2]] บน [[$3]]",
	'article-blog-comments-file-page' => "[[$1| ความคิดเห็นจาก $2]] บน [[$3|$4]] โพสต์บนบล็อก [[$5|$6's]]",
	'article-comments-anonymous' => 'ผู้ไม่ประสงค์ออกนาม',
	'article-comments-comments' => 'ความคิดเห็น ($1)',
	'article-comments-post' => 'โพสต์ ความคิดเห็น',
	'article-comments-cancel' => 'ยกเลิก',
	'article-comments-delete' => 'ลบ',
	'article-comments-edit' => 'แก้ไข',
	'article-comments-history' => 'ประวัติ',
	'article-comments-error' => 'ความคิดเห็นไม่สามารถบันทึกได้',
	'article-comments-undeleted-comment' => 'ยกเลิกการลบความคิดเห็นสำหรับหน้าบล็อก $1',
	'article-comments-rc-comment' => 'ความคิดเห็นบทความ  (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'ความคิดเห็นบทความ ([[$1]])',
	'article-comments-fblogin' => 'กรุณา <a href="$1" rel="nofollow"> เข้าสู่ระบบโดยการเชื่อมต่อกับ Facebook</a> เพื่อสามารถแสดงความคิดเห็นบน วิกิ ได้!',
	'article-comments-fbconnect' => 'กรุณา <a href="$1">เชื่อมต่อกับบัญชีนี้โดย Facebook</a> เพื่อแสดงความคิดเห็น!',
	'article-comments-rc-blog-comment' => 'แสดงความคิดเห็นต่อบล็อก (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'ความคิดเห็นต่อบล็อก ([[$1]])',
	'article-comments-login' => 'โปรด [[Special:UserLogin| เข้าสุ่ระบบ ]] เพื่อแสดงความคิดเห็นบน วิกิ',
	'article-comments-toc-item' => 'ความคิดเห็น',
	'article-comments-comment-cannot-add' => 'คุณไม่สามารถเพิ่มความคิดเห็นต่อบทความได้',
	'article-comments-vote' => 'โหวตขึ้น',
	'article-comments-reply' => 'ตอบกลับ',
	'article-comments-show-all' => 'แสดง ความคิดเห็น ทั้งหมด',
	'article-comments-prev-page' => 'ก่อนหน้า',
	'article-comments-next-page' => 'ต่อไป',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'บทความหลัก /ความคิดเห็นหลัก ได้ถูกลบออก',
	'article-comments-empty-comment' => "คุณไม่สามารถแสดงความคิดเห็นที่ว่างเปล่า [$1 ลบมันแทน?]",
	'article-comments-show-more' => 'แสดงความคิดเห็นเพิ่มเติม',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|ความคิดเห็น|ความคิดเห็น}}',
	'wikiamobile-article-comments-header' => 'ความคิดเห็น',
	'wikiamobile-article-comments-more' => 'โหลดเพิ่มเติ่ม',
	'wikiamobile-article-comments-prev' => 'โหลดก่อนหน้านี้',
	'wikiamobile-article-comments-none' => 'ไม่มีความคิดเห็น',
];

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = [
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
	'article-comments-login' => 'Mangyaring [[Special:UserLogin|log in]] upang makapagpaskil ng isang puna sa wiking ito.',
	'article-comments-toc-item' => 'Mga puna',
	'article-comments-comment-cannot-add' => 'Hindi ka makapagdaragdag ng isang puna sa artikulo.',
	'article-comments-vote' => 'Bumotong paitaas',
	'article-comments-reply' => 'Tumugon',
	'article-comments-show-all' => 'Ipakita ang lahat ng mga puna',
	'article-comments-prev-page' => 'Nakaraan',
	'article-comments-next-page' => 'Kasunod',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Nabura ang magulang ng artikulo / magulang ng puna.',
	'article-comments-empty-comment' => "Hindi ka makapagpapaskil ng puna na walang laman. [$1 Burahin na lang ito?]",
	'wikiamobile-article-comments-header' => 'mga puna',
	'wikiamobile-article-comments-more' => 'Magkarga pa',
	'wikiamobile-article-comments-prev' => 'Ikarga ang dati',
	'wikiamobile-article-comments-none' => 'Walang mga puna',
	'wikiamobile-article-comments-view' => 'Tingnan ang mga tugon',
	'wikiamobile-article-comments-replies' => 'mga tugon',
	'wikiamobile-article-comments-post-reply' => 'Magpaskil ng isang tugon',
	'wikiamobile-article-comments-post' => 'Ipaskil',
	'wikiamobile-article-comments-placeholder' => 'Magpaskil ng puna',
	'wikiamobile-article-comments-login-post' => 'Mangyaring lumagda upang makapagpaskil ng isang puna.',
	'enotif_subject_article_comment' => 'Pumuna ang $PAGEEDITOR sa "$PAGETITLE" sa {{SITENAME}}',
	'enotif_body_article_comment' => 'Minamahal na $WATCHINGUSERNAME,

Nagbigay ng puna si $PAGEEDITOR sa "$PAGETITLE".

Upang matingnan ang bagting ng puna, sundan ang kawing na nasa ibaba:
$PAGETITLE_URL

Mangyaring dumalaw at mamatnugot ng madalas...

Wikia', # Fuzzy
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
</p>', # Fuzzy
];

/** Talysh (толышә зывон)
 * @author Erdemaslancan
 * @author Гусейн
 */
$messages['tly'] = [
	'article-comments-cancel' => 'Ләғв кардеј',
	'article-comments-delete' => 'рәдд кардеј',
	'article-comments-edit' => 'сәрост кардеј',
	'article-comments-history' => 'тарых',
	'article-comments-toc-item' => 'Мындәриҹот',
	'article-comments-prev-page' => 'Навы.',
];

/** Turkish (Türkçe)
 * @author 82-145
 * @author Gizemb
 * @author Incelemeelemani
 * @author Trncmvsr
 */
$messages['tr'] = [
	'article-comments-file-page' => "[[$3]] sayfasında [[$1|$2 tarafından]] yorum yapıldı",
	'article-blog-comments-file-page' => "[[$5|$6]] kullanıcısının [[$3|$4]] blog yazısına [[$1|$2 kullanıcısı]] yorum yaptı",
	'article-comments-anonymous' => 'Anonim kullanıcı',
	'article-comments-comments' => 'Yorumlar ($1)',
	'article-comments-post' => 'Yorum gönder',
	'article-comments-cancel' => 'Vazgeç',
	'article-comments-delete' => 'sil',
	'article-comments-edit' => 'düzenle',
	'article-comments-history' => 'geçmiş',
	'article-comments-error' => 'Yorum kaydedilemiyor',
	'article-comments-undeleted-comment' => '$1 blog sayfasındaki yorum geri alındı',
	'article-comments-rc-comment' => 'Makale yorumu (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Makale yorumları ([[$1]])',
	'article-comments-fblogin' => 'Bu makaleyi yorumlamak için lütfen oturum açın veya <a href="$1" rel="nofollow">Facebook ile bağlanın</a>!',
	'article-comments-fbconnect' => 'Yorumlamak için lütfen <a href="$1">Facebook hesabı ile hesabınızı</a> ilişkilendirin!',
	'article-comments-rc-blog-comment' => 'Blog yorumu (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => 'Blog yorumları ([[$1]])',
	'article-comments-login' => 'Bu wiki hakkında yorum yapabilmek için lütfen [[Special:UserLogin|oturum açın]].',
	'article-comments-toc-item' => 'Yorumlar',
	'article-comments-comment-cannot-add' => 'Bu maddeye yorum ekleyemezsiniz.',
	'article-comments-vote' => 'Destekle',
	'article-comments-reply' => 'Yanıtla',
	'article-comments-show-all' => 'Tüm yanıtları göster',
	'article-comments-prev-page' => 'Önceki',
	'article-comments-next-page' => 'Sonraki',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Ana makale / ana yorum silinmiş.',
	'article-comments-empty-comment' => "Boş yorum gönderemezsiniz. [$1 Bunun yerine silin?]",
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|Yorum|Yorum}}',
	'wikiamobile-article-comments-header' => 'Yorumlar',
	'wikiamobile-article-comments-more' => 'Daha fazla yükle',
	'wikiamobile-article-comments-prev' => 'Öncekileri yükle',
	'wikiamobile-article-comments-none' => 'Yorum yok',
	'wikiamobile-article-comments-view' => 'Yanıtları görüntüle',
	'wikiamobile-article-comments-replies' => 'cevaplar',
	'wikiamobile-article-comments-post-reply' => 'Cevap gönder',
	'wikiamobile-article-comments-post' => 'Yazı',
	'wikiamobile-article-comments-placeholder' => 'Yorum gönder',
	'wikiamobile-article-comments-login-post' => 'Yorum yazmak için lütfen giriş yapınız.',
	'wikiamobile-article-comments-post-fail' => 'Yorum kaydetme başarısız oldu, lütfen daha sonra yeniden deneyin',
	'enotif_subject_article_comment' => '$PAGEEDITOR {{SITENAME}} sitesindeki  "$PAGETITLE" başlığına yorum bıraktı',
	'enotif_body_article_comment' => 'Merhaba $WATCHINGUSERNAME,

{{SITENAME}} sitesi $PAGETITLE  başlığında yeni bir yorum var. Tüm yorumları görmek için şu linki kullanabilirsiniz: $PAGETITLE_URL#WikiaArticleComments

- Wikia Topluluğu Desteği

___________________________________________
* Topluluk Merkezinden yardım alabilirsiniz: http://community.wikia.com
* Bizden daha az mesaj almak ister misiniz? Şu adresteki tercihlerinizden e-posta aboneliğinizi iptal edin veya değiştirin: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Merhaba $WATCHINGUSERNAME,
<br /><br />
{{SITENAME}} sitesi $PAGETITLE başlığında yeni bir yorum var. Tüm yorumları görmek için şu bağlantıyı kullanın: $PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia Topluluğu Desteği
<br /><br />
___________________________________________
<ul>
<li>Topluluk Merkezinden yardım alabilirsiniz: <a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>Bizden daha az mesaj almak ister misiniz? Şu adresteki tercihlerinizden e-posta aboneliğinizi iptal edin veya değiştirin: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = [
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
	'article-comments-login' => 'Бу викида фикер калдырыр өчен, зинһар,  [[Special:UserLogin|системага керегез]]',
	'article-comments-toc-item' => 'Фикерләр',
	'article-comments-comment-cannot-add' => 'Сез бу мәкалә фикер калдыра алмыйсыз',
	'article-comments-vote' => '- өчен тавыш бирергә',
	'article-comments-reply' => 'Җавап бирергә',
	'article-comments-show-all' => 'Бөтен фикерләрне күрсәтергә',
	'article-comments-prev-page' => 'Алдагы',
	'article-comments-next-page' => 'Киләсе',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Баш мәкалә/ баш фикер бетерелгән иде.',
	'article-comments-empty-comment' => "Сез буш фикер өсти алмыйсыз. [$1 Бетерергәме аны?]",
	'wikiamobile-article-comments-header' => 'фикерләр',
	'wikiamobile-article-comments-more' => 'Күбрәк йөкләү',
	'wikiamobile-article-comments-prev' => 'Алдагыларын йөкләү',
	'wikiamobile-article-comments-none' => 'Шәрехләр юк',
	'wikiamobile-article-comments-view' => 'Җавапларны карау',
	'wikiamobile-article-comments-replies' => 'җаваплар',
	'wikiamobile-article-comments-post-reply' => 'Җавап калдырырга',
	'wikiamobile-article-comments-post' => 'Калдырырга',
	'wikiamobile-article-comments-placeholder' => 'Фикер калдырырга',
	'wikiamobile-article-comments-login-post' => 'Фикер калдырыр өчен, зинһар, керегез.',
	'enotif_subject_article_comment' => '$PAGEEDITOR {{SITENAME}} сәхифәсендә "$PAGETITLE" битен шәрехләде',
	'enotif_body_article_comment' => 'Хөрмәтле $WATCHINGUSERNAME,


$PAGEEDITOR "$PAGETITLE" мәкаләсендә шәрехләмә калдырды.

Шәрехләмәне карар өчен, бу сылтама аша узыгыз:
$PAGETITLE_URL

Викия', # Fuzzy
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
</p>', # Fuzzy
];

/** Central Atlas Tamazight (ⵜⴰⵎⴰⵣⵉⵖⵜ)
 * @author Tifinaghes
 */
$messages['tzm'] = [
	'article-comments-history' => 'ⴰⵎⵣⵔⵓⵢ',
	'article-comments-reply' => 'ⵔⴰⵔ',
];

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Base
 * @author Erami
 * @author Mykola Swarnyk
 * @author Steve.rusyn
 * @author SteveR
 * @author Ua2004
 * @author Капитан Джон Шепард
 */
$messages['uk'] = [
	'article-comments-desc' => 'Коментарі до статті на Вікі-сторінці',
	'article-comments-file-page' => "[[$1|Коментар від $2]] у темі [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Коментар від $2]] на сторінці [[$3|$4]] у блозі користувача [[$5|$6]]",
	'article-comments-anonymous' => 'Анонімний користувач',
	'article-comments-comments' => 'Коментарі ($1)',
	'article-comments-post' => 'Залишити коментар',
	'article-comments-cancel' => 'Скасувати',
	'article-comments-delete' => 'Видалити',
	'article-comments-edit' => 'редагувати',
	'article-comments-history' => 'історія',
	'article-comments-error' => 'Неможливо зберегти коментар',
	'article-comments-undeleted-comment' => 'Відновити коментар на сторінці блогу $1',
	'article-comments-rc-comment' => 'Коментар до статті (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => 'Коментарі до статті ([[$1]])',
	'article-comments-fblogin' => 'Будь ласка, <a href="$1" rel="nofollow">увійдіть до системи через Facebook</a>, щоб мати змогу залишати коментарі на цій вікі!',
	'article-comments-fbconnect' => 'Будь ласка, <a href="$1">підключіть цей акаунт до Facebook</a>, щоб мати змогу коментувати!',
	'article-comments-rc-blog-comment' => 'Коментар у блозі (<span class="plainlinks">[$1  $2]</span>)',
	'article-comments-rc-blog-comments' => 'Коментарі у блозі ([[$1]])',
	'article-comments-login' => 'Будь ласка, [[Special:UserLogin|авторизуйтеся,]] щоб коментувати на цій вікі.',
	'article-comments-toc-item' => 'Коментарі',
	'article-comments-comment-cannot-add' => 'Ви не можете додати коментар до цієї статті.',
	'article-comments-vote' => 'Голосувати за',
	'article-comments-reply' => 'Відповісти',
	'article-comments-show-all' => 'Показати всі коментарі',
	'article-comments-prev-page' => 'Перед',
	'article-comments-next-page' => 'Далі',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Батьківську статтю / коментар було видалено.',
	'article-comments-empty-comment' => "Ви не можете надіслати порожній коментар. [$1 Видалити його?]",
	'article-comments-show-more' => 'Показати більше коментарів',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|коментар|коментарі|коментарів}}',
	'wikiamobile-article-comments-header' => 'Коментарі',
	'wikiamobile-article-comments-more' => 'Завантажити більше',
	'wikiamobile-article-comments-prev' => 'Завантажити попередні',
	'wikiamobile-article-comments-none' => 'Немає коментарів',
	'wikiamobile-article-comments-view' => 'Переглянути відповіді',
	'wikiamobile-article-comments-replies' => 'відповіді',
	'wikiamobile-article-comments-post-reply' => 'Відповісти',
	'wikiamobile-article-comments-post' => 'Залишити повідомлення',
	'wikiamobile-article-comments-placeholder' => 'Залишити коментар',
	'wikiamobile-article-comments-login-post' => 'Будь ласка, увійдіть, щоб залишити коментар.',
	'wikiamobile-article-comments-post-fail' => 'Не вдалося зберегти коментар, будь ласка, повторіть спробу пізніше',
	'enotif_subject_article_comment' => '$PAGEEDITOR прокоментував статтю "$PAGETITLE" на  сайті {{SITENAME}}',
	'enotif_body_article_comment' => 'Привіт, $WATCHINGUSERNAME.

З\'явився новий коментар до статті $PAGETITLE на сайті {{SITENAME}}. Зайдіть сюди, щоб переглянути всі коментарі: $PAGETITLE_URL#WikiaArticleComments

- Підтримка спільноти Wikia

___________________________________________
* Знайти допомогу і пораду в Громадському центрі: http://community.wikia.com
* Хочете отримувати менше повідомлень від нас? Ви можете відмовитися або змінити налаштування вашої електронної пошти тут: http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Привіт $WATCHINGUSERNAME.
<br /><br />
З\'явився новий коментар до статті $PAGETITLE на сайті {{SITENAME}}. Зайдіть сюди, щоб переглянути  всі коментарі: $PAGETITLE_URL #WikiaArticleComments
<br /><br />
- Підтримка спільноти Wikia
<br /><br />
___________________________________________
<ul>
<li>Знайти допомогу і пораду в громадському центрі: <a href="http://community.wikia.com">http://community.wikia.com</a></li>
<li>Хочете отримувати менше повідомлень від нас? Ви можете відмовитися або змінити налаштування вашої електронної пошти тут: <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = [
	'article-comments-cancel' => 'Heitta pätand',
	'article-comments-delete' => 'čuta poiš',
];

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author Dinhxuanduyet
 * @author Tuankiet65
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = [
	'article-comments-desc' => 'Các bình luận bài viết cho các trang wiki',
	'article-comments-file-page' => "[[$1|Bình luận của $2]] trên bài [[$3]]",
	'article-blog-comments-file-page' => "[[$1|Bình luận từ  $2  ]] trên [[$3| $4 ]] đăng bài trên [[$5|  $6 của]] blog",
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
	'article-comments-login' => 'Xin vui lòng [[Special:UserLogin|đăng nhập]] để đăng một bình luận trên wiki này.',
	'article-comments-toc-item' => 'Bình luận',
	'article-comments-comment-cannot-add' => 'Bạn không thể thêm bình luận cho bài viết.',
	'article-comments-vote' => 'Bình chọn',
	'article-comments-reply' => 'Trả lời',
	'article-comments-show-all' => 'Hiển thị tất cả các bình luận',
	'article-comments-prev-page' => 'Kế trước',
	'article-comments-next-page' => 'Tiếp theo',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => 'Bài viết gốc / bình luận gốc đã bị xóa.',
	'article-comments-empty-comment' => "Bạn không thể đăng một bình luận rỗng. [$1 Xóa nó thay thế?]",
	'article-comments-show-more' => 'Hiển thị các bình luận khác',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|bình luận|bình luận}}',
	'wikiamobile-article-comments-header' => 'Bình luận',
	'wikiamobile-article-comments-more' => 'Tải thêm',
	'wikiamobile-article-comments-prev' => 'Tải bản trước',
	'wikiamobile-article-comments-none' => 'Không có bình luận',
	'wikiamobile-article-comments-view' => 'Xem hồi âm',
	'wikiamobile-article-comments-replies' => 'hồi âm',
	'wikiamobile-article-comments-post-reply' => 'Viết một hồi âm',
	'wikiamobile-article-comments-post' => 'Gửi',
	'wikiamobile-article-comments-placeholder' => 'Viết một bình luận',
	'wikiamobile-article-comments-login-post' => 'Vui lòng đăng nhập để viết bình luận.',
	'wikiamobile-article-comments-post-fail' => 'Không thể lưu bình luận, xin vui lòng thử lại sau',
	'enotif_subject_article_comment' => '$PAGEEDITOR đã bình luận trang "$PAGETITLE" trên {{SITENAME}}',
	'enotif_body_article_comment' => 'Xin chào $WATCHINGUSERNAME,

$PAGEEDITOR đã có một bình luận trên trang "$PAGETITLE".

Để xem các chủ đề thảo luận, xin theo liên kết dưới đây:
$PAGETITLE_URL

Xin hãy truy cập và sửa đổi thường xuyên...

- Cộng đồng hỗ trợ Wikia',
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
];

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Duolaimi
 * @author Hydra
 * @author Liuxinyu970226
 * @author User670839245
 * @author Yfdyh000
 */
$messages['zh-hans'] = [
	'article-comments-desc' => 'wiki页面的条目评论',
	'article-comments-file-page' => "[[$1|评论由 $2]] 于 [[$3]] 发表",
	'article-blog-comments-file-page' => "在[[$5|$6]]的博客上的文章[[$3|$4]]有[[$1|来至$2的评论]]。",
	'article-comments-anonymous' => '匿名用户',
	'article-comments-comments' => '评论（$1）',
	'article-comments-post' => '发表评论',
	'article-comments-cancel' => '取消',
	'article-comments-delete' => '删除',
	'article-comments-edit' => '编辑',
	'article-comments-history' => '历史',
	'article-comments-error' => '无法保存评论',
	'article-comments-undeleted-comment' => '撤消删除博客页$1的评论',
	'article-comments-rc-comment' => '条目评论(<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => '文章评论([[$1]])',
	'article-comments-fblogin' => '请<a href="$1" rel="nofollow">登陆并连接到Facebook</a>以在本维基上发表评论！',
	'article-comments-fbconnect' => '请<a href="$1">将该账户连接到Facebook</a>以进行评论！',
	'article-comments-rc-blog-comment' => '博客评论(<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '博客评论([[$1]])',
	'article-comments-login' => '请[[Special:UserLogin|登陆]]以在本维基上发表评论。',
	'article-comments-toc-item' => '评论',
	'article-comments-comment-cannot-add' => '不能将评论添加到文章中。',
	'article-comments-vote' => '投票',
	'article-comments-reply' => '回复',
	'article-comments-show-all' => '显示所有注释',
	'article-comments-prev-page' => '上一页',
	'article-comments-next-page' => '下一页',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '源条目/源评论已被删除。',
	'article-comments-empty-comment' => "您不能发布空白评论。[$1 是否删除它？]",
	'article-comments-show-more' => '显示更多评论',
	'wikiamobile-article-comments-counter' => '$1条评论',
	'wikiamobile-article-comments-header' => '条评论',
	'wikiamobile-article-comments-more' => '加载更多',
	'wikiamobile-article-comments-prev' => '加载前项',
	'wikiamobile-article-comments-none' => '暂无评论',
	'wikiamobile-article-comments-view' => '查看回复',
	'wikiamobile-article-comments-replies' => '回复',
	'wikiamobile-article-comments-post-reply' => '发表回复',
	'wikiamobile-article-comments-post' => '发布',
	'wikiamobile-article-comments-placeholder' => '发表评论',
	'wikiamobile-article-comments-login-post' => '请登录以发表评论。',
	'wikiamobile-article-comments-post-fail' => '评论保存失败，请稍后再试',
	'enotif_subject_article_comment' => '$PAGEEDITOR在{{SITENAME}}上对"$PAGETITLE"发表了评论',
	'enotif_body_article_comment' => '嗨！$WATCHINGUSERNAME

{{SITENAME}}上的$PAGETITLE有了新评论哦。点此链接查看所有评论：$PAGETITLE_URL#WikiaArticleComments

- Wikia社区支持

___________________________________________
* 在社区中心寻找帮助和建议：http://community.wikia.com
* 希望减少来自我们的消息？您可以在此退订或更改您的电子邮件设置：http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}}上的$PAGETITLE有评论哦。点击如下链接查看全部评论：
<br /><br />
依如下链接查看评论：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia社区支持
<br /><br />

___________________________________________
<ul>
<li>在社区中心群求帮助或建议：<a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>管理您收到的邮件，退订或改变邮件设置请点击： <a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Traditional Chinese (中文（繁體）‎)
 * @author Citizen01
 * @author Cwlin0416
 * @author Ffaarr
 * @author LNDDYL
 * @author Liuxinyu970226
 */
$messages['zh-hant'] = [
	'article-comments-desc' => 'wiki 頁面的文章評論功能',
	'article-comments-file-page' => "[[$1|評論由 $2]] 於 [[$3]] 發表",
	'article-blog-comments-file-page' => "在[[$5|$6]]的部落格上的文章[[$3|$4]]有[[$1|來自 $2 的評論]]。",
	'article-comments-anonymous' => '匿名使用者',
	'article-comments-comments' => '評論 ($1)',
	'article-comments-post' => '發表評論',
	'article-comments-cancel' => '取消',
	'article-comments-delete' => '刪除',
	'article-comments-edit' => '編輯',
	'article-comments-history' => '歷史',
	'article-comments-error' => '評論無法儲存',
	'article-comments-undeleted-comment' => '取消刪除部落格文章 $1 的評論',
	'article-comments-rc-comment' => '文章評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-comments' => '文章評論 ([[$1]])',
	'article-comments-fblogin' => '請 <a href="$1" rel="nofollow">登入並連結 Facebook</a> 以在此 wiki 發表評論',
	'article-comments-fbconnect' => '請 <a href="$1">連結此帳號與 Facebook </a> 以發表評論',
	'article-comments-rc-blog-comment' => '部落格評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '部落格評論 ([[$1]])',
	'article-comments-login' => '請 [[Special:UserLogin|登入]] 以在此 wiki 發表評論。',
	'article-comments-toc-item' => '評論',
	'article-comments-comment-cannot-add' => '您不能在這篇文章中增加評論。',
	'article-comments-vote' => '參與投票',
	'article-comments-reply' => '回覆',
	'article-comments-show-all' => '顯示所有評論',
	'article-comments-prev-page' => '前一頁',
	'article-comments-next-page' => '下一頁',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-delete-reason' => '上層文章/上層評論已經被刪除。',
	'article-comments-empty-comment' => "您不能發佈空白的評論。[$1 要刪除它嗎？]",
	'article-comments-show-more' => '顯示更多評論',
	'wikiamobile-article-comments-counter' => '$1 {{PLURAL:$1|評論|評論}}',
	'wikiamobile-article-comments-header' => '評論',
	'wikiamobile-article-comments-more' => '讀取更多',
	'wikiamobile-article-comments-prev' => '讀取前項',
	'wikiamobile-article-comments-none' => '沒有評論',
	'wikiamobile-article-comments-view' => '檢視回覆',
	'wikiamobile-article-comments-replies' => '回覆',
	'wikiamobile-article-comments-post-reply' => '發表回覆',
	'wikiamobile-article-comments-post' => '發佈',
	'wikiamobile-article-comments-placeholder' => '發表評論',
	'wikiamobile-article-comments-login-post' => '請登入後發表評論。',
	'wikiamobile-article-comments-post-fail' => '評論儲存失敗，請稍後再試',
	'enotif_subject_article_comment' => '$PAGEEDITOR 在 {{SITENAME}} 的文章 "$PAGETITLE" 中發表評論',
	'enotif_body_article_comment' => '您好 $WATCHINGUSERNAME，

{{SITENAME}} 上的 $PAGETITLE 有新評論。
點此連結查看評論：$PAGETITLE_URL#WikiaArticleComments

Wikia 社群支援小組

___________________________________________
* 您可在社群中心尋找協助和建議：http://community.wikia.com
* 不想收到這麼多訊息？您可以在以下頁面退訂或變更電子信箱設定：http://community.wikia.com/Special:Preferences',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}} 上的 $PAGETITLE 有新評論。
<br /><br />
點此連結查看評論：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia 社群支援小組
<br /><br />

___________________________________________
<ul>
<li>您可在社群中心尋找協助和建議：<a href="http://community.wikia.com">http://community.wikia.com</a><li>
<li>不想收到這麼多訊息？您可以在以下頁面退訂或變更電子信箱設定：<a href="http://community.wikia.com/Special:Preferences">http://community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
];

/** Chinese (Hong Kong) (中文（香港）‎)
 * @author Tcshek
 */
$messages['zh-hk'] = [
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
	'article-comments-rc-blog-comment' => '文章評論 (<span class="plainlinks">[$1 $2]</span>)',
	'article-comments-rc-blog-comments' => '文章評論 ([[$1]])',
	'article-comments-login' => '請 [[Special:UserLogin|登入]] 以在此wiki上張貼評論。',
	'article-comments-toc-item' => '評論',
	'article-comments-comment-cannot-add' => '您不能在這篇文章中增加評論。',
	'article-comments-vote' => '參與投票',
	'article-comments-reply' => '回覆',
	'article-comments-show-all' => '顯示所有評論',
	'article-comments-prev-page' => '前一筆',
	'article-comments-next-page' => '下一頁',
	'article-comments-page-spacer' => '&#160...&#160',
	'article-comments-empty-comment' => "你不能發佈空的評論。[$1 要刪除它嗎？]",
	'wikiamobile-article-comments-header' => '評論',
	'wikiamobile-article-comments-more' => '載入更多',
	'wikiamobile-article-comments-prev' => '載入前面的',
	'wikiamobile-article-comments-none' => '沒有評論',
	'wikiamobile-article-comments-view' => '查看回覆',
	'wikiamobile-article-comments-replies' => '回覆',
	'wikiamobile-article-comments-post-reply' => '發表回覆',
	'wikiamobile-article-comments-post' => '發佈',
	'wikiamobile-article-comments-placeholder' => '發表評論',
	'wikiamobile-article-comments-login-post' => '請登錄後發表評論。',
	'wikiamobile-article-comments-post-fail' => '評論儲存失敗，請稍後再試',
	'enotif_subject_article_comment' => '$PAGEEDITOR 在 {{SITENAME}}的文章 "$PAGETITLE"中發表評論',
];
