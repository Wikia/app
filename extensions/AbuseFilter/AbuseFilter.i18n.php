<?php
/**
 * Internationalisation file for extension AbuseFilter.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Andrew Garrett
 */
$messages['en'] = array(
	// Description message
	'abusefilter-desc' => 'Applies automatic heuristics to edits.',

	// Special pages
	'abusefilter' => 'Abuse filter configuration',
	'abuselog' => 'Abuse log',
	
	// Hooks
	'abusefilter-warning' => "<big>'''Warning'''</big>: This action has been automatically identified as harmful.
Unconstructive edits will be quickly reverted,
and egregious or repeated unconstructive editing will result in your account or computer being blocked.
If you believe this edit to be constructive, you may click Submit again to confirm it.
A brief description of the abuse rule which your action matched is: $1",
	'abusefilter-disallowed' => "This action has been automatically identified as harmful,
and therefore disallowed.
If you believe your edit was constructive, please contact an administrator, and inform them of what you were trying to do.
A brief description of the abuse rule which your action matched is: $1",
	'abusefilter-blocked-display' => "This action has been automatically identified as harmful,
and you have been prevented from executing it.
In addition, to protect {{SITENAME}}, your user account and all associated IP addresses have been blocked from editing.
If this has occurred in error, please contact an administrator.
A brief description of the abuse rule which your action matched is: $1",
	'abusefilter-degrouped' => "This action has been automatically identified as harmful.
Consequently, it has been disallowed, and, since your account is suspected of being compromised, all rights have been revoked.
If you believe this to have been in error, please contact a bureaucrat with an explanation of this action, and your rights may be restored.
A brief description of the abuse rule which your action matched is: $1",
	'abusefilter-autopromote-blocked' => "This action has been automatically identified as harmful, and it has been disallowed.
In addition, as a security measure, some privileges routinely granted to established accounts have been temporarily revoked from your account.
A brief description of the abuse rule which your action matched is: $1",

	'abusefilter-blocker' => 'Abuse filter',
	'abusefilter-blockreason' => 'Automatically blocked by abuse filter. Rule description: $1',
	'abusefilter-degroupreason' => 'Rights automatically stripped by abuse filter. Rule description: $1',
	
	'abusefilter-accountreserved' => 'This account name is reserved for use by the abuse filter.',
	
	// Permissions
	'right-abusefilter-modify' => 'Modify abuse filters',
	'right-abusefilter-view' => 'View abuse filters',
	'right-abusefilter-log' => 'View the abuse log',
	'right-abusefilter-log-detail' => 'View detailed abuse log entries',
	'right-abusefilter-private' => 'View private data in the abuse log',
	
	// Abuse Log
	'abusefilter-log' => 'Abuse filter log',
	'abusefilter-log-search' => 'Search the abuse log',
	'abusefilter-log-search-user' => 'User:',
	'abusefilter-log-search-filter' => 'Filter ID:',
	'abusefilter-log-search-title' => 'Title:',
	'abusefilter-log-search-submit' => 'Search',
	'abusefilter-log-entry' => '$1: $2 triggered an abuse filter, making a $3 on $4. Actions taken: $5; Filter description: $6',
	'abusefilter-log-detailedentry' => '$1: $2 triggered filter $3, making a $4 on $5. Actions taken: $6; Filter description: $7 ($8)',
	'abusefilter-log-detailslink' => 'details',
	'abusefilter-log-details-legend' => 'Details for log entry $1',
	'abusefilter-log-details-var' => 'Variable',
	'abusefilter-log-details-val' => 'Value',
	'abusefilter-log-details-vars' => 'Action parameters',
	'abusefilter-log-details-private' => 'Private data',
	'abusefilter-log-details-ip' => 'Originating IP address',
	'abusefilter-log-noactions' => 'none',
	
	// Abuse filter management
	'abusefilter-management' => 'Abuse filter management',
	'abusefilter-list' => 'All filters',
	'abusefilter-list-id' => 'Filter ID',
	'abusefilter-list-status' => 'Status',
	'abusefilter-list-public' => 'Public description',
	'abusefilter-list-consequences' => 'Consequences',
	'abusefilter-list-visibility' => 'Visibility',
	'abusefilter-list-hitcount' => 'Hit count',
	'abusefilter-list-edit' => 'Edit',
	'abusefilter-list-details' => 'Details',
	'abusefilter-hidden' => 'Private',
	'abusefilter-unhidden' => 'Public',
	'abusefilter-enabled' => 'Enabled',
	'abusefilter-disabled' => 'Disabled',
	'abusefilter-hitcount' => '$1 {{PLURAL:$1|hit|hits}}',
	'abusefilter-list-new' => 'New filter',
	'abusefilter-tools-modifiertest-submit' => 'Test',
	
	// Abuse filter tools
	'abusefilter-tools' => 'Some [[Special:AbuseFilter/tools|tools]] are available to assist in formulating and debugging abuse filters.',
	'abusefilter-tools-modifiertest' => 'Test modifiers',
	'abusefilter-tools-modifier' => 'Modifier:',
	'abusefilter-tools-value' => 'Value to test:',
	'abusefilter-tools-result' => 'Result:',
	
	// Abuse filter status
	'abusefilter-status' => "Of the last $1 actions, $2 ($3%) have reached the condition limit of $4. $5 ($6%) have matched one of the filters currently enabled.",
	
	// The edit screen
	'abusefilter-edit-subtitle' => 'Editing filter $1',
	'abusefilter-edit-status-label' => 'Statistics',
	'abusefilter-edit-status' => 'Of the last $1 actions, this filter has matched $2 ($3%).',
	'abusefilter-edit-throttled' => "'''Warning''': This filter was automatically disabled as a safety measure. It reached the limit of matching more than $1% of actions.",
	'abusefilter-edit-new' => 'New filter',
	'abusefilter-edit-save' => 'Save filter',
	'abusefilter-edit-id' => 'Filter ID:',
	'abusefilter-edit-description' => "Description:\n:''(publicly viewable)''",
	'abusefilter-edit-flags' => 'Flags:',
	'abusefilter-edit-enabled' => 'Enable this filter',
	'abusefilter-edit-hidden' => 'Hide details of this filter from public view',
	'abusefilter-edit-rules' => 'Ruleset:',
	'abusefilter-edit-notes' => "Notes:\n:''(private)",
	'abusefilter-edit-lastmod' => 'Filter last modified:',
	'abusefilter-edit-lastuser' => 'Last user to modify this filter:',
	'abusefilter-edit-hitcount' => 'Filter hits:',
	'abusefilter-edit-consequences' => 'Actions taken on hit',
	'abusefilter-edit-action-warn' => 'Trigger these actions after giving the user a warning',
	'abusefilter-edit-action-disallow' => 'Disallow the action',
	'abusefilter-edit-action-flag' => 'Flag the edit in the abuse log',
	'abusefilter-edit-action-blockautopromote' => "Revoke the users' autoconfirmed status",
	'abusefilter-edit-action-degroup' => 'Remove all privileged groups from the user',
	'abusefilter-edit-action-block' => 'Block the user from editing',
	'abusefilter-edit-action-throttle' => 'Trigger actions only if the user trips a rate limit',
	'abusefilter-edit-throttle-count' => 'Number of actions to allow:',
	'abusefilter-edit-throttle-period' => 'Period of time:',
	'abusefilter-edit-throttle-seconds' => '$1 seconds',
	'abusefilter-edit-throttle-groups' => "Group throttle by:\n:''(one per line, combine with commas)''",
	'abusefilter-edit-denied' => "You may not view details of this filter, because it is hidden from public view",
	'abusefilter-edit-main' => 'Filter parameters',
	'abusefilter-edit-done-subtitle' => 'Filter edited',
	'abusefilter-edit-done' => "You have successfully saved your changes to the filter.\n\n[[Special:AbuseFilter|Return]]",
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'abusefilter-list-edit' => "A'tū'ạki",
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'abusefilter-log-search-submit' => 'Kumi',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'abuselog'                              => 'Misbruiklogboek',
	'abusefilter-blocker'                   => 'Misbruikfilter',
	'abusefilter-log-search-user'           => 'Gebruiker:',
	'abusefilter-log-search-title'          => 'Titel:',
	'abusefilter-log-search-submit'         => 'Soek',
	'abusefilter-log-detailslink'           => 'details',
	'abusefilter-log-details-var'           => 'Veranderlike',
	'abusefilter-log-details-val'           => 'Waarde',
	'abusefilter-log-noactions'             => 'geen',
	'abusefilter-list-status'               => 'Status',
	'abusefilter-list-public'               => 'Publieke beskrywing',
	'abusefilter-list-consequences'         => 'Gevolge',
	'abusefilter-list-visibility'           => 'Sigbaarheid',
	'abusefilter-list-edit'                 => 'Wysig',
	'abusefilter-list-details'              => 'Details',
	'abusefilter-hidden'                    => 'Privaat',
	'abusefilter-unhidden'                  => 'Publiek',
	'abusefilter-tools-modifiertest-submit' => 'Toets',
	'abusefilter-tools-value'               => 'Waarde om te toets:',
	'abusefilter-tools-result'              => 'Resultaat:',
	'abusefilter-edit-status-label'         => 'Statistieke',
	'abusefilter-edit-throttle-seconds'     => '$1 sekondes',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Alnokta
 */
$messages['ar'] = array(
	'abusefilter-desc'                         => 'يطبق قواعد أوتوماتيكية على التعديلات.',
	'abusefilter'                              => 'ضبط فلتر الإساءة',
	'abuselog'                                 => 'سجل الإساءة',
	'abusefilter-warning'                      => "<big>'''تحذير'''</big>: هذا الفعل تم التعرف عليه تلقائيا كضار.
التعديلات غير البناءة سيتم استرجاعها سريعا،
والتعديل غير البناء المتكرر أو المستمر سيؤدي إلى منع حسابك أو حاسوبك.
لو كنت تعتقد أن هذا التعديل بناء، يمكنك أن تضغط تنفيذ مرة أخرى لتأكيده.
وصف مختصر لقاعدة الإساءة التي طابقها فعلك هو: $1",
	'abusefilter-disallowed'                   => 'هذا الفعل تم التعرف عليه تلقائيا كضار،
ولذا تم منعه.
لو كنت تعتقد أن تعديلك بناء، من فضلك اتصل بإداري، وأخبره بما كنت تحاول أن تفعل.
وصف مختصر لقاعدة الإساءة التي طابقها فعلك هو: $1',
	'abusefilter-blocked-display'              => 'هذا الفعل تم التعرف عليه تلقائيا كضار،
وأنت تم منعك من تنفيذه.
بالإضافة إلى ذلك، لحماية {{SITENAME}}، حسابك وكل عناوين الأيبي الملحقة تم منعها من التحرير.
لو أن هذا حدث بطريق الخطأ، من فضلك اتصل بإداري.
وصف مختصر لقاعدة الإساءة التي طابقها فعلك هو: $1',
	'abusefilter-degrouped'                    => 'هذا الفعل تم التعرف عليه تلقائيا كضار.
وبالتالي، تم منعه، و، بما أن حسابك مشكوك في أنه قد تم اختراقه، كل الصلاحيات تم سحبها.
لو أنك تعتقد أن هذا خطأ، من فضلك اتصل ببيروقراط بتفسير لهذا الفعل، وصلاحياتك ربما تتم استعادتها.
وصف مختصر لقاعدة الإساءة التي طابقها فعلك هو: $1',
	'abusefilter-autopromote-blocked'          => 'هذا الفعل تم التعرف عليه تلقائيا كضار، وتم منعه.
بالإضافة إلى ذلك، كإجراء أمني، بعض المميزات التي يتم منحها روتينيا للحسابات تمت إزالتها مؤقتا من حسابك.
وصف مختصر لقاعدة الإساءة التي طابقها فعلك هو: $1',
	'abusefilter-blocker'                      => 'فلتر الإساءة',
	'abusefilter-blockreason'                  => 'ممنوع تلقائيا بواسطة فلتر الإساءة. وصف القاعدة: $1',
	'abusefilter-degroupreason'                => 'الصلاحيات تمت إزالتها تلقائيا بواسطة فلتر الإساءة. وصف القاعدة: $1',
	'abusefilter-accountreserved'              => 'اسم الحساب هذا محجوز للاستخدام بواسطة فلتر الإساءة.',
	'right-abusefilter-modify'                 => 'تعديل فلترات الإساءة',
	'right-abusefilter-view'                   => 'عرض فلترات الإساءة',
	'right-abusefilter-log'                    => 'عرض سجل الإساءة',
	'right-abusefilter-log-detail'             => 'عرض مدخلات سجل الإساءة المفصلة',
	'right-abusefilter-private'                => 'عرض البيانات السرية في سجل الإساءة',
	'abusefilter-log'                          => 'سجل فلتر الإساءة',
	'abusefilter-log-search'                   => 'بحث سجل الإساءة',
	'abusefilter-log-search-user'              => 'المستخدم:',
	'abusefilter-log-search-filter'            => 'رقم الفلتر:',
	'abusefilter-log-search-title'             => 'العنوان:',
	'abusefilter-log-search-submit'            => 'بحث',
	'abusefilter-log-entry'                    => '$1: $2 فعل فلتر إساءة، فاعلا $3 في $4. الأفعال المتخذة: $5؛ وصف الفلتر: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 فعل الفلتر $3، فاعلا $4 في $5. الأفعال المتخذة: $6؛ وصف الفلتر: $7 ($8)',
	'abusefilter-log-detailslink'              => 'التفاصيل',
	'abusefilter-log-details-legend'           => 'التفاصيل لمدخلة السجل $1',
	'abusefilter-log-details-var'              => 'متغير',
	'abusefilter-log-details-val'              => 'قيمة',
	'abusefilter-log-details-vars'             => 'محددات الفعل',
	'abusefilter-log-details-private'          => 'بيانات سرية',
	'abusefilter-log-details-ip'               => 'عنوان الأيبي المصدر',
	'abusefilter-log-noactions'                => 'لا شيء',
	'abusefilter-management'                   => 'التحكم بفلتر الإساءة',
	'abusefilter-list'                         => 'كل الفلاتر',
	'abusefilter-list-id'                      => 'رقم الفلتر',
	'abusefilter-list-status'                  => 'الحالة',
	'abusefilter-list-public'                  => 'وصف علني',
	'abusefilter-list-consequences'            => 'العواقب',
	'abusefilter-list-visibility'              => 'رؤية',
	'abusefilter-list-hitcount'                => 'عدد الضربات',
	'abusefilter-list-edit'                    => 'عدل',
	'abusefilter-list-details'                 => 'التفاصيل',
	'abusefilter-hidden'                       => 'سري',
	'abusefilter-unhidden'                     => 'علني',
	'abusefilter-enabled'                      => 'مفعل',
	'abusefilter-disabled'                     => 'معطل',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|ضربة|ضربة}}',
	'abusefilter-list-new'                     => 'فلتر جديد',
	'abusefilter-tools-modifiertest-submit'    => 'اختبار',
	'abusefilter-tools'                        => 'بعض [[Special:AbuseFilter/tools|الأدوات]] متوفرة للمساعدة في صياغة وتصحيح فلترات الإساءة.',
	'abusefilter-tools-modifiertest'           => 'معدلات الاختبار',
	'abusefilter-tools-modifier'               => 'المعدل:',
	'abusefilter-tools-value'                  => 'القيمة ليتم اختبارها:',
	'abusefilter-tools-result'                 => 'النتيجة:',
	'abusefilter-status'                       => 'من آخر $1 فعل، $2 ($3%) وصلت لحد الحالة ل$4. $5 ($6%) طابقت واحدا من الفلترات المفعلة حاليا.',
	'abusefilter-edit-subtitle'                => 'تعديل الفلتر $1',
	'abusefilter-edit-status-label'            => 'إحصاءات',
	'abusefilter-edit-status'                  => 'من آخر $1 تعديل، الفلتر طابق $2 ($3%).',
	'abusefilter-edit-throttled'               => "'''تحذير''': هذا الفلتر تم تعطيله تلقائيا كإجراء أمني. لقد وصل إلى حد مطابقة أكثر من $1% من الأفعال.",
	'abusefilter-edit-new'                     => 'فلتر جديد',
	'abusefilter-edit-save'                    => 'حفظ الفلتر',
	'abusefilter-edit-id'                      => 'رقم الفلتر:',
	'abusefilter-edit-description'             => "الوصف:
:''(معروض علنيا)''",
	'abusefilter-edit-flags'                   => 'الأعلام:',
	'abusefilter-edit-enabled'                 => 'تفعيل هذا الفلتر',
	'abusefilter-edit-hidden'                  => 'إخفاء تفاصيل هذا الفلتر من العرض العلني',
	'abusefilter-edit-rules'                   => 'مجموعة القاعدة:',
	'abusefilter-edit-notes'                   => "ملاحظات:
