<?php

$messages = array();

$messages['en'] = array(
	'phalanx-desc' => 'Phalanx is an Integrated Spam Defense Mechanism',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrated Spam Defense Mechanism',
	'phalanx-type-content' => 'page content',
	'phalanx-type-summary' => 'page summary',
	'phalanx-type-title' => 'page title',
	'phalanx-type-user' => 'user',
	'phalanx-type-user-email' => 'email',
	'phalanx-type-answers-question-title' => 'question title',
	'phalanx-type-answers-recent-questions' => 'recent questions',
	'phalanx-type-wiki-creation' => 'wiki creation',
	'phalanx-add-block' => 'Apply block',
	'phalanx-edit-block' => 'Save block',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Reason:',
	'phalanx-label-expiry' => 'Expiry:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Language:',
	'phalanx-view-type' => 'Type of block...',
	'phalanx-view-blocker' => 'Search by filter text:',
	'phalanx-view-blocks' => 'Search filters',
	'phalanx-view-id' => 'Get filter by ID:',
	'phalanx-view-id-submit' => 'Get filter',
	'phalanx-expire-durations' => '1 hour,2 hours,4 hours,6 hours,1 day,3 days,1 week,2 weeks,1 month,3 months,6 months,1 year,infinite', // FIXME: no L10n possible; see core block/protect implementations for proper solution.
	'phalanx-format-text' => 'plain text',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'case sensitive',
	'phalanx-format-exact' => 'exact',
	'phalanx-tab-main' => 'Manage Filters',
	'phalanx-tab-secondary' => 'Test Filters',

	'phalanx-block-success' => 'The block was successfully added',
	'phalanx-block-failure' => 'There was an error during adding the block',
	'phalanx-modify-success' => 'The block was successfully modified',
	'phalanx-modify-failure' => 'There was an error modifying the block',
	'phalanx-modify-warning' => 'You are editing block ID #$1.
Clicking "{{int:phalanx-edit-block}}" will save your changes!',
	'phalanx-test-description' => 'Test provided text against current blocks.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Test results',
	'phalanx-display-row-blocks' => 'blocks: $1',
	'phalanx-display-row-created' => "created by '''$1''' on $2",

	'phalanx-link-unblock' => 'unblock',
	'phalanx-link-modify' => 'modify',
	'phalanx-link-stats' => 'stats',
	'phalanx-reset-form' => 'Reset form',

	'phalanx-legend-input' => 'Create or modify filter',
	'phalanx-legend-listing' => 'Currently applied filters',
	'phalanx-unblock-message' => 'Block ID #$1 was successfully removed',

	'phalanx-help-type-content' => 'This filter prevents an edit from being saved, if its content matches any of the blacklisted phrases.',
	'phalanx-help-type-summary' => 'This filter prevents an edit from being saved, if the summary given matches any of the blacklisted phrases.',
	'phalanx-help-type-title' => 'This filter prevents a page from being created, if its title matches any of the blacklisted phrases.

	 It does not prevent a pre-existing page from being edited.',
	'phalanx-help-type-user' => 'This filter blocks a user (exactly the same as a local MediaWiki block), if the name or IP address matches one of the blacklisted names or IP addresses.',
	'phalanx-help-type-wiki-creation' => 'This filter prevents a wiki from being created, if its name or URL matches any blacklisted phrase.',
	'phalanx-help-type-answers-question-title' => 'This filter blocks a question (page) from being created, if its title matches any of the blacklisted phrases.

Note: only works on Answers-type wikis.',
	'phalanx-help-type-answers-recent-questions' => 'This filter prevents questions (pages) from being displayed in a number of outputs (widgets, lists, tag-generated listings).
It does not prevent those pages from being created.

Note: works only on Answers-type wiks.',
	'phalanx-help-type-user-email' => 'This filter prevents account creation using a blocked email address.',

	#block reason overrides, when no block reason was inputed (original usage)
	'phalanx-user-block-reason-ip' => 'This IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please [[Special:Contact|contact Wikia]].',
	'phalanx-user-block-reason-exact' => 'This username or IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption.
If you believe this is in error, please [[Special:Contact|contact Wikia]].',
	'phalanx-user-block-reason-similar' => 'This username is prevented from editing across the entire Wikia network due to vandalism or other disruption by a user with a similar name.
Please [[Special:Contact|contact Wikia]] about the problem.',
	'phalanx-user-block-new-account' => 'Username is not available for registration. Please choose another one.',

	#block reason overrides, worded to add the block reason
	'phalanx-user-block-withreason-ip' => 'This IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please [[Special:Contact|contact Wikia]].<br />The blocker also gave this additional reason: $1.',
	'phalanx-user-block-withreason-exact' => 'This username or IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption.
If you believe this is in error, please [[Special:Contact|contact Wikia]].<br />The blocker also gave this additional reason: $1.',
	'phalanx-user-block-withreason-similar' => 'This username is prevented from editing across the entire Wikia network due to vandalism or other disruption by a user with a similar name.
Please [[Special:Contact|contact Wikia]] about the problem.<br />The blocker also gave this additional reason: $1.',

	'phalanx-title-move-summary' => 'The reason you entered contained a blocked phrase.',
	'phalanx-content-spam-summary' => "The text was found in the page's summary.",

	'phalanx-stats-title' => 'Phalanx Stats',
	'phalanx-stats-block-notfound' => 'block ID not found',
	'phalanx-stats-table-id' => 'Block ID',
	'phalanx-stats-table-user' => 'Added by',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Created',
	'phalanx-stats-table-expire' => 'Expires',
	'phalanx-stats-table-exact' => 'Exact',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Case',
	'phalanx-stats-table-language' => 'Language',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Reason',
	'phalanx-stats-row' => "at $4, filter type '''$1''' blocked '''$2''' on $3",
	'phalanx-stats-row-per-wiki' => "user '''$2''' was blocked on '''$4''' by filter ID '''$3''' ($5) (type: '''$1''')",

	'phalanx-rule-log-name' => 'Phalanx rules log',
	'phalanx-rule-log-header' => 'This is a log of changes to phalanx rules.',
	'phalanx-email-rule-log-name' => 'Phalanx e-mail rules log',
	'phalanx-email-rule-log-header' => 'This is a log of changes to Phalanx rules for type e-mail.',
	'phalanx-rule-log-add' => 'Phalanx rule added: $1',
	'phalanx-rule-log-edit' => 'Phalanx rule edited: $1',
	'phalanx-rule-log-delete' => 'Phalanx rule deleted: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", type: "$2", reason: "$3"',

	'phalanx-stats-table-wiki-id' => 'Wiki ID',
	'phalanx-stats-table-wiki-name' => 'Wiki Name',
	'phalanx-stats-table-wiki-url' => 'Wiki URL',
	'phalanx-stats-table-wiki-last-edited' => 'Last edited',

	'phalanx-email-filter-hidden' => 'E-mail filter hidden. You do not have permission to view text.',

	'action-phalanx' => 'use the Integrated Spam Defense Mechanism',

	#permissions
	'right-phalanx' => 'Can manage global blocks and spam filters',
	'right-phalanxexempt' => 'Exempt from Phalanx rules',
	'right-phalanxemailblock' => 'Can file, view and manage e-mail based blocks',
);

/** Message documentation (Message documentation)
 * @author McDutchie
 * @author PtM
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'phalanx-type-title' => '{{Identical|Page title}}',
	'phalanx-type-user' => '{{Identical|User}}',
	'phalanx-add-block' => 'This message is used as a button label (like "Save", "Show preview" and "Show changes" in <code>action=edit</code>). Clicking on the button adds a new block to the Phalanx database. ([[Thread:Support/About_Wikia:Phalanx-add-block/fi/reply|documentation]] by [[User:Jack Phoenix|Jack Phoenix]])',
	'phalanx-label-filter' => '{{Identical|Filter}}',
	'phalanx-label-reason' => '{{Identical|Reason}}',
	'phalanx-label-expiry' => '{{Identical|Expiry}}',
	'phalanx-label-type' => '{{Identical|Type}}',
	'phalanx-label-lang' => '{{Identical|Language}}',
	'phalanx-format-text' => '{{Identical|Plain text}}',
	'phalanx-format-regex' => '{{Identical|Regex}}',
	'phalanx-test-submit' => '{{Identical|Test}}',
	'phalanx-link-unblock' => '{{Identical|Unblock}}',
	'phalanx-unblock-message' => '$1 is the ID of the block removed.',
	'phalanx-stats-table-create' => '{{Identical|Created}}',
	'phalanx-stats-table-expire' => '{{Identical|Expire}}',
	'phalanx-stats-table-regex' => '{{Identical|Regex}}',
	'phalanx-stats-table-language' => '{{Identical|Language}}',
	'phalanx-stats-table-text' => '{{Identical|Text}}',
	'phalanx-stats-table-reason' => '{{Identical|Reason}}',
	'phalanx-stats-row' => '$1 is a type of block (e.g. user or title), $2 is a user (name or IP), $3 is the URL of a wiki, $4 is a time and date',
	'phalanx-stats-row-per-wiki' => '$1 is a type of block (e.g. user or title), $2 is a user (name or IP), $3 is a filter ID, $4 is the URL of a wiki, $4 is a time and date, $5 is a link to stats for that filter ID',
	'phalanx-stats-table-wiki-name' => '{{Identical|Wiki name}}',
	'action-phalanx' => '{{doc-action|phalanx}}',
	'right-phalanx' => '{{doc-right|phalanx}}',
	'right-phalanxexempt' => '{{doc-right|phalanxexempt}}',
	'right-phalanxemailblock' => '{{doc-right|phalanxemailblock}}',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author OsamaK
 */
