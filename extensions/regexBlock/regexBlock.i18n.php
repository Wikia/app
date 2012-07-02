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
	'regexblock-block-log' => "User name or IP address '''$1''' has been blocked.",
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
Note: partial IP addresses will be treated as usernames in determining blocking.
If no reason is specified, a default generic reason will be used.\'\'',
	'regexblock-page-title-1' => 'Block address using regular expressions',
	'regexblock-reason-ip' => 'This IP address is prevented from editing due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please [[$1|contact us]]',
	'regexblock-reason-name' => 'This username is prevented from editing due to vandalism or other disruption.
If you believe this is in error, please [[$1|contact us]]',
	'regexblock-reason-regex' => 'This username is prevented from editing due to vandalism or other disruption by a user with a similar name.
Please create an alternate user name or [[$1|contact us]] about the problem',
	'regexblock-form-username' => 'IP address or username:',
	'regexblock-form-reason' => 'Reason:',
	'regexblock-form-expiry' => 'Expiry:',
	'regexblock-form-match' => 'Exact match',
	'regexblock-form-account-block' => 'Block creation of new accounts',
	'regexblock-form-submit' => 'Block this user',
	'regexblock-form-submit-empty' => 'Give a user name or an IP address to block.',
	'regexblock-form-submit-regex' => 'Invalid regular expression.',
	'regexblock-form-submit-expiry' => 'Please specify an expiration period.',
	'regexblock-link' => 'block with regular expression',
	'regexblock-match-stats-record' => "$1 blocked '$2' on '$3' at '$4', logging from address '$5'",
	'regexblock-nodata-found' => 'No data found',
	'regexblock-stats-title' => 'Regex block statistics',
	'regexblock-unblock-success' => 'Unblock succeeded',
	'regexblock-unblock-log' => "User name or IP address '''$1''' has been unblocked.",
	'regexblock-unblock-error' => 'Error unblocking $1.
Probably there is no such user.',
	'regexblock-regex-filter' => ' or regex value:', // FIXME: bad i18n. Static formatting and lego
	'regexblock-view-blocked' => 'View blocked by:',
	'regexblock-view-all' => 'All',
	'regexblock-view-go' => 'Go',
	'regexblock-view-match' => '(exact match)',
	'regexblock-view-regex' => '(regex match)',
	'regexblock-view-account' => '(account creation block)',
	'regexblock-view-reason' => 'reason: $1',
	'regexblock-view-reason-default' => 'generic reason',
	'regexblock-view-block-infinite' => 'permanent block',
	'regexblock-view-block-by' => 'blocked by:',
	'regexblock-view-block-unblock' => 'unblock',
	'regexblock-view-stats' => 'stats',
	'regexblock-view-empty' => 'The list of blocked names and addresses is empty.',
	'regexblock-view-time' => 'on $1',
	'right-regexblock' => 'Block users from editing on all wikis on the wiki farm',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 * @author SPQRobin
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'regexblock-already-blocked' => '{{Identical|$1 is already blocked}}',
	'regexblock-desc' => '{{desc}}',
	'regexblock-expire-duration' => '{{Identical|Infinite}}',
	'regexblock-reason-ip' => 'Parameter $1 is <tt>$wgContactLink</tt>, which is by default "<tt>Special:Contact</tt>".',
	'regexblock-reason-name' => 'Parameter $1 is <tt>$wgContactLink</tt>, which is by default "<tt>Special:Contact</tt>".',
	'regexblock-reason-regex' => 'Parameter $1 is <tt>$wgContactLink</tt>, which is by default "<tt>Special:Contact</tt>".',
	'regexblock-form-username' => '{{Identical/IP address or username}}',
	'regexblock-form-reason' => '{{Identical|Reason}}',
	'regexblock-form-expiry' => '{{Identical|Expiry}}',
	'regexblock-form-match' => '{{Identical|Exact match}}',
	'regexblock-match-stats-record' => 'Parameters are:
* $1: regex match
* $2: username
* $3: database name
* $4: date/time
* $5: IP address
* $6: isolated date of $4
* $7: isolated time of $4',
	'regexblock-regex-filter' => 'This is a field name for a text field in a form. In the field a user is expected to type a regex filter. If a regex filter is present, the field is prefilled with it.',
	'regexblock-view-blocked' => 'This is a label followed by a dropdown list of all users who have ever used regexBlock on the wiki, allowing the viewer to filter down the list of regexBlocks, i.e. see all blocks performed by User:X if users X, Y and Z have used regexBlock tool. There is [[mw:File:RegexBlock.png|a screenshot]].',
	'regexblock-view-all' => '{{Identical|All}}',
	'regexblock-view-go' => '{{Identical|Go}}',
	'regexblock-view-match' => '{{Identical|Exact match}}',
	'regexblock-view-time' => '* $1 is a date/time
* $2 is a date (optional)
* $3 is a time (optional)',
	'right-regexblock' => '{{doc-right|regexblock}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'regexblock-form-reason' => 'Kakano:',
	'regexblock-view-go' => 'Fano',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'regexblock-already-blocked' => '$1 is reeds geblok.',
	'regexblock-expire-duration' => '1 uur,2 uur,4 uur,6 uur,1 dag,3 dae,1 week,2 weke,1 maand,3 maande,6 maande,1 jaar,onbepaald',
	'regexblock-form-username' => 'IP-adres of gebruikersnaam:',
	'regexblock-form-reason' => 'Rede:',
	'regexblock-form-expiry' => 'Verval:',
	'regexblock-form-match' => 'Presiese resultaat',
	'regexblock-form-submit' => 'Blokkeer die gebruiker',
	'regexblock-nodata-found' => 'Geen data gevind nie',
	'regexblock-view-all' => 'Alles',
	'regexblock-view-go' => 'Laat waai',
	'regexblock-view-match' => '(presiese resultaat)',
	'regexblock-view-reason' => 'rede: $1',
	'regexblock-view-reason-default' => 'algemene rede',
	'regexblock-view-block-infinite' => 'permanente blokkade',
	'regexblock-view-block-by' => 'geblokkeer deur:',
	'regexblock-view-stats' => 'statistieke',
	'regexblock-view-time' => 'op $1',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'regexblock-unblock-success' => 'Zhbllokuar sukses',
	'regexblock-unblock-log' => "''$1''Emri i përdoruesit ose IP adresa ',' është çbllokoi.",
	'regexblock-unblock-error' => 'Gabim zhbllokimin e $1. Ndoshta nuk ka përdorues të tillë.',
	'regexblock-regex-filter' => 'ose vlera regex:',
	'regexblock-view-blocked' => 'View bllokuar nga:',
	'regexblock-view-all' => 'Të gjithë',
	'regexblock-view-go' => 'Shkoj',
	'regexblock-view-match' => '(Ndeshje e saktë)',
	'regexblock-view-regex' => '(Ndeshje regex)',
	'regexblock-view-account' => '(Krijimi llogari bllok)',
	'regexblock-view-reason' => 'arsye: $1',
	'regexblock-view-reason-default' => 'arsye gjenerike',
	'regexblock-view-block-infinite' => 'bllok i përhershëm',
	'regexblock-view-block-by' => 'bllokuar nga:',
	'regexblock-view-block-unblock' => 'zhbllokuar',
	'regexblock-view-stats' => 'Statistikat',
	'regexblock-view-empty' => 'Lista e emrave të bllokuar dhe adresat është e zbrazët.',
	'regexblock-view-time' => 'në $1',
	'right-regexblock' => 'Blloko përdoruesit nga redaktimi në të gjitha wikis në fermë wiki',
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
	'regexblock-already-blocked' => '$1 ya yera bloqueyato.',
	'regexblock-form-username' => "Adreza IP u nombre d'usuario:",
	'regexblock-form-reason' => 'Razón:',
	'regexblock-view-all' => 'Todas',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'regexblock' => 'تعبير منتظم لمنع',
	'regexblock-already-blocked' => '$1 ممنوع بالفعل.',
	'regexblock-block-log' => "اسم المستخدم أو عنوان الأيبي '''$1''' تم منعه.",
	'regexblock-block-success' => 'المنع نجح',
	'regexblock-currently-blocked' => 'العناوين الممنوعة حاليا:',
	'regexblock-desc' => 'امتداد يستخدم لمنع أسماء المستخدمين وعناوين الأيبي باستخدام تعبيرات منتظمة. يحتوي على ميكانيكية المنع و [[Special:Regexblock|صفحة خاصة]] لإضافة/التحكم بعمليات المنع',
	'regexblock-expire-duration' => '1 ساعة,2 ساعة,4 ساعة,6 ساعة,1 يوم,3 يوم,1 أسبوع,2 أسبوع,1 شهر,3 شهر,6 شهر,1 سنة,لا نهائي',
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
لو أنك تعتقد أن هذا خطأ، من فضلك [[$1|اتصل بنا]]',
	'regexblock-reason-name' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى.
لو كنت تعتقد أن هذا خطأ، من فضلك [[$1|اتصل بنا]]',
	'regexblock-reason-regex' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى بواسطة مستخدم باسم مشابه.
من فضلك أنشيء اسم مستخدم بديل أو [[$1|اتصل بنا]] حول المشكلة',
	'regexblock-form-username' => 'عنوان الأيبي أو اسم المستخدم:',
	'regexblock-form-reason' => 'السبب:',
	'regexblock-form-expiry' => 'الانتهاء:',
	'regexblock-form-match' => 'تطابق تام',
	'regexblock-form-account-block' => 'منع إنشاء الحسابات الجديدة',
	'regexblock-form-submit' => 'امنع هذا المستخدم',
	'regexblock-form-submit-empty' => 'أعط اسم مستخدم أو عنوان أيبي للمنع.',
	'regexblock-form-submit-regex' => 'تعبير منتظم غير صحيح.',
	'regexblock-form-submit-expiry' => 'من فضلك حدد تاريخ انتهاء.',
	'regexblock-link' => 'منع بتعبير منتظم',
	'regexblock-match-stats-record' => "$1 منع '$2' في '$3' في '$4'، تسجيل من العنوان '$5'",
	'regexblock-nodata-found' => 'لا بيانات تم العثور عليها',
	'regexblock-stats-title' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-unblock-success' => 'رفع المنع نجح',
	'regexblock-unblock-log' => "اسم المستخدم أو عنوان الأيبي '''$1''' تم رفع المنع عنه.",
	'regexblock-unblock-error' => 'خطأ أثناء رفع المنع عن $1.
على الأرجح لا يوجد مستخدم بهذا الاسم.',
	'regexblock-regex-filter' => '  أو قيمة الريجيكس:',
	'regexblock-view-blocked' => 'عرض الممنوع بواسطة:',
	'regexblock-view-all' => 'الكل',
	'regexblock-view-go' => 'اذهب',
	'regexblock-view-match' => '(تطابق تام)',
	'regexblock-view-regex' => '(تطابق تعبير منتظم)',
	'regexblock-view-account' => '(منع إنشاء حساب)',
	'regexblock-view-reason' => 'السبب: $1',
	'regexblock-view-reason-default' => 'سبب تلقائي',
	'regexblock-view-block-infinite' => 'منع دائم',
	'regexblock-view-block-by' => 'ممنوع بواسطة:',
	'regexblock-view-block-unblock' => 'رفع المنع',
	'regexblock-view-stats' => 'إحصاءات',
	'regexblock-view-empty' => 'قائمة الأسماء والعناوين الممنوعة فارغة.',
	'regexblock-view-time' => 'في $1',
	'right-regexblock' => 'منع المستخدمين من التعديل في كل الويكيات في مزرعة الويكي',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'regexblock-form-reason' => 'ܥܠܬܐ:',
	'regexblock-view-all' => 'ܟܠ',
	'regexblock-view-go' => 'ܙܠ',
	'regexblock-view-reason' => 'ܥܠܬܐ: $1',
	'regexblock-view-block-by' => 'ܚܪܝܡܐ ܒܝܕ:',
	'regexblock-view-block-unblock' => 'ܛܥܘܢ ܚܪܡܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
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
	'regexblock-expire-duration' => '1 ساعة,2 ساعة,4 ساعة,6 ساعة,1 يوم,3 يوم,1 أسبوع,2 أسبوع,1 شهر,3 شهر,6 شهر,1 سنة,لا نهائى',
	'regexblock-page-title' => 'منع الاسم بواسطة تعبير منتظم',
	'regexblockstats' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-help' => 'استخدم الاستمارة بالأسفل لمنع التحرير من عنوان أيبى أو اسم مستخدم محدد.
هذا ينبغى أن يتم فقط لمنع التخريب، وبالتوافق مع السياسة.
\'\'هذه الصفحة ستسمح لك بمنع حتى المستخدمين غير الموجودين، وستمنع أيضا المستخدمين بأسماء مشابهة للمعطاة،أى أن "Test" سيتم منعها بالإضافة إلى "Test 2"إلى آخره.
يمكنك أيضا منع عناوين أيبى كاملة، مما يعنى أنه لا أحد مسجلا للدخول منها سيمكنه تعديل الصفحات.
ملاحظة: عناوين الأيبى الجزئية سيتم معاملتها بواسطة أسماء مستخدمين فى تحديد المنع.
لو لم يتم تحديد سبب، سيتم استخدام سبب افتراضى تلقائى.\'\'',
	'regexblock-page-title-1' => 'منع عنوان باستخدام تعبيرات منتظمة',
	'regexblock-reason-ip' => 'عنوان الأيبى هذا ممنوع نتيجة للتخريب أو إساءة أخرى بواسطتك أو بواسطة شخص يشارك فى عنوان الأيبى الخاص بك.
لو أنك تعتقد أن هذا خطأ، من فضلك [[$1|اتصل بنا]]',
	'regexblock-reason-name' => 'اسم المستخدم هذا ممنوع من التحرير نتيجة للتخريب أو إساءة أخرى.
لو كنت تعتقد أن هذا خطأ، من فضلك [[$1|اتصل بنا]]',
	'regexblock-reason-regex' => 'اسم اليوزر ده ممنوع من التحرير نتيجة للتخريب أو إساءة تانيه بواسطة يوزر بإسم مشابه.
من فضلك أنشىء اسم يوزر بديل أو [[$1|اتصل بينا]] بخصوص المشكلة',
	'regexblock-form-username' => 'عنوان الأيبى أو اسم المستخدم:',
	'regexblock-form-reason' => 'السبب:',
	'regexblock-form-expiry' => 'الانتهاء:',
	'regexblock-form-match' => 'تطابق تام',
	'regexblock-form-account-block' => 'منع إنشاء الحسابات الجديدة',
	'regexblock-form-submit' => 'منع هذا المستخدم',
	'regexblock-form-submit-empty' => 'أعط اسم مستخدم أو عنوان أيبى للمنع.',
	'regexblock-form-submit-regex' => 'تعبير منتظم غير صحيح.',
	'regexblock-form-submit-expiry' => 'من فضلك حدد تاريخ انتهاء.',
	'regexblock-match-stats-record' => "$1 منع '$2' فى '$3' فى '$4'، تسجيل من العنوان '$5'",
	'regexblock-nodata-found' => 'مافيش بيانات اتلقت',
	'regexblock-stats-title' => 'إحصاءات تعبيرات المنع المنتظمة',
	'regexblock-unblock-success' => 'رفع المنع نجح',
	'regexblock-unblock-log' => "اسم المستخدم أو عنوان الأيبى '''$1''' تم رفع المنع عنه.",
	'regexblock-unblock-error' => 'خطأ أثناء رفع المنع عن $1.
على الأرجح لا يوجد مستخدم بهذا الاسم.',
	'regexblock-regex-filter' => '   أو قيمة الريجيكس:',
	'regexblock-view-blocked' => 'عرض الممنوع بواسطة:',
	'regexblock-view-all' => 'الكل',
	'regexblock-view-go' => 'اذهب',
	'regexblock-view-match' => '(تطابق تام)',
	'regexblock-view-regex' => '(تطابق تعبير منتظم)',
	'regexblock-view-account' => '(منع إنشاء حساب)',
	'regexblock-view-reason' => 'السبب: $1',
	'regexblock-view-reason-default' => 'سبب تلقائي',
	'regexblock-view-block-infinite' => 'منع دائم',
	'regexblock-view-block-by' => 'ممنوع بواسطة:',
	'regexblock-view-block-unblock' => 'رفع المنع',
	'regexblock-view-stats' => 'ستاتس',
	'regexblock-view-empty' => 'قائمة الأسماء والعناوين الممنوعة فارغة.',
	'regexblock-view-time' => 'فى $1',
	'right-regexblock' => 'منع المستخدمين من التعديل فى كل الويكيات فى مزرعة الويكى',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'regexblock-form-reason' => 'Səbəb:',
	'regexblock-view-all' => 'Hamısı',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'regexblock-form-reason' => 'Прычына:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'regexblock' => 'Блякаваньне з дапамогай рэгулярных выразаў',
	'regexblock-already-blocked' => '$1 ужо {{GENDER:$1|заблякаваны|заблякаваная}}.',
	'regexblock-block-log' => "Рахунак {{GENDER:$1|ўдзельніка|ўдзельніцы}} альбо ІР-адрас '''$1''' заблякаваны.",
	'regexblock-block-success' => 'Пасьпяховае блякаваньне',
	'regexblock-currently-blocked' => 'Цяпер заблякаваныя адрасы:',
	'regexblock-desc' => 'З дапамогай гэтага пашырэньня блякуюцца рахункі ўдзельнікаў і ІР-адрасы па рэгулярным выразам. Утрымлівае мэханізм блякаваньня і [[Special:Regexblock|спэцыяльную старонку]] для даданьня/кіраваньня блякаваньнямі',
	'regexblock-expire-duration' => '1 гадзіна,2 гадзіны,4 гадзіны,6 гадзінаў,1 дзень,3 дні,1 тыдзень,2 тыдні,1 месяц,3 месяцы,6 месяцаў,1 год,назаўсёды',
	'regexblock-page-title' => 'Блякаваньне рахункаў з выкарыстаньнем рэгулярнага выразу',
	'regexblockstats' => 'Статыстыка блякаваньняў па рэгулярным выразам',
	'regexblock-help' => "Выкарыстоўвайце форму пададзеную ніжэй для блякаваньня рэдагаваньняў з вызначаных рахункаў альбо ІР-адрасоў.
Гэта можна рабіць толькі для прадухіленьня вандалізму і выключна згодна з правіламі.
''Гэта старонка дазволіць Вам блякаваць нават неіснуючыя рахункі і рахункі з падобнымі назвамі, напрыклад, разам з «Тэст» будзе заблякаваны і «Тэст 2» і г.д.
Таксама Вы можаце блякаваць поўныя ІР-адрасы, што азначае, што іх больш нельга будзе выкарыстоўваць для рэдагаваньня старонак.
Увага: частковая ІР-адрасы будуць інтэрпрэтавацца як назвы рахункаў у вызначаных блякаваньнях.
Калі не пазначаная прычына, будзе выкарыстоўвацца агульнае апісаньне па змоўчваньні.''",
	'regexblock-page-title-1' => 'Блякаваньне адрасоў з выкарыстаньнем рэгулярнага выразу',
	'regexblock-reason-ip' => 'Гэта ІР-адрас быў заблякаваны па прычыне вандалізму ці іншага парушэньня зробленага Вамі альбо кім-небудзь іншым, хто карыстаецца гэтым ІР-адрасам.
Калі Вы лічыце, што гэта памылка, калі ласка, [[$1|паведаміце нам]]',
	'regexblock-reason-name' => 'Гэты ўдзельнік ня можа рэдагаваць у выніку вандалізму ці іншага парушэньня.
Калі Вы лічыце, што  гэта памылка, калі ласка, [[$1|паведаміце нам]]',
	'regexblock-reason-regex' => 'Гэты ўдзельнік ня можа рэдагаваць у выніку вандалізму ці іншага парушэньня, якое зрабіў удзельнік з падобным іменем.
Калі ласка, стварыце рахунак зь іншай назвай альбо [[$1|паведаміце нам пра праблему]]',
	'regexblock-form-username' => 'ІР-адрас альбо імя ўдзельніка:',
	'regexblock-form-reason' => 'Прычына:',
	'regexblock-form-expiry' => 'Тэрмін:',
	'regexblock-form-match' => 'Дакладная адпаведнасьць',
	'regexblock-form-account-block' => 'Забараніць стварэньне новых рахункаў',
	'regexblock-form-submit' => 'Заблякаваць гэтага ўдзельніка',
	'regexblock-form-submit-empty' => 'Пазначце імя ўдзельніка альбо ІР-адрас для блякаваньня.',
	'regexblock-form-submit-regex' => 'Няслушны рэгулярны выраз.',
	'regexblock-form-submit-expiry' => 'Калі ласка, пазначце тэрмін дзеяньня.',
	'regexblock-link' => 'заблякаваць з рэгулярным выразам',
	'regexblock-match-stats-record' => '$1 заблякаваў «$2» ў «$3» «$4», увайшоўшага з IP-адрасу «$5»',
	'regexblock-nodata-found' => 'Нічога ня знойдзена',
	'regexblock-stats-title' => 'Статыстыка блякаваньняў з дапамогай рэгулярных выразаў',
	'regexblock-unblock-success' => 'Разблякаваньне пасьпяховае',
	'regexblock-unblock-log' => "Імя ўдзельніка альбо ІР-адрас '''$1''' быў разблякаваны.",
	'regexblock-unblock-error' => 'Памылка разблякаваньня $1.
Верагодна няма такога ўдзельніка.',
	'regexblock-regex-filter' => '   ці значэньне рэгулярнага выразу:',
	'regexblock-view-blocked' => 'Паказаць заблякаваных праз:',
	'regexblock-view-all' => 'Усе',
	'regexblock-view-go' => 'Паказаць',
	'regexblock-view-match' => '(дакладная адпаведнасьць)',
	'regexblock-view-regex' => '(адпаведнасьць рэгулярнаму выразу)',
	'regexblock-view-account' => '(забарона стварэньня рахункаў)',
	'regexblock-view-reason' => 'прычына: $1',
	'regexblock-view-reason-default' => 'агульная прычына',
	'regexblock-view-block-infinite' => 'бестэрміновае блякаваньне',
	'regexblock-view-block-by' => 'заблякаваны:',
	'regexblock-view-block-unblock' => 'разблякаваць',
	'regexblock-view-stats' => 'статыстыка',
	'regexblock-view-empty' => 'Сьпіс заблякаваных рахункаў і IP-адрасоў пусты.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'блякаваньне удзельнікаў ад рэдагаваньня ва ўсіх вікі гэтай вікі-фэрмы',
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
	'regexblock-view-go' => 'Отваряне',
	'regexblock-view-match' => '(пълно съвпадение)',
	'regexblock-view-reason' => 'причина: $1',
	'regexblock-view-block-infinite' => 'перманентно блокиране',
	'regexblock-view-block-by' => 'блокиран от',
	'regexblock-view-block-unblock' => 'отблокиране',
	'regexblock-view-stats' => 'статистики',
	'regexblock-view-empty' => 'Списъкът на блокирани имена и адреси е празен.',
	'regexblock-view-time' => 'на $1',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'regexblock-form-username' => 'আইপি ঠিকানা বা ব্যবহারকারীর নাম:',
	'regexblock-form-reason' => 'কারণ:',
	'regexblock-form-expiry' => 'যখন মেয়াদোত্তীর্ণ হবে:',
	'regexblock-form-account-block' => 'নতুন অ্যাকাউন্ট তৈরিতে বাধা দাও',
	'regexblock-form-submit' => 'এই ব্যবহারকারীকে বাধা দাও',
	'regexblock-form-submit-empty' => 'বাধা প্রদানের জন্য একটি ব্যবহারকারী নাম বা আইপি ঠিকানা দিন',
	'regexblock-form-submit-regex' => 'অবৈধ রেগুলার এক্সপ্রেশন',
	'regexblock-form-submit-expiry' => 'অনুগ্রহপূর্বক মেয়াদ উত্তীর্ণের সময়সীমা উল্লেখ করুন।',
	'regexblock-link' => 'রেগুলার এক্সপ্রেশনসহ বাধাদান',
	'regexblock-nodata-found' => 'কোনো ডেটা খুঁজে পাওয়া যায়নি',
	'regexblock-unblock-success' => 'সফলভাবে বাধা তুলে নেওয়া হয়েছে',
	'regexblock-view-all' => 'সমস্ত',
	'regexblock-view-go' => 'যাও',
	'regexblock-view-stats' => 'পরিসংখ্যান',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'regexblock' => 'Eztaoladennoù poellel evit stankañ',
	'regexblock-already-blocked' => '$1 zo stanket dija.',
	'regexblock-block-log' => "Sanket eo bet an implijer pe ar chomlec'h IP '''$1'''.",
	'regexblock-block-success' => 'Stanket eo bet an implijer',
	'regexblock-currently-blocked' => "Chomlec'hioù stanket er mare-mañ :",
	'regexblock-desc' => "Astenn implijet evit stankañ implijerien pe chomlec'hioù IP gant eztaoladennoù poellel. Bez ez eus war un dro ur gwikefre stankañ hag [[Special:Regexblock|ur bajenn]] hag a c'hell ouzhpennañ ha merañ ar stankadennoù",
	'regexblock-expire-duration' => '1 eurvezh, 2 eurvezh, 4 eurvezh, 6 eurvezh, 1 devezh, 3 devezh, 1 sizhunvezh, 2 sizhunvezh, miz, 3 miz, 6 miz, bloaz, da viken',
	'regexblock-page-title' => 'Stankadenn un anv gant un eztaoladenn poellel',
	'regexblockstats' => 'Stadegoù war ar stankadennoù gant eztaoladennoù poellel',
	'regexblock-help' => "Grit gant ar furmskrid a-is evit mirout ouzh ur chomlec'h IP pe un anv implijer da skrivañ.
An dra-se ne zle bezañ graet nemet evit mirout ouzh ar vandalerezh ha hervez ar reolennoù degemeret evit ar raktres.
''Gant ar bajenn-mañ e c'hallit stankañ implijerien dienroll hag ar re ganto anvioù damheñvel ouzh an anv lakaet zoken : da skouer, stanket e vo \"Test\" war un dro gant \"Test 2\" hag all.
Stankañ a c'hallit ivez chomlec'hioù IP klok, ar pezh a dalvez n'hallo ket den ebet kevreet adal ar chomlec'hioù-se kemmañ pajennoù.
Notenn : ar chomlec'hioù IP diglok a vo sellet outo evel ouzh anvioù implijerien e-pad ar stankañ. Mar ne lakaer abeg ebet en evezhiadennoù e teuio war wel un abeg dre ziouer.\"",
	'regexblock-page-title-1' => "Stankadenn ur chomlec'h hag a implij eztaoladennoù poellel",
	'regexblock-reason-ip' => "Ne c'hell ket ar c'homec'h IP-mañ degas an disterañ kemm en abeg d'ar vandalerezh pe obererezhioù damheñvel bet graet ganeoc'h pe gant unan all hag a implij ar memes chomlec'h IP.
