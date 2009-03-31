<?php
/**
 * Internationalisation file for regexBlock extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 * @author Piotr Molski
 * @author Tomasz Klim
 */
$messages['en'] = array(
	'regexblock' => 'Regex block',
	'regexblock-already-blocked' => '$1 is already blocked.',
	'regexblock-block-log' => 'User name or IP address \'\'\'$1\'\'\' has been blocked.',
	'regexblock-block-success' => 'Block succedeed',
	'regexblock-currently-blocked' => 'Currently blocked addresses:',
	'regexblock-desc' => 'Extension used for blocking users names and IP addresses with regular expressions. Contains both the blocking mechanism and a [[Special:Regexblock|special page]] to add/manage blocks',
	'regexblock-expire-duration' => '1 hour,2 hours,4 hours,6 hours,1 day,3 days,1 week,2 weeks,1 month,3 months,6 months,1 year,infinite', // FIXME: looks like bad i18n. See 'ipboptions' in core
	'regexblock-page-title' => 'Regular expression name block',
	'regexblockstats' => 'Regex block statistics',
	'regexblock-help' => 'Use the form below to block write access from a specific IP address or username.
This should be done only to prevent vandalism, and in accordance with policy.
\'\'This page will allow you to block even non-existing users, and will also block users with names similar to given, i.e. "Test" will be blocked along with "Test 2" etc.
You can also block full IP addresses, meaning that no one logging in from them will be able to edit pages.
Note: partial IP addresses will be treated by usernames in determining blocking.
If no reason is specified, a default generic reason will be used.\'\'',
	'regexblock-page-title-1' => 'Block address using regular expressions',
	'regexblock-reason-ip' => 'This IP address is prevented from editing due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please $1' ,
	'regexblock-reason-name' => 'This username is prevented from editing due to vandalism or other disruption.
If you believe this is in error, please $1',
	'regexblock-reason-regex' => 'This username is prevented from editing due to vandalism or other disruption by a user with a similar name.
Please create an alternate user name or $1 about the problem',
	'regexblock-form-username' => 'IP address or username:',
	'regexblock-form-reason' => 'Reason:',
	'regexblock-form-expiry' => 'Expiry:',
	'regexblock-form-match' => 'Exact match',
	'regexblock-form-account-block' => 'Block creation of new accounts',
	'regexblock-form-submit' => 'Block this user',
	'regexblock-form-submit-empty' => 'Give a user name or an IP address to block.',
	'regexblock-form-submit-regex' => 'Invalid regular expression.',
	'regexblock-form-submit-expiry' => 'Please specify an expiration period.',
	'regexblock-match-stats-record' => "$1 blocked '$2' on '$3' at '$4', logging from address '$5'",
	'regexblock-nodata-found' => 'No data found',
	'regexblock-stats-title' => 'Regex block statistics',
	'regexblock-unblock-success' => 'Unblock succeeded',
	'regexblock-unblock-log' => 'User name or IP address \'\'\'$1\'\'\' has been unblocked.',
	'regexblock-unblock-error' => 'Error unblocking $1.
Probably there is no such user.',
	'regexblock-regex-filter' => ' or regex value: ', // FIXME: bad i18n. Static formatting and lego
	'regexblock-view-blocked' => 'View blocked by:',
	'regexblock-view-all' => 'All',
	'regexblock-view-go' => 'Go',
	'regexblock-view-match' => '(exact match)',
	'regexblock-view-regex' => '(regex match)',
	'regexblock-view-account' => '(account creation block)',
	'regexblock-view-reason' => 'reason: $1',
	'regexblock-view-reason-default' => 'generic reason',
	'regexblock-view-block-infinite' => 'permanent block',
	'regexblock-view-block-temporary' => 'expires on ',
	'regexblock-view-block-expired' => 'EXPIRED on ',
	'regexblock-view-block-by' => 'blocked by ',
	'regexblock-view-block-unblock' => 'unblock',
	'regexblock-view-stats' => 'stats',
	'regexblock-view-empty' => 'The list of blocked names and addresses is empty.',
	'regexblock-view-time' => 'on $1',
	'right-regexblock' => 'Block users from editing on all wikis on the wiki farm',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'regexblock-form-reason' => 'Kakano:',
	'regexblock-view-go' => 'Fano',
);

/** Goanese Konkani (Latin) (कोंकणी/Konknni  (Latin))
 * @author Deepak D'Souza
 */
