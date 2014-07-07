<?php
/**
 * Internationalisation file for FlaggedRevs extension, section Stabilization
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Page stabilization',
	'stabilization-text' => '\'\'\'Change the settings below to adjust how the stable version of [[:$1|$1]] is selected and displayed.\'\'\'',
    'stabilization-perm' => 'Your account does not have permission to change the stable version configuration.
Here are the current settings for [[:$1|$1]]:',
	'stabilization-page' => 'Page name:',
	'stabilization-leg' => 'Confirm stable version settings',
    'stabilization-def' => 'Revision displayed on default page view',
	'stabilization-def1' => 'The stable version; if not present, then the latest revision',
	'stabilization-def2' => 'The latest revision',
	'stabilization-restrict' => 'Review/auto-review restrictions',
	'stabilization-restrict-none' => 'No extra restrictions',
	'stabilization-submit' => 'Confirm',
	'stabilization-notexists' => 'There is no page called "[[:$1|$1]]".
No configuration is possible.',
	'stabilization-notcontent' => 'The page "[[:$1|$1]]" cannot be reviewed.
No configuration is possible.',
	'stabilization-comment' => 'Reason:',
	'stabilization-otherreason' => 'Other reason:',
	'stabilization-expiry' => 'Expires:',
	'stabilization-othertime' => 'Other time:',
	'stabilization-def-short' => 'Default',
	'stabilization-def-short-0' => 'Current',
	'stabilization-def-short-1' => 'Stable',
    'stabilize_page_invalid'       => 'The target page title is invalid.',
    'stabilize_page_notexists'     => 'The target page does not exist.',
    'stabilize_page_unreviewable'  => 'The target page is not in reviewable namespace.',
    'stabilize_invalid_autoreview' => 'Invalid autoreview restriction.',
    'stabilize_invalid_level'      => 'Invalid protection level.',
	'stabilize_expiry_invalid'     => 'Invalid expiration date.',
	'stabilize_expiry_old'         => 'This expiration time has already passed.',
    'stabilize_denied'             => 'Permission denied.',
    'stabilize_protect_quota'      => 'The maximum number of currently flag-protected pages has already been reached.', # do not translate
	'stabilize-expiring'           => 'expires $1 (UTC)',
	'stabilization-review'         => 'Mark the current revision checked',
);

/** Message documentation (Message documentation)
 * @author Aaron Schulz
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 * @author Robby
 * @author SPQRobin
 * @author Saper
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'stabilization-tab' => '{{Flagged Revs-small}}

Some skins (e.g. standard/classic) display an additional tab to control visibility of the page revisions, e.g. whether last revision should be included or perhaps the last checked or published version. Links to [[Special:Stabilization]].',
	'stabilization' => '{{Flagged Revs}}
Page title of Special:Stabilization, which lets admins change how the stable version is used for a page and who can review it.',
	'stabilization-text' => '{{Flagged Revs-small}}

Information displayed on Special:Stabilization.

"stable version selection" is the same as {{msg-mw|Stabilization-select}}.
*$1 The page name',
	'stabilization-perm' => '{{Flagged Revs-small}}
Used on Special:Stabilization when the user has not the permission to change the settings.
* $1 The page name',
	'stabilization-page' => '{{Flagged Revs}}
{{Identical|Page name}}
Used on Special:Stabilization.',
	'stabilization-leg' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilization-def' => '{{Flagged Revs}}
Used on Special:Stabilization.
This is referring to the revision of the page that most users will see unless the specify a different revision (e.g. ?oldid=X or ?stable=0)',
	'stabilization-def1' => '{{Flagged Revs-small}}
Used on Special:Stabilization as an option for "Revision displayed on default page view".

This option has sub-options, see "How the published version is selected".',
	'stabilization-def2' => '{{Flagged Revs-small}}
Used on Special:Stabilization as an option for "Revision displayed on default page view".',
	'stabilization-restrict' => '{{Flagged Revs}}
Used on Special:Stabilization.
This means: "restrictions on automatic reviews" (\'\'it does not mean: 
"automatically review the restrictions")

Note that this restricts not just auto-reviewing, but manual reviewing as well.
See http://en.labs.wikimedia.org/wiki/Special:Stabilization/Main_Page for more information (you can give yourself review rights)',
	'stabilization-restrict-none' => "{{Flagged Revs}}
Used on Special:Stabilization.
Message wording is a bit vague due to the fact that wikis can restrict the 'review' and 'autoreview' rights site-wide to any extent. It should *not* say \"allow all users\" or such.",
	'stabilization-submit' => '{{Flagged Revs}}
Used on Special:Stabilization.
{{Identical|Confirm}}',
	'stabilization-notexists' => '{{Flagged Revs}}
Used on Special:Stabilization.
* $1 The page name',
	'stabilization-notcontent' => '{{Flagged Revs}}
Used on Special:Stabilization.
* $1 The page name',
	'stabilization-comment' => '{{Flagged Revs}}
Used on Special:Stabilization.
{{Identical|Reason}}',
	'stabilization-otherreason' => '{{Flagged Revs}}
Used on Special:Stabilization.
{{Identical|Other reason}}',
	'stabilization-expiry' => '{{Flagged Revs}}
Used on Special:Stabilization.
{{Identical|Expires}}',
	'stabilization-othertime' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilization-def-short' => '{{Flagged Revs}}
{{Identical|Default}}
Used at Special:Log for entries made by Special:Stabilization. It is displayed as in log entries that have text like "[Default: Stable, autoreview=sysop]".',
	'stabilization-def-short-0' => '{{Flagged Revs}}
{{Identical|Current}}
Used at Special:Log for entries made by Special:Stabilization. It is displayed as in log entries that have text like "[Default: Stable, autoreview=sysop]".',
	'stabilization-def-short-1' => '{{Flagged Revs}}
{{Identical|Stable}}
Used at Special:Log for entries made by Special:Stabilization. It is displayed as in log entries that have text like "[Default: Stable, autoreview=sysop]".',
	'stabilize_page_invalid' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_page_notexists' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_page_unreviewable' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_invalid_autoreview' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_invalid_level' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_expiry_invalid' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_expiry_old' => '{{Flagged Revs}}
Used on Special:Stabilization.',
	'stabilize_denied' => '{{Flagged Revs}}
Used on Special:Stabilization. Generic permission error.',
	'stabilize-expiring' => "{{Flagged Revs}}
Used on Special:Stabilization.

Used to indicate when something expires.
$1 is a time stamp in the wiki's content language.
$2 is the corresponding date in the wiki's content language.
$3 is the corresponding time in the wiki's content language.

{{Identical|Expires $1 (UTC)}}",
	'stabilization-review' => '{{Flagged Revs}}
Used on Special:Stabilization.
This refers to an option that reviews the current revision of the page when the user changes the FlaggedRevs settings for the page.',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'stabilization' => 'Bladsy-stabilisasie',
	'stabilization-page' => 'Bladsynaam:',
	'stabilization-leg' => 'Bevestig stabiele weergawe instellings',
	'stabilization-def1' => 'Die stabiele weergawe, indien nie teenwoordig is nie, dan is die jongste hersiening',
	'stabilization-def2' => 'Die nuutste weergawe',
	'stabilization-restrict-none' => 'Geen addisionele beperkinge',
	'stabilization-submit' => 'Bevestig',
	'stabilization-notexists' => 'Daar is geen bladsy genaamd "[[:$1|$1]]" nie.
Geen konfigurasie is moontlik nie.',
	'stabilization-comment' => 'Rede:',
	'stabilization-otherreason' => 'Ander rede:',
	'stabilization-expiry' => 'Verval:',
	'stabilization-othertime' => 'Ander tyd:',
	'stabilization-def-short' => 'Standaard',
	'stabilization-def-short-0' => 'Huidig',
	'stabilization-def-short-1' => 'Gepubliseer',
	'stabilize_page_invalid' => 'De naam van die teikenbladsy is ongeldig.',
	'stabilize_page_notexists' => 'Die teikenbladsy bestaan ​​nie.',
	'stabilize_page_unreviewable' => "Die teikenbladsy is nie in 'n hersienbare naamspasie nie.",
	'stabilize_invalid_autoreview' => 'Ongeldige autoreview beperking.',
	'stabilize_invalid_level' => 'Ongeldige beskerming vlak.',
	'stabilize_expiry_invalid' => 'Ongeldige vervaldatum.',
	'stabilize_expiry_old' => 'Die vervaldatum is reeds verby.',
	'stabilize_denied' => 'Toestemming geweier.',
	'stabilize-expiring' => 'verval $1 (UTC)',
	'stabilization-review' => 'Merk die huidige weergawe nagegaan',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'stabilization-tab' => 'veteriner',
	'stabilization' => 'stabilizimin e faqes',
	'stabilization-text' => "''' Ndryshimi parametrat e mëposhtëm për të rregulluar si versionin e publikuar i [[:$1|$1]] është zgjedhur dhe të shfaqet. '''",
	'stabilization-perm' => 'Llogaria juaj nuk ka leje për të ndryshuar konfigurimin versionin e botuar. Këtu janë parametrat aktual për [[:$1|$1]]:',
	'stabilization-page' => 'Emri i faqes:',
	'stabilization-leg' => 'Paneli i Konfirmo publikuar versionin',
	'stabilization-def' => 'Revision shfaqet në faqe të parë default',
	'stabilization-def1' => 'Versioni i publikuar, e nëse nuk është i pranishëm, atëherë / draftin aktual',
	'stabilization-def2' => 'Aktuale / rishikim projekt',
	'stabilization-restrict' => 'Rishikimi / auto-përmbledhje kufizime',
	'stabilization-restrict-none' => 'Nuk ka kufizime shtesë',
	'stabilization-submit' => 'Konfirmoj',
	'stabilization-notexists' => 'Nuk ka asnjë faqe quhet "[[:$1|$1]] ". Nuk konfigurimit është e mundur.',
	'stabilization-notcontent' => 'Faqja "[[:$1|$1]] "nuk mund të rishikohet. Nr konfigurimit është e mundur.',
	'stabilization-comment' => 'Arsyeja:',
	'stabilization-otherreason' => 'arsye të tjera:',
	'stabilization-expiry' => 'Skadon:',
	'stabilization-othertime' => 'kohë të tjera:',
	'stabilization-def-short' => 'Default',
	'stabilization-def-short-0' => 'Aktual',
	'stabilization-def-short-1' => 'Publikuar',
	'stabilize_page_invalid' => 'Faqja e objektivit titull është i pavlefshëm.',
	'stabilize_page_notexists' => 'Faqja objektiv nuk ekziston.',
	'stabilize_page_unreviewable' => 'Faqja objektivi nuk është në hapësirën rishikueshme.',
	'stabilize_invalid_autoreview' => 'kufizimin e pavlefshme autoreview',
	'stabilize_invalid_level' => 'nivelin e pavlefshme mbrojtje.',
	'stabilize_expiry_invalid' => 'data e skadimit pavlefshme.',
	'stabilize_expiry_old' => 'Kjo kohë ka kaluar skadimit tashmë.',
	'stabilize-expiring' => 'kalon $1 (UTC)',
	'stabilization-review' => 'Mark versionin e fundit kontrolluar',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'stabilization-comment' => 'ምክንያቱ፦',
	'stabilization-def-short-0' => 'ያሁኑኑ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'stabilization-tab' => '(vet)',
	'stabilization' => "Estabilización d'a pachina",
	'stabilization-text' => "'''Cambeye a confeguración d'abaixo si quier achustar a forma de trigar y amostrar a versión acceptada de [[:$1|$1]].'''",
	'stabilization-perm' => "A suya cuenta no tiene premisos ta cambiar a confeguración d'a versión acceptada. Os achustes actuals ta [[:$1|$1]] s'amuestran aquí:",
	'stabilization-page' => "Nombre d'a pachina:",
	'stabilization-leg' => "Confirmar a confeguración d'a versión acceptada",
	'stabilization-def' => "A revisión s'amuestra en a pachina de visualización por defecto",
	'stabilization-def1' => 'A versión estable; si no ye present, alavez a zaguera versión',
	'stabilization-def2' => 'A zaguera versión',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'No bi ha garra pachina tetulata "[[:$1|$1]]". 
No ye posible confegurar-la.',
	'stabilization-notcontent' => 'A pachina "[[:$1|$1]]" no se puede revisar.
No ye posible confegurar-la.',
	'stabilization-comment' => 'Razón:',
	'stabilization-otherreason' => 'Atra razón:',
	'stabilization-expiry' => 'Circunduce:',
	'stabilization-def-short' => 'Por defecto',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Acceptada',
	'stabilize_expiry_invalid' => 'A calendata de circunducción no ye conforme.',
	'stabilize_expiry_old' => 'Ista calendata de circunducción ya ye pasata.',
	'stabilize-expiring' => 'circunduce o $1 (UTC)',
);

/** Arabic (العربية)
 * @author ;Hiba;1
 * @author Alnokta
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'stabilization-tab' => 'تج',
	'stabilization' => 'تثبيت الصفحة',
	'stabilization-text' => "'''غير الإعدادات بالأسفل لضبط الكيفية التي بها النسخة المستقرة من [[:$1|$1]] يتم اختيارها وعرضها.'''",
	'stabilization-perm' => 'حسابك لا يمتلك الصلاحية لتغيير إعدادات النسخة المنشورة.
هنا الإعدادات الحالية ل[[:$1|$1]]:',
	'stabilization-page' => 'اسم الصفحة:',
	'stabilization-leg' => 'تأكيد إعدادات النسخة المنشورة',
	'stabilization-def' => 'المراجعة المعروضة عند رؤية الصفحة افتراضيا',
	'stabilization-def1' => 'صيغة مستقرة ، فإن لم تكن موجودة ،  فإنه آخر تنقيح',
	'stabilization-def2' => 'آخر مراجعة',
	'stabilization-restrict' => 'قيود المراجعة/المراجعة التلقائية',
	'stabilization-restrict-none' => 'لا ضوابط إضافية',
	'stabilization-submit' => 'تأكيد',
	'stabilization-notexists' => 'لا توجد صفحة بالاسم "[[:$1|$1]]".
لا ضبط ممكن.',
	'stabilization-notcontent' => 'الصفحة "[[:$1|$1]]" لا يمكن مراجعتها.
لا ضبط ممكن.',
	'stabilization-comment' => 'السبب:',
	'stabilization-otherreason' => 'سبب آخر:',
	'stabilization-expiry' => 'تنتهي:',
	'stabilization-othertime' => 'وقت آخر:',
	'stabilization-def-short' => 'افتراضي',
	'stabilization-def-short-0' => 'حالي',
	'stabilization-def-short-1' => 'منشورة',
	'stabilize_page_invalid' => 'عنوان الصفحة الهدف ليس صالحًا.',
	'stabilize_page_notexists' => 'الصفحة الهدف غير موجودة.',
	'stabilize_page_unreviewable' => 'الصفحة الهدف ليست في نطاق يسمح بالمراجعة.',
	'stabilize_invalid_autoreview' => 'تقييد مراجعة تلقائية غير صالح.',
	'stabilize_invalid_level' => 'مستوى حماية غير صالح.',
	'stabilize_expiry_invalid' => 'تاريخ انتهاء غير صحيح.',
	'stabilize_expiry_old' => 'تاريخ الانتهاء هذا مر بالفعل.',
	'stabilize_denied' => 'الإذن مرفوض!',
	'stabilize-expiring' => 'تنتهي في $1 (UTC)',
	'stabilization-review' => 'عام على النسخة الحالية كمراجعة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'stabilization-page' => 'ܫܡܐ ܕܦܐܬܐ:',
	'stabilization-submit' => 'ܚܬܬ',
	'stabilization-comment' => 'ܥܠܬܐ:',
	'stabilization-otherreason' => 'ܥܠܬܐ ܐܚܪܬܐ:',
	'stabilization-othertime' => 'ܥܕܢܐ ܐܚܪܬܐ:',
	'stabilization-def-short-0' => 'ܗܫܝܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'stabilization-tab' => 'تج',
	'stabilization' => 'تثبيت الصفحة',
	'stabilization-text' => "'''غيّر التظبيطات اللى تحت علشان تظبط ازاى تختار و تبيّن النسخه المنشوره بتاعة [[:$1|$1]].'''",
	'stabilization-perm' => 'حسابك ما عندوش اذن علشان يغيّر ظبطة النسخه المنشوره.
هنا التظبيطات بتاعة دلوقتى لـ [[:$1|$1]]:',
	'stabilization-page' => 'اسم الصفحة:',
	'stabilization-leg' => 'اتأكيد من تظبيطات النسخه المنشوره',
	'stabilization-def' => 'المراجعه المعروضه عند رؤيه الصفحه افتراضيا',
	'stabilization-def1' => 'المراجعه المنشوره; لو مش موجوده, يبقى المراجعه بتاعة دلوقتى/المسوده',
	'stabilization-def2' => 'المراجعه الحالية/المسودة',
	'stabilization-restrict' => 'ضوابط المراجعه التلقائية',
	'stabilization-restrict-none' => 'لا ضوابط إضافية',
	'stabilization-submit' => 'تأكيد',
	'stabilization-notexists' => 'لا توجد صفحه بالاسم "[[:$1|$1]]".
لا ضبط ممكن.',
	'stabilization-notcontent' => 'الصفحه "[[:$1|$1]]" لا يمكن مراجعتها.
لا ضبط ممكن.',
	'stabilization-comment' => 'السبب:',
	'stabilization-otherreason' => 'سبب آخر:',
	'stabilization-expiry' => 'تنتهي:',
	'stabilization-othertime' => 'وقت آخر:',
	'stabilization-def-short' => 'افتراضي',
	'stabilization-def-short-0' => 'حالي',
	'stabilization-def-short-1' => 'منشوره',
	'stabilize_expiry_invalid' => 'تاريخ انتهاء غير صحيح.',
	'stabilize_expiry_old' => 'تاريخ الانتهاء هذا مر بالفعل.',
	'stabilize-expiring' => 'تنتهى فى $1 (UTC)',
	'stabilization-review' => 'راجع النسخه الحالية',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'stabilization-tab' => '(aq)',
	'stabilization' => 'Estabilización de páxines',
	'stabilization-text' => "'''Camudar les preferencies d'embaxo p'axustar cómo se seleiciona y s'amuesa la versión estable de [[:$1|$1]].'''",
	'stabilization-perm' => 'La to cuenta nun tienen permisos pa camudar la configuración de la versión estable.
Esta ye la configuración actual de [[:$1|$1]]:',
	'stabilization-page' => 'Nome de la páxina:',
	'stabilization-leg' => 'Confirmar la configuración de la versión estable',
	'stabilization-def' => "Revisión que s'amuesa na vista de páxina predeterminada",
	'stabilization-def1' => 'La versión estable; si nun la hai, entós la cabera revisión',
	'stabilization-def2' => 'La cabera revisión',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Nun esiste la páxina "[[:$1|$1]]". Nun ye posible la configuración.',
	'stabilization-notcontent' => 'La páxina "[[:$1|$1]]" nun pue ser revisada. Nun ye posible la configuración.',
	'stabilization-comment' => 'Motivu:',
	'stabilization-expiry' => 'Caduca:',
	'stabilization-def-short' => 'Predetermináu',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Estable',
	'stabilize_expiry_invalid' => 'Fecha de caducidá non válida.',
	'stabilize_expiry_old' => 'Esta caducidá yá tien pasao.',
	'stabilize-expiring' => "caduca'l $1 (UTC)",
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 * @author Vugar 1981
 */
$messages['az'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Səhifənin stabilləşdirilməsi',
	'stabilization-text' => '[[:$1|$1]]  üçün yoxlanılmış versiyanın seçilib görüntülənməsini nizamlamaq üçün nizamlamaları dəyişin',
	'stabilization-page' => 'Səhifə adı:',
	'stabilization-def2' => 'Son yoxlama',
	'stabilization-submit' => 'Təsdiq et',
	'stabilization-comment' => 'Səbəb:',
	'stabilization-otherreason' => 'Digər səbəb:',
	'stabilization-expiry' => 'Vaxtı bitib:',
	'stabilization-othertime' => 'Başqa vaxt:',
	'stabilization-def-short' => 'Susmaya görə',
	'stabilization-def-short-0' => 'Hazırki',
	'stabilize_invalid_level' => 'Keçərsiz mühafizə səviyyəsi',
	'stabilize_expiry_invalid' => 'Yanlış bitmə tarixi.',
	'stabilize_denied' => 'İcazə yoxdur.',
	'stabilize-expiring' => '$1 (UTC)-da bitir',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'stabilization-comment' => 'Сәбәп:',
	'stabilization-otherreason' => 'Башҡа сәбәп:',
	'stabilization-expiry' => 'Тамамлана:',
	'stabilization-othertime' => 'Башҡа ваҡыт:',
	'stabilization-def-short' => 'Ғәҙәттәге',
	'stabilization-def-short-0' => 'Хәҙерге',
	'stabilization-def-short-1' => 'Тотороҡло',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'stabilization-submit' => 'Bestäting',
	'stabilization-comment' => 'Grund:',
	'stabilization-otherreason' => 'Ãndara Grund:',
	'stabilization-expiry' => 'Güit bis:',
	'stabilization-othertime' => 'Ãndare Zeid:',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'stabilization-tab' => 'وت',
	'stabilization' => '‏ثبات کتن صفحه',
	'stabilization-text' => "''''عوض کن تنظیمات جهلی په شرکتن شی چه چطورکا نسخه ثابت  [[:$1|$1]]  انتخاب و پیش دارگ بیت''''",
	'stabilization-perm' => 'شمی حساب اجازت به عوض کتن تنظیمات نسخه ثابت نیست.
ادان هنوکین تنظیمات په  [[:$1|$1]]:',
	'stabilization-page' => 'نام صفحه:',
	'stabilization-leg' => 'تنظیمات نسخه ثابت تایید کن',
	'stabilization-def' => 'بازبینی ته پیش فرضین دیستن جاهکیت',
	'stabilization-def1' => 'ثابتین بازبینی; اگر نیست، گوڈء هنوکین',
	'stabilization-def2' => 'هنوکین بازبینی',
	'stabilization-submit' => 'تایید',
	'stabilization-notexists' => 'صفحه ای په نام "[[:$1|$1]]" نیست.
هچ تنظیمی ممکن نهنت.',
	'stabilization-notcontent' => 'صفحه "[[:$1|$1]]" نه تونیت باز بینی بیت.
هچ تنظیمی ممکن نهنت.',
	'stabilization-comment' => 'دلیل:',
	'stabilization-expiry' => 'هلیت:',
	'stabilization-def-short' => 'پیش فرض',
	'stabilization-def-short-0' => 'هنوکین',
	'stabilization-def-short-1' => 'ثابت',
	'stabilize_expiry_invalid' => 'نامعتبرین تاریخ هلگ',
	'stabilize_expiry_old' => 'ای زمان انقضا هنو هلتت.',
	'stabilize-expiring' => 'وهدی هلیت  $1 (UTC)',
);

/** Belarusian (Беларуская)
 * @author Хомелка
 */