Ma 'z oc'h sur ez eo ur fazi, [[$1|deuit e darempred ganeomp]].",
	'regexblock-reason-name' => "Ne c'hell ket an implijer-mañ degas an disterañ kemm en abeg da vandalerezh pe obererezhioù damheñvel.
Ma 'z oc'h sur ez eo ur fazi, [[$1|deuit e darempred ganeomp]].",
	'regexblock-reason-regex' => "Ne c'hell ket an implijer-mañ degas an disterañ kemm en abeg da vandalerezh pe obererezhioù damheñvel bet graet gant un implijer gant un anv karr.
krouit ur gont all pe [[$1|deuit e darempred ganeomp]] evit menegiñ ar gudenn.",
	'regexblock-form-username' => "Chomlec'h IP pe anv implijer :",
	'regexblock-form-reason' => 'Abeg :',
	'regexblock-form-expiry' => 'Termen :',
	'regexblock-form-match' => 'Klotadur rik',
	'regexblock-form-account-block' => 'Berzañ krouidigezh kontoù nevez',
	'regexblock-form-submit' => 'Stankañ an implijer-mañ',
	'regexblock-form-submit-empty' => "Roit un anv implijer pe ur chomlec'h IP da stankañ.",
	'regexblock-form-submit-regex' => 'Eztaoladenn poellel direizh.',
	'regexblock-form-submit-expiry' => 'Diferit un termen, mar plij.',
	'regexblock-link' => 'stankañ gant un eztaoladenn poellel',
	'regexblock-match-stats-record' => "$1 en deus stanket « $2 » d'an « $3 » da « $4 », liammet adalek ar chomlec'h « $5 »",
	'regexblock-nodata-found' => "N'eus ket bet kavet roadennoù",
	'regexblock-stats-title' => 'Stadegoù war ar stankadennoù gant eztaoladennoù poellel',
	'regexblock-unblock-success' => 'Distanket eo bet an implijer',
	'regexblock-unblock-log' => "Disanket eo bet an implijer pe ar chomlec'h IP '''$1'''.",
	'regexblock-unblock-error' => "Fazi distankañ $1.
Sur a-walc'h n'eus ket eus an implijer-mañ.",
	'regexblock-regex-filter' => 'pe talvoudenn un eztaoladenn poellel :',
	'regexblock-view-blocked' => 'Gwelet ar stankadurioù gant :',
	'regexblock-view-all' => 'Pep tra',
	'regexblock-view-go' => 'Mont',
	'regexblock-view-match' => '(klotadur rik)',
	'regexblock-view-regex' => '(klotadenn eztaoladenn poellel)',
	'regexblock-view-account' => "(krouidigezh ar c'hontoù stanket)",
	'regexblock-view-reason' => 'abeg : $1',
	'regexblock-view-reason-default' => 'abeg dre-vras',
	'regexblock-view-block-infinite' => 'stankadur pad',
	'regexblock-view-block-by' => 'stanket gant :',
	'regexblock-view-block-unblock' => 'distankañ',
	'regexblock-view-stats' => 'stadegoù',
	'regexblock-view-empty' => "Goullo eo roll an implijerien pe ar chomlec'hioù IP bet stanket.",
	'regexblock-view-time' => "d'an $1",
	'right-regexblock' => 'Mirout a ra ouzh an implijerien da zegas kemmoù war an holl wikioù zo er feurm wiki.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'regexblock' => 'Regex blokiranje',
	'regexblock-already-blocked' => '$1 je već blokiran.',
	'regexblock-block-log' => "Korisničko ime ili IP adresa '''$1''' je blokiran.",
	'regexblock-block-success' => 'Blokada uspješna',
	'regexblock-currently-blocked' => 'Trenutno blokirane adrese:',
	'regexblock-desc' => 'Proširenje koje se koristi za blokiranje korisničkim imena i IP adresa putem redovnih izraza. Sadrži i mehanizam za blokiranje i [[Special:Regexblock|posebnu stranicu]] za dodavanj/upravljanje blokadama',
	'regexblock-expire-duration' => '1 sat,2 sata,4 sata,6 sati,1 dan,3 dana,1 sedmica,2 sedmice,1 mjesec,3 mjeseca,6 mjeseci,1 godina,neograničeno',
	'regexblock-page-title' => 'Blokiranje imena putem redovnih izraza',
	'regexblockstats' => 'Statistike regex bloka',
	'regexblock-help' => "Koristite obrazac ispod za blokiranje prava pisanja sa određene IP adrese ili korisničkog imena.
Ovo se koristi samo za prevenciju vandalizma i u skladu sa pravilima.
''Ova stranica će Vam omogućiti da blokirate i one koji nisu korisnici a i korisnike sa sličnim imenom tj. ''Test'' će biti blokiran zajedno sa ''Test 2'' itd.
Možete također blokirati pune IP adrese, što znači da ne niko ne može s njih prijaviti za uređivanje stranica.
Pažnja: djelimična blokada IP adresa će se smatrati kao korisničko ime pri određivanju blokade.
Ako nije naveden razlog, bit će korišten uobičajeni generički razlog.''",
	'regexblock-page-title-1' => 'Blokiranje adrese koristeći obične izraze',
	'regexblock-reason-ip' => 'Ova IP adresa je onemogućena za uređivanje zbog vandalizma ili drugih sličnih akcija od strane Vas ili nekog drugog s kim dijelite Vašu IP adresu.
Ako mislite da je u pitanju greška, molimo [[$1|kontaktirajte nas]]',
	'regexblock-reason-name' => 'Ovo korisničko ime je blokirano za uređivanje zbog vandalizma ili drugih nepoželjnih radnji.
Ako mislite da je greška, molimo [[$1|kontaktirajte nas]]',
	'regexblock-reason-regex' => 'Ovo korisničko ime je onemogućeno za uređivanje zbog vandalizma i drugih radnji od strane korisnika sa sličnim imenom.
Molimo napravite drugo korisničko ime ili [[$1|nas obavijestite]] o problemu',
	'regexblock-form-username' => 'IP adresa ili korisničko ime:',
	'regexblock-form-reason' => 'Razlog:',
	'regexblock-form-expiry' => 'Ističe:',
	'regexblock-form-match' => 'Tačno slaganje',
	'regexblock-form-account-block' => 'Blokiranje pravljenja novih računa',
	'regexblock-form-submit' => 'Blokiraj ovog korisnika',
	'regexblock-form-submit-empty' => 'Navedite korisničko ime ili IP adresu za blokiranje.',
	'regexblock-form-submit-regex' => 'Nevaljan regularni izraz.',
	'regexblock-form-submit-expiry' => 'Molimo odredite vrijeme isteka.',
	'regexblock-link' => 'blokiranje sa regularnim izrazom',
	'regexblock-match-stats-record' => "$1 blokiran korisnik '$2' na '$3' u '$4', zapisnik sa adrese '$5'",
	'regexblock-nodata-found' => 'Podaci nisu nađeni',
	'regexblock-stats-title' => 'Statistike blokade putem regexa',
	'regexblock-unblock-success' => 'Deblokiranje uspjelo',
	'regexblock-unblock-log' => "Korisničko ime ili IP adresa '''$1''' je deblokiran.",
	'regexblock-unblock-error' => 'Greška pri deblokadi $1.
Moguće da ne postoji takav korisnik.',
	'regexblock-regex-filter' => '  ili regex vrijednost:',
	'regexblock-view-blocked' => 'Pregled blokiran od strane:',
	'regexblock-view-all' => 'Sve',
	'regexblock-view-go' => 'Idi',
	'regexblock-view-match' => '(tačno slaganje)',
	'regexblock-view-regex' => '(slaganje regexa)',
	'regexblock-view-account' => '(blokiranje pravljenja računa)',
	'regexblock-view-reason' => 'razlog: $1',
	'regexblock-view-reason-default' => 'opći razlog',
	'regexblock-view-block-infinite' => 'trajna blokada',
	'regexblock-view-block-by' => 'blokirano od strane:',
	'regexblock-view-block-unblock' => 'deblokada',
	'regexblock-view-stats' => 'statistike',
	'regexblock-view-empty' => 'Spisak blokiranih imena i adresa je prazan.',
	'regexblock-view-time' => 'u $1',
	'right-regexblock' => 'Blokiranje korisnika od uređivanja na svim wikijima na wiki farmi',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'regexblock-already-blocked' => '$1 ja està blocat.',
	'regexblock-form-reason' => 'Motiu:',
	'regexblock-view-go' => 'Vés-hi',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'regexblock-form-reason' => 'Бахьан:',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'regexblock-view-go' => 'Hånao',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'regexblock-form-reason' => 'هۆکار:',
	'regexblock-view-go' => 'بڕۆ',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'regexblock-form-username' => 'IP adresa nebo uživatelské jméno:',
	'regexblock-form-reason' => 'Důvod:',
	'regexblock-form-expiry' => 'Čas vypršení:',
	'regexblock-view-all' => 'Všechny',
	'regexblock-view-go' => 'Jít na',
	'regexblock-view-match' => '(přesná shoda)',
	'regexblock-view-reason' => 'důvod: $1',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'regexblock-form-username' => 'IP число или по́льꙃєватєлꙗ и́мѧ :',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'regexblock-view-all' => 'Oll',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'regexblock-form-reason' => 'Begrundelse:',
	'regexblock-view-blocked' => 'Vis blokerede af:',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Church of emacs
 * @author Imre
 * @author Melancholie
 * @author Purodha
 * @author Revolus
 * @author SVG
 * @author Umherirrender
 */
$messages['de'] = array(
	'regexblock' => 'Regex-Sperre',
	'regexblock-already-blocked' => '$1 ist bereits gesperrt.',
	'regexblock-block-log' => "Benutzername oder IP-Adresse '''$1''' wurde gesperrt.",
	'regexblock-block-success' => 'Sperrung erfolgreich',
	'regexblock-currently-blocked' => 'Derzeit gesperrte Adressen:',
	'regexblock-desc' => 'Erweiterung zum Sperren von Benutzernamen und IP-Adressen mit regulären Ausdrücken. Enthält den Sperrmechanismus und eine [[Special:Regexblock|Spezialseite]] um Sperren hinzuzufügen und zu verwalten',
	'regexblock-expire-duration' => '1 hour,2 hours,4 hours,6 hours,1 day,3 days,1 week,2 weeks,1 month,3 months,6 months,1 year,infinite',
	'regexblock-page-title' => 'Namenssperre mit regulären Ausdrücken',
	'regexblockstats' => 'Regex-Sperrstatistiken',
	'regexblock-help' => "Verwende das folgende Formular um eine IP-Adresse oder einen angemeldeten Benutzer zu sperren.
Diese Funktion sollte nur zur Verhinderung von Vandalismus und gemäß der Richtlinien eingesetzt werden.
''Diese Seite erlaubt es auch nicht existierende Benutzerkonten zu sperren, sowie solche, die ähnliche Namen zu bestehenden Konten haben, zum Beispiel eine Sperre von „Test” sperrt auch „Test 2“ usw.
Du kannst auch ganze IP-Adressen sperren, so dass niemand der sich unter diesen IP-Adressen anmeldet, Seiten bearbeiten kann.
Achtung: Teile von IP-Adressen werden als Benutzernamen beim Sperren aufgefasst.
Falls kein Sperrgrund angegeben ist, wird eine Standard-Begründung verwendet.''",
	'regexblock-page-title-1' => 'Sperre Adressen anhand regulärer Ausdrücke',
	'regexblock-reason-ip' => 'Dieser IP-Adresse ist es verboten, Seiten zu bearbeiten, da von dieser IP-Adresse – von dir oder jemandem mit derselben IP-Adresse – Vandalismus oder schädliches Verhalten ausging.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[$1|nimm bitte Kontakt mit uns auf]].',
	'regexblock-reason-name' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem verhalten, verboten, Seiten zu bearbeiten.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[$1|nimm bitte Kontakt mit uns auf]].',
	'regexblock-reason-regex' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem Verhalten eines Benutzers mit einem ähnliches Benutzernamen, verboten, Seiten zu bearbeiten.
Bitte melde dich mit einem anderen Benutzernamen an oder [[$1|nimm Kontakt mit uns auf]].',
	'regexblock-form-username' => 'IP-Adresse oder Benutzername:',
	'regexblock-form-reason' => 'Grund:',
	'regexblock-form-expiry' => 'Ablaufdatum:',
	'regexblock-form-match' => 'Genauer Treffer',
	'regexblock-form-account-block' => 'Sperre die Erstellung neuer Accounts',
	'regexblock-form-submit' => 'Sperre diesen Benutzer',
	'regexblock-form-submit-empty' => 'Einen Benutzernamen oder eine IP-Adresse für die Sperrung angeben.',
	'regexblock-form-submit-regex' => 'Ungültiger regulärer Ausdruck.',
	'regexblock-form-submit-expiry' => 'Bitte wähle einen Ablaufzeitraum.',
	'regexblock-link' => 'mit regulärem Ausdruck sperren',
	'regexblock-match-stats-record' => '$1 sperrte „$2“ auf „$3“ am $6 um $7 Uhr, angemeldet von Adresse „$5“',
	'regexblock-nodata-found' => 'Keine Daten gefunden',
	'regexblock-stats-title' => 'Regex-Sperrstatistiken',
	'regexblock-unblock-success' => 'Entsperrung erfolgreich',
	'regexblock-unblock-log' => "Benutzername oder IP-Adresse '''$1''' wurde entsperrt.",
	'regexblock-unblock-error' => 'Fehler beim Entsperren von $1.
Vermutlich gibt es keinen solchen Benutzer.',
	'regexblock-regex-filter' => '  oder regulärer Ausdruck:',
	'regexblock-view-blocked' => 'Ansicht gesperrt von:',
	'regexblock-view-all' => 'Alle',
	'regexblock-view-go' => 'Los',
	'regexblock-view-match' => '(genauer Treffer)',
	'regexblock-view-regex' => '(Regex-Treffer)',
	'regexblock-view-account' => '(Accounterstellung gesperrt)',
	'regexblock-view-reason' => 'Grund: $1',
	'regexblock-view-reason-default' => 'allgemeiner Grund',
	'regexblock-view-block-infinite' => 'permanente Sperrung',
	'regexblock-view-block-by' => 'gesperrt von:',
	'regexblock-view-block-unblock' => 'entsperren',
	'regexblock-view-stats' => 'Statistiken',
	'regexblock-view-empty' => 'Die Liste der gesperrten Namen und Adressen ist leer.',
	'regexblock-view-time' => 'am $2, $3 Uhr',
	'right-regexblock' => 'Benutzer auf allen Wikis der Wiki-Farm sperren',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Revolus
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'regexblock-help' => "Verwenden Sie das folgende Formular um eine IP-Adresse oder einen angemeldeten Benutzer zu sperren.
Diese Funktion sollte nur zur Verhinderung von Vandalismus und gemäß der Richtlinien eingesetzt werden.
''Diese Seite erlaubt es auch nicht existierende Benutzerkonten zu sperren, sowie solche, die ähnliche Namen zu bestehenden Konten haben, zum Beispiel eine Sperre von „Test” sperrt auch „Test 2“ usw.
Sie können auch ganze IP-Adressen sperren, so dass niemand der sich unter diesen IP-Adressen anmeldet, Seiten bearbeiten kann.
Achtung: Teile von IP-Adressen werden als Benutzernamen beim Sperren aufgefasst.
Falls kein Sperrgrund angegeben ist, wird eine Standard-Begründung verwendet.''",
	'regexblock-reason-ip' => 'Dieser IP-Adresse ist es verboten zu, Seiten zu bearbeiten, da von dieser IP-Adresse – von Ihnen oder jemandem mit derselben IP-Adresse – Vandalismus oder schädliches Verhalten ausging.
Wenn Sie denken, dass es sich hierbei um einen Fehler handelt, [[$1|nehmen Sie bitte Kontakt mit uns auf]].',
	'regexblock-reason-name' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem Verhalten, verboten, Seiten zu bearbeiten.
Wenn Sie denken, dass es sich hierbei um einen Fehler handelt, [[$1|nehmen Sie bitte Kontakt mit uns auf]].',
	'regexblock-reason-regex' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem schändlichem Verhalten eines Benutzers mit einem ähnliches Benutzernamen, verboten, Seiten zu bearbeiten.
Bitte melden Sie sich mit einem anderen Benutzernamen an oder [[$1|nehmen Sie Kontakt mit uns auf]].',
	'regexblock-form-submit-expiry' => 'Bitte wählen Sie einen Ablaufzeitraum.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'regexblock' => 'Blokěrowanje pśez regularne wuraze',
	'regexblock-already-blocked' => '$1 jo južo blokěrowany.',
	'regexblock-block-log' => "Wužywarske mě abo IP-adresa '''$1''' jo se blokěrowało.",
	'regexblock-block-success' => 'Blokěrowanje wuspěšne',
	'regexblock-currently-blocked' => 'Tuchylu blokěrowane adrese:',
	'regexblock-desc' => 'Rozšyrjenje za blokěrowanje wužywarskich mjenjow a IP-adresow pśez regularne wuraze. Wopśimujo ako blokěrowański mechanizm tak teke [[Special:Regexblock|specialny bok]] za pśidanje/zastojanje blokěrowanjow',
	'regexblock-expire-duration' => '1 góźina,2 góźinje,4 góźiny,6 góźinow,1 źeń,3 dny,1 tyźeń,2 tyźenja,1 mjasec,3 mjasece,6 mjasecow,1 lěto,njewěsty',
	'regexblock-page-title' => 'Blokěrowanje mjenjow pśez regularne wuraze',
	'regexblockstats' => 'Statistika blokěrowanjow pśez regularne wuraze',
	'regexblock-help' => 'Wužyj slědujucy formular, aby blokěrował pisański pśistup za IP-adresu abo wužywarske mě.
To by měło se jano cyniś, aby zajźowało wandalizm a w makanju z zasadach.
\'\'Toś ten bok buźo śi zmóžnjaś, samo njeeksistujucych wužywarjow blokěrowaś a buźo teke wužywarjow z pódobnym mjenim blokěrowaś, t.j. "Test" buźo se gromaźe "Test 2" atd. blokěrowaś. Móžoš teke dopołne IP-adrese blokěrowaś, to groni, až nichto, kótaryž se z nimi pśizjawja, njamóžo boki wobźěłaś. Pśispomnjeśe: źělne IP-adrese wobchadaju se ako wužywarske mjenja, aby rozsuźił wo blokěrowanju. Jolic pśicyna njejo pódana, buźo se powšykna pśicyna wužiwaś.\'\'',
	'regexblock-page-title-1' => 'Adresu z pomocu regularnych wurazow blokěrowaś',
	'regexblock-reason-ip' => 'Toś tej IP-adresy se zawoborujo wobźěłowanje dla wandalizma abo drugego mólenja wót tebje abo někogo, kótaryž ma samsku IP-adresu.
Jolic wěriš, až to jo zmólenje, pšosym [[$1|staj se z nami do zwiska]].',
	'regexblock-reason-name' => 'Toś tomu wužywarskemu mjenjeju se zawoborujo wobźěłowanje, dla wandalizma abo drugego mólenja.
Jolic wěriš, až to jo zamólenje, pšosym [[$1|staj se z nami do zwiska]].',
	'regexblock-reason-regex' => 'Toś tomu wužywarskemu mjenjeju se zawoborujo wobźěłowanje, dla wandalizma abo drugego mólenja wót wužywarja z pódobnym mjenim.
Pšosym napóraj druge wužywarske mě abo [[$1|informěruj nas]] wó toś tom problemje.',
	'regexblock-form-username' => 'IP-adresa abo wužywarske mě:',
	'regexblock-form-reason' => 'Pśicyna:',
	'regexblock-form-expiry' => 'Wótběgnjo:',
	'regexblock-form-match' => 'Eksaktne makanje',
	'regexblock-form-account-block' => 'Załoženje nowych kontow blokěrowaś',
	'regexblock-form-submit' => 'Toś togo wužywarja blokěrowaś',
	'regexblock-form-submit-empty' => 'Pódaj wužywarske mě abo IP-adresu za blokěrowanje.',
	'regexblock-form-submit-regex' => 'Njepłaśiwy regularny wuraz.',
	'regexblock-form-submit-expiry' => 'Pšosym pódaj cas pśepadnjenja.',
	'regexblock-link' => 'z regularnym wurazom blokěrowaś',
	'regexblock-match-stats-record' => "$1 jo blokěrował '$2' na '$3' '$4', pśizjawjony wót adrese '$5'",
	'regexblock-nodata-found' => 'Žedne daty namakane',
	'regexblock-stats-title' => 'Statistika blokěrowanjow pśez regularne wuraze',
	'regexblock-unblock-success' => 'Pśipušćenje wuspěšnje',
	'regexblock-unblock-log' => "Wužywarske mě abo IP-adrese '''$1''' jo se pśipušćiło.",
	'regexblock-unblock-error' => 'Zmólka pśi pśipušćanju $1.
Nejskerjej taki wužywaŕ njejo.',
	'regexblock-regex-filter' => 'abo gódnota regularnego wuraza:',
	'regexblock-view-blocked' => 'Naglěd blokěrowany wót:',
	'regexblock-view-all' => 'Wšykne',
	'regexblock-view-go' => 'Źi',
	'regexblock-view-match' => '(eksaktne makanje)',
	'regexblock-view-regex' => '(wótpowědujo regularnemu wurazoju)',
	'regexblock-view-account' => '(Blokěrowanje załoženja kontow)',
	'regexblock-view-reason' => 'Pśicyna: $1',
	'regexblock-view-reason-default' => 'powšykna pśicyna',
	'regexblock-view-block-infinite' => 'wobstawne blokěrowanje',
	'regexblock-view-block-by' => 'blokěrowany wót:',
	'regexblock-view-block-unblock' => 'pśipušćiś',
	'regexblock-view-stats' => 'statistiske pódaśa',
	'regexblock-view-empty' => 'Lisćina blokěrowanych mjenjow a adresow jo prozna.',
	'regexblock-view-time' => 'na $1',
	'right-regexblock' => 'Zawoborujo wužywarjam wobźěłowanje na wšych wikijach na wikijowej farmje',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'regexblock-form-expiry' => 'Nuwuwu:',
	'regexblock-view-go' => 'Yi',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Dada
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'regexblock' => 'Τακτική έκφραση φραγής',
	'regexblock-already-blocked' => 'Ο $1 είναι ήδη φραγμένος',
	'regexblock-block-success' => 'Η φραγή πέτυχε',
	'regexblock-currently-blocked' => 'Υπάρχουσες φραγμένες διευθύνσεις:',
	'regexblock-page-title' => 'Κανονική φραγή ονόματος έκφρασης',
	'regexblockstats' => 'Τακτική έκφραση στατιστικών φραγής',
	'regexblock-form-username' => 'Διεύθυνση IP ή όνομα χρήστη',
	'regexblock-form-reason' => 'Λόγος:',
	'regexblock-form-expiry' => 'Λήξη:',
	'regexblock-form-match' => 'Ακριβής αντιστοιχία',
	'regexblock-form-account-block' => 'Φραγή δημιουργίας νέων λογαριασμών',
	'regexblock-form-submit' => 'Φραγή αυτού του χρήστη',
	'regexblock-form-submit-regex' => 'Μη έγκυρη τακτική έκφραση',
	'regexblock-form-submit-expiry' => 'Παρακαλούμε ορίστε μια περίοδο λήξης.',
	'regexblock-nodata-found' => 'Δεν βρέθηκαν δεδομένα',
	'regexblock-unblock-success' => 'Η άρση φραγής ολοκληρώθηκε επιτυχώς',
	'regexblock-regex-filter' => ' ή τιμή τακτικής έκφρασης:',
	'regexblock-view-blocked' => 'Προβολή φραγμένων από:',
	'regexblock-view-all' => 'Όλα',
	'regexblock-view-go' => 'Πήγαινε',
	'regexblock-view-match' => '(ακριβής αντιστοιχία)',
	'regexblock-view-regex' => '(αντιστοιχία τακτικής έκφρασης)',
	'regexblock-view-account' => '(φραγή δημιουργίας λογαριασμού)',
	'regexblock-view-reason' => 'Λόγος: $1',
	'regexblock-view-reason-default' => 'γενικός λόγος',
	'regexblock-view-block-infinite' => 'μόνιμη φραγή',
	'regexblock-view-block-by' => 'φραγμένος από:',
	'regexblock-view-block-unblock' => 'άρση φραγής',
	'regexblock-view-stats' => 'στατιστικά',
	'regexblock-view-time' => 'στις $1',
);

