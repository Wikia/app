<?php
/**
 * Internationalisation file for Maintenance extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Ryan Schmidt
 * @author Purodha
 */
$messages['en'] = array(
	// special page text
	'maintenance' => 'Run maintenance scripts',
	// description
	'maintenance-desc' => '[[Special:Maintenance|Wiki interface]] for various maintenance scripts',
	// for Special:ListGroupRights
	'right-maintenance' => 'Run maintenance scripts through [[Special:Maintenance]]',
	// main form
	'maintenance-backlink' => 'Back to script selection',
	'maintenance-header' => 'Please select a script below to execute.
Descriptions are next to each script',
	// script descriptions
	'maintenance-changePassword-desc' => "Change a user's password",
	'maintenance-createAndPromote-desc' => 'Create a user and promote to administrator status',
	'maintenance-deleteBatch-desc' => 'Mass-delete pages',
	'maintenance-deleteRevision-desc' => 'Remove revisions from the database',
	'maintenance-eval-desc' => 'Evaluate PHP code in the MediaWiki environment',
	'maintenance-initEditCount-desc' => 'Recalculate the edit counts of users',
	'maintenance-initStats-desc' => 'Recalculate site statistics',
	'maintenance-moveBatch-desc' => 'Mass-move pages',
	'maintenance-reassignEdits-desc' => 'Reassign edits from one user to another',
	'maintenance-runJobs-desc' => 'Run jobs in the job queue',
	'maintenance-showJobs-desc' => 'Show a list of jobs pending in the job queue',
	'maintenance-sql-desc' => 'Execute an SQL query',
	'maintenance-stats-desc' => 'Show Memcached statistics',
	// changePassword
	'maintenance-changePassword' => "Use this form to change a user's password",
	// createAndPromote
	'maintenance-createAndPromote' => 'Use this form to create a new user and promote it to administrator.
Check the bureaucrat box if you wish to promote to bureaucrat as well',
	// deleteBatch
	'maintenance-deleteBatch' => 'Use this form to mass-delete pages.
Put only one page per line',
	// deleteRevision
	'maintenance-deleteRevision' => 'Use this form to mass-delete revisions.
Put only one revision number per line',
	// initEditCount
	'maintenance-initEditCount' => '',
	// initStats
	'maintenance-initStats' => 'Use this form to recalculate site statistics, specifying if you want to recalculate page views as well',
	// moveBatch
	'maintenance-moveBatch' => 'Use this form to mass-move pages.
Each line should specify a source page and destination page separated by a pipe',
	// runJobs
	'maintenance-runJobs' => '',
	// showJobs
	'maintenance-showJobs' => '',
	// stats
	'maintenance-stats' => '',
	// invalid type
	'maintenance-invalidtype' => 'Invalid type!',
	// changePassword + createAndPromote
	'maintenance-name' => 'Username',
	'maintenance-password' => 'Password',
	// createAndPromote
	'maintenance-bureaucrat' => 'Promote user to bureaucrat status',
	// deleteBatch, moveBatch, etc.
	'maintenance-reason' => 'Reason',
	// initStats
	'maintenance-update' => 'Use UPDATE when updating a table? Unchecked uses DELETE/INSERT instead.',
	'maintenance-noviews' => 'Check this to prevent updating the number of pageviews',
	// all scripts
	'maintenance-confirm' => 'Confirm',
	// createAndPromote, perhaps others
	'maintenance-invalidname' => 'Invalid username!',
	// all scripts
	'maintenance-success' => '$1 ran successfully!',
	// createAndPromote
	'maintenance-userexists' => 'User already exists!',
	// deleteBatch, moveBatch, perhaps others
	'maintenance-invalidtitle' => 'Invalid title "$1"!',
	// deleteBatch, moveBatch, perhaps others
	'maintenance-titlenoexist' => 'Title specified ("$1") does not exist!',
	// unsure
	'maintenance-failed' => 'FAILED',
	'maintenance-deleted' => 'DELETED',
	// deleteRevisions
	'maintenance-revdelete' => 'Deleting {{PLURAL:$3|revision|revisions}} $1 from wiki $2',
	'maintenance-revnotfound' => 'Revision $1 not found!',
	// sql
	'maintenance-sql' => 'Use this form to execute a SQL query on the database.',
	'maintenance-sql-aff' => 'Affected rows: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|row|rows}} returned:
$2',
	// stats
	'maintenance-stats-edits' => 'Number of edits: $1',
	'maintenance-stats-articles' => 'Number of pages in the main namespace: $1',
	'maintenance-stats-pages' => 'Number of pages: $1',
	'maintenance-stats-users' => 'Number of users: $1',
	'maintenance-stats-admins' => 'Number of admins: $1',
	'maintenance-stats-images' => 'Number of files: $1',
	'maintenance-stats-views' => 'Number of pageviews: $1',
	'maintenance-stats-update' => 'Updating database{{int:ellipsis}}',
	// moveBatch
	'maintenance-move' => 'Moving $1 to $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Error encountered while moving: $1.
Aborting move',
	// unsure
	'maintenance-error' => 'Error: $1',
	// stats
	'maintenance-memc-fake' => 'You are running FakeMemCachedClient. No statistics can be provided',
	'maintenance-memc-requests' => 'Requests',
	'maintenance-memc-withsession' => 'with session:',
	'maintenance-memc-withoutsession' => 'without session:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Parser cache',
	'maintenance-memc-hits' => 'hits:',
	'maintenance-memc-invalid' => 'invalid:',
	'maintenance-memc-expired' => 'expired:',
	'maintenance-memc-absent' => 'absent:',
	'maintenance-memc-stub' => 'stub threshold:',
	'maintenance-memc-imagecache' => 'Image cache',
	'maintenance-memc-misses' => 'misses:',
	'maintenance-memc-updates' => 'updates:',
	'maintenance-memc-uncacheable' => 'uncacheable:',
	'maintenance-memc-diffcache' => 'Diff Cache',
	// eval
	'maintenance-eval' => 'Use this form to evaluate PHP code in the MediaWiki environment.',
	// reassignEdits
	'maintenance-reassignEdits' => 'Use this form to reassign edits from one user to another.',
	'maintenance-re-from' => 'Name of the user to assign edits from',
	'maintenance-re-to' => 'Name of the user to assign edits to',
	'maintenance-re-force' => 'Reassign even if the target user does not exist',
	'maintenance-re-rc' => 'Do not update the recent changes table',
	'maintenance-re-report' => 'Print out details of what would be changed, but do not update it',
	'maintenance-re-nf' => 'User $1 not found',
	'maintenance-re-rr' => 'Run the script again without "$1" to update.',
	'maintenance-re-ce' => 'Current edits: $1',
	'maintenance-re-de' => 'Deleted edits: $1',
	'maintenance-re-rce' => 'RecentChanges entries: $1',
	'maintenance-re-total' => 'Total entries to change: $1',
	'maintenance-re-re' => 'Reassigning edits{{int:ellipsis}} done',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Fryed-peach
 * @author IAlex
 * @author Jon Harald Søby
 * @author Lloffiwr
 * @author Purodha
 * @author Siebrand
 * @author Translationista
 */
$messages['qqq'] = array(
	'maintenance-desc' => 'Short description of the Maintenance extension, shown in [[Special:Version]]. Do not translate or change links.',
	'right-maintenance' => '{{doc-right}}',
	'maintenance-name' => '{{Identical|Username}}',
	'maintenance-password' => '{{Identical|Password}}',
	'maintenance-reason' => '{{Identical|Reason}}',
	'maintenance-update' => "This message appears next to a checkbox. 'Unchecked' means that the checkbox has not been 'checked'. Words having the same meaning as 'checked' in this sentence are 'marked', 'ticked' and 'selected'.

Are UPDATE and DELETE/INSERT also translatable?",
	'maintenance-confirm' => '{{Identical|Confirm}}',
	'maintenance-deleted' => '{{Identical|Deleted}}',
	'maintenance-revdelete' => '* $1 is a list of revisions numbers
* $2 is the local wiki id (string containing database name and tables prefix, if any)',
	'maintenance-memc-total' => '{{Identical|Total}}',
	'maintenance-memc-hits' => '{{Identical|Hits}}',
	'maintenance-re-report' => 'Used as text for an option check box. Also substituted in {{msg-mw|maintenance-re-rr}}.',
	'maintenance-re-rr' => '* $1 is substituted by {{msg-mw|maintenance-re-report}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'maintenance-name' => 'Asa',
	'maintenance-password' => 'Ou password',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'maintenance-name' => 'Matahigoa he tagata',
	'maintenance-password' => 'Kupu fufu',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'maintenance-name' => 'Gebruikersnaam',
	'maintenance-password' => 'Wagwoord',
	'maintenance-reason' => 'Rede',
	'maintenance-confirm' => 'Bevestig',
	'maintenance-deleted' => 'Geskrap',
	'maintenance-memc-total' => 'totaal:',
	'maintenance-memc-invalid' => 'ongeldig:',
	'maintenance-memc-absent' => 'afwesig:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'maintenance-reason' => 'ምክንያት',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'maintenance-confirm' => 'Confirmar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'maintenance' => 'تشغيل سكريبتات الصيانة',
	'maintenance-desc' => '[[Special:Maintenance|واجهة ويب]] لسكريبتات صيانة مختلفة',
	'right-maintenance' => 'تشغيل سكريبتات الصيانة من خلال [[Special:Maintenance]]',
	'maintenance-backlink' => 'الرجوع إلى اختيار السكريبت',
	'maintenance-header' => 'من فضلك اختر سكريبت بالأسفل للتنفيذ.
الوصوفات بجانب كل سكريبت',
	'maintenance-changePassword-desc' => 'غير كلمة السر لمستخدم',
	'maintenance-createAndPromote-desc' => 'إنشاء مستخدم وترقية إلى حالة إداري',
	'maintenance-deleteBatch-desc' => 'حذف كمي للصفحات',
	'maintenance-deleteRevision-desc' => 'إزالة المراجعات من قاعدة البيانات',
	'maintenance-eval-desc' => 'في بيئة الميدياويكي PHP قيم كود',
	'maintenance-initEditCount-desc' => 'إعادة حساب عدد التعديلات للمستخدمين',
	'maintenance-initStats-desc' => 'إعادة حساب إحصاءات الموقع',
	'maintenance-moveBatch-desc' => 'نقل كمي للصفحات',
	'maintenance-reassignEdits-desc' => 'إعادة إلحاق التعديلات من مستخدم إلى آخر',
	'maintenance-runJobs-desc' => 'تنفيذ الأشغال في طابور الشغل',
	'maintenance-showJobs-desc' => 'يعرض قائمة بالأشغال قيد الانتظار في طابور الشغل',
	'maintenance-sql-desc' => 'SQL نفذ استعلام',
	'maintenance-stats-desc' => 'عرض إحصاءات ميم كاشد',
	'maintenance-changePassword' => 'استخدم هذه الاستمارة لتغيير كلمة السر لمستخدم',
	'maintenance-createAndPromote' => 'استخدم هذه الاستمارة لإنشاء مستخدم جديد وترقيته إلى مدير نظام.
علم على صندوق البيروقراط لو كنت ترغب في ترقيته إلى بيروقراط أيضا',
	'maintenance-deleteBatch' => 'استخدم هذه الاستمارة لحذف الصفحات بشكل كمي.
ضع فقط صفحة واحدة في كل سطر',
	'maintenance-deleteRevision' => 'استخدم هذه الاستمارة لحذف المراجعات بشكل كمي.
ضع فقط رقم مراجعة واحد في كل سطر',
	'maintenance-initStats' => 'استخدم هذه الاستمارة لإعادة حساب إحصاءات الموقع، محددا ما إذا كنت ترغب في إعادة حساب مشاهدات الصفحات أيضا',
	'maintenance-moveBatch' => 'استخدم هذه الاستمارة لنقل الصفحات بشكل كمي.
كل سطر ينبغي أن يحدد صفحة مصدر وصفحة هدف مفصولين ببايب',
	'maintenance-invalidtype' => 'نوع غير صحيح!',
	'maintenance-name' => 'اسم مستخدم',
	'maintenance-password' => 'كلمة السر',
	'maintenance-bureaucrat' => 'ترقية مستخدم إلى حالة بيروقراط',
	'maintenance-reason' => 'سبب',
	'maintenance-update' => 'استخدم UPDATE عند تحديث جدول غير المعلم يستخدم DELETE/INSERT بدلا من ذلك.',
	'maintenance-noviews' => 'علم على هذا لمنع تحديث عدد عرض الصفحات',
	'maintenance-confirm' => 'تأكيد',
	'maintenance-invalidname' => 'اسم مستخدم غير صحيح!',
	'maintenance-success' => '$1 عمل بنجاح!',
	'maintenance-userexists' => 'المستخدم موجود حاليا!',
	'maintenance-invalidtitle' => 'عنوان غير صحيح "$1"!',
	'maintenance-titlenoexist' => 'العنوان المحدد ("$1") غير موجود!',
	'maintenance-failed' => 'فشل',
	'maintenance-deleted' => 'تم حذفه',
	'maintenance-revdelete' => 'حذف {{PLURAL:$3|المراجعة|المراجعات}} $1 من الويكي $2',
	'maintenance-revnotfound' => 'المراجعة $1 لم يتم العثور عليها!',
	'maintenance-sql' => 'على قاعدة البيانات SQL استعمل هذا النموذج لتنفيذ استعلام',
	'maintenance-sql-aff' => 'الصفوف المتأثرة: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|صف|صف}} أرجع:
$2',
	'maintenance-stats-edits' => 'عدد التعديلات: $1',
	'maintenance-stats-articles' => 'عدد الصفحات في النطاق الرئيسي: $1',
	'maintenance-stats-pages' => 'عدد الصفحات: $1',
	'maintenance-stats-users' => 'عدد المستخدمين: $1',
	'maintenance-stats-admins' => 'عدد الإداريين: $1',
	'maintenance-stats-images' => 'عدد الملفات: $1',
	'maintenance-stats-views' => 'عدد مرات عرض الصفحة: $1',
	'maintenance-stats-update' => 'جاري تحديث قاعدة البيانات...',
	'maintenance-move' => 'نقل $1 إلى $2...',
	'maintenance-movefail' => 'تمت مصادفة خطأ أثناء النقل: $1.
ترك النقل',
	'maintenance-error' => 'خطأ: $1',
	'maintenance-memc-fake' => 'أنت تشغل FakeMemCachedClient. لا إحصاءات يمكن توفيرها',
	'maintenance-memc-requests' => 'طلبات',
	'maintenance-memc-withsession' => 'مع جلسة:',
	'maintenance-memc-withoutsession' => 'بدون جلسة:',
	'maintenance-memc-total' => 'مجموع:',
	'maintenance-memc-parsercache' => 'كاش المحلل',
	'maintenance-memc-hits' => 'ضربات:',
	'maintenance-memc-invalid' => 'غير صحيح:',
	'maintenance-memc-expired' => 'انتهى:',
	'maintenance-memc-absent' => 'غائب:',
	'maintenance-memc-stub' => 'الحد للبذرة:',
	'maintenance-memc-imagecache' => 'كاش الصورة',
	'maintenance-memc-misses' => 'مفقودات:',
	'maintenance-memc-updates' => 'تحديثات:',
	'maintenance-memc-uncacheable' => 'لا يمكن تخزينه:',
	'maintenance-memc-diffcache' => 'كاش الفرق',
	'maintenance-eval' => 'استخدم هذه الاستمارة لتقييم كود PHP في بيئة.',
	'maintenance-reassignEdits' => 'استخدم هذه الاستمارة لإعادة إلحاق التعديلات من مستخدم إلى آخر.',
	'maintenance-re-from' => 'اسم المستخدم لإلحاق التعديلات منه',
	'maintenance-re-to' => 'اسم المستخدم لإلحاق التعديلات إليه',
	'maintenance-re-force' => 'أعد الإلحاق حتى لو كان المستخدم الهدف غير موجود',
	'maintenance-re-rc' => 'لا تحدث جدول أحدث التغييرات',
	'maintenance-re-report' => 'اطبع تفاصيل ما سيتم تغييره، لكن لا تحدثه',
	'maintenance-re-nf' => 'المستخدم $1 لم يتم العثور عليه',
	'maintenance-re-rr' => 'أعد تشغيل السكريبت مرة أخرى بدون "$1" للتحديث.',
	'maintenance-re-ce' => 'تعديلات حالية: $1',
	'maintenance-re-de' => 'تعديلات محذوفة: $1',
	'maintenance-re-rce' => 'مدخلات أحدث التغييرات: $1',
	'maintenance-re-total' => 'إجمالي المدخلات للتغيير: $1',
	'maintenance-re-re' => 'جاري إعادة إلحاق التعديلات... تم',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ouda
 */
$messages['arz'] = array(
	'maintenance' => 'تشغيل سكريبتات الصيانة',
	'maintenance-desc' => '[[Special:Maintenance|واجهة ويب]] لسكريبتات صيانة مختلفة',
	'right-maintenance' => 'تشغيل سكريبتات الصيانة من خلال [[Special:Maintenance]]',
	'maintenance-backlink' => 'الرجوع إلى اختيار السكريبت',
	'maintenance-header' => 'من فضلك اختر سكريبت بالأسفل للتنفيذ.
الوصوفات بجانب كل سكريبت',
	'maintenance-changePassword-desc' => 'غير كلمة السر ليوزر',
	'maintenance-createAndPromote-desc' => 'إنشاء يوزر وترقية لإدارى',
	'maintenance-deleteBatch-desc' => 'حذف كمى للصفحات',
	'maintenance-deleteRevision-desc' => 'إزالة المراجعات من قاعدة البيانات',
	'maintenance-eval-desc' => 'فى بيئة الميدياويكى PHP قيم كود',
	'maintenance-initEditCount-desc' => 'إعادة حساب عدد التعديلات لليوزرز',
	'maintenance-initStats-desc' => 'إعادة حساب إحصاءات الموقع',
	'maintenance-moveBatch-desc' => 'نقل كمى للصفحات',
	'maintenance-reassignEdits-desc' => 'إعادة إلحاق التعديلات من مستخدم إلى آخر',
	'maintenance-runJobs-desc' => 'تنفيذ الأشغال فى طابور الشغل',
	'maintenance-showJobs-desc' => 'يعرض قائمة بالأشغال قيد الانتظار فى طابور الشغل',
	'maintenance-sql-desc' => 'SQL نفذ استعلام',
	'maintenance-stats-desc' => 'عرض إحصاءات ميم كاشد',
	'maintenance-changePassword' => 'استخدم هذه الاستمارة لتغيير كلمة السر لمستخدم',
	'maintenance-createAndPromote' => 'استخدم هذه الإستمارة لإنشاء مستخدم جديد وترقيته إلى مدير نظام.
علم على صندوق البيروقراط لو كنت ترغب فى ترقيته إلى بيروقراط أيضا',
	'maintenance-deleteBatch' => 'استخدم هذه الإستمارة لحذف الصفحات بشكل كمى.
ضع فقط صفحة واحدة فى كل سطر',
	'maintenance-deleteRevision' => 'استخدم هذه الإستمارة لحذف المراجعات بشكل كمى.
ضع فقط رقم مراجعة واحد فى كل سطر',
	'maintenance-initStats' => 'استخدم هذه الإستمارة لإعادة حساب إحصاءات الموقع، محددا ما إذا كنت ترغب فى إعادة حساب مشاهدات الصفحات أيضا',
	'maintenance-moveBatch' => 'استخدم هذه الإستمارة لنقل الصفحات بشكل كمى.
كل سطر ينبغى أن يحدد صفحة مصدر وصفحة هدف مفصولين ببايب',
	'maintenance-invalidtype' => 'نوع غير صحيح!',
	'maintenance-name' => 'اسم يوزر',
	'maintenance-password' => 'كلمة السر',
	'maintenance-bureaucrat' => 'ترقية مستخدم إلى حالة بيروقراط',
	'maintenance-reason' => 'سبب',
	'maintenance-update' => 'استخدم UPDATE عند تحديث جدول غير المعلم يستخدم DELETE/INSERT بدلا من ذلك.',
	'maintenance-noviews' => 'علم على هذا لمنع تحديث عدد عرض الصفحات',
	'maintenance-confirm' => 'تأكيد',
	'maintenance-invalidname' => 'اسم يوزر مش صحيح !',
	'maintenance-success' => '$1 عمل بنجاح!',
	'maintenance-userexists' => 'اليوزر موجود  دلوقتى!',
	'maintenance-invalidtitle' => 'عنوان غير صحيح "$1"!',
	'maintenance-titlenoexist' => 'العنوان المحدد ("$1") غير موجود!',
	'maintenance-failed' => 'فشل',
	'maintenance-deleted' => 'تم حذفه',
	'maintenance-revdelete' => 'حذف {{PLURAL:$3|المراجعه|المراجعات}} $1 من الويكى $2',
	'maintenance-revnotfound' => 'المراجعة $1 لم يتم العثور عليها!',
	'maintenance-sql' => 'على قاعدة البيانات SQL استعمل هذا النموذج لتنفيذ استعلام.',
	'maintenance-sql-aff' => 'الصفوف المتأثرة: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|صف|صف}} أرجع:
$2',
	'maintenance-stats-edits' => 'عدد التعديلات: $1',
	'maintenance-stats-articles' => 'عدد الصفحات فى النطاق الرئيسي: $1',
	'maintenance-stats-pages' => 'عدد الصفحات: $1',
	'maintenance-stats-users' => 'عدد المستخدمين: $1',
	'maintenance-stats-admins' => 'عدد الإداريين: $1',
	'maintenance-stats-images' => 'عدد الملفات: $1',
	'maintenance-stats-views' => 'عدد مرات عرض الصفحة: $1',
	'maintenance-stats-update' => 'جارى تحديث قاعدة البيانات...',
	'maintenance-move' => 'نقل $1 إلى $2...',
	'maintenance-movefail' => 'تمت مصادفة خطأ أثناء النقل: $1.
ترك النقل',
	'maintenance-error' => 'خطأ: $1',
	'maintenance-memc-fake' => 'أنت تشغل FakeMemCachedClient. لا إحصاءات يمكن توفيرها',
	'maintenance-memc-requests' => 'طلبات',
	'maintenance-memc-withsession' => 'مع جلسة:',
	'maintenance-memc-withoutsession' => 'بدون جلسة:',
	'maintenance-memc-total' => 'مجموع:',
	'maintenance-memc-parsercache' => 'كاش المحلل',
	'maintenance-memc-hits' => 'ضربات:',
	'maintenance-memc-invalid' => 'غير صحيح:',
	'maintenance-memc-expired' => 'انتهى:',
	'maintenance-memc-absent' => 'غائب:',
	'maintenance-memc-stub' => 'الحد للبذرة:',
	'maintenance-memc-imagecache' => 'كاش الصورة',
	'maintenance-memc-misses' => 'مفقودات:',
	'maintenance-memc-updates' => 'تحديثات:',
	'maintenance-memc-uncacheable' => 'لا يمكن تخزينه:',
	'maintenance-memc-diffcache' => 'كاش الفرق',
	'maintenance-eval' => 'استخدم هذه الاستمارة لتقييم كود PHP فى بيئة.',
	'maintenance-reassignEdits' => 'استخدم هذه الاستمارة لإعادة إلحاق التعديلات من مستخدم إلى آخر.',
	'maintenance-re-from' => 'اسم المستخدم لإلحاق التعديلات منه',
	'maintenance-re-to' => 'اسم المستخدم لإلحاق التعديلات إليه',
	'maintenance-re-force' => 'أعد الإلحاق حتى لو كان المستخدم الهدف غير موجود',
	'maintenance-re-rc' => 'لا تحدث جدول أحدث التغييرات',
	'maintenance-re-report' => 'اطبع تفاصيل ما سيتم تغييره، لكن لا تحدثه',
	'maintenance-re-nf' => 'المستخدم $1 غير موجود',
	'maintenance-re-rr' => 'أعد تشغيل السكريبت مرة أخرى بدون "$1" للتحديث.',
	'maintenance-re-ce' => '$1 : التعديلات الحالية',
	'maintenance-re-de' => '$1 : التعديلات المحذوفة',
	'maintenance-re-rce' => 'مدخلات أحدث التغييرات: $1',
	'maintenance-re-total' => 'إجمالى المدخلات للتغيير: $1',
	'maintenance-re-re' => 'جارى إعادة إلحاق التعديلات... تم',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'maintenance' => 'Запуск скрыптоў падтрымкі',
	'maintenance-desc' => '[[Special:Maintenance|Вікі-інтэрфэйс]] для розных скрыптоў падтрымкі',
	'right-maintenance' => 'запуск скрыптоў падтрымкі праз [[Special:Maintenance]]',
	'maintenance-backlink' => 'Вярнуцца ў выбар скрыптоў',
	'maintenance-header' => 'Калі ласка, выберыце скрыпт для запуску.
Апісаньне знаходзіцца каля кожнага скрыпта',
	'maintenance-changePassword-desc' => 'Зьмяніць пароль удзельніка',
	'maintenance-createAndPromote-desc' => 'Стварыць удзельнікам з правамі адміністратара',
	'maintenance-deleteBatch-desc' => 'Масавае выдаленьне старонак',
	'maintenance-deleteRevision-desc' => 'Выдаліць вэрсіі старонак з базы зьвестак',
	'maintenance-eval-desc' => 'Праверыць РНР код у асяродзьдзі MediaWiki',
	'maintenance-initEditCount-desc' => 'Пералічыць колькасьць рэдагаваньняў удзельнікаў',
	'maintenance-initStats-desc' => 'Пералічыць статыстыку сайта',
	'maintenance-moveBatch-desc' => 'Масавы перанос старонак',
	'maintenance-reassignEdits-desc' => 'Пераназначыць рэдагаваньні ад аднаго ўдзельніка да іншага',
	'maintenance-runJobs-desc' => 'Выканаць заданьні з чаргі заданьняў',
	'maintenance-showJobs-desc' => 'Паказаць сьпіс заданьняў з чаргі заданьняў',
	'maintenance-sql-desc' => 'Выканаць SQL-запыт',
	'maintenance-stats-desc' => 'Паказаць статыстыку Memcached',
	'maintenance-changePassword' => 'Выкарыстоўвайце гэтую форму для зьмены паролю ўдзельніка',
	'maintenance-createAndPromote' => 'Выкарыстоўвайце гэтую форму для стварэньня новага ўдзельніка з правамі адміністратара.
Пазначце поле ніжэй, каб зрабіць яго бюракратам',
	'maintenance-deleteBatch' => 'Выкарыстоўвайце гэтую форму для масавага выдаленьня старонак.
Пастаўце толькі адну назву старонкі ў кожны радок',
	'maintenance-deleteRevision' => 'Выкарыстоўвайце гэтую форму для масавага выдаленьня вэрсіяў старонак.
Пастаўце толькі адну вэрсію ў кожны радок',
	'maintenance-initStats' => 'Выкарыстоўвайце гэтую форму для перападліку статыстыкі сайта. Пазначце, калі Вы таксама жадаеце перападлічыць прагляд старонак',
	'maintenance-moveBatch' => 'Выкарыстоўвайце гэтую форму для масавага пераносу старонак.
У кожным радку павінна быць крынічная старонка і мэтавая старонка, падзеленыя сымбалем «|»',
	'maintenance-invalidtype' => 'Няслушны тып!',
	'maintenance-name' => 'Імя ўдзельніка',
	'maintenance-password' => 'Пароль',
	'maintenance-bureaucrat' => 'Надаць удзельніку статус бюракрата',
	'maintenance-reason' => 'Прычына',
	'maintenance-update' => 'Выкарыстоўвайце UPDATE для абнаўленьня табліцы? Паспрабуйце выкарыстоўваць замест гэтага DELETE/INSERT.',
	'maintenance-noviews' => 'Пазначце гэта, каб не абнаўляць колькасьць праглядаў старонак',
	'maintenance-confirm' => 'Пацьвердзіць',
	'maintenance-invalidname' => 'Няслушнае імя ўдзельніка!',
	'maintenance-success' => '$1 пасьпяхова запушчаны!',
	'maintenance-userexists' => 'Удзельнік ужо існуе!',
	'maintenance-invalidtitle' => 'Няслушная назва «$1»!',
	'maintenance-titlenoexist' => 'Пазначаная назва («$1») не існуе!',
	'maintenance-failed' => 'НЕ АТРЫМАЛАСЯ',
	'maintenance-deleted' => 'ВЫДАЛЕНА',
	'maintenance-revdelete' => 'Выдаленьне {{PLURAL:$3|вэрсіі|вэрсіяў}} $1 з вікі $2',
	'maintenance-revnotfound' => 'Вэрсія $1 ня знойдзена!',
	'maintenance-sql' => 'Выкарыстоўвайце гэтую форму для выкананьня SQL-запыту ў базе зьвестак.',
	'maintenance-sql-aff' => 'Закранутыя радкі: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|Вернуты $1 радок|Вернутыя $1 радкі|Вернутыя $1 радкоў}}:
$2',
	'maintenance-stats-edits' => 'Колькасьць рэдагаваньняў: $1',
	'maintenance-stats-articles' => 'Колькасьць старонак у асноўнай прасторы назваў: $1',
	'maintenance-stats-pages' => 'Колькасьць старонак: $1',
	'maintenance-stats-users' => 'Колькасьць удзельнікаў: $1',
	'maintenance-stats-admins' => 'Колькасьць адміністратараў: $1',
	'maintenance-stats-images' => 'Колькасьць файлаў: $1',
	'maintenance-stats-views' => 'Колькасьць праглядаў старонак: $1',
	'maintenance-stats-update' => 'Абнаўленьня базы зьвестак...',
	'maintenance-move' => 'Перанос $1 у $2...',
	'maintenance-movefail' => 'Узьнікла памылка пад час пераносу: $1.
Перанос адменены',
	'maintenance-error' => 'Памылка: $1',
	'maintenance-memc-fake' => 'Вы запусьцілі FakeMemCachedClient. Немагчыма атрымаць ніякай статыстыкі',
	'maintenance-memc-requests' => 'Запыты',
	'maintenance-memc-withsession' => 'з сэансам:',
	'maintenance-memc-withoutsession' => 'без сэансу:',
	'maintenance-memc-total' => 'усяго:',
	'maintenance-memc-parsercache' => 'Кэш парсэра',
	'maintenance-memc-hits' => 'трапляньняў:',
	'maintenance-memc-invalid' => 'няслушных:',
	'maintenance-memc-expired' => 'састарэўшых:',
	'maintenance-memc-absent' => 'адсутнічае:',
	'maintenance-memc-stub' => 'памер накіду:',
	'maintenance-memc-imagecache' => 'Кэш выяваў',
	'maintenance-memc-misses' => 'не трапіла:',
	'maintenance-memc-updates' => 'абнаўленьняў:',
	'maintenance-memc-uncacheable' => 'некэшаваных:',
	'maintenance-memc-diffcache' => 'Кэш параўнаньняў вэрсіяў',
	'maintenance-eval' => 'Выкарыстоўвайце гэтую форму для тэставаньня PHP-коду ў асяродзьдзі MediaWiki.',
	'maintenance-reassignEdits' => 'Выкарыстоўвайце гэтую форму для перадачы рэдагаваньняў ад аднаго ўдзельніка да іншага.',
	'maintenance-re-from' => 'Імя ўдзельніка для перадачы рэдагаваньняў да іншага',
	'maintenance-re-to' => 'Імя ўдзельніка для перадачы рэдагаваньняў ад іншага',
	'maintenance-re-force' => 'Перадаць, нават калі мэтавы ўдзельнік не існуе',
	'maintenance-re-rc' => 'Не абнаўляць табліцу апошніх зьменаў',
	'maintenance-re-report' => 'Вывесьці падрабязнасьці пра тое, што павінна быць зьменена, але без абнаўленьня',
	'maintenance-re-nf' => '{{GENDER:$1|Удзельнік $1 ня знойдзены|Удзельніца $1 ня знойдзеная}}',
	'maintenance-re-rr' => 'Зноў запусьціць скрыпт без «$1» для абнаўленьня.',
	'maintenance-re-ce' => 'Цяперашнія рэдагаваньні: $1',
	'maintenance-re-de' => 'Выдаленыя рэдагаваньні: $1',
	'maintenance-re-rce' => 'Запісы апошніх зьменаў: $1',
	'maintenance-re-total' => 'Усяго элемэнтаў для зьмены: $1',
	'maintenance-re-re' => 'Перадача рэдагаваньняў... выкананая',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'maintenance' => 'Пускане на скриптове за поддръжка',
	'maintenance-desc' => '[[Special:Maintenance|Уеб интерфейс]] за различни скриптове за поддръжка',
	'maintenance-backlink' => 'Връщане към избора на скрипт',
	'maintenance-changePassword-desc' => 'Променяне на потребителска парола',
	'maintenance-createAndPromote-desc' => 'Създаване на потребител и даване на администраторски права',
	'maintenance-deleteBatch-desc' => 'Масово изтриване на страници',
	'maintenance-deleteRevision-desc' => 'Премахване на версии от базата от данни',
	'maintenance-initEditCount-desc' => 'Преизчисляване на броя редакции, направени от потребителите',
	'maintenance-initStats-desc' => 'Опресняване на статистиките на сайта',
	'maintenance-moveBatch-desc' => 'Масово преместване на страници',
	'maintenance-changePassword' => 'Формулярът по-долу се използва за промяна на паролата на потребител',
	'maintenance-createAndPromote' => 'Следният формуляр служи за създаване на нов потребител и предоставянето му на администраторски права.
Поставянето на отметка ще добави и права на бюрократ.',
	'maintenance-deleteBatch' => 'Този формуляр служи за масово изтриване на страници.
Всеки ред трябва да съдържа по една страница',
	'maintenance-deleteRevision' => 'Този формуляр служи за масово изтриване на версии.
Всеки ред трябва да съдържа по един номер на версия',
	'maintenance-moveBatch' => 'Този формуляр служи за масово преместване на страници.
Всеки ред трябва да съдържа основна страница и целева страница, разделени с отвесна черта',
	'maintenance-invalidtype' => 'Невалиден тип!',
	'maintenance-name' => 'Потребителско име',
	'maintenance-password' => 'Парола',
	'maintenance-bureaucrat' => 'Предоставяне на права на бюрократ',
	'maintenance-reason' => 'Причина',
	'maintenance-update' => 'Използване на UPDATE при обновяване на таблиците? Без отметка се използва DELETE/INSERT.',
	'maintenance-noviews' => 'Поставянето на отметка ще спре обновяването на броя прегледи на страниците',
	'maintenance-confirm' => 'Потвърждаване',
	'maintenance-invalidname' => 'Невалидно потребителско име!',
	'maintenance-success' => '$1 беше изпълнен успешно!',
	'maintenance-userexists' => 'Този потребител вече съществува!',
	'maintenance-invalidtitle' => 'Невалидно заглавие „$1“!',
	'maintenance-titlenoexist' => 'Посоченото заглавие („$1“) не съществува!',
	'maintenance-revdelete' => 'Изтриване на версии $1 от уики $2',
	'maintenance-revnotfound' => 'Версия $1 не беше намерена!',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|върнат ред|върнати реда}}:
$2',
	'maintenance-stats-edits' => 'Брой редакции: $1',
	'maintenance-stats-articles' => 'Брой страници в основното именно пространство: $1',
	'maintenance-stats-pages' => 'Брой страници: $1',
	'maintenance-stats-users' => 'Брой потребители: $1',
	'maintenance-stats-admins' => 'Брой администратори: $1',
	'maintenance-stats-images' => 'Брой файлове: $1',
	'maintenance-stats-views' => 'Брой прегледи на страниците: $1',
	'maintenance-stats-update' => 'Обновяване на базата от данни...',
	'maintenance-move' => 'Преместване на $1 като $2...',
	'maintenance-movefail' => 'Възникна грешка при преместване: $1.
Прекратяване на преместването.',
	'maintenance-error' => 'Грешка: $1',
	'maintenance-memc-requests' => 'Заявки',
	'maintenance-memc-withsession' => 'със сесия:',
	'maintenance-memc-withoutsession' => 'без сесия:',
	'maintenance-memc-total' => 'общо:',
	'maintenance-re-ce' => 'Текущи редакции: $1',
	'maintenance-re-de' => 'Изтрити редакции: $1',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'maintenance-changePassword-desc' => 'Cheñch ger-tremen un implijer',
	'maintenance-deleteBatch-desc' => "Dilemel pajennoù a-yoc'h",
	'maintenance-deleteRevision-desc' => 'Lemel adweladennoù eus an diaz roadennoù',
	'maintenance-initStats-desc' => "Adjediñ stadegoù al lec'hienn",
	'maintenance-moveBatch-desc' => "Dilec'hiañ pajennoù a-yoc'h",
	'maintenance-sql-desc' => 'Seveniñ ur reked SQL',
	'maintenance-stats-desc' => 'Diskouez stadegoù ar grubuilh',
	'maintenance-changePassword' => 'Implijout ar furmskrid-mañ da cheñch ger-tremen un implijer',
	'maintenance-deleteBatch' => 'Implijit ar furmskrid-mañ da zilemel pajennoù a-zruilh.
Lakait ur bajenn hepken dre linenn',
	'maintenance-invalidtype' => 'Seurt direizh !',
	'maintenance-name' => 'Anv implijer',
	'maintenance-password' => 'Ger-tremen',
	'maintenance-reason' => 'Abeg',
	'maintenance-confirm' => 'Kadarnaat',
	'maintenance-invalidname' => 'Anv implijer fall !',
	'maintenance-success' => '$1 a zo bet mat !',
	'maintenance-userexists' => 'An implijer zo anezhañ dija !',
	'maintenance-invalidtitle' => 'Titl fall "$1" !',
	'maintenance-titlenoexist' => 'N\'eus ket eus an titl bet lakaet ("$1") !',
	'maintenance-failed' => "C'HWITET",
	'maintenance-deleted' => 'DILAMET',
	'maintenance-revdelete' => 'Dilemel an {{PLURAL:$3|adweladenn|adweladennoù}} $1 eus ar wiki $2',
	'maintenance-revnotfound' => "N'eo ket bet adkavet an adweladenn $1 !",
	'maintenance-sql' => 'Implijout ar furmskrid-mañ da seveniñ ur reked SQL war an diaz roadennoù.',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|linenn|linenn}} adkaset:
$2',
	'maintenance-stats-edits' => 'Niver a gemmoù : $1',
	'maintenance-stats-articles' => "Niver a bajennoù el lec'h pennañ : $1",
	'maintenance-stats-pages' => 'Niver a bajennoù : $1',
	'maintenance-stats-users' => 'Niver a implijerien : $1',
	'maintenance-stats-admins' => 'Niver a verourien : $1',
	'maintenance-stats-images' => 'Niver a restroù : $1',
	'maintenance-stats-views' => 'Niver a bajennoù gweladennet : $1',
	'maintenance-stats-update' => "Oc'h hizivaat an diaz roadennoù{{int:ellipsis}}",
	'maintenance-move' => "Dilec'hiañ $1 da $2{{int:ellipsis}}",
	'maintenance-error' => 'Fazi : $1',
	'maintenance-memc-requests' => 'Rekedoù',
	'maintenance-memc-withsession' => 'gant ur gont :',
	'maintenance-memc-withoutsession' => 'hep ar gont :',
	'maintenance-memc-total' => 'hollad :',
	'maintenance-memc-invalid' => 'direizh :',
	'maintenance-memc-expired' => 'aet diwar termen :',
	'maintenance-memc-absent' => 'ezvezant :',
	'maintenance-memc-misses' => 'kollet :',
	'maintenance-memc-updates' => 'hizivadennoù :',
	'maintenance-re-rc' => "Chom hep hizivaat taolenn ar c'hemmoù nevez",
	'maintenance-re-nf' => "An implijer $1 n'eo ket bet kavet",
	'maintenance-re-ce' => 'Kemmoù a-vremañ : $1',
	'maintenance-re-de' => 'Aozadennoù dilamet : $1',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'maintenance' => 'Pokretanje skripti za održavanje',
	'maintenance-desc' => '[[Special:Maintenance|Web interfejs]] za razne skripte održavanja',
	'right-maintenance' => 'Pokretanje skripti održavanja preko [[Special:Maintenance]]',
	'maintenance-backlink' => 'Nazad na odabir skripte',
	'maintenance-header' => 'Molimo odaberite skriptu za izvršenje ispod.
Opisi su navedeni pored svake skripte',
	'maintenance-changePassword-desc' => 'Promjena korisničke šifre',
	'maintenance-createAndPromote-desc' => 'Napravi korisnika i unaprijedi ga u status administratora',
	'maintenance-deleteBatch-desc' => 'Masovno brisanje stranica',
	'maintenance-deleteRevision-desc' => 'Ukloni revizije iz baze podataka',
	'maintenance-eval-desc' => 'Ocijenjivanje PHP koda u MediaWiki okruženju',
	'maintenance-initEditCount-desc' => 'Ponovno preračunaj broj izmjena korisnika',
	'maintenance-initStats-desc' => 'Ponovno izračunavanje statistike sajta',
	'maintenance-moveBatch-desc' => 'Masovno premještanje stranica',
	'maintenance-reassignEdits-desc' => 'Prerasporedi izmjene od jednog korisnika drugom',
	'maintenance-runJobs-desc' => 'Pokreni poslove koji čekaju u redu',
	'maintenance-showJobs-desc' => 'Pokaži spisak poslova koji čekaju na izvršenje',
	'maintenance-sql-desc' => 'Izvrši SQL zahtjev',
	'maintenance-stats-desc' => 'Prikaži Memcached statistike',
	'maintenance-changePassword' => 'Koristi ovaj obrazac za promjenu šifre korisnika',
	'maintenance-createAndPromote' => 'Koristite ovaj obrazac za pravljenje novog korisnika i njegovo postavljanje kao administratora.
Označite kutiju birokrata ako želite da ga unaprijedite i u birokratu',
	'maintenance-deleteBatch' => 'Koristite ovaj obrazac za masovno brisanje stranica.
Stavite po jednu stranicu u svaki red',
	'maintenance-deleteRevision' => 'Koristite ovaj obrazac za masovno brisanje revizija.
Stavite samo jedan broj revizije u jedan red',
	'maintenance-initStats' => 'Koristite ovaj obrazac za ponovo računanje statistika sajta, navodeći da li želite i ponovo računanje pregleda stranice',
	'maintenance-moveBatch' => 'Koristite ovaj obrazac za masovno premještanje stranica.
Svaka linija treba navesti izvornu stranicu i odredišnu stranicu razdvojene uspravnom linijom',
	'maintenance-invalidtype' => 'Nevaljan tip!',
	'maintenance-name' => 'Korisničko ime',
	'maintenance-password' => 'Šifra',
	'maintenance-bureaucrat' => 'Unaprijedi korisnika u birokratu',
	'maintenance-reason' => 'Razlog',
	'maintenance-update' => 'Koristite UPDATE kada ažurirate tabelu? Umjesto toga ukloni upotrebu DELETE/INSERT.',
	'maintenance-noviews' => 'Odaberite ovo za prevenciju ažuriranja broja pogleda na stranicu',
	'maintenance-confirm' => 'Potvrdi',
	'maintenance-invalidname' => 'Nevaljano korisničko ime!',
	'maintenance-success' => '$1 je bio pokrenut uspješno!',
	'maintenance-userexists' => 'Korisnik već postoji!',
	'maintenance-invalidtitle' => 'Nevaljan naslov "$1"!',
	'maintenance-titlenoexist' => 'Navedeni naslov ("$1") ne postoji!',
	'maintenance-failed' => 'NEUSPJELO',
	'maintenance-deleted' => 'OBRISANO',
	'maintenance-revdelete' => 'Brisanje {{PLURAL:$3|revizije|revizija}} $1 iz wikija $2',
	'maintenance-revnotfound' => 'Revizija $1 nije pronađena!',
	'maintenance-sql' => 'Koristite ovaj obrazac za izvršavanje SQL upita u bazi podataka.',
	'maintenance-sql-aff' => 'Zahvaćeni redovi: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|red zahvaćen|reda zahvaćena|redova zahvaćeno}}:
$2',
	'maintenance-stats-edits' => 'Broj uređivanja: $1',
	'maintenance-stats-articles' => 'Broj stranica u glavnom imenskom prostoru: $1',
	'maintenance-stats-pages' => 'Broj stranica: $1',
	'maintenance-stats-users' => 'Broj korisnika: $1',
	'maintenance-stats-admins' => 'Broj administratora: $1',
	'maintenance-stats-images' => 'Broj datoteka: $1',
	'maintenance-stats-views' => 'Broj pregleda stranica: $1',
	'maintenance-stats-update' => 'Ažuriranje baze podataka...',
	'maintenance-move' => 'Premještam $1 na $2...',
	'maintenance-movefail' => 'Greška se desila pri premještanju: $1.
Odustajem od premještanja',
	'maintenance-error' => 'Greška: $1',
	'maintenance-memc-fake' => 'Vi koristite FakeMemCachedClient. Ne može se prikupiti statistika',
	'maintenance-memc-requests' => 'Zahtjevi',
	'maintenance-memc-withsession' => 'sa sesijom:',
	'maintenance-memc-withoutsession' => 'bez sesije:',
	'maintenance-memc-total' => 'ukupno:',
	'maintenance-memc-parsercache' => 'keš parsera',
	'maintenance-memc-hits' => 'pogodaka:',
	'maintenance-memc-invalid' => 'nevaljano:',
	'maintenance-memc-expired' => 'isteklo:',
	'maintenance-memc-absent' => 'otsutno:',
	'maintenance-memc-stub' => 'ograničenje stubova:',
	'maintenance-memc-imagecache' => 'Keš slike',
	'maintenance-memc-misses' => 'promašaji:',
	'maintenance-memc-updates' => 'ažuriranja:',
	'maintenance-memc-uncacheable' => 'ne može se keširati:',
	'maintenance-memc-diffcache' => 'Diff keš',
	'maintenance-eval' => 'Koristite ovaj obrazac za ocjenu PHP koda u MediaWiki okruženju.',
	'maintenance-reassignEdits' => 'Koristite ovaj obrazac za ponovno dodjeljivanje izmjena od jednog korisnika drugom.',
	'maintenance-re-from' => 'Ime korisnika s kojeg se oduzimaju izmjene',
	'maintenance-re-to' => 'Ime korisnika kojem se dodjeljuju izmjene',
	'maintenance-re-force' => 'Ponovo dodijeli čak i ako određeni korisnik ne postoji',
	'maintenance-re-rc' => 'Ne ažuriraj tabelu nedavnih izmjena',
	'maintenance-re-report' => 'štampanja detalja o tome šta bi se moglo izmijeniti, ali ih ne ažurira',
	'maintenance-re-nf' => '{{GENDER:$1|Korisnik|Korisnica}} $1 nije {{GENDER:$1|pronađen|pronađena}}',
	'maintenance-re-rr' => 'Pokrenite skriptu ponovno bez "$1" radi ažuriranja.',
	'maintenance-re-ce' => 'Trenutne izmjene: $1',
	'maintenance-re-de' => 'Obrisane izmjene: $1',
	'maintenance-re-rce' => 'Stavke nedavnih promjena: $1',
	'maintenance-re-total' => 'Ukupno stavki za izmjenu: $1',
	'maintenance-re-re' => 'Preraspoređivanje izmjena{{int:ellipsis}} završeno',
);

/** Catalan (Català)
 * @author Paucabot
 * @author Solde
 */
$messages['ca'] = array(
	'maintenance-changePassword-desc' => "Canvia la contrasenya d'un usuari",
	'maintenance-deleteBatch-desc' => 'Eliminació massiva de pàgines',
	'maintenance-reason' => 'Motiu',
	'maintenance-confirm' => 'Confirma',
	'maintenance-invalidname' => "Nom d'usuari no vàlid!",
	'maintenance-deleted' => 'ELIMINAT',
	'maintenance-stats-edits' => "Nombre d'edicions: $1",
	'maintenance-stats-pages' => 'Nombre de pàgines: $1',
	'maintenance-stats-users' => "Nombre d'usuaris: $1",
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'maintenance-name' => 'по́льꙃєватєлꙗ и́мѧ',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author DaSch
 * @author Imre
 * @author Leithian
 * @author MF-Warburg
 * @author Melancholie
 * @author MichaelFrey
 * @author Purodha
 * @author Raimond Spekking
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'maintenance' => 'Wartungsskript starten',
	'maintenance-desc' => '[[Special:Maintenance|Webinterface]] für verschiedene Wartungsskripte',
	'right-maintenance' => 'Wartungsskripte über [[Special:Maintenance]] starten',
	'maintenance-backlink' => 'Zurück zur Skript-Auswahl',
	'maintenance-header' => 'Bitte wähle ein Skript zur Ausführung aus.
Beschreibungen stehen neben jedem Skript.',
	'maintenance-changePassword-desc' => 'Passwort eines Benutzers ändern',
	'maintenance-createAndPromote-desc' => 'Erstellen eines Benutzerkontos und Vergabe des Administrator-Status',
	'maintenance-deleteBatch-desc' => 'Massenlöschung von Seiten',
	'maintenance-deleteRevision-desc' => 'Versionen aus der Datenbank entfernen',
	'maintenance-eval-desc' => 'PHP-Code in der MediaWiki-Umgebung auswerten',
	'maintenance-initEditCount-desc' => 'Benutzerbeitragszähler eines Benutzers neu berechnen',
	'maintenance-initStats-desc' => 'Seitenstatistik neu berechnen',
	'maintenance-moveBatch-desc' => 'Massenverschiebung von Seiten',
	'maintenance-reassignEdits-desc' => 'Bearbeitungen eines Benutzers einem anderen zuweisen',
	'maintenance-runJobs-desc' => 'Aufträge in Warteschlange ausführen',
	'maintenance-showJobs-desc' => 'Liste der auf Abarbeitung wartenden Jobs in der Jobqueue',
	'maintenance-sql-desc' => 'Eine SQL-Abfrage ausführen',
	'maintenance-stats-desc' => 'Zeige Memcached-Statistik',
	'maintenance-changePassword' => 'Passwort eines Benutzers ändern',
	'maintenance-createAndPromote' => 'Verwende diese Maske, um einen neuen Benutzer zu erstellen und ihn zum Administrator zu ernennen.
Aktiviere die Bürokrat-Checkbox, wenn du ihn auch zum Bürokraten machen möchtest.',
	'maintenance-deleteBatch' => 'Verwende diese Maske, um viele Seiten zu löschen.
Schreibe nur eine Seite pro Zeile',
	'maintenance-deleteRevision' => 'Verwende diese Maske, um viele Versionen zu löschen.
Schreibe nur eine Versionsnummer pro Zeile',
	'maintenance-initStats' => 'Verwende diese Maske, um die Seitenstatistiken neu zu berechnen und gib dabei an, ob du auch die Seitenaufrufe neu berechnen möchtest.',
	'maintenance-moveBatch' => 'Verwende diese Maske, um viele Seiten zu verschieben.
Jede Zeile sollte eine Quellseite und eine Zielseite angeben, durch einen Senkrechtstrich getrennt',
	'maintenance-invalidtype' => 'Ungültiger Typ!',
	'maintenance-name' => 'Benutzername',
	'maintenance-password' => 'Passwort',
	'maintenance-bureaucrat' => 'Benutzer zum Bürokraten machen',
	'maintenance-reason' => 'Grund',
	'maintenance-update' => 'UPDATE zum Aktualisieren von Tabellen verwenden? Wenn nicht aktiviert, wird DELETE/INSERT verwendet.',
	'maintenance-noviews' => 'Aktualisierung des Seitenaufrufszählers deaktivieren',
	'maintenance-confirm' => 'Bestätigen',
	'maintenance-invalidname' => 'Ungültiger Benutzername!',
	'maintenance-success' => '$1 erfolgreich ausgeführt!',
	'maintenance-userexists' => 'Benutzer existiert bereits!',
	'maintenance-invalidtitle' => 'Ungültiger Titel „$1“!',
	'maintenance-titlenoexist' => 'Der angegebene Titel („$1“) existiert nicht!',
	'maintenance-failed' => 'Fehlgeschlagen',
	'maintenance-deleted' => 'GELÖSCHT',
	'maintenance-revdelete' => 'Lösche {{PLURAL:$3|Version|Versionen}} $1 von Wiki $2',
	'maintenance-revnotfound' => 'Version $1 nicht gefunden!',
	'maintenance-sql' => 'Verwende diese Maske, um eine SQL-Abfrage in der Datenbank auszuführen.',
	'maintenance-sql-aff' => 'Betroffene Zeilen: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|Zeile|Zeilen}} zurückgegeben:
$2',
	'maintenance-stats-edits' => 'Anzahl an Bearbeitungen: $1',
	'maintenance-stats-articles' => 'Anzahl von Seiten im Hauptnamensraum: $1',
	'maintenance-stats-pages' => 'Anzahl an Seiten: $1',
	'maintenance-stats-users' => 'Anzahl an Benutzern: $1',
	'maintenance-stats-admins' => 'Anzahl an Administratoren: $1',
	'maintenance-stats-images' => 'Anzahl an Dateien: $1',
	'maintenance-stats-views' => 'Anzahl an Seitenaufrufen: $1',
	'maintenance-stats-update' => 'Aktualisiere Datenbank …',
	'maintenance-move' => 'Verschiebe $1 nach $2 …',
	'maintenance-movefail' => 'Fehler beim Verschieben: $1
Verschieben abgebrochen',
	'maintenance-error' => 'Fehler: $1',
	'maintenance-memc-fake' => 'Du verwendest FakeMemCachedClient. Es sind keine Statistiken verfügbar',
	'maintenance-memc-requests' => 'Anfragen',
	'maintenance-memc-withsession' => 'mit Sitzung:',
	'maintenance-memc-withoutsession' => 'ohne Sitzung:',
	'maintenance-memc-total' => 'gesamt:',
	'maintenance-memc-parsercache' => 'Parser-Zwischenspeicher',
	'maintenance-memc-hits' => 'Treffer:',
	'maintenance-memc-invalid' => 'Ungültig:',
	'maintenance-memc-expired' => 'abgelaufen:',
	'maintenance-memc-absent' => 'abwesend:',
	'maintenance-memc-stub' => 'Stubgrenze:',
	'maintenance-memc-imagecache' => 'Bildercache',
	'maintenance-memc-misses' => 'Versäumnisse:',
	'maintenance-memc-updates' => 'Updates:',
	'maintenance-memc-uncacheable' => 'nicht cachebar:',
	'maintenance-memc-diffcache' => 'Diff-Zwischenspeicher',
	'maintenance-eval' => 'Benutze dieses Formular um PHP-Codes in MediaWiki auszuwerten.',
	'maintenance-reassignEdits' => 'Benutze diese Seite um Bearbeitungen eines Benutzers einem anderen zuzuweisen.',
	'maintenance-re-from' => 'Benutzer, dem die Bearbeitungen weggenommen werden sollen',
	'maintenance-re-to' => 'Benutzer, dem die Bearbeitungen zugewiesen werden sollen',
	'maintenance-re-force' => 'Auch neu zuweisen wenn der neue Benutzer nicht existiert',
	'maintenance-re-rc' => 'Datenbank-Tabelle Letzte Änderungen nicht aktualisieren',
	'maintenance-re-report' => 'Nichts ändern, nur zeigen, was geändert werden würde',
	'maintenance-re-nf' => 'Benutzer $1 nicht gefunden',
	'maintenance-re-rr' => 'Zum Neuzuweisen das Skript noch einmal ohne „$1“ laufen lassen.',
	'maintenance-re-ce' => 'Aktuelle Bearbeitungen: $1',
	'maintenance-re-de' => 'Gelöschte Bearbeitungen: $1',
	'maintenance-re-rce' => 'Einträge in den Letzten Änderungen: $1',
	'maintenance-re-total' => 'Zu ändernde Einträge: $1',
	'maintenance-re-re' => 'Neuzuordnung der Edits … erledigt',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 * @author Imre
 */
$messages['de-formal'] = array(
	'maintenance-header' => 'Bitte wählen Sie ein Skript zur Ausführung aus.
Beschreibungen stehen neben jedem Skript.',
	'maintenance-createAndPromote' => 'Verwenden Sie diese Maske, um einen neuen Benutzer zu erstellen und ihn zum Administrator zu ernennen.
Aktivieren Sie die Bürokrat-Checkbox, wenn Sie ihn auch zum Bürokraten machen möchten.',
	'maintenance-deleteBatch' => 'Verwenden Sie diese Maske, um viele Seiten zu löschen.
Schreiben Sie nur eine Seite pro Zeile',
	'maintenance-deleteRevision' => 'Verwenden Sie diese Maske, um viele Versionen zu löschen.
Schreiben Sie nur eine Versionsnummer pro Zeile',
	'maintenance-initStats' => 'Verwenden Sie diese Maske, um die Seitenstatistiken neu zu berechnen und geben Sie dabei an, ob Sie auch die Seitenaufrufe neu berechnen möchten.',
	'maintenance-moveBatch' => 'Verwenden Sie diese Maske, um viele Seiten zu verschieben.
Jede Zeile sollte eine Quellseite und eine Zielseite angeben, durch einen Senkrechtstrich getrennt',
	'maintenance-sql' => 'Verwenden Sie diese Maske, um eine SQL-Abfrage in der Datenbank auszuführen.',
	'maintenance-memc-fake' => 'Sie verwenden FakeMemCachedClient. Es sind keine Statistiken verfügbar',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'maintenance' => 'Wótwardowańske skripty wuwjasć',
	'maintenance-desc' => '[[Special:Maintenance|Wikijowy interfejs]] za wšake wótwardowańske skripty',
	'right-maintenance' => 'Wótwardowańske skripty pśez [[Special:Maintenance]] wuwjasć',
	'maintenance-backlink' => 'Slědk k wuběrkoju skriptow',
	'maintenance-header' => 'Pšosym wubjeŕ skript za wuwjaźenje.
Wopisanja su pódla wótpowědnego skripta.',
	'maintenance-changePassword-desc' => 'Gronidło wužywarja změniś',
	'maintenance-createAndPromote-desc' => 'Wužywarske konto napóraś a status administratora daś',
	'maintenance-deleteBatch-desc' => 'Boki z kopicami wulašowaś',
	'maintenance-deleteRevision-desc' => 'Wersije z datoweje banki wótpóraś',
	'maintenance-eval-desc' => 'PHP-kod we wokolinje MediaWiki wugódnośiś',
	'maintenance-initEditCount-desc' => 'Licenja změnow wužywarjow hyšći raz woblicyś',
	'maintenance-initStats-desc' => 'Statistika sedłow hyšći raz woblicyś',
	'maintenance-moveBatch-desc' => 'Boki z kopicami pśesunuś',
	'maintenance-reassignEdits-desc' => 'Změny jadnego wužywarja k drugemu znowego pśipokazaś',
	'maintenance-runJobs-desc' => 'Nadawki w rěźe cakajucych nadawkow wuwjasć',
	'maintenance-showJobs-desc' => 'Lisćinu nadawkow pokazaś, kótarež cakaju w rěźe nadawkow',
	'maintenance-sql-desc' => 'SQL_wótpšašanje wuwjasć',
	'maintenance-stats-desc' => 'Statistiku Memcached pokazaś',
	'maintenance-changePassword' => 'Wužyj toś ten formular, aby změnił gronidło wužywarja',
	'maintenance-createAndPromote' => 'Wužyj toś ten formular, aby napórał nowego wužywarja a pózwignuł jogo k administratoroju.
Markěruj běrokratowy kašćik, jolic coš jogo teke k běrokratoju pózwignuś.',
	'maintenance-deleteBatch' => 'Wužyj toś ten formular, aby lašował boki z kopicami.
Napiš jano jaden bok na smužku',
	'maintenance-deleteRevision' => 'Wužyj toś ten formular, aby lašował wersije z kopicami.
Napiš jano jaden wersijowy numer na smužku',
	'maintenance-initStats' => 'Wužyj toś ten formular, aby znowego woblicył statistiku sedła. Pódaj, lěc coš zwobraznjenja boka teke znowego woblicyś.',
	'maintenance-moveBatch' => 'Wužyj toś ten formular, aby pśesunuł boki z kopicami.
Kužda smužka by měła žrědłowy bok a celowy bok pódaś, kótrejž stej pśez znamješko rołka (|) wótźělonej',
	'maintenance-invalidtype' => 'Njepłaśiwy typ!',
	'maintenance-name' => 'Wužywarske mě',
	'maintenance-password' => 'Gronidło',
	'maintenance-bureaucrat' => 'Do statusa běrokrata pózwignuś',
	'maintenance-reason' => 'Pśicyna',
	'maintenance-update' => 'UPDATE za aktualizěrowanje tabele wužywaś? Jolic to njejo wubrane, DELETE/INSERT se wužywa.',
	'maintenance-noviews' => 'Wubjeŕ to, aby zajźował aktualizaciji licby zwobraznjenjow boka',
	'maintenance-confirm' => 'Wobkšuśiś',
	'maintenance-invalidname' => 'Njepłaśiwe wužywarske mě!',
	'maintenance-success' => '$1 wuspěšnje wuwjeźony!',
	'maintenance-userexists' => 'Wužywaŕ južo eksistěrujo!',
	'maintenance-invalidtitle' => 'Njepłaśiwy titel "$1"!',
	'maintenance-titlenoexist' => 'Pódany titel ("$1") njeeksistěrujo!',
	'maintenance-failed' => 'NJERAŹIŁO SE',
	'maintenance-deleted' => 'WULAŠOWANY',
	'maintenance-revdelete' => '{{PLURAL:$3|Lašujo se wersija|Lašujotej se wersiji|Lašuju se wersije|Lašuju se wersije}} $1 z wikija $2',
	'maintenance-revnotfound' => 'Wersija $1 njenamakana!',
	'maintenance-sql' => 'Wužyj toś ten formular, aby wuwjadł SQL-wótpšašanje w datowej bance.',
	'maintenance-sql-aff' => 'Pótrjefjone smužki: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|smužka wrośona|smužce wrośenej|smužki wrośone|smužkow wrośone}}:
$2',
	'maintenance-stats-edits' => 'Licba změnow: $1',
	'maintenance-stats-articles' => 'Licba bokow w głownem mjenjowem rumje: $1',
	'maintenance-stats-pages' => 'Licba bokow: $1',
	'maintenance-stats-users' => 'Licba wužywarjow: $1',
	'maintenance-stats-admins' => 'Licba administratorow: $1',
	'maintenance-stats-images' => 'Licba datajow: $1',
	'maintenance-stats-views' => 'Licba zwobraznjenjow bokow: $1',
	'maintenance-stats-update' => 'Datowa banka se aktualizěrujo{{int:ellipsis}}',
	'maintenance-move' => '$1 do $2 se pśesuwa{{int:ellipsis}}',
	'maintenance-movefail' => 'Zmólka pśi pśesuwanju: $1.
Pśesunjenje pśetergnjone',
	'maintenance-error' => 'Zmólka: $1',
	'maintenance-memc-fake' => 'Wuwjedujoš FakeMemCacheClient. Žedna statistika k dispoziciji.',
	'maintenance-memc-requests' => 'Napšašowanja',
	'maintenance-memc-withsession' => 'z pósejźenim:',
	'maintenance-memc-withoutsession' => 'bźez pósejźenja:',
	'maintenance-memc-total' => 'dogromady:',
	'maintenance-memc-parsercache' => 'Parserowy cache',
	'maintenance-memc-hits' => 'trjefarje:',
	'maintenance-memc-invalid' => 'njepłaśiwy:',
	'maintenance-memc-expired' => 'pśepadnjony:',
	'maintenance-memc-absent' => 'njepśibytny:',
	'maintenance-memc-stub' => 'zarodkowy prog:',
	'maintenance-memc-imagecache' => 'Cache wobrazow',
	'maintenance-memc-misses' => 'zmólenja:',
	'maintenance-memc-updates' => 'aktualizacije:',
	'maintenance-memc-uncacheable' => 'cache njedajo se wužywaś',
	'maintenance-memc-diffcache' => 'Cache rozdźělow',
	'maintenance-eval' => 'Wužyj toś ten formular, aby wugódnośił PHP-kod we wokolinje MediaWiki.',
	'maintenance-reassignEdits' => 'Wužyj toś ten formular, aby znowego pśipokazał změny wót jadnego wužywarja k drugemu wužywarjeju.',
	'maintenance-re-from' => 'Mě wužywarja, wót kótaregož změny maju se pśipokazaś',
	'maintenance-re-to' => 'Mě wužywarja, kótaremuž změny maju se pśipokazaś',
	'maintenance-re-force' => 'Znowego pśipokazaś, samo gaby celowy wužywaŕ njeeksistěrował',
	'maintenance-re-rc' => 'Tabelu aktualnych změnow njeaktualizěrowaś',
	'maintenance-re-report' => 'Drobnostki pokazaś, kótarež by se změnili, ale njeaktualizěruj',
	'maintenance-re-nf' => 'Wužywaŕ $1 njenamakany',
	'maintenance-re-rr' => 'Skript za aktualizaciju znowego bźez "$1" wuwjasć',
	'maintenance-re-ce' => 'Aktualne změny: $1',
	'maintenance-re-de' => 'Wulašowane změny: $1',
	'maintenance-re-rce' => 'Zapiski w aktualnych změnach: $1',
	'maintenance-re-total' => 'Wšykne zapiski, kótarež maju se změniś: $1',
	'maintenance-re-re' => 'Změny se znowego pśipokazuju{{int:ellipsis}} gótowe',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'maintenance-changePassword-desc' => 'Αλλαγή κωδικού ενός χρήστη',
	'maintenance-deleteBatch-desc' => 'Μαζική διαγραφή σελίδων',
	'maintenance-initStats-desc' => 'Επανυπολογισμός των στατιστικών του ιστοτόπου',
	'maintenance-moveBatch-desc' => 'Μαζική μετακίνηση σελίδων',
	'maintenance-sql-desc' => 'Εκτέλεση ενός αιτήματος SQL',
	'maintenance-invalidtype' => 'Μη έγκυρος τύπος!',
	'maintenance-name' => 'Όνομα χρήστη',
	'maintenance-password' => 'Κωδικός',
	'maintenance-bureaucrat' => 'Προαγωγή χρήστη σε γραφειοκράτη',
	'maintenance-reason' => 'Λόγος',
	'maintenance-confirm' => 'Επιβεβαίωση',
	'maintenance-invalidname' => 'Μη έγκυρο όνομα χρήστη!',
	'maintenance-success' => 'Το $1 έτρεξε επιτυχώς!',
	'maintenance-userexists' => 'Ο χρήστης υπάρχει ήδη!',
	'maintenance-invalidtitle' => 'Μη έγκυρος τίτλος "$1"!',
	'maintenance-titlenoexist' => 'Ο τίτλος που δόθηκε ("$1") δεν υπάρχει!',
	'maintenance-failed' => 'ΑΠΕΤΥΧΕ',
	'maintenance-deleted' => 'ΔΙΑΓΡΑΜΜΕΝΟΣ',
	'maintenance-revnotfound' => 'Η έκδοση $1 δεν βρέθηκε!',
	'maintenance-sql-aff' => 'Σειρές που επηρεάζονται: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|σειρά ήρθε|σειρές ήρθαν}}:
$2',
	'maintenance-stats-edits' => 'Αριθμός επεξεργασιών: $1',
	'maintenance-stats-articles' => 'Αριθμός σελίδων στην κύρια περιοχή: $1',
	'maintenance-stats-pages' => 'Αριθμός σελίδων: $1',
	'maintenance-stats-users' => 'Αριθμός χρηστών: $1',
	'maintenance-stats-admins' => 'Αριθμός διαχειριστών: $1',
	'maintenance-stats-images' => 'Αριθμός αρχείων: $1',
	'maintenance-stats-views' => 'Αριθμός προβολών σελίδων: $1',
	'maintenance-stats-update' => 'Ενημέρωση βάσης δεδομένων{{int:ellipsis}}',
	'maintenance-move' => 'Μετακίνηση $1 σε $2{{int:ellipsis}}',
	'maintenance-error' => 'Σφάλμα: $1',
	'maintenance-memc-requests' => 'Αιτήσεις',
	'maintenance-memc-withsession' => 'με σύνοδο:',
	'maintenance-memc-withoutsession' => 'χωρίς σύνοδο:',
	'maintenance-memc-total' => 'σύνολο:',
	'maintenance-memc-parsercache' => 'Λανθάνουσα λεξιαναλυτή',
	'maintenance-memc-hits' => 'χτυπήματα:',
	'maintenance-memc-invalid' => 'μη έγκυρο:',
	'maintenance-memc-expired' => 'ληγμένο:',
	'maintenance-memc-absent' => 'απών:',
	'maintenance-memc-imagecache' => 'Λανθάνουσα μνήμη εικόνας',
	'maintenance-memc-misses' => 'αστοχίες:',
	'maintenance-memc-updates' => 'αναβαθμίσεις:',
	'maintenance-memc-uncacheable' => 'χωρίς λανθάνουσα μνήμη:',
	'maintenance-memc-diffcache' => 'Λανθάνουσα μνήμη διαφορών',
	'maintenance-re-nf' => 'Ο χρήστης $1 δεν βρέθηκε',
	'maintenance-re-ce' => 'Τωρινές επεξεργασίες: $1',
	'maintenance-re-de' => 'Διαγραμμένες επεξεργασίες: $1',
	'maintenance-re-rce' => 'Καταχωρήσεις ΠροσφάτωνΑλλαγών: $1',
	'maintenance-re-total' => 'Συνολικές καταχωρήσεις για αλλαγή: $1',
	'maintenance-re-re' => 'Έγινε επανανάθεση επεξεργασιών{{int:ellipsis}}',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'maintenance-changePassword-desc' => 'Ŝangi pasvorton de uzanto',
	'maintenance-deleteBatch-desc' => 'Amasforigi paĝojn',
	'maintenance-initStats-desc' => 'Rekalkuli retejan statistikon',
	'maintenance-moveBatch-desc' => 'Amasmovi paĝojn',
	'maintenance-invalidtype' => 'Nevalida speco!',
	'maintenance-name' => 'Salutnomo',
	'maintenance-password' => 'Pasvorto',
	'maintenance-reason' => 'Kialo',
	'maintenance-confirm' => 'Konfirmi',
	'maintenance-invalidname' => 'Nevalida salutnomo!',
	'maintenance-success' => '$1 sukcesis!',
	'maintenance-userexists' => 'Uzanto jam ekzistas!',
	'maintenance-invalidtitle' => 'Nevalida titolo "$1"!',
	'maintenance-failed' => 'MALSUKCESIS',
	'maintenance-deleted' => 'FORIGITA',
	'maintenance-revdelete' => 'Forigante {{PLURAL:$3|version|versiojn}} $1 el vikio $2',
	'maintenance-revnotfound' => 'Revisio $1 ne estas trovita!',
	'maintenance-stats-edits' => 'Nombro de redaktoj: $1',
	'maintenance-stats-articles' => 'Nombro de paĝoj en la ĉefa nomspaco: $1',
	'maintenance-stats-pages' => 'Nombro de paĝoj: $1',
	'maintenance-stats-users' => 'Nombro de uzantoj: $1',
	'maintenance-stats-admins' => 'Nombro de administrantoj: $1',
	'maintenance-stats-images' => 'Nombro de dosieroj: $1',
	'maintenance-stats-views' => 'Nombro de paĝvidoj: $1',
	'maintenance-stats-update' => 'Ĝisdatigante datumbazon{{int:ellipsis}}',
	'maintenance-move' => 'Movante $1 al $2{{int:ellipsis}}',
	'maintenance-error' => 'Eraro: $1',
	'maintenance-memc-requests' => 'Petoj',
	'maintenance-memc-withsession' => 'kun seanco:',
	'maintenance-memc-withoutsession' => 'sen seanco:',
	'maintenance-memc-total' => 'sumo:',
	'maintenance-memc-parsercache' => 'Kaŝmemoro de sintaksa analizilo',
	'maintenance-memc-hits' => 'trafoj:',
	'maintenance-memc-invalid' => 'nevalida:',
	'maintenance-memc-imagecache' => 'Bilda memorkaŝujo',
	'maintenance-memc-misses' => 'maltrafoj:',
	'maintenance-memc-updates' => 'ĝisdatigoj:',
	'maintenance-memc-diffcache' => 'Diferenca Kaŝmemoro',
	'maintenance-re-ce' => 'Nunaj redaktoj: $1',
	'maintenance-re-de' => 'Forigitaj redaktoj: $1',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Locos epraix
 * @author Translationista
 */
$messages['es'] = array(
	'maintenance' => 'Ejecutar scripts de mantenimiento',
	'maintenance-desc' => '[[Special:Maintenance|Interfaz wiki]] para variados scripts de mantenimiento',
	'right-maintenance' => 'Ejecutar scripts de mantenimiento a través de [[Special:Maintenance]]',
	'maintenance-backlink' => 'Regresar a selección de escritura',
	'maintenance-header' => 'Por favor, seleccione el script de abajo para ejecutarlo.
Las descripciones están del lado de cada script',
	'maintenance-changePassword-desc' => 'Cambiar la contraseña de un usuario',
	'maintenance-createAndPromote-desc' => 'Crear un usuario y promoverlo al status de administrador',
	'maintenance-deleteBatch-desc' => 'Borrao masivo de páginas',
	'maintenance-deleteRevision-desc' => 'Remover revisiones de la base de datos',
	'maintenance-eval-desc' => 'Evaluar código PHP en ambiente MediaWiki',
	'maintenance-initEditCount-desc' => 'Recalcular los conteos de ediciones de los usuarios',
	'maintenance-initStats-desc' => 'Recalcular estadísticas del sitio',
	'maintenance-moveBatch-desc' => 'Movilización masiva de páginas',
	'maintenance-reassignEdits-desc' => 'Reasignar ediciones de un usuario a otro',
	'maintenance-runJobs-desc' => 'Ejecutar los trabajos de la cola de trabajos',
	'maintenance-showJobs-desc' => 'Mostrar un listado de trabajos pendientes en la cola de trabajo',
	'maintenance-sql-desc' => 'Ejecutar una consulta SQL',
	'maintenance-changePassword' => 'Utiliza este formulario para cambiar la contraseña de un usuario:',
	'maintenance-createAndPromote' => 'Usar este formulario para crear un nuevo usuario y promoverlo para administrador.
Verificar la tabla de burócrata si deseas promoverlo a burócrata también',
	'maintenance-deleteBatch' => 'Usar este formulario para borrado masivo de páginas.
Coloque solamente una página por línea',
	'maintenance-deleteRevision' => 'Usar este formulario para borrado masivo de revisiones.
Coloque solamente un número de revisión por línea',
	'maintenance-initStats' => 'Usar este formulario para recalcular estadísticas del sitio, especificando si deseas recalcular vistas de página también',
	'maintenance-moveBatch' => 'Use este formulario para mover páginas en masa.
Cada línea debería especificar una página fuente y página destino separadas por una barra (“|”)',
	'maintenance-invalidtype' => 'Tipo inválido!',
	'maintenance-name' => 'Nombre de usuario',
	'maintenance-password' => 'Contraseña',
	'maintenance-bureaucrat' => 'Promover usuario al status de burócrata',
	'maintenance-reason' => 'Motivo',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-invalidname' => 'Nombre de usuario inválido!',
	'maintenance-success' => '$1 se ejecutó con éxito!',
	'maintenance-userexists' => 'Usuario ya existe!',
	'maintenance-invalidtitle' => 'Título inválido "$1"!',
	'maintenance-titlenoexist' => 'Título especificado ("$1") no existe!',
	'maintenance-failed' => 'FALLADO',
	'maintenance-deleted' => 'BORRADO',
	'maintenance-revdelete' => 'Borrando {{PLURAL:$3|revisión|revisiones}} $1 del wiki $2',
	'maintenance-revnotfound' => 'Revisión $1 no encontrada!',
	'maintenance-sql' => 'Utilizar este formulario para ejecutar una consulta SQL en la base de datos.',
	'maintenance-sql-aff' => 'Filas afectadas: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|fila|filas}} retornadas:
$2',
	'maintenance-stats-edits' => 'Número de ediciones: $1',
	'maintenance-stats-articles' => 'Número de páginas en el espacio de nombre principal: $1',
	'maintenance-stats-pages' => 'Número de páginas: $1',
	'maintenance-stats-users' => 'Número de usuarios: $1',
	'maintenance-stats-admins' => 'Número de administradores: $1',
	'maintenance-stats-images' => 'Número de archivos: $1',
	'maintenance-stats-views' => 'Número de vistas de página: $1',
	'maintenance-stats-update' => 'Actualizando base de datos...',
	'maintenance-move' => 'Moviendo $1 a $2...',
	'maintenance-error' => 'Error: $1',
	'maintenance-memc-fake' => 'Estás ejecutando FakeMemCachedClient. Estadísticas no pueden ser proveídas',
	'maintenance-memc-requests' => 'Solicitudes',
	'maintenance-memc-withsession' => 'Con sesión:',
	'maintenance-memc-withoutsession' => 'sin sesión:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Cache de analizador',
	'maintenance-memc-hits' => 'resultados:',
	'maintenance-memc-invalid' => 'inválido:',
	'maintenance-memc-expired' => 'expirado:',
	'maintenance-memc-absent' => 'ausente:',
	'maintenance-memc-imagecache' => 'Cache de imagen',
	'maintenance-memc-misses' => 'fallos:',
	'maintenance-memc-updates' => 'actualizaciones:',
	'maintenance-memc-uncacheable' => 'no almacenable en caché:',
	'maintenance-memc-diffcache' => 'Caché de Dif',
	'maintenance-eval' => 'Utiliza este formulario para evaluar código PHP en ambiente MediaWiki.',
	'maintenance-reassignEdits' => 'Usar este formulario para reasignar ediciones de un usuario a otro.',
	'maintenance-re-from' => 'Nombre del usuario desde el cual se asigna ediciones',
	'maintenance-re-to' => 'Nombre del usuario a quien se asigna ediciones',
	'maintenance-re-force' => 'Reasignar incluso si el usuario de destino no existe',
	'maintenance-re-rc' => 'No actualizar la tabla de cambios recientes',
	'maintenance-re-report' => 'Imprimir los detalles de lo que cambiaría, pero no actualizar',
	'maintenance-re-nf' => 'Usuario $1 no encontrado',
	'maintenance-re-rr' => 'Ejecutar el script de nuevo sin actualizar "$1".',
	'maintenance-re-ce' => 'Ediciones actuales: $1',
	'maintenance-re-de' => 'Ediciones borradas: $1',
	'maintenance-re-rce' => 'Entradas de cambios recientes: $1',
	'maintenance-re-total' => 'Cantidad total de entradas a cambiar: $1',
);

/** Estonian (Eesti)
 * @author Silvar
 */
$messages['et'] = array(
	'maintenance-changePassword-desc' => 'Muuda kasutajate paroole',
	'maintenance-deleteBatch-desc' => 'Lehekülgede lauskustutamine',
	'maintenance-invalidtype' => 'Vigane tüüp!',
	'maintenance-name' => 'Kasutajanimi',
	'maintenance-password' => 'Parool',
	'maintenance-bureaucrat' => 'Eduta kasutajat bürokraadi staatusesse',
	'maintenance-reason' => 'Põhjus',
	'maintenance-deleted' => 'KUSTUTATUD',
	'maintenance-re-nf' => 'Kasutajat $1 ei leidnud',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'maintenance-name' => 'Lankide izena',
	'maintenance-password' => 'Pasahitza',
	'maintenance-bureaucrat' => 'Lankidea burokrata bihurtu',
	'maintenance-reason' => 'Arrazoia',
	'maintenance-confirm' => 'Baieztatu',
	'maintenance-invalidname' => 'Lankide izen okerra!',
	'maintenance-deleted' => 'EZABATUA',
	'maintenance-memc-total' => 'guztira:',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Jack Phoenix
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 * @author ZeiP
 */
$messages['fi'] = array(
	'maintenance' => 'Suorita ylläpitoskriptejä',
	'maintenance-desc' => '[[Special:Maintenance|Wikikäyttöliittymä]] muutamille wikin ylläpitoon tarkoitetuille komentosarjoille.',
	'right-maintenance' => 'Ajaa ylläpitotyökaluita toimintosivun [[Special:Maintenance]] kautta',
	'maintenance-backlink' => 'Takaisin skriptin valintaan',
	'maintenance-header' => 'Valitse suoritettava skripti alapuolelta.
	Skriptien kuvaukset ovat niiden nimien vieressä',
	'maintenance-changePassword-desc' => 'Muuta käyttäjän salasana',
	'maintenance-createAndPromote-desc' => 'Luo käyttäjä ja lisää ylläpitäjäksi',
	'maintenance-deleteBatch-desc' => 'Massapoista sivuja',
	'maintenance-deleteRevision-desc' => 'Poista versioita tietokannasta',
	'maintenance-eval-desc' => 'Suorittaa PHP-koodia MediaWiki-ympäristössä.',
	'maintenance-initEditCount-desc' => 'Laske uudelleen käyttäjien muokkausmäärät',
	'maintenance-initStats-desc' => 'Laske sivuston tilastot uudelleen',
	'maintenance-moveBatch-desc' => 'Massasiirrä sivuja',
	'maintenance-reassignEdits-desc' => 'Määritä muokkauksia käyttäjältä toiselle',
	'maintenance-runJobs-desc' => 'Aja työt ohjelmiston ylläpitotyöjonosta',
	'maintenance-showJobs-desc' => 'Näytä lista töistä ylläpitotyöjonossa',
	'maintenance-sql-desc' => 'Suorita SQL-kysely',
	'maintenance-stats-desc' => 'Näytä Memcached-tilastot',
	'maintenance-changePassword' => 'Vaihda käyttäjän salasana tällä lomakkeella',
	'maintenance-createAndPromote' => 'Käytä tätä lomaketta luodaksesi uuden käyttäjän ja ylentääksesi hänet ylläpitäjäksi.
Laita myös rasti byrokraatti-laatikkoon jos haluat ylentää käyttäjän byrokraatiksi',
	'maintenance-deleteBatch' => 'Käytä tätä lomaketta sivujen massapoistamiseen.
Laita vain yhden sivun nimi riviä kohden',
	'maintenance-deleteRevision' => 'Käytä tätä lomaketta versioiden massapoistamiseen.
Laita vain yhden version numero riviä kohden',
	'maintenance-initStats' => 'Käytä tätä lomaketta sivuston tilastojen uudelleenlaskemiseen, määritellen myös, haluatko uudelleenlaskea sivujen näyttökerrat',
	'maintenance-moveBatch' => 'Käytä tätä lomaketta sivujen massasiirtoon.
Jokaisella rivillä tulisi olla lähdesivu ja kohdesivu pystyviivan erottamina',
	'maintenance-invalidtype' => 'Kelvoton tyyppi!',
	'maintenance-name' => 'Käyttäjätunnus',
	'maintenance-password' => 'Salasana',
	'maintenance-bureaucrat' => 'Ylennä käyttäjä byrokraatiksi',
	'maintenance-reason' => 'Syy',
	'maintenance-update' => 'Käytä UPDATE-lausekkeita taulua päivitettäessä? Jos tätä ei ole valittu, DELETE/INSERT-lausekkeita käytetään sen sijaan.',
	'maintenance-noviews' => 'Valitse tämä estääksesi sivujen näyttökertojen päivittämisen',
	'maintenance-confirm' => 'Vahvista',
	'maintenance-invalidname' => 'Virheellinen käyttäjätunnus.',
	'maintenance-success' => '$1 ajettiin onnistuneesti.',
	'maintenance-userexists' => 'Käyttäjä on jo olemassa.',
	'maintenance-invalidtitle' => 'Kelvoton otsikko "$1"!',
	'maintenance-titlenoexist' => 'Määritellyn otsikon ("$1") mukaista artikkelia ei ole olemassa!',
	'maintenance-failed' => 'EPÄONNISTUI',
	'maintenance-deleted' => 'POISTETTU',
	'maintenance-revdelete' => 'Poistetaan {{PLURAL:$3|versio|versiot}} $1 wikistä $2',
	'maintenance-revnotfound' => 'Versiota $1 ei löydy.',
	'maintenance-sql' => 'Tällä lomakkeella voit tehdä SQL-kyselyitä tietokannasta.',
	'maintenance-sql-aff' => 'Muutettuja rivejä: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|rivi|riviä}} palasi:
$2',
	'maintenance-stats-edits' => 'Muokkauksia yhteensä: $1',
	'maintenance-stats-articles' => 'Sivujen määrä päänimiavaruudessa: $1',
	'maintenance-stats-pages' => 'Sivuja yhteensä: $1',
	'maintenance-stats-users' => 'Käyttäjiä yhteensä: $1',
	'maintenance-stats-admins' => 'Ylläpitäjiä yhteensä: $1',
	'maintenance-stats-images' => 'Tiedostoja yhteensä: $1',
	'maintenance-stats-views' => 'Sivuja näytetty yhteensä: $1',
	'maintenance-stats-update' => 'Päivitetään tietokantaa{{int:ellipsis}}',
	'maintenance-move' => 'Siirretään $1 nimelle $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Tapahtui virhe siirrettäessä sivua: $1.
Keskeytetään siirto',
	'maintenance-error' => 'Virhe: $1',
	'maintenance-memc-fake' => 'Käytössä on FakeMemCachedClient. Tilastoja ei voida tarjota',
	'maintenance-memc-requests' => 'Pyynnöt',
	'maintenance-memc-withsession' => 'istunnon kera:',
	'maintenance-memc-withoutsession' => 'ilman istuntoa:',
	'maintenance-memc-total' => 'yhteensä:',
	'maintenance-memc-parsercache' => 'Jäsentimen välimuisti',
	'maintenance-memc-hits' => 'osumia:',
	'maintenance-memc-invalid' => 'kelvottomia:',
	'maintenance-memc-expired' => 'vanhentunut:',
	'maintenance-memc-absent' => 'poissa:',
	'maintenance-memc-stub' => 'tyngän raja:',
	'maintenance-memc-imagecache' => 'Kuvien välimuisti',
	'maintenance-memc-misses' => 'huteja:',
	'maintenance-memc-updates' => 'päivityksiä:',
	'maintenance-memc-uncacheable' => 'ei-välimuistitettava:',
	'maintenance-memc-diffcache' => 'Erolistausvälimuisti',
	'maintenance-eval' => 'Käytä tätä lomaketta PHP-koodin suorittamiseksi MediaWiki-ympäristössä.',
	'maintenance-reassignEdits' => 'Käytä tätä lomaketta määrittääksesi muokkauksen yhdeltä käyttäjältä toiselle.',
	'maintenance-re-from' => 'Sen käyttäjän nimi, jolta muokkaus otetaan',
	'maintenance-re-to' => 'Sen käyttäjän nimi, jolle muokkaus annetaan',
	'maintenance-re-force' => 'Määritä uudelleen, vaikka kohdekäyttäjää ei olisi olemassa',
	'maintenance-re-rc' => 'Älä päivitä tuoreet muutokset -taulua',
	'maintenance-re-report' => 'Tulosta tiedot siitä mitä muutettaisiin, mutta älä tee muutoksia',
	'maintenance-re-nf' => 'Käyttäjää $1 ei löydy',
	'maintenance-re-rr' => 'Aja komentosarja uudestaan ilman valintaa ”$1” tehdäksesi muutokset.',
	'maintenance-re-ce' => 'Nykyisiä muokkauksia: $1',
	'maintenance-re-de' => 'Poistettuja muokkauksia: $1',
	'maintenance-re-rce' => 'Tuoreiden muutosten tietueet: $1',
	'maintenance-re-total' => 'Yhteensä muutoksia: $1',
	'maintenance-re-re' => 'Määritetään uudestaan muokkauksia{{int:ellipsis}} valmis',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author PieRRoMaN
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'maintenance' => 'Lancer les scripts de maintenance',
	'maintenance-desc' => '[[Special:Maintenance|Interface Web]] pour divers scripts de maintenance',
	'right-maintenance' => 'Lancer des scripts de maintenance depuis [[Special:Maintenance]]',
	'maintenance-backlink' => 'Retour à la sélection du script',
	'maintenance-header' => 'Veuillez sélectionner, ci-dessous, un script à exécuter.
Les descriptions sont à la suite de chacun de ceux-ci.',
	'maintenance-changePassword-desc' => 'Changer le mot de passe d’un utilisateur',
	'maintenance-createAndPromote-desc' => 'Créer un utilisateur et promouvoir au statut d’administrateur',
	'maintenance-deleteBatch-desc' => 'Suppression de pages en masse',
	'maintenance-deleteRevision-desc' => 'Enlever des versions de la base de données',
	'maintenance-eval-desc' => 'Évaluer un code PHP dans l’environnement MediaWiki',
	'maintenance-initEditCount-desc' => 'Recalculer les compteurs de modifications des utilisateurs',
	'maintenance-initStats-desc' => 'Recalculer les statistiques du site',
	'maintenance-moveBatch-desc' => 'Renommage de pages en masse',
	'maintenance-reassignEdits-desc' => 'Réassigner des modifications d’un utilisateur vers un autre',
	'maintenance-runJobs-desc' => 'Lancer les tâches dans la liste de celles à accomplir',
	'maintenance-showJobs-desc' => 'Afficher une liste des tâches en cours dans la liste de celles à accomplir',
	'maintenance-sql-desc' => 'Exécuter une requête SQL',
	'maintenance-stats-desc' => 'Afficher les statistiques de la mémoire cache',
	'maintenance-changePassword' => 'Utiliser ce formulaire pour changer le mot de passe d’un utilisateur',
	'maintenance-createAndPromote' => 'Utiliser ce formulaire pour créer un nouvel utilisateur et le promouvoir administrateur.
Cocher la case bureaucrate si vous désirez lui conférer aussi ce statut.',
	'maintenance-deleteBatch' => 'Utilisez ce formulaire pour supprimer en masse des pages.
Indiquer une seule page par ligne.',
	'maintenance-deleteRevision' => 'Utilisez ce formulaire pour supprimer en masse des versions.
Indiquez une seule version par ligne.',
	'maintenance-initStats' => 'Utilisez ce formulaire pour recalculer les statistiques du site, en indiquant, le cas échéant, si vous désirez le recalcul du nombre de visites par page.',
	'maintenance-moveBatch' => 'Utilisez ce formulaire pour déplacer en masse des pages.
Chaque ligne devra indiquer la page d’origine et celle de destination, lesquelles devront être séparées par un « <nowiki>|</nowiki> »',
	'maintenance-invalidtype' => 'Type incorrect !',
	'maintenance-name' => 'Nom d’utilisateur',
	'maintenance-password' => 'Mot de passe',
	'maintenance-bureaucrat' => 'Promouvoir l’utilisateur au statut de bureaucrate',
	'maintenance-reason' => 'Motif',
	'maintenance-update' => 'Voulez-vous utiliser la méthode « UPDATE » pour la mise à jour directe d’une table ? Décochez l’option pour utiliser plutôt « DELETE / INSERT » (suppression puis réinsertion).',
	'maintenance-noviews' => 'Cocher ceci pour empêcher la mise à jour du nombre de visites des pages.',
	'maintenance-confirm' => 'Confirmer',
	'maintenance-invalidname' => 'Nom d’utilisateur incorrect !',
	'maintenance-success' => '$1 s’est déroulé avec succès !',
	'maintenance-userexists' => 'L’utilisateur existe déjà !',
	'maintenance-invalidtitle' => 'Titre incorrect « $1 » !',
	'maintenance-titlenoexist' => 'Le titre indiqué (« $1 ») n’existe pas !',
	'maintenance-failed' => 'ÉCHEC',
	'maintenance-deleted' => 'SUPPRIMÉ',
	'maintenance-revdelete' => 'Suppression {{PLURAL:$3|de la révision|des révisions}} $1 du wiki $2',
	'maintenance-revnotfound' => 'Version $1 introuvable !',
	'maintenance-sql' => 'Utilisez cette forme pour exécuter une requête SQL sur la base de données.',
	'maintenance-sql-aff' => 'Lignes affectées : $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|ligne renvoyée|lignes renvoyées}} :
$2',
	'maintenance-stats-edits' => 'Nombre de modifications : $1',
	'maintenance-stats-articles' => 'Nombre de pages dans l’espace principal : $1',
	'maintenance-stats-pages' => 'Nombre de pages : $1',
	'maintenance-stats-users' => 'Nombre d’utilisateurs : $1',
	'maintenance-stats-admins' => 'Nombre d’administrateurs : $1',
	'maintenance-stats-images' => 'Nombre de fichiers : $1',
	'maintenance-stats-views' => 'Nombre de pages visitées : $1',
	'maintenance-stats-update' => 'Mise à jour de la base de données{{int:ellipsis}}',
	'maintenance-move' => 'Déplacement de $1 vers $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Erreur survenue lors du renommage : $1.
Déplacement interrompu.',
	'maintenance-error' => 'Erreur : $1',
	'maintenance-memc-fake' => "Vous utilisez ''FakeMemCachedClient''. Aucune statistique ne sera fournie.",
	'maintenance-memc-requests' => 'Requêtes',
	'maintenance-memc-withsession' => 'avec la session :',
	'maintenance-memc-withoutsession' => 'sans la session :',
	'maintenance-memc-total' => 'total :',
	'maintenance-memc-parsercache' => 'Cache parseur',
	'maintenance-memc-hits' => 'clics :',
	'maintenance-memc-invalid' => 'incorrects :',
	'maintenance-memc-expired' => 'expirés :',
	'maintenance-memc-absent' => 'absents :',
	'maintenance-memc-stub' => 'seuil de départ :',
	'maintenance-memc-imagecache' => 'Cache image',
	'maintenance-memc-misses' => 'perdus :',
	'maintenance-memc-updates' => 'mis à jour :',
	'maintenance-memc-uncacheable' => 'hors cache :',
	'maintenance-memc-diffcache' => 'Cache des diff',
	'maintenance-eval' => 'Utilisez cette forme pour évaluer le code PHP dans un environnement MediaWiki.',
	'maintenance-reassignEdits' => 'Utilisez ce formulaire pour réassigner des modifications d’un utilisateur vers un autre.',
	'maintenance-re-from' => 'Nom de l’utilisateur à qui prendre les modifications',
	'maintenance-re-to' => 'Nom de l’utilisateur à qui assigner les modifications',
	'maintenance-re-force' => 'Réassigner même si l’utilisateur cible n’existe pas',
	'maintenance-re-rc' => 'Ne pas modifier la table des modifications récentes',
	'maintenance-re-report' => 'Afficher les détails de ce qui va être modifié, mais sans mettre à jour les données',
	'maintenance-re-nf' => 'L’utilisateur « $1 » n’a pas été trouvé',
	'maintenance-re-rr' => 'Lancer de nouveau le script sans mettre à jour « $1 ».',
	'maintenance-re-ce' => 'Modifications actuelles : $1.',
	'maintenance-re-de' => 'Modifications supprimées : $1',
	'maintenance-re-rce' => 'Entrées dans la table des modifications récentes : $1',
	'maintenance-re-total' => 'Nombre total de modifications à modifier : $1',
	'maintenance-re-re' => 'Réaffectation des modifications{{int:ellipsis}} fait',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 */
$messages['frp'] = array(
	'maintenance-reason' => 'Rêson',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-stats-pages' => 'Nombro de pâges : $1',
	'maintenance-stats-users' => 'Nombro d’utilisators : $1',
	'maintenance-stats-admins' => 'Nombro d’administrators : $1',
	'maintenance-stats-images' => 'Nombro de fichiérs : $1',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'maintenance-name' => 'Meidoggernamme',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'maintenance-reason' => 'Fáth',
	'maintenance-invalidname' => 'Ainm úsáideoir neamhbhailí!',
	'maintenance-invalidtitle' => 'Teideal neamhbhailí "$1"!',
	'maintenance-deleted' => 'SCRIOSTA',
	'maintenance-stats-pages' => 'Líon leathanaigh: $1',
	'maintenance-stats-users' => 'Líon úsáideoirí: $1',
	'maintenance-stats-admins' => 'Líon riarthóirí: $1',
	'maintenance-stats-images' => 'Líon comhaid: $1',
	'maintenance-error' => 'Earráid: $1',
	'maintenance-memc-requests' => 'Iarratais',
	'maintenance-memc-total' => 'iomlán:',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'maintenance' => 'Executar as escrituras de mantemento',
	'maintenance-desc' => '[[Special:Maintenance|Interface da web]] para diversas escrituras de mantemento',
	'right-maintenance' => 'Executar escrituras de mantemento mediante [[Special:Maintenance]]',
	'maintenance-backlink' => 'Voltar á selección de escrituras',
	'maintenance-header' => 'Por favor, seleccione a escritura de embaixo que queira executar.
As descricións están ao lado de cada escritura',
	'maintenance-changePassword-desc' => 'Cambiar o contrasinal dun usuario',
	'maintenance-createAndPromote-desc' => 'Crear un usuario e promovelo ao status de administrador',
	'maintenance-deleteBatch-desc' => 'Borrar páxinas masivamente',
	'maintenance-deleteRevision-desc' => 'Borrar revisións da base de datos',
	'maintenance-eval-desc' => 'Avaliar o código PHP no ambiente MediaWiki',
	'maintenance-initEditCount-desc' => 'Volver calcular o contador de edicións dos usuarios',
	'maintenance-initStats-desc' => 'Volver calcular as estatísticas do sitio',
	'maintenance-moveBatch-desc' => 'Mover páxinas masivamente',
	'maintenance-reassignEdits-desc' => 'Reasignar as edicións dun usuario a outro',
	'maintenance-runJobs-desc' => 'Executar os traballos na cola de traballo',
	'maintenance-showJobs-desc' => 'Amosar a lista dos traballos pendentes na cola de traballo',
	'maintenance-sql-desc' => 'Executar unha pescuda SQL',
	'maintenance-stats-desc' => 'Amosar as estatísticas da memoria caché',
	'maintenance-changePassword' => 'Use este formulario para cambiar o contrasinal dun usuario',
	'maintenance-createAndPromote' => 'Use este formulario para crear un novo usuario e promovelo ao status de administrador.
Comprobe a caixa de burócrata se quere tamén promovelo ao status de burócrata',
	'maintenance-deleteBatch' => 'Use este formulario para borrar revisións en masa.
Poña só unha páxina por liña',
	'maintenance-deleteRevision' => 'Use este formulario para borrar revisións en masa.
Poña só un número de revisión por liña',
	'maintenance-initStats' => 'Use este formulario para volver calcular as estatísticas do sitio, especificando se tamén quere calcular de novo as vistas por páxina',
	'maintenance-moveBatch' => 'Use este formulario para mover páxinas en masa.
Cada liña debería especificar unha fonte e destino da páxina separados por unha barra (“|”)',
	'maintenance-invalidtype' => 'Tipo inválido!',
	'maintenance-name' => 'Nome de usuario',
	'maintenance-password' => 'Contrasinal',
	'maintenance-bureaucrat' => 'Promover este usuario ao status de burócrata',
	'maintenance-reason' => 'Motivo',
	'maintenance-update' => 'Desexa usar ACTUALIZAR ao actualizar unha táboa? Se non marca a opción, usarase, no canto diso, BORRAR/INSERTAR.',
	'maintenance-noviews' => 'Comprove isto para previr a actualización do número de vistas por páxina',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-invalidname' => 'Nome de usuario inválido!',
	'maintenance-success' => '$1 executouse con éxito!',
	'maintenance-userexists' => 'O usuario xa existe!',
	'maintenance-invalidtitle' => 'Título inválido "$1"!',
	'maintenance-titlenoexist' => 'O título especificado ("$1") non existe!',
	'maintenance-failed' => 'FALLIDO',
	'maintenance-deleted' => 'BORRADO',
	'maintenance-revdelete' => 'Borrando {{PLURAL:$3|a revisión|as revisións}} $1 de $2',
	'maintenance-revnotfound' => 'A revisión $1 non foi atopada!',
	'maintenance-sql' => 'Use este formulario para executar unha pescuda SQL na base de datos.',
	'maintenance-sql-aff' => 'Ringleiras afectadas: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|Voltou unha ringleira|Voltaron $1 ringleiras}}:
$2',
	'maintenance-stats-edits' => 'Número de edicións: $1',
	'maintenance-stats-articles' => 'Número de páxinas no espazo de nomes principal: $1',
	'maintenance-stats-pages' => 'Número de páxinas: $1',
	'maintenance-stats-users' => 'Número de usuarios: $1',
	'maintenance-stats-admins' => 'Número de administradores: $1',
	'maintenance-stats-images' => 'Número de ficheiros: $1',
	'maintenance-stats-views' => 'Número de vistas por páxina: $1',
	'maintenance-stats-update' => 'Actualizando a base de datos{{int:ellipsis}}',
	'maintenance-move' => 'Movendo "$1" a "$2"{{int:ellipsis}}',
	'maintenance-movefail' => 'Produciuse un erro durante o movemento: $1.
Cancelando a operación',
	'maintenance-error' => 'Erro: $1',
	'maintenance-memc-fake' => 'Está executando FakeMemCachedClient. As estatísticas non poden ser amosadas',
	'maintenance-memc-requests' => 'Solicitudes',
	'maintenance-memc-withsession' => 'con sesión:',
	'maintenance-memc-withoutsession' => 'sen sesión:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Analizador da memoria caché',
	'maintenance-memc-hits' => 'éxitos:',
	'maintenance-memc-invalid' => 'inválido:',
	'maintenance-memc-expired' => 'remata:',
	'maintenance-memc-absent' => 'falta:',
	'maintenance-memc-stub' => 'bosquexo:',
	'maintenance-memc-imagecache' => 'Imaxe da memoria caché',
	'maintenance-memc-misses' => 'perdas:',
	'maintenance-memc-updates' => 'actualizacións:',
	'maintenance-memc-uncacheable' => 'non se pode comprobar a caché:',
	'maintenance-memc-diffcache' => 'Diferenza na memoria caché',
	'maintenance-eval' => 'Use este formulario para avaliar o código PHP no ambiente MediaWiki.',
	'maintenance-reassignEdits' => 'Use este formulario para reasignar as edicións dun usuario a outro.',
	'maintenance-re-from' => 'Nome do usuario do que coller as edicións',
	'maintenance-re-to' => 'Nome do usuario ao que asignar as edicións',
	'maintenance-re-force' => 'Reasignar incluso se o usuario non existe',
	'maintenance-re-rc' => 'Non actualizar a táboa de cambios recentes',
	'maintenance-re-report' => 'Imprimir os detalles do que será cambiado, pero non actualizalo',
	'maintenance-re-nf' => 'O usuario "$1" non foi atopado',
	'maintenance-re-rr' => 'Executar de novo a escritura sen "$1" para actualizar.',
	'maintenance-re-ce' => 'Edicións actuais: $1',
	'maintenance-re-de' => 'Edicións borradas: $1',
	'maintenance-re-rce' => 'Entradas nos Cambios recentes: $1',
	'maintenance-re-total' => 'Entradas totais a cambiar: $1',
	'maintenance-re-re' => 'Reasignando as edicións{{int:ellipsis}} feito',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'maintenance-name' => 'Ὄνομα χρωμένου',
	'maintenance-password' => 'Σύνθημα',
	'maintenance-reason' => 'Αἰτία',
	'maintenance-confirm' => 'Κυροῦν',
	'maintenance-failed' => 'ΑΠΕΤΕΥΧΘΗ',
	'maintenance-deleted' => 'ΔΙΕΓΡΑΦΗ',
	'maintenance-memc-requests' => 'Αἰτήσεις',
	'maintenance-memc-total' => 'συνολικόν:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'maintenance' => 'Wartigsskript starte',
	'maintenance-desc' => '[[Special:Maintenance|Webinterface]] fir verschideni Wartigsskript',
	'right-maintenance' => 'Start Wartigsskript iber [[Special:Maintenance]]',
	'maintenance-backlink' => 'Zrugg zue dr Skript-Uuswahl',
	'maintenance-header' => 'Bitte wehl e Skript uus, wu soll uusgfiert wäre.
Bschrybige stehn näbe jedem Skript.',
	'maintenance-changePassword-desc' => 'Passwort vun eme Benutzer ändere',
	'maintenance-createAndPromote-desc' => 'E Benutzerkonto aalege un Adminischtrator-Status vergee',
	'maintenance-deleteBatch-desc' => 'Masseleschig vu Syte',
	'maintenance-deleteRevision-desc' => 'Versionen us dr Datebank useneh',
	'maintenance-eval-desc' => 'PHP-Code in dr MediaWiki-Umgäbig uuswärte',
	'maintenance-initEditCount-desc' => 'Benutzerbyytragszeller vun eme Benutzers nej rächne',
	'maintenance-initStats-desc' => 'Sytestatischtik nej rächne',
	'maintenance-moveBatch-desc' => 'Masseverschiebig vu Syte',
	'maintenance-reassignEdits-desc' => 'Bearbeitige vun eme Benutzer eme andere zuewyyse',
	'maintenance-runJobs-desc' => 'Ufträg in dr Warteschlang uusfiere',
	'maintenance-showJobs-desc' => 'Lischt vu dr Ufträg in dr Warteschlang, wu no mien abgarbeitet wäre',
	'maintenance-sql-desc' => 'E SQL-Abfrog uusfiere',
	'maintenance-stats-desc' => 'Zeig Memcached-Statischtik',
	'maintenance-changePassword' => 'Passwort vun eme Benutzer ändere',
	'maintenance-createAndPromote' => 'Nimm die Maschke go ne neje Benutzer aazlege un e zuen eme Adminischtrator mache.
Aktivier d Bürokrat-Checkbox, wänn Du ne au zum Bürokrat witt mache.',
	'maintenance-deleteBatch' => 'Nimm die Maschke zum vil Syte z lesche.
Schryyb numen ei Syte pro Zyyle',
	'maintenance-deleteRevision' => 'Nimm die Maschke go vil Versione z lesche.
Schryb numen ei Versionsnummere pro Zyyle',
	'maintenance-initStats' => 'Nimm die Maschke go d Sytestatischtike nej z rächne un gib debyy aa, eb Du au d Syteufruef witt nej rächne.',
	'maintenance-moveBatch' => 'Nimm die Maschke go vil Syte verschiebe.
Jedi Zyyle sott e Quällsyten un e Ziilsyten aagee, dur e Sänkrächtstrich trännt',
	'maintenance-invalidtype' => 'Nit giltige Typ!',
	'maintenance-name' => 'Benutzername',
	'maintenance-password' => 'Passwort',
	'maintenance-bureaucrat' => 'Benutzer zum Bürokrat mache',
	'maintenance-reason' => 'Grund',
	'maintenance-update' => 'UPDATE zum Aktualisiere vu Tabälle neh? Wänn nit aktiviert, wird DELETE/INSERT bruucht.',
	'maintenance-noviews' => 'Aktualisierig vum Sytenufruefzeller deaktiviere',
	'maintenance-confirm' => 'Bstätige',
	'maintenance-invalidname' => 'Nit giltige Benutzername!',
	'maintenance-success' => '$1 erfolgrych uusgfiert!',
	'maintenance-userexists' => 'Benutzer git s scho!',
	'maintenance-invalidtitle' => 'Nit giltige Titel „$1“!',
	'maintenance-titlenoexist' => 'Dr Titel („$1“), wu Du aagee hesch, git s nit!',
	'maintenance-failed' => 'FÄHLGSCHLAA',
	'maintenance-deleted' => 'GLESCHT',
	'maintenance-revdelete' => '{{PLURAL:$3|Version|Versione}} $1 vu Wiki $2 lesche',
	'maintenance-revnotfound' => 'Version $1 nit gfunde!',
	'maintenance-sql' => 'Nimm die Maschke go ne SQL-Abfrog in dr Datebank uuszfiere.',
	'maintenance-sql-aff' => 'Zyyle, wu s trifft: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|Zyyle|Zyyle}} zrugggee:
$2',
	'maintenance-stats-edits' => 'Aazahl vu Bearbeitige: $1',
	'maintenance-stats-articles' => 'Aszahl vu Syten im Hauptnamensruum: $1',
	'maintenance-stats-pages' => 'Aszahl vu Syte: $1',
	'maintenance-stats-users' => 'Aazahl vu Benutzer: $1',
	'maintenance-stats-admins' => 'Aazahl vu Adminischtratore: $1',
	'maintenance-stats-images' => 'Aazahl vu Dateie: $1',
	'maintenance-stats-views' => 'Aazahl vu Sytenufruef: $1',
	'maintenance-stats-update' => 'Am Datebank aktualisiere ...',
	'maintenance-move' => 'Am $1 no $2 verschiebe …',
	'maintenance-movefail' => 'Fähler bim Verschiebe: $1
Verschieben abbroche',
	'maintenance-error' => 'Fähler: $1',
	'maintenance-memc-fake' => 'Du bruuchsch FakeMemCachedClient. S sin kei Statischtike verfiegbar',
	'maintenance-memc-requests' => 'Aafroge',
	'maintenance-memc-withsession' => 'mit Sitzig:',
	'maintenance-memc-withoutsession' => 'ohni Sitzig:',
	'maintenance-memc-total' => 'gsamt:',
	'maintenance-memc-parsercache' => 'Parser-Zwischespycher',
	'maintenance-memc-hits' => 'Träffer:',
	'maintenance-memc-invalid' => 'Nit giltig:',
	'maintenance-memc-expired' => 'abgloffe:',
	'maintenance-memc-absent' => 'nit do:',
	'maintenance-memc-stub' => 'Stumpegränz:',
	'maintenance-memc-imagecache' => 'Bildercache',
	'maintenance-memc-misses' => 'nonig gmacht:',
	'maintenance-memc-updates' => 'Update:',
	'maintenance-memc-uncacheable' => 'nit cachebar:',
	'maintenance-memc-diffcache' => 'Diff-Zwischespycher',
	'maintenance-eval' => 'Bruuch des Formular go PHP-Code in MediaWiki uuswärte.',
	'maintenance-reassignEdits' => 'Bruuch die Syte go Bearbeitige vun eme Benutzer in eme andere zuewyyse.',
	'maintenance-re-from' => 'Benutzer, wu d Bearbeitige ewäggnuu solle wäre',
	'maintenance-re-to' => 'Benutzer, wu d Bearbeitige solle zuegwise wäre',
	'maintenance-re-force' => 'Au nej zuewyyse, wänn s dr nej Benutzer nit git',
	'maintenance-re-rc' => 'Datebank-Tabälle Letschti Änderige nit aktualisiere',
	'maintenance-re-report' => 'Nyt ändere, nume zeige, was gänderet tet wäre',
	'maintenance-re-nf' => 'Benutzer $1 nit gfunde',
	'maintenance-re-rr' => 'Zum Nejzuewyyse s Skript non emol laufe loo ohni „$1“.',
	'maintenance-re-ce' => 'Aktuälli Bearbeitige: $1',
	'maintenance-re-de' => 'Gleschti Bearbeitige: $1',
	'maintenance-re-rce' => 'Yyträg in dr Letschten Änderige: $1',
	'maintenance-re-total' => 'Yyträg, wu mien gänderet wäre: $1',
	'maintenance-re-re' => 'Nejzueornig vu dr Bearbeitige … gmacht',
);

/** Gujarati (ગુજરાતી)
 * @author Dineshjk
 */
$messages['gu'] = array(
	'maintenance-name' => 'સભ્ય નામ',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'maintenance-name' => 'Yung-fu-miàng',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'maintenance-password' => 'ʻŌlelo hūnā',
	'maintenance-reason' => 'Kumu',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'maintenance' => 'הרצת סקריפטים של תחזוקה',
	'maintenance-desc' => '[[Special:Maintenance|ממשק אינטרנט]] למגוון סקריפטים של תחזוקה',
	'right-maintenance' => 'הרצת סקריפטים לתחזוקה דרך [[Special:Maintenance]]',
	'maintenance-backlink' => 'חזרה לבחירת הסקריפטים',
	'maintenance-header' => 'אנא בחרו איזה מהסקריפטים שלהלן להריץ.
התיאורים מופיעים ליד כל סקריפט',
	'maintenance-changePassword-desc' => 'שינוי סיסמת משתמש',
	'maintenance-createAndPromote-desc' => 'יצירת משתמש וקידומו למצב מפעיל מערכת',
	'maintenance-deleteBatch-desc' => 'מחיקה המונית של דפים',
	'maintenance-deleteRevision-desc' => 'הסרת גרסאות ממסד הנתונים',
	'maintenance-eval-desc' => 'הרצת קוד PHP בסביבת מדיה־ויקי',
	'maintenance-initEditCount-desc' => 'חישוב מחדש של מספר העריכות שביצע כל משתמש',
	'maintenance-initStats-desc' => 'חישוב מחדש של סטטיסטיקות האתר',
	'maintenance-moveBatch-desc' => 'העברה המונית של דפים',
	'maintenance-reassignEdits-desc' => 'הקצאת עריכות מחדש ממשתמש אחד לאחר',
	'maintenance-runJobs-desc' => 'הרצת משימות מתור המשימות',
	'maintenance-showJobs-desc' => 'הצגת רשימת משימות הממתינות בתור המשימות',
	'maintenance-sql-desc' => 'הרצת שאילתת SQL',
	'maintenance-stats-desc' => 'הצגת סטטיסטיקת Memcached',
	'maintenance-changePassword' => 'השתמשו בטופס זה כדי לשנות סיסמה של משתמש',
	'maintenance-createAndPromote' => 'השתמשו בטופס זה כדי ליצור משתמש חדש ולקדם אותו לדרגת מפעיל מערכת.
סמנו את תיבת הביורוקרט אם ברצונכם לקדם אותו גם לדרגת ביורוקרט',
	'maintenance-deleteBatch' => 'השתמשו בטופס זה למחיקת דפים המונית.
כתבו שם של דף אחד בכל שורה',
	'maintenance-deleteRevision' => 'השתמשו בטופס זה למחיקה המונית של גרסאות.
כתבו מספר גרסה אחד בכל שורה',
	'maintenance-initStats' => 'השתמשו בטופס זה כדי לחשב מחדש את סטטיסטיקות האתר, וציינו האם ברצונכם לחשב מחדש גם את סטטיסטיקות הצפיות בדפים',
	'maintenance-moveBatch' => 'השתמשו בטופס זה להעברה המונית של דפים.
כל שורה אמורה לציין דף מקור ודף יעד המופרדים ב־"|"',
	'maintenance-invalidtype' => 'הסוג אינו תקין!',
	'maintenance-name' => 'שם משתמש',
	'maintenance-password' => 'סיסמה',
	'maintenance-bureaucrat' => 'קידום משתמש למצב ביורוקרט',
	'maintenance-reason' => 'סיבה',
	'maintenance-update' => 'האם להשתמש ב־UPDATE לעדכון הטבלה? אם תבטלו את הסימון, ייעשה שימוש ב־DELETE/INSERT במקום זאת.',
	'maintenance-noviews' => 'סמנו זאת כדי למנוע את עדכון מספרי הצפיות בדפים',
	'maintenance-confirm' => 'אישור',
	'maintenance-invalidname' => 'שם משתמש בלתי תקין!',
	'maintenance-success' => 'הסקריפט $1 רץ בהצלחה!',
	'maintenance-userexists' => 'המשתמש כבר קיים!',
	'maintenance-invalidtitle' => 'הכותרת "$1" אינה תקינה!',
	'maintenance-titlenoexist' => 'הכותרת שצוינה ("$1") אינה קיימת!',
	'maintenance-failed' => 'נכשלה',
	'maintenance-deleted' => 'נמחק',
	'maintenance-revdelete' => 'מחיקת {{PLURAL:$3|הגרסה|הגרסאות}} $1 מאתר הוויקי $2',
	'maintenance-revnotfound' => 'הגרסה $1 לא נמצאה!',
	'maintenance-sql' => 'השתמשו בטופס זה כדי להריץ שאילתת SQL על בסיס הנתונים.',
	'maintenance-sql-aff' => 'שורות שהושפעו: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|שורה אחת הוחזרה|$1 שורות הוחזרו}}:
$2',
	'maintenance-stats-edits' => 'מספר העריכות: $1',
	'maintenance-stats-articles' => 'מספר הדפים במרחב השם הראשי: $1',
	'maintenance-stats-pages' => 'מספר הדפים: $1',
	'maintenance-stats-users' => 'מספר המשתמשים: $1',
	'maintenance-stats-admins' => 'מספר מפעילי המערכת: $1',
	'maintenance-stats-images' => 'מספר הקבצים: $1',
	'maintenance-stats-views' => 'מספר הצפיות בדפים: $1',
	'maintenance-stats-update' => 'בסיס הנתונים מתעדכן...',
	'maintenance-move' => 'העברת $1 אל $2...',
	'maintenance-movefail' => 'אירעה שגיאה בעת העברת: $1.
ההעברה נקטעה',
	'maintenance-error' => 'שגיאה: $1',
	'maintenance-memc-fake' => 'אתם מריצים את FakeMemCachedClient. לא ניתן לספק סטטיסטיקה.',
	'maintenance-memc-requests' => 'בקשות',
	'maintenance-memc-withsession' => 'בהתחברות:',
	'maintenance-memc-withoutsession' => 'ללא התחברות:',
	'maintenance-memc-total' => 'סך הכול:',
	'maintenance-memc-parsercache' => 'מטמון המפענח',
	'maintenance-memc-hits' => 'פעמים בשימוש:',
	'maintenance-memc-invalid' => 'לא תקין:',
	'maintenance-memc-expired' => 'שתוקפו פג:',
	'maintenance-memc-absent' => 'נעדר:',
	'maintenance-memc-stub' => 'סף הקצרמרים:',
	'maintenance-memc-imagecache' => 'מטמון התמונות',
	'maintenance-memc-misses' => 'החטאות:',
	'maintenance-memc-updates' => 'עדכונים:',
	'maintenance-memc-uncacheable' => 'לא ניתן למטמון:',
	'maintenance-memc-diffcache' => 'מטמון השינויים',
	'maintenance-eval' => 'השתמשו בטופס זה כדי להעריך קוד PHP בסביבת מדיה־ויקי.',
	'maintenance-reassignEdits' => 'השתמשו בטופס זה כדי להקצות מחדש עריכות ממשתמש אחד לאחר.',
	'maintenance-re-from' => 'שם המשתמש ממנו יש להקצות את העריכות',
	'maintenance-re-to' => 'שם המשתמש אליו יוקצו העריכות',
	'maintenance-re-force' => 'ביצוע הקצאה מחודשת אפילו אם משתמש היעד אינו קיים',
	'maintenance-re-rc' => 'לא לעדכן את טבלת השינויים האחרונים',
	'maintenance-re-report' => 'הצגת הפרטים של מה שישתנה, ללא ביצוע השינויים',
	'maintenance-re-nf' => 'המשתמש $1 לא נמצא',
	'maintenance-re-rr' => 'הרצת הסקריפט שוב ללא "$1" לעדכון.',
	'maintenance-re-ce' => 'עריכות נוכחיות: $1',
	'maintenance-re-de' => 'עריכות שנמחקו: $1',
	'maintenance-re-rce' => 'רשומות שינויים אחרונים: $1',
	'maintenance-re-total' => 'סך כל הרשומות לשינוי: $1',
	'maintenance-re-re' => 'הקצאת העריכות מחדש... בוצעה',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'maintenance' => 'Pokreni skripte za održavanje',
	'maintenance-desc' => '[[Special:Maintenance|Web sučelje]] za različite skripte za održavanje',
	'maintenance-backlink' => 'Nazad na odabir skripte',
	'maintenance-header' => 'Odaberite dolje skriptu za pokrenuti.
Opis stoji pored svake skripte.',
	'maintenance-changePassword-desc' => 'Promijeni lozinku suradnika',
	'maintenance-createAndPromote-desc' => 'Stvori suradnički račun i dodijeli sysop pravo',
	'maintenance-deleteBatch-desc' => 'Skupno brisanje stranica',
	'maintenance-deleteRevision-desc' => 'Ukloni izmjene iz baze podataka',
	'maintenance-eval-desc' => 'Procijeni PHP kod u MediaWiki okruženju',
	'maintenance-initEditCount-desc' => 'Ponovno izračunaj broj uređivanja za suradnike',
	'maintenance-initStats-desc' => 'Ponovno izračunaj statistiku za projekt',
	'maintenance-moveBatch-desc' => 'Skupno premještanje stranica',
	'maintenance-reassignEdits-desc' => 'Prenamjeni uređivanje od jednog suradnika drugom.',
	'maintenance-runJobs-desc' => 'Pokreni poslove u redu poslova',
	'maintenance-showJobs-desc' => 'Pokaži popis poslova u toku u redu poslova.',
	'maintenance-sql-desc' => 'Izvrši SQL upit',
	'maintenance-stats-desc' => 'Pokaži memcached statistiku',
	'maintenance-changePassword' => 'Koristite ovu stranicu za promjenu suradničke lozinke',
	'maintenance-createAndPromote' => 'Koristite ovu stranicu za stvaranje novog suradničkog računa i dodjelu sysop prava.
Označite kućicu bureaucrat ako želite dodijeliti i pravo birokrata.',
	'maintenance-deleteBatch' => 'Koristite ovu stranicu za skupno brisanje stranica.
Stavite samu jedno stranicu po retku.',
	'maintenance-deleteRevision' => 'Koristite ovu stranicu za skupno brisanje izmjena.
Stavite broj samo jedne izmjene po retku.',
	'maintenance-initStats' => 'Koristite ovu stranicu za ponovno izračunavanje statistike, odredite ako želite izračunati i broj gledanja stranica također',
	'maintenance-moveBatch' => 'Koristite ovu stranicu za skupno premještanje stranica.
Svaki red mora sadržavati polazišnu stranicu i ciljnu stranicu odvojeno kosom crtom "|"',
	'maintenance-invalidtype' => 'Neispravna vrsta!',
	'maintenance-name' => 'Suradničko ime',
	'maintenance-password' => 'Lozinka',
	'maintenance-bureaucrat' => 'Dodjeli suradniku pravo birokrata',
	'maintenance-reason' => 'Razlog',
	'maintenance-update' => 'Koristi UPDATE prilikom ažuriranja tablice? Neoznačeno umjesto toga koristi DELETE/INSERT.',
	'maintenance-noviews' => 'Označite ovo za sprečavanje ažuriranja broja gledanja stranica',
	'maintenance-confirm' => 'Potvrdi',
	'maintenance-invalidname' => 'Nevaljano suradničko ime!',
	'maintenance-success' => '$1 pokrenut uspješno!',
	'maintenance-userexists' => 'Suradnik već postoji!',
	'maintenance-invalidtitle' => 'Nevaljan naslov "$1"!',
	'maintenance-titlenoexist' => 'Određeni naslov ("$1") ne postoji!',
	'maintenance-failed' => 'NEUSPJEŠNO',
	'maintenance-deleted' => 'OBRISANO',
	'maintenance-revdelete' => 'Brisanje izmjene $1 s wiki $2',
	'maintenance-revnotfound' => 'Izmjena $1 nije pronađena!',
	'maintenance-sql' => 'Koristite ovaj obrazac kako bi izvršili SQL upit na bazu.',
	'maintenance-stats-edits' => 'Broj uređivanja: $1',
	'maintenance-stats-articles' => 'Broj stranica u glavnom imenskom prostoru: $1',
	'maintenance-stats-pages' => 'Broj stranica: $1',
	'maintenance-stats-users' => 'Broj suradnika: $1',
	'maintenance-stats-admins' => 'Broj administratora: $1',
	'maintenance-stats-images' => 'Broj datoteka: $1',
	'maintenance-stats-views' => 'Broj gledanja stranica: $1',
	'maintenance-stats-update' => 'Ažuriranje baze podataka{{int:ellipsis}}',
	'maintenance-move' => 'Premještam $1 na $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Dogodila se greška prilikom premještanja: $1.
Premještanje prekinuto.',
	'maintenance-error' => 'Greška: $1',
	'maintenance-memc-fake' => 'Uključen je lažni memcache klijent. Statistika ne može biti pružena.',
	'maintenance-memc-requests' => 'Zahtjevi',
	'maintenance-memc-withsession' => 'sa sesijom:',
	'maintenance-memc-withoutsession' => 'bez sesije:',
	'maintenance-memc-total' => 'ukupno:',
	'maintenance-memc-parsercache' => 'Memorija parsera',
	'maintenance-memc-hits' => 'pogodaka:',
	'maintenance-memc-invalid' => 'neispravno:',
	'maintenance-memc-expired' => 'isteklo:',
	'maintenance-memc-absent' => 'odustno:',
	'maintenance-memc-stub' => 'prag mrve:',
	'maintenance-memc-imagecache' => 'Memorija slike',
	'maintenance-memc-misses' => 'neuspjelo:',
	'maintenance-memc-updates' => 'ažuriranja:',
	'maintenance-memc-uncacheable' => 'neuhvatljivo za memoriju:',
	'maintenance-memc-diffcache' => 'Diff memorija',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'maintenance' => 'Wothladowanske skripty wuwjesć',
	'maintenance-desc' => '[[Special:Maintenance|Wikijowy interfejs]] za wšelake wothladowanske skripty',
	'right-maintenance' => 'Wothladowanske skripty přez [[Special:Maintenance]] wuwjesć',
	'maintenance-backlink' => 'Wróćo k wuběrej skriptow',
	'maintenance-header' => 'Prošu wubjer jedyn ze slědowacych skriptow, zo by jón wuwjedł.
Wopisanja su pódla wotpowědneho skripta',
	'maintenance-changePassword-desc' => 'Hesło wužiwarja změnić',
	'maintenance-createAndPromote-desc' => 'Wužiwarske konto załožić a do statusa administratora pozběhnyć',
	'maintenance-deleteBatch-desc' => 'Strony z masami wušmórnyć',
	'maintenance-deleteRevision-desc' => 'Wersije z datoweje banki wotstronić',
	'maintenance-eval-desc' => 'PHP-kod we wokolinje MediaWiki wuhódnoćić',
	'maintenance-initEditCount-desc' => 'Ličenja změnow wužiwarjow znowa wobličić',
	'maintenance-initStats-desc' => 'Statistiku sydła znowa wobličić',
	'maintenance-moveBatch-desc' => 'Strony z masami přesunyć',
	'maintenance-reassignEdits-desc' => 'Změny wot jednoho wužiwarja k druhemu wužiwarjej znowa připokazać',
	'maintenance-runJobs-desc' => 'Nadawki w rynku čakacych nadawkow wuwjesć',
	'maintenance-showJobs-desc' => 'Lisćinu nadawkow pokazać, kotrež w rynku nadawkow čakaja',
	'maintenance-sql-desc' => 'SQL-wotprašenje wuwjesć',
	'maintenance-stats-desc' => 'Statistiku Memcached pokazać',
	'maintenance-changePassword' => 'Wužij tutón formular, zo by hesło wužiwarja změnił.',
	'maintenance-createAndPromote' => 'Wužij tutón formular, zo by noweho wužiwarja wutworił a jeho k administratorej powyšił.
Wubjer běrokratowy kašćik, jeli chceš jeho tež k běrokratej powyšić.',
	'maintenance-deleteBatch' => 'Wužij tutón formular, zo by strony z masami wušmórnył.
Napisaj jenož jednu stronu na linku',
	'maintenance-deleteRevision' => 'Wužij tutón formular, zo by wersije z masami wušmórnył.
Napisaj jenož jednu wersiju na linku',
	'maintenance-initStats' => 'Wužij tutón formular, zo by statistiku sydła znowa wobličił. Podaj, hač chceš zwobraznjenja strony tež znowa wobličić',
	'maintenance-moveBatch' => 'Wužij tutón formular, zo by strony z masami přesunył.
Kóžda linka měła žórłowu stronu a cilowu stronu podać, wótdźělenej přez znamješko rołka (|)',
	'maintenance-invalidtype' => 'Njepłaćiwy typ!',
	'maintenance-name' => 'Wužiwarske mjeno',
	'maintenance-password' => 'Hesło',
	'maintenance-bureaucrat' => 'Wužiwarja do statusa běrokrata pozběhnyć',
	'maintenance-reason' => 'Přičina',
	'maintenance-update' => 'Při aktualizowanju tabele UPDATE wužiwać? Jeli to njeje wubrane, so DELETE/INSERT město toho wužiwa.',
	'maintenance-noviews' => 'Wubjer to, zo by aktualizowanju ličby zwobraznjenjow strony zadźěwał',
	'maintenance-confirm' => 'Wobkrućić',
	'maintenance-invalidname' => 'Njepłaćiwe wužiwarske mjeno!',
	'maintenance-success' => '$1 wuspěšnje wuwjedźeny!',
	'maintenance-userexists' => 'Wužiwar hižo eksistuje!',
	'maintenance-invalidtitle' => 'Njepłaćiwy titul "$1"!',
	'maintenance-titlenoexist' => 'Pódaty titul ("$1") njeeksistuje!',
	'maintenance-failed' => 'NJEPORADŹENY',
	'maintenance-deleted' => 'WUŠMÓRNJENY',
	'maintenance-revdelete' => '{{PLURAL:$3|Wersija|Wersiji|Wersije|Wersije}} $1 so z wikija $2 {{PLURAL:$3|wušmóruje|wušmórujetej|wušmóruja|wušmóruja}}',
	'maintenance-revnotfound' => 'Wersija $1 njenamakana!',
	'maintenance-sql' => 'Wužij tutón formular, zo by SQL-wotprašenje w datowej bance wuwjedł.',
	'maintenance-sql-aff' => 'Potrjechene rjadki: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|rjadka wróćena|rjadce wróćenej|rjadki wróćene|rjadkow wróćene}}:
$2',
	'maintenance-stats-edits' => 'Ličba změnow: $1',
	'maintenance-stats-articles' => 'Ličba stronow we hłownym mjenowym rumje: $1',
	'maintenance-stats-pages' => 'Ličba stronow: $1',
	'maintenance-stats-users' => 'Ličba wužiwarjow: $1',
	'maintenance-stats-admins' => 'Ličba administratorow: $1',
	'maintenance-stats-images' => 'Ličba datajow: $1',
	'maintenance-stats-views' => 'Ličba zwobraznjenjow strony: $1',
	'maintenance-stats-update' => 'Datowa banka so aktualizuje{{int:ellipsis}}',
	'maintenance-move' => '$1 so do $2 přesuwuje{{int:ellipsis}}',
	'maintenance-movefail' => 'Zmylk při přesunjenju: $1
Přesunjenje přetorhnjene',
	'maintenance-error' => 'Zmylk: $1',
	'maintenance-memc-fake' => 'Wuwjeduješ FakeMemCachedClient. Žana statistika k dispoziciji.',
	'maintenance-memc-requests' => 'Naprašowanja',
	'maintenance-memc-withsession' => 'z posedźenjom:',
	'maintenance-memc-withoutsession' => 'bjez posedźenja:',
	'maintenance-memc-total' => 'dohromady:',
	'maintenance-memc-parsercache' => 'Parserowy pufrowak',
	'maintenance-memc-hits' => 'wutrjechi:',
	'maintenance-memc-invalid' => 'njepłaćiwy:',
	'maintenance-memc-expired' => 'spadnjeny:',
	'maintenance-memc-absent' => 'njepřitomny:',
	'maintenance-memc-stub' => 'Zarodkowy próh:',
	'maintenance-memc-imagecache' => 'Wobrazowy pufrowak',
	'maintenance-memc-misses' => 'misnjenja:',
	'maintenance-memc-updates' => 'aktualizacije:',
	'maintenance-memc-uncacheable' => 'pufrowak njeda so wužiwać',
	'maintenance-memc-diffcache' => 'Pufrowak rozdźělow',
	'maintenance-eval' => 'Wužij tutón formular, zo by PHP-kod we wokolinje MediaWiki wuhódnoćił.',
	'maintenance-reassignEdits' => 'Wužij tutón formular, zo by změny wot jednoho wužiwarja k druhemu wužiwarjej znowa připokazał.',
	'maintenance-re-from' => 'Mjeno wužiwarja, wot kotrehož so změny připokazuja',
	'maintenance-re-to' => 'Mjeno wužiwarja, kotremuž so změny připokazuja',
	'maintenance-re-force' => 'Znowa připokazać, byrnjež cilowy wužiwar njeeksistował',
	'maintenance-re-rc' => 'Tabelu aktualnych změnow njeaktualizować',
	'maintenance-re-report' => 'Podrobnosće pokazać, kotrež bychu so změnili, ale njeaktualizuj',
	'maintenance-re-nf' => 'Wužiwar $1 njenamakany',
	'maintenance-re-rr' => 'Skript za aktualizaciju hišće raz bjez "$1" wuwjesć.',
	'maintenance-re-ce' => 'Aktualne změny: $1',
	'maintenance-re-de' => 'Wušmórnjene změny: $1',
	'maintenance-re-rce' => 'Zapiski aktualnych změnow: $1',
	'maintenance-re-total' => 'Wšě změny, kotrež maja so změnić: $1',
	'maintenance-re-re' => 'Změny se připokazuja{{int:ellipsis}} sčinjeny',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'maintenance' => 'Karbantartó-szkriptek futtatása',
	'maintenance-desc' => '[[Special:Maintenance|Wikis felület]] különböző karbantartó parancsfájlokhoz',
	'right-maintenance' => 'Karbantartó szkriptek futtatása a [[Special:Maintenance]] speciális lap segítségével',
	'maintenance-backlink' => 'Vissza a parancsfájl-választáshoz',
	'maintenance-header' => 'Kérlek válaszd ki az alábbiak közül a futtatni kívánt parancsfájlt.
Minden parancsfájl mellett megtalálható a leírása',
	'maintenance-changePassword-desc' => 'Felhasználói jelszavak megváltoztatása',
	'maintenance-createAndPromote-desc' => 'Felhasználó létrehozása és előléptetése adminisztrátorrá',
	'maintenance-deleteBatch-desc' => 'Lapok tömeges törlése',
	'maintenance-deleteRevision-desc' => 'Változatok eltávolítása az adatbázisból',
	'maintenance-eval-desc' => 'PHP kód kiértékelése a MediaWiki környezetben',
	'maintenance-initEditCount-desc' => 'Felhasználók szerkesztéseinek újraszámolása',
	'maintenance-initStats-desc' => 'Oldal statisztikáinak újraszámolása',
	'maintenance-moveBatch-desc' => 'Lapok tömeges átnevezése',
	'maintenance-reassignEdits-desc' => 'Szerkesztések átkönyvelése egyik felhasználótól egy másikhoz',
	'maintenance-runJobs-desc' => 'Feladatok futtatása a feladatok várakozási sorában',
	'maintenance-showJobs-desc' => 'Mutasd a feladatok várakozási sorában függőben levő feladatok listáját',
	'maintenance-sql-desc' => 'SQL-lekérdezés futtatása',
	'maintenance-stats-desc' => 'Memcached statisztika megjelenítése',
	'maintenance-changePassword' => 'Ezen űrlap segítségével megváltoztathatod egy felhasználó jelszavát',
	'maintenance-createAndPromote' => 'Ezen űrlap segítségével új felhasználót hozhatsz létre adminisztrátori jogosultsággal.
Kattintsd be a bürokrata jelölőnégyzetet ha bürokratává is szeretnéd tenni',
	'maintenance-deleteBatch' => 'Ezen űrlap segítségével tömegesen törölhetsz lapokat.
Soronként csak egy lapot adj meg',
	'maintenance-deleteRevision' => 'Ezen űrlap segítségével tömegesen törölhetsz lapváltozatokat.
Soronként csak egy változatazonosítót adj meg',
	'maintenance-initStats' => 'Ezen űrlap segítségével újraszámoltathatod az oldal statisztikáit, valamint opcionálisan az oldalmegtekintések számát is',
	'maintenance-moveBatch' => 'Ezen űrlap segítségével tömegesen nevezhetsz át lapokat.
Minden sorban egy-egy forráslapnak és céllapnak kell szerepelnie, pipe ( | ) karakterrel elválasztva',
	'maintenance-invalidtype' => 'Érvénytelen típus!',
	'maintenance-name' => 'Felhasználói név',
	'maintenance-password' => 'jelszó',
	'maintenance-bureaucrat' => 'Felhasználó előléptetése bürokratává',
	'maintenance-reason' => 'Indoklás',
	'maintenance-update' => 'Használja az UPDATE-et táblák frissítésekor? Ha nem pipálod ki, akkor DELETE/INSERT lesz használva helyette.',
	'maintenance-noviews' => 'Jelöld be ezt, ha nem szeretnéd frissíteni az oldalmegtekintések számát',
	'maintenance-confirm' => 'Megerősítés',
	'maintenance-invalidname' => 'Érvénytelen felhasználói név!',
	'maintenance-success' => '$1 sikeresen lefutott!',
	'maintenance-userexists' => 'A felhasználó már létezik!',
	'maintenance-invalidtitle' => 'Érvénytelen cím: „$1”!',
	'maintenance-titlenoexist' => 'A megadott cím („$1”) nem létezik!',
	'maintenance-failed' => 'Sikertelen',
	'maintenance-deleted' => 'TÖRÖLVE',
	'maintenance-revdelete' => 'A következő {{PLURAL:$3|változat|változatok}} törlése a(z) $2 wikiről: $1',
	'maintenance-revnotfound' => 'A(z) $1 változat nem található!',
	'maintenance-sql' => 'Ezen űrlap segítségével SQL-lekérdezést futtathatsz az adatbázison.',
	'maintenance-sql-aff' => 'Érintett sorok: $1',
	'maintenance-sql-res' => 'Az eredmény a következő $1 sor:
$2',
	'maintenance-stats-edits' => 'Szerkesztések száma: $1',
	'maintenance-stats-articles' => 'A fő névtérben lévő lapok száma: $1',
	'maintenance-stats-pages' => 'Lapok száma: $1',
	'maintenance-stats-users' => 'Felhasználók száma: $1',
	'maintenance-stats-admins' => 'Adminisztrátorok száma: $1',
	'maintenance-stats-images' => 'Fájlok száma: $1',
	'maintenance-stats-views' => 'Lapletöltések száma: $1',
	'maintenance-stats-update' => 'Adatbázis frissítése…',
	'maintenance-move' => '$1 átnevezése $2 címre…',
	'maintenance-movefail' => 'Hiba történt az áthelyezés közben: $1.
Áthelyezés megszakítása',
	'maintenance-error' => 'Hiba: $1',
	'maintenance-memc-fake' => 'A FakeMemCachedClientet futtatod. Nem lehet statisztikát készíteni',
	'maintenance-memc-requests' => 'Kérelmek',
	'maintenance-memc-withsession' => 'munkamenettel:',
	'maintenance-memc-withoutsession' => 'munkamenet nélkül:',
	'maintenance-memc-total' => 'összesen:',
	'maintenance-memc-parsercache' => 'Elemző gyorsítótára',
	'maintenance-memc-hits' => 'találatok:',
	'maintenance-memc-invalid' => 'érvénytelen:',
	'maintenance-memc-expired' => 'lejárt:',
	'maintenance-memc-absent' => 'hiányzik:',
	'maintenance-memc-stub' => 'csonkok határa:',
	'maintenance-memc-imagecache' => 'Kép gyorsítótár',
	'maintenance-memc-misses' => 'találati hibák:',
	'maintenance-memc-updates' => 'frissítések:',
	'maintenance-memc-uncacheable' => 'nem gyorsítótárazható:',
	'maintenance-memc-diffcache' => 'Változatok közötti eltérések gyorsítótára',
	'maintenance-eval' => 'Ezen űrlap segítségével PHP-kódot futtathatsz a MediaWiki környezetben.',
	'maintenance-reassignEdits' => 'Ezen űrlap segítségével szerkesztéseket adhatsz át egyik felhasználótól a másiknak.',
	'maintenance-re-from' => 'A felhasználó neve, akitől elveszed a szerkesztéseket',
	'maintenance-re-to' => 'A felhasználó neve, akinek adod a szerkesztéseket',
	'maintenance-re-force' => 'Akkor is adja át, ha a felhasználó nem létezik',
	'maintenance-re-rc' => 'Ne frissítsd a friss változtatások táblát',
	'maintenance-re-report' => 'Írja ki, hogy milyen változtatások történnének, de ne hajtsa őket végre.',
	'maintenance-re-nf' => '$1 felhasználó nem található',
	'maintenance-re-rr' => 'Futtassa újra a szkriptet „$1” nélkül a frissítéshez',
	'maintenance-re-ce' => 'Aktuális szerkesztések: $1',
	'maintenance-re-de' => 'Törölt szerkesztések: $1',
	'maintenance-re-rce' => 'Friss változtatások bejegyzései: $1',
	'maintenance-re-total' => 'Összes megváltoztatandó bejegyzés: $1',
	'maintenance-re-re' => 'Szerkesztések átadása … megtörtént',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'maintenance' => 'Executar scripts de mantenentia',
	'maintenance-desc' => '[[Special:Maintenance|Interfacie web]] pro diverse scripts de mantenentia',
	'right-maintenance' => 'Executar scripts de mantenentia per [[Special:Maintenance]]',
	'maintenance-backlink' => 'Retornar al selection de script',
	'maintenance-header' => 'Per favor selige in basso un script pro executar.
Le descriptones se trova al latere de cata script.',
	'maintenance-changePassword-desc' => 'Cambiar le contrasigno de un usator',
	'maintenance-createAndPromote-desc' => 'Crear un usator e promover le al stato de administrator',
	'maintenance-deleteBatch-desc' => 'Deler paginas in massa',
	'maintenance-deleteRevision-desc' => 'Remover versiones del base de datos',
	'maintenance-eval-desc' => 'Evalutar codice PHP in le ambiente MediaWiki',
	'maintenance-initEditCount-desc' => 'Recalcular le computos de modificationes de usatores',
	'maintenance-initStats-desc' => 'Recalcular le statisticas del sito',
	'maintenance-moveBatch-desc' => 'Renominar paginas in massa',
	'maintenance-reassignEdits-desc' => 'Reassignar modificationes ab un usator verso un altere',
	'maintenance-runJobs-desc' => 'Executar cargas listate in le cauda de actiones',
	'maintenance-showJobs-desc' => 'Monstrar un lista del cargas pendente in le cauda de actiones',
	'maintenance-sql-desc' => 'Executar un consulta SQL',
	'maintenance-stats-desc' => 'Monstrar statisticas Memcached',
	'maintenance-changePassword' => 'Usa iste formulario pro cambiar le contrasigno de un usator',
	'maintenance-createAndPromote' => 'Usa iste formulario pro crear un nove usator e promover le a administrator.
Marca le quadrato de bureaucrate si tu vole promover le etiam a bureaucrate.',
	'maintenance-deleteBatch' => 'Usa iste formulario pro deler paginas in massa.
Indica un sol pagina per linea.',
	'maintenance-deleteRevision' => 'Usa iste forma pro deler versiones in massa.
Indica un sol numero de version per linea.',
	'maintenance-initStats' => 'Usa iste formulario pro recalcular le statisticas del sito. Specifica si tu vole recalcular etiam le visitas de paginas.',
	'maintenance-moveBatch' => 'Usa iste formulario pro renominar paginas in massa.
Cata linea debe specificar un pagina de origine e un pagina de destination separate per un tubo ("<nowiki>|</nowiki>").',
	'maintenance-invalidtype' => 'Typo invalide!',
	'maintenance-name' => 'Nomine de usator',
	'maintenance-password' => 'Contrasigno',
	'maintenance-bureaucrat' => 'Promover le usator al stato de bureaucrate',
	'maintenance-reason' => 'Motivo',
	'maintenance-update' => 'Usar UPDATE pro actualisar un tabella? Dismarca pro usar DELETE/INSERT in vice.',
	'maintenance-noviews' => 'Marca isto pro impedir le actualisation del numero de visitas de paginas.',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-invalidname' => 'Nomine de usator invalide!',
	'maintenance-success' => '$1 se executava con successo!',
	'maintenance-userexists' => 'Le usator existe ja!',
	'maintenance-invalidtitle' => 'Titulo invalide "$1"!',
	'maintenance-titlenoexist' => 'Le titulo specificate ("$1") non existe!',
	'maintenance-failed' => 'FALTA',
	'maintenance-deleted' => 'DELITE',
	'maintenance-revdelete' => 'Deletion del {{PLURAL:$3|version|versiones}} $1 del wiki $2',
	'maintenance-revnotfound' => 'Version $1 non trovate!',
	'maintenance-sql' => 'Usa iste formularo pro executar un consulta SQL del le base de datos.',
	'maintenance-sql-aff' => 'Lineas afficite: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|linea|lineas}} retornate:
$2',
	'maintenance-stats-edits' => 'Numero de moficicationes: $1',
	'maintenance-stats-articles' => 'Numero de paginas in le spatio de nomines principal: $1',
	'maintenance-stats-pages' => 'Numero de paginas: $1',
	'maintenance-stats-users' => 'Numero de usatores: $1',
	'maintenance-stats-admins' => 'Numero de administratores: $1',
	'maintenance-stats-images' => 'Numero de files: $1',
	'maintenance-stats-views' => 'Numero de visitas de paginas: $1',
	'maintenance-stats-update' => 'Actualisation del base de datos in curso…',
	'maintenance-move' => 'Renomination de $1 a $2 in curso…',
	'maintenance-movefail' => 'Error incontrate durante le renomination: $1.
Le renomination es abortate.',
	'maintenance-error' => 'Error: $1',
	'maintenance-memc-fake' => 'Tu executa FakeMemCachedClient. Nulle statistica pote esser fornite.',
	'maintenance-memc-requests' => 'Requestas',
	'maintenance-memc-withsession' => 'con session:',
	'maintenance-memc-withoutsession' => 'sin session:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Cache del analysator syntactic',
	'maintenance-memc-hits' => 'accessos:',
	'maintenance-memc-invalid' => 'invalide:',
	'maintenance-memc-expired' => 'expirate:',
	'maintenance-memc-absent' => 'absente:',
	'maintenance-memc-stub' => 'limine de pecietta:',
	'maintenance-memc-imagecache' => 'Cache de imagines',
	'maintenance-memc-misses' => 'non in cache:',
	'maintenance-memc-updates' => 'actualisationes:',
	'maintenance-memc-uncacheable' => 'non cachabile:',
	'maintenance-memc-diffcache' => 'Cache de comparationes',
	'maintenance-eval' => 'Usa iste formulario pro evalutar codice PHP in le ambiente MediaWiki.',
	'maintenance-reassignEdits' => 'Usa iste formulario pro reassignar modificationes ab un usator verso un altere.',
	'maintenance-re-from' => 'Nomine del usator ab qui prender modificationes',
	'maintenance-re-to' => 'Nomine del usator a qui assignar modificationes',
	'maintenance-re-force' => 'Reassignar mesmo si le usator de destination non existe',
	'maintenance-re-rc' => 'Non actualisar le tabula de modificationes recente',
	'maintenance-re-report' => 'Imprimer detalios de lo que cambiarea, sed non actualisar',
	'maintenance-re-nf' => 'Usator $1 non trovate',
	'maintenance-re-rr' => 'Reexecutar le script sin "$1" a actualisar.',
	'maintenance-re-ce' => 'Modificationes actual: $1',
	'maintenance-re-de' => 'Modificationes delite: $1',
	'maintenance-re-rce' => 'Entratas de Modificationes recente: $1',
	'maintenance-re-total' => 'Total del entratas a cambiar: $1',
	'maintenance-re-re' => 'Reassignation del modificationes… complete',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Kandar
 * @author Rex
 */
$messages['id'] = array(
	'maintenance' => 'Jalankan skrip pemeliharaan',
	'maintenance-desc' => '[[Special:Maintenance|Antarmuka Wiki]] untuk beragam skrip pemeliharaan',
	'right-maintenance' => 'Jalankan skrip pemeliharaan melalui [[Special:Maintenance]]',
	'maintenance-backlink' => 'Kembali ke pemilihan skrip',
	'maintenance-header' => 'Silakan pilih sebuah skrip di bawah ini untuk dijalankan.
Deskripsi tersedia di samping masing-masing skrip',
	'maintenance-changePassword-desc' => 'Ubah kata sandi pengguna',
	'maintenance-createAndPromote-desc' => 'Buat seorang pengguna dan promosikan menjadi pengurus',
	'maintenance-deleteBatch-desc' => 'Penghapusan halaman secara masal',
	'maintenance-deleteRevision-desc' => 'Hapus revisi dari basis data',
	'maintenance-eval-desc' => 'Evaluasi kode PHP di lingkungan MediaWiki',
	'maintenance-initEditCount-desc' => 'Hitung ulang jumlah suntingan pengguna',
	'maintenance-initStats-desc' => 'Hitung ulang statistik situs',
	'maintenance-moveBatch-desc' => 'Pindahkan halaman secara massal',
	'maintenance-reassignEdits-desc' => 'Ganti kredit suntingan dari satu pengguna lain ke yang lain',
	'maintenance-runJobs-desc' => 'Jalankan pekerjaan di antrean pekerjaan',
	'maintenance-showJobs-desc' => 'Tampilkan daftar pekerjaan tertunda di antrean pekerjaan',
	'maintenance-sql-desc' => 'Jalankan suatu kueri SQL',
	'maintenance-stats-desc' => 'Tampilkan statistik Memcached',
	'maintenance-changePassword' => 'Gunakan formulir ini untuk mengubah kata sandi pengguna',
	'maintenance-createAndPromote' => 'Gunakan formulir ini untuk membuat pengguna baru dan mempromosikannya menjadi pengurus.
Cek kotak birokrat jika Anda ingin mempromosikannya juga sebagai birokrat',
	'maintenance-deleteBatch' => 'Gunakan formulir ini untuk menghapus massal halaman.
Cantumkan hanya satu halaman per baris',
	'maintenance-deleteRevision' => 'Gunakan formulir ini untuk menghapus massal revisi.
Cantumkan hanya satu nomor revisi per baris',
	'maintenance-initStats' => 'Gunakan formulir ini untuk menghitung ulang statistik situs. Tentukan jika Anda ingin menghitung ulang juga tampilan halaman',
	'maintenance-moveBatch' => 'Gunakan formulir ini untuk menghapus massal halaman.
Setiap baris harus mencantumkan halaman sumber dan tujuan, dipisahkan dengan tanda pipa',
	'maintenance-invalidtype' => 'Tipe tidak benar!',
	'maintenance-name' => 'Nama pengguna',
	'maintenance-password' => 'Kata sandi',
	'maintenance-bureaucrat' => 'Promosikan pengguna ke status birokrat',
	'maintenance-reason' => 'Alasan',
	'maintenance-update' => 'Gunakan UPDATE sewaktu memperbarui suatu tabel? Jika tidak, akan digunakan DELETE/INSERT.',
	'maintenance-noviews' => 'Centang ini untuk mencegah pembaruan jumlah tampilan halaman',
	'maintenance-confirm' => 'Konfirmasi',
	'maintenance-invalidname' => 'Nama pengguna tidak sah!',
	'maintenance-success' => '$1 berjalan lancar!',
	'maintenance-userexists' => 'Pengguna sudah ada!',
	'maintenance-invalidtitle' => 'Judul "$1" tidak sah!',
	'maintenance-titlenoexist' => 'Judul yang dimaksud ("$1") tidak ada!',
	'maintenance-failed' => 'GAGAL',
	'maintenance-deleted' => 'DIHAPUS',
	'maintenance-revdelete' => 'Menghapus {{PLURAL:$3|revisi|revisi}} $1 dari wiki $2',
	'maintenance-revnotfound' => 'Revisi $1 tidak ditemukan!',
	'maintenance-sql' => 'Gunakan formulir ini untuk menjalankan suatu kueri SQL pada basis data',
	'maintenance-sql-aff' => 'Baris yang terpengaruh: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|baris|baris}} menghasilkan:
$2',
	'maintenance-stats-edits' => 'Jumlah suntingan: $1',
	'maintenance-stats-articles' => 'Jumlah halaman pada ruang nama utama: $1',
	'maintenance-stats-pages' => 'Jumlah halaman: $1',
	'maintenance-stats-users' => 'Jumlah pengguna: $1',
	'maintenance-stats-admins' => 'Jumlah pengurus: $1',
	'maintenance-stats-images' => 'Jumlah berkas: $1',
	'maintenance-stats-views' => 'Jumlah tampilan halaman: $1',
	'maintenance-stats-update' => 'Memperbarui basis data{{int:ellipsis}}',
	'maintenance-move' => 'Memindahkan $1 ke $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Terjadi kesalahan sewaktu memindahkan: $1
Pemindahan dibatalkan',
	'maintenance-error' => 'Kesalahan: $1',
	'maintenance-memc-fake' => 'Anda menjalankan FakeMemCachedClient. Tidak dapat menyediakan statistik.',
	'maintenance-memc-requests' => 'Permintaan',
	'maintenance-memc-withsession' => 'dengan sesi:',
	'maintenance-memc-withoutsession' => 'tanpa sesi:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Singgahan parser',
	'maintenance-memc-hits' => 'tohokan:',
	'maintenance-memc-invalid' => 'tak valid:',
	'maintenance-memc-expired' => 'kadaluwarsa:',
	'maintenance-memc-absent' => 'absen:',
	'maintenance-memc-stub' => 'ambang batas rintisan',
	'maintenance-memc-imagecache' => 'Singgahan berkas',
	'maintenance-memc-misses' => 'luput:',
	'maintenance-memc-updates' => 'pembaruan:',
	'maintenance-memc-uncacheable' => 'tak tersinggahkan:',
	'maintenance-memc-diffcache' => 'Singgahan Perbedaan',
	'maintenance-eval' => 'Gunakan formulir ini untuk mengevaluasi kode PHP di lingkungan MediaWiki.',
	'maintenance-reassignEdits' => 'Gunakan formulir ini untuk memindahkan kredit suntingan dari satu pengguna yang lain.',
	'maintenance-re-from' => 'Nama pengguna pemilik awal suntingan',
	'maintenance-re-to' => 'Nama pengguna pemilik baru suntingan',
	'maintenance-re-force' => 'Ganti penyunting bahkan jika pengguna target tidak ada',
	'maintenance-re-rc' => 'Jangan perbarui tabel perubahan terbaru',
	'maintenance-re-report' => 'Tampilkan detail yang akan diubah, tapi jangan langsung diubah',
	'maintenance-re-nf' => 'Pengguna $1 tidak ditemukan',
	'maintenance-re-rr' => 'Jalankan lagi skrip tanpa pilihan "$1" untuk mengubah data.',
	'maintenance-re-ce' => 'Suntingan sekarang: $1',
	'maintenance-re-de' => 'Suntingan yang dihapus: $1',
	'maintenance-re-rce' => 'Entri PerubahanTerbaru: $1',
	'maintenance-re-total' => 'Entri total untuk diubah: $1',
	'maintenance-re-re' => 'Pengalihan suntingan{{int:ellipsis}} berhasil',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'maintenance-password' => 'Lykilorð',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Gianfranco
 * @author Pietrodn
 */
$messages['it'] = array(
	'maintenance' => 'Esegui script di manutenzione',
	'maintenance-desc' => '[[Special:Maintenance|Interfaccia Wiki]] per alcuni script di manutenzione',
	'right-maintenance' => 'Esegui gli script di manutenzione mediante la pagina [[Special:Maintenance]]',
	'maintenance-backlink' => 'Torna alla selezione degli script',
	'maintenance-header' => 'Scegli uno script da eseguire.
Le descrizioni sono riportate a fianco di ciascuno script',
	'maintenance-changePassword-desc' => 'Cambia una password utente',
	'maintenance-createAndPromote-desc' => 'Crea un utente e promuovilo amministratore (sysop)',
	'maintenance-deleteBatch-desc' => 'Cancella pagine in blocco',
	'maintenance-deleteRevision-desc' => 'Rimuovi revisioni dal database',
	'maintenance-eval-desc' => 'Sperimenta codice PHP in ambiente MediaWiki',
	'maintenance-initEditCount-desc' => 'Ricalcola il conteggio degli edit degli utenti',
	'maintenance-initStats-desc' => 'Ricalcola le statistiche del sito',
	'maintenance-moveBatch-desc' => 'Sposta pagine in blocco',
	'maintenance-reassignEdits-desc' => 'Riassegna gli edit da un utente ad un altro utente',
	'maintenance-runJobs-desc' => 'Esegui richieste in coda job',
	'maintenance-showJobs-desc' => 'Mostra un elenco di operazioni in attesa in coda job',
	'maintenance-sql-desc' => 'Esegui una query SQL',
	'maintenance-stats-desc' => 'Mostra statistiche latenti in Memcache',
	'maintenance-changePassword' => 'Usa questo modulo per cambiare la password di un utente',
	'maintenance-createAndPromote' => 'Usa questo modulo per creare un nuovo utente e promuoverlo amministratore (sysop).
Spunta la casella burocrate se vuoi promuoverlo anche burocrate',
	'maintenance-deleteBatch' => 'Usa questo modulo per cancellare pagine in blocco.
Indica solo una pagina per riga',
	'maintenance-deleteRevision' => 'Usa questo modulo per cancellare revisioni in blocco.
Indica solo un numero di revisione per riga',
	'maintenance-initStats' => 'Usa questo modulo per ricalcolare le statistiche del sito, specificando se vuoi ricalcolare anche il numero di visualizzazioni per pagina',
	'maintenance-moveBatch' => 'Usa questo modulo per spostare pagine in blocco.
Ogni riga deve indicare una pagina di origine ed una di destinazione, separate da un pipe (|)',
	'maintenance-invalidtype' => 'Tipo non valido',
	'maintenance-name' => 'Nome utente',
	'maintenance-password' => 'Password',
	'maintenance-bureaucrat' => 'Promuovi utente a burocrate',
	'maintenance-reason' => 'Motivo',
	'maintenance-update' => "Usare l'istruzione UPDATE per l'aggiornamento delle tabelle? Se non selezionato, usa DELETE/INSERT.",
	'maintenance-noviews' => "Spuntare la casella per evitare l'aggiornamento del numero di visualizzazioni pagine",
	'maintenance-confirm' => 'Conferma',
	'maintenance-invalidname' => 'Nome utente non valido!',
	'maintenance-success' => '$1 eseguito con successo!',
	'maintenance-userexists' => 'Nome utente già esistente!',
	'maintenance-invalidtitle' => 'Titolo "$1" non valido!',
	'maintenance-titlenoexist' => 'Il titolo indicato ("$1") non esiste!',
	'maintenance-failed' => 'FALLITO',
	'maintenance-deleted' => 'CANCELLATO',
	'maintenance-revdelete' => 'Cancellazione di $1 {{PLURAL:$3|revisione|revisioni}} dal wiki $2',
	'maintenance-revnotfound' => 'Revisione $1 non trovata!',
	'maintenance-sql' => 'Usa questo modulo per eseguire una query SQL sul database.',
	'maintenance-sql-aff' => 'Righe interessate: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|riga restituisce|righe restituiscono}}:
$2',
	'maintenance-stats-edits' => 'Numero di edit: $1',
	'maintenance-stats-articles' => 'Numero di pagine nel namespace principale: $1',
	'maintenance-stats-pages' => 'Numero di pagine: $1',
	'maintenance-stats-users' => 'Numero di utenti: $1',
	'maintenance-stats-admins' => 'Numero di amministratori: $1',
	'maintenance-stats-images' => 'Numero di file: $1',
	'maintenance-stats-views' => 'Numero di visualizzazioni pagine: $1',
	'maintenance-stats-update' => 'Aggiornamento del database in corso{{int:ellipsis}}',
	'maintenance-move' => 'Spostamento di $1 a $2 in corso{{int:ellipsis}}',
	'maintenance-movefail' => 'Errore durante lo spostamento: $1.
Spostamento annullato',
	'maintenance-error' => 'Errore: $1',
	'maintenance-memc-fake' => 'Stai eseguendo FakeMemCachedClient. Non è possibile fornire statistiche',
	'maintenance-memc-requests' => 'Richieste',
	'maintenance-memc-withsession' => 'con la sessione:',
	'maintenance-memc-withoutsession' => 'senza sessione:',
	'maintenance-memc-total' => 'totale:',
	'maintenance-memc-parsercache' => 'Cache del parser',
	'maintenance-memc-hits' => 'corrispondenze:',
	'maintenance-memc-invalid' => 'non valido:',
	'maintenance-memc-expired' => 'terminata:',
	'maintenance-memc-absent' => 'assente:',
	'maintenance-memc-stub' => 'livello per stub:',
	'maintenance-memc-imagecache' => 'Cache immagini',
	'maintenance-memc-misses' => 'manca:',
	'maintenance-memc-updates' => 'aggiornamenti:',
	'maintenance-memc-uncacheable' => 'non inseribili in cache:',
	'maintenance-memc-diffcache' => 'Cache per le diff',
	'maintenance-eval' => 'Usa questo modulo per sperimentare codice PHP in ambiente MediaWiki.',
	'maintenance-reassignEdits' => 'Usa questo modulo per riassegnare edit da un utente ad un altro utente.',
	'maintenance-re-from' => "Nome dell'utente i cui edit devono essere riassegnati",
	'maintenance-re-to' => "Nome dell'utente al quale devono essere riassegnati gli edit",
	'maintenance-re-force' => "Riassegna anche se l'utente di destinazione non esiste",
	'maintenance-re-rc' => 'Non aggiornare la tabella delle ultime modifiche',
	'maintenance-re-report' => 'Mostra i dettagli di cosa verrebbe cambiato, ma non aggiornare',
	'maintenance-re-nf' => 'Utente $1 non trovato',
	'maintenance-re-rr' => 'Esegui di nuovo lo script senza "$1" per aggiornare.',
	'maintenance-re-ce' => 'Edit attuali: $1',
	'maintenance-re-de' => 'Edit cancellati: $1',
	'maintenance-re-rce' => 'Voci in RecentChanges: $1',
	'maintenance-re-total' => 'Totale voci da modificare: $1',
	'maintenance-re-re' => 'Riassegnazione edit{{int:ellipsis}} eseguita',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'maintenance' => 'メンテナンス・スクリプトを実行する',
	'maintenance-desc' => '様々なメンテナンス・スクリプト用の[[Special:Maintenance|ウィキ・インタフェース]]',
	'right-maintenance' => '[[Special:Maintenance]] を使ってメンテナンス・スクリプトを実行する',
	'maintenance-backlink' => 'スクリプト選択に戻る',
	'maintenance-header' => '実行するスクリプトを以下から選んでください。解説は各スクリプトの隣にあります',
	'maintenance-changePassword-desc' => '利用者のパスワードを変更する',
	'maintenance-createAndPromote-desc' => '利用者を作成し、管理者にする',
	'maintenance-deleteBatch-desc' => 'ページの一括削除',
	'maintenance-deleteRevision-desc' => 'データベースから版を削除',
	'maintenance-eval-desc' => 'MediaWiki 環境で PHP コードを評価する',
	'maintenance-initEditCount-desc' => '利用者の編集回数を再計算する',
	'maintenance-initStats-desc' => 'サイトの統計を再計算する',
	'maintenance-moveBatch-desc' => 'ページの一括移動',
	'maintenance-reassignEdits-desc' => '編集を現在の利用者から別の利用者に再割り当てする',
	'maintenance-runJobs-desc' => 'ジョブ・キュー中のジョブを実行する',
	'maintenance-showJobs-desc' => 'ジョブ・キューで保留中のジョブ一覧を表示する',
	'maintenance-sql-desc' => 'SQLクエリーを実行する',
	'maintenance-stats-desc' => 'メモリ中にキャッシュされた統計を表示する',
	'maintenance-changePassword' => 'このフォームを使って利用者のパスワードを変更する',
	'maintenance-createAndPromote' => 'このフォームを使って利用者を新規作成し、管理者にする。ビューロクラットにもしたい場合はビューロクラット・ボックスをチェックする',
	'maintenance-deleteBatch' => 'このフォームを使ってページを一括削除する。1行に1ページのみ書く',
	'maintenance-deleteRevision' => 'このフォームを使って版を一括削除する。1行に1版のみ書く',
	'maintenance-initStats' => 'このフォームを使ってサイト統計を再計算する。ページビューも同様に再計算したいか指定する',
	'maintenance-moveBatch' => 'このフォームを使ってページを一括移動する。各行には移動元と移動先ページをパイプで区切って指定する',
	'maintenance-invalidtype' => '無効なタイプです！',
	'maintenance-name' => '利用者名',
	'maintenance-password' => 'パスワード',
	'maintenance-bureaucrat' => '利用者をビューロクラットにする',
	'maintenance-reason' => '理由',
	'maintenance-update' => 'テーブルの更新に UPDATE を使いますか？ 未チェックならば DELETE と INSERT を代わりに使います。',
	'maintenance-noviews' => 'ページビュー数の更新を避けるにはここをチェックする',
	'maintenance-confirm' => '確認',
	'maintenance-invalidname' => '無効な利用者名です！',
	'maintenance-success' => '$1 の実行は成功しました！',
	'maintenance-userexists' => '利用者が既に存在します！',
	'maintenance-invalidtitle' => '「$1」は無効なページ名です！',
	'maintenance-titlenoexist' => '指定した名前 (「$1」) のページは存在しません！',
	'maintenance-failed' => '失敗',
	'maintenance-deleted' => '削除',
	'maintenance-revdelete' => 'ウィキ $2 から{{PLURAL:$3|版}} $1 を削除中',
	'maintenance-revnotfound' => '版 $1 は見つかりません！',
	'maintenance-sql' => 'このフォームを使ってSQLクエリーをデータベース上で実行する。',
	'maintenance-sql-aff' => '影響を受けた行: $1',
	'maintenance-sql-res' => '$1{{PLURAL:$1|行}}が返りました:
$2',
	'maintenance-stats-edits' => '編集回数: $1',
	'maintenance-stats-articles' => '標準名前空間のページ数: $1',
	'maintenance-stats-pages' => 'ページ数: $1',
	'maintenance-stats-users' => '利用者数: $1',
	'maintenance-stats-admins' => '管理者数: $1',
	'maintenance-stats-images' => 'ファイル数: $1',
	'maintenance-stats-views' => 'ページビュー数: $1',
	'maintenance-stats-update' => 'データベースを更新中…',
	'maintenance-move' => '$1 を $2 に移動中…',
	'maintenance-movefail' => '移動中にエラー発生: $1。
移動を中止中',
	'maintenance-error' => 'エラー: $1',
	'maintenance-memc-fake' => 'あなたは FakeMemCachedClient を動かしています。統計を提供することはできません',
	'maintenance-memc-requests' => '要求',
	'maintenance-memc-withsession' => 'セッションあり:',
	'maintenance-memc-withoutsession' => 'セッションなし:',
	'maintenance-memc-total' => '合計:',
	'maintenance-memc-parsercache' => 'パーサーキャッシュ',
	'maintenance-memc-hits' => 'ヒット数:',
	'maintenance-memc-invalid' => '無効:',
	'maintenance-memc-expired' => '期限切れ:',
	'maintenance-memc-absent' => '欠損:',
	'maintenance-memc-stub' => 'スタブ境界:',
	'maintenance-memc-imagecache' => '画像キャッシュ',
	'maintenance-memc-misses' => 'ミス:',
	'maintenance-memc-updates' => '更新:',
	'maintenance-memc-uncacheable' => 'キャッシュ不可:',
	'maintenance-memc-diffcache' => '差分キャッシュ',
	'maintenance-eval' => 'このフォームを使って MediaWiki 環境で PHPコードを評価する。',
	'maintenance-reassignEdits' => '編集の別の利用者への再割り当てを行うにはこのフォームを使います。',
	'maintenance-re-from' => '編集が現在割り当てられている利用者の名前',
	'maintenance-re-to' => '編集を新しく割り当てる利用者の名前',
	'maintenance-re-force' => '割り当て先利用者が存在しない場合でも再割り当てを行う',
	'maintenance-re-rc' => '最近の更新テーブルを更新しない',
	'maintenance-re-report' => '更新せずに、変更点の詳細を出力する',
	'maintenance-re-nf' => '利用者 $1 は見つかりません',
	'maintenance-re-rr' => '「$1」を更新せずにスクリプトを再実行する。',
	'maintenance-re-ce' => '現在の編集: $1',
	'maintenance-re-de' => '削除する編集: $1',
	'maintenance-re-rce' => '最近の更新ページの項目: $1',
	'maintenance-re-total' => '変更する項目の合計: $1',
	'maintenance-re-re' => '編集の再割り当て… 完了',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'maintenance-reason' => 'მიზეზი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'maintenance' => 'ដំណើរការស្រ្គីបតំហែទាំ',
	'maintenance-changePassword-desc' => 'ប្តូរពាក្យសំងាត់របស់អ្នកប្រើប្រាស់',
	'maintenance-createAndPromote-desc' => 'បង្កើត​អ្នកប្រើប្រាស់ និង​ដំឡើង​ទៅជា​អ្នកអភិបាល (sysop status)',
	'maintenance-invalidtype' => 'គំរូ​មិន​ត្រឹមត្រូវ!',
	'maintenance-name' => 'អ្នកប្រើប្រាស់',
	'maintenance-password' => 'ពាក្យសំងាត់',
	'maintenance-bureaucrat' => 'ដំឡើង​អ្នកប្រើប្រាស់​ទៅជា​អ្នកការិយាល័យ',
	'maintenance-reason' => 'មូលហេតុ',
	'maintenance-confirm' => 'អះអាង',
	'maintenance-invalidname' => 'អ្នកប្រើប្រាស់មិនត្រឹមត្រូវ!',
	'maintenance-success' => '$1 បាន​ដំណើការ​ដោយ​ជោគជ័យ​!',
	'maintenance-userexists' => 'អ្នកប្រើប្រាស់មានរួចជាស្រេចហើយ!',
	'maintenance-invalidtitle' => 'ចំណងជើង​មិនត្រឹមត្រូវ "$1"!',
	'maintenance-failed' => 'បាន​បរាជ័យ',
	'maintenance-deleted' => 'បាន​លុប',
	'maintenance-revdelete' => 'លុប {{PLURAL:$3|ការពិនិត្យឡើងវិញ|ការពិនិត្យឡើងវិញ}} $1 ពី​វិគី $2',
	'maintenance-revnotfound' => 'រក​មិនឃើញ​ការពិនិត្យឡើងវិញ $1 ទេ​!',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|ជួរ|ជួរ}} បាន​ត្រឡប់:
$2',
	'maintenance-stats-edits' => 'ចំនួនកំណែប្រែ៖ $1',
	'maintenance-stats-articles' => 'ចំនួន​ទំព័រ​នៅក្នុង​លំហឈ្មោះ​ដើម: $1',
	'maintenance-stats-pages' => 'ចំនួនទំព័រ: $1',
	'maintenance-stats-users' => 'ចំនួនអ្នកប្រើប្រាស់: $1',
	'maintenance-stats-admins' => 'ចំនួនអ្នកថែទាំប្រព័ន្ធ: $1',
	'maintenance-stats-images' => 'ចំនួនឯកសារ: $1',
	'maintenance-stats-views' => 'ចំនួន​នៃ​ការមើល​ទំព័រ: $1',
	'maintenance-stats-update' => 'ធ្វើឱ្យ​ទិន្នន័យ​ទាន់សម័យ​...',
	'maintenance-move' => 'កំពុងប្តូរទីតាំង$1ទៅ$2...',
	'maintenance-error' => 'កំហុស: $1',
	'maintenance-memc-requests' => 'ស្នើសុំ',
	'maintenance-memc-total' => 'សរុប:',
	'maintenance-memc-invalid' => 'មិន​ត្រឹមត្រូវ:',
	'maintenance-memc-expired' => 'បានផុតកំណត់៖',
	'maintenance-memc-absent' => 'អវត្តមាន:',
	'maintenance-memc-misses' => 'ខ្វះ:',
	'maintenance-memc-updates' => 'បន្ទាន់សម័យ​៖',
	'maintenance-re-nf' => 'រក​មិន​ឃើញ​អ្នកប្រើប្រាស់ $1 ទេ',
	'maintenance-re-rr' => 'ដំណើរការ​ស្គ្រីប​ម្ដងទៀត ដោយ​គ្មាន "$1" ដើម្បី​បន្ទាន់សម័យ​ទេ​។',
	'maintenance-re-ce' => 'កំណែប្រែ​បច្ចុប្បន្ន: $1',
	'maintenance-re-de' => 'កំណែប្រែ​ដែល​បាន​លុប: $1',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'maintenance-reason' => 'ಕಾರಣ',
);

/** Korean (한국어)
 * @author Ficell
 * @author Kwj2772
 */
$messages['ko'] = array(
	'maintenance-password' => '비밀번호',
	'maintenance-confirm' => '확인',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'maintenance' => 'Waadongsprojramme loufe lohße',
	'maintenance-desc' => '[[Special:Maintenance|Web Engerfäjß]] för divärse Waadongsprojramme',
	'right-maintenance' => 'E Waadongsprojramm övver <i lang="en">[[Special:Maintenance]]</i> loufe ze lohße',
	'maintenance-backlink' => 'Zoröck zom Projramm-Wähle',
	'maintenance-header' => 'Donn hee e Projramm ußsööke wat De loufe lohße wells.
Näve dä Projramme es koot jesaat, wat se donn.',
	'maintenance-changePassword-desc' => 'Ennem Metmaacher sing Paßwoot ändere',
	'maintenance-createAndPromote-desc' => 'Don ene Metmaacher aanlääje un zom Wiki-Köbes maache',
	'maintenance-deleteBatch-desc' => 'Massehaff Sigge fottschmiiße',
	'maintenance-deleteRevision-desc' => 'Sigge-Versione uß de Datebank schmiiße',
	'maintenance-eval-desc' => 'E PHP-Projrammshtöck en de MediaWiki Ömjävung ußprobeere',
	'maintenance-initEditCount-desc' => 'Ennem Metmaacher sing Aanzahl Sigge-Änderonge neu ußzälle',
	'maintenance-initStats-desc' => 'De Sigge ier Statistike neu ußzälle',
	'maintenance-moveBatch-desc' => 'Messehaff Sigge ömnänne',
	'maintenance-reassignEdits-desc' => 'Änderunge aam Wiki vun einem Metmaacher enem andere Metmaacher zohschrihve',
	'maintenance-runJobs-desc' => 'Opjaave uß de Leß aanshtüße, dat jetz jedonn wääde',
	'maintenance-showJobs-desc' => 'De Leß met de Opjave aanzeije',
	'maintenance-sql-desc' => 'De SQL Datebangk befroore',
	'maintenance-stats-desc' => 'Zeich de Statistike vom <tt>Memcached</tt>',
	'maintenance-changePassword' => 'Ennem Medmaacher sing Passwoot övver e Formular änndere',
	'maintenance-createAndPromote' => 'Met dämm Fommulaa hee kanns De ene neue Metmaacher aanläje un och tiräk
ene {{int:group-sysop-member}} odder ene {{int:group-bureaucrat-member}}
druß maache.',
	'maintenance-deleteBatch' => 'Met hee dämm Fommulaa kanns De Sigge ang-maß fott schmiiße.
Jif nur eine Sigge-Tittel en jede Reih en.',
	'maintenance-deleteRevision' => 'Met hee dämm Fommulaa kanns De Versione ang-maß fott schmiiße.
Jif nur eine Versionsnummer en jede Reih en.',
	'maintenance-initStats' => 'Met hee dämm Fommulaa kanns De Shtatistike för Sigge neu ußräschne.
Do kanns extra aanjevve, of De de Sigge-Afroofe och neu jezallt han wells.',
	'maintenance-moveBatch' => 'Met hee dämm Fommulaa kanns De maßisch Sigge ömnenne.
En jede Reih sullt ene ahle u nene neue Siggetittel hengereneejn shtonn,
met enem senkrääschte Shtresh dozwesche, allsu däm „|“',
	'maintenance-invalidtype' => 'En onjölijje Zoot!',
	'maintenance-name' => 'Metmaacher Name',
	'maintenance-password' => 'Passwood',
	'maintenance-bureaucrat' => 'Mach enne Bürrokrad uß ennem Metmaacher',
	'maintenance-reason' => 'Jrond oddo Aanlaß',
	'maintenance-update' => 'Met Höksche: bruch <span style="text-transform:uppercase">update</span> wann de Tabäll jänndert wede soll. Ohne Höksche: nemm <span style="text-transform:uppercase">delete</span> odder <span style="text-transform:uppercase">insert</span> doför.',
	'maintenance-noviews' => 'Maach hee e Hööksche, öm de Aanzahl affjeroofe Sigge nit aanzepacke',
	'maintenance-confirm' => 'Bestätije',
	'maintenance-invalidname' => 'Der Metmaacher kenne mer nit!',
	'maintenance-success' => '„$1“ es met Erfolch jeloufe!',
	'maintenance-userexists' => 'Dä Metmaacher jidd_et ald!',
	'maintenance-invalidtitle' => 'Onjöltije Sigge-Tittel: „$1“!',
	'maintenance-titlenoexist' => 'Dä aanjejovve Tittel „$1“ jidd_et nit!',
	'maintenance-failed' => '<span style="text-transform:uppercase">donevve jejange</span>',
	'maintenance-deleted' => '<span style="text-transform:uppercase">fottjeschmesse</span>',
	'maintenance-revdelete' => 'Ben dabei, {{PLURAL:$3|de Version|de Versione|kein Version}} $1 vum Wiki $2 fottzeschmiiße.',
	'maintenance-revnotfound' => 'En Version $1 hammer nit jefonge!',
	'maintenance-sql' => 'Met hee dämm Fommulaa kanns De ene SQL-Befäähl aan de Datebangk schecke.',
	'maintenance-sql-aff' => 'Betroffe Reije: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|Ein Reih|$ Reije|Kein einzije Reih}} kohm drop zerök:
$2',
	'maintenance-stats-edits' => 'Aanzahl Sigge-Änderonge: $1',
	'maintenance-stats-articles' => 'Aanzahl Sigge em Appachtemang met de Atikele: $1',
	'maintenance-stats-pages' => 'Aanzahl Sigge: $1',
	'maintenance-stats-users' => 'Aanzahl Metmaacher: $1',
	'maintenance-stats-admins' => 'Aanzahl Wiki-Köbesse: $1',
	'maintenance-stats-images' => 'Aanzahl Dateie: $1',
	'maintenance-stats-views' => 'Aanzahl Sigge-Afroofe: $1',
	'maintenance-stats-update' => 'Ben de Datebank am ändere&nbsp;…',
	'maintenance-move' => 'Ben „$1“ op „$2“ aam Ömenne&nbsp;…',
	'maintenance-movefail' => 'Ene Fähler es paßeet beim ömnänne vun dä Sigk: „$1“
Dat Ömnenne weed jeshtopp.',
	'maintenance-error' => 'Fähler: $1',
	'maintenance-memc-fake' => 'Ühr hat der <code>FakeMemCachedClient</code> am Loufe. Do jidd_et kein Statistike för.',
	'maintenance-memc-requests' => 'Aanfrore',
	'maintenance-memc-withsession' => 'Met en Setzung:',
	'maintenance-memc-withoutsession' => 'Oohne en Setzung:',
	'maintenance-memc-total' => 'Zosamme:',
	'maintenance-memc-parsercache' => 'Däm Paaser singe Zwescheshpeisher',
	'maintenance-memc-hits' => 'Treffer:',
	'maintenance-memc-invalid' => 'onjöltesch:',
	'maintenance-memc-expired' => 'afjeloufe:',
	'maintenance-memc-absent' => 'nit do:',
	'maintenance-memc-stub' => 'Jrenz för Shtümpschens-Sigge:',
	'maintenance-memc-imagecache' => 'Dä Zwescheshpeisher för de Bellder',
	'maintenance-memc-misses' => 'Nit jetroffe:',
	'maintenance-memc-updates' => 'Änderonge:',
	'maintenance-memc-uncacheable' => 'kam_mer nit zewscheshpeishere:',
	'maintenance-memc-diffcache' => 'Zweschespeicher för de Ungerscheide',
	'maintenance-eval' => 'Dat Fommulaa hee kanns De bruche, öm e PHP-Projrammshtöck enjebett en dem MediaWiki sing Ömjävung ußzeprobeere.',
	'maintenance-reassignEdits' => 'Di Sigk hee kanns De bruche, öm de Änderunge vun einem Metmaacher enem andere zozeschrieve.',
	'maintenance-re-from' => 'Däm Metmaacher singe Name, däm sing Änderunge enem andere zojeschrevve wäde sulle',
	'maintenance-re-to' => 'Däm Metmaacher, däm de Änderunge zojeschrevve wäde sulle, singe Name',
	'maintenance-re-force' => 'Neu zodeijle, selfs wann et dä neue Metmacher jaa nit jit',
	'maintenance-re-rc' => 'Donn de „{{int:recentchanges}}“ en de Datebangk nit ändere',
	'maintenance-re-report' => 'Änderonge zeije, ävver nit maache',
	'maintenance-re-nf' => 'Metmaacher $1 nit jefonge',
	'maintenance-re-rr' => 'Lohß dat norr_ens loufe oohne „$1“ öm de Änderonge och ze maache.',
	'maintenance-re-ce' => 'Aktoälle Aanzahl Änderunge: $1',
	'maintenance-re-de' => 'Aanzahl fottjeschmeße Änderunge: $1',
	'maintenance-re-rce' => 'Enndrääsch en de Neuste Änderunge: $1',
	'maintenance-re-total' => 'Aanzahl Endräch zom Ändere: $1',
	'maintenance-re-re' => "Änderunge neu zo'oodene … jedonn",
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Purodha
 * @author Robby
 */
$messages['lb'] = array(
	'maintenance' => 'Maintenance-Skripten ausféieren',
	'maintenance-desc' => '[[Special:Maintenance|Web interface]] fir verschidde Maintenance-Skripten',
	'right-maintenance' => 'Ënnerhalts-Skripten op [[Special:Maintenance]] starten',
	'maintenance-backlink' => "Zréck op d'Auswiel vum Script",
	'maintenance-header' => "Sicht w.e.g. ënnendrëmmer e Script eraus fir auszeféieren.
D'Beschreiwunge stinn niewent all Script.",
	'maintenance-changePassword-desc' => 'Engem Benotzer säi Passwuert änneren',
	'maintenance-createAndPromote-desc' => 'E Benotzerkont opmaachen an deem de Statut vun engem Administrateur ginn',
	'maintenance-deleteBatch-desc' => 'Vill Säite matenee läschen',
	'maintenance-deleteRevision-desc' => 'Versiounen aus der Datebank eraushuelen',
	'maintenance-eval-desc' => 'PHP-Code am MediaWiki-Kontext bewerten',
	'maintenance-initEditCount-desc' => "D'Compteuren vun den Ännerunge vun de Benotzer nei berechnen",
	'maintenance-initStats-desc' => "D'Statistike vum Site neiberechnen",
	'maintenance-moveBatch-desc' => 'Vill Säite matenee réckelen',
	'maintenance-reassignEdits-desc' => 'Ännerunge vun engem Benotzer engem aneren zouweisen',
	'maintenance-runJobs-desc' => 'Aarbechten an der Queue vun den Aarbechte starten',
	'maintenance-showJobs-desc' => "Weis d'Lësccht vun den Aarbechten déi nach an der ''Queue'' stinn",
	'maintenance-sql-desc' => 'Eng SQL-Ufro ausféieren',
	'maintenance-stats-desc' => 'Statistiken vun der Cache Memoire weisen',
	'maintenance-changePassword' => "Dëse Formulaire benotze fir engem Benotzer säi Passwuert z'änneren",
	'maintenance-createAndPromote' => "Dëse Formulaire benotze fir en neie Benotzer unzeleeën a fir him Adminstrateur's-Rechter ze ginn.
Klickt d'Bürokrate-Këscht u wann Dir wëllt datt en och Bürokrat gi soll.",
	'maintenance-deleteBatch' => 'Dëse Formulaire benotze fir eng Rei vu Säiten ze läschen.
Nëmmen eng Säit pro Linn aginn.',
	'maintenance-deleteRevision' => 'Benotzt dëse Formulaire fir vill Versioune mateneen ze läschen.
Schreiwt an all Linn just eng Versioun.',
	'maintenance-initStats' => "Benotzt dëse Formulaire fir d'Statistike vum Site nei ze berechnen, gitt w.e.g. unn ob Dir d'Zuel vun de Säiten-Ufroen och wëllt nei berechent hunn",
	'maintenance-moveBatch' => "Benotzt dëse Formulaire fir eng Grous Zuel vu Säiten ze réckelen.
An all Linn soll en Quellsäit an eng Zilsäit, getrennt duerch een ''<nowiki>|</nowiki>'', drastoen.",
	'maintenance-invalidtype' => 'Typ net valabel!',
	'maintenance-name' => 'Benotzernumm',
	'maintenance-password' => 'Passwuert',
	'maintenance-bureaucrat' => 'Engem Benotzer de Bürokrate-Status ginn',
	'maintenance-reason' => 'Grond',
	'maintenance-update' => "UPDATE benotze fir eng Tabell z'aktualiséieren? Wann et net ugekräizt ass gëtt DELETE/INSERT dofir benotzt.",
	'maintenance-noviews' => "Dëst nokucke fir d'Aktualisatioun vun der Zuel vun deVisite vun der Säit ze verhënneren",
	'maintenance-confirm' => 'Confirméieren',
	'maintenance-invalidname' => 'Ongëltege Benotzernumm!',
	'maintenance-success' => '$1 ass gemaach ginn!',
	'maintenance-userexists' => 'De Benotzer gëtt et schonn!',
	'maintenance-invalidtitle' => 'Ongëltegen Titel "$1"!',
	'maintenance-titlenoexist' => 'Den Titel den dir uginn hutt ("$1") gëtt et net!',
	'maintenance-failed' => 'Huet net fonctionnéiert',
	'maintenance-deleted' => 'GELÄSCHT',
	'maintenance-revdelete' => 'Läsche {{PLURAL:$3|vun der Versioun| vun de Versioune(n)}} $1 vun der Wiki $2',
	'maintenance-revnotfound' => "D'Versioun $1 gouf net fonnt!",
	'maintenance-sql' => 'Dëse Formaulaire benotze fir eng SQL-Ufro an der Datebank ze maachen.',
	'maintenance-sql-aff' => 'Betraffe Reien: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|Rei|Reien}} zréckgeschéckt:
$2',
	'maintenance-stats-edits' => 'Zuel vun den Ännerungen: $1',
	'maintenance-stats-articles' => 'Zuel vun de Säiten am Haaptnummraum: $1',
	'maintenance-stats-pages' => 'Zuel vun de Säiten: $1',
	'maintenance-stats-users' => 'Zuel vun de Benotzer: $1',
	'maintenance-stats-admins' => 'Zuel vun den Administrateuren: $1',
	'maintenance-stats-images' => 'Zuel vun de Fichieren: $1',
	'maintenance-stats-views' => 'Zuel vun de besichte Säiten: $1',
	'maintenance-stats-update' => "D'Datebank gëtt aktualiséiert {{int:ellipsis}}",
	'maintenance-move' => '$1 gëtt op $2 geréckelt {{int:ellipsis}}',
	'maintenance-movefail' => 'Feeler beim Réckele vu(n): $1.
Réckelen ofgebrach',
	'maintenance-error' => 'Feeler: $1',
	'maintenance-memc-fake' => 'Dir benotzt FakeMemCachedClient. Et si keng Statistiken disponibel',
	'maintenance-memc-requests' => 'Ufroen',
	'maintenance-memc-withsession' => 'mat Sessioun:',
	'maintenance-memc-withoutsession' => 'ouni Sessioun:',
	'maintenance-memc-total' => 'Total:',
	'maintenance-memc-parsercache' => 'Parser-Tëschespäicher',
	'maintenance-memc-hits' => 'Klicken:',
	'maintenance-memc-invalid' => 'net valabel:',
	'maintenance-memc-expired' => 'ofgelaf:',
	'maintenance-memc-absent' => 'net do:',
	'maintenance-memc-stub' => 'Limit fir eng Skizz:',
	'maintenance-memc-imagecache' => 'Bild Tëschespäicher (Cache)',
	'maintenance-memc-misses' => 'verluer:',
	'maintenance-memc-updates' => 'Aktualiséierungen:',
	'maintenance-memc-uncacheable' => 'kann net tëschegespäichert ginn:',
	'maintenance-memc-diffcache' => 'Diff-Tëschespäicher',
	'maintenance-eval' => 'Benotzt dëse Formulaire fir PHP-Code am MediaWiki-Kontext ze bewerten',
	'maintenance-reassignEdits' => 'Benotzt dëse Formulaire fir Ännerunge vun engem Bentzer engem aneren zouzeweisen.',
	'maintenance-re-from' => "Numm vum Benotzer deem d'Ännerunge ewechgeholl solle ginn",
	'maintenance-re-to' => 'Numm vum Benotzer deem dës Ännerungen zougewise solle ginn',
	'maintenance-re-force' => 'Och dann nees zouweise wann et den Zilbenotzer net gëtt',
	'maintenance-re-rc' => 'Tabell vun de rezenten Ännerungen net aktualiséieren',
	'maintenance-re-report' => 'Detailer weisen vun deem wat geännert géif  ginn, awer et net aktualiséieren.',
	'maintenance-re-nf' => 'De Benotzer $1 gouf net fonnt',
	'maintenance-re-rr' => 'De Skript nachemol lafe lossen ouni "$1" z\'aktualiséieren',
	'maintenance-re-ce' => 'Aktuell Ännerungen: $1',
	'maintenance-re-de' => 'Geläschten Ännerungen: $1',
	'maintenance-re-rce' => 'Zuel vun de rezenten Ännerungen: $1',
	'maintenance-re-total' => "Total vun den Ännerunge déi z'ännere sinn: $1",
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'maintenance-stats-edits' => 'Numero de cambias: $1',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'maintenance-name' => 'Пайдаланышын лӱмжӧ',
	'maintenance-password' => 'Шолыпмут',
	'maintenance-reason' => 'Амал',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'maintenance' => 'Пушти скрипти за одржување',
	'maintenance-desc' => '[[Special:Maintenance|Вики-интерфејс]] за разни скрипти за одржување',
	'right-maintenance' => 'Пуштање на скрипти за одржување преку [[Special:Maintenance]]',
	'maintenance-backlink' => 'Назад кон изборот на скрипта',
	'maintenance-header' => 'Одберете скрипта подолу за извршување.
До секоја скрипта стои нејзин опис',
	'maintenance-changePassword-desc' => 'Промени лозинка на корисник',
	'maintenance-createAndPromote-desc' => 'Создај корисник и унапреди го во администратор',
	'maintenance-deleteBatch-desc' => 'Групно бришење на страници',
	'maintenance-deleteRevision-desc' => 'Отстрани ревизии од базата на податоци',
	'maintenance-eval-desc' => 'Проверка на PHP-кодот во МедијаВики околина',
	'maintenance-initEditCount-desc' => 'Одново пресметај го бројот на уредувањата на корисниците',
	'maintenance-initStats-desc' => 'Одново пресметај ги статистиките на веб-страницата',
	'maintenance-moveBatch-desc' => 'Групно преместување на страници',
	'maintenance-reassignEdits-desc' => 'Презадај уредувања од еден корисник на друг',
	'maintenance-runJobs-desc' => 'Пушти ги задачите во редицата на задачи',
	'maintenance-showJobs-desc' => 'Прикажи листа на задачи во редот на чекање',
	'maintenance-sql-desc' => 'Изврши SQL-барање',
	'maintenance-stats-desc' => 'Прикажи Memcached статистики',
	'maintenance-changePassword' => 'Овој образец служи за менување на лозинка на корисник',
	'maintenance-createAndPromote' => 'Овој образец служи за создавање на нов корисник и негово унапредување во администратор.
Штиклирајте го кутивчето за „бирократ“ ако сакате корисникот воедно да биде и во бирократ',
	'maintenance-deleteBatch' => 'Овој образец користи за групно бришење на слики.
Внесувајте само една страница по ред',
	'maintenance-deleteRevision' => 'Овој образец служи за групно бришење на ревизии.
Внесувајте само по еден број на ревизија во секој ред',
	'maintenance-initStats' => 'Овој образец служи за одново пресметување на статистики, назначувајќи дали сакате да одновно да ги пресметате и прегледите на страниците',
	'maintenance-moveBatch' => 'Овој образец служи за групно преместување на страници.
ВО секој ред треба да има наведено изворна страница и целна страница, одделени со знакот „|“',
	'maintenance-invalidtype' => 'Неважечки тип!',
	'maintenance-name' => 'Корисничко име',
	'maintenance-password' => 'Лозинка',
	'maintenance-bureaucrat' => 'Промоција на корисник во бирократ',
	'maintenance-reason' => 'Неважечки тип!',
	'maintenance-update' => 'Да користам UPDATE кога ажурирам табела? Отшриклирајте ако сакате наместо тоа да користам DELETE/INSERT.',
	'maintenance-noviews' => 'Штиклирајте го ова за да го спречите ажурирањето на бројот на прегледи на страниците',
	'maintenance-confirm' => 'Потврди',
	'maintenance-invalidname' => 'Неважечко корисничко име!',
	'maintenance-success' => '$1 е успешно извршено!',
	'maintenance-userexists' => 'Корисникот веќе постои!',
	'maintenance-invalidtitle' => 'Неважечки наслов „$1“!',
	'maintenance-titlenoexist' => 'Назначениот наслов („$1“) не постои.',
	'maintenance-failed' => 'НЕУСПЕШНО',
	'maintenance-deleted' => 'ИЗБРИШАНО',
	'maintenance-revdelete' => 'Бришење на {{PLURAL:$3|ревизија|ревизии}} $1 од викито $2',
	'maintenance-revnotfound' => 'Ревизијата $1 не е пронајдена!',
	'maintenance-sql' => 'Овој образец служи за вршење на SQL-барање од базата на податоци.',
	'maintenance-sql-aff' => 'Засегнати редови: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|Вратен е $1 ред|Вратени се $1 реда}}:
$2',
	'maintenance-stats-edits' => 'Број на уредувања: $1',
	'maintenance-stats-articles' => 'Број на страници во главниот именски простор: $1',
	'maintenance-stats-pages' => 'Број на страници: $1',
	'maintenance-stats-users' => 'Број на корисници: $1',
	'maintenance-stats-admins' => 'Број на администратори: $1',
	'maintenance-stats-images' => 'Број на податотеки: $1',
	'maintenance-stats-views' => 'Број на прегледи на страниците: $1',
	'maintenance-stats-update' => 'Ја обновувам базата на податоци{{int:ellipsis}}',
	'maintenance-move' => 'Ја преместувам страницата $1 во $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Настана грешка при преместувањето: $1.
Откажување на преместувањето',
	'maintenance-error' => 'Грешка: $1',
	'maintenance-memc-fake' => 'Работите со FakeMemCachedClient. Не може да се наведат статистики',
	'maintenance-memc-requests' => 'Барања',
	'maintenance-memc-withsession' => 'со сесија:',
	'maintenance-memc-withoutsession' => 'без сесија:',
	'maintenance-memc-total' => 'вкупно:',
	'maintenance-memc-parsercache' => 'Парсерски кеш',
	'maintenance-memc-hits' => 'погодоци:',
	'maintenance-memc-invalid' => 'неважечки:',
	'maintenance-memc-expired' => 'истечени:',
	'maintenance-memc-absent' => 'отсутно:',
	'maintenance-memc-stub' => 'праг за никулци:',
	'maintenance-memc-imagecache' => 'Кеш на сликите',
	'maintenance-memc-misses' => 'промашувања:',
	'maintenance-memc-updates' => 'подновувања:',
	'maintenance-memc-uncacheable' => 'некеширливи:',
	'maintenance-memc-diffcache' => 'Кеш на разликата',
	'maintenance-eval' => 'Овој образец служи за проверка на PHP-код во МедијаВики околина.',
	'maintenance-reassignEdits' => 'Овој образец служи за презадавање на уредувања од еден корисник на друг.',
	'maintenance-re-from' => 'Име на корисникот чиишто уредувања се презадаваат',
	'maintenance-re-to' => 'Име на корисникот кому му се презадаваат уредувањата',
	'maintenance-re-force' => 'Презадај дури и ако целниот корисник не постои',
	'maintenance-re-rc' => 'Не ја подновувај табелата на скорешни промени',
	'maintenance-re-report' => 'Прикажи ги подробностите од измените, но не ги применувај',
	'maintenance-re-nf' => 'Корисникот $1 не е пронајден',
	'maintenance-re-rr' => 'Повторно пушти ја скриптата без „$1“ за да ажурирате.',
	'maintenance-re-ce' => 'Тековни уредувања: $1',
	'maintenance-re-de' => 'Избришани уредувања: $1',
	'maintenance-re-rce' => 'Записи во скорешните промени: $1',
	'maintenance-re-total' => 'Вкупно записи за менување: $1',
	'maintenance-re-re' => 'Презадавањето на уредувањата{{int:ellipsis}} е завршено',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'maintenance' => 'പരിപാലന സ്ക്രിപ്റ്റുകള്‍ ഓടിക്കുക',
	'maintenance-desc' => 'വിവിധ പരിപാലന സ്ക്രിപ്റ്റുകള്‍ക്കുള്ള [[Special:Maintenance|വെബ്ബ് ഇന്റര്‍ഫേസ്]]',
	'maintenance-backlink' => 'സ്ക്രിപ്റ്റുകളുടെ തിരഞ്ഞെടുക്കല്‍ താളിലേക്കു തിരിച്ചു പോവുക',
	'maintenance-header' => 'പ്രവര്‍ത്തിപ്പിക്കുവാനുള്ള സ്ക്രിപ്റ്റ് താഴെ നിന്നു തിരഞ്ഞെടുക്കുക. ഓരോ സ്ക്രിപ്റ്റിനു നേരെയും അതിനെക്കുറിച്ചുള്ള വിവരണം കൊടുത്തിരിക്കുന്നു.',
	'maintenance-changePassword-desc' => 'ഒരു ഉപയോക്താവിന്റെ രഹസ്യവാക്ക് മാറ്റുക',
	'maintenance-createAndPromote-desc' => 'ഒരു ഉഒഅയോക്താവിനെ സൃഷ്ടിച്ച് സിസോപ്പായി സ്ഥാനക്കയറ്റം നല്‍കുക',
	'maintenance-deleteBatch-desc' => 'താലുകള്‍ കൂട്ടമായി ഒഴിവാക്കുക',
	'maintenance-deleteRevision-desc' => 'ഡാറ്റാബേസില്‍ നിന്നു പതിപ്പുകള്‍ മാറ്റുക',
	'maintenance-initEditCount-desc' => 'ഉപയോക്താക്കളുടെ തിരുത്തലിന്റെ എണ്ണം വീണ്ടും കണക്കുകൂട്ടുക.',
	'maintenance-initStats-desc' => 'സൈറ്റിന്റെ സ്ഥിതിവിവരക്കണക്ക് വീണ്ടും കണക്കുകൂട്ടുക',
	'maintenance-moveBatch-desc' => 'താളുകള്‍ കൂട്ടമായി മാറ്റുക',
	'maintenance-changePassword' => 'ഉപയോക്താവിന്റെ രഹസ്യവാക്ക് മാറ്റാന്‍ ഈ ഫോം ഉപയോഗിക്കുക',
	'maintenance-createAndPromote' => 'ഒരു ഉപയോക്താവിനെ ഉണ്ടാക്കി പ്രസ്തുത ഉപയോക്താവിനെ സിസോപ്പ് ആയി ഉയര്‍ത്താന്‍ ഈ ഫോം ഉപയോഗിക്കുക.
പ്രസ്തുത ഉപയോക്താവിനെ ബ്യൂറോക്രാറ്റ് ആയി കൂടെ ഉയര്‍ത്തണമെകില്‍ ബ്രൂറോക്രാറ്റിനടുത്തുള്ള ബോക്സ് തിരഞ്ഞെടുക്കുക.',
	'maintenance-deleteBatch' => 'താളുകള്‍ കൂട്ടത്തോടെ മായ്ക്കുവാന്‍ ഈ താള്‍ ഉപയോഗിക്കുക.
ഓരോ നിരയിലും ഒരു താള്‍ മാത്രം ചേര്‍ക്കുക.',
	'maintenance-deleteRevision' => 'പതിപ്പുകള്‍ കൂട്ടത്തോടെ മായ്ക്കുവാന്‍ ഈ താള്‍ ഉപയോഗിക്കുക.
ഓരോ നിരയിലും ഒരു പതിപ്പ് മാത്രം ചേര്‍ക്കുക.',
	'maintenance-moveBatch' => 'താളുകളുടെ തലക്കെട്ട് കൂട്ടത്തോടെ മാറ്റുവാന്‍ ഈ താള്‍ ഉപയോഗിക്കുക. ഓരോ നിരയില്‍ ഒരു സ്രോതസ്സ് താളും പൈപ്പ് ചിഹനം ഇട്ടു വേര്‍തിരിച്ചതിനു ശേഷം അതിന്റെ ലക്ഷ്യതാളും മാത്രം ചേര്‍ക്കുക.',
	'maintenance-name' => 'ഉപയോക്തൃനാമം',
	'maintenance-password' => 'രഹസ്യവാക്ക്',
	'maintenance-bureaucrat' => 'ഉപയോക്താവിനെ ബ്യൂറോക്രാറ്റ് പദവിയിലേക്കുയര്‍ത്തുക',
	'maintenance-reason' => 'കാരണം',
	'maintenance-confirm' => 'സ്ഥിരീകരിക്കുക',
	'maintenance-invalidname' => 'അസാധുവായ ഉപയോക്തൃനാമം!',
	'maintenance-success' => '$1 വിജയകരമായി ഓടിച്ചിരിക്കുന്നു!',
	'maintenance-userexists' => 'ഉപയോക്തൃനാമം നിലവിലുണ്ട്',
	'maintenance-invalidtitle' => 'അസാധുവായ തലക്കെട്ട് "$1"!',
	'maintenance-titlenoexist' => '("$1") എന്ന ശീര്‍ഷകത്തിലുള്ള ലേഖനം നിലവിലില്ല',
	'maintenance-failed' => 'പരാജയപ്പെട്ടു',
	'maintenance-deleted' => 'മായ്ച്ചു',
	'maintenance-revdelete' => '$2 വിക്കിയില്‍ നിന്ന് $1 പതിപ്പുകള്‍ ഒഴിവാക്കുന്നു',
	'maintenance-revnotfound' => '$1 എന്ന പതിപ്പ് കണ്ടില്ല!',
	'maintenance-stats-edits' => 'തിരുത്തലുകളുടെ എണ്ണം: $1',
	'maintenance-stats-articles' => 'മുഖ്യ നാമമേഖലയിലുള്ള താളുകളുടെ എണ്ണം: $1',
	'maintenance-stats-pages' => 'താളുകളുടെ എണ്ണം: $1',
	'maintenance-stats-users' => 'ഉപയോക്താക്കളുടെ എണ്ണം: $1',
	'maintenance-stats-admins' => 'കാര്യനിര്‍‌വാഹകരുടെ എണ്ണം: $1',
	'maintenance-stats-images' => 'പ്രമാണങ്ങളുടെ എണ്ണം: $1',
	'maintenance-stats-views' => 'പേജ് വ്യൂവിന്റെ എണ്ണം: $1',
	'maintenance-stats-update' => 'ഡാറ്റാബേസ് പുതുക്കുന്നു...',
	'maintenance-move' => '$1 നെ $2 ലേക്ക് മാറ്റുന്നു',
	'maintenance-movefail' => 'താള്‍ മാറ്റുമ്പോള്‍ പിഴവ് സം‌ഭവിച്ചു: $1
മാറ്റം നിര്‍ത്തിവയ്ക്കുന്നു',
	'maintenance-error' => 'പിഴവ്: $1',
	'maintenance-memc-requests' => 'അഭ്യര്‍ത്ഥനകള്‍',
	'maintenance-memc-withsession' => 'സെഷനോടെ:',
	'maintenance-memc-withoutsession' => 'സെഷനില്ലാതെ:',
	'maintenance-memc-total' => 'മൊത്തം:',
	'maintenance-memc-invalid' => 'അസാധു:',
	'maintenance-memc-expired' => 'കാലാവധി:',
	'maintenance-memc-absent' => 'അഭാവം:',
	'maintenance-memc-updates' => 'അപ്‌ഡേറ്റ്സ്:',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'maintenance' => 'व्यवस्थापन स्क्रीप्ट्स चालवा',
	'maintenance-desc' => 'वेगवेगळ्या व्यवस्थापन स्क्रीप्ट्स करिता [[Special:Maintenance|वेब इंटरफेस]]',
	'maintenance-backlink' => 'स्क्रीप्ट निवडीकडे परत चला',
	'maintenance-header' => 'चालविण्यासाठी खालील एक स्क्रीप्ट निवडा.
प्रत्येक स्क्रीप्टच्या पुढे माहिती दिलेली आहे',
	'maintenance-changePassword-desc' => 'एखाद्या सदस्याचा परवलीचा शब्द बदला',
	'maintenance-createAndPromote-desc' => 'एक सदस्य तयार करा व त्याला प्रबंधक बनवा',
	'maintenance-deleteBatch-desc' => 'खूप पाने एकत्र वगळा',
	'maintenance-deleteRevision-desc' => 'डाटाबेस मधून आवृत्त्या वगळा',
	'maintenance-initEditCount-desc' => 'सदस्यांची योगदान संख्या पुन्हा मोजा',
	'maintenance-initStats-desc' => 'सांख्यिकी पुन्हा मोजा',
	'maintenance-moveBatch-desc' => 'खूप पाने एकत्र स्थानांतरीत करा',
	'maintenance-runJobs-desc' => 'कार्य रांगेतील कार्ये करा',
	'maintenance-showJobs-desc' => 'कार्य रांगेतील पूर्ण न झालेल्या कार्यांची यादी दाखवा',
	'maintenance-stats-desc' => 'Memcached सांख्यिकी दाखवा',
	'maintenance-changePassword' => 'हा अर्ज एखाद्या सदस्याचा परवलीचा शब्द बदलण्यासाठी वापरा',
	'maintenance-createAndPromote' => 'हा अर्ज एखादा नवीन सदस्य बनवून त्याला प्रबंधक करण्यासाठी वापरा.
सदस्याला अधिकारी बनविण्यासाठी अधिकारी बॉक्समध्ये सुद्धा टिचकी द्या',
	'maintenance-deleteBatch' => 'हा अर्ज एकाच वेळी अनेक पाने वगळण्यासाठी वापरा.
एका ओळीवर एकच पान लिहा',
	'maintenance-deleteRevision' => 'हा अर्ज अनेक आवृत्त्या एकाचवेळी वगळण्यासाठी वापरा.
एका ओळीवर एकच आवृत्ती लिहा',
	'maintenance-initStats' => 'हा अर्ज सांख्यिकी पुन्हा मोजण्यासाठी वापरा, त्यामध्ये तुम्ही पान बघण्याची सांख्यिकी सुद्धा पुन्हा मोजू शकता',
	'maintenance-moveBatch' => 'हा अर्ज एकाचवेळी अनेक पाने स्थानांतरीत करण्यासाठी वापरा.
प्रत्येक ओळीवर स्रोत पान व लक्ष्य पान पाईप चिन्ह वापरून लिहा',
	'maintenance-invalidtype' => 'चुकीचा प्रकार!',
	'maintenance-name' => 'सदस्यनाव',
	'maintenance-password' => 'परवलीचा शब्द',
	'maintenance-bureaucrat' => 'सदस्याला अधिकारीपद द्या',
	'maintenance-reason' => 'कारण',
	'maintenance-update' => 'सारणी बदलताना UPDATE चा वापर करायचा का? जर निवडले नाही तर DELETE/INSERT चा वापर होईल.',
	'maintenance-noviews' => 'पान पहाण्याची सांख्यिकी न बदलण्यासाठी हे निवडा',
	'maintenance-confirm' => 'निश्चित करा',
	'maintenance-invalidname' => 'चुकीचे सदस्यनाव!',
	'maintenance-success' => '$1 यशस्वीरित्या पूर्ण झाले!',
	'maintenance-userexists' => 'सदस्य अगोदरच अस्तित्वात आहे!',
	'maintenance-invalidtitle' => 'चुकीचे शीर्षक "$1"!',
	'maintenance-titlenoexist' => 'दिलेले शीर्षक ("$1") अस्तित्वात नाही!',
	'maintenance-failed' => 'रद्द झाले',
	'maintenance-deleted' => 'वगळले',
	'maintenance-revdelete' => '$2 या विकिवरील $1 आवृत्त्या वगळत आहे',
	'maintenance-revnotfound' => '$1 आवृत्ती सापडली नाही!',
	'maintenance-stats-edits' => 'संपादनांची संख्या: $1',
	'maintenance-stats-articles' => 'मुख्य नामविश्वातील पानांची संख्या: $1',
	'maintenance-stats-pages' => 'पृष्ठ संख्या: $1',
	'maintenance-stats-users' => 'सदस्य संख्या: $1',
	'maintenance-stats-admins' => 'प्रबंधकांची संख्या: $1',
	'maintenance-stats-images' => 'संचिकांची संख्या: $1',
	'maintenance-stats-views' => 'पाने पहाण्याची संख्या: $1',
	'maintenance-stats-update' => 'डाटाबेस बदलत आहे...',
	'maintenance-move' => ' $1 चे $2 ला स्थानांतरण करीत आहे...',
	'maintenance-movefail' => 'स्थानांतरण करण्यात त्रुटी: $1.
स्थानांतरण रद्द करत आहे',
	'maintenance-error' => 'त्रुटी: $1',
	'maintenance-memc-fake' => 'तुम्ही FakeMemCachedClient चालवित आहात. सांख्यिकी देता येणार नाही',
	'maintenance-memc-requests' => 'मागण्या',
	'maintenance-memc-withsession' => 'सेशन सहित:',
	'maintenance-memc-withoutsession' => 'सेशन रहित:',
	'maintenance-memc-total' => 'एकूण:',
	'maintenance-memc-parsercache' => 'पार्सर सय',
	'maintenance-memc-hits' => 'हिट्स:',
	'maintenance-memc-invalid' => 'अवैध:',
	'maintenance-memc-expired' => 'रद्द झालेले:',
	'maintenance-memc-absent' => 'गैरहजर:',
	'maintenance-memc-stub' => 'स्टब थ्रेशहोल्ड:',
	'maintenance-memc-imagecache' => 'चित्र सय',
	'maintenance-memc-misses' => 'मिसेस:',
	'maintenance-memc-updates' => 'अपडेट्स:',
	'maintenance-memc-uncacheable' => 'सयीत ठेवता येत नाही:',
	'maintenance-memc-diffcache' => 'फरक सय',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 */
$messages['ms'] = array(
	'maintenance-reason' => 'Sebab',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'maintenance-name' => 'Isem l-utent',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'maintenance-name' => 'Теицянь лем',
	'maintenance-password' => 'Совамо вал',
	'maintenance-reason' => 'Тувтал',
	'maintenance-confirm' => 'Кемекстамс',
	'maintenance-failed' => 'ЭЗЬ ЛИСЕ',
	'maintenance-deleted' => 'НАРДАЗЬ',
	'maintenance-stats-edits' => 'Зяроксть витнезь-петнезь: $1',
	'maintenance-stats-pages' => 'Зяро лопатнеде: $1',
	'maintenance-stats-admins' => 'Зяро админтнэде: $1',
	'maintenance-stats-images' => 'Зяро файлатнеде: $1',
	'maintenance-memc-requests' => 'Вешемат',
	'maintenance-memc-total' => 'весемезэ:',
	'maintenance-memc-absent' => 'арась:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'maintenance-name' => 'Tlatequitiltilīltōcāitl',
	'maintenance-password' => 'Tlahtōlichtacāyōtl',
	'maintenance-reason' => 'Īxtlamatiliztli',
	'maintenance-invalidtitle' => '¡Ahcualli tōcāitl "$1"!',
	'maintenance-deleted' => 'TLAPOLOC',
	'maintenance-stats-edits' => 'Tlapatlaliztli tlapōhualli',
	'maintenance-stats-articles' => 'Zāzanilli huēyi tōcātzimpan in ītlapōhual: $1',
	'maintenance-stats-pages' => 'Zāzanilli tlapōhualli: $1',
	'maintenance-stats-users' => 'Tlatequitiltilīlli tlapōhualli: $1',
	'maintenance-stats-images' => 'Tlahcuilōlli tlapōhualli: $1',
	'maintenance-move' => 'Mozacacah $1 īhuīc $2{{int:ellipsis}}',
	'maintenance-memc-total' => 'mochīntīn:',
	'maintenance-memc-expired' => 'ōmotlami:',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'maintenance' => 'Beheerscripts uitvoeren',
	'maintenance-desc' => '[[Special:Maintenance|Wiki-interface]] voor een aantal beheerscripts',
	'right-maintenance' => 'Onderhoudscripts uitvoeren via [[Special:Maintenance]]',
	'maintenance-backlink' => 'Naar scriptselectie terugkeren',
	'maintenance-header' => 'Selecteer hieronder een uit te voeren script.
Beschrijvingen staan naast de scripts',
	'maintenance-changePassword-desc' => 'Wachtwoord van een gebruiker wijzigen',
	'maintenance-createAndPromote-desc' => 'Een nieuwe gebruiker aanmaken en deze beheerder maken',
	'maintenance-deleteBatch-desc' => "Pagina's en masse verwijderen",
	'maintenance-deleteRevision-desc' => 'Versies uit de database verwijderen',
	'maintenance-eval-desc' => 'PHP-code evalueren in de MediaWiki-omgeving',
	'maintenance-initEditCount-desc' => 'Aantal bewerkingen van gebruikers herberekenen',
	'maintenance-initStats-desc' => 'Sitestatistieken herberekenen',
	'maintenance-moveBatch-desc' => "Pagina's en masse hernoemen",
	'maintenance-reassignEdits-desc' => 'Bewerkingen aan een andere gebruiker toewijzen',
	'maintenance-runJobs-desc' => 'Taken uit de jobqueue uitvoeren',
	'maintenance-showJobs-desc' => 'Openstaande taken in de jobqueue bekijken',
	'maintenance-sql-desc' => 'SQL-query uitvoeren',
	'maintenance-stats-desc' => 'Memcachedstatistieken bekijken',
	'maintenance-changePassword' => 'Gebruik dit formulier om het wachtwoord van een gebruiker te wijzigen',
	'maintenance-createAndPromote' => "Gebruik dit formulier om een gebruiker aan te maken en deze beheerder te maken.
Vink het vakje 'bureaucraat' aan om de gebruik ook bureacraat te maken",
	'maintenance-deleteBatch' => "Gebruik dit formulier om en masse pagina's te verwijderen.
Geef op iedere regel een paginanaam op",
	'maintenance-deleteRevision' => 'Gebruik dit formulier om en masse versie te verwijderen.
Geef op iedere regel een paginanaam op',
	'maintenance-initStats' => 'Gebruik dit formulier de sitestatistieken opnieuw te berekenen. Geef daarbij aan of u de tellingen van het aantal keren dat een pagina is bekeken ook wilt bijwerken',
	'maintenance-moveBatch' => 'Gebruik dit formulier om en masse pagina\'s te hernoemen.
Iedere regel moet een doelpagina en een bestemmingspagina bevatten, gescheiden door een pipe-teken ("|")',
	'maintenance-invalidtype' => 'Ongeldig type!',
	'maintenance-name' => 'Gebruiker',
	'maintenance-password' => 'Wachtwoord',
	'maintenance-bureaucrat' => 'De gebruiker bureaucraat maken',
	'maintenance-reason' => 'Reden',
	'maintenance-update' => 'Gebruik UPDATE als u een tabel wilt bijwerken? Unchecked gebruiker in plaats daarvan DELETE/INSERT.',
	'maintenance-noviews' => 'Vink dit aan om te voorkomen dat het aantal keren dat een pagina is bekeken wordt bijgewerkt',
	'maintenance-confirm' => 'Bevestigen',
	'maintenance-invalidname' => 'Ongeldige gebruikersnaam!',
	'maintenance-success' => '$1 is uitgevoerd!',
	'maintenance-userexists' => 'De gebruiker bestaat al!',
	'maintenance-invalidtitle' => 'Ongeldige paginanaam "$1"!',
	'maintenance-titlenoexist' => 'De opgegeven pagina ("$1") bestaat niet!',
	'maintenance-failed' => 'Mislukt',
	'maintenance-deleted' => 'Verwijderd',
	'maintenance-revdelete' => 'Bezig met het verwijderen van {{PLURAL:$3|versie|versies}} $1 van wiki $2',
	'maintenance-revnotfound' => 'Versie $1 niet gevonden!',
	'maintenance-sql' => 'Gebruik dit formulier om een SQL-query op de database uit te voeren.',
	'maintenance-sql-aff' => 'Getroffen rijen: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|rij|rijen}} in resultaat:
$2',
	'maintenance-stats-edits' => 'Aantal bewerkingen: $1',
	'maintenance-stats-articles' => "Aantal pagina's in de hoofdnaamruimte: $1",
	'maintenance-stats-pages' => "Aantal pagina's: $1",
	'maintenance-stats-users' => 'Aantal gebruikers: $1',
	'maintenance-stats-admins' => 'Aantal beheerders: $1',
	'maintenance-stats-images' => 'Aantal bestanden: $1',
	'maintenance-stats-views' => "Aantal bekeken pagina's: $1",
	'maintenance-stats-update' => 'Bezig met het bijwerken van de database…',
	'maintenance-move' => 'Bezig met het hernoemen van $1 naar $2…',
	'maintenance-movefail' => 'Er is een fout opgetreden bij het hernoemen: $1.
Hernoemen is afgebroken',
	'maintenance-error' => 'Fout: $1',
	'maintenance-memc-fake' => 'U maakt gebruik van FakeMemCachedClient. Het is niet mogelijk statistieken te berekenen',
	'maintenance-memc-requests' => 'Verzoeken',
	'maintenance-memc-withsession' => 'met sessie:',
	'maintenance-memc-withoutsession' => 'zonder sessie:',
	'maintenance-memc-total' => 'totaal:',
	'maintenance-memc-parsercache' => 'Parsercache',
	'maintenance-memc-hits' => 'hits:',
	'maintenance-memc-invalid' => 'ongeldig:',
	'maintenance-memc-expired' => 'vervallen:',
	'maintenance-memc-absent' => 'afwezig:',
	'maintenance-memc-stub' => 'stubdrempelwaarde:',
	'maintenance-memc-imagecache' => 'Beeldencache',
	'maintenance-memc-misses' => 'gemist:',
	'maintenance-memc-updates' => 'bijgewerkt:',
	'maintenance-memc-uncacheable' => 'kan niet gecached worden:',
	'maintenance-memc-diffcache' => 'Diff cache',
	'maintenance-eval' => 'Gebruik dit formulier om PHP-code in de MediaWiki-omgeving te evalueren.',
	'maintenance-reassignEdits' => 'Gebruik dit formulier om bewerkingen aan een andere gebruiker toe te wijzen.',
	'maintenance-re-from' => 'Brongebruiker',
	'maintenance-re-to' => 'Doelgebruiker',
	'maintenance-re-force' => 'Ook toewijzen als de doelgebruiker niet bestaat',
	'maintenance-re-rc' => 'Recente wijzigingen niet bijwerken',
	'maintenance-re-report' => 'Details weergeven van te maken wijzigingen zonder daarwerkelijk bij te werken',
	'maintenance-re-nf' => 'Gebruiker $1 bestaat niet',
	'maintenance-re-rr' => 'Voer de handeling opnieuw uit met bijwerken door de optie "$1" uit te schakelen.',
	'maintenance-re-ce' => 'Huidige bewerkingen: $1',
	'maintenance-re-de' => 'Verwijderde bewerkingen: $1',
	'maintenance-re-rce' => 'Regels in recente wijzigingen: $1',
	'maintenance-re-total' => 'Aantal bij te werken bewerkingen: $1',
	'maintenance-re-re' => 'Bezig met het toewijzen… Klaar',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'maintenance' => 'Køyr vedlikehaldsskript',
	'maintenance-desc' => '[[Special:Maintenance|Wikigrensesnitt]] for ymse vedlikehaldsskript',
	'right-maintenance' => 'Køyra vedlikehaldsskript gjennom [[Special:Maintenance]]',
	'maintenance-backlink' => 'Attende til skriptval',
	'maintenance-header' => 'Vel eit skript under som skal verta køyrt.
Skildringa til kvart skript ligg ved sida det.',
	'maintenance-changePassword-desc' => 'Endra passordet til ein brukar',
	'maintenance-createAndPromote-desc' => 'Opprett ein brukar og gjer han til administrator',
	'maintenance-deleteBatch-desc' => 'Masseslett sider',
	'maintenance-deleteRevision-desc' => 'Fjern versjonar frå databasen',
	'maintenance-eval-desc' => 'Evaluer PHP-kode i MediaWiki-omgjevnadene',
	'maintenance-initEditCount-desc' => 'Rekn om endringsteljaren til brukarar',
	'maintenance-initStats-desc' => 'Rekn om sidestatistikken',
	'maintenance-moveBatch-desc' => 'Masseflytt sider',
	'maintenance-reassignEdits-desc' => 'Flytta endringar frå ein brukar til ein annan',
	'maintenance-runJobs-desc' => 'Køyra jobbar i jobbkøen',
	'maintenance-showJobs-desc' => 'Syn ei lista over jobbar som ventar i jobbkøen',
	'maintenance-sql-desc' => 'Utfør ei SQL-spørjing',
	'maintenance-stats-desc' => 'Vis mellomlagra statistikk',
	'maintenance-changePassword' => 'Nytt dette skjemaet for å endra passordet til ein brukar.',
	'maintenance-createAndPromote' => 'Nytt dette skjemaet for å oppretta ein ny brukar og gjera han til administrator.
Kryss av i byråkratboksen om du ønskjer å gjera han til byråkrat òg',
	'maintenance-deleteBatch' => 'Nytt dette skjemaet for å sletta mange sider på éin gong.
Skriv inn berre éin sidetittel per rad.',
	'maintenance-deleteRevision' => 'Nytt dette skjemaet for å sletta mange versjonar på éin gong.
Skriv berre inn eitt versjonsnummer per rad.',
	'maintenance-initStats' => 'Nytt dette skjemaet for å rekna ut sidestatistikken på nytt. Spesifiser om du òg ynskjer å rekna ut sidevisingar på nytt',
	'maintenance-moveBatch' => 'Nytt dette skjemaet for å flytta mange sider på éin gong.
Kvar linja bør oppgje ei kjeldesida og ei målsida skilde med ein strek (|).',
	'maintenance-invalidtype' => 'Ugyldig type!',
	'maintenance-name' => 'Brukarnamn',
	'maintenance-password' => 'Passord',
	'maintenance-bureaucrat' => 'Gjer ein brukar til byråkrat',
	'maintenance-reason' => 'Årsak',
	'maintenance-update' => 'Nytt UPDATE under oppdatering av tabell? Om uavkryssa vert DELETE/INSERT nytta i staden.',
	'maintenance-noviews' => 'Kryss av her for ikkje å oppdatera sidevisingar',
	'maintenance-confirm' => 'Stadfest',
	'maintenance-invalidname' => 'Ugyldig brukarnamn.',
	'maintenance-success' => '$1 blei køyrt gjennom utan problem.',
	'maintenance-userexists' => 'Brukaren finst frå før.',
	'maintenance-invalidtitle' => 'Tittelen «$1» er ugyldig.',
	'maintenance-titlenoexist' => 'Den oppgjevne tittelen («$1») finst ikkje.',
	'maintenance-failed' => 'MISLUKKAST',
	'maintenance-deleted' => 'SLETTA',
	'maintenance-revdelete' => 'Slettar {{PLURAL:$3|versjonen|versjonane}} $1 frå wikien $2',
	'maintenance-revnotfound' => 'Fann ikkje versjonen $1.',
	'maintenance-sql' => 'Nytt dette skjemaet for å utføra ein SQL-spørjing på databasen.',
	'maintenance-sql-aff' => 'Råka rekkjer: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|éi rekkja|$1 rekkjer}} gav:
$2',
	'maintenance-stats-edits' => 'Tal på endringar: $1',
	'maintenance-stats-articles' => 'Tal på sider i hovudnamnerommet: $1',
	'maintenance-stats-pages' => 'Tal på sider: $1',
	'maintenance-stats-users' => 'Tal på brukarar: $1',
	'maintenance-stats-admins' => 'Tal på administratorar: $1',
	'maintenance-stats-images' => 'Tal på filer: $1',
	'maintenance-stats-views' => 'Tal på sidevisingar: $1',
	'maintenance-stats-update' => 'Oppdaterer databasen …',
	'maintenance-move' => 'Flyttar $1 til $2 …',
	'maintenance-movefail' => 'Feil oppstod under flytting: $1.
Stoggar flytting.',
	'maintenance-error' => 'Feil: $1',
	'maintenance-memc-fake' => 'Du køyrer ein FakeMemCachedClient. Ingen statistikk kan verta oppgjeven.',
	'maintenance-memc-requests' => 'Førespurnader',
	'maintenance-memc-withsession' => 'med økt:',
	'maintenance-memc-withoutsession' => 'utan økt:',
	'maintenance-memc-total' => 'totalt:',
	'maintenance-memc-parsercache' => 'Parsermellomlager',
	'maintenance-memc-hits' => 'treff:',
	'maintenance-memc-invalid' => 'ugyldig:',
	'maintenance-memc-expired' => 'gjekk ut:',
	'maintenance-memc-absent' => 'fråverande:',
	'maintenance-memc-stub' => 'spireterskel:',
	'maintenance-memc-imagecache' => 'Biletmellomlager',
	'maintenance-memc-misses' => 'gleppar:',
	'maintenance-memc-updates' => 'oppdateringar:',
	'maintenance-memc-uncacheable' => 'kan ikkje verta mellomlagra:',
	'maintenance-memc-diffcache' => 'Skilnadsmellomlager',
	'maintenance-eval' => 'Nytt dette skjemaet til å evaluera PHP-kode i MediaWiki-omgjevnader.',
	'maintenance-reassignEdits' => 'Nytt dette skjemaet til å flytta endringar frå ein brukar til ein annan.',
	'maintenance-re-from' => 'Namnet på brukaren som skal endringane skal verta tekne frå',
	'maintenance-re-to' => 'Namnet på brukaren som skal få endringane',
	'maintenance-re-force' => 'Flytt endringar sjølv om målbrukar ikkje finst',
	'maintenance-re-rc' => 'Ikkje oppdater tabellen over siste endringar',
	'maintenance-re-report' => 'Skriv ut detaljar av det som ville ha vorte endra, men ikkje oppdater',
	'maintenance-re-nf' => 'Fann ikkje brukaren «$1»',
	'maintenance-re-rr' => 'Køyr skriptet omatt utan «$1» for å oppdatera.',
	'maintenance-re-ce' => 'Noverande endringar: $1',
	'maintenance-re-de' => 'Sletta endringar: $1',
	'maintenance-re-rce' => 'Bidrag på siste endringar: $1',
	'maintenance-re-total' => 'Endringar som skal verta endra: $1',
	'maintenance-re-re' => 'Flyttar endringar{{int:ellipsis}} gjort',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 * @author Simny
 */
$messages['no'] = array(
	'maintenance' => 'Kjør vedlikeholdsskript',
	'maintenance-desc' => '[[Special:Maintenance|Nettgrensesnitt]] for ulike vedlikeholdsskript',
	'right-maintenance' => 'Kjør vedlikeholdsskript gjennom [[Special:Maintenance]]',
	'maintenance-backlink' => 'Tilbake til skriptvalget',
	'maintenance-header' => 'Velg et skript å utføre nedenfor.
Beskrivelser gis ved siden av hvert skript.',
	'maintenance-changePassword-desc' => 'Endre en brukers passord',
	'maintenance-createAndPromote-desc' => 'Opprett en bruker og gjør til administrator',
	'maintenance-deleteBatch-desc' => 'Slett mange sider',
	'maintenance-deleteRevision-desc' => 'Fjern revisjoner fra databasen',
	'maintenance-eval-desc' => 'Evaluer PHP-kode i MediaWiki-omgivelsene',
	'maintenance-initEditCount-desc' => 'Regne om redigeringstelleren for brukere',
	'maintenance-initStats-desc' => 'Regne om sidestatistikken',
	'maintenance-moveBatch-desc' => 'Flytte mange sider',
	'maintenance-runJobs-desc' => 'Kjøre jobber i jobbkøen',
	'maintenance-showJobs-desc' => 'Vise en liste over jobber som venter i jobbkøen',
	'maintenance-sql-desc' => 'Utfør en SQL-spørring',
	'maintenance-stats-desc' => 'Vis mellomlagret statistikk',
	'maintenance-changePassword' => 'Bruk dette skjemaet for å endre en brukers passord',
	'maintenance-createAndPromote' => 'Bruk dette skjemaet for å opprette en ny bruker og gjøre den til administrator.
Kryss av i byråkratboksen om du ønsker å gjøre den til byråkrat også',
	'maintenance-deleteBatch' => 'Bruk dette skjemaet for å slette mange sider på én gang.
Skriv én sidetittel per rad',
	'maintenance-deleteRevision' => 'Bruk dette skjemaet for å slette mange revisjoner på én gang.
Skriv ett revisjonsnummer per rad',
	'maintenance-initStats' => 'Bruk dette skjemaet for å regne ut sidestatistikken på nytt, spesielt om du vil regne ut sidevisninger på nytt',
	'maintenance-moveBatch' => 'Bruk dette skjemaet for å flytte mange sider på én gang.
Hver linje bør oppgi kildeside og målside adskilt med strek (|)',
	'maintenance-invalidtype' => 'Ugyldig type!',
	'maintenance-name' => 'Brukernavn',
	'maintenance-password' => 'Passord',
	'maintenance-bureaucrat' => 'Forfrem en bruker til byråkrat',
	'maintenance-reason' => 'Årsak',
	'maintenance-update' => 'Bruk UPDATE under oppdatering av tabell? Om uavkrysset brukes DELETE/INSERT i stedet.',
	'maintenance-noviews' => 'Kryss av her for ikke å oppdatere sidevisninger',
	'maintenance-confirm' => 'Bekreft',
	'maintenance-invalidname' => 'Ugyldig brukernavn.',
	'maintenance-success' => '$1 ble gjennomført uten uhell.',
	'maintenance-userexists' => 'Brukeren finnes allerede.',
	'maintenance-invalidtitle' => 'Ugyldig tittel «$1».',
	'maintenance-titlenoexist' => 'Den oppgitte tittelen («$1») finnes ikke.',
	'maintenance-failed' => 'MISLYKTES',
	'maintenance-deleted' => 'SLETTET',
	'maintenance-revdelete' => 'Sletter {{PLURAL:$3|revisjonen|revisjonene}} $1 fra wikien $2',
	'maintenance-revnotfound' => 'Revisjon $1 ikke funnet.',
	'maintenance-sql' => 'Bruk dette skjemaet for å utføre en SQL-spørring på databasen.',
	'maintenance-sql-aff' => 'Berørte rekker: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|én rad|$1 rader}} returnerte:
$2',
	'maintenance-stats-edits' => 'Antal redigeringer: $1',
	'maintenance-stats-articles' => 'Antall sider i hovednavnerommet: $1',
	'maintenance-stats-pages' => 'Antall sider: $1',
	'maintenance-stats-users' => 'Antall brukere: $1',
	'maintenance-stats-admins' => 'Antall administratorer: $1',
	'maintenance-stats-images' => 'Antall filer: $1',
	'maintenance-stats-views' => 'Antall sidevisninger: $1',
	'maintenance-stats-update' => 'Oppdaterer database …',
	'maintenance-move' => 'Flytter $1 til $2 …',
	'maintenance-movefail' => 'Feil oppsto under flytting: $1.
Avbryter flytting',
	'maintenance-error' => 'Feil: $1',
	'maintenance-memc-fake' => 'Du kjører en FakeMemCachedClient. Ingen statistikk kan oppgis.',
	'maintenance-memc-requests' => 'Forespørsler',
	'maintenance-memc-withsession' => 'med sesjon:',
	'maintenance-memc-withoutsession' => 'uten sesjon:',
	'maintenance-memc-total' => 'totalt:',
	'maintenance-memc-parsercache' => 'Parsermellomlager',
	'maintenance-memc-hits' => 'treff:',
	'maintenance-memc-invalid' => 'ugyldig:',
	'maintenance-memc-expired' => 'utgikk:',
	'maintenance-memc-absent' => 'ikke til stede:',
	'maintenance-memc-stub' => 'stubbgrense:',
	'maintenance-memc-imagecache' => 'Bildemellomlager',
	'maintenance-memc-misses' => 'bom:',
	'maintenance-memc-updates' => 'Oppdateringer:',
	'maintenance-memc-uncacheable' => 'Kan ikke mellomlagres:',
	'maintenance-memc-diffcache' => 'Forskjellsmellomlager',
	'maintenance-eval' => 'Bruk dette skjemaet for å evaluere PHP-kode i MediaWiki-miljøet.',
	'maintenance-re-rc' => 'Ikke oppdater tabellen over siste endringer',
	'maintenance-re-report' => 'Skriv ut detaljer av det som ville ha endret seg, men ikke oppdater det',
	'maintenance-re-nf' => 'Fant ikke bruker $1',
	'maintenance-re-rr' => 'Kjør skriptet igjen uten «$1» for å oppdatere.',
	'maintenance-re-ce' => 'Nåværende redigeringer: $1',
	'maintenance-re-de' => 'Slettede redigeringer: $1',
	'maintenance-re-rce' => 'Bidrag på siste endringer: $1',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'maintenance-reason' => 'Resone',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'maintenance' => 'Aviar los escripts de mantenença',
	'maintenance-desc' => '[[Special:Maintenance|Interfàcia Web]] pels diferents escripts de mantenença',
	'right-maintenance' => "Aviar d'escriptes de mantenença dempuèi [[Special:Maintenance]]",
	'maintenance-backlink' => "Retorn cap a la seleccion de l'escript",
	'maintenance-header' => "Seleccionatz, çaijós, un escript d'executar.
Las descripcions son a la seguida de cadun d'aquestes.",
	'maintenance-changePassword-desc' => 'Cambiar lo senhal d’un utilizaire',
	'maintenance-createAndPromote-desc' => "Crear un utilizaire e promòure a l'estatut d’administrator",
	'maintenance-deleteBatch-desc' => 'Supression en massa de las paginas',
	'maintenance-deleteRevision-desc' => 'Levar las versions de la banca de donadas',
	'maintenance-eval-desc' => "Avalorar un còde PHP dins l'environament MediaWiki",
	'maintenance-initEditCount-desc' => 'Tornar calcular los comptadors d’edicions dels utilizaires',
	'maintenance-initStats-desc' => 'Tornar calcular las estatisticas del site',
	'maintenance-moveBatch-desc' => 'Cambiament de nom en massa de las paginas',
	'maintenance-reassignEdits-desc' => "Tornar assignar de modificacions d'un utilizaire cap a un autre",
	'maintenance-runJobs-desc' => "Aviar los prètzfaches dins la lista de los d'acomplir",
	'maintenance-showJobs-desc' => "Afichar una lista dels prètzfaches en cors dins la lista de los d'acomplir",
	'maintenance-sql-desc' => 'Executar una requèsta SQL',
	'maintenance-stats-desc' => 'Afichar las estatisticas de la memòria-amagatal',
	'maintenance-changePassword' => 'Utilizar aqueste formulari per cambiar lo senhal d’un utilizaire',
	'maintenance-createAndPromote' => 'Utilizar aqueste formulari per crear un utilizaire novèl e per lo promòure administrator.
Marcar la casa burocrata se li desiratz conferir tanben aqueste estatut.',
	'maintenance-deleteBatch' => 'Utilizatz aqueste formulari per suprimir en massa de paginas/
Indicar una sola pagina per linha',
	'maintenance-deleteRevision' => 'Utilizatz aqueste formulari per suprimir en massa las versions.
Indicatz una sola version per linha',
	'maintenance-initStats' => 'Utilizatz aqueste formulari per tornar calcular las estatisticas del site, en indicant, se fa mestièr, se desiratz lo recalcul del nombre de visitas per pagina.',
	'maintenance-moveBatch' => 'Utilizatz aqueste formulari per desplaçar en massa las paginas.
Cada linha deurà indicar la pagina d’origina e la de destinacion ; las qualas deuràn èsser separadas per un « <nowiki>|</nowiki> »',
	'maintenance-invalidtype' => 'Tipe incorrècte !',
	'maintenance-name' => "Nom d'utilizaire",
	'maintenance-password' => 'Senhal',
	'maintenance-bureaucrat' => "Promòure l’utilizaire a l'estatut de burocrata",
	'maintenance-reason' => 'Motiu',
	'maintenance-update' => "Utilizar UPDATE al moment de la mesa a jorn d'una taula ? Desmarcatz l'usatge DELETE/INSERT al luòc d'aquò.",
	'maintenance-noviews' => 'Marcar aquò per evitar la mesa a jorn del nombre de visitas de las paginas.',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-invalidname' => 'Nom d’utilizaire incorrècte !',
	'maintenance-success' => '$1 a marchat amb succès !',
	'maintenance-userexists' => 'L’utilizaire existís ja !',
	'maintenance-invalidtitle' => 'Títol incorrècte « $1 » !',
	'maintenance-titlenoexist' => 'Lo títol indicat (« $1 ») existís pas !',
	'maintenance-failed' => 'FRACÀS',
	'maintenance-deleted' => 'SUPRIMIT',
	'maintenance-revdelete' => 'Supression {{PLURAL:$3|de la revision|de las revisions}} $1 del wiki $2',
	'maintenance-revnotfound' => 'Version $1 introbabla !',
	'maintenance-sql' => 'Utilizatz aquesta forma per executar una requèsta SQL sus la banca de donadas.',
	'maintenance-sql-aff' => 'Linhas afectadas : $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|linha renviada|linhas renviadas}} :
$2',
	'maintenance-stats-edits' => 'Nombre d’edicions : $1',
	'maintenance-stats-articles' => 'Nombre de paginas dins lo meteis espaci : $1',
	'maintenance-stats-pages' => 'Nombre de paginas : $1',
	'maintenance-stats-users' => "Nombre d'utilizaires : $1",
	'maintenance-stats-admins' => "Nombre d'administrators : $1",
	'maintenance-stats-images' => 'Nombre de fichièrs : $1',
	'maintenance-stats-views' => 'Nombre de paginas visitadas : $1',
	'maintenance-stats-update' => 'Mesa a jorn de la banca de donadas…',
	'maintenance-move' => 'Desplaçament de $1 cap a $2…',
	'maintenance-movefail' => 'Error constatada al moment del cambiament de nom : $1.
Arrèst del desplaçament.',
	'maintenance-error' => 'Error : $1',
	'maintenance-memc-fake' => "Sètz a aviar FakeMemCachedClient. Cap d'estatistica serà pas provesida.",
	'maintenance-memc-requests' => 'Requèstas',
	'maintenance-memc-withsession' => 'amb la sesilha :',
	'maintenance-memc-withoutsession' => 'sens la sesilha :',
	'maintenance-memc-total' => 'soma :',
	'maintenance-memc-parsercache' => 'Amagatal del parser',
	'maintenance-memc-hits' => 'clics :',
	'maintenance-memc-invalid' => 'invalid :',
	'maintenance-memc-expired' => 'expirats :',
	'maintenance-memc-absent' => 'absent :',
	'maintenance-memc-stub' => 'sulhèt de despart :',
	'maintenance-memc-imagecache' => 'Amagatal imatge',
	'maintenance-memc-misses' => 'perduts :',
	'maintenance-memc-updates' => 'meses a jorn :',
	'maintenance-memc-uncacheable' => "fòra de l'amagatal :",
	'maintenance-memc-diffcache' => 'Amagatal dels dif',
	'maintenance-eval' => 'Utilizatz aquesta forma per avalorar lo còde PHP dins un environament MediaWiki.',
	'maintenance-reassignEdits' => "Utilizatz aqueste formulari per tornar assignar de modificacions d'un utilizaire cap a un autre.",
	'maintenance-re-from' => "Nom de l'utilizaire al qual préner las modificacions",
	'maintenance-re-to' => "Nom de l'utilizaire al qual assignar las modificacions",
	'maintenance-re-force' => "Tornar assignar quitament se l'utilizaire cibla existís pas",
	'maintenance-re-rc' => 'Modificar pas la taula dels darrièrs cambiaments',
	'maintenance-re-report' => 'Afichar los detalhs de çò que va èsser modificat, mas sens metre a jorn las donadas',
	'maintenance-re-nf' => "L'utilizaire « $1 » es pas estat trobat",
	'maintenance-re-rr' => "Aviar tornmai l'escript sens metre a jorn « $1 ».",
	'maintenance-re-ce' => 'Modificacions actualas : $1.',
	'maintenance-re-de' => 'Modificacions suprimidas : $1',
	'maintenance-re-rce' => 'Entradas dins la taula dels darrièrs cambiaments : $1',
	'maintenance-re-total' => 'Nombre total de modificacions de modificar : $1',
	'maintenance-re-re' => 'Reafectacion dels cambiaments{{int:ellipsis}} fach',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'maintenance-reason' => 'Аххос',
	'maintenance-deleted' => 'АППÆРСТ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'maintenance-name' => 'Yuuser-Naame',
	'maintenance-password' => 'Paesswatt',
	'maintenance-reason' => 'Grund',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'maintenance-name' => 'Bruckernome',
	'maintenance-password' => 'Passwuat',
);

/** Polish (Polski)
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'maintenance' => 'Uruchom skrypty konserwacyjne',
	'maintenance-desc' => '[[Special:Maintenance|Interfejs]] dla różnych skryptów konserwacyjnych',
	'right-maintenance' => 'Uruchamianie skryptów konserwacyjnych z wykorzystaniem [[Special:Maintenance]]',
	'maintenance-backlink' => 'Wróć do wyboru skryptu',
	'maintenance-header' => 'Wybierz skrypt, który chcesz uruchomić.
Przy nazwach skryptów znajdują się ich opisy.',
	'maintenance-changePassword-desc' => 'Zmień hasło użytkownika',
	'maintenance-createAndPromote-desc' => 'Utwórz użytkownika i nadaj mu uprawnienia administratora',
	'maintenance-deleteBatch-desc' => 'Usuń masowo strony',
	'maintenance-initEditCount-desc' => 'Przelicz ponownie liczniki edycji użytkowników',
	'maintenance-initStats-desc' => 'Przelicz ponownie statystyki strony',
	'maintenance-moveBatch-desc' => 'Przenieś masowo strony',
	'maintenance-runJobs-desc' => 'Uruchom zadania z kolejki',
	'maintenance-showJobs-desc' => 'Pokaż kolejkę zadań oczekujących na wykonanie',
	'maintenance-changePassword' => 'Użyj tego formularza, by zmienić hasło użytkownika',
	'maintenance-createAndPromote' => 'Użyj tego formularza, by utworzyć nowe konto użytkownika i nadać mu uprawnienia administratora.
Zaznacz pole wyboru poniżej, aby przyznać mu również uprawnienia biurokraty.',
	'maintenance-deleteBatch' => 'Używaj tego formularza do masowego usuwania stron.
W każdej linijce podaj tylko jedną nazwę strony.',
	'maintenance-deleteRevision' => 'Używaj tego formularza do masowego usuwania wersji artykułów.
W każdej linijce podaj tylko jeden numer wersji artykułu.',
	'maintenance-name' => 'Nazwa użytkownika',
	'maintenance-password' => 'Hasło',
	'maintenance-bureaucrat' => 'Przyznaj użytkownikowi uprawnienia biurokraty',
	'maintenance-reason' => 'Powód',
	'maintenance-confirm' => 'Potwierdź',
	'maintenance-userexists' => 'Użytkownik już istnieje!',
	'maintenance-invalidtitle' => 'Niepoprawny tytuł „$1”!',
	'maintenance-titlenoexist' => 'Wybrana nazwa „$1” nie istnieje!',
	'maintenance-failed' => 'NIEPOWODZENIE',
	'maintenance-deleted' => 'USUNIĘTO',
	'maintenance-revdelete' => 'Usuwanie {{PLURAL:$3|wersji|wersji:}} $1 z wiki $2',
	'maintenance-revnotfound' => 'Wersja $1 nie została odnaleziona!',
	'maintenance-stats-edits' => 'Liczba edycji $1',
	'maintenance-stats-articles' => 'Liczba stron w głównej przestrzeni nazw $1',
	'maintenance-stats-pages' => 'Liczba stron: $1',
	'maintenance-stats-users' => 'Liczba użytkowników: $1',
	'maintenance-stats-admins' => 'Liczba administratorów: $1',
	'maintenance-stats-images' => 'Liczba plików: $1',
	'maintenance-stats-views' => 'Liczba odwiedzin strony: $1',
	'maintenance-stats-update' => 'Aktualizacja bazy danych{{int:ellipsis}}',
	'maintenance-move' => 'Przenoszenie $1 do $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Wystąpił błąd przy przenoszeniu $1.
Przenoszenie przerwane.',
	'maintenance-error' => 'Błąd: $1',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'maintenance' => 'Fa giré script ëd manutension',
	'maintenance-desc' => '[[Special:Maintenance|Antërfacia Wiki]] për vàire script ëd manutension',
	'right-maintenance' => 'Fa giré un senari ëd manutension con [[Special:Maintenance]]',
	'maintenance-backlink' => 'André a la selession dël senari',
	'maintenance-header' => "Për piasì ch'a selession-a un senari sì-sota da fé giré.
Le descrission a son tacà a minca senari",
	'maintenance-changePassword-desc' => 'Cangia na ciav utent',
	'maintenance-createAndPromote-desc' => "Creé n'utent e promeuvlo a aministrator",
	'maintenance-deleteBatch-desc' => 'Scancelassion ëd pàgine a bocc',
	'maintenance-deleteRevision-desc' => 'Gava revision dal database',
	'maintenance-eval-desc' => "Valuté un còdes PHP ant l'ambient MediaWiki",
	'maintenance-initEditCount-desc' => "Torna calcolé ij conteur ëd modìfiche dj'utent",
	'maintenance-initStats-desc' => 'Torna calcolé le statìstiche dël sit',
	'maintenance-moveBatch-desc' => 'tramuda pàgine a bocc',
	'maintenance-reassignEdits-desc' => "Riassigna modìfiche da n'utent a n'àutr",
	'maintenance-runJobs-desc' => 'Fà giré ij travajòt ant la coa dij travajòt',
	'maintenance-showJobs-desc' => 'Smon-e na lista dij travajòt an cors ant la coa dij travajòt',
	'maintenance-sql-desc' => "Fé n'arcesta SQL",
	'maintenance-stats-desc' => 'Smon-e le statìstiche dla memòria local',
	'maintenance-changePassword' => "Dovré ës formolari për cangé na ciav ëd n'utent",
	'maintenance-createAndPromote' => "Dovré ës formolari për creé un neuv utent e promeuvlo a aministrator.
Marché la casela mangiapapé s'a veul ëdcò promeuvlo a mangiapapé",
	'maintenance-deleteBatch' => 'Dovré ës formolari për scancelé dle pàgine a bocc.
Buté mach na pàgina për linia',
	'maintenance-deleteRevision' => 'Dovré ës formolari për scancelé dle revision a bocc.
Buté mach un nùmer ëd revision për linia',
	'maintenance-initStats' => "Dovré ës formolari për calcolé torna le statìstiche dël sit, spessificand s'a veul ëdcò calcolé torna le vìsite a le pàgine",
	'maintenance-moveBatch' => 'Dovré ës formolari për tramudé dle pàgine a bocc.
Minca linia a dovrìa spessifiché na pàgina sorgiss e na pàgina destinassion separà da na bara vertical',
	'maintenance-invalidtype' => 'Sòrt pa bon-a!',
	'maintenance-name' => 'Nòm utent',
	'maintenance-password' => 'Ciav',
	'maintenance-bureaucrat' => 'Promeuv utent a mangiapapé',
	'maintenance-reason' => 'Rason',
	'maintenance-update' => "Dovré UPDATE an modificand na tàula? Se pa marcà, a sò pòst a l'é dovrà DELETE/INSERT.",
	'maintenance-noviews' => "Marché sòn për ch'as modìfica pa ël nùmer ëd vìsite dle pàgine",
	'maintenance-confirm' => 'Conferma',
	'maintenance-invalidname' => 'Nòm utent pa bon!',
	'maintenance-success' => "$1 a l'ha girà da bin!",
	'maintenance-userexists' => "L'utent a esist già!",
	'maintenance-invalidtitle' => 'Tìtol "$1" pa bon!',
	'maintenance-titlenoexist' => 'Ël tìtol spessificà ("$1") a esist pa!',
	'maintenance-failed' => 'FALÌ',
	'maintenance-deleted' => 'SCANCELÀ',
	'maintenance-revdelete' => 'Scancelassion {{PLURAL:$3|dla revision|dle revision}} $1 da la wiki $2',
	'maintenance-revnotfound' => 'Revision $1 pa trovà!',
	'maintenance-sql' => "Dovré ës formolari për fé n'arcesta SQL an sla base ëd dàit.",
	'maintenance-sql-aff' => 'Righe tocà: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|riga|righe}} artornà:
$2',
	'maintenance-stats-edits' => 'Nùmer ëd modìfiche: $1',
	'maintenance-stats-articles' => 'Nùmer ëd pàgine ant lë spassi nominal prinsipal: $1',
	'maintenance-stats-pages' => 'Nùmer ëd pàgine: $1',
	'maintenance-stats-users' => "Nùmer d'utent: $1",
	'maintenance-stats-admins' => "Nùmer d'aministrator: $1",
	'maintenance-stats-images' => "Nùmer d'archivi: $1",
	'maintenance-stats-views' => 'Nùmer ëd pàgine visità: $1',
	'maintenance-stats-update' => 'Modìfica dla base ëd dàit{{int:ellipsis}}',
	'maintenance-move' => 'Bogé $1 a $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Eror ancontrà an tramudand: $1.
Tramud abortì',
	'maintenance-error' => 'Eror: $1',
	'maintenance-memc-fake' => "A l'é an camin ch'a fa giré FakeMemCachedClient. Gnun-a statìstica a peul esse smonùa",
	'maintenance-memc-requests' => 'Arceste',
	'maintenance-memc-withsession' => 'con session:',
	'maintenance-memc-withoutsession' => 'sensa session:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Memòria local dël parser',
	'maintenance-memc-hits' => 'colp:',
	'maintenance-memc-invalid' => 'pa bon:',
	'maintenance-memc-expired' => 'scadù:',
	'maintenance-memc-absent' => 'assent:',
	'maintenance-memc-stub' => 'livel dë sbòss:',
	'maintenance-memc-imagecache' => 'Memòria local dle figure',
	'maintenance-memc-misses' => 'mancant:',
	'maintenance-memc-updates' => 'modìfiche:',
	'maintenance-memc-uncacheable' => 'fòra dla memòria local:',
	'maintenance-memc-diffcache' => 'Memòria local dle diferense',
	'maintenance-eval' => "Dovré ës formolari për valuté ël còdes PHP ant l'ambient WikiMedia.",
	'maintenance-reassignEdits' => "Dovré ës formolari për riassigné dle modìfiche da n'utent a n'àutr.",
	'maintenance-re-from' => "Nòm ëd l'utent da 'ndoa pijé le modìfiche",
	'maintenance-re-to' => "Nòm ëd l'utent andoa assigné le modìfiche",
	'maintenance-re-force' => "Riassigné ëdcò se l'utent dëstinatari a esist pa",
	'maintenance-re-rc' => 'Modifiché pa la tàula dij cangiament recent',
	'maintenance-re-report' => "Smon-e ij detaj ëd lòn ch'a sarìa cangià, ma sensa modifichelo",
	'maintenance-re-nf' => 'Utent $1 pa trovà',
	'maintenance-re-rr' => 'Fa giré torna ël senari sensa modifiché "$1".',
	'maintenance-re-ce' => 'Modìfiche corente: $1',
	'maintenance-re-de' => 'Modìfiche scancelà: $1',
	'maintenance-re-rce' => 'Vos an RecentChanges: $1',
	'maintenance-re-total' => 'Vos totaj da cangé: $1',
	'maintenance-re-re' => 'Riassignassion dle modìfiche{{int:ellipsis}} fàita',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'maintenance-name' => 'کارن-نوم',
	'maintenance-password' => 'پټنوم',
	'maintenance-reason' => 'سبب',
	'maintenance-invalidname' => 'ناسم کارن-نوم!',
	'maintenance-userexists' => 'دا کارونکی د پخوا نه ثبت دی!',
	'maintenance-stats-pages' => 'د مخونو شمېر: $1',
	'maintenance-stats-users' => 'د کارونکو شمېر: $1',
	'maintenance-stats-admins' => 'د پازوالانو شمېر: $1',
	'maintenance-stats-images' => 'د دوتنو شمېر: $1',
	'maintenance-memc-total' => 'ټولټال:',
	'maintenance-memc-invalid' => 'ناسم:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'maintenance' => 'Execute scripts de manutenção',
	'maintenance-desc' => '[[Special:Maintenance|Interface wiki]] para vários scripts de manutenção',
	'right-maintenance' => 'Executar scripts de manutenção através de [[Special:Maintenance]]',
	'maintenance-backlink' => 'Voltar à seleção de scripts',
	'maintenance-header' => 'Por favor, selecione abaixo um script a executar.
As descrições estão junto a cada script',
	'maintenance-changePassword-desc' => 'Alterar a palavra-chave de um utilizador',
	'maintenance-createAndPromote-desc' => 'Criar um utilizador e promover a administrador',
	'maintenance-deleteBatch-desc' => 'Eliminar páginas em massa',
	'maintenance-deleteRevision-desc' => 'Remover revisões da base de dados',
	'maintenance-eval-desc' => 'Interpretar código PHP no ambiente MediaWiki',
	'maintenance-initEditCount-desc' => 'Recalcular a contagem de edições de utilizadores',
	'maintenance-initStats-desc' => 'Recalcular estatísticas do sítio',
	'maintenance-moveBatch-desc' => 'Mover páginas em bloco',
	'maintenance-reassignEdits-desc' => 'Reatribuir edições de um utilizador para outro',
	'maintenance-runJobs-desc' => 'Executar tarefas na fila de tarefas',
	'maintenance-showJobs-desc' => 'Mostrar uma lista de tarefas pendentes na fila de tarefas',
	'maintenance-sql-desc' => 'Executar um comando SQL',
	'maintenance-stats-desc' => 'Mostrar estatísticas do Memcached',
	'maintenance-changePassword' => 'Use este formulário para alterar a palavra-chave de um utilizador',
	'maintenance-createAndPromote' => 'Utilize este formulário para criar um novo utilizador e promovê-lo a administrador.
Assinale a caixa de burocrata se pretende também promovê-lo a burocrata',
	'maintenance-deleteBatch' => 'Utilize este formulário para eliminar páginas em massa.
Coloque apenas uma página por linha',
	'maintenance-deleteRevision' => 'Utilize este formulário para eliminar revisões em massa.
Coloque apenas um número de revisão por linha',
	'maintenance-initStats' => 'Utilize este formulário para recalcular as estatísticas do sítio, especificando se pretende recalcular as visualizações de página também',
	'maintenance-moveBatch' => 'Utilize este formulário para mover páginas em massa.
Cada linha deverá especificar uma página fonte e uma página destino, separadas por uma barra vertical ("pipe")',
	'maintenance-invalidtype' => 'Tipo inválido!',
	'maintenance-name' => 'Nome de utilizador',
	'maintenance-password' => 'Palavra-chave',
	'maintenance-bureaucrat' => 'Promover utilizador a estatuto de burocrata',
	'maintenance-reason' => 'Motivo',
	'maintenance-update' => 'Usar UPDATE para atualizar uma tabela? Se desselecionado, usa DELETE/INSERT.',
	'maintenance-noviews' => 'Assinale aqui para prevenir a atualização do número de visualizações de página',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-invalidname' => 'Nome de utilizador inválido!',
	'maintenance-success' => '$1 executado com sucesso!',
	'maintenance-userexists' => 'O utilizador já existe!',
	'maintenance-invalidtitle' => 'Título "$1" inválido!',
	'maintenance-titlenoexist' => 'O título especificado ("$1") não existe!',
	'maintenance-failed' => 'FALHADO',
	'maintenance-deleted' => 'ELIMINADO',
	'maintenance-revdelete' => 'Eliminando {{PLURAL:$3|revisão|revisões}} $1 da wiki $2',
	'maintenance-revnotfound' => 'Revisão $1 não encontrada!',
	'maintenance-sql' => 'Use este formulário para executar um comando SQL na base de dados.',
	'maintenance-sql-aff' => 'Linhas afetadas: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|linha retornada|linhas retornadas}}:
$2',
	'maintenance-stats-edits' => 'Número de edições: $1',
	'maintenance-stats-articles' => 'Número de páginas no espaço nominal principal: $1',
	'maintenance-stats-pages' => 'Número de páginas: $1',
	'maintenance-stats-users' => 'Número de utilizadores: $1',
	'maintenance-stats-admins' => 'Número de administradores: $1',
	'maintenance-stats-images' => 'Número de ficheiros: $1',
	'maintenance-stats-views' => 'Número de visualizações de página: $1',
	'maintenance-stats-update' => 'A atualizar base de dados{{int:ellipsis}}',
	'maintenance-move' => 'A mover $1 para $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Erro encontrado durante a movimentação: $1.
A abortar a movimentação',
	'maintenance-error' => 'Erro: $1',
	'maintenance-memc-fake' => 'Está a executar o FakeMemCachedClient. Não podem ser fornecidas estatísticas.',
	'maintenance-memc-requests' => 'Pedidos',
	'maintenance-memc-withsession' => 'com sessão:',
	'maintenance-memc-withoutsession' => 'sem sessão:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Cache do analisador parser',
	'maintenance-memc-hits' => 'acertos:',
	'maintenance-memc-invalid' => 'inválidos:',
	'maintenance-memc-expired' => 'caducados:',
	'maintenance-memc-absent' => 'ausentes:',
	'maintenance-memc-stub' => 'limite de esboço:',
	'maintenance-memc-imagecache' => 'Cache de imagens',
	'maintenance-memc-misses' => 'faltas:',
	'maintenance-memc-updates' => 'atualizações:',
	'maintenance-memc-uncacheable' => 'não "cacháveis":',
	'maintenance-memc-diffcache' => 'Cache de Diferenças',
	'maintenance-eval' => 'Utilize este formulário para executar código PHP no ambiente MediaWiki.',
	'maintenance-reassignEdits' => 'Utilize este formulário para re-atribuir edições de um utilizador a outro.',
	'maintenance-re-from' => 'Nome do utilizador a que desatribuir edições',
	'maintenance-re-to' => 'Nome do utilizador a que atribuir edições',
	'maintenance-re-force' => 'Re-atribuir mesmo que o utilizador alvo não exista',
	'maintenance-re-rc' => 'Não atualizar a tabela de modificações recentes',
	'maintenance-re-report' => 'Apresentar detalhes do que seria alterado, mas não o atualizar',
	'maintenance-re-nf' => 'Utilizador $1 não encontrado',
	'maintenance-re-rr' => 'Executar o script novamente sem "$1" para atualizar.',
	'maintenance-re-ce' => 'Edições actuais: $1',
	'maintenance-re-de' => 'Edições eliminadas: $1',
	'maintenance-re-rce' => 'Entradas das Mudanças Recentes: $1',
	'maintenance-re-total' => 'Entradas totais a alterar: $1',
	'maintenance-re-re' => 'A re-atribuir edições{{int:ellipsis}} concluído',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'maintenance' => 'Execute scripts de manutenção',
	'maintenance-desc' => '[[Special:Maintenance|Interface wiki]] para vários scripts de manutenção',
	'right-maintenance' => 'Executar scripts de manutenção através de [[Special:Maintenance]]',
	'maintenance-backlink' => 'Voltar à seleção de scripts',
	'maintenance-header' => 'Por favor, selecione abaixo um script a executar.
As descrições estão junto a cada script',
	'maintenance-changePassword-desc' => 'Alterar a palavra-chave de um utilizador',
	'maintenance-createAndPromote-desc' => 'Criar um utilizador e promover a administrador',
	'maintenance-deleteBatch-desc' => 'Eliminar páginas em massa',
	'maintenance-deleteRevision-desc' => 'Remover revisões da base de dados',
	'maintenance-eval-desc' => 'Interpretar código PHP no ambiente MediaWiki',
	'maintenance-initEditCount-desc' => 'Recalcular a contagem de edições de utilizadores',
	'maintenance-initStats-desc' => 'Recalcular estatísticas do sítio',
	'maintenance-moveBatch-desc' => 'Mover páginas em bloco',
	'maintenance-reassignEdits-desc' => 'Reatribuir edições de um utilizador para outro',
	'maintenance-runJobs-desc' => 'Executar tarefas na fila de tarefas',
	'maintenance-showJobs-desc' => 'Mostrar uma lista de tarefas pendentes na fila de tarefas',
	'maintenance-sql-desc' => 'Executar um comando SQL',
	'maintenance-stats-desc' => 'Mostrar estatísticas do Memcached',
	'maintenance-changePassword' => 'Use este formulário para alterar a palavra-chave de um utilizador',
	'maintenance-createAndPromote' => 'Utilize este formulário para criar um novo utilizador e promovê-lo a administrador.
Assinale a caixa de burocrata se pretende também promovê-lo a burocrata',
	'maintenance-deleteBatch' => 'Utilize este formulário para eliminar páginas em massa.
Coloque apenas uma página por linha',
	'maintenance-deleteRevision' => 'Utilize este formulário para eliminar revisões em massa.
Coloque apenas um número de revisão por linha',
	'maintenance-initStats' => 'Utilize este formulário para recalcular as estatísticas do sítio, especificando se pretende recalcular as visualizações de página também',
	'maintenance-moveBatch' => 'Utilize este formulário para mover páginas em massa.
Cada linha deverá especificar uma página fonte e uma página destino, separadas por uma barra vertical ("pipe")',
	'maintenance-invalidtype' => 'Tipo inválido!',
	'maintenance-name' => 'Nome de utilizador',
	'maintenance-password' => 'Palavra-chave',
	'maintenance-bureaucrat' => 'Promover utilizador a estatuto de burocrata',
	'maintenance-reason' => 'Motivo',
	'maintenance-update' => 'Usar UPDATE para atualizar uma tabela? Se desselecionado, usa DELETE/INSERT.',
	'maintenance-noviews' => 'Assinale aqui para prevenir a atualização do número de visualizações de página',
	'maintenance-confirm' => 'Confirmar',
	'maintenance-invalidname' => 'Nome de utilizador inválido!',
	'maintenance-success' => '$1 executado com sucesso!',
	'maintenance-userexists' => 'O utilizador já existe!',
	'maintenance-invalidtitle' => 'Título "$1" inválido!',
	'maintenance-titlenoexist' => 'O título especificado ("$1") não existe!',
	'maintenance-failed' => 'FALHOU',
	'maintenance-deleted' => 'ELIMINADO',
	'maintenance-revdelete' => 'Eliminando {{PLURAL:$3|revisão|revisões}} $1 do wiki $2',
	'maintenance-revnotfound' => 'Revisão $1 não encontrada!',
	'maintenance-sql' => 'Use este formulário para executar um comando SQL na base de dados.',
	'maintenance-sql-aff' => 'Linhas afetadas: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|linha retornada|linhas retornadas}}:
$2',
	'maintenance-stats-edits' => 'Número de edições: $1',
	'maintenance-stats-articles' => 'Número de páginas no domínio principal: $1',
	'maintenance-stats-pages' => 'Número de páginas: $1',
	'maintenance-stats-users' => 'Número de utilizadores: $1',
	'maintenance-stats-admins' => 'Número de administradores: $1',
	'maintenance-stats-images' => 'Número de ficheiros: $1',
	'maintenance-stats-views' => 'Número de visualizações de página: $1',
	'maintenance-stats-update' => 'Atualizando base de dados{{int:ellipsis}}',
	'maintenance-move' => 'Movendo $1 para $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Erro encontrado durante a movimentação: $1.
Abortando a movimentação',
	'maintenance-error' => 'Erro: $1',
	'maintenance-memc-fake' => 'Você está a executar o FakeMemCachedClient. Estatísticas não podem ser fornecidas.',
	'maintenance-memc-requests' => 'Pedidos',
	'maintenance-memc-withsession' => 'com sessão:',
	'maintenance-memc-withoutsession' => 'sem sessão:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-parsercache' => 'Cache do analisador (parser)',
	'maintenance-memc-hits' => 'acertos:',
	'maintenance-memc-invalid' => 'inválidos:',
	'maintenance-memc-expired' => 'expirados:',
	'maintenance-memc-absent' => 'ausentes:',
	'maintenance-memc-stub' => 'limite de esboço:',
	'maintenance-memc-imagecache' => 'Cache de imagens',
	'maintenance-memc-misses' => 'faltas:',
	'maintenance-memc-updates' => 'atualizações:',
	'maintenance-memc-uncacheable' => 'não "cacheáveis":',
	'maintenance-memc-diffcache' => 'Cache de Diferenças',
	'maintenance-eval' => 'Utilize este formulário para executar código PHP no ambiente MediaWiki.',
	'maintenance-reassignEdits' => 'Utilize este formulário para re-atribuir edições de um utilizador a outro.',
	'maintenance-re-from' => 'Nome do utilizador a quem desatribuir edições',
	'maintenance-re-to' => 'Nome do utilizador a que atribuir edições',
	'maintenance-re-force' => 'Re-atribuir mesmo que o utilizador alvo não exista',
	'maintenance-re-rc' => 'Não atualizar a tabela de modificações recentes',
	'maintenance-re-report' => 'Apresentar detalhes do que seria alterado, mas não o atualizar',
	'maintenance-re-nf' => 'Utilizador $1 não encontrado',
	'maintenance-re-rr' => 'Executar o script novamente sem "$1" para atualizar.',
	'maintenance-re-ce' => 'Edições atuais: $1',
	'maintenance-re-de' => 'Edições eliminadas: $1',
	'maintenance-re-rce' => 'Entradas das Mudanças Recentes: $1',
	'maintenance-re-total' => 'Entradas totais a alterar: $1',
	'maintenance-re-re' => 'Re-atribuindo edições{{int:ellipsis}} concluído',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'maintenance' => 'Rulează scripturile de întreţinere',
	'maintenance-desc' => '[[Special:Maintenance|Interfaţa wiki]] pentru diferite scripturi de întreţinere',
	'right-maintenance' => 'Rulează scripturile de întreţinere prin [[Special:Maintenance]]',
	'maintenance-backlink' => 'Înapoi la selecţia scriptului',
	'maintenance-header' => 'Vă rugăm să selectaţi de mai jos un script pentru executare.
Descrierile se află în apropierea fiecărui script',
	'maintenance-changePassword-desc' => 'Schimbă parola unui utilizator',
	'maintenance-createAndPromote-desc' => 'Creează un utilizator şi promovează-l la statutul de administrator',
	'maintenance-deleteBatch-desc' => 'Şterge pagini în masă',
	'maintenance-deleteRevision-desc' => 'Şterge reviziile din baza de date',
	'maintenance-eval-desc' => 'Evaluează codul PHP în mediul MediaWiki',
	'maintenance-initEditCount-desc' => 'Recalculează numărul de modificări ale utilizatorilor',
	'maintenance-initStats-desc' => 'Recalculează statisticile sitului',
	'maintenance-moveBatch-desc' => 'Mută pagini în masă',
	'maintenance-reassignEdits-desc' => 'Redistribuie contribuţiile de la un utilizator la altul',
	'maintenance-sql-desc' => 'Execută o interogare SQL',
	'maintenance-stats-desc' => 'Arată statisticile Memcached',
	'maintenance-changePassword' => 'Utilizaţi acest formular pentru a schimba parola unui utilizator',
	'maintenance-createAndPromote' => 'Utilizaţi acest formular pentru a crea un nou utilizator şi a-l promova la statutul de administrator.
Bifaţi şi caseta „birocrat” dacă doriţi să-l promovaţi şi la statutul de birocrat',
	'maintenance-deleteBatch' => 'Utilizaţi acest formular pentru ştergerea în masă a paginilor.
Puneţi doar o pagină pe un rând',
	'maintenance-deleteRevision' => 'Utilizaţi acest formular pentru ştergerea în masă a reviziilor.
Puneţi doar o revizie pe un rând',
	'maintenance-invalidtype' => 'Tip incorect!',
	'maintenance-name' => 'Nume de utilizator',
	'maintenance-password' => 'Parolă',
	'maintenance-reason' => 'Motiv',
	'maintenance-confirm' => 'Confirmă',
	'maintenance-invalidname' => 'Nume de utilizator incorect!',
	'maintenance-success' => '$1 a rulat cu succes!',
	'maintenance-userexists' => 'Utilizatorul există deja!',
	'maintenance-invalidtitle' => 'Titlu incorect "$1"!',
	'maintenance-titlenoexist' => 'Titlul specificat ("$1") nu există!',
	'maintenance-failed' => 'EŞUAT',
	'maintenance-deleted' => 'ŞTERS',
	'maintenance-revnotfound' => 'Revizia $1 negăsită!',
	'maintenance-sql-aff' => 'Rânduri afectate: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|rând returnat|rânduri returnate}}:
$2',
	'maintenance-stats-edits' => 'Număr de modificări: $1',
	'maintenance-stats-articles' => 'Număr de pagini în spaţiul de nume principal: $1',
	'maintenance-stats-pages' => 'Număr de pagini: $1',
	'maintenance-stats-users' => 'Număr de utilizatori: $1',
	'maintenance-stats-admins' => 'Număr de administratori: $1',
	'maintenance-stats-images' => 'Număr de fişiere: $1',
	'maintenance-error' => 'Eroare: $1',
	'maintenance-memc-requests' => 'Cereri',
	'maintenance-memc-withsession' => 'cu sesiune:',
	'maintenance-memc-withoutsession' => 'fără sesiune:',
	'maintenance-memc-total' => 'total:',
	'maintenance-memc-hits' => 'clickuri:',
	'maintenance-memc-invalid' => 'incorect:',
	'maintenance-memc-expired' => 'expirat:',
	'maintenance-memc-absent' => 'absent:',
	'maintenance-memc-updates' => 'actualizări:',
	'maintenance-re-ce' => 'Modificări curente: $1',
	'maintenance-re-de' => 'Modificări şterse: $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'maintenance-name' => 'Nome utende',
	'maintenance-userexists' => "L'utende già esiste!",
	'maintenance-stats-edits' => 'Numere de cangiaminde: $1',
	'maintenance-error' => 'Errore: $1',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'maintenance' => 'Запуск скриптов обслуживания',
	'maintenance-desc' => '[[Special:Maintenance|Веб-интерфейс]] для различных скриптов обслуживания',
	'right-maintenance' => 'запуск скриптов обслуживания с помощью [[Special:Maintenance]]',
	'maintenance-backlink' => 'Вернуться к выбору скрипта',
	'maintenance-header' => 'Пожалуйста, выберите скрипт для исполнения. 
Описание рядом с каждым скриптом',
	'maintenance-changePassword-desc' => 'Изменить пароль участника',
	'maintenance-createAndPromote-desc' => 'Создать участника со статусом администратора',
	'maintenance-deleteBatch-desc' => 'Массовое удаление страниц',
	'maintenance-deleteRevision-desc' => 'Удаление версий страниц из базы данных',
	'maintenance-eval-desc' => 'Проверка кода PHP в окружении MediaWiki',
	'maintenance-initEditCount-desc' => 'Пересчитать число правок участников',
	'maintenance-initStats-desc' => 'Пересчитать статистику сайта',
	'maintenance-moveBatch-desc' => 'Массовое переименование страниц',
	'maintenance-reassignEdits-desc' => 'Переназначить правки с одного участника на другого',
	'maintenance-runJobs-desc' => 'Запустить задания в очереди заданий',
	'maintenance-showJobs-desc' => 'Показать список заданий из очереди заданий',
	'maintenance-sql-desc' => 'Выполнить SQL-запрос',
	'maintenance-stats-desc' => 'Показать статистику Memcached',
	'maintenance-changePassword' => 'Используйте эту форму, чтобы изменить пароль участника',
	'maintenance-createAndPromote' => 'Используйте эту форму для создания нового участника с правами администратора.
Обратите внимание на форму бюрократа, если вы хотите сделать его бюрократом',
	'maintenance-deleteBatch' => 'Используйте эту форму для массового удаления страниц.
На одной строке должна находиться только одна страница.',
	'maintenance-deleteRevision' => 'Используйте эту форму для массового удаления версий страниц.
На одной строке должен быть только один номер версии страницы',
	'maintenance-initStats' => 'Используйте эту форму для пересчёта статистики сайта, при необходимости укажите, что нужно пересчитывать также просмотры страниц',
	'maintenance-moveBatch' => 'Используйте эту форму для массового переименования страниц.
Каждая строка должна содержать исходную страницу и её новое название, разделённые знаком «|»',
	'maintenance-invalidtype' => 'Ошибочный тип!',
	'maintenance-name' => 'Имя участника',
	'maintenance-password' => 'Пароль',
	'maintenance-bureaucrat' => 'Присвоить участнику статус бюрократа',
	'maintenance-reason' => 'Причина',
	'maintenance-update' => 'Использовать UPDATE для обновления таблицы? Снимите отметку чтобы использовать DELETE/INSERT.',
	'maintenance-noviews' => 'Проверьте это для предотвращения обновления числа просмотров',
	'maintenance-confirm' => 'Подтвердить',
	'maintenance-invalidname' => 'Ошибочное имя участника!',
	'maintenance-success' => '$1 успешно выполнено!',
	'maintenance-userexists' => 'Участник уже существует!',
	'maintenance-invalidtitle' => 'Ошибочный заголовок «$1»!',
	'maintenance-titlenoexist' => 'Указанный заголовок («$1») не существует!',
	'maintenance-failed' => 'НЕУДАЧНО',
	'maintenance-deleted' => 'УДАЛЕНО',
	'maintenance-revdelete' => 'Удаление {{PLURAL:$3|версия страницы|версии страницы|версий страниц}} $1 из вики $2',
	'maintenance-revnotfound' => 'Версия страницы $1 не найдена!',
	'maintenance-sql' => 'Используйте эту форму для выполнения SQL-запроса в базе данных.',
	'maintenance-sql-aff' => 'Выведено строк: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|Возвращена $1 строка|Возвращено $1 строки|Возвращено $1 строк}}:
$2',
	'maintenance-stats-edits' => 'Число правок: $1',
	'maintenance-stats-articles' => 'Количество страниц в основном пространстве: $1',
	'maintenance-stats-pages' => 'Количество страниц: $1',
	'maintenance-stats-users' => 'Количество участников: $1',
	'maintenance-stats-admins' => 'Количество администраторов: $1',
	'maintenance-stats-images' => 'Количество файлов: $1',
	'maintenance-stats-views' => 'Количество просмотров страниц: $1',
	'maintenance-stats-update' => 'Обновление базы данных...',
	'maintenance-move' => 'Переименование $1 в $2...',
	'maintenance-movefail' => 'Ошибки, возникшие при переименовании: $1.
Переименование отменено',
	'maintenance-error' => 'Ошибка: $1',
	'maintenance-memc-fake' => 'Вы запустили FakeMemCachedClient. Статистика не может быть предоставлена.',
	'maintenance-memc-requests' => 'Запросы',
	'maintenance-memc-withsession' => 'с сеансом:',
	'maintenance-memc-withoutsession' => 'без сеанса:',
	'maintenance-memc-total' => 'всего:',
	'maintenance-memc-parsercache' => 'Кеш парсера',
	'maintenance-memc-hits' => 'просмотров:',
	'maintenance-memc-invalid' => 'ошибочных:',
	'maintenance-memc-expired' => 'истекших:',
	'maintenance-memc-absent' => 'отсутствует:',
	'maintenance-memc-stub' => 'порог заготовок:',
	'maintenance-memc-imagecache' => 'Кеш изображений',
	'maintenance-memc-misses' => 'ошибок:',
	'maintenance-memc-updates' => 'обновлений:',
	'maintenance-memc-uncacheable' => 'некэшируемых:',
	'maintenance-memc-diffcache' => 'Кеш сравнений версий',
	'maintenance-eval' => 'используйте эту форму для проверка кода PHP в окружении MediaWiki.',
	'maintenance-reassignEdits' => 'Используйте эту форму для переназначения правок от одного участника к другому.',
	'maintenance-re-from' => 'Имя участника, правки которого переназначаются',
	'maintenance-re-to' => 'Имя участника, которому переназначаются правки',
	'maintenance-re-force' => 'Переназначить, даже если целевого участника не существует',
	'maintenance-re-rc' => 'Не обновлять таблицу свежих правок',
	'maintenance-re-report' => 'Вывести подробности об изменениях, но не применять их',
	'maintenance-re-nf' => 'Участник $1 не найден',
	'maintenance-re-rr' => 'Выполнить скрипт опять без «$1» к обновлению.',
	'maintenance-re-ce' => 'Текущие правки: $1',
	'maintenance-re-de' => 'Удалённые правки: $1',
	'maintenance-re-rce' => 'Записи свежих правок: $1',
	'maintenance-re-total' => 'Всего записей для изменения: $1',
	'maintenance-re-re' => 'Переназначение правок{{int:ellipsis}} завершено',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'maintenance' => 'Spustiť údržbové skripty',
	'maintenance-desc' => '[[Special:Maintenance|Webové rozhranie]] pre rozličné údržbové skripty',
	'right-maintenance' => 'Spúšťať údržbové skripty pomocou [[Special:Maintenance]]',
	'maintenance-backlink' => 'Späť na výber skriptu',
	'maintenance-header' => 'Prosím, vyberte dolu skript, ktorý sa má spustiť.',
	'maintenance-changePassword-desc' => 'Zmeniť heslo používateľa',
	'maintenance-createAndPromote-desc' => 'Vytvoriť používateľa a povyšiť ho na správcu',
	'maintenance-deleteBatch-desc' => 'Hromadné mazanie stránok',
	'maintenance-deleteRevision-desc' => 'Odstránenie revízií z databázy',
	'maintenance-eval-desc' => 'Vyhodnocovať PHP kód v prostredí MediaWiki',
	'maintenance-initEditCount-desc' => 'Znovu spočítať počty úprav používateľov',
	'maintenance-initStats-desc' => 'Znovu spočítať štatistiky wiki',
	'maintenance-moveBatch-desc' => 'Hromadný presun stránok',
	'maintenance-reassignEdits-desc' => 'Zmeniť pôvodcu úprav z jedného používateľa na iného',
	'maintenance-runJobs-desc' => 'Spustiť úlohy vo fronte úloh',
	'maintenance-showJobs-desc' => 'Zobraziť zoznam čakajúcich úloh vo fronte úloh',
	'maintenance-sql-desc' => 'Vykonať SQL požiadavku',
	'maintenance-stats-desc' => 'Zobraziť štatistiky Memcached',
	'maintenance-changePassword' => 'Tento formulár slúži na zmenu hesla používateľa',
	'maintenance-createAndPromote' => 'Tento formulár slúži na vytvorenie nového používateľa a jeho povýšenie na správcu.
Označte pole „byrokrat” ak ho chcete povýšiť aj na byrokrata.',
	'maintenance-deleteBatch' => 'Tento formulár slúži na hromadné mazanie stránok.
Píšte iba jednu stránku na riadok',
	'maintenance-deleteRevision' => 'Tento formulár slúži na hromadné mazanie revízií.
Píšte iba jednu revíziu na riadok',
	'maintenance-initStats' => 'Tento formulár slúži na prepočítanie štatistík tejto wiki. Môžete určiť, či chcete prepočítať aj zobrazenia stránok.',
	'maintenance-moveBatch' => 'Tento formulár slúži na hromadné presúvanie stránok.
Na každom riadku by ste mali určiť zdrojovú a cieľovú stránku oddelenú znakom rúry („|”).',
	'maintenance-invalidtype' => 'Neplatný typ!',
	'maintenance-name' => 'Používateľské meno',
	'maintenance-password' => 'Heslo',
	'maintenance-bureaucrat' => 'Povýšiť používateľa na stav byrokrat',
	'maintenance-reason' => 'Dôvod',
	'maintenance-update' => 'Použiť na aktualizáciu tabuľky UPDATE? Ak nie, použije sa DELETE/INSERT.',
	'maintenance-noviews' => 'Ak je toto pole označené, nebude sa aktualizovať počet zobrazení stránky',
	'maintenance-confirm' => 'Potvrdiť',
	'maintenance-invalidname' => 'Neplatné používateľské meno!',
	'maintenance-success' => '$1 prebehol úspešne!',
	'maintenance-userexists' => 'Používateľ už existuje!',
	'maintenance-invalidtitle' => 'Neplatný názov „$1”!',
	'maintenance-titlenoexist' => 'Uvedený názov („$1”) neexistuje!',
	'maintenance-failed' => 'ZLYHALO',
	'maintenance-deleted' => 'ZMAZANÉ',
	'maintenance-revdelete' => '{{PLURAL:$3|Maže sa revízia|Mažú sa revízie}} $1 z wiki $2',
	'maintenance-revnotfound' => 'Revízia $1 nenájdená!',
	'maintenance-sql' => 'Tento formulár môžete použiť na vykonanie SQL požiadavky do databázy.',
	'maintenance-sql-aff' => 'Ovplyvnených riadkov: $1',
	'maintenance-sql-res' => '{{PLURAL:$1|Vrátený $1 riadok|Vrátené $1 riadky|Vrátených $1 riadkov}}:
$2',
	'maintenance-stats-edits' => 'Počet úprav: $1',
	'maintenance-stats-articles' => 'Počet stránok v hlavnom mennom priestore: $1',
	'maintenance-stats-pages' => 'Počet stránok: $1',
	'maintenance-stats-users' => 'Počet používateľov: $1',
	'maintenance-stats-admins' => 'Počet správcov: $1',
	'maintenance-stats-images' => 'Počet súborov: $1',
	'maintenance-stats-views' => 'Počet zobrazení stránky: $1',
	'maintenance-stats-update' => 'Aktualizuje sa databáza{{int:ellipsis}}',
	'maintenance-move' => 'Presúva sa $1 na $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Počas presúvania sa vyskytla chyba: $1.
Presúvanie sa ruší',
	'maintenance-error' => 'Chyba: $1',
	'maintenance-memc-fake' => 'Používate FakeMemCachedClient. Štatistiky nie sú dostupné',
	'maintenance-memc-requests' => 'Požiadavky',
	'maintenance-memc-withsession' => 's reláciou:',
	'maintenance-memc-withoutsession' => 'bez relácie:',
	'maintenance-memc-total' => 'celkom:',
	'maintenance-memc-parsercache' => 'Vyrovnávacia pamäť syntaktického analyzátora',
	'maintenance-memc-hits' => 'zásahov:',
	'maintenance-memc-invalid' => 'neplatných:',
	'maintenance-memc-expired' => 'vypršaných:',
	'maintenance-memc-absent' => 'chýbajúcich:',
	'maintenance-memc-stub' => 'prah výhonku:',
	'maintenance-memc-imagecache' => 'Vyrovnávacia pamäť obrázkov',
	'maintenance-memc-misses' => 'minutí:',
	'maintenance-memc-updates' => 'aktualizácií:',
	'maintenance-memc-uncacheable' => 'nebolo možné použiť vyrovnávaciu pamäť:',
	'maintenance-memc-diffcache' => 'Rozdiel vo vyrovnávacej pamäti',
	'maintenance-eval' => 'Tento formulár môžete použiť na vyhodnotenie PHP kódu v prostredí MediaWiki.',
	'maintenance-reassignEdits' => 'Tento formulár môžete použiť na zmenu pôvodcu úprav z jedného používateľa na iného.',
	'maintenance-re-from' => 'Používateľské meno ktorého úpravy chcete zmeniť',
	'maintenance-re-to' => 'Používateľské meno komu chcete úpravy pripísať',
	'maintenance-re-force' => 'Zmeniť pôvodcu aj ak cieľový používateľ neexistuje',
	'maintenance-re-rc' => 'Neaktualizovať tabuľku posledných úprav',
	'maintenance-re-report' => 'Vypísať podrobnosti čo sa zmení, ale zatiaľ nevykonávať zmeny',
	'maintenance-re-nf' => 'Používateľ $1 nebol nájdený',
	'maintenance-re-rr' => 'Aktualizáciu vykonáte opätovným spustením skriptu bez „$1“',
	'maintenance-re-ce' => 'Aktuálne úpravy: $1',
	'maintenance-re-de' => 'Zmazané úpravy: $1',
	'maintenance-re-rce' => 'Záznamy Posledných úprav: $1',
	'maintenance-re-total' => 'Zmeniť celkovo záznamov: $1',
	'maintenance-re-re' => 'Zmena pôvodcu úprav{{int:ellipsis}} hotovo',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'maintenance' => 'Покрени скрипте за одржавање',
	'maintenance-desc' => '[[Special:Maintenance|Вики интерфејс]] за разне скрипте за одржавање',
	'maintenance-backlink' => 'Повратак на обележавање скрипти',
	'maintenance-header' => 'Молимо Вас да испот означите скрипту коју треба покренути.
Поред сваке скрипте се налази одговарајући опис.',
	'maintenance-changePassword-desc' => 'Промени лозинку корисника',
	'maintenance-createAndPromote-desc' => 'Направи корисника и унапреди га у администратора',
	'maintenance-deleteBatch-desc' => 'Стране за масовно брисање',
	'maintenance-deleteRevision-desc' => 'Обриши ревизије из базе података',
	'maintenance-eval-desc' => 'Развиј PHP код у МедијаВики окружењу',
	'maintenance-initEditCount-desc' => 'Освежи корисничке бројаче измена',
	'maintenance-initStats-desc' => 'Освежи статистике сајта',
	'maintenance-moveBatch-desc' => 'Стране за масовно премештање',
	'maintenance-reassignEdits-desc' => 'Припиши измене једног корисника другом',
	'maintenance-runJobs-desc' => 'Покрени послове из реда за послове',
	'maintenance-showJobs-desc' => 'Покажи списак послова из реда за послове',
	'maintenance-sql-desc' => 'Изврши SQL захтев',
	'maintenance-changePassword' => 'Користите ову форму да бисте променили лозинку корисника',
	'maintenance-deleteBatch' => 'Користите ову форму да бисте масовно брисали странице.
Уписујте само једну страну по линији.',
	'maintenance-deleteRevision' => 'Користите ову страну да бисте масовно брисали ревизије.
Уписујте број само једне ревизије по линији.',
	'maintenance-initStats' => 'Користите ову форму да бисте освежили статистике сајта, означивши да ли такође желите да освежите и прегледе страница.',
	'maintenance-moveBatch' => 'Користите ову форму да бисте масовно премештали странице.
У свакој линији треба (тим редом) означити тренутно и циљано име странице, и раздвојити их знаком "|"',
	'maintenance-invalidtype' => 'Непознат тип!',
	'maintenance-name' => 'Корисничко име',
	'maintenance-password' => 'Лозинка',
	'maintenance-bureaucrat' => 'Унапредите корисника у бирократу',
	'maintenance-reason' => 'Разлог',
	'maintenance-noviews' => 'Означите ово да бисте спрежили освежавање броја прегледа страна',
	'maintenance-confirm' => 'Потврди',
	'maintenance-invalidname' => 'Погрешно корисничко име!',
	'maintenance-success' => '$1 се успешно извршила!',
	'maintenance-userexists' => 'Тај корисник већ постоји!',
	'maintenance-invalidtitle' => 'Неисправан наслов "$1"!',
	'maintenance-titlenoexist' => 'Наведени наслов ("$1") не постоји!',
	'maintenance-failed' => 'НЕУСПЕЛО',
	'maintenance-deleted' => 'ОБРИСАНО',
	'maintenance-revdelete' => 'Брисање {{PLURAL:$3|ревизије|ревизија}} $1 са $2-Викија.',
	'maintenance-revnotfound' => 'Ревизија $1 није пронађена!',
	'maintenance-sql' => 'Користите ову форму да извршите SQL захтев над базом података.',
	'maintenance-sql-aff' => 'Афектовани редови: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|ред враћен|редова враћено}}:
$2',
	'maintenance-stats-edits' => 'Број измена: $1',
	'maintenance-stats-articles' => 'Број страна у главном именском простору: $1',
	'maintenance-stats-pages' => 'Број страна: $1',
	'maintenance-stats-users' => 'Број корисника: $1',
	'maintenance-stats-admins' => 'Број администратора: $1',
	'maintenance-stats-images' => 'Број фајлова: $1',
	'maintenance-stats-views' => 'Број прегледа страна: $1',
	'maintenance-stats-update' => 'Освежавање базе података{{int:ellipsis}}',
	'maintenance-move' => 'Премештање $1 на $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Грешка приликом премештања: $1.
Опозивање премештања',
	'maintenance-error' => 'Грешка: $1',
	'maintenance-memc-fake' => 'Ви сте покренули FakeMemCachedClient. Статистике не могу бити приложене',
	'maintenance-memc-requests' => 'Захтеви',
	'maintenance-memc-withsession' => 'са сесијом:',
	'maintenance-memc-withoutsession' => 'без сесије:',
	'maintenance-memc-total' => 'укупно:',
	'maintenance-memc-parsercache' => 'Кеш парсера',
	'maintenance-memc-hits' => 'погодака:',
	'maintenance-memc-invalid' => 'неисправно:',
	'maintenance-memc-expired' => 'истекло:',
	'maintenance-memc-absent' => 'одсутно:',
	'maintenance-memc-stub' => 'праг клице:',
	'maintenance-memc-imagecache' => 'Кеш слика',
	'maintenance-memc-misses' => 'промашаји',
	'maintenance-memc-uncacheable' => 'немогуће кеширати:',
	'maintenance-eval' => 'Користите ову форму да развијете PHP код у МедијаВики окружењу.',
	'maintenance-reassignEdits' => 'Користите ову форму да припишете измене једног корисника другом.',
	'maintenance-re-from' => 'Корисничко име чије се измене приписују',
	'maintenance-re-to' => 'Корисничко име којем се измене приписују',
	'maintenance-re-force' => 'Припиши чак иако циљани корисник не постоји',
	'maintenance-re-rc' => 'Не бележи измене у скорашњим изменама',
	'maintenance-re-nf' => 'Корисник $1 није пронађен',
	'maintenance-re-rr' => 'Опет покрени скрипту "$1" зарад освежења.',
	'maintenance-re-ce' => 'Тренутне измене: $1',
	'maintenance-re-de' => 'Обрисане измене: $1',
	'maintenance-re-re' => 'Приписивање измена{{int:ellipsis}} готово',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'maintenance' => 'Pokreni skripte za održavanje',
	'maintenance-desc' => '[[Special:Maintenance|Viki interfejs]] za razne skripte za održavanje',
	'maintenance-backlink' => 'Povratak na obeležavanje skripti',
	'maintenance-header' => 'Molimo Vas da ispot označite skriptu koju treba pokrenuti.
Pored svake skripte se nalazi odgovarajući opis.',
	'maintenance-changePassword-desc' => 'Promeni lozinku korisnika',
	'maintenance-createAndPromote-desc' => 'Napravi korisnika i unapredi ga u administratora',
	'maintenance-deleteBatch-desc' => 'Strane za masovno brisanje',
	'maintenance-deleteRevision-desc' => 'Obriši revizije iz baze podataka',
	'maintenance-eval-desc' => 'Razvij PHP kod u MedijaViki okruženju',
	'maintenance-initEditCount-desc' => 'Osveži korisničke brojače izmena',
	'maintenance-initStats-desc' => 'Osveži statistike sajta',
	'maintenance-moveBatch-desc' => 'Strane za masovno premeštanje',
	'maintenance-reassignEdits-desc' => 'Pripiši izmene jednog korisnika drugom',
	'maintenance-runJobs-desc' => 'Pokreni poslove iz reda za poslove',
	'maintenance-showJobs-desc' => 'Pokaži spisak poslova iz reda za poslove',
	'maintenance-sql-desc' => 'Izvrši SQL zahtev',
	'maintenance-changePassword' => 'Koristite ovu formu da biste promenili lozinku korisnika',
	'maintenance-deleteBatch' => 'Koristite ovu formu da biste masovno brisali stranice.
Upisujte samo jednu stranu po liniji.',
	'maintenance-deleteRevision' => 'Koristite ovu stranu da biste masovno brisali revizije.
Upisujte broj samo jedne revizije po liniji.',
	'maintenance-initStats' => 'Koristite ovu formu da biste osvežili statistike sajta, označivši da li takođe želite da osvežite i preglede stranica.',
	'maintenance-moveBatch' => 'Koristite ovu formu da biste masovno premeštali stranice.
U svakoj liniji treba (tim redom) označiti trenutno i ciljano ime stranice, i razdvojiti ih znakom "|"',
	'maintenance-invalidtype' => 'Nepoznat tip!',
	'maintenance-name' => 'Korisničko ime',
	'maintenance-password' => 'Lozinka',
	'maintenance-bureaucrat' => 'Unapredite korisnika u birokratu',
	'maintenance-reason' => 'Razlog',
	'maintenance-noviews' => 'Označite ovo da biste sprežili osvežavanje broja pregleda strana',
	'maintenance-confirm' => 'Potvrdi',
	'maintenance-invalidname' => 'Pogrešno korisničko ime!',
	'maintenance-success' => '$1 se uspešno izvršila!',
	'maintenance-userexists' => 'Taj korisnik već postoji!',
	'maintenance-invalidtitle' => 'Neispravan naslov "$1"!',
	'maintenance-titlenoexist' => 'Navedeni naslov ("$1") ne postoji!',
	'maintenance-failed' => 'NEUSPELO',
	'maintenance-deleted' => 'OBRISANO',
	'maintenance-revdelete' => 'Brisanje {{PLURAL:$3|revizije|revizija}} $1 sa $2-Vikija.',
	'maintenance-revnotfound' => 'Revizija $1 nije pronađena!',
	'maintenance-sql' => 'Koristite ovu formu da izvršite SQL zahtev nad bazom podataka.',
	'maintenance-sql-aff' => 'Afektovani redovi: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|red vraćen|redova vraćeno}}:
$2',
	'maintenance-stats-edits' => 'Broj izmena: $1',
	'maintenance-stats-articles' => 'Broj strana u glavnom imenskom prostoru: $1',
	'maintenance-stats-pages' => 'Broj strana: $1',
	'maintenance-stats-users' => 'Broj korisnika: $1',
	'maintenance-stats-admins' => 'Broj administratora: $1',
	'maintenance-stats-images' => 'Broj fajlova: $1',
	'maintenance-stats-views' => 'Broj pregleda strana: $1',
	'maintenance-stats-update' => 'Osvežavanje baze podataka{{int:ellipsis}}',
	'maintenance-move' => 'Premeštanje $1 na $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Greška prilikom premeštanja: $1.
Opozivanje premeštanja',
	'maintenance-error' => 'Greška: $1',
	'maintenance-memc-fake' => 'Vi ste pokrenuli FakeMemCachedClient. Statistike ne mogu biti priložene',
	'maintenance-memc-requests' => 'Zahtevi',
	'maintenance-memc-withsession' => 'sa sesijom:',
	'maintenance-memc-withoutsession' => 'bez sesije:',
	'maintenance-memc-total' => 'ukupno:',
	'maintenance-memc-parsercache' => 'Keš parsera',
	'maintenance-memc-hits' => 'pogodaka:',
	'maintenance-memc-invalid' => 'neispravno:',
	'maintenance-memc-expired' => 'isteklo:',
	'maintenance-memc-absent' => 'odsutno:',
	'maintenance-memc-stub' => 'prag klice:',
	'maintenance-memc-imagecache' => 'Keš slika',
	'maintenance-memc-misses' => 'promašaji',
	'maintenance-memc-uncacheable' => 'nemoguće keširati:',
	'maintenance-eval' => 'Koristite ovu formu da razvijete PHP kod u MedijaViki okruženju.',
	'maintenance-reassignEdits' => 'Koristite ovu formu da pripišete izmene jednog korisnika drugom.',
	'maintenance-re-from' => 'Korisničko ime čije se izmene pripisuju',
	'maintenance-re-to' => 'Korisničko ime kojem se izmene pripisuju',
	'maintenance-re-force' => 'Pripiši čak iako ciljani korisnik ne postoji',
	'maintenance-re-rc' => 'Ne beleži izmene u skorašnjim izmenama',
	'maintenance-re-nf' => 'Korisnik $1 nije pronađen',
	'maintenance-re-rr' => 'Opet pokreni skriptu "$1" zarad osveženja.',
	'maintenance-re-ce' => 'Trenutne izmene: $1',
	'maintenance-re-de' => 'Obrisane izmene: $1',
	'maintenance-re-re' => 'Pripisivanje izmena{{int:ellipsis}} gotovo',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'maintenance-name' => 'Landihan',
	'maintenance-password' => 'Sandi',
	'maintenance-reason' => 'Alesan',
	'maintenance-deleted' => 'DIHAPUS',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author M.M.S.
 * @author Sannab
 */
$messages['sv'] = array(
	'maintenance' => 'Kör underhållsskripter',
	'maintenance-desc' => '[[Special:Maintenance|Webbgränssnitt]] för olika underhållsskripter',
	'right-maintenance' => 'Kör underhållsskript genom [[Special:Maintenance]]',
	'maintenance-backlink' => 'Tillbaka till skriptvalet',
	'maintenance-header' => 'Var god ange ett skript nedan till att exekvera.
Beskrivningar finns brevid varje skript',
	'maintenance-changePassword-desc' => 'Ändra en användares lösenord',
	'maintenance-createAndPromote-desc' => 'Skapa en användare och befodra till administratör',
	'maintenance-deleteBatch-desc' => 'Mass-radera sidor',
	'maintenance-deleteRevision-desc' => 'Ta bort versioner från databasen',
	'maintenance-eval-desc' => 'Evaluera PHP-kod i MediaWiki-miljön',
	'maintenance-initEditCount-desc' => 'Omräkna redigeringräkningarna för användare',
	'maintenance-initStats-desc' => 'Omräkna sajtstatistiken',
	'maintenance-moveBatch-desc' => 'Mass-flytta sidor',
	'maintenance-reassignEdits-desc' => 'Flytta redigeringar från en användare till en annan',
	'maintenance-runJobs-desc' => 'Köra jobb i jobbkön',
	'maintenance-showJobs-desc' => 'Visa en lista över jobb som ligger i jobbkön',
	'maintenance-sql-desc' => 'Kör SQL-fråga',
	'maintenance-stats-desc' => 'Visa mellanlagrad statistik',
	'maintenance-changePassword' => 'Använd detta formulär för att ändra en användares lösenord',
	'maintenance-createAndPromote' => 'Använd detta formulär för att skapa en ny användare och befodra den till administratör.
Kryssa i byråkratruta om du vill befodra den till byråkrat istället',
	'maintenance-deleteBatch' => 'Använd detta formulär för att mass-radera sidor.
Skriv endast in en sida per rad',
	'maintenance-deleteRevision' => 'Använd detta formulär för att mass-radera versioner.
Skriv endast in en version per rad',
	'maintenance-initStats' => 'Använd detta formulär för att räkna om sajtens statistik, speciellt om du vill räkna om sidvisningar',
	'maintenance-moveBatch' => 'Använd detta formulär för att mass-flytta sidor.
Varje rad specifierar den nuvarande sidan och destinationssidan separerade med ett lodrätt streck (|)',
	'maintenance-invalidtype' => 'Ogiltig typ!',
	'maintenance-name' => 'Användarnamn',
	'maintenance-password' => 'Lösenord',
	'maintenance-bureaucrat' => 'Befodra en användare till en byråkrat',
	'maintenance-reason' => 'Anledning',
	'maintenance-update' => 'Använd UPPDATERA när du uppdaterar en tabell? Okryssade använder RADERA/INFOGA istället.',
	'maintenance-noviews' => 'Kolla det här för att förhindra uppdatering av sidvisningar',
	'maintenance-confirm' => 'Bekräfta',
	'maintenance-invalidname' => 'Ogiltigt användarnamn!',
	'maintenance-success' => '$1 kördes lyckat!',
	'maintenance-userexists' => 'Användaren existerar redan!',
	'maintenance-invalidtitle' => 'Ogiltig titel "$1"!',
	'maintenance-titlenoexist' => 'Titeln som specifierades ("$1") finns inte!',
	'maintenance-failed' => 'MISSLYCKAD',
	'maintenance-deleted' => 'RADERAD',
	'maintenance-revdelete' => 'Raderar {{PLURAL:$3|versionen|versionerna}} $1 från wiki $2',
	'maintenance-revnotfound' => 'Versionen $1 hittades inte!',
	'maintenance-sql' => 'Använd detta formulär för att köra en SQL-fråga mot databasen.',
	'maintenance-sql-aff' => 'Påverkade rader: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|rad|rader}} returnerades:
$2',
	'maintenance-stats-edits' => 'Antal redigeringar: $1',
	'maintenance-stats-articles' => 'Antal sidor i huvudnamnrymden: $1',
	'maintenance-stats-pages' => 'Antal sidor: $1',
	'maintenance-stats-users' => 'Antal användare: $1',
	'maintenance-stats-admins' => 'Antal administratörer: $1',
	'maintenance-stats-images' => 'Antal filer: $1',
	'maintenance-stats-views' => 'Antal sidvisningar: $1',
	'maintenance-stats-update' => 'Uppdaterar databasen{{int:ellipsis}}',
	'maintenance-move' => 'Flyttar $1 till $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Ett fel uppstod medan flyttningen: $1.
Avbryt flyttning',
	'maintenance-error' => 'Fel: $1',
	'maintenance-memc-fake' => 'Du kör en FakeMemCachedClient. Ingen statistik kan uppges',
	'maintenance-memc-requests' => 'Efterfrågningar',
	'maintenance-memc-withsession' => 'med session:',
	'maintenance-memc-withoutsession' => 'utan session:',
	'maintenance-memc-total' => 'totalt:',
	'maintenance-memc-parsercache' => 'Parsercache',
	'maintenance-memc-hits' => 'träffar:',
	'maintenance-memc-invalid' => 'ogiltig:',
	'maintenance-memc-expired' => 'utgick:',
	'maintenance-memc-absent' => 'frånvarande:',
	'maintenance-memc-stub' => 'stubbgräns:',
	'maintenance-memc-imagecache' => 'Bildcache',
	'maintenance-memc-misses' => 'missar:',
	'maintenance-memc-updates' => 'uppdateringar:',
	'maintenance-memc-uncacheable' => 'ej mellanlagringsbara:',
	'maintenance-memc-diffcache' => 'Skillnadscache',
	'maintenance-eval' => 'Använd detta formulär för att testa PHP-kod i MediaWiki-miljön.',
	'maintenance-reassignEdits' => 'Använd detta formulär för att flytta redigeringar från en användare till en annan.',
	'maintenance-re-from' => 'Namn på användaren som redigeringarna skall flyttas från',
	'maintenance-re-to' => 'Namn på användaren som redigeringarna skall flyttas till',
	'maintenance-re-force' => 'Flytta redigeringar även om målanvändaren inte existerar',
	'maintenance-re-rc' => 'Uppdatera inte tabellen för senaste ändringar',
	'maintenance-re-report' => 'Skriv ut detaljer om vad som skulle förändras, men genomför inte förändringen',
	'maintenance-re-nf' => 'Hittade inte användaren "$1"',
	'maintenance-re-rr' => 'Kör skriptet igen utan "$1" för att uppdatera.',
	'maintenance-re-ce' => 'Nuvarande redigeringar: $1',
	'maintenance-re-de' => 'Raderade redigeringar: $1',
	'maintenance-re-rce' => 'Bidrag på senaste ändringar: $1',
	'maintenance-re-total' => 'Totalt antal redigeringar att ändra: $1',
	'maintenance-re-re' => 'Flyttar redigeringar{{int:ellipsis}} klart',
);

/** Telugu (తెలుగు)
 * @author C.Chandra Kanth Rao
 * @author Veeven
 */
$messages['te'] = array(
	'maintenance-changePassword-desc' => 'వాడుకరి యొక్క సంకేతపదం మార్చండి',
	'maintenance-initEditCount-desc' => 'వాడుకరులు మార్పుల సంఖ్యను మళ్లీ లెక్కించు',
	'maintenance-initStats-desc' => 'సైటు గణాంకాలని మళ్ళీ లెక్కించు',
	'maintenance-invalidtype' => 'చెల్లని రకం!',
	'maintenance-name' => 'వాడుకరిపేరు',
	'maintenance-password' => 'సంకేతపదం',
	'maintenance-reason' => 'కారణం',
	'maintenance-confirm' => 'నిర్ధారించండి',
	'maintenance-invalidname' => 'తప్పుడు వాడుకరిపేరు!',
	'maintenance-success' => '$1 విజయవంతంగా నడిచింది!',
	'maintenance-userexists' => 'వాడుకరి ఇప్పటికే ఉన్నారు!',
	'maintenance-invalidtitle' => 'తప్పుడు శీర్షిక "$1"!',
	'maintenance-failed' => 'విఫలమైనది',
	'maintenance-deleted' => 'తొలిగించబడినది',
	'maintenance-stats-edits' => 'మార్పుల సంఖ్య: $1',
	'maintenance-stats-pages' => 'పేజీల సంఖ్య: $1',
	'maintenance-stats-users' => 'వాడుకర్ల సంఖ్య: $1',
	'maintenance-stats-admins' => 'నిర్వాహకుల సంఖ్య: $1',
	'maintenance-stats-images' => 'ఫైళ్ళ సంఖ్య: $1',
	'maintenance-stats-views' => 'పేజీ వీక్షణల సంఖ్య: $1',
	'maintenance-stats-update' => 'డాటాబేస్ తాజాకరింపబడుచున్నది',
	'maintenance-error' => 'పొరపాటు: $1',
	'maintenance-memc-requests' => 'అభ్యర్థనలు',
	'maintenance-memc-total' => 'మొత్తం:',
	'maintenance-memc-invalid' => 'చెల్లనివి:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'maintenance-reason' => 'Motivu',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'maintenance-reason' => 'เหตุผล',
	'maintenance-confirm' => 'ยืนยัน',
	'maintenance-memc-total' => 'รวม:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'maintenance-name' => 'Ulanyjy ady',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'maintenance' => 'Patakbuhin ang mga panitik na pang-pagpapanatili',
	'maintenance-desc' => '[[Special:Maintenance|Ugnayang-hangganan ng Wiki]] para sa sari-saring mga panitik na pang-pagpapanatili',
	'right-maintenance' => 'Patakbuhin ang mga panitik ng pagpapanatili sa pamamagitan ng [[Special:Maintenance]]',
	'maintenance-backlink' => 'Bumalik sa pilian ng mga panitik',
	'maintenance-header' => 'Pakipili lamang ng isang panitik sa ibaba na isasakatuparan.
Katabi ng bawat panitik ang mga paglalarawan',
	'maintenance-changePassword-desc' => 'Palitan ang hudyat ng isang tagagamit',
	'maintenance-createAndPromote-desc' => "Lumikha ng isang tagagamit at itaas sa katayuang ''sysop'' (tagapagpatakbo ng sistema)",
	'maintenance-deleteBatch-desc' => 'Malawakang burahin ang mga pahina',
	'maintenance-deleteRevision-desc' => 'Tanggalin ang mga pagbabago mula sa kalipunan ng dato',
	'maintenance-eval-desc' => 'Limiin/Suriin ang kodigong PHP na nasa loob ng kapiligiran ng MediaWiki',
	'maintenance-initEditCount-desc' => 'Muling tuusin ang mga bilang ng pagbabago ng mga tagagamit',
	'maintenance-initStats-desc' => 'Muling tuusin ang mga estadistika ng sityo',
	'maintenance-moveBatch-desc' => 'Malawakang ilipat ang mga pahina',
	'maintenance-reassignEdits-desc' => 'Muling italaga ang mga pagbabago mula sa isang tagagamit patungo sa iba pa',
	'maintenance-runJobs-desc' => 'Patakbuhin ang mga gawaing nasa loob ng pila ng gawain',
	'maintenance-showJobs-desc' => 'Magpakita ng isang talaan ng mga gawaing naghihintay sa loob ng pila ng mga gawain',
	'maintenance-sql-desc' => 'Magsakatupran ng isang katanungang SQL',
	'maintenance-stats-desc' => 'Ipakita ang mga estadistikang nakatago sa alaala/memorya',
	'maintenance-changePassword' => 'Gamitin ang pormularyong ito upang baguhin ang hudyat ng isang tagagamit',
	'maintenance-createAndPromote' => "Gamitin ang pormularyong ito upang makalikha ng isang bagong tagagamit at maitaas ito bilang ''sysop''.
Lagyan ng tsek ang kahon ng burokrato kung nais mong itaas din ito bilang burokrato",
	'maintenance-deleteBatch' => 'Gamitin ang pormularyong ito upang malawakang makapagbura ng mga pahina.
Maglagay lamang ng isang pahina sa bawat guhit',
	'maintenance-deleteRevision' => 'Gamitin ang pormularyong ito upang malawakang makapagbura ng mga pagbabago.
Maglagay lamang ng isang bilang ng pagbabago sa bawat guhit',
	'maintenance-initStats' => 'Gamitin ang pormularyong ito upang muling tuusin ang mga estadistika ng sityo, na tinutukoy kung nais mo ring tuusing muli ang mga pagtingin sa pahina',
	'maintenance-moveBatch' => "Gamitin ang pormularyong ito upang malawakang makapaglipat ng mga pahina.
Dapat na tinutukoy ng bawat guhit ang isang pinagmulang pahina at kapupuntahang pahina na pinaghihiwalay ng isang \"tubo\" (''pipe'')",
	'maintenance-invalidtype' => 'Hindi tanggap na uri!',
	'maintenance-name' => 'Pangalan ng tagagamit',
	'maintenance-password' => 'Hudyat',
	'maintenance-bureaucrat' => 'Itaas ang tagagamit patungo sa katayuang burokrato',
	'maintenance-reason' => 'Dahilan',
	'maintenance-update' => 'Gamitin ang ISAPANAHON kapag nagsasapanahon ng mga tabla? Sa halip nito, gumagamit ang mga hindi pa nasusuri ng BURAHIN/ISINGIT.',
	'maintenance-noviews' => 'Lagyan ito ng tsek upang maiwasan ang pagsasapanahon ng bilang ng mga pagtingin sa pahina',
	'maintenance-confirm' => 'Tiyakin',
	'maintenance-invalidname' => 'Hindi tanggap na pangalan ng tagagamit!',
	'maintenance-success' => 'Matagumpay na tumakbo ang $1!',
	'maintenance-userexists' => 'Umiiral na ang tagagamit!',
	'maintenance-invalidtitle' => 'Hindi tanggap na pamagat ang "$1"!',
	'maintenance-titlenoexist' => 'Hindi umiiral ang tinukoy na pamagat ("$1")!',
	'maintenance-failed' => 'NABIGO',
	'maintenance-deleted' => 'NABURA',
	'maintenance-revdelete' => 'Binubura ang {{PLURAL:$3|pagbabago|mga pagbabago}}ng $1 mula sa wiking $2',
	'maintenance-revnotfound' => 'Hindi natagpuan ang pagbabagong $1!',
	'maintenance-sql' => 'Gamitin ang pormularyong ito upang maisakatuparan ang isang katanungang SQL sa kalipunan ng dato.',
	'maintenance-sql-aff' => 'Apektadong pahalang na mga hanay: $1',
	'maintenance-sql-res' => '$1 {{PLURAL:$1|pahalang na hanay|pahalang na mga hanay}} ibinalik:
$2',
	'maintenance-stats-edits' => 'Bilang ng mga pagbabago: $1',
	'maintenance-stats-articles' => 'Bilang ng mga pahinang nasa pangunahing espasyo ng pangalan: $1',
	'maintenance-stats-pages' => 'Bilang ng mga pahina: $1',
	'maintenance-stats-users' => 'Bilang ng mga tagagamit: $1',
	'maintenance-stats-admins' => 'Bilang ng mga tagapangasiwa: $1',
	'maintenance-stats-images' => 'Bilang ng mga talaksan: $1',
	'maintenance-stats-views' => 'Bilang ng mga pagtingin sa pahina: $1',
	'maintenance-stats-update' => 'Isinasapanahon ang kalipunan ng dato{{int:ellipsis}}',
	'maintenance-move' => 'Inililipat ang $1 patungo sa $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Nakaranas ng kamalian habang naglilipat: $1.
Itinitigil ang paglilipat',
	'maintenance-error' => 'Kamalian: $1',
	'maintenance-memc-fake' => 'Ipinatatakbo ang FakeMemCachedClient. Walang maibibigay na mga estadistika',
	'maintenance-memc-requests' => 'Mga kahilingan',
	'maintenance-memc-withsession' => 'may nakalaang panahon:',
	'maintenance-memc-withoutsession' => 'walang nakalaang panahon:',
	'maintenance-memc-total' => 'kabuoan:',
	'maintenance-memc-parsercache' => 'Ligpitan ng mga banghay',
	'maintenance-memc-hits' => 'mga pagsapol (pagpunta):',
	'maintenance-memc-invalid' => 'hindi tanggap:',
	'maintenance-memc-expired' => 'walang bisa:',
	'maintenance-memc-absent' => 'wala:',
	'maintenance-memc-stub' => 'katindihan ng usbong:',
	'maintenance-memc-imagecache' => 'Taguan ng larawan',
	'maintenance-memc-misses' => 'mga hindi pagsapol:',
	'maintenance-memc-updates' => 'mga pagsasapanahon:',
	'maintenance-memc-uncacheable' => 'hindi maitatago:',
	'maintenance-memc-diffcache' => 'Taguan ng Pagkakaiba',
	'maintenance-eval' => 'Gamitin ang pormularyong ito upang suriin ang kodigong PHP na nasa loob ng kapaligiran ng MediaWiki.',
	'maintenance-reassignEdits' => 'Gamitin ang pormularyong ito upang muling maitalaga ang mga pagbabago mula sa isang tagagamit patungo sa iba pa.',
	'maintenance-re-from' => 'Pangalan ng tagagamit na panggagalingan ng mga itatalagang pagbabago',
	'maintenance-re-to' => 'Pangalan ng tagagamit na patutunguhan ng mga itatalagang pagbabago',
	'maintenance-re-force' => 'Italagang muli kahit na hindi umiiral ang pinupukol na tagagamit',
	'maintenance-re-rc' => 'Huwag isapanahon ang tabla ng kamakailang mga pagbabago',
	'maintenance-re-report' => 'Maglimbag ng mga detalye hinggil sa mga babaguhin, subalit huwag itong isapanahon',
	'maintenance-re-nf' => 'Hindi natagpuan ang tagagamit na $1',
	'maintenance-re-rr' => 'Patakbuhing muli ang panitik na walang "$1" upang maisapanahon.',
	'maintenance-re-ce' => 'Pangkasalukuyang mga pagbabago: $1',
	'maintenance-re-de' => 'Naburang mga pagbabago: $1',
	'maintenance-re-rce' => 'Mga ipinasok na Kamakailang mga Pagbabago: $1',
	'maintenance-re-total' => 'Kabuoan ng mga ipinasok na babaguhin: $1',
	'maintenance-re-re' => 'Muling pagtatalaga ng mga pagbabago{{int:ellipsis}} nagawa na',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'maintenance' => 'Bakım betiklerini çalıştır',
	'maintenance-desc' => 'Çeşitli bakım betikleri için [[Special:Maintenance|viki arayüzü]]',
	'maintenance-backlink' => 'Betik seçimine geri dön',
	'maintenance-header' => 'Lütfen çalıştırmak için aşağıdan bir betik seçin.
Her betiğin yanında açıklamalarına yer verilmiştir.',
	'maintenance-changePassword-desc' => 'Bir kullanıcının parolasını değiştir',
	'maintenance-deleteBatch-desc' => 'Sayfaları toplu sil',
	'maintenance-deleteRevision-desc' => 'Sürümleri veritabanından kaldır',
	'maintenance-initEditCount-desc' => 'Kullanıcıların değişiklik sayılarını tekrar hesapla',
	'maintenance-initStats-desc' => 'Site istatistiklerini tekrar hesapla',
	'maintenance-moveBatch-desc' => 'Sayfaları toplu taşı',
	'maintenance-runJobs-desc' => 'İş kuyruğunda işleri yürüt',
	'maintenance-invalidtype' => 'Geçersiz tür!',
	'maintenance-name' => 'Kullanıcı adı',
	'maintenance-password' => 'Parola',
	'maintenance-bureaucrat' => 'Kullanıcıyı bürokrat statüsüne yükselt',
	'maintenance-reason' => 'Neden',
	'maintenance-confirm' => 'Onayla',
	'maintenance-invalidname' => 'Geçersiz kullanıcı adı!',
	'maintenance-userexists' => 'Kullanıcı zaten mevcut!',
	'maintenance-failed' => 'BAŞARISIZ',
	'maintenance-deleted' => 'Silindi',
	'maintenance-revnotfound' => '$1 sürümü bulunamadı!',
	'maintenance-sql-aff' => 'Etkilenen satırlar: $1',
	'maintenance-stats-edits' => 'Değişiklik sayısı: $1',
	'maintenance-stats-articles' => 'Ana isim alanındaki sayfaların saysı: $1',
	'maintenance-stats-pages' => 'Sayfa sayısı: $1',
	'maintenance-stats-users' => 'Kullanıcı sayısı: $1',
	'maintenance-stats-admins' => 'Hizmetli sayısı: $1',
	'maintenance-stats-images' => 'Dosya sayısı: $1',
	'maintenance-stats-views' => 'Sayfa görüntüleme sayısı: $1',
	'maintenance-error' => 'Hata: $1',
	'maintenance-memc-requests' => 'İstekler',
	'maintenance-memc-withsession' => 'oturumlu:',
	'maintenance-memc-withoutsession' => 'oturumsuz:',
	'maintenance-memc-total' => 'toplam:',
	'maintenance-memc-parsercache' => 'Ayrıştırıcı önbellek',
	'maintenance-memc-hits' => 'eşleşme:',
	'maintenance-memc-stub' => 'taslak eşiği:',
	'maintenance-memc-imagecache' => 'Resim önbelleği',
	'maintenance-memc-updates' => 'güncellemeler',
	'maintenance-memc-diffcache' => 'Fark Önbelleği',
	'maintenance-re-rc' => 'Son değişiklikler tablosunu güncellemeyin',
	'maintenance-re-ce' => 'Mevcut değişiklik: $1',
	'maintenance-re-de' => 'Silinen değişiklikler: $1',
	'maintenance-re-rce' => 'SonDeğişiklikler girdileri: $1',
	'maintenance-re-total' => 'Değiştirilecek toplam girdi: $1',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'maintenance-name' => 'ئىشلەتكۇچى ئىسمى',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'maintenance-name' => 'Ishletkuchi ismi',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'maintenance-confirm' => 'Підтвердити',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'maintenance-invalidtype' => 'Vär tip!',
	'maintenance-name' => 'Kävutajan nimi',
	'maintenance-password' => 'Peitsana',
	'maintenance-bureaucrat' => 'Panda kävutai bürokrataks',
	'maintenance-reason' => 'Sü',
	'maintenance-confirm' => 'Vahvištoitta',
	'maintenance-invalidname' => 'Vär kävutajannimi!',
	'maintenance-failed' => 'ONETOMAŠTI',
	'maintenance-deleted' => 'ČUTUD POIŠ',
	'maintenance-error' => 'Petuz: $1',
	'maintenance-memc-total' => 'kaiked:',
	'maintenance-memc-parsercache' => 'Parseran keš',
	'maintenance-memc-hits' => 'kacundoid:',
	'maintenance-memc-invalid' => 'värid:',
	'maintenance-memc-expired' => 'männuden lopstrokanke:',
	'maintenance-memc-absent' => 'ei ole:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'maintenance' => 'Chạy mã bảo trì',
	'maintenance-desc' => '[[Special:Maintenance|Giao diện web]] dành cho các loại mã bảo trì khác nhau',
	'maintenance-backlink' => 'Quay lại lựa chọn mã',
	'maintenance-header' => 'Xin hãy chọn một đoạn mã ở dưới để thực thi.
Mô tả nằm ở bên cạnh mỗi đoạn mã',
	'maintenance-changePassword-desc' => 'Thay đổi mật khẩu của thành viên',
	'maintenance-createAndPromote-desc' => 'Tạo một thành viên và phong cho thành viên này thành sysop',
	'maintenance-deleteBatch-desc' => 'Xóa trang hàng loạt',
	'maintenance-deleteRevision-desc' => 'Xóa một phiên bản ra khỏi cơ sở dữ liệu',
	'maintenance-initEditCount-desc' => 'Tính toán lại số lần sửa đổi của thành viên',
	'maintenance-initStats-desc' => 'Tính toán lại các thống kê của trang',
	'maintenance-moveBatch-desc' => 'Di chuyển trang hàng loạt',
	'maintenance-runJobs-desc' => 'Chạy các tác vụ trong hàng đợi công việc',
	'maintenance-showJobs-desc' => 'Hiển thị danh sách các công việc đang chờ đợi trong hàng đợi việc',
	'maintenance-stats-desc' => 'Hiển thị thống kê được lưu vào bộ đệm',
	'maintenance-changePassword' => 'Sử dụng mẫu này để thay đổi mật khẩu của thành viên',
	'maintenance-createAndPromote' => 'Sử dụng mẫu này để tạo ra thành viên mới và phong cho thành viên này cờ sysop.
Chọn vào ô hành chính viên nếu bạn cũng muốn phong thành Hành chính viên',
	'maintenance-deleteBatch' => 'Sử dụng mẫu này để xóa trang hàng loạt.
Chỉ ghi mỗi dòng một trang',
	'maintenance-deleteRevision' => 'Sử dụng mẫu này để xóa phiên bản hàng loạt.
Chỉ ghi mỗi dòng một phiên bản',
	'maintenance-initStats' => 'Sử dụng mẫu này để tính lại các thống kê của trang, hãy chỉ rõ nếu bạn cũng muốn tính lại số lần xem trang',
	'maintenance-moveBatch' => 'Sử dụng mẫu này để di chuyển trang hàng loạt.
Mỗi dòng nên ghi rõ trang nguồn và trang đích, cách nhau bằng dấu sọc đứng',
	'maintenance-invalidtype' => 'Kiểu không hợp lệ!',
	'maintenance-name' => 'Tên người dùng',
	'maintenance-password' => 'Mật khẩu',
	'maintenance-bureaucrat' => 'Thăng người này làm hành chính viên',
	'maintenance-reason' => 'Lý do',
	'maintenance-update' => 'Có sử dụng UPDATE khi cập nhật một bảng? Thay vào đó hãy bỏ chọn cách dùng DELETE/INSERT.',
	'maintenance-noviews' => 'Chọn cái này để ngăn cập nhật số lần xem trang',
	'maintenance-confirm' => 'Xác nhận',
	'maintenance-invalidname' => 'Tên người dùng không hợp lệ!',
	'maintenance-success' => '$1 đã chạy thành công!',
	'maintenance-userexists' => 'Người dùng đã tồn tại!',
	'maintenance-invalidtitle' => 'Tựa đề “$1” không hợp lệ!',
	'maintenance-titlenoexist' => 'Tựa đề chỉ định (“$1”) không tồn tại!',
	'maintenance-failed' => 'THẤT BẠI',
	'maintenance-deleted' => 'ĐÃ XÓA',
	'maintenance-revdelete' => 'Đang xóa {{PLURAL:$3|phiên bản|các phiên bản}} $1 từ wiki $2',
	'maintenance-revnotfound' => 'Không tìm thấy phiên bản $1!',
	'maintenance-stats-edits' => 'Số lần sửa đổi: $1',
	'maintenance-stats-articles' => 'Số trang trong không gian tên chính: $1',
	'maintenance-stats-pages' => 'Số trang: $1',
	'maintenance-stats-users' => 'Số người dùng: $1',
	'maintenance-stats-admins' => 'Số quản lý: $1',
	'maintenance-stats-images' => 'Số tập tin: $1',
	'maintenance-stats-views' => 'Số lần xem trang: $1',
	'maintenance-stats-update' => 'Đang cập nhật cơ sở dữ liệu...',
	'maintenance-move' => 'Đang di chuyển $1 sang $2...',
	'maintenance-movefail' => 'Gặp lỗi khi di chuyển: $1.
Hủy di chuyển',
	'maintenance-error' => 'Lỗi: $1',
	'maintenance-memc-fake' => 'Bạn đang chạy FakeMemCachedClient. Không có thống kê nào',
	'maintenance-memc-requests' => 'Yêu cầu',
	'maintenance-memc-withsession' => 'với phiên:',
	'maintenance-memc-withoutsession' => 'không có phiên',
	'maintenance-memc-total' => 'tổng cộng:',
	'maintenance-memc-parsercache' => 'Bộ đệm Phân tích cú pháp',
	'maintenance-memc-hits' => 'số hit:',
	'maintenance-memc-invalid' => 'không hợp lệ:',
	'maintenance-memc-expired' => 'hết hạn:',
	'maintenance-memc-absent' => 'thiếu:',
	'maintenance-memc-stub' => 'ngưỡng sơ khai:',
	'maintenance-memc-imagecache' => 'Bộ đệm Hình ảnh',
	'maintenance-memc-misses' => 'số miss:',
	'maintenance-memc-updates' => 'số cập nhật:',
	'maintenance-memc-uncacheable' => 'không thể lưu đệm:',
	'maintenance-memc-diffcache' => 'Khác nhau Bộ đệm',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'maintenance-changePassword-desc' => 'Votükön gebanaletavödi',
	'maintenance-createAndPromote-desc' => 'Jafön gebani e gevön one guvanastadi',
	'maintenance-deleteBatch-desc' => 'Moükön padamödoti',
	'maintenance-deleteRevision-desc' => 'Moükön revidis se nünodem',
	'maintenance-initEditCount-desc' => 'Dönukalkulön redakamanumi gebanas',
	'maintenance-initStats-desc' => 'Dönukalkulön sitastatitis',
	'maintenance-moveBatch-desc' => 'Topätükön padamödoti',
	'maintenance-reassignEdits-desc' => 'Givülön redakamis gebana bal gebane votik',
	'maintenance-changePassword' => 'Gebolös fometi at ad votükön letavödi gebana',
	'maintenance-createAndPromote' => 'Gebolös fometi at ad jafön gebani nulik e gevön one guvanastadi.
Välolös i „büran“ if vilol gevön one i büranastadi.',
	'maintenance-deleteBatch' => 'Gebolös fometi at ad moükön padamödoti.
Penolös padi te bali a lien.',
	'maintenance-deleteRevision' => 'Gebolös fometi at ad moükön revidamödoti.
Penolös revidi te bali a lien.',
	'maintenance-initStats' => 'Gebolös fometi at ad dönukalkulön statitis topädik. Mäniotolös, if vilol dönukalkulön i padilogamis.',
	'maintenance-moveBatch' => 'Gebolös fometi at ad topätükön padamödoti.
Lien alik muton ninädön fonätapadi e zeilapadi pateilölis dub malat: „|“',
	'maintenance-invalidtype' => 'Sot no lonöföl!',
	'maintenance-name' => 'Gebananem',
	'maintenance-password' => 'Letavöd',
	'maintenance-bureaucrat' => 'Gevön gebane stadi bürana',
	'maintenance-reason' => 'Kod',
	'maintenance-confirm' => 'Fümedön',
	'maintenance-invalidname' => 'Gebananem no lonöfon!',
	'maintenance-userexists' => 'Geban ya dabinon!',
	'maintenance-invalidtitle' => 'Tiäd no lonöföl: „$1“!',
	'maintenance-titlenoexist' => 'Tiäd pavilöl („$1“) no dabinon!',
	'maintenance-failed' => 'NO EPLÖPON',
	'maintenance-deleted' => 'PEMOÜKON',
	'maintenance-revdelete' => 'Revids: $1 se vük: $2 pamoükons',
	'maintenance-revnotfound' => 'Revid: $1 no petuvon!',
	'maintenance-stats-edits' => 'Num redakamas: $1',
	'maintenance-stats-articles' => 'Num padas in nemaspad cifik: $1',
	'maintenance-stats-pages' => 'Num padas: $1',
	'maintenance-stats-users' => 'Num gebanas: $1',
	'maintenance-stats-admins' => 'Num guvanas: $1',
	'maintenance-stats-images' => 'Num ragivas: $1',
	'maintenance-stats-views' => 'Num padilogams: $1',
	'maintenance-move' => 'Pad: $1 patopätükon ad pad: $2{{int:ellipsis}}',
	'maintenance-movefail' => 'Pöl dü topätükam pada: $1.
Topätükam pestöpädon.',
	'maintenance-error' => 'Pöl: $1',
	'maintenance-memc-requests' => 'Begs',
	'maintenance-memc-total' => 'valod:',
	'maintenance-reassignEdits' => 'Gebolös fometi at ad dönugivülön redakamis gebana bal gebane votik.',
	'maintenance-re-from' => 'Nem gebana, kelas redakams podönugivülons',
	'maintenance-re-to' => 'Nem gebana, kele redakams pogivülons',
	'maintenance-re-force' => 'Dönugivülön ifi zeilageban no dabinon',
	'maintenance-re-nf' => 'Geban: $1 no petuvon',
	'maintenance-re-de' => 'Redakams pemoüköl: $1',
	'maintenance-re-re' => 'Redakams padönugivülons{{int:ellipsis}} peledunon.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'maintenance-name' => 'באַניצער נאָמען',
	'maintenance-password' => 'פאַסווארט',
	'maintenance-reason' => 'אורזאַך',
	'maintenance-confirm' => 'באַשטעטיגן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author PhiLiP
 * @author Wrightbus
 */
$messages['zh-hans'] = array(
	'maintenance-name' => '使用者名称',
	'maintenance-password' => '密码',
	'maintenance-reason' => '原因',
	'maintenance-confirm' => '确认',
	'maintenance-memc-requests' => '请求',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'maintenance-name' => '使用者名稱',
	'maintenance-password' => '密碼',
	'maintenance-reason' => '原因',
	'maintenance-confirm' => '確認',
	'maintenance-memc-requests' => '請求',
);