$messages['be'] = array(
	'stabilization-tab' => '(кк)',
	'stabilization' => 'Стабілізацыя старонкі',
	'stabilization-text' => "'''З дапамогай прыведзеных ніжэй наладак можна кіраваць выбарам і адлюстраваннем апублікаванай версіі старонкі [[:$1|$1]].'''",
	'stabilization-perm' => 'Вашаму ўліковага запісу не дастаткова паўнамоцтваў для змены наладак апублікаваных версій.
Тут прыведзены бягучыя наладкі для [[:$1|$1]]:',
	'stabilization-page' => 'Назва старонкі:',
	'stabilization-leg' => 'Пацвярджэнне наладак апублікаванай версіі',
	'stabilization-def' => 'Версія, якая адлюстроўваецца па змаўчанні',
	'stabilization-def1' => 'Стабільная версія; калі такой няма, то апошняя версія',
	'stabilization-def2' => 'Апошняя версія',
	'stabilization-restrict' => 'Абмежаванні праверкі/аўтаправеркі',
	'stabilization-restrict-none' => 'Няма дадатковых абмежаванняў',
	'stabilization-submit' => 'Пацвердзіць',
	'stabilization-notexists' => 'Адсутнічае старонка з назвай «[[:$1|$1]]». Наладка немагчыма.',
	'stabilization-notcontent' => 'Старонка «[[:$1|$1]]» не можа быць праверана. Наладка немагчыма.',
	'stabilization-comment' => 'Прычына:',
	'stabilization-otherreason' => 'Іншая прычына:',
	'stabilization-expiry' => 'Канчаецца:',
	'stabilization-othertime' => 'Іншы час:',
	'stabilization-def-short' => 'Па змаўчанні',
	'stabilization-def-short-0' => 'Бягучая',
	'stabilization-def-short-1' => 'Апублікаваная',
	'stabilize_page_invalid' => 'Недапушчальная назва мэтавай старонкі.',
	'stabilize_page_notexists' => 'Мэтавая старонка не існуе.',
	'stabilize_page_unreviewable' => 'Мэтавая старонка не знаходзіцца ў правяраемай прасторы імёнаў.',
	'stabilize_invalid_autoreview' => 'Памылковыя абмежаванні аўтаправеркі',
	'stabilize_invalid_level' => 'Памылковы ўзровень абароны.',
	'stabilize_expiry_invalid' => 'Памылковая дата заканчэння.',
	'stabilize_expiry_old' => 'Абраны час заканчэння дзеяння ўжо прайшло.',
	'stabilize_denied' => 'Доступ забаронены.',
	'stabilize-expiring' => 'Скончыцца  $1 (UTC)',
	'stabilization-review' => 'Адзначыць бягучую версію як правераную',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'stabilization-tab' => 'Бачная вэрсія старонкі',
	'stabilization' => 'Стабілізацыя старонкі',
	'stabilization-text' => "'''Зьмяніце налады ніжэй, якім чынам павінна выбірацца і паказвацца апублікаваная вэрсія старонкі [[:$1|$1]].'''",
	'stabilization-perm' => 'Ваш рахунак ня мае правоў для зьмены канфігурацыі апублікаванай вэрсіі.
Тут пададзеныя цяперашнія налады для [[:$1|$1]]:',
	'stabilization-page' => 'Назва старонкі:',
	'stabilization-leg' => 'Пацьвердзіць налады апублікаванай вэрсіі',
	'stabilization-def' => 'Вэрсія, якая паказваецца па змоўчваньні',
	'stabilization-def1' => 'Стабільная вэрсія; калі яе не існуе, то апошняя вэрсія',
	'stabilization-def2' => 'Апошняя вэрсія',
	'stabilization-restrict' => 'Абмежаваньні праверкі/аўтаматычнай праверкі',
	'stabilization-restrict-none' => 'Няма дадатковых абмежаваньняў',
	'stabilization-submit' => 'Пацьвердзіць',
	'stabilization-notexists' => 'Не існуе старонкі з назвай «[[:$1|$1]]».
Немагчыма зьмяніць налады.',
	'stabilization-notcontent' => 'Старонка «[[:$1|$1]]» ня можа быць правераная.
Немагчыма зьмяніць налады.',
	'stabilization-comment' => 'Прычына:',
	'stabilization-otherreason' => 'Іншая прычына:',
	'stabilization-expiry' => 'Тэрмін:',
	'stabilization-othertime' => 'Іншы час:',
	'stabilization-def-short' => 'Па змоўчваньні',
	'stabilization-def-short-0' => 'Цяперашняя',
	'stabilization-def-short-1' => 'Апублікаваная',
	'stabilize_page_invalid' => 'Няслушная назва мэтавай старонкі.',
	'stabilize_page_notexists' => 'Мэтавая старонка не існуе.',
	'stabilize_page_unreviewable' => 'Мэтавай старонкі няма ў прасторы назваў, якую можна рэцэнзаваць.',
	'stabilize_invalid_autoreview' => 'Няслушнае абмежаваньне аўтаматычнага рэцэнзаваньня',
	'stabilize_invalid_level' => 'Няслушны ўзровень абароны.',
	'stabilize_expiry_invalid' => 'Няслушны тэрмін.',
	'stabilize_expiry_old' => 'Час сканчэньня ўжо прайшоў.',
	'stabilize_denied' => 'Доступ забаронены.',
	'stabilize-expiring' => 'канчаецца $1 (UTC)',
	'stabilization-review' => 'Пазначыць цяперашнюю вэрсію як правераную',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'stabilization' => 'Устойчивост на страницата',
	'stabilization-page' => 'Име на страницата:',
	'stabilization-leg' => 'Потвърждение на настройките за устойчива версия',
	'stabilization-def' => 'Версия, показвана по подразбиране',
	'stabilization-def1' => 'Устойчивата версия; ако няма такава, тогава текущата',
	'stabilization-def2' => 'Текущата версия или чернова',
	'stabilization-restrict-none' => 'Няма допълнителни ограничения',
	'stabilization-submit' => 'Потвърждаване',
	'stabilization-notexists' => 'Не съществува страница „[[:$1|$1]]“. Не е възможно конфигуриране.',
	'stabilization-notcontent' => 'Страницата "[[:$1|$1]]" не може да бъде рецензирана.
Невъзможно конфигурирането.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Друга причина:',
	'stabilization-expiry' => 'Изтича на:',
	'stabilization-othertime' => 'Друго време:',
	'stabilization-def-short' => 'По подразбиране',
	'stabilization-def-short-0' => 'Текуща',
	'stabilization-def-short-1' => 'Устойчива',
	'stabilize_page_invalid' => 'Заглавието на целевата страница е невалидно.',
	'stabilize_page_notexists' => 'Целевата страница не съществува.',
	'stabilize_page_unreviewable' => 'Целевата страница не е от именно пространство, подлежащо на рецензия',
	'stabilize_invalid_level' => 'Невалидно ниво на защита.',
	'stabilize_expiry_invalid' => 'Невалидна дата на изтичане.',
	'stabilize_expiry_old' => 'Дата на изтичане вече е отминала.',
	'stabilize_denied' => 'Достъпът е отказан.',
	'stabilize-expiring' => 'изтича на $1 (UTC)',
	'stabilization-review' => 'Отбелязване на текущата версия като проверена',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Ehsanulhb
 * @author Zaheen
 */
$messages['bn'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'পাতা স্থিতিকরণ',
	'stabilization-page' => 'পাতার নাম:',
	'stabilization-def2' => 'সাম্প্রতিক সংশোধন',
	'stabilization-submit' => 'নিশ্চিত করুন',
	'stabilization-comment' => 'কারণ:',
	'stabilization-otherreason' => 'অন্য কারণ:',
	'stabilization-expiry' => 'মেয়াদ উত্তীর্ণ:',
	'stabilization-othertime' => 'অন্য সময়:',
	'stabilization-def-short' => 'পূর্বনির্ধারিত',
	'stabilization-def-short-0' => 'বর্তমান',
	'stabilization-def-short-1' => 'গৃহীত',
	'stabilize_expiry_invalid' => 'অবৈধ মেয়াদ উত্তীর্ণের তারিখ।',
	'stabilize_expiry_old' => 'মেয়াদ উত্তীর্ণের সময় পার হয়ে গেছে।',
	'stabilize-expiring' => 'মেয়াদ উত্তীর্ণ হবে $1 (UTC)',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'stabilization-tab' => 'argas',
	'stabilization' => 'Stabiladur ar bajenn',
	'stabilization-text' => "'''Cheñch ar c'hefluniadur dindan da spisaat an doare ma vez diuzet ha diskwelet stumm embannet [[:$1|$1]].'''",
	'stabilization-perm' => "N'eo ket aotreet ho kont da gemmañ arventennoù ar stumm embannet.
Setu an arventennoù red eus [[:$1|$1]] :",
	'stabilization-page' => 'Anv ar bajenn :',
	'stabilization-leg' => 'Kadarnaat arventennoù ar stumm embannet',
	'stabilization-def' => 'Stumm diskwelet er mod diskwel dre ziouer',
	'stabilization-def1' => 'Ar stumm stabil ma vez; a-hend-all lakaat an adweladenn ziwezhañ',
	'stabilization-def2' => 'An adweladenn ziwezhañ',
	'stabilization-restrict' => 'Strishadurioù adlenn/adlenn emgefre',
	'stabilization-restrict-none' => 'Strishadurioù ouzhpenn ebet',
	'stabilization-submit' => 'Kadarnaat',
	'stabilization-notexists' => 'N\'eus pajenn ebet anvet "[[:$1|$1]]".
N\'haller ket kefluniañ netra.',
	'stabilization-notcontent' => 'N\'hall ket ar bajenn "[[:$1|$1]]" bezañ adwelet.
N\'haller ket kefluniañ netra.',
	'stabilization-comment' => 'Abeg :',
	'stabilization-otherreason' => 'Abeg all :',
	'stabilization-expiry' => "A ya d'e dermen",
	'stabilization-othertime' => 'Mare all :',
	'stabilization-def-short' => 'Dre ziouer',
	'stabilization-def-short-0' => 'Red',
	'stabilization-def-short-1' => 'Embannet',
	'stabilize_page_invalid' => 'Fall eo titl ar bajenn buket.',
	'stabilize_page_notexists' => "N'eus ket eus ar bajenn buket.",
	'stabilize_page_unreviewable' => "N'emañ ket ar bajenn buket en un esaouenn anv a c'haller adwelet",
	'stabilize_invalid_autoreview' => 'Strishadur adlenn emgefre direizh',
	'stabilize_invalid_level' => 'Live gwareziñ direizh.',
	'stabilize_expiry_invalid' => 'Direizh eo an deiziad termen.',
	'stabilize_expiry_old' => 'Tremenet eo dija an amzer termen-se.',
	'stabilize_denied' => "Aotre nac'het.",
	'stabilize-expiring' => "Termenet d'an $1 (UTC)",
	'stabilization-review' => 'Merkañ ar stumm red evel adwelet.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'stabilization-tab' => 'konfig',
	'stabilization' => 'Stabilizacija stranice',
	'stabilization-text' => "'''Promijenite postavke ispod da biste podesili kako će se stabilna verzija stranice [[:$1|$1]] odabrati i prikazati.'''",
	'stabilization-perm' => 'Vaš račun nema dopuštenje da mijenja konfiguraciju objavljene verzije.
Ovdje su trenutne postavke za [[:$1|$1]]:',
	'stabilization-page' => 'Naslov stranice:',
	'stabilization-leg' => 'Potvrdite postavke objavljene verzije',
	'stabilization-def' => 'Revizija prikazana kao pretpostavljena stranica',
	'stabilization-def1' => 'Stabilna verzija, ako je nema, onda posljednja revizija',
	'stabilization-def2' => 'Posljednja revizija',
	'stabilization-restrict' => 'Ograničenja za preglede/automatske preglede',
	'stabilization-restrict-none' => 'Bez posebnih ograničenja',
	'stabilization-submit' => 'Potvrdi',
	'stabilization-notexists' => 'Nema stranice pod nazivom "[[:$1|$1]]".
Nije moguća konfiguracija.',
	'stabilization-notcontent' => 'Stranica "[[:$1|$1]]" ne može biti provjerena.
Nije moguća konfiguracija.',
	'stabilization-comment' => 'Razlog:',
	'stabilization-otherreason' => 'Ostali razlozi:',
	'stabilization-expiry' => 'Ističe:',
	'stabilization-othertime' => 'Ostali period:',
	'stabilization-def-short' => 'Standardno',
	'stabilization-def-short-0' => 'Trenutna',
	'stabilization-def-short-1' => 'Objavljeno',
	'stabilize_page_invalid' => 'Naslov ciljne stranice nije valjan.',
	'stabilize_page_notexists' => 'Ciljna stranica ne postoji.',
	'stabilize_page_unreviewable' => 'Ciljna stranica nije u imenskom prostoru koji se može provjeravati.',
	'stabilize_invalid_autoreview' => 'Nevaljano ograničenje automatskog provjeravanja.',
	'stabilize_invalid_level' => 'Nevaljan nivo zaštite.',
	'stabilize_expiry_invalid' => 'Nevaljan datum isticanja.',
	'stabilize_expiry_old' => 'Ovo vrijeme isticanja je već prošlo.',
	'stabilize_denied' => 'Pristup odbijen.',
	'stabilize-expiring' => 'ističe $1 (UTC)',
	'stabilization-review' => 'Označite trenutnu reviziju provjerenom',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Paucabot
 * @author Qllach
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'stabilization-page' => 'Nom de la pàgina:',
	'stabilization-def2' => 'La revisió actual/esborrany',
	'stabilization-submit' => 'Confirma',
	'stabilization-notexists' => 'No hi ha cap pàgina que s\'anomeni "[[:$1|$1]]".
No és possible fer cap configuració.',
	'stabilization-comment' => 'Motiu:',
	'stabilization-otherreason' => 'Altres raons:',
	'stabilization-expiry' => 'Venç:',
	'stabilization-othertime' => 'Un altre temps:',
	'stabilization-def-short' => 'Per defecte',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Publicat',
	'stabilize_expiry_invalid' => 'La data de venciment no és vàlida.',
	'stabilize_expiry_old' => 'Aquesta data de venciment ja ha passat.',
	'stabilize_denied' => 'Permís denegat.',
	'stabilize-expiring' => 'expira $1 (UTC)',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'stabilization-page' => 'Агlон цlе:',
	'stabilization-submit' => 'Къобалде',
	'stabilization-comment' => 'Бахьан:',
	'stabilization-otherreason' => 'Кхин бахьан:',
	'stabilization-expiry' => 'Чекхйолу:',
	'stabilization-othertime' => 'Кхин хан:',
	'stabilization-def-short' => 'Iад йитарца',
	'stabilization-def-short-0' => 'хlинцлера',
	'stabilization-def-short-1' => 'Чутоьхнарг',
	'stabilize_page_invalid' => 'Агlонан чулацамца йогlуш йоцу цlе.',
	'stabilize_page_notexists' => 'Iалаше хьажийна агlо йа йац.',
	'stabilize-expiring' => 'чакхйолу $1 (UTC)',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'stabilization-submit' => 'پشتدار بکەرەوە',
	'stabilization-comment' => 'هۆکار:',
	'stabilization-otherreason' => 'هۆکاری دیکە:',
	'stabilization-expiry' => 'ھەتا:',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Jkjk
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'stabilization-tab' => 'stabilizace',
	'stabilization' => 'Stabilizace stránky',
	'stabilization-text' => "'''Změňte nastavení níže pro přizpůsobení toho, jak se vybírá stabilní verze stránky [[:$1|$1]] a co se zobrazí.'''",
	'stabilization-perm' => 'Tento účet nemá povoleno měnit nastavení stabilní verze. Níže je současné nastavení stránky [[:$1|$1]]:',
	'stabilization-page' => 'Jméno stránky:',
	'stabilization-leg' => 'Potvrdit nastavení stabilní verze',
	'stabilization-def' => 'Verze zobrazená jako výchozí',
	'stabilization-def1' => 'Stabilní revize; pokud neexistuje, je to současná revize/návrh',
	'stabilization-def2' => 'Současná/návrhová verze',
	'stabilization-restrict' => 'Omezení automatického posuzování',
	'stabilization-restrict-none' => 'Žádná další omezení',
	'stabilization-submit' => 'Potvrdit',
	'stabilization-notexists' => 'Neexistuje stránka "[[:$1|$1]]". Nastavení není možné.',
	'stabilization-notcontent' => 'Stránka „[[:$1|$1]]“ nemůže být posouzena. Nastavení není možné.',
	'stabilization-comment' => 'Důvod:',
	'stabilization-otherreason' => 'Jiný důvod:',
	'stabilization-expiry' => 'Čas vypršení:',
	'stabilization-othertime' => 'Jiný čas:',
	'stabilization-def-short' => 'Výchozí',
	'stabilization-def-short-0' => 'současná',
	'stabilization-def-short-1' => 'Stabilní',
	'stabilize_page_invalid' => 'Cílová stránka je neplatná.',
	'stabilize_page_notexists' => 'Cílová stránka neexistuje.',
	'stabilize_page_unreviewable' => 'Cílová stránka není v posuzovatelném jmenném prostoru.',
	'stabilize_invalid_autoreview' => 'Nesprávné omezení automatického posuzování.',
	'stabilize_invalid_level' => 'Neplatná úroveň ochrany.',
	'stabilize_expiry_invalid' => 'Datum vypršení je chybné.',
	'stabilize_expiry_old' => 'Čas vypršení již minul.',
	'stabilize_denied' => 'Přístup odmítnut.',
	'stabilize-expiring' => 'vyprší $1 (UTC)',
	'stabilization-review' => 'Posoudit aktuální verzi',
);

/** Danish (Dansk)
 * @author Froztbyte
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'stabilization-def2' => 'Den seneste version',
	'stabilization-submit' => 'Bekræft',
	'stabilization-notexists' => 'Der findes ingen side kaldet "[[:$1|$1]]".
Ingen konfigurering er mulig.',
	'stabilization-comment' => 'Årsag:',
	'stabilization-otherreason' => 'Anden årsag:',
	'stabilization-expiry' => 'Udløb:',
	'stabilization-othertime' => 'Anden tid:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Nuværende',
	'stabilization-def-short-1' => 'Publiseret',
	'stabilize_invalid_level' => 'Ugyldigt beskyttelsesniveau.',
	'stabilize_expiry_old' => 'Udløbstidspunktet er allerede passeret.',
	'stabilize_denied' => 'Tilgang nægtet.',
	'stabilize-expiring' => 'til $1 (UTC)',
	'stabilization-review' => 'Marker den nuværende version som kontrolleret',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Giftpflanze
 * @author Kghbln
 * @author Metalhead64
 * @author Purodha
 * @author Steef389
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'stabilization-tab' => 'Konfig.',
	'stabilization' => 'Seitenkonfiguration',
	'stabilization-text' => "'''Ändere die folgenden Einstellungen, um festzulegen, wie die zu veröffentlichende Version von „[[:$1|$1]]“ ausgewählt und angezeigt werden soll.'''",
	'stabilization-perm' => 'Du hast nicht die erforderliche Berechtigung, um die Einstellungen der markierten Version zu ändern.
Die aktuellen Einstellungen für „[[:$1|$1]]“ sind:',
	'stabilization-page' => 'Seitenname:',
	'stabilization-leg' => 'Bestätige die Einstellungen bezüglich der zu veröffentlichenden Version',
	'stabilization-def' => 'Angezeigte Version in der normalen Seitenansicht',
	'stabilization-def1' => 'Die stabile Version; sofern keine vorhanden ist, die aktuelle Version',
	'stabilization-def2' => 'Die aktuelle Version',
	'stabilization-restrict' => 'Einschränkungen bezüglich des Markierens/des automatischen Markierens',
	'stabilization-restrict-none' => 'Keine zusätzlichen Einschränkungen',
	'stabilization-submit' => 'Bestätigen',
	'stabilization-notexists' => 'Es gibt keine Seite „[[:$1|$1]]“. Keine Einstellungen möglich.',
	'stabilization-notcontent' => 'Die Seite „[[:$1|$1]]“ kann nicht markiert werden. Konfiguration ist nicht möglich.',
	'stabilization-comment' => 'Grund:',
	'stabilization-otherreason' => 'Anderer Grund:',
	'stabilization-expiry' => 'Gültig bis:',
	'stabilization-othertime' => 'Andere Zeit:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktuell',
	'stabilization-def-short-1' => 'stabile Version',
	'stabilize_page_invalid' => 'Der gewählte Seitentitel ist ungültig.',
	'stabilize_page_notexists' => 'Die gewählte Seite existiert nicht.',
	'stabilize_page_unreviewable' => 'Die gewählte Seite befindet sich nicht in einem Namensraum, in dem Markierungen gesetzt werden können.',
	'stabilize_invalid_autoreview' => 'Ungültige Einschränkung bezüglich automatischer Markierungen.',
	'stabilize_invalid_level' => 'Ungültige Seitenschutzstufe.',
	'stabilize_expiry_invalid' => 'Ungültiges Ablaufdatum.',
	'stabilize_expiry_old' => 'Das Ablaufdatum wurde überschritten.',
	'stabilize_denied' => 'Zugriff verweigert.',
	'stabilize-expiring' => 'bis $2, $3 Uhr (UTC)',
	'stabilization-review' => 'Markiere die aktuelle Version',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'stabilization-text' => "'''Ändern Sie die folgenden Einstellungen, um festzulegen, wie die zu veröffentlichende Version von „[[:$1|$1]]“ ausgewählt und angezeigt werden soll.'''",
	'stabilization-perm' => 'Sie haben nicht die erforderliche Berechtigung, um die Einstellungen bezüglich der zu veröffentlichenden Version zu ändern.
Die aktuellen Einstellungen für „[[:$1|$1]]“ sind:',
	'stabilization-leg' => 'Bestätigen Sie die Einstellungen bezüglich der zu veröffentlichenden Version',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Belekvor
 * @author Xoser
 */
$messages['diq'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'istiqrar kerdışê peli',
	'stabilization-text' => "'''Eyaran bine de bivurne ke versiyonê sebiti  [[:$1|$1]] biweciye u biese.'''",
	'stabilization-perm' => 'Hesabê tu rê destur çini yo ke stable versiyon confugration bivurne.
Tiya de eyaranê penîyî qe [[:$1|$1]] esto:',
	'stabilization-page' => 'Nameyê pelî:',
	'stabilization-leg' => 'Eyaranê stable versionî testiq bike',
	'stabilization-def' => 'Vînayişê pelî de revizyon mucnayiyo',
	'stabilization-def1' => 'Revizyonê sebitî; eka çini yo, revizyona peniye',
	'stabilization-def2' => 'Revizyonê penî',
	'stabilization-restrict' => 'Kontrolî/qedexeyê oto-kontrolî',
	'stabilization-restrict-none' => 'Restriksiyonê bînî çini yo',
	'stabilization-submit' => 'Konfirme bike',
	'stabilization-notexists' => 'Yew pel ser "[[:$1|$1]]" çini yo. 
Konfugure ni beno.',
	'stabilization-notcontent' => 'Pel"[[:$1|$1]]" kontrol nibeno. 
Konfugure ni beno.',
	'stabilization-comment' => 'Sebeb:',
	'stabilization-otherreason' => 'Sebebê bîn:',
	'stabilization-expiry' => 'Qediyeno:',
	'stabilization-othertime' => 'Wextê bîn:',
	'stabilization-def-short' => 'Eyaranê tewr vernî',
	'stabilization-def-short-0' => 'Penî',
	'stabilization-def-short-1' => 'Sebit',
	'stabilize_page_invalid' => 'Nameyê pele ya hedefi meqbul niyo.',
	'stabilize_page_notexists' => 'Pele ke hedef biya eka cini ya.',
	'stabilize_page_unreviewable' => 'Pele ke hedef biya cayenameyi de cini ya.',
	'stabilize_invalid_autoreview' => 'Otokontrol raşt niya.',
	'stabilize_invalid_level' => 'Seviyeyê pawitiş raşt niya.',
	'stabilize_expiry_invalid' => 'Wextê qedîyayîş raşt niyo.',
	'stabilize_expiry_old' => 'Wextê qedîyayîş penî de mend.',
	'stabilize_denied' => 'Destur nedano.',
	'stabilize-expiring' => '$1 (UTC) de qediyeno',
	'stabilization-review' => 'Versiyonê penî ke kontrol biyo ay nisan bike',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'stabilization-tab' => 'pśekontrolowaś',
	'stabilization' => 'Stabilizacija boka',
	'stabilization-text' => "'''Změń slědujuce nastajenja, aby póstajił, kak se wózjawjona wersija wót [[:$1|$1]] wuběra a zwobraznjujo.'''",
	'stabilization-perm' => 'Twójo konto njama pšawo, aby změniło konfiguraciju wózjawjoneje wersije. How su aktualne nastajenja za [[:$1|$1]]:',
	'stabilization-page' => 'Mě boka:',
	'stabilization-leg' => 'Nastajenja wózjawjoneje wersije wobkšuśiś',
	'stabilization-def' => 'Zwobraznjona wersija w standardnem bocnem naglěźe',
	'stabilization-def1' => 'Stabilna wersija; jolic žedna njejo, ga nejnowša wersija',
	'stabilization-def2' => 'Nejnowša wersija',
	'stabilization-restrict' => 'Wobgranicowanja pśeglědanjow/awtomatiskich pséglědanjow',
	'stabilization-restrict-none' => 'Žedne pśidatne wobgranicowanja',
	'stabilization-submit' => 'Wobkšuśiś',
	'stabilization-notexists' => 'Njejo bok z mjenim "[[:$1|$1]]".
Žedna konfiguracija móžno.',
	'stabilization-notcontent' => 'Bok "[[:$1|$1]]" njedajo se pśeglědaś.
Žedna konfiguracija móžno.',
	'stabilization-comment' => 'Pśicyna:',
	'stabilization-otherreason' => 'Druga pśicyna:',
	'stabilization-expiry' => 'Pśepadnjo:',
	'stabilization-othertime' => 'Drugi cas:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktualny',
	'stabilization-def-short-1' => 'Wózjawjony',
	'stabilize_page_invalid' => 'Titel celowego boka jo njepłaśiwy.',
	'stabilize_page_notexists' => 'Celowy bok njeeksistěrujo.',
	'stabilize_page_unreviewable' => 'Celowy bok njejo w pśeglědujobnem mjenjowem rumje.',
	'stabilize_invalid_autoreview' => 'Njepłaśiwe wobgranicowanje awtomatiskich pśeglědanjow.',
	'stabilize_invalid_level' => 'Njepłaśiwy šćitowy schojźeńk.',
	'stabilize_expiry_invalid' => 'Njpłaśiwy datum pśepadnjenja.',
	'stabilize_expiry_old' => 'Toś ten cas pśepadnjenja jo se južo minuł.',
	'stabilize_denied' => 'Pšawo wótpokazane.',
	'stabilize-expiring' => 'pśepadnjo $1 (UTC)',
	'stabilization-review' => 'Aktualnu wersiju ako pśekontrolěrowanu markěrowaś',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Crazymadlover
 * @author Dead3y3
 * @author Glavkos
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'stabilization-tab' => 'εξωνυχιστικός έλεγχος',
	'stabilization' => 'Σταθεροποίηση σελίδας',
	'stabilization-text' => "'''Αλλάξτε τις ρυθμίσεις παρακάτω για να ρυθμίσετε το πως η σταθερή έκδοση της σελίδας [[:$1|$1]] επιλέγεται και εμφανίζεται.'''",
	'stabilization-perm' => 'Ο λογαριασμός σας δεν έχει δικαίωμα να αλλάξει την ρύθμιση σταθερής έκδοσης.
Εδώ είναι οι τρέχουσες ρυθμίσεις για τη σελίδα [[:$1|$1]]:',
	'stabilization-page' => 'Όνομα σελίδας:',
	'stabilization-leg' => 'Επιβεβαιώστε τις ρυθμίσεις της  σταθερής έκδοσης',
	'stabilization-def' => 'Αναθεώρηση εμφανιζόμενη στην προεπιλεγμένη εμφάνιση σελίδας',
	'stabilization-def1' => 'Η σταθερή αναθεώρηση· αν δεν είναι παρούσα, τότε η τρέχουσα/πρόχειρη',
	'stabilization-def2' => 'Η πιο πρόσφατη αναθεώρηση',
	'stabilization-restrict' => 'Περιορισμοί Επισκόπησης/αυτό-επισκόπησης',
	'stabilization-restrict-none' => 'Κανένας επιπλέον περιορισμός',
	'stabilization-submit' => 'Επιβεβαίωση',
	'stabilization-notexists' => 'Δεν υπάρχει σελίδα αποκαλούμενη "[[:$1|$1]]".<br />
Δεν είναι δυνατή καμία ρύθμιση.',
	'stabilization-notcontent' => 'Η σελίδα "[[:$1|$1]]" δεν μπορεί να κριθεί.<br />
Δεν είναι δυνατή καμία ρύθμιση.',
	'stabilization-comment' => 'Λόγος:',
	'stabilization-otherreason' => 'Άλλος λόγος:',
	'stabilization-expiry' => 'Λήγει:',
	'stabilization-othertime' => 'Άλλη ώρα:',
	'stabilization-def-short' => 'Προεπιλογή',
	'stabilization-def-short-0' => 'Τρέχουσα',
	'stabilization-def-short-1' => 'Σταθερή',
	'stabilize_page_invalid' => 'Ο τίτλος της σελίδας προορισμού δεν είναι έγκυρος.',
	'stabilize_page_notexists' => 'Η σελίδα προορισμού δεν υπάρχει.',
	'stabilize_invalid_autoreview' => 'Μη έγκυρος περιορισμός αυτοεπισκόπησης',
	'stabilize_invalid_level' => 'Άκυρο επίπεδο προστασίας.',
	'stabilize_expiry_invalid' => 'Άκυρη ημερομηνία λήξης.',
	'stabilize_expiry_old' => 'Η ημερομηνία λήξης έχει ήδη περάσει.',
	'stabilize_denied' => 'Δεν έχετε δικαίωμα πρόσβασης.',
	'stabilize-expiring' => 'λήγει στις $1 (UTC)',
	'stabilization-review' => 'Επιθεωρήστε τη τρέχουσα έκδοση',
);

/** British English (British English)
 * @author Reedy
 */
$messages['en-gb'] = array(
	'stabilization' => 'Page stabilisation',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'stabilization-tab' => 'kontroli',
	'stabilization' => 'Paĝa stabiligado',
	'stabilization-text' => "'''Ŝanĝu la jenajn agordojn por modifi kiel la publikigita versio de [[:$1|$1]] estas elektita kaj montrita.'''",
	'stabilization-perm' => 'Via konto ne rajtas ŝanĝi la konfiguron de publikigita versio.
Jen la nunaj agordoj por [[:$1|$1]]:',
	'stabilization-page' => 'Paĝnomo:',
	'stabilization-leg' => 'Konfirmi agordojn de publikigitaj versioj',
	'stabilization-def' => 'Versio montrita en defaŭlta paĝa vido',
	'stabilization-def1' => 'La stabila versio; se ĝi ne ekzistas, la lasta revizio',
	'stabilization-def2' => 'La lasta revizio',
	'stabilization-restrict' => 'Limigoj pri kontrolado aŭ aŭtomata kontrolado',
	'stabilization-restrict-none' => 'Neniuj pliaj limigoj',
	'stabilization-submit' => 'Konfirmi',
	'stabilization-notexists' => 'Neniu paĝo estas nomata "[[:$1|$1]]".
Neniu konfiguro estas farebla.',
	'stabilization-notcontent' => 'La paĝo "[[:$1|$1]]" ne estas kontrolebla.
Neniu konfiguro eblas.',
	'stabilization-comment' => 'Kialo:',
	'stabilization-otherreason' => 'Alia kialo:',
	'stabilization-expiry' => 'Fintempo:',
	'stabilization-othertime' => 'Alia tempo:',
	'stabilization-def-short' => 'Defaŭlta',
	'stabilization-def-short-0' => 'Nuna',
	'stabilization-def-short-1' => 'Publikigita',
	'stabilize_page_invalid' => 'La titolo de la cela paĝo estas malvalida.',
	'stabilize_page_notexists' => 'La cela paĝo ne ekzistas.',
	'stabilize_page_unreviewable' => 'La cela paĝo ne estas en kontrolebla nomspaco.',
	'stabilize_invalid_autoreview' => 'Malvalida limigo de aŭtomata kontrolado',
	'stabilize_invalid_level' => 'Malvalida nivelo de protektado.',
	'stabilize_expiry_invalid' => 'Malvalida findato.',
	'stabilize_expiry_old' => 'Ĉi tiu findato jam estas pasita.',
	'stabilize_denied' => 'Malpermesita.',
	'stabilize-expiring' => 'findato $1 (UTC)',
	'stabilization-review' => 'Marki la nunan revizion kiel kontrolitan',
);

/** Spanish (Español)
 * @author Bola
 * @author Crazymadlover
 * @author Dferg
 * @author Drini
 * @author Imre
 * @author Kobazulo
 * @author Manuelt15
 * @author Peter17
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'stabilization-tab' => 'vetar',
	'stabilization' => 'Estabilización de página',
	'stabilization-text' => "'''Cambiar las configuraciones de abajo para ajustar cómo la versión estable de [[:$1|$1]] es seleccionada y mostrada.'''",
	'stabilization-perm' => 'Su cuenta no tiene permiso para cambiar la configuración de la versión publicada.
La configuración actual es [[:$1|$1]]:',
	'stabilization-page' => 'Nombre de la página:',
	'stabilization-leg' => 'Confirmar la configuración de la versión publicada',
	'stabilization-def' => 'Revisión mostrada en la vista de página por defecto',
	'stabilization-def1' => 'La versión estable; si no está presente, entonces la última revisión',
	'stabilization-def2' => 'La última revisión',
	'stabilization-restrict' => 'Restricciones de revisión/autorevisión',
	'stabilization-restrict-none' => 'Sin restricciones extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'No hay una página llamada "[[:$1|$1]]".
La configuración no es posible.',
	'stabilization-notcontent' => 'La página "[[:$1|$1]]" no puede ser revisada.
La configuración no es posible.',
	'stabilization-comment' => 'Razón:',
	'stabilization-otherreason' => 'Otra razón:',
	'stabilization-expiry' => 'Expira:',
	'stabilization-othertime' => 'Otra vez:',
	'stabilization-def-short' => 'Por defecto',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Publicado',
	'stabilize_page_invalid' => 'El título de la página de destino es inválido.',
	'stabilize_page_notexists' => 'La página de destino es no existe.',
	'stabilize_page_unreviewable' => 'La página de destino no está en un espacio de nombre en el que sea posible una revisión.',
	'stabilize_invalid_autoreview' => 'Restricciión e autorevisión inválida.',
	'stabilize_invalid_level' => 'Nivel de protección inválido.',
	'stabilize_expiry_invalid' => 'La fecha de caducidad no es válida.',
	'stabilize_expiry_old' => 'Este tiempo de expiración ya ha pasado',
	'stabilize_denied' => 'Permiso denegado.',
	'stabilize-expiring' => 'caduca el $1 (UTC)',
	'stabilization-review' => 'Marcar la versión actual verificada',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author KalmerE.
 * @author Pikne
 */
$messages['et'] = array(
	'stabilization-tab' => 'sätted',
	'stabilization' => 'Lehekülje kindlustamine',
	'stabilization-text' => "'''Muuda järgnevaid sätteid reguleerimaks, kuidas lehekülje \"[[:\$1|\$1]]\" püsiv versioon valitakse ja kuvatakse.'''",
	'stabilization-perm' => 'Su kontol pole püsiva versiooni sätete muutmise luba.
Siin on lehekülje "[[:$1|$1]]" praegused sätted:',
	'stabilization-page' => 'Lehekülje nimi:',
	'stabilization-leg' => 'Püsiva versiooni sätete kinnitamine',
	'stabilization-def' => 'Vaikimisi kuvatav lehekülje redaktsioon',
	'stabilization-def1' => 'Püsiv versioon; selle puudumisel uusim redaktsioon',
	'stabilization-def2' => 'Uusim redaktsioon',
	'stabilization-restrict' => 'Ülevaatuse või automaatse ülevaatuse piirangud',
	'stabilization-restrict-none' => 'Lisapiiranguteta',
	'stabilization-submit' => 'Kinnita',
	'stabilization-notexists' => 'Puudub lehekülg "[[:$1|$1]]".
Sätete seadmine pole võimalik.',
	'stabilization-notcontent' => 'Lehekülge "[[:$1|$1]]" ei saa üle vaadata.
Sätete seadmine pole võimalik.',
	'stabilization-comment' => 'Põhjus:',
	'stabilization-otherreason' => 'Muu põhjus:',
	'stabilization-expiry' => 'Aegub:',
	'stabilization-othertime' => 'Muu aeg:',
	'stabilization-def-short' => 'Vaikeväärtus',
	'stabilization-def-short-0' => 'Praegune',
	'stabilization-def-short-1' => 'Püsiv',
	'stabilize_page_invalid' => 'Sihtlehekülje pealkiri on vigane.',
	'stabilize_page_notexists' => 'Sihtlehekülge pole olemas.',
	'stabilize_page_unreviewable' => 'Sihtlehekülg on nimeruumis, kus ülevaatamine pole võimalik.',
	'stabilize_invalid_autoreview' => 'Vigane automaatse ülevaatuse piirang.',
	'stabilize_invalid_level' => 'Vigane kaitsetase.',
	'stabilize_expiry_invalid' => 'Vigane aegumistähtaeg.',
	'stabilize_expiry_old' => 'See aegumistähtaeg on juba möödunud.',
	'stabilize_denied' => 'Luba tagasi lükatud.',
	'stabilize-expiring' => 'aegumistähtajaga $1 (UTC)',
	'stabilization-review' => 'Märgi praegune redaktsioon kord vaadatuks',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'stabilization' => 'Orrialdearen egonkortzea',
	'stabilization-page' => 'Orrialdearen izenburua:',
	'stabilization-leg' => 'Argitaratutako bertsioaren konfigurazioa berretsi',
	'stabilization-submit' => 'Baieztatu',
	'stabilization-comment' => 'Arrazoia:',
	'stabilization-otherreason' => 'Beste arrazoirik:',
	'stabilization-expiry' => 'Epemuga:',
	'stabilization-othertime' => 'Beste denbora:',
	'stabilization-def-short' => 'Lehenetsia',
	'stabilization-def-short-0' => 'Oraingoa',
	'stabilization-def-short-1' => 'Argitaratua',
	'stabilize_expiry_invalid' => 'Iraungipen-data okerra.',
	'stabilize-expiring' => 'iraungipen-data: $1 (UTC)',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'stabilization-page' => 'Nombri la páhina:',
	'stabilization-submit' => 'Confirmal',
	'stabilization-def-short' => 'Defeutu',
	'stabilization-def-short-0' => 'Atual',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Momeni
 * @author Sahim
 * @author Wayiran
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'stabilization-tab' => '(کک)',
	'stabilization' => 'پایدارسازی صفحه‌ها',
	'stabilization-text' => 'برای تعیین چگونگی انتخاب و نمایش نسخهٔ پایدار [[:$1|$1]]، تنظیمات زیر را تغییر دهید.',
	'stabilization-perm' => 'حساب شما اجازهٔ تغییر پیکربندی نسخهٔ پایدار را ندارد.
تنظیمات کنونی برای [[:$1|$1]] چنین هستند:',
	'stabilization-page' => 'نام صفحه:',
	'stabilization-leg' => 'تأیید تنظیمات نسخهٔ پایدار',
	'stabilization-def' => 'نسخه‌ای که در حالت پیش‌فرض نمایش داده می‌شود',
	'stabilization-def1' => 'نسخه پایدار؛ اگر وجود ندارد، آخرین نسخه',
	'stabilization-def2' => 'آخرین نسخه',
	'stabilization-restrict' => 'بازبینی/بازبینی خودکار محدودیت‌ها',
	'stabilization-restrict-none' => 'بدون هرگونه محدودیت اضافی',
	'stabilization-submit' => 'تأیید',
	'stabilization-notexists' => 'صفحه‌ای با عنوان «[[:$1|$1]]» وجود ندارد. تنظیمات ممکن نیست.',
	'stabilization-notcontent' => 'صفحه «[[:$1|$1]]» قابل بررسی نیست. تنظیمات ممکن نیست.',
	'stabilization-comment' => 'دلیل:',
	'stabilization-otherreason' => 'دلیل دیگر:',
	'stabilization-expiry' => 'زمان سرآمدن:',
	'stabilization-othertime' => 'زمان دیگر:',
	'stabilization-def-short' => 'پیش‌فرض',
	'stabilization-def-short-0' => 'کنونی',
	'stabilization-def-short-1' => 'پایدار',
	'stabilize_page_invalid' => 'عنوان صفحهٔ مقصد نامعتبر است.',
	'stabilize_page_notexists' => 'صفحهٔ مقصد وجود ندارد.',
	'stabilize_page_unreviewable' => 'صفحهٔ مقصد در فضای نام قابل بازبینی نیست.',
	'stabilize_invalid_autoreview' => 'بی‌اعتباری بازبینی‌های خودکار محدود',
	'stabilize_invalid_level' => 'سطح محافظت نامعتبر',
	'stabilize_expiry_invalid' => 'تاریخ انقضای غیرمجاز',
	'stabilize_expiry_old' => 'این تاریخ انقضا همینک سپری شده‌است.',
	'stabilize_denied' => 'اجازه داده نشد.',
	'stabilize-expiring' => 'در $1 (UTC) منقضی می‌شود.',
	'stabilization-review' => 'علامت زدن این نسخه به عنوان بازبینی شده',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Mies
 * @author Nike
 * @author Olli
 * @author Pxos
 * @author Silvonen
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'stabilization-tab' => 'vakautus',
	'stabilization' => 'Sivun vakauttaminen',
	'stabilization-text' => "'''Muuta alla olevia asetuksia, jotka määrittävät, kuinka sivun [[:$1|$1]] vakaa versio valitaan ja näytetään.'''",
	'stabilization-perm' => 'Tunnuksellasi ei ole oikeutta muuttaa vakaiden versioiden asetuksia.
Tässä ovat nykyiset asetukset kohteelle [[:$1|$1]]:',
	'stabilization-page' => 'Sivun nimi:',
	'stabilization-leg' => 'Vahvista vakaiden versioiden asetukset',
	'stabilization-def' => 'Versio, joka näytetään oletusarvoisesti',
	'stabilization-def1' => 'Vakaa versio. Jos vakaata versiota ei ole, viimeisin versio.',
	'stabilization-def2' => 'Viimeisin versio',
	'stabilization-restrict' => 'Seulonnan ja automaattiseulonnan rajoitukset',
	'stabilization-restrict-none' => 'Ei erityisiä rajoituksia',
	'stabilization-submit' => 'Vahvista',
	'stabilization-notexists' => 'Sivua [[:$1|$1]] ei ole olemassa.
Asetusten määrittäminen ei ole mahdollista.',
	'stabilization-notcontent' => 'Sivua [[:$1|$1]] ei voi merkitä arvioiduksi.
Asetusten määrittäminen ei ole mahdollista.',
	'stabilization-comment' => 'Syy',
	'stabilization-otherreason' => 'Muu syy',
	'stabilization-expiry' => 'Vanhenee',
	'stabilization-othertime' => 'Muu aika',
	'stabilization-def-short' => 'Oletus',
	'stabilization-def-short-0' => 'Viimeisin',
	'stabilization-def-short-1' => 'Vakaa',
	'stabilize_page_invalid' => 'Kohdesivun nimi ei kelpaa.',
	'stabilize_page_notexists' => 'Kohdesivua ei ole olemassa.',
	'stabilize_page_unreviewable' => 'Kohdesivu ei ole nimiavaruudessa, jonka sivuja voitaisiin arvioida.',
	'stabilize_invalid_autoreview' => 'Automaattisen seulonnan rajoitus ei kelpaa.',
	'stabilize_invalid_level' => 'Suojaustaso on virheellinen.',
	'stabilize_expiry_invalid' => 'Virheellinen päättymispäivä.',
	'stabilize_expiry_old' => 'Tämä erääntymisaika on jo mennyt.',
	'stabilize_denied' => 'Ei oikeutta.',
	'stabilize-expiring' => 'vanhenee $1 (UTC)',
	'stabilization-review' => 'Merkitse viimeisin versio katsotuksi',
);

/** French (Français)
 * @author ChrisPtDe
 * @author Dereckson
 * @author Dodoïste
 * @author Grondin
 * @author IAlex
 * @author Juanpabl
 * @author Peter17
 * @author PieRRoMaN
 * @author Purodha
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'stabilization-tab' => '(aq)',
	'stabilization' => 'Stabilisation de la page',
	'stabilization-text' => "'''Modifiez les paramètres ci-dessous pour définir la façon dont la version publiée de [[:$1|$1]] est sélectionnée et affichée.'''",
	'stabilization-perm' => "Votre compte n'a pas les droits pour changer les paramètres de la version publiée.
Voici les paramètres actuels de [[:$1|$1]] :",
	'stabilization-page' => 'Nom de la page :',
	'stabilization-leg' => 'Confirmer le paramétrage de la version publiée',
	'stabilization-def' => "Version affichée lors de l'affichage par défaut de la page",
	'stabilization-def1' => "La version stable ; s'il n'y en a pas, alors la révision courante",
	'stabilization-def2' => 'La révision courante',
	'stabilization-restrict' => 'Restrictions de relecture (automatique)',
	'stabilization-restrict-none' => 'Pas de restriction supplémentaire',
	'stabilization-submit' => 'Confirmer',
	'stabilization-notexists' => "Il n'y a pas de page « [[:$1|$1]] », pas de paramétrage possible",
	'stabilization-notcontent' => 'La page « [[:$1|$1]] » ne peut être révisée, pas de paramétrage possible',
	'stabilization-comment' => 'Motif :',
	'stabilization-otherreason' => 'Autre raison :',
	'stabilization-expiry' => 'Expire :',
	'stabilization-othertime' => 'Autre temps :',
	'stabilization-def-short' => 'Par défaut',
	'stabilization-def-short-0' => 'Courante',
	'stabilization-def-short-1' => 'Publié',
	'stabilize_page_invalid' => 'Le titre de la page cible est incorrect',
	'stabilize_page_notexists' => "La page cible n'existe pas.",
	'stabilize_page_unreviewable' => "La page cible n'est pas dans un espace de noms qui peut être relu.",
	'stabilize_invalid_autoreview' => 'Restriction de relecture automatique invalide',
	'stabilize_invalid_level' => 'Niveau de protection invalide.',
	'stabilize_expiry_invalid' => "Date d'expiration invalide.",
	'stabilize_expiry_old' => "Cette durée d'expiration est déjà écoulée.",
	'stabilize_denied' => 'Permission refusée.',
	'stabilize-expiring' => 'Expire le $1 (UTC)',
	'stabilization-review' => 'Marquer la version actuelle comme vérifiée',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'stabilization-tab' => 'Controlar',
	'stabilization' => 'Stabilisacion de la pâge.',
	'stabilization-text' => "'''Changiéd los paramètres ce-desot por dèfenir la façon que la vèrsion stâbla de [[:$1|$1]] est chouèsia et pués montrâ.'''",
	'stabilization-perm' => 'Voutron compto at pas los drêts por changiér los paramètres de la vèrsion stâbla.
Vê-que los paramètres d’ora de [[:$1|$1]] :',
	'stabilization-page' => 'Nom de la pâge :',
	'stabilization-leg' => 'Confirmar los paramètres de la vèrsion stâbla',
	'stabilization-def' => 'Vèrsion montrâ pendent la visualisacion de la pâge per dèfôt',
	'stabilization-def1' => 'La vèrsion stâbla ; s’y en at pas, adonc cela d’ora',
	'stabilization-def2' => 'La vèrsion d’ora',
	'stabilization-restrict' => 'Rèstriccions de rèvision (ôtomatica)',
	'stabilization-restrict-none' => 'Gins de rèstriccion de ples',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Y at gins de pâge « [[:$1|$1]] »,
gins de configuracion possibla.',
	'stabilization-notcontent' => 'La pâge « [[:$1|$1]] » pôt pas étre revua,
gins de configuracion possibla.',
	'stabilization-comment' => 'Rêson :',
	'stabilization-otherreason' => 'Ôtra rêson :',
	'stabilization-expiry' => 'Èxpire :',
	'stabilization-othertime' => 'Ôtro temps :',
	'stabilization-def-short' => 'Per dèfôt',
	'stabilization-def-short-0' => 'D’ora',
	'stabilization-def-short-1' => 'Stâbla',
	'stabilize_page_invalid' => 'Lo titro de la pâge ciba est fôx.',
	'stabilize_page_notexists' => 'La pâge ciba ègziste pas.',
	'stabilize_page_unreviewable' => 'La pâge ciba est pas dens un èspâço de noms que pôt étre revu.',
	'stabilize_invalid_autoreview' => 'Rèstriccion de rèvision ôtomatica envalida.',
	'stabilize_invalid_level' => 'Nivél de protèccion envalido.',
	'stabilize_expiry_invalid' => 'Dâta d’èxpiracion envalida.',
	'stabilize_expiry_old' => 'Cél temps d’èxpiracion est ja passâ.',
	'stabilize_denied' => 'Pèrmission refusâ.',
	'stabilize-expiring' => 'èxpire lo $1 (UTC)',
	'stabilization-review' => 'Marcar la vèrsion d’ora coment controlâ',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'stabilization-page' => 'Sidenamme:',
	'stabilization-comment' => 'Reden:',
	'stabilization-def-short' => 'Standert',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'stabilization-comment' => 'Fáth:',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'Estabilización da páxina',
	'stabilization-text' => "'''Mude a configuración a continuación para axustar a forma na que a versión publicada de \"[[:\$1|\$1]]\" se selecciona e mostra.'''",
	'stabilization-perm' => 'A súa conta non ten os permisos necesarios para mudar a configuración da versión publicada.
Velaquí está a configuración actual de "[[:$1|$1]]":',
	'stabilization-page' => 'Nome da páxina:',
	'stabilization-leg' => 'Confirmar as configuración da versión publicada',
	'stabilization-def' => 'Revisión que aparece por defecto na vista da páxina',
	'stabilization-def1' => 'A versión estable; se non existe, entón a última revisión',
	'stabilization-def2' => 'A última revisión',
	'stabilization-restrict' => 'Restricións de revisión/revisión automática',
	'stabilization-restrict-none' => 'Sen restricións extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Non hai páxina ningunha chamada "[[:$1|$1]]".
Non é posible a configuración.',
	'stabilization-notcontent' => 'Non se pode revisar a páxina "[[:$1|$1]]" .
Non é posible a configuración.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Outro motivo:',
	'stabilization-expiry' => 'Caducidade:',
	'stabilization-othertime' => 'Outro tempo:',
	'stabilization-def-short' => 'Por defecto',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Publicada',
	'stabilize_page_invalid' => 'O título da páxina de destino non é correcto.',
	'stabilize_page_notexists' => 'A páxina de destino non existe.',
	'stabilize_page_unreviewable' => 'A páxina de destino non está nun espazo de nomes que se poida revisar.',
	'stabilize_invalid_autoreview' => 'Restrición de revisión automática incorrecta',
	'stabilize_invalid_level' => 'Nivel de protección incorrecto.',
	'stabilize_expiry_invalid' => 'Data de caducidade non válida.',
	'stabilize_expiry_old' => 'O tempo de caducidade xa pasou.',
	'stabilize_denied' => 'Permisos rexeitados.',
	'stabilize-expiring' => 'caduca o $2 ás $3 (UTC)',
	'stabilization-review' => 'Marcar a revisión actual como comprobada',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'stabilization-tab' => 'ἐλεγχ',
	'stabilization' => 'Σταθεροποίησις δέλτου',
	'stabilization-page' => 'Ὄνομα δέλτου:',
	'stabilization-submit' => 'Κυροῦν',
	'stabilization-comment' => 'Αἰτία:',
	'stabilization-otherreason' => 'Ἑτέρα αἰτία:',
	'stabilization-expiry' => 'Λήγει:',
	'stabilization-def-short' => 'Προκαθωρισμένη',
	'stabilization-def-short-0' => 'Τρέχουσα',
	'stabilization-def-short-1' => 'Σταθερά',
	'stabilize-expiring' => 'λήγει $1 (UTC)',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'stabilization-tab' => 'Konfig.',
	'stabilization' => 'Sytekonfiguration',
	'stabilization-text' => "'''Tue d Yystellige ändere fir zum feschtzlege, wie di vereffetligt Version vu „[[:$1|$1]]“ usgwehlt un aazeigt soll wäre.'''",
	'stabilization-perm' => 'Du hesch nid d Berächtigung, zum die Yystellige vu dr vereffetligte Version z ändere.
Di aktuällen Yystellige fir „[[:$1|$1]]“ sin:',
	'stabilization-page' => 'Sytename:',
	'stabilization-leg' => 'Yystellige vu dr vereffetligte Version fir e Syte',
	'stabilization-def' => 'Version, wu in dr normale Syteaasicht aazeigt wird',
	'stabilization-def1' => 'Di vereffetligt Version; wänn s keini het, derno di aktuäll Version',
	'stabilization-def2' => 'Di aktuäll Version',
	'stabilization-restrict' => 'Priefig/Automatischi Priefig-Yyschränkige',
	'stabilization-restrict-none' => 'Keini extra Yyschränkige',
	'stabilization-submit' => 'Bstätige',
	'stabilization-notexists' => 'Es git kei Syte „[[:$1|$1]]“. Kei Yystellige megli.',
	'stabilization-notcontent' => 'D Syte „[[:$1|$1]]“ cha nit vum Fäldhieter gsäh wäre. E Konfiguration isch nid megli.',
	'stabilization-comment' => 'Grund:',
	'stabilization-otherreason' => 'Andere Grund:',
	'stabilization-expiry' => 'Giltig bis:',
	'stabilization-othertime' => 'Anderi Zyt:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktuäll',
	'stabilization-def-short-1' => 'Vereffetligt',
	'stabilize_page_invalid' => 'Dää Sytename isch nit giltig.',
	'stabilize_page_notexists' => 'Die gwehlt Syte git s nit.',
	'stabilize_page_unreviewable' => 'Die gwehlt Syte git snit in eme Namensruum, wu Markierige chenne gsetzt wäre.',
	'stabilize_invalid_autoreview' => 'Nit giltigi Yyschränkig vu dr automatische Markierig.',
	'stabilize_invalid_level' => 'Nit giltigi Syteschitzstapfle.',
	'stabilize_expiry_invalid' => 'Nid giltigs Ablaufdatum.',
	'stabilize_expiry_old' => 'S Ablaufdatum isch iberschritte wore.',
	'stabilize_denied' => 'Zuegriff verweigeret.',
	'stabilize-expiring' => 'erlischt $1 (UTC)',
	'stabilization-review' => 'Di aktuäll Version as aagluegt markiere',
);

/** Manx (Gaelg)
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'stabilization-comment' => 'Fa:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'stabilization-comment' => 'Dalili:',
	'stabilization-otherreason' => 'Wani dalili:',
	'stabilization-expiry' => "Wa'adi:",
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'stabilization-def-short' => 'Paʻamau',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author DoviJ
 * @author Ori229
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'stabilization-tab' => 'ביקורת',
	'stabilization' => 'הגדרות היציבות של הדף',
	'stabilization-text' => "'''ניתן לשנות את ההגדרות שלהלן כדי לכוונן כיצד הגרסה היציבה של [[:$1|$1]] נבחרת ומוצגת.'''",
	'stabilization-perm' => 'אין לחשבונך הרשאה לשנות את הגדרות היציבות.
להלן ההגדרות הנוכחיות עבור [[:$1|$1]]:',
	'stabilization-page' => 'שם הדף:',
	'stabilization-leg' => 'אנא אשרו את הגדרות היציבות',
	'stabilization-def' => 'הגרסה המופיעה לפי בררת מחדל',
	'stabilization-def1' => 'הגרסה היציבה; אם היא לא קיימת, אז הגרסה האחרונה',
	'stabilization-def2' => 'הגרסה האחרונה',
	'stabilization-restrict' => 'הגבלות על סקירה וסקירה אוטומטית',
	'stabilization-restrict-none' => 'אין הגבלות נוספות',
	'stabilization-submit' => 'אישור',
	'stabilization-notexists' => 'אין דף בשם "[[:$1|$1]]".
לא ניתן לבצע תצורה.',
	'stabilization-notcontent' => 'אין אפשרות לסקור את הדף "[[:$1|$1]]".
לא ניתן לבצע הגדרות.',
	'stabilization-comment' => 'סיבה:',
	'stabilization-otherreason' => 'סיבה אחרת:',
	'stabilization-expiry' => 'פקיעה:',
	'stabilization-othertime' => 'זמן פקיעה אחר:',
	'stabilization-def-short' => 'בררת מחדל',
	'stabilization-def-short-0' => 'נוכחי',
	'stabilization-def-short-1' => 'יציב',
	'stabilize_page_invalid' => 'כותרת דף היעד אינה תקינה.',
	'stabilize_page_notexists' => 'דף היעד אינו קיים.',
	'stabilize_page_unreviewable' => 'דף היעד אינו במרחב שסקירת דפים מופעלת בו.',
	'stabilize_invalid_autoreview' => 'הגבלה בלתי תקינה של סקירה אוטומטית.',
	'stabilize_invalid_level' => 'רמת הגנה בלתי תקינה.',
	'stabilize_expiry_invalid' => 'תאריך הפקיעה אינו תקין.',
	'stabilize_expiry_old' => 'תאריך הפקיעה כבר עבר.',
	'stabilize_denied' => 'ההרשאה נדחתה.',
	'stabilize-expiring' => 'פקיעה: $1 (UTC)',
	'stabilization-review' => 'סימון הגרסה הנוכחית כבדוקה',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 */
$messages['hi'] = array(
	'stabilization-tab' => 'व्हेट',
	'stabilization' => 'लेख स्थ्रिर करें',
	'stabilization-text' => "'''[[:$1|$1]] का स्थिर अवतरण किस प्रकार चुना या दर्शाया जाये इस के लिये निम्नलिखित सेटिंग बदलें।'''",
	'stabilization-perm' => 'आपको स्थिर अवतरण बदलनेकी अनुमति नहीं हैं।
[[:$1|$1]]का अभीका सेटींग इस प्रकार हैं:',
	'stabilization-page' => 'पृष्ठ नाम:',
	'stabilization-leg' => 'स्थिर अवतरण सेटिंग निश्चित करें',
	'stabilization-def' => 'डिफॉल्ट पन्ने के साथ बदलाव दर्शायें गयें हैं',
	'stabilization-def1' => 'स्थिर अवतरण;
अगर नहीं हैं, तो सद्य',
	'stabilization-def2' => 'सद्य अवतरण',
	'stabilization-restrict' => 'समिक्षा/स्व-समिक्षा प्रतिबंध',
	'stabilization-restrict-none' => 'कोई अतिरिक्त प्रतिबंध नहीं',
	'stabilization-submit' => 'निश्चित करें',
	'stabilization-notexists' => '"[[:$1|$1]]" इस नामका पृष्ठ अस्तित्वमें नहीं हैं।
बदलाव नहीं किये जा सकतें।',
	'stabilization-notcontent' => '"[[:$1|$1]]" यह पृष्ठ जाँचा नहीं जा सकता।
बदलाव नहीं किये जा सकतें।',
	'stabilization-comment' => 'कारण:',
	'stabilization-otherreason' => 'अन्य कारण:',
	'stabilization-expiry' => 'समाप्ति:',
	'stabilization-othertime' => 'अन्य समय:',
	'stabilization-def-short' => 'डिफॉल्ट',
	'stabilization-def-short-0' => 'सद्य',
	'stabilization-def-short-1' => 'स्थिर',
	'stabilize_page_invalid' => 'लक्ष्य पृष्ठ की शीर्षक अमान्य है ।',
	'stabilize_page_notexists' => 'लक्ष्य पृष्ठ मौजूद नहीं है ।',
	'stabilize_page_unreviewable' => 'लख्य पृष्ठ समिक्षायोग्य नेमस्पेस में नहीं है ।',
	'stabilize_invalid_autoreview' => 'अमान्य स्वसमिक्षा प्रतिबंध ।',
	'stabilize_invalid_level' => 'अमान्य सुरक्षा सस्तर ।',
	'stabilize_expiry_invalid' => 'गलत समाप्ति तिथी।',
	'stabilize_expiry_old' => 'यह समाप्ति तिथी गुजर चुकी हैं।',
	'stabilize_denied' => 'अनुमति नहीं मिली ।',
	'stabilize-expiring' => '$1 (UTC) को समाप्ति',
	'stabilization-review' => 'बर्त्तमान की संशोधन को चिन्हित करें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author Herr Mlinka
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Stalnost stranice',
	'stabilization-text' => "'''Promijenite postavke kako biste prilagodili kako će važeća inačica članka [[:$1|$1]] biti odabrana i prikazana.'''",
	'stabilization-perm' => 'Vaš suradnički račun nema prava mijenjanja postavki važeće inačice članka.
Slijede važeće postavke za [[:$1|$1]]:',
	'stabilization-page' => 'Ime stranice:',
	'stabilization-leg' => 'Potvrdi postavke važeće inačice',
	'stabilization-def' => 'Inačica koja se prikazuje kao zadana',
	'stabilization-def1' => 'Stabilna inačica; ako je nema, onda najnovija inačica',
	'stabilization-def2' => 'Najnovija inačica',
	'stabilization-restrict' => 'Ograničenja za pregledavanje i automatsko pregledavanje',
	'stabilization-restrict-none' => 'Nema dodatnih ograničenja',
	'stabilization-submit' => 'Potvrdite',
	'stabilization-notexists' => 'Ne postoji stranica "[[:$1|$1]]". Namještanje postavki nije moguće.',
	'stabilization-notcontent' => 'Stranica "[[:$1|$1]]" ne može biti ocijenjena. Namještanje postavki nije moguće.',
	'stabilization-comment' => 'Razlog:',
	'stabilization-otherreason' => 'Drugi razlog:',
	'stabilization-expiry' => 'Istječe:',
	'stabilization-othertime' => 'Drugo vrijeme:',
	'stabilization-def-short' => 'Zadano',
	'stabilization-def-short-0' => 'Trenutačno',
	'stabilization-def-short-1' => 'Važeća inačica',
	'stabilize_page_invalid' => 'Naslov ciljne stranice nije valjan.',
	'stabilize_page_notexists' => 'Ciljna stranica ne postoji.',
	'stabilize_page_unreviewable' => 'Ciljna stranica nije u imenskom prostoru koji se može provjeravati.',
	'stabilize_invalid_autoreview' => 'Nevaljano ograničenje automatskog provjeravanja.',
	'stabilize_invalid_level' => 'Nevaljan nivo zaštite.',
	'stabilize_expiry_invalid' => 'Neispravan datum isticanja.',
	'stabilize_expiry_old' => 'Ovo vrijeme isticanja je već prošlo.',
	'stabilize_denied' => 'Pristup odbijen.',
	'stabilize-expiring' => 'ističe $1 (UTC)',
	'stabilization-review' => 'Označite trenutačnu inačicu pregledanom',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'stabilization-tab' => 'přepruwować',
	'stabilization' => 'Stabilizacija strony',
	'stabilization-text' => "'''Změń slědowace nastajenja, zo by postajił, kak so wozjewjena wersija wot [[:$1|$1]] wuběra a zwobraznja.'''",
	'stabilization-perm' => 'Twoje wužiwarske konto nima trěbne prawo, zo by nastajenja wozjewjeneje wersije změniło.
Aktualne nastajenja za „[[:$1|$1]]“ su:',
	'stabilization-page' => 'Mjeno strony:',
	'stabilization-leg' => 'Nastajenja za wozjewjenu wersiju potwjerdźić',
	'stabilization-def' => 'Wersija zwobraznjena w normalnym napohledźe strony',
	'stabilization-def1' => 'Stabilna wersija; jeli žana njeeksistuje, da najnowša wersija',
	'stabilization-def2' => 'Najnowša wersija',
	'stabilization-restrict' => 'Wobmjezowanja přepruwowanjow/awtomatiskich přepruwowanjow',
	'stabilization-restrict-none' => 'Žane přidatne wobmjezowanja',
	'stabilization-submit' => 'Potwjerdźić',
	'stabilization-notexists' => 'Njeje strona „[[:$1|$1]]“. Žana konfiguracija móžno.',
	'stabilization-notcontent' => 'Strona "[[:$1|$1]]" njeda so pruwować. Žana konfiguracija móžno.',
	'stabilization-comment' => 'Přičina:',
	'stabilization-otherreason' => 'Druha přičina:',
	'stabilization-expiry' => 'Spadnje:',
	'stabilization-othertime' => 'Druhi čas:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktualny',
	'stabilization-def-short-1' => 'Stabilna wersija',
	'stabilize_page_invalid' => 'Titul ciloweje strony je njepłaćiwy.',
	'stabilize_page_notexists' => 'Cilowa strona njeeksistuje.',
	'stabilize_page_unreviewable' => 'Cilowa strona w přepruwujomnym mjenowym rumje njeje.',
	'stabilize_invalid_autoreview' => 'Njepłaćiwe wobmjezowanje awtomatiskeho přepruwowanja',
	'stabilize_invalid_level' => 'Njepłaćiwy škitny schodźenk.',
	'stabilize_expiry_invalid' => 'Njepłaćiwy datum spadnjenja.',
	'stabilize_expiry_old' => 'Tutón čas spadnjenja je hižo zańdźeny.',
	'stabilize_denied' => 'Prawo zapowědźene.',
	'stabilize-expiring' => 'spadnje $1 hodź. (UTC)',
	'stabilization-review' => 'Aktualnu wersiju jako skontrolowanu markěrować',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Enbéká
 * @author Glanthor Reviol
 * @author Gondnok
 * @author Hunyadym
 * @author KossuthRad
 * @author Samat
 * @author Tgr
 */
$messages['hu'] = array(
	'stabilization-tab' => 'megjelenítési beállítás',
	'stabilization' => 'Lap jelölt változatainak beállítása',
	'stabilization-text' => "'''Az alábbi beállítások módosításával adhatod meg a(z) [[:$1|$1]] lap közzétett változatának kiválasztási és megjelenítési módját.'''",
	'stabilization-perm' => 'Nincs jogosultságod megváltoztatni a közzétett változat beállításait.
A(z) [[:$1|$1]] lapra vonatkozó jelenlegi beállítások:',
	'stabilization-page' => 'A lap címe:',
	'stabilization-leg' => 'Közzétett változat beállításainak megerősítése',
	'stabilization-def' => 'Az alapértelmezettként megjelenített változat',
	'stabilization-def1' => 'A közzétett változat; ha nincs, akkor a jelenlegi legutolsó',
	'stabilization-def2' => 'A legutolsó változat',
	'stabilization-restrict' => 'Ellenőrzés/automatikus ellenőrzés korlátozásai',
	'stabilization-restrict-none' => 'Nincsenek külön megkötések',
	'stabilization-submit' => 'Megerősítés',
	'stabilization-notexists' => 'Nincs „[[:$1|$1]]” című lap.
Nem lehet a beállításokat módosítani.',
	'stabilization-notcontent' => 'A(z) „[[:$1|$1]]” lapot nem lehet ellenőrizni.
Nem lehet a beállításokat módosítani.',
	'stabilization-comment' => 'Ok:',
	'stabilization-otherreason' => 'Egyéb indok:',
	'stabilization-expiry' => 'Lejárat:',
	'stabilization-othertime' => 'Más időpont:',
	'stabilization-def-short' => 'Alapértelmezett',
	'stabilization-def-short-0' => 'jelenlegi',
	'stabilization-def-short-1' => 'közzétett',
	'stabilize_page_invalid' => 'A céloldal címe érvénytelen.',
	'stabilize_page_notexists' => 'A céloldal nem létezik.',
	'stabilize_page_unreviewable' => 'A kiválasztott lap nem ellenőrizhető névtérben van.',
	'stabilize_invalid_autoreview' => 'Érvénytelen automatikus ellenőrzési megszorítás.',
	'stabilize_invalid_level' => 'Érvénytelen védelmi szint.',
	'stabilize_expiry_invalid' => 'Hibás lejárati idő.',
	'stabilize_expiry_old' => 'A megadott lejárati idő már elmúlt.',
	'stabilize_denied' => 'Engedély megtagadva.',
	'stabilize-expiring' => 'lejár $1-kor (UTC szerint)',
	'stabilization-review' => 'Aktuális változat ellenőrzöttnek jelölése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'stabilization-tab' => 'qualitate',
	'stabilization' => 'Stabilisation de paginas',
	'stabilization-text' => "'''Cambia le configurationes hic infra pro adjustar como le version publicate de [[:$1|$1]] es seligite e monstrate.'''",
	'stabilization-perm' => 'Tu conto non ha le permission de cambiar le configuration del version publicate.
Ecce le configurationes actual pro [[:$1|$1]]:',
	'stabilization-page' => 'Nomine del pagina:',
	'stabilization-leg' => 'Confirmar configuration del version publicate',
	'stabilization-def' => 'Version monstrate in le visualisation predefinite del pagina',
	'stabilization-def1' => 'Le version stabile; si non presente, le ultime version',
	'stabilization-def2' => 'Le ultime version',
	'stabilization-restrict' => 'Restrictiones de revision/auto-revision',
	'stabilization-restrict-none' => 'Nulle restriction extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Non existe un pagina con titulo "[[:$1|$1]]".
Nulle configuration es possibile.',
	'stabilization-notcontent' => 'Le pagina "[[:$1|$1]]" non pote esser revidite.
Nulle configuration es possibile.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Altere motivo:',
	'stabilization-expiry' => 'Expira:',
	'stabilization-othertime' => 'Altere duration:',
	'stabilization-def-short' => 'Predefinition',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Publicate',
	'stabilize_page_invalid' => 'Le titulo del pagina de destination es invalide.',
	'stabilize_page_notexists' => 'Le pagina de destination non existe.',
	'stabilize_page_unreviewable' => 'Le pagina de destination non es in un spatio de nomines revisibile.',
	'stabilize_invalid_autoreview' => 'Restriction de autorevision invalide.',
	'stabilize_invalid_level' => 'Nivello de protection invalide.',
	'stabilize_expiry_invalid' => 'Data de expiration invalide.',
	'stabilize_expiry_old' => 'Iste tempore de expiration ha ja passate.',
	'stabilize_denied' => 'Permission refusate.',
	'stabilize-expiring' => 'expira le $1 (UTC)',
	'stabilization-review' => 'Marcar le version actual como verificate',
);

/** Indonesian (Bahasa Indonesia)
 * @author ArdWar
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Kenrick95
 * @author Rex
 */
$messages['id'] = array(
	'stabilization-tab' => 'cek',
	'stabilization' => 'Pengaturan versi stabil halaman',
	'stabilization-text' => "'''Ubah pengaturan berikut untuk mengatur cara versi stabil dari [[:$1|$1]] dipilih dan ditampilkan.'''",
	'stabilization-perm' => 'Akun Anda tidak memiliki izin untuk mengubah konfigurasi versi stabil.
Berikut adalah pengaturan terkini untuk [[:$1|$1]]:',
	'stabilization-page' => 'Nama halaman:',
	'stabilization-leg' => 'Konfirmasi pengaturan versi stabil',
	'stabilization-def' => 'Revisi yang ditampilkan sebagai tampilan baku halaman',
	'stabilization-def1' => 'Revisi stabil; jika tidak ada, maka revisi terkini',
	'stabilization-def2' => 'Revisi terkini',
	'stabilization-restrict' => 'Pembatasan tinjauan/tinjauan otomatis',
	'stabilization-restrict-none' => 'Tidak ada tambahan pembatasan',
	'stabilization-submit' => 'Konfirmasi',
	'stabilization-notexists' => 'Tak ada halaman berjudul "[[:$1|$1]]".
Konfigurasi tak dapat diterapkan.',
	'stabilization-notcontent' => 'Halaman "[[:$1|$1]]" tak dapat ditinjau.
Konfigurasi tak dapat diterapkan.',
	'stabilization-comment' => 'Alasan:',
	'stabilization-otherreason' => 'Alasan lain:',
	'stabilization-expiry' => 'Kedaluwarsa:',
	'stabilization-othertime' => 'Waktu lain:',
	'stabilization-def-short' => 'Baku',
	'stabilization-def-short-0' => 'Terkini',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_page_invalid' => 'Judul halaman tujuan tidak sah.',
	'stabilize_page_notexists' => 'Halaman yang dituju tidak ditemukan',
	'stabilize_page_unreviewable' => 'Halaman yang dituju tidak berada dalam ruang nama yang dapat ditinjau.',
	'stabilize_invalid_autoreview' => 'Pembatasan tinjauan otomatis tidak sah.',
	'stabilize_invalid_level' => 'Tingkat pelindungan tidak valid.',
	'stabilize_expiry_invalid' => 'Tanggal kedaluwarsa tak valid.',
	'stabilize_expiry_old' => 'Tanggal kedaluwarsa telah terlewati.',
	'stabilize_denied' => 'Izin ditolak.',
	'stabilize-expiring' => 'kedaluwarsa $1 (UTC)',
	'stabilization-review' => 'Tandai revisi terkini sebagai terperiksa',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'stabilization-tab' => 'vet',
	'stabilization-page' => 'Áhà ihü:',
	'stabilization-submit' => 'Sị Í kwèrè',
	'stabilization-comment' => 'Mgbághapụtà:',
	'stabilization-otherreason' => 'Mgbághàpụtá ozor:',
	'stabilization-expiry' => 'Gbá okà:',
	'stabilization-othertime' => 'Ógẹ ozor',
	'stabilization-def-short' => 'Nke éjị bịdó',
	'stabilization-def-short-0' => 'Nká Í nọ',
	'stabilization-def-short-1' => 'Chịm',
	'stabilize-expiring' => 'nà gbá ókà na $1 (UTC)',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'stabilization-page' => 'Nomo di la pagino:',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Altra motivo:',
	'stabilization-othertime' => 'Altra tempo:',
	'stabilization-def-short-0' => 'Aktuala',
	'stabilization-def-short-1' => 'Stabila',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'stabilization-page' => 'Titill síðu:',
	'stabilization-submit' => 'Staðfesta',
	'stabilization-comment' => 'Ástæða:',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author Beta16
 * @author Blaisorblade
 * @author Darth Kule
 * @author F. Cosoleto
 * @author Gianfranco
 * @author Melos
 * @author Nemo bis
 * @author Pietrodn
 */
$messages['it'] = array(
	'stabilization' => 'Stabilizzazione pagina',
	'stabilization-text' => "'''Modifica le impostazioni sottostanti per regolare come la versione stabile di [[:$1|$1]] è selezionata e visualizzata.'''",
	'stabilization-perm' => "L'utente non dispone dei permessi necessari a cambiare la configurazione della versione stabile.
Qui ci sono le impostazioni attuali per [[:$1|$1]]:",
	'stabilization-page' => 'Nome della pagina:',
	'stabilization-leg' => 'Conferma le impostazioni della versione stabile',
	'stabilization-def' => 'Revisione visualizzata di default alla visita della pagina',
	'stabilization-def1' => "La versione stabile; se non disponibile, l'ultima revisione",
	'stabilization-def2' => "L'ultima revisione",
	'stabilization-restrict' => 'Restrizioni sulla revisione/auto-revisione',
	'stabilization-restrict-none' => "Nessun'ulteriore restrizione",
	'stabilization-submit' => 'Conferma',
	'stabilization-notexists' => 'Non ci sono pagine col titolo "[[:$1|$1]]".
Non è possibile effettuare la configurazione.',
	'stabilization-notcontent' => 'La pagina "[[:$1|$1]]" non può essere revisionata.
Non è possibile effettuare la configurazione.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Altro motivo:',
	'stabilization-expiry' => 'Scadenza:',
	'stabilization-othertime' => 'Altra durata:',
	'stabilization-def-short' => 'Default',
	'stabilization-def-short-0' => 'Attuale',
	'stabilization-def-short-1' => 'Stabile',
	'stabilize_page_invalid' => 'Il titolo della pagina di destinazione non è valido.',
	'stabilize_page_notexists' => 'La pagina di destinazione non esiste.',
	'stabilize_page_unreviewable' => 'La pagina di destinazione non è in un namespace revisionabile.',
	'stabilize_invalid_level' => 'Livello di protezione non valido.',
	'stabilize_expiry_invalid' => 'Data di scadenza non valida.',
	'stabilize_expiry_old' => 'La data di scadenza è già passata.',
	'stabilize_denied' => 'Permesso negato.',
	'stabilize-expiring' => 'scadenza: $1 (UTC)',
	'stabilization-review' => 'Marca la versione corrente come controllata',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Schu
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'stabilization-tab' => '固定',
	'stabilization' => '表示ページの固定',
	'stabilization-text' => "'''以下で [[:$1|$1]] の公開版の選択方法と表示方法を変更できます。'''",
	'stabilization-perm' => 'あなたのアカウントには公開版の設定を変更する権限がありません。
現在の [[:$1|$1]] における設定は以下の通りです：',
	'stabilization-page' => 'ページ名：',
	'stabilization-leg' => '公開版の設定確認',
	'stabilization-def' => 'ページに既定で表示する版',
	'stabilization-def1' => '公開版、それがない場合は、最新版',
	'stabilization-def2' => '最新版',
	'stabilization-restrict' => '査読および自動査読の制限',
	'stabilization-restrict-none' => '追加制限なし',
	'stabilization-submit' => '設定',
	'stabilization-notexists' => '「[[:$1|$1]]」というページは存在しないため、設定できません。',
	'stabilization-notcontent' => 'ページ「[[:$1|$1]]」は査読対象ではないため、設定できません。',
	'stabilization-comment' => '理由：',
	'stabilization-otherreason' => 'その他の理由：',
	'stabilization-expiry' => '有効期限：',
	'stabilization-othertime' => 'その他の日時：',
	'stabilization-def-short' => '既定表示',
	'stabilization-def-short-0' => '最新版',
	'stabilization-def-short-1' => '公開済み',
	'stabilize_page_invalid' => '指定したページ名が無効です。',
	'stabilize_page_notexists' => '指定したページ名が存在しません。',
	'stabilize_page_unreviewable' => '指定したページは査読可能な名前空間にありません。',
	'stabilize_invalid_autoreview' => '無効な自動査読の制限。',
	'stabilize_invalid_level' => '不正な保護レベル。',
	'stabilize_expiry_invalid' => '有効期限に不正な日時が設定されました。',
	'stabilize_expiry_old' => '有効期限に指定された日時を過ぎています。',
	'stabilize_denied' => '許可されていません。',
	'stabilize-expiring' => '有効期限: $1 (UTC)',
	'stabilization-review' => '現在の版を査読済みとする',
);

/** Jutish (Jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'stabilization-tab' => 'vet',
	'stabilization-page' => 'Pægenavn:',
	'stabilization-def' => 'Reviisje displayen åp somår pæger sigt',
	'stabilization-def1' => 'Æ ståbiil reviisje;
als ekke er, dan æ nuværende',
	'stabilization-def2' => 'Æ nuværende reviisje',
	'stabilization-submit' => 'Konfirmær',
	'stabilization-notexists' => 'Her har ekke pæge nåm "[[:$1|$1]]".
Ekke konfiguråsje er mågleg.',
	'stabilization-notcontent' => 'Æ pæge "[[:$1|$1]]" ken ekke være sæn.
Ekke konfiguråsje er mågleg.',
	'stabilization-comment' => 'Begrundelse:',
	'stabilization-expiry' => 'Duråsje:',
	'stabilization-def-short' => 'Åtåmatisk',
	'stabilization-def-short-0' => 'Nuværende',
	'stabilization-def-short-1' => 'Stabiil',
	'stabilize_expiry_invalid' => 'Ugyldegt duråsje dåt æller tiid.',
	'stabilize_expiry_old' => 'Dette duråsje tiid er ål passærn.',
	'stabilize-expiring' => 'durær biis $1 (UTC)',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'გვერდის სტაბილიზაცია',
	'stabilization-page' => 'გვერდის სახელი:',
	'stabilization-def2' => 'ბოლო ვერსია',
	'stabilization-restrict-none' => 'არც-ერთი დამატებითი აკრძალვა',
	'stabilization-submit' => 'დამოწმება',
	'stabilization-notexists' => 'არ არსებობს გვერდი სახელით "[[:$1|$1]]".
კონფიგურაცია შეუძლებელია.',
	'stabilization-notcontent' => 'გვერდი «[[:$1|$1]]» ვერ შემოწმდება. კონფიგურაცია შეუძლებელია.',
	'stabilization-comment' => 'მიზეზი:',
	'stabilization-otherreason' => 'სხვა მიზეზი:',
	'stabilization-expiry' => 'ვადა:',
	'stabilization-othertime' => 'სხვა დრო:',
	'stabilization-def-short' => 'თავდაპირველი',
	'stabilization-def-short-0' => 'მიმდინარე',
	'stabilization-def-short-1' => 'გამოქვეყნებული',
	'stabilize_expiry_invalid' => 'ვადის გასვლის არასწორი თარიღი.',
	'stabilize_expiry_old' => 'მოქმედების ვადა გავიდა.',
	'stabilize-expiring' => 'ვადა გასდის: $1 (UTC)',
	'stabilization-review' => 'მონიშნეთ ამჟამინდელი ცვლილება შემოწმებულად',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'stabilization-tab' => '(سق)',
	'stabilization' => 'بەتتى تىياناقتاۋ',
	'stabilization-text' => 'تومەندەگى باپتالىمداردى وزگەرتكەندە [[:$1|$1]] دەگەننىڭ تىياناقتى نۇسقاسى قالاي بولەكتەنۋى مەن كورسەتىلۋى تۇزەتىلەدى.',
	'stabilization-perm' => 'تىركەلگىڭىزگە تىياناقتى نۇسقانىڭ باپتالىمىن وزگەرتۋگە رۇقسات بەرىلمەگەن.
[[:$1|$1]] ٴۇشىن اعىمداعى باپتاۋلار مىندا كەلتىرىلەدى:',
	'stabilization-page' => 'بەت اتاۋى:',
	'stabilization-leg' => 'بەت ٴۇشىن تىياناقتى نۇسقانى باپتاۋ',
	'stabilization-def' => 'بەتتىڭ ادەپكى كورىنىسىندە كەلتىرىلەتىن نۇسقا',
	'stabilization-def1' => 'تىياناقتى نۇسقاسى; ەگەر جوق بولسا, اعىمداعىلاردىڭ بىرەۋى بولادى',
	'stabilization-def2' => 'اعىمدىق نۇسقاسى',
	'stabilization-submit' => 'قۇپتاۋ',
	'stabilization-notexists' => '«[[:$1|$1]]» دەپ اتالعان ەش بەت جوق. ەش باپتالىم رەتتەلمەيدى.',
	'stabilization-notcontent' => '«[[:$1|$1]]» دەگەن بەتكە سىن بەرىلمەيدى. ەش باپتالىم رەتتەلمەيدى.',
	'stabilization-comment' => 'سەبەبى:',
	'stabilization-def-short' => 'ادەپكى',
	'stabilization-def-short-0' => 'اعىمدىق',
	'stabilization-def-short-1' => 'تىياناقتى',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'stabilization-tab' => '(сқ)',
	'stabilization' => 'Бетті тиянақтау',
	'stabilization-text' => 'Төмендегі бапталымдарды өзгерткенде [[:$1|$1]] дегеннің тиянақты нұсқасы қалай бөлектенуі мен көрсетілуі түзетіледі.',
	'stabilization-perm' => 'Тіркелгіңізге тиянақты нұсқаның бапталымын өзгертуге рұқсат берілмеген.
[[:$1|$1]] үшін ағымдағы баптаулар мында келтіріледі:',
	'stabilization-page' => 'Бет атауы:',
	'stabilization-leg' => 'Бет үшін тиянақты нұсқаны баптау',
	'stabilization-def' => 'Беттің әдепкі көрінісінде келтірілетін нұсқа',
	'stabilization-def1' => 'Тиянақты нұсқасы; егер жоқ болса, ағымдағылардың біреуі болады',
	'stabilization-def2' => 'Ағымдық нұсқасы',
	'stabilization-submit' => 'Құптау',
	'stabilization-notexists' => '«[[:$1|$1]]» деп аталған еш бет жоқ. Еш бапталым реттелмейді.',
	'stabilization-notcontent' => '«[[:$1|$1]]» деген бетке сын берілмейді. Еш бапталым реттелмейді.',
	'stabilization-comment' => 'Себебі:',
	'stabilization-def-short' => 'Әдепкі',
	'stabilization-def-short-0' => 'Ағымдық',
	'stabilization-def-short-1' => 'Тиянақты',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'stabilization-tab' => '(sq)',
	'stabilization' => 'Betti tïyanaqtaw',
	'stabilization-text' => 'Tömendegi baptalımdardı özgertkende [[:$1|$1]] degenniñ tïyanaqtı nusqası qalaý bölektenwi men körsetilwi tüzetiledi.',
	'stabilization-perm' => 'Tirkelgiñizge tïyanaqtı nusqanıñ baptalımın özgertwge ruqsat berilmegen.
[[:$1|$1]] üşin ağımdağı baptawlar mında keltiriledi:',
	'stabilization-page' => 'Bet atawı:',
	'stabilization-leg' => 'Bet üşin tïyanaqtı nusqanı baptaw',
	'stabilization-def' => 'Bettiñ ädepki körinisinde keltiriletin nusqa',
	'stabilization-def1' => 'Tïyanaqtı nusqası; eger joq bolsa, ağımdağılardıñ birewi boladı',
	'stabilization-def2' => 'Ağımdıq nusqası',
	'stabilization-submit' => 'Quptaw',
	'stabilization-notexists' => '«[[:$1|$1]]» dep atalğan eş bet joq. Eş baptalım rettelmeýdi.',
	'stabilization-notcontent' => '«[[:$1|$1]]» degen betke sın berilmeýdi. Eş baptalım rettelmeýdi.',
	'stabilization-comment' => 'Sebebi:',
	'stabilization-def-short' => 'Ädepki',
	'stabilization-def-short-0' => 'Ağımdıq',
	'stabilization-def-short-1' => 'Tïyanaqtı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'stabilization-page' => 'ឈ្មោះទំព័រ៖',
	'stabilization-def2' => 'ការពិនិត្យឡើងវិញពេលបច្ចុប្បន្ន',
	'stabilization-submit' => 'បញ្ជាក់ទទួលស្គាល់',
	'stabilization-comment' => 'មូលហេតុ៖',
	'stabilization-otherreason' => 'មូលហេតុផ្សេងទៀត៖',
	'stabilization-expiry' => 'ផុតកំណត់៖',
	'stabilization-othertime' => 'រយៈពេលផ្សេងទៀត៖',
	'stabilization-def-short' => 'លំនាំដើម',
	'stabilization-def-short-0' => 'បច្ចុប្បន្ន',
	'stabilization-def-short-1' => 'ឋិតថេរ',
	'stabilize_page_invalid' => 'ឈ្មោះឯកសារគោលដៅមិនត្រឹមត្រូវ។',
	'stabilize_page_notexists' => 'មិនមាន​ទំព័រ​គោលដៅនេះ​ទេ​។',
	'stabilize_expiry_invalid' => 'កាលបរិច្ឆេទផុតកំណត់មិនត្រឹមត្រូវ។',
	'stabilize-expiring' => 'ផុតកំណត់ម៉ោង $1 (UTC)',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'stabilization-comment' => 'ಕಾರಣ:',
	'stabilization-otherreason' => 'ಇತರ ಕಾರಣ:',
);

/** Korean (한국어)
 * @author Devunt
 * @author Gapo
 * @author Kwj2772
 */
$messages['ko'] = array(
	'stabilization-tab' => '검토',
	'stabilization' => '문서 배포 설정',
	'stabilization-text' => "'''[[:$1|$1]] 문서의 배포판을 어떻게 선택되어 보여질 지에 대한 설정을 아래 양식을 통해 바꿀 수 있습니다.'''",
	'stabilization-perm' => '당신의 계정은 게시 설정 변경을 할 수 있는 권한이 없습니다.
[[:$1|$1]]에 현재 설정이 있습니다',
	'stabilization-page' => '문서 이름:',
	'stabilization-leg' => '게시 설정 확인',
	'stabilization-def' => '기본 문서 보기에서 판 표시',
	'stabilization-def1' => '게시 판; 현재 판이 아니라면, 현재/임시 판',
	'stabilization-def2' => '현재/임시 판',
	'stabilization-restrict' => '검토/자동 검토 제한',
	'stabilization-restrict-none' => '추가 제한 없음',
	'stabilization-submit' => '확인',
	'stabilization-notexists' => '"[[:$1|$1]]" 문서가 존재하지 않습니다.
설정이 불가능합니다.',
	'stabilization-notcontent' => '"[[:$1|$1]]" 문서는 검토할 수 없습니다.
설정이 불가능합니다.',
	'stabilization-comment' => '이유:',
	'stabilization-otherreason' => '다른 이유:',
	'stabilization-expiry' => '기한:',
	'stabilization-othertime' => '다른 시간:',
	'stabilization-def-short' => '기본 설정',
	'stabilization-def-short-0' => '현재',
	'stabilization-def-short-1' => '게시',
	'stabilize_page_invalid' => '문서 이름이 잘못되었습니다.',
	'stabilize_page_notexists' => '문서가 존재하지 않습니다.',
	'stabilize_page_unreviewable' => '문서가 검토 가능한 이름공간에 존재하지 않습니다',
	'stabilize_invalid_autoreview' => '잘못된 자동 검토 제한',
	'stabilize_invalid_level' => '잘못된 보호 수준.',
	'stabilize_expiry_invalid' => '기한을 잘못 입력하였습니다.',
	'stabilize_expiry_old' => '기한을 과거로 입력하였습니다.',
	'stabilize_denied' => '권한 없음',
	'stabilize-expiring' => '$1 (UTC)에 만료',
	'stabilization-review' => '현재 판을 확인한 것으로 표시',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'stabilization-tab' => 'Qualliteit',
	'stabilization' => 'Enshtellunge för beschtändijje Sigge',
	'stabilization-text' => "'''Donn de Enshtellunge onge aanpasse, öm faßzelääje, wi de {{int:stablepages-stable}} vun [[:$1|$1]] ußjesöhk un aanjezeijsch weedt.'''",
	'stabilization-perm' => 'Der fäählt et Rääsch, de Enshtellunge för de beshtändijje Versione vun Sigge ze verändere. Dat hee sin de aktoälle Enshtellunge för di Sigg „[[:$1|$1]]“:',
	'stabilization-page' => 'Name fun dä Sigg:',
	'stabilization-leg' => 'Donn de Enshtellunge för de {{int:stablepages-stable}} vun en Sigg beschtäätejje',
	'stabilization-def' => 'De Version, di shtanndatmääßesch aanjezeisch weed, wann Eine en Sigg opröhf',
	'stabilization-def1' => 'De {{int:stablepages-stable}}, un wann et kein jitt, dann de neuste Version.',
	'stabilization-def2' => 'De neuste Version',
	'stabilization-restrict' => 'Beschrängkunge för et automattesch als nohjekik Makeere',
	'stabilization-restrict-none' => 'Kein zohsäzlejje Beschränkunge',
	'stabilization-submit' => 'Bestätije',
	'stabilization-notexists' => 'Mer han kein Sigg met dämm Tittel „[[:$1|$1]]“.
Et jit nix enzestelle.',
	'stabilization-notcontent' => 'De Sigg met dämm Tittel „[[:$1|$1]]“ kam_mer nit nohkike.
Et jidd och nix ennzeshtelle.',
	'stabilization-comment' => 'Jrond:',
	'stabilization-otherreason' => 'Ene andere Jrond:',
	'stabilization-expiry' => 'Leuf uß:',
	'stabilization-othertime' => 'En ander Zick:',
	'stabilization-def-short' => 'Shtandatt',
	'stabilization-def-short-0' => 'Von jetz',
	'stabilization-def-short-1' => 'Beshtändesch',
	'stabilize_page_invalid' => 'Dä Tittel vum Ziel es nit jöltesch',
	'stabilize_page_notexists' => 'Di Ziel_Sigg jitt et nit.',
	'stabilize_page_unreviewable' => 'De Ziel_Sigg es en enem Appachtemang, woh et Nohkik nit müjjelesch es.',
	'stabilize_invalid_autoreview' => 'En önjöltijje Beschrängkong för et automattesch Nohkike.',
	'stabilize_invalid_level' => 'Ene onjöltije Schotz för en Sigg.',
	'stabilize_expiry_invalid' => 'Dat Affloufdattum es nit jöltisch.',
	'stabilize_expiry_old' => 'Dat Affloufdattum es ald förbei.',
	'stabilize_denied' => 'Zohjang verbodde.',
	'stabilize-expiring' => 'leuf uß, am $2 öm $3 Uhr (UTC)',
	'stabilization-review' => 'Donn faßhallde, dat de aktoälle Version nohjekik es',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'stabilization-page' => 'Navê rûpelê:',
	'stabilization-comment' => 'Sedem:',
	'stabilization-otherreason' => 'Sedemekî din:',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'stabilization-page' => 'Nomen paginae:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'stabilization-tab' => 'Astellung',
	'stabilization' => 'Stabilisatioun vun der Säit',
	'stabilization-text' => "'''Ännert d'Astellungen ënnendrënner fir anzestellen wéi déi publizéiert Versioun vu(n) [[:$1|$1]] erausgesicht an ugewise gëtt.'''",
	'stabilization-perm' => "Äre Benotzerkont huet net d'Recht fir d'Astellung vun der publizéierter Versioun z'änneren.
Hei sinn déi aktuell Astellunge fir [[:$1|$1]]:",
	'stabilization-page' => 'Säitennumm:',
	'stabilization-leg' => "Confirméiert d'publizéiert-Versiouns-Astellungen",
	'stabilization-def' => 'Versioun déi als Standard beim Weise vun der Säit gewise gëtt',
	'stabilization-def1' => 'Déi stabil Versioun; oder wann et keng gëtt, déi lescht Versioun',
	'stabilization-def2' => 'Déi stabil Versioun',
	'stabilization-restrict' => 'Limitatioune vum Nokucken/automatesche Nokucken',
	'stabilization-restrict-none' => 'Keng speziell Restriktiounen',
	'stabilization-submit' => 'Confirméieren',
	'stabilization-notexists' => 'D\'Säit "[[:$1|$1]]" gëtt et net.
Keng Astellunge méiglech.',
	'stabilization-notcontent' => 'D\'Säit "[[:$1|$1]]" kann net nogekuckt ginn.
Et ass keng Konfiguratioun méiglech.',
	'stabilization-comment' => 'Grond:',
	'stabilization-otherreason' => 'Anere Grond:',
	'stabilization-expiry' => 'Valabel bis:',
	'stabilization-othertime' => 'Aner Zäit:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktuell',
	'stabilization-def-short-1' => 'Publizéiert',
	'stabilize_page_invalid' => 'Den Titel vun der Zilsäit ass net valabel.',
	'stabilize_page_notexists' => "D'Zilsäit gëtt et net",
	'stabilize_page_unreviewable' => "D'Zilsäit ass net an engem Nummraum wou Säite kënnen nogekuckt ginn.",
	'stabilize_invalid_autoreview' => 'Net valabel Limitatioun beim automateschen Nokucken.',
	'stabilize_invalid_level' => 'Ne valabelen Niveau vun der Spär.',
	'stabilize_expiry_invalid' => 'Net valabele Schlussdatum',
	'stabilize_expiry_old' => 'Den Oflafdatum ass schonn eriwwer.',
	'stabilize_denied' => 'Erlaabnes refuséiert',
	'stabilize-expiring' => 'bis $1 (UTC)',
	'stabilization-review' => 'Déi aktuell Versioun als nogekuckt markéieren',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'stabilization-tab' => '(kb)',
	'stabilization' => 'Paginastabilisatie',
	'stabilization-text' => "'''Wiezig de ongerstaonde instellinge om aan te passe wie de gepubliceerde versie van [[:$1|$1]] geselecteerd en weergegaeve weurt.'''",
	'stabilization-perm' => 'Doe höbs gein rechte om de instellinge veur de gepubliceerde versie te wiezige.
Dit zeen de hudige instellinge veur [[:$1|$1]]:',
	'stabilization-page' => 'Pazjenanaam:',
	'stabilization-leg' => 'Bevestig instellinge stabiel versie',
	'stabilization-def' => 'Versie dae standerd getuund wörd',
	'stabilization-def1' => "De stebiel verzie; is die d'r neet, den de lèste",
	'stabilization-def2' => 'De nuujste versie',
	'stabilization-restrict' => 'Beperkinge op (automatisch) gecontroleerd markere',
	'stabilization-restrict-none' => 'Gein biekómstig beperkinge',
	'stabilization-submit' => 'Bevestige',
	'stabilization-notexists' => 'd\'r Is geine pazjena "[[:$1|$1]]". Instelle is neet meugelik.',
	'stabilization-notcontent' => 'De pazjena "[[:$1|$1]]" kin neet beoordeild waere. Instelle is neet meugelik.',
	'stabilization-comment' => 'Reeje:',
	'stabilization-otherreason' => 'Anger reeje:',
	'stabilization-expiry' => 'Verloup:',
	'stabilization-othertime' => 'Angere doer:',
	'stabilization-def-short' => 'Standerd',
	'stabilization-def-short-0' => 'Hujig',
	'stabilization-def-short-1' => 'Stabiel',
	'stabilize_page_invalid' => 'De doelpaginanaam is ongeldig.',
	'stabilize_page_notexists' => 'De doelpagina besteit neet.',
	'stabilize_page_unreviewable' => "De doelpagina bevindj zich neet in 'n te controlere naamruumde.",
	'stabilize_invalid_autoreview' => 'Ongeldige beperking veur automatische controle',
	'stabilize_invalid_level' => 'Ongeldig besjörmingsniveau.',
	'stabilize_expiry_invalid' => 'Ongeldige verloopdatum.',
	'stabilize_expiry_old' => 'Deze verloopdatum is al verstreke.',
	'stabilize_denied' => 'Geinen toegank.',
	'stabilize-expiring' => 'verloopt $1 (UTC)',
	'stabilization-review' => 'Markeer hudige versie es gecontroleerd',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Matasg
 */
$messages['lt'] = array(
	'stabilization-page' => 'Puslapio pavadinimas:',
	'stabilization-submit' => 'Patvirtinti',
	'stabilization-comment' => 'Priežastis:',
	'stabilization-otherreason' => 'Kitos priežastys:',
	'stabilization-expiry' => 'Baigiasi:',
	'stabilization-othertime' => 'Kitas laikas:',
	'stabilization-def-short' => 'Standartinis',
	'stabilization-def-short-0' => 'Esamas',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'stabilization-comment' => 'Iemesls:',
	'stabilization-otherreason' => 'Cits iemesls:',
	'stabilization-expiry' => 'Beidzas:',
	'stabilization-othertime' => 'Cits laiks:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'stabilization-page' => 'Лаштыкын лӱмжӧ:',
	'stabilization-def-short' => 'Ойлыде',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'stabilization-tab' => 'конфиг.',
	'stabilization' => 'Стабилизација на страница',
	'stabilization-text' => "'''Изменете ги поставките подолу за да прилагодите како се одбира и прикажува објавената верзија на [[:$1|$1]].'''",
	'stabilization-perm' => 'Вашата сметка нема дозвола за промена на конфигурацијата на објавената верзија.
Еве ги моменталните нагодувања за [[:$1|$1]]:',
	'stabilization-page' => 'Име на страницата:',
	'stabilization-leg' => 'Потврди нагодувања за објавена верзија',
	'stabilization-def' => 'Верзија прикажана по основно при преглед на страница',
	'stabilization-def1' => 'Стабилната ревизија; ако не постои, тогаш најновата ревизија',
	'stabilization-def2' => 'Најновата ревизија',
	'stabilization-restrict' => 'Ограничувања на прегледување/автопрегледување',
	'stabilization-restrict-none' => 'Нема дополнителни ограничувања',
	'stabilization-submit' => 'Потврди',
	'stabilization-notexists' => 'Нема страница насловена како "[[:$1|$1]]".
Не е можно нагодување.',
	'stabilization-notcontent' => 'Страницата "[[:$1|$1]]" не може да се проверува.
Не е можно нагодување.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Друга причина:',
	'stabilization-expiry' => 'Истекува:',
	'stabilization-othertime' => 'Друго време:',
	'stabilization-def-short' => 'Основно',
	'stabilization-def-short-0' => 'Моментално',
	'stabilization-def-short-1' => 'Објавена',
	'stabilize_page_invalid' => 'Целната страница е неважечка.',
	'stabilize_page_notexists' => 'Целната страница не постои.',
	'stabilize_page_unreviewable' => 'Целната страница не е во проверлив именски простор.',
	'stabilize_invalid_autoreview' => 'Неважечко ограничување на автопрегледот',
	'stabilize_invalid_level' => 'Неважечко ниво на заштита.',
	'stabilize_expiry_invalid' => 'Погрешен датум на важност.',
	'stabilize_expiry_old' => 'Времето на важност веќе е поминато.',
	'stabilize_denied' => 'Пристапот е забранет.',
	'stabilize-expiring' => 'истекува $1 (UTC)',
	'stabilization-review' => 'Обележи ја тековната верзија како проверена',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'stabilization-tab' => 'സ്ഥിരത',
	'stabilization' => 'താളിന്റെ സ്ഥിരീകരണം',
	'stabilization-text' => "'''താഴെക്കൊടുത്തിരിക്കുന്ന സജ്ജീകരണങ്ങൾ ക്രമീകരിച്ച് [[:$1|$1]] താളിന്റെ സ്ഥിരതയുള്ള പതിപ്പ് എപ്രകാരം തിരഞ്ഞെടുക്കണമെന്നും പ്രദർശിപ്പിക്കണെമെന്നും നിർണ്ണയിക്കാം.'''",
	'stabilization-perm' => 'പ്രസിദ്ധീകരിക്കപ്പെട്ട പതിപ്പിന്റെ ക്രമീകരണം മാറ്റുന്നതിനുള്ള അവകാശം താങ്കളുടെ അംഗത്വത്തിനില്ല. [[:$1|$1]]ന്റെ നിലവിലുള്ള ക്രമീകരണം ഇവിടെ കാണാം:',
	'stabilization-page' => 'താളിന്റെ പേര്‌:',
	'stabilization-leg' => 'പ്രസിദ്ധീകരിക്കപ്പെട്ട പതിപ്പിന്റെ ക്രമീകരണങ്ങൾ സ്ഥിരീകരിക്കുക',
	'stabilization-def' => 'താളിന്റെ സ്വതേയുള്ള നിലയിൽ പ്രദർശിപ്പിക്കുന്ന പതിപ്പ്',
	'stabilization-def1' => 'സ്ഥിരപ്പെടുത്തിയ പതിപ്പ്;
അതില്ലെങ്കിൽ ഏറ്റവും പുതിയ പതിപ്പ്',
	'stabilization-def2' => 'ഒടുവിലത്തെ നാൾപ്പതിപ്പ്',
	'stabilization-restrict' => 'സംശോധന/സ്വയം-സംശോധന പരിമിതപ്പെടുത്തലുകൾ',
	'stabilization-restrict-none' => 'കൂടുതൽ പരിമിതപ്പെടുത്തലുകളില്ല',
	'stabilization-submit' => 'സ്ഥിരീകരിക്കുക',
	'stabilization-notexists' => '"[[:$1|$1]]". എന്ന ഒരു താൾ നിലവിലില്ല. ക്രമീകരണങ്ങൾ നടത്തുന്നതിനു സാദ്ധ്യമല്ല.',
	'stabilization-notcontent' => '"[[:$1|$1]]" എന്ന താൾ സം‌ശോധനം ചെയ്യുന്നതിനു സാദ്ധ്യമല്ല. ക്രമീകരണം അനുവദനീയമല്ല.',
	'stabilization-comment' => 'കാരണം:',
	'stabilization-otherreason' => 'മറ്റു കാരണം:',
	'stabilization-expiry' => 'കാലാവധി:',
	'stabilization-othertime' => 'മറ്റ് കാലയളവ്:',
	'stabilization-def-short' => 'സ്വതേ',
	'stabilization-def-short-0' => 'നിലവിലുള്ളത്',
	'stabilization-def-short-1' => 'പ്രസിദ്ധീകരിക്കപ്പെട്ടത്',
	'stabilize_page_invalid' => 'താളിനു ലക്ഷ്യമിട്ട പേര് അസാധുവാണ്.',
	'stabilize_page_notexists' => 'ലക്ഷ്യമിട്ട താൾ നിലവിലില്ല.',
	'stabilize_page_unreviewable' => 'ലക്ഷ്യമിട്ട താൾ സംശോധനം ചെയ്യാവുന്ന നാമമേഖലയിലല്ല.',
	'stabilize_invalid_autoreview' => 'അസാധുവായ സ്വയംസംശോധന പരിമിതപ്പെടുത്തൽ',
	'stabilize_invalid_level' => 'അസാധുവായ സംരക്ഷണ മാനം.',
	'stabilize_expiry_invalid' => 'അസാധുവായ കാലാവധി തീയതി.',
	'stabilize_expiry_old' => 'ഈ കാലാവധി സമയം കഴിഞ്ഞു പോയി.',
	'stabilize_denied' => 'അനുമതി നിഷേധിച്ചിരിക്കുന്നു.',
	'stabilize-expiring' => 'കാലാവധി തീരുന്നത് - $1 (UTC)',
	'stabilization-review' => 'ഇപ്പോഴുള്ള പതിപ്പ് പരിശോധിച്ചതായി അടയാളപ്പെടുത്തുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'stabilization-comment' => 'Шалтгаан:',
	'stabilization-otherreason' => 'Өөр шалтгаан:',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'stabilization-tab' => 'व्हेट',
	'stabilization' => 'पान स्थिर करा',
	'stabilization-text' => "[[:$1|$1]] ची स्थिर आवृत्ती कशा प्रकारे निवडली अथवा दाखविली जाईल या साठी खालील रुपरेषा बदला.'''",
	'stabilization-perm' => 'तुम्हाला स्थिर आवृत्ती बदलण्याची परवानगी नाही.
[[:$1|$1]]चे सध्याचे सेटींग खालीलप्रमाणे:',
	'stabilization-page' => 'पृष्ठ नाव:',
	'stabilization-leg' => 'स्थिर आवृत्ती सेटिंग निश्चित करा',
	'stabilization-def' => 'मूळ प्रकारे पानावर बदल दाखविलेले आहेत',
	'stabilization-def1' => 'स्थिर आवृत्ती;
जर उपलब्ध नसेल, तर सध्याची',
	'stabilization-def2' => 'सध्याची आवृत्ती',
	'stabilization-submit' => 'सहमती द्या',
	'stabilization-notexists' => '"[[:$1|$1]]" या नावाचे पृष्ठ अस्तित्वात नाही.
बदल करू शकत नाही.',
	'stabilization-notcontent' => '"[[:$1|$1]]" हे पान तपासू शकत नाही.
बदल करता येणार नाहीत.',
	'stabilization-comment' => 'कारण:',
	'stabilization-expiry' => 'रद्द होते:',
	'stabilization-def-short' => 'मूळ (अविचल)',
	'stabilization-def-short-0' => 'सद्य',
	'stabilization-def-short-1' => 'स्थीर',
	'stabilize_expiry_invalid' => 'चुकीचा रद्दीकरण दिनांक.',
	'stabilize_expiry_old' => 'ही रद्दीकरण वेळ उलटून गेलेली आहे.',
	'stabilize-expiring' => '$1 (UTC) ला रद्द होते',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'stabilization-tab' => 'periksa',
	'stabilization' => 'Penstabilan laman',
	'stabilization-text' => "'''Ubah tetapan di bawah untuk melaraskan cara memilih dan memaparkan versi stabil [[:$1|$1]].'''",
	'stabilization-perm' => 'Akaun anda tidak dibenarkan mengubah konfigurasi versi stabil.
Berikut ialah tetapan semasa untuk [[:$1|$1]]:',
	'stabilization-page' => 'Nama laman:',
	'stabilization-leg' => 'Sahkan tetapan versi stabil',
	'stabilization-def' => 'Semakan yang dipaparkan pada paparan laman asali',
	'stabilization-def1' => 'Semakan stabil; jika tiada, maka semakan terkini',
	'stabilization-def2' => 'Semakan terkini',
	'stabilization-restrict' => 'Sekatan kepada penyemakan/penyemakan automatik',
	'stabilization-restrict-none' => 'Tiada pengehadan tambahan',
	'stabilization-submit' => 'Sahkan',
	'stabilization-notexists' => 'Tiada laman dengan nama "[[:$1|$1]]".
Tetapan tidak boleh dibuat.',
	'stabilization-notcontent' => 'Laman "[[:$1|$1]]" tidak boleh diperiksa.
Tetapan tidak boleh dibuat.',
	'stabilization-comment' => 'Alasan:',
	'stabilization-otherreason' => 'Sebab lain:',
	'stabilization-expiry' => 'Tamat pada:',
	'stabilization-othertime' => 'Waktu lain:',
	'stabilization-def-short' => 'Asali',
	'stabilization-def-short-0' => 'Semasa',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_page_invalid' => 'Tajuk laman sasaran tidak sah.',
	'stabilize_page_notexists' => 'Laman sasaran tidak wujud.',
	'stabilize_page_unreviewable' => 'Laman sasaran tiada dalam ruang nama yang boleh dikaji semula.',
	'stabilize_invalid_autoreview' => 'Sekatan kaji semula automatik tidak sah.',
	'stabilize_invalid_level' => 'Tahap perlindungan tidak sah.',
	'stabilize_expiry_invalid' => 'Tarikh tamat tidak sah.',
	'stabilize_expiry_old' => 'Waktu tamat telah pun berlalu.',
	'stabilize_denied' => 'Kebenaran ditolak.',
	'stabilize-expiring' => 'tamat pada $1 (UTC)',
	'stabilization-review' => 'Tandai semakan semasa sebagai diperiksa',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'stabilization-page' => 'Лопань лем:',
	'stabilization-submit' => 'Кемекстамс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Ricardo gs
 */
$messages['nah'] = array(
	'stabilization-page' => 'Zāzanilli ītōcā:',
	'stabilization-def2' => 'In yancuīc tlachiyaliztli',
	'stabilization-expiry' => 'Tlamiliztli:',
	'stabilization-def-short' => 'Ic default',
	'stabilization-def-short-0' => 'Āxcān',
	'stabilize-expiring' => 'motlamīz $1 (UTC)',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author H92
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'stabilization-tab' => 'kvalitet',
	'stabilization' => 'Sidestabilisering',
	'stabilization-text' => "'''Endre innstillingene nedenfor for å bestemme hvordan den publiserte versjonen av [[:$1|$1]] skal velges og vises.'''",
	'stabilization-perm' => 'Din brukerkonto har ikke tillatelse til å endre innstillinger for publiserte versjoner.
Her er de nåværende innstillingene for [[:$1|$1]]:',
	'stabilization-page' => 'Sidenavn:',
	'stabilization-leg' => 'Bekreft innstillinger for publiserte versjoner',
	'stabilization-def' => 'Sideversjonen som skal brukes som standardvisning',
	'stabilization-def1' => 'Den stabile versjonen; om den ikke finnes, den siste revisjon',
	'stabilization-def2' => 'Den siste revisjonen',
	'stabilization-restrict' => 'Begrensninger av revidering/auto-revidering',
	'stabilization-restrict-none' => 'Ingen ekstra begrensinger',
	'stabilization-submit' => 'Bekreft',
	'stabilization-notexists' => 'Det er ingen side med tittelen «[[:$1|$1]]». Ingen innstillinger kan gjøres.',
	'stabilization-notcontent' => 'Siden «[[:$1|$1]]» kan ikke bli undersøkt. Ingen innstillinger kan gjøres.',
	'stabilization-comment' => 'Årsak:',
	'stabilization-otherreason' => 'Annen årsak:',
	'stabilization-expiry' => 'Utgår:',
	'stabilization-othertime' => 'Annen tid:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Nåværende',
	'stabilization-def-short-1' => 'Publisert',
	'stabilize_page_invalid' => 'Målsidetittelen er ugyldig.',
	'stabilize_page_notexists' => 'Målsiden finnes ikke.',
	'stabilize_page_unreviewable' => 'Målsiden er ikke i et reviderbart navnerom.',
	'stabilize_invalid_autoreview' => 'Ugyldig autorevideringsbegrensning',
	'stabilize_invalid_level' => 'Ugyldig beskyttelsesnivå.',
	'stabilize_expiry_invalid' => 'Ugyldig varighet.',
	'stabilize_expiry_old' => 'Varigheten har allerede utløpt.',
	'stabilize_denied' => 'Tilgang nektet.',
	'stabilize-expiring' => 'utgår $1 (UTC)',
	'stabilization-review' => 'Merk den nåværende revisjonen som kontrollert',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'stabilization-page' => 'Siedennaam:',
	'stabilization-comment' => 'Grund:',
	'stabilization-expiry' => 'Löppt ut:',
	'stabilize-expiring' => 'löppt $1 ut (UTC)',
);

/** Dutch (Nederlands)
 * @author Annabel
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'stabilization-tab' => '(er)',
	'stabilization' => 'Paginastabilisatie',
	'stabilization-text' => "'''Wijzig de onderstaande instellingen om aan te passen hoe de gepubliceerde versie van [[:$1|$1]] geselecteerd en weergegeven wordt.'''",
	'stabilization-perm' => 'U hebt geen rechten om de instellingen voor de gepubliceerde versie te wijzigen.
Dit zijn de huidige instellingen voor [[:$1|$1]]:',
	'stabilization-page' => 'Paginanaam:',
	'stabilization-leg' => 'Instellingen gepubliceerde versie bevestigen',
	'stabilization-def' => 'Versie die standaard weergegeven wordt',
	'stabilization-def1' => 'De weergegeven versie; als die er niet is, dan de laatste versie',
	'stabilization-def2' => 'De nieuwste versie',
	'stabilization-restrict' => 'Beperkingen op (automatisch) gecontroleerd markeren',
	'stabilization-restrict-none' => 'Geen additionele beperkingen',
	'stabilization-submit' => 'Bevestigen',
	'stabilization-notexists' => 'Er is geen pagina "[[:$1|$1]]".
Instellen is niet mogelijk.',
	'stabilization-notcontent' => 'U kunt de pagina "[[:$1|$1]]" niet controleren.
Instellen is niet mogelijk.',
	'stabilization-comment' => 'Reden:',
	'stabilization-otherreason' => 'Andere reden:',
	'stabilization-expiry' => 'Vervallen:',
	'stabilization-othertime' => 'Andere tijd:',
	'stabilization-def-short' => 'Standaard',
	'stabilization-def-short-0' => 'Huidig',
	'stabilization-def-short-1' => 'Gepubliceerd',
	'stabilize_page_invalid' => 'De naam van de doelpagina is ongeldig.',
	'stabilize_page_notexists' => 'De doelpagina bestaat niet.',
	'stabilize_page_unreviewable' => 'De doelpagina is bevindt zich niet in een te controleren naamruimte.',
	'stabilize_invalid_autoreview' => 'Ongeldige beperking voor automatische controle',
	'stabilize_invalid_level' => 'Ongeldig beschermingsniveau.',
	'stabilize_expiry_invalid' => 'Ongeldige vervaldatum.',
	'stabilize_expiry_old' => 'Deze vervaldatum is al verstreken.',
	'stabilize_denied' => 'Geen toegang.',
	'stabilize-expiring' => 'vervalt $1 (UTC)',
	'stabilization-review' => 'Huidige versie als gecontroleerd markeren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'stabilization-tab' => 'kvalitet',
	'stabilization' => 'Sidestabilisering',
	'stabilization-text' => "'''Endra innstillingane nedanfor for å velja korleis den stabile versjonen av [[:$1|$1]] skal verta vald og synt.'''",
	'stabilization-perm' => 'Brukarkontoen din har ikkje løyve til å endra innstillingane for stabile versjonar.
Her er dei noverande innstillingane for [[:$1|$1]]:',
	'stabilization-page' => 'Sidenamn:',
	'stabilization-leg' => 'Stadfest innstillingane for stabile versjonar',
	'stabilization-def' => 'Sideversjonen som skal verta nytta som standardvising',
	'stabilization-def1' => 'Den stabile versjonen om han finst; om ikkje, den siste versjonen',
	'stabilization-def2' => 'Den siste versjonen',
	'stabilization-restrict' => 'Avgrensing på automelding',
	'stabilization-restrict-none' => 'Ingen ekstra avgrensingar',
	'stabilization-submit' => 'Stadfest',
	'stabilization-notexists' => 'Det finst inga sida med tittelen «[[:$1|$1]]».
Ingen innstillingar kan verta gjort.',
	'stabilization-notcontent' => 'Sida «[[:$1|$1]]» kan ikkje verta vurdert.
Ingen innstillingar kan verta gjorde.',
	'stabilization-comment' => 'Årsak:',
	'stabilization-otherreason' => 'Anna årsak',
	'stabilization-expiry' => 'Endar:',
	'stabilization-othertime' => 'Anna tid:',
	'stabilization-def-short' => '(standard)',
	'stabilization-def-short-0' => 'Noverande',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_page_invalid' => 'Målsidetittelen er ugyldig.',
	'stabilize_page_notexists' => 'Målsida finst ikkje.',
	'stabilize_expiry_invalid' => 'Ugyldig sluttdato.',
	'stabilize_expiry_old' => 'Sluttdatoen har alt vore.',
	'stabilize-expiring' => 'endar $1 (UTC)',
	'stabilization-review' => 'Vurder den noverande versjonen',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'stabilization-comment' => 'Resone:',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'stabilization-page' => 'Leina la letlakala:',
	'stabilize-expiring' => 'fetatšatši $1 (UTC)',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author ChrisPtDe
 * @author Juanpabl
 */
$messages['oc'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'Estabilizacion de la pagina',
	'stabilization-text' => "'''Modificatz los paramètres çaijós per definir lo biais dont la version establa de [[:$1|$1]] es seleccionada e afichada.'''",
	'stabilization-perm' => 'Vòstre compte a pas los dreches per cambiar los paramètres de la version publicada.
Aquí los paramètres actuals de [[:$1|$1]] :',
	'stabilization-page' => 'Nom de la pagina :',
	'stabilization-leg' => 'Confirmar lo parametratge de la version publicada',
	'stabilization-def' => "Version afichada al moment de l'afichatge per defaut de la pagina",
	'stabilization-def1' => "La revision publicada ; se'n i a pas, alara la correnta o lo borrolhon en cors",
	'stabilization-def2' => 'La revision correnta o lo borrolhon en cors',
	'stabilization-restrict' => 'Tornar veire automaticament las restriccions',
	'stabilization-restrict-none' => 'Pas de restriccion suplementària',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'I a pas de pagina « [[:$1|$1]] », pas de parametratge possible',
	'stabilization-notcontent' => 'La pagina « [[:$1|$1]] » pòt pas èsser revisada, pas de parametratge possible',
	'stabilization-comment' => 'Rason :',
	'stabilization-otherreason' => 'Autra rason :',
	'stabilization-expiry' => 'Expira :',
	'stabilization-othertime' => 'Autre temps :',
	'stabilization-def-short' => 'Defaut',
	'stabilization-def-short-0' => 'Correnta',
	'stabilization-def-short-1' => 'Publicada',
	'stabilize_expiry_invalid' => "Data d'expiracion invalida.",
	'stabilize_expiry_old' => "Lo temps d'expiracion ja es passat.",
	'stabilize-expiring' => 'expira $1 (UTC)',
	'stabilization-review' => 'Tornar veire la version correnta',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'stabilization-page' => 'ପୃଷ୍ଠା ନାମ:',
	'stabilization-submit' => 'ଥୟ କରିବେ',
	'stabilization-comment' => 'କାରଣ:',
	'stabilization-otherreason' => 'ଅନ୍ୟ କାରଣ:',
	'stabilization-expiry' => 'ଅଚଳ ହେବ:',
	'stabilization-othertime' => 'ବାକି ସମୟ:',
	'stabilization-def-short' => 'ପୂର୍ବ ନିର୍ଦ୍ଧାରିତ',
	'stabilization-def-short-0' => 'ଏବେକାର',
	'stabilization-def-short-1' => 'ସ୍ଥିର',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'stabilization-page' => 'Naame vum Blatt:',
	'stabilization-comment' => 'Grund:',
	'stabilization-otherreason' => 'Annerer Grund:',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'stabilization-page' => 'Saidename:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Fizykaa
 * @author Holek
 * @author Leinad
 * @author McMonster
 * @author Saper
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'stabilization-tab' => 'Widoczne wersje strony',
	'stabilization' => 'Widoczna wersja strony',
	'stabilization-text' => "'''Ustaw poniżej, w jaki sposób ma być wybierana i wyświetlana opublikowana wersja strony [[:$1|$1]].'''",
	'stabilization-perm' => 'Nie masz wystarczających uprawnień, aby zmienić konfigurację wersji oznaczonych.
Poniżej znajdują się aktualne ustawienia dla strony [[:$1|$1]].',
	'stabilization-page' => 'Nazwa strony:',
	'stabilization-leg' => 'Zatwierdź konfigurację wersji opublikowanej',
	'stabilization-def' => 'Wersja strony wyświetlana domyślnie',
	'stabilization-def1' => 'Ostatnia wersja przejrzana, a jeśli nie istnieje, to wersja bieżąca',
	'stabilization-def2' => 'Wersja bieżąca',
	'stabilization-restrict' => 'Ograniczenia ręcznego i automatycznego oznaczania',
	'stabilization-restrict-none' => 'Brak dodatkowych ograniczeń',
	'stabilization-submit' => 'Potwierdź',
	'stabilization-notexists' => 'Brak strony zatytułowanej „[[:$1|$1]]”. Nie jest możliwa jej konfiguracja.',
	'stabilization-notcontent' => 'Strona „[[:$1|$1]]” nie może być oznaczona.
Nie jest możliwa jej konfiguracja.',
	'stabilization-comment' => 'Powód',
	'stabilization-otherreason' => 'Inny powód',
	'stabilization-expiry' => 'Upływa',
	'stabilization-othertime' => 'Inny okres',
	'stabilization-def-short' => 'Domyślna',
	'stabilization-def-short-0' => 'Bieżąca',
	'stabilization-def-short-1' => 'Opublikowana',
	'stabilize_page_invalid' => 'Nieprawidłowy tytuł wskazanej strony.',
	'stabilize_page_notexists' => 'Wskazana strona nie istnieje.',
	'stabilize_page_unreviewable' => 'Wersje oznaczone są nieaktywne w tej przestrzeni nazw.',
	'stabilize_invalid_autoreview' => 'Nieprawidłowe ograniczenia automatycznego oznaczania.',
	'stabilize_invalid_level' => 'Nieprawidłowy poziom zabezpieczeń.',
	'stabilize_expiry_invalid' => 'Nieprawidłowa data wygaśnięcia.',
	'stabilize_expiry_old' => 'Czas wygaśnięcia już upłynął.',
	'stabilize_denied' => 'Brak dostępu.',
	'stabilize-expiring' => 'wygasa $1 (UTC)',
	'stabilization-review' => 'Oznacz jako przejrzaną aktualną wersję',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'stabilization-tab' => '(c.q.)',
	'stabilization' => 'Stabilisassion dla pàgina',
	'stabilization-text' => "'''Cangé le regolassion ambelessì sota për rangé coma la version publicà ëd [[:$1|$1]] a deva esse sernùa e smonùa.'''",
	'stabilization-perm' => "Sò cont a l'ha pa ij përmess për cangé la configurassion ëd la version publicà. 
Ambelessì a-i son le regolassion corente për [[:$1|$1]]:",
	'stabilization-page' => 'Nòm dla pàgina:',
	'stabilization-leg' => "Conferma j'ampostassion ëd la version publicà",
	'stabilization-def' => 'Revision da smon-e coma pàgina sòlita për la vos',
	'stabilization-def1' => "La version stàbil; s'a-i é pa, antlora l'ùltima revision",
	'stabilization-def2' => "L'ùltima revision",
	'stabilization-restrict' => 'Restrission ëd revision/àuto-revision',
	'stabilization-restrict-none' => 'Pa gnun-e restrission extra',
	'stabilization-submit' => 'Confermé',
	'stabilization-notexists' => 'A-i é pa gnun-a pàgina ch\'as ciama "[[:$1|$1]]". As peul nen regolé lòn ch\'a-i é nen.',
	'stabilization-notcontent' => 'La pàgina "[[:$1|$1]]" as peul pa s-ciairesse. A-i é gnun-a regolassion ch\'as peula fesse.',
	'stabilization-comment' => 'Rason:',
	'stabilization-otherreason' => 'Autra rason:',
	'stabilization-expiry' => 'A finiss:',
	'stabilization-othertime' => 'Autra vira:',
	'stabilization-def-short' => 'Për sòlit',
	'stabilization-def-short-0' => 'version corenta',
	'stabilization-def-short-1' => 'Publicà',
	'stabilize_page_invalid' => "Ël tìtol ëd la pàgina pontà a l'é pa vàlid.",
	'stabilize_page_notexists' => 'La pàgina pontà a esist pa.',
	'stabilize_page_unreviewable' => "La pàgina pontà a l'é pa ant lë spassi nominal revisionàbil.",
	'stabilize_invalid_autoreview' => "restrission d'autorevision pa bon-a.",
	'stabilize_invalid_level' => 'Livel ëd protession pa bon.',
	'stabilize_expiry_invalid' => 'Data fin pa bon-a.',
	'stabilize_expiry_old' => "Sta data fin-sì a l'é già passà",
	'stabilize_denied' => 'Përmess arfudà.',
	'stabilize-expiring' => 'A finiss $1 (UTC)',
	'stabilization-review' => 'Marché la version corenta com controlà',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'stabilization-page' => 'د مخ نوم:',
	'stabilization-submit' => 'تاييد',
	'stabilization-comment' => 'سبب:',
	'stabilization-otherreason' => 'بل سبب:',
	'stabilization-expiry' => 'د پای نېټه:',
	'stabilization-othertime' => 'بل وخت:',
	'stabilization-def-short' => 'تلواليز',
	'stabilization-def-short-0' => 'اوسنی',
	'stabilization-def-short-1' => 'ثابت',
	'stabilize-expiring' => 'په $1 (UTC) پای ته رسېږي',
);

/** Portuguese (Português)
 * @author 555
 * @author Giro720
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'stabilization-tab' => 'cgq',
	'stabilization' => 'Estabilização de páginas',
	'stabilization-text' => "'''Altere os parâmetros abaixo para ajustar a forma como a versão publicada de [[:$1|$1]] é seleccionada e apresentada.'''",
	'stabilization-perm' => 'A sua conta não tem permissão para alterar a configuração da versão publicada.
Os parâmetros actuais da página [[:$1|$1]] são:',
	'stabilization-page' => 'Nome da página:',
	'stabilization-leg' => 'Confirmar os parâmetros da versão publicada',
	'stabilization-def' => 'Edição apresentada por omissão',
	'stabilization-def1' => 'A versão publicada; se inexistente, então a edição mais recente',
	'stabilization-def2' => 'A edição mais recente',
	'stabilization-restrict' => 'Restrições da revisão automática',
	'stabilization-restrict-none' => 'Nenhuma restrição extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'A página "[[:$1|$1]]" não existe.
Não é possível configurá-la.',
	'stabilization-notcontent' => 'A página "[[:$1|$1]]" não pode ser revista.
Não é possível configurá-la.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Outro motivo:',
	'stabilization-expiry' => 'Expira:',
	'stabilization-othertime' => 'Outra hora:',
	'stabilization-def-short' => 'Padrão',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Publicada',
	'stabilize_page_invalid' => 'O título da página de destino é inválido.',
	'stabilize_page_notexists' => 'A página de destino não existe.',
	'stabilize_page_unreviewable' => 'A página de destino não está num espaço nominal sujeito a revisão.',
	'stabilize_invalid_autoreview' => 'Restrição de auto-revisão é inválida',
	'stabilize_invalid_level' => 'Nível de protecção é inválido.',
	'stabilize_expiry_invalid' => 'Data de expiração inválida.',
	'stabilize_expiry_old' => 'Esta data de expiração já passou.',
	'stabilize_denied' => 'Permissão negada.',
	'stabilize-expiring' => 'expira às $1 (UTC)',
	'stabilization-review' => 'Marcar a edição actual como verificada',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'stabilization-tab' => 'cgq',
	'stabilization' => 'Configurações da Garantia de Qualidade',
	'stabilization-text' => "'''Altere os parâmetros abaixo para ajustar a forma como a versão publicada de [[:$1|$1]] é selecionada e apresentada.'''",
	'stabilization-perm' => 'A sua conta não tem permissão para alterar a configuração da versão publicada.
Os parâmetros atuais da página [[:$1|$1]] são:',
	'stabilization-page' => 'Nome da página:',
	'stabilization-leg' => 'Confirmar os parâmetros da versão publicada',
	'stabilization-def' => 'Edição exibida na visualização padrão de página',
	'stabilization-def1' => 'A edição publicada; se inexistente, então a revisão mais recente',
	'stabilization-def2' => 'A edição mais recente',
	'stabilization-restrict' => 'Restrições da revisão automática',
	'stabilization-restrict-none' => 'sem restrições extras',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'A página "[[:$1|$1]]" não existe.
Não é possível configurá-la.',
	'stabilization-notcontent' => 'A página "[[:$1|$1]]" não pode ser analisada.
Não é possível configurá-la.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Outro motivo:',
	'stabilization-expiry' => 'Expira em:',
	'stabilization-othertime' => 'Outra hora:',
	'stabilization-def-short' => 'Padrão',
	'stabilization-def-short-0' => 'Atual',
	'stabilization-def-short-1' => 'Publicada',
	'stabilize_page_invalid' => 'O título da página de destino é inválido.',
	'stabilize_page_notexists' => 'A página de destino não existe.',
	'stabilize_page_unreviewable' => 'A página de destino não está em um espaço nominal sujeito a revisão.',
	'stabilize_invalid_autoreview' => 'Restrição de autorrevisão inválida.',
	'stabilize_invalid_level' => 'Nível de proteção inválido.',
	'stabilize_expiry_invalid' => 'Data de expiração inválida.',
	'stabilize_expiry_old' => 'Este tempo de expiração já se encerrou.',
	'stabilize_denied' => 'Permissão negada.',
	'stabilize-expiring' => 'expira às $1 (UTC)',
	'stabilization-review' => 'Marcar a revisão atual como verificada',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'stabilize_denied' => 'Manam saqillasqachu.',
);

/** Romanian (Română)
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Memo18
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'stabilization-tab' => 'config.',
	'stabilization' => 'Stabilizarea paginii',
	'stabilization-perm' => 'Contul tău nu are permisiunea de a schimba versiunea stabilă a configurației.
Iată configurația curentă pentru [[:$1|$1]]:',
	'stabilization-page' => 'Numele paginii:',
	'stabilization-leg' => 'Confirmați setările versiunii stabile',
	'stabilization-def' => 'Revizie afișată pe vizualizarea paginii implicite',
	'stabilization-def1' => 'Revizia stabilă; dacă nu există, atunci cea curentă',
	'stabilization-def2' => 'Ultima versiune',
	'stabilization-restrict' => 'Restricții pentru revizualizarea automată',
	'stabilization-restrict-none' => 'Nicio restricție suplimentară',
	'stabilization-submit' => 'Confirmă',
	'stabilization-notexists' => 'Nu există nicio pagină numită „[[:$1|$1]]”.
Configurarea nu este posibilă.',
	'stabilization-notcontent' => 'Pagina „[[:$1|$1]]” nu poate fi revizuită.
Configurarea nu este posibilă.',
	'stabilization-comment' => 'Motiv:',
	'stabilization-otherreason' => 'Alte motive:',
	'stabilization-expiry' => 'Expiră:',
	'stabilization-othertime' => 'Alt timp:',
	'stabilization-def-short' => 'Implicit',
	'stabilization-def-short-0' => 'Curent',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_page_invalid' => 'Titlul paginii ţintă este invalid.',
	'stabilize_page_notexists' => 'Pagina-ţintă nu există.',
	'stabilize_invalid_level' => 'Nivel de protecție nevalid.',
	'stabilize_expiry_invalid' => 'Data expirării incorectă.',
	'stabilize_expiry_old' => 'Această dată de expirare a trecut deja.',
	'stabilize_denied' => 'Permisiune refuzată.',
	'stabilize-expiring' => 'expiră $1 (UTC)',
	'stabilization-review' => 'Marchează versiunea curentă ca verificată',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Pàgene de stabbilizzazione',
	'stabilization-text' => "'''Cange le 'mbostaziune sotte pe aggiustà cumme a 'na versiona secure de [[:$1|$1]] ca jè selezionete e visualizzate.'''",
	'stabilization-perm' => "'U cunde utende tue non ge tène le permesse pe cangià 'a configurazione d'a versione pubblecate.
Chiste sonde le configuraziune corrende pe [[:$1|$1]]:",
	'stabilization-page' => "Nome d'a pàgene:",
	'stabilization-leg' => 'Conferme le configuraziune pe le versiune pubblecate',
	'stabilization-def' => "Revisiune visualizzete sus 'a viste d'a pàgene de default",
	'stabilization-def1' => "'A revisiona secure; ce non g'è presende, allore vide jè l'urtema revisione",
	'stabilization-def2' => "L'urtema revisione",
	'stabilization-restrict' => "Restriziune sus a 'a revisitazione/l'auto revisitazione",
	'stabilization-restrict-none' => 'Nisciuna restriziona de cchiù',
	'stabilization-submit' => 'Conferme',
	'stabilization-notexists' => 'Non ge stè \'na pàgene ca se chieme "[[:$1|$1]]".
Nisciuna configurazione jè possibbele.',
	'stabilization-notcontent' => '\'A pàgene "[[$1|$1]]" non ge pò essere reviste.
Non ge stonne le configurazione.',
	'stabilization-comment' => 'Mutive:',
	'stabilization-otherreason' => 'Otre mutive:',
	'stabilization-expiry' => 'More:',
	'stabilization-othertime' => 'Otre orarije:',
	'stabilization-def-short' => 'Defolt',
	'stabilization-def-short-0' => 'Corrende',
	'stabilization-def-short-1' => 'Pubblecate',
	'stabilize_page_invalid' => "'U titele d'a pàgene de destinazzione jè invalide.",
	'stabilize_page_notexists' => "'A pàgene de destinazzione non g'esiste.",
	'stabilize_page_unreviewable' => "'A pàgene de destinazione non ge ste jndr'à 'nu namespace revisitabbele.",
	'stabilize_invalid_autoreview' => 'Restriziune de autorevisitazione invalide.',
	'stabilize_invalid_level' => 'Levèlle de protezione invalide.',
	'stabilize_expiry_invalid' => 'Date de scadenze errete.',
	'stabilize_expiry_old' => 'Sta date de scadenze ha già passete.',
	'stabilize_denied' => 'Permesse vietate.',
	'stabilize-expiring' => "scade 'u $1 (UTC)",
	'stabilization-review' => "Signe 'a revisiona corrende cumme verificate",
);

/** Russian (Русский)
 * @author AlexSm
 * @author Claymore
 * @author Drbug
 * @author Ferrer
 * @author G0rn
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'stabilization-tab' => '(кк)',
	'stabilization' => 'Стабилизация страницы',
	'stabilization-text' => "'''С помощью приведённых ниже настроек можно управлять выбором и отображением опубликованной версии страницы [[:$1|$1]].'''",
	'stabilization-perm' => 'У вашей учётной записи недостаточно полномочий для изменения настройки опубликованных версий.
Здесь приведены текущие настройки для страницы [[:$1|$1]]:',
	'stabilization-page' => 'Название страницы:',
	'stabilization-leg' => 'Подтверждение настроек опубликованной версии',
	'stabilization-def' => 'Версия, показываемая по умолчанию',
	'stabilization-def1' => 'Стабильная версия; если такой нет, то последняя версия',
	'stabilization-def2' => 'Последняя версия',
	'stabilization-restrict' => 'Ограничения проверки/самопроверки',
	'stabilization-restrict-none' => 'Нет дополнительных ограничений',
	'stabilization-submit' => 'Подтвердить',
	'stabilization-notexists' => 'Отсутствует страница с названием «[[:$1|$1]]». Настройка невозможна.',
	'stabilization-notcontent' => 'Страница «[[:$1|$1]]» не может быть проверена. Настройка невозможна.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Другая причина:',
	'stabilization-expiry' => 'Истекает:',
	'stabilization-othertime' => 'Другое время:',
	'stabilization-def-short' => 'по умолчанию',
	'stabilization-def-short-0' => 'текущая',
	'stabilization-def-short-1' => 'Опубликованная',
	'stabilize_page_invalid' => 'Целевое название страницы ошибочно.',
	'stabilize_page_notexists' => 'Целевой страницы не существует.',
	'stabilize_page_unreviewable' => 'Целевая страница не находится в проверяемом пространстве имён.',
	'stabilize_invalid_autoreview' => 'Ошибочные ограничения автопроверки',
	'stabilize_invalid_level' => 'Ошибочный уровень защиты.',
	'stabilize_expiry_invalid' => 'Ошибочная дата истечения.',
	'stabilize_expiry_old' => 'Указанное время окончания действия уже прошло.',
	'stabilize_denied' => 'Доступ запрещён.',
	'stabilize-expiring' => 'истекает $1 (UTC)',
	'stabilization-review' => 'Отметить текущую версию как проверенную',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'stabilization-tab' => '(кя)',
	'stabilization' => 'Стабілізація сторінкы',
	'stabilization-text' => "'''Змінити наставлїня долов про приспособлїня того, як ся выберать стабілна верзія сторінкы [[:$1|$1]] і як ся зобразить.'''",
	'stabilization-perm' => 'Ваше конто не мать права змінити стабілну конфіґурацію верзії.
Ту є актуалне наставлїня [[:$1|$1]]:',
	'stabilization-page' => 'Назва сторінкы:',
	'stabilization-leg' => 'Потвердити наставлїня стабілной верзії',
	'stabilization-def' => 'Ревізія зобразена як імпліцітна',
	'stabilization-def1' => 'Стабілна верзія; кідь такой нїт так послїдня верзія',
	'stabilization-def2' => 'Послїдня ревізія',
	'stabilization-restrict' => 'Обмеджіня резензованя/автоедітованя',
	'stabilization-restrict-none' => 'Без далшых обмеджінь',
	'stabilization-submit' => 'Підтвердити',
	'stabilization-notexists' => 'Не екзістує сторінка "[[:$1|$1]]". Наставлїня не є можне.',
	'stabilization-notcontent' => 'Сторінка «[[:$1|$1]]» не може быти перевірена.
Наставлїня не є можне.',
	'stabilization-comment' => 'Причіна:',
	'stabilization-otherreason' => 'Інша причіна:',
	'stabilization-expiry' => 'Кінчіть:',
	'stabilization-othertime' => 'Іншый час:',
	'stabilization-def-short' => 'Імпліцітне',
	'stabilization-def-short-0' => 'Актуална',
	'stabilization-def-short-1' => 'Публікована',
	'stabilize_page_invalid' => 'Назва цілёвой сторінкы не є платна',
	'stabilize_page_notexists' => 'Цілёвой сторінкы не є.',
	'stabilize_page_unreviewable' => 'Цілёва сторінка не є в просторї назв, котры ся можуть рецензовати.',
	'stabilize_invalid_autoreview' => 'Неправилне обмеджіня авторецензованя.',
	'stabilize_invalid_level' => 'Неправилна уровень охраны.',
	'stabilize_expiry_invalid' => 'Хыбный датум експірації.',
	'stabilize_expiry_old' => 'Час закінчіня експіровав.',
	'stabilize_denied' => 'Приступ забороненый.',
	'stabilize-expiring' => 'кінчіть $1 (UTC)',
	'stabilization-review' => 'Позначіти актуалну верзію',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'stabilization-page' => 'पृष्ठ नाम:',
	'stabilization-submit' => 'स्थिरीकरोतु',
	'stabilization-comment' => 'कारणम् :',
	'stabilization-def-short' => 'यदभावे',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'stabilization-tab' => '(хх)',
	'stabilization' => 'Сирэй стабилизацията',
	'stabilization-text' => "'''Манна баар туруоруулары уларытан [[:$1|$1]] сирэй бигэ барылын талары уонна хайдах көстүөҕүн уларытыахха сөп.'''",
	'stabilization-perm' => 'Эн аккаунуҥ бэчээттэммит барыллар туруорууларын уларытар кыаҕы биэрбэт эбит.
Манна [[:$1|$1]] туруоруулара көстөллөр:',
	'stabilization-page' => 'Сирэй аата:',
	'stabilization-leg' => 'Сирэй бигэ барылын туруорууларын бигэргэтии',
	'stabilization-def' => 'Анаан этиллибэтэҕинэ көрдөрүллэр торум',
	'stabilization-def1' => 'Бигэ барыл; ол суох буоллаҕына - бүтэһик барыл',
	'stabilization-def2' => 'Бүтэһик барыл',
	'stabilization-restrict' => 'Тургутуу/бэйэни тургутуу хааччахтара',
	'stabilization-restrict-none' => 'Эбии хааччах суох',
	'stabilization-submit' => 'Бигэргэтии',
	'stabilization-notexists' => 'Маннык ааттаах сирэй «[[:$1|$1]]» суох. Онон уларытар кыах суох.',
	'stabilization-notcontent' => '«[[:$1|$1]]» сирэй ырытыллыбат. Онон туруорууларын уларытар сатаммат.',
	'stabilization-comment' => 'Төрүөтэ:',
	'stabilization-otherreason' => 'Атын төрүөт:',
	'stabilization-expiry' => 'Болдьоҕо бүтэр:',
	'stabilization-othertime' => 'Атын кэм:',
	'stabilization-def-short' => 'Анал туруоруута суох',
	'stabilization-def-short-0' => 'Бүтэһик',
	'stabilization-def-short-1' => 'Бигэ',
	'stabilize_page_invalid' => 'Сорук-сирэй аата сыыһалаах.',
	'stabilize_page_notexists' => 'Сорук-сирэй суох эбит.',
	'stabilize_page_unreviewable' => 'Сорук-сирэй тургутуллар аат далын таһыгар эбит.',
	'stabilize_invalid_autoreview' => 'Аптамаатынан тургутуу алҕастаах хааччахтара',
	'stabilize_expiry_invalid' => 'Болдьох сыыһа туруорулунна.',
	'stabilize_expiry_old' => 'Болдьох этиллибит кэмэ номнуо ааспыт.',
	'stabilize-expiring' => 'Болдьоҕо бүтэр: $1 (UTC)',
	'stabilization-review' => 'Билиҥни барылын көрүү',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'stabilization-page' => 'Nùmene pàgina:',
	'stabilization-submit' => 'Cunfirma',
	'stabilization-comment' => 'Motivu:',
	'stabilization-otherreason' => 'Àteru motivu:',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'stabilization-page' => 'Nnomu dâ pàggina:',
	'stabilization-comment' => 'Mutivu:',
	'stabilization-otherreason' => 'Àutru mutivu:',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'stabilization' => 'පිටුවේ ස්ථාවරත්වය',
	'stabilization-page' => 'පිටු නාමය:',
	'stabilization-def2' => 'අවසාන සංශෝධනය',
	'stabilization-restrict-none' => 'අමතර සීමා නොමැත',
	'stabilization-submit' => 'තහවුරු කරන්න',
	'stabilization-comment' => 'හේතුව:',
	'stabilization-otherreason' => 'වෙනත් හේතු:',
	'stabilization-expiry' => 'කල් ඉකුත් වන්නේ:',
	'stabilization-othertime' => 'අනෙකුත් වේලාව:',
	'stabilization-def-short' => 'පෙරනිමි',
	'stabilization-def-short-0' => 'වත්මන්',
	'stabilization-def-short-1' => 'ස්ථාවර',
	'stabilize_page_invalid' => 'ඉලක්කගත පිටුවේ මාතෘකාව අනීතිකයි.',
	'stabilize_page_notexists' => 'ඉලක්කගත පිටුව නොපවතියි.',
	'stabilize_page_unreviewable' => 'ඉලක්කගත පිටුව ඇත්තේ නිරික්ෂණමය නාමඅවකාශයක නොවේ.',
	'stabilize_invalid_autoreview' => 'වලංගු නොවන ස්වයංනිරීක්ෂණ සීමාව.',
	'stabilize_invalid_level' => 'වලංගු නොවන ආරක්ෂණ මට්ටම.',
	'stabilize_expiry_invalid' => 'වලංගු නොවන කල් ඉකුත් වීමේ දිනය.',
	'stabilize_denied' => 'අවසරය ලබා නොදේ.',
	'stabilize-expiring' => 'ඉකුත් වේ  $1 (යූටීසි)',
	'stabilization-review' => 'වත්මන් සංශෝධනය සලකුණු කළා යයි සලකුණු කරන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'stabilization-tab' => '(kk)',
	'stabilization' => 'Stabilizácia stránky',
	'stabilization-text' => "'''|Tieto voľby menia spôsob výberu a zobrazenia stabilnej verzie stránky [[:$1|$1]].'''",
	'stabilization-perm' => 'Váš účet nemá oprávnenie meniť nastavenia stabilnej verzie. Tu sú súčasné nastavenia [[:$1|$1]]:',
	'stabilization-page' => 'Názov stránky:',
	'stabilization-leg' => 'Potvrdiť nastavenia stabilnej verzie',
	'stabilization-def' => 'Revízia, ktorá sa zobrazí pri štandardnom zobrazení stránky',
	'stabilization-def1' => 'Stabilná revízia; ak nie je prítomná, je to aktuálna/návrh',
	'stabilization-def2' => 'Aktuálna revízia/návrh',
	'stabilization-restrict' => 'Obmedzenia automatického overenia',
	'stabilization-restrict-none' => 'Žiadne ďalšie obmedzenia',
	'stabilization-submit' => 'Potvrdiť',
	'stabilization-notexists' => 'Neexistuje stránka s názvom „[[:$1|$1]]“. Konfigurácia nie je možná.',
	'stabilization-notcontent' => 'Stránku „[[:$1|$1]]“ nie je možné skontrolovať. Konfigurácia nie je možná.',
	'stabilization-comment' => 'Dôvod:',
	'stabilization-otherreason' => 'Iný dôvod:',
	'stabilization-expiry' => 'Vyprší:',
	'stabilization-othertime' => 'Iný čas:',
	'stabilization-def-short' => 'štandard',
	'stabilization-def-short-0' => 'aktuálna',
	'stabilization-def-short-1' => 'stabilná',
	'stabilize_page_invalid' => 'Názov cieľovej stránky nie je platný.',
	'stabilize_page_notexists' => 'Cieľová stránka neexistuje.',
	'stabilize_page_unreviewable' => 'Cieľová stránka nie je v mennom priestore, v ktorom možno kontrolovať.',
	'stabilize_invalid_autoreview' => 'Neplatné obmedzenie automatickej kontroly.',
	'stabilize_invalid_level' => 'Neplatná úroveň ochrany.',
	'stabilize_expiry_invalid' => 'Neplatný dátum vypršania.',
	'stabilize_expiry_old' => 'Čas vypršania už prešiel.',
	'stabilize_denied' => 'Nedostatočné oprávnenie.',
	'stabilize-expiring' => 'vyprší $1 (UTC)',
	'stabilization-review' => 'Označiť aktuálnu revíziu ako skontrolovanú',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'stabilization-tab' => 'redakcije',
	'stabilization' => 'Ustaljevanje strani',
	'stabilization-text' => "'''Spremenite spodnje nastavitve, da prilagodite, kako je ustaljena različica [[:$1|$1]] izbrana in prikazana.'''",
	'stabilization-perm' => 'Vaš račun nima dovoljenja za spreminjanje nastavitev stabilne različice.
Tukaj so trenutne nastavitve [[:$1|$1]]:',
	'stabilization-page' => 'Naslov strani:',
	'stabilization-leg' => 'Potrdi nastavitve ustaljene različice',
	'stabilization-def' => 'Redakcija prikazana na privzetem pogledu strani',
	'stabilization-def1' => 'Ustaljena različica; če ni prisotna, potem zadnja različica',
	'stabilization-def2' => 'Zadnja redakcija',
	'stabilization-restrict' => 'Omejitve pregledov/samodejnih pregledov',
	'stabilization-restrict-none' => 'Brez dodatnih omejitev',
	'stabilization-submit' => 'Potrdi',
	'stabilization-notexists' => 'Stran »[[:$1|$1]]« ne obstaja.
Nastavitev ni mogoča.',
	'stabilization-notcontent' => 'Strani »[[:$1|$1]]« ni mogoče pregledati.
Nastavitev ni mogoča.',
	'stabilization-comment' => 'Razlog:',
	'stabilization-otherreason' => 'Drug razlog:',
	'stabilization-expiry' => 'Poteče:',
	'stabilization-othertime' => 'Drugačen čas:',
	'stabilization-def-short' => 'Privzeto',
	'stabilization-def-short-0' => 'Trenutno',
	'stabilization-def-short-1' => 'Stabilno',
	'stabilize_page_invalid' => 'Naslov ciljne strani ni veljaven.',
	'stabilize_page_notexists' => 'Ciljna stran ne obstaja.',
	'stabilize_page_unreviewable' => 'Ciljna stran ni v imenskem prostoru, ki omogoča preglede.',
	'stabilize_invalid_autoreview' => 'Neveljavna omejitev samodejnih pregledov.',
	'stabilize_invalid_level' => 'Neveljavna raven zaščite.',
	'stabilize_expiry_invalid' => 'Neveljaven datum poteka.',
	'stabilize_expiry_old' => 'Ta čas poteka je že minil.',
	'stabilize_denied' => 'Dovoljenje je zavrnjeno.',
	'stabilize-expiring' => 'poteče $1 (UTC)',
	'stabilization-review' => 'Označi trenutno redakcijo kot pregledano',
);

/** Albanian (Shqip)
 * @author Puntori
 */
$messages['sq'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Stabilizimi i faqes',
	'stabilization-page' => 'Emri i faqes:',
	'stabilization-def2' => 'Versioni i tanishëm',
	'stabilization-submit' => 'Konfirmo',
	'stabilization-notexists' => 'Nuk ka faqe me emrin "[[:$1|$1]]".
Asnjë konfigurim nuk është i mundshëm.',
	'stabilization-notcontent' => 'Faqja "[[:$1|$1]]" nuk mund të rishqyrtohet.
Asnjë konfigurim nuk është i mundshëm.',
	'stabilization-comment' => 'Arsyeja:',
	'stabilization-expiry' => 'Skadon:',
	'stabilization-def-short-0' => 'Tani',
	'stabilize_expiry_invalid' => 'Datë jo vlefshme e skadimit.',
	'stabilize_expiry_old' => 'Koha e skadimit tanimë ka kaluar.',
	'stabilize-expiring' => 'skadon $1 (UTC)',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'stabilization-tab' => 'конфиг.',
	'stabilization' => 'Стабилизација странице',
	'stabilization-text' => "'''Промените поставке испод да бисте подесили како се изабира и приказује објављено издање странице [[:$1|$1]].'''",
	'stabilization-perm' => 'Ваш налог нема дозволу за измену подешавања за стабилне верзије.
Овде су тренутна подешавања за [[:$1|$1]]:',
	'stabilization-page' => 'Назив странице:',
	'stabilization-leg' => 'Потврди подешавања за стабилне верзије',
	'stabilization-def' => 'Верзија приказана на подразумеваном приказу стране.',
	'stabilization-def1' => 'Стабилно издање; ако не постоји, онда последња измена',
	'stabilization-def2' => 'Последња измена',
	'stabilization-restrict' => 'Ограничења за прегледање и аутоматско прегледање',
	'stabilization-restrict-none' => 'Без додатних ограничења',
	'stabilization-submit' => 'Прихвати',
	'stabilization-notexists' => 'Нема странице под називом „[[:$1|$1]]“.
Подешавање није могуће.',
	'stabilization-notcontent' => 'Страница „[[:$1|$1]]“ не може бити прегледана. Подешавање није могуће.',
	'stabilization-comment' => 'Разлог:',
	'stabilization-otherreason' => 'Други разлог:',
	'stabilization-expiry' => 'Истиче:',
	'stabilization-othertime' => 'Друго време:',
	'stabilization-def-short' => 'Подразумевано',
	'stabilization-def-short-0' => 'Тренутно',
	'stabilization-def-short-1' => 'Стабилно',
	'stabilize_page_invalid' => 'Наслов циљане стране је неисправан.',
	'stabilize_page_notexists' => 'Циљана страна не постоји.',
	'stabilize_page_unreviewable' => 'Циљана страна се не налази у прегледивом именском простору.',
	'stabilize_invalid_level' => 'Неисправан ниво заштите.',
	'stabilize_expiry_invalid' => 'Лош датум истицања.',
	'stabilize_expiry_old' => 'Време истицања је већ прошло.',
	'stabilize_denied' => 'Приступ је одбијен.',
	'stabilize-expiring' => 'истиче $1 (UTC)',
	'stabilization-review' => 'Означи тренутну ревизику као прегледану',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'stabilization-tab' => 'veteran',
	'stabilization' => 'Stabilizacija strane',
	'stabilization-text' => "'''Promenite postavke ispod da biste podesili kako se izabira i prikazuje objavljeno izdanje stranice [[:$1|$1]].'''",
	'stabilization-perm' => 'Vaš nalog nema dozvolu za izmenu podešavanja za stabilne verzije.
Ovde su trenutna podešavanja za [[:$1|$1]]:',
	'stabilization-page' => 'Ime stranice:',
	'stabilization-leg' => 'Potvrdi podešavanja za stabilne verzije',
	'stabilization-def' => 'Verzija prikazana na podrazumevanom prikazu strane.',
	'stabilization-def1' => 'Stabilno izdanje; ako ne postoji, onda poslednja izmena',
	'stabilization-def2' => 'Poslednja revizija',
	'stabilization-restrict' => 'Ograničenja za pregledanje i automatsko pregledanje',
	'stabilization-restrict-none' => 'Bez dodatnih ograničenja',
	'stabilization-submit' => 'Prihvati',
	'stabilization-notexists' => 'Ne postoji stranica pod imenom „[[:$1|$1]]“. Podešavanje nije moguće.',
	'stabilization-notcontent' => 'Stranica „[[:$1|$1]]“ ne može biti pregledana. Podešavanje nije moguće.',
	'stabilization-comment' => 'Razlog:',
	'stabilization-otherreason' => 'Drugi razlog:',
	'stabilization-expiry' => 'Ističe:',
	'stabilization-othertime' => 'Drugo vreme:',
	'stabilization-def-short' => 'Osnovno',
	'stabilization-def-short-0' => 'Trenutno',
	'stabilization-def-short-1' => 'Prihvaćeno',
	'stabilize_page_invalid' => 'Naslov ciljane strane je neispravan.',
	'stabilize_page_notexists' => 'Ciljana strana ne postoji.',
	'stabilize_page_unreviewable' => 'Ciljana strana se ne nalazi u pregledivom imenskom prostoru.',
	'stabilize_invalid_level' => 'Neispravan nivo zaštite.',
	'stabilize_expiry_invalid' => 'Loš datum isticanja.',
	'stabilize_expiry_old' => 'Vreme isticanja je već prošlo.',
	'stabilize_denied' => 'Pristup odbijen.',
	'stabilize-expiring' => 'ističe $1 (UTC)',
	'stabilization-review' => 'Označi trenutnu reviziku kao pregledanu',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'Sieden-Stabilität',
	'stabilization-text' => "'''Annerje do Ienstaalengen uum fäästtoulääsen, wo ju stoabile Version fon „[[:$1|$1]]“ uutwääld un anwiesd wäide schäl.'''",
	'stabilization-perm' => 'Du hääst nit ju ärfoarderelke Begjuchtigenge, uum do Ienstaalengen fon ju stoabile Version tou annerjen. Do aktuelle Begjuchtigengen foar „[[:$1|$1]]“ sunt:',
	'stabilization-page' => 'Siedennoome:',
	'stabilization-leg' => 'Ienstaalengen fon ju markierde Version foar ne Siede',
	'stabilization-def' => 'Anwiesde Version in ju normoale Siedenansicht',
	'stabilization-def1' => 'Ju stoabile Version; wan neen deer is, dan ju aktuelle Version.',
	'stabilization-def2' => 'Ju aktuellste Version',
	'stabilization-submit' => 'Bestäätigje',
	'stabilization-notexists' => 'Dät rakt neen Siede „[[:$1|$1]]“. Neen Ienstaalengen muugelk.',
	'stabilization-notcontent' => 'Ju Siede "[[:$1|$1]]" kon nit wröiged wäide. Konfiguration nit muugelk.',
	'stabilization-comment' => 'Gruund:',
	'stabilization-expiry' => 'Gultich bit:',
	'stabilization-def-short' => 'Standoard',
	'stabilization-def-short-0' => 'Aktuell',
	'stabilization-def-short-1' => 'Stoabil',
	'stabilize_expiry_invalid' => 'Uungultich Ouloopdoatum.',
	'stabilize_expiry_old' => 'Dät Ouloopdoatum is al foarbie.',
	'stabilize-expiring' => 'lapt ou $1 (UTC)',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'stabilization' => 'Stabilisasi halaman',
	'stabilization-text' => "''Robah seting katut pikeun mengatur vérsi stabil ti [[:$1|$1]] geus dipilih sarta ditémbongkeun.'''",
	'stabilization-perm' => 'Rekening anjeun teu boga kawenangan pikeun ngarobah konfigurasi vérsi stabil.
Setélan kiwari pikeun [[:$1|$1]] nyaéta:',
	'stabilization-page' => 'Ngaran kaca:',
	'stabilization-def1' => 'Vérsi stabil;
mun euweuh, paké vérsi kiwari',
	'stabilization-def2' => 'Révisi kiwari',
	'stabilization-submit' => 'Konfirmasi',
	'stabilization-notexists' => 'Euweuh kaca nu ngaranna “[[:$1|$1]]”.
KOnfigurasi teu bisa dilarapkeun.',
	'stabilization-comment' => 'Alesan:',
	'stabilization-expiry' => 'Kadaluwarsa:',
	'stabilization-def-short' => 'Buhun',
	'stabilization-def-short-0' => 'Kiwari',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Titimangsa kadaluwarsana salah.',
	'stabilize_expiry_old' => 'Titimangsa kadaluwarsa geus kaliwat.',
	'stabilize-expiring' => 'kadaluwarsa $1 (UTC)',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Dafer45
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'stabilization-tab' => 'kvalitet',
	'stabilization' => 'Sidstabilisering',
	'stabilization-text' => "'''Ändra inställningarna nedan för att bestämma hur den publicerade versionen av [[:$1|$1]] väljs och visas.'''",
	'stabilization-perm' => 'Ditt konto har inte behörighet att ändra inställningen för publicerade sidversioner.
Här visas de nuvarande inställningarna för [[:$1|$1]]:',
	'stabilization-page' => 'Sidnamn:',
	'stabilization-leg' => 'Bekräfta inställningar för publicerade versioner',
	'stabilization-def' => 'Sidversion som används som standard när sidan visas',
	'stabilization-def1' => 'Den stabila versionen; om sådan saknas, den senaste versionen',
	'stabilization-def2' => 'Den senaste sidversionen',
	'stabilization-restrict' => 'Begränsningar av granskning/automatgranskning',
	'stabilization-restrict-none' => 'Inga extra begränsningar',
	'stabilization-submit' => 'Bekräfta',
	'stabilization-notexists' => 'Det finns ingen sida med titeln "[[:$1|$1]]". Inga inställningar kan göras.',
	'stabilization-notcontent' => 'Sidan "[[:$1|$1]]" kan inte granskas. Inga inställningar kan göras.',
	'stabilization-comment' => 'Anledning:',
	'stabilization-otherreason' => 'Annan anledning:',
	'stabilization-expiry' => 'Varaktighet:',
	'stabilization-othertime' => 'Annan tid:',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Senaste',
	'stabilization-def-short-1' => 'Publicerad',
	'stabilize_page_invalid' => 'Målsidans titel är ogiltig.',
	'stabilize_page_notexists' => 'Målsidan finns ej.',
	'stabilize_page_unreviewable' => 'Målsidan är inte i granskningsbar namnrymd.',
	'stabilize_invalid_autoreview' => 'Ogiltig automatgranskningsbegränsning.',
	'stabilize_invalid_level' => 'Ogiltig skyddsnivå.',
	'stabilize_expiry_invalid' => 'Ogiltig varaktighet.',
	'stabilize_expiry_old' => 'Varaktigheten har redan löpt ut.',
	'stabilize_denied' => 'Tillgång nekad.',
	'stabilize-expiring' => 'upphör den $1 (UTC)',
	'stabilization-review' => 'Markera den nuvarande revisionen som kontrollerad',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'stabilization-submit' => 'Yakinisha',
	'stabilization-comment' => 'Sababu:',
	'stabilization-otherreason' => 'Sababu nyingine:',
	'stabilization-expiry' => 'Itakwisha:',
	'stabilization-othertime' => 'Kipindi kingine:',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'stabilization-expiry' => 'Wygaso:',
	'stabilization-def-short' => 'Důmyślna',
);

/** Tamil (தமிழ்)
 * @author Kanags
 * @author TRYPPN
 * @author Ulmo
 * @author செல்வா
 */
$messages['ta'] = array(
	'stabilization-page' => 'பக்கப் பெயர்:',
	'stabilization-def2' => 'அண்மைய திருத்தங்கள்',
	'stabilization-restrict-none' => 'மேலும் அதிகப்படியான தடைகள் இல்லை',
	'stabilization-submit' => 'உறுதிப்படுத்து',
	'stabilization-comment' => 'காரணம்:',
	'stabilization-otherreason' => 'வேறு காரணம்:',
	'stabilization-expiry' => 'முடிவுறுகிறது:',
	'stabilization-othertime' => 'வேறு நேரம்:',
	'stabilization-def-short' => 'பொதுவானது',
	'stabilization-def-short-0' => 'நடப்பு',
	'stabilization-def-short-1' => 'ஏற்றுக்கொள்ளப்பட்டது',
	'stabilize_denied' => 'செய்யுரிமை மறுக்கப்பட்டது.',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'పేజీ స్ధిరీకరణ',
	'stabilization-text' => "'''[[:$1|$1]] యొక్క సుస్థిర కూర్పు ఎలా ఎంచుకోవాలి మరియు చూపించబడాలో సరిదిద్దడానికి క్రింది అమరికలు మార్చండి.'''",
	'stabilization-perm' => 'మీ ఖాతాకు సుస్థిర కూర్పును మార్చే అనుమతి లేదు. [[:$1|$1]]కి ప్రస్తుత అమరికల ఇవీ:',
	'stabilization-page' => 'పేజీ పేరు:',
	'stabilization-leg' => 'పేజీకి సుస్థిర కూర్పు సెట్టి౦గులని నిర్ధేశించండి',
	'stabilization-def' => 'డిఫాల్టు పేజీ వ్యూలో చూపించే కూర్పు',
	'stabilization-def1' => 'సుస్థిర కూర్పు; అది లేకపోతే, ప్రస్తుత కూర్పు',
	'stabilization-def2' => 'ప్రస్తుత కూర్పు',
	'stabilization-restrict-none' => 'మరిన్ని నిరోధాలు లేవు',
	'stabilization-submit' => 'నిర్ధారించు',
	'stabilization-notexists' => '"[[:$1|$1]]" అనే పేజీ లేదు. స్వరూపణం వీలుపడదు.',
	'stabilization-notcontent' => '"[[:$1|$1]]" అన్న పేజీని సమీక్షించ లేదు. ఎటువంటి స్వరూపణం వీలు కాదు.',
	'stabilization-comment' => 'కారణం:',
	'stabilization-otherreason' => 'ఇతర కారణం:',
	'stabilization-expiry' => 'కాలంచెల్లు తేదీ:',
	'stabilization-othertime' => 'ఇతర సమయం:',
	'stabilization-def-short' => 'అప్రమేయం',
	'stabilization-def-short-0' => 'ప్రస్తుత',
	'stabilization-def-short-1' => 'ప్రచురితం',
	'stabilize_expiry_invalid' => 'తప్పుడు కాలపరిమితి తేదీ.',
	'stabilize_expiry_old' => 'ఈ కాలం ఎప్పుడో చెల్లిపోయింది.',
	'stabilize_denied' => 'అనుమతిని నిరాకరించారు.',
	'stabilize-expiring' => '$1 (UTC) నాడు కాలం చెల్లుతుంది',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'stabilization-page' => 'Naran pájina nian:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'stabilization-tab' => 'санҷиш',
	'stabilization' => 'Пойдорсозии саҳифаҳо',
	'stabilization-text' => "'''Тағйири танзимоти зерин ба манзури таъйини ин, ки нусхаи пойдор аз [[:$1|$1]] чигуна интихоб ва намоиш дода мешавад.'''",
	'stabilization-perm' => 'Ҳисоби шумо иҷозати тағйири танзими нусхаи пойдорро надорад. Танзимоти феълӣ барои [[:$1|$1]]  чунинанд:',
	'stabilization-page' => 'Номи саҳифа:',
	'stabilization-leg' => 'Тасдиқи танзими нусхаи пойдор',
	'stabilization-def' => 'Нусхае ки дар ҳолати пешфарз намоиш дода мешавад',
	'stabilization-def1' => 'Нусхаи пойдор; агар он вуҷуд надошта бошад, пас он нусхаи феълӣ аст',
	'stabilization-def2' => 'Нусхаи феълӣ',
	'stabilization-submit' => 'Тасдиқ',
	'stabilization-notexists' => 'Саҳифае бо унвони "[[:$1|$1]]" вуҷуд надорад. Танзимот мумкин нест.',
	'stabilization-notcontent' => 'Саҳифаи "[[:$1|$1]]" қобили баррасӣ нест. Танзимот мумкин нест.',
	'stabilization-comment' => 'Сабаб:',
	'stabilization-expiry' => 'Интиҳо:',
	'stabilization-def-short' => 'Пешфарз',
	'stabilization-def-short-0' => 'Феълӣ',
	'stabilization-def-short-1' => 'Пойдор',
	'stabilize_expiry_invalid' => 'Таърихи интиҳоии ғайримиҷоз.',
	'stabilize_expiry_old' => 'Таърихи интиҳо аллакай сипарӣ шудааст.',
	'stabilize-expiring' => 'Дар $1 (UTC) ба интиҳо мерасад',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'stabilization-tab' => 'sançiş',
	'stabilization' => 'Pojdorsoziji sahifaho',
	'stabilization-perm' => "Hisobi şumo içozati taƣjiri tanzimi nusxai pojdorro nadorad. Tanzimoti fe'lī baroi [[:$1|$1]]  cuninand:",
	'stabilization-page' => 'Nomi sahifa:',
	'stabilization-leg' => 'Tasdiqi tanzimi nusxai pojdor',
	'stabilization-def' => 'Nusxae ki dar holati peşfarz namoiş doda meşavad',
	'stabilization-submit' => 'Tasdiq',
	'stabilization-notexists' => 'Sahifae bo unvoni "[[:$1|$1]]" vuçud nadorad. Tanzimot mumkin nest.',
	'stabilization-notcontent' => 'Sahifai "[[:$1|$1]]" qobili barrasī nest. Tanzimot mumkin nest.',
	'stabilization-comment' => 'Sabab:',
	'stabilization-expiry' => 'Intiho:',
	'stabilization-def-short' => 'Peşfarz',
	'stabilization-def-short-0' => "Fe'lī",
	'stabilization-def-short-1' => 'Pojdor',
	'stabilize_expiry_invalid' => "Ta'rixi intihoiji ƣajrimiçoz.",
	'stabilize_expiry_old' => "Ta'rixi intiho allakaj siparī şudaast.",
	'stabilize-expiring' => 'Dar $1 (UTC) ba intiho merasad',
);

/** Thai (ไทย)
 * @author Horus
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'stabilization-page' => 'ชื่อหน้า:',
	'stabilization-submit' => 'ยืนยัน',
	'stabilization-comment' => 'เหตุผล:',
	'stabilization-def-short-0' => 'ปัจจุบัน',
	'stabilization-def-short-1' => 'เสถียร',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Sahypa durnuklaşdyrma',
	'stabilization-text' => "'''[[:$1|$1]] üçin durnukly wersiýanyň nähili saýlanmalydygyny we görkezilmelidigini sazlamak üçin sazlamalry üýtgediň.'''",
	'stabilization-perm' => 'Hasabyňyzyň durnukly wersiýa konfigurasiýasyny üýtgetmäge rugsady ýok. 
[[:$1|$1]] üçin häzirki sazlamalar:',
	'stabilization-page' => 'Sahypa ady:',
	'stabilization-leg' => 'Durnukly wersiýa sazlamalaryny tassykla',
	'stabilization-def' => 'Gaýybana sahypa görkezişinde görkezilýän wersiýa',
	'stabilization-def1' => 'Durnukly wersiýa; eger ýok bolsa, onda häzirki wersiýa/garalama',
	'stabilization-def2' => 'Häzirki/garalama wersiýa',
	'stabilization-restrict' => 'Awto gözden geçirme çäklendirmeleri',
	'stabilization-restrict-none' => 'Başga goşmaça çäklendirme ýok',
	'stabilization-submit' => 'Tassykla',
	'stabilization-notexists' => '"[[:$1|$1]]" atlandyrylýan sahypa ýok.
Konfigurasiýa mümkin däl.',
	'stabilization-notcontent' => '"[[:$1|$1]]" sahypasyny gözden geçirip bolmaýar.
Konfigurirlemek mümkin däl.',
	'stabilization-comment' => 'Sebäp:',
	'stabilization-otherreason' => 'Başga sebäp:',
	'stabilization-expiry' => 'Gutarýan wagty:',
	'stabilization-othertime' => 'Başga wagt:',
	'stabilization-def-short' => 'Gaýybana',
	'stabilization-def-short-0' => 'Häzirki',
	'stabilization-def-short-1' => 'Durnukly',
	'stabilize_page_invalid' => 'Niýetlenilýän sahypa ady nädogry.',
	'stabilize_page_notexists' => 'Niýetlenilýän sahypa ýok.',
	'stabilize_invalid_level' => 'Nädogry gorag derejesi.',
	'stabilize_expiry_invalid' => 'Nädogry gutaryş senesi.',
	'stabilize_expiry_old' => 'Gutaryş möhleti eýýäm geçipdir.',
	'stabilize_denied' => 'Rugsat ret edildi.',
	'stabilize-expiring' => 'gutarýar $1 (UTC)',
	'stabilization-review' => 'Häzirki wersiýany gözden geçir',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'stabilization-tab' => 'suriing mabuti (masinsinan)',
	'stabilization' => 'Pagpapatatag ng pahina',
	'stabilization-text' => "'''Baguhin ang mga pagtatakdang nasa ibaba upang mabago ang kung paano napili at napalitaw ang tanggap na bersyon ng [[:$1|$1]].'''",
	'stabilization-perm' => 'Walang pahintulon ang akawnt mo na magbago ng ayos ng tanggap na bersyon.
Narito ang pangkasalukuyang mga katakdaan para sa [[:$1|$1]]:',
	'stabilization-page' => 'Pangalan ng pahina:',
	'stabilization-leg' => 'Tiyakin ang mga pagtatakda para sa tanggap na bersyon',
	'stabilization-def' => 'Ang pagbabagong ipinakita sa natatanaw na likas na nakatakdang pahina',
	'stabilization-def1' => 'Ang matatag na bersyon; kapag wala, ang pinakahuling pagbabago',
	'stabilization-def2' => 'Ang pinakahuling pagbabago',
	'stabilization-restrict' => 'Mga hangganan ng pagsusuri/kusang pagsusuri',
	'stabilization-restrict-none' => 'Walang karagdagang mga hangganan',
	'stabilization-submit' => 'Tiyakin',
	'stabilization-notexists' => 'Walang pahinang tinatawag na "[[:$1|$1]]".
Walang maaaring maging pagkakaayos (konpigurasyon).',
	'stabilization-notcontent' => 'Hindi masusuri ang "[[:$1|$1]]".
Walang maaaring maging pagkakaayos (konpigurasyon).',
	'stabilization-comment' => 'Dahilan:',
	'stabilization-otherreason' => 'Ibang dahilan:',
	'stabilization-expiry' => 'Magtatapos sa:',
	'stabilization-othertime' => 'Ibang oras:',
	'stabilization-def-short' => 'Likas na nakatakda',
	'stabilization-def-short-0' => 'Pangkasalukuyan',
	'stabilization-def-short-1' => 'Nalathala na',
	'stabilize_page_invalid' => 'Hindi tanggap ang puntiryang pahina ng pamagat.',
	'stabilize_page_notexists' => 'Hindi umiiral ang puntiryang pahina.',
	'stabilize_page_unreviewable' => 'Wala ang pinupukol na pahina sa loob masusuring pangalan ng puwang.',
	'stabilize_invalid_autoreview' => 'Hindi tanggap na pagbabawal ng kusang pagsuri.',
	'stabilize_invalid_level' => 'Hindi tanggap na antas ng panananggalang.',
	'stabilize_expiry_invalid' => 'Hindi tanggap na petsa ng pagtatapos.',
	'stabilize_expiry_old' => 'Lagpas na ang oras/panahon ng pagtatapos na ito.',
	'stabilize_denied' => 'Ipinagkait ang pahintulot.',
	'stabilize-expiring' => 'magtatapos sa $1 (UTC)',
	'stabilization-review' => 'Markahan ang kasalukuyang rebisyon bilang nasuri na',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 * @author Manco Capac
 * @author Srhat
 */
$messages['tr'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Sayfa kararlılaştırılması',
	'stabilization-text' => "'''[[:$1|$1]] için kararlı sürümün nasıl seçilip görüntüleneceğini ayarlamak için ayarları değiştirin.'''",
	'stabilization-perm' => 'Hesabınızın kararlı sürüm yapılandırmasını değiştirmeye izni yok.
[[:$1|$1]] için şuanki ayarlar:',
	'stabilization-page' => 'Sayfa adı:',
	'stabilization-leg' => 'Kararlı sürüm ayarlarını onayla',
	'stabilization-def' => 'Varsayılan sayfa görünümünde gösterilen revizyon',
	'stabilization-def1' => 'Kararlı sürümü; eğer yoksa, halihazırdaki son sürümü',
	'stabilization-def2' => 'Son sürüm',
	'stabilization-restrict' => 'İnceleme/oto-inceleme kısıtlamaları',
	'stabilization-restrict-none' => 'Başka ilave kısıtlama yok',
	'stabilization-submit' => 'Tespit et',
	'stabilization-notexists' => '"[[:$1|$1]]" adında bir sayfa yok.
Yapılandırma mümkün değil.',
	'stabilization-notcontent' => '"[[:$1|$1]]" sayfası gözden geçirilemiyor.
Yapılandırma mümkün değil.',
	'stabilization-comment' => 'Sebep:',
	'stabilization-otherreason' => 'Diğer sebep:',
	'stabilization-expiry' => 'Süresi bitiyor:',
	'stabilization-othertime' => 'Diğer zaman:',
	'stabilization-def-short' => 'Varsayılan',
	'stabilization-def-short-0' => 'Şu anki',
	'stabilization-def-short-1' => 'Kararlı',
	'stabilize_page_invalid' => 'Hedef sayfa başlığı geçersiz.',
	'stabilize_page_notexists' => 'Hedef sayfa mevcut değil.',
	'stabilize_page_unreviewable' => 'Hedef sayfa incelenebilir ad boşluğunda değil.',
	'stabilize_invalid_autoreview' => 'Geçersiz oto-inceleme kısıtlaması',
	'stabilize_invalid_level' => 'Geçersiz koruma seviyesi.',
	'stabilize_expiry_invalid' => 'Geçersiz sona erme tarihi.',
	'stabilize_expiry_old' => 'Sona erme tarihi zaten geçmiş.',
	'stabilize_denied' => 'İzin verilmedi.',
	'stabilize-expiring' => '$1 (UTC) tarihinde sona eriyor',
	'stabilization-review' => 'Geçerli sürümü kontrol edilmiş olarak işaretle',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ерней
 */
$messages['tt-cyrl'] = array(
	'stabilization-def-short' => 'Килешү буенча',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'stabilization-tab' => '(кя)',
	'stabilization' => 'Стабілізація сторінки',
	'stabilization-text' => "'''Змініть наведені нижче налаштування, щоб упорядкувати вибір і відображення опублікованої версії [[:$1|$1]].'''",
	'stabilization-perm' => 'Вашому обліковому запису не вистачає прав для зміни налаштувань опублікованої версії.
Тут наведені поточні налаштування для [[:$1|$1]]:',
	'stabilization-page' => 'Назва сторінки:',
	'stabilization-leg' => 'Підтвердження налаштувань опублікованої версії',
	'stabilization-def' => 'Версія, що показується за умовчанням',
	'stabilization-def1' => 'Стабільна версія; якщо такої нема, то остання версія',
	'stabilization-def2' => 'Остання версія',
	'stabilization-restrict' => 'Обмеження рецензування/авторецензування',
	'stabilization-restrict-none' => 'Без додаткових обмежень',
	'stabilization-submit' => 'Підтвердити',
	'stabilization-notexists' => 'Відсутня сторінка з назвою «[[:$1|$1]]».
Налаштування неможливе.',
	'stabilization-notcontent' => 'Сторінка «[[:$1|$1]]» не може бути перевірена.
Налаштування неможливе.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Інша причина:',
	'stabilization-expiry' => 'Закінчується:',
	'stabilization-othertime' => 'Інший час:',
	'stabilization-def-short' => 'Стандартно',
	'stabilization-def-short-0' => 'Поточна',
	'stabilization-def-short-1' => 'Опублікована',
	'stabilize_page_invalid' => 'Неприпустима назва цільової сторінки.',
	'stabilize_page_notexists' => 'Цільової сторінки не існує.',
	'stabilize_page_unreviewable' => 'Цільова сторінка не перебуває в просторі назв, що може рецензуватись.',
	'stabilize_invalid_autoreview' => 'Невірне обмеження автоматичного рецензування.',
	'stabilize_invalid_level' => 'Невірний рівень захисту.',
	'stabilize_expiry_invalid' => 'Помилкова дата закінчення.',
	'stabilize_expiry_old' => 'Зазначений час закінчення пройшов.',
	'stabilize_denied' => 'Доступ заборонено.',
	'stabilize-expiring' => 'закінчується о $1 (UTC)',
	'stabilization-review' => 'Позначити поточну версію перевіреною',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'stabilization-comment' => 'وجہ:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'stabilization-tab' => 'c. q.',
	'stabilization' => 'Stabilizassion de pagina',
	'stabilization-text' => "'''Canbia le inpostassion qua soto par stabilir come la version stabile de [[:$1|$1]] la vegna selessionà e mostrà.'''",
	'stabilization-perm' => 'No ti gà i permessi necessari par canbiar le inpostassion de la version publicà.
Chì ghe xe le inpostassion atuali par [[:$1|$1]]:',
	'stabilization-page' => 'Nome de la pagina:',
	'stabilization-leg' => 'Conferma le inpostassion par la version publicà',
	'stabilization-def' => 'Version mostrà par default quando se varda la pagina',
	'stabilization-def1' => "La revision stabile; se no ghe n'è, alora l'ultima revision",
	'stabilization-def2' => "L'ultima revision",
	'stabilization-restrict' => 'Restrizion su la revision/auto-revision',
	'stabilization-restrict-none' => 'Nissun restrizion èstra',
	'stabilization-submit' => 'Conferma',
	'stabilization-notexists' => 'No ghe xe nissuna pagina che se ciama "[[:$1|$1]]".
Nissuna configurassion xe possibile.',
	'stabilization-notcontent' => 'La pagina "[[:$1|$1]]" no la pode èssar riesaminà.
No se pode canbiar le inpostassion.',
	'stabilization-comment' => 'Motivassion:',
	'stabilization-otherreason' => 'Altro motivo:',
	'stabilization-expiry' => 'Scadensa:',
	'stabilization-othertime' => 'Altra durata:',
	'stabilization-def-short' => 'Predefinìa',
	'stabilization-def-short-0' => 'Atuale',
	'stabilization-def-short-1' => 'Publicà',
	'stabilize_page_invalid' => "El titolo de destinassion no'l xe mia valido",
	'stabilize_page_notexists' => 'La pagina de destinassion no la esiste.',
	'stabilize_page_unreviewable' => 'La pagina de destinassion no la xe in un namespace revisionabile.',
	'stabilize_invalid_autoreview' => 'Restrission de autorevision mia valida.',
	'stabilize_invalid_level' => 'Livel de protession mia valido.',
	'stabilize_expiry_invalid' => 'Data de scadensa mìa valida.',
	'stabilize_expiry_old' => 'Sta scadensa la xe zà passà.',
	'stabilize_denied' => 'Parmesso negà',
	'stabilize-expiring' => 'scadensa $1 (UTC)',
	'stabilization-review' => 'Segna la revision atuale come controlà',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Lehtpolen stabilizacii',
	'stabilization-text' => "Alemba anttud järgendused pättas, kut sab valita da ozutelda [[:$1|$1]]-lehtpolen publikuidud versii.'''",
	'stabilization-perm' => 'Teile ei ulotu oiktusid, miše toižetada publikuidud versijoiden järgendused.
Naku oma nügüdläižed järgendused [[:$1|$1]]-lehtpolen täht:',
	'stabilization-page' => 'Lehtpolen nimi:',
	'stabilization-leg' => 'Publikuidud versijan järgendusiden vahvištoitand',
	'stabilization-def' => 'Versii, kudambad ozutadas augotižjärgendusen mödhe',
	'stabilization-def1' => "Stabiline versii; ku mugošt ei ole, ka jäl'gmäine (kodvversii)",
	'stabilization-def2' => "Jäl'gmäine versii (kodvversii)",
	'stabilization-restrict' => 'Kodvindan/avtokodvindan kaidendused',
	'stabilization-restrict-none' => 'Ei ole ližakaidendusid',
	'stabilization-submit' => 'Vahvištoitta',
	'stabilization-notexists' => 'Ei ole "[[:$1|$1]]"-nimitadud lehtpolen versijad. Ei voi järgeta.',
	'stabilization-notcontent' => '"[[:$1|$1]]"-lehtpol\'t ei voi kodvda.
Ei voi järgeta.',
	'stabilization-comment' => 'Sü:',
	'stabilization-otherreason' => 'Toine sü:',
	'stabilization-expiry' => 'Lopstrok:',
	'stabilization-othertime' => 'Toine aig',
	'stabilization-def-short' => 'Augotižjärgendusen mödhe',
	'stabilization-def-short-0' => 'Nügüdläine',
	'stabilization-def-short-1' => 'Publikoitud',
	'stabilize_page_invalid' => 'Metlehtpolen nimi om vär',
	'stabilize_page_notexists' => "Metlehtpol't ei ole olemas",
	'stabilize_page_unreviewable' => "Metlehtpol't ei ole kodvdud nimiavarudes.",
	'stabilize_invalid_autoreview' => 'Avtokodvindan petuzližed kaidendused',
	'stabilize_invalid_level' => 'Petuzline kaičendtazopind.',
	'stabilize_expiry_invalid' => 'Petuzline lopstrok.',
	'stabilize_expiry_old' => 'Nece tegendan lopmižen aig om jo männu.',
	'stabilize_denied' => 'Ei sa tulda.',
	'stabilize-expiring' => 'lopiše aigal $1 (UTC)',
	'stabilization-review' => 'Tühjitada nügüdläine versii, sikš miše se om kodvmatoi',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Trần Nguyễn Minh Huy
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Ổn định trang',
	'stabilization-text' => "'''Thay đổi thiết lập dưới đây để điều chỉnh cách lựa chọn và hiển thị phiên bản ổn định của [[:$1|$1]].'''",
	'stabilization-perm' => 'Tài khoản của bạn không có quyền thay đổi cấu hình phiên bản công bố.
Dưới đây là các thiết lập hiện hành cho [[:$1|$1]]:',
	'stabilization-page' => 'Tên trang:',
	'stabilization-leg' => 'Xác nhận các thiết lập bản công bố',
	'stabilization-def' => 'Bản được hiển thị mặc định',
	'stabilization-def1' => 'Phiên bản ổn định; không có thì phiên bản hiện hành',
	'stabilization-def2' => 'Phiên bản gần đây nhất',
	'stabilization-restrict' => 'Hạn chế duyệt / duyệt tự động',
	'stabilization-restrict-none' => 'Không có hạn chế nào khác',
	'stabilization-submit' => 'Xác nhận',
	'stabilization-notexists' => 'Không có trang nào có tên “[[:$1|$1]]”.
Không thể cấu hình.',
	'stabilization-notcontent' => 'Trang “[[:$1|$1]]” không thể được duyệt.
Không thể cấu hình.',
	'stabilization-comment' => 'Lý do:',
	'stabilization-otherreason' => 'Lý do khác:',
	'stabilization-expiry' => 'Thời hạn:',
	'stabilization-othertime' => 'Thời gian khác:',
	'stabilization-def-short' => 'Mặc định',
	'stabilization-def-short-0' => 'Hiện hành',
	'stabilization-def-short-1' => 'Ổn định',
	'stabilize_page_invalid' => 'Tên trang đích không hợp lệ',
	'stabilize_page_notexists' => 'Trang đích không tồn tại',
	'stabilize_page_unreviewable' => 'Trang đích không phải thuộc về không gian tên duyệt được.',
	'stabilize_invalid_autoreview' => 'Hạn chết duyệt tự động không hợp lệ.',
	'stabilize_invalid_level' => 'Mức độ bảo vệ không hợp lệ.',
	'stabilize_expiry_invalid' => 'Thời hạn không hợp lệ.',
	'stabilize_expiry_old' => 'Thời hạn đã qua.',
	'stabilize_denied' => 'Không cho phép.',
	'stabilize-expiring' => 'hết hạn vào $1 (UTC)',
	'stabilization-review' => 'Đánh dấu phiên bản hiện hành là “đã xem qua”.',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'stabilization-tab' => '(ka)',
	'stabilization' => 'Fümöfükam pada',
	'stabilization-text' => "'''Votükolös parametis dono ad sludön, lio fomam fümöfik pada: [[:$1|$1]] pavälon e pajonon.'''",
	'stabilization-perm' => 'Kal olik no dälon ad votükön parametemi fomama fümöfik. Is palisedon parametem anuik pro pad: [[:$1|$1]]:',
	'stabilization-page' => 'Nem pada:',
	'stabilization-leg' => 'Fümedön parametis fomama fümöfik',
	'stabilization-def' => 'Fomam jonabik pö padilogams kösömik',
	'stabilization-def1' => 'Fomam fümöfik; if no dabinon, tän fomam anuik',
	'stabilization-def2' => 'Fomam anuik',
	'stabilization-submit' => 'Fümedön',
	'stabilization-notexists' => 'Pad tiädü "[[:$1|$1]]" no dabinon. Fomükam no mögon.',
	'stabilization-notcontent' => 'Pad: "[[:$1|$1]]" no kanon pakrütön. Parametem nonik mögon.',
	'stabilization-comment' => 'Kod:',
	'stabilization-otherreason' => 'Kod votik:',
	'stabilization-expiry' => 'Dul jü:',
	'stabilization-othertime' => 'Dul votik:',
	'stabilization-def-short-0' => 'Anuik',
	'stabilization-def-short-1' => 'Fümöfik',
	'stabilize_expiry_invalid' => 'Dul no lonöföl.',
	'stabilize-expiring' => 'dulon jü $1 (UTC)',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'stabilization-comment' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'stabilization-page' => 'בלאט נאמען:',
	'stabilization-submit' => 'באַשטעטיקן',
	'stabilization-comment' => 'אורזאַך:',
	'stabilization-otherreason' => 'אַנדער אורזאַך',
	'stabilization-expiry' => 'גייט אויס:',
	'stabilization-def-short' => 'גרונטלעך',
	'stabilization-def-short-0' => 'לויפֿיקע',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'stabilization-tab' => '查',
	'stabilization' => '穩定頁',
	'stabilization-text' => "'''改下面嘅設定去調節所揀嘅[[:$1|$1]]之穩定版如何顯示。'''",
	'stabilization-perm' => '你嘅戶口無權限去改穩定版設定。
呢度有現時[[:$1|$1]]嘅設定:',
	'stabilization-page' => '版名:',
	'stabilization-leg' => '確認穩定版嘅設定',
	'stabilization-def' => '響預設版視嘅修訂顯示',
	'stabilization-def1' => '穩定修訂；如果未有，就係現時嘅',
	'stabilization-def2' => '現時嘅修訂',
	'stabilization-submit' => '確認',
	'stabilization-notexists' => '呢度係無一版係叫"[[:$1|$1]]"。
無設定可以改到。',
	'stabilization-notcontent' => '嗰版"[[:$1|$1]]"唔可以複審。
無設定可以改到。',
	'stabilization-comment' => '原因:',
	'stabilization-expiry' => '到期:',
	'stabilization-def-short' => '預設',
	'stabilization-def-short-0' => '現時',
	'stabilization-def-short-1' => '穩定',
	'stabilize_expiry_invalid' => '無效嘅到期日。',
	'stabilize_expiry_old' => '到期日已經過咗。',
	'stabilize-expiring' => '於 $1 (UTC) 到期',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Gaoxuewei
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'stabilization-tab' => '检查',
	'stabilization' => '稳定页面',
	'stabilization-text' => "'''修改以下设置以调整选择和显示[[:$1|$1]]稳定版本的方式。'''",
	'stabilization-perm' => '您的帐户无权更改稳定版本配置。这是[[:$1|$1]]的当前设置：',
	'stabilization-page' => '页面名称：',
	'stabilization-leg' => '确认稳定版本设置',
	'stabilization-def' => '在默认页面视图中显示修订',
	'stabilization-def1' => '稳定版本；如果不存在，则显示最新修订',
	'stabilization-def2' => '最新修订',
	'stabilization-restrict' => '复审／自动复审限制',
	'stabilization-restrict-none' => '没有额外限制',
	'stabilization-submit' => '确认',
	'stabilization-notexists' => '页面“[[:$1|$1]]”不存在，无法进行配置。',
	'stabilization-notcontent' => '不能复审页面“[[:$1|$1]]”，无法进行配置。',
	'stabilization-comment' => '原因：',
	'stabilization-otherreason' => '其他原因：',
	'stabilization-expiry' => '到期：',
	'stabilization-othertime' => '其他时间：',
	'stabilization-def-short' => '默认',
	'stabilization-def-short-0' => '当前',
	'stabilization-def-short-1' => '稳定',
	'stabilize_page_invalid' => '目标页面名称无效。',
	'stabilize_page_notexists' => '目标页面不存在。',
	'stabilize_page_unreviewable' => '目标页面不在可复审的名字空间内。',
	'stabilize_invalid_autoreview' => '无效的自动复审限制。',
	'stabilize_invalid_level' => '无效的保护级别。',
	'stabilize_expiry_invalid' => '无效的到期时间。',
	'stabilize_expiry_old' => '该到期时间已经过去了。',
	'stabilize_denied' => '权限错误。',
	'stabilize-expiring' => '到期时间 $1（UTC）',
	'stabilization-review' => '将当前修订标记为已检查',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Shinjiman
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'stabilization-tab' => '調查',
	'stabilization' => '穩定頁面',
	'stabilization-text' => "'''更改以下的設定去調節所選擇的[[:$1|$1]]之穩定版本如何顯示。'''",
	'stabilization-perm' => '您的帳戶並沒有權限去更改穩定版本設定。
這是[[:$1|$1]]目前的設定：',
	'stabilization-page' => '頁面名稱:',
	'stabilization-leg' => '確認穩定版本的設定',
	'stabilization-def' => '在預設頁視的修訂顯示',
	'stabilization-def1' => '穩定修訂；如果未有，則是現時版本',
	'stabilization-def2' => '最新版本',
	'stabilization-restrict' => '自動審核限制',
	'stabilization-restrict-none' => '無其他限制',
	'stabilization-submit' => '確認',
	'stabilization-notexists' => '頁面「[[:$1|$1]]」不存在。
無法進行設定。',
	'stabilization-notcontent' => '頁面「[[:$1|$1]]」不能被審核。
無法進行設定。',
	'stabilization-comment' => '原因：',
	'stabilization-otherreason' => '其他原因：',
	'stabilization-expiry' => '到期：',
	'stabilization-othertime' => '其他時間：',
	'stabilization-def-short' => '預設',
	'stabilization-def-short-0' => '現時',
	'stabilization-def-short-1' => '穩定',
	'stabilize_page_invalid' => '目標頁面名稱是無效的',
	'stabilize_page_notexists' => '目標頁面不存在',
	'stabilize_page_unreviewable' => '目標頁面的名字空間不是一個需要審查的名字空間。',
	'stabilize_invalid_autoreview' => '沒有自動複查權限',
	'stabilize_invalid_level' => '無效的保護水平。',
	'stabilize_expiry_invalid' => '無效的到期日。',
	'stabilize_expiry_old' => '到期日已過。',
	'stabilize_denied' => '權限錯誤',
	'stabilize-expiring' => '於 $1 （UTC） 到期',
	'stabilization-review' => '將此當前版本標記為已查閱',
);