/** Esperanto (Esperanto)
 * @author LyzTyphone
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'regexblock-already-blocked' => '$1 jam estas forbarita.',
	'regexblock-block-log' => "Salutnomo aŭ IP-adreso '''$1''' estis forbarita.",
	'regexblock-block-success' => 'Forbaro sukcesis',
	'regexblock-currently-blocked' => 'Nune forbaritaj adresoj:',
	'regexblock-form-username' => 'IP Adreso aŭ salutnomo:',
	'regexblock-form-reason' => 'Kialo:',
	'regexblock-form-expiry' => 'Findato:',
	'regexblock-form-match' => 'Preciza kongruo',
	'regexblock-form-submit' => 'Bloki la uzanton',
	'regexblock-form-submit-regex' => 'Malvalida regulara esprimo.',
	'regexblock-unblock-success' => 'Malforbaro sukcesis',
	'regexblock-unblock-log' => "Salutnomo aŭ IP-adreso '''$1''' estis restarigita.",
	'regexblock-unblock-error' => 'Eraro malforbarante $1.
Verŝajne ne estas uzanto kun tiu nomo.',
	'regexblock-view-all' => 'Ĉiuj',
	'regexblock-view-go' => 'Ek!',
	'regexblock-view-reason' => 'kialo: $1',
	'regexblock-view-reason-default' => 'malspecifa kialo',
	'regexblock-view-block-infinite' => 'ĉiama bloko',
	'regexblock-view-block-by' => 'forbarita de:',
	'regexblock-view-block-unblock' => 'restarigu',
	'regexblock-view-stats' => 'statistikoj',
	'regexblock-view-time' => 'je $1',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Hamilton Abreu
 * @author Imre
 * @author Jatrobat
 * @author Piolinfax
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'regexblock' => 'Bloque de expresión regular',
	'regexblock-already-blocked' => '"$1" ya está bloqueado.',
	'regexblock-block-log' => "Nombre de usuario o dirección IP '''$1''' ha sido bloqueada.",
	'regexblock-block-success' => 'Bloqueo fue un éxito',
	'regexblock-currently-blocked' => 'Direcciones actualmente bloqueadas:',
	'regexblock-desc' => 'Extensión usada para bloquear nombres de usuario y direcciones de IP con expresiones regulares. Contiene el mecanismo de bloqueo y una [[Special:Regexblock|special page]] para añadir/administrar bloqueos',
	'regexblock-expire-duration' => '1 hora,2 horas,4 horas,6 horas,1 día,3 días,1 semana,2 semanas,1 mes,3 meses,6 meses,1 año,infinito',
	'regexblock-page-title' => 'Bloque de nombre de expresiones regulares',
	'regexblockstats' => 'Estadísticas del bloque de expresiones regulares',
	'regexblock-help' => 'Utilice el formulario de abajo para bloquear acceso de escritura de un usuario o dirección IP específicos.
Esto se deberá hacer para prevenir actos vandálicos y en concordancia con la política.
\'\'Esta página le permite incluso bloquear usuarios no existentes, y también bloqueará usuarios con nombres similares al introducido. Por ejemplo: "Prueba" se bloqueará en conjunto con "Prueba 2", etc.
También puede bloquear direcciones completas de IP, con lo que nadie que acceda al sistema desde ahí pueda editar páginas.
Observación: Las direcciones IP parciales serán tratadas como nombres de usuario en la determinación de bloqueos.
Si no se especifica una razón, se utilizará una razón genérica predeterminada.\'\'',
	'regexblock-page-title-1' => 'Bloquear direcciones por medio de expresiones regulares',
	'regexblock-reason-ip' => 'Esta dirección IP está prevenida de editar a causa de vandalismo u otra desorganización tuya o pde alguien que comparte tu dirección IP.
Si crees que esto es un error, por favor [[$1|contactanos]]',
	'regexblock-reason-name' => 'Este nombre de usuario está prevenido de editar a causa de vandalismo u otra desorganización.
Si crees que esto es un error, por favor [[$1|contactanos]]',
	'regexblock-reason-regex' => 'Este nombre de usuario está prevenido de editar a causa de vandalismo u otra desorganización hecha por un usuario con un nombre similar.
Por favor crea un nombre alternativo o [[$1|contactanos]] acerca del problema',
	'regexblock-form-username' => 'Dirección IP o nombre de usuario:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Expiración:',
	'regexblock-form-match' => 'Coincidencia exacta',
	'regexblock-form-account-block' => 'Bloquear creaación de nuevas cuentas',
	'regexblock-form-submit' => 'Bloquear este usuario',
	'regexblock-form-submit-empty' => 'De un nombre de usuario o una dirección IP a bloquear.',
	'regexblock-form-submit-regex' => 'Expresión regular inválida.',
	'regexblock-form-submit-expiry' => 'Por favor especifique un periodo de expiración.',
	'regexblock-link' => 'bloque con expresión regular',
	'regexblock-match-stats-record' => "$1 bloqueado '$2' en '$3' en '$4', iniciando sesión desde dirección '$5'",
	'regexblock-nodata-found' => 'Sin datos encontrados',
	'regexblock-stats-title' => 'Estadísticas del bloque de expresiones regulares',
	'regexblock-unblock-success' => 'Desbloqueo fue un éxito',
	'regexblock-unblock-log' => "Nombre de usuario o dirección IP '''$1''' ha sido bloqueada.",
	'regexblock-unblock-error' => 'Error desbloqueando $1.
Probablemente no existe tal usuario.',
	'regexblock-regex-filter' => 'o valor de expresión regular:',
	'regexblock-view-blocked' => 'Ver bloqueos por:',
	'regexblock-view-all' => 'Todos',
	'regexblock-view-go' => 'Ir',
	'regexblock-view-match' => '(coincidencia exacta)',
	'regexblock-view-regex' => '(coincidencia de expresión regular)',
	'regexblock-view-account' => '(bloqueo de creación de cuenta)',
	'regexblock-view-reason' => 'Motivo: $1',
	'regexblock-view-reason-default' => 'razón genérica',
	'regexblock-view-block-infinite' => 'bloqueo permanente',
	'regexblock-view-block-by' => 'bloqueado por:',
	'regexblock-view-block-unblock' => 'desbloquear',
	'regexblock-view-stats' => 'Estadísticas',
	'regexblock-view-empty' => 'La lista de nombres y direcciones bloqueadas está vacía',
	'regexblock-view-time' => 'en $1',
	'right-regexblock' => 'Bloquea el permiso de usuario de editar en todas las wikis de la granja wiki',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'regexblock-expire-duration' => '1 tund,2 tundi,4 tundi,6 tundi,1 päev,3 päeva,1 nädal,2 nädalat,1 kuu,3 kuud,6 kuud,1 aasta,igavene',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'regexblock-form-username' => 'IP helbidea edo lankide izena:',
	'regexblock-form-reason' => 'Arrazoia:',
	'regexblock-form-submit' => 'Erabiltzaile hau blokeatu',
	'regexblock-nodata-found' => 'Ez da daturik aurkitu',
	'regexblock-view-all' => 'Dena',
	'regexblock-view-go' => 'Joan',
	'regexblock-view-reason' => 'arrazoia: $1',
);

/** Persian (فارسی)
 * @author Zack90
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'regexblock' => 'مسدودکردن با عبارت باقاعده',
	'regexblock-already-blocked' => '$1 در حال حاضر مسدود شده‌است.',
	'regexblock-block-log' => "نام کاربری یا نشانی آی‌پی '''$1''' مسدود شده‌است.",
	'regexblock-block-success' => 'مسدودکردن با موفقیت انجام شد',
	'regexblock-currently-blocked' => 'نشانی‌هایی که در حال حاضر مسدود شده‌اند:',
	'regexblock-expire-duration' => '۱ ساعت,۲ ساعت,۴ ساعت,۶ ساعت,۱ روز,۳ روز,۱ هفته,۲ هفته,۱ ماه,۳ ماه,۶ ماه,۱ سال,بی‌پایان',
	'regexblock-form-username' => 'نشانی آی‌پی یا نام کاربری:',
	'regexblock-form-reason' => 'دلیل:',
	'regexblock-form-expiry' => 'زمان سرآمدن:',
	'regexblock-form-match' => 'تطبیق دقیق',
	'regexblock-form-account-block' => 'مسدودکردن ایجاد حساب‌های کاربری جدید',
	'regexblock-form-submit' => 'مسدودکردن این کاربر',
	'regexblock-form-submit-empty' => 'یک نام کاربری یا نشانی آی‌پی برای مسدودشدن بدهید.',
	'regexblock-form-submit-regex' => 'عبارت باقاعدهٔ نامعتبر',
	'regexblock-link' => 'مسدود کردن با استفاده از عبارت باقاعده',
	'regexblock-nodata-found' => 'هیچ داده‌ای یافت نشد',
	'regexblock-regex-filter' => ' یا مقدار عبارت باقاعده:',
	'regexblock-view-blocked' => 'نمایش مسدوده‌شده‌ها توسط:',
	'regexblock-view-all' => 'همه',
	'regexblock-view-go' => 'رفتن',
	'regexblock-view-reason' => 'دلیل: $1',
	'regexblock-view-reason-default' => 'دلیل عمومی',
	'regexblock-view-block-infinite' => 'مسدودکردن دائم',
	'regexblock-view-block-by' => 'مسدودکننده:',
	'regexblock-view-block-unblock' => 'آزادسازی',
	'regexblock-view-stats' => 'آمار',
	'regexblock-view-time' => 'در $1',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Option
 * @author Str4nd
 */
$messages['fi'] = array(
	'regexblock-already-blocked' => '$1 on jo estetty.',
	'regexblock-block-log' => "Käyttäjätunnus tai IP-osoite '''$1''' on nyt estetty.",
	'regexblock-block-success' => 'Estäminen onnistui',
	'regexblock-currently-blocked' => 'Tällä hetkellä estetyt osoitteet:',
	'regexblock-expire-duration' => '1 tunti,2 tuntia,4 tuntia,6 tuntia,1 vuorokausi,3 vuorokautta,1 viikko,2 viikkoa,1 kuukausi,3 kuukautta,6 kuukautta,1 vuosi,ikuinen',
	'regexblock-form-username' => 'IP-osoite tai käyttäjätunnus:',
	'regexblock-form-reason' => 'Syy:',
	'regexblock-form-expiry' => 'Kesto:',
	'regexblock-form-match' => 'Tarkka osuma',
	'regexblock-form-account-block' => 'Estä uusien tunnusten luonti',
	'regexblock-form-submit' => 'Estä tämä käyttäjä',
	'regexblock-form-submit-empty' => 'Anna estettävän käyttäjätunnus tai IP-osoite.',
	'regexblock-nodata-found' => 'Tietoja ei löytynyt',
	'regexblock-unblock-success' => 'Eston poisto onnistui',
	'regexblock-unblock-log' => "Eston poistaminen käyttäjätunnukselta tai IP-osoitteelta '''$1''' on onnistunut.",
	'regexblock-unblock-error' => 'Virhe purkaessa estoa $1.
Todennäköisesti kyseistä käyttäjää ei ole olemassa.',
	'regexblock-view-all' => 'Kaikki',
	'regexblock-view-go' => 'Siirry',
	'regexblock-view-match' => '(tarkka osuma)',
	'regexblock-view-account' => '(tunnusten luominen estetty)',
	'regexblock-view-reason' => 'syy: $1',
	'regexblock-view-reason-default' => 'yleinen syy',
	'regexblock-view-block-infinite' => 'pysyvä esto',
	'regexblock-view-block-by' => 'estänyt:',
	'regexblock-view-block-unblock' => 'poista esto',
	'regexblock-view-stats' => 'tilastot',
	'regexblock-view-empty' => 'Estettyjen käyttäjätunnuksien sekä osoitteiden lista on tyhjä.',
	'right-regexblock' => 'Estää käyttäjiä muokkaamasta kaikissa wikifarmin wikeissä',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'regexblock' => 'Expressions rationnelles pour bloquer un utilisateur ou une IP',
	'regexblock-already-blocked' => '$1 est déjà bloqué.',
	'regexblock-block-log' => "L’Utilisateur ou l’adresse IP '''$1''' a été bloqué.",
	'regexblock-block-success' => 'Le blocage a réussi',
	'regexblock-currently-blocked' => 'Adresses actuellement bloquées :',
	'regexblock-desc' => 'Extension utilisée pour bloquer des utilisateurs ou des adresses IP avec des expressions rationnelles. Contient à la fois un mécanisme de blocage ainsi qu’[[Special:Regexblock|une page]] pouvant ajouter et gérer les blocages.',
	'regexblock-expire-duration' => '1 heure,2 heures,4 heures,6 hours,1 jour,3 jours,1 semaine,2 semaines,1 mois,3 mois,6 mois,1 and,infini',
	'regexblock-page-title' => 'Blocage d’un nom par une expression rationnelle',
	'regexblockstats' => 'Statistiques sur les blocages par expressions rationnelles',
	'regexblock-help' => "Utilisez le formulaire ci-dessous pour bloquer l’accès en écriture d’une adresse IP ou d’un nom d’utilisateur.
Ceci doit être fait uniquement pour éviter tout vandalisme et conformément aux règles prescrites sur le projet.
''Cette page vous permet même de bloquer des utilisateurs non enregistrés et ceux présentant des noms similaires au nom donné : par exemple, « Test » sera bloqué en même temps que « Test 2 » etc. Vous pouvez aussi bloquer des adresses IP complètes, ce qui signifie que personne connecté depuis celles-ci ne pourra modifier des pages. Note : des adresses IP partielles seront considérées comme des noms d’utilisateur lors du blocage. Si aucun motif n’est indiqué en commentaire, un motif par défaut sera indiqué.''",
	'regexblock-page-title-1' => 'Blocage d’une adresse utilisant une expression rationnelle',
	'regexblock-reason-ip' => 'Cette adresse IP n’a pas les droits de modification pour cause de vandalisme ou autres méfaits analogues commis par vous ou quelqu’un d’autre partageant cette adresse IP.
Si vous êtes persuadé{{GENDER:||e|(e)}} qu’il s’agit d’une erreur, [[$1|contactez-nous]].',
	'regexblock-reason-name' => 'Cet utilisateur n’a pas les droits de modification pour cause de vandalisme ou autres méfaits analogues.
Si vous êtes persuadé{{GENDER:||e|(e)}} qu’il s’agit d’une erreur, [[$1|contactez-nous]].',
	'regexblock-reason-regex' => 'Cet utilisateur est écarté de toute modification pour cause de vandalisme ou autres faits analogues commis par un utilisateur ayant un nom similaire. Veuillez créer un autre compte ou [[$1|contactez-nous]] pour signaler le problème.',
	'regexblock-form-username' => 'Adresse IP ou Utilisateur :',
	'regexblock-form-reason' => 'Motif :',
	'regexblock-form-expiry' => 'Expiration :',
	'regexblock-form-match' => 'Terme exact',
	'regexblock-form-account-block' => 'Interdire la création d’un nouveau compte.',
	'regexblock-form-submit' => 'Bloquer cet utilisateur',
	'regexblock-form-submit-empty' => 'Indiquez un nom d’utilisateur ou une adresse IP à bloquer.',
	'regexblock-form-submit-regex' => 'Expression rationnelle incorrecte.',
	'regexblock-form-submit-expiry' => 'Précisez une période d’expiration.',
	'regexblock-link' => 'bloquer avec un expression rationnelle',
	'regexblock-match-stats-record' => '$1 a bloqué « $2 » le « $3 » à « $4 », connecté depuis l’adresse « $5 »',
	'regexblock-nodata-found' => 'Aucune donnée trouvée',
	'regexblock-stats-title' => 'Statistiques des blocages par expressions rationnelles',
	'regexblock-unblock-success' => 'Le déblocage a réussi',
	'regexblock-unblock-log' => "L’utilisateur ou l’adresse IP '''$1''' a été débloqué.",
	'regexblock-unblock-error' => 'Erreur de déblocage de $1. L’utilisateur n’existe probablement pas.',
	'regexblock-regex-filter' => '  ou une expression rationnelle :',
	'regexblock-view-blocked' => 'Voir les blocages par :',
	'regexblock-view-all' => 'Tous',
	'regexblock-view-go' => 'Lancer',
	'regexblock-view-match' => '(terme exact)',
	'regexblock-view-regex' => '(expression rationnelle)',
	'regexblock-view-account' => '(création des comptes bloquée)',
	'regexblock-view-reason' => 'motif : $1',
	'regexblock-view-reason-default' => 'aucun motif indiqué',
	'regexblock-view-block-infinite' => 'blocage permanent',
	'regexblock-view-block-by' => 'bloqué par :',
	'regexblock-view-block-unblock' => 'débloquer',
	'regexblock-view-stats' => 'statistiques',
	'regexblock-view-empty' => 'La liste des utilisateurs et des adresses IP bloqués est vide.',
	'regexblock-view-time' => 'le $1',
	'right-regexblock' => 'Bloquer en écriture les utilisateurs sur tout les wikis de la ferme wiki',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'regexblock' => 'Blocâjo per èxprèssions racionèles',
	'regexblock-already-blocked' => '$1 est ja blocâ.',
	'regexblock-block-success' => 'Lo blocâjo at reussi',
	'regexblock-currently-blocked' => 'Adrèces blocâs houé :',
	'regexblock-page-title' => 'Blocâjo d’un nom per una èxprèssion racionèla',
	'regexblockstats' => 'Statistiques des blocâjos per èxprèssions racionèles',
	'regexblock-form-username' => 'Adrèce IP ou ben nom d’utilisator :',
	'regexblock-form-reason' => 'Rêson :',
	'regexblock-form-expiry' => 'Èxpiracion :&#160;',
	'regexblock-form-match' => 'Corrèspondance justa',
	'regexblock-form-account-block' => 'Dèfendre la crèacion d’un compto novél',
	'regexblock-form-submit' => 'Blocar ceti usanciér',
	'regexblock-form-submit-regex' => 'Èxprèssion racionèla fôssa.',
	'regexblock-link' => 'blocar avouéc una èxprèssion racionèla',
	'regexblock-match-stats-record' => '$1 at blocâ « $2 » lo « $3 » a « $4 », branchiê dês l’adrèce « $5 »',
	'regexblock-nodata-found' => 'Gins de balyê trovâ',
	'regexblock-stats-title' => 'Statistiques des blocâjos per èxprèssions racionèles',
	'regexblock-unblock-success' => 'Lo dèblocâjo at reussi',
	'regexblock-unblock-log' => "L’usanciér ou ben l’adrèce IP '''$1''' at étâ dèblocâ.",
	'regexblock-regex-filter' => ' ou ben una èxprèssion racionèla :',
	'regexblock-view-blocked' => 'Vêre los blocâjos per :',
	'regexblock-view-all' => 'Tôs',
	'regexblock-view-go' => 'Lanciér',
	'regexblock-view-match' => '(corrèspondance justa)',
	'regexblock-view-regex' => '(èxprèssion racionèla)',
	'regexblock-view-account' => '(dèfensa de la crèacion de comptos)',
	'regexblock-view-reason' => 'rêson : $1',
	'regexblock-view-reason-default' => 'rêson g·ènèrica',
	'regexblock-view-block-infinite' => 'blocâjo sen fin',
	'regexblock-view-block-by' => 'blocâ per :',
	'regexblock-view-block-unblock' => 'dèblocar',
	'regexblock-view-stats' => 'statistiques',
	'regexblock-view-time' => 'lo $1',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'regexblock-already-blocked' => '$1 is al útsluten.',
	'regexblock-form-expiry' => 'Ferrint nei:',
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
	'regexblockstats' => 'Estatísticas do bloqueo por expresións regulares',
	'regexblock-help' => "Use o formulario de embaixo para bloquear o acceso de escritura desde un determinado enderezo IP ou nome de usuario.
Isto debería facerse só para previr vandalismo, e segundo a política e normas de bloqueo.
''Esta páxina permitiralle bloquear incluso usuarios que non existen, e usuarios con nomes semellantes ao dado, é dicir, «Test» será bloqueado xunto con «Test 2», etc. Tamén pode bloquear enderezos IP completos, no sentido de que ninguén rexistrado nos mesmos será capaz de editar páxinas. Nota: os enderezos IP parciais serán tratados polos nomes de usuarios na determinación do bloqueo. Se non se especifica a razón, será usado por defecto un motivo xenérico.''",
	'regexblock-page-title-1' => 'Bloquear un enderezo usando expresións regulares',
	'regexblock-reason-ip' => 'A este enderezo IP estalle prohibido editar debido a vandalismo ou outras actividades negativas realizadas por vostede ou por alguén que comparte o seu enderezo IP.
Se pensa que se trata dun erro, [[$1|póñase en contacto con nós]]',
	'regexblock-reason-name' => 'A este nome de usuario estalle prohibido editar debido a vandalismo ou outras actividades negativas.
Se pensa que se trata dun erro, [[$1|contacte con nós]]',
	'regexblock-reason-regex' => 'A este nome de usuario estalle prohibido editar debido a vandalismo ou outras actividades negativas por parte dun usuario cun nome semellante.
Cree un nome de usuario diferente ou [[$1|contacte con nós]] para falar sobre o problema',
	'regexblock-form-username' => 'Enderezo IP ou nome de usuario:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Remate:',
	'regexblock-form-match' => 'Procura exacta',
	'regexblock-form-account-block' => 'Bloqueada a creación de novas contas',
	'regexblock-form-submit' => 'Bloquear este usuario',
	'regexblock-form-submit-empty' => 'Dar un nome de usuario ou un enderezo IP para bloquear.',
	'regexblock-form-submit-regex' => 'Expresión regular non válida.',
	'regexblock-form-submit-expiry' => 'Especifique un período de caducidade.',
	'regexblock-link' => 'bloquear cunha expresión regular',
	'regexblock-match-stats-record' => '$1 bloqueou a "$2" en "$3" ás $4, rexistrado desde o enderezo "$5"',
	'regexblock-nodata-found' => 'Non se atoparon os datos',
	'regexblock-stats-title' => 'Estatísticas do bloqueo por expresións regulares',
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
	'regexblock-view-block-by' => 'bloqueado por:',
	'regexblock-view-block-unblock' => 'desbloquear',
	'regexblock-view-stats' => 'estatísticas',
	'regexblock-view-empty' => 'A lista dos nomes e enderezos bloqueados está baleira.',
	'regexblock-view-time' => 'en $1',
	'right-regexblock' => 'Bloquearlles aos usuarios a edición en todos os wikis na granxa',
);

