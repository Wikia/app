<?php
/**
 * Internationalisation file for FlaggedRevs extension, section Stabilization
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Page stabilization',
	'stabilization-text' => '\'\'\'Change the settings below to adjust how the stable version of [[:$1|$1]] is selected and displayed.\'\'\'

When changing the \'\'stable version selection\'\' configuration to use "quality" or "pristine" revisions by default,
be sure to check if there actually are such revisions in the page, otherwise the change will have little affect.',
	'stabilization-perm' => 'Your account does not have permission to change the stable version configuration.
Here are the current settings for [[:$1|$1]]:',
	'stabilization-page' => 'Page name:',
	'stabilization-leg' => 'Confirm stable version settings',
	'stabilization-select' => 'Stable version selection',
	'stabilization-select1' => 'The latest quality revision; if not present, then the latest sighted one',
	'stabilization-select2' => 'The latest reviewed revision, regardless of validation level',
	'stabilization-select3' => 'The latest pristine revision; if not present, then the latest quality or sighted one',
	'stabilization-def' => 'Revision displayed on default page view',
	'stabilization-def1' => 'The stable revision; if not present, then the current one',
	'stabilization-def2' => 'The current revision',
	'stabilization-restrict' => 'Auto-review restrictions',
	'stabilization-restrict-none' => 'No extra restrictions',
	'stabilization-submit' => 'Confirm',
	'stabilization-notexists' => 'There is no page called "[[:$1|$1]]".
No configuration is possible.',
	'stabilization-notcontent' => 'The page "[[:$1|$1]]" cannot be reviewed.
No configuration is possible.',
	'stabilization-comment' => 'Reason:',
	'stabilization-otherreason' => 'Other reason',
	'stabilization-expiry' => 'Expires:',
	'stabilization-othertime' => 'Other time',
	'stabilization-sel-short' => 'Precedence',
	'stabilization-sel-short-0' => 'Quality',
	'stabilization-sel-short-1' => 'None',
	'stabilization-sel-short-2' => 'Pristine',
	'stabilization-def-short' => 'Default',
	'stabilization-def-short-0' => 'Current',
	'stabilization-def-short-1' => 'Stable',
	'stabilization-rest-short' => 'autoreview=$1',
	'stabilize_expiry_invalid' => 'Invalid expiration date.',
	'stabilize_expiry_old' => 'This expiration time has already passed.',
	'stabilize-expiring' => 'expires $1 (UTC)',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author SPQRobin
 * @author Saper
 */
