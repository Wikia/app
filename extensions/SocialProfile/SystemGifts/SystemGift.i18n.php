<?php
/**
 * Internationalization file for SystemGifts extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Wikia, Inc.
 * @author Purodha
 */
$messages['en'] = array(
	'systemgiftmanager' => 'System gifts manager',
	'ga-addnew' => '+ Add new gift',
	'ga-back-edit-gift' => 'Back to edit this gift',
	'ga-back-gift-list' => 'Back to gift list',
	'ga-back-link' => '<a href="$1">< Back to $2\'s profile</a>',
	'ga-choosefile' => 'Choose file:',
	'ga-count' => '$1 has $2 {{PLURAL:$2|award|awards}}.',
	'ga-create-gift' => 'Create gift',
	'ga-created' => 'The gift has been created',
	'ga-currentimage' => 'Current image',
	'ga-error-message-invalid-link' => 'The link you have entered is invalid.',
	'ga-error-message-no-user' => 'The user you are trying to view does not exist.',
	'ga-error-title' => 'Woops, you took a wrong turn!',
	'ga-file-instructions' => 'Your image must be a jpeg, png or gif (no animated gifs), and must be less than 100kb in size.',
	'ga-gift' => 'gift',
	'ga-gift-given-count' => 'This gift has been given out $1 {{PLURAL:$1|time|times}}',
	'ga-gift-title' => '$1\'s "$2"',
	'ga-giftdesc' => 'gift description',
	'ga-giftimage' => 'gift image',
	'ga-giftname' => 'gift name',
	'ga-gifttype' => 'gift type',
	'ga-goback' => 'Go back',
	'ga-imagesbelow' => 'Below are your images that will be used on the site',
	'ga-img' => 'add/replace image',
	'ga-large' => 'Large',
	'ga-medium' => 'Medium',
	'ga-mediumlarge' => 'Medium-large',
	'ga-new' => 'New',
	'ga-next' => 'Next',
	'ga-previous' => 'Prev',
	'ga-recent-recipients-award' => 'Other recent recipients of this award',
	'ga-saved' => 'The gift has been saved',
	'ga-small' => 'Small',
	'ga-threshold' => 'threshold',
	'ga-title' => '$1\'s awards',
	'ga-uploadsuccess' => 'Upload successful',
	'ga-viewlist' => 'View gift list',
	'ga-cancel' => 'Cancel',
	'ga-remove' => 'Remove',
	'ga-remove-title' => 'Remove "$1"?',
	'ga-delete-message' => 'Are you sure you want to delete the gift "$1"?
This will also delete it from users who may have received it.',
	'ga-remove-success-title' => 'You have successfully removed the gift "$1"',
	'ga-remove-success-message' => 'The gift "$1" has been removed.',
	'ga-user-got-awards' => '$1 got $2',
	'ga-awards-given-out' => '{{PLURAL:$1|One award|$1 awards}} were given out',
	'topawards' => 'Top Awards',
	'topawards-edit-title' => 'Top Awards - Edit Milestones',
	'topawards-vote-title' => 'Top Awards - Vote Milestones',
	'topawards-comment-title' => 'Top Awards - Comment Milestones',
	'topawards-recruit-title' => 'Top Awards - Recruit Milestones',
	'topawards-friend-title' => 'Top Awards - Friend Milestones',
	'topawards-award-categories' => 'Award Categories',
	'topawards-edits' => 'Edits',
	'topawards-votes' => 'Votes',
	'topawards-comments' => 'Comments',
	'topawards-recruits' => 'Recruits',
	'topawards-friends' => 'Friends',
	'topawards-edit-milestone' => '{{PLURAL:$1|$1 Edit|$1 Edits}} Milestone',
	'topawards-vote-milestone' => '{{PLURAL:$1|$1 Vote|$1 Votes}} Milestone',
	'topawards-comment-milestone' => '{{PLURAL:$1|$1 Comment|$1 Comments}} Milestone',
	'topawards-recruit-milestone' => '{{PLURAL:$1|$1 Recruit|$1 Recruits}} Milestone',
	'topawards-friend-milestone' => '{{PLURAL:$1|$1 Friend|$1 Friends}} Milestone',
	'topawards-empty' => 'Either there are no configured awards for this award category, or then nobody has gotten those awards yet.',
	'system_gift_received_subject' => 'You have received the $1 award on {{SITENAME}}!',
	'system_gift_received_body' => 'Hi $1.

You have just received the $2 award on {{SITENAME}}!

"$3"

Click below to check out your trophy case!

$4

We hope you like it!

Thanks,


The {{SITENAME}} team

---

Hey, want to stop getting emails from us?

Click $5
and change your settings to disable email notifications.',
	// For Special:ListGroupRights
	'right-awardsmanage' => 'Create new and edit existing awards',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'ga-goback' => '{{Identical|Go back}}',
	'ga-large' => '{{Identical|Large}}',
	'ga-medium' => '{{Identical|Medium}}',
	'ga-new' => '{{Identical|New}}',
	'ga-next' => '{{Identical|Next}}',
	'ga-previous' => '{{Identical|Prev}}',
	'ga-small' => '{{Identical|Small}}',
	'ga-cancel' => '{{Identical|Cancel}}',
	'ga-remove' => '{{Identical|Remove}}',
	'ga-remove-success-title' => 'Parameters:
* $1 is a gift name.',
	'topawards-edits' => '{{Identical|Edit}}',
	'topawards-votes' => '{{Identical|Vote}}',
	'topawards-comments' => '{{Identical|Comment}}',
	'topawards-friends' => '{{Identical|Friend}}',
	'topawards-edit-milestone' => 'Parameters:
* $1 is a number; also used for PLURAL.',
	'topawards-vote-milestone' => 'Parameters:
* $1 is a number; also used for PLURAL.',
	'topawards-comment-milestone' => 'Parameters:
* $1 is a number; also used for PLURAL.',
	'topawards-recruit-milestone' => 'Parameters:
* $1 is a number; also used for PLURAL.',
	'topawards-friend-milestone' => 'Parameters:
* $1 is a number; also used for PLURAL.',
	'right-awardsmanage' => '{{doc-right|awardsmanage}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'ga-goback' => 'Gaan terug',
	'ga-large' => 'Groot',
	'ga-medium' => 'Middelmatig',
	'ga-new' => 'Nuut',
	'ga-next' => 'Volgende',
	'ga-previous' => 'Vorige',
	'ga-small' => 'Klein',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'ga-small' => 'Chicot',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'systemgiftmanager' => 'مدير هدايا النظام',
	'ga-addnew' => '+ إضافة هدية جديدة',
	'ga-back-edit-gift' => 'رجوع لتعديل هذه الهدية',
	'ga-back-gift-list' => 'رجوع لقائمة الهدايا',
	'ga-back-link' => '<a href="$1">< رجوع إلى ملف $2</a>',
	'ga-choosefile' => 'اختر الملف:',
	'ga-count' => 'لدى $1 {{PLURAL:$2||جائزة واحدة|جائزتين|$2 جوائز|$2 جائزة}}.',
	'ga-create-gift' => 'إنشاء الهدية',
	'ga-created' => 'الهدية تم إنشاؤها',
	'ga-currentimage' => 'الصورة الحالية',
	'ga-error-message-invalid-link' => 'الوصلة التي أدخلتها غير صحيحة.',
	'ga-error-message-no-user' => 'المستخدم الذي تحاول رؤيته غير موجود.',
	'ga-error-title' => 'آه، أنت أخذت منحنى خاطئا!',
	'ga-file-instructions' => 'صورتك يجب أن تكون jpeg، png أو gif (لا gif فيديو)، ويجب أن تكون أقل من 100 كيلوبت في الحجم.',
	'ga-gift' => 'هدية',
	'ga-gift-given-count' => 'أعطيت هذه الهدية {{PLURAL:$1||مرة واحدة|مرتين|$1 مرات|$1 مرة}}',
	'ga-gift-title' => '"$2" الخاصة ب$1',
	'ga-giftdesc' => 'وصف الهدية',
	'ga-giftimage' => 'صورة الهدية',
	'ga-giftname' => 'اسم الهدية',
	'ga-gifttype' => 'نوع الهدية',
	'ga-goback' => 'ارجع',
	'ga-imagesbelow' => 'بالأسفل صورك التي سيتم استخدامها في الموقع',
	'ga-img' => 'أضف/استبدل الصورة',
	'ga-large' => 'كبير',
	'ga-medium' => 'متوسط',
	'ga-mediumlarge' => 'كبير-متوسط',
	'ga-new' => 'جديد',
	'ga-next' => 'تالي',
	'ga-previous' => 'سابق',
	'ga-recent-recipients-award' => 'المتلقون الجدد الآخرون لهذه الهدية',
	'ga-saved' => 'الهدية تم حفظها',
	'ga-small' => 'صغير',
	'ga-threshold' => 'حد',
	'ga-title' => 'جوائز $1',
	'ga-uploadsuccess' => 'الرفع نجح',
	'ga-viewlist' => 'عرض قائمة الهدايا',
	'system_gift_received_subject' => 'أنت تلقيت جائزة $1 في {{SITENAME}}!',
	'system_gift_received_body' => 'مرحبا $1:

أنت تلقيت حالا جائزة $2 في {{SITENAME}}!

"$3"

اضغط بالأسفل للتحقق من صندوق جوائزك!

$4

نأمل أن تعجبك!

شكرا،


فريق {{SITENAME}}

---

ها، تريد أن تتوقف عن تلقي رسائل البريد الإلكتروني منا؟

اضغط $5
وغير إعداداتك لتعطيل إخطارات البريد الإكتروني.',
	'right-awardsmanage' => 'إنشاء جوائز جديدة وتعديل الموجودة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'ga-addnew' => '+ ܐܘܣܦ ܕܫܢܐ ܚܕܬܐ',
	'ga-choosefile' => 'ܓܒܝ ܠܦܦܐ:',
	'ga-count' => '$1 ܐܝܬ ܠܗ $2 {{PLURAL:$2|ܫܘܟܢܐ|ܫܘܟܢ̈ܐ}}.',
	'ga-create-gift' => 'ܒܪܝ ܕܫܢܐ',
	'ga-currentimage' => 'ܨܘܪܬܐ ܗܫܝܬܐ',
	'ga-gift' => 'ܕܫܢܐ',
	'ga-giftdesc' => 'ܫܘܡܗܐ ܕܕܫܢܐ',
	'ga-giftimage' => 'ܨܘܪܬܐ ܕܕܫܢܐ',
	'ga-giftname' => 'ܫܡܐ ܕܕܫܢܐ',
	'ga-gifttype' => 'ܐܕܫܐ ܕܕܫܢܐ',
	'ga-large' => 'ܪܒܬܐ',
	'ga-medium' => 'ܡܨܥܝܬܐ',
	'ga-mediumlarge' => 'ܡܨܥܝܬܐ - ܪܒܬܐ',
	'ga-new' => 'ܚܕܬܐ',
	'ga-next' => 'ܒܬܪ',
	'ga-previous' => 'ܩܕܡ',
	'ga-small' => 'ܙܥܘܪܬܐ',
	'ga-uploadsuccess' => 'ܐܣܩܬܐ ܕܠܦܦܐ ܢܨܚ',
	'ga-viewlist' => 'ܚܙܝ ܡܟܬܒܘܬܐ ܕܕ̈ܫܢܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'systemgiftmanager' => 'مدير هدايا النظام',
	'ga-addnew' => '+ إضافة هدية جديدة',
	'ga-back-edit-gift' => 'رجوع لتعديل هذه الهدية',
	'ga-back-gift-list' => 'رجوع لقائمة الهدايا',
	'ga-back-link' => '<a href="$1">< رجوع إلى ملف $2</a>',
	'ga-choosefile' => 'اختر الملف:',
	'ga-count' => '$1 يمتلك $2 {{PLURAL:$2|جائزة|جائزة}}.',
	'ga-create-gift' => 'إنشاء الهدية',
	'ga-created' => 'الهدية تم إنشاؤها',
	'ga-currentimage' => 'الصورة الحالية',
	'ga-error-message-invalid-link' => 'الوصلة التى أدخلتها غير صحيحة.',
	'ga-error-message-no-user' => 'المستخدم الذى تحاول رؤيته غير موجود.',
	'ga-error-title' => 'آه، أنت أخذت منحنى خاطئا!',
	'ga-file-instructions' => 'صورتك يجب أن تكون jpeg، png أو gif (لا gif فيديو)، ويجب أن تكون أقل من 100 كيلوبت فى الحجم.',
	'ga-gift' => 'هدية',
	'ga-gift-given-count' => 'هذه الهدية تم منحها $1 {{PLURAL:$1|مرة|مرة}}',
	'ga-gift-title' => '"$2" الخاصة ب$1',
	'ga-giftdesc' => 'وصف الهدية',
	'ga-giftimage' => 'صورة الهدية',
	'ga-giftname' => 'اسم الهدية',
	'ga-gifttype' => 'نوع الهدية',
	'ga-goback' => 'رجوع',
	'ga-imagesbelow' => 'بالأسفل صورك التى سيتم استخدامها فى الموقع',
	'ga-img' => 'أضف/استبدل الصورة',
	'ga-large' => 'كبير',
	'ga-medium' => 'متوسط',
	'ga-mediumlarge' => 'كبير-متوسط',
	'ga-new' => 'جديد',
	'ga-next' => 'تالى',
	'ga-previous' => 'سابق',
	'ga-recent-recipients-award' => 'المتلقون الجدد الآخرون لهذه الهدية',
	'ga-saved' => 'الهدية تم حفظها',
	'ga-small' => 'صغير',
	'ga-threshold' => 'حد',
	'ga-title' => 'جوائز $1',
	'ga-uploadsuccess' => 'الرفع نجح',
	'ga-viewlist' => 'عرض قائمة الهدايا',
	'system_gift_received_subject' => 'أنت تلقيت جائزة $1 فى {{SITENAME}}!',
	'system_gift_received_body' => 'مرحبا $1:

أنت تلقيت حالا جائزة $2 فى {{SITENAME}}!

"$3"

اضغط بالأسفل للتحقق من صندوق جوائزك!

$4

نأمل أن تعجبك!

شكرا،


فريق {{SITENAME}}

---

ها، تريد أن تتوقف عن تلقى رسائل البريد الإلكترونى منا؟

اضغط $5
وغير إعداداتك لتعطيل إخطارات البريد الإكترونى.',
	'right-awardsmanage' => 'إنشاء جوائز جديدة وتعديل الموجودة',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'ga-large' => 'Böyük',
	'ga-medium' => 'Orta',
	'ga-new' => 'Yeni',
	'ga-next' => 'Növbəti',
	'ga-small' => 'Kiçik',
	'ga-cancel' => 'İmtina',
	'ga-remove' => 'Çıxar',
	'ga-remove-title' => 'Çıxar "$1"?',
	'topawards-edits' => 'Redaktələr',
	'topawards-votes' => 'Səslər',
	'topawards-comments' => 'Şərhlər',
	'topawards-friends' => 'Dostlar',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Renessaince
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'systemgiftmanager' => 'Сыстэма кіраваньня падарункамі',
	'ga-addnew' => '+ Дадаць новы падарунак',
	'ga-back-edit-gift' => 'Вярнуцца да рэдагаваньня гэтага падарунка',
	'ga-back-gift-list' => 'Вярнуцца да сьпісу падарункаў',
	'ga-back-link' => '<a href="$1">< Вярнуцца да профілю $2</a>',
	'ga-choosefile' => 'Выберыце файл:',
	'ga-count' => '$1 мае $2 {{PLURAL:$2|узнагароду|узнагароды|узнагародаў}}.',
	'ga-create-gift' => 'Стварыць падарунак',
	'ga-created' => 'Падарунак быў створаны',
	'ga-currentimage' => 'Цяперашняя выява',
	'ga-error-message-invalid-link' => 'Спасылка, якую Вы ўвялі — няслушная.',
	'ga-error-message-no-user' => 'Удзельніка, якога Вы спрабуеце праглядзець, не існуе.',
	'ga-error-title' => 'Ой, Вы выбралі няслушны накірунак!',
	'ga-file-instructions' => 'Ваша выява павінна быць у фармаце jpeg, png альбо gif (анімаваныя выявы не дазволеныя) і мець памер меней за 100 кб.',
	'ga-gift' => 'падарунак',
	'ga-gift-given-count' => 'Гэты падарунак быў падараваны $1 {{PLURAL:$1|раз|разы|разоў}}',
	'ga-gift-title' => '«$2» удзельніка $1',
	'ga-giftdesc' => 'апісаньне падарунка',
	'ga-giftimage' => 'выява падарунка',
	'ga-giftname' => 'назва падарунка',
	'ga-gifttype' => 'тып падарунка',
	'ga-goback' => 'Вярнуцца',
	'ga-imagesbelow' => 'Ніжэй знаходзяцца Вашыя выявы, якія будуць выкарыстаныя на сайце',
	'ga-img' => 'дадаць/зьмяніць выяву',
	'ga-large' => 'Вялікая',
	'ga-medium' => 'Сярэдняя',
	'ga-mediumlarge' => 'Сярэдне-вялікая',
	'ga-new' => 'Новая',
	'ga-next' => 'Наступная',
	'ga-previous' => 'Папярэдняя',
	'ga-recent-recipients-award' => 'Іншыя апошнія атрымальнікі гэтай узнагароды',
	'ga-saved' => 'Падарунак быў захаваны',
	'ga-small' => 'Маленькая',
	'ga-threshold' => 'парог',
	'ga-title' => 'Узнагароды $1',
	'ga-uploadsuccess' => 'Пасьпяховая загрузка',
	'ga-viewlist' => 'Паказаць сьпіс падарункаў',
	'ga-cancel' => 'Скасаваць',
	'ga-remove' => 'Выдаліць',
	'ga-remove-title' => 'Выдаліць «$1»?',
	'ga-delete-message' => 'Вы ўпэўненыя, што жадаеце выдаліць падарунак «$1»?
Ён будзе выдалены і ва ўдзельнікаў, якія маглі яго атрымаць.',
	'ga-remove-success-title' => 'Вы пасьпяхова выдалілі падарунак «$1»',
	'ga-remove-success-message' => 'Падарунак «$1» быў выдалены.',
	'topawards' => 'Найлепшыя ўзнагароды',
	'topawards-edit-title' => 'Найлепшыя ўзнагароды — эпахальныя рэдагаваньні',
	'topawards-vote-title' => 'Найлепшыя ўзнагароды — эпахальныя галасаваньні',
	'topawards-comment-title' => 'Найлепшыя ўзнагароды — эпахальныя камэнтары',
	'topawards-recruit-title' => 'Найлепшыя ўзнагароды — эпахальныя навічкі',
	'topawards-friend-title' => 'Найлепшыя ўзнагароды — эпахальныя сябры',
	'topawards-award-categories' => 'Катэгорыі ўзнагародаў',
	'topawards-edits' => 'Рэдагаваньні',
	'topawards-votes' => 'Галасы',
	'topawards-comments' => 'Камэнтары',
	'topawards-recruits' => 'Навічкі',
	'topawards-friends' => 'Сябры',
	'topawards-edit-milestone' => '$1 {{PLURAL:$1|эпахальнае рэдагаваньне|эпахальныя рэдагаваньні|эпахальных рэдагаваньняў}}',
	'topawards-vote-milestone' => '$1 {{PLURAL:$1|эпахальнае галасаваньне|эпахальныя галасаваньні|эпахальных галасаваньняў}}',
	'topawards-comment-milestone' => '$1 {{PLURAL:$1|эпахальны камэнтар|эпахальныя камэнтары|эпахальных камэнтараў}}',
	'topawards-recruit-milestone' => '$1 {{PLURAL:$1|эпахальны навічок|эпахальныя навічкі|эпахальных навічкоў}}',
	'topawards-friend-milestone' => '$1 {{PLURAL:$1|эпахальны сябар|эпахальныя сябры|эпахальных сяброў}}',
	'topawards-empty' => 'Для гэтай катэгорыі ўзнагародаў няма наладжаных узнагародаў, альбо ніхто яшчэ не атрымоўваў гэтыя ўзнагароды.',
	'system_gift_received_subject' => 'Вы атрымалі ўзнагароду $1 у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Прывітаньне, $1.

Вы толькі што атрымалі ўзнагароду $2 у {{GRAMMAR:месны|{{SITENAME}}}}!

«$3»

Націсьніце ніжэй, каб пабачыць Ваш трафэй!

$4

Мы спадзяемся, што Вам яна спадабаецца!

Дзякуй,


Каманда {{SITENAME}}

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $5 і зьмяніце Вашыя налады, каб адключыць дасыланьне паведамленьняў па электроннай пошце.',
	'right-awardsmanage' => 'Стварыць новую і рэдагаваць існуючыя ўзнагароды',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'ga-addnew' => '+ Добавяне на нов подарък',
	'ga-choosefile' => 'Избиране на файл:',
	'ga-currentimage' => 'Текуща картинка',
	'ga-large' => 'Голяма',
	'ga-medium' => 'Средна',
	'ga-new' => 'Нова',
	'ga-next' => 'Следваща',
	'ga-previous' => 'Предишна',
	'ga-small' => 'Малка',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'ga-choosefile' => 'ফাইল পছন্দ করুন:',
	'ga-gift' => 'উপহার',
	'ga-giftdesc' => 'উপহারের বিবরণ',
	'ga-giftimage' => 'উপহারের ছবি',
	'ga-giftname' => 'উপহারের নাম',
	'ga-gifttype' => 'উপহারের ধরন',
	'ga-goback' => 'ফিরে যাও',
	'ga-large' => 'বড়',
	'ga-medium' => 'মধ্যম',
	'ga-mediumlarge' => 'মধ্যম-বড়',
	'ga-new' => 'নতুন',
	'ga-next' => 'পরবর্তী',
	'ga-previous' => 'পূর্ববর্তী',
	'ga-small' => 'ছোট',
	'ga-uploadsuccess' => 'আপলোড সফল',
	'ga-viewlist' => 'উপহারের তালিকা দেখাও',
	'system_gift_received_subject' => 'আপনি {{SITENAME}} সাইটে $1 পুরস্কার লাভ করেছেন!',
	'right-awardsmanage' => 'নতুন তৈরি এবং ইতিমধ্যেই থাকা পুরস্কারসমূহ সম্পাদনা করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'systemgiftmanager' => 'Reizhiad merañ ar profoù',
	'ga-addnew' => '+ Ouzhpennañ ur prof nevez',
	'ga-back-edit-gift' => 'Distreiñ da aozañ ar prof-mañ',
	'ga-back-gift-list' => 'Distreiñ da roll ar profoù',
	'ga-back-link' => '<a href="$1">< Distreiñ da brofil $2</a>',
	'ga-choosefile' => 'Dibab ur restr :',
	'ga-count' => '$1 en deus $2 {{PLURAL:$2|garedon|garedon}}.',
	'ga-create-gift' => 'Krouiñ ur prof',
	'ga-created' => 'Krouet eo bet ar prof',
	'ga-currentimage' => 'Skeudenn red',
	'ga-error-message-invalid-link' => "Direizh eo al liamm hoc'h eus ebarzhet.",
	'ga-error-message-no-user' => "N'eus ket eus an implijer emaoc'h o klask gwelet.",
	'ga-error-title' => "Hopala, kemeret hoc'h eus un hent fall !",
	'ga-file-instructions' => "Ret eo d'ho skeudenn bezañ er furmad jpeg, png pe gif (n'eo ket gif bev), ha ret eo d'he ment bezañ dindan 100 ko.",
	'ga-gift' => 'prof',
	'ga-gift-given-count' => 'Roet eo bet ar prof-mañ $1 {{PLURAL:$1|wech|gwech}}',
	'ga-gift-title' => '« $2 »  $1',
	'ga-giftdesc' => 'deskrivadur ar prof',
	'ga-giftimage' => 'skeudenn eus ar prof',
	'ga-giftname' => 'anv ar prof',
	'ga-gifttype' => 'seurt prof',
	'ga-goback' => 'Distreiñ',
	'ga-imagesbelow' => "Amañ dindan emañ ar skeudennoù a vo implijet war al lec'hienn",
	'ga-img' => "ouzhpennañ / erlec'hiañ ar skeudenn",
	'ga-large' => 'Bras',
	'ga-medium' => 'Etre',
	'ga-mediumlarge' => 'Etre-bras',
	'ga-new' => 'Nevez',
	'ga-next' => "War-lerc'h",
	'ga-previous' => 'Kent',
	'ga-recent-recipients-award' => 'Degemererien all eus ar garedon-mañ',
	'ga-saved' => 'Enrollet eo bet ar prof',
	'ga-small' => 'Bihan',
	'ga-threshold' => 'treuzoù',
	'ga-title' => 'Garedon $1',
	'ga-uploadsuccess' => 'Kaset eo bet mat',
	'ga-viewlist' => 'Gwelet roll ar profoù',
	'ga-cancel' => 'Nullañ',
	'ga-remove' => 'Dilemel',
	'ga-remove-title' => 'Dilemel "$1" ?',
	'topawards-edits' => 'Kemmoù',
	'topawards-votes' => 'Mouezhioù',
	'topawards-comments' => 'Evezhiadennoù',
	'topawards-friends' => 'Mignoned',
	'system_gift_received_subject' => "Resevet hoc'h eus ar garedon $1 war {{SITENAME}} !",
	'system_gift_received_body' => "Salud deoc'h, \$1.

Emaoc'h o paouez resev ar garedon \$2 war {{SITENAME}} !

\"\$3\"

Klikit war al liamm amañ dindan evit gwelet ho trofe !

\$4

Emichañs e plijo deoc'h !

Trugarez deoc'h,


Skipailh {{SITENAME}} 

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war \$5
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dra bostel.",
	'right-awardsmanage' => 'Krouiñ hag aozañ garedonoù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'systemgiftmanager' => 'Upravitelj sistemskih poklona',
	'ga-addnew' => '+ Dodaj novi poklon',
	'ga-back-edit-gift' => 'Nazad na uređivanje ovog poklona',
	'ga-back-gift-list' => 'Nazad na spisak poklona',
	'ga-back-link' => '<a href="$1">< Nazad na profil korisnika $2</a>',
	'ga-choosefile' => 'Odaberi datoteku:',
	'ga-count' => '$1 ima $2 {{PLURAL:$2|nagradu|nagrade|nagrada}}.',
	'ga-create-gift' => 'Napravi poklon',
	'ga-created' => 'Poklon je napravljen',
	'ga-currentimage' => 'Trenutna slika',
	'ga-error-message-invalid-link' => 'Link koji ste unijeli nije valjan.',
	'ga-error-message-no-user' => 'Korisnik kojeg pokušavate pogledati ne postoji.',
	'ga-error-title' => 'Ups, desilo nešto se nepredviđeno!',
	'ga-file-instructions' => 'Vaša slika treba biti jpeg, png ili gif (bez animiranih gif-ova) i mora biti manja od 100 kilobajta.',
	'ga-gift' => 'poklon',
	'ga-gift-given-count' => 'Ovaj poklon je poslan $1 {{PLURAL:$1|put|puta}}',
	'ga-gift-title' => '"$2" korisnika $1',
	'ga-giftdesc' => 'opis poklona',
	'ga-giftimage' => 'slika poklona',
	'ga-giftname' => 'naziv poklona',
	'ga-gifttype' => 'tip poklona',
	'ga-goback' => 'Idi nazad',
	'ga-imagesbelow' => 'Ispod se nalaze Vaše slike koje se koriste na ovom sajtu',
	'ga-img' => 'dodaj/zamijeni sliku',
	'ga-large' => 'Veliki',
	'ga-medium' => 'Srednji',
	'ga-mediumlarge' => 'Srednje-veliki',
	'ga-new' => 'Novi',
	'ga-next' => 'Slijedeći',
	'ga-previous' => 'Preth',
	'ga-recent-recipients-award' => 'Drugi nedavni primaoci ove nagrade',
	'ga-saved' => 'Poklon je sačuvan',
	'ga-small' => 'Malehni',
	'ga-threshold' => 'prag',
	'ga-title' => 'Nagrade korisnika $1',
	'ga-uploadsuccess' => 'Postavljanje uspješno',
	'ga-viewlist' => 'Pogledajte spisak poklona',
	'system_gift_received_subject' => 'Dobili ste $1 nagradu na {{SITENAME}}!',
	'system_gift_received_body' => 'Pozdrav $1.

Upravo ste dobili $2 nagradu na {{SITENAME}}!

"$3"

Kliknite ispod da pregledate Vašu kolekciju nagrada!

$4

Nadamo se da Vam se sviđa!

Hvala,


{{SITENAME}} tim

---

Hej, da li želite da prestanete dobivati e-mailove od nas?

Kliknite $5
i promijenite Vaše postavke onemogućavajući obavještenja putem emaila.',
	'right-awardsmanage' => 'Pravljenje novih i uređivanje postojećih nagrada',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'ga-giftdesc' => 'descripció del regal',
	'ga-giftimage' => 'imatge del regal',
	'ga-giftname' => 'nom del regal',
	'ga-gifttype' => 'tipus de regal',
	'ga-goback' => 'Torna enrerra',
	'ga-large' => 'Gran',
	'ga-medium' => 'Mitjà',
	'ga-mediumlarge' => 'Mitjà-llarg',
	'ga-new' => 'Nou',
	'ga-next' => 'Següent',
	'ga-previous' => 'Anterior',
	'ga-small' => 'Petit',
	'ga-threshold' => 'llindar',
	'ga-title' => 'Premis de $1',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'ga-goback' => 'گەڕانەوە بۆ دواوە',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'ga-large' => 'Velká',
	'ga-medium' => 'Střední',
	'ga-new' => 'Nová',
	'ga-next' => 'Další',
	'ga-previous' => 'Předchozí',
	'ga-small' => 'Malá',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'systemgiftmanager' => 'Verwaltung der Systemgeschenke',
	'ga-addnew' => '+ Neues Geschenk hinzufügen',
	'ga-back-edit-gift' => 'Zurück zur Geschenkbearbeitung',
	'ga-back-gift-list' => 'Zurück zur Geschenkeliste',
	'ga-back-link' => '<a href="$1">< Zurück zum Profil von $2</a>',
	'ga-choosefile' => 'Wähle Datei:',
	'ga-count' => '$1 hat $2 {{PLURAL:$2|Auszeichnung|Auszeichnungen}}.',
	'ga-create-gift' => 'Geschenk erstellen',
	'ga-created' => 'Das Geschenk wurde erstellt',
	'ga-currentimage' => 'Aktuelles Bild',
	'ga-error-message-invalid-link' => 'Der eingegebende Link ist ungültig.',
	'ga-error-message-no-user' => 'Der Benutzer, den du anschauen möchtest, existiert nicht.',
	'ga-error-title' => 'Ops, da ging etwas schief!',
	'ga-file-instructions' => 'Das Bild muss ein „JPEG“, „PNG“ oder ein nicht animiertes „GIF“ sein sowie eine Dateigröße unter 100 KB haben.',
	'ga-gift' => 'Geschenk',
	'ga-gift-given-count' => 'Dieses Geschenk wurde {{PLURAL:$1|einmal|$1 mal}} ausgegeben',
	'ga-gift-title' => '„$2“ von $1',
	'ga-giftdesc' => 'Geschenkbeschreibung',
	'ga-giftimage' => 'Geschenkabbildung',
	'ga-giftname' => 'Geschenkname',
	'ga-gifttype' => 'Geschenkart',
	'ga-goback' => 'gehe zurück',
	'ga-imagesbelow' => 'Hier drunter folgen alle Bilder, die auf dieser Seite genutzt werden',
	'ga-img' => 'Bild hinzufügen/entfernen',
	'ga-large' => 'Groß',
	'ga-medium' => 'Mittel',
	'ga-mediumlarge' => 'Mittelgroß',
	'ga-new' => 'Neu',
	'ga-next' => 'Nächste',
	'ga-previous' => 'Vorherige',
	'ga-recent-recipients-award' => 'Andere aktuelle Empfänger dieser Auszeichnung',
	'ga-saved' => 'Das Geschenk wurde gespeichert',
	'ga-small' => 'Schmal',
	'ga-threshold' => 'Schwelle',
	'ga-title' => 'Auszeichnungen von $1',
	'ga-uploadsuccess' => 'Hochladen erfolgreich',
	'ga-viewlist' => 'Geschenkeliste ansehen',
	'ga-cancel' => 'Abbrechen',
	'ga-remove' => 'Entfernen',
	'ga-remove-title' => '„$1“ entfernen?',
	'ga-delete-message' => 'Bist du dir sicher, das du das Geschenk „$1“ löschen möchtest?
Dies wird es auch bei Benutzern löschen, die es bereits erhalten haben.',
	'ga-remove-success-title' => 'Du hast das Geschenk „$1“ erfolgreich entfernt.',
	'ga-remove-success-message' => 'Das Geschenk „$1“ wurde entfernt.',
	'topawards' => 'Auszeichnungen',
	'topawards-edit-title' => 'Auszeichnungen - Meilensteine beim Bearbeiten',
	'topawards-vote-title' => 'Auszeichnungen - Meilensteine beim Abstimmen',
	'topawards-comment-title' => 'Auszeichnungen - Meilensteine beim Kommentieren',
	'topawards-recruit-title' => 'Auszeichnungen - Meilensteine beim Anwerben',
	'topawards-friend-title' => 'Auszeichnungen - Meilensteine bei Freunden',
	'topawards-award-categories' => 'Auszeichnungskategorien',
	'topawards-edits' => 'Bearbeitungen',
	'topawards-votes' => 'Stimmen',
	'topawards-comments' => 'Kommentare',
	'topawards-recruits' => 'Anwerbungen',
	'topawards-friends' => 'Freunde',
	'topawards-edit-milestone' => '{{PLURAL:$1|$1 Bearbeitung|$1 Bearbeitungen}}-Meilenstein,',
	'topawards-vote-milestone' => '{{PLURAL:$1|$1 Stimme|$1 Stimmen}}-Meilenstein',
	'topawards-comment-milestone' => '{{PLURAL:$1|$1 Kommentar|$1 Kommentare}}-Meilenstein',
	'topawards-recruit-milestone' => '{{PLURAL:$1|$1 Anwerbung|$1 Anwerbungen}}-Meilenstein',
	'topawards-friend-milestone' => '{{PLURAL:$1|$1 Freund|$1 Freunde}}-Meilenstein',
	'topawards-empty' => 'Entweder wurden für diese Auszeichnungskategorie noch keine Auszeichnungen konfiguriert, oder es hat noch niemand eine dieser Auszeichnungen erhalten.',
	'system_gift_received_subject' => '[{{SITENAME}}] Du hast die $1-Auszeichnung erhalten!',
	'system_gift_received_body' => 'Hallo $1,

du hast soeben die $2-Auszeichnung auf {{SITENAME}} erhalten!

„$3“

Klicke auf den nachfolgenden Link, um deine Trophäe anzusehen:

$4

Wir hoffen, sie gefällt dir!

Vielen Dank und viele Grüße,

Das {{SITENAME}}-Team

---

Du möchtest keine E-Mails von uns erhalten?

Klicke $5
und ändere deine Einstellungen so, dass E-Mail-Benachrichtigung deaktiviert sind.',
	'right-awardsmanage' => 'Neue erstellen und bestehende Auszeichnungen bearbeiten',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'ga-error-message-no-user' => 'Der Benutzer, den Sie anschauen möchten, existiert nicht.',
	'ga-delete-message' => 'Sind Sie sich sicher, das Sie das Geschenk „$1“ löschen möchten?
Dies wird es auch bei Benutzern löschen, die es bereits erhalten haben.',
	'ga-remove-success-title' => 'Sie haben das Geschenk „$1“ erfolgreich entfernt.',
	'system_gift_received_subject' => '[{{SITENAME}}]Sie haben die $1-Auszeichnung erhalten!',
	'system_gift_received_body' => 'Hallo $1,

Sie haben soeben die $2-Auszeichnung auf {{SITENAME}} erhalten!

„$3“

Klicken Sie auf den nachfolgenden Link, um Ihre Trophäe anzusehen:

$4

Wir hoffen, sie gefällt Ihnen!

Vielen Dank und viele Grüße,

Das {{SITENAME}}-Team

---

Sie möchten keine E-Mails von uns erhalten?

Klicken Sie $5
und ändern Sie Ihre Einstellungen so, dass E-Mail-Benachrichtigung deaktiviert sind.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'systemgiftmanager' => 'Zastojnik systemowych darow',
	'ga-addnew' => '+ Nowy dar pśidaś',
	'ga-back-edit-gift' => 'Slědk k wobźěłanjeju toś togo dara',
	'ga-back-gift-list' => 'Slědk k lisćinje darow',
	'ga-back-link' => '<a href="$1">< Slědk k profiloju wót $2</a>',
	'ga-choosefile' => 'Dataju wubraś:',
	'ga-count' => '$1 ma $2 {{PLURAL:$2|myto|myśe|myta|mytow}}.',
	'ga-create-gift' => 'Dar napóraś',
	'ga-created' => 'Dar jo se napórał.',
	'ga-currentimage' => 'Aktualny wobraz',
	'ga-error-message-invalid-link' => 'Wótkaz, kótaryž sy zapódał, jo njepłaśiwy.',
	'ga-error-message-no-user' => 'Wužywaŕ, kótaregož wopytujoš se woglědaś, njeeksistěrujo.',
	'ga-error-title' => 'Hopla, sy cynił něco wopaki!',
	'ga-file-instructions' => 'Twój wobraz musy typ jpeg, png abo gif (njeaniměerowany) měś a musy mjenjej ako 100 kb wjeliki byś.',
	'ga-gift' => 'dar',
	'ga-gift-given-count' => 'Toś ten dar jo se wudał {{PLURAL:$1|raz|dwójcy|$1 razy|$1 razow}}',
	'ga-gift-title' => '"$2" wót $1',
	'ga-giftdesc' => 'wopisanje dara',
	'ga-giftimage' => 'wobraz dara',
	'ga-giftname' => 'mě dara',
	'ga-gifttype' => 'typ dara',
	'ga-goback' => 'Źi slědk',
	'ga-imagesbelow' => 'Dołojce su twóje wobraze, kótarež wužywaju se na sedle.',
	'ga-img' => 'wobraz pśidaś/wuměniś',
	'ga-large' => 'Wjeliki',
	'ga-medium' => 'Srědny',
	'ga-mediumlarge' => 'Wósrědny',
	'ga-new' => 'Nowy',
	'ga-next' => 'Pśiducy',
	'ga-previous' => 'Pjerwjejšny',
	'ga-recent-recipients-award' => 'Druge aktualne dostawarje toś togo myta',
	'ga-saved' => 'Dar jo se składł.',
	'ga-small' => 'Mały',
	'ga-threshold' => 'prog',
	'ga-title' => 'Myta wót $1',
	'ga-uploadsuccess' => 'Nagraśe wuspěšne',
	'ga-viewlist' => 'Lisćinu darow se woglědaś',
	'system_gift_received_subject' => 'Sy dostał myto $1 na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Witaj $1.

Sy rowno dostał myto $2 na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

"$3"

Klikni dołojce, aby wiźeł swóju trofeju!

$4

Naźejamy se, až se śi spódaba!

Źěkujomy se,


Team {{GRAMMAR:genitiw|{{SITENAME}}}}

---

Njocoš wěcej e-mail wót nas dostaś?

Klikni na $5
a změń nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'right-awardsmanage' => 'Nowe myta napóraś a eksistěrujuce wobźěłaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'systemgiftmanager' => 'Διαχειριστής συστήματος δώρων',
	'ga-addnew' => '+ Προσθήκη νέου δώρου',
	'ga-back-edit-gift' => 'Πίσω στην επεξεργασία αυτού του δώρου',
	'ga-back-gift-list' => 'Πίσω στη λίστα δώρων',
	'ga-back-link' => '<a href="$1">< Πίσω στο προφίλ του $2</a>',
	'ga-choosefile' => 'Επιλογή αρχείου:',
	'ga-count' => 'Ο $1 έχει $2 {{PLURAL:$2|βραβείο|βραβεία}}.',
	'ga-create-gift' => 'Δημιουργία δώρου',
	'ga-created' => 'Το δώρο έχει δημιουργηθεί',
	'ga-currentimage' => 'Τρέχουσα εικόνα',
	'ga-error-message-invalid-link' => 'Ο σύνδεσμος που δώσατε δεν είναι έγκυρος.',
	'ga-error-message-no-user' => 'Ο χρήστης που προσπαθείτε να δείτε δεν υπάρχει.',
	'ga-error-title' => 'Ουπς, πήρες μια λάθος στροφή!',
	'ga-file-instructions' => 'Η εικόνα σας πρέπει να ειναι jpeg, png ή gif (όχι κινούμενα gif) και πρέπει να είναι λιγότερο από 100kb σε μέγεθος.',
	'ga-gift' => 'δώρο',
	'ga-gift-given-count' => 'Αυτό το δώρο έχει δοθεί $1 {{PLURAL:$1|φορά|φορές}}',
	'ga-gift-title' => '"$2" του $1',
	'ga-giftdesc' => 'περιγραφή δώρου',
	'ga-giftimage' => 'εικόνα δώρου',
	'ga-giftname' => 'όνομα δώρου',
	'ga-gifttype' => 'τύπος δώρου',
	'ga-goback' => 'Πήγαινε πίσω',
	'ga-imagesbelow' => 'Παρακάτω είναι οι εικόνες που θα χρησιμοποιηθούν στον ιστοτόπο',
	'ga-img' => 'προσθήκη/αντικατάσταση εικόνας',
	'ga-large' => 'Μεγάλος',
	'ga-medium' => 'Μέσος',
	'ga-mediumlarge' => 'Μεσαίο-μεγάλο',
	'ga-new' => 'Νέο',
	'ga-next' => 'Επομ',
	'ga-previous' => 'Προηγ',
	'ga-recent-recipients-award' => 'Άλλοι πρόσφατοι παραλήπτες του βραβείου',
	'ga-saved' => 'Το δώρο έχει αποθηκευθεί',
	'ga-small' => 'Μικρός',
	'ga-threshold' => 'κατώφλι',
	'ga-title' => 'Τα βραβεία του $1',
	'ga-uploadsuccess' => 'Επιτυχής φόρτωση',
	'ga-viewlist' => 'Προβολή λίστας δώρων',
	'system_gift_received_subject' => 'Έλαβες το $1 βραβείο στο {{SITENAME}}!',
	'system_gift_received_body' => 'Γεια $1.

Μόλις λάβατε το βραβείο $2 στο {{SITENAME}}.

"$3"

Κάνετε κλικ παρακάτω για να δείτε το τρόπαιό σας!

$4

Ελπίζουμε να σας αρέσει!

Ευχαριστούμε,


Η ομάδα του {{SITENAME}}

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $5
και αλλάξετε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'right-awardsmanage' => 'Δημιουργία νέων και επεξεργασία υπάρχοντων βραβείων',
);