/** Gothic (Gothic)
 * @author Crazymadlover
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'regexblock-form-reason' => '𐍆𐌰𐌹𐍂𐌹𐌽𐌰:',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'regexblock-form-reason' => 'Αἰτία:',
	'regexblock-form-expiry' => 'Λῆξις:',
	'regexblock-view-all' => 'ἅπασαι',
	'regexblock-view-go' => 'Ἱέναι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'regexblock' => 'Regex-Sperri',
	'regexblock-already-blocked' => '$1 isch scho gsperrt.',
	'regexblock-block-log' => "Benutzername oder IP-Adräss '''$1''' isch gsperrt wore.",
	'regexblock-block-success' => 'Sperrig erfolgryych',
	'regexblock-currently-blocked' => 'Zur Zyt gsperrti Adrässe:',
	'regexblock-desc' => 'Erwyterig zum Sperre vu Benutzernämen un IP-Adrässe mit regulären Uusdrick. S het e Sperrmechanismus din un e [[Special:Regexblock|Spezialsyte]] go Sperrine zuefiege un verwalte',
	'regexblock-expire-duration' => '1 Stund,2 Stunde,4 Stunde,6 Stunde,1 Tag,3 Täg,1 Wuche,2 Wuche,1 Monet,3 Monet,6 Monet,1 Johr,fir immer',
	'regexblock-page-title' => 'Namesperri mit regulären Uusdrick',
	'regexblockstats' => 'Regex-Sperrstatischtike',
	'regexblock-help' => "Bruuch des Formular go ne IP-Adräss oder e aagmäldete Benutzer z sperren.
Die Funktion sott nume yygsetzt wäre go Vandalismus verhindere un alliwyl nume no dr Richtlinie.
''Die Seite erlaubt s au Benuttzer z sperre, wu s gar nit git, un Benutzer, wu ähnligi Näme hän wie sonigi, wu s scho git, z. B. wird mit „Test” au „Test 2“ usw. gsperrt .
Du chasch au gani IP-Adrässe sperre, ass nieme meh sich unter däne IP-Adrässe cha aamaälde, Syte bearbeite usw.
Obacht: Teil vu IP-Adrässe wäre bim Sperre as Benutzernamen ufgfasst.
Wänn kei Sperrgrund aagee wird, wird e Standard-Grund bruucht.''",
	'regexblock-page-title-1' => 'Adrässe mit regulären Uusdrick sperre',
	'regexblock-reason-ip' => 'Däre IP-Adräss isch s verbote Bearbeitige z mache, wel vu däre IP-Adräss – vu Dir oder eberem mit dr nämligen IP_Adräss -  Vandalismus oder schädlig Verhalten uusgangen isch.
Wänn Du dänksch, ass es sich dodebyy um e Fähler handlet, no [[$1|nimm Kontakt zuen is uf]].',
	'regexblock-reason-name' => 'Däm Benutzername isch s verbote, Bearbeitige z mache, wäge Vandalismus oder anderem schändlige Verhalte.
Wänn Du dänksch, ass es sich dodebyy um e Fähler handlet, no [[$1|nimm Kontakt zuen is uf]]',
	'regexblock-reason-regex' => 'Däm Benutzername isch s verbote, Bearbeitige z mache, wäge Vandalismus oder anderem schändlige Verhalte.
Bitte mälde Di mit eme andere Benutzernamen aa oder [[$1|nimm Kontakt zuen is uf]] zum Probläm.',
	'regexblock-form-username' => 'IP-Adräss oder Benutzername:',
	'regexblock-form-reason' => 'Grund:',
	'regexblock-form-expiry' => 'Ablaufdatum:',
	'regexblock-form-match' => 'Gnaue Träffer',
	'regexblock-form-account-block' => 'S Aalege vu neje Benutzerkonte sperre',
	'regexblock-form-submit' => 'Dää Benutzer sperre',
	'regexblock-form-submit-empty' => 'E Benutzernamen oder e IP-Adräss fir d Sperrig aagee.',
	'regexblock-form-submit-regex' => 'Nit giltige regulären Uusdruck.',
	'regexblock-form-submit-expiry' => 'Bitte wehl e Verfallszytruum.',
	'regexblock-link' => 'mit eme reguläre Uusdruck sperre',
	'regexblock-match-stats-record' => '$1 het „$2“ uf „$3“ um „$4“ gsperrt, aagmäldet vu dr Adräss „$5“',
	'regexblock-nodata-found' => 'Kei Date gfunde',
	'regexblock-stats-title' => 'Regex-Sperrstatischtike',
	'regexblock-unblock-success' => 'Entsperrig erfolgryych',
	'regexblock-unblock-log' => "Benutzername oder IP-Adräss '''$1''' isch entsperrt wore.",
	'regexblock-unblock-error' => 'Fähler bim Entsperre vu $1.
Wahrschyns git s kei sonige Benutzer.',
	'regexblock-regex-filter' => '   oder regulären Uusdruck:',
	'regexblock-view-blocked' => 'Aasicht gsperrt vu:',
	'regexblock-view-all' => 'Alli',
	'regexblock-view-go' => 'Gang',
	'regexblock-view-match' => '(gnaue Träffer)',
	'regexblock-view-regex' => '(Regex-Träffer)',
	'regexblock-view-account' => '(Benutzerkonteaalege gsperrt)',
	'regexblock-view-reason' => 'Grund: $1',
	'regexblock-view-reason-default' => 'allgmeine Grund',
	'regexblock-view-block-infinite' => 'permanenti Sperrig',
	'regexblock-view-block-by' => 'gsperrt vu:',
	'regexblock-view-block-unblock' => 'entsperre',
	'regexblock-view-stats' => 'Statischtike',
	'regexblock-view-empty' => 'D Lischt vu dr gsperrte Nämen un Adrässen isch läär.',
	'regexblock-view-time' => 'am $1',
	'right-regexblock' => 'Nimmt Benutzer s Rächt uf allene Wiki vum Wiki-Hof Bearbeitige z mache',
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

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'regexblock-form-reason' => 'Dalili:',
	'regexblock-view-all' => 'Duka',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'regexblock-expire-duration' => '1 hola,2 hola,4 hola,6 hola,1 lā,3 lā,1 pule,2 pule,1 mahina,3 mahina,6 mahina,1 makahiki,pau ʻole',
	'regexblock-form-reason' => 'Kumu:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'regexblock' => 'חסימה לפי ביטויים רגולריים',
	'regexblock-already-blocked' => '$1 כבר חסום.',
	'regexblock-block-log' => "כתובת ה־IP או שם המשתמש '''$1''' נחסמו.",
	'regexblock-block-success' => 'החסימה בוצעה בהצלחה',
	'regexblock-currently-blocked' => 'הכתובות החסומות נכון לעכשיו:',
	'regexblock-desc' => 'הרחבה המשמשת לחסימת שמות וכתובות IP של משתמשים בעזרת ביטויים רגולריים. היא מכילה גם את מנגנון החסימה וגם [[Special:Regexblock|דף מיוחד]] להוספת/ניהול החסימות.',
	'regexblock-expire-duration' => 'שעה,שעתיים,4 שעות,6 שעות,יום,3 ימים,שבוע,שבועיים,חודש,3 חודשים,6 חודשים,שנה,לצמיתות',
	'regexblock-page-title' => 'חסימת שם לפי ביטוי רגולרי',
	'regexblockstats' => 'סטטיסטיקת החסימה באמצעות ביטויים רגולריים',
	'regexblock-help' => "השתמשו בטופס שלהלן כדי לחסום גישה לכתיבה מפני שם משתמש או כתובת IP מסוימים.
יש לעשות זאת רק כדי להימנע מהשחתה, ובהתאם למדיניות.
'''דף זה יאפשר לכם לחסום אפילו משתמשים שאינם קיימים, וגם יחסום משתמשים שם שמות הדומים לשם שצויין, לדוגמה: \"בדיקה\" תיחסם יחד עם \"בדיקה 2\" וכו'.
תוכלו גם לחסום כתובות IP מלאות, כלומר שכל מי שמתחבר מכתובת זו לא יוכל לערוך דפים.
הערה: כתובות IP חלקיות תיחשבנה לשמות משתמשים בזיהוי החסימה.
אם לא צוינה סיבה, יעשה שימוש בהודעה כללית כברירת מחדל.'''",
	'regexblock-page-title-1' => 'חסימת כתובת באמצעות ביטויים רגולריים',
	'regexblock-reason-ip' => 'העריכה מכתובת IP זו נחסמה עקב  השחתה או הפרעה אחרת על ידיכם או על ידי מישהו אחר החולק איתכם את כתובת ה־IP.
אם אתם חושבים שזו טעות, אנא [[$1|צרו קשר]]',
	'regexblock-reason-name' => 'העריכה מחשבון משתמש זה נחסמה עקב השחתה או הפרעה אחרת.
אם אתם חושבים שזו טעות, אנא [[$1|צרו קשר]]',
	'regexblock-reason-regex' => 'הרשאות העריכה של שם משתמש זה נשללו עקב השחתה או הפרעה אחרת על ידי משתמש בעל שם משתמש דומה.
אנא צרו שם משתמש חלופי או [[$1|צרו קשר]] אודות הבעיה.',
	'regexblock-form-username' => 'כתובת IP או שם משתמש:',
	'regexblock-form-reason' => 'סיבה:',
	'regexblock-form-expiry' => 'פקיעה:',
	'regexblock-form-match' => 'התאמה מדויקת',
	'regexblock-form-account-block' => 'חסימת יצירת חשבונות חדשים',
	'regexblock-form-submit' => 'חסימת משתמש זה',
	'regexblock-form-submit-empty' => 'כתבו שם משתמש או כתובת IP לחסימה.',
	'regexblock-form-submit-regex' => 'ביטוי רגולרי בלתי תקין.',
	'regexblock-form-submit-expiry' => 'אנא ציינו את משך הזמן עד לפקיעת החסימה.',
	'regexblock-link' => 'חסימה באמצעות ביטויים רגולאריים',
	'regexblock-match-stats-record' => "$1 נחסם '$2' ב־'$3' ב־'$4', בעת התחברות מהכתובת '$5'",
	'regexblock-nodata-found' => 'לא נמצאו נתונים',
	'regexblock-stats-title' => 'סטטיסטיקת הנתונים הרגולריים',
	'regexblock-unblock-success' => 'שחרור החסימה הושלם בהצלחה',
	'regexblock-unblock-log' => "כתובת ה־IP או שם המשתמש '''$1''' שוחררו מחסימה.",
	'regexblock-unblock-error' => 'שגיאה בשחרור $1.
כנראה שאין משתמש כזה.',
	'regexblock-regex-filter' => '  או ערך ביטוי רגולרי:',
	'regexblock-view-blocked' => 'צפייה בחסימות שבוצעו על ידי:',
	'regexblock-view-all' => 'כולם',
	'regexblock-view-go' => 'הצגה',
	'regexblock-view-match' => '(התאמה מדויקת)',
	'regexblock-view-regex' => '(התאמת ביטוי רגולרי)',
	'regexblock-view-account' => '(חסימת יצירת חשבונות)',
	'regexblock-view-reason' => 'סיבה: $1',
	'regexblock-view-reason-default' => 'סיבה כללית',
	'regexblock-view-block-infinite' => 'חסימה קבועה',
	'regexblock-view-block-by' => 'נחסם על ידי:',
	'regexblock-view-block-unblock' => 'שחרור חסימה',
	'regexblock-view-stats' => 'סטטיסטיקה',
	'regexblock-view-empty' => 'רשימת השמות והכתובות החסומים ריקה.',
	'regexblock-view-time' => 'ב־$1',
	'right-regexblock' => 'חסימת משתמשים מעריכה בכל אתרי הוויקי שבחוות הוויקי',
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
	'regexblock-view-block-by' => 'ब्लॉक कर्ता',
	'regexblock-view-block-unblock' => 'अनब्लॉक',
	'regexblock-view-stats' => 'सांख्यिकी',
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
 * @author Ex13
 * @author Herr Mlinka
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'regexblock' => 'Blokiranje pomoću regularnih izraza',
	'regexblock-already-blocked' => '$1 je već blokiran.',
	'regexblock-block-log' => "Suradnik ili IP-adresa '''$1''' su blokirani.",
	'regexblock-block-success' => 'Blokiranje uspjelo',
	'regexblock-currently-blocked' => 'Trenutno blokirane adrese:',
	'regexblock-expire-duration' => '1 sat,2 sata,4 sata,6 sati,1 dan,3 dana,1 tjedan,2 tjedna,1 mjesec,3 mjeseca,6 mjeseci,1 godina,zauvijek',
	'regexblock-page-title' => 'Blokiranje pomoću regularnih izraza',
	'regexblockstats' => 'Statistika blokiranja regularnim izrazima',
	'regexblock-help' => "Rabite donju formu za blokiranje određenih IP adresa ili suradnika. TO treba činiti samo radi sprječavanja vandalizama, u skladu s pravilima.

''Ova stranica omogućava vam blokiranje suradničkih imena prema uzorku (postojećih i novih), npr. ako blokirate « Test 2», blokirat ćete i « Test » itd. Možete također blokirati IP adrese, što znači da nitko tko se prijavi s njih neće moći uređivati. Napomena: djelomične IP adrese bit će analizirane prema suradničkim imenima u određivanju trajanja bloka. Ukoliko razlog nije dan, bit će navedeno generičko objašnjenje.''",
	'regexblock-page-title-1' => 'Blokiraj adresu koristeći regularni izraz',
	'regexblock-reason-ip' => 'Ova IP adresa je spriječena uređivati stranice zbog vandalizma ili drugog vašeg prekršaja ili nekog s kim dijelite IP adresu. 
Ukoliko mislite da je posrijedi greška, molimo [[$1|kontaktirajte nas]]',
	'regexblock-reason-name' => 'Ovo je suradničko ime spriječeno uređivati zbog vandalizma ili nekog drugog prekršaja. Ukoliko mislite da je posrijedi greška, molimo [[$1|kontaktirajte nas]]',
	'regexblock-reason-regex' => 'Ovo je suradničko ime spriječeno uređivati zbog vandalizma ili nekog drugog prekršaja suradnika sličnog imena. Molimo stvorite drugo suradničko ime ili nas [[$1|kontaktirajte]] o problemu',
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
	'regexblock-view-block-by' => 'blokiran od:',
	'regexblock-view-block-unblock' => 'deblokiraj',
	'regexblock-view-stats' => 'statistika',
	'regexblock-view-empty' => 'Popis blokiranih imena i adresa je prazan.',
	'regexblock-view-time' => 'u $1',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'regexblock' => 'Blokowanje přez regularne wurazy',
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
	'regexblock-reason-ip' => 'Tuta IP-adresa so dla wandalizma abo mylenje přez tebje abo někoho druheho, kiž IP-adresu z tobu dźěli, za wobdźěłowanje zawěra. Jeli mysliš, zo to je zmylk, prošu [[$1|skontaktuj nas]].',
	'regexblock-reason-name' => 'Tute wužiwarske mjeno so dla wandalizma abo druheho mylenja za wobdźěłowanje zawěra. Jeli mysliš, zo to je zmylk, prošu [[$1|skontaktuj nas]].',
	'regexblock-reason-regex' => 'Tute wužiwarske mjeno so dla wandalizma abo druheho mylenja přez wužiwarja z podobnym mjenom zawěra. Prošu wutwor druhe wužiwarske mjeno abo [[$1|informuj nas]] wo tutym problemje.',
	'regexblock-form-username' => 'IP-adresa abo wužiwarske mjeno:',
	'regexblock-form-reason' => 'Přičina:',
	'regexblock-form-expiry' => 'Spadnjenje:',
	'regexblock-form-match' => 'Eksaktny wotpowědnik',
	'regexblock-form-account-block' => 'Wutworjenje nowych kontow blokować',
	'regexblock-form-submit' => 'Tutoho wužiwarja blokować',
	'regexblock-form-submit-empty' => 'Podaj wužiwarske mjeno abo IP-adresu za blokowanje.',
	'regexblock-form-submit-regex' => 'Njepłaćiwy regularny wuraz.',
	'regexblock-form-submit-expiry' => 'Podaj prošu periodu spadnjenja.',
	'regexblock-link' => 'z regularnym wurazom blokować',
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
	'regexblock-view-regex' => '(wotpowěduje regularnemu wurazej)',
	'regexblock-view-account' => '(wutworjenje konta blokować)',
	'regexblock-view-reason' => 'přičina: $1',
	'regexblock-view-reason-default' => 'powšitkowna přičina',
	'regexblock-view-block-infinite' => 'trajne blokowanje',
	'regexblock-view-block-by' => 'zablokowany wot:',
	'regexblock-view-block-unblock' => 'wotblokować',
	'regexblock-view-stats' => 'statistiske podaća',
	'regexblock-view-empty' => 'Lisćina zablokowanych mjenow a adresow je prózdna.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Wužiwarjam wobdźěłowanje na wšěch wikijach na wikijowej farmje zadźěwać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'regexblock' => 'Reguláris kifejezés alapú blokkolás',
	'regexblock-already-blocked' => '$1 már blokkolva van.',
	'regexblock-block-log' => "A(z) '''$1''' felhasználónév vagy IP-cím blokkolva.",
	'regexblock-block-success' => 'A blokk sikeres',
	'regexblock-currently-blocked' => 'Jelenleg blokkolt címek:',
	'regexblock-desc' => 'Kiterjesztés felhasználói nevek és IP-címek blokkolására reguláris kifejezések segítségével. Tartalmazza a blokkolási mechanizmust és egy [[Special:Regexblock|speciális lapot]] a blokkok kezelésére',
	'regexblock-expire-duration' => '1 óra:1 hour,2 óra:2 hours,4 óra:4 hours,6 óra:6 hours,1 nap:1 day,3 nap:3 days,1 hét:1 week,2 hét:2 weeks,1 hónap:1 month,3 hónap:3 months,6 hónap:6 months,1 év:1 year,végtelen:infinite',
	'regexblock-page-title' => 'Név blokkolása reguláris kifejezés segítségével',
	'regexblockstats' => 'Reguláris kifejezés alapú blokkok statisztikája',
	'regexblock-help' => "Használd az alábbi űrlapot egy megadott IP-cím vagy felhasználónév írási jogosultságának blokkolására.
Ezt csak vandalizmus megelőzése céljából szabad használni, összhangban az irányelvekkel.
''Ezen a lapon akár nem létező felhasználókat is blokkolhatsz, és a blokk érinteni fogja a megadotthoz hasonló felhasználóneveket is. Azaz „teszt” blokkolva lesz „teszt 2”-vel együtt, stb.
Blokkolhatsz teljes IP-címeket is, ami azt jelenti, hogy azokról bejelentkezve senki nem fog tudni szerkeszteni.
Megjegyzés: részleges IP-címek felhasználónévként lesznek értelmezve a blokk feldolgozásánál.
Ha nem adsz meg indoklást, általános ok lesz feltüntetve.''",
	'regexblock-page-title-1' => 'Cím blokkolása reguláris kifejezések segítségével',
	'regexblock-reason-ip' => 'Ezen IP-cím szerkesztési jogosultsága blokkolva van vandalizmus vagy más káros tevékenység miatt, amit te, vagy valaki veled azonos IP-címet használó követett el.
Ha úgy gondolod, hogy hiba történt, [[$1|vedd fel velünk a kapcsolatot]]',
	'regexblock-reason-name' => 'Ezen felhasználónév szerkesztési jogosultsága blokkolva van vandalizmus vagy más káros tevékenység miatt.
Ha úgy gondolod, hogy hiba történt, [[$1|vedd fel velünk a kapcsolatot]]',
	'regexblock-reason-regex' => 'Ezen IP-cím szerkesztési jogosultsága blokkolva van vandalizmus vagy más káros tevékenység miatt, amit hasonló nevű felhasználó követett el.
Kérlek regisztrálj más néven, vagy [[$1|vedd fel velünk a kapcsolatot]]',
	'regexblock-form-username' => 'IP-cím vagy felhasználói név:',
	'regexblock-form-reason' => 'Indoklás:',
	'regexblock-form-expiry' => 'Lejárat:',
	'regexblock-form-match' => 'Pontos találat',
	'regexblock-form-account-block' => 'Új fiókok létrehozásának tiltása',
	'regexblock-form-submit' => 'Blokkold ezt a felhasználót',
	'regexblock-form-submit-empty' => 'Add meg a blokkolandó felhasználónevet vagy IP-címet.',
	'regexblock-form-submit-regex' => 'Érvénytelen reguláris kifejezés.',
	'regexblock-form-submit-expiry' => 'Add meg a blokk lejáratát.',
	'regexblock-link' => 'blokkolás reguláris kifejezéssel',
	'regexblock-match-stats-record' => '$1 blokkolta „$2” felhasználót itt: „$3” ekkor: „$4”, naplózás a(z) „$5” címről',
	'regexblock-nodata-found' => 'Nem található adat',
	'regexblock-stats-title' => 'Reguláris kifejezés blokk statisztika',
	'regexblock-unblock-success' => 'A blokk feloldása sikerült',
	'regexblock-unblock-log' => "A(z) '''$1''' felhasználónév vagy IP-cím blokkja feloldva.",
	'regexblock-unblock-error' => 'Hiba $1 blokkjának feloldásakor.
Lehetséges hogy nincs ilyen felhasználó.',
	'regexblock-regex-filter' => ' vagy reguláris kifejezés:',
	'regexblock-view-blocked' => 'Blokkok megtekintése a blokkot kiosztó felhasználó szerint:',
	'regexblock-view-all' => 'Mind',
	'regexblock-view-go' => 'Menj',
	'regexblock-view-match' => '(pontos találat)',
	'regexblock-view-regex' => '(keresés reguláris kifejezéssel)',
	'regexblock-view-account' => '(fióklétrehozás tiltása)',
	'regexblock-view-reason' => 'indoklás: $1',
	'regexblock-view-reason-default' => 'általános indok',
	'regexblock-view-block-infinite' => 'végleges blokk',
	'regexblock-view-block-by' => 'blokkolta:',
	'regexblock-view-block-unblock' => 'blokkolás feloldása',
	'regexblock-view-stats' => 'statisztikák',
	'regexblock-view-empty' => 'A blokkolt felhasználónevek és IP-címek listája üres.',
	'regexblock-view-time' => 'ekkor: $1',
	'right-regexblock' => 'Felhasználók blokkolása az wikifarmon található összes wikin',
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
	'regexblock-expire-duration' => '1 hora,2 horas,4 horas,6 horas,1 die,3 dies,1 septimana,2 septimanas,1 mense,3 menses,6 menses,1 anno,infinite',
	'regexblock-page-title' => 'Blocada de un nomine per expression regular',
	'regexblockstats' => 'Statisticas super blocadas per expressiones regular',
	'regexblock-help' => 'Usa le formulario in basso pro blocar le accesso a scriber ab un adresse IP o nomine de usator specific.
Isto debe facite solmente pro impedir le vandalismo, e in concordantia con le politica in vigor.
\'\'Iste pagina te permitte blocar mesmo usatores non existente, e pote equalmente blocar usatores con nomines similar al date, i.e. "Test" essera blocate insimul con "Test 2", etc.
Tu pote tamben blocar adresses IP complete, isto vole dicer que necuno connectente se de istes potera modificar paginas.
Nota: le adresses IP partial essera considerate como nomines de usator in le determination del blocada.
Si nulle motivo es specificate, un motivo generic predefenite essera usate.\'\'',
	'regexblock-page-title-1' => 'Blocar adresses per medio de expressiones regular',
	'regexblock-reason-ip' => 'Iste adresse IP es impedite de facer modificationes pro causa de vandalismo o de altere disruption per te o per alcuno altere qui usa un adresse IP in commun con te. Si tu crede que isto es un error, per favor [[$1|contacta nos]].',
	'regexblock-reason-name' => 'Iste nomine de usator es impedite de facer modificationes pro causa de vandalismo o de altere disruption.
Si tu crede que isto sia un error, per favor [[$1|contacta nos]].',
	'regexblock-reason-regex' => 'Iste nomine de usator es impedite de facer modificationes pro causa de vandalismo o de altere disruption per un usator con un nomine similar.
Per favor crea un nomine de usator alternative o [[$1|contacta nos]] a proposito de iste problema.',
	'regexblock-form-username' => 'Adresse IP o nomine de usator:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Expiration:',
	'regexblock-form-match' => 'Correspondentia exacte',
	'regexblock-form-account-block' => 'Blocar le creation de nove contos',
	'regexblock-form-submit' => 'Blocar iste usator',
	'regexblock-form-submit-empty' => 'Specifica un nomine de usator o adresse IP a blocar.',
	'regexblock-form-submit-regex' => 'Expression regular invalide.',
	'regexblock-form-submit-expiry' => 'Per favor specifica un periodo de expiration.',
	'regexblock-link' => 'blocar con expression regular',
	'regexblock-match-stats-record' => "$1 blocava '$2' in '$3' al '$4', connectite ab le adresse '$5'",
	'regexblock-nodata-found' => 'Nulle datos trovate',
	'regexblock-stats-title' => 'Statisticas de blocadas per expressiones regular',
	'regexblock-unblock-success' => 'Disblocada succedite',
	'regexblock-unblock-log' => "Le nomine de usator o adresse IP '''$1''' ha essite disblocate.",
	'regexblock-unblock-error' => 'Error durante le disblocada de $1.
Probabilemente non existe tal usator.',
	'regexblock-regex-filter' => ' o valor regex:',
	'regexblock-view-blocked' => 'Vider blocadas per:',
	'regexblock-view-all' => 'Totes',
	'regexblock-view-go' => 'Va',
	'regexblock-view-match' => '(correspondentia exacte)',
	'regexblock-view-regex' => '(correspondentia per expression regular)',
	'regexblock-view-account' => '(blocada de creation de contos)',
	'regexblock-view-reason' => 'motivo: $1',
	'regexblock-view-reason-default' => 'motivo generic',
	'regexblock-view-block-infinite' => 'blocada permanente',
	'regexblock-view-block-by' => 'blocate per:',
	'regexblock-view-block-unblock' => 'disblocar',
	'regexblock-view-stats' => 'statisticas',
	'regexblock-view-empty' => 'Le lista de nomines e adresses blocate es vacue.',
	'regexblock-view-time' => 'le $1',
	'right-regexblock' => 'Blocar usatores de modificar in tote le wikis del ferma de wikis',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'regexblock' => 'Pemblokiran regex',
	'regexblock-already-blocked' => '$1 telah diblokir.',
	'regexblock-block-log' => "Nama pengguna atau alamat IP '''$1''' telah diblokir.",
	'regexblock-block-success' => 'Pemblokiran berhasil',
	'regexblock-currently-blocked' => 'Alamat yang sedang diblokir:',
	'regexblock-desc' => 'Ekstensi yang digunakan untuk memblokir pengguna nama dan alamat IP dengan ekspresi reguler. Berisi baik mekanisme pemblokiran dan suatu [[Special:Regexblock|halaman istimewa]] untuk menambah/mengelola blokir',
	'regexblock-expire-duration' => '1 jam,2 jam,4 jam,6 jam,1 hari,3 hari,1 minggu,2 minggu,1 bulan,3 bulan,6 bulan,1 tahun,selamanya',
	'regexblock-page-title' => 'Pemblokiran nama dengan ekspresi reguler',
	'regexblockstats' => 'Statistik pemblokiran regex',
	'regexblock-help' => 'Gunakan formulir di bawah untuk memblokir akses menulis dari alamat IP atau nama pengguna tertentu.
Gunakan ini hanya untuk mencegah vandalisme dan sesuai dengan kebijakan.
\'\'Halaman ini memungkinkan Anda untuk bahkan memblokir pengguna yang belum ada, dan juga akan memblokir pengguna dengan nama yang serupa dengan yang diberikan, yaitu "Pengujian" akan diblokir sebagaimana "Pengujian 2", dll.
Anda juga dapat memblokir seluruh alamat IP, yang berarti bahwa tidak ada yang bisa masuk log dan menyunting halaman.
Catatan: alamat IP parsial akan diperlakukan seperti nama pengguna dalam penentuan blokir.
Jika tidak ada alasan yang diberikan, suatu alasan generik baku akan digunakan.\'\'',
	'regexblock-page-title-1' => 'Blokir alamat menggunakan ekspresi reguler',
	'regexblock-reason-ip' => 'Alamat IP ini dicekal untuk menyunting karena vandalisme atau gangguan yang dilakukan oleh Anda atau orang lain yang berbagi IP dengan Anda.
Jika menurut Anda ini adalah suatu kesalahan, silakan [[$1|hubungi kami]]',
	'regexblock-reason-name' => 'Pengguna ini dicegah dari penyuntingan karena vandalisme atau kekacauan lain.
Jika anda percaya ini adalah kesalahan, silakan [[$1|hubungi kami]]',
	'regexblock-reason-regex' => 'Pengguna ini dicegah dari penyuntingan karena vandalisme atau kekacauan lain oleh pengguna dengan nama yang mirip.
Silakan buat nama pengguna lain atau [[$1|hubungi kami]] tentang permasalahan ini',
	'regexblock-form-username' => 'Alamat IP atau nama pengguna:',
	'regexblock-form-reason' => 'Alasan:',
	'regexblock-form-expiry' => 'Kedaluwarsa:',
	'regexblock-form-match' => 'Pertandingan tepat',
	'regexblock-form-account-block' => 'Blokir pembuatan akun baru',
	'regexblock-form-submit' => 'Blok pengguna ini',
	'regexblock-form-submit-empty' => 'Memberikan nama pengguna atau alamat IP yang dapat diblokir.',
	'regexblock-form-submit-regex' => 'Ekspresi regular tidak valid.',
	'regexblock-form-submit-expiry' => 'Tolong tentukan periode kedaluwarsa.',
	'regexblock-link' => 'blokir dengan ekspresi reguler',
	'regexblock-match-stats-record' => "$1 diblok '$2' pada '$3' saat '$4', masuk log dari alamat '$5'",
	'regexblock-nodata-found' => 'Tanggal tidak ditemukan',
	'regexblock-stats-title' => 'Statistik blokir regex',
	'regexblock-unblock-success' => 'Buka blokir berhasil',
	'regexblock-unblock-log' => "Nama pengguna atau alamat IP '''$1''' telah dibuka diblokirnya.",
	'regexblock-unblock-error' => 'Kesalahan buka blokir $1.
Mungkin tidak ada pengguna seperti itu.',
	'regexblock-regex-filter' => 'atau nilai regex:',
	'regexblock-view-blocked' => 'Lihat pemblokiran oleh:',
	'regexblock-view-all' => 'Semua',
	'regexblock-view-go' => 'Tuju ke',
	'regexblock-view-match' => '(pertandingan tepat)',
	'regexblock-view-regex' => '(kecocokan regex)',
	'regexblock-view-account' => '(pembuatan akun diblokir)',
	'regexblock-view-reason' => 'alasan: $1',
	'regexblock-view-reason-default' => 'alasan generik',
	'regexblock-view-block-infinite' => 'blok permanen',
	'regexblock-view-block-by' => 'diblokir oleh:',
	'regexblock-view-block-unblock' => 'buka blokir',
	'regexblock-view-stats' => 'stat',
	'regexblock-view-empty' => 'Daftar nama dan alamat yang diblokir kosong.',
	'regexblock-view-time' => 'pada $1',
	'right-regexblock' => 'Memblokir pengguna untuk menyunting pada semua wiki di kebun wiki',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'regexblock-form-reason' => 'Mgbághapụtà:',
	'regexblock-form-expiry' => 'Gbá okà:',
	'regexblock-view-all' => 'Haníle',
	'regexblock-view-go' => 'Gá',
	'regexblock-view-reason' => 'mgbáhàpụtá: $1',
	'regexblock-view-time' => 'na $1',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'regexblock-form-expiry' => 'Expiro:',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'regexblock-already-blocked' => '$1 er nú þegar í banni.',
	'regexblock-form-reason' => 'Ástæða:',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 */