:''(سرية)",
	'abusefilter-edit-lastmod'                 => 'فلتر المعدل آخرا',
	'abusefilter-edit-lastuser'                => 'آخر مستخدم عدل هذا الفلتر:',
	'abusefilter-edit-hitcount'                => 'ضربات الفلتر:',
	'abusefilter-edit-consequences'            => 'الأفعال المتخذة عند الضرب',
	'abusefilter-edit-action-warn'             => 'نفذ هذه الأفعال بعد إعطاء المستخدم تحذيرا',
	'abusefilter-edit-action-disallow'         => 'منع الفعل',
	'abusefilter-edit-action-flag'             => 'علم على التعديل في سجل الإساءة',
	'abusefilter-edit-action-blockautopromote' => 'اسحب حالة التأكيد التلقائي من المستخدم',
	'abusefilter-edit-action-degroup'          => 'أزل كل المجموعات المميزة من المستخدم',
	'abusefilter-edit-action-block'            => 'امنع المستخدم من التحرير',
	'abusefilter-edit-action-throttle'         => 'نفذ الأفعال فقط إذا ما تجاوز المستخدم حد المعدل',
	'abusefilter-edit-throttle-count'          => 'عدد الأفعال المسموح بها:',
	'abusefilter-edit-throttle-period'         => 'فترة من الزمن:',
	'abusefilter-edit-throttle-seconds'        => '$1 ثانية',
	'abusefilter-edit-throttle-groups'         => "حد المجموعة بواسطة:
:''(واحدة لكل سطر، ادمج بالفاصلات)''",
	'abusefilter-edit-denied'                  => 'أنت لا يمكنك رؤية تفاصيل هذا الفلتر، لأنه مخفي من العرض العلني',
	'abusefilter-edit-main'                    => 'محددات الفلتر',
	'abusefilter-edit-done-subtitle'           => 'الفلتر تم تعديله',
	'abusefilter-edit-done'                    => 'أنت حفظت تغييراتك للفلتر بنجاح.

[[Special:AbuseFilter|رجوع]]',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ramsis1978
 */
$messages['arz'] = array(
	'abusefilter-log-search-user'              => 'يوزر:',
	'abusefilter-edit-action-disallow'         => 'منع الفعل',
	'abusefilter-edit-action-flag'             => 'علم على التعديل في سجل الإساءة',
	'abusefilter-edit-action-blockautopromote' => 'اسحب حالة التأكيد الأوتوماتيكي من اليوزر',
	'abusefilter-edit-action-degroup'          => 'شيل كل المجموعات المميزة من اليوزر',
	'abusefilter-edit-action-block'            => 'إمنع اليوزر من التحرير',
	'abusefilter-edit-action-throttle'         => 'نفذ الأفعال بس لو اليوزر اتجاوز حد المعدل',
	'abusefilter-edit-throttle-count'          => 'عدد الأفعال المسموح بيها:',
	'abusefilter-edit-throttle-period'         => 'مدة من الزمن:',
	'abusefilter-edit-throttle-seconds'        => '$1 ثواني',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author Red Winged Duck
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'abusefilter-desc'    => 'Прыстасоўвае аўтаматычную эўрыстыку да рэдагаваньняў.',
	'abusefilter'         => 'Наладка фільтра злоўжываньняў',
	'abuselog'            => 'Журнал злоўжываньняў',
	'abusefilter-warning' => "<big>'''Увага'''</big>: Гэтае дзеяньне будзе аўтаматычна лічыцца шкодным. Неканструктыўныя рэдагаваньні будуць адмененыя, і значныя ці неаднаразовыя неканструктыўныя рэдагаваньні прывядуць да блякаваньня Вашага рахунка ці кампутара. Калі Вы лічыце гэтае рэдагаваньне канструктыўным, Вам неабходна націснуць «Адправіць» яшчэ раз каб яго пацьвердзіць.
Кароткі сьпіс злоўжываньняў, зь якімі суадносіцца Вашае дзеяньне тут: $1",
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'abuselog'                          => 'Дневник на злоупотребите',
	'abusefilter-accountreserved'       => 'Това име на сметка е запазено за употреба от филтъра за злоупотреби.',
	'right-abusefilter-modify'          => 'Променяне на филтрите за злоупотреби',
	'right-abusefilter-view'            => 'Преглеждане на филтрите за злоупотреби',
	'right-abusefilter-log'             => 'Преглеждане на дневника със злоупотребите',
	'right-abusefilter-log-detail'      => 'Преглеждане на подробни записи в дневника за злоупотребите',
	'right-abusefilter-private'         => 'Преглеждане на личните данни в дневника със злоупотребите',
	'abusefilter-log-search'            => 'Търсене в дневника със злоупотреби',
	'abusefilter-log-search-user'       => 'Потребител:',
	'abusefilter-log-search-title'      => 'Заглавие:',
	'abusefilter-log-search-submit'     => 'Търсене',
	'abusefilter-log-detailslink'       => 'детайли',
	'abusefilter-log-details-var'       => 'Променлива',
	'abusefilter-log-details-val'       => 'Стойност',
	'abusefilter-log-noactions'         => 'няма',
	'abusefilter-list'                  => 'Всички филтри',
	'abusefilter-list-status'           => 'Статут',
	'abusefilter-list-public'           => 'Публично описание',
	'abusefilter-list-edit'             => 'Редактиране',
	'abusefilter-list-details'          => 'Детайли',
	'abusefilter-list-new'              => 'Нов филтър',
	'abusefilter-tools-result'          => 'Резултат:',
	'abusefilter-edit-subtitle'         => 'Редактиране на филтър $1',
	'abusefilter-edit-new'              => 'Нов филтър',
	'abusefilter-edit-save'             => 'Съхраняване на филтъра',
	'abusefilter-edit-throttle-period'  => 'Период от време:',
	'abusefilter-edit-throttle-seconds' => '$1 секунди',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'abusefilter-log-search-user'       => 'Implijer :',
	'abusefilter-log-search-submit'     => 'Klask',
	'abusefilter-list-details'          => 'Munudoù',
	'abusefilter-hidden'                => 'Prevez',
	'abusefilter-unhidden'              => 'Foran',
	'abusefilter-edit-new'              => 'Sil nevez',
	'abusefilter-edit-save'             => 'Enrollañ ar sil',
	'abusefilter-edit-throttle-period'  => 'Prantad amzer :',
	'abusefilter-edit-throttle-seconds' => '$1 eilenn',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'abusefilter-desc'                         => 'Nałožujo awtomatisku heuristiku na změny.',
	'abusefilter'                              => 'Konfiguracija filtra znjewužywanja',
	'abuselog'                                 => 'Protokol znjewužywanjow',
	'abusefilter-blocker'                      => 'Filter znjewužywanja',
	'abusefilter-blockreason'                  => 'Awtomatiski pśez filter znjewužywanja blokěrowany. Wopisanje pšawidła: $1',
	'abusefilter-degroupreason'                => 'Pšawa awtomatiski pśez fitler znjewužywanja zajmjone. Wopisanje pšawidła: $1',
	'abusefilter-accountreserved'              => 'Toś to kontowe mě jo za wužywanje pśez filter znjewužywanja wuměnjone.',
	'right-abusefilter-modify'                 => 'Filtry znjewužywanja změniś',
	'right-abusefilter-view'                   => 'Filtry znjewužywanja zwobrazniś',
	'right-abusefilter-log'                    => 'Protokol znjewužywanjow zwobrazniś',
	'right-abusefilter-log-detail'             => 'Detailěrowane zapiski protokola znjewužywanjow zwbrazniś',
	'right-abusefilter-private'                => 'Priwatne daty w protokolu znjewužywanjow zwobrazniś',
	'abusefilter-log'                          => 'Protokol filtrow znjewužywanja',
	'abusefilter-log-search'                   => 'Protokol znjewužywanjow pytaś',
	'abusefilter-log-search-user'              => 'Wužywaŕ:',
	'abusefilter-log-search-filter'            => 'ID filtra:',
	'abusefilter-log-search-title'             => 'Titel:',
	'abusefilter-log-search-submit'            => 'Pytaś',
	'abusefilter-log-entry'                    => '$1: $2 jo filter znjewužywanja zapušćił a $3 na $4 cynił. Wuwjeźone akcije: $5; Wopisanje filtra: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 jo filter $3 zapušćił a $4 na $5 cynił. Wuwjeźone akcije: $6. Wopisanje filtra: $7 ($8)',
	'abusefilter-log-detailslink'              => 'Drobnosći',
	'abusefilter-log-details-legend'           => 'Drobnosći za protokolowy zapisk $1',
	'abusefilter-log-details-var'              => 'Wariabla',
	'abusefilter-log-details-val'              => 'Gódnota',
	'abusefilter-log-details-vars'             => 'Akcijne parametry',
	'abusefilter-log-details-private'          => 'Priwatne daty',
	'abusefilter-log-details-ip'               => 'Wuchadna adresa IP',
	'abusefilter-log-noactions'                => 'žeden',
	'abusefilter-management'                   => 'Zastojanje filtrow znjewužywanja',
	'abusefilter-list'                         => 'Wše filtry',
	'abusefilter-list-id'                      => 'ID filtra',
	'abusefilter-list-status'                  => 'Status',
	'abusefilter-list-public'                  => 'Zjawne wopisanje',
	'abusefilter-list-consequences'            => 'Konsekwence',
	'abusefilter-list-visibility'              => 'Widobnosć',
	'abusefilter-list-hitcount'                => 'Trjefarje licyś',
	'abusefilter-list-edit'                    => 'Wobźěłaś',
	'abusefilter-list-details'                 => 'Drobnosći',
	'abusefilter-hidden'                       => 'Priwatny',
	'abusefilter-unhidden'                     => 'Zjawny',
	'abusefilter-enabled'                      => 'Zmóžnjony',
	'abusefilter-disabled'                     => 'Znjemóžnjony',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|trjefaŕ|trjefarja|trjefarje|trjefarjow}}',
	'abusefilter-list-new'                     => 'Nowy filter',
	'abusefilter-edit-subtitle'                => 'Filter $1 se wobźěłujo',
	'abusefilter-edit-new'                     => 'Nowy filter',
	'abusefilter-edit-save'                    => 'Filter składowaś',
	'abusefilter-edit-id'                      => 'ID filtra:',
	'abusefilter-edit-description'             => "Wopisanje:
:''(zjawnje widobne)''",
	'abusefilter-edit-flags'                   => 'Wobznamjenja:',
	'abusefilter-edit-enabled'                 => 'Toś ten filter zmóžniś',
	'abusefilter-edit-hidden'                  => 'Drobnosći toś togo filtra pśed zjawnym zwobraznjenim schowaś',
	'abusefilter-edit-rules'                   => 'Sajźba pšawidłow:',
	'abusefilter-edit-notes'                   => "Pśipomnjeś:
:'' (priwatny)",
	'abusefilter-edit-lastmod'                 => 'filter slědny raz změnjony:',
	'abusefilter-edit-lastuser'                => 'Slědny wužywaŕ, kótaryž toś ten filter wobźěłał:',
	'abusefilter-edit-hitcount'                => 'Licba filtrowych trefarjow:',
	'abusefilter-edit-consequences'            => 'Akcije wuwjeźone pśi trjefarju',
	'abusefilter-edit-action-warn'             => 'Toś te akcije pó warnowanju do wužiwarja zapušćiś',
	'abusefilter-edit-action-disallow'         => 'Akciju zakazaś',
	'abusefilter-edit-action-flag'             => 'Změnu w protokolu znjewužywanjow wobznamjeniś',
	'abusefilter-edit-action-blockautopromote' => 'Wužywarjeju awtomatiski wobkšuśony status zajmjeś',
	'abusefilter-edit-action-degroup'          => 'Wužywarja ze wšych priwilegěrowanych kupkow wótwónoźeś',
	'abusefilter-edit-action-block'            => 'Wobźełanje pśez wužywarja blokěrowaś',
	'abusefilter-edit-action-throttle'         => 'Akcije jano zapušćiś, jolic wužywaŕ pśekšaca progowy gódnotu',
	'abusefilter-edit-throttle-count'          => 'Licba dowólonych akcijow:',
	'abusefilter-edit-throttle-period'         => 'Casowy interwal:',
	'abusefilter-edit-throttle-seconds'        => '$1 {{PLURAL:$1|sekunda|sekunźe|sekundy|sekundow}}',
	'abusefilter-edit-throttle-groups'         => "Wobgranicowanje spěšnosći wobźěłanja kupki pśez:
:''(jadna na smužku, někotare z komami)''",
	'abusefilter-edit-denied'                  => 'Njamóžośo drobnosći toś togo filtra wiźeś, dokulaž jo pśed zjawneym zwobranjenim schowany.',
	'abusefilter-edit-main'                    => 'Filtrowe parametry',
	'abusefilter-edit-done-subtitle'           => 'Filter wobźěłany',
	'abusefilter-edit-done'                    => 'Sy swóje změny na filtrach wuspěšnje składł.

[[Special:AbuseFilter|Slědk]]',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'abusefilter-desc'                  => 'Aplikas aŭtomatan heŭristikon al redaktoj.',
	'abusefilter'                       => 'Konfiguri filtrilon de misuzado',
	'abuselog'                          => 'Protokolo pri misuzado',
	'abusefilter-warning'               => "<big>'''Averto'''</big>: Ĉi tiu ago estis aŭtomate identigita kiel misuzema.
Malkonstruktivaj redaktoj rapide estos malfaritaj,
kaj ĉi tia ega aŭ ripetita redaktado rezultos, ke via konto aŭ komputilo estos forbarita.
Se vi kredas ke ĉi tiu redakto estas ja konstruktiva, vi povas klaki Konservi denove por konfirmi ĝin.
Mallonga priskribo pri la regulo de misuzo kiun via ago kongruis estas: $1",
	'abusefilter-blocker'               => 'Filtrilo de misuzo',
	'right-abusefilter-modify'          => 'Modifi filtrilojn de misuzo',
	'right-abusefilter-view'            => 'Rigardi filtrilojn de misuzo',
	'right-abusefilter-log'             => 'Rigardi la protokolon de misuzo',
	'right-abusefilter-log-detail'      => 'Rigardi detalojn en la protokolo de misuzo',
	'right-abusefilter-private'         => 'Rigardi privatajn datenojn en la protokolo de misuzo',
	'abusefilter-log'                   => 'Protokolo pri Filtrilo de Misuzo',
	'abusefilter-log-search'            => 'Serĉi la protokolon de misuzo',
	'abusefilter-log-search-user'       => 'Uzanto',
	'abusefilter-log-search-filter'     => 'Identigo de filtrilo:',
	'abusefilter-log-search-title'      => 'Titolo:',
	'abusefilter-log-search-submit'     => 'Serĉi',
	'abusefilter-log-detailslink'       => 'detaloj',
	'abusefilter-log-details-legend'    => 'Detaloj por protokola listano $1',
	'abusefilter-log-details-var'       => 'Variablo',
	'abusefilter-log-details-val'       => 'Valuto',
	'abusefilter-log-details-vars'      => 'Parametroj de ago',
	'abusefilter-log-details-private'   => 'Privataj datenoj',
	'abusefilter-log-details-ip'        => 'Originala IP-adreso',
	'abusefilter-log-noactions'         => 'neniu',
	'abusefilter-management'            => 'Administrado de filtriloj de misuzo',
	'abusefilter-list'                  => 'Ĉiuj filtriloj',
	'abusefilter-list-id'               => 'Identigo de Filtrilo',
	'abusefilter-list-status'           => 'Statuso',
	'abusefilter-list-public'           => 'Publika priskribo',
	'abusefilter-list-consequences'     => 'Konsekvencoj',
	'abusefilter-list-visibility'       => 'Videbleco',
	'abusefilter-list-edit'             => 'Redakti',
	'abusefilter-hidden'                => 'Privata',
	'abusefilter-unhidden'              => 'Publika',
	'abusefilter-disabled'              => 'Malebligita',
	'abusefilter-hitcount'              => '$1 {{PLURAL:$1|trovo|trovoj}}',
	'abusefilter-list-new'              => 'Nova filtrilo',
	'abusefilter-edit-subtitle'         => 'Redaktis filtrilon $1',
	'abusefilter-edit-new'              => 'Nova filtrilo',
	'abusefilter-edit-save'             => 'Konservi filtrilon',
	'abusefilter-edit-enabled'          => 'Ebligi ĉi tiun filtrilon',
	'abusefilter-edit-hidden'           => 'Kaŝi detalojn pri ĉi tiu filtrilo de publika vido',
	'abusefilter-edit-rules'            => 'Regularo:',
	'abusefilter-edit-notes'            => "Notoj:
:''(privata)",
	'abusefilter-edit-lastmod'          => 'Filtri laste modifitajn:',
	'abusefilter-edit-lastuser'         => 'Lasta uzanto modifanta ĉi tiun filtrilon:',
	'abusefilter-edit-action-disallow'  => 'Malpermesi la agon',
	'abusefilter-edit-action-block'     => 'Forbari la uzanton de redaktado',
	'abusefilter-edit-throttle-period'  => 'Tempdaŭro:',
	'abusefilter-edit-throttle-seconds' => '$1 sekundoj',
	'abusefilter-edit-denied'           => 'Vi ne rajtas vidi detalojn pri ĉi tiu filtrilo, ĉar ĝi estas kaŝita de publika vido',
	'abusefilter-edit-main'             => 'Filtraj parametroj',
	'abusefilter-edit-done-subtitle'    => 'Filtrilo redaktita',
	'abusefilter-edit-done'             => 'Vi sukcese konservis viajn ŝanĝojn al la filtrilo.

[[Special:AbuseFilter|Reiri]]',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'abusefilter-desc'                         => 'Applique des heuristiques automatiques aux modifications',
	'abusefilter'                              => 'Configuration du filtre des abus',
	'abuselog'                                 => 'Journal des abus',
	'abusefilter-warning'                      => "<big>'''Avertissement'''</big> : Cette action a été identifiée automatiquement comme nuisible.
Les éditions non constructives seront rapidement annulée,
et la répétition des âneries du même genre provoquera le blocage de votre compte.
Si vous être convaincu que votre modification est constructive, vous pouvez la soumettre une nouvelle fois pour la valider.
Voici description brève de la règle de l’abus qui a détecté votre action : $1",
	'abusefilter-disallowed'                   => 'Cette modification a été automatiquement idenfiée comme nuisible et, par voie de conséquence, non permise. Si vous êtes convaicu que votre modification était constructive, veuillez contacter un administrateur, et informez le de quelle action vous êtiez en train de faire : $1',
	'abusefilter-blocked-display'              => 'Cette action a été automatiquement identifée comme nuisible, et vous avez déjà été empêché de l’exécuter.
En conséquence, pour protéger {{SITENAME}}, votre compte utilisateur et toutes les adresses IP associées ont été bloqués en écriture.
Si ceci est dû à une erreur, veuillez contacter un administrateur.
Voici la courte description de la règle de l’abus qui a détecté votre action : $1',
	'abusefilter-degrouped'                    => 'Cette action a été automatiquement identifiée comme nuisible.
En conséquence, elle a été non permise, dès lors, votre compte est suspecté de compromission, tous vos droits ont été enlevés.
Si vous êtes convaincu que cela est dû à une erreur, veuillez contacter un bureaucrate avec une explication de cette action, et tous vos droits pourront être rétablis.
Voici la courte description de la règle de l’abus qui a détecté votre action : $1',
	'abusefilter-autopromote-blocked'          => 'Cette action a été automatiquement identifié comme nuisible, et elle a été non permise.
En conséquence, à titre de mesure de sécurité, quelques privilèges accordés d’habitude pour les comptes établis ont été révoqués temporairement de votre compte.
Une brève description de la règle d’abus que votre action a déclenchée est : $1',
	'abusefilter-blocker'                      => 'Filtre des abus',
	'abusefilter-blockreason'                  => 'Bloqué automatiquement pour avoir tenté d’avoir fait des modifications identifiées comme nuisibles. Description de la règle : $1',
	'abusefilter-degroupreason'                => 'Droits automatiquement retirés par le filtre des abus. Description de la règle : $1',
	'abusefilter-accountreserved'              => 'Le nom de ce compte est révervé pour l’usage par le filtre des abus.',
	'right-abusefilter-modify'                 => 'Modifier les filtres des abus',
	'right-abusefilter-view'                   => 'Voir les filtres des abus',
	'right-abusefilter-log'                    => 'Voir le journal des abus',
	'right-abusefilter-log-detail'             => 'Voir les entrées du journal détaillé des abus',
	'right-abusefilter-private'                => 'Voir les données privées dans le journal des abus',
	'abusefilter-log'                          => 'Journal du filtre des abus',
	'abusefilter-log-search'                   => 'Rechercher le journal des abus',
	'abusefilter-log-search-user'              => 'Utilisateur :',
	'abusefilter-log-search-filter'            => 'Filtre ID :',
	'abusefilter-log-search-title'             => 'Titre :',
	'abusefilter-log-search-submit'            => 'Rechercher',
	'abusefilter-log-entry'                    => '$1 : $2 a déclenché un filtre des abus, faisant un $3 sur $4. Actions prises : $5 ; Description du filtre : $6',
	'abusefilter-log-detailedentry'            => '$1 : $2 a déclenché le filtre $3 des abus, faisant un $4 sur $5. Actions prises : $6 ; Description du filtre : $7 ($8)',
	'abusefilter-log-detailslink'              => 'détails',
	'abusefilter-log-details-legend'           => "Détails pour l'entrée $1 du journal",
	'abusefilter-log-details-var'              => 'Variable',
	'abusefilter-log-details-val'              => 'Valeur',
	'abusefilter-log-details-vars'             => 'Paramètres de l’action',
	'abusefilter-log-details-private'          => 'Donnée privée',
	'abusefilter-log-details-ip'               => 'Provenance de l’adresse IP',
	'abusefilter-log-noactions'                => 'néant',
	'abusefilter-management'                   => 'Gestion du filtre des abus',
	'abusefilter-list'                         => 'Tous les filtres',
	'abusefilter-list-id'                      => 'Filtre ID',
	'abusefilter-list-status'                  => 'Statut',
	'abusefilter-list-public'                  => 'Description publique',
	'abusefilter-list-consequences'            => 'Conséquences',
	'abusefilter-list-visibility'              => 'Visibilité',
	'abusefilter-list-hitcount'                => 'Lancer le compteur',
	'abusefilter-list-edit'                    => 'Modifier',
	'abusefilter-list-details'                 => 'Détails',
	'abusefilter-hidden'                       => 'Privé',
	'abusefilter-unhidden'                     => 'Public',
	'abusefilter-enabled'                      => 'Activé',
	'abusefilter-disabled'                     => 'Désactivé',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|visite|visites}}',
	'abusefilter-list-new'                     => 'Nouveau filtre',
	'abusefilter-tools-modifiertest-submit'    => 'Test',
	'abusefilter-tools'                        => 'Quelques [[Special:AbuseFilter/tools|outils]] sont disponibles pour aider à la formulation et au déboggage des filtres des abus.',
	'abusefilter-tools-modifiertest'           => 'Modifier le test',
	'abusefilter-tools-modifier'               => 'Modifier :',
	'abusefilter-tools-value'                  => 'Valeur à tester :',
	'abusefilter-tools-result'                 => 'Résultat :',
	'abusefilter-status'                       => 'Des $1 dernières actions, $2 ($3 %) ont atteint la limite de la condition définie par $4. $5 ($6 %) correspondent à l’un de ces filtres actuellement en service.',
	'abusefilter-edit-subtitle'                => 'Modification du filtre $1',
	'abusefilter-edit-status-label'            => 'Statistiques',
	'abusefilter-edit-status'                  => 'Des $1 dernières actions, ce filtre a atteint $2 ($3 %).',
	'abusefilter-edit-throttled'               => "'''Avertissement''' : Ce filtre a été désactivé automatiquement par mesure de sécurité. Il a atteint la limite de correspondance à plus de $1 % des actions.",
	'abusefilter-edit-new'                     => 'Nouveau filtre',
	'abusefilter-edit-save'                    => 'Sauvegarder le filtre',
	'abusefilter-edit-id'                      => 'Filtre ID :',
	'abusefilter-edit-description'             => "Description :
:''(Visible publiquement)''",
	'abusefilter-edit-flags'                   => 'Drapeaux :',
	'abusefilter-edit-enabled'                 => 'Activer ce filtre',
	'abusefilter-edit-hidden'                  => 'Cacher les détails de ce filtre à la vue publique',
	'abusefilter-edit-rules'                   => 'Paramètre de la règle :',
	'abusefilter-edit-notes'                   => "Notes :
:''(privé)''",
	'abusefilter-edit-lastmod'                 => 'Filtre modifié en dernier :',
	'abusefilter-edit-lastuser'                => 'Dernier utilisateur ayant modifié ce filtre :',
	'abusefilter-edit-hitcount'                => 'Visites du filtre :',
	'abusefilter-edit-consequences'            => 'Actions entreprises lors de la visite',
	'abusefilter-edit-action-warn'             => 'Déclencher ces actions après avoir donné un avertissement à l’utilisateur',
	'abusefilter-edit-action-disallow'         => 'Ne pas permettre l’action',
	'abusefilter-edit-action-flag'             => 'Marquer la modification dans le journal des abus',
	'abusefilter-edit-action-blockautopromote' => 'Révoquer le status de compte automatiquement confirmé de l’utilisateur',
	'abusefilter-edit-action-degroup'          => 'Retirer à l’utilisateur tous les groupes privilégiés',
	'abusefilter-edit-action-block'            => 'Bloquer l’utilisateur en écriture',
	'abusefilter-edit-action-throttle'         => 'Déclencher les actions uniquement si l’utilisateur a dépassé les limites',
	'abusefilter-edit-throttle-count'          => 'Nombre d’actions à autoriser :',
	'abusefilter-edit-throttle-period'         => 'Laps de temps :',
	'abusefilter-edit-throttle-seconds'        => '$1 secondes',
	'abusefilter-edit-throttle-groups'         => "Group détenu par :
:''(un par ligne, séparé par des virgules)''",
	'abusefilter-edit-denied'                  => 'Vous ne pouvez pas voir les détails de ce filtre parce qu’il est caché à la vue du public',
	'abusefilter-edit-main'                    => 'Paramètres du filtre',
	'abusefilter-edit-done-subtitle'           => 'Filtre modifié',
	'abusefilter-edit-done'                    => 'Vous avez sauvegardé vos modifications avec succès dans le filtre.

[[Special:AbuseFilter|Retour]]',
);

/** Western Frisian (Frysk)
 * @author Pyt
 */
$messages['fy'] = array(
	'abusefilter-desc' => 'Fiert automatyske heuristyske analyse út op bewurkings',
	'abusefilter'      => 'Misbrûkfilterkonfiguraasje',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'abusefilter-desc'                         => 'Aplica heurísticas automáticas ás edicións.',
	'abusefilter'                              => 'Configuración do filtro de abusos',
	'abuselog'                                 => 'Rexistro de abusos',
	'abusefilter-warning'                      => "<big>'''Atención:'''</big> esta acción foi identificada automaticamente como dañina.
As edicións non construtivas serán revertidas rapidamente,
e a repetición destas edicións dará como resultado o bloqueo da súa conta ou do seu computador.
Se cre que esta edición é construtiva, pode premer outra vez en \"Enviar\" para confirmalo.
Unha breve descrición da regra de abuso coa que a súa acción coincide é: \$1",
	'abusefilter-disallowed'                   => 'Esta acción foi identificada automaticamente como dañina
e por iso non está permitida.
Se cre que a súa edición foi construtiva, por favor, contacte cun administrador e infórmelle do que estaba intentando facer.
Unha breve descrición da regra de abuso coa que a súa acción coincide é: $1',
	'abusefilter-blocked-display'              => 'Esta acción foi identificada automaticamente como dañina
e impedíuselle que a executase.
Ademais, para protexer a {{SITENAME}}, a súa conta de usuario e todos os enderezos IP asociados foron bloqueados fronte á edición.
Se isto ocorreu por erro, por favor, contacte cun administrador.
Unha breve descrición da regra de abuso coa que a súa acción coincide é: $1',
	'abusefilter-degrouped'                    => 'Esta acción foi identificada automaticamente como dañina.
Como consecuencia, non está perminita e, desde que se sospeita que a súa conta está comprometida, todos os seus dereitos foron revogados.
Se cre que isto foi un erro, por favor, contacte cun burócrata cunha explicación desta acción e os seus dereitos serán restaurados.
Unha breve descrición da regra de abuso coa que a súa acción coincide é: $1',
	'abusefilter-autopromote-blocked'          => 'Esta acción foi identificada automaticamente como dañina e non está permitida.
Ademais, como medida de seguridade, fóronlle revogados temporalmente da súa conta algúns privilexios que habitualmente son concedidos ás contas establecidas.
Unha breve descrición da regra de abuso coa que a súa acción coincide é: $1',
	'abusefilter-blocker'                      => 'Filtro de abusos',
	'abusefilter-blockreason'                  => 'Bloqueado automaticamente polo filtro de abusos. Descrición da regra: $1',
	'abusefilter-degroupreason'                => 'Os dereitos foron retirados automaticamente polo filtro de abusos. Descrición da regra: $1',
	'abusefilter-accountreserved'              => 'Este nome de conta está reservado para ser usado polo filtro de abusos.',
	'right-abusefilter-modify'                 => 'Modificar os filtros de abuso',
	'right-abusefilter-view'                   => 'Ver os filtros de abuso',
	'right-abusefilter-log'                    => 'Ver o rexistro de abusos',
	'right-abusefilter-log-detail'             => 'Ver os detalles das entradas do rexistro de abusos',
	'right-abusefilter-private'                => 'Ver os datos privados no rexistro de abusos',
	'abusefilter-log'                          => 'Rexistro do filtro de abusos',
	'abusefilter-log-search'                   => 'Procurar o rexistro de abuso',
	'abusefilter-log-search-user'              => 'Usuario:',
	'abusefilter-log-search-filter'            => 'Filtrar o ID:',
	'abusefilter-log-search-title'             => 'Título:',
	'abusefilter-log-search-submit'            => 'Procurar',
	'abusefilter-log-entry'                    => '$1: $2 accionou o filtro de abusos, facendo un $3 en $4. Accións levadas a cabo: $5; descrición do filtro: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 accionou o filtro $3, facendo un $4 en $5. Accións levadas a cabo: $6; descrición do filtro: $7 ($8)',
	'abusefilter-log-detailslink'              => 'detalles',
	'abusefilter-log-details-legend'           => 'Detalles para a entrada $1 do rexistro',
	'abusefilter-log-details-var'              => 'Variable',
	'abusefilter-log-details-val'              => 'Valor',
	'abusefilter-log-details-vars'             => 'Parámetros de acción',
	'abusefilter-log-details-private'          => 'Datos privados',
	'abusefilter-log-details-ip'               => 'Enderezo IP de orixe',
	'abusefilter-log-noactions'                => 'ningunha',
	'abusefilter-management'                   => 'Xestión do filtro de abusos',
	'abusefilter-list'                         => 'Todos os filtros',
	'abusefilter-list-id'                      => 'Filtrar o ID',
	'abusefilter-list-status'                  => 'Status',
	'abusefilter-list-public'                  => 'Descrición pública',
	'abusefilter-list-consequences'            => 'Consecuencias',
	'abusefilter-list-visibility'              => 'Visibilidade',
	'abusefilter-list-hitcount'                => 'Contador de visitas',
	'abusefilter-list-edit'                    => 'Editar',
	'abusefilter-list-details'                 => 'Detalles',
	'abusefilter-hidden'                       => 'Privado',
	'abusefilter-unhidden'                     => 'Público',
	'abusefilter-enabled'                      => 'Permitido',
	'abusefilter-disabled'                     => 'Non permitido',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|visita|visitas}}',
	'abusefilter-list-new'                     => 'Novo filtro',
	'abusefilter-tools-modifiertest-submit'    => 'Proba',
	'abusefilter-tools'                        => 'Están dispoñibles algunhas [[Special:AbuseFilter/tools|ferramentas]] para axudar a formular e depurar filtros de abuso.',
	'abusefilter-tools-modifiertest'           => 'Probar os modificadores',
	'abusefilter-tools-modifier'               => 'Modificador:',
	'abusefilter-tools-value'                  => 'Valor para probar:',
	'abusefilter-tools-result'                 => 'Resultado:',
	'abusefilter-status'                       => 'Das $1 últimas accións, $2 ($3%) acadaron o condición límite de $4. $5 ($6%) coincidiron cun dos filtros permitidos actualmente.',
	'abusefilter-edit-subtitle'                => 'Editando o filtro $1',
	'abusefilter-edit-status-label'            => 'Estatísticas',
	'abusefilter-edit-status'                  => 'Das $1 últimas accións, este filtro coincidiu con $2 ($3%).',
	'abusefilter-edit-throttled'               => "'''Aviso:''' este filtro foi deshabilitado automaticamente como unha medida de seguridade. Alcanzouse o límite de  máis de $1% de coincidencias de accións.",
	'abusefilter-edit-new'                     => 'Novo filtro',
	'abusefilter-edit-save'                    => 'Gardar o filtro',
	'abusefilter-edit-id'                      => 'Filtrar o ID:',
	'abusefilter-edit-description'             => "Descrición:
:''(visible publicamente)''",
	'abusefilter-edit-flags'                   => 'Revisións:',
	'abusefilter-edit-enabled'                 => 'Permitir este filtro',
	'abusefilter-edit-hidden'                  => 'Agochar os detalles deste filtro da vista pública',
	'abusefilter-edit-rules'                   => 'Parámetros das regras:',
	'abusefilter-edit-notes'                   => "Notas:
:''(privado)''",
	'abusefilter-edit-lastmod'                 => 'O filtro foi modificado por última vez:',
	'abusefilter-edit-lastuser'                => 'Último usuario que modificou este filtro:',
	'abusefilter-edit-hitcount'                => 'Visitas do filtro:',
	'abusefilter-edit-consequences'            => 'Accións levadas a cabo nel',
	'abusefilter-edit-action-warn'             => 'Accionar estas accións despois de darlle ao usuario un aviso',
	'abusefilter-edit-action-disallow'         => 'Non permitir a acción',
	'abusefilter-edit-action-flag'             => 'Revisar a edición no rexistro de abusos',
	'abusefilter-edit-action-blockautopromote' => 'Revogar o status de usuario autoconfirmado',
	'abusefilter-edit-action-degroup'          => 'Eliminar todos os grupos de privilexios dun usuario',
	'abusefilter-edit-action-block'            => 'Bloquear este usuario fronte á edición',
	'abusefilter-edit-action-throttle'         => 'Accionar as accións só se o usuario se salta un límite',
	'abusefilter-edit-throttle-count'          => 'Número de accións a permitir:',
	'abusefilter-edit-throttle-period'         => 'Período de tempo:',
	'abusefilter-edit-throttle-seconds'        => '$1 segundos',
	'abusefilter-edit-throttle-groups'         => "Grupo acelerado por:
:''(un por liña, combinar con comas)''",
	'abusefilter-edit-denied'                  => 'Non pode ver os detalles deste filtro porque está agochado da vista pública',
	'abusefilter-edit-main'                    => 'Parámetros do filtro',
	'abusefilter-edit-done-subtitle'           => 'Filtro editado',
	'abusefilter-edit-done'                    => 'Gardou con éxito os seus cambios no filtro.

[[Special:AbuseFilter|Voltar]]',
);

/** Hebrew (עברית)
 * @author StuB
 */
$messages['he'] = array(
	'abusefilter-log-search-user' => 'משתמש:',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'abusefilter-log-search-title'  => 'शीर्षक:',
	'abusefilter-log-search-submit' => 'खोज',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'abusefilter-log-noactions' => 'ništa',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'abusefilter-desc'                         => 'Nałožuje awtomatisku heuristiku na změny.',
	'abusefilter'                              => 'Konfiguracija filtra znjewužiwanja',
	'abuselog'                                 => 'protokol znjewužiwanjow',
	'abusefilter-blocker'                      => 'Filter znjewužiwanja',
	'abusefilter-blockreason'                  => 'Přez filter znjewužiwanja awtomatisce blokowany. Wopisanje prawidła: $1',
	'abusefilter-degroupreason'                => 'Prawa awtomatisce přez filter znjewužiwanja zebrane. Wopisanje prawidła: $1',
	'abusefilter-accountreserved'              => 'Tute kontowe mjeno je za wužiwanje přez filter znjewužiwanja wuměnjene.',
	'right-abusefilter-modify'                 => 'Filtry znjewužiwanja změnić',
	'right-abusefilter-view'                   => 'Filtry znjewužiwanja zwobraznić',
	'right-abusefilter-log'                    => 'Protokol znjewužiwanjow zwobraznić',
	'right-abusefilter-log-detail'             => 'Podrobne zapiski protokola znjewužiwanjow zwobraznić',
	'right-abusefilter-private'                => 'Priwatne daty w protokol znjewužiwanjow zwobraznić',
	'abusefilter-log'                          => 'Protokol filtrow znjewužiwanja',
	'abusefilter-log-search'                   => 'Protokol znjewužiwanjow přepytać',
	'abusefilter-log-search-user'              => 'Wužiwar:',
	'abusefilter-log-search-filter'            => 'ID filtra:',
	'abusefilter-log-search-title'             => 'Titul:',
	'abusefilter-log-search-submit'            => 'Pytać',
	'abusefilter-log-detailslink'              => 'podrobnosće',
	'abusefilter-log-details-legend'           => 'Podrobnosće za protokolowy zapisk $1',
	'abusefilter-log-details-var'              => 'Wariabla',
	'abusefilter-log-details-val'              => 'Hódnota',
	'abusefilter-log-details-vars'             => 'Akciske parametry',
	'abusefilter-log-details-private'          => 'Priwatne daty',
	'abusefilter-log-details-ip'               => 'Wuchadna adresa IP',
	'abusefilter-log-noactions'                => 'žadyn',
	'abusefilter-management'                   => 'Zrjadowanje filtrow znjewužiwanja',
	'abusefilter-list'                         => 'wšě filtry',
	'abusefilter-list-id'                      => 'ID filtra',
	'abusefilter-list-status'                  => 'Status',
	'abusefilter-list-public'                  => 'Zjawne wopisanje',
	'abusefilter-list-consequences'            => 'Konsekwency',
	'abusefilter-list-visibility'              => 'Widźomnosć',
	'abusefilter-list-edit'                    => 'Wobdźěłać',
	'abusefilter-list-details'                 => 'Podrobnosće',
	'abusefilter-hidden'                       => 'Priwatny',
	'abusefilter-unhidden'                     => 'Zjawny',
	'abusefilter-enabled'                      => 'Zmóžnjeny',
	'abusefilter-disabled'                     => 'Znjemóžnjeny',
	'abusefilter-list-new'                     => 'Nowy filter',
	'abusefilter-edit-subtitle'                => 'Filter $1 so wobdźěłuje',
	'abusefilter-edit-new'                     => 'Nowy filter',
	'abusefilter-edit-save'                    => 'Filter składować',
	'abusefilter-edit-id'                      => 'ID filtra:',
	'abusefilter-edit-description'             => "Wopisanje:
:''(zjawnje widźomne)''",
	'abusefilter-edit-flags'                   => 'Chorhojčka:',
	'abusefilter-edit-enabled'                 => 'Tutón filter zmóžnić',
	'abusefilter-edit-hidden'                  => 'Podrobnosće před zjawnym wobhldanjom schować',
	'abusefilter-edit-rules'                   => 'Sadźba prawidłow:',
	'abusefilter-edit-notes'                   => "Přispomnjenki:
:''(priwatne)",
	'abusefilter-edit-lastmod'                 => 'Filter posledni raz změnjeny:',
	'abusefilter-edit-lastuser'                => 'Posledni wužiwar, kotryž je tutón filter změnił:',
	'abusefilter-edit-action-warn'             => 'Tute akcije po warnowanje wužiwarjej zahibać',
	'abusefilter-edit-action-disallow'         => 'Akciju zakazać',
	'abusefilter-edit-action-blockautopromote' => 'Wužiwarjej awtomatisce wobkrućeny status zebrać',
	'abusefilter-edit-action-degroup'          => 'Wužiwarja z priwilegowanych skupinow wotstronić',
	'abusefilter-edit-action-block'            => 'Wobdźěłanjam wužiwarja zadźěwać',
	'abusefilter-edit-action-throttle'         => 'Akcije jenož zahibać, jeli wužiwar prohowu hódnotu překročuje',
	'abusefilter-edit-throttle-count'          => 'Ličba dowolenych akcijow',
	'abusefilter-edit-throttle-period'         => 'Časowy interwal',
	'abusefilter-edit-throttle-seconds'        => '$1 {{PLURAL:$1|sekunda|sekundźe|sekundy|sekundow}}',
	'abusefilter-edit-denied'                  => 'Njemóžeš sej podrobnosće tutoho filtra wobhladać, dokelž je před zjawnym wobhladanjom schowany.',
	'abusefilter-edit-main'                    => 'Filtrowe parametry',
	'abusefilter-edit-done-subtitle'           => 'Fitler wobdźěłany',
	'abusefilter-edit-done'                    => 'Sy swoje změny na filtrje wuspěšnje składował.

[[Special:AbuseFilter|Wróćo]]',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'abusefilter-desc'              => 'Applica heuristicas automatic al modificationes.',
	'abusefilter'                   => 'Configuration del filtro contra abuso',
	'abuselog'                      => 'Registro de abusos',
	'abusefilter-warning'           => "<big>'''Advertimento:'''</big> Iste action ha essite automaticamente identificate como damnose.
Tote modificationes non constructive essera rapidemente revertite,
e le repetition flagrante de modificationes non constructive resultara in le blocada de tu conto o computator.
Si tu crede que iste modification sia constructive, tu pote cliccar Submitter de novo pro confirmar lo.
Un breve description del regula de abuso correspondente a tu action es: $1",
	'abusefilter-disallowed'        => 'Iste action ha essite automaticamente identificate como damnose,
e per consequente es prohibite.
Si tu crede que tu modification esseva constructive, per favor contacta un administrator, e informa le/la de lo que tu tentava facer.
Un breve description del regula de abuso correspondente a tu action es: $1',
	'abusefilter-log-search-submit' => 'Cercar',
	'abusefilter-list-edit'         => 'Modificar',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'abusefilter-log-search-user'       => 'អ្នកប្រើប្រាស់:',
	'abusefilter-log-search-title'      => 'ចំនងជើង:',
	'abusefilter-log-search-submit'     => 'ស្វែងរក',
	'abusefilter-log-noactions'         => 'ទទេ',
	'abusefilter-list-edit'             => 'កែប្រែ',
	'abusefilter-edit-throttle-period'  => 'រយៈពេល:',
	'abusefilter-edit-throttle-seconds' => '$1វិនាទី',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'abusefilter-list-edit' => 'Ändere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'abusefilter'                           => 'Astellung vum Mëssbrauchsfilter',
	'abuselog'                              => 'Lëscht vum Mëssbrauch',
	'abusefilter-blocker'                   => 'Filter vum Mëssbrauch',
	'abusefilter-blockreason'               => 'Automtesch gespaart duerch de Mëssbrauchsfilter. Beschreiwung vun der Regel: $1',
	'abusefilter-degroupreason'             => 'Rechter goufen atomatesch duerch de Mëssbrauchsfilter ewechgeholl. Beschreiwung vun der Regel: $1',
	'abusefilter-accountreserved'           => 'Dëse Numm fir e Benotzerkont ass reservéiert fir vum Mëssbrauchs-filer benotzt ze ginn.',
	'right-abusefilter-modify'              => "D'filtere vum Mëssbrauch änneren",
	'right-abusefilter-view'                => 'Mëssbrauchs-Filtere weisen',
	'right-abusefilter-log'                 => 'Lëscht vum Mëssbrauch weisen',
	'abusefilter-log'                       => 'Lëscht vun de Mëssbrauchs-Filteren',
	'abusefilter-log-search'                => 'D?Lëscht vum Mëssbrauch duerchsichen',
	'abusefilter-log-search-user'           => 'Benotzer:',
	'abusefilter-log-search-filter'         => 'Nummer(ID) vum Filter:',
	'abusefilter-log-search-title'          => 'Titel:',
	'abusefilter-log-search-submit'         => 'Sichen',
	'abusefilter-log-detailslink'           => 'Detailer',
	'abusefilter-log-details-legend'        => "Detailer fir d'Rubrique am Logbuch $1",
	'abusefilter-log-details-var'           => 'Variabel',
	'abusefilter-log-details-val'           => 'Wert',
	'abusefilter-log-details-ip'            => 'IP-Adress déi bnotzt gouf',
	'abusefilter-log-noactions'             => 'keen',
	'abusefilter-management'                => 'Gestioun vum Mëssbrauchsfilter',
	'abusefilter-list'                      => 'All Filteren',
	'abusefilter-list-id'                   => 'Nummer(ID) vum Filter',
	'abusefilter-list-status'               => 'Statut',
	'abusefilter-list-public'               => 'Ëffentlech Beschreiwung',
	'abusefilter-list-consequences'         => 'Konsequenzen',
	'abusefilter-list-visibility'           => 'Visibilitéit',
	'abusefilter-list-edit'                 => 'Änneren',
	'abusefilter-list-details'              => 'Dteailer',
	'abusefilter-hidden'                    => 'Privat',
	'abusefilter-unhidden'                  => 'Ëffentlech',
	'abusefilter-enabled'                   => 'Aktivéiert',
	'abusefilter-disabled'                  => 'Desaktivéiert',
	'abusefilter-list-new'                  => 'Neie Filter',
	'abusefilter-tools-modifiertest-submit' => 'Test',
	'abusefilter-tools-modifier'            => 'Änneren:',
	'abusefilter-tools-result'              => 'Resultat:',
	'abusefilter-edit-subtitle'             => 'Änner vum Filter $1',
	'abusefilter-edit-status-label'         => 'Statistiken',
	'abusefilter-edit-new'                  => 'Neie Filter',
	'abusefilter-edit-save'                 => 'Filter späicheren',
	'abusefilter-edit-id'                   => 'Nummer (ID) vum Filter:',
	'abusefilter-edit-description'          => "Beschreiwung:
:''(ëffentlech)''",
	'abusefilter-edit-flags'                => 'Fändelen:',
	'abusefilter-edit-enabled'              => 'Dëse Filter aktivéieren',
	'abusefilter-edit-hidden'               => "Verstop d'Detailer vun dësem Filter virun der Ëffentlechkeet",
	'abusefilter-edit-notes'                => "Notizen:
:''(privat)''",
	'abusefilter-edit-lastmod'              => "De Filter gouf fir d'lescht geännert",
	'abusefilter-edit-lastuser'             => 'Leschte Benotzer deen dëse Filter geännert huet:',
	'abusefilter-edit-action-disallow'      => 'Dës Aktioun net erlaben',
	'abusefilter-edit-action-flag'          => "D'Ännerung am Mëssbrauchslog markéieren",
	'abusefilter-edit-action-degroup'       => 'Dem Benotzer all priviligéiert Gruppen ewechhuelen',
	'abusefilter-edit-action-block'         => 'De Benotzer fir Ännerunge spären',
	'abusefilter-edit-throttle-period'      => 'Zäitraum:',
	'abusefilter-edit-throttle-seconds'     => '$1 Sekonnen',
	'abusefilter-edit-denied'               => 'Dir kënnt Detailer vun dësem Filter net gesinn, well se virum Public verstoppr sinn',
	'abusefilter-edit-main'                 => 'Parametere vum Filter',
	'abusefilter-edit-done-subtitle'        => 'Filter geännert',
	'abusefilter-edit-done'                 => 'Dir hutt är Ännerunge vum Filter ofgespäichert.

[[Special:AbuseFilter|Zréck]]',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'abusefilter-log-search-user'   => 'Naudotojas:',
	'abusefilter-log-search-submit' => 'Ieškoti',
);

/** Maltese (Malti)
 * @author Giangian15
 */