$messages['ar'] = array(
	'phalanx-desc' => 'فالانكس هو نظام دفاع مضاد للرسائل المزعجة',
	'phalanx' => 'فالانكس',
	'phalanx-title' => 'فالانكس - نظام دفاع مضاد للرسائل المزعجة',
	'phalanx-type-content' => 'محتوى الصفحة',
	'phalanx-type-summary' => 'ملخص الصفحة',
	'phalanx-type-title' => 'عنوان الصفحة',
	'phalanx-type-user' => 'مستخدم',
	'phalanx-type-user-email' => 'بريد إلكتروني',
	'phalanx-type-answers-question-title' => 'عنوان السؤال',
	'phalanx-type-answers-recent-questions' => 'الأسئلة الحديثة',
	'phalanx-type-wiki-creation' => 'إنشاء ويكي',
	'phalanx-add-block' => 'تطبيق المنع',
	'phalanx-edit-block' => 'حفظ المنع',
	'phalanx-label-filter' => 'مرشح:',
	'phalanx-label-reason' => 'السبب:',
	'phalanx-label-expiry' => 'انتهاء الصلاحية:',
	'phalanx-label-type' => 'النوع:',
	'phalanx-label-lang' => 'اللغة:',
	'phalanx-view-type' => 'نوع المنع...',
	'phalanx-view-blocker' => 'البحث بواسطة مرشح النصوص:',
	'phalanx-view-blocks' => 'مرشح البحث',
	'phalanx-view-id' => 'الترشيح حسب الرقم:',
	'phalanx-view-id-submit' => 'الترشيح',
	'phalanx-format-text' => 'نص عادي',
	'phalanx-format-regex' => 'رجاكس',
	'phalanx-format-case' => 'يتحسس حالة الأحرف',
	'phalanx-format-exact' => 'بالضبط',
	'phalanx-tab-main' => 'إدارة المرشحات',
	'phalanx-tab-secondary' => 'اختبار المرشحات',
	'phalanx-block-success' => 'تم إضافة المنع بنجاح',
	'phalanx-block-failure' => 'حدث خطأ أثناء إضافة المنع',
	'phalanx-modify-success' => 'تم تعديل المنع بنجاح',
	'phalanx-modify-failure' => 'حدث خطأ أثناء تعديل المنع',
	'phalanx-modify-warning' => 'أنت تقوم بتعديل المنع رقم #$1.
النقر فوق  "{{int:phalanx-edit-block}}" سوف يحفظ تغييراتك!',
	'phalanx-test-description' => 'النص الذي تم توفيره من قبل اختبار عمليات المنع الحالية',
	'phalanx-test-submit' => 'اختبار',
	'phalanx-test-results-legend' => 'نتائج الاختبار',
	'phalanx-display-row-blocks' => 'عمليات المنع: $1',
	'phalanx-display-row-created' => "تم إنشاؤها بواسطة ''''$1''' على $2",
	'phalanx-link-unblock' => 'الغاء المنع',
	'phalanx-link-modify' => 'تعديل',
	'phalanx-link-stats' => 'الحالة',
	'phalanx-reset-form' => 'إعادة تعيين النموذج',
	'phalanx-legend-input' => 'إنشاء أو تعديل مرشح',
	'phalanx-legend-listing' => 'المرشحات المطبقة حاليا',
	'phalanx-unblock-message' => 'تمت إزالة عملية المنع رقم #$1 بنجاح',
	'phalanx-help-type-content' => 'هذا المرشح يمنع عملية تحرير من أن يتم حفظها، إذا كان محتواها يتطابق مع أي من العبارات المدرجة في القائمة السوداء.',
	'phalanx-title-move-summary' => 'سبب المنع الذي أدخلته يحتوي على عبارة محظورة.',
	'phalanx-content-spam-summary' => 'تم العثور على النص في موجز للصفحة.',
	'phalanx-stats-title' => 'إحصائيات الفالانكس',
	'phalanx-stats-block-notfound' => 'لا يمكن العثور على رقم عملية المنع',
	'phalanx-stats-table-id' => 'رقم عملية المنع',
	'phalanx-stats-table-user' => 'أضيفت من قبل',
	'phalanx-stats-table-type' => 'النوع',
	'phalanx-stats-table-create' => 'تم إنشاؤه',
	'phalanx-stats-table-expire' => 'ينتهي في',
	'phalanx-stats-table-exact' => 'بالضبط',
	'phalanx-stats-table-regex' => 'رجاكس',
	'phalanx-stats-table-case' => 'الحالة',
	'phalanx-stats-table-language' => 'اللغة',
	'phalanx-stats-table-text' => 'النص',
	'phalanx-stats-table-reason' => 'السبب',
	'phalanx-stats-row' => "قام مرشح '''$1''' بمنع '''$2''' في $3 في $4",
	'phalanx-stats-row-per-wiki' => "تم منع المستخدم '''$2''' في '''$4''' من قبل المرشح رقم  '''$3''' ($5) (نوع: '''$1''')",
	'phalanx-rule-log-name' => 'سجل قواعد الفالانكس',
	'phalanx-rule-log-header' => 'هذا سجل بالتغييرات في قواعد الفالانكس.',
	'phalanx-email-rule-log-name' => 'سجل قواعد الفالانكس للبريد الإلكتروني.',
	'phalanx-email-rule-log-header' => 'هذا سجل للتغييرات الحاصلة على قواعد الفالانكس لنوع البريد الإلكتروني.',
	'phalanx-rule-log-add' => 'تمت إضافة قاعدة فالانكس: $1',
	'phalanx-rule-log-edit' => 'تم تعديل قاعدة فالانكس: $1',
	'phalanx-rule-log-delete' => 'تم حذف قاعدة فالانكس: $1',
	'phalanx-rule-log-details' => 'مرشح: "$1", نوع: "$2", سبب: "$3"',
	'phalanx-stats-table-wiki-id' => 'رقم الويكي',
	'phalanx-stats-table-wiki-name' => 'اسم الويكي',
	'phalanx-stats-table-wiki-url' => 'عنوان الويكي الإلكتروني (URL)',
	'phalanx-stats-table-wiki-last-edited' => 'آخر تعديل',
	'phalanx-email-filter-hidden' => 'مرشح البريد الإلكتروني مخفي. ليس لديك إذن لعرض النص.',
	'action-phalanx' => 'استخدام نظام الدفاع المضاد للرسائل المزعجة',
	'right-phalanx' => 'يمكن أن يدير عمليات منع عامة وترشيح الرسائل المزعجة',
	'right-phalanxexempt' => 'مستثناة من قواعد الفالانكس',
	'right-phalanxemailblock' => 'يمكنك ترتيب و عرض و إدارة عمليات منع البريد الإلكتروني',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'phalanx-type-user' => 'istifadəçi',
	'phalanx-label-reason' => 'Səbəb:',
	'phalanx-label-type' => 'Tipi:',
	'phalanx-label-lang' => 'Dil:',
	'phalanx-test-submit' => 'Test',
	'phalanx-stats-table-type' => 'Tipi',
	'phalanx-stats-table-language' => 'Dil',
	'phalanx-stats-table-text' => 'Mətn',
	'phalanx-stats-table-reason' => 'Səbəb',
	'phalanx-stats-table-wiki-name' => 'Viki adı',
	'phalanx-stats-table-wiki-url' => 'Viki URL',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'phalanx-label-reason' => 'Причина:',
	'phalanx-label-lang' => 'Език:',
	'phalanx-stats-table-language' => 'Език',
	'phalanx-stats-table-reason' => 'Причина',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'phalanx' => 'Phalanx',
	'phalanx-type-title' => 'anv ar bajenn',
	'phalanx-type-user' => 'implijer',
	'phalanx-type-user-email' => 'postel',
	'phalanx-type-answers-question-title' => 'titl ar goulenn',
	'phalanx-type-answers-recent-questions' => 'goulennoù graet nevez zo',
	'phalanx-type-wiki-creation' => 'Krouiñ ur wiki',
	'phalanx-edit-block' => "Enrollañ ar bloc'h",
	'phalanx-label-filter' => 'Sil :',
	'phalanx-label-reason' => 'Abeg :',
	'phalanx-label-expiry' => 'Termen :',
	'phalanx-label-type' => 'Seurt :',
	'phalanx-label-lang' => 'Yezh :',
	'phalanx-view-type' => "Seurt bloc'h...",
	'phalanx-view-blocker' => 'Klask dre silañ an destenn :',
	'phalanx-view-blocks' => 'Siloù enklask',
	'phalanx-view-id' => 'Silañ dre ID :',
	'phalanx-view-id-submit' => 'Tapout ur sil',
	'phalanx-format-text' => 'testenn blaen',
	'phalanx-format-exact' => 'rik',
	'phalanx-tab-main' => 'Merañ ar siloù',
	'phalanx-tab-secondary' => 'Amprouiñ ar siloù',
	'phalanx-test-submit' => 'Amprouiñ',
	'phalanx-test-results-legend' => "Disoc'hoù an amprouad",
	'phalanx-display-row-blocks' => 'stankadennoù : $1',
	'phalanx-display-row-created' => "krouet gant '''$1''' war $2",
	'phalanx-link-unblock' => 'distankañ',
	'phalanx-link-modify' => 'kemmañ',
	'phalanx-link-stats' => 'stadegoù',
	'phalanx-reset-form' => 'Adderaouekaat ar furmskrid',
	'phalanx-legend-input' => 'Krouiñ pe gemmañ ur sil',
	'phalanx-legend-listing' => 'Siloù implijet evit bremañ',
	'phalanx-unblock-message' => "Lamet eo bet ar bloc'h ID #$1",
	'phalanx-stats-title' => 'Stadegoù Phalanx',
	'phalanx-stats-table-id' => 'Stankañ an ID',
	'phalanx-stats-table-user' => 'Ouzhpennet gant',
	'phalanx-stats-table-type' => 'Seurt',
	'phalanx-stats-table-create' => 'Krouet',
	'phalanx-stats-table-exact' => 'Rik',
	'phalanx-stats-table-language' => 'Yezh',
	'phalanx-stats-table-text' => 'Testenn',
	'phalanx-stats-table-reason' => 'Abeg',
	'phalanx-rule-log-name' => 'Marilh ar reolennoù Phalanx',
	'phalanx-rule-log-header' => "Hemañ zo ur marilh eus ar c'hemmoù e reolennoù Phalanx.",
	'phalanx-rule-log-add' => 'Reolenn Phalanx ouzhpennet : $1',
	'phalanx-rule-log-edit' => 'Reolenn Phalanx aozet : $1',
	'phalanx-rule-log-delete' => 'Reolenn Phalanx dilamet : $1',
	'phalanx-rule-log-details' => 'Sil : "$1", seurt : "$2", abeg : "$3"',
	'phalanx-stats-table-wiki-id' => 'ID ar wiki',
	'phalanx-stats-table-wiki-name' => 'Anv ar wiki',
	'phalanx-stats-table-wiki-url' => 'URL ar wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Kemmet da ziwezhañ',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Light of Cosmos
 * @author Roxas Nobody 15
 */
$messages['ca'] = array(
	'phalanx-desc' => "Phalanx es un Mecanisme de Defensa Integrat contra l'Spam",
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Falange - mecanisme de defensa de Spam integrat',
	'phalanx-type-content' => 'contingut de la pàgina',
	'phalanx-type-summary' => 'pàgina de resum',
	'phalanx-type-title' => 'Nom de la pàgina',
	'phalanx-type-user' => 'Usuari',
	'phalanx-type-user-email' => 'Adreça electrònica',
	'phalanx-type-answers-question-title' => 'títol de pregunta',
	'phalanx-type-answers-recent-questions' => 'Preguntes recents',
	'phalanx-type-wiki-creation' => 'creació del wiki',
	'phalanx-add-block' => 'Aplicar bloqueig',
	'phalanx-edit-block' => 'Guardar bloqueig',
	'phalanx-label-filter' => 'Filtre',
	'phalanx-label-reason' => 'Raó:',
	'phalanx-label-expiry' => 'Caducitat:',
	'phalanx-label-type' => 'Tipus',
	'phalanx-label-lang' => 'Idioma:',
	'phalanx-view-type' => 'Tipo de bloqueig...',
	'phalanx-view-blocker' => 'Cerca pel filtre de text:',
	'phalanx-view-blocks' => 'Filtres de recerca',
	'phalanx-view-id' => 'Obtenir filtre per ID:',
	'phalanx-view-id-submit' => 'Prova el filtre',
	'phalanx-format-text' => 'Text net',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'sensible',
	'phalanx-format-exact' => 'exacte',
	'phalanx-tab-main' => 'Administra filtres',
	'phalanx-tab-secondary' => 'Prova el filtre',
	'phalanx-block-success' => 'El bloqueig va ser afegit correctament',
	'phalanx-block-failure' => 'Hi havia un error en afegir el bloqueig',
	'phalanx-modify-success' => 'El bloqueig va ser afegit correctament',
	'phalanx-modify-failure' => 'Hi havia un error en modificar el bloqueig',
	'phalanx-modify-warning' => 'Esteu editant bloqueig ID # $1 .
Si feu clic a "{{int:phalanx-editar-bloc}}" estalviarà els canvis!',
	'phalanx-test-description' => 'Prova el text que contra bloqueig actuals.',
	'phalanx-test-submit' => 'Prova',
	'phalanx-test-results-legend' => 'Resultats de les proves',
	'phalanx-display-row-blocks' => 'bloqueigs:$1',
	'phalanx-display-row-created' => "creada per ' ' $1 ' ' en$2",
	'phalanx-link-unblock' => 'Desbloqueja',
	'phalanx-link-modify' => 'modifica',
	'phalanx-link-stats' => 'Estadístiques',
	'phalanx-reset-form' => 'Reinicialitza el formulari',
	'phalanx-legend-input' => 'Crear o modificar el filtre',
	'phalanx-legend-listing' => 'Filtres actualment aplicades',
	'phalanx-unblock-message' => 'Bloc ID # $1  va ser retirat amb èxit',
	'phalanx-help-type-content' => 'Aquest filtre impedeix un editar desant, si el seu contingut coincideix amb qualsevol de les frases llista negra.',
	'phalanx-help-type-summary' => 'Aquest filtre impedeix un editar desant, si el resum donat coincideix amb alguna de les frases de llista negra.',
	'phalanx-help-type-title' => 'Aquest filtre impedeix una pàgina es va crear, si el seu títol coincideix amb alguna de les frases blacklisted.

	 Això no impedeix una pàgina preexistent editant.',
	'phalanx-help-type-user' => 'Aquest filtre bloqui un usuari (exactament el mateix que un bloc de MediaWiki locals), si el nom o adreça IP coincideix amb un dels noms de llista negra o adreces IP.',
	'phalanx-help-type-wiki-creation' => 'Aquest filtre impedeix un wiki es va crear, si la seva URL o el nom coincideixi amb qualsevol frase llista negra.',
	'phalanx-help-type-answers-question-title' => 'Aquest filtre bloqueja una pregunta (pàgina) des que es va crear, si el seu títol coincideix amb alguna de les frases de la llista negra.

Nota: només funciona en les Respostes-tipus de wikis.',
	'phalanx-help-type-answers-recent-questions' => "Aquest filtre preguntes (pàgines) impedeix ser mostrat en un nombre de sortides (widgets, llistes, llistats generats etiqueta).
Això no impedeix les pàgines s'està creant.

Nota: treballa només en les respostes de tipus wiks.",
	'phalanx-help-type-user-email' => "Aquest filtre impedeix la creació de compte utilitzant una adreça d'e-mail bloquejats.",
	'phalanx-user-block-reason-ip' => 'Aquesta adreça IP és impedir edició a través de tota la xarxa Wikia per vandalisme o altre interrupció per vostè o algú que comparteix la seva adreça IP.
Si vostè creu que això és error, si us plau [[Wikia especials: Contact|contact]].', # Fuzzy
	'phalanx-user-block-reason-exact' => "Aquest nom d'usuari o adreça d'IP és impedir edició a través de tota la xarxa Wikia per vandalisme o altre interrupció.
Si vostè creu que això és error, si us plau [[Wikia especials: Contact|contact]].", # Fuzzy
	'phalanx-user-block-reason-similar' => "Aquest nom d'usuari és impedir edició a través de tota la xarxa Wikia per vandalisme o altre interrupció per un usuari amb un nom semblant.
Si us plau [[especial: Contact|contact Wikia]] sobre el problema.", # Fuzzy
	'phalanx-user-block-new-account' => "Nom d'usuari no està disponible per a la matrícula. Si us plau, escolliu un altre.",
	'phalanx-user-block-withreason-ip' => 'Aquesta adreça IP és impedir edició a través de tota la xarxa Wikia per vandalisme o altre interrupció per vostè o algú que comparteix la seva adreça IP.
Si vostè creu que això és error, si us plau [[Wikia especials: Contact|contact]].<br>El blocker també va donar aquesta raó addicional:  $1 .', # Fuzzy
	'phalanx-user-block-withreason-exact' => 'Aquest usuari o adreça IP han estat bloquejats per editar en tota Wikia degut a vandalisme o altres molèsties causades. 
Si vostè creu que es tracta d\'un error, si us plau, [[Special:Contact|contacti amb Wikia]].<br />Raó addicional de bloqueig: <span class="notranslate" traduir="no">$1</span>.',
	'phalanx-user-block-withreason-similar' => "Aquest nom d'usuari te impedida  l´edició a través de tota la xarxa Wikia per vandalisme o altre interrupció per un usuari amb un nom semblant.
Si us plau [[especial: Contact|contact Wikia]] sobre el problema.<br>El blocker també va donar aquesta raó addicional:  $1 .", # Fuzzy
	'phalanx-title-move-summary' => 'La raó que heu introduït contenia una frase bloquejat.',
	'phalanx-content-spam-summary' => 'El text es trobava en el resum de la pàgina.',
	'phalanx-stats-title' => 'Estadístiques de Phalanx',
	'phalanx-stats-block-notfound' => 'bloc ID no es troba',
	'phalanx-stats-table-id' => 'Id. de bloqueig',
	'phalanx-stats-table-user' => 'Afegit per',
	'phalanx-stats-table-type' => 'Tipus',
	'phalanx-stats-table-create' => 'Creat',
	'phalanx-stats-table-expire' => 'Caduca',
	'phalanx-stats-table-exact' => 'exacte',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Sensible',
	'phalanx-stats-table-language' => 'Llengua',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Raó',
	'phalanx-stats-row' => 'a  $4 , tipus de filtre "" $1 "" bloquejat "\' $2 \' \' en$3',
	'phalanx-stats-row-per-wiki' => 'usuari "\' $2 " \' va ser bloquejat en \' \' $4 "\' per filtre ID" \' $3 \' \' ( $5 ) (tipus: "\' $1 " \')',
	'phalanx-rule-log-name' => 'Registre de normes de Phalanx',
	'phalanx-rule-log-header' => "Aquest és un registre dels canvis als noms d'usuari",
	'phalanx-email-rule-log-name' => 'Registre de correos a Phalanx',
	'phalanx-email-rule-log-header' => "Es tracta d'un registre de canvis en les regles per al correu electrònic Phalanx.",
	'phalanx-rule-log-add' => 'Regla de Phalanx posada: $1',
	'phalanx-rule-log-edit' => 'Regla de Phalanx editada: $1',
	'phalanx-rule-log-delete' => 'Regla de Phalanx suprimida: $1',
	'phalanx-rule-log-details' => 'Filtre: " $1 ", tipus: " $2 ", raó: " $3 "',
	'phalanx-stats-table-wiki-id' => 'Wiki ID',
	'phalanx-stats-table-wiki-name' => 'Nom del wiki',
	'phalanx-stats-table-wiki-url' => 'Wiki URL',
	'phalanx-stats-table-wiki-last-edited' => 'Última edició',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'phalanx-label-lang' => 'Мотт:',
	'phalanx-stats-table-expire' => 'Чекхйолу',
	'phalanx-stats-table-language' => 'Мотт',
	'phalanx-rule-log-details' => 'Литтар: "$1", тайп: "$2", бахьна: "$3"',
);

/** Czech (česky)
 * @author Chmee2
 */
$messages['cs'] = array(
	'phalanx-type-content' => 'obsah stránky',
	'phalanx-type-title' => 'název stránky',
	'phalanx-type-user' => 'uživatel',
	'phalanx-type-user-email' => 'e-mail',
	'phalanx-type-answers-question-title' => 'název otázky',
	'phalanx-type-answers-recent-questions' => 'poslední otázky',
	'phalanx-add-block' => 'Použít blok',
	'phalanx-edit-block' => 'Uložit blok',
	'phalanx-label-filter' => 'Filtr:',
	'phalanx-label-reason' => 'Důvod:',
	'phalanx-label-expiry' => 'Čas vypršení:',
	'phalanx-label-type' => 'Typ:',
	'phalanx-label-lang' => 'Jazyk:',
	'phalanx-view-type' => 'Typ bloku...',
	'phalanx-view-blocks' => 'Vyhledávací filtry',
	'phalanx-test-submit' => 'Test',
	'phalanx-link-unblock' => 'odblokovat',
	'phalanx-link-modify' => 'změnit',
	'phalanx-link-stats' => 'statistiky',
	'phalanx-stats-table-id' => 'ID bloku',
	'phalanx-stats-table-type' => 'Typ',
	'phalanx-stats-table-create' => 'Vytvořeno',
	'phalanx-stats-table-expire' => 'Vyprší',
	'phalanx-stats-table-exact' => 'Přesný',
	'phalanx-stats-table-language' => 'Jazyk',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Důvod',
	'phalanx-stats-table-wiki-id' => 'ID wiki',
	'phalanx-stats-table-wiki-name' => 'Název wiki',
	'phalanx-stats-table-wiki-url' => 'Adresa URL wiki',
);

/** Welsh (Cymraeg)
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'phalanx-type-user' => 'defnyddiwr',
	'phalanx-type-user-email' => 'e-bost',
	'phalanx-label-lang' => 'Iaith:',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author DaSch
 * @author Geitost
 * @author George Animal
 * @author LWChris
 * @author PtM
 * @author SVG
 */
$messages['de'] = array(
	'phalanx-desc' => 'Phalanx ist ein integrierter Spam-Verteidigungs-Mechanismus',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrierter Spam-Verteidigungs-Mechanismus',
	'phalanx-type-content' => 'Seiteninhalt',
	'phalanx-type-summary' => 'Zusammenfassung',
	'phalanx-type-title' => 'Seitentitel',
	'phalanx-type-user' => 'Benutzer',
	'phalanx-type-user-email' => 'E-Mail',
	'phalanx-type-answers-question-title' => 'Frage-Titel',
	'phalanx-type-answers-recent-questions' => 'Kürzliche Fragen',
	'phalanx-type-wiki-creation' => 'Wiki-Erstellung',
	'phalanx-add-block' => 'Sperre anwenden',
	'phalanx-edit-block' => 'Sperre speichern',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Grund:',
	'phalanx-label-expiry' => 'Sperrdauer:',
	'phalanx-label-type' => 'Typ:',
	'phalanx-label-lang' => 'Sprache:',
	'phalanx-view-type' => 'Art der Sperre...',
	'phalanx-view-blocker' => 'Suche nach Filtertext:',
	'phalanx-view-blocks' => 'Suchfilter',
	'phalanx-view-id' => 'Filter nach ID:',
	'phalanx-view-id-submit' => 'Hole Filter',
	'phalanx-format-text' => 'Klartext',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'Groß- und Kleinschreibung',
	'phalanx-format-exact' => 'genau',
	'phalanx-tab-main' => 'Filter verwalten',
	'phalanx-tab-secondary' => 'Filter testen',
	'phalanx-block-success' => 'Die Sperre wurde erfolgreich hinzugefügt',
	'phalanx-block-failure' => 'Es gab einen Fehler beim Hinzufügen der Sperre',
	'phalanx-modify-success' => 'Die Sperre wurde erfolgreich geändert',
	'phalanx-modify-failure' => 'Es gab einen Fehler beim Ändern der Sperre',
	'phalanx-modify-warning' => 'Du bearbeitest die Sperre mit der ID #$1.
Ein Klick auf „{{int:phalanx-edit-block}}“ speichert deine Änderungen!',
	'phalanx-test-description' => 'Teste gegebenen Text mit aktuellen Sperren.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Testergebnisse',
	'phalanx-display-row-blocks' => 'Sperren: $1',
	'phalanx-display-row-created' => "erstellt von '''$1''' um $2",
	'phalanx-link-unblock' => 'entsperren',
	'phalanx-link-modify' => 'ändern',
	'phalanx-link-stats' => 'Statistiken',
	'phalanx-reset-form' => 'Formular leeren',
	'phalanx-legend-input' => 'Filter erstellen oder ändern',
	'phalanx-legend-listing' => 'Derzeit angewandte Filter',
	'phalanx-unblock-message' => 'Die Sperre mit der ID #$1 wurde erfolgreich entfernt',
	'phalanx-help-type-content' => 'Dieser Filter verhindert das Speichern einer Bearbeitung, falls ihr Inhalt auf einen Eintrag in der schwarzen Liste passt.',
	'phalanx-help-type-summary' => 'Dieser Filter verhindert das Speichern einer Bearbeitung, falls die Zusammenfassung auf einen Eintrag in der schwarzen Liste passt.',
	'phalanx-help-type-title' => 'Dieser Filter verhindert das Erstellen einer Seite, falls ihr Name auf einen Eintrag in der schwarzen Liste passt.

Er verhindert nicht die Bearbeitung einer bereits vorhandenen Seite.',
	'phalanx-help-type-user' => 'Dieser Filter blockiert einen Benutzer (genauso wie eine lokale MediaWiki-Sperre), wenn der Name oder die IP-Adresse mit einem Eintrag in der schwarzen Liste übereinstimmt.',
	'phalanx-help-type-wiki-creation' => 'Dieser Filter verhindert die Erstellung eines Wikis, falls sein Name oder seine URL auf einen Eintrag in der schwarzen Liste passt.',
	'phalanx-help-type-answers-question-title' => 'Dieser Filter verhindert die Erstellung einer Frage (Seite), falls ihr Titel auf einen Eintrag in der schwarzen Liste passt.

Anmerkung: funktioniert nur für Wikis vom Typ Answers.',
	'phalanx-help-type-answers-recent-questions' => 'Dieser Filter verhindert die Anzeige einer Frage (Seite) in einer Anzahl von Ausgängen (Widgets, Listen, Tag-generierte Auflistungen).

Anmerkung: funktioniert nur für Wikis vom Typ Answers.',
	'phalanx-help-type-user-email' => 'Dieser Filter verhindert die Kontoerstellung über eine blockierte E-Mail-Adresse.',
	'phalanx-user-block-reason-ip' => 'Aufgrund von Vandalismus oder anderem Fehlverhalten durch dich oder jemanden, der deine IP-Adresse mitnutzt, wurde dieser IP-Adresse das Schreibrecht entzogen. Dies gilt für das gesamte Wikia-Netzwerk.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[Special:Contact|kontaktiere Wikia]]!',
	'phalanx-user-block-reason-exact' => 'Diesem Benutzernamen oder dieser IP-Adresse ist das Schreiben – aufgrund von Vandalismus oder anderem Fehlverhalten – im gesamten Wikia-Netzwerk verboten worden.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, dann [[Special:Contact|kontaktiere Wikia]]!',
	'phalanx-user-block-reason-similar' => 'Aufgrund von Ähnlichkeit mit dem Benutzernamen eines für Vandalismus oder anderes Fehlverhalten gesperrten Benutzers wurde auch diesem Benutzerkonto das Schreibrecht im gesamten Wikia-Netzwerk entzogen.
Bitte [[Special:Contact|kontaktiere Wikia]] im Falle eines Versehens!',
	'phalanx-user-block-new-account' => 'Dieser Benutzername ist zur Registrierung nicht verfügbar. Bitte wähle einen anderen.',
	'phalanx-user-block-withreason-ip' => 'Aufgrund von Vandalismus oder anderem Fehlverhalten durch dich oder jemanden, der deine IP-Adresse mitnutzt, wurde dieser IP-Adresse das Schreibrecht entzogen. Dies gilt für das gesamte Wikia-Netzwerk.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[Special:Contact|kontaktiere Wikia]]!<br />Als Sperrgrund wurde Folgendes angegeben: $1',
	'phalanx-user-block-withreason-exact' => 'Diesem Benutzernamen oder dieser IP-Adresse ist das Schreiben – aufgrund von Vandalismus oder anderem Fehlverhalten – im gesamten Wikia-Netzwerk verboten worden.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, dann [[Special:Contact|kontaktiere Wikia]]!<br />Als Sperrgrund wurde Folgendes angegeben: $1',
	'phalanx-user-block-withreason-similar' => 'Aufgrund von Ähnlichkeit mit dem Benutzernamen eines für Vandalismus oder anderes Fehlverhalten gesperrten Benutzers wurde auch diesem Benutzerkonto das Schreibrecht im gesamten Wikia-Netzwerk entzogen.
Bitte [[Special:Contact|kontaktiere Wikia]] im Falle eines Versehens!<br />Als Sperrgrund wurde Folgendes angegeben: $1',
	'phalanx-title-move-summary' => 'Der von dir eingegebene Grund enthält eine gesperrte Phrase.',
	'phalanx-content-spam-summary' => 'Der Text wurde in der Zusammenfassung gefunden.',
	'phalanx-stats-title' => 'Phalanx Statistik',
	'phalanx-stats-block-notfound' => 'Sperr-ID nicht gefunden',
	'phalanx-stats-table-id' => 'Sperr-ID',
	'phalanx-stats-table-user' => 'Hinzugefügt von',
	'phalanx-stats-table-type' => 'Art',
	'phalanx-stats-table-create' => 'Erstellt',
	'phalanx-stats-table-expire' => 'Gültig bis',
	'phalanx-stats-table-exact' => 'Genau',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Groß-/Kleinschreibung',
	'phalanx-stats-table-language' => 'Sprache',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Grund',
	'phalanx-stats-row' => "$4 wurde '''$2''' auf '''$3''' von Filtertyp '''$1''' geblockt",
	'phalanx-stats-row-per-wiki' => "Benutzer '''$2''' wurde am '''$4''' von Filter ID '''$3''' ($5) geblockt (Typ: '''$1''')",
	'phalanx-rule-log-name' => 'Phalanx Regel-Log',
	'phalanx-rule-log-header' => 'Dies ist ein Logbuch der Änderungen an Phalanx Regeln.',
	'phalanx-email-rule-log-name' => 'Phalanx-Mailregeln-Logbuch',
	'phalanx-email-rule-log-header' => 'Dies ist ein Logbuch zu Änderungen der Phalanx-Regeln des Typs E-Mail.',
	'phalanx-rule-log-add' => 'Phalanx Regel hinzugefügt: $1',
	'phalanx-rule-log-edit' => 'Phalanx Regel bearbeitet: $1',
	'phalanx-rule-log-delete' => 'Phalanx Regel gelöscht: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", Typ: "$2", Grund: "$3"',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wikiname',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Zuletzt bearbeitet',
	'phalanx-email-filter-hidden' => 'E-Mail Filter ausgeblendet. Keine Berechtigung zum Anzeigen des Textes.',
	'action-phalanx' => 'den Integrated Spam Defense Mechanism verwenden',
	'right-phalanx' => 'Kann globale Benutzersperren und Spamfilter verwalten',
	'right-phalanxexempt' => 'Von Phalanx-Regelungen ausgenommen',
	'right-phalanxemailblock' => 'Kann E-Mail-bezogene Sperren ordnen, einsehen und bearbeiten',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author Geitost
 */
$messages['de-formal'] = array(
	'phalanx-modify-warning' => 'Sie bearbeiten die Sperre mit der ID #$1.
Ein Klick auf „{{int:phalanx-edit-block}}“ speichert Ihre Änderungen!',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'phalanx' => 'Falanc',
	'phalanx-type-user' => 'karber',
	'phalanx-type-user-email' => 'E-posta',
	'phalanx-label-filter' => 'Avrêc:',
	'phalanx-label-reason' => 'Sebeb:',
	'phalanx-label-expiry' => 'Qediyayış:',
	'phalanx-label-type' => 'Babet:',
	'phalanx-test-submit' => 'Test',
	'phalanx-stats-table-type' => 'Babet',
	'phalanx-stats-table-create' => 'Vıraziya',
	'phalanx-stats-table-language' => 'Zıwan',
	'phalanx-stats-table-text' => 'nuşte',
	'phalanx-stats-table-reason' => 'Sebeb',
	'phalanx-stats-table-wiki-id' => 'Wiki ID',
	'phalanx-stats-table-wiki-name' => 'Wiki Name',
	'phalanx-stats-table-wiki-url' => 'Wiki URL',
);

/** Spanish (español)
 * @author Fitoschido
 * @author Mor
 * @author VegaDark
 */
$messages['es'] = array(
	'phalanx-desc' => 'Phalanx es un Mecanismo de Defensa Integrado contra Spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mecanismo de Defensa Integrado contra Spam',
	'phalanx-type-content' => 'contenido de artículo',
	'phalanx-type-summary' => 'resumen de artículo',
	'phalanx-type-title' => 'título de artículo',
	'phalanx-type-user' => 'usuario',
	'phalanx-type-user-email' => 'correo',
	'phalanx-type-answers-question-title' => 'título de pregunta',
	'phalanx-type-answers-recent-questions' => 'preguntas recientes',
	'phalanx-type-wiki-creation' => 'creación de wiki',
	'phalanx-add-block' => 'Aplicar bloqueo',
	'phalanx-edit-block' => 'Guardar bloqueo',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Caduca:',
	'phalanx-label-type' => 'Tipo:',
	'phalanx-label-lang' => 'Idioma:',
	'phalanx-view-type' => 'Tipo de bloqueo...',
	'phalanx-view-blocker' => 'Buscar por texto de filtro:',
	'phalanx-view-blocks' => 'Buscar filtros',
	'phalanx-view-id' => 'Obtener filtro por ID:',
	'phalanx-view-id-submit' => 'Obtener filtro',
	'phalanx-format-text' => 'texto plano',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'sensible',
	'phalanx-format-exact' => 'exacto',
	'phalanx-tab-main' => 'Administrar filtros',
	'phalanx-tab-secondary' => 'Probar filtros',
	'phalanx-block-success' => 'El bloqueo fue añadido satisfactoriamente.',
	'phalanx-block-failure' => 'Ha ocurrido un error mientras se añadía el bloqueo.',
	'phalanx-modify-success' => 'El bloqueo fue modificado satisfactoriamente.',
	'phalanx-modify-failure' => 'A ocurrido un error para modificar el bloqueo.',
	'phalanx-modify-warning' => 'Estás editando el bloqueo ID #$1.
¡Hacer clic en "{{int:phalanx-add-block}}" guardará tus cambios!',
	'phalanx-test-description' => 'Prueba de texto contra bloqueos actuales.',
	'phalanx-test-submit' => 'Prueba',
	'phalanx-test-results-legend' => 'Resultados de la prueba',
	'phalanx-display-row-blocks' => 'bloqueos: $1',
	'phalanx-display-row-created' => "creado por '''$1''' a las $2",
	'phalanx-link-unblock' => 'desbloquear',
	'phalanx-link-modify' => 'modificar',
	'phalanx-link-stats' => 'estadísticas',
	'phalanx-reset-form' => 'Resetear formulario',
	'phalanx-legend-input' => 'Crear o modificar filtro',
	'phalanx-legend-listing' => 'Filtros aplicados actualmente',
	'phalanx-unblock-message' => 'El ID de bloqueo #$1 fue eliminado satisfactoriamente.',
	'phalanx-help-type-content' => 'Este filtro evita que una edición sea guardada, si su contenido concuerda con alguna frase bloqueada.',
	'phalanx-help-type-summary' => 'Este filtro evita que una edición sea guardada, si el resumen de edición concuerda con alguna frase bloqueada.',
	'phalanx-help-type-title' => 'Este filtro evita que una página sea creada, si el título concuerda con alguna frase bloqueada.

No evitará que las páginas previamente existentes sean editadas.',
	'phalanx-help-type-user' => 'Este filtro bloquea a un usuario (exactamente igual que Especial:Bloquear de las wikis), si el nombre de usuario o la IP concuerdan con una cuenta o IP bloqueada.',
	'phalanx-help-type-wiki-creation' => 'Este filtro evita que una wiki sea creada, si su nombre contiene alguna frase bloqueada.',
	'phalanx-help-type-answers-question-title' => 'Este filtro bloquea una pregunta (página) de ser creada, si su título concuerda con cualquiera de las frases.

Nota: solo trabaja en wikis tipo answers.',
	'phalanx-help-type-answers-recent-questions' => 'Este filtro previene que las preguntas sean mostradas en los widgets, listas, etiquetas, etc. No previene que esas páginas sean creadas.

Nota: solo trabaja en wikis tipo answers.',
	'phalanx-help-type-user-email' => 'Este filtro evita el registro de cuentas usando un correo electrónico bloqueado.',
	'phalanx-user-block-reason-ip' => 'Esta dirección IP ha sido bloqueada para editar en toda Wikia debido a vandalismo, spam u otro problema por ti u otra persona quien comparte la misma dirección IP.
Si crees que es un error, por favor [[Special:Contact|contacta a Wikia]].',
	'phalanx-user-block-reason-exact' => 'Este nombre de usuario o dirección IP ha sido bloqueado para editar en toda Wikia debido a vandalismo, spam u otro problema por ti u otra persona quien comparte la misma dirección IP.
Si crees que es un error, por favor [[Special:Contact|contacta a Wikia]].',
	'phalanx-user-block-reason-similar' => 'Este nombre de usuario ha sido bloqueado para editar en toda Wikia debido a vandalismo, spam u otro problema por ti u otra persona quien comparte la misma dirección IP.
Si crees que es un error, por favor [[Special:Contact|contacta a Wikia]].',
	'phalanx-user-block-new-account' => 'El nombre de usuario no está disponible para su registro. Por favor, selecciona otro.',
	'phalanx-user-block-withreason-ip' => 'Esta dirección IP ha sido bloqueada para editar en toda Wikia debido a vandalismo, spam u otro problema por ti u otra persona quien comparte la misma dirección IP.
Si crees que es un error, por favor [[Special:Contact|contacta a Wikia]].<br />El que hizo el bloqueo ha dado este motivo adicional: $1.',
	'phalanx-user-block-withreason-exact' => 'Este nombre de usuario ha sido bloqueado para editar en toda Wikia debido a vandalismo, spam u otro problema.
Si crees que es un error, por favor [[Special:Contact|contacta a Wikia]].<br />El que hizo el bloqueo ha dado este motivo adicional: $1.',
	'phalanx-user-block-withreason-similar' => 'Este nombre de usuario ha sido bloqueado para editar en toda Wikia debido a vandalismo, spam u otro problema por ti u otra persona con un nombre similar.
Si crees que es un error, por favor [[Special:Contact|contacta a Wikia]].<br />El que hizo el bloqueo ha dado este motivo adicional: $1.',
	'phalanx-title-move-summary' => 'El resumen que ingresaste contiene una frase bloqueada.',
	'phalanx-content-spam-summary' => 'El texto fue encontrado en el resumen de la página.',
	'phalanx-stats-title' => 'Estadísticas de Phalanx',
	'phalanx-stats-block-notfound' => 'ID de bloqueo no encontrado',
	'phalanx-stats-table-id' => 'Id. de bloqueo',
	'phalanx-stats-table-user' => 'Añadido por',
	'phalanx-stats-table-type' => 'Tipo',
	'phalanx-stats-table-create' => 'Creado',
	'phalanx-stats-table-expire' => 'Caduca',
	'phalanx-stats-table-exact' => 'Exacto',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Sensible',
	'phalanx-stats-table-language' => 'Idioma',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
	'phalanx-stats-row' => "a las $4, el filtro '''$1''' bloqueó a '''$2''' en $3",
	'phalanx-stats-row-per-wiki' => "usuario '''$2''' fue bloqueado en '''$4''' por el filtro ID '''$3''' ($5) (tipo: '''$1''')",
	'phalanx-rule-log-name' => 'Registro de reglas de Phalanx',
	'phalanx-rule-log-header' => 'Este es un registro de cambios a las reglas de Phalanx.',
	'phalanx-email-rule-log-name' => 'Registro de correos en Phalanx',
	'phalanx-email-rule-log-header' => 'Este es un registro de cambios de correos en las reglas de Phalanx.',
	'phalanx-rule-log-add' => 'Regla de Phalanx añadida: $1',
	'phalanx-rule-log-edit' => 'Regla de Phalanx editada: $1',
	'phalanx-rule-log-delete' => 'Reglas de Phalanx borrada: $1',
	'phalanx-rule-log-details' => 'Filtro: "$1", tipo: "$2", motivo: "$3"',
	'phalanx-stats-table-wiki-id' => 'Id. del wiki',
	'phalanx-stats-table-wiki-name' => 'Nombre de wiki',
	'phalanx-stats-table-wiki-url' => 'URL de wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Última edición',
	'phalanx-email-filter-hidden' => 'Filtro de correo ocultado. No tienes permisos para ver el texto.',
	'action-phalanx' => 'utilizar el Mecanismo de Defensa Integrado contra Spam',
	'right-phalanx' => 'Puede administrar bloqueos globales y filtros de spam',
	'right-phalanxexempt' => 'Exento de las reglas de Phalanx',
	'right-phalanxemailblock' => 'Crear, ver y administrar bloqueos de correos',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Nedergard
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'phalanx' => 'Phalanx',
	'phalanx-type-content' => 'sivun sisältö',
	'phalanx-type-summary' => 'sivun yhteenveto',
	'phalanx-type-title' => 'sivun otsikko',
	'phalanx-type-user' => 'käyttäjä',
	'phalanx-type-user-email' => 'sähköpostiosoite',
	'phalanx-type-answers-question-title' => 'kysymysotsikko',
	'phalanx-type-answers-recent-questions' => 'tuoreet kysymykset',
	'phalanx-type-wiki-creation' => 'wiki-luominen',
	'phalanx-add-block' => 'Toteuta esto',
	'phalanx-edit-block' => 'Tallenna esto',
	'phalanx-label-filter' => 'Suodatin:',
	'phalanx-label-reason' => 'Syy:',
	'phalanx-label-expiry' => 'Kesto:',
	'phalanx-label-type' => 'Tyyppi:',
	'phalanx-label-lang' => 'Kieli:',
	'phalanx-view-type' => 'Eston tyyppi...',
	'phalanx-view-blocks' => 'Hakusuodattimet',
	'phalanx-view-id' => 'Hae suodatinta tunnisteella:',
	'phalanx-view-id-submit' => 'Nouda suodatin',
	'phalanx-format-text' => 'muotoilematon teksti',
	'phalanx-format-case' => 'kirjainkoko on merkitsevä',
	'phalanx-format-exact' => 'tarkka',
	'phalanx-tab-main' => 'Suodattimien hallinta',
	'phalanx-tab-secondary' => 'Kokeile suodatinta',
	'phalanx-modify-warning' => 'Muokkaat estoa, jonka tunniste on $1.
Tallenna muutoksesi napsauttamalla {{int:phalanx-edit-block}}.',
	'phalanx-test-submit' => 'Testi',
	'phalanx-test-results-legend' => 'Testitulokset',
	'phalanx-display-row-blocks' => 'estot: $1',
	'phalanx-link-unblock' => 'poista esto',
	'phalanx-link-modify' => 'muokkaa',
	'phalanx-link-stats' => 'tilastot',
	'phalanx-reset-form' => 'Tyhjennä lomake',
	'phalanx-legend-input' => 'Luo tai muokkaa suodatinta',
	'phalanx-legend-listing' => 'Tällä hetkellä käytetyt suodattimet',
	'phalanx-unblock-message' => 'Estotunnisteen #$1 poisto onnistui',
	'phalanx-user-block-reason-exact' => 'Tämä käyttäjätunnus tai IP-osoite on estetty ilkivallan tai muunlaisen häiriköinnin vuoksi.
Jos tämä on mielestäsi virhe, ole hyvä ja [[Special:Contact|ota yhteyttä Wikiaan]].', # Fuzzy
	'phalanx-stats-table-user' => 'Lisääjä',
	'phalanx-stats-table-type' => 'Tyyppi',
	'phalanx-stats-table-create' => 'Luotu',
	'phalanx-stats-table-language' => 'Kieli',
	'phalanx-stats-table-text' => 'Teksti',
	'phalanx-stats-table-reason' => 'Syy',
	'phalanx-stats-table-wiki-id' => 'Wikin tunniste',
	'phalanx-stats-table-wiki-name' => 'Wikin nimi',
	'phalanx-stats-table-wiki-url' => 'Wikin verkko-osoite',
);

/** French (français)
 * @author Balzac 40
 * @author Brunoperel
 * @author Crochet.david
 * @author Gomoko
 * @author Iketsi
 * @author McDutchie
 * @author Od1n
 * @author Urhixidur
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'phalanx-desc' => 'Phalanx est un mécanisme de défense contre les courriers indésirables intégré',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mécanisme intégré de défense contre le spam',
	'phalanx-type-content' => 'contenu de la page',
	'phalanx-type-summary' => 'résumé de la page',
	'phalanx-type-title' => 'titre de la page',
	'phalanx-type-user' => 'utilisateur',
	'phalanx-type-user-email' => 'courriel',
	'phalanx-type-answers-question-title' => 'titre de la question',
	'phalanx-type-answers-recent-questions' => 'questions récentes',
	'phalanx-type-wiki-creation' => 'Création de wiki',
	'phalanx-add-block' => 'Appliquer le bloc',
	'phalanx-edit-block' => 'Sauvegarder le bloc',
	'phalanx-label-filter' => 'Filtre :',
	'phalanx-label-reason' => 'Motif :',
	'phalanx-label-expiry' => 'Expiration :',
	'phalanx-label-type' => 'Type :',
	'phalanx-label-lang' => 'Langue :',
	'phalanx-view-type' => 'Type de blocage...',
	'phalanx-view-blocker' => 'Rechercher par filtrage de texte :',
	'phalanx-view-blocks' => 'Filtres de recherche',
	'phalanx-view-id' => 'Filtrer par ID :',
	'phalanx-view-id-submit' => 'Filtrer',
	'phalanx-format-text' => 'texte brut',
	'phalanx-format-regex' => 'expression rationnelle',
	'phalanx-format-case' => 'sensible à la casse',
	'phalanx-format-exact' => 'exact',
	'phalanx-tab-main' => 'Gérer les filtres',
	'phalanx-tab-secondary' => 'Tester les filtres',
	'phalanx-block-success' => 'Le blocage a été ajouté avec succès',
	'phalanx-block-failure' => 'Une erreur est survenue durant l’ajout du blocage',
	'phalanx-modify-success' => 'Le blocage a été modifié avec succès',
	'phalanx-modify-failure' => 'Une erreur est survenue durant la modification du blocage',
	'phalanx-modify-warning' => 'Vous éditez le bloc d\'identifiant #$1.
En cliquant sur "{{int:phalanx-add-block}}" vos modifications seront enregistrées.',
	'phalanx-test-description' => 'Texte fourni par le test contre les blocages actuels.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Résultats des essais',
	'phalanx-display-row-blocks' => 'blocages : $1',
	'phalanx-display-row-created' => "créé par '''$1''' sur $2",
	'phalanx-link-unblock' => 'débloquer',
	'phalanx-link-modify' => 'modifier',
	'phalanx-link-stats' => 'stats',
	'phalanx-reset-form' => 'Réinitialiser le formulaire',
	'phalanx-legend-input' => 'Créer ou modifier le filtre',
	'phalanx-legend-listing' => 'Filtres actuellement utilisés',
	'phalanx-unblock-message' => "Le bloc d'identifiant #$1 a été supprimé avec succès",
	'phalanx-help-type-content' => "Ce filtre empêche une édition d'être enregistrée si son contenu correspond avec une des expressions contenues dans la liste noire.",
	'phalanx-help-type-summary' => "Ce filtre empêche une édition d'être enregistrée si son résumé correspond avec une des expressions contenues dans la liste noire.",
	'phalanx-help-type-title' => "Ce filtre empêche une page d'être créée si son titre correspond à une des expressions contenues dans la liste noire.

Il n'empêche pas l'édition d'une page existante.",
	'phalanx-help-type-user' => "Ce filtre bloque un utilisateur (exactement le même qu'un bloc local MediaWiki), si le nom ou l'adresse IP correspond à l'un des noms ou l'une des adresses IP sur la liste noire.",
	'phalanx-help-type-wiki-creation' => "Ce filtre empêche la création d'un wiki si son nom ou son URL correspond à une des expressions contenues dans la liste noire.",
	'phalanx-help-type-answers-question-title' => "Ce filtre bloque la création d'une question (page) si son titre correspond à une des expressions de la liste noire.

Note: Ne fonctionne que sur les wikis de type Answers.",
	'phalanx-help-type-answers-recent-questions' => 'Ce filtre empêche des questions (pages) d’être affichées dans un certains nombre de sorties (widgets, listes, énumérations générées par balise).
Il n’empêche pas ces pages d’être créées.

Note : cela ne fonctionne que sur les wikis de type Réponses.',
	'phalanx-help-type-user-email' => 'Ce filtre empêche la création de compte en utilisant une adresse de courriel bloquée.',
	'phalanx-user-block-reason-ip' => 'Cette adresse IP n’a pas les droits de modification dans le réseau entier Wikia en raison de vandalisme ou autres méfaits analogues commis par vous ou par quelqu’un d’autre qui partage cette adresse IP.
Si vous pensez qu’il s’agit d’une erreur, [[Special:Contact|Contacter Wikia]].',
	'phalanx-user-block-reason-exact' => 'Ce nom d’utilisateur ou cette adresse IP est interdit de toute modification sur l’intégralité du réseau Wikia en raison de vandalisme ou d’autres perturbations.
Si vous pensez qu’il s’agit d’une erreur, veuillez [[Special:Contact|contacter Wikia]].',
	'phalanx-user-block-reason-similar' => 'Ce nom d’utilisateur est interdit de toute modification dans l’intégralité du réseau Wikia en raison de vandalisme ou d’autres perturbations par un utilisateur de nom similaire.
Veuillez [[Special:Contact|contacter Wikia]] à propos de ce problème.',
	'phalanx-user-block-new-account' => "Le nom d'utilisateur n'est pas disponible pour enregistrement. Veuillez en choisir un autre.",
	'phalanx-user-block-withreason-ip' => 'Cette adresse IP n’a pas les droits de modification dans le réseau entier Wikia en raison de vandalisme ou autres méfaits analogues commis par vous ou par quelqu’un d’autre qui partage cette adresse IP.
Si vous pensez qu’il s’agit d’une erreur, [[Special:Contact|Contacter Wikia]].<br />La personne qui vous a bloqué a également donné ce motif : $1.',
	'phalanx-user-block-withreason-exact' => "Ce nom d'utilisateur ou cette adresse IP est interdit de toute modification dans l’intégralité du réseau Wikia en raison de vandalisme ou d’autres perturbations.
Si vous pensez qu’il s’agit d’une erreur, veuillez [[Special:Contact|contacter Wikia]].<br />La personne qui a mis en place ce blocage a également donné ce motif supplémentaire : $1.",
	'phalanx-user-block-withreason-similar' => "Ce nom d'utilisateur n’a pas les droits de modification dans le réseau Wikia en raison de vandalisme ou autres méfaits analogues commis par vous ou quelqu’un d’autre partageant cette adresse IP.
Veuillez [[Special:Contact|contacter Wikia]] à propos de ce problème.<br />La personne qui vous a bloqué a également donné ce motif : $1.",
	'phalanx-title-move-summary' => 'Le motif que vous avez inscrit contenait une phrase bloquée.',
	'phalanx-content-spam-summary' => 'Le texte a été trouvé dans le résumé de la page.',
	'phalanx-stats-title' => 'Statistiques Phalanx',
	'phalanx-stats-block-notfound' => 'Identifiant de bloc non trouvé',
	'phalanx-stats-table-id' => 'Identifiant de bloc',
	'phalanx-stats-table-user' => 'Ajouté par',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Créé le',
	'phalanx-stats-table-expire' => 'Expire le',
	'phalanx-stats-table-exact' => 'Exact',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Casse',
	'phalanx-stats-table-language' => 'Langue',
	'phalanx-stats-table-text' => 'Texte',
	'phalanx-stats-table-reason' => 'Motif',
	'phalanx-stats-row' => "à $4, le type de filtre '''$1''' a bloqué '''$2''' sur $3",
	'phalanx-stats-row-per-wiki' => "L'utilisateur '''$2''' a été bloqué sur '''$4''' par le filtre d'identifiant '''$3''' ($5) (type: '''$1''')",
	'phalanx-rule-log-name' => 'Journal des règles Phalanx',
	'phalanx-rule-log-header' => 'Ceci est un journal des changements de règles de Phalanx.',
	'phalanx-email-rule-log-name' => 'Journal des règles de courriel Phalanx',
	'phalanx-email-rule-log-header' => 'Voici un journal des changements des règles Phalanx pour le type de courriel.',
	'phalanx-rule-log-add' => 'Règle Phalanx ajoutée: $1',
	'phalanx-rule-log-edit' => 'Règle Phalanx éditée: $1',
	'phalanx-rule-log-delete' => 'Règle Phalanx supprimée: $1',
	'phalanx-rule-log-details' => 'Filtre: "$1", type: "$2", motif: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID du wiki',
	'phalanx-stats-table-wiki-name' => 'Nom du wiki',
	'phalanx-stats-table-wiki-url' => 'URL du wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Dernière modification',
	'phalanx-email-filter-hidden' => "Filtre de courriel caché. Vous n'avez pas le droit de voir son contenu.",
	'action-phalanx' => 'utiliser le mécanisme de défense contre les courriers indésirables intégré',
	'right-phalanx' => 'Peut gérer les blocages globaux et filtres de contenu indésirable',
	'right-phalanxexempt' => 'Exonéré des règles Phalanx',
	'right-phalanxemailblock' => 'Vous pouvez lister, voir et gérer les blocs basés sur les courriels.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'phalanx-desc' => 'Phalanx é un mecanismo integrado de defensa contra o spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mecanismo integrado de defensa contra o spam',
	'phalanx-type-content' => 'contido da páxina',
	'phalanx-type-summary' => 'resumo da páxina',
	'phalanx-type-title' => 'título da páxina',
	'phalanx-type-user' => 'usuario',
	'phalanx-type-user-email' => 'correo electrónico',
	'phalanx-type-answers-question-title' => 'título da pregunta',
	'phalanx-type-answers-recent-questions' => 'preguntas recentes',
	'phalanx-type-wiki-creation' => 'creación de wiki',
	'phalanx-add-block' => 'Aplicar o bloqueo',
	'phalanx-edit-block' => 'Gardar o bloqueo',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Duración:',
	'phalanx-label-type' => 'Tipo:',
	'phalanx-label-lang' => 'Lingua:',
	'phalanx-view-type' => 'Tipo de bloqueo...',
	'phalanx-view-blocker' => 'Procurar por texto de filtro:',
	'phalanx-view-blocks' => 'Procurar nos filtros',
	'phalanx-view-id' => 'Obter o filtro por ID:',
	'phalanx-view-id-submit' => 'Obter o filtro',
	'phalanx-format-text' => 'texto simple',
	'phalanx-format-regex' => 'expresión regular',
	'phalanx-format-case' => 'con distinción entre maiúsculas e minúsculas',
	'phalanx-format-exact' => 'exacto',
	'phalanx-tab-main' => 'Xestionar os filtros',
	'phalanx-tab-secondary' => 'Probar os filtros',
	'phalanx-block-success' => 'O bloqueo foi engadido correctamente',
	'phalanx-block-failure' => 'Houbo un erro durante a adición do bloqueo',
	'phalanx-modify-success' => 'O bloqueo foi modificado correctamente',
	'phalanx-modify-failure' => 'Houbo un erro durante a modificación do bloqueo',
	'phalanx-modify-warning' => 'Está editando o bloqueo co identificador nº$1.
Ao premer en "{{int:phalanx-edit-block}}" gardará os cambios!',
	'phalanx-test-description' => 'Texto proporcionado para a proba contra os bloqueos actuais.',
	'phalanx-test-submit' => 'Probar',
	'phalanx-test-results-legend' => 'Resultados das probas',
	'phalanx-display-row-blocks' => 'bloqueos: $1',
	'phalanx-display-row-created' => "creado por '''$1''' o $2",
	'phalanx-link-unblock' => 'desbloquear',
	'phalanx-link-modify' => 'modificar',
	'phalanx-link-stats' => 'estatísticas',
	'phalanx-reset-form' => 'Restablecer o formulario',
	'phalanx-legend-input' => 'Crear ou modificar o filtro',
	'phalanx-legend-listing' => 'Filtros que se aplican actualmente',
	'phalanx-unblock-message' => 'O bloqueo co identificador nº$1 eliminouse correctamente',
	'phalanx-help-type-content' => 'Este filtro impide gardar unha edición se o seu contido coincide con calquera das frases presentes na lista negra.',
	'phalanx-help-type-summary' => 'Este filtro impide gardar unha edición se o resumo coincide con calquera das frases presentes na lista negra.',
	'phalanx-help-type-title' => 'Este filtro impide crear unha páxina se o seu título coincide con calquera das frases presentes na lista negra.

Non impide a edición daquelas páxinas que xa existían con anterioridade.',
	'phalanx-help-type-user' => 'Este filtro bloquea un usuario (exactamente o mesmo que un bloqueo local en MediaWiki) se o nome ou o enderezo IP coincide con calquera dos nomes ou enderezos IP presentes na lista negra.',
	'phalanx-help-type-wiki-creation' => 'Este filtro impide a creación dun wiki se o seu nome ou enderezo URL coincide con calquera das frases presentes na lista negra.',
	'phalanx-help-type-answers-question-title' => 'Este filtro impide a creación dunha pregunta (páxina) se o seu título coincide con calquera das frases presentes na lista negra.

Nota: Funciona só nos wikis do tipo de preguntas e respostas.',
	'phalanx-help-type-answers-recent-questions' => 'Este filtro impide mostrar aquelas preguntas (páxinas) nun número de saídas (widgets, listas, enumeracións xeradas por etiqueta).
Non impide a creación das devanditas páxinas.

Nota: Funciona só nos wikis do tipo de preguntas e respostas.',
	'phalanx-help-type-user-email' => 'Este filtro evita a creación de contas segundo os enderezos de correo electrónico bloqueados.',
	'phalanx-user-block-reason-ip' => 'A este enderezo IP estalle prohibido editar ao longo de toda a rede de Wikia debido a vandalismo ou outras actividades negativas realizadas por vostede ou por alguén que comparte o seu enderezo IP.
Se pensa que se trata dun erro, [[Special:Contact|póñase en contacto con Wikia]].',
	'phalanx-user-block-reason-exact' => 'A este nome de usuario ou enderezo IP estalle prohibido editar ao longo de toda a rede de Wikia debido a vandalismo ou outras actividades negativas.
Se pensa que se trata dun erro, [[Special:Contact|póñase en contacto con Wikia]].',
	'phalanx-user-block-reason-similar' => 'A este nome de usuario estalle prohibido editar ao longo de toda a rede de Wikia debido a vandalismo ou outras actividades negativas realizadas por un usuario cun nome similar.
[[Special:Contact|Póñase en contacto con Wikia]] para arranxar o problema.',
	'phalanx-user-block-new-account' => 'Ese nome de usuario non está dispoñible para o seu rexistro. Escolla outro nome.',
	'phalanx-user-block-withreason-ip' => 'A este enderezo IP estalle prohibido editar ao longo de toda a rede de Wikia debido a vandalismo ou outras actividades negativas realizadas por vostede ou por alguén que comparte o seu enderezo IP.
Se pensa que se trata dun erro, [[Special:Contact|póñase en contacto con Wikia]].<br />A persoa que impuxo o bloqueo deu este motivo: $1.',
	'phalanx-user-block-withreason-exact' => 'A este nome de usuario ou enderezo IP estalle prohibido editar ao longo de toda a rede de Wikia debido a vandalismo ou outras actividades negativas.
Se pensa que se trata dun erro, [[Special:Contact|póñase en contacto con Wikia]].<br />A persoa que impuxo o bloqueo deu este motivo: $1.',
	'phalanx-user-block-withreason-similar' => 'A este nome de usuario estalle prohibido editar ao longo de toda a rede de Wikia debido a vandalismo ou outras actividades negativas realizadas por un usuario cun nome similar.
[[Special:Contact|Póñase en contacto con Wikia]] para falar sobre o problema.<br />A persoa que impuxo o bloqueo deu este motivo: $1.',
	'phalanx-title-move-summary' => 'O motivo que inseriu contén unha frase bloqueada.',
	'phalanx-content-spam-summary' => 'O texto atopouse no resumo da páxina.',
	'phalanx-stats-title' => 'Estatísticas de Phalanx',
	'phalanx-stats-block-notfound' => 'non se atopou o identificador do bloqueo',
	'phalanx-stats-table-id' => 'ID do bloqueo',
	'phalanx-stats-table-user' => 'Engadido por',
	'phalanx-stats-table-type' => 'Tipo',
	'phalanx-stats-table-create' => 'Creado',
	'phalanx-stats-table-expire' => 'Caduca',
	'phalanx-stats-table-exact' => 'Exacto',
	'phalanx-stats-table-regex' => 'Expresión regular',
	'phalanx-stats-table-case' => 'Maiúscula/minúscula',
	'phalanx-stats-table-language' => 'Lingua',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
	'phalanx-stats-row' => "ás $4, o filtro do tipo '''$1''' bloqueou a '''$2''' en $3",
	'phalanx-stats-row-per-wiki' => "o usuario '''$2''' foi bloqueado en '''$4''' polo filtro co identificador '''$3''' ($5) (tipo: '''$1''')",
	'phalanx-rule-log-name' => 'Rexistro de regras do Phalanx',
	'phalanx-rule-log-header' => 'Este é un rexistro dos cambios realizados nas regras do Phalanx.',
	'phalanx-email-rule-log-name' => 'Rexistro de regras de correo electrónico do Phalanx',
	'phalanx-email-rule-log-header' => 'Este é un rexistro dos cambios realizados nas regras do Phalanx para o tipo de correo electrónico.',
	'phalanx-rule-log-add' => 'Regra do Phalanx engadida: $1',
	'phalanx-rule-log-edit' => 'Regra do Phalanx editada: $1',
	'phalanx-rule-log-delete' => 'Regra do Phalanx borrada: $1',
	'phalanx-rule-log-details' => 'Filtro: "$1", tipo: "$2", motivo: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID do wiki',
	'phalanx-stats-table-wiki-name' => 'Nome do wiki',
	'phalanx-stats-table-wiki-url' => 'URL do wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Última edición',
	'phalanx-email-filter-hidden' => 'O filtro de correo electrónico está agochado. Non ten os permisos necesarios para ollar o texto.',
	'action-phalanx' => 'usar o mecanismo integrado de defensa contra o spam',
	'right-phalanx' => 'Pode xestionar os bloqueos globais e os filtros de spam',
	'right-phalanxexempt' => 'Exento das regras do Phalanx',
	'right-phalanxemailblock' => 'Pode arquivar, ollar e xestionar os bloqueos baseados en correos electrónicos',
);

/** Hungarian (magyar)
 * @author Dani
 * @author TK-999
 */
$messages['hu'] = array(
	'phalanx-desc' => 'A Phalanx egy beépített spam elleni mechanizmus',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrált spam elleni védelmi mechanizmus',
	'phalanx-type-content' => 'lap tartalma',
	'phalanx-type-summary' => 'lap összefoglalója',
	'phalanx-type-title' => 'lap címe',
	'phalanx-type-user' => 'felhasználó',
	'phalanx-type-user-email' => 'e-mail',
	'phalanx-type-answers-question-title' => 'kérdés címe',
	'phalanx-type-answers-recent-questions' => 'legújabb kérdések',
	'phalanx-type-wiki-creation' => 'wiki létrehozás',
	'phalanx-add-block' => 'Blokk alkalmazása',
	'phalanx-edit-block' => 'Blokk mentése',
	'phalanx-label-filter' => 'Szűrő:',
	'phalanx-label-reason' => 'Ok:',
	'phalanx-label-expiry' => 'Lejárat:',
	'phalanx-label-type' => 'Típus:',
	'phalanx-label-lang' => 'Nyelv:',
	'phalanx-view-type' => 'Blokk típusa...',
	'phalanx-view-blocker' => 'Keresés szűrt szöveg alapján:',
	'phalanx-view-blocks' => 'Szűrők keresése',
	'phalanx-view-id' => 'Szűrő lekérése azonosító alapján:',
	'phalanx-view-id-submit' => 'Szűrő lekérése',
	'phalanx-format-text' => 'egyszerű szöveg',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'kis- és nagybetűérzékeny',
	'phalanx-format-exact' => 'pontos',
	'phalanx-tab-main' => 'Szűrők karbantartása',
	'phalanx-tab-secondary' => 'Szűrők tesztelése',
	'phalanx-block-success' => 'A tiltás felvétele sikerült.',
	'phalanx-block-failure' => 'Hiba történt a tiltás hozzáadása közben.',
	'phalanx-modify-success' => 'A tiltás módosítása sikerült.',
	'phalanx-modify-failure' => 'Hiba történt a tiltás módosítása közben.',
	'phalanx-modify-warning' => 'Jelenleg az #$1 azonosítójú tiltást szerkeszted.
Az "{{int:phalanx-edit-block}}"-ra kattintva elmentheted a változtatásaidat!',
	'phalanx-test-description' => 'Érvényben lévő tiltások tesztelése megadott szöveggel.',
	'phalanx-test-submit' => 'Teszt',
	'phalanx-test-results-legend' => 'Teszteredmények',
	'phalanx-display-row-blocks' => 'tiltások: $1',
	'phalanx-display-row-created' => "létrehozta '''$1''' $2",
	'phalanx-link-unblock' => 'blokk feloldása',
	'phalanx-link-modify' => 'módosítás',
	'phalanx-link-stats' => 'statisztikák',
	'phalanx-reset-form' => 'Űrlap alaphelyzetbe állítása',
	'phalanx-legend-input' => 'Szűrő létrehozása vagy módosítása',
	'phalanx-legend-listing' => 'A jelenleg alkalmazott szűrők',
	'phalanx-unblock-message' => 'Az #$1 azonosítójú tiltás sikeresen el lett távolítva.',
	'phalanx-help-type-content' => 'Ez a szűrő megakadályozza a szerkesztés mentését, amennyiben az tartalmazza a feketelistás kifejezések bármelyikét.',
	'phalanx-help-type-summary' => 'Ez a szűrő megakadályozza a szerkesztés mentését, amennyiben annak összefoglalója tartalmazza a feketelistás kifejezések bármelyikét.',
	'phalanx-help-type-title' => 'Ez a szűrő megakadályozza az oldal létrehozását, amennyiben a kívánt cím megegyezik a feketelistás kifejezések bármelyikével.

	 Nem akadályozza meg azonban az esetlegesen már meglévő oldal szerkesztését.',
	'phalanx-help-type-user' => 'Ez a szűrő blokkol egy felhasználót (a helyi MediaWiki blokkal megegyezően), ammennyiben a név vagy IP-cím megegyezik valamelyik feketelistás mnévvel vagy IP-címmel.',
	'phalanx-help-type-wiki-creation' => 'Ez a szűrő megakadályozza egy wiki létrehozását, amennyiben a neve vagy az URL-címe megegyezik a feketelistás kifejezések bármelyikével.',
	'phalanx-help-type-answers-question-title' => 'Ez a szűrő blokkolja a kérdés (oldal) létrehozását, ammennyiben annak címe megegyezik a feketelistás kifejezések bármelyikével.
Megjegyzés: csak az Answers-típusú wikiken működik.',
	'phalanx-help-type-answers-recent-questions' => 'Ez a szűrő megakadályozza a kérdések (oldalak) megjelenítését egy sor kimenetben (widgetek, listák, címkék által létrehozott listák).
Nem gátolja meg ezen oldalak létrehozását.

Megjegyzés:csak az Answers-típusú wikiken működik.',
	'phalanx-help-type-user-email' => 'Ez a szűrő megakadályozza a letiltott e-mail cím használatával végzett fióklétrehozást.',
	'phalanx-user-block-reason-ip' => 'Ez az IP-cím a Wikia egész hálózatán el van tiltva a szerkesztéstől általad&mdash;vagy az IP-címed más használója&mdash;végzett vandalizmus vagy más rendzavarás miatt.
Amennyiben ezt hibásnak tartod, kérlek, [[Special:Contact|lépj kapcsolatba a Wikiával]].',
	'phalanx-user-block-reason-exact' => 'Ez a felhasználónév vagy IP-cím a Wikia egész hálózatán el van tiltva a szerkesztéstől vandalizmus vagy más rendzavarás miatt.
Amennyiben ezt hibásnak tartod, kérlek, [[Special:Contact|lépj kapcsolatba a Wikiával]].',
	'phalanx-user-block-reason-similar' => 'Ez a felhasználónév a Wikia egész hálózatán el van tiltva a szerkesztéstől egy hasonló nevű felhasználó által végzett vandalizmus vagy más rendzavarás miatt.
Kérlek, [[Special:Contact|lépj kapcsolatba a Wikiával]] a probléma megoldása érdekében.',
	'phalanx-user-block-new-account' => 'A felhasználónév nem regisztráltatható. Kérlek, válassz másikat.',
	'phalanx-user-block-withreason-ip' => 'Ez az IP-cím a Wikia egész hálózatán el van tiltva a szerkesztéstől általad&mdash;vagy az IP-címed más használója&mdash;végzett vandalizmus vagy más rendzavarás miatt.
Amennyiben ezt hibásnak tartod, kérlek, [[Special:Contact|lépj kapcsolatba a Wikiával]].<br />
Az IP-címet letiltó személy az alábbi indoklást adta: $1',
	'phalanx-user-block-withreason-exact' => 'Ez a felhasználónév vagy IP-cím a Wikia egész hálózatán el van tiltva a szerkesztéstől vandalizmus vagy más rendzavarás miatt.
Amennyiben ezt hibásnak tartod, kérlek, [[Special:Contact|lépj kapcsolatba a Wikiával]].<br />
A letiltó személy az alábbi indoklást adta: $1',
	'phalanx-user-block-withreason-similar' => 'Ez a felhasználónév a Wikia egész hálózatán el van tiltva a szerkesztéstől egy hasonló nevű felhasználó által végzett vandalizmus vagy más rendzavarás miatt.
Amennyiben ezt hibásnak tartod, kérlek, [[Special:Contact|lépj kapcsolatba a Wikiával]].<br />
A letiltó személy az alábbi indoklást adta: $1',
	'phalanx-title-move-summary' => 'A megadott indoklás blokkolt kifejezést tartalmazott.',
	'phalanx-content-spam-summary' => 'Szövegtalálat a lap összefoglalójában.',
	'phalanx-stats-title' => 'Phalanx statisztikák',
	'phalanx-stats-block-notfound' => 'blokk-azonosító nem található',
	'phalanx-stats-table-id' => 'Blokkazonosító',
	'phalanx-stats-table-user' => 'Hozzáadta',
	'phalanx-stats-table-type' => 'Típus',
	'phalanx-stats-table-create' => 'Létrehozás ideje',
	'phalanx-stats-table-expire' => 'Lejárat:',
	'phalanx-stats-table-exact' => 'Pontos',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Eset',
	'phalanx-stats-table-language' => 'Nyelv',
	'phalanx-stats-table-text' => 'Szöveg',
	'phalanx-stats-table-reason' => 'Ok',
	'phalanx-stats-row' => "a(z) '''$1''' típusú szűrő $4-kor blokkolta $2-t a(z) $3-n",
	'phalanx-stats-row-per-wiki' => "a(z) '''$2''' felhasználót a(z) '''$4'''-en letiltotta az '''$3''' azonosítójú szűrő ($5) (típus: $1)",
	'phalanx-rule-log-name' => 'Phalanx szabályok naplója',
	'phalanx-rule-log-header' => 'Ez a Phalanx szabályain végzett módosítások naplója.',
	'phalanx-email-rule-log-name' => 'Phalanx e-mail szabályok naplója',
	'phalanx-email-rule-log-header' => 'Ez az e-mail típusú Phalanx szabályokon végzett változtatások naplója.',
	'phalanx-rule-log-add' => 'Hozzáadott Phalanx szabály: $1',
	'phalanx-rule-log-edit' => 'Módosított Phalanx szabály: $1',
	'phalanx-rule-log-delete' => 'Törölt Phalanx szabály: $1',
	'phalanx-rule-log-details' => 'Szűrő: "$1", típus: "$2", ok: "$3"',
	'phalanx-stats-table-wiki-id' => 'Wiki azonosító',
	'phalanx-stats-table-wiki-name' => 'Wiki neve',
	'phalanx-stats-table-wiki-url' => 'Wiki URL-címe',
	'phalanx-stats-table-wiki-last-edited' => 'Utolsó szerkesztés',
	'phalanx-email-filter-hidden' => 'Az e-mail szűrő rejtett. Nincs engedélyed a szöveg megjelenítéséhez.',
	'action-phalanx' => 'az integrált spam elleni védelmi mechanizmus használata',
	'right-phalanx' => 'Globális blokkok és spamszűrők kezelése',
	'right-phalanxexempt' => 'Phalanx szabályok alól felmentett',
	'right-phalanxemailblock' => 'Létrehozhat, megtekinthet és kezelhet e-mail alapú blokkokat',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'phalanx-desc' => 'Phalanx es un systema anti-spam integrate',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Systema anti-spam integrate',
	'phalanx-type-content' => 'contento de pagina',
	'phalanx-type-summary' => 'summario de pagina',
	'phalanx-type-title' => 'titulo de pagina',
	'phalanx-type-user' => 'usator',
	'phalanx-type-user-email' => 'e-mail',
	'phalanx-type-answers-question-title' => 'titulo de question',
	'phalanx-type-answers-recent-questions' => 'questiones recente',
	'phalanx-type-wiki-creation' => 'creation de wiki',
	'phalanx-add-block' => 'Applicar blocada',
	'phalanx-edit-block' => 'Salveguardar blocada',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Expiration:',
	'phalanx-label-type' => 'Typo:',
	'phalanx-label-lang' => 'Lingua:',
	'phalanx-view-type' => 'Typo de blocada...',
	'phalanx-view-blocker' => 'Cercar per texto de filtro:',
	'phalanx-view-blocks' => 'Cercar in filtros',
	'phalanx-view-id' => 'Cercar filtro per ID:',
	'phalanx-view-id-submit' => 'Obtener filtro',
	'phalanx-format-text' => 'texto simple',
	'phalanx-format-regex' => 'expression regular',
	'phalanx-format-case' => 'sensibile al majusculas',
	'phalanx-format-exact' => 'exacte',
	'phalanx-tab-main' => 'Gerer filtros',
	'phalanx-tab-secondary' => 'Testar filtros',
	'phalanx-block-success' => 'Le blocada ha essite addite con successo',
	'phalanx-block-failure' => 'Un error occurreva durante le addition del blocada',
	'phalanx-modify-success' => 'Le blocada ha essite modificate con successo',
	'phalanx-modify-failure' => 'Un error occurreva durante le modification del blocada',
	'phalanx-modify-warning' => 'Tu modifica le blocada con ID #$1.
Un clic sur "{{int:phalanx-add-block}}" salveguardara le cambios!',
	'phalanx-test-description' => 'Verificar le texto fornite contra le blocadas actual.',
	'phalanx-test-submit' => 'Testar',
	'phalanx-test-results-legend' => 'Resultatos del test',
	'phalanx-display-row-blocks' => 'blocadas: $1',
	'phalanx-display-row-created' => "create per '''$1''' le $2",
	'phalanx-link-unblock' => 'disblocar',
	'phalanx-link-modify' => 'modificar',
	'phalanx-link-stats' => 'statisticas',
	'phalanx-reset-form' => 'Reinitialisar formulario',
	'phalanx-legend-input' => 'Crear o modificar filtro',
	'phalanx-legend-listing' => 'Filtros actualmente applicate',
	'phalanx-unblock-message' => 'Le blocada con ID #$1 ha essite removite con successo',
	'phalanx-help-type-content' => 'Iste filtro impedi le salveguarda de un modification si su contento corresponde a un phrase presente in le lista nigre.',
	'phalanx-help-type-summary' => 'Iste filtro impedi le salveguarda de un modification si le summario specificate corresponde a un phrase presente in le lista nigre.',
	'phalanx-help-type-title' => 'Iste filtro impedi le salveguarda de un modification si su titulo corresponde a un phrase presente in le lista nigre.

Illo non impedi le modification de un pagina pre-existente.',
	'phalanx-help-type-user' => 'Iste filtro bloca un usator (exactemente como un blocada local in MediaWiki), si le nomine o adresse IP es presente in le lista nigre de nomines o de adresses IP.',
	'phalanx-help-type-wiki-creation' => 'Iste filtro impedi le creation de un wiki si su nomine o URL es presente in le lista nigre.',
	'phalanx-help-type-answers-question-title' => 'Iste filtro bloca le creation de un question (pagina), si su titulo es presente in le lista nigre.

Nota: functiona solmente in wikis del typo Responsas.',
	'phalanx-help-type-answers-recent-questions' => 'Iste filtro impedi le visualisation de questiones (paginas) in un numero de formatos (widgets, listas, listages a base de etiquettas).
Illo non impedi le creation de tal paginas.

Nota: functiona solmente in wikis del typo Answers.',
	'phalanx-help-type-user-email' => 'Iste filtro impedi le creation de contos con un adresse de e-mail blocate.',
	'phalanx-user-block-reason-ip' => 'Iste adresse IP es impedite de facer modificationes in tote le rete de Wikia pro causa de vandalismo o de altere disruption per te o per alcuno altere qui usa un adresse IP in commun con te.
Si tu crede que isto es un error, per favor [[Special:Contact|contacta Wikia]].',
	'phalanx-user-block-reason-exact' => 'Iste nomine de usator o adresse IP es impedite de facer modificationes in tote le rete de Wikia pro causa de vandalismo o de altere disruption.
Si tu crede que isto es un error, per favor [[Special:Contact|contacta Wikia]].',
	'phalanx-user-block-reason-similar' => 'Iste nomine de usator es impedite de facer modificationes in tote le rete de Wikia pro causa de vandalismo o de altere disruption per un usator con un nomine similar.
Per favor [[Special:Contact|contacta Wikia]] a proposito de iste problema.',
	'phalanx-user-block-new-account' => 'Iste nomine de usator non es disponibile pro registration. Per favor elige un altere.',
	'phalanx-user-block-withreason-ip' => 'Iste adresse IP es impedite de facer modificationes in tote le rete de Wikia pro causa de vandalismo o de altere disruption per te o per alcuno altere qui usa un adresse IP in commun con te.
Si tu crede que isto es un error, per favor [[Special:Contact|contacta Wikia]].<br />Le blocator dava tamben iste motivo additional: $1.',
	'phalanx-user-block-withreason-exact' => 'Iste nomine de usator o adresse IP es impedite de facer modificationes in tote le rete de Wikia pro causa de vandalismo o de altere disruption.
Si tu crede que isto es un error, per favor [[Special:Contact|contacta Wikia]].<br />Le blocator dava tamben iste motivo additional: $1.',
	'phalanx-user-block-withreason-similar' => 'Iste nomine de usator es impedite de facer modificationes in tote le rete de Wikia pro causa de vandalismo o de altere disruption per un usator con un nomine similar.
Per favor [[Special:Contact|contacta Wikia]] a proposito de iste problema.<br />Le blocator dava tamben iste motivo additional: $1.',
	'phalanx-title-move-summary' => 'Le motivo que tu entrava contineva un phrase blocate.',
	'phalanx-content-spam-summary' => 'Le texto esseva trovate in le summario del pagina.',
	'phalanx-stats-title' => 'Statisticas de Phalanx',
	'phalanx-stats-block-notfound' => 'ID de blocada non trovate',
	'phalanx-stats-table-id' => 'ID de blocada',
	'phalanx-stats-table-user' => 'Addite per',
	'phalanx-stats-table-type' => 'Typo',
	'phalanx-stats-table-create' => 'Create',
	'phalanx-stats-table-expire' => 'Expira',
	'phalanx-stats-table-exact' => 'Exacte',
	'phalanx-stats-table-regex' => 'Expression regular',
	'phalanx-stats-table-case' => 'Litteras',
	'phalanx-stats-table-language' => 'Lingua',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
	'phalanx-stats-row' => "a $4, le typo de filtro ''$1''' blocava '''$2''' in $3",
	'phalanx-stats-row-per-wiki' => "le usator '''$2''' esseva blocate a '''$4''' per le filtro con ID '''$3''' ($5) (typo: '''$1''')",
	'phalanx-rule-log-name' => 'Registro de regulas Phalanx',
	'phalanx-rule-log-header' => 'Isto es un registro de modificationes in le regulas de Phalanx.',
	'phalanx-email-rule-log-name' => 'Registro de regulas de e-mail Phalanx',
	'phalanx-email-rule-log-header' => 'Isto es un registro de cambios in regulas Phalanx pro le typo de e-mail.',
	'phalanx-rule-log-add' => 'Regula de Phalanx addite: $1',
	'phalanx-rule-log-edit' => 'Regula de Phalanx modificate: $1',
	'phalanx-rule-log-delete' => 'Regula de Phalanx delite: $1',
	'phalanx-rule-log-details' => 'Filtro: "$1", typo: "$2", motivo: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID del wiki',
	'phalanx-stats-table-wiki-name' => 'Nomine del wiki',
	'phalanx-stats-table-wiki-url' => 'URL del wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Ultime modification',
	'phalanx-email-filter-hidden' => 'Le filtro de e-mail es celate. Tu non ha le permission de vider le texto.',
	'action-phalanx' => 'usar le systema anti-spam integrate',
	'right-phalanx' => 'Pote gerer global blocadas e filtros anti-spam',
	'right-phalanxexempt' => 'Exempte de regulas de Phalanx',
	'right-phalanxemailblock' => 'Pote submitter, vider e gerer blocadas a base de e-mail',
);

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 */
$messages['id'] = array(
	'phalanx-type-summary' => 'rangkuman halaman',
	'phalanx-add-block' => 'Terapkan pemblokiran',
	'phalanx-label-reason' => 'Alasan:',
	'phalanx-view-type' => 'Jenis pemblokiran...',
	'phalanx-view-blocks' => 'Cari penyaringan',
	'phalanx-tab-main' => 'Kelola Filter',
	'phalanx-block-success' => 'Pemblokiran berhasil ditambahkan',
	'phalanx-test-results-legend' => 'Hasil pengujian',
	'phalanx-display-row-created' => "dibuat oleh '''$1''' pada $2",
	'phalanx-link-stats' => 'statistik',
	'phalanx-help-type-content' => 'Filter ini mencegah sebuah suntingan disimpan, jika isinya cocok dengan ungkapan manapun dalam daftar hitam.',
	'phalanx-help-type-title' => 'Penyaringan ini mencegah halaman untuk dibuat, jika judulnya cocok dengan salah satu ungkapan dalam daftar hitam.

	Ini tidak menghalangi halaman yang sudah ada dari penyuntingan.',
	'phalanx-help-type-user-email' => 'Filter ini mencegah pembuatan akun menggunakan alamat surel yang diblokir.',
	'phalanx-user-block-reason-similar' => 'Nama pengguna ini dicegah dari menyunting di seluruh jaringan Wikia karena vandalisme atau gangguan lainnya oleh pengguna dengan nama yang mirip.
Silakan [[Special:Contact|hubungi Wikia]] mengenai masalah ini.',
	'phalanx-user-block-withreason-exact' => 'Nama pengguna atau IP ini dicegah dari menyunting di seluruh jaringan Wikia karena vandalisme atau gangguan lainnya.
Jika Anda yakin ini adalah sebuah kesalahan, silakan [[Special:Contact|hubungi Wikia]].<br />Pemblokir juga memberikan alasan tambahan ini: $1.',
	'phalanx-content-spam-summary' => 'Teks ini ditemukan dalam ringkasan halaman.',
	'phalanx-stats-table-user' => 'Ditambahkan oleh',
);

/** Icelandic (íslenska)
 * @author Snævar
 */
$messages['is'] = array(
	'phalanx-type-content' => 'Innihald síðu',
	'phalanx-type-title' => 'Titill síðu',
	'phalanx-type-user' => 'notandi',
	'phalanx-type-user-email' => 'tölvupóstur',
	'phalanx-type-answers-question-title' => 'spurninga titill',
	'phalanx-type-answers-recent-questions' => 'síðustu spurningar',
	'phalanx-edit-block' => 'Vista bann',
	'phalanx-label-filter' => 'Sía:',
	'phalanx-label-reason' => 'Ástæða:',
	'phalanx-label-expiry' => 'Rennur út:',
	'phalanx-label-type' => 'Gerð:',
	'phalanx-label-lang' => 'Tungumál:',
	'phalanx-view-type' => 'Gerð banns...',
	'phalanx-view-id-submit' => 'Sækja síu',
	'phalanx-format-regex' => 'regluleg segð',
	'phalanx-format-exact' => 'nákvæm',
	'phalanx-tab-main' => 'Stjórna síum',
	'phalanx-tab-secondary' => 'Prófa síur',
	'phalanx-modify-success' => 'Banninu var breytt',
	'phalanx-modify-failure' => 'Mistókst að breyta banninu',
	'phalanx-test-submit' => 'Prófun',
	'phalanx-display-row-blocks' => 'bönn: $1',
	'phalanx-display-row-created' => "búið til af '''$1''' á $2",
	'phalanx-link-unblock' => 'afbanna',
	'phalanx-link-modify' => 'breyta',
	'phalanx-link-stats' => 'tölfræði',
	'phalanx-reset-form' => 'Endursetja eyðublað',
	'phalanx-legend-input' => 'Búa til eða breyta síu',
	'phalanx-unblock-message' => 'Banni með auðkennið #$1 var fjarlægt',
	'phalanx-help-type-content' => 'Þessi sía kemur í veg fyrir að breyting sé vistuð, ef innihald hennar passar við eitthvert af setningunum á bannlistanum.',
	'phalanx-help-type-title' => 'Þessi sía kemur í veg fyrir að síða sé stofnuð, ef titill hennar passar við eitthvert af setningunum á bannlistanum.

Sían kemur ekki í veg fyrir breytingar á síðu sem er þegar til.',
	'phalanx-help-type-user' => 'Þessi sía kemur í veg fyrir notanda (nákvæmlega það sama og bann), ef nafn eða vistfang passar við eitt af eitthvert af setningunum á banlistanum.',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'phalanx-type-title' => 'ページ名',
	'phalanx-type-user-email' => 'メール',
	'phalanx-type-wiki-creation' => 'ウィキ作成',
	'phalanx-add-block' => 'ブロックを適用',
	'phalanx-edit-block' => 'ブロックを保存',
	'phalanx-label-filter' => 'フィルター:',
	'phalanx-label-reason' => '理由:',
	'phalanx-label-type' => '種類:',
	'phalanx-label-lang' => '言語:',
	'phalanx-format-text' => 'プレーンテキスト',
	'phalanx-format-regex' => '正規表現',
	'phalanx-format-case' => '大文字・小文字を区別',
	'phalanx-tab-main' => 'フィルターを管理',
	'phalanx-tab-secondary' => 'フィルターをテスト',
	'phalanx-test-submit' => 'テスト',
	'phalanx-link-unblock' => 'ブロック解除',
	'phalanx-link-modify' => '修正',
	'phalanx-reset-form' => 'フォームをリセット',
	'phalanx-stats-block-notfound' => 'ブロック ID が見つかりません',
	'phalanx-stats-table-id' => 'ブロック ID',
	'phalanx-stats-table-regex' => '正規表現',
	'phalanx-stats-table-language' => '言語',
	'phalanx-stats-table-text' => 'テキスト',
	'phalanx-stats-table-reason' => '理由',
	'phalanx-stats-table-wiki-id' => 'ウィキ ID',
	'phalanx-stats-table-wiki-name' => 'ウィキ名',
	'phalanx-stats-table-wiki-url' => 'ウィキの URL',
	'phalanx-stats-table-wiki-last-edited' => '最終編集',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'phalanx-type-content' => 'ខ្លឹមសារទំព័រ',
	'phalanx-type-summary' => 'ចំណារពន្យល់ទំព័រ',
	'phalanx-type-title' => 'ចំណងជើង​ទំព័រ',
	'phalanx-type-user' => 'អ្នកប្រើប្រាស់',
	'phalanx-type-answers-question-title' => 'ចំនងជើងសំនួរ',
	'phalanx-type-answers-recent-questions' => 'សំនួរថ្មីៗ',
	'phalanx-type-wiki-creation' => 'ការបង្កើតវិគី',
	'phalanx-add-block' => 'អនុវត្តការរាំងខ្ទប់',
	'phalanx-edit-block' => 'រក្សាទុកការរាំងខ្ទប់',
	'phalanx-label-filter' => 'តម្រង៖',
	'phalanx-label-reason' => 'មូលហេតុ៖',
	'phalanx-label-expiry' => 'រយៈពេលផុតកំណត់៖',
	'phalanx-label-type' => 'ប្រភេទ​៖',
	'phalanx-label-lang' => 'ភាសា៖',
	'phalanx-view-type' => 'ប្រភេទការរាំងខ្ទប់...',
	'phalanx-view-blocker' => 'ស្វែងរកដោយអត្ថបទតំរង៖',
	'phalanx-view-blocks' => 'ស្វែងរកតំរង',
	'phalanx-view-id' => 'យកតំរងដោយអត្តសញ្ញាណ៖',
	'phalanx-view-id-submit' => 'យកតំរង',
	'phalanx-format-text' => 'អត្ថបទធម្មតា',
	'phalanx-tab-main' => 'គ្រប់គ្រងតំរង',
	'phalanx-tab-secondary' => 'ធ្វើតេស្តតំរង',
	'phalanx-block-success' => 'ការរាំងខ្ទប់ត្រូវបានបន្ថែមបានសំរេច',
	'phalanx-block-failure' => 'មានបញ្ហាក្នុងពេលបន្ថែមការរាំងខ្ទប់',
	'phalanx-modify-success' => 'ការរាំងខ្ទប់ត្រូវបានកែសំរួលបានសំរេច',
	'phalanx-modify-failure' => 'មានបញ្ហាក្នុងពេលកែសំរួលការរាំងខ្ទប់',
	'phalanx-modify-warning' => 'អ្នកកំពុងកែប្រែកការរាំងខ្ទប់អត្តសញ្ញាណ #$1។
ការចុច "{{int:phalanx-add-block}}" នឹងរក្សាទុកការកែប្រែរបស់អ្នក!',
	'phalanx-test-submit' => 'តេស្ត',
	'phalanx-test-results-legend' => 'លទ្ធផលតេស្ត',
	'phalanx-display-row-blocks' => 'ការរាំងខ្ទប់៖ $1',
	'phalanx-display-row-created' => "បង្កើតដោយ '''$1''' នៅ $2",
	'phalanx-link-unblock' => 'ឈប់រាំងខ្ទប់',
	'phalanx-link-modify' => 'កែសំរួល',
	'phalanx-link-stats' => 'ស្ថិតិ',
);

/** Korean (한국어)
 * @author Cafeinlove
 */
$messages['ko'] = array(
	'phalanx-label-type' => '유형:',
	'phalanx-label-lang' => '언어:',
	'phalanx-stats-table-language' => '언어',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'phalanx-type-user' => 'Benotzer',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Grond:',
	'phalanx-label-lang' => 'Sprooch:',
	'phalanx-test-submit' => 'Test',
	'phalanx-stats-table-type' => 'Typ',
	'phalanx-stats-table-language' => 'Sprooch',
	'phalanx-stats-table-text' => 'Text:',
	'phalanx-stats-table-reason' => 'Grond',
	'phalanx-stats-table-wiki-name' => 'Numm vun der Wiki',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'phalanx-desc' => 'Phalanx е вграден систем за одбрана од спам',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - вграден систем за одбрана од спам',
	'phalanx-type-content' => 'содржина на страницата',
	'phalanx-type-summary' => 'опис на страницата',
	'phalanx-type-title' => 'наслов на страницата',
	'phalanx-type-user' => 'корисник',
	'phalanx-type-user-email' => 'е-пошта',
	'phalanx-type-answers-question-title' => 'наслов на прашањето',
	'phalanx-type-answers-recent-questions' => 'скорешни прашања',
	'phalanx-type-wiki-creation' => 'создавање на вики',
	'phalanx-add-block' => 'Примени блок',
	'phalanx-edit-block' => 'Зачувај блок',
	'phalanx-label-filter' => 'Филтер:',
	'phalanx-label-reason' => 'Причина:',
	'phalanx-label-expiry' => 'Истекува:',
	'phalanx-label-type' => 'Тип:',
	'phalanx-label-lang' => 'Јазик:',
	'phalanx-view-type' => 'Тип на блок...',
	'phalanx-view-blocker' => 'Пребарај по филтриран текст:',
	'phalanx-view-blocks' => 'Пребарај филтри',
	'phalanx-view-id' => 'Дај филтер по назнака:',
	'phalanx-view-id-submit' => 'Дај филтер',
	'phalanx-format-text' => 'прост текст',
	'phalanx-format-regex' => 'рег. израз',
	'phalanx-format-case' => 'разликувај гол/мал букв.',
	'phalanx-format-exact' => 'точно',
	'phalanx-tab-main' => 'Раководење со филтри',
	'phalanx-tab-secondary' => 'Испробај филтри',
	'phalanx-block-success' => 'Блокот е успешо додаден',
	'phalanx-block-failure' => 'Се појави грешка при додавањето на блокот',
	'phalanx-modify-success' => 'Блокот е успешно изменет',
	'phalanx-modify-failure' => 'Се појави грешка при менувањето на блокот',
	'phalanx-modify-warning' => 'Го уредувате блокот со назнака бр. $1.
Ако стиснете на „{{int:phalanx-add-block}}“ ќе ги зачувате промените!',
	'phalanx-test-description' => 'Испробајте дали тековните блокови реагираат на даден текст',
	'phalanx-test-submit' => 'Испробај',
	'phalanx-test-results-legend' => 'Исход од испробувањето',
	'phalanx-display-row-blocks' => 'блокови: $1',
	'phalanx-display-row-created' => "создадено од '''$1''' на $2",
	'phalanx-link-unblock' => 'одблокирај',
	'phalanx-link-modify' => 'измени',
	'phalanx-link-stats' => 'статистики',
	'phalanx-reset-form' => 'Исчисти го образецот',
	'phalanx-legend-input' => 'Создај или измени филтер',
	'phalanx-legend-listing' => 'Филтри во тековна примена',
	'phalanx-unblock-message' => 'Блокот со назнака бр. $1 е успешно отстранет',
	'phalanx-help-type-content' => 'Овој филтер спречува зачувување на уредување ако неговата содржина одговара на некој израз наведен на црниот список.',
	'phalanx-help-type-summary' => 'Овој филтер спречува зачувување на уредување ако неговиот опис одговара на некој израз наведен на црниот список.',
	'phalanx-help-type-title' => 'Овој филтер спречува создавање на страница ако нејзиниот наслов одговара на некој израз наведен на црниот список.

Филтерот не спречува уредување на веќе постоечка страница.',
	'phalanx-help-type-user' => 'Овој филтер блокира корисник (сосем исто како локален блок на МедијаВики) ако неговото име или IP-адреса одговара на некое име или IP-адреса наведена на црниот список.',
	'phalanx-help-type-wiki-creation' => 'Овој филтер спречува создавање на вики ако неговото име или URL-адреса одговара на нешто од наведеното на црниот список.',
	'phalanx-help-type-answers-question-title' => 'Овој филтер блокира создавање на прашање (страница) ако насловот одговара на некој од изразите наведени на црниот список.

Напомена: работи само на викија за одговорање на прашања',
	'phalanx-help-type-answers-recent-questions' => 'Овој филтер спречува приказ на прашања (страници) во низа изводи (посреднички елементи, списоци, пописи направени со ознаки). 
Филтерот не спречува создавање на таквите страници.

Напомена: работи само на викија за одговорање на прашања',
	'phalanx-help-type-user-email' => 'Филтерот спречува создавање на сметки со блокирани е-пошти.',
	'phalanx-user-block-reason-ip' => 'Оваа IP-адреса е спречена да уредува низ сета мрежа на Викија поради вандализам или друго нарушување од страна на вас или некој што ја користи вашата IP-адреса.
Доколку сметате дека ова е по грешка, [[Special:Contact|контактирајте ја Викија]].',
	'phalanx-user-block-reason-exact' => 'Ова корисничко име или IP-адреса е спречена да уредува низ сета мрежа на Викија поради вандализам или друго нарушување.
Доколку сметате дека ова е по грешка, [[Special:Contact|контактирајте ја Викија]].',
	'phalanx-user-block-reason-similar' => 'Ова корисничко име е спречено да уредува низ сета мрежа на Викија поради вандализам или друго нарушување од страна на корисник со слично име.
[[Special:Contact|Известете ја Викија]] за проблемот.',
	'phalanx-user-block-new-account' => 'Корисничкото не е слободно за регистрација. Одберете друго.',
	'phalanx-user-block-withreason-ip' => 'Оваа IP-адреса е спречена да уредува низ сета мрежа на Викија поради вандализам или друго нарушување од страна на вас или некој што ја користи вашата IP-адреса.
Доколку сметате дека ова е по грешка, [[Special:Contact|контактирајте ја Викија]].<br />Лицето што го постави блокот го понуди и следново дополнително образложение: $1.',
	'phalanx-user-block-withreason-exact' => 'Ова корисничко име или IP-адреса е спречено да уредува низ сета мрежа на Викија поради вандализам или друго нарушување.
Доколку сметате дека ова е по грешка, [[Special:Contact|контактирајте ја Викија]].<br />Лицето што го постави блокот го понуди и следново дополнително образложение: $1.',
	'phalanx-user-block-withreason-similar' => 'Ова корисничко име е спречено да уредува низ сета мрежа на Викија поради вандализам или друго нарушување од страна на корисник со слично корисничко име.
[[Special:Contact|Известете ја Викија]] за проблемов.<br />Лицето што го постави блокот го понуди и следново дополнително образложение: $1.',
	'phalanx-title-move-summary' => 'Причината е тоа што внесовте блокиран израз.',
	'phalanx-content-spam-summary' => 'Текстот е пронајден во описот на страницата.',
	'phalanx-stats-title' => 'Статистики за Phalanx',
	'phalanx-stats-block-notfound' => 'не е пронајдена таква назнака на блок',
	'phalanx-stats-table-id' => 'Назнака на блокот',
	'phalanx-stats-table-user' => 'Додадено од',
	'phalanx-stats-table-type' => 'Тип',
	'phalanx-stats-table-create' => 'Создадено',
	'phalanx-stats-table-expire' => 'Истекува',
	'phalanx-stats-table-exact' => 'Точно',
	'phalanx-stats-table-regex' => 'Рег. израз',
	'phalanx-stats-table-case' => 'Регистар',
	'phalanx-stats-table-language' => 'Јазик',
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-reason' => 'Причина',
	'phalanx-stats-row' => "во $4, филтерот од типот '''$1''' го блокирал корисникот '''$2''' на $3",
	'phalanx-stats-row-per-wiki' => "корисникот '''$2''' е блокиран на '''$4''' од филтерот со назнака '''$3''' ($5) (тип: '''$1''')",
	'phalanx-rule-log-name' => 'Дневник на правила за Phalanx',
	'phalanx-rule-log-header' => 'Ова е дневник на измените во правилата на Phalanx.',
	'phalanx-email-rule-log-name' => 'Дневник на правила за е-пошта на Phalanx',
	'phalanx-email-rule-log-header' => 'Ова е дневник на измените во правилата за е-пошта.',
	'phalanx-rule-log-add' => 'Додадено правилото: $1',
	'phalanx-rule-log-edit' => 'Изменето правилото: $1',
	'phalanx-rule-log-delete' => 'Избришано правилото: $1',
	'phalanx-rule-log-details' => 'Филтер: „$1“, тип: „$2“, причина: „$3“',
	'phalanx-stats-table-wiki-id' => 'Назнака на викито',
	'phalanx-stats-table-wiki-name' => 'Име на викито',
	'phalanx-stats-table-wiki-url' => 'URL на викито',
	'phalanx-stats-table-wiki-last-edited' => 'Последно уредување',
	'phalanx-email-filter-hidden' => 'Филтерот за е-пошта е скриен. Немате дозвола да го гледате текстот.',
	'action-phalanx' => 'употреба на Вградениот механизам за одбрана од спам',
	'right-phalanx' => 'Може да раководи со глобални блокови и филтри за спам',
	'right-phalanxexempt' => 'Изземен од правилата на Phalanx',
	'right-phalanxemailblock' => 'Може да заведува, прегледува и раководи со блокови за е-пошта',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'phalanx-type-content' => 'താളിന്റെ ഉള്ളടക്കം',
	'phalanx-type-summary' => 'താളിന്റെ ചുരുക്കം',
	'phalanx-type-title' => 'താളിന്റെ തലക്കെട്ട്',
	'phalanx-type-user' => 'ഉപയോക്താവ്',
	'phalanx-type-answers-question-title' => 'ചോദ്യത്തിന്റെ തലക്കെട്ട്',
	'phalanx-type-answers-recent-questions' => 'സമീപകാല ചോദ്യങ്ങൾ',
	'phalanx-label-reason' => 'കാരണം:',
	'phalanx-label-expiry' => 'കാലാവധി:',
	'phalanx-label-type' => 'തരം:',
	'phalanx-label-lang' => 'ഭാഷ:',
	'phalanx-stats-table-type' => 'തരം',
	'phalanx-stats-table-create' => 'സൃഷ്ടിച്ചത്',
	'phalanx-stats-table-expire' => 'കാലാവധി',
	'phalanx-stats-table-language' => 'ഭാഷ',
	'phalanx-stats-table-text' => 'എഴുത്ത്',
	'phalanx-stats-table-reason' => 'കാരണം',
	'phalanx-stats-table-wiki-id' => 'വിക്കി ഐ.ഡി.',
	'phalanx-stats-table-wiki-name' => 'വിക്കിയുടെ പേര്‌',
	'phalanx-stats-table-wiki-url' => 'വിക്കിയുടെ യു.ആർ.എൽ.',
	'phalanx-stats-table-wiki-last-edited' => 'അവസാനം തിരുത്തിയത്',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'phalanx-desc' => 'Phalanx merupakan Mekanisme Pertahanan Spam Bersepadu',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mekanisme Pertahanan Spam Bersepadu',
	'phalanx-type-content' => 'kandungan laman',
	'phalanx-type-summary' => 'ringkasan laman',
	'phalanx-type-title' => 'tajuk laman',
	'phalanx-type-user' => 'pengguna',
	'phalanx-type-user-email' => 'e-mel',
	'phalanx-type-answers-question-title' => 'tajuk soalan',
	'phalanx-type-answers-recent-questions' => 'soalan terbaru',
	'phalanx-type-wiki-creation' => 'penciptaan wiki',
	'phalanx-add-block' => 'Gunakan sekatan',
	'phalanx-edit-block' => 'Simpan sekatan',
	'phalanx-label-filter' => 'Tapis:',
	'phalanx-label-reason' => 'Sebab:',
	'phalanx-label-expiry' => 'Tamat:',
	'phalanx-label-type' => 'Jenis:',
	'phalanx-label-lang' => 'Bahasa:',
	'phalanx-view-type' => 'Jenis sekatan...',
	'phalanx-view-blocker' => 'Cari mengikut teks penapis:',
	'phalanx-view-blocks' => 'Cari penapis',
	'phalanx-view-id' => 'Dapatkan penapis dengan ID:',
	'phalanx-view-id-submit' => 'Dapatkan penapis',
	'phalanx-format-text' => 'teks biasa',
	'phalanx-format-regex' => 'ungkapan nalar',
	'phalanx-format-case' => 'peka huruf besar kecil',
	'phalanx-format-exact' => 'tepat',
	'phalanx-tab-main' => 'Uruskan Penapis',
	'phalanx-tab-secondary' => 'Uji Penapis',
	'phalanx-block-success' => 'Sekatan ini berjaya ditambahkan',
	'phalanx-block-failure' => 'Ralat dialami ketika menambahkan sekatan',
	'phalanx-modify-success' => 'Sekatan ini berjaya diubah',
	'phalanx-modify-failure' => 'Ralat dialami ketika mengubah sekatan',
	'phalanx-modify-warning' => 'Anda sedang menyunting ID sekatan #$1.
Klik "{{int:phalanx-add-block}}" untuk menyimpan pengubahan anda!',
	'phalanx-test-description' => 'Ujian menyediakan teks melawan sekatan semasa.',
	'phalanx-test-submit' => 'Ujian',
	'phalanx-test-results-legend' => 'Hasil ujian',
	'phalanx-display-row-blocks' => 'sekatan: $1',
	'phalanx-display-row-created' => "dicipta oleh '''$1''' pada $2",
	'phalanx-link-unblock' => 'nyahsekat',
	'phalanx-link-modify' => 'ubah',
	'phalanx-link-stats' => 'statistik',
	'phalanx-reset-form' => 'Set semula borang',
	'phalanx-legend-input' => 'Cipta/ubahsuai penapis',
	'phalanx-legend-listing' => 'Penapis yang digunakan sekarang',
	'phalanx-unblock-message' => 'ID sekatan #$1 berjaya digugurkan',
	'phalanx-help-type-content' => 'Penapis ini menghalang penyimpanan suntingan jika kandungannya berpadan dengan mana-mana ungkapan yang dilarang.',
	'phalanx-help-type-summary' => 'Penapis ini menghalang penyimpanan suntingan jika ringkasannya berpadan dengan mana-mana ungkapan yang dilarang.',
	'phalanx-help-type-title' => 'Penapis ini menghalang penciptaan laman jika tajuknya berpadan dengan mana-mana ungkapan yang dilarang.

Ia tidak menghalang laman yang prawujud daripada disunting.',
	'phalanx-help-type-user' => 'Penapis ini menyekat seseorang pengguna (yang sama sekali dengan sekatan MediaWiki setempat), jika nama atau alamat IP berpadan dengan mana-mana nama atau alamat IP yang dilarang.',
	'phalanx-help-type-wiki-creation' => 'Penapis ini menghalang pembukaan wiki jika nama atau URL-nya berpadan dengan mana-mana ungkapan yang dilarang.',
	'phalanx-help-type-answers-question-title' => 'Penapis ini menyekat penciptaan (laman) soalan jika judulnya berpadan dengan mana-mana ungkapan yang dilarang.

Perhatian: berkesan di wiki jenis Soal Jawab (Answers) sahaja.',
	'phalanx-help-type-answers-recent-questions' => 'Penapis ini menghalang (laman) soalan daripada dipaparkan di sebilangan output (widget, senarai, senarai janaan tag). Ia tidak menghalang pembukaan laman-laman itu.

Perhatian: Berkesan di wiki jenis Soal Jawab (Answers) sahaja.',
	'phalanx-help-type-user-email' => 'Penapis ini melarang pembukaan akaun dengan alamat e-mel yang disekat.',
	'phalanx-user-block-reason-ip' => 'Alamat IP ini dihalang daripada menyunting atas kesalahan laku musnah atau gangguan yang dilakukan oleh anda atau sesiapa yang berkongsi alamat IP anda.
Jika anda percaya bahawa ini ialah kesilapan, sila [[Special:Contact|hubungi Wikia]].',
	'phalanx-user-block-reason-exact' => 'Nama pengguna atau alamat IP ini dihalang daripada menyunting atas kesalahan laku musnah atau gangguan.
Jika anda percaya bahawa ini ialah kesilapan, sila [[Special:Contact|hubungi Wikia]].',
	'phalanx-user-block-reason-similar' => 'Nama pengguna ini dihalang daripada menyunting atas kesalahan laku musnah atau gangguan oleh pengguna yang serupa namanya.
Sila cipta nama pengguna yang lain atau [[Special:Contact|hubungi Wikia]] tentang masalah ini.',
	'phalanx-user-block-new-account' => 'Nama pengguna ini tidak boleh dipakai untuk pendaftaran. Sila pilih satu lagi.',
	'phalanx-user-block-withreason-ip' => 'Alamat IP ini dihalang daripada menyunting di seluruh rangkaian Wikia atas kesalahan laku musnah atau apa jua gangguan yang dilakukan oleh anda atau sesiapa yang berkongsi alamat IP anda.
Jika anda percaya ini kesilapan, sila [[Special:Contact|hubungi Wikia]].<br />Penyekat juga memberikan sebab tambahan ini: $1.',
	'phalanx-user-block-withreason-exact' => 'Alamat IP ini dihalang daripada menyunting di seluruh rangkaian Wikia atas kesalahan laku musnah atau apa jua gangguan.
Jika anda percaya ini kesilapan, sila [[Special:Contact|hubungi Wikia]].<br />Penyekat juga memberikan sebab tambahan ini: $1.',
	'phalanx-user-block-withreason-similar' => 'Nama pengguna ini dihalang daripada menyunting di seluruh rangkaian Wikia atas kesalahan laku musnah atau gangguan oleh pengguna yang serupa namanya.
Sila [[Special:Contact|hubungi Wikia]] tentang masalah ini.<br />Penyekat juga memberikan sebab tambahan ini: $1.',
	'phalanx-title-move-summary' => 'Sebab yang anda isikan mengandungi ungkapan terlarang.',
	'phalanx-content-spam-summary' => 'Teks ini dijumpai dalam ringkasan laman.',
	'phalanx-stats-title' => 'Statistik Phalanx',
	'phalanx-stats-block-notfound' => 'ID sekatan tidak dijumpai',
	'phalanx-stats-table-id' => 'ID Sekatan',
	'phalanx-stats-table-user' => 'Ditambahkan oleh',
	'phalanx-stats-table-type' => 'Jenis',
	'phalanx-stats-table-create' => 'Dicipta',
	'phalanx-stats-table-expire' => 'Luput',
	'phalanx-stats-table-exact' => 'Tepat',
	'phalanx-stats-table-regex' => 'Ungkapan nalar',
	'phalanx-stats-table-case' => 'Kes',
	'phalanx-stats-table-language' => 'Bahasa',
	'phalanx-stats-table-text' => 'Teks',
	'phalanx-stats-table-reason' => 'Sebab',
	'phalanx-stats-row' => "di $4, penapis jenis '''$1''' menyekat '''$2''' pada $3",
	'phalanx-stats-row-per-wiki' => "pengguna '''$2''' disekat pada '''$4''' oleh ID penapis '''$3''' ($5) (jenis: '''$1''')",
	'phalanx-rule-log-name' => 'Log peraturan Phalanx',
	'phalanx-rule-log-header' => 'Ini ialah log penukaran peraturan phalanx.',
	'phalanx-email-rule-log-name' => 'Log peraturan e-mel Phalanx',
	'phalanx-email-rule-log-header' => 'Inilah log perubahan pada peraturan Phalanx untuk e-mel jenis.',
	'phalanx-rule-log-add' => 'Peraturan Phalanx ditambahkan: $1',
	'phalanx-rule-log-edit' => 'Peraturan Phalanx disunting: $1',
	'phalanx-rule-log-delete' => 'Peraturan Phalanx dipadamkan: $1',
	'phalanx-rule-log-details' => 'Penapis: "$1", jenis: "$2", sebab: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID Wiki',
	'phalanx-stats-table-wiki-name' => 'Nama Wiki',
	'phalanx-stats-table-wiki-url' => 'URL Wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Suntingan terkini',
	'phalanx-email-filter-hidden' => 'Penapis e-mel disorokkan. Anda tidak dibenarkan untuk membaca teksnya.',
	'action-phalanx' => 'menggunakan Mekanisme Pertahanan Spam Bersepadu',
	'right-phalanx' => 'Boleh menguruskan sekatan dan penapis spam sedunia',
	'right-phalanxexempt' => 'Dikecualikan daripada peraturan Phalanx',
	'right-phalanxemailblock' => 'Boleh memfailkan, melihat dan mengurus sekatan berasaskan e-mel',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'phalanx-desc' => 'Phalanx er en integrert mekanisme for forsvar mot spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrert mekanisme for forsvar mot spam',
	'phalanx-type-content' => 'sideinnhold',
	'phalanx-type-summary' => 'sidesammendrag',
	'phalanx-type-title' => 'sidetittel',
	'phalanx-type-user' => 'bruker',
	'phalanx-type-user-email' => 'e-post',
	'phalanx-type-answers-question-title' => 'spørsmålstittel',
	'phalanx-type-answers-recent-questions' => 'siste spørsmål',
	'phalanx-type-wiki-creation' => 'wiki-opprettelse',
	'phalanx-add-block' => 'Utfør blokkering',
	'phalanx-edit-block' => 'Lagre blokkering',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Årsak:',
	'phalanx-label-expiry' => 'Utløpstid:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Språk:',
	'phalanx-view-type' => 'Blokkeringstype...',
	'phalanx-view-blocker' => 'Søk etter filtrert tekst:',
	'phalanx-view-blocks' => 'Søkefilter',
	'phalanx-view-id' => 'Hent filter etter ID:',
	'phalanx-view-id-submit' => 'Hent filter',
	'phalanx-format-text' => 'ren tekst',
	'phalanx-format-regex' => 'regulært uttrykk',
	'phalanx-format-case' => 'skiller mellom store og små bokstaver',
	'phalanx-format-exact' => 'nøyaktig',
	'phalanx-tab-main' => 'Administrer filtre',
	'phalanx-tab-secondary' => 'Test filtre',
	'phalanx-block-success' => 'Blokkeringen ble lagt til',
	'phalanx-block-failure' => 'Det oppstod en feil ved innleggingen av blokkeringen',
	'phalanx-modify-success' => 'Blokkeringen ble endret',
	'phalanx-modify-failure' => 'Det oppstod en feil under endring av blokkeringen',
	'phalanx-modify-warning' => 'Du redigerer blokkering ID #$1.
Å trykke «{{int:phalanx-add-block}}» vil lagre endringene!',
	'phalanx-test-description' => 'Testen ga tekst mot aktuelle blokkeringer.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Testresultater',
	'phalanx-display-row-blocks' => 'blokkeringer: $1',
	'phalanx-display-row-created' => "opprettet av '''$1''' på $2",
	'phalanx-link-unblock' => 'opphev blokkering',
	'phalanx-link-modify' => 'endre',
	'phalanx-link-stats' => 'statistikk',
	'phalanx-reset-form' => 'Tilbakestill skjema',
	'phalanx-legend-input' => 'Opprett eller endre filter',
	'phalanx-legend-listing' => 'For øyeblikket brukte filtre',
	'phalanx-unblock-message' => 'Blokkering ID #$1 ble fjernet',
	'phalanx-help-type-content' => 'Dette filteret hindrer en redigering fra å lagres om innholdet samsvarer med noen av de svartelistede setningene.',
	'phalanx-help-type-summary' => 'Dette filteret hindrer en redigering fra å lagres om det oppgitte sammendraget samsvarer med noen av de svartelistede setningene.',
	'phalanx-help-type-title' => 'Dette filteret hindrer en side fra å bli opprettet hvis tittelen samsvarer med noen av de svartelistede setningene.

Det hindrer ikke en allerede eksisterende side i å redigeres.',
	'phalanx-help-type-user' => 'Dette filteret blokkerer en bruker (nøyaktig det samme som en lokal MediaWiki-blokkering) dersom navnet eller IP-adressen samsvarer et av de svartelistede navnene eller IP-adressene.',
	'phalanx-help-type-wiki-creation' => 'Dette filteret hindrer en wiki i å opprettes om navnet eller URL-en samsvarer med noen av de svartelistede setningene.',
	'phalanx-help-type-answers-question-title' => 'Dette filteret blokkerer et spørsmål (en side) fra å opprettes dersom tittelen samsvarer med noen av de svartelistede setningene.

Note: fungerer kun på Svar-wikier.',
	'phalanx-help-type-answers-recent-questions' => 'Dette filteret hindrer spørsmål (sider) fra å vises i en rekke kanaler (skjermelementer, lister, tag-genererte lister).
Det hindrer ikke disse sidene i å opprettes.

Note: fungerer kun på Svar-wikier.',
	'phalanx-help-type-user-email' => 'Dette filteret hindrer kontoopprettelse med en blokkert e-postadresse.',
	'phalanx-user-block-reason-ip' => 'Denne IP-adressen er forhindret i å redigere over hele Wikia-nettverket  grunnet vandalisme eller annt hærverk fra deg eller noen som deler din IP-adresse.
Om du mener dette er en feil, vennligst [[Special:Contact|kontakt Wikia]].',
	'phalanx-user-block-reason-exact' => 'Dette brukernavnet eller IP-adressen er forhindret i år redigere over hele Wikia-nettverket grunnet vandalisme eller annet hærverk. 
Om du mener dette er en feil, vennligst [[Special:Contact|kontakt Wikia]].',
	'phalanx-user-block-reason-similar' => 'Dette brukernavnet er forhindret i å redigere over hele Wikia-nettverket grunnet vandalisme eller annet hærverk av en bruker med lignende navn.
Vennligst opprett et alternativt brukernavn eller [[Special:Contact|kontakt Wikia]] om problemet.',
	'phalanx-user-block-new-account' => 'Brukernavnet er ikke tilgjengelig for registrering. Velg et annet.',
	'phalanx-user-block-withreason-ip' => 'Denne IP-adressen er forhindret i å redigere over hele Wikia-nettverket grunnet vandalisme eller annet hærverk fra deg eller noen deler din IP-adresse.
Om du mener dette er en feil, vennligst [[Special:Contact|kontakt Wikia]].<br />Blokkereren la i tillegg til denne begrunnelsen: $1.',
	'phalanx-user-block-withreason-exact' => 'Dette brukernavnet eller denne IP-adressen er forhindret i å redigere over hele Wikia-nettverket grunnet vandalisme eller annet hærverk.
Om du mener dette er en feil, vennligst [[Special:Contact|kontakt Wikia]].<br />Blokkereren la i tillegg til denne begrunnelsen: $1.',
	'phalanx-user-block-withreason-similar' => 'Dette brukernavnet er forhindret i å redigere over hele Wikia-nettverket grunnet vandalisme eller annet hærverkav en bruker med lignende navn.
Vennligst [[Special:Contact|kontakt Wikia]] om problemet.<br />Blokkereren la i tillegg til denne begrunnelsen: $1.',
	'phalanx-title-move-summary' => 'Årsaken du angav inneholdt en blokkert setning.',
	'phalanx-content-spam-summary' => 'Teksten ble funnet i sidens sammendrag.',
	'phalanx-stats-title' => 'Phalanx-statistikk',
	'phalanx-stats-block-notfound' => 'blokkerings-ID ikke funnet',
	'phalanx-stats-table-id' => 'Blokkerings-ID',
	'phalanx-stats-table-user' => 'Lagt til av',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Opprettet',
	'phalanx-stats-table-expire' => 'Utløper',
	'phalanx-stats-table-exact' => 'Nøyaktig',
	'phalanx-stats-table-regex' => 'Regulært uttrykk',
	'phalanx-stats-table-case' => 'Sak',
	'phalanx-stats-table-language' => 'Språk',
	'phalanx-stats-table-text' => 'Tekst',
	'phalanx-stats-table-reason' => 'Årsak',
	'phalanx-stats-row' => "på $4, filtertype '''$1''' blokkerte '''$2''' på $3",
	'phalanx-stats-row-per-wiki' => "bruker '''$2''' ble blokkert på '''$4''' av filter ID '''$3''' ($5) (type: '''$1''')",
	'phalanx-rule-log-name' => 'Logg over regler i Phalanx',
	'phalanx-rule-log-header' => 'Dette er en logg over endringer i phalanx-reglene.',
	'phalanx-email-rule-log-name' => 'Logg over e-post-regler i Phalanx',
	'phalanx-email-rule-log-header' => 'Dette er en logg over endringer på Phalanx-reglene for innskriving av e-post.',
	'phalanx-rule-log-add' => 'Phalanx-regel lagt til: $1',
	'phalanx-rule-log-edit' => 'Phalanx-regel redigert: $1',
	'phalanx-rule-log-delete' => 'Phalanx-regel slettet: $1',
	'phalanx-rule-log-details' => 'Filter: «$1», type: «$2», årsak: «$3»',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wiki-navn',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Sist redigert',
	'phalanx-email-filter-hidden' => 'E-post-filteret er skjult. Du har ikke tillatelse til å vise teksten.',
	'action-phalanx' => 'bruk den integrerte mekanismen for forsvar mot spam',
	'right-phalanx' => 'Kan administrere globale blokkeringer og spamfiltre',
	'right-phalanxexempt' => 'Fritatt fra Phalanx-reglene',
	'right-phalanxemailblock' => 'Kan ordne, vise og administrere e-post-baserte blokkeringer',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'phalanx-desc' => 'Phalanx  is een Geïntegreerd Spamafweersysteem',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Geïntegreerd Spamafweersysteem',
	'phalanx-type-content' => 'paginainhoud',
	'phalanx-type-summary' => 'paginasamenvatting',
	'phalanx-type-title' => 'paginanaam',
	'phalanx-type-user' => 'gebruiker',
	'phalanx-type-user-email' => 'e-mail',
	'phalanx-type-answers-question-title' => 'vraag',
	'phalanx-type-answers-recent-questions' => 'recente vragen',
	'phalanx-type-wiki-creation' => 'wikiaanmaak',
	'phalanx-add-block' => 'Blokkade toepassen',
	'phalanx-edit-block' => 'Blokkade opslaan',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Reden:',
	'phalanx-label-expiry' => 'Vervalt:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Taal:',
	'phalanx-view-type' => 'Type blokkade...',
	'phalanx-view-blocker' => 'Zoeken op filtertekst:',
	'phalanx-view-blocks' => 'Filters doorzoeken',
	'phalanx-view-id' => 'Filter op nummer zoeken:',
	'phalanx-view-id-submit' => 'Filter zoeken',
	'phalanx-format-text' => 'tekst zonder opmaak',
	'phalanx-format-regex' => 'reguliere expressie',
	'phalanx-format-case' => 'hoofdlettergevoelig',
	'phalanx-format-exact' => 'precies',
	'phalanx-tab-main' => 'Filters beheren',
	'phalanx-tab-secondary' => 'Filters testen',
	'phalanx-block-success' => 'De blokkade is toegevoegd',
	'phalanx-block-failure' => 'Er is een fout opgetreden tijdens het toevoegen van de blokkade',
	'phalanx-modify-success' => 'De blokkade is aangepast',
	'phalanx-modify-failure' => 'Er is een fout opgetreden tijdens het aanpassen van de blokkade',
	'phalanx-modify-warning' => 'U bent blokkadenummer #$1 aan het bewerken.
Als u op "{{int:phalanx-add-block}}" klikt, worden uw wijzigingen opgeslagen.',
	'phalanx-test-description' => 'Opgegeven tekst tegen huidige blokkades testen.',
	'phalanx-test-submit' => 'Testen',
	'phalanx-test-results-legend' => 'Testresulaten',
	'phalanx-display-row-blocks' => 'blokkades: $1',
	'phalanx-display-row-created' => "aangemaakt door '''$1''' op $2",
	'phalanx-link-unblock' => 'blokkade opheffen',
	'phalanx-link-modify' => 'aanpassen',
	'phalanx-link-stats' => 'statistieken',
	'phalanx-reset-form' => 'Formulier opnieuw instellen',
	'phalanx-legend-input' => 'Filter aanmaken of aanpassen',
	'phalanx-legend-listing' => 'Huidige actieve filters',
	'phalanx-unblock-message' => 'Blokkadenummer #$1 is verwijderd',
	'phalanx-help-type-content' => 'Dit filter voorkomt dat een bewerking wordt opgeslagen als in de inhoud tekst voorkomt die op de zwarte lijst staat.',
	'phalanx-help-type-summary' => 'Dit filter voorkomt dat een bewerking wordt opgeslagen als in de samenvatting tekst voorkomt die op de zwarte lijst staat.',
	'phalanx-help-type-title' => 'Dit filter voorkomt dat een pagina wordt aangemaakt als in de paginanaam tekst voorkomt die op de zwarte lijst staat.

Dit filter voorkomt niet dat een bestaande pagina bewerkt kan worden.',
	'phalanx-help-type-user' => 'Dit filter blokkeert een gebruiker (net zoals lokale blokkades in MediaWiki) als de gebruikersnaam of het IP-adres voorkomt in de zwarte lijst met namen en IP-adressen.',
	'phalanx-help-type-wiki-creation' => 'Dit filter voorkomt dat een wiki wordt aangemaakt als tekst uit de naam of de URL op de zwarte lijst staat.',
	'phalanx-help-type-answers-question-title' => "Dit filter voorkomt dat een pagina wordt aangemaakt als tekst uit de paginanaam op de zwarte lijst staat.

Dit werkt alleen voor Antwoordwiki's.",
	'phalanx-help-type-answers-recent-questions' => "Dit filter voorkomt dat vragen (pagina's) worden weergegeven in een aantal lijsten (widgets, lijsten, labelgebaseerde lijsten).
Het voorkomt niet dat pagina's worden aangemaakt.

Dit werkt alleen voor Antwoordwiki's.",
	'phalanx-help-type-user-email' => 'Dit filter voorkomt het aanmaken van gebruikers met een geblokkeerd e-mailadres.',
	'phalanx-user-block-reason-ip' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken in het gehele Wikia-netwerk wegens vandalisme of verstoring door u of door iemand met hetzelfde IP-adres.
Als u denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].',
	'phalanx-user-block-reason-exact' => 'Deze (anonieme) gebruiker mag niet bewerken in het hele Wikia-netwerk wegens vandalisme of verstoring.
Als u denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]]',
	'phalanx-user-block-reason-similar' => 'Deze gebruiker mag niet bewerken in het hele Wikia-netwerk wegens vandalisme of verstoring door een gebruiker met een gelijkluidende naam.
