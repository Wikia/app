<?php
/**
 * Internationalisation file for CentralNotice extension.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'centralnotice' => 'Central notice admin',
	'noticetemplate' => 'Central notice template',
	'centralnotice-desc' => 'Adds a central sitenotice',
	'centralnotice-summary' => 'This module allows you to edit your currently setup central notices.
It can also be used to add or remove old notices.',
	'centralnotice-query' => 'Modify current notices',
	'centralnotice-notice-name' => 'Notice name',
	'centralnotice-end-date' => 'End date',
	'centralnotice-enabled' => 'Enabled',
	'centralnotice-modify' => 'Submit',
	'centralnotice-preview' => 'Preview',
	'centralnotice-add-new' => 'Add a new central notice',
	'centralnotice-remove' => 'Remove',
	'centralnotice-translate-heading' => 'Translation for $1',
	'centralnotice-manage' => 'Manage central notice',
	'centralnotice-add' => 'Add',
	'centralnotice-add-notice' => 'Add a notice',
	'centralnotice-add-template' => 'Add a template',
	'centralnotice-show-notices' => 'Show notices',
	'centralnotice-list-templates' => 'List templates',
	'centralnotice-translations' => 'Translations',
	'centralnotice-translate-to' => 'Translate to',
	'centralnotice-translate' => 'Translate',
	'centralnotice-english' => 'English',
	'centralnotice-template-name' => 'Template name',
	'centralnotice-templates' => 'Templates',
	'centralnotice-weight' => 'Weight',
	'centralnotice-locked' => 'Locked',
	'centralnotice-notices' => 'Notices',
	'centralnotice-notice-exists' => 'Notice already exists.
Not adding',
	'centralnotice-template-exists' => 'Template already exists.
Not adding',
	'centralnotice-notice-doesnt-exist' => 'Notice does not exist.
Nothing to remove',
	'centralnotice-template-still-bound' => 'Template is still bound to a notice.
Not removing.',
	'centralnotice-template-body' => 'Template body:',
	'centralnotice-day' => 'Day',
	'centralnotice-year' => 'Year',
	'centralnotice-month' => 'Month',
	'centralnotice-hours' => 'Hour',
	'centralnotice-min' => 'Minute',
	'centralnotice-project-lang' => 'Project language',
	'centralnotice-project-name' => 'Project name',
	'centralnotice-start-date' => 'Start date',
	'centralnotice-start-time' => 'Start time (UTC)',
	'centralnotice-assigned-templates' => 'Assigned templates',
	'centralnotice-no-templates' => 'No templates found.
Add some!',
	'centralnotice-no-templates-assigned' => 'No templates assigned to notice.
Add some!',
	'centralnotice-available-templates' => 'Available templates',
	'centralnotice-template-already-exists' => 'Template is already tied to campaign.
Not adding',
	'centralnotice-preview-template' => 'Preview template',
	'centralnotice-start-hour' => 'Start time',
	'centralnotice-change-lang' => 'Change translation language',
	'centralnotice-weights' => 'Weights',
	'centralnotice-notice-is-locked' => 'Notice is locked.
Not removing',
	'centralnotice-overlap' => 'Notice overlaps within the time of another notice.
Not adding',
	'centralnotice-invalid-date-range' => 'Invalid date range.
Not updating',
	'centralnotice-null-string' => 'Cannot add a null string.
Not adding',
	'centralnotice-confirm-delete' => 'Are you sure you want to delete this item?
This action will be unrecoverable.',
	'centralnotice-no-notices-exist' => 'No notices exist.
Add one below',
	'centralnotice-no-templates-translate' => 'There are not any templates to edit translations for',
	'centralnotice-number-uses' => 'Uses',
	'centralnotice-edit-template' => 'Edit template',
	'centralnotice-message' => 'Message',
	'centralnotice-message-not-set' => 'Message not set',
	'centralnotice-clone' => 'Clone',
	'centralnotice-clone-notice' => 'Create a copy of the template',
	'centralnotice-preview-all-template-translations' => 'Preview all available translations of template',

	'right-centralnotice-admin' => 'Manage central notices',
	'right-centralnotice-translate' => 'Translate central notices',

	'action-centralnotice-admin' => 'manage central notices',
	'action-centralnotice-translate' => 'translate central notices',
	'centralnotice-preferred' => 'Preferred',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Nike
 * @author Purodha
 */