$messages['mt'] = array(
	'abusefilter-log-search-user'   => 'Utent:',
	'abusefilter-log-search-filter' => 'ID tal-Filtru:',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'abusefilter-log-search-user'      => 'Tlatēquitiltilīlli:',
	'abusefilter-log-search-title'     => 'Tōcāitl:',
	'abusefilter-log-search-submit'    => 'Tlatēmoāz',
	'abusefilter-list-edit'            => 'Ticpatlāz',
	'abusefilter-edit-throttle-period' => 'Cāhuitl:',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'abusefilter-desc'                         => 'Voert automatisch heuristische analyse uit op bewerkingen',
	'abusefilter'                              => 'Misbruikfilterconfiguratie',
	'abuselog'                                 => 'Misbruiklogboek',
	'abusefilter-warning'                      => "<big>'''Waarschuwing'''</big>: Deze handeling is automatisch geïdentificeerd als schadelijk.
Onconstructieve bewerkingen worden snel teruggedraaid, en herhaald onconstructief bewerken eindigt in een blokkade van uw gebruiker.
Als u denkt dat deze bewerking wel constructief is, klik dan opnieuw op \"Pagina opslaan\" om de bewerking te bevestigen.
Een korte beschrijving van de regel op basis waarvan uw bewerking is tegengehouden volgt nu: \$1",
	'abusefilter-disallowed'                   => 'Deze handeling is automatisch geïdentificeerd als schadelijk, en daarom niet toegelaten.
Als u denkt dat uw bewerking wel constructief was, neem dan contact op met een beheerder, en informeer hemwat u probeerde te doen.
Een korte beschrijving van de regel op basis waarvan uw bewerking is tegengehouden volgt nu: $1',
	'abusefilter-blocked-display'              => 'Deze handeling is automatisch geïdentificeerd als schadelijk. Daarom is deze niet uitgevoerd.
Om {{SITENAME}} te beschermen zijn uw gebruiker en alle bijbehorende IP-adressen geblokkeerd.
Als deze maatregel onterecht is genomen, neem dan contact op met een beheerder.
Een korte beschrijving van de regel op basis waarvan uw bewerking is tegengehouden volgt nu: $1',
	'abusefilter-degrouped'                    => 'Deze handeling is automatisch geïdentificeerd als schadelijk.
Omdat is vastgesteld dat deze gebruiker mogelijk door iemand anders wordt misbruikt, zijn alle rechten ingetrokken.
Als deze maatregel onterecht is genomen, neem dan contact op met een bureaucraat en licht deze handeling toe, zodat uw rechten hersteld kunnen worden.
Een korte beschrijving van de regel op basis waarvan uw bewerking is tegengehouden volgt nu: $1',
	'abusefilter-autopromote-blocked'          => 'Deze handeling is automatisch geïdentificeerd als schadelijk. Daarom is deze niet uitgevoerd.
Als aanvullende veiligheidsmaatregel zijn een aantal automatisch toegekende rechten voor uw gebruiker tijdelijk ingetrokken.
Een korte beschrijving van de regel op basis waarvan uw bewerking is tegengehouden volgt nu: $1',
	'abusefilter-blocker'                      => 'Misbruikfilter',
	'abusefilter-blockreason'                  => 'Automatisch geblokeerd door misbruikfilter. Regelbeschrijving: $1',
	'abusefilter-degroupreason'                => 'Rechten zijn automatisch verwijderd door het misbruikfilter. Regelbeschrijving: $1',
	'abusefilter-accountreserved'              => 'Deze gebruiker is gereserveerd voor de misbruikfilter.',
	'right-abusefilter-modify'                 => 'Misbruikfilters wijzigen',
	'right-abusefilter-view'                   => 'Misbruikfilters bekijken',
	'right-abusefilter-log'                    => 'Het misbruiklogboek bekijken',
	'right-abusefilter-log-detail'             => 'Gedetailleerde items in het misbruiklogboek bekijken',
	'right-abusefilter-private'                => 'Private gegevens in het misbruiklogboek bekijken',
	'abusefilter-log'                          => 'Misbruiklogboek',
	'abusefilter-log-search'                   => 'Het misbruiklogboek doorzoeken',
	'abusefilter-log-search-user'              => 'Gebruiker:',
	'abusefilter-log-search-filter'            => 'Filternummer:',
	'abusefilter-log-search-title'             => 'Titel:',
	'abusefilter-log-search-submit'            => 'Zoeken',
	'abusefilter-log-entry'                    => '$1: $2 deed een misbruikfilter afgaan bij het doen van een $3 op $4. Genomen actie: $5. Filterbeschrijving: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 liet misbruikfilter $3 afgaan bij het uitvoeren van een $4 op $5. Genomen acties: $6. Filterbeschrijving: $7 ($8)',
	'abusefilter-log-detailslink'              => 'details',
	'abusefilter-log-details-legend'           => 'Details voor logboekitem $1',
	'abusefilter-log-details-var'              => 'Variabele',
	'abusefilter-log-details-val'              => 'Waarde',
	'abusefilter-log-details-vars'             => 'Handelingsparameters',
	'abusefilter-log-details-private'          => 'Private gegevens',
	'abusefilter-log-details-ip'               => 'IP-adres bron',
	'abusefilter-log-noactions'                => 'geen',
	'abusefilter-management'                   => 'Beheer van misbruikfilter',
	'abusefilter-list'                         => 'Alle filters',
	'abusefilter-list-id'                      => 'Filternummer',
	'abusefilter-list-status'                  => 'Status',
	'abusefilter-list-public'                  => 'Publieke beschrijving',
	'abusefilter-list-consequences'            => 'Gevolgen',
	'abusefilter-list-visibility'              => 'Zichtbaarheid',
	'abusefilter-list-hitcount'                => 'Hitcount',
	'abusefilter-list-edit'                    => 'Bewerken',
	'abusefilter-list-details'                 => 'Details',
	'abusefilter-hidden'                       => 'Privaat',
	'abusefilter-unhidden'                     => 'Publiek',
	'abusefilter-enabled'                      => 'Ingeschakeld',
	'abusefilter-disabled'                     => 'Uitgeschakeld',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|hit|hits}}',
	'abusefilter-list-new'                     => 'Nieuwe filter',
	'abusefilter-tools-modifiertest-submit'    => 'Testen',
	'abusefilter-tools'                        => 'Er zijn een aantal [[Special:AbuseFilter/tools|hulpmiddelen]] beschikbaar voor het maken en testen van misbruikfilters.',
	'abusefilter-tools-modifiertest'           => 'Testmodifiers',
	'abusefilter-tools-modifier'               => 'Modifier:',
	'abusefilter-tools-value'                  => 'Te testen waarde:',
	'abusefilter-tools-result'                 => 'Resultaat:',
	'abusefilter-status'                       => 'Van de laatste $1 acties, hebben er $2 ($3%) de conditielimiet van $4 gehaald. $5 ($6%) voldeden aan een van de actieve filters.',
	'abusefilter-edit-subtitle'                => 'Bezig met het bewerken van filter $1',
	'abusefilter-edit-status-label'            => 'Statistieken',
	'abusefilter-edit-status'                  => 'Van de laatste $1 acties voldeden er $2 aan deze filter ($3%).',
	'abusefilter-edit-throttled'               => "'''Waarschuwing''': deze filter is als veiligheidsmaatregel automatisch uitgeschakeld. De limiet van voldoen aan meer dan $1% van de handelingen is bereikt.",
	'abusefilter-edit-new'                     => 'Nieuwe filter',
	'abusefilter-edit-save'                    => 'Filter opslaan',
	'abusefilter-edit-id'                      => 'Filternummer:',
	'abusefilter-edit-description'             => "Beschrijving:
:''(publiekelijk zichtbaar)''",
	'abusefilter-edit-flags'                   => 'Vlaggen:',
	'abusefilter-edit-enabled'                 => 'Deze filter inschakelen',
	'abusefilter-edit-hidden'                  => 'Details van deze filter verbergen voor het publiek',
	'abusefilter-edit-rules'                   => 'Regelset:',
	'abusefilter-edit-notes'                   => "Opmerkingen:
:''(privaat)''",
	'abusefilter-edit-lastmod'                 => 'Filter laatst aangepast:',
	'abusefilter-edit-lastuser'                => 'Gebruiker die deze filter het laatste heeft bewerkt:',
	'abusefilter-edit-hitcount'                => 'Hits filteren:',
	'abusefilter-edit-consequences'            => 'Genomen actie bij hit',
	'abusefilter-edit-action-warn'             => 'Voer deze acties uit nadat een gebruiker een waarschuwing heeft gekregen',
	'abusefilter-edit-action-disallow'         => 'De handeling niet toelaten',
	'abusefilter-edit-action-flag'             => 'De bewerking in het misbruiklogboek markeren',
	'abusefilter-edit-action-blockautopromote' => 'De bevestigde status van deze gebruiker verwijderen',
	'abusefilter-edit-action-degroup'          => 'Alle gebruikersgroepen van deze gebruiker verwijderen',
	'abusefilter-edit-action-block'            => 'De gebruiker blokkeren',
	'abusefilter-edit-action-throttle'         => 'Acties alleen uitvoeren als de gebruiker een drempelwaarde overschreidt',
	'abusefilter-edit-throttle-count'          => 'Aantal handelingen om toe te laten:',
	'abusefilter-edit-throttle-period'         => 'Tijdsduur:',
	'abusefilter-edit-throttle-seconds'        => '$1 seconden',
	'abusefilter-edit-throttle-groups'         => "Groepsbeperkingen per tijdseenheid op basis van:
:''(één per regel, combineren met komma's)''",
	'abusefilter-edit-denied'                  => 'U mag de details van deze filter niet bekijken, omdat het verborgen is voor het publiek',
	'abusefilter-edit-main'                    => 'Filterparameters',
	'abusefilter-edit-done-subtitle'           => 'Filter bewerkt',
	'abusefilter-edit-done'                    => 'U hebt uw wijzigingen aan de filter successvol opgeslagen.

[[Special:AbuseFilter|Terugkeren]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'abusefilter-desc'                         => 'Legger automatisk til heuristikk til redigeringer.',
	'abusefilter'                              => 'Konfigurasjon av misbruksfilter',
	'abuselog'                                 => 'Misbrukslogg',
	'abusefilter-warning'                      => "<big>'''Advarsel:'''</big> Handlingen har automatisk blitt identifisert som skadelig.
Ikke-konstruktive redigeringer blir raskt tilbakestilt, og langvarig forstyrrende redigering vil føre til at din konto eller datamaskin blir blokkert. Om du mener dette er en konstruktiv redigering, klikk «Lagre» igjen for å bekrefte.
En kortfattet beskrivelse av misbruksregelen som din handling utløste er: $1",
	'abusefilter-disallowed'                   => 'Denne handlingen har automatisk blitt identifisert som skadelig, og tillates ikke. Om du mener redigeringen var konstruktiv, kontakt en administrator og informer ham eller henne om hva du prøvde å få til.
En kortfattet beskrivelse av misbruksregelen som din handling utløste er: $1',
	'abusefilter-blocked-display'              => 'Denne handlingen har automatisk blitt identifisert som skadelig, og du har blitt hindret fra å gjennomføre den. I tillegg har kontoen din og alle IP-adresser assosiert med denne blitt blokkert fra å redigere {{SITENAME}}. Om dette var en feil, kontakt en administrator.
En kortfattet beskrivelse av misbruksregelen som din handling utløste er: $1',
	'abusefilter-degrouped'                    => 'Denne handlingen har automatisk blitt identifisert som skadelig. Derfor ble den ikke tillatt, og på grunn av mistanke om misbruk har kontoen din mistet alle rettigheter. Om du mener dette er en feil, kontakt en byråkrat med en forklaring på hva du gjorde, og rettighetene dine kan bli gjenopprettet.
En kortfattet beskrivelse av misbruksregelen som din handling utløste er: $1',
	'abusefilter-autopromote-blocked'          => 'Denne handlingen har automatisk blitt identifisert som skadelig, og ble ikke tillatt.
I tillegg ble noen av rettighetene kontoen din hadde fjernet midlertidig, av sikkerhetsmessige grunner.
En kort beskrivelse av misbruksregelen handlingen din brøt er: $1',
	'abusefilter-blocker'                      => 'Misbruksfilter',
	'abusefilter-blockreason'                  => 'Automatisk blokkert for å utføre skadelige redigeringer. Regelbeskrivelse: $1',
	'abusefilter-degroupreason'                => 'Rettigheter fjernet automatisk av misbruksfilter. Regelbeskrivelse: $1',
	'abusefilter-accountreserved'              => 'Denne kontoen er reservert for bruk av misbruksfilteret.',
	'right-abusefilter-modify'                 => 'Endre misbruksfiltere',
	'right-abusefilter-view'                   => 'Vise misbruksfiltere',
	'right-abusefilter-log'                    => 'Vise misbruksloggen',
	'right-abusefilter-log-detail'             => 'Vise detaljerte punkter i misbruksloggen',
	'right-abusefilter-private'                => 'Vise privat informasjon i misbruksloggen',
	'abusefilter-log'                          => 'Logg for misbruksfilter',
	'abusefilter-log-search'                   => 'Søk i misbruksloggen',
	'abusefilter-log-search-user'              => 'Bruker:',
	'abusefilter-log-search-filter'            => 'Filter-ID:',
	'abusefilter-log-search-title'             => 'Tittel:',
	'abusefilter-log-search-submit'            => 'Søk',
	'abusefilter-log-entry'                    => '$1: $2 utløste misbruksfilteret ved å gjøre en $3 på $4. Reaksjon: $5; filterbeskrivelse: $6',
	'abusefilter-log-detailedentry'            => '$1: $1: $2 utløste misbruksfilter $3, ved å gjøre en $4 på $5. Reaksjon: $6; filterbeskrivelse: $7 ($8)',
	'abusefilter-log-detailslink'              => 'detaljer',
	'abusefilter-log-details-legend'           => 'Detaljer for loggelement $1',
	'abusefilter-log-details-var'              => 'Variabel',
	'abusefilter-log-details-val'              => 'Verdi',
	'abusefilter-log-details-vars'             => 'Handlingsparametere',
	'abusefilter-log-details-private'          => 'Privat informasjon',
	'abusefilter-log-details-ip'               => 'Opphavs-IP',
	'abusefilter-log-noactions'                => 'ingen',
	'abusefilter-management'                   => 'Behandling av misbruksfilter',
	'abusefilter-list'                         => 'Alle filtere',
	'abusefilter-list-id'                      => 'Filter-ID',
	'abusefilter-list-status'                  => 'Status',
	'abusefilter-list-public'                  => 'Offentlig beskrivelse',
	'abusefilter-list-consequences'            => 'Konsekvenser',
	'abusefilter-list-visibility'              => 'Synlighet',
	'abusefilter-list-hitcount'                => 'Treffteller',
	'abusefilter-list-edit'                    => 'Rediger',
	'abusefilter-list-details'                 => 'Detaljer',
	'abusefilter-hidden'                       => 'Privat',
	'abusefilter-unhidden'                     => 'Offentlig',
	'abusefilter-enabled'                      => 'Slått på',
	'abusefilter-disabled'                     => 'Slått av',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|treff|treff}}',
	'abusefilter-list-new'                     => 'Nytt filter',
	'abusefilter-tools-modifiertest-submit'    => 'Test',
	'abusefilter-tools'                        => 'Noen [[Special:AbuseFilter/tools|verktøy]] er tilgjengelig til hjelp med formulering og feilsøking i forbindelse med misbruksfiltere.',
	'abusefilter-tools-modifiertest'           => 'Testalternativer',
	'abusefilter-tools-modifier'               => 'Parameter:',
	'abusefilter-tools-value'                  => 'Verdi å teste:',
	'abusefilter-tools-result'                 => 'Resultat:',
	'abusefilter-status'                       => 'Av de siste $1 handlingene har $2 ($3&nbsp;%) nådd grenseverdien $4. $5 ($6&nbsp;%) har passet med en av de påslåtte filterne.',
	'abusefilter-edit-subtitle'                => 'Redigerer filteret $1',
	'abusefilter-edit-status-label'            => 'Statistikk',
	'abusefilter-edit-status'                  => 'Av de siste $1 handlinger har dette filteret passet med $2 ($3&nbsp;%).',
	'abusefilter-edit-throttled'               => "'''Advarsel:''' Dette filteret ble automatisk slått av av sikkerhetsårsaker. Det nådde grensen på $1&nbsp;% av alle handlinger.",
	'abusefilter-edit-new'                     => 'Nytt filter',
	'abusefilter-edit-save'                    => 'Lagre filter',
	'abusefilter-edit-id'                      => 'Filter-ID:',
	'abusefilter-edit-description'             => ":''(vises offentlig)''",
	'abusefilter-edit-flags'                   => 'Flagg:',
	'abusefilter-edit-enabled'                 => 'Slå på dette filteret',
	'abusefilter-edit-hidden'                  => 'Skjul detaljer om dette filteret',
	'abusefilter-edit-rules'                   => 'Regelsett:',
	'abusefilter-edit-notes'                   => ":''(privat)''",
	'abusefilter-edit-lastmod'                 => 'Filter sist endret:',
	'abusefilter-edit-lastuser'                => 'Siste bruker som endret dette filteret:',
	'abusefilter-edit-hitcount'                => 'Filtertreff:',
	'abusefilter-edit-consequences'            => 'Handlinger som skal tas ved treff',
	'abusefilter-edit-action-warn'             => 'Gi brukeren en advarsel før disse handlingene foretas',
	'abusefilter-edit-action-disallow'         => 'Gjør handling forbudt',
	'abusefilter-edit-action-flag'             => 'Flagg redigeringen i misbruksloggen',
	'abusefilter-edit-action-blockautopromote' => 'Fjern brukeres «autoconfirmed»-status',
	'abusefilter-edit-action-degroup'          => 'Fjern alle rettigheter brukeren har',
	'abusefilter-edit-action-block'            => 'Blokker brukeren',
	'abusefilter-edit-action-throttle'         => 'Gjennomfør dette kun dersom brukeren gjør det flere ganger',
	'abusefilter-edit-throttle-count'          => 'Antall tillatte handlinger:',
	'abusefilter-edit-throttle-period'         => 'Tidsperiode:',
	'abusefilter-edit-throttle-seconds'        => '{{PLURAL:$1|ett sekund|$1 sekunder}}',
	'abusefilter-edit-throttle-groups'         => "Grupper fart etter:
:''(en på hver linje, kombiner med kommaer)''",
	'abusefilter-edit-denied'                  => 'Du kan ikke se detaljene i dette filteret, fordi de er skjult fra offentligheten',
	'abusefilter-edit-main'                    => 'Filterparametere',
	'abusefilter-edit-done-subtitle'           => 'Filter redigert',
	'abusefilter-edit-done'                    => 'Du har lagret endringene dine i filteret.

[[Special:AbuseFilter|Tilbake]]',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'abusefilter-desc'                         => "Aplica d'euristicas automaticas a las modificacions",
	'abusefilter'                              => 'Configuracion del filtre dels abuses',
	'abuselog'                                 => 'Jornal dels abuses',
	'abusefilter-warning'                      => "<big>'''Avertiment'''</big> : Aquesta accion es estada identificada automaticament coma nusibla.
Las edicions que son pas constructivas seràn rapidament anullada,
e la repeticion de las asinadas del meteis genre provocarà lo blocatge de vòstre compte.
Se sètz convençut(uda) que vòstra modificacion es constructiva, la podètz la sometre un còp de mai per la validar.
Vaquí la descripcion brèva de la règla de l’abús qu'a detectat vòstra accion : $1",
	'abusefilter-disallowed'                   => 'Aquesta modificacion es estada automaticament idenficada coma nusibla e, per via de consequéncia, pas permesa.
Se sètz convençut(uda) que vòstra modificacion èra constructiva, contactatz un administrator, e informatz-lo de quina accion eratz a far : $1',
	'abusefilter-blocked-display'              => "Aquesta accion es estada identifcada coma nusibla automaticament, e ja sètz estat(ada) empachat(ada) de l’executar.
En consequéncia, per protegir {{SITENAME}}, vòstre compte d'utilizaire e totas las adreças IP son estadas blocadas en escritura.
S'aquò es degut a una error, contactatz un administrator.
Vaquí la descripcion brèva de la règla de l’abús qu'a detectat vòstra accion : $1",
	'abusefilter-degrouped'                    => "Aquesta accion es estada identificada coma nusibla automaticament.
En consequéncia, es pas estada permesa, tre alara, vòstre compte es suspectat de compromission, totes vòstres dreches son estats levats.
Se sètz convençut(uda) qu'aquò es degut a una error, contactatz un burocrata amb una explicacion d'aquesta accion, e totes vòstres dreches poiràn èsser restablits.
Vaquí la descripcion brèva de la règla de l’abús qu'a detectat vòstra accion : $1",
	'abusefilter-autopromote-blocked'          => 'Aquesta accion es estada automaticament identificada coma nusibla, e es pas estada permesa. En consequéncia, a títol de mesura de seguretat, qualques privilègis acordats de costum pels comptes establits son estats revocats temporàriament de vòstre compte.',
	'abusefilter-blocker'                      => 'Filtre dels abuses',
	'abusefilter-blockreason'                  => 'Blocat automaticament per aver temptat de far de modificacions identificadas coma nusiblas.
Descripcion de la règla : $1',
	'abusefilter-degroupreason'                => 'Dreches levats automaticament pel filtre dels abuses. Descripcion de la règla : $1',
	'abusefilter-accountreserved'              => "Lo nom d'aqueste compte es reservat per l’usatge pel filtre dels abuses.",
	'right-abusefilter-modify'                 => 'Modificar los filtres dels abuses',
	'right-abusefilter-view'                   => 'Veire los filtres dels abuses',
	'right-abusefilter-log'                    => 'Veire lo jornal dels abuses',
	'right-abusefilter-log-detail'             => 'Veire las entradas del jornal detalhat dels abuses',
	'right-abusefilter-private'                => 'Veire las donadas privadas dins lo jornal dels abuses',
	'abusefilter-log'                          => 'Jornal del filtre dels abuses',
	'abusefilter-log-search'                   => 'Recercar lo jornal dels abuses',
	'abusefilter-log-search-user'              => 'Utilizaire :',
	'abusefilter-log-search-filter'            => 'Filtre ID :',
	'abusefilter-log-search-title'             => 'Títol :',
	'abusefilter-log-search-submit'            => 'Recercar',
	'abusefilter-log-entry'                    => '$1 : $2 a desenclavat un filtre dels abuses, que fa un $3 sus $4. Accions presas : $5 ; Descripcion del filtre : $6',
	'abusefilter-log-detailedentry'            => '$1 : $2 a desenclavat lo filtre $3 dels abuses, que fa un $4 sus $5. Accions presas : $6 ; Descripcion del filtre : $7 ($8)',
	'abusefilter-log-detailslink'              => 'detalhs',
	'abusefilter-log-details-legend'           => "Detalhs per l'entrada $1 del jornal",
	'abusefilter-log-details-var'              => 'Variabla',
	'abusefilter-log-details-val'              => 'Valor',
	'abusefilter-log-details-vars'             => 'Paramètres de l’accion',
	'abusefilter-log-details-private'          => 'Donada privada',
	'abusefilter-log-details-ip'               => 'Provenéncia de l’adreça IP',
	'abusefilter-log-noactions'                => 'pas cap',
	'abusefilter-management'                   => 'Gestion del filtre dels abuses',
	'abusefilter-list'                         => 'Totes los filtres',
	'abusefilter-list-id'                      => 'Filtre ID',
	'abusefilter-list-status'                  => 'Estatut',
	'abusefilter-list-public'                  => 'Descripcion publica',
	'abusefilter-list-consequences'            => 'Consequéncias',
	'abusefilter-list-visibility'              => 'Visibilitat',
	'abusefilter-list-hitcount'                => 'Aviar lo comptador',
	'abusefilter-list-edit'                    => 'Modificar',
	'abusefilter-list-details'                 => 'Detalhs',
	'abusefilter-hidden'                       => 'Privat',
	'abusefilter-unhidden'                     => 'Public',
	'abusefilter-enabled'                      => 'Activat',
	'abusefilter-disabled'                     => 'Desactivat',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|visita|visitas}}',
	'abusefilter-list-new'                     => 'Filtre novèl',
	'abusefilter-edit-subtitle'                => 'Modificacion del filtre $1',
	'abusefilter-edit-new'                     => 'Filtre novèl',
	'abusefilter-edit-save'                    => 'Salvar lo filtre',
	'abusefilter-edit-id'                      => 'Filtre ID :',
	'abusefilter-edit-description'             => "Descripcion :
:''(Visibla publicament)''",
	'abusefilter-edit-flags'                   => 'Drapèus :',
	'abusefilter-edit-enabled'                 => 'Activar aqueste filtre',
	'abusefilter-edit-hidden'                  => "Amagar los detalhs d'aqueste filtre a la vista publica",
	'abusefilter-edit-rules'                   => 'Paramètre de la règla :',
	'abusefilter-edit-notes'                   => "Nòtas :
:''(privat)''",
	'abusefilter-edit-lastmod'                 => 'Filtre modificat en darrièr :',
	'abusefilter-edit-lastuser'                => "Darrièr utilizaire qu'a modificat aqueste filtre :",
	'abusefilter-edit-hitcount'                => 'Visitas del filtre :',
	'abusefilter-edit-consequences'            => 'Accions entrepresas al moment de la visita',
	'abusefilter-edit-action-warn'             => 'Desenclavar aquestas accions aprèp aver balhat un avertiment a l’utilizaire',
	'abusefilter-edit-action-disallow'         => 'Permetre pas l’accion',
	'abusefilter-edit-action-flag'             => 'Marcar la modificacion dins lo jornal dels abuses',
	'abusefilter-edit-action-blockautopromote' => "Revocar l'estatut de compte automaticament confirmat de l’utilizaire",
	'abusefilter-edit-action-degroup'          => 'Levar a l’utilizaire totes los gropes privilegiats',
	'abusefilter-edit-action-block'            => 'Blocar l’utilizaire en escritura',
	'abusefilter-edit-action-throttle'         => 'Desenclavar las accions unicament se l’utilizaire a depassat los limits',
	'abusefilter-edit-throttle-count'          => "Nombre d’accions d'autorizar :",
	'abusefilter-edit-throttle-period'         => 'Periòde de temps :',
	'abusefilter-edit-throttle-seconds'        => '$1 segondas',
	'abusefilter-edit-throttle-groups'         => "Grop detengut per :
:''(un per linha, separat per de virgulas)''",
	'abusefilter-edit-denied'                  => "Podètz pas veire los detalhs d'aqueste filtre perque es amagat a la vista del public",
	'abusefilter-edit-main'                    => 'Paramètres del filtre',
	'abusefilter-edit-done-subtitle'           => 'Filtre modificat',
	'abusefilter-edit-done'                    => 'Avètz salvadas vòstras modificacions amb succès dins lo filtre.

[[Special:AbuseFilter|Retorn]]',
);

/** Polish (Polski)
 * @author Airwolf
 * @author Sp5uhe
 * @author Maikking
 */
$messages['pl'] = array(
	'abusefilter-log-search-user'       => 'Użytkownik',
	'abusefilter-log-search-title'      => 'Tytuł:',
	'abusefilter-log-search-submit'     => 'Szukaj',
	'abusefilter-log-detailslink'       => 'szczegóły',
	'abusefilter-log-details-legend'    => 'Szczegóły: $1',
	'abusefilter-list-edit'             => 'Edytuj',
	'abusefilter-list-details'          => 'Szczegóły',
	'abusefilter-tools-result'          => 'Wynik:',
	'abusefilter-edit-status-label'     => 'Statystyki',
	'abusefilter-edit-flags'            => 'Flagi:',
	'abusefilter-edit-action-block'     => 'Zablokuj użytkownikowi możliwość edycji',
	'abusefilter-edit-throttle-seconds' => '$1 sekund',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'abusefilter-warning'           => "<big>'''ګواښنه'''</big>: همدا کړنه په اتوماتيک ډول زيانمنه وپېژندل شوه.
نارغوونکې سمونې به ډېر ژر پر شا خپلې پخوانۍ بڼې ته واوړي، ورانکاري او په بيا بيا د نارغوونکې سمونې په ترسره کولو سره به ستاسو په کارن-حساب او يا هم کمپيوټر باندې بنديزونه ولګېږي.
که چېرته تاسو په دې ډاډه ياست چې همدا يوه رغوونکې سمونه ده، نو تاسو کولای شی چې پر «سپارل» وټوکۍ ترڅو ستاسو د کړنې پخلی وشي.
د ناوړو کړنو د کړنلارې يوه لنډه څرګندونه چې ستاسو د کړنې همډوله وه، په دې توګه ده: $1",
	'abusefilter-log-search-user'   => 'کارونکی:',
	'abusefilter-log-search-title'  => 'سرليک:',
	'abusefilter-log-search-submit' => 'پلټل',
	'abusefilter-list'              => 'ټول چاڼګران',
	'abusefilter-tools-result'      => 'پايلې؛',
	'abusefilter-edit-flags'        => 'بېرغونه:',
	'abusefilter-edit-notes'        => "يادونې:
:''(شخصي)",
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'abusefilter-log-search-submit' => 'Tarzzut',
	'abusefilter-list-edit'         => 'Arri',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'abusefilter-desc'                      => 'Aplică euristică automată modificărilor.',
	'abusefilter-log-search-user'           => 'Utilizator:',
	'abusefilter-log-search-filter'         => 'ID filtru:',
	'abusefilter-log-search-title'          => 'Titlu:',
	'abusefilter-log-search-submit'         => 'Caută',
	'abusefilter-log-detailslink'           => 'detalii',
	'abusefilter-log-details-var'           => 'Variabilă',
	'abusefilter-log-details-val'           => 'Valoare',
	'abusefilter-log-details-vars'          => 'Parametrii acţiunii',
	'abusefilter-log-details-private'       => 'Date private',
	'abusefilter-log-details-ip'            => 'Adresa IP de origine',
	'abusefilter-list'                      => 'Toate filtrele',
	'abusefilter-list-id'                   => 'ID filtru',
	'abusefilter-list-status'               => 'Statut',
	'abusefilter-list-public'               => 'Descriere publică',
	'abusefilter-list-consequences'         => 'Consecinţe',
	'abusefilter-list-visibility'           => 'Vizibilitate',
	'abusefilter-list-edit'                 => 'Modifică',
	'abusefilter-list-details'              => 'Detalii',
	'abusefilter-hidden'                    => 'Privat',
	'abusefilter-unhidden'                  => 'Public',
	'abusefilter-enabled'                   => 'Activat',
	'abusefilter-disabled'                  => 'Dezactivat',
	'abusefilter-list-new'                  => 'Filtru nou',
	'abusefilter-tools-modifiertest-submit' => 'Test',
	'abusefilter-tools-result'              => 'Rezultat:',
	'abusefilter-edit-subtitle'             => 'Modificare filtru $1',
	'abusefilter-edit-status-label'         => 'Statistici',
	'abusefilter-edit-new'                  => 'Filtru nou',
	'abusefilter-edit-save'                 => 'Salvează filtru',
	'abusefilter-edit-description'          => "Descriere:
:''(publică)''",
	'abusefilter-edit-enabled'              => 'Activează acest filtru',
	'abusefilter-edit-lastuser'             => 'Ultimul utilizator care a modificat acest filtru:',
	'abusefilter-edit-action-disallow'      => 'Nu permite acţiunea',
	'abusefilter-edit-action-block'         => 'Blochează utilizatorul la modificare',
	'abusefilter-edit-throttle-count'       => 'Număr de acţiuni permise:',
	'abusefilter-edit-throttle-period'      => 'Perioadă de timp:',
	'abusefilter-edit-throttle-seconds'     => '$1 secunde',
	'abusefilter-edit-main'                 => 'Parametrii filtrului',
	'abusefilter-edit-done-subtitle'        => 'Filtru modificat',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Ahonc
 * @author MaxSem
 */
$messages['ru'] = array(
	'abusefilter-desc'                         => 'Применяет к правкам автоматические эвристики.',
	'abusefilter'                              => 'Настройка фильтра злоупотреблений',
	'abuselog'                                 => 'Журнал злоупотреблений',
	'abusefilter-warning'                      => "<big>'''Внимание'''</big>. Данное действие было автоматически определено как вредоносное.
Неконструктивные правки будут быстро отменены,
грубые или неоднократные неконструктивную правки приведут к блокировке вашей учётной записи или компьютера.
Если вы уверены, что это конструктивная правка, вы можете нажать «Отправить» ещё раз, подтвердив тем самым правку.
Краткое описание злоупотребления, с которым определено соответствие вашего действия: $1",
	'abusefilter-disallowed'                   => 'Данное действие было автоматически определено как вредоносное,
и потому запрещено.
Если вы уверены, что это конструктивная правка, пожалуйста, обратитесь к администратору и расскажите, что вы собирались сделать.
Краткое описание злоупотребления, с которым определено соответствие вашего действия: $1',
	'abusefilter-blocked-display'              => 'Данное действие было автоматически определено как вредоносное,
вам было запрещено его выполнение.
Кроме того, в целях защиты проекта {{SITENAME}}, ваша учётная запись и связанные с ней IP-адреса были заблокированы.
Если вы видите в этом ошибку, пожалуйста, свяжитесь с администратором.
Краткое описание злоупотребления, с которым определено соответствие вашего действия: $1',
	'abusefilter-degrouped'                    => 'Данное действие было автоматически определено как вредоносное.
Таким образом, действие не было выполнено, ваша учётная запись считается скомпрометированный, с неё сняты все права.
Если вы считаете, что это ошибка, пожалуйста, свяжитесь с бюрократом и объясните ему ваши действия, тогда ваши права будут восстановлены.
Краткое описание злоупотребления, с которым определено соответствие вашего действия: $1',
	'abusefilter-autopromote-blocked'          => 'Данное действие было автоматически определено как вредоносное, и потому запрещено.
Кроме того, в целях безопасности, с вашей учётной записи сняты некоторые привилегии, обычно предоставляемые зарегистрированным учётным записям.
Краткое описание злоупотребления, с которым определено соответствие вашего действия: $1',
	'abusefilter-blocker'                      => 'Фильтр злоупотреблений',
	'abusefilter-blockreason'                  => 'Автоматически заблокирован фильтром злоупотреблений. Описание правила: $1',
	'abusefilter-degroupreason'                => 'Фильтр злоупотреблений автоматически отобрал права. Описание правила: $1',
	'abusefilter-accountreserved'              => 'Эта учётная запись зарезервирована для использования фильтром злоупотреблений.',
	'right-abusefilter-modify'                 => 'Изменить фильтры злоупотреблений',
	'right-abusefilter-view'                   => 'Просмотреть фильтры злоупотреблений',
	'right-abusefilter-log'                    => 'Просмотреть журнал злоупотреблений',
	'right-abusefilter-log-detail'             => 'Просмотреть подробнее записи журнала злоупотреблений',
	'right-abusefilter-private'                => 'Просмотреть приватные данные в журнале злоупотреблений',
	'abusefilter-log'                          => 'Журнал фильтра злоупотреблений',
	'abusefilter-log-search'                   => 'Поиск в журнале злоупотреблений',
	'abusefilter-log-search-user'              => 'Участник:',
	'abusefilter-log-search-filter'            => 'ИД фильтра:',
	'abusefilter-log-search-title'             => 'Заголовок:',
	'abusefilter-log-search-submit'            => 'Найти',
	'abusefilter-log-entry'                    => '$1: $2 вызвал срабатывание фильтра злоупотреблений, действие «$3» на странице «$4». Принятые меры: $5; описание фильтра: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 вызвал срабатывание фильтра $3, действие «$4» на странице «$5». Принятые меры: $6; описание фильтра: $7 ($8)',
	'abusefilter-log-detailslink'              => 'подробности',
	'abusefilter-log-details-legend'           => 'Подробности записи журнала $1',
	'abusefilter-log-details-var'              => 'Переменная',
	'abusefilter-log-details-val'              => 'Значение',
	'abusefilter-log-details-vars'             => 'Параметры действия',
	'abusefilter-log-details-private'          => 'Приватные данные',
	'abusefilter-log-details-ip'               => 'Исходящий IP-адрес',
	'abusefilter-log-noactions'                => 'нет',
	'abusefilter-management'                   => 'Управление фильтром злоупотреблений',
	'abusefilter-list'                         => 'Все фильтры',
	'abusefilter-list-id'                      => 'ИД фильтра',
	'abusefilter-list-status'                  => 'Состояние',
	'abusefilter-list-public'                  => 'Общедоступное описание',
	'abusefilter-list-consequences'            => 'Последствия',
	'abusefilter-list-visibility'              => 'Видимость',
	'abusefilter-list-hitcount'                => 'Срабатываний',
	'abusefilter-list-edit'                    => 'Править',
	'abusefilter-list-details'                 => 'Подробности',
	'abusefilter-hidden'                       => 'Личное',
	'abusefilter-unhidden'                     => 'Общедоступное',
	'abusefilter-enabled'                      => 'Включён',
	'abusefilter-disabled'                     => 'Выключен',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|срабатывание|срабатывания|срабатываний}}',
	'abusefilter-list-new'                     => 'Новый фильтр',
	'abusefilter-edit-subtitle'                => 'Изменение фильтра $1',
	'abusefilter-edit-status-label'            => 'Статистика',
	'abusefilter-edit-new'                     => 'Новый фильтр',
	'abusefilter-edit-save'                    => 'Сохранить фильтр',
	'abusefilter-edit-id'                      => 'ИД фильтра:',
	'abusefilter-edit-description'             => "Описание:
:''(общедоступное)''",
	'abusefilter-edit-flags'                   => 'Флаги:',
	'abusefilter-edit-enabled'                 => 'Включить этот фильтр',
	'abusefilter-edit-hidden'                  => 'Скрыть подробности этого фильтра от обычных участников',
	'abusefilter-edit-rules'                   => 'Набор правил:',
	'abusefilter-edit-notes'                   => "Примечания:
:''(приватные)",
	'abusefilter-edit-lastmod'                 => 'Последнее изменение фильтра:',
	'abusefilter-edit-lastuser'                => 'Участник, последним изменивший фильтр:',
	'abusefilter-edit-hitcount'                => 'Срабатываний фильтра:',
	'abusefilter-edit-consequences'            => 'Принятых по срабатыванию мер',
	'abusefilter-edit-action-warn'             => 'Принимать эти меры после предупреждения участника',
	'abusefilter-edit-action-disallow'         => 'Запретить действие',
	'abusefilter-edit-action-flag'             => 'Отметить правку в журнале злоупотреблений',
	'abusefilter-edit-action-blockautopromote' => 'Снять с участника статус автоподтверждения',
	'abusefilter-edit-action-degroup'          => 'Исключить участника из всех привилегированных групп',
	'abusefilter-edit-action-block'            => 'Заблокировать участника',
	'abusefilter-edit-action-throttle'         => 'Применять меры только если участник превышает предел',
	'abusefilter-edit-throttle-count'          => 'Количество разрешённых действий:',
	'abusefilter-edit-throttle-period'         => 'Отрезок времени:',
	'abusefilter-edit-throttle-seconds'        => '$1 секунд',
	'abusefilter-edit-throttle-groups'         => "Группа сжатая:
:''(по одной на строке, в сочетании с запятыми)''",
	'abusefilter-edit-denied'                  => 'Вы не можете просмотреть подробную информацию об этом фильтре, так как она скрыта от обычных участников.',
	'abusefilter-edit-main'                    => 'Параметры фильтра',
	'abusefilter-edit-done-subtitle'           => 'Фильтр исправлен',
	'abusefilter-edit-done'                    => 'Вы успешно сохранили изменения в фильтре.

[[Special:AbuseFilter|Вернуться]]',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'abusefilter-desc'                         => 'Vykonáva automatickú heuristiku úprav.',
	'abusefilter'                              => 'Nastavenie filtra zneužití',
	'abuselog'                                 => 'Záznam zneužití',
	'abusefilter-warning'                      => "<big>'''Upozornenie'''</big>: Táto činnosť bola automaticky identifikovaná ako škodlivá.
Nekonštruktívne úpravy budú rýchlo vrátené a zjavné alebo opakované nekonštruktívne zásahy budú mať za následok zablokovanie vášho účtu alebo počítača. Ak veríte, že je táto úprava konštruktívna, môžete znova kliknúť na Uložiť, čím ju potvrdíte.
Stručný popis pravidla zneužitia, ktoré zachytilo vašu úpravu, je: $1",
	'abusefilter-disallowed'                   => 'Táto činnosť bola automaticky identifikovaná ako škodlivá a preto bola odmietnutá.
Ak veríte, že je táto úprava konštruktívna, kontaktujte prosím správcu a oznámte im, čo ste sa pokúšali urobiť.
Stručný popis pravidla zneužitia, ktoré zachytilo vašu úpravu, je: $1',
	'abusefilter-blocked-display'              => 'Táto činnosť bola automaticky identifikovaná ako škodlivá a preto bola odmietnutá.
Naviac, na ochranu {{GRAMMAR:genitív|{{SITENAME}}}} boli zablokované úpravy z vášho používateľského účtu a všetkých príslušných IP adries.
Ak veríte, že to je omyl, kontaktujte prosím správcu.
Stručný popis pravidla zneužitia, ktoré zachytilo vašu úpravu, je: $1',
	'abusefilter-degrouped'                    => 'Táto činnosť bola automaticky identifikovaná ako škodlivá.
Následne bola odmietnutá a pretože existuje podozrenie, že váš účet bol zneužitý, všetky práva mu boli odobrané.
Ak veríte, že to je omyl, kontaktujte prosím byrokrata, vysvetlite mu, čo ste sa pokúšali urobiť a môže obnoviť vaše práva.
Stručný popis pravidla zneužitia, ktoré zachytilo vašu úpravu, je: $1',
	'abusefilter-autopromote-blocked'          => 'Táto činnosť bola automaticky identifikovaná ako škodlivá a preto bola odmietnutá.
Naviac, ako bezpečnostné opatrenie, boli vášmu účtu dočasne odobrané niektoré oprávnenia, ktoré sa bežne prideľujú dôveryhodným účtom.
Stručný popis pravidla zneužitia, ktoré zachytilo vašu úpravu, je: $1',
	'abusefilter-blocker'                      => 'Filter zneužití',
	'abusefilter-blockreason'                  => 'Automaticky zachytené filtrom zneužití. Popis pravidla: $1',
	'abusefilter-degroupreason'                => 'Práva automaticky odobral filter zneužívania. Popis pravidla: $1',
	'abusefilter-accountreserved'              => 'Tento názov účtu je vyhradený pre použitie filtrom zneužití.',
	'right-abusefilter-modify'                 => 'Zmeniť filtre zneužití',
	'right-abusefilter-view'                   => 'Zobraziť filtre zneužití',
	'right-abusefilter-log'                    => 'Zobraziť záznam zneužití',
	'right-abusefilter-log-detail'             => 'Zobraziť podrobnosti položiek záznamu zneužití',
	'right-abusefilter-private'                => 'Zobraziť osobné údaje v zázname zneužití',
	'abusefilter-log'                          => 'Záznam filtra zneužití',
	'abusefilter-log-search'                   => 'Hľadať v zázname filtra zneužití',
	'abusefilter-log-search-user'              => 'Používateľ:',
	'abusefilter-log-search-filter'            => 'ID filtra:',
	'abusefilter-log-search-title'             => 'Názov:',
	'abusefilter-log-search-submit'            => 'Hľadať',
	'abusefilter-log-entry'                    => '$1: $2 spustil filter zneužití, pri vykonávaní $3 na $4. Opatrenia: $5; Popis filtra: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 spustil filter $3, pri vykonávaní $4 na $5. Opatrenia: $6; Popis filtra: $7 ($8)',
	'abusefilter-log-detailslink'              => 'podrobnosti',
	'abusefilter-log-details-legend'           => 'Podrobnosti položky záznamu $1',
	'abusefilter-log-details-var'              => 'Premenná',
	'abusefilter-log-details-val'              => 'Hodnota',
	'abusefilter-log-details-vars'             => 'Parametre operácie',
	'abusefilter-log-details-private'          => 'Osobné údaje',
	'abusefilter-log-details-ip'               => 'Zdrojová IP adresa',
	'abusefilter-log-noactions'                => 'žiadne',
	'abusefilter-management'                   => 'Správa filtra zneužití',
	'abusefilter-list'                         => 'Všetky filtre',
	'abusefilter-list-id'                      => 'ID filtra',
	'abusefilter-list-status'                  => 'Stav',
	'abusefilter-list-public'                  => 'Verejný popis',
	'abusefilter-list-consequences'            => 'Následky',
	'abusefilter-list-visibility'              => 'Viditeľnosť',
	'abusefilter-list-hitcount'                => 'Počet zásahov',
	'abusefilter-list-edit'                    => 'upraviť',
	'abusefilter-list-details'                 => 'Podrobnosti',
	'abusefilter-hidden'                       => 'Súkromné',
	'abusefilter-unhidden'                     => 'Verejné',
	'abusefilter-enabled'                      => 'Zapnuté',
	'abusefilter-disabled'                     => 'Vypnuté',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|zásah|zásahov}}',
	'abusefilter-list-new'                     => 'Nový filter',
	'abusefilter-tools-modifiertest-submit'    => 'Otestovať',
	'abusefilter-tools'                        => 'Sú dostupné [[Special:AbuseFilter/tools|nástroje]] pomáhajúce pri tvorbe a ladení filtrov zneužití.',
	'abusefilter-tools-modifiertest'           => 'Otestovať modifikátory',
	'abusefilter-tools-modifier'               => 'Modifikátor:',
	'abusefilter-tools-value'                  => 'Otestovať hodnotu:',
	'abusefilter-tools-result'                 => 'Výsledok:',
	'abusefilter-status'                       => 'Z posledných $1 operácií $2 ($3%) dosialho hraničnú podmienku $4. $5 ($6%) zodpovedalo momentálne zapnutým filtrom.',
	'abusefilter-edit-subtitle'                => 'Úprava filtra $1',
	'abusefilter-edit-status-label'            => 'Štatistika',
	'abusefilter-edit-status'                  => 'Z posledných $1 operácii tomuto filtru zodpovedalo $2 ($3 %).',
	'abusefilter-edit-throttled'               => "'''Upozornenie''': V rámci bezpečnostných opatrení bol tento filter automaticky vypnutý. Dosiahol hodnotu obmedzenia $1 % operácií, ktoré mu zodpovedajú.",
	'abusefilter-edit-new'                     => 'Nový filter',
	'abusefilter-edit-save'                    => 'Uložiť filter',
	'abusefilter-edit-id'                      => 'ID filtra:',
	'abusefilter-edit-description'             => "Popis:
:''(verejne viditeľný)''",
	'abusefilter-edit-flags'                   => 'Príznaky:',
	'abusefilter-edit-enabled'                 => 'Zapnúť tento filter',
	'abusefilter-edit-hidden'                  => 'Skryť verejné zobrazovanie podrobností filtra',
	'abusefilter-edit-rules'                   => 'Pravidlá:',
	'abusefilter-edit-notes'                   => "Poznámky:
:''(súkromný)''",
	'abusefilter-edit-lastmod'                 => 'Posledná zmena filtra:',
	'abusefilter-edit-lastuser'                => 'Poslednú zmenu filtra vykonal:',
	'abusefilter-edit-hitcount'                => 'Počet zásahov filtra:',
	'abusefilter-edit-consequences'            => 'Opatrenia vykonané pri zásahu',
	'abusefilter-edit-action-warn'             => 'Spustiť tieto operácie po varovaní používateľa',
	'abusefilter-edit-action-disallow'         => 'Zamietnuť operáciu',
	'abusefilter-edit-action-flag'             => 'Označiť úpravu v zázname zneužití',
	'abusefilter-edit-action-blockautopromote' => 'Odobrať používateľovi stav „zaregistrovaný”',
	'abusefilter-edit-action-degroup'          => 'Odstrániť používateľa zo všetkých privilegovaných skupín',
	'abusefilter-edit-action-block'            => 'Zablokovať používateľa',
	'abusefilter-edit-action-throttle'         => 'Spustiť operáciu iba ak používateľ dosiahne limit rýchlosti úprav',
	'abusefilter-edit-throttle-count'          => 'Počet povolených operácií:',
	'abusefilter-edit-throttle-period'         => 'Časový interval:',
	'abusefilter-edit-throttle-seconds'        => '$1 sekúnd',
	'abusefilter-edit-throttle-groups'         => "Obmedzenie rýchlosti úprav skupiny:
:''(jedna na riadok, viaceré oddelené čiarkami)''",
	'abusefilter-edit-denied'                  => 'Nemôžete zobraziť podrobnosti toho filtra, pretože jeho verejné zobrazovanie je vypnuté',
	'abusefilter-edit-main'                    => 'Parametre filtra',
	'abusefilter-edit-done-subtitle'           => 'Filter bol upravený',
	'abusefilter-edit-done'                    => 'Úspešne ste uložili zmeny filtra.

[[Special:AbuseFilter|Vrátiť sa späť]]',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Boivie
 */