Kies een andere gebruikersnaam of [[Special:Contact|neem contact op met Wikia]] over het probleem.',
	'phalanx-user-block-new-account' => 'De gebruikersnaam kan niet geregistreerd worden. Kies een andere naam.',
	'phalanx-user-block-withreason-ip' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken in het gehele Wikia-netwerk wegens vandalisme of verstoring door u of door iemand met hetzelfde IP-adres.
Als u denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].<br />De reden voor blokkeren is: $1.',
	'phalanx-user-block-withreason-exact' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken in het gehele Wikia-netwerk wegens vandalisme of verstoring door u of door iemand met hetzelfde IP-adres.
Als u denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].<br />De reden voor blokkeren is: $1.',
	'phalanx-user-block-withreason-similar' => 'Deze gebruiker mag niet bewerken in het hele Wikia-netwerk wegens vandalisme of verstoring door een gebruiker met een gelijkluidende naam.
Kies een andere gebruikersnaam of [[Special:Contact|neem contact op met Wikia]] over het probleem.<br />De reden voor blokkeren is: $1.',
	'phalanx-title-move-summary' => 'De opgegeven reden bevat een tekstdeel dat op de zwarte lijst staat.',
	'phalanx-content-spam-summary' => 'De tekst is aangetroffen in de bewerkingssamenvatting.',
	'phalanx-stats-title' => 'Phalanx-statistieken',
	'phalanx-stats-block-notfound' => 'blokkadenummer niet gevonden',
	'phalanx-stats-table-id' => 'Blokkadenummer',
	'phalanx-stats-table-user' => 'Toegevoegd door',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Aangemaakt',
	'phalanx-stats-table-expire' => 'Vervalt',
	'phalanx-stats-table-exact' => 'Precies',
	'phalanx-stats-table-regex' => 'Reguliere expressie',
	'phalanx-stats-table-case' => 'Hoofd- of kleine letters',
	'phalanx-stats-table-language' => 'Taal',
	'phalanx-stats-table-text' => 'Tekst',
	'phalanx-stats-table-reason' => 'Reden',
	'phalanx-stats-row' => "om $4 heeft filtertype '''$1''' '''$2''' geblokkeerd op $3",
	'phalanx-stats-row-per-wiki' => "gebruiker '''$2''' is geblokkeerd op '''$4''' door filternummer '''$3''' ($5) (type '''$1''')",
	'phalanx-rule-log-name' => 'Logboek Phalanx-regels',
	'phalanx-rule-log-header' => 'Dit is een logboek met wijzigingen aan Phalanx-regels',
	'phalanx-email-rule-log-name' => 'Logboek Phalanxe-mailregels',
	'phalanx-email-rule-log-header' => 'Dit is een logboek met de wijzingen aan Phalanx-regels voor het type e-mail.',
	'phalanx-rule-log-add' => 'Phalanx-regel toegevoegd: $1',
	'phalanx-rule-log-edit' => 'Phalanx-regel gewijzigd: $1',
	'phalanx-rule-log-delete' => 'Phalanx-regel verwijderd: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", type: "$2", reden: "$3"',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wikinaam',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Laatste bewerking',
	'phalanx-email-filter-hidden' => 'E-mailfilter verborgen. U hebt geen rechten om de tekst te bekijken.',
	'action-phalanx' => 'het Integrated Spam Defense Mechanism te gebruiken',
	'right-phalanx' => 'Kan globale blokkades en spamfilters beheren',
	'right-phalanxexempt' => 'Kan Phalanx-regels omzeilen',
	'right-phalanxemailblock' => 'Kan e-mailgebaseerde blokkades toevoegen, bekijken en beheren',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'phalanx-modify-warning' => 'Je bent blokkadenummer #$1 aan het bewerken.
