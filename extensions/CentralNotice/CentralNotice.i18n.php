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
Add one below.',
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
 * @author Bennylin
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
	'centralnotice-end-date' => '{{Identical|End date}}',
	'centralnotice-enabled' => '{{Identical|Enabled}}',
	'centralnotice-modify' => '{{Identical|Submit}}',
	'centralnotice-preview' => '{{Identical|Preview}}',
	'centralnotice-remove' => '{{Identical|Remove}}',
	'centralnotice-translate-heading' => '$1 is a name of a template.',
	'centralnotice-add' => '{{Identical|Add}}',
	'centralnotice-translate' => '{{Identical|Translate}}',
	'centralnotice-notice-exists' => 'Errore message displayed in Special:CentralNotice when trying to add a notice with the same name of another notice',
	'centralnotice-template-exists' => 'Errore message displayed in Special:NoticeTemplate when trying to add a template with the same name of another template',
	'centralnotice-start-date' => 'Used in Special:CentralNotice.

{{Identical|Start date}}',
	'centralnotice-start-time' => 'Used in Special:CentralNotice',
	'centralnotice-available-templates' => 'Used in Special:NoticeTemplate',
	'centralnotice-notice-is-locked' => 'Errore message displayed in Special:CentralNotice when trying to delete a locked notice',
	'centralnotice-invalid-date-range' => '{{Identical|Date}}',
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
	'centralnotice-query' => 'Verander huidige kennisgewings',
	'centralnotice-notice-name' => 'Kennisgewing-naam',
	'centralnotice-end-date' => 'Einddatum',
	'centralnotice-enabled' => 'Aktief',
	'centralnotice-modify' => 'Dien in',
	'centralnotice-preview' => 'Voorskou',
	'centralnotice-add-new' => "Voeg 'n nuwe sentrale kennisgewing by",
	'centralnotice-remove' => 'Verwyder',
	'centralnotice-translate-heading' => 'Vertaling vir $1',
	'centralnotice-manage' => 'Beheer sentrale kennisgewings',
	'centralnotice-add' => 'Byvoeg',
	'centralnotice-add-notice' => "Voeg 'n kennisgewing by",
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
	'centralnotice-notices' => 'Kennisgewings',
	'centralnotice-notice-exists' => 'Die kennisgewing bestaan reeds.
Hierdie word nie bygevoeg nie.',
	'centralnotice-template-exists' => 'Die sjabloon bestaan reeds.
Dit word nie bygevoeg nie.',
	'centralnotice-notice-doesnt-exist' => 'Die kennisgewing bestaan nie.
Daar is niks om te verwyder nie',
	'centralnotice-template-still-bound' => "Die sjabloon is nog aan 'n kennisgewing gekoppel.
Word nie verwyder nie.",
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
	'centralnotice-no-templates' => "Daar is geen sjablone op die stelsel beskikbaar nie.
Voeg 'n paar by!",
	'centralnotice-no-templates-assigned' => "Daar is geen sjablone aan die kennisgewing toegewys nie.
Voeg 'n paar by!",
	'centralnotice-available-templates' => 'Beskikbare sjablone',
	'centralnotice-template-already-exists' => 'Die sjabloon is reeds aan \'n "campaign" gekoppel.
Word nie bygevoeg nie',
	'centralnotice-preview-template' => 'Voorskou sjabloon',
	'centralnotice-start-hour' => 'Begintyd',
	'centralnotice-change-lang' => 'Verander taal vir vertaling',
	'centralnotice-weights' => 'Gewigte',
	'centralnotice-notice-is-locked' => 'Kennisgewing is gesluit.
Word nie verwyder nie',
	'centralnotice-overlap' => "Die kennisgewing oorvleuel met 'n ander kennisgewing.
Nie bygevoeg nie",
	'centralnotice-invalid-date-range' => 'Ongeldige datumreeks.
Word nie bygewerk nie',
	'centralnotice-null-string' => "Kan nie 'n leë teksveld bysit nie.
Word nie bygevoeg nie",
	'centralnotice-confirm-delete' => 'Is u seker u wil hierdie item verwyder?
Hierdie aksie kan nie teruggerol word nie.',
	'centralnotice-no-notices-exist' => 'Daar bestaan geen kennisgewings nie.
U kan een hieronder byvoeg',
	'centralnotice-no-templates-translate' => 'Daar is geen sjablone waarvoor vertalings gemaak kan word nie',
	'centralnotice-number-uses' => 'Aantal kere gebruik',
	'centralnotice-edit-template' => 'Wysig sjabloon',
	'centralnotice-message' => 'Boodskap',
	'centralnotice-message-not-set' => 'Boodskap nie ingestel nie',
	'centralnotice-clone' => 'Kopieer',
	'centralnotice-clone-notice' => "Maak 'n kopie van die sjabloon",
	'centralnotice-preview-all-template-translations' => 'Voorskou al die beskikbare vertalings van die sjabloon',
	'right-centralnotice-admin' => 'Bestuur sentrale kennisgewings',
	'right-centralnotice-translate' => 'Vertaal sentrale kennisgewings',
	'action-centralnotice-admin' => 'bestuur sentrale kennisgewings',
	'action-centralnotice-translate' => 'vertaal sentrale kennisgewings',
	'centralnotice-preferred' => 'Voorkeur',
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
	'centralnotice-start-time' => 'وقت البداية (UTC)',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'centralnotice-add' => 'ܐܘܣܦ',
	'centralnotice-add-template' => 'ܐܘܣܦ ܩܠܒܐ',
	'centralnotice-translate' => 'ܬܪܓܡ',
	'centralnotice-day' => 'ܝܘܡܐ',
	'centralnotice-year' => 'ܫܢܬܐ',
	'centralnotice-month' => 'ܝܪܚܐ',
	'centralnotice-hours' => 'ܫܥܬܐ',
	'centralnotice-min' => 'ܩܛܝܢܬܐ',
	'centralnotice-edit-template' => 'ܫܚܠܦ ܩܠܒܐ',
	'centralnotice-message' => 'ܐܓܪܬܐ',
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
	'centralnotice-summary' => 'الوحدة دى بتسمحلك بتعديل إعدادات الإخطار المركزى الحالية.
ممكن تستخدم كمان لإضافة أو إزالة إخطارات قديمة.',
	'centralnotice-query' => 'تعديل الاعلانات الموجودة دلوقتي',
	'centralnotice-notice-name' => 'اسم الاعلان',
	'centralnotice-end-date' => 'تاريخ الانتهاء',
	'centralnotice-enabled' => 'متشغل',
	'centralnotice-modify' => 'قدم',
	'centralnotice-preview' => 'اعمل بروفة',
	'centralnotice-add-new' => 'حط اعلان مركزى جديد',
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
	'centralnotice-start-time' => 'وقت البداية (توقيت عالمى)',
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
	'centralnotice-no-templates-translate' => 'مافيش أى قالب لتحرير ترجمته',
	'centralnotice-number-uses' => 'الاستعمالات',
	'centralnotice-edit-template' => 'عدل فى القالب',
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
	'noticetemplate' => 'تمپلت اعلان مرکزی',
	'centralnotice-desc' => 'یک مرکزی اخطار سایت هور کنت',
	'centralnotice-query' => 'عوض کتن نوکین اعلانات',
	'centralnotice-notice-name' => 'اعلان ءِ نام',
	'centralnotice-end-date' => 'وهد هلگ',
	'centralnotice-enabled' => 'فعال',
	'centralnotice-modify' => 'دیم دهگ',
	'centralnotice-preview' => 'پیشدارگ',
	'centralnotice-add' => 'هور کتن',
	'centralnotice-translations' => 'ترجمه هان',
	'centralnotice-translate-to' => 'ترجمه په',
	'centralnotice-translate' => 'ترجمه کتن',
	'centralnotice-english' => 'انگریزی',
	'centralnotice-weight' => 'وزن',
	'centralnotice-locked' => 'کبل',
	'centralnotice-notices' => 'اعلانات',
	'centralnotice-day' => 'روچ',
	'centralnotice-year' => 'سال',
	'centralnotice-month' => 'ماه',
	'centralnotice-hours' => 'ساعت',
	'centralnotice-min' => 'دقیقه',
	'centralnotice-start-hour' => 'وهد بنگیج',
	'centralnotice-null-string' => 'هالیکن رشتگی نه تونیت هور بیت.
هوری نکنت',
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
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'centralnotice' => 'Администратор на централизираните съобщения',
	'noticetemplate' => 'Шаблон за централизирани съобщения',
	'centralnotice-desc' => 'Добавя главнa сайтова бележка',
	'centralnotice-summary' => 'Този интерфейс позволява да редактирате текущо съществуващите централизирани съобщения.
Той може да се използва и за прибавяне на нови и премахване на стари съобщения.',
	'centralnotice-query' => 'Промяна на текущите съобщения',
	'centralnotice-notice-name' => 'Име на съобщението',
	'centralnotice-end-date' => 'Крайна дата',
	'centralnotice-enabled' => 'Включено',
	'centralnotice-modify' => 'Изпращане',
	'centralnotice-preview' => 'Преглеждане',
	'centralnotice-add-new' => 'Добавяне на ново централизирано съобщение',
	'centralnotice-remove' => 'Премахване',
	'centralnotice-translate-heading' => 'Превод за $1',
	'centralnotice-manage' => 'Управление на централизираното съобщение',
	'centralnotice-add' => 'Добавяне',
	'centralnotice-add-notice' => 'Добавяне на съобщение',
	'centralnotice-add-template' => 'Добавяне на шаблон',
	'centralnotice-show-notices' => 'Показване на съобщенията',
	'centralnotice-list-templates' => 'Списък на шаблоните',
	'centralnotice-translations' => 'Преводи',
	'centralnotice-translate-to' => 'Превеждане на',
	'centralnotice-translate' => 'Превеждане',
	'centralnotice-english' => 'Английски',
	'centralnotice-template-name' => 'Име на шаблона',
	'centralnotice-templates' => 'Шаблони',
	'centralnotice-weight' => 'Тежест',
	'centralnotice-locked' => 'Заключено',
	'centralnotice-notices' => 'Съобщения',
	'centralnotice-template-body' => 'Тяло на шаблона:',
	'centralnotice-day' => 'Ден',
	'centralnotice-year' => 'Година',
	'centralnotice-month' => 'Месец',
	'centralnotice-hours' => 'Час',
	'centralnotice-min' => 'Минута',
	'centralnotice-project-lang' => 'Език на проекта',
	'centralnotice-project-name' => 'Име на проекта',
	'centralnotice-start-date' => 'Начална дата',
	'centralnotice-start-time' => 'начално време (UTC)',
	'centralnotice-available-templates' => 'Налични шаблони',
	'centralnotice-preview-template' => 'Преглед на шаблона',
	'centralnotice-start-hour' => 'Начален час',
	'centralnotice-no-templates-translate' => 'Няма шаблони, за които да се редактират преводите',
	'centralnotice-edit-template' => 'Редактиране на шаблон',
	'centralnotice-message' => 'Съобщение',
	'centralnotice-message-not-set' => 'Съобщението не е зададено',
	'centralnotice-clone' => 'Клониране',
	'centralnotice-clone-notice' => 'Създаване на копие на шаблона',
	'centralnotice-preview-all-template-translations' => 'Преглед на всички налични преводи на шаблона',
	'right-centralnotice-admin' => 'Управление на централизираните съобщения',
	'right-centralnotice-translate' => 'Превод на централизираните съобщения',
	'centralnotice-preferred' => 'Предпочитано',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'centralnotice' => 'কেন্দ্রীয় নোটিশ প্রশাসক',
	'noticetemplate' => 'কেন্দ্রীয় নোটিশ টেম্পলেট',
	'centralnotice-desc' => 'একটি কেন্দ্রীয় সাইটনোটিশ যোগ করো',
	'centralnotice-summary' => 'এই মডিউলটি বর্তমান সেটআপ করা সাইট নোটিশ সম্পাদনা করার সুযোগ দিবে।
পুরাতন নোটিশ যোগ বা অপসারণের কাজেও এটি ব্যবহার করা যাবে।',
	'centralnotice-query' => 'বর্তমান নোটিশ পরিবর্তন',
	'centralnotice-notice-name' => 'নোটিশের নাম',
	'centralnotice-end-date' => 'শেষের তারিখ',
	'centralnotice-enabled' => 'সক্রিয়',
	'centralnotice-modify' => 'জমা দাও',
	'centralnotice-preview' => 'প্রাকদর্শন',
	'centralnotice-add-new' => 'একটি নতুন কেন্দ্রীয় নোটিশ যোগ করো',
	'centralnotice-remove' => 'অপসারণ',
	'centralnotice-translate-heading' => '$1 এর জন্য অনুবাদ',
	'centralnotice-manage' => 'কেন্দ্রীয় নোটশ ব্যবস্থাপনা',
	'centralnotice-add' => 'যোগ',
	'centralnotice-add-notice' => 'নোটিশ যোগ',
	'centralnotice-add-template' => 'টেম্পলেট যোগ',
	'centralnotice-show-notices' => 'নোটিশ দেখাও',
	'centralnotice-list-templates' => 'টেম্পলেটের তালিকা',
	'centralnotice-translations' => 'অনুবাদসমূহ',
	'centralnotice-translate-to' => 'যে ভাষায় অনুবাদ করা হচ্ছে তা হল',
	'centralnotice-translate' => 'অনুবাদ',
	'centralnotice-english' => 'ইংরেজি',
	'centralnotice-template-name' => 'টেম্পলেটের নাম',
	'centralnotice-templates' => 'টেম্পলেট',
	'centralnotice-weight' => 'ওজন',
	'centralnotice-locked' => 'অবরুদ্ধ',
	'centralnotice-notices' => 'নোটিশ',
	'centralnotice-notice-exists' => 'সাইট নোটশ ইতিমধ্যে রয়েছে।
যোগ হয়নি',
	'centralnotice-template-exists' => 'টেম্পলেট ইতিমধ্যে রয়েছে।
যোগ হয়নি',
	'centralnotice-notice-doesnt-exist' => 'নোটিশ নেই।
অপসারণ করার মত কিছু নেই',
	'centralnotice-template-body' => 'টেম্পলেট বডি:',
	'centralnotice-day' => 'দিন',
	'centralnotice-year' => 'বছর',
	'centralnotice-month' => 'মাস',
	'centralnotice-hours' => 'ঘন্টা',
	'centralnotice-min' => 'মিনিট',
	'centralnotice-project-lang' => 'প্রকল্পের ভাষা',
	'centralnotice-project-name' => 'প্রকল্পের নাম',
	'centralnotice-start-date' => 'শুরুর তারিখ',
	'centralnotice-start-time' => 'শুরুর সময় (UTC)',
	'centralnotice-assigned-templates' => 'নিয়োজিত টেম্পলেট',
	'centralnotice-no-templates' => 'কোনো টেম্পলেট পাওয়া যায়নি।
যোগ করুন!',
	'centralnotice-no-templates-assigned' => 'নোটিশে কোনো টেম্পলেট নিয়োগ হয় নাই।
যোগ করুন!',
	'centralnotice-available-templates' => 'বিদ্যমান টেম্পলেট',
	'centralnotice-preview-template' => 'টেম্পলেট প্রাকদর্শন',
	'centralnotice-start-hour' => 'শুরুর সময়',
	'centralnotice-change-lang' => 'অনুবাদের ভাষা পরিবর্তন',
	'centralnotice-weights' => 'ওজন',
	'centralnotice-notice-is-locked' => 'নোটিশটি অবরুদ্ধ।
অপসারণ হয়নি',
	'centralnotice-overlap' => 'অন্য নোটিশের সময়ের মধ্যে অধিক্রমন (ওভারল্যাপ) করে।
যোগ হয়নি',
	'centralnotice-invalid-date-range' => 'ভুল তারিখ পরিসীমা।
হালনাগাদ হয়নি',
	'centralnotice-null-string' => 'খালি স্ট্রিং যোগ করা যাবে না।
যোগ হয়নি',
	'centralnotice-confirm-delete' => 'আপনি কি নিশ্চিত ভাবে এই আইটেমটি মুছে ফেলতে চান?
এই কাজটির পুনরুদ্ধার সম্ভব হবে না।',
	'centralnotice-no-notices-exist' => 'কোনো নোটিশ নেই।
নিচে একটি যোগ করুন।',
	'centralnotice-no-templates-translate' => 'অনুবাদ সম্পাদনার জন্য কোনো টেম্পলেট নেই',
	'centralnotice-number-uses' => 'ব্যবহার',
	'centralnotice-edit-template' => 'টেম্পলেট সম্পাদনা',
	'centralnotice-message' => 'বার্তা',
	'centralnotice-message-not-set' => 'বার্তা সেট হয়নি',
	'centralnotice-clone' => 'হুবুহু অনুলিপি',
	'centralnotice-clone-notice' => 'টেম্পলেটের অনুলিপি তৈরি করো',
	'centralnotice-preview-all-template-translations' => 'টেম্পলেটের বিদ্যমান সকল অনুবাদের প্রাকদর্শন দেখাও',
	'right-centralnotice-admin' => 'কেন্দ্রীয় নোটিশ ব্যবস্থাপনা',
	'right-centralnotice-translate' => 'কেন্দ্রীয় নোটিশ অনুবাদ করুন',
	'action-centralnotice-admin' => 'কেন্দ্রীয় নোটিশ ব্যবস্থাপনা করুন',
	'action-centralnotice-translate' => 'কেন্দ্রীয় নোটিশ অনুবাদ করুন',
	'centralnotice-preferred' => 'পছন্দনীয়',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'centralnotice' => 'Melestradurezh an alioù kreiz',
	'noticetemplate' => 'Patrom an alioù kreiz',
	'centralnotice-desc' => "Ouzhpennañ a ra ur c'hemenn kreiz e laez ar pajennoù (sitenotice).",
	'centralnotice-query' => 'Kemmañ an alioù a-vremañ',
	'centralnotice-notice-name' => 'Anv an ali',
	'centralnotice-end-date' => 'Deiziad termen',
	'centralnotice-enabled' => 'Gweredekaet',
	'centralnotice-modify' => 'Kas',
	'centralnotice-preview' => 'Rakwelet',
	'centralnotice-add-new' => 'Ouzhpennañ un ali kreiz nevez',
	'centralnotice-remove' => 'Dilemel',
	'centralnotice-translate-heading' => 'Troidigezh eus $1',
	'centralnotice-manage' => 'Merañ an alioù kreiz',
	'centralnotice-add' => 'Ouzhpennañ',
	'centralnotice-add-notice' => "Ouhzpennañ ur c'hemenn",
	'centralnotice-add-template' => 'Ouzhpennañ ur patrom',
	'centralnotice-show-notices' => 'Diskouez an alioù',
	'centralnotice-list-templates' => 'Listennañ ar patromoù',
	'centralnotice-translations' => 'Troidigezhioù',
	'centralnotice-translate-to' => 'Treiñ e',
	'centralnotice-translate' => 'Treiñ',
	'centralnotice-english' => 'Saozneg',
	'centralnotice-template-name' => 'Anv ar patrom',
	'centralnotice-templates' => 'Patromoù',
	'centralnotice-weight' => 'Pouez',
	'centralnotice-locked' => 'Prennet',
	'centralnotice-notices' => 'Kemennoù',
	'centralnotice-notice-exists' => "Bez ez eus dija eus an ali-se.
N'eo ket bet ouzhpennet neuze",
	'centralnotice-template-exists' => "Bez ez eus dija eus ar patrom-se.
N'eo ket bet ouzhpennet.",
	'centralnotice-notice-doesnt-exist' => "N'eus ket seus an ali-mañ.
N'eus netra da zilemel",
	'centralnotice-template-still-bound' => "Liammet eo c'hoazh ar patrom gant un ali.
N'eo ket bet dilammet.",
	'centralnotice-template-body' => 'Korf ar patrom :',
	'centralnotice-day' => 'Deiz',
	'centralnotice-year' => 'Bloaz',
	'centralnotice-month' => 'Miz',
	'centralnotice-hours' => 'Eur',
	'centralnotice-min' => 'Munutenn',
	'centralnotice-project-lang' => 'Yezh ar raktres',
	'centralnotice-project-name' => 'Anv ar raktres',
	'centralnotice-start-date' => 'Deiziad kregiñ',
	'centralnotice-start-time' => 'Eurvezh kregiñ (UTC)',
	'centralnotice-assigned-templates' => 'Patromoù deverket',
	'centralnotice-no-templates' => "N'eo bet kavet patrom ebet.
Ouzhpennit patromoù !",
	'centralnotice-no-templates-assigned' => "N'eus patrom ebet deverket gant an ali.
Ouzhpennit unan !",
	'centralnotice-available-templates' => 'Patromoù zo da gaout',
	'centralnotice-template-already-exists' => "Liammet eo c'hoazh ar patrom gant ur c'houlzad.
N'eo ket bet ouzhpennet.",
	'centralnotice-preview-template' => 'Rakwelet ar patrom',
	'centralnotice-start-hour' => 'Eurvezh kregiñ',
	'centralnotice-change-lang' => 'Kemmañ yezh an droidigezh',
	'centralnotice-weights' => 'Pouezioù',
	'centralnotice-notice-is-locked' => "Prenet eo an ali.
N'eo ket bet dilammet.",
	'centralnotice-null-string' => "Ne c'haller ket ouzhpennañ un neudennad c'houllo.
N'eo ket bet ouzhpennet",
	'centralnotice-confirm-delete' => "Ha sur oc'h ho peus c'hoant dilemmel an elfenn-mañ ?
Ne vo ket tu adtapout anezhi.",
	'centralnotice-no-notices-exist' => "N'eus ali ebet.
Ouzhpennit unan da heul.",
	'centralnotice-no-templates-translate' => "N'eus patrom ebet da dreiñ",
	'centralnotice-number-uses' => 'Implijoù',
	'centralnotice-edit-template' => 'Kemmañ ar patrom',
	'centralnotice-message' => 'Kemennadenn',
	'centralnotice-message-not-set' => "N'eo ket bet kaset ar gemenadenn",
	'centralnotice-clone' => 'Eilañ',
	'centralnotice-clone-notice' => 'Krouiñ un eiladenn eus ar patrom',
	'centralnotice-preview-all-template-translations' => 'Rakwellit an holl droidigezhioù a zo evit ar patrom-mañ',
	'right-centralnotice-admin' => 'Merañ an alioù kreiz',
	'right-centralnotice-translate' => 'Treiñ an alioù kreiz',
	'action-centralnotice-admin' => 'merañ an alioù kreiz',
	'action-centralnotice-translate' => 'treiñ an alioù kreiz',
	'centralnotice-preferred' => "Kavet gwelloc'h",
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