$messages['it'] = array(
	'regexblock-block-log' => "Il nome utente o indirizzo IP '''$1''' è stato bloccato.",
	'regexblock-block-success' => 'Blocco eseguito',
	'regexblock-expire-duration' => '1 ora, 2 ore, 4 ore, 6 ore, 1 giorno, 3 giorni, 1 settimana, 2 settimane, 1 mese, 3 mesi, 6 mesi, 1 anno, infinito',
	'regexblock-form-username' => 'Indirizzo IP o nome utente:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Scadenza del blocco:',
	'regexblock-form-submit' => "Blocca l'utente",
	'regexblock-unblock-success' => 'Sblocco eseguito',
	'regexblock-view-all' => 'Tutti',
	'regexblock-view-go' => 'Vai',
	'regexblock-view-reason' => 'motivo: $1',
	'regexblock-view-block-infinite' => 'blocco permanente',
	'regexblock-view-block-by' => 'bloccato da:',
	'regexblock-view-block-unblock' => 'sblocca',
	'regexblock-view-stats' => 'statistiche',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'regexblock' => '正規表現ブロック',
	'regexblock-already-blocked' => '$1 は既にブロックされています。',
	'regexblock-block-log' => "利用者名もしくはIPアドレス '''$1''' はブロックされました。",
	'regexblock-block-success' => 'ブロックに成功しました',
	'regexblock-currently-blocked' => '現在ブロックされているアドレス:',
	'regexblock-desc' => '利用者名やIPアドレスを正規表現を使ってブロックするための拡張機能。ブロック機構とブロックを追加・管理するための[[Special:Regexblock|特別ページ]]の両方を含む',
	'regexblock-expire-duration' => '1時間,2時間,4時間,6時間,1日,3日,1週間,2週間,1か月,3か月,6か月,1年,無期限',
	'regexblock-page-title' => '正規表現による利用者名のブロック',
	'regexblockstats' => '正規表現ブロック統計',
	'regexblock-help' => '以下のフォームを使って特定のIPアドレスまたは利用者名からの書き込みアクセスをブロックします。これは荒らしを防ぐためのみになされるべきであり、方針と合致しているべきです。\'\'このページを使うとまだ存在していない利用者さえブロックすることができます。また、指定した名前に類似した利用者もブロックします。つまり、"Test" をブロックすると "Test 2" もブロックされます。また、完全なIPアドレスをブロックすることもできます。つまり、そこからログインしている誰も編集できないようにできるということです。注：部分的なIPアドレスはブロック決定過程において利用者名として処理されます。理由を指定しなかった場合は、既定の一般的な理由が使われます。\'\'',
	'regexblock-page-title-1' => '正規表現を使ってアドレスをブロックする',
	'regexblock-reason-ip' => 'あなた、もしくはあなたとIPアドレスを共有するだれかによる荒らしなどの破壊行為のため、このIPアドレスは編集が禁止されています。これが間違いだとお考えなら、[[$1|我々に連絡]]してください',
	'regexblock-reason-name' => 'この利用者名は荒らしなどの破壊行為のため編集が禁止されています。これが間違いだとお考えなら、[[$1|我々に連絡]]してください',
	'regexblock-reason-regex' => '類似した名前の利用者による荒らしなどの破壊行為のため、この利用者名は編集が禁止されています。別の名前でアカウントを作成されるか、この問題について[[$1|我々に連絡]]してください',
	'regexblock-form-username' => 'IPアドレスまたは利用者名：',
	'regexblock-form-reason' => '理由：',
	'regexblock-form-expiry' => '有効期限：',
	'regexblock-form-match' => '完全一致',
	'regexblock-form-account-block' => '新規アカウントの作成をブロックする',
	'regexblock-form-submit' => 'この利用者をブロックする',
	'regexblock-form-submit-empty' => 'ブロックする利用者名かIPアドレスを入力してください。',
	'regexblock-form-submit-regex' => '無効な正規表現です。',
	'regexblock-form-submit-expiry' => '期限を設定してください。',
	'regexblock-link' => '正規表現を使ってブロック',
	'regexblock-match-stats-record' => '$1 が $2 (アドレス $5) を $3 で $4 にブロックしました',
	'regexblock-nodata-found' => '該当データなし',
	'regexblock-stats-title' => '正規表現ブロックの統計',
	'regexblock-unblock-success' => 'ブロックの解除に成功しました',
	'regexblock-unblock-log' => "利用者名またはIPアドレス '''$1''' のブロックを解除しました。",
	'regexblock-unblock-error' => '$1 のブロック解除エラー。おそらく、その利用者は存在しません。',
	'regexblock-regex-filter' => ' あるいは正規表現:',
	'regexblock-view-blocked' => '指定した利用者によるブロックを表示:',
	'regexblock-view-all' => 'すべて',
	'regexblock-view-go' => '表示',
	'regexblock-view-match' => '(完全一致)',
	'regexblock-view-regex' => '(正規表現マッチ)',
	'regexblock-view-account' => '(アカウント作成ブロック)',
	'regexblock-view-reason' => '理由: $1',
	'regexblock-view-reason-default' => '一般の理由',
	'regexblock-view-block-infinite' => '無期限ブロック',
	'regexblock-view-block-by' => 'ブロック実行者:',
	'regexblock-view-block-unblock' => 'ブロック解除',
	'regexblock-view-stats' => '統計',
	'regexblock-view-empty' => 'ブロックされた利用者名とアドレスの一覧には項目がありません。',
	'regexblock-view-time' => '$1',
	'right-regexblock' => '利用者をウィキファーム上のすべてのウィキで投稿ブロックする',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'regexblock-already-blocked' => '$1 wis diblokir',
	'regexblock-block-log' => "Panganggo utawa alamat IP '''$1''' wis diblokir.",
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
	'regexblock-view-blocked' => 'Ndeleng diblokir déning:',
	'regexblock-view-all' => 'Kabèh',
	'regexblock-view-go' => 'Golèk',
	'regexblock-view-reason' => 'alesan: $1',
	'regexblock-view-reason-default' => 'alesan umum',
	'regexblock-view-block-infinite' => 'blokade permanèn',
	'regexblock-view-block-by' => 'diblokir déning:',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'regexblock-form-reason' => 'მიზეზი:',
);

/** Kalaallisut (Kalaallisut)
 * @author Qaqqalik
 */
$messages['kl'] = array(
	'regexblock-expire-duration' => '1 tiimi,2 tiimit,4 tiimit,6 tiimit,ulloq 1,ullut 3,sap akunn 1,sap akunn 2,1 qaammat,qaammatit 3,qaammatit 6,ukioq 1,killeqanngitsoq',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'regexblock-already-blocked' => '$1ត្រូវបានហាមឃាត់រួចហើយ។',
	'regexblock-block-log' => "អត្តនាមឬ អាសយដ្ឋានIP '''$1''' បានត្រូវរាំងខ្ទប់។",
	'regexblock-block-success' => 'រាំងខ្ទប់ដោយជោគជ័យ',
	'regexblock-currently-blocked' => 'អាសយដ្ឋានដែលត្រូវបានហាមឃាត់បច្ចុប្បន្ន៖',
	'regexblock-form-username' => 'អាសយដ្ឋានIP ឬអត្តនាម៖',
	'regexblock-form-reason' => 'មូលហេតុ៖',
	'regexblock-form-expiry' => 'ផុតកំណត់:',
	'regexblock-form-account-block' => 'រាំងខ្ទប់​ការបង្កើត​គណនី​ថ្មី',
	'regexblock-form-submit' => 'ហាមឃាត់អ្នកប្រើប្រាស់នេះ',
	'regexblock-form-submit-empty' => 'ផ្តល់អត្តនាមឬអាសយដ្ឋានIPដើម្បីហាមឃាត់។',
	'regexblock-form-submit-expiry' => 'សូម​ធ្វើការ​បញ្ជាក់​កាលបរិច្ឆេទ​ដែល​ត្រូវ​ផុតកំណត់​។',
	'regexblock-unblock-success' => 'បានឈប់ហាមឃាត់ដោយជោគជ័យ',
	'regexblock-unblock-log' => "អត្តនាមឬ អាសយដ្ឋាន IP '''$1''' បានត្រូវ​លែងរាំងខ្ទប់​។",
	'regexblock-view-blocked' => 'មើល​ការ​រាំងខ្ទប់​ដោយ:',
	'regexblock-view-all' => 'ទាំងអស់',
	'regexblock-view-go' => 'ទៅ',
	'regexblock-view-account' => '(រាំងខ្ទប់​ការបង្កើត​គណនី)',
	'regexblock-view-reason' => 'មូលហេតុ៖ $1',
	'regexblock-view-block-by' => 'ត្រូវបានរាំងខ្ទប់ដោយ៖',
	'regexblock-view-block-unblock' => 'ឈប់ហាមឃាត់',
	'regexblock-view-stats' => 'ស្ថិតិ',
	'regexblock-view-empty' => 'បញ្ជីអត្តនាមនិងអាសយដ្ឋានIPគឺទទេ។',
	'regexblock-view-time' => 'នៅ $1',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'regexblock-form-reason' => 'ಕಾರಣ:',
	'regexblock-view-all' => 'ಎಲ್ಲಾ',
	'regexblock-view-go' => 'ಹೋಗು',
);

/** Krio (Krio)
 * @author Jose77
 * @author Lloffiwr
 * @author Psubhashish
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

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'regexblock' => 'Sperre övver <i lang="en">regular expressions</i>',
	'regexblock-already-blocked' => '$1 es ald jesperrt.',
	'regexblock-block-log' => "Dä Metmaacher met däm Name '''\$1''' odder de <code lang=\"en\">IP</code>-Address es jesperrt woode.",
	'regexblock-block-success' => 'Jesperrt',
	'regexblock-currently-blocked' => 'Addresse, di em Momang jesperrt sin:',
	'regexblock-desc' => 'Määt et müjjelesch, Metmaacher  un IP-Addresse övver <i lang="en">regular expressions</i> ze sperre. Deit sperre, un hät en [[Special:Regexblock|Söndersigg]], öm de Sperre ze verwallde.',
	'regexblock-expire-duration' => '1 Stund:1 hour,2 Stund:2 hours,3 Stund:3 hours,6 Stund:6 hours,12 Stund:12 hours,1 Dach:1 day,3 Däch:3 days,1 Woch:1 week,2 Woche:2 weeks,3 Woche:3 weeks,1 Mond:1 month,3 Mond:3 months,6 Mond:6 months,9 Mond:9 months,1 Johr:1 year,2 Johre:2 years,3 Johre:3 years,Iewich:infinite',
	'regexblock-page-title' => 'Name Sperre övver <i lang="en">regular expressions</i>',
	'regexblockstats' => 'Statistike övver et {{int:Regexblock-page-title}}',
	'regexblock-help' => 'En hee däm Fommulaa kanns De en besptemmpte <code lang="en">IP</code>-Addreß odder enem Metmaacher singe Name shperre un dänne domet et Schriive em Wikki verbeede.
Dat sullt mer bloß donn, öm Kappottmaacherei ze verhindere, un nur noh dä Räjelle, di mer doför han.
\'\'Die Sigg hee määt et müjjelesch, Metmaacher ze shperre, die et (noch) nit jitt. Mer hann och leish Metmaacher met ähnlesche Name en einem Rötsch shperre. Zom Beishpell „Ens Versöke“ weet metjeshperrt, wam_mer „Ens Versöke 2“ shperre deiht, un esu wigger. Mer kann och janze <code lang="en">IP</code>-Addresse shperre, wat bedügg, dat keine, dä vun dä Addreß enlogge deiht, mieh Sigge ändere darf. Opjepaß: Hallve <code lang="en">IP</code>-Addresse wäde als Name vun Metmaachere aanjesinnf, wann et öm et Beshtemme vun Shperre jeiht. Wann keine Jrond för et Shperre aanjejovve es, weed ene Shtandatt-Tex jenumme.\'\'',
	'regexblock-page-title-1' => 'Addresse övver <i lang="en">regular expressions</i> sperre',
	'regexblock-reason-ip' => 'Et es jraad verbodde, met hee dä IP-Addräß aam Wiki jet ze ändere.
Dat litt dodraan, dat zoh vill Driß drövver jemaat wood.
Dat moß ävver nit vun Dir jekumme sin, et kann vun Jedem jekumme sin,
dä di Address och ens jehatt hät.
Wann De meins, dat dat esu nit sinn sullt, dann donn [[$1|Desch melde]].',
	'regexblock-reason-name' => 'Dä Metmaacher-Name es jesperrt un kann kei Sigge ändere.
För jewöhnlesch deiht dat bedügge, dat dä zevill Driß jemaat hät.
Wann de meins, dat es nit en Odenung, [[$1|lohß et uns weße]].',
	'regexblock-reason-regex' => 'Dä Metmaacher-Name es jesperrt un mer kann med em kei Sigge ändere.
Dat litt dodraan, dat zoh vill Driß övver ene janz äähnlijje Name jemaat wood.
Wann de meins, dat es nit en Odenung, [[$1|lohß et uns weße]], odder nemm janz ene andere Metmaacher-Name. Kanns jo flöck ene neue aanmelde.',
	'regexblock-form-username' => 'De <code lang="en">IP</code>-Addreß odder enem Metmacher singe Name:',
	'regexblock-form-reason' => 'Aanlass:',
	'regexblock-form-expiry' => 'Endt aam:',
	'regexblock-form-match' => 'Akkeraate Treffer',
	'regexblock-form-account-block' => 'Donn et neu Aanmelde verbeede',
	'regexblock-form-submit' => 'Donn dä Metmaacher Sperre',
	'regexblock-form-submit-empty' => 'Jiff enem Metmacher singe Name odder en <code lang="en">IP</code>-Addreß för zem Sperre aan.',
	'regexblock-form-submit-regex' => 'En onjöltijje <i lang="en">regular expression</i>.',
	'regexblock-form-submit-expiry' => 'Beß esu joot, un donn en Zick för et Engk fun de Shperr aanjevve.',
	'regexblock-link' => 'Schpärre övver <i lang="en">regular expression</i>e ennreschhte.',
	'regexblock-match-stats-record' => 'Dä Ußdrock „$1“ hät öm/aam $4 för en Sperr en „$3“ för {{GENDER:$2|dä|et|dä Metmaacher|dat|de}} „$2“ jesorrsch, beim Enlogge vun dä IP-Addreeß $5',
	'regexblock-nodata-found' => 'Kein Date jefonge',
	'regexblock-stats-title' => 'Shtatistike för de Shperre övver <i lang="en">regular expressions</i>',
	'regexblock-unblock-success' => 'Nimmieh jeshperrt',
	'regexblock-unblock-log' => "Dä Metmacher odder de <code lang=\"en\">IP</code>-Addreß '''„\$1“''' es widder frei jejovve.",
	'regexblock-unblock-error' => 'Fähler beim Sperr-Ophävve. Ene Metmaacher „<nowiki>$1</nowiki>“ jit et nit.',
	'regexblock-regex-filter' => ' odder en <i lang="en">regular expression</i>:',
	'regexblock-view-blocked' => 'Sök bloß de Sperre uß vun däm Metmaacher:',
	'regexblock-view-all' => 'All',
	'regexblock-view-go' => 'Lohß Jonn!',
	'regexblock-view-match' => '(akkeraat jetroffe)',
	'regexblock-view-regex' => '(<i lang="en">regular expression</i> jetroffe)',
	'regexblock-view-account' => '(Neu Aanmelde verbodde)',
	'regexblock-view-reason' => 'Jrund: $1',
	'regexblock-view-reason-default' => '— keine Jrund aanjejovve —',
	'regexblock-view-block-infinite' => 'för iewisch jesperrt',
	'regexblock-view-block-by' => 'Jesperrt vum:',
	'regexblock-view-block-unblock' => 'Sperr ophävve',
	'regexblock-view-stats' => 'Shtatistike',
	'regexblock-view-empty' => 'De Leß me de jesperrte Metmaacher ier Name un Adresse eß leddisch.',
	'regexblock-view-time' => 'aam $2 öm $3 Uhr',
	'right-regexblock' => 'Donn dänne Metmaacher en alle Wikis em eije Shtall voll Wikis et Äandere verbeede',
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
	'regexblock-desc' => "Erweiderung fir d'Späre vu Benotzernimm an IP-Adressen mat regulären Ausdréck. D'Erweiderung huet esouwuel e Spär-Mechansmus wéi och eng [[Special:Regexblock|Spezialsäit]] fir Spären derbäizesetzen/ze geréieren",
	'regexblock-expire-duration' => '1 Stonn,2 Stonnen, 4 Stonnen,6 Stonnen,1 Dag,3 Deeg,1 Woch,2 Wochen,1 Mount,3 Méint,6 Méint,1 Joer,onbegrenzt',
	'regexblock-page-title' => 'Spär vun engem Numm mat engem regulärem Ausdrock',
	'regexblockstats' => 'Regex Spärstatistiken',
	'regexblock-page-title-1' => 'Adress spären andem regulär Ausdréck (Regex) benotzt ginn',
	'regexblock-reason-ip' => "Dës IP-Adress ass wéinst Vandalismus oder anerem Schiedlechem Verhalen vun Iech oder engem Aneren dee mat Iech déi selwëscht IP-Adress deelt fir d'Änner vu Säite gespaart. Wann Dir mengt dëst fir e Feeler, da [[$1|kontaktéiert eis]] w.e.g.",
	'regexblock-reason-name' => 'Dëse Benotzernumm ass wéinst Vandalismus oder aus ähnlechen Ursaache gespaart an däerf keng Ännerunge maachen. 
Wann Dir iwwerzeecht sidd datt et sech ëm ee Feeler handelt, [[$1|kontaktéiert eis w.e.g.]]',
	'regexblock-reason-regex' => 'Dëse Benotzernumm ass wéint Vandalismus oder anerem schiedleche Verhale vun engem Benotzer mat engem ähnleche Benotzernumm gespaart fir Ännerungen a Säiten ze maachen. Wielt w.e.g. en anere Benotzernumm oder [[$1|kontaktéiert eis]] wéinst deem Problem.',
	'regexblock-form-username' => 'IP-Adress oder Benotzer:',
	'regexblock-form-reason' => 'Grond:',
	'regexblock-form-account-block' => 'Uleeë vun neie Benotzerkonte spären',
	'regexblock-form-submit' => 'Dëse Benotzer spären',
	'regexblock-form-submit-empty' => 'Gitt e Benotzernumm oder eng IP-Adress un fir ze spären.',
	'regexblock-form-submit-expiry' => "Gitt w.e.g. en Zäitraum fir d'Spär un.",
	'regexblock-match-stats-record' => "$1 huet '$2' de(n) '$3' ëm '$4' gespaart, ageloggt vun der Adress '$5'",
	'regexblock-nodata-found' => 'Keng Date fonnt',
	'regexblock-stats-title' => 'Regex Spärstatistik',
	'regexblock-unblock-success' => 'Spär opgehuewen',
	'regexblock-unblock-log' => "D'Spär vum Benotzer oder vun der IP-Adress '''$1'''' gouf opgehuewen.",
	'regexblock-unblock-error' => 'Feeler beim Ophiewe vun der Spär vum $1.
Warscheinlech gëtt et esou e Benotzer net.',
	'regexblock-view-blocked' => "Weis d'Späre vum:",
	'regexblock-view-all' => 'Alleguer',
	'regexblock-view-go' => 'Lass',
	'regexblock-view-regex' => '(Regex-Treffer)',
	'regexblock-view-account' => '(Opmaache vu Benotzerkonte gespaart)',
	'regexblock-view-reason' => 'Grond: $1',
	'regexblock-view-reason-default' => 'allgemenge Grond',
	'regexblock-view-block-infinite' => 'permanent Spär',
	'regexblock-view-block-by' => 'gespaart vum:',
	'regexblock-view-block-unblock' => 'Spär ophiewen',
	'regexblock-view-stats' => 'Statistik',
	'regexblock-view-empty' => "D'Lëscht vun de gespaarte Benotzer an IP-Adressen ass eidel.",
	'regexblock-view-time' => 'den $1',
	'right-regexblock' => 'Spär Benotzer fir Ännerungen op alle Wikiën vun der Wiki-Farm',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'regexblock-view-all' => 'Vysi',
);

/** Moksha (Мокшень)
 * @author Jarmanj Turtash
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
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'regexblock' => 'Блок по регуларен израз',
	'regexblock-already-blocked' => '$1 е веќе блокиран.',
	'regexblock-block-log' => "Корисничкото име или IP-адресата '''$1''' е блокирана.",
	'regexblock-block-success' => 'Блокирањето успеа',
	'regexblock-currently-blocked' => 'Моментално блокирани адреси:',
	'regexblock-desc' => 'Додаток за блокирање на кориснички имиња и IP-адреси со помош на регуларни изрази. Го содржи механизмот за блокирање и [[Special:Regexblock|специјална страница]] за давање/раководење со блокови',
	'regexblock-expire-duration' => '1 час,2 часа,4 часа,6 часа,1 ден,3 дена,1 недела,2 недели,1 месец,3 месеци,6 месеци,1 година,без рок',
	'regexblock-page-title' => 'Блокирање на име по регуларен израз',
	'regexblockstats' => 'Статистика за блок по регуларен израз',
	'regexblock-help' => "Користете го образецот подолу за блокирање на пристап кон уредување од извесна IP-адреса или корисничко име.
Ова треба да се употребува само за спречување на вандализам, и во согласност со правилата.
''Оваа страница ви овозможува да блокирате дури и непостоечки корисници, и да блокирате корисници со имиња слични на зададените, т.е. „Test“ ќе биде блокиран заедно со „Test 2“ и тн.
Можете и да блокирате полни IP-адреси, што значи дека ниеден корисник најавен со таа IP-адреса нема да може да уредува страници.
Напомена: делумните IP-адреси ќе се сметаат за кориснички имиња при одлучувањето дали да се даде блок.
Ако нема назначено причина, тогаш ќе се користи основно зададената општа причина.''",
	'regexblock-page-title-1' => 'Блокирање на адреси со помош на регуларни изрази',
	'regexblock-reason-ip' => 'На оваа IP-адреса ѝ е оневозможено уредување поради вандализам или други пореметувачки дејства направени од вас или или некој што ја користи истата IP-адреса.
Ако сметате дека ова е грешка, тогаш [[$1|контактирајте нè]]',
	'regexblock-reason-name' => 'На ова корисничко име е му е оневозможено да уредува поради вандализам или други пореметувачки дејства.
Ако сметате дека ова е грешка, [[$1|контактирајте нè]]',
	'regexblock-reason-regex' => 'На ова корисничко име му е оневозможено да уредува поради вандализам или други пореметувачки дејства од корисник со слично име.
Создајте друго корисничко име или [[$1|контактирајте нè]] во врска со овој проблем',
	'regexblock-form-username' => 'IP-адреса или корисничко име:',
	'regexblock-form-reason' => 'Причина:',
	'regexblock-form-expiry' => 'Истекува:',
	'regexblock-form-match' => 'Токму така',
	'regexblock-form-account-block' => 'Блокирање на создавањето на нови сметки',
	'regexblock-form-submit' => 'Блокирај го корисников',
	'regexblock-form-submit-empty' => 'Наведете корисничко име или IP-адреса за блокирање.',
	'regexblock-form-submit-regex' => 'Неважечки регуларен израз.',
	'regexblock-form-submit-expiry' => 'Назначете рок на истекување.',
	'regexblock-link' => 'блокирај со регуларен израз',
	'regexblock-match-stats-record' => '$1 го блокираше корисникот „$2“ на „$3“ на „$4“, најавувајќи се од адресата „$5“',
	'regexblock-nodata-found' => 'Нема пронајдено податоци',
	'regexblock-stats-title' => 'Статистики за блокирање со регуларен израз',
	'regexblock-unblock-success' => 'Одблокирањето успеа',
	'regexblock-unblock-log' => "Корисничкото име или IP-адресата '''$1''' е одблокирана.",
	'regexblock-unblock-error' => 'Грешка при одблокирање на $1.
Веројатно таков корисник не постои.',
	'regexblock-regex-filter' => 'или вредноста на регуларниот израз:',
	'regexblock-view-blocked' => 'Прегледај блокирани по:',
	'regexblock-view-all' => 'Сè',
	'regexblock-view-go' => 'Оди',
	'regexblock-view-match' => '(токму така)',
	'regexblock-view-regex' => '(совпаѓање со рег. израз)',
	'regexblock-view-account' => '(блок на создавање сметки)',
	'regexblock-view-reason' => 'причина: $1',
	'regexblock-view-reason-default' => 'општа причина',
	'regexblock-view-block-infinite' => 'бесконечен блок',
	'regexblock-view-block-by' => 'блокиран од:',
	'regexblock-view-block-unblock' => 'одблокирај',
	'regexblock-view-stats' => 'статистики',
	'regexblock-view-empty' => 'Списокот на блокирани имиња и адреси е празен.',
	'regexblock-view-time' => 'на $1',
	'right-regexblock' => 'Блокирање на корисници од уредување на сите викија на вики-фармата',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'regexblock-already-blocked' => '$1 ഇതിനകം തന്നെ തടയപ്പെട്ടിരിക്കുന്നു.',
	'regexblock-block-log' => "'''$1''' എന്ന ഉപയോക്തൃനാമം അല്ലെങ്കിൽ ഐ.പി. വിലാസം തടയപ്പെട്ടിരിക്കുന്നു.",
	'regexblock-block-success' => 'തടയൽ വിജയിച്ചിരിക്കുന്നു',
	'regexblock-currently-blocked' => 'നിലവിൽ തടയപ്പെട്ട വിലാസങ്ങൾ:',
	'regexblock-reason-ip' => 'താങ്കളോ മറ്റോരോ നടത്തിയ നശീകരണ പ്രവർത്തനം മൂലം താങ്കൾ ഇപ്പോൾ ഉപയോഗിക്കുന്ന ഐ.പി. വിലാസം തിരുത്തൽ നടത്തുന്നതിൽ നിന്നു തടയപ്പെട്ടിരിക്കുന്നു.
ഇത് ഒരു പിഴവാണെന്നു താങ്കൾ കരുതുന്നെങ്കിൽ ദയവായി [[$1|ഞങ്ങളെ ബന്ധപ്പെടുക]]',
	'regexblock-reason-name' => 'നശീകരണ പ്രവർത്തനങ്ങൾ മൂലം താങ്കളുടെ ഉപയോക്തൃനാമത്തെ തിരുത്തൽ നടത്തുന്നതിൽ നിന്നു തടഞ്ഞിരിക്കുന്നു. ഇതൊരു പിഴവാണെന്നു താങ്കൾ കരുതുന്നെങ്കിൽ ദയവായി [[$1|ഞങ്ങളെ ബന്ധപ്പെടുക]]',
	'regexblock-reason-regex' => 'ഈ ഉപയോക്തൃനാമത്തോടു സാമ്യമുള്ള ഉപയോക്താവിന്റെ നശീകരണ പ്രവർത്തനങ്ങൾ മൂലം ഈ ഉപയോക്തൃനാമത്തെ തിരുത്തൽ നടത്തുന്നതിൽ നിന്നു തടഞ്ഞിരിക്കുന്നു. 
ഒന്നുകിൽ പുതിയ ഉപയോക്തൃനാമം ഉണ്ടാക്കുക അല്ലെങ്കിൽ ഈ പ്രശ്നത്തെക്കുറിച്ച് [[$1|ഞങ്ങളെ അറിയിക്കുക]]',
	'regexblock-form-username' => 'ഐ.പി. വിലാസം അല്ലെങ്കിൽ ഉപയോക്തൃനാമം:',
	'regexblock-form-reason' => 'കാരണം:',
	'regexblock-form-expiry' => 'കാലാവധി:',
	'regexblock-form-match' => 'കൃത്യമായി യോജിക്കുന്നവ',
	'regexblock-form-account-block' => 'പുതിയ അംഗത്വങ്ങൾ സൃഷ്ടിക്കുന്നതു തടയുക',
	'regexblock-form-submit' => ' ഈ  ഉപയോക്താവിനെ തടയുക',
	'regexblock-form-submit-empty' => 'തടയുവാൻ വേണ്ടിയുള്ള ഉപയോക്തൃനാമമോ ഐ.പി. വിലാസമോ ചേർക്കുക.',
	'regexblock-form-submit-expiry' => 'ദയവായി തടയലിനു ഒരു കാലാവധി തിരഞ്ഞെടുക്കുക.',
	'regexblock-unblock-success' => 'സ്വതന്ത്രമാക്കൽ വിജയിച്ചിരിക്കുന്നു',
	'regexblock-unblock-log' => "'''$1''' എന്ന ഉപയോക്തൃനാമം അല്ലെങ്കിൽ ഐ.പി.വിലാസം സ്വതന്ത്രമാക്കിയിരിക്കുന്നു.",
	'regexblock-unblock-error' => '$1നെ സ്വതന്ത്രമാക്കുന്നതിൽ പിഴവ്. അങ്ങനെയൊരു ഉപയോക്താവ് നിലവിലില്ലായിരിക്കും എന്നതാവും കാരണം.',
	'regexblock-view-all' => 'എല്ലാം',
	'regexblock-view-go' => 'പോകൂ',
	'regexblock-view-match' => '(കൃത്യമായി യോജിക്കുന്നവ)',
	'regexblock-view-account' => '(അംഗത്വം സൃഷ്ടിക്കുന്നതു തടയൽ)',
	'regexblock-view-reason' => 'കാരണം: $1',
	'regexblock-view-reason-default' => 'സാമാന്യമായ കാരണം',
	'regexblock-view-block-infinite' => 'സ്ഥിരമായ തടയൽ',
	'regexblock-view-block-by' => 'തടഞ്ഞത്:',
	'regexblock-view-block-unblock' => 'സ്വതന്ത്രമാക്കുക',
	'regexblock-view-time' => '$1 ന്‌',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'regexblock-form-reason' => 'Шалтгаан:',
	'regexblock-view-all' => 'Бүгдийг',
	'regexblock-view-go' => 'Явах',
);

/** Marathi (मराठी)
 * @author Htt
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
	'regexblock-reason-ip' => 'ह्या आयपी अंकपत्त्याला संपादनांपासून रोखण्यात आलेले आहे कारण तुम्ही अथवा इतर कोणीतरी या आयपी अंकपत्त्यावरून केलेला उत्पात आहेत.
जर तुमच्या मते हे चुकून झाले आहे, तर [[$1|आमच्याशी संपर्क साधा]]',
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
	'regexblock-view-block-by' => 'ब्लॉक कर्ता:',
	'regexblock-view-block-unblock' => 'अनब्लॉक',
	'regexblock-view-stats' => 'सांख्यिकी',
	'regexblock-view-empty' => 'ब्लॉक केलेल्या सदस्यनाव तसेच आयपी अंकपत्त्यांची यादी रिकामी आहे.',
	'regexblock-view-time' => '$1 वर',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 */