$messages['gom-latn'] = array(
	'regexblock-stats-username' => '$1 kahtir',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'regexblock-form-reason' => 'Rede:',
	'regexblock-already-blocked' => '$1 is reeds geblok.',
	'regexblock-stats-username' => 'Vir $1',
	'regexblock-view-all' => 'Alles',
	'regexblock-view-go' => 'Gaan',
	'regexblock-view-reason' => 'rede: $1',
	'regexblock-view-time' => 'op $1',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'regexblock-form-reason' => 'ምክንያት:',
	'regexblock-view-all' => 'ሁሉ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'regexblock-form-reason' => 'Razón:',
	'regexblock-already-blocked' => '$1 ya yera bloqueyato.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'regexblock' => 'تعبير منتظم لمنع',
	'regexblock-already-blocked' => '$1 ممنوع بالفعل.',
	'regexblock-block-log' => "اسم المستخدم أو عنوان الأيبي '''$1''' تم منعه.",
	'regexblock-block-success' => 'المنع نجح',
	'regexblock-currently-blocked' => 'العناوين الممنوعة حاليا:',
	'regexblock-desc' => 'امتداد يستخدم لمنع أسماء المستخدمين وعناوين الأيبي باستخدام تعبيرات منتظمة. يحتوي على ميكانيكية المنع و [[Special:Regexblock|صفحة خاصة]] لإضافة/التحكم بعمليات المنع',
	'regexblock-page-title' => 'منع الاسم بواسطة تعبير منتظم',
	'regexblockstats' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-help' => 'استخدم الاستمارة بالأسفل لمنع التحرير من عنوان أيبي أو اسم مستخدم محدد.
هذا ينبغي أن يتم فقط لمنع التخريب، وبالتوافق مع السياسة.
\'\'هذه الصفحة ستسمح لك بمنع حتى المستخدمين غير الموجودين، وستمنع أيضا المستخدمين بأسماء مشابهة للمعطاة،أي أن "Test" سيتم منعها بالإضافة إلى "Test 2"إلى آخره.
يمكنك أيضا منع عناوين أيبي كاملة، مما يعني أنه لا أحد مسجلا للدخول منها سيمكنه تعديل الصفحات.
ملاحظة: عناوين الأيبي الجزئية سيتم معاملتها بواسطة أسماء مستخدمين في تحديد المنع.
لو لم يتم تحديد سبب، سيتم استخدام سبب افتراضي تلقائي.\'\'',
	'regexblock-page-title-1' => 'منع عنوان باستخدام تعبيرات منتظمة',
	'regexblock-reason-ip' => 'عنوان الأيبي هذا ممنوع نتيجة للتخريب أو إساءة أخرى بواسطتك أو بواسطة شخص يشارك في عنوان الأيبي الخاص بك.
لو كنت تعتقد أن هذا خطأ، من فضلك $1',
	'regexblock-reason-name' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى.
لو كنت تعتقد أن هذا خطأ، من فضلك $1',
	'regexblock-reason-regex' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى بواسطة مستخدم باسم مشابه.
من فضلك أنشيء اسم مستخدم بديل أو $1 حول المشكلة',
	'regexblock-form-username' => 'عنوان الأيبي أو اسم المستخدم:',
	'regexblock-form-reason' => 'السبب:',
	'regexblock-form-expiry' => 'الانتهاء:',
	'regexblock-form-match' => 'تطابق تام',
	'regexblock-form-account-block' => 'منع إنشاء الحسابات الجديدة',
	'regexblock-form-submit' => 'منع هذا المستخدم',
	'regexblock-form-submit-empty' => 'أعط اسم مستخدم أو عنوان أيبي للمنع.',
	'regexblock-form-submit-regex' => 'تعبير منتظم غير صحيح.',
	'regexblock-form-submit-expiry' => 'من فضلك حدد تاريخ انتهاء.',
	'regexblock-stats-title' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-unblock-success' => 'رفع المنع نجح',
	'regexblock-unblock-log' => "اسم المستخدم أو عنوان الأيبي '''$1''' تم رفع المنع عنه.",
	'regexblock-unblock-error' => 'خطأ أثناء رفع المنع عن $1.
على الأرجح لا يوجد مستخدم بهذا الاسم.',
	'regexblock-view-blocked' => 'عرض الممنوع بواسطة:',
	'regexblock-view-all' => 'الكل',
	'regexblock-view-go' => 'اذهب',
	'regexblock-view-match' => '(تطابق تام)',
	'regexblock-view-regex' => '(تطابق تعبير منتظم)',
	'regexblock-view-account' => '(منع إنشاء حساب)',
	'regexblock-view-reason' => 'السبب: $1',
	'regexblock-view-reason-default' => 'سبب تلقائي',
	'regexblock-view-block-infinite' => 'منع دائم',
	'regexblock-view-block-temporary' => 'ينتهي في',
	'regexblock-view-block-expired' => 'انتهى في',
	'regexblock-view-block-by' => 'ممنوع بواسطة',
	'regexblock-view-block-unblock' => 'رفع المنع',
	'regexblock-view-stats' => '(إحصاءات)',
	'regexblock-view-empty' => 'قائمة الأسماء والعناوين الممنوعة فارغة.',
	'regexblock-view-time' => 'في $1',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'regexblock' => 'تعبير منتظم لمنع',
	'regexblock-already-blocked' => '$1 ممنوع بالفعل.',
	'regexblock-block-log' => "اسم المستخدم أو عنوان الأيبى '''$1''' تم منعه.",
	'regexblock-block-success' => 'المنع نجح',
	'regexblock-currently-blocked' => 'العناوين الممنوعة حاليا:',
	'regexblock-desc' => 'امتداد يستخدم لمنع أسماء المستخدمين وعناوين الأيبى باستخدام تعبيرات منتظمة. يحتوى على ميكانيكية المنع و [[Special:Regexblock|صفحة خاصة]] لإضافة/التحكم بعمليات المنع',
	'regexblock-page-title' => 'منع الاسم بواسطة تعبير منتظم',
	'regexblockstats' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-help' => 'استخدم الاستمارة بالأسفل لمنع التحرير من عنوان أيبى أو اسم مستخدم محدد.
هذا ينبغى أن يتم فقط لمنع التخريب، وبالتوافق مع السياسة.
\'\'هذه الصفحة ستسمح لك بمنع حتى المستخدمين غير الموجودين، وستمنع أيضا المستخدمين بأسماء مشابهة للمعطاة،أى أن "Test" سيتم منعها بالإضافة إلى "Test 2"إلى آخره.
يمكنك أيضا منع عناوين أيبى كاملة، مما يعنى أنه لا أحد مسجلا للدخول منها سيمكنه تعديل الصفحات.
ملاحظة: عناوين الأيبى الجزئية سيتم معاملتها بواسطة أسماء مستخدمين فى تحديد المنع.
لو لم يتم تحديد سبب، سيتم استخدام سبب افتراضى تلقائي.\'\'',
	'regexblock-page-title-1' => 'منع عنوان باستخدام تعبيرات منتظمة',
	'regexblock-reason-ip' => 'عنوان الأيبى هذا ممنوع نتيجة للتخريب أو إساءة أخرى بواسطتك أو بواسطة شخص يشارك فى عنوان الأيبى الخاص بك.
لو كنت تعتقد أن هذا خطأ، من فضلك $1',
	'regexblock-reason-name' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى.
لو كنت تعتقد أن هذا خطأ، من فضلك $1',
	'regexblock-reason-regex' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى بواسطة مستخدم باسم مشابه.
من فضلك أنشيء اسم مستخدم بديل أو $1 حول المشكلة',
	'regexblock-form-username' => 'عنوان الأيبى أو اسم المستخدم:',
	'regexblock-form-reason' => 'السبب:',
	'regexblock-form-expiry' => 'الانتهاء:',
	'regexblock-form-match' => 'تطابق تام',
	'regexblock-form-account-block' => 'منع إنشاء الحسابات الجديدة',
	'regexblock-form-submit' => 'منع هذا المستخدم',
	'regexblock-form-submit-empty' => 'أعط اسم مستخدم أو عنوان أيبى للمنع.',
	'regexblock-form-submit-regex' => 'تعبير منتظم غير صحيح.',
	'regexblock-form-submit-expiry' => 'من فضلك حدد تاريخ انتهاء.',
	'regexblock-nodata-found' => 'مافيش بيانات اتلقت',
	'regexblock-stats-title' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-unblock-success' => 'رفع المنع نجح',
	'regexblock-unblock-log' => "اسم المستخدم أو عنوان الأيبى '''$1''' تم رفع المنع عنه.",
	'regexblock-unblock-error' => 'خطأ أثناء رفع المنع عن $1.
على الأرجح لا يوجد مستخدم بهذا الاسم.',
	'regexblock-view-blocked' => 'عرض الممنوع بواسطة:',
	'regexblock-view-all' => 'الكل',
	'regexblock-view-go' => 'اذهب',
	'regexblock-view-match' => '(تطابق تام)',
	'regexblock-view-regex' => '(تطابق تعبير منتظم)',
	'regexblock-view-account' => '(منع إنشاء حساب)',
	'regexblock-view-reason' => 'السبب: $1',
	'regexblock-view-reason-default' => 'سبب تلقائي',
	'regexblock-view-block-infinite' => 'منع دائم',
	'regexblock-view-block-temporary' => 'ينتهى في',
	'regexblock-view-block-expired' => 'انتهى في',
	'regexblock-view-block-by' => 'ممنوع بواسطة',
	'regexblock-view-block-unblock' => 'رفع المنع',
	'regexblock-view-stats' => 'ستاتس',
	'regexblock-view-empty' => 'قائمة الأسماء والعناوين الممنوعة فارغة.',
	'regexblock-view-time' => 'فى $1',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'regexblock-form-reason' => 'Прычына:',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'regexblock-already-blocked' => '$1 е вече блокиран.',
	'regexblock-block-log' => "Потребител или IP адрес '''$1''' беше блокиран.",
	'regexblock-block-success' => 'Блокирането беше успешно',
	'regexblock-currently-blocked' => 'Текущо блокирани адреси:',
	'regexblock-page-title-1' => 'Блокиране на адреси чрез регулярни изрази',
	'regexblock-reason-ip' => 'На това потребителско име не е позволено да редактира заради вандализъм или други разрушаващи действия от потребител, който споделя същия IP-адрес. Ако смятате, че това е грешка, $1',
	'regexblock-reason-name' => 'На това потребителско име не е позволено да редактира заради вандализъм или други разрушаващи действия. Ако смятате, че това е грешка, $1',
	'regexblock-reason-regex' => 'На това потребителско име не е позволено да редактира заради вандализъм или други разрушаващи действия от потребител със сходно име. Можете да създадете друга потребителска сметка или да $1 за проблема',
	'regexblock-form-username' => 'IP адрес или потребителско име:',
	'regexblock-form-reason' => 'Причина:',
	'regexblock-form-expiry' => 'Срок на изтичане:',
	'regexblock-form-match' => 'Пълно съвпадение',
	'regexblock-form-account-block' => 'Блокиране създаването на нови сметки',
	'regexblock-form-submit' => 'Блокиране на този потребител',
	'regexblock-form-submit-regex' => 'Невалиден регулярен израз.',
	'regexblock-form-submit-expiry' => 'Необходимо е да бъде посочен срок на изтичане.',
	'regexblock-unblock-success' => 'Отблокирането беше успешно',
	'regexblock-unblock-log' => "Потребителят или IP адресът '''$1''' беше отблокиран.",
	'regexblock-unblock-error' => 'Грешка при отблокиране на $1.
Вероятно не съществува такъв потребител.',
	'regexblock-view-blocked' => 'Преглед на блокираните по:',
	'regexblock-view-all' => 'Всички',
	'regexblock-view-match' => '(пълно съвпадение)',
	'regexblock-view-reason' => 'причина: $1',
	'regexblock-view-block-infinite' => 'перманентно блокиране',
	'regexblock-view-block-temporary' => 'изтича на',
	'regexblock-view-block-by' => 'блокиран от',
	'regexblock-view-block-unblock' => 'отблокиране',
	'regexblock-view-stats' => '(статистика)',
	'regexblock-view-empty' => 'Списъкът на блокирани имена и адреси е празен.',
	'regexblock-view-time' => 'на $1',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'regexblock-form-reason' => 'Razlog:',
	'regexblock-already-blocked' => '$1 je već blokiran.',
	'regexblock-view-all' => 'Sve',
	'regexblock-view-go' => 'Idi',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'regexblock-already-blocked' => '$1 ja està blocat.',
	'regexblock-view-go' => 'Vés-hi',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'regexblock-view-go' => 'Hånao',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'regexblock-view-all' => 'Oll',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'regexblock-form-reason' => 'Begrundelse:',
	'regexblock-stats-username' => 'For $1',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Imre
 * @author Melancholie
 * @author Purodha
 * @author Revolus
 */
$messages['de'] = array(
	'regexblock' => 'Regex-Sperre',
	'regexblock-already-blocked' => '$1 ist bereits gesperrt.',
	'regexblock-block-log' => "Benutzername oder IP-Adresse '''$1''' wurde gesperrt.",
	'regexblock-block-success' => 'Sperrung erfolgreich',
	'regexblock-currently-blocked' => 'Derzeit gesperrte Adressen:',
	'regexblock-desc' => 'Erweiterung zum Sperren von Benutzernamen und IP-Adressen mit regulären Ausdrücken. Enthält den Sperrmechanismus und eine [[Special:Regexblock|Spezialseite]] um Sperren hinzuzufügen und zu verwalten',
	'regexblock-page-title' => 'Namenssperre mit regulären Ausdrücken',
	'regexblockstats' => 'Regex-Sperrstatistiken',
	'regexblock-page-title-1' => 'Sperre Adressen anhand regulärer Ausdrücke',
	'regexblock-reason-ip' => 'Dieser IP-Adresse ist es verboten zu Editieren, da von dieser IP-Adresse – von dir oder jemandem mit derselben IP-Adresse – Vandalismus oder schädliches Verhalten ausging.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, $1',
	'regexblock-reason-name' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem verhalten, verboten zu Editieren.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, $1',
	'regexblock-reason-regex' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem Verhalten eines Benutzers mit einem ähnliches Benutzernamen, verboten zu Editieren.
Bitte melde dich mit einem anderen Benutzernamen an oder $1 über das Problem.',
	'regexblock-form-username' => 'IP-Adresse oder Benutzername:',
	'regexblock-form-reason' => 'Grund:',
	'regexblock-form-expiry' => 'Ablaufdatum:',
	'regexblock-form-match' => 'Genauer Treffer',
	'regexblock-form-account-block' => 'Sperre die Erstellung neuer Accounts',
	'regexblock-form-submit' => 'Sperre diesen Benutzer',
	'regexblock-form-submit-empty' => 'Einen Benutzernamen oder eine IP-Adresse für die Sperrung angeben.',
	'regexblock-form-submit-regex' => 'Ungültiger regulärer Ausdruck.',
	'regexblock-form-submit-expiry' => 'Bitte wähle einen Verfallszeitraum.',
	'regexblock-stats-title' => 'Regex-Sperrstatistiken',
	'regexblock-unblock-success' => 'Entsperrung erfolgreich',
	'regexblock-unblock-log' => "Benutzername oder IP-Adresse '''$1''' wurde entsperrt.",
	'regexblock-unblock-error' => 'Fehler beim Entsperren von $1.
Vermutlich gibt es keinen solchen Benutzer.',
	'regexblock-view-blocked' => 'Ansicht gesperrt von:',
	'regexblock-view-all' => 'Alle',
	'regexblock-view-go' => 'Los',
	'regexblock-view-match' => '(genauer Treffer)',
	'regexblock-view-regex' => '(Regex-Treffer)',
	'regexblock-view-account' => '(Accounterstellung gesperrt)',
	'regexblock-view-reason' => 'Grund: $1',
	'regexblock-view-reason-default' => 'allgemeiner Grund',
	'regexblock-view-block-infinite' => 'permanente Sperrung',
	'regexblock-view-block-temporary' => 'läuft ab am',
	'regexblock-view-block-expired' => 'ABGELAUFEN am',
	'regexblock-view-block-by' => 'gesperrt von',
	'regexblock-view-block-unblock' => 'entsperren',
	'regexblock-view-stats' => 'Statistiken',
	'regexblock-view-empty' => 'Die Liste der gesperrten Namen und Adressen ist leer.',
	'regexblock-view-time' => 'am $1',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Revolus
 */
$messages['de-formal'] = array(
	'regexblock-reason-ip' => 'Dieser IP-Adresse ist es verboten zu Editieren, da von dieser IP-Adresse – von Ihnen oder jemandem mit derselben IP-Adresse – Vandalismus oder schädliches Verhalten ausging.
Wenn Sie denken, dass es sich hierbei um einen Fehler handelt, $1',
	'regexblock-reason-name' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem Verhalten, verboten zu Editieren.
Wenn Sie denken, dass es sich hierbei um einen Fehler handelt, $1',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'regexblock-form-reason' => 'Λόγος:',
	'regexblock-stats-username' => 'Για $1',
	'regexblock-view-reason' => 'Λόγος: $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'regexblock-unblock-success' => 'Malforbaro sukcesis',
	'regexblock-unblock-log' => "Salutnomo aŭ IP-adreso '''$1''' estis restarigita.",
	'regexblock-unblock-error' => 'Eraro malforbarante $1.
Verŝajne ne estas uzanto kun tiu nomo.',
	'regexblock-form-username' => 'IP Adreso aŭ salutnomo:',
	'regexblock-form-reason' => 'Kialo:',
	'regexblock-form-expiry' => 'Findato:',
	'regexblock-form-submit' => 'Forbari ĉi tiun uzanton',
	'regexblock-block-success' => 'Forbaro sukcesis',
	'regexblock-already-blocked' => '$1 jam estas forbarita.',
	'regexblock-stats-username' => 'Por $1',
	'regexblock-stats-times' => 'estis forbarita je',
	'regexblock-currently-blocked' => 'Nune forbaritaj adresoj:',
	'regexblock-view-all' => 'Ĉiuj',
	'regexblock-view-go' => 'Ek!',
	'regexblock-view-reason' => 'kialo: $1',
	'regexblock-view-reason-default' => 'malspecifa kialo',
	'regexblock-view-block-by' => 'forbarita de',
	'regexblock-view-block-unblock' => 'restarigu',
	'regexblock-view-time' => 'je $1',
);

/** Spanish (Español)
 * @author Imre
 * @author Jatrobat
 * @author Piolinfax
 */
$messages['es'] = array(
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-stats-username' => 'Por $1',
	'regexblock-view-all' => 'Todos',
	'regexblock-view-go' => 'Ir',
	'regexblock-view-reason' => 'Motivo: $1',
	'regexblock-view-block-unblock' => 'desbloquear',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Urhixidur
 */
$messages['fr'] = array(
	'regexblock' => 'Expressions régulières pour bloquer un utilisateur ou une IP',
	'regexblock-already-blocked' => '$1 est déjà bloqué.',
	'regexblock-block-log' => "L’Utilisateur ou l’adresse IP '''$1''' a été bloqué.",
	'regexblock-block-success' => 'Le blocage a réussi',
	'regexblock-currently-blocked' => 'Adresses actuellement bloquées :',
	'regexblock-desc' => 'Extension utilisée pour bloquer des utilisateurs ou des adresses IP avec des expressions régulières. Contient à la fois un mécanisme de blocage ainsi qu’[[Special:Regexblock|une page]] pouvant ajouter et gérer les blocages',
	'regexblock-expire-duration' => '1 heure,2 heures,4 heures,6 hours,1 jour,3 jours,1 semaine,2 semaines,1 mois,3 mois,6 mois,1 and,infini',
	'regexblock-page-title' => 'Blocage d’un nom par une expression régulière',
	'regexblockstats' => 'Statistiques sur les blocages par expressions régulières',
	'regexblock-help' => "Utilisez le formulaire ci-dessous pour bloquer l’accès en écriture d’une adresse IP ou d’un nom d’utilisateur. Ceci doit être fait uniquement pour éviter tout vandalisme et conformément aux règles prescrites sur le projet. ''Cette page vous autorise même à bloquer des utilisateurs non enregistrés et permet aussi de bloquer des utilisateur présentant des noms similaires. Par exemple, « Test » sera bloqué en même temps que « Test 2 » etc. Vous pouvez aussi bloquer des adresses IP entières, ce qui signifie que personne travaillant depuis celles-ci ne pourra éditer des pages. Note : des adresses IP partielles seront considérées comme des noms d’utilisateur lors du blocage. Si aucun motif n’est indiqué en commentaire, un motif par défaut sera indiqué.''",
	'regexblock-page-title-1' => 'Blocage d’une adresse utilisant une expression régulière',
	'regexblock-reason-ip' => 'Cette adresse IP est écartée de toute édition pour cause de vandalisme ou autres faits analogues par vous ou quelqu’un d’autre partageant votre adresse IP. Si vous êtes persuadé qu’il s’agit d’une erreur, $1',
	'regexblock-reason-name' => 'Cet utilisateur est écarté de toute édition pour cause de vandalisme ou autres faits analogues. Si vous êtes persuadé qu’il s’agit d’une erreur, $1.',
	'regexblock-reason-regex' => 'Cet utilisateur est écarté de toute édition pour cause de vandalisme ou autres faits analogues par un utilisateur ayant un nom similaire. Veuillez créer un autre compte ou $1 pour signaler le problème.',
	'regexblock-form-username' => 'Adresse IP ou Utilisateur :',
	'regexblock-form-reason' => 'Motif :',
	'regexblock-form-expiry' => 'Expiration :&#160;',
	'regexblock-form-match' => 'Terme exact',
	'regexblock-form-account-block' => 'Interdire la création d’un nouveau compte.',
	'regexblock-form-submit' => 'Bloquer cet utilisateur',
	'regexblock-form-submit-empty' => 'Indiquez un nom d’utilisateur ou une adresse IP à bloquer.',
	'regexblock-form-submit-regex' => 'Expression régulière incorrecte.',
	'regexblock-form-submit-expiry' => 'Précisez une période d’expiration.',
	'regexblock-match-stats-record' => "$1 a bloqué « $2 » le « $3 » à « $4 », connecté depuis l'adresse « $5 »",
	'regexblock-nodata-found' => 'Aucune donnée trouvée',
	'regexblock-stats-title' => 'Statistiques des blocages par expressions régulières',
	'regexblock-unblock-success' => 'Le déblocage a réussi',
	'regexblock-unblock-log' => "L’utilisateur ou l’adresse IP '''$1''' a été débloqué.",
	'regexblock-unblock-error' => 'Erreur de déblocage de $1. L’utilisateur n’existe probablement pas.',
	'regexblock-regex-filter' => '  ou une expression rationnelle :',
	'regexblock-view-blocked' => 'Voir les blocages par :',
	'regexblock-view-all' => 'Tous',
	'regexblock-view-go' => 'Lancer',
	'regexblock-view-match' => '(terme exact)',
	'regexblock-view-regex' => '(expression régulière)',
	'regexblock-view-account' => '(création des comptes bloquée)',
	'regexblock-view-reason' => 'motif : $1',
	'regexblock-view-reason-default' => 'aucun motif indiqué',
	'regexblock-view-block-infinite' => 'blocage permanent',
	'regexblock-view-block-temporary' => 'expire le',
	'regexblock-view-block-expired' => 'EXPIRÉ le',
	'regexblock-view-block-by' => 'bloqué par',
	'regexblock-view-block-unblock' => 'débloquer',
	'regexblock-view-stats' => 'statistiques',
	'regexblock-view-empty' => 'La liste des utilisateurs et des adresses IP bloqués est vide.',
	'regexblock-view-time' => 'le $1',
	'right-regexblock' => 'Bloquer en écriture les utilisateurs sur tout les wikis de la ferme wiki',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'regexblock-form-expiry' => 'Ferrint nei:',
	'regexblock-already-blocked' => '$1 is al útsluten.',
	'regexblock-view-all' => 'Alles',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'regexblock' => 'Bloqueo Regex',
	'regexblock-already-blocked' => '$1 xa está bloqueado.',
	'regexblock-block-log' => "O nome de usuario ou o enderezo IP '''$1''' foi bloqueado.",
	'regexblock-block-success' => 'Bloqueo con éxito',
	'regexblock-currently-blocked' => 'Enderezos actualmente bloqueados:',
	'regexblock-desc' => 'Extensión usada para bloquear nomes de usuario e mais enderezos IP con expresións regulares. Contén o mecanismo de bloqueo e unha [[Special:Regexblock|páxina especial]] para engadir/xestionar bloqueos',
	'regexblock-expire-duration' => '1 hora,2 horas,4 horas,6 horas,1 día,3 días,1 semana,2 semanas,1 mes,3 meses,6 meses,1 ano,para sempre',
	'regexblock-page-title' => 'Bloqueo do nome da expresión regular',
	'regexblockstats' => 'Estatísticas do bloqueo Regex',
	'regexblock-help' => "Use o formulario de embaixo para bloquear o acceso de escritura desde un determinado enderezo IP ou nome de usuario.
Isto debería facerse só para previr vandalismo, e segundo a política e normas de bloqueo.
''Esta páxina permitiralle bloquear incluso usuarios que non existen, e usuarios con nomes semellantes ao dado, é dicir, «Test» será bloqueado xunto con «Test 2», etc. Tamén pode bloquear enderezos IP completos, no sentido de que ninguén rexistrado nos mesmos será capaz de editar páxinas. Nota: os enderezos IP parciais serán tratados polos nomes de usuarios na determinación do bloqueo. Se non se especifica a razón, será usado por defecto un motivo xenérico.''",
	'regexblock-page-title-1' => 'Bloquear un enderezo usando expresións regulares',
	'regexblock-reason-ip' => 'A este enderezo IP estalle prohibido editar debido a vandalismo ou outras actividades negativas realizadas por vostede ou por alguén que comparte o seu enderezo IP. Se pensa que se trata dun erro, $1',
	'regexblock-reason-name' => 'A este nome de usuario estalle prohibido editar debido a vandalismo ou outras actividades negativas. Se pensa que se trata dun erro, $1',
	'regexblock-reason-regex' => 'A este nome de usuario prohíbeselle editar debido a vandalismo ou outras actividades negativas por parte dun usuario cun nome semellante. Cree un nome de usuario diferente ou $1 sobre o problema',
	'regexblock-form-username' => 'Enderezo IP ou nome de usuario:',
	'regexblock-form-reason' => 'Razón:',
	'regexblock-form-expiry' => 'Remate:',
	'regexblock-form-match' => 'Procura exacta',
	'regexblock-form-account-block' => 'Bloqueada a creación de novas contas',
	'regexblock-form-submit' => 'Bloquear este usuario',
	'regexblock-form-submit-empty' => 'Dar un nome de usuario ou un enderezo IP para bloquear.',
	'regexblock-form-submit-regex' => 'Expresión regular non válida.',
	'regexblock-form-submit-expiry' => 'Especifique un período de caducidade.',
	'regexblock-match-stats-record' => '$1 bloqueou a "$2" en "$3" ás $4, rexistrado desde o enderezo "$5"',
	'regexblock-nodata-found' => 'Non se atoparon os datos',
	'regexblock-stats-title' => 'Estatíticas do bloqueo Regex',
	'regexblock-unblock-success' => 'O desbloqueo foi un éxito',
	'regexblock-unblock-log' => "O nome de usuario ou o enderezo IP '''$1''' foi desbloqueado.",
	'regexblock-unblock-error' => 'Erro desbloqueando $1. Probabelmente non existe tal usuario.',
	'regexblock-regex-filter' => '  ou o valor regex:',
	'regexblock-view-blocked' => 'Ver bloqueado por:',
	'regexblock-view-all' => 'Todo',
	'regexblock-view-go' => 'Adiante',
	'regexblock-view-match' => '(procura exacta)',
	'regexblock-view-regex' => '(coincidencia regex)',
	'regexblock-view-account' => '(bloqueo de creación de contas)',
	'regexblock-view-reason' => 'razón: $1',
	'regexblock-view-reason-default' => 'razón xenérica',
	'regexblock-view-block-infinite' => 'bloqueo permanente',
	'regexblock-view-block-temporary' => 'expira o',
	'regexblock-view-block-expired' => 'EXPIRADO o',
	'regexblock-view-block-by' => 'bloqueado por',
	'regexblock-view-block-unblock' => 'desbloquear',
	'regexblock-view-stats' => 'estatísticas',
	'regexblock-view-empty' => 'A listaxe dos nomes e enderezos bloqueados está baleira.',
	'regexblock-view-time' => 'en $1',
	'right-regexblock' => 'Bloquearlles aos usuarios a edición en todos os wikis na granxa',
);

/** Gothic
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'regexblock-form-reason' => 'Faírina',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'regexblock-form-reason' => 'Αἰτία:',
	'regexblock-stats-username' => 'Διὰ τὸ $1',
	'regexblock-view-all' => 'ἅπασαι',
	'regexblock-view-go' => 'Ἱέναι',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'regexblock-form-username' => 'Enmys IP ny ennym ymmydeyr:',
	'regexblock-form-reason' => 'Fa:',
	'regexblock-view-go' => 'Gow',
	'regexblock-view-reason' => 'fa: $1',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'regexblock-form-reason' => 'Kumu:',
	'regexblock-stats-username' => 'No $1',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'regexblock' => 'रेजएक्सब्लॉक',
	'regexblock-already-blocked' => '$1 को पहलेसे ब्लॉक किया हुआ हैं।',
	'regexblock-block-log' => "'''$1''' इस सदस्य नाम अथव आयपी एड्रेसको ब्लॉक कर दिया हैं।",
	'regexblock-block-success' => 'ब्लॉक यशस्वी',
	'regexblock-currently-blocked' => 'अभी ब्लॉक किये हुए एड्रेस:',
	'regexblock-page-title' => 'रेग्युलर एक्स्प्रेशन नाम ब्लॉक',
	'regexblockstats' => 'रेजएक्स ब्लॉक सांख्यिकी',
	'regexblock-page-title-1' => 'रेग्युलर एक्स्प्रेशनका इस्तेमाल करके एड्रेस ब्लॉक करें',
	'regexblock-form-username' => 'आइपी एड्रेस या सदस्यनाम:',
	'regexblock-form-reason' => 'कारण:',
	'regexblock-form-expiry' => 'समाप्ती:',
	'regexblock-form-match' => 'सही मैच',
	'regexblock-form-account-block' => 'नया खाता खोलने के लिये प्रतिबंधित करें',
	'regexblock-form-submit' => 'इस सदस्यको ब्लॉक करें',
	'regexblock-form-submit-empty' => 'ब्लॉक करनेके लिये एक सदस्य नाम या आइपी एड्रेस दें।',
	'regexblock-form-submit-regex' => 'गलत रेग्युलर एक्स्प्रेशन।',
	'regexblock-form-submit-expiry' => 'कृपया समाप्ति कालावधि दें।',
	'regexblock-stats-title' => 'रेजएक्स ब्लॉक सांख्यिकी',
	'regexblock-unblock-success' => 'अनब्लॉक यशस्वी',
	'regexblock-unblock-log' => "सदस्यनाम या आइपी एड्रेस '''$1''' को अनब्लॉक किया।",
	'regexblock-unblock-error' => '$1 को अनब्लॉक करनेमें समस्या।
शायद ऐसा सदस्य अस्तित्वमें नहीं।',
	'regexblock-view-blocked' => 'जिसने ब्लॉक किया उसके अनुसार सूची देखें:',
	'regexblock-view-all' => 'सभी',
	'regexblock-view-go' => 'जायें',
	'regexblock-view-match' => '(सही मैच)',
	'regexblock-view-regex' => '(रेजएक्स मैच)',
	'regexblock-view-account' => '(खाता खोलने पर ब्लॉक)',
	'regexblock-view-reason' => 'कारण: $1',
	'regexblock-view-reason-default' => 'सर्वसाधारण कारण',
	'regexblock-view-block-infinite' => 'हमेशा के लिये ब्लॉक',
	'regexblock-view-block-temporary' => 'समाप्ती',
	'regexblock-view-block-expired' => 'समाप्त हुआ, समय',
	'regexblock-view-block-by' => 'ब्लॉक कर्ता',
	'regexblock-view-block-unblock' => 'अनब्लॉक',
	'regexblock-view-stats' => '(सांख्यिकी)',
	'regexblock-view-empty' => 'ब्लॉक किये सदस्यनाम और आइपी एड्रेसोंकी सूची खाली हैं।',
	'regexblock-view-time' => '$1 पर',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'regexblock-form-reason' => 'Rason:',
	'regexblock-view-go' => 'Lakat',
);

/** Croatian (Hrvatski)
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'regexblock' => 'Blokiranje pomoću regularnih izraza',
	'regexblock-already-blocked' => '$1 je već blokiran.',
	'regexblock-block-log' => "Suradnik ili IP-adresa '''$1''' su blokirani.",
	'regexblock-block-success' => 'Blokiranje uspjelo',
	'regexblock-currently-blocked' => 'Trenutno blokirane adrese:',
	'regexblock-page-title' => 'Blokiranje pomoću regularnih izraza',
	'regexblockstats' => 'Statistika blokiranja regularnim izrazima',
	'regexblock-help' => "Rabite donju formu za blokiranje određenih IP adresa ili suradnika. TO treba činiti samo radi sprječavanja vandalizama, u skladu s pravilima.

''Ova stranica omogućava vam blokiranje suradničkih imena prema uzorku (postojećih i novih), npr. ako blokirate « Test 2», blokirat ćete i « Test » itd. Možete također blokirati IP adrese, što znači da nitko tko se prijavi s njih neće moći uređivati. Napomena: djelomične IP adrese bit će analizirane prema suradničkim imenima u određivanju trajanja bloka. Ukoliko razlog nije dan, bit će navedeno generičko objašnjenje.''",
	'regexblock-page-title-1' => 'Blokiraj adresu koristeći regularni izraz',
	'regexblock-reason-ip' => 'Ova IP adresa je blokirana (tj. nemoguće je uređivati stranice) zbog vandalizma ili nekog drugog vašeg prekršaja (ili nekog s kim dijelite IP adresu). Ukoliko mislite da je posrijedi greška, molimo $1',
	'regexblock-reason-name' => 'Ovo suradničko ime je blokirano (tj. spriječeno mu je uređivanje članaka) zbog vandalizma ili nekog drugog prekršaja. Ukoliko mislite da se radi o grešci, molimo $1',
	'regexblock-reason-regex' => 'Ovo suradničko ime je blokirano (tj. spriječeno mu je uređivanje članaka) zbog vandalizma ili nekog drugog prekršaja suradnika s istim (ili sličnem) imenom. Ukoliko mislite da se radi o grešci, molimo $1',
	'regexblock-form-username' => 'IP-adresa ili ime suradnika:',
	'regexblock-form-reason' => 'Razlog:',
	'regexblock-form-expiry' => 'Istek bloka:',
	'regexblock-form-match' => 'Točno podudaranje',
	'regexblock-form-account-block' => 'Blokiraj stvaranje novih računa',
	'regexblock-form-submit' => 'Blokiraj ovog suradnika',
	'regexblock-form-submit-empty' => 'Unesite ime suradnika ili IP-adresu za blokiranje.',
	'regexblock-form-submit-regex' => 'Pogrešan regularni izraz.',
	'regexblock-form-submit-expiry' => 'Molimo odredite razdoblje isteka.',
	'regexblock-stats-title' => 'Statistika blokiranja reg. izrazima',
	'regexblock-unblock-success' => 'Deblokiranje uspjelo',
	'regexblock-unblock-log' => "Suradnik ili IP adresa '''$1''' je deblokiran.",
	'regexblock-unblock-error' => 'Greška prilikom deblokiranja $1. Taj suradnik vjerojatno ne postoji.',
	'regexblock-view-blocked' => 'Pregled po onom tko je blokirao:',
	'regexblock-view-all' => 'Svi',
	'regexblock-view-go' => 'Kreni',
	'regexblock-view-match' => '(točno podudaranje)',
	'regexblock-view-regex' => '(podudaranje reg. izrazom)',
	'regexblock-view-account' => '(blokiranje otvaranja računa)',
	'regexblock-view-reason' => 'razlog: $1',
	'regexblock-view-reason-default' => 'uobičajeni razlog',
	'regexblock-view-block-infinite' => 'trajna blokada',
	'regexblock-view-block-temporary' => 'ističe u',
	'regexblock-view-block-expired' => 'ISTEKLO u',
	'regexblock-view-block-by' => 'blokiran od',
	'regexblock-view-block-unblock' => 'deblokiraj',
	'regexblock-view-stats' => '(statistika)',
	'regexblock-view-empty' => 'Popis blokiranih imena i adresa je prazan.',
	'regexblock-view-time' => 'u $1',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'regexblock' => 'Regularne wurazy blokować',
	'regexblock-already-blocked' => '$1 je hižo zablokowany.',
	'regexblock-block-log' => "Wužiwarske mjeno abo IP-adresa '''$1''' je so blokowało/blokowała.",
	'regexblock-block-success' => 'Blokowanje wuspěšne',
	'regexblock-currently-blocked' => 'Tuchwilu zablokowane adresy:',
	'regexblock-desc' => 'Rozšěrjenje wužiwane za blokowanje wužiwarskich mjenow a IP-adresow z regularnymi wurazami. Wobsahuje blokowanski mechanizm kaž tež [[Special:Regexblock|specialnu stronu]] za přidaće/zrjadowanje blokowanjow',
	'regexblock-expire-duration' => '1 hodźina, 2 hodźinje, 4 hodźiny, 6 hodźin, 1 dźeń, 3 dny, 1 tydźeń, 2 njedźeli, 1 měsac, 3 měsacy, 6 měsacow, 1 lěto, njeskónčny',
	'regexblock-page-title' => 'Blokowanje mjenow regularnych wurazow',
	'regexblockstats' => 'Regex Block Statistika',
	'regexblock-help' => 'Wužij formular deleka, zo by pisanski přistup ze specifiskeje adresy abo wužiwarskeho mjena blokował. To měło so jenož činić, zo by wandalizmej zadźěwało a wotpowědujo prawidłam. \'\'Tuta strona budźe će dowoleć, samo njeeksistowacych wužiwarjow blokować a budźe tež wužiwarjow z mjenom, kotrež je datemu podobne, blokować, t.r. "test" budźe so runje tak blokować kaž "test 2" atd. Móžeš dospołne OP-adresy blokować, zo by něchtó, kiž so z nich přizjewja, strony wobdźěłać móhł. Kedźbu: dźělne IP-adresy so přez wužiwarske mjeno wužiwaja, zo by blokowanje postajiło. Jeli přičina njeje podata, budźe so powšitkowna přičina wužiwać.\'\'',
	'regexblock-page-title-1' => 'Adresu z pomocu regularnych wurazow blokować',
	'regexblock-reason-ip' => 'Tuta IP-adresa so dla wandalizma abo mylenje přez tebje abo někoho druheho, kiž IP-adresu z tobu dźěli, za wobdźěłowanje zawěra. Jeli mysliš, zo to je zmylk, prošu $1',
	'regexblock-reason-name' => 'Tute wužiwarske mjeno so dla wandalizma abo druheho mylenja za wobdźěłowanje zawěra. Jerli mysliš, zo to je zmylk, prošu $1',
	'regexblock-reason-regex' => 'Tute wužiwarske mjeno so dla wandalizma abo druheho mylenja přez wužiwarja z podobnym mjenom zawěra. Prošu wutwor druhe wužiwarske mjeno abo $1 wo tutym problemje',
	'regexblock-form-username' => 'IP-adresa abo wužiwarske mjeno:',
	'regexblock-form-reason' => 'Přičina:',
	'regexblock-form-expiry' => 'Spadnjenje:',
	'regexblock-form-match' => 'Eksaktny wotpowědnik',
	'regexblock-form-account-block' => 'Wutworjenje nowych kontow blokować',
	'regexblock-form-submit' => 'Tutoho wužiwarja blokować',
	'regexblock-form-submit-empty' => 'Podaj wužiwarske mjeno abo IP-adresu za blokowanje.',
	'regexblock-form-submit-regex' => 'Njepłaćiwy regularny wuraz.',
	'regexblock-form-submit-expiry' => 'Podaj prošu periodu spadnjenja.',
	'regexblock-match-stats-record' => "$1 jo blokěrował '$2' na '$3' pola '$4' při přizjewjenju wot adresy '$5'",
	'regexblock-nodata-found' => 'Žane daty namakane',
	'regexblock-stats-title' => 'Regex Block Statistiske podaća',
	'regexblock-unblock-success' => 'Wotblokowanje wuspěšne',
	'regexblock-unblock-log' => "Wužiwarske mjeno abo IP-adresa '''$1''' wotblokowana.",
	'regexblock-unblock-error' => 'Zmylk při wotblokowanju $1. Najskerje tajki wužiwar njeje.',
	'regexblock-regex-filter' => 'abo hódnota regularneho wuraza:',
	'regexblock-view-blocked' => 'Wobhladanje zablokowane wot:',
	'regexblock-view-all' => 'Wšě',
	'regexblock-view-go' => 'Dźi',
	'regexblock-view-match' => '(eksaktny wotpowědnik)',
	'regexblock-view-regex' => '(regularny wuraz wotpowědnik)',
	'regexblock-view-account' => '(wutworjenje konta blokować)',
	'regexblock-view-reason' => 'přičina: $1',
	'regexblock-view-reason-default' => 'powšitkowna přičina',
	'regexblock-view-block-infinite' => 'trajne blokowanje',
	'regexblock-view-block-temporary' => 'spadnje',
	'regexblock-view-block-expired' => 'SPADNJENY',
	'regexblock-view-block-by' => 'zablokowany wot',
	'regexblock-view-block-unblock' => 'wotblokować',
	'regexblock-view-stats' => 'statistiske podaća',
	'regexblock-view-empty' => 'Lisćina zablokowanych mjenow a adresow je prózdna.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Wužiwarjam wobdźěłowanje na wšěch wikijach na wikijowej farmje zadźěwać',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'regexblock' => 'Blocar con regex',
	'regexblock-already-blocked' => '"$1" es ja blocate.',
	'regexblock-block-log' => "Le nomine de usator o adresse IP '''$1''' ha essite blocate.",
	'regexblock-block-success' => 'Blocada succedite',
	'regexblock-currently-blocked' => 'Adresses actualmente blocate:',
	'regexblock-desc' => 'Extension usate pro blocar le nomines e adresses IP de usatores per medio de expressiones regular. Contine e le mechanismo de blocar e un [[Special:Regexblock|pagina special]] pro adder/gerer blocadas',
	'regexblock-page-title' => 'Blocada de un nomine per expression regular',
	'regexblockstats' => 'Statisticas super blocadas per expressiones regular',
	'regexblock-help' => 'Usa le formulario in basso pro blocar le accesso a scriber ab un adresse IP o nomine de usator specific.
Isto debe facite solmente pro impedir le vandalismo, e in concordantia con le politica in vigor.
\'\'Iste pagina te permitte blocar mesmo usatores non existente, e pote equalmente blocar usatores con nomines similar al date, i.e. "Test" essera blocate insimul con "Test 2", etc.
Tu pote tamben blocar adresses IP complete, isto vole dicer que necuno connectente se de istes potera modificar paginas.
Nota: le adresses IP partial essera considerate como nomines de usator in le determination del blocada.
Si nulle motivo es specificate, un motivo generic predefenite essera usate.\'\'',
	'regexblock-page-title-1' => 'Blocar adresses per medio de expressiones regular',
	'regexblock-reason-ip' => 'Iste adresse IP es impedite de facer modificationes pro causa de vandalismo o de altere disruption per te o per alcuno altere qui usa un adresse IP in commun con te. Si tu crede que isto sia un error, per favor $1',
	'regexblock-reason-name' => 'Iste nomine de usator es impedite de facer modificationes pro causa de vandalismo o de altere disruption.
Si tu crede que isto sia un error, per favor $1',
	'regexblock-reason-regex' => 'Iste nomine de usator es impedite de facer modificationes pro causa de vandalismo o de altere disruption per un usator con un nomine similar.
Per favor crea un nomine de usator alternative o $1 a proposito de iste problema',
	'regexblock-form-username' => 'Adresse IP o nomine de usator:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Expiration:',
	'regexblock-form-match' => 'Correspondentia exacte',
	'regexblock-form-account-block' => 'Blocar le creation de nove contos',
	'regexblock-form-submit' => 'Blocar iste usator',
	'regexblock-form-submit-empty' => 'Specifica un nomine de usator o adresse IP a blocar.',
	'regexblock-form-submit-regex' => 'Expression regular invalide.',
	'regexblock-form-submit-expiry' => 'Per favor specifica un periodo de expiration.',
	'regexblock-stats-title' => 'Statisticas de blocadas per expressiones regular',
	'regexblock-unblock-success' => 'Disblocada succedite',
	'regexblock-unblock-log' => "Le nomine de usator o adresse IP '''$1''' ha essite disblocate.",
	'regexblock-unblock-error' => 'Error durante le disblocada de $1.
Probabilemente non existe tal usator.',
	'regexblock-view-blocked' => 'Vider blocadas per:',
	'regexblock-view-all' => 'Totes',
	'regexblock-view-go' => 'Ir',
	'regexblock-view-match' => '(correspondentia exacte)',
	'regexblock-view-regex' => '(correspondentia per expression regular)',
	'regexblock-view-account' => '(blocada de creation de contos)',
	'regexblock-view-reason' => 'motivo: $1',
	'regexblock-view-reason-default' => 'motivo generic',
	'regexblock-view-block-infinite' => 'blocada permanente',
	'regexblock-view-block-temporary' => 'expira le',
	'regexblock-view-block-expired' => 'EXPIRATE le',
	'regexblock-view-block-by' => 'blocate per',
	'regexblock-view-block-unblock' => 'disblocar',
	'regexblock-view-stats' => '(statisticas)',
	'regexblock-view-empty' => 'Le lista de nomines e adresses blocate es vacue.',
	'regexblock-view-time' => 'le $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'regexblock-form-reason' => 'Alasan:',
	'regexblock-view-all' => 'Semua',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'regexblock-form-reason' => 'Ástæða:',
	'regexblock-already-blocked' => '$1 er nú þegar í banni.',
	'regexblock-stats-username' => 'Fyrir $1',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Scadenza del blocco:',
	'regexblock-view-go' => 'Vai',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'regexblock' => '正規表現ブロック',
	'regexblock-desc' => '利用者名やIPアドレスを正規表現でブロックするための拡張機能。ブロック機構とブロックを追加・管理するための[[Special:Regexblock|特別ページ]]の両方を含む',
	'regexblock-special-desc' => '代替利用者ブロック (正規表現を使用)',
	'regexblock-stat-desc' => '正規表現ブロック拡張機能の[[Special:Regexblockstats|ブロック統計]]を表示する',
	'regexblock-page-title' => '正規表現による利用者名のブロック',
	'regexblockstats' => '正規表現ブロック統計',
	'regexblock-reason-ip' => 'あなたかあなたとIPアドレスを共有するだれかによる荒らしなどの破壊のため、このIPアドレスは編集が禁止されています。これが間違いだとお考えなら、$1 してください',
	'regexblock-reason-name' => 'この利用者名は荒らしなどの破壊のため編集が禁止されています。これが間違いだとお考えなら、$1 してください',
	'regexblock-reason-regex' => '類似した名前の利用者による荒らしなどの破壊のため、この利用者名は編集が禁止されています。これが間違いだとお考えなら、$1 してください',
	'regexblock-help' => '以下のフォームを使って特定のIPアドレスまたは利用者名からの書き込みアクセスをブロックします。これは荒らしを防ぐためのみになされるべきであり、方針と合致しているべきです。\'\'このページを使うとまだ存在していない利用者さえブロックすることができます。また、指定した名前に類似した利用者もブロックします。つまり、"Test" をブロックすると "Test 2" もブロックされます。また、完全なIPアドレスをブロックすることもできます。つまり、そこからログインしている誰も編集できないようにできるということです。注：部分的なIPアドレスはブロック決定過程において利用者名として処理されます。理由を指定しなかった場合は、既定の一般的な理由が使われます。\'\'',
	'regexblock-page-title-1' => '正規表現を使ってアドレスをブロックする',
	'regexblock-unblock-success' => 'ブロック解除成功',
	'regexblock-unblock-log' => "利用者名またはIPアドレス '''$1''' のブロックを解除しました。",
	'regexblock-unblock-error' => '$1 のブロック解除エラー。おそらく、その利用者は存在しません。',
	'regexblock-form-username' => 'IPアドレスまたは利用者名:',
	'regexblock-form-reason' => '理由:',
	'regexblock-form-expiry' => '期限:',
	'regexblock-form-match' => '完全一致',
	'regexblock-form-account-block' => '新規アカウントの作成をブロックする',
	'regexblock-form-submit' => 'この利用者をブロックする',
	'regexblock-already-blocked' => '$1 は既にブロックされています。',
	'regexblock-view-all' => 'すべて',
	'regexblock-view-match' => '(完全一致)',
	'regexblock-view-reason' => '理由: $1',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'regexblockstats' => 'Statistik pamblokiran regex',
	'regexblock-help' => "Nganggoa formulir ing ngisor iki kanggo mblokir aksès panulisan saka sawijining alamat IP tartamtu utawa jeneng panganggo.
Iki nanging namung kudu dilakokaké waé kanggo menggak vandalisme, lan miturut kawicaksanan sing ana.
''Nganggo kaca iki panjenengan uga bisa mblokir panganggo-panganggo sing durung ana, lan uga mblokir panganggo sing duwé jeneng mèmper karo jeneng sing wis ana. Contoné « Test » bakal diblokir karo « Test 2 » lsp.
Panjenengan uga bisa mblokir alamat-alamat IP sacara pol-polan, dadi tegesé ora ana sing bisa log mlebu saka kana lan nyunting kaca-kaca.
Cathetan: alamat IP parsial bakal dianggep miturut jeneng panganggo yèn arep diblokir.
Yèn ora ana alesan sing diwènèhaké, sawijining alesan umum baku bakal dienggo.",
	'regexblock-form-username' => 'Alamat IP utawa jeneng panganggo:',
	'regexblock-form-reason' => 'Alesan:',
	'regexblock-form-match' => 'Persis cocog',
	'regexblock-block-log' => "Panganggo utawa alamat IP '''$1''' wis diblokir.",
	'regexblock-already-blocked' => '$1 wis diblokir',
	'regexblock-stats-username' => 'Kanggo $1',
	'regexblock-stats-times' => 'wis diblokir ing',
	'regexblock-view-blocked' => 'Ndeleng diblokir déning:',
	'regexblock-view-all' => 'Kabèh',
	'regexblock-view-go' => 'Golèk',
	'regexblock-view-reason' => 'alesan: $1',
	'regexblock-view-reason-default' => 'alesan umum',
	'regexblock-view-block-infinite' => 'blokade permanèn',
	'regexblock-view-block-temporary' => 'kadaluwarsa ing',
	'regexblock-view-block-expired' => 'KADALUWARSA ing',
	'regexblock-view-block-by' => 'diblokir déning',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'regexblock-form-reason' => 'მიზეზი:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'regexblock-unblock-success' => 'បានឈប់ហាមឃាត់ដោយជោគជ័យ',
	'regexblock-unblock-log' => "ឈ្មោះអ្នកប្រើប្រាស់ ឬ អាសយដ្ឋាន IP '''$1''' បានត្រូវ​លែងរាំងខ្ទប់​។",
	'regexblock-form-username' => 'អាសយដ្ឋានIP ឬឈ្មោះអ្នកប្រើប្រាស់៖',
	'regexblock-form-reason' => 'មូលហេតុ៖',
	'regexblock-form-expiry' => 'ផុតកំណត់:',
	'regexblock-form-account-block' => 'រាំងខ្ទប់​ការបង្កើត​គណនី​ថ្មី',
	'regexblock-form-submit' => 'ហាមឃាត់អ្នកប្រើប្រាស់នេះ',
	'regexblock-block-log' => "ឈ្មោះអ្នកប្រើប្រាស់ ឬ អាសយដ្ឋាន IP '''$1''' បានត្រូវ រាំងខ្ទប់។",
	'regexblock-block-success' => 'រាំងខ្ទប់ដោយជោគជ័យ',
	'regexblock-form-submit-empty' => 'ផ្តល់ឈ្មោះអ្នកប្រើប្រាស់ឬអាសយដ្ឋានIPដើម្បីហាមឃាត់។',
	'regexblock-form-submit-expiry' => 'សូម​ធ្វើការ​បញ្ជាក់​កាលបរិច្ឆេទ​ដែល​ត្រូវ​ផុតកំណត់​។',
	'regexblock-already-blocked' => '$1ត្រូវបានហាមឃាត់រួចហើយ។',
	'regexblock-stats-username' => 'សម្រាប់ $1',
	'regexblock-stats-times' => 'បាន​ត្រូវ​រាំងខ្ទប់​នៅលើ',
	'regexblock-stats-logging' => 'ឡុកអ៊ីនចូលពី​អាសយដ្ឋាន',
	'regexblock-currently-blocked' => 'អាសយដ្ឋានដែលត្រូវបានហាមឃាត់បច្ចុប្បន្ន៖',
	'regexblock-view-blocked' => 'មើល​ការ​រាំងខ្ទប់​ដោយ:',
	'regexblock-view-all' => 'ទាំងអស់',
	'regexblock-view-go' => 'ទៅ',
	'regexblock-view-account' => '(រាំងខ្ទប់​ការបង្កើត​គណនី)',
	'regexblock-view-reason' => 'មូលហេតុ៖ $1',
	'regexblock-view-block-temporary' => 'ផុតកំណត់នៅ',
	'regexblock-view-block-expired' => 'បានផុតកំណត់នៅ',
	'regexblock-view-block-by' => 'ត្រូវបានហាមឃាត់ដោយ',
	'regexblock-view-block-unblock' => 'ឈប់ហាមឃាត់',
	'regexblock-view-empty' => 'បញ្ជីឈ្មោះអ្នកប្រើប្រាស់និងអាសយដ្ឋានIPគឺទទេ។',
	'regexblock-view-time' => 'នៅ $1',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'regexblock-view-go' => 'Go to am',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'regexblock-view-go' => 'Agto',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'regexblock-desc' => 'Määt et müjjelesch, Metmaacher  un IP-Addresse övver <i lang="en">regular expressions</i> ze sperre. Deit sperre, un hät en [[Special:Regexblock|Söndersigg]], öm de Sperre ze verwallde.',
	'regexblock-special-desc' => 'Ander Metmaacher Sperr (övver Metmaacher ier Name, met <i lang="en">regular expressions</i>)',
	'regexblock-stat-desc' => 'Zeish [[Special:Regexblockstats|Zahle fun Sperre]] för dä Zosatz <i lang="en">regexblock</i> zom Wiki.',
	'regexblock-form-reason' => 'Aanlass:',
	'regexblock-view-all' => 'All',
	'regexblock-view-go' => 'Loß Jonn!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'regexblock' => 'Begrëffer fir e Benotzer oder eng IP-Adress ze spären',
	'regexblock-already-blocked' => '$1 ass scho gespaart.',
	'regexblock-block-log' => "De Benotzer oder d'IP-Adress '''$1''' gouf gespaart.",
	'regexblock-block-success' => "D'Spär ass elo ageschalt",
	'regexblock-currently-blocked' => 'Aktuell gespaarten Adressen:',
	'regexblockstats' => 'Regex Spärstatistiken',
	'regexblock-reason-name' => 'Dëse Benotzer ass wéinst Vandalismus oder ähnlech Ursaache gespaart an däerf keng Ännerunge maachen. Wann Dir iwwerzeecht sidd datt et sech ëm ee Feeler handelt, $1',
	'regexblock-form-username' => 'IP-Adress oder Benotzer:',
	'regexblock-form-reason' => 'Grond:',
	'regexblock-form-account-block' => 'Uleeë vun neie Benotzerkonte spären',
	'regexblock-form-submit' => 'Dëse Benotzer spären',
	'regexblock-form-submit-empty' => 'Gitt e Benotzernumm oder eng IP-Adress un fir ze spären.',
	'regexblock-stats-title' => 'Regex Spärstatistik',
	'regexblock-unblock-success' => 'Spär opgehuewen',
	'regexblock-unblock-log' => "D'Spär vum Benotzer oder vun der IP-Adress '''$1'''' gouf opgehuewen.",
	'regexblock-view-blocked' => "Weis d'Späre vum:",
	'regexblock-view-all' => 'Alleguer',
	'regexblock-view-go' => 'Lass',
	'regexblock-view-reason' => 'Grond: $1',
	'regexblock-view-block-infinite' => 'permanent Spär',
	'regexblock-view-block-by' => 'gespaart vum',
	'regexblock-view-block-unblock' => 'Spär ophiewen',
	'regexblock-view-stats' => 'Statistik',
	'regexblock-view-empty' => "D'Lëscht vun de gespaarte Benotzer an IP-Adressen ass eidel.",
	'regexblock-view-time' => 'den $1',
);

/** Moksha (Мокшень)
 * @author Khazar II
 */
$messages['mdf'] = array(
	'regexblock-already-blocked' => '"$1" сёлкфоль ни',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'regexblock-form-reason' => 'Амал:',
	'regexblock-stats-username' => '$1 лан',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'regexblock-reason-ip' => 'താങ്കളോ അല്ലെങ്കില്‍ മറ്റോരോ നടത്തിയ നശീകരണ പ്രവര്‍ത്തനം മൂലം താങ്കള്‍ ഇപ്പോള്‍ ഉപയോഗിക്കുന്ന ഐപി വിലാസം തിരുത്തല്‍ നടത്തുന്നതില്‍ നിന്നു തടയപ്പെട്ടിരിക്കുന്നു.
ഇത് ഒരു പിഴവാണെന്നു താങ്കള്‍ കരുതുന്നെങ്കില്‍ ദയവായി $1',
	'regexblock-reason-name' => 'നശീകരണ പ്രവര്‍ത്തനങ്ങള്‍ മൂലം താങ്കളുടെ ഉപയോക്തൃനാമത്തെ തിരുത്തല്‍ നടത്തുന്നതില്‍ നിന്നു തടഞ്ഞിരിക്കുന്നു. ഇത് ഒരു പിഴവാണെന്നു താങ്കള്‍ കരുതുന്നെങ്കില്‍ ദയവായി $1',
	'regexblock-reason-regex' => 'ഈ ഉപയോക്തൃനാമത്തോടു സാമ്യമുള്ള ഉപയോക്താവിന്റെ നശീകരണ പ്രവര്‍ത്തനങ്ങള്‍ മൂലം ഈ ഉപയോക്തൃനാമത്തെ തിരുത്തല്‍ നടത്തുന്നതില്‍ നിന്നു തടഞ്ഞിരിക്കുന്നു. 
ഒന്നുകില്‍ പുതിയൊരു ഉപയോക്തൃനാമം ഉണ്ടാക്കുക അല്ലെങ്കില്‍ ഈ പ്രശ്നത്തെക്കുറിച്ച് $1',
	'regexblock-unblock-success' => 'സ്വതന്ത്രമാക്കല്‍ വിജയിച്ചിരിക്കുന്നു',
	'regexblock-unblock-log' => "'''$1''' എന്ന ഉപയോക്തൃനാമം അല്ലെങ്കില്‍ ഐപിവിലാസം സ്വതന്ത്രമാക്കിയിരിക്കുന്നു.",
	'regexblock-unblock-error' => '$1നെ സ്വതന്ത്രമാക്കുന്നതില്‍ പിശക്. അങ്ങനെയൊരു ഉപയോക്താവ് നിലവിലില്ലായിരിക്കും എന്നതാവും കാരണം.',
	'regexblock-form-username' => 'ഐപി വിലാസം അല്ലെങ്കില്‍ ഉപയോക്തൃനാമം:',
	'regexblock-form-reason' => 'കാരണം:',
	'regexblock-form-expiry' => 'കാലാവധി:',
	'regexblock-form-match' => 'കൃത്യമായി യോജിക്കുന്നവ',
	'regexblock-form-account-block' => 'പുതിയ അക്കൗണ്ടുകള്‍ സൃഷ്ടിക്കുന്നതു തടയുക',
	'regexblock-form-submit' => ' ഈ  ഉപയോക്താവിനെ തടയുക',
	'regexblock-block-log' => "'''$1''' എന്ന ഉപയോക്തൃനാമം അല്ലെങ്കില്‍ ഐപി വിലാസം തടയപ്പെട്ടിരിക്കുന്നു.",
	'regexblock-block-success' => 'തടയല്‍ വിജയിച്ചിരിക്കുന്നു',
	'regexblock-form-submit-empty' => 'തടയുവാന്‍ വേണ്ടിയുള്ള ഉപയോക്തൃനാമമോ ഐപി വിലാസമോ ചേര്‍ക്കുക.',
	'regexblock-form-submit-expiry' => 'ദയവായി തടയലിനു ഒരു കാലാവധി തിരഞ്ഞെടുക്കുക.',
	'regexblock-already-blocked' => '$1 ഇതിനകം തന്നെ തടയപ്പെട്ടിരിക്കുന്നു.',
	'regexblock-stats-username' => '$1നു വേണ്ടി',
	'regexblock-stats-times' => 'തടയപ്പെട്ടത്',
	'regexblock-currently-blocked' => 'നിലവില്‍ തടയപ്പെട്ട വിലാസങ്ങള്‍:',
	'regexblock-view-all' => 'എല്ലാം',
	'regexblock-view-go' => 'പോകൂ',
	'regexblock-view-match' => '(കൃത്യമായി യോജിക്കുന്നവ)',
	'regexblock-view-account' => '(അക്കൗണ്ട് സൃഷ്ടിക്കുന്നതു തടയല്‍)',
	'regexblock-view-reason' => 'കാരണം: $1',
	'regexblock-view-reason-default' => 'സാമാന്യമായ കാരണം',
	'regexblock-view-block-infinite' => 'സ്ഥിരമായ തടയല്‍',
	'regexblock-view-block-temporary' => 'കാലാവധി തീരുന്നത്',
	'regexblock-view-block-expired' => 'കാലാവധി തീരുന്നത്',
	'regexblock-view-block-by' => 'തടഞ്ഞത്',
	'regexblock-view-block-unblock' => 'സ്വതന്ത്രമാക്കുക',
	'regexblock-view-time' => '$1 ന്‌',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'regexblock' => 'रेजएक्सब्लॉक',
	'regexblock-already-blocked' => '$1 ला अगोदरच ब्लॉक केलेले आहे.',
	'regexblock-block-log' => "'''$1''' या सदस्य नाव अथव आयपी अंकपत्त्याला ब्लॉक केलेले आहे.",
	'regexblock-block-success' => 'ब्लॉक यशस्वी',
	'regexblock-currently-blocked' => 'सध्या ब्लॉक केलेले पत्ते:',
	'regexblock-desc' => 'नेहमीची एक्स्प्रेशन्स वापरून सदस्य नावे व आयपी अंकपत्ते ब्लॉक करण्यासाठीचे एक्स्टेंशन. यामध्ये ब्लॉक करणे तसेच ब्लॉकचे व्यवस्थापन करण्यासाठीचे [[Special:Regexblock|विशेष पान]], दोघांचा समावेश आहे',
	'regexblock-page-title' => 'नेहमीचे एक्स्प्रेशन नाव ब्लॉक',
	'regexblockstats' => 'रेजएक्स ब्लॉक सांख्यिकी',
	'regexblock-help' => "खालील अर्ज विशिष्ट आयपी अंकपत्ता किंवा सदस्यनाव यांना ब्लॉक करण्यासाठी वापरता येईल.
हे फक्त उत्पात रोखण्यासाठीच वापरायचे आहे, तसेच नीतीला धरून असल्याची खात्री करा.
''हे पान वापरुन तुम्हाला अस्तित्वात नसलेले सदस्य सुद्धा ब्लॉक करता येतील, तसेच दिलेल्या नावाशी साधर्म्य राखणारी सदस्य नावे सुद्धा ब्लॉक केली जातील. उदा. « Test 2 » सोबत « Test » सुद्धा ब्लॉक होईल.
तुम्ही संपूर्ण आयपी अंकपत्ता सुद्धा ब्लॉक करू शकता, यामुळे त्या अंकपत्त्यावरून प्रवेश करणार्‍या कुणालाही संपादने करता येणार नाहीत.
सूचना: ब्लॉक ठरविण्यासाठी अर्धे आयपी अंकपत्ते सदस्यनावाने वापरले जातील.
जर कारण दिले नसेल तर एक अविचर साधारण कारण लिहिले जाईल.''",
	'regexblock-page-title-1' => 'नेहमीच्या एक्स्प्रेशन्सचा वापर करुन अंकपत्ता ब्लॉक करा',
	'regexblock-reason-ip' => 'ह्या आयपी अंकपत्त्याला संपादनांपासून रोखण्यात आलेले आहे कारण तुम्ही अथवा इतर कोणीतरी या आयपी अंकपत्त्यावरून केलेला उत्पात.
जर तुमच्या मते हे चुकून झाले आहे, तर $1 करा',
	'regexblock-reason-name' => 'ह्या सदस्यनावाला उत्पात अथवा इतर कारणांमुळे संपादनांपासून रोखण्यात आलेले आहे.
तुमच्या मते हे चुकून झाले आहे, तर $1 करा',
	'regexblock-reason-regex' => 'ह्या सदस्यनावाशी साम्य असणार्‍या सदस्यनावावरून झालेला उत्पात अथवा इतर कारणांमुळे या सदस्यनावाला संपादनांपासून रोखण्यात आलेले आहे.
कृपया दुसरे सदस्यनाव तयार करा किंवा या संदेशाबद्दल विकियाशी संपर्क ($1) करा',
	'regexblock-form-username' => 'आयपी अंकपत्ता किंवा सदस्यनाव:',
	'regexblock-form-reason' => 'कारण:',
	'regexblock-form-expiry' => 'समाप्ती:',
	'regexblock-form-match' => 'तंतोतंत जुळणी',
	'regexblock-form-account-block' => 'नवीन खाते तयार करणे अवरुद्ध करा',
	'regexblock-form-submit' => 'या सदस्याला ब्लॉक करा',
	'regexblock-form-submit-empty' => 'ब्लॉक करण्यासाठी एक सदस्य नाव किंवा आयपी अंकपत्ता द्या.',
	'regexblock-form-submit-regex' => 'चुकीचे रेग्युलर एक्स्प्रेशन.',
	'regexblock-form-submit-expiry' => 'कृपया समाप्तीचा कालावधी द्या.',
	'regexblock-stats-title' => 'रेजएक्स ब्लॉक सांख्यिकी',
	'regexblock-unblock-success' => 'अनब्लॉक यशस्वी',
	'regexblock-unblock-log' => "सदस्य नाव किंवा आयपी अंकपत्ता '''$1''' अनब्लॉक केलेला आहे.",
	'regexblock-unblock-error' => '$1 ला अनब्लॉक करण्यात त्रुटी.
कदाचित असा सदस्य अस्तित्वात नाही.',
	'regexblock-view-blocked' => 'ज्याने ब्लॉक केले त्याप्रमाणे यादी पहा:',
	'regexblock-view-all' => 'सर्व',
	'regexblock-view-go' => 'चला',
	'regexblock-view-match' => '(तंतोतंत जुळणी)',
	'regexblock-view-regex' => '(रेजएक्स जुळणी)',
	'regexblock-view-account' => '(खाते तयार करणे अवरुद्ध केले)',
	'regexblock-view-reason' => 'कारण: $1',
	'regexblock-view-reason-default' => 'सर्वसाधारण कारण',
	'regexblock-view-block-infinite' => 'कायमस्वरूपी ब्लॉक',
	'regexblock-view-block-temporary' => 'समाप्ती',
	'regexblock-view-block-expired' => 'संपल्याची वेळ',
	'regexblock-view-block-by' => 'ब्लॉक कर्ता',
	'regexblock-view-block-unblock' => 'अनब्लॉक',
	'regexblock-view-stats' => '(सांख्यिकी)',
	'regexblock-view-empty' => 'ब्लॉक केलेल्या सदस्यनाव तसेच आयपी अंकपत्त्यांची यादी रिकामी आहे.',
	'regexblock-view-time' => '$1 वर',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'regexblock-already-blocked' => '"$1" diġà bblokkjat',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'regexblock-form-reason' => 'Тувталось:',
	'regexblock-form-expiry' => 'Таштомома шказо:',
	'regexblock-view-all' => 'Весе',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'regexblock-form-username' => 'IP nozo tlatequitiltilīltōcāitl:',
	'regexblock-form-reason' => 'Īxtlamatiliztli:',
	'regexblock-form-expiry' => 'Motlamia:',
	'regexblock-form-account-block' => 'Ticquīxtīz yancuīc cuentah ītlachīhualiz',
	'regexblock-form-submit' => 'Ticquīxtīz inīn tlatequitiltilīlli',
	'regexblock-view-all' => 'Mochīntīn',
	'regexblock-view-go' => 'Yāuh',
	'regexblock-view-reason' => 'īxtlamatiliztli: $1',
	'regexblock-view-block-temporary' => 'motlamīz īpan',
	'regexblock-view-stats' => '(tlapōhualli)',
	'regexblock-view-time' => 'īpan $1',
);

/** Dutch (Nederlands)
 * @author Meno25
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'regexblock' => 'RegexBlokkeren',
	'regexblock-already-blocked' => '$1 is al geblokkeerd.',
	'regexblock-block-log' => "Gebruikersnaam of IP-adres '''$1''' is geblokkeerd.",
	'regexblock-block-success' => 'Het blokkeren is gelukt',
	'regexblock-currently-blocked' => 'Op dit moment geblokkeerde IP-adressen:',
	'regexblock-desc' => 'Uitbreiding die wordt gebruikt voor het blokkeren van gebruikers en IP-adress met een reguliere expressie. Bevat zowel een blokkademechanisme als een [[Special:Regexblock|speciale pagina]] voor het toevoegen en beheren van blokkades',
	'regexblock-expire-duration' => '1 uur,2 uur,4 uur,6 uur,1 dag,3 dagen,1 week,2 weken,1 maand,3 maanden,6 maanden,1 jaar,onbepaald',
	'regexblock-page-title' => 'Namen blokkeren met reguliere uitdrukkingen',
	'regexblockstats' => 'Statistieken van regex-blokkeren',
	'regexblock-help' => "Gebruik het onderstaande formulier om schrijftoegang voor een IP-adres of gebruiker te ontzeggen. Dit hoort eigenlijk alleen te gebeuren om vandalisme te voorkomen, en dient in overeenstemming te zijn met het beleid. ''U kunt zelfs gebruikers die nog niet bestaan blokkeren. Daarnaast worden ook gebruikers met gelijkende namen geblokkeerd. \"Test\" wordt samen met \"Test 2\", enzovoort geblokkeerd. U kunt ook een IP-adres blokkeren, wat betekent dat niemand van dat IP-adres pagina's kan bewerken. Opmerking: IP-adressen worden behandeld als gebruikersnamen bij het bepalen van blokkades. Als er geen reden is opgegeven, dan wordt er een standaard reden gebruikt.''",
	'regexblock-page-title-1' => 'IP-adres blokkeren met behulp van reguliere uitdrukkingen',
	'regexblock-reason-ip' => 'Dit IP-adres is door u of door iemand met hetzelfde IP-adres geblokkeerd van bewerken door vandalisme of een andere reden. Als u gelooft dat dit een fout is, gelieve $1',
	'regexblock-reason-name' => 'Deze gebruikersnaam is geblokkeerd van bewerken door vandalisme of een andere reden. Als u gelooft dat dit een fout is, gelieve $1',
	'regexblock-reason-regex' => 'Deze gebruikersnaam is door een gebruiker met dezelfde naam geblokkeerd van bewerken door vandalisme of een andere reden. Gelieve een andere gebruikersnaam te kiezen of $1 over het probleem',
	'regexblock-form-username' => 'IP-adres of gebruikersnaam:',
	'regexblock-form-reason' => 'Reden:',
	'regexblock-form-expiry' => 'Verloopt:',
	'regexblock-form-match' => 'Voldoet precies',
	'regexblock-form-account-block' => 'Het aanmaken van nieuwe gebruikers blokkeren',
	'regexblock-form-submit' => 'Deze gebruiker blokkeren',
	'regexblock-form-submit-empty' => 'Geef een gebruikersnaam of een IP-adres om te blokkeren.',
	'regexblock-form-submit-regex' => 'Ongeldige reguliere uitdrukking.',
	'regexblock-form-submit-expiry' => 'Geef een verlooptermijn op.',
	'regexblock-match-stats-record' => '$1 blokkeerde "$2" op "$3" om "$4", werkend via IP-adres "$5"',
	'regexblock-nodata-found' => 'Er zijn geen gegevens aangetroffen',
	'regexblock-stats-title' => 'Regex-blokkeringsstatistieken',
	'regexblock-unblock-success' => 'Het deblokkeren is gelukt',
	'regexblock-unblock-log' => "Gebruikersnaam of IP-adres '''$1''' zijn gedeblokkeerd.",
	'regexblock-unblock-error' => 'Een fout bij het deblokkeren van $1. Waarschijnlijk bestaat er geen gebruiker met die naam.',
	'regexblock-regex-filter' => 'of reguliere expressiewaarde:',
	'regexblock-view-blocked' => 'Blokkades weergeven door:',
	'regexblock-view-all' => 'Alles',
	'regexblock-view-go' => 'Gaan',
	'regexblock-view-match' => '(voldoet precies)',
	'regexblock-view-regex' => '(voldoet aan regex)',
	'regexblock-view-account' => '(blokkade aanmaken gebruikers)',
	'regexblock-view-reason' => 'reden: $1',
	'regexblock-view-reason-default' => 'algemene reden',
	'regexblock-view-block-infinite' => 'permanente blokkade',
	'regexblock-view-block-temporary' => 'verloopt op',
	'regexblock-view-block-expired' => 'VERLOPEN op',
	'regexblock-view-block-by' => 'geblokkeerd door',
	'regexblock-view-block-unblock' => 'deblokkeren',
	'regexblock-view-stats' => 'statistieken',
	'regexblock-view-empty' => 'De lijst van geblokkeerde namen en IP-adressen is leeg.',
	'regexblock-view-time' => 'op $1',
	'right-regexblock' => "Rechten om te bewerken intrekken voor gebruikers in alle wiki's van een wikifarm",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'regexblock' => 'Regex-blokkering',
	'regexblock-already-blocked' => '$1 er alt blokkert.',
	'regexblock-block-log' => "Brukarnamnet eller IP-adressa '''$1''' har blitt blokkert.",
	'regexblock-block-success' => 'Blokkering lukkast',
	'regexblock-currently-blocked' => 'Noverande blokkerte adresser:',
	'regexblock-desc' => 'Utviding nytta for blokkering av brukarnamn og IP-adressar ved hjelp av regulære uttrykk. Innheld både blokkeringsmekanismen og ei [[Special:Regexblock|spesialsida]] for å leggja til og endra blokkeringar.',
	'regexblock-page-title' => 'Namneblokkering ved hjelp av regulært uttrykk',
	'regexblockstats' => 'Regex-blokkeringsstatistikk',
	'regexblock-help' => "Nytt skjemaet nedanfor for å hindra visse IP-adresser eller brukarnamn frå å endra. 
Dette bør berre bli gjort for å hindra hærverk, og i følgje med retningslinene. 
''Denne sida vil la deg òg blokkera ikkje-eksisterande brukarar, og vil òg blokkera brukarar med namn som liknar det som blir oppgjeve. Til dømes vil «Test» bli blokkert saman med «Test 2» osb. 
Du kan òg blokkera fulle IP-adresser, noko som tyder at ingen som loggar på gjennom desse kan endra sider. 
Merk: delvise IP-adresser vil bli handsama som brukarnamn under blokkering. Om ingen årsak er oppgjeven vil ein standardårsak bli nytta.''",
	'regexblock-page-title-1' => 'Blokker adressa ved hjelp av regulære uttrykk',
	'regexblock-reason-ip' => 'IP-adressa di er hindra frå å endra sider grunna hærverk eller annan forstyrring av deg eller andre som nyttar den same IP-adressa. Om du meiner at dette er ein feil, $1',
	'regexblock-reason-name' => 'Brukarnamnet ditt er hindra frå å endra sider grunna hærverk eller annan forstyrring. 
Om du meiner at dette er ein feil, $1',
	'regexblock-reason-regex' => 'Dette brukarnamnet er hindra frå å endra sider grunna hærverk eller annan forstyrring av ein brukar med liknande namn. 
Opprett eit anna brukarnamn eller $1 om problemet.',
	'regexblock-form-username' => 'IP-adressa eller brukarnamn:',
	'regexblock-form-reason' => 'Årsak:',
	'regexblock-form-expiry' => 'Opphøyrstid:',
	'regexblock-form-match' => 'Nøyaktig treff',
	'regexblock-form-account-block' => 'Blokker oppretting av nye kontoar',
	'regexblock-form-submit' => 'Blokker denne brukaren',
	'regexblock-form-submit-empty' => 'Oppgje eit brukarnamn eller ei IP-adressa til å blokkera.',
	'regexblock-form-submit-regex' => 'Ugyldig regulært uttrykk.',
	'regexblock-form-submit-expiry' => 'Oppgje ei tid for enden på blokkeringa.',
	'regexblock-stats-title' => 'Statistikk for blokkering med regulære uttrykk',
	'regexblock-unblock-success' => 'Avblokkering lukkast',
	'regexblock-unblock-log' => "Brukarnamnet eller IP-adressa '''$1''' har blitt avblokkert.",
	'regexblock-unblock-error' => 'Det oppstod ein feil under avblokkeringa av $1. 
Truleg finst det ingen brukar med dette namnet.',
	'regexblock-view-blocked' => 'Syn dei blokkerte etter:',
	'regexblock-view-all' => 'Alle',
	'regexblock-view-go' => 'Gå',
	'regexblock-view-match' => '(nøyaktig treff)',
	'regexblock-view-regex' => '(regex-treff)',
	'regexblock-view-account' => '(kontooppretting slege av)',
	'regexblock-view-reason' => 'årsak: $1',
	'regexblock-view-reason-default' => 'generisk årsak',
	'regexblock-view-block-infinite' => 'permanent blokkering',
	'regexblock-view-block-temporary' => 'endar',
	'regexblock-view-block-expired' => 'ENDA',
	'regexblock-view-block-by' => 'blokkert av',
	'regexblock-view-block-unblock' => 'avblokker',
	'regexblock-view-stats' => '(statistikk)',
	'regexblock-view-empty' => 'Lista over blokkerte namn og adresser er tom.',
	'regexblock-view-time' => '$1',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'regexblock' => 'Regex-blokkering',
	'regexblock-already-blocked' => '«$1» er allerede blokkert',
	'regexblock-block-log' => "Brukeren '''$1''' har blitt blokkert.",
	'regexblock-block-success' => 'Blokkering lyktes',
	'regexblock-currently-blocked' => 'Nåværende blokkerte adresser:',
	'regexblock-desc' => 'Utvidelse som brukes for å blokkere brukernavn og IP-adresser ved hjelp av regulære uttrykk. Inneholder både blokkeringsmekanismen og en [[Special:Regexblock|spesialside]] for å legge til og endre blokkeringer',
	'regexblock-page-title' => 'Tittelblokkering ved hjelp av regulære uttrykk',
	'regexblockstats' => 'Regex-blokkeringsstatistikk',
	'regexblock-help' => "Bruk skjemaet nedenfor for å blokkere visse IP-adresser eller brukernavn fra å redigere. Dette burde gjøres kun for å forhindre hærverk, og i følge med retningslinjene. ''Denne siden vil la deg blokkere også ikke-eksisterende brukere, og vil også blokkere brukere med navn som ligner det som blir gitt. F.eks. vil «Test» blokkeres sammen med «Test 2» osv. Du kan også blokkere fulle IP-adresser, hvilket betyr at ingen som logger på via disse kan redigere sider. Merk delvise IP-adresser vil behandles som brukernavn under blokkering. Om ingen begrunnelse oppgis vil en standardbegrunnelse bli brukt.''",
	'regexblock-page-title-1' => 'Blokker adresse ved hjelp av regulære uttrykk',
	'regexblock-reason-ip' => 'Denne IP-adressen er hindret fra å redigere på grunn av hærverk eller annen forstyrrelse av deg eller noen andre som bruker samme IP-adresse. Om du mener dette er en feil, vennligst $1',
	'regexblock-reason-name' => 'Dette brukernavnet er hindret fra å redigere på grunn av hærverk eller annen forstyrrelse. Om du mener dette er en feil, vennligst $1',
	'regexblock-reason-regex' => 'Dette brukernavnet er forhindret fra redigering på grunn av hærverk eller annen forstyrrelse av en bruker med lignende navn. Vennligst opprett et annet brukernavn eller $1 om problemet.',
	'regexblock-form-username' => 'IP-adresse eller brukernavn:',
	'regexblock-form-reason' => 'Årsak:',
	'regexblock-form-expiry' => 'Varighet:',
	'regexblock-form-match' => 'Nøyaktig treff',
	'regexblock-form-account-block' => '{{int:ipbcreateaccount}}',
	'regexblock-form-submit' => 'Blokker denne brukeren',
	'regexblock-form-submit-empty' => 'Angi et brukernavn eller en IP-adresse å blokkere.',
	'regexblock-form-submit-regex' => 'Ugyldig regulært uttrykk',
	'regexblock-form-submit-expiry' => 'Angi en utløpstid.',
	'regexblock-stats-title' => 'Statistikk for blokkering med regulære uttrykk',
	'regexblock-unblock-success' => 'Avblokkering lyktes',
	'regexblock-unblock-log' => "Brukernavnet eller IP-adressen '''$1''' er blitt avblokkert",
	'regexblock-unblock-error' => 'Feil under avblokkering av $1. Det er trolig ingen brukere med det navnet.',
	'regexblock-view-blocked' => 'Vis de blokkerte etter:',
	'regexblock-view-all' => 'Alle',
	'regexblock-view-go' => '{{int:Go}}',
	'regexblock-view-match' => '(nøyaktig treff)',
	'regexblock-view-regex' => '(regex-treff)',
	'regexblock-view-account' => '(kontooppretting slått av)',
	'regexblock-view-reason' => 'begrunnelse: $1',
	'regexblock-view-reason-default' => 'generisk grunn',
	'regexblock-view-block-infinite' => 'permanent blokkering',
	'regexblock-view-block-temporary' => 'utgår',
	'regexblock-view-block-expired' => 'UTGIKK',
	'regexblock-view-block-by' => 'blokkert av',
	'regexblock-view-block-unblock' => 'avblokker',
	'regexblock-view-stats' => '(statistikk)',
	'regexblock-view-empty' => 'listen over blokkerte navn og adresser er tom.',
	'regexblock-view-time' => '$1',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'regexblock-form-username' => 'IP Atrese goba leina la mošomiši:',
	'regexblock-form-reason' => 'Lebaka:',
	'regexblock-block-log' => "Leina la mošomiši goba IP atrese '''$1''' e thibilwe.",
	'regexblock-form-submit-empty' => 'Efa leina la mošomiši goba IP atrese go thiba.',
	'regexblock-stats-username' => 'Ya $1',
	'regexblock-stats-times' => 'e thibilwe ka',
	'regexblock-view-all' => 'Kamoka',
	'regexblock-view-go' => 'Sepela',
	'regexblock-view-reason' => 'lebaka: $1',
	'regexblock-view-block-by' => 'thibilwe ke',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'regexblock' => 'Expressions regularas per blocar un utilizaire o una IP',
	'regexblock-already-blocked' => '$1 ja es blocat.',
	'regexblock-block-log' => "L’Utilizaire o l’adreça IP '''$1''' es estat blocat.",
	'regexblock-block-success' => 'Lo blocatge a capitat',
	'regexblock-currently-blocked' => 'Adreças actualament blocadas :',
	'regexblock-desc' => "Extension utilizada per blocar d'utilizaires o d'adreças IP amb d'expressions regularas. Conten a l'encòp un mecanisme de blocatge e mai [[Special:Regexblock|una pagina]] podent apondre e gerir los blocatges",
	'regexblock-page-title' => 'Blocatge d’un nom per una expression regulara',
	'regexblockstats' => 'Estatisticas suls blocatges per expressions regularas',
	'regexblock-help' => "Utilizatz lo formulari çaijós per blocar l’accès en escritura una adreça IP o un nom d’utilizaire. Aquò deu èsser fach unicament per evitar tot vandalisme e conformadament a las règlas prescrichas sul projècte. ''Aquesta pagina vos autoriza quitament a blocar d'utilizaires pas enregistrats e permet tanben de blocar d'utilizaires que presentan de noms similars. Per exemple, « Tèst » serà blocada al meteis temps que « Tèst 2 » etc. Tanben podètz blocar d'adreças IP entièras, çò que significa que degun que trabalha pas dempuèi elas poirà pas editar de paginas. Nòta : d'adreças IP parcialas seràn consideradas coma de noms d’utilizaire al moment del blocatge. Se cap de motiu es pas indicat en comentari, un motiu per defaut serà indicat.''",
	'regexblock-page-title-1' => 'Blocatge d’una adreça utilizant una expression regulara',
	'regexblock-reason-ip' => 'Aquesta adreça IP es apartat de tota edicon per causa de vandalisme o autres faches analògs per vos o qualqu’un d’autre partejant vòstra adreça IP. Se sètz persuadit(-ida) que s’agís d’una error, $1',
	'regexblock-reason-name' => 'Aqueste utilizaire es apartat de tota edicion per causa de vandalisme o autres faches analògs. Se sètz persuadit(-ida) que s’agís d’una error, $1.',
	'regexblock-reason-regex' => "Aqueste utilizaire es apartat de tota edicion per causa de vandalisme o autres faches analògs per un utilizaire qu'a un nom similar. Creatz un autre compte o $1 per senhalar lo problèma.",
	'regexblock-form-username' => 'Adreça IP o Utilizaire :',
	'regexblock-form-reason' => 'Motiu :',
	'regexblock-form-expiry' => 'Expiracion :',
	'regexblock-form-match' => 'Tèrme exacte',
	'regexblock-form-account-block' => 'Interdire la creacion d’un compte novèl.',
	'regexblock-form-submit' => 'Blocar aqueste Utilizaire',
	'regexblock-form-submit-empty' => 'Indicatz un nom d’utilizaire o una adreça IP de blocar.',
	'regexblock-form-submit-regex' => 'Expression regulara incorrècta.',
	'regexblock-form-submit-expiry' => 'Precisatz un periòde d’expiracion.',
	'regexblock-stats-title' => 'Estatisticas dels blocatges per expressions regularas',
	'regexblock-unblock-success' => 'Lo desblocatge a capitat',
	'regexblock-unblock-log' => "L’utilizaire o l’adreça IP '''$1''' es estat desblocat.",
	'regexblock-unblock-error' => 'Error de deblocatge de $1. L’utilizaire existís probablament pas.',
	'regexblock-view-blocked' => 'Veire los blocatges per :',
	'regexblock-view-all' => 'Totes',
	'regexblock-view-go' => 'Amodar',
	'regexblock-view-match' => '(tèrme exacte)',
	'regexblock-view-regex' => '(expression regulara)',
	'regexblock-view-account' => '(creacion dels comptes blocada)',
	'regexblock-view-reason' => 'motiu : $1',
	'regexblock-view-reason-default' => 'cap de motiu indicat',
	'regexblock-view-block-infinite' => 'blocatge permanent',
	'regexblock-view-block-temporary' => 'expira lo',
	'regexblock-view-block-expired' => 'EXPIRAT lo',
	'regexblock-view-block-by' => 'blocat per',
	'regexblock-view-block-unblock' => 'desblocar',
	'regexblock-view-stats' => '(estatisticas)',
	'regexblock-view-empty' => 'La lista dels utilizaires e de las adreças IP blocats es voida.',
	'regexblock-view-time' => 'lo $1',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'regexblock-form-reason' => 'Аххос:',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'regexblock-view-all' => 'ਸਭ',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'regexblock' => 'Blokada wyrażeniem regularnym',
	'regexblock-already-blocked' => '$1 jest już zablokowany',
	'regexblock-block-log' => "Nazwa użytkownika lub adres IP '''$1''' zostały zablokowane.",
	'regexblock-block-success' => 'Pomyślnie zablokowano',
	'regexblock-currently-blocked' => 'Zablokowane adresy:',
	'regexblock-desc' => 'Rozszerzenie umożliwiające blokowanie nazw użytkowników oraz adresów IP opisanych wyrażeniami regularnymi. Zawiera mechanizm blokujący oraz [[Special:Regexblock|stronę specjalną]] dla dodawania i zarządzania blokadami',
	'regexblock-page-title' => 'Blokada wyrażeniem regularnym',
	'regexblockstats' => 'Statystyki blokad z wyrażeniami regularnymi',
	'regexblock-page-title-1' => 'Zablokuj adres, używając wyrażenia regularnego',
	'regexblock-reason-ip' => 'Ten adres IP został zablokowany z powodu wandalizmu lub innego naruszenia zasad przez Ciebie lub przez kogoś, z kim współdzielisz ten adres IP.
Jeżeli uważasz, że nastąpiła pomyłka, $1',
	'regexblock-reason-name' => 'Nazwa użytkownika została zablokowana z powodu wandalizmu lub innego naruszenia zasad.
Jeżeli uważasz, że nastąpiła pomyłka, $1',
	'regexblock-reason-regex' => 'Nazwa użytkownika została zablokowana z powodu wandalizmu lub innego naruszenia zasad, wykonanych przez użytkownika o bardzo podobnej nazwie.
Utwórz nową nazwę użytkownika lub skontaktuj się z $1 w celu rozwiązania problemu.',
	'regexblock-form-username' => 'Adres IP lub nazwa użytkownika:',
	'regexblock-form-reason' => 'Powód:',
	'regexblock-form-expiry' => 'Czas blokady:',
	'regexblock-form-match' => 'Dokładnie',
	'regexblock-form-account-block' => 'Zablokuj możliwość tworzenia nowych kont',
	'regexblock-form-submit' => 'Zablokuj użytkownika',
	'regexblock-form-submit-empty' => 'Podaj nazwę użytkownika lub adres IP do zablokowania.',
	'regexblock-form-submit-regex' => 'Nieprawidłowe wyrażenie regularne',
	'regexblock-form-submit-expiry' => 'Określ czas zakończenia blokady.',
	'regexblock-stats-title' => 'Statystyki blokad wyrażeń regularnych',
	'regexblock-unblock-success' => 'Odblokowano',
	'regexblock-unblock-log' => "Użytkownik lub adres IP '''$1''' został odblokowany.",
	'regexblock-unblock-error' => 'Błąd przy odblokowaniu $1.
Prawdopodobnie brak takiego użytkownika.',
	'regexblock-view-blocked' => 'Pokaż zablokowanych, posortowanych według',
	'regexblock-view-all' => 'Wszystkie',
	'regexblock-view-go' => 'Przejdź',
	'regexblock-view-match' => '(dokładnie)',
	'regexblock-view-regex' => '(dopasowanie wyrażenia regularnego)',
	'regexblock-view-account' => '(blokada tworzenia konta)',
	'regexblock-view-reason' => 'powód: $1',
	'regexblock-view-block-temporary' => 'upływa',
	'regexblock-view-block-expired' => 'upłynęła',
	'regexblock-view-block-by' => 'zablokowany przez',
	'regexblock-view-block-unblock' => 'odblokuj',
	'regexblock-view-stats' => '(statystyki)',
	'regexblock-view-empty' => 'Lista zablokowanych nazw i adresów jest pusta.',
	'regexblock-view-time' => '$1',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'regexblock-form-reason' => 'سبب:',
	'regexblock-form-expiry' => 'د پای نېټه:',
	'regexblock-view-all' => 'ټول',
	'regexblock-view-go' => 'ورځه',
	'regexblock-view-reason' => 'سبب: $1',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'regexblock-already-blocked' => '$1 já está bloqueada.',
	'regexblock-block-log' => "Nome de usuário ou endereço IP '''$1''' foi bloqueado.",
	'regexblock-block-success' => 'Bloqueio com sucesso',
	'regexblock-currently-blocked' => 'Endereços actualmente bloqueados:',
	'regexblock-desc' => 'Extensão usada para bloquear nomes de usuário ou endereços IP através de expressões regulares. Contém o mecanismo e uma [[Special:Regexblock|página especial]] para adicionar/gerir os bloqueios',
	'regexblock-expire-duration' => '1 hora,2 horas,4 horas,6 horas,1 dia,3 dias,1 semana,2 semanas,1 mês,3 meses,6 meses,1 ano,infinito',
	'regexblock-page-title-1' => 'Bloquear endereço utilizando expressões regulares',
	'regexblock-reason-name' => 'Este nome de usuário está impedido de editar devido a vandalismo ou outro tipo de disrupção. Se julgar tratar-se de um erro, por favor $1',
	'regexblock-form-username' => 'Endereço IP ou nome de utilizador:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-account-block' => 'Bloquear criação de novas contas',
	'regexblock-form-submit' => 'Bloquear este Utilizador',
	'regexblock-form-submit-empty' => 'Forneça um nome de usuário ou um endereço IP para bloquear.',
	'regexblock-form-submit-regex' => 'Expressão regular inválida.',
	'regexblock-form-submit-expiry' => 'Por favor, seleccione um período de expiração.',
	'regexblock-unblock-success' => 'Desbloqueio bem sucedido',
	'regexblock-unblock-log' => "O nome de utilizador ou endereço IP '''$1''' foi desbloqueado.",
	'regexblock-unblock-error' => 'Erro ao desbloquear $1. Provavelmente não existe esse usuário.',
	'regexblock-view-blocked' => 'Ver bloqueios por:',
	'regexblock-view-all' => 'Todos',
	'regexblock-view-go' => 'Ir',
	'regexblock-view-account' => '(bloqueio de criação de conta)',
	'regexblock-view-reason' => 'motivo: $1',
	'regexblock-view-reason-default' => 'motivo genérico',
	'regexblock-view-block-infinite' => 'bloqueio permanente',
	'regexblock-view-block-temporary' => 'expira em',
	'regexblock-view-block-expired' => 'EXPIRADO em',
	'regexblock-view-block-by' => 'bloqueado por',
	'regexblock-view-block-unblock' => 'desbloquear',
	'regexblock-view-stats' => 'estatísticas',
	'regexblock-view-empty' => 'Esta lista de nomes e endereços bloqueados está vazia.',
	'regexblock-view-time' => 'em $1',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'regexblock-view-all' => 'Maṛṛa',
	'regexblock-view-go' => 'Raḥ ɣa',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'regexblock-form-username' => 'Adresă IP sau nume d utilizator:',
	'regexblock-form-reason' => 'Motiv:',
	'regexblock-already-blocked' => '$1 este deja blocat.',
	'regexblock-stats-username' => 'Pentru $1',
	'regexblock-stats-times' => 'a fost blocat la',
	'regexblock-view-reason' => 'motiv: $1',
	'regexblock-view-reason-default' => 'motiv generic',
	'regexblock-view-block-temporary' => 'expiră la',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'regexblock' => 'RegexBlock',
	'regexblock-already-blocked' => '$1 уже заблокирован.',
	'regexblock-block-log' => "Имя участника или IP-адрес '''$1''' заблокирован.",
	'regexblock-block-success' => 'Блокировка выполнена успешно',
	'regexblock-currently-blocked' => 'Заблокированные сейчас адреса:',
	'regexblock-desc' => 'Расширение, использующееся для блокировки имён участников и IP-адресов с помощью регулярных выражений. Содержит механизм блокирования и [[Special:Regexblock|служебную страницу]] для добавления и управления блокировками',
	'regexblock-page-title' => 'Блокирование имени по регулярному выражению',
	'regexblockstats' => 'Статистика блокировок по регулярным выражениям',
	'regexblock-help' => "Используйте приведённую ниже форму для запрета возможности записи для определённого IP-адреса или имени участника.
Это следует делать только для предотвращения вандализма, руководствуясь правилами.
''Эта страница позволит вам заблокировать даже несуществующих участников, а также заблокирует участников с похожими именами, т. е. вместе с «Test» будет заблокирован и «Test 2» и т. д.
Вы также можете заблокировать полный IP-адрес, что означает, что его больше нельзя быдет использовать для редактирования страниц.
Замечание: частично IP-адреса будут очищены именами участников при определённых блокировках.
Если не указана причина, то будет использовано общее описание по умолчанию.''",
	'regexblock-page-title-1' => 'Блокировка адресов с помощью регулярных выражений',
	'regexblock-reason-ip' => 'Этот IP-адрес отстранён от редактирования из-за вандализма или других нарушений, которые могли совершить вы или кто-то другой, использующий такой же IP-адрес.
Если вы считаете, что это ошибка, пожалуйста, $1',
	'regexblock-reason-name' => 'Это имя участника отстранёно от редактирования из-за вандализма или других нарушений.
Если вы считаете, что это ошибка, пожалуйста, $1',
	'regexblock-reason-regex' => 'Это имя участника отстранёно от редактирования из-за вандализма или других нарушений, которые совершил участник с похожим именем.
Пожалуйста, создайте другое имя участника или $1 о проблеме',
	'regexblock-form-username' => 'IP-адрес или имя участника:',
	'regexblock-form-reason' => 'Причина:',
	'regexblock-form-expiry' => 'Истекает:',
	'regexblock-form-match' => 'Точное соответствие',
	'regexblock-form-account-block' => 'Запретить создание новых учётных записей',
	'regexblock-form-submit' => 'Заблокировать этого участника',
	'regexblock-form-submit-empty' => 'Укажите имя участника или IP-адрес для блокировки.',
	'regexblock-form-submit-regex' => 'Ошибочное регулярное выражение.',
	'regexblock-form-submit-expiry' => 'Пожалуйста, укажите время действия.',
	'regexblock-stats-title' => 'Статистика RegexBlock',
	'regexblock-unblock-success' => 'Разблокировка выполнена успешно',
	'regexblock-unblock-log' => "Имя участника или IP-адрес '''$1''' заблокирован.",
	'regexblock-unblock-error' => 'Ошибка разблокировки $1.
Возможно, такого участника не существует.',
	'regexblock-view-blocked' => 'Просмотреть заблокированных:',
	'regexblock-view-all' => 'Все',
	'regexblock-view-go' => 'Выполнить',
	'regexblock-view-match' => '(точное соответствие)',
	'regexblock-view-regex' => '(соответствие рег. выр.)',
	'regexblock-view-account' => '(запрет создания учётных записей)',
	'regexblock-view-reason' => 'причина: $1',
	'regexblock-view-reason-default' => 'общая причина',
	'regexblock-view-block-infinite' => 'бессрочная блокировка',
	'regexblock-view-block-temporary' => 'истекает',
	'regexblock-view-block-expired' => 'ИСТЕКЛА',
	'regexblock-view-block-by' => 'заблокирован',
	'regexblock-view-block-unblock' => 'разблокировать',
	'regexblock-view-stats' => '(статистика)',
	'regexblock-view-empty' => 'Список заблокированных имён и адресов пуст.',
	'regexblock-view-time' => '$1',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'regexblock-already-blocked' => '$1 è già broccaddu.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'regexblock' => 'RegexBlock',
	'regexblock-already-blocked' => '$1 je už zablokovaný.',
	'regexblock-block-log' => "Používateľské meno alebo IP adresa '''$1''' bolo zablokované.",
	'regexblock-block-success' => 'Blokovanie úspešné',
	'regexblock-currently-blocked' => 'Momentálne zablokované adresy:',
	'regexblock-desc' => 'Rozšírenie na blokovanie používateľských mien a IP adries na základe regulárnych výrazov. Obsahuje mechanizmus blokovania a [[Special:Regexblock|špeciálnu stránku]] na pridávanie a správu blokovaní',
	'regexblock-page-title' => 'Blokovanie mena na základe regulárneho výrazu',
	'regexblockstats' => 'Štatistika regex blokovaní',
	'regexblock-help' => "Použite tento formulár na zablokovanie úprav z určitej IP adresy alebo používateľského mena. Toto by sa malo využívať iba na predchádzanie vandalizmu a v súlade so zásadami blokovania. ''Táto stránka vým umožní zablokovať aj momentálne neexistujúcich používateľov a používateľov s podobnými menami ako bolo zadané, t.j. okrem « Test » bude zablokovaný aj « Test 2 » atď. Môžete tiež zablokovať celé IP adresy, čo znamená, že nikto, kto z nich pristupuje nebude môcť upravovať stránky. Pozn.: čiastočné IP adresy budú považované za používateľské mená. Ak nebude uvedený dôvod, použije sa štandardný všeobecný dôvod.''",
	'regexblock-page-title-1' => 'Zablokovať adresu na základe regulárneho výrazu',
	'regexblock-reason-ip' => 'Tejto IP adrese bolo zakázané upravovanie kvôli vandalizmu alebo inej rušivej činnosti, ktorú ste vykonával vy alebo niekto, s kým máte spoločnú vašu IP adresu. Ak veríte, že toto je omyl, prosím $1',
	'regexblock-reason-name' => 'Tomuto používateľskému menu bolo zakázané upravovanie kvôli vandalizmu alebo inej rušivej činnosti. Ak veríte, že toto je omyl, prosím $1',
	'regexblock-reason-regex' => 'Tomuto používateľskému menu bolo zakázané upravovanie kvôli vandalizmu alebo inej rušivej činnosti používateľa s podobným menom. Prosím, vytvorte si alternatívny používateľský účet alebo o probléme $1',
	'regexblock-form-username' => 'IP adresa alebo meno používateľa:',
	'regexblock-form-reason' => 'Dôvod:',
	'regexblock-form-expiry' => 'Vyprší:',
	'regexblock-form-match' => 'Presná zhoda',
	'regexblock-form-account-block' => 'Zablokovať možnosť tvorby nových účtov',
	'regexblock-form-submit' => 'Zablokovať tohto používateľa',
	'regexblock-form-submit-empty' => 'Zadajte používateľské meno alebo IP adresu, ktorá sa má zablokovať.',
	'regexblock-form-submit-regex' => 'Neplatný regulárny výraz.',
	'regexblock-form-submit-expiry' => 'Prosím zadajte, kedy má blokovanie skončiť.',
	'regexblock-stats-title' => 'Štatistiky regex blokovaní',
	'regexblock-unblock-success' => 'Odblokovanie úspešné',
	'regexblock-unblock-log' => "Používateľské meno alebo IP adresa '''$1''' bolo odblokované",
	'regexblock-unblock-error' => 'Chyba pri odblokovaní $1. Taký používateľ pravdepodobne neexistuje.',
	'regexblock-view-blocked' => 'Zobraziť blokovania od:',
	'regexblock-view-all' => 'Všetci',
	'regexblock-view-go' => 'Vykonať',
	'regexblock-view-match' => '(presná zhoda)',
	'regexblock-view-regex' => '(vyhovuje reg. výrazu)',
	'regexblock-view-account' => '(blokovanie tvorby účtov)',
	'regexblock-view-reason' => 'dôvod: $1',
	'regexblock-view-reason-default' => 'všeobecný dôvod',
	'regexblock-view-block-infinite' => 'trvalé blokovanie',
	'regexblock-view-block-temporary' => 'vyprší',
	'regexblock-view-block-expired' => 'VYPRŠALO',
	'regexblock-view-block-by' => 'zablokoval ho',
	'regexblock-view-block-unblock' => 'odblokovať',
	'regexblock-view-stats' => '(štatistiky)',
	'regexblock-view-empty' => 'Zoznam blokovaných mien a IP adries je prázdny.',
	'regexblock-view-time' => '$1',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'regexblock-form-reason' => 'Разлог:',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'regexblock-form-reason' => 'Alesan:',
	'regexblock-already-blocked' => '$1 geus dipeungpeuk.',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'regexblock' => 'Regex-blockering',
	'regexblock-already-blocked' => '"$1" är redan blockerad.',
	'regexblock-block-log' => "Användarnamnet eller IP-adressen '''$1''' har blockerats.",
	'regexblock-block-success' => 'Blockering lyckades',
	'regexblock-currently-blocked' => 'Nuvarande blockerade adresser:',
	'regexblock-desc' => 'Tillägg som används för att blockera användarnamn och IP-adresser med hjälp av reguljära uttryck. Innehåller både blockeringsmekansimen och en [[Special:Regexblock|specialsida]] för att lägga till och ändra blockeringar',
	'regexblock-page-title' => 'Blockering med hjälp av reguljära uttryck',
	'regexblockstats' => 'Regex-blockeringsstatistik',
	'regexblock-help' => 'Använd formuläret nedan för att blockera vissa IP-adresser eller användarnamn från att redigera. 
Det här borde endast göras för att förhindra vandalism, i följd med riktlinjerna.
\'\'Den här sidan låter dig även blockera ej existerande användare, och kommer också blockera användare med liknande namn. t.ex. kommer "Test" blockeras samtidigt med "Test 2" o.s.v.
Du kan också blockera fulla IP-adresser, vilket betyder att ingen som loggar in via dessa kan redigera sidor.
Notera att delvisa IP-adresser kommer behandlas som användarnamn under blockering.
Om ingen beskrivning uppges kommer en standardbeskrivning användas.\'\'',
	'regexblock-page-title-1' => 'Blockera adress med hjälp av reguljära uttryck',
	'regexblock-reason-ip' => 'Den här IP-adressen är hindrad från att redigera på grund av vandalism eller annan förstörelse av dig eller någon annan som använder samma IP-adress.
Om du menar att detta är ett fel, var god $1',
	'regexblock-reason-name' => 'Det här användarnamnet är hindrad från att redigera på grund av vandalism eller annan förstörelse.
Om du menar att detta är ett fel, var god $1',
	'regexblock-reason-regex' => 'Den här IP-adressen är hindrad från att redigera på grund av vandalism eller annan förstörelse av en användare med liknande namn. 
Var god skapa ett annat användarnamn eller $1 om problemet.',
	'regexblock-form-username' => 'IP adress eller användarnamn:',
	'regexblock-form-reason' => 'Anledning:',
	'regexblock-form-expiry' => 'Utgång:',
	'regexblock-form-match' => 'Exakt träff',
	'regexblock-form-account-block' => 'Blockera skapandet av nya konton',
	'regexblock-form-submit' => 'Blockera den här användaren',
	'regexblock-form-submit-empty' => 'Ange ett användarnamn eller en IP-adress att blockera.',
	'regexblock-form-submit-regex' => 'Ogiltigt reguljärt uttryck',
	'regexblock-form-submit-expiry' => 'Var god ange en utgångstid.',
	'regexblock-stats-title' => 'Regex-blockeringsstatistik',
	'regexblock-unblock-success' => 'Avblockering lyckades',
	'regexblock-unblock-log' => "Användarnamnet eller IP-adressen '''$1''' har avblockerats",
	'regexblock-unblock-error' => 'Fel under avblockering av $1.
Troligen så finns det ingen användare med det namnet.',
	'regexblock-view-blocked' => 'Visa de blockerade efter:',
	'regexblock-view-all' => 'Alla',
	'regexblock-view-go' => 'Gå',
	'regexblock-view-match' => '(exakt träff)',
	'regexblock-view-regex' => '(regex-träff)',
	'regexblock-view-account' => '(kontoskapande blockerat)',
	'regexblock-view-reason' => 'anledning: $1',
	'regexblock-view-reason-default' => 'generisk grund',
	'regexblock-view-block-infinite' => 'permanent blockering',
	'regexblock-view-block-temporary' => 'utgår på',
	'regexblock-view-block-expired' => 'GICK UT på',
	'regexblock-view-block-by' => 'blockerad av',
	'regexblock-view-block-unblock' => 'avblockera',
	'regexblock-view-stats' => '(statistik)',
	'regexblock-view-empty' => 'Listan över blockerade namn och adresser är tom.',
	'regexblock-view-time' => 'på $1',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'regexblock-form-reason' => 'Čymu:',
	'regexblock-form-expiry' => 'Wygaso:',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'regexblock-view-all' => 'அனைத்து',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'regexblock-already-blocked' => '$1ని ఇదివరకే నిషేధించారు.',
	'regexblock-block-log' => "'''$1''' అనే వాడుకరిపేరు లేదా ఐపీ చిరునామాని నిరోధించాం.",
	'regexblock-block-success' => 'నిరోధం విజయవంతమైంది',
	'regexblock-currently-blocked' => 'ప్రస్తుతం నిరోధంలో ఉన్న చిరునామాలు:',
	'regexblock-form-username' => 'IP చిరునామా లేదా వాడుకరి పేరు:',
	'regexblock-form-reason' => 'కారణం:',
	'regexblock-form-expiry' => 'కాలపరిమితి:',
	'regexblock-form-account-block' => 'కొత్త ఖాతాలు సృష్టించడం నిరోధించు',
	'regexblock-form-submit' => 'ఈ వాడుకరిని నిరోధించండి',
	'regexblock-form-submit-empty' => 'నిరోధించాల్సిన వాడుకరి పేరు లేదా ఐపీ చిరునామా ఇవ్వండి.',
	'regexblock-form-submit-regex' => 'తప్పుడు రెగ్యులర్ ఎక్స్&zwnj;ప్రెషన్.',
	'regexblock-form-submit-expiry' => 'దయచేసి ఓ కాలపరిమితి ఇవ్వండి.',
	'regexblock-unblock-success' => 'నిరోధపు ఎత్తివేత విజయవంతమైంది',
	'regexblock-unblock-log' => "'''$1''' అనే వాడుకరి పేరు లేదా ఐపీ చిరునామాపై నిరోధం ఎత్తివేసారు.",
	'regexblock-view-all' => 'అన్నీ',
	'regexblock-view-go' => 'వెళ్ళు',
	'regexblock-view-account' => '(ఖాతా సృష్టింపు నిరోధం)',
	'regexblock-view-reason' => 'కారణం: $1',
	'regexblock-view-reason-default' => 'సాధారణ కారణం',
	'regexblock-view-block-infinite' => 'శాశ్వత నిరోధం',
	'regexblock-view-block-temporary' => 'కాలంచెల్లు తేదీ',
	'regexblock-view-block-expired' => 'కాలంచెల్లింది',
	'regexblock-view-block-by' => 'నిరోధించినది',
	'regexblock-view-block-unblock' => 'నిరోధం ఎత్తివేయండి',
	'regexblock-view-stats' => '(గణాంకాలు)',
	'regexblock-view-empty' => 'నిరోధించిన పేర్లు మరియు చిరునామాల జాబితా ఖాళీగా ఉంది.',
	'regexblock-view-time' => '$1 నాడు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'regexblock-form-reason' => 'Motivu:',
	'regexblock-stats-username' => 'Ba $1',
	'regexblock-view-all' => 'Hotu',
	'regexblock-view-go' => 'Bá',
	'regexblock-view-reason' => 'motivu: $1',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'regexblock-already-blocked' => '"$1" аллакай баста шудааст.',
	'regexblock-block-log' => "Номи корбарӣ ё нишонаи '''$1''' баста шуд.",
	'regexblock-block-success' => 'Бастан муваффақ шуд',
	'regexblock-currently-blocked' => 'Нишонаҳои басташудаи кунунӣ:',
	'regexblock-form-username' => 'Нишонаи IP ё номи корбарӣ:',
	'regexblock-form-reason' => 'Далел:',
	'regexblock-form-match' => 'Мутобиқати дақиқ',
	'regexblock-form-account-block' => 'Эҷоди бастани ҳисобҳои ҷадид',
	'regexblock-form-submit' => 'Бастани ин Корбар',
	'regexblock-form-submit-empty' => 'Барои бастан номи корбарӣ ё нишонаи IP диҳед.',
	'regexblock-form-submit-regex' => 'Ибораи оддии номӯътабар.',
	'regexblock-form-submit-expiry' => 'Лутфан давраи ба хотимарасиро мушаххас кунед.',
	'regexblock-stats-title' => 'Омори Бастани Regex',
	'regexblock-unblock-success' => 'Боз кардан аз бастан муваффақ шуд',
	'regexblock-unblock-log' => "Номи корбарӣ ё нишонаи IP '''$1''' аз бастан боз шуд.",
	'regexblock-unblock-error' => 'Хато дар боз кардани $1.
Эҳтимолан чунин корбаре нест.',
	'regexblock-view-all' => 'Ҳама',
	'regexblock-view-go' => 'Бирав',
	'regexblock-view-match' => '(мутобиқати дақиқ)',
	'regexblock-view-account' => '(бастани эҷоди ҳисоби ҷадид)',
	'regexblock-view-reason' => 'далел: $1',
	'regexblock-view-reason-default' => 'далели умумӣ',
	'regexblock-view-block-infinite' => 'бастани доимӣ',
	'regexblock-view-block-temporary' => 'сипарӣ мешавад дар',
	'regexblock-view-block-by' => 'баста шуд тавассути',
	'regexblock-view-block-unblock' => 'боз кардан',
	'regexblock-view-stats' => '(омор)',
	'regexblock-view-empty' => 'Феҳристи номҳо ва нишонаҳои баста шуда холӣ аст.',
	'regexblock-view-time' => 'дар $1',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'regexblock-view-all' => 'ทั้งหมด',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'regexblock-already-blocked' => 'Hinadlangan na si $1.',
	'regexblock-block-log' => "Hinadlangan na ang pangalan ng tagagamit o adres ng IP na '''$1'''.",
	'regexblock-block-success' => 'Nagtagumpay ang paghadlang',
	'regexblock-expire-duration' => '1 oras,2 oras,4 na oras,6 na oras,1 araw,3 mga araw,1 linggo,2 linggo,1 buwan,3 buwan,6 na buwan,1 taon,walang hanggan',
	'regexblock-form-username' => 'Adres ng IP o pangalan ng tagagamit:',
	'regexblock-form-reason' => 'Dahilan:',
	'regexblock-form-expiry' => 'Katapusan:',
	'regexblock-form-match' => 'Tugmang-tugma',
	'regexblock-form-account-block' => 'Hadlangan ang paglikha ng bagong mga kuwenta',
	'regexblock-form-submit' => 'Hadlangan ang tagagamit na ito',
	'regexblock-form-submit-empty' => 'Magbigay ng isang pangalan ng tagagamit o isang adres ng IP na hahadlangan.',
	'regexblock-form-submit-regex' => 'Hindi tanggap na pangkaraniwang pagsasaad.',
	'regexblock-form-submit-expiry' => 'Pakitukoy ang isang panahon ng pagtatapos.',
	'regexblock-match-stats-record' => "Hinadlangan ni $1 sa '$2' noong '$3' sa '$4', lumalagda mula sa adres na '$5'",
	'regexblock-nodata-found' => 'Walang natagpuang dato',
	'regexblock-stats-title' => 'Mga estadistika ng paghadlang sa pangkaraniwang pagsasaad',
	'regexblock-unblock-success' => 'Nagtagumpay ang pagtanggal ng hadlang',
	'regexblock-unblock-log' => "Tinanggal na ang pagkakahadlang sa pangalan ng tagagamit o adres ng IP na '''$1'''.",
	'regexblock-unblock-error' => 'Kamalian sa pagtatanggal ng hadlang kay $1.
Marahal ay walang ganyang tagagamit.',
	'regexblock-regex-filter' => '  o halaga ng pangkaraniwang pagsasaad:',
	'regexblock-view-blocked' => 'Tingnan ang hinadlangan ni:',
	'regexblock-view-all' => 'Lahat',
	'regexblock-view-go' => 'Gawin na',
	'regexblock-view-match' => '(tugmang-tugma)',
	'regexblock-view-regex' => '(tugma sa pangkaraniwang pagsasaad)',
	'regexblock-view-account' => '(paghadlang sa paglikha ng kuwenta)',
	'regexblock-view-reason' => 'dahilan: $1',
	'regexblock-view-reason-default' => 'pangkalahatang dahilan',
	'regexblock-view-block-infinite' => 'pamalagiang paghadlang',
	'regexblock-view-block-temporary' => 'magtatapos sa',
	'regexblock-view-block-expired' => 'NAGTAPOS noong',
	'regexblock-view-block-by' => 'hinadlangan ni',
	'regexblock-view-block-unblock' => 'tanggalin sa pagkakahadlang',
	'regexblock-view-stats' => 'mga estadistika',
	'regexblock-view-empty' => 'Walang laman ang talaan ng hinadlangang mga pangalan at mga adres.',
	'regexblock-view-time' => 'noong $1',
);

/** Turkish (Türkçe)
 * @author Suelnur
 */
$messages['tr'] = array(
	'regexblock-form-reason' => 'Neden:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'regexblock' => 'Cấm bằng biểu thức chính quy',
	'regexblock-already-blocked' => '“$1” đã bị cấm rồi.',
	'regexblock-block-log' => "Tên người dùng hoặc địa chỉ IP '''$1''' đã bị cấm.",
	'regexblock-block-success' => 'Cấm thành công',
	'regexblock-currently-blocked' => 'Các địa chỉ hiện đang bị cấm:',
	'regexblock-desc' => 'Gói mở rộng dùng để cấm những tên người dùng và địa chỉ IP bằng biểu thức chính quy. Có cả cơ chế cấm và một [[Special:Regexblock|trang đặc biệt]] để thêm/quản lý việc cấm',
	'regexblock-page-title' => 'Cấm tên theo Biểu thức chính quy',
	'regexblockstats' => 'Thống kê cấm Regex',
	'regexblock-help' => "Hãy dùng mẫu dưới đây để cấm quyền viết bài của một địa chỉ IP hoặc tên người dùng cụ thể.
Điều này chỉ nên thực hiện để ngăn chặn phá hoại, và theo đúng với quy định.
''Trang này sẽ cho phép bạn thậm chí cấm cả những thành viên không tồn tại, và cũng sẽ cấm những thành viên có tên tương tự với tên đưa ra, nghĩa là « Test » sẽ bị cấm cùng với « Test 2 » v.v.
Bạn cũng có thể cấm các dải địa chỉ IP đầy đủ, nghĩa là không ai đăng nhập từ các IP đó có thể thực hiện sửa đổi trang.
Chú ý: các địa chỉ IP bán phần sẽ được đối xử như tên người dùng trong việc xác định cấm.
Nếu không đưa ra lý do gì, một lý do chung chung mặc định sẽ được sử dụng.''",
	'regexblock-page-title-1' => 'Cấm địa chỉ sử dụng biểu thức chính quy',
	'regexblock-reason-ip' => 'Địa chỉ IP này bị chặn không được sửa đổi do phá hoại hoặc vi phạm của bạn hoặc bởi ai đó dùng chung địa chỉ IP với bạn.
Nếu bạn tin rằng đây là nhầm lẫn, xin hãy $1',
	'regexblock-reason-name' => 'Tên người dùng này bị chặn không được sửa đổi do phá hoại hoặc hành vi vi phạm khác.
Nếu bạn tin rằng đây là nhầm lẫn, xin hãy $1',
	'regexblock-reason-regex' => 'Tên người dùng này bị chặn không được sửa đổi do phá hoại hoặc hành vi vi phạm khác của một thành viên có tên tương tự như thế này.
Xin hãy tạo một tên người dùng thay thế hoặc $1 về vấn đề này',
	'regexblock-form-username' => 'Địa chỉ IP hoặc tên người dùng:',
	'regexblock-form-reason' => 'Lý do:',
	'regexblock-form-expiry' => 'Thời hạn:',
	'regexblock-form-match' => 'Khớp chính xác',
	'regexblock-form-account-block' => 'Cấm mở tài khoản mới',
	'regexblock-form-submit' => 'Cấm người dùng này',
	'regexblock-form-submit-empty' => 'Cung cấp một tên người dùng hoặc một địa chỉ IP để cấm.',
	'regexblock-form-submit-regex' => 'Biểu thức chính quy không hợp lệ.',
	'regexblock-form-submit-expiry' => 'Xin xác định thời hạn cấm.',
	'regexblock-stats-title' => 'Thống kê cấm regex',
	'regexblock-unblock-success' => 'Bỏ cấm thành công',
	'regexblock-unblock-log' => "Tên người dùng hoặc địa chỉ IP '''$1''' đã được bỏ cấm.",
	'regexblock-unblock-error' => 'Lỗi khi bỏ cấm $1.
Có thể không có thành viên nào như vậy.',
	'regexblock-view-blocked' => 'Xem những lần cấm do:',
	'regexblock-view-all' => 'Tất cả',
	'regexblock-view-go' => 'Xem',
	'regexblock-view-match' => '(khớp chính xác)',
	'regexblock-view-regex' => '(khớp chính xác)',
	'regexblock-view-account' => '(cấm mở tài khoản)',
	'regexblock-view-reason' => 'lý do: $1',
	'regexblock-view-reason-default' => 'lý do chung chung',
	'regexblock-view-block-infinite' => 'cấm vĩnh viễn',
	'regexblock-view-block-temporary' => 'hết hạn vào',
	'regexblock-view-block-expired' => 'HẾT HẠN vào',
	'regexblock-view-block-by' => 'bị cấm bởi',
	'regexblock-view-block-unblock' => 'bỏ cấm',
	'regexblock-view-stats' => '(thống kê)',
	'regexblock-view-empty' => 'Danh sách các tên và địa chỉ bị cấm đang trống.',
	'regexblock-view-time' => 'vào $1',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'regexblock-already-blocked' => '$1 ya peblokon.',
	'regexblock-block-log' => "Gebananem/Ladet-IP: '''$1''' peblokon.",
	'regexblock-block-success' => 'Blokam eplöpon',
	'regexblock-currently-blocked' => 'Ladets-IP pebloköl:',
	'regexblock-expire-duration' => 'düp 1,düps 2,düps 4,düps 6,del 1,dels 3,vig 1,vigs 2,mul 1,muls 3,muls 6,yel 1,nenfinik',
	'regexblock-form-username' => 'Ladet-IP u gebananem:',
	'regexblock-form-reason' => 'Kod:',
	'regexblock-form-expiry' => 'Dul jü:',
	'regexblock-form-account-block' => 'Blokön jafami kalas nulik',
	'regexblock-form-submit' => 'Blokön gebani at',
	'regexblock-form-submit-empty' => 'Penolös gebananemi u ladeti-IP ad blokön.',
	'regexblock-match-stats-record' => 'Geban: $1 äblokon eli „$2“ su „$3“ tü „$4“, se ladet: „$5“',
	'regexblock-nodata-found' => 'Nünods nonik petuvons',
	'regexblock-unblock-success' => 'Säblokam eplöpon',
	'regexblock-unblock-log' => "Gebananem/Ladet-IP: '''$1''' pesäblokon.",
	'regexblock-view-all' => 'Valik',
	'regexblock-view-go' => 'Ledunön',
	'regexblock-view-reason' => 'kod: $1',
	'regexblock-view-block-infinite' => 'blokam laidüpik',
	'regexblock-view-block-temporary' => 'dulon jü',
	'regexblock-view-block-expired' => 'ÄFINIKON tü',
	'regexblock-view-block-by' => 'peblokon fa',
	'regexblock-view-block-unblock' => 'säblokön',
	'regexblock-view-stats' => 'statits',
	'regexblock-view-empty' => 'Lised gebananemas e ladetas-IP peblokölas vagon.',
	'regexblock-view-time' => 'in $1',
	'right-regexblock' => 'Blokön gebanis in vüks valik vükafarma',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'regexblock-block-success' => '封禁成功',
	'regexblock-form-username' => 'IP地址或用户名：',
	'regexblock-form-reason' => '原因：',
	'regexblock-form-expiry' => '到期日：',
	'regexblock-form-submit' => '封禁这位用户',
	'regexblock-view-stats' => '（统计）',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'regexblock-block-success' => '封禁成功',
	'regexblock-form-username' => 'IP位址或使用者名稱：',
	'regexblock-form-reason' => '原因：',
	'regexblock-form-expiry' => '到期日：',
	'regexblock-form-submit' => '封禁該名使用者',
	'regexblock-view-reason-default' => '一般原因',
	'regexblock-view-block-infinite' => '永久封禁',
	'regexblock-view-stats' => '（統計）',
);

