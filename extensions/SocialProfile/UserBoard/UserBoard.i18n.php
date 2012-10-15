<?php
/**
 * Internationalisation file for UserBoard extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Aaron Wright
 * @author David Pean
 * @author Purodha
 */
$messages['en'] = array(
	'boardblastlogintitle' => 'You must be logged in to send board blasts',
	'boardblastlogintext' => 'In order to send board blasts, you must be [[Special:UserLogin|logged in]].',
	'messagesenttitle' => 'Messages sent',
	'boardblasttitle' => 'Send board blast',
	'boardblaststep1' => 'Step 1 - Write your message',
	'boardblastprivatenote'	=> 'All messages will be sent as private messages',
	'boardblaststep2' => 'Step 2 - Select who you want to send your message to',
	'boardlinkselectall' => 'Select all',
	'boardlinkunselectall' => 'Unselect all',
	'boardlinkselectfriends' => 'Select friends',
	'boardlinkunselectfriends' => 'Unselect friends',
	'boardlinkselectfoes' => 'Select foes',
	'boardlinkunselectfoes' => 'Unselect foes',
	'boardsendbutton' => 'Send board blast',
	'boardnofriends' => 'You have no friends to send a message to!',
	'messagesentsuccess' => 'Your message was successfully sent',
	'userboard' => 'User board',
	'userboard_board-to-board' => 'Board-to-board',
	'userboard_delete' => 'Delete',
	'userboard_noexist' => 'The user you are trying to view does not exist.',
	'userboard_yourboard' => 'Your board',
	'userboard_owner' => '$1\'s board',
	'userboard_yourboardwith' => 'Your board-to-board with $1',
	'userboard_otherboardwith' => '$1\'s board-to-board with $2',
	'userboard_backprofile' => 'Back to $1\'s profile',
	'userboard_backyourprofile' => 'Back to your profile',
	'userboard_boardtoboard' => 'Board-to-board',
	'userboard_confirmdelete' => 'Are you sure you want to delete this message?',
	'userboard_sendmessage' => 'Send $1 a message',
	'userboard_myboard' => 'My board',
	'userboard_posted_ago' => 'posted $1 ago',
	'userboard_private' => 'private',
	'userboard_public' => 'public',
	'userboard_messagetype' => 'Message type',
	'userboard_nextpage' => 'next',
	'userboard_prevpage' => 'prev',
	'userboard_nomessages' => 'No messages.',
	'userboard_sendbutton' => 'send',
	'userboard_loggedout' => 'You must be <a href="$1">logged in</a> to post messages to other users.',
	'userboard_showingmessages' => 'Showing {{PLURAL:$4|message $3|messages $2-$3}} of {{PLURAL:$1|$1 message|$1 messages}}.',
	'right-userboard-delete' => "Delete others' board messages",
	'userboard-time-days' => '{{PLURAL:$1|one day|$1 days}}',
	'userboard-time-hours' => '{{PLURAL:$1|one hour|$1 hours}}',
	'userboard-time-minutes' => '{{PLURAL:$1|one minute|$1 minutes}}',
	'userboard-time-seconds' => '{{PLURAL:$1|one second|$1 seconds}}',
	'message_received_subject' => '$1 wrote on your board on {{SITENAME}}',
	'message_received_body' => 'Hi $1.

$2 just wrote on your board on {{SITENAME}}!

Click below to check out your board!

$3

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable email notifications.'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Translationista
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'boardblastlogintitle' => 'As I understand it, it is a sort of board tool to leave messages. Is it?
http://www.mediawiki.org/wiki/Extension:SocialProfile#Board_Blast',
	'userboard_delete' => '{{Identical|Delete}}',
	'userboard_private' => '{{Identical|Private}}',
	'userboard_public' => '{{Identical|Public}}',
	'userboard_nextpage' => '{{Identical|Next}}',
	'userboard_prevpage' => '{{Identical|Prev}}',
	'userboard_sendbutton' => '{{Identical|Send}}',
	'userboard_showingmessages' => "* '''$1''' is the total count of messages
* '''$2''' is the number of the first message shown
* '''$3''' is the number of the last message shown
* '''$4''' is the count of messages acutally shown",
	'right-userboard-delete' => '{{doc-right|userboard-delete}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'userboard_delete' => 'Tamate',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'userboard_delete' => 'Skrap',
	'userboard_private' => 'persoonlik',
	'userboard_public' => 'publiek',
	'userboard_nextpage' => 'volgende',
	'userboard_prevpage' => 'vorige',
	'userboard_nomessages' => 'Geen boodskappe.',
	'userboard_sendbutton' => 'stuur',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'userboard_nextpage' => 'ቀጥሎ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'userboard_delete' => 'Borrar',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'boardblastlogintitle' => 'ينبغي أن تكون مسجلًا الدخول لترسل بورد بلاست',
	'boardblastlogintext' => 'لإرسال بورد بلاست،
يجب أن تكون <a href="index.php?title=Special:UserLogin">مسجل الدخول</a>.',
	'messagesenttitle' => 'الرسائل تم إرسالها',
	'boardblasttitle' => 'أرسل بورد بلاست',
	'boardblaststep1' => 'خطوة 1 - اكتب رسالتك',
	'boardblastprivatenote' => 'كل الرسائل سترسل كرسائل خاصة',
	'boardblaststep2' => 'خطوة 2 - اختر الشخص الذي تود إرسال رسالتك إليه',
	'boardlinkselectall' => 'اختر الكل',
	'boardlinkunselectall' => 'ألغِ اختيار الكل',
	'boardlinkselectfriends' => 'اختيار الأصدقاء',
	'boardlinkunselectfriends' => 'عكس اختيار الأصدقاء',
	'boardlinkselectfoes' => 'اختر الأعداء',
	'boardlinkunselectfoes' => 'عكس اختيار الأعداء',
	'boardsendbutton' => 'أرسل بورد بلاست',
	'boardnofriends' => 'لا تمتلك أي أصدقاء لترسل رسالة إليهم!',
	'messagesentsuccess' => 'رسالتك أُرسلت بنجاح',
	'userboard' => 'مجلس المستخدم',
	'userboard_board-to-board' => 'بورد إلى بورد',
	'userboard_delete' => 'احذف',
	'userboard_noexist' => 'المستخدم الذي تحاول عرضه غير موجود.',
	'userboard_yourboard' => 'مجلسك',
	'userboard_owner' => 'بورد الخاص ب$1',
	'userboard_yourboardwith' => 'مجلسك إلى مجلس مع $1',
	'userboard_otherboardwith' => 'مجلس إلى مجلس الخاص ب$1 مع $2',
	'userboard_backprofile' => 'ارجع إلى ملف $1',
	'userboard_backyourprofile' => 'ارجع إلى ملفك',
	'userboard_boardtoboard' => 'مجلس إلى مجلس',
	'userboard_confirmdelete' => 'هل أنت متأكد أنك تريد حذف هذه الرسالة؟',
	'userboard_sendmessage' => 'أرسل رسالة إلى $1',
	'userboard_myboard' => 'مجلسي',
	'userboard_posted_ago' => 'بعث منذ $1',
	'userboard_private' => 'خاص',
	'userboard_public' => 'علني',
	'userboard_messagetype' => 'نوع الرسالة',
	'userboard_nextpage' => 'بعد',
	'userboard_prevpage' => 'قبل',
	'userboard_nomessages' => 'لا رسائل.',
	'userboard_sendbutton' => 'أرسل',
	'userboard_loggedout' => 'يجب أن تكون <a href="$1">مُسجلًا الدخول</a> لترسل رسائل إلى المستخدمين الآخرين.',
	'userboard_showingmessages' => 'يعرض {{PLURAL:$4||الرسالة $3|الرسالتين $2-$3|الرسائل $2-$3}} من أصل {{PLURAL:$1||رسالة واحدة|رسالتين|$1 رسائل|$1 رسالة}}',
	'right-userboard-delete' => 'حذف رسائل حائط الآخرين',
	'userboard-time-days' => '{{PLURAL:$1||يوم واحد|يومان|$1 أيام|$1 يومًا|$1 يوم}}',
	'userboard-time-hours' => '{{PLURAL:$1||ساعة واحدة|ساعتان|$1 ساعات|$1 ساعة}}',
	'userboard-time-minutes' => '{{PLURAL:$1||دقيقة واحدة|دقيقتان|$1 دقائق|$1 دقيقة}}',
	'userboard-time-seconds' => '{{PLURAL:$1||ثانية واحدة|ثانيتان|$1 ثوانٍ|$1 ثانية}}',
	'message_received_subject' => '$1 كتب على مجلسك في {{SITENAME}}',
	'message_received_body' => 'مرحبا $1:

$2 كتب حالا على مجلسك في {{SITENAME}}!

اضغط بالأسفل للتحقق من مجلسك!

$3

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'userboard_delete' => 'ܫܘܦ',
	'userboard_private' => 'ܦܪܨܘܦܝܐ',
	'userboard_messagetype' => 'ܐܕܫܐ ܕܐܓܪܬܐ',
	'userboard_nextpage' => 'ܒܬܪ',
	'userboard_prevpage' => 'ܩܕܡ',
	'userboard_nomessages' => 'ܠܝܬ ܐܓܪ̈ܬܐ',
	'userboard-time-days' => '{{PLURAL:$1|ܚܕ ܝܘܡܐ|$1 ܝܘܡܬ̈ܐ}}',
	'userboard-time-hours' => '{{PLURAL:$1|ܚܕܐ ܫܥܬܐ|$1 ܫܥܬ̈ܐ}}',
	'userboard-time-minutes' => '{{PLURAL:$1|ܚܕܐ ܩܛܝܢܬܐ|$1 ܩܛܝܢ̈ܬܐ}}',
	'userboard-time-seconds' => '{{PLURAL:$1|ܚܕ ܪܦܦܐ|$1 ܪ̈ܦܦܐ}}',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'boardblastlogintitle' => 'أنت ينبغى أن تكون مسجل الدخول لترسل بورد بلاست',
	'boardblastlogintext' => 'لإرسال بورد بلاست،
يجب أن تكون <a href="index.php?title=Special:UserLogin">مسجل الدخول</a>.',
	'messagesenttitle' => 'الرسائل تم إرسالها',
	'boardblasttitle' => 'أرسل بورد بلاست',
	'boardblaststep1' => 'خطوة 1 - اكتب رسالتك',
	'boardblastprivatenote' => 'كل الرسائل سترسل كرسائل خاصة',
	'boardblaststep2' => 'خطوة 2 - انتقِ الذى تود إرسال رسالتك إليه',
	'boardlinkselectall' => 'اختيار الكل',
	'boardlinkunselectall' => 'عكس اختيار الكل',
	'boardlinkselectfriends' => 'اختيار الأصدقاء',
	'boardlinkunselectfriends' => 'عكس اختيار الأصدقاء',
	'boardlinkselectfoes' => 'اختيار الأعداء',
	'boardlinkunselectfoes' => 'عكس اختيار الأعداء',
	'boardsendbutton' => 'أرسل بورد بلاست',
	'boardnofriends' => 'لا تمتلك أى أصدقاء لترسل رسالة إليهم!',
	'messagesentsuccess' => 'رسالتك أُرسلت بنجاح',
	'userboard' => 'مجلس المستخدم',
	'userboard_board-to-board' => 'بورد إلى بورد',
	'userboard_delete' => 'احذف',
	'userboard_noexist' => 'المستخدم الذى تحاول عرضه غير موجود.',
	'userboard_yourboard' => 'مجلسك',
	'userboard_owner' => 'بورد الخاص ب$1',
	'userboard_yourboardwith' => 'مجلسك إلى مجلس مع $1',
	'userboard_otherboardwith' => 'مجلس إلى مجلس الخاص ب$1 مع $2',
	'userboard_backprofile' => 'رجوع إلى ملف $1',
	'userboard_backyourprofile' => 'الرجوع إلى ملفك',
	'userboard_boardtoboard' => 'مجلس إلى مجلس',
	'userboard_confirmdelete' => 'هل أنت متأكد أنك تريد حذف هذه الرسالة؟',
	'userboard_sendmessage' => 'أرسل رسالة إلى $1',
	'userboard_myboard' => 'مجلسي',
	'userboard_posted_ago' => 'بعث منذ $1',
	'userboard_private' => 'خاص',
	'userboard_public' => 'علني',
	'userboard_messagetype' => 'نوع الرسالة',
	'userboard_nextpage' => 'بعد',
	'userboard_prevpage' => 'قبل',
	'userboard_nomessages' => 'لا رسائل.',
	'userboard_sendbutton' => 'إرسال',
	'userboard_loggedout' => 'أنت يجب أن تكون <a href="$1">مسجل الدخول</a> لترسل رسائل إلى المستخدمين الآخرين.',
	'userboard_showingmessages' => 'عرض {{PLURAL:$4|الرسالة $3|الرسايل $2-$3}} من {{PLURAL:$1|$1 رسالة|$1 رسالة}}',
	'message_received_subject' => '$1 كتب على مجلسك فى {{SITENAME}}',
	'message_received_body' => 'مرحبا $1:

$2 كتب حالا على مجلسك فى {{SITENAME}}!

اضغط بالأسفل للتحقق من مجلسك!

$3

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكترونى.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'boardlinkselectall' => 'Hamısını seç',
	'userboard_delete' => 'Sil',
	'userboard_public' => 'ictimai',
	'userboard_nextpage' => 'növbəti',
	'userboard_sendbutton' => 'göndər',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'boardblastlogintitle' => 'Вам неабходна ўвайсьці ў сыстэму, каб дасылаць паведамленьні на агульную дошку',
	'boardblastlogintext' => 'Вам неабходна [[Special:UserLogin|ўвайсьці ў сыстэму]], каб дасылаць паведамленьні на агульную дошку.',
	'messagesenttitle' => 'Паведамленьні дасланыя',
	'boardblasttitle' => 'Адпраўка паведамленьня на дошку',
	'boardblaststep1' => 'Крок 1: Напішыце Вашае паведамленьне',
	'boardblastprivatenote' => 'Усе паведамленьні будуць дасланыя як прыватныя',
	'boardblaststep2' => 'Крок 2: Выберыце, каму Вы жадаеце даслаць Ваша паведамленьне',
	'boardlinkselectall' => 'Выбраць усіх',
	'boardlinkunselectall' => 'Зьняць выбар',
	'boardlinkselectfriends' => 'Выбраць сяброў',
	'boardlinkunselectfriends' => 'Зьняць выбар сяброў',
	'boardlinkselectfoes' => 'Выбраць ворагаў',
	'boardlinkunselectfoes' => 'Зьняць выбар ворагаў',
	'boardsendbutton' => 'Даслаць паведамленьне на дошку',
	'boardnofriends' => 'У Вас няма сяброў, якім можна даслаць паведамленьне!',
	'messagesentsuccess' => 'Ваша паведамленьне было даслана',
	'userboard' => 'Дошка ўдзельніка',
	'userboard_board-to-board' => 'Дошка-да-дошкі',
	'userboard_delete' => 'Выдаліць',
	'userboard_noexist' => 'Удзельніка, якога Вы спрабуеце паглядзець, не існуе.',
	'userboard_yourboard' => 'Ваша дошка',
	'userboard_owner' => 'Дошка ўдзельніка $1',
	'userboard_yourboardwith' => 'Ваша дошка-на-дошку з $1',
	'userboard_otherboardwith' => 'Дошка-на-дошку ўдзельніка $1 з $2',
	'userboard_backprofile' => 'Вярнуцца да профілю ўдзельніка $1',
	'userboard_backyourprofile' => 'Вярнуцца да Вашага профілю',
	'userboard_boardtoboard' => 'Дошка-на-дошку',
	'userboard_confirmdelete' => 'Вы ўпэўнены, што жадаеце выдаліць гэта паведамленьне?',
	'userboard_sendmessage' => 'Даслаць паведамленьне $1',
	'userboard_myboard' => 'Мая дошка',
	'userboard_posted_ago' => 'разьмешчана $1 таму',
	'userboard_private' => 'прыватнае',
	'userboard_public' => 'публічнае',
	'userboard_messagetype' => 'Тып паведамленьня',
	'userboard_nextpage' => 'наступная',
	'userboard_prevpage' => 'папярэдняя',
	'userboard_nomessages' => 'Няма паведамленьняў.',
	'userboard_sendbutton' => 'даслаць',
	'userboard_loggedout' => 'Вам неабходна <a href="$1">ўвайсьці ў сыстэму</a>, каб пісаць паведамленьні іншым удзельнікам.',
	'userboard_showingmessages' => '{{PLURAL:$4|Паказанае паведамленьне $3|Паказаныя паведамленьньні $2-$3}} з $1 {{PLURAL:$1|паведамленьня|паведамленьняў|паведамленьняў}}',
	'right-userboard-delete' => 'выдаленьне паведамленьняў іншых удзельнікаў з дошкі',
	'userboard-time-days' => '$1 {{PLURAL:$1|дзень|дні|дзён}}',
	'userboard-time-hours' => '$1 {{PLURAL:$1|гадзіна|гадзіны|гадзінаў}}',
	'userboard-time-minutes' => '$1 {{PLURAL:$1|хвіліна|хвіліны|хвілінаў}}',
	'userboard-time-seconds' => '$1 {{PLURAL:$1|сэкунда|сэкунды|сэкундаў}}',
	'message_received_subject' => '$1 напісаў на Вашай дошцы ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'message_received_body' => 'Прывітаньне, $1.

$2 толькі што напісаў на Вашай дошцы ў {{GRAMMAR:месны|{{SITENAME}}}}!

Націсьніце ніжэй, каб праверыць Вашу дошку!

$3

---


Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4 і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'messagesenttitle' => 'Изпратени съобщения',
	'boardblaststep1' => 'Стъпка 1 - Писане на съобщение',
	'boardblastprivatenote' => 'Всички съобщения ще бъдат изпращани като лични съобщения',
	'boardblaststep2' => 'Стъпка 2 - Избиране на потребители, до които да бъде изпратено съобщението',
	'boardlinkselectall' => 'Маркиране на всички',
	'boardlinkunselectall' => 'Размаркиране на всички',
	'boardlinkselectfriends' => 'Маркиране на приятелите',
	'boardlinkunselectfriends' => 'Размаркиране на приятелите',
	'boardlinkselectfoes' => 'Маркиране на неприятелите',
	'boardlinkunselectfoes' => 'Размаркиране на неприятелите',
	'boardnofriends' => 'Нямате приятели, на които да изпращате съобщения!',
	'messagesentsuccess' => 'Съобщението беше изпратено успешно',
	'userboard' => 'Потребителско табло',
	'userboard_board-to-board' => 'Табло-до-табло',
	'userboard_delete' => 'Изтриване',
	'userboard_noexist' => 'Потребителят, който се опитахте да видите, не съществува.',
	'userboard_yourboard' => 'Вашето табло',
	'userboard_owner' => 'Табло на $1',
	'userboard_yourboardwith' => 'Вашето табло-до-табло с $1',
	'userboard_otherboardwith' => 'Табло-до-табло на $1 с $2',
	'userboard_backprofile' => 'Връщане към профила на $1',
	'userboard_backyourprofile' => 'Обратно към профила ми',
	'userboard_boardtoboard' => 'Табло-до-табло',
	'userboard_confirmdelete' => 'Необходимо е потвърждение за изтриване на съобщението.',
	'userboard_sendmessage' => 'Изпращане на съобщение до $1',
	'userboard_myboard' => 'Моето табло',
	'userboard_posted_ago' => 'публикувано преди $1',
	'userboard_private' => 'лично',
	'userboard_public' => 'публично',
	'userboard_messagetype' => 'Тип съобщение',
	'userboard_nextpage' => 'следващи',
	'userboard_prevpage' => 'предишни',
	'userboard_nomessages' => 'Няма съобщения.',
	'userboard_sendbutton' => 'изпращане',
	'userboard_loggedout' => 'За изпращане на съобщения до другите потребители е необходимо <a href="$1">влизане</a> в системата.',
	'userboard_showingmessages' => 'Показване на {{PLURAL:$4|$3 съобщение|съобщения $2–$3}} от {{PLURAL:$1|$1 съобщение|$1 съобщения}}',
	'message_received_subject' => '$1 писа на таблото ви в {{SITENAME}}',
	'message_received_body' => 'Привет $1,

$2 тъкмо написа съобщение на таблото ви в {{SITENAME}}!

Можете да проверите таблото си чрез следната препратка:

$3

---

Не желаете да получавате повече писма от нас?

Последвайте $4
за промяна на настройките и оповестяването по е-поща.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 * @author Zaheen
 */
$messages['bn'] = array(
	'messagesenttitle' => 'বার্তা প্রেরিত',
	'boardlinkselectall' => 'সবগুলো নির্বাচন',
	'boardlinkunselectall' => 'সমস্ত নির্বাচন বাতিল করুন',
	'boardlinkselectfriends' => 'বন্ধু নির্বাচন',
	'userboard_board-to-board' => 'বোর্ড-থেকে-বোর্ডে',
	'userboard_delete' => 'মুছে ফেলা হোক',
	'userboard_yourboard' => 'আপনার বোর্ড',
	'userboard_private' => 'ব্যক্তিগত',
	'userboard_public' => 'সর্বসাধারণের',
	'userboard_messagetype' => 'বার্তার ধরন',
	'userboard_nextpage' => 'পরবর্তী',
	'userboard_prevpage' => 'পূর্ববর্তী',
	'userboard_nomessages' => 'কোনো নতুন বার্তা নেই।',
	'userboard_sendbutton' => 'প্রেরণ',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 */
$messages['br'] = array(
	'boardblastlogintitle' => "Ret eo deoc'h bezañ kevreet evit kas un darzhadenn daolenn",
	'boardblastlogintext' => 'Evit kas tarzhadennoù taolenn e rankit bezañ [[Special:UserLogin|kevreet]].',
	'messagesenttitle' => 'Kemennadennoù kaset',
	'boardblasttitle' => 'Kas un darzhadenn daolenn',
	'boardblaststep1' => 'Pazenn 1 - Skrivit ho kemennadenn',
	'boardblastprivatenote' => "An holl gemennadennoù a vo kaset deoc'h evel kemennadennoù prevez",
	'boardblaststep2' => "Pazenn 2 - Diuzit da biv hoc'h eus c'hoant da gas ho kemennadenn",
	'boardlinkselectall' => 'Diuzañ pep tra',
	'boardlinkunselectall' => 'Diziuzañ pep tra',
	'boardlinkselectfriends' => 'Diuzañ mignoned',
	'boardlinkunselectfriends' => 'Diziuzañ mignoned',
	'boardlinkselectfoes' => 'Diuzañ enebourien',
	'boardlinkunselectfoes' => 'Diziuzañ enebourien',
	'boardsendbutton' => 'Kas un darzhadenn daolenn',
	'boardnofriends' => "N'hoc'h eus mignon ebet da gas ar gemennadenn dezhañ !",
	'messagesentsuccess' => 'Kaset eo bet ho kemennadenn',
	'userboard' => 'Taolenn an implijer',
	'userboard_board-to-board' => 'Taolenn-ouzh-taolenn',
	'userboard_delete' => 'Dilemel',
	'userboard_noexist' => "N'eus ket eus an implijer emaoc'h o klask gwelet.",
	'userboard_yourboard' => 'Ho taolenn',
	'userboard_owner' => 'Taolenn $1',
	'userboard_yourboardwith' => 'Ho taolenn-ouzh-taolenn gant $1',
	'userboard_otherboardwith' => 'Taolenn-ouzh-taolenn $1 gant $2',
	'userboard_backprofile' => 'Distreiñ da brofil $1',
	'userboard_backyourprofile' => "Distreiñ d'ho profil",
	'userboard_boardtoboard' => 'Taolenn-ouzh-taolenn',
	'userboard_confirmdelete' => "Ha sur oc'h hoc'h eus c'hoant da zilemel ar gemennadenn-mañ ?",
	'userboard_sendmessage' => 'Kas ur gemennadenn da $1',
	'userboard_myboard' => 'Ma zaolenn',
	'userboard_posted_ago' => 'kaset $1 zo',
	'userboard_private' => 'prevez',
	'userboard_public' => 'foran',
	'userboard_messagetype' => 'Seurt kemennadenn',
	'userboard_nextpage' => 'da-heul',
	'userboard_prevpage' => 'kent',
	'userboard_nomessages' => 'Kemennadenn ebet',
	'userboard_sendbutton' => 'kas',
	'userboard_loggedout' => 'Ret eo deoc\'h bezañ <a href="$1">kevreet</a> evit kas kemennadennoù d\'an implijerien all.',
	'userboard_showingmessages' => 'O tiskouez {{PLURAL:$4|kemennadenn$3|kemennadenn$2-$3}} diwar {{PLURAL:$1|$1 gemennadenn|$1 kemennadenn}}',
	'right-userboard-delete' => "Dilemel ar c'hemennadennoù gant implijerien all",
	'userboard-time-days' => '{{PLURAL:$1|un deiz|$1 deiz}}',
	'userboard-time-hours' => '{{PLURAL:$1|un eurvezh|$1 eurvezh}}',
	'userboard-time-minutes' => '{{PLURAL:$1|ur vunutenn|$1 munutenn}}',
	'userboard-time-seconds' => '{{PLURAL:$1|un eilenn|$1 eilenn}}',
	'message_received_subject' => '$1 en deus skrivet war ho taolenn war {{SITENAME}}',
	'message_received_body' => "Salud deoc'h, $1.

Emañ $2 o paouez skrivañ war ho taolenn war {{SITENAME}} !

Klikit war al liamm amañ dindan evit gwelet ho taolenn !

$3

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'boardblastlogintitle' => 'Morate biti prijavljeni da biste mogli slati izjave na tabli',
	'boardblastlogintext' => 'Da biste poslali izjavu na tablu, morate biti [[Special:UserLogin|prijavljeni]].',
	'messagesenttitle' => 'Poruke poslane',
	'boardblasttitle' => 'Pošalji izjavu na tablu',
	'boardblaststep1' => 'Korak 1 - Napišite Vašu poruku',
	'boardblastprivatenote' => 'Sve poruke će biti poslane kao privatne poruke',
	'boardblaststep2' => 'Korak 2 - Odaberite kome želite poslati Vašu poruku',
	'boardlinkselectall' => 'Označi sve',
	'boardlinkunselectall' => 'Ukloni sav odabir',
	'boardlinkselectfriends' => 'Odaberi prijatelje',
	'boardlinkunselectfriends' => 'Deselektiraj prijatelje',
	'boardlinkselectfoes' => 'Odaberi neprijatelje',
	'boardlinkunselectfoes' => 'Deselektiraj neprijatelje',
	'boardsendbutton' => 'Pošalji izjavu na tablu',
	'boardnofriends' => 'Nemate prijatelja za slanje poruka!',
	'messagesentsuccess' => 'Vaša poruka je uspješno poslana',
	'userboard' => 'Korisnička ploča',
	'userboard_board-to-board' => 'Sa table na tablu',
	'userboard_delete' => 'Obriši',
	'userboard_noexist' => 'Korisnik kojeg pokušavate pogledati ne postoji.',
	'userboard_yourboard' => 'Vaša tabla',
	'userboard_owner' => 'Tabla od $1',
	'userboard_yourboardwith' => 'Sa vaše table na tablu od $1',
	'userboard_otherboardwith' => 'Sa table od $1 na tablu od $2',
	'userboard_backprofile' => 'Nazad na profil korisnika $1',
	'userboard_backyourprofile' => 'Nazad na Vaš profil',
	'userboard_boardtoboard' => 'Sa table na tablu',
	'userboard_confirmdelete' => 'Da li ste sigurni da želite obrisati ovu poruku?',
	'userboard_sendmessage' => 'Pošalji $1 poruku',
	'userboard_myboard' => 'Moja ploča',
	'userboard_posted_ago' => 'poslano prije $1',
	'userboard_private' => 'privatno',
	'userboard_public' => 'javno',
	'userboard_messagetype' => 'Vrsta poruke',
	'userboard_nextpage' => 'slijedeće',
	'userboard_prevpage' => 'preth',
	'userboard_nomessages' => 'Nema poruka.',
	'userboard_sendbutton' => 'pošalji',
	'userboard_loggedout' => 'Morate biti <a href="$1">prijavljeni</a> da biste mogli slati poruke drugim korisnicima.',
	'userboard_showingmessages' => 'Prikazujem {{PLURAL:$4|poruku $3|poruke $2-$3}} od {{PLURAL:$1|$1 poruku|$1 poruke|$1 poruka}}',
	'right-userboard-delete' => 'Brisanje poruka na tabli od drugih korisnika',
	'userboard-time-days' => '{{PLURAL:$1|jedan dan|$1 dana}}',
	'userboard-time-hours' => '{{PLURAL:$1|jedan sat|$1 sata|$1 sati}}',
	'userboard-time-minutes' => '{{PLURAL:$1|jedna minuta|$1 minute|$1 minuta}}',
	'userboard-time-seconds' => '{{PLURAL:$1|jedna sekunda|$1 sekunde|$1 sekundi}}',
	'message_received_subject' => '$1 je pisao na vašoj tabli na {{SITENAME}}',
	'message_received_body' => 'Zdravo $1.

$2 je upravo pisao na vašoj tabli na {{SITENAME}}!

Kliknite ispod da provjerite vašu tablu!

$3

---

Da li želite prestati da dobijate e-mailove od nas?

Kliknite $4
i promijenite vaše postavke da onemogućite obavještenje putem maila.',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'messagesenttitle' => 'Missatges enviats',
	'boardlinkselectall' => "Selecciona'ls tots",
	'boardlinkselectfriends' => 'Selecciona amics',
	'userboard_delete' => 'Elimina',
	'userboard_private' => 'privat',
	'userboard_public' => 'públic',
	'userboard_nextpage' => 'següent',
	'userboard_prevpage' => 'ant',
	'userboard_nomessages' => 'Cap missatge.',
	'userboard_sendbutton' => 'envia',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'userboard_nextpage' => 'кхин',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'userboard_delete' => 'سڕینەوە',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'boardblastlogintitle' => 'Musíte se přihlásit, aby jste mohli posílat zprávy fóra.',
	'boardblastlogintext' => 'Musíte se přihlásit, aby jste mohli posílat zprávy fóra.
Klikněte <a href="index.php?title=Special:UserLogin">sem</a> pro přihlášení.',
	'messagesenttitle' => 'Odeslanýh zpráv',
	'boardblasttitle' => 'Poslat zprávu fóra',
	'boardblaststep1' => 'Krok 1: Napište svoji zprávu',
	'boardblastprivatenote' => 'Všechny zprávy se pošlou jako soukromé zprávy.',
	'boardblaststep2' => 'Krok 2: Vyberte, komu chcete svoji zprávu poslat.',
	'boardlinkselectall' => 'Vybrat všechny',
	'boardlinkunselectall' => 'Zrušit výběr',
	'boardlinkselectfriends' => 'Vybrat přátele',
	'boardlinkunselectfriends' => 'Zrušit výběr přátel',
	'boardlinkselectfoes' => 'Vybrat nepřátele',
	'boardlinkunselectfoes' => 'Zrušit výběr nepřátel',
	'boardsendbutton' => 'Poslat zprávu fóra',
	'boardnofriends' => 'Nemáte žádné přátele, kterým by jste mohli poslat zprávu!',
	'messagesentsuccess' => 'Vaše zpráva byla úspěšně odeslána.',
	'userboard' => 'Uživatelské fórum',
	'userboard_board-to-board' => 'Mezi fóry',
	'userboard_delete' => 'Smazat',
	'userboard_noexist' => 'Uživatel, kterého se pokoušíte zobrazit, neexistuje.',
	'userboard_yourboard' => 'Vaše fórum',
	'userboard_owner' => 'Fórum uživatele $1',
	'userboard_yourboardwith' => 'Vaše fórum s uživatelem $1',
	'userboard_otherboardwith' => 'Fórum uživatele $1 s uživatelem $2',
	'userboard_backprofile' => 'Zpět na profil uživatelel $1',
	'userboard_backyourprofile' => 'Zpět na váš profil',
	'userboard_boardtoboard' => 'Fórum s uživatelem',
	'userboard_confirmdelete' => 'Jste si jistý, že chcete smazat tuto zprávu?',
	'userboard_sendmessage' => 'Poslat zprávu uživateli $1',
	'userboard_myboard' => 'Moje fórum',
	'userboard_posted_ago' => 'poslané před $1',
	'userboard_private' => 'soukromé',
	'userboard_public' => 'veřejné',
	'userboard_messagetype' => 'Typ zprávy',
	'userboard_nextpage' => 'další',
	'userboard_prevpage' => 'předchozí',
	'userboard_nomessages' => 'Žádné zprávy.',
	'userboard_sendbutton' => 'poslat',
	'userboard_loggedout' => 'Musíte <a href="$1">se přihlásit</a>, aby jste mohli posílat zprávy jiným uživatelům.',
	'userboard_showingmessages' => 'Zobrazují se zprávy $2-$3 {{PLURAL:$1|z $1 zprávy|ze $1 zpráv|ze $1 zpráv}}.',
	'message_received_subject' => '$1 napsal na vaše fórum na {{grammar:6sg|{{SITENAME}}}}.',
	'message_received_body' => 'Ahoj, $1:

$2 napsal na vaše fórum na {{grammar:6sg|{{SITENAME}}}}.

Po kliknutí na následující odkaz si můžete přečíst svoje fórum:

$3

---

Nepřejete si dostávat tyt e-maily?

Klikněte sem $4
a změňte svoje nastavení na vypnutí upozornění e-mailem.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'userboard_delete' => 'поничьжє́ниѥ',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'userboard_delete' => 'Slet',
	'userboard_private' => 'privat',
	'userboard_nextpage' => 'næste',
	'userboard_sendbutton' => 'send',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 * @author MF-Warburg
 * @author Purodha
 * @author Raimond Spekking
 * @author Tim 'Avatar' Bartel
 * @author Umherirrender
 */
$messages['de'] = array(
	'boardblastlogintitle' => 'Du musst angemeldet sein, um Nachrichten versenden zu können',
	'boardblastlogintext' => 'Du musst [[Special:UserLogin|angemeldet]] sein, um Nachrichten versenden zu können.',
	'messagesenttitle' => 'Nachrichten verschickt',
	'boardblasttitle' => 'Nachricht senden',
	'boardblaststep1' => 'Schritt 1: Schreibe deine Nachricht',
	'boardblastprivatenote' => 'Alle Nachrichten werden als private Mitteilungen verschickt',
	'boardblaststep2' => 'Schritt 2: Wähle aus, wem du die Nachrichte schicken willst',
	'boardlinkselectall' => 'Alle markieren',
	'boardlinkunselectall' => 'Keine markieren',
	'boardlinkselectfriends' => 'Freunde auswählen',
	'boardlinkunselectfriends' => 'Freunde abwählen',
	'boardlinkselectfoes' => 'Feinde auswählen',
	'boardlinkunselectfoes' => 'Feinde abwählen',
	'boardsendbutton' => 'Nachricht senden',
	'boardnofriends' => 'Du hast keine Freunde, denen du eine Nachricht senden könntest!',
	'messagesentsuccess' => 'Deine Nachricht wurde erfolgreich verschickt.',
	'userboard' => 'Pinnwand',
	'userboard_board-to-board' => 'Pinnwand-zu-Pinnwand',
	'userboard_delete' => 'Löschen',
	'userboard_noexist' => 'Der gesuchte Benutzer existiert nicht.',
	'userboard_yourboard' => 'Deine Pinnwand',
	'userboard_owner' => '$1s Pinnwand',
	'userboard_yourboardwith' => 'Deine Pinnwand-Diskussion mit $1',
	'userboard_otherboardwith' => '$1s Pinnwand-Diskussion mit $2',
	'userboard_backprofile' => 'Zurück zu $1s Profil',
	'userboard_backyourprofile' => 'Zurück zu deinem Profil',
	'userboard_boardtoboard' => 'Pinnwand-Diskussion',
	'userboard_confirmdelete' => 'Soll diese Nachricht tatsächlich gelöscht werden?',
	'userboard_sendmessage' => 'Schicke $1 eine Nachricht',
	'userboard_myboard' => 'Meine Pinnwand',
	'userboard_posted_ago' => 'vor $1 geschickt',
	'userboard_private' => 'privat',
	'userboard_public' => 'öffentlich',
	'userboard_messagetype' => 'Nachrichtentyp',
	'userboard_nextpage' => 'nächste',
	'userboard_prevpage' => 'vorherige',
	'userboard_nomessages' => 'Keine Nachrichten.',
	'userboard_sendbutton' => 'senden',
	'userboard_loggedout' => 'Du musst <a href="$1">angemeldet sein</a>, um Nachrichten an andere Nutzer schicken zu können.',
	'userboard_showingmessages' => 'Zeige {{PLURAL:$4|Nachricht $3|Nachrichten $2-$3}} von $1 insgesamt',
	'right-userboard-delete' => 'Nachrichten anderer vom Board löschen',
	'userboard-time-days' => '{{PLURAL:$1|ein Tag|$1 Tage}}',
	'userboard-time-hours' => '{{PLURAL:$1|eine Stunde|$1 Stunden}}',
	'userboard-time-minutes' => '{{PLURAL:$1|eine Minute|$1 Minuten}}',
	'userboard-time-seconds' => '{{PLURAL:$1|eine Sekunde|$1 Sekunden}}',
	'message_received_subject' => '$1 hat auf deine {{SITENAME}}-Pinnwand geschrieben',
	'message_received_body' => 'Hallo $1,

$2 hat eben auf deine {{SITENAME}}-Pinnwand geschrieben!

Klicke auf den folgenden Link um deine Pinnwand aufzurufen!

$3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'boardblastlogintitle' => 'Sie müssen angemeldet sein, um Nachrichten versenden zu können',
	'boardblastlogintext' => 'Sie müssen [[Special:UserLogin|angemeldet]] sein, um Nachrichten versenden zu können.',
	'boardblaststep1' => 'Schritt 1: Schreiben Sie Ihre Nachricht',
	'boardblaststep2' => 'Schritt 2: Wählen Sie aus, wem Sie die Nachrichte schicken wollen',
	'boardnofriends' => 'Sie haben keine Freunde, denen Sie eine Nachricht senden könnten!',
	'messagesentsuccess' => 'Ihre Nachricht wurde erfolgreich verschickt.',
	'userboard_yourboard' => 'Ihre Pinnwand',
	'userboard_yourboardwith' => 'Ihre Pinnwand-Diskussion mit $1',
	'userboard_backyourprofile' => 'Zurück zu Ihrem Profil',
	'userboard_loggedout' => 'Sie müssen <a href="$1">angemeldet sein</a>, um Nachrichten an andere Nutzer schicken zu können.',
	'message_received_subject' => '$1 hat auf Ihre {{SITENAME}}-Pinnwand geschrieben',
	'message_received_body' => 'Guten Tag $1,

$2 hat eben auf Ihre {{SITENAME}}-Pinnwand geschrieben!

Klicken Sie auf den folgenden Link um Ihre Pinnwand aufzurufen!

$3

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'boardblastlogintitle' => 'Musyš pśizjawjony byś, aby pósłał forumowe powěsći',
	'boardblastlogintext' => 'Musyš [[Special:UserLogin|pśizjawjony]] byś, aby pósłał forumowe powěsći.',
	'messagesenttitle' => 'Powěsći pósłane',
	'boardblasttitle' => 'Forumowu powěsć pósłaś',
	'boardblaststep1' => 'Kšac 1 - Napiš swóju powěsć',
	'boardblastprivatenote' => 'Wše powěsći pósćelu se ako priwatne powěsći',
	'boardblaststep2' => 'Kšac 2 - Wubjeŕ, komuž coš swóju powěsć pósłaś',
	'boardlinkselectall' => 'Wše wubraś',
	'boardlinkunselectall' => 'Wuběrk za wše wótpóraś',
	'boardlinkselectfriends' => 'Pśijaśelow wubraś',
	'boardlinkunselectfriends' => 'Pśijaśelow wótwóliś',
	'boardlinkselectfoes' => 'Njepśijaśelow wubraś',
	'boardlinkunselectfoes' => 'Njepśijaśelow wótwóliś',
	'boardsendbutton' => 'Forumowu powěsć pósłaś',
	'boardnofriends' => 'Njamaš žednych pśijaśelow, kótarymž by mógł powěsć pósłaś!',
	'messagesentsuccess' => 'Twója powěsć jo se wuspěšnje pósłała',
	'userboard' => 'Carna dela',
	'userboard_board-to-board' => 'Diskusija dela k deli',
	'userboard_delete' => 'Lašowaś',
	'userboard_noexist' => 'Wužywaŕ, kótaregož wopytujoš se woglědaś, njeeksistěrujo.',
	'userboard_yourboard' => 'Twója dela',
	'userboard_owner' => 'Dela wužywarja $1',
	'userboard_yourboardwith' => 'Twója diskusija dela k deli z $1',
	'userboard_otherboardwith' => 'Diskusija dela k deli wužywarja $1 z $2',
	'userboard_backprofile' => 'Slědk k profiloju wužywarja $1',
	'userboard_backyourprofile' => 'Slědk k twójemu profiloju',
	'userboard_boardtoboard' => 'Diskusija dela k deli',
	'userboard_confirmdelete' => 'Coš toś tu powěsć napšawdu lašowaś?',
	'userboard_sendmessage' => 'Wužiwarjeju $1 powěsć pósłaś',
	'userboard_myboard' => 'Mója dela',
	'userboard_posted_ago' => 'pśed $1 wótpósłany',
	'userboard_private' => 'priwatny',
	'userboard_public' => 'zjawny',
	'userboard_messagetype' => 'Typ powěsći',
	'userboard_nextpage' => 'pśiducy',
	'userboard_prevpage' => 'pjerwjejšny',
	'userboard_nomessages' => 'Žedne powěsći.',
	'userboard_sendbutton' => 'pósłaś',
	'userboard_loggedout' => 'Musyš <a href="$1">pśizjawjony</a> byś, aby pósłał powěsći drugim wužywarjam.',
	'userboard_showingmessages' => '{{PLURAL:$4|Pokazujo se powěsć $3|Pokazujotej se powěsći $2-$3|Pokazuju se powěsći $2-$3|Pokazuju se powěsći $2-$3}} z {{PLURAL:$1|$1 powěsći|$1 powěsćowu|$1 powěsćow|$1 powěsćow}}',
	'right-userboard-delete' => 'Powěsći z dele drugich wulašowaś',
	'userboard-time-days' => '{{PLURAL:$1|jaden źeń|$1 dna|$1 dny|$1 dnjow}}',
	'userboard-time-hours' => '{{PLURAL:$1|jadna góźina|$1 góźinje|$1 góźiny|$1 góźin}}',
	'userboard-time-minutes' => '{{PLURAL:$1|jadna minuta|$1 minuśe|$1 minuty|$1 minutow}}',
	'userboard-time-seconds' => '{{PLURAL:$1|jadna sekunda|$1 sekunźe|$1 sekundy|$1 sekundow}}',
	'message_received_subject' => '$1 jo napisał na twóju delu na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'message_received_body' => 'Witaj $1.

$2 jo rowno napisał na twóju delu na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Klikni dołojce, aby se woglědał swóju delu!

$3

---

Hej, njocoš wěcej e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'userboard_delete' => 'Tutui',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Evropi
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'messagesenttitle' => 'Απεσταλμένα μηνύματα',
	'boardblasttitle' => 'Αποστολή του πίνακα σε ριπή',
	'boardblaststep1' => 'Βήμα 1 - Γράψτε το μήνυμά σας',
	'boardblastprivatenote' => 'Όλα τα μηνύματα θα σταλλούν ως προσωπικά μηνύματα',
	'boardblaststep2' => 'Βήμα 2 - Επιλέξτε σε ποιον θέλετε να στείλετε το μήνυμα σας',
	'boardlinkselectall' => 'Επιλογή όλων',
	'boardlinkunselectall' => 'Αποεπιλογή όλων',
	'boardlinkselectfriends' => 'Επιλογή φίλων',
	'boardlinkunselectfriends' => 'Αποεπιλογή φίλων',
	'boardlinkselectfoes' => 'Επιλογή εχθρών',
	'boardlinkunselectfoes' => 'Αποεπιλογή εχθρών',
	'boardsendbutton' => 'Αποστολή του πίνακα σε ριπή',
	'boardnofriends' => 'Δεν έχετε φίλους για να στείλετε ένα μήνυμα!',
	'messagesentsuccess' => 'Το μήνυμά σας στάλθηκε επιτυχώς',
	'userboard' => 'Επιτροπή χρήστη',
	'userboard_board-to-board' => 'Πίνακα-σε-πίνακα',
	'userboard_delete' => 'Διαγραφή',
	'userboard_noexist' => 'Ο χρήστης που προσπαθείτε να δείτε δεν υπάρχει.',
	'userboard_yourboard' => 'Η επιτροπή σας',
	'userboard_owner' => 'Ο πίνακας του $1',
	'userboard_yourboardwith' => 'Ο πίνακας-σε-πίνακα σας με τον $1',
	'userboard_otherboardwith' => 'Ο πίνακας-σε-πίνακα του $1 με τον $2',
	'userboard_backprofile' => 'Πίσω στο προφίλ του $1',
	'userboard_backyourprofile' => 'Πίσω στο προφίλ σας',
	'userboard_boardtoboard' => 'Πίνακα-σε-πίνακα',
	'userboard_confirmdelete' => 'Είστε σίγουρος πως θέλετε να διαγράψετε αυτό το μήνυμα;',
	'userboard_sendmessage' => 'Αποστολή στον $1 ένα μήνυμα',
	'userboard_myboard' => 'Η επιτροπή μου',
	'userboard_posted_ago' => 'δημοσιεύθηκε $1 πριν',
	'userboard_private' => 'ιδιωτικός',
	'userboard_public' => 'δημόσιο',
	'userboard_messagetype' => 'Τύπος Μηνύματος',
	'userboard_nextpage' => 'επομ',
	'userboard_prevpage' => 'προηγ',
	'userboard_nomessages' => 'Κανένα μήνυμα.',
	'userboard_sendbutton' => 'αποστολή',
	'userboard_loggedout' => 'Πρέπει να είστε <a href="$1">συνδεδεμένος</a> για να δημοσιεύσετε μηνύματα σε άλλους χρήστες.',
	'right-userboard-delete' => 'Διαγραφή μηνυμάτων πίνακα άλλων',
	'userboard-time-days' => '{{PLURAL:$1|μια μέρα|$1 μέρες}}',
	'userboard-time-hours' => '{{PLURAL:$1|μια ώρα|$1 ώρες}}',
	'userboard-time-minutes' => '{{PLURAL:$1|ένα λεπτό|$1 λεπτά}}',
	'userboard-time-seconds' => '{{PLURAL:$1|ένα δευτερόλεπτο|$1 δευτερόλεπτα}}',
	'message_received_subject' => 'Ο $1 έγραψε στο πίνακά σας στο {{SITENAME}}',
	'message_received_body' => 'Γεια $1.

Ο $2 μόλις έγραψε στον πίνακά σας στο {{SITENAME}}.

Τσεκάρετε τον πίνακά σας κάνωντας κλικ εδώ!

$3

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξετε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'messagesenttitle' => 'Mesaĝoj senditaj',
	'boardblaststep1' => 'Ŝtupo 1 - Skribu vian mesaĝon',
	'boardblaststep2' => 'Ŝtupo 2 - Selektu kiun vi volas alsendi vian mesaĝon',
	'boardlinkselectall' => 'Elektu Ĉiujn',
	'boardlinkunselectall' => 'Malselektu ĉiujn',
	'boardlinkselectfriends' => 'Selektu amikojn',
	'boardlinkunselectfriends' => 'Malselektu amikojn',
	'boardlinkselectfoes' => 'Selektu malamikojn',
	'boardlinkunselectfoes' => 'Malselektu malamikojn',
	'boardnofriends' => 'Vi havas neniujn amikojn por alsendi mesaĝon!',
	'userboard' => 'Uzula afiŝejo',
	'userboard_delete' => 'Forigi',
	'userboard_yourboard' => 'Via afiŝejo',
	'userboard_owner' => 'Afiŝejo de $1',
	'userboard_backprofile' => 'Reiri al profilo de $1',
	'userboard_backyourprofile' => 'Reiri vian profilon',
	'userboard_confirmdelete' => 'Ĉu ver certas ke vi volas forigi ĉi tiun mesaĝon?',
	'userboard_sendmessage' => 'Sendu al $1 mesaĝon',
	'userboard_myboard' => 'Mia afiŝejo',
	'userboard_posted_ago' => 'afiŝita antaŭ $1',
	'userboard_private' => 'privata',
	'userboard_public' => 'publika',
	'userboard_messagetype' => 'Mesaĝa tipo',
	'userboard_nextpage' => 'sekv',
	'userboard_prevpage' => 'antaŭ',
	'userboard_nomessages' => 'Neniuj mesaĝoj.',
	'userboard_sendbutton' => 'sendi',
	'userboard_loggedout' => 'Vi devas <a href="$1">ensaluti</a> por afiŝi mesaĝojn al aliaj uzantoj.',
	'userboard_showingmessages' => 'Montrante {{PLURAL:$4|mesaĝon|mesaĝojn $2-$3}} el {{PLURAL:$1|$1 mesaĝo|$1 mesaĝoj}}',
	'userboard-time-days' => '{{PLURAL:$1|unu tago|$1 tagoj}}',
	'userboard-time-hours' => '{{PLURAL:$1|unu horo|$1 horoj}}',
	'message_received_subject' => '$1 skribis en via afiŝejon en {{SITENAME}}',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Imre
 * @author Locos epraix
 * @author Mor
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'boardblastlogintitle' => 'Ud. debe ingresar como usuario para enviar mensajes a otros tablones',
	'boardblastlogintext' => 'Para enviar mensajes, Ud. debe [[Special:UserLogin|ingresar como usuario]].',
	'messagesenttitle' => 'Mensajes enviados',
	'boardblasttitle' => 'Enviar mensaje a otros tablones',
	'boardblaststep1' => 'Paso 1 - Escribe tu mensaje',
	'boardblastprivatenote' => 'Todos los mensajes serán enviados como mensajes privados',
	'boardblaststep2' => 'Paso 2 - Selecciona a quién deseas enviar el mensaje',
	'boardlinkselectall' => 'Seleccionar todo',
	'boardlinkunselectall' => 'Deseleccionar todo',
	'boardlinkselectfriends' => 'Seleccionar amigos',
	'boardlinkunselectfriends' => 'Deseleccionar amigos',
	'boardlinkselectfoes' => 'Seleccionar enemigos',
	'boardlinkunselectfoes' => 'Deseleccionar enemigos',
	'boardsendbutton' => 'Enviar mensaje',
	'boardnofriends' => '¡No tienes amigos a los que enviar un mensaje!',
	'messagesentsuccess' => 'Tu mensaje fue enviado exitosamente',
	'userboard' => 'Tablón del usuario',
	'userboard_board-to-board' => 'Tablón a tablón',
	'userboard_delete' => 'Borrar',
	'userboard_noexist' => 'El usuario que tratas de ver no existe.',
	'userboard_yourboard' => 'Tu tablón',
	'userboard_owner' => 'tablón de $1',
	'userboard_yourboardwith' => 'Tu tablón a tablón con $1',
	'userboard_otherboardwith' => 'Tablón de $1con $2',
	'userboard_backprofile' => 'Regresar al perfil de $1',
	'userboard_backyourprofile' => 'Regresar a tu perfil',
	'userboard_boardtoboard' => 'Tablón a tablón',
	'userboard_confirmdelete' => '¿Seguro que deseas borrar este mensaje?',
	'userboard_sendmessage' => 'Enviar a $1 un mensaje',
	'userboard_myboard' => 'Mi tablón',
	'userboard_posted_ago' => 'Enviado hace $1',
	'userboard_private' => 'privado',
	'userboard_public' => 'público',
	'userboard_messagetype' => 'Tipo de mensaje',
	'userboard_nextpage' => 'siguiente',
	'userboard_prevpage' => 'anterior',
	'userboard_nomessages' => 'Sin mensajes.',
	'userboard_sendbutton' => 'enviar',
	'userboard_loggedout' => 'Tienes que haber <a href="$1">iniciado sesión</a> para enviar mensajes a otros usuarios.',
	'userboard_showingmessages' => 'Mostrando {{PLURAL:$4|mensaje $3|mensajes $2-$3}} de {{PLURAL:$1|$1 mensaje|$1 mensajes}}',
	'right-userboard-delete' => 'Borrar otros mensajes del tablón',
	'userboard-time-days' => '{{PLURAL:$1|un día|$1 días}}',
	'userboard-time-hours' => '{{PLURAL:$1|una hora|$1 horas}}',
	'userboard-time-minutes' => '{{PLURAL:$1|un minuto|$1 minutos}}',
	'userboard-time-seconds' => '{{PLURAL:$1|un segundo|$1 segundos}}',
	'message_received_subject' => '$1 escribió en tu tablón en {{SITENAME}}',
	'message_received_body' => 'Hola, $1.

$2 acaba de escribir en tu tablón en {{SITENAME}}!

¡Haz click debajo para revisar tu tablón!

$3

---

Hey, ¿deseas dejar de recibir correos electrónicos de nosotros?

Haz click en $4
y cambia tus configuraciones para deshabilitar notificaciones por correo electrónico.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'messagesenttitle' => 'Sõnumid saadetud',
	'boardlinkselectall' => 'Vali kõik',
	'boardlinkselectfriends' => 'Vali sõbrad',
	'boardlinkselectfoes' => 'Vali vaenlased',
	'boardnofriends' => 'Sul ei ole sõpru, kellele sõnumit saata!',
	'userboard_delete' => 'Kustuta',
	'userboard_backyourprofile' => 'Tagasi oma profiili juurde',
	'userboard_confirmdelete' => 'Kas Sa oled kindel, et soovid seda sõnumit kustutada?',
	'userboard_private' => 'erasõnum',
	'userboard_public' => 'avalik',
	'userboard_messagetype' => 'Sõnumi tüüp',
	'userboard_nextpage' => 'järgmine',
	'userboard_prevpage' => 'eelmine',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'messagesenttitle' => 'Bidalitako mezuak',
	'boardblaststep1' => '1. pausoa - Zure mezua idatzi',
	'boardblaststep2' => '2. pausoa - Mezua nori bidali nahi diozun aukeratu',
	'boardlinkselectall' => 'Guztiak hautatu',
	'boardlinkunselectall' => 'Guztiak desautatu',
	'boardlinkselectfriends' => 'Lagunak hautatu',
	'boardlinkunselectfriends' => 'Lagunak deshautatu',
	'boardlinkselectfoes' => 'Etsaiak hautatu',
	'boardlinkunselectfoes' => 'Etsaiak deshautatu',
	'userboard_delete' => 'Ezabatu',
	'userboard_backprofile' => '$1-(r)en perfilera itzuli',
	'userboard_backyourprofile' => 'Perfilera itzuli',
	'userboard_confirmdelete' => 'Ziur zaude mezu hau ezabatu nahi duzula?',
	'userboard_sendmessage' => '$1-(r)i mezua bidali',
	'userboard_private' => 'pribatua',
	'userboard_public' => 'publikoa',
	'userboard_messagetype' => 'Mezu mota',
	'userboard_nextpage' => 'hurrengo',
	'userboard_prevpage' => 'aurreko',
	'userboard_nomessages' => 'Ez dago mezurik.',
	'userboard_sendbutton' => 'bidali',
	'userboard-time-days' => '{{PLURAL:$1|egun bat|$1 egun}}',
	'userboard-time-hours' => '{{PLURAL:$1|ordu bat|$1 ordu}}',
	'userboard-time-minutes' => '{{PLURAL:$1|minutu bat|$1 minutu}}',
	'userboard-time-seconds' => '{{PLURAL:$1|segundo bat|$1 segundo}}',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'messagesenttitle' => 'پیام‌ها ارسال شدند',
	'boardlinkselectall' => 'انتخاب همه',
	'userboard_delete' => 'حذف',
	'userboard_private' => 'خصوصی',
	'userboard_public' => 'عمومی',
	'userboard_nextpage' => 'بعدی',
	'userboard_prevpage' => 'قبلی',
	'userboard_nomessages' => 'پيامى وجود ندارد.',
	'userboard_sendbutton' => 'ارسال',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix
 * @author Mobe
 * @author Nike
 */
$messages['fi'] = array(
	'boardblastlogintitle' => 'Sinun tulee olla sisäänkirjautunut lähettääksesi keskustelupläjäyksiä',
	'boardblastlogintext' => 'Sinun tulee olla [[Special:UserLogin|sisäänkirjautunut]] lähettääksesi keskusteluja.',
	'messagesenttitle' => 'Viestit lähetetty',
	'boardblasttitle' => 'Lähetä keskustelupläjäys',
	'boardblaststep1' => 'Vaihe 1 – Kirjoita viestisi',
	'boardblastprivatenote' => 'Kaikki viestit lähetetään yksityisviesteinä',
	'boardblaststep2' => 'Vaihe 2 – Valitse kenelle haluat lähettää viestisi',
	'boardlinkselectall' => 'Valitse kaikki',
	'boardlinkunselectall' => 'Poista valinta kaikista',
	'boardlinkselectfriends' => 'Valitse ystäviä',
	'boardlinkunselectfriends' => 'Poista valinta ystävistä',
	'boardlinkselectfoes' => 'Valitse vihollisia',
	'boardlinkunselectfoes' => 'Poista valinta vihollisista',
	'boardsendbutton' => 'Lähetä keskustelupläjäys',
	'boardnofriends' => 'Sinulla ei ole ystäviä, joille lähettää viestejä!',
	'messagesentsuccess' => 'Viestisi lähetettiin onnistuneesti',
	'userboard' => 'Käyttäjän keskustelualue',
	'userboard_board-to-board' => 'Käyttäjäkeskustelu',
	'userboard_delete' => 'Poista',
	'userboard_noexist' => 'Käyttäjää, jota yrität katsoa ei ole olemassa.',
	'userboard_yourboard' => 'Oma keskustelualueeni',
	'userboard_owner' => '{{GRAMMAR:genitive|$1}} keskustelualue',
	'userboard_yourboardwith' => 'Sinun keskustelualueelta-keskustelualueelle käyttäjän $1 kanssa',
	'userboard_otherboardwith' => '{{GRAMMAR:genitive|$1}} keskustelualueelta-keskustelualueelle käyttäjän $2 kanssa',
	'userboard_backprofile' => 'Takaisin {{GRAMMAR:genitive|$1}} profiiliin',
	'userboard_backyourprofile' => 'Takaisin käyttäjäprofiiliisi',
	'userboard_boardtoboard' => 'Keskustelualueelta-keskustelualueelle',
	'userboard_confirmdelete' => 'Oletko varma, että haluat poistaa tämän viestin?',
	'userboard_sendmessage' => 'Lähetä käyttäjälle $1 viesti',
	'userboard_myboard' => 'Keskustelualueeni',
	'userboard_posted_ago' => 'lähetetty $1 sitten',
	'userboard_private' => 'yksityinen',
	'userboard_public' => 'julkinen',
	'userboard_messagetype' => 'Viestin tyyppi',
	'userboard_nextpage' => 'seuraava',
	'userboard_prevpage' => 'edellinen',
	'userboard_nomessages' => 'Ei viestejä.',
	'userboard_sendbutton' => 'lähetä',
	'userboard_loggedout' => 'Sinun tulee olla <a href="$1">kirjautunut sisään</a> lähettääksesi viestejä toisille käyttäjille.',
	'userboard_showingmessages' => 'Näkyvillä on {{PLURAL:$4|viesti $3|viestit $2–$3}}. Yhteensä {{PLURAL:$1|$1 viesti|$1 viestiä}}.',
	'right-userboard-delete' => 'Poistaa toisten käyttäjien keskustelualueviestejä',
	'userboard-time-days' => '{{PLURAL:$1|päivä|$1 päivää}}',
	'userboard-time-hours' => '{{PLURAL:$1|tunti|$1 tuntia}}',
	'userboard-time-minutes' => '{{PLURAL:$1|minuutti|$1 minuuttia}}',
	'userboard-time-seconds' => '{{PLURAL:$1|sekunti|$1 sekuntia}}',
	'message_received_subject' => '$1 kirjoitti keskustelualueellesi {{GRAMMAR:inessive|{{SITENAME}}}}',
	'message_received_body' => 'Hei $1:

$2 juuri kirjoitti keskustelualueellesi {{GRAMMAR:inessive|{{SITENAME}}}}!

Napsauta alapuolella olevaa linkki tarkistaaksesi keskustelualueesi!

$3

---

Hei, etkö halua enää saada sähköposteja meiltä?

Napsauta $4
ja muuta asetuksiasi poistaaksesi sähköpostitoiminnot käytöstä.',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Urhixidur
 */
$messages['fr'] = array(
	'boardblastlogintitle' => 'Vous devez être connecté pour envoyer le tableau en rafale',
	'boardblastlogintext' => 'Pour envoyer des tableaux en rafales, vous devez [[Special:UserLogin|être connecté]].',
	'messagesenttitle' => 'Messages envoyés',
	'boardblasttitle' => 'Envoyer le tableau en rafale',
	'boardblaststep1' => 'Étape 1 - Écrivez votre message',
	'boardblastprivatenote' => 'Tous les messages seront envoyés comme des messages privés',
	'boardblaststep2' => 'Étape 2 - Sélectionnez aussi à qui vous voulez envoyer votre message',
	'boardlinkselectall' => 'Tout sélectionner',
	'boardlinkunselectall' => 'Tout déselectionner',
	'boardlinkselectfriends' => 'Sélectionnez les amis',
	'boardlinkunselectfriends' => 'Désélectionner les amis',
	'boardlinkselectfoes' => 'Sélectionner les ennemis',
	'boardlinkunselectfoes' => 'Désélectionner les ennemis',
	'boardsendbutton' => 'Envoyez le tableau en rafale',
	'boardnofriends' => 'Vous n’avez aucun ami à qui envoyer le message',
	'messagesentsuccess' => 'Votre message a été envoyé avec succès',
	'userboard' => 'Tableau utilisateur',
	'userboard_board-to-board' => 'De tableau à tableau',
	'userboard_delete' => 'Supprimer',
	'userboard_noexist' => 'L’utilisateur que vous êtes en train d’essayer de visionner n’existe pas.',
	'userboard_yourboard' => 'Votre tableau',
	'userboard_owner' => 'Le tableau de $1',
	'userboard_yourboardwith' => 'Votre tableau à tableau avec $1',
	'userboard_otherboardwith' => 'Le tableau à tableau de $1 avec $2',
	'userboard_backprofile' => 'Retour vers le profil de $1',
	'userboard_backyourprofile' => 'Retour vers votre profil',
	'userboard_boardtoboard' => 'Tableau à tableau',
	'userboard_confirmdelete' => 'Êtes-vous certain{{GENDER:||e|(e)}} de vouloir supprimer ce message ?',
	'userboard_sendmessage' => 'Envoyer un message à $1',
	'userboard_myboard' => 'Mon tableau',
	'userboard_posted_ago' => 'envoyé depuis $1',
	'userboard_private' => 'privé',
	'userboard_public' => 'public',
	'userboard_messagetype' => 'Type de message',
	'userboard_nextpage' => 'suivant',
	'userboard_prevpage' => 'précédent',
	'userboard_nomessages' => 'Aucun message.',
	'userboard_sendbutton' => 'envoyé',
	'userboard_loggedout' => 'Vous devez être <a href="$1">connecté</a> pour poster des messages à d’autres utilisateurs.',
	'userboard_showingmessages' => 'Visionnement {{PLURAL:$4|du message $3|des messages $2-$3}} sur un total de $1 message{{PLURAL:$1||s}}',
	'right-userboard-delete' => 'Supprimer les messages d’autres utilisateurs',
	'userboard-time-days' => '$1 {{PLURAL:$1|jour|jours}}',
	'userboard-time-hours' => '$1 {{PLURAL:$1|heure|heures}}',
	'userboard-time-minutes' => '$1 {{PLURAL:$1|minute|minutes}}',
	'userboard-time-seconds' => '$1 {{PLURAL:$1|seconde|secondes}}',
	'message_received_subject' => '$1 a écrit sur votre tableau sur {{SITENAME}}',
	'message_received_body' => 'Salut $1 :

$2 vient juste d’écrire sur votre tableau sur {{SITENAME}} !

Cliquez sur le lien ci-dessous pour allez sur votre tableau !

$3

---

Hé ! Voulez-vous arrêter d’obtenir, de nous, les courriels ?

Cliquer $4
et modifiez vos paramètres pour désactiver les notifications des courriels.',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'messagesenttitle' => 'Mèssâjos mandâs',
	'boardblasttitle' => 'Mandar lo tablô per a-côp',
	'boardblaststep1' => 'Ètapa 1 - Ècrîde voutron mèssâjo',
	'boardlinkselectall' => 'Chouèsir tot',
	'boardlinkunselectall' => 'Pas chouèsir tot',
	'boardlinkselectfriends' => 'Chouèsir los amis',
	'boardlinkunselectfriends' => 'Pas chouèsir los amis',
	'boardlinkselectfoes' => 'Chouèsir los ènemis',
	'boardlinkunselectfoes' => 'Pas chouèsir los ènemis',
	'boardsendbutton' => 'Mandar lo tablô per a-côp',
	'userboard' => 'Tablô utilisator',
	'userboard_board-to-board' => 'De tablô a tablô',
	'userboard_delete' => 'Suprimar',
	'userboard_yourboard' => 'Voutron tablô',
	'userboard_owner' => 'Lo tablô a $1',
	'userboard_yourboardwith' => 'Voutron tablô a tablô avouéc $1',
	'userboard_otherboardwith' => 'Lo tablô a tablô a $1 avouéc $2',
	'userboard_backprofile' => 'Retôrn de vers lo profil de $1',
	'userboard_backyourprofile' => 'Retôrn de vers voutron profil',
	'userboard_boardtoboard' => 'De tablô a tablô',
	'userboard_confirmdelete' => 'Éte-vos de sûr de volêr suprimar cél mèssâjo ?',
	'userboard_sendmessage' => 'Mandar un mèssâjo a $1',
	'userboard_myboard' => 'Mon tablô',
	'userboard_posted_ago' => 'mandâ dês $1',
	'userboard_private' => 'privâ',
	'userboard_public' => 'publico',
	'userboard_messagetype' => 'Tipo de mèssâjo',
	'userboard_nextpage' => 'aprés',
	'userboard_prevpage' => 'devant',
	'userboard_nomessages' => 'Gins de mèssâjo.',
	'userboard_sendbutton' => 'mandâ',
	'userboard_loggedout' => 'Vos dête étre <a href="$1">branchiê</a> por postar des mèssâjos a d’ôtros utilisators.',
	'userboard_showingmessages' => 'Visualisacion d{{PLURAL:$4|u mèssâjo $3|es mèssâjos $2-$3}} sur una soma totâla de $1 mèssâjo{{PLURAL:$1||s}}',
	'right-userboard-delete' => 'Suprimar los mèssâjos a ôtros utilisators',
	'userboard-time-days' => '$1 jorn{{PLURAL:$1||s}}',
	'userboard-time-hours' => '$1 hor{{PLURAL:$1|a|es}}',
	'userboard-time-minutes' => '$1 menut{{PLURAL:$1|a|es}}',
	'userboard-time-seconds' => '$1 second{{PLURAL:$1|a|es}}',
	'message_received_subject' => '$1 at ècrit sur voutron tablô dessus {{SITENAME}}',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'userboard_delete' => 'Wiskje',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'boardblastlogintitle' => 'Debe acceder ao sistema para enviar un recado',
	'boardblastlogintext' => 'Para poder enviar un recado debe antes ter [[Special:UserLogin|accedido ao sistema]].',
	'messagesenttitle' => 'Mensaxes enviadas',
	'boardblasttitle' => 'Enviar un recado',
	'boardblaststep1' => 'Paso 1 - Estriba a súa mensaxe',
	'boardblastprivatenote' => 'Todas as mensaxes serán enviadas de maneira privada',
	'boardblaststep2' => 'Paso 2 - Escolla a quen lle quere enviar a súa mensaxe tamén',
	'boardlinkselectall' => 'Seleccionar todo',
	'boardlinkunselectall' => 'Deixar de seleccionar todo',
	'boardlinkselectfriends' => 'Seleccionar amigos',
	'boardlinkunselectfriends' => 'Deixar de seleccionar amigos',
	'boardlinkselectfoes' => 'Seleccionar inimigos',
	'boardlinkunselectfoes' => 'Deixar de seleccionar inimigos',
	'boardsendbutton' => 'Enviar o recado',
	'boardnofriends' => 'Non ten amigos para mandarlles mensaxes!',
	'messagesentsuccess' => 'A súa mensaxe foi enviada con éxito',
	'userboard' => 'Taboleiro do usuario',
	'userboard_board-to-board' => 'De taboleiro a taboleiro',
	'userboard_delete' => 'Borrar',
	'userboard_noexist' => 'O usuario que está tentando ver non existe.',
	'userboard_yourboard' => 'O seu taboleiro',
	'userboard_owner' => 'O taboleiro de $1',
	'userboard_yourboardwith' => 'O seu taboleiro a taboleiro con $1',
	'userboard_otherboardwith' => 'De taboleiro a taboleiro de $1 con $2',
	'userboard_backprofile' => 'Volver ao perfil de $1',
	'userboard_backyourprofile' => 'Volver ao seu perfil',
	'userboard_boardtoboard' => 'De taboleiro a taboleiro',
	'userboard_confirmdelete' => 'Está seguro de querer borrar esta mensaxe?',
	'userboard_sendmessage' => 'Enviar unha mensaxe a $1',
	'userboard_myboard' => 'O meu taboleiro',
	'userboard_posted_ago' => 'publicou hai $1',
	'userboard_private' => 'privada',
	'userboard_public' => 'pública',
	'userboard_messagetype' => 'Tipo de mensaxe',
	'userboard_nextpage' => 'seguinte',
	'userboard_prevpage' => 'anterior',
	'userboard_nomessages' => 'Ningunha mensaxe.',
	'userboard_sendbutton' => 'enviar',
	'userboard_loggedout' => 'Debe <a href="$1">acceder ao sistema</a> para deixar mensaxes a outros usuarios.',
	'userboard_showingmessages' => 'Mostrando {{PLURAL:$4|ata a mensaxe $3|as mensaxes da $2 á $3}} dun total {{PLURAL:$1|dunha mensaxe|de $1 mensaxes}}.',
	'right-userboard-delete' => 'Borrar o taboleiro de mensaxes doutros',
	'userboard-time-days' => '{{PLURAL:$1|un día|$1 días}}',
	'userboard-time-hours' => '{{PLURAL:$1|unha hora|$1 horas}}',
	'userboard-time-minutes' => '{{PLURAL:$1|un minuto|$1 minutos}}',
	'userboard-time-seconds' => '{{PLURAL:$1|un segundo|$1 segundos}}',
	'message_received_subject' => '$1 escribiu no seu taboleiro en {{SITENAME}}',
	'message_received_body' => 'Ola $1:

$2 acaba de escribir no seu taboleiro en {{SITENAME}}!

Faga clic embaixo para comprobar o seu taboleiro!

$3

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'userboard_delete' => 'Taíran',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'userboard_delete' => 'Σβεννύναι',
	'userboard_private' => 'ἰδιωτικός',
	'userboard_public' => 'δημόσιος',
	'userboard_nextpage' => 'ἑπομ',
	'userboard_prevpage' => 'προηγ',
	'userboard_sendbutton' => 'πέμπειν',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'boardblastlogintitle' => 'Du muesch aagmäldet syy zum Nochrichte verschicke z chenne',
	'boardblastlogintext' => 'Du muesch [[Special:UserLogin|aagmolde]] sy, zume Noochrichte z verschicke.',
	'messagesenttitle' => 'Nochrichte gschickt',
	'boardblasttitle' => 'Nochricht schicke',
	'boardblaststep1' => 'Schritt 1: Schryb Dyyni Nochricht',
	'boardblastprivatenote' => 'Alli Nochrichte wäre as privati Mitteilige verschickt',
	'boardblaststep2' => 'Schritt 2: Wehl uus, wäm Du d Nochrichte witt schicke',
	'boardlinkselectall' => 'Alli markiere',
	'boardlinkunselectall' => 'Keini markiere',
	'boardlinkselectfriends' => 'Frynd uuswehle',
	'boardlinkunselectfriends' => 'Frynd abwehle',
	'boardlinkselectfoes' => 'Fynd uuswehle',
	'boardlinkunselectfoes' => 'Fynd abwehle',
	'boardsendbutton' => 'Nochricht schicke',
	'boardnofriends' => 'Du hesch keini Frynd, wu Du chenntsch e Nochricht schicke!',
	'messagesentsuccess' => 'Dyyni Nochricht isch erfolgryych verschickt wore',
	'userboard' => 'Schwarz Brätt',
	'userboard_board-to-board' => 'Schwarz Brätt - zue - Schwarz Brätt',
	'userboard_delete' => 'Lesche',
	'userboard_noexist' => 'Dr Benutzer, wu Du wit aaluege, git s nit.',
	'userboard_yourboard' => 'Dyy Schwarz Brätt',
	'userboard_owner' => 'S Schwarz Brätt vu $1',
	'userboard_yourboardwith' => 'Dyyni Diskussion uf em Schwarze Brätt mit $1',
	'userboard_otherboardwith' => 'D Diskussion uf em Schwarze Brätt vu $1 mit $2',
	'userboard_backprofile' => 'Zrugg zum Profil vu $1',
	'userboard_backyourprofile' => 'Zrugg zue Dyynem Profil',
	'userboard_boardtoboard' => 'Diskussion uf em Schwarze Brätt',
	'userboard_confirmdelete' => 'Bisch sicher, ass Du die Nochricht witt lesche?',
	'userboard_sendmessage' => 'Schick $1 e Nochricht',
	'userboard_myboard' => 'Myy Schwarz BRätt',
	'userboard_posted_ago' => 'vu $1 gschickt',
	'userboard_private' => 'privat',
	'userboard_public' => 'effentli',
	'userboard_messagetype' => 'Nochrichtetyp',
	'userboard_nextpage' => 'negschti',
	'userboard_prevpage' => 'vorigi',
	'userboard_nomessages' => 'Kei Nochrichte.',
	'userboard_sendbutton' => 'schicke',
	'userboard_loggedout' => 'Du muesch <a href="$1">aagmäldet syy</a> zum Nochrichte an anderi Nutzer schicke z chenne.',
	'userboard_showingmessages' => 'Zeig {{PLURAL:$4|Nochricht $3|Nochrichte $2-$3}} vu $1 insgsamt',
	'right-userboard-delete' => 'Nochrichte vu andere lesche',
	'userboard-time-days' => '{{PLURAL:$1|1 Tag|$1 Täg}}',
	'userboard-time-hours' => '{{PLURAL:$1|1 Stund|$1 Stunde}}',
	'userboard-time-minutes' => '{{PLURAL:$1|1 Minut|$1 Minute}}',
	'userboard-time-seconds' => '{{PLURAL:$1|1 Sekund|$1 Sekunde}}',
	'message_received_subject' => '$1 het uf Dyy Schwarz Brätt uf {{SITENAME}} gschribe',
	'message_received_body' => 'Sali $1:

$2 het Dir grad ebis gschribe uf Dyynem Schwarze Brätt uf {{SITENAME}}!

Druck uf des Gleich go Dyy Schwarz Brätt aaluege!

$3

---

Ha, Du wetsch gar keini E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go E-Mail-Benochrichtigunge abstelle.',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'userboard_delete' => 'Soke',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'userboard_delete' => 'Chhù-thet',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'boardblastlogintitle' => 'עליכם להיכנס לחשבון כדי לשלוח מסרים המוניים',
	'boardblastlogintext' => 'כדי לשלוח מסרים המוניים, עליכם [[Special:UserLogin|להיכנס לחשבון]].',
	'messagesenttitle' => 'ההודעות נשלחו',
	'boardblasttitle' => 'שליחת מסר המוני',
	'boardblaststep1' => 'שלב 1 – כתבו את הודעתכם',
	'boardblastprivatenote' => 'כל ההודעות יישלחו כהודעות פרטיות',
	'boardblaststep2' => 'שלב 2 – בחרו אל מי תרצו לשלוח את ההודעה',
	'boardlinkselectall' => 'בחרו הכול',
	'boardlinkunselectall' => 'ביטול בחירת הכול',
	'boardlinkselectfriends' => 'בחירת חברים',
	'boardlinkunselectfriends' => 'ביטול בחירת חברים',
	'boardlinkselectfoes' => 'בחירת יריבים',
	'boardlinkunselectfoes' => 'ביטול בחירת חברים',
	'boardsendbutton' => 'שליחת מסר המוני',
	'boardnofriends' => 'אין לכם חברים שאפשר לשלוח אליהם הודעות!',
	'messagesentsuccess' => 'הודעתכם נשלחה בהצלחה',
	'userboard' => 'לוח משתמש',
	'userboard_board-to-board' => 'לוח־אל־לוח',
	'userboard_delete' => 'מחיקה',
	'userboard_noexist' => 'המשתמש שאתם מנסים לצפות בו אינו קיים.',
	'userboard_yourboard' => 'הלוח שלכם',
	'userboard_owner' => 'הלוח של $1',
	'userboard_yourboardwith' => 'פגישת הלוח־אל־לוח שלכם עם $1',
	'userboard_otherboardwith' => 'פגישת הלוח־אל־לוח של $1 עם $2',
	'userboard_backprofile' => 'חזרה לפרופיל של $1',
	'userboard_backyourprofile' => 'חזרה לפרופיל שלכם',
	'userboard_boardtoboard' => 'לוח־אל־לוח',
	'userboard_confirmdelete' => 'האם אתם בטוחים שברצונכם למחוק הודעה זו?',
	'userboard_sendmessage' => 'שליחת הודעה אל $1',
	'userboard_myboard' => 'הלוח שלכם',
	'userboard_posted_ago' => 'פורסם לפני $1',
	'userboard_private' => 'פרטי',
	'userboard_public' => 'ציבורי',
	'userboard_messagetype' => 'סוג ההודעה',
	'userboard_nextpage' => 'הבא',
	'userboard_prevpage' => 'הקודם',
	'userboard_nomessages' => 'אין הודעות.',
	'userboard_sendbutton' => 'שליחה',
	'userboard_loggedout' => 'עליכם <a href="$1">להיכנס לחשבון</a> כדי לשלוח הודעות למשתמשים אחרים.',
	'userboard_showingmessages' => 'הצגת {{PLURAL:$4|הודעה $3|הודעות $2-$3}} מתוך {{PLURAL:$1|הודעה אחת|$1 הודעות}}',
	'right-userboard-delete' => 'מחיקת הודעות לוח שכתבו אחרים',
	'userboard-time-days' => '{{PLURAL:$1|יום|$1 ימים|יומיים}}',
	'userboard-time-hours' => '{{PLURAL:$1|שעה|$1 שעות|שעתיים}}',
	'userboard-time-minutes' => '{{PLURAL:$1|דקה|$1 דקות}}',
	'userboard-time-seconds' => '{{PLURAL:$1|שנייה|$1 שניות}}',
	'message_received_subject' => '$1 כתב בלוח שלך ב{{grammar:תחילית|{{SITENAME}}}}',
	'message_received_body' => 'שלום $1:

$2 הרגע כתב בלוח שלכם ב{{grammar:תחילית|{{SITENAME}}}}!

לחצו למטה כדי לצפות בלוח שלכם!

$3

---

רוצים להפסיק לקבל מאיתנו הודעות בדוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל קבלת התרעות בדוא"ל.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'userboard_delete' => 'हटायें',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'userboard_delete' => 'Panason',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'userboard_delete' => 'Izbriši',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'boardblastlogintitle' => 'Dyrbiš přizjewjeny być, zo by forumowe powěsće pósłał',
	'boardblastlogintext' => 'Dyrbiš <a href="index.php?title=Special:UserLogin">přizjewjeny</a> być, zo by forumowe powěsće pósłał.',
	'messagesenttitle' => 'Powěsće pósłane',
	'boardblasttitle' => 'Forumowu powěsć pósłać',
	'boardblaststep1' => 'Krok 1 - Napisaj swoju powěsć',
	'boardblastprivatenote' => 'Wšě powěsće pósćelu so jako priwatne powěsće',
	'boardblaststep2' => 'Krok 2 - Wubjer, komuž chceš swoju powěsć pósłać',
	'boardlinkselectall' => 'Wšě wubrać',
	'boardlinkunselectall' => 'Wuběr zběhnyć',
	'boardlinkselectfriends' => 'Přećelow wubrać',
	'boardlinkunselectfriends' => 'Přećelow wotwolić',
	'boardlinkselectfoes' => 'Njepřećelow wubrać',
	'boardlinkunselectfoes' => 'Njepřećelow wotwolić',
	'boardsendbutton' => 'Forumowu powěsć pósłać',
	'boardnofriends' => 'Nimaš žanych přećelow, kotrymž by móhł powěsć pósłać!',
	'messagesentsuccess' => 'Twoja powěsć je so wuspěšnje pósłała',
	'userboard' => 'Čorna deska',
	'userboard_board-to-board' => 'Diskusija deska k desce',
	'userboard_delete' => 'Wušmórnyć',
	'userboard_noexist' => 'Wužiwar, kotrehož pospytuješ sej wobhladać, njeeksistuje.',
	'userboard_yourboard' => 'Twoja deska',
	'userboard_owner' => 'Deska wužiwarja $1',
	'userboard_yourboardwith' => 'Twoja deska k desce z $1',
	'userboard_otherboardwith' => 'Diskusija deska k desce wužiwarja $1 z $2',
	'userboard_backprofile' => 'Wróćo k profilej wužiwarja $1',
	'userboard_backyourprofile' => 'Wróćo k twojemu profilej',
	'userboard_boardtoboard' => 'Diskusija deska k desce',
	'userboard_confirmdelete' => 'Chceš tutu powěsć woprawdźe wušmórnyć?',
	'userboard_sendmessage' => 'Wužiwarjej $1 powěsć pósłać',
	'userboard_myboard' => 'Moja deska',
	'userboard_posted_ago' => 'před $1 wótposłany',
	'userboard_private' => 'priwatny',
	'userboard_public' => 'zjawny',
	'userboard_messagetype' => 'Typ powěsće',
	'userboard_nextpage' => 'přichodny',
	'userboard_prevpage' => 'předchadny',
	'userboard_nomessages' => 'Žane powěsće.',
	'userboard_sendbutton' => 'pósłać',
	'userboard_loggedout' => 'Dyrbiš <a href="$1">přizjewjeny</a> być, zo by druhim wužiwarjam powěsće pósłał.',
	'userboard_showingmessages' => '{{PLURAL:$4|Pokazuje so powěsć $3|Pokazujetej so powěsći $2-$3|Pokazuja so powěsće $2-$3|Pokazuja so powěsće $2-$3}} z {{PLURAL:$1|$1 powěsće|$1 powěsćow|$1 powěsćow|$1 powěsćow}}',
	'right-userboard-delete' => 'Powěsće z deski druhich wušmórnyć',
	'userboard-time-days' => '{{PLURAL:$1|jedyn dźeń|$1 dnjej|$1 dny|$1 dnjow}}',
	'userboard-time-hours' => '{{PLURAL:$1|jedna hodźina|$1 hodźinje|$1 hodźiny|$1 hodźin}}',
	'userboard-time-minutes' => '{{PLURAL:$1|jedna mjeńšina|$1 mjeńšinje|$1 mjeńšiny|$1 mjeńšin}}',
	'userboard-time-seconds' => '{{PLURAL:$1|jedna sekunda|$1 sekundźe|$1 sekundy|$1 sekundow}}',
	'message_received_subject' => '$1 je na twoju desku na {{GRAMMAR:lokatiw|{{SITENAME}}}} napisał',
	'message_received_body' => 'Witaj $1.

$2 je runje na twoju desku na {{GRAMMAR:lokatiw|{{SITENAME}}}} napisał!

Klikń deleka, zo by sej swoju desku wobhladał!

$3

---

Hej, hižo nochceš e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'boardblastlogintitle' => 'Bejegyzés küldéséhez be kell jelentkezned.',
	'boardblastlogintext' => 'Ahhoz hogy tudj bejegyzéseket küldeni,
<a href="index.php?title=Special:UserLogin">be kell jelentkezned</a>.',
	'messagesenttitle' => 'Elküldött üzenetek',
	'boardblasttitle' => 'Bejegyzés küldése',
	'boardblaststep1' => '1. lépés – írd meg az üzeneted',
	'boardblastprivatenote' => 'Minden üzenet privát üzenetként lesz elküldve',
	'boardblaststep2' => '2. lépés – válaszd ki, kinek szeretnéd elküldeni az üzenetet',
	'boardlinkselectall' => 'Mind kijelölése',
	'boardlinkunselectall' => 'Összes kijelölés megszüntetése',
	'boardlinkselectfriends' => 'Barátok kijelölése',
	'boardlinkunselectfriends' => 'Barátok kijelölésének megszüntetése',
	'boardlinkselectfoes' => 'Ellenségek kijelölése',
	'boardlinkunselectfoes' => 'Ellenségek kijelölésének megszüntetése',
	'boardsendbutton' => 'Bejegyzés elküldése az üzenőfalra',
	'boardnofriends' => 'Nincsenek barátaid, akiknek üzenetet küldhetnél!',
	'messagesentsuccess' => 'Az üzeneted sikeresen elküldve',
	'userboard' => 'Üzenőfal',
	'userboard_board-to-board' => 'Üzenőfaltól-üzenőfalig',
	'userboard_delete' => 'Törlés',
	'userboard_noexist' => 'A megtekinteni próbált felhasználó nem létezik.',
	'userboard_yourboard' => 'Saját üzenőfalad',
	'userboard_owner' => '$1 üzenőfala',
	'userboard_yourboardwith' => 'Üzenőfalak közti beszélgetésed vele: $1',
	'userboard_otherboardwith' => '$1 üzenőfalak közti beszélgetése vele: $2',
	'userboard_backprofile' => 'Vissza $1 profiljára',
	'userboard_backyourprofile' => 'Vissza a profilodra',
	'userboard_boardtoboard' => 'Üzenőfal-beszélgetés',
	'userboard_confirmdelete' => 'Biztos vagy benne, hogy törölni szeretnéd ezt az üzenetet?',
	'userboard_sendmessage' => 'Üzenet küldése $1 részére',
	'userboard_myboard' => 'Saját üzenőfalam',
	'userboard_posted_ago' => 'beküldve: $1',
	'userboard_private' => 'privát',
	'userboard_public' => 'nyilvános',
	'userboard_messagetype' => 'Üzenet típusa',
	'userboard_nextpage' => 'következő',
	'userboard_prevpage' => 'előző',
	'userboard_nomessages' => 'Nincsenek üzenetek.',
	'userboard_sendbutton' => 'küldés',
	'userboard_loggedout' => 'Ha más felhasználók számára szeretnél üzenetet küldeni, <a href="$1">be kell jelentkezned</a>.',
	'userboard_showingmessages' => '{{PLURAL:$4|$3 üzenet|$2 – $3 üzenetek}} megjelenítése (összesen: $1)',
	'right-userboard-delete' => 'mások üzenőfalas üzeneteinek törlése',
	'userboard-time-days' => '{{PLURAL:$1|egy|$1}} nappal',
	'userboard-time-hours' => '{{PLURAL:$1|egy|$1}} órával',
	'userboard-time-minutes' => '{{PLURAL:$1|egy|$1}} perccel',
	'userboard-time-seconds' => '{{PLURAL:$1|egy|$1}} másodperccel',
	'message_received_subject' => '$1 írt a hirdetőfaladra a(z) {{SITENAME}} oldalon',
	'message_received_body' => 'Szia $1!

$2 írt az üzenőfaladra a(z) {{SITENAME}} wikin!

Kattints alábbi hivatkozásra az üzenőfalad megtekintéséhez.

$3

---
Szeretnéd ha nem zaklatnánk több e-maillel?

Kattints a linkre: $4
és tiltsd le az e-mail értesítéseket a beállításaidban',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'boardblastlogintitle' => 'Tu debe aperir un session pro poter inviar colpos de tabuliero',
	'boardblastlogintext' => 'Pro poter inviar colpos de tabuliero, tu debe [[Special:UserLogin|aperir un session]].',
	'messagesenttitle' => 'Messages inviate',
	'boardblasttitle' => 'Inviar colpo de tabuliero',
	'boardblaststep1' => 'Passo 1 - Scribe tu message',
	'boardblastprivatenote' => 'Tote le messages essera inviate como messages private',
	'boardblaststep2' => 'Passo 2 - Selige a qui tu vole inviar tu message',
	'boardlinkselectall' => 'Seliger toto',
	'boardlinkunselectall' => 'Disseliger toto',
	'boardlinkselectfriends' => 'Seliger amicos',
	'boardlinkunselectfriends' => 'Disseliger amicos',
	'boardlinkselectfoes' => 'Seliger inimicos',
	'boardlinkunselectfoes' => 'Disseliger inimicos',
	'boardsendbutton' => 'Inviar colpo de tabuliero',
	'boardnofriends' => 'Tu ha nulle amico a qui inviar un message!',
	'messagesentsuccess' => 'Tu message ha essite inviate con successo',
	'userboard' => 'Tabuliero de usator',
	'userboard_board-to-board' => 'De tabuliero a tabuliero',
	'userboard_delete' => 'Deler',
	'userboard_noexist' => 'Le usator que tu vole vider non existe.',
	'userboard_yourboard' => 'Tu tabuliero',
	'userboard_owner' => 'Le tabuliero de $1',
	'userboard_yourboardwith' => 'Tu tabuliero a tabuliero con $1',
	'userboard_otherboardwith' => 'Le tabuliero a tabuliero de $1 con $2',
	'userboard_backprofile' => 'Retornar al profilo de $1',
	'userboard_backyourprofile' => 'Retornar a tu profilo',
	'userboard_boardtoboard' => 'Tabuliero a tabuliero',
	'userboard_confirmdelete' => 'Es tu secur de voler deler iste message?',
	'userboard_sendmessage' => 'Inviar un message a $1',
	'userboard_myboard' => 'Mi tabuliero',
	'userboard_posted_ago' => 'inviate $1 retro',
	'userboard_private' => 'private',
	'userboard_public' => 'public',
	'userboard_messagetype' => 'Typo de message',
	'userboard_nextpage' => 'seq',
	'userboard_prevpage' => 'prec',
	'userboard_nomessages' => 'Nulle message.',
	'userboard_sendbutton' => 'inviar',
	'userboard_loggedout' => 'Tu debe <a href="$1">aperir un session</a> pro poter inviar messages a altere usatores.',
	'userboard_showingmessages' => 'Presentation del {{PLURAL:$4|message $3|messages $2-$3}} de $1 {{PLURAL:$1|message|messages}}',
	'right-userboard-delete' => 'Deler le messages de alteros del tabuliero',
	'userboard-time-days' => '{{PLURAL:$1|un die|$1 dies}}',
	'userboard-time-hours' => '{{PLURAL:$1|un hora|$1 horas}}',
	'userboard-time-minutes' => '{{PLURAL:$1|un minuta|$1 minutas}}',
	'userboard-time-seconds' => '{{PLURAL:$1|un secunda|$1 secundas}}',
	'message_received_subject' => '$1 scribeva in tu tabuliero in {{SITENAME}}',
	'message_received_body' => 'Salute $1,

$2 justo scribeva in tu tabuliero in {{SITENAME}}!

Clicca infra pro visitar tu tabuliero!

$3

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 */
$messages['id'] = array(
	'boardblastlogintitle' => 'Anda harus masuk log untuk mengirim papan peledak',
	'boardblastlogintext' => 'Untuk mengirim kiriman massal, Anda harus [[Special:UserLogin|masuk]].',
	'messagesenttitle' => 'Surat terkirim',
	'boardblasttitle' => 'Kirim papan peledak',
	'boardblaststep1' => 'Tahap 1 - Tulis surat anda',
	'boardblastprivatenote' => 'Semua surat akan dikirim sebagai surat pribadi',
	'boardblaststep2' => 'Tahap 2 - Pilih siapa yang akan anda kirimi surat',
	'boardlinkselectall' => 'Pilih semua',
	'boardlinkunselectall' => 'Jangan pilih semua',
	'boardlinkselectfriends' => 'Pilih teman',
	'boardlinkunselectfriends' => 'Batalkan teman',
	'boardlinkselectfoes' => 'Pilih musuh',
	'boardlinkunselectfoes' => 'Batalkan musuh',
	'boardsendbutton' => 'Kirim papan peledak',
	'boardnofriends' => 'Anda tidak punya teman yang bisa dikirimi surat!',
	'messagesentsuccess' => 'Surat anda sudah terkirim',
	'userboard' => 'Papan pengguna',
	'userboard_board-to-board' => 'Antarpapan',
	'userboard_delete' => 'Hapus',
	'userboard_noexist' => 'Pengguna yang anda coba lihat tidak ada.',
	'userboard_yourboard' => 'Papan anda',
	'userboard_owner' => 'Papan $1',
	'userboard_yourboardwith' => 'Antarpapan anda dengan $1',
	'userboard_otherboardwith' => 'Antarpapan antara $1 dan $2',
	'userboard_backprofile' => 'Kembali ke profil $1',
	'userboard_backyourprofile' => 'Kembali ke profil anda',
	'userboard_boardtoboard' => 'Antarpapan',
	'userboard_confirmdelete' => 'Anda yakin ingin menghapus surat ini?',
	'userboard_sendmessage' => 'Kirim surat ke $1',
	'userboard_myboard' => 'Papan saya',
	'userboard_posted_ago' => 'dikirim $1 yang lalu',
	'userboard_private' => 'pribadi',
	'userboard_public' => 'publik',
	'userboard_messagetype' => 'Tipe surat',
	'userboard_nextpage' => 'selanjutnya',
	'userboard_prevpage' => 'sebelumnya',
	'userboard_nomessages' => 'Tak ada surat.',
	'userboard_sendbutton' => 'kirim',
	'userboard_loggedout' => 'Anda harus <a href="$1">masuk log</a> untuk bisa mengirim surat ke pengguna lain.',
	'userboard_showingmessages' => 'Menampilkan {{PLURAL:$4|surat $3|surat $2-$3}} dari {{PLURAL:$1|$1 surat|$1 surat}}',
	'right-userboard-delete' => 'Hapus pesan orang lain di papan',
	'userboard-time-days' => '{{PLURAL:$1|sehari|$1 hari}}',
	'userboard-time-hours' => '{{PLURAL:$1|sejam|$1 jam}}',
	'userboard-time-minutes' => '{{PLURAL:$1|semenit|$1 menit}}',
	'userboard-time-seconds' => '{{PLURAL:$1|sedetik|$1 detik}}',
	'message_received_subject' => '$1 menulis pada papan anda di {{SITENAME}}',
	'message_received_body' => 'Hai $1.

$2 baru menulis di papan Anda pada {{SITENAME}}!

Klik di bawah untuk memeriksa papan Anda!

$3

---

Hey, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah setting anda untuk menonaktifkan notifikasi surel.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'userboard_delete' => 'Kàcha',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'userboard_nextpage' => 'sequanta',
	'userboard_prevpage' => 'antea',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'messagesenttitle' => 'Messaggio inviato',
	'boardlinkselectall' => 'Seleziona tutte',
	'userboard_delete' => 'Cancella',
	'userboard_private' => 'privata',
	'userboard_public' => 'pubblico',
	'userboard_nextpage' => 'succ',
	'userboard_prevpage' => 'prec',
	'userboard_nomessages' => 'Non vi sono nuovi messaggi.',
	'userboard_sendbutton' => 'invia',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Gzdavidwong
 * @author Schu
 */
$messages['ja'] = array(
	'boardblastlogintitle' => '一斉メッセージを送るにはログインする必要があります',
	'boardblastlogintext' => '一斉メッセージを送るには [[Special:UserLogin|ログイン]]する必要があります。',
	'messagesenttitle' => 'メッセージを送る',
	'boardblasttitle' => '一斉メッセージの送信',
	'boardblaststep1' => 'ステップ1 - メッセージを書きます',
	'boardblastprivatenote' => 'すべてのメッセージはプライベートメッセージとして送信されます',
	'boardblaststep2' => 'ステップ2 - メッセージを送りたい相手を選んでください',
	'boardlinkselectall' => 'すべて選択',
	'boardlinkunselectall' => 'すべて選択解除',
	'boardlinkselectfriends' => '友達を選択する',
	'boardlinkunselectfriends' => '友達の選択を解除する',
	'boardlinkselectfoes' => '敵を選択する',
	'boardlinkunselectfoes' => '敵の選択を解除する',
	'boardsendbutton' => '一斉メッセージを送る',
	'boardnofriends' => 'あなたはメッセージを送信する友達がいません！',
	'messagesentsuccess' => 'あなたのメッセージは正常に送信されました',
	'userboard' => '利用者掲示板',
	'userboard_board-to-board' => '掲示板連絡',
	'userboard_delete' => '削除',
	'userboard_noexist' => '閲覧しようとした利用者は存在していません。',
	'userboard_yourboard' => 'あなたの掲示板',
	'userboard_owner' => '$1 の掲示板',
	'userboard_yourboardwith' => 'あなたと$1の専用掲示板',
	'userboard_otherboardwith' => '$1の$2との連絡掲示板',
	'userboard_backprofile' => '$1 のプロフィールへ戻る',
	'userboard_backyourprofile' => 'あなたのプロフィールへ戻る',
	'userboard_boardtoboard' => '専用掲示板',
	'userboard_confirmdelete' => 'このメッセージを本当に削除してよろしいですか？',
	'userboard_sendmessage' => '$1 にメッセージを送る',
	'userboard_myboard' => '自分の掲示板',
	'userboard_posted_ago' => '$1前に投稿',
	'userboard_private' => '非公開',
	'userboard_public' => '公開',
	'userboard_messagetype' => 'メッセージタイプ',
	'userboard_nextpage' => '次',
	'userboard_prevpage' => '前',
	'userboard_nomessages' => 'メッセージなし',
	'userboard_sendbutton' => '送信',
	'userboard_loggedout' => '他の利用者にメッセージを送信するには<a href="$1">ログイン</a>する必要があります。',
	'userboard_showingmessages' => 'メッセージ$1件中{{PLURAL:$4|$3件|$2-$3件}}を表示中',
	'right-userboard-delete' => '他人の掲示板のメッセージを削除する',
	'userboard-time-days' => '{{PLURAL:$1|$1日}}',
	'userboard-time-hours' => '{{PLURAL:$1|$1時間}}',
	'userboard-time-minutes' => '{{PLURAL:$1|$1分}}',
	'userboard-time-seconds' => '{{PLURAL:$1|$1秒}}',
	'message_received_subject' => '$1が{{SITENAME}}のあなたの掲示板に書き込みました',
	'message_received_body' => 'こんにちは、$1さん。

さきほど、$2さんが{{SITENAME}}上のあなたの掲示板に書き込みをしました！

以下をクリックして、掲示板を確認してください！

$3

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'messagesenttitle' => 'Pesen dikirim',
	'boardblaststep1' => 'Tahap 1 - Nulisa pesen panjenengan',
	'boardblastprivatenote' => 'Kabèh pesen bakal dikirim minangka pesen pribadi',
	'boardblaststep2' => 'Tahap 2 - Pilihen sapa waé sing péngin dikirimi pesen panjenengan',
	'boardlinkselectall' => 'Pilih kabèh',
	'userboard_delete' => 'Busak',
	'userboard_sendmessage' => 'Ngirimi pesen $1',
	'userboard_private' => 'pribadi',
	'userboard_public' => 'umum',
	'userboard_messagetype' => 'Jenis pesen',
	'userboard_nextpage' => 'sabanjuré',
	'userboard_prevpage' => 'sadurungé',
	'userboard_nomessages' => 'Ora ana pesen.',
	'userboard_sendbutton' => 'kirim',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'messagesenttitle' => 'សារបានផ្ញើរួចហើយ',
	'boardblaststep1' => 'ជំហានទី១ - សរសេរសាររបស់លោកអ្នក',
	'boardblastprivatenote' => 'គ្រប់​សារ​ទាំងអស់​នឹង​ត្រូវបាន​ផ្ញើ​ក្នុងលក្ខណៈជាសារ​ឯកជន',
	'boardblaststep2' => 'ជំហានទី២ - សូម​ជ្រើសរើស​អ្នក​ដែលអ្នកចង់ផ្ញើសារទៅកាន់',
	'boardlinkselectall' => 'ជ្រើសរើសទាំងអស់',
	'boardlinkunselectall' => 'មិនជ្រើសរើសទាំងអស់',
	'boardlinkselectfriends' => 'ជ្រើសមិត្តភ័ក្ដិ',
	'boardlinkunselectfriends' => 'មិន​ជ្រើសមិត្តភ័ក្ដិ',
	'boardlinkselectfoes' => 'ជ្រើស​បច្ចាមិត្ត',
	'boardlinkunselectfoes' => 'មិន​ជ្រើស​បច្ចាមិត្ត',
	'boardnofriends' => 'អ្នក​ពុំមាន​មិត្តភ័ក្ដិ ដើម្បី​ផ្ញើ​សារ​ទៅកាន់​ទេ​!',
	'messagesentsuccess' => 'សារ​របស់អ្នក​ត្រូវបាន​ផ្ញើដោយជោគជ័យ',
	'userboard_delete' => 'លុប',
	'userboard_noexist' => 'អ្នកប្រើប្រាស់ ដែល​អ្នក​កំពុងតែ​ព្យាយម​មើលនោះ មិនមាន​ទេ​។',
	'userboard_backprofile' => 'ត្រឡប់​ទៅកាន់​ប្រវត្តិរូបរបស់ $1',
	'userboard_backyourprofile' => 'ត្រឡប់​ទៅកាន់​ប្រវត្តិរូប​របស់អ្នក',
	'userboard_confirmdelete' => 'តើ​អ្នកប្រាកដ​ហើយឬ​ដែលចង់​លុបសារ​នេះចោល?',
	'userboard_sendmessage' => 'ផ្ញើសារទៅកាន់$1',
	'userboard_private' => 'ឯកជន',
	'userboard_public' => 'សាធារណៈ',
	'userboard_messagetype' => 'ប្រភេទសារ',
	'userboard_nextpage' => 'បន្ទាប់',
	'userboard_prevpage' => 'មុន',
	'userboard_nomessages' => 'មិនមានសារទេ។',
	'userboard_sendbutton' => 'ផ្ញើ',
	'userboard_loggedout' => 'ដើម្បីបញ្ជូនសារទៅកាន់អ្នកប្រើប្រាស់ផ្សេងៗទៀតបាន អ្នកចាំបាច់ត្រូវតែបាន<a href="$1">កត់ឈ្មោះចូល</a>។',
	'userboard-time-days' => '{{PLURAL:$1|មួយថ្ងៃ​|$1 ថ្ងៃ​}}',
	'userboard-time-hours' => '{{PLURAL:$1|មួយម៉ោង​|$1 ម៉ោង​}}',
	'userboard-time-minutes' => '{{PLURAL:$1|មួយ​នាទី​|$1 នាទី​}}',
	'userboard-time-seconds' => '{{PLURAL:$1|មួយ​វិនាទី|$1 វិនាទី}}',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'userboard_delete' => 'ಅಳಿಸು',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'userboard_delete' => 'Dilit',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'boardblastlogintitle' => 'Do moß enjelogg sin, öm Nohreechte verschecke ze künne',
	'boardblastlogintext' => 'Do moß enjelogg sin, öm Nohreechte verschecke ze künne.
Donn diräk [[Special:UserLogin|enlogge]].',
	'messagesenttitle' => 'Nohreechte verscheck',
	'boardblasttitle' => 'Nohreesch verschecke',
	'boardblaststep1' => 'Eetste Schrett — Don Ding Nohreesch schriive',
	'boardblastprivatenote' => 'All die Nohreeche wäde als private Nohreechte verscheck',
	'boardblaststep2' => 'Zweite Schrett — Don ußsöke, wämm De Ding Nohreesch schecke wells',
	'boardlinkselectall' => 'Alle ußsöke',
	'boardlinkunselectall' => 'Nix ußsöke',
	'boardlinkselectfriends' => 'De Fründe ußsöke',
	'boardlinkunselectfriends' => 'Keine Fründ ußsöke',
	'boardlinkselectfoes' => 'Feinde ußsöke',
	'boardlinkunselectfoes' => 'Keine Feind ußsöke',
	'boardsendbutton' => 'Nohreesch schecke!',
	'boardnofriends' => 'Do häß kein Fründe! Do kanns nix schecke!',
	'messagesentsuccess' => 'Ding Nohreesch eß verscheck woode',
	'userboard' => 'Pennwand fö Metmaacher',
	'userboard_board-to-board' => 'Pennwand-zoh-Pennwand',
	'userboard_delete' => 'Fottschmieße',
	'userboard_noexist' => 'Dä Metmaacher jit et nit, dä De do beloore wells.',
	'userboard_yourboard' => 'Ding Pinnwand',
	'userboard_owner' => 'Däm Metmaacher $1 sing Pinnwand',
	'userboard_yourboardwith' => 'Ding Pinnwand-zo-Pinnwand Klaaf met däm Metmaacher $1',
	'userboard_otherboardwith' => 'Däm Metmaacher $1 singe Pinnwand-zo-Pinnwand Klaaf met däm Metmaacher $2',
	'userboard_backprofile' => 'Retuur noh däm Metmaacher $1 singem Profil',
	'userboard_backyourprofile' => 'Retuur noh Dingem eije Profil',
	'userboard_boardtoboard' => 'Pinnwand-zo-Pinnwand Klaaf',
	'userboard_confirmdelete' => 'Wells De heh di Nohreesch verhaftesh fottschmieße?',
	'userboard_sendmessage' => 'Scheck däm Metmaacher $1 en Nohreesch',
	'userboard_myboard' => 'Ming Pinnwand',
	'userboard_posted_ago' => 'för $1 jespeichert',
	'userboard_private' => 'privat',
	'userboard_public' => 'öffentlech',
	'userboard_messagetype' => 'De Zoot Nohreesch',
	'userboard_nextpage' => 'näx',
	'userboard_prevpage' => 'förrije',
	'userboard_nomessages' => 'Kein Nohrechte.',
	'userboard_sendbutton' => 'Schecke!',
	'userboard_loggedout' => 'Do möß ald <a href="$1">enjelogg</a> sin, öm Nohrechte aan ander Metmaacher verschecke ze künne.',
	'userboard_showingmessages' => 'Dat {{PLURAL:$4|es de Nohreesch|sin de Nohreeschte $2 beß|nix}} $3 vun {{PLURAL:$1|eine Nohreesch|$1|nix}} ennsjesammp.',
	'right-userboard-delete' => 'Donn anderlücks Nohreeschte vun dä Pennwand fottschmiiße',
	'userboard-time-days' => '{{PLURAL:$1|eine Daach|$1 Dääsch|keine Daach}}',
	'userboard-time-hours' => '{{PLURAL:$1|ein Shtundt|$1 Shtunde|kein Shtundt}}',
	'userboard-time-minutes' => '{{PLURAL:$1|ein Menutt|$1 Menutte|kein Menutt}}',
	'userboard-time-seconds' => '{{PLURAL:$1|ein Sekund|$1 Sekunde|kein Sekund}}',
	'message_received_subject' => 'Dä Metmaacher $1 hät jet op Dinge Pinnwand {{GRAMMAR:em|{{SITENAME}}}} jedonn',
	'message_received_body' => 'Hallo $1,

dä Metmaacher $2 hät jraad op Ding Brett {{GRAMMAR:em|{{SITENAME}}}}
jeschrevve

Don hee klicke, öm dat ze beloore:

$3

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'boardblastlogintitle' => 'Dir musst ageloggt si fir Messagen a grousser Zuel op Panneauen ze schécken',
	'boardblastlogintext' => 'Fir d\'Fonctioun "board blast" ze benotze musst Dir [[Special:UserLogin|ageloggt sinn]].',
	'messagesenttitle' => 'Geschéckte Messagen',
	'boardblasttitle' => "Messagen a grousser Zuel op d'Panneaue schécken",
	'boardblaststep1' => '1. Schrëtt: Schreiwt äre Message',
	'boardblastprivatenote' => 'All Message ginn als privat Message verschéckt',
	'boardblaststep2' => '2. Schrëtt: Wielt aus wien Dir äre Message schöcke wellt',
	'boardlinkselectall' => 'Alles uwielen',
	'boardlinkunselectall' => 'Näischt ukräizen',
	'boardlinkselectfriends' => 'Frënn auswielen',
	'boardlinkunselectfriends' => 'Aus der Lëscht vun de Frënn ewechhuelen',
	'boardlinkselectfoes' => 'Géigner auswielen',
	'boardlinkunselectfoes' => 'Géigner net auswielen',
	'boardsendbutton' => "Messagen a grousser Zuel op d'Panneaue schécken",
	'boardnofriends' => 'Dir hutt keng Frënn deenen dir ee Message schécke kënnt!',
	'messagesentsuccess' => 'Äre Noriicht gouf geschéckt',
	'userboard' => 'Benotzerpanneau',
	'userboard_board-to-board' => 'Vu Panneau-zu-Panneau',
	'userboard_delete' => 'Läschen',
	'userboard_noexist' => 'De Benotzer den Dir wëllt gesi gëtt et net.',
	'userboard_yourboard' => 'Äre Panneau',
	'userboard_owner' => 'Dem $1 säi Panneau',
	'userboard_yourboardwith' => 'Är Diskussioun vu Panneau-zu-Panneau mam $1',
	'userboard_otherboardwith' => "D'Diskusioun vu Panneau-zu-Panneau tëschent dem $1 an dem $2",
	'userboard_backprofile' => 'Zréck op dem $1 säi Profil',
	'userboard_backyourprofile' => 'Zréck op äre Profil',
	'userboard_boardtoboard' => 'Vu Panneau-zu-Panneau',
	'userboard_confirmdelete' => 'Sidd Dir sécher datt Dir dëse Message läsche wëllt?',
	'userboard_sendmessage' => 'Dem $1 ee Message schécken',
	'userboard_myboard' => 'Mäi Panneau',
	'userboard_posted_ago' => 'viru(n) $1 geschéckt',
	'userboard_private' => 'privat',
	'userboard_public' => 'ëffentlech',
	'userboard_messagetype' => 'Typ vu Message',
	'userboard_nextpage' => 'nächst',
	'userboard_prevpage' => 'vireg',
	'userboard_nomessages' => 'Keng Messagen',
	'userboard_sendbutton' => 'geschéckt',
	'userboard_loggedout' => 'Dir musst <a href="$1">ageloggt si</a> fir anere Benotzer e Message ze schécken.',
	'userboard_showingmessages' => 'Weis {{PLURAL:$4|Noriicht $3|Noriichten $2-$3}} vu(n) {{PLURAL:$1|$1 Noriicht|$1 Noriichten}}',
	'right-userboard-delete' => 'Noriichten vun Aneren um Panneau läschen',
	'userboard-time-days' => '{{PLURAL:$1|een Dag|$1 Deeg}}',
	'userboard-time-hours' => '{{PLURAL:$1|eng Stonn|$1 Stonnen}}',
	'userboard-time-minutes' => '{{PLURAL:$1|eng Minutt|$1 Minutten}}',
	'userboard-time-seconds' => '{{PLURAL:$1|eng Sekonn|$1 Sekonnen}}',
	'message_received_subject' => 'De(n) $1 huet op äre Panneau op {{SITENAME}} geschriwwen',
	'message_received_body' => 'Salut $1.

$2 huet elo grad op Äre Panneau op {{SITENAME}} geschriwwen!

Klickt hei ënnendrënenr fir Ären Tableau ze kucken!

$3

---

Wëllt Dir keng Maile méi vun eis kréien?

Klickt $4
an ännert Är Astellunge fir E-Mail-Noriichten auszeschalten.',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'userboard_delete' => 'Pašalinti',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'userboard_delete' => 'Шӧраш',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'boardblastlogintitle' => 'Мора да сте најавени за да испраќате изјави на таблата',
	'boardblastlogintext' => 'За да праќате изјави на таблата, мора прво да сте [[Special:UserLogin|најавени]].',
	'messagesenttitle' => 'Пораките се испратени',
	'boardblasttitle' => 'Испрати изјава на таблата',
	'boardblaststep1' => 'Чекор 1 - Напишете ја пораката',
	'boardblastprivatenote' => 'Сите пораки ќе бидат испратени како приватни',
	'boardblaststep2' => 'Чекор 2 - Изберете кому сакате да ја испратите пораката',
	'boardlinkselectall' => 'Избери сè',
	'boardlinkunselectall' => 'Тргни избор',
	'boardlinkselectfriends' => 'Избери пријатели',
	'boardlinkunselectfriends' => 'Тргни избор на пријатели',
	'boardlinkselectfoes' => 'Избери непријатели',
	'boardlinkunselectfoes' => 'Тргни избор на непријатели',
	'boardsendbutton' => 'Испрати изјава на таблата',
	'boardnofriends' => 'Немате пријатели на кои можете да им испраќате пораки!',
	'messagesentsuccess' => 'Пораката ви е успешно испратена',
	'userboard' => 'Корисничка табла',
	'userboard_board-to-board' => 'Од табла на табла',
	'userboard_delete' => 'Избриши',
	'userboard_noexist' => 'Корисникот којшто сакате да го видите не постои.',
	'userboard_yourboard' => 'Вашата табла',
	'userboard_owner' => 'Таблата на $1',
	'userboard_yourboardwith' => 'Вашата од табла на табла со $1',
	'userboard_otherboardwith' => 'Од табла на табла на $1 со $2',
	'userboard_backprofile' => 'Назад кон профилот на $1',
	'userboard_backyourprofile' => 'Назад кон вашиот профил',
	'userboard_boardtoboard' => 'Од табла на табла',
	'userboard_confirmdelete' => 'Дали сте сигурни дека сакате да ја избришете оваа порака?',
	'userboard_sendmessage' => 'Испрати порака на $1',
	'userboard_myboard' => 'Мојата табла',
	'userboard_posted_ago' => 'испратена пред $1',
	'userboard_private' => 'приватна',
	'userboard_public' => 'јавна',
	'userboard_messagetype' => 'Тип на порака',
	'userboard_nextpage' => 'следни',
	'userboard_prevpage' => 'претходни',
	'userboard_nomessages' => 'Нема пораки.',
	'userboard_sendbutton' => 'испрати',
	'userboard_loggedout' => 'Мора да сте <a href="$1">најавени</a> за да можете да испраќате пораки до други корисници.',
	'userboard_showingmessages' => 'Приказ на {{PLURAL:$4|порака $3|пораки $2-$3}} од {{PLURAL:$1|$1 порака|$1 пораки}}',
	'right-userboard-delete' => 'Бришење на пораки на туѓи табли',
	'userboard-time-days' => '{{PLURAL:$1|еден ден|$1 дена}}',
	'userboard-time-hours' => '{{PLURAL:$1|еден час|$1 часа}}',
	'userboard-time-minutes' => '{{PLURAL:$1|една минута|$1 минути}}',
	'userboard-time-seconds' => '{{PLURAL:$1|една секунда|$1 секунди}}',
	'message_received_subject' => '$1 ви пиша на вашата табла на {{SITENAME}}',
	'message_received_body' => 'Здраво $1.

$2 штотуку Ви пиша на Вашата табла на {{SITENAME}}!

Кликнете подолу за да ја проверите пораката!

$3

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете известувања по е-пошта.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'messagesenttitle' => 'സന്ദേശങ്ങൾ അയച്ചു',
	'boardblaststep1' => 'ഘട്ടം 1 - താങ്കളുടെ സന്ദേശം എഴുതുക',
	'boardblastprivatenote' => 'എല്ലാ സന്ദേശങ്ങളും സ്വകാര്യസന്ദേശങ്ങളായി അയക്കും.',
	'boardblaststep2' => 'ഘട്ടം 3- സന്ദേശം കിട്ടേണ്ട ആളിനെ തിരഞ്ഞെടുക്കുക',
	'boardlinkselectall' => 'എല്ലാം തിരഞ്ഞെടുക്കുക',
	'boardlinkunselectall' => 'എല്ലാം സ്വതന്ത്രമാക്കുക',
	'boardlinkselectfriends' => 'കൂട്ടുകാരെ തിരഞ്ഞെടുക്കുക',
	'boardlinkunselectfriends' => 'കൂട്ടുകാരെ ഒഴിവാക്കുക',
	'userboard_delete' => 'മായ്ക്കുക',
	'userboard_confirmdelete' => 'ഈ സന്ദേശം ഒഴിവാക്കണമെന്നു താങ്കൾക്ക് ഉറപ്പാണോ?',
	'userboard_sendmessage' => '$1-നു സന്ദേശം അയക്കുക',
	'userboard_posted_ago' => '$1കൾക്ക് മുൻപ് പോസ്റ്റ് ചെയ്തത്',
	'userboard_private' => 'സ്വകാര്യം',
	'userboard_public' => 'പരസ്യമായത്',
	'userboard_nextpage' => 'അടുത്തത്',
	'userboard_prevpage' => 'മുൻപുള്ളത്',
	'userboard_nomessages' => 'സന്ദേശങ്ങളില്ല.',
	'userboard_sendbutton' => 'അയക്കൂ',
	'userboard_loggedout' => 'മറ്റുള്ള ഉപയോക്താക്കൾക്ക് സന്ദേശം ഇടാൻ താങ്കൾ <a href="$1">ലോഗിൻ</a> ചെയ്തിരിക്കണം.',
	'userboard_showingmessages' => '$2-$3 ന്റെ {{PLURAL:$1|$1 സന്ദേശം|$1 സന്ദേശങ്ങൾ}} കാണിക്കുന്നു',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'boardblastlogintitle' => 'बोर्ड ब्लास्ट पाठविण्यासाठी तुम्ही प्रवेश केलेला असणे आवश्यक आहे.',
	'boardblastlogintext' => 'बोर्ड ब्लास्ट पाठविण्यासाठी तुम्ही प्रवेश केलेला असणे आवश्यक आहे.
प्रवेश करण्यासाठी <a href="index.php?title=Special:UserLogin">इथे टिचकी</a> द्या.',
	'messagesenttitle' => 'संदेश पाठवले',
	'boardblasttitle' => 'बोर्ड ब्लास्ट पाठवा',
	'boardblaststep1' => 'पायरी १ - तुमचा संदेश लिहा',
	'boardblastprivatenote' => 'सर्व संदेश खाजगी संदेश स्वरूपात पाठवले जातील',
	'boardblaststep2' => 'पायरी २ - तुम्ही कुणाला संदेश पाठवायचा ते सदस्य निवडा',
	'boardlinkselectall' => 'सगळे निवडा',
	'boardlinkunselectall' => 'सगळी निवड रद्द करा',
	'boardlinkselectfriends' => 'मित्र निवडा',
	'boardlinkunselectfriends' => 'मित्र काढा',
	'boardlinkselectfoes' => 'शत्रू निवडा',
	'boardlinkunselectfoes' => 'शत्रू काढा',
	'boardsendbutton' => 'बोर्ड ब्लास्ट पाठवा',
	'boardnofriends' => 'तुम्हाला संदेश पाठविण्यासाठी एकही मित्र नाही!',
	'messagesentsuccess' => 'तुमचा संदेश पाठविलेला आहे',
	'userboard' => 'सदस्य बोर्ड',
	'userboard_board-to-board' => 'बोर्ड ते बोर्ड',
	'userboard_delete' => 'वगळा',
	'userboard_noexist' => 'तुम्ही बघू इच्छित असलेला सदस्य अस्तित्वात नाही',
	'userboard_yourboard' => 'तुमचे बोर्ड',
	'userboard_owner' => '$1चे बोर्ड',
	'userboard_yourboardwith' => 'तुमचे $1 बरोबरचे बोर्ड ते बोर्ड',
	'userboard_otherboardwith' => '$1चे $2 बरोबरचे बोर्ड ते बोर्ड',
	'userboard_backprofile' => '$1च्या प्रोफाइल कडे परत',
	'userboard_backyourprofile' => 'तुमच्या प्रोफाइल कडे परत',
	'userboard_boardtoboard' => 'बोर्ड ते बोर्ड',
	'userboard_confirmdelete' => 'तुम्ही खरोखरच हा संदेश वगळू इच्छिता?',
	'userboard_sendmessage' => '$1 ला एक संदेश पाठवा',
	'userboard_myboard' => 'माझे बोर्ड',
	'userboard_posted_ago' => '$1 पूर्वी पाठविला',
	'userboard_private' => 'खासगी',
	'userboard_public' => 'सार्वजनिक',
	'userboard_messagetype' => 'संदेश प्रकार',
	'userboard_nextpage' => 'पुढील',
	'userboard_prevpage' => 'मागे',
	'userboard_nomessages' => 'संदेश नाहीत.',
	'userboard_sendbutton' => 'पाठवा',
	'userboard_loggedout' => 'इतर सदस्यांना संदेश पाठविण्यासाठी तुम्ही <a href="$1">प्रवेश केलेला असणे</a> आवश्यक आहे.',
	'userboard_showingmessages' => '{{PLURAL:$1|$1 संदेशापैकी|$1 संदेशांपैकी}} $2-$3 दर्शवित आहोत',
	'message_received_subject' => '$1ने तुमच्या {{SITENAME}} वरच्या बोर्डवर संदेश लिहिलेला आहे',
	'message_received_body' => 'नमस्कार $1 :

$2 ने आत्ताच ( ( SITENAME ) )वरील तुमच्या पटलावर लिहीले आहे !

तुमचे पटल पहाण्याकरिता खाली टिचकी मारा!

$3

---

हे , तुम्हाला आमच्याकडून येणारी  विपत्रे बंद करून हवी आहेत काय ?

$4 वर टिचकी मारा
आणि विपत्र(ईमेल) सूचना अक्षम करण्याकरिता सुविधेत बदल करा.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'userboard_delete' => 'Hapuskan',
	'userboard_yourboard' => 'Papan anda',
	'userboard_owner' => 'Papan $1',
	'userboard_myboard' => 'Papan saya',
	'userboard_posted_ago' => 'dikirim $1 lalu',
	'userboard_private' => 'tertutup',
	'userboard_public' => 'umum',
	'userboard_messagetype' => 'Jenis pesanan',
	'userboard_nextpage' => 'berikutnya',
	'userboard_prevpage' => 'akhir',
	'userboard-time-days' => '{{PLURAL:$1|sehari|$1 hari}}',
	'userboard-time-hours' => '{{PLURAL:$1|sejam|$1 jam}}',
	'userboard-time-minutes' => '{{PLURAL:$1|seminit|$1 minit}}',
	'userboard-time-seconds' => '{{PLURAL: $1|sesaat|$1 saat}}',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'userboard_delete' => 'Нардамс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'userboard_delete' => 'Ticpolōz',
	'userboard_private' => 'ichtac',
	'userboard_nextpage' => 'niman',
	'userboard_sendbutton' => 'ticquihuāz',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'boardblastlogintitle' => 'U moet aangemeld zijn om berichten naar meerdere gebruikers te kunnen verzenden',
	'boardblastlogintext' => 'U moet [[Special:UserLogin|aanmelden]] om berichten naar meerdere gebruikers te kunnen verzenden.',
	'messagesenttitle' => 'Berichten verzonden',
	'boardblasttitle' => 'Bericht aan meerdere gebruikers verzenden',
	'boardblaststep1' => 'Stap 1: uw bericht schrijven',
	'boardblastprivatenote' => 'Alle berichten worden verzonden als privéberichten',
	'boardblaststep2' => 'Stap 2: ontvangers van uw bericht selecteren',
	'boardlinkselectall' => 'Alles selecteren',
	'boardlinkunselectall' => 'Alles deselecteren',
	'boardlinkselectfriends' => 'Vrienden selecteren',
	'boardlinkunselectfriends' => 'Vrienden deselecteren',
	'boardlinkselectfoes' => 'Tegenstanders selecteren',
	'boardlinkunselectfoes' => 'Tegenstanders deselecteren',
	'boardsendbutton' => 'Bericht naar meerdere gebruikers verzenden',
	'boardnofriends' => 'U hebt geen vrienden om een bericht aan te zenden!',
	'messagesentsuccess' => 'Uw bericht is verzonden',
	'userboard' => 'Gebruikersboard',
	'userboard_board-to-board' => 'Board-naar-board',
	'userboard_delete' => 'Verwijderen',
	'userboard_noexist' => 'De gebruiker die u wilt bekijken bestaat niet.',
	'userboard_yourboard' => 'Mijn board',
	'userboard_owner' => 'Board van $1',
	'userboard_yourboardwith' => 'Uw board-naar-board met $1',
	'userboard_otherboardwith' => 'Board-naar-board van $1 met $2',
	'userboard_backprofile' => 'Terug naar het profiel van $1',
	'userboard_backyourprofile' => 'Terug naar uw profiel',
	'userboard_boardtoboard' => 'Board-naar-board',
	'userboard_confirmdelete' => 'Wilt u dit bericht inderdaad verwijderen?',
	'userboard_sendmessage' => '$1 een bericht zenden',
	'userboard_myboard' => 'Mijn board',
	'userboard_posted_ago' => '$1 geleden gepost',
	'userboard_private' => 'persoonlijk',
	'userboard_public' => 'publiek',
	'userboard_messagetype' => 'Berichttype',
	'userboard_nextpage' => 'volgende',
	'userboard_prevpage' => 'vorige',
	'userboard_nomessages' => 'Geen berichten.',
	'userboard_sendbutton' => 'verzenden',
	'userboard_loggedout' => 'U moet <a href="$1">aangemeld</a> zijn om berichten naar andere gebruikers te verzenden.',
	'userboard_showingmessages' => '{{PLURAL:$4|Bericht $3|Berichten $2 tot $3}} van {{PLURAL:$1|$1 bericht|$1 berichten}} worden weergegeven',
	'right-userboard-delete' => 'Boardberichten van andere gebruikers verwijderen',
	'userboard-time-days' => '{{PLURAL:$1|één dag|$1 dagen}}',
	'userboard-time-hours' => '{{PLURAL:$1|één|$1}} uur',
	'userboard-time-minutes' => '{{PLURAL:$1|één minuut|$1 minuten}}',
	'userboard-time-seconds' => '{{PLURAL:$1|één seconde|$1 seconden}}',
	'message_received_subject' => '$1 heeft op uw board op {{SITENAME}} geschreven',
	'message_received_body' => 'Hallo $1.

$2 heeft net een bericht achtergelaten op uw board op {{SITENAME}}!

Klik op de onderstaande verwijzing om uw board te bekijken!

$3

---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'boardblastlogintitle' => 'Du må logga inn for kunna senda meldingar',
	'boardblastlogintext' => 'For å kunna senda meldingar, lyt du vera <a href="index.php?title=Special:UserLogin">innlogga</a>.',
	'messagesenttitle' => 'Sendte meldingar',
	'boardblasttitle' => 'Send melding',
	'boardblaststep1' => 'Steg 1 &ndash; skriv meldinga di',
	'boardblastprivatenote' => 'Alle meldingar vil vera private',
	'boardblaststep2' => 'Steg 2 &ndash; vel kven du vil senda meldinga til',
	'boardlinkselectall' => 'Merk alle',
	'boardlinkunselectall' => 'Fjern all merking',
	'boardlinkselectfriends' => 'Merk venner',
	'boardlinkunselectfriends' => 'Fjern merking av venner',
	'boardlinkselectfoes' => 'Merk fiendar',
	'boardlinkunselectfoes' => 'Fjern merking av fiendar',
	'boardsendbutton' => 'Send melding',
	'boardnofriends' => 'Du har ingen venner som du kan senda meldingar til.',
	'messagesentsuccess' => 'Meldinga di blei sendt',
	'userboard' => 'Brukardiskusjon',
	'userboard_board-to-board' => 'Brukardiskusjon',
	'userboard_delete' => 'Slett',
	'userboard_noexist' => 'Brukaren du freistar å sjå finst ikkje.',
	'userboard_yourboard' => 'Diskusjonssida di',
	'userboard_owner' => 'Diskusjonssida til $1',
	'userboard_yourboardwith' => 'Den delte diskusjonssida di med $1',
	'userboard_otherboardwith' => 'Delt diskusjonssida mellom $1 og $2',
	'userboard_backprofile' => 'Attende til profilen til $1',
	'userboard_backyourprofile' => 'Attende til profilen din',
	'userboard_boardtoboard' => 'Delt diskusjonssida',
	'userboard_confirmdelete' => 'Er du sikker på at du vil sletta denne meldinga?',
	'userboard_sendmessage' => 'Send ei melding til $1',
	'userboard_myboard' => 'Diskusjonssida mi',
	'userboard_posted_ago' => 'lagt inn $1 sidan',
	'userboard_private' => 'privat',
	'userboard_public' => 'offentleg',
	'userboard_messagetype' => 'Meldingstype',
	'userboard_nextpage' => 'neste',
	'userboard_prevpage' => 'førre',
	'userboard_nomessages' => 'Ingen meldingar.',
	'userboard_sendbutton' => 'send',
	'userboard_loggedout' => 'Du må vera <a href="$1">innlogga</a> for å senda meldingar til andre brukarar.',
	'userboard_showingmessages' => 'Syner {{PLURAL:$4|melding $3|meldingane $2&ndash;$3}} av {{PLURAL:$1|éi melding|$1 meldingar}} totalt',
	'right-userboard-delete' => 'Sletta andre sine meldingar',
	'userboard-time-days' => '{{PLURAL:$1|éin dag|$1 dagar}}',
	'userboard-time-hours' => '{{PLURAL:$1|éin time|$1 timar}}',
	'userboard-time-minutes' => '{{PLURAL:$1|eitt minutt|$1 minutt}}',
	'userboard-time-seconds' => '{{PLURAL:$1|eitt sekund|$1 sekund}}',
	'message_received_subject' => '$1 skreiv på diskusjonssida di på {{SITENAME}}',
	'message_received_body' => 'Hei, $1.

$2 har skrive på diskusjonssida di på {{SITENAME}}.

Følg lekkja nedanfor for å sjå diskusjonssida di.

$3

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'boardblastlogintitle' => 'Du må være logget inn for å sende meldinger',
	'boardblastlogintext' => 'For å kunne sende meldinger må du være <a href="index.php?title=Special:UserLogin">logget inn</a>.',
	'messagesenttitle' => 'Sendte beskjeder',
	'boardblasttitle' => 'Send melding',
	'boardblaststep1' => 'Steg 1 &ndash; skriv beskjeden din',
	'boardblastprivatenote' => 'Alle meldinger vil være private',
	'boardblaststep2' => 'Steg 2 &ndash; velg hvem du vil sende meldingen til',
	'boardlinkselectall' => 'Merk alle',
	'boardlinkunselectall' => 'Fjern all merking',
	'boardlinkselectfriends' => 'Merk venner',
	'boardlinkunselectfriends' => 'Fjern merking av venner',
	'boardlinkselectfoes' => 'Merk fiender',
	'boardlinkunselectfoes' => 'Fjern merking av fiender',
	'boardsendbutton' => 'Send melding',
	'boardnofriends' => 'Du har ingen venner å sende beskjed til.',
	'messagesentsuccess' => 'Beskjeden din ble sendt',
	'userboard' => 'Brukerdiskusjon',
	'userboard_board-to-board' => 'Brukerdiskusjon',
	'userboard_delete' => 'Slett',
	'userboard_noexist' => 'Brukeren du prøver å se finnes ikke.',
	'userboard_yourboard' => 'Din diskusjonsside',
	'userboard_owner' => 'Diskusjonssiden til $1',
	'userboard_yourboardwith' => 'Din delte diskusjonsside med $1',
	'userboard_otherboardwith' => 'Delt diskusjonsside mellom $1 og $2',
	'userboard_backprofile' => 'Tilbake til profilen til $1',
	'userboard_backyourprofile' => 'Tilbake til profilen din',
	'userboard_boardtoboard' => 'Delt diskusjonsside',
	'userboard_confirmdelete' => 'Er du sikker på at du vil slette denne beskjeden?',
	'userboard_sendmessage' => 'Send en beskjed til $1',
	'userboard_myboard' => 'Min diskusjonsside',
	'userboard_posted_ago' => 'postet $1 siden',
	'userboard_private' => 'privat',
	'userboard_public' => 'offentlig',
	'userboard_messagetype' => 'Beskjedtype',
	'userboard_nextpage' => 'neste',
	'userboard_prevpage' => 'forrige',
	'userboard_nomessages' => 'Ingen beskjeder.',
	'userboard_sendbutton' => 'send',
	'userboard_loggedout' => 'Du må være <a href="$1">logget inn</a> for å sende beskjeder til andre brukere.',
	'userboard_showingmessages' => 'Viser {{PLURAL:$4|melding $3|meldingene $2&ndash;$3}} av {{PLURAL:$1|$1 melding|$1 meldinger}}',
	'right-userboard-delete' => 'Slett andres meldinger',
	'userboard-time-days' => '{{PLURAL:$1|én dag|$1 dager}}',
	'userboard-time-hours' => '{{PLURAL:$1|én time|$1 timer}}',
	'userboard-time-minutes' => '{{PLURAL:$1|ett minutt|$1 minutt}}',
	'userboard-time-seconds' => '{{PLURAL:$1|ett sekund|$1 sekund}}',
	'message_received_subject' => '$1 har skrevet på diskusjonssiden din på {{SITENAME}}',
	'message_received_body' => 'Hei, $1.

$2 har skrevet på diskusjonssiden din på {{SITENAME}}.

Følg lenken nedenfor for å se diskusjonssiden din.

$3

---

Vil du ikke motta flere e-poster fra oss?

Klikk $4 og endre innstillingene dine for å slå av e-postbeskjeder.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'boardblastlogintitle' => 'Vos cal èsser en sesilha per mandar lo tablèu en mitralhada',
	'boardblastlogintext' => 'Per mandar lo tablèu en mitralhadas,
vos cal <a href="index.php?title=Special:UserLogin">èsser connectat(ada)</a>.',
	'messagesenttitle' => 'Messatges mandats',
	'boardblasttitle' => 'Mandar lo tablèu en mitralhada',
	'boardblaststep1' => 'Etapa 1 - Escrivètz vòstre messatge',
	'boardblastprivatenote' => 'Totes los messatges seràn mandats coma de messatges privats',
	'boardblaststep2' => 'Etapa 2 - Seleccionatz tanben a qui volètz mandar vòstre messatge',
	'boardlinkselectall' => 'Seleccionar tot',
	'boardlinkunselectall' => 'Deseleccionar tot',
	'boardlinkselectfriends' => 'Seleccionatz los amics',
	'boardlinkunselectfriends' => 'Deseleccionatz los amics',
	'boardlinkselectfoes' => 'Seleccionatz los enemics',
	'boardlinkunselectfoes' => 'Deseleccionatz los enemics',
	'boardsendbutton' => 'Mandaz lo tablèu en mitralhada',
	'boardnofriends' => "Avètz pas cap d'amic a qui mandar lo messatge",
	'messagesentsuccess' => 'Vòstre messatge es estat mandat amb succès',
	'userboard' => "Tablèu d'utilizaire",
	'userboard_board-to-board' => 'De tablèu a tablèu',
	'userboard_delete' => 'Suprimir',
	'userboard_noexist' => 'L’utilizaire que sètz a ensajar de visionar existís pas.',
	'userboard_yourboard' => 'Vòstre tablèu',
	'userboard_owner' => 'Lo tablèu de $1',
	'userboard_yourboardwith' => 'Vòstre tablèu a tablèu amb $1',
	'userboard_otherboardwith' => 'Lo tablèu a tablèu de $1 amb $2',
	'userboard_backprofile' => 'Retorn cap al perfil de $1',
	'userboard_backyourprofile' => 'Retorn cap a vòstre perfil',
	'userboard_boardtoboard' => 'Tablèu a tablèu',
	'userboard_confirmdelete' => 'Sètz segur que volètz suprimir aqueste messatge ?',
	'userboard_sendmessage' => 'Mandar un messatge a $1',
	'userboard_myboard' => 'Mon tablèu',
	'userboard_posted_ago' => 'mandat dempuèi $1',
	'userboard_private' => 'privat',
	'userboard_public' => 'public',
	'userboard_messagetype' => 'Tipe de messatge',
	'userboard_nextpage' => 'seguent',
	'userboard_prevpage' => 'precedent',
	'userboard_nomessages' => 'Pas de messatge.',
	'userboard_sendbutton' => 'mandat',
	'userboard_loggedout' => 'Vos cal èsser <a href="$1">connectat(ada)</a> per mandar de messatges a d’autres utilizaires.',
	'userboard_showingmessages' => 'Visionament {{PLURAL:$4|del messatge $3|dels messatges $2-$3}} sus un total de {{PLURAL:$1|$1 messatge|$1 messatges}}',
	'right-userboard-delete' => "Suprimir los messatges d'autres utilizaires",
	'userboard-time-days' => '{{PLURAL:$1|un jorn|$1 jorns}}',
	'userboard-time-hours' => '{{PLURAL:$1|una ora|$1 oras}}',
	'userboard-time-minutes' => '{{PLURAL:$1|una minuta|$1 minutas}}',
	'userboard-time-seconds' => '{{PLURAL:$1|una segonda|$1 segondas}}',
	'message_received_subject' => '$1 a escrich sus vòstre tablèu sus {{SITENAME}}',
	'message_received_body' => "Adiu $1 :

$2 ven just d'escriure sus vòstre tablèu sus {{SITENAME}} !

Clicatz sul ligam çaijós per anar sus vòstre tablèu !

$3

---

E ! Volètz arrestar d’obténer de corrièrs de nòstra part ?

Clicatz $4
e modificatz vòstres paramètres per desactivar las notificacions dels corrièrs electronics.",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'userboard_nextpage' => 'ପର',
	'userboard_prevpage' => 'ଆଗ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'userboard_delete' => 'Аппар',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'userboard_delete' => 'Lösche',
	'userboard_private' => 'private',
	'userboard_nextpage' => 'neegschte',
	'userboard_sendbutton' => 'schicke',
	'userboard-time-days' => '{{PLURAL:$1|een Daag|$1 Daag}}',
	'userboard-time-hours' => '{{PLURAL:$1|ee Schtund|$1 Schtunde}}',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'userboard_nextpage' => 'negschte',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'boardblastlogintitle' => 'Musisz się zalogować, aby pisać ogłoszenia na forum',
	'boardblastlogintext' => 'Wysłać ogłoszenie możesz dopiero po [[Special:UserLogin|zalogowaniu się]].',
	'messagesenttitle' => 'Wiadomości zostały wysłane',
	'boardblasttitle' => 'Wyślij ogłoszenie',
	'boardblaststep1' => 'Krok 1 – Napisz wiadomość',
	'boardblastprivatenote' => 'Wszystkie wiadomości będą wysyłane jako prywatne',
	'boardblaststep2' => 'Krok 2 – Wybierz, do kogo chcesz wysłać wiadomość',
	'boardlinkselectall' => 'Zaznacz wszystkich',
	'boardlinkunselectall' => 'Odznacz wszystkich',
	'boardlinkselectfriends' => 'Zaznacz znajomych',
	'boardlinkunselectfriends' => 'Odznacz znajomych',
	'boardlinkselectfoes' => 'Zaznacz wrogów',
	'boardlinkunselectfoes' => 'Odznacz wrogów',
	'boardsendbutton' => 'Wyślij ogłoszenie',
	'boardnofriends' => 'Nie masz żadnych znajomych.',
	'messagesentsuccess' => 'Wiadomość została wysłana',
	'userboard' => 'Forum użytkownika',
	'userboard_board-to-board' => 'Wspólne forum',
	'userboard_delete' => 'Usuń',
	'userboard_noexist' => 'Poszukiwany użytkownik nie istnieje.',
	'userboard_yourboard' => 'Twoje forum',
	'userboard_owner' => 'Forum użytkownika $1',
	'userboard_yourboardwith' => 'Twoje wspólne forum z $1',
	'userboard_otherboardwith' => 'Wspólne forum $1 oraz $2',
	'userboard_backprofile' => 'Powrót do profilu $1',
	'userboard_backyourprofile' => 'Powrót do Twojego profilu',
	'userboard_boardtoboard' => 'Wspólne forum',
	'userboard_confirmdelete' => 'Czy na pewno usunąć wiadomość?',
	'userboard_sendmessage' => 'Wyślij wiadomość do $1',
	'userboard_myboard' => 'Moje forum',
	'userboard_posted_ago' => 'wysłane $1 temu',
	'userboard_private' => 'prywatne',
	'userboard_public' => 'publiczne',
	'userboard_messagetype' => 'Typ wiadomości',
	'userboard_nextpage' => 'nast.',
	'userboard_prevpage' => 'poprz.',
	'userboard_nomessages' => 'Brak wiadomości.',
	'userboard_sendbutton' => 'wyślij',
	'userboard_loggedout' => 'Musisz <a href="$1">zalogować się</a> aby wysłać wiadomość do innego użytkownika.',
	'userboard_showingmessages' => 'Pokazano {{PLURAL:$4|wiadomość $3|wiadomości $2‐$3}} z $1',
	'right-userboard-delete' => 'Usuwanie z forum ogłoszeń wstawionych przez innych',
	'userboard-time-days' => '{{PLURAL:$1|jeden dzień|$1 dni}}',
	'userboard-time-hours' => '{{PLURAL:$1|jedną godzinę|$1 godziny|$1 godzin}}',
	'userboard-time-minutes' => '{{PLURAL:$1|jedną minutę|$1 minuty|$1 minut}}',
	'userboard-time-seconds' => '{{PLURAL:$1|jedną sekundę|$1 sekundy|$1 sekund}}',
	'message_received_subject' => '$1 napisał na Twoim forum na {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'message_received_body' => 'Witaj $1.

$2 napisał do Ciebie na {{GRAMMAR:MS.lp|{{SITENAME}}}}!

Kliknij poniżej aby sprawdzić swoje forum!

$3

---

Nie chcesz otrzymywać od nas maili?

Kliknij $4
i zmień ustawienia, wyłączając powiadomienia e‐mail.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'boardblastlogintitle' => 'A dev esse intrà ant ël sistema për mandé là tàula an ramà',
	'boardblastlogintext' => 'Per mandé dle tàule a ramà, a dev esse [[Special:UserLogin|intrà ant ël sistema]].',
	'messagesenttitle' => 'Mëssagi spedì',
	'boardblasttitle' => 'Manda na tàula an ramà',
	'boardblaststep1' => 'Pass 1 - Scriv tò mëssagi',
	'boardblastprivatenote' => 'Tùit ij mëssagi a saran mandà com mëssagi privà',
	'boardblaststep2' => 'Step 2 - Selession-a a chi it veule mandé tò mëssagi',
	'boardlinkselectall' => 'Selession-a tut',
	'boardlinkunselectall' => 'Deselession-a tut',
	'boardlinkselectfriends' => 'Selession-a amis',
	'boardlinkunselectfriends' => 'Deselession-a amis',
	'boardlinkselectfoes' => 'Selession-a nemis',
	'boardlinkunselectfoes' => 'Deselession-a nemis',
	'boardsendbutton' => 'Manda la tàula an ramà',
	'boardnofriends' => "It l'has pa d'amis da mandeje 'd mëssagi!",
	'messagesentsuccess' => "Tò mëssagi a l'é stàit mandà da bin",
	'userboard' => "Quàder ëd l'utent",
	'userboard_board-to-board' => 'Da quàder a quàder',
	'userboard_delete' => 'Scancela',
	'userboard_noexist' => "L'utent ch'it ses an camin ch'it sërche ëd visualisé a esit pa.",
	'userboard_yourboard' => 'Tò quàder',
	'userboard_owner' => 'Quàder ëd $1',
	'userboard_yourboardwith' => 'Tò da quàder a quàder con $1',
	'userboard_otherboardwith' => 'Ël da quàder a quàder ëd $1 con $2',
	'userboard_backprofile' => 'André al profil ëd $1',
	'userboard_backyourprofile' => 'André a tò profil',
	'userboard_boardtoboard' => 'Da quàder a quàder',
	'userboard_confirmdelete' => 'É-lo sicur ëd vorèj scancelé sto mëssagi-sì?',
	'userboard_sendmessage' => 'Manda un mëssagi a $1',
	'userboard_myboard' => 'Mè quàder',
	'userboard_posted_ago' => 'Spedì $1 fa',
	'userboard_private' => 'privà',
	'userboard_public' => 'Pùblich',
	'userboard_messagetype' => 'Tipo ëd mëssagi',
	'userboard_nextpage' => 'dapress',
	'userboard_prevpage' => 'prima',
	'userboard_nomessages' => 'Gnun mëssagi.',
	'userboard_sendbutton' => 'manda',
	'userboard_loggedout' => 'A dev esse <a href="$1">intrà ant ël sistema</a> për spedì dij mëssagi a d\'àutr utent.',
	'userboard_showingmessages' => 'Vision {{PLURAL:$4|dël mëssagi $3|dij mëssagi $2-$3}} ëd {{PLURAL:$1|$1 mëssagi|$1 mëssagi}}',
	'right-userboard-delete' => "Scancela ij mëssagi d'àutri utent",
	'userboard-time-days' => '{{PLURAL:$1|un di|$1 di}}',
	'userboard-time-hours' => '{{PLURAL:$1|one ora|$1 ore}}',
	'userboard-time-minutes' => '{{PLURAL:$1|na minuta|$1 minute}}',
	'userboard-time-seconds' => '{{PLURAL:$1|un second|$1 second}}',
	'message_received_subject' => "$1 a l'ha scrivù su tò quàder dzora {{SITENAME}}",
	'message_received_body' => "Cerea $1.

$2 a l'ha pen-e scrivuje su sò quàder dzora {{SITENAME}}!

Ch'a sgnaca sota për controlé sò quàder!

$3

---

Ch'a scota, veul-lo pa pi arseive mëssagi an pòsta eletrònica da noi?

Ch'a gnaca $4
e ch'a cambia ij sò gust për disabilité la notìfica dij mëssagi an pòsta eletrònica.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'messagesenttitle' => 'پېغامونه مو ولېږل شول',
	'boardblaststep1' => '۱ ګام - خپل پيغام وليکۍ',
	'boardlinkselectall' => 'ټول ټاکل',
	'boardlinkunselectall' => 'ټول ناټاکل',
	'boardlinkselectfriends' => 'ملګري ټاکل',
	'boardlinkunselectfriends' => 'ملګري ناټاکل',
	'boardlinkselectfoes' => 'سيالان ټاکل',
	'boardnofriends' => 'تاسې تر اوسه پورې هېڅ کوم ملګری نلری چې پيغام ورولېږۍ!',
	'messagesentsuccess' => 'ستاسې پيغام په برياليتوب سره ولېږل شو.',
	'userboard_delete' => 'ړنګول',
	'userboard_confirmdelete' => 'آيا تاسې ډاډه ياست چې تاسې همدا پيغام ړنګول غواړۍ؟',
	'userboard_sendmessage' => '$1 ته يو پيغام ولېږۍ',
	'userboard_public' => 'ټولګړی',
	'userboard_messagetype' => 'د پيغام ډول',
	'userboard_nextpage' => 'راتلونکي',
	'userboard_prevpage' => 'پخوانی',
	'userboard_nomessages' => 'هېڅ کوم پيغام نشته.',
	'userboard_sendbutton' => 'لېږل',
	'userboard-time-days' => '{{PLURAL:$1|يوه ورځ|$1 ورځې}}',
	'userboard-time-hours' => '{{PLURAL:$1|يو ساعت|$1 ساعتونه}}',
	'userboard-time-minutes' => '{{PLURAL:$1|يوه دقيقه|$1 دقيقې}}',
	'userboard-time-seconds' => '{{PLURAL:$1|يوه ثانيه|$1 ثانيې}}',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Vanessa Sabino
 * @author Waldir
 */
$messages['pt'] = array(
	'boardblastlogintitle' => 'Tem de estar autenticado para enviar recados',
	'boardblastlogintext' => 'Para enviar recados tem de [[Special:UserLogin|autenticar-se]].',
	'messagesenttitle' => 'Mensagens enviadas',
	'boardblasttitle' => 'Enviar recado',
	'boardblaststep1' => 'Passo 1 - Escreva a sua mensagem',
	'boardblastprivatenote' => 'Todas as mensagens serão enviadas como mensagens privadas',
	'boardblaststep2' => 'Passo 2 - Seleccione a quem deseja enviar a mensagem',
	'boardlinkselectall' => 'Seleccionar tudo',
	'boardlinkunselectall' => 'Não seleccionar nada',
	'boardlinkselectfriends' => 'Seleccionar amigos',
	'boardlinkunselectfriends' => 'Não seleccionar amigos',
	'boardlinkselectfoes' => 'Seleccionar inimigos',
	'boardlinkunselectfoes' => 'Não seleccionar inimigos',
	'boardsendbutton' => 'Enviar recado',
	'boardnofriends' => 'Não tem amigos a quem enviar uma mensagem!',
	'messagesentsuccess' => 'A sua mensagem foi enviada com sucesso',
	'userboard' => 'Mural do utilizador',
	'userboard_board-to-board' => 'Mural-a-mural',
	'userboard_delete' => 'Remover',
	'userboard_noexist' => 'O utilizador que está tentando ver não existe.',
	'userboard_yourboard' => 'O seu mural',
	'userboard_owner' => 'Mural de $1',
	'userboard_yourboardwith' => 'O seu mural-a-mural com $1',
	'userboard_otherboardwith' => 'Mural-a-mural de $1 com $2',
	'userboard_backprofile' => 'Voltar ao perfil de $1',
	'userboard_backyourprofile' => 'Voltar ao seu perfil',
	'userboard_boardtoboard' => 'Mural-a-mural',
	'userboard_confirmdelete' => 'Tem a certeza de que quer eliminar esta mensagem?',
	'userboard_sendmessage' => 'Enviar uma mensagem a $1',
	'userboard_myboard' => 'O meu mural',
	'userboard_posted_ago' => 'enviado há $1',
	'userboard_private' => 'privado',
	'userboard_public' => 'público',
	'userboard_messagetype' => 'Tipo de mensagem',
	'userboard_nextpage' => 'próxima',
	'userboard_prevpage' => 'anterior',
	'userboard_nomessages' => 'Sem mensagens.',
	'userboard_sendbutton' => 'enviar',
	'userboard_loggedout' => 'Precisa de <a href="$1">autenticar-se</a> para enviar mensagens a outros utilizadores.',
	'userboard_showingmessages' => 'Mostrando {{PLURAL:$4|mensagem $3|mensagens $2-$3}} de {{PLURAL:$1|$1 mensagem|$1 mensagens}}',
	'right-userboard-delete' => 'Eliminar mensagens no mural de outros',
	'userboard-time-days' => '{{PLURAL:$1|um dia|$1 dias}}',
	'userboard-time-hours' => '{{PLURAL:$1|uma hora|$1 horas}}',
	'userboard-time-minutes' => '{{PLURAL:$1|um minuto|$1 minutos}}',
	'userboard-time-seconds' => '{{PLURAL:$1|um segundo|$1 segundos}}',
	'message_received_subject' => '$1 escreveu no seu mural na {{SITENAME}}',
	'message_received_body' => 'Olá $1,

$2 acabou de escrever no seu mural na {{SITENAME}}!

Clique abaixo para ver o seu mural!

$3

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Helder.wiki
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'boardblastlogintitle' => 'Você precisa estar autenticado para enviar recados',
	'boardblastlogintext' => 'Para enviar recados,
você precisa estar <a href="index.php?title=Special:UserLogin">autenticado</a>',
	'messagesenttitle' => 'Mensagens Enviadas',
	'boardblasttitle' => 'Enviar recado',
	'boardblaststep1' => 'Passo 1 - Escreva a sua mensagem',
	'boardblastprivatenote' => 'Todas as mensagens serão enviadas como mensagens privadas',
	'boardblaststep2' => 'Passo 2 - Selecione a quem deseja enviar a sua mensagem',
	'boardlinkselectall' => 'Selecionar tudo',
	'boardlinkunselectall' => 'Desselecionar tudo',
	'boardlinkselectfriends' => 'Selecionar amigos',
	'boardlinkunselectfriends' => 'Desselecionar amigos',
	'boardlinkselectfoes' => 'Selecionar inimigos',
	'boardlinkunselectfoes' => 'Desselecionar inimigos',
	'boardsendbutton' => 'Enviar recado',
	'boardnofriends' => 'Você não tem amigos para enviar uma mensagem!',
	'messagesentsuccess' => 'Sua mensagem foi enviada com sucesso',
	'userboard' => 'Mural do utilizador',
	'userboard_board-to-board' => 'Mural-para-mural',
	'userboard_delete' => 'Remover',
	'userboard_noexist' => 'O utilizador que você está tentando ver não existe.',
	'userboard_yourboard' => 'Seu mural',
	'userboard_owner' => 'Mural de $1',
	'userboard_yourboardwith' => 'Seu mural-para-mural com $1',
	'userboard_otherboardwith' => 'Mural-para-mural de $1 com $2',
	'userboard_backprofile' => 'Voltar para perfil de $1',
	'userboard_backyourprofile' => 'Voltar para seu perfil',
	'userboard_boardtoboard' => 'Mural-para-mural',
	'userboard_confirmdelete' => 'Tem certeza de que você quer excluir essa mensagem?',
	'userboard_sendmessage' => 'Enviar uma mensagem para $1',
	'userboard_myboard' => 'Meu mural',
	'userboard_posted_ago' => 'enviado há $1',
	'userboard_private' => 'privado',
	'userboard_public' => 'público',
	'userboard_messagetype' => 'Tipo de Mensagem',
	'userboard_nextpage' => 'próxima',
	'userboard_prevpage' => 'anterior',
	'userboard_nomessages' => 'Sem mensagens.',
	'userboard_sendbutton' => 'enviar',
	'userboard_loggedout' => 'Você precida estar <a href="$1">autenticado</a> para enviar mensagens a outros usuários.',
	'userboard_showingmessages' => 'Mostrando {{PLURAL:$4|mensagem $3|mensagens $2-$3}} de {{PLURAL:$1|$1 mensagem|$1 mensagens}}',
	'right-userboard-delete' => 'Eliminar mensagens no mural de outros',
	'userboard-time-days' => '{{PLURAL:$1|um dia|$1 dias}}',
	'userboard-time-hours' => '{{PLURAL:$1|uma hora|$1 horas}}',
	'userboard-time-minutes' => '{{PLURAL:$1|um minuto|$1 minutos}}',
	'userboard-time-seconds' => '{{PLURAL:$1|um segundo|$1 segundos}}',
	'message_received_subject' => '$1 escreveu em seu mural em {{SITENAME}}',
	'message_received_body' => 'Oi $1:

$2 acabou de escrever em seu mural em {{SITENAME}}!

Clique abaixo para ver seu mural!

$3

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferênciar para desabilidar e-mails de notificação.',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'userboard_delete' => 'Sfaḍ',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'messagesenttitle' => 'Mesaje trimise',
	'boardblastprivatenote' => 'Toate mesajele vor fi trimise ca mesaje private',
	'boardlinkselectall' => 'Selectați tot',
	'boardlinkunselectall' => 'Deselectați tot',
	'boardlinkselectfriends' => 'Selectați prieteni',
	'boardlinkunselectfriends' => 'Deselectați prieteni',
	'boardlinkselectfoes' => 'Selectați inamici',
	'boardlinkunselectfoes' => 'Deselectați inamici',
	'userboard_delete' => 'Şterge',
	'userboard_posted_ago' => 'postat acum $1',
	'userboard_private' => 'privat',
	'userboard_public' => 'public',
	'userboard_messagetype' => 'Tipul mesajului',
	'userboard_nextpage' => 'următorul',
	'userboard_prevpage' => 'prec',
	'userboard_nomessages' => 'Nici un mesaj.',
	'userboard_sendbutton' => 'trimite',
	'userboard-time-days' => '{{PLURAL:$1|o zi|$1 zile}}',
	'userboard-time-hours' => '{{PLURAL:$1|o oră|$1 ore}}',
	'userboard-time-minutes' => '{{PLURAL:$1|un minut|$1 minute}}',
	'userboard-time-seconds' => '{{PLURAL:$1|o secundă|$1 secunde}}',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'boardlinkselectall' => 'Selezione tutte',
	'boardlinkunselectall' => 'No selezionà nisciune',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Flrn
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'boardblastlogintitle' => 'Нужно представиться системе',
	'boardblastlogintext' => 'Чтобы отправлять высказывания на доски, вы должны [[Special:UserLogin|войти в систему]]',
	'messagesenttitle' => 'Сообщение отправлено',
	'boardblasttitle' => 'Отправка высказывания на доску',
	'boardblaststep1' => 'Шаг 1 - Напишите ваше сообщение',
	'boardblastprivatenote' => 'Все сообщения будут отправляться как личные',
	'boardblaststep2' => 'Шаг 2 - Выберите комы вы хотите отправить сообщение',
	'boardlinkselectall' => 'Выбрать всех',
	'boardlinkunselectall' => 'Снять выделение',
	'boardlinkselectfriends' => 'Выбрать друзей',
	'boardlinkunselectfriends' => 'Исключить друзей',
	'boardlinkselectfoes' => 'Выбрать непрителей',
	'boardlinkunselectfoes' => 'Исключить неприятелей',
	'boardsendbutton' => 'Отправить высказывание на доску',
	'boardnofriends' => 'У вас нет друзей, для которых можно отправить сообщение.',
	'messagesentsuccess' => 'Ваше сообщение было успешно отправлено',
	'userboard' => 'Доска участника',
	'userboard_board-to-board' => 'Доска-к-доске',
	'userboard_delete' => 'Удалить',
	'userboard_noexist' => 'Участника, которого вы пытаетесь просмотреть, не существует.',
	'userboard_yourboard' => 'Ваша доска',
	'userboard_owner' => 'Доска участника $1',
	'userboard_yourboardwith' => 'Ваше доска-на-доску с $1',
	'userboard_otherboardwith' => 'Доска-на-доску участника $1 с $2',
	'userboard_backprofile' => 'Назад к очерку участника $1',
	'userboard_backyourprofile' => 'Назад к вашему очерку',
	'userboard_boardtoboard' => 'Доска-на-доску',
	'userboard_confirmdelete' => 'Вы уверены, что хотите удалить это сообщение?',
	'userboard_sendmessage' => 'Отправить сообщение $1',
	'userboard_myboard' => 'Моя доска',
	'userboard_posted_ago' => 'написано $1 назад',
	'userboard_private' => 'личное',
	'userboard_public' => 'общедоступное',
	'userboard_messagetype' => 'Тип сообщения',
	'userboard_nextpage' => 'след.',
	'userboard_prevpage' => 'пред.',
	'userboard_nomessages' => 'Нет сообщений.',
	'userboard_sendbutton' => 'отправить',
	'userboard_loggedout' => 'Вы должны быть <a href="$1">представлены системе</a>, чтобы отправлять сообщения другим участникам.',
	'userboard_showingmessages' => 'Отображение {{PLURAL:$4|сообщения $3|сообщений $2—$3}} из $1',
	'right-userboard-delete' => 'удаление сообщений других досок',
	'userboard-time-days' => '{{PLURAL:$1|$1 день|$1 дня|$1 дней}}',
	'userboard-time-hours' => '{{PLURAL:$1|$1 час|$1 часа|$1 часов}}',
	'userboard-time-minutes' => '{{PLURAL:$1|$1 минута|$1 минуты|$1 минут}}',
	'userboard-time-seconds' => '{{PLURAL:$1|$1 секунда|$1 секунды|$1 секунд}}',
	'message_received_subject' => '$1 написал(а) на вашу доску на сайте {{SITENAME}}',
	'message_received_body' => 'Привет, $1:

$2 написал(а) на вашу доску на сайте {{SITENAME}}!

Щёлкните ниже, чтобы просмотреть вашу доску!

$3

---

Не хотите больше получать писем от нас?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'boardlinkselectall' => 'Выбрати вшыткы',
	'boardlinkunselectall' => 'Зрушыти выбер',
	'boardlinkselectfriends' => 'Выбрати приятелїв',
	'boardlinkunselectfriends' => 'Зрушыти выбер приятелїв',
	'boardlinkselectfoes' => 'Выбрати неприятелїв',
	'boardlinkunselectfoes' => 'Зрушыти выбер неприятелїв',
	'boardsendbutton' => 'Послати повідомлїня фора',
	'boardnofriends' => 'Не маєте ниякых приятелїв, котрым бы сьте могли послати повідомлїня!',
	'userboard' => 'Хосновательске форум',
	'userboard_board-to-board' => 'Міджі фора',
	'userboard_delete' => 'Вымазати',
	'userboard_noexist' => 'Хоснователь котрого ся пробуєте зобразити не екзістує',
	'userboard_yourboard' => 'Ваше форум',
	'userboard_owner' => 'Форум хоснователя $1',
	'userboard_yourboardwith' => 'Ваше форум з хоснователём $1',
	'userboard_otherboardwith' => 'Форум хоснователя $1 з хоснователём $2',
	'userboard_backprofile' => 'Назад на профіл хоснователяl $1',
	'userboard_backyourprofile' => 'Назад на ваш профіл',
	'userboard_boardtoboard' => 'Міджі фора',
	'userboard_confirmdelete' => 'Напевно хочете змазати тото повідомлїня',
	'userboard_sendmessage' => 'Послати повідомлїня хоснователёви  $1',
	'userboard_myboard' => 'Моє форум',
	'userboard_posted_ago' => 'послане перед $1',
	'userboard_private' => 'пріватне',
	'userboard_public' => 'верейне',
	'userboard_messagetype' => 'Тіп повідомлїня',
	'userboard_nextpage' => 'далша',
	'userboard_prevpage' => 'попередня',
	'userboard_nomessages' => 'Жадны повідомлїня.',
	'userboard_sendbutton' => 'послати',
	'userboard_loggedout' => 'Мусите <a href="$1">ся приголосити</a>, жебы сьте могли посылати повідомлїня іншым хоснователям.',
	'userboard-time-days' => '$1 {{PLURAL:$1|день|днї|днїв}}',
	'userboard-time-hours' => '$1 {{PLURAL:$1|година|годины|годин}}',
	'userboard-time-minutes' => '$1 {{PLURAL:$1|минута|минуты|минут}}',
	'userboard-time-seconds' => '$1 {{PLURAL:$1|секунда|секунды|секунд}}',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'boardlinkselectall' => 'Барытын тал',
	'boardlinkunselectall' => 'Барытын талыыны суох гын',
	'boardlinkselectfriends' => 'Доҕоттору тал',
	'boardlinkunselectfriends' => 'Доҕоттору киллэримэ',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'boardblastlogintitle' => 'Musíte sa prihlásiť, aby ste mohli posielať správy fóra',
	'boardblastlogintext' => 'Musíte <a href="index.php?title=Special:UserLogin">sa prihlásiť</a>, aby ste mohli posielať správy fóra.',
	'messagesenttitle' => 'Poslaných správ',
	'boardblasttitle' => 'Poslať správu fóra',
	'boardblaststep1' => 'Krok 1 - Napíšte svoju správu',
	'boardblastprivatenote' => 'Všetky správy sa pošlú ako súkromné správy',
	'boardblaststep2' => 'Krok 2 - Vybete, komu svoju správu chcete poslať',
	'boardlinkselectall' => 'Vybrať všetkých',
	'boardlinkunselectall' => 'Zrušiť výber',
	'boardlinkselectfriends' => 'Vybrať priateľov',
	'boardlinkunselectfriends' => 'Zrušiť výber priateľov',
	'boardlinkselectfoes' => 'Vybrať nepriateľov',
	'boardlinkunselectfoes' => 'Zrušiť výber nepriateľov',
	'boardsendbutton' => 'Poslať správu fóra',
	'boardnofriends' => 'Nemáte žiadnych priateľov, ktorým by ste mohli poslať správu!',
	'messagesentsuccess' => 'Vaša správa bola úspešne odoslaná',
	'userboard' => 'Používateľské fórum',
	'userboard_board-to-board' => 'Medzi fórami',
	'userboard_delete' => 'Zmazať',
	'userboard_noexist' => 'Používateľ, ktorého sa pokúšate zobraziť, neexistuje.',
	'userboard_yourboard' => 'Vaše fórum',
	'userboard_owner' => 'Fórum používateľa $1',
	'userboard_yourboardwith' => 'Vaše fórum s používateľom $1',
	'userboard_otherboardwith' => 'Fórum používateľa $1 s používateľom $2',
	'userboard_backprofile' => 'Späť na profil používateľa $1',
	'userboard_backyourprofile' => 'Späť na váš profil',
	'userboard_boardtoboard' => 'Fórum s používateľom',
	'userboard_confirmdelete' => 'Ste si istý, že chcete zmazať túto správu?',
	'userboard_sendmessage' => 'Poslať správu používateľovi $1',
	'userboard_myboard' => 'Moje fórum',
	'userboard_posted_ago' => 'poslané pred $1',
	'userboard_private' => 'súkromné',
	'userboard_public' => 'verejné',
	'userboard_messagetype' => 'Typ správy',
	'userboard_nextpage' => 'ďal',
	'userboard_prevpage' => 'pred',
	'userboard_nomessages' => 'Žiadne správy.',
	'userboard_sendbutton' => 'poslať',
	'userboard_loggedout' => 'Musíte <a href="$1">sa prihlásiť</a>, aby ste mohli posielať správy iným používateľom.',
	'userboard_showingmessages' => '{{PLURAL:$4|Zobrazuje sa správa $3|Zobrazujú sa správy $2-$3}} z $1 {{PLURAL:$1|správy|správ}}',
	'right-userboard-delete' => 'Zmazať správy na fóre iných',
	'userboard-time-days' => '{{PLURAL:$1|jeden deň|$1 dni|$1 dní}}',
	'userboard-time-hours' => '{{PLURAL:$1|jedna hodina|$1 hodiny|$1 hodín}}',
	'userboard-time-minutes' => '{{PLURAL:$1|jedna minúta|$1 minúty|$1 minút}}',
	'userboard-time-seconds' => '{{PLURAL:$1|jedna sekunda|$1 sekundy|$1 sekúnd}}',
	'message_received_subject' => '$1 napísal na vaše fórum na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'message_received_body' => 'Ahoj, $1:

$2 napísal na vaše fórum na {{GRAMMAR:lokál|{{SITENAME}}}}

Po kliknutí na nasledujúci odkaz si môžete prečítať svoje fórum.

$3

---

Chcete prestať dostávať tieto emaily?

Kliknite sem $4
a zmeňte svoje nastavenia na vypnutie upozornení emailom.',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'messagesenttitle' => 'Поруке послате',
	'boardblaststep1' => 'Први корак - Напишите Вашу поруку',
	'boardblastprivatenote' => 'Све поруке ће бити послате као приватне поруке',
	'boardblaststep2' => 'Корак 2 - Назначите коме желите да пожаљете поруку',
	'boardlinkselectall' => 'Изабери све',
	'boardlinkunselectall' => 'Скини ознаке са свега',
	'boardlinkselectfriends' => 'Означи пријатеље',
	'boardlinkunselectfriends' => 'Скини ознаке са пријатеља',
	'boardlinkselectfoes' => 'Означи непријатеље',
	'boardlinkunselectfoes' => 'Скини ознаке са непријатеља',
	'boardnofriends' => 'Немате пријатеља којима бисте послали поруку!',
	'userboard_delete' => 'Брисање',
	'userboard_backprofile' => 'Повратак на профил од $1',
	'userboard_backyourprofile' => 'Назад на профил',
	'userboard_sendmessage' => 'Пошаљи поруку кориснику $1',
	'userboard_posted_ago' => 'послато пре $1',
	'userboard_private' => 'приватно',
	'userboard_public' => 'јавно',
	'userboard_messagetype' => 'Тип поруке',
	'userboard_nextpage' => 'следеће',
	'userboard_prevpage' => 'претходно',
	'userboard_nomessages' => 'Нема порука.',
	'userboard_sendbutton' => 'пошаљи',
	'userboard_loggedout' => 'Морате бити <a href="$1">улоговани</a> да бисте слали поруке другим корисницима.',
	'userboard-time-days' => '{{PLURAL:$1|један дан|$1 дана|$1 дана}}',
	'userboard-time-hours' => '{{PLURAL:$1|један сат|$1 сата|$1 сати}}',
	'userboard-time-minutes' => '{{PLURAL:$1|једна минута|$1 минуте|$1 минуте|$1 минуте|$1 минута}}',
	'userboard-time-seconds' => '{{PLURAL:$1|једна секунда|$1 секунде|$1 секунде|$1 секунде|$1 секунди}}',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'messagesenttitle' => 'Poruke poslate',
	'boardblaststep1' => 'Prvi korak - Napišite Vašu poruku',
	'boardblastprivatenote' => 'Sve poruke će biti poslate kao privatne poruke',
	'boardblaststep2' => 'Korak 2 - Naznačite kome želite da požaljete poruku',
	'boardlinkselectall' => 'Označi sve',
	'boardlinkunselectall' => 'Skini oznake sa svega',
	'boardlinkselectfriends' => 'Označi prijatelje',
	'boardlinkunselectfriends' => 'Skini oznake sa prijatelja',
	'boardlinkselectfoes' => 'Označi neprijatelje',
	'boardlinkunselectfoes' => 'Skini oznake sa neprijatelja',
	'boardnofriends' => 'Nemate prijatelja kojima biste poslali poruku!',
	'userboard_delete' => 'Brisanje',
	'userboard_backprofile' => 'Povratak na profil od $1',
	'userboard_backyourprofile' => 'Povratak na Vaš profil',
	'userboard_sendmessage' => 'Pošalji poruku korisniku $1',
	'userboard_posted_ago' => 'poslato pre $1',
	'userboard_private' => 'privatan',
	'userboard_public' => 'javan',
	'userboard_messagetype' => 'Tip poruke',
	'userboard_nextpage' => 'sledeće',
	'userboard_prevpage' => 'prethodno',
	'userboard_nomessages' => 'Nema poruka.',
	'userboard_sendbutton' => 'pošalji',
	'userboard_loggedout' => 'Morate biti <a href="$1">ulogovani</a> da biste slali poruke drugim korisnicima.',
	'userboard-time-days' => '{{PLURAL:$1|jedan dan|$1 dana}}',
	'userboard-time-hours' => '{{PLURAL:$1|jedan sat|$1 sata|$1 sata|$1 sata|$1 sati}}',
	'userboard-time-minutes' => '{{PLURAL:$1|jedna minuta|$1 minute|$1 minute|$1 minute|$1 minuta}}',
	'userboard-time-seconds' => '{{PLURAL:$1|jedna sekunda|$1 sekunde|$1 sekunde|$1 sekunde|$1 sekundi}}',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Jon Harald Søby
 * @author M.M.S.
 * @author Najami
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'boardblastlogintitle' => 'Du måste vara inloggad för att sända meddelanden',
	'boardblastlogintext' => 'För att kunna skicka meddelanden måste du vara [[Special:UserLogin|inloggad]].',
	'messagesenttitle' => 'Sända meddelanden',
	'boardblasttitle' => 'Sänd meddelande',
	'boardblaststep1' => 'Steg 1 - Skriv ditt meddelande',
	'boardblastprivatenote' => 'Alla meddelanden ska vara privata',
	'boardblaststep2' => 'Steg 2 - Välj vem du vill sända meddelandet till',
	'boardlinkselectall' => 'Märk alla',
	'boardlinkunselectall' => 'Radera all märkning',
	'boardlinkselectfriends' => 'Märk vänner',
	'boardlinkunselectfriends' => 'Ta bort märkning av vänner',
	'boardlinkselectfoes' => 'Märk fiender',
	'boardlinkunselectfoes' => 'Ta bort märkning av fiender',
	'boardsendbutton' => 'Sänd meddelande',
	'boardnofriends' => 'Du har inga vänner att sända meddelandet till!',
	'messagesentsuccess' => 'Ditt meddelande har skickats',
	'userboard' => 'Användardiskussion',
	'userboard_board-to-board' => 'Användardiskussion',
	'userboard_delete' => 'Radera',
	'userboard_noexist' => 'Användaren du prövar att se finns inte.',
	'userboard_yourboard' => 'Din diskussionssida',
	'userboard_owner' => '$1s diskussionssida',
	'userboard_yourboardwith' => 'Din delade diskussionssida med $1',
	'userboard_otherboardwith' => 'Dela diskussionsida mellan $1 och $2',
	'userboard_backprofile' => 'Tillbaka till $1s profil',
	'userboard_backyourprofile' => 'Tillbaka till din profil',
	'userboard_boardtoboard' => 'Delad diskussionssida',
	'userboard_confirmdelete' => 'Är du säker på att du vill radera detta meddelande?',
	'userboard_sendmessage' => 'Skickade ett meddelande till $1',
	'userboard_myboard' => 'Min diskussionssida',
	'userboard_posted_ago' => 'postat $1 sidan',
	'userboard_private' => 'privat',
	'userboard_public' => 'offentlig',
	'userboard_messagetype' => 'Meddelandetyp',
	'userboard_nextpage' => 'nästa',
	'userboard_prevpage' => 'föregående',
	'userboard_nomessages' => 'Inga meddelanden.',
	'userboard_sendbutton' => 'sänd',
	'userboard_loggedout' => 'Du måste vara <a href="$1">inloggad</a> för att skicka meddelanden till andra användare.',
	'userboard_showingmessages' => 'Visar {{PLURAL:$4|meddelande $3|$2-$3}} av {{PLURAL:$1|$1 meddelande|$1 meddelanden}}',
	'right-userboard-delete' => 'Ta bort andras meddelanden',
	'userboard-time-days' => '{{PLURAL:$1|en dag|$1 dagar}}',
	'userboard-time-hours' => '{{PLURAL:$1|en timme|$1 timmar}}',
	'userboard-time-minutes' => '{{PLURAL:$1|en minut|$1 minuter}}',
	'userboard-time-seconds' => '{{PLURAL:$1|en sekund|$1 sekunder}}',
	'message_received_subject' => '$1 har skrivit på din diskussionssida på {{SITENAME}}',
	'message_received_body' => 'Hej, $1.

$2 har skrivit på din diskussionssida på {{SITENAME}}.

Följ länken nedan för att se din diskussionssida.

$3

---

Vill du inte ta emot fler e-postmeddelanden från oss?

Klicka på $4 och ändra dina inställningar för att slå av e-postbesked.',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'userboard_delete' => 'நீக்கவும்',
	'userboard_private' => 'தனிப்பட்ட',
	'userboard_public' => 'பொதுவான',
	'userboard_nextpage' => 'அடுத்தது',
	'userboard_nomessages' => 'செய்திகள் இல்லை.',
	'userboard_sendbutton' => 'அனுப்பு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'messagesenttitle' => 'సందేశాలను పంపించాం',
	'boardblaststep1' => '1వ అంచె - మీ సందేశాన్ని వ్రాయండి',
	'boardblastprivatenote' => 'అన్ని సందేశాలని వ్యక్తిగత సందేశాలుగా పంపిస్తాం',
	'boardblaststep2' => '2వ అంచె - మీ సందేశాన్ని ఎవరికి పంపాలనుకుంటున్నారో ఎంచుకోండి',
	'boardlinkselectall' => 'అందరినీ ఎంచుకోండి',
	'boardlinkselectfriends' => 'స్నేహితులను ఎంచుకోండి',
	'boardlinkselectfoes' => 'శత్రువులను ఎంచుకోండి',
	'boardnofriends' => 'సందేశం పంపించడానికి మీకు స్నేహితులేవరూ లేరు!',
	'messagesentsuccess' => 'మీ సందేశాన్ని విజయవంతంగా పంపించాం',
	'userboard_delete' => 'తొలగించు',
	'userboard_noexist' => 'మీరు చూడాలనుకుంటున్న వాడుకరి లేనేలేరు.',
	'userboard_confirmdelete' => 'ఈ సందేశాన్ని మీరు తొలగించాలనుకుంటున్నారా?',
	'userboard_sendmessage' => '$1కి ఓ సందేశం పంపండి',
	'userboard_private' => 'అంతరంగికం',
	'userboard_public' => 'బహిరంగం',
	'userboard_messagetype' => 'సందేశపు రకం',
	'userboard_nextpage' => 'తర్వాతి',
	'userboard_prevpage' => 'క్రితం',
	'userboard_nomessages' => 'సందేశాలు లేవు.',
	'userboard_sendbutton' => 'పంపించు',
	'userboard-time-days' => '{{PLURAL:$1|ఒక రోజు|$1 రోజులు}}',
	'userboard-time-hours' => '{{PLURAL:$1|ఒక గంట|$1 గంటలు}}',
	'userboard-time-minutes' => '{{PLURAL:$1|ఒక నిమిషం|$1 నిమిషాలు}}',
	'userboard-time-seconds' => '{{PLURAL:$1|ఒక క్షణం|$1 క్షణాలు}}',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'userboard_delete' => 'Halakon',
	'userboard_nextpage' => 'oinmai',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'messagesenttitle' => 'Паёмҳои фиристода шуданд',
	'boardblaststep1' => 'Қадами 1 - Паёми худро нависед',
	'boardblastprivatenote' => 'Ҳамаи паёмҳо чун паёмҳои шахсӣ фиристода хоҳанд шуд',
	'boardblaststep2' => 'Қадами 2 - Ба шахсе, ки паём фиристодан мехоҳед интихоб кунед',
	'boardnofriends' => 'Шумо ягон дӯсте барои фиристодани паём надоред!',
	'messagesentsuccess' => 'Паёми шумо бо муваффақият фиристода шуд',
	'userboard' => 'Лавҳаи корбар',
	'userboard_delete' => 'Ҳазф',
	'userboard_noexist' => 'Корбаре ки шумо кушиши дидан карда истодаед вуҷуд надорад.',
	'userboard_yourboard' => 'Лавҳаи Шумо',
	'userboard_owner' => 'Лавҳаи $1',
	'userboard_yourboardwith' => 'Лавҳа-ба-лавҳаи шумо бо $1',
	'userboard_otherboardwith' => 'Лавҳа-ба-лавҳаи $1 бо $2',
	'userboard_boardtoboard' => 'Лавҳа-ба-лавҳа',
	'userboard_sendmessage' => 'Ба $1 паёме фирист',
	'userboard_myboard' => 'Лавҳаи Ман',
	'userboard_messagetype' => 'Навъи паём',
	'userboard_nextpage' => 'баъдӣ',
	'userboard_prevpage' => 'қаблӣ',
	'userboard_nomessages' => 'Пайғоме нест.',
	'userboard_sendbutton' => 'фирист',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'messagesenttitle' => 'Pajomhoi firistoda şudand',
	'boardblaststep1' => 'Qadami 1 - Pajomi xudro navised',
	'boardblastprivatenote' => 'Hamai pajomho cun pajomhoi şaxsī firistoda xohand şud',
	'boardblaststep2' => 'Qadami 2 - Ba şaxse, ki pajom firistodan mexohed intixob kuned',
	'boardnofriends' => 'Şumo jagon dūste baroi firistodani pajom nadored!',
	'messagesentsuccess' => 'Pajomi şumo bo muvaffaqijat firistoda şud',
	'userboard' => 'Lavhai korbar',
	'userboard_delete' => 'Hazf',
	'userboard_noexist' => 'Korbare ki şumo kuşişi didan karda istodaed vuçud nadorad.',
	'userboard_yourboard' => 'Lavhai Şumo',
	'userboard_owner' => 'Lavhai $1',
	'userboard_yourboardwith' => 'Lavha-ba-lavhai şumo bo $1',
	'userboard_otherboardwith' => 'Lavha-ba-lavhai $1 bo $2',
	'userboard_boardtoboard' => 'Lavha-ba-lavha',
	'userboard_sendmessage' => 'Ba $1 pajome firist',
	'userboard_myboard' => 'Lavhai Man',
	'userboard_messagetype' => "Nav'i pajom",
	'userboard_nextpage' => "ba'dī",
	'userboard_prevpage' => 'qablī',
	'userboard_nomessages' => 'Pajƣome nest.',
	'userboard_sendbutton' => 'firist',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'boardblastlogintitle' => 'คุณต้องลงชื่อเข้าใช้ก่อนที่จะกระจายข้อความ',
	'boardblastlogintext' => 'ในการที่จะกระจายข้อความนั้น
<br />คุณต้อง<a href="index.php?title=Special:UserLogin">ได้ลงชื่อเข้าใช้แล้ว</a>',
	'messagesenttitle' => 'ข้อความได้ถูกส่งแล้ว',
	'boardblasttitle' => 'กระจายข้อความ',
	'boardblaststep1' => 'ขั้นตอนที่ 1 - เขียนข้อความ',
	'boardblastprivatenote' => 'ข้อความทั้งหมดจะถูกส่งเป็นข้อความส่วนตัว',
	'boardblaststep2' => 'ขั้นตอนที่ 2 - เลือกผู้ที่จะส่งข้อความไปให้',
	'boardlinkselectall' => 'เลือกทั้งหมด',
	'boardlinkunselectall' => 'ไม่เลือกทั้งหมด',
	'boardlinkselectfriends' => 'เลือกเพื่อน',
	'boardlinkunselectfriends' => 'ไม่เลือกเพื่อน',
	'boardlinkselectfoes' => 'เลือกศัตรู',
	'boardlinkunselectfoes' => 'ไม่เลือกศัตรู',
	'boardsendbutton' => 'กระจายข้อความ',
	'boardnofriends' => 'คุณไม่มีเพื่อนที่จะส่งข้อความไปหา!',
	'messagesentsuccess' => 'ข้อความของคุณได้ถูกส่งไปเป็นที่เรียบร้อยแล้ว',
	'userboard' => 'บอร์ดของผู้ใช้',
	'userboard_board-to-board' => 'จากบอร์ด-ถึงบอร์ด',
	'userboard_delete' => 'ลบ',
	'userboard_noexist' => 'ไม่ปรากฎผู้ใช้ที่คุณกำลังพยายามดูอยู่',
	'userboard_yourboard' => 'บอร์ดของคุณ',
	'userboard_owner' => 'บอร์ดของ $1',
	'userboard_yourboardwith' => 'จากบอร์ด-ถึงบอร์ดกับ $1',
	'userboard_otherboardwith' => 'จากบอร์ด-ถึงบอร์ดของ $1 กับ $2',
	'userboard_backprofile' => 'กลับไปยังโปรไฟล์ของ $1',
	'userboard_backyourprofile' => 'กลับไปยังโปรไฟล์ของคุณ',
	'userboard_boardtoboard' => 'จากบอร์ด-ถึงบอร์ด',
	'userboard_confirmdelete' => 'คุณแน่ใจหรือไม่ที่จะลบข้อความนี้?',
	'userboard_sendmessage' => 'ส่งข้อความให้ $1',
	'userboard_myboard' => 'บอร์ดของฉัน',
	'userboard_posted_ago' => 'ส่งเมื่อ $1 ที่แล้ว',
	'userboard_private' => 'ส่วนบุคคล',
	'userboard_public' => 'สาธารณะ',
	'userboard_messagetype' => 'ประเภทข้อความ',
	'userboard_nextpage' => 'ถัดไป',
	'userboard_prevpage' => 'ก่อนหน้า',
	'userboard_nomessages' => 'ไม่มีข้อความ',
	'userboard_sendbutton' => 'ส่ง',
	'userboard_loggedout' => 'คุณต้อง<a href="$1">ลงชื่อเข้าใช้</a>เพื่อส่งข้อความไปยังผู้ใช้คนอื่นๆ',
	'userboard_showingmessages' => 'กำลังแสดง {{PLURAL:$4|ข้อความที่ $3|ข้อความที่ $2-$3}} จากทั้งหมด {{PLURAL:$1|$1 ข้อความ|$1 ข้่อความ}}',
	'right-userboard-delete' => 'ลบข้อความของบอร์ดอื่นๆ',
	'userboard-time-days' => '{{PLURAL:$1|1 วัน|$1 วัน}}',
	'userboard-time-hours' => '{{PLURAL:$1|1 ชั่วโมง|$1 ชั่วโมง}}',
	'userboard-time-minutes' => '{{PLURAL:$1|1 นาที|$1 นาที}}',
	'userboard-time-seconds' => '{{PLURAL:$1|1 วินาที|$1 วินาที}}',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'userboard_delete' => 'Öçür',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'boardblastlogintitle' => 'Dapat na nakalagda ka muna upang makapagpadala ng mga pitadang pampisara',
	'boardblastlogintext' => 'Upang makapagpadala ng mga pitadang pampisara, 
dapat na [[Special:UserLogin|nakalagda]] ka.',
	'messagesenttitle' => 'Naipadala na ang mga mensahe',
	'boardblasttitle' => 'Ipadala ang pitadang pampisara',
	'boardblaststep1' => 'Hakbang 1 - Isulat ang mensahe mo',
	'boardblastprivatenote' => 'Ipapadala ang lahat ng mga mensahe bilang pansarili/pribadong mga mensahe',
	'boardblaststep2' => 'Hakbang 2 - Piliin kung kanino mo nais na ipadala ang mensahe mo',
	'boardlinkselectall' => 'Piliin lahat',
	'boardlinkunselectall' => 'Tanggalin sa pagkakapili ang lahat',
	'boardlinkselectfriends' => 'Pumili ng mga kaibigan',
	'boardlinkunselectfriends' => 'Tanggalin sa pagkakapili ang mga kaibigan',
	'boardlinkselectfoes' => 'Pumili ng mga katunggali',
	'boardlinkunselectfoes' => 'Tanggalin sa pagkakapili ang mga katunggali',
	'boardsendbutton' => 'Ipadala ang pitadang pampisara',
	'boardnofriends' => 'Walang kang mga kaibigang mapapadalhan ng isang mensahe!',
	'messagesentsuccess' => 'Matagumpay na naipadala ang mensahe mo',
	'userboard' => 'Pisara ng tagagamit',
	'userboard_board-to-board' => 'Pisara-sa-pisara',
	'userboard_delete' => 'Burahin',
	'userboard_noexist' => 'Hindi umiiral ang tagagamit na sinusubok mong tingnan.',
	'userboard_yourboard' => 'Pisara mo',
	'userboard_owner' => 'Pisara ni $1',
	'userboard_yourboardwith' => 'Ang pisara-sa-pisara mo kay $1',
	'userboard_otherboardwith' => 'Ang pisara-sa-pisara ni $1 kay $2',
	'userboard_backprofile' => 'Bumalik sa talaang pangkatangian ni $1',
	'userboard_backyourprofile' => 'Magbalik sa iyong talaang pangkatangian',
	'userboard_boardtoboard' => 'Pisara-sa-pisara',
	'userboard_confirmdelete' => 'Nakatitiyak ka bang nais mong burahin ang mensaheng ito?',
	'userboard_sendmessage' => 'Magpadala ng isang mensahe kay $1',
	'userboard_myboard' => 'Pisara ko',
	'userboard_posted_ago' => 'itinala/pinaskil noong $1 na ang nakalilipas',
	'userboard_private' => 'pansarili (pribado)',
	'userboard_public' => 'pangmadla',
	'userboard_messagetype' => 'Uri ng mensahe',
	'userboard_nextpage' => 'susunod',
	'userboard_prevpage' => 'sinundan',
	'userboard_nomessages' => 'Walang mga mensahe.',
	'userboard_sendbutton' => 'ipadala',
	'userboard_loggedout' => 'Dapat na <a href="$1">nakalagda</a>  ka muna upang makapagtala/makapagpaskil ng mga mensahe sa iba pang mga tagagamit.',
	'userboard_showingmessages' => 'Nagpapakita ng {{PLURAL:$4|mensaheng $3|mga mensaheng $2-$3}} ng {{PLURAL:$1|$1 mensahe|$1 mga mensahe}}',
	'right-userboard-delete' => 'Burahin ang mga mensahe sa pisara ng iba',
	'userboard-time-days' => '{{PLURAL:$1|isang araw|$1 mga araw}}',
	'userboard-time-hours' => '{{PLURAL:$1|isang oras|$1 mga oras}}',
	'userboard-time-minutes' => '{{PLURAL:$1|isang minuto|$1 mga minuto}}',
	'userboard-time-seconds' => '{{PLURAL:$1|isang segundo|$1 mga segundo}}',
	'message_received_subject' => 'Sumulat si $1 sa iyong pisarang nasa {{SITENAME}}',
	'message_received_body' => 'Kumusta ka $1:

Katatapos lamang magsulat ni $2 sa iyong pisarang nasa {{SITENAME}}!

Pindutin sa ibaba upang matanaw na ang pisara mo!

$3

---

Hoy, nais mo bang tumigil na ang pagtanggap mo ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan upang huwag nang paganahin ang pagpapabatid na pang-e-liham.',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'boardblastlogintitle' => 'Pano gönderisi için oturum açmış olmanız gerekiyor',
	'boardblastlogintext' => 'Pano seri gönderisi göndermek için,
<a href="index.php?title=Special:UserLogin">oturum açmış</a> olmalısınız.',
	'messagesenttitle' => 'Mesaj gönder',
	'boardblasttitle' => 'Pano seri gönderisi gönder',
	'boardblaststep1' => '1. Adım - Mesajınızı yazın',
	'boardblastprivatenote' => 'Tüm mesajlar özel mesaj olarak gönderilecek',
	'boardblaststep2' => '2. Adım - Mesajınızı göndermek istediğiniz kişiyi seçin',
	'boardlinkselectall' => 'Tümünü seç',
	'boardlinkunselectall' => 'Tümünün seçimini kaldır',
	'boardlinkselectfriends' => 'Arkadaş seç',
	'boardlinkunselectfriends' => 'Arkadaşların seçimini kaldır',
	'boardlinkselectfoes' => 'Düşmanları seçin',
	'boardlinkunselectfoes' => 'Düşmanların seçimini kaldır',
	'boardsendbutton' => 'Pano seri gönderisi gönder',
	'boardnofriends' => 'Mesaj gönderebilecek bir arkadaşınız yok!',
	'messagesentsuccess' => 'Mesajınız başarıyla gönderildi',
	'userboard' => 'Kullanıcı panosu',
	'userboard_board-to-board' => 'Panodan panoya',
	'userboard_delete' => 'Sil',
	'userboard_noexist' => 'Görmeye çalıştığınız kullanıcı mevcut değil.',
	'userboard_yourboard' => 'Panonuz',
	'userboard_owner' => '$1 adlı kullanıcının panosu',
	'userboard_yourboardwith' => '$1 ile panodan panoya mesajlarınız',
	'userboard_otherboardwith' => '$1 ile $2 arasındaki panodan panoya mesajlaşma',
	'userboard_backprofile' => '$1 adlı kullanıcının profiline geri dön',
	'userboard_backyourprofile' => 'Profilinize geri dönün',
	'userboard_boardtoboard' => 'Panodan panoya',
	'userboard_confirmdelete' => 'Bu mesajı silmek istediğinizden emin misiniz?',
	'userboard_sendmessage' => '$1 adlı kullanıcıya bir mesaj gönder',
	'userboard_myboard' => 'Panom',
	'userboard_posted_ago' => '$1 önce gönderildi',
	'userboard_private' => 'özel',
	'userboard_public' => 'herkese açık',
	'userboard_messagetype' => 'Mesaj tipi',
	'userboard_nextpage' => 'sonraki',
	'userboard_prevpage' => 'önceki',
	'userboard_nomessages' => 'Mesaj yok.',
	'userboard_sendbutton' => 'gönder',
	'userboard_loggedout' => 'Diğer kullanıcılara mesaj göndermek için <a href="$1">oturum açmış olmanız</a> gerekmektedir.',
	'userboard_showingmessages' => '{{PLURAL:$1|$1 mesajdan|$1 mesajdan}} {{PLURAL:$4|$3. numaralı mesaj|$2-$3 arası mesajlar}} görüntüleniyor',
	'right-userboard-delete' => 'Diğerlerinin pano mesajlarını siler',
	'userboard-time-days' => '{{PLURAL:$1|bir gün|$1 gün}}',
	'userboard-time-hours' => '{{PLURAL:$1|bir saat|$1 saat}}',
	'userboard-time-minutes' => '{{PLURAL:$1|bir dakika|$1 dakika}}',
	'userboard-time-seconds' => '{{PLURAL:$1|bir saniye|$1 saniye}}',
	'message_received_subject' => '$1 adlı kullanıcı {{SITENAME}} üzerinde panonuza yazı yazdı',
	'message_received_body' => 'Merhaba $1.

$2, {{SITENAME}} üzerinde panonuza yazı yazdı!

Panonuzu kontrol etmek için aşağıya tıklayın!

$3

---

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'boardlinkselectall' => 'Обрати всі',
	'userboard_delete' => 'Вилучити',
	'userboard_posted_ago' => 'написано $1 тому',
	'userboard_public' => 'публічне',
	'userboard_messagetype' => 'Тип повідомлення',
	'userboard_nextpage' => 'наступна',
	'userboard_prevpage' => 'попередній',
	'userboard_nomessages' => 'Немає повідомлень.',
	'userboard_sendbutton' => 'надіслати',
	'userboard-time-days' => '$1 {{PLURAL:$1|день|дні|днів}}',
	'userboard-time-hours' => '$1 {{PLURAL:$1|година|години|годин}}',
	'userboard-time-minutes' => '$1 {{PLURAL:$1|хвилина|хвилини|хвилин}}',
	'userboard-time-seconds' => '$1 {{PLURAL:$1|секунда|секунди|секунд}}',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'userboard_nextpage' => "jäl'ghine",
	'userboard_prevpage' => 'edeline',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'boardlinkselectall' => 'Chọn tất cả',
	'userboard_delete' => 'Xóa',
	'userboard_public' => 'công khai',
	'userboard_nextpage' => 'sau',
	'userboard_prevpage' => 'trước',
	'userboard_nomessages' => 'Không có tin nhắn.',
	'userboard_sendbutton' => 'gửi',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'boardlinkselectall' => 'Välön valikis',
	'boardlinkunselectall' => 'Sävälön valikis',
	'boardlinkselectfriends' => 'Välön flenis',
	'boardlinkunselectfriends' => 'Sävälön flenis',
	'boardlinkselectfoes' => 'Välön neflenis',
	'boardlinkunselectfoes' => 'Sävälön neflenis',
	'userboard_delete' => 'Moükön',
	'userboard_confirmdelete' => 'Vilol-li fümiko moükön nuni at?',
	'userboard_sendmessage' => 'Sedön gebane: $1 penedi',
	'userboard_private' => 'privatik',
	'userboard_public' => 'notidik',
	'userboard_messagetype' => 'Nunasot',
	'userboard_nextpage' => 'sököl',
	'userboard_prevpage' => 'büik',
	'userboard_nomessages' => 'Nuns nonik.',
	'userboard_sendbutton' => 'sedön',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'userboard_delete' => 'אויסמעקן',
	'userboard_private' => 'פריוואַט',
	'userboard_nextpage' => 'נעקסט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'boardlinkselectall' => '选择全部',
	'boardlinkunselectall' => '取消选择所有',
	'boardlinkselectfriends' => '选择朋友',
	'boardlinkunselectfriends' => '取消选择朋友',
	'boardlinkselectfoes' => '选择仇敌',
	'userboard_delete' => '删除',
	'userboard_posted_ago' => '在$1前张贴',
	'userboard_private' => '私有',
	'userboard_public' => '公开',
	'userboard_nextpage' => '后继',
	'userboard_prevpage' => '先前',
	'userboard_nomessages' => '没有信息。',
	'userboard_sendbutton' => '发送',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'boardblaststep1' => '第 1 步 - 編寫您的訊息',
	'boardlinkselectall' => '選擇全部',
	'boardlinkunselectall' => '取消所有選擇',
	'boardlinkselectfriends' => '選擇朋友',
	'boardlinkunselectfriends' => '取消選擇朋友',
	'boardlinkselectfoes' => '選擇仇人',
	'boardlinkunselectfoes' => '取消選擇的仇人',
	'userboard_delete' => '刪除',
	'userboard_posted_ago' => '在 $1 前發表',
	'userboard_private' => '私有',
	'userboard_messagetype' => '訊息類型',
	'userboard_nomessages' => '沒有訊息。',
	'userboard_sendbutton' => '傳送',
	'userboard-time-days' => '{{PLURAL:$1|一天|$1 天}}',
	'userboard-time-hours' => '{{PLURAL:$1|一小時|$1 小時}}',
	'userboard-time-minutes' => '{{PLURAL:$1|一分鐘|$1 分鐘}}',
	'userboard-time-seconds' => '{{PLURAL:$1|一秒|$1 秒}}',
);