$messages['ms'] = array(
	'regexblock-form-reason' => 'Sebab:',
	'regexblock-form-expiry' => 'Tamat:',
	'regexblock-view-all' => 'Semua',
	'regexblock-view-go' => 'Pergi',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'regexblock-already-blocked' => '"$1" diġà bblokkjat',
	'regexblock-expire-duration' => 'siegħa,sagħtejn,4 sigħat,6 sigħat,ġurnata,3 ġranet,ġimgħa,ġimgħatejn,xahar,3 xhur,6 xhur,sena,infinta',
	'regexblock-view-go' => 'Mur',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'regexblock-already-blocked' => '"$1" уш саймас саезь.',
	'regexblock-form-reason' => 'Тувталось:',
	'regexblock-form-expiry' => 'Таштомома шказо:',
	'regexblock-view-all' => 'Весе',
	'regexblock-view-go' => 'Адя',
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
	'regexblock-view-stats' => 'tlapōhualli',
	'regexblock-view-time' => 'īpan $1',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'regexblock' => 'Regex-blokkering',
	'regexblock-already-blocked' => '«$1» er allerede blokkert',
	'regexblock-block-log' => "Brukeren '''$1''' har blitt blokkert.",
	'regexblock-block-success' => 'Blokkering lyktes',
	'regexblock-currently-blocked' => 'Nåværende blokkerte adresser:',
	'regexblock-desc' => 'Utvidelse som brukes for å blokkere brukernavn og IP-adresser ved hjelp av regulære uttrykk. Inneholder både blokkeringsmekanismen og en [[Special:Regexblock|spesialside]] for å legge til og endre blokkeringer',
	'regexblock-expire-duration' => 'én time,2 timer,fire timer,seks timer,én dag,tre dager,én uke,to uker,én måned,tre måneder,seks måneder, ett år, uendelig',
	'regexblock-page-title' => 'Tittelblokkering ved hjelp av regulære uttrykk',
	'regexblockstats' => 'Regex-blokkeringsstatistikk',
	'regexblock-help' => "Bruk skjemaet nedenfor for å blokkere visse IP-adresser eller brukernavn fra å redigere. Dette burde gjøres kun for å forhindre hærverk, og i følge med retningslinjene. ''Denne siden vil la deg blokkere også ikke-eksisterende brukere, og vil også blokkere brukere med navn som ligner det som blir gitt. F.eks. vil «Test» blokkeres sammen med «Test 2» osv. Du kan også blokkere fulle IP-adresser, hvilket betyr at ingen som logger på via disse kan redigere sider. Merk delvise IP-adresser vil behandles som brukernavn under blokkering. Om ingen begrunnelse oppgis vil en standardbegrunnelse bli brukt.''",
	'regexblock-page-title-1' => 'Blokker adresse ved hjelp av regulære uttrykk',
	'regexblock-reason-ip' => 'Denne IP-adressen er hindret fra å redigere på grunn av hærverk eller annen forstyrrelse av deg eller noen andre som bruker samme IP-adresse. Om du mener dette er en feil, vennligst [[$1|kontakt oss]]',
	'regexblock-reason-name' => 'Dette brukernavnet er hindret fra å redigere på grunn av hærverk eller annen forstyrrelse. Om du mener dette er en feil, vennligst [[$1|kontakt oss]]',
	'regexblock-reason-regex' => 'Dette brukernavnet er forhindret fra redigering på grunn av hærverk eller annen forstyrrelse av en bruker med lignende navn. Vennligst opprett et annet brukernavn eller [[$1|kontakt oss]] om problemet.',
	'regexblock-form-username' => 'IP-adresse eller brukernavn:',
	'regexblock-form-reason' => 'Årsak:',
	'regexblock-form-expiry' => 'Varighet:',
	'regexblock-form-match' => 'Nøyaktig treff',
	'regexblock-form-account-block' => '{{int:ipbcreateaccount}}',
	'regexblock-form-submit' => 'Blokker denne brukeren',
	'regexblock-form-submit-empty' => 'Angi et brukernavn eller en IP-adresse å blokkere.',
	'regexblock-form-submit-regex' => 'Ugyldig regulært uttrykk',
	'regexblock-form-submit-expiry' => 'Angi en utløpstid.',
	'regexblock-link' => 'blokker med et regulært uttrykk',
	'regexblock-match-stats-record' => "$1 blokkerte '$2' på '$3' den '$4',fra IP-adressen '$5'",
	'regexblock-nodata-found' => 'Ingen data funnet',
	'regexblock-stats-title' => 'Statistikk for blokkering med regulære uttrykk',
	'regexblock-unblock-success' => 'Avblokkering lyktes',
	'regexblock-unblock-log' => "Brukernavnet eller IP-adressen '''$1''' er blitt avblokkert",
	'regexblock-unblock-error' => 'Feil under avblokkering av $1. Det er trolig ingen brukere med det navnet.',
	'regexblock-regex-filter' => ' eller regex-verdi:',
	'regexblock-view-blocked' => 'Vis de blokkerte etter:',
	'regexblock-view-all' => 'Alle',
	'regexblock-view-go' => '{{int:Go}}',
	'regexblock-view-match' => '(nøyaktig treff)',
	'regexblock-view-regex' => '(regex-treff)',
	'regexblock-view-account' => '(kontooppretting slått av)',
	'regexblock-view-reason' => 'begrunnelse: $1',
	'regexblock-view-reason-default' => 'generisk grunn',
	'regexblock-view-block-infinite' => 'permanent blokkering',
	'regexblock-view-block-by' => 'blokkert av:',
	'regexblock-view-block-unblock' => 'avblokker',
	'regexblock-view-stats' => 'statistikk',
	'regexblock-view-empty' => 'listen over blokkerte navn og adresser er tom.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Blokker brukere fra å endre på alle wikier på wiki-farmen',
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
	'regexblock-reason-ip' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken wegens vandalisme of verstoring door u of door iemand met hetzelfde IP-adres.
Als u denk dat dit ten onrechte is, [[$1|neem dan contact met ons op]].',
	'regexblock-reason-name' => 'Deze gebruiker mag niet bewerken wegens vandalisme of verstoring.
Als u denkt dat dit ten onrechte is, [[$1|neem dan contact met ons op]]',
	'regexblock-reason-regex' => 'Deze gebruiker mag niet bewerken wegens vandalisme of verstoring door een gebruiker met een gelijkluidende naam.
Kies een andere gebruikersnaam of [[$1|neem contact met ons op]] over het probleem',
	'regexblock-form-username' => 'IP-adres of gebruikersnaam:',
	'regexblock-form-reason' => 'Reden:',
	'regexblock-form-expiry' => 'Vervalt:',
	'regexblock-form-match' => 'Voldoet precies',
	'regexblock-form-account-block' => 'Het aanmaken van nieuwe gebruikers blokkeren',
	'regexblock-form-submit' => 'Deze gebruiker blokkeren',
	'regexblock-form-submit-empty' => 'Geef een gebruikersnaam of een IP-adres om te blokkeren.',
	'regexblock-form-submit-regex' => 'Ongeldige reguliere uitdrukking.',
	'regexblock-form-submit-expiry' => 'Geef een vervaltermijn op.',
	'regexblock-link' => 'blokkeren met reguliere expressies',
	'regexblock-match-stats-record' => '$1 blokkeerde "$2" op "$3" om "$4", werkend via IP-adres "$5"',
	'regexblock-nodata-found' => 'Er zijn geen gegevens aangetroffen',
	'regexblock-stats-title' => 'Regex-blokkeringsstatistieken',
	'regexblock-unblock-success' => 'Het deblokkeren is gelukt',
	'regexblock-unblock-log' => "Gebruikersnaam of IP-adres '''$1''' zijn gedeblokkeerd.",
	'regexblock-unblock-error' => 'Een fout bij het deblokkeren van $1. Waarschijnlijk bestaat er geen gebruiker met die naam.',
	'regexblock-regex-filter' => 'of reguliere expressiewaarde:',
	'regexblock-view-blocked' => 'Blokkades weergeven door:',
	'regexblock-view-all' => 'Alles',
	'regexblock-view-go' => 'OK',
	'regexblock-view-match' => '(voldoet precies)',
	'regexblock-view-regex' => '(voldoet aan regex)',
	'regexblock-view-account' => '(blokkade aanmaken gebruikers)',
	'regexblock-view-reason' => 'reden: $1',
	'regexblock-view-reason-default' => 'algemene reden',
	'regexblock-view-block-infinite' => 'permanente blokkade',
	'regexblock-view-block-by' => 'geblokkeerd door:',
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
	'regexblock-expire-duration' => 'éin time,to timar,fire timar,seks timar,éin dag,tre dagar,éi veka,to veker,éin månad,tre månader,seks månader,eitt år,endelaus',
	'regexblock-page-title' => 'Namneblokkering ved hjelp av regulært uttrykk',
	'regexblockstats' => 'Regex-blokkeringsstatistikk',
	'regexblock-help' => "Nytt skjemaet nedanfor for å hindra visse IP-adresser eller brukarnamn frå å endra. 
Dette bør berre bli gjort for å hindra hærverk, og i følgje med retningslinene. 
''Denne sida vil la deg òg blokkera ikkje-eksisterande brukarar, og vil òg blokkera brukarar med namn som liknar det som blir oppgjeve. Til dømes vil «Test» bli blokkert saman med «Test 2» osb. 
Du kan òg blokkera fulle IP-adresser, noko som tyder at ingen som loggar på gjennom desse kan endra sider. 
Merk: delvise IP-adresser vil bli handsama som brukarnamn under blokkering. Om ingen årsak er oppgjeven vil ein standardårsak bli nytta.''",
	'regexblock-page-title-1' => 'Blokker adressa ved hjelp av regulære uttrykk',
	'regexblock-reason-ip' => 'Denne IP-adressa er hindra frå å endra sider grunna hærverk eller anna forstyrring av deg eller andre som nyttar den same IP-adressa. [[$1|Kontakt oss]] om du meiner at dette er ein feil.',
	'regexblock-reason-name' => 'Brukarnamnet ditt er hindra frå å endra sider grunna hærverk eller anna forstyrring.
[[$1|Kontakt oss]] om du meiner at dette er ein feil.',
	'regexblock-reason-regex' => 'Dette brukarnamnet er hindra frå å endra sider grunna hærverk eller anna forstyrring av ein brukar med eit liknande namn. 
Opprett eit anna brukarnamn eller [[$1|kontakt oss]] om problemet.',
	'regexblock-form-username' => 'IP-adressa eller brukarnamn:',
	'regexblock-form-reason' => 'Årsak:',
	'regexblock-form-expiry' => 'Opphøyrstid:',
	'regexblock-form-match' => 'Nøyaktig treff',
	'regexblock-form-account-block' => 'Blokker oppretting av nye kontoar',
	'regexblock-form-submit' => 'Blokker denne brukaren',
	'regexblock-form-submit-empty' => 'Oppgje eit brukarnamn eller ei IP-adressa til å blokkera.',
	'regexblock-form-submit-regex' => 'Ugyldig regulært uttrykk.',
	'regexblock-form-submit-expiry' => 'Oppgje ei tid for enden på blokkeringa.',
	'regexblock-link' => 'blokker med regulærutrykk',
	'regexblock-match-stats-record' => '$1 blokkerte «$2» på «$3» den «$4», frå IP-adressa «$5»',
	'regexblock-nodata-found' => 'Fann ingen data',
	'regexblock-stats-title' => 'Statistikk for blokkering med regulære uttrykk',
	'regexblock-unblock-success' => 'Avblokkering lukkast',
	'regexblock-unblock-log' => "Brukarnamnet eller IP-adressa '''$1''' har blitt avblokkert.",
	'regexblock-unblock-error' => 'Det oppstod ein feil under avblokkeringa av $1. 
Truleg finst det ingen brukar med dette namnet.',
	'regexblock-regex-filter' => ' eller regex-verdi:',
	'regexblock-view-blocked' => 'Syn dei blokkerte etter:',
	'regexblock-view-all' => 'Alle',
	'regexblock-view-go' => 'Gå',
	'regexblock-view-match' => '(nøyaktig treff)',
	'regexblock-view-regex' => '(regex-treff)',
	'regexblock-view-account' => '(kontooppretting slege av)',
	'regexblock-view-reason' => 'årsak: $1',
	'regexblock-view-reason-default' => 'generisk årsak',
	'regexblock-view-block-infinite' => 'permanent blokkering',
	'regexblock-view-block-by' => 'blokkert av:',
	'regexblock-view-block-unblock' => 'avblokker',
	'regexblock-view-stats' => 'statistikk',
	'regexblock-view-empty' => 'Lista over blokkerte namn og adresser er tom.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Blokker brukarar frå å endra på alle wikiane i wikisamlinga',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'regexblock-form-reason' => 'Resone:',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'regexblock-block-log' => "Leina la mošomiši goba IP atrese '''$1''' e thibilwe.",
	'regexblock-form-username' => 'IP Atrese goba leina la mošomiši:',
	'regexblock-form-reason' => 'Lebaka:',
	'regexblock-form-submit-empty' => 'Efa leina la mošomiši goba IP atrese go thiba.',
	'regexblock-view-all' => 'Kamoka',
	'regexblock-view-go' => 'Sepela',
	'regexblock-view-reason' => 'lebaka: $1',
	'regexblock-view-block-by' => 'thibilwe ke:',
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
	'regexblock-expire-duration' => '1 ora,2 oras,4 oras,6 oras,1 jorn,3 jorns,1 setmana,2 setmanas,1 mes,3 meses,6 meses,1 an,infinit',
	'regexblock-page-title' => 'Blocatge d’un nom per una expression regulara',
	'regexblockstats' => 'Estatisticas suls blocatges per expressions regularas',
	'regexblock-help' => "Utilizatz lo formulari çaijós per blocar l’accès en escritura una adreça IP o un nom d’utilizaire. Aquò deu èsser fach unicament per evitar tot vandalisme e conformadament a las règlas prescrichas sul projècte. ''Aquesta pagina vos autoriza quitament a blocar d'utilizaires pas enregistrats e permet tanben de blocar d'utilizaires que presentan de noms similars. Per exemple, « Tèst » serà blocada al meteis temps que « Tèst 2 » etc. Tanben podètz blocar d'adreças IP entièras, çò que significa que degun que trabalha pas dempuèi elas poirà pas editar de paginas. Nòta : d'adreças IP parcialas seràn consideradas coma de noms d’utilizaire al moment del blocatge. Se cap de motiu es pas indicat en comentari, un motiu per defaut serà indicat.''",
	'regexblock-page-title-1' => 'Blocatge d’una adreça utilizant una expression regulara',
	'regexblock-reason-ip' => 'Aquesta adreça IP es apartada de tota edicon per causa de vandalisme o autres faches analògs per vos o qualqu’un mai que pertatja vòstra adreça IP. 
Se sètz segur{{GENDER:||a|}} que s’agís d’una error, [[$1|contactatz-nos]]',
	'regexblock-reason-name' => 'Aqueste utilizaire es apartat de tota edicion per causa de vandalisme o autres faches analògs.
Se sètz segur{{GENDER:||a}} que s’agís d’una error, [[$1|contactatz-nos]].',
	'regexblock-reason-regex' => "Aqueste utilizaire es apartat de tota edicion per causa de vandalisme o autres faches analògs per un utilizaire qu'a un nom similar. Creatz un autre compte o [[$1|contactatz-nos]] per senhalar lo problèma.",
	'regexblock-form-username' => 'Adreça IP o Utilizaire :',
	'regexblock-form-reason' => 'Motiu :',
	'regexblock-form-expiry' => 'Expiracion :',
	'regexblock-form-match' => 'Tèrme exacte',
	'regexblock-form-account-block' => 'Interdire la creacion d’un compte novèl.',
	'regexblock-form-submit' => 'Blocar aqueste Utilizaire',
	'regexblock-form-submit-empty' => 'Indicatz un nom d’utilizaire o una adreça IP de blocar.',
	'regexblock-form-submit-regex' => 'Expression regulara incorrècta.',
	'regexblock-form-submit-expiry' => 'Precisatz un periòde d’expiracion.',
	'regexblock-link' => 'blocar amb una expression racionala',
	'regexblock-match-stats-record' => "$1 a blocat « $2 » lo « $3 » a « $4 », connectat dempuèi l'adreça « $5 »",
	'regexblock-nodata-found' => 'Cap de donada pas trobada',
	'regexblock-stats-title' => 'Estatisticas dels blocatges per expressions regularas',
	'regexblock-unblock-success' => 'Lo desblocatge a capitat',
	'regexblock-unblock-log' => "L’utilizaire o l’adreça IP '''$1''' es estat desblocat.",
	'regexblock-unblock-error' => 'Error de deblocatge de $1. L’utilizaire existís probablament pas.',
	'regexblock-regex-filter' => '  o una expression racionala :',
	'regexblock-view-blocked' => 'Veire los blocatges per :',
	'regexblock-view-all' => 'Totes',
	'regexblock-view-go' => 'Amodar',
	'regexblock-view-match' => '(tèrme exacte)',
	'regexblock-view-regex' => '(expression regulara)',
	'regexblock-view-account' => '(creacion dels comptes blocada)',
	'regexblock-view-reason' => 'motiu : $1',
	'regexblock-view-reason-default' => 'cap de motiu indicat',
	'regexblock-view-block-infinite' => 'blocatge permanent',
	'regexblock-view-block-by' => 'blocat per :',
	'regexblock-view-block-unblock' => 'desblocar',
	'regexblock-view-stats' => 'estatisticas',
	'regexblock-view-empty' => 'La lista dels utilizaires e de las adreças IP blocats es voida.',
	'regexblock-view-time' => 'lo $1',
	'right-regexblock' => 'Blocar en escritura los utilizaires sus totes los wikis de la bòria wiki',
);