Als je op "{{int:phalanx-add-block}}" klikt, worden je wijzigingen opgeslagen.',
	'phalanx-user-block-reason-ip' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken in het gehele Wikia-netwerk wegens vandalisme of verstoring door jou of door iemand met hetzelfde IP-adres.
Als je denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].',
	'phalanx-user-block-reason-exact' => 'Deze (anonieme) gebruiker mag niet bewerken in het hele Wikia-netwerk wegens vandalisme of verstoring.
Als je denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]]',
	'phalanx-user-block-withreason-ip' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken in het gehele Wikia-netwerk wegens vandalisme of verstoring door jou of door iemand met hetzelfde IP-adres.
Als je denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].<br />De reden voor blokkeren is: $1.',
	'phalanx-user-block-withreason-exact' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken in het gehele Wikia-netwerk wegens vandalisme of verstoring door jou of door iemand met hetzelfde IP-adres.
Als je denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].<br />De reden voor blokkeren is: $1.',
	'phalanx-title-move-summary' => 'De samenvatting die je hebt opgegeven bevat niet toegelaten tekst.',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'phalanx-type-user' => 'Benudza',
	'phalanx-label-filter' => 'Filda:',
	'phalanx-test-submit' => 'Teschd',
	'phalanx-test-results-legend' => 'Teschdgewniss',
	'phalanx-link-modify' => 'änere',
	'phalanx-stats-table-expire' => 'Gildisch bis',
	'phalanx-stats-table-exact' => 'Rischdisch',
	'phalanx-stats-table-text' => 'Tegschd',
	'phalanx-stats-table-reason' => 'Grund:',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wikinoame',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => "Z'ledsch g'änad",
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Odder
 * @author Sovq
 */