/** Catalan (Català)
 * @author Aleator
 * @author Loupeter
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'centralnotice' => "Administrador d'avisos centrals",
	'noticetemplate' => "Plantilla d'avís central",
	'centralnotice-desc' => "Afegeix un lloc central d'avisos",
	'centralnotice-summary' => "Aquesta extensió us permet editar el vostre lloc central d'avisos.
També pot ser usat per afegir o eliminar avisos.",
	'centralnotice-query' => 'Modifica avisos actuals',
	'centralnotice-notice-name' => "Nom de l'avís",
	'centralnotice-end-date' => 'Data de finalització',
	'centralnotice-enabled' => 'Activat',
	'centralnotice-modify' => 'Tramet',
	'centralnotice-preview' => 'Previsualitza',
	'centralnotice-add-new' => "Afegeix una nova central d'avisos",
	'centralnotice-remove' => 'Elimina',
	'centralnotice-translate-heading' => 'Traducció de $1',
	'centralnotice-manage' => "Gestiona la central d'avisos",
	'centralnotice-add' => 'Afegeix',
	'centralnotice-add-notice' => 'Afegeix un avís',
	'centralnotice-add-template' => 'Afegeix una plantilla',
	'centralnotice-show-notices' => 'Mostra avisos',
	'centralnotice-list-templates' => 'Llista les plantilles',
	'centralnotice-translations' => 'Traduccions',
	'centralnotice-translate-to' => 'Tradueix a',
	'centralnotice-translate' => 'Tradueix',
	'centralnotice-english' => 'Anglès',
	'centralnotice-template-name' => 'Nom de la plantilla',
	'centralnotice-templates' => 'Plantilles',
	'centralnotice-weight' => 'Pes',
	'centralnotice-locked' => 'Bloquejat',
	'centralnotice-notices' => 'Avisos',
	'centralnotice-notice-exists' => "L'avís ja existeix.
No s'afegirà",
	'centralnotice-template-exists' => "La plantilla ja existeix.
No s'afegirà.",
	'centralnotice-notice-doesnt-exist' => "L'avís no existeix.
No s'ha eliminat res",
	'centralnotice-template-still-bound' => "La plantilla encara s'usa en un avís.
No s'ha pogut eliminar.",
	'centralnotice-template-body' => 'Cos de la plantilla:',
	'centralnotice-day' => 'Dia',
	'centralnotice-year' => 'Any',
	'centralnotice-month' => 'Mes',
	'centralnotice-hours' => 'Hora',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Llengua del projecte',
	'centralnotice-project-name' => 'Nom del projecte',
	'centralnotice-start-date' => 'Data inicial',
	'centralnotice-start-time' => "Hora d'inici (UTC)",
	'centralnotice-assigned-templates' => 'Plantilles assignades',
	'centralnotice-no-templates' => 'No hi ha plantilles.
Afegiu-ne!',
	'centralnotice-no-templates-assigned' => "No hi ha plantilles assignades a l'avís.
Afegiu-ne!",
	'centralnotice-available-templates' => 'Plantilles disponibles',
	'centralnotice-template-already-exists' => "La plantilla ja s'està usant a la campanya.
No s'afegirà",
	'centralnotice-preview-template' => 'Previsualitza la plantilla',
	'centralnotice-start-hour' => "Hora d'inici",
	'centralnotice-change-lang' => 'Canvia la llengua de la traducció',
	'centralnotice-weights' => 'Pesos',
	'centralnotice-notice-is-locked' => "L'avís està bloquejat.
No s'ha eliminat",
	'centralnotice-overlap' => "L'avís se superposa en el temps amb un altre avís.
No s'ha afegit",
	'centralnotice-invalid-date-range' => 'Interval de dates invàlid.
No actualitzat',
	'centralnotice-null-string' => "No s'ha pogut afegir una cadena nul·la.",
	'centralnotice-confirm-delete' => 'Estau segur que voleu eliminar aquest ítem?
Aquesta acció serà irreversible.',
	'centralnotice-no-notices-exist' => 'No hi ha cap avís.
Afegiu-ne un a continuació.',
	'centralnotice-no-templates-translate' => 'No hi ha cap plantilla per editar les traduccions per',
	'centralnotice-number-uses' => 'Usos',
	'centralnotice-edit-template' => 'Edita la plantilla',
	'centralnotice-message' => 'Missatge',
	'centralnotice-message-not-set' => 'Missatge no fixat',
	'centralnotice-clone' => 'Duplica',
	'centralnotice-clone-notice' => 'Crea una còpia de la plantilla',
	'centralnotice-preview-all-template-translations' => 'Previsualitza totes les traduccions disponibles de plantilles',
	'right-centralnotice-admin' => 'Gestionau els avisos centrals',
	'right-centralnotice-translate' => 'Traduïu els avisos centrals',
	'action-centralnotice-admin' => 'Gestionau els avisos centrals',
	'action-centralnotice-translate' => 'Traduïu els avisos centrals',
	'centralnotice-preferred' => 'Preferit',
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

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'centralnotice' => "Gweinyddu'r hysbysiad canolog",
	'centralnotice-desc' => 'Yn ychwanegu hysbysiad canolog',
	'centralnotice-notice-name' => "Enw'r hysbysiad",
	'centralnotice-end-date' => 'Dyddiad y daw i ben',
	'centralnotice-modify' => 'Gosoder',
	'centralnotice-preview' => 'Rhagolwg',
	'centralnotice-remove' => 'Diddymu',
	'centralnotice-add' => 'Ychwanegu',
	'centralnotice-add-notice' => 'Ychwanegu hysbysiad',
	'centralnotice-translations' => 'Cyfieithiadau',
	'centralnotice-translate' => 'Cyfieithu',
	'centralnotice-english' => 'Saesneg',
	'centralnotice-notices' => 'Hysbysiadau',
	'centralnotice-day' => 'Dydd',
	'centralnotice-year' => 'Blwyddyn',
	'centralnotice-month' => 'Mis',
	'centralnotice-hours' => 'Awr',
	'centralnotice-min' => 'Munud',
	'centralnotice-project-lang' => 'Iaith y prosiect',
	'centralnotice-project-name' => "Enw'r prosiect",
	'centralnotice-start-date' => 'Dyddiad cychwyn',
	'centralnotice-start-time' => 'Amser cychwyn (UTC)',
	'centralnotice-start-hour' => 'Amser dechrau',
	'centralnotice-message' => 'Neges',
	'right-centralnotice-admin' => 'Gweinyddu hysbysiadau canolog',
	'right-centralnotice-translate' => 'Cyfieithu hysbysiadau canolog',
	'action-centralnotice-admin' => 'gweinyddu hysbysiadau canolog',
	'action-centralnotice-translate' => 'cyfieithu hysbysiadau canolog',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Masz
 */