/** Ossetic (Ирон)
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

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'regexblock-form-username' => 'IP-Adress odder Yuusernaame:',
	'regexblock-form-reason' => 'Grund:',
	'regexblock-view-all' => 'All',
	'regexblock-view-go' => 'Geh los',
	'regexblock-view-reason' => 'Grund: $1',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'regexblock' => 'Blokada z użyciem wyrażenia regularnego',
	'regexblock-already-blocked' => '$1 jest już zablokowany.',
	'regexblock-block-log' => "Nazwa użytkownika lub adres IP '''$1''' zostały zablokowane.",
	'regexblock-block-success' => 'Pomyślnie zablokowano',
	'regexblock-currently-blocked' => 'Obecnie zablokowane adresy:',
	'regexblock-desc' => 'Rozszerzenie umożliwiające blokowanie nazw użytkowników oraz adresów IP opisanych wyrażeniami regularnymi. Zawiera mechanizm blokujący oraz [[Special:Regexblock|stronę specjalną]] dla dodawania i zarządzania blokadami',
	'regexblock-expire-duration' => '1 godzina,2 godziny,4 godziny,6 godzin,1 dzień,3 dni,1 tydzień,2 tygodnie,1 miesiąc,3 miesiące,6 miesięcy,1 rok,na zawsze',
	'regexblock-page-title' => 'Blokada nazwy z użyciem wyrażenia regularnego',
	'regexblockstats' => 'Statystyki blokad z użyciem wyrażeń regularnych',
	'regexblock-help' => "Użyj poniższego formularza do zablokowania możliwości wykonywania zapisu określonemu użytkownikowi lub spod wskazanego adresu IP.
Powinno być to wykonywane zgodnie z obowiązującymi zasadami, wyłącznie w celu zapobiegania wandalizmom.
''Na tej stronie możesz zablokować również nieistniejące konta użytkowników oraz konta o nazwach podobnych do zadanej, „Test” zostanie zablokowany razem z „Test 2” itd.
Możesz również zablokować adresy IP, co spowoduje, że nikt bez zalogowania nie będzie mógł z nich edytować stron.
Uwaga: adresy IP będą traktowane jak nazwa użytkownika w celu ustalenia blokowania.
Jeżeli nie podano powodu blokady, zostaniu użyty domyślny typowy opis blokady.''",
	'regexblock-page-title-1' => 'Zablokuj adres, używając wyrażenia regularnego',
	'regexblock-reason-ip' => 'Ten adres IP został zablokowany z powodu wandalizmu lub innego naruszenia zasad przez Ciebie lub przez kogoś, z kim współdzielisz ten adres IP.
Jeżeli uważasz, że nastąpiła pomyłka [[$1|skontaktuj się z nami]]',
	'regexblock-reason-name' => 'Nazwa użytkownika została zablokowana z powodu wandalizmu lub innego naruszenia zasad.
Jeżeli uważasz, że nastąpiła pomyłka [[$1|skontaktuj się z nami]]',
	'regexblock-reason-regex' => 'Nazwa użytkownika została zablokowana z powodu wandalizmu lub innego naruszenia zasad, wykonanych przez użytkownika o bardzo podobnej nazwie.
Utwórz inną nazwę użytkownika lub [[$1|skontaktuj się z nami]] w celu rozwiązania problemu.',
	'regexblock-form-username' => 'Adres IP lub nazwa użytkownika:',
	'regexblock-form-reason' => 'Powód',
	'regexblock-form-expiry' => 'Czas blokady:',
	'regexblock-form-match' => 'Dokładnie',
	'regexblock-form-account-block' => 'Zablokuj możliwość tworzenia nowych kont',
	'regexblock-form-submit' => 'Zablokuj użytkownika',
	'regexblock-form-submit-empty' => 'Podaj nazwę użytkownika lub adres IP do zablokowania.',
	'regexblock-form-submit-regex' => 'Nieprawidłowe wyrażenie regularne',
	'regexblock-form-submit-expiry' => 'Określ czas zakończenia blokady.',
	'regexblock-link' => 'blokada z wykorzystaniem wyrażenia regularnego',
	'regexblock-match-stats-record' => '$1 zablokowało „$2” w „$3” o „$4”, zalogowanego „$5”',
	'regexblock-nodata-found' => 'Nie odnaleziono danych',
	'regexblock-stats-title' => 'Statystyki blokad z użyciem wyrażeń regularnych',
	'regexblock-unblock-success' => 'Odblokowano',
	'regexblock-unblock-log' => "Użytkownik lub adres IP '''$1''' został odblokowany.",
	'regexblock-unblock-error' => 'Błąd przy odblokowaniu $1.
Prawdopodobnie brak takiego użytkownika.',
	'regexblock-regex-filter' => ' lub wyrażenie regularne',
	'regexblock-view-blocked' => 'Pokaż zablokowanych, posortowanych według',
	'regexblock-view-all' => 'Wszystkie',
	'regexblock-view-go' => 'Przejdź',
	'regexblock-view-match' => '(dokładnie)',
	'regexblock-view-regex' => '(dopasowanie wyrażenia regularnego)',
	'regexblock-view-account' => '(blokada tworzenia konta)',
	'regexblock-view-reason' => 'powód: $1',
	'regexblock-view-reason-default' => 'typowa przyczyna',
	'regexblock-view-block-infinite' => 'blokada stała',
	'regexblock-view-block-by' => 'zablokowany przez',
	'regexblock-view-block-unblock' => 'odblokuj',
	'regexblock-view-stats' => 'statystyki',
	'regexblock-view-empty' => 'Lista zablokowanych nazw i adresów jest pusta.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Blokowanie użytkownikom możliwości edycji na wszystkich wiki w obrębie farmy',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'regexblock' => 'Blocagi regex',
	'regexblock-already-blocked' => "$1 a l'é già blocà",
	'regexblock-block-log' => "Ël nòm utent o l'adrëssa IP '''$1''' a l'é stàit blocà.",
	'regexblock-block-success' => 'Blocagi bin fàit',
	'regexblock-currently-blocked' => 'Adrësse blocà al moment:',
	'regexblock-desc' => 'Estension dovrà për bloché nòm utent e adrësse IP con espression regolar. A conten ël mecanism ëd blocagi e na [[Special:Regexblock|pàgina special]] për gionté/gestì ij blocagi.',
	'regexblock-expire-duration' => '1 ora, 2 ore, 4 ore, 6 ore, 1 di, 3 di, 1 sman-a, 2 sman-e, 1 mèis, 3 mèis, 6 mèis, 1 ann, sensa fin',
	'regexblock-page-title' => "Blocagi dël nòm con n'espression regolar",
	'regexblockstats' => 'Statìstiche ëd blocagi regex',
	'regexblock-help' => "Deuvra ël formolari sì-sota për bloché l'acess an scritura a na specìfica adrëssa IP o nòm utent.
Sòn a dovrìa esse fàit mach për evité vandalism, e d'acòrdi con ij deuit.
''Sta pàgina-sì at përmët ëd bloché ëdcò utent pa esistent, e a blòca ëdcò utent con nòm smijant a col dàit, visadì \"Test\" a sarà blocà ansema a \"Test 2\" e via fòrt.
It peule ëdcò bloché adrësse IP, visadì che pi gnun intrand da lì a podrà modifiché dle pàgine.
Nòta: adrësse IP parsiaj a saran tratà com nòm utent për determiné ël blocagi.
Se gnun-e rason a son specificà, a sarà dovrà na rason genérica stàndard.''",
	'regexblock-page-title-1' => 'Blòca adrëssa an dovrand espression regolar',
	'regexblock-reason-ip' => "St'adrëssa IP-sì a peul pa modifiché për vandalism o àutr dann fàit da ti o da cheicun che a condivid  toa adrëssa IP.
S'it chërde che son a sia n'eror, për piasì [[$1|contatne]]",
	'regexblock-reason-name' => "Sto nòm utent-sì a peul pa modifiché për vandalism o àutr dann.
S'it chërde che a sia n'eror, për piasì [[$1|contatne]]",
	'regexblock-reason-regex' => "Sto nòm utent-sì a peul pa modifichè për vandalism o àutr dann fàit na n'utent con nòm ësmijant.
Për piasì crea n'àutr nòm utent o [[$1|contatne]] për parlé dël problema.",
	'regexblock-form-username' => 'Adrëssa IP o nòm utent:',
	'regexblock-form-reason' => 'Rason:',
	'regexblock-form-expiry' => 'Fin:',
	'regexblock-form-match' => 'Pròpi istess',
	'regexblock-form-account-block' => 'Blòca la creassion ëd neuv cont',
	'regexblock-form-submit' => "Blòca st'utent-sì",
	'regexblock-form-submit-empty' => "Da un nòm utent o n'adrëssa IP da bloché.",
	'regexblock-form-submit-regex' => 'Espression regolar pa bon-a.',
	'regexblock-form-submit-expiry' => 'Për piasì specìfica un temp ëd fin.',
	'regexblock-link' => 'blòca con espression regolar',
	'regexblock-match-stats-record' => "$1 a l'ha blocà '$2' su '$3' a '$4', registrand da l'adrëssa '$5'",
	'regexblock-nodata-found' => 'Pa gnun dat trovà',
	'regexblock-stats-title' => 'Statìstiche dij blocagi regex',
	'regexblock-unblock-success' => 'Dësblocagi andàit bin',
	'regexblock-unblock-log' => "Ël nòm utent o l'adrëssa IP '''$1''' a l'é stàit blocà.",
	'regexblock-unblock-error' => 'Eror an dësblocand $1.
A peul esse che a-i sia pa col utent.',
	'regexblock-regex-filter' => '  o valor regex:',
	'regexblock-view-blocked' => 'Visualisassion blocà da:',
	'regexblock-view-all' => 'Tùit',
	'regexblock-view-go' => 'Va',
	'regexblock-view-match' => '(pròpi parèj)',
	'regexblock-view-regex' => '(corëspondensa regex)',
	'regexblock-view-account' => '(blocagi ëd la creassion ëd cont)',
	'regexblock-view-reason' => 'rason: $1',
	'regexblock-view-reason-default' => 'rason genérica',
	'regexblock-view-block-infinite' => 'blocagi përmanent',
	'regexblock-view-block-by' => 'blocà da:',
	'regexblock-view-block-unblock' => 'dësbloché',
	'regexblock-view-stats' => 'statìstiche',
	'regexblock-view-empty' => "La lista ëd nòm e adrësse blocà a l'é veuida.",
	'regexblock-view-time' => 'dzora $1',
	'right-regexblock' => "Blòca utent për le modìfiche dzora a tute le wiki dl'ansema ëd wiki",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'regexblock-already-blocked' => 'پر $1 د پخوا نه بنديز لګېدلی.',
	'regexblock-block-log' => "په کارن نوم او يا د '''$1''' په IP پتې بنديز لګېدلی.",
	'regexblock-block-success' => 'بنديز په برياليتوب سره ولګېده',
	'regexblock-currently-blocked' => 'د دم مهال بنديز لګېدلې پتې:',
	'regexblock-expire-duration' => '1 ساعت،2 ساعتونه،4 ساعتونه،6 ساعتونه،1 ورځ3 ورځې،1 اونۍ،2 اونۍ،1 مياشت،3 مياشتې،6 مياشتې،1 کال، لامحدوده',
	'regexblock-form-username' => 'IP پته يا کارن-نوم:',
	'regexblock-form-reason' => 'سبب:',
	'regexblock-form-expiry' => 'د پای نېټه:',
	'regexblock-form-account-block' => 'د نوؤ کارن-حسابونو په جوړېدو بنديز لګول',
	'regexblock-form-submit' => 'په دې کارن بنديز لګول',
	'regexblock-form-submit-expiry' => 'لطفاً يوه نوې پای موده وټاکۍ.',
	'regexblock-nodata-found' => 'اومتوک و نه موندل شو',
	'regexblock-unblock-success' => 'بنديز په برياليتوب سره ليري شو',
	'regexblock-view-all' => 'ټول',
	'regexblock-view-go' => 'ورځه',
	'regexblock-view-reason' => 'سبب: $1',
	'regexblock-view-block-unblock' => 'بنديز لرې کول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'regexblock' => 'Bloqueio de expressões regulares',
	'regexblock-already-blocked' => '$1 já está bloqueada.',
	'regexblock-block-log' => "Nome de utilizador ou endereço IP '''$1''' foi bloqueado.",
	'regexblock-block-success' => 'Bloqueio com sucesso',
	'regexblock-currently-blocked' => 'Endereços actualmente bloqueados:',
	'regexblock-desc' => 'Extensão usada para bloquear nomes de utilizador ou endereços IP através de expressões regulares. Contém o mecanismo e uma [[Special:Regexblock|página especial]] para adicionar/gerir os bloqueios',
	'regexblock-expire-duration' => '1 hora,2 horas,4 horas,6 horas,1 dia,3 dias,1 semana,2 semanas,1 mês,3 meses,6 meses,1 ano,infinito',
	'regexblock-page-title' => 'Bloqueio de nomes de expressões regulares',
	'regexblockstats' => 'Estatísticas de bloqueio de expressões regulares',
	'regexblock-help' => 'Use o formulário abaixo para bloquear o acesso de escrita a um endereço IP ou nome de utilizador específicos.
Isto deverá ser feito apenas para prevenir vandalismo, e de acordo com as normas.
\'\'Esta página permitir-lhe-á bloquear até mesmo utilizadores não existentes, e também bloqueará utilizadores com nomes semelhantes ao dado, isto é, "Teste" será bloqueado juntamente com "Teste 2", etc.
Também pode bloquear endereços IP completos, significando isto que ninguém proveniente deles poderá editar páginas.
Nota: endereços IP parciais serão tratados como nomes de utilizador na determinação do bloqueio.
Se nenhum motivo for especificado, será usado um motivo genérico predefinido.\'\'',
	'regexblock-page-title-1' => 'Bloquear endereço utilizando expressões regulares',
	'regexblock-reason-ip' => 'Este endereço IP está impedido de editar devido a vandalismo ou outra perturbação por si ou outra pessoa que partilha o seu endereço IP.
Se crê que se trata de um erro, por favor, [[$1|entre em contacto]]',
	'regexblock-reason-name' => 'Este nome de utilizador está impedido de editar devido a vandalismo ou outro tipo de disrupção. Se julgar tratar-se de um erro, por favor [[$1|entre em contacto]]',
	'regexblock-reason-regex' => 'Este nome de utilizador está impedido de editar devido a vandalismo ou outra perturbação por um utilizador com um nome semelhante.
Por favor, crie um nome de utilizador alternativo ou [[$1|avise-nos]] sobre o problema',
	'regexblock-form-username' => 'Endereço IP ou nome de utilizador:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Validade:',
	'regexblock-form-match' => 'Correspondência exata',
	'regexblock-form-account-block' => 'Bloquear criação de novas contas',
	'regexblock-form-submit' => 'Bloquear este Utilizador',
	'regexblock-form-submit-empty' => 'Forneça um nome de utilizador ou um endereço IP para bloquear.',
	'regexblock-form-submit-regex' => 'Expressão regular inválida.',
	'regexblock-form-submit-expiry' => 'Por favor, seleccione um período de expiração.',
	'regexblock-link' => 'bloqueio com expressão regular',
	'regexblock-match-stats-record' => "$1 bloqueou '$2' em '$3' em '$4', proveniente do endereço '$5'",
	'regexblock-nodata-found' => 'Não foram encontrados dados',
	'regexblock-stats-title' => 'Estatísticas de bloqueio com expressões regulares',
	'regexblock-unblock-success' => 'Desbloqueio bem sucedido',
	'regexblock-unblock-log' => "O nome de utilizador ou endereço IP '''$1''' foi desbloqueado.",
	'regexblock-unblock-error' => 'Erro ao desbloquear $1. Provavelmente não existe esse utilizador.',
	'regexblock-regex-filter' => '  ou valor de regex:',
	'regexblock-view-blocked' => 'Ver bloqueios por:',
	'regexblock-view-all' => 'Todos',
	'regexblock-view-go' => 'Ir',
	'regexblock-view-match' => '(correspondência exata)',
	'regexblock-view-regex' => '(correspondência a regex)',
	'regexblock-view-account' => '(bloqueio de criação de conta)',
	'regexblock-view-reason' => 'motivo: $1',
	'regexblock-view-reason-default' => 'motivo genérico',
	'regexblock-view-block-infinite' => 'bloqueio permanente',
	'regexblock-view-block-by' => 'bloqueado por:',
	'regexblock-view-block-unblock' => 'desbloquear',
	'regexblock-view-stats' => 'estatísticas',
	'regexblock-view-empty' => 'Esta lista de nomes e endereços bloqueados está vazia.',
	'regexblock-view-time' => 'em $1',
	'right-regexblock' => 'Bloquear a edição aos utilizadores de todas as wikis da fazenda',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'regexblock' => 'Bloqueio por expressões regulares',
	'regexblock-already-blocked' => '$1 já está bloqueada.',
	'regexblock-block-log' => "Nome de utilizador ou endereço IP '''$1''' foi bloqueado.",
	'regexblock-block-success' => 'Bloqueio com sucesso',
	'regexblock-currently-blocked' => 'Endereços bloqueados atualmente:',
	'regexblock-desc' => 'Extensão usada para bloquear nomes de utilizador ou endereços IP através de expressões regulares. Contém o mecanismo e uma [[Special:Regexblock|página especial]] para adicionar/gerenciar os bloqueios.',
	'regexblock-expire-duration' => '1 hora,2 horas,4 horas,6 horas,1 dia,3 dias,1 semana,2 semanas,1 mês,3 meses,6 meses,1 ano,infinito',
	'regexblock-page-title' => 'Bloqueio de nomes por expressões regulares',
	'regexblockstats' => 'Estatísticas de bloqueio por expressões regulares',
	'regexblock-help' => 'Use o formulário abaixo para bloquear o acesso de escrita a um endereço IP ou nome de utilizador específicos.
Isto deverá ser feito apenas para prevenir vandalismo, e de acordo com as políticas.
\'\'Esta página lhe permitirá bloquear até mesmo utilizadores não existentes, e também bloqueará utilizadores com nomes semelhantes ao dado, p. ex. "Teste" será bloqueado juntamente com "Teste 2", etc.
Você pode também bloquear endereços IP completos, significando isto que ninguém proveniente deles poderá editar páginas.
Nota: endereços IP parciais serão tratados como nomes de utilizadores na determinação do bloqueio.
Se nenhum motivo for especificado, um motivo genérico padrão será usado.\'\'',
	'regexblock-page-title-1' => 'Bloquear endereço utilizando expressões regulares',
	'regexblock-reason-ip' => 'Este endereço IP está impedido de editar devido a vandalismo ou outra perturbação por si ou outra pessoa que compartilha o seu endereço IP.
Se você acredita que se trata de um erro, por favor, [[$1|contate-nos]]',
	'regexblock-reason-name' => 'Este nome de utilizador está impedido de editar devido a vandalismo ou outro tipo de disrupção. Se julgar tratar-se de um erro, por favor [[$1|contate-nos]]',
	'regexblock-reason-regex' => 'Este nome de utilizador está impedido de editar devido a vandalismo ou outra perturbação por um utilizador com um nome semelhante.
Por favor, crie um nome de utilizador alternativo ou [[$1|contate-nos]] sobre o problema',
	'regexblock-form-username' => 'Endereço IP ou nome de utilizador:',
	'regexblock-form-reason' => 'Motivo:',
	'regexblock-form-expiry' => 'Validade:',
	'regexblock-form-match' => 'Correspondência exata',
	'regexblock-form-account-block' => 'Bloquear criação de novas contas',
	'regexblock-form-submit' => 'Bloquear este Utilizador',
	'regexblock-form-submit-empty' => 'Forneça um nome de utilizador ou um endereço IP para bloquear.',
	'regexblock-form-submit-regex' => 'Expressão regular inválida.',
	'regexblock-form-submit-expiry' => 'Por favor, seleccione um período de expiração.',
	'regexblock-link' => 'bloqueio com expressão regular',
	'regexblock-match-stats-record' => "$1 bloqueou '$2' em '$3' em '$4', proveniente do endereço '$5'",
	'regexblock-nodata-found' => 'Nenhum dado encontrado',
	'regexblock-stats-title' => 'Estatísticas de bloqueio de expressões regulares',
	'regexblock-unblock-success' => 'Desbloqueio bem sucedido',
	'regexblock-unblock-log' => "O nome de utilizador ou endereço IP '''$1''' foi desbloqueado.",
	'regexblock-unblock-error' => 'Erro ao desbloquear $1. Provavelmente não existe esse utilizador.',
	'regexblock-regex-filter' => 'ou valor de regex:',
	'regexblock-view-blocked' => 'Ver bloqueios por:',
	'regexblock-view-all' => 'Todos',
	'regexblock-view-go' => 'Ir',
	'regexblock-view-match' => '(correspondência exata)',
	'regexblock-view-regex' => '(correspondência por regex)',
	'regexblock-view-account' => '(bloqueio de criação de conta)',
	'regexblock-view-reason' => 'motivo: $1',
	'regexblock-view-reason-default' => 'motivo genérico',
	'regexblock-view-block-infinite' => 'bloqueio permanente',
	'regexblock-view-block-by' => 'bloqueado por:',
	'regexblock-view-block-unblock' => 'desbloquear',
	'regexblock-view-stats' => 'estatísticas',
	'regexblock-view-empty' => 'Esta lista de nomes e endereços bloqueados está vazia.',
	'regexblock-view-time' => 'em $1',
	'right-regexblock' => 'Bloquear a edição a utilizadores em todos os wikis da farm de wikis',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'regexblock-reason-regex' => "Kay ruraqpa sutinqa llamk'apuymanta hark'asqam, yaqa kaqlla sutiyuq ruraq wandaluchaptinmi, millaykunata ruraptinmi. Ama hina kaspa, huk ruraqpa sutiykita kamariy icha [[$1|qillqarimuwayku]] kay sasachakuymanta rimanakunanchikpaq",
	'regexblock-form-submit' => "Kay ruraqta hark'ay",
	'regexblock-match-stats-record' => '$1 sutiyuqqa \'$2\' sutiyuqta hark\'an \'$3\' p\'unchawpi \'$4\' pachapi, \'$5\' tiyaymanta hallch\'aspa
<!--
structure:
"hark\'an" = "blocked"
"$1 sutiyuqqa" = "the one who has the name $1" and so on
-->',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'regexblock-view-all' => 'Maṛṛa',
	'regexblock-view-go' => 'Raḥ ɣa',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'regexblock' => 'Blocare regex',
	'regexblock-already-blocked' => '$1 este deja blocat.',
	'regexblock-currently-blocked' => 'Adrese blocate în prezent:',
	'regexblock-form-username' => 'Adresă IP sau nume de utilizator:',
	'regexblock-form-reason' => 'Motiv:',
	'regexblock-form-expiry' => 'Expirare:',
	'regexblock-form-account-block' => 'Blochează crearea de conturi noi',
	'regexblock-form-submit' => 'Blochează acest utilizator',
	'regexblock-form-submit-regex' => 'Expresie regulată incorectă.',
	'regexblock-unblock-success' => 'Deblocare cu succes',
	'regexblock-unblock-log' => "Utilizatorul sau adresa IP '''$1''' a fost deblocat.",
	'regexblock-view-all' => 'Toți',
	'regexblock-view-go' => 'Mergeți',
	'regexblock-view-account' => '(blocare creare conturi)',
	'regexblock-view-reason' => 'motiv: $1',
	'regexblock-view-reason-default' => 'motiv generic',
	'regexblock-view-block-infinite' => 'blocare permanentă',
	'regexblock-view-block-by' => 'blocat de către:',
	'regexblock-view-block-unblock' => 'deblocare',
	'regexblock-view-stats' => 'statistici',
	'regexblock-view-empty' => 'Lista de nume și adrese blocate este goală.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'regexblock-form-reason' => 'Mutive:',
	'regexblock-view-all' => 'Tutte',
	'regexblock-view-go' => 'Veje',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'regexblock' => 'RegexBlock',
	'regexblock-already-blocked' => '$1 уже заблокирован.',
	'regexblock-block-log' => "Имя участника или IP-адрес '''$1''' заблокирован.",
	'regexblock-block-success' => 'Блокировка выполнена успешно',
	'regexblock-currently-blocked' => 'Заблокированные сейчас адреса:',
	'regexblock-desc' => 'Расширение, использующееся для блокировки имён участников и IP-адресов с помощью регулярных выражений. Содержит механизм блокирования и [[Special:Regexblock|служебную страницу]] для добавления и управления блокировками',
	'regexblock-expire-duration' => '1 час,2 часа,4 часа,6 часов,1 день,3 дня,1 неделя,2 недели,1 месяц,3 месяца,6 месяцев,1 год,бессрочно',
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
Если вы считаете, что это ошибка, пожалуйста, [[$1|свяжитесь с нами]]',
	'regexblock-reason-name' => 'Это имя участника отстранёно от редактирования из-за вандализма или других нарушений.
Если вы считаете, что это ошибка, пожалуйста, [[$1|свяжитесь с нами]]',
	'regexblock-reason-regex' => 'Это имя участника отстранёно от редактирования из-за вандализма или других нарушений, которые совершил участник с похожим именем.
Пожалуйста, создайте другое имя участника или [[$1|сообщите нам]] о проблеме',
	'regexblock-form-username' => 'IP-адрес или имя участника:',
	'regexblock-form-reason' => 'Причина:',
	'regexblock-form-expiry' => 'Истекает:',
	'regexblock-form-match' => 'Точное соответствие',
	'regexblock-form-account-block' => 'Запретить создание новых учётных записей',
	'regexblock-form-submit' => 'Заблокировать этого участника',
	'regexblock-form-submit-empty' => 'Укажите имя участника или IP-адрес для блокировки.',
	'regexblock-form-submit-regex' => 'Ошибочное регулярное выражение.',
	'regexblock-form-submit-expiry' => 'Пожалуйста, укажите время действия.',
	'regexblock-link' => 'заблокировать с регулярным выражением',
	'regexblock-match-stats-record' => '$1 блокировал «$2» на «$3» на «$4», вошедшего в систему с адреса «$5»',
	'regexblock-nodata-found' => 'Ничего не найдено',
	'regexblock-stats-title' => 'Статистика RegexBlock',
	'regexblock-unblock-success' => 'Разблокировка выполнена успешно',
	'regexblock-unblock-log' => "Имя участника или IP-адрес '''$1''' заблокирован.",
	'regexblock-unblock-error' => 'Ошибка разблокировки $1.
Возможно, такого участника не существует.',
	'regexblock-regex-filter' => '  или значение регулярного выражения:',
	'regexblock-view-blocked' => 'Просмотреть заблокированных:',
	'regexblock-view-all' => 'Все',
	'regexblock-view-go' => 'Выполнить',
	'regexblock-view-match' => '(точное соответствие)',
	'regexblock-view-regex' => '(соответствие рег. выр.)',
	'regexblock-view-account' => '(запрет создания учётных записей)',
	'regexblock-view-reason' => 'причина: $1',
	'regexblock-view-reason-default' => 'общая причина',
	'regexblock-view-block-infinite' => 'бессрочная блокировка',
	'regexblock-view-block-by' => 'заблокирован:',
	'regexblock-view-block-unblock' => 'разблокировать',
	'regexblock-view-stats' => 'статистика',
	'regexblock-view-empty' => 'Список заблокированных имён и адресов пуст.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Запретить участникам редактировать во всех вики этой вики-фермы',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'regexblock-form-reason' => 'Причіна:',
	'regexblock-form-expiry' => 'Кінчіть:',
	'regexblock-form-submit' => 'Заблоковати того хоснователя',
	'regexblock-view-all' => 'Вшыткы',
	'regexblock-view-go' => 'Іти на',
	'regexblock-view-block-unblock' => 'одблоковати',
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
	'regexblock-expire-duration' => '1 hodina,2 hodiny,4 hodiny,6 hodín,1 deň,3 dni,1 týždeň,2 týždne,1 mesiac,3 mesiace,6 mesiacov,1 rok,na neurčito',
	'regexblock-page-title' => 'Blokovanie mena na základe regulárneho výrazu',
	'regexblockstats' => 'Štatistika regex blokovaní',
	'regexblock-help' => "Použite tento formulár na zablokovanie úprav z určitej IP adresy alebo používateľského mena. Toto by sa malo využívať iba na predchádzanie vandalizmu a v súlade so zásadami blokovania. ''Táto stránka vým umožní zablokovať aj momentálne neexistujúcich používateľov a používateľov s podobnými menami ako bolo zadané, t.j. okrem « Test » bude zablokovaný aj « Test 2 » atď. Môžete tiež zablokovať celé IP adresy, čo znamená, že nikto, kto z nich pristupuje nebude môcť upravovať stránky. Pozn.: čiastočné IP adresy budú považované za používateľské mená. Ak nebude uvedený dôvod, použije sa štandardný všeobecný dôvod.''",
	'regexblock-page-title-1' => 'Zablokovať adresu na základe regulárneho výrazu',
	'regexblock-reason-ip' => 'Tejto IP adrese bolo zakázané upravovanie kvôli vandalizmu alebo inej rušivej činnosti, ktorú ste vykonávali vy alebo niekto s kým máte spoločnú vašu IP adresu. Ak veríte, že toto je omyl, prosím [[$1|kontaktujte nás]].',
	'regexblock-reason-name' => 'Tomuto používateľskému menu bolo zakázané upravovanie kvôli vandalizmu alebo inej rušivej činnosti. Ak veríte, že toto je omyl, prosím [[$1|kontaktujte nás]].',
	'regexblock-reason-regex' => 'Tomuto používateľskému menu bolo zakázané upravovanie kvôli vandalizmu alebo inej rušivej činnosti používateľa s podobným menom. Prosím, vytvorte si alternatívny používateľský účet alebo nás ohľadne problému [[$1|kontaktujte]].',
	'regexblock-form-username' => 'IP adresa alebo meno používateľa:',
	'regexblock-form-reason' => 'Dôvod:',
	'regexblock-form-expiry' => 'Vyprší:',
	'regexblock-form-match' => 'Presná zhoda',
	'regexblock-form-account-block' => 'Zablokovať možnosť tvorby nových účtov',
	'regexblock-form-submit' => 'Zablokovať tohto používateľa',
	'regexblock-form-submit-empty' => 'Zadajte používateľské meno alebo IP adresu, ktorá sa má zablokovať.',
	'regexblock-form-submit-regex' => 'Neplatný regulárny výraz.',
	'regexblock-form-submit-expiry' => 'Prosím zadajte, kedy má blokovanie skončiť.',
	'regexblock-link' => 'zablokovať regulárnym výrazom',
	'regexblock-match-stats-record' => '$1 zablokoval účet „$2“ na „$3“ $4, záznam z adresy „$5“',
	'regexblock-nodata-found' => 'Neboli nájdené žiadne údaje',
	'regexblock-stats-title' => 'Štatistiky regex blokovaní',
	'regexblock-unblock-success' => 'Odblokovanie úspešné',
	'regexblock-unblock-log' => "Používateľské meno alebo IP adresa '''$1''' bolo odblokované",
	'regexblock-unblock-error' => 'Chyba pri odblokovaní $1. Taký používateľ pravdepodobne neexistuje.',
	'regexblock-regex-filter' => '  alebo hodnota reg. výrazu:',
	'regexblock-view-blocked' => 'Zobraziť blokovania od:',
	'regexblock-view-all' => 'Všetci',
	'regexblock-view-go' => 'Vykonať',
	'regexblock-view-match' => '(presná zhoda)',
	'regexblock-view-regex' => '(vyhovuje reg. výrazu)',
	'regexblock-view-account' => '(blokovanie tvorby účtov)',
	'regexblock-view-reason' => 'dôvod: $1',
	'regexblock-view-reason-default' => 'všeobecný dôvod',
	'regexblock-view-block-infinite' => 'trvalé blokovanie',
	'regexblock-view-block-by' => 'zablokoval ho:',
	'regexblock-view-block-unblock' => 'odblokovať',
	'regexblock-view-stats' => 'štatistiky',
	'regexblock-view-empty' => 'Zoznam blokovaných mien a IP adries je prázdny.',
	'regexblock-view-time' => '$1',
	'right-regexblock' => 'Zablokovať úpravy používateľov na všetkých wiki z tejto wiki farmy',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'regexblock-form-reason' => 'Razlog:',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'regexblock-block-success' => 'Блокирање је успело',
	'regexblock-currently-blocked' => 'Тренутно блокиране адресе:',
	'regexblock-page-title-1' => 'Блокирај адресу користећи регуларне изразе',
	'regexblock-form-username' => 'ИП адреса или корисничко име:',
	'regexblock-form-reason' => 'Разлог:',
	'regexblock-form-expiry' => 'Истиче:',
	'regexblock-form-match' => 'Тачно поклапање',
	'regexblock-form-submit' => 'Блокирај овог корисника',
	'regexblock-view-all' => 'Све',
	'regexblock-view-go' => 'Иди',
	'regexblock-view-reason' => 'разлог: $1',
	'regexblock-view-reason-default' => 'општи разлог',
	'regexblock-view-block-infinite' => 'трајна блокада',
	'regexblock-view-block-by' => 'блокирао:',
	'regexblock-view-block-unblock' => 'деблокирај',
	'regexblock-view-stats' => 'статистике',
	'regexblock-view-time' => '$2 у $3',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'regexblock-block-success' => 'Blokiranje je uspelo',
	'regexblock-currently-blocked' => 'Trenutno blokirane adrese:',
	'regexblock-page-title-1' => 'Blokiraj adresu koristeći regularne izraze',
	'regexblock-form-username' => 'IP adresa ili korisničko ime:',
	'regexblock-form-reason' => 'Razlog:',
	'regexblock-form-expiry' => 'Ističe:',
	'regexblock-form-match' => 'Tačno poklapanje',
	'regexblock-form-submit' => 'Blokiraj ovog korisnika',
	'regexblock-view-all' => 'Sve',
	'regexblock-view-go' => 'Idi',
	'regexblock-view-reason' => 'razlog: $1',
	'regexblock-view-reason-default' => 'opšti razlog',
	'regexblock-view-block-infinite' => 'trajna blokada',
	'regexblock-view-block-by' => 'blokirao:',
	'regexblock-view-block-unblock' => 'deblokiraj',
	'regexblock-view-stats' => 'statistike',
	'regexblock-view-time' => '$2 u $3',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'regexblock-already-blocked' => '$1 geus dipeungpeuk.',
	'regexblock-form-reason' => 'Alesan:',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author M.M.S.
 * @author Najami
 * @author Sertion
 */