/** Esperanto (Esperanto)
 * @author Lucas
 * @author Yekrats
 */
$messages['eo'] = array(
	'ga-addnew' => '+ Aldoni novan donacon',
	'ga-back-gift-list' => 'Reiri al donaclisto',
	'ga-choosefile' => 'Elekti dosieron:',
	'ga-count' => '$1 havas $2 {{PLURAL:$2|premion|premiojn}}.',
	'ga-create-gift' => 'Krei donacon',
	'ga-created' => 'La donaco estis kreita',
	'ga-currentimage' => 'Nuna bildo',
	'ga-gift' => 'donaco',
	'ga-gift-title' => '"$2" de $1',
	'ga-gifttype' => 'donaca speco',
	'ga-goback' => 'Reen',
	'ga-large' => 'Granda',
	'ga-medium' => 'Meza',
	'ga-mediumlarge' => 'Mezgranda',
	'ga-new' => 'Nova',
	'ga-next' => 'Poste',
	'ga-previous' => 'Antaŭe',
	'ga-saved' => 'La donaco estis konservita',
	'ga-small' => 'Malgranda',
	'ga-title' => 'Premioj de $1',
	'ga-uploadsuccess' => 'Alŝtuo sukcesis',
	'ga-viewlist' => 'Vidi donacan liston',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Mor
 */
$messages['es'] = array(
	'systemgiftmanager' => 'Administrador de sistema de regalos',
	'ga-addnew' => '+ Agregar nuevo regalo',
	'ga-back-edit-gift' => 'Regresar a editar este regalo',
	'ga-back-gift-list' => 'Regresar a la lista de regalos',
	'ga-back-link' => '<a href="$1">< regresar a perfil de $2</a>',
	'ga-choosefile' => 'Escoger archivo:',
	'ga-count' => '$1 tiene $2 {{PLURAL:$2|premio|premios}}.',
	'ga-create-gift' => 'Crear regalo',
	'ga-created' => 'El regalo ha sido creado',
	'ga-currentimage' => 'Imagen actual',
	'ga-error-message-invalid-link' => 'El enlace que ha introducido no es válido.',
	'ga-error-message-no-user' => 'El usuario que está tratando de ver no existe',
	'ga-error-title' => '¡Ups, usted tomó un giro equivocado!',
	'ga-file-instructions' => 'Tu imagen debe ser un jpeg, png o gif (no gif animado), y debe ser menor que 100kb en tamaño.',
	'ga-gift' => 'regalo',
	'ga-gift-given-count' => 'Este regalo ha sido enviado $1 {{PLURAL:$1|vez|veces}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descripción de regalo',
	'ga-giftimage' => 'imagen de regalo',
	'ga-giftname' => 'nombre de regalo',
	'ga-gifttype' => 'tipo de regalo',
	'ga-goback' => 'Volver',
	'ga-imagesbelow' => 'Debajo están sus imágenes que serán usadas en el sitio',
	'ga-img' => 'agregar/reemplazar imagen',
	'ga-large' => 'Grande',
	'ga-medium' => 'Medio',
	'ga-mediumlarge' => 'Medio-Grande',
	'ga-new' => 'Nuevo',
	'ga-next' => 'Próximo',
	'ga-previous' => 'Anterior',
	'ga-recent-recipients-award' => 'Otros receptores recientes de este premio',
	'ga-saved' => 'El regalo ha sido grabado',
	'ga-small' => 'Pequeño',
	'ga-threshold' => 'umbral',
	'ga-title' => 'premios de $1',
	'ga-uploadsuccess' => 'Carga exitosa',
	'ga-viewlist' => 'Ver lista de regalos',
	'system_gift_received_subject' => 'Usted ha recibido el premio $1 en {{SITENAME}}!',
	'system_gift_received_body' => 'Hola $1.

Acabas de recibir el premio $2 en {{SITENAME}}!

"$3"

¡Haz click abajo para ver tu vitrina de trofeos!

$4

¡Esperamos que te guste!

Gracias,


El equipo de {{SITENAME}}

---

Hey, ¿Deseas dejar de recibir correos nuestros?

Haz click en $5
y cambia tus configuraciones para deshabilitar notificaciones por correo electrónico.',
	'right-awardsmanage' => 'Crear nuevo y editar premios existentes',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'ga-choosefile' => 'Vali fail:',
	'ga-create-gift' => 'Loo kingitus',
	'ga-created' => 'Kingitus on loodud',
	'ga-currentimage' => 'Praegune pilt',
	'ga-gift' => 'kingitus',
	'ga-giftdesc' => 'kingituse kirjeldus',
	'ga-giftimage' => 'kingituse pilt',
	'ga-giftname' => 'kingituse nimi',
	'ga-gifttype' => 'kingituse tüüp',
	'ga-goback' => 'Tagasi',
	'ga-img' => 'lisa/vaheta pilt',
	'ga-large' => 'Suur',
	'ga-medium' => 'Keskmine',
	'ga-new' => 'Uus',
	'ga-next' => 'Järgmine',
	'ga-previous' => 'Eelmine',
	'ga-saved' => 'Kingitus on salvestatud',
	'ga-small' => 'Väike',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'ga-addnew' => '+ Opari berria gehitu',
	'ga-back-edit-gift' => 'Opari hau editatzeko itzuli',
	'ga-back-gift-list' => 'Oparien zerrendara itzuli',
	'ga-create-gift' => 'Oparia sortu',
	'ga-created' => 'Oparia sortu da',
	'ga-gift' => 'oparia',
	'ga-giftdesc' => 'opariaren deskribapena',
	'ga-giftimage' => 'opariaren irudia',
	'ga-giftname' => 'opariaren izena',
	'ga-gifttype' => 'opari mota',
	'ga-goback' => 'Atzera itzuli',
	'ga-img' => 'gehitu/ordeztu irudia',
	'ga-new' => 'Berria',
	'ga-next' => 'Hurrengoa',
	'ga-previous' => 'Aurrekoa',
	'ga-viewlist' => 'Oparien zerrenda ikusi',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'systemgiftmanager' => 'سامانه مدیریت هدیه',
	'ga-addnew' => '+ افزودن هدیه جدید',
	'ga-back-edit-gift' => 'بازگشت به ویرایش این هدیه',
	'ga-back-gift-list' => 'بازگشت به فهرست هدیه',
	'ga-choosefile' => 'انتخاب پرونده:',
	'ga-create-gift' => 'ایجاد هدیه',
	'ga-currentimage' => 'تصویر کنونی',
	'ga-gift' => 'هدیه',
	'ga-giftdesc' => 'توضیحات هدیه',
	'ga-giftimage' => 'تصویر هدیه',
	'ga-giftname' => 'نام هدیه',
	'ga-gifttype' => 'نوع هدیه',
	'ga-goback' => 'بازگشت به عقب',
	'ga-img' => 'افزودن/جایگزین تصویر',
	'ga-large' => 'بزرگ',
	'ga-medium' => 'متوسط',
	'ga-mediumlarge' => 'متوسط-بزرگ',
	'ga-new' => 'جدید',
	'ga-next' => 'بعدی',
	'ga-previous' => 'قبلی',
	'ga-saved' => 'هدیه ذخیره شده است',
	'ga-small' => 'کوچک',
	'ga-uploadsuccess' => 'بارگذاری موفق',
	'ga-viewlist' => 'مشاهده فهرست هدیه',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'systemgiftmanager' => 'Järjestelmälahjojen hallinta',
	'ga-addnew' => '+ Lisää uusi lahja',
	'ga-back-edit-gift' => 'Takaisin tämän lahjan muokkaamiseen',
	'ga-back-gift-list' => 'Takaisin lahjalistaan',
	'ga-back-link' => '<a href="$1">< Takaisin käyttäjän $2 profiiliin</a>',
	'ga-choosefile' => 'Valitse tiedosto:',
	'ga-count' => 'Käyttäjällä $1 on $2 {{PLURAL:$2|palkinto|palkintoa}}.',
	'ga-create-gift' => 'Luo lahja',
	'ga-created' => 'Lahja on luotu',
	'ga-currentimage' => 'Tämänhetkinen kuva',
	'ga-error-message-invalid-link' => 'Antamasi linkki on kelvoton.',
	'ga-error-message-no-user' => 'Käyttäjää, jota yrität katsoa, ei ole olemassa.',
	'ga-error-title' => 'Hups, astuit harhaan!',
	'ga-file-instructions' => 'Kuvasi tulee olla jpeg, png tai gif-muotoinen (ei animoituja gif-kuvia) ja sen tulee olla kooltaan alle 100Kb.',
	'ga-gift' => 'lahja',
	'ga-gift-given-count' => 'Tämä lahja on annettu $1 {{PLURAL:$1|kerran|kertaa}}',
	'ga-gift-title' => 'Käyttäjän $1 "$2"',
	'ga-giftdesc' => 'lahjan kuvaus',
	'ga-giftimage' => 'lahjan kuva',
	'ga-giftname' => 'lahjan nimi',
	'ga-gifttype' => 'lahjan tyyppi',
	'ga-goback' => 'Palaa takaisin',
	'ga-imagesbelow' => 'Alapuolella ovat kuvasi, joita käytetään sivustolla',
	'ga-img' => 'lisää tai korvaa kuva',
	'ga-large' => 'Suuri',
	'ga-medium' => 'Keskikokoinen',
	'ga-mediumlarge' => 'Keskikokoinen - suuri',
	'ga-new' => 'Uusi',
	'ga-next' => 'Seur.',
	'ga-previous' => 'Edell.',
	'ga-recent-recipients-award' => 'Muut tämän palkinnon tuoreet saajat',
	'ga-saved' => 'Lahja on tallennettu',
	'ga-small' => 'Pieni',
	'ga-threshold' => 'kynnys',
	'ga-title' => 'Käyttäjän $1 palkinnot',
	'ga-uploadsuccess' => 'Tallentaminen onnistui',
	'ga-viewlist' => 'Katso lahjalista',
	'ga-cancel' => 'Peruuta',
	'ga-remove' => 'Poista',
	'ga-remove-title' => 'Poista "$1"?',
	'ga-delete-message' => 'Oletko varma, että haluat poistaa lahjan "$1"?
Tämä poistaa sen myös käyttäjiltä, jotka ovat saattaneet saada sen.',
	'ga-remove-success-title' => 'Olet onnistuneesti poistanut lahjan "$1"',
	'ga-remove-success-message' => 'Lahja "$1" on poistettu.',
	'ga-user-got-awards' => '$1 sai palkinnon $2',
	'ga-awards-given-out' => '{{PLURAL:$1|Yksi palkinto|$1 palkintoa}} jaettiin',
	'system_gift_received_subject' => 'Olet saanut palkinnon $1 {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Hei $1:

Olet juuri saanut $2-palkinnon {{GRAMMAR:inessive|{{SITENAME}}}}!

"$3"

Napsauta alapuolella olevaa linkkiä tarkistaaksesi palkintorasiasi!

$4

Toivomme, että pidät siitä!

Kiittäen,


{{GRAMMAR:genitive|{{SITENAME}}}} tiimi

---

Hei, etkö halua enää saada sähköposteja meiltä?

Napsauta $5
ja muuta asetuksiasi poistaaksesi sähköpostitoiminnot käytöstä.',
	'right-awardsmanage' => 'Luoda uusia ja muokata olemassaolevia palkintoja',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author Hashar
 * @author IAlex
 * @author Od1n
 * @author PieRRoMaN
 * @author Verdy p
 */
$messages['fr'] = array(
	'systemgiftmanager' => 'Système de gestion de cadeaux',
	'ga-addnew' => '+ Ajouter un nouveau cadeau',
	'ga-back-edit-gift' => 'Revenir à la modification de ce cadeau',
	'ga-back-gift-list' => 'Revenir à la liste des cadeaux',
	'ga-back-link' => '<a href="$1">< Revenir au profil de $2</a>',
	'ga-choosefile' => 'Choisir le fichier :',
	'ga-count' => '$1 a {{PLURAL:$2|un prix|$2 prix}}.',
	'ga-create-gift' => 'Créer un cadeau',
	'ga-created' => 'Le cadeau a été créé',
	'ga-currentimage' => 'Image actuelle',
	'ga-error-message-invalid-link' => 'Le lien que vous avez entré est invalide.',
	'ga-error-message-no-user' => 'L’utilisateur que vous essayez de voir n’existe pas.',
	'ga-error-title' => 'Oops, vous avez pris un mauvais tour !',
	'ga-file-instructions' => 'Voir image doit être jpeg, png ou gif (mais pas animée) et doit être plus petite que 100 Ko.',
	'ga-gift' => 'cadeau',
	'ga-gift-given-count' => 'Ce cadeau a été donné {{PLURAL:$1|une fois|$1 fois}}',
	'ga-gift-title' => '« $2 » de $1',
	'ga-giftdesc' => 'description du cadeau',
	'ga-giftimage' => 'image du cadeau',
	'ga-giftname' => 'nom du cadeau',
	'ga-gifttype' => 'type de cadeau',
	'ga-goback' => 'Revenir',
	'ga-imagesbelow' => 'Les image qui seront utilisées sur ce site sont affichées ci-dessous',
	'ga-img' => 'ajouter / modifier l’image',
	'ga-large' => 'Grand',
	'ga-medium' => 'Moyen',
	'ga-mediumlarge' => 'Moyen-Grand',
	'ga-new' => 'Nouveau',
	'ga-next' => 'Suivant',
	'ga-previous' => 'Précédent',
	'ga-recent-recipients-award' => 'Autres bénéficiaires de ce prix',
	'ga-saved' => 'Ce cadeau a été sauvegardé',
	'ga-small' => 'Petit',
	'ga-threshold' => 'seuil',
	'ga-title' => 'Prix de $1',
	'ga-uploadsuccess' => 'Téléchargement effectué avec succès',
	'ga-viewlist' => 'Voir la liste des cadeaux',
	'ga-cancel' => 'Annuler',
	'ga-remove' => 'Supprimer',
	'ga-remove-title' => 'Supprimer "$1"?',
	'ga-delete-message' => 'Êtes-vous sûrs de vouloir supprimer le cadeau "$1"?
Cela le supprimera aussi pour les utilisateurs qui l\'auraient reçu.',
	'ga-remove-success-title' => 'Vous avez bien supprimé le cadeau "$1"',
	'ga-remove-success-message' => 'Le cadeau "$1" a été supprimé.',
	'topawards' => 'Premiers prix',
	'topawards-edit-title' => 'Premiers prix - Modifier les jalons',
	'topawards-vote-title' => 'Premiers prix - Voter pour les jalons',
	'topawards-comment-title' => 'Premiers prix - Commenter les jalons',
	'topawards-recruit-title' => 'Premiers prix - Recruter des jalons',
	'topawards-friend-title' => 'Premiers prix - Jalons amis',
	'topawards-award-categories' => 'Catégories de prix',
	'topawards-edits' => 'Éditions',
	'topawards-votes' => 'Votes',
	'topawards-comments' => 'Commentaires',
	'topawards-recruits' => 'Recrues',
	'topawards-friends' => 'Amis',
	'topawards-edit-milestone' => '{{PLURAL:$1|$1 modification|$1 modifications}} des jalons',
	'topawards-vote-milestone' => '{{PLURAL:$1|$1 vote|$1 votes}} pour le jalon',
	'topawards-comment-milestone' => '{{PLURAL:$1|$1 commentaire|$1 commentaires}} pour le jalon',
	'topawards-recruit-milestone' => '{{PLURAL:$1|$1 recrue|$1 recrues}} pour le jalon',
	'topawards-friend-milestone' => '{{PLURAL:$1|$1 ami|$1 amis}} pour le jalon',
	'topawards-empty' => "Soit il n'y a aucun prix configuré  pour cette catégorie, soit personne n'a encore obtenu ces prix.",
	'system_gift_received_subject' => 'Vous avez reçu le prix $1 sur {{SITENAME}} !',
	'system_gift_received_body' => 'Bonjour $1,

Vous avez reçu le prix $2 sur {{SITENAME}} !

« $3 »

Cliquez sur le lien ci-dessous pour voir votre trophée

$4

Nous espérons que l’apprécierez !

Merci,


L’équipe de {{SITENAME}}

---

Vous ne voulez plus recevoir de courriels de notre part ?

Cliquez $5
et modifiez vos préférences pour désactiver les notifications par courriel.',
	'right-awardsmanage' => 'Créer et modifier les prix existants',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'systemgiftmanager' => 'Sistèmo d’administracion de presents',
	'ga-addnew' => '+ Apondre un present novél',
	'ga-back-edit-gift' => 'Tornar u changement de ceti present',
	'ga-back-gift-list' => 'Tornar a la lista des presents',
	'ga-back-link' => '<a href="$1">< Tornar u profil de $2</a>',
	'ga-choosefile' => 'Chouèsir lo fichiér :',
	'ga-count' => '$1 at {{PLURAL:$2|yon prix|$2 prix}}.',
	'ga-create-gift' => 'Fâre un present',
	'ga-created' => 'Lo present at étâ fêt',
	'ga-currentimage' => 'Émâge d’ora',
	'ga-gift' => 'present',
	'ga-gift-given-count' => 'Ceti present at étâ balyê {{PLURAL:$1|yon côp|$1 côps}}',
	'ga-gift-title' => '« $2 » a $1',
	'ga-giftdesc' => 'dèscripcion du present',
	'ga-giftimage' => 'émâge du present',
	'ga-giftname' => 'nom du present',
	'ga-gifttype' => 'tipo de present',
	'ga-goback' => 'Tornar',
	'ga-img' => 'apondre / remplaciér l’émâge',
	'ga-large' => 'Grant',
	'ga-medium' => 'Moyen',
	'ga-mediumlarge' => 'Moyen-grant',
	'ga-new' => 'Novél',
	'ga-next' => 'Aprés',
	'ga-previous' => 'Devant',
	'ga-saved' => 'Lo present at étâ sôvâ',
	'ga-small' => 'Petiôt',
	'ga-threshold' => 'lendâr',
	'ga-title' => 'Prix a $1',
	'ga-uploadsuccess' => 'Tèlèchargement reussi',
	'ga-viewlist' => 'Vêre la lista des presents',
	'ga-cancel' => 'Anular',
	'ga-remove' => 'Enlevar',
	'ga-remove-title' => 'Enlevar « $1 » ?',
	'ga-remove-success-message' => 'Lo present « $1 » at étâ enlevâ.',
	'topawards' => 'Premiérs prix',
	'topawards-edit-title' => 'Premiérs prix - Jalons changements',
	'topawards-vote-title' => 'Premiérs prix - Jalons votos',
	'topawards-comment-title' => 'Premiérs prix - Jalons comentèros',
	'topawards-recruit-title' => 'Premiérs prix - Jalons recrues',
	'topawards-friend-title' => 'Premiérs prix - Jalons amis',
	'topawards-award-categories' => 'Catègories de prix',
	'topawards-edits' => 'Changements',
	'topawards-votes' => 'Votos',
	'topawards-comments' => 'Comentèros',
	'topawards-recruits' => 'Recrues',
	'topawards-friends' => 'Amis',
	'topawards-edit-milestone' => 'Jalon de $1 changement{{PLURAL:$1||s}}',
	'topawards-vote-milestone' => 'Jalon de $1 voto{{PLURAL:$1||s}}',
	'topawards-comment-milestone' => 'Jalon de $1 comentèro{{PLURAL:$1||s}}',
	'topawards-recruit-milestone' => 'Jalon de $1 recru{{PLURAL:$1|a|es}}',
	'topawards-friend-milestone' => 'Jalon de $1 ami{{PLURAL:$1||s}}',
	'system_gift_received_subject' => 'Vos éd reçu lo prix $1 dessus {{SITENAME}} !',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'systemgiftmanager' => 'Xestor de agasallos do sistema',
	'ga-addnew' => '+ Engadir un novo agasallo',
	'ga-back-edit-gift' => 'Volver ao editor de agasallos',
	'ga-back-gift-list' => 'Volver á lista de agasallos',
	'ga-back-link' => '<a href="$1">< Volver ao perfil de $2</a>',
	'ga-choosefile' => 'Elixir o ficheiro:',
	'ga-count' => '$1 ten $2 {{PLURAL:$2|premio|premios}}.',
	'ga-create-gift' => 'Crear un agasallo',
	'ga-created' => 'O agasallo foi creado',
	'ga-currentimage' => 'Imaxe actual',
	'ga-error-message-invalid-link' => 'A ligazón que inseriu é inválida.',
	'ga-error-message-no-user' => 'O usuario que está intentando ver non existe.',
	'ga-error-title' => 'Vaites, tomou un xiro erróneo!',
	'ga-file-instructions' => 'A súa imaxe debe ser jpeg, png ou gif (que non sexa animado), e debe ter un tamaño menor a 100kb.',
	'ga-gift' => 'agasallo',
	'ga-gift-given-count' => 'Este agasallo foi concedido {{PLURAL:$1|unha vez|$1 veces}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descrición do agasallo',
	'ga-giftimage' => 'imaxe do agasallo',
	'ga-giftname' => 'nome do agasallo',
	'ga-gifttype' => 'tipo de agasallo',
	'ga-goback' => 'Volver',
	'ga-imagesbelow' => 'Embaixo están as súas imaxes, que serán usadas no sitio',
	'ga-img' => 'engadir/substituír a imaxe',
	'ga-large' => 'Grande',
	'ga-medium' => 'Mediano',
	'ga-mediumlarge' => 'Mediano-Grande',
	'ga-new' => 'Novo',
	'ga-next' => 'Seguinte',
	'ga-previous' => 'Previo',
	'ga-recent-recipients-award' => 'Outros galardoados recentes con este agasallo',
	'ga-saved' => 'O agasallo foi gardado',
	'ga-small' => 'Pequeno',
	'ga-threshold' => 'límite',
	'ga-title' => 'Premios de $1',
	'ga-uploadsuccess' => 'Carga exitosa',
	'ga-viewlist' => 'Ver a lista dos agasallos',
	'ga-cancel' => 'Cancelar',
	'ga-remove' => 'Eliminar',
	'ga-remove-title' => 'Quere eliminar "$1"?',
	'ga-delete-message' => 'Está seguro de querer eliminar o agasallo "$1"?
Isto tamén o borrará dos usuarios que o recibiron.',
	'ga-remove-success-title' => 'Eliminou con éxito o agasallo "$1"',
	'ga-remove-success-message' => 'O agasallo "$1" foi eliminado.',
	'topawards' => 'Grandes premios',
	'topawards-edit-title' => 'Grandes premios - Metas de edición',
	'topawards-vote-title' => 'Grandes premios - Metas de votos',
	'topawards-comment-title' => 'Grandes premios - Metas de comentarios',
	'topawards-recruit-title' => 'Grandes premios - Metas de recrutas',
	'topawards-friend-title' => 'Grandes premios - Metas de amigos',
	'topawards-award-categories' => 'Categorías de premios',
	'topawards-edits' => 'Edicións',
	'topawards-votes' => 'Votos',
	'topawards-comments' => 'Comentarios',
	'topawards-recruits' => 'Recrutas',
	'topawards-friends' => 'Amigos',
	'topawards-edit-milestone' => 'Meta {{PLURAL:$1|dunha edición|de $1 edicións}}',
	'topawards-vote-milestone' => 'Meta {{PLURAL:$1|dun voto|de $1 votos}}',
	'topawards-comment-milestone' => 'Meta {{PLURAL:$1|dun comentario|de $1 comentarios}}',
	'topawards-recruit-milestone' => 'Meta {{PLURAL:$1|dun recruta|de $1 recrutas}}',
	'topawards-friend-milestone' => 'Meta {{PLURAL:$1|dun amigo|de $1 amigos}}',
	'topawards-empty' => 'Ou non hai ningún premio configurado para esta categoría de premios ou ben aínda ninguén obtivo estes premios.',
	'system_gift_received_subject' => 'Recibiu o premio $1 en {{SITENAME}}!',
	'system_gift_received_body' => 'Ola $1:

Acaba de recibir o premio $2 en {{SITENAME}}!

"$3"

Prema embaixo para ver o seu trofeo!

$4

Agardamos que lle guste!

Grazas,


O equipo de {{SITENAME}}

---

Quere deixar de recibir os nosos correos electrónicos?

Prema $5
e cambie as súas preferencias para desactivar as notificacións por correo electrónico.',
	'right-awardsmanage' => 'Crear novos agasallos e editar os existentes',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'ga-currentimage' => 'Παροῦσα εἰκών',
	'ga-gift' => 'δῶρον',
	'ga-gift-title' => '"$2" τοῦ $1',
	'ga-new' => 'Νέα',
	'ga-next' => 'Ἑπομ',
	'ga-previous' => 'Προηγ',
	'ga-threshold' => 'οὐδός',
	'ga-title' => 'Τὰ βραβεῖα τοῦ $1',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'systemgiftmanager' => 'Syschtem-Gschänkverwaltig',
	'ga-addnew' => '+ Nej Gschänk zuefiege',
	'ga-back-edit-gift' => 'Zrugg zum Bearbeite vu däm Gschänk',
	'ga-back-gift-list' => 'Zrugg zue dr Gschänklischt',
	'ga-back-link' => '<a href="$1">< Zrugg zum Profil vu $2</a>',
	'ga-choosefile' => 'Wehl e Datei:',
	'ga-count' => '$1 het $2 {{PLURAL:$2|Uuszeichnig|Uuszeichnige}}.',
	'ga-create-gift' => 'Gschänk aalege',
	'ga-created' => 'S Gschänk isch aagleit wore',
	'ga-currentimage' => 'Aktuäll Bild',
	'ga-error-message-invalid-link' => 'S Gleich, wu Du yygee hesch, isch nit giltig.',
	'ga-error-message-no-user' => 'Dr Benutzer, wu Du wetsch aaluege, git s nit.',
	'ga-error-title' => 'Hoppla, do lauft ebis scheps!',
	'ga-file-instructions' => 'S Bild muess e „jpeg“, „png“, „gif“ (kei animiert) syy, un d Dateigreßi muess chleiner syy wie 100 kb.',
	'ga-gift' => 'Gschänk',
	'ga-gift-given-count' => 'Des Gschänk isch scho $1 {{PLURAL:$1|Mol|Mol}} verschänkt wore',
	'ga-gift-title' => '„$2“ vu $1',
	'ga-giftdesc' => 'Bschryybig',
	'ga-giftimage' => 'Bild',
	'ga-giftname' => 'Name',
	'ga-gifttype' => 'Typ',
	'ga-goback' => 'Gang zrugg',
	'ga-imagesbelow' => 'Doo drunter chemme alli Bilder, wu uf däre Syte bruucht wäre',
	'ga-img' => 'Bild dryysetze / useneh',
	'ga-large' => 'Groß',
	'ga-medium' => 'Mittel',
	'ga-mediumlarge' => 'Mittelgroß',
	'ga-new' => 'Nej',
	'ga-next' => 'Negschti',
	'ga-previous' => 'Vorigi',
	'ga-recent-recipients-award' => 'Anderi, wu die Uuszeichnig iberchu hän',
	'ga-saved' => 'S Gschänk isch gspycheret wore',
	'ga-small' => 'Chlei',
	'ga-threshold' => 'Schwelli',
	'ga-title' => 'Uuszeichnige vu $1',
	'ga-uploadsuccess' => 'Erfolgryych uffeglade',
	'ga-viewlist' => 'Gschänklischt bschaue',
	'ga-cancel' => 'Abbräche',
	'ga-remove' => 'Usenee',
	'ga-remove-title' => '„$1“ usenee?',
	'ga-delete-message' => 'Bisch sicher, ass Du s Gschenk "$1" witt lesche? Derno wird s au bi Benutzer glescht, wu s scho iberchu hän.',
	'ga-remove-success-title' => 'Du hesch s Gschänk "$1" erfolgryych usegnu.',
	'ga-remove-success-message' => 'S Gschänk "$1" isch usegnu wore.',
	'topawards' => 'Usszeichnige',
	'topawards-edit-title' => 'Usszeichnige - Meilestai bim Bearbeite',
	'topawards-vote-title' => 'Usszeichnige - Meilestai bim Abstimme',
	'topawards-comment-title' => 'Usszeichnige - Meilestai bim Kommentiere',
	'topawards-recruit-title' => 'Usszeichnige - Meilestai bim Anwerbe',
	'topawards-friend-title' => 'Usszeichnige - Meilestai bim Fründ mache',
	'topawards-award-categories' => 'Usszeichnigskategorie',
	'topawards-edits' => 'Bearbeitige',
	'topawards-votes' => 'Stimme',
	'topawards-comments' => 'Kommentar',
	'topawards-recruits' => 'Aawerbige',
	'topawards-friends' => 'Fründ',
	'topawards-edit-milestone' => '{{PLURAL:$1|$1 Bearbeitigs|$1 Bearbeitige}}-Meilestai,',
	'topawards-vote-milestone' => '{{PLURAL:$1|$1 Stimm|$1 Stimme}}-Meilestai',
	'topawards-comment-milestone' => '{{PLURAL:$1|$1 Kommentar|$1 Kommentar}}-Meilestai',
	'topawards-recruit-milestone' => '{{PLURAL:$1|$1 Aawerbig|$1 Aawerbige}}-Meilestai',
	'topawards-friend-milestone' => '{{PLURAL:$1|$1 Fründ|$1 Fründ}}-Meilestai',
	'topawards-empty' => "Entweder git's für nie Usszeichnigskategori no kei Usszeichnige, oder es het no niemer eini vo dänne Usszeichnige übercho.",
	'system_gift_received_subject' => 'Du hesch d $1 Uuszeichnig iberchu uf {{SITENAME}}!',
	'system_gift_received_body' => 'Sali $1:

Du hesch grad d $2 Uuszeichnig iberchu uf {{SITENAME}}!

"$3"

Druck doo go die Uuszeichnig iberpriefe!

$4

Mir hoffe, s gfallt Dir!

Dankschen,


D Lyt vu {{SITENAME}}

---

Ha, Du wetsch gar keini E-Mai meh vun is iberchu?

Druck $5
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abstelle.',
	'right-awardsmanage' => 'Neji Uuszeichnige aalege un sonigi bearbeite wu s scho het',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'systemgiftmanager' => 'מנהל מתנות מערכתי',
	'ga-addnew' => '+ הוספת מתנה חדשה',
	'ga-back-edit-gift' => 'חזרה לעריכת מתנה זו',
	'ga-back-gift-list' => 'חזרה לרשימת המתנות',
	'ga-back-link' => '<a href="$1">< חזרה לפרופיל של $2</a>',
	'ga-choosefile' => 'בחירת קובץ:',
	'ga-count' => 'ל־$1 יש {{PLURAL:$2|פרס אחד|$2 פרסים}}.',
	'ga-create-gift' => 'יצירת מתנה',
	'ga-created' => 'המתנה נוצרה',
	'ga-currentimage' => 'התמונה הנוכחית',
	'ga-error-message-invalid-link' => 'הקישור שכתבתם אינו תקין.',
	'ga-error-message-no-user' => 'המשתמש שאתם מנסים לצפות בו אינו קיים.',
	'ga-error-title' => 'אופס, טעות בפנייה!',
	'ga-file-instructions' => 'על תמונתכם להיות מסוג jpeg, מסוג png או מסוג gif (לא מונפש), ועליה להיות קטנה מ־100 קילובייט.',
	'ga-gift' => 'מתנה',
	'ga-gift-given-count' => 'מתנה זו הוענקה {{PLURAL:$1|פעם אחת|$1 פעמים|פעמיים}}',
	'ga-gift-title' => 'ה־"$2" של $1',
	'ga-giftdesc' => 'תיאור המתנה',
	'ga-giftimage' => 'תמונת המתנה',
	'ga-giftname' => 'שם המתנה',
	'ga-gifttype' => 'סוג המתנה',
	'ga-goback' => 'חזרה',
	'ga-imagesbelow' => 'להלן תמונותיכם שתשמשנה באתר',
	'ga-img' => 'הוספה או החלפה של תמונה',
	'ga-large' => 'גדולה',
	'ga-medium' => 'בינונית',
	'ga-mediumlarge' => 'בינונית־גדולה',
	'ga-new' => 'חדשה',
	'ga-next' => 'הבאה',
	'ga-previous' => 'הקודמת',
	'ga-recent-recipients-award' => 'הענקות אחרות של פרס זה לאחרונה',
	'ga-saved' => 'המתנה נשמרה',
	'ga-small' => 'קטנה',
	'ga-threshold' => 'סף',
	'ga-title' => 'הפרסים של $1',
	'ga-uploadsuccess' => 'ההעלאה הושלמה בהצלחה',
	'ga-viewlist' => 'צפייה ברשימת המתנות',
	'system_gift_received_subject' => 'קיבלתם את פרס ה$1 ב{{grammar:תחילית|{{SITENAME}}}}!',
	'system_gift_received_body' => 'שלום $1.

הרגע קיבלתם את פרס ה$2 ב{{grammar:תחילית|{{SITENAME}}}}!

"$3"

לחצו להלן כדי לצפות בגביע שקיבלתם!

$4

אנו מקווים שתאהבו אותו!

רוב תודות,

צוות {{SITENAME}}

---

רוצים להפסיק לקבל מאיתנו הודעות בדוא"ל?

לחצו על $5
ושנו את הגדרותיכם לביטול התרעות בדוא"ל',
	'right-awardsmanage' => 'יצירת פרסים חדשים ועריכת פרסים קיימים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'systemgiftmanager' => 'Zrjadowak systemowych darow',
	'ga-addnew' => '+ Nowy dar přidać',
	'ga-back-edit-gift' => 'Wróćo k wobdźěłanju tutoho dara',
	'ga-back-gift-list' => 'Wróćo k lisćinje darow',
	'ga-back-link' => '<a href="$1">< Wróćo k profilej wot $2</a>',
	'ga-choosefile' => 'Wubjer dataju:',
	'ga-count' => '$1 ma $2 {{PLURAL:$2|myto|myće|myta|mytow}}.',
	'ga-create-gift' => 'Dar wutworić',
	'ga-created' => 'Dar bu wutworjeny.',
	'ga-currentimage' => 'Aktualny wobraz',
	'ga-error-message-invalid-link' => 'Wotkaz, kotryž sy zapodał, je njepłaćiwy.',
	'ga-error-message-no-user' => 'Wužiwar, kotrehož pospytuješ sej wobhladać, njeeksistuje.',
	'ga-error-title' => 'Hopla, sy něšto wopak činił!',
	'ga-file-instructions' => 'Twój wobraz dyrbi typ jpeg, png abo gif (žane animěrowane gif) měć a mjeńši hač 100 kb być.',
	'ga-gift' => 'dar',
	'ga-gift-given-count' => 'Tutón dar bu {{PLURAL:$1|jedyn raz|dwójce|$1 razy|$1 razow}} wudaty',
	'ga-gift-title' => '"$2" wot $1',
	'ga-giftdesc' => 'wopisanje dara',
	'ga-giftimage' => 'wobraz dara',
	'ga-giftname' => 'mjeno dara',
	'ga-gifttype' => 'typ dara',
	'ga-goback' => 'Wróćo',
	'ga-imagesbelow' => 'Deleka su twoje wobrazy, kotrež so na sydle wužiwaja',
	'ga-img' => 'Wobraz přidać/narunać',
	'ga-large' => 'Wulki',
	'ga-medium' => 'Srěni',
	'ga-mediumlarge' => 'Srěnjowulki',
	'ga-new' => 'Nowy',
	'ga-next' => 'Přichodny',
	'ga-previous' => 'Předchadny',
	'ga-recent-recipients-award' => 'Druzy aktualni přijimowarjo tutoho myta',
	'ga-saved' => 'Dar bu składowany',
	'ga-small' => 'Mały',
	'ga-threshold' => 'próh',
	'ga-title' => 'Myta wot $1',
	'ga-uploadsuccess' => 'Nahraće wuspěšne',
	'ga-viewlist' => 'Lisćinu darow sej wobhladać',
	'system_gift_received_subject' => 'Sy myto $1 na {{GRAMMAR:lokatiw|{{SITENAME}}}} dóstał!',
	'system_gift_received_body' => 'Witaj $1.

Sy runje myto $2 na {{GRAMMAR:lokatiw|{{SITENAME}}}} dóstał!

"$3"

Klikń deleka, zo by sej swoju trofeju wobhladał!

$4

Nadźijamy so, zo so ći spodoba!

Dźakujemy so,

Team {{SITENAME}}

---

Hej, hižo nochceš nam e-mejle słać?

Klikń na $5
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'right-awardsmanage' => 'Nowe myta wutworić a eksistowace wobdźěłać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'systemgiftmanager' => 'Rendszerajándékok kezelése',
	'ga-addnew' => '+ Új ajándék hozzáadása',
	'ga-back-edit-gift' => 'Vissza ezen ajándék szerkesztéséhez',
	'ga-back-gift-list' => 'Vissza az ajándékok listájához',
	'ga-back-link' => '<a href="$1">< vissza $2 profiljára</a>',
	'ga-choosefile' => 'Fájl kiválasztása:',
	'ga-count' => '$1 felhasználónak $2 díja van.',
	'ga-create-gift' => 'Ajándék készítése',
	'ga-created' => 'Az ajándék elkészült',
	'ga-currentimage' => 'Jelenlegi kép',
	'ga-error-message-invalid-link' => 'A megadott hivatkozás érvénytelen.',
	'ga-error-message-no-user' => 'A felhasználó, akit meg próbáltál tekinteni nem létezik.',
	'ga-error-title' => 'Hoppá, eltévedtél!',
	'ga-file-instructions' => 'A képnek jpeg, png vagy (nem animált) gif formátumúnak, és 100 KB-nál kisebb méretűnek kell lennie.',
	'ga-gift' => 'ajándék',
	'ga-gift-given-count' => 'Ezt az ajándékot $1 alkalommal adták át.',
	'ga-gift-title' => '$1 „$2” ajándéka',
	'ga-giftdesc' => 'ajándék leírása',
	'ga-giftimage' => 'ajándék képe',
	'ga-giftname' => 'ajándék neve',
	'ga-gifttype' => 'ajándék típusa',
	'ga-goback' => 'Visszalépés',
	'ga-imagesbelow' => 'Alább láthatóak a képeid, amelyek használva lesznek az oldalon',
	'ga-img' => 'kép hozzáadása/cseréje',
	'ga-large' => 'Nagy',
	'ga-medium' => 'Közepes',
	'ga-mediumlarge' => 'Középnagy',
	'ga-new' => 'Új',
	'ga-next' => 'Következő',
	'ga-previous' => 'Előző',
	'ga-recent-recipients-award' => 'A többiek, akik a közelmúltban megkapták e díjat',
	'ga-saved' => 'Az ajándék elmentve',
	'ga-small' => 'Kicsi',
	'ga-threshold' => 'küszöb',
	'ga-title' => '$1 díjai',
	'ga-uploadsuccess' => 'Sikeres feltöltés',
	'ga-viewlist' => 'Ajándékok listájának megtekintése',
	'system_gift_received_subject' => 'Megkaptad a(z) $1 díjat a(z) {{SITENAME}} oldalon!',
	'system_gift_received_body' => 'Szia $1!

Épp most kaptad meg a(z) $2 díjat a(z) {{SITENAME}} oldalon!

„$3”

Kattints alant, hogy megnézd!

$4

Reméljük tetszeni fog!

Köszönettel,

A(z) {{SITENAME}} oldal csapata


~~
Szeretnéd ha nem zaklatnánk több e-maillel?

Kattints a linkre: $5
és tiltsd le az e-mail értesítéseket a beállításaidban',
	'right-awardsmanage' => 'Új díjak készítése vagy meglevők szerkesztése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'systemgiftmanager' => 'Gerente de donos del systema',
	'ga-addnew' => '+ Adder un nove dono',
	'ga-back-edit-gift' => 'Retornar a modificar iste dono',
	'ga-back-gift-list' => 'Retornar al lista de donos',
	'ga-back-link' => '<a href="$1">< Retornar al profilo de $2</a>',
	'ga-choosefile' => 'Selige un file:',
	'ga-count' => '$1 ha $2 {{PLURAL:$2|premio|premios}}.',
	'ga-create-gift' => 'Crear un dono',
	'ga-created' => 'Le dono ha essite create',
	'ga-currentimage' => 'Imagine actual',
	'ga-error-message-invalid-link' => 'Le ligamine que tu ha entrate es invalide.',
	'ga-error-message-no-user' => 'Le usator que tu tenta vider non existe.',
	'ga-error-title' => 'Ups, tu ha errate!',
	'ga-file-instructions' => 'Tu imagine debe esser in formato jpeg, png o gif (sin animation), e debe esser minus grande que 100kb.',
	'ga-gift' => 'dono',
	'ga-gift-given-count' => 'Iste dono ha essite date $1 {{PLURAL:$1|vice|vices}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'description del dono',
	'ga-giftimage' => 'imagine del dono',
	'ga-giftname' => 'nomine del dono',
	'ga-gifttype' => 'typo de dono',
	'ga-goback' => 'Retornar',
	'ga-imagesbelow' => 'Infra se trova tu imagines que essera usate in le sito',
	'ga-img' => 'adder/reimplaciar imagine',
	'ga-large' => 'Grande',
	'ga-medium' => 'Medie',
	'ga-mediumlarge' => 'Medie-grande',
	'ga-new' => 'Nove',
	'ga-next' => 'Proxime',
	'ga-previous' => 'Previe',
	'ga-recent-recipients-award' => 'Altere ganiatores recente de iste premio',
	'ga-saved' => 'Le dono ha essite salveguardate',
	'ga-small' => 'Parve',
	'ga-threshold' => 'limine',
	'ga-title' => 'Le premios de $1',
	'ga-uploadsuccess' => 'Incargamento succedite',
	'ga-viewlist' => 'Vider le lista de donos',
	'ga-cancel' => 'Cancellar',
	'ga-remove' => 'Remover',
	'ga-remove-title' => 'Remover "$1"?',
	'ga-delete-message' => 'Es tu secur que tu vole deler le dono "$1"? Isto va equalmente deler lo de omne usator qui lo ha recipite.',
	'ga-remove-success-title' => 'Tu ha removite le dono "$1" con successo',
	'ga-remove-success-message' => 'Le dono "$1" ha essite removite.',
	'topawards' => 'Top de premios',
	'topawards-edit-title' => 'Top de premios - Successos de modification',
	'topawards-vote-title' => 'Top de premios - Successos de votation',
	'topawards-comment-title' => 'Top de premios - Successos de commento',
	'topawards-recruit-title' => 'Top de premios - Successos de recrutamento',
	'topawards-friend-title' => 'Top de premios - Successos de amicitate',
	'topawards-award-categories' => 'Categorias de premio',
	'topawards-edits' => 'Modificationes',
	'topawards-votes' => 'Votos',
	'topawards-comments' => 'Commentos',
	'topawards-recruits' => 'Recrutas',
	'topawards-friends' => 'Amicos',
	'topawards-edit-milestone' => 'Successo de $1 {{PLURAL:$1|modification|modificationes}}',
	'topawards-vote-milestone' => 'Successo de $1 {{PLURAL:$1|voto|votos}}',
	'topawards-comment-milestone' => 'Successo de $1 {{PLURAL:$1|commento|commentos}}',
	'topawards-recruit-milestone' => 'Successo de $1 {{PLURAL:$1|recruta|recrutas}}',
	'topawards-friend-milestone' => 'Successo de $1 {{PLURAL:$1|amico|amicos}}',
	'topawards-empty' => 'O il non ha premios configurate pro iste categoria, o nemo ha ancora recipite iste premios.',
	'system_gift_received_subject' => 'Tu ha recipite le premio $1 in {{SITENAME}}!',
	'system_gift_received_body' => 'Salute $1.

Tu ha justo recipite le premio $2 in {{SITENAME}}!

"$3"

Clicca infra pro vider tu armario de tropheos!

$4

Nos spera que isto te place!

Gratias,


Le equipa de {{SITENAME}}

---

Tu non vole reciper plus messages de nos?

Clicca $5
e disactiva in tu preferentias le notificationes per e-mail.',
	'right-awardsmanage' => 'Crear nove premios e modificar existentes',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 */
$messages['id'] = array(
	'systemgiftmanager' => 'Sistem pengelolaan hadiah',
	'ga-addnew' => '+ Tambahkan hadiah baru',
	'ga-back-edit-gift' => 'Kembali untuk menyunting hadiah ini',
	'ga-back-gift-list' => 'Kembali ke daftar hadiah',
	'ga-back-link' => '<a href="$1">< Kembali ke profil $2</a>',
	'ga-choosefile' => 'Pilih berkas:',
	'ga-count' => '$1 memiliki $2 {{PLURAL:$2|penghargaan|penghargaan}}.',
	'ga-create-gift' => 'Buat hadiah',
	'ga-created' => 'Hadiah sudah dibuat',
	'ga-currentimage' => 'Gambar saat ini',
	'ga-error-message-invalid-link' => 'Pranala yang anda masukkan tidak benar.',
	'ga-error-message-no-user' => 'Pengguna yang anda coba buka tidak ada.',
	'ga-error-title' => 'Aduh, anda salah belok!',
	'ga-file-instructions' => 'Gambar anda harus jpeg, png atau gif (tanpa animasi), dan ukurannya tidak boleh lebih dari 100kb.',
	'ga-gift' => 'hadiah',
	'ga-gift-given-count' => 'Hadiah ini telah diberikan $1 {{PLURAL:$1|kali|kali}}',
	'ga-gift-title' => '$1 "$2"',
	'ga-giftdesc' => 'penjelasan hadiah',
	'ga-giftimage' => 'gambar hadiah',
	'ga-giftname' => 'nama hadiah',
	'ga-gifttype' => 'tipe hadiah',
	'ga-goback' => 'Kembali',
	'ga-imagesbelow' => 'Di bawah ini adalah gambar-gambar yang akan digunakan di situs',
	'ga-img' => 'tambahkan/ganti gambar',
	'ga-large' => 'Besar',
	'ga-medium' => 'Menengah',
	'ga-mediumlarge' => 'Sedang-besar',
	'ga-new' => 'Baru',
	'ga-next' => 'Selanjutnya',
	'ga-previous' => 'Sebelumnya',
	'ga-recent-recipients-award' => 'Penerima lain penghargaan ini',
	'ga-saved' => 'Hadiah sudah disimpan',
	'ga-small' => 'Kecil',
	'ga-threshold' => 'ambang batas',
	'ga-title' => '$1 hadiah',
	'ga-uploadsuccess' => 'Sukses mengunggah',
	'ga-viewlist' => 'Lihat daftar hadiah',
	'system_gift_received_subject' => 'Anda mendapatkan $1 piala di {{SITENAME}}!',
	'system_gift_received_body' => 'Hai $1.

Anda baru menerima $2 penghargaan di {{SITENAME}}!

"$3"

Klik di bawah untuk mengetahui jenis penghargaan Anda!

$4

Kami harap Anda menyukainya!

Terima kasih,


{{SITENAME}} tim

---

Ingin berhenti mendapatkan surel dari kami?

Klik $5
dan ubah setting anda untuk menonaktifkan notifikasi surel.',
	'right-awardsmanage' => 'Buat baru dan sunting penghargaan yang ada',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'ga-small' => 'Ntàkiri',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'ga-goback' => 'Indietro',
	'ga-large' => 'Grande',
	'ga-medium' => 'Medio',
	'ga-new' => 'Nuovo',
	'ga-next' => 'Succ',
	'ga-previous' => 'Prec',
	'ga-small' => 'Piccolo',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'systemgiftmanager' => 'システムからの贈り物の管理',
	'ga-addnew' => '+ 新しい贈り物を追加',
	'ga-back-edit-gift' => '戻ってこの贈り物を編集する',
	'ga-back-gift-list' => '贈り物一覧へ戻る',
	'ga-back-link' => '<a href="$1">< $2のプロフィールへ戻る</a>',
	'ga-choosefile' => 'ファイルを選ぶ:',
	'ga-count' => '$1 は$2{{PLURAL:$2|回}}表彰されています',
	'ga-create-gift' => '贈り物を作成',
	'ga-created' => '贈り物を作成しました',
	'ga-currentimage' => '現在の画像',
	'ga-error-message-invalid-link' => '入力されたリンクは無効です',
	'ga-error-message-no-user' => '表示しようとした利用者は存在しません。',
	'ga-error-title' => 'おっと、手順を間違えたようです！',
	'ga-file-instructions' => '使用できる画像は jpeg、png、または gif (gifアニメーション除く)で、サイズが100kb以下のものです。',
	'ga-gift' => '贈り物',
	'ga-gift-given-count' => 'この贈り物はいままでに$1{{PLURAL:$1|回}}贈られています',
	'ga-gift-title' => '$1の「$2」',
	'ga-giftdesc' => '贈り物の説明',
	'ga-giftimage' => '贈り物用画像',
	'ga-giftname' => '贈り物名',
	'ga-gifttype' => '贈り物の種類',
	'ga-goback' => '戻る',
	'ga-imagesbelow' => '以下はこのサイトであなたの画像として使用されている画像です',
	'ga-img' => '画像を追加もしくは置き換え',
	'ga-large' => '大',
	'ga-medium' => '中',
	'ga-mediumlarge' => '中大',
	'ga-new' => '新規',
	'ga-next' => '次',
	'ga-previous' => '前',
	'ga-recent-recipients-award' => 'ほかにこの賞を最近受けた人',
	'ga-saved' => '贈り物を保存しました',
	'ga-small' => '小',
	'ga-threshold' => '閾値',
	'ga-title' => '$1のもらった賞',
	'ga-uploadsuccess' => 'アップロード成功',
	'ga-viewlist' => '贈り物一覧を見る',
	'system_gift_received_subject' => '{{SITENAME}}にて$1賞を受けました',
	'system_gift_received_body' => '$1さん、こんにちは。

$1さんは、{{SITENAME}}にて$2賞を受賞されました！

「$3」

トロフィー入れを確認するには下のリンクをクリックしてください！

$4

お気に入れば幸いです！

{{SITENAME}}チーム

---
メール受信を停止したい場合は、
$5
をクリックして、メール通知を無効にするよう設定変更してください。',
	'right-awardsmanage' => '賞の編集・新規作成',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'ga-addnew' => '+ បន្ថែម​អំណោយ​ថ្មី​',
	'ga-back-gift-list' => 'ត្រឡប់ទៅកាន់បញ្ជីអំណោយ​',
	'ga-create-gift' => 'បង្កើត​អំណោយ',
	'ga-created' => 'អំណោយ​ត្រូវ​បាន​បង្កើត​',
	'ga-currentimage' => 'រូបភាពបច្ចុប្បន្ន',
	'ga-gift' => 'អំណោយ​',
	'ga-large' => 'ធំ​',
	'ga-medium' => 'មធ្យម​',
	'ga-mediumlarge' => 'ធំគួរសម',
	'ga-new' => 'ថ្មី​',
	'ga-next' => 'បន្ទាប់​',
	'ga-previous' => 'មុន​',
	'ga-small' => 'តូច​',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'ga-new' => 'ಹೊಸ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'systemgiftmanager' => 'Jeschenke vum Süstem verwallde',
	'ga-addnew' => '+ Neu Jeschenk dobei donn',
	'ga-back-edit-gift' => 'Jangk retuur un donn dat Jeschengk beärbeide',
	'ga-back-gift-list' => 'Jangk retuur op de Leß met de Jeschengke',
	'ga-back-link' => '<a href="$1">← Jangk retuur noh däm „$2“ singem Profil</a>',
	'ga-choosefile' => 'Sök en Datei uß:',
	'ga-count' => 'Dä Metmaacher „$1“ hät {{PLURAL:$2|eij <span class="plainlinks">gif</span> hann, ävver Belohnung|$2 Belohnunge|keij Belohnung}}.',
	'ga-create-gift' => 'Jeschenk aanlääje',
	'ga-created' => 'Dat Jeschenk es jez aanjelaat',
	'ga-currentimage' => 'Dat aktoälle Beld',
	'ga-error-message-invalid-link' => 'Do häss_enne unjöltijje Lengk enjejovve.',
	'ga-error-message-no-user' => 'Dä Metmaacher jidd_et nit, däm De aanloore wells.',
	'ga-error-title' => 'Och, do es jet donevve jejange!',
	'ga-file-instructions' => 'Ding Beld-Datei moß et Fommaat <code>jpeg</code>, <code>png</code>, odder <span class="plainlinks">gif</span> hann, ävver annimeete <span class="plainlinks">gif</span> donn et nit, un moß ene Dateiömfang fun 100&nbsp;KB odder winnijer han.',
	'ga-gift' => 'Jeschenk',
	'ga-gift-given-count' => 'Dat jeschenk wood {{PLURAL:$1|eijmol|$1 mol|noch nie}} ußjejovve.',
	'ga-gift-title' => 'Däm $1 sing „$2“',
	'ga-giftdesc' => 'Jeschenk beschrieve',
	'ga-giftimage' => 'Beld vun däm Jeschenk',
	'ga-giftname' => 'Name vum Jeschenk',
	'ga-gifttype' => 'Zoot vun jeschenk',
	'ga-goback' => 'Jangk Retuur',
	'ga-imagesbelow' => 'Hee drunger sin Ding Belder, die hee jebruch wäde',
	'ga-img' => 'Beld dobei donn udder ußtuusche',
	'ga-large' => 'Jruß',
	'ga-medium' => 'Meddel bes kleijn',
	'ga-mediumlarge' => 'Meddel bes jrooß',
	'ga-new' => 'Neu',
	'ga-next' => 'Nächs',
	'ga-previous' => 'Vörije',
	'ga-recent-recipients-award' => 'Andere Metmaacher, die die Belohnung krääje han',
	'ga-saved' => 'Dat Jeschenk es afjeshpeichert',
	'ga-small' => 'Kleijn',
	'ga-threshold' => 'Grenz ov Schwell',
	'ga-title' => 'Dem $1 sing Belohnunge',
	'ga-uploadsuccess' => 'Dat Huhlaade hät jeflupp',
	'ga-viewlist' => 'Leß met Jeschenke aanloore',
	'system_gift_received_subject' => 'Do häs {{GRAMMAR:em|{{SITENAME}}}} de Belohnung „$1“ krääje!',
	'system_gift_received_body' => 'Joden Daach $1,

{{GRAMMAR:em|{{SITENAME}}}} häs De jrad de Belohung $2 bekumme!

„$3“

Jangl op die Sigg hee, un don Ding Sammlung vun Belohnunge beloore:

$4

Mer hoffe, Do maachs dat!

Mer bedanke uns.

---

Wells de kein e-mail mieh vun uns krijje?

Dann jangk noh $5
un donn en Dinge Ensstellunge de Nohrechte övver e-mail affschallde.',
	'right-awardsmanage' => 'Belohnunge ändere udder neu aanlööje',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author Welathêja
 */
$messages['ku-latn'] = array(
	'ga-new' => 'Nû',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'ga-addnew' => '+ Neie Cadeau derbäisetzen',
	'ga-back-edit-gift' => "Zréck fir dëse Cadeau z'änneren",
	'ga-back-gift-list' => "Zréck op d'Lëscht vun de Cadeauen",
	'ga-back-link' => '<a href="$1">< Zréck op dem $2 säi Profil</a>',
	'ga-choosefile' => 'Wielt e Fichier:',
	'ga-count' => '$1 huet $2 {{PLURAL:$2|Auszeechnung|Auszeechnungen}}.',
	'ga-create-gift' => 'Cadeau uleeën',
	'ga-created' => 'De Cadeau gouf ugeluecht',
	'ga-currentimage' => 'Aktuellt Bild',
	'ga-error-message-invalid-link' => 'De Link deen Dir uginn hutt ass net valabel.',
	'ga-error-message-no-user' => 'De Benotzer, deen Dir kucke wëllt, gëtt et net.',
	'ga-error-title' => 'Ups, Dir hutt e falsche Wee gewielt!',
	'ga-file-instructions' => 'Är Bild muss e jpeg, png oder gif (keng animéiert Gifen) a muss méi kleng si wéi 100 kb.',
	'ga-gift' => 'Cadeau',
	'ga-gift-given-count' => 'Dëse Cadeau gouf $1 {{PLURAL:$1|mol gemaach|mol gemaach}}',
	'ga-gift-title' => '"$2" vum $1',
	'ga-giftdesc' => 'Bechreiwung vum Cadeau',
	'ga-giftimage' => 'Bild vum Cadeau',
	'ga-giftname' => 'Numm vum Cadeau',
	'ga-gifttype' => 'Typ vu Cadeau',
	'ga-goback' => 'Zréckgoen',
	'ga-imagesbelow' => 'Hei ënnendrënner sinn Är Biller déi um Site benotzt wäerte ginn',
	'ga-img' => 'Bild derbäisetzen/ersetzen',
	'ga-large' => 'Grouss',
	'ga-medium' => 'Mëttel',
	'ga-mediumlarge' => 'Mëttelgrouss',
	'ga-new' => 'Nei',
	'ga-next' => 'Nächst',
	'ga-previous' => 'Vireg',
	'ga-recent-recipients-award' => 'Anerer déi dës Auszeechnung viru kuerzem kritt hunn',
	'ga-saved' => 'De Cadeau gouf gespäichert',
	'ga-small' => 'Kleng',
	'ga-threshold' => 'Limit',
	'ga-title' => 'Dem $1 seng Auszeechnungen',
	'ga-uploadsuccess' => 'Eroplueden ofgeschloss',
	'ga-viewlist' => 'Lëscht vun de Cadeaue kucken',
	'system_gift_received_subject' => "Dir hutt d'$1-Auszeechnung op {{SITENAME}}!",
	'right-awardsmanage' => 'Nei Auszeechnungen uleeën a bestoender änneren',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'systemgiftmanager' => 'Раководител со системски подароци',
	'ga-addnew' => '+ Додај нов подарок',
	'ga-back-edit-gift' => 'Назад кон уредувањето на овој подарок',
	'ga-back-gift-list' => 'Назад кон списокот на подароци',
	'ga-back-link' => '<a href="$1">< Назад кон профилот на $2</a>',
	'ga-choosefile' => 'Одберете податотека:',
	'ga-count' => '$1 има $2 {{PLURAL:$2|награда|награди}}.',
	'ga-create-gift' => 'Создај подарок',
	'ga-created' => 'Подарокот е создаден',
	'ga-currentimage' => 'Тековна слика',
	'ga-error-message-invalid-link' => 'Внесената врска е неважечка.',
	'ga-error-message-no-user' => 'Корисникот кој сакате да го видите не постои.',
	'ga-error-title' => 'Упс, направивте погрешен потег!',
	'ga-file-instructions' => 'Сликата мора да биде од типот jpeg, png или gif (но не анимиран gif), и мора да биде помала од 100кб.',
	'ga-gift' => 'подарок',
	'ga-gift-given-count' => 'Овој подарок досега е подаруван $1 {{PLURAL:$1|пат|пати}}',
	'ga-gift-title' => '„$2“ на $1',
	'ga-giftdesc' => 'опис на подарокот',
	'ga-giftimage' => 'слика на подарокот',
	'ga-giftname' => 'име на подарокот',
	'ga-gifttype' => 'тип на подарок',
	'ga-goback' => 'Назад',
	'ga-imagesbelow' => 'Подолу се наоѓаат сликите коишто ќе се користат на мрежното место',
	'ga-img' => 'додај/замени слика',
	'ga-large' => 'Голем',
	'ga-medium' => 'Среден',
	'ga-mediumlarge' => 'Средно-голем',
	'ga-new' => 'Нов',
	'ga-next' => 'Следен',
	'ga-previous' => 'Претходен',
	'ga-recent-recipients-award' => 'Други скорешни добитници на оваа награда',
	'ga-saved' => 'Подарокот е зачуван',
	'ga-small' => 'Мал',
	'ga-threshold' => 'праг',
	'ga-title' => 'Наградите на $1',
	'ga-uploadsuccess' => 'Подигањето е успешно',
	'ga-viewlist' => 'Прикажи список на подароци',
	'ga-cancel' => 'Откажи',
	'ga-remove' => 'Отстрани',
	'ga-remove-title' => 'Да го отстранам „$1“?',
	'ga-delete-message' => 'Дали сте сигурни дека сакате да го избришете подарокот „$1“?
Со ова истиот ќе биде избришан и кај корисниците кои го имаат примено.',
	'ga-remove-success-title' => 'Успешно го отстранивте подарокот „$1“',
	'ga-remove-success-message' => 'Подарокот „$1“ е отстранет.',
	'topawards' => 'Предводнички награди',
	'topawards-edit-title' => 'Предводнички награди - Важни чекори - Уредување',
	'topawards-vote-title' => 'Предводнички награди - Важни чекори - Гласање',
	'topawards-comment-title' => 'Предводнички награди - Важни чекори - Коментирање',
	'topawards-recruit-title' => 'Предводнички награди - Важни чекори - Регрутирање',
	'topawards-friend-title' => 'Предводнички награди - Важни чекори - Пријатели',
	'topawards-award-categories' => 'Категории на награди',
	'topawards-edits' => 'Уредувања',
	'topawards-votes' => 'Гласови',
	'topawards-comments' => 'Коментари',
	'topawards-recruits' => 'Регрути',
	'topawards-friends' => 'Пријатели',
	'topawards-edit-milestone' => 'Важен чекор - {{PLURAL:$1|$1 уредување|$1 уредувања}}',
	'topawards-vote-milestone' => 'Важен чекор - {{PLURAL:$1|$1 глас|$1 гласови}}',
	'topawards-comment-milestone' => 'Важен чекор - {{PLURAL:$1|$1 коментар|$1 коментари}}',
	'topawards-recruit-milestone' => 'Важен чекор - {{PLURAL:$1|$1 регрут|$1 регрути}}',
	'topawards-friend-milestone' => 'Важен чекор - {{PLURAL:$1|$1 пријател|$1 пријатели}}',
	'topawards-empty' => 'Нема поставено награди за оваа категорија, или пак досега никој ги нема добиено.',
	'system_gift_received_subject' => 'Ја добивте наградата $1 на {{SITENAME}}!',
	'system_gift_received_body' => 'Здраво $1.

Штотуку ја добивте наградата $2 на {{SITENAME}}!

„$3“

Кликнете подолу за да си ја видите витрината со трофеи!

$4

Се надеваме дека Ви се допаѓа!

Благодариме,


Екипата на {{SITENAME}}

---

Сакате повеќе да не добивате е-пошта од нас?

Кликнете на $5
и изменете си ги нагодувањата за да оневозможите известувања по е-пошта.',
	'right-awardsmanage' => 'Создавање на нови и уредување на постоечки награди',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'systemgiftmanager' => 'Pengurus hadian sistem',
	'ga-addnew' => '+ Tambah hadiah baru',
	'ga-back-edit-gift' => 'Kembali kepada menyunting hadiah ini',
	'ga-back-gift-list' => 'Kembali ke senarai hadiah',
	'ga-back-link' => '<a href="$1">< Kembali ke profil $2</a>',
	'ga-choosefile' => 'Pilih fail:',
	'ga-count' => '$1 ada $2 anugerah',
	'ga-create-gift' => 'Cipta hadiah',
	'ga-created' => 'Hadiah sudah dicipta',
	'ga-currentimage' => 'Imej semasa',
	'ga-error-message-invalid-link' => 'Pautan yang anda berikan itu tidak sah.',
	'ga-error-message-no-user' => 'Pengguna yang anda cuba melihat itu tidak wujud.',
	'ga-error-title' => 'Eh, tersilap arah!',
	'ga-file-instructions' => 'Imej anda mestilah jpeg, png atau gif (bukan gif animasi), dan saiznya kurang daripada 100KB.',
	'ga-gift' => 'hadiah',
	'ga-gift-given-count' => 'Hadiah ini telah diberikan $1 kali',
	'ga-gift-title' => '"$2" $1',
	'ga-giftdesc' => 'keterangan hadiah',
	'ga-giftimage' => 'imej hadiah',
	'ga-giftname' => 'nama hadiah',
	'ga-gifttype' => 'jenis hadiah',
	'ga-goback' => 'Kembali',
	'ga-imagesbelow' => 'Berikut ialah imej-imej anda yang akan digunakan di tapak ini',
	'ga-img' => 'tambah/ganti imej',
	'ga-large' => 'Besar',
	'ga-medium' => 'Sederhana',
	'ga-mediumlarge' => 'Sederhana besar',
	'ga-new' => 'Baru',
	'ga-next' => 'Berikutnya',
	'ga-previous' => 'Sebelumnya',
	'ga-recent-recipients-award' => 'Penerima terkini lain anugerah ini',
	'ga-saved' => 'Hadiah sudah disimpan',
	'ga-small' => 'Kecil',
	'ga-threshold' => 'ambang',
	'ga-title' => 'Anugerah $1',
	'ga-uploadsuccess' => 'Muat naik berjaya',
	'ga-viewlist' => 'Lihat senarai hadiah',
	'ga-cancel' => 'Batalkan',
	'ga-remove' => 'Buang',
	'ga-remove-title' => 'Nak buang "$1"?',
	'ga-delete-message' => 'Adakah anda benar-benar ingin membuang hadiah "$1"?
Dengan ini, hadiah ini juga akan terpadam daripada pengguna-pengguna yang menerimanya.',
	'ga-remove-success-title' => 'Anda berjaya membuang hadiah "$1"',
	'ga-remove-success-message' => 'Hadiah "$1" telah digugurkan.',
	'topawards' => 'Anugerah Terunggul',
	'topawards-edit-title' => 'Anugerah Terunggul - Pencapaian Penyuntingan',
	'topawards-vote-title' => 'Anugerah Terunggul - Pencapaian Pengundian',
	'topawards-comment-title' => 'Anugerah Terunggul - Pencapaian Komen',
	'topawards-recruit-title' => 'Anugerah Terunggul - Pencapaian Perekrutan',
	'topawards-friend-title' => 'Anugerah Terunggul - Pencapaian Persahabatan',
	'topawards-award-categories' => 'Kategori Anugerah',
	'topawards-edits' => 'Suntingan',
	'topawards-votes' => 'Undian',
	'topawards-comments' => 'Komen',
	'topawards-recruits' => 'Rekrut',
	'topawards-friends' => 'Kawan',
	'topawards-edit-milestone' => 'Pencapaian $1 Suntingan',
	'topawards-vote-milestone' => 'Pencapaian $1 Undian',
	'topawards-comment-milestone' => 'Pencapaian $1 Komen',
	'topawards-recruit-milestone' => 'Pencapaian $1 Rekrut',
	'topawards-friend-milestone' => 'Pencapaian $1 Kawan',
	'topawards-empty' => 'Sama ada anugerah belum dikonfigurasi untuk kategori anugerah ini, ataupun belum ada sesiapa yang menerima anugerah itu.',
	'system_gift_received_subject' => 'Anda telah menerima anugerah $1 di {{SITENAME}}!',
	'system_gift_received_body' => 'Kepada $1.

Anda baru menerima anugerah $2 di {{SITENAME}}!

"$3"

Klik di bawah untuk melihat piala anda!

$4

Semoga anda menyukainya!

Ihsan,


Pasukan {{SITENAME}}

---

Adakah anda tidak mahu menerima e-mel daripada kami?

Klik $5
dan tukar tetapan anda untuk mematikan pemberitahuan e-mel.',
	'right-awardsmanage' => 'Mencipta anugerah baru dan menyunting anugerah sedia ada',
);

/** Dutch (Nederlands)
 * @author GerardM
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'systemgiftmanager' => 'Giftenbeheer van systeem',
	'ga-addnew' => '+ Nieuwe gift toevoegen',
	'ga-back-edit-gift' => 'Terug naar gift bewerken',
	'ga-back-gift-list' => 'Terug naar giftenlijst',
	'ga-back-link' => '<a href="$1">< Terug naar het profiel van $2</a>',
	'ga-choosefile' => 'Bestand kiezen:',
	'ga-count' => '$1 heeft $2 {{PLURAL:$2|prijs|prijzen}}.',
	'ga-create-gift' => 'Gift aanmaken',
	'ga-created' => 'De gift is aangemaakt',
	'ga-currentimage' => 'Huidige afbeelding',
	'ga-error-message-invalid-link' => 'De verwijzing die u ingevoerd heeft is onjuist.',
	'ga-error-message-no-user' => 'De gebruiker die u wilt bekijken bestaat niet.',
	'ga-error-title' => 'Oeps, er ging iets fout!',
	'ga-file-instructions' => 'Uw afbeelding moet een JPEG-, PNG- of GIF-bestand (niet geanimeerd) zijn en dient minder dan 100 KB in grootte te zijn.',
	'ga-gift' => 'gift',
	'ga-gift-given-count' => 'Deze gift is $1 {{PLURAL:$1|keer|keren}} gegeven',
	'ga-gift-title' => '"$2" van $1',
	'ga-giftdesc' => 'giftomschrijving',
	'ga-giftimage' => 'giftafbeelding',
	'ga-giftname' => 'giftnaam',
	'ga-gifttype' => 'gifttype',
	'ga-goback' => 'Teruggaan',
	'ga-imagesbelow' => 'Hieronder volgen de afbeeldingen die gebruikt gaan worden op de site',
	'ga-img' => 'afbeelding toevoegen/vervangen',
	'ga-large' => 'Groot',
	'ga-medium' => 'Middelmatig',
	'ga-mediumlarge' => 'Middelgroot',
	'ga-new' => 'Nieuw',
	'ga-next' => 'Volgende',
	'ga-previous' => 'Vorige',
	'ga-recent-recipients-award' => 'Andere recente ontvangers van deze prijs',
	'ga-saved' => 'De gift is opgeslagen',
	'ga-small' => 'Klein',
	'ga-threshold' => 'drempel',
	'ga-title' => 'Prijzen van $1',
	'ga-uploadsuccess' => 'Uploaden voltooid',
	'ga-viewlist' => 'Giftenlijst weergeven',
	'ga-cancel' => 'Annuleren',
	'ga-remove' => 'Verwijderen',
	'ga-remove-title' => '"$1" verwijderen?',
	'ga-delete-message' => 'Weet u zeker dat u de gift "$1" wilt verwijderen?
Dit zal hem ook verwijderen van gebruikers die hem ontvangen hebben.',
	'ga-remove-success-title' => 'U hebt de gift "$1" verwijderd.',
	'ga-remove-success-message' => 'De gift "$1" is verwijderd.',
	'topawards' => 'Toplijst onderscheidingen',
	'topawards-edit-title' => 'Toplijst onderscheidingen - Mijlpalen bewerkingen',
	'topawards-vote-title' => 'Toplijst onderscheidingen - Mijlpalen stemmen',
	'topawards-comment-title' => 'Toplijst onderscheidingen - Mijlpalen opmerkingen',
	'topawards-recruit-title' => 'Toplijst onderscheidingen - Mijlpalen recruitering',
	'topawards-friend-title' => 'Toplijst onderscheidingen - Mijlpalen vrienden',
	'topawards-award-categories' => 'Categorieën voor onderscheidingen',
	'topawards-edits' => 'Bewerkingen',
	'topawards-votes' => 'Stemmen',
	'topawards-comments' => 'Opmerkingen',
	'topawards-recruits' => 'Rekruten',
	'topawards-friends' => 'Vrienden',
	'topawards-edit-milestone' => 'Mijlpaal {{PLURAL:$1|Eén bewerking|$1 bewerkingen}}',
	'topawards-vote-milestone' => 'Mijlpaal {{PLURAL:$1|Eén stem|$1 stemmen}}',
	'topawards-comment-milestone' => 'Mijlpaal {{PLURAL:$1|Eén opmerking|$1 opmerkingen}}',
	'topawards-recruit-milestone' => 'Mijlpaal {{PLURAL:$1|Eén rekruut|$1 rekruten}}',
	'topawards-friend-milestone' => 'Mijlpaal {{PLURAL:$1|Eén vriend|$1 vrienden}}',
	'topawards-empty' => 'Er zijn geen onderscheidingen voor deze categorie of niemand heeft de onderscheiding nog ontvangen.',
	'system_gift_received_subject' => 'U hebt de $1-prijs gekregen op {{SITENAME}}!',
	'system_gift_received_body' => 'Hallo $1,

U hebt zojuist de $2-prijs op {{SITENAME}} gekregen!

"$3"

Klik op de verwijzing hieronder om uw prijzenkast te bekijken!

$4

We hopen dat u er blij mee bent!

Bedankt,


Het {{SITENAME}}-team

---

Wilt u geen e-mails meer van ons ontvangen?

Klik op $5
en wijzig uw instellingen om e-mailwaarschuwingen uit te schakelen.',
	'right-awardsmanage' => 'Nieuwe prijzen aanmaken en bestaande prijzen bewerken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'systemgiftmanager' => 'Systemgåvehandsamar',
	'ga-addnew' => '+ legg til ei ny gåva',
	'ga-back-edit-gift' => 'Attende til endring av gåva',
	'ga-back-gift-list' => 'Attende til gåvelista',
	'ga-back-link' => '<a href="$1">< attende til profilen til $2</a>',
	'ga-choosefile' => 'Vel fil:',
	'ga-count' => '$1 har {{PLURAL:$2|éi utmerking|$2 utmerkingar}}.',
	'ga-create-gift' => 'Opprett gåva',
	'ga-created' => 'Gåva vart oppretta',
	'ga-currentimage' => 'Noverande bilete',
	'ga-error-message-invalid-link' => 'Lenkja du oppgav er ugyldig.',
	'ga-error-message-no-user' => 'Brukaren du ynskjer å sjå finst ikkje.',
	'ga-error-title' => 'Oi, du svingte feil!',
	'ga-file-instructions' => 'Biletet ditt lyt vera eit jpeg, png eller gif (ingen animerte gif-filer) og ha ein storleik på mindre enn 100 kb.',
	'ga-gift' => 'gåva',
	'ga-gift-given-count' => 'Denne gåva har vorten gjeven {{PLURAL:$1|éin gong|$1 gonger}}',
	'ga-gift-title' => '$2 til $1',
	'ga-giftdesc' => 'gåveskildring',
	'ga-giftimage' => 'gåvebilete',
	'ga-giftname' => 'gåvenamn',
	'ga-gifttype' => 'gåvetype',
	'ga-goback' => 'Attende',
	'ga-imagesbelow' => 'Nedanfor er bileta dine som vil verta nytta på sida',
	'ga-img' => 'legg til/erstatt bilete',
	'ga-large' => 'Stort',
	'ga-medium' => 'Medels',
	'ga-mediumlarge' => 'Medelsstort',
	'ga-new' => 'Ny',
	'ga-next' => 'Neste',
	'ga-previous' => 'Førre',
	'ga-recent-recipients-award' => 'Andre som nyleg mottok denne utmerkinga',
	'ga-saved' => 'Gåva har vorten lagra',
	'ga-small' => 'Lite',
	'ga-threshold' => 'terskel',
	'ga-title' => 'utmerkingane til $1',
	'ga-uploadsuccess' => 'Opplasting lukkast',
	'ga-viewlist' => 'Sjå gåvelista',
	'system_gift_received_subject' => 'Du har motteke utmerkinga $1 på {{SITENAME}}!',
	'system_gift_received_body' => 'Hei $1:

Du har nett motteke $2-utmerkinga på {{SITENAME}}!

«$3»

Trykk nedanfor for å sjå trofeet ditt!

$4

Me håpar du vil lika det!

Takk,


{{SITENAME}}-laget

----

Vil du ikkje lenger motta e-postar frå oss?

Trykk $5
og endra innstillingane dine for å slå av e-postmeldingar.',
	'right-awardsmanage' => 'Opprett nye og endra eksisterande utmerkingar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Simny
 */
$messages['nb'] = array(
	'systemgiftmanager' => 'Systemgaveforvalter',
	'ga-addnew' => '+ legg til en ny presang',
	'ga-back-edit-gift' => 'Tilbake til endring av gaven',
	'ga-back-gift-list' => 'Tilbake til gavelista',
	'ga-back-link' => '<a href="$1">< tilbake til $2s profil </a>',
	'ga-choosefile' => 'Velg fil:',
	'ga-count' => '$1 har {{PLURAL:$2|én utmerkelse|$2 utmerkelser}}.',
	'ga-create-gift' => 'opprett gave',
	'ga-created' => 'Gaven har blitt opprettet',
	'ga-currentimage' => 'Nåværende bilde',
	'ga-error-message-invalid-link' => 'Lenken du oppga er ugyldig.',
	'ga-error-message-no-user' => 'Brukeren du ønsker å se finnes ikke.',
	'ga-error-title' => 'Oi, du svingte feil!',
	'ga-file-instructions' => 'Bildet ditt må være et jpeg, png, eller gif (ingen animerte gif-filer), og ha en størrelse på mindre en 100 kb.',
	'ga-gift' => 'gave',
	'ga-gift-given-count' => 'Denne gaven har blitt gitt {{PLURAL:$1|én gang|$1 ganger}}',
	'ga-gift-title' => '$1s «$2»',
	'ga-giftdesc' => 'beskrivelse av gave',
	'ga-giftimage' => 'gavebilde',
	'ga-giftname' => 'gavenavn',
	'ga-gifttype' => 'gavetype',
	'ga-goback' => 'Gå tilbake',
	'ga-imagesbelow' => 'Under er bildene dine som vil bli brukt på sida.',
	'ga-img' => 'legg til/erstatt bilde',
	'ga-large' => 'Stort',
	'ga-medium' => 'Middels',
	'ga-mediumlarge' => 'middels stort',
	'ga-new' => 'Ny',
	'ga-next' => 'Neste',
	'ga-previous' => 'Forrige',
	'ga-recent-recipients-award' => 'Andre som nylig mottok denne utmerkelsen',
	'ga-saved' => 'Gaven har blitt lagret',
	'ga-small' => 'Lite',
	'ga-threshold' => 'terskel',
	'ga-title' => '$1s utmerkelser',
	'ga-uploadsuccess' => 'Opplasting vellykket',
	'ga-viewlist' => 'Se gavelista',
	'system_gift_received_subject' => 'Du har mottatt utmerkelsen $1 på {{SITENAME}}!',
	'system_gift_received_body' => 'Hei $1.

Du har akkurat mottatt en $2-utmerkelse på {{SITENAME}}!

«$3»

Klikk under for å se trofeet ditt!

$4

Vi håper du liker det!

Takk,

{{SITENAME}}-laget

---

Vil du ikke lenger motta e-poster fra oss?

Klikk $5
og forandre dine innstillinger for å slå av e-postbeskjeder.',
	'right-awardsmanage' => 'Opprett nye og endre eksisterende utmerkelser',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'systemgiftmanager' => 'Sistèma de gestion de presents',
	'ga-addnew' => '+ Apondre un present novèl',
	'ga-back-edit-gift' => "Tornar a la modificacion d'aqueste present",
	'ga-back-gift-list' => 'Tornar a la lista dels presents',
	'ga-back-link' => '<a href="$1">< Tornar al perfil de $2</a>',
	'ga-choosefile' => 'Causir lo fichièr :',
	'ga-count' => '$1 a $2 {{PLURAL:$2|prèmi|prèmis}}.',
	'ga-create-gift' => 'Crear un present',
	'ga-created' => 'Lo present es estat creat',
	'ga-currentimage' => 'Imatge actual',
	'ga-error-message-invalid-link' => "Lo ligam qu'avètz picat es invalid.",
	'ga-error-message-no-user' => "L'utilizaire qu'ensajatz de veire existís pas.",
	'ga-error-title' => 'Ops, avètz pres un marrit torn !',
	'ga-file-instructions' => 'Vòstre imatge deu èsser en jpeg, png o gif (mas pas animat) e deu èsser mai pichona que 100 Ko.',
	'ga-gift' => 'present',
	'ga-gift-given-count' => 'Aqueste present es estat balhat $1 {{PLURAL:$1|còp|còps}}',
	'ga-gift-title' => '« $2 » de $1',
	'ga-giftdesc' => 'descripcion del present',
	'ga-giftimage' => 'imatge del present',
	'ga-giftname' => 'nom del present',
	'ga-gifttype' => 'tipe del present',
	'ga-goback' => 'Tornar',
	'ga-imagesbelow' => 'Los imatges que seràn utilizats sus aquel site son afichats çaijós',
	'ga-img' => "apondre / modificar l'imatge",
	'ga-large' => 'Grand',
	'ga-medium' => 'Mejan',
	'ga-mediumlarge' => 'Mejan-Grand',
	'ga-new' => 'Novèl',
	'ga-next' => 'Seguent',
	'ga-previous' => 'Precedent',
	'ga-recent-recipients-award' => "Autres beneficiaris d'aquel prèmi",
	'ga-saved' => 'Aquel present es estat salvat',
	'ga-small' => 'Pichon',
	'ga-threshold' => 'sulhet',
	'ga-title' => 'Prèmi de $1',
	'ga-uploadsuccess' => 'Telecargament efectuat amb succès',
	'ga-viewlist' => 'Vejatz la lista dels presents',
	'system_gift_received_subject' => 'Avètz recebut lo prèmi $1 sus {{SITENAME}} !',
	'system_gift_received_body' => "Bonjorn $1,

Avètz recebut lo prèmi $2 sus {{SITENAME}} !

« $3 »

Clicatz sul ligam çaijós per veire vòstre trofèu

$4

Esperam que vos agradarà !

Mercés,


L'equipa de {{SITENAME}}

---

Volètz pas recebre mai de corrièrs electronics de nòstra part ?

Clicatz $5
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.",
	'right-awardsmanage' => 'Crear de prèmis novèls e modificar los prèmis existents',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'ga-back-link' => '<a href="$1">< Zerrick zur Uffstelling vun $2</a>',
	'ga-goback' => 'geh zerrick',
	'ga-large' => 'Gross',
	'ga-new' => 'Nei',
	'ga-next' => 'Neegschte',
	'ga-small' => 'Glee',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'ga-next' => 'Negschte',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'systemgiftmanager' => 'System zarządzania prezentami',
	'ga-addnew' => '+ Dodaj nowy prezent',
	'ga-back-edit-gift' => 'Powrót do edycji tego prezentu',
	'ga-back-gift-list' => 'Powrót do listy prezentów',
	'ga-back-link' => '<a href="$1">< Powrót do profilu $2</a>',
	'ga-choosefile' => 'Wybierz plik',
	'ga-count' => '$1 dostał $2 {{PLURAL:$2|nagrodę|nagrody|nagród}}.',
	'ga-create-gift' => 'Utwórz prezent',
	'ga-created' => 'Prezent został utworzony',
	'ga-currentimage' => 'Obecna grafika',
	'ga-error-message-invalid-link' => 'Wprowadzone łącze jest nieprawidłowe.',
	'ga-error-message-no-user' => 'Użytkownik, którego próbujesz wyświetlić nie istnieje.',
	'ga-error-title' => 'Ojej, chciałeś wykonać nieprawidłową operację!',
	'ga-file-instructions' => 'Grafika musi być w formacie jpeg, png lub gif (bez animacji) i musi być mniejsza niż 100kb.',
	'ga-gift' => 'prezent',
	'ga-gift-given-count' => 'Ten prezent został podrowany $1 dolar {{PLURAL:$1|raz|razy}}',
	'ga-gift-title' => '$1 – „$2”',
	'ga-giftdesc' => 'opis prezentu',
	'ga-giftimage' => 'grafika prezentu',
	'ga-giftname' => 'nazwa prezentu',
	'ga-gifttype' => 'rodzaj prezentu',
	'ga-goback' => 'Wróć',
	'ga-imagesbelow' => 'Poniżej znajdują się grafiki, które zostaną wykorzystane',
	'ga-img' => 'dodaj lub wymień grafikę',
	'ga-large' => 'Duży',
	'ga-medium' => 'Średni',
	'ga-mediumlarge' => 'Średnio‐duży',
	'ga-new' => 'Nowy',
	'ga-next' => 'Następny',
	'ga-previous' => 'Poprzedni',
	'ga-recent-recipients-award' => 'Inni, którzy ostatnio otrzymali tę nagrodę',
	'ga-saved' => 'Prezent został zapisany',
	'ga-small' => 'Nieduża',
	'ga-threshold' => 'próg',
	'ga-title' => 'nagrody $1',
	'ga-uploadsuccess' => 'Przesłano',
	'ga-viewlist' => 'Zobacz listę prezentu',
	'system_gift_received_subject' => 'Dostałeś nagrodę $1 na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Witaj $1.

Otrzymałeś właśnie nagrodę $2 w {{GRAMMAR:MS.lp|{{SITENAME}}}}!

„$3”

Kliknij poniżej, aby sprawdzić dlaczego!

$4

Mamy nadzieję, że się cieszysz!

Dziękujemy, 

zespół {{GRAMMAR:D.lp|{{SITENAME}}}}

--- 

Nie chcesz otrzymywać wiadomości?

Kliknij $5
i zmień ustawienia, aby wyłączyć powiadomienia e‐mail.',
	'right-awardsmanage' => 'Tworzenie nowych oraz edytowanie istniejących nagród',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'systemgiftmanager' => 'Gestor dël sistema ëd cadò',
	'ga-addnew' => '+ Gionta un cadò neuv',
	'ga-back-edit-gift' => 'André a modifiché sto cadò-sì',
	'ga-back-gift-list' => 'André a la lista dij cadò',
	'ga-back-link' => '<a href="$1">< André al profil ëd $2</a>',
	'ga-choosefile' => "Serne l'archivi:",
	'ga-count' => "$1 a l'ha $2 {{PLURAL:$2|premi|premi}}.",
	'ga-create-gift' => 'Crea cadò',
	'ga-created' => "Ël cadò a l'é stàit creà",
	'ga-currentimage' => 'Figura corenta',
	'ga-error-message-invalid-link' => "Ël colegament ch'it l'has anserì a l'é pa bon.",
	'ga-error-message-no-user' => "L'utent ch'it l'has provà a vardé a esist pa.",
	'ga-error-title' => "Contacc, a l'é rivaje un brut colp!",
	'ga-file-instructions' => 'Toa figura a deuv esse na jpeg, png o gif (gif pa animà), e a deuv esse men che 100kb an dimension.',
	'ga-gift' => 'cadò',
	'ga-gift-given-count' => "Sto cadò-sì a l'é stàit fàit $1 {{PLURAL:$1|vira|vire}}",
	'ga-gift-title' => '"$2" ëd $1',
	'ga-giftdesc' => 'descrission dël cadò',
	'ga-giftimage' => 'figura dël cadò',
	'ga-giftname' => 'nòm dël cadò',
	'ga-gifttype' => 'sòrt ëd cadò',
	'ga-goback' => 'Va andré',
	'ga-imagesbelow' => 'Sota a-i son soe figure che a saran dovrà an sël sit',
	'ga-img' => 'gionta/cambia figura',
	'ga-large' => 'Gròss',
	'ga-medium' => 'Medi',
	'ga-mediumlarge' => 'Medi-gròss',
	'ga-new' => 'Neuv',
	'ga-next' => 'Dapress',
	'ga-previous' => 'Prima',
	'ga-recent-recipients-award' => "Àutri che ëd recent a l'han arseivù sto premi-sì",
	'ga-saved' => "Ël cadò a l'é stàit salvà",
	'ga-small' => 'Cit',
	'ga-threshold' => 'seuja',
	'ga-title' => 'premi ëd $1',
	'ga-uploadsuccess' => 'Carià da bin',
	'ga-viewlist' => 'Varda la lista dij cadò',
	'system_gift_received_subject' => "It l'has arseivù ël premi $1 dzora a {{SITENAME}}!",
	'system_gift_received_body' => 'Cerea $1.

It l\'has pen-e arseivù ël premi $2 dzora {{SITENAME}}!

"$3"

Sgnaca sota për controlé tò trofeo!

$4

I speroma ch\'at piasa!

Mersì,


L\'echip {{SITENAME}}

---

Scota, veus-to pa pi arseive mëssagi ëd pòsta eletrònica da noiàutri?

Sgnaca $5
e cambia toe ampostassion për disabilité le notìfiche an pòsta eletrònica.',
	'right-awardsmanage' => "Crea neuv premi e modìfica j'esistent",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'ga-addnew' => '+ نوې ډالۍ ورګډول',
	'ga-choosefile' => 'دوتنه ټاکل:',
	'ga-create-gift' => 'ډالۍ جوړول',
	'ga-created' => 'ډالۍ مو جوړه شوه',
	'ga-gift' => 'ډالۍ',
	'ga-giftimage' => 'د ډالۍ انځور',
	'ga-giftname' => 'د ډالۍ نوم',
	'ga-goback' => 'پر شا تلل',
	'ga-large' => 'لوی',
	'ga-new' => 'نوی',
	'ga-next' => 'راتلونکی',
	'ga-previous' => 'پخوانی',
	'ga-saved' => 'ډالۍ مو خوندي شوه',
	'ga-small' => 'وړوکی',
	'ga-viewlist' => 'د ډاليو لړليک کتل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Vanessa Sabino
 * @author Waldir
 */
$messages['pt'] = array(
	'systemgiftmanager' => 'Administrador do sistema de prendas',
	'ga-addnew' => '+ Adicionar nova prenda',
	'ga-back-edit-gift' => 'Voltar para editar esta prenda',
	'ga-back-gift-list' => 'Voltar à lista de prendas',
	'ga-back-link' => '<a href="$1">< Voltar ao perfil de $2</a>',
	'ga-choosefile' => 'Escolher ficheiro:',
	'ga-count' => '$1 tem {{PLURAL:$2|um prémio|$2 prémios}}.',
	'ga-create-gift' => 'Criar prenda',
	'ga-created' => 'A prenda foi criada',
	'ga-currentimage' => 'Imagem actual',
	'ga-error-message-invalid-link' => 'O link que forneceu é inválido.',
	'ga-error-message-no-user' => 'O utilizador que pretende ver não existe.',
	'ga-error-title' => 'Ui, enganou-se no caminho!',
	'ga-file-instructions' => 'A imagem tem de ser um jpeg, png or gif (sem gifs animados) e ter um tamanho inferior a 100KB.',
	'ga-gift' => 'prenda',
	'ga-gift-given-count' => 'Esta prenda foi dada {{PLURAL:$1|uma vez|$1 vezes}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descrição da prenda',
	'ga-giftimage' => 'imagem da prenda',
	'ga-giftname' => 'nome da prenda',
	'ga-gifttype' => 'tipo da prenda',
	'ga-goback' => 'Voltar',
	'ga-imagesbelow' => 'Abaixo estão as suas imagens que serão usadas no site',
	'ga-img' => 'adicionar/substituir imagem',
	'ga-large' => 'Grande',
	'ga-medium' => 'Médio',
	'ga-mediumlarge' => 'Médio/Grande',
	'ga-new' => 'Novo',
	'ga-next' => 'Próximo',
	'ga-previous' => 'Anterior',
	'ga-recent-recipients-award' => 'Outros ganhadores recentes deste prémio',
	'ga-saved' => 'Esta prenda foi gravada',
	'ga-small' => 'Pequeno',
	'ga-threshold' => 'threshold',
	'ga-title' => 'prémios de $1',
	'ga-uploadsuccess' => 'Carregamento com sucesso',
	'ga-viewlist' => 'Ver lista de prendas',
	'ga-cancel' => 'Cancelar',
	'ga-remove' => 'Remover',
	'ga-remove-title' => 'Remover "$1"?',
	'ga-delete-message' => 'Tem a certeza de que deseja eliminar a prenda "$1"?
Isto irá também retirá-la aos utilizadores que a tenham recebido.',
	'ga-remove-success-title' => 'Removeu a prenda "$1"',
	'ga-remove-success-message' => 'A prenda "$1" foi removida.',
	'topawards' => 'Grandes Prémios',
	'topawards-edit-title' => 'Grandes Prémios - Objectivos de Edições',
	'topawards-vote-title' => 'Grandes Prémios - Objectivos de Votos',
	'topawards-comment-title' => 'Grandes Prémios - Objectivos de Comentários',
	'topawards-recruit-title' => 'Grandes Prémios - Objectivos de Recrutas',
	'topawards-friend-title' => 'Grandes Prémios - Objectivos de Amigos',
	'topawards-award-categories' => 'Categorias de Prémios',
	'topawards-edits' => 'Edições',
	'topawards-votes' => 'Votos',
	'topawards-comments' => 'Comentários',
	'topawards-recruits' => 'Recrutas',
	'topawards-friends' => 'Amigos',
	'topawards-edit-milestone' => 'Objectivo de {{PLURAL:$1|$1 Edição|$1 Edições}}',
	'topawards-vote-milestone' => 'Objectivo de {{PLURAL:$1|$1 Voto|$1 Votos}}',
	'topawards-comment-milestone' => 'Objectivo de {{PLURAL:$1|$1 Comentário|$1 Comentários}}',
	'topawards-recruit-milestone' => 'Objectivo de {{PLURAL:$1|$1 Recruta|$1 Recrutas}}',
	'topawards-friend-milestone' => 'Objectivo de {{PLURAL:$1|$1 Amigo|$1 Amigos}}',
	'topawards-empty' => 'Ou não existem prémios configurados para esta categoria, ou ainda ninguém recebeu estes prémios.',
	'system_gift_received_subject' => 'Recebeu o prémio $1 na {{SITENAME}}!',
	'system_gift_received_body' => 'Olá $1,

Acaba de receber o prémio $2 na {{SITENAME}}!

"$3"

Clique abaixo para ver a sua estante de troféus!

$4

Esperamos que tenha gostado!

Obrigado,


A equipa da {{SITENAME}}

---

Olhe, quer parar de receber as nossas mensagens?

Clique $5
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'right-awardsmanage' => 'Criar novos prémios e editar os existentes',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'systemgiftmanager' => 'Gerenciador do Sistema de Presentes',
	'ga-addnew' => '+ Adicionar Novo Presente',
	'ga-back-edit-gift' => 'Voltar para Editar Este Presente',
	'ga-back-gift-list' => 'Voltar para Lista de Presentes',
	'ga-back-link' => '<a href="$1">< Voltar para Perfil de $2</a>',
	'ga-choosefile' => 'Escolher arquivo:',
	'ga-count' => '$1 tem $2 {{PLURAL:$2|prêmio|prêmios}}.',
	'ga-create-gift' => 'Criar presente',
	'ga-created' => 'O presente foi criado',
	'ga-currentimage' => 'Imagem atual',
	'ga-error-message-invalid-link' => 'A ligação que você colocou é inválida.',
	'ga-error-message-no-user' => 'O utilizador que você está tentando ver não existe.',
	'ga-error-title' => 'Ops, você entrou no lugar errado!',
	'ga-file-instructions' => 'Sua imagem precisa ser um jpeg, png ou gif (sem gifs animados), e precisa ter tamanho menor que 100kb.',
	'ga-gift' => 'presente',
	'ga-gift-given-count' => 'Este presente foi dado $1 {{PLURAL:$1|vez|vezes}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descrição do presente',
	'ga-giftimage' => 'imagem do presente',
	'ga-giftname' => 'nome do presente',
	'ga-gifttype' => 'tipo do presente',
	'ga-goback' => 'Voltar',
	'ga-imagesbelow' => 'Abaixo estão suas imagens que serão usadas no sítio',
	'ga-img' => 'adicionar/substituir imagem',
	'ga-large' => 'Grande',
	'ga-medium' => 'Médio',
	'ga-mediumlarge' => 'Médio/Grande',
	'ga-new' => 'Novo',
	'ga-next' => 'Próximo',
	'ga-previous' => 'Anterior',
	'ga-recent-recipients-award' => 'Outros ganhadores recentes deste prêmio',
	'ga-saved' => 'Este presente foi salvo',
	'ga-small' => 'Pequeno',
	'ga-threshold' => 'threshold',
	'ga-title' => 'Prêmios de $1',
	'ga-uploadsuccess' => 'Carregamento bem sucedido',
	'ga-viewlist' => 'Ver Lista de Presentes',
	'system_gift_received_subject' => 'Você recebeu o prêmio $1 em {{SITENAME}}!',
	'system_gift_received_body' => 'Oi $1:

Você acaba de receber o prêmio $2 em {{SITENAME}}!

"$3"

Clique abaixo para ver sua estante de troféis!

$4

Esperamos que tenha gostado!

Obrigado,


O Time de {{SITENAME}}

---

Ei, quer parer de receber e-mails de nós?

Clique $5
e altere suas preferências para desabilitar e-mails de notificação.',
	'right-awardsmanage' => 'Crie novos e edite prêmios existentes',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'ga-choosefile' => 'Alegeți fișier:',
	'ga-create-gift' => 'Creați un cadou',
	'ga-currentimage' => 'Imaginii curente',
	'ga-error-message-invalid-link' => 'Legătura introdusă este incorectă.',
	'ga-gift' => 'cadou',
	'ga-giftimage' => 'imaginea cadoului',
	'ga-giftname' => 'numele cadoului',
	'ga-gifttype' => 'tipul cadoului',
	'ga-goback' => 'Reveniți',
	'ga-large' => 'Mare',
	'ga-medium' => 'Mediu',
	'ga-mediumlarge' => 'Mediu-mare',
	'ga-new' => 'Nou',
	'ga-next' => 'Următorul',
	'ga-previous' => 'Anteriorul',
	'ga-small' => 'Mic',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ga-choosefile' => "Scacchie 'u file:",
	'ga-gift' => 'riale',
	'ga-new' => 'Nuève',
);

/** Russian (Русский)
 * @author Alexandr Efremov
 * @author Ferrer
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'systemgiftmanager' => 'Система управления подарками',
	'ga-addnew' => '+ Добавить новый подарок',
	'ga-back-edit-gift' => 'Вернуться к редактированию этого подарка',
	'ga-back-gift-list' => 'Вернуться к списку подарков',
	'ga-back-link' => '<a href="$1">< Вернуться к странице $2</a>',
	'ga-choosefile' => 'Выберите файл:',
	'ga-count' => '$1 имеет $2 {{PLURAL:$1|награду|награды|наград}}.',
	'ga-create-gift' => 'Создать подарок',
	'ga-created' => 'Подарок был создан',
	'ga-currentimage' => 'Текущее изображение',
	'ga-error-message-invalid-link' => 'Введённая вами ссылка ошибочна.',
	'ga-error-message-no-user' => 'Участник, которого вы хотите посмотреть, не существует.',
	'ga-error-title' => 'Опа, вы ввели неправильное название!',
	'ga-file-instructions' => 'Ваше изображение должно быть в формате jpeg, png или gif (неанимированный gif), и быть меньше 100 КБ.',
	'ga-gift' => 'подарок',
	'ga-gift-given-count' => 'Этот подарок был подарен $1 {{PLURAL:$1|раз|раза|раза}}',
	'ga-gift-title' => '$1 «$2»',
	'ga-giftdesc' => 'описание подарка',
	'ga-giftimage' => 'изображение подарка',
	'ga-giftname' => 'название подарка',
	'ga-gifttype' => 'тип подарка',
	'ga-goback' => 'Перейти назад',
	'ga-imagesbelow' => 'Ниже находятся ваши изображения, которые будут использоваться на сайте',
	'ga-img' => 'добавить/изменить изображение',
	'ga-large' => 'Большой',
	'ga-medium' => 'Средний',
	'ga-mediumlarge' => 'Средний-большой',
	'ga-new' => 'Новый',
	'ga-next' => 'Следующий',
	'ga-previous' => 'Предыдущий',
	'ga-recent-recipients-award' => 'Другие недавние получатели этой награды',
	'ga-saved' => 'Этот подарок был сохранён',
	'ga-small' => 'Маленький',
	'ga-threshold' => 'порог',
	'ga-title' => 'Награды $1',
	'ga-uploadsuccess' => 'Загрузка успешно завершена',
	'ga-viewlist' => 'Просмотр списка подарков',
	'ga-cancel' => 'Отмена',
	'system_gift_received_subject' => 'Вы получили награду $1 на {{SITENAME}}!',
	'system_gift_received_body' => 'Здравствуйте, $1.

Вы только что получили награду $2 на {{SITENAME}}!

«$3»

Нажмите ниже для проверки вашего трофея!

$4

Мы надеемся, что вам понравится!

Спасибо,


Команда {{SITENAME}}

---

Хотите прекратить получать письма от нас?

Нажмите $5
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'right-awardsmanage' => 'создание новых и правка существующих наград',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'ga-back-link' => '<a href="$1">< Назад на $2\'s профіл</a>',
	'ga-choosefile' => 'Выбрати файл:',
	'ga-large' => 'Великый',
	'ga-medium' => 'Середнїй',
	'ga-mediumlarge' => 'Середнїй - великый',
	'ga-new' => 'Новый',
	'ga-next' => 'Далшый',
	'ga-previous' => 'Попереднїй',
	'ga-small' => 'Маленькый',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'systemgiftmanager' => 'Systémový správca darčekov',
	'ga-addnew' => '+ Pridať nový darček',
	'ga-back-edit-gift' => 'Späť na Upraviť tento darček',
	'ga-back-gift-list' => 'Späť na zoznam darčekov',
	'ga-back-link' => '<a href="$1">< Späť na profil $2</a>',
	'ga-choosefile' => 'Vybrať súbor:',
	'ga-count' => '$1 má $2 {{PLURAL:$2|ocenenie|ocenenia|ocenení}}.',
	'ga-create-gift' => 'Vytvoriť darček',
	'ga-created' => 'Darček bol vytvorený',
	'ga-currentimage' => 'Aktuálny obrázok',
	'ga-error-message-invalid-link' => 'Odkaz, ktorý ste zadali je neplatný.',
	'ga-error-message-no-user' => 'Používateľ, ktorého sa snažíte zobraziť, neexistuje.',
	'ga-error-title' => 'Ops, niečo ste spravili zle!',
	'ga-file-instructions' => 'Váš obrázok musí byť jpeg, png alebo gif (nie animovaný gif) a musí mať veľkosť menšiu ako 100 kb.',
	'ga-gift' => 'darček',
	'ga-gift-given-count' => 'Tento darček bol darovaný {{PLURAL:$1|jedenkrát|$1-krát}}',
	'ga-gift-title' => '„$2“ používateľa $1',
	'ga-giftdesc' => 'popis darčeka',
	'ga-giftimage' => 'obrázok darčeka',
	'ga-giftname' => 'názov darčeka',
	'ga-gifttype' => 'typ darčeka',
	'ga-goback' => 'Vrátiť sa späť',
	'ga-imagesbelow' => 'Dolu je zoznam vašich obrázkov, ktoré sa použijú na stránke',
	'ga-img' => 'pridať/nahradiť obrázok',
	'ga-large' => 'Veľký',
	'ga-medium' => 'Stredný',
	'ga-mediumlarge' => 'Stredne veľký',
	'ga-new' => 'Nový',
	'ga-next' => 'Ďalší',
	'ga-previous' => 'Predošlý',
	'ga-recent-recipients-award' => 'Ďalší, ktorí nedávno dostali toto ocenenie',
	'ga-saved' => 'Darček bol uložený',
	'ga-small' => 'Malý',
	'ga-threshold' => 'hraničná hodnota',
	'ga-title' => 'Ocenenia používateľa $1',
	'ga-uploadsuccess' => 'Nahrávanie prebehlo úspešne',
	'ga-viewlist' => 'Zobraziť zoznam darčekov',
	'system_gift_received_subject' => 'Dostali ste ocenenie $1 na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'system_gift_received_body' => 'Ahoj $1:

Práve ste dostali ocenenie $2 na {{GRAMMAR:lokál|{{SITENAME}}}}

„$3“

Chcete si pozrieť svoje ocenenie? Kliknite na nasledovný odkaz:

$4

Dúfame, že sa vám bude páčiť!

Vďaka,


Tím {{GRAMMAR:genitív|{{SITENAME}}}}

---

Neželáte si od nás dostávať emaily?

Kliknite na $5
a zmeňte svoje nastavenia týkajúce sa upozornení emailom.',
	'right-awardsmanage' => 'Vytvárať nové alebo upravovať existujúce ocenenia',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'ga-goback' => 'Pojdi nazaj',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'ga-addnew' => '+ Додајте нови поклон',
	'ga-back-edit-gift' => 'Повратак на измену овог поклона',
	'ga-back-gift-list' => 'Повратак на списак поклона',
	'ga-back-link' => '<a href="$1">< Повратак на профил $2</a>',
	'ga-choosefile' => 'Изаберите фајл:',
	'ga-count' => '$1 има $2 {{PLURAL:$2|награду|награда}}.',
	'ga-create-gift' => 'Направите поклон',
	'ga-created' => 'Поклон је направљен',
	'ga-currentimage' => 'Тренутна слика',
	'ga-error-message-invalid-link' => 'Линк који сте навели је неисправан.',
	'ga-error-message-no-user' => 'Корисник кога покушавате да видите не постоји.',
	'ga-file-instructions' => 'Ваша слика мора бити у jpeg/jpg, png или gif (неанимираном) формату, и мора бити величине испод 100kB.',
	'ga-gift' => 'поклон',
	'ga-gift-given-count' => 'Овај поклон је био поклоњен $1 {{PLURAL:$1|пут|пута}}',
	'ga-gift-title' => '"$2" од $1',
	'ga-giftdesc' => 'опис поклона',
	'ga-giftimage' => 'слика поклона',
	'ga-giftname' => 'назив поклона',
	'ga-gifttype' => 'врста поклона',
	'ga-goback' => 'Назад',
	'ga-imagesbelow' => 'Испод се налазе ваше слике које ће бити коришћене на сајту',
	'ga-img' => 'додај/замени слику',
	'ga-large' => 'Велико',
	'ga-medium' => 'Средње',
	'ga-mediumlarge' => 'Средње – велико',
	'ga-new' => 'Ново',
	'ga-next' => 'Следеће',
	'ga-previous' => 'Претходно',
	'ga-recent-recipients-award' => 'Други скорији примаоци ове награде',
	'ga-saved' => 'Поклон је снимљен',
	'ga-small' => 'Мало',
	'ga-title' => 'Награде $1',
	'ga-uploadsuccess' => 'Слање успешно',
	'ga-viewlist' => 'Погледај списак поклона',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'ga-addnew' => '+ Dodajte novi poklon',
	'ga-back-edit-gift' => 'Povratak na izmenu ovog poklona',
	'ga-back-gift-list' => 'Povratak na spisak poklona',
	'ga-back-link' => '<a href="$1">< Povratak na profil $2</a>',
	'ga-choosefile' => 'Izaberite fajl:',
	'ga-count' => '$1 ima $2 {{PLURAL:$2|nagradu|nagrada}}.',
	'ga-create-gift' => 'Napravite poklon',
	'ga-created' => 'Poklon je napravljen',
	'ga-currentimage' => 'Trenutna slika',
	'ga-error-message-invalid-link' => 'Link koji ste naveli je neispravan.',
	'ga-error-message-no-user' => 'Korisnik koga pokušavate da vidite ne postoji.',
	'ga-file-instructions' => 'Vaša slika mora biti u jpeg/jpg, png ili gif (neanimiranom) formatu, i mora biti veličine ispod 100kB.',
	'ga-gift' => 'poklon',
	'ga-gift-given-count' => 'Ovaj poklon je bio poklonjen $1 {{PLURAL:$1|put|puta}}',
	'ga-gift-title' => '"$2" od $1',
	'ga-giftdesc' => 'opis poklona',
	'ga-giftimage' => 'slika poklona',
	'ga-giftname' => 'naziv poklona',
	'ga-gifttype' => 'vrsta poklona',
	'ga-goback' => 'Nazad',
	'ga-imagesbelow' => 'Ispod se nalaze vaše slike koje će biti korišćene na sajtu',
	'ga-img' => 'dodaj/zameni sliku',
	'ga-large' => 'Veliko',
	'ga-medium' => 'Srednje',
	'ga-mediumlarge' => 'Srednje-veliko',
	'ga-new' => 'Novo',
	'ga-next' => 'Sledeće',
	'ga-previous' => 'Prethodno',
	'ga-recent-recipients-award' => 'Drugi skoriji primaoci ove nagrade',
	'ga-saved' => 'Poklon je snimljen',
	'ga-small' => 'Malo',
	'ga-title' => 'Nagrade $1',
	'ga-uploadsuccess' => 'Slanje uspešno',
	'ga-viewlist' => 'Pogledaj spisak poklona',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'systemgiftmanager' => 'Systempresentförvaltare',
	'ga-addnew' => '+ lägg till en ny present',
	'ga-back-edit-gift' => 'Tillbaka för att ändra denna present',
	'ga-back-gift-list' => 'Tillbaka till presentlista',
	'ga-choosefile' => 'Välj fil:',
	'ga-count' => '$1 har $2 {{PLURAL:$2|utmärkelse|utmärkelser}}.',
	'ga-create-gift' => 'Skapa present',
	'ga-created' => 'Presenten har skapats',
	'ga-currentimage' => 'Nuvarande bild',
	'ga-error-message-invalid-link' => 'Länken du angav är ogiltig.',
	'ga-error-message-no-user' => 'Användaren du försöker titta på existerar inte.',
	'ga-error-title' => 'Oj, du gick visst fel!',
	'ga-gift' => 'present',
	'ga-gift-given-count' => 'Presenten har delats ut $1 {{PLURAL:$1|gång|gånger}}',
	'ga-gift-title' => '$1s "$2"',
	'ga-giftdesc' => 'beskrivning av present',
	'ga-giftimage' => 'presentbild',
	'ga-giftname' => 'presentnamn',
	'ga-gifttype' => 'presenttyp',
	'ga-goback' => 'Gå tillbaka',
	'ga-img' => 'lägg till/byt ut bild',
	'ga-large' => 'Stor',
	'ga-new' => 'Ny',
	'ga-next' => 'Nästa',
	'ga-previous' => 'Föregående',
	'ga-recent-recipients-award' => 'Andra som nyligen fick denna utmärkelse',
	'ga-saved' => 'Presenten har sparats',
	'ga-small' => 'Liten',
	'ga-threshold' => 'tröskel',
	'ga-title' => '$1s utmärkelser',
	'ga-viewlist' => 'Visa presentlista',
	'right-awardsmanage' => 'Skapa nya och ändra existerande utmärkelser',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'ga-choosefile' => 'దస్త్రాన్ని ఎంచుకోండి:',
	'ga-gift' => 'బహుమతి',
	'ga-gift-given-count' => 'ఈ బహుమతిని {{PLURAL:$1|ఒకసారి|$1 సార్లు}} ఇచ్చారు',
	'ga-gift-title' => '$1 యొక్క "$2"',
	'ga-giftdesc' => 'బహుమతి వివరణ',
	'ga-giftimage' => 'బహుమతి చిత్రం',
	'ga-giftname' => 'బహుమతి పేరు',
	'ga-gifttype' => 'బహుమతి రకం',
	'ga-goback' => 'వెనక్కి వెళ్ళు',
	'ga-new' => 'కొత్త',
	'ga-next' => 'తర్వాతి',
	'ga-previous' => 'గత',
	'ga-title' => '$1 యొక్క పురస్కారాలు',
	'ga-uploadsuccess' => 'ఎక్కింపు విజయవంతం',
	'ga-viewlist' => 'బహుమతుల జాబితాని చూడండి',
	'system_gift_received_subject' => '{{SITENAME}}లో మీకు $1 పురస్కారం లభించింది!',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'systemgiftmanager' => 'Tagapamahala ng Sistema ng mga Handog',
	'ga-addnew' => '+ Magdagdag ng Bagong Handog',
	'ga-back-edit-gift' => 'Bumalik sa Baguhin ang Handog na Ito',
	'ga-back-gift-list' => 'Bumalik sa Talaan ng Handog',
	'ga-back-link' => '<a href="$1">< Bumalik sa Talaan ng Katangian ni $2</a>',
	'ga-choosefile' => 'Pumili ng Talaksan:',
	'ga-count' => 'Si $1 ay may $2 {{PLURAL:$2|gantimpala|mga gantimpala}}.',
	'ga-create-gift' => 'Lumikha ng handog',
	'ga-created' => 'Nalikha na ang handog',
	'ga-currentimage' => 'Kasalukuyang larawan',
	'ga-error-message-invalid-link' => 'Hindi tanggap ang ipinasok mong kawing.',
	'ga-error-message-no-user' => 'Hindi umiiral ang tagagamit na sinusubukan mong tingnan.',
	'ga-error-title' => "Ay 'sus, nagkamali ka sa pagliko!",
	'ga-file-instructions' => 'Dapat na isang jpeg, png o gif ang larawan mo (walang gumagalaw na mga gif), at dapat na mas mababa kaysa 100 mga kb ang sukat.',
	'ga-gift' => 'handog',
	'ga-gift-given-count' => 'Naipamigay na ng $1 {{PLURAL:$1|ulit|mga ulit}} ang handog na ito',
	'ga-gift-title' => '"$2" ni $1',
	'ga-giftdesc' => 'paglalarawan ng handog',
	'ga-giftimage' => 'larawan ng handog',
	'ga-giftname' => 'pangalan ng handog',
	'ga-gifttype' => 'uri ng handog',
	'ga-goback' => 'Magbalik',
	'ga-imagesbelow' => 'Nasa ibaba ang iyong mga larawang gagamitin sa sityo',
	'ga-img' => 'idagdag/palitan ang larawan',
	'ga-large' => 'Malaki',
	'ga-medium' => 'Gitnang sukat',
	'ga-mediumlarge' => 'Gitnang Sukat-Malaki',
	'ga-new' => 'Bago',
	'ga-next' => 'Susunod',
	'ga-previous' => 'Dati',
	'ga-recent-recipients-award' => 'Iba pang kamakailang mga nakatanggap ng gantimpalang ito',
	'ga-saved' => 'Nasagip na ang handog',
	'ga-small' => 'Maliit',
	'ga-threshold' => 'katindihan/abot ng saklaw',
	'ga-title' => 'Mga Gantimpala ni $1',
	'ga-uploadsuccess' => 'Tagumpay sa Pagkarga',
	'ga-viewlist' => 'Tingnan ang Talaan ng Handog',
	'system_gift_received_subject' => 'Natanggap mo ang gantimpalang $1 sa {{SITENAME}}!',
	'system_gift_received_body' => 'Kumusta ka $1:

Katatanggap mo pa lang ng gantimpalang $2 sa {{SITENAME}}!

"$3"

Pindutin sa ibaba upang suriin ang lalagyan mo ng tropeo!

$4

Sana ay magustuhan mo ito!

Salamat,


Ang Pangkat ng {{SITENAME}}

---

Hoy, nais mo bang huminto na ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $5
at baguhin ang mga pagtatakda mo upang huwag nang paganahin ang mga pagpapabatid sa pamamagitan ng e-liham.',
	'right-awardsmanage' => 'Lumikha ng bago at baguhin ang umiiral na mga gantimpala',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'systemgiftmanager' => 'Sistem hediye yöneticisi',
	'ga-addnew' => '+ Yeni hediye ekle',
	'ga-back-edit-gift' => 'Bu hediyeyi düzenlemeye geri dön',
	'ga-back-gift-list' => 'Hediye listesine geri dön',
	'ga-back-link' => '<a href="$1">< $2 adlı kullanıcının profiline geri dön</a>',
	'ga-choosefile' => 'Dosya seç:',
	'ga-count' => '$1, $2 {{PLURAL:$2|ödüle|ödüle}} sahip.',
	'ga-create-gift' => 'Hediye oluştur',
	'ga-created' => 'Hediye oluşturuldu',
	'ga-currentimage' => 'Mevcut resim',
	'ga-error-message-invalid-link' => 'Girdiğiniz bağlantı geçersiz.',
	'ga-error-message-no-user' => 'Görmeye çalıştığınız kullanıcı mevcut değil.',
	'ga-error-title' => 'Hay Allah, yanlış işlem yaptınız!',
	'ga-file-instructions' => 'Resminiz jpeg, png veya gif (animasyonlu gif dosyaları hariç) formatında ve 100kb altı boyutta olmalıdır.',
	'ga-gift' => 'hediye',
	'ga-gift-given-count' => 'Bu hediye $1 {{PLURAL:$1|kez|kez}} verildi',
	'ga-gift-title' => '$1 adlı kullanıcının "$2" hediyesi',
	'ga-giftdesc' => 'hediye açıklaması',
	'ga-giftimage' => 'hediye resmi',
	'ga-giftname' => 'hediye adı',
	'ga-gifttype' => 'hediye türü',
	'ga-goback' => 'Geri dön',
	'ga-imagesbelow' => 'Sitede kullanılacak resimleriniz aşağıdadır',
	'ga-img' => 'resim ekle/değiştir',
	'ga-large' => 'Büyük',
	'ga-medium' => 'Orta',
	'ga-mediumlarge' => 'Orta-büyük',
	'ga-new' => 'Yeni',
	'ga-next' => 'Sonraki',
	'ga-previous' => 'Önceki',
	'ga-recent-recipients-award' => 'Bu ödülün diğer yakın zamanlı alıcıları',
	'ga-saved' => 'Hediye kaydedildi',
	'ga-small' => 'Küçük',
	'ga-threshold' => 'eşik',
	'ga-title' => '$1 adlı kullanıcının ödülleri',
	'ga-uploadsuccess' => 'Yükleme başarılı',
	'ga-viewlist' => 'Hediye listesini gör',
	'system_gift_received_subject' => '{{SITENAME}} üzerinde $1 ödülü aldınız!',
	'system_gift_received_body' => 'Merhaba $1.

{{SITENAME}} üzerinde $2 ödülünü aldınız!

"$3"

Ödül dolabınızı kontrol etmek için aşağıya tıklayın!

$4

Umarız hoşunuza gider!

Teşekkürler,

{{SITENAME}} ekibi

---

Hey, bizden e-posta alımını durdurmak ister misiniz?

$5 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'right-awardsmanage' => 'Yeni ödül oluşturur ve mevcut ödülleri düzenler',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'ga-choosefile' => 'Виберіть файл:',
	'ga-goback' => 'Назад',
	'ga-img' => 'додати/замінити зображення',
	'ga-large' => 'Великий',
	'ga-medium' => 'Середній',
	'ga-new' => 'Новий',
	'ga-next' => 'Наступний',
	'ga-previous' => 'Попередній',
	'ga-small' => 'Малий',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'ga-choosefile' => 'Valiče fail:',
	'ga-gift' => 'lahj',
	'ga-gift-given-count' => 'Nece lahj om anttud $1 {{PLURAL:$1|kerd|kerdad}}',
	'ga-gift-title' => '$1-kävutajan "$2"',
	'ga-giftdesc' => 'lahjan ümbrikacund',
	'ga-giftimage' => 'lahjan kuva',
	'ga-giftname' => 'lahjan nimi',
	'ga-gifttype' => 'lahjan tip',
	'ga-goback' => 'Mäne tagaze',
	'ga-large' => "Sur'",
	'ga-medium' => 'Keskmäine',
	'ga-mediumlarge' => "Keskmäižsur'",
	'ga-new' => "Uz'",
	'ga-next' => "Jäl'gh.",
	'ga-previous' => 'Edel.',
	'ga-small' => "Pen'",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'ga-choosefile' => 'Chọn tập tin:',
	'ga-currentimage' => 'Hình hiện hành',
	'ga-gift-title' => '“$2” của $1',
	'ga-goback' => 'Trở lại',
	'ga-img' => 'thêm/thay hình',
	'ga-large' => 'Lớn',
	'ga-medium' => 'Vừa',
	'ga-mediumlarge' => 'Hơi lớn',
	'ga-new' => 'Mới',
	'ga-next' => 'Sau',
	'ga-previous' => 'Trước',
	'ga-small' => 'Nhỏ',
	'ga-title' => 'Huy chương của $1',
	'ga-uploadsuccess' => 'Đã tải lên thành công',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'ga-choosefile' => 'קלויבט טעקע:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'systemgiftmanager' => '系统礼物管理',
	'ga-addnew' => '+ 添加新的礼物',
	'ga-back-edit-gift' => '返回编辑礼物',
	'ga-back-gift-list' => '返回礼品列表',
	'ga-choosefile' => '选择文件',
	'ga-create-gift' => '创造礼物',
	'ga-created' => '礼物已被创建',
	'ga-currentimage' => '当前图像',
	'ga-error-message-invalid-link' => '您输入的链接是无效的。',
	'ga-error-message-no-user' => '您要查看的用户不存在。',
	'ga-error-title' => '唔，你拐错弯了！',
	'ga-file-instructions' => '您的图片必须为JPEG、PNG或GIF（非动态）格式，且大小必须不超过100kb。',
	'ga-gift' => '礼物',
	'ga-gift-given-count' => '这个礼物已被送出$1次',
	'ga-gift-title' => '$1的“$2”',
	'ga-giftdesc' => '礼物说明',
	'ga-giftimage' => '礼物图片',
	'ga-giftname' => '礼物名称',
	'ga-gifttype' => '礼物种类',
	'ga-goback' => '后退',
	'ga-imagesbelow' => '下面是您将在站点使用的图像',
	'ga-img' => '添加／替换图像',
	'ga-large' => '大',
	'ga-medium' => '中',
	'ga-mediumlarge' => '中至大',
	'ga-new' => '新的',
	'ga-next' => '下一个',
	'ga-previous' => '前页',
	'ga-saved' => '礼物已被保存',
	'ga-small' => '小',
	'ga-threshold' => '阈值',
	'ga-uploadsuccess' => '上载成功',
	'ga-viewlist' => '检视礼物清单',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'ga-choosefile' => '選擇檔案：',
	'ga-error-message-invalid-link' => '您輸入的連結是無效的。',
	'ga-giftdesc' => '禮物說明',
	'ga-giftimage' => '禮物圖片',
	'ga-giftname' => '禮物名稱',
	'ga-gifttype' => '禮物種類',
	'ga-goback' => '返回',
	'ga-img' => '新增/替換圖片',
	'ga-large' => '大',
	'ga-medium' => '中',
	'ga-new' => '新的',
	'ga-previous' => '上一頁',
	'ga-small' => '小',
	'ga-uploadsuccess' => '上傳成功',
	'ga-viewlist' => '檢視禮物清單',
);