$messages['da'] = array(
	'right-centralnotice-admin' => 'Administrere centrale meddelelser',
	'action-centralnotice-admin' => 'administrere centrale beskeder',
	'action-centralnotice-translate' => 'oversætte centrale beskeder',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
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
	'right-centralnotice-admin' => 'Zentrale Meldungen verwalten',
	'right-centralnotice-translate' => 'Zentrale Meldungen übersetzen',
	'action-centralnotice-admin' => 'Zentrale Seitennotiz verwalten',
	'action-centralnotice-translate' => 'Zentrale Seitennotiz übersetzen',
	'centralnotice-preferred' => 'Bevorzugt',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 */
$messages['de-formal'] = array(
	'centralnotice-confirm-delete' => 'Sind Sie sicher, dass Sie den Eintrag löschen möchten?
Die Aktion kann nicht rückgängig gemacht werden.',
);

/** Zazaki (Zazaki)
 * @author Xoser
 */
$messages['diq'] = array(
	'centralnotice' => 'Noticeyê adminê merkezî',
	'noticetemplate' => 'Templatê adminê merkezî',
	'centralnotice-desc' => 'Yew sitenoticeyê merkezî de keno',
	'centralnotice-summary' => 'Ena panel ti ra yardim keno ke ti eşkeno îkazanê merkezî bivurne.
Ena panel eyni zeman de eşkeno îkazanê kihanî de biko ya zi wedaro.',
	'centralnotice-query' => 'Îkazê peniyî bivurne',
	'centralnotice-notice-name' => 'Nameyê îkazî',
	'centralnotice-end-date' => 'Tarixê qediyayîşî',
	'centralnotice-enabled' => 'A biya',
	'centralnotice-modify' => 'Qeyd bike',
	'centralnotice-preview' => 'Verqeyd',
	'centralnotice-add-new' => 'Yew îkazê merkezi ye newî de bike',
	'centralnotice-remove' => 'Biwedar',
	'centralnotice-translate-heading' => 'Qe $1 çarnayîşî',
	'centralnotice-manage' => 'Yew îkazê merkezî îdare bike',
	'centralnotice-add' => 'De bike',
	'centralnotice-add-notice' => 'Yew îkazê de bike',
	'centralnotice-add-template' => 'Yew template de bike',
	'centralnotice-show-notices' => 'Îkazan bimucne',
	'centralnotice-list-templates' => 'Templeteyan liste bike',
	'centralnotice-translations' => 'Çarnayişan',
	'centralnotice-translate-to' => 'Ci ra çarnayîş bike',
	'centralnotice-translate' => 'Çarnayiş',
	'centralnotice-english' => 'Ingilizkî',
	'centralnotice-template-name' => 'Nameyê templateyî',
	'centralnotice-templates' => 'Templetan',
	'centralnotice-weight' => 'Ebat',
	'centralnotice-locked' => 'Kafilnaye',
	'centralnotice-notices' => 'Îkazan',
	'centralnotice-notice-exists' => 'Îkazê verînî hama esto.
De nikeno',
	'centralnotice-template-exists' => 'Templateyanê verînî hama esto.
De nikeno',
	'centralnotice-notice-doesnt-exist' => 'Îkazê verînî hama niesto.
De nikeno',
	'centralnotice-template-still-bound' => 'Templateyê verînî hama gani bihebito.
Niwedarneno',
	'centralnotice-template-body' => 'Bedenê templateyî:',
	'centralnotice-day' => 'Roc',
	'centralnotice-year' => 'Serre',
	'centralnotice-month' => 'Aşme',
	'centralnotice-hours' => 'Seet',
	'centralnotice-min' => 'Dekika',
	'centralnotice-project-lang' => 'Ziwanê proceyî',
	'centralnotice-project-name' => 'Nameyê proceyî',
	'centralnotice-start-date' => 'Wextê başli kerdişî',
	'centralnotice-start-time' => 'Seetê başli kerdişî  (UTC)',
	'centralnotice-assigned-templates' => 'Templatan ke assign biyo',
	'centralnotice-no-templates' => 'Templateyan nidiyo
Tay de bike!',
	'centralnotice-no-templates-assigned' => 'Qe îkazî, templateyan assign nibiyo.
Tay de bike!',
	'centralnotice-available-templates' => 'Templatan ke esto',
	'centralnotice-template-already-exists' => 'Template hama hebitiyeno.
De nikeno',
	'centralnotice-preview-template' => 'Template verqeyd bike',
	'centralnotice-start-hour' => 'Seetê başli kerdişî',
	'centralnotice-change-lang' => 'Ziwanê translasyonî bivurne',
	'centralnotice-weights' => 'Ebatan',
	'centralnotice-notice-is-locked' => 'îkaz kefiniyo.
Niwedarano',
	'centralnotice-overlap' => 'Zerrê wextê îkazanî de overlapanê rê dikat bike.
De nikeno',
	'centralnotice-invalid-date-range' => 'Menzilê wextî raşt niyo.
Rocaniye nikeno',
	'centralnotice-null-string' => 'Yew stringê nullyî nieşkeno de bike.
De nikeno',
	'centralnotice-confirm-delete' => 'Ti raştî wazeno ena item biwedare?
Ena hereket reyna nieşkeno biyar.',
	'centralnotice-no-notices-exist' => 'Yew  îkaz zi çin o.
Yew de bike',
	'centralnotice-no-templates-translate' => 'Hin templeteyan çino ke ti biçarne',
	'centralnotice-number-uses' => 'Ça de kar keno',
	'centralnotice-edit-template' => 'Template bivurne',
	'centralnotice-message' => 'Mesaj',
	'centralnotice-message-not-set' => 'Mesaj nişiravt',
	'centralnotice-clone' => 'Kopye bike',
	'centralnotice-clone-notice' => 'Ye kopyayê templateyî viraze',
	'centralnotice-preview-all-template-translations' => 'Çarnayîşê template yê hemî bivîne',
	'right-centralnotice-admin' => 'Îkazanê merkezî îdare bike',
	'right-centralnotice-translate' => 'Çarnayîşê merkezî îdare bike',
	'action-centralnotice-admin' => 'îkazanê merkezî îdare bike',
	'action-centralnotice-translate' => 'çarnayîşê merkezî îdare bike',
	'centralnotice-preferred' => 'Tercih biyo',
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

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'centralnotice-preview' => 'Kpɔe do ŋgɔ',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author K sal 15
 * @author Lou
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'centralnotice' => 'Διαχειριστής κεντρικών ειδοποιήσεων',
	'noticetemplate' => 'Πρότυπο κεντρικής ανακοίνωσης',
	'centralnotice-desc' => 'Προσθέτει μια κεντρική ανακοίνωση',
	'centralnotice-summary' => 'Αυτή η επέκταση σας επιτρέπει να επεξεργαστείτε τις τώρα εγκατεστημένες κεντρικές ειδοποιήσεις σας.
Μπορεί επίσης να χρησιμοποιηθεί για να προσθέσει ή να αφαιρέσει παλιές ειδοποιήσεις.',
	'centralnotice-query' => 'Τροποποίηση τρεχουσών ειδοποιήσεων',
	'centralnotice-notice-name' => 'Όνομα σημείωσης',
	'centralnotice-end-date' => 'Ημερομηνία λήξης',
	'centralnotice-enabled' => 'Ενεργοποιημένο',
	'centralnotice-modify' => 'Καταχώρηση',
	'centralnotice-preview' => 'Προεπισκόπηση',
	'centralnotice-add-new' => 'Προσθήκη νέας κεντρικής ανακοίνωσης',
	'centralnotice-remove' => 'Αφαίρεση',
	'centralnotice-translate-heading' => 'Μετάφραση για το $1',
	'centralnotice-manage' => 'Διαχείριση κεντρικής ειδοποίησης',
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
	'centralnotice-template-still-bound' => 'Το πρότυπο είναι ακόμη συνδεδεμένο με ένα σημείωμα.
Δεν έχει αφαιρεθεί.',
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
	'centralnotice-assigned-templates' => 'Απονομημένα πρότυπα',
	'centralnotice-no-templates' => 'Δεν βρέθηκαν πρότυπα.
Προσθέστε μερικά!',
	'centralnotice-no-templates-assigned' => 'Κανένα πρότυπο δεν έχει ανατεθεί σε σημείωση.
Προσθέστε κάποια!',
	'centralnotice-available-templates' => 'Διαθέσιμα πρότυπα',
	'centralnotice-template-already-exists' => 'Το πρότυπο είναι ακόμη συνδεδεμένο με μία καμπάνια. 
Δεν έχει προστεθεί',
	'centralnotice-preview-template' => 'Πρότυπο προεπισκόπησης',
	'centralnotice-start-hour' => 'Χρόνος εκκίνησης',
	'centralnotice-change-lang' => 'Αλλαγή της γλώσσας μετάφρασης',
	'centralnotice-weights' => 'Βάρη',
	'centralnotice-notice-is-locked' => 'Η σημείωση είναι κλειδωμένη.
Δεν θα αφαιρεθεί',
	'centralnotice-overlap' => 'Το σημείωμα επικαλύπτεται με τον χρόνο ενός άλλου σημειώματος. 
Δεν έχει προστεθεί',
	'centralnotice-invalid-date-range' => 'Άκυρο εύρος ημερομηνιών.
Δεν είναι ενημερωμένο',
	'centralnotice-null-string' => 'Αδύνατη η προσθήκη κενού ορμαθού.
Δεν έχει προστεθεί',
	'centralnotice-confirm-delete' => 'Είστε σίγουρος ότι θέλετε να διαγράψετε αυτό το αντικείμενο;
Αυτή η ενέργεια θα είναι μη αναστρέψιμη.',
	'centralnotice-no-notices-exist' => 'Δεν υπάρχουν σημειώσεις.
Προσθέστε μια παρακάτω.',
	'centralnotice-no-templates-translate' => 'Δεν υπάρχουν πολλά πρότυπα για να γίνει επεξεργασία των μεταφράσεων',
	'centralnotice-number-uses' => 'Χρήσεις',
	'centralnotice-edit-template' => 'Επεξεργασία προτύπου',
	'centralnotice-message' => 'Μήνυμα',
	'centralnotice-message-not-set' => 'Μη ρυθμισμένο μήνυμα',
	'centralnotice-clone' => 'Κλώνος',
	'centralnotice-clone-notice' => 'Δημιουργία ενός αντίγραφου του προτύπου',
	'centralnotice-preview-all-template-translations' => 'Προεπισκόπηση όλων των διαθέσιμων μεταφράσεων του προτύπου',
	'right-centralnotice-admin' => 'Διαχείριση κεντρικών ειδοποιήσεων',
	'right-centralnotice-translate' => 'Μετάφραση κεντρικών ειδοποιήσεων',
	'action-centralnotice-admin' => 'διαχείριση κεντρικών ειδοποιήσεων',
	'action-centralnotice-translate' => 'μετάφραση κεντρικών ειδοποιήσεων',
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
 * @author Locos epraix
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'centralnotice' => 'Administración del aviso central',
	'noticetemplate' => 'Plantilla del aviso central',
	'centralnotice-desc' => 'Añade un mensaje central',
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
 * @author Pikne
 */
$messages['et'] = array(
	'centralnotice' => 'Keskuse teadete haldamine',
	'noticetemplate' => 'Keskuse teate mall',
	'centralnotice-desc' => 'Lisab keskse võrgukohateatesüsteemi.',
	'centralnotice-summary' => 'See komponent võimaldab muuta praegu üles seatud keskuse teateid.
Samuti saab sellega teateid lisada või vanu teateid eemaldada.',
	'centralnotice-notice-name' => 'Teate nimi',
	'centralnotice-end-date' => 'Lõpukuupäev',
	'centralnotice-enabled' => 'Kasutusel',
	'centralnotice-modify' => 'Sobib',
	'centralnotice-preview' => 'Eelvaade',
	'centralnotice-add-new' => 'Lisa uus keskuse teade',
	'centralnotice-remove' => 'Eemalda',
	'centralnotice-translate-heading' => 'Malli $1 tõlge',
	'centralnotice-manage' => 'Keskuse teate muutmine',
	'centralnotice-add' => 'Lisa',
	'centralnotice-add-notice' => 'Lisa teade',
	'centralnotice-add-template' => 'Lisa mall',
	'centralnotice-show-notices' => 'Näita teateid',
	'centralnotice-list-templates' => 'Mallide list',
	'centralnotice-translations' => 'Tõlked',
	'centralnotice-translate-to' => 'Tõlgi',
	'centralnotice-translate' => 'Tõlgi',
	'centralnotice-english' => 'Inglise',
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
	'centralnotice-template-still-bound' => 'Mall on ikka teatega seotud.
Ei eemaldata',
	'centralnotice-template-body' => 'Malli sisu:',
	'centralnotice-day' => 'Päev',
	'centralnotice-year' => 'Aasta',
	'centralnotice-month' => 'Kuu',
	'centralnotice-hours' => 'Tund',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Projekti keel',
	'centralnotice-project-name' => 'Projekti nimi',
	'centralnotice-start-date' => 'Alguskuupäev',
	'centralnotice-start-time' => 'Alguskellaaeg (UTC)',
	'centralnotice-assigned-templates' => 'Vastavad mallid',
	'centralnotice-no-templates' => 'Malle ei leitud.

Lisa mõni!',
	'centralnotice-no-templates-assigned' => 'Teatega pole vastavusse seatud ühtegi malli.
Lisa mõni!',
	'centralnotice-available-templates' => 'Saadaolevad mallid',
	'centralnotice-template-already-exists' => 'Mall on juba kampaaniaga seotud.
Ei lisata',
	'centralnotice-preview-template' => 'Malli eelvaade',
	'centralnotice-start-hour' => 'Algusaeg',
	'centralnotice-change-lang' => 'Tõlkekeele vahetamine',
	'centralnotice-weights' => 'Raskused',
	'centralnotice-notice-is-locked' => 'Teade on lukustatud.
Ei eemaldata',
	'centralnotice-confirm-delete' => 'Soovid sa tõepoolest seda üksust kustutada.
See toiming pole tagasipööratav.',
	'centralnotice-no-notices-exist' => 'Ühtegi teadet pole.
Lisa allpool üks.',
	'centralnotice-no-templates-translate' => 'Pole ühtegi malli, mille tõlget muuta',
	'centralnotice-number-uses' => 'Kasutusi',
	'centralnotice-edit-template' => 'Malli muutmine',
	'centralnotice-message' => 'Sõnum',
	'centralnotice-message-not-set' => 'Sõnumit ei ole seatud',
	'centralnotice-clone' => 'Kloon',
	'centralnotice-clone-notice' => 'Loo mallist koopia',
	'centralnotice-preview-all-template-translations' => 'Malli kõigi kättesaadavate tõlgete eelvaated',
	'right-centralnotice-admin' => 'Keskuse teateid hallata',
	'right-centralnotice-translate' => 'Tõlkida keskuse teateid',
	'action-centralnotice-admin' => 'keskuse teateid hallata',
	'action-centralnotice-translate' => 'keskuse teateid tõlkida',
	'centralnotice-preferred' => 'Eelistatud',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Pi
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
	'centralnotice-translate' => 'Itzuli',
	'centralnotice-english' => 'Ingelera',
	'centralnotice-template-name' => 'Txantiloi izena',
	'centralnotice-templates' => 'Txantiloiak',
	'centralnotice-weight' => 'Pisua',
	'centralnotice-locked' => 'Babesturik',
	'centralnotice-notices' => 'Berriak',
	'centralnotice-notice-exists' => 'Berria badago dagoeneko.
Ez da gehituko',
	'centralnotice-template-body' => 'Txantiloi gorputza:',
	'centralnotice-day' => 'Egun',
	'centralnotice-year' => 'Urte',
	'centralnotice-month' => 'Hilabete',
	'centralnotice-hours' => 'Ordu',
	'centralnotice-min' => 'Minutu',
	'centralnotice-project-lang' => 'Proiektuaren hizkuntza',
	'centralnotice-project-name' => 'Proiektuaren izena',
	'centralnotice-start-date' => 'Hasiera data',
	'centralnotice-start-time' => 'Hasiera ordua (UTC)',
	'centralnotice-assigned-templates' => 'Ezarritako txantiloiak',
	'centralnotice-preview-template' => 'Txantiloia aurreikusi',
	'centralnotice-start-hour' => 'Hasiera ordua',
	'centralnotice-change-lang' => 'Aldatu itzulpen hizkuntza',
	'centralnotice-edit-template' => 'Txantiloia aldatu',
	'centralnotice-message' => 'Mezua',
	'centralnotice-clone-notice' => 'Txantiloia honen kopia sortu',
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
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Meithal
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'centralnotice' => 'Administration des avis centraux',
	'noticetemplate' => 'Modèle des avis centraux',
	'centralnotice-desc' => 'Ajoute un avis central du site',
	'centralnotice-summary' => 'Ce module vous permet de modifier vos paramètres d’avis centraux.
Il peut aussi être utilisé pour ajouter des avis ou en enlever les plus anciens.',
	'centralnotice-query' => 'Modifier les avis actuels',
	'centralnotice-notice-name' => 'Nom de l’avis',
	'centralnotice-end-date' => 'Date de fin',
	'centralnotice-enabled' => 'Activé',
	'centralnotice-modify' => 'Soumettre',
	'centralnotice-preview' => 'Prévisualiser',
	'centralnotice-add-new' => 'Ajouter un nouvel avis central',
	'centralnotice-remove' => 'Supprimer',
	'centralnotice-translate-heading' => 'Traduction de l’avis « $1 »',
	'centralnotice-manage' => 'Gérer les avis centraux',
	'centralnotice-add' => 'Ajouter',
	'centralnotice-add-notice' => 'Ajouter un avis',
	'centralnotice-add-template' => 'Ajouter un modèle',
	'centralnotice-show-notices' => 'Afficher les avis',
	'centralnotice-list-templates' => 'Lister les modèles',
	'centralnotice-translations' => 'Traductions',
	'centralnotice-translate-to' => 'Traduire en',
	'centralnotice-translate' => 'Traduire',
	'centralnotice-english' => 'anglais',
	'centralnotice-template-name' => 'Nom du modèle',
	'centralnotice-templates' => 'Modèles',
	'centralnotice-weight' => 'Poids',
	'centralnotice-locked' => 'Verrouillé',
	'centralnotice-notices' => 'Avis',
	'centralnotice-notice-exists' => 'L’avis existe déjà.
Il n’a pas été ajouté.',
	'centralnotice-template-exists' => 'Le modèle existe déjà.
Il n’a pas été ajouté.',
	'centralnotice-notice-doesnt-exist' => 'L’avis n’existe pas.
Il n’y a rien à supprimer.',
	'centralnotice-template-still-bound' => 'Le modèle est encore lié à un avis.
Il n’a pas été supprimé.',
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
	'centralnotice-no-templates' => 'Aucun modèle trouvé.
Ajoutez-en !',
	'centralnotice-no-templates-assigned' => 'Aucun modèle assigné à l’avis.
Ajoutez-en !',
	'centralnotice-available-templates' => 'Modèles disponibles',
	'centralnotice-template-already-exists' => 'Le modèle est déjà attaché à une campagne.
Il n’a pas été ajouté.',
	'centralnotice-preview-template' => 'Prévisualiser le modèle',
	'centralnotice-start-hour' => 'Heure de début',
	'centralnotice-change-lang' => 'Modifier la langue de traduction',
	'centralnotice-weights' => 'Poids',
	'centralnotice-notice-is-locked' => 'L’avis est verrouillé.
Il n’a pas été supprimé.',
	'centralnotice-overlap' => 'L’avis couvre tout ou partie de la durée d’un autre avis.
Il n’a pas été ajouté.',
	'centralnotice-invalid-date-range' => 'Intervalle de dates incorrect pour l’avis.
Il n’a pas été mis à jour.',
	'centralnotice-null-string' => 'Impossible d’ajouter un avis vide.
Il n’a pas été ajouté.',
	'centralnotice-confirm-delete' => 'Êtes-vous sûr{{GENDER:||e|}} de vouloir supprimer cet élément ?
Cette action ne pourra pas être récupérée.',
	'centralnotice-no-notices-exist' => 'Aucun avis n’existe.
Ajoutez-en ci-dessous.',
	'centralnotice-no-templates-translate' => 'Il n’y a aucun modèle à traduire',
	'centralnotice-number-uses' => 'Utilisations',
	'centralnotice-edit-template' => 'Modifier le modèle',
	'centralnotice-message' => 'Message',
	'centralnotice-message-not-set' => 'Message non renseigné',
	'centralnotice-clone' => 'Dupliquer',
	'centralnotice-clone-notice' => 'Créer une copie du modèle',
	'centralnotice-preview-all-template-translations' => 'Prévisualiser toutes les traductions disponibles du modèle',
	'right-centralnotice-admin' => 'Gérer les avis centraux',
	'right-centralnotice-translate' => 'Traduire les avis centraux',
	'action-centralnotice-admin' => 'gérer les avis centraux',
	'action-centralnotice-translate' => 'traduire les avis centraux',
	'centralnotice-preferred' => 'Préféré',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'centralnotice' => 'Administracion des avis centrâls',
	'noticetemplate' => 'Modèlo des avis centrâls',
	'centralnotice-desc' => 'Apond un sitenotice centrâl.',
	'centralnotice-query' => 'Changiér los avis d’ora',
	'centralnotice-notice-name' => 'Nom de l’avis',
	'centralnotice-end-date' => 'Dâta de fin',
	'centralnotice-enabled' => 'Activâ',
	'centralnotice-modify' => 'Sometre',
	'centralnotice-preview' => 'Prèvisualisacion',
	'centralnotice-add-new' => 'Apondre un novél avis centrâl',
	'centralnotice-remove' => 'Suprimar',
	'centralnotice-translate-heading' => 'Traduccion de l’avis « $1 »',
	'centralnotice-manage' => 'Administrar los avis centrâls',
	'centralnotice-add' => 'Apondre',
	'centralnotice-add-notice' => 'Apondre un avis',
	'centralnotice-add-template' => 'Apondre un modèlo',
	'centralnotice-show-notices' => 'Fâre vêre los avis',
	'centralnotice-list-templates' => 'Listar los modèlos',
	'centralnotice-translations' => 'Traduccions',
	'centralnotice-translate-to' => 'Traduire en',
	'centralnotice-translate' => 'Traduire',
	'centralnotice-english' => 'Anglès',
	'centralnotice-template-name' => 'Nom du modèlo',
	'centralnotice-templates' => 'Modèlos',
	'centralnotice-weight' => 'Pêds',
	'centralnotice-locked' => 'Vèrrolyê',
	'centralnotice-notices' => 'Avis',
	'centralnotice-notice-exists' => 'L’avis ègziste ja.
Il at pas étâ apondu.',
	'centralnotice-template-exists' => 'Lo modèlo ègziste ja.
Il at pas étâ apondu.',
	'centralnotice-notice-doesnt-exist' => 'L’avis ègziste pas.
Y at ren a suprimar.',
	'centralnotice-template-still-bound' => 'Lo modèlo est adés liyê a un avis.
Il at pas étâ suprimâ.',
	'centralnotice-template-body' => 'Côrp du modèlo :',
	'centralnotice-day' => 'Jorn',
	'centralnotice-year' => 'An',
	'centralnotice-month' => 'Mês',
	'centralnotice-hours' => 'Hora',
	'centralnotice-min' => 'Menuta',
	'centralnotice-project-lang' => 'Lengoua du projèt',
	'centralnotice-project-name' => 'Nom du projèt',
	'centralnotice-start-date' => 'Dâta de comencement',
	'centralnotice-start-time' => 'Hora de comencement (UTC)',
	'centralnotice-assigned-templates' => 'Modèlos assignês',
	'centralnotice-no-templates' => 'Gins de modèlo trovâ.
Apondéd-nen !',
	'centralnotice-no-templates-assigned' => 'Gins de modèlo assignê a l’avis.
Apondéd-nen !',
	'centralnotice-available-templates' => 'Modèlos disponiblos',
	'centralnotice-template-already-exists' => 'Lo modèlo est ja atachiê a una propaganda.
Il at pas étâ apondu.',
	'centralnotice-preview-template' => 'Prèvisualisacion du modèlo',
	'centralnotice-start-hour' => 'Hora de comencement',
	'centralnotice-change-lang' => 'Changiér la lengoua de traduccion',
	'centralnotice-weights' => 'Pêds',
	'centralnotice-notice-is-locked' => 'L’avis est vèrrolyê.
Il at pas étâ suprimâ.',
	'centralnotice-overlap' => 'L’avis côvre tot ou ben partia du temps d’un ôtro avis.
Il at pas étâ apondu.',
	'centralnotice-invalid-date-range' => 'Entèrvalo de dâtes fôx por l’avis.
Il at pas étâ betâ a jorn.',
	'centralnotice-null-string' => 'Empossiblo d’apondre un avis vouedo.
Il at pas étâ apondu.',
	'centralnotice-confirm-delete' => 'Éte-vos de sûr de volêr suprimar ceti èlèment ?
Cela accion porrat pas étre rècupèrâ.',
	'centralnotice-no-notices-exist' => 'Nion avis ègziste.
Apondéd-nen ce-desot.',
	'centralnotice-no-templates-translate' => 'Y at gins de modèlo a traduire',
	'centralnotice-number-uses' => 'Usâjos',
	'centralnotice-edit-template' => 'Changiér lo modèlo',
	'centralnotice-message' => 'Mèssâjo',
	'centralnotice-message-not-set' => 'Mèssâjo pas rensègnê',
	'centralnotice-clone' => 'Copiyér',
	'centralnotice-clone-notice' => 'Fâre una copia du modèlo',
	'centralnotice-preview-all-template-translations' => 'Prèvisualisar totes les traduccions disponibles du modèlo',
	'right-centralnotice-admin' => 'Administrar los avis centrâls',
	'right-centralnotice-translate' => 'Traduire los avis centrâls',
	'action-centralnotice-admin' => 'administrar los avis centrâls',
	'action-centralnotice-translate' => 'traduire los avis centrâls',
	'centralnotice-preferred' => 'Prèferâ',
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
	'centralnotice-query' => 'Μετατροπία τρεχόντων σημειωμάτων',
	'centralnotice-modify' => 'Ὑποβάλλειν',
	'centralnotice-preview' => 'Προθεωρεῖν',
	'centralnotice-remove' => 'Άφαιρεῖν',
	'centralnotice-manage' => 'Διαχειρίζεσθαι κεντρικὸν σημείωμα',
	'centralnotice-add' => 'Προστιθέναι',
	'centralnotice-translate' => 'Μεταγλωττίζειν',
	'centralnotice-english' => 'Ἀγγλιστί',
	'centralnotice-weight' => 'Βάρος',
	'centralnotice-locked' => 'Κεκλῃσμένη',
	'centralnotice-notices' => 'Ἀναγγελίαι',
	'centralnotice-template-body' => 'Σῶμα προτύπου:',
	'centralnotice-preview-template' => 'Προθεωρεῖν πρότυπον',
	'centralnotice-weights' => 'Βάρη',
	'centralnotice-number-uses' => 'Χρήσεις',
	'centralnotice-message' => 'Μήνυμα',
	'centralnotice-clone' => 'Κλών',
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
 * @author Ex13
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
 * @author Bennylin
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'centralnotice' => 'Administrasi pengumuman sentral',
	'noticetemplate' => 'Templat pengumuman sentral',
	'centralnotice-desc' => 'Menambahkan suatu pengumuman sentral',
	'centralnotice-summary' => 'Dengan modul ini, Anda dapat menyunting pengaturan pengumuman sentral saat ini.
Modul ini juga dapat digunakan untuk menambahkan atau menghapus pengumuman lama.',
	'centralnotice-query' => 'Ubah pengumuman saat ini',
	'centralnotice-notice-name' => 'Judul pengumuman',
	'centralnotice-end-date' => 'Tanggal selesai',
	'centralnotice-enabled' => 'Diaktifkan',
	'centralnotice-modify' => 'Kirim',
	'centralnotice-preview' => 'Pratayang',
	'centralnotice-add-new' => 'Buat pengumuman sentral baru',
	'centralnotice-remove' => 'Hapus',
	'centralnotice-translate-heading' => 'Terjemahan untuk $1',
	'centralnotice-manage' => 'Pengaturan pengumuman sentral',
	'centralnotice-add' => 'Tambahkan',
	'centralnotice-add-notice' => 'Tambah pengumuman',
	'centralnotice-add-template' => 'Tambah templat',
	'centralnotice-show-notices' => 'Tampilkan pengumuman',
	'centralnotice-list-templates' => 'Daftar templat',
	'centralnotice-translations' => 'Terjemahan',
	'centralnotice-translate-to' => 'Terjemahkan ke',
	'centralnotice-translate' => 'Terjemahkan',
	'centralnotice-english' => 'Bahasa Inggris',
	'centralnotice-template-name' => 'Nama templat',
	'centralnotice-templates' => 'Templat',
	'centralnotice-weight' => 'Bobot',
	'centralnotice-locked' => 'Terkunci',
	'centralnotice-notices' => 'Pengumuman',
	'centralnotice-notice-exists' => 'Pengumuman sudah ada.
Batal menambahkan',
	'centralnotice-template-exists' => 'Templat sudah ada.
Batal menambahkan',
	'centralnotice-notice-doesnt-exist' => 'Pengumuman tidak ditemukan.
Batal menghapus',
	'centralnotice-template-still-bound' => 'Templat masih digunakan dalam suatu pengumuman.
Batal menghapus',
	'centralnotice-template-body' => 'Isi templat:',
	'centralnotice-day' => 'Hari',
	'centralnotice-year' => 'Tahun',
	'centralnotice-month' => 'Bulan',
	'centralnotice-hours' => 'Jam',
	'centralnotice-min' => 'Menit',
	'centralnotice-project-lang' => 'Bahasa proyek',
	'centralnotice-project-name' => 'Nama proyek',
	'centralnotice-start-date' => 'Tanggal mulai',
	'centralnotice-start-time' => 'Waktu mulai (UTC)',
	'centralnotice-assigned-templates' => 'Tempat yang digunakan',
	'centralnotice-no-templates' => 'Tidak ada templat yang ditemukan.
Tambahkan!',
	'centralnotice-no-templates-assigned' => 'Tidak ada templat yang digunakan dalam pengumuman.
Tambahkan!',
	'centralnotice-available-templates' => 'Templat yang tersedia',
	'centralnotice-template-already-exists' => 'Templat sudah digunakan dalam kampanye.
Batal menambahkan',
	'centralnotice-preview-template' => 'Lihat pratayang templat',
	'centralnotice-start-hour' => 'Waktu mulai',
	'centralnotice-change-lang' => 'Ubah bahasa terjemahan',
	'centralnotice-weights' => 'Bobot',
	'centralnotice-notice-is-locked' => 'Pengumuman terkunci.
Batal menghapus',
	'centralnotice-overlap' => 'Pengumuman bertumpang tindih dengan waktu pengumuman lainnya.
Batal menambahkan',
	'centralnotice-invalid-date-range' => 'Jangka waktu tidak valid.
Batal memperbarui',
	'centralnotice-null-string' => 'Tidak dapat menambahkan string kosong.
Batal menambahkan',
	'centralnotice-confirm-delete' => 'Apakah Anda yakin untuk menghapus?
Tindakan ini tidak dapat dibatalkan.',
	'centralnotice-no-notices-exist' => 'Tidak ada pengumuman ditemukan.
Tambahkan di bawah ini.',
	'centralnotice-no-templates-translate' => 'Tidak ada templat yang dapat diterjemahkan',
	'centralnotice-number-uses' => 'Menggunakan',
	'centralnotice-edit-template' => 'Sunting templat',
	'centralnotice-message' => 'Pesan',
	'centralnotice-message-not-set' => 'Pengaturan pesan tidak dilakukan',
	'centralnotice-clone' => 'Duplikat',
	'centralnotice-clone-notice' => 'Buat duplikat templat ini',
	'centralnotice-preview-all-template-translations' => 'Lihat pratayang semua terjemahan templat yang tersedia',
	'right-centralnotice-admin' => 'Mengatur pengumuman sentral',
	'right-centralnotice-translate' => 'Menerjemahkan pengumuman sentral',
	'action-centralnotice-admin' => 'mengatur pengumuman sentral',
	'action-centralnotice-translate' => 'menerjemahkan pengumuman sentral',
	'centralnotice-preferred' => 'Preferensi',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'centralnotice-modify' => 'Sendez',
	'centralnotice-add' => 'Adjuntar',
	'centralnotice-add-notice' => 'Adjuntar avizo',
	'centralnotice-add-template' => 'Adjuntar shablono',
	'centralnotice-english' => 'Angliana',
	'centralnotice-templates' => 'Shabloni',
	'centralnotice-weight' => 'Pezo',
	'centralnotice-notices' => 'Avizi',
	'centralnotice-day' => 'Dio',
	'centralnotice-year' => 'Yaro',
	'centralnotice-month' => 'Monato',
	'centralnotice-hours' => 'Horo',
	'centralnotice-min' => 'Minuto',
);

/** Icelandic (Íslenska)
 * @author Spacebirdy
 */
$messages['is'] = array(
	'centralnotice-modify' => 'Staðfesta',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
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
	'centralnotice-list-templates' => 'Elenca template',
	'centralnotice-translations' => 'Traduzioni',
	'centralnotice-translate-to' => 'Traduci in',
	'centralnotice-translate' => 'Traduci',
	'centralnotice-english' => 'Inglese',
	'centralnotice-template-name' => 'Nome template',
	'centralnotice-templates' => 'Template',
	'centralnotice-weight' => 'Dimensione',
	'centralnotice-locked' => 'Bloccato',
	'centralnotice-notices' => 'Avvisi',
	'centralnotice-notice-exists' => "Avviso già esistente. L'avviso non è stato aggiunto",
	'centralnotice-template-exists' => 'Template già esistente. Il template non è stato aggiunto',
	'centralnotice-notice-doesnt-exist' => 'Avviso non esistente. Niente da rimuovere',
	'centralnotice-template-still-bound' => 'Il template è ancora collegato a un avviso. Il template non è stato rimosso',
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
	'centralnotice-no-templates-assigned' => "Nessun template è assegnato all'avviso. Aggiungine qualcuno!",
	'centralnotice-available-templates' => 'Template disponibili',
	'centralnotice-template-already-exists' => 'Il template è già collegato alla campagna. Il template non è stato aggiunto',
	'centralnotice-preview-template' => 'Anteprima template',
	'centralnotice-start-hour' => 'Ora di inizio',
	'centralnotice-change-lang' => 'Cambia lingua della traduzione',
	'centralnotice-weights' => 'Dimensioni',
	'centralnotice-notice-is-locked' => "L'avviso è bloccato. Avviso non rimosso",
	'centralnotice-overlap' => "L'avviso si sovrappone con il tempo di un altro avviso. Non aggiunto",
	'centralnotice-invalid-date-range' => 'Intervallo di date non valido.
Non aggiorno',
	'centralnotice-null-string' => 'Impossibile aggiungere una stringa nulla.
Non aggiorno',
	'centralnotice-confirm-delete' => "Sei veramente sicuro di voler cancellare questo elemento? L'azione non è reversibile.",
	'centralnotice-no-notices-exist' => 'Non esiste alcun avviso. Aggiungine uno di seguito',
	'centralnotice-no-templates-translate' => 'Non ci sono template per cui modificare le traduzioni',
	'centralnotice-number-uses' => 'Usi',
	'centralnotice-edit-template' => 'Modifica template',
	'centralnotice-message' => 'Messaggio',
	'centralnotice-message-not-set' => 'Messaggio non impostato',
	'centralnotice-clone' => 'Clona',
	'centralnotice-clone-notice' => 'Crea una copia del template',
	'centralnotice-preview-all-template-translations' => 'Mostra tutte le traduzioni disponibili del template',
	'right-centralnotice-admin' => 'Gestisce gli avvisi centralizzati',
	'right-centralnotice-translate' => 'Traduce avvisi centralizzati',
	'action-centralnotice-admin' => 'gestire gli avvisi centralizzati',
	'action-centralnotice-translate' => 'tradurre avvisi centralizzati',
	'centralnotice-preferred' => 'Preferito',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'centralnotice' => '中央管理通知の管理',
	'noticetemplate' => '中央管理通知テンプレート',
	'centralnotice-desc' => '中央管理のサイト通知を追加する',
	'centralnotice-summary' => 'このモジュールにより現在設定されている中央管理通知を編集することができます。通知の追加や除去も行えます。',
	'centralnotice-query' => '現在の通知を変更する',
	'centralnotice-notice-name' => '通知名',
	'centralnotice-end-date' => '終了日',
	'centralnotice-enabled' => '有効',
	'centralnotice-modify' => '投稿',
	'centralnotice-preview' => 'プレビュー',
	'centralnotice-add-new' => '新しい中央管理通知を追加する',
	'centralnotice-remove' => '除去',
	'centralnotice-translate-heading' => '$1の翻訳',
	'centralnotice-manage' => '中央管理通知の管理',
	'centralnotice-add' => '追加',
	'centralnotice-add-notice' => '通知を追加',
	'centralnotice-add-template' => 'テンプレートを追加',
	'centralnotice-show-notices' => '通知を表示',
	'centralnotice-list-templates' => 'テンプレートを一覧表示',
	'centralnotice-translations' => '翻訳',
	'centralnotice-translate-to' => '翻訳先',
	'centralnotice-translate' => '翻訳',
	'centralnotice-english' => '英語',
	'centralnotice-template-name' => 'テンプレート名',
	'centralnotice-templates' => 'テンプレート',
	'centralnotice-weight' => '重さ',
	'centralnotice-locked' => 'ロック中',
	'centralnotice-notices' => '通知一覧',
	'centralnotice-notice-exists' => '通知がすでに存在します。追加できませんでした。',
	'centralnotice-template-exists' => 'テンプレートがすでに存在します。追加できませんでした。',
	'centralnotice-notice-doesnt-exist' => '通知が存在しません。除去できませんでした。',
	'centralnotice-template-still-bound' => 'そのテンプレートはまだ通知に使用されています。除去できませんでした。',
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
	'centralnotice-assigned-templates' => '使用テンプレート',
	'centralnotice-no-templates' => 'テンプレートがみつかりませんでした。なにか追加してください！',
	'centralnotice-no-templates-assigned' => '通知にテンプレートが使われていません。なにか追加してください！',
	'centralnotice-available-templates' => '利用可能なテンプレート',
	'centralnotice-template-already-exists' => 'テンプレートが特定の目的に使用されています。追加できません。',
	'centralnotice-preview-template' => 'テンプレートをプレビューする',
	'centralnotice-start-hour' => '開始時刻',
	'centralnotice-change-lang' => '翻訳言語を変更する',
	'centralnotice-weights' => '重要性',
	'centralnotice-notice-is-locked' => '通知がロックされています。除去できません。',
	'centralnotice-overlap' => 'すでにある通知と通知期間が重複しています。追加できません。',
	'centralnotice-invalid-date-range' => '通知期間の指定が無効です。更新できません。',
	'centralnotice-null-string' => '空の行は追加できません。',
	'centralnotice-confirm-delete' => 'この項目を削除してよいですか？この操作は取り消せません。',
	'centralnotice-no-notices-exist' => '通知はひとつもありません。以下に追加してください。',
	'centralnotice-no-templates-translate' => '翻訳すべきテンプレートはありません。',
	'centralnotice-number-uses' => '使用目的',
	'centralnotice-edit-template' => 'テンプレートを編集する',
	'centralnotice-message' => 'メッセージ',
	'centralnotice-message-not-set' => 'メッセージ未指定',
	'centralnotice-clone' => '複製',
	'centralnotice-clone-notice' => 'テンプレートの複製を作成する',
	'centralnotice-preview-all-template-translations' => 'テンプレートのすべての利用可能な翻訳をプレビューする',
	'right-centralnotice-admin' => '中央管理通知の管理',
	'right-centralnotice-translate' => '中央管理通知の翻訳',
	'action-centralnotice-admin' => '中央管理通知の管理',
	'action-centralnotice-translate' => '中央管理通知の翻訳',
	'centralnotice-preferred' => '優先',
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

/** Georgian (ქართული)
 * @author BRUTE
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'noticetemplate' => 'გლობალური შეტყობინების თარგი',
	'centralnotice-query' => 'მოქმედი შეტყობინების შეცვლა',
	'centralnotice-end-date' => 'დასრულების თარიღი',
	'centralnotice-modify' => 'გაგზავნა',
	'centralnotice-preview' => 'წინა',
	'centralnotice-remove' => 'წაშლა',
	'centralnotice-translate-heading' => 'თარგმანი $1-თვის',
	'centralnotice-add' => 'დამატება',
	'centralnotice-show-notices' => 'შეტყობინებების ჩვენება',
	'centralnotice-english' => 'ინგლისური',
	'centralnotice-template-name' => 'თარგების სახელი',
	'centralnotice-templates' => 'თარგები',
	'centralnotice-locked' => 'დაბლოკილი',
	'centralnotice-template-exists' => 'თარგი უკვე არსებობს. არ დაამატოთ',
	'centralnotice-notice-doesnt-exist' => 'შეტყობინება არ არსებობს.
არაფერია წასაშლელი.',
	'centralnotice-template-body' => 'თარგის სხეული:',
	'centralnotice-day' => 'დღე',
	'centralnotice-year' => 'წელი',
	'centralnotice-month' => 'თვე',
	'centralnotice-hours' => 'საათი',
	'centralnotice-min' => 'წუთი',
	'centralnotice-project-lang' => 'პროექტის ენა',
	'centralnotice-project-name' => 'პროექტის სახელი',
	'centralnotice-start-date' => 'დაწყების თარიღი',
	'centralnotice-start-time' => 'დაწყების დრო (UTC)',
	'centralnotice-no-templates' => 'თარგები ნაპოვნი არ არის. დაამატეთ რამე!',
	'centralnotice-preview-template' => 'წინა თარგი',
	'centralnotice-start-hour' => 'დაწყების დრო',
	'centralnotice-change-lang' => 'თარგმანის ენის შეცვლა',
	'centralnotice-confirm-delete' => 'დარწმუნებული ხართ, რომ გინდათ ამ ელემენტის წაშლა? ეს მოქმედება ვეღარ გაუქმნდება.',
	'centralnotice-edit-template' => 'თარგის რედაქტირება',
	'centralnotice-message' => 'შეტყობინება',
	'centralnotice-clone' => 'კლონირება',
	'centralnotice-clone-notice' => 'თარგის ასლის შექმნა',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'centralnotice-end-date' => 'កាលបរិច្ឆេទបញ្ចប់',
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
	'centralnotice-weight' => 'ទម្ងន់​',
	'centralnotice-locked' => 'បានចាក់សោ',
	'centralnotice-day' => 'ថ្ងៃ',
	'centralnotice-year' => 'ឆ្នាំ',
	'centralnotice-month' => 'ខែ',
	'centralnotice-hours' => 'ម៉ោង',
	'centralnotice-min' => 'នាទី',
	'centralnotice-project-lang' => 'ភាសាគម្រោង',
	'centralnotice-project-name' => 'ឈ្មោះគម្រោង',
	'centralnotice-start-time' => 'ម៉ោង​ចាប់ផ្តើម (UTC)',
	'centralnotice-preview-template' => 'មើលទំព័រគំរូជាមុន',
	'centralnotice-start-hour' => 'ពេលចាប់ផ្តើម',
	'centralnotice-edit-template' => 'កែប្រែទំព័រគំរូ',
	'centralnotice-message' => 'សារ',
	'centralnotice-clone' => 'ក្លូន',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'centralnotice-preview' => 'ಮುನ್ನೋಟ',
	'centralnotice-day' => 'ದಿನ',
	'centralnotice-year' => 'ವರ್ಷ',
	'centralnotice-month' => 'ತಿಂಗಳು',
	'centralnotice-hours' => 'ಘಂಟೆ',
	'centralnotice-min' => 'ನಿಮಿಷ',
	'centralnotice-project-lang' => 'ಪ್ರಾಜೆಕ್ಟ್ ಭಾಷೆ',
	'centralnotice-project-name' => 'ಪ್ರಾಜೆಕ್ಟ್ ಹೆಸರು',
	'centralnotice-message' => 'ಸಂದೇಶ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'centralnotice' => '중앙 공지 관리',
	'noticetemplate' => '중앙 공지 틀',
	'centralnotice-desc' => '중앙에서 공지하는 사이트노티스를 추가',
	'centralnotice-summary' => '전체 공지 기능을 추가합니다. 현재의 공지 편집 기능과 공지의 추가/삭제 기능을 제공합니다.',
	'centralnotice-query' => '현재 공지 수정하기',
	'centralnotice-notice-name' => '공지 이름',
	'centralnotice-end-date' => '종료 날짜',
	'centralnotice-enabled' => '활성화됨',
	'centralnotice-modify' => '변경',
	'centralnotice-preview' => '미리 보기',
	'centralnotice-add-new' => '새 중앙 공지 추가',
	'centralnotice-remove' => '제거',
	'centralnotice-translate-heading' => '$1에 대한 번역',
	'centralnotice-manage' => '중앙 공지 관리',
	'centralnotice-add' => '추가',
	'centralnotice-add-notice' => '알림을 추가하기',
	'centralnotice-add-template' => '틀을 추가하기',
	'centralnotice-show-notices' => '공지 표시하기',
	'centralnotice-list-templates' => '템플릿 목록 표시하기',
	'centralnotice-translations' => '번역',
	'centralnotice-translate-to' => '번역할 언어',
	'centralnotice-translate' => '번역하기',
	'centralnotice-english' => '영어',
	'centralnotice-template-name' => '틀 이름',
	'centralnotice-templates' => '틀',
	'centralnotice-weight' => '중요도',
	'centralnotice-locked' => '잠김',
	'centralnotice-notices' => '공지',
	'centralnotice-notice-exists' => '이미 공지가 존재합니다. 공지를 추가할 수 없습니다.',
	'centralnotice-template-exists' => '틀이 이미 존재합니다.
추가하지 않았습니다.',
	'centralnotice-notice-doesnt-exist' => '공지가 없습니다. 삭제할 수 없습니다.',
	'centralnotice-template-still-bound' => '템플릿이 공지에 사용되고 있습니다. 삭제할 수 없습니다.',
	'centralnotice-template-body' => '템플릿 내용:',
	'centralnotice-day' => '일',
	'centralnotice-year' => '연도',
	'centralnotice-month' => '월',
	'centralnotice-hours' => '시',
	'centralnotice-min' => '분',
	'centralnotice-project-lang' => '프로젝트 언어',
	'centralnotice-project-name' => '프로젝트 이름',
	'centralnotice-start-date' => '시작 날짜',
	'centralnotice-start-time' => '시작 시간 (UTC)',
	'centralnotice-assigned-templates' => '배당된 틀',
	'centralnotice-no-templates' => '사용 가능한 템플릿이 없습니다. 템플릿을 추가해주세요!',
	'centralnotice-no-templates-assigned' => '해당 공지에 사용가능한 템플릿이 없습니다. 템플릿을 추가해주세요!',
	'centralnotice-available-templates' => '사용 가능한 템플릿 목록',
	'centralnotice-template-already-exists' => '템플릿이 이미 설정되어 있습니다. 추가할 수 없습니다.',
	'centralnotice-preview-template' => '틀 미리 보기',
	'centralnotice-start-hour' => '시작 시간',
	'centralnotice-change-lang' => '번역할 언어 변경',
	'centralnotice-weights' => '중요도',
	'centralnotice-notice-is-locked' => '공지가 잠겼습니다.
제거하지 않았습니다.',
	'centralnotice-overlap' => '다른 공지와 시간이 중복됩니다. 추가할 수 없습니다.',
	'centralnotice-invalid-date-range' => '날짜 형식이 잘못되었습니다. 추가할 수 없습니다.',
	'centralnotice-null-string' => '공지 내용이 비었습니다. 추가할 수 없습니다.',
	'centralnotice-confirm-delete' => '정말 이 항목을 삭제하시겠습니까?
한 번 삭제하면 복구할 수 없습니다.',
	'centralnotice-no-notices-exist' => '공지가 존재하지 않습니다. 공지를 추가해주세요.',
	'centralnotice-no-templates-translate' => '번역해야 할 템플릿이 없습니다.',
	'centralnotice-number-uses' => '사용 횟수',
	'centralnotice-edit-template' => '틀 편집하기',
	'centralnotice-message' => '메시지',
	'centralnotice-message-not-set' => '메시지가 정의되지 않았습니다.',
	'centralnotice-clone' => '사본',
	'centralnotice-clone-notice' => '이 틀의 사본을 만들기',
	'centralnotice-preview-all-template-translations' => '템플렛의 모든 번역 미리 보기',
	'right-centralnotice-admin' => '중앙 공지 관리',
	'right-centralnotice-translate' => '중앙 공지 번역',
	'action-centralnotice-admin' => '중앙 공지를 관리하기',
	'action-centralnotice-translate' => '중앙 공지를 번역할',
	'centralnotice-preferred' => '우선 사용',
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

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'centralnotice-english' => 'Sowsnek',
	'centralnotice-day' => 'Dydh',
	'centralnotice-year' => 'Bledhen',
	'centralnotice-month' => 'Mis',
	'centralnotice-edit-template' => 'Chanjya skantlyn',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'centralnotice' => 'Administratioun vun den zenrale Matdeelungen',
	'noticetemplate' => 'Schabloun vun den zentrale Matdeelungen',
	'centralnotice-desc' => 'Setzt eng zentral Matdeelung iwwert de Site derbäi',
	'centralnotice-summary' => "Dës Erweiderung erlaabt et Är aktuell Parameter vun den zentrale Matdeelungen z'änneren.
Se kann och benotzt gi fir Matdeelunge derbäizesetzen oder aler ewechzehuelen.",
	'centralnotice-query' => 'Déi aktuell Matdeelungen änneren',
	'centralnotice-notice-name' => 'Numm vun der Matdeelung',
	'centralnotice-end-date' => 'Schlussdatum',
	'centralnotice-enabled' => 'Aktivéiert',
	'centralnotice-modify' => 'Späicheren',
	'centralnotice-preview' => 'Weisen ouni ze späicheren',
	'centralnotice-add-new' => 'Eng nei zentral Matdeelung derbäisetzen',
	'centralnotice-remove' => 'Ewechhuelen',
	'centralnotice-translate-heading' => 'Iwwersetzung vu(n) $1',
	'centralnotice-manage' => 'Zentralmatdeelunge geréieren',
	'centralnotice-add' => 'Derbäisetzen',
	'centralnotice-add-notice' => 'Eng Matdeelung derbäisetzen',
	'centralnotice-add-template' => 'Eng Schabloun derbäisetzen',
	'centralnotice-show-notices' => 'Matdeelunge weisen',
	'centralnotice-list-templates' => 'Lëscht vun de Schablounen',
	'centralnotice-translations' => 'Iwwersetzungen',
	'centralnotice-translate-to' => 'Iwwersetzen op',
	'centralnotice-translate' => 'Iwwersetzen',
	'centralnotice-english' => 'Englesch',
	'centralnotice-template-name' => 'Numm vun der Schabloun',
	'centralnotice-templates' => 'Schablounen',
	'centralnotice-weight' => 'Gewiicht',
	'centralnotice-locked' => 'Gespaart',
	'centralnotice-notices' => 'Matdeelungen',
	'centralnotice-notice-exists' => "D'Matdeelung gëtt et schonn.
Si konnt net derbäigesat ginn.",
	'centralnotice-template-exists' => "D'Schabloun gëtt et schonn.
Et gouf näischt derbäigsat.",
	'centralnotice-notice-doesnt-exist' => "D'Matdeelung gëtt et net.
Et gëtt näischt fir ewechzehuelen.",
	'centralnotice-template-still-bound' => "D'Schabloun ass nach ëmmer mat enger Notiz verbonn.
Si kann net ewechegeholl ginn",
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
	'centralnotice-no-templates-assigned' => 'Keng Schabloune matt der Meldung verbonn.
Setzt der derbäi!',
	'centralnotice-available-templates' => 'Disponibel Schablounen',
	'centralnotice-template-already-exists' => "D'Schabloun ass schonn enger Campagne zougedeelt.
Net derbäisetzen",
	'centralnotice-preview-template' => 'Schabloun weisen ouni ze späicheren',
	'centralnotice-start-hour' => 'Ufankszäit',
	'centralnotice-change-lang' => 'Sprooch vun der Iwwersetzung änneren',
	'centralnotice-weights' => 'Gewiicht',
	'centralnotice-notice-is-locked' => "D'Matdeelung ass gespaart.
Se kann net ewechgeholl ginn.",
	'centralnotice-overlap' => "D'Meldung iwwerschneid sech mat der Zäit vun enger anerer Meldung.
Net derbäigesat.",
	'centralnotice-invalid-date-range' => 'Ongëltegen Zäitraum.
Gëtt net aktualiséiert.',
	'centralnotice-null-string' => 'Et ass net méiglech näischt derbäizesetzen.
Näischt derbäigesat',
	'centralnotice-confirm-delete' => 'Sidd Dir sécher datt Dir dës Säit läsche wëllt?
Dës Aktioun kann net réckgängeg gemaach ginn.',
	'centralnotice-no-notices-exist' => 'Et gëtt keng Matdeelung.
Setzt eng hei ënnendrënner bäi.',
	'centralnotice-no-templates-translate' => "Et gëtt keng Schablounen fir déi Iwwersetzungen z'ännere sinn",
	'centralnotice-number-uses' => 'gëtt benotzt',
	'centralnotice-edit-template' => 'Schabloun änneren',
	'centralnotice-message' => 'Message',
	'centralnotice-message-not-set' => 'Message net gepäichert',
	'centralnotice-clone' => 'Eng Kopie maachen',
	'centralnotice-clone-notice' => 'Eng Kopie vun der Schabloun maachen',
	'centralnotice-preview-all-template-translations' => 'All disponibel Iwwersetzunge vun der Schabloun weisen ouni ofzespäicheren',
	'right-centralnotice-admin' => 'Zentralmatdeelunge geréieren',
	'right-centralnotice-translate' => 'Zentralmatdeelungen iwwersetzen',
	'action-centralnotice-admin' => 'Zentralmatdeelungen ze geréieren',
	'action-centralnotice-translate' => "Zentralmatdeelungen z'iwwersetzen",
	'centralnotice-preferred' => 'Am léiwsten',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'centralnotice-day' => 'Dia',
	'centralnotice-year' => 'Anio',
	'centralnotice-hours' => 'Ora',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'centralnotice' => 'Beheer centrale sitemitdeiling',
	'noticetemplate' => 'Sjabloon centrale citemitdeiling',
	'centralnotice-desc' => "Deit 'n centrale sitemededeling bie",
	'centralnotice-summary' => 'Mit dees moduul kinne centraal ingestelde sitemitdeilinge bewirk waere.
De module kin ouch gebroek waere om sitemitdeilinge bie te doon of eweg te sjaffe.',
	'centralnotice-query' => 'Hujige sitemitdeilinge verangere',
	'centralnotice-notice-name' => 'Naam mitdeiling',
	'centralnotice-end-date' => 'Einddatum',
	'centralnotice-enabled' => 'Aktief',
	'centralnotice-modify' => 'Opslaon',
	'centralnotice-preview' => 'Betrachte',
	'centralnotice-add-new' => 'Nuuj centrale sitemitdeiling biedoon',
	'centralnotice-remove' => 'Wis',
	'centralnotice-translate-heading' => 'Vertaling veur $1',
	'centralnotice-manage' => 'Centrale sitemitdeiling behere',
	'centralnotice-add' => 'Biedoon',
	'centralnotice-add-notice' => 'Sitemitdeiling biedoon',
	'centralnotice-add-template' => 'Sjabloon biedoon',
	'centralnotice-show-notices' => 'Sitemitdeilinge waergaeve',
	'centralnotice-list-templates' => 'Sjablone waergaeve',
	'centralnotice-translations' => 'Euverzèttinge',
	'centralnotice-translate-to' => 'Euverzètte nao',
	'centralnotice-translate' => 'Euverzètte',
	'centralnotice-english' => 'Ingels',
	'centralnotice-template-name' => 'Sjabloonnaam',
	'centralnotice-templates' => 'Sjablone',
	'centralnotice-weight' => 'Gewich',
	'centralnotice-locked' => 'Aafgesjlaote',
	'centralnotice-notices' => 'Sitemitdeilinge',
	'centralnotice-notice-exists' => 'De sitemitdeiling besjteit al.
Deze weurt neet biegedoon.',
	'centralnotice-template-exists' => "'t Sjabloon besjteit al.
Dit weurt neet biegedoon.",
	'centralnotice-notice-doesnt-exist' => 'De sitemitdeiling besjteit neet.
Niks weurt eweggesjaf.',
	'centralnotice-template-still-bound' => "'t Sjabloon is nog neet gekoppeld aan 'n sitemitdeiling.
't Weurt neet eweggesjaf.",
	'centralnotice-template-body' => 'Sjablooninhoud:',
	'centralnotice-day' => 'Daag',
	'centralnotice-year' => 'Jaor',
	'centralnotice-month' => 'Maondj',
	'centralnotice-hours' => 'Oer',
	'centralnotice-min' => 'Menuut',
	'centralnotice-project-lang' => 'Projektaal',
	'centralnotice-project-name' => 'Projeknaam',
	'centralnotice-start-date' => 'Sjtartdatum',
	'centralnotice-start-time' => 'Sjtarttied (UTC)',
	'centralnotice-assigned-templates' => 'Toegeweze sjablone',
	'centralnotice-no-templates' => "Gein sjablone gevónje.
Doog 'rs bie!",
	'centralnotice-no-templates-assigned' => "D'r zeen gein sjablone toegeweze aan de sitemitdeiling.
Doog 'rs bie!",
	'centralnotice-available-templates' => 'Besjikbare sjablone',
	'centralnotice-template-already-exists' => "'t Sjabloon is al gekoppeld aan 'n campagne.
't Weurt neet biegedoon.",
	'centralnotice-preview-template' => 'Veursjouw sjabloon',
	'centralnotice-start-hour' => 'Sjtarttied',
	'centralnotice-change-lang' => 'Euver te zètte taal verangere',
	'centralnotice-weights' => 'Gewichte',
	'centralnotice-notice-is-locked' => 'De sitenotice is toe.
Deze wörd neet gewis',
	'centralnotice-overlap' => "De sitemitdeiling euverlap mit 'n anger sitemitdeiling.
Deze weurt neet biegedoon",
	'centralnotice-invalid-date-range' => "Ongeljige datumreeks.
D'r weurt niks biegewirk.",
	'centralnotice-null-string' => "De kins gein laeg teksveld biedoon.
D'r weurt niks biegedoon",
	'centralnotice-confirm-delete' => 'Wèts doe zeker dats doe dit item wils ewegsjaffe?
Dees hanjeling is neet trök te drieje.',
	'centralnotice-no-notices-exist' => "D'r zeen gein sitemitdeilinge.
De kins hiejónger ein biedoon.",
	'centralnotice-no-templates-translate' => "D'r zeen gein sjablone woeveur euverzèttinge gemaak kinne waere",
	'centralnotice-number-uses' => 'Gebroeke',
	'centralnotice-edit-template' => 'Sjabloon bewirke',
	'centralnotice-message' => 'Berich',
	'centralnotice-message-not-set' => "'t Berich is neet ingesjtèld",
	'centralnotice-clone' => 'Kopiëre',
	'centralnotice-clone-notice' => "'n Kopie van 't sjabloon make",
	'centralnotice-preview-all-template-translations' => "Alle besjikbare euverzèttinge van 't sjabloon betrachte",
	'right-centralnotice-admin' => 'Centrale sitemitdeilinge behere',
	'right-centralnotice-translate' => 'Centrale sitenotices vertale',
	'action-centralnotice-admin' => 'beheer centrale sitemitdeilinge',
	'action-centralnotice-translate' => 'centrale sitemitdeilinge euverzètte',
	'centralnotice-preferred' => 'Prifferensies',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'centralnotice-day' => 'Diena',
	'centralnotice-year' => 'Metai',
	'centralnotice-month' => 'Mėnuo',
	'centralnotice-hours' => 'Valanda',
	'centralnotice-min' => 'Minutė',
	'centralnotice-project-lang' => 'Projekto kalba',
	'centralnotice-project-name' => 'Projekto pavadinimas',
	'centralnotice-start-date' => 'Pradžios data',
	'centralnotice-start-time' => 'Pradžios laikas (UTC)',
	'centralnotice-no-templates' => 'Nerasta šablonų.
Pridėkite!',
	'centralnotice-available-templates' => 'Galimi šablonai',
	'centralnotice-preview-template' => 'Peržiūrėti šabloną',
	'centralnotice-start-hour' => 'Pradžios laikas',
	'centralnotice-edit-template' => 'Redaguoti šabloną',
	'centralnotice-message' => 'Pranešimas',
	'centralnotice-message-not-set' => 'Pranešimas nenustatytas',
	'centralnotice-clone' => 'Klonuoti',
	'centralnotice-clone-notice' => 'Sukurti šablono kopiją',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'centralnotice' => "Fandrindàn'ny toerana fampandrenesana",
	'noticetemplate' => "Endrin'ny toerana fampandrenesana",
	'centralnotice-desc' => "Manampy toerana fampandrenesana amin'ilay tranonkala",
	'centralnotice-query' => 'Ovay ny fampandrenesana misy ankehitriny',
	'centralnotice-notice-name' => "Anaran'ilay fampandrenesana",
	'centralnotice-end-date' => 'Daty fijanonana',
	'centralnotice-enabled' => 'Mande',
	'centralnotice-modify' => 'Alefaso',
	'centralnotice-preview' => 'Asehoy aloha',
	'centralnotice-remove' => 'Esorina',
	'centralnotice-translate-heading' => 'Dika ny fampandrenesana « $1 »',
	'centralnotice-manage' => 'Hikojakoja ny toerana fampandrenesana',
	'centralnotice-add' => 'Hanampy',
	'centralnotice-add-notice' => 'Hanampy hafatra',
	'centralnotice-add-template' => 'Hanampy endrika',
	'centralnotice-show-notices' => 'Ampiseho ny hafatra',
	'centralnotice-list-templates' => 'Ataovy lisitra ny endrika',
	'centralnotice-translations' => 'Dikan-teny',
	'centralnotice-translate-to' => "Dikao amin'ny",
	'centralnotice-translate' => 'Dikao',
	'centralnotice-english' => 'Anglisy',
	'centralnotice-template-name' => "Anaran'ilay endrika",
	'centralnotice-templates' => 'Endrika',
	'centralnotice-weight' => 'Lanja',
	'centralnotice-locked' => 'Voaaro/voasakana',
	'centralnotice-notices' => 'Fampandrenesana/Hafatra',
	'centralnotice-notice-exists' => 'Efa misy io hafatra fampandrenesana io.
Tsy nampiana ilay izy',
	'centralnotice-day' => 'Andro',
	'centralnotice-year' => 'Taona',
	'centralnotice-month' => 'Volana',
	'centralnotice-hours' => 'Ora',
	'centralnotice-min' => 'Minìtra',
	'centralnotice-project-lang' => "Fiteny ampiasain'ilay tetikasa",
	'centralnotice-project-name' => "anaran'ilay tetikasa",
	'centralnotice-start-date' => 'Daty fanombohany',
	'centralnotice-start-time' => 'Ora fanombohany (UTC)',
	'centralnotice-assigned-templates' => 'Endrika ampiasainy',
	'centralnotice-no-templates' => 'Tsy nisy endrika hita.
Ampio!',
	'centralnotice-no-templates-assigned' => "Tsy misy endrika ampiasaina hoan'ilay hafatra.
Ampio!",
	'centralnotice-available-templates' => 'Endrika afaka ampiasaina',
	'centralnotice-preview-template' => 'Asehoy aloha io endrika',
	'centralnotice-start-hour' => 'Ora fanombohany',
	'centralnotice-change-lang' => "Ampio ny fiteny miasa amin'ny fandikàna-teny",
	'centralnotice-weights' => 'Lanja',
	'centralnotice-notice-is-locked' => 'Voaaro ilay hafatra.
Tsy nifafàna ilay izy',
	'centralnotice-number-uses' => 'Fampiasàna',
	'centralnotice-edit-template' => 'Ovay ny endrika',
	'centralnotice-message' => 'Hafatra',
	'centralnotice-clone' => 'Avereno dikao',
	'centralnotice-clone-notice' => "Angala-tahaka n'ilay endrika",
	'right-centralnotice-translate' => 'dikao teny ny hafatra',
	'action-centralnotice-admin' => "mikojakoja n'io hafatra io",
	'action-centralnotice-translate' => 'dikao teny ny fampandrenesana',
	'centralnotice-preferred' => 'Ny tiako/ny tianao/Ny tiny',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'centralnotice' => 'Администратор на централни известувања',
	'noticetemplate' => 'Шаблон за централни известувања',
	'centralnotice-desc' => 'Централизирано известување',
	'centralnotice-summary' => 'Овој модул ви овозможува да ги уредувате вашите моментално поставени централни известувања.
Може да се користи и за додавање или отстранување на стари известувања.',
	'centralnotice-query' => 'Измени моментални известувања',
	'centralnotice-notice-name' => 'Назив на известувањето',
	'centralnotice-end-date' => 'Истекува',
	'centralnotice-enabled' => 'Овозможено',
	'centralnotice-modify' => 'Испрати',
	'centralnotice-preview' => 'Преглед',
	'centralnotice-add-new' => 'Додај ново централно известување',
	'centralnotice-remove' => 'Тргни',
	'centralnotice-translate-heading' => 'Превод на $1',
	'centralnotice-manage' => 'Раководење со централното известување',
	'centralnotice-add' => 'Додај',
	'centralnotice-add-notice' => 'Додај известување',
	'centralnotice-add-template' => 'Додај шаблон',
	'centralnotice-show-notices' => 'Прикажи известувања',
	'centralnotice-list-templates' => 'Наведи шаблони',
	'centralnotice-translations' => 'Преводи',
	'centralnotice-translate-to' => 'Преведи на',
	'centralnotice-translate' => 'Преведи',
	'centralnotice-english' => 'англиски',
	'centralnotice-template-name' => 'Назив на шаблонот',
	'centralnotice-templates' => 'Шаблони',
	'centralnotice-weight' => 'Тежина',
	'centralnotice-locked' => 'Заклучено',
	'centralnotice-notices' => 'Известувања',
	'centralnotice-notice-exists' => 'Известувањето веќе постои.
Не е додадено',
	'centralnotice-template-exists' => 'Шаблонот веќе постои.
Не е додаден',
	'centralnotice-notice-doesnt-exist' => 'Известувањето не постои.
Нема ништо за бришење',
	'centralnotice-template-still-bound' => 'Шаблонот сè уште е врзан за известување.
Нема да биде отстранет.',
	'centralnotice-template-body' => 'Тело на шаблонот:',
	'centralnotice-day' => 'Ден',
	'centralnotice-year' => 'Година',
	'centralnotice-month' => 'Месец',
	'centralnotice-hours' => 'Час',
	'centralnotice-min' => 'Минута',
	'centralnotice-project-lang' => 'Јазик на проект',
	'centralnotice-project-name' => 'Име на проект',
	'centralnotice-start-date' => 'Почетен датум',
	'centralnotice-start-time' => 'Почетен датум (UTC)',
	'centralnotice-assigned-templates' => 'Придружени шаблони',
	'centralnotice-no-templates' => 'Нема шаблони.
Додај некој!',
	'centralnotice-no-templates-assigned' => 'Нема шаблони назначени за известување.
Додајте некои!',
	'centralnotice-available-templates' => 'Шаблони на располагање',
	'centralnotice-template-already-exists' => 'Шаблонот е веќе врзан за кампањата.
Нема да биде додаден',
	'centralnotice-preview-template' => 'Преглед на шаблонот',
	'centralnotice-start-hour' => 'Започнува',
	'centralnotice-change-lang' => 'Смени јазик на превод',
	'centralnotice-weights' => 'Тегови',
	'centralnotice-notice-is-locked' => 'Известувањето е заклучено.
Нема да биде отстрането',
	'centralnotice-overlap' => 'Известувањето временски се преклопува со друго известување.
Нема да биде додадено',
	'centralnotice-invalid-date-range' => 'Погрешен временски опсег.
Не се обновува',
	'centralnotice-null-string' => 'Не можете да додадете нулта низа.
Нема да биде додадено',
	'centralnotice-confirm-delete' => 'Дали сте сигурни дека сакате да ја избришење оваа ставка?
Ова ќе биде неповратно.',
	'centralnotice-no-notices-exist' => 'Нема никакви известувања.
Додајте известување подолу.',
	'centralnotice-no-templates-translate' => 'Нема шаблони за кои можете да уредите преведувања',
	'centralnotice-number-uses' => 'Користи',
	'centralnotice-edit-template' => 'Уреди шаблон',
	'centralnotice-message' => 'Порака',
	'centralnotice-message-not-set' => 'Порката не е поставена',
	'centralnotice-clone' => 'Клонирај',
	'centralnotice-clone-notice' => 'Создај копија на шаблонот',
	'centralnotice-preview-all-template-translations' => 'Преглед на сите расположиви преводи на шаблонот',
	'right-centralnotice-admin' => 'Раководење со централни известувања',
	'right-centralnotice-translate' => 'Преведување на централни известувања',
	'action-centralnotice-admin' => 'раководење со централни известувања',
	'action-centralnotice-translate' => 'преведување на цетрални известувања',
	'centralnotice-preferred' => 'Претпочитано',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'centralnotice' => 'കേന്ദ്രീകൃത അറിയിപ്പ് കാര്യനിർവാഹകൻ',
	'noticetemplate' => 'കേന്ദ്രീകൃത അറിയിപ്പ് ഫലകം',
	'centralnotice-desc' => 'കേന്ദീകൃത സൈറ്റ്നോട്ടീസ് ചേര്‍ക്കുന്നു',
	'centralnotice-summary' => 'തയ്യാറാക്കപ്പെട്ട കേന്ദ്രീകൃത അറിയിപ്പുകൾ തിരുത്താൻ ഈ ഘടകം താങ്കളെ പ്രാപ്തമാക്കുന്നു.
പഴയ അറിയിപ്പുകൾ കൂട്ടിച്ചേർക്കാനോ നീക്കം ചെയ്യാനോ വേണ്ടിയും ഇതുപയോഗിക്കാവുന്നതാണ്.',
	'centralnotice-query' => 'ഇപ്പോഴുള്ള അറിയിപ്പുകളിൽ മാറ്റം വരുത്തുക',
	'centralnotice-notice-name' => 'അറിയിപ്പിന്റെ പേര്',
	'centralnotice-end-date' => 'അവസാനിക്കുന്ന തീയ്യതി',
	'centralnotice-enabled' => 'സജ്ജമാക്കിയിരിക്കുന്നു',
	'centralnotice-modify' => 'സമർപ്പിക്കുക',
	'centralnotice-preview' => 'എങ്ങനെയുണ്ടെന്നു കാണുക',
	'centralnotice-add-new' => 'പുതിയൊരു കേന്ദ്രീകൃത അറിയിപ്പ് ചേർക്കുക',
	'centralnotice-remove' => 'നീക്കംചെയ്യുക',
	'centralnotice-translate-heading' => '$1 എന്നതിനുള്ള തർജ്ജമ',
	'centralnotice-manage' => 'കേന്ദ്രീകൃത അറിയിപ്പ് കൈകാര്യം ചെയ്യുക',
	'centralnotice-add' => 'കൂട്ടിച്ചേർക്കുക',
	'centralnotice-add-notice' => 'ഒരു അറിയിപ്പ് കൂട്ടിച്ചേർക്കുക',
	'centralnotice-add-template' => 'ഫലകം കൂട്ടിച്ചേർക്കുക',
	'centralnotice-show-notices' => 'അറിയിപ്പുകൾ പ്രദർശിപ്പിക്കുക',
	'centralnotice-list-templates' => 'ഫലകങ്ങൾ പട്ടികവത്കരിക്കുക',
	'centralnotice-translations' => 'തർജ്ജമകൾ',
	'centralnotice-translate-to' => 'ഇതിലേയ്ക്ക് തർജ്ജമ ചെയ്യുക',
	'centralnotice-translate' => 'തർജ്ജമ ചെയ്യുക',
	'centralnotice-english' => 'ഇംഗ്ലീഷ്',
	'centralnotice-template-name' => 'ഫലകത്തിന്റെ പേര്',
	'centralnotice-templates' => 'ഫലകങ്ങൾ',
	'centralnotice-weight' => 'ഘനം',
	'centralnotice-locked' => 'പൂട്ടിയിരിക്കുന്നു',
	'centralnotice-notices' => 'അറിയിപ്പുകൾ',
	'centralnotice-notice-exists' => 'അറിയിപ്പ് ഇപ്പോൾ തന്നെ ഉണ്ട്.
കൂട്ടിച്ചേർക്കുന്നില്ല',
	'centralnotice-template-exists' => 'ഫലകം നിലവിലുണ്ട്.
കൂട്ടിച്ചേർക്കുന്നില്ല',
	'centralnotice-notice-doesnt-exist' => 'അറിയിപ്പ് നിലനിൽപ്പില്ല.
നീക്കംചെയ്യാനൊന്നുമില്ല',
	'centralnotice-template-still-bound' => 'ഫലകം ഇപ്പോഴും ഒരു അറിയിപ്പുമായി ബന്ധപ്പെട്ടിരിക്കുന്നു.
നീക്കം ചെയ്യുന്നില്ല.',
	'centralnotice-template-body' => 'ഫലകത്തിന്റെ ഉള്ളടക്കം:',
	'centralnotice-day' => 'ദിവസം',
	'centralnotice-year' => 'വർഷം',
	'centralnotice-month' => 'മാസം',
	'centralnotice-hours' => 'മണിക്കൂർ',
	'centralnotice-min' => 'മിനിട്ട്',
	'centralnotice-project-lang' => 'പദ്ധതിയുടെ ഭാഷ',
	'centralnotice-project-name' => 'പദ്ധതിയുടെ പേര്',
	'centralnotice-start-date' => 'ആരംഭിക്കുന്ന തീയതി',
	'centralnotice-start-time' => 'ആരംഭിക്കുന്ന സമയം (UTC)',
	'centralnotice-assigned-templates' => 'ചുമതലപ്പെടുത്തിയിരിക്കുന്ന ഫലകങ്ങൾ',
	'centralnotice-no-templates' => 'ഫലകങ്ങൾ ഒന്നും കണ്ടെത്താനായില്ല.
ഏതാനം ചേർക്കുക!',
	'centralnotice-no-templates-assigned' => 'അറിയിപ്പിനായി ഫലകങ്ങൾ ഒന്നും മാറ്റിവെച്ചിട്ടില്ല.
ഏതാനം ചേർക്കുക!',
	'centralnotice-available-templates' => 'ലഭ്യമായ ഫലകങ്ങൾ',
	'centralnotice-template-already-exists' => 'ഫലകം പ്രചരണപ്രവർത്തനവുമായി ബന്ധിച്ചിരിക്കുന്നു.
കൂട്ടിച്ചേർക്കുന്നില്ല',
	'centralnotice-preview-template' => 'ഫലകത്തിന്റെ പ്രിവ്യൂ കാണുക',
	'centralnotice-start-hour' => 'ആരംഭിക്കുന്ന സമയം',
	'centralnotice-change-lang' => 'തർജ്ജമയുടെ ഭാഷ മാറ്റുക',
	'centralnotice-weights' => 'ഘനങ്ങൾ',
	'centralnotice-notice-is-locked' => 'അറിയിപ്പ് പൂട്ടപ്പെട്ടിരിക്കുന്നു.
നീക്കം ചെയ്യുന്നില്ല',
	'centralnotice-overlap' => 'മറ്റൊരു അറിയിപ്പിന്റെ സമയക്രമത്തെ ഈ അറിയിപ്പ് അതിലംഘിക്കുന്നു.
കൂട്ടിച്ചേർക്കുന്നില്ല',
	'centralnotice-invalid-date-range' => 'തീയതിയുടെ പരിധി അസാധുവാണ്.
പുതുക്കുന്നില്ല.',
	'centralnotice-null-string' => 'ശൂന്യമായ പദം ചേർക്കാൻ കഴിയില്ല.
കൂട്ടിച്ചേർക്കുന്നില്ല',
	'centralnotice-confirm-delete' => 'ഇത് മായ്ച്ചുകളയണമെന്നതിനു താങ്കൾക്കുറപ്പുണ്ടോ?
ഈ പ്രവൃത്തി തിരികെ ചെയ്യാവുന്നതല്ല.',
	'centralnotice-no-notices-exist' => 'അറിയിപ്പുകൾ നിലനിൽപ്പില്ല.
താഴെ ഒരെണ്ണം കൂട്ടിച്ചേർക്കുക',
	'centralnotice-no-templates-translate' => 'ഇതിന്റെ തർജ്ജമകൾ തിരുത്താനായി ഒരു ഫലകവും ഇപ്പോഴില്ല',
	'centralnotice-number-uses' => 'ഉപയോഗങ്ങൾ',
	'centralnotice-edit-template' => 'ഫലകം തിരുത്തുക',
	'centralnotice-message' => 'സന്ദേശം',
	'centralnotice-message-not-set' => 'സന്ദേശം നിശ്ചിതപ്പെടുത്തിയില്ല.',
	'centralnotice-clone' => 'സമപ്പകർപ്പ്',
	'centralnotice-clone-notice' => 'ഫലകത്തിന്റെ പകർപ്പ് സൃഷ്ടിക്കുക',
	'centralnotice-preview-all-template-translations' => 'ഫലകത്തിന്റെ ലഭ്യമായ എല്ലാ തർജ്ജമകളുടേയും പ്രിവ്യൂ കാണുക',
	'right-centralnotice-admin' => 'കേന്ദ്രീകൃത അറിയിപ്പുകൾ കൈകാര്യം ചെയ്യുക',
	'right-centralnotice-translate' => 'കേന്ദ്രീകൃത അറിയിപ്പുകൾ തർജ്ജമ ചെയ്യുക',
	'action-centralnotice-admin' => 'കേന്ദ്രീകൃത അറിയിപ്പുകൾ കൈകാര്യം ചെയ്യുക',
	'action-centralnotice-translate' => 'കേന്ദ്രീകൃത അറിയിപ്പുകൾ തർജ്ജമ ചെയ്യുക',
	'centralnotice-preferred' => 'അഭിലഷണീയമായുള്ളത്',
);

/** Marathi (मराठी)
 * @author Mahitgar
 */
$messages['mr'] = array(
	'centralnotice-desc' => 'संकेतस्थळाचा मध्यवर्ती सूचना फलक',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Izzudin
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
	'centralnotice-weight' => 'Berat',
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
	'centralnotice-assigned-templates' => 'Templat ditugasi',
	'centralnotice-no-templates' => 'Tiada templat. Sila cipta templat baru.',
	'centralnotice-no-templates-assigned' => 'Tiada templat untuk pemberitahuan. Tambah templat baru!',
	'centralnotice-available-templates' => 'Templat yang ada',
	'centralnotice-template-already-exists' => 'Templat telah pun terikat dengan kempen, oleh itu tidak ditambah.',
	'centralnotice-preview-template' => 'Pralihat templat',
	'centralnotice-start-hour' => 'Waktu mula',
	'centralnotice-change-lang' => 'Tukar bahasa terjemahan',
	'centralnotice-weights' => 'Berat',
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
	'centralnotice-preferred' => 'Dipilih',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'centralnotice-add-template' => 'Żid mudell',
	'centralnotice-template-name' => 'Isem tal-mudell',
	'centralnotice-number-uses' => 'Użi',
	'centralnotice-message' => 'Messaġġ',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'centralnotice-add' => 'Поладомс',
	'centralnotice-add-template' => 'Поладомс лопа парцун',
	'centralnotice-template-name' => 'Лопа парцунонь лем',
	'centralnotice-templates' => 'Лопа парцунт',
	'centralnotice-weight' => 'Сталмо',
	'centralnotice-template-body' => 'Лопа парцунонть рунгозо:',
	'centralnotice-day' => 'Чи',
	'centralnotice-year' => 'Ие',
	'centralnotice-month' => 'Ков',
	'centralnotice-hours' => 'Цяс',
	'centralnotice-min' => 'Минут',
	'centralnotice-available-templates' => 'Кедь маласо лопа парцунт',
	'centralnotice-edit-template' => 'Лопа парцунонть витнеме-петнеме',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'centralnotice' => 'Sitenotice verwalten',
	'noticetemplate' => 'Vörlaag för Sitenotice',
	'centralnotice-desc' => 'Föögt en zentrale Naricht för de Websteed to',
	'centralnotice-summary' => 'Dit Modul verlöövt di dat Ännern vun de Instellungen för Sitenotice.
Dat kann ok bruukt warrn, üm Sitenotices totofögen oder ruttonehmen.',
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
	'centralnotice-desc' => 'Voeg een centrale mededeling an de webstee toe',
	'centralnotice-translate-heading' => 'Vertaling veur $1',
	'centralnotice-add' => 'Toevoegen',
	'centralnotice-add-template' => 'Mal toevoegen',
	'centralnotice-translations' => 'Vertalingen',
	'centralnotice-change-lang' => 'Taal dee-j vertalen willen wiezigen',
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

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'centralnotice-add' => 'Dezu duh',
	'centralnotice-list-templates' => 'Lischt vun Moddle',
	'centralnotice-translations' => 'Iwwersetzinge',
	'centralnotice-translate-to' => 'Iwwersetze in',
	'centralnotice-translate' => 'Iwwersetze',
	'centralnotice-english' => 'Englisch',
	'centralnotice-templates' => 'Moddle',
	'centralnotice-day' => 'Daag',
	'centralnotice-year' => 'Yaahr',
	'centralnotice-month' => 'Munet',
	'centralnotice-hours' => 'Schtund',
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

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'centralnotice' => 'Aministrassion sentral ëd le neuve',
	'noticetemplate' => 'Stamp dle neuve sentraj',
	'centralnotice-desc' => 'A gionta na Neuva Sentral dël sit',
	'centralnotice-summary' => 'Sto mòdol-sì a-j përmët ëd modifiché soe Neuve Sentraj ampostà al moment.
A peul ëdcò esse dovrà për gionté o gavé notissie veje.',
	'centralnotice-query' => 'Modìfica le neuve corente',
	'centralnotice-notice-name' => 'Nòm ëd la neuva',
	'centralnotice-end-date' => 'Data fin',
	'centralnotice-enabled' => 'Abilità',
	'centralnotice-modify' => 'Spediss',
	'centralnotice-preview' => 'Previsualisassion',
	'centralnotice-add-new' => 'Gionta na Neuva Sentral neuva',
	'centralnotice-remove' => 'Gava',
	'centralnotice-translate-heading' => 'Tradussion për $1',
	'centralnotice-manage' => 'Gestiss neuva sentral',
	'centralnotice-add' => 'Gionta',
	'centralnotice-add-notice' => 'Gionta na neuva',
	'centralnotice-add-template' => 'Gionta në stamp',
	'centralnotice-show-notices' => 'Mostra neuva',
	'centralnotice-list-templates' => 'Lista stamp',
	'centralnotice-translations' => 'Tradussion',
	'centralnotice-translate-to' => 'Volté an',
	'centralnotice-translate' => 'Volté',
	'centralnotice-english' => 'Anglèis',
	'centralnotice-template-name' => 'Nòm ëd lë stamp',
	'centralnotice-templates' => 'Stamp',
	'centralnotice-weight' => 'Pèis',
	'centralnotice-locked' => 'Blocà',
	'centralnotice-notices' => 'Neuve',
	'centralnotice-notice-exists' => 'La neuva a esist già.
Pa giontà',
	'centralnotice-template-exists' => 'Lë stamp a esist già.
Pa giontà',
	'centralnotice-notice-doesnt-exist' => 'La neuva a esist pa.
A-i é gnente da gavé',
	'centralnotice-template-still-bound' => "Lë stamp a l'é ancó gropà a na neuva.
Pa gavà.",
	'centralnotice-template-body' => 'Còrp ëd lë stamp:',
	'centralnotice-day' => 'Di',
	'centralnotice-year' => 'Ann',
	'centralnotice-month' => 'Mèis',
	'centralnotice-hours' => 'Ora',
	'centralnotice-min' => 'Minuta',
	'centralnotice-project-lang' => 'Lenga dël proget',
	'centralnotice-project-name' => 'Nòm dël proget',
	'centralnotice-start-date' => "Data d'inissi",
	'centralnotice-start-time' => "Ora d'inissi (UTC)",
	'centralnotice-assigned-templates' => 'Stamp assignà',
	'centralnotice-no-templates' => 'Pa gnun stamp trovà.
Giontne un!',
	'centralnotice-no-templates-assigned' => 'Pa gnun stamp assignà a la neuva.
Giontne un!',
	'centralnotice-available-templates' => 'Stamp disponìbij',
	'centralnotice-template-already-exists' => "Lë stamp a l'é già gropà a na campagna.
Pa giontà",
	'centralnotice-preview-template' => 'Previsualisassion stamp',
	'centralnotice-start-hour' => "Ora d'inissi",
	'centralnotice-change-lang' => 'Cangé lenga ëd tradussion',
	'centralnotice-weights' => 'Pèis',
	'centralnotice-notice-is-locked' => 'Neuva blocà.
Pa gavà',
	'centralnotice-overlap' => "La neuva a coata la durà ëd n'àutra neuva.
Pa giontà",
	'centralnotice-invalid-date-range' => 'Antërval ëd date pa bon.
Pa modificà',
	'centralnotice-null-string' => 'A peul pa gionté na stringa veuida.
Pa giontà',
	'centralnotice-confirm-delete' => "É-lo sigur ëd vorèj scancelé sto element-sì?
St'assion a podrà pa esse arcuperà.",
	'centralnotice-no-notices-exist' => "A-i son gnun-e neuve.
Ch'a na gionta un-a sì-sota.",
	'centralnotice-no-templates-translate' => 'A-i é gnun ëstamp dont modifiché la tradussion',
	'centralnotice-number-uses' => 'Usagi',
	'centralnotice-edit-template' => 'Modìfica stamp',
	'centralnotice-message' => 'Mëssagi',
	'centralnotice-message-not-set' => 'Mëssagi pa ampostà',
	'centralnotice-clone' => 'Clon-a',
	'centralnotice-clone-notice' => 'Crea na còpia ëd lë stamp',
	'centralnotice-preview-all-template-translations' => 'Previsualisa tute le tradussion disponìbij ëd lë stamp',
	'right-centralnotice-admin' => 'Gestì le neuve sentraj',
	'right-centralnotice-translate' => 'Volté le neuve sentraj',
	'action-centralnotice-admin' => 'gestì le neuve sentraj',
	'action-centralnotice-translate' => 'volté le neuve sentraj',
	'centralnotice-preferred' => 'Mè gust',
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
	'centralnotice-end-date' => 'د پای نېټه',
	'centralnotice-preview' => 'مخکتنه',
	'centralnotice-translate-heading' => 'د $1 لپاره ژباړه',
	'centralnotice-add' => 'ورګډول',
	'centralnotice-add-template' => 'يوه کينډۍ ورګډول',
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
	'centralnotice-available-templates' => 'شته کينډۍ',
	'centralnotice-start-hour' => 'د پيل وخت',
	'centralnotice-change-lang' => 'د ژباړې ژبه بدلول',
	'centralnotice-message' => 'پيغام',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
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
	'centralnotice-preview' => 'Antever',
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
	'centralnotice-preview-template' => 'Antever modelo',
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
	'centralnotice-preview-all-template-translations' => 'Antever todas as traduções disponíveis do modelo',
	'right-centralnotice-admin' => 'Gerir avisos centralizados',
	'right-centralnotice-translate' => 'Traduzir avisos centralizados',
	'action-centralnotice-admin' => 'gerir avisos centralizados',
	'action-centralnotice-translate' => 'traduzir avisos centralizados',
	'centralnotice-preferred' => 'Preferido',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'centralnotice' => 'Administração de aviso centralizado',
	'noticetemplate' => 'Modelo de aviso do sítio',
	'centralnotice-desc' => 'Adiciona um aviso do sítio centralizado',
	'centralnotice-summary' => 'Este módulo permite-lhe editar os seus avisos centralizados atualmente configurados.
Pode também ser usado para adicionar ou remover avisos antigos.',
	'centralnotice-query' => 'Modificar avisos atuais',
	'centralnotice-notice-name' => 'Nome do aviso',
	'centralnotice-end-date' => 'Data de fim',
	'centralnotice-enabled' => 'Ativo',
	'centralnotice-modify' => 'Enviar',
	'centralnotice-preview' => 'Previsão',
	'centralnotice-add-new' => 'Adicionar um novo aviso centralizado',
	'centralnotice-remove' => 'Remover',
	'centralnotice-translate-heading' => 'Tradução de $1',
	'centralnotice-manage' => 'Gerenciar aviso centralizado',
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
	'centralnotice-project-lang' => 'Língua do projeto',
	'centralnotice-project-name' => 'Nome do projeto',
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
Não atualizado',
	'centralnotice-null-string' => 'Não é possível adicionar uma cadeia de caracteres nula.
Não adicionado',
	'centralnotice-confirm-delete' => 'Tem a certeza de que pretende eliminar este item?
Esta ação será irreversível.',
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
	'right-centralnotice-admin' => 'Gerenciar avisos centralizados',
	'right-centralnotice-translate' => 'Traduzir avisos centralizados',
	'action-centralnotice-admin' => 'gerenciar avisos centralizados',
	'action-centralnotice-translate' => 'traduzir avisos centralizados',
	'centralnotice-preferred' => 'Preferido',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'centralnotice' => 'Chawpi willay kamachiy',
	'noticetemplate' => 'Chawpi willay plantilla',
	'centralnotice-desc' => 'Tukuy ruraykamaykunapaq chawpi willayta yapan',
	'centralnotice-summary' => "Kay wakina tupuwanqa qampa kachkaq chawpi willayniykikunatam allinchayta atinki.
Paywanmi mawk'a willaykunatapas yapayta icha qichuyta atinki.",
	'centralnotice-query' => 'Kachkaq willaykunata hukchay',
	'centralnotice-notice-name' => 'Willaypa sutin',
	'centralnotice-end-date' => "Tukuna p'unchaw",
	'centralnotice-enabled' => 'Saqillasqa',
	'centralnotice-modify' => 'Kachay',
	'centralnotice-preview' => 'Ñawpaqta qhawallay',
	'centralnotice-add-new' => 'Musuq chawpi willayta yapay',
	'centralnotice-remove' => 'Qichuy',
	'centralnotice-translate-heading' => "$1-paq t'ikrasqa",
	'centralnotice-manage' => 'Chawpi willayta kamachiy',
	'centralnotice-add' => 'Yapay',
	'centralnotice-add-notice' => 'Willayta yapay',
	'centralnotice-add-template' => 'Plantillata yapay',
	'centralnotice-show-notices' => 'Willaykunata rikuchiy',
	'centralnotice-list-templates' => 'Plantillakunata sutisuyupi rikuchiy',
	'centralnotice-translations' => "T'ikrasqakuna",
	'centralnotice-translate-to' => "Kayman t'ikray:",
	'centralnotice-translate' => "T'ikray",
	'centralnotice-english' => 'Inlish simipi',
	'centralnotice-template-name' => 'Plantilla suti',
	'centralnotice-templates' => 'Plantillakuna',
	'centralnotice-weight' => 'Llasay',
	'centralnotice-locked' => "Llawiwan wichq'asqa",
	'centralnotice-notices' => 'Willaykuna',
	'centralnotice-notice-exists' => 'Willayqa kachkañam.
Manam yapasqachu',
	'centralnotice-template-exists' => 'Plantillaqa kachkañam.
Manam yapasqachu',
	'centralnotice-notice-doesnt-exist' => 'Willayqa manam kanchu.
Manam qichunallachu',
	'centralnotice-template-still-bound' => 'Plantillaqa willaymanraqmi watasqa.
Manam qichusqa kanqachu.',
	'centralnotice-template-body' => 'Plantilla kurku:',
	'centralnotice-day' => "P'unchaw",
	'centralnotice-year' => 'Wata',
	'centralnotice-month' => 'Killa',
	'centralnotice-hours' => 'Ura',
	'centralnotice-min' => 'Minutu',
	'centralnotice-project-lang' => 'Ruraykamaypa rimaynin',
	'centralnotice-project-name' => 'Ruraykamaypa sutin',
	'centralnotice-start-date' => "Qallarisqanpa p'unchawnin",
	'centralnotice-start-time' => 'Qallarisqanpa pachan (UTC)',
	'centralnotice-assigned-templates' => 'Haypusqa plantillakuna',
	'centralnotice-no-templates' => 'Manam tarisqachu plantillakuna.
Yapay!',
	'centralnotice-no-templates-assigned' => 'Manam kanchu willayman haypusqa plantillakuna.
Yapay!',
	'centralnotice-available-templates' => 'Aypanalla plantillakuna',
	'centralnotice-preview-template' => 'Plantillata ñawpaqta qhawallay',
	'centralnotice-start-hour' => 'Qallarisqanpa pachan',
	'centralnotice-change-lang' => "T'ikrana rimayta hukchay",
	'centralnotice-weights' => 'Llasaykuna',
	'centralnotice-notice-is-locked' => "Willayqa llawiwanmi wichq'asqa.
Manam qullusqa kanqachu",
	'centralnotice-overlap' => "Willayqa huk willaypa pachanwanmi mast'arinakunmi.
Manam yapasqa kanqachu",
	'centralnotice-invalid-date-range' => "P'unchawkunap mit'anqa manam allinchu.
Manam yapasqa kanqachu",
	'centralnotice-null-string' => "Manam atinichu ch'usaq link'uta yapayta.
Manam yapasqa kanqachu",
	'centralnotice-confirm-delete' => 'Allinta yachankichu, kayta qulluyta munaspayki?
Rurarqaspaykiqa, manam kutichiyta atinkichu.',
	'centralnotice-no-notices-exist' => 'Manam kanchu willaykuna.
Kay qatiqpi hukta yapay',
	'centralnotice-no-templates-translate' => "Manam kanchu plantillakuna, imapaqchus t'ikrasqa llamk'apunalla kanman",
	'centralnotice-number-uses' => "Llamk'achin",
	'centralnotice-edit-template' => "Plantillata llamk'apuy",
	'centralnotice-message' => 'Willay',
	'centralnotice-message-not-set' => 'Manam kanchu churasqa willay',
	'centralnotice-clone' => 'Iskayllachay',
	'centralnotice-clone-notice' => 'Plantillamanta iskaychasqanta kamariy',
	'centralnotice-preview-all-template-translations' => "Tukuy aypanalla plantillamanta t'ikrasqakunata ñawpaqta qhawallay",
	'right-centralnotice-admin' => 'Chawpi willaykunata kamachiy',
	'right-centralnotice-translate' => "Chawpi willaykunata t'ikray",
	'action-centralnotice-admin' => 'chawpi willaykunata kamachiy',
	'action-centralnotice-translate' => "chawpi willaykunata t'ikray",
	'centralnotice-preferred' => 'Astawan munakusqa',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'centralnotice-desc' => 'Adaugă un anunţ central sitului',
	'centralnotice-query' => 'Modifică anunţurile curente',
	'centralnotice-notice-name' => 'Numele anunţului',
	'centralnotice-end-date' => 'Dată de încheiere',
	'centralnotice-enabled' => 'Activat',
	'centralnotice-modify' => 'Trimite',
	'centralnotice-preview' => 'Previzualizare',
	'centralnotice-add-new' => 'Adaugă un anunţ central nou',
	'centralnotice-remove' => 'Şterge',
	'centralnotice-translate-heading' => 'Traducere pentru $1',
	'centralnotice-manage' => 'Gestionaţi anunţ central',
	'centralnotice-add' => 'Adaugă',
	'centralnotice-add-notice' => 'Adaugă un anunţ',
	'centralnotice-add-template' => 'Adaugă un format',
	'centralnotice-show-notices' => 'Arată anunţurile',
	'centralnotice-list-templates' => 'Lista de formate',
	'centralnotice-translations' => 'Traduceri',
	'centralnotice-translate-to' => 'Tradu în',
	'centralnotice-translate' => 'Tradu',
	'centralnotice-english' => 'engleză',
	'centralnotice-template-name' => 'Numele formatului',
	'centralnotice-templates' => 'Formate',
	'centralnotice-weight' => 'Greutate',
	'centralnotice-locked' => 'Blocat',
	'centralnotice-notices' => 'Notificări',
	'centralnotice-day' => 'Zi',
	'centralnotice-year' => 'An',
	'centralnotice-month' => 'Lună',
	'centralnotice-hours' => 'Oră',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Limba proiectului',
	'centralnotice-project-name' => 'Numele proiectului',
	'centralnotice-start-date' => 'Data de începere',
	'centralnotice-start-time' => 'Data de începere (UTC)',
	'centralnotice-available-templates' => 'Formate disponibile',
	'centralnotice-preview-template' => 'Previzualizare formate',
	'centralnotice-start-hour' => 'Ora de început',
	'centralnotice-change-lang' => 'Schimbă limba de traducere',
	'centralnotice-weights' => 'Greutăţi',
	'centralnotice-edit-template' => 'Modifică format',
	'centralnotice-message' => 'Mesaj',
	'centralnotice-clone' => 'Clonaţi',
	'centralnotice-clone-notice' => 'Creează o copie a formatului',
	'right-centralnotice-translate' => 'Traduce anunţurile centrale',
	'action-centralnotice-admin' => 'administraţi anunţurile centrale',
	'action-centralnotice-translate' => 'traduceţi anunţurile centrale',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'centralnotice-enabled' => 'Abbilitate',
	'centralnotice-preview' => 'Andeprime',
	'centralnotice-remove' => 'Live',
	'centralnotice-add' => 'Aggiunge',
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
	'centralnotice' => 'Кииннэммит биллэриилэри салайыы',
	'noticetemplate' => 'Кииннэммит биллэрии халыыба',
	'centralnotice-desc' => 'Саайт биллэриитин эбэр',
	'centralnotice-summary' => 'Бу муодул билигин үлэлиир кииннэммит биллэриилэргитин уларытарга туһаныллар.
Саҥа биллэриилэри эбэргэ, эргэ биллэриилэри соторго туһаныллыан эмиэ сөп.',
	'centralnotice-query' => 'Бу биллэриини уларытыы',
	'centralnotice-notice-name' => 'Биллэрии аата',
	'centralnotice-end-date' => 'Түмүктэнии күнэ-дьыла',
	'centralnotice-enabled' => 'Холбоммут/холбонно',
	'centralnotice-modify' => 'Ыытарга',
	'centralnotice-preview' => 'Ыытыах иннинэ көрүү',
	'centralnotice-add-new' => 'Саҥа кииннэммит биллэриини эбэргэ',
	'centralnotice-remove' => 'Сот',
	'centralnotice-translate-heading' => '$1 тылбааһа',
	'centralnotice-manage' => 'Кииннэммит биллэриилэри салайыы',
	'centralnotice-add' => 'Эбэргэ',
	'centralnotice-add-notice' => 'Биллэрии эбэргэ',
	'centralnotice-add-template' => 'Халыып эбэргэ',
	'centralnotice-show-notices' => 'Биллэриилэри көрдөр',
	'centralnotice-list-templates' => 'Халыыптар тиһиктэрэ',
	'centralnotice-translations' => 'Тылбаастар',
	'centralnotice-translate-to' => 'Манна тылбаас',
	'centralnotice-translate' => 'Тылбаас',
	'centralnotice-english' => 'Аҥылычаан',
	'centralnotice-template-name' => 'Халыып аата',
	'centralnotice-templates' => 'Халыыптар',
	'centralnotice-weight' => 'Кэтитэ',
	'centralnotice-locked' => 'Хааччахтаммыт/бобуллубут',
	'centralnotice-notices' => 'Биллэриилэр',
	'centralnotice-notice-exists' => 'Биллэрии баар эбит.
Кыайан эбиллибэт',
	'centralnotice-template-exists' => 'Халыып баар эбит.
Кыайан эбиллибэт',
	'centralnotice-notice-doesnt-exist' => 'Биллэрии суох эбит.
Сотуллар суох',
	'centralnotice-template-still-bound' => 'Халыып уруккутун курдук биллэриини кытта ситимнээх.
Кыайан сотуллубат.',
	'centralnotice-template-body' => 'Халыып бэйэтэ:',
	'centralnotice-day' => 'Күн (хонук)',
	'centralnotice-year' => 'Сыл',
	'centralnotice-month' => 'Ый',
	'centralnotice-hours' => 'Чаас',
	'centralnotice-min' => 'Мүнүүтэ',
	'centralnotice-project-lang' => 'Бырайыак тыла',
	'centralnotice-project-name' => 'Бырайыак аата',
	'centralnotice-start-date' => 'Саҕаламмыт ыйа-күнэ',
	'centralnotice-start-time' => 'Саҕаламмыт кэмэ (UTC)',
	'centralnotice-assigned-templates' => 'Олордуллубут халыыптар',
	'centralnotice-no-templates' => 'Халыыптар көстүбэтилэр.
Эп эрэ!',
	'centralnotice-no-templates-assigned' => 'Биллэриини кытта ситимнээх халыыптар суохтар.
Эп эрэ!',
	'centralnotice-available-templates' => 'Баар халыыптар',
	'centralnotice-template-already-exists' => 'Халыып ситимнээх.
Эбиллибэтэх',
	'centralnotice-preview-template' => 'Халыыбы хайдах буолуоҕун көрүү',
	'centralnotice-start-hour' => 'Саҕаламмыт кэмэ',
	'centralnotice-change-lang' => 'Тылбаас тылын уларытыы',
	'centralnotice-weights' => 'Ыйааһына',
	'centralnotice-notice-is-locked' => 'Биллэрии көмүскэллээх.
Сотуллубат',
	'centralnotice-overlap' => 'Биллэрии атын биллэриини кытта кэминэн быһа охсуһар.
Эбиллэр кыаҕа суох',
	'centralnotice-invalid-date-range' => 'Күнүн-дьылын болдьоҕо сыыһа.
Кыайан саҥардыллыбат',
	'centralnotice-null-string' => 'Кураанах устуруоканы эбэр табыллыбат.
Эбиллибэт',
	'centralnotice-confirm-delete' => 'Маны сотоору гынаҕын дуо?
Соттоххуна төннөрөр кыаҕыҥ суох буолуо.',
	'centralnotice-no-notices-exist' => 'Биллэриилэр суохтар.
Эбиэххэ сөп',
	'centralnotice-no-templates-translate' => 'Тылбаастыырга аналлаах биир да халыыып суох',
	'centralnotice-number-uses' => 'Туттуллаллар',
	'centralnotice-edit-template' => 'Халыыбы уларытыы',
	'centralnotice-message' => 'Сурук',
	'centralnotice-message-not-set' => 'Сурук туруоруллубатах',
	'centralnotice-clone' => 'Клоннааһын',
	'centralnotice-clone-notice' => 'Халыып куопуйатын оҥоруу',
	'centralnotice-preview-all-template-translations' => 'Халыып баар тылбаастарын барытын көрүү',
	'right-centralnotice-admin' => 'Кииннэмит биллэриилэри салайыы',
	'right-centralnotice-translate' => 'Кииннэммит биллэриилэри тылбаастааһын',
	'action-centralnotice-admin' => 'кииннэммит биллэриилэри салайыы',
	'action-centralnotice-translate' => 'кииннэммит биллэриилэри тылбаастааһын',
	'centralnotice-preferred' => 'Бэрт буолуо этэ',
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

/** Serbo-Croatian (Srpskohrvatski / Српскохрватски)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'centralnotice-modify' => 'Unesi',
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

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Millosh
 * @author Јованвб
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'centralnotice-desc' => 'Додаје централну напомену на сајт.',
	'centralnotice-query' => 'Измени тренутна обавештења',
	'centralnotice-notice-name' => 'Име обавештења',
	'centralnotice-end-date' => 'Завршни датум',
	'centralnotice-enabled' => 'Омогућено',
	'centralnotice-modify' => 'Пошаљи',
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
	'centralnotice-weight' => 'Тежина',
	'centralnotice-locked' => 'Закључано',
	'centralnotice-notices' => 'Обавештења',
	'centralnotice-notice-exists' => 'Напомена већ постоји.
Неће бити додата',
	'centralnotice-template-exists' => 'Шаблон већ постоји.
Неће бити додат',
	'centralnotice-notice-doesnt-exist' => 'Напомена не постоји.
Нема шта да се обрише',
	'centralnotice-template-still-bound' => 'Шаблон је још увек придружен напомени.
Неће бити обрисан.',
	'centralnotice-template-body' => 'Тело шаблона:',
	'centralnotice-day' => 'Дан',
	'centralnotice-year' => 'Година',
	'centralnotice-month' => 'Месец',
	'centralnotice-hours' => 'Сат',
	'centralnotice-min' => 'Минут',
	'centralnotice-project-lang' => 'Име пројекта',
	'centralnotice-project-name' => 'Име пројекта',
	'centralnotice-start-date' => 'Почетни датум',
	'centralnotice-start-time' => 'Почетно време (UTC)',
	'centralnotice-no-templates' => 'Шаблони нису проађен.
Додај неки!',
	'centralnotice-available-templates' => 'Расположиви шаблони',
	'centralnotice-preview-template' => 'Прикажи шаблон',
	'centralnotice-start-hour' => 'Почетно време',
	'centralnotice-change-lang' => 'Измени језик транслитерације',
	'centralnotice-weights' => 'Тежине',
	'centralnotice-notice-is-locked' => 'Напомена је закључана.
Није била обрисана',
	'centralnotice-invalid-date-range' => 'Неисправан опсег података.
Ажурирање није извршено',
	'centralnotice-null-string' => 'Није могуће додавање празног стринга.
Није додат',
	'centralnotice-confirm-delete' => 'Да ли сте сигурни да желите да обришете ову ставку?
Ова акција се не може вратити.',
	'centralnotice-no-notices-exist' => 'Нема напомена.
Додајте једну испод.',
	'centralnotice-number-uses' => 'Коришћење',
	'centralnotice-edit-template' => 'Измени шаблон',
	'centralnotice-message' => 'Порука',
	'centralnotice-message-not-set' => 'Порука није подешена',
	'centralnotice-clone' => 'Клонирај',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'centralnotice-desc' => 'Dodaje centralnu napomenu na sajt.',
	'centralnotice-query' => 'Izmeni trenutna obaveštenja',
	'centralnotice-notice-name' => 'Ime obaveštenja',
	'centralnotice-end-date' => 'Završni datum',
	'centralnotice-enabled' => 'Omogućeno',
	'centralnotice-modify' => 'Pošalji',
	'centralnotice-preview' => 'Prikaži',
	'centralnotice-add-new' => 'Dodaj novu centralnu napomenu',
	'centralnotice-remove' => 'Ukloni',
	'centralnotice-translate-heading' => 'Prevod za $1',
	'centralnotice-manage' => 'Uredi centralnu napomenu',
	'centralnotice-add' => 'Dodaj',
	'centralnotice-add-notice' => 'Dodaj obaveštenje',
	'centralnotice-add-template' => 'Dodaj šablon',
	'centralnotice-show-notices' => 'Prikaži obaveštenja',
	'centralnotice-list-templates' => 'Spisak šablona',
	'centralnotice-translations' => 'Prevodi',
	'centralnotice-translate-to' => 'Prevedi na',
	'centralnotice-translate' => 'Prevedi',
	'centralnotice-english' => 'Engleski',
	'centralnotice-template-name' => 'Ime šablona',
	'centralnotice-templates' => 'Šabloni',
	'centralnotice-weight' => 'Težina',
	'centralnotice-locked' => 'Zaključano',
	'centralnotice-notices' => 'Obaveštenja',
	'centralnotice-notice-exists' => 'Napomena već postoji.
Neće biti dodata',
	'centralnotice-template-exists' => 'Šablon već postoji.
Neće biti dodat',
	'centralnotice-notice-doesnt-exist' => 'Napomena ne postoji.
Nema šta da se obriše',
	'centralnotice-template-still-bound' => 'Šablon je još uvek pridružen napomeni.
Neće biti obrisan.',
	'centralnotice-template-body' => 'Telo šablona:',
	'centralnotice-day' => 'Dan',
	'centralnotice-year' => 'Godina',
	'centralnotice-month' => 'Mesec',
	'centralnotice-hours' => 'Sat',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Ime projekta',
	'centralnotice-project-name' => 'Ime projekta',
	'centralnotice-start-date' => 'Početni datum',
	'centralnotice-start-time' => 'Početno vreme (UTC)',
	'centralnotice-no-templates' => 'Šabloni nisu proađen.
Dodaj neki!',
	'centralnotice-available-templates' => 'Raspoloživi šabloni',
	'centralnotice-preview-template' => 'Prikaži šablon',
	'centralnotice-start-hour' => 'Početno vreme',
	'centralnotice-change-lang' => 'Izmeni jezik transliteracije',
	'centralnotice-weights' => 'Težine',
	'centralnotice-notice-is-locked' => 'Napomena je zaključana.
Nije bila obrisana',
	'centralnotice-invalid-date-range' => 'Neispravan opseg podataka.
Ažuriranje nije izvršeno',
	'centralnotice-null-string' => 'Nije moguće dodavanje praznog stringa.
Nije dodat',
	'centralnotice-confirm-delete' => 'Da li ste sigurni da želite da obrišete ovu stavku?
Ova akcija se ne može vratiti.',
	'centralnotice-no-notices-exist' => 'Nema napomena.
Dodajte jednu ispod.',
	'centralnotice-number-uses' => 'Korišćenje',
	'centralnotice-edit-template' => 'Izmeni šablon',
	'centralnotice-message' => 'Poruka',
	'centralnotice-message-not-set' => 'Poruka nije podešena',
	'centralnotice-clone' => 'Kloniraj',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'centralnotice' => 'Adminstrierenge fon do zentroale Mäldengen',
	'noticetemplate' => 'Zentroale Mäldengs-Foarloage',
	'centralnotice-desc' => "Föiget ne zentroale ''sitenotice'' bietou",
	'centralnotice-summary' => 'Disse Ärwiederenge ferlööwet ju Konfiguration fon zentroale Mäldengen.
Ju kon uk tou dät Moakjen fon näie un Läskenge fon oolde Mäldengen ferwoand wäide.',
	'centralnotice-query' => 'Aktuelle Mäldenge annerje',
	'centralnotice-notice-name' => 'Noome fon ju Notiz',
	'centralnotice-end-date' => 'Eenddoatum',
	'centralnotice-enabled' => 'Aktivierd',
	'centralnotice-modify' => 'OK',
	'centralnotice-preview' => 'Foarschau',
	'centralnotice-add-new' => 'Föich ne näie zentroale Mäldenge bietou',
	'centralnotice-remove' => 'Wächhoalje',
	'centralnotice-translate-heading' => 'Uursättenge fon "$1"',
	'centralnotice-manage' => 'Zentroale Mäldengen ferwaltje',
	'centralnotice-add' => 'Bietouföigje',
	'centralnotice-add-notice' => 'Bietouföigjen fon ne Mäldenge',
	'centralnotice-add-template' => 'Bietouföigjen fon ne Foarloage',
	'centralnotice-show-notices' => 'Wies Mäldengen',
	'centralnotice-list-templates' => 'Foarloagen apliestje',
	'centralnotice-translations' => 'Uursättengen',
	'centralnotice-translate-to' => 'Uursätte in',
	'centralnotice-translate' => 'Uursätte',
	'centralnotice-english' => 'Ängelsk',
	'centralnotice-template-name' => 'Noome fon ju Foarloage',
	'centralnotice-templates' => 'Foarloagen',
	'centralnotice-weight' => 'Gewicht',
	'centralnotice-locked' => 'Speerd',
	'centralnotice-notices' => 'Mäldengen',
	'centralnotice-notice-exists' => 'Mäldenge is al deer.
Nit bietouföiged.',
	'centralnotice-template-exists' => 'Foarloage is al deer.
Nit bietouföiged.',
	'centralnotice-notice-doesnt-exist' => 'Mäldenge is nit deer.
Wächhoaljen nit muugelk.',
	'centralnotice-template-still-bound' => 'Foarloage is noch an ne Mäldengen buunen.
Wächhoaljen nit muugelk.',
	'centralnotice-template-body' => 'Foarloagentext:',
	'centralnotice-day' => 'Dai',
	'centralnotice-year' => 'Jier',
	'centralnotice-month' => 'Mound',
	'centralnotice-hours' => 'Uure',
	'centralnotice-min' => 'Minute',
	'centralnotice-project-lang' => 'Projektsproake',
	'centralnotice-project-name' => 'Projektnoome',
	'centralnotice-start-date' => 'Startdoatum',
	'centralnotice-start-time' => 'Starttied (UTC)',
	'centralnotice-assigned-templates' => 'Touwiesde Foarloagen',
	'centralnotice-no-templates' => 'Der sunt neen Foarloagen in dät System deer.',
	'centralnotice-no-templates-assigned' => 'Der sunt neen Foarloagen an Mäldengen touwiesd.
Föich een bietou.',
	'centralnotice-available-templates' => 'Ferföichboare Foarloagen',
	'centralnotice-template-already-exists' => 'Foarloage is al an ju Kampagne buunen.
Nit bietouföiged.',
	'centralnotice-preview-template' => 'Foarschau Foarloage',
	'centralnotice-start-hour' => 'Starttied',
	'centralnotice-change-lang' => 'Uursättengssproake annerje',
	'centralnotice-weights' => 'Gewicht',
	'centralnotice-notice-is-locked' => 'Mäldenge is speerd.
Wächhoaljen nit muugelk.',
	'centralnotice-overlap' => 'Ju Mäldenge uursnit sik mäd dän Tiedruum fon ne uur Mäldenge.
Nit bietouföiged.',
	'centralnotice-invalid-date-range' => 'Uungultigen Tiedruum.
Nit aktualisierd.',
	'centralnotice-null-string' => 'Der kon neen Nulstring bietouföiged wäide.
Niks bietouföiged.',
	'centralnotice-confirm-delete' => 'Bäst du sicher, dät du dän Iendraach läskje moatest?
Ju Aktion kon nit tourääch troald wäide.',
	'centralnotice-no-notices-exist' => 'Der sunt neen Mäldengen deer.
Föich een bietou.',
	'centralnotice-no-templates-translate' => 'Dät rakt neen Foarloagen, wierfoar do Uursättengen tou beoarbaidjen sunt',
	'centralnotice-number-uses' => 'Nutsengen',
	'centralnotice-edit-template' => 'Foarloage beoarbaidje',
	'centralnotice-message' => 'Ättergjucht',
	'centralnotice-message-not-set' => 'Ättergjucht nit sät.',
	'centralnotice-clone' => 'Klon moakje',
	'centralnotice-clone-notice' => 'Moak ne Kopie fon ju Foarloage',
	'centralnotice-preview-all-template-translations' => 'Foarschau fon aal do ferföichboare Uursättengen fon ne Foarloage',
	'right-centralnotice-admin' => 'Ferwaltjen fon zentroale Mäldengen',
	'right-centralnotice-translate' => 'Uursätten fon zentroale Mäldengen',
	'action-centralnotice-admin' => 'Zentroale Siedennotiz ferfaalen',
	'action-centralnotice-translate' => 'Zentroale Siedennotiz uursätte',
	'centralnotice-preferred' => 'Foarleeken',
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
	'centralnotice' => 'కేంద్రీయ గమనిక నిర్వహణ',
	'noticetemplate' => 'కేంద్రీయ గమనిక మూస',
	'centralnotice-desc' => 'కేంద్రీయ సైటు గమనికని చేరుస్తుంది',
	'centralnotice-notice-name' => 'గమనిక పేరు',
	'centralnotice-end-date' => 'ముగింపు తేదీ',
	'centralnotice-enabled' => 'చేతనమైంది',
	'centralnotice-modify' => 'దాఖలుచేయి',
	'centralnotice-preview' => 'మునుజూపు',
	'centralnotice-add-new' => 'కొత్త కేంద్రీయ గమనికని చేర్చు',
	'centralnotice-remove' => 'తొలగించు',
	'centralnotice-translate-heading' => '$1కి అనువాదం',
	'centralnotice-add' => 'చేర్చు',
	'centralnotice-add-template' => 'ఒక మూసని చేర్చు',
	'centralnotice-list-templates' => 'మూసలను చూపించు',
	'centralnotice-translations' => 'అనువాదాలు',
	'centralnotice-translate' => 'అనువదించండి',
	'centralnotice-english' => 'ఇంగ్లీష్',
	'centralnotice-template-name' => 'మూస పేరు',
	'centralnotice-templates' => 'మూసలు',
	'centralnotice-weight' => 'భారం',
	'centralnotice-notices' => 'గమనికలు',
	'centralnotice-notice-exists' => 'గమనిక ఇప్పటికే ఉంది.
చేర్చట్లేదు',
	'centralnotice-template-exists' => 'మూస ఇప్పటికే ఉంది.
చేర్చట్లేదు',
	'centralnotice-notice-doesnt-exist' => 'గమనిక లేనే లేదు.
ఏమీ తొలగించలేదు',
	'centralnotice-template-body' => 'మూస వివరణ:',
	'centralnotice-day' => 'రోజు',
	'centralnotice-year' => 'సంవత్సరం',
	'centralnotice-month' => 'నెల',
	'centralnotice-hours' => 'గంట',
	'centralnotice-min' => 'నిమిషం',
	'centralnotice-project-lang' => 'ప్రాజెక్టు భాష',
	'centralnotice-project-name' => 'ప్రాజెక్టు పేరు',
	'centralnotice-start-date' => 'ప్రారంభ తేదీ',
	'centralnotice-start-time' => 'ప్రారంభ సమయం (UTC)',
	'centralnotice-no-templates' => 'మూసలు ఏమీ లేవు.
కొన్నింటిని చేర్చండి!',
	'centralnotice-available-templates' => 'అందుబాటులో ఉన్న మూసలు',
	'centralnotice-preview-template' => 'మూస మునుజూపు',
	'centralnotice-start-hour' => 'ప్రారంభ సమయం',
	'centralnotice-change-lang' => 'అనువాదపు భాషని మార్చండి',
	'centralnotice-weights' => 'భారాలు',
	'centralnotice-no-notices-exist' => 'గమనికలు ఏమీ లేవు.
క్రింద చేర్చండి.',
	'centralnotice-number-uses' => 'వాడుకరులు',
	'centralnotice-edit-template' => 'మూసని మార్చు',
	'centralnotice-message' => 'సందేశం',
	'right-centralnotice-admin' => 'కేంద్రీయ గమనికలని నిర్వహించగలగడం',
	'right-centralnotice-translate' => 'కేంద్రీయ గమనికలని అనుదించండి',
	'action-centralnotice-translate' => 'కేంద్రీయ గమనికలని అనువదించగలగడం',
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

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'centralnotice' => "Mudiri e'loni mutamarkaz",
	'noticetemplate' => "Şabloni e'loni mutamarkaz",
	'centralnotice-desc' => 'Jak ittilooti markazi ilova mekunad',
	'centralnotice-summary' => "In modul ba şumo imkoni viroigi nasbi e'loni mutamarkazi kuninro peşkaş mekunad.
On boz metavonad baroi izofa jo pok kardani e'lonhoi kūhna istifoda şavad.",
	'centralnotice-query' => "Taƣjiri e'lonhoi kununī",
	'centralnotice-notice-name' => "Unvoni e'lon",
	'centralnotice-end-date' => 'Sanai oxir',
	'centralnotice-enabled' => "Fa'ol şud",
	'centralnotice-modify' => 'Irsol',
	'centralnotice-preview' => 'Peşnamoiş',
	'centralnotice-add-new' => "Izofai jak e'loni mutamarkaz",
	'centralnotice-remove' => 'Pok kardan',
	'centralnotice-translate-heading' => 'Tarçuma baroi $1',
	'centralnotice-manage' => "Idorakuniji e'loni mutamarkaz",
	'centralnotice-add' => 'Izofa',
	'centralnotice-add-notice' => 'Izofa kardani jak xabar',
	'centralnotice-add-template' => 'Izofai jak şablon',
	'centralnotice-show-notices' => "Namoişi e'lonho",
	'centralnotice-list-templates' => 'Fehristi şablonho',
	'centralnotice-translations' => 'Tarçumaho',
	'centralnotice-translate-to' => 'Tarçuma ba',
	'centralnotice-translate' => 'Tarçuma',
	'centralnotice-english' => 'Anglisī',
	'centralnotice-template-name' => 'Unvoni şablon',
	'centralnotice-templates' => 'Şablonho',
	'centralnotice-weight' => 'Vazn',
	'centralnotice-locked' => 'Bastaşuda',
	'centralnotice-notices' => "E'lonho",
	'centralnotice-notice-exists' => "E'lon allakaj vuçud dorad.
Izofa naşud",
	'centralnotice-template-exists' => 'Şabloni allakaj mavçud ast.
Izofa nameşavad',
	'centralnotice-notice-doesnt-exist' => "E'lon vuçud nadorad.
Cize baroi pok kardan nest",
	'centralnotice-template-still-bound' => "Şablon to hol dar jak e'lone caspida ast.
Pok nameşavad.",
	'centralnotice-template-body' => 'Tanai Şablon:',
	'centralnotice-day' => 'Rūz',
	'centralnotice-year' => 'Sol',
	'centralnotice-month' => 'Moh',
	'centralnotice-hours' => 'Soat',
	'centralnotice-min' => 'Daqiqa',
	'centralnotice-project-lang' => 'Zaboni loiha',
	'centralnotice-project-name' => 'Nomi loiha',
	'centralnotice-start-date' => "Sanai şurū'",
	'centralnotice-start-time' => "Zamoni şurū' (UTC)",
	'centralnotice-assigned-templates' => 'Şablonhoi muqararşuda',
	'centralnotice-no-templates' => 'Heç şablone joft naşud.
Cande izofa namoed!',
	'centralnotice-no-templates-assigned' => "Heç şablone ba e'lon muqarar naşudaast.
Cande izofa namoed!",
	'centralnotice-available-templates' => 'Şablonhoi dastras',
	'centralnotice-template-already-exists' => "Şabloni allakaj ba e'lon casponida şudaast.
Izofa naşud.",
	'centralnotice-preview-template' => 'Peşnamoişi şablon',
	'centralnotice-start-hour' => "Vaqti şurū'",
	'centralnotice-change-lang' => 'Taƣjiri zaboni tarçuma',
	'centralnotice-weights' => 'Vaznho',
	'centralnotice-notice-is-locked' => "E'lon basta ast.
Pok naşuda istoda ast",
	'centralnotice-overlap' => "E'lon bo vaqtu zamoni digar e'lon rūi ham omad.
Izofa naşud",
	'centralnotice-invalid-date-range' => "Davrai sanai nomū'tabar.
Barūz naşud",
	'centralnotice-null-string' => 'Riştai xoliro nametavon afzud.
Afzuda naşud',
	'centralnotice-confirm-delete' => 'Ojo şumo mutmain hasted, ki mexohed in mavodro hafz kuned?
In amal barqarornaşavada xohad bud.',
	'centralnotice-no-notices-exist' => "Heç e'lone vuçud nadorad.
Dar zer jak e'lone izofa namoed",
	'centralnotice-no-templates-translate' => 'Heç şablone baroi viroişi tarçumaaş nest',
	'centralnotice-number-uses' => 'Istifodaho',
	'centralnotice-edit-template' => 'Viroişi şablon',
	'centralnotice-message' => 'Pajƣom',
	'centralnotice-message-not-set' => 'Pajƣom tanzim naşudaast',
	'centralnotice-clone' => 'Klon',
	'centralnotice-clone-notice' => 'Eçodi jak nusxai in şablon',
	'centralnotice-preview-all-template-translations' => 'Peşnamoişi hamai tarçumahoi dastrasi şablon',
	'right-centralnotice-admin' => "Idorakuniji e'lonhoi mutamarkaz",
	'right-centralnotice-translate' => "Tarçumai e'lonhoi mutamarkaz",
	'action-centralnotice-admin' => "idorakuniji e'lonhoi mutamarkaz",
	'action-centralnotice-translate' => "tarçumai e'lonhoi mutamarkaz",
	'centralnotice-preferred' => 'Tarçihi dodaşuda',
);

/** Thai (ไทย)
 * @author Ans
 * @author Manop
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'centralnotice' => 'การจัดการประกาศส่วนกลาง',
	'noticetemplate' => 'แม่แบบประกาศของส่้วนกลาง',
	'centralnotice-desc' => 'เพิ่มประกาศส่วนกลางของไซต์',
	'centralnotice-summary' => 'คุณสามารถแก้ไขประกาศส่วนกลางปัจจุบันได้ โดยใช้เครื่องมือนี้
คุณสามารถเพิ่มหรือนำประกาศเก่าออกได้เช่นกัน',
	'centralnotice-query' => 'แก้ไขประกาศปัจจุบัน',
	'centralnotice-notice-name' => 'หัวข้อการประกาศ',
	'centralnotice-end-date' => 'วันหมดอายุ',
	'centralnotice-enabled' => 'ถูกทำให้ใช้งานได้',
	'centralnotice-modify' => 'ตกลง',
	'centralnotice-preview' => 'แสดงตัวอย่าง',
	'centralnotice-add-new' => 'เพิ่มประกาศของส่วนกลางใหม่',
	'centralnotice-remove' => 'นำออก',
	'centralnotice-translate-heading' => 'การแปลสำหรับ $1',
	'centralnotice-manage' => 'จัดการกับประกาศส่วนกลาง',
	'centralnotice-add' => 'เพิ่ม',
	'centralnotice-add-notice' => 'เพิ่มประกาศ',
	'centralnotice-add-template' => 'เพิ่มแม่แบบ',
	'centralnotice-show-notices' => 'แสดงประกาศ',
	'centralnotice-list-templates' => 'แสดงรายชื่อแม่แบบ',
	'centralnotice-translations' => 'การแปล',
	'centralnotice-translate-to' => 'แปลเป็นภาษา',
	'centralnotice-translate' => 'แปล',
	'centralnotice-english' => 'อังกฤษ',
	'centralnotice-template-name' => 'ชื่อแม่แบบ',
	'centralnotice-templates' => 'แม่แบบ',
	'centralnotice-weight' => 'น้ำหนัก',
	'centralnotice-locked' => 'ถูกล็อก',
	'centralnotice-notices' => 'ประกาศ',
	'centralnotice-notice-exists' => 'มีประกาศอยู่แล้ว
จะไม่ทำการเพิ่ม',
	'centralnotice-template-exists' => 'มีแม่แบบอยู่แล้ว
จะไม่ทำการเพิ่ม',
	'centralnotice-notice-doesnt-exist' => 'ไม่มีประกาศ
ไม่สามารถนำออกได้',
	'centralnotice-template-still-bound' => 'แม่แบบยังอยู่ในระยะเวลาที่ใช้ประกาศ
จะไม่ทำการนำออก',
	'centralnotice-template-body' => 'เนื้อหาของแม่แบบ:',
	'centralnotice-day' => 'วัน',
	'centralnotice-year' => 'ปี',
	'centralnotice-month' => 'เดือน',
	'centralnotice-hours' => 'ชั่วโมง',
	'centralnotice-min' => 'นาที',
	'centralnotice-project-lang' => 'ภาษาของโึครงการ',
	'centralnotice-project-name' => 'ชื่อโครงการ',
	'centralnotice-start-date' => 'วันที่เริ่ม',
	'centralnotice-start-time' => 'เวลาที่เริ่ม (เวลาสากลกรีนิช UTC)',
	'centralnotice-assigned-templates' => 'แม่แบบที่ได้รับมอบหมาย',
	'centralnotice-no-templates' => 'ไม่พบแม่แบบใด ๆ
กรุณาเพิ่มแม่แบบ!',
	'centralnotice-no-templates-assigned' => 'ไม่มีแม่แบบบนประกาศ
กรุณาเพิ่มแม่แบบ!',
	'centralnotice-available-templates' => 'แม่แบบที่มีอยู่',
	'centralnotice-template-already-exists' => 'แม่แบบนี้เป็นส่วนหนึ่งของการรณรงค์
ไม่ทำการเพิ่ม',
	'centralnotice-preview-template' => 'ดูตัวอย่างแม่แบบ',
	'centralnotice-start-hour' => 'เวลาที่เริ่ม',
	'centralnotice-change-lang' => 'เปลี่ยนภาษาที่ใช้ในการแปล',
	'centralnotice-weights' => 'น้ำหนัก',
	'centralnotice-notice-is-locked' => 'ประกาศถูกล็อกอยู่
ไม่นำออก',
	'centralnotice-overlap' => 'ประกาศนี้ทับซ้อนกับเวลาของอีกประกาศหนึ่ง
จะำไม่ทำการเพิ่ม',
	'centralnotice-invalid-date-range' => 'ช่วงเวลาดังกล่าวเป็นช่วงเวลาที่ไม่สามารถเป็นไปได้
จะไม่ทำการอัปเดต',
	'centralnotice-null-string' => 'ไม่สามารถเพิ่มประกาศที่มีข้อความว่้างได้
จะไม่ทำการเพิ่ม',
	'centralnotice-confirm-delete' => 'คุณแน่ใจหรือว่าต้องการลบรายการนี้ทิ้ง
เมื่อลบทิ้งแล้ว จะไม่สามารถกู้คืนมาได้อีกเลย',
	'centralnotice-no-notices-exist' => 'ไม่มีประกาศ
เพิ่มประกาศด้านล่าง',
	'centralnotice-no-templates-translate' => 'ไม่มีแม่แบบใด ๆ ที่จะแก้ไขการแปล',
	'centralnotice-number-uses' => 'การใช้งาน',
	'centralnotice-edit-template' => 'แก้ไขแม่แบบ',
	'centralnotice-message' => 'ข้อความ',
	'centralnotice-message-not-set' => 'ข้อความยังไม่ได้ถูกตั้งค่า',
	'centralnotice-clone' => 'สำเนา',
	'centralnotice-clone-notice' => 'สร้างสำเนาของแม่แบบ',
	'centralnotice-preview-all-template-translations' => 'ดูการแปลในทุก ๆ ภาษาของแม่แบบ',
	'right-centralnotice-admin' => 'จัดการประกาศส่วนกลาง',
	'right-centralnotice-translate' => 'แปลประกาศส่วนกลาง',
	'action-centralnotice-admin' => 'จัดการประกาศส่วนกลาง',
	'action-centralnotice-translate' => 'แปลประกาศส่วนกลาง',
	'centralnotice-preferred' => 'แบบที่เลือก',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'centralnotice' => 'Merkezi uwedomleniýe admini',
	'noticetemplate' => 'Merkezi uwedomleniýe şablony',
	'centralnotice-desc' => 'Merkezi uwedomleniýe goşýar',
	'centralnotice-summary' => 'Bu modul size bar bolan gurulgy merkezi uwedomleniýeleri üýtgetmäge rugsat berýär. 
Ony köne uwedomleniýeleri goşmak ýa-da aýyrmak üçin hem ulanmak bolýar.',
	'centralnotice-query' => 'Häzirki uwedomleniýeleri üýtget',
	'centralnotice-notice-name' => 'Uwedomleniýe ady',
	'centralnotice-end-date' => 'Gutaryş senesi',
	'centralnotice-enabled' => 'Açyk',
	'centralnotice-modify' => 'Tabşyr',
	'centralnotice-preview' => 'Deslapky syn',
	'centralnotice-add-new' => 'Täze merkezi uwedomleniýe goş',
	'centralnotice-remove' => 'Aýyr',
	'centralnotice-translate-heading' => '$1 üçin terjime',
	'centralnotice-manage' => 'Merkezi uwedomleniýäni dolandyr',
	'centralnotice-add' => 'Goş',
	'centralnotice-add-notice' => 'Uwedomleniýe goş',
	'centralnotice-add-template' => 'Şablon goş',
	'centralnotice-show-notices' => 'Uwedomleniýeleri görkez',
	'centralnotice-list-templates' => 'Şablonlaryň sanawyny görkez',
	'centralnotice-translations' => 'Terjimeler',
	'centralnotice-translate-to' => 'Şu dile terjime et:',
	'centralnotice-translate' => 'Terjime et',
	'centralnotice-english' => 'iňlisçe',
	'centralnotice-template-name' => 'Şablon ady',
	'centralnotice-templates' => 'Şablonlar',
	'centralnotice-weight' => 'Agram',
	'centralnotice-locked' => 'Gulply',
	'centralnotice-notices' => 'Uwedomleniýeler',
	'centralnotice-notice-exists' => 'Uwedomleniýe eýýäm bar.
Goşulmaýar',
	'centralnotice-template-exists' => 'Şablon eýýäm bar.
Goşulmaýar',
	'centralnotice-notice-doesnt-exist' => 'Uwedomleniýe ýok.
Aýyrmaga zat ýok',
	'centralnotice-template-still-bound' => 'Şablon henizem bir uwedomleniýä bagly.
Aýrylmaýar.',
	'centralnotice-template-body' => 'Şablon göwresi:',
	'centralnotice-day' => 'Gün',
	'centralnotice-year' => 'Ýyl',
	'centralnotice-month' => 'Aý',
	'centralnotice-hours' => 'Sagat',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Taslama dili',
	'centralnotice-project-name' => 'Taslama ady',
	'centralnotice-start-date' => 'Başlangyç senesi',
	'centralnotice-start-time' => 'Başlangyç wagty (UTC)',
	'centralnotice-assigned-templates' => 'Bellenilen şablonlar',
	'centralnotice-no-templates' => 'Hiç hili şablon tapylmady.
Biraz goşuň!',
	'centralnotice-no-templates-assigned' => 'Bu uwedomleniýä hiç hili şablon bellenilmändir.
Biraz goşuň!',
	'centralnotice-available-templates' => 'Bar bolan şablonlar',
	'centralnotice-template-already-exists' => 'Şablon eýýäç kampaniýa baglanypdyr.
Goşulmaýar',
	'centralnotice-preview-template' => 'Şablony deslapky synla',
	'centralnotice-start-hour' => 'Başlangyç wagty',
	'centralnotice-change-lang' => 'Terjime dilini üýtget',
	'centralnotice-weights' => 'Agramlar',
	'centralnotice-notice-is-locked' => 'Uwedomleniýe gulply.
Aýyrylmaýar',
	'centralnotice-overlap' => 'Uwedomleniýe başga bir uwedomleniýäniň wagty bilen çakyşýar.',
	'centralnotice-invalid-date-range' => 'Nädogry sene aralygy.
Täzelenmeýär',
	'centralnotice-null-string' => 'Boş setir goşup bolmaýar.
Goşulmaýar',
	'centralnotice-confirm-delete' => 'Bu elementi hakykatdan-da öçürjekmisiňiz?
Bu hereketi yzyna alyp bolýan däldir.',
	'centralnotice-no-notices-exist' => 'Hiç hili uwedomleniýe ýok.
Aşak birini goşuň.',
	'centralnotice-no-templates-translate' => 'Terjimeleri redaktirlemek üçin hiç hili şablon ýok.',
	'centralnotice-number-uses' => 'Ulanyşlar',
	'centralnotice-edit-template' => 'Şablony redaktirle',
	'centralnotice-message' => 'Habarlaşyk',
	'centralnotice-message-not-set' => 'Habarlaşyk bellenilmändir',
	'centralnotice-clone' => 'Klonirle',
	'centralnotice-clone-notice' => 'Şablonyň nusgasyny döret',
	'centralnotice-preview-all-template-translations' => 'Şablonyň bar bolan ähli terjimelerini deslapky synla',
	'right-centralnotice-admin' => 'Merkezi uwedomleniýeleri dolandyr',
	'right-centralnotice-translate' => 'Merkezi uwedomleniýeleri terjime et',
	'action-centralnotice-admin' => 'merkezi uwedomleniýeleri dolandyr',
	'action-centralnotice-translate' => 'merkezi uwedomleniýeleri terjime et',
	'centralnotice-preferred' => 'Ileri tutulýan',
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

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'centralnotice' => 'Merkezi uyarı yöneticisi',
	'noticetemplate' => 'Merkezi uyarı şablonu',
	'centralnotice-desc' => 'Merkezi site uyarısı ekler',
	'centralnotice-summary' => 'Bu modül size, mevcut ayarlanmış merkezi uyarıları değiştirmenize izin verir.
Eski uyarıları ekleyip çıkarmak için de kullanılabilir.',
	'centralnotice-query' => 'Güncel uyarıları değiştir',
	'centralnotice-notice-name' => 'Uyarı adı',
	'centralnotice-end-date' => 'Bitiş tarihi',
	'centralnotice-enabled' => 'Etkinleştirilmiş',
	'centralnotice-modify' => 'Gönder',
	'centralnotice-preview' => 'Ön izleme',
	'centralnotice-add-new' => 'Yeni bir merkezi uyarı ekle',
	'centralnotice-remove' => 'Çıkar',
	'centralnotice-translate-heading' => '$1 için çeviri',
	'centralnotice-manage' => 'Merkezi uyarıyı yönet',
	'centralnotice-add' => 'Ekle',
	'centralnotice-add-notice' => 'Bir uyarı ekle',
	'centralnotice-add-template' => 'Bir şablon ekle',
	'centralnotice-show-notices' => 'Uyarıları göster',
	'centralnotice-list-templates' => 'Şablonları listele',
	'centralnotice-translations' => 'Çeviriler',
	'centralnotice-translate-to' => 'Şu dile çevir',
	'centralnotice-translate' => 'Çevir',
	'centralnotice-english' => 'İngilizce',
	'centralnotice-template-name' => 'Şablon adı',
	'centralnotice-templates' => 'Şablonlar',
	'centralnotice-weight' => 'Önem',
	'centralnotice-locked' => 'Kilitli',
	'centralnotice-notices' => 'Uyarılar',
	'centralnotice-notice-exists' => 'Uyarı zaten var.
Eklenmiyor',
	'centralnotice-template-exists' => 'Şablon zaten var.
Eklenmiyor',
	'centralnotice-notice-doesnt-exist' => 'Uyarı mevcut değil.
Çıkaracak birşey yok',
	'centralnotice-template-still-bound' => 'Şablon hala bir uyarıya bağlı.
Kaldırılmıyor.',
	'centralnotice-template-body' => 'Şablon gövdesi:',
	'centralnotice-day' => 'Gün',
	'centralnotice-year' => 'Yıl',
	'centralnotice-month' => 'Ay',
	'centralnotice-hours' => 'Saat',
	'centralnotice-min' => 'Dakika',
	'centralnotice-project-lang' => 'Proje dili',
	'centralnotice-project-name' => 'Proje adı',
	'centralnotice-start-date' => 'Başlangıç tarihi',
	'centralnotice-start-time' => 'Başlangıç zamanı (UTC)',
	'centralnotice-assigned-templates' => 'Atanmış şablonlar',
	'centralnotice-no-templates' => 'Hiç şablon bulunamadı.
Birkaç tane ekleyin!',
	'centralnotice-no-templates-assigned' => 'Uyarıya hiç şablon atanmamış.
Birkaç tane ekleyin!',
	'centralnotice-available-templates' => 'Uygun şablonlar',
	'centralnotice-template-already-exists' => 'Şablon zaten kampanyaya bağlı.
Eklenmiyor',
	'centralnotice-preview-template' => 'Şablonu önizle',
	'centralnotice-start-hour' => 'Başlangıç zamanı',
	'centralnotice-change-lang' => 'Çeviri dilini değiştir',
	'centralnotice-weights' => 'Önemler',
	'centralnotice-notice-is-locked' => 'Uyarı kilitli.
Kaldırılmıyor',
	'centralnotice-overlap' => 'Uyarı başka bir uyarının zamanıyla çakışıyor.
Eklenmiyor',
	'centralnotice-invalid-date-range' => 'Geçersiz tarih aralığı.
Güncellenmiyor',
	'centralnotice-null-string' => 'Boş dizi eklenemez.
Eklenmiyor',
	'centralnotice-confirm-delete' => 'Bu öğeyi silmek istediğinize emin misiniz?
Bu işlem geri alınamaz.',
	'centralnotice-no-notices-exist' => 'Hiç uyarı yok.
Aşağıya bir tane ekleyin',
	'centralnotice-no-templates-translate' => 'Çevirileri değiştirmek için hiç şablon yok',
	'centralnotice-number-uses' => 'Kullanımlar',
	'centralnotice-edit-template' => 'Şablonu değiştir',
	'centralnotice-message' => 'Mesaj',
	'centralnotice-message-not-set' => 'Mesaj ayarlanmadı',
	'centralnotice-clone' => 'Klonla',
	'centralnotice-clone-notice' => 'Şablonun kopyasını oluştur',
	'centralnotice-preview-all-template-translations' => 'Şablonun bütün uygun çevirilerini önizle',
	'right-centralnotice-admin' => 'Merkezi uyarıları yönet',
	'right-centralnotice-translate' => 'Merkezi uyarıları çevir',
	'action-centralnotice-admin' => 'merkezi uyarıları yönet',
	'action-centralnotice-translate' => 'merkezi uyarıları çevir',
	'centralnotice-preferred' => 'Tercih edilen',
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
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'centralnotice' => 'Quản lý các thông báo chung',
	'noticetemplate' => 'Bản mẫu thông báo chung',
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
	'centralnotice-add-template' => 'Thêm bản mẫu',
	'centralnotice-show-notices' => 'Xem các thông báo',
	'centralnotice-list-templates' => 'Liệt kê các bản mẫu',
	'centralnotice-translations' => 'Bản dịch',
	'centralnotice-translate-to' => 'Dịch ra',
	'centralnotice-translate' => 'Biên dịch',
	'centralnotice-english' => 'tiếng Anh',
	'centralnotice-template-name' => 'Tên bản mẫu',
	'centralnotice-templates' => 'Bản mẫu',
	'centralnotice-weight' => 'Mức ưu tiên',
	'centralnotice-locked' => 'Bị khóa',
	'centralnotice-notices' => 'Thông báo',
	'centralnotice-notice-exists' => 'Không thêm được: thông báo đã tồn tại.',
	'centralnotice-template-exists' => 'Không thêm được: bản mẫu đã tồn tại.',
	'centralnotice-notice-doesnt-exist' => 'Không dời được: thông báo không tồn tại.',
	'centralnotice-template-still-bound' => 'Không dời được: có thông báo dựa theo bản mẫu.',
	'centralnotice-template-body' => 'Nội dung bản mẫu:',
	'centralnotice-day' => 'Ngày',
	'centralnotice-year' => 'Năm',
	'centralnotice-month' => 'Tháng',
	'centralnotice-hours' => 'Giờ',
	'centralnotice-min' => 'Phút',
	'centralnotice-project-lang' => 'Ngôn ngữ của dự án',
	'centralnotice-project-name' => 'Tên dự án',
	'centralnotice-start-date' => 'Ngày bắt đầu',
	'centralnotice-start-time' => 'Lúc bắt đầu (UTC)',
	'centralnotice-assigned-templates' => 'Bản mẫu được sử dụng',
	'centralnotice-no-templates' => 'Hệ thống không chứa bản mẫu.
Hãy thêm vào!',
	'centralnotice-no-templates-assigned' => 'Thông báo không dùng bản mẫu nào. Hãy chỉ định bản mẫu!',
	'centralnotice-available-templates' => 'Bản mẫu có sẵn',
	'centralnotice-template-already-exists' => 'Không chỉ định được: thông báo đã sử dụng bản mẫu.',
	'centralnotice-preview-template' => 'Xem trước bản mẫu',
	'centralnotice-start-hour' => 'Lúc bắt đầu',
	'centralnotice-change-lang' => 'Thay đổi ngôn ngữ của bản dịch',
	'centralnotice-weights' => 'Mức ưu tiên',
	'centralnotice-notice-is-locked' => 'Không dời được: thông báo bị khóa.',
	'centralnotice-overlap' => 'Không thêm được: thông báo sẽ hiện cùng lúc với thông báo khác.',
	'centralnotice-invalid-date-range' => 'Không cập nhật được: thời gian không hợp lệ.',
	'centralnotice-null-string' => 'Không thêm được: chuỗi rỗng.',
	'centralnotice-confirm-delete' => 'Bạn có chắc muốn xóa thông báo hoặc bản mẫu này không? Không thể phục hồi nó.',
	'centralnotice-no-notices-exist' => 'Chưa có thông báo. Hãy thêm thông báo ở dưới.',
	'centralnotice-no-templates-translate' => 'Không có bản mẫu để dịch',
	'centralnotice-number-uses' => 'Số thông báo dùng',
	'centralnotice-edit-template' => 'Sửa đổi bản mẫu',
	'centralnotice-message' => 'Thông báo',
	'centralnotice-message-not-set' => 'Thông báo chưa được thiết lập',
	'centralnotice-clone' => 'Sao',
	'centralnotice-clone-notice' => 'Tạo bản sao của bản mẫu',
	'centralnotice-preview-all-template-translations' => 'Xem trước các bản dịch có sẵn của bản mẫu',
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
	'centralnotice-end-date' => 'Finadät',
	'centralnotice-enabled' => 'Pemögükon',
	'centralnotice-modify' => 'Sedön',
	'centralnotice-preview' => 'Büologed',
	'centralnotice-remove' => 'Moükön',
	'centralnotice-translate-heading' => 'Tradutam pro $1',
	'centralnotice-add' => 'Läükön',
	'centralnotice-add-template' => 'Läükön samafomoti',
	'centralnotice-list-templates' => 'Lisedön samafomotis',
	'centralnotice-translations' => 'Tradutods',
	'centralnotice-translate-to' => 'Tradutön ini',
	'centralnotice-translate' => 'Tradutön',
	'centralnotice-english' => 'Linglänapük',
	'centralnotice-template-name' => 'Nem samafomota',
	'centralnotice-templates' => 'Samafomots',
	'centralnotice-locked' => 'Pelökofärmükon',
	'centralnotice-template-exists' => 'Samafomot ya dabinon.
No paläükon',
	'centralnotice-day' => 'Del',
	'centralnotice-year' => 'Yel',
	'centralnotice-month' => 'Mul',
	'centralnotice-hours' => 'Düp',
	'centralnotice-min' => 'Minut',
	'centralnotice-project-lang' => 'Proyegapük',
	'centralnotice-project-name' => 'Proyeganem',
	'centralnotice-start-date' => 'Primadät',
	'centralnotice-start-time' => 'Primatim (UTC)',
	'centralnotice-assigned-templates' => 'Samafomots pegivülöl',
	'centralnotice-no-templates' => 'Samafomots nonik petuvons.
Läükolös anikis!',
	'centralnotice-available-templates' => 'Samafomots gebidik',
	'centralnotice-preview-template' => 'Büologed samafomota',
	'centralnotice-start-hour' => 'Primatim',
	'centralnotice-change-lang' => 'Votükön tradutamapük',
	'centralnotice-confirm-delete' => 'Sevol-li fümo, das vilol moükön atosi?
Dun at obinon nesädunovik.',
	'centralnotice-no-templates-translate' => 'Dabinons samafomots nonik, tefü kels kanoy bevobön tradutodis',
	'centralnotice-number-uses' => 'Gebs',
	'centralnotice-edit-template' => 'Redakön samafomoti',
	'centralnotice-message' => 'Nun',
	'centralnotice-clone-notice' => 'Jafön kopiedi samafomota',
	'centralnotice-preview-all-template-translations' => 'Büologed tradutodas gebidik valik samafomota',
	'centralnotice-preferred' => 'Pebuüköl',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'centralnotice-preview' => 'פֿאראויסשטעלונג',
	'centralnotice-translate-heading' => 'פֿאַרטייטשונג פֿאַר ִ$1',
	'centralnotice-add' => 'צולייגן',
	'centralnotice-translations' => 'פֿאַרטייטשונגען',
	'centralnotice-translate-to' => 'פֿאַרטייטשן אויף',
	'centralnotice-translate' => 'פֿאַרטייטשן',
	'centralnotice-english' => 'ענגליש',
	'centralnotice-template-name' => 'מוסטער נאמען',
	'centralnotice-templates' => 'מוסטערן',
	'centralnotice-locked' => 'פֿאַרשלאסן',
	'centralnotice-notices' => 'נאטיצן',
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
 * @author Chenzw
 * @author Gzdavidwong
 * @author Liangent
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'centralnotice' => '中央通告管理',
	'noticetemplate' => '中央通告模板',
	'centralnotice-desc' => '在页面的顶部增加統一的公告栏位',
	'centralnotice-summary' => '这个模块允许你编辑你当前设置的中央通告。
它也可以用于添加或删除旧的通告。',
	'centralnotice-query' => '修改当前的通告',
	'centralnotice-notice-name' => '通告名称',
	'centralnotice-end-date' => '结束日期',
	'centralnotice-enabled' => '已启用',
	'centralnotice-modify' => '提交',
	'centralnotice-preview' => '预览',
	'centralnotice-add-new' => '添加一个新的中央通告',
	'centralnotice-remove' => '移除',
	'centralnotice-translate-heading' => '$1的翻译',
	'centralnotice-manage' => '管理中央通告',
	'centralnotice-add' => '添加',
	'centralnotice-add-notice' => '添加一个通告',
	'centralnotice-add-template' => '添加一个模板',
	'centralnotice-show-notices' => '显示通告',
	'centralnotice-list-templates' => '列出模板',
	'centralnotice-translations' => '翻译',
	'centralnotice-translate-to' => '翻译到',
	'centralnotice-translate' => '翻译',
	'centralnotice-english' => '英语',
	'centralnotice-template-name' => '模板名称',
	'centralnotice-templates' => '模板',
	'centralnotice-weight' => '权重',
	'centralnotice-locked' => '已锁定',
	'centralnotice-notices' => '通告',
	'centralnotice-notice-exists' => '通告已经存在。
没有添加',
	'centralnotice-template-exists' => '模板已经存在。
没有添加',
	'centralnotice-notice-doesnt-exist' => '通告不存在。
没有东西移除',
	'centralnotice-template-still-bound' => '模板不存在。
没有东西移除。',
	'centralnotice-template-body' => '模板体：',
	'centralnotice-day' => '日',
	'centralnotice-year' => '年',
	'centralnotice-month' => '月',
	'centralnotice-hours' => '时',
	'centralnotice-min' => '分',
	'centralnotice-project-lang' => '计划语言',
	'centralnotice-project-name' => '计划名称',
	'centralnotice-start-date' => '开始日期',
	'centralnotice-start-time' => '开始时间（UTC）',
	'centralnotice-assigned-templates' => '已分配的模板',
	'centralnotice-no-templates' => '没有找到模板。
添加一些！',
	'centralnotice-no-templates-assigned' => '没有模板分配到通告。
添加一些！',
	'centralnotice-available-templates' => '可用模板',
	'centralnotice-template-already-exists' => '模板已经绑定到营销。
没有添加',
	'centralnotice-preview-template' => '预览模板',
	'centralnotice-start-hour' => '开始时间',
	'centralnotice-change-lang' => '改变翻译语言',
	'centralnotice-weights' => '权重',
	'centralnotice-notice-is-locked' => '通告已经锁定。
没有移除',
	'centralnotice-overlap' => '通告在另一个通告的时间内重叠。
没有添加',
	'centralnotice-invalid-date-range' => '无效日期范围。
没有更新',
	'centralnotice-null-string' => '不能添加一个空字符串。
没有添加',
	'centralnotice-confirm-delete' => '你确定要删除这个项目？
这个动作是不可恢复的。',
	'centralnotice-no-notices-exist' => '不存在通告。
在下面添加一个。',
	'centralnotice-no-templates-translate' => '没有任何可以编辑翻译的模板',
	'centralnotice-number-uses' => '使用',
	'centralnotice-edit-template' => '编辑模板',
	'centralnotice-message' => '消息',
	'centralnotice-message-not-set' => '没有设置消息',
	'centralnotice-clone' => '建立副本',
	'centralnotice-clone-notice' => '创建一个模板的副本',
	'centralnotice-preview-all-template-translations' => '预览模板的所有可用翻译',
	'right-centralnotice-admin' => '管理中央通告',
	'right-centralnotice-translate' => '翻译中央通告',
	'action-centralnotice-admin' => '管理中央通告',
	'action-centralnotice-translate' => '翻译中央通告',
	'centralnotice-preferred' => '偏好的',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alex S.H. Lin
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'centralnotice' => '中央通告管理',
	'noticetemplate' => '中央通告模板',
	'centralnotice-desc' => '在頁面頂端增加統一的公告欄位',
	'centralnotice-summary' => '這個模塊允許你編輯你當前設置的中央通告。
它也可以用於添加或刪除舊的通告。',
	'centralnotice-query' => '修改當前的通告',
	'centralnotice-notice-name' => '通告名稱',
	'centralnotice-end-date' => '結束日期',
	'centralnotice-enabled' => '已啟用',
	'centralnotice-modify' => '提交',
	'centralnotice-preview' => '預覽',
	'centralnotice-add-new' => '添加一個新的中央通告',
	'centralnotice-remove' => '移除',
	'centralnotice-translate-heading' => '$1的翻譯',
	'centralnotice-manage' => '管理中央通告',
	'centralnotice-add' => '添加',
	'centralnotice-add-notice' => '添加一個通告',
	'centralnotice-add-template' => '添加一個模板',
	'centralnotice-show-notices' => '顯示通告',
	'centralnotice-list-templates' => '列出模板',
	'centralnotice-translations' => '翻譯',
	'centralnotice-translate-to' => '翻譯到',
	'centralnotice-translate' => '翻譯',
	'centralnotice-english' => '英語',
	'centralnotice-template-name' => '模板名稱',
	'centralnotice-templates' => '模板',
	'centralnotice-weight' => '權重',
	'centralnotice-locked' => '已鎖定',
	'centralnotice-notices' => '通告',
	'centralnotice-notice-exists' => '通告已經存在。
沒有添加',
	'centralnotice-template-exists' => '模板已經存在。
沒有添加',
	'centralnotice-notice-doesnt-exist' => '通告不存在。
沒有東西移除',
	'centralnotice-template-still-bound' => '模板不存在。
沒有東西移除。',
	'centralnotice-template-body' => '模板體：',
	'centralnotice-day' => '日',
	'centralnotice-year' => '年',
	'centralnotice-month' => '月',
	'centralnotice-hours' => '時',
	'centralnotice-min' => '分',
	'centralnotice-project-lang' => '計劃語言',
	'centralnotice-project-name' => '計劃名稱',
	'centralnotice-start-date' => '開始日期',
	'centralnotice-start-time' => '開始時間（UTC）',
	'centralnotice-assigned-templates' => '已分配的模板',
	'centralnotice-no-templates' => '沒有找到模板。
添加一些！',
	'centralnotice-no-templates-assigned' => '沒有模板分配到通告。
添加一些！',
	'centralnotice-available-templates' => '可用模板',
	'centralnotice-template-already-exists' => '模板已經綁定到營銷。
沒有添加',
	'centralnotice-preview-template' => '預覽模板',
	'centralnotice-start-hour' => '開始時間',
	'centralnotice-change-lang' => '改變翻譯語言',
	'centralnotice-weights' => '權重',
	'centralnotice-notice-is-locked' => '通告已經鎖定。
沒有移除',
	'centralnotice-overlap' => '通告在另一個通告的時間內重疊。
沒有添加',
	'centralnotice-invalid-date-range' => '無效日期範圍。
沒有更新',
	'centralnotice-null-string' => '不能添加一個空字符串。
沒有添加',
	'centralnotice-confirm-delete' => '你確定要刪除這個項目？
這個動作是不可恢復的。',
	'centralnotice-no-notices-exist' => '不存在通告。
在下面添加一個。',
	'centralnotice-no-templates-translate' => '沒有任何可以編輯翻譯的模板',
	'centralnotice-number-uses' => '使用',
	'centralnotice-edit-template' => '編輯模板',
	'centralnotice-message' => '消息',
	'centralnotice-message-not-set' => '沒有設置消息',
	'centralnotice-clone' => '建立副本',
	'centralnotice-clone-notice' => '創建一個模板的副本',
	'centralnotice-preview-all-template-translations' => '預覽模板的所有可用翻譯',
	'right-centralnotice-admin' => '管理中央通告',
	'right-centralnotice-translate' => '翻譯中央通告',
	'action-centralnotice-admin' => '管理中央通告',
	'action-centralnotice-translate' => '翻譯中央通告',
	'centralnotice-preferred' => '偏好的',
);