$messages['sv'] = array(
	'abusefilter-desc'                         => 'Lägger till automatiska heuristiker till redigeringar.',
	'abusefilter'                              => 'Konfiguration av missbruksfilter',
	'abuselog'                                 => 'Missbrukslogg',
	'abusefilter-warning'                      => "<big>'''Varning:'''</big> Denna handling har automatiskt identifierats som skadlig.
Ej konstruktiva redigeringar kommer snabbt att återställas,
och långvaring förstörande redigering kommer leda till att ditt konto eller dator blir blockerad.
Om du menar att denna redigering är konstruktiv, ska du klicka på \"Spara\" igen för att bekräfta det.
En kortfattad beskrivning av missbruksregler som matchar med din handling är: \$1",
	'abusefilter-disallowed'                   => 'Denna handling har automatiskt identifierats som skadlig,
och tillåts därför inte.
Om du menar att din redigering var konstruktiv, var god kontakta en administratör och informera den om vad du prövade att göra.
En kortfattad beskrivning av missbruksregler som din handling matchar med är: $1',
	'abusefilter-blocked-display'              => 'Denna handling har automatiskt identifierats som skadlig,
och du har blivit hindrad från att genomföra den.
I tillägg, för att skydda {{SITENAME}}, har ditt användarkonto och alla associerade IP-adresser blivit blockerade från att redigera.
Om detta är ett fel, var god kontakta en administratör.
En kortfattad beskrivning av missbruksregler som din handling matchar med är: $1',
	'abusefilter-degrouped'                    => 'Denna handling har automatiskt identifierats som skadlig.
Därför är den inte tillåten, och på grund av misstanke om missbruk har ditt konto mist alla sina rättighetet.
Om du menar att detta är fel, var god kontakta en byråkrat med en förklaring på vad du gjorde, och dina rättigheter kan återställas.
En kortfattad beskrivning av missbruksregler som din handling matchar med är: $1',
	'abusefilter-autopromote-blocked'          => 'Denna handling har automatiskt identifierats som skadlig, och är inte tillåten.
I tillägg blev några av ditt kontos rättigheter borttagna temporärt.
En kortfattad beskrivning av missbruksregler som din handling matchar med är: $1',
	'abusefilter-blocker'                      => 'Missbruksfilter',
	'abusefilter-blockreason'                  => 'Automatiskt blockerad av missbruksfiltret. Regelbeskrivning: $1',
	'abusefilter-degroupreason'                => 'Behörigheter borttagna automatisk av missbruksfilter. Regelbeskrivning: $1',
	'abusefilter-accountreserved'              => 'Detta kontot är reserverat för användning av missbruksfiltret.',
	'right-abusefilter-modify'                 => 'Ändra missbruksfilter',
	'right-abusefilter-view'                   => 'Visa missbruksfilter',
	'right-abusefilter-log'                    => 'Visa missbruksloggen',
	'right-abusefilter-log-detail'             => 'Visa detaljerade element i missbruksloggen',
	'right-abusefilter-private'                => 'Visa privat information i missbruksloggen',
	'abusefilter-log'                          => 'Logg för missbruksfilter',
	'abusefilter-log-search'                   => 'Sök i missbruksloggen',
	'abusefilter-log-search-user'              => 'Användare:',
	'abusefilter-log-search-filter'            => 'Filter-ID:',
	'abusefilter-log-search-title'             => 'Titel:',
	'abusefilter-log-search-submit'            => 'Sök',
	'abusefilter-log-entry'                    => '$1: $2 utlöste missbruksfiltret genom att göra en $3 på $4. Reaktion: $5; filterbeskrivning: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 utlöste missbruksfilter $3, genom att göra en $4 på $5. Reaktion: $6; filterbeskrivning: $7 ($8)',
	'abusefilter-log-detailslink'              => 'detaljer',
	'abusefilter-log-details-legend'           => 'Detaljer för loggelement $1',
	'abusefilter-log-details-var'              => 'Variabel',
	'abusefilter-log-details-val'              => 'Värde',
	'abusefilter-log-details-vars'             => 'Handlingsparametrar',
	'abusefilter-log-details-private'          => 'Privat information',
	'abusefilter-log-details-ip'               => 'Upphovs-IP',
	'abusefilter-log-noactions'                => 'ingen',
	'abusefilter-management'                   => 'Behandling av missbruksfilter',
	'abusefilter-list'                         => 'Alla filter',
	'abusefilter-list-id'                      => 'Filter-ID',
	'abusefilter-list-status'                  => 'Status',
	'abusefilter-list-public'                  => 'Allmän beskrivning',
	'abusefilter-list-consequences'            => 'Konsekvenser',
	'abusefilter-list-visibility'              => 'Synlighet',
	'abusefilter-list-hitcount'                => 'Träffräknare',
	'abusefilter-list-edit'                    => 'Redigera',
	'abusefilter-list-details'                 => 'Detaljer',
	'abusefilter-hidden'                       => 'Privat',
	'abusefilter-unhidden'                     => 'Allmän',
	'abusefilter-enabled'                      => 'Påslagen',
	'abusefilter-disabled'                     => 'Avslagen',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|träff|träffar}}',
	'abusefilter-list-new'                     => 'Nytt filter',
	'abusefilter-tools-modifiertest-submit'    => 'Testa',
	'abusefilter-tools'                        => 'Några [[Special:AbuseFilter/tools|verktyg]] finns tillgängliga för att hjälpa till med formulering och felsökning av missbruksfilter.',
	'abusefilter-tools-modifiertest'           => 'Testalternativ',
	'abusefilter-tools-modifier'               => 'Parameter:',
	'abusefilter-tools-value'                  => 'Värde att testa:',
	'abusefilter-tools-result'                 => 'Resultat:',
	'abusefilter-status'                       => 'Av de senaste $1 handlingarna har $2 ($3%) nått gränsvärdet $4. $5 ($6%) har matchat ett av de filter som för närvarande är påslagna.',
	'abusefilter-edit-subtitle'                => 'Redigerar filtret $1',
	'abusefilter-edit-status-label'            => 'Statistik',
	'abusefilter-edit-status'                  => 'Av de senaste $1 handlingarna, så har detta filter matchat $2 ($3).',
	'abusefilter-edit-throttled'               => "'''Varning''': Detta filter slogs av automatiskt, som en säkerhetsåtgärd. Det nådde gränsen av att matcha mer än $1% av handlingarna.",
	'abusefilter-edit-new'                     => 'Nytt filter',
	'abusefilter-edit-save'                    => 'Spara filter',
	'abusefilter-edit-id'                      => 'Filter-ID:',
	'abusefilter-edit-description'             => "Beskrivning:
:''(visas allmänt)''",
	'abusefilter-edit-flags'                   => 'Flaggor:',
	'abusefilter-edit-enabled'                 => 'Slå på detta filter',
	'abusefilter-edit-hidden'                  => 'Dölj detaljer om detta filter',
	'abusefilter-edit-rules'                   => 'Regelverk:',
	'abusefilter-edit-notes'                   => "Noteringar:
:''(privat)",
	'abusefilter-edit-lastmod'                 => 'Filter senast ändrat:',
	'abusefilter-edit-lastuser'                => 'Senaste användare som ändrade detta filter:',
	'abusefilter-edit-hitcount'                => 'Filterträffar:',
	'abusefilter-edit-consequences'            => 'Handlingar som tas vid träff',
	'abusefilter-edit-action-warn'             => 'Gör dessa handlingar efter att använaren fått en varning',
	'abusefilter-edit-action-disallow'         => 'Förbjud handlingen',
	'abusefilter-edit-action-flag'             => 'Flagga redigeringen i missbruksloggen',
	'abusefilter-edit-action-blockautopromote' => 'Återta användarnas bekräftad-status',
	'abusefilter-edit-action-degroup'          => 'Ta bort alla behörigheter från användaren',
	'abusefilter-edit-action-block'            => 'Blockera användaren från redigering',
	'abusefilter-edit-action-throttle'         => 'Genomför handlingar endast om användaren överstiger en limit',
	'abusefilter-edit-throttle-count'          => 'Antal tillåtna handlingar:',
	'abusefilter-edit-throttle-period'         => 'Tidsperiod:',
	'abusefilter-edit-throttle-seconds'        => '$1 sekunder',
	'abusefilter-edit-throttle-groups'         => "Gruppbegränsning på:
:''(en per rad, kombinera med komman)''",
	'abusefilter-edit-denied'                  => 'Du kan inte se detta filters detaljer, för de är dolda',
	'abusefilter-edit-main'                    => 'Filterparametrar',
	'abusefilter-edit-done-subtitle'           => 'Filter redigerat',
	'abusefilter-edit-done'                    => 'Du har sparat dina ändringar i filtret.

[[Special:AbuseFilter|Tillbaka]]',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'abuselog'                          => 'దురుపయోగాల చర్యానివేదిక',
	'abusefilter-blocker'               => 'దురుపయోగాల జల్లెడ',
	'abusefilter-log-search-user'       => 'వాడుకరి:',
	'abusefilter-log-search-title'      => 'శీర్షిక:',
	'abusefilter-log-search-submit'     => 'అన్వేషణ',
	'abusefilter-log-detailslink'       => 'వివరాలు',
	'abusefilter-log-details-val'       => 'విలువ',
	'abusefilter-log-details-ip'        => 'ఉద్భవించిన ఐ.పీ.చిరునామా',
	'abusefilter-list-status'           => 'స్థితి',
	'abusefilter-list-consequences'     => 'పరిణామాలు',
	'abusefilter-list-hitcount'         => 'హిట్ల లెక్క',
	'abusefilter-list-edit'             => 'మార్చు',
	'abusefilter-list-details'          => 'వివరాలు',
	'abusefilter-hidden'                => 'అంతరంగికం',
	'abusefilter-unhidden'              => 'బహిరంగం',
	'abusefilter-enabled'               => 'సచేతనం',
	'abusefilter-disabled'              => 'అచేతనం',
	'abusefilter-list-new'              => 'కొత్త జల్లెడ',
	'abusefilter-edit-subtitle'         => '$1 జల్లెడను దిద్దుతున్నారు',
	'abusefilter-edit-new'              => 'కొత్త జల్లెడ',
	'abusefilter-edit-save'             => 'జల్లెడ భద్రపరచు',
	'abusefilter-edit-id'               => 'జల్లెడ ఐ.డీ:',
	'abusefilter-edit-description'      => "వివరణ:
:''(బహిరంగంగా కనిపిస్తుంది)''",
	'abusefilter-edit-rules'            => 'నియమావళి:',
	'abusefilter-edit-notes'            => "గమనికలు:
:''(అంతరంగికం)",
	'abusefilter-edit-hitcount'         => 'జల్లెడ హిట్లు:',
	'abusefilter-edit-consequences'     => 'హిట్‌పై తీసుకున్న చర్యలు',
	'abusefilter-edit-action-disallow'  => 'ఈ చర్యను నిరాకరించు',
	'abusefilter-edit-action-block'     => 'ఈ వాడుకరిని దిద్దుబాట్లు చేయకుండా నిషేధించు',
	'abusefilter-edit-throttle-seconds' => '$1 క్షణాలు',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author AS
 */
$messages['uk'] = array(
	'abusefilter-desc'                         => 'Застосовує до редагувань автоматичні евристики.',
	'abusefilter'                              => 'Налаштування фільтра зловживань',
	'abuselog'                                 => 'Журнал зловживань',
	'abusefilter-warning'                      => "<big>'''Увага'''</big>: Ця дія була автоматично визначена як шкідлива.
Неконструктивні редагування будуть швидко скасовані,
а грубі або неодноразові неконструктивні редагування призведуть до блокування вашого облікового запису або комп'ютера.
Якщо ви вважаєте, що це редагування конструктивне, то ви можете ще раз натиснути «Зберегти сторінку», щоб підтвердити редагування.
Короткий опис зловживання, яке пов'язане з вашою дією: $1",
	'abusefilter-disallowed'                   => "Ця дія автоматично визначена як шкідлива,
і тому заборонена.
Якщо ви вважаєте, що це редагування конструктивне, будь ласка, зверніться до адміністратора і розкажіть йому, що ви хотіли зробити.
Короткий опис зловживання, яке пов'язане з вашою дією: $1",
	'abusefilter-blocked-display'              => "Ця дію була автоматично визначена як шкідлива,
і тому її виконання заборонене.
Окрім того, для захисту проекту {{SITENAME}} ваш обліковий запис і пов'язані з ним IP-адреси були заблоковані.
Якщо ви вважаєте це помилковим, то зв'яжіться з адміністратором.
Короткий опис зловживання, яке пов'язане з вашою дією: $1",
	'abusefilter-degrouped'                    => "Ця дія була автоматично визначена як шкідлива.
Таким чином, дія була скасована, ваш обліковий запис вважається скомпрометованим і в нього відібрано всі права.
Якщо ви вважаєте це помилковим, будь ласка, зв'яжіться з бюрократом і поясніть йому ваші дії, тоді ваші права будуть відновлені.
Короткий опис зловживання, яке пов'язане з вашою дією: $1",
	'abusefilter-autopromote-blocked'          => "Цю дію автоматично визначено, як шкідливу, і тому заборонено.
Крім того, як захід безпеки, у вашого облікового запису тимчасово відібрано деякі привілеї, які звичаєво надаються зареєстрованим обліковим записам.
Короткий опис зловживання, яке пов'язали з вашою дією: $1",
	'abusefilter-blocker'                      => 'Фільтр зловживань',
	'abusefilter-blockreason'                  => 'Автоматично заблокований фільтром зловживань. Опис правила: $1',
	'abusefilter-degroupreason'                => 'Права автоматично відібрані фільтром зловживань. Опис правила: $1',
	'abusefilter-accountreserved'              => 'Цей обліковий запис є зарезервованим для використання фільтром зловживань.',
	'right-abusefilter-modify'                 => 'Налаштувати фільтр зловживань',
	'right-abusefilter-view'                   => 'Переглянути фільтр зловживань',
	'right-abusefilter-log'                    => 'Переглянути журнал зловживань',
	'right-abusefilter-log-detail'             => 'Переглянути деталізовані записи журналу зловживань',
	'right-abusefilter-private'                => 'Переглянути приватні дані у журналі зловживань',
	'abusefilter-log'                          => 'Журнал фільтру зловживань',
	'abusefilter-log-search'                   => 'Пошук в журналі зловживань',
	'abusefilter-log-search-user'              => 'Користувач:',
	'abusefilter-log-search-title'             => 'Заголовок:',
	'abusefilter-log-search-submit'            => 'Знайти',
	'abusefilter-log-entry'                    => '$1: $2 запустив фільтр зловживань, виконуючи "$3" на сторінці "$4". Прийняті заходи: $5; опис фільтру: $6',
	'abusefilter-log-detailedentry'            => '$1: $2 запустив фільтр $3, виконуючи "$4" на сторінці "$5". Прийняті заходи: $6; опис фільтру: $7 ($8)',
	'abusefilter-log-detailslink'              => 'деталі',
	'abusefilter-log-details-legend'           => 'Деталі журнального запису $1',
	'abusefilter-log-details-var'              => 'Змінна',
	'abusefilter-log-details-val'              => 'Значення',
	'abusefilter-log-details-vars'             => 'Параметри дії',
	'abusefilter-log-details-private'          => 'Приватні дані',
	'abusefilter-log-details-ip'               => 'Вихідна IP-адреса',
	'abusefilter-management'                   => 'Управління фільтром зловживань',
	'abusefilter-list'                         => 'Усі фільтри',
	'abusefilter-list-id'                      => 'ІД фільтра',
	'abusefilter-list-status'                  => 'Стан',
	'abusefilter-list-public'                  => 'Загальнодоступний опис',
	'abusefilter-list-consequences'            => 'Наслідки',
	'abusefilter-list-visibility'              => 'Видимість',
	'abusefilter-list-hitcount'                => 'Спрацьовувань',
	'abusefilter-list-edit'                    => 'Редагувати',
	'abusefilter-list-details'                 => 'Деталі',
	'abusefilter-hidden'                       => 'Приватне',
	'abusefilter-unhidden'                     => 'Загальнодоступне',
	'abusefilter-enabled'                      => 'Увімкнений',
	'abusefilter-disabled'                     => 'Вимкнений',
	'abusefilter-hitcount'                     => '$1 {{PLURAL:$1|спрацьовування|спрацьовування|спрацьовувань}}',
	'abusefilter-list-new'                     => 'Новий фільтр',
	'abusefilter-edit-subtitle'                => 'Редагування фільтру $1',
	'abusefilter-edit-new'                     => 'Новий фільтр',
	'abusefilter-edit-save'                    => 'Зберегти фільтр',
	'abusefilter-edit-id'                      => 'ІД фильтра:',
	'abusefilter-edit-description'             => "Опис:
:''(загальнодоступне) ''",
	'abusefilter-edit-flags'                   => 'Прапорці:',
	'abusefilter-edit-enabled'                 => 'Увімкнути цей фільтр',
	'abusefilter-edit-hidden'                  => 'Приховати деталі цього фільтру від загальнодоступного огляду',
	'abusefilter-edit-rules'                   => 'Набір правил:',
	'abusefilter-edit-notes'                   => "Примітки:
:''(приватні)",
	'abusefilter-edit-lastmod'                 => 'Остання зміна фільтру:',
	'abusefilter-edit-lastuser'                => 'Останній, хто змінював фільтр:',
	'abusefilter-edit-hitcount'                => 'Спрацьовувань фільтру:',
	'abusefilter-edit-consequences'            => 'Прийнятих після спрацьовування мір',
	'abusefilter-edit-action-warn'             => 'Приймати ці заходи після попередження користувача',
	'abusefilter-edit-action-disallow'         => 'Заборонити дію',
	'abusefilter-edit-action-flag'             => 'Позначити редагування в журналі зловживань',
	'abusefilter-edit-action-blockautopromote' => 'Зняти з користувача статус автопідтвердження',
	'abusefilter-edit-action-degroup'          => 'Виключити користувача з усіх привілейованих груп',
	'abusefilter-edit-action-block'            => 'Заблокувати користувача',
	'abusefilter-edit-action-throttle'         => 'Приймати міри тільки якщо користувач переходить межу',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'abusefilter-desc' => 'Àplica dele eurìstiche automatiche a le modifiche.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'abusefilter-list'                  => 'Các bộ lọc',
	'abusefilter-list-id'               => 'ID bộ lọc',
	'abusefilter-list-status'           => 'Trạng thái',
	'abusefilter-list-edit'             => 'Sửa đổi',
	'abusefilter-list-details'          => 'Chi tiết',
	'abusefilter-unhidden'              => 'Công khai',
	'abusefilter-list-new'              => 'Bộ lọc mới',
	'abusefilter-edit-subtitle'         => 'Sửa đổi bộ lọc $1',
	'abusefilter-edit-new'              => 'Bộ lọc mới',
	'abusefilter-edit-save'             => 'Lưu bộ lọc',
	'abusefilter-edit-id'               => 'ID bộ lọc:',
	'abusefilter-edit-rules'            => 'Bộ quy tắc:',
	'abusefilter-edit-action-block'     => 'Cấm người dùng không được sửa đổi',
	'abusefilter-edit-throttle-period'  => 'Thời gian:',
	'abusefilter-edit-throttle-seconds' => '$1 giây',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenzw
 */
$messages['zh-hans'] = array(
	'abusefilter-log-search-user' => '用户：',
);