$messages['pl'] = array(
	'phalanx-desc' => 'Phalanx jest zintegrowanym mechanizmem obrony przed spamem',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - zintegrowany mechanizm obrony przed spamem',
	'phalanx-type-content' => 'zawartość strony',
	'phalanx-type-summary' => 'podsumowanie strony',
	'phalanx-type-title' => 'tytuł strony',
	'phalanx-type-user' => 'użytkownik',
	'phalanx-type-user-email' => 'e‐mail',
	'phalanx-type-answers-question-title' => 'tytuł pytania',
	'phalanx-type-answers-recent-questions' => 'ostatnie pytania',
	'phalanx-type-wiki-creation' => 'tworzenie wiki',
	'phalanx-add-block' => 'Zastosuj blokadę',
	'phalanx-edit-block' => 'Zapisz blokadę',
	'phalanx-label-filter' => 'Filtr:',
	'phalanx-label-reason' => 'Powód:',
	'phalanx-label-expiry' => 'Wygaśnięcie:',
	'phalanx-label-type' => 'Typ:',
	'phalanx-label-lang' => 'Język:',
	'phalanx-view-type' => 'Typ blokady...',
	'phalanx-view-blocker' => 'Szukaj według filtru tekstu:',
	'phalanx-view-blocks' => 'Filtry wyszukiwania',
	'phalanx-view-id' => 'Filtrowanie według Identyfikatora:',
	'phalanx-view-id-submit' => 'Pobierz filtr',
	'phalanx-format-text' => 'zwykły tekst',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'bierz pod uwagę wielkość liter',
	'phalanx-format-exact' => 'dokładny',
	'phalanx-tab-main' => 'Zarządzanie filtrami',
	'phalanx-tab-secondary' => 'Testuj filtry',
	'phalanx-block-success' => 'Pomyślnie dodano blokadę',
	'phalanx-block-failure' => 'Wystąpił błąd podczas dodawania blokady',
	'phalanx-modify-success' => 'Blokada została pomyślnie zmodyfikowana',
	'phalanx-modify-failure' => 'Wystąpił błąd podczas modyfikowania blokady',
	'phalanx-modify-warning' => 'Edytujesz blokadę o ID #$1.
Kliknięcie "{{int:phalanx-edit-block}}" spowoduje zapisanie zmian!',
	'phalanx-test-description' => 'Sprawdź wskazany tekst pod kątem aktualnych blokad.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Wyniki testu',
	'phalanx-display-row-blocks' => 'blokady: $1',
	'phalanx-display-row-created' => "utworzona przez '''$1''' na $2",
	'phalanx-link-unblock' => 'odblokuj',
	'phalanx-link-modify' => 'zmień',
	'phalanx-link-stats' => 'statystyki',
	'phalanx-reset-form' => 'Wyzeruj formularz',
	'phalanx-legend-input' => 'Tworzenie lub modyfikowanie filtru',
	'phalanx-legend-listing' => 'Obecnie stosowane filtry',
	'phalanx-unblock-message' => 'Blokada o ID #$1  została pomyślnie usunięta',
	'phalanx-help-type-content' => 'Ten filtr zapobiega zapisowi zmiany, jeśli zawartość pasuje do dowolnego z wyrażeń zabronionych.',
	'phalanx-help-type-summary' => 'Ten filtr zapobiega zapisowi zmiany, jeśli wprowadzone podsumowanie pasuje do dowolnego z wyrażeń zabronionych.',
	'phalanx-help-type-title' => 'Ten filtr zapobiega utworzeniu strony, jeśli jego nazwa pasuje do dowolnego wyrażeń zabronionych.

Nie uniemożliwia edycji strony utworzonej wcześniej.',
	'phalanx-help-type-user' => 'Ten filtr blokuje użytkownika (dokładnie tak samo jak blokada lokalna MediaWiki), jeśli nazwa lub adres IP odpowiada jednej z zabronionych nazw lub adresów IP.',
	'phalanx-help-type-wiki-creation' => 'Ten filtr zapobiega utworzeniu wiki, jeśli jego nazwa lub adres URL odpowiada dowolnej z zabronionych fraz.',
	'phalanx-help-type-answers-question-title' => 'Ten filtr blokuje pytanie (stronę) przed utworzeniem, jeśli jego nazwa pasuje do dowolnego z zabronionych wyrażeń.

Uwaga: działa tylko na wiki typu Odpowiedzi.',
	'phalanx-help-type-answers-recent-questions' => 'Ten filtr uniemożliwia wyświetlenie  pytań (stron)  w pewnych wyjściach (widżety, listy, wykazy generowane według znacznika).
Nie blokuje on utworzenia tych stron.

Uwaga: działa tylko z wiki typu Odpowiedzi.',
	'phalanx-help-type-user-email' => 'Ten filtr zapobiega tworzeniu kont przy użyciu zablokowanego adresu e-mail.',
	'phalanx-user-block-reason-ip' => 'Ten adres IP jest został zablokowany i nie posiada praw edycji w całej Wikii z powodu wandalizmu lub innego typu naruszeń zasad czynionych przez Ciebie lub przez inną osobę, która dzieli twój adres IP.
Jeśli uważasz, że jest to błąd, proszę [[Special:Contact|skontaktuj się z nami]].',
	'phalanx-user-block-reason-exact' => 'Ta nazwa użytkownika lub adres IP jest zablokowany i nie ma prawa do edycji na całej Wikii ze względu na wandalizm lub inne nadużycia.
Jeśli uważasz, że jest to błąd, prosimy [[Special:Contact|skontaktuj się z nami]].',
	'phalanx-user-block-reason-similar' => 'Na tą nazwę użytkownika nałożono blokadę edycji w całej Wikii spowodowaną wandalizmem lub innymi naruszeniami zasad przez użytkownika o podobnej nazwie.
Prosimy [[Special:Contact|o kontakt]] w sprawie problemu.',
	'phalanx-user-block-new-account' => 'Nazwa użytkownika nie jest dostępna do zarejestrowania. Proszę wybrać inną.',
	'phalanx-user-block-withreason-ip' => 'Ten adres IP został zablokowany i nie posiada praw edycji na całej Wikii z powodu wandalizmu lub innego typu naruszeń zasad czynionych przez Ciebie lub przez inną osobę, która dzieli twój adres IP.
Jeśli uważasz, że jest to błąd, proszę [[Special:Contact|skontaktuj się z nami]].<br />Blokujący podał również powód dodatkowy: $1.',
	'phalanx-user-block-withreason-exact' => 'Ta nazwa użytkownika lub adres IP zostały zablokowane i nie posiadają praw edycji na całej Wikii z powodu wandalizmu lub innego typu naruszeń zasad.
Jeśli uważasz, że jest to błąd, prosimy [[Special:Contact|skontaktuj się z nami]].<br />Blokujący podał również powód dodatkowy: $1.',
	'phalanx-user-block-withreason-similar' => 'Ta nazwa użytkownika została zablokowana i nie posiada praw edycji ma całej Wikii z powodu wandalizmu lub innego typu naruszeń zasad czynionych przez użytkownika o podobnej nazwie.
Prosimy [[Special:Contact|skontaktuj się z nami]] w sprawie problemu.<br />Blokujący podał również powód dodatkowy: $1.',
	'phalanx-title-move-summary' => 'Wybrany powód zawiera zabroniony zwrot.',
	'phalanx-content-spam-summary' => 'Tekst został odnaleziony w opisie zmian.',
	'phalanx-stats-title' => 'Statystyki Phalanx',
	'phalanx-stats-block-notfound' => 'nie odnaleziono Identyfikatora blokady',
	'phalanx-stats-table-id' => 'Identyfikator blokady',
	'phalanx-stats-table-user' => 'Dodana przez',
	'phalanx-stats-table-type' => 'Typ',
	'phalanx-stats-table-create' => 'Utworzono',
	'phalanx-stats-table-expire' => 'Wygasa',
	'phalanx-stats-table-exact' => 'Dokładny',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Przypadek',
	'phalanx-stats-table-language' => 'Język',
	'phalanx-stats-table-text' => 'Tekst',
	'phalanx-stats-table-reason' => 'Powód',
	'phalanx-stats-row' => "w $4, typ filtru '''$1''' zablokowano '''$2''' na $3",
	'phalanx-stats-row-per-wiki' => "użytkownik '''$2''' zablokował na '''$4''' wedle ID filtru '''$3''' ($5) (typ: '''$1''')",
	'phalanx-rule-log-name' => 'Rejestr Phalanx',
	'phalanx-rule-log-header' => 'Jest to rejestr zmian reguł Phalanx.',
	'phalanx-email-rule-log-name' => 'rejestr filtrów e-mailowych Phalanx',
	'phalanx-email-rule-log-header' => 'To jest rejestr zmian w filtrach Phalanx dotyczących e-maili.',
	'phalanx-rule-log-add' => 'Reguła Phalanx dodana: $1',
	'phalanx-rule-log-edit' => 'Reguła Phalanx zmieniona: $1',
	'phalanx-rule-log-delete' => 'Reguła Phalanx usunięta: $1',
	'phalanx-rule-log-details' => 'Filtr: " $1 ", typ: " $2 ", powód: " $3 "',
	'phalanx-stats-table-wiki-id' => 'ID Wiki',
	'phalanx-stats-table-wiki-name' => 'Nazwa Wiki',
	'phalanx-stats-table-wiki-url' => 'Adres URL Wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Ostatnia zmiana',
	'phalanx-email-filter-hidden' => 'Filtr e-mailowy ukryty. Nie masz uprawnień aby wyświetlić tekst.',
	'action-phalanx' => 'używania zintegrowanego mechanizmu obrony przed spamem',
	'right-phalanx' => 'Zarządzenie globalnymi blokadami i filtrami spamu',
	'right-phalanxexempt' => 'Wyłączony z reguł Phalanx',
	'right-phalanxemailblock' => 'Umożliwia włączanie, przeglądanie i zarządzanie blokadami opartymi o e-mail',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'phalanx-desc' => "Phalanx a l'é un Mecanism Antegrà ëd Difèisa da la rumenta",
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mecanism Antegrà ëd Difèisa da la rumenta',
	'phalanx-type-content' => 'contnù ëd la pàgina',
	'phalanx-type-summary' => 'resumé ëd la pàgina',
	'phalanx-type-title' => 'tìtol ëd la pàgina',
	'phalanx-type-user' => 'utent',
	'phalanx-type-user-email' => 'pòsta eletrònica',
	'phalanx-type-answers-question-title' => 'tìtol dla chestion',
	'phalanx-type-answers-recent-questions' => 'chestion recente',
	'phalanx-type-wiki-creation' => 'creassion ëd wiki',
	'phalanx-add-block' => 'Apliché ël blocagi',
	'phalanx-edit-block' => 'Argistré ël blocagi',
	'phalanx-label-filter' => 'Filtr:',
	'phalanx-label-reason' => 'Rason:',
	'phalanx-label-expiry' => 'Fin:',
	'phalanx-label-type' => 'Sòrt:',
	'phalanx-label-lang' => 'Lenga:',
	'phalanx-view-type' => 'Sòrt ëd blocagi...',
	'phalanx-view-blocker' => 'Sërché an filtrand ël test:',
	'phalanx-view-blocks' => "Filtr d'arserca",
	'phalanx-view-id' => 'Filtré për ID:',
	'phalanx-view-id-submit' => 'Filtré',
	'phalanx-format-text' => 'mach test',
	'phalanx-format-regex' => 'espression rassional',
	'phalanx-format-case' => 'sensìbil a minùscol e majùscol',
	'phalanx-format-exact' => 'precis',
	'phalanx-tab-main' => 'Gestì ij Filtr',
	'phalanx-tab-secondary' => 'Filtr ëd Preuva',
	'phalanx-block-success' => "Ël blocagi a l'é stàit giontà për da bin",
	'phalanx-block-failure' => "A-i é staje n'eror an giontand ël blocagi",
	'phalanx-modify-success' => "Ël blocagi a l'é stàit modificà për da bin",
	'phalanx-modify-failure' => "A-i é staje n'eror durant la modìfica dël blocagi",
	'phalanx-modify-warning' => "A l'é an camin ch'a modìfica ël blocagi d'identificativ #$1. 
Sgnacand ancima a «{{int:phalanx-edit-block}}» soe modìfiche a saran argistrà!",
	'phalanx-test-description' => 'Test fornì për la preuva contra ij blocagi corent.',
	'phalanx-test-submit' => 'Preuva',
	'phalanx-test-results-legend' => 'Arzultà dla preuva',
	'phalanx-display-row-blocks' => 'blocagi: $1',
	'phalanx-display-row-created' => "creà da '''$1''' ai $2",
	'phalanx-link-unblock' => 'dësbloché',
	'phalanx-link-modify' => 'modìfica',
	'phalanx-link-stats' => 'statìstiche',
	'phalanx-reset-form' => "Formolari d'anulament",
	'phalanx-legend-input' => 'Creé o modifiché ël filtr',
	'phalanx-legend-listing' => 'Filtr aplicà al moment',
	'phalanx-unblock-message' => "ël blocagi d'identificativ #$1 a l'é stàit gavà për da bin",
	'phalanx-help-type-content' => 'Ës filtr a ampediss che na modìfica a sia salvà, se sò contnù a corispond a chèich fras dla lista nèira.',
	'phalanx-help-type-summary' => 'Ës filtr a ampediss che na modìfica a sia salvà, se ël resumé dàit a corispond a chèich fras dla lista nèira.',
	'phalanx-help-type-title' => 'Ës filtr a ampediss che na pàgina a sia creà, se sò tìtol a corispond a chèich fras dla lista nèira.

A ampediss pa che na pàgina esistenta a sia modificà.',
	'phalanx-help-type-user' => "Ës filtr a blòca n'utent (pròpi l'istess com un blocagi local MediaWiki), se ël nòm o l'adrëssa IP a corispond a un dij nòm o dj'adrësse IP dla lista nèira.",
	'phalanx-help-type-wiki-creation' => 'Ës filtr a ampediss che na wiki a sia creà, se sò nòm o adrëssa a corispond a chèich fras dla lista nèira.',
	'phalanx-help-type-answers-question-title' => 'Sto filtr a blòca la creassion ëd na chestion (pàgina), se sò tìtol a corispond a chèich fras dla lista nèira.

Nòta: a marcia mach dzora le wiki ëd sòrt Rispòste.',
	'phalanx-help-type-answers-recent-questions' => 'Sto filtr a ampediss ëd visualisé dle chestion (pàgine) ant vàire surtìe (widget, liste, liste generà da tichëtte). 
A ampediss pa che coste pàgine a sio creà.

Nòta: a marcia mach dzora le wiki ëd sòrt Rispòste.',
	'phalanx-help-type-user-email' => "Sto filtr a ampediss la creassion ëd cont dovrand n'adrëssa ëd pòsta eletrònica blocà.",
	'phalanx-user-block-reason-ip' => "St'adrëssa IP-sì a peul pa modifiché an tuta la rej Wikia për ëd vandalism o d'àutri dann fàit da chiel o da cheidun che a condivid soa adrëssa IP.
S'a chërde che sòn a sia n'eror, për piasì [[Special:Contact|ch'a contata Wikia]].",
	'phalanx-user-block-reason-exact' => "Së stranòm costa adrëssa IP a peul pa modifiché an tuta la rej Wikia për ëd vandalism o d'àutri dann.
S'a chërd che a sia n'eror, për piasì [[Special:Contact|ch'a contata Wikia]].",
	'phalanx-user-block-reason-similar' => "Së stranòm a peul pa modifiché an tuta la rèj Wikia për ëd vandalism o d'àutri dann fàit da n'utent con në stranòm ch'a jë smija.
Për piasì [[Special:Contact|ch'a contata Wikia]] a propòsit d'ës problema.",
	'phalanx-user-block-new-account' => "Lë stranòm utent a l'é nne disponìbil për la registrassion. Për piasì, ch'a na serna n'àutr.",
	'phalanx-user-block-withreason-ip' => "St'adrëssa IP-sì a peul pa modifiché an tuta la rèj Wikia për ëd vandalism o d'àutri dann fàit da chiel o da cheidun che a condivid soa adrëssa IP.
S'a chërd che sòn a sia n'eror, për piasì [[Special:Contact|ch'a contata Wikia]].<br />Chi ch'a l'ha blocalo a l'ha ëdcò butà costa rason adissional: $1.",
	'phalanx-user-block-withreason-exact' => "Së stranòm o costa adrëssa IP a peul pa modifiché an tuta la rèj Wikia për ëd vandalism o d'àutri dann.
S'a chërd che sòn a sia n'eror, për piasì [[Special:Contact|ch'a contata Wikia]].<br />Chi a l'ha butà ël blocagi a l'ha ëdcò butà costa rason adissional: $1.",
	'phalanx-user-block-withreason-similar' => "Së stranòm-sì a peul pa modifichè an tuta la rèj Wikia për ëd vandalism o d'àutri dann fàit da n'utent con në stranòm ch'a jë smija.
Për piasì [[Special:Contact|ch'a contata Wikia]] për parlé dël problema.<br />Chi a l'ha blocalo a l'ha ëdcò butà sta rason adissional: $1.",
	'phalanx-title-move-summary' => "La rason ch'a l'ha anserì a contnisìa na fras blocà.",
	'phalanx-content-spam-summary' => "Ël test a l'é stàit trovà ant ël somari dla pàgina.",
	'phalanx-stats-title' => 'Statìstiche ëd Phalanx',
	'phalanx-stats-block-notfound' => 'Identificativ ëd blocagi nen trovà',
	'phalanx-stats-table-id' => 'Identificativ ëd blocagi',
	'phalanx-stats-table-user' => 'Giontà da',
	'phalanx-stats-table-type' => 'Sòrt',
	'phalanx-stats-table-create' => 'Creà',
	'phalanx-stats-table-expire' => 'Scadensa',
	'phalanx-stats-table-exact' => 'Precis',
	'phalanx-stats-table-regex' => 'Espression regolar',
	'phalanx-stats-table-case' => 'Cas',
	'phalanx-stats-table-language' => 'Lenga',
	'phalanx-stats-table-text' => 'Test',
	'phalanx-stats-table-reason' => 'Rason',
	'phalanx-stats-row' => "a $4, la sòrt ëd filtr '''$1''' a l'ha blocà '''$2''' su $3",
	'phalanx-stats-row-per-wiki' => "l'utent '''$2''' a l'é stàit blocà dzor '''$4''' dal filtr d'identificativ '''$3''' ($5) (sòrt: '''$1''')",
	'phalanx-rule-log-name' => 'Registr ëd le régole Phalanx',
	'phalanx-rule-log-header' => "Cost-sì a l'é un registr dle modìfiche a le régole ëd phalanx.",
	'phalanx-email-rule-log-name' => 'Registr ëd le régole ëd pòsta eletrònica ëd Phalanx',
	'phalanx-email-rule-log-header' => "Cost-sì a l'é un registr dle modìfiche a le régole ëd Phalanx për la sòrt ëd pòsta eletrònica.",
	'phalanx-rule-log-add' => 'Régola Phalanx giontà: $1',
	'phalanx-rule-log-edit' => 'Régola Phalanx modificà: $1',
	'phalanx-rule-log-delete' => 'Régola Phalanx sganfà: $1',
	'phalanx-rule-log-details' => 'Filtr: "$1", sòrt: "$2", rason: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID ëd la wiki',
	'phalanx-stats-table-wiki-name' => 'Nòm ëd la Wiki',
	'phalanx-stats-table-wiki-url' => 'Anliura dla wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Ùltima modìfica',
	'phalanx-email-filter-hidden' => "Filtr ëd pòsta eletrònica stërmà. A l'ha nen ël përmess ëd vëdde ël test.",
	'action-phalanx' => 'dovré ël Mecanism Antegrà ëd Difèisa da la rumenta',
	'right-phalanx' => 'A peul gestì ij blocagi globaj e filtr ëd rumenta',
	'right-phalanxexempt' => 'Esentà da le régole Phalanx',
	'right-phalanxemailblock' => 'Chiel a peul archivié, vëdde e gestì ij blocagi basà an sij mëssagi ëd pòsta eletrònica',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'phalanx-type-content' => 'د مخ منځپانګه',
	'phalanx-type-summary' => 'د مخ لنډيز',
	'phalanx-type-title' => 'مخ سرليک',
	'phalanx-type-user' => 'کارن',
	'phalanx-type-user-email' => 'برېښليک',
	'phalanx-type-answers-question-title' => 'د پوښتنې سرليک',
	'phalanx-label-filter' => 'چاڼگر:',
	'phalanx-label-reason' => 'سبب:',
	'phalanx-label-type' => 'ډول:',
	'phalanx-label-lang' => 'ژبه:',
	'phalanx-test-submit' => 'آزمېښت',
	'phalanx-test-results-legend' => 'آزمېښت پايلې',
	'phalanx-stats-table-user' => 'ورګډونکی',
	'phalanx-stats-table-type' => 'ډول',
	'phalanx-stats-table-create' => 'جوړ شو',
	'phalanx-stats-table-expire' => 'پای نېټه',
	'phalanx-stats-table-exact' => 'کټ مټ',
	'phalanx-stats-table-language' => 'ژبه',
	'phalanx-stats-table-text' => 'متن',
	'phalanx-stats-table-reason' => 'سبب',
	'phalanx-stats-table-wiki-id' => 'ويکي پېژند',
	'phalanx-stats-table-wiki-name' => 'ويکي نوم',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 * @author SandroHc
 */
$messages['pt'] = array(
	'phalanx-desc' => 'Phalanx é um Mecanismo Integrado Anti-Spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mecanismo Integrado Anti-Spam',
	'phalanx-type-content' => 'conteúdo da página',
	'phalanx-type-summary' => 'resumo da página',
	'phalanx-type-title' => 'título da página',
	'phalanx-type-user' => 'utilizador',
	'phalanx-type-answers-question-title' => 'título da pergunta',
	'phalanx-type-answers-recent-questions' => 'perguntas recentes',
	'phalanx-type-wiki-creation' => 'criação de wikis',
	'phalanx-add-block' => 'Aplicar bloqueio',
	'phalanx-edit-block' => 'Gravar bloqueio',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Expiração:',
	'phalanx-label-type' => 'Tipo:',
	'phalanx-label-lang' => 'Língua:',
	'phalanx-view-type' => 'Tipo de bloqueio...',
	'phalanx-view-blocker' => 'Pesquisar o texto de filtro:',
	'phalanx-view-blocks' => 'Filtros de pesquisa',
	'phalanx-view-id' => 'Obter filtro por ID:',
	'phalanx-view-id-submit' => 'Obter filtro',
	'phalanx-format-text' => 'texto simples',
	'phalanx-format-regex' => 'expressão regular',
	'phalanx-format-case' => 'distinguir maiúsculas de minúsculas',
	'phalanx-format-exact' => 'exacto',
	'phalanx-tab-main' => 'Gerir Filtros',
	'phalanx-tab-secondary' => 'Testar Filtros',
	'phalanx-block-success' => 'O bloqueio foi adicionado',
	'phalanx-block-failure' => 'Ocorreu um erro durante a adição do bloqueio',
	'phalanx-modify-success' => 'O bloqueio foi modificado',
	'phalanx-modify-failure' => 'Ocorreu um erro durante a modificação do bloqueio',
	'phalanx-modify-warning' => 'Está a editar o bloqueio com o ID Nº $1.
Clicar "{{int:phalanx-add-block}}" grava as suas alterações!',
	'phalanx-test-description' => 'Texto fornecido pelo teste contra bloqueios atuais.',
	'phalanx-test-submit' => 'Testar',
	'phalanx-test-results-legend' => 'Resultados do teste',
	'phalanx-display-row-blocks' => 'bloqueios: $1',
	'phalanx-display-row-created' => "criado por '''$1''' em $2",
	'phalanx-link-unblock' => 'desbloquear',
	'phalanx-link-modify' => 'modificar',
	'phalanx-link-stats' => 'estatísticas',
	'phalanx-reset-form' => 'Reiniciar o formulário',
	'phalanx-legend-input' => 'Criar ou modificar filtro',
	'phalanx-legend-listing' => 'Filtros que estão a ser aplicados',
	'phalanx-unblock-message' => 'O bloqueio com o ID Nº $1 foi removido',
	'phalanx-help-type-content' => 'Este filtro impede a gravação de uma edição, se o conteúdo corresponder a qualquer uma das frases na lista negra.',
	'phalanx-help-type-summary' => 'Este filtro impede a gravação de uma edição, se o resumo corresponder a alguma das frases na lista negra.',
	'phalanx-help-type-title' => 'Este filtro impede a criação de uma página, se o título corresponder a alguma das frases na lista negra,

Não impede a edição de uma página que já exista.',
	'phalanx-help-type-user' => 'Este filtro bloqueia um utilizador (exactamente como um bloqueio local no MediaWiki), se o nome ou o endereço IP do utilizador corresponder a um dos nomes ou endereços IP da lista negra.',
	'phalanx-help-type-wiki-creation' => 'Este filtro impede a criação de uma wiki, se o nome ou a URL da wiki corresponderem a qualquer frase da lista negra.',
	'phalanx-help-type-answers-question-title' => 'Este filtro impede a criação de uma (página de) pergunta, se o título da página corresponder a qualquer uma das frases da lista negra.

Nota: só funciona nas wikis de Perguntas e Respostas.',
	'phalanx-help-type-answers-recent-questions' => 'Este filtro impede a apresentação de (páginas de) perguntas numa série de dispositivos de saída (widgets, listas, listagens geradas com base em tags).
Não impede a criação dessas páginas.

Nota: só funciona nas wikis de Perguntas e Respostas.',
	'phalanx-user-block-reason-ip' => 'O seu endereço IP está impedido de editar as wikis da Wikia, devido a atividades de vandalismo ou perturbação originadas por si ou por outra pessoa que partilha o seu endereço IP atual.
Se acredita que este bloqueio foi feito em erro [[Special:Contact|contate a Wikia]], por favor.',
	'phalanx-user-block-reason-exact' => 'Este utilizador ou endereço IP está impedido de editar as wikis da Wikia, devido a atividades de vandalismo ou outras formas de perturbação.
Se acredita que este bloqueio foi feito em erro [[Special:Contact|contate a Wikia]], por favor.',
	'phalanx-user-block-reason-similar' => 'Este nome de utilizador está impedido de editar as wikis da Wikia, devido a atividades de vandalismo ou outras formas de perturbação exercidas por outro utilizador com um nome semelhante.
[[Special:Contact|Contate a Wikia]] acerca deste problema, por favor.',
	'phalanx-user-block-new-account' => 'O nome de utilizador não está disponível para registo. Escolha outro, por favor.',
	'phalanx-user-block-withreason-ip' => 'Este endereço IP está impedido de editar as wikis da Wikia, devido a atividades de vandalismo ou outra forma de perturbação conduzidas por si ou por outra pessoa que partilha o seu endereço IP atual.
Se acredita que este bloqueio foi feito em erro, [[Special:Contact|contate a Wikia]], por favor.<br />O autor do bloqueio apresentou também este motivo adicional: $1.',
	'phalanx-user-block-withreason-exact' => 'Este nome de utilizador ou endereço IP estão impedidos de editar as wikis da Wikia, devido a atividades de vandalismo ou outra forma de perturbação.
Se acredita que este bloqueio foi feito em erro [[Special:Contact|contate a Wikia]], por favor.<br />O autor do bloqueio apresentou também este motivo adicional: $1.',
	'phalanx-user-block-withreason-similar' => 'Este nome de utilizador está impedido de editar as wikis da Wikia, devido a atividades de vandalismo ou outras formas de perturbação exercidas por outro utilizador com um nome semelhante.
[[Special:Contact|Contate a Wikia]] acerca deste problema, por favor.<br />O autor do bloqueio apresentou também este motivo adicional: $1.',
	'phalanx-title-move-summary' => 'O motivo que introduziu continha uma frase bloqueada.',
	'phalanx-content-spam-summary' => 'O texto foi encontrado no resumo da página.',
	'phalanx-stats-title' => 'Estatísticas do Phalanx',
	'phalanx-stats-block-notfound' => 'ID do bloqueio não foi encontrado',
	'phalanx-stats-table-id' => 'ID do Bloqueio',
	'phalanx-stats-table-user' => 'Adicionado por',
	'phalanx-stats-table-type' => 'Tipo',
	'phalanx-stats-table-create' => 'Criação',
	'phalanx-stats-table-expire' => 'Expira',
	'phalanx-stats-table-exact' => 'Exacto',
	'phalanx-stats-table-regex' => 'Expressão regular',
	'phalanx-stats-table-case' => 'Caso',
	'phalanx-stats-table-language' => 'Língua',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
	'phalanx-stats-row' => "a $4,o filtro do tipo '''$1''' bloqueou '''$2''' em $3",
	'phalanx-stats-row-per-wiki' => "o utilizador '''$2''' foi bloqueado a '''$4''' pelo filtro com ID '''$3''' ($5) (tipo: '''$1''')",
	'phalanx-rule-log-name' => 'Registo de regras do Phalanx',
	'phalanx-rule-log-header' => 'Este é um registo das alterações às regras do Phalanx.',
	'phalanx-rule-log-add' => 'Regra do Phalanx adicionada: $1',
	'phalanx-rule-log-edit' => 'Regra do Phalanx editada: $1',
	'phalanx-rule-log-delete' => 'Regra do Phalanx eliminada: $1',
	'phalanx-rule-log-details' => 'Filtro: "$1", tipo: "$2", motivo: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID da Wiki',
	'phalanx-stats-table-wiki-name' => 'Nome da Wiki',
	'phalanx-stats-table-wiki-url' => 'URL da Wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Última edição',
	'right-phalanx' => 'Pode gerir bloqueios globais e filtros de spam',
	'right-phalanxexempt' => 'Isento da regras do Phalanx',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Luckas
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'phalanx' => 'Phalanx',
	'phalanx-type-content' => 'conteúdo da página',
	'phalanx-type-summary' => 'resumo da página',
	'phalanx-type-title' => 'título da página',
	'phalanx-type-user' => 'usuário',
	'phalanx-type-answers-question-title' => 'título da pergunta',
	'phalanx-type-answers-recent-questions' => 'perguntas recentes',
	'phalanx-add-block' => 'Aplicar bloqueio',
	'phalanx-edit-block' => 'Salvar bloqueio',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Expiração:',
	'phalanx-label-type' => 'Tipo:',
	'phalanx-label-lang' => 'Língua:',
	'phalanx-view-type' => 'Tipo de bloqueio...',
	'phalanx-view-blocks' => 'Pesquisar filtros',
	'phalanx-view-id' => 'Obter filtro por ID:',
	'phalanx-view-id-submit' => 'Obter filtro',
	'phalanx-format-text' => 'texto simples',
	'phalanx-format-regex' => 'expressão regular',
	'phalanx-format-case' => 'distinguir maiúsculas de minúsculas',
	'phalanx-format-exact' => 'exato',
	'phalanx-tab-secondary' => 'Testar filtros',
	'phalanx-test-submit' => 'Testar',
	'phalanx-test-results-legend' => 'Resultados do teste',
	'phalanx-display-row-blocks' => 'bloqueios: $1',
	'phalanx-display-row-created' => "criado por '''$1''' em $2",
	'phalanx-link-unblock' => 'desbloquear',
	'phalanx-link-modify' => 'modificar',
	'phalanx-link-stats' => 'estatísticas',
	'phalanx-reset-form' => 'Reiniciar o formulário',
	'phalanx-legend-input' => 'Criar ou modificar filtro',
	'phalanx-stats-table-user' => 'Adicionado por',
	'phalanx-stats-table-type' => 'Tipo',
	'phalanx-stats-table-create' => 'Criado',
	'phalanx-stats-table-expire' => 'Expira',
	'phalanx-stats-table-exact' => 'Exato',
	'phalanx-stats-table-regex' => 'Expressão regular',
	'phalanx-stats-table-case' => 'Caso',
	'phalanx-stats-table-language' => 'Língua',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'phalanx' => 'Falange',
	'phalanx-title' => "Falange - Meccanisme de Difese Indegrate condre a 'u Spam",
	'phalanx-type-content' => "condenute d'a pàgene",
	'phalanx-type-summary' => "riepiloghe d'a pàgene",
	'phalanx-type-title' => "Titole d'a pàgene",
	'phalanx-type-user' => 'utende',
	'phalanx-type-user-email' => 'e-mail',
	'phalanx-type-answers-question-title' => "titole d'a domande",
	'phalanx-type-answers-recent-questions' => 'domande recende',
	'phalanx-type-wiki-creation' => "ccrejazione d'a uicchi",
	'phalanx-add-block' => "Appliche 'u blocche",
	'phalanx-edit-block' => "Reggìstre 'u blocche",
	'phalanx-label-filter' => 'Filtre:',
	'phalanx-label-reason' => 'Mutive:',
	'phalanx-label-expiry' => 'Scadenze:',
	'phalanx-label-type' => 'Tipe:',
	'phalanx-label-lang' => 'Lènghe:',
	'phalanx-view-type' => 'Tipe de blocche...',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-exact' => 'satte satte',
	'phalanx-tab-main' => 'Gestisce le filtre',
	'phalanx-tab-secondary' => 'Filtre de test',
	'phalanx-block-success' => "'U blocche ha state aggiunde",
	'phalanx-modify-success' => "'U blocche ha state cangiate",
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => "Resultate d'u test",
	'phalanx-display-row-blocks' => 'blocche: $1',
	'phalanx-display-row-created' => "ccrejate da '''$1''' 'u $2",
	'phalanx-link-unblock' => 'sblocche',
	'phalanx-link-modify' => 'cange',
	'phalanx-link-stats' => 'statisteche',
	'phalanx-stats-title' => "Statisteche d'a Falange",
	'phalanx-stats-block-notfound' => "ID d'u blocche none acchiate",
	'phalanx-stats-table-id' => "ID d'u blocche",
	'phalanx-stats-table-user' => 'Aggiunde da',
	'phalanx-stats-table-type' => 'Tipe',
	'phalanx-stats-table-create' => 'Ccrejate',
	'phalanx-stats-table-expire' => 'Scade',
	'phalanx-stats-table-exact' => 'Satte satte',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Case',
	'phalanx-stats-table-language' => 'Lènghe',
	'phalanx-stats-table-text' => 'Teste',
	'phalanx-stats-table-reason' => 'Mutive',
);

/** Russian (русский)
 * @author Byulent
 * @author DCamer
 * @author Engineering
 * @author Kuzura
 * @author Lvova
 */
$messages['ru'] = array(
	'phalanx-desc' => 'Phalanx - комплексный механизм обнаружения спама',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - комплексный механизм обнаружения спама',
	'phalanx-type-content' => 'содержание страницы',
	'phalanx-type-summary' => 'страница резюме',
	'phalanx-type-title' => 'название страницы',
	'phalanx-type-user' => 'пользователь',
	'phalanx-type-user-email' => 'email',
	'phalanx-type-answers-question-title' => 'заголовок вопроса',
	'phalanx-type-answers-recent-questions' => 'свежие вопросы',
	'phalanx-type-wiki-creation' => 'создание вики',
	'phalanx-add-block' => 'Применить блок',
	'phalanx-edit-block' => 'Сохранить блок',
	'phalanx-label-filter' => 'Фильтр:',
	'phalanx-label-reason' => 'Причина:',
	'phalanx-label-expiry' => 'Срок действия:',
	'phalanx-label-type' => 'Тип:',
	'phalanx-label-lang' => 'Язык:',
	'phalanx-view-type' => 'Тип блокировки...',
	'phalanx-view-blocker' => 'Поиск по фильтру для текста:',
	'phalanx-view-blocks' => 'Поисковые фильтры',
	'phalanx-view-id' => 'Использовать фильтр по ID:',
	'phalanx-view-id-submit' => 'Получить фильтр',
	'phalanx-format-text' => 'обычный текст',
	'phalanx-format-regex' => 'регулярно',
	'phalanx-format-case' => 'с учётом регистра',
	'phalanx-format-exact' => 'строго',
	'phalanx-tab-main' => 'Управление фильтрами',
	'phalanx-tab-secondary' => 'Проверить фильтры',
	'phalanx-block-success' => 'Блокирование было осуществлено успешно',
	'phalanx-block-failure' => 'Произошла ошибка при блокировании',
	'phalanx-modify-success' => 'Блокирование было успешно изменено',
	'phalanx-modify-failure' => 'Произошла ошибка при изменении блока',
	'phalanx-modify-warning' => 'Вы изменили ID блока #$1.
Нажмите "{{int:phalanx-edit-block}}", чтобы сохранить изменения!',
	'phalanx-test-description' => 'Тест представил текст о текущих блоках.',
	'phalanx-test-submit' => 'Тест',
	'phalanx-test-results-legend' => 'Результаты теста',
	'phalanx-display-row-blocks' => 'блоки: $1',
	'phalanx-display-row-created' => "создал '''$1''' на $2",
	'phalanx-link-unblock' => 'разблокировать',
	'phalanx-link-modify' => 'изменить',
	'phalanx-link-stats' => 'Статистика',
	'phalanx-reset-form' => 'Сбросить форму',
	'phalanx-legend-input' => 'Создать или изменить фильтр',
	'phalanx-legend-listing' => 'Текущие применённые фильтры',
	'phalanx-unblock-message' => 'Блок ID # $1  был успешно удален',
	'phalanx-help-type-content' => 'Если содержание соответствует любому слову из черного списка фраз, то фильтр запрещает сохранение после редактирования.',
	'phalanx-help-type-summary' => 'Если описание правок соответствует любому слову из черного списка фраз, то фильтр запрещает сохранение после редактирования.',
	'phalanx-help-type-title' => 'Этот фильтр предотвращает создание страницы, если её название соответствует любому слову из чёрного списка.

Это не мешает редактированию страницы.',
	'phalanx-help-type-user' => 'Этот фильтр блокирует участника (также, как блокирование на самой вики), если его имя или IP-адрес соответствует имени или IP-адресу из чёрного списка.',
	'phalanx-help-type-wiki-creation' => 'Если название или URL-адрес вики соответствует тому, что находится в чёрном списке, то этот фильтр запрещает создание такой вики.',
	'phalanx-help-type-answers-question-title' => 'Этот фильтр блокирует создание вопроса (страницы), если его название соответствует слову из чёрного списка фильтра.

Примечание: работает только на Вики-ответов.',
	'phalanx-help-type-answers-recent-questions' => 'Этот фильтр предотвращает отображение вопросов (страниц) на экране в ряде случаев (виджеты, списки, генерируемые тегами списки).
Это не мешает созданию данных страниц.

Примечание: работает только на Вики-ответах.',
	'phalanx-help-type-user-email' => 'Этот фильтр предотвращает создание учетной записи, с использованием заблокированного электронного адреса.',
	'phalanx-user-block-reason-ip' => 'Участник с данным IP-адресом не может редактировать на всей Викия из-за вандализма или других нарушений, которые совершил он или некто с таким же IP-адресом.
Если Вы считаете, что произошла ошибка, то, пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Викия]].',
	'phalanx-user-block-reason-exact' => 'Этот участник или участник с данным IP-адресом не может редактировать на всей Викия из-за вандализма или других нарушений.
Если Вы считаете, что произошла ошибка, пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Викия]].',
	'phalanx-user-block-reason-similar' => 'Участнику с данным именем участника запрещено редактировать на всей Викия из-за вандализма или других нарушений.
Пожалуйста,  [[Special:Contact|свяжитесь с сотрудниками Викия]], чтобы узнать больше об этом.',
	'phalanx-user-block-new-account' => 'Это имя пользователя не доступно для регистрации. Пожалуйста, выберите другое.',
	'phalanx-user-block-withreason-ip' => 'Участник с данным IP-адресом не может редактировать на всей Викия из-за вандализма или других нарушений, которые совершил он или некто с таким же IP-адресом.
Если Вы считаете, что произошла ошибка,  пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Викия]].<br />Тот, кто вас заблокировал, оставил следующее пояснение: $1.',
	'phalanx-user-block-withreason-exact' => 'Этот участник или участник с данным IP-адресом не может редактировать на всей Викия из-за вандализма или других нарушений.
Если Вы считаете, что произошла ошибка, пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Викия]].<br />Тот, кто заблокировал Вас, оставил следующее посянение: $1.',
	'phalanx-user-block-withreason-similar' => 'Участнику с данным именем участника запрещено редактировать на всей Викия из-за вандализма или других нарушений.
Пожалуйста,  [[Special:Contact|свяжитесь с сотрудниками Викия]], чтобы узнать больше об этом.<br />Тот, кто заблокировал Вас, оставил следующее пояснение: $1',
	'phalanx-title-move-summary' => 'Причина, по которой вы добавляете эту фразу для блокировки.',
	'phalanx-content-spam-summary' => 'Текст, найденный в описании изменений.',
	'phalanx-stats-title' => 'Статистика Phalanx',
	'phalanx-stats-block-notfound' => 'ID блока не найдено',
	'phalanx-stats-table-id' => 'ID блока',
	'phalanx-stats-table-user' => 'Добавить',
	'phalanx-stats-table-type' => 'Тип',
	'phalanx-stats-table-create' => 'Создать',
	'phalanx-stats-table-expire' => 'Истекает',
	'phalanx-stats-table-exact' => 'Строго',
	'phalanx-stats-table-regex' => 'Регулярно',
	'phalanx-stats-table-case' => 'В случае',
	'phalanx-stats-table-language' => 'Язык',
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-reason' => 'Причина',
	'phalanx-stats-row' => "в $4, тип фильтра '''$1''' заблокировал '''$2''' на $3",
	'phalanx-stats-row-per-wiki' => "участник '''$2''' был заблокирован на '''$4''' с ID фильтра '''$3''' ($5) (тип: '''$1''')",
	'phalanx-rule-log-name' => 'журнал правил Phalanx',
	'phalanx-rule-log-header' => 'Это журнал изменений правил phalanx.',
	'phalanx-email-rule-log-name' => 'Журнал правил Phalanx для e-mail',
	'phalanx-email-rule-log-header' => 'Это журнал изменений правил Phalanx для e-mail.',
	'phalanx-rule-log-add' => 'Правило Phalanx добавлено: $1',
	'phalanx-rule-log-edit' => 'Правило Phalanx отредактировано: $1',
	'phalanx-rule-log-delete' => 'Правило Phalanx удалено: $1',
	'phalanx-rule-log-details' => 'Фильтр: "$1", тип: "$2", причина: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID вики',
	'phalanx-stats-table-wiki-name' => 'Имя вики',
	'phalanx-stats-table-wiki-url' => 'URL-адрес вики',
	'phalanx-stats-table-wiki-last-edited' => 'Последняя правка',
	'phalanx-email-filter-hidden' => 'Фильтр для e-mail скрыт. У вас нет разрешения на просмотр текста.',
	'action-phalanx' => 'использовать интегрированный механизм защиты от спама',
	'right-phalanx' => 'Можно управлять глобальными блоками и спам-фильтрами',
	'right-phalanxexempt' => 'Освобождено от правил Phalanx',
	'right-phalanxemailblock' => 'Можно обратиться, просмотреть и управлять e-mail на основе блоков',
);

/** ꢱꣃꢬꢵꢯ꣄ꢡ꣄ꢬꢵ (ꢱꣃꢬꢵꢯ꣄ꢡ꣄ꢬꢵ)
 * @author MooRePrabu
 */
$messages['saz'] = array(
	'phalanx-type-user' => 'ꢮꢮ꣄ꢬꢸꢥꢵꢬ꣄',
	'phalanx-label-filter' => 'ꢏꢜ꣄ꢗꢶ',
	'phalanx-stats-table-language' => 'ꢩꢵꢰꣁ',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'phalanx-type-content' => 'садржај странице',
	'phalanx-type-summary' => 'опис странице',
	'phalanx-type-title' => 'наслов странице',
	'phalanx-type-user' => 'корисник',
	'phalanx-type-answers-recent-questions' => 'скорашња питања',
	'phalanx-add-block' => 'Примени забрану',
	'phalanx-edit-block' => 'Сачувај забрану',
	'phalanx-label-filter' => 'Филтер:',
	'phalanx-label-expiry' => 'Истек:',
	'phalanx-label-type' => 'Врста:',
	'phalanx-label-lang' => 'Језик:',
	'phalanx-view-type' => 'Врста забране...',
	'phalanx-view-blocks' => 'Претражи филтере',
	'phalanx-format-text' => 'чист текст',
	'phalanx-link-modify' => 'измени',
	'phalanx-stats-table-user' => 'Додао:',
	'phalanx-stats-table-type' => 'Врста',
	'phalanx-stats-table-language' => 'Језик',
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-reason' => 'Разлог',
);

/** Swedish (svenska)
 * @author VickyC
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'phalanx-desc' => 'Phalanx är en integrerad försvarsmekanism mot spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrerad försvarsmekanism mot spam',
	'phalanx-type-content' => 'sidinnehåll',
	'phalanx-type-summary' => 'sidsammanfattning',
	'phalanx-type-title' => 'sidtitel',
	'phalanx-type-user' => 'användare',
	'phalanx-type-user-email' => 'e-post',
	'phalanx-type-answers-question-title' => 'frågetitel',
	'phalanx-type-answers-recent-questions' => 'senaste frågorna',
	'phalanx-type-wiki-creation' => 'wiki-skapande',
	'phalanx-add-block' => 'Verkställ blockering',
	'phalanx-edit-block' => 'Spara blockering',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Orsak:',
	'phalanx-label-expiry' => 'Varaktighet:',
	'phalanx-label-type' => 'Typ:',
	'phalanx-label-lang' => 'Språk:',
	'phalanx-view-type' => 'Typ av blockering...',
	'phalanx-view-blocker' => 'Sök med textfilter:',
	'phalanx-view-blocks' => 'Sökfilter',
	'phalanx-view-id' => 'Få filter efter ID:',
	'phalanx-view-id-submit' => 'Hämta filter',
	'phalanx-format-text' => 'oformaterad text',
	'phalanx-format-regex' => 'reguljärt uttryck',
	'phalanx-format-case' => 'skiftlägeskänslig',
	'phalanx-format-exact' => 'exakt',
	'phalanx-tab-main' => 'Hantera filter',
	'phalanx-tab-secondary' => 'Testa filter',
	'phalanx-block-success' => 'Blockeringen lades till',
	'phalanx-block-failure' => 'Det uppstod ett fel när blockeringen skulle läggas till',
	'phalanx-modify-success' => 'Blockeringen ändrades',
	'phalanx-modify-failure' => 'Det uppstod ett fel när blockeringen skulle ändras',
	'phalanx-modify-warning' => 'Du redigerar blockerings-ID #$1.
Klicka på "{{int:phalanx-edit-block}}" för att spara dina ändringar!',
	'phalanx-test-description' => 'Testet gav text mot aktuella blockeringar.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Testresultat',
	'phalanx-display-row-blocks' => 'blockeringar: $1',
	'phalanx-display-row-created' => "skapades av '''$1''' den $2",
	'phalanx-link-unblock' => 'avblockera',
	'phalanx-link-modify' => 'ändra',
	'phalanx-link-stats' => 'statistik',
	'phalanx-reset-form' => 'Återställ formulär',
	'phalanx-legend-input' => 'Skapa eller ändra filter',
	'phalanx-legend-listing' => 'För närvarande tillämpade filter',
	'phalanx-unblock-message' => 'Block-ID #$1 har tagits bort',
	'phalanx-help-type-content' => 'Detta filter förhindrar en wiki från att skapas om dess namn matchar någon svartlistad fras.',
	'phalanx-help-type-summary' => 'Detta filter förhindrar en redigering från att sparas om sammanfattningen matchar någon svartlistad fras.',
	'phalanx-help-type-title' => 'Detta filter förhindrar en sida från att skapas, om dess titel matchar någon av de svartlistade fraserna.

Filtret förhindrar inte möjligheten att redigera en tidigare skapad sida.',
	'phalanx-help-type-user' => 'Detta filter blockerar en användare (precis samma som en lokal MediaWiki-blockering) om namnet eller IP-adressen matchar en av de svartlistade namnen eller IP-adresserna.',
	'phalanx-help-type-wiki-creation' => 'Detta filter förhindrar en wiki från att skapas om dess namn eller URL-adress matchar någon svartlistad fras.',
	'phalanx-help-type-answers-question-title' => 'Detta filter förhindrar att en fråga (sida) skapas, om dess titel matchar någon av de svartlistade fraserna.
Anmärkning: fungerar endast på Svar-typ wikier.',
	'phalanx-help-type-answers-recent-questions' => 'Detta filter förhindrar att frågor (sidor) visas i ett antal listor (widgets, listor, tag-baserade listor).
Filtret förhindrar inte att dessa sidor skapas.

Anmärkning: fungerar endast på Svar-typ wikier.',
	'phalanx-help-type-user-email' => 'Detta filter förhindrar att konton skapas med en blockerad e-postadress.',
	'phalanx-user-block-reason-ip' => 'Denna IP-adress förhindras från att redigera på hela Wikia-nätverket på grund av vandalisering eller andra störningar av dig eller någon annan som delar din IP-adress.
Om du tror att detta är ett fel, var god [[Special:Contact|kontakta Wikia]].',
	'phalanx-user-block-reason-exact' => 'Detta användarnamn eller IP-adress förhindras från att redigera på hela Wikia-nätverket på grund av vandalisering eller någon annan störning.
Om du tror att detta är ett fel, var god [[Special:Contact|kontakta Wikia]].',
	'phalanx-user-block-reason-similar' => 'Detta användarnamn förhindras från att redigera på hela Wikia-nätverket på grund av vandalisering eller andra störningar av en användare med ett liknande namn.
Vänligen [[Special:Contact|kontakta Wikia]] om problemet.',
	'phalanx-user-block-new-account' => 'Användarnamnet är inte tillgängligt för registrering. Välj ett annat.',
	'phalanx-user-block-withreason-ip' => 'Denna IP-adress förhindras från att redigera på hela Wikia-nätverket på grund av vandalisering eller andra störningar av dig eller någon annan som delar din IP-adress.
Om du tror att detta är ett fel, var god [[Special:Contact|kontakta Wikia]].<br />Blockeringen gav också denna tilläggande anledning: $1.',
	'phalanx-user-block-withreason-exact' => 'Detta användarnamn eller IP-adress förhindras från att redigera på hela Wikia-nätverket på grund av vandalisering eller någon annan störning.
Om du tror att detta är ett fel, var god [[Special:Contact|kontakta Wikia]].<br />Blockeringen gav också denna tilläggande anledning: $1.',
	'phalanx-user-block-withreason-similar' => 'Detta användarnamn förhindras från att redigera på hela Wikia-nätverket på grund av vandalisering eller andra störningar av en användare med ett liknande namn.
Var god [[Special:Contact|kontakta Wikia]] om problemet.<br />Blockeringen gav också denna tilläggande anledning: $1.',
	'phalanx-title-move-summary' => 'Anledningen du skrev in innehöll en blockerad fras.',
	'phalanx-content-spam-summary' => 'Texten hittades i sidans sammanfattning.',
	'phalanx-stats-title' => 'Phalanx-statistik',
	'phalanx-stats-block-notfound' => 'blockerings-ID hittades inte',
	'phalanx-stats-table-id' => 'Blockerings-ID',
	'phalanx-stats-table-user' => 'Lades till av',
	'phalanx-stats-table-type' => 'Typ',
	'phalanx-stats-table-create' => 'Skapades',
	'phalanx-stats-table-expire' => 'Upphör',
	'phalanx-stats-table-exact' => 'Exakt',
	'phalanx-stats-table-regex' => 'Reguljärt uttryck',
	'phalanx-stats-table-case' => 'Händelse',
	'phalanx-stats-table-language' => 'Språk',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Anledning',
	'phalanx-stats-row' => "på $4, filtertyp '''$1''' blockerade '''$2''' den $3",
	'phalanx-stats-row-per-wiki' => "användaren '''$2''' blockerades den '''$4''' av filter-ID '''$3''' ($5) (typ: '''$1''')",
	'phalanx-rule-log-name' => 'Logg över regler i Phalanx',
	'phalanx-rule-log-header' => 'Detta är en logg över ändringar i phalanxreglerna.',
	'phalanx-email-rule-log-name' => 'Logg över e-postregler i Phalanx',
	'phalanx-email-rule-log-header' => 'Detta är en logg över ändringar i Phalanxreglerna för typen e-post.',
	'phalanx-rule-log-add' => 'Phalanx-regel lades till: $1',
	'phalanx-rule-log-edit' => 'Phalanx-regel redigerades: $1',
	'phalanx-rule-log-delete' => 'Phalanx-regel raderades: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", typ: "$2", orsak: "$3"',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wiki-namn',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Senast redigerad',
	'phalanx-email-filter-hidden' => 'E-postfilter dolt. Du har inte behörighet att visa texten.',
	'action-phalanx' => 'använd den integrerade försvarsmekanismen mot spam',
	'right-phalanx' => 'Kan hantera globala blockeringar och spamfilter',
	'right-phalanxexempt' => 'Förutom Phalanx-regler',
	'right-phalanxemailblock' => 'Kan ordna, visa och hantera e-postbaserade blockeringar',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'phalanx-type-content' => 'పుట విషయం',
	'phalanx-type-summary' => 'పుట సారాంశం',
	'phalanx-type-title' => 'పుట శీర్షిక',
	'phalanx-type-user' => 'వాడుకరి',
	'phalanx-type-answers-recent-questions' => 'ఇటీవలి ప్రశ్నలు',
	'phalanx-label-reason' => 'కారణం:',
	'phalanx-label-type' => 'రకం:',
	'phalanx-label-lang' => 'భాష:',
	'phalanx-test-results-legend' => 'పరీక్షా ఫలితాలు',
	'phalanx-link-stats' => 'గణాంకాలు',
	'phalanx-stats-table-type' => 'రకం',
	'phalanx-stats-table-language' => 'భాష',
	'phalanx-stats-table-text' => 'పాఠ్యం',
	'phalanx-stats-table-reason' => 'కారణం',
	'phalanx-stats-table-wiki-name' => 'వికీ పేరు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'phalanx-desc' => 'Ang Phalanx ay isang Pinagsamang Mekanismo ng Pagtatanggol Laban sa Basurang Liham',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Pinagsamang Mekanismong Panlaban sa Basurang Liham',
	'phalanx-type-content' => 'nilalaman ng pahina',
	'phalanx-type-summary' => 'buod ng pahina',
	'phalanx-type-title' => 'pamagat ng pahina',
	'phalanx-type-user' => 'tagagamit',
	'phalanx-type-user-email' => 'e-liham',
	'phalanx-type-answers-question-title' => 'pamagat ng tanong',
	'phalanx-type-answers-recent-questions' => 'kamakailang mga tanong',
	'phalanx-type-wiki-creation' => 'paglikha ng wiki',
	'phalanx-add-block' => 'Ilapat ang harang',
	'phalanx-edit-block' => 'Sagipin ang pagharang',
	'phalanx-label-filter' => 'Pansala:',
	'phalanx-label-reason' => 'Dahilan:',
	'phalanx-label-expiry' => 'Katapusan:',
	'phalanx-label-type' => 'Uri:',
	'phalanx-label-lang' => 'Wika:',
	'phalanx-view-type' => 'Magmakinilya ng pagharang...',
	'phalanx-view-blocker' => 'Maghanap sa pamamagitan ng teksto ng pagsala:',
	'phalanx-view-blocks' => 'Maghanap sa mga pansala',
	'phalanx-view-id' => 'Kuhanin ang pansala ayon sa ID:',
	'phalanx-view-id-submit' => 'Kunin ang pansala',
	'phalanx-format-text' => 'payak na teksto',
	'phalanx-format-regex' => 'pangkaraniwang pagsasaad',
	'phalanx-format-case' => 'maselan ang pagmamakinilya',
	'phalanx-format-exact' => 'lapat na lapat',
	'phalanx-tab-main' => 'Pamahalaan ang mga Pansala',
	'phalanx-tab-secondary' => 'Subukan ang mga Pansala',
	'phalanx-block-success' => 'Matagumpay na naidagdag ang harang',
	'phalanx-block-failure' => 'May kamalian habang idinaragdag ang harang',
	'phalanx-modify-success' => 'Matagumpay na nabago ang harang',
	'phalanx-modify-failure' => 'May kamalian sa pagbago ng harang',
	'phalanx-modify-warning' => 'Binabago mo ang ID ng harang na #$1.
Makapagsasagip ng mga binago mo ang pagpindot sa "{{int:phalanx-add-block}}"',
	'phalanx-test-description' => 'Ang pagsubok ay nagbigay ng teksto laban sa pangkasalukuyang mga pagharang.',
	'phalanx-test-submit' => 'Pagsubok',
	'phalanx-test-results-legend' => 'Mga resulta ng pagsubok',
	'phalanx-display-row-blocks' => 'mga paghadlang: $1',
	'phalanx-display-row-created' => "nilikha ni '''$1''' noong $2",
	'phalanx-link-unblock' => 'huwag hadlangan',
	'phalanx-link-modify' => 'baguhin',
	'phalanx-link-stats' => 'estadistika',
	'phalanx-reset-form' => 'Itakda uli ang pormularyo',
	'phalanx-legend-input' => 'Likhain o baguhin ang pansala',
	'phalanx-legend-listing' => 'Pangkasalukuyang nakalapat na mga pansala',
	'phalanx-unblock-message' => 'Matagumpay na naalis ang harang na may ID na #$1',
	'phalanx-help-type-content' => 'Iniiwasan ng pansalang ito ang pagsagip ng isang pagbabago, kapag tumugma ang nilalaman ng anuman sa mga pariralang nasa talaan ng mga hinahadlangan.',
	'phalanx-help-type-summary' => 'Iniiwasan ng talaksang ito na masagip ang isang pagbabago, kapag ang ibinigay na buod ay tumugma sa anumang mga pariralang pinagbabawalan.',
	'phalanx-help-type-title' => 'Iniiwasan ng pansalang ito na malikha ang isang pahina, kapag tumugma ang pamagat nito sa anuman sa mga pariralang pinagbabawalan.

Hindi nito iniiwasan ang mabago ang isang dati nang umiiral na pahina.',
	'phalanx-help-type-user' => 'Ang pansalang ito ay hinahadlangan ang isang tagagamit (katulad na katulad ng isang katutubong paghahadlang ng MediaWiki), kapag tumugma ang pangalan o tirahang IP sa isa sa ipinagbabawal na mga pangalan o tirahang IP.',
	'phalanx-help-type-wiki-creation' => 'Iniiwasan ng pansalang ito na malikha ang isang wiki, kapag tumugma ang pangalan o URL nito sa anumang pariralang ipinagbabawal.',
	'phalanx-help-type-answers-question-title' => 'Paunawa: gumagana lamang sa mga wiking may uri ng mga Sagot.',
	'phalanx-help-type-answers-recent-questions' => 'Paunawa: gumagana lamang sa mga uri ng wiking Sumasagot.',
	'phalanx-help-type-user-email' => 'Iniiwasan ng pansalang ito ang paglikha ng akawnt na ginagamit ang isang hinarang na tirahan ng e-liham.',
	'phalanx-user-block-reason-ip' => 'Pinipigilan ang tirahan ng IP na ito na makapamatnugot sa kahabaan ng buong lambat na panggawain ng Wikia dahil sa pambababoy o ibang panggugulo mo o ng isang taong kabahagi ng tirahan ng IP mo.
Kung naniniwala ka na isa itong pagkakamali, paki [[Special:Contact|makipag-ugnayan sa Wikia]].',
	'phalanx-user-block-reason-exact' => 'Pinipigilan ang pangalan ng tagagamit o tirahang IP na ito na makapamatnugot sa kahabaan ng buong lambat na gawaan ng Wikia dahil sa pambababoy o ibang panggugulo.
Kung naniniwalang ka na isa itong pagkakamali, paki [[Special:Contact|makipag-ugnayan sa Wikia]].',
	'phalanx-user-block-reason-similar' => 'Pinipigilan ang pangalan ng tagagamit na ito na makapamatnugot sa kahabaan ng buong lambat na gawaan ng dahil sa pambababoy o ibang panggugulo ng isang tagagamit na may katulad na pangalan.
Paki [[Special:Contact|makipag-ugnayan sa Wikia]] tungkol sa suliranin.',
	'phalanx-user-block-new-account' => 'Hindi makuha ang pangalan ng tagagamit para sa pagrerehistro. Paki pumili ng naiibang isa.',
	'phalanx-user-block-withreason-ip' => 'Pinipigilan ang tirahan ng IP na ito na makapamatnugot sa kahabaan ng buong lambat na panggawain ng Wikia dahil sa pambababoy o ibang panggugulo mo o ng isang taong kabahagi ng tirahan ng IP mo.
Kung naniniwala ka na isa itong pagkakamali, paki [[Special:Contact|makipag-ugnayan sa Wikia]].<br /> Ang humarang ay nagbigay din ng ganitong karagdagang dahilan: $1.',
	'phalanx-user-block-withreason-exact' => 'Pinipigilan ang pangalan ng tagagamit o tirahan ng IP na ito na makapamatnugot sa kahabaan ng buong lambat na panggawain ng Wikia dahil sa pambababoy o ibang panggugulo.
Kung naniniwala ka na isa itong pagkakamali, paki [[Special:Contact|makipag-ugnayan sa Wikia]].<br />Ang humarang ay nagbigay din ng ganitong karagdagang dahilan: $1.',
	'phalanx-user-block-withreason-similar' => 'Pinipigilan ang pangalan ng tagagamit na ito na makapamatnugot sa kahabaan ng buong lambat na panggawain ng Wikia dahil sa pambababoy o ibang panggugulo ng  isang tagagamit na may katulad na pangalan.
Paki [[Special:Contact|makipag-ugnayan sa Wikia]] hinggil sa suliranin.<br />Ang humarang ay nagbigay din ng ganitong karagdagang dahilan: $1.',
	'phalanx-title-move-summary' => 'Ang ipinasok mong dahilan ay naglalaman ng isang hinaharangang parirala.',
	'phalanx-content-spam-summary' => 'Natagpuan ang teksto sa loob ng buod ng pahina.',
	'phalanx-stats-title' => 'Estadistika ng Phalanx',
	'phalanx-stats-block-notfound' => 'hindi natagpuan ang ID ng pagharang',
	'phalanx-stats-table-id' => 'ID ng Harang',
	'phalanx-stats-table-user' => 'Idinagdag ni',
	'phalanx-stats-table-type' => 'Uri',
	'phalanx-stats-table-create' => 'Nalikha na',
	'phalanx-stats-table-expire' => 'Magtatapos sa',
	'phalanx-stats-table-exact' => 'Lapat na lapat',
	'phalanx-stats-table-regex' => 'Pangkaraniwang pagsasaad',
	'phalanx-stats-table-case' => 'Sukat ng titik',
	'phalanx-stats-table-language' => 'Wika',
	'phalanx-stats-table-text' => 'Teksto',
	'phalanx-stats-table-reason' => 'Dahilan',
	'phalanx-stats-row' => "sa ganap na $4, uri ng pansalang '''$1''' hinadlangan ang '''$2''' noong $3",
	'phalanx-stats-row-per-wiki' => "ang tagagmit na si '''$2''' ay hinarang noong '''$4''' sa pamamagitan ng ID ng pansala na '''$3''' ($5) (uri: '''$1''')",
	'phalanx-rule-log-name' => 'Talaan ng tuntunin ng Phalanx',
	'phalanx-rule-log-header' => 'Isa itong talaan ng mga pagbabago sa mga patakaran ng Phalanx.',
	'phalanx-email-rule-log-name' => 'talaan ng mga patakaran ng e-liham ng Phalanx',
	'phalanx-email-rule-log-header' => 'Isa itong talaan ng mga pagbabago sa mga patakaran ng Phalanx para sa uri ng e-liham.',
	'phalanx-rule-log-add' => 'Idinagdag ang patakaran ng Phalanx: $1',
	'phalanx-rule-log-edit' => 'Binago ang patakaran ng Phalanx: $1',
	'phalanx-rule-log-delete' => 'Binura ang patakaran ng Phalanx: $1',
	'phalanx-rule-log-details' => 'Pansala: "$1", uri: "$2", dahilan: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID ng Wiki',
	'phalanx-stats-table-wiki-name' => 'Pangalan ng Wiki',
	'phalanx-stats-table-wiki-url' => 'URL ng Wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Huling binago',
	'phalanx-email-filter-hidden' => 'Nakakubli ang pansala ng e-liham. Wala kang pahintulot na makita ang teksto.',
	'action-phalanx' => 'gamitin ang Pinagsamang Mekanismong Panlaban sa Basurang Liham',
	'right-phalanx' => 'Makakapamahala ng pangglobong mga pagharang at mga pansala ng basura',
	'right-phalanxexempt' => 'Hindi kasali sa mga patakaran ng Phalanx',
	'right-phalanxemailblock' => 'Makapaghaharap, makatitingin at makakapamahala ng mga pagharang na nakabatay sa e-liham',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-wiki-name' => 'Wiki исеме',
);

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Steve.rusyn
 * @author SteveR
 * @author Ата
 * @author Тест
 */
$messages['uk'] = array(
	'phalanx-desc' => 'Phalanx — комплексний механізм захисту від спаму',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx — комплексний механізм захисту від спаму',
	'phalanx-type-content' => 'зміст сторінки',
	'phalanx-type-summary' => 'стислий опис сторінки',
	'phalanx-type-title' => 'Назва сторінки',
	'phalanx-type-user' => 'користувач',
	'phalanx-type-user-email' => 'електронна пошта',
	'phalanx-type-answers-question-title' => 'назва запитання',
	'phalanx-type-answers-recent-questions' => 'нові запитання',
	'phalanx-type-wiki-creation' => 'створення вікі',
	'phalanx-add-block' => 'Застосувати блок',
	'phalanx-edit-block' => 'Зберегти блок',
	'phalanx-label-filter' => 'Фільтр:',
	'phalanx-label-reason' => 'Причина:',
	'phalanx-label-expiry' => 'Термін дії:',
	'phalanx-label-type' => 'Тип:',
	'phalanx-label-lang' => 'Мова:',
	'phalanx-view-type' => 'Тип блоку...',
	'phalanx-view-blocker' => 'Шукати за фільтром для тексту:',
	'phalanx-view-blocks' => 'Пошукові фільтри',
	'phalanx-view-id' => 'Використовувати фільтр за ID:',
	'phalanx-view-id-submit' => 'Отримати фільтр',
	'phalanx-format-text' => 'Простий текст',
	'phalanx-format-regex' => 'регулярно',
	'phalanx-format-case' => 'з урахуванням регістру',
	'phalanx-format-exact' => 'точно',
	'phalanx-tab-main' => 'Фільтри',
	'phalanx-tab-secondary' => 'Випробувати фільтр',
	'phalanx-block-success' => 'Блок успішно додано',
	'phalanx-block-failure' => 'Помилка при додаванні блоку',
	'phalanx-modify-success' => 'Блок успішно змінено',
	'phalanx-modify-failure' => 'Помилка при зміні блоку',
	'phalanx-modify-warning' => 'Вb змінили ID блоку #$1.
Натисніть "{{int:phalanx-edit-block}}", щоб зберегти зміни!',
	'phalanx-test-description' => 'Тест надав текст про поточні блоки.',
	'phalanx-test-submit' => 'Тест',
	'phalanx-test-results-legend' => 'Результати тесту',
	'phalanx-display-row-blocks' => 'блоки: $1',
	'phalanx-display-row-created' => "створив '''$1''' на $2",
	'phalanx-link-unblock' => 'розблокувати',
	'phalanx-link-modify' => 'змінити',
	'phalanx-link-stats' => 'статистика',
	'phalanx-reset-form' => 'Скинути форму',
	'phalanx-legend-input' => 'Створити або змінити фільтр',
	'phalanx-legend-listing' => 'Поточні фільтри',
	'phalanx-unblock-message' => 'Блок ID # $1  успішно вилучено',
	'phalanx-help-type-content' => 'Якщо зміст відповідає будь-якому слову з чорного списку фраз, то фільтр забороняє збереження після редагування.',
	'phalanx-help-type-summary' => 'Фільтр не дає зберігати редагування, якщо подане резюме містить щось із чорного списку фраз.',
	'phalanx-help-type-title' => 'Цей фільтр запобігає створенню сторінки, якщо її назва відповідає будь-якому слову з чорного списку.

Це не заважає редагуванню сторінки.',
	'phalanx-help-type-user' => "Цей фільтр блокує учасника (також як блокування на самій вікі), коли його ім'я або IP-адреса відповідає імені або IP-адресі з чорного списку.",
	'phalanx-help-type-wiki-creation' => 'Якщо назва або URL-адреса вікі відповідає тому, що знаходиться в чорному списку, то цей фільтр забороняє створення такої вікі.',
	'phalanx-help-type-answers-question-title' => 'Цей фільтр блокує створення питання (сторінки), якщо його назва відповідає слову з чорного списку фільтра.

Примітка: працює тільки на вікі типу відповіді.',
	'phalanx-help-type-answers-recent-questions' => 'Цей фільтр запобігає відображенню питань (сторінок) на екрані в ряді випадків (віджети, списки, генеровані тегами списки).
Це не заважає створенню даних сторінок.

Примітка: працює тільки на вікі типу відповіді.',
	'phalanx-help-type-user-email' => 'Цей фільтр запобігає створення облікового запису з допомогою заблокованої адреси електронної пошти.',
	'phalanx-user-block-reason-ip' => "Учасник з даними IP-адресою не може редагувати на всій Вікія через вандалізм або інших порушень, які вчинив він чи хтось з таким же IP-адресою.
Якщо Ви вважаєте, що сталася помилка, то, будь ласка,[[Special:Contact|зв'яжіться із співробітниками Вікія]].",
	'phalanx-user-block-reason-exact' => "Цей учасник або учасник з даною IP-адресою не може редагувати на всій Вікія через вандалізм або інші порушення.
Якщо Ви вважаєте, що сталася помилка, то, будь ласка, [[Special:Contact|зв'яжіться із співробітниками Вікія]].",
	'phalanx-user-block-reason-similar' => "Учаснику з даним ім'ям користувача заборонено редагувати на всій Вікія через вандалізм або інші порушення.
Будь ласка,  [[Special:Contact| зв'яжіться із співробітниками Вікія]], щоб дізнатися більше про це.",
	'phalanx-user-block-new-account' => "Це ім'я користувача не доступно для реєстрації. Будь ласка, виберіть інше.",
	'phalanx-user-block-withreason-ip' => 'Користувач з цією IP-адресою не може редагувати на всій Вікіа через вандалізм або інші порушення, які вчинив він або хтось з тією ж IP-адресою.
Якщо Ви вважаєте, що сталася помилка, будь ласка,[[Special:Contact|зверніться до адміністраторів Вікіа]].<br />Блокувач так пояснив свій крок: $1.',
	'phalanx-user-block-withreason-exact' => "Користувач з цим ім'ям або IP-адресою не може редагувати на всій Вікіа через вандалізм або інші порушення, які вчинив він або хтось з тією ж IP-адресою.
Якщо Ви вважаєте, що сталася помилка, будь ласка,[[Special:Contact|зверніться до адміністраторів Вікіа]].<br />Блокувач так пояснив свій крок: $1.",
	'phalanx-user-block-withreason-similar' => "Користувач з цим ім'ям не може редагувати на всій Вікіа через вандалізм або інші порушення, які вчинив він або хтось з тією ж IP-адресою.
Якщо Ви вважаєте, що сталася помилка, будь ласка,[[Special:Contact|зверніться до адміністраторів Вікіа]].<br />Блокувач так пояснив свій крок: $1.",
	'phalanx-title-move-summary' => 'Причина, по якій ви додаєте цю фразу для блокування.',
	'phalanx-content-spam-summary' => 'Текст знайдено у резюме сторінки.',
	'phalanx-stats-title' => 'Статистика Phalanx',
	'phalanx-stats-block-notfound' => 'ID блоку не найдено',
	'phalanx-stats-table-id' => 'ID блоку',
	'phalanx-stats-table-user' => 'Додано',
	'phalanx-stats-table-type' => 'Тип',
	'phalanx-stats-table-create' => 'Створено',
	'phalanx-stats-table-expire' => 'Закінчується',
	'phalanx-stats-table-exact' => 'Точно',
	'phalanx-stats-table-regex' => 'регулярний вираз',
	'phalanx-stats-table-case' => 'У разі',
	'phalanx-stats-table-language' => 'Мова',
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-reason' => 'Причина',
	'phalanx-stats-row' => "в $4, тип фільтру '''$1''' заблоковано '''$2''' на $3",
	'phalanx-stats-row-per-wiki' => "користувач '''$2''' заблокований на '''$4''' з ID фільтром '''$3''' ($5) (тип: '''$1''')",
	'phalanx-rule-log-name' => 'журнал правил Phalanx',
	'phalanx-rule-log-header' => 'Це журнал змін правил phalanx.',
	'phalanx-email-rule-log-name' => 'Журнал правил Phalanx для ел.пошти',
	'phalanx-email-rule-log-header' => 'Це журнал змін правил Phalanx для ел.пошти.',
	'phalanx-rule-log-add' => 'Правило Phalanx додано: $1',
	'phalanx-rule-log-edit' => 'Правило Phalanx відредаговано: $1',
	'phalanx-rule-log-delete' => 'Правило Phalanx вилучено: $1',
	'phalanx-rule-log-details' => 'Фільтр: "$1", тип: "$2", причина: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID вікі',
	'phalanx-stats-table-wiki-name' => 'Назва вікі',
	'phalanx-stats-table-wiki-url' => 'URL-адреса вікі',
	'phalanx-stats-table-wiki-last-edited' => 'Останнє редагування',
	'phalanx-email-filter-hidden' => 'Фільтр пошти прихований. Ви не маєте дозвіл на перегляд тексту.',
	'action-phalanx' => 'використовувати комплексний механізм захисту від спаму',
	'right-phalanx' => 'Можна керувати блокуванням і спам-фільтрами',
	'right-phalanxexempt' => 'Звільнено від правил Phalanx',
	'right-phalanxemailblock' => 'Можна звернутися, переглянути і управляти ел.поштою на основі блоків',
);

/** Uzbek (oʻzbekcha)
 * @author Sociologist
 */
$messages['uz'] = array(
	'phalanx-label-lang' => 'Til:',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Hydra
 * @author Reasno
 * @author Xiaomingyan
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'phalanx-desc' => 'Phalanx是一个集成化的垃圾信息防御机制',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - 集成化垃圾信息防御机制',
	'phalanx-type-content' => '页面内容',
	'phalanx-type-summary' => '页面摘要',
	'phalanx-type-title' => '页面标题',
	'phalanx-type-user' => '用户',
	'phalanx-type-user-email' => '电子邮件',
	'phalanx-type-answers-question-title' => '问题标题',
	'phalanx-type-answers-recent-questions' => '最新问题',
	'phalanx-label-reason' => '原因：',
	'phalanx-label-expiry' => '截止日期：',
	'phalanx-label-type' => '类型：',
	'phalanx-label-lang' => '语言：',
	'phalanx-format-text' => '纯文本',
	'phalanx-stats-table-type' => '类型',
	'phalanx-stats-table-create' => '以创造',
	'phalanx-stats-table-expire' => '到期',
	'phalanx-stats-table-language' => '语言',
	'phalanx-stats-table-text' => '文字',
	'phalanx-stats-table-reason' => '原因',
	'phalanx-stats-table-wiki-id' => '维基 ID',
	'phalanx-stats-table-wiki-name' => '维基名字',
	'phalanx-stats-table-wiki-url' => '维基 URL',
);