$messages['sv'] = array(
	'regexblock' => 'Regex-blockering',
	'regexblock-already-blocked' => '"$1" är redan blockerad.',
	'regexblock-block-log' => "Användarnamnet eller IP-adressen '''$1''' har blockerats.",
	'regexblock-block-success' => 'Blockering lyckades',
	'regexblock-currently-blocked' => 'Nuvarande blockerade adresser:',
	'regexblock-desc' => 'Tillägg som används för att blockera användarnamn och IP-adresser med hjälp av reguljära uttryck. Innehåller både blockeringsmekansimen och en [[Special:Regexblock|specialsida]] för att lägga till och ändra blockeringar',
	'regexblock-expire-duration' => '1 timme,2 timmar,4 timmar,6 timmar,1 dag,3 dagar,1 vecka,2 veckor,1 månad,3 månader,6 månader,1 år, oändlig',
	'regexblock-page-title' => 'Blockering med hjälp av reguljära uttryck',
	'regexblockstats' => 'Regex-blockeringsstatistik',
	'regexblock-help' => 'Använd formuläret nedan för att blockera vissa IP-adresser eller användarnamn från att redigera. 
Det här borde endast göras för att förhindra vandalism, i följd med riktlinjerna.
\'\'Den här sidan låter dig även blockera ej existerande användare, och kommer också blockera användare med liknande namn. t.ex. kommer "Test" blockeras samtidigt med "Test 2" o.s.v.
Du kan också blockera fulla IP-adresser, vilket betyder att ingen som loggar in via dessa kan redigera sidor.
Notera att delvisa IP-adresser kommer behandlas som användarnamn under blockering.
Om ingen beskrivning uppges kommer en standardbeskrivning användas.\'\'',
	'regexblock-page-title-1' => 'Blockera adress med hjälp av reguljära uttryck',
	'regexblock-reason-ip' => 'Den här IP-adressen är blockerad från att redigera på grund av vandalism eller annan förstörelse av dig eller någon annan som använder samma IP-adress.
Om du anser att detta är fel, var god [[$1|kontakta oss]]',
	'regexblock-reason-name' => 'Det här användarnamnet är blockerat från att redigera på grund av vandalism eller annan förstörelse.
Om du anser att detta är fel, var god [[$1|kontakta oss]]',
	'regexblock-reason-regex' => 'Den här IP-adressen är blockerad från att redigera på grund av vandalism eller annan förstörelse av en användare med liknande namn. 
Var god skapa ett annat användarnamn eller [[$1|kontakta oss]] om problemet.',
	'regexblock-form-username' => 'IP adress eller användarnamn:',
	'regexblock-form-reason' => 'Anledning:',
	'regexblock-form-expiry' => 'Utgång:',
	'regexblock-form-match' => 'Exakt träff',
	'regexblock-form-account-block' => 'Blockera skapandet av nya konton',
	'regexblock-form-submit' => 'Blockera den här användaren',
	'regexblock-form-submit-empty' => 'Ange ett användarnamn eller en IP-adress att blockera.',
	'regexblock-form-submit-regex' => 'Ogiltigt reguljärt uttryck',
	'regexblock-form-submit-expiry' => 'Var god ange en utgångstid.',
	'regexblock-link' => 'blockering med reguljära uttryck',
	'regexblock-match-stats-record' => "$1 blockerade '$2' på $3 vid $4, loggade in från $5",
	'regexblock-nodata-found' => 'Hittade ingen data',
	'regexblock-stats-title' => 'Regex-blockeringsstatistik',
	'regexblock-unblock-success' => 'Avblockering lyckades',
	'regexblock-unblock-log' => "Användarnamnet eller IP-adressen '''$1''' har avblockerats",
	'regexblock-unblock-error' => 'Fel under avblockering av $1.
Troligen så finns det ingen användare med det namnet.',
	'regexblock-regex-filter' => ' eller det reguljära uttrycket:',
	'regexblock-view-blocked' => 'Visa de blockerade efter:',
	'regexblock-view-all' => 'Alla',
	'regexblock-view-go' => 'Gå',
	'regexblock-view-match' => '(exakt träff)',
	'regexblock-view-regex' => '(regex-träff)',
	'regexblock-view-account' => '(kontoskapande blockerat)',
	'regexblock-view-reason' => 'anledning: $1',
	'regexblock-view-reason-default' => 'generisk grund',
	'regexblock-view-block-infinite' => 'permanent blockering',
	'regexblock-view-block-by' => 'blockerad av:',
	'regexblock-view-block-unblock' => 'avblockera',
	'regexblock-view-stats' => 'statistik',
	'regexblock-view-empty' => 'Listan över blockerade namn och adresser är tom.',
	'regexblock-view-time' => 'på $1',
	'right-regexblock' => 'Blockerar användare från att redigera på alla wikis i wikisamlingen',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'regexblock-form-reason' => 'Čymu:',
	'regexblock-form-expiry' => 'Wygaso:',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'regexblock-view-all' => 'அனைத்தும்',
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
	'regexblock-nodata-found' => 'భోగట్టా ఏమీ దొరకలేదు',
	'regexblock-unblock-success' => 'నిరోధపు ఎత్తివేత విజయవంతమైంది',
	'regexblock-unblock-log' => "'''$1''' అనే వాడుకరి పేరు లేదా ఐపీ చిరునామాపై నిరోధం ఎత్తివేసారు.",
	'regexblock-view-all' => 'అన్నీ',
	'regexblock-view-go' => 'వెళ్ళు',
	'regexblock-view-account' => '(ఖాతా సృష్టింపు నిరోధం)',
	'regexblock-view-reason' => 'కారణం: $1',
	'regexblock-view-reason-default' => 'సాధారణ కారణం',
	'regexblock-view-block-infinite' => 'శాశ్వత నిరోధం',
	'regexblock-view-block-by' => 'నిరోధించినది:',
	'regexblock-view-block-unblock' => 'నిరోధం ఎత్తివేయండి',
	'regexblock-view-stats' => 'గణాంకాలు',
	'regexblock-view-empty' => 'నిరోధించిన పేర్లు మరియు చిరునామాల జాబితా ఖాళీగా ఉంది.',
	'regexblock-view-time' => '$1 నాడు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'regexblock-form-reason' => 'Motivu:',
	'regexblock-view-all' => 'Hotu',
	'regexblock-view-go' => 'Bá',
	'regexblock-view-reason' => 'motivu: $1',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
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
	'regexblock-view-block-by' => 'баста шуд тавассути',
	'regexblock-view-block-unblock' => 'боз кардан',
	'regexblock-view-stats' => 'омор',
	'regexblock-view-empty' => 'Феҳристи номҳо ва нишонаҳои баста шуда холӣ аст.',
	'regexblock-view-time' => 'дар $1',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'regexblock-already-blocked' => '"$1" allakaj basta şudaast.',
	'regexblock-block-log' => "Nomi korbarī jo nişonai '''$1''' basta şud.",
	'regexblock-block-success' => 'Bastan muvaffaq şud',
	'regexblock-currently-blocked' => 'Nişonahoi bastaşudai kununī:',
	'regexblock-form-username' => 'Nişonai IP jo nomi korbarī:',
	'regexblock-form-reason' => 'Dalel:',
	'regexblock-form-match' => 'Mutobiqati daqiq',
	'regexblock-form-account-block' => 'Eçodi bastani hisobhoi çadid',
	'regexblock-form-submit' => 'Bastani in Korbar',
	'regexblock-form-submit-empty' => 'Baroi bastan nomi korbarī jo nişonai IP dihed.',
	'regexblock-form-submit-regex' => "Iborai oddiji nomū'tabar.",
	'regexblock-form-submit-expiry' => 'Lutfan davrai ba xotimarasiro muşaxxas kuned.',
	'regexblock-stats-title' => 'Omori Bastani Regex',
	'regexblock-unblock-success' => 'Boz kardan az bastan muvaffaq şud',
	'regexblock-unblock-log' => "Nomi korbarī jo nişonai IP '''$1''' az bastan boz şud.",
	'regexblock-unblock-error' => 'Xato dar boz kardani $1.
Ehtimolan cunin korbare nest.',
	'regexblock-view-all' => 'Hama',
	'regexblock-view-go' => 'Birav',
	'regexblock-view-match' => '(mutobiqati daqiq)',
	'regexblock-view-account' => '(bastani eçodi hisobi çadid)',
	'regexblock-view-reason' => 'dalel: $1',
	'regexblock-view-reason-default' => 'daleli umumī',
	'regexblock-view-block-infinite' => 'bastani doimī',
	'regexblock-view-block-unblock' => 'boz kardan',
	'regexblock-view-stats' => 'omor',
	'regexblock-view-empty' => 'Fehristi nomho va nişonahoi basta şuda xolī ast.',
	'regexblock-view-time' => 'dar $1',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'regexblock-expire-duration' => '1 ชั่วโมง,2 ชั่วโมง,4 ชั่วโมง,6 ชั่วโมง,1 วัน,3 วัน,1 สัปดาห์,2 สัปดาห์,1 เดือน,3 เดือน,6 เดือน,1 ปี,ตลอดกาล',
	'regexblock-form-reason' => 'เหตุผล:',
	'regexblock-view-all' => 'ทั้งหมด',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'regexblock-view-all' => 'Ählisi',
	'regexblock-view-go' => 'Git',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'regexblock' => 'Paghadlang na pangpangkaraniwang pagsasaad',
	'regexblock-already-blocked' => 'Hinadlangan na si $1.',
	'regexblock-block-log' => "Hinadlangan na ang pangalan ng tagagamit o adres ng IP na '''$1'''.",
	'regexblock-block-success' => 'Nagtagumpay ang paghadlang',
	'regexblock-currently-blocked' => 'Pangkalasalukuyang hinahadlangang mga adres:',
	'regexblock-desc' => 'Karugtong na ginagamit para sa paghahadlang ng mga pangalan ng mga tagagamit at mga adres ng IP sa pamamagitan ng pangkaraniwang mga pagsasaad.  Naglalaman ng kapwa mekanismong panghadlang at isang [[Special:Regexblock|natatanging pahina]] upang makapagdagdag/makapamahala ng mga paghahadlang.',
	'regexblock-expire-duration' => '1 oras,2 oras,4 na oras,6 na oras,1 araw,3 mga araw,1 linggo,2 linggo,1 buwan,3 buwan,6 na buwan,1 taon,walang hanggan',
	'regexblock-page-title' => 'Paghadlang sa pangalan ng pangkaraniwang pagsasaad',
	'regexblockstats' => 'Mga estadistika ng paghadlang na pangpangkaraniwang pagsasaad',
	'regexblock-help' => 'Gamitin ang pormularyo sa ibaba upang mahadlangan ang pagpuntang makapagsusulat mula sa isang partikular na adres ng IP o pangalan ng tagagamit.  
Dapat na gawin lamang ito upang maiwasan ang bandalismo/pambababoy, at alinsunod sa patakaran.
\'\'Magpapahintulot ang pahina ito upang mahadlangang mo kahit ang hindi umiiral na mga tagagamit, at haharangan din ang mga tagagamit na may mga pangalan katulad ng ibinigay, halimbawa na ang "Subok" na mahahadlangang kasama ng "Subok 2" atbp.
Maaari mo ring hadlangan ang buong adres ng IP, na may ibig sabihing walang sinumang lalagda mula sa mga ito ang magkakaroon ng kakayanang makapagbago ng mga pahina.
Paunawa: ang hindi buong mga adres ng IP ay tatratuhin ayon sa mga pangalan ng tagagamit para sa pagtukoy ng paghahadlang.
Kapag walang dahilang tinukoy, isang likas na nakatakdang panglahatan dahil ang gagamitin.\'\'',
	'regexblock-page-title-1' => 'Hadlangan ang adres sa pamamagitan ng paggamit ng pangkaraniwang mga pagsasaad',
	'regexblock-reason-ip' => 'Ang adres ng IP na ito ay pinagbawalan sa paggawa ng pagbabago dahil sa pambababoy o iba pang pang-aabala mo o ng isang nakikisalo sa iyong adres ng IP.
Kung naniniwala kang isa itong kamalian, paki [[$1|makipag-ugnayan sa amin]]',
	'regexblock-reason-name' => 'Ang pangalan ng tagagamit na ito ay pinagbawalan sa paggawa ng pagbabago dahil sa pambababoy o iba pang pang-aabala.
Kung naniniwala kang isa itong kamalian, paki [[$1|makipag-ugnayan sa amin]]',
	'regexblock-reason-regex' => 'Ang pangalan ng tagagamit na ito ay pinagbawalan sa paggawa ng pagbabago dahil sa pambababoy o iba pang pang-aabala ng isang tagagamit na may kahawig na pangalan.
Pakilikha ang isang kapalit na pangalan ng tagagamit o [[$1|makipag-ugnayan sa amin]] hinggil sa suliranin',
	'regexblock-form-username' => 'Adres ng IP o pangalan ng tagagamit:',
	'regexblock-form-reason' => 'Dahilan:',
	'regexblock-form-expiry' => 'Katapusan:',
	'regexblock-form-match' => 'Tugmang-tugma',
	'regexblock-form-account-block' => 'Hadlangan ang paglikha ng bagong mga kuwenta',
	'regexblock-form-submit' => 'Hadlangan ang tagagamit na ito',
	'regexblock-form-submit-empty' => 'Magbigay ng isang pangalan ng tagagamit o isang adres ng IP na hahadlangan.',
	'regexblock-form-submit-regex' => 'Hindi tanggap na pangkaraniwang pagsasaad.',
	'regexblock-form-submit-expiry' => 'Pakitukoy ang isang panahon ng pagtatapos.',
	'regexblock-link' => 'hadlangan na may karaniwang pananalita',
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
	'regexblock-view-block-by' => 'hinadlangan ni:',
	'regexblock-view-block-unblock' => 'tanggalin sa pagkakahadlang',
	'regexblock-view-stats' => 'mga estadistika',
	'regexblock-view-empty' => 'Walang laman ang talaan ng hinadlangang mga pangalan at mga adres.',
	'regexblock-view-time' => 'noong $1',
	'right-regexblock' => 'Hadlangan ang mga tagagamit na makagawa ng mga pagbabago sa lahat ng mga wiki na nasa linangan ("bukid") ng wiki',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'regexblock' => 'Regex bloğu',
	'regexblock-block-success' => 'Engel başarılı',
	'regexblock-currently-blocked' => 'Halihazırda engellenmiş olan adresler:',
	'regexblock-page-title' => 'Kurallı ifade ad engeli',
	'regexblockstats' => 'Regex blok istatistikleri',
	'regexblock-form-username' => 'IP adresi veya kullanıcı adı:',
	'regexblock-form-reason' => 'Neden:',
	'regexblock-form-expiry' => 'Bitiş tarihi:',
	'regexblock-form-match' => 'Tam eşleşme',
	'regexblock-form-account-block' => 'Yeni hesap oluşturulmasını engelle',
	'regexblock-form-submit' => 'Bu kullanıcıyı engelle',
	'regexblock-form-submit-regex' => 'Geçersiz kurallı ifade',
	'regexblock-form-submit-expiry' => 'Lütfen bir bitiş süresi belirtin.',
	'regexblock-unblock-success' => 'Engel kaldırma başarısız oldu',
	'regexblock-view-all' => 'Hepsi',
	'regexblock-view-go' => 'Git',
	'regexblock-view-match' => '(tam eşleşme)',
	'regexblock-view-regex' => '(regex eşleşmesi)',
	'regexblock-view-reason' => 'gerekçe: $1',
	'regexblock-view-reason-default' => 'genel neden',
	'regexblock-view-block-infinite' => 'süresiz engel',
	'regexblock-view-block-by' => 'engelleyen:',
	'regexblock-view-block-unblock' => 'engeli kaldır',
	'regexblock-view-empty' => 'Engellenmiş ad ve adres listesi boş.',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'regexblock-view-go' => 'كۆچۈش',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'regexblock-view-go' => 'Köchüsh',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'regexblock-already-blocked' => '$1 вже заблокований.',
	'regexblock-form-username' => "IP-адреса або ім'я користувача:",
	'regexblock-form-reason' => 'Причина:',
	'regexblock-form-expiry' => 'Закінчення:',
	'regexblock-view-all' => 'Усі',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'regexblock-form-reason' => 'وجہ:',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'regexblock-form-reason' => 'Sü:',
	'regexblock-view-all' => 'Kaik',
	'regexblock-view-stats' => 'statistik',
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
	'regexblock-desc' => 'Phần mở rộng dùng để cấm những tên người dùng và địa chỉ IP bằng biểu thức chính quy. Có cả cơ chế cấm và một [[Special:Regexblock|trang đặc biệt]] để thêm/quản lý việc cấm',
	'regexblock-expire-duration' => '1 tiếng,2 tiếng,4 tiếng,6 tiếng,1 ngày,3 ngày,1 tuần,2 tuần,1 tháng,3 tháng,6 tháng,1 năm,vô hạn',
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
Nếu bạn tin rằng đây là nhầm lẫn, xin hãy [[$1|liên lạc với chúng tôi]].',
	'regexblock-reason-name' => 'Tên người dùng này bị chặn không được sửa đổi do phá hoại hoặc hành vi vi phạm khác.
Nếu bạn tin rằng đây là nhầm lẫn, xin hãy [[$1|liên lạc với chúng tôi]].',
	'regexblock-reason-regex' => 'Tên người dùng này bị chặn không được sửa đổi do phá hoại hoặc hành vi vi phạm khác của một thành viên có tên tương tự như thế này.
Xin hãy tạo một tên người dùng thay thế hoặc [[$1|liên lạc với chúng tôi]] về vấn đề này.',
	'regexblock-form-username' => 'Địa chỉ IP hoặc tên người dùng:',
	'regexblock-form-reason' => 'Lý do:',
	'regexblock-form-expiry' => 'Thời hạn:',
	'regexblock-form-match' => 'Khớp chính xác',
	'regexblock-form-account-block' => 'Cấm mở tài khoản mới',
	'regexblock-form-submit' => 'Cấm người dùng này',
	'regexblock-form-submit-empty' => 'Cung cấp một tên người dùng hoặc một địa chỉ IP để cấm.',
	'regexblock-form-submit-regex' => 'Biểu thức chính quy không hợp lệ.',
	'regexblock-form-submit-expiry' => 'Xin xác định thời hạn cấm.',
	'regexblock-link' => 'cấm dùng biểu thức chính quy',
	'regexblock-match-stats-record' => '$1 đã cấm “$2” tại “$3” ngày $4, địa chỉ IP là $5',
	'regexblock-nodata-found' => 'Không tìm thấy dữ liệu',
	'regexblock-stats-title' => 'Thống kê cấm regex',
	'regexblock-unblock-success' => 'Bỏ cấm thành công',
	'regexblock-unblock-log' => "Tên người dùng hoặc địa chỉ IP '''$1''' đã được bỏ cấm.",
	'regexblock-unblock-error' => 'Lỗi khi bỏ cấm $1.
Có thể không có thành viên nào như vậy.',
	'regexblock-regex-filter' => '  hoặc biểu thức chính quy:',
	'regexblock-view-blocked' => 'Xem những lần cấm do:',
	'regexblock-view-all' => 'Tất cả',
	'regexblock-view-go' => 'Xem',
	'regexblock-view-match' => '(khớp chính xác)',
	'regexblock-view-regex' => '(khớp chính xác)',
	'regexblock-view-account' => '(cấm mở tài khoản)',
	'regexblock-view-reason' => 'lý do: $1',
	'regexblock-view-reason-default' => 'lý do chung chung',
	'regexblock-view-block-infinite' => 'cấm vĩnh viễn',
	'regexblock-view-block-by' => 'bị cấm bởi:',
	'regexblock-view-block-unblock' => 'bỏ cấm',
	'regexblock-view-stats' => 'thống kê',
	'regexblock-view-empty' => 'Danh sách các tên và địa chỉ bị cấm đang trống.',
	'regexblock-view-time' => 'vào $1',
	'right-regexblock' => 'Cấm người dùng không được sửa đổi tại wiki nào trong mạng wiki',
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
	'regexblock-view-block-by' => 'peblokon fa:',
	'regexblock-view-block-unblock' => 'säblokön',
	'regexblock-view-stats' => 'statits',
	'regexblock-view-empty' => 'Lised gebananemas e ladetas-IP peblokölas vagon.',
	'regexblock-view-time' => 'in $1',
	'right-regexblock' => 'Blokön gebanis in vüks valik vükafarma',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'regexblock-form-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'regexblock-already-blocked' => '$1 איז שוין בלאקירט.',
	'regexblock-form-reason' => 'אורזאַך:',
	'regexblock-form-expiry' => 'אויסלאז:',
	'regexblock-view-all' => 'אַלע',
	'regexblock-view-go' => 'גיין',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'regexblock-block-success' => '封禁成功',
	'regexblock-expire-duration' => '1小时，2小时，4小时，6小时，1天，3天，1周，2周，1个月，3个月，6个月，1年，无限期',
	'regexblock-form-username' => 'IP地址或用户名：',
	'regexblock-form-reason' => '原因：',
	'regexblock-form-expiry' => '到期日：',
	'regexblock-form-submit' => '封禁这位用户',
	'regexblock-nodata-found' => '找不到数据',
	'regexblock-view-all' => '全部',
	'regexblock-view-go' => '提交',
	'regexblock-view-reason' => '原因：$1',
	'regexblock-view-reason-default' => '一般原因',
	'regexblock-view-block-infinite' => '永久封禁',
	'regexblock-view-block-unblock' => '解除封禁',
	'regexblock-view-stats' => '统计',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'regexblock-block-success' => '封禁成功',
	'regexblock-expire-duration' => '1小時，2小時，4小時，6小時，1天，3天，1週，2週，一個月，三個月，六個月，一年，永久',
	'regexblock-form-username' => 'IP 位址或使用者名稱：',
	'regexblock-form-reason' => '原因：',
	'regexblock-form-expiry' => '到期日：',
	'regexblock-form-submit' => '封禁該名使用者',
	'regexblock-nodata-found' => '找不到資料',
	'regexblock-view-all' => '全部',
	'regexblock-view-go' => '提交',
	'regexblock-view-reason' => '原因：$1',
	'regexblock-view-reason-default' => '一般原因',
	'regexblock-view-block-infinite' => '永久封禁',
	'regexblock-view-block-unblock' => '解除禁封',
	'regexblock-view-stats' => '統計',
);