$messages['qqq'] = array(
	'stabilization-tab' => '{{Flagged Revs-small}}

Some skins (e.g. standard/classic) display an additional tab to control visibility of the page revisions, e.g. whether last revision should be included or perhaps the last sighted or stable version.',
	'stabilization' => '{{Flagged Revs-small}}
Page title of Special:Stabilization.',
	'stabilization-text' => '{{Flagged Revs-small}}

Information displayed on Special:Stabilization.

"stable version selection" is the same as {{msg-mw|Stabilization-select}}.',
	'stabilization-perm' => '{{Flagged Revs-small}}
Used on Special:Stabilization when the user has not the permission to change the settings.',
	'stabilization-page' => '{{Flagged Revs}}
{{Identical|Page name}}',
	'stabilization-leg' => '{{Flagged Revs}}',
	'stabilization-select' => '{{Flagged Revs}}',
	'stabilization-select1' => '{{Flagged Revs-small}}
Used on Special:Stabilization as an option for "How the stable version is selected".',
	'stabilization-select2' => '{{Flagged Revs-small}}
Used on Special:Stabilization as an option for "How the stable version is selected".',
	'stabilization-select3' => '{{Flagged Revs}}',
	'stabilization-def' => '{{Flagged Revs}}',
	'stabilization-def1' => '{{Flagged Revs-small}}
Used on Special:Stabilization as an option for "Revision displayed on default page view".

This option has sub-options, see "How the stable version is selected".',
	'stabilization-def2' => '{{Flagged Revs-small}}
Used on Special:Stabilization as an option for "Revision displayed on default page view".',
	'stabilization-submit' => '{{Flagged Revs}}
{{Identical|Confirm}}',
	'stabilization-notexists' => '{{Flagged Revs}}',
	'stabilization-notcontent' => '{{Flagged Revs}}',
	'stabilization-comment' => '{{Flagged Revs}}
{{Identical|Reason}}',
	'stabilization-expiry' => '{{Flagged Revs}}
{{Identical|Expires}}',
	'stabilization-sel-short' => '{{Flagged Revs}}',
	'stabilization-sel-short-0' => '{{Flagged Revs}}',
	'stabilization-sel-short-1' => '{{Flagged Revs}}
{{Identical|None}}',
	'stabilization-sel-short-2' => '{{Flagged Revs}}',
	'stabilization-def-short' => '{{Flagged Revs}}
{{Identical|Default}}',
	'stabilization-def-short-0' => '{{Flagged Revs}}
{{Identical|Current}}',
	'stabilization-def-short-1' => '{{Flagged Revs}}
{{Identical|Stable}}',
	'stabilize_expiry_invalid' => '{{Flagged Revs}}',
	'stabilize_expiry_old' => '{{Flagged Revs}}',
	'stabilize-expiring' => "{{Flagged Revs}}
Used to indicate when something expires.
$1 is a time stamp in the wiki's content language.
$2 is the correxponding date in the wiki's content language.
$3 is the correxponding time in the wiki's content language.

{{Identical|Expires $1 (UTC)}}",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Lehtpolen stabilizacii',
	'stabilization-text' => "'''Toižetagat järgendused, miše pätta, kut pidab valita da ozutelda [[:\$1|\$1]]-lehtpolen stabiline versii.'''

Konz tö toižetat ''stabiližen versijan valičendan'' järgendused, miše kävutada \"laduline\" vai \"puhtaz\" 
järgendusen mödhe, ka kodvgat, om-ik lehtpolel nigomid toižetusid, ika tö et sabustagoi metod.",
	'stabilization-perm' => 'Teile ei ulotu oiktusid, miše toižetada stabiližen versijan ozutamižen järgendused.
Naku oma nügüdläižed järgendused [[:$1|$1]]-lehtpolen täht:',
	'stabilization-page' => 'Lehtpolen nimi:',
	'stabilization-leg' => 'Stabiližen versijan järgendusiden vahvištoitand',
	'stabilization-select' => 'Stabiližen versijan valičend',
	'stabilization-select1' => 'Naku om veresemb kodvdud versii; ku mugošt ei ole, ka veresemb arvosteldud versijoišpäi.',
	'stabilization-select2' => "Jäl'gmäine kodvdud versii, vahvištoitandan tazopindha kacmata",
	'stabilization-select3' => "Jäl'gmäine koskmatoi versii; ku mugošt ei ole, ka jäl'gmäine kodvdud vai arvosteldud versii.",
	'stabilization-def' => 'Versii, kudambad ozutadas augotižjärgendusen mödhe',
	'stabilization-def1' => 'Stabiline versii; ku mugošt ei ole, ka nügüdläine',
	'stabilization-def2' => 'Nügüdläine versii',
	'stabilization-restrict' => 'Avtoarvostelendan kaidendused',
	'stabilization-restrict-none' => 'Ei ole ližakaidendusid',
	'stabilization-submit' => 'Vahvištoitta',
	'stabilization-notexists' => 'Ei ole "[[:$1|$1]]"-nimitadud lehtpolen versijad. Ei voi järgeta.',
	'stabilization-notcontent' => '"[[:$1|$1]]"-lehtpol\'t ei voi kodvda.
Ei voi järgeta.',
	'stabilization-comment' => 'Sü:',
	'stabilization-otherreason' => 'Toine sü:',
	'stabilization-expiry' => 'Lopstrok:',
	'stabilization-othertime' => 'Toine aig',
	'stabilization-sel-short' => "Jäl'gendusen järgenduz.",
	'stabilization-sel-short-0' => 'Kodvdud',
	'stabilization-sel-short-1' => 'Ei ole',
	'stabilization-sel-short-2' => 'Koskmatoi',
	'stabilization-def-short' => 'Augotižjärgendusen mödhe',
	'stabilization-def-short-0' => 'Nügüdläine',
	'stabilization-def-short-1' => 'Stabiline',
	'stabilization-rest-short' => 'avtoarvostelend=$1',
	'stabilize_expiry_invalid' => 'Petuzline lopstrok.',
	'stabilize_expiry_old' => 'Nece tegendan lopmižen aig om jo männu.',
	'stabilize-expiring' => 'lopiše aigal $1 (UTC)',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'stabilization-page' => 'Bladsynaam:',
	'stabilization-def2' => 'Die weergawe',
	'stabilization-submit' => 'Bevestig',
	'stabilization-comment' => 'Rede:',
	'stabilization-otherreason' => 'Ander rede',
	'stabilization-expiry' => 'Verval:',
	'stabilization-othertime' => 'Aander tyd',
	'stabilization-sel-short' => 'Voorrang',
	'stabilization-sel-short-0' => 'Kwaliteit',
	'stabilization-sel-short-1' => 'Geen',
	'stabilization-sel-short-2' => 'Ongerep',
	'stabilization-def-short' => 'Standaard',
	'stabilization-def-short-0' => 'Huidig',
	'stabilization-def-short-1' => 'Stabiel',
	'stabilize_expiry_invalid' => 'Ongeldige vervaldatum.',
	'stabilize_expiry_old' => 'Die vervaldatum is reeds verby.',
	'stabilize-expiring' => 'verval $1 (UTC)',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'stabilization-comment' => 'ማጠቃለያ፦',
	'stabilization-def-short-0' => 'ያሁኑኑ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'stabilization-tab' => '(compreb)',
	'stabilization' => "Estabilizazión d'a pachina",
	'stabilization-text' => "'''Si quiere achustar cómo se triga y amuestra a bersión estable de [[:$1|$1]] cambee a confegurazión más tabaixo.'''",
	'stabilization-perm' => "A suya cuenta no tiene premisos ta cambiar a confegurazión d'a bersión estable. Os achustes autuals ta [[:$1|$1]] s'amuestran aquí:",
	'stabilization-page' => "Nombre d'a pachina:",
	'stabilization-leg' => "Confirmar a confegurazión d'a bersión estable",
	'stabilization-select' => "Triga d'a bersión estable",
	'stabilization-select1' => "A zaguera bersión de calidat; si no bi'n ha, alabez a zaguera bersión superbisata",
	'stabilization-select2' => 'A zaguera bersión rebisata',
	'stabilization-select3' => "A zaguera bersión zanzera; si bi'n ha, alabez a zaguera bersión de calidat u rebisata.",
	'stabilization-def' => "A rebisión s'amuestra en a pachina de bisualizazión por defeuto",
	'stabilization-def1' => "A bersión estable; si no bi'n ha, alabez a bersión autual",
	'stabilization-def2' => 'A bersión autual',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'No bi ha garra pachina tetulata "[[:$1|$1]]". 
No ye posible confegurar-la.',
	'stabilization-notcontent' => 'A pachina "[[:$1|$1]]" no se puede rebisar.
No ye posible confegurar-la.',
	'stabilization-comment' => 'Comentario:',
	'stabilization-expiry' => 'Zircunduze:',
	'stabilization-sel-short' => 'Prezendenzia',
	'stabilization-sel-short-0' => 'Calidat',
	'stabilization-sel-short-1' => 'Denguna',
	'stabilization-sel-short-2' => 'Zanzera',
	'stabilization-def-short' => 'Por defeuto',
	'stabilization-def-short-0' => 'Autual',
	'stabilization-def-short-1' => 'Estable',
	'stabilize_expiry_invalid' => 'A calendata de zircunduzión no ye conforme.',
	'stabilize_expiry_old' => 'Ista calendata de zircunduzión ya ye pasata.',
	'stabilize-expiring' => 'zircunduze o $1 (UTC)',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 */
$messages['ar'] = array(
	'stabilization-tab' => 'تج',
	'stabilization' => 'تثبيت الصفحة',
	'stabilization-text' => "'''غير الإعدادات بالأسفل لضبط الكيفية التي بها النسخة المستقرة من [[:\$1|\$1]] يتم اختيارها وعرضها.'''

عند تغيير ضبط ''اختيار النسخة المختارة'' لاستخدام مراجعات \"الجودة\" أو \"الفائقة\" افتراضيا،
تأكد من التحقق من وجود مراجعات كهذه في الصفحة، وإلا فإن التغيير سيكون له تأثير ضعيف.",
	'stabilization-perm' => 'حسابك لا يمتلك الصلاحية لتغيير إعدادات النسخة المستقرة.
	هنا الإعدادات الحالية ل[[:$1|$1]]:',
	'stabilization-page' => 'اسم الصفحة:',
	'stabilization-leg' => 'تأكيد إعدادات النسخة المستقرة',
	'stabilization-select' => 'اختيار النسخة المستقرة',
	'stabilization-select1' => 'آخر مراجعة جودة؛ لو غير موجودة، إذا آخر واحدة منظورة',
	'stabilization-select2' => 'آخر مراجعة مراجعة، بعض النظر عن مستوى التحقيق',
	'stabilization-select3' => 'آخر مراجعة فائقة؛ لو غير موجودة، إذا آخر مراجعة جودة أو منظورة',
	'stabilization-def' => 'المراجعة المعروضة عند رؤية الصفحة افتراضيا',
	'stabilization-def1' => 'المراجعة المستقرة؛ لو غير موجودة، إذا المراجعة الحالية',
	'stabilization-def2' => 'المراجعة الحالية',
	'stabilization-restrict' => 'ضوابط المراجعة التلقائية',
	'stabilization-restrict-none' => 'لا ضوابط إضافية',
	'stabilization-submit' => 'تأكيد',
	'stabilization-notexists' => 'لا توجد صفحة بالاسم "[[:$1|$1]]".
لا ضبط ممكن.',
	'stabilization-notcontent' => 'الصفحة "[[:$1|$1]]" لا يمكن مراجعتها.
لا ضبط ممكن.',
	'stabilization-comment' => 'السبب:',
	'stabilization-otherreason' => 'سبب آخر',
	'stabilization-expiry' => 'تنتهي:',
	'stabilization-othertime' => 'وقت آخر',
	'stabilization-sel-short' => 'تنفيذ',
	'stabilization-sel-short-0' => 'جودة',
	'stabilization-sel-short-1' => 'لا شيء',
	'stabilization-sel-short-2' => 'فائقة',
	'stabilization-def-short' => 'افتراضي',
	'stabilization-def-short-0' => 'حالي',
	'stabilization-def-short-1' => 'مستقر',
	'stabilization-rest-short' => 'مراجعة تلقائية=$1',
	'stabilize_expiry_invalid' => 'تاريخ انتهاء غير صحيح.',
	'stabilize_expiry_old' => 'تاريخ الانتهاء هذا مر بالفعل.',
	'stabilize-expiring' => 'تنتهي في $1 (UTC)',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'stabilization-tab' => 'تج',
	'stabilization' => 'تثبيت الصفحة',
	'stabilization-text' => "'''غير الإعدادات بالأسفل لضبط الكيفية التى بها النسخة المستقرة من [[:$1|$1]] يتم اختيارها وعرضها.'''",
	'stabilization-perm' => 'حسابك لا يمتلك الصلاحية لتغيير إعدادات النسخة المستقرة.
هنا الإعدادات الحالية ل[[:$1|$1]]:',
	'stabilization-page' => 'اسم الصفحة:',
	'stabilization-leg' => 'تأكيد إعدادات النسخة المستقرة',
	'stabilization-select' => 'اختيار النسخة المستقرة',
	'stabilization-select1' => 'آخر مراجعة جودة؛ لو غير موجودة، إذا آخر واحدة منظورة',
	'stabilization-select2' => 'آخر مراجعة مراجعة',
	'stabilization-select3' => 'آخر مراجعة فائقة؛ لو غير موجودة، إذا آخر مراجعة جودة أو منظورة',
	'stabilization-def' => 'المراجعة المعروضة عند رؤية الصفحة افتراضيا',
	'stabilization-def1' => 'المراجعة المستقرة؛ لو غير موجودة، إذا المراجعة الحالية',
	'stabilization-def2' => 'المراجعة الحالية',
	'stabilization-submit' => 'تأكيد',
	'stabilization-notexists' => 'لا توجد صفحة بالاسم "[[:$1|$1]]".
لا ضبط ممكن.',
	'stabilization-notcontent' => 'الصفحة "[[:$1|$1]]" لا يمكن مراجعتها.
لا ضبط ممكن.',
	'stabilization-comment' => 'السبب:',
	'stabilization-otherreason' => 'سبب تانى',
	'stabilization-expiry' => 'تنتهى:',
	'stabilization-othertime' => 'وقت تانى',
	'stabilization-sel-short' => 'تنفيذ',
	'stabilization-sel-short-0' => 'جودة',
	'stabilization-sel-short-1' => 'لا شيء',
	'stabilization-sel-short-2' => 'فائقة',
	'stabilization-def-short' => 'افتراضى',
	'stabilization-def-short-0' => 'حالى',
	'stabilization-def-short-1' => 'مستقر',
	'stabilize_expiry_invalid' => 'تاريخ انتهاء غير صحيح.',
	'stabilize_expiry_old' => 'تاريخ الانتهاء هذا مر بالفعل.',
	'stabilize-expiring' => 'تنتهى فى $1 (UTC)',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'stabilization-tab' => '(aq)',
	'stabilization' => 'Estabilización de páxines',
	'stabilization-text' => "'''Camudar la configuración d'embaxo p'axustar cómo se seleiciona y s'amuesa la versión estable de [[:$1|$1]].'''",
	'stabilization-perm' => 'La to cuenta nun tienen permisos pa camudar la configuración de la versión estable.
Esta ye la configuración de [[:$1|$1]]:',
	'stabilization-page' => 'Nome de la páxina:',
	'stabilization-leg' => 'Confirmar la configuración de la versión estable',
	'stabilization-select' => 'Seleición de la versión estable',
	'stabilization-select1' => 'La cabera revisión calidable; si nun la hai, entós la cabera vista',
	'stabilization-select2' => 'La cabera revisión revisada',
	'stabilization-def' => 'Revisión amosada na vista de páxina por defeutu',
	'stabilization-def1' => "La revisión estable; si nun la hai, entós l'actual",
	'stabilization-def2' => 'La revisión actual',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Nun esiste la páxina "[[:$1|$1]]". Nun ye posible la configuración.',
	'stabilization-notcontent' => 'La páxina "[[:$1|$1]]" nun pue ser revisada. Nun ye posible la configuración.',
	'stabilization-comment' => 'Comentariu:',
	'stabilization-expiry' => 'Caduca:',
	'stabilization-sel-short' => 'Prioridá',
	'stabilization-sel-short-0' => 'Calidable',
	'stabilization-sel-short-1' => 'Nenguna',
	'stabilization-def-short' => 'Por defeutu',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Estable',
	'stabilize_expiry_invalid' => 'Fecha de caducidá non válida.',
	'stabilize_expiry_old' => 'Esta caducidá yá tien pasao.',
	'stabilize-expiring' => "caduca'l $1 (UTC)",
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'stabilization-othertime' => 'Ãndare Zeid',
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
	'stabilization-select' => 'انتخاب نسخه ثابت',
	'stabilization-select1' => 'آهری بازبینی کیفیت؛اگر نیست؛اچه اهرین رویت بیتگن',
	'stabilization-select2' => 'آهری دیستگین بازبینی',
	'stabilization-select3' => 'آهری بازبینی دست نوارتگین، اگه نیست، رندا آهری کیفیت یا رویتء',
	'stabilization-def' => 'بازبینی ته پیش فرضین دیستن جاهکیت',
	'stabilization-def1' => 'ثابتین بازبینی; اگر نیست، گوڈء هنوکین',
	'stabilization-def2' => 'هنوکین بازبینی',
	'stabilization-submit' => 'تایید',
	'stabilization-notexists' => 'صفحه ای په نام "[[:$1|$1]]" نیست.
هچ تنظیمی ممکن نهنت.',
	'stabilization-notcontent' => 'صفحه "[[:$1|$1]]" نه تونیت باز بینی بیت.
هچ تنظیمی ممکن نهنت.',
	'stabilization-comment' => 'نظر:',
	'stabilization-expiry' => 'هلیت:',
	'stabilization-sel-short' => 'تقدم',
	'stabilization-sel-short-0' => 'کیفیت',
	'stabilization-sel-short-1' => 'هچ یک',
	'stabilization-sel-short-2' => 'اولین',
	'stabilization-def-short' => 'پیش فرض',
	'stabilization-def-short-0' => 'هنوکین',
	'stabilization-def-short-1' => 'ثابت',
	'stabilize_expiry_invalid' => 'نامعتبرین تاریخ هلگ',
	'stabilize_expiry_old' => 'ای زمان انقضا هنو هلتت.',
	'stabilize-expiring' => 'وهدی هلیت  $1 (UTC)',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'stabilization-page' => 'Назва старонкі:',
	'stabilization-submit' => 'Пацьвердзіць',
	'stabilization-comment' => 'Прычына:',
	'stabilization-sel-short-0' => 'Якасьць',
	'stabilization-def-short' => 'Па змоўчваньні',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'stabilization' => 'Устойчивост на страницата',
	'stabilization-page' => 'Име на страницата:',
	'stabilization-leg' => 'Настройка на устойчивата версия на страницата',
	'stabilization-select1' => 'Последната качествена версия; ако няма такава, тогава последната прегледана',
	'stabilization-select2' => 'Последната рецензирана версия',
	'stabilization-def1' => 'Устойчивата версия; ако няма такава, тогава текущата',
	'stabilization-def2' => 'Текущата версия',
	'stabilization-submit' => 'Потвърждаване',
	'stabilization-notexists' => 'Не съществува страница „[[:$1|$1]]“. Не е възможно конфигуриране.',
	'stabilization-comment' => 'Коментар:',
	'stabilization-expiry' => 'Изтича на:',
	'stabilization-sel-short' => 'Предимство',
	'stabilization-sel-short-0' => 'Качество',
	'stabilization-sel-short-1' => 'Никоя',
	'stabilization-def-short' => 'По подразбиране',
	'stabilization-def-short-0' => 'Текуща',
	'stabilization-def-short-1' => 'Устойчива',
	'stabilize_expiry_invalid' => 'Невалидна дата на изтичане.',
	'stabilize_expiry_old' => 'Дата на изтичане вече е отминала.',
	'stabilize-expiring' => 'изтича на $1 (UTC)',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'পাতা স্থিতিকরণ',
	'stabilization-page' => 'পাতার নাম:',
	'stabilization-def2' => 'বর্তমান সংশোধন',
	'stabilization-submit' => 'নিশ্চিত করো',
	'stabilization-comment' => 'মন্তব্য:',
	'stabilization-expiry' => 'মেয়াদ উত্তীর্ণ:',
	'stabilization-sel-short' => 'অগ্রাধিকার',
	'stabilization-sel-short-0' => 'গুণ',
	'stabilization-sel-short-1' => 'কিছু না',
	'stabilization-def-short-0' => 'বর্তমান',
	'stabilization-def-short-1' => 'সুদৃঢ়',
	'stabilize_expiry_invalid' => 'অবৈধ মেয়াদ উত্তীর্ণের তারিখ।',
	'stabilize_expiry_old' => 'মেয়াদ উত্তীর্ণের সময় পার হয়ে গেছে।',
	'stabilize-expiring' => 'মেয়াদ উত্তীর্ণ হবে $1 (UTC)',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'stabilization-page' => 'Anv ar bajenn :',
	'stabilization-submit' => 'Kadarnaat',
	'stabilization-comment' => 'Notenn :',
	'stabilization-expiry' => "A ya d'e dermen",
	'stabilization-sel-short' => 'Kentwir',
	'stabilization-sel-short-0' => 'Perzhded',
	'stabilization-sel-short-1' => 'Hini ebet',
	'stabilization-def-short' => 'Dre ziouer',
	'stabilization-def-short-1' => 'Stabil',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'stabilization-page' => 'Naslov stranice:',
	'stabilization-def2' => 'Trenutna revizija',
	'stabilization-restrict-none' => 'Bez posebnih ograničenja',
	'stabilization-submit' => 'Potvrdi',
	'stabilization-comment' => 'Razlog:',
	'stabilization-otherreason' => 'Ostali razlozi',
	'stabilization-sel-short-0' => 'Kvalitet',
	'stabilization-sel-short-1' => 'nema',
	'stabilization-def-short' => 'Standardno',
	'stabilization-def-short-0' => 'Trenutna',
	'stabilize-expiring' => 'ističe $1 (UTC)',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Paucabot
 * @author Toniher
 */
$messages['ca'] = array(
	'stabilization-page' => 'Nom de la pàgina:',
	'stabilization-def2' => 'La revisió actual',
	'stabilization-submit' => 'Confirma',
	'stabilization-notexists' => 'No hi ha cap pàgina que s\'anomeni "[[:$1|$1]]".
No és possible fer cap configuració.',
	'stabilization-comment' => 'Motiu:',
	'stabilization-expiry' => 'Venç:',
	'stabilization-sel-short' => 'Precedència',
	'stabilization-sel-short-0' => 'Qualitat',
	'stabilization-sel-short-1' => 'Cap',
	'stabilization-def-short' => 'Per defecte',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Estable',
	'stabilize_expiry_invalid' => 'La data de venciment no és vàlida.',
	'stabilize-expiring' => 'expira $1 (UTC)',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 */
$messages['cs'] = array(
	'stabilization-tab' => 'stabilizace',
	'stabilization' => 'Stabilizace stránky',
	'stabilization-text' => "'''Změňte nastavení, jak se vybírá stabilní verze stránky [[:$1|$1]] a co se zobrazí.'''",
	'stabilization-perm' => 'Tento účet nemá povoleno měnit nastavení stabilní verze. Níže je současné nastavení stránky [[:$1|$1]]:',
	'stabilization-page' => 'Jméno stránky:',
	'stabilization-leg' => 'Potvrdit nastavení stabilní verze',
	'stabilization-select' => 'Výběr stabilní verze',
	'stabilization-select1' => 'Poslední kvalitní verze; pokud není k dispozici pak poslední prohlédnutá',
	'stabilization-select2' => 'Poslední posouzená verze',
	'stabilization-def' => 'Verze zobrazená jako výchozí',
	'stabilization-def1' => 'Stabilní verze',
	'stabilization-def2' => 'Současná verze',
	'stabilization-submit' => 'Potvrdit',
	'stabilization-notexists' => 'Neexistuje stránka "[[:$1|$1]]". Nastavení není možné.',
	'stabilization-notcontent' => 'Stránka „[[:$1|$1]]“ nemůže být posouzena. Nastavení není možné.',
	'stabilization-comment' => 'Komentář:',
	'stabilization-expiry' => 'Vyprší:',
	'stabilization-sel-short' => 'Váha',
	'stabilization-sel-short-0' => 'kvalitní',
	'stabilization-sel-short-1' => 'žádná',
	'stabilization-def-short' => 'výchozí',
	'stabilization-def-short-0' => 'současná',
	'stabilization-def-short-1' => 'stabilní',
	'stabilize_expiry_invalid' => 'Datum vypršení je chybné.',
	'stabilize_expiry_old' => 'Čas vypršení již minul.',
	'stabilize-expiring' => 'vyprší $1 (UTC)',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'stabilization-submit' => 'Bekræft',
	'stabilization-expiry' => 'Udløb:',
	'stabilization-sel-short-1' => 'Ingen',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Nuværende',
	'stabilize-expiring' => 'til $1 (UTC)',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Umherirrender
 */
$messages['de'] = array(
	'stabilization-tab' => 'Konfig.',
	'stabilization' => 'Seitenkonfiguration',
	'stabilization-text' => "'''Ändere die Einstellungen um festzulegen, wie die markierte Version von „[[:$1|$1]]“ ausgewählt und angezeigt werden soll.'''

Bei einer Änderung der Konfiguration der standardmäßig angezeigten Version auf „geprüft“ oder „ursprünglich“, sollte darauf geachtet werden, dass die Seite eine solche Version enthält, andernfalls hat die Änderung keine große Auswirkung.",
	'stabilization-perm' => 'Du hast nicht die erforderliche Berechtigung, um die Einstellungen der markierten Version zu ändern.
Die aktuellen Einstellungen für „[[:$1|$1]]“ sind:',
	'stabilization-page' => 'Seitenname:',
	'stabilization-leg' => 'Einstellungen der markierten Version für eine Seite',
	'stabilization-select' => 'Auswahl der markierten Version',
	'stabilization-select1' => 'Die letzte geprüfte Version; wenn keine vorhanden ist, dann die letzte gesichtete Version',
	'stabilization-select2' => 'Die letzte markierte Version',
	'stabilization-select3' => 'Die letzte ursprüngliche Version; wenn keine vorhanden ist, dann die letzte gesichtete oder geprüfte Version',
	'stabilization-def' => 'Angezeigte Version in der normalen Seitenansicht',
	'stabilization-def1' => 'Die markierte Version; wenn keine vorhanden ist, dann die aktuelle Version',
	'stabilization-def2' => 'Die aktuelle Version',
	'stabilization-submit' => 'Bestätigen',
	'stabilization-notexists' => 'Es gibt keine Seite „[[:$1|$1]]“. Keine Einstellungen möglich.',
	'stabilization-notcontent' => 'Die Seite „[[:$1|$1]]“ kann nicht markiert werden. Konfiguration ist nicht möglich.',
	'stabilization-comment' => 'Grund:',
	'stabilization-otherreason' => 'Anderer Grund',
	'stabilization-expiry' => 'Gültig bis:',
	'stabilization-othertime' => 'Andere Zeit',
	'stabilization-sel-short' => 'Priorität',
	'stabilization-sel-short-0' => 'Qualität',
	'stabilization-sel-short-1' => 'keine',
	'stabilization-sel-short-2' => 'ursprünglich',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktuell',
	'stabilization-def-short-1' => 'Markiert',
	'stabilize_expiry_invalid' => 'Ungültiges Ablaufdatum.',
	'stabilize_expiry_old' => 'Das Ablaufdatum wurde überschritten.',
	'stabilize-expiring' => 'erlischt $1 (UTC)',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'stabilization-perm' => 'Sie haben nicht die erforderliche Berechtigung, um die Einstellungen der markierten Version zu ändern.
Die aktuellen Einstellungen für „[[:$1|$1]]“ sind:',
);

/** Zazaki (Zazaki)
 * @author Belekvor
 */
$messages['diq'] = array(
	'stabilization-sel-short-1' => 'çino',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'stabilization-tab' => 'pśekontrolowaś',
	'stabilization' => 'Stabilizacija boka',
	'stabilization-text' => "'''Změń slědujuce nastajenja, aby póstajił, kak se stabilna wersija wót [[:\$1|\$1]] wuběra a zwobraznjujo.'''

Gaž změniš konfiguraciju ''wuběr stabilneje wersije'', aby wužywał \"kwalitnu\" abo \"spoćetnu\" wersiju pó standarźe, pśekontrolěruj, lěc jo tam napšawdu take wersije w boku, howac to njezmějo mało wustatkowanja.",
	'stabilization-perm' => 'Twójo konto njama pšawo, aby změniło konfiguraciju stabilneje wersije. How su aktualne nastajenja za [[:$1|$1]]:',
	'stabilization-page' => 'Mě boka:',
	'stabilization-leg' => 'Nastajenja stabilneje wersije wobkšuśiś',
	'stabilization-select' => 'Wubraśe stabilneje wersije',
	'stabilization-select1' => 'Aktualna kwalitna wersija; jolic žedna njejo, ga slědna pśeglědana wersija',
	'stabilization-select2' => 'Slědna pśeglědana wersija, njeglědajucy na rowninu pśekontrolěrowanja',
	'stabilization-select3' => 'Slědna spócetna wersija; jolic žedna njejo, ga slědna kwalitna abo pśeglědana wersija',
	'stabilization-def' => 'Zwobraznjona wersija w standardnem bocnem naglěźe',
	'stabilization-def1' => 'Stabilna wersija; jolic žedna njejo, ga aktualna wersija',
	'stabilization-def2' => 'Aktualna wersija',
	'stabilization-restrict' => 'Wobgtranicowanja awtomatiskego pśekontrolěrowanja',
	'stabilization-restrict-none' => 'Žedne pśidatne wobgranicowanja',
	'stabilization-submit' => 'Wobkšuśiś',
	'stabilization-notexists' => 'Njejo bok z mjenim "[[:$1|$1]]".
Žedna konfiguracija móžno.',
	'stabilization-notcontent' => 'Bok "[[:$1|$1]]" njedajo se pśeglědaś.
Žedna konfiguracija móžno.',
	'stabilization-comment' => 'Pśicyna:',
	'stabilization-otherreason' => 'Druga pśicyna',
	'stabilization-expiry' => 'Pśepadnjo:',
	'stabilization-othertime' => 'Drugi cas',
	'stabilization-sel-short' => 'Priorita',
	'stabilization-sel-short-0' => 'Kwalita',
	'stabilization-sel-short-1' => 'Žedna',
	'stabilization-sel-short-2' => 'Spócetny',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktualny',
	'stabilization-def-short-1' => 'Stabilny',
	'stabilization-rest-short' => 'awtomatiska kontrola=$2',
	'stabilize_expiry_invalid' => 'Njpłaśiwy datum pśepadnjenja.',
	'stabilize_expiry_old' => 'Toś ten cas pśepadnjenja jo se južo minuł.',
	'stabilize-expiring' => 'pśepadnjo $1 (UTC)',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Dead3y3
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'stabilization-tab' => 'εξωνυχιστικός έλεγχος',
	'stabilization' => 'Σταθεροποίηση σελίδας',
	'stabilization-text' => "'''Αλλάξτε τις ρυθμίσεις παρακάτω για να ρυθμίσετε πως η σταθερή έκδοση της σελίδας [[:$1|$1]] επιλέγεται και εμφανίζεται.'''",
	'stabilization-perm' => 'Ο λογαριασμός σας δεν έχει δικαίωμα να αλλάξει την ρύθμιση σταθερής έκδοσης.
Εδώ είναι οι τρέχουσες ρυθμίσεις για τη σελίδα [[:$1|$1]]:',
	'stabilization-page' => 'Όνομα σελίδας:',
	'stabilization-leg' => 'Επιβεβαιώστε ρυθμίσεις σταθερής έκδοσης',
	'stabilization-select' => 'Επιλογή σταθερής έκδοσης',
	'stabilization-select1' => 'Η τελευταία αναθεώρηση ποιότητας· αν δεν είναι παρούσα, τότε η τελευταία ιδωμένη',
	'stabilization-select2' => 'Η τελευταία κριθείσα αναθεώρηση',
	'stabilization-select3' => 'Η τελευταία μη αλλοιωμένη αναθεώρηση· αν δεν είναι παρούσα, τότε η τελευταία ποιότητας ή ιδωμένη',
	'stabilization-def' => 'Αναθεώρηση εμφανιζόμενη στην προεπιλεγμένη εμφάνιση σελίδας',
	'stabilization-def1' => 'Η σταθερή αναθεώρηση· αν δεν είναι παρούσα, τότε η τρέχουσα',
	'stabilization-def2' => 'Η τρέχουσα αναθεώρηση',
	'stabilization-submit' => 'Επιβεβαίωση',
	'stabilization-notexists' => 'Δεν υπάρχει σελίδα αποκαλούμενη "[[:$1|$1]]".<br />
Δεν είναι δυνατή καμία ρύθμιση.',
	'stabilization-notcontent' => 'Η σελίδα "[[:$1|$1]]" δεν μπορεί να κριθεί.<br />
Δεν είναι δυνατή καμία ρύθμιση.',
	'stabilization-comment' => 'Λόγος:',
	'stabilization-otherreason' => 'Άλλος λόγος',
	'stabilization-expiry' => 'Λήγει:',
	'stabilization-othertime' => 'Άλλος χρόνος',
	'stabilization-sel-short' => 'Προτεραιότητα',
	'stabilization-sel-short-0' => 'Ποιότητα',
	'stabilization-sel-short-1' => 'Τίποτα',
	'stabilization-sel-short-2' => 'Μη αλλοίωση',
	'stabilization-def-short' => 'Προεπιλογή',
	'stabilization-def-short-0' => 'Τρέχουσα',
	'stabilization-def-short-1' => 'Σταθερή',
	'stabilize_expiry_invalid' => 'Άκυρη ημερομηνία λήξης.',
	'stabilize_expiry_old' => 'Η ημερομηνία λήξης έχει ήδη περάσει.',
	'stabilize-expiring' => 'λήγει στις $1 (UTC)',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'stabilization-tab' => 'kontroli',
	'stabilization' => 'Paĝa stabiligado',
	'stabilization-text' => "'''Ŝanĝu la subajn preferojn por modifi kiel la stabila versio de [[:\$1|\$1]] estas elektita kaj montrita.'''

Kiam ŝanĝante la konfiguro ''elekto de stabila versio'' por uzi \"bonkvalita\" aŭ \"netega\" revizioj defaŭlte,
certigu kontroli se ja estas tiaj revizioj en la paĝo, aŭ la ŝanĝo efikos preskaŭ neniom.",
	'stabilization-perm' => 'Via konto ne rajtas ŝanĝi la konfiguron de stabila versio.
Jen la nunaj preferoj por [[:$1|$1]]:',
	'stabilization-page' => 'Paĝnomo:',
	'stabilization-leg' => 'Konfirmi konfiguron de stabila versio',
	'stabilization-select' => 'Elektado de stabila versio',
	'stabilization-select1' => 'La lasta bonkvalita versio; se ĝi ne ekzistas, tiel la lasta reviziita versio.',
	'stabilization-select2' => 'La lasta kontrolita versio',
	'stabilization-select3' => 'La lasta netega versio; se ne estanta, la lasta bonkvalita aŭ reviziita versio.',
	'stabilization-def' => 'Versio montrita en defaŭlta paĝa vido',
	'stabilization-def1' => 'La stabila versio;
se ĝi ne ekzistas, la nuna versio',
	'stabilization-def2' => 'La nuna versio:',
	'stabilization-submit' => 'Konfirmi',
	'stabilization-notexists' => 'Neniu paĝo estas nomata "[[:$1|$1]]".
Neniu konfiguro estas farebla.',
	'stabilization-notcontent' => 'La paĝo "[[:$1|$1]]" ne estas kontrolebla.
Neniu konfiguro eblas.',
	'stabilization-comment' => 'Kialo:',
	'stabilization-otherreason' => 'Alia kialo',
	'stabilization-expiry' => 'Fintempo:',
	'stabilization-othertime' => 'Alia tempo',
	'stabilization-sel-short' => 'Prioritato',
	'stabilization-sel-short-0' => 'Kvalito',
	'stabilization-sel-short-1' => 'Neniu',
	'stabilization-sel-short-2' => 'Netega',
	'stabilization-def-short' => 'Defaŭlta',
	'stabilization-def-short-0' => 'Nuna',
	'stabilization-def-short-1' => 'Stabila',
	'stabilize_expiry_invalid' => 'Nevalida findato.',
	'stabilize_expiry_old' => 'Ĉi tiu findato jam estas pasita.',
	'stabilize-expiring' => 'findato $1 (UTC)',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Drini
 * @author Imre
 * @author Kobazulo
 * @author Sanbec
 */
$messages['es'] = array(
	'stabilization-tab' => 'vetar',
	'stabilization' => 'Estabilización de página',
	'stabilization-text' => "'''Cambiar las configuraciones de abajo para ajustar como la versión estable de [[:\$1|\$1]] es seleccionada y mostrada.'''

Cuando cambie la configuración de ''selección de versión estable'' usar revisiones de \"calidad\" o \"prístina\" por defecto,
asegúrese de verificar si hay realmente tales revisiones en la página, de otra manera se afectará ligeramente.",
	'stabilization-perm' => 'Su cuenta no tiene permiso para cambiar la configuración de la versión estable. Aquí están las configuraciones actuales para [[:$1|$1]]:',
	'stabilization-page' => 'Nombre de la página:',
	'stabilization-leg' => 'Confirmar la configuración de la versión estable',
	'stabilization-select' => 'Selección de versión estable',
	'stabilization-select2' => 'La última versión verificada, a pesar del nivel de validación',
	'stabilization-def' => 'Revisión mostrada en la vista de página por defecto',
	'stabilization-def2' => 'La actual revisión',
	'stabilization-restrict' => 'Restricciones de autorevisión',
	'stabilization-restrict-none' => 'Sin restricciones extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'No hay una página llamada "[[:$1|$1]]".
La configuración no es posible.',
	'stabilization-notcontent' => 'La página "[[:$1|$1]]" no puede ser revisada.
La configuración no es posible.',
	'stabilization-comment' => 'Razón:',
	'stabilization-otherreason' => 'Otra razón',
	'stabilization-expiry' => 'Expira:',
	'stabilization-othertime' => 'Otra vez',
	'stabilization-sel-short' => 'Precedencia',
	'stabilization-sel-short-0' => 'Calidad',
	'stabilization-sel-short-1' => 'Ninguno',
	'stabilization-sel-short-2' => 'Prístina',
	'stabilization-def-short' => 'Por defecto',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Estable',
	'stabilization-rest-short' => 'autorevisión=$1',
	'stabilize_expiry_invalid' => 'La fecha de caducidad no es válida.',
	'stabilize_expiry_old' => 'Este tiempo de expiración ya ha pasado',
	'stabilize-expiring' => 'caduca el $1 (UTC)',
);

/** Estonian (Eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'stabilization-submit' => 'Kinnita',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'stabilization' => 'Orrialdearen egonkortzea',
	'stabilization-page' => 'Orrialdearen izenburua:',
	'stabilization-leg' => 'Bertsio egonkorraren konfigurazioa berretsi',
	'stabilization-select' => 'Bertsio egonkorraren aukeraketa',
	'stabilization-submit' => 'Berretsi',
	'stabilization-comment' => 'Arrazoia:',
	'stabilization-expiry' => 'Epemuga:',
	'stabilization-sel-short-0' => 'Kalitatea',
	'stabilization-def-short' => 'Lehenetsia',
	'stabilization-def-short-0' => 'Oraingoa',
	'stabilization-def-short-1' => 'Egonkorra',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'stabilization-page' => 'Nombri la páhina:',
	'stabilization-submit' => 'Confirmal',
	'stabilization-sel-short-1' => 'Dengunu',
	'stabilization-def-short' => 'Defeutu',
	'stabilization-def-short-0' => 'Atual',
);

/** Persian (فارسی)
 * @author Huji
 * @author Momeni
 */
$messages['fa'] = array(
	'stabilization-tab' => '(کک)',
	'stabilization' => 'پایدارسازی صفحه‌ها',
	'stabilization-text' => "'''تغییر تنظیمات زیر به منظور تعیین این که نسخه پایدار [[:$1|$1]] چگونه انتخاب و نمایش داده می‌شود.'''",
	'stabilization-perm' => 'حساب شما اجازه تغییر تنظیمات نسخه پایدار را ندارد.
تنظیمات فعلی برای [[:$1|$1]] چنین هستند:',
	'stabilization-page' => 'نام صفحه:',
	'stabilization-leg' => 'تایید تنظیمات نسخهٔ پایدار',
	'stabilization-select' => 'انتخاب نسخهٔ پایدار',
	'stabilization-select1' => 'آخرین نسخه با کیفیت، یا در صورت عدم وجود آن، آخرین نسخه بررسی شده',
	'stabilization-select2' => 'آخرین نسخه بررسی شده',
	'stabilization-select3' => 'آخرین نسخهٔ دست نخورده؛ در صورت عدم وجود، آخرین نسخهٔ با کیفیت یا بررسی شده',
	'stabilization-def' => 'نسخه‌ای که در حالت پیش‌فرض نمایش داده می‌شود',
	'stabilization-def1' => 'نسخه پایدار، یا در صورت عدم وجود، نسخه فعلی',
	'stabilization-def2' => 'نسخه فعلی',
	'stabilization-submit' => 'تائید',
	'stabilization-notexists' => 'صفحه‌ای با عنوان «[[:$1|$1]]» وجود ندارد. تنظیمات ممکن نیست.',
	'stabilization-notcontent' => 'صفحه «[[:$1|$1]]» قابل بررسی نیست. تنظیمات ممکن نیست.',
	'stabilization-comment' => 'توضیح:',
	'stabilization-otherreason' => 'دلیل دیگر',
	'stabilization-expiry' => 'انقضا:',
	'stabilization-othertime' => 'زمان دیگر',
	'stabilization-sel-short' => 'تقدم',
	'stabilization-sel-short-0' => 'با کیفیت',
	'stabilization-sel-short-1' => 'هیچ',
	'stabilization-sel-short-2' => 'دست نخورده',
	'stabilization-def-short' => 'پیش‌فرض',
	'stabilization-def-short-0' => 'فعلی',
	'stabilization-def-short-1' => 'پایدار',
	'stabilize_expiry_invalid' => 'تاریخ انقضای غیرمجاز',
	'stabilize_expiry_old' => 'این تاریخ انقضا همینک سپری شده‌است.',
	'stabilize-expiring' => 'در $1 (UTC) منقضی می‌شود.',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'stabilization-page' => 'Sivun nimi',
	'stabilization-select2' => 'Uusin arvioitu versio',
	'stabilization-def2' => 'Nykyinen versio',
	'stabilization-submit' => 'Vahvista',
	'stabilization-comment' => 'Kommentti',
	'stabilization-sel-short-0' => 'Laatu',
	'stabilization-def-short' => 'Oletus',
	'stabilization-def-short-0' => 'Nykyinen',
	'stabilization-def-short-1' => 'Vakaa',
);

/** French (Français)
 * @author ChrisPtDe
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Juanpabl
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'stabilization-tab' => '(aq)',
	'stabilization' => 'Stabilisation de la page',
	'stabilization-text' => "'''Modifiez les paramètres ci-dessous pour définir la façon dont la version stable de [[:$1|$1]] est sélectionnée et affichée.'''

Lorsque vous configurez la ''sélection de la version stable'' pour utiliser les révisions « de qualité » ou « initiales » par défaut, assurez-vous qu'il y a effectivement de telles révisions dans la page, sinon les modifications n'auront pas d'incidence.",
	'stabilization-perm' => "Votre compte n'a pas les droits pour changer les paramètres de la version stable. Voici les paramètres courants de [[:$1|$1]] :",
	'stabilization-page' => 'Nom de la page :',
	'stabilization-leg' => 'Confirmer le paramétrage de la version stable',
	'stabilization-select' => 'Sélection de la version stable',
	'stabilization-select1' => 'La dernière version de qualité, sinon la dernière version vue',
	'stabilization-select2' => 'La dernière version révisée, sans tenir compte du niveau de validation',
	'stabilization-select3' => 'La dernière version intacte ; en cas d’absence, la dernière de qualité ou relue.',
	'stabilization-def' => "Version affichée lors de l'affichage par défaut de la page",
	'stabilization-def1' => 'La version stable, sinon la version courante',
	'stabilization-def2' => 'La version courante',
	'stabilization-restrict' => 'Revoir automatiquement les restrictions',
	'stabilization-restrict-none' => 'Pas de restriction supplémentaire',
	'stabilization-submit' => 'Confirmer',
	'stabilization-notexists' => "Il n'y a pas de page « [[:$1|$1]] », pas de paramétrage possible",
	'stabilization-notcontent' => 'La page « [[:$1|$1]] » ne peut être révisée, pas de paramétrage possible',
	'stabilization-comment' => 'Raison :',
	'stabilization-otherreason' => 'Autre raison',
	'stabilization-expiry' => 'Expire :',
	'stabilization-othertime' => 'Autre temps',
	'stabilization-sel-short' => 'Priorité',
	'stabilization-sel-short-0' => 'Qualité',
	'stabilization-sel-short-1' => 'Nulle',
	'stabilization-sel-short-2' => 'Intacte',
	'stabilization-def-short' => 'Défaut',
	'stabilization-def-short-0' => 'Courante',
	'stabilization-def-short-1' => 'Stable',
	'stabilization-rest-short' => 'révision automatique=$1',
	'stabilize_expiry_invalid' => "Date d'expiration invalide.",
	'stabilize_expiry_old' => "Cette durée d'expiration est déjà écoulée.",
	'stabilize-expiring' => 'Expire le $1 (UTC)',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'stabilization-tab' => '(aq)',
	'stabilization' => 'Stabilisacion de la pâge',
	'stabilization-text' => "'''Changiér los paramètres ce-desot por ajustar l’afichâjo et la sèlèccion de la vèrsion stâbla de [[:$1|$1]].'''",
	'stabilization-perm' => 'Voutron compto at pas los drêts por changiér los paramètres de la vèrsion stâbla. Vê-que los paramètres corents de [[:$1|$1]] :',
	'stabilization-page' => 'Nom de la pâge :',
	'stabilization-leg' => 'Paramètrar la vèrsion stâbla d’una pâge',
	'stabilization-select' => 'Coment la vèrsion stâbla est chouèsia/cièrdua',
	'stabilization-select1' => 'La dèrriére vèrsion de qualitât, ôtrament la dèrriére vèrsion vua',
	'stabilization-select2' => 'La dèrriére vèrsion vua',
	'stabilization-def' => 'Vèrsion afichiê pendent l’afichâjo per dèfôt de la pâge',
	'stabilization-def1' => 'La vèrsion stâbla, ôtrament la vèrsion corenta',
	'stabilization-def2' => 'La vèrsion corenta',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Y at pas de pâge « [[:$1|$1]] », pas de paramètrâjo possiblo.',
	'stabilization-notcontent' => 'La pâge « [[:$1|$1]] » pôt pas étre rèvisâ, pas de paramètrâjo possiblo.',
	'stabilization-comment' => 'Comentèro :',
	'stabilization-expiry' => 'Èxpire :',
	'stabilization-sel-short' => 'Prioritât',
	'stabilization-sel-short-0' => 'Qualitât',
	'stabilization-sel-short-1' => 'Nula',
	'stabilization-def-short' => 'Dèfôt',
	'stabilization-def-short-0' => 'Corenta',
	'stabilization-def-short-1' => 'Stâbla',
	'stabilize_expiry_invalid' => 'Dâta d’èxpiracion envalida.',
	'stabilize_expiry_old' => 'Cél temps d’èxpiracion est ja passâ.',
	'stabilize-expiring' => 'èxpire lo $1 (UTC)',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'stabilization-page' => 'Sidenamme:',
	'stabilization-comment' => 'Oanmerking:',
	'stabilization-sel-short-1' => 'Gjin',
	'stabilization-def-short' => 'Standert',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'stabilization-comment' => 'Nóta tráchta:',
	'stabilization-sel-short-1' => 'Faic',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'Estabilización da páxina',
	'stabilization-text' => "'''Mude a configuración a continuación para axustar a forma na que a versión estábel de \"[[:\$1|\$1]]\" é seleccionada e mostrada.'''

Ao cambiar a configuración da ''selección da versión estábel'' para usar as revisións de \"calidade\" ou unha \"previa\" por defecto,
asegúrese de comprobar se en realidade existen tales revisións na páxina, pola contra o cambio afectará lixeiramente.",
	'stabilization-perm' => 'A súa conta non ten permisos para mudar a configuración da versión estábel.
	Esta é a configuración actual para [[:$1|$1]]:',
	'stabilization-page' => 'Nome da páxina:',
	'stabilization-leg' => 'Confirmar as configuración da versión estábel',
	'stabilization-select' => 'Selección da versión estábel',
	'stabilization-select1' => 'A última revisión de calidade; se non existe, entón a última revisada',
	'stabilization-select2' => 'A última revisión revisada, malia o nivel de validación',
	'stabilization-select3' => 'A última revisión previa; se non existe, entón a última de calidade ou revisada',
	'stabilization-def' => 'Revisión que aparece por defecto na vista da páxina',
	'stabilization-def1' => 'A revisión estábel, se non presente, entón a actual',
	'stabilization-def2' => 'A revisión actual',
	'stabilization-restrict' => 'Revisar automaticamente as restricións',
	'stabilization-restrict-none' => 'Sen restricións extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Non hai unha páxina chamada "[[:$1|$1]]". A non configuración é posíbel.',
	'stabilization-notcontent' => 'A páxina "[[:$1|$1]]" non pode ser revisada. A non configuración é posíbel.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Outro motivo',
	'stabilization-expiry' => 'Caducidade:',
	'stabilization-othertime' => 'Outro tempo',
	'stabilization-sel-short' => 'Precedencia',
	'stabilization-sel-short-0' => 'Calidade',
	'stabilization-sel-short-1' => 'Ningún',
	'stabilization-sel-short-2' => 'Intacto',
	'stabilization-def-short' => 'Por defecto',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Estábel',
	'stabilization-rest-short' => 'revisión automática=$1',
	'stabilize_expiry_invalid' => 'Data non válida de caducidade.',
	'stabilize_expiry_old' => 'O tempo de caducidade xa pasou.',
	'stabilize-expiring' => 'caduca o $2 ás $3 (UTC)',
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
	'stabilization-expiry' => 'Λήγει:',
	'stabilization-sel-short' => 'Προτεραιότης',
	'stabilization-sel-short-0' => 'ποιοτικὴ',
	'stabilization-sel-short-1' => 'Οὐδέν',
	'stabilization-sel-short-2' => 'Ἀνέπαφος',
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
	'stabilization-text' => "'''Tue d Yystellige ändere fir zum feschtzlege, wie di aagluegt Version vu „[[:\$1|\$1]]“ usgwehlt un aazeigt soll wäre.'''

Wänn d Konfigieration vu dr ''Uuswahl vu dr Aagluegte Versione'' gändertet wird go \"priefti\" oder \"reini\" 
Versione as Standard z neh, stell sicher, ass es aktuäll sonigi Versione git, sunscht het s keini großi Uuswirkig.",
	'stabilization-perm' => 'Du hesch nid d Berächtigung, zum die Yystellige vu dr aagluegte Version z ändere.
Di aktuällen Yystellige fir „[[:$1|$1]]“ sin:',
	'stabilization-page' => 'Sytename:',
	'stabilization-leg' => 'Yystellige vu dr aagluegte Version fir e Syte',
	'stabilization-select' => 'Uswahl vu dr aagluegte Version',
	'stabilization-select1' => 'Di letscht prieft Version; wänn s keini het, no di letscht gsichtet Version',
	'stabilization-select2' => 'Di letscht Version, wu vum Fäldhieter gsäh isch, uuabhängig vu dr Validierugsebeni',
	'stabilization-select3' => 'Di letscht urspringlig Version; wänn s keini het, derno di letscht Version, wu vum Fäldhieter gsäh oder prieft isch',
	'stabilization-def' => 'Version, wu in dr normale Syteaasicht aazeigt wird',
	'stabilization-def1' => 'D Version, wu vum Fäldhieter gsäh isch; wänn s keini het, derno di aktuäll Version',
	'stabilization-def2' => 'Di aktuäll Version',
	'stabilization-restrict' => 'Auto-Review-Yyschränkige',
	'stabilization-restrict-none' => 'Keini extra Yyschränkige',
	'stabilization-submit' => 'Bstätige',
	'stabilization-notexists' => 'Es git kei Syte „[[:$1|$1]]“. Kei Yystellige megli.',
	'stabilization-notcontent' => 'D Syte „[[:$1|$1]]“ cha nit vum Fäldhieter gsäh wäre. E Konfiguration isch nid megli.',
	'stabilization-comment' => 'Grund:',
	'stabilization-otherreason' => 'Andere Grund',
	'stabilization-expiry' => 'Giltig bis:',
	'stabilization-othertime' => 'Anderi Zyt',
	'stabilization-sel-short' => 'Priorität',
	'stabilization-sel-short-0' => 'Qualität',
	'stabilization-sel-short-1' => 'keini',
	'stabilization-sel-short-2' => 'urspringli',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktuäll',
	'stabilization-def-short-1' => 'Vum Fäldhieter gsäh',
	'stabilization-rest-short' => 'autoreview=$1',
	'stabilize_expiry_invalid' => 'Nid giltigs Ablaufdatum.',
	'stabilize_expiry_old' => 'S Ablaufdatum isch iberschritte wore.',
	'stabilize-expiring' => 'erlischt $1 (UTC)',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'stabilization-def-short' => 'Paʻamau',
);

/** Hebrew (עברית)
 * @author DoviJ
 * @author Ori229
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'stabilization-tab' => 'נבדק',
	'stabilization' => 'התייצבות הדף',
	'stabilization-text' => "'''שנו את ההגדרות שלהלן כדי לשנות את אופני בחירתה והצגתה של הגרסה היציבה של [[:\$1|\$1]].'''

בעת השינוי ההגדרות של '''בחירת גרסה יציבה''' כך שייעשה שימוש בגרסאות \"איכותיות\" או \"מושלמות\" כברירת מחדל,
אנא ודאו שבאמת קיימות גרסאות כאלה בדף, אחרת לא תהיה לכך השפעה רבה.",
	'stabilization-perm' => 'אין לכם הרשאה לשנות את תצורת הגרסה היציבה.
להלן ההגדרות הנוכחיות עבור [[:$1|$1]]:',
	'stabilization-page' => 'שם הדף:',
	'stabilization-leg' => 'אנא אשרו את הגדרות הגרסה היציבה',
	'stabilization-select' => 'בחירת גרסה יציבה',
	'stabilization-select1' => 'הגרסה האיכותית האחרונה; אם לא קיימת, הגרסה הנצפית האחרונה',
	'stabilization-select2' => 'הגרסה האחרונה שנבדקה, ללא קשר לרמת האימות',
	'stabilization-select3' => 'הגרסה המושלמת האחרונה; אם לא קיימת, הגרסה האיכותית או הנצפית האחרונה',
	'stabilization-def' => 'הגרסה המופיעה כברירת מחדל',
	'stabilization-def1' => 'הגרסה היציבה; אם לא קיימת, הגרסה הנוכחית',
	'stabilization-def2' => 'הגרסה הנוכחית',
	'stabilization-restrict' => 'הגבלות על בדיקה אוטומטית',
	'stabilization-restrict-none' => 'אין הגבלות נוספות',
	'stabilization-submit' => 'אישור',
	'stabilization-notexists' => 'אין דף בשם "[[:$1|$1]]".
לא ניתן לבצע תצורה.',
	'stabilization-notcontent' => 'אין אפשרות לבדוק את הדף "[[:$1|$1]]".
לא ניתן לבצע תצורה.',
	'stabilization-comment' => 'סיבה:',
	'stabilization-otherreason' => 'סיבה אחרת',
	'stabilization-expiry' => 'פקיעה:',
	'stabilization-othertime' => 'זמן פקיעה אחר',
	'stabilization-sel-short' => 'קדימות',
	'stabilization-sel-short-0' => 'איכות',
	'stabilization-sel-short-1' => 'לא קיים',
	'stabilization-sel-short-2' => 'מושלם',
	'stabilization-def-short' => 'ברירת מחדל',
	'stabilization-def-short-0' => 'נוכחי',
	'stabilization-def-short-1' => 'יציב',
	'stabilization-rest-short' => 'בדיקה אוטומטית=$1',
	'stabilize_expiry_invalid' => 'תאריך הפקיעה אינו תקין.',
	'stabilize_expiry_old' => 'תאריך הפקיעה כבר עבר.',
	'stabilize-expiring' => 'פקיעה: $1 (UTC)',
);

/** Hindi (हिन्दी)
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
	'stabilization-select' => 'स्थिर अवतरण का चुनाव',
	'stabilization-select1' => 'नवीनतम गुणवत्तापूर्ण अवतरण;
अगर उपलब्ध नहीं हैं, तो नवीनतम चुना हुआ अवतरण',
	'stabilization-select2' => 'नवीनतम परिक्षण हुआ अवतरण',
	'stabilization-select3' => 'नवीनतम उत्कृष्ठ अवतरण; अगर उपलब्ध नहीं हैं, तो नवीनतम गुणवत्तापूर्ण या चुना हुआ अवतरण',
	'stabilization-def' => 'डिफॉल्ट पन्ने के साथ बदलाव दर्शायें गयें हैं',
	'stabilization-def1' => 'स्थिर अवतरण;
अगर नहीं हैं, तो सद्य',
	'stabilization-def2' => 'सद्य अवतरण',
	'stabilization-submit' => 'निश्चित करें',
	'stabilization-notexists' => '"[[:$1|$1]]" इस नामका पृष्ठ अस्तित्वमें नहीं हैं।
बदलाव नहीं किये जा सकतें।',
	'stabilization-notcontent' => '"[[:$1|$1]]" यह पृष्ठ जाँचा नहीं जा सकता।
बदलाव नहीं किये जा सकतें।',
	'stabilization-comment' => 'टिप्पणी:',
	'stabilization-expiry' => 'समाप्ति:',
	'stabilization-sel-short' => 'अनुक्रम',
	'stabilization-sel-short-0' => 'गुणवत्ता',
	'stabilization-sel-short-1' => 'बिल्कुल नहीं',
	'stabilization-sel-short-2' => 'उत्कृष्ठ',
	'stabilization-def-short' => 'डिफॉल्ट',
	'stabilization-def-short-0' => 'सद्य',
	'stabilization-def-short-1' => 'स्थिर',
	'stabilize_expiry_invalid' => 'गलत समाप्ति तिथी।',
	'stabilize_expiry_old' => 'यह समाप्ति तिथी गुजर चुकी हैं।',
	'stabilize-expiring' => '$1 (UTC) को समाप्ति',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'stabilization-tab' => '(vi)',
	'stabilization' => 'Stabilizacija stranice',
	'stabilization-text' => "'''Promijeni postavke kako će se važeća inačica članka [[:$1|$1]] prikazivati.'''",
	'stabilization-perm' => 'Vaš suradnički račun nema prava mijenjanja stabilne inačice članka.
Slijede važeće postavke za [[:$1|$1]]:',
	'stabilization-page' => 'Ime stranice:',
	'stabilization-leg' => "Odredi važeću (''stabilnu'') inačicu članka",
	'stabilization-select' => 'Kako je odabrana stabilna verzija',
	'stabilization-select1' => 'Posljednja ocjena kvalitete; ukoliko je nije bilo, posljednje pregledavanje',
	'stabilization-select2' => 'Posljednja ocijenjena inačica',
	'stabilization-def' => "Odabir inačice koja se prikazuje po ''defaultu''",
	'stabilization-def1' => 'Stabilna inačica; ako je nema, trenutna',
	'stabilization-def2' => 'Tekuća inačica',
	'stabilization-submit' => 'Potvrdite',
	'stabilization-notexists' => 'Ne postoji stranica "[[:$1|$1]]", te stoga nije moguće namještanje postavki za tu stranicu.',
	'stabilization-notcontent' => 'Stranica "[[:$1|$1]]" ne može biti ocijenjena. Namještanje postavki nije moguće.',
	'stabilization-comment' => 'Komentar:',
	'stabilization-expiry' => 'Istječe:',
	'stabilization-sel-short' => 'Prvenstvo',
	'stabilization-sel-short-0' => 'Kvaliteta',
	'stabilization-sel-short-1' => 'Nema',
	'stabilization-def-short' => 'Uobičajeno',
	'stabilization-def-short-0' => 'Tekući',
	'stabilization-def-short-1' => 'Važeća inačica',
	'stabilize_expiry_invalid' => 'Neispravan dan isticanja.',
	'stabilize_expiry_old' => 'Ovo vrijeme isticanja je već prošlo',
	'stabilize-expiring' => 'ističe $1 (UTC)',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'stabilization-tab' => '(Kwalitne zawěsćenje)',
	'stabilization' => 'Stabilizacija strony',
	'stabilization-text' => "'''Změń slědowace nastajenja, zo by postajił, kak so stabilna wersija wot [[:\$1|\$1]] wuběra a zwobraznja.'''

Hdyž konfiguraciju ''wuběra stabilneje wersije'' změniš, zo by \"kwalitnu\" abo \"prěnjotnu\" wersiju po standardźe wužiwał, skontroluj, hač su woprawdźe tajke wersije w stronje, hewak změje mało wuskutka.",
	'stabilization-perm' => 'Twoje wužiwarske konto nima trěbne prawo, zo by nastajenja stabilneje wersije změniło.
	Aktualne nastajenja za „[[:$1|$1]]“ su:',
	'stabilization-page' => 'Mjeno strony:',
	'stabilization-leg' => 'Nastajenja za stabilnu wersiju potwjerdźić',
	'stabilization-select' => 'Wuběr stabilneje wersije',
	'stabilization-select1' => 'Poslednja pruwowana wersija; jeli žana njeje, potom poslednja přehladana wersija',
	'stabilization-select2' => 'Poslednja přepruwowana wersija, njedźiwajo na runinu přepruwowanja',
	'stabilization-select3' => 'Poslednja prěnjotna wersija; jeli njeeksistuje, da poslednja přepruwowana abo přehladana wersiaj',
	'stabilization-def' => 'Wersija zwobraznjena w normalnym napohledźe strony',
	'stabilization-def1' => 'Stabilna wersija',
	'stabilization-def2' => 'Aktualna wersija',
	'stabilization-restrict' => 'Wobmjezowanja awtomatiskeho přepruwowanja',
	'stabilization-restrict-none' => 'Žane přidatne wobmjezowanja',
	'stabilization-submit' => 'Potwjerdźić',
	'stabilization-notexists' => 'Njeje strona „[[:$1|$1]]“. Žana konfiguracija móžno.',
	'stabilization-notcontent' => 'Strona "[[:$1|$1]]" njeda so pruwować. Žana konfiguracija móžno.',
	'stabilization-comment' => 'Přičina:',
	'stabilization-otherreason' => 'Druha přičina',
	'stabilization-expiry' => 'Spadnje:',
	'stabilization-othertime' => 'Druhi čas',
	'stabilization-sel-short' => 'Priorita',
	'stabilization-sel-short-0' => 'Kwalita',
	'stabilization-sel-short-1' => 'Žana',
	'stabilization-sel-short-2' => 'Prěnjotny',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktualny',
	'stabilization-def-short-1' => 'Stabilny',
	'stabilization-rest-short' => 'awtomatiska kontrola=$1',
	'stabilize_expiry_invalid' => 'Njepłaćiwy datum spadnjenja.',
	'stabilize_expiry_old' => 'Tutón čas spadnjenja je hižo zańdźeny.',
	'stabilize-expiring' => 'spadnje $1 hodź. (UTC)',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Gondnok
 * @author KossuthRad
 * @author Samat
 */
$messages['hu'] = array(
	'stabilization-tab' => '(qa)',
	'stabilization' => 'Lap rögzítése',
	'stabilization-text' => "'''Az alábbi beállítások módosításával állíthatod be, hogy a(z) [[:$1|$1]] melyik változata jelenjen meg az olvasók számára.'''",
	'stabilization-perm' => 'Nincs jogosultságod megváltoztatni a rögzített változat beállításait.
A(z) [[:$1|$1]] lapra vonatkozó jelenlegi beállítások:',
	'stabilization-page' => 'A lap címe:',
	'stabilization-leg' => 'Elfogadott változat beállításainak megerősítése',
	'stabilization-select' => 'Az elfogadott változat kiválasztása',
	'stabilization-select1' => 'A legutolsó kiemelt változat; ha nincs, akkor a legutolsó megtekintett változat',
	'stabilization-select2' => 'A legutolsó megtekintett változat',
	'stabilization-select3' => 'A legutolsó legjobb változat; ha nincs, akkor a legutolsó kiemelt vagy megtekintett',
	'stabilization-def' => 'Az alapértelmezettként megjelenített változat',
	'stabilization-def1' => 'A jelölt változat; ha nincs, akkor a legutolsó',
	'stabilization-def2' => 'A legutolsó változat',
	'stabilization-submit' => 'Megerősítés',
	'stabilization-notexists' => 'Nincs „[[:$1|$1]]” című lap.
Nem lehet a beállításokat módosítani.',
	'stabilization-notcontent' => 'A(z) „[[:$1|$1]]” című lapot nem ellenőrizni.
Nem lehet a beállításokat módosítani.',
	'stabilization-comment' => 'Indok:',
	'stabilization-otherreason' => 'Egyéb indok',
	'stabilization-expiry' => 'Lejárat:',
	'stabilization-sel-short' => 'Precendencia',
	'stabilization-sel-short-0' => 'minőségi',
	'stabilization-sel-short-1' => 'nincs',
	'stabilization-sel-short-2' => 'eredeti',
	'stabilization-def-short' => 'Alapértelmezett',
	'stabilization-def-short-0' => 'legutolsó',
	'stabilization-def-short-1' => 'elfogadott',
	'stabilize_expiry_invalid' => 'Hibás lejárati idő.',
	'stabilize_expiry_old' => 'A megadott lejárati idő már elmúlt.',
	'stabilize-expiring' => 'lejár $1-kor (UTC szerint)',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'stabilization-tab' => 'rev',
	'stabilization' => 'Stabilisation de paginas',
	'stabilization-text' => "'''Cambia le configurationes infra pro adjustar como le version stabile de [[:\$1|\$1]] es seligite e monstrate.'''

Si tu cambia le configuration ''selection de version stabile'' a usar per predefinition le versiones \"de qualitate\" o \"pristine\", sia secur de verificar si existe de facto tal versiones del pagina, alteremente le cambio habera pauc effecto.",
	'stabilization-perm' => 'Tu conto non ha le permission de cambiar le configuration de versiones stabile.
Ecce le configurationes actual pro [[:$1|$1]]:',
	'stabilization-page' => 'Nomine del pagina:',
	'stabilization-leg' => 'Confirmar configurationes de version stabile',
	'stabilization-select' => 'Selection de version stabile',
	'stabilization-select1' => 'Le ultime version de qualitate; si non presente, le ultime version revidite',
	'stabilization-select2' => 'Le ultime version revidite',
	'stabilization-select3' => 'Le ultime version pristine; si non presente, le ultime version de qualitate o revidite',
	'stabilization-def' => 'Version monstrate in visualisation predefinite de pagina',
	'stabilization-def1' => 'Le version stabile; si non presente, le version actual',
	'stabilization-def2' => 'Le version actual',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'Non existe un pagina con titulo "[[:$1|$1]]".
Nulle configuration es possibile.',
	'stabilization-notcontent' => 'Le pagina "[[:$1|$1]]" non pote esser revidite.
Nulle configuration es possibile.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Altere motivo',
	'stabilization-expiry' => 'Expira:',
	'stabilization-othertime' => 'Altere tempore',
	'stabilization-sel-short' => 'Precedentia',
	'stabilization-sel-short-0' => 'Qualitate',
	'stabilization-sel-short-1' => 'Nulle',
	'stabilization-sel-short-2' => 'Pristine',
	'stabilization-def-short' => 'Predefinition',
	'stabilization-def-short-0' => 'Actual',
	'stabilization-def-short-1' => 'Stabile',
	'stabilize_expiry_invalid' => 'Data de expiration invalide.',
	'stabilize_expiry_old' => 'Iste tempore de expiration ha ja passate.',
	'stabilize-expiring' => 'expira le $1 (UTC)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'stabilization-tab' => 'cek',
	'stabilization' => 'Pengaturan versi stabil halaman',
	'stabilization-text' => "'''Konfigurasi pengaturan untuk menampilkan dan memilih versi stabil dari [[:$1|$1]].'''",
	'stabilization-perm' => 'Akun Anda tak memiliki hak untuk mengganti konfigurasi versi stabil. Berikut konfigurasi terkini dari [[:$1|$1]]:',
	'stabilization-page' => 'Nama halaman:',
	'stabilization-leg' => 'Konfirmasi konfigurasi versi stabil',
	'stabilization-select' => 'Pemilihan versi stabil',
	'stabilization-select1' => 'Revisi layak terakhir; jika tak ada, versi terperiksa terakhir',
	'stabilization-select2' => 'Revisi stabil terakhir',
	'stabilization-select3' => 'Revisi asli terakhir; jika tidak ada, versi layak atau terperiksa terakhir',
	'stabilization-def' => 'Revisi yang ditampilkan sebagai tampilan baku halaman',
	'stabilization-def1' => 'Revisi stabil; jika tak ada, revisi terkini',
	'stabilization-def2' => 'Revisi terkini',
	'stabilization-submit' => 'Konfirmasi',
	'stabilization-notexists' => 'Tak ada halaman berjudul "[[:$1|$1]]".
Konfigurasi tak dapat diterapkan.',
	'stabilization-notcontent' => 'Halaman "[[:$1|$1]]" tak dapat ditinjau.
Konfigurasi tak dapat diterapkan.',
	'stabilization-comment' => 'Komentar:',
	'stabilization-expiry' => 'Kadaluwarsa:',
	'stabilization-sel-short' => 'Pengutamaan',
	'stabilization-sel-short-0' => 'Layak',
	'stabilization-sel-short-1' => 'Tak ada',
	'stabilization-sel-short-2' => 'Asli',
	'stabilization-def-short' => 'Baku',
	'stabilization-def-short-0' => 'Terkini',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Tanggal kadaluwarsa tak valid.',
	'stabilize_expiry_old' => 'Tanggal kadaluwarsa telah terlewati.',
	'stabilize-expiring' => 'kadaluwarsa $1 (UTC)',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'stabilization-page' => 'Titill síðu:',
	'stabilization-submit' => 'Staðfesta',
	'stabilization-comment' => 'Athugasemd:',
	'stabilization-sel-short-0' => 'Gæði',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 */
$messages['it'] = array(
	'stabilization' => 'Stabilizzazione pagina',
	'stabilization-text' => "'''Modifica le impostazioni sotto per regolare come la versione stabile di [[:\$1|\$1]] è selezionata e visualizzata.'''

Quando cambi la configurazione ''selezione versione stabile'' per usare di default le revisioni \"qualità\" o \"immacolata\",
assicurati di controllare se effettivamente ci siano nella pagina tali revisioni, altrimenti la modifica non avrà molto effetto.",
	'stabilization-perm' => "L'utente non dispone dei permessi necessari a cambiare la configurazione della versione stabile.
Qui ci sono le impostazioni attuali per [[:$1|$1]]:",
	'stabilization-page' => 'Nome della pagina:',
	'stabilization-leg' => 'Conferma le impostazioni della versione stabile',
	'stabilization-select' => 'Selezione versione stabile',
	'stabilization-select1' => "L'ultima versione di qualità; se non presente, allora l'ultima visionata",
	'stabilization-select2' => "L'ultima versione revisionata, indipendentemente dal livello di validazione",
	'stabilization-def' => 'Revisione visualizzata di default alla visita della pagina',
	'stabilization-def1' => 'La versione stabile; se non presente, quella attuale',
	'stabilization-def2' => 'La versione attuale',
	'stabilization-restrict' => "Restrizioni sull'auto-revisione",
	'stabilization-restrict-none' => "Nessun'ulteriore restrizione",
	'stabilization-submit' => 'Conferma',
	'stabilization-notexists' => 'Non ci sono pagine col titolo "[[:$1|$1]]".
Non è possibile effettuare la configurazione.',
	'stabilization-notcontent' => 'La pagina "[[:$1|$1]]" non può essere revisionata.
Non è possibile effettuare la configurazione.',
	'stabilization-comment' => 'Motivazione:',
	'stabilization-otherreason' => 'Altro motivo',
	'stabilization-expiry' => 'Scadenza:',
	'stabilization-othertime' => 'Altra durata',
	'stabilization-sel-short' => 'Precedenza',
	'stabilization-sel-short-0' => 'Qualità',
	'stabilization-sel-short-1' => 'Nessuna',
	'stabilization-sel-short-2' => 'Immacolata',
	'stabilization-def-short' => 'Default',
	'stabilization-def-short-0' => 'Attuale',
	'stabilization-def-short-1' => 'Stabile',
	'stabilize_expiry_invalid' => 'Data di scadenza non valida.',
	'stabilize_expiry_old' => 'La data di scadenza è già passata.',
	'stabilize-expiring' => 'scadenza: $1 (UTC)',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'stabilization-tab' => '固定',
	'stabilization' => '表示ページの固定',
	'stabilization-text' => "'''以下で [[:$1|$1]] の表示を固定する版の選択方法と表示方法を変更できます。'''

「{{int:stabilization-select}}」設定にて{{int:stabilization-sel-short-0}}もしくは{{int:stabilization-sel-short-2}}を既定とする場合は、ページに該当する版が実際に存在することを確認してください。存在しない場合、設定する意味がほとんどありません。",
	'stabilization-perm' => 'あなたには権限がないた固定版の設定を変更できません。現在の [[:$1|$1]] における設定は以下の通りです:',
	'stabilization-page' => 'ページ名:',
	'stabilization-leg' => '固定版の設定確認',
	'stabilization-select' => '固定版の選択',
	'stabilization-select1' => '最新の{{int:revreview-lev-quality}}版、それがない場合は、最新の{{int:revreview-lev-sighted}}版',
	'stabilization-select2' => '判定レベルにかかわらず最新の査読済み版',
	'stabilization-select3' => '最新の{{int:revreview-lev-pristine}}版、それがない場合は、最新の{{int:revreview-lev-quality}}版もしくは{{int:revreview-lev-sighted}}版',
	'stabilization-def' => 'ページに既定で表示する版',
	'stabilization-def1' => '固定版、それがない場合は、最新版',
	'stabilization-def2' => '最新版',
	'stabilization-restrict' => '自動査読の制限',
	'stabilization-restrict-none' => '追加制限なし',
	'stabilization-submit' => '設定',
	'stabilization-notexists' => '「[[:$1|$1]]」というページは存在しないため、設定できません。',
	'stabilization-notcontent' => 'ページ「[[:$1|$1]]」は査読対象ではないため、設定できません。',
	'stabilization-comment' => '理由:',
	'stabilization-otherreason' => '他の理由',
	'stabilization-expiry' => '有効期限:',
	'stabilization-othertime' => '他の日時',
	'stabilization-sel-short' => '優先度',
	'stabilization-sel-short-0' => '{{int:revreview-lev-quality}}',
	'stabilization-sel-short-1' => '不問',
	'stabilization-sel-short-2' => '{{int:revreview-lev-pristine}}',
	'stabilization-def-short' => '既定表示',
	'stabilization-def-short-0' => '最新版',
	'stabilization-def-short-1' => '固定版',
	'stabilization-rest-short' => '自動査読=$1',
	'stabilize_expiry_invalid' => '有効期限に不正な日時が設定されました。',
	'stabilize_expiry_old' => '有効期限に指定された日時を過ぎています。',
	'stabilize-expiring' => '有効期限: $1 (UTC)',
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
	'stabilization-comment' => 'Bemærkenge:',
	'stabilization-expiry' => 'Duråsje:',
	'stabilization-sel-short' => 'Præsedens',
	'stabilization-sel-short-0' => 'Kwalitæ',
	'stabilization-sel-short-1' => 'Ekke',
	'stabilization-def-short' => 'Åtåmatisk',
	'stabilization-def-short-0' => 'Nuværende',
	'stabilization-def-short-1' => 'Stabiil',
	'stabilize_expiry_invalid' => 'Ugyldegt duråsje dåt æller tiid.',
	'stabilize_expiry_old' => 'Dette duråsje tiid er ål passærn.',
	'stabilize-expiring' => 'durær biis $1 (UTC)',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'stabilization-sel-short-0' => 'Kwalitas',
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
	'stabilization-select' => 'تىياناقتى نۇسقا قالاي بولەكتەنەدى',
	'stabilization-select1' => 'ەڭ سوڭعى ساپالى نۇسقاسى; ەگەر جوق بولسا, ەڭ سوڭعى شولىنعانداردىڭ بىرەۋى بولادى',
	'stabilization-select2' => 'ەڭ سوڭعى سىن بەرىلگەن نۇسقا',
	'stabilization-def' => 'بەتتىڭ ادەپكى كورىنىسىندە كەلتىرىلەتىن نۇسقا',
	'stabilization-def1' => 'تىياناقتى نۇسقاسى; ەگەر جوق بولسا, اعىمداعىلاردىڭ بىرەۋى بولادى',
	'stabilization-def2' => 'اعىمدىق نۇسقاسى',
	'stabilization-submit' => 'قۇپتاۋ',
	'stabilization-notexists' => '«[[:$1|$1]]» دەپ اتالعان ەش بەت جوق. ەش باپتالىم رەتتەلمەيدى.',
	'stabilization-notcontent' => '«[[:$1|$1]]» دەگەن بەتكە سىن بەرىلمەيدى. ەش باپتالىم رەتتەلمەيدى.',
	'stabilization-comment' => 'ماندەمە:',
	'stabilization-sel-short' => 'ارتىقشىلىق',
	'stabilization-sel-short-0' => 'ساپالى',
	'stabilization-sel-short-1' => 'ەشقانداي',
	'stabilization-def-short' => 'ادەپكى',
	'stabilization-def-short-0' => 'اعىمدىق',
	'stabilization-def-short-1' => 'تىياناقتى',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'stabilization-tab' => '(сқ)',
	'stabilization' => 'Бетті тиянақтау',
	'stabilization-text' => 'Төмендегі бапталымдарды өзгерткенде [[:$1|$1]] дегеннің тиянақты нұсқасы қалай бөлектенуі мен көрсетілуі түзетіледі.',
	'stabilization-perm' => 'Тіркелгіңізге тиянақты нұсқаның бапталымын өзгертуге рұқсат берілмеген.
[[:$1|$1]] үшін ағымдағы баптаулар мында келтіріледі:',
	'stabilization-page' => 'Бет атауы:',
	'stabilization-leg' => 'Бет үшін тиянақты нұсқаны баптау',
	'stabilization-select' => 'Тиянақты нұсқа қалай бөлектенеді',
	'stabilization-select1' => 'Ең соңғы сапалы нұсқасы; егер жоқ болса, ең соңғы шолынғандардың біреуі болады',
	'stabilization-select2' => 'Ең соңғы сын берілген нұсқа',
	'stabilization-def' => 'Беттің әдепкі көрінісінде келтірілетін нұсқа',
	'stabilization-def1' => 'Тиянақты нұсқасы; егер жоқ болса, ағымдағылардың біреуі болады',
	'stabilization-def2' => 'Ағымдық нұсқасы',
	'stabilization-submit' => 'Құптау',
	'stabilization-notexists' => '«[[:$1|$1]]» деп аталған еш бет жоқ. Еш бапталым реттелмейді.',
	'stabilization-notcontent' => '«[[:$1|$1]]» деген бетке сын берілмейді. Еш бапталым реттелмейді.',
	'stabilization-comment' => 'Мәндеме:',
	'stabilization-sel-short' => 'Артықшылық',
	'stabilization-sel-short-0' => 'Сапалы',
	'stabilization-sel-short-1' => 'Ешқандай',
	'stabilization-def-short' => 'Әдепкі',
	'stabilization-def-short-0' => 'Ағымдық',
	'stabilization-def-short-1' => 'Тиянақты',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'stabilization-tab' => '(sq)',
	'stabilization' => 'Betti tïyanaqtaw',
	'stabilization-text' => 'Tömendegi baptalımdardı özgertkende [[:$1|$1]] degenniñ tïyanaqtı nusqası qalaý bölektenwi men körsetilwi tüzetiledi.',
	'stabilization-perm' => 'Tirkelgiñizge tïyanaqtı nusqanıñ baptalımın özgertwge ruqsat berilmegen.
[[:$1|$1]] üşin ağımdağı baptawlar mında keltiriledi:',
	'stabilization-page' => 'Bet atawı:',
	'stabilization-leg' => 'Bet üşin tïyanaqtı nusqanı baptaw',
	'stabilization-select' => 'Tïyanaqtı nusqa qalaý bölektenedi',
	'stabilization-select1' => 'Eñ soñğı sapalı nusqası; eger joq bolsa, eñ soñğı şolınğandardıñ birewi boladı',
	'stabilization-select2' => 'Eñ soñğı sın berilgen nusqa',
	'stabilization-def' => 'Bettiñ ädepki körinisinde keltiriletin nusqa',
	'stabilization-def1' => 'Tïyanaqtı nusqası; eger joq bolsa, ağımdağılardıñ birewi boladı',
	'stabilization-def2' => 'Ağımdıq nusqası',
	'stabilization-submit' => 'Quptaw',
	'stabilization-notexists' => '«[[:$1|$1]]» dep atalğan eş bet joq. Eş baptalım rettelmeýdi.',
	'stabilization-notcontent' => '«[[:$1|$1]]» degen betke sın berilmeýdi. Eş baptalım rettelmeýdi.',
	'stabilization-comment' => 'Mändeme:',
	'stabilization-sel-short' => 'Artıqşılıq',
	'stabilization-sel-short-0' => 'Sapalı',
	'stabilization-sel-short-1' => 'Eşqandaý',
	'stabilization-def-short' => 'Ädepki',
	'stabilization-def-short-0' => 'Ağımdıq',
	'stabilization-def-short-1' => 'Tïyanaqtı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'stabilization-page' => 'ឈ្មោះទំព័រ៖',
	'stabilization-def2' => 'ការពិនិត្យឡើងវិញពេលបច្ចុប្បន្ន',
	'stabilization-submit' => 'បញ្ជាក់ទទួលស្គាល់',
	'stabilization-comment' => 'យោបល់៖',
	'stabilization-expiry' => 'ផុតកំណត់៖',
	'stabilization-sel-short-0' => 'គុណភាព',
	'stabilization-sel-short-1' => 'ទទេ',
	'stabilization-def-short' => 'លំនាំដើម',
	'stabilization-def-short-0' => 'បច្ចុប្បន្ន',
	'stabilization-def-short-1' => 'ឋិតថេរ',
	'stabilize_expiry_invalid' => 'កាលបរិច្ឆេទផុតកំណត់មិនត្រឹមត្រូវ។',
	'stabilize-expiring' => 'ផុតកំណត់ម៉ោង $1 (UTC)',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'stabilization-text' => "'''[[:$1]] 문서의 어떤 버전이 선택되어 안정 버전으로 보이게 할 것인지에 대한 설정을 바꾸시려면 아래 양식을 이용해주세요.'''",
	'stabilization-page' => '문서 이름:',
	'stabilization-submit' => '확인',
	'stabilization-expiry' => '기한:',
	'stabilization-def-short' => '기본 설정',
	'stabilize_expiry_invalid' => '기한을 잘못 입력하였습니다.',
	'stabilize_expiry_old' => '기한을 과거로 입력하였습니다.',
	'stabilize-expiring' => '$1 (UTC)에 만료',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'stabilization-page' => 'Name fun dä Sigg:',
	'stabilization-def2' => 'De aktuelle Version',
	'stabilization-submit' => 'Bestätije',
	'stabilization-notexists' => 'Mer han kein Sigg met dämm Tittel „[[:$1|$1]]“.
Et jit nix enzestelle.',
	'stabilization-notcontent' => 'De Sigg met dämm Tittel „[[:$1|$1]]“ cannot be reviewed.
Et jit nix enzestelle.',
	'stabilization-comment' => 'Jrond:',
	'stabilization-otherreason' => 'Ene andere Jrond',
	'stabilization-def-short-0' => 'Von jetz',
	'stabilize_expiry_invalid' => 'Dat Affloufdattum es nit jöltisch.',
	'stabilize_expiry_old' => 'Dat Affloufdattum es ald förbei.',
	'stabilize-expiring' => 'Leuf uß, am $2 öm $3 Uhr (UTC)',
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
	'stabilization' => 'Stabilisatioun vun der Säit',
	'stabilization-page' => 'Säitennumm:',
	'stabilization-leg' => "Confirméiert d'stabil-Versiouns-Astellungen",
	'stabilization-select' => 'Auswiel vun der stabiler Versioun',
	'stabilization-select2' => 'Déi lescht iwwerkuckte Versioun, ouni de Niveua vun der Validatioun a Betracht ze zéien',
	'stabilization-def1' => 'déi stabil Versioun; oder wann et keng gëtt, déi aktuell Versioun',
	'stabilization-def2' => 'Déi aktuell Versioun',
	'stabilization-submit' => 'Confirméieren',
	'stabilization-notexists' => 'D\'Säit "[[:$1|$1]]" gëtt et net.
Keng Astellunge méiglech.',
	'stabilization-comment' => 'Grond:',
	'stabilization-otherreason' => 'Anere Grond:',
	'stabilization-othertime' => 'Aner Zäit',
	'stabilization-sel-short' => 'Priorititéit',
	'stabilization-sel-short-0' => 'Qualitéit',
	'stabilization-sel-short-1' => 'Keng',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Aktuell',
	'stabilization-def-short-1' => 'Stabil',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'stabilization-tab' => '(kb)',
	'stabilization' => 'Paginastabilisatie',
	'stabilization-text' => "'''Wijzig de onderstaande instellingen om aan te passen hoe de stabiele versie van [[:$1|$1]] geselecteerd is en getoond wordt.'''",
	'stabilization-perm' => 'Uw account heeft niet de toelating om de stabiele versie te wijzigen.
Dit zijn de huidige instellingen voor [[:$1|$1]]:',
	'stabilization-page' => 'Pazjenanaam:',
	'stabilization-leg' => "Stebiel versie van 'ne pazjena aanpasse",
	'stabilization-select' => 'Wie de stebiel versie wörd geselecteerd',
	'stabilization-select1' => "De letste kwaliteitsversie; es dae d'r neet is, den de letste bedoordeilde versie",
	'stabilization-select2' => 'De letste beoordeilde versie',
	'stabilization-def' => 'Versie dae standerd getuund wörd',
	'stabilization-def1' => 'De stebiel verzie',
	'stabilization-def2' => 'De hujig versie',
	'stabilization-submit' => 'Bevestige',
	'stabilization-notexists' => 'd\'r Is geine pazjena "[[:$1|$1]]". Instelle is neet meugelik.',
	'stabilization-notcontent' => 'De pazjena "[[:$1|$1]]" kin neet beoordeild waere. Instelle is neet meugelik.',
	'stabilization-comment' => 'Opmerking:',
	'stabilization-expiry' => 'Verloup:',
	'stabilization-sel-short' => 'Veurrang',
	'stabilization-sel-short-0' => 'Kwaliteit',
	'stabilization-sel-short-1' => 'Gein',
	'stabilization-def-short' => 'Standerd',
	'stabilization-def-short-0' => 'Hujig',
	'stabilization-def-short-1' => 'Stabiel',
	'stabilize_expiry_invalid' => 'Ongeldige verloopdatum.',
	'stabilize_expiry_old' => 'Deze verloopdatum is al verstreke.',
	'stabilize-expiring' => 'verloopt $1 (UTC)',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'stabilization-page' => 'Puslapio pavadinimas:',
	'stabilization-submit' => 'Patvirtinti',
	'stabilization-comment' => 'Komentaras:',
	'stabilization-sel-short-0' => 'Kokybė',
	'stabilization-def-short' => 'Standartinis',
	'stabilization-def-short-0' => 'Esamas',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'stabilization-page' => 'Лаштыкын лӱмжӧ:',
	'stabilization-def-short' => 'Ойлыде',
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'stabilization-tab' => 'ветеран',
	'stabilization' => 'Стабилизација на страница',
	'stabilization-text' => "'''Промени ги нагодувањата подолу за тоа како стабилната верзија на [[:$1|$1]] ќе биде избрана и прикажана.'''",
	'stabilization-perm' => 'Вашата корисничка сметка нема пермисии за промена на конфигурацијата на стабилна верзија.
Моментални нагодувања за [[:$1|$1]]:',
	'stabilization-page' => 'Име на страница:',
	'stabilization-leg' => 'Потврди нагодувања за стабилна верзија',
	'stabilization-select' => 'Избор на стабилна верзија',
	'stabilization-select1' => 'Последната квалитетна ревизија; ако не постои, тогаш последната прегледана',
	'stabilization-select2' => 'Последната оценета ревизија',
	'stabilization-select3' => 'Последната нерасипана ревизија; ако не постои, тогаш последната квалитетна или прегледана.',
	'stabilization-def' => 'Ревизија прикажана по основно при преглед на страница',
	'stabilization-def1' => 'Стабилната ревизија; ако не постои, тогаш моменталната',
	'stabilization-def2' => 'Моменталната ревизија',
	'stabilization-submit' => 'Потврди',
	'stabilization-notexists' => 'Нема страница насловена како "[[:$1|$1]]".
Не е можно нагодување.',
	'stabilization-notcontent' => 'Страницата "[[:$1|$1]]" не може да се оценува.
Не е можно нагодување.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Друга причина',
	'stabilization-expiry' => 'Истекува:',
	'stabilization-othertime' => 'Друго време',
	'stabilization-sel-short' => 'Исклучок',
	'stabilization-sel-short-0' => 'Квалитет',
	'stabilization-sel-short-1' => 'Ништо',
	'stabilization-sel-short-2' => 'Нерасипана',
	'stabilization-def-short' => 'Основно',
	'stabilization-def-short-0' => 'Моментално',
	'stabilization-def-short-1' => 'Стабилно',
	'stabilize_expiry_invalid' => 'Погрешен датум на важност.',
	'stabilize_expiry_old' => 'Времето на важност веќе е поминато.',
	'stabilize-expiring' => 'истекува $1 (UTC)',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'stabilization-tab' => 'സ്ഥിരത',
	'stabilization' => 'താളിന്റെ സ്ഥിരീകരണം',
	'stabilization-perm' => 'സ്ഥിരതയുള്ള പതിപ്പിന്റെ ക്രമീകരണം മാറ്റുന്നതിനുള്ള അവകാശം താങ്കളുടെ അക്കൗണ്ടിനില്ല. [[:$1|$1]]ന്റെ നിലവിലുള്ള ക്രമീകരണം ഇവിടെ കാണാം:',
	'stabilization-page' => 'താളിന്റെ പേര്‌:',
	'stabilization-leg' => 'സ്ഥിരതയുള്ള പതിപ്പിന്റെ ക്രമീകരണങ്ങള്‍ ഉറപ്പിക്കുക',
	'stabilization-select' => 'സ്ഥിരതയുള്ള പതിപ്പിന്റെ തിരഞ്ഞെടുക്കല്‍',
	'stabilization-select2' => 'അവസാനമായി സം‌ശോധനം നടത്തിയ പതിപ്പ്',
	'stabilization-def' => 'താളിന്റെ സ്വതവേയുള്ള നിലയില്‍ പ്രദര്‍ശിപ്പിക്കുന്ന പതിപ്പ്',
	'stabilization-def1' => 'സ്ഥിരതയുള്ള പതിപ്പ്;
അതില്ലെങ്കില്‍ നിലവിലുള്ള പതിപ്പ്',
	'stabilization-def2' => 'നിലവിലുള്ള പതിപ്പ്',
	'stabilization-submit' => 'സ്ഥിരീകരിക്കുക',
	'stabilization-notexists' => '"[[:$1|$1]]". എന്ന ഒരു താള്‍ നിലവിലില്ല. ക്രമീകരണങ്ങള്‍ നടത്തുന്നതിനു സാദ്ധ്യമല്ല.',
	'stabilization-notcontent' => '"[[:$1|$1]]" എന്ന താള്‍ സം‌ശോധനം ചെയ്യുന്നതിനു സാദ്ധ്യമല്ല. ക്രമീകരണം അനുവദനീയമല്ല.',
	'stabilization-comment' => 'അഭിപ്രായം:',
	'stabilization-expiry' => 'കാലാവധി:',
	'stabilization-sel-short' => 'മുന്‍‌നടപ്പ്',
	'stabilization-sel-short-0' => 'ഉന്നത നിലവാരം',
	'stabilization-sel-short-1' => 'ഒന്നുമില്ല',
	'stabilization-def-short' => 'സ്വതവെ',
	'stabilization-def-short-0' => 'നിലവിലുള്ളത്',
	'stabilization-def-short-1' => 'സ്ഥിരതയുള്ളത്',
	'stabilize_expiry_invalid' => 'അസാധുവായ കാലാവധി തീയതി.',
	'stabilize_expiry_old' => 'ഈ കാലാവധി സമയം കഴിഞ്ഞു പോയി.',
	'stabilize-expiring' => '$1 (UTC) നു കാലാവധി തീരുന്നു',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'stabilization-tab' => 'व्हेट',
	'stabilization' => 'पान स्थिर करा',
	'stabilization-text' => "'''[[:$1|$1]] ची स्थिर आवृत्ती कशा प्रकारे निवडली अथवा दाखविली जाईल या साठी खालील सेटिंग बदला.'''",
	'stabilization-perm' => 'तुम्हाला स्थिर आवृत्ती बदलण्याची परवानगी नाही.
[[:$1|$1]]चे सध्याचे सेटींग खालीलप्रमाणे:',
	'stabilization-page' => 'पृष्ठ नाव:',
	'stabilization-leg' => 'स्थिर आवृत्ती सेटिंग निश्चित करा',
	'stabilization-select' => 'स्थिर आवृत्तीची निवड',
	'stabilization-select1' => 'नवीनतम गुणवत्तापूर्ण आवृत्ती;
जर उपलब्ध नसेल, तर नवीनतम निवडलेली आवृत्ती',
	'stabilization-select2' => 'नवीनतम तपासलेली आवृत्ती',
	'stabilization-select3' => 'नवीनतम सर्वोत्कृष्ठ आवृत्ती; जर उपलब्ध नसेल, तर नवीनतम गुणवत्तापूर्ण किंवा निवडलेली',
	'stabilization-def' => 'मूळ प्रकारे पानावर बदल दाखविलेले आहेत',
	'stabilization-def1' => 'स्थिर आवृत्ती;
जर उपलब्ध नसेल, तर सध्याची',
	'stabilization-def2' => 'सध्याची आवृत्ती',
	'stabilization-submit' => 'सहमती द्या',
	'stabilization-notexists' => '"[[:$1|$1]]" या नावाचे पृष्ठ अस्तित्वात नाही.
बदल करू शकत नाही.',
	'stabilization-notcontent' => '"[[:$1|$1]]" हे पान तपासू शकत नाही.
बदल करता येणार नाहीत.',
	'stabilization-comment' => 'शेरा:',
	'stabilization-expiry' => 'रद्द होते:',
	'stabilization-sel-short' => 'अनुक्रम',
	'stabilization-sel-short-0' => 'दर्जा',
	'stabilization-sel-short-1' => 'काहीही नाही',
	'stabilization-sel-short-2' => 'सर्वोत्कृष्ठ',
	'stabilization-def-short' => 'मूळ (अविचल)',
	'stabilization-def-short-0' => 'सद्य',
	'stabilization-def-short-1' => 'स्थीर',
	'stabilize_expiry_invalid' => 'चुकीचा रद्दीकरण दिनांक.',
	'stabilize_expiry_old' => 'ही रद्दीकरण वेळ उलटून गेलेली आहे.',
	'stabilize-expiring' => '$1 (UTC) ला रद्द होते',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'stabilization-tab' => 'periksa',
	'stabilization' => 'Penstabilan laman',
	'stabilization-text' => "'''Ubah tetapan di bawah untuk mengawal bagaimana versi stabil bagi [[:$1|$1]] dipilih dan dipaparkan.'''",
	'stabilization-perm' => 'Anda tidak mempunyai keizinan untuk mengubah tetapan versi stabil ini.
Yang berikut ialah tetapan bagi [[:$1|$1]]:',
	'stabilization-page' => 'Nama laman:',
	'stabilization-leg' => 'Sahkan tetapan versi stabil',
	'stabilization-select' => 'Pemilihan versi stabil',
	'stabilization-select1' => 'Semakan bermutu terakhir; jika tiada, semakan dijenguk terakhir',
	'stabilization-select2' => 'Semakan diperiksa terakhir',
	'stabilization-select3' => 'Semakan asli terakhir; jika tiada, semakan bermutu atau semakan dijenguk terakhir',
	'stabilization-def' => 'Semakan yang dipaparkan ketika lalai',
	'stabilization-def1' => 'Semakan stabil; jika tiada, semakan semasa',
	'stabilization-def2' => 'Semakan semasa',
	'stabilization-submit' => 'Sahkan',
	'stabilization-notexists' => 'Tiada laman dengan nama "[[:$1|$1]]".
Tetapan tidak boleh dibuat.',
	'stabilization-notcontent' => 'Laman "[[:$1|$1]]" tidak boleh diperiksa.
Tetapan tidak boleh dibuat.',
	'stabilization-comment' => 'Ulasan:',
	'stabilization-expiry' => 'Tamat pada:',
	'stabilization-sel-short' => 'Keutamaan',
	'stabilization-sel-short-0' => 'Mutu',
	'stabilization-sel-short-1' => 'Tiada',
	'stabilization-sel-short-2' => 'Asli',
	'stabilization-def-short' => 'Lalai',
	'stabilization-def-short-0' => 'Semasa',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Tarikh tamat tidak sah.',
	'stabilize_expiry_old' => 'Waktu tamat telah pun berlalu.',
	'stabilize-expiring' => 'tamat pada $1 (UTC)',
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
 */
$messages['nah'] = array(
	'stabilization-page' => 'Zāzanilli ītōcā:',
	'stabilization-def2' => 'Āxcān in tlachiyaliztli',
	'stabilization-expiry' => 'Tlamiliztli:',
	'stabilization-sel-short-0' => 'Cuallōtl',
	'stabilization-sel-short-1' => 'Ahtlein',
	'stabilization-def-short' => 'Ic default',
	'stabilization-def-short-0' => 'Āxcān',
	'stabilize-expiring' => 'motlamīz $1 (UTC)',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'stabilization-page' => 'Siedennaam:',
	'stabilization-comment' => 'Grund:',
	'stabilization-expiry' => 'Löppt ut:',
	'stabilization-sel-short-0' => 'Qualität',
	'stabilization-sel-short-1' => 'Keen',
	'stabilize-expiring' => 'löppt $1 ut (UTC)',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'stabilization-tab' => '(er)',
	'stabilization' => 'Paginastabilisatie',
	'stabilization-text' => "'''Wijzig de onderstaande instellingen om aan te passen hoe de stabiele versie van [[:\$1|\$1]] geselecteerd en weergegeven wordt.'''

Controleer of \"kwaliteitsversies\" of \"ongerepte versies\" van pagina's echt aanwezig zijn voordat u deze als ''stabiele versieselectie'' instelt, anders heeft de wijziging weinig effect.",
	'stabilization-perm' => 'U hebt geen rechten om de instellingen voor de stabiele versie te wijzigen.
Dit zijn de huidige instellingen voor [[:$1|$1]]:',
	'stabilization-page' => 'Paginanaam:',
	'stabilization-leg' => 'Instellingen stabiele versie bevestigen',
	'stabilization-select' => 'Hoe de stabiele versie wordt geselecteerd',
	'stabilization-select1' => 'De laatste kwaliteitsversie;
als die er niet is, dan de laatste gecontroleerde versie',
	'stabilization-select2' => 'De laatste versie met eindredactie, onafhankelijk van het controleniveau',
	'stabilization-select3' => 'De laatste ongerepte versie.
Als deze niet beschikbaar is, dan de laatste kwaliteitsversie of gecontroleerde versie',
	'stabilization-def' => 'Versie die standaard weergegeven wordt',
	'stabilization-def1' => 'De stabiele versie;
als die er niet is, dan de huidige versie',
	'stabilization-def2' => 'De werkversie',
	'stabilization-restrict' => 'Beperkingen auto-eindredactie',
	'stabilization-restrict-none' => 'Geen additionele beperkingen',
	'stabilization-submit' => 'Bevestigen',
	'stabilization-notexists' => 'Er is geen pagina "[[:$1|$1]]".
Instellen is niet mogelijk.',
	'stabilization-notcontent' => 'U kunt geen eindredactie op de pagina "[[:$1|$1]]" doen.
Instellen is niet mogelijk.',
	'stabilization-comment' => 'Reden:',
	'stabilization-otherreason' => 'Andere reden',
	'stabilization-expiry' => 'Vervallen:',
	'stabilization-othertime' => 'Andere tijd',
	'stabilization-sel-short' => 'Voorrang',
	'stabilization-sel-short-0' => 'Kwaliteit',
	'stabilization-sel-short-1' => 'Geen',
	'stabilization-sel-short-2' => 'Ongerept',
	'stabilization-def-short' => 'Standaard',
	'stabilization-def-short-0' => 'Huidig',
	'stabilization-def-short-1' => 'Stabiel',
	'stabilization-rest-short' => 'auto-eindredactie=$1',
	'stabilize_expiry_invalid' => 'Ongeldige vervaldatum.',
	'stabilize_expiry_old' => 'Deze vervaldatum is al verstreken.',
	'stabilize-expiring' => 'vervalt $1 (UTC)',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'stabilization-tab' => 'kvalitet',
	'stabilization' => 'Sidestabilisering',
	'stabilization-text' => "'''Endra innstillingane nedanfor for å velja korleis den stabile versjonen av [[:$1|$1]] skal verta vald og synt.'''

Når ein endrar oppsettet for ''valet av stabil versjon'' slik at det nyttar «{{int:revreview-lev-quality}}» eller «{{int:revreview-lev-pristine}}» som standard,
må ein gjera seg viss om at sida har slike versjonar, elles vil endringa ha liten verknad.",
	'stabilization-perm' => 'Brukarkontoen din har ikkje løyve til å endra innstillingane for stabile versjonar.
Her er dei noverande innstillingane for [[:$1|$1]]:',
	'stabilization-page' => 'Sidenamn:',
	'stabilization-leg' => 'Stadfest innstillingane for stabile versjonar',
	'stabilization-select' => 'Val av stabil versjon',
	'stabilization-select1' => 'Den siste kvalitetsversjonen om han finst; om ikkje, den siste vurderte versjonen',
	'stabilization-select2' => 'Den siste vurderte versjonen, same kva kvalitetsnivå.',
	'stabilization-select3' => 'Den siste urørde versjonen av sida. Om han ikkje finst, ta den siste kvalitetsversjonen eller den siste vurderte versjonen',
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
	'stabilization-othertime' => 'Anna tid',
	'stabilization-sel-short' => 'Prioritet',
	'stabilization-sel-short-0' => 'Kvalitet',
	'stabilization-sel-short-1' => 'Ingen',
	'stabilization-sel-short-2' => 'Urørd',
	'stabilization-def-short' => '(standard)',
	'stabilization-def-short-0' => 'Noverande',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Ugyldig sluttdato.',
	'stabilize_expiry_old' => 'Sluttdatoen har alt vore.',
	'stabilize-expiring' => 'endar $1 (UTC)',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author H92
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'stabilization-tab' => 'kvalitet',
	'stabilization' => 'Sidestabilisering',
	'stabilization-text' => "'''Endre innstillingene nedenfor for å bestemme hvordan den stabile versjonen av [[:$1|$1]] skal velges og vises.'''",
	'stabilization-perm' => 'Din brukerkonto har ikke tillatelse til å endre innstillinger for stabile versjoner.
Her er de nåværende innstillingene for [[:$1|$1]]:',
	'stabilization-page' => 'Sidenavn:',
	'stabilization-leg' => 'Bekreft innstillinger for stabile versjoner',
	'stabilization-select' => 'Valg av stabil versjon',
	'stabilization-select1' => 'Den siste kvalitetsrevisjonen hvis den finnes, ellers den siste synede versjonen',
	'stabilization-select2' => 'Den siste undersøkte versjonen.',
	'stabilization-select3' => 'Den siste urørte versjonen av denne siden; om det ikke finnes, det siste kvalitetsversjonen eller den siste sjekkede versjonen',
	'stabilization-def' => 'Sideversjonen som skal brukes som standardvisning',
	'stabilization-def1' => 'Den stabile versjonen hvis den finnes, ellers den nyeste versjonen',
	'stabilization-def2' => 'Den nyeste versjonen',
	'stabilization-submit' => 'Bekreft',
	'stabilization-notexists' => 'Det er ingen side med tittelen «[[:$1|$1]]». Ingen innstillinger kan gjøres.',
	'stabilization-notcontent' => 'Siden «[[:$1|$1]]» kan ikke bli undersøkt. Ingen innstillinger kan gjøres.',
	'stabilization-comment' => 'Kommentar:',
	'stabilization-expiry' => 'Utgår:',
	'stabilization-sel-short' => 'Presedens',
	'stabilization-sel-short-0' => 'Kvalitet',
	'stabilization-sel-short-1' => 'Ingen',
	'stabilization-sel-short-2' => 'Urørt',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Nåværende',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Ugyldig varighet.',
	'stabilize_expiry_old' => 'Varigheten har allerede utløpt.',
	'stabilize-expiring' => 'utgår $1 (UTC)',
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
	'stabilization-text' => "'''Modificatz los paramètres çaijós per definir lo biais dont la version establa de [[:$1|$1]] es seleccionada e afichada.'''

Quora configuratz la ''seleccion de la version establa'' per utilizar las revisions « de qualitat » o « inicialas » per defaut, asseguratz-vos qu'i a efièchament de talas revisions dins la pagina, siquenon las modificacions auràn pas d'incidéncia.",
	'stabilization-perm' => 'Vòstre compte a pas los dreches per cambiar los paramètres de la version establa. Vaquí los paramètres corrents de [[:$1|$1]] :',
	'stabilization-page' => 'Nom de la pagina :',
	'stabilization-leg' => 'Confirmar lo parametratge de la version establa',
	'stabilization-select' => 'Seleccion de la version establa',
	'stabilization-select1' => 'La darrièra version de qualitat, siquenon la darrièra version vista',
	'stabilization-select2' => 'La darrièra revision revisada, sens téner compte del nivèl de validacion',
	'stabilization-select3' => 'La version mai anciana ; en cas d’abséncia, la darrièra de qualitat o visada.',
	'stabilization-def' => "Version afichada al moment de l'afichatge per defaut de la pagina",
	'stabilization-def1' => 'La version establa, siquenon la version correnta',
	'stabilization-def2' => 'La version correnta',
	'stabilization-restrict' => 'Tornar veire automaticament las restriccions',
	'stabilization-restrict-none' => 'Pas de restriccion suplementària',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'I a pas de pagina « [[:$1|$1]] », pas de parametratge possible',
	'stabilization-notcontent' => 'La pagina « [[:$1|$1]] » pòt pas èsser revisada, pas de parametratge possible',
	'stabilization-comment' => 'Rason :',
	'stabilization-otherreason' => 'Autra rason',
	'stabilization-expiry' => 'Expira :',
	'stabilization-othertime' => 'Autre temps',
	'stabilization-sel-short' => 'Prioritat',
	'stabilization-sel-short-0' => 'Qualitat',
	'stabilization-sel-short-1' => 'Nula',
	'stabilization-sel-short-2' => 'Primitiva',
	'stabilization-def-short' => 'Defaut',
	'stabilization-def-short-0' => 'Correnta',
	'stabilization-def-short-1' => 'Establa',
	'stabilization-rest-short' => 'revision automatica=$1',
	'stabilize_expiry_invalid' => "Data d'expiracion invalida.",
	'stabilize_expiry_old' => "Lo temps d'expiracion ja es passat.",
	'stabilize-expiring' => 'expira $1 (UTC)',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'stabilization-sel-short-1' => 'Нæй',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author McMonster
 * @author Saper
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'stabilization-tab' => 'Widoczne wersje strony',
	'stabilization' => 'Widoczna wersja strony',
	'stabilization-text' => "'''Ustaw poniżej, w jaki sposób ma być wybierana i wyświetlana oznaczona wersja strony [[:$1|$1]].'''

Po zmianie sposobu ''wyboru wersji oznaczonej'', aby korzystała domyślnie z wersji „zweryfikowanej” lub „nienaruszonej” należy się upewnić, że strona posiada tego typu wersje, w przeciwnym wypadku zmiana przyniesie niewielki skutek.",
	'stabilization-perm' => 'Nie masz wystarczających uprawnień, by zmienić konfigurację wersji oznaczonych.
Aktualne ustawienia dla strony [[:$1|$1]]:',
	'stabilization-page' => 'Nazwa strony:',
	'stabilization-leg' => 'Zatwierdź konfigurację wersji oznaczonej',
	'stabilization-select' => 'Wybór wersji oznaczonej',
	'stabilization-select1' => 'Ostatnia wersja zweryfikowana, a jeśli nie istnieje, to ostatnia wersja przejrzana',
	'stabilization-select2' => 'Ostatnia wersja oznaczona, niezależnie od poziomu oznaczenia',
	'stabilization-select3' => 'Ostatnia nienaruszona wersja, a jeśli nie istnieje, to ostatnia wersja zweryfikowana lub przejrzana',
	'stabilization-def' => 'Wersja strony wyświetlana domyślnie',
	'stabilization-def1' => 'Wersja oznaczona, a jeśli nie istnieje, to wersja bieżąca',
	'stabilization-def2' => 'Bieżąca wersja',
	'stabilization-restrict' => 'Ograniczenia automatycznego przeglądania',
	'stabilization-restrict-none' => 'Brak dodatkowych ograniczeń',
	'stabilization-submit' => 'Potwierdź',
	'stabilization-notexists' => 'Brak strony zatytułowanej „[[:$1|$1]]”. Nie jest możliwa jej konfiguracja.',
	'stabilization-notcontent' => 'Strona „[[:$1|$1]]” nie może być oznaczona.
Nie jest możliwa jej konfiguracja.',
	'stabilization-comment' => 'Powód',
	'stabilization-otherreason' => 'Inna przyczyna',
	'stabilization-expiry' => 'Czas wygaśnięcia',
	'stabilization-othertime' => 'Innym razem',
	'stabilization-sel-short' => 'Kolejność',
	'stabilization-sel-short-0' => 'Zweryfikowana',
	'stabilization-sel-short-1' => 'Brak',
	'stabilization-sel-short-2' => 'Nienaruszona',
	'stabilization-def-short' => 'Domyślna',
	'stabilization-def-short-0' => 'Bieżąca',
	'stabilization-def-short-1' => 'Oznaczona',
	'stabilization-rest-short' => 'automatyczne przeglądanie=$1',
	'stabilize_expiry_invalid' => 'Nieprawidłowa data wygaśnięcia.',
	'stabilize_expiry_old' => 'Czas wygaśnięcia już upłynął.',
	'stabilize-expiring' => 'wygasa $1 (UTC)',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'stabilization-tab' => '(c.q.)',
	'stabilization' => 'Stabilisassion dla pàgina',
	'stabilization-text' => "'''Ch'a toca le regolassion ambelessì sota për rangé coma la version stàbila ëd [[:$1|$1]] a debia esse sërnùa e smonùa.'''",
	'stabilization-perm' => "Sò cont a l'ha pa ij përmess dont a fa da manca për toché le regolassion dla version stàbila. Ambelessì a-i son le regolassion corente për [[:$1|$1]]:",
	'stabilization-page' => 'Nòm dla pàgina:',
	'stabilization-leg' => 'Regolé la version stàbila ëd na pàgina',
	'stabilization-select' => 'Coma sërne la version stàbila',
	'stabilization-select1' => "Ùltima revision ëd qualità; s'a-i é nen cola, pijé l'ùltima controlà",
	'stabilization-select2' => 'Ùltima revision controlà',
	'stabilization-def' => 'Revision da smon-e coma pàgina sòlita për la vos',
	'stabilization-def1' => "la version stàbila, s'a-i n'a-i é gnun-a, pijé cola corenta",
	'stabilization-def2' => 'la revision corenta',
	'stabilization-submit' => 'Confermé',
	'stabilization-notexists' => 'A-i é pa gnun-a pàgina ch\'as ciama "[[:$1|$1]]". As peul nen regolé lòn ch\'a-i é nen.',
	'stabilization-notcontent' => 'La pàgina "[[:$1|$1]]" as peul pa s-ciairesse. A-i é gnun-a regolassion ch\'as peula fesse.',
	'stabilization-sel-short' => 'Precedensa',
	'stabilization-sel-short-0' => 'Qualità',
	'stabilization-sel-short-1' => 'Gnun-a',
	'stabilization-def-short' => 'Për sòlit',
	'stabilization-def-short-0' => 'version corenta',
	'stabilization-def-short-1' => 'version stàbila',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'stabilization-page' => 'د مخ نوم:',
	'stabilization-sel-short-1' => 'هېڅ',
	'stabilization-def-short' => 'تلواليز',
	'stabilization-def-short-0' => 'اوسنی',
	'stabilize-expiring' => 'په $1 (UTC) پای ته رسېږي',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'stabilization-tab' => 'cgq',
	'stabilization' => 'Configurações da Garantia de Qualidade',
	'stabilization-text' => "'''Altere a seguir as configurações de como a versão estável de [[:\$1|\$1]] é selecionada e exibida.'''

Quanto alterar a configuração de ''seleção da versão estável'' para usar revisões \"qualidade\" ou \"intocada\" por defeito,
certifique-se que verifica se realmente existem tais revisões na página, caso contrário a alteração terá pouco efeito.",
	'stabilization-perm' => 'Sua conta não possui permissão para alterar as configurações de edições estáveis.
Seguem-se as configurações para [[:$1|$1]]:',
	'stabilization-page' => 'Nome da página:',
	'stabilization-leg' => 'Confirmar a configuração da edição estável',
	'stabilization-select' => 'Seleção da edição estável',
	'stabilization-select1' => 'A última edição analisada como confiável; 
se inexistente, a mais recentemente analisada',
	'stabilization-select2' => 'A revisão mais recentemente analisada, independentemente do nível de validação',
	'stabilization-select3' => 'A última revisão intocada; se não estiver presente, então a última de qualidade ou visionada',
	'stabilization-def' => 'Edição exibida na visualização padrão de página',
	'stabilization-def1' => 'A edição estável; 
se inexistente, exibir a edição actual',
	'stabilization-def2' => 'A edição actual',
	'stabilization-restrict' => 'Restrições de auto-revisão',
	'stabilization-restrict-none' => 'Nenhuma restrição extra',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'A página "[[:$1|$1]]" não existe.
Não é possível configurá-la.',
	'stabilization-notcontent' => 'A página "[[:$1|$1]]" não pode ser analisada.
Não é possível configurá-la.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Outro motivo',
	'stabilization-expiry' => 'Expira em:',
	'stabilization-othertime' => 'Outro tempo',
	'stabilization-sel-short' => 'Precedência',
	'stabilization-sel-short-0' => 'Qualidade',
	'stabilization-sel-short-1' => 'Nenhum',
	'stabilization-sel-short-2' => 'Intocada',
	'stabilization-def-short' => 'Padrão',
	'stabilization-def-short-0' => 'Atual',
	'stabilization-def-short-1' => 'Estável',
	'stabilization-rest-short' => 'auto-revisão=$1',
	'stabilize_expiry_invalid' => 'Data de expiração inválida.',
	'stabilize_expiry_old' => 'Este tempo de expiração já se encerrou.',
	'stabilize-expiring' => 'expira às $1 (UTC)',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'stabilization-tab' => 'cgq',
	'stabilization' => 'Configurações da Garantia de Qualidade',
	'stabilization-text' => "'''Altere a seguir as configurações de como a versão estável de [[:\$1|\$1]] é selecionada e exibida.'''

Ao mudar a configuração de ''seleção de versão estável'' para utilizar revisões \"confiáveis\" ou \"intocadas\" por padrão, tenha certeza de checar se de fato existem revisões assim na página, pois de outra maneira a mudança terá pouco efeito.",
	'stabilization-perm' => 'Sua conta não possui permissão para alterar as configurações de edições estáveis.
Seguem-se as configurações para [[:$1|$1]]:',
	'stabilization-page' => 'Nome da página:',
	'stabilization-leg' => 'Confirmar a configuração da edição estável',
	'stabilization-select' => 'Seleção da edição estável',
	'stabilization-select1' => 'A última edição analisada como confiável;  
se inexistente, a mais recentemente analisada',
	'stabilization-select2' => 'A revisão mais recentemente analisada, independente do nível de validação',
	'stabilization-select3' => 'A última revisão intocada; se não estiver presente, então a última de qualidade ou analisada',
	'stabilization-def' => 'Edição exibida na visualização padrão de página',
	'stabilization-def1' => 'A edição estável;  
se inexistente, exibir a edição atual',
	'stabilization-def2' => 'A edição atual',
	'stabilization-restrict' => 'Auto-analisar restrições',
	'stabilization-restrict-none' => 'sem restrições extras',
	'stabilization-submit' => 'Confirmar',
	'stabilization-notexists' => 'A página "[[:$1|$1]]" não existe.
Não é possível configurá-la.',
	'stabilization-notcontent' => 'A página "[[:$1|$1]]" não pode ser analisada.
Não é possível configurá-la.',
	'stabilization-comment' => 'Motivo:',
	'stabilization-otherreason' => 'Outro motivo',
	'stabilization-expiry' => 'Expira em:',
	'stabilization-othertime' => 'Outro tempo',
	'stabilization-sel-short' => 'Precedência',
	'stabilization-sel-short-0' => 'Qualidade',
	'stabilization-sel-short-1' => 'Nenhum',
	'stabilization-sel-short-2' => 'Intocada',
	'stabilization-def-short' => 'Padrão',
	'stabilization-def-short-0' => 'Atual',
	'stabilization-def-short-1' => 'Estável',
	'stabilization-rest-short' => 'autoreview=$1',
	'stabilize_expiry_invalid' => 'Data de expiração inválida.',
	'stabilize_expiry_old' => 'Este tempo de expiração já se encerrou.',
	'stabilize-expiring' => 'expira às $1 (UTC)',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'stabilization-page' => 'Numele paginii:',
	'stabilization-def1' => 'Revizia stabilă; dacă nu există, atunci cea curentă',
	'stabilization-def2' => 'Revizia curentă',
	'stabilization-submit' => 'Confirmă',
	'stabilization-comment' => 'Comentariu:',
	'stabilization-expiry' => 'Expiră:',
	'stabilization-sel-short-0' => 'Calitate',
	'stabilize_expiry_invalid' => 'Data expirării incorectă.',
	'stabilize-expiring' => 'expiră $1 (UTC)',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Pàgene de stabbilizzazione',
	'stabilization-text' => "'''Cange le 'mbostaziune sotte pe aggiustà cumme a 'na versiona secure de [[:\$1|\$1]] ca jè selezionete e visualizzete.'''

Quanne cange 'a configurazione d'a ''seleziona d'a versiona secure'' pe ausà \"qualità\" o \"repristine\" le revisiune pe default, a essere secure ca è condrollete ce stonne jndr'à quidde mumende quacche versiona jndr'à pàgene, ce no 'u cangiamende ave 'n'effette piccinne.",
	'stabilization-perm' => "'U cunde utende tue non ge tène le permesse pe cangià 'a configurazione d'a versione secure.
Chiste sonde le configuraziune corrende pe [[:$1|$1]]:",
	'stabilization-page' => "Nome d'a pàgene:",
	'stabilization-leg' => 'Conferme le configuraziune pe le versiune secure',
	'stabilization-select' => "Selezione d'a versiona secure",
	'stabilization-select1' => "L'urtema versione de qualità; ce non g'è presende, allore vide l'urtema viste",
	'stabilization-select2' => "L'urtema revisione reviste, senza 'nu levèlle de validazione",
	'stabilization-select3' => "L'urtema versione bbone; ce non g'è presende, allore vide l'urtema versione de qualità o viste",
	'stabilization-def' => "Revisiune visualizzete sus 'a viste d'a pàgene de default",
	'stabilization-def1' => "'A revisiona secure; ce non g'è presende, allore vide quedda corrende",
	'stabilization-def2' => "'A revisiona corrende",
	'stabilization-restrict' => "Restriziune sus a l'auto revisitazione",
	'stabilization-restrict-none' => 'Nisciuna restriziona de cchiù',
	'stabilization-submit' => 'Conferme',
	'stabilization-notexists' => 'Non ge stè \'na pàgene ca se chieme "[[:$1|$1]]".
Nisciuna configurazione jè possibbele.',
	'stabilization-notcontent' => '\'A pàgene "[[$1|$1]]" non ge pò essere reviste.
Non ge stonne le configurazione.',
	'stabilization-comment' => 'Mutive:',
	'stabilization-otherreason' => 'Otre mutive',
	'stabilization-expiry' => 'More:',
	'stabilization-othertime' => 'Otre orarije',
	'stabilization-sel-short' => 'Precedenze',
	'stabilization-sel-short-0' => 'Qualità',
	'stabilization-sel-short-1' => 'Ninde',
	'stabilization-sel-short-2' => 'Bbuene proprie',
	'stabilization-def-short' => 'Defolt',
	'stabilization-def-short-0' => 'Corrende',
	'stabilization-def-short-1' => 'Sicure',
	'stabilization-rest-short' => 'autorevisitaziune=$1',
	'stabilize_expiry_invalid' => 'Date de scadenze errete.',
	'stabilize_expiry_old' => 'Sta date de scadenze ha già passete.',
	'stabilize-expiring' => "scade 'u $1 (UTC)",
);

/** Russian (Русский)
 * @author Drbug
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'stabilization-tab' => '(кк)',
	'stabilization' => 'Стабилизация страницы',
	'stabilization-text' => "'''С помощью приведённых ниже настроек можно управлять выбором и отображением стабильной версии страницы [[:$1|$1]].'''",
	'stabilization-perm' => 'Вашей учётной записи не хватает прав, чтобы изменять настройки показа стабильной версии.
Здесь приведены текущие настройки для [[:$1|$1]]:',
	'stabilization-page' => 'Название страницы:',
	'stabilization-leg' => 'Подтверждение настроек стабильной версии',
	'stabilization-select' => 'Выбор стабильной версии',
	'stabilization-select1' => 'Самая свежая выверенная версия; если её нет, то самая свежая из досмотренных.',
	'stabilization-select2' => 'Последняя проверенная версия',
	'stabilization-select3' => 'Последняя нетронутая версия; если нет, то последняя выверенная или досмотренная',
	'stabilization-def' => 'Версия, показываемая по умолчанию',
	'stabilization-def1' => 'Стабильная версия; если нет, то текущая',
	'stabilization-def2' => 'Текущая версия',
	'stabilization-submit' => 'Подтвердить',
	'stabilization-notexists' => 'Отсутствует страница с названием «[[:$1|$1]]». Настройка невозможна.',
	'stabilization-notcontent' => 'Страница «[[:$1|$1]]» не может быть проверена. Настройка невозможна.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Другая причина',
	'stabilization-expiry' => 'Истекает:',
	'stabilization-othertime' => 'Другое время',
	'stabilization-sel-short' => 'Порядок следования',
	'stabilization-sel-short-0' => 'Выверенная',
	'stabilization-sel-short-1' => 'Нет',
	'stabilization-sel-short-2' => 'Нетронутая',
	'stabilization-def-short' => 'По умолчанию',
	'stabilization-def-short-0' => 'Текущая',
	'stabilization-def-short-1' => 'Стабильная',
	'stabilize_expiry_invalid' => 'Ошибочная дата истечения.',
	'stabilize_expiry_old' => 'Указанное время окончания действия уже прошло.',
	'stabilize-expiring' => 'истекает $1 (UTC)',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'stabilization-tab' => '(хх)',
	'stabilization' => 'Сирэй стабилизацията',
	'stabilization-text' => "'''Манна баар туруорууларынан [[:$1|$1]] сирэй чистовой торумун талары уонна хайдах көстүөҕүн уларытыахха сөп.'''",
	'stabilization-perm' => 'Эн аккаунуҥ чистовой торум туруорууларын уларытар кыаҕы биэрбэт.
Манна [[:$1|$1]] билигин үлэлиир туруоруулара көстөллөр:',
	'stabilization-page' => 'Сирэй аата:',
	'stabilization-leg' => 'Сирэй чистовой торумун туруорууларын уларыт',
	'stabilization-select' => 'Чистовой торуму хайдах талар туһунан',
	'stabilization-select1' => 'Бүтэһик бэрэбиэркэлэммит торум; суох буоллаҕына - бүтэһик көрүллүбүт.',
	'stabilization-select2' => 'Бүтэһик ырытыллыбыт сирэй',
	'stabilization-def' => 'Анаан этиллибэтэҕинэ көрдөрүллэр торум',
	'stabilization-def1' => 'Чистовой торум, суох буоллаҕына - бүтэһик торум',
	'stabilization-def2' => 'Бүтэһик торум',
	'stabilization-submit' => 'Бигэргэтии',
	'stabilization-notexists' => 'Маннык ааттаах сирэй «[[:$1|$1]]» суох. Онон уларытар кыах суох.',
	'stabilization-notcontent' => '«[[:$1|$1]]» сирэй ырытыллыбат. Онон туруорууларын уларытар сатаммат.',
	'stabilization-comment' => 'Хос быһаарыы:',
	'stabilization-expiry' => 'Болдьоҕо бүтэр:',
	'stabilization-sel-short' => 'Бэрээдэгэ',
	'stabilization-sel-short-0' => 'Үрдүк таһымнаах',
	'stabilization-sel-short-1' => 'Суох',
	'stabilization-def-short' => 'Анал туруоруута суох',
	'stabilization-def-short-0' => 'Бүтэһик',
	'stabilization-def-short-1' => 'Чистовой',
	'stabilize_expiry_invalid' => 'Болдьох сыыһа туруорулунна.',
	'stabilize_expiry_old' => 'Болдьох этиллибит кэмэ номнуо ааспыт.',
	'stabilize-expiring' => 'Болдьоҕо бүтэр: $1 (UTC)',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'stabilization-tab' => '(kk)',
	'stabilization' => 'Stabilizácia stránky',
	'stabilization-text' => "'''|Tieto voľby menia spôsob výberu a zobrazenia stabilnej verzie stránky [[:$1|$1]].'''

Pri zmene nastavenia ''výber stabilnej verzie'' aby sa používala štandardne „{{int:revreview-lev-quality}}“ alebo „{{int:revreview-lev-pristine}}“ revízia sa uistite, či skutočne existuje takáto revízia stránky, inak sa nastavenie neprejaví.",
	'stabilization-perm' => 'Váš účet nemá oprávnenie meniť nastavenia stabilnej verzie. Tu sú súčasné nastavenia [[:$1|$1]]:',
	'stabilization-page' => 'Názov stránky:',
	'stabilization-leg' => 'Potvrdiť nastavenia stabilnej verzie',
	'stabilization-select' => 'Výber stabilnej verzie',
	'stabilization-select1' => 'Posledná kvalitná revízia; ak nie je prítomná, je to posledná skontrolovaná',
	'stabilization-select2' => 'Posledná skontrolovaná revízia nezávisle na úrovni overenia',
	'stabilization-select3' => 'Najnovšia neskazená revízia; ak neexistuje, najnovšia kvalitná alebo videná',
	'stabilization-def' => 'Revízia, ktorá sa zobrazí pri štandardnom zobrazení stránky',
	'stabilization-def1' => 'Stabilná revízia; ak nie je prítomná, je to aktuálna',
	'stabilization-def2' => 'Aktuálna revízia',
	'stabilization-restrict' => 'Obmedzenia automatického overenia',
	'stabilization-restrict-none' => 'Žiadne ďalšie obmedzenia',
	'stabilization-submit' => 'Potvrdiť',
	'stabilization-notexists' => 'Neexistuje stránka s názvom „[[:$1|$1]]“. Konfigurácia nie je možná.',
	'stabilization-notcontent' => 'Stránku „[[:$1|$1]]“ nie je možné skontrolovať. Konfigurácia nie je možná.',
	'stabilization-comment' => 'Dôvod:',
	'stabilization-otherreason' => 'Iný dôvod',
	'stabilization-expiry' => 'Vyprší:',
	'stabilization-othertime' => 'Iný čas',
	'stabilization-sel-short' => 'Precedencia',
	'stabilization-sel-short-0' => 'Kvalita',
	'stabilization-sel-short-1' => 'žiadna',
	'stabilization-sel-short-2' => 'neskazená',
	'stabilization-def-short' => 'štandard',
	'stabilization-def-short-0' => 'aktuálna',
	'stabilization-def-short-1' => 'stabilná',
	'stabilization-rest-short' => 'autokontrola=$1',
	'stabilize_expiry_invalid' => 'Neplatný dátum vypršania.',
	'stabilize_expiry_old' => 'Čas vypršania už prešiel.',
	'stabilize-expiring' => 'vyprší $1 (UTC)',
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
	'stabilization-comment' => 'Komenti:',
	'stabilization-expiry' => 'Skadon:',
	'stabilization-sel-short-0' => 'Kualiteti',
	'stabilization-sel-short-1' => "S'ka",
	'stabilization-def-short-0' => 'Tani',
	'stabilize_expiry_invalid' => 'Datë jo vlefshme e skadimit.',
	'stabilize_expiry_old' => 'Koha e skadimit tanimë ka kaluar.',
	'stabilize-expiring' => 'skadon $1 (UTC)',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'stabilization-tab' => 'ветеран',
	'stabilization' => 'Стабилизација стране',
	'stabilization-text' => "'''Измени подешавања испод у циљу намешатања како ће стабилне верзије стране [[:$1|$1]] бити означене и приказане.'''",
	'stabilization-perm' => 'Твој налог нема дозвола за измену подешавања за стабилне верзије. Тренутна подешавања за страну [[:$1|$1]] су:',
	'stabilization-page' => 'Име странице:',
	'stabilization-leg' => 'Потврди подешавања за стабилне верзије.',
	'stabilization-select' => 'Означавање стабилних верзија.',
	'stabilization-select1' => 'Последња квалитетна верзија; ако не постоји, онда ће бити приказана последња прегледана.',
	'stabilization-select2' => 'Последња прегледана верзија.',
	'stabilization-select3' => 'Последња непокрварена верзија; ако не постоји, последња квалитетна или прегледана ће бити приказана.',
	'stabilization-def' => 'Верзија приказана на подразумеваном приказу стране.',
	'stabilization-def1' => 'Стабилна верзија; ако не постоји, биће приказана тренутна.',
	'stabilization-def2' => 'Тренутна верзија.',
	'stabilization-submit' => 'Прихвати',
	'stabilization-notexists' => 'Не постоји страна под именом "[[:$1|$1]]". Подешавање није могуће.',
	'stabilization-notcontent' => 'Страна "[[:$1|$1]]" не може бити прегледана. Подешавање није могуће.',
	'stabilization-comment' => 'Коментар:',
	'stabilization-expiry' => 'Истиче:',
	'stabilization-sel-short' => 'Изузетак',
	'stabilization-sel-short-0' => 'Квалитет',
	'stabilization-sel-short-1' => 'Ништа',
	'stabilization-sel-short-2' => 'Непоквареност',
	'stabilization-def-short' => 'Основно',
	'stabilization-def-short-0' => 'Тренутно',
	'stabilization-def-short-1' => 'Стабилно',
	'stabilize_expiry_invalid' => 'Лош датум истицања.',
	'stabilize_expiry_old' => 'Време истицања је већ прошло.',
	'stabilize-expiring' => 'истиче $1 (UTC)',
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
	'stabilization-leg' => 'Ienstaalengen fon ju stoabile Version foar ne Siede',
	'stabilization-select' => 'Uutwoal fon ju stoabile Version',
	'stabilization-select1' => 'Ju lääste wröigede Version; wan neen deer is, dan ju lääste sieuwede Version',
	'stabilization-select2' => 'Ju lääste wröigede Version',
	'stabilization-def' => 'Anwiesde Version in ju normoale Siedenansicht',
	'stabilization-def1' => 'Ju stoabile Version; wan neen deer is, dan ju aktuelle Version.',
	'stabilization-def2' => 'Ju aktuellste Version',
	'stabilization-submit' => 'Bestäätigje',
	'stabilization-notexists' => 'Dät rakt neen Siede „[[:$1|$1]]“. Neen Ienstaalengen muugelk.',
	'stabilization-notcontent' => 'Ju Siede "[[:$1|$1]]" kon nit wröiged wäide. Konfiguration nit muugelk.',
	'stabilization-comment' => 'Kommentoar:',
	'stabilization-expiry' => 'Gultich bit:',
	'stabilization-sel-short' => 'Priorität',
	'stabilization-sel-short-0' => 'Qualität',
	'stabilization-sel-short-1' => 'neen',
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
	'stabilization-text' => "'''Robah setélan di handap pikeun nangtukeun cara milih jeung némbongkeun vérsi stabil [[:$1|$1]].'''",
	'stabilization-perm' => 'Rekening anjeun teu boga kawenangan pikeun ngarobah konfigurasi vérsi stabil.
Setélan kiwari pikeun [[:$1|$1]] nyaéta:',
	'stabilization-page' => 'Ngaran kaca:',
	'stabilization-select' => 'Milihan vérsi stabil',
	'stabilization-def1' => 'Vérsi stabil;
mun euweuh, paké vérsi kiwari',
	'stabilization-def2' => 'Révisi kiwari',
	'stabilization-submit' => 'Konfirmasi',
	'stabilization-notexists' => 'Euweuh kaca nu ngaranna “[[:$1|$1]]”.
KOnfigurasi teu bisa dilarapkeun.',
	'stabilization-comment' => 'Kamandang:',
	'stabilization-expiry' => 'Kadaluwarsa:',
	'stabilization-def-short' => 'Buhun',
	'stabilization-def-short-0' => 'Kiwari',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Titimangsa kadaluwarsana salah.',
	'stabilize_expiry_old' => 'Titimangsa kadaluwarsa geus kaliwat.',
	'stabilize-expiring' => 'kadaluwarsa $1 (UTC)',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'stabilization-tab' => 'kvalitet',
	'stabilization' => 'Sidstabilisering',
	'stabilization-text' => "'''Ändra inställningarna härunder för att bestämma hur den stabila versionen av [[:$1|$1]] ska väljas och visas.'''

När konfigurationen för ''val av stabil version'' ändras till användande av {{int:revreview-lev-quality}} eller {{int:revreview-lev-pristine}} som förval,
kontrollera att det faktiskt finns sådana varianter i sidan, annars får det liten effekt.",
	'stabilization-perm' => 'Ditt konto har inte behörighet att ändra inställningar för stabila sidversioner.
Här visas de nuvarande inställningarna för [[:$1|$1]]:',
	'stabilization-page' => 'Sidnamn:',
	'stabilization-leg' => 'Bekräfta inställningar för stabila versioner',
	'stabilization-select' => 'Val av stabil version',
	'stabilization-select1' => 'Den senaste kvalitetsversionen om den finns, annars den senaste sedda versionen',
	'stabilization-select2' => 'Den senaste granskade versionen',
	'stabilization-select3' => 'Den senaste ursprungliga versionen av den här sidan; om inte den aktuella, efter den senaste kvalitetsversionen eller den synade',
	'stabilization-def' => 'Sidversion som används som standard när sidan visas',
	'stabilization-def1' => 'Den stabila versionen om den finns, annars den senaste versionen',
	'stabilization-def2' => 'Den senaste versionen',
	'stabilization-submit' => 'Bekräfta',
	'stabilization-notexists' => 'Det finns ingen sida med titeln "[[:$1|$1]]". Inga inställningar kan göras.',
	'stabilization-notcontent' => 'Sidan "[[:$1|$1]]" kan inte granskas. Inga inställningar kan göras.',
	'stabilization-comment' => 'Anledning:',
	'stabilization-otherreason' => 'Annan anledning',
	'stabilization-expiry' => 'Varaktighet:',
	'stabilization-othertime' => 'Annan tid',
	'stabilization-sel-short' => 'Företräde',
	'stabilization-sel-short-0' => 'Kvalitet',
	'stabilization-sel-short-1' => 'Ingen',
	'stabilization-sel-short-2' => 'Ursprunglig',
	'stabilization-def-short' => 'Standard',
	'stabilization-def-short-0' => 'Senaste',
	'stabilization-def-short-1' => 'Stabil',
	'stabilize_expiry_invalid' => 'Ogiltig varaktighet.',
	'stabilize_expiry_old' => 'Varaktigheten har redan löpt ut.',
	'stabilize-expiring' => 'upphör den $1 (UTC)',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'stabilization-expiry' => 'Wygaso:',
	'stabilization-def-short' => 'Důmyślna',
);

/** Tamil (தமிழ்)
 * @author Ulmo
 */
$messages['ta'] = array(
	'stabilization-page' => 'பக்கப் பெயர்:',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'పేజీ స్ధిరీకరణ',
	'stabilization-text' => "'''[[:$1|$1]] యొక్క సుస్థిర కూర్పు ఎలా ఎంచుకోవాలి మరియు చూపించబడాలో సరిదిద్దడానికి క్రింది అమరికలు మార్చండి.'''",
	'stabilization-perm' => 'మీ ఖాతాకు సుస్థిర కూర్పును మార్చే అనుమతి లేదు. [[:$1|$1]]కి ప్రస్తుత అమరికల ఇవీ:',
	'stabilization-page' => 'పేజీ పేరు:',
	'stabilization-leg' => 'పేజీకి సుస్థిర కూర్పుని నిర్ధేశించండి',
	'stabilization-select' => 'సుస్థిర కూర్పుని ఎలా ఎంచుకుంటారు',
	'stabilization-select1' => 'చిట్టచివరి నాణ్యమైన కూర్పు; అది లేకపోతే, కనబడిన వాటిలో చిట్టచివరిది',
	'stabilization-select2' => 'చివరి సమీక్షిత కూర్పు',
	'stabilization-def' => 'డిఫాల్టు పేజీ వ్యూలో చూపించే కూర్పు',
	'stabilization-def1' => 'సుస్థిర కూర్పు; అది లేకపోతే, ప్రస్తుత కూర్పు',
	'stabilization-def2' => 'ప్రస్తుత కూర్పు',
	'stabilization-submit' => 'నిర్ధారించు',
	'stabilization-notexists' => '"[[:$1|$1]]" అనే పేజీ లేదు. స్వరూపణం వీలుపడదు.',
	'stabilization-notcontent' => '"[[:$1|$1]]" అన్న పేజీని సమీక్షించ లేదు. ఎటువంటి స్వరూపణం వీలు కాదు.',
	'stabilization-comment' => 'వ్యాఖ్య:',
	'stabilization-expiry' => 'కాలంచెల్లు తేదీ:',
	'stabilization-sel-short' => 'ప్రాధాన్యత',
	'stabilization-sel-short-0' => 'నాణ్యత',
	'stabilization-sel-short-1' => 'ఏమీలేదు',
	'stabilization-def-short' => 'డిఫాల్టు',
	'stabilization-def-short-0' => 'ప్రస్తుత',
	'stabilization-def-short-1' => 'సుస్థిరం',
	'stabilize_expiry_invalid' => 'తప్పుడు కాలపరిమితి తేదీ.',
	'stabilize_expiry_old' => 'ఈ కాలం ఎప్పుడో చెల్లిపోయింది.',
	'stabilize-expiring' => '$1 (UTC) నాడు కాలం చెల్లుతుంది',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'stabilization-page' => 'Naran pájina nian:',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'stabilization-tab' => 'санҷиш',
	'stabilization' => 'Пойдорсозии саҳифаҳо',
	'stabilization-text' => "'''Тағйири танзимоти зерин ба манзури таъйини ин, ки нусхаи пойдор аз [[:$1|$1]] чигуна интихоб ва намоиш дода мешавад.'''",
	'stabilization-perm' => 'Ҳисоби шумо иҷозати тағйири танзими нусхаи пойдорро надорад. Танзимоти феълӣ барои [[:$1|$1]]  чунинанд:',
	'stabilization-page' => 'Номи саҳифа:',
	'stabilization-leg' => 'Тасдиқи танзими нусхаи пойдор',
	'stabilization-select' => 'Интихоби нусхаи пойдор',
	'stabilization-select1' => 'Охирин нусхаи бо кайфият; агар он вуҷуд надошта бошад, пас он охирин яке аз баррасидашуда аст',
	'stabilization-select2' => 'Охирин саҳифаи баррасӣ шуда',
	'stabilization-def' => 'Нусхае ки дар ҳолати пешфарз намоиш дода мешавад',
	'stabilization-def1' => 'Нусхаи пойдор; агар он вуҷуд надошта бошад, пас он нусхаи феълӣ аст',
	'stabilization-def2' => 'Нусхаи феълӣ',
	'stabilization-submit' => 'Тасдиқ',
	'stabilization-notexists' => 'Саҳифае бо унвони "[[:$1|$1]]" вуҷуд надорад. Танзимот мумкин нест.',
	'stabilization-notcontent' => 'Саҳифаи "[[:$1|$1]]" қобили баррасӣ нест. Танзимот мумкин нест.',
	'stabilization-comment' => 'Тавзеҳ:',
	'stabilization-expiry' => 'Интиҳо:',
	'stabilization-sel-short' => 'Тақдим',
	'stabilization-sel-short-0' => 'Бо кайфият',
	'stabilization-sel-short-1' => 'Ҳеҷ',
	'stabilization-def-short' => 'Пешфарз',
	'stabilization-def-short-0' => 'Феълӣ',
	'stabilization-def-short-1' => 'Пойдор',
	'stabilize_expiry_invalid' => 'Таърихи интиҳоии ғайримиҷоз.',
	'stabilize_expiry_old' => 'Таърихи интиҳо аллакай сипарӣ шудааст.',
	'stabilize-expiring' => 'Дар $1 (UTC) ба интиҳо мерасад',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'stabilization-page' => 'ชื่อหน้า:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'stabilization-tab' => 'suriing mabuti (masinsinan)',
	'stabilization' => 'Pagpapatatag ng pahina',
	'stabilization-text' => "'''Baguhin ang mga pagtatakda sa ibaba upang mabago ang kung paano napili at napalitaw (naipakita) ang matatag na bersyon ng [[:\$1|\$1]].'''

Kapag binabago ang pagkakaayos ng ''pilian ng matatag na bersyon'' para magamit ang mga pagbabago sa \"antas ng uri\" o \"dalisay\" sa pamamamagitan ng likas na pagtatakda, tiyaking susuriin kung talagang mayroong ganyang mga rebisyon sa loob ng pahina, dahil bahagya lamang ang magiging epekto ng pagbabago kung wala.",
	'stabilization-perm' => 'Walang kapahintulutan ang kuwenta/akawnt mo upang baguhin ang pagkakaayos ng matatag na bersyon.
Narito ang pangkasalukuyang mga katakdaan para sa [[:$1|$1]]:',
	'stabilization-page' => 'Pangalan ng pahina:',
	'stabilization-leg' => 'Tiyakin ang mga pagtatakda para sa matatag na bersyon',
	'stabilization-select' => 'Pagpipilian para sa matatag na bersyon',
	'stabilization-select1' => 'Ang pinakahuling pagbabagong may mataas na uri; kung wala, ang pinakahuling namataang isa na lamang',
	'stabilization-select2' => 'Ang pinakahuling pagbabagong nasuri na',
	'stabilization-select3' => 'Ang pinakahuling dalisay (malinis) na pagbabago; kung wala, ang huling may pinakamataas na uri o namataang isa na lamang',
	'stabilization-def' => 'Ang pagbabagong ipinakita sa natatanaw na likas na nakatakdang pahina',
	'stabilization-def1' => 'Ang matatag na pagbabago, kung, ang pangkasalukuyang isa na lamang',
	'stabilization-def2' => 'Ang pangkasalukuyang pagbabago',
	'stabilization-submit' => 'Tiyakin',
	'stabilization-notexists' => 'Walang pahinang tinatawag na "[[:$1|$1]]".
Walang maaaring maging pagkakaayos (konpigurasyon).',
	'stabilization-notcontent' => 'Hindi masusuri ang "[[:$1|$1]]".
Walang maaaring maging pagkakaayos (konpigurasyon).',
	'stabilization-comment' => 'Dahilan:',
	'stabilization-otherreason' => 'Ibang dahilan',
	'stabilization-expiry' => 'Magtatapos sa:',
	'stabilization-othertime' => 'Ibang oras',
	'stabilization-sel-short' => 'Pagkakauna-una (pagkakasunud-sunod)',
	'stabilization-sel-short-0' => 'Kaantasan ng uri (kalidad)',
	'stabilization-sel-short-1' => 'Wala',
	'stabilization-sel-short-2' => 'Dalisay (malinis)',
	'stabilization-def-short' => 'Likas na nakatakda',
	'stabilization-def-short-0' => 'Pangkasalukuyan',
	'stabilization-def-short-1' => 'Matatag',
	'stabilize_expiry_invalid' => 'Hindi tanggap na petsa ng pagtatapos.',
	'stabilize_expiry_old' => 'Lagpas na ang oras/panahon ng pagtatapos na ito.',
	'stabilize-expiring' => 'magtatapos sa $1 (UTC)',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 * @author Srhat
 */
$messages['tr'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Sayfa kararlılaştırılması',
	'stabilization-text' => "'''[[:\$1|\$1]] için kararlı sürümün nasıl seçilip görüntüleneceğini ayarlamak için ayarları değiştirin.'''

Varsayılan olarak \"kalite\" ya da \"asıl\" revizyonlarını kullanmak için ''kararlı sürüm seçimi'' yapılandırmasını değiştirirken, sayfada böyle revizyonların olduğunu kontrol ettiğinize emin olun, aksi halde değişikliğin etkisi küçük olacaktır.",
	'stabilization-perm' => 'Hesabınızın kararlı sürüm yapılandırmasını değiştirmeye izni yok.
[[:$1|$1]] için şuanki ayarlar:',
	'stabilization-page' => 'Sayfa adı:',
	'stabilization-leg' => 'Kararlı sürüm ayarlarını onayla',
	'stabilization-select' => 'Kararlı sürüm seçimi',
	'stabilization-select1' => 'En son kaliteli revizyon; eğer yoksa, en son gözlenmiş olan',
	'stabilization-select2' => 'En son gözden geçirilmiş revizyon, doğrulama seviyesine bakmaksızın',
	'stabilization-select3' => 'En son bozulmamış revizyon; eğer yoksa, en son kaliteli ya da gözlenmiş olan',
	'stabilization-def' => 'Varsayılan sayfa görünümünde gösterilen revizyon',
	'stabilization-def1' => 'Kararlı revizyon; eğer yoksa, halihazırda bulunan',
	'stabilization-def2' => 'Şuanki revizyon',
	'stabilization-restrict' => 'Oto-inceleme kısıtlamaları',
	'stabilization-restrict-none' => 'Başka ilave kısıtlama yok',
	'stabilization-submit' => 'Tespit et',
	'stabilization-notexists' => '"[[:$1|$1]]" adında bir sayfa yok.
Yapılandırma mümkün değil.',
	'stabilization-notcontent' => '"[[:$1|$1]]" sayfası gözden geçirilemiyor.
Yapılandırma mümkün değil.',
	'stabilization-comment' => 'Sebep:',
	'stabilization-otherreason' => 'Diğer sebep',
	'stabilization-expiry' => 'Süresi bitiyor:',
	'stabilization-othertime' => 'Diğer zaman',
	'stabilization-sel-short' => 'Öncelik',
	'stabilization-sel-short-0' => 'Kalite',
	'stabilization-sel-short-1' => 'Hiçbiri',
	'stabilization-sel-short-2' => 'Bozulmamış',
	'stabilization-def-short' => 'Varsayılan',
	'stabilization-def-short-0' => 'Şuanki',
	'stabilization-def-short-1' => 'Kararlı',
	'stabilization-rest-short' => 'otoinceleme=$1',
	'stabilize_expiry_invalid' => 'Geçersiz sona erme tarihi.',
	'stabilize_expiry_old' => 'Sona erme tarihi zaten geçmiş.',
	'stabilize-expiring' => '$1 (UTC) tarihinde sona eriyor',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'stabilization-tab' => '(кя)',
	'stabilization' => 'Стабілізація сторінки',
	'stabilization-text' => "'''За допомогою наведених нижче налаштувань можна керувати вибором і відображенням стабільної версії сторінки [[:$1|$1]].'''",
	'stabilization-perm' => 'Вашому обліковому запису не вистачає прав, щоб змінювати налаштування показу стабільної версії.
Тут наведені поточні налаштування для [[:$1|$1]]:',
	'stabilization-page' => 'Назва сторінки:',
	'stabilization-leg' => 'Підтвердження налаштувань стабільної версії',
	'stabilization-select' => 'Вибір стабільної версії',
	'stabilization-select1' => 'Найсвіжіша якісна версія; якщо такої нема, то найсвіжіша переглянута',
	'stabilization-select2' => 'Остання перевірена версія',
	'stabilization-select3' => 'Остання недоторкана версія, якщо такої немає, то остання якісна або переглянута',
	'stabilization-def' => 'Версія, що показується за замовчуванням',
	'stabilization-def1' => 'Стабільна версія; якщо такої нема, то поточна',
	'stabilization-def2' => 'Поточна версія',
	'stabilization-submit' => 'Підтвердити',
	'stabilization-notexists' => 'Відсутня сторінка з назвою «[[:$1|$1]]».
Налаштування неможливе.',
	'stabilization-notcontent' => 'Сторінка «[[:$1|$1]]» не може бути перевірена.
Налаштування неможливе.',
	'stabilization-comment' => 'Причина:',
	'stabilization-otherreason' => 'Інша причина',
	'stabilization-expiry' => 'Закінчується:',
	'stabilization-othertime' => 'Інший час',
	'stabilization-sel-short' => 'Порядок слідування',
	'stabilization-sel-short-0' => 'Якісна',
	'stabilization-sel-short-1' => 'Нема',
	'stabilization-sel-short-2' => 'Недоторкана',
	'stabilization-def-short' => 'Стандартно',
	'stabilization-def-short-0' => 'Поточна',
	'stabilization-def-short-1' => 'Стабільна',
	'stabilize_expiry_invalid' => 'Помилкова дата закінчення.',
	'stabilize_expiry_old' => 'Зазначений час закінчення пройшов.',
	'stabilize-expiring' => 'закінчується о $1 (UTC)',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'stabilization-tab' => 'c. q.',
	'stabilization' => 'Stabilizassion de pagina',
	'stabilization-text' => "'''Canbia le inpostassion qua soto par stabilir come la version stabile de [[:$1|$1]] la vegna selessionà e mostrà.'''",
	'stabilization-perm' => 'No ti gà i permessi necessari par canbiar le inpostassion de la version stabile.
Chì ghe xe le inpostassion atuali par [[:$1|$1]]:',
	'stabilization-page' => 'Nome de la pagina:',
	'stabilization-leg' => 'Conferma le inpostassion par la version stabile',
	'stabilization-select' => 'Selession de la version stabile',
	'stabilization-select1' => "L'ultima version de qualità;
se no ghe n'è, alora l'ultima version rivardà",
	'stabilization-select2' => "L'ultima version riesaminà",
	'stabilization-select3' => "L'ultima version primitiva; se no ghe n'è, alora l'ultima version de qualità o l'ultima rivardà.",
	'stabilization-def' => 'Version mostrà par default quando se varda la pagina',
	'stabilization-def1' => "La revision stabile;
se no ghe n'è, alora la revision corente",
	'stabilization-def2' => 'La revision corente',
	'stabilization-submit' => 'Conferma',
	'stabilization-notexists' => 'No ghe xe nissuna pagina che se ciama "[[:$1|$1]]".
Nissuna configurassion xe possibile.',
	'stabilization-notcontent' => 'La pagina "[[:$1|$1]]" no la pode èssar riesaminà.
No se pode canbiar le inpostassion.',
	'stabilization-comment' => 'Motivassion:',
	'stabilization-otherreason' => 'Altro motivo',
	'stabilization-expiry' => 'Scadensa:',
	'stabilization-othertime' => 'Altra durata',
	'stabilization-sel-short' => 'Preçedensa',
	'stabilization-sel-short-0' => 'De qualità',
	'stabilization-sel-short-1' => 'Nissuna',
	'stabilization-sel-short-2' => 'Primitiva',
	'stabilization-def-short' => 'Predefinìa',
	'stabilization-def-short-0' => 'Atuale',
	'stabilization-def-short-1' => 'Stabile',
	'stabilize_expiry_invalid' => 'Data de scadensa mìa valida.',
	'stabilize_expiry_old' => 'Sta scadensa la xe zà passà.',
	'stabilize-expiring' => 'scadensa $1 (UTC)',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'stabilization-tab' => 'vet',
	'stabilization' => 'Ổn định trang',
	'stabilization-text' => "'''Thay đổi thiết lập dưới đây để điều chỉnh cách phiên bản ổn định của [[:\$1|\$1]] sẽ được lựa chọn và hiển thị.'''

Khi thay đổi cấu hình ''lựa chọn phiên bản ổn định'' để mặc định sử dụng các phiên bản \"chất lượng\" hoặc \"sơ khai\",
hãy nhớ kiểm tra xem thực sự có những phiên bản như vậy trong trang không, nếu không thay đổi đó sẽ có rất ít tác dụng.",
	'stabilization-perm' => 'Tài khoản của bạn không có quyền thay đổi cấu hình phiên bản ổn định.
Dưới đây là các thiết lập hiện hành cho [[:$1|$1]]:',
	'stabilization-page' => 'Tên trang:',
	'stabilization-leg' => 'Xác nhận các thiết lập bản ổn định',
	'stabilization-select' => 'Lựa chọn bản ổn định',
	'stabilization-select1' => 'Bản chất lượng mới nhất;
nếu không có, sẽ là bản đã xem qua mới nhất',
	'stabilization-select2' => 'Bản đã duyệt mới nhất, bất kể mức độ phê chuẩn',
	'stabilization-select3' => 'Phiên bản cổ xưa mới nhất; nếu không có, thì bản chất lượng hoặc đã xem qua mới nhất',
	'stabilization-def' => 'Bản được hiển thị mặc định',
	'stabilization-def1' => 'Phiên bản ổn định;
nếu không có, sẽ là bản hiện hành',
	'stabilization-def2' => 'Phiên bản hiện hành',
	'stabilization-restrict' => 'Hạn chế duyệt tự động',
	'stabilization-restrict-none' => 'Không có hạn chế nào khác',
	'stabilization-submit' => 'Xác nhận',
	'stabilization-notexists' => 'Không có trang nào có tên “[[:$1|$1]]”.
Không thể cấu hình.',
	'stabilization-notcontent' => 'Trang “[[:$1|$1]]” không thể được duyệt.
Không thể cấu hình.',
	'stabilization-comment' => 'Lý do:',
	'stabilization-otherreason' => 'Lý do khác',
	'stabilization-expiry' => 'Thời hạn:',
	'stabilization-othertime' => 'Thời gian khác',
	'stabilization-sel-short' => 'Đi trước',
	'stabilization-sel-short-0' => 'Chất lượng',
	'stabilization-sel-short-1' => 'Không có',
	'stabilization-sel-short-2' => 'Bản gốc',
	'stabilization-def-short' => 'Mặc định',
	'stabilization-def-short-0' => 'Hiện hành',
	'stabilization-def-short-1' => 'Ổn định',
	'stabilization-rest-short' => 'autoreview=$1',
	'stabilize_expiry_invalid' => 'Thời hạn không hợp lệ.',
	'stabilize_expiry_old' => 'Thời hạn đã qua.',
	'stabilize-expiring' => 'hết hạn vào $1 (UTC)',
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
	'stabilization-select' => 'Väl fomama fümöfik',
	'stabilization-select2' => 'Fomam pekrütöl lätik',
	'stabilization-def' => 'Fomam jonabik pö padilogams kösömik',
	'stabilization-def1' => 'Fomam fümöfik; if no dabinon, tän fomam anuik',
	'stabilization-def2' => 'Fomam anuik',
	'stabilization-submit' => 'Fümedön',
	'stabilization-notexists' => 'Pad tiädü "[[:$1|$1]]" no dabinon. Fomükam no mögon.',
	'stabilization-notcontent' => 'Pad: "[[:$1|$1]]" no kanon pakrütön. Parametem nonik mögon.',
	'stabilization-comment' => 'Küpet:',
	'stabilization-expiry' => 'Dul jü:',
	'stabilization-sel-short-0' => 'Kaliet',
	'stabilization-sel-short-1' => 'Nonik',
	'stabilization-def-short-0' => 'Anuik',
	'stabilization-def-short-1' => 'Fümöfik',
	'stabilize_expiry_invalid' => 'Dul no lonöföl.',
	'stabilize-expiring' => 'dulon jü $1 (UTC)',
);

/** Yue (粵語)
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
	'stabilization-select' => '穩定版選擇',
	'stabilization-select1' => '最近有質素嘅修訂；如果未有，就係最近視察過嘅',
	'stabilization-select2' => '最近複審過嘅修訂',
	'stabilization-select3' => '最近原始嘅修訂；如果未有，就係最近有質素或視察過嘅',
	'stabilization-def' => '響預設版視嘅修訂顯示',
	'stabilization-def1' => '穩定修訂；如果未有，就係現時嘅',
	'stabilization-def2' => '現時嘅修訂',
	'stabilization-submit' => '確認',
	'stabilization-notexists' => '呢度係無一版係叫"[[:$1|$1]]"。
無設定可以改到。',
	'stabilization-notcontent' => '嗰版"[[:$1|$1]]"唔可以複審。
無設定可以改到。',
	'stabilization-comment' => '註解:',
	'stabilization-expiry' => '到期:',
	'stabilization-sel-short' => '優先',
	'stabilization-sel-short-0' => '質素',
	'stabilization-sel-short-1' => '無',
	'stabilization-sel-short-2' => '原始',
	'stabilization-def-short' => '預設',
	'stabilization-def-short-0' => '現時',
	'stabilization-def-short-1' => '穩定',
	'stabilize_expiry_invalid' => '無效嘅到期日。',
	'stabilize_expiry_old' => '到期日已經過咗。',
	'stabilize-expiring' => '於 $1 (UTC) 到期',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'stabilization-tab' => '調查',
	'stabilization' => '穩定頁面',
	'stabilization-text' => "'''更改以下的設定去調節所選擇的[[:$1|$1]]之穩定版本如何顯示。'''",
	'stabilization-perm' => '您的賬戶並沒有權限去更改穩定版本設定。
呢度有現時[[:$1|$1]]的設定:',
	'stabilization-page' => '頁面名稱:',
	'stabilization-leg' => '確認穩定版本的設定',
	'stabilization-select' => '穩定版本選擇',
	'stabilization-select1' => '最近有質素的修訂；如果未有，則是最近視察過的',
	'stabilization-select2' => '最近複審過的修訂',
	'stabilization-select3' => '最近原始的修訂；如果未有，則是最近有質素或視察過的',
	'stabilization-def' => '在預設頁視的修訂顯示',
	'stabilization-def1' => '穩定修訂；如果未有，則是現時的',
	'stabilization-def2' => '現時的修訂',
	'stabilization-submit' => '確認',
	'stabilization-notexists' => '這裏是沒有一頁面名叫"[[:$1|$1]]"。
沒有設定可以更改。',
	'stabilization-notcontent' => '該頁面"[[:$1|$1]]"不可以複審。
沒有設定可以更改。',
	'stabilization-comment' => '註解:',
	'stabilization-expiry' => '到期:',
	'stabilization-sel-short' => '優先',
	'stabilization-sel-short-0' => '質素',
	'stabilization-sel-short-1' => '無',
	'stabilization-sel-short-2' => '原始',
	'stabilization-def-short' => '預設',
	'stabilization-def-short-0' => '現時',
	'stabilization-def-short-1' => '穩定',
	'stabilize_expiry_invalid' => '無效的到期日。',
	'stabilize_expiry_old' => '到期日已過。',
	'stabilize-expiring' => '於 $1 (UTC) 到期',
);