$messages['qqq'] = array(
	'centralnotice' => 'Name of Special:CentralNotice in Special:SpecialPages and title of the page',
	'noticetemplate' => 'Title of Special:NoticeTemplate',
	'centralnotice-desc' => 'Short description of the Centralnotice extension, shown in [[Special:Version]]. Do not translate or change links.',
	'centralnotice-summary' => 'Used in Special:CentralNotice',
	'centralnotice-enabled' => '{{Identical|Enabled}}',
	'centralnotice-modify' => '{{Identical|Submit}}',
	'centralnotice-preview' => '{{Identical|Preview}}',
	'centralnotice-remove' => '{{Identical|Remove}}',
	'centralnotice-translate-heading' => '$1 is a name of a template.',
	'centralnotice-add' => '{{Identical|Add}}',
	'centralnotice-translate' => '{{Identical|Translate}}',
	'centralnotice-notice-exists' => 'Errore message displayed in Special:CentralNotice when trying to add a notice with the same name of another notice',
	'centralnotice-template-exists' => 'Errore message displayed in Special:NoticeTemplate when trying to add a template with the same name of another template',
	'centralnotice-start-date' => 'Used in Special:CentralNotice',
	'centralnotice-start-time' => 'Used in Special:CentralNotice',
	'centralnotice-available-templates' => 'Used in Special:NoticeTemplate',
	'centralnotice-notice-is-locked' => 'Errore message displayed in Special:CentralNotice when trying to delete a locked notice',
	'centralnotice-no-notices-exist' => 'Used in Special:CentralNotice when there are no notices',
	'centralnotice-message' => '{{Identical|Message}}',
	'right-centralnotice-admin' => '{{doc-right}}',
	'right-centralnotice-translate' => '{{doc-right}}',
	'action-centralnotice-admin' => '{{doc-action}}',
	'action-centralnotice-translate' => '{{doc-action}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'centralnotice' => 'Bestuur sentrale kennisgewings',
	'noticetemplate' => 'Sjabloon vir sentrale kennisgewing',
	'centralnotice-desc' => "Voeg 'n sentrale stelselkennisgewing by",
	'centralnotice-end-date' => 'Einddatum',
	'centralnotice-enabled' => 'Aktief',
	'centralnotice-modify' => 'Dien in',
	'centralnotice-preview' => 'Voorskou',
	'centralnotice-add-new' => "Voeg 'n nuwe sentrale kennisgewing by",
	'centralnotice-remove' => 'Verwyder',
	'centralnotice-translate-heading' => 'Vertaling vir $1',
	'centralnotice-manage' => 'Beheer sentrale kennisgewings',
	'centralnotice-add' => 'Byvoeg',
	'centralnotice-add-template' => 'Voeg sjabloon by',
	'centralnotice-show-notices' => 'Wys kennisgewings',
	'centralnotice-list-templates' => 'Lys sjablone',
	'centralnotice-translations' => 'Vertalings',
	'centralnotice-translate-to' => 'Vertaal na',
	'centralnotice-translate' => 'Vertaal',
	'centralnotice-english' => 'Engels',
	'centralnotice-template-name' => 'Sjabloonnaam',
	'centralnotice-templates' => 'Sjablone',
	'centralnotice-weight' => 'Gewig',
	'centralnotice-locked' => 'Gesluit',
	'centralnotice-template-body' => 'Sjablooninhoud:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'Jaar',
	'centralnotice-month' => 'Maand',
	'centralnotice-hours' => 'Uur',
	'centralnotice-min' => 'Minuut',
	'centralnotice-project-lang' => 'Projektaal',
	'centralnotice-project-name' => 'Projeknaam',
	'centralnotice-start-date' => 'Begindatum',
	'centralnotice-start-time' => 'Begintyd (UTC)',
	'centralnotice-assigned-templates' => 'Aangewese sjablone',
	'centralnotice-start-hour' => 'Begintyd',
	'centralnotice-change-lang' => 'Verander taal vir vertaling',
	'centralnotice-weights' => 'Gewigte',
	'centralnotice-number-uses' => 'Aantal kere gebruik',
	'centralnotice-edit-template' => 'Wysig sjabloon',
	'centralnotice-message' => 'Boodskap',
	'right-centralnotice-admin' => 'Bestuur sentrale kennisgewings',
	'action-centralnotice-admin' => 'bestuur sentrale kennisgewings',
	'action-centralnotice-translate' => 'vertaal sentrale kennisgewings',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 * @author Elfalem
 */
$messages['am'] = array(
	'centralnotice-desc' => 'በሁሉም ገጾች ላይ የሚታይ መልዕክት ይጨምራል',
	'centralnotice-message' => 'መልእክት',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'centralnotice-desc' => 'Adibe una "sitenotice" zentral',
	'centralnotice-end-date' => 'Calendata final',
	'centralnotice-start-date' => 'Calendata de prenzipio',
	'centralnotice-invalid-date-range' => "Rango de datos no conforme.
No s'está adautando.",
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'centralnotice' => 'مدير الإخطار المركزي',
	'noticetemplate' => 'قالب الإخطار المركزي',
	'centralnotice-desc' => 'يضيف إعلانا مركزيا للموقع',
	'centralnotice-summary' => 'هذه الوحدة تسمح لك بتعديل إعدادات الإخطار المركزي الحالية.
يمكن أن تستخدم أيضا لإضافة أو إزالة إخطارات قديمة.',
	'centralnotice-query' => 'تعديل الإخطارات الحالية',
	'centralnotice-notice-name' => 'اسم الإخطار',
	'centralnotice-end-date' => 'تاريخ الانتهاء',
	'centralnotice-enabled' => 'مُفعّل',
	'centralnotice-modify' => 'سلّم',
	'centralnotice-preview' => 'عاين',
	'centralnotice-add-new' => 'أضف إخطار جديد مركزي',
	'centralnotice-remove' => 'أزل',
	'centralnotice-translate-heading' => 'ترجمة $1',
	'centralnotice-manage' => 'أدر الإخطار المركزي',
	'centralnotice-add' => 'أضف',
	'centralnotice-add-notice' => 'إضافة إخطار',
	'centralnotice-add-template' => 'إضافة قالب',
	'centralnotice-show-notices' => 'إظهار الإخطارات',
	'centralnotice-list-templates' => 'اعرض القوالب',
	'centralnotice-translations' => 'الترجمات',
	'centralnotice-translate-to' => 'ترجم إلى',
	'centralnotice-translate' => 'ترجم',
	'centralnotice-english' => 'الإنجليزية',
	'centralnotice-template-name' => 'اسم القالب',
	'centralnotice-templates' => 'القوالب',
	'centralnotice-weight' => 'الوزن',
	'centralnotice-locked' => 'مغلق',
	'centralnotice-notices' => 'الإخطارات',
	'centralnotice-notice-exists' => 'الإخطار موجود بالفعل.
لا إضافة',
	'centralnotice-template-exists' => 'القالب موجود فعلا
لا تضيفه',
	'centralnotice-notice-doesnt-exist' => 'الملاحظة غير موجودة.
لا شيء للإزالة',
	'centralnotice-template-still-bound' => 'القالب مازال مرتبطا بملاحظة.
لن تتم الإزالة.',
	'centralnotice-template-body' => 'جسم القالب:',
	'centralnotice-day' => 'اليوم',
	'centralnotice-year' => 'السنة',
	'centralnotice-month' => 'الشهر',
	'centralnotice-hours' => 'الساعة',
	'centralnotice-min' => 'الدقيقة',
	'centralnotice-project-lang' => 'لغة المشروع',
	'centralnotice-project-name' => 'اسم المشروع',
	'centralnotice-start-date' => 'تاريخ البدء',
	'centralnotice-start-time' => 'وقت البدء (غرينتش)',
	'centralnotice-assigned-templates' => 'القوالب المرتبطة',
	'centralnotice-no-templates' => 'لا قوالب موجود.
أضف بعضا منها!',
	'centralnotice-no-templates-assigned' => 'لا قوالب مرتبطة بالملاحظة.
أضف البعض!',
	'centralnotice-available-templates' => 'القوالب المتاحة',
	'centralnotice-template-already-exists' => 'القالب مربوط بالفعل بالحملة.
لن تتم الإضافة',
	'centralnotice-preview-template' => 'معاينة القالب',
	'centralnotice-start-hour' => 'وقت البدء',
	'centralnotice-change-lang' => 'تغيير لغة الترجمة',
	'centralnotice-weights' => 'الأوزان',
	'centralnotice-notice-is-locked' => 'الإخطار مغلق.
لا إزالة',
	'centralnotice-overlap' => 'الإخطار يتداخل مع وقت إخطار آخر.
لا إضافة',
	'centralnotice-invalid-date-range' => 'مدى تاريخ غير صحيح.
لا تحديث',
	'centralnotice-null-string' => 'لا يمكن إضافة نص مصفّر.
لا إضافة',
	'centralnotice-confirm-delete' => 'هل أنت متأكد من حذف هذا العنصر؟
هذا الإجراء لن يكون قابلا للاسترجاع',
	'centralnotice-no-notices-exist' => 'لا إخطارات موجودة.
أضف واحدا أسفله',
	'centralnotice-no-templates-translate' => 'لا يوجد أي قالب لتحرير ترجمته',
	'centralnotice-number-uses' => 'الاستخدامات',
	'centralnotice-edit-template' => 'حرّر قالبا',
	'centralnotice-message' => 'الرسالة',
	'centralnotice-message-not-set' => 'الرسالة غير مضبوطة',
	'centralnotice-clone' => 'استنساخ',
	'centralnotice-clone-notice' => 'أنشئ نسخة من القالب',
	'centralnotice-preview-all-template-translations' => 'عرض كل الترجمات المتوفرة للقالب',
	'right-centralnotice-admin' => 'أدر الإخطارات المركزية',
	'right-centralnotice-translate' => 'ترجم الإخطارات المركزية',
	'action-centralnotice-admin' => 'التحكم بالإعلانات المركزية',
	'action-centralnotice-translate' => 'ترجمة الإعلانات المركزية',
	'centralnotice-preferred' => 'مفضل',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'centralnotice' => 'مدير الاعلانات المركزية',
	'noticetemplate' => 'قالب الاعلانات المركزية',
	'centralnotice-desc' => 'بيحط اعلان مركزى للموقع',
	'centralnotice-summary' => 'الوحدة دى بتسمحلك بتعديل إعدادات الإخطار المركزي الحالية.
ممكن تستخدم كمان لإضافة أو إزالة إخطارات قديمة.',
	'centralnotice-query' => 'تعديل الاعلانات الموجودة دلوقتي',
	'centralnotice-notice-name' => 'اسم الاعلان',
	'centralnotice-end-date' => 'تاريخ الانتهاء',
	'centralnotice-enabled' => 'متشغل',
	'centralnotice-modify' => 'قدم',
	'centralnotice-preview' => 'اعمل بروفة',
	'centralnotice-add-new' => 'حط اعلان مركزي جديد',
	'centralnotice-remove' => 'شيل',
	'centralnotice-translate-heading' => 'الترجمة بتاعة $1',
	'centralnotice-manage' => 'ادارة الاعلانات المركزية',
	'centralnotice-add' => 'ضيف',
	'centralnotice-add-notice' => 'حط اعلان',
	'centralnotice-add-template' => 'ضيف قالب',
	'centralnotice-show-notices' => 'اظهر الاعلانات',
	'centralnotice-list-templates' => 'لستة القوالب',
	'centralnotice-translations' => 'الترجمات',
	'centralnotice-translate-to' => 'ترجم لـ',
	'centralnotice-translate' => 'ترجم',
	'centralnotice-english' => 'انجليزى',
	'centralnotice-template-name' => 'اسم القالب',
	'centralnotice-templates' => 'قوالب',
	'centralnotice-weight' => 'الوزن',
	'centralnotice-locked' => 'مقفول',
	'centralnotice-notices' => 'اعلانات',
	'centralnotice-notice-exists' => 'الاعلان موجود من قبل كده.
مافيش اصافة',
	'centralnotice-template-exists' => 'القالب موجود من قبل كده
مافيش اضافة',
	'centralnotice-notice-doesnt-exist' => 'الاعلان مش موجود
مافيش حاجة عشان تتشال',
	'centralnotice-template-still-bound' => 'القالب لسة مربوط بالاعلان.
ماينفعش يتشال.',
	'centralnotice-template-body' => 'جسم القالب:',
	'centralnotice-day' => 'اليوم',
	'centralnotice-year' => 'السنه',
	'centralnotice-month' => 'الشهر',
	'centralnotice-hours' => 'الساعة',
	'centralnotice-min' => 'الدقيقة',
	'centralnotice-project-lang' => 'اللغة بتاعة المشروع',
	'centralnotice-project-name' => 'الاسم بتاع المشروع',
	'centralnotice-start-date' => 'تاريخ البدايه',
	'centralnotice-start-time' => 'وقت البداية(يو تي سي)',
	'centralnotice-assigned-templates' => 'قالب موجود',
	'centralnotice-no-templates' => 'مافيش قوالب.
ضيف بعض القوالب!',
	'centralnotice-no-templates-assigned' => ' مافيش قالب موجود.
ضيف  قوالب',
	'centralnotice-available-templates' => 'القوالب الموجودة',
	'centralnotice-template-already-exists' => 'قالب موجود
. مافيش  إضافة',
	'centralnotice-preview-template' => 'معاينة القالب',
	'centralnotice-start-hour' => 'وقت البداية',
	'centralnotice-change-lang' => 'تغيير لغة الترجمه',
	'centralnotice-weights' => 'الاوزان',
	'centralnotice-notice-is-locked' => 'الاعلان مقفول.
مافيش مسح.',
	'centralnotice-overlap' => 'الإخطار يتداخل مع وقت إخطار تانى.
مافيش إضافة',
	'centralnotice-invalid-date-range' => 'مدى تاريخ مش صحيح.
مافيش تحديث',
	'centralnotice-null-string' => 'مش ممكن إضافة نص مصفّر.
مافيش  إضافة',
	'centralnotice-confirm-delete' => 'انت متأكد انك عايز تلغى الحتة دي؟
الاجراء دا مش ح يترجع فيه',
	'centralnotice-no-notices-exist' => 'مافيش اخطارات موجودة.
ضيف واحد تحته',
	'centralnotice-no-templates-translate' => 'مافيش أي قالب لتحرير ترجمته',
	'centralnotice-number-uses' => 'الاستعمالات',
	'centralnotice-edit-template' => 'عدل في القالب',
	'centralnotice-message' => 'الرسالة',
	'centralnotice-message-not-set' => 'الرسالة مش مظبوطة',
	'centralnotice-clone' => 'انسخ',
	'centralnotice-clone-notice' => 'اعمل نسخة من القالب',
	'centralnotice-preview-all-template-translations' => 'اعرض كل الترجمات الموجودة للقالب',
	'right-centralnotice-admin' => 'ادارة الاعلانات المركزيه',
	'right-centralnotice-translate' => 'ترجم الاعلانات المركزية',
	'action-centralnotice-admin' => 'ادارة الاعلانات المركزية',
	'action-centralnotice-translate' => 'ترجمة الاعلانات المركزية',
	'centralnotice-preferred' => ' مفضله',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'centralnotice-desc' => 'Añade una anuncia centralizada del sitiu (sitenotice)',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'centralnotice-desc' => 'یک مرکزی اخطار سایت هور کنت',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'centralnotice' => 'Кіраваньне цэнтралізаванымі паведамленьнямі',
	'noticetemplate' => 'Шаблён цэнтралізаванага паведамленьня',
	'centralnotice-desc' => 'Дадае цэнтралізаванае паведамленьне сайту',
	'centralnotice-summary' => 'Гэты модуль дазваляе Вам рэдагаваць Вашыя актуальныя цэнтралізаваныя паведамленьні.
Ён таксама можа выкарыстоўвацца для даданьня ці выдаленьня старых паведамленьняў.',
	'centralnotice-query' => 'Зьмяніць цяперашняе паведамленьне',
	'centralnotice-notice-name' => 'Назва паведамленьня',
	'centralnotice-end-date' => 'Дата заканчэньня',
	'centralnotice-enabled' => 'Уключана',
	'centralnotice-modify' => 'Захаваць',
	'centralnotice-preview' => 'Папярэдні прагляд',
	'centralnotice-add-new' => 'Дадаць новае цэнтралізаванае паведамленьне',
	'centralnotice-remove' => 'Выдаліць',
	'centralnotice-translate-heading' => 'Пераклад для $1',
	'centralnotice-manage' => 'Кіраваньне цэнтралізаванымі паведамленьнямі',
	'centralnotice-add' => 'Дадаць',
	'centralnotice-add-notice' => 'Дадаць паведамленьне',
	'centralnotice-add-template' => 'Дадаць шаблён',
	'centralnotice-show-notices' => 'Паказаць паведамленьні',
	'centralnotice-list-templates' => 'Сьпіс шаблёнаў',
	'centralnotice-translations' => 'Пераклады',
	'centralnotice-translate-to' => 'Пераклад на',
	'centralnotice-translate' => 'Пераклад',
	'centralnotice-english' => 'Ангельская',
	'centralnotice-template-name' => 'Назва шаблёну',
	'centralnotice-templates' => 'Шаблёны',
	'centralnotice-weight' => 'Вага',
	'centralnotice-locked' => 'Заблякаваны',
	'centralnotice-notices' => 'Паведамленьні',
	'centralnotice-notice-exists' => 'Паведамленьне ўжо існуе.
Новае не было дададзенае',
	'centralnotice-template-exists' => 'Шаблён ужо існуе.
Новы шаблён ня быў дададзены',
	'centralnotice-notice-doesnt-exist' => 'Паведамленьне не існуе.
Няма чаго выдаляць',
	'centralnotice-template-still-bound' => 'Шаблён па-ранейшаму зьвязаны з паведамленьнем.
Не выдаляецца.',
	'centralnotice-template-body' => 'Зьмест шаблёну:',
	'centralnotice-day' => 'Дзень',
	'centralnotice-year' => 'Год',
	'centralnotice-month' => 'Месяц',
	'centralnotice-hours' => 'Гадзіна',
	'centralnotice-min' => 'Хвіліна',
	'centralnotice-project-lang' => 'Мова праекту',
	'centralnotice-project-name' => 'Назва праекту',
	'centralnotice-start-date' => 'Дата пачатку',
	'centralnotice-start-time' => 'Час пачатку (UTC)',
	'centralnotice-assigned-templates' => 'Прызначаныя шаблёны',
	'centralnotice-no-templates' => 'Шаблёны ня знойдзеныя.
Дадайце якія-небудзь!',
	'centralnotice-no-templates-assigned' => 'Няма зьвязаных з паведамленьнем шаблёнаў.
Дадайце які-небудзь!',
	'centralnotice-available-templates' => 'Даступныя шаблёны',
	'centralnotice-template-already-exists' => 'Шаблён ужо выкарыстоўваецца ў кампаніі.
Ня быў дададзены',
	'centralnotice-preview-template' => 'Папярэдні прагляд шаблёну',
	'centralnotice-start-hour' => 'Час пачатку',
	'centralnotice-change-lang' => 'Зьмяніць мову перакладу',
	'centralnotice-weights' => 'Вагі',
	'centralnotice-notice-is-locked' => 'Паведамленьне заблякаванае.
Не выдаляецца',
	'centralnotice-overlap' => 'Час паведамленьня перакрываецца часам іншага паведамленьня.
Новае паведамленьне не было дададзенае',
	'centralnotice-invalid-date-range' => 'Няслушны дыяпазон датаў.
Не абнаўляецца',
	'centralnotice-null-string' => 'Немагчыма дадаць пусты радок.
Не дадаецца',
	'centralnotice-confirm-delete' => 'Вы ўпэўнены, што жадаеце выдаліць гэты элемэнт?
Гэта дзеяньне немагчыма будзе адмяніць.',
	'centralnotice-no-notices-exist' => 'Паведамленьняў няма.
Дадайце адно ніжэй',
	'centralnotice-no-templates-translate' => 'Няма шаблёнаў для рэдагаваньня перакладаў для',
	'centralnotice-number-uses' => 'Выкарыстоўвае',
	'centralnotice-edit-template' => 'Рэдагаваць шаблён',
	'centralnotice-message' => 'Паведамленьне',
	'centralnotice-message-not-set' => 'Паведамленьне не ўсталяванае',
	'centralnotice-clone' => 'Копія',
	'centralnotice-clone-notice' => 'Стварыць копію шаблёну',
	'centralnotice-preview-all-template-translations' => 'Праглядзець усе даступныя пераклады шаблёну',
	'right-centralnotice-admin' => 'Кіраваньне цэнтральнымі паведамленьнямі',
	'right-centralnotice-translate' => 'пераклад цэнтралізаваных паведамленьняў',
	'action-centralnotice-admin' => 'кіраваньне цэнтралізаванымі паведамленьнямі',
	'action-centralnotice-translate' => 'пераклад цэнтральных паведамленьняў',
	'centralnotice-preferred' => 'Пажадана',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'centralnotice-desc' => 'Добавя главнa сайтова бележка',
	'centralnotice-end-date' => 'Крайна дата',
	'centralnotice-modify' => 'Изпращане',
	'centralnotice-preview' => 'Преглеждане',
	'centralnotice-remove' => 'Премахване',
	'centralnotice-translate-heading' => 'Превод за $1',
	'centralnotice-add' => 'Добавяне',
	'centralnotice-add-template' => 'Добавяне на шаблон',
	'centralnotice-translations' => 'Преводи',
	'centralnotice-translate-to' => 'Превеждане на',
	'centralnotice-translate' => 'Превеждане',
	'centralnotice-english' => 'Английски',
	'centralnotice-template-name' => 'Име на шаблона',
	'centralnotice-templates' => 'Шаблони',
	'centralnotice-day' => 'Ден',
	'centralnotice-year' => 'Година',
	'centralnotice-month' => 'Месец',
	'centralnotice-hours' => 'Час',
	'centralnotice-min' => 'Минута',
	'centralnotice-start-date' => 'Начална дата',
	'centralnotice-start-time' => 'начално време (UTC)',
	'centralnotice-available-templates' => 'Налични шаблони',
	'centralnotice-start-hour' => 'Начален час',
	'centralnotice-edit-template' => 'Редактиране на шаблон',
	'centralnotice-message' => 'Съобщение',
	'centralnotice-clone' => 'Клониране',
	'centralnotice-clone-notice' => 'Създаване на копие на шаблона',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'centralnotice-desc' => 'একটি কেন্দ্রীয় সাইটনোটিশ যোগ করো',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'centralnotice-desc' => "Ouzhpennañ a ra ur c'hemenn kreiz e laez ar pajennoù (sitenotice).",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'centralnotice' => 'Uređivanje središnjeg obavještenja',
	'noticetemplate' => 'Šablon za središnju obavijest',
	'centralnotice-desc' => 'Dodaje središnju obavijest na stranici',
	'centralnotice-summary' => 'Ovaj modul omogućava uređivanje Vaših trenutno postavljenih središnjih obavještenja.
Također se može koristiti i za dodavanje ili uklanjanje starih obavještenja.',
	'centralnotice-query' => 'Izmjena trenutnog obavještenja',
	'centralnotice-notice-name' => 'Naziv obavještenja',
	'centralnotice-end-date' => 'Krajnji datum',
	'centralnotice-enabled' => 'Omogućeno',
	'centralnotice-modify' => 'Pošalji',
	'centralnotice-preview' => 'Izgled',
	'centralnotice-add-new' => 'Dodavanje novog središnjeg obavještenja',
	'centralnotice-remove' => 'Ukloni',
	'centralnotice-translate-heading' => 'Prijevod za $1',
	'centralnotice-manage' => 'Uređivanje središnje obavijesti',
	'centralnotice-add' => 'Dodaj',
	'centralnotice-add-notice' => 'Dodaj obavještenje',
	'centralnotice-add-template' => 'Dodaj šablon',
	'centralnotice-show-notices' => 'Prikaži obavještenja',
	'centralnotice-list-templates' => 'Spisak šablona',
	'centralnotice-translations' => 'Prijevodi',
	'centralnotice-translate-to' => 'Prevedi na',
	'centralnotice-translate' => 'Prijevod',
	'centralnotice-english' => 'engleski jezik',
	'centralnotice-template-name' => 'Naslov šablona',
	'centralnotice-templates' => 'Šabloni',
	'centralnotice-weight' => 'Težina',
	'centralnotice-locked' => 'Zaključano',
	'centralnotice-notices' => 'Obavještenja',
	'centralnotice-notice-exists' => 'Obavještenje već postoji.
Ne može se dodati',
	'centralnotice-template-exists' => 'Šablon već postoji.
Ne dodaje se',
	'centralnotice-notice-doesnt-exist' => 'Obavještenje ne postoji.
Ništa se ne uklanja',
	'centralnotice-template-still-bound' => 'Šablon je još uvijek povezan sa obavještenje.
Ne uklanja se',
	'centralnotice-template-body' => 'Tijelo šablona:',
	'centralnotice-day' => 'dan',
	'centralnotice-year' => 'godina',
	'centralnotice-month' => 'mjesec',
	'centralnotice-hours' => 'sat',
	'centralnotice-min' => 'minut',
	'centralnotice-project-lang' => 'Jezik projekta',
	'centralnotice-project-name' => 'Naslov projekta',
	'centralnotice-start-date' => 'Početni datum',
	'centralnotice-start-time' => 'Početno vrijeme (UTC)',
	'centralnotice-assigned-templates' => 'Dodijeljeni šabloni',
	'centralnotice-no-templates' => 'Nisu pronađeni šabloni.
Dodajte neki!',
	'centralnotice-no-templates-assigned' => 'Nijedan šablon nije pridružen obavještenju.
Dodajte neki!',
	'centralnotice-available-templates' => 'Dostupni šabloni',
	'centralnotice-template-already-exists' => 'Šablon je već povezan sa kampanjom.
Ne dodaje se',
	'centralnotice-preview-template' => 'Izgled šablona',
	'centralnotice-start-hour' => 'Vrijeme početka',
	'centralnotice-change-lang' => 'Promjena jezika prijevoda',
	'centralnotice-weights' => 'Težina',
	'centralnotice-notice-is-locked' => 'Obavještenje je zaključano.
Ne može se ukloniti',
	'centralnotice-overlap' => 'Obavještenje se preklapa u toku vremena sa drugim obavještenjem.
Ne može se dodati',
	'centralnotice-invalid-date-range' => 'Pogrešan vremenski period.
Ne može se ažurirati',
	'centralnotice-null-string' => 'Ne može se dodati prazan string.
Obavještenje nije dodano',
	'centralnotice-confirm-delete' => 'Da li ste sigurni da želite obrisati ovu stavku?
Ta akcija se ne može vratiti.',
	'centralnotice-no-notices-exist' => 'Ne postoji obavijest.
Dodaj jednu ispod',
	'centralnotice-no-templates-translate' => 'Nema ni jednog šablona za uređivanje prijevoda',
	'centralnotice-number-uses' => 'Upotreba',
	'centralnotice-edit-template' => 'Uredi šablon',
	'centralnotice-message' => 'Poruka',
	'centralnotice-message-not-set' => 'Poruka nije postavljena',
	'centralnotice-clone' => 'Klon',
	'centralnotice-clone-notice' => 'Pravi kopiju šablona',
	'centralnotice-preview-all-template-translations' => 'Pregled svih dostupnih prijevoda za šablon',
	'right-centralnotice-admin' => 'Uređivanje središnjeg obavještenja',
	'right-centralnotice-translate' => 'Prevođenje središnjeg obavještenja',
	'action-centralnotice-admin' => 'uređujete središnje obavještenje',
	'action-centralnotice-translate' => 'Prevođenje središnjeg obavještenja',
	'centralnotice-preferred' => 'Preferirano',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'centralnotice' => 'Správa centralizovaných oznámení',
	'noticetemplate' => 'Šablony centralizovaných oznámení',
	'centralnotice-desc' => 'Přidává centrální zprávu do záhlaví',
	'centralnotice-summary' => 'Pomocí tohoto modulu můžete upravovat momentálně nastavená centralizovaná oznámení.
Také zde můžete přidávat nová či odstraňovat stará.',
	'centralnotice-query' => 'Změnit současná oznámení',
	'centralnotice-notice-name' => 'Název oznámení',
	'centralnotice-end-date' => 'Datum konce',
	'centralnotice-enabled' => 'Zapnuto',
	'centralnotice-modify' => 'Odeslat',
	'centralnotice-preview' => 'Náhled',
	'centralnotice-add-new' => 'Přidat nové centrální oznámení',
	'centralnotice-remove' => 'Odstranit',
	'centralnotice-translate-heading' => 'Překlad šablony „$1“',
	'centralnotice-manage' => 'Spravovat centralizovaná oznámení',
	'centralnotice-add' => 'Přidat',
	'centralnotice-add-notice' => 'Přidat oznámení',
	'centralnotice-add-template' => 'Přidat šablonu',
	'centralnotice-show-notices' => 'Zobrazit oznámení',
	'centralnotice-list-templates' => 'Seznam šablon',
	'centralnotice-translations' => 'Překlady',
	'centralnotice-translate-to' => 'Přeložit do jazyka',
	'centralnotice-translate' => 'Přeložit',
	'centralnotice-english' => 'Anglicky',
	'centralnotice-template-name' => 'Název šablony',
	'centralnotice-templates' => 'Šablony',
	'centralnotice-weight' => 'Váha',
	'centralnotice-locked' => 'Uzamčeno',
	'centralnotice-notices' => 'Oznámení',
	'centralnotice-notice-exists' => 'Oznámení už existuje. Nepřidáno.',
	'centralnotice-template-exists' => 'Šablona už existuje. Nepřidána.',
	'centralnotice-notice-doesnt-exist' => 'Oznámení neexistuje. Není co odstranit.',
	'centralnotice-template-still-bound' => 'Šablona je stále navázána na oznámení. Nebude odstraněna.',
	'centralnotice-template-body' => 'Tělo šablony:',
	'centralnotice-day' => 'Den',
	'centralnotice-year' => 'Rok',
	'centralnotice-month' => 'Měsíc',
	'centralnotice-hours' => 'Hodiny',
	'centralnotice-min' => 'Minuty',
	'centralnotice-project-lang' => 'Jazyk projektu',
	'centralnotice-project-name' => 'Název projektu',
	'centralnotice-start-date' => 'Datum začátku',
	'centralnotice-start-time' => 'Čas začátku (UTC)',
	'centralnotice-assigned-templates' => 'Přiřazené šablony',
	'centralnotice-no-templates' => 'Nenalezena ani jedna šablona. Vytvořte nějakou!',
	'centralnotice-no-templates-assigned' => 'K oznámení nebyly přiřazeny žádné šablony. Přidejte nějaké!',
	'centralnotice-available-templates' => 'Dostupné šablony',
	'centralnotice-template-already-exists' => 'Šablona už byla s kampaní svázána.
Nebude přidána.',
	'centralnotice-preview-template' => 'Náhled šablony',
	'centralnotice-start-hour' => 'Čas začátku',
	'centralnotice-change-lang' => 'Změnit překládaný jazyk',
	'centralnotice-weights' => 'Váhy',
	'centralnotice-notice-is-locked' => 'Oznámení je uzamčeno. Nebude odstraněno.',
	'centralnotice-overlap' => 'Čas zobrazení oznámení se překrývá s časem zobrazení jiného oznámení.
Nebylo přidáno.',
	'centralnotice-invalid-date-range' => 'Neplatný rozsah dat. Nebude změněno.',
	'centralnotice-null-string' => 'Nelze přidat prázdný řetězec. Nebude přidáno.',
	'centralnotice-confirm-delete' => 'Jste si jisti, že chcete tuto položku smazat? Tuto operaci nebude možno vrátit.',
	'centralnotice-no-notices-exist' => 'Neexistují žádná oznámení.
Níže můžete vytvořit nové.',
	'centralnotice-no-templates-translate' => 'Nejsou žádné šablony, které by šlo přeložit',
	'centralnotice-number-uses' => 'Použití',
	'centralnotice-edit-template' => 'Upravit šablonu',
	'centralnotice-message' => 'Zpráva',
	'centralnotice-message-not-set' => 'Zpráva nebyla nastavena',
	'centralnotice-clone' => 'Naklonovat',
	'centralnotice-clone-notice' => 'Vytvořit kopii šablony',
	'centralnotice-preview-all-template-translations' => 'Náhled všech dostupných překladů šablony',
	'right-centralnotice-admin' => 'Správa centralizovaných oznámení',
	'right-centralnotice-translate' => 'Překlad centralizovaných oznámení',
	'action-centralnotice-admin' => 'spravovat centralizovaná oznámení',
	'action-centralnotice-translate' => 'překládat centralizovaná oznámení',
	'centralnotice-preferred' => 'Preferováno',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Purodha
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'centralnotice' => 'Administrierung der zentralen Meldungen',
	'noticetemplate' => 'Zentrale Meldungs-Vorlage',
	'centralnotice-desc' => "Fügt eine zentrale ''sitenotice'' hinzu",
	'centralnotice-summary' => 'Diese Erweiterung erlaubt die Konfiguration zentraler Meldungen.
Sie kann auch zur Erstellung neuer und Löschung alter Meldungen verwendet werden.',
	'centralnotice-query' => 'Aktuelle Meldung ändern',
	'centralnotice-notice-name' => 'Name der Notiz',
	'centralnotice-end-date' => 'Enddatum',
	'centralnotice-enabled' => 'Aktiviert',
	'centralnotice-modify' => 'OK',
	'centralnotice-preview' => 'Vorschau',
	'centralnotice-add-new' => 'Füge eine neue zentrale Meldung hinzu',
	'centralnotice-remove' => 'Entfernen',
	'centralnotice-translate-heading' => 'Übersetzung von „$1“',
	'centralnotice-manage' => 'Zentrale Meldungen verwalten',
	'centralnotice-add' => 'Hinzufügen',
	'centralnotice-add-notice' => 'Hinzufügen einer Meldung',
	'centralnotice-add-template' => 'Hinzufügen einer Vorlage',
	'centralnotice-show-notices' => 'Zeige Meldungen',
	'centralnotice-list-templates' => 'Vorlagen auflisten',
	'centralnotice-translations' => 'Übersetzungen',
	'centralnotice-translate-to' => 'Übersetzen in',
	'centralnotice-translate' => 'Übersetzen',
	'centralnotice-english' => 'Englisch',
	'centralnotice-template-name' => 'Name der Vorlage',
	'centralnotice-templates' => 'Vorlagen',
	'centralnotice-weight' => 'Gewicht',
	'centralnotice-locked' => 'Gesperrt',
	'centralnotice-notices' => 'Meldungen',
	'centralnotice-notice-exists' => 'Meldung ist bereits vorhanden.
Nicht hinzugefügt.',
	'centralnotice-template-exists' => 'Vorlage ist bereits vorhanden.
Nicht hinzugefügt.',
	'centralnotice-notice-doesnt-exist' => 'Meldung ist nicht vorhanden.
Entfernung nicht möglich.',
	'centralnotice-template-still-bound' => 'Vorlage ist noch an eine Meldung gebunden.
Entfernung nicht möglich.',
	'centralnotice-template-body' => 'Vorlagentext:',
	'centralnotice-day' => 'Tag',
	'centralnotice-year' => 'Jahr',
	'centralnotice-month' => 'Monat',
	'centralnotice-hours' => 'Stunde',
	'centralnotice-min' => 'Minute',
	'centralnotice-project-lang' => 'Projektsprache',
	'centralnotice-project-name' => 'Projektname',
	'centralnotice-start-date' => 'Startdatum',
	'centralnotice-start-time' => 'Startzeit (UTC)',
	'centralnotice-assigned-templates' => 'Zugewiesene Vorlagen',
	'centralnotice-no-templates' => 'Es sind keine Vorlagen im System vorhanden.',
	'centralnotice-no-templates-assigned' => 'Es sind keine Vorlagen an Meldungen zugewiesen.
Füge eine hinzu.',
	'centralnotice-available-templates' => 'Verfügbare Vorlagen',
	'centralnotice-template-already-exists' => 'Vorlage ist bereits an die Kampagne gebunden.
Nicht hinzugefügt.',
	'centralnotice-preview-template' => 'Vorschau Vorlage',
	'centralnotice-start-hour' => 'Startzeit',
	'centralnotice-change-lang' => 'Übersetzungssprache ändern',
	'centralnotice-weights' => 'Gewicht',
	'centralnotice-notice-is-locked' => 'Meldung ist gesperrt.
Entfernung nicht möglich.',
	'centralnotice-overlap' => 'Die Meldung überschneidet sich mit dem Zeitraum einer anderen Meldung.
Nicht hinzugefügt.',
	'centralnotice-invalid-date-range' => 'Ungültiger Zeitraum.
Nicht aktualisiert.',
	'centralnotice-null-string' => 'Es kann kein Nullstring hinzugefügt werden.
Nichts hinzugefügt.',
	'centralnotice-confirm-delete' => 'Bist du sicher, dass du den Eintrag löschen möchtest?
Die Aktion kann nicht rückgängig gemacht werden.',
	'centralnotice-no-notices-exist' => 'Es sind keine Meldungen vorhanden.
Füge eine hinzu.',
	'centralnotice-no-templates-translate' => 'Es gibt keine Vorlagen, für die Übersetzungen zu bearbeiten wären',
	'centralnotice-number-uses' => 'Nutzungen',
	'centralnotice-edit-template' => 'Vorlage bearbeiten',
	'centralnotice-message' => 'Nachricht',
	'centralnotice-message-not-set' => 'Nachricht nicht gesetzt',
	'centralnotice-clone' => 'Klon erstellen',
	'centralnotice-clone-notice' => 'Erstelle eine Kopie der Vorlage',
	'centralnotice-preview-all-template-translations' => 'Vorschau aller verfügbaren Übersetzungen einer Vorlage',
	'right-centralnotice-admin' => 'Verwalten von zentralen Meldungen',
	'right-centralnotice-translate' => 'Übersetzen von zentralen Meldungen',
	'action-centralnotice-admin' => 'Zentrale Seitennotiz verwalten',
	'action-centralnotice-translate' => 'Zentrale Seitennotiz übersetzen',
	'centralnotice-preferred' => 'Bevorzugt',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'centralnotice' => 'Administrěrowanje centralnych powěźeńkow',
	'noticetemplate' => 'Pśedłoga za centralne powěźeńki',
	'centralnotice-desc' => 'Pśidawa centralnu powěźeńku do głowy boka',
	'centralnotice-summary' => 'Toś ten modul zmóžnja wobźěłowanje tuchylu nastajenych centralnych powěźeńkow.
Dajo se teke wužywaś, aby se pśidali nowe powěźeńki abo wótpórali stare powěźeńki.',
	'centralnotice-query' => 'Centralne powěźeńki změniś',
	'centralnotice-notice-name' => 'Mě powěźeńki',
	'centralnotice-end-date' => 'Kóńcny datum',
	'centralnotice-enabled' => 'Zmóžnjony',
	'centralnotice-modify' => 'Wótpósłaś',
	'centralnotice-preview' => 'Pśeglěd',
	'centralnotice-add-new' => 'Nowu centralnu powěźeńku pśidaś',
	'centralnotice-remove' => 'Wótwónoźeś',
	'centralnotice-translate-heading' => 'Pśełožk za $1',
	'centralnotice-manage' => 'Centralne powěźeńki zastojaś',
	'centralnotice-add' => 'Pśidaś',
	'centralnotice-add-notice' => 'Powěźeńku pśidaś',
	'centralnotice-add-template' => 'Pśedłogu pśidaś',
	'centralnotice-show-notices' => 'Powěźeńki pokazaś',
	'centralnotice-list-templates' => 'Pśedłogi nalistowaś',
	'centralnotice-translations' => 'Pśełožki',
	'centralnotice-translate-to' => 'Pśełoźiś do',
	'centralnotice-translate' => 'Pśełožiś',
	'centralnotice-english' => 'Engelšćina',
	'centralnotice-template-name' => 'Mě pśedłogi',
	'centralnotice-templates' => 'Pśedłogi',
	'centralnotice-weight' => 'Wažnosć',
	'centralnotice-locked' => 'Zastajony',
	'centralnotice-notices' => 'Powěźeńki',
	'centralnotice-notice-exists' => 'Powěźeńka južo eksistěrujo.
Žedne pśidaśe',
	'centralnotice-template-exists' => 'Pśedłoga južo eksistěrujo.
Žedne pśidaśe',
	'centralnotice-notice-doesnt-exist' => 'Powěźeńka njeeksistěrujo.
Žedne wótpóranje',
	'centralnotice-template-still-bound' => 'Pśedłoga jo hyšći z powěźeńku zwězana.
Žedne wótpóranje.',
	'centralnotice-template-body' => 'Tekst pśedłogi:',
	'centralnotice-day' => 'Źeń',
	'centralnotice-year' => 'Lěto',
	'centralnotice-month' => 'Mjasec',
	'centralnotice-hours' => 'Góźina',
	'centralnotice-min' => 'Minuta',
	'centralnotice-project-lang' => 'Projektowa rěc',
	'centralnotice-project-name' => 'Projektowe mě',
	'centralnotice-start-date' => 'Startowy datum',
	'centralnotice-start-time' => 'Startowy cas (UTC)',
	'centralnotice-assigned-templates' => 'Pśipokazane pśedłogi',
	'centralnotice-no-templates' => 'Žedne pśedłogi namakane.
Pśidaj někotare!',
	'centralnotice-no-templates-assigned' => 'Žedne pśedłogi powěźeńce pśipokazane.
Pśidaj jadnu!',
	'centralnotice-available-templates' => 'K dispoziciji stojece pśedłogi',
	'centralnotice-template-already-exists' => 'Pśedłoga je južo z kampanju zwězana.
Žedne pśidaśe',
	'centralnotice-preview-template' => 'Pśeglěd pśedłogi',
	'centralnotice-start-hour' => 'Startowy cas',
	'centralnotice-change-lang' => 'Pśełožkowu rěc změniś',
	'centralnotice-weights' => 'Wagi',
	'centralnotice-notice-is-locked' => 'Powěźeńka jo zastajona.
Žedne wótpóranje',
	'centralnotice-overlap' => 'Powěźeńka prěcy se z casom drugeje powěźeńki.
Žedne pśidaśe',
	'centralnotice-invalid-date-range' => 'Njepłaśiwy cas.
Žedna aktualizacija',
	'centralnotice-null-string' => 'Prozny tekst njedajo se pśidaś.
Žedne pśidaśe',
	'centralnotice-confirm-delete' => 'Coš napšawdu toś ten zapisk wulašowaś?
Toś ta akcija njedajo se anulěrowaś.',
	'centralnotice-no-notices-exist' => 'Njeeksistěruju žedne powěźeńki.
Pśidaj jadnu.',
	'centralnotice-no-templates-translate' => 'Njejsu pśedłogi, za kótarež deje se pśełožki wobźěłaś',
	'centralnotice-number-uses' => 'Wužyśa',
	'centralnotice-edit-template' => 'Pśedłogu wobźěłaś',
	'centralnotice-message' => 'Powěźeńka',
	'centralnotice-message-not-set' => 'Powěźeńka njestajona',
	'centralnotice-clone' => 'Klonowaś',
	'centralnotice-clone-notice' => 'Kopiju pśedłogi napóraś',
	'centralnotice-preview-all-template-translations' => 'Pśeglěd wšych k dispoziciji stojecych pśełožkow pśedłogi',
	'right-centralnotice-admin' => 'Centralne powěźeńki zastojaś',
	'right-centralnotice-translate' => 'Centralne powěźeńki pśełožiś',
	'action-centralnotice-admin' => 'Centralne powěźeńki zastojaś',
	'action-centralnotice-translate' => 'Centralne powěźeńki pśełožiś',
	'centralnotice-preferred' => 'Preferěrowane',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Lou
 * @author ZaDiak
 */
$messages['el'] = array(
	'noticetemplate' => 'Πρότυπο κεντρικής ανακοίνωσης',
	'centralnotice-desc' => 'Προσθέτει μια κεντρική ανακοίνωση',
	'centralnotice-notice-name' => 'Όνομα σημείωσης',
	'centralnotice-end-date' => 'Ημερομηνία λήξης',
	'centralnotice-enabled' => 'Ενεργοποιημένο',
	'centralnotice-modify' => 'Καταχώρηση',
	'centralnotice-preview' => 'Προεπισκόπηση',
	'centralnotice-add-new' => 'Προσθήκη νέας κεντρικής ανακοίνωσης',
	'centralnotice-remove' => 'Αφαίρεση',
	'centralnotice-translate-heading' => 'Μετάφραση για το $1',
	'centralnotice-add' => 'Προσθήκη',
	'centralnotice-add-notice' => 'Προσθήκη ανακοίνωσης',
	'centralnotice-add-template' => 'Προσθήκη προτύπου',
	'centralnotice-show-notices' => 'Εμφάνιση ανακοινώσεων',
	'centralnotice-list-templates' => 'Κατάλογος προτύπων',
	'centralnotice-translations' => 'Μεταφράσεις',
	'centralnotice-translate-to' => 'Μετάφραση σε',
	'centralnotice-translate' => 'Μετάφραση',
	'centralnotice-english' => 'Αγγλικά',
	'centralnotice-template-name' => 'Όνομα προτύπου',
	'centralnotice-templates' => 'Πρότυπα',
	'centralnotice-weight' => 'Βάρος',
	'centralnotice-locked' => 'Κλειδωμένο',
	'centralnotice-notices' => 'Ανακοινώσεις',
	'centralnotice-notice-exists' => 'Η σημείωση υπάρχει ήδη.
Δεν προστίθεται',
	'centralnotice-template-exists' => 'Το πρότυπο υπάρχει ήδη.
Δεν προστέθηκε',
	'centralnotice-notice-doesnt-exist' => 'Η σημείωση δεν υπάρχει.
Τίποτα να αφαιρεθεί',
	'centralnotice-template-body' => 'Δομή προτύπου:',
	'centralnotice-day' => 'Ημέρα',
	'centralnotice-year' => 'Χρόνος',
	'centralnotice-month' => 'Μήνας',
	'centralnotice-hours' => 'Ώρα',
	'centralnotice-min' => 'Λεπτό',
	'centralnotice-project-lang' => 'Γλώσσα εγχειρήματος',
	'centralnotice-project-name' => 'Όνομα εγχειρήματος',
	'centralnotice-start-date' => 'Αρχική ημερομηνία',
	'centralnotice-start-time' => 'Χρόνος εκκίνησης (UTC)',
	'centralnotice-available-templates' => 'Διαθέσιμα πρότυπα',
	'centralnotice-preview-template' => 'Πρότυπο προεπισκόπησης',
	'centralnotice-start-hour' => 'Χρόνος εκκίνησης',
	'centralnotice-change-lang' => 'Αλλαγή της γλώσσας μετάφρασης',
	'centralnotice-weights' => 'Βάρη',
	'centralnotice-notice-is-locked' => 'Η σημείωση είναι κλειδωμένη.
Δεν θα αφαιρεθεί',
	'centralnotice-number-uses' => 'Χρήσεις',
	'centralnotice-edit-template' => 'Επεξεργασία προτύπου',
	'centralnotice-message' => 'Μήνυμα',
	'centralnotice-clone' => 'Κλώνος',
	'centralnotice-clone-notice' => 'Δημιουργία ενός αντίγραφου του προτύπου',
	'centralnotice-preferred' => 'Προτιμώμενα',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'centralnotice' => 'Administranto de centrala notico',
	'noticetemplate' => 'Ŝablono por centrala notico',
	'centralnotice-desc' => 'Aldonas centralan noticon por la vikio',
	'centralnotice-summary' => 'Ĉi tiu modulo permesas al vi redakti viajn aktualajn centralajn noticojn.
Ĝi ankaŭ estas uzable por aldoni aŭ forigi malfreŝajn noticojn.',
	'centralnotice-query' => 'Modifi nunajn noticojn',
	'centralnotice-notice-name' => 'Notica nomo',
	'centralnotice-end-date' => 'Fina dato',
	'centralnotice-enabled' => 'Ŝaltita',
	'centralnotice-modify' => 'Enigi',
	'centralnotice-preview' => 'Antaŭrigardo',
	'centralnotice-add-new' => 'Aldoni novan centralan noticon',
	'centralnotice-remove' => 'Forigi',
	'centralnotice-translate-heading' => 'Traduko por $1',
	'centralnotice-manage' => 'Administri centralan noticon',
	'centralnotice-add' => 'Aldoni',
	'centralnotice-add-notice' => 'Aldoni noticon',
	'centralnotice-add-template' => 'Aldoni ŝablonon',
	'centralnotice-show-notices' => 'Montri noticojn',
	'centralnotice-list-templates' => 'Rigardi ŝablonojn',
	'centralnotice-translations' => 'Tradukoj',
	'centralnotice-translate-to' => 'Traduki al',
	'centralnotice-translate' => 'Traduki',
	'centralnotice-english' => 'Angla',
	'centralnotice-template-name' => 'Ŝablona nomo',
	'centralnotice-templates' => 'Ŝablonoj',
	'centralnotice-weight' => 'Graveco',
	'centralnotice-locked' => 'Ŝlosita',
	'centralnotice-notices' => 'Noticoj',
	'centralnotice-notice-exists' => 'Notico jam ekzistas.
Ne aldonante',
	'centralnotice-template-exists' => 'Ŝablono jam ekzistas.
Ne aldonante',
	'centralnotice-notice-doesnt-exist' => 'Notico ne ekzistas.
Neniu forigi',
	'centralnotice-template-still-bound' => 'Ŝablono ankoraŭ estas ligita al notico.
Ne forigante.',
	'centralnotice-template-body' => 'Ŝablona korpo:',
	'centralnotice-day' => 'Tago',
	'centralnotice-year' => 'Jaro',
	'centralnotice-month' => 'Monato',
	'centralnotice-hours' => 'Horo',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Projekta lingvo',
	'centralnotice-project-name' => 'Projekta nomo',
	'centralnotice-start-date' => 'Komenca dato',
	'centralnotice-start-time' => 'Komenca tempo (UTC)',
	'centralnotice-assigned-templates' => 'Asignitaj ŝablonoj',
	'centralnotice-no-templates' => 'Neniuj ŝablonoj estis trovitaj.
Aldonu iujn!',
	'centralnotice-no-templates-assigned' => 'Neniuj ŝablonoj estas asignitaj al notico.
Aldonu iujn!',
	'centralnotice-available-templates' => 'Utileblaj ŝablonoj',
	'centralnotice-template-already-exists' => 'La ŝablono jam estas ligita al kampanjo.
Ne aldonante',
	'centralnotice-preview-template' => 'Antaŭrigardi ŝablonon',
	'centralnotice-start-hour' => 'Komenca tempo',
	'centralnotice-change-lang' => 'Ŝanĝi traduklingvon',
	'centralnotice-weights' => 'Pezoj',
	'centralnotice-notice-is-locked' => 'Notico estas ŝlosita.
Ne forigante',
	'centralnotice-overlap' => 'Notico kolizias inter la tempo de alia notico.
Ne aldonante',
	'centralnotice-invalid-date-range' => 'Nevalida data intervalo.
Ne ĝisdatigante',
	'centralnotice-null-string' => 'Ne povas aldoni nulan signoĉenon.
Ne aldonante.',
	'centralnotice-confirm-delete' => 'Ĉu vi certas ke vi volas forigi ĉi tiun aĵon?
Ĉi tiu ago ne estos malfarebla.',
	'centralnotice-no-notices-exist' => 'Neniuj noticoj ekzistas.
Afiŝu noticon suben',
	'centralnotice-no-templates-translate' => 'Ne estas iuj ŝablonoj por redakti tradukojn por',
	'centralnotice-number-uses' => 'Uzoj',
	'centralnotice-edit-template' => 'Redakti ŝablonojn',
	'centralnotice-message' => 'Mesaĝo',
	'centralnotice-message-not-set' => 'Mesaĝo ne estis ŝaltita',
	'centralnotice-clone' => 'Kloni',
	'centralnotice-clone-notice' => 'Krei duplikaton de la ŝablono',
	'centralnotice-preview-all-template-translations' => 'Antaŭvidi ĉiujn haveblajn tradukojn de ŝablono',
	'right-centralnotice-admin' => 'Administri centralajn noticojn',
	'right-centralnotice-translate' => 'Traduki centralajn noticojn',
	'action-centralnotice-admin' => 'administri centralajn noticojn',
	'action-centralnotice-translate' => 'traduki centralajn noticojn',
	'centralnotice-preferred' => 'Preferata',
);

/** Spanish (Español)
 * @author Imre
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'centralnotice' => 'Administración del aviso central',
	'noticetemplate' => 'Plantilla del aviso central',
	'centralnotice-desc' => 'Añade un mensaje central común a todos los proyectos.',
	'centralnotice-summary' => 'Este módulo te permite editar los parámetros actuales de los avisos centrales.
También puede usarse para añadir o borrar avisos antiguos.',
	'centralnotice-query' => 'Modificar avisos actuales',
	'centralnotice-notice-name' => 'Nombre del aviso',
	'centralnotice-end-date' => 'Fecha de fin',
	'centralnotice-enabled' => 'Habilitado',
	'centralnotice-modify' => 'Enviar',
	'centralnotice-preview' => 'Previsualizar',
	'centralnotice-add-new' => 'Añadir un nuevo aviso central',
	'centralnotice-remove' => 'Quitar',
	'centralnotice-translate-heading' => 'Traducción para $1',
	'centralnotice-manage' => 'Gestionar aviso central',
	'centralnotice-add' => 'Añadir',
	'centralnotice-add-notice' => 'Añadir un aviso',
	'centralnotice-add-template' => 'Añadir una plantilla',
	'centralnotice-show-notices' => 'Mostrar avisos',
	'centralnotice-list-templates' => 'Listar plantillas',
	'centralnotice-translations' => 'Traducciones',
	'centralnotice-translate-to' => 'Traducir al',
	'centralnotice-translate' => 'Traducir',
	'centralnotice-english' => 'Inglés',
	'centralnotice-template-name' => 'Nombre de la plantilla',
	'centralnotice-templates' => 'Plantillas',
	'centralnotice-weight' => 'Peso',
	'centralnotice-locked' => 'Cerrada con llave',
	'centralnotice-notices' => 'Avisos',
	'centralnotice-notice-exists' => 'El aviso ya existe.
No se ha añadido',
	'centralnotice-template-exists' => 'La plantilla ya exixte.
No se ha añadido',
	'centralnotice-notice-doesnt-exist' => 'El aviso no existe.
No hay nada que borrar',
	'centralnotice-template-still-bound' => 'La plantilla todavía está enlazada a un aviso.
No se borrará.',
	'centralnotice-template-body' => 'Cuerpo de la plantilla:',
	'centralnotice-day' => 'Día',
	'centralnotice-year' => 'Año',
	'centralnotice-month' => 'Mes',
	'centralnotice-hours' => 'Hora',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Idioma del proyecto',
	'centralnotice-project-name' => 'Nombre del proyecto',
	'centralnotice-start-date' => 'Fecha de inicio',
	'centralnotice-start-time' => 'Hora de inicio (UTC)',
	'centralnotice-assigned-templates' => 'Plantillas asignadas',
	'centralnotice-no-templates' => 'No hay plantillas.
¡Añade alguna!',
	'centralnotice-no-templates-assigned' => 'No hay plantillas asignadas a avisos.
¡Añade alguna!',
	'centralnotice-available-templates' => 'Plantillas disponibles',
	'centralnotice-template-already-exists' => 'La plantilla ya está atada a una campaña.
No se añade',
	'centralnotice-preview-template' => 'Previsualizar plantilla',
	'centralnotice-start-hour' => 'Hora de inicio',
	'centralnotice-change-lang' => 'Cambiar idioma de traducción',
	'centralnotice-weights' => 'Pesos',
	'centralnotice-notice-is-locked' => 'El aviso está cerrado con llave.
No se borrará',
	'centralnotice-overlap' => 'El aviso se solapa con el tiempo de otro.
No se añade',
	'centralnotice-invalid-date-range' => 'Rango de fechas no válido.
No se actualizará.',
	'centralnotice-null-string' => 'No se puede añadir una cadena vacía.
No se añadirá',
	'centralnotice-confirm-delete' => '¿Estás seguro de querer borrar este elemento?
Esta acción no se podrá deshacer.',
	'centralnotice-no-notices-exist' => 'No hay avisos.
Añade uno debajo',
	'centralnotice-no-templates-translate' => 'No hay plantillas de las que editar traducciones',
	'centralnotice-number-uses' => 'Usa',
	'centralnotice-edit-template' => 'Editar plantilla',
	'centralnotice-message' => 'Mensaje',
	'centralnotice-message-not-set' => 'No se ha establecido un mensaje',
	'centralnotice-clone' => 'Clonar',
	'centralnotice-clone-notice' => 'Crear una copia de la plantilla',
	'centralnotice-preview-all-template-translations' => 'Previsualizar todas las traducciones disponibles de la plantilla',
	'right-centralnotice-admin' => 'Gestionar avisos centrales',
	'right-centralnotice-translate' => 'Traducir avisos centrales',
	'action-centralnotice-admin' => 'gestionar avisos centrales',
	'action-centralnotice-translate' => 'traducir avisos centrales',
	'centralnotice-preferred' => 'Preferido',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'centralnotice' => 'Keskuse teate admin',
	'noticetemplate' => 'Keskuse teate mall',
	'centralnotice-notice-name' => 'Teate nimi',
	'centralnotice-end-date' => 'Tähtaeg',
	'centralnotice-enabled' => 'Luba olemas',
	'centralnotice-modify' => 'Esita',
	'centralnotice-preview' => 'Eelvaade',
	'centralnotice-add-new' => 'Lisa uus keskuse teade',
	'centralnotice-remove' => 'Eemalda',
	'centralnotice-translate-heading' => '$1 tõlge',
	'centralnotice-manage' => 'Muuda keskuse teadet',
	'centralnotice-add' => 'Lisa',
	'centralnotice-add-notice' => 'Lisa teade',
	'centralnotice-add-template' => 'Lisa mall',
	'centralnotice-show-notices' => 'Näita teateid',
	'centralnotice-list-templates' => 'Mallide list',
	'centralnotice-translations' => 'Tõlked',
	'centralnotice-translate-to' => 'Tõlgi',
	'centralnotice-translate' => 'Tõlgi',
	'centralnotice-english' => 'inglise',
	'centralnotice-template-name' => 'Malli nimi',
	'centralnotice-templates' => 'Mallid',
	'centralnotice-weight' => 'Kaal',
	'centralnotice-locked' => 'Lukustatud',
	'centralnotice-notices' => 'Teated',
	'centralnotice-notice-exists' => 'Teade on juba olemas.

Ei lisatud',
	'centralnotice-template-exists' => 'Mall on juba olemas.

Ei lisatud.',
	'centralnotice-notice-doesnt-exist' => 'Teadet ei ole.

Ei ole midagi eemaldada',
	'centralnotice-template-body' => 'Malli sisu:',
	'centralnotice-day' => 'Päev',
	'centralnotice-year' => 'Aasta',
	'centralnotice-month' => 'Kuu',
	'centralnotice-hours' => 'Tund',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Projekti keel',
	'centralnotice-project-name' => 'Projekti nimi',
	'centralnotice-start-date' => 'Alguse kuupäev',
	'centralnotice-start-time' => 'Alguse kellaaeg (UTC)',
	'centralnotice-no-templates' => 'Malle ei leitud.

Lisa mõni!',
	'centralnotice-available-templates' => 'Saadaolevad mallid',
	'centralnotice-preview-template' => 'Malli eelvaade',
	'centralnotice-start-hour' => 'Algusaeg',
	'centralnotice-change-lang' => 'Muuda tõlke keelt',
	'centralnotice-edit-template' => 'Muuda malli',
	'centralnotice-message' => 'Sõnum',
	'centralnotice-message-not-set' => 'Sõnumit ei ole seatud',
	'centralnotice-clone' => 'Kloon',
	'centralnotice-clone-notice' => 'Loo mallist koopia',
	'centralnotice-preview-all-template-translations' => 'Malli kõigi kättesaadavate tõlgete eelvaated',
	'right-centralnotice-admin' => 'Halda keskuse teateid',
	'right-centralnotice-translate' => 'Tõlgi keskuse teateid',
	'action-centralnotice-admin' => 'halda keskuse teateid',
	'action-centralnotice-translate' => 'tõlgi keskuse teateid',
	'centralnotice-preferred' => 'Eelistatud',
);

/** Basque (Euskara)
 * @author Theklan
 */
$messages['eu'] = array(
	'centralnotice-query' => 'Oraingo oharrak aldatu',
	'centralnotice-notice-name' => 'Oharraren izena',
	'centralnotice-end-date' => 'Bukaera data',
	'centralnotice-enabled' => 'Gaitua',
	'centralnotice-modify' => 'Bidali',
	'centralnotice-preview' => 'Aurreikusi',
	'centralnotice-add-new' => 'Mezu orokor berri bat gehitu',
	'centralnotice-remove' => 'Ezabatu',
	'centralnotice-translate-heading' => '$1(r)entzat itzulpena',
	'centralnotice-manage' => 'Ohar nagusia kudeatu',
	'centralnotice-add' => 'Gehitu',
	'centralnotice-add-notice' => 'Gehitu ohar bat',
	'centralnotice-add-template' => 'Txantiloi bat gehitu',
	'centralnotice-show-notices' => 'Oharrak erakutsi',
	'centralnotice-list-templates' => 'Txantiloiak zerrendatu',
	'centralnotice-translations' => 'Itzulpenak',
	'centralnotice-translate-to' => 'Hona itzuli',
);

/** Persian (فارسی)
 * @author Huji
 * @author Komeil 4life
 */
$messages['fa'] = array(
	'centralnotice' => 'مدیر اعلان متمرکز',
	'noticetemplate' => 'الگوی اعلان متمرکز',
	'centralnotice-desc' => 'یک اعلان متمرکز می‌افزاید',
	'centralnotice-summary' => 'این ابزار به شما اجازه می‌دهد که اعلانات متمرکز خود را ویرایش کنید.
از آن می‌توان برای افزودن یا برداشتن اعلان‌های قبلی نیز استفاده کرد.',
	'centralnotice-query' => 'تغییر اعلان‌های اخیر',
	'centralnotice-notice-name' => 'نام اعلان',
	'centralnotice-end-date' => 'تاریخ پایان',
	'centralnotice-enabled' => 'فعال',
	'centralnotice-modify' => 'ارسال',
	'centralnotice-preview' => 'نمایش',
	'centralnotice-add-new' => 'افزودن یک اعلان متمرکز جدید',
	'centralnotice-remove' => 'حذف',
	'centralnotice-translate-heading' => 'ترجمه از $1',
	'centralnotice-manage' => 'مدیریت اعلان متمرکز',
	'centralnotice-add' => 'اضافه کردن',
	'centralnotice-add-notice' => 'اضافه کردن خبر',
	'centralnotice-add-template' => 'اضافه کردن الگو',
	'centralnotice-show-notices' => 'نمایش اعلان‌ها',
	'centralnotice-list-templates' => 'فهرست الگوها',
	'centralnotice-translations' => 'ترجمه‌ها',
	'centralnotice-translate-to' => 'ترجمه به',
	'centralnotice-translate' => 'ترجمه کردن',
	'centralnotice-english' => 'انگلیسی',
	'centralnotice-template-name' => 'نام الگو',
	'centralnotice-templates' => 'الگوها',
	'centralnotice-weight' => 'وزن',
	'centralnotice-locked' => 'قفل شده',
	'centralnotice-notices' => 'اعلانات',
	'centralnotice-notice-exists' => 'اعلان از قبل وجود دارد.
افزوده نشد',
	'centralnotice-template-exists' => 'الگو از قبل وجود دارد.
افزوده نشد',
	'centralnotice-notice-doesnt-exist' => 'اعلان وجود ندارد.
چیزی برای حذف وجود ندارد',
	'centralnotice-template-still-bound' => 'الگو هنوز در اتصال با یک اعلان است.
حذف نشد',
	'centralnotice-template-body' => 'بدنه قالب:',
	'centralnotice-day' => 'روز',
	'centralnotice-year' => 'سال',
	'centralnotice-month' => 'ماه',
	'centralnotice-hours' => 'ساعت',
	'centralnotice-min' => 'دقیقه',
	'centralnotice-project-lang' => 'زبان پروژه',
	'centralnotice-project-name' => 'نام پروژه',
	'centralnotice-start-date' => 'تاریخ آغاز',
	'centralnotice-start-time' => 'زمان آغاز',
	'centralnotice-assigned-templates' => 'الگوهای متصل شده',
	'centralnotice-no-templates' => 'در این سیستم هیچ الگویی نیست. 
چندتا بسازید.',
	'centralnotice-no-templates-assigned' => 'الگویی به این اعلان متصل نیست.
اضافه کنید!',
	'centralnotice-available-templates' => 'الگوهای موجود',
	'centralnotice-template-already-exists' => 'الگو از قبل به اعلان گره خورده است.
افزوده نشد',
	'centralnotice-preview-template' => 'الگو نمایش',
	'centralnotice-start-hour' => 'زمان شروع',
	'centralnotice-change-lang' => 'تغییر زبان ترجمه',
	'centralnotice-weights' => 'وزن‌ها',
	'centralnotice-notice-is-locked' => 'اعلان قفل شده‌است.
افزوده نشد',
	'centralnotice-overlap' => 'اعلان با زمان یک اعلان دیگر تداخل دارد.
افزوده نشد',
	'centralnotice-invalid-date-range' => 'بازهٔ زمانی غیر مجاز.
به روز نشد',
	'centralnotice-null-string' => 'رشتهٔ خالی را نمی‌توان افزود.
افزوده نشد',
	'centralnotice-confirm-delete' => 'آیا مطمئن هستید که می‌خواهید این گزینه را حذف کنید؟
این عمل غیر قابل بازگشت خواهد بود.',
	'centralnotice-no-notices-exist' => 'اعلانی وجود ندارد.
یکی اضافه کنید',
	'centralnotice-no-templates-translate' => 'الگویی وجود ندارد که ترجمه‌اش را ویرایش کنید',
	'centralnotice-number-uses' => 'کاربردها',
	'centralnotice-edit-template' => 'الگو ویرایش',
	'centralnotice-message' => 'پیام',
	'centralnotice-message-not-set' => 'پیغام تنظیم نشده',
	'centralnotice-clone' => 'کلون',
	'centralnotice-clone-notice' => 'ایجاد یک کپی از الگو',
	'centralnotice-preview-all-template-translations' => 'پیش‌نمایش تمام ترجمه‌های موجود از الگو',
	'right-centralnotice-admin' => 'مدیریت اعلان‌های متمرکز',
	'right-centralnotice-translate' => 'ترجمهٔ اعلان‌های متمرکز',
	'action-centralnotice-admin' => 'مدیریت اعلان‌های متمرکز',
	'action-centralnotice-translate' => 'ترجمهٔ اعلان‌های متمرکز',
	'centralnotice-preferred' => 'ترجیح داده شده',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Tarmo
 */
$messages['fi'] = array(
	'centralnotice' => 'Keskitettyjen tiedotteiden ylläpito',
	'noticetemplate' => 'Keskitetyn tiedotteen malline',
	'centralnotice-desc' => 'Mahdollistaa keskitetyn sivustotiedotteen lisäämisen.',
	'centralnotice-summary' => 'Tämä moduuli antaa sinun muokata tällä hetkellä käytössä olevia keskitettyjä tiedotteita.
Voit myös lisätä tai poistaa vanhoja tiedotteita.',
	'centralnotice-query' => 'Muokkaa nykyisiä tiedotteita',
	'centralnotice-notice-name' => 'Tiedotteen nimi',
	'centralnotice-end-date' => 'Lopetuspäivä',
	'centralnotice-enabled' => 'Käytössä',
	'centralnotice-modify' => 'Lähetä',
	'centralnotice-preview' => 'Esikatselu',
	'centralnotice-add-new' => 'Lisää uusi keskitetty tiedote',
	'centralnotice-remove' => 'Poista',
	'centralnotice-translate-heading' => 'Käännös mallineelle $1',
	'centralnotice-manage' => 'Hallinnoi keskitettyä tiedotetta',
	'centralnotice-add' => 'Lisää',
	'centralnotice-add-notice' => 'Lisää tiedote',
	'centralnotice-add-template' => 'Lisää malline',
	'centralnotice-show-notices' => 'Näytä tiedotteet',
	'centralnotice-list-templates' => 'Luettele mallineet',
	'centralnotice-translations' => 'Käännökset',
	'centralnotice-translate-to' => 'Käännös:',
	'centralnotice-translate' => 'Käännä',
	'centralnotice-english' => 'Englanniksi',
	'centralnotice-template-name' => 'Mallineen nimi',
	'centralnotice-templates' => 'Mallineet',
	'centralnotice-weight' => 'Paino',
	'centralnotice-locked' => 'Lukittu',
	'centralnotice-notices' => 'Tiedotteet',
	'centralnotice-notice-exists' => 'Tiedote on jo olemassa.
Ei lisätä',
	'centralnotice-template-exists' => 'Malline on jo olemassa.
Ei lisätä',
	'centralnotice-notice-doesnt-exist' => 'Tiedotetta ei ole.
Ei mitään poistettavaa',
	'centralnotice-template-still-bound' => 'Malline on vielä kytkettynä tiedotteeseen.
Ei poisteta',
	'centralnotice-template-body' => 'Mallineen runko:',
	'centralnotice-day' => 'Päivä',
	'centralnotice-year' => 'Vuosi',
	'centralnotice-month' => 'Kuukausi',
	'centralnotice-hours' => 'Tunti',
	'centralnotice-min' => 'Minuutti',
	'centralnotice-project-lang' => 'Projektin kieli',
	'centralnotice-project-name' => 'Projektin nimi',
	'centralnotice-start-date' => 'Alkamispäivä',
	'centralnotice-start-time' => 'Alkamisaika (UTC)',
	'centralnotice-assigned-templates' => 'Kytketyt mallineet',
	'centralnotice-no-templates' => 'Ei löydy mallineita.
Lisää niitä.',
	'centralnotice-no-templates-assigned' => 'Ei tiedotteeseen kytkettyjä mallineita.
Lisää niitä!',
	'centralnotice-available-templates' => 'Käytettävät mallineet',
	'centralnotice-template-already-exists' => 'Malline on jo kytketty kampanjaan.
Ei lisätä',
	'centralnotice-preview-template' => 'Esikatsele malline',
	'centralnotice-start-hour' => 'Alkamisaika',
	'centralnotice-change-lang' => 'Vaihda käännöskieli',
	'centralnotice-weights' => 'Painot',
	'centralnotice-notice-is-locked' => 'Tiedote on lukittu.
Ei poisteta',
	'centralnotice-overlap' => 'Tiedote ulottuu ajallisesti toisen tiedotteen päälle.
Ei lisätä',
	'centralnotice-invalid-date-range' => 'Epäkelpo aikaväli.
Ei muuteta',
	'centralnotice-null-string' => 'Tyhjää merkkijonoa ei voida lisätä.
Ei lisätä',
	'centralnotice-confirm-delete' => 'Haluatko varmasti poistaa tämän?
Tätä tekoa ei voi perua.',
	'centralnotice-no-notices-exist' => 'Ei tiedotteita.
Lisää alapuolella sellainen',
	'centralnotice-no-templates-translate' => 'Ei mallineita, joiden käännöksiä voisi muokata',
	'centralnotice-number-uses' => 'Käyttää',
	'centralnotice-edit-template' => 'Muokkaa mallinetta',
	'centralnotice-message' => 'Viesti',
	'centralnotice-message-not-set' => 'Viestiä ei ole asetettu',
	'centralnotice-clone' => 'Kahdenna',
	'centralnotice-clone-notice' => 'Tee kopio mallineesta',
	'centralnotice-preview-all-template-translations' => 'Esikatsele kaikkia saatavilla olevia mallineen käännöksiä',
	'right-centralnotice-admin' => 'Hallinnoida keskitettyjä tiedotteita',
	'right-centralnotice-translate' => 'Kääntää keskitettyjä tiedotteita',
	'action-centralnotice-admin' => 'hallinnoida keskitettyjä tiedotteita',
	'action-centralnotice-translate' => 'kääntää keskitettyjä tiedotteita',
	'centralnotice-preferred' => 'Suositeltu',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Meithal
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'centralnotice' => 'Administration des avis centraux',
	'noticetemplate' => 'Modèles des avis centraux',
	'centralnotice-desc' => 'Ajoute un sitenotice central',
	'centralnotice-summary' => 'Ce module vous permet de modifier vos paramètrres des notifications centrales.',
	'centralnotice-query' => 'Modifier les avis actuels',
	'centralnotice-notice-name' => "Nom de l'avis",
	'centralnotice-end-date' => 'Date de fin',
	'centralnotice-enabled' => 'Activé',
	'centralnotice-modify' => 'Soumettre',
	'centralnotice-preview' => 'Prévisualisation',
	'centralnotice-add-new' => 'Ajouter un nouvel avis central',
	'centralnotice-remove' => 'Supprimer',
	'centralnotice-translate-heading' => 'Traduction de $1',
	'centralnotice-manage' => 'Gérer les avis centraux',
	'centralnotice-add' => 'Ajouter',
	'centralnotice-add-notice' => 'Ajouter un avis',
	'centralnotice-add-template' => 'Ajouter un modèle',
	'centralnotice-show-notices' => 'Afficher les avis',
	'centralnotice-list-templates' => 'Lister les modèles',
	'centralnotice-translations' => 'Traductions',
	'centralnotice-translate-to' => 'Traduire en',
	'centralnotice-translate' => 'Traduire',
	'centralnotice-english' => 'Anglais',
	'centralnotice-template-name' => 'Nom du modèle',
	'centralnotice-templates' => 'Modèles',
	'centralnotice-weight' => 'Poids',
	'centralnotice-locked' => 'Verrouillé',
	'centralnotice-notices' => 'Avis',
	'centralnotice-notice-exists' => "L'avis existe déjà.
Il n'a pas été ajouté.",
	'centralnotice-template-exists' => "Le modèle existe déjà.
Il n'a pas été ajouté.",
	'centralnotice-notice-doesnt-exist' => "L'avis n'existe pas.
Il n'y a rien à supprimer.",
	'centralnotice-template-still-bound' => "Le modèle est encore relié à un avis.
Il n'a pas été supprimé.",
	'centralnotice-template-body' => 'Corps du modèle :',
	'centralnotice-day' => 'Jour',
	'centralnotice-year' => 'Année',
	'centralnotice-month' => 'Mois',
	'centralnotice-hours' => 'Heure',
	'centralnotice-min' => 'Minute',
	'centralnotice-project-lang' => 'Langue du projet',
	'centralnotice-project-name' => 'Nom du projet',
	'centralnotice-start-date' => 'Date de début',
	'centralnotice-start-time' => 'Heure de début (UTC)',
	'centralnotice-assigned-templates' => 'Modèles assignés',
	'centralnotice-no-templates' => 'Il n’y a pas de modèle dans le système.',
	'centralnotice-no-templates-assigned' => "Aucun modèle assigné à l'avis.
Ajoutez-en un !",
	'centralnotice-available-templates' => 'Modèles disponibles',
	'centralnotice-template-already-exists' => 'Le modèle est déjà attaché à une campagne.
Ne pas ajouter',
	'centralnotice-preview-template' => 'Prévisualisation du modèle',
	'centralnotice-start-hour' => 'Heure de début',
	'centralnotice-change-lang' => 'Modifier la langue de traduction',
	'centralnotice-weights' => 'Poids',
	'centralnotice-notice-is-locked' => "L'avis est verrouillé.
Il n'a pas été supprimé.",
	'centralnotice-overlap' => 'Notification s’imbriquant dans le temps d’une autre.
Ne pas ajouter.',
	'centralnotice-invalid-date-range' => 'Tri de date incorrecte.
Ne pas mettre à jour.',
	'centralnotice-null-string' => 'Ne peut ajouter une chaîne nulle.
Ne pas ajouter.',
	'centralnotice-confirm-delete' => 'Êtes vous sûr que vous voulez supprimer cet article ?
Cette action ne pourra plus être récupérée.',
	'centralnotice-no-notices-exist' => 'Aucun avis existe.
Ajoutez-en un en dessous.',
	'centralnotice-no-templates-translate' => "Il n'y a aucun modèle à traduire",
	'centralnotice-number-uses' => 'Utilisateurs',
	'centralnotice-edit-template' => 'Modifier le modèle',
	'centralnotice-message' => 'Message',
	'centralnotice-message-not-set' => 'Message non renseigné',
	'centralnotice-clone' => 'Cloner',
	'centralnotice-clone-notice' => 'Créer une copie de ce modèle',
	'centralnotice-preview-all-template-translations' => 'Prévisualiser toutes les traductions de ce modèle',
	'right-centralnotice-admin' => 'Gérer les notifications centrales',
	'right-centralnotice-translate' => 'Traduire les notifications centrales',
	'action-centralnotice-admin' => 'gérer les avis centraux',
	'action-centralnotice-translate' => 'traduire les avis centraux',
	'centralnotice-preferred' => 'Préféré',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'centralnotice-desc' => 'Apond un sitenotice centrâl.',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'noticetemplate' => 'Teimpléad fógra lárnach',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'centralnotice' => 'Administración do aviso central',
	'noticetemplate' => 'Modelo do aviso central',
	'centralnotice-desc' => 'Engade un aviso central',
	'centralnotice-summary' => 'Este módulo permite editar os parámetros dos seus avisos centrais actuais.
Tamén pode ser usado para engadir ou eliminar avisos vellos.',
	'centralnotice-query' => 'Modificar os avisos actuais',
	'centralnotice-notice-name' => 'Nome do aviso',
	'centralnotice-end-date' => 'Data da fin',
	'centralnotice-enabled' => 'Permitido',
	'centralnotice-modify' => 'Enviar',
	'centralnotice-preview' => 'Vista previa',
	'centralnotice-add-new' => 'Engadir un novo aviso central',
	'centralnotice-remove' => 'Eliminar',
	'centralnotice-translate-heading' => 'Traducións de "$1"',
	'centralnotice-manage' => 'Xestionar o aviso central',
	'centralnotice-add' => 'Engadir',
	'centralnotice-add-notice' => 'Engadir un aviso',
	'centralnotice-add-template' => 'Engadir un modelo',
	'centralnotice-show-notices' => 'Amosar os avisos',
	'centralnotice-list-templates' => 'Listar os modelos',
	'centralnotice-translations' => 'Traducións',
	'centralnotice-translate-to' => 'Traducir ao',
	'centralnotice-translate' => 'Traducir',
	'centralnotice-english' => 'inglés',
	'centralnotice-template-name' => 'Nome do modelo',
	'centralnotice-templates' => 'Modelos',
	'centralnotice-weight' => 'Peso',
	'centralnotice-locked' => 'Bloqueado',
	'centralnotice-notices' => 'Avisos',
	'centralnotice-notice-exists' => 'O aviso xa existe.
Non se engade',
	'centralnotice-template-exists' => 'O modelo xa existe.
Non se engade',
	'centralnotice-notice-doesnt-exist' => 'O aviso non existe.
Non hai nada que eliminar',
	'centralnotice-template-still-bound' => 'O modelo aínda está ligado a un aviso.
Non se elimina.',
	'centralnotice-template-body' => 'Corpo do modelo:',
	'centralnotice-day' => 'Día',
	'centralnotice-year' => 'Ano',
	'centralnotice-month' => 'Mes',
	'centralnotice-hours' => 'Hora',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Lingua do proxecto',
	'centralnotice-project-name' => 'Nome do proxecto',
	'centralnotice-start-date' => 'Data de inicio',
	'centralnotice-start-time' => 'Hora de inicio (UTC)',
	'centralnotice-assigned-templates' => 'Modelos asignados',
	'centralnotice-no-templates' => 'Non se atopou ningún modelo.
Engada algún!',
	'centralnotice-no-templates-assigned' => 'Non hai modelos asignados a avisos.
Engada algún!',
	'centralnotice-available-templates' => 'Modelos dispoñibles',
	'centralnotice-template-already-exists' => 'O modelo xa está atado á campaña.
Non se engade',
	'centralnotice-preview-template' => 'Vista previa do modelo',
	'centralnotice-start-hour' => 'Hora de inicio',
	'centralnotice-change-lang' => 'Cambiar a lingua de tradución',
	'centralnotice-weights' => 'Pesos',
	'centralnotice-notice-is-locked' => 'O aviso está bloqueado.
Non se eliminará',
	'centralnotice-overlap' => 'O aviso superponse no tempo no que aparecerá outro.
Non se engade',
	'centralnotice-invalid-date-range' => 'Rango de datos inválido.
Non se actualizará',
	'centralnotice-null-string' => 'Non se pode engadir unha corda.
Non se engade',
	'centralnotice-confirm-delete' => 'Está seguro de que quere eliminar este elemento?
Esta acción non poderá ser recuperada',
	'centralnotice-no-notices-exist' => 'Non existe ningún aviso.
Engada algún embaixo',
	'centralnotice-no-templates-translate' => 'Non hai modelos que traducir',
	'centralnotice-number-uses' => 'Usos',
	'centralnotice-edit-template' => 'Editar o modelo',
	'centralnotice-message' => 'Mensaxe',
	'centralnotice-message-not-set' => 'Mensaxe sen fixar',
	'centralnotice-clone' => 'Clonar',
	'centralnotice-clone-notice' => 'Crear unha copia do modelo',
	'centralnotice-preview-all-template-translations' => 'Mostrar a vista previa de todas as traducións dispoñibles do modelo',
	'right-centralnotice-admin' => 'Xestionar os avisos centrais',
	'right-centralnotice-translate' => 'Traducir os avisos centrais',
	'action-centralnotice-admin' => 'xestionar os avisos centrais',
	'action-centralnotice-translate' => 'traducir os avisos centrais',
	'centralnotice-preferred' => 'Preferido',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'centralnotice-modify' => 'Ὑποβάλλειν',
	'centralnotice-preview' => 'Προθεωρεῖν',
	'centralnotice-remove' => 'Άφαιρεῖν',
	'centralnotice-add' => 'Προστιθέναι',
	'centralnotice-english' => 'Ἀγγλιστί',
	'centralnotice-weight' => 'Βάρος',
	'centralnotice-locked' => 'Κεκλῃσμένη',
	'centralnotice-notices' => 'Ἀναγγελίαι',
	'centralnotice-template-body' => 'Σῶμα προτύπου:',
	'centralnotice-preview-template' => 'Προθεωρεῖν πρότυπον',
	'centralnotice-weights' => 'Βάρη',
	'centralnotice-number-uses' => 'Χρήσεις',
	'centralnotice-preferred' => 'Προκρινομένη',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'centralnotice' => 'Adminischtrierig vu dr zentrale Mäldige',
	'noticetemplate' => 'Zentrali Mäldigs-Vorlag',
	'centralnotice-desc' => "Fiegt e zentrali ''sitenotice'' zue",
	'centralnotice-summary' => 'Die Erwyterig erlaubt d Konfiguration vu zentrale Mäldige.
Si cha au zum Aalege vu neije un dr Leschig vu alte Mäldige brucht wäre.',
	'centralnotice-query' => 'Aktuälli Mäldig ändere',
	'centralnotice-notice-name' => 'Name vu dr Notiz',
	'centralnotice-end-date' => 'Änddatum',
	'centralnotice-enabled' => 'Aktiviert',
	'centralnotice-modify' => 'In Ornig',
	'centralnotice-preview' => 'Vorschau',
	'centralnotice-add-new' => 'Fieg e neiji zentrali Mäldig zue',
	'centralnotice-remove' => 'Useneh',
	'centralnotice-translate-heading' => 'Ibersetzig vu „$1“',
	'centralnotice-manage' => 'Zentrali Mäldige verwalte',
	'centralnotice-add' => 'Zuefiege',
	'centralnotice-add-notice' => 'Zuefiege vun ere Mäldig',
	'centralnotice-add-template' => 'Zuefiege vun ere Vorlag',
	'centralnotice-show-notices' => 'Zeig Mäldige',
	'centralnotice-list-templates' => 'Vorlage uflischte',
	'centralnotice-translations' => 'Ibersetzige',
	'centralnotice-translate-to' => 'Ibersetze in',
	'centralnotice-translate' => 'Ibersetze',
	'centralnotice-english' => 'Änglisch',
	'centralnotice-template-name' => 'Name vu dr Vorlag',
	'centralnotice-templates' => 'Vorlage',
	'centralnotice-weight' => 'Gwicht',
	'centralnotice-locked' => 'Gsperrt',
	'centralnotice-notices' => 'Mäldige',
	'centralnotice-notice-exists' => 'Mäldig git s scho.
Nyt zuegfiegt.',
	'centralnotice-template-exists' => 'Vorlag git s scho.
Nyt zuegfiegt.',
	'centralnotice-notice-doesnt-exist' => 'Mäldig isch nit vorhande.
Useneh isch nit megli.',
	'centralnotice-template-still-bound' => 'Vorlag isch no an e Mäldig bunde.
Useneh nit megli.',
	'centralnotice-template-body' => 'Vorlagetäxt:',
	'centralnotice-day' => 'Tag',
	'centralnotice-year' => 'Johr',
	'centralnotice-month' => 'Monet',
	'centralnotice-hours' => 'Stund',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Projäktsproch',
	'centralnotice-project-name' => 'Projäktname',
	'centralnotice-start-date' => 'Startdatum',
	'centralnotice-start-time' => 'Startzyt (UTC)',
	'centralnotice-assigned-templates' => 'Zuegwiseni Vorlage',
	'centralnotice-no-templates' => 'S sin kei Vorlage im Syschtem vorhande.',
	'centralnotice-no-templates-assigned' => 'S sin kei Vorlage zuegwise zue Mäldige.
Fieg eini zue.',
	'centralnotice-available-templates' => 'Verfiegbari Vorlage',
	'centralnotice-template-already-exists' => 'Vorlage isch scho an d Kampagne bunde.
Nit zuegfiegt.',
	'centralnotice-preview-template' => 'Vorschau-Vorlag',
	'centralnotice-start-hour' => 'Startzyt',
	'centralnotice-change-lang' => 'Ibersetzigssproch ändere',
	'centralnotice-weights' => 'Gwicht',
	'centralnotice-notice-is-locked' => 'Mäldig isch gsperrt.
Useneh nit megli.',
	'centralnotice-overlap' => 'D Mäldig iberschnyydet si mit em Zytruum vun ere andere Mäldig.
Nit zuegfiegt.',
	'centralnotice-invalid-date-range' => 'Uugiltige Zytruum.
Nit aktualisiert.',
	'centralnotice-null-string' => 'S cha kei Nullstring zuegfiegt wäre.
Nyt zuegfiegt.',
	'centralnotice-confirm-delete' => 'Bisch sicher, ass Du dr Yytrag wit lesche?
D Aktion cha nit ruckgängig gmacht wäre.',
	'centralnotice-no-notices-exist' => 'S sin kei Mäldige vorhande.
Fieg eini zue.',
	'centralnotice-no-templates-translate' => 'S git kei Vorlage, wu Ibersetzige derfir z bearbeite wäre',
	'centralnotice-number-uses' => 'Nutzige',
	'centralnotice-edit-template' => 'Vorlag bearbeite',
	'centralnotice-message' => 'Nochricht',
	'centralnotice-message-not-set' => 'Nochricht nit gsetzt',
	'centralnotice-clone' => 'Klon aalege',
	'centralnotice-clone-notice' => 'Leg e Kopii vu dr Vorlag aa',
	'centralnotice-preview-all-template-translations' => 'Vorschau vu allene verfiegbare Ibersetzige vun ere Vorlag',
	'right-centralnotice-admin' => 'Zentrali Mäldige verwalte',
	'right-centralnotice-translate' => 'Zentrali Mäldige ibersetze',
	'action-centralnotice-admin' => 'Zentrali Sytenotize verwalte',
	'action-centralnotice-translate' => 'Zentrali Sytenotize ibersetze',
	'centralnotice-preferred' => 'Bevorzugt',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'centralnotice' => 'ניהול ההודעה המרכזית',
	'noticetemplate' => 'תבנית ההודעה המרכזית',
	'centralnotice-desc' => 'הוספת הודעה בראש הדף משרת מרכזי',
	'centralnotice-summary' => 'מודול זה מאפשר את עריכת ההודעות המרכזיות המותקנות כעת.
ניתן גם להשתמש בו כדי להוסיף או להסיר הודעות ישנות.',
	'centralnotice-query' => 'שינוי ההודעות הקיימות',
	'centralnotice-notice-name' => 'שם ההודעה',
	'centralnotice-end-date' => 'תאריך סיום',
	'centralnotice-enabled' => 'מופעלת',
	'centralnotice-modify' => 'שליחה',
	'centralnotice-preview' => 'תצוגה מקדימה',
	'centralnotice-add-new' => 'הוספת הודעה מרכזית חדשה',
	'centralnotice-remove' => 'הסרה',
	'centralnotice-translate-heading' => 'תרגום של $1',
	'centralnotice-manage' => 'ניהול ההודעה המרכזית',
	'centralnotice-add' => 'הוספה',
	'centralnotice-add-notice' => 'הוספת הודעה',
	'centralnotice-add-template' => 'הוספת תבנית',
	'centralnotice-show-notices' => 'הצגת הודעות',
	'centralnotice-list-templates' => 'רשימת תבניות',
	'centralnotice-translations' => 'תרגומים',
	'centralnotice-translate-to' => 'תרגום ל',
	'centralnotice-translate' => 'תרגום',
	'centralnotice-english' => 'אנגלית',
	'centralnotice-template-name' => 'שם התבנית',
	'centralnotice-templates' => 'תבניות',
	'centralnotice-weight' => 'משקל',
	'centralnotice-locked' => 'נעול',
	'centralnotice-notices' => 'הודעות',
	'centralnotice-notice-exists' => 'ההודעה כבר קיימת.
התוספת לא תבוצע',
	'centralnotice-template-exists' => 'התבנית כבר קיימת.
התוספת לא תבוצע',
	'centralnotice-notice-doesnt-exist' => 'ההודעה אינה קיימת.
אין מה להסיר',
	'centralnotice-template-still-bound' => 'התבנית עדיין מקושרת להודעה.
ההסרה לא תבוצע.',
	'centralnotice-template-body' => 'גוף ההודעה:',
	'centralnotice-day' => 'יום',
	'centralnotice-year' => 'שנה',
	'centralnotice-month' => 'חודש',
	'centralnotice-hours' => 'שעה',
	'centralnotice-min' => 'דקה',
	'centralnotice-project-lang' => 'שפת המיזם',
	'centralnotice-project-name' => 'שם המיזם',
	'centralnotice-start-date' => 'תאריך ההתחלה',
	'centralnotice-start-time' => 'שעת ההתחלה (UTC)',
	'centralnotice-assigned-templates' => 'תבניות מקושרות',
	'centralnotice-no-templates' => 'לא נמצאו תבניות.
הוסיפו כמה!',
	'centralnotice-no-templates-assigned' => 'אין תבניות המקושרות להודעה.
הוסיפו כמה!',
	'centralnotice-available-templates' => 'תבניות זמינות',
	'centralnotice-template-already-exists' => 'התבנית כבר קשורה להודעה.
התוספת לא תבוצע',
	'centralnotice-preview-template' => 'תצוגה מקדימה של התבנית',
	'centralnotice-start-hour' => 'זמן התחלה',
	'centralnotice-change-lang' => 'שינוי שפת התרגום',
	'centralnotice-weights' => 'משקלים',
	'centralnotice-notice-is-locked' => 'ההודעה נעולה.
היא לא תוסר',
	'centralnotice-overlap' => 'ההודעה מתנגשת עם הזמן של הודעה אחרת.
התוספת לא תבוצע',
	'centralnotice-invalid-date-range' => 'טווח תאריכים בלתי תקין.
העדכון לא יבוצע',
	'centralnotice-null-string' => 'לא ניתן להוסיף מחרוזת ריקה.
התוספת לא תבוצע',
	'centralnotice-confirm-delete' => 'האם אתם בטוחים שברצונכם למחוק פריט זה?
אין אפשרות לבטל פעולה זו.',
	'centralnotice-no-notices-exist' => 'אין עדיין הודעות.
הוסיפו אחת למטה',
	'centralnotice-no-templates-translate' => 'אין תבניות כדי לערוך את התרגומים שלהן',
	'centralnotice-number-uses' => 'משתמשת ב',
	'centralnotice-edit-template' => 'עריכת התבנית',
	'centralnotice-message' => 'הודעה',
	'centralnotice-message-not-set' => 'לא הוגדרה הודעה',
	'centralnotice-clone' => 'שכפול',
	'centralnotice-clone-notice' => 'יצירת עותק של התבנית',
	'centralnotice-preview-all-template-translations' => 'תצוגה מקדימה של כל התרגומים בתבנית',
	'right-centralnotice-admin' => 'ניהול הודעת מרכזיות',
	'right-centralnotice-translate' => 'תרגום הודעות מרכזיות',
	'action-centralnotice-admin' => 'לנהל הודעות מרכזיות',
	'action-centralnotice-translate' => 'לתרגם הודעות מרכזיות',
	'centralnotice-preferred' => 'מועדפת',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'centralnotice-desc' => 'सेंट्रल साईटनोटिस बढ़ायें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Suradnik13
 */
$messages['hr'] = array(
	'centralnotice' => 'Administracija središnjih obavijesti',
	'noticetemplate' => 'Predložak središnje obavijesti',
	'centralnotice-desc' => 'Dodaje središnju obavijest za projekt',
	'centralnotice-summary' => 'Ova stranica vam omogućava uređivanje trenutačno postavljenih središnjih obavijesti.
Može biti korištena i za dodavanje ili uklanjanje zastarjelih obavijesti.',
	'centralnotice-query' => 'Promijeni trenutačne obavijesti',
	'centralnotice-notice-name' => 'Naziv obavijesti',
	'centralnotice-end-date' => 'Završni datum',
	'centralnotice-enabled' => 'Omogućeno',
	'centralnotice-modify' => 'Postavi',
	'centralnotice-preview' => 'Pregledaj',
	'centralnotice-add-new' => 'Dodaj novu središnju obavijest',
	'centralnotice-remove' => 'Ukloni',
	'centralnotice-translate-heading' => 'Prijevod za $1',
	'centralnotice-manage' => 'Uredi središnje obavijesti',
	'centralnotice-add' => 'Dodaj',
	'centralnotice-add-notice' => 'Dodaj obavijest',
	'centralnotice-add-template' => 'Dodaj predložak',
	'centralnotice-show-notices' => 'Pokaži obavijesti',
	'centralnotice-list-templates' => 'Popis predložaka',
	'centralnotice-translations' => 'Prijevodi',
	'centralnotice-translate-to' => 'Prevedi na',
	'centralnotice-translate' => 'Prevedi',
	'centralnotice-english' => 'Engleski',
	'centralnotice-template-name' => 'Naziv predloška',
	'centralnotice-templates' => 'Predlošci',
	'centralnotice-weight' => 'Težina',
	'centralnotice-locked' => 'Zaključano',
	'centralnotice-notices' => 'Obavijesti',
	'centralnotice-notice-exists' => 'Obavijest već postoji.
Nije dodano',
	'centralnotice-template-exists' => 'Predložak već postoji.
Nije dodano',
	'centralnotice-notice-doesnt-exist' => 'Obavijest ne postoji.
Ništa nije uklonjeno',
	'centralnotice-template-still-bound' => 'Predložak je još uvijek vezan uz obavijest.
Nije uklonjeno.',
	'centralnotice-template-body' => 'Sadržaj predloška:',
	'centralnotice-day' => 'Dan',
	'centralnotice-year' => 'Godina',
	'centralnotice-month' => 'Mjesec',
	'centralnotice-hours' => 'Sat',
	'centralnotice-min' => 'Minuta',
	'centralnotice-project-lang' => 'Jezik projekta',
	'centralnotice-project-name' => 'Naziv projekta',
	'centralnotice-start-date' => 'Početni datum',
	'centralnotice-start-time' => 'Početno vrijeme (UTC)',
	'centralnotice-assigned-templates' => 'Dodijeljeni predlošci',
	'centralnotice-no-templates' => 'Nije pronađen ni jedan predložak.
Dodaj jedan!',
	'centralnotice-no-templates-assigned' => 'Nijedan predložak nije dodijeljen obavijesti.
Dodaj jedan!',
	'centralnotice-available-templates' => 'Dostupni predlošci',
	'centralnotice-template-already-exists' => 'Predložak je već vezan uz kampanju.
Nije dodano',
	'centralnotice-preview-template' => 'Pregledaj predložak',
	'centralnotice-start-hour' => 'Početno vrijeme',
	'centralnotice-change-lang' => 'Promijeni jezik prijevoda',
	'centralnotice-weights' => 'Težine',
	'centralnotice-notice-is-locked' => 'Obavijest je zaključana.
Nije uklonjeno',
	'centralnotice-overlap' => 'Obavijest se u vremenu preklapa s drugom obaviješću.
Nije dodana',
	'centralnotice-invalid-date-range' => 'Nevaljan opseg datuma.
Nije ažurirano',
	'centralnotice-null-string' => 'Nulta vrijednost se ne može dodati.
Nije dodano',
	'centralnotice-confirm-delete' => 'Jeste li sigurni da želite ovo obrisati?
Ova akcija se neće moći poništiti.',
	'centralnotice-no-notices-exist' => 'Ne postoji ni jedna obavijest.
Dodajte jednu ispod',
	'centralnotice-no-templates-translate' => 'Ne postoje predlošci za prevođenje',
	'centralnotice-number-uses' => 'Koristi',
	'centralnotice-edit-template' => 'Uredi predložak',
	'centralnotice-message' => 'Poruka',
	'centralnotice-message-not-set' => 'Poruka nije postavljena',
	'centralnotice-clone' => 'Kopija',
	'centralnotice-clone-notice' => 'Stvori kopiju predloška',
	'centralnotice-preview-all-template-translations' => 'Vidi sve dostupne prijevode predloška',
	'right-centralnotice-admin' => 'Uređivanje središnjih obavijesti',
	'right-centralnotice-translate' => 'Prevođenje središnjih obavijesti',
	'action-centralnotice-admin' => 'uređivanje središnjih obavijesti',
	'action-centralnotice-translate' => 'prevođenje središnjih obavijesti',
	'centralnotice-preferred' => 'Željeno',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'centralnotice' => 'Administrator centralnych powěsćow',
	'noticetemplate' => 'Předłoha za centralnu powěsć',
	'centralnotice-desc' => 'Přidawa centralnu bóčnu zdźělenku',
	'centralnotice-summary' => 'Tutón modul ći dowola, zo by swoje aktualnu konfiguraciju centralnych powěsćow wobdźěłał.
Hodźi so tež za přidaće abo wotstronjenje starych powěsćow wužiwać.',
	'centralnotice-query' => 'Aktualne zdźělenki změnić',
	'centralnotice-notice-name' => 'Mjeno powěsće',
	'centralnotice-end-date' => 'Kónčny datum',
	'centralnotice-enabled' => 'Zmóžnjeny',
	'centralnotice-modify' => 'Wotpósłać',
	'centralnotice-preview' => 'Přehlad',
	'centralnotice-add-new' => 'Nowu centralnu zdźělenku přidać',
	'centralnotice-remove' => 'Wotstronić',
	'centralnotice-translate-heading' => 'Přełožk za $1',
	'centralnotice-manage' => 'Centralne powěsće zrjadować',
	'centralnotice-add' => 'Přidać',
	'centralnotice-add-notice' => 'Powěsć přidać',
	'centralnotice-add-template' => 'Předłohu přidać',
	'centralnotice-show-notices' => 'Zdźělenki pokazać',
	'centralnotice-list-templates' => 'Předłohi nalistować',
	'centralnotice-translations' => 'Přełožki',
	'centralnotice-translate-to' => 'Přełožić do',
	'centralnotice-translate' => 'Přełožić',
	'centralnotice-english' => 'Jendźelšćina',
	'centralnotice-template-name' => 'Mjeno předłohi',
	'centralnotice-templates' => 'Předłohi',
	'centralnotice-weight' => 'Waha',
	'centralnotice-locked' => 'Zawrjeny',
	'centralnotice-notices' => 'Powěsće',
	'centralnotice-notice-exists' => 'Powěsć hižo eksistuje.
Njepřidawa so.',
	'centralnotice-template-exists' => 'Předłoha hižo eksistuje.
Njepřidawa so.',
	'centralnotice-notice-doesnt-exist' => 'Powěsć njeeksistuje.
Njewotstroni so ničo.',
	'centralnotice-template-still-bound' => 'Předłoha je hišće na powěsć zwjazana.
Njewotstronja so.',
	'centralnotice-template-body' => 'Tekst předłohi:',
	'centralnotice-day' => 'Dźeń',
	'centralnotice-year' => 'Lěto',
	'centralnotice-month' => 'Měsac',
	'centralnotice-hours' => 'Hodźina',
	'centralnotice-min' => 'Mjeńšina',
	'centralnotice-project-lang' => 'Projektowa rěč',
	'centralnotice-project-name' => 'Projektowe mjeno',
	'centralnotice-start-date' => 'Startowy datum',
	'centralnotice-start-time' => 'Startowy čas (UTC)',
	'centralnotice-assigned-templates' => 'Připokazane předłohi',
	'centralnotice-no-templates' => 'Žane předłohi namakane.
Přidaj někajke!',
	'centralnotice-no-templates-assigned' => 'Žane předłohi k powěsći připokazane.
Přidaj někajke!',
	'centralnotice-available-templates' => 'K dispozciji stejace předłohi',
	'centralnotice-template-already-exists' => 'Předłoha je hižo z kampanju zwjazana.
Njepřidawa so',
	'centralnotice-preview-template' => 'Přehlad předłohi',
	'centralnotice-start-hour' => 'Startowy čas',
	'centralnotice-change-lang' => 'Přełožowansku rěč změnić',
	'centralnotice-weights' => 'Wahi',
	'centralnotice-notice-is-locked' => 'Powěsć je zawrjena.
Njewotstronja so',
	'centralnotice-overlap' => 'Zdźělenka padnje do časa druheje zdźělenki.
Njepřidawa so',
	'centralnotice-invalid-date-range' => 'Njepłaćiwa doba.
Njeaktualizuje so',
	'centralnotice-null-string' => 'Njeda so prózdny znamjěskowy slěd přidać.
Njepřidawa so',
	'centralnotice-confirm-delete' => 'Chceš tutón zapisk woprawdźe wušmórnyć?
Tuta akcija njeda so cofnyć.',
	'centralnotice-no-notices-exist' => 'Powěsće njeeksistuja.
Přidaj někajku',
	'centralnotice-no-templates-translate' => 'Njejsu předłohi, za kotrež dyrbjeli so přełožki wobdźěłać',
	'centralnotice-number-uses' => 'Wužića',
	'centralnotice-edit-template' => 'Předłohu wobdźěłać',
	'centralnotice-message' => 'Powěsć',
	'centralnotice-message-not-set' => 'Powěsć njepostajena',
	'centralnotice-clone' => 'Klonować',
	'centralnotice-clone-notice' => 'Kopiju předłohi wutworić',
	'centralnotice-preview-all-template-translations' => 'Přehlad wšěch k dispoziciji stejacych přełožkow předłohi',
	'right-centralnotice-admin' => 'Centralne powěsće zrjadować',
	'right-centralnotice-translate' => 'Centralne powěsće přełožić',
	'action-centralnotice-admin' => 'Centralne powěsće zrjadować',
	'action-centralnotice-translate' => 'centralne powěsće přełožić',
	'centralnotice-preferred' => 'Preferowany',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'centralnotice' => 'Központi üzenet adminisztráció',
	'noticetemplate' => 'Központi üzenet-sablon',
	'centralnotice-desc' => 'Központi üzenet megjelenítése',
	'centralnotice-summary' => 'Ez a kiegészítő lehetővé teszi, hogy szerkeszd a jelenleg beállított központi üzeneteket.
Használhatod újak hozzáadására, vagy régiek eltávolítására is.',
	'centralnotice-query' => 'Jelenlegi üzenetek módosítása',
	'centralnotice-notice-name' => 'Üzenet neve',
	'centralnotice-end-date' => 'Befejezés dátuma',
	'centralnotice-enabled' => 'Engedélyezve',
	'centralnotice-modify' => 'Elküldés',
	'centralnotice-preview' => 'Előnézet',
	'centralnotice-add-new' => 'Új központi üzenet hozzáadása',
	'centralnotice-remove' => 'Eltávolítás',
	'centralnotice-translate-heading' => '$1 fordítása',
	'centralnotice-manage' => 'Központi üzenet beállítása',
	'centralnotice-add' => 'Hozzáadás',
	'centralnotice-add-notice' => 'Üzenet hozzáadása',
	'centralnotice-add-template' => 'Sablon hozzáadása',
	'centralnotice-show-notices' => 'Üzenetek megjelenítése',
	'centralnotice-list-templates' => 'Sablonok listázása',
	'centralnotice-translations' => 'Fordítások',
	'centralnotice-translate-to' => 'Lefordítás',
	'centralnotice-translate' => 'Lefordítás',
	'centralnotice-english' => 'angol',
	'centralnotice-template-name' => 'Sablonnév',
	'centralnotice-templates' => 'Sablonok',
	'centralnotice-weight' => 'Súly',
	'centralnotice-locked' => 'Lezárva',
	'centralnotice-notices' => 'Üzenetek',
	'centralnotice-notice-exists' => 'Az üzenet már létezik.
Nem történt hozzáadás.',
	'centralnotice-template-exists' => 'A sablon már létezik.
Nem történt hozzáadás.',
	'centralnotice-notice-doesnt-exist' => 'Az üzenet nem létezik.
Nincs mit eltávolítani.',
	'centralnotice-template-still-bound' => 'A sablon nem létezik.
Nincs mit eltávolítani.',
	'centralnotice-template-body' => 'Sablon törzse:',
	'centralnotice-day' => 'Nap',
	'centralnotice-year' => 'Év',
	'centralnotice-month' => 'Hónap',
	'centralnotice-hours' => 'Óra',
	'centralnotice-min' => 'Perc',
	'centralnotice-project-lang' => 'Projekt nyelve',
	'centralnotice-project-name' => 'Projekt neve',
	'centralnotice-start-date' => 'Kezdési dátum',
	'centralnotice-start-time' => 'Kezdési idő (UTC)',
	'centralnotice-assigned-templates' => 'Hozzárendelt sablonok',
	'centralnotice-no-templates' => 'Nem találhatóak sablonok.
Adj hozzá néhányat.',
	'centralnotice-no-templates-assigned' => 'Nincsenek sablonok rendelve az üzenethez.
Adj hozzá néhányat.',
	'centralnotice-available-templates' => 'Elérhető sablonok',
	'centralnotice-template-already-exists' => 'A sablon már hozzá van rendelve a kampányhoz.
Nem történt hozzáadás',
	'centralnotice-preview-template' => 'Sablon előnézete',
	'centralnotice-start-hour' => 'Kezdési idő',
	'centralnotice-change-lang' => 'Fordítási nyelv megváltoztatása',
	'centralnotice-weights' => 'Súlyok',
	'centralnotice-notice-is-locked' => 'Az üzenet le van zárva.
Nem történt eltávolítás.',
	'centralnotice-overlap' => 'Az üzenet le van zárva.
Nem történt hozzáadás.',
	'centralnotice-invalid-date-range' => 'Érvénytelen időtartam.
Nem történt módosítás.',
	'centralnotice-null-string' => 'Nem adhatsz hozzá üres szöveget.
Nem történt hozzáadás.',
	'centralnotice-confirm-delete' => 'Biztos, hogy törölni szeretnéd ezt az elemet?
A művelet visszavonhatatlan.',
	'centralnotice-no-notices-exist' => 'Nincsenek üzenetek.
Itt adhatsz hozzá újakat.',
	'centralnotice-no-templates-translate' => 'Nincs egyetlen sablon sem, amit fordítani lehetne',
	'centralnotice-number-uses' => 'Használatok',
	'centralnotice-edit-template' => 'Sablon szerkesztése',
	'centralnotice-message' => 'Üzenet',
	'centralnotice-message-not-set' => 'Üzenet nincs beállítva',
	'centralnotice-clone' => 'Klónozás',
	'centralnotice-clone-notice' => 'Másolat készítése a sablonról',
	'centralnotice-preview-all-template-translations' => 'A sablon összes fordításának megtekintése',
	'right-centralnotice-admin' => 'központi üzenetek beállítása',
	'right-centralnotice-translate' => 'központi üzenetek fordítása',
	'action-centralnotice-admin' => 'központi üzenetek beállítása',
	'action-centralnotice-translate' => 'központi üzenetek fordítása',
	'centralnotice-preferred' => 'Előnyben részesített',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'centralnotice' => 'Administration de avisos central',
	'noticetemplate' => 'Patrono de avisos central',
	'centralnotice-desc' => 'Adde un aviso de sito central',
	'centralnotice-summary' => 'Iste modulo permitte modificar le avisos central actualmente configurate.
Illo pote tamben esser usate pro adder o remover avisos ancian.',
	'centralnotice-query' => 'Modificar avisos actual',
	'centralnotice-notice-name' => 'Nomine del aviso',
	'centralnotice-end-date' => 'Data de fin',
	'centralnotice-enabled' => 'Active',
	'centralnotice-modify' => 'Submitter',
	'centralnotice-preview' => 'Previsualisar',
	'centralnotice-add-new' => 'Adder un nove aviso central',
	'centralnotice-remove' => 'Remover',
	'centralnotice-translate-heading' => 'Traduction de $1',
	'centralnotice-manage' => 'Gerer aviso central',
	'centralnotice-add' => 'Adder',
	'centralnotice-add-notice' => 'Adder un aviso',
	'centralnotice-add-template' => 'Adder un patrono',
	'centralnotice-show-notices' => 'Monstrar avisos',
	'centralnotice-list-templates' => 'Listar patronos',
	'centralnotice-translations' => 'Traductiones',
	'centralnotice-translate-to' => 'Traducer in',
	'centralnotice-translate' => 'Traducer',
	'centralnotice-english' => 'Anglese',
	'centralnotice-template-name' => 'Nomine del patrono',
	'centralnotice-templates' => 'Patronos',
	'centralnotice-weight' => 'Peso',
	'centralnotice-locked' => 'Serrate',
	'centralnotice-notices' => 'Avisos',
	'centralnotice-notice-exists' => 'Aviso existe ja.
Non es addite',
	'centralnotice-template-exists' => 'Patrono existe ja.
Non es addite',
	'centralnotice-notice-doesnt-exist' => 'Aviso non existe.
Nihil a remover',
	'centralnotice-template-still-bound' => 'Patrono es ancora ligate a un aviso.
Non es removite.',
	'centralnotice-template-body' => 'Corpore del patrono:',
	'centralnotice-day' => 'Die',
	'centralnotice-year' => 'Anno',
	'centralnotice-month' => 'Mense',
	'centralnotice-hours' => 'Hora',
	'centralnotice-min' => 'Minuta',
	'centralnotice-project-lang' => 'Lingua del projecto',
	'centralnotice-project-name' => 'Nomine del projecto',
	'centralnotice-start-date' => 'Data de initio',
	'centralnotice-start-time' => 'Tempore de initio (UTC)',
	'centralnotice-assigned-templates' => 'Patronos assignate',
	'centralnotice-no-templates' => 'Nulle patrono trovate.
Adde alcunes!',
	'centralnotice-no-templates-assigned' => 'Nulle patronos assignate al aviso.
Adde alcunes!',
	'centralnotice-available-templates' => 'Patronos disponibile',
	'centralnotice-template-already-exists' => 'Le patrono es ja ligate a un campania.
Non es addite',
	'centralnotice-preview-template' => 'Previsualisar patrono',
	'centralnotice-start-hour' => 'Tempore de initio',
	'centralnotice-change-lang' => 'Cambiar lingua de traduction',
	'centralnotice-weights' => 'Pesos',
	'centralnotice-notice-is-locked' => 'Aviso es serrate.
Non es removite',
	'centralnotice-overlap' => 'Aviso imbrica in le tempore de un altere aviso.
Non es addite',
	'centralnotice-invalid-date-range' => 'Intervallo incorrecte de datas.
Non es actualisate',
	'centralnotice-null-string' => 'Non pote adder un catena de characteres vacue.
Non es addite',
	'centralnotice-confirm-delete' => 'Es tu secur que tu vole deler iste articulo?
Iste action essera irrecuperabile.',
	'centralnotice-no-notices-exist' => 'Nulle aviso existe.
Adde un infra',
	'centralnotice-no-templates-translate' => 'Non existe alcun patrono a traducer',
	'centralnotice-number-uses' => 'Usos',
	'centralnotice-edit-template' => 'Modificar patrono',
	'centralnotice-message' => 'Message',
	'centralnotice-message-not-set' => 'Message non definite',
	'centralnotice-clone' => 'Clonar',
	'centralnotice-clone-notice' => 'Crear un copia del patrono',
	'centralnotice-preview-all-template-translations' => 'Previsualiar tote le traductiones disponibile del patrono',
	'right-centralnotice-admin' => 'Gerer avisos central',
	'right-centralnotice-translate' => 'Traducer avisos central',
	'action-centralnotice-admin' => 'gerer avisos central',
	'action-centralnotice-translate' => 'traducer avisos central',
	'centralnotice-preferred' => 'Preferite',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'centralnotice-desc' => 'Menambahkan pengumuman situs terpusat',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'centralnotice' => 'Gestione avviso centralizzato',
	'noticetemplate' => 'Template avvisi centralizzati',
	'centralnotice-desc' => 'Aggiunge un avviso centralizzato a inizio pagina (sitenotice)',
	'centralnotice-summary' => 'Questo modulo permette di modificare gli avvisi centralizzati. Puoi essere inoltre usato per aggiungere o rimuovere vecchi avvisi.',
	'centralnotice-query' => 'Modifica avvisi attuali',
	'centralnotice-notice-name' => "Nome dell'avviso",
	'centralnotice-end-date' => 'Data di fine',
	'centralnotice-enabled' => 'Attivato',
	'centralnotice-modify' => 'Invia',
	'centralnotice-preview' => 'Anteprima',
	'centralnotice-add-new' => 'Aggiungi un nuovo avviso centralizzato',
	'centralnotice-remove' => 'Rimuovi',
	'centralnotice-translate-heading' => 'Traduzione di $1',
	'centralnotice-manage' => 'Gestione avvisi centralizzati',
	'centralnotice-add' => 'Aggiungi',
	'centralnotice-add-notice' => 'Aggiungi un avviso',
	'centralnotice-add-template' => 'Aggiungi un template',
	'centralnotice-show-notices' => 'Mostra avvisi',
	'centralnotice-translations' => 'Traduzioni',
	'centralnotice-translate-to' => 'Traduci in',
	'centralnotice-translate' => 'Traduci',
	'centralnotice-english' => 'Inglese',
	'centralnotice-template-name' => 'Nome template',
	'centralnotice-templates' => 'Template',
	'centralnotice-locked' => 'Bloccato',
	'centralnotice-notices' => 'Avvisi',
	'centralnotice-notice-exists' => "Avviso già esistente. L'avviso non è stato aggiunto",
	'centralnotice-template-exists' => 'Template già esistente. Il template non è stato aggiunto',
	'centralnotice-notice-doesnt-exist' => 'Avviso non esistente. Niente da rimuovere',
	'centralnotice-template-body' => 'Corpo del template:',
	'centralnotice-day' => 'Giorno',
	'centralnotice-year' => 'Anno',
	'centralnotice-month' => 'Mese',
	'centralnotice-hours' => 'Ora',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Lingua progetto',
	'centralnotice-project-name' => 'Nome progetto',
	'centralnotice-start-date' => 'Data di inizio',
	'centralnotice-start-time' => 'Ora di inizio (UTC)',
	'centralnotice-assigned-templates' => 'Template assegnati',
	'centralnotice-no-templates' => 'Nessun template trovato. Aggiungine qualcuno!',
	'centralnotice-available-templates' => 'Template disponibili',
	'centralnotice-preview-template' => 'Anteprima template',
	'centralnotice-start-hour' => 'Ora di inizio',
	'centralnotice-change-lang' => 'Cambia lingua della traduzione',
	'centralnotice-notice-is-locked' => "L'avviso è bloccato. Avviso non rimosso",
	'centralnotice-confirm-delete' => "Sei veramente sicuro di voler cancellare questo elemento? L'azione non è reversibile.",
	'centralnotice-no-notices-exist' => 'Non esiste alcun avviso. Aggiungine uno di seguito',
	'centralnotice-number-uses' => 'Usi',
	'centralnotice-edit-template' => 'Modifica template',
	'centralnotice-message' => 'Messaggio',
	'centralnotice-clone' => 'Clona',
	'centralnotice-clone-notice' => 'Crea una copia del template',
	'right-centralnotice-admin' => 'Gestisce gli avvisi centralizzati',
	'right-centralnotice-translate' => 'Traduce avvisi centralizzati',
	'action-centralnotice-admin' => 'gestire gli avvisi centralizzati',
	'action-centralnotice-translate' => 'tradurre avvisi centralizzati',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'centralnotice-desc' => '中央管理のサイトのお知らせを追加する',
	'centralnotice-notice-name' => '通知名',
	'centralnotice-end-date' => '終了日',
	'centralnotice-enabled' => '有効',
	'centralnotice-modify' => '投稿',
	'centralnotice-preview' => 'プレビュー',
	'centralnotice-remove' => '除去',
	'centralnotice-translate-heading' => '$1の翻訳',
	'centralnotice-manage' => '中央管理のお知らせの編集',
	'centralnotice-add' => '追加',
	'centralnotice-add-notice' => 'お知らせを追加',
	'centralnotice-add-template' => 'テンプレートを追加',
	'centralnotice-translations' => '翻訳',
	'centralnotice-translate-to' => '翻訳先',
	'centralnotice-translate' => '翻訳',
	'centralnotice-english' => '英語',
	'centralnotice-template-name' => 'テンプレート名',
	'centralnotice-templates' => 'テンプレート',
	'centralnotice-weight' => '重さ',
	'centralnotice-locked' => 'ロック中',
	'centralnotice-notices' => 'お知らせ',
	'centralnotice-notice-exists' => '同じ名前のお知らせがすでに存在します。追加できませんでした。',
	'centralnotice-template-exists' => '同じ名前のテンプレートがすでに存在します。追加できませんでした。',
	'centralnotice-notice-doesnt-exist' => 'その名前のお知らせは存在しません。除去できませんでした。',
	'centralnotice-template-still-bound' => 'そのテンプレートはまだお知らせに使用されています。除去できませんでした。',
	'centralnotice-template-body' => '翻訳本文:',
	'centralnotice-day' => '日',
	'centralnotice-year' => '年',
	'centralnotice-month' => '月',
	'centralnotice-hours' => '時',
	'centralnotice-min' => '分',
	'centralnotice-project-lang' => 'プロジェクト言語',
	'centralnotice-project-name' => 'プロジェクト名',
	'centralnotice-start-date' => '開始日',
	'centralnotice-start-time' => '開始時間 (UTC)',
	'centralnotice-available-templates' => '利用可能なテンプレート',
	'centralnotice-preview-template' => 'テンプレートをプレビューする',
	'centralnotice-start-hour' => '開始時刻',
	'centralnotice-change-lang' => '翻訳言語を変更する',
	'centralnotice-number-uses' => '使用目的',
	'centralnotice-edit-template' => 'テンプレートを編集する',
	'centralnotice-message' => 'メッセージ',
	'centralnotice-clone' => '複製',
	'centralnotice-clone-notice' => 'テンプレートの複製を作成する',
	'centralnotice-preview-all-template-translations' => 'テンプレートのすべての利用可能な翻訳をプレビューする',
	'right-centralnotice-admin' => '中央管理のお知らせの編集',
	'right-centralnotice-translate' => '中央管理のお知らせの翻訳',
	'action-centralnotice-admin' => '中央管理のお知らせの編集',
	'action-centralnotice-translate' => '中央管理のお知らせの翻訳',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'centralnotice-desc' => "Tilføje'n sentrål sitenotice",
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'centralnotice' => "Admin cathetan pusat (''central notice'')",
	'noticetemplate' => "Cithakan cathetan pusat (''central notice'')",
	'centralnotice-desc' => 'Nambahaké wara-wara situs punjer',
	'centralnotice-summary' => "Modul iki kanggo nyunting tatanan cathetan pusat (''central notice'') sing ana.
Iki uga bisa kanggo nambah utawa mbuwang cathetan/pangumuman lawas.",
	'centralnotice-query' => 'Owahi cathetan/pangumuman sing ana saiki',
	'centralnotice-notice-name' => 'Jeneng cathetan/pangumuman',
	'centralnotice-end-date' => 'Tanggal dipungkasi',
	'centralnotice-enabled' => 'Diaktifaké',
	'centralnotice-modify' => 'Kirim',
	'centralnotice-preview' => 'Pratayang',
	'centralnotice-add-new' => 'Tambah cathetan pusat (pangumuman) anyar',
	'centralnotice-remove' => 'Buwang/busak',
	'centralnotice-translate-heading' => 'Terjemahan saka $1',
	'centralnotice-manage' => "Tata cathetan pusat (''central notice'')",
	'centralnotice-add' => 'Tambahaké',
	'centralnotice-add-notice' => 'Tambahaké cathetan',
	'centralnotice-add-template' => 'Tambahaké cithakan',
	'centralnotice-show-notices' => 'Tuduhaké cathetan',
	'centralnotice-list-templates' => 'Dhaptar cithakan',
	'centralnotice-translations' => 'Terjemahan',
	'centralnotice-translate-to' => 'Terjemahaké menyang',
	'centralnotice-translate' => 'Terjemah',
	'centralnotice-english' => 'Basa Inggris',
	'centralnotice-template-name' => 'Jeneng cithakan',
	'centralnotice-templates' => 'Cithakan',
	'centralnotice-weight' => 'Bobot',
	'centralnotice-locked' => 'Kakunci',
	'centralnotice-notices' => 'Cathetan',
	'centralnotice-notice-exists' => 'Cathetan wis ana.
Dudu panambahan',
	'centralnotice-template-exists' => 'Cithakan wis ana.
Dudu panambahan',
	'centralnotice-notice-doesnt-exist' => 'Cathetan ora ana.
Ora ana sing perlu dibusak',
	'centralnotice-template-still-bound' => 'Cithakan isih diwatesi déning cathetan.
Ora bisa mbusak.',
	'centralnotice-template-body' => 'Bagéyan utama cithakan',
	'centralnotice-day' => 'Dina',
	'centralnotice-year' => 'Taun',
	'centralnotice-month' => 'Sasi',
	'centralnotice-hours' => 'Jam',
	'centralnotice-min' => 'Menit',
	'centralnotice-project-lang' => 'Basa Proyèk',
	'centralnotice-project-name' => 'Jeneng proyèk',
	'centralnotice-start-date' => 'Tanggal diwiwiti',
	'centralnotice-start-time' => 'Wektu diwiwiti (UTC)',
	'centralnotice-assigned-templates' => 'Cithakan-cithakan sing ditetepaké',
	'centralnotice-no-templates' => 'Ora ana cithakan.
Gawénen!',
	'centralnotice-no-templates-assigned' => "Durung ana cithakan kanggo cathetan/pangumuman (''notice'').
Gawénen!",
	'centralnotice-available-templates' => 'Cithakan-cithakan sing ana',
	'centralnotice-template-already-exists' => "Cithakan isih kagandhèng menyang ''campaing''.
Ora bisa nambah",
	'centralnotice-preview-template' => 'Tampilaké cithakan',
	'centralnotice-start-hour' => 'Wektu diwiwiti',
	'centralnotice-change-lang' => 'Owahi basa terjemahan',
	'centralnotice-weights' => 'Bobot',
	'centralnotice-notice-is-locked' => 'Cathetan dikunci.
Ora bisa mbusak',
	'centralnotice-overlap' => 'Cathetan sauntara tumpang tindhih karo cathetan liyané.
Ora bisa nambah',
	'centralnotice-invalid-date-range' => 'Jangka data ora sah.
Ora bisa ngowahi',
	'centralnotice-null-string' => "Ora bisa nambah ''null string''. Ora bisa nambah",
	'centralnotice-confirm-delete' => 'Panjenengan yakin bakal mbusak item iki?
Tumindak iki bakal ora bisa didandani manèh.',
	'centralnotice-no-notices-exist' => 'Durung ana cathetan.
Tambahaké ing ngisor',
	'centralnotice-no-templates-translate' => 'Ora ana cithakan sing kudu disunting/terjemahaké',
	'centralnotice-number-uses' => 'Guna',
	'centralnotice-edit-template' => 'Sunting cithakan',
	'centralnotice-message' => 'Warta',
	'centralnotice-message-not-set' => 'Warta durung di sèt',
	'centralnotice-clone' => 'Kloning',
	'centralnotice-clone-notice' => "Gawé salinan (''copy'') saka cithakan",
	'centralnotice-preview-all-template-translations' => 'Tampilaké kabèh terjemahan cithakan sing ana',
	'right-centralnotice-admin' => 'Tata cathetan pusat',
	'right-centralnotice-translate' => "Terjemahaké cathetan pusat (''central notices'')",
	'action-centralnotice-admin' => "tata cathetan pusat (''central notices'')",
	'action-centralnotice-translate' => "terjemahaké cathetan pusat (''central notices'')",
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'centralnotice-modify' => 'ដាក់ស្នើ',
	'centralnotice-preview' => 'មើលជាមុន',
	'centralnotice-remove' => 'ដកចេញ',
	'centralnotice-translate-heading' => 'ការប្រែសម្រួល​សម្រាប់​$1',
	'centralnotice-add' => 'ដាក់បន្ថែម',
	'centralnotice-add-template' => 'បន្ថែមទំព័រគំរូ',
	'centralnotice-translations' => 'ការបកប្រែ',
	'centralnotice-translate-to' => 'បកប្រែ​ទៅ',
	'centralnotice-translate' => 'បកប្រែ',
	'centralnotice-english' => 'ភាសាអង់គ្លេស',
	'centralnotice-template-name' => 'ឈ្មោះទំព័រគំរូ',
	'centralnotice-templates' => 'ទំព័រគំរូ',
	'centralnotice-locked' => 'បានចាក់សោ',
	'centralnotice-day' => 'ថ្ងៃ',
	'centralnotice-year' => 'ឆ្នាំ',
	'centralnotice-month' => 'ខែ',
	'centralnotice-hours' => 'ម៉ោង',
	'centralnotice-min' => 'នាទី',
	'centralnotice-project-lang' => 'ភាសាគម្រោង',
	'centralnotice-project-name' => 'ឈ្មោះគម្រោង',
	'centralnotice-preview-template' => 'មើលទំព័រគំរូជាមុន',
	'centralnotice-edit-template' => 'កែប្រែទំព័រគំរូ',
	'centralnotice-message' => 'សារ',
	'centralnotice-clone' => 'ក្លូន',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'centralnotice-enabled' => '활성화됨',
	'centralnotice-modify' => '저장',
	'centralnotice-preview' => '미리 보기',
	'centralnotice-remove' => '제거',
	'centralnotice-translate-heading' => '$1에 대한 번역',
	'centralnotice-add' => '추가',
	'centralnotice-add-notice' => '알림을 추가하기',
	'centralnotice-add-template' => '틀을 추가하기',
	'centralnotice-translations' => '번역',
	'centralnotice-translate-to' => '번역할 언어',
	'centralnotice-translate' => '번역하기',
	'centralnotice-english' => '영어',
	'centralnotice-template-name' => '틀 이름',
	'centralnotice-templates' => '틀',
	'centralnotice-locked' => '잠김',
	'centralnotice-template-exists' => '틀이 이미 존재합니다.
추가하지 않았습니다.',
	'centralnotice-hours' => '시',
	'centralnotice-min' => '분',
	'centralnotice-project-lang' => '프로젝트 언어',
	'centralnotice-project-name' => '프로젝트 이름',
	'centralnotice-start-date' => '시작 날짜',
	'centralnotice-start-time' => '시작 시간 (UTC)',
	'centralnotice-preview-template' => '틀 미리 보기',
	'centralnotice-start-hour' => '시작 시간',
	'centralnotice-change-lang' => '번역할 언어 변경',
	'centralnotice-edit-template' => '틀 편집하기',
	'right-centralnotice-translate' => '중앙 공지 번역',
	'action-centralnotice-admin' => '중앙 공지를 관리하기',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'centralnotice' => 'Zentraal Nohreschte verwallde',
	'noticetemplate' => 'Schabloon för zentraal Nohreschte',
	'centralnotice-desc' => "Brengk en zentraale ''sitenotice'' en et wiki",
	'centralnotice-summary' => 'Hee met kanns De de zentraal Nohreschte ändere, die jraad em Wiki opjesaz sen,
ävver och neue dobei donn, un allde fott schmieße.',
	'centralnotice-query' => 'Aktowälle zentraale Nohresch ändere.',
	'centralnotice-notice-name' => 'Dä Nohresch ier Name',
	'centralnotice-end-date' => 'Et Dattum fum Engk',
	'centralnotice-enabled' => 'Aanjeschalldt',
	'centralnotice-modify' => 'Loß Jonn!',
	'centralnotice-preview' => 'Vör-Aansich zeije',
	'centralnotice-add-new' => 'Donn en zentrale Nohresch dobei',
	'centralnotice-remove' => 'Fottnämme',
	'centralnotice-translate-heading' => 'Övversäzong för $1',
	'centralnotice-manage' => 'Zentrale Nohreschte fowallde',
	'centralnotice-add' => 'Dobeidonn',
	'centralnotice-add-notice' => 'En zentrale Nohresch dobei donn',
	'centralnotice-add-template' => 'En Schabloon dobei donn',
	'centralnotice-show-notices' => 'Zentrale Nohreschte zeije',
	'centralnotice-list-templates' => 'Schablone opleßte',
	'centralnotice-translations' => 'Övversäzonge',
	'centralnotice-translate-to' => 'Övversäze noh',
	'centralnotice-translate' => 'Övversäze',
	'centralnotice-english' => 'Englesch',
	'centralnotice-template-name' => 'Dä Schablon iere Name',
	'centralnotice-templates' => 'Schablone',
	'centralnotice-weight' => 'Jeweesch',
	'centralnotice-locked' => 'jespert',
	'centralnotice-notices' => 'zentrale Nohreschte',
	'centralnotice-notice-exists' => 'Di zentrale Nohresch es ald doh.
Nix dobei jedonn.',
	'centralnotice-template-exists' => 'Di Schablon es ald doh.
Nit dobei jedonn.',
	'centralnotice-notice-doesnt-exist' => 'Di zentrale Nohresch es nit doh.
Kam_mer nit fott lohße.',
	'centralnotice-template-still-bound' => 'Di Schablon deit aan ene zentrale Nohresch hange.
Di kam_mer nit fott nämme.',
	'centralnotice-template-body' => 'Dä Tex fun dä Schablon:',
	'centralnotice-day' => 'Daach',
	'centralnotice-year' => 'Johr',
	'centralnotice-month' => 'Moohnd',
	'centralnotice-hours' => 'Shtund',
	'centralnotice-min' => 'Menutt',
	'centralnotice-project-lang' => 'Däm Projäk sing Shprooch',
	'centralnotice-project-name' => 'Däm Projäk singe Name',
	'centralnotice-start-date' => 'Et Annfangsdattum',
	'centralnotice-start-time' => 'De Aanfangszick (UTC)',
	'centralnotice-assigned-templates' => 'Zojedeilte Schablone',
	'centralnotice-no-templates' => 'Mer han kein Schablone.
Kanns ävver welshe dobei don.',
	'centralnotice-no-templates-assigned' => 'Et sin kein Schablone för de zentraal Nohresch zojedeilt.
Donn dat ens!',
	'centralnotice-available-templates' => 'Müjjelesche Schabloone',
	'centralnotice-template-already-exists' => 'Di Schablon weed ald förr_en Kampannje jebruch.
Nit dobeijedonn.',
	'centralnotice-preview-template' => 'Vör-Ansich för di Schablon',
	'centralnotice-start-hour' => 'Uhrzigg fum Aanfang',
	'centralnotice-change-lang' => 'Shprooch fö et Övversäze ändere',
	'centralnotice-weights' => 'Jeweeschte',
	'centralnotice-notice-is-locked' => 'Di zentraal Nohresch es jesperrt.
Se blief.',
	'centralnotice-overlap' => 'De Zick vun hee dä, un en ander vun dä zentraale Nohreschte, donn sesch övverlappe. Dat jeiht nit.
Nit dobei jedonn.',
	'centralnotice-invalid-date-range' => 'Die Zigge jidd_et nit.
Nix jedonn.',
	'centralnotice-null-string' => 'Et hät keine Senn, ene Täx aanzefööje, woh nix dren steiht.
Dat maache mer nit.',
	'centralnotice-confirm-delete' => "Bes De sescher, dat De dä Enndraach fottschmiiße well?
Fott eß fott, dä kam_mer '''nit''' widder zeröck holle!",
	'centralnotice-no-notices-exist' => 'Mer han kein Nohreschte.
De kanns ävver welshe dobei don.',
	'centralnotice-no-templates-translate' => 'Mer hann kein Schablone, woh mer Översäzunge för beärbeide künnt.',
	'centralnotice-number-uses' => 'Jebruch',
	'centralnotice-edit-template' => 'Schablon beärbeide',
	'centralnotice-message' => 'Nohresch',
	'centralnotice-message-not-set' => 'De Nohresch es nit jesaz',
	'centralnotice-clone' => 'Kopi maache',
	'centralnotice-clone-notice' => 'Maach en Kopi fun dä Schabloon',
	'centralnotice-preview-all-template-translations' => 'Vör-Aansich fun all dä Övversäzunge fun dä Schablon',
	'right-centralnotice-admin' => 'Zentraal Nohreschte verwallde',
	'right-centralnotice-translate' => 'Zentraal Nohreschte övversäze',
	'action-centralnotice-admin' => 'zentraal Nohreschte ze verwallde',
	'action-centralnotice-translate' => 'zentraal Nohreschte ze övversäze',
	'centralnotice-preferred' => 'Förjetrocke!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'centralnotice' => 'Administratioun vun der zenraler Notiz',
	'noticetemplate' => 'Schabloun vun der zentraler Notiz',
	'centralnotice-desc' => "Setzt eng zentral 'Sitenotice' derbäi",
	'centralnotice-query' => 'Déi aktuell Notizen änneren',
	'centralnotice-notice-name' => 'Numm vun der Notiz',
	'centralnotice-end-date' => 'Schlussdatum',
	'centralnotice-enabled' => 'Aktivéiert',
	'centralnotice-modify' => 'Späicheren',
	'centralnotice-preview' => 'Weisen ouni ze späicheren',
	'centralnotice-add-new' => 'Eng nei zentral Notiz derbäisetzen',
	'centralnotice-remove' => 'Ewechhuelen',
	'centralnotice-translate-heading' => 'Iwwersetzung vu(n) $1',
	'centralnotice-manage' => 'Zentralnotiz geréieren',
	'centralnotice-add' => 'Derbäisetzen',
	'centralnotice-add-notice' => 'Eng Notiz derbäisetzen',
	'centralnotice-add-template' => 'Eng Schabloun derbäisetzen',
	'centralnotice-show-notices' => 'Notize weisen',
	'centralnotice-list-templates' => 'Lëscht vun de Schablounen',
	'centralnotice-translations' => 'Iwwersetzungen',
	'centralnotice-translate-to' => 'Iwwersetzen op',
	'centralnotice-translate' => 'Iwwersetzen',
	'centralnotice-english' => 'Englesch',
	'centralnotice-template-name' => 'Numm vun der Schabloun',
	'centralnotice-templates' => 'Schablounen',
	'centralnotice-weight' => 'Gewiicht',
	'centralnotice-locked' => 'Gespaart',
	'centralnotice-notices' => 'Notizen',
	'centralnotice-notice-exists' => "D'Notiz gëtt et schonn.
Si konnt net derbäigesat ginn.",
	'centralnotice-template-exists' => "D'Schabloun gëtt et schonn.
Et gouf näischt derbäigsat.",
	'centralnotice-notice-doesnt-exist' => "D'notiz gëtt et net.
Et gëtt näischt fir ewechzehuelen.",
	'centralnotice-template-body' => 'Text vun der Schabloun:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'Joer',
	'centralnotice-month' => 'Mount',
	'centralnotice-hours' => 'Stonn',
	'centralnotice-min' => 'Minutt',
	'centralnotice-project-lang' => 'Sprooch vum Projet',
	'centralnotice-project-name' => 'Numm vum Projet',
	'centralnotice-start-date' => 'Ufanksdatum',
	'centralnotice-start-time' => 'Ufankszäit (UTC)',
	'centralnotice-assigned-templates' => 'Zougewise Schablounen',
	'centralnotice-no-templates' => 'Et gëtt keng Schablounen am System',
	'centralnotice-available-templates' => 'Disponibel Schablounen',
	'centralnotice-template-already-exists' => "D'Schabloun ass schonn enger Campagne zougedeelt.
Net derbäisetzen",
	'centralnotice-preview-template' => 'Schabloun weisen ouni ze späicheren',
	'centralnotice-start-hour' => 'Ufankszäit',
	'centralnotice-change-lang' => 'Sprooch vun der Iwwersetzung änneren',
	'centralnotice-weights' => 'Gewiicht',
	'centralnotice-notice-is-locked' => "D'Notiz ass gespaart.
Se kann net ewechgeholl ginn.",
	'centralnotice-invalid-date-range' => 'Ongëltegen Zäitraum.
Gëtt net aktualiséiert.',
	'centralnotice-null-string' => 'Et ass net méiglech näischt derbäizesetzen.
Näischt derbäigesat',
	'centralnotice-confirm-delete' => 'Sidd Dir sécher datt Dir dës Säit läsche wëllt?
Dës Aktioun kann net réckgängeg gemaach ginn.',
	'centralnotice-no-notices-exist' => 'Et gëtt keng Notiz.
Setzt eng hei ënnendrënner bäi.',
	'centralnotice-no-templates-translate' => "Et gëtt keng Schablounen fir déi Iwwersetzungen z'ännere sinn",
	'centralnotice-number-uses' => 'gëtt benotzt',
	'centralnotice-edit-template' => 'Schabloun änneren',
	'centralnotice-message' => 'Message',
	'centralnotice-message-not-set' => 'Message net gepäichert',
	'centralnotice-clone' => 'Eng Kopie maachen',
	'centralnotice-clone-notice' => 'Eng Kopie vun der Schabloun maachen',
	'centralnotice-preview-all-template-translations' => 'All disponibel Iwwersetzunge vun der Schabloun weisen ouni ofzespäicheren',
	'right-centralnotice-admin' => 'Zentralnotize geréieren',
	'right-centralnotice-translate' => 'Zentral Notizen iwwersetzen',
	'action-centralnotice-admin' => 'Zentralnotize geréieren',
	'action-centralnotice-translate' => 'Zentral Notiz iwwersetzen',
	'centralnotice-preferred' => 'Am léiwsten',
);

/** Limburgish (Limburgs)
 * @author Matthias
 */
$messages['li'] = array(
	'centralnotice-desc' => "Voegt 'n centrale sitemededeling toe",
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'centralnotice-desc' => 'Централизирано известување',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'centralnotice-desc' => 'കേന്ദീകൃത സൈറ്റ്നോട്ടീസ് ചേര്‍ക്കുന്നു',
);

/** Marathi (मराठी)
 * @author Mahitgar
 */
$messages['mr'] = array(
	'centralnotice-desc' => 'संकेतस्थळाचा मध्यवर्ती सूचना फलक',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'centralnotice' => 'Pentadbiran pemberitahuan pusat',
	'noticetemplate' => 'Templat pemberitahuan pusat',
	'centralnotice-desc' => 'Menambah pemberitahuan pusat',
	'centralnotice-summary' => 'Anda boleh menggunakan modul ini untuk menyunting pemberitahuan pusat yang disediakan. Anda juga boleh menambah atau membuang pemberitahuan yang lama.',
	'centralnotice-query' => 'Ubah suai pemberitahuan semasa',
	'centralnotice-notice-name' => 'Nama pemberitahuan',
	'centralnotice-end-date' => 'Tarikh tamat',
	'centralnotice-enabled' => 'Boleh',
	'centralnotice-modify' => 'Serah',
	'centralnotice-preview' => 'Pralihat',
	'centralnotice-add-new' => 'Tambah pemberitahuan pusat baru',
	'centralnotice-remove' => 'Buang',
	'centralnotice-translate-heading' => 'Penterjemahan $1',
	'centralnotice-manage' => 'Urus pemberitahuan pusat',
	'centralnotice-add' => 'Tambah',
	'centralnotice-add-notice' => 'Tambah pemberitahuan',
	'centralnotice-add-template' => 'Tambah templat',
	'centralnotice-show-notices' => 'Papar pemberitahuan',
	'centralnotice-list-templates' => 'Senarai templat',
	'centralnotice-translations' => 'Terjemahan',
	'centralnotice-translate-to' => 'Terjemah',
	'centralnotice-translate' => 'Terjemah',
	'centralnotice-english' => 'Bahasa Inggeris',
	'centralnotice-template-name' => 'Nama templat',
	'centralnotice-templates' => 'Templat',
	'centralnotice-locked' => 'Dikunci',
	'centralnotice-notices' => 'Pemberitahuan',
	'centralnotice-notice-exists' => 'Pemberitahuan telah pun wujud dan tidak ditambah.',
	'centralnotice-template-exists' => 'Templat telah pun wujud dan tidak ditambah.',
	'centralnotice-notice-doesnt-exist' => 'Pemberitahuan tidak wujud untuk dibuang.',
	'centralnotice-template-still-bound' => 'Templat masih digunakan untuk pemberitahuan dan tidak dibuang.',
	'centralnotice-template-body' => 'Kandungan templat:',
	'centralnotice-day' => 'Hari',
	'centralnotice-year' => 'Tahun',
	'centralnotice-month' => 'Bulan',
	'centralnotice-hours' => 'Jam',
	'centralnotice-min' => 'Minit',
	'centralnotice-project-lang' => 'Bahasa projek',
	'centralnotice-project-name' => 'Nama projek',
	'centralnotice-start-date' => 'Tarikh mula',
	'centralnotice-start-time' => 'Waktu mula (UTC)',
	'centralnotice-no-templates' => 'Tiada templat. Sila cipta templat baru.',
	'centralnotice-no-templates-assigned' => 'Tiada templat untuk pemberitahuan. Tambah templat baru!',
	'centralnotice-available-templates' => 'Templat yang ada',
	'centralnotice-template-already-exists' => 'Templat telah pun terikat dengan kempen, oleh itu tidak ditambah.',
	'centralnotice-preview-template' => 'Pralihat templat',
	'centralnotice-start-hour' => 'Waktu mula',
	'centralnotice-change-lang' => 'Tukar bahasa terjemahan',
	'centralnotice-notice-is-locked' => 'Pemberitahuan telah dikunci dan tidak boleh dibuang.',
	'centralnotice-overlap' => 'Pemberitahuan tersebut bertindan waktu dengan pemberitahuan lain, oleh itu tidak ditambah.',
	'centralnotice-invalid-date-range' => 'Julat tarikh tidak sah dan tidak dikemaskinikan.',
	'centralnotice-null-string' => 'Rentetan kosong tidak boleh ditambah.',
	'centralnotice-confirm-delete' => 'Betul anda mahu menghapuskan item ini? Tindakan ini tidak boleh dipulihkan.',
	'centralnotice-no-notices-exist' => 'Tiada pemberitahuan. Anda boleh menambahnya di bawah.',
	'centralnotice-no-templates-translate' => 'Tiada templat untuk diterjemah',
	'centralnotice-number-uses' => 'Penggunaan',
	'centralnotice-edit-template' => 'Sunting templat',
	'centralnotice-message' => 'Pesanan',
	'centralnotice-message-not-set' => 'Pesanan tidak ditetapkan',
	'centralnotice-clone' => 'Salin',
	'centralnotice-clone-notice' => 'Buat salinan templat ini',
	'centralnotice-preview-all-template-translations' => 'Pratonton semua terjemahan yang ada bagi templat ini',
	'right-centralnotice-admin' => 'Mengurus pemberitahuan pusat',
	'right-centralnotice-translate' => 'Menterjemah pemberitahuan pusat',
	'action-centralnotice-admin' => 'mengurus pemberitahuan pusat',
	'action-centralnotice-translate' => 'menterjemah pemberitahuan pusat',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'centralnotice' => 'Sitenotice verwalten',
	'noticetemplate' => 'Vörlaag för Sitenotice',
	'centralnotice-desc' => 'Föögt en zentrale Naricht för de Websteed to',
	'centralnotice-query' => 'Aktuelle Sitenotice ännern',
	'centralnotice-notice-name' => 'Naam',
	'centralnotice-end-date' => 'Datum vun’t Enn',
	'centralnotice-enabled' => 'Aktiv',
	'centralnotice-modify' => 'OK',
	'centralnotice-preview' => 'Vörschau',
	'centralnotice-add-new' => 'Ne’e zentrale Sitenotice tofögen',
	'centralnotice-remove' => 'Rutnehmen',
	'centralnotice-translate-heading' => 'Översetten för $1',
	'centralnotice-manage' => 'Sitenotice verwalten',
	'centralnotice-add' => 'Tofögen',
	'centralnotice-add-notice' => 'En Sitenotice tofögen',
	'centralnotice-add-template' => 'En Vörlaag tofögen',
	'centralnotice-show-notices' => 'Sitenotices wiesen',
	'centralnotice-list-templates' => 'Vörlagen oplisten',
	'centralnotice-translations' => 'Översetten',
	'centralnotice-translate-to' => 'Översetten na',
	'centralnotice-translate' => 'Översetten',
	'centralnotice-english' => 'Engelsch',
	'centralnotice-template-name' => 'Vörlagennaam',
	'centralnotice-templates' => 'Vörlagen',
	'centralnotice-weight' => 'Gewicht',
	'centralnotice-locked' => 'Afslaten',
	'centralnotice-notices' => 'Sitenotices',
	'centralnotice-notice-exists' => 'De Sitenotice gifft dat al.
Nix toföögt.',
	'centralnotice-template-exists' => 'De Vörlaag gifft dat al.
Nix toföögt.',
	'centralnotice-notice-doesnt-exist' => 'De Sitenotice gifft dat nich.
Nix rutnahmen.',
	'centralnotice-template-still-bound' => 'Vörlaag is noch jümmer an en Sitenotice bunnen.
Nich rutnahmen.',
	'centralnotice-template-body' => 'Vörlagentext:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'Johr',
	'centralnotice-month' => 'Maand',
	'centralnotice-hours' => 'Stünn',
	'centralnotice-min' => 'Minuut',
	'centralnotice-project-lang' => 'Projektspraak',
	'centralnotice-project-name' => 'Projektnaam',
	'centralnotice-start-date' => 'Startdatum',
	'centralnotice-start-time' => 'Starttied (UTC)',
	'centralnotice-assigned-templates' => 'Towiest Vörlagen',
	'centralnotice-no-templates' => 'Keen Vörlagen funnen.
Kannst welk tofögen!',
	'centralnotice-no-templates-assigned' => 'Dor sünd kene Vörlagen an de Sitenotice towiest.
Föög welk to!',
	'centralnotice-available-templates' => 'Verföögbor Vörlagen',
	'centralnotice-template-already-exists' => 'Vörlaag is al an Kampagne bunnen.
Nich toföögt',
	'centralnotice-preview-template' => 'Vörschau för de Vörlaag',
	'centralnotice-start-hour' => 'Starttied',
	'centralnotice-change-lang' => 'Spraak för’t Översetten ännern',
	'centralnotice-weights' => 'Gewichten',
	'centralnotice-notice-is-locked' => 'Sitenotice is sperrt.
Nich rutnahmen',
	'centralnotice-overlap' => 'Sitenotice överlappt mit en annere Sitenotice.
Nich toföögt',
	'centralnotice-invalid-date-range' => 'Ungüllig Tied.
Warrt nich aktuell maakt.',
	'centralnotice-null-string' => 'Kann keen Nullstring tofögen.
Nix toföögt',
	'centralnotice-confirm-delete' => 'Büst du seker, dat du dissen Indrag wegdoon wullt?
Dat geit nich wedder trüchtodreihn.',
	'centralnotice-no-notices-exist' => 'Gifft keen Narichten.
Kannst ünnen een tofögen',
	'centralnotice-no-templates-translate' => 'Dat gifft keen Vörlagen, för de Översetten maakt warrn köönt',
	'centralnotice-number-uses' => 'Maal bruukt',
	'centralnotice-edit-template' => 'Vörlaag ännern',
	'centralnotice-message' => 'Naricht',
	'centralnotice-message-not-set' => 'Naricht nich instellt',
	'centralnotice-clone' => 'Koperen',
	'centralnotice-clone-notice' => 'En Kopie vun de Vörlaag maken',
	'centralnotice-preview-all-template-translations' => 'All vörhannen Översetten vun en Vörlaag ankieken',
	'right-centralnotice-admin' => 'Zentrale Siedennotiz verwalten',
	'right-centralnotice-translate' => 'Zentrale Siedennotiz översetten',
	'action-centralnotice-admin' => 'zentrale Siedennotiz verwalten',
	'action-centralnotice-translate' => 'zentrale Siedennotiz översetten',
	'centralnotice-preferred' => 'Vörtagen',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'centralnotice-add' => 'Toevoegen',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'centralnotice' => 'Beheer centrale sitenotice',
	'noticetemplate' => 'Sjablonen centrale sitenotice',
	'centralnotice-desc' => 'Voegt een centrale sitemededeling toe',
	'centralnotice-summary' => 'Met deze module kunnen centraal ingestelde sitenotices bewerkt worden.
De module kan ook gebruikt worden om sitenotices toe te voegen of oude te verwijderen.',
	'centralnotice-query' => 'Huidige sitenotices wijzigen',
	'centralnotice-notice-name' => 'Sitenoticenaam',
	'centralnotice-end-date' => 'Einddatum',
	'centralnotice-enabled' => 'Actief',
	'centralnotice-modify' => 'Opslaan',
	'centralnotice-preview' => 'Bekijken',
	'centralnotice-add-new' => 'Nieuwe centrale sitenotice toevoegen',
	'centralnotice-remove' => 'Verwijderen',
	'centralnotice-translate-heading' => 'Vertaling voor $1',
	'centralnotice-manage' => 'Centrale sitenotice beheren',
	'centralnotice-add' => 'Toevoegen',
	'centralnotice-add-notice' => 'Sitenotice toevoegen',
	'centralnotice-add-template' => 'Sjabloon toevoegen',
	'centralnotice-show-notices' => 'Sitenotices weergeven',
	'centralnotice-list-templates' => 'Sjablonen weergeven',
	'centralnotice-translations' => 'Vertalingen',
	'centralnotice-translate-to' => 'Vertalen naar',
	'centralnotice-translate' => 'Vertalen',
	'centralnotice-english' => 'Engels',
	'centralnotice-template-name' => 'Sjabloonnaam',
	'centralnotice-templates' => 'Sjablonen',
	'centralnotice-weight' => 'Gewicht',
	'centralnotice-locked' => 'Afgesloten',
	'centralnotice-notices' => 'Sitenotices',
	'centralnotice-notice-exists' => 'De sitenotice bestaat al.
Deze wordt niet toegevoegd.',
	'centralnotice-template-exists' => 'Het sjabloon bestaat al.
Dit wordt niet toegevoegd.',
	'centralnotice-notice-doesnt-exist' => 'De sitenotice bestaat niet.
Er is niets te verwijderen',
	'centralnotice-template-still-bound' => 'Het sjabloon is nog gekoppeld aan een sitenotice.
Het wordt niet verwijderd.',
	'centralnotice-template-body' => 'Sjablooninhoud:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'Jaar',
	'centralnotice-month' => 'Maand',
	'centralnotice-hours' => 'Uur',
	'centralnotice-min' => 'Minuut',
	'centralnotice-project-lang' => 'Projecttaal',
	'centralnotice-project-name' => 'Projectnaam',
	'centralnotice-start-date' => 'Startdatum',
	'centralnotice-start-time' => 'Starttijd (UTC)',
	'centralnotice-assigned-templates' => 'Toegewezen sjablonen',
	'centralnotice-no-templates' => 'Er zijn geen sjablonen beschikbaar in het systeem',
	'centralnotice-no-templates-assigned' => 'Er zijn geen sjablonen toegewezen aan de sitenotice.
Die moet u toevoegen.',
	'centralnotice-available-templates' => 'Beschikbare sjablonen',
	'centralnotice-template-already-exists' => 'Het sjabloon is al gekoppeld aan een campagne.
Het wordt niet toegevoegd',
	'centralnotice-preview-template' => 'Voorvertoning sjabloon',
	'centralnotice-start-hour' => 'Starttijd',
	'centralnotice-change-lang' => 'Te vertalen taal wijzigen',
	'centralnotice-weights' => 'Gewichten',
	'centralnotice-notice-is-locked' => 'De sitenotice is afgesloten.
Deze wordt niet verwijderd',
	'centralnotice-overlap' => 'De sitenotice overlapt met een andere sitenotice.
Deze wordt niet toegevoegd',
	'centralnotice-invalid-date-range' => 'Ongeldige datumreeks.
Er wordt niet bijgewerkt',
	'centralnotice-null-string' => 'U kunt geen leeg tekstveld toevoegen.
Er wordt niet toegevoegd.',
	'centralnotice-confirm-delete' => 'Weet u zeker dat u dit item wilt verwijderen?
Deze handeling is niet terug te draaien.',
	'centralnotice-no-notices-exist' => 'Er zijn geen sitenotices.
U kunt er hieronder een toevoegen',
	'centralnotice-no-templates-translate' => 'Er zijn geen sjablonen waarvoor vertalingen gemaakt kunnen worden',
	'centralnotice-number-uses' => 'Aantal keren gebruikt',
	'centralnotice-edit-template' => 'Sjabloon bewerken',
	'centralnotice-message' => 'Bericht',
	'centralnotice-message-not-set' => 'Het bericht is niet ingesteld',
	'centralnotice-clone' => 'Kopiëren',
	'centralnotice-clone-notice' => 'Een kopie van het sjabloon maken',
	'centralnotice-preview-all-template-translations' => 'Alle beschikbare vertalingen van het sjabloon bekijken',
	'right-centralnotice-admin' => 'Centrale sitenotices beheren',
	'right-centralnotice-translate' => 'Centrale sitenotices vertalen',
	'action-centralnotice-admin' => 'centrale sitenotices beheren',
	'action-centralnotice-translate' => 'centrale sitenotices vertalen',
	'centralnotice-preferred' => 'Voorkeur',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'centralnotice' => 'Administrasjon av sentrale merknader',
	'noticetemplate' => 'Mal for sentrale merknader',
	'centralnotice-desc' => 'Legg til ein sentral sidemerknad',
	'centralnotice-summary' => 'Denne modulen lèt deg endra dine noverande sentralmerknader.
Han kan òg bli nytta til å leggja til eller fjerna gamle merknader.',
	'centralnotice-query' => 'Endra noverande merknader',
	'centralnotice-notice-name' => 'Namn på merknad',
	'centralnotice-end-date' => 'Sluttdato',
	'centralnotice-enabled' => 'Aktivert',
	'centralnotice-modify' => 'Utfør',
	'centralnotice-preview' => 'Førehandsvising',
	'centralnotice-add-new' => 'Legg til ein ny sentralmerknad',
	'centralnotice-remove' => 'Fjern',
	'centralnotice-translate-heading' => 'Omsetjing for $1',
	'centralnotice-manage' => 'Handter sentralmerknader',
	'centralnotice-add' => 'Legg til',
	'centralnotice-add-notice' => 'Legg til ein merknad',
	'centralnotice-add-template' => 'Legg til ein mal',
	'centralnotice-show-notices' => 'Syn merknader',
	'centralnotice-list-templates' => 'List opp malar',
	'centralnotice-translations' => 'Omsetjingar',
	'centralnotice-translate-to' => 'Omset til',
	'centralnotice-translate' => 'Omset',
	'centralnotice-english' => 'Engelsk',
	'centralnotice-template-name' => 'Malnamn',
	'centralnotice-templates' => 'Malar',
	'centralnotice-weight' => 'Vekt',
	'centralnotice-locked' => 'Låst',
	'centralnotice-notices' => 'Merknader',
	'centralnotice-notice-exists' => 'Merknaden finst frå før.
Legg han ikkje til',
	'centralnotice-template-exists' => 'Mal finst frå før.
Legg han ikkje til',
	'centralnotice-notice-doesnt-exist' => 'Merknad finst ikkje. Ingenting å fjerna',
	'centralnotice-template-still-bound' => 'Malen er framleis kopla til ein merknad. Fjernar han ikkje',
	'centralnotice-template-body' => 'Malinnhald:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'År',
	'centralnotice-month' => 'Månad',
	'centralnotice-hours' => 'Time',
	'centralnotice-min' => 'Minutt',
	'centralnotice-project-lang' => 'Prosjektspråk',
	'centralnotice-project-name' => 'Prosjektnamn',
	'centralnotice-start-date' => 'Startdato',
	'centralnotice-start-time' => 'Starttid (UTC)',
	'centralnotice-assigned-templates' => 'Tildelte malar',
	'centralnotice-no-templates' => 'Fann ingen malar. Legg til nokre!',
	'centralnotice-no-templates-assigned' => 'Ingen malar er tildelte meldingar. Legg til nokre!',
	'centralnotice-available-templates' => 'Tilgjengelege malar',
	'centralnotice-template-already-exists' => 'Malen er allereie knytta til ein kampanje Legg han ikkje til',
	'centralnotice-preview-template' => 'Førehandsvis mal',
	'centralnotice-start-hour' => 'Starttid',
	'centralnotice-change-lang' => 'Endra omsetjingsspråk',
	'centralnotice-weights' => 'Vekter',
	'centralnotice-notice-is-locked' => 'Merknad er låst. Fjernar ikkje',
	'centralnotice-overlap' => 'Merknaden overlappar tida til ein annan merknad. Legg han ikkje til',
	'centralnotice-invalid-date-range' => 'Ugyldig tidsrom. Oppdaterer ikkje',
	'centralnotice-null-string' => 'Kan ikkje leggja til ein nullstreng. Legg ikkje til',
	'centralnotice-confirm-delete' => 'Er du sikker på at du vil sletta? 
Denne handlinga kan ikkje bli omgjort.',
	'centralnotice-no-notices-exist' => 'Ingen merknader finst. Legg til ein under',
	'centralnotice-no-templates-translate' => 'Det finst ingen malar å endra omsetjingar for',
	'centralnotice-number-uses' => 'Gonger nytta',
	'centralnotice-edit-template' => 'Endra mal',
	'centralnotice-message' => 'Melding',
	'centralnotice-message-not-set' => 'Melding ikkje gjeve',
	'centralnotice-clone' => 'Kopi',
	'centralnotice-clone-notice' => 'Opprett ein kopi av malen',
	'centralnotice-preview-all-template-translations' => 'Førehandsvis alle tilgjengelege omsetjingar av malen',
	'right-centralnotice-admin' => 'Handtera sentrale merknader',
	'right-centralnotice-translate' => 'Omsetja sentrale merknader',
	'action-centralnotice-admin' => 'handtera sentrale merknader',
	'action-centralnotice-translate' => 'omsetja sentrale merknader',
	'centralnotice-preferred' => 'Føretrukke',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Laaknor
 */
$messages['no'] = array(
	'centralnotice' => 'Administrasjon av sentrale beskjeder',
	'noticetemplate' => 'Mal for sentrale beskjeder',
	'centralnotice-desc' => 'Legger til en sentral sidenotis',
	'centralnotice-summary' => 'Denne modulen lar deg redigere din nåværende sentralmeldinger.
Den kan også bli brukt for å legge til eller fjerne gamle meldinger.',
	'centralnotice-query' => 'Endre nåværende meldinger',
	'centralnotice-notice-name' => 'Meldingsnavn',
	'centralnotice-end-date' => 'Sluttdato',
	'centralnotice-enabled' => 'Aktivert',
	'centralnotice-modify' => 'Lagre',
	'centralnotice-preview' => 'Forhåndsvisning',
	'centralnotice-add-new' => 'Legg til en ny sentralmelding',
	'centralnotice-remove' => 'Fjern',
	'centralnotice-translate-heading' => 'Oversettelse for $1',
	'centralnotice-manage' => 'Håndter sentralemeldinger',
	'centralnotice-add' => 'Legg til',
	'centralnotice-add-notice' => 'Legg til en melding',
	'centralnotice-add-template' => 'Legg til en mal',
	'centralnotice-show-notices' => 'Vis meldinger',
	'centralnotice-list-templates' => 'Vis maler',
	'centralnotice-translations' => 'Oversettelser',
	'centralnotice-translate-to' => 'Oversett til',
	'centralnotice-translate' => 'Oversett',
	'centralnotice-english' => 'Engelsk',
	'centralnotice-template-name' => 'Malnavn',
	'centralnotice-templates' => 'Maler',
	'centralnotice-weight' => 'Vekt',
	'centralnotice-locked' => 'Låst',
	'centralnotice-notices' => 'Meldinger',
	'centralnotice-notice-exists' => 'Melding eksisterer allerede.
Ikke lagt inn.',
	'centralnotice-template-exists' => 'Mal finnes allerede.
Ikke lagt inn',
	'centralnotice-notice-doesnt-exist' => 'Melding finnes ikke.
Ingenting å slette',
	'centralnotice-template-still-bound' => 'Mal er fortsatt koblet til en melding.
Ikke fjernet',
	'centralnotice-template-body' => 'Malinnhold:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'År',
	'centralnotice-month' => 'Måned',
	'centralnotice-hours' => 'Timer',
	'centralnotice-min' => 'Minutt',
	'centralnotice-project-lang' => 'Prosjektspråk',
	'centralnotice-project-name' => 'Prosjektnavn',
	'centralnotice-start-date' => 'Startdato',
	'centralnotice-start-time' => 'Starttid (UTC)',
	'centralnotice-assigned-templates' => 'Tildelte maler',
	'centralnotice-no-templates' => 'Ingen maler funnet.
Legg til noen!',
	'centralnotice-no-templates-assigned' => 'Ingen maler tildelt melding.
Legg til noen!',
	'centralnotice-available-templates' => 'Tilgjengelige maler',
	'centralnotice-template-already-exists' => 'Mal er allerede knyttet til kampanje.
Ikke lagt inn',
	'centralnotice-preview-template' => 'Forhåndsvis mal',
	'centralnotice-start-hour' => 'Starttid',
	'centralnotice-change-lang' => 'Endre oversettelsesspråk',
	'centralnotice-weights' => 'Tyngder',
	'centralnotice-notice-is-locked' => 'Melding er låst.
Ikke fjernet',
	'centralnotice-overlap' => 'Melding overlapper tiden til en annen melding.
Ikke lagt inn',
	'centralnotice-invalid-date-range' => 'Ugyldig tidsrom.
Ikke oppdatert',
	'centralnotice-null-string' => 'Kan ikke legge til en nullstreng.
Ikke lagt til',
	'centralnotice-confirm-delete' => 'Er du sikker på at du vil slette denne?
Denne handlingen kan ikke bli omgjort.',
	'centralnotice-no-notices-exist' => 'Ingen notiser finnes.
Legg til en under',
	'centralnotice-no-templates-translate' => 'Det finnes ingen maler å redigere oversettelser for',
	'centralnotice-number-uses' => 'Anvendelser',
	'centralnotice-edit-template' => 'Rediger mal',
	'centralnotice-message' => 'Beskjed',
	'centralnotice-message-not-set' => 'Melding ikke satt',
	'centralnotice-clone' => 'Klon',
	'centralnotice-clone-notice' => 'Lag en kopi av malen',
	'centralnotice-preview-all-template-translations' => 'Forhåndsvis alle tilgjengelige oversettelser av malen',
	'right-centralnotice-admin' => 'Håndtere sentrale meldinger',
	'right-centralnotice-translate' => 'Oversett sentrale meldinger',
	'action-centralnotice-admin' => 'administrere sentrale meldinger',
	'action-centralnotice-translate' => 'oversette sentrale meldinger',
	'centralnotice-preferred' => 'Foretrukket',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'centralnotice' => 'Administracion de las notificacions centralas',
	'noticetemplate' => 'Modèls de las notificacions centralas',
	'centralnotice-desc' => 'Apond un sitenotice central',
	'centralnotice-summary' => 'Aqueste modul vos permet de modificar vòstres paramètres de las notificacions centralas.',
	'centralnotice-query' => 'Modificar las notificacions actualas',
	'centralnotice-notice-name' => 'Nom de la notificacion',
	'centralnotice-end-date' => 'Data de fin',
	'centralnotice-enabled' => 'Activat',
	'centralnotice-modify' => 'Sometre',
	'centralnotice-preview' => 'Previsualizacion',
	'centralnotice-add-new' => 'Apondre una notificacion centrala novèla',
	'centralnotice-remove' => 'Suprimir',
	'centralnotice-translate-heading' => 'Traduccion de $1',
	'centralnotice-manage' => 'Gerir las notificacions centralas',
	'centralnotice-add' => 'Apondre',
	'centralnotice-add-notice' => 'Apondre una notificacion',
	'centralnotice-add-template' => 'Apondre un modèl',
	'centralnotice-show-notices' => 'Afichar las notificacions',
	'centralnotice-list-templates' => 'Listar los modèls',
	'centralnotice-translations' => 'Traduccions',
	'centralnotice-translate-to' => 'Traduire en',
	'centralnotice-translate' => 'Traduire',
	'centralnotice-english' => 'Anglés',
	'centralnotice-template-name' => 'Nom del modèl',
	'centralnotice-templates' => 'Modèls',
	'centralnotice-weight' => 'Pes',
	'centralnotice-locked' => 'Varrolhat',
	'centralnotice-notices' => 'Notificacions',
	'centralnotice-notice-exists' => 'La notificacion existís ja.
Es pas estada aponduda.',
	'centralnotice-template-exists' => 'Lo modèl existís ja.
Es pas estat apondut.',
	'centralnotice-notice-doesnt-exist' => 'La notificacion existís pas.
I a pas res de suprimir.',
	'centralnotice-template-still-bound' => 'Lo modèl es encara religat a una notificacion.
Es pas estat suprimit.',
	'centralnotice-template-body' => 'Còs del modèl :',
	'centralnotice-day' => 'Jorn',
	'centralnotice-year' => 'Annada',
	'centralnotice-month' => 'Mes',
	'centralnotice-hours' => 'Ora',
	'centralnotice-min' => 'Minuta',
	'centralnotice-project-lang' => 'Lenga del projècte',
	'centralnotice-project-name' => 'Nom del projècte',
	'centralnotice-start-date' => 'Data de començament',
	'centralnotice-start-time' => 'Ora de començament (UTC)',
	'centralnotice-assigned-templates' => 'Modèls assignats',
	'centralnotice-no-templates' => 'I a pas de modèl dins lo sistèma.
Apondètz-ne un !',
	'centralnotice-no-templates-assigned' => 'Pas cap de modèl assignat a la notificacion.
Apondètz-ne un !',
	'centralnotice-available-templates' => 'Modèls disponibles',
	'centralnotice-template-already-exists' => "Lo modèl je es estacat a una campanha.
D'apondre pas",
	'centralnotice-preview-template' => 'Previsualizacion del modèl',
	'centralnotice-start-hour' => 'Ora de començament',
	'centralnotice-change-lang' => 'Modificar la lenga de traduccion',
	'centralnotice-weights' => 'Pes',
	'centralnotice-notice-is-locked' => 'La notificacion es varrolhada.
Es pas estada suprimida.',
	'centralnotice-overlap' => "Notificacion que s’imbrica dins lo temps d’una autra.
D'apondre pas.",
	'centralnotice-invalid-date-range' => 'Triada de data incorrècta.
De metre pas a jorn.',
	'centralnotice-null-string' => "Pòt pas apondre una cadena nulla.
D'apondre pas.",
	'centralnotice-confirm-delete' => 'Sètz segur(a) que volètz suprimir aqueste article ?
Aquesta accion poirà pas pus èsser recuperada.',
	'centralnotice-no-notices-exist' => 'Cap de notificacion existís pas.
Apondètz-ne una en dejós.',
	'centralnotice-no-templates-translate' => 'I a pas cap de modèl de traduire',
	'centralnotice-number-uses' => 'Utilizaires',
	'centralnotice-edit-template' => 'Modificar lo modèl',
	'centralnotice-message' => 'Messatge',
	'centralnotice-message-not-set' => 'Messatge pas entresenhat',
	'centralnotice-clone' => 'Clonar',
	'centralnotice-clone-notice' => "Crear una còpia d'aqueste modèl",
	'centralnotice-preview-all-template-translations' => "Previsualizar totas las traduccions d'aqueste modèl",
	'right-centralnotice-admin' => 'Gerís las notificacions centralas',
	'right-centralnotice-translate' => 'Traduire las notificacions centralas',
	'action-centralnotice-admin' => 'gerir las notificacions centralas',
	'action-centralnotice-translate' => 'traduire las notificacions centralas',
	'centralnotice-preferred' => 'Preferit',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'centralnotice-preview' => 'Разæркаст',
	'centralnotice-translations' => 'Тæлмацтæ',
	'centralnotice-year' => 'Аз',
	'centralnotice-project-lang' => 'Проекты æвзаг',
	'centralnotice-project-name' => 'Проекты ном',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Qblik
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'centralnotice' => 'Administrowanie wspólnymi komunikatami',
	'noticetemplate' => 'Szablony wspólnych komunikatów',
	'centralnotice-desc' => 'Dodaje wspólny komunikat dla serwisów',
	'centralnotice-summary' => 'Ten moduł pozwala zmieniać bieżące ustawienia wspólnych komunikatów.
Można także dodawać i usuwać komunikaty.',
	'centralnotice-query' => 'Modyfikuj bieżący komunikat',
	'centralnotice-notice-name' => 'Nazwa komunikatu',
	'centralnotice-end-date' => 'Data zakończenia',
	'centralnotice-enabled' => 'Włączony',
	'centralnotice-modify' => 'Zapisz',
	'centralnotice-preview' => 'Podgląd',
	'centralnotice-add-new' => 'Dodaj nowy wspólny komunikat',
	'centralnotice-remove' => 'Usuń',
	'centralnotice-translate-heading' => 'Tłumaczenie dla $1',
	'centralnotice-manage' => 'Zarządzaj wspólnymi komunikatami',
	'centralnotice-add' => 'Dodaj',
	'centralnotice-add-notice' => 'Dodaj komunikat',
	'centralnotice-add-template' => 'Dodaj szablon',
	'centralnotice-show-notices' => 'Pokaż komunikaty',
	'centralnotice-list-templates' => 'Lista szablonów',
	'centralnotice-translations' => 'Tłumaczenia',
	'centralnotice-translate-to' => 'Przetłumacz na',
	'centralnotice-translate' => 'Przetłumacz',
	'centralnotice-english' => 'Angielski',
	'centralnotice-template-name' => 'Nazwa szablonu',
	'centralnotice-templates' => 'Szablony',
	'centralnotice-weight' => 'Waga',
	'centralnotice-locked' => 'Zablokowany',
	'centralnotice-notices' => 'Komunikaty',
	'centralnotice-notice-exists' => 'Komunikat o podanej nazwie już istnieje. Nowy komunikat nie został dodany.',
	'centralnotice-template-exists' => 'Szablon o podanej nazwie już istnieje. Nowy szablon nie został dodany.',
	'centralnotice-notice-doesnt-exist' => 'Komunikat nie istnieje. Nie ma czego usunąć.',
	'centralnotice-template-still-bound' => 'Szablon nie może zostać usunięty. Jest ciągle używany przez komunikat.',
	'centralnotice-template-body' => 'Treść szablonu:',
	'centralnotice-day' => 'Dzień',
	'centralnotice-year' => 'Rok',
	'centralnotice-month' => 'Miesiąc',
	'centralnotice-hours' => 'Godzina',
	'centralnotice-min' => 'Minuta',
	'centralnotice-project-lang' => 'Język projektu',
	'centralnotice-project-name' => 'Nazwa projektu',
	'centralnotice-start-date' => 'Data rozpoczęcia',
	'centralnotice-start-time' => 'Czas rozpoczęcia (UTC)',
	'centralnotice-assigned-templates' => 'Dołączone szablony',
	'centralnotice-no-templates' => 'Brak szablonów w bazie modułu',
	'centralnotice-no-templates-assigned' => 'Nie dołączono szablonów do komunikatu.
Dodaj jakiś szablon!',
	'centralnotice-available-templates' => 'Dostępne szablony',
	'centralnotice-template-already-exists' => 'Szablon nie został dodany.
Jest już wykorzystany w kampani.',
	'centralnotice-preview-template' => 'Podgląd szablonu',
	'centralnotice-start-hour' => 'Czas rozpoczęcia',
	'centralnotice-change-lang' => 'Zmień język tłumaczenia',
	'centralnotice-weights' => 'Wagi',
	'centralnotice-notice-is-locked' => 'Komunikat nie może zostać usunięty, ponieważ jest zablokowany.',
	'centralnotice-overlap' => 'Czas komunikatu pokrywa się z czasem innego komunikatu. Nowy komunikat nie został dodany.',
	'centralnotice-invalid-date-range' => 'Nieprawidłowy przedział pomiędzy datą rozpoczęcia a zakończenia.
Komunikat nie został zaktualizowany.',
	'centralnotice-null-string' => 'Nie można dodać pustej zawartości.',
	'centralnotice-confirm-delete' => 'Czy jesteś pewien, że chcesz usunąć ten element?
Działanie to będzie nieodwracalne.',
	'centralnotice-no-notices-exist' => 'Brak komunikatów.
Dodaj nowy poniżej.',
	'centralnotice-no-templates-translate' => 'Nie ma żadnych szablonów do zmiany tłumaczeń dla',
	'centralnotice-number-uses' => 'Zastosowania',
	'centralnotice-edit-template' => 'Edycja szablonu',
	'centralnotice-message' => 'Wiadomość',
	'centralnotice-message-not-set' => 'Wiadomość nie jest ustawiona',
	'centralnotice-clone' => 'Kopia',
	'centralnotice-clone-notice' => 'Utwórz kopię szablonu',
	'centralnotice-preview-all-template-translations' => 'Zobacz wszystkie dostępne tłumaczenia szablonu',
	'right-centralnotice-admin' => 'Zarządzać wspólnymi komunikatami',
	'right-centralnotice-translate' => 'Tłumaczyć wspólne komunikaty',
	'action-centralnotice-admin' => 'zarządzaj centralnymi komunikatami',
	'action-centralnotice-translate' => 'przetłumacz centralne komunikaty',
	'centralnotice-preferred' => 'Preferowany',
);

/** Pontic (Ποντιακά)
 * @author Omnipaedista
 */
$messages['pnt'] = array(
	'centralnotice-english' => "Σ' αγγλικά",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'centralnotice-desc' => 'يو مرکزي ويبځی-يادښت ورګډول',
	'centralnotice-translate-heading' => 'د $1 لپاره ژباړه',
	'centralnotice-add' => 'ورګډول',
	'centralnotice-translations' => 'ژباړې',
	'centralnotice-translate' => 'ژباړل',
	'centralnotice-english' => 'انګرېزي',
	'centralnotice-template-name' => 'د کينډۍ نوم',
	'centralnotice-templates' => 'کينډۍ',
	'centralnotice-day' => 'ورځ',
	'centralnotice-year' => 'کال',
	'centralnotice-month' => 'مياشت',
	'centralnotice-hours' => 'ساعت',
	'centralnotice-min' => 'دقيقه',
	'centralnotice-project-lang' => 'د ژبې پروژه',
	'centralnotice-project-name' => 'د پروژې نوم',
	'centralnotice-start-date' => 'د پيل نېټه',
	'centralnotice-start-time' => 'د پيل وخت (UTC)',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'centralnotice' => 'Administração de aviso centralizado',
	'noticetemplate' => 'Modelo de aviso do sítio',
	'centralnotice-desc' => 'Adiciona um aviso do sítio centralizado',
	'centralnotice-summary' => 'Este módulo permite-lhe editar os seus avisos centralizados actualmente configurados.
Pode também ser usado para adicionar ou remover avisos antigos.',
	'centralnotice-query' => 'Modificar avisos actuais',
	'centralnotice-notice-name' => 'Nome do aviso',
	'centralnotice-end-date' => 'Data fim',
	'centralnotice-enabled' => 'Activo',
	'centralnotice-modify' => 'Submeter',
	'centralnotice-preview' => 'Previsão',
	'centralnotice-add-new' => 'Adicionar um novo aviso centralizado',
	'centralnotice-remove' => 'Remover',
	'centralnotice-translate-heading' => 'Tradução de $1',
	'centralnotice-manage' => 'Gerir aviso centralizado',
	'centralnotice-add' => 'Adicionar',
	'centralnotice-add-notice' => 'Adicionar um aviso',
	'centralnotice-add-template' => 'Adicionar um modelo',
	'centralnotice-show-notices' => 'Mostrar avisos',
	'centralnotice-list-templates' => 'Listar modelos',
	'centralnotice-translations' => 'Traduções',
	'centralnotice-translate-to' => 'Traduzir para',
	'centralnotice-translate' => 'Traduzir',
	'centralnotice-english' => 'Inglês',
	'centralnotice-template-name' => 'Nome do modelo',
	'centralnotice-templates' => 'Modelos',
	'centralnotice-weight' => 'Peso',
	'centralnotice-locked' => 'Bloqueado',
	'centralnotice-notices' => 'Avisos',
	'centralnotice-notice-exists' => 'O aviso já existe.
Não adicionado',
	'centralnotice-template-exists' => 'O modelo já existe.
Não adicionado',
	'centralnotice-notice-doesnt-exist' => 'O aviso não existe.
Nada a remover',
	'centralnotice-template-still-bound' => 'O modelo ainda está ligado a um aviso.
Não removido.',
	'centralnotice-template-body' => 'Conteúdo do modelo:',
	'centralnotice-day' => 'Dia',
	'centralnotice-year' => 'Ano',
	'centralnotice-month' => 'Mês',
	'centralnotice-hours' => 'Hora',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Língua do projecto',
	'centralnotice-project-name' => 'Nome do projecto',
	'centralnotice-start-date' => 'Data início',
	'centralnotice-start-time' => 'Hora início (UTC)',
	'centralnotice-assigned-templates' => 'Modelos atribuídos',
	'centralnotice-no-templates' => 'Nenhum modelo encontrado.
Adicione alguns!',
	'centralnotice-no-templates-assigned' => 'Nenhum modelo atribuído a avisos.
Adicione alguns!',
	'centralnotice-available-templates' => 'Modelos disponíveis',
	'centralnotice-template-already-exists' => 'O modelo já está ligado a campanha.
Não adicionado',
	'centralnotice-preview-template' => 'Prever modelo',
	'centralnotice-start-hour' => 'Hora início',
	'centralnotice-change-lang' => 'Alterar língua de tradução',
	'centralnotice-weights' => 'Pesos',
	'centralnotice-notice-is-locked' => 'O aviso está bloqueado.
Não removido',
	'centralnotice-overlap' => 'O aviso sobrepõe-se no tempo com outro aviso.
Não adicionado',
	'centralnotice-invalid-date-range' => 'Intervalo de datas inválido.
Não actualizado',
	'centralnotice-null-string' => 'Não é possível adicionar uma cadeia de caracteres nula.
Não adicionado',
	'centralnotice-confirm-delete' => 'Tem a certeza de que pretende eliminar este item?
Esta acção será irreversível.',
	'centralnotice-no-notices-exist' => 'Não existe nenhum aviso.
Adicione um abaixo',
	'centralnotice-no-templates-translate' => 'Não há quaisquer modelos para os quais seja possível editar traduções',
	'centralnotice-number-uses' => 'Utilizações',
	'centralnotice-edit-template' => 'Editar modelo',
	'centralnotice-message' => 'Mensagem',
	'centralnotice-message-not-set' => 'Mensagem não estabelecida',
	'centralnotice-clone' => 'Clonar',
	'centralnotice-clone-notice' => 'Criar uma cópia do modelo',
	'centralnotice-preview-all-template-translations' => 'Prever todas as traduções disponíveis do modelo',
	'right-centralnotice-admin' => 'Gerir avisos centralizados',
	'right-centralnotice-translate' => 'Traduzir avisos centralizados',
	'action-centralnotice-admin' => 'gerir avisos centralizados',
	'action-centralnotice-translate' => 'traduzir avisos centralizados',
	'centralnotice-preferred' => 'Preferido',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'centralnotice-project-name' => 'Nome do projeto',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'centralnotice-desc' => 'Adaugă un anunţ central sitului',
	'centralnotice-query' => 'Modifică anunţurile curente',
	'centralnotice-notice-name' => 'Numele anunţului',
	'centralnotice-enabled' => 'Activat',
	'centralnotice-preview' => 'Previzualizare',
	'centralnotice-add-new' => 'Adaugă un anunţ central nou',
	'centralnotice-translate-heading' => 'Traducere pentru $1',
	'centralnotice-add' => 'Adaugă',
	'centralnotice-add-notice' => 'Adaugă un anunţ',
	'centralnotice-add-template' => 'Adaugă un format',
	'centralnotice-show-notices' => 'Arată anunţurile',
	'centralnotice-translations' => 'Traduceri',
	'centralnotice-translate-to' => 'Tradu în',
	'centralnotice-translate' => 'Tradu',
	'centralnotice-english' => 'engleză',
	'centralnotice-template-name' => 'Numele formatului',
	'centralnotice-templates' => 'Formate',
	'centralnotice-day' => 'Zi',
	'centralnotice-year' => 'An',
	'centralnotice-month' => 'Lună',
	'centralnotice-hours' => 'Oră',
	'centralnotice-min' => 'Minut',
	'centralnotice-available-templates' => 'Formate disponibile',
	'centralnotice-edit-template' => 'Modifică format',
	'centralnotice-message' => 'Mesaj',
	'centralnotice-clone-notice' => 'Creează o copie a formatului',
	'right-centralnotice-translate' => 'Traduce anunţurile centrale',
	'action-centralnotice-admin' => 'administrezi anunţurile centrale',
	'action-centralnotice-translate' => 'traduci anunţurile centrale',
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'centralnotice' => 'Управление централизованными уведомлениями',
	'noticetemplate' => 'Шаблон централизованного уведомления',
	'centralnotice-desc' => 'Добавляет общее сообщение сайта',
	'centralnotice-summary' => 'Этот модуль позволяет вам изменять ваши текущие централизованные уведомления.
Он также может использоваться для добавления новых и удаления старых уведомлений.',
	'centralnotice-query' => 'Изменить текущее уведомление',
	'centralnotice-notice-name' => 'Название уведомления',
	'centralnotice-end-date' => 'Дата окончания',
	'centralnotice-enabled' => 'Включено',
	'centralnotice-modify' => 'Отправить',
	'centralnotice-preview' => 'Предпросмотр',
	'centralnotice-add-new' => 'Добавить новое централизованное уведомление',
	'centralnotice-remove' => 'Удалить',
	'centralnotice-translate-heading' => 'Перевод для $1',
	'centralnotice-manage' => 'Управление централизованными уведомлениями',
	'centralnotice-add' => 'Добавить',
	'centralnotice-add-notice' => 'Добавить уведомление',
	'centralnotice-add-template' => 'Добавить шаблон',
	'centralnotice-show-notices' => 'Показать уведомления',
	'centralnotice-list-templates' => 'Вывести список шаблонов',
	'centralnotice-translations' => 'Переводы',
	'centralnotice-translate-to' => 'Перевод на',
	'centralnotice-translate' => 'Перевод',
	'centralnotice-english' => 'английский',
	'centralnotice-template-name' => 'Название шаблона',
	'centralnotice-templates' => 'Шаблоны',
	'centralnotice-weight' => 'Ширина',
	'centralnotice-locked' => 'Заблокированный',
	'centralnotice-notices' => 'уведомления',
	'centralnotice-notice-exists' => 'Уведомление уже существует.
Не добавляется',
	'centralnotice-template-exists' => 'Шаблон уже существует.
Не добавляется',
	'centralnotice-notice-doesnt-exist' => 'Уведомления не существует.
Нечего удалять',
	'centralnotice-template-still-bound' => 'Шаблон по-прежнему связан с уведомлением.
Не удаляется.',
	'centralnotice-template-body' => 'Тело шаблона:',
	'centralnotice-day' => 'День',
	'centralnotice-year' => 'Год',
	'centralnotice-month' => 'Месяц',
	'centralnotice-hours' => 'Час',
	'centralnotice-min' => 'Минута',
	'centralnotice-project-lang' => 'Язык проекта',
	'centralnotice-project-name' => 'Название проекта',
	'centralnotice-start-date' => 'Дата начала',
	'centralnotice-start-time' => 'Время начала (UTC)',
	'centralnotice-assigned-templates' => 'Установленные шаблоны',
	'centralnotice-no-templates' => 'Не найдено шаблонов.
Добавьте что-нибудь!',
	'centralnotice-no-templates-assigned' => 'Нет связанных с уведомлением шаблонов.
Добавьте какой-нибудь',
	'centralnotice-available-templates' => 'Доступные шаблоны',
	'centralnotice-template-already-exists' => 'Шаблон уже привязан.
Не добавлен',
	'centralnotice-preview-template' => 'Предпросмотр шаблона',
	'centralnotice-start-hour' => 'Время начала',
	'centralnotice-change-lang' => 'Изменить язык перевода',
	'centralnotice-weights' => 'Веса',
	'centralnotice-notice-is-locked' => 'Уведомление заблокировано.
Не удаляется',
	'centralnotice-overlap' => 'Уведомление перекрывается по времени с другим уведомлением.
Не добавляется',
	'centralnotice-invalid-date-range' => 'Ошибочный диапазон дат.
Не обновляется',
	'centralnotice-null-string' => 'Невозможно добавить пустую строку.
Не добавляется',
	'centralnotice-confirm-delete' => 'Вы уверены в решении удалить этот элемент?
Это действие нельзя будет отменить.',
	'centralnotice-no-notices-exist' => 'Нет уведомлений.
Можно добавить',
	'centralnotice-no-templates-translate' => 'Нет ни одного шаблона для правки перевода',
	'centralnotice-number-uses' => 'Используются',
	'centralnotice-edit-template' => 'Править шаблон',
	'centralnotice-message' => 'Сообщение',
	'centralnotice-message-not-set' => 'Сообщение не установлено',
	'centralnotice-clone' => 'Клонирование',
	'centralnotice-clone-notice' => 'Создать копию шаблона',
	'centralnotice-preview-all-template-translations' => 'Просмотреть все доступные переводы шаблона',
	'right-centralnotice-admin' => 'управление централизованными уведомлениями',
	'right-centralnotice-translate' => 'перевод централизованных уведомлений',
	'action-centralnotice-admin' => 'управление централизованными уведомлениями',
	'action-centralnotice-translate' => 'перевод централизованных уведомлений',
	'centralnotice-preferred' => 'Желательно',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'centralnotice-desc' => 'Саайт биллэриитин эбэр',
	'centralnotice-translate' => 'Тылбаас',
	'centralnotice-template-name' => 'Халыып аата',
	'centralnotice-templates' => 'Халыыптар',
	'centralnotice-weight' => 'Кэтитэ',
	'centralnotice-locked' => 'Хааччахтаммыт/бобуллубут',
);

/** Sicilian (Sicilianu)
 * @author Gmelfi
 * @author Santu
 */
$messages['scn'] = array(
	'centralnotice' => 'Gistioni di avvisu cintralizzatu',
	'noticetemplate' => "Template di l'avvisi cintralizzati",
	'centralnotice-desc' => "Jiunci n'avvisu cintralizzatu a inìzziu pàggina",
	'centralnotice-summary' => "Stu mòdulu pirmetti di canciari l'avvisa cintralizzati. Pò èssiri usatu pi junciri o livari avvisa vecchi.",
	'centralnotice-query' => "Cancia l'avvisa attuali",
	'centralnotice-notice-name' => "Nomu di l'avvisu",
	'centralnotice-end-date' => "Data d'accapata",
	'centralnotice-enabled' => 'Attivatu',
	'centralnotice-modify' => 'Mànna',
	'centralnotice-preview' => 'Antiprima',
	'centralnotice-add-new' => "Junci n'avvisu cintralizzatu novu",
	'centralnotice-remove' => 'Lèva',
	'centralnotice-translate-heading' => 'Traduzzioni di $1',
	'centralnotice-manage' => "Gistioni di l'avvisa cintralizzati",
	'centralnotice-add' => 'Junci',
	'centralnotice-add-notice' => "Junci n'avvisu",
	'centralnotice-add-template' => 'Junci nu template',
	'centralnotice-show-notices' => "Ammuscia l'avvisa",
	'centralnotice-list-templates' => 'Li template di lista',
	'centralnotice-translations' => 'Traduzzioni',
	'centralnotice-translate-to' => 'Tradùci n',
	'centralnotice-translate' => 'Traduci',
	'centralnotice-english' => 'Ngrisi',
	'centralnotice-template-name' => 'Nomu dû template',
	'centralnotice-templates' => 'Template',
	'centralnotice-weight' => 'Pisu',
	'centralnotice-locked' => 'Bluccatu',
	'centralnotice-notices' => 'Nutizzî',
	'centralnotice-notice-exists' => 'Avvisu già esistenti.
Nun fu jiunchiutu.',
	'centralnotice-template-exists' => 'Template già esistenti.
Nun fu jiunchiutu',
	'centralnotice-notice-doesnt-exist' => "L'avvisu nun esisti. Nun ce nenti di luvari",
	'centralnotice-template-still-bound' => 'Lu template è ancora fissatu a na nutizzia.
Nun si leva.',
	'centralnotice-template-body' => 'Lu corpu dû template',
	'centralnotice-day' => 'Jornu',
	'centralnotice-year' => 'Annu',
	'centralnotice-month' => 'Misi',
	'centralnotice-hours' => 'Ura',
	'centralnotice-min' => 'Minutu',
	'centralnotice-project-lang' => 'Lingua dû pruggettu',
	'centralnotice-project-name' => 'Nomu dû pruggettu',
	'centralnotice-start-date' => "Data d'accuminzatina",
	'centralnotice-start-time' => "Ura d'accuminzatina (UTC)",
	'centralnotice-assigned-templates' => 'Template assignati',
	'centralnotice-no-templates' => 'Nuddu template truvatu. Junchiccìnni quarchidunu!',
	'centralnotice-no-templates-assigned' => "Nuddu template assignatu all'avvisu. Junchiccìnni quarchidunu!",
	'centralnotice-available-templates' => 'Template dispunìbbili',
	'centralnotice-template-already-exists' => 'Lu template è già liatu â campagna.
Nun si junci',
	'centralnotice-preview-template' => 'Antiprima dû template',
	'centralnotice-start-hour' => "Ura d'accuminzatina",
	'centralnotice-change-lang' => 'Cancia la lingua dâ traduzzioni',
	'centralnotice-weights' => 'Pisa',
	'centralnotice-notice-is-locked' => "L'avvisu è bliccatu. Avvisu nun livatu",
	'centralnotice-overlap' => "L'avvisu si camìna ntê pèdi di n'àutru avvisu a causa dû tempu. 
Nun junciutu",
	'centralnotice-invalid-date-range' => 'Ntirvaddu di tempu nun vàlidu.
Nun fu canciatu',
	'centralnotice-null-string' => 'Nun si pò junciri na strinca nulla.
Nun junciutu',
	'centralnotice-confirm-delete' => "Si pi daveru sicuru di vuliri scancillari st'uggettu? Na vota scancillatu non si pò turnari arredi.",
	'centralnotice-no-notices-exist' => "Nuddu avvisu c'è. Agghiunciccinni unu di sècutu.",
	'centralnotice-no-templates-translate' => 'Nun ci sunnu template pi mudificari li traduzzioni pi',
	'centralnotice-number-uses' => 'Usi',
	'centralnotice-edit-template' => 'Cancia template',
	'centralnotice-message' => 'Missaggiu',
	'centralnotice-message-not-set' => 'Missaggiu no mpustatu',
	'centralnotice-clone' => 'Clona',
	'centralnotice-clone-notice' => 'Cria na copia dû template',
	'centralnotice-preview-all-template-translations' => "Tutti li traduzzioni dî template dispunìbbili 'n anteprima",
	'right-centralnotice-admin' => "Gistisci l'avvisi cintralizzati",
	'right-centralnotice-translate' => 'Traduci avvisi cintralizzati',
	'action-centralnotice-admin' => "Guverna l'avvisi cintralizzati",
	'action-centralnotice-translate' => 'tradùciri avvisi cintralizzati',
	'centralnotice-preferred' => 'Prifiriti',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'centralnotice' => 'Centrálny oznam',
	'noticetemplate' => 'Šablóna centrálneho oznamu',
	'centralnotice-desc' => 'Pridáva centrálnu Správu lokality',
	'centralnotice-summary' => 'Tento modul umožňuje upravovať vaše momentálne nastavené centrálne oznamy.
Tiež ho môžete použiť na pridanie alebo odstránenie starých oznamov.',
	'centralnotice-query' => 'Zmeniť súčasné oznamy',
	'centralnotice-notice-name' => 'Názov oznamu',
	'centralnotice-end-date' => 'Dátum ukončenia',
	'centralnotice-enabled' => 'Zapnutá',
	'centralnotice-modify' => 'Odoslať',
	'centralnotice-preview' => 'Náhľad',
	'centralnotice-add-new' => 'Pridať nový centrálny oznam',
	'centralnotice-remove' => 'Odstrániť',
	'centralnotice-translate-heading' => 'Preklad $1',
	'centralnotice-manage' => 'Správa centrálnych oznamov',
	'centralnotice-add' => 'Pridať',
	'centralnotice-add-notice' => 'Pridať oznam',
	'centralnotice-add-template' => 'Pridať šablónu',
	'centralnotice-show-notices' => 'Zobraziť oznamy',
	'centralnotice-list-templates' => 'Zoznam šablón',
	'centralnotice-translations' => 'Preklady',
	'centralnotice-translate-to' => 'Preložiť do jazyka',
	'centralnotice-translate' => 'Preložiť',
	'centralnotice-english' => 'angličtina',
	'centralnotice-template-name' => 'Názov šablóny',
	'centralnotice-templates' => 'Šablóny',
	'centralnotice-weight' => 'Váha',
	'centralnotice-locked' => 'Zamknutý',
	'centralnotice-notices' => 'Oznamy',
	'centralnotice-notice-exists' => 'Oznam už existuje. Nebude pridaný.',
	'centralnotice-template-exists' => 'Šablóna už existuje. Nebude pridaná.',
	'centralnotice-notice-doesnt-exist' => 'Oznam neexistuje. Nebude odstránený.',
	'centralnotice-template-still-bound' => 'Šablóna je ešte stále naviazaná na oznam. Nebude odstránená.',
	'centralnotice-template-body' => 'Telo šablóny:',
	'centralnotice-day' => 'Deň',
	'centralnotice-year' => 'Rok',
	'centralnotice-month' => 'Mesiac',
	'centralnotice-hours' => 'Hodina',
	'centralnotice-min' => 'Minúta',
	'centralnotice-project-lang' => 'Jazyk projektu',
	'centralnotice-project-name' => 'Názov projektu',
	'centralnotice-start-date' => 'Dátum začatia',
	'centralnotice-start-time' => 'Čas začatia (UTC)',
	'centralnotice-assigned-templates' => 'Priradené šablóny',
	'centralnotice-no-templates' => 'Neboli nájdené žiadne šablóny. Pridajte nejaké!',
	'centralnotice-no-templates-assigned' => 'Žiadne šablóny neboli priradené oznamom. Pridajte nejaké!',
	'centralnotice-available-templates' => 'Dostupné šablóny',
	'centralnotice-template-already-exists' => 'Šablóna sa už viaže na kampaň. Nebude pridaná.',
	'centralnotice-preview-template' => 'Náhľad šablóny',
	'centralnotice-start-hour' => 'Dátum začiatku',
	'centralnotice-change-lang' => 'Zmeniť jazyk prekladu',
	'centralnotice-weights' => 'Váhy',
	'centralnotice-notice-is-locked' => 'Oznam je zamknutý. Nebude odstránený.',
	'centralnotice-overlap' => 'Čas zobrazenia oznamu sa prelína s časom iného oznamu. Nebude pridaný.',
	'centralnotice-invalid-date-range' => 'Neplatný rozsah dátumov. Nebude aktualizovaný.',
	'centralnotice-null-string' => 'Nemožno pridať prázdny reťazec. Nebude pridaný.',
	'centralnotice-confirm-delete' => 'Ste si istý, že chcete zmazať túto položku?
Túto operáciu nebude možné vrátiť.',
	'centralnotice-no-notices-exist' => 'Neexistujú žiadne oznamy. Môžete ich pridať.',
	'centralnotice-no-templates-translate' => 'Nie sú žiadne šablóny, ktoré by bolo možné preložiť.',
	'centralnotice-number-uses' => 'Použitia',
	'centralnotice-edit-template' => 'Upraviť šablónu',
	'centralnotice-message' => 'Správa',
	'centralnotice-message-not-set' => 'Správa nebola nastavená',
	'centralnotice-clone' => 'Klonovať',
	'centralnotice-clone-notice' => 'Vytvoriť kópiu šablóny',
	'centralnotice-preview-all-template-translations' => 'Náhľad všetkých dostupných verzií šablóny',
	'right-centralnotice-admin' => 'Spravovať centrálne oznamy',
	'right-centralnotice-translate' => 'Prekladať centrálne oznamy',
	'action-centralnotice-admin' => 'spravovať centrálne oznamy',
	'action-centralnotice-translate' => 'prekladať centrálne oznamy',
	'centralnotice-preferred' => 'Uprednostňované',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Јованвб
 */
$messages['sr-ec'] = array(
	'centralnotice-desc' => 'Додаје централну напомену на сајт.',
	'centralnotice-query' => 'Измени тренутна обавештења',
	'centralnotice-notice-name' => 'Име обавештења',
	'centralnotice-preview' => 'Прикажи',
	'centralnotice-add-new' => 'Додај нову централну напомену',
	'centralnotice-remove' => 'Уклони',
	'centralnotice-translate-heading' => 'Превод за $1',
	'centralnotice-manage' => 'Уреди централну напомену',
	'centralnotice-add' => 'Додај',
	'centralnotice-add-notice' => 'Додај обавештење',
	'centralnotice-add-template' => 'Додај шаблон',
	'centralnotice-show-notices' => 'Прикажи обавештења',
	'centralnotice-list-templates' => 'Списак шаблона',
	'centralnotice-translations' => 'Преводи',
	'centralnotice-translate-to' => 'Преведи на',
	'centralnotice-translate' => 'Преведи',
	'centralnotice-english' => 'Енглески',
	'centralnotice-template-name' => 'Име шаблона',
	'centralnotice-templates' => 'Шаблони',
	'centralnotice-notices' => 'Обавештења',
	'centralnotice-day' => 'Дан',
	'centralnotice-year' => 'Година',
	'centralnotice-month' => 'Месец',
	'centralnotice-hours' => 'Сат',
	'centralnotice-min' => 'Минут',
	'centralnotice-project-lang' => 'Име пројекта',
	'centralnotice-project-name' => 'Име пројекта',
	'centralnotice-no-templates' => 'Шаблони нису проађен.
Додај неки!',
	'centralnotice-preview-template' => 'Прикажи шаблон',
	'centralnotice-edit-template' => 'Измени шаблон',
	'centralnotice-message' => 'Порука',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'centralnotice-desc' => "Föiget ne zentroale ''sitenotice'' bietou",
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'centralnotice-desc' => 'Nambah émbaran puseur',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'centralnotice' => 'Centralmeddelande-administration',
	'noticetemplate' => 'Centralmeddelande-mall',
	'centralnotice-desc' => 'Lägger till en central sitenotice',
	'centralnotice-summary' => 'Denna modul låter dig redigera din nuvarande uppsättning centralmeddelanden.
Den kan också användas för att lägga till eller ta bort gamla meddelanden.',
	'centralnotice-query' => 'Ändra nuvarande meddelanden',
	'centralnotice-notice-name' => 'Meddelandenamn',
	'centralnotice-end-date' => 'Slutdatum',
	'centralnotice-enabled' => 'Aktiverad',
	'centralnotice-modify' => 'Verkställ',
	'centralnotice-preview' => 'Förhandsgranska',
	'centralnotice-add-new' => 'Lägg till ett nytt centralmeddelande',
	'centralnotice-remove' => 'Ta bort',
	'centralnotice-translate-heading' => 'Översättning för $1',
	'centralnotice-manage' => 'Hantera centralmeddelande',
	'centralnotice-add' => 'Lägg till',
	'centralnotice-add-notice' => 'Lägg till ett meddelande',
	'centralnotice-add-template' => 'Lägg till en mall',
	'centralnotice-show-notices' => 'Visa meddelanden',
	'centralnotice-list-templates' => 'Lista mallar',
	'centralnotice-translations' => 'Översättningar',
	'centralnotice-translate-to' => 'Översätt till',
	'centralnotice-translate' => 'Översätt',
	'centralnotice-english' => 'Engelska',
	'centralnotice-template-name' => 'Mallnamn',
	'centralnotice-templates' => 'Mallar',
	'centralnotice-weight' => 'Tyngd',
	'centralnotice-locked' => 'Låst',
	'centralnotice-notices' => 'Meddelanden',
	'centralnotice-notice-exists' => 'Meddelande existerar redan.
Lägger inte till',
	'centralnotice-template-exists' => 'Mall existerar redan.
Lägger inte till',
	'centralnotice-notice-doesnt-exist' => 'Meddelande existerar inte.
Inget att ta bort',
	'centralnotice-template-still-bound' => 'Mall är inte fortfarande kopplad till ett meddelande.
Tar inte bort.',
	'centralnotice-template-body' => 'Mallinnehåll:',
	'centralnotice-day' => 'Dag',
	'centralnotice-year' => 'År',
	'centralnotice-month' => 'Månad',
	'centralnotice-hours' => 'Timma',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Projektspråk',
	'centralnotice-project-name' => 'Projektnamn',
	'centralnotice-start-date' => 'Startdatum',
	'centralnotice-start-time' => 'Starttid (UTC)',
	'centralnotice-assigned-templates' => 'Använda mallar',
	'centralnotice-no-templates' => 'Inga mallar hittade.
Lägg till några!',
	'centralnotice-no-templates-assigned' => 'Inga mallar kopplade till meddelande.
Lägg till några!',
	'centralnotice-available-templates' => 'Tillgängliga mallar',
	'centralnotice-template-already-exists' => 'Mall är redan kopplad till kampanj.
Lägger inte till',
	'centralnotice-preview-template' => 'Förhandsgranska mall',
	'centralnotice-start-hour' => 'Starttid',
	'centralnotice-change-lang' => 'Ändra översättningsspråk',
	'centralnotice-weights' => 'Tyngder',
	'centralnotice-notice-is-locked' => 'Meddelande är låst.
Tar inte bort',
	'centralnotice-overlap' => 'Meddelande överlappar inom tiden för annat meddelande.
Lägger inte till',
	'centralnotice-invalid-date-range' => 'Ogiltig tidsrymd.
Uppdaterar inte',
	'centralnotice-null-string' => 'Kan inte lägga till en nollsträng.
Lägger inte till',
	'centralnotice-confirm-delete' => 'Är du säker på att vill radera detta föremål?
Denna handling kan inte återställas.',
	'centralnotice-no-notices-exist' => 'Inga meddelanden existerar.
Lägg till ett nedan',
	'centralnotice-no-templates-translate' => 'Det finns inga mallar att redigera översättningar för',
	'centralnotice-number-uses' => 'Användningar',
	'centralnotice-edit-template' => 'Redigera mall',
	'centralnotice-message' => 'Budskap',
	'centralnotice-message-not-set' => 'Budskap inte satt',
	'centralnotice-clone' => 'Klon',
	'centralnotice-clone-notice' => 'Skapa en kopia av mallen',
	'centralnotice-preview-all-template-translations' => 'Förhandsgranska alla tillgängliga översättningar av mallen',
	'right-centralnotice-admin' => 'Hantera centralmeddelanden',
	'right-centralnotice-translate' => 'Översätt centralmeddelanden',
	'action-centralnotice-admin' => 'hantera centralmeddelanden',
	'action-centralnotice-translate' => 'översätt centralmeddelanden',
	'centralnotice-preferred' => 'Föredragen',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'centralnotice-desc' => 'కేంద్రీయ సైటు గమనికని చేరుస్తుంది',
	'centralnotice-translations' => 'అనువాదాలు',
	'centralnotice-template-name' => 'మూస పేరు',
	'centralnotice-templates' => 'మూసలు',
	'centralnotice-day' => 'రోజు',
	'centralnotice-year' => 'సంవత్సరం',
	'centralnotice-month' => 'నెల',
	'centralnotice-hours' => 'గంట',
	'centralnotice-min' => 'నిమిషం',
	'centralnotice-message' => 'సందేశం',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'centralnotice-add' => 'Tau tan',
	'centralnotice-translations' => 'Tradusaun sira',
	'centralnotice-translate' => 'Tradús',
	'centralnotice-english' => 'Inglés',
	'centralnotice-day' => 'Loron',
	'centralnotice-year' => 'Tinan',
	'centralnotice-month' => 'Fulan',
	'centralnotice-min' => 'Minutu',
	'centralnotice-project-lang' => 'Lian projetu nian',
	'centralnotice-project-name' => 'Naran projetu nian',
	'centralnotice-number-uses' => 'Uza',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'centralnotice' => 'Мудири эълони мутамарказ',
	'noticetemplate' => 'Шаблони эълони мутамарказ',
	'centralnotice-desc' => 'Як иттилооти маркази илова мекунад',
	'centralnotice-summary' => 'Ин модул ба шумо имкони вироиги насби эълони мутамаркази кунинро пешкаш мекунад.
Он боз метавонад барои изофа ё пок кардани эълонҳои кӯҳна истифода шавад.',
	'centralnotice-query' => 'Тағйири эълонҳои кунунӣ',
	'centralnotice-notice-name' => 'Унвони эълон',
	'centralnotice-end-date' => 'Санаи охир',
	'centralnotice-enabled' => 'Фаъол шуд',
	'centralnotice-modify' => 'Ирсол',
	'centralnotice-preview' => 'Пешнамоиш',
	'centralnotice-add-new' => 'Изофаи як эълони мутамарказ',
	'centralnotice-remove' => 'Пок кардан',
	'centralnotice-translate-heading' => 'Тарҷума барои $1',
	'centralnotice-manage' => 'Идоракунии эълони мутамарказ',
	'centralnotice-add' => 'Изофа',
	'centralnotice-add-notice' => 'Изофа кардани як хабар',
	'centralnotice-add-template' => 'Изофаи як шаблон',
	'centralnotice-show-notices' => 'Намоиши эълонҳо',
	'centralnotice-list-templates' => 'Феҳристи шаблонҳо',
	'centralnotice-translations' => 'Тарҷумаҳо',
	'centralnotice-translate-to' => 'Тарҷума ба',
	'centralnotice-translate' => 'Тарҷума',
	'centralnotice-english' => 'Англисӣ',
	'centralnotice-template-name' => 'Унвони шаблон',
	'centralnotice-templates' => 'Шаблонҳо',
	'centralnotice-weight' => 'Вазн',
	'centralnotice-locked' => 'Басташуда',
	'centralnotice-notices' => 'Эълонҳо',
	'centralnotice-notice-exists' => 'Эълон аллакай вуҷуд дорад.
Изофа нашуд',
	'centralnotice-template-exists' => 'Шаблони аллакай мавҷуд аст.
Изофа намешавад',
	'centralnotice-notice-doesnt-exist' => 'Эълон вуҷуд надорад.
Чизе барои пок кардан нест',
	'centralnotice-template-still-bound' => 'Шаблон то ҳол дар як эълоне часпида аст.
Пок намешавад.',
	'centralnotice-template-body' => 'Танаи Шаблон:',
	'centralnotice-day' => 'Рӯз',
	'centralnotice-year' => 'Сол',
	'centralnotice-month' => 'Моҳ',
	'centralnotice-hours' => 'Соат',
	'centralnotice-min' => 'Дақиқа',
	'centralnotice-project-lang' => 'Забони лоиҳа',
	'centralnotice-project-name' => 'Номи лоиҳа',
	'centralnotice-start-date' => 'Санаи шурӯъ',
	'centralnotice-start-time' => 'Замони шурӯъ (UTC)',
	'centralnotice-assigned-templates' => 'Шаблонҳои муқараршуда',
	'centralnotice-no-templates' => 'Ҳеҷ шаблоне ёфт нашуд.
Чанде изофа намоед!',
	'centralnotice-no-templates-assigned' => 'Ҳеҷ шаблоне ба эълон муқарар нашудааст.
Чанде изофа намоед!',
	'centralnotice-available-templates' => 'Шаблонҳои дастрас',
	'centralnotice-template-already-exists' => 'Шаблони аллакай ба эълон часпонида шудааст.
Изофа нашуд.',
	'centralnotice-preview-template' => 'Пешнамоиши шаблон',
	'centralnotice-start-hour' => 'Вақти шурӯъ',
	'centralnotice-change-lang' => 'Тағйири забони тарҷума',
	'centralnotice-weights' => 'Вазнҳо',
	'centralnotice-notice-is-locked' => 'Эълон баста аст.
Пок нашуда истода аст',
	'centralnotice-overlap' => 'Эълон бо вақту замони дигар эълон рӯи ҳам омад.
Изофа нашуд',
	'centralnotice-invalid-date-range' => 'Давраи санаи номӯътабар.
Барӯз нашуд',
	'centralnotice-null-string' => 'Риштаи холиро наметавон афзуд.
Афзуда нашуд',
	'centralnotice-confirm-delete' => 'Оё шумо мутмаин ҳастед, ки мехоҳед ин маводро ҳафз кунед?
Ин амал барқарорнашавада хоҳад буд.',
	'centralnotice-no-notices-exist' => 'Ҳеҷ эълоне вуҷуд надорад.
Дар зер як эълоне изофа намоед',
	'centralnotice-no-templates-translate' => 'Ҳеҷ шаблоне барои вироиши тарҷумааш нест',
	'centralnotice-number-uses' => 'Истифодаҳо',
	'centralnotice-edit-template' => 'Вироиши шаблон',
	'centralnotice-message' => 'Пайғом',
	'centralnotice-message-not-set' => 'Пайғом танзим нашудааст',
	'centralnotice-clone' => 'Клон',
	'centralnotice-clone-notice' => 'Эҷоди як нусхаи ин шаблон',
	'centralnotice-preview-all-template-translations' => 'Пешнамоиши ҳамаи тарҷумаҳои дастраси шаблон',
	'right-centralnotice-admin' => 'Идоракунии эълонҳои мутамарказ',
	'right-centralnotice-translate' => 'Тарҷумаи эълонҳои мутамарказ',
	'action-centralnotice-admin' => 'идоракунии эълонҳои мутамарказ',
	'action-centralnotice-translate' => 'тарҷумаи эълонҳои мутамарказ',
	'centralnotice-preferred' => 'Тарҷиҳи додашуда',
);

/** Thai (ไทย)
 * @author Manop
 */
$messages['th'] = array(
	'centralnotice-day' => 'วัน',
	'centralnotice-year' => 'ปี',
	'centralnotice-month' => 'เดือน',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'centralnotice' => 'Tagapangasiwa ng pangunahing pabatid',
	'noticetemplate' => 'Suleras ng pangunahing pabatid',
	'centralnotice-desc' => 'Nagdaragdag ng pangunahing pahayag ng sayt/sityo',
	'centralnotice-summary' => 'Nagbibigay ang bahaging-panggampaning ito ng pahintulot na mabago mo ang iyong pangkasulukyang naitakdang mga pangunahing pahayag.  
Maaari rin itong gamitin upang makapagdagdag o magtanggal ng mga lumang pahayag.',
	'centralnotice-query' => 'Baguhin ang pangkasalukuyang mga pabatid',
	'centralnotice-notice-name' => 'Pangalan ng pabatid',
	'centralnotice-end-date' => 'Pangwakas na petsa',
	'centralnotice-enabled' => 'Paganahin',
	'centralnotice-modify' => 'Ipasa/ipadala',
	'centralnotice-preview' => 'Paunang tingin',
	'centralnotice-add-new' => 'Magdagdag ng isang bagong pangunahing pabatid',
	'centralnotice-remove' => 'Tanggalin',
	'centralnotice-translate-heading' => 'Salinwika para sa $1',
	'centralnotice-manage' => 'Pamahalaan ang pangunahing pabatid',
	'centralnotice-add' => 'Magdagdag',
	'centralnotice-add-notice' => 'Magdagdag ng isang pabatid',
	'centralnotice-add-template' => 'Magdagdag ng isang suleras',
	'centralnotice-show-notices' => 'Ipagkita ang mga pabatid',
	'centralnotice-list-templates' => 'Itala ang mga suleras',
	'centralnotice-translations' => 'Mga salinwika',
	'centralnotice-translate-to' => 'Isalinwika patungong',
	'centralnotice-translate' => 'Isalinwika',
	'centralnotice-english' => 'Ingles',
	'centralnotice-template-name' => 'Pangalan ng suleras',
	'centralnotice-templates' => 'Mga suleras',
	'centralnotice-weight' => 'Timbang',
	'centralnotice-locked' => 'Nakakandado',
	'centralnotice-notices' => 'Mga pabatid',
	'centralnotice-notice-exists' => 'Umiiral na ang pabatid/pahayag.
Hindi idaragdag',
	'centralnotice-template-exists' => 'Umiiral na ang suleras.
Hindi idinargdag',
	'centralnotice-notice-doesnt-exist' => 'Hindi umiiral ang pabatid/pahayag.
Walang matatanggal',
	'centralnotice-template-still-bound' => 'Nakadikit pa ang suleras sa isang pabatid/pahayag.
Hindi tatanggalin.',
	'centralnotice-template-body' => 'Katawan ng suleras:',
	'centralnotice-day' => 'Araw',
	'centralnotice-year' => 'Taon',
	'centralnotice-month' => 'Buwan',
	'centralnotice-hours' => 'Oras',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Wika ng proyekto',
	'centralnotice-project-name' => 'Pangalan ng proyekto',
	'centralnotice-start-date' => 'Petsa ng pagsisimula',
	'centralnotice-start-time' => 'Oras ng simula (UTC)',
	'centralnotice-assigned-templates' => 'Nakatakdang mga suleras',
	'centralnotice-no-templates' => 'Walang natagpuang mga suleras.
Madagdag ng ilan!',
	'centralnotice-no-templates-assigned' => 'Walang nakatakdang mga suleras para sa pabatid.
Magdagdag ng ilan!',
	'centralnotice-available-templates' => 'Makukuhang mga suleras',
	'centralnotice-template-already-exists' => 'Nakabigkis na ang suleras sa kampanya.
Hindi idaragdag',
	'centralnotice-preview-template' => 'Paunang tingnan ang suleras',
	'centralnotice-start-hour' => 'Oras ng pagsisimula',
	'centralnotice-change-lang' => 'Baguhin ang wika ng pagsasalin',
	'centralnotice-weights' => 'Mga timbang',
	'centralnotice-notice-is-locked' => 'Nakakandado ang pabatid.
Hindi tatanggalin',
	'centralnotice-overlap' => 'Nakikipagsabayan ang pabatid sa loob ng oras ng isa pang pahayag.
Hindi idaragdag',
	'centralnotice-invalid-date-range' => 'Hindi tanggap na sakop ng petsa.
Hindi isasapanahon',
	'centralnotice-null-string' => 'Hindi maidaragdag ang isang hindi mabisang bagting o hanay.
Hindi idaragdag',
	'centralnotice-confirm-delete' => 'Nakatitiyak ka bang ibig mong burahin ang bagay na ito?
Hindi na muling mababawi pa ang galaw na ito.',
	'centralnotice-no-notices-exist' => 'Walang umiiral na mga pabatid.
Magdagdag ng isa sa ibaba',
	'centralnotice-no-templates-translate' => 'Walang mga suleras na mapagsasagawaan ng mga pagbabagong pangsalinwika',
	'centralnotice-number-uses' => 'Mga mapaggagamitan',
	'centralnotice-edit-template' => 'Baguhin ang suleras',
	'centralnotice-message' => 'Mensahe',
	'centralnotice-message-not-set' => 'Hindi nakatakda ang mensahe',
	'centralnotice-clone' => 'Kopyang kahawig na kahawig ng pinaggayahan',
	'centralnotice-clone-notice' => 'Lumikha ng isang sipi ng suleras',
	'centralnotice-preview-all-template-translations' => 'Paunang tanawin ang lahat ng mga makukuhang mga salinwika ng suleras',
	'right-centralnotice-admin' => 'Pamahalaan ang pangunahing mga pabatid',
	'right-centralnotice-translate' => 'Isalinwika ang pangunahing mga pabatid',
	'action-centralnotice-admin' => 'pamahalaan ang pangunahing mga pabatid',
	'action-centralnotice-translate' => 'isalinwika ang pangunahing mga pabatid',
	'centralnotice-preferred' => 'Mas ninanais',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'centralnotice' => 'Управління централізованими сповіщеннями',
	'noticetemplate' => 'Шаблон централізованого повідомлення',
	'centralnotice-desc' => 'Додає загальне повідомлення сайту',
	'centralnotice-summary' => 'Цей модуль дозволяє вам змінювати ваші поточні централізовані повідомлення. 
Він також може використовуватися для додавання нових і видалення старих повідомлень.',
	'centralnotice-query' => 'Змінити поточне повідомлення',
	'centralnotice-notice-name' => 'Назва повідомлення',
	'centralnotice-end-date' => 'Дата закінчення',
	'centralnotice-enabled' => 'Включено',
	'centralnotice-modify' => 'Відправити',
	'centralnotice-preview' => 'Попередній перегляд',
	'centralnotice-add-new' => 'Додати нове централізоване повідомлення',
	'centralnotice-remove' => 'Вилучити',
	'centralnotice-translate-heading' => 'Переклад для $1',
	'centralnotice-manage' => 'Управління централізованими сповіщеннями',
	'centralnotice-add' => 'Додати',
	'centralnotice-add-notice' => 'Додати повідомлення',
	'centralnotice-add-template' => 'Додати шаблон',
	'centralnotice-show-notices' => 'Показати повідомлення',
	'centralnotice-list-templates' => 'Cписок шаблонів',
	'centralnotice-translations' => 'Переклади',
	'centralnotice-translate-to' => 'Переклад на',
	'centralnotice-translate' => 'Переклад',
	'centralnotice-english' => 'англійську',
	'centralnotice-template-name' => 'Назва шаблону',
	'centralnotice-templates' => 'Шаблони',
	'centralnotice-weight' => 'Ширина',
	'centralnotice-locked' => 'Заблокований',
	'centralnotice-notices' => 'повідомлення',
	'centralnotice-notice-exists' => 'Повідомлення вже існує. 
Не додається',
	'centralnotice-template-exists' => 'Шаблон вже існує. 
Не додається',
	'centralnotice-notice-doesnt-exist' => 'Повідомлення не існує. 
Нема чого видаляти',
	'centralnotice-template-still-bound' => "Шаблон, як і раніше, пов'язаний з повідомленням. 
Не видаляється.",
	'centralnotice-template-body' => 'Тіло шаблону:',
	'centralnotice-day' => 'День',
	'centralnotice-year' => 'Рік',
	'centralnotice-month' => 'Місяць',
	'centralnotice-hours' => 'Час',
	'centralnotice-min' => 'Хвилина',
	'centralnotice-project-lang' => 'Мова проекту',
	'centralnotice-project-name' => 'Назва проекту',
	'centralnotice-start-date' => 'Дата початку',
	'centralnotice-start-time' => 'Час початку (UTC)',
	'centralnotice-assigned-templates' => 'Встановлені шаблони',
	'centralnotice-no-templates' => 'Не знайдено шаблонів. 
Додайте що-небудь!',
	'centralnotice-no-templates-assigned' => "Не має пов'язаних з повідомленням шаблонів. 
Додайте який-небудь!",
	'centralnotice-available-templates' => 'Доступні шаблони',
	'centralnotice-template-already-exists' => "Шаблон вже прив'язаний. 
Не доданий",
	'centralnotice-preview-template' => 'Попередній перегляд шаблону',
	'centralnotice-start-hour' => 'Час початку',
	'centralnotice-change-lang' => 'Змінити мову перекладу',
	'centralnotice-weights' => 'Ваги',
	'centralnotice-notice-is-locked' => 'Повідомлення заблоковано. 
Не вилучається',
	'centralnotice-overlap' => 'Повідомлення перекривається за часом з іншим повідомленням. 
Не додається',
	'centralnotice-invalid-date-range' => 'Хибний діапазон дат. 
Не оновлюється',
	'centralnotice-null-string' => 'Не вдається додати порожній рядок. 
Не додається',
	'centralnotice-confirm-delete' => 'Ви впевнені у вирішенні вилучити цей елемент? 
Цю дію не можна буде скасувати.',
	'centralnotice-no-notices-exist' => 'Немає повідомлень. 
Можна додати',
	'centralnotice-no-templates-translate' => 'Не має ні одного шаблону для редагування перекладу',
	'centralnotice-number-uses' => 'Використовуються',
	'centralnotice-edit-template' => 'Редагувати шаблон',
	'centralnotice-message' => 'Повідомлення',
	'centralnotice-message-not-set' => 'Повідомлення не встановлено',
	'centralnotice-clone' => 'Клонування',
	'centralnotice-clone-notice' => 'Створити копію шаблона',
	'centralnotice-preview-all-template-translations' => 'Переглянути всі доступні переклади шаблону',
	'right-centralnotice-admin' => 'Управління централізованими сповіщеннями',
	'right-centralnotice-translate' => 'Переклад централізованих повідомлень',
	'action-centralnotice-admin' => 'управління централізованими сповіщеннями',
	'action-centralnotice-translate' => 'переклад централізованих повідомлень',
	'centralnotice-preferred' => 'Бажано',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'centralnotice' => 'Gestion notifiche sentralizade',
	'noticetemplate' => 'Modèl de aviso sentralizà',
	'centralnotice-desc' => 'Zonta un aviso çentralizà in çima a la pagina (sitenotice)',
	'centralnotice-summary' => 'Sto modulo el permete de canbiar i avisi sentralixà.
In più se pol dopararlo anca par zontar o cavar avisi veci.',
	'centralnotice-query' => 'Modìfega le notifiche corenti',
	'centralnotice-notice-name' => 'Nome de la notifica',
	'centralnotice-end-date' => 'Data de fine',
	'centralnotice-enabled' => 'Ativà',
	'centralnotice-modify' => 'Invia',
	'centralnotice-preview' => 'Anteprima',
	'centralnotice-add-new' => 'Zonta na notifica sentrale nova',
	'centralnotice-remove' => 'Cava',
	'centralnotice-translate-heading' => 'Tradussion par $1',
	'centralnotice-manage' => 'Gestion avisi sentralixà',
	'centralnotice-add' => 'Zonta',
	'centralnotice-add-notice' => 'Zonta na notifica',
	'centralnotice-add-template' => 'Zonta un modèl',
	'centralnotice-show-notices' => 'Mostra notifiche',
	'centralnotice-list-templates' => 'Elenca i modèi',
	'centralnotice-translations' => 'Tradussioni',
	'centralnotice-translate-to' => 'Tradusi con',
	'centralnotice-translate' => 'Tradusi',
	'centralnotice-english' => 'Inglese',
	'centralnotice-template-name' => 'Nome del modèl',
	'centralnotice-templates' => 'Modèi',
	'centralnotice-weight' => 'Peso',
	'centralnotice-locked' => 'Blocà',
	'centralnotice-notices' => 'Notifiche',
	'centralnotice-notice-exists' => 'Notifica zà esistente. 
Inserimento mia fato',
	'centralnotice-template-exists' => 'Modèl zà esistente. 
Inserimento mia fato',
	'centralnotice-notice-doesnt-exist' => 'Notifica mia esistente. 
Rimozion mia fata',
	'centralnotice-template-still-bound' => 'Modèl ancora ligà a na notifica. 
Rimozion mia fata.',
	'centralnotice-template-body' => 'Corpo del modèl:',
	'centralnotice-day' => 'Zorno',
	'centralnotice-year' => 'Ano',
	'centralnotice-month' => 'Mese',
	'centralnotice-hours' => 'Ora',
	'centralnotice-min' => 'Minuto',
	'centralnotice-project-lang' => 'Lengoa del projeto',
	'centralnotice-project-name' => 'Nome del projeto',
	'centralnotice-start-date' => 'Data de scominsio',
	'centralnotice-start-time' => 'Ora de scominsio (UTC)',
	'centralnotice-assigned-templates' => 'Modèi assegnà',
	'centralnotice-no-templates' => 'Nissun modèl catà.
Zónteghene qualchedun!',
	'centralnotice-no-templates-assigned' => 'Nissun modèl assegnà a la notifica
Zónteghene qualchedun!',
	'centralnotice-available-templates' => 'Modèi disponibili',
	'centralnotice-template-already-exists' => 'Sto modèl el xe zà ligà a na campagna. 
Inserimento mia fato',
	'centralnotice-preview-template' => 'Anteprima modèl',
	'centralnotice-start-hour' => 'Ora de scominsio',
	'centralnotice-change-lang' => 'Cànbia lengoa de tradussion',
	'centralnotice-weights' => 'Pesi',
	'centralnotice-notice-is-locked' => 'Notifica blocà.
Rimozion mia fata',
	'centralnotice-overlap' => "El periodo de validità de sto aviso la se sormonta col periodo de n'antro aviso.
Creassion de l'aviso mia fata",
	'centralnotice-invalid-date-range' => 'Intervàl de date mia valido.
Modìfega mia fata',
	'centralnotice-null-string' => 'No se pol zontar na stringa voda.
Inserimento mia fato',
	'centralnotice-confirm-delete' => 'Vuto dal bon scancelar sto elemento? Arda che dopo no se pol più recuperarlo.',
	'centralnotice-no-notices-exist' => 'No esiste nissuna notifica.
Zónteghene una qua soto.',
	'centralnotice-no-templates-translate' => 'No ghe xe nissun modèl de cui modificar la tradussion',
	'centralnotice-number-uses' => 'Usi',
	'centralnotice-edit-template' => 'Modìfega modèl',
	'centralnotice-message' => 'Messagio',
	'centralnotice-message-not-set' => 'Messajo mia inpostà',
	'centralnotice-clone' => 'Copia',
	'centralnotice-clone-notice' => 'Crea na copia del modèl',
	'centralnotice-preview-all-template-translations' => 'Anteprima de tute le tradussion disponibili del modèl',
	'right-centralnotice-admin' => 'Gestisse i avisi sentralixà',
	'right-centralnotice-translate' => 'Tradusi le notifiche sentrali',
	'action-centralnotice-admin' => 'gestir i avisi sentralixà',
	'action-centralnotice-translate' => 'tradur i avisi sentralixà',
	'centralnotice-preferred' => 'Preferìo',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'centralnotice' => 'Quản lý các thông báo chung',
	'noticetemplate' => 'Tiêu bản thông báo chung',
	'centralnotice-desc' => 'Thêm thông báo ở đầu các trang tại hơn một wiki',
	'centralnotice-summary' => 'Dùng phần này, bạn có thể sửa đổi các thông báo chung đã được thiết lập, cũng như thêm thông báo mới hoặc dời thông báo cũ.',
	'centralnotice-query' => 'Sửa đổi các thông báo hiện hành',
	'centralnotice-notice-name' => 'Tên thông báo',
	'centralnotice-end-date' => 'Ngày kết thúc',
	'centralnotice-enabled' => 'Đang hiện',
	'centralnotice-modify' => 'Lưu các thông báo',
	'centralnotice-preview' => 'Xem trước',
	'centralnotice-add-new' => 'Thêm thông báo chung mới',
	'centralnotice-remove' => 'Dời',
	'centralnotice-translate-heading' => 'Dịch $1',
	'centralnotice-manage' => 'Quản lý thông báo chung',
	'centralnotice-add' => 'Thêm',
	'centralnotice-add-notice' => 'Thêm thông báo',
	'centralnotice-add-template' => 'Thêm tiêu bản',
	'centralnotice-show-notices' => 'Xem các thông báo',
	'centralnotice-list-templates' => 'Liệt kê các tiêu bản',
	'centralnotice-translations' => 'Bản dịch',
	'centralnotice-translate-to' => 'Dịch ra',
	'centralnotice-translate' => 'Dịch',
	'centralnotice-english' => 'tiếng Anh',
	'centralnotice-template-name' => 'Tên tiêu bản',
	'centralnotice-templates' => 'Tiêu bản',
	'centralnotice-weight' => 'Mức ưu tiên',
	'centralnotice-locked' => 'Bị khóa',
	'centralnotice-notices' => 'Thông báo',
	'centralnotice-notice-exists' => 'Không thêm được: thông báo đã tồn tại.',
	'centralnotice-template-exists' => 'Không thêm được: tiêu bản đã tồn tại.',
	'centralnotice-notice-doesnt-exist' => 'Không dời được: thông báo không tồn tại.',
	'centralnotice-template-still-bound' => 'Không dời được: có thông báo dựa theo tiêu bản.',
	'centralnotice-template-body' => 'Nội dung tiêu bản:',
	'centralnotice-day' => 'Ngày',
	'centralnotice-year' => 'Năm',
	'centralnotice-month' => 'Tháng',
	'centralnotice-hours' => 'Giờ',
	'centralnotice-min' => 'Phút',
	'centralnotice-project-lang' => 'Ngôn ngữ của dự án',
	'centralnotice-project-name' => 'Tên dự án',
	'centralnotice-start-date' => 'Ngày bắt đầu',
	'centralnotice-start-time' => 'Lúc bắt đầu (UTC)',
	'centralnotice-assigned-templates' => 'Tiêu bản được sử dụng',
	'centralnotice-no-templates' => 'Hệ thống không chứa tiêu bản',
	'centralnotice-no-templates-assigned' => 'Thông báo không dùng tiêu bản nào. Hãy chỉ định tiêu bản!',
	'centralnotice-available-templates' => 'Tiêu bản có sẵn',
	'centralnotice-template-already-exists' => 'Không chỉ định được: thông báo đã sử dụng tiêu bản.',
	'centralnotice-preview-template' => 'Xem trước tiêu bản',
	'centralnotice-start-hour' => 'Lúc bắt đầu',
	'centralnotice-change-lang' => 'Thay đổi ngôn ngữ của bản dịch',
	'centralnotice-weights' => 'Mức ưu tiên',
	'centralnotice-notice-is-locked' => 'Không dời được: thông báo bị khóa.',
	'centralnotice-overlap' => 'Không thêm được: thông báo sẽ hiện cùng lúc với thông báo khác.',
	'centralnotice-invalid-date-range' => 'Không cập nhật được: thời gian không hợp lệ.',
	'centralnotice-null-string' => 'Không thêm được: chuỗi rỗng.',
	'centralnotice-confirm-delete' => 'Bạn có chắc muốn xóa thông báo hoặc tiêu bản này không? Không thể phục hồi nó.',
	'centralnotice-no-notices-exist' => 'Chưa có thông báo. Hãy thêm thông báo ở dưới.',
	'centralnotice-no-templates-translate' => 'Không có tiêu bản để dịch',
	'centralnotice-number-uses' => 'Số thông báo dùng',
	'centralnotice-edit-template' => 'Sửa đổi tiêu bản',
	'centralnotice-message' => 'Thông báo',
	'centralnotice-message-not-set' => 'Thông báo chưa được thiết lập',
	'centralnotice-clone' => 'Sao',
	'centralnotice-clone-notice' => 'Tạo bản sao của tiêu bản',
	'centralnotice-preview-all-template-translations' => 'Xem trước các bản dịch có sẵn của tiêu bản',
	'right-centralnotice-admin' => 'Quản lý thông báo chung',
	'right-centralnotice-translate' => 'Dịch thông báo chung',
	'action-centralnotice-admin' => 'quản lý thông báo chung',
	'action-centralnotice-translate' => 'dịch thông báo chung',
	'centralnotice-preferred' => 'Nổi bật hơn',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'centralnotice-desc' => 'Läükön sitanulod zänodik',
	'centralnotice-preview' => 'Büologed',
	'centralnotice-translations' => 'Tradutods',
	'centralnotice-translate' => 'Tradutön',
	'centralnotice-english' => 'Linglänapük',
	'centralnotice-day' => 'Del',
	'centralnotice-year' => 'Yel',
	'centralnotice-month' => 'Mul',
	'centralnotice-hours' => 'Düp',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Proyegapük',
	'centralnotice-project-name' => 'Proyeganem',
	'centralnotice-number-uses' => 'Gebs',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'centralnotice-translate-heading' => 'פֿאַרטייטשונג פֿאַר ִ$1',
	'centralnotice-translations' => 'פֿאַרטייטשונגען',
	'centralnotice-translate-to' => 'פֿאַרטייטשן אויף',
	'centralnotice-translate' => 'פֿאַרטייטשן',
	'centralnotice-english' => 'ענגליש',
	'centralnotice-template-name' => 'מוסטער נאמען',
	'centralnotice-templates' => 'מוסטערן',
	'centralnotice-day' => 'טאג',
	'centralnotice-year' => 'יאר',
	'centralnotice-month' => 'מאנאט',
	'centralnotice-hours' => 'שעה',
	'centralnotice-min' => 'מינוט',
	'centralnotice-project-lang' => 'פראיעקט שפראך',
	'centralnotice-project-name' => 'פראיעקט נאמען',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'centralnotice-desc' => '加入一個中央公告欄',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Alex S.H. Lin
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'centralnotice-desc' => '在页面的顶部增加統一的公告栏位',
	'centralnotice-enabled' => '已启用',
	'centralnotice-modify' => '提交',
	'centralnotice-preview' => '预览',
	'centralnotice-english' => '英语',
	'centralnotice-template-name' => '模板名称',
	'centralnotice-templates' => '模板',
	'centralnotice-locked' => '已锁定',
	'centralnotice-project-lang' => '计划语言',
	'centralnotice-project-name' => '计划名称',
	'centralnotice-preview-template' => '预览模板',
	'centralnotice-edit-template' => '编辑模板',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alex S.H. Lin
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'centralnotice-desc' => '在頁面頂端增加統一的公告欄位',
	'centralnotice-enabled' => '已啟用',
	'centralnotice-modify' => '提交',
	'centralnotice-preview' => '預覽',
	'centralnotice-english' => '英語',
	'centralnotice-template-name' => '模板名稱',
	'centralnotice-templates' => '模板',
	'centralnotice-locked' => '已鎖定',
	'centralnotice-project-lang' => '計劃語言',
	'centralnotice-project-name' => '計劃名稱',
	'centralnotice-preview-template' => '預覽模板',
	'centralnotice-edit-template' => '編輯模板',
);

