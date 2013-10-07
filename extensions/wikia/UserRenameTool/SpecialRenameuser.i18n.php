<?php
/**
 * Internationalisation file for extension UserRenameTool.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'userrenametool' => "Change a user's name",
	'renameuser' => 'Rename user',
	'userrenametool-warning' => '<strong>Please read the following information carefully</strong>:<p>Before renaming a user, please make sure <strong>all the information is correct</strong>, and ensure that <strong>the user knows it may take some time to complete</strong>.
<br />Please be aware that due to some external factors the first part of the process <strong>could result in a blank page</strong>, that doesn\'t mean the process won\'t be completed correctly.</p><p>You can track the progress of the process through [[Special:Stafflog|Staff log]], also <strong>the system will send an email to you as the whole rename procedure will be completed</strong>.</p>',
	'userrenametool-desc' => 'Adds a [[Special:UserRenameTool|special page]] to rename a user (need \'\'renameuser\'\' right) and process all the related data',
	'userrenametool-old' => 'Current username:',
	'userrenametool-new' => 'New username:',
    'userrenametool-encoded' => 'URL encoded:',
	'userrenametool-reason' => 'Reason for rename:',
	'userrenametool-move' => 'Move user and talk pages (and their subpages) to new name',
	'userrenametool-reserve' => 'Block the old username from future use',
	'userrenametool-notify-renamed' => 'Send e-mail to renamed user when done',
	'userrenametool-warnings' => 'Warnings:',
	'userrenametool-requested-rename' => 'User $1 requested a rename',
	'userrenametool-did-not-request-rename' => 'User $1 did not request a rename',
	'userrenametool-previously-renamed' => 'User $1 has already had a rename',
	'userrenametool-phalanx-matches' => 'Phalanx filters matching $1:',
	'userrenametool-confirm' => 'Yes, rename the user',
	'userrenametool-submit' => 'Change username',

	'userrenametool-error-antispoof-conflict' => 'AntiSpoof warning - there is already a username similar to "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof is not installed.',
	'userrenametool-errordoesnotexist' => 'The user "<nowiki>$1</nowiki>" does not exist.',
	'userrenametool-errorexists' => 'The user "<nowiki>$1</nowiki>" already exists.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" is not a valid username.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" is not a valid new username.',
	'userrenametool-errortoomany' => 'The user "<nowiki>$1</nowiki>" has $2 {{PLURAL:$2|contribution|contributions}}, renaming a user with more than $3 {{PLURAL:$3|contribution|contributions}} could adversely affect site performance.',
	'userrenametool-errorprocessing' => 'The rename process for user <nowiki>$1</nowiki> to <nowiki>$2</nowiki> is already in progress.',
	'userrenametool-errorblocked' => 'User <nowiki>$1</nowiki> is blocked by <nowiki>$2</nowiki> for $3.',
	'userrenametool-errorlocked' => 'User <nowiki>$1</nowiki> is blocked.',
	'userrenametool-errorbot' => 'User <nowiki>$1</nowiki> is a bot.',
	'userrenametool-error-request' => 'There was a problem with receiving the request.
Please go back and try again.',
	'userrenametool-error-same-user' => 'You cannot rename a user to the same name.',
	'userrenametool-error-extension-abort' => 'An extension prevented the rename process.',
	'userrenametool-error-cannot-rename-account' => 'Renaming the user account on the shared global database failed.',
	'userrenametool-error-cannot-create-block' => 'Creation of Phalanx block failed.',
	'userrenametool-error-cannot-rename-unexpected' => 'Unexpected error occurred, check logs or try again.',
	'userrenametool-warnings-characters' => 'New username contains illegal characters!',
	'userrenametool-warnings-maxlength' => 'New username\'s length cannot exceed 255 characters!',
	'userrenametool-warn-repeat' => 'Attention! The user "<nowiki>$1</nowiki>" has already been renamed to "<nowiki>$2</nowiki>".
Continue processing only if you need to update some missing information.',
	'userrenametool-warn-table-missing' => 'Table "<nowiki>$2</nowiki>" does not exist in database "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 started to rename: $2 to $3 (logs: $4).
Reason: "$5".',
	'userrenametool-info-finished' => '$1 completed rename: $2 to $3 (logs: $4).
Reason: "$5".',
	'userrenametool-info-failed' => '$1 FAILED rename: $2 to $3 (logs: $4).
Reason: "$5".',
	'userrenametool-info-wiki-finished' => '$1 renamed $2 to $3 on $4.
Reason: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 renamed $2 to $3 on $4 with errors.
Reason: "$5".',
	'userrenametool-info-in-progress' => 'Rename process is in progress.
The rest will be done in background.
You will be notified via e-mail when it is completed.',
	'userrenametool-success' => 'The user "$1" has been renamed to "$2".',

	'userrenametool-confirm-intro' => 'Do you really want to do this?',
	'userrenametool-confirm-yes' => 'Yes',
	'userrenametool-confirm-no' => 'No',

	'userrenametool-page-exists' => 'The page $1 already exists and cannot be automatically overwritten.',
	'userrenametool-page-moved' => 'The page $1 has been moved to $2.',
	'userrenametool-page-unmoved' => 'The page $1 could not be moved to $2.',

	'userrenametool-finished-email-subject' => 'User rename process completed for [$1]',
	'userrenametool-finished-email-body-text' => 'The move process for "<nowiki>$1</nowiki>" to "<nowiki>$2</nowiki>" has been completed.',
	'userrenametool-finished-email-body-html' => 'The move process for "<nowiki>$1</nowiki>" to "<nowiki>$2</nowiki>" has been completed.',

	'userrenametool-logpage' => 'User rename log',
	'userrenametool-logpagetext' => 'This is a log of changes to user names.',
	'userrenametool-logentry' => 'renamed $1 to "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edit|$1 edits}}.
Reason: $2',
	'userrenametool-move-log' => 'Automatically moved page while renaming the user "[[User:$1|$1]]" to "[[User:$2|$2]]"',

	'right-renameuser' => 'Rename users',
	'action-renameuser' => 'rename users',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Meno25
 * @author SPQRobin
 * @author Shirayuki
 * @author Siebrand
 * @author Тест
 */
$messages['qqq'] = array(
	'renameuser' => '{{Identical|Rename user}}',
	'userrenametool-desc' => 'Short description of the Renameuser extension, shown on [[Special:Version]]. Do not translate or change links.',
	'userrenametool-encoded' => 'Label for URL encoded version of new username',
	'userrenametool-reserve' => 'Option to block the old username (after it has been renamed) from being used again.',
	'userrenametool-warnings' => '{{Identical|Warning}}',
	'userrenametool-submit' => '{{Identical|Submit}}',
	'userrenametool-error-antispoof-conflict' => 'Message to show when similarity conflict occurs for new username.',
	'userrenametool-error-antispoof-notinstalled' => 'Message to show when AntiSpoof extension is not installed.',
	'userrenametool-error-cannot-create-block' => 'When this user rename tool is running, a block is supposed to be put in place to prevent the user from being able to edit to prevent data corruption. This message appears as a warning that the block was not able to be added automatically and that the user will need to be blocked manually.',
	'userrenametool-error-cannot-rename-unexpected' => 'Process failed on some point, detailed info with path to file and number of line can be found in logs',
	'userrenametool-info-wiki-finished' => '',
	'userrenametool-confirm-yes' => '{{Identical|Yes}}',
	'userrenametool-confirm-no' => '{{Identical|No}}',
	'userrenametool-logentry' => 'Used in [[Special:Log/renameuser]].
* Parameter $1 is the original username
* Parameter $2 is the new username',
	'right-renameuser' => '{{doc-right|renameuser}}
{{Identical|Rename user}}',
	'action-renameuser' => '{{doc-action|renameuser}}
{{Identical|Rename user}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'renameuser' => 'Hernoem gebruiker',
	'userrenametool-desc' => "Herdoop gebruikers (benodig ''renameuser'' regte)",
	'userrenametool-old' => 'Huidige gebruikersnaam:',
	'userrenametool-new' => 'Nuwe gebruikersnaam:',
	'userrenametool-reason' => 'Rede vir hernoeming:',
	'userrenametool-warnings' => 'Waarskuwings:',
	'userrenametool-submit' => 'Hernoem',
	'userrenametool-errordoesnotexist' => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan nie',
	'userrenametool-errorexists' => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan reeds',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" is \'n ongeldige gebruikernaam',
	'userrenametool-success' => 'Die gebruiker "<nowiki>$1</nowiki>" is hernoem na "<nowiki>$2</nowiki>".',
	'userrenametool-logpage' => 'Logboek van gebruikershernoemings',
	'right-renameuser' => 'Hernoem gebruikers',
);

/** Aragonese (aragonés)
 * @author Juanpabl
 * @author SMP
 */
$messages['an'] = array(
	'renameuser' => 'Renombrar un usuario',
	'userrenametool-desc' => "Renombrar un usuario (amenista os dreitos de ''renameuser'')",
	'userrenametool-old' => 'Nombre autual:',
	'userrenametool-new' => 'Nombre nuebo:',
	'userrenametool-reason' => "Razón d'o cambeo de nombre:",
	'userrenametool-move' => "Tresladar as pachinas d'usuario y de descusión (y as suyas sozpachinas) ta o nuebo nombre",
	'userrenametool-warnings' => 'Albertenzias:',
	'userrenametool-confirm' => "Sí, quiero cambiar o nombre de l'usuario",
	'userrenametool-submit' => 'Nimbiar',
	'userrenametool-errordoesnotexist' => 'L\'usuario "<nowiki>$1</nowiki>" no esiste.',
	'userrenametool-errorexists' => 'L\'usuario "<nowiki>$1</nowiki>" ya esiste.',
	'userrenametool-errorinvalid' => 'O nombre d\'usuario "<nowiki>$1</nowiki>" no ye conforme.',
	'userrenametool-errortoomany' => 'L\'usuario "<nowiki>$1</nowiki>" tiene $2 {{PLURAL:$2|contrebuzión|contrebuzions}}. Si renombra un usuario con más de $3 {{PLURAL:$3|contrebuzión|contrebuzions}} podría afeutar ta o funzionamiento d\'o sitio.',
	'userrenametool-error-request' => 'Bi abió un problema reculliendo a demanda. Por fabor, torne entazaga y prebe una atra begada.',
	'userrenametool-error-same-user' => 'No puede renombrar un usuario con o mesmo nombre que ya teneba.',
	'userrenametool-success' => 'S\'ha renombrau l\'usuario "<nowiki>$1</nowiki>" como "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'A pachina $1 ya esiste y no puede estar sustituyita automaticament.',
	'userrenametool-page-moved' => "S'ha tresladato a pachina $1 ta $2.",
	'userrenametool-page-unmoved' => "A pachina $1 no s'ha puesto tresladar ta $2.",
	'userrenametool-logpage' => "Rechistro de cambios de nombre d'usuarios",
	'userrenametool-logpagetext' => "Isto ye un rechistro de cambios de nombres d'usuarios",
	'userrenametool-logentry' => 'Renombrato $1 como "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edizión|$1 edizions}}. Razón: $2',
	'userrenametool-move-log' => 'Pachina tresladata automaticament en renombrar o usuario "[[User:$1|$1]]" como "[[User:$2|$2]]"',
	'right-renameuser' => 'Renombrar usuarios',
);

/** Old English (Ænglisc)
 */
$messages['ang'] = array(
	'renameuser' => 'Ednemnan brūcend',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Malhargan
 * @author Meno25
 * @author Mido
 * @author Mutarjem horr
 * @author OsamaK
 */
$messages['ar'] = array(
	'userrenametool' => 'غيّر اسم مستخدم',
	'renameuser' => 'أعد تسمية المستخدم',
	'userrenametool-desc' => "يضيف [[Special:Renameuser|صفحة خاصة]] لإعادة تسمية مستخدم (يحتاج إلى صلاحية ''renameuser'')",
	'userrenametool-old' => 'اسم المستخدم الحالي:',
	'userrenametool-new' => 'اسم المستخدم الجديد:',
	'userrenametool-reason' => 'السبب لإعادة التسمية:',
	'userrenametool-move' => 'انقل صفحات المستخدم ونقاشه (و الصفحات المتفرعة) إلى الاسم الجديد',
	'userrenametool-reserve' => 'إمنع إستعمال الاسم القديم في المستقبل',
	'userrenametool-notify-renamed' => 'أرسل بريد إلكتروني إلى المستخدم الذي تمت إعادة تسميته عند الإنتهاء',
	'userrenametool-warnings' => 'التحذيرات:',
	'userrenametool-requested-rename' => 'المستخدم  $1  طلب إعادة تسمية',
	'userrenametool-did-not-request-rename' => 'المستخدم  $1  لم يطلب إعادة تسمية',
	'userrenametool-previously-renamed' => 'المستخدم  $1  كان له بالفعل عملية إعادة تسمية',
	'userrenametool-phalanx-matches' => 'مطابقة مرشحات الفالانكس $1:',
	'userrenametool-confirm' => 'نعم، أعد تسمية المستخدم',
	'userrenametool-submit' => 'غيّر اسم المستخدم',
	'userrenametool-errordoesnotexist' => 'لا يوجد مستخدم بالاسم "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'المستخدم "<nowiki>$1</nowiki>" موجود سابقاً.',
	'userrenametool-errorinvalid' => 'اسم المستخدم "<nowiki>$1</nowiki>" غير صالح.',
	'userrenametool-errorinvalidnew' => '"<nowiki> $1 </nowiki>" ليس اسم مستخدم جديد صالح.',
	'userrenametool-errortoomany' => 'المستخدم "<nowiki>$1</nowiki>" لديه $2 {{PLURAL:$2|مساهمة|مساهمة}}، إعادة تسمية مستخدم لديه أكثر من $3 {{PLURAL:$3|مساهمة|مساهمة}} يمكن أن تؤثر سلبا على أداء الموقع.',
	'userrenametool-error-request' => 'حدثت مشكلة أثناء استقبال الطلب.
من فضلك عد وحاول مرة ثانية.',
	'userrenametool-error-same-user' => 'لا يمكنك إعادة تسمية مستخدم بنفس الاسم.',
	'userrenametool-warn-table-missing' => 'الجدول "<nowiki>$2</nowiki>" غير موجود في قاعدة المعطيات "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1بدأت إعادة تسمية:  $2  إلى  $3  (سجلات:  $4 ).
السبب: " $5 ".',
	'userrenametool-success' => 'تمت إعادة تسمية المستخدم "<nowiki>$1</nowiki>" إلى "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'هل تريد حقاً أن تفعل ذلك؟',
	'userrenametool-confirm-yes' => 'نعم',
	'userrenametool-confirm-no' => 'لا',
	'userrenametool-page-exists' => 'الصفحة $1 موجودة سابقاً ولا يمكن إنشاء أخرى مكانها تلقائياً.',
	'userrenametool-page-moved' => 'تم نقل الصفحة $1 إلى $2.',
	'userrenametool-page-unmoved' => 'تعثر نقل الصفحة $1 إلى $2.',
	'userrenametool-finished-email-subject' => 'إكتملت عملية إعادة تسمية المستخدم ل[$1]',
	'userrenametool-logpage' => 'سجل إعادة تسمية المستخدمين',
	'userrenametool-logpagetext' => 'هذا سجل بالتغييرات في أسماء المستخدمين.',
	'userrenametool-logentry' => 'أعاد تسمية $1 إلى "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 تعديل|$1 تعديل}}.
السبب: $2',
	'userrenametool-move-log' => 'نقل الصفحة تلقائيا خلال إعادة تسمية المستخدم من "[[User:$1|$1]]" إلى "[[User:$2|$2]]"',
	'right-renameuser' => 'إعادة تسمية المستخدمين',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'userrenametool' => 'ܫܚܠܦ ܫܡܐ ܕܡܦܠܚܢܐ',
	'renameuser' => 'ܬܢܝ ܫܘܡܗܐ ܕܡܦܠܚܢܐ',
	'userrenametool-old' => 'ܫܡܐ ܕܡܦܠܚܢܐ ܗܫܝܐ:',
	'userrenametool-new' => 'ܫܡܐ ܕܡܦܠܚܢܐ ܚܕܬܐ:',
	'userrenametool-reason' => 'ܥܠܬܐ ܕܬܢܝ ܫܘܡܗܐ:',
	'userrenametool-warnings' => 'ܙܘܗܪ̈ܐ:',
	'userrenametool-confirm' => 'ܐܝܢ، ܫܚܠܦ ܫܡܐ ܕܡܦܠܚܢܐ',
	'userrenametool-submit' => 'ܫܚܠܦ ܫܡܐ ܕܡܦܠܚܢܐ',
	'userrenametool-confirm-intro' => 'ܐܪܐ ܫܪܝܪܐܝܬ ܨܒܬ ܕܬܥܒܕ ܗܢܐ؟',
	'userrenametool-confirm-yes' => 'ܐܝܢ',
	'userrenametool-confirm-no' => 'ܠܐ',
	'userrenametool-logpage' => 'ܣܓܠܐ ܕܬܘܢܝ ܫܘܡܗܐ ܕܡܦܠܚܢܐ',
	'userrenametool-logpagetext' => 'ܗܢܘ ܣܓܠܐ ܕܫܘܚܠܦ̈ܐ ܕܫܡܗ̈ܐ ܕܡܦܠܚܢܐ.',
	'userrenametool-logentry' => 'ܬܢܝ ܫܘܡܗܐ $1 ܠ "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 ܫܘܚܠܦܐ|$1 ܫܘܚܠܦ̈ܐ}}.
ܥܠܬܐ: $2',
	'userrenametool-move-log' => 'ܝܬܐܝܬ ܫܢܐ ܦܐܬܐ ܟܕ ܬܢܝ ܫܘܡܗܐ ܕܡܦܠܚܢܐ "[[User:$1|$1]]" ܠ "[[User:$2|$2]]"',
	'right-renameuser' => 'ܬܢܝ ܫܘܡܗܐ ܕܡܦܠܚܢܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'renameuser' => 'تغيير تسمية يوزر',
	'userrenametool-desc' => "بيضيف [[Special:Renameuser|صفحة مخصوصة]] علشان تغير اسم يوزر(محتاج صلاحية ''renameuser'')",
	'userrenametool-old' => 'اسم اليوزر الحالي:',
	'userrenametool-new' => 'اسم اليوزر الجديد:',
	'userrenametool-reason' => 'السبب لإعادة التسميه:',
	'userrenametool-move' => 'انقل صفحات اليوزر و مناقشاته (بالصفحات الفرعية)للاسم الجديد.',
	'userrenametool-reserve' => 'احفظ اسم اليوزر القديم ضد الاستخدام',
	'userrenametool-warnings' => 'التحذيرات:',
	'userrenametool-confirm' => 'ايوه،سمى اليوزر دا من تاني',
	'userrenametool-submit' => 'تقديم',
	'userrenametool-errordoesnotexist' => 'اليوزر"<nowiki>$1</nowiki>" مالوش وجود.',
	'userrenametool-errorexists' => 'اليوزر "<nowiki>$1</nowiki>" موجود من قبل كدا.',
	'userrenametool-errorinvalid' => 'اسم اليوزر "<nowiki>$1</nowiki>"مش صحيح.',
	'userrenametool-errortoomany' => 'اليوزر "<nowiki>$1</nowiki>" عنده {{PLURAL:$2|مساهمة|مساهمة}}, تغيير اسم يوزر عنده اكتر من {{PLURAL:$3|مساهمة|مساهمة}} ممكن يأثر على اداء الموقع تاثير سلبي.',
	'userrenametool-error-request' => 'حصلت مشكلة فى استلام الطلب.
لو سمحت ارجع لورا و حاول تاني.',
	'userrenametool-error-same-user' => 'ما ينفعش تغير اسم اليوزر لنفس الاسم من تاني.',
	'userrenametool-success' => 'اليوزر "<nowiki>$1</nowiki>" اتغير اسمه لـ"<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'الصفحة $1 موجودة من قبل كدا و ماينفعش يتكتب عليها اوتوماتيكي.',
	'userrenametool-page-moved' => 'تم نقل الصفحه $1 ل $2.',
	'userrenametool-page-unmoved' => 'الصفحة $1 مانفعش تتنقل لـ$2.',
	'userrenametool-logpage' => 'سجل تغيير تسمية اليوزرز',
	'userrenametool-logpagetext' => 'دا سجل بالتغييرات فى أسامى اليوزرز',
	'userrenametool-logentry' => 'اتغيرت تسمية$1 لـ "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 تعديل|$1 تعديل}}. علشان: $2',
	'userrenametool-move-log' => 'الصفحة اتنقلت اوتوماتيكى لما اليوزر "[[User:$1|$1]]" اتغير اسمه لـ "[[User:$2|$2]]"',
	'right-renameuser' => 'غير اسم اليوزرز',
);

/** Asturian (asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'userrenametool' => "Camudar el nome d'un usuariu",
	'renameuser' => 'Renomar usuariu',
	'userrenametool-desc' => "Renoma un usuariu (necesita'l permisu ''renameuser'')",
	'userrenametool-old' => "Nome d'usuariu actual:",
	'userrenametool-new' => "Nome d'usuariu nuevu:",
	'userrenametool-reason' => 'Motivu del cambéu de nome:',
	'userrenametool-move' => "Treslladar les páxines d'usuariu y d'alderique (y toles subpáxines) al nome nuevu",
	'userrenametool-reserve' => "Bloquiar el nome d'usuariu antiguu pa evitar usalu nun futuru",
	'userrenametool-notify-renamed' => 'Unviar corréu al usuariu renomáu cuando tea fecho',
	'userrenametool-warnings' => 'Avisos:',
	'userrenametool-confirm' => "Sí, renomar l'usuariu",
	'userrenametool-submit' => 'Executar',
	'userrenametool-errordoesnotexist' => 'L\'usuariu "<nowiki>$1</nowiki>" nun esiste.',
	'userrenametool-errorexists' => 'L\'usuariu "<nowiki>$1</nowiki>" yá esiste.',
	'userrenametool-errorinvalid' => 'El nome d\'usuariu "<nowiki>$1</nowiki>" nun ye válidu.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" nun ye un nome d\'usuariu nuevu válidu.',
	'userrenametool-errortoomany' => 'L\'usuariu "<nowiki>$1</nowiki>" tien $2 {{PLURAL:$2|contribución|contribuciones}}; renomar a un usuariu con más de $3 {{PLURAL:$3|contribución|contribuciones}} podría afeutar al rindimientu del sitiu.',
	'userrenametool-error-request' => 'Hebo un problema al recibir el pidimientu. Por favor vuelve atrás y inténtalo otra vuelta.',
	'userrenametool-error-same-user' => 'Nun pues renomar un usuariu al mesmu nome que tenía.',
	'userrenametool-success' => 'L\'usuariu "<nowiki>$1</nowiki>" foi renomáu como "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => '¿Realmente quies facer esto?',
	'userrenametool-confirm-yes' => 'Sí',
	'userrenametool-confirm-no' => 'Non',
	'userrenametool-page-exists' => 'La páxina $1 yá esiste y nun pue ser sobreescrita automáticamente.',
	'userrenametool-page-moved' => 'La páxina $1 treslladóse a $2.',
	'userrenametool-page-unmoved' => 'La páxina $1 nun pudo treslladase a $2.',
	'userrenametool-finished-email-subject' => "Ta completu'l procesu de renomar usuariu pa [$1]",
	'userrenametool-finished-email-body-text' => 'Ta completu\'l procesu de treslladar de "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>".',
	'userrenametool-finished-email-body-html' => 'Ta completu\'l procesu de treslladar de "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>".',
	'userrenametool-logpage' => "Rexistru de cambeos de nome d'usuariu",
	'userrenametool-logpagetext' => "Esti ye un rexistru de los cambeos de nomes d'usuariu",
	'userrenametool-logentry' => 'renomó a $1 como "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivu: $2',
	'userrenametool-move-log' => 'Treslladóse la páxina automáticamente al renomar al usuariu "[[User:$1|$1]]" como "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomar usuarios',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'userrenametool-confirm-yes' => 'Bəli',
	'userrenametool-confirm-no' => 'Xeyr',
);

/** Bashkir (башҡортса)
 */
$messages['ba'] = array(
	'userrenametool' => 'Ҡатнашыусының исемен үҙгәртергә',
	'renameuser' => 'Ҡатнашыусының исемен үҙгәртергә',
	'userrenametool-warning' => 'Ҡатнашыусының исемен үҙгәртер алдынан, зинһар, бөтә бирелгән мәғлүмәттең дөрөҫлөгөн тикшерегеҙ һәм ҡатнашыусы был ғәмәлде тамамлау өсөн күпмелер ваҡыт кәрәклеген белеүен тәьмин итегеҙ.
Яҙмаларҙы [[Special:Stafflog|Хеҙмәткәрҙәр яҙмалары журналында]] ҡарағыҙ.',
	'userrenametool-desc' => "Ҡатнашыусының исемен үҙгәртеү (''renameuser'' хоҡуғы талап ителә) һәм бөтә бәйле мәғлүмәтте эшкәртеү өсөн [[Special:UserRenameTool|махсус бит]] өҫтәй",
	'userrenametool-old' => 'Хәҙерге исеме:',
	'userrenametool-new' => 'Яңы исеме:',
	'userrenametool-reason' => 'Исемен үҙгәртеү сәбәбе:',
	'userrenametool-move' => 'Шулай уҡ ҡатнашыусы битенең, фекер алышыу битенең (һәм уларҙың эске биттәренең) исемен үҙгәртергә',
	'userrenametool-reserve' => 'Ҡатнашыусының элекке исемен киләсәктә ҡулланыу өсөн һаҡларға',
	'userrenametool-warnings' => 'Киҫәтеүҙәр:',
	'userrenametool-confirm' => 'Эйе, ҡатнашыусының исемен үҙгәртергә',
	'userrenametool-submit' => 'Ҡатнашыусының исемен үҙгәртергә',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" исемле ҡатнашыусы теркәлмәгән.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" исемле ҡатнашыусы теркәлгән инде.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" исеме дөрөҫ түгел.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" исеме дөрөҫ түгел.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" ҡатнашыусыһы $2 {{PLURAL:$2|өлөш}} индергән, $3 үҙгәртеүҙән күберәк өлөш индергән ҡатнашыусының исемен үҙгәртеү сайттың эшмәкәрлегенә кире йоғонто яһауы мөмкин.',
	'userrenametool-errorprocessing' => '<nowiki>$1</nowiki> ҡатнашыусыһының исемен <nowiki>$2</nowiki> тип үҙгәртеү башҡарыла инде.',
	'userrenametool-errorblocked' => '<nowiki>$1</nowiki> ҡатнашыусыһы <nowiki>$2</nowiki> тарафынан $3 бикләнгән.',
	'userrenametool-errorlocked' => '<nowiki>$1</nowiki> ҡатнашыусыһы бикләнгән.', # Fuzzy
	'userrenametool-errorbot' => '<nowiki>$1</nowiki> ҡатнашыусыһы — бот.',
	'userrenametool-error-request' => 'Һорауҙы алыу менән ҡыйынлыҡтар тыуҙы.
Зинһар, кире ҡайтығыҙ һәм яңынан ҡабатлап ҡарағыҙ.',
	'userrenametool-error-same-user' => 'You cannot rename a user to the same name.',
	'userrenametool-error-extension-abort' => 'Киңәйеү исем үҙгәртеүҙе башҡарыуға юл ҡуйманы.',
	'userrenametool-error-cannot-rename-account' => 'Ҡатнашыусының иҫәп яҙмаһының исемен дөйөм мәғлүмәттәр базаһында үҙгәртеү хата менән тамамланды.',
	'userrenametool-error-cannot-create-block' => 'Танылыуҙы бикләү булдырыу хата менән тамамланды.', # Fuzzy
	'userrenametool-warn-repeat' => 'Иғтибар! "<nowiki>$1</nowiki>" ҡатнашыусыһы "<nowiki>$2</nowiki>" тип үҙгәртелгән инде.
Ҡайһы бер етмәгән мәғлүмәтте яңыртыр өсөн генә дауам итегеҙ.',
	'userrenametool-warn-table-missing' => '"<nowiki>$2</nowiki>" таблицаһы "<nowiki>$1</nowiki>" мәғлүмәттәр базаһында юҡ.',
	'userrenametool-info-started' => '$1 $2 ҡатнашыусыһын $3 тип үҙгәртә башланы (яҙмалар: $4).
Сәбәп: "$5".',
	'userrenametool-info-finished' => '$1 $2 ҡатнашыусыһын $3 тип үҙгәртеүҙе тамамланы (яҙмалар: $4).
Сәбәп: "$5".',
	'userrenametool-info-failed' => '$1 $2 ҡатнашыусыһын $3 тип үҙгәртә алманы (яҙмалар: $4).
Сәбәп: "$5".',
	'userrenametool-info-wiki-finished' => '$1 $4 $2 ҡатнашыусыһын $3 тип үҙгәртте.
Сәбәп: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 $4 $2 ҡатнашыусыһын $3 тип хаталар менән үҙгәртте.
Сәбәп: "$5".',
	'userrenametool-info-in-progress' => 'Исем үҙгәртеү башҡарыла.
Был ғәмәл артҡы планда тамамланасаҡ.
Тамамланғас, һеҙгә электрон почта аша белдереләсәк.',
	'userrenametool-success' => '"$1" ҡатнашыусыһының исеме "$2" тип үҙгәртелде.',
	'userrenametool-confirm-intro' => 'Һеҙ ысынлап та быны эшләргә теләйһегеҙме?',
	'userrenametool-confirm-yes' => 'Эйе',
	'userrenametool-confirm-no' => 'Юҡ',
	'userrenametool-page-exists' => '$1 бите бар инде һәм уның өҫтөнә автоматик рәүештә яҙҙырыу мөмкин түгел.',
	'userrenametool-page-moved' => '$1 битенең исеме $2 тип үҙгәртелде.',
	'userrenametool-page-unmoved' => '$1 битенең исеме $2 тип үҙгәртелә алмай.',
	'userrenametool-finished-email-subject' => 'Ҡатнашыусы исемен үҙгәртеү [$1] өсөн тамамланды',
	'userrenametool-finished-email-body-text' => '"<nowiki>$1</nowiki>" исемен "<nowiki>$2</nowiki>" тип үҙгәртеү тамамланды.',
	'userrenametool-finished-email-body-html' => '"<nowiki>$1</nowiki>" исемен "<nowiki>$2</nowiki>" тип үҙгәртеү тамамланды.',
	'userrenametool-logpage' => 'Ҡатнашыусы исемдәрен үҙгәртеү яҙмалары журналы',
	'userrenametool-logpagetext' => 'Был — ҡатнашыусы исемдәрен үҙгәртеү яҙмалары журналы.',
	'userrenametool-logentry' => '$1 ҡатнашыусыһын "$2" тип үҙгәрткән',
	'userrenametool-log' => '$1 {{PLURAL:$1|үҙгәртеү}}. Сәбәбе: $2',
	'userrenametool-move-log' => 'Биттең исеме "[[User:$1|$1]]" ҡатнашыусыһының исемен "[[User:$2|$2]]" тип үҙгәртеү сәбәпле үҙенән-үҙе үҙгәргән',
	'right-renameuser' => 'Ҡатнашыусыларҙың исемен үҙгәртеү',
);

/** bat-smg (bat-smg)
 * @author Hugo.arg
 */
$messages['bat-smg'] = array(
	'userrenametool-old' => 'Esams nauduotuojė vards:',
	'userrenametool-new' => 'Naus nauduotuojė vards:',
	'userrenametool-success' => 'Nauduotuos "<nowiki>$1</nowiki>" bova parvadėnts i "<nowiki>$2</nowiki>".',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'renameuser' => 'کاربر نامی بدل کن',
	'userrenametool-desc' => "یک کاربر نامی بدیل کن(حق ''بدل نام''لازمن)",
	'userrenametool-old' => 'هنوکین نام کاربری:',
	'userrenametool-new' => 'نوکین نام کاربری:',
	'userrenametool-reason' => 'دلیل په نام بدل کتن:',
	'userrenametool-move' => 'صفحات گپ و کاربر (و آیانی زیر صفحات) په نوکین نام جاه په جاه کن',
	'userrenametool-warnings' => 'هوژاریان:',
	'userrenametool-confirm' => 'بله، کاربر نامی عوض کن',
	'userrenametool-submit' => 'دیم دی',
	'userrenametool-errordoesnotexist' => 'کاربر "<nowiki>$1</nowiki>" موجود نهنت.',
	'userrenametool-errorexists' => 'کاربر "<nowiki>$1</nowiki>" هنو هستن.',
	'userrenametool-errorinvalid' => 'نام کاربری "<nowiki>$1</nowiki>" نامعتبر انت.',
	'userrenametool-error-request' => 'مشکلی گون دریافت درخواست هستت.
لطفا برگردیت و دگه تلاش کنیت.',
	'userrenametool-error-same-user' => 'شما نه تونیت یک کاربر په هما پیشگین چیزی نامی بدل کنیت',
	'userrenametool-success' => 'کاربر "<nowiki>$1</nowiki>" نامی بدل بوتت په "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'صفحه $1 الان هست و اتوماتیکی اور آی نوسیگ نه بیت.',
	'userrenametool-page-moved' => 'صفحه $1 جاه په جاه بیت په $2.',
	'userrenametool-page-unmoved' => 'صفحه $1 نه تونیت په $2 جاه په جاه بیت.',
	'userrenametool-logpage' => 'آمار نام بدل کتن کاربر',
	'userrenametool-logpagetext' => 'شی آماری چه تغییرات نامان کاربران انت',
	'userrenametool-logentry' => 'نام بدل بوت $1 په "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 اصلاح|$1 اصلاحلات}}. دلیل: $2',
	'userrenametool-move-log' => 'اتوماتیکی صفحه جاه په جاه بیت وهدی که کاربر نام بدل بی "[[User:$1|$1]]" به "[[User:$2|$2]]"',
	'right-renameuser' => 'عوض کتن نام کابران',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'userrenametool-submit' => 'Isumitir',
	'userrenametool-errordoesnotexist' => 'An parágamit "<nowiki>$1</nowiki>" mayò man',
	'userrenametool-errorexists' => 'An parágamit "<nowiki>$1</nowiki>" yaon na',
	'userrenametool-page-moved' => 'An páhinang $1 piglipat sa $2.',
	'userrenametool-page-unmoved' => 'An páhinang $1 dai mailipat sa $2.',
	'userrenametool-log' => '$1 mga hirá. Rasón: $2',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 * @author Jim-by
 * @author KorneySan
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'userrenametool' => 'Перайменаваць рахунак удзельніка',
	'renameuser' => 'Перайменаваць рахунак удзельніка',
	'userrenametool-warning' => 'Перш чым пераймяноўваць рахунак, упэўніцеся, што ўся інфармацыя слушная, і паведаміце ўдзельніку, што на на перайменаваньне можа спатрэбіцца некаторы час.
Глядзіце [[Special:Stafflog|журнал супрацоўніка]] для дадатковай інфармацыі.',
	'userrenametool-desc' => "Дадае [[Special:Renameuser|спэцыяльную старонку]] для перайменаваньня рахунку ўдзельніка (неабходныя правы на ''перайменаваньне ўдзельніка'')",
	'userrenametool-old' => 'Цяперашняе імя ўдзельніка:',
	'userrenametool-new' => 'Новае імя:',
	'userrenametool-reason' => 'Прычына перайменаваньня:',
	'userrenametool-move' => 'Перайменаваць старонкі ўдзельніка і размоваў (і іх падстаронкі)',
	'userrenametool-reserve' => 'Заблякаваць старое імя ўдзельніка для выкарыстаньня ў будучыні',
	'userrenametool-notify-renamed' => 'Адправіць электронны ліст ўдзельніку з новым іменем пасьля завяршэньня',
	'userrenametool-warnings' => 'Папярэджаньні:',
	'userrenametool-confirm' => 'Так, перайменаваць удзельніка',
	'userrenametool-submit' => 'Перайменаваць',
	'userrenametool-errordoesnotexist' => 'Рахунак «<nowiki>$1</nowiki>» не існуе.',
	'userrenametool-errorexists' => 'Рахунак «<nowiki>$1</nowiki>» ужо існуе.',
	'userrenametool-errorinvalid' => 'Няслушнае імя ўдзельніка «<nowiki>$1</nowiki>».',
	'userrenametool-errorinvalidnew' => 'Няслушнае новае імя ўдзельніка «<nowiki>$1</nowiki>»',
	'userrenametool-errortoomany' => 'Удзельнік «<nowiki>$1</nowiki>» зрабіў $2 {{PLURAL:$2|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}. Перайменаваньне рахунку ўдзельніка, які зрабіў болей за $3 {{PLURAL:$3|рэдагаваньне|рэдагаваньні|рэдагаваньняў}} можа нэгатыўна паўплываць на працу {{GRAMMAR:родны|{{SITENAME}}}}.',
	'userrenametool-errorprocessing' => 'Працэс перайменаваньня рахунку <nowiki>$1</nowiki> у <nowiki>$2</nowiki> ужо выконваецца.',
	'userrenametool-errorblocked' => 'Удзельнік <nowiki>$1</nowiki> заблякаваны <nowiki>$2</nowiki> на $3.',
	'userrenametool-errorlocked' => 'Удзельнік <nowiki>$1</nowiki> заблякаваны.', # Fuzzy
	'userrenametool-errorbot' => 'Удзельнік <nowiki>$1</nowiki> — робат.',
	'userrenametool-error-request' => 'Узьніклі праблемы з атрыманьнем запыту.
Калі ласка, вярніцеся назад і паспрабуйце ізноў.',
	'userrenametool-error-same-user' => 'Немагчыма перайменаваць рахунак удзельніка ў тое ж самае імя.',
	'userrenametool-error-extension-abort' => 'Пашырэньне прадухіліла перайменаваньне рахунку.',
	'userrenametool-error-cannot-rename-account' => 'Перайменаваньне рахунку ўдзельніка ў агульнай глябальнай базе зьвестак не атрымалася.',
	'userrenametool-error-cannot-create-block' => 'Немагчыма стварыць блякаваньне ўваходу ў сыстэму.', # Fuzzy
	'userrenametool-warn-repeat' => 'Увага! Рахунак удзельніка «<nowiki>$1</nowiki>» ужо быў перайменаваны ў «<nowiki>$2</nowiki>».
Працягвайце апрацоўку толькі ў тым выпадку, калі Вам неабходна абнавіць некаторую інфармацыю, якая адсутнічае.',
	'userrenametool-warn-table-missing' => 'Табліца «<nowiki>$2</nowiki>» не існуе ў базе зьвестак «<nowiki>$1</nowiki>».',
	'userrenametool-info-started' => '$1 пачаў перайменаваньне: $2 у $3 (журналы: $4).
Прычына: «$5».',
	'userrenametool-info-finished' => '$1 завяршыў перайменаваньне: $2 у $3 (журналы: $4).
Прычына: «$5».',
	'userrenametool-info-failed' => '$1 немагчыма перайменаваць: $2 у $3 (журналы: $4).
Прычына: «$5».',
	'userrenametool-info-wiki-finished' => '$1 перайменаваў $2 у $3 ($4).
Прычына: «$5».',
	'userrenametool-info-wiki-finished-problems' => '$1 перайменаваў $2 у $3 ($4) з памылкамі.
Прычына: «$5».',
	'userrenametool-info-in-progress' => 'Адбываецца перайменаваньне.
Астатнія дзеяньні будуць рабіцца ў фонавым рэжыме.
Вы будзеце апавешчаны па электроннай пошце пра яго завяршэньне.',
	'userrenametool-success' => 'Рахунак «<nowiki>$1</nowiki>» быў перайменаваны ў «<nowiki>$2</nowiki>».',
	'userrenametool-confirm-intro' => 'Вы сапраўды жадаеце гэта зрабіць?',
	'userrenametool-confirm-yes' => 'Так',
	'userrenametool-confirm-no' => 'Не',
	'userrenametool-page-exists' => 'Старонка $1 ужо існуе і ня можа быць аўтаматычна перазапісаная.',
	'userrenametool-page-moved' => 'Старонка $1 была перайменаваная ў $2.',
	'userrenametool-page-unmoved' => 'Старонка $1 ня можа быць перайменаваная ў $2.',
	'userrenametool-finished-email-subject' => 'Працэс перайменаваньня рахунку скончаны для [$1]',
	'userrenametool-finished-email-body-text' => 'Працэс пераносу з «<nowiki>$1</nowiki>» у «<nowiki>$2</nowiki>» скончаны.',
	'userrenametool-finished-email-body-html' => 'Працэс пераносу з «<nowiki>$1</nowiki>» у «<nowiki>$2</nowiki>» скончаны.',
	'userrenametool-logpage' => 'Журнал перайменаваньняў удзельнікаў',
	'userrenametool-logpagetext' => 'Гэта журнал перайменаваньняў рахункаў удзельнікаў.',
	'userrenametool-logentry' => 'перайменаваў $1 у «$2»',
	'userrenametool-log' => '$1 {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}. Прычына: $2',
	'userrenametool-move-log' => 'Аўтаматычнае перайменаваньне старонкі ў сувязі зь перайменаваньнем рахунку ўдзельніка з «[[User:$1|$1]]» у «[[User:$2|$2]]»',
	'right-renameuser' => 'перайменаваньне ўдзельнікаў',
);

/** Bulgarian (български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'renameuser' => 'Преименуване на потребител',
	'userrenametool-desc' => 'Добавя възможност за преименуване на потребители',
	'userrenametool-old' => 'Текущо потребителско име:',
	'userrenametool-new' => 'Ново потребителско име:',
	'userrenametool-reason' => 'Причина за преименуването:',
	'userrenametool-move' => 'Преместване под новото име на потребителската лична страница и беседа (както и техните подстраници)',
	'userrenametool-warnings' => 'Предупреждения:',
	'userrenametool-confirm' => 'Да, преименуване на потребителя',
	'userrenametool-submit' => 'Изпълнение',
	'userrenametool-errordoesnotexist' => 'Потребителят „<nowiki>$1</nowiki>“ не съществува.',
	'userrenametool-errorexists' => 'Потребителят „<nowiki>$1</nowiki>“ вече съществува.',
	'userrenametool-errorinvalid' => 'Потребителското име „<nowiki>$1</nowiki>“ е невалидно.',
	'userrenametool-errortoomany' => 'Потребителят „<nowiki>$1</nowiki>“ има $2 {{PLURAL:$2|принос|приноса}}. Преименуването на потребители с повече от $3 {{PLURAL:$2|принос|приноса}}, може да се отрази зле върху производителността на сайта.',
	'userrenametool-error-request' => 'Имаше проблем с приемането на заявката. Върнете се на предишната страница и опитайте отново!',
	'userrenametool-error-same-user' => 'Новото потребителско име е същото като старото.',
	'userrenametool-success' => 'Потребителят „<nowiki>$1</nowiki>“ беше преименуван на „<nowiki>$2</nowiki>“',
	'userrenametool-confirm-yes' => 'Да',
	'userrenametool-confirm-no' => 'Не',
	'userrenametool-page-exists' => 'Страницата $1 вече съществува и не може да бъде автоматично заместена.',
	'userrenametool-page-moved' => 'Страницата $1 беше преместена като $2.',
	'userrenametool-page-unmoved' => 'Страницата $1 не можа да бъде преместена като $2.',
	'userrenametool-logpage' => 'Дневник на преименуванията',
	'userrenametool-logpagetext' => 'В този дневник се записват преименуванията на потребители.',
	'userrenametool-logentry' => 'преименува $1 на „$2“',
	'userrenametool-log' => '{{PLURAL:$1|една редакция|$1 редакции}}. Причина: $2',
	'userrenametool-move-log' => 'Автоматично преместена страница при преименуването на потребител "[[User:$1|$1]]" като "[[User:$2|$2]]"',
	'right-renameuser' => 'преименуване на потребители',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'renameuser' => 'ব্যবহারকারী নামান্তর করো',
	'userrenametool-desc' => "একজন ব্যবহারকারীকে নামান্তর করুন (''ব্যবহাকারী নামান্তর'' অধিকার প্রয়োজন)",
	'userrenametool-old' => 'বর্তমান ব্যবহারকারী নাম:',
	'userrenametool-new' => 'নতুন ব্যবহারকারী নাম:',
	'userrenametool-reason' => 'নামান্তরের কারণ:',
	'userrenametool-move' => 'ব্যবহারকারী এবং আলাপের পাতা (এবং তার উপপাতাসমূহ) নতুন নামে সরিয়ে নাও',
	'userrenametool-warnings' => 'সতর্কীকরণ:',
	'userrenametool-confirm' => 'হ্যা, ব্যবহারকারীর নাম পরিবর্তন করো',
	'userrenametool-submit' => 'জমা দিন',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" নামের কোন ব্যবহারকারী নাই।',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" ব্যবহারকারী ইতিমধ্যে বিদ্যমান আছে।',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" ব্যবহারকারী নামটি ঠিক নয়।',
	'userrenametool-error-request' => 'এই অনুরোধ গ্রহণে সমস্যা ছিল। দয়াকরে পেছনে যান এবং আবার চেষ্টা করুন।',
	'userrenametool-error-same-user' => 'আপনি পূর্বের নামে নামান্তর করতে পারবেন না।',
	'userrenametool-success' => 'ব্যবহারকারী "<nowiki>$1</nowiki>" থেকে "<nowiki>$2</nowiki>" তে নামান্তরিত করা হয়েছে।',
	'userrenametool-page-exists' => 'পাতা $1 বিদ্যমান এবং সয়ঙ্ক্রিয়ভাবে এটির উপর লেখা যাবে না',
	'userrenametool-page-moved' => 'পাতাটি $1 থেকে $2 তে সরিয়ে নেওয়া হয়েছে।',
	'userrenametool-page-unmoved' => 'পাতাটি $1 থেকে $2 তে সরিয়ে নেওয়া যাবে না।',
	'userrenametool-logpage' => 'ব্যবহারকারী নামান্তরের লগ',
	'userrenametool-logpagetext' => 'এটি ব্যাবহারকারী নামের পরিবর্তনের লগ',
	'userrenametool-logentry' => '$1 থেকে "$2" তে নামান্তর করা হয়েছে',
	'userrenametool-log' => '{{PLURAL:$1|1 সম্পাদনা|$1 সম্পাদনাসমূহ}}। কারণ: $2',
	'userrenametool-move-log' => 'যখন ব্যবহারকারী "[[User:$1|$1]]" থেকে "[[User:$2|$2]]" তে নামান্তরিত হবে তখন সয়ঙ্ক্রিয়ভাবে পাতা সরিয়ে নেওয়া হয়েছে',
	'right-renameuser' => 'ব্যবহারকারীদের পুনরায় নাম দাও',
);

/** Tibetan (བོད་ཡིག)
 * @author Freeyak
 */
$messages['bo'] = array(
	'userrenametool' => 'སྤྱོད་མིའི་མིང་བརྗེ་བ།',
	'renameuser' => 'སྤྱོད་མིང་བསྐྱར་འདོགས།',
	'userrenametool-old' => 'ད་ཡོད་སྤྱོད་མིང་།',
	'userrenametool-new' => 'སྤྱོད་མིའི་མིང་གསར་བ།',
	'userrenametool-reason' => 'སྤྱོད་མིང་བརྗེ་བའི་རྒྱུ་མཚན།',
	'userrenametool-warnings' => 'ཉེན་བརྡ།',
	'userrenametool-confirm' => 'ལགས་སོ། སྤྱོད་མིང་བསྐྱར་འདོགས་བྱོས།',
	'userrenametool-confirm-intro' => 'འདི་བྱེད་པ་སེམས་ཐག་ཡིན་ནམ།',
	'userrenametool-confirm-yes' => 'ཡིན།',
	'userrenametool-confirm-no' => 'མིན།',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'userrenametool' => 'Kemmañ anv un implijer',
	'renameuser' => 'Adenvel an implijer',
	'userrenametool-desc' => "Adenvel un implijer (ret eo kaout ''gwirioù adenvel'')",
	'userrenametool-old' => 'Anv a-vremañ an implijer :',
	'userrenametool-new' => 'Anv implijer nevez :',
	'userrenametool-reason' => 'Abeg evit adenvel :',
	'userrenametool-move' => 'Kas ar pajennoù implijer ha kaozeal (hag o ispajennoù) betek o anv nevez',
	'userrenametool-warnings' => 'Diwallit :',
	'userrenametool-confirm' => 'Ya, adenvel an implijer',
	'userrenametool-submit' => 'Adenvel',
	'userrenametool-errordoesnotexist' => 'An implijer "<nowiki>$1</nowiki>" n\'eus ket anezhañ',
	'userrenametool-errorexists' => 'Krouet eo bet an anv implijer "<nowiki>$1</nowiki>" dija',
	'userrenametool-errorinvalid' => 'Faziek eo an anv implijer "<nowiki>$1</nowiki>"',
	'userrenametool-errorinvalidnew' => "N'eo ket ''<nowiki>$1</nowiki>'' un anv implijer reizh.",
	'userrenametool-errortoomany' => 'Deuet ez eus $2 degasadenn gant an implijer "<nowiki>$1</nowiki>"; adenvel un implijer degaset gantañ ouzhpenn $3 degasadenn a c\'hall noazout ouzh startijenn mont en-dro al lec\'hienn a-bezh',
	'userrenametool-errorblocked' => 'Stanket eo an implijer <nowiki>$1</nowiki> gant <nowiki>$2</nowiki> evit $3.',
	'userrenametool-errorlocked' => 'Stanket eo an implijer <nowiki>$1</nowiki>.',
	'userrenametool-errorbot' => 'Ur bot eo an implijer <nowiki>$1</nowiki>.',
	'userrenametool-error-request' => 'Ur gudenn zo bet gant degemer ar reked. Kit war-gil ha klaskit en-dro.',
	'userrenametool-error-same-user' => "N'haller ket adenvel un implijer gant an hevelep anv hag a-raok.",
	'userrenametool-info-started' => 'Kroget en deus $1 da adenvel : $2 e $3 (marilh : $4).
Abeg : "$5".',
	'userrenametool-info-finished' => 'Echuet en deus $1 da adenvel : $2 e $3 (marilh : $4).
Abeg : "$5".',
	'userrenametool-info-failed' => 'C\'HWITET en deus $1 an adenvel : $2 e $3 (marilh : $4).
Abeg : "$5".',
	'userrenametool-info-wiki-finished' => '$1 en deus adanvet $2 e $3 war $4.
Abeg : "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 en deus adanvet $2 e $3 war $4 gant FAZIOÙ.
Abeg : "$5".',
	'userrenametool-success' => 'Deuet eo an implijer "<nowiki>$1</nowiki>" da vezañ "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => "Ha sur oc'h ho peus c'hoant ober kement-mañ ?",
	'userrenametool-confirm-yes' => 'Ya',
	'userrenametool-confirm-no' => 'Ket',
	'userrenametool-page-exists' => "Bez' ez eus eus ar bajenn $1 dija, n'haller ket hec'h erlec'hiañ ent emgefreek.",
	'userrenametool-page-moved' => 'Adkaset eo bet ar bajenn $1 da $2.',
	'userrenametool-page-unmoved' => "N'eus ket bet gallet adkas ar bajenn $1 da $2.",
	'userrenametool-finished-email-subject' => 'Argerzh adenvel an implijer echuet evit [$1]',
	'userrenametool-logpage' => 'Roll an implijerien bet adanvet',
	'userrenametool-logpagetext' => 'Setu istor an implijerien bet cheñchet o anv ganto',
	'userrenametool-logentry' => 'en deus adanvet $1 e "$2"',
	'userrenametool-log' => 'Ssavet gantañ $1 degasadenn. $2',
	'userrenametool-move-log' => 'Pajenn dilec\'hiet ent emgefreek e-ser adenvel an implijer "[[User:$1|$1]]" e "[[User:$2|$2]]"',
	'right-renameuser' => 'Adenvel implijerien',
);

/** Bosnian (bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'renameuser' => 'Preimenuj korisnika',
	'userrenametool-desc' => "Dodaje [[Special:Renameuser|posebnu stranicu]] u svrhu promjene imena korisnika (zahtjeva pravo ''preimenovanja korisnika'')",
	'userrenametool-old' => 'Trenutno ime korisnika:',
	'userrenametool-new' => 'Novo korisničko ime:',
	'userrenametool-reason' => 'Razlog promjene imena:',
	'userrenametool-move' => 'Premještanje korisnika i njegove stranice za razgovor (zajedno sa podstranicama) na novo ime',
	'userrenametool-reserve' => 'Blokiraj staro korisničko ime od kasnijeg korištenja',
	'userrenametool-warnings' => 'Upozorenja:',
	'userrenametool-confirm' => 'Da, promijeni ime korisnika',
	'userrenametool-submit' => 'Pošalji',
	'userrenametool-errordoesnotexist' => 'Korisnik "<nowiki>$1</nowiki>" ne postoji.',
	'userrenametool-errorexists' => 'Korisnik "<nowiki>$1</nowiki>" već postoji.',
	'userrenametool-errorinvalid' => 'Korisničko ime "<nowiki>$1</nowiki>" nije valjano.',
	'userrenametool-errortoomany' => 'Korisnik "<nowiki>$1</nowiki>" ima $2 {{PLURAL:$2|izmjenu|izmjene|izmjena}}, promjena imena korisnika sa više od $3 {{PLURAL:$3|izmjene|izmjena}} može ugroziti performanse stranica.',
	'userrenametool-error-request' => 'Nastao je problem pri prijemu zahtjeva.
Molimo Vas da se vratite nazad i pokušate ponovo.',
	'userrenametool-error-same-user' => 'Ne može se promijeniti ime korisnika u isto kao i ranije.',
	'userrenametool-success' => 'Ime korisnika "<nowiki>$1</nowiki>" je promijenjeno u "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Stranica $1 već postoji i ne može biti automatski prepisana.',
	'userrenametool-page-moved' => 'Stranica $1 je premještena na $2.',
	'userrenametool-page-unmoved' => 'Stranica $1 nije mogla biti premještena na $2.',
	'userrenametool-logpage' => 'Zapisnik preimenovanja korisnika',
	'userrenametool-logpagetext' => 'Ovo je zapisnik promjena korisničkih imena.',
	'userrenametool-logentry' => '$1 preimenovan u "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 izmjena|$1 izmjene|$1 izmjena}}. Razlog: $2',
	'userrenametool-move-log' => 'Automatski premještena stranica pri promjeni korisničkog imena "[[User:$1|$1]]" u "[[User:$2|$2]]"',
	'right-renameuser' => 'Preimenovanje korisnika',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Juanpabl
 * @author Light of Cosmos
 * @author Marcmpujol
 * @author Paucabot
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'userrenametool' => "Canviar el nom d'un usuari",
	'renameuser' => "Reanomena l'usuari",
	'userrenametool-warning' => "Abans de reanomenar a un usuari, si us plau, assegura't de que tota la informació és correcta, i garanteix que l'usuari coneix que pot portar algun temps per completar-se. Pots veure el registre en el [[Special:Stafflog|registre del Personal]].",
	'userrenametool-desc' => "Reanomena un usuari (necessita drets de ''renameuser'')",
	'userrenametool-old' => "Nom d'usuari actual:",
	'userrenametool-new' => "Nou nom d'usuari:",
	'userrenametool-encoded' => 'URL codificat:',
	'userrenametool-reason' => 'Motiu pel canvi:',
	'userrenametool-move' => "Reanomena la pàgina d'usuari, la de discussió i les subpàgines que tingui al nou nom",
	'userrenametool-reserve' => "Bloca el nom d'usuari antic d'usos futurs",
	'userrenametool-notify-renamed' => "Enviar un correu electrònic a l'usuari reanomenat al finalitzar",
	'userrenametool-warnings' => 'Advertències:',
	'userrenametool-requested-rename' => "L'usuari $1 va sol·licitar un renom del compte",
	'userrenametool-did-not-request-rename' => "L'usuario $1 no va sol·licitar un renom del compte",
	'userrenametool-previously-renamed' => "L'usuari $1 ja té un renom del compte",
	'userrenametool-phalanx-matches' => 'Coincidències en filtres de Phalanx: $1',
	'userrenametool-confirm' => "Sí, reanomena l'usuari",
	'userrenametool-submit' => 'Tramet',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof no instal·lat.',
	'userrenametool-errordoesnotexist' => "L'usuari «<nowiki>$1</nowiki>» no existeix",
	'userrenametool-errorexists' => "L'usuari «<nowiki>$1</nowiki>» ja existeix",
	'userrenametool-errorinvalid' => "El nom d'usuari «<nowiki>$1</nowiki>» no és vàlid",
	'userrenametool-errorinvalidnew' => "''<nowiki>$1</nowiki>'' no és un nom d'usuari vàlid.",
	'userrenametool-errortoomany' => "L'usuari «<nowiki>$1</nowiki>» té $2 {{PLURAL:$2|contribució|contribucions}}. Canviar el nom a un usuari amb més de $3 {{PLURAL:$3|contribució|contribucions}} pot causar problemes.",
	'userrenametool-errorprocessing' => "El procés de canviar el nom de l'usuari <nowiki>$1</nowiki> a <nowiki>$2</nowiki> està en procés.",
	'userrenametool-errorblocked' => "L'usuari <nowiki>$1</nowiki> està bloquejat per <nowiki>$2</nowiki> per $3.",
	'userrenametool-errorlocked' => "L'usuari <nowiki>$1</nowiki> està bloquejat.",
	'userrenametool-errorbot' => "L'usuari <nowiki>$1</nowiki> és un bot.",
	'userrenametool-error-request' => "Hi ha hagut un problema en la recepció de l'ordre.
Torneu enrere i torneu-ho a intentar.",
	'userrenametool-error-same-user' => 'No podeu reanomenar un usuari a un nom que ja tenia anteriorment.',
	'userrenametool-error-extension-abort' => 'Una extensió va impedir el procés de canvi de nom.',
	'userrenametool-error-cannot-rename-account' => "El canvi de nom d'usuari en la base de dades global compartida ha fallat.",
	'userrenametool-error-cannot-create-block' => "La creació d'un filtre de bloqueig en Phalanx ha fallat.",
	'userrenametool-error-cannot-rename-unexpected' => "S'ha produït un error inesperat, comprova els registres o prova un altre cop.",
	'userrenametool-warnings-characters' => "El nom nou d'usuari conté caràcters il·legals!",
	'userrenametool-warnings-maxlength' => "El nou nom d'usuari no pot sobrepassar els 255 caràcters!",
	'userrenametool-warn-repeat' => 'Atenció! L\'usuari "<nowiki>$1</nowiki>" ja ha sigut reanomenat a "<nowiki>$2</nowiki>".
Continua amb el procés sol si necessites actualitzar alguna informació que falta.',
	'userrenametool-warn-table-missing' => 'La taula "<nowiki>$2</nowiki>" no existeix en la base de dades "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 va començar a reanomenar: $2 a $3 (registres: $4).
Motiu: "$5".',
	'userrenametool-info-finished' => '$1 ha completat el renom: $2 a $3 (registres: $4).
Motiu: "$5".',
	'userrenametool-info-failed' => '$1 HA FALLAT el renom: $2 a $3 (registres: $4).
Motiu: "$5".',
	'userrenametool-info-wiki-finished' => '$1 ha reanomenat $2 a $3 en $4.
Motiu: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 ha reanomenat $2 a $3 en $4 amb errors.
Motiu: "$5".',
	'userrenametool-info-in-progress' => "El procés de reanomenament està en progrés.
La resta es farà en segon pla.
Seràs notificat per correu electrònic quan s'hagi completat.",
	'userrenametool-success' => "L'usuari «<nowiki>$1</nowiki>» s'ha reanomenat com a «<nowiki>$2</nowiki>»",
	'userrenametool-confirm-intro' => 'Realment vols fer això?',
	'userrenametool-confirm-yes' => 'Si',
	'userrenametool-confirm-no' => 'No',
	'userrenametool-page-exists' => 'La pàgina «$1» ja existeix i no pot ser sobreescrita automàticament',
	'userrenametool-page-moved' => "La pàgina «$1» s'ha reanomenat com a «$2».",
	'userrenametool-page-unmoved' => "La pàgina $1 no s'ha pogut reanomenar com a «$2».",
	'userrenametool-finished-email-subject' => "Procés de reanomenament d'usuari completat per [$1]",
	'userrenametool-finished-email-body-text' => 'El procés de reanomenament de "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" ha estat completat.',
	'userrenametool-finished-email-body-html' => 'El procés de reanomenament de "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" ha estat completat.',
	'userrenametool-logpage' => "Registre del canvi de nom d'usuari",
	'userrenametool-logpagetext' => "Aquest és un registre dels canvis als noms d'usuari",
	'userrenametool-logentry' => 'ha reanomenat $1 a "$2"',
	'userrenametool-log' => '{{PLURAL:$1|Una contribució|$1 contribucions}}. Motiu: $2',
	'userrenametool-move-log' => "S'ha reanomenat automàticament la pàgina mentre es reanomenava l'usuari «[[User:$1|$1]]» com «[[User:$2|$2]]»",
	'right-renameuser' => 'Reanomenar usuaris',
	'action-renameuser' => 'reanomenar usuaris',
);

/** Chechen (нохчийн)
 * @author Sasan700
 * @author Умар
 */
$messages['ce'] = array(
	'renameuser' => 'Декъашхочун цӀе хийца',
	'userrenametool-submit' => 'Кхочушдé',
	'userrenametool-page-exists' => 'Агӏо $1 йолуш ю цундела и ша юху дӏаязъян йиш яц.',
	'userrenametool-move-log' => 'Автоматически декъашхочун цӀе хийцина дела «[[User:$1|$1]]» оцу «[[User:$2|$2]]»',
);

/** Sorani Kurdish (کوردی)
 * @author Calak
 */
$messages['ckb'] = array(
	'userrenametool-logpage' => 'لۆگی گۆڕینی ناوی بەکارھێنەر',
	'right-renameuser' => 'گۆڕینی ناوی بەکارھێنەران',
);

/** Crimean Turkish (Cyrillic script) (къырымтатарджа (Кирилл)‎)
 * @author Alessandro
 */
$messages['crh-cyrl'] = array(
	'userrenametool-logpage' => 'Къулланыджы ады денъишиклиги журналы',
	'userrenametool-logpagetext' => 'Ашагъыда булунгъан джедвель ады денъиштирильген къулланыджыларны косьтере',
	'userrenametool-logentry' => '$1 къулланыджысынынъ адыны "$2" оларакъ денъиштирди',
	'userrenametool-log' => '{{PLURAL:$1|1 денъишиклик|$1 денъишиклик}} япкъан. Себеп: $2',
);

/** Crimean Turkish (Latin script) (qırımtatarca (Latin)‎)
 * @author Alessandro
 */
$messages['crh-latn'] = array(
	'userrenametool-logpage' => 'Qullanıcı adı deñişikligi jurnalı',
	'userrenametool-logpagetext' => 'Aşağıda bulunğan cedvel adı deñiştirilgen qullanıcılarnı köstere',
	'userrenametool-logentry' => '$1 qullanıcısınıñ adını "$2" оlaraq deñiştirdi',
	'userrenametool-log' => '{{PLURAL:$1|1 deñişiklik|$1 deñişiklik}} yapqan. Sebep: $2',
);

/** Czech (česky)
 * @author Chmee2
 * @author Danny B.
 * @author Darth Daron
 * @author Dontlietome7
 * @author Li-sung
 * @author Martin Kozák
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'userrenametool' => 'Změnit uživatelské jméno',
	'renameuser' => 'Přejmenovat uživatele',
	'userrenametool-warning' => 'Před přejmenováním uživatele se prosím ujistěte, že všechny údaje jsou správné, a zajistěte, že uživatel ví, že akce může určitou dobu trvat.
Protokoly viz [[Special:Stafflog]].',
	'userrenametool-desc' => "Přejmenování uživatele (vyžadováno oprávnění ''renameuser'')",
	'userrenametool-old' => 'Stávající uživatelské jméno:',
	'userrenametool-new' => 'Nové uživatelské jméno:',
	'userrenametool-reason' => 'Důvod přejmenování:',
	'userrenametool-move' => 'Přesunout uživatelské a diskusní stránky (a jejich podstránky) na nové jméno',
	'userrenametool-reserve' => 'Zabránit nové registraci původního uživatelského jména',
	'userrenametool-notify-renamed' => 'Poslat přejmenovanému uživateli email až bude hotovo',
	'userrenametool-warnings' => 'Upozornění:',
	'userrenametool-requested-rename' => 'Uživatel $1 požádal o přejmenování',
	'userrenametool-did-not-request-rename' => 'Uživatel $1 nepožádal o přejmenování',
	'userrenametool-previously-renamed' => 'Uživatel $1 již byl přejmenován',
	'userrenametool-phalanx-matches' => 'Phalanx filtry odpovídající $1:',
	'userrenametool-confirm' => 'Ano, přejmenovat uživatele',
	'userrenametool-submit' => 'Přejmenovat',
	'userrenametool-errordoesnotexist' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ neexistuje',
	'userrenametool-errorexists' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ již existuje',
	'userrenametool-errorinvalid' => 'Uživatelské jméno „<nowiki>$1</nowiki>“ nelze použít',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" není platné nové uživatelské jméno.',
	'userrenametool-errortoomany' => 'Uživatel „<nowiki>$1</nowiki>“ má $2 {{PLURAL:$2|příspěvek|příspěvky|příspěvků}}, přejmenování uživatele s více než $3 {{PLURAL:$3|příspěvkem|příspěvky|příspěvky}} by příliš zatěžovalo systém.',
	'userrenametool-errorprocessing' => 'Proces přejmenování uživatele <nowiki>$1</nowiki> na <nowiki>$2</nowiki> již probíhá.',
	'userrenametool-errorblocked' => 'Uživatel <nowiki>$1</nowiki> je zablokován uživatelem <nowiki>$2</nowiki> za $3.',
	'userrenametool-errorlocked' => 'Uživatel <nowiki>$1</nowiki> je zablokovaný.',
	'userrenametool-errorbot' => 'Uživatel <nowiki>$1</nowiki> je bot.',
	'userrenametool-error-request' => 'Při přijímání požadavku došlo k chybě. Vraťte se a zkuste to znovu.',
	'userrenametool-error-same-user' => 'Nové uživatelské jméno je stejné jako dosavadní.',
	'userrenametool-error-extension-abort' => 'Rozšíření brání procesu přejmenování.',
	'userrenametool-error-cannot-rename-account' => 'Přejmenování uživatelského účtu na sdílené globální databázi se nezdařilo.',
	'userrenametool-error-cannot-create-block' => 'Vytvoření Phalanx blokace se nezdařilo.',
	'userrenametool-warn-repeat' => 'Pozor! Uživatel "<nowiki>$1</nowiki>" již byl přejmenován na "<nowiki>$2</nowiki>".
Pokračujte, pouze pokud potřebujete doplnit chybějící informace.',
	'userrenametool-warn-table-missing' => 'Tabulka "<nowiki>$2</nowiki>" neexistuje v databázi "<nowiki>$1</nowiki>".',
	'userrenametool-info-started' => '$1 začal přejmenovávat: $2 na $3 (protokoly: $4).
Důvod: "$5".',
	'userrenametool-info-finished' => '$1 dokončil přejmenování: $2 na 3 $3 (protokoly: $4).
Důvod: "$5".',
	'userrenametool-info-failed' => '$1 přejmenování SELHALO: $2 na $3 (protokoly: $4).
Důvod: "$5".',
	'userrenametool-info-wiki-finished' => '$1 přejmenoval $2 na $3 na $4.
Důvod: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 přejmenoval $2 na $3 na $4 s chybami.
Důvod: "$5".',
	'userrenametool-info-in-progress' => 'Proces přejmenování probíhá.
Zbytek bude proveden na pozadí.
O dokončení budete informován(a) e-mailem.',
	'userrenametool-success' => 'Uživatel „<nowiki>$1</nowiki>“ byl úspěšně přejmenován na „<nowiki>$2</nowiki>“',
	'userrenametool-confirm-intro' => 'Opravdu to chcete udělat?',
	'userrenametool-confirm-yes' => 'Ano',
	'userrenametool-confirm-no' => 'Ne',
	'userrenametool-page-exists' => 'Stránka $1 již existuje a nelze ji automaticky přepsat.',
	'userrenametool-page-moved' => 'Stránka $1 byla přesunuta na $2.',
	'userrenametool-page-unmoved' => 'Stránku $1 se nepodařilo přesunout na $2.',
	'userrenametool-finished-email-subject' => 'Proces přejmenování uživatele byl dokončen pro [$1]',
	'userrenametool-finished-email-body-text' => 'Proces přesunutí "<nowiki>$1</nowiki>" na "<nowiki>$2</nowiki>" byl dokončen.',
	'userrenametool-finished-email-body-html' => 'Proces přesunutí "<nowiki>$1</nowiki>" na "<nowiki>$2</nowiki>" byl dokončen.',
	'userrenametool-logpage' => 'Kniha přejmenování uživatelů',
	'userrenametool-logpagetext' => 'Toto je záznam přejmenování uživatelů (změn uživatelského jména).',
	'userrenametool-logentry' => '$1 přejmenován na "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 editace|$1 editace|$1 editací}}. Zdůvodnění: $2',
	'userrenametool-move-log' => 'Automatický přesun při přejmenování uživatele „[[User:$1|$1]]“ na „[[User:$2|$2]]“',
	'right-renameuser' => 'Přejmenovávání uživatelů',
);

/** Church Slavic (словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author Svetko
 * @author ОйЛ
 */
$messages['cu'] = array(
	'renameuser' => 'прѣимєноуи по́льꙃєватєл҄ь',
	'userrenametool-old' => 'Нынѣщьнѥѥ имѧ:',
	'userrenametool-new' => 'Ново имѧ:',
	'userrenametool-reason' => 'Какъ съмыслъ:',
	'userrenametool-move' => 'Нарьци тако польѕевател страницѫ, бесѣдѫ и ихъ подъстраницѧ',
	'userrenametool-submit' => 'Еи',
	'userrenametool-errordoesnotexist' => 'Польѕевател «<nowiki>$1</nowiki>» нѣстъ',
	'userrenametool-errorexists' => 'Польѕевател҄ь «<nowiki>$1</nowiki>» ѥстъ ю',
	'userrenametool-errorinvalid' => 'Имѧ «<nowiki>$1</nowiki>» нѣстъ годѣ',
	'userrenametool-errortoomany' => 'Польѕевател҄ь «<nowiki>$1</nowiki>» $2 {{PLURAL:$2|исправлѥниѥ|исправлѥнии|исправлѥни|исправлѥнии}} сътворилъ ѥстъ. Аще польѕевател прѣименѹѥши кыи болѥ $3 {{PLURAL:$3|исправлѥниѥ|исправлѥнии|исправлѥни|исправлѥнии}} сътворилъ ѥстъ, то зълѣ бѫдетъ.',
	'userrenametool-logpage' => 'по́льꙃєватєлъ прѣимєнова́ниꙗ їсторі́ꙗ',
	'userrenametool-logentry' => 'нарече $1 именьмь "$2"',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'renameuser' => 'Ail-enwi defnyddiwr',
	'userrenametool-desc' => "Yn ychwanegu [[Special:UserRenameTool|tudalen arbennig]] er mwyn gallu ail-enwi cyfrif defnyddiwr (sydd angen y gallu ''renameuser'') a phrosesu'r data cysylltiedig",
	'userrenametool-old' => 'Enw defnyddiwr presennol:',
	'userrenametool-new' => 'Enw defnyddiwr newydd:',
	'userrenametool-reason' => 'Y rheswm dros ail-enwi:',
	'userrenametool-move' => "Symud y tudalennau defnyddiwr a sgwrs (ac unrhyw is-dudalennau) i'r enw newydd",
	'userrenametool-reserve' => 'Atal yr hen enw defnyddiwr rhag cael ei ddefnyddio rhagor',
	'userrenametool-warnings' => 'Rhybuddion:',
	'userrenametool-confirm' => "Parhau gyda'r ail-enwi",
	'userrenametool-submit' => 'Anfon',
	'userrenametool-errordoesnotexist' => 'Nid yw\'r defnyddiwr "<nowiki>$1</nowiki>" yn bodoli.',
	'userrenametool-errorexists' => 'Mae\'r defnyddiwr "<nowiki>$1</nowiki>" eisoes yn bodoli.',
	'userrenametool-errorinvalid' => 'Mae\'r enw defnyddiwr "<nowiki>$1</nowiki>" yn annilys',
	'userrenametool-errortoomany' => 'Mae gan y defnyddiwr "<nowiki>$1</nowiki>" $2 {{PLURAL:$2|cyfraniad|cyfraniad|gyfraniad|chyfraniad|chyfraniad|o gyfraniadau}}; gall ail-enwi defnyddiwr gyda mwy na(g) $3 {{PLURAL:$3|o gyfraniadau}} ddirywio perfformiad y safle.',
	'userrenametool-error-request' => 'Cafwyd trafferth yn derbyn y cais.
Ewch yn ôl a cheisio eto, os gwelwch yn dda.',
	'userrenametool-error-same-user' => "Ni ellir ail-enwi defnyddiwr gyda'r un enw ag o'r blaen.",
	'userrenametool-success' => 'Mae\'r defnyddiwr "<nowiki>$1</nowiki>" wedi cael ei ail-enwi i "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'Ydy chi wir am wneud hyn?',
	'userrenametool-confirm-yes' => 'Ydw',
	'userrenametool-confirm-no' => 'Nacydw',
	'userrenametool-page-exists' => "Mae'r dudalen $1 ar gael yn barod ac ni ellir ei throsysgrifo.",
	'userrenametool-page-moved' => 'Symudwyd $1 i $2.',
	'userrenametool-page-unmoved' => 'Ni lwyddwyd i symud y dudalen $1 i $2.',
	'userrenametool-logpage' => 'Lòg ail-enwi defnyddwyr',
	'userrenametool-logpagetext' => "Dyma lòg o'r holl newidiadau i enwau defnyddwyr.",
	'userrenametool-logentry' => 'wedi ail-enwi $1 yn "$2"',
	'userrenametool-log' => '$1 {{PLURAL:$1|golygiad|golygiad|olygiad|golygiad|golygiad|o olygiadau}}. Rheswm: $2',
	'userrenametool-move-log' => 'Wedi symud y dudalen yn awtomatig wrth ail-enwi\'r defnyddiwr "[[User:$1|$1]]" i "[[User:$2|$2]]"',
	'right-renameuser' => 'Ail-enwi defnyddwyr',
);

/** Danish (dansk)
 */
$messages['da'] = array(
	'renameuser' => 'Omdøb bruger',
	'right-renameuser' => 'Omdøbe brugere',
);

/** German (Deutsch)
 * @author Avatar
 * @author Geitost
 * @author Inkowik
 * @author Kghbln
 * @author LWChris
 * @author Lyzzy
 * @author Metalhead64
 * @author PtM
 * @author Raimond Spekking
 * @author Spacebirdy
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'userrenametool' => 'Umbenennen',
	'renameuser' => 'Benutzer umbenennen',
	'userrenametool-warning' => 'Stelle bitte vor der Umbenennung eines Benutzers sicher, dass alle Informationen korrekt sind, und dass der Benutzer weiß, dass es bis zur Fertigstellung einige Zeit dauern kann.
Siehe [[Special:Stafflog|Mitarbeiterlog]] für Logs.',
	'userrenametool-desc' => "Ergänzt eine [[Special:Renameuser|Spezialseite]] zur Umbenennung eines Benutzers (erfordert das ''renameuser''-Recht)",
	'userrenametool-old' => 'Bisheriger Benutzername:',
	'userrenametool-new' => 'Neuer Benutzername:',
	'userrenametool-encoded' => 'URL-kodiert:',
	'userrenametool-reason' => 'Grund:',
	'userrenametool-move' => 'Benutzer-/Diskussionsseite (inkl. Unterseiten) auf den neuen Benutzernamen verschieben',
	'userrenametool-reserve' => 'Alten Benutzernamen für eine Neuregistrierung blockieren',
	'userrenametool-notify-renamed' => 'Sende umbenannten Benutzer nach Fertigstellung eine E-Mail',
	'userrenametool-warnings' => 'Warnungen:',
	'userrenametool-requested-rename' => 'Benutzer $1 hat eine Umbenennung beantragt',
	'userrenametool-did-not-request-rename' => 'Benutzer $1 hat keine Umbenennung beantragt',
	'userrenametool-previously-renamed' => 'Benutzer $1 wurde bereits einmal umbenannt',
	'userrenametool-phalanx-matches' => '$1 zuzuordnende Phalanx-Filter:',
	'userrenametool-confirm' => 'Ja, Benutzer umbenennen',
	'userrenametool-submit' => 'Umbenennen',
	'userrenametool-error-antispoof-conflict' => 'AntiSpoof-Warnung – Es gibt bereits einen Benutzernamen, der ähnlich ist wie „<nowiki>$1</nowiki>“.',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof ist nicht installiert.',
	'userrenametool-errordoesnotexist' => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert nicht.',
	'userrenametool-errorexists' => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert bereits.',
	'userrenametool-errorinvalid' => 'Der Benutzername „<nowiki>$1</nowiki>“ ist ungültig.',
	'userrenametool-errorinvalidnew' => 'Der Benutzername „<nowiki>$1</nowiki>“ ist ungültig.',
	'userrenametool-errortoomany' => 'Der Benutzer „<nowiki>$1</nowiki>“ hat $2 {{PLURAL:$2|Bearbeitung|Bearbeitungen}}. Die Namensänderung eines Benutzers mit mehr als $3 {{PLURAL:$3|Bearbeitung|Bearbeitungen}} kann die Serverleistung nachteilig beeinflussen.',
	'userrenametool-errorprocessing' => 'Der umbenennungs-Prozess für Benutzer <nowiki>$1</nowiki> bis <nowiki>$2</nowiki> ist bereits im Gange.',
	'userrenametool-errorblocked' => 'Benutzer <nowiki>$1</nowiki> wird von <nowiki>$2</nowiki> für $3 blockiert.',
	'userrenametool-errorlocked' => 'Benutzer <nowiki>$1</nowiki> ist gesperrt.',
	'userrenametool-errorbot' => 'Benutzer <nowiki>$1</nowiki> ist ein Bot.',
	'userrenametool-error-request' => 'Es gab ein Problem beim Empfang der Anfrage. Bitte nochmal versuchen.',
	'userrenametool-error-same-user' => 'Alter und neuer Benutzername sind identisch.',
	'userrenametool-error-extension-abort' => 'Eine Erweiterung verhinderte den Umbenennungsprozess.',
	'userrenametool-error-cannot-rename-account' => 'Die Umbenennung des Benutzerkontos in der gemeinsamen globalen Datenbank ist fehlgeschlagen.',
	'userrenametool-error-cannot-create-block' => 'Fehler bei der Erstellung des Phalanx-Blocks',
	'userrenametool-error-cannot-rename-unexpected' => 'Es ist ein unerwarteter Fehler aufgetreten. Bitte Logs überprüfen oder erneut versuchen.',
	'userrenametool-warnings-characters' => 'Der neue Benutzername enthält ungültige Zeichen!',
	'userrenametool-warnings-maxlength' => 'Die Länge des neuen Benutzernamens kann nicht länger sein als 255 Zeichen!',
	'userrenametool-warn-repeat' => 'Achtung! Der Benutzer "<nowiki> $1 </nowiki>" wurde bereits umbenannt in "<nowiki> $2 </nowiki>".
Setze den Prozess nur fort, wenn du fehlende Informationen hinzufügen musst.',
	'userrenametool-warn-table-missing' => 'Die Tabelle "<nowiki>$2</nowiki>" existiert nicht in der Datenbank "<nowiki>$1</nowiki>".',
	'userrenametool-info-started' => '$1 hat Umbenennung begonnen: $2 in $3 (Logs: $4).
Grund: "$5".',
	'userrenametool-info-finished' => '$1 hat Umbenennung vollzogen: $2 in $3 (Logs: $4).
Grund: "$5".',
	'userrenametool-info-failed' => '$1 ist bei Umbenennung GESCHEITERT: $2 in $3 (Logs: $4).
Grund: "$5".',
	'userrenametool-info-wiki-finished' => '$1 hat im $4 $2 in $3 umbenannt.
Grund: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 hat im $4 $2 in $3 mit Fehlern umbenannt.
Grund: "$5".',
	'userrenametool-info-in-progress' => 'Der Umbenennungsprozess läuft.
Der Rest erfolgt im Hintergrund.
Du wirst per E-Mail benachrichtigt, wenn alles abgeschlossen ist.',
	'userrenametool-success' => 'Der Benutzer „$1“ wurde erfolgreich in „$2“ umbenannt.',
	'userrenametool-confirm-intro' => 'Wollen Sie wirklich dies tun?',
	'userrenametool-confirm-yes' => 'Ja',
	'userrenametool-confirm-no' => 'Nein',
	'userrenametool-page-exists' => 'Die Seite $1 existiert bereits und kann nicht automatisch überschrieben werden.',
	'userrenametool-page-moved' => 'Die Seite „$1“ wurde nach „$2“ verschoben.',
	'userrenametool-page-unmoved' => 'Die Seite „$1“ konnte nicht nach „$2“ verschoben werden.',
	'userrenametool-finished-email-subject' => 'Umbenennung ist abgeschlossen für [$ 1]',
	'userrenametool-finished-email-body-text' => 'Des Verschiebungs-Prozess  für "<nowiki>$1</nowiki>" auf "<nowiki>$2</nowiki>" ist abgeschlossen.',
	'userrenametool-finished-email-body-html' => 'Des Verschiebungs-Prozess  für "<nowiki>$1</nowiki>" auf "<nowiki>$2</nowiki>" ist abgeschlossen.',
	'userrenametool-logpage' => 'Benutzernamenänderungs-Logbuch',
	'userrenametool-logpagetext' => 'In diesem Logbuch werden die Änderungen von Benutzernamen protokolliert.',
	'userrenametool-logentry' => 'hat „$1“ in „$2“ umbenannt',
	'userrenametool-log' => '{{PLURAL:$1|Eine Bearbeitung|$1 Bearbeitungen}}. Grund: $2',
	'userrenametool-move-log' => 'Seite während der Benutzerkontoumbenennung von „[[User:$1|$1]]“ in „[[User:$2|$2]]“ automatisch verschoben',
	'right-renameuser' => 'Benutzer umbenennen',
	'action-renameuser' => 'Benutzer umzubenennen',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'renameuser' => 'nameyê karberi bıvurn',
	'userrenametool-old' => 'Namey karberi yo nıkayên:',
	'userrenametool-new' => 'Nameyê karberi yo newe:',
	'userrenametool-warnings' => 'pıpawin',
	'userrenametool-submit' => 'Namey karberi bıvurnê',
	'userrenametool-errorblocked' => '$3<nowiki>$2</nowiki> Karber <nowiki>$1</nowiki> bloke kerd.',
	'userrenametool-errorlocked' => 'Karber <nowiki>$1</nowiki> bloke biyo.',
	'userrenametool-errorbot' => '<nowiki>$1</nowiki>yew boto.',
	'userrenametool-confirm-yes' => 'Eya',
	'userrenametool-confirm-no' => 'Nê',
	'userrenametool-logentry' => ' $1 nameycı yo newe "$2"o',
	'right-renameuser' => 'nameyê karberan bıvurn',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'renameuser' => 'Wužywarja pśemjeniś',
	'userrenametool-desc' => "Pśidawa [[Special:UserRenameTool|specialny bok]] za pśemjenjenje wužywarja (pomina se pšawo ''renameuser'') a pśeźěłowanje wšyknych pśisłušajucych datow",
	'userrenametool-old' => 'Aktualne wužywarske mě:',
	'userrenametool-new' => 'Nowe wužywarske mě:',
	'userrenametool-reason' => 'Pśicyna za pśemjenjenje',
	'userrenametool-move' => 'Wužywarski a diskusijny bok (a jich pódboki) do nowego mjenja pśesunuś',
	'userrenametool-reserve' => 'Stare wužywarske mě pśeśiwo pśichodnemu wužywanjeju blokěrowaś',
	'userrenametool-warnings' => 'Warnowanja:',
	'userrenametool-confirm' => 'Jo, wužywarja pśemjeniś',
	'userrenametool-submit' => 'Pśemjeniś',
	'userrenametool-errordoesnotexist' => 'Wužywaŕ "<nowiki>$1</nowiki>" njeeksistěrujo.',
	'userrenametool-errorexists' => 'Wužywaŕ "<nowiki>$1</nowiki>" južo eksistěrujo.',
	'userrenametool-errorinvalid' => 'Wužywarske mě "<nowiki>$1</nowiki>" jo njepłaśiwe.',
	'userrenametool-errortoomany' => 'Wužywaŕ "<nowiki>$1</nowiki>" ma $2 {{PLURAL:$2|pśinosk|pśinoska|pśinoski|pśinoskow}}. Pśemjenjenje wužywarja z wěcej nježli $3 {{PLURAL:$3|pśinoskom|pśinoskoma|pśinoskami|pśinoskami}} móžo wugbałosć serwera na škódu wobwliwowaś.',
	'userrenametool-error-request' => 'Problem jo pśi dostawanju napšašanja wustupił.
Źi pšosym slědk a wopytaj hyšći raz.',
	'userrenametool-error-same-user' => 'Njamóžoš wužywarja do togo samogo mjenja pśemjeniś',
	'userrenametool-success' => 'Wužywaŕ "<nowiki>$1</nowiki>" jo se do "<nowiki>$2</nowiki>" pśemjenił.',
	'userrenametool-page-exists' => 'Bok $1 južo eksistěrujo a njedajo se awtomatiski pśepisaś.',
	'userrenametool-page-moved' => 'Bok $1 jo se do $2 pśesunuł.',
	'userrenametool-page-unmoved' => 'Bok $1 njejo se do $2 pśesunuś dał.',
	'userrenametool-logpage' => 'Protokol wužywarskich pśemjenjenjow',
	'userrenametool-logpagetext' => 'Toś to jo protokol změnow na wužywarskich mjenjach.',
	'userrenametool-logentry' => 'jo $1 do "$2" pśemjenił',
	'userrenametool-log' => '{{PLURAL:&1|1 změna|$1 změnje|$1 změny|$1 změnow}}. Pśicyna: $2',
	'userrenametool-move-log' => 'Pśi pśemjenjowanju wužywarja "[[User:$1|$1]]" do "[[User:$2|$2]]" awtomatiski pśesunjony bok',
	'right-renameuser' => 'Wužywarjow pśemjeniś',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Dead3y3
 * @author MF-Warburg
 * @author Nikosguard
 * @author ZaDiak
 */
$messages['el'] = array(
	'renameuser' => 'Μετονομασία χρήστη',
	'userrenametool-desc' => "Προσθέτει μια [[Special:Renameuser|ειδική σελίδα]] για την μετονομασία ενός χρήστη (είναι απαραίτητο το δικαίωμα ''renameuser'')",
	'userrenametool-old' => 'Τρέχον όνομα χρήστη:',
	'userrenametool-new' => 'Νέο όνομα χρήστη:',
	'userrenametool-reason' => 'Λόγος μετονομασίας:',
	'userrenametool-move' => 'Μετακίνηση της σελίδας χρήστη και της σελίδας συζήτησης χρήστη (και των υποσελίδων τους) στο καινούργιο όνομα',
	'userrenametool-reserve' => 'Φραγή του παλιού ονόματος χρήστη/χρήστριας από μελλοντική χρήση',
	'userrenametool-warnings' => 'Προειδοποιήσεις:',
	'userrenametool-confirm' => 'Ναι, μετονομάστε τον χρήστη',
	'userrenametool-submit' => 'Καταχώριση',
	'userrenametool-errordoesnotexist' => 'Ο χρήστης "<nowiki>$1</nowiki>" δεν υπάρχει',
	'userrenametool-errorexists' => 'Ο χρήστης "<nowiki>$1</nowiki>" υπάρχει ήδη.',
	'userrenametool-errorinvalid' => 'Το όνομα χρήστη "<nowiki>$1</nowiki>" είναι άκυρο.',
	'userrenametool-errortoomany' => 'Ο χρήστης ή η χρήστρια «<nowiki>$1</nowiki>» έχει $2 {{PLURAL:$2|συνεισφορά|συνεισφορές}}. Η μετονομασία ενός χρήστη ή μιας χρήστριας με περισσότερες από $3 {{PLURAL:$3|συνεισφορά|συνεισφορές}} μπορεί να επηρεάσει δυσμενώς την απόδοση του ιστοτόπου.',
	'userrenametool-error-request' => 'Υπήρξε ένα πρόβλημα στην παραλαβή της αίτησης. Παρακαλούμε επιστρέψτε και ξαναδοκιμάστε.',
	'userrenametool-error-same-user' => 'Δεν μπορείτε να μετονομάσετε έναν χρήστη σε όνομα ίδιο με το προηγούμενο.',
	'userrenametool-success' => 'Ο χρήστης ή η χρήστρια «<nowiki>$1</nowiki>» έχει μετονομαστεί σε «<nowiki>$2</nowiki>».',
	'userrenametool-page-exists' => 'Η σελίδα $1 υπάρχει ήδη και δεν μπορεί να αντικατασταθεί αυτόματα.',
	'userrenametool-page-moved' => 'Η σελίδα $1 μετακινήθηκε στο $2.',
	'userrenametool-page-unmoved' => 'Η σελίδα $1 δεν μπόρεσε να μετακινηθεί στο $2.',
	'userrenametool-logpage' => 'Αρχείο μετονομασίας χρηστών',
	'userrenametool-logpagetext' => 'Αυτό είναι ένα αρχείο καταγραφών αλλαγών σε ονόματα χρηστών',
	'userrenametool-logentry' => 'Ο/Η $1 μετονομάστηκε σε «$2»',
	'userrenametool-log' => '{{PLURAL:$1|1 επεξεργασία|$1 επεξεργασίες}}. Λόγος: $2',
	'userrenametool-move-log' => 'Η σελίδα μετακινήθηκε αυτόματα κατά τη μετονομασία του χρήστη "[[User:$1|$1]]" σε "[[User:$2|$2]]"',
	'right-renameuser' => 'Μετονομασία χρηστών',
	'action-renameuser' => 'μετονομασία χρηστών',
);

/** Esperanto (Esperanto)
 * @author Tlustulimu
 * @author Yekrats
 */
$messages['eo'] = array(
	'renameuser' => 'Alinomigu uzanton',
	'userrenametool-desc' => "Alinomigu uzanton (bezonas rajton ''renameuser'')",
	'userrenametool-old' => 'Aktuala uzantonomo:',
	'userrenametool-new' => 'Nova salutnomo:',
	'userrenametool-reason' => 'Kialo por alinomigo:',
	'userrenametool-move' => 'Movu uzantan kaj diskutan paĝojn (kaj ties subpaĝojn) al la nova nomo',
	'userrenametool-reserve' => 'Teni la malnovan salutnomon de plua uzo',
	'userrenametool-warnings' => 'Avertoj:',
	'userrenametool-confirm' => 'Jes, renomigu la uzanton',
	'userrenametool-submit' => 'Ek',
	'userrenametool-errordoesnotexist' => 'La uzanto "<nowiki>$1</nowiki>" ne ekzistas',
	'userrenametool-errorexists' => 'La uzanto "<nowiki>$1</nowiki>" jam ekzistas',
	'userrenametool-errorinvalid' => 'La uzantonomo "<nowiki>$1</nowiki>" estas malvalida',
	'userrenametool-errortoomany' => 'La uzanto "<nowiki>$1</nowiki>" havas $2 {{PLURAL:$2|kontribuon|kontribuojn}}. Alinamigo de uzanto kun pli ol $3 {{PLURAL:$2|kontribuo|kontribuoj}} povus malbone influi paĝaran funkciadon',
	'userrenametool-error-request' => 'Estis problemo recivante la peton.
Bonvolu retroigi kaj reprovi.',
	'userrenametool-error-same-user' => 'Vi ne povas alinomigi uzanton al la sama nomo.',
	'userrenametool-success' => 'La uzanto "<nowiki>$1</nowiki>" estas alinomita al "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'La paĝo $1 jam ekzistas kaj ne povas esti aŭtomate anstataŭata.',
	'userrenametool-page-moved' => 'La paĝo $1 estis movita al $2.',
	'userrenametool-page-unmoved' => 'La paĝo $1 ne povis esti movita al $2.',
	'userrenametool-logpage' => 'Protokolo pri alinomigoj de uzantoj',
	'userrenametool-logpagetext' => 'Ĉi tio estas protokolo pri ŝanĝoj de uzantonomoj',
	'userrenametool-logentry' => 'renomigis $1 al "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 redakto|$1 redaktoj}}. Kialo: $2',
	'userrenametool-move-log' => 'Aŭtomate movis paĝon dum alinomigo de la uzanto "[[User:$1|$1]]" al "[[User:$2|$2]]"',
	'right-renameuser' => 'Alinomigi uzantojn',
);

/** Spanish (español)
 * @author Alhen
 * @author Icvav
 * @author Jatrobat
 * @author Lin linao
 * @author Ovruni
 * @author Remember the dot
 * @author Rhaijin
 * @author Sanbec
 * @author Spacebirdy
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'userrenametool' => 'Cambiar el nombre de un usuario',
	'renameuser' => 'Cambiar el nombre de usuario',
	'userrenametool-warning' => 'Antes de renombrar a un usuario, por favor asegúrate de que toda la información es correcta, y garantiza que el usuario conoce que puede llevar algún tiempo para completarse. Puedes ver el registro en el [[Special:Stafflog|registro del Personal]].',
	'userrenametool-desc' => "Añade una [[Special:UserRenameTool|página especial]] para renombrar a un usuario (necesita el derecho ''renameuser'') y procesa todos los datos relacionados",
	'userrenametool-old' => 'Nombre actual:',
	'userrenametool-new' => 'Nuevo nombre de usuario:',
	'userrenametool-encoded' => 'URL codificada:',
	'userrenametool-reason' => 'Motivo:',
	'userrenametool-move' => 'Trasladar las páginas de usuario y de discusión (y sus subpáginas) al nuevo nombre',
	'userrenametool-reserve' => 'Bloquea el antiguo nombre de usuario para evitar usarlo en el futuro',
	'userrenametool-notify-renamed' => 'Enviar un correo electrónico al usuario renombrado al finalizar',
	'userrenametool-warnings' => 'Avisos:',
	'userrenametool-requested-rename' => 'El usuario $1 solicitó un renombre de la cuenta',
	'userrenametool-did-not-request-rename' => 'El usuario $1 no solicitó un renombre de la cuenta',
	'userrenametool-previously-renamed' => 'El usuario $1 ya tiene un renombre de cuenta',
	'userrenametool-phalanx-matches' => 'Coincidencias en filtros de Phalanx: $1',
	'userrenametool-confirm' => 'Sí, renombrar el usuario',
	'userrenametool-submit' => 'Enviar',
	'userrenametool-error-antispoof-conflict' => 'Advertencia AntiSpoof - ya existe un nombre de usuario similar a "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof no está instalado.',
	'userrenametool-errordoesnotexist' => 'El usuario «<nowiki>$1</nowiki>» no existe',
	'userrenametool-errorexists' => 'El usuario «<nowiki>$1</nowiki>» ya existe',
	'userrenametool-errorinvalid' => 'El nombre de usuario «<nowiki>$1</nowiki>» no es válido',
	'userrenametool-errorinvalidnew' => "''<nowiki>$1</nowiki>'' no es un nombre de usuario válido.",
	'userrenametool-errortoomany' => 'El usuario «<nowiki>$1</nowiki>» tiene $2 {{PLURAL:$2|contribución|contribuciones}}, renombrar a un usuario con más de $3 {{PLURAL:$3|contribución|contribuciones}} podría afectar negativamente al rendimiento del sitio.',
	'userrenametool-errorprocessing' => 'El proceso de cambiar el nombre del usuario <nowiki>$1</nowiki> a <nowiki>$2</nowiki> está en progreso.',
	'userrenametool-errorblocked' => 'El usuario <nowiki>$1</nowiki> está bloqueado por <nowiki>$2</nowiki> por $3.',
	'userrenametool-errorlocked' => 'El usuario <nowiki>$1</nowiki> esta bloqueado.',
	'userrenametool-errorbot' => 'El usuario <nowiki>$1</nowiki> es un bot.',
	'userrenametool-error-request' => 'Hubo un problema al recibir la solicitud.
Por favor, vuelve atrás e inténtalo de nuevo.',
	'userrenametool-error-same-user' => 'No puedes renombrar a un usuario con el nombre que ya tenía.',
	'userrenametool-error-extension-abort' => 'Una extensión impidió el proceso de cambio de nombre.',
	'userrenametool-error-cannot-rename-account' => 'El cambio de nombre de usuario en la base de datos global compartida falló.',
	'userrenametool-error-cannot-create-block' => 'La creación de un filtro de bloqueo en Phalanx falló.',
	'userrenametool-error-cannot-rename-unexpected' => 'Se produjo un error inesperado, comprueba los registros o intenta de nuevo.',
	'userrenametool-warnings-characters' => 'El nuevo nombre de usuario contiene caracteres no válidos!',
	'userrenametool-warnings-maxlength' => 'La longitud del nuevo nombre de usuario no puede exceder de 255 caracteres!',
	'userrenametool-warn-repeat' => '¡Atención! El usuario "<nowiki>$1</nowiki>" ya ha sido renombrado a "<nowiki>$2</nowiki>".
Continúa con el proceso sólo si necesitas actualizar alguna información faltante.',
	'userrenametool-warn-table-missing' => 'La tabla "<nowiki>$2</nowiki>" no existe en la base de datos "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 comenzó a renombrar: $2 a $3 (registros: $4).
Motivo: "$5".',
	'userrenametool-info-finished' => '$1 completó el renombre: $2 a $3 (registros: $4).
Motivo: "$5".',
	'userrenametool-info-failed' => '$1 FALLÓ el renombre: $2 to $3 (registros: $4).
Motivo: "$5".',
	'userrenametool-info-wiki-finished' => '$1 renombró $2 a $3 en $4.
Motivo: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 renombró $2 a $3 en $4 con errores.
Motivo: "$5".',
	'userrenametool-info-in-progress' => 'El proceso de renombre está en progreso.
El resto se hará en segundo plano.
Serás notificado por correo electrónico cuando se haya completado.',
	'userrenametool-success' => 'El usuario «<nowiki>$1</nowiki>» ha sido renombrado a «<nowiki>$2</nowiki>»',
	'userrenametool-confirm-intro' => '¿Realmente quieres hacer esto?',
	'userrenametool-confirm-yes' => 'Sí',
	'userrenametool-confirm-no' => 'No',
	'userrenametool-page-exists' => 'La página $1 ya existe y no puede ser reemplazada automáticamente.',
	'userrenametool-page-moved' => 'La página $1 ha sido trasladada a $2.',
	'userrenametool-page-unmoved' => 'La página $1 no pudo ser trasladada a $2.',
	'userrenametool-finished-email-subject' => 'Proceso de renombre de usuario completado para [$1]',
	'userrenametool-finished-email-body-text' => 'El proceso de renombrado de "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" ha sido completado.',
	'userrenametool-finished-email-body-html' => 'El proceso de renombrado de "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" ha sido completado.',
	'userrenametool-logpage' => 'Registro de cambios de nombre de usuarios',
	'userrenametool-logpagetext' => 'Este es un registro de cambios de nombres de usuarios',
	'userrenametool-logentry' => 'ha renombrado a $1 a "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivo: $2',
	'userrenametool-move-log' => 'Página trasladada automáticamente al renombrar al usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Renombrar usuarios',
	'action-renameuser' => 'renombrar usuarios',
);

/** Estonian (eesti)
 * @author Avjoska
 * @author Jaan513
 * @author WikedKentaur
 */
$messages['et'] = array(
	'renameuser' => 'Kasutajanime muutmine',
	'userrenametool-old' => 'Praegune kasutajanimi:',
	'userrenametool-new' => 'Uus kasutajanimi:',
	'userrenametool-reason' => 'Muutmise põhjus:',
	'userrenametool-move' => 'Nimeta ümber kasutajaleht, aruteluleht ja nende alamlehed.',
	'userrenametool-warnings' => 'Hoiatused:',
	'userrenametool-confirm' => 'Jah, nimeta kasutaja ümber',
	'userrenametool-submit' => 'Muuda',
	'userrenametool-logpage' => 'Kasutajanime muutmise logi',
	'userrenametool-log' => '{{PLURAL:$1|1 redaktsioon|$1 redaktsiooni}}. Põhjus: $2',
	'right-renameuser' => 'Muuta kasutajanimesid',
);

/** Basque (euskara)
 * @author An13sa
 * @author Theklan
 * @author Xabier Armendaritz
 */
$messages['eu'] = array(
	'renameuser' => 'Erabiltzaile bati izena aldatu',
	'userrenametool-old' => 'Oraingo erabiltzaile izena:',
	'userrenametool-new' => 'Erabiltzaile izen berria:',
	'userrenametool-reason' => 'Izena aldatzeko arrazoia:',
	'userrenametool-warnings' => 'Oharrak:',
	'userrenametool-confirm' => 'Bai, lankidearen izena aldatu',
	'userrenametool-submit' => 'Bidali',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" lankidea existitzen da',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" erabiltzaile izena okerra da',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" lankideak $2 {{PLURAL:$2|ekarpen|ekarpen}} ditu, $3 baino {{PLURAL:$3|ekarpen|ekarpen}} gehiago dituen lankide baten izena aldatzeak gunearen errendimenduan eragin txarrak izan ditzake.',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" lankidearen izen berria "<nowiki>$2</nowiki>" da',
	'userrenametool-page-exists' => 'Badago $1 orrialdea, eta ezin da automatikoki gainidatzi.',
	'userrenametool-page-moved' => '$1 orria $2 izenera aldatu da.',
	'userrenametool-page-unmoved' => 'Ezin izan da $1 orrialdea $2(e)ra mugitu.',
	'userrenametool-logpage' => 'Erabiltzaileen izen aldaketa erregistroa',
	'userrenametool-logpagetext' => 'Erabiltzaileen izen aldaketen erregistroa da hau',
	'userrenametool-move-log' => 'Orria automatikoki lekualdatu da, «[[User:$1|$1]]» wikilaria «[[User:$2|$2]]» izenera aldatzean',
	'right-renameuser' => 'Lankideak berrizendatu',
);

/** Extremaduran (estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'userrenametool-page-moved' => 'S´á moviu la páhina $1 a $2.',
);

/** Persian (فارسی)
 * @author Huji
 * @author Mjbmr
 */
$messages['fa'] = array(
	'userrenametool' => 'تغییر یک نام کاربر',
	'renameuser' => 'تغییر نام کاربر',
	'userrenametool-desc' => "نام یک کاربر را تغییر می‌دهد (نیازمند برخورداری از اختیارات ''تغییرنام'' است)",
	'userrenametool-old' => 'نام کاربری فعلی:',
	'userrenametool-new' => 'نام کاربری جدید:',
	'userrenametool-reason' => 'علت تغییر نام کاربری:',
	'userrenametool-move' => 'صفحه کاربر و صفحه بحث کاربر (و زیر صفحه‌های آن‌ها) را به نام جدید انتقال بده',
	'userrenametool-reserve' => 'نام کاربری قبلی را در مقابل استفادهٔ مجدد حفظ کن',
	'userrenametool-notify-renamed' => 'ارسال پست الکترونیکی به کاربر تغییر نام داده شده، در هنگام اتمام کار.',
	'userrenametool-warnings' => 'هشدار:',
	'userrenametool-confirm' => 'بله، نام کاربر را تغییر بده',
	'userrenametool-submit' => 'ثبت',
	'userrenametool-errordoesnotexist' => 'نام کاربری «<nowiki>$1</nowiki>» وجود ندارد',
	'userrenametool-errorexists' => 'نام کاربری «<nowiki>$1</nowiki>» استفاده شده‌است',
	'userrenametool-errorinvalid' => 'نام کاربری «<nowiki>$1</nowiki>» غیر مجاز است',
	'userrenametool-errortoomany' => 'کاربر «<nowiki>$1</nowiki>» دارای $2 {{PLURAL:$2|مشارکت|مشارکت}} است؛ تغییر نام کاربران با بیش از $3 ویرایش ممکن است عملکرد وبگاه را دچار مشکل کند.',
	'userrenametool-error-request' => 'در دریافت درخواست مشکلی پیش آمد. لطفاً به صفحهٔ قبل بازگردید و دوباره تلاش کنید.',
	'userrenametool-error-same-user' => 'شما نمی‌توانید نام یک کاربر را به همان نام قبلی‌اش تغییر دهید.',
	'userrenametool-success' => 'نام کاربر «<nowiki>$1</nowiki>» به «<nowiki>$2</nowiki>» تغییر یافت.',
	'userrenametool-confirm-yes' => 'بله',
	'userrenametool-confirm-no' => 'خیر',
	'userrenametool-page-exists' => 'صفحهٔ $1 از قبل وجود داشته و به طور خودکار قابل بازنویسی نیست.',
	'userrenametool-page-moved' => 'صفحهٔ $1 به $2 انتقال داده شد.',
	'userrenametool-page-unmoved' => 'امکان انتقال صفحهٔ $1 به $2 وجود ندارد.',
	'userrenametool-logpage' => 'سیاهه تغییر نام کاربر',
	'userrenametool-logpagetext' => 'این سیاههٔ تغییر نام کاربران است',
	'userrenametool-logentry' => 'نام $1 را به $2 تغییر داد',
	'userrenametool-log' => '{{PLURAL:$1|۱ ویرایش|$1 ویرایش}}. دلیل: $2',
	'userrenametool-move-log' => 'صفحه در ضمن تغییر نام «[[User:$1|$1]]» به «[[User:$2|$2]]» به طور خودکار انتقال داده شد.',
	'right-renameuser' => 'تغییر نام کاربران',
);

/** Finnish (suomi)
 * @author Agony
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Tofu II
 */
$messages['fi'] = array(
	'renameuser' => 'Käyttäjätunnuksen vaihto',
	'userrenametool-desc' => "Mahdollistaa [[Special:UserRenameTool|käyttäjän uudelleennimeämisen]] (vaatii ''renameuser''-oikeudet).",
	'userrenametool-old' => 'Nykyinen tunnus',
	'userrenametool-new' => 'Uusi tunnus',
	'userrenametool-reason' => 'Kommentti',
	'userrenametool-move' => 'Siirrä käyttäjä- ja keskustelusivut alasivuineen uudelle nimelle',
	'userrenametool-reserve' => 'Estä entinen käyttäjänimi tulevalta käytöltä',
	'userrenametool-warnings' => 'Varoitukset:',
	'userrenametool-confirm' => 'Kyllä, uudelleennimeä käyttäjä',
	'userrenametool-submit' => 'Nimeä',
	'userrenametool-errordoesnotexist' => 'Tunnusta ”<nowiki>$1</nowiki>” ei ole',
	'userrenametool-errorexists' => 'Tunnus ”<nowiki>$1</nowiki>” on jo olemassa',
	'userrenametool-errorinvalid' => 'Tunnus ”<nowiki>$1</nowiki>” ei ole kelvollinen',
	'userrenametool-errortoomany' => 'Tunnuksella ”<nowiki>$1</nowiki>” on $2 {{PLURAL:$2|muokkaus|muokkausta}}. Tunnuksen, jolla on yli $3 {{PLURAL:$3|muokkaus|muokkausta}}, vaihtaminen voi haitata sivuston suorituskykyä.',
	'userrenametool-errorbot' => 'Käyttäjä <nowiki>$1</nowiki> on botti.',
	'userrenametool-error-request' => 'Pyynnön vastaanottamisessa oli ongelma. Ole hyvä ja yritä uudelleen.',
	'userrenametool-error-same-user' => 'Et voi nimetä käyttäjää uudelleen samaksi kuin hän jo on.',
	'userrenametool-success' => 'Käyttäjän ”<nowiki>$1</nowiki>” tunnus on nyt ”<nowiki>$2</nowiki>”.',
	'userrenametool-confirm-intro' => 'Haluatko todella tehdä tämän?',
	'userrenametool-confirm-yes' => 'Kyllä',
	'userrenametool-confirm-no' => 'Ei',
	'userrenametool-page-exists' => 'Sivu $1 on jo olemassa eikä sitä korvattu.',
	'userrenametool-page-moved' => 'Sivu $1 siirrettiin nimelle $2.',
	'userrenametool-page-unmoved' => 'Sivun $1 siirtäminen nimelle $2 ei onnistunut.',
	'userrenametool-logpage' => 'Tunnusten vaihdot',
	'userrenametool-logpagetext' => 'Tämä on loki käyttäjätunnuksien vaihdoista.',
	'userrenametool-logentry' => 'on nimennyt käyttäjän $1 käyttäjäksi ”$2”',
	'userrenametool-log' => 'Tehnyt {{PLURAL:$1|yhden muokkauksen|$1 muokkausta}}. $2',
	'userrenametool-move-log' => 'Siirretty automaattisesti tunnukselta ”[[User:$1|$1]]” tunnukselle ”[[User:$2|$2]]”',
	'right-renameuser' => 'Nimetä käyttäjätunnuksia uudelleen',
);

/** Faroese (føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'userrenametool-new' => 'Nýtt brúkaranavn:',
);

/** French (français)
 * @author Cedric31
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author Hégésippe Cormier
 * @author IAlex
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'userrenametool' => 'Changer le nom d’un utilisateur',
	'renameuser' => 'Renommer l’utilisateur',
	'userrenametool-warning' => 'Avant de renommer un utilisateur, veuillez vous assurer que toutes les informations sont correctes et que l’utilisateur sait que cela peut nécessiter un certain temps.
Consulter le [[Special:Stafflog|journal du personnel]] pour les historiques.',
	'userrenametool-desc' => "Ajoute une [[Special:UserRenameTool|page spéciale]] qui permet de renommer un utilisateur (nécessite l’autorisation ''renameuser'') et de traiter toutes les données qui lui sont liées.",
	'userrenametool-old' => 'Nom actuel de l’utilisateur :',
	'userrenametool-new' => 'Nouveau nom de l’utilisateur :',
	'userrenametool-encoded' => 'URL encodée :',
	'userrenametool-reason' => 'Motif du renommage :',
	'userrenametool-move' => 'Renommer toutes les pages de l’utilisateur vers le nouveau nom',
	'userrenametool-reserve' => "Réserver l'ancien nom pour un usage futur",
	'userrenametool-notify-renamed' => "Envoyer un courriel à l’utilisateur renommé une fois l'opération effectuée",
	'userrenametool-warnings' => 'Avertissements :',
	'userrenametool-requested-rename' => 'L’utilisateur $1 a demandé un renommage',
	'userrenametool-did-not-request-rename' => 'L’utilisateur $1 n’a pas demandé de renommage',
	'userrenametool-previously-renamed' => "L'utilisateur $1 a déjà eu un renommage",
	'userrenametool-phalanx-matches' => 'Filtres de phalange correspondant à $1:',
	'userrenametool-confirm' => 'Oui, renommer l’utilisateur',
	'userrenametool-submit' => 'Soumettre',
	'userrenametool-error-antispoof-conflict' => 'Avertissement anti-usurpation — il y a déjà un nom d’utilisateur similaire à « <nowiki>$1</nowiki> ».',
	'userrenametool-error-antispoof-notinstalled' => 'L’anti-usurpation n’est pas installée.',
	'userrenametool-errordoesnotexist' => 'L’utilisateur « <nowiki>$1</nowiki> » n’existe pas',
	'userrenametool-errorexists' => 'L’utilisateur « <nowiki>$1</nowiki> » existe déjà',
	'userrenametool-errorinvalid' => 'Le nom d’utilisateur « <nowiki>$1</nowiki> » n’est pas valide',
	'userrenametool-errorinvalidnew' => '« <nowiki>$1</nowiki> » n’est pas un nom d’utilisateur valide.',
	'userrenametool-errortoomany' => 'L’utilisateur « <nowiki>$1</nowiki> » a $2 contribution{{PLURAL:$2||s}} à son actif. Renommer un utilisateur ayant plus de $3 contribution{{PLURAL:$3||s}} pourrait affecter les performances du site.',
	'userrenametool-errorprocessing' => 'Le processus de renommage de l’utilisateur « <nowiki>$1</nowiki> » en « <nowiki>$2</nowiki> » est déjà en cours.',
	'userrenametool-errorblocked' => 'L’utilisateur <nowiki>$1</nowiki> est bloqué par <nowiki>$2</nowiki> pour $3.',
	'userrenametool-errorlocked' => 'L’utilisateur <nowiki>$1</nowiki> est bloqué.',
	'userrenametool-errorbot' => 'L’utilisateur <nowiki>$1</nowiki> est un robot.',
	'userrenametool-error-request' => 'Un problème existe avec la réception de la requête. Revenez en arrière et essayez à nouveau.',
	'userrenametool-error-same-user' => 'Vous ne pouvez pas renommer un utilisateur du même nom qu’auparavant.',
	'userrenametool-error-extension-abort' => 'Une extension a empêché le processus de renommage.',
	'userrenametool-error-cannot-rename-account' => 'Le renommage du compte utilisateur sur la base de données globale a échoué.',
	'userrenametool-error-cannot-create-block' => 'La création d’un blocage Phalanx a échoué.',
	'userrenametool-error-cannot-rename-unexpected' => 'Une erreur inattendue s’est produite, vérifier les journaux ou réessayez',
	'userrenametool-warnings-characters' => 'Le nouveau nom d’utilisateur contient des caractères interdits !',
	'userrenametool-warnings-maxlength' => 'La longueur du nouveau nom d’utilisateur ne peut pas dépasser 255 caractères !',
	'userrenametool-warn-repeat' => 'Attention ! L’utilisateur « <nowiki>$1</nowiki> » a déjà été renommé « <nowiki>$2</nowiki> ».
Vous ne devez continuer le traitement que si vous avez besoin de mettre à jour des informations manquantes.',
	'userrenametool-warn-table-missing' => 'La table « <nowiki>$2</nowiki> » n’existe pas dans la base de données « <nowiki>$1</nowiki> ».',
	'userrenametool-info-started' => '$1 a commencé à renommer : $2 en $3 (journaux : $4).
Motif : « $5 ».',
	'userrenametool-info-finished' => '$1 a terminé de renommer : $2 en $3 (journaux : $4).
Motif : « $5 ».',
	'userrenametool-info-failed' => '$1 a ÉCHOUÉ à renommer : $2 en $3 (journaux : $4).
Raison : « $5 ».',
	'userrenametool-info-wiki-finished' => '$1 a renommé $2 en $3 sur $4.
Raison : « $5 ».',
	'userrenametool-info-wiki-finished-problems' => '$1 a renommé $2 en $3 sur $4 avec des ERREURS.
Raison : « $5 ».',
	'userrenametool-info-in-progress' => 'Le processus de renommage est en cours.
Le reste sera effectué en arrière-plan.
Vous serez informé par courriel quand cela sera terminé.',
	'userrenametool-success' => 'L’utilisateur « $1 » a été renommé en « $2 ».',
	'userrenametool-confirm-intro' => 'Voulez-vous vraiment faire ceci ?',
	'userrenametool-confirm-yes' => 'Oui',
	'userrenametool-confirm-no' => 'Non',
	'userrenametool-page-exists' => 'La page $1 existe déjà et ne peut pas être automatiquement remplacée.',
	'userrenametool-page-moved' => 'La page $1 a été déplacée vers $2.',
	'userrenametool-page-unmoved' => 'La page $1 ne peut pas être renommée en $2.',
	'userrenametool-finished-email-subject' => 'Processus de renommage d’utilisateur terminé pour [$1]',
	'userrenametool-finished-email-body-text' => 'Le processus de renommage de « <nowiki>$1</nowiki> » en « <nowiki>$2</nowiki> » s’est achevé.',
	'userrenametool-finished-email-body-html' => 'Le processus de renommage de « <nowiki>$1</nowiki> » en « <nowiki>$2</nowiki> » s’est achevé.',
	'userrenametool-logpage' => 'Journal des renommages d’utilisateur',
	'userrenametool-logpagetext' => "Ceci est l’historique des changements de noms d'utilisateur",
	'userrenametool-logentry' => 'a renommé « $1 » en « $2 »',
	'userrenametool-log' => '$1 {{PLURAL:$1|modification|modifications}}. Motif : $2',
	'userrenametool-move-log' => 'Page automatiquement déplacée lors du renommage de l’utilisateur « [[User:$1|$1]] » en « [[User:$2|$2]] »',
	'right-renameuser' => 'Renommer les utilisateurs',
	'action-renameuser' => 'renommer les utilisateurs',
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'renameuser' => 'Renomar l’usanciér',
	'userrenametool-desc' => "Apond una [[Special:UserRenameTool|pâge spèciâla]] que pèrmèt de renomar un usanciér (at fôta des drêts de ''renameuser'') et pués de trètar totes les balyês que lui sont liyês.",
	'userrenametool-old' => 'Nom d’ora a l’usanciér :',
	'userrenametool-new' => 'Novél nom a l’usanciér :',
	'userrenametool-reason' => 'Rêson du renomâjo :',
	'userrenametool-move' => 'Renomar totes les pâges a l’usanciér vers lo novél nom',
	'userrenametool-submit' => 'Sometre',
	'userrenametool-errordoesnotexist' => 'L’usanciér « <nowiki>$1</nowiki> » ègziste pas.',
	'userrenametool-errorexists' => 'L’usanciér « <nowiki>$1</nowiki> » ègziste ja.',
	'userrenametool-errorinvalid' => 'Lo nom d’usanciér « <nowiki>$1</nowiki> » est envalido.',
	'userrenametool-errortoomany' => 'L’usanciér « <nowiki>$1</nowiki> » at $2 contribucion{{PLURAL:$2||s}} a son actif. Renomar un usanciér qu’at més de $3 contribucion{{PLURAL:$3||s}} porrêt afèctar la capacitât du seto.',
	'userrenametool-error-request' => 'Un problèmo ègziste avouéc la rècèpcion de la requéta. Tornâd arriér et pués tornâd èprovar.',
	'userrenametool-error-same-user' => 'Vos pouede pas renomar un usanciér avouéc lo mémo nom.',
	'userrenametool-success' => 'L’usanciér « <nowiki>$1</nowiki> » at étâ renomâ en « <nowiki>$2</nowiki> ».',
	'userrenametool-page-exists' => 'La pâge $1 ègziste ja et pôt pas étre ôtomaticament remplaciê.',
	'userrenametool-page-moved' => 'La pâge $1 at étâ dèplaciê vers $2.',
	'userrenametool-page-unmoved' => 'La pâge $1 pôt pas étre renomâ en $2.',
	'userrenametool-logpage' => 'Historico des renomâjos d’usanciér',
	'userrenametool-logpagetext' => 'Cen est l’historico des changements de noms d’usanciér.',
	'userrenametool-logentry' => 'at renomâ $1 en "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 èdicion|$1 èdicions}}. Rêson : $2',
	'userrenametool-move-log' => 'Pâge dèplaciê ôtomaticament quand l’usanciér « [[User:$1|$1]] » est vegnu « [[User:$2|$2]] »',
	'right-renameuser' => 'Renomar des usanciérs',
);

/** Friulian (furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'renameuser' => 'Cambie non par un utent',
	'userrenametool-old' => 'Non utent atuâl:',
	'userrenametool-new' => 'Gnûf non utent:',
	'userrenametool-warnings' => 'Avîs:',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'renameuser' => 'Feroarje in meidochnamme',
	'userrenametool-old' => 'Alde namme:',
	'userrenametool-new' => 'Nije namme:',
	'userrenametool-move' => 'Werneam meidogger en oerlis siden (mei ûnderlizzende siden) nei de nije namme',
	'userrenametool-submit' => 'Feroarje',
	'userrenametool-errordoesnotexist' => 'Der is gjin meidogger mei de namme "<nowiki>$1</nowiki>"',
	'userrenametool-errorexists' => 'De meidochnamme "<nowiki>$1</nowiki>" wurdt al brûkt.',
	'userrenametool-errorinvalid' => 'De meidochnamme "<nowiki>$1</nowiki>" mei net.',
	'userrenametool-errortoomany' => 'Meidogger "<nowiki>$1</nowiki>" hat $2 bewurkings dien; it feroarjen fan de namme fan in meidgger mei mear as $3 bewurkings koe in neidielige ynfloed op de prestaasje fan de webstee hawwe.',
	'userrenametool-success' => 'Meidogger "<nowiki>$1</nowiki>" is no meidogger "<nowiki>$2</nowiki>".',
	'userrenametool-logpage' => 'Nammeferoar-loch',
	'userrenametool-logpagetext' => 'Dit is in loch fan feroarings fan meidochnammen.',
	'right-renameuser' => 'Feroarje meidoggersnammen',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'renameuser' => 'Athainmnigh úsáideoir',
	'userrenametool-old' => 'Ainm reatha úsáideora:',
	'userrenametool-new' => 'Ainm nua úsáideora:',
	'userrenametool-success' => 'Athainmníodh úsáideoir "<nowiki>$1</nowiki>" mar "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Tá leathanach "$1" ann chean féin; ní féidir ábhar a scríobh thairis go huathoibríoch.',
	'userrenametool-logentry' => 'athainmníodh úsáideoir $1 mar "$2"',
	'userrenametool-log' => '{{PLURAL:$1|Athrú amháin|$1 athruithe}}. Fáth: $2',
);

/** Galician (galego)
 * @author Alma
 * @author Prevert
 * @author Toliño
 */
$messages['gl'] = array(
	'userrenametool' => 'Mudar o nome dun usuario',
	'renameuser' => 'Mudar o nome do usuario',
	'userrenametool-warning' => '<strong>Lea a seguinte información detidamente:</strong><p>Antes de mudar o nome dun usuario, asegúrese de que <strong>toda a información é correcta</strong> e de que <strong>o usuario sabe que pode levar algo de tempo completar o proceso</strong>.
<br />Lembre que debido a algúns factores externos a primeira parte do proceso <strong>pode resultar nunha páxina baleira</strong>, que non significa que o proceso non se completase correctamente.</p><p>Pode seguir o progreso do proceso a través do [[Special:Stafflog|rexistro]]; ademais, <strong>o sistema enviará un correo electrónico en canto se complete o proceso</strong>.</p>',
	'userrenametool-desc' => "Engade unha [[Special:UserRenameTool|páxina especial]] para renomear un usuario (cómpre ter o dereito de ''renomear usuarios'') e procesar todos os datos relacionados",
	'userrenametool-old' => 'Nome de usuario actual:',
	'userrenametool-new' => 'Novo nome de usuario:',
	'userrenametool-encoded' => 'Enderezo URL codificado:',
	'userrenametool-reason' => 'Motivo para mudar o nome:',
	'userrenametool-move' => 'Mover as páxinas de usuario e de conversa (xunto coas subpáxinas) ao novo nome',
	'userrenametool-reserve' => 'Reservar o nome de usuario vello para un uso posterior',
	'userrenametool-notify-renamed' => 'Enviar un correo electrónico ao usuario ao rematar',
	'userrenametool-warnings' => 'Avisos:',
	'userrenametool-requested-rename' => 'O usuario $1 solicitou un cambio de nome',
	'userrenametool-did-not-request-rename' => 'O usuario $1 non solicitou un cambio de nome',
	'userrenametool-previously-renamed' => 'O usuario $1 xa recibiu un cambio de nome',
	'userrenametool-phalanx-matches' => 'Filtros de Phalanx que coinciden con $1:',
	'userrenametool-confirm' => 'Si, renomear este usuario',
	'userrenametool-submit' => 'Mudar o nome de usuario',
	'userrenametool-error-antispoof-conflict' => 'Advertencia contra as usurpacións: Xa hai un nome de usuario similar a "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof non está instalado.',
	'userrenametool-errordoesnotexist' => 'O usuario "<nowiki>$1</nowiki>" non existe.',
	'userrenametool-errorexists' => 'O usuario "<nowiki>$1</nowiki>" xa existe.',
	'userrenametool-errorinvalid' => 'O nome de usuario "<nowiki>$1</nowiki>" non é válido.',
	'userrenametool-errorinvalidnew' => 'O nome de usuario "<nowiki>$1</nowiki>" non é válido.',
	'userrenametool-errortoomany' => 'O usuario "<nowiki>$1</nowiki>" ten {{PLURAL:$2|unha contribución|$2 contribucións}}; mudar o nome dun usuario con máis {{PLURAL:$3|dunha contribución|de $3 contribucións}} podería afectar negativamente ao rendemento do sitio.',
	'userrenametool-errorprocessing' => 'O proceso de cambio de nome do usuario <nowiki>$1</nowiki> a <nowiki>$2</nowiki> xa está en curso.',
	'userrenametool-errorblocked' => 'O usuario <nowiki>$1</nowiki> foi bloqueado por <nowiki>$2</nowiki> con este motivo: $3.',
	'userrenametool-errorlocked' => 'O usuario <nowiki>$1</nowiki> está bloqueado.',
	'userrenametool-errorbot' => 'O usuario <nowiki>$1</nowiki> é un bot.',
	'userrenametool-error-request' => 'Houbo un problema coa recepción da solicitude.
Volva atrás e inténteo de novo.',
	'userrenametool-error-same-user' => 'Non pode mudar o nome dun usuario ao mesmo nome que tiña antes.',
	'userrenametool-error-extension-abort' => 'Unha extensión impediu o proceso de cambio de nome.',
	'userrenametool-error-cannot-rename-account' => 'Houbo un erro ao mudar o nome á conta de usuario na base de datos global.',
	'userrenametool-error-cannot-create-block' => 'Houbo un erro ao crear o bloqueo Phalanx.',
	'userrenametool-error-cannot-rename-unexpected' => 'Produciuse un erro inesperado. Comprobe os rexistros ou inténteo de novo.',
	'userrenametool-warnings-characters' => 'O novo nome de usuario contén caracteres ilegais!',
	'userrenametool-warnings-maxlength' => 'A lonxitude do novo nome de usuario supera os 255 caracteres!',
	'userrenametool-warn-repeat' => 'Atención! Ao usuario "<nowiki>$1</nowiki>" xa se lle mudou o nome por "<nowiki>$2</nowiki>".
Continúe o proceso só se necesita actualizar información que falte.',
	'userrenametool-warn-table-missing' => 'A táboa "<nowiki>$2</nowiki>" non existe na base de datos "<nowiki>$1</nowiki>".',
	'userrenametool-info-started' => '$1 comezou a mudar o nome: $2 a $3 (rexistros: $4).
Motivo: "$5".',
	'userrenametool-info-finished' => '$1 rematou de mudar o nome: $2 a $3 (rexistros: $4).
Motivo: "$5".',
	'userrenametool-info-failed' => '$1 FALLOU ao mudar o nome: $2 a $3 (rexistros: $4).
Motivo: "$5".',
	'userrenametool-info-wiki-finished' => '$1 mudou o nome de $2 a $3 o $4.
Motivo: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 mudou o nome de $2 a $3 o $4 con erros.
Motivo: "$5".',
	'userrenametool-info-in-progress' => 'O proceso de cambio de nome está en curso.
O resto farase en segundo plano.
Recibirá unha notificación a través do correo electrónico en canto remate.',
	'userrenametool-success' => 'O usuario "<nowiki>$1</nowiki>" mudou o nome a "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'Está seguro de querer facelo?',
	'userrenametool-confirm-yes' => 'Si',
	'userrenametool-confirm-no' => 'Non',
	'userrenametool-page-exists' => 'A páxina "$1" xa existe e non pode ser sobrescrita automaticamente.',
	'userrenametool-page-moved' => 'A páxina "$1" foi movida a "$2".',
	'userrenametool-page-unmoved' => 'A páxina "$1" non pode ser movida a "$2".',
	'userrenametool-finished-email-subject' => 'Proceso de cambio de nome completado por [$1]',
	'userrenametool-finished-email-body-text' => 'Completouse o proceso de mover "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>"',
	'userrenametool-finished-email-body-html' => 'Completouse o proceso de mover "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>"',
	'userrenametool-logpage' => 'Rexistro de cambios de nome de usuario',
	'userrenametool-logpagetext' => 'Este é un rexistro dos cambios nos nomes de usuario.',
	'userrenametool-logentry' => 'mudou o nome de "$1" a "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edición|$1 edicións}}. Razón: $2',
	'userrenametool-move-log' => 'A páxina moveuse automaticamente cando se mudou o nome do usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomear usuarios',
	'action-renameuser' => 'renomear usuarios',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'userrenametool-submit' => 'Ὑποβάλλειν',
	'userrenametool-log' => '{{PLURAL:$1|1 μεταγραφή|$1 μεταγραφαί}}. Αίτία: $2',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'renameuser' => 'Benutzer umnänne',
	'userrenametool-desc' => "Ergänzt e [[Special:Renameuser|Spezialsyte]] fir d Umnännig vun eme Benutzer (brucht s ''renameuser''-Rächt)",
	'userrenametool-old' => 'Bishärige Benutzername:',
	'userrenametool-new' => 'Neije Benutzername:',
	'userrenametool-reason' => 'Grund:',
	'userrenametool-move' => 'Verschieb Benutzer-/Diskussionssyte mit Untersyte uf dr neij Benutzername',
	'userrenametool-reserve' => 'Blockier dr alt Benutzername fir e Neijregischtrierig',
	'userrenametool-warnings' => 'Warnige:',
	'userrenametool-confirm' => 'Jo, Benutzer umnänne',
	'userrenametool-submit' => 'Umnänne',
	'userrenametool-errordoesnotexist' => 'Dr Benutzername „<nowiki>$1</nowiki>“ git s nit.',
	'userrenametool-errorexists' => 'Dr Benutzername „<nowiki>$1</nowiki>“ git s scho.',
	'userrenametool-errorinvalid' => 'Dr Benutzername „<nowiki>$1</nowiki>“ isch uugiltig.',
	'userrenametool-errortoomany' => 'Dr Benutzer „<nowiki>$1</nowiki>“ het $2 {{PLURAL:$2|Bearbeitig|Bearbeitige}}. D Änderig vum Name vun eme Benutzer mit meh wie $3 {{PLURAL:$3|Bearbeitig|Bearbeitige}} cha d Serverleischtig nochteilig beyyflusse.',
	'userrenametool-error-request' => 'S het e Probläm bim Empfang vu dr Aafrog gee. Bitte nomol versueche.',
	'userrenametool-error-same-user' => 'Dr alt und dr neij Benutzername sin identisch.',
	'userrenametool-success' => 'Dr Benutzer „<nowiki>$1</nowiki>“ isch mit Erfolg in „<nowiki>$2</nowiki>“ umgnännt wore.',
	'userrenametool-page-exists' => 'D Syte $1 git s scho un cha nit automatisch iberschribe wäre.',
	'userrenametool-page-moved' => 'D Syte $1 isch noch $2 verschobe wore.',
	'userrenametool-page-unmoved' => 'D Syte $1 het nit chenne noch $2 verschobe wäre.',
	'userrenametool-logpage' => 'Benutzernamenänderigs-Logbuech',
	'userrenametool-logpagetext' => 'In däm Logbuech wäre d Änderige vu Benutzernäme protokolliert.',
	'userrenametool-logentry' => 'het „$1“ in „$2“ umgnännt',
	'userrenametool-log' => '{{PLURAL:$1|1 Bearbeitig|$1 Bearbeitige}}. Grund: $2',
	'userrenametool-move-log' => 'dur d Umnännig vu „[[User:$1|$1]]“ noch „[[User:$2|$2]]“ automatisch verschobeni Syte',
	'right-renameuser' => 'Benutzer umnänne',
);

/** Hebrew (עברית)
 * @author Inkbug
 * @author Ofekalef
 * @author Rotem Liss
 */
$messages['he'] = array(
	'renameuser' => 'שינוי שם משתמש',
	'userrenametool-desc' => 'הוספת [[Special:Renameuser|דף מיוחד]] לשינוי שם משתמש (דרושה הרשאת "renameuser)',
	'userrenametool-old' => 'שם משתמש נוכחי:',
	'userrenametool-new' => 'שם משתמש חדש:',
	'userrenametool-reason' => 'סיבה לשינוי השם:',
	'userrenametool-move' => 'העברת דפי המשתמש והשיחה (כולל דפי המשנה שלהם) לשם החדש',
	'userrenametool-reserve' => 'חסימת שם המשתמש הישן לשימוש נוסף',
	'userrenametool-warnings' => 'אזהרות:',
	'userrenametool-confirm' => 'כן, שנה את שם המשתמש',
	'userrenametool-submit' => 'שינוי שם משתמש',
	'userrenametool-errordoesnotexist' => 'המשתמש "<nowiki>$1</nowiki>" אינו קיים.',
	'userrenametool-errorexists' => 'המשתמש "<nowiki>$1</nowiki>" כבר קיים.',
	'userrenametool-errorinvalid' => 'שם המשתמש "<nowiki>$1</nowiki>" אינו תקין.',
	'userrenametool-errortoomany' => 'למשתמש "<nowiki>$1</nowiki>" יש {{PLURAL:$2|תרומה אחת|$2 תרומות}}; שינוי שם משתמש של משתמש עם יותר מ{{PLURAL:$3|תרומה אחת|־$3 תרומות}} עלול להשפיע לרעה על ביצועי האתר.',
	'userrenametool-errorlocked' => 'המשתמש <nowiki>$1</nowiki> חסום.',
	'userrenametool-errorbot' => 'המשתמש <nowiki>$1</nowiki> הוא בוט.',
	'userrenametool-error-request' => 'הייתה בעיה בקבלת הבקשה. אנא חזרו לדף הקודם ונסו שנית.',
	'userrenametool-error-same-user' => 'אינכם יכולים לשנות את שם המשתמש לשם זהה לשמו הישן.',
	'userrenametool-success' => 'שם המשתמש של "<nowiki>$1</nowiki>" שונה ל"<nowiki>$2</nowiki>".',
	'userrenametool-confirm-yes' => 'כן',
	'userrenametool-confirm-no' => 'לא',
	'userrenametool-page-exists' => 'הדף $1 כבר קיים ולא ניתן לדרוס אותו אוטומטית.',
	'userrenametool-page-moved' => 'הדף $1 הועבר לדף $2.',
	'userrenametool-page-unmoved' => 'לא ניתן היה להעביר את הדף $1 ל$2.',
	'userrenametool-logpage' => 'יומן שינויי שמות משתמש',
	'userrenametool-logpagetext' => 'זהו יומן השינויים בשמות המשתמשים.',
	'userrenametool-logentry' => 'שינה את שם המשתמש "$1" ל־"$2"',
	'userrenametool-log' => '{{PLURAL:$1|עריכה אחת|$1 עריכות}}. סיבה: $2',
	'userrenametool-move-log' => 'העברה אוטומטית בעקבות שינוי שם המשתמש "[[User:$1|$1]]" ל־"[[User:$2|$2]]"',
	'right-renameuser' => 'שינוי שמות משתמש',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'renameuser' => 'सदस्यनाम बदलें',
	'userrenametool-desc' => "सदस्यनाम बदलें (''सदस्यनाम बदलने अधिकार'' अनिवार्य)",
	'userrenametool-old' => 'सद्य सदस्यनाम:',
	'userrenametool-new' => 'नया सदस्यनाम:',
	'userrenametool-reason' => 'नाम बदलने के कारण:',
	'userrenametool-move' => 'सदस्य पृष्ठ और वार्ता पृष्ठ (और उनके सबपेज) नये नाम की ओर भेजें',
	'userrenametool-submit' => 'भेजें',
	'userrenametool-errordoesnotexist' => 'सदस्य "<nowiki>$1</nowiki>" अस्तित्वमें नहीं हैं।',
	'userrenametool-errorexists' => 'सदस्य "<nowiki>$1</nowiki>" पहले से अस्तित्वमें हैं।',
	'userrenametool-errorinvalid' => 'सदस्यनाम "<nowiki>$1</nowiki>" गलत हैं।',
	'userrenametool-errortoomany' => 'सदस्य "<nowiki>$1</nowiki>" ने $2 बदलाव किये हैं, $3 से ज्यादा बदलाव किये हुए सदस्यका नाम बदलने से साईटमें समस्या निर्माण हो सकती हैं।',
	'userrenametool-error-request' => 'यह मांग पूरी करने मे समस्या आई हैं।
कृपया पीछे जाकर फिरसे यत्न करें।',
	'userrenametool-error-same-user' => 'आप सदस्यनाम को उसी नामसे बदल नहीं सकते हैं।',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" का सदस्यनाम "<nowiki>$2</nowiki>" कर दिया गया हैं।',
	'userrenametool-page-exists' => '$1 यह पन्ना पहले से अस्तित्वमें हैं और इसपर अपने आप पुनर्लेखन नहीं कर सकतें।',
	'userrenametool-page-moved' => '$1 का नाम बदलकर $2 कर दिया गया हैं।',
	'userrenametool-page-unmoved' => '$1 का नाम बदलकर $2 नहीं कर सकें हैं।',
	'userrenametool-logpage' => 'सदस्यनाम बदलाव सूची',
	'userrenametool-logpagetext' => 'यह सदस्यनामोंमें हुए बदलावोंकी सूची हैं',
	'userrenametool-logentry' => 'ने $1 को "$2" में बदल दिया हैं',
	'userrenametool-log' => '{{PLURAL:$1|1 बदलाव|$1 बदलाव}}. कारण: $2',
	'userrenametool-move-log' => '"[[User:$1|$1]]" को "[[User:$2|$2]]" करते वक्त अपने आप सदस्यपृष्ठ बदल दिया हैं',
	'right-renameuser' => 'सदस्योंके नाम बदलें',
);

/** Fiji Hindi (Latin script) (Fiji Hindi)
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'renameuser' => 'Sadasya ke naam badlo',
	'userrenametool-desc' => "[[Special:Renameuser|special panna]] ke jorro ek sadasya ke naam badle ke khatir (''renameuser'' ke hak maange hai)",
	'userrenametool-old' => 'Abhi ke username:',
	'userrenametool-new' => 'Nawaa username:',
	'userrenametool-reason' => 'Naam badle ke kaaran:',
	'userrenametool-move' => 'Sadasya aur salah waala panna (aur uske sub-panna) ke naam badlo',
	'userrenametool-reserve' => 'Purana username ke aage use kare se roko',
	'userrenametool-warnings' => 'Chetauni:',
	'userrenametool-confirm' => 'Haan, sadasya ke naam badlo',
	'userrenametool-submit' => 'Submit karo',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" naam ke koi sadasya nai hai.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" naam ke ek sadasya abhi hai.',
	'userrenametool-errorinvalid' => 'Username "<nowiki>$1</nowiki>" kharaab hai.',
	'userrenametool-errortoomany' => 'Sadasya "<nowiki>$1</nowiki>" ke $2 {{PLURAL:$2|contribution|contributions}} hai, ek sadasya jiske $3 se jaada {{PLURAL:$3|contribution|contributions}} hai, ke naam badle se site ke performance kharaab se affect hoe sake hai.',
	'userrenametool-error-request' => 'Request ke le me kuchh karrbarr bhais hai.
Meharbani kar ke laut ke fir kosis karo.',
	'userrenametool-error-same-user' => 'Aap sadasya ke naam ke badal ke pahile waala naam nai kare sakta hai.',
	'userrenametool-success' => 'Sadasya "<nowiki>$1</nowiki>" ke naam badal ke "<nowiki>$2</nowiki>" kar dewa gais hai.',
	'userrenametool-page-exists' => 'Panna $1 abhi hai aur iske apne se overwrite nai karaa jaae sake hai.',
	'userrenametool-page-moved' => 'Panna $1 ke naam badal ke $2 kar dewa gais hai.',
	'userrenametool-page-unmoved' => 'Panna $1 ke naam badal ke $2 nai kare sakaa hai.',
	'userrenametool-logpage' => 'Sadasya ke naam badle ke log',
	'userrenametool-logpagetext' => 'Ii ek sadasya ke naam badle ke log hai.',
	'userrenametool-logentry' => '$1 ke naam badal ke "$2" kar dewa gais hai',
	'userrenametool-log' => '{{PLURAL:$1|1 badlao|$1 badlao}}. Kaaran: $2',
	'userrenametool-move-log' => 'Automatically panna ke move kar diya hai jab ki sadasya ke naam "[[User:$1|$1]]" se badal ke "[[User:$2|$2]]" kar dewa gais hai',
	'right-renameuser' => 'Sadasya log ke naam badlo',
);

/** Croatian (hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'renameuser' => 'Preimenuj suradnika',
	'userrenametool-desc' => "Dodaje [[Special:Renameuser|posebnu stranicu]] za preimenovanje suradnika (potrebno je ''renameuser'' pravo)",
	'userrenametool-old' => 'Trenutačno suradničko ime:',
	'userrenametool-new' => 'Novo suradničko ime:',
	'userrenametool-reason' => 'Razlog za preimenovanje:',
	'userrenametool-move' => 'Premjesti suradnikove stranice (glavnu, stranicu za razgovor i podstranice, ako postoje) na novo ime',
	'userrenametool-reserve' => 'Zadrži staro suradničko ime od daljnje upotrebe',
	'userrenametool-warnings' => 'Upozorenja:',
	'userrenametool-confirm' => 'Da, preimenuj suradnika',
	'userrenametool-submit' => 'Potvrdi',
	'userrenametool-errordoesnotexist' => 'Suradnik "<nowiki>$1</nowiki>" ne postoji (suradničko ime nije zauzeto).',
	'userrenametool-errorexists' => 'Suradničko ime "<nowiki>$1</nowiki>" već postoji',
	'userrenametool-errorinvalid' => 'Suradničko ime "<nowiki>$1</nowiki>" nije valjano',
	'userrenametool-errortoomany' => 'Suradnik "<nowiki>$1</nowiki>" ima $2 {{PLURAL:$2|uređivanje|uređivanja}}, preimenovanje suradnika s više od $3 {{PLURAL:$3|uređivanja|uređivanja}} moglo bi usporiti ovaj wiki',
	'userrenametool-error-request' => 'Pojavio se problem sa zaprimanjem zahtjeva. Molimo, vratite se i probajte ponovo.',
	'userrenametool-error-same-user' => 'Ne možete preimenovati suradnika u isto kao prethodno.',
	'userrenametool-success' => 'Suradnik "<nowiki>$1</nowiki>" je preimenovan u "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Stranica $1 već postoji i ne može biti prepisana.',
	'userrenametool-page-moved' => 'Suradnikova stranica $1 je premještena, sad se zove: $2.',
	'userrenametool-page-unmoved' => 'Stranica $1 ne može biti preimenovana u $2.',
	'userrenametool-logpage' => 'Evidencija preimenovanja suradnika',
	'userrenametool-logpagetext' => 'Ovo je evidencija preimenovanja suradničkih imena',
	'userrenametool-logentry' => 'promijenjeno suradničko ime $1 u "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 uređivanje|$1 uređivanja}}. Razlog: $2',
	'userrenametool-move-log' => 'Stranica suradnika je premještena prilikom preimenovanja iz "[[User:$1|$1]]" u "[[User:$2|$2]]"',
	'right-renameuser' => 'Preimenovati suradnike',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'userrenametool' => 'Mjeno wužiwarja změnić',
	'renameuser' => 'Wužiwarja přemjenować',
	'userrenametool-desc' => "Přidawa [[Special:UserRenameTool|specialnu stronu]] za přemjenowanje wužiwarja (wužaduje sej prawo ''renameuser'') a wobdźěkowanje wšěch zwjazanych datow",
	'userrenametool-old' => 'Tuchwilne wužiwarske mjeno:',
	'userrenametool-new' => 'Nowe wužiwarske mjeno:',
	'userrenametool-reason' => 'Přičina za přemjenowanje:',
	'userrenametool-move' => 'Wužiwarsku stronu a wužiwarsku diskusiju (a jeju podstrony) na nowe mjeno přesunyć',
	'userrenametool-reserve' => 'Stare wužiwarske mjeno za přichodne wužiwanje blokować',
	'userrenametool-warnings' => 'Warnowanja:',
	'userrenametool-confirm' => 'Haj, wužiwarja přemjenować',
	'userrenametool-submit' => 'Składować',
	'userrenametool-errordoesnotexist' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeeksistuje.',
	'userrenametool-errorexists' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ hižo eksistuje.',
	'userrenametool-errorinvalid' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeje płaćiwe.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" płaćiwe nowe wužiwarske mjeno njeje.',
	'userrenametool-errortoomany' => 'Wužiwar „<nowiki>$1</nowiki>“ je $2 {{PLURAL:$2|přinošk|přinoškaj|přinoški|přinoškow}} dodał. Přemjenowanje wužiwarja z wjace hač $3 {{PLURAL:$3|přinoškom|přinoškomaj|přinoškami|přinoškami}} móže so njepřihódnje na wukonitosć serwera wuskutkować.',
	'userrenametool-errorblocked' => 'Wužiwar <nowiki>$1</nowiki> bu wot <nowiki>$2</nowiki> za $3 zablokowany.',
	'userrenametool-errorlocked' => 'Wužiwar <nowiki>$1</nowiki> je zablokowany.',
	'userrenametool-errorbot' => 'Wužiwar <nowiki>$1</nowiki> je boćik.',
	'userrenametool-error-request' => 'Problem je při přijimanju požadanja wustupił. Prošu dźi wróćo a spytaj hišće raz.',
	'userrenametool-error-same-user' => 'Njemóžeš wužiwarja do samsneje wěcy kaž prjedy přemjenować.',
	'userrenametool-error-extension-abort' => 'Rozšěrjenje je přemjenowanskemu procesej zadźěwał.',
	'userrenametool-success' => 'Wužiwar „<nowiki>$1</nowiki>“ bu wuspěšnje na „<nowiki>$2</nowiki>“ přemjenowany.',
	'userrenametool-confirm-intro' => 'Chceš to woprawdźe činić?',
	'userrenametool-confirm-yes' => 'Haj',
	'userrenametool-confirm-no' => 'Ně',
	'userrenametool-page-exists' => 'Strona $1 hižo eksistuje a njemóže so awtomatisce přepisować.',
	'userrenametool-page-moved' => 'Strona $1 bu pod nowy titul $2 přesunjena.',
	'userrenametool-page-unmoved' => 'Njemóžno stronu $1 pod titul $2 přesunyć.',
	'userrenametool-logpage' => 'Protokol přemjenowanja wužiwarjow',
	'userrenametool-logpagetext' => 'Tu protokoluja so wšě přemjenowanja wužiwarjow.',
	'userrenametool-logentry' => 'je $1 do "$2" přemjenował',
	'userrenametool-log' => '{{PLURAL:$1|1 změna|$1 změnje|$1 změny|$1 změnow}}. Přičina: $2',
	'userrenametool-move-log' => 'Přez přemjenowanje wužiwarja „[[User:$1|$1]]“ na „[[User:$2|$2]]“ awtomatisce přesunjena strona.',
	'right-renameuser' => 'Wužiwarjow přemjenować',
);

/** Hungarian (magyar)
 * @author Dani
 * @author TK-999
 */
$messages['hu'] = array(
	'userrenametool' => 'Felhasználó nevének módosítása',
	'renameuser' => 'Szerkesztő átnevezése',
	'userrenametool-warning' => '<strong>Kérlek, olvasd el az alábbi információkat figyelmesen</strong>:<p>Egy felhasználó átnevezése előtt ellenőrizd, hogy <strong>minden adat helyes-e</strong>, és győződj meg arról, hogy <strong>a felhasználó tudatában van-e annak, hogy némi idő kell a folyamat befejeződéséhez</strong>.
<br />Kérlek, ne feledd, hogy bizonyos külső tényezők miatt a folyamat első része <strong>üres oldalt eredményezhet</strong>, amely azonban nem jelenti a folyamat sikertelenségét</p><p>A folyamatot a [[Special:Stafflog|személyzeti naplóban]] követheted nyomon, valamint <strong>a rendszer e-mailt fog küldeni a teljes átnevezési folyamat befejeződésekor</strong>.</p>',
	'userrenametool-desc' => "Lehetővé teszi egy felhasználó átnevezését (''renameuser'' jog szükséges)",
	'userrenametool-old' => 'Jelenlegi felhasználónév:',
	'userrenametool-new' => 'Új felhasználónév:',
	'userrenametool-reason' => 'Átnevezés oka:',
	'userrenametool-move' => 'Felhasználói- és vitalapok (és azok allapjainak) áthelyezése az új név alá',
	'userrenametool-reserve' => 'Régi név blokkolása a jövőbeli használat megakadályozására',
	'userrenametool-notify-renamed' => 'E-mail küldése az átnevezett felhasználónak a folyamat befejeződésekor',
	'userrenametool-warnings' => 'Figyelmeztetések:',
	'userrenametool-requested-rename' => '"$1" felhasználó átnevezést kért',
	'userrenametool-did-not-request-rename' => '"$1" felhasználó nem igényelt átnevezést',
	'userrenametool-previously-renamed' => '"$1" felhasználót már átnevezték egyszer',
	'userrenametool-phalanx-matches' => '$1-el egyező Phalanx szűrők:',
	'userrenametool-confirm' => 'Igen, nevezd át a szerkesztőt',
	'userrenametool-submit' => 'Elküld',
	'userrenametool-errordoesnotexist' => 'Nem létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'userrenametool-errorexists' => 'Már létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'userrenametool-errorinvalid' => 'A felhasználónév („<nowiki>$1</nowiki>”) érvénytelen',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" nem egy érvényes új felhasználónév.',
	'userrenametool-errortoomany' => '„<nowiki>$1</nowiki>” szerkesztőnek {{PLURAL:$2|egy|$2}} szerkesztése van, $3 szerkesztésnél többel rendelkező felhasználók átnevezése rossz hatással lehet az oldal működésére',
	'userrenametool-errorprocessing' => '<nowiki>"$1"</nowiki> felhasználó <nowiki>"$2"</nowiki>-vé történő átnevezése már folyamatban van.',
	'userrenametool-errorblocked' => '<nowiki>"$1"</nowiki> felhasználót blokkolta <nowiki>$2</nowiki> az alábbi indoklással: $3.',
	'userrenametool-errorlocked' => '<nowiki>"$1"</nowiki> felhasználót blokkolták.',
	'userrenametool-errorbot' => '<nowiki>"$1"</nowiki> felhasználó egy bot.',
	'userrenametool-error-request' => 'Hiba történt a lekérdezés küldése közben. Menj vissza az előző oldalra és próbáld újra.',
	'userrenametool-error-same-user' => 'Nem nevezhetsz át egy felhasználót a meglévő nevére.',
	'userrenametool-error-extension-abort' => 'Egy bővítmény meggátolta az átnevezési folyamatot.',
	'userrenametool-error-cannot-rename-account' => 'A felhasználói fiók átnevezése a megosztott globális adatbázison nem sikerült.',
	'userrenametool-error-cannot-create-block' => 'A Phalanx blokk létrehozása nem sikerült.',
	'userrenametool-warn-repeat' => 'Figyelem! A(z) "<nowiki>$1</nowiki>" felhasználót már átnevezték "<nowiki>$2</nowiki>"-re.
Csak akkor folytasd, ha hiányzó információ frissítése céljából teszed.',
	'userrenametool-warn-table-missing' => 'Nem létezik "<nowiki>$2</nowiki>" táblázat a(z) "<nowiki>$1</nowiki>" adatbázisban.',
	'userrenametool-info-started' => '$1 elkezdte $2 átnevezését az alábbira: $3 (naplók: $4).
Indoklás: "$5".',
	'userrenametool-info-finished' => '$1 befejezte $2 átnevezését az alábbira: $3 (naplók: $4).
Indoklás: "$5".',
	'userrenametool-success' => '„<nowiki>$1</nowiki>” sikeresen át lett nevezve „<nowiki>$2</nowiki>” névre.',
	'userrenametool-confirm-yes' => 'Igen',
	'userrenametool-confirm-no' => 'Nem',
	'userrenametool-page-exists' => '$1 már létezik, és nem lehet automatikusan felülírni.',
	'userrenametool-page-moved' => '$1 át lett nevezve $2 névre',
	'userrenametool-page-unmoved' => '$1-t nem sikerült $2 névre nevezi',
	'userrenametool-logpage' => 'Felhasználóátnevezési-napló',
	'userrenametool-logpagetext' => 'Ez a felhasználói nevek változtatásának naplója.',
	'userrenametool-logentry' => 'átnevezte $1 azonosítóját (az új név: „$2”)',
	'userrenametool-log' => '$1 szerkesztése van. Indoklás: $2',
	'userrenametool-move-log' => '„[[User:$1|$1]]” „[[User:$2|$2]]” névre való átnevezése közben automatikusan átnevezett oldal',
	'right-renameuser' => 'felhasználók átnevezése',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'userrenametool' => 'Cambiar le nomine de un usator',
	'renameuser' => 'Renominar usator',
	'userrenametool-warning' => 'Ante de renominar un usator, per favor assecura te que tote le information es correcte, e que le usator sape que isto pote necessitar un certe tempore pro completar.
Consulta le [[Special:Stafflog|registro del personal]] pro detalios.',
	'userrenametool-desc' => "Adde un [[Special:UserRenameTool|pagina special]] pro renominar un usator (require le privilegio ''renameuser'') e processar tote le datos connexe",
	'userrenametool-old' => 'Nomine de usator actual:',
	'userrenametool-new' => 'Nove nomine de usator:',
	'userrenametool-reason' => 'Motivo del renomination:',
	'userrenametool-move' => 'Renominar etiam le paginas de usator e de discussion (e lor subpaginas) verso le nove nomine',
	'userrenametool-reserve' => 'Blocar le ancian nomine de usator de esser usate in le futuro',
	'userrenametool-notify-renamed' => 'Inviar e-mail al usator renominate quando finite',
	'userrenametool-warnings' => 'Advertimentos:',
	'userrenametool-requested-rename' => 'Le usator $1 requestava un renomination',
	'userrenametool-did-not-request-rename' => 'Le usator $1 non requestava un renomination',
	'userrenametool-previously-renamed' => 'Le usator $1 ha jam essite renominate un vice',
	'userrenametool-phalanx-matches' => 'Filtros de phalange correspondente a $1:',
	'userrenametool-confirm' => 'Si, renomina le usator',
	'userrenametool-submit' => 'Submitter',
	'userrenametool-errordoesnotexist' => 'Le usator "<nowiki>$1</nowiki>" non existe.',
	'userrenametool-errorexists' => 'Le usator ""<nowiki>$1</nowiki>"" existe ja.',
	'userrenametool-errorinvalid' => 'Le nomine de usator "<nowiki>$1</nowiki>" es invalide.',
	'userrenametool-errorinvalidnew' => 'Le nomine de nove usator "<nowiki>$1</nowiki>" es invalide.',
	'userrenametool-errortoomany' => 'Le usator "<nowiki>$1</nowiki>" ha $2 {{PLURAL:$2|contribution|contributiones}}. Le renomination de un usator con plus de $3 {{PLURAL:$3|contribution|contributiones}} poterea afficer negativemente le prestationes del sito.',
	'userrenametool-errorprocessing' => 'Le processo de renomination del usator <nowiki>$1</nowiki> a <nowiki>$2</nowiki> es jam in progresso.',
	'userrenametool-errorblocked' => 'Le usator <nowiki>$1</nowiki> es blocate per <nowiki>$2</nowiki> pro $3.',
	'userrenametool-errorlocked' => 'Le usator <nowiki>$1</nowiki> es blocate.',
	'userrenametool-errorbot' => 'Le usator <nowiki>$1</nowiki> es un robot.',
	'userrenametool-error-request' => 'Il habeva un problema con le reception del requesta.
Per favor retorna e reprova.',
	'userrenametool-error-same-user' => 'Tu non pote renominar un usator al mesme nomine.',
	'userrenametool-error-extension-abort' => 'Un extension impediva le processo de renomination.',
	'userrenametool-error-cannot-rename-account' => 'Le renomination del conto de usator in le base de datos global ha fallite.',
	'userrenametool-error-cannot-create-block' => 'Le creation de un blocada Phalanx ha fallite.',
	'userrenametool-warn-repeat' => 'Attention! Le usator "<nowiki>$1</nowiki>" ha ja essite renominate a "<nowiki>$2</nowiki>".
Continua le processo solmente si tu debe actualisar alcun information mancante.',
	'userrenametool-warn-table-missing' => 'Le tabella "<nowiki>$2</nowiki>" non existe in le base de datos "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 comenciava a renominar: $2 a $3 (registros: $4).
Motivo: "$5".',
	'userrenametool-info-finished' => '$1 completava le renomination: $2 a $3 (registros: $4).
Motivo: "$5".',
	'userrenametool-info-failed' => '$1 FALLEVA le renomination: $2 a $3 (registros: $4).
Motivo: "$5".',
	'userrenametool-info-wiki-finished' => '$1 renominava $2 a $3 in $4.
Motivo: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 renominava $2 a $3 in $4 con errores.
Motivo: "$5".',
	'userrenametool-info-in-progress' => 'Le processo de renomination es in curso.
Le resto essera facite in le fundo.
Tu recipera notification via e-mail quando isto es complete.',
	'userrenametool-success' => 'Le usator "<nowiki>$1</nowiki>" ha essite renominate a "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => 'Es tu secur de voler facer isto?',
	'userrenametool-confirm-yes' => 'Si',
	'userrenametool-confirm-no' => 'No',
	'userrenametool-page-exists' => 'Le pagina $1 existe ja e non pote esser automaticamente superscribite.',
	'userrenametool-page-moved' => 'Le pagina $1 ha essite renominate a $2.',
	'userrenametool-page-unmoved' => 'Le pagina $1 non poteva esser renominate a $2.',
	'userrenametool-finished-email-subject' => 'Processo de renomination de usator completate pro [$1]',
	'userrenametool-finished-email-body-text' => 'Le processo de renomination pro "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" ha essite completate.',
	'userrenametool-finished-email-body-html' => 'Le processo de renomination pro "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" ha essite completate.',
	'userrenametool-logpage' => 'Registro de renominationes de usatores',
	'userrenametool-logpagetext' => 'Isto es un registro de cambiamentos de nomines de usator.',
	'userrenametool-logentry' => 'renominava $1 verso "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 modification|$1 modificationes}}. Motivo: $2',
	'userrenametool-move-log' => 'Le pagina ha essite automaticamente renominate con le renomination del usator "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Renominar usatores',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'userrenametool' => 'Ganti nama pengguna',
	'renameuser' => 'Penggantian nama pengguna',
	'userrenametool-desc' => "Mengganti nama pengguna (perlu hak akses ''renameuser'')",
	'userrenametool-old' => 'Nama sekarang:',
	'userrenametool-new' => 'Nama baru:',
	'userrenametool-reason' => 'Alasan penggantian nama:',
	'userrenametool-move' => 'Pindahkan halaman pengguna dan pembicaraannya (berikut subhalamannya) ke nama baru',
	'userrenametool-reserve' => 'Cadangkan nama pengguna lama sehingga tidak dapat digunakan lagi',
	'userrenametool-notify-renamed' => 'Kirim surel saat pergantian nama pengguna selesai',
	'userrenametool-warnings' => 'Peringatan:',
	'userrenametool-confirm' => 'Ya, ganti nama pengguna tersebut',
	'userrenametool-submit' => 'Simpan',
	'userrenametool-errordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak ada',
	'userrenametool-errorexists' => 'Pengguna "<nowiki>$1</nowiki>" telah ada',
	'userrenametool-errorinvalid' => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah',
	'userrenametool-errortoomany' => 'Pengguna "<nowiki>$1</nowiki>" telah memiliki $2 {{PLURAL:$2|kontribusi|kontribusi}}.
Penggantian nama pengguna dengan lebih dari $3 {{PLURAL:$3|kontribusi|kontribusi}} dapat menurunkan kinerja situs.',
	'userrenametool-error-request' => 'Ada masalah dalam pemrosesan permintaan. Silakan kembali dan coba lagi.',
	'userrenametool-error-same-user' => 'Anda tak dapat mengganti nama pengguna sama seperti asalnya.',
	'userrenametool-error-extension-abort' => 'Pertambahan menghalangi proses mengubah nama',
	'userrenametool-success' => 'Pengguna "<nowiki>$1</nowiki>" telah diganti namanya menjadi "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'Apakah anda yankin mau melakukan ini?',
	'userrenametool-confirm-yes' => 'Ya',
	'userrenametool-confirm-no' => 'Tidak',
	'userrenametool-page-exists' => 'Halaman $1 telah ada dan tidak dapat ditimpa secara otomatis.',
	'userrenametool-page-moved' => 'Halaman $1 telah dipindah ke $2.',
	'userrenametool-page-unmoved' => 'Halaman $1 tidak dapat dipindah ke $2.',
	'userrenametool-finished-email-subject' => 'Proses perubahan nama selesai untuk [$1]',
	'userrenametool-logpage' => 'Log penggantian nama pengguna',
	'userrenametool-logpagetext' => 'Di bawah ini adalah log penggantian nama pengguna',
	'userrenametool-logentry' => 'telah mengganti nama $1 menjadi "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 suntingan|$1 suntingan}}. Alasan: $2',
	'userrenametool-move-log' => 'Secara otomatis memindahkan halaman sewaktu mengganti nama pengguna "[[User:$1|$1]]" menjadi "[[User:$2|$2]]"',
	'right-renameuser' => 'Mengganti nama pengguna',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'renameuser' => 'Rinomar uzanto',
	'userrenametool-old' => 'Aktuala uzantonomo:',
	'userrenametool-new' => 'Nova uzantonomo:',
	'userrenametool-warnings' => 'Averti:',
	'userrenametool-confirm' => "Yes, rinomez l'uzanto",
	'userrenametool-errordoesnotexist' => 'L\'uzanto "<nowiki>$1</nowiki>" ne existas.',
	'userrenametool-errorexists' => 'L\'uzanto "<nowiki>$1</nowiki>" ja existas.',
	'userrenametool-errorinvalid' => 'L\'uzantonomo "<nowiki>$1</nowiki>" esas ne-valida.',
	'userrenametool-error-same-user' => 'Vu ne povas renomar uzanto ad la sama nomo.',
	'userrenametool-success' => 'La uzanto "<nowiki>$1</nowiki>" rinomesis "<nowiki>$2</nowiki>".',
	'userrenametool-page-moved' => 'La pagino $1 movesis a $2.',
	'userrenametool-page-unmoved' => 'On ne povis movar la pagino $1 a $2.',
	'userrenametool-logpage' => 'Registro di uzanto-rinomizuri',
	'userrenametool-logpagetext' => 'Ito es registro di uzantonomala chanji.',
	'userrenametool-logentry' => 'rinomis $1 por "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edito|$1 editi}}. Motivo: $2',
	'right-renameuser' => 'Rinomar uzanti',
);

/** Icelandic (íslenska)
 * @author Cessator
 * @author S.Örvarr.S
 * @author Spacebirdy
 * @author לערי ריינהארט
 */
$messages['is'] = array(
	'renameuser' => 'Breyta notandanafni',
	'userrenametool-old' => 'Núverandi notandanafn:',
	'userrenametool-new' => 'Nýja notandanafnið:',
	'userrenametool-submit' => 'Senda',
	'userrenametool-errordoesnotexist' => 'Notandinn „<nowiki>$1</nowiki>“ er ekki til',
	'userrenametool-errorexists' => 'Notandinn „<nowiki>$1</nowiki>“ er nú þegar til',
	'userrenametool-errorinvalid' => 'Notandanafnið „<nowiki>$1</nowiki>“ er ógilt',
	'userrenametool-page-exists' => 'Síða sem heitir $1 er nú þegar til og það er ekki hægt að búa til nýja grein með sama heiti.',
	'userrenametool-page-moved' => 'Síðan $1 hefur verið færð á $2.',
	'userrenametool-page-unmoved' => 'Ekki var hægt að færa síðuna $1 á $2.',
	'userrenametool-logpage' => 'Skrá yfir nafnabreytingar notenda',
	'userrenametool-logpagetext' => 'Þetta er skrá yfir nýlegar breytingar á notendanöfnum.',
);

/** Italian (italiano)
 * @author .anaconda
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 * @author Gianfranco
 * @author Nemo bis
 */
$messages['it'] = array(
	'renameuser' => 'Rinomina utente',
	'userrenametool-desc' => "Aggiunge una [[Special:Renameuser|pagina speciale]] per rinominare un utente (richiede i diritti di ''renameuser'')",
	'userrenametool-old' => 'Nome utente attuale:',
	'userrenametool-new' => 'Nuovo nome utente:',
	'userrenametool-reason' => 'Motivo del cambio nome:',
	'userrenametool-move' => 'Rinomina anche la pagina utente, la pagina di discussione e le relative sottopagine',
	'userrenametool-reserve' => "Impedisci l'utilizzo del vecchio nome in futuro",
	'userrenametool-warnings' => 'Avvisi:',
	'userrenametool-confirm' => 'Sì, rinomina questo utente',
	'userrenametool-submit' => 'Invia',
	'userrenametool-errordoesnotexist' => 'L\'utente "<nowiki>$1</nowiki>" non esiste',
	'userrenametool-errorexists' => 'L\'utente "<nowiki>$1</nowiki>" esiste già',
	'userrenametool-errorinvalid' => 'Il nome utente "<nowiki>$1</nowiki>" non è valido',
	'userrenametool-errortoomany' => 'L\'utente "<nowiki>$1</nowiki>" ha $2 {{PLURAL:$2|contributo|contributi}}; rinominare un utente con più di $3 {{PLURAL:$3|contributo|contributi}} può influenzare negativamente le prestazioni del sito.',
	'userrenametool-error-request' => 'Si è verificato un problema nella ricezione della richiesta. Tornare indietro e riprovare.',
	'userrenametool-error-same-user' => 'Non è possibile rinominare un utente allo stesso nome che aveva già.',
	'userrenametool-success' => 'L\'utente "<nowiki>$1</nowiki>" è stato rinominato in "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'La pagina $1 esiste già; impossibile sovrascriverla automaticamente.',
	'userrenametool-page-moved' => 'La pagina $1 è stata spostata a $2.',
	'userrenametool-page-unmoved' => 'Impossibile spostare la pagina $1 a $2.',
	'userrenametool-logpage' => 'Utenti rinominati',
	'userrenametool-logpagetext' => 'Di seguito viene presentato il registro delle modifiche ai nomi utente.',
	'userrenametool-logentry' => 'ha rinominato $1 in "$2"',
	'userrenametool-log' => 'Che ha {{PLURAL:$1|un contributo|$1 contributi}}. Motivo: $2',
	'userrenametool-move-log' => 'Pagina spostata automaticamente durante la rinomina dell\'utente "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Rinomina gli utenti',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Broad-Sky
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Marine-Blue
 * @author Shirayuki
 * @author Suisui
 */
$messages['ja'] = array(
	'userrenametool' => '利用者名を変更',
	'renameuser' => '利用者名を変更',
	'userrenametool-desc' => '利用者名変更のための[[Special:Renameuser|特別ページ]]を追加する（renameuser権限が必要）',
	'userrenametool-old' => '現在の利用者名:',
	'userrenametool-new' => '新しい利用者名:',
	'userrenametool-reason' => '変更理由:',
	'userrenametool-move' => '利用者ページと会話ページ（およびそれらのサブページ）を新しい名前に移動する',
	'userrenametool-reserve' => '旧利用者名の今後の使用をブロックする',
	'userrenametool-notify-renamed' => '利用者名の変更後にメールを送信',
	'userrenametool-warnings' => '警告:',
	'userrenametool-confirm' => 'はい、利用者名を変更します',
	'userrenametool-submit' => '変更',
	'userrenametool-errordoesnotexist' => '利用者 “<nowiki>$1</nowiki>” は存在しません。',
	'userrenametool-errorexists' => '利用者 “<nowiki>$1</nowiki>” は既に存在しています。',
	'userrenametool-errorinvalid' => '利用者名 “<nowiki>$1</nowiki>” は無効です。',
	'userrenametool-errorinvalidnew' => '新しい利用者名“<nowiki>$1</nowiki>”は無効です。',
	'userrenametool-errortoomany' => '利用者 "<nowiki>$1</nowiki>" には $2 件の投稿記録があります。$3 件以上の投稿記録がある利用者の名前を変更すると、サイトのパフォーマンスに悪影響を及ぼす可能性があります。',
	'userrenametool-errorbot' => '利用者 <nowiki>$1</nowiki> はボットです。',
	'userrenametool-error-request' => '要求を正常に受け付けることができませんでした。戻ってから再度お試しください。',
	'userrenametool-error-same-user' => '現在と同じ利用者名には変更できません。',
	'userrenametool-success' => '利用者 "<nowiki>$1</nowiki>" を "<nowiki>$2</nowiki>" に変更しました。',
	'userrenametool-confirm-yes' => 'はい',
	'userrenametool-confirm-no' => 'いいえ',
	'userrenametool-page-exists' => '$1 が既に存在しているため、自動で上書きできませんでした。',
	'userrenametool-page-moved' => '$1 を $2 に移動しました。',
	'userrenametool-page-unmoved' => '$1 を $2 に移動できませんでした。',
	'userrenametool-logpage' => '利用者名変更記録',
	'userrenametool-logpagetext' => 'これは、利用者名の変更を記録したものです。',
	'userrenametool-logentry' => '$1を "$2" へ利用者名変更しました。',
	'userrenametool-log' => '{{PLURAL:$1|$1 回の編集}}。
理由: $2',
	'userrenametool-move-log' => '名前の変更と共に "[[User:$1|$1]]" を "[[User:$2|$2]]" へ自動的に移動しました。',
	'right-renameuser' => '利用者名変更',
);

/** Jutish (jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'renameuser' => 'Gæf æ bruger en ny navn',
	'userrenametool-desc' => "Gæf en bruger en ny navn (''renameuser'' regt er nøteg)",
	'userrenametool-old' => 'Nuværende brugernavn:',
	'userrenametool-new' => 'Ny brugernavn:',
	'userrenametool-reason' => "Før hvat dett'er dun:",
	'userrenametool-move' => 'Flyt bruger og diskusje sider (og deres substrøk) til ny navn',
	'userrenametool-submit' => 'Gå til',
	'userrenametool-errordoesnotexist' => 'Æ bruger "<nowiki>$1</nowiki>" bestä ekke.',
	'userrenametool-errorexists' => 'Æ bruger "<nowiki>$1</nowiki>" er ål.',
	'userrenametool-errorinvalid' => 'Æ brugernavn "<nowiki>$1</nowiki>" er ogyldegt.',
	'userrenametool-errortoomany' => 'Æ bruger "<nowiki>$1</nowiki>" har $2 biidråg, hernåmende en bruger ve mære als $3 biidråg ken æ site performans slektes hvinse gæve.',
	'userrenametool-error-request' => 'Her har en pråblæm ve enkriige der anfråge. Gå hen og pråbær nurmål.',
	'userrenametool-error-same-user' => 'Du kenst ekke hernåm æ bruger til æselbste nåm als dafør.',
	'userrenametool-success' => 'Æ bruger "<nowiki>$1</nowiki>" er hernåmt til "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Æ pæge $1 er ål og ken ekke åtåmatisk åverflyttet være.',
	'userrenametool-page-moved' => 'Æ pæge $1 er flyttet til $2.',
	'userrenametool-page-unmoved' => 'Æ pæge $1 kon ekke flyttet være til $2.',
	'userrenametool-logpage' => 'Bruger hernåm log',
	'userrenametool-logpagetext' => "Dett'er en log der ændrenger til brugernavner",
	'userrenametool-logentry' => 'har hernåmt $1 til "$2"',
	'userrenametool-log' => '{{PLURAL:$1|en redigærenge|$1 redigærenger}}. Resån: $2',
	'userrenametool-move-log' => 'Åtåmatisk flyttet pæge hviil hernåm der bruger "[[User:$1|$1]]" til "[[User:$2|$2]]"',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'renameuser' => 'Ngganti jeneng panganggo',
	'userrenametool-desc' => "Ngganti jeneng panganggo (perlu hak aksès ''renameuser'')",
	'userrenametool-old' => 'Jeneng panganggo saiki:',
	'userrenametool-new' => 'Jeneng panganggo anyar:',
	'userrenametool-reason' => 'Alesan ganti jeneng:',
	'userrenametool-move' => 'Mindhah kaca panganggo lan kaca dhiskusiné (sarta subkaca-kacané) menyang jeneng anyar',
	'userrenametool-reserve' => 'Blokir utawa cadhangaké jeneng panganggo lawas supaya ora bisa dianggo manèh',
	'userrenametool-warnings' => 'Pènget:',
	'userrenametool-confirm' => 'Ya, ganti jeneng panganggo kasebut',
	'userrenametool-submit' => 'Kirim',
	'userrenametool-errordoesnotexist' => 'Panganggo "<nowiki>$1</nowiki>" ora ana.',
	'userrenametool-errorexists' => 'Panganggo "<nowiki>$1</nowiki>" wis ana.',
	'userrenametool-errorinvalid' => 'Jeneng panganggo "<nowiki>$1</nowiki>" ora absah',
	'userrenametool-errortoomany' => 'Panganggo "<nowiki>$1</nowiki>" wis duwé $2 {{PLURAL:$2|suntingan|suntingan}}, yèn jeneng panganggoné diganti mawa luwih saka $3 {{PLURAL:$3|suntingan|suntingan}} bisa awèh pangaruh ala marang kinerja situs.',
	'userrenametool-error-request' => 'Ana masalah nalika nampa panyuwunan panjenengan.
Mangga balènana lan nyoba manèh.',
	'userrenametool-error-same-user' => 'Panjenengan ora bisa ngganti jeneng panganggo dadi kaya jeneng asalé.',
	'userrenametool-success' => 'Panganggo "<nowiki>$1</nowiki>" wis diganti jenengé dadi "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Kaca $1 wis ana lan ora bisa ditimpa sacara otomatis.',
	'userrenametool-page-moved' => 'Kaca $1 wis dialihaké menyang $2.',
	'userrenametool-page-unmoved' => 'Kaca $1 ora bisa dialihaké menyang $2.',
	'userrenametool-logpage' => 'Log ganti jeneng panganggo',
	'userrenametool-logpagetext' => 'Iki log owah-owahan jeneng panganggo',
	'userrenametool-logentry' => 'Ganti jeneng $1 dadi "$2"',
	'userrenametool-log' => 'sing wis duwé $1 suntingan. Alesan: $2',
	'userrenametool-move-log' => 'Sacara otomatis mindhah kaca nalika ngganti jeneng panganggo "[[User:$1|$1]]" dadi "[[User:$2|$2]]"',
	'right-renameuser' => 'Ganti jeneng panganggo-panganggo',
);

/** Georgian (ქართული)
 * @author Malafaya
 * @author Sopho
 */
$messages['ka'] = array(
	'renameuser' => 'მომხმარებლის სახელის გამოცვლა',
	'userrenametool-old' => 'ამჟამინდელი მომხმარებლის სახელი:',
	'userrenametool-new' => 'ახალი მომხმარებლის სახელი:',
	'userrenametool-reason' => 'სახელის შეცვლის მიზეზი:',
	'userrenametool-move' => 'მომხმარებლისა და განხილვის გვერდების (და მათი დაქვემდებარებული გვერდების) გადატანა ახალ დასახელებაზე',
	'userrenametool-warnings' => 'გაფრთხილებები:',
	'userrenametool-submit' => 'გაგზავნა',
	'userrenametool-errordoesnotexist' => 'მომხმარებელი "<nowiki>$1</nowiki>" არ არსებობს',
	'userrenametool-errorexists' => 'მომხმარებელი "<nowiki>$1</nowiki>" უკვე არსებობს',
	'userrenametool-errorinvalid' => 'მომხმარებლის სახელი "<nowiki>$1</nowiki>" არასწორია',
	'userrenametool-errortoomany' => 'მომხმარებელს "<nowiki>$1</nowiki>" გაკეთებული აქვს $2 რედაქცია. სახელის შეცვლამ მომხმარებლისათვის, რომელიც $3-ზე მეტ რედაქციას ითვლის, შესაძლოა ზიანი მიაყენოს საიტის ქმედითობას',
	'userrenametool-success' => 'მომხმარებლის სახელი - "<nowiki>$1</nowiki>", შეიცვალა "<nowiki>$2</nowiki>"-ით',
	'userrenametool-page-exists' => 'გვერდი $1 უკვე არსებობს და მისი ავტომატურად შენაცვლება შეუძლებელია.',
	'userrenametool-page-moved' => 'გვერდი $1 გადატანილია $2-ზე.',
	'userrenametool-page-unmoved' => 'არ მოხერხდა გვერდის $1 გადატანა $2-ზე.',
	'userrenametool-logpage' => 'მომხმარებლის სახელის გადარქმევის რეგისტრაციის ჟურნალი',
	'userrenametool-logpagetext' => 'ეს არის ჟურნალი, სადაც აღრიცხულია მომხმარებლის სახელთა ცვლილებები',
	'userrenametool-log' => '$1 რედაქცია. მიზეზი: $2',
	'userrenametool-move-log' => 'ავტომატურად იქნა გადატანილი გვერდი მომხმარებლის "[[User:$1|$1]]" სახელის შეცვლისას "[[User:$2|$2]]-ით"',
	'right-renameuser' => 'მომხმარებლების სახელის გადარქმევა',
);

/** Khowar (کھوار)
 * @author Rachitrali
 */
$messages['khw'] = array(
	'renameuser' => 'صارفو نامو تبدیل کورے',
);

/** Kazakh (Arabic script) (قازاقشا (تٴوتە)‏)
 */
$messages['kk-arab'] = array(
	'renameuser' => 'قاتىسۋشىنى قايتا اتاۋ',
	'userrenametool-old' => 'اعىمداعى قاتىسۋشى اتى:',
	'userrenametool-new' => 'جاڭا قاتىسۋشى اتى:',
	'userrenametool-reason' => 'قايتا اتاۋ سەبەبى:',
	'userrenametool-move' => 'قاتىسۋشىنىڭ جەكە جانە تالقىلاۋ بەتتەرىن (جانە دە ولاردىڭ تومەنگى بەتتەرىن) جاڭا اتاۋعا جىلجىتۋ',
	'userrenametool-submit' => 'جىبەرۋ',
	'userrenametool-errordoesnotexist' => '«<nowiki>$1» دەگەن قاتىسۋشى جوق',
	'userrenametool-errorexists' => '«$1» دەگەن قاتىسۋشى بار تۇگە',
	'userrenametool-errorinvalid' => '«$1» قاتىسۋشى اتى جارامسىز',
	'userrenametool-errortoomany' => '«$1» قاتىسۋشى $2 ۇلەس بەرگەن, $3 ارتا ۇلەسى بار قاتىسۋشىنى قايتا اتاۋى توراپ ونىمدىلىگىنە ىقپال ەتەدى',
	'userrenametool-success' => '«$1» دەگەن قاتىسۋشى اتى «$2» دەگەنگە اۋىستىرىلدى',
	'userrenametool-page-exists' => '$1 دەگەن بەت بار تۇگە, جانە وزدىك تۇردە ونىڭ ۇستىنە ەشتەڭە جازىلمايدى.',
	'userrenametool-page-moved' => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلدى.',
	'userrenametool-page-unmoved' => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلمادى.',
	'userrenametool-logpage' => 'قاتىسۋشىنى قايتا اتاۋ جۋرنالى',
	'userrenametool-logpagetext' => 'بۇل قاتىسۋشى اتىنداعى وزگەرىستەر جۋرنالى',
	'userrenametool-logentry' => '$1 اتاۋىن $2 دەگەنگە وزگەرتتى',
	'userrenametool-log' => '$1 تۇزەتۋى بار. $2',
	'userrenametool-move-log' => '«[[User:$1|$1]]» دەگەن قاتىسۋشى اتىن «[[User:$2|$2]]» دەگەنگە اۋىسقاندا بەت وزدىك تۇردە جىلجىتىلدى',
);

/** Kazakh (Cyrillic script) (қазақша (кирил)‎)
 */
$messages['kk-cyrl'] = array(
	'renameuser' => 'Қатысушыны қайта атау',
	'userrenametool-old' => 'Ағымдағы қатысушы аты:',
	'userrenametool-new' => 'Жаңа қатысушы аты:',
	'userrenametool-reason' => 'Қайта атау себебі:',
	'userrenametool-move' => 'Қатысушының жеке және талқылау беттерін (және де олардың төменгі беттерін) жаңа атауға жылжыту',
	'userrenametool-submit' => 'Жіберу',
	'userrenametool-errordoesnotexist' => '«<nowiki>$1</nowiki>» деген қатысушы жоқ',
	'userrenametool-errorexists' => '«<nowiki>$1</nowiki>» деген қатысушы бар түге',
	'userrenametool-errorinvalid' => '«<nowiki>$1</nowiki>» қатысушы аты жарамсыз',
	'userrenametool-errortoomany' => '«<nowiki>$1</nowiki>» қатысушы $2 үлес берген, $3 арта үлесі бар қатысушыны қайта атауы торап өнімділігіне ықпал етеді',
	'userrenametool-success' => '«<nowiki>$1</nowiki>» деген қатысушы аты «<nowiki>$2</nowiki>» дегенге ауыстырылды',
	'userrenametool-page-exists' => '$1 деген бет бар түге, және өздік түрде оның үстіне ештеңе жазылмайды.',
	'userrenametool-page-moved' => '$1 деген бет $2 деген бетке жылжытылды.',
	'userrenametool-page-unmoved' => '$1 деген бет $2 деген бетке жылжытылмады.',
	'userrenametool-logpage' => 'Қатысушыны қайта атау журналы',
	'userrenametool-logpagetext' => 'Бұл қатысушы атындағы өзгерістер журналы',
	'userrenametool-logentry' => '$1 атауын «$2» дегенге өзгертті',
	'userrenametool-log' => '$1 түзетуі бар. $2',
	'userrenametool-move-log' => '«[[User:$1|$1]]» деген қатысушы атын «[[User:$2|$2]]» дегенге ауысқанда бет өздік түрде жылжытылды',
);

/** Kazakh (Latin script) (qazaqşa (latın)‎)
 */
$messages['kk-latn'] = array(
	'renameuser' => 'Qatıswşını qaýta ataw',
	'userrenametool-old' => 'Ağımdağı qatıswşı atı:',
	'userrenametool-new' => 'Jaña qatıswşı atı:',
	'userrenametool-reason' => 'Qaýta ataw sebebi:',
	'userrenametool-move' => 'Qatıswşınıñ jeke jäne talqılaw betterin (jäne de olardıñ tömengi betterin) jaña atawğa jıljıtw',
	'userrenametool-submit' => 'Jiberw',
	'userrenametool-errordoesnotexist' => '«<nowiki>$1</nowiki>» degen qatıswşı joq',
	'userrenametool-errorexists' => '«<nowiki>$1</nowiki>» degen qatıswşı bar tüge',
	'userrenametool-errorinvalid' => '«<nowiki>$1</nowiki>» qatıswşı atı jaramsız',
	'userrenametool-errortoomany' => '«<nowiki>$1</nowiki>» qatıswşı $2 üles bergen, $3 arta ülesi bar qatıswşını qaýta atawı torap önimdiligine ıqpal etedi',
	'userrenametool-success' => '«<nowiki>$1</nowiki>» degen qatıswşı atı «<nowiki>$2</nowiki>» degenge awıstırıldı',
	'userrenametool-page-exists' => '$1 degen bet bar tüge, jäne özdik türde onıñ üstine eşteñe jazılmaýdı.',
	'userrenametool-page-moved' => '$1 degen bet $2 degen betke jıljıtıldı.',
	'userrenametool-page-unmoved' => '$1 degen bet $2 degen betke jıljıtılmadı.',
	'userrenametool-logpage' => 'Qatıswşını qaýta ataw jwrnalı',
	'userrenametool-logpagetext' => 'Bul qatıswşı atındağı özgerister jwrnalı',
	'userrenametool-logentry' => '$1 atawın «$2» degenge özgertti',
	'userrenametool-log' => '$1 tüzetwi bar. $2',
	'userrenametool-move-log' => '«[[User:$1|$1]]» degen qatıswşı atın «[[User:$2|$2]]» degenge awısqanda bet özdik türde jıljıtıldı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'renameuser' => 'ប្តូរឈ្មោះអ្នកប្រើប្រាស់',
	'userrenametool-desc' => "ប្តូរឈ្មោះអ្នកប្រើប្រាស់(ត្រូវការសិទ្ធិ ''ប្តូរឈ្មោះអ្នកប្រើប្រាស់'')",
	'userrenametool-old' => 'ឈ្មោះអ្នកប្រើប្រាស់បច្ចុប្បន្ន ៖',
	'userrenametool-new' => 'ឈ្មោះអ្នកប្រើប្រាស់ថ្មី៖',
	'userrenametool-reason' => 'មូលហេតុ៖',
	'userrenametool-move' => 'ប្តូរទីតាំងទំព័រអ្នកប្រើប្រាស់និងទំព័រពិភាក្សា(រួមទាំងទំព័ររងផងដែរ)ទៅឈ្មោះថ្មី',
	'userrenametool-reserve' => 'ហាមឃាត់គណនីចាស់ពីការប្រើប្រាស់នាពេលអនាគត',
	'userrenametool-warnings' => 'បម្រាម​៖',
	'userrenametool-confirm' => 'បាទ/ចាស៎ សូមប្តូរឈ្មោះអ្នកប្រើប្រាស់នេះ',
	'userrenametool-submit' => 'ដាក់ស្នើ',
	'userrenametool-errordoesnotexist' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មិនមាន ។',
	'userrenametool-errorexists' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មានហើយ ។',
	'userrenametool-errorinvalid' => 'ឈ្មោះអ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មិនត្រឹមត្រូវ ។',
	'userrenametool-error-request' => 'មានបញ្ហា​ចំពោះការទទួលសំណើ​។ សូមត្រឡប់ក្រោយ ហើយព្យាយាមម្តងទៀត​។',
	'userrenametool-error-same-user' => 'អ្នកមិនអាចប្តូរឈ្មោះអ្នកប្រើប្រាស់ទៅជាឈ្មោះដូចមុនបានទេ។',
	'userrenametool-success' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" ត្រូវបានប្តូរឈ្មោះទៅ "<nowiki>$2</nowiki>"។',
	'userrenametool-page-exists' => 'ទំព័រ $1 មានហើយ មិនអាចសរសេរជាន់ពីលើដោយស្វ័យប្រវត្តិទេ។',
	'userrenametool-page-moved' => 'ទំព័រ$1ត្រូវបានប្តូរទីតាំងទៅ$2ហើយ។',
	'userrenametool-page-unmoved' => 'ទំព័រ$1មិនអាចប្តូរទីតាំងទៅ$2បានទេ។',
	'userrenametool-logpage' => 'កំនត់ហេតុនៃការប្តូរឈ្មោះអ្នកប្រើប្រាស់',
	'userrenametool-logpagetext' => 'នេះជាកំណត់ហេតុនៃបំលាស់ប្តូរនៃឈ្មោះអ្នកប្រើប្រាស់',
	'userrenametool-logentry' => 'បានប្តូរឈ្មោះ $1 ទៅជា "$2" ហើយ',
	'userrenametool-log' => '{{PLURAL:$1|កំណែប្រែ}}។ ហេតុផល៖ $2',
	'userrenametool-move-log' => 'បានប្តូរទីតាំងទំព័រដោយស្វ័យប្រវត្តិក្នុងខណៈពេលប្តូរឈ្មោះអ្នកប្រើប្រាស់ "[[User:$1|$1]]" ទៅ "[[User:$2|$2]]"',
	'right-renameuser' => 'ប្ដូរឈ្មោះអ្នកប្រើប្រាស់នានា',
);

/** Kannada (ಕನ್ನಡ)
 */
$messages['kn'] = array(
	'renameuser' => 'ಸದಸ್ಯರನ್ನು ಮರುನಾಮಕರಣ ಮಾಡಿ',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 * @author 아라
 */
$messages['ko'] = array(
	'renameuser' => '사용자 이름 바꾸기',
	'userrenametool-desc' => "사용자 이름을 바꾸기 위한 [[Special:UserRenameTool|특수 문서]]를 추가하고 ('''renameuser''' 권한 필요) 및 모든 관련 데이터를 처리합니다",
	'userrenametool-old' => '기존 사용자 이름:',
	'userrenametool-new' => '새 이름:',
	'userrenametool-reason' => '바꾸는 이유:',
	'userrenametool-move' => '사용자 문서와 토론 문서, 하위 문서를 새 사용자 이름으로 이동하기',
	'userrenametool-reserve' => '나중에 이전의 이름이 사용되지 않도록 차단하기',
	'userrenametool-warnings' => '경고:',
	'userrenametool-confirm' => '예, 이름을 변경합니다.',
	'userrenametool-submit' => '사용자 이름 바꾸기',
	'userrenametool-errordoesnotexist' => '‘<nowiki>$1</nowiki>’ 사용자가 존재하지 않습니다.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" 사용자가 이미 존재합니다.',
	'userrenametool-errorinvalid' => '‘<nowiki>$1</nowiki>’ 사용자 이름이 잘못되었습니다.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" 사용자는 기여를 $2번 했습니다. $3번을 넘는 기여를 한 사용자의 이름을 변경하는 것은 성능 저하를 일으킬 수 있습니다.',
	'userrenametool-error-request' => '요청을 보내는 데 문제가 있습니다.
뒤로 가서 다시 시도하세요.',
	'userrenametool-error-same-user' => '이전의 이름과 같은 이름으로는 바꿀 수 없습니다.',
	'userrenametool-success' => '‘<nowiki>$1</nowiki>’ 사용자가 ‘<nowiki>$2</nowiki>’(으)로 변경되었습니다.',
	'userrenametool-page-exists' => '$1 문서가 이미 존재하여 자동으로 이동하지 못했습니다.',
	'userrenametool-page-moved' => '$1 문서를 $2 문서로 옮겼습니다.',
	'userrenametool-page-unmoved' => '$1 문서를 $2 문서로 이동하지 못했습니다.',
	'userrenametool-logpage' => '이름 바꾸기 기록',
	'userrenametool-logpagetext' => '사용자 이름 바꾸기 기록입니다.',
	'userrenametool-logentry' => '$1에서 "$2"(으)로 이름을 바꾸었습니다.',
	'userrenametool-log' => '기여 $1개. 이유: $2',
	'userrenametool-move-log' => '"[[User:$1|$1]]" 사용자를 "[[User:$2|$2]]" 사용자로 바꾸면서 문서를 자동으로 옮겼습니다',
	'right-renameuser' => '사용자 이름 바꾸기',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'renameuser' => 'Metmaacher ömdäufe',
	'userrenametool-desc' => '[[Special:Renameuser|Metmaacher ömdäufe]] — ävver do buch mer et Rääsch „<i lang=en">renameuser</i>“ för.',
	'userrenametool-old' => 'Dä ahle Metmaacher-Name',
	'userrenametool-new' => 'Dä neue Metmaacher-Name',
	'userrenametool-reason' => 'Jrund för et Ömdäufe:',
	'userrenametool-move' => 'De Metmaachersigg met Klaaf- un Ungersigge op dä neue Metmaacher-Name ömstelle',
	'userrenametool-reserve' => 'Donn dä Name fun dämm Metmaacher dobei sperre, dat_e nit norrens neu aanjemelldt weed.',
	'userrenametool-warnings' => 'Warnunge:',
	'userrenametool-confirm' => 'Jo, dunn dä Metmaacher ömbenenne un em singe Name ändere',
	'userrenametool-submit' => 'Ömdäufe!',
	'userrenametool-errordoesnotexist' => 'Ene Metmaacher „<nowiki>$1</nowiki>“ kenne mer nit.',
	'userrenametool-errorexists' => 'Ene Metmaacher met däm Name „<nowiki>$1</nowiki>“ jit et ald.',
	'userrenametool-errorinvalid' => 'Ene Metmaacher-Name eß „<nowiki>$1</nowiki>“ ävver nit, dä wöhr nit richtich.',
	'userrenametool-errortoomany' => 'Dä Metmaacher „<nowiki>$1</nowiki>“ hät {{PLURAL:$2|eine Beidraach|$3 Beidrääsch|keine Beidraach}} zom Wiki jemaat.

<strong>Opjepass:</strong> Esu ene Metmaacher, met mieh wi {{PLURAL:$3|<strong>einem</strong> Beidraach|<strong>$3</strong> Beidrääsch|<strong>keinem</strong> Beidraach}}, ömzedäufe, dat brems et Wiki womööchlesch kräftesch.',
	'userrenametool-error-request' => 'Mer hatte e Problem met Dingem Opdrach.
Bes esu joot un versöök et noch ens.',
	'userrenametool-error-same-user' => 'Do Tuppes! Der ahle un der neue Name es dersellve. Do bengk et Ömdäufe jaanix.',
	'userrenametool-success' => 'Dä Metmaacher „<nowiki>$1</nowiki>“ es jetz op „<nowiki>$2</nowiki>“ ömjedäuf.',
	'userrenametool-page-exists' => 'De Sigg $1 es ald doh, un mer könne se nit automatesch övverschrieve',
	'userrenametool-page-moved' => 'De Sigg wood vun „$1“ op „$2“ ömjenannt.',
	'userrenametool-page-unmoved' => 'Di Sigg „$1“ kunnt nit op „$2“ ömjenannt wääde.',
	'userrenametool-logpage' => 'Logboch vum Metmaacher-Ömdäufe',
	'userrenametool-logpagetext' => 'Dat es et Logboch vun de ömjedäufte Metmaachere',
	'userrenametool-logentry' => 'hät „$1“ op dä Metmaacher „$2“ ömjedäuf',
	'userrenametool-log' => '{{PLURAL:$1|ein Beärbeidung|$1 Beärbeidung|kein Beärbeidung}}. Jrund: $2',
	'userrenametool-move-log' => 'Di Sigg weet automatesch ömjenannt weil mer dä Metmaacher „[[User:$1|$1]]“ op „[[User:$2|$2]]“ öm am däufe sin.',
	'right-renameuser' => 'Metmaacher ömdäufe',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 * @author Ghybu
 */
$messages['ku-latn'] = array(
	'userrenametool' => 'Navê bikarhênerekî biguherîne',
	'renameuser' => 'Navî bikarhênerê biguherîne',
	'userrenametool-old' => 'Navî niha:',
	'userrenametool-new' => 'Navî nuh:',
	'userrenametool-reason' => 'Sedema ji bo navguhertinê:',
	'userrenametool-confirm' => 'Erê, navê vî bikarhênerî biguherîne',
	'userrenametool-submit' => 'Bike',
	'userrenametool-errordoesnotexist' => ' Bikarhêner "<nowiki>$1</nowiki>" tune ye.',
	'userrenametool-errorlocked' => 'Bikarhêner <nowiki>$1</nowiki> hate astengkirin.', # Fuzzy
	'userrenametool-errorbot' => "Bikarhêner <nowiki>$1</nowiki> bot'ek e.",
	'userrenametool-success' => 'Navî bikarhênerê "<nowiki>$1</nowiki>" bû "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-yes' => 'Erê',
	'userrenametool-confirm-no' => 'Na',
	'userrenametool-logpage' => 'Guhertina navê bikarhêner',
	'userrenametool-log' => 'yê $1 beşdarîyên xwe hebû. $2',
);

/** Latin (Latina)
 * @author MF-Warburg
 * @author Rsa23899
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'renameuser' => 'Usorem renominare',
	'userrenametool-old' => 'Praesente nomen usoris:',
	'userrenametool-new' => 'Novum nomen usoris:',
	'userrenametool-reason' => 'Causa renominationis:',
	'userrenametool-move' => 'Movere paginas usoris et disputationis (et subpaginae) in nomen novum',
	'userrenametool-submit' => 'Renominare',
	'userrenametool-errordoesnotexist' => 'Usor "<nowiki>$1</nowiki>" non existit',
	'userrenametool-errorexists' => 'Usor "<nowiki>$1</nowiki>" iam existit',
	'userrenametool-errorinvalid' => 'Nomen usoris "<nowiki>$1</nowiki>" irritum est',
	'userrenametool-errortoomany' => 'Usor "<nowiki>$1</nowiki>" $2 {{PLURAL:$2|recensionem|recensiones}} fecit. Usorem plus quam $3 {{PLURAL:$3|recensionem|recensiones}} habentem renominando hoc vici lentescere potest.',
	'userrenametool-success' => 'Usor "<nowiki>$1</nowiki>" renominatus est in "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-yes' => 'Ita vērō',
	'userrenametool-confirm-no' => 'Minime',
	'userrenametool-page-exists' => 'Pagina $1 iam existit et non potest automatice deleri.',
	'userrenametool-page-moved' => 'Pagina $1 mota est ad $2.',
	'userrenametool-page-unmoved' => 'Pagina $1 ad $2 moveri non potuit.',
	'userrenametool-logpage' => 'Index renominationum usorum',
	'userrenametool-logpagetext' => 'Hic est index renominationum usorum',
	'userrenametool-logentry' => 'renominavit $1 in "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 recensio|$1 recensiones}}. Causa: $2',
	'userrenametool-move-log' => 'movit paginam automatice in renominando usorem "[[User:$1|$1]]" in "[[User:$2|$2]]"',
	'right-renameuser' => 'Usores renominare',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'userrenametool' => 'Engem Benotzer säin Numm änneren',
	'renameuser' => 'Benotzernumm änneren',
	'userrenametool-desc' => "Setzt eng [[Special:UserRenameTool|Spezialsäit]] derbäi fir e Benotzer ëmzebenennen (brauch dofir ''renameuser''-Rechter) an all domat verbonnen Aktiounen duerchzeféieren",
	'userrenametool-old' => 'Aktuelle Benotzernumm:',
	'userrenametool-new' => 'Neie Benotzernumm:',
	'userrenametool-reason' => "Grond fir d'Ëmbenennung:",
	'userrenametool-move' => 'Benotzer- an Diskussiounssäiten (an déi jeweileg Ënnersäiten) op den neie Benotzernumm réckelen',
	'userrenametool-reserve' => 'Den ale Benotzernumm fir de weitere Gebrauch spären',
	'userrenametool-warnings' => 'Warnungen:',
	'userrenametool-confirm' => 'Jo, Benotzer ëmbenennen',
	'userrenametool-submit' => 'Ëmbenennen',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof ass net installéiert.',
	'userrenametool-errordoesnotexist' => 'De Benotzer "<nowiki>$1</nowiki>" gëtt et net.',
	'userrenametool-errorexists' => 'De Benotzer "<nowiki>$1</nowiki>" gët et schonn.',
	'userrenametool-errorinvalid' => 'De Benotzernumm "<nowiki>$1</nowiki>" kann net benotzt ginn.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" ass kee valabelen neie Benotzernumm.',
	'userrenametool-errortoomany' => 'De Benotzer "<nowiki>$1</nowiki>" huet $2 {{PLURAL:$2|Ännerung|Ännerunge}} gemaach. D\'Ännerung vum Benotzernumm vun engem Benotzer mat méi wéi $3 {{PLURAL:$3|Ännerung|Ännerunge}} kann d\'Vitesse vum Site staark beaflossen.',
	'userrenametool-errorlocked' => 'De Benotzer <nowiki>$1</nowiki> ass gespaart.',
	'userrenametool-errorbot' => 'De Benotzer <nowiki>$1</nowiki> ass e Bot.',
	'userrenametool-error-request' => 'Et gouf e Problem mat ärer Ufro.
Gitt w.e.g. zréck a versicht et nach eng Kéier.',
	'userrenametool-error-same-user' => 'Dir kënnt kee Benotzernumm änneren, an him dee selweschte Numm erëmginn.',
	'userrenametool-error-extension-abort' => "Eng Erweiderung léissen d'Ëmbenennen net zou.",
	'userrenametool-warnings-characters' => 'Den neie Benotzernumm huet Zeechen déi net akzeptéiert ginn!',
	'userrenametool-success' => 'De Benotzer "<nowiki>$1</nowiki>" gouf "<nowiki>$2</nowiki>" ëmbenannt.',
	'userrenametool-confirm-intro' => 'Wëllt Dir dat wierklech maachen?',
	'userrenametool-confirm-yes' => 'Jo',
	'userrenametool-confirm-no' => 'Neen',
	'userrenametool-page-exists' => "D'Säit $1 gëtt et schonns a kann net automatesch iwwerschriwwe ginn.",
	'userrenametool-page-moved' => "D'Säit $1 gouf op $2 geréckelt.",
	'userrenametool-page-unmoved' => "D'Säit $1 konnt net op $2 geréckelt ginn.",
	'userrenametool-finished-email-subject' => 'Prozedur vum "Benotzer ëmbenennen" ofgeschloss fir ($1)',
	'userrenametool-logpage' => 'Logbuch vun den Ännerunge vum Benotzernumm',
	'userrenametool-logpagetext' => 'An dësem Logbuch ginn Ännerunge vu Benotzernimm festgehal.',
	'userrenametool-logentry' => 'huet de Benotzer $1 op "$2" ëmbenannt',
	'userrenametool-log' => '{{PLURAL:$1|1 Ännerung|$1 Ännerungen}}. Grond: $2',
	'userrenametool-move-log' => 'Duerch d\'Réckele vum Benotzer "[[User:$1|$1]]" op "[[User:$2|$2]]" goufen déi folgend Säiten automatesch matgeréckelt:',
	'right-renameuser' => 'Benotzer ëmbenennen',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Tibor
 */
$messages['li'] = array(
	'renameuser' => 'Herneum gebroeker',
	'userrenametool-desc' => "Voog 'n [[Special:Renameuser|speciaal pazjwna]] toe óm 'ne gebroeker te hernömme (doe höbs hiej ''renameuser''-rech veur neudig)",
	'userrenametool-old' => 'Hujige gebroekersnaam:',
	'userrenametool-new' => 'Nuje gebroekersnaam:',
	'userrenametool-reason' => 'Ree veur hernömme:',
	'userrenametool-move' => "De gebroekerspazjena en euverlèkpazjena (en eventueel subpazjena's) hernömmme nao de nuje gebroekersnaam",
	'userrenametool-reserve' => 'Veurkómme det de aaje gebroeker opnuuj wörd geregistreerd',
	'userrenametool-warnings' => 'Waarschuwinge:',
	'userrenametool-confirm' => 'Jao, hernaam gebroeker',
	'userrenametool-submit' => 'Hernöm',
	'userrenametool-errordoesnotexist' => 'De gebroeker "<nowiki>$1</nowiki>" besteit neet.',
	'userrenametool-errorexists' => 'De gebroeker "<nowiki>$1</nowiki>" besteit al.',
	'userrenametool-errorinvalid' => 'De gebroekersnaam "<nowiki>$1</nowiki>" is óngeljig.',
	'userrenametool-errortoomany' => 'De gebroeker "<nowiki>$1</nowiki>" haet $2 {{PLURAL:$2|bewèrking|bewèrkinger}}gedaon; \'t hernömme van \'ne gebroeker mit meer es $3 biedraag kan de perstasie van de site naodeilig beïnvloeje.',
	'userrenametool-error-request' => "d'r Woor 'n perbleem bie 't óntvange vanne aanvraog. Lèvver trök te gaon en opnuuj te perbere/",
	'userrenametool-error-same-user' => 'De kèns gein gebroekers herneume nao dezelfde naam.',
	'userrenametool-success' => 'De gebroeker "<nowiki>$1</nowiki>" is hernömp nao "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'De pazjena $1 besteit al en kan neet automatisch euversjreve waere,',
	'userrenametool-page-moved' => 'De pagina $1 is hernömp nao $2.',
	'userrenametool-page-unmoved' => 'De pagina $1 kon neet hernömp waere nao $2.',
	'userrenametool-logpage' => 'Logbook gebroekersnaamwieziginge',
	'userrenametool-logpagetext' => 'Hiejónger staon gebroekersname die verangerdj zeen',
	'userrenametool-logentry' => 'haet $1 hernömp nao "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 bewerking|$1 bewerkinge}}. Ree: $2',
	'userrenametool-move-log' => 'Automatisch hernömp bie \'t wiezige van gebroeker "[[User:$1|$1]]" nao "[[User:$2|$2]]"',
	'right-renameuser' => 'Gebroekers hernaome',
);

/** Lithuanian (lietuvių)
 * @author Homo
 * @author Hugo.arg
 * @author Matasg
 */
$messages['lt'] = array(
	'renameuser' => 'Pervadinti naudotoją',
	'userrenametool-desc' => "Pervadinti naudotoją (reikia ''pervadintojo'' teisių)",
	'userrenametool-old' => 'Esamas naudotojo vardas:',
	'userrenametool-new' => 'Naujas naudotojo vardas:',
	'userrenametool-reason' => 'Pervadinimo priežastis:',
	'userrenametool-move' => 'Perkelti naudotojo ir aptarimo puslapius (bei jo subpuslapius) prie naujo vardo',
	'userrenametool-reserve' => 'Užblokuoti senąjį naudotojo vardą nuo galimybių naudoti ateityje',
	'userrenametool-warnings' => 'Įspėjimai:',
	'userrenametool-confirm' => 'Taip, pervadinti naudotoją',
	'userrenametool-submit' => 'Patvirtinti',
	'userrenametool-errordoesnotexist' => 'Naudotojas "<nowiki>$1</nowiki>" neegzistuoja.',
	'userrenametool-errorexists' => 'Naudotojas "<nowiki>$1</nowiki>" jau egzistuoja.',
	'userrenametool-errorinvalid' => 'Naudotojo vardas "<nowiki>$1</nowiki>" netinkamas.',
	'userrenametool-errortoomany' => 'Naudotojas "<nowiki>$1</nowiki>" yra atlikęs $2 {{PLURAL:$2|pakeitimą|pakeitimų|pakeitimus}}, pervadinat naudotoją, atlikusį daugiau nei $3 {{PLURAL:$2|pakeitimą|pakeitimų|pakeitimus}}, gali būti neigiamai paveiktas tinklalapio darbas.',
	'userrenametool-error-request' => 'Iškilo prašymo gavimo problema.
Prašome eiti atgal ir bandyti iš naujo.',
	'userrenametool-error-same-user' => 'Jūs negalite pervadinti naudotojo į tokį pat vardą, kaip pirmiau.',
	'userrenametool-success' => 'Naudotojas "<nowiki>$1</nowiki>" buvo pervadintas į "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Puslapis $1 jau egzistuoja ir negali būti automatiškai perrašytas.',
	'userrenametool-page-moved' => 'Puslapis $1 buvo perkeltas į $2.',
	'userrenametool-page-unmoved' => 'Puslapis $1 negali būti perkeltas į $2.',
	'userrenametool-logpage' => 'Naudotojų pervadinimo sąrašas',
	'userrenametool-logpagetext' => 'Tai yra naudotojų vardų pakeitimų sąrašas',
	'userrenametool-logentry' => 'pervadintas $1 į „$2“',
	'userrenametool-log' => '{{PLURAL:$1|1 redagavimas|$1 redagavimų(ai)}}. Priežastis: $2',
	'userrenametool-move-log' => 'Puslapis automatiškai perkeltas, kai buvo pervadinamas naudotojas "[[User:$1|$1]]" į "[[User:$2|$2]]"',
	'right-renameuser' => 'Pervadinti naudotojus',
);

/** Latvian (latviešu)
 * @author Xil
 */
$messages['lv'] = array(
	'renameuser' => 'Pārsaukt lietotāju',
	'userrenametool-warnings' => 'Brīdinājumi:',
	'userrenametool-confirm' => 'Jā, pārdēvēt lietotāju',
	'userrenametool-errorexists' => 'Lietotājs "<nowiki>$1</nowiki>" jau ir.',
	'userrenametool-success' => 'Lietotājs "<nowiki>$1</nowiki>" pārdēvēts par "<nowiki>$2</nowiki>".',
	'userrenametool-logpage' => 'Lietotāju pārdēvēšanas reģistrs',
	'userrenametool-logpagetext' => 'Lietotājvārdu maiņas reģistrs',
	'right-renameuser' => 'Pārsaukt lietotājus',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'renameuser' => "Hanova ny anaran'ny mpikambana",
	'userrenametool-confirm' => 'Eny, soloy anarana ilay mpikambana',
	'right-renameuser' => "Manova ny anaran'ny mpikambana",
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 * @author Brest
 * @author Misos
 */
$messages['mk'] = array(
	'userrenametool' => 'Промена на корисничко име',
	'renameuser' => 'Преименувај корисник',
	'userrenametool-warning' => 'Пред да преименувате некој корисник, проверете дали сите податоци се точни, и дека корисникот е свесен дека ова може да потрае извесно време.
Погледајте ја евиденцијата на [[Special:Stafflog|Записникот за персонал]].',
	'userrenametool-desc' => "Додава [[Special:UserRenameTool|специјална страница]] за преименување на корисници (бара право ''renameuser'') и ги обработува сите поврзани податоци",
	'userrenametool-old' => 'Сегашно корисничко име:',
	'userrenametool-new' => 'Ново корисничко име:',
	'userrenametool-encoded' => 'URL-кодирано:',
	'userrenametool-reason' => 'Причина за преименувањето:',
	'userrenametool-move' => 'Премести корисничка страница и страници за разговор (и нивните подстраници) под новото име',
	'userrenametool-reserve' => 'Блокирање на старото корисничко име, да не може да се користи во иднина',
	'userrenametool-notify-renamed' => 'Со завршувањето, испрати е-пошта на преименуваниот корисник',
	'userrenametool-warnings' => 'Предупредувања:',
	'userrenametool-requested-rename' => 'Корисникот $1 има побарано преименување',
	'userrenametool-did-not-request-rename' => 'Корисникот $1 нема побарано преименување',
	'userrenametool-previously-renamed' => 'Корисникот $1 веќе е преименуван',
	'userrenametool-phalanx-matches' => 'Филтри на Phalanx што одговараат на $1:',
	'userrenametool-confirm' => 'Да, преименувај го корисникот',
	'userrenametool-submit' => 'Смени корисничко име',
	'userrenametool-errordoesnotexist' => 'Корисникот "<nowiki>$1</nowiki>" не постои',
	'userrenametool-errorexists' => 'Корисникот "<nowiki>$1</nowiki>" веќе постои',
	'userrenametool-errorinvalid' => '„<nowiki>$1</nowiki>“ не претставува важечко корисничко име.',
	'userrenametool-errorinvalidnew' => 'Корисничкото име „<nowiki>$1</nowiki>“ не е важечко.',
	'userrenametool-errortoomany' => 'Корисникот "<nowiki>$1</nowiki>" има направено $2 {{PLURAL:$2|придонес|придонеси}}, преименување на корисник со повеќе од $3 {{PLURAL:$3|придонес|придонеси}} може негативно да влијае на перформансите на сајтот.',
	'userrenametool-errorprocessing' => 'Постапката за преименување на корисникот <nowiki>$1</nowiki> во <nowiki>$2</nowiki> е веќе во тек.',
	'userrenametool-errorblocked' => 'Корисникот <nowiki>$1</nowiki> е блокиран од <nowiki>$2</nowiki> поради $3.',
	'userrenametool-errorlocked' => 'Корисникот <nowiki>$1</nowiki> е блокиран.',
	'userrenametool-errorbot' => 'Корисникот <nowiki>$1</nowiki> е бот.',
	'userrenametool-error-request' => 'Се јави проблем при примањето на барањето.
Вратете се и обидете се повторно.',
	'userrenametool-error-same-user' => 'Не можете да преименувате во истото име од претходно.',
	'userrenametool-error-extension-abort' => 'Некој додаток ја попречи постапката на преименување.',
	'userrenametool-error-cannot-rename-account' => 'Преименувањето на корисничка сметка на заедничката глобална база на податоци не успеа.',
	'userrenametool-error-cannot-create-block' => 'Создавањето на Phalanx-блок не успеа.',
	'userrenametool-error-cannot-rename-unexpected' => 'Се појави неочекувана грешка. Погледајте во дневниците и обидете се повторно.',
	'userrenametool-warn-repeat' => 'Внимание! Корисникот „<nowiki>$1</nowiki>“ е веќе преименуван во „<nowiki>$2</nowiki>“.
Продолжете со постапката само ако треба да дополните некои податоци што недостасуваат.',
	'userrenametool-warn-table-missing' => 'Табелата „<nowiki>$2</nowiki>“ не постои во базата „<nowiki>$1</nowiki>“.',
	'userrenametool-info-started' => '$1 почна со преименување на: $2 во $3 (записи: $4).
Причина: „$5“.',
	'userrenametool-info-finished' => '$1 заврши со преименување на: $2 во $3 (записи: $4).
Причина: „$5“.',
	'userrenametool-info-failed' => '$1 НЕ УСПЕА во преименувањето на $2 во $3 (записи: $4).
Причина: „$5“.',
	'userrenametool-info-wiki-finished' => '$1 го преименуваше корисникот $2 во $3 на $4.
Причина: „$5“.',
	'userrenametool-info-wiki-finished-problems' => '$1 го преименуваше корисникот $2 во $3 на $4 со грешки.
Причина: „$5“.',
	'userrenametool-info-in-progress' => 'Постапката за преименување е во тек.
Остатокот ќе се одвива во позадина.
Кога ќе заврши, ќе бидете известени по е-пошта.',
	'userrenametool-success' => 'Корисникот "<nowiki>$1</nowiki>" е преименуван во "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'Дали навистина сакате да го направите ова?',
	'userrenametool-confirm-yes' => 'Да',
	'userrenametool-confirm-no' => 'Не',
	'userrenametool-page-exists' => 'Страницата $1 веќе постои и не може автоматски да се презапише.',
	'userrenametool-page-moved' => 'Страницата $1 е преместена на $2.',
	'userrenametool-page-unmoved' => 'Страницата $1 не можеше да се премести на $2.',
	'userrenametool-finished-email-subject' => 'Постапката на преименување корисник е завршена за [$1]',
	'userrenametool-finished-email-body-text' => 'Постапката на преместување на „<nowiki>$1</nowiki>“ во „<nowiki>$2</nowiki>“ е завршена.',
	'userrenametool-finished-email-body-html' => 'Постапката на преместување на „<nowiki>$1</nowiki>“ во „<nowiki>$2</nowiki>“ е завршена.',
	'userrenametool-logpage' => 'Дневник на преименувања на корисници',
	'userrenametool-logpagetext' => 'Ово е дневник на преименувања на корисници',
	'userrenametool-logentry' => 'преименуван $1 во "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 уредување|$1 уредувања}}. Образложение: $2',
	'userrenametool-move-log' => 'Автоматски преместена страница при преименување на корисникот "[[User:$1|$1]]" во "[[User:$2|$2]]"',
	'right-renameuser' => 'Преименување корисници',
	'action-renameuser' => 'преименување на корисници',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'userrenametool' => 'ഉപയോക്താവിന്റെ പേര് മാറ്റുക',
	'renameuser' => 'ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്യുക',
	'userrenametool-desc' => "ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്യാനുള്ള [[Special:UserRenameTool|പ്രത്യേക താൾ]] കൂട്ടിച്ചേർക്കുന്നു (''പുനർനാമകരണ'' അവകാശം വേണം) ഒപ്പം ബന്ധപ്പെട്ട വിവരങ്ങൾ കൈകാര്യം ചെയ്യുന്നു",
	'userrenametool-old' => 'ഇപ്പോഴത്തെ ഉപയോക്തൃനാമം:',
	'userrenametool-new' => 'പുതിയ ഉപയോക്തൃനാമം:',
	'userrenametool-reason' => 'ഉപയോക്തൃനാമം മാറ്റാനുള്ള കാരണം:',
	'userrenametool-move' => 'നിലവിലുള്ള ഉപയോക്തൃതാളും, ഉപയോക്താവിന്റെ സം‌വാദം താളും (സബ് പേജുകള്‍ അടക്കം) പുതിയ നാമത്തിലേക്കു മാറ്റുക.',
	'userrenametool-reserve' => 'പഴയ ഉപയോക്തൃനാമം ഭാവിയിൽ ഉപയോഗിക്കുന്നതു തടയുക',
	'userrenametool-warnings' => 'മുന്നറിയിപ്പുകൾ:',
	'userrenametool-confirm' => 'അതെ, ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്യുക',
	'userrenametool-submit' => 'സമര്‍പ്പിക്കുക',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവ് നിലവിലുണ്ട്.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്തൃനാമം അസാധുവാണ്‌.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്തൃനാമം അസാധുവാണ്‌.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനു ഈ വിക്കിയിൽ {{PLURAL:$2|ഒരു തിരുത്തൽ|$2 തിരുത്തലുകൾ}} ഉണ്ട്, {{PLURAL:$3|ഒരു തിരുത്തലിനു|$3 തിരുത്തലുകൾക്കു}} മുകളിൽ തിരുത്തലുകളുള്ള ഉപയോക്തൃനാമങ്ങളെ പുനർനാമകരണം ചെയ്യുന്നതു ഈ സൈറ്റിന്റെ പ്രവർത്തനത്തെ ദോഷകരമായി ബാധിക്കും.',
	'userrenametool-errorblocked' => 'ഉപയോക്താവ് <nowiki>$1</nowiki> $3 കാലാവധിയിൽ <nowiki>$2</nowiki> തടഞ്ഞിരിക്കുന്നു.',
	'userrenametool-errorlocked' => 'ഉപയോക്താവ് <nowiki>$1</nowiki> ബന്ധിക്കപ്പെട്ടിരിക്കുന്നു.', # Fuzzy
	'userrenametool-errorbot' => 'ഉപയോക്താവ് <nowiki>$1</nowiki> ഒരു യന്ത്രമാണ്.',
	'userrenametool-error-request' => 'അപേക്ഷ സ്വീകരിക്കുമ്പോള്‍ പിഴവ് സം‌ഭവിച്ചു. ദയവായി തിരിച്ചു പോയി വീണ്ടും പരിശ്രമിക്കുക.',
	'userrenametool-error-same-user' => 'നിലവിലുള്ള ഒരു ഉപയോക്തൃനാമത്തിലേക്കു വേറൊരു ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തുവാന്‍ സാധിക്കില്ല.',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനെ "<nowiki>$2</nowiki>" എന്ന നാമത്തിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'userrenametool-confirm-intro' => 'ഇത് ചെയ്യേണ്ട കാര്യം തന്നെയാണോ?',
	'userrenametool-confirm-yes' => 'അതെ',
	'userrenametool-confirm-no' => 'അല്ല',
	'userrenametool-page-exists' => '$1 എന്ന താള്‍ നിലവിലുള്ളതിനാല്‍ അതിനെ യാന്ത്രികമായി മാറ്റാന്‍ കഴിയില്ല.',
	'userrenametool-page-moved' => '$1 എന്ന താള്‍ $2വിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'userrenametool-page-unmoved' => '$1 എന്ന താള്‍ $2 വിലേക്കു മാറ്റാന്‍ സാദ്ധ്യമല്ല.',
	'userrenametool-finished-email-subject' => '[$1] എന്ന ഉപയോക്താവിന്റെ പേരുമാറ്റൽ പ്രക്രിയ പൂർണ്ണമായിരിക്കുന്നു',
	'userrenametool-logpage' => 'ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തിയതിന്റെ പ്രവര്‍ത്തനരേഖ',
	'userrenametool-logpagetext' => 'ഈ പ്രവര്‍ത്തനരേഖ ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തിയതിന്റേതാണ്‌.',
	'userrenametool-logentry' => '$1 എന്ന താള്‍ "$2" എന്ന താളിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'userrenametool-log' => '{{PLURAL:$1|ഒരു തിരുത്തല്‍|$1 തിരുത്തലുകള്‍}}. കാരണം: $2',
	'userrenametool-move-log' => '"[[User:$1|$1]]" എന്ന ഉപയോക്താവിനെ "[[User:$2|$2]]" എന്നു പുനര്‍നാമകരണം ചെയ്തപ്പോള്‍ താള്‍ യാന്ത്രികമായി മാറ്റി.',
	'right-renameuser' => 'ഉപയോക്തൃ പുനർനാമകരണം',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 */
$messages['mr'] = array(
	'userrenametool' => 'सदस्यनाव बदला',
	'renameuser' => 'सदस्यनाम बदला',
	'userrenametool-desc' => "सदस्यनाम बदला (यासाठी तुम्हाला ''सदस्यनाम बदलण्याचे अधिकार'' असणे आवश्यक आहे)",
	'userrenametool-old' => 'सध्याचे सदस्यनाम:',
	'userrenametool-new' => 'नवीन सदस्यनाम:',
	'userrenametool-reason' => 'नाम बदलण्याचे कारण:',
	'userrenametool-move' => 'सदस्य तसेच सदस्य चर्चापान (तसेच त्यांची उपपाने) नवीन सदस्यनामाकडे स्थानांतरीत करा',
	'userrenametool-reserve' => 'जुने सदस्यनाव भविष्यातील वापरासाठी प्रतिबंधित करा',
	'userrenametool-notify-renamed' => 'पूर्ण झाल्यावर नाव बदललेल्या सदस्याला विपत्र पाठवा',
	'userrenametool-submit' => 'पाठवा',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अस्तित्वात नाही.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अगोदरच अस्तित्वात आहे',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" हे नाव चुकीचे आहे.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" हे वैध सदस्यनाव नाही.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" या सदस्याने $2 संपादने केलेली आहेत, $3 पेक्षा जास्त संपादने केलेल्या सदस्यांचे नाव बदलल्यास संकेतस्थळावर प्रश्न निर्माण होऊ शकतात.',
	'userrenametool-errorprocessing' => 'सदस्य <nowiki>$1</nowiki> याची <nowiki>$2</nowiki> या नावाने सदस्यनाव बदलण्याची प्रक्रिया अगोदरच सुरु आहे.',
	'userrenametool-errorbot' => 'सदस्य <nowiki>$1</nowiki> हा एक सांगकाम्या आहे.',
	'userrenametool-error-request' => 'हे काम करताना त्रुटी आढळलेली आहे. कृपया मागे जाऊन परत प्रयत्न करा.',
	'userrenametool-error-same-user' => 'तुम्ही एखाद्या सदस्याला परत पूर्वीच्या नावाकडे बदलू शकत नाही',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" या सदस्याचे नाव "<nowiki>$2</nowiki>" ला बदललेले आहे.',
	'userrenametool-page-exists' => '$1 हे पान अगोदरच अस्तित्वात आहे व आपोआप पुनर्लेखन करता येत नाही.',
	'userrenametool-page-moved' => '$1 हे पान $2 मथळ्याखाली स्थानांतरीत केले.',
	'userrenametool-page-unmoved' => '$1 हे पान $2 मथळ्याखाली स्थानांतरीत करू शकत नाही.',
	'userrenametool-logpage' => 'सदस्यनाम बदल यादी',
	'userrenametool-logpagetext' => 'ही सदस्यनामांमध्ये केलेल्या बदलांची यादी आहे.',
	'userrenametool-logentry' => 'नी $1 ला "$2" केले',
	'userrenametool-log' => '{{PLURAL:$1|१ संपादन|$1 संपादने}}. कारण: $2',
	'userrenametool-move-log' => '"[[User:$1|$1]]" ला "[[User:$2|$2]]" बदलताना आपोआप सदस्य पान स्थानांतरीत केलेले आहे.',
	'right-renameuser' => 'सदस्यांची नावे बदला',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'userrenametool' => 'Tukar nama pengguna',
	'renameuser' => 'Tukar nama pengguna',
	'userrenametool-warning' => 'Sebelum menukar nama pengguna, sila pastikan semua maklumat adalah betul, dan pastikan pengguna itu sedar bahawa ini akan mengambil sedikit masa untuk disiapkan.
Lihat [[Special:Stafflog|log Kakitangan]] untuk lognya.',
	'userrenametool-desc' => "Menukar nama pengguna (memerlukan hak ''renameuser'')",
	'userrenametool-old' => 'Nama semasa:',
	'userrenametool-new' => 'Nama baru:',
	'userrenametool-encoded' => 'URL dikodkan:',
	'userrenametool-reason' => 'Sebab tukar:',
	'userrenametool-move' => 'Pindahkan laman pengguna dan laman perbincangannya (berserta semua sublaman yang ada) ke nama baru',
	'userrenametool-reserve' => 'Pelihara nama pengguna lama supaya tidak digunakan lagi',
	'userrenametool-notify-renamed' => 'Hantarkan e-mel kepada pengguna yang ditukar nama sebaik sahaja siap',
	'userrenametool-warnings' => 'Amaran:',
	'userrenametool-requested-rename' => 'Pengguna $1 memohon penukaran nama',
	'userrenametool-did-not-request-rename' => 'Pengguna $1 tidak memohon penukaran nama',
	'userrenametool-previously-renamed' => 'Pengguna $1 baru menukar namanya',
	'userrenametool-phalanx-matches' => 'Penapis Phalanx yang berpadan dengan $1:',
	'userrenametool-confirm' => 'Ya, tukar nama pengguna ini',
	'userrenametool-submit' => 'Tukar nama pengguna',
	'userrenametool-error-antispoof-conflict' => 'Amaran AntiSpoof - sudah terdapat nama pengguna yang serupa dengan "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof tidak terpasang.',
	'userrenametool-errordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak wujud.',
	'userrenametool-errorexists' => 'Pengguna "<nowiki>$1</nowiki>" telah pun wujud.',
	'userrenametool-errorinvalid' => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" bukan nama pengguna baru yang sah.',
	'userrenametool-errortoomany' => 'Pengguna "<nowiki>$1</nowiki>" mempunyai $2 sumbangan. Penukaran nama pengguna yang mempunyai lebih daripada $3 sumbangan boleh menjejaskan prestasi tapak web ini.',
	'userrenametool-errorprocessing' => 'Proses menukar nama pengguna <nowiki>$1</nowiki> kepada <nowiki>$2</nowiki> sedang diusahakan.',
	'userrenametool-errorblocked' => 'Pengguna <nowiki>$1</nowiki> disekat oleh <nowiki>$2</nowiki> dari $3.',
	'userrenametool-errorlocked' => 'Pengguna <nowiki>$1</nowiki> disekat.',
	'userrenametool-errorbot' => 'Pengguna <nowiki>$1</nowiki> ialah bot.',
	'userrenametool-error-request' => 'Berlaku masalah ketika menerima permintaan anda.
Sila undur dan cuba lagi.',
	'userrenametool-error-same-user' => 'Anda tidak boleh menukar nama pengguna kepada nama yang sama.',
	'userrenametool-error-extension-abort' => 'Proses menukar nama dihalang oleh sambungan.',
	'userrenametool-error-cannot-rename-account' => 'Gagal menukar nama akaun pengguna pada pangkalan data kongsian global.',
	'userrenametool-error-cannot-create-block' => 'Sekatan Phalanx tidak dapat dibentuk.',
	'userrenametool-error-cannot-rename-unexpected' => 'Berlakunya ralat tak dijangka; semak log atau cuba lagi.',
	'userrenametool-warnings-characters' => 'Nama pengguna baru mengandungi aksara terlarang!',
	'userrenametool-warnings-maxlength' => 'Nama pengguna baru tidak boleh melebihi 255 aksara!',
	'userrenametool-warn-repeat' => 'Perhatian! Pengguna "<nowiki>$1</nowiki>" sudah menukar namanya kepada "<nowiki>$2</nowiki>".
Teruskan memproses hanya jika anda perlu menambahkan maklumat yang belum diisi.',
	'userrenametool-warn-table-missing' => 'Jadual "<nowiki>$2</nowiki>" tidak wujud dalam pangkalan data "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 mulai menukar nama: $2 kepada $3 (log: $4).
Sebab: "$5".',
	'userrenametool-info-finished' => '$1 selesai menukar nama: $2 kepada $3 (log: $4).
Sebab: "$5".',
	'userrenametool-info-failed' => '$1 GAGAL menukar nama: $2 kepada $3 (log: $4).
Sebab: "$5".',
	'userrenametool-info-wiki-finished' => '$1 menukar nama $2 kepada $3 di $4.
Sebab: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 menukar nama $2 kepada $3 di $4, tetapi dengan ralat.
Sebab: "$5".',
	'userrenametool-info-in-progress' => 'Proses penukaran nama sedang dijalankan.
Yang selebihnya dilakukan di latar belakang.
Anda akan dimaklumkan melalui e-mel sebaik sahaja ia selesai.',
	'userrenametool-success' => 'Nama "<nowiki>$1</nowiki>" telah ditukar menjadi "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => 'Adakah anda benar-benar ingin melakukannya?',
	'userrenametool-confirm-yes' => 'Ya',
	'userrenametool-confirm-no' => 'Tidak',
	'userrenametool-page-exists' => 'Laman $1 telah pun wujud dan tidak boleh ditulis ganti secara automatik.',
	'userrenametool-page-moved' => 'Laman $1 telah dipindahkan ke $2.',
	'userrenametool-page-unmoved' => 'Laman $1 tidak dapat dipindahkan ke $2.',
	'userrenametool-finished-email-subject' => 'Proses penukaran nama pengguna selesai untuk [$1]',
	'userrenametool-finished-email-body-text' => 'Proses pemindahan "<nowiki>$1</nowiki>" ke "<nowiki>$2</nowiki>" telah selesai.',
	'userrenametool-finished-email-body-html' => 'Proses pemindahan "<nowiki>$1</nowiki>" ke "<nowiki>$2</nowiki>" telah selesai.',
	'userrenametool-logpage' => 'Log penukaran nama pengguna',
	'userrenametool-logpagetext' => 'Ini ialah log penukaran nama pengguna.',
	'userrenametool-logentry' => 'telah menukar nama $1 menjadi "$2"',
	'userrenametool-log' => '$1 suntingan. Sebab: $2',
	'userrenametool-move-log' => 'Memindahkan laman secara automatik ketika menukar nama "[[User:$1|$1]]" menjadi "[[User:$2|$2]]"',
	'right-renameuser' => 'Menukar nama pengguna',
	'action-renameuser' => 'menukar nama pengguna',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'userrenametool-confirm' => "Iva, erġa' semmi l-utent",
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'userrenametool-warnings' => 'သတိပေးချက် :',
	'userrenametool-confirm-yes' => 'လုပ်မည်',
	'userrenametool-confirm-no' => 'မလုပ်ပါ',
	'userrenametool-page-moved' => 'စာမျက်နှာ $1 ကို $2 သို့ ရွှေ့ပြီးပြီ ဖြစ်သည်။',
	'userrenametool-page-unmoved' => 'စာမျက်နှာ $1 ကို $2 သို့ ရွှေ့မရနိုင်ပါ။',
	'right-renameuser' => 'အသုံးပြုသူအား အမည်ပြန်မှည့်ရန်',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'userrenametool-submit' => 'Tiquihuāz',
);

/** Min Nan Chinese (Bân-lâm-gú)
 */
$messages['nan'] = array(
	'renameuser' => 'Kái iōng-chiá ê miâ',
	'userrenametool-page-moved' => '$1 í-keng sóa khì tī $2.',
	'userrenametool-logpagetext' => 'Chit-ê log lia̍t-chhut kái-piàn iōng-chiá miâ-jī ê tōng-chok.',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'userrenametool' => 'Endre en bruker navn',
	'renameuser' => 'Døp om bruker',
	'userrenametool-warning' => 'Før du omdøper en bruker, vennligst sørg for at all informasjon er korrekt, og forsikre deg om at brukeren vet at det kan ta litt tid før handlingen er fullført.
Se [[Special:Stafflog|Ledelsesloggen]] for logger.',
	'userrenametool-desc' => "Legger til en [[Special:UserRenameTool|spesialside]] for å omdøpe en bruker (trenger ''renameuser''-rettigheter) og behandle all relatert data",
	'userrenametool-old' => 'Nåværende navn:',
	'userrenametool-new' => 'Nytt brukernavn:',
	'userrenametool-reason' => 'Grunn for omdøping:',
	'userrenametool-move' => 'Flytt bruker- og brukerdiskusjonssider (og deres undersider) til nytt navn',
	'userrenametool-reserve' => 'Reserver det gamle brukernavnet mot framtidig bruk',
	'userrenametool-notify-renamed' => 'Send en e-post til den omdøpte brukeren når du er ferdig',
	'userrenametool-warnings' => 'Advarsler:',
	'userrenametool-requested-rename' => 'Bruker $1 ba om et navnebytte',
	'userrenametool-did-not-request-rename' => 'Bruker $1 har ikke bedt om et navnebytte',
	'userrenametool-previously-renamed' => 'Brukeren $1 har allerede foretatt et navnebytte',
	'userrenametool-phalanx-matches' => 'Phalanx-filterne sammenligner $1:',
	'userrenametool-confirm' => 'Ja, endre navn på brukeren',
	'userrenametool-submit' => 'Døp om',
	'userrenametool-errordoesnotexist' => 'Brukeren «<nowiki>$1</nowiki>» finnes ikke',
	'userrenametool-errorexists' => 'Brukeren «<nowiki>$1</nowiki>» finnes allerede',
	'userrenametool-errorinvalid' => 'Brukernavnet «<nowiki>$1</nowiki>» er ugyldig',
	'userrenametool-errorinvalidnew' => '«<nowiki>$1</nowiki>» er ikke et gyldig nytt brukernavn.',
	'userrenametool-errortoomany' => 'Brukeren «<nowiki>$1</nowiki>» har $2&nbsp;{{PLURAL:$2|redigering|redigeringer}}. Å døpe om brukere med mer enn $3&nbsp;{{PLURAL:$3|redigering|redigeringer}} vil kunne påvirke sidens ytelse.',
	'userrenametool-errorprocessing' => 'Omdøpingsprosessen for brukeren <nowiki>$1</nowiki> til <nowiki>$2</nowiki> er allerede i gang.',
	'userrenametool-errorblocked' => 'Brukeren <nowiki>$1</nowiki> er blokkert av <nowiki>$2</nowiki> for $3.',
	'userrenametool-errorlocked' => 'Brukeren <nowiki>$1</nowiki> er blokkert.',
	'userrenametool-errorbot' => 'Brukeren <nowiki>$1</nowiki> er en robot.',
	'userrenametool-error-request' => 'Det var et problem med å motte forespørselen. Gå tilbake og prøv igjen.',
	'userrenametool-error-same-user' => 'Du kan ikke gi en bruker samme navn som han/hun allerede har.',
	'userrenametool-error-extension-abort' => 'En utvidelse hindret omdøpningsprosessen.',
	'userrenametool-error-cannot-rename-account' => 'Omdøpning av brukerkonto på den delte globale databasen mislyktes.',
	'userrenametool-error-cannot-create-block' => 'Opprettelse av Phalanx-blokk mislyktes.',
	'userrenametool-warn-repeat' => 'OBS! Brukeren «<nowiki>$1</nowiki>» har allerede blitt omdøpt til «<nowiki>$2</nowiki>».
Fortsett kun hvis du må oppdatere manglende informasjon.',
	'userrenametool-warn-table-missing' => 'Tabellen «<nowiki>$2</nowiki>» eksisterer ikke i databasen «<nowiki>$1</nowiki>.»',
	'userrenametool-info-started' => '$1 begynte å omdøpe: $2 til $3 (logger: $4).
Årsak: «$5».',
	'userrenametool-info-finished' => '$1 fullførte omdøpning: $2 til $3 (logger: $4).
Årsak: «$5».',
	'userrenametool-info-failed' => '$1 MISLYKTES i omdøpning: $2 til $3 (logger: $4).
Årsak: «$5».',
	'userrenametool-info-wiki-finished' => '$1 omdøpte $2 til $3 på $4.
Årsak: «$5».',
	'userrenametool-info-wiki-finished-problems' => '$1 omdøpte $2 til $3 på $4 med feil.
Årsak: «$5».',
	'userrenametool-info-in-progress' => 'Omdøpningsprosessen pågår.
Resten vil bli gjort i bakgrunnen.
Du vil bli varslet via e-post når den er fullført.',
	'userrenametool-success' => 'Brukeren «<nowiki>$1</nowiki>» har blitt omdøpt til «<nowiki>$2</nowiki>»',
	'userrenametool-confirm-intro' => 'Vil du virkelig gjøre dette?',
	'userrenametool-confirm-yes' => 'Ja',
	'userrenametool-confirm-no' => 'Nei',
	'userrenametool-page-exists' => 'Siden $1 finnes allerede, og kunne ikke erstattes automatisk.',
	'userrenametool-page-moved' => 'Siden $1 har blitt flyttet til $2.',
	'userrenametool-page-unmoved' => 'Siden $1 kunne ikke flyttes til $2.',
	'userrenametool-finished-email-subject' => 'Omdøpningsprosess av bruker fullført for [$1]',
	'userrenametool-finished-email-body-text' => 'Flytningsprosessen for «<nowiki>$1</nowiki>» til «<nowiki>$2</nowiki>» er fullført.',
	'userrenametool-finished-email-body-html' => 'Flytningsprosessen for «<nowiki>$1</nowiki>» til «<nowiki>$2</nowiki>» er fullført.',
	'userrenametool-logpage' => 'Omdøpingslogg',
	'userrenametool-logpagetext' => 'Dette er en logg over endringer i brukernavn.',
	'userrenametool-logentry' => 'endret navn på $1 til «$2»',
	'userrenametool-log' => '{{PLURAL:$1|Én redigering|$1 redigeringer}}. Grunn: $2',
	'userrenametool-move-log' => 'Flyttet side automatisk under omdøping av brukeren «[[User:$1|$1]]» til «[[User:$2|$2]]»',
	'right-renameuser' => 'Døpe om brukere',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'renameuser' => 'Brukernaam ännern',
	'userrenametool-desc' => "Föögt en [[Special:Renameuser|Spezialsied]] to för dat Ne’en-Naam-Geven för Brukers (''renameuser''-Recht nödig)",
	'userrenametool-old' => 'Brukernaam nu:',
	'userrenametool-new' => 'Nee Brukernaam:',
	'userrenametool-reason' => 'Gründ för den ne’en Naam:',
	'userrenametool-move' => 'Brukersieden op’n ne’en Naam schuven',
	'userrenametool-reserve' => 'Den olen Brukernaam dor vör schulen, dat he noch wedder nee anmellt warrt',
	'userrenametool-warnings' => 'Wohrschauels:',
	'userrenametool-confirm' => 'Jo, den Bruker en ne’en Naam geven',
	'userrenametool-submit' => 'Ännern',
	'userrenametool-errordoesnotexist' => "Bruker ''<nowiki>$1</nowiki>'' gifft dat nich",
	'userrenametool-errorexists' => "Bruker ''<nowiki>$1</nowiki>'' gifft dat al",
	'userrenametool-errorinvalid' => "Brukernaam ''<nowiki>$1</nowiki>'' geiht nich",
	'userrenametool-errortoomany' => "Bruker ''<nowiki>$1</nowiki>'' hett $2 {{PLURAL:$2|Bidrag|Bidrääg}}. Den Naam ännern kann bi Brukers mit mehr as $3 {{PLURAL:$2|Bidrag|Bidrääg}} de Software lahm maken.",
	'userrenametool-error-request' => 'Dat geev en Problem bi’t Överdragen vun de Anfraag. Gah trüch un versöök dat noch wedder.',
	'userrenametool-error-same-user' => 'De ole un ne’e Brukernaam sünd gliek.',
	'userrenametool-success' => "Brukernaam ''<nowiki>$1</nowiki>'' op ''<nowiki>$2</nowiki>'' ännert",
	'userrenametool-page-exists' => 'Siet $1 gifft dat al un kann nichautomaatsch överschreven warrn.',
	'userrenametool-page-moved' => 'Siet $1 schaven na $2.',
	'userrenametool-page-unmoved' => 'Siet $1 kunn nich na $2 schaven warrn.',
	'userrenametool-logpage' => 'Ännerte-Brukernaams-Logbook',
	'userrenametool-logpagetext' => 'Dit is dat Logbook för ännerte Brukernaams',
	'userrenametool-logentry' => 'hett „$1“ ne’en Naam „$2“ geven',
	'userrenametool-log' => '{{PLURAL:$1|1 Ännern|$1 Ännern}}. Grund: $2',
	'userrenametool-move-log' => "Siet bi dat Ännern vun’n Brukernaam ''[[User:$1|$1]]'' na ''[[User:$2|$2]]'' automaatsch schaven",
	'right-renameuser' => 'Brukers ne’en Naam geven',
);

/** Low Saxon (Netherlands) (Nedersaksies)
 */
$messages['nds-nl'] = array(
	'renameuser' => 'Gebruker herneumen',
);

/** Nepali (नेपाली)
 */
$messages['ne'] = array(
	'userrenametool-old' => 'अहिलेको प्रयोगकर्ता नाम:',
	'userrenametool-new' => 'नयाँ प्रयोगकर्ता नाम:',
);

/** Dutch (Nederlands)
 * @author Effeietsanders
 * @author Jochempluim
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 * @author Southparkfan
 */
$messages['nl'] = array(
	'userrenametool' => 'Gebruikersnaam wijzigen',
	'renameuser' => 'Gebruiker hernoemen',
	'userrenametool-warning' => 'Zorg ervoor dat alle informatie correct is voordat u een gebruiker hernoemt en zorg dat de gebruiker weet dat het wat tijd kost om alles door te voeren.
Zie ook het [[Special:Stafflog|Staflogboek]].',
	'userrenametool-desc' => "Voegt een [[Special:UserRenameTool|speciale pagina]] toe om een gebruiker te hernoemen (u hebt hiervoor het recht ''renameuser'' nodig)",
	'userrenametool-old' => 'Huidige gebruikersnaam:',
	'userrenametool-new' => 'Nieuwe gebruikersnaam:',
	'userrenametool-encoded' => 'URL gecodeerd:',
	'userrenametool-reason' => 'Reden voor hernoemen:',
	'userrenametool-move' => "De gebruikerspagina en overlegpagina (en eventuele subpagina's) hernoemen naar de nieuwe gebruikersnaam",
	'userrenametool-reserve' => 'Voorkomen dat de oude gebruiker opnieuw wordt geregistreerd',
	'userrenametool-notify-renamed' => 'E-mail verzenden naar hernoemde gebruiker als het proces is afgerond',
	'userrenametool-warnings' => 'Waarschuwingen:',
	'userrenametool-requested-rename' => 'Gebruiker $1 heeft een hernoeming aangevraagd',
	'userrenametool-did-not-request-rename' => 'Gebruiker $1 heeft geen hernoeming aangevraagd',
	'userrenametool-previously-renamed' => 'Gebruiker $1 is al hernoemd',
	'userrenametool-phalanx-matches' => 'Phalanxfilters die overeenkomen met $1:',
	'userrenametool-confirm' => 'Ja, hernoem de gebruiker',
	'userrenametool-submit' => 'Hernoemen',
	'userrenametool-error-antispoof-conflict' => 'AntiSpoof waarschuwing - er is al een gebruikersnaam die lijkt op "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof is niet geïnstalleerd.',
	'userrenametool-errordoesnotexist' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat niet.',
	'userrenametool-errorexists' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat al.',
	'userrenametool-errorinvalid' => 'De gebruikersnaam "<nowiki>$1</nowiki>" is ongeldig.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" is geen geldige nieuwe gebruikersnaam.',
	'userrenametool-errortoomany' => 'De gebruiker "<nowiki>$1</nowiki>" heeft $2 {{PLURAL:$2|bewerking|bewerkingen}} gedaan; het hernoemen van een gebruiker met meer dan $3 {{PLURAL:$2|bewerking|bewerkingen}} kan de prestaties van de site nadelig beïnvloeden.',
	'userrenametool-errorprocessing' => 'Het naamswijzigingsproces voor gebruiker <nowiki>$1</nowiki> naar <nowiki>$2</nowiki> draait al.',
	'userrenametool-errorblocked' => 'Gebruiker <nowiki>$1</nowiki> is geblokkeerd door <nowiki>$2</nowiki> voor $3.',
	'userrenametool-errorlocked' => 'Gebruiker <nowiki>$1</nowiki> is geblokkeerd.',
	'userrenametool-errorbot' => 'Gebruiker <nowiki>$1</nowiki> is een robot.',
	'userrenametool-error-request' => 'Er was een probleem bij het ontvangen van de aanvraag. Gelieve terug te gaan en opnieuwe te proberen.',
	'userrenametool-error-same-user' => 'U kunt geen gebruiker hernoemen naar dezelfde naam.',
	'userrenametool-error-extension-abort' => 'Een extensie heeft de naamswijziging verhinderd.',
	'userrenametool-error-cannot-rename-account' => 'De naamswijziging op de gedeelde globale database is mislukt.',
	'userrenametool-error-cannot-create-block' => 'Het aanmaken van de Phalanx-blokkade is mislukt.',
	'userrenametool-error-cannot-rename-unexpected' => 'Er is een onverwachte fout opgetreden. Controleer de logboeken of probeer het opnieuw.',
	'userrenametool-warnings-characters' => 'De nieuwe gebruikersnaam bevat ongeldige tekens!',
	'userrenametool-warnings-maxlength' => 'De lengte van de nieuwe gebruikersnaam mag niet langer zijn dan 255 tekens!',
	'userrenametool-warn-repeat' => 'Let op! De gebruikersnaam "<nowiki>$1</nowiki>" is al gewijzigd in "<nowiki>$2</nowiki>".
Ga alleen door met de verwerking als u missende gegevens wilt bijwerken.',
	'userrenametool-warn-table-missing' => 'De tabel "<nowiki>$2</nowiki>" bestaat niet in de database "<nowiki>$1</nowiki>".',
	'userrenametool-info-started' => '$1 heeft een naamswijziging gestart: $2 naar $3 (logboeken: $4).
Reden: "$5".',
	'userrenametool-info-finished' => '$1 heeft een naamswijziging afgerond: $2 naar $3 (logboeken: $4).
Reden: "$5".',
	'userrenametool-info-failed' => 'De naamswijziging door $1 is mislukt: $2 naar $3 (logboeken: $4).
Reden: "$5".',
	'userrenametool-info-wiki-finished' => '$1 heeft de gebruikersnaam $2 gewijzigd naar $3 op $4.
Reden: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 heeft de gebruikersnaam $2 met fouten gewijzigd naar $3 op $4.
Reden: "$5".',
	'userrenametool-info-in-progress' => 'De naamswijziging wordt uitgevoerd.
De rest wordt gedaan in de achtergrond.
U wordt per e-mail op de hoogte gesteld als het proces is afgerond.',
	'userrenametool-success' => 'De gebruiker "<nowiki>$1</nowiki>" is hernoemd naar "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => 'Weet u zeker dat u dit wilt uitvoeren?',
	'userrenametool-confirm-yes' => 'Ja',
	'userrenametool-confirm-no' => 'Nee',
	'userrenametool-page-exists' => 'De pagina $1 bestaat al en kan niet automatisch overschreven worden.',
	'userrenametool-page-moved' => 'De pagina $1 is hernoemd naar $2.',
	'userrenametool-page-unmoved' => 'De pagina $1 kon niet hernoemd worden naar $2.',
	'userrenametool-finished-email-subject' => 'De gebruikersnaamwijziging voor [$1] is afgerond',
	'userrenametool-finished-email-body-text' => 'De gebruikersnaamwijziging voor "<nowiki>$1</nowiki>" naar "<nowiki>$2</nowiki>" is afgerond.',
	'userrenametool-finished-email-body-html' => 'De gebruikersnaamwijziging voor "<nowiki>$1</nowiki>" naar "<nowiki>$2</nowiki>" is afgerond.',
	'userrenametool-logpage' => 'Logboek gebruikersnaamwijzigingen',
	'userrenametool-logpagetext' => 'Hieronder staan gebruikersnamen die gewijzigd zijn',
	'userrenametool-logentry' => 'heeft $1 hernoemd naar "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 bewerking|$1 bewerkingen}}. Reden: $2',
	'userrenametool-move-log' => 'Automatisch hernoemd bij het wijzigen van gebruiker "[[User:$1|$1]]" naar "[[User:$2|$2]]"',
	'right-renameuser' => 'Gebruikers hernoemen',
	'action-renameuser' => 'gebruikers te hernoemen',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'userrenametool-error-same-user' => 'Je kunt geen gebruiker hernoemen naar dezelfde naam.',
	'userrenametool-warn-repeat' => 'Let op! De gebruikersnaam "<nowiki>$1</nowiki>" is al gewijzigd in "<nowiki>$2</nowiki>".
Ga alleen door met de verwerking als je missende gegevens wilt bijwerken.',
	'userrenametool-info-in-progress' => 'De naamswijziging wordt uitgevoerd.
De rest wordt gedaan in de achtergrond.
Je wordt per e-mail op de hoogte gesteld als het proces is afgerond.',
	'userrenametool-confirm-intro' => 'Weet je zeker dat je dit wilt uitvoeren?',
);

/** Norwegian Nynorsk (norsk nynorsk)
 * @author Harald Khan
 * @author Njardarlogar
 */
$messages['nn'] = array(
	'renameuser' => 'Døyp om brukar',
	'userrenametool-desc' => "Legg til ei [[Special:Renameuser|spesialsida]] for å døypa om ein brukar (krev ''renameuser''-rettar)",
	'userrenametool-old' => 'Brukarnamn no:',
	'userrenametool-new' => 'Nytt brukarnamn:',
	'userrenametool-reason' => 'Årsak for omdøyping:',
	'userrenametool-move' => 'Flytt brukar- og brukardiskusjonssider (og undersidene deira) til nytt namn',
	'userrenametool-reserve' => 'Blokker det gamle brukarnamnet for framtidig bruk',
	'userrenametool-warnings' => 'Åtvaringar:',
	'userrenametool-confirm' => 'Ja, endra namn på brukaren',
	'userrenametool-submit' => 'Utfør',
	'userrenametool-errordoesnotexist' => 'Brukaren «<nowiki>$1</nowiki>» finst ikkje.',
	'userrenametool-errorexists' => 'Brukaren «<nowiki>$1</nowiki>» finst allereie.',
	'userrenametool-errorinvalid' => 'Brukarnamnet «<nowiki>$1</nowiki>» er ikkje gyldig.',
	'userrenametool-errortoomany' => 'Brukaren «<nowiki>$1</nowiki>» har {{PLURAL:$2|eitt bidrag|$2 bidrag}}. Å døypa om ein brukar med meir enn {{PLURAL:$3|eitt bidrag|$3 bidrag}} vil kunna påverka sida si yting negativt.',
	'userrenametool-error-request' => 'Det var eit problem med å motta førespurnaden.
Gå attende og prøv på nytt.',
	'userrenametool-error-same-user' => 'Du kan ikkje gje ein brukar same namn som han/ho har frå før.',
	'userrenametool-success' => 'Brukaren «<nowiki>$1</nowiki>» har fått brukarnamnet endra til «<nowiki>$2</nowiki>»',
	'userrenametool-page-exists' => 'Sida $1 finst allereie og kan ikkje automatisk verta skrive over.',
	'userrenametool-page-moved' => 'Sida $1 har vorte flytta til $2.',
	'userrenametool-page-unmoved' => 'Sida $1 kunne ikkje verta flytta til $2.',
	'userrenametool-logpage' => 'Logg over brukarnamnendringar',
	'userrenametool-logpagetext' => 'Logg over endringar av brukarnamn',
	'userrenametool-logentry' => 'endra $1 til «$2»',
	'userrenametool-log' => '{{PLURAL:$1|eitt bidrag|$1 bidrag}}. Årsak: $2',
	'userrenametool-move-log' => 'Flytta sida automatisk under omdøyping av brukaren «[[User:$1|$1]]» til «[[User:$2|$2]]»',
	'right-renameuser' => 'Døypa om brukarar',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'renameuser' => 'Fetola leina la mošomiši',
	'userrenametool-old' => 'Leina la bjale la mošomiši:',
	'userrenametool-new' => 'Leina le lempsha la mošomiši:',
	'userrenametool-reason' => 'Lebaka lago fetola leina:',
	'userrenametool-page-moved' => 'Letlakala $1 le hudušitšwe go $2',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'renameuser' => "Tornar nomenar l'utilizaire",
	'userrenametool-desc' => "Torna nomenar un utilizaire (necessita los dreches de ''renameuser'')",
	'userrenametool-old' => "Nom actual de l'utilizaire :",
	'userrenametool-new' => "Nom novèl de l'utilizaire :",
	'userrenametool-reason' => 'Motiu del cambiament de nom :',
	'userrenametool-move' => 'Desplaçar totas las paginas de l’utilizaire cap al nom novèl',
	'userrenametool-reserve' => 'Reservar lo nom ancian per un usatge futur',
	'userrenametool-warnings' => 'Avertiments :',
	'userrenametool-confirm' => 'Òc, tornar nomenar l’utilizaire',
	'userrenametool-submit' => 'Sometre',
	'userrenametool-errordoesnotexist' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » es pas valid",
	'userrenametool-errorexists' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » existís ja",
	'userrenametool-errorinvalid' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » existís pas",
	'userrenametool-errortoomany' => "L'utilizaire « <nowiki>$1</nowiki> » a $2 {{PLURAL:$2|contribucion|contribucions}}. Tornar nomenar un utilizaire qu'a mai de $3 {{PLURAL:$3|contribucion|contribucions}} a son actiu pòt afectar las performanças del sit.",
	'userrenametool-error-request' => 'Un problèma existís amb la recepcion de la requèsta. Tornatz en rèire e ensajatz tornamai.',
	'userrenametool-error-same-user' => 'Podètz pas tornar nomenar un utilizaire amb la meteissa causa deperabans.',
	'userrenametool-success' => "L'utilizaire « <nowiki>$1</nowiki> » es plan estat renomenat en « <nowiki>$2</nowiki> »",
	'userrenametool-page-exists' => 'La pagina $1 existís ja e pòt pas èsser remplaçada automaticament.',
	'userrenametool-page-moved' => 'La pagina $1 es estada desplaçada cap a $2.',
	'userrenametool-page-unmoved' => 'La pagina $1 pòt pas èsser renomenada en $2.',
	'userrenametool-logpage' => "Istoric dels cambiaments de nom d'utilizaire",
	'userrenametool-logpagetext' => "Aquò es l'istoric dels cambiaments de nom dels utilizaires",
	'userrenametool-logentry' => 'a renomenat $1 en "$2"',
	'userrenametool-log' => '$1 {{PLURAL:$1|edicion|edicions}}. Motiu : $2',
	'userrenametool-move-log' => 'Pagina desplaçada automaticament al moment del cambiament de nom de l’utilizaire "[[User:$1|$1]]" en "[[User:$2|$2]]"',
	'right-renameuser' => "Tornar nomenar d'utilizaires",
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'renameuser' => 'Архайæджы ном баив',
	'userrenametool-old' => 'Ныры ном:',
	'userrenametool-new' => 'Ног ном:',
	'userrenametool-reason' => 'Ном ивыны аххос:',
	'userrenametool-submit' => 'Афтæ уæд',
	'userrenametool-logpage' => 'Архайджыты нæмттæ ивыны лог',
);

/** Picard (Picard)
 */
$messages['pcd'] = array(
	'renameuser' => "Canger ch'nom d'uzeu",
	'right-renameuser' => 'Érlonmer chés uzeus',
);

/** Deitsch (Deitsch)
 */
$messages['pdc'] = array(
	'renameuser' => 'Naame vum Yuuser ennere',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 * @author SPS
 */
$messages['pfl'] = array(
	'userrenametool-submit' => 'Benutzer umbenenne',
	'userrenametool-confirm-yes' => 'Ja',
	'userrenametool-confirm-no' => 'Nä',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Chrumps
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Sovq
 * @author Sp5uhe
 * @author WarX
 * @author Woytecr
 * @author Wpedzich
 */
$messages['pl'] = array(
	'userrenametool' => 'Zmień nazwę użytkownika',
	'renameuser' => 'Zmiana nazwy użytkownika',
	'userrenametool-warning' => 'Przed zmianą nazwy użytkownika, upewnij się że wszystkie informacje są poprawne i że użytkownik wie, że może to trochę potrwać.
Zobacz [[Special:Stafflog|Staff log]] aby sprawdzić logi.',
	'userrenametool-desc' => "Dodaje [[Special:UserRenameTool|stronę specjalną]] służącą do zmiany nazwy użytkownika. (wymaga posiadania uprawnień ''renameuser'')",
	'userrenametool-old' => 'Obecna nazwa użytkownika:',
	'userrenametool-new' => 'Nowa nazwa użytkownika:',
	'userrenametool-encoded' => 'Wersja URL encoded:',
	'userrenametool-reason' => 'Przyczyna zmiany nazwy:',
	'userrenametool-move' => 'Przeniesienie strony i dyskusji użytkownika (oraz ich podstron) pod nową nazwę użytkownika',
	'userrenametool-reserve' => 'Zablokuj starą nazwę użytkownika przed możliwością użycia jej',
	'userrenametool-notify-renamed' => 'Po zakończeniu wyślij e-mail do użytkownika, któremu zmieniasz nazwę',
	'userrenametool-warnings' => 'Ostrzeżenia:',
	'userrenametool-requested-rename' => 'Użytkownik $1 poprosił o zmianę nazwy',
	'userrenametool-did-not-request-rename' => 'Użytkownik $1 nie prosił o zmianę nazwy',
	'userrenametool-previously-renamed' => 'Nazwa użytkownika $1 została już wcześniej zmieniona',
	'userrenametool-phalanx-matches' => 'Filtry Phalanx z $1:',
	'userrenametool-confirm' => 'Zmień nazwę użytkownika',
	'userrenametool-submit' => 'Zmień',
	'userrenametool-error-antispoof-conflict' => 'Ostrzeżenie AntiSpoof - istnieje już nazwa użytkownika podobna do "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof nie jest zainstalowany.',
	'userrenametool-errordoesnotexist' => 'Użytkownik „<nowiki>$1</nowiki>” nie istnieje',
	'userrenametool-errorexists' => 'Użytkownik „<nowiki>$1</nowiki>” już istnieje',
	'userrenametool-errorinvalid' => 'Niepoprawna nazwa użytkownika „<nowiki>$1</nowiki>”',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" nie jest prawidłową nową nazwą użytkownika.',
	'userrenametool-errortoomany' => 'Użytkownik „<nowiki>$1</nowiki>” ma {{PLURAL:$2|1 edycję|$2 edycje|$2 edycji}}. Zmiana nazwy użytkownika mającego powyżej $3 {{PLURAL:$3|edycji|edycji}} może wpłynąć na wydajność serwisu.',
	'userrenametool-errorprocessing' => 'Proces zmiany nazwy użytkownika <nowiki>$1</nowiki> na <nowiki>$2</nowiki> jest w toku.',
	'userrenametool-errorblocked' => 'Użytkownik <nowiki>$1</nowiki> został zablokowany przez <nowiki>$2</nowiki> za $3',
	'userrenametool-errorlocked' => 'Użytkownik <nowiki>$1</nowiki> jest zablokowany.',
	'userrenametool-errorbot' => 'Użytkownik <nowiki>$1</nowiki> jest botem.',
	'userrenametool-error-request' => 'Wystąpił problem z odbiorem żądania.
Wróć i spróbuj jeszcze raz.',
	'userrenametool-error-same-user' => 'Nie możesz zmienić nazwy użytkownika na taką samą jaka była wcześniej.',
	'userrenametool-error-extension-abort' => 'Inne rozszerzenie zablokowało proces zmiany nazwy.',
	'userrenametool-error-cannot-rename-account' => 'Zmiana nazwy użytkownika w globalnej bazie danych nie powiodła się.',
	'userrenametool-error-cannot-create-block' => 'Tworzenie bloku Phalanx nie powiodło się.',
	'userrenametool-error-cannot-rename-unexpected' => 'Wystąpił nieoczekiwany błąd, sprawdź logi lub spróbuj ponownie.',
	'userrenametool-warnings-characters' => 'Nowa nazwa użytkownika zawiera niedozwolone znaki!',
	'userrenametool-warnings-maxlength' => 'Nowa nazwa użytkownika nie może przekraczać 255 znaków!',
	'userrenametool-warn-repeat' => 'Uwaga! Nazwa użytkownika "<nowiki>$1</nowiki>" została już zmieniona na "<nowiki>$2</nowiki>".
Kontynuuj jedynie jeśli musisz dodać brakujące informacje.',
	'userrenametool-warn-table-missing' => 'Tabela "<nowiki>$2</nowiki>" nie istnieje w bazie danych "<nowiki>$1</nowiki>.”',
	'userrenametool-info-started' => '$1 rozpoczął zmianę nazwy: $2 na $3 (logi:  $4).
Przyczyna: "$5".',
	'userrenametool-info-finished' => '$1 ukończył zmianę nazwy: $2 na $3 (logi:  $4).
Przyczyna: "$5".',
	'userrenametool-info-failed' => '$1 NIE ZMIENIŁ nazwy: $2 na $3 (logi:  $4).
Przyczyna: "$5".',
	'userrenametool-info-wiki-finished' => '$1 zmienił nazwę $2 na $3 na $4.
Przyczyna: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 zmienił nazwę $2 na $3 na $4 z błędami.
Przyczyna: "$5".',
	'userrenametool-info-in-progress' => 'Zmiana nazwy jest w toku.
Reszta zostanie wykonana w tle.
Zostaniesz powiadomiony e-mailem o jej zakończeniu.',
	'userrenametool-success' => 'Nazwa użytkownika „$1” została zmieniona na „$2”',
	'userrenametool-confirm-intro' => 'Na pewno chcesz to zrobić?',
	'userrenametool-confirm-yes' => 'Tak',
	'userrenametool-confirm-no' => 'Nie',
	'userrenametool-page-exists' => 'Strona „$1” już istnieje i nie może być automatycznie nadpisana.',
	'userrenametool-page-moved' => 'Strona „$1” została przeniesiona pod nazwę „$2”.',
	'userrenametool-page-unmoved' => 'Strona „$1” nie mogła zostać przeniesiona pod nazwę „$2”.',
	'userrenametool-finished-email-subject' => 'Proces zmiany nazwy użytkownika zakończony dla [$1]',
	'userrenametool-finished-email-body-text' => 'Proces przenoszenia "<nowiki>$1</nowiki>" do "<nowiki>$2</nowiki>" został zakończony.',
	'userrenametool-finished-email-body-html' => 'Proces przenoszenia "<nowiki>$1</nowiki>" do "<nowiki>$2</nowiki>" został zakończony.',
	'userrenametool-logpage' => 'Zmiany nazw użytkowników',
	'userrenametool-logpagetext' => 'To jest rejestr zmian nazw użytkowników',
	'userrenametool-logentry' => 'zmienił nazwę użytkownika $1 na „$2”',
	'userrenametool-log' => '$1 {{PLURAL:$1|edycja|edycje|edycji}}.
Powód: $2',
	'userrenametool-move-log' => 'Automatyczne przeniesienie stron użytkownika po zmianie nazwy konta z „[[User:$1|$1]]” na „[[User:$2|$2]]”',
	'right-renameuser' => 'Zmiana nazw kont użytkowników',
	'action-renameuser' => 'zmiana nazwy użytkownika',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'userrenametool' => "Cangé lë stranòm ëd n'utent",
	'renameuser' => "Arbatié n'utent",
	'userrenametool-warning' => "<strong>Për piasì, ch'a lesa con atension j'anformassion sì-dapress</strong>:<p>Prima d'arbatié n'utent, për piasì ch'as sigura che <strong>tute j'anformassion a sio giuste</strong>, e ch'as sigura che <strong>l'utent a sapia che a peul andeje dël temp për completé l'operassion</strong>.
<br />Për piasì, ch'a ten-a da ment che për dle rason esterne la prima part dël process <strong>a podrìa arzulté ant na pàgina veuida</strong>, che a veul pa dì che ël process a l'abia nen marcià bin.</p><p>A peul controlé 'me ch'as dësrola ël process për mojen dël [[Special:Stafflog|registr dl'Echip]], an dzorpì <strong>ël sistema a-j manderà un mëssagi quand tuta la procedura d'arbatiament a sarà completà</strong>.</p>",
	'userrenametool-desc' => "A gionta na [[Special:UserRenameTool|pàgina special]] për arbatié n'utent (a-i va ël drit «renameuser») e për traté tùit ij dat relativ",
	'userrenametool-old' => 'Stranòm corent:',
	'userrenametool-new' => 'Stranòm neuv:',
	'userrenametool-reason' => "Rason ch'as cambia stranòm:",
	'userrenametool-move' => 'Tramuda ëdcò la pàgina utent e cola dle ciaciarade (con tute soe sotapàgine) a lë stranòm neuv',
	'userrenametool-reserve' => 'Blòca lë stanòm vej da future utilisassion',
	'userrenametool-notify-renamed' => "Mandeje un mëssagi a l'utent arbatià na vira che l'operassion a l'é livrà",
	'userrenametool-warnings' => 'Atension:',
	'userrenametool-requested-rename' => "L'utent $1 a l'ha ciamà d'esse arbatià",
	'userrenametool-did-not-request-rename' => "L'utent $1 a l'ha pa ciamà d'esse arbatià",
	'userrenametool-previously-renamed' => "L'utent $1 a l'é già stàit arbatià",
	'userrenametool-phalanx-matches' => 'Filtr ëd polpiss corispondent a $1:',
	'userrenametool-confirm' => "É!, arnòmina l'utent",
	'userrenametool-submit' => 'Falo',
	'userrenametool-errordoesnotexist' => 'A-i é pa gnun utent ch\'as ës-ciama "<nowiki>$1</nowiki>"',
	'userrenametool-errorexists' => 'N\'utent ch\'as ës-ciama "<nowiki>$1</nowiki>" a-i é già',
	'userrenametool-errorinvalid' => 'Lë stranòm "<nowiki>$1</nowiki>" a l\'é nen bon',
	'userrenametool-errorinvalidnew' => "«<nowiki>$1</nowiki>» a l'é pa në stranòm neuv d'utent bon.",
	'userrenametool-errortoomany' => "L'utent \"<nowiki>\$1</nowiki>\" a l'ha fait \$2 modìfiche, ch'a ten-a present che arbatié n'utent ch'a l'abia pì che \$3 modìfiche a podrìa feje un brut efet a le prestassion dël sit.",
	'userrenametool-errorprocessing' => "Ël process d'arbatiagi për l'utent <nowiki>$1</nowiki> a <nowiki>$2</nowiki> a l'é già an camin.",
	'userrenametool-errorblocked' => "L'utent <nowiki>$1</nowiki> a l'é blocà da <nowiki>$2</nowiki> për $3.",
	'userrenametool-errorlocked' => "L'utent <nowiki>$1</nowiki> a l'é blocà.",
	'userrenametool-errorbot' => "L'utent <nowiki>$1</nowiki> a l'é un trigomiro.",
	'userrenametool-error-request' => "A-i é staje un problema ant l'arseiviment ëd l'arcesta.
Për piasì, ch'a torna andré e ch'a preuva torna.",
	'userrenametool-error-same-user' => "A peul pa arbatié n'utent con ël midem ëstranòm.",
	'userrenametool-error-extension-abort' => "N'estension a vieta ël process d'arbatiagi.",
	'userrenametool-error-cannot-rename-account' => "L'arbatiagi dël cont utent an sla base ëd dàit global partagià a l'é falì.",
	'userrenametool-error-cannot-create-block' => "La creassion dël blocagi Phalanx a l'é falìa.",
	'userrenametool-warn-repeat' => "Tension! L'utent «<nowiki>$1</nowiki>» a l'é già stàit arnominà an «<nowiki>$2</nowiki>».
Ch'a continua ël tratament mach s'a dev agiorné dj'anformassion mancante.",
	'userrenametool-warn-table-missing' => 'La tàula «<nowiki>$2</nowiki>» a esist pa ant la base ëd dàit «<nowiki>$1</nowiki>».',
	'userrenametool-info-started' => '$1 a l\'ha ancaminà a arbatié: $2 a $3 (registr: $4).
Rason: "$5".',
	'userrenametool-info-finished' => '$1 a l\'ha completà l\'arbatiagi: $2 a $3 (registr: $4).
Rason: "$5".',
	'userrenametool-info-failed' => '$1 A L\'HA FALI\' a arbatié: $2 a $3 (registr: $4).
Rason: "$5".',
	'userrenametool-info-wiki-finished' => '$1 a l\'ha arbatià $2 a $3 dzor $4.
Rason: "$5".',
	'userrenametool-info-wiki-finished-problems' => "$1 a l'ha arbatià $2 a $3 dzor $4 con dj'eror.
Rason: «$5».",
	'userrenametool-info-in-progress' => "Ël process d'arbatiagi a l'é an cors.
Ël rest a sarà fàit an slë sfond.
A sarà anformà për pòsta eletrònica quand tut a sarà livrà.",
	'userrenametool-success' => 'L\'utent "<nowiki>$1</nowiki>" a l\'é stait arbatià an "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'Veul-lo pròpi fé sòn?',
	'userrenametool-confirm-yes' => 'É!',
	'userrenametool-confirm-no' => 'Nò',
	'userrenametool-page-exists' => "La pàgina $1 a-i é già e as peul nen passe-ie dzora n'aotomàtich.",
	'userrenametool-page-moved' => "La pàgina $1 a l'ha fait San Martin a $2.",
	'userrenametool-page-unmoved' => "La pàgina $1 a l'é pa podusse tramudé a $2.",
	'userrenametool-finished-email-subject' => "Process d'arbatiagi dl'utent completà për [$1]",
	'userrenametool-finished-email-body-text' => 'Ël process ëd tramudé "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" a l\'é stàit completà.',
	'userrenametool-finished-email-body-html' => 'Ël process ëd tramudé "<nowiki>$1</nowiki>" a "<nowiki>$2</nowiki>" a l\'é stàit completà.',
	'userrenametool-logpage' => "Registr dj'arbatiagi",
	'userrenametool-logpagetext' => "Sossì a l'é un registr dle modìfiche djë stranòm dj'utent",
	'userrenametool-logentry' => 'a l\'ha arbatià $1 coma "$2"',
	'userrenametool-log' => "ch'a l'avìa $1 modìfiche. $2",
	'userrenametool-move-log' => 'Pàgina utent tramudà n\'aotomàtich damëntrè ch\'as arbatiava "[[User:$1|$1]]" an "[[User:$2|$2]]"',
	'right-renameuser' => "Arnòmina j'utent",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'userrenametool' => 'د يو کارن نوم بدلول',
	'renameuser' => 'کارن-نوم بدلول',
	'userrenametool-old' => 'اوسنی کارن-نوم:',
	'userrenametool-new' => 'نوی کارن-نوم:',
	'userrenametool-reason' => 'د نوم د بدلون سبب:',
	'userrenametool-warnings' => 'ګواښنې:',
	'userrenametool-submit' => 'کارن-نوم بدلول',
	'userrenametool-errordoesnotexist' => 'د "<nowiki>$1</nowiki>" په نامه کارونکی نه شته.',
	'userrenametool-errorexists' => 'د "<nowiki>$1</nowiki>" په نامه يو کارونکی له پخوا نه شته.',
	'userrenametool-error-request' => 'د غوښتنې په ترلاسه کولو کې يوه ستونزه راپېښه شوه.
مهرباني وکړی بېرته پرشا ولاړ شی او يو ځل بيا پرې کوښښ وکړی.',
	'userrenametool-confirm-yes' => 'هو',
	'userrenametool-confirm-no' => 'نه',
	'userrenametool-logpage' => 'د کارن-نوم يادښت',
	'userrenametool-log' => '{{PLURAL:$1|1 سمون|$1 سمونونه}}.
سبب: $2',
	'right-renameuser' => 'کارن-نومونه بدلول',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 * @author Malafaya
 * @author SandroHc
 * @author 555
 */
$messages['pt'] = array(
	'userrenametool' => 'Alterar o nome de um utilizador',
	'renameuser' => 'Alterar o nome do utilizador',
	'userrenametool-warning' => 'Antes de alterar o nome de um utilizador, certifique-se de que todas as informações estão corretas e que o utilizador sabe que o processo pode demorar algum tempo.
Pode ver os registros no [[Special:Stafflog|Registro da equipa]].',
	'userrenametool-desc' => "Adiciona uma [[Special:UserRenameTool|página especial]] para alterar o nome de um utilizador (requer o privilégio ''renameuser'') e processar todos os dados relacionados",
	'userrenametool-old' => 'Nome de utilizador atual:',
	'userrenametool-new' => 'Novo nome de utilizador:',
	'userrenametool-reason' => 'Motivo da alteração do nome:',
	'userrenametool-move' => 'Mover as páginas de utilizador e de discussão do utilizador (e as respectivas subpáginas) para o novo nome',
	'userrenametool-reserve' => 'Impedir o reuso do antigo nome de utilizador',
	'userrenametool-notify-renamed' => 'Quando terminar, notificar o utilizador por correio electrónico',
	'userrenametool-warnings' => 'Alertas:',
	'userrenametool-confirm' => 'Sim, alterar o nome do utilizador',
	'userrenametool-submit' => 'Alterar o nome do utilizador',
	'userrenametool-errordoesnotexist' => 'Não existe um utilizador "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'Já existe um utilizador "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalid' => 'O nome de utilizador "<nowiki>$1</nowiki>" é inválido.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" não é um nome de utilizador válido.',
	'userrenametool-errortoomany' => 'O utilizador "<nowiki>$1</nowiki>" tem $2 {{PLURAL:$2|contribuição|contribuições}}. Alterar o nome de um utilizador com mais de $3 {{PLURAL:$3|contribuição|contribuições}} pode afetar o desempenho do site.',
	'userrenametool-errorprocessing' => 'O processo de alteração do nome do utilizador <nowiki>$1</nowiki> para <nowiki>$2</nowiki> já está em progresso.',
	'userrenametool-errorblocked' => 'O utilizador <nowiki>$1</nowiki> está bloqueado por <nowiki>$2</nowiki> por $3.',
	'userrenametool-errorlocked' => 'O utilizador <nowiki>$1</nowiki> está bloqueado.',
	'userrenametool-errorbot' => 'O utilizador <nowiki>$1</nowiki> é um robô.',
	'userrenametool-error-request' => 'Ocorreu um problema ao receber este pedido.
Volte atrás e tente novamente.',
	'userrenametool-error-same-user' => 'Não pode alterar um nome de utilizador para o mesmo nome.',
	'userrenametool-error-extension-abort' => 'Uma extensão impediu o processo de alteração do nome.',
	'userrenametool-error-cannot-rename-account' => 'A alteração do nome da conta na base de dados partilhada global falhou.',
	'userrenametool-error-cannot-create-block' => 'A criação de um bloqueio de Phalanx falhou.',
	'userrenametool-warn-repeat' => 'Atenção! O nome do utilizador "<nowiki>$1</nowiki>" já foi alterado para "<nowiki>$2</nowiki>".
Continue esta operação somente se necessita de actualizar alguma informação em falta.',
	'userrenametool-warn-table-missing' => 'A tabela "<nowiki>$2</nowiki>" não existe na base de dados "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 iniciou a alteração do nome: $2 para $3 (registos: $4).
Motivo: "$5".',
	'userrenametool-info-finished' => '$1 terminou a alteração do nome: $2 para $3 (registos: $4).
Motivo: "$5".',
	'userrenametool-info-failed' => '$1 FALHOU a alteração do nome: $2 para $3 (registos: $4).
Motivo: "$5".',
	'userrenametool-info-wiki-finished' => '$1 alterou o nome de $2 para $3 em $4.
Motivo: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 alterou o nome de $2 para $3 em $4 com erros.
Motivo: "$5".',
	'userrenametool-info-in-progress' => 'O processo de alteração do nome está em progresso.
O restante será executado como tarefa de segundo plano.
Quando este terminar, receberá uma notificação por correio electrónico.',
	'userrenametool-success' => 'O nome do utilizador "<nowiki>$1</nowiki>" foi alterado para "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => 'Pretende realmente executar esta operação?',
	'userrenametool-confirm-yes' => 'Sim',
	'userrenametool-confirm-no' => 'Não',
	'userrenametool-page-exists' => 'Já existe a página $1. Não é possível sobrescrever automaticamente.',
	'userrenametool-page-moved' => 'A página $1 foi movida para $2.',
	'userrenametool-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'userrenametool-finished-email-subject' => 'Terminou o processo de alteração do nome de [$1]',
	'userrenametool-finished-email-body-text' => 'O processo de alteração de "<nowiki>$1</nowiki>" para "<nowiki>$2</nowiki>" terminou.',
	'userrenametool-finished-email-body-html' => 'O processo de alteração de "<nowiki>$1</nowiki>" para "<nowiki>$2</nowiki>" terminou.',
	'userrenametool-logpage' => 'Registo de alteração do nome de utilizador',
	'userrenametool-logpagetext' => 'Este é um registro de alterações efetuadas a nomes de utilizadores.',
	'userrenametool-logentry' => 'alterou o nome de $1 para "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'userrenametool-move-log' => 'Página movida automaticamente ao alterar o nome do utilizador "[[User:$1|$1]]" para "[[User:$2|$2]]"',
	'right-renameuser' => 'Alterar nomes de utilizadores',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Cainamarques
 * @author JM Pessanha
 * @author Luckas
 * @author 555
 */
$messages['pt-br'] = array(
	'userrenametool' => 'Alterar o nome de um utilizador',
	'renameuser' => 'Renomear usuário',
	'userrenametool-warning' => 'Antes de alterar o nome de um utilizador, certifique-se de que todas as informações estão correctas e que o utilizador sabe que o processo pode demorar algum tempo.
Pode ver os registos no [[Special:Stafflog|Registo da equipa]].',
	'userrenametool-desc' => "Adiciona uma [[Special:Renameuser|página especial]] para renomear um usuário (requer privilégio ''renameuser'')",
	'userrenametool-old' => 'Nome de usuário atual:',
	'userrenametool-new' => 'Novo nome de usuário:',
	'userrenametool-reason' => 'Motivo de renomear:',
	'userrenametool-move' => 'Mover as páginas de usuário, páginas de discussão de usuário e sub-páginas para o novo nome',
	'userrenametool-reserve' => 'Impedir novos usos do antigo nome de usuário',
	'userrenametool-notify-renamed' => 'Quando terminar, notificar o utilizador por correio electrónico',
	'userrenametool-warnings' => 'Alertas:',
	'userrenametool-requested-rename' => 'O usuário $1 solicitou a renomeação da conta',
	'userrenametool-did-not-request-rename' => 'O usuário $1 não solicitou uma renomeação da conta',
	'userrenametool-previously-renamed' => 'O usuário $1 já teve uma renomeação de conta',
	'userrenametool-phalanx-matches' => 'Resultados no filtro de Phalanx $1:',
	'userrenametool-confirm' => 'Sim, renomeie o usuário',
	'userrenametool-submit' => 'Alterar o nome do usuário',
	'userrenametool-errordoesnotexist' => 'Não existe um usuário "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'Já existe um usuário "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalid' => 'O nome de usuário "<nowiki>$1</nowiki>" é inválido.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" não é um nome de utilizador válido.',
	'userrenametool-errortoomany' => 'O usuário "<nowiki>$1</nowiki>" possui $2 {{PLURAL:$2|contribuição|contribuições}}. Renomear um usuário com mais de $3 {{PLURAL:$3|contribuição|contribuições}} pode afetar o desempenho do site.',
	'userrenametool-errorprocessing' => 'O processo de alteração do nome do utilizador <nowiki>$1</nowiki> para <nowiki>$2</nowiki> já está em progresso.',
	'userrenametool-errorblocked' => 'O utilizador <nowiki>$1</nowiki> está bloqueado por <nowiki>$2</nowiki> por $3.',
	'userrenametool-errorlocked' => 'O usuário <nowiki>$1</nowiki> está bloqueado.',
	'userrenametool-errorbot' => 'O usuário <nowiki>$1</nowiki> é um robô.',
	'userrenametool-error-request' => 'Houve um problema ao receber este pedido.
Retorne e tente novamente.',
	'userrenametool-error-same-user' => 'Não é possível renomear um usuário para o nome anterior.',
	'userrenametool-error-extension-abort' => 'Uma extensão impediu o processo de alteração do nome.',
	'userrenametool-error-cannot-rename-account' => 'A alteração do nome da conta na base de dados partilhada global falhou.',
	'userrenametool-error-cannot-create-block' => 'A criação de um bloqueio de Phalanx falhou.',
	'userrenametool-warn-repeat' => 'Atenção! O nome do utilizador "<nowiki>$1</nowiki>" já foi alterado para "<nowiki>$2</nowiki>".
Continue esta operação somente se necessita de atualizar alguma informação em falta.',
	'userrenametool-warn-table-missing' => 'A tabela "<nowiki>$2</nowiki>" não existe na base de dados "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 iniciou a alteração do nome: $2 para $3 (registos: $4).
Motivo: "$5".',
	'userrenametool-info-finished' => '$1 terminou a alteração do nome: $2 para $3 (registos: $4).
Motivo: "$5".',
	'userrenametool-info-failed' => '$1 FALHOU a alteração do nome: $2 para $3 (registos: $4).
Motivo: "$5".',
	'userrenametool-info-wiki-finished' => '$1 alterou o nome de $2 para $3 em $4.
Motivo: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 alterou o nome de $2 para $3 em $4 com erros.
Motivo: "$5".',
	'userrenametool-info-in-progress' => 'O processo de alteração do nome está em progresso.
O restante será executado como tarefa de segundo plano.
Quando este terminar, receberá uma notificação por correio electrónico.',
	'userrenametool-success' => 'O usuário "<nowiki>$1</nowiki>" foi renomeado para "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => 'Pretende realmente executar esta operação?',
	'userrenametool-confirm-yes' => 'Sim',
	'userrenametool-confirm-no' => 'Não',
	'userrenametool-page-exists' => 'Já existe a página $1. Não é possível sobrescrever automaticamente.',
	'userrenametool-page-moved' => 'A página $1 foi movida com sucesso para $2.',
	'userrenametool-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'userrenametool-finished-email-subject' => 'Terminou o processo de alteração do nome de [$1]',
	'userrenametool-finished-email-body-text' => 'O processo de alteração de "<nowiki>$1</nowiki>" para "<nowiki>$2</nowiki>" terminou.',
	'userrenametool-finished-email-body-html' => 'O processo de alteração de "<nowiki>$1</nowiki>" para "<nowiki>$2</nowiki>" terminou.',
	'userrenametool-logpage' => 'Registro de renomeação de usuários',
	'userrenametool-logpagetext' => 'Este é um registro de alterações efetuadas em nomes de usuários.',
	'userrenametool-logentry' => 'renomeou $1 para "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'userrenametool-move-log' => 'Páginas foram movidas automaticamente ao renomear o usuário "[[User:$1|$1]]" para "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomear usuários',
	'action-renameuser' => 'renomear usuários',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'renameuser' => 'Ruraqpa sutinta hukchay',
	'userrenametool-old' => 'Kunan ruraqpa sutin:',
	'userrenametool-new' => 'Musuq ruraqpa sutin:',
	'userrenametool-reason' => 'Imarayku ruraqpa sutinta hukchasqa:',
	'userrenametool-move' => "Ruraqpa p'anqanta, rimachinanta (urin p'anqankunatapas) musuq sutinman astay",
	'userrenametool-submit' => 'Kachay',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa manam kanchu.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa kachkanñam.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" nisqa sutiqa manam allinchu.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa $2 {{PLURAL:$2|llamk\'apusqayuqmi|llamk\'apusqayuqmi}}. $3-manta aswan {{PLURAL:$3|llamk\'apusqayuq|llamk\'apusqayuq}} ruraqpa sutinta hukchayqa llika tiyaypa rikch\'akuyninpaq mana allinchá kanman.',
	'userrenametool-error-request' => 'Manam atinichu mañasqaykita chaskiyta. Ama hina kaspa, ñawpaqman kutimuspa musuqmanta ruraykachay.',
	'userrenametool-error-same-user' => 'Manam atinkichu ruraqpa sutinta ñawpaq suti hinalla sutinman hukchayta.',
	'userrenametool-success' => 'Ruraqpa "<nowiki>$1</nowiki>" nisqa sutinqa "<nowiki>$2</nowiki>" nisqa sutinman hukchasqañam.',
	'userrenametool-page-exists' => '"<nowiki>$1</nowiki>" sutiyuq p\'anqaqa kachkanñam. Manam atinallachu kikinmanta huknachay.',
	'userrenametool-page-moved' => '"<nowiki>$1</nowiki>" ñawpa sutiyuq ruraqpa p\'anqanqa "<nowiki>$2</nowiki>" nisqa musuq p\'anqanman astasqañam.',
	'userrenametool-page-unmoved' => 'Manam atinichu "<nowiki>$1</nowiki>" ñawpa sutiyuq ruraqpa p\'anqanta "<nowiki>$2</nowiki>" nisqa musuq p\'anqanman astayta.',
	'userrenametool-logpage' => "Ruraqpa sutin hukchay hallch'a",
	'userrenametool-logpagetext' => "Kayqa ruraqkunap sutinkunata hukchaymanta hallch'am",
	'userrenametool-logentry' => '$1-pa sutinta "$2" sutiman hukchasqa',
	'userrenametool-log' => "{{PLURAL:$1|1 llamk'apusqa|$1 llamk'apusqakuna}}, kayrayku: $2",
	'userrenametool-move-log' => '"[[User:$1|$1]]" ruraqpa sutinta "[[User:$2|$2]]" sutiman hukchaspa kikinmanta ruraqpa p\'anqatapas astan',
	'right-renameuser' => 'Ruraqpa sutinkunata hukchay',
);

/** Romani (Romani)
 * @author Desiphral
 */
$messages['rmy'] = array(
	'userrenametool-submit' => 'De le jeneske aver nav',
);

/** Romanian (română)
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'renameuser' => 'Redenumire utilizator',
	'userrenametool-desc' => "Adaugă o [[Special:Renameuser|pagină specială]] pentru a redenumi un utilizator (necesită drept de ''renameuser'')",
	'userrenametool-old' => 'Numele de utilizator existent:',
	'userrenametool-new' => 'Numele de utilizator nou:',
	'userrenametool-reason' => 'Motivul schimbării numelui:',
	'userrenametool-move' => 'Mută pagina de utilizator şi pagina de discuţii (şi subpaginile lor) la noul nume',
	'userrenametool-reserve' => 'Utilizarea ulterioară a vechiului nume de utilizator',
	'userrenametool-warnings' => 'Avertizări:',
	'userrenametool-confirm' => 'Da, redenumeşte utilizatorul',
	'userrenametool-submit' => 'Trimite',
	'userrenametool-errordoesnotexist' => 'Utilizatorul "$1" nu există',
	'userrenametool-errorexists' => 'Utilizatorul "$1" există deja',
	'userrenametool-errorinvalid' => 'Numele de utilizator "<nowiki>$1</nowiki>" este invalid',
	'userrenametool-errortoomany' => 'Utilizatorul "<nowiki>$1</nowiki>" are $2 {{PLURAL:$2|contribuţie|contribuţii}}, redenumirea unui utilizator cu mai mult de $3 {{PLURAL:$3|contribuţie|contribuţii}} contribuţii ar putea afecta performanţa sitului',
	'userrenametool-error-request' => 'A fost o problemă la procesarea cererii.
Întoarceţi-vă şi încercaţi din nou.',
	'userrenametool-error-same-user' => 'Nu puteţi redenumi un utilizator la acelaşi nume ca şi înainte.',
	'userrenametool-success' => 'Utilizatorul "$1" a fost redenumit în "$2"',
	'userrenametool-confirm-intro' => 'Chiar vrei să faci asta?',
	'userrenametool-confirm-yes' => 'Da',
	'userrenametool-confirm-no' => 'Nu',
	'userrenametool-page-exists' => 'Pagina $1 există deja şi nu poate fi suprascrisă automat.',
	'userrenametool-page-moved' => 'Pagina $1 a fost mutată la $2.',
	'userrenametool-page-unmoved' => 'Pagina $1 nu poate fi mutată la $2.',
	'userrenametool-logpage' => 'Raport redenumiri utilizatori',
	'userrenametool-logpagetext' => 'Acesta este un raport al modificărilor de nume de utilizator',
	'userrenametool-logentry' => 'a redenumit $1 în „$2”',
	'userrenametool-log' => '{{PLURAL:$1|o contribuţie|$1 contribuţii}}. Motiv: $2',
	'userrenametool-move-log' => 'Pagină mutată automat la redenumirea utilizatorului de la "[[User:$1|$1]]" la "[[User:$2|$2]]"',
	'right-renameuser' => 'Redenumește utilizatori',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'userrenametool' => "Cange 'nu nome utende",
	'renameuser' => "Renomene l'utende",
	'userrenametool-old' => 'Nome utende de mò:',
	'userrenametool-new' => 'Nome utende nuève:',
	'userrenametool-reason' => 'Mutive pe renomenà:',
	'userrenametool-move' => "Spuèste utende e pàgene de le 'ngazzaminde (e le sottopàggene) a 'u nome nuève",
	'userrenametool-reserve' => "Blocche 'u nome utende vicchije da le ause future",
	'userrenametool-submit' => 'Conferme',
	'userrenametool-confirm-yes' => 'Sìne',
	'userrenametool-confirm-no' => 'None',
	'userrenametool-logentry' => 'renomnate $1 jndr\'à "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 cangiamende|$1 cangiaminde}}.
Mutive: $2',
	'right-renameuser' => "Rennomene l'utinde",
);

/** Russian (русский)
 * @author Ahonc
 * @author DCamer
 * @author EugeneZelenko
 * @author Innv
 * @author Kaganer
 * @author Kuzura
 * @author Okras
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'userrenametool' => 'Изменить имя пользователя',
	'renameuser' => 'Переименовать участника',
	'userrenametool-warning' => 'Прежде чем переименовывать участника, убедитесь что вся информация верна, и сообщите об этом участнику, может потребоваться некоторое время для завершения.
Смотрите [[Special:Stafflog|журнал сотрудника]] чтобы получить логи.',
	'userrenametool-desc' => "Добавляет [[Special:UserRenameTool|специальную страницу]] переименования участника (необходимы права ''renameuser'') и обработки всех связанных данных",
	'userrenametool-old' => 'Имя в настоящий момент:',
	'userrenametool-new' => 'Новое имя:',
	'userrenametool-encoded' => 'В виде URL:',
	'userrenametool-reason' => 'Причина переименования:',
	'userrenametool-move' => 'Переименовать также страницу участника, личное обсуждение и их подстраницы',
	'userrenametool-reserve' => 'Зарезервировать старое имя участника для использования в будущем',
	'userrenametool-notify-renamed' => 'Отправить сообщение переименованному участнику после завершения',
	'userrenametool-warnings' => 'Предупреждения:',
	'userrenametool-requested-rename' => 'Участник $1 запросил переименование',
	'userrenametool-did-not-request-rename' => 'Участник $1 не запрашивал переименование',
	'userrenametool-previously-renamed' => 'Участник $1 уже был переименован',
	'userrenametool-phalanx-matches' => 'Фильтры Phalanx соответствуют $1:',
	'userrenametool-confirm' => 'Да, переименовать участника',
	'userrenametool-submit' => 'Выполнить',
	'userrenametool-error-antispoof-conflict' => 'Предупреждение AntiSpoof — уже есть имя пользователя, похожее на «<nowiki>$1</nowiki>».',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof не установлен.',
	'userrenametool-errordoesnotexist' => 'Участник с именем «<nowiki>$1</nowiki>» не зарегистрирован.',
	'userrenametool-errorexists' => 'Участник с именем «<nowiki>$1</nowiki>» уже зарегистрирован.',
	'userrenametool-errorinvalid' => 'Недопустимое имя участника «<nowiki>$1</nowiki>»',
	'userrenametool-errorinvalidnew' => 'Недопустимое новое имя участника «<nowiki>$1</nowiki>»',
	'userrenametool-errortoomany' => 'Участник <nowiki>$1</nowiki> внёс $2 {{PLURAL:$2|правку|правки|правок}}, переименование участника с более чем $3 {{PLURAL:$3|правкой|правками|правками}} может оказать негативное влияние на доступ к сайту.',
	'userrenametool-errorprocessing' => 'Процесс переименования участника <nowiki>$1</nowiki> в <nowiki>$2</nowiki> уже выполняется.',
	'userrenametool-errorblocked' => 'Участник <nowiki>$1</nowiki> заблокирован <nowiki>$2</nowiki> на $3.',
	'userrenametool-errorlocked' => 'Участник <nowiki>$1</nowiki> заблокирован.',
	'userrenametool-errorbot' => 'Участник <nowiki>$1</nowiki> это бот.',
	'userrenametool-error-request' => 'Возникли затруднения с получением запроса. Пожалуйста, вернитесь назад и повторите ещё раз.',
	'userrenametool-error-same-user' => 'Вы не можете переименовать участника в тоже имя, что и было раньше.',
	'userrenametool-error-extension-abort' => 'Расширение помешало процессу переименования.',
	'userrenametool-error-cannot-rename-account' => 'Переименование учетной записи участника в общей глобальной базе данных не удалось.',
	'userrenametool-error-cannot-create-block' => 'Создание блока с помощью Phalanx не удалось.',
	'userrenametool-error-cannot-rename-unexpected' => 'Произошла непредвиденная ошибка, проверьте журналы или попробуйте еще раз.',
	'userrenametool-warnings-characters' => 'Новое имя пользователя содержит недопустимые символы!',
	'userrenametool-warnings-maxlength' => 'Длина нового имени пользователя не может превышать 255 символов!',
	'userrenametool-warn-repeat' => 'Внимание! Участник «<nowiki>$1</nowiki>» уже был переименован в «<nowiki>$2</nowiki>».
Продолжайте обработку только в том случае, когда вам необходимо обновить некоторую недостающую информацию.',
	'userrenametool-warn-table-missing' => 'Таблица «<nowiki>$2</nowiki>» не существует в базе данных «<nowiki>$1</nowiki>».',
	'userrenametool-info-started' => '$1 начал переименовывать: $2 в $3 (записей: $4).
Причина: "$5".',
	'userrenametool-info-finished' => '$1 завершил переименовывать: $2 в $3 (записей: $4).
Причина: "$5".',
	'userrenametool-info-failed' => '$1 не удалось переименовать: $2 в $3 (записей: $4).
Причина: "$5".',
	'userrenametool-info-wiki-finished' => '$1 переименовал $2 в $3 (в $4).
Причина: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 переименовал $2 в $3 (в $4) с ошибками.
Причина: "$5".',
	'userrenametool-info-in-progress' => 'Переименование в процессе.
Остальные процессы будут осуществляться в фоновом режиме.
Вы будете уведомлены по электронной почте о его завершении.',
	'userrenametool-success' => 'Участник «<nowiki>$1</nowiki>» был переименован в «<nowiki>$2</nowiki>».',
	'userrenametool-confirm-intro' => 'Вы действительно хотите это сделать?',
	'userrenametool-confirm-yes' => 'Да',
	'userrenametool-confirm-no' => 'Нет',
	'userrenametool-page-exists' => 'Страница $1 уже существует и не может быть перезаписана автоматически.',
	'userrenametool-page-moved' => 'Страница $1 была переименована в $2.',
	'userrenametool-page-unmoved' => 'Страница $1 не может быть переименована в $2.',
	'userrenametool-finished-email-subject' => 'Процесс переименования закончен для [$1]',
	'userrenametool-finished-email-body-text' => 'Процесс перемещения из "<nowiki>$1</nowiki>" в "<nowiki>$2</nowiki>" завершён.',
	'userrenametool-finished-email-body-html' => 'Процесс перемещения из "<nowiki>$1</nowiki>" в "<nowiki>$2</nowiki>" завершён.',
	'userrenametool-logpage' => 'Журнал переименований участников',
	'userrenametool-logpagetext' => 'Это журнал произведённых переименований зарегистрированных участников.',
	'userrenametool-logentry' => 'переименовал $1 в «$2»',
	'userrenametool-log' => '$1 {{PLURAL:$1|правка|правки|правок}}. Причина: $2',
	'userrenametool-move-log' => 'Автоматически в связи с переименованием учётной записи «[[User:$1|$1]]» в «[[User:$2|$2]]»',
	'right-renameuser' => 'переименование участников',
	'action-renameuser' => 'переименование участников',
);

/** Rusyn (русиньскый)
 */
$messages['rue'] = array(
	'renameuser' => 'Переменоватихоснователя',
	'right-renameuser' => 'Переменованя хоснователїв',
);

/** Sakha (саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'renameuser' => 'Кыттааччы аатын уларыт',
	'userrenametool-desc' => "Кыттааччы аатын уларытыы (''renameuser'' бырааба наада)",
	'userrenametool-old' => 'Билиҥҥи аата:',
	'userrenametool-new' => 'Саҥа аата:',
	'userrenametool-reason' => 'Аатын уларыппыт төрүөтэ:',
	'userrenametool-move' => 'Кыттааччы аатын кытта кэпсэтэр сирин, уонна атын сирэйдэрин ааттарын уларыт',
	'userrenametool-reserve' => 'Кыттааччы урукку аатын кэлин туттарга анаан хааллар',
	'userrenametool-warnings' => 'Сэрэтиилэр:',
	'userrenametool-confirm' => 'Сөп, аатын уларыт',
	'userrenametool-submit' => 'Толор',
	'userrenametool-errordoesnotexist' => 'Маннык ааттаах кыттааччы «<nowiki>$1</nowiki>» бэлиэтэммэтэх.',
	'userrenametool-errorexists' => 'Маннык ааттаах кыттааччы "<nowiki>$1</nowiki>" номнуо баар.',
	'userrenametool-errorinvalid' => 'Маннык аат "<nowiki>$1</nowiki>" көҥуллэммэт.',
	'userrenametool-errortoomany' => '<nowiki>$1</nowiki> кыттааччы $2 көннөрүүнү киллэрбит, $3 тахса көннөрүүнү оҥорбут кыттааччы аатын уларытыы саайка оччото суох быһыыны үөскэтиэн сөп.',
	'userrenametool-error-request' => 'Запрос тутуута моһуоктанна. Бука диэн төнүн уонна хатылаа.',
	'userrenametool-error-same-user' => 'Кыттааччы аатын урукку аатыгар уларытар табыллыбат.',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" кыттааччы мантан ыла "<nowiki>$2</nowiki>" диэн ааттанна.',
	'userrenametool-page-exists' => '$1 сирэй номнуо баар онон аптамаатынан хат суруллар кыаҕа суох.',
	'userrenametool-page-moved' => '$1 сирэй маннык ааттаммыт $2.',
	'userrenametool-page-unmoved' => '$1 сирэй маннык $2 ааттанар кыаҕа суох.',
	'userrenametool-logpage' => 'Кыттааччылар ааттарын уларытыыларын сурунаала',
	'userrenametool-logpagetext' => 'Бу бэлиэтэммит кыттааччылар ааттарын уларытыыларын сурунаала',
	'userrenametool-logentry' => '$1 аатын манныкка уларытта "$2"',
	'userrenametool-log' => '{{PLURAL:$1|Биирдэ|$1 төгүл}} уларыйбыт. Төрүөтэ: $2',
	'userrenametool-move-log' => '«[[User:$1|$1]]» аата «[[User:$2|$2]]» буолбутунан аптамаатынан',
	'right-renameuser' => 'Кыттааччылар ааттарын уларытыы',
);

/** Sicilian (sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'renameuser' => 'Rinòmina utenti',
	'userrenametool-desc' => "Funzioni pi rinuminari n'utenti (addumanna li diritti di ''renameuser'')",
	'userrenametool-old' => 'Nomu utenti dô prisenti:',
	'userrenametool-new' => 'Novu nomu utenti:',
	'userrenametool-reason' => 'Mutivu dû caciu di nomu',
	'userrenametool-move' => 'Rinòmina macari la pàggina utenti, la pàggina di discussioni e li suttapàggini',
	'userrenametool-reserve' => 'Sarva lu vecchiu utenti pi futuri usi',
	'userrenametool-warnings' => 'Avvisi:',
	'userrenametool-confirm' => "Si, rinòmina st'utenti",
	'userrenametool-submit' => 'Manna',
	'userrenametool-errordoesnotexist' => 'L\'utenti "<nowiki>$1</nowiki>" nun esisti',
	'userrenametool-errorexists' => 'L\'utenti "<nowiki>$1</nowiki>" c\'è già',
	'userrenametool-errorinvalid' => 'Lu nomu utenti "<nowiki>$1</nowiki>" nun è vàlidu',
	'userrenametool-errortoomany' => 'L\'utenti "<nowiki>$1</nowiki>" havi $2 {{PLURAL:$2|cuntribbutu|cuntribbuti}}; ri-numinari n\'utenti cu chiossai di $3 {{PLURAL:$3|cuntribbutu|cuntribbuti}} pò nfruinzari \'n manera nigativa li pristazzioni dû situ.',
	'userrenametool-error-request' => "Si virificau nu prubbrema nnô ricivimentu dâ dumanna. Turnari arredi e pruvari n'àutra vota.",
	'userrenametool-error-same-user' => "Nun si pò ri-numinari n'utenti cô stissu nomu c'avìa già.",
	'userrenametool-success' => 'L\'utenti "<nowiki>$1</nowiki>" vinni ri-numinatu \'n "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => "La pàggina $1 c'è già; mpussìbbili suprascrivìrila autumaticamenti.",
	'userrenametool-page-moved' => 'La pàggina $1 vinni spustata a $2.',
	'userrenametool-page-unmoved' => 'Mpussìbbili mòviri la pàggina $1 a $2.',
	'userrenametool-logpage' => 'Utenti ri-numinati',
	'userrenametool-logpagetext' => "Di sècutu sunnu elencati li ri-numinazzioni di l'utenti.",
	'userrenametool-logentry' => 'hà ri-numinatu $1 \'n "$2"',
	'userrenametool-log' => 'Ca havi {{PLURAL:$1|nu cuntribbutu|$1 cuntribbuti}}. Mutivu: $2',
	'userrenametool-move-log' => 'Spustamentu autumàticu dâ pàggina - utenti ri-numinatu di "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => "Ri-nòmina l'utenti",
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'renameuser' => 'පරිශීලකයා යළි-නම්කරන්න',
	'userrenametool-desc' => "පරිශීලකයෙක් යළි-නම්කරනු වස් [[Special:Renameuser|විශේෂ පිටුවක්]] එක් කරන්න (''renameuser'' අයිතිය අවශ්‍යයි)",
	'userrenametool-old' => 'වත්මන් පරිශීලක නාමය:',
	'userrenametool-new' => 'නව පරිශීලක නාමය:',
	'userrenametool-reason' => 'යළි-නම්කිරීමට හේතුව:',
	'userrenametool-move' => 'පරිශීලක හා සාකච්ඡා පිටු (හා ඒවායේ උපපිටු) නව නම වෙතට ගෙන යන්න',
	'userrenametool-reserve' => 'පැරණි පරිශීලක නම අනාගත භාවිතයෙන් වාරණය කරන්න',
	'userrenametool-warnings' => 'අවවාදයන්:',
	'userrenametool-confirm' => 'ඔව්, පරිශීලකයා යළි-නම්කරන්න',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" පරිශීලකයා නොපවතී.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" පරිශීලකයා දැනටමත් පවතියි.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" පරිශීලක නාමය අනීතිකයි.',
	'right-renameuser' => 'පරිශීලකයන් ප්‍රතිනම් කරන්න',
);

/** Slovak (slovenčina)
 * @author Helix84
 * @author KuboF
 */
$messages['sk'] = array(
	'renameuser' => 'Premenovať používateľa',
	'userrenametool-desc' => "Premenovať používateľa (vyžaduje právo ''renameuser'')",
	'userrenametool-old' => 'Súčasné používateľské meno:',
	'userrenametool-new' => 'Nové používateľské meno:',
	'userrenametool-reason' => 'Dôvod premenovania:',
	'userrenametool-move' => 'Presunúť používateľské a diskusné stránky (a ich podstránky) na nový názov',
	'userrenametool-reserve' => 'Vyhradiť staré používateľské meno (zabrániť ďalšiemu použitiu)',
	'userrenametool-notify-renamed' => 'Poslať premenovanému používateľovi email po dokončení',
	'userrenametool-warnings' => 'Upozornenia:',
	'userrenametool-confirm' => 'Áno, premenovať používateľa',
	'userrenametool-submit' => 'Odoslať',
	'userrenametool-errordoesnotexist' => 'Používateľ „<nowiki>$1</nowiki>“ neexistuje',
	'userrenametool-errorexists' => 'Používateľ „<nowiki>$1</nowiki>“ už existuje',
	'userrenametool-errorinvalid' => 'Používateľské meno „<nowiki>$1</nowiki>“ je neplatné',
	'userrenametool-errortoomany' => 'Používateľ „<nowiki>$1</nowiki>“ má $2 {{PLURAL:$2|príspevok|príspevky|príspevkov}}, premenovanie používateľa s viac ako $3 {{PLURAL:$3|príspevkom|príspevkami}} by sa mohlo nepriaznivo odraziť na výkone stránky.',
	'userrenametool-errorbot' => 'Používateľ <nowiki>$1</nowiki> je robot.',
	'userrenametool-error-request' => 'Pri prijímaní vašej požiadavky nastal problém. Prosím, vráťte sa a skúste to znova.',
	'userrenametool-error-same-user' => 'Nemôžete premenovať používateľa na rovnaké meno ako mal predtým.',
	'userrenametool-success' => 'Používateľ „<nowiki>$1</nowiki>“ bol premenovaný na „<nowiki>$2</nowiki>“',
	'userrenametool-page-exists' => 'Stránka $1 už existuje a nie je možné ju automaticky prepísať.',
	'userrenametool-page-moved' => 'Stránka $1 bola presunutá na $2.',
	'userrenametool-page-unmoved' => 'Stránku $1 nebolo možné presunúť na $2.',
	'userrenametool-logpage' => 'Záznam premenovaní používateľov',
	'userrenametool-logpagetext' => 'Toto je záznam premenovaní používateľov',
	'userrenametool-logentry' => 'premenoval používateľa $1 na „$2”',
	'userrenametool-log' => 'mal {{PLURAL:$1|1 úpravu|$1 úpravy|$1 úprav}}. Dôvod: $2',
	'userrenametool-move-log' => 'Automaticky presunutá stránka počas premenovania používateľa „[[User:$1|$1]]“ na „[[User:$2|$2]]“',
	'right-renameuser' => 'Premenovávať používateľov',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 * @author Eleassar
 */
$messages['sl'] = array(
	'userrenametool' => 'Spreminjanje uporabniškega imena',
	'renameuser' => 'Preimenovanje uporabnika',
	'userrenametool-warning' => '<strong>Prosimo, pazljivo preberite sledeče informacije</strong>:<p>Pred preimenovanjem uporabnika se prepričajte, da so <strong>vsi podatki pravilni</strong>, in zagotovite, da <strong>uporabnik ve, da lahko dokončanje traja nekaj časa</strong>.
<br />Prosimo, zavedajte se, da se lahko zaradi nekaterih zunanjih dejavnikov prvi del postopka <strong>konča na prazni strani</strong>, kar ne pomeni, da postopek ne bo pravilno dokončan.</p><p>Napredku postopka lahko sledite preko [[Special:Stafflog|dnevnika osebja]], prav tako pa <strong>vam bo sistem poslal e-pošto, ko bo celotni postopek preimenovanja uporabnika zaključen</strong>.</p>',
	'userrenametool-desc' => "Doda [[Special:UserRenameTool|posebno stran]] za preimenovanje uporabnika (potrebna je pravica ''renameuser'') in obdela vse sorodne podatke",
	'userrenametool-old' => 'Trenutno uporabniško ime:',
	'userrenametool-new' => 'Novo uporabniško ime:',
	'userrenametool-reason' => 'Razlog za preimenovanje:',
	'userrenametool-move' => 'Prestavi uporabniške in pogovorne strani (ter njihove podstrani) na novo ime',
	'userrenametool-reserve' => 'Blokiraj staro uporabniško ime pred nadaljnjo uporabo',
	'userrenametool-notify-renamed' => 'Po koncu pošlji e-pošto preimenovanemu uporabniku',
	'userrenametool-warnings' => 'Opozorila:',
	'userrenametool-requested-rename' => 'Uporabnik $1 je zahteval preimenovanje',
	'userrenametool-did-not-request-rename' => 'Uporabnik $1 ni zahteval preimenovanja',
	'userrenametool-previously-renamed' => 'Uporabnik $1 je že bil preimenovan',
	'userrenametool-phalanx-matches' => 'Filtri Phalanx, ki se ujemajo z $1:',
	'userrenametool-confirm' => 'Da, preimenuj uporabnika',
	'userrenametool-submit' => 'Spremeni uporabniško ime',
	'userrenametool-error-antispoof-conflict' => 'Opozorilo pred prevaro - uporabniško ime, podobno »<nowiki>$1</nowiki>«, že obstaja.',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof ni nameščen.',
	'userrenametool-errordoesnotexist' => 'Uporabnik »<nowiki>$1</nowiki>« ne obstaja.',
	'userrenametool-errorexists' => 'Uporabnik »<nowiki>$1</nowiki>« že obstaja.',
	'userrenametool-errorinvalid' => '»<nowiki>$1</nowiki>« ni veljavno uporabniško ime.',
	'userrenametool-errorinvalidnew' => '»<nowiki>$1</nowiki>« ni veljavno novo uporabniško ime.',
	'userrenametool-errortoomany' => 'Uporabnik »<nowiki>$1</nowiki>« ima $2 {{PLURAL:$2|prispevek|prispevka|prispevke|prispevkov}}; preimenovanje uporabnika z več kot $3 {{PLURAL:$3|prispevkom|prispevkoma|prispevki}} lahko neželeno vpliva na delovanje strani.',
	'userrenametool-errorprocessing' => 'Postopek preimenovanja uporabnika <nowiki>$1</nowiki> v <nowiki>$2</nowiki> je že v teku.',
	'userrenametool-errorblocked' => 'Uporabnika <nowiki>$1</nowiki> je blokiral <nowiki>$2</nowiki> za $3.',
	'userrenametool-errorlocked' => 'Uporabnik <nowiki>$1</nowiki> je blokiran.',
	'userrenametool-errorbot' => 'Uporabnik <nowiki>$1</nowiki> je bot.',
	'userrenametool-error-request' => 'Pri prejemanju zahteve je prišlo do težave.
Prosimo, pojdite nazaj in poskusite znova.',
	'userrenametool-error-same-user' => 'Uporabnika ne morete preimenovati v isto ime.',
	'userrenametool-error-extension-abort' => 'Razširitev je preprečila postopek preimenovanja.',
	'userrenametool-error-cannot-rename-account' => 'Preimenovanje uporabniškega računa v skupni globalni zbirki podatkov ni uspelo.',
	'userrenametool-error-cannot-create-block' => 'Ustvarjanje blokade Phalanx ni uspelo.',
	'userrenametool-error-cannot-rename-unexpected' => 'Prišlo je do nepričakovane napake; preverite dnevnike ali poskusite znova.',
	'userrenametool-warnings-characters' => 'Novo uporabniško ime vsebuje prepovedane znake!',
	'userrenametool-warnings-maxlength' => 'Dolžina novega uporabniškega imena ne sme presegati 255 znakov!',
	'userrenametool-warn-repeat' => 'Pozor! Uporabnik »<nowiki>$1</nowiki>« je že preimenovan v »<nowiki>$2</nowiki>«.
Nadaljujte obdelavo le, če morate posodobiti kakšne manjkajoče informacije.',
	'userrenametool-warn-table-missing' => 'Tabela »<nowiki>$2</nowiki>« v zbirki podatkov »<nowiki>$1</nowiki>« ne obstaja.',
	'userrenametool-info-started' => '$1 je pričel s preimenovanjem: $2 v $3 (dnevniki: $4).
Razlog: »$5«.',
	'userrenametool-info-finished' => '$1 je dokončal preimenovanje: $2 v $3 (dnevniki: $4).
Razlog: »$5«.',
	'userrenametool-info-failed' => '$1 je SPODLETELO preimenovanje: $2 v $3 (dnevniki: $4).
Razlog: »$5«.',
	'userrenametool-info-wiki-finished' => '$1 je preimenoval(-a) $2 v $3 dne $4.
Razlog: »$5«.',
	'userrenametool-info-wiki-finished-problems' => '$1 je preimenoval(-a) $2 v $3 dne $4 z napakami.
Razlog: »$5«.',
	'userrenametool-info-in-progress' => 'Postopek preimenovanja je v teku.
Preostalo bo opravljeno v ozadju.
Ko bo dokončan, boste obveščeni po e-pošti.',
	'userrenametool-success' => 'Uporabnik »$1« je preimenovan v »$2«.',
	'userrenametool-confirm-intro' => 'Ali to res želite storiti?',
	'userrenametool-confirm-yes' => 'Da',
	'userrenametool-confirm-no' => 'Ne',
	'userrenametool-page-exists' => 'Stran $1 že obstaja in je ni mogoče samodejno prepisati.',
	'userrenametool-page-moved' => 'Stran $1 je bila prestavljena na $2.',
	'userrenametool-page-unmoved' => 'Strani $1 ni mogoče prestaviti na $2.',
	'userrenametool-finished-email-subject' => 'Postopek preimenovanja uporabnika je končan za [$1]',
	'userrenametool-finished-email-body-text' => 'Postopek prestavitve »<nowiki>$1</nowiki>« na »<nowiki>$2</nowiki>« je bil zaključen.',
	'userrenametool-finished-email-body-html' => 'Postopek prestavitve »<nowiki>$1</nowiki>« na »<nowiki>$2</nowiki>« je bil zaključen.',
	'userrenametool-logpage' => 'Dnevnik preimenovanj uporabnikov',
	'userrenametool-logpagetext' => 'Prikazan je dnevnik sprememb uporabniških imen.',
	'userrenametool-logentry' => 'preimenoval(-a) $1 v »$2«',
	'userrenametool-log' => '$1 {{PLURAL:$1|urejanje|urejanji|urejanja|urejanj}}.
Razlog: $2',
	'userrenametool-move-log' => 'Samodejno prestavljanje strani pri preimenovanju uporabnika »[[User:$1|$1]]« v »[[User:$2|$2]]«',
	'right-renameuser' => 'Preimenovanje uporabnikov',
	'action-renameuser' => 'preimenovanje uporabnikov',
);

/** Albanian (shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'renameuser' => 'Ndërrim përdoruesi',
	'userrenametool-old' => 'Emri i tanishëm',
	'userrenametool-new' => 'Emri i ri',
	'userrenametool-move' => 'Zhvendos faqet e përdoruesit dhe të diskutimit (dhe nën-faqet e tyre) tek emri i ri',
	'userrenametool-submit' => 'Ndryshoje',
	'userrenametool-errordoesnotexist' => 'Përdoruesi me emër "<nowiki>$1</nowiki>" nuk ekziston',
	'userrenametool-errorexists' => 'Përdoruesi me emër "<nowiki>$1</nowiki>" ekziston',
	'userrenametool-errorinvalid' => 'Emri "<nowiki>$1</nowiki>" nuk është i lejuar',
	'userrenametool-errortoomany' => 'Përdoruesi "<nowiki>$1</nowiki>" ka dhënë $2 {{PLURAL:$2|kontribut|kontribute}}. Ndryshimi i emrit të një përdoruesi me më shumë se $3 {{PLURAL:$3|kontribut|kontribute}} mund të ndikojë rëndë tek rendimenti i shërbyesave.',
	'userrenametool-success' => 'Përdoruesi "<nowiki>$1</nowiki>" u riemërua në "<nowiki>$2</nowiki>"',
	'userrenametool-logpage' => 'Regjistri i emër-ndryshimeve',
	'userrenametool-logpagetext' => 'Ky është një regjistër i ndryshimeve së emrave të përdoruesve',
	'userrenametool-log' => '{{PLURAL:$1|1 redaktim|$1 redaktime}}. Arsyeja: $2',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author FriedrickMILBarbarossa
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'userrenametool' => 'Промени корисничко име',
	'renameuser' => 'Преименуј корисника',
	'userrenametool-desc' => "Додаје [[Special:UserRenameTool|посебну страницу]] за преименовање корисника (потребно је ''renameuser'' право) и извршавање свих сродних података",
	'userrenametool-old' => 'Тренутно корисничко име:',
	'userrenametool-new' => 'Ново корисничко име:',
	'userrenametool-reason' => 'Разлог:',
	'userrenametool-move' => 'Премести корисничку страницу и страницу за разговор (и њихове подстранице) на нови назив',
	'userrenametool-warnings' => 'Упозорења:',
	'userrenametool-confirm' => 'Да, преименуј корисника',
	'userrenametool-submit' => 'Промени',
	'userrenametool-errordoesnotexist' => 'Корисник „<nowiki>$1</nowiki>“ не постоји.',
	'userrenametool-errorexists' => 'Корисник „<nowiki>$1</nowiki>“ већ постоји.',
	'userrenametool-errorinvalid' => '„<nowiki>$1</nowiki>“ није исправно корисничко име.',
	'userrenametool-errortoomany' => 'Корисник „<nowiki>$1</nowiki>“ има $2 {{PLURAL:$2|прилог|прилога|прилога}}. Преименовање корисника с више од $3 {{PLURAL:$3|прилог|прилога|прилога}} може да утиче на перформансе сајта.',
	'userrenametool-errorblocked' => 'Корисник <nowiki>$1</nowiki> је блокиран од члана <nowiki>$2</nowiki> за $3.',
	'userrenametool-errorlocked' => 'Корисник <nowiki>$1</nowiki> је блокиран.',
	'userrenametool-errorbot' => 'Корисник <nowiki>$1</nowiki> је бот.',
	'userrenametool-error-request' => 'Дошло је до проблема при примању захтева.
Вратите се назад и покушајте поново.',
	'userrenametool-error-same-user' => 'Не можете преименовати корисника у исто име.',
	'userrenametool-error-extension-abort' => 'Проширење је спречило преименовање.',
	'userrenametool-success' => 'Корисник „<nowiki>$1</nowiki>“ је преименован у „<nowiki>$2</nowiki>“.',
	'userrenametool-confirm-intro' => 'Потврдити радњу?',
	'userrenametool-confirm-yes' => 'Да',
	'userrenametool-confirm-no' => 'Не',
	'userrenametool-page-exists' => 'Страница $1 већ постоји и не може се заменити.',
	'userrenametool-page-moved' => 'Страница $1 је премештена у $2.',
	'userrenametool-page-unmoved' => 'Страница $1 не може да се премести на $2.',
	'userrenametool-logpagetext' => 'Ово је историјат измена корисничких имена.',
	'userrenametool-logentry' => '{{GENDER:|је преименовао|је преименовала|је преименовао}} $1 у „$2“',
	'userrenametool-log' => '{{PLURAL:$1|1 измена|$1 измене|$1 измена}}.
Разлог: $2',
	'userrenametool-move-log' => 'Премештене странице приликом преименовања корисника: „[[User:$1|$1]]“ у „[[User:$2|$2]]“.',
	'right-renameuser' => 'преименовање корисника',
);

/** Serbian (Latin script) (srpski (latinica)‎)
 */
$messages['sr-el'] = array(
	'renameuser' => 'Preimenuj korisnika',
	'right-renameuser' => 'preimenovanje korisničkih imena',
);

/** Seeltersk (Seeltersk)
 * @author Maartenvdbent
 * @author Pyt
 */
$messages['stq'] = array(
	'renameuser' => 'Benutsernoome annerje',
	'userrenametool-desc' => "Föiget ne [[Special:Renameuser|Spezioalsiede]] bietou tou Uumbenaamenge fon n Benutser (fräiget dät ''renameuser''-Gjucht)",
	'userrenametool-old' => 'Benutsernoomer bithäär:',
	'userrenametool-new' => 'Näie Benutsernoome:',
	'userrenametool-reason' => 'Gruund foar Uumenaame:',
	'userrenametool-move' => 'Ferschuuwe Benutser-/Diskussionssiede inkl. Unnersieden ap dän näie Benutsernoome',
	'userrenametool-reserve' => 'Blokkierje dän oolde Benutsernoome foar ne näie Registrierenge',
	'userrenametool-warnings' => 'Woarschauengen:',
	'userrenametool-confirm' => 'Jee, Benutser uumbenaame',
	'userrenametool-submit' => 'Uumbenaame',
	'userrenametool-errordoesnotexist' => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant nit',
	'userrenametool-errorexists' => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant al',
	'userrenametool-errorinvalid' => 'Die Benutsernoome "<nowiki>$1</nowiki>" is uungultich',
	'userrenametool-errortoomany' => 'Die Benutser "<nowiki>$1</nowiki>" häd $2 {{PLURAL:$2|Beoarbaidenge|Beoarbaidengen}}. Ju Noomensannerenge fon aan Benutser mäd moor as $3 {{PLURAL:$3|Beoarbaidenge|Beoarbaidengen}} kon ju Serverlaistenge toun Ätterdeel beienfloudje.',
	'userrenametool-error-request' => 'Dät roat n Problem bie dän Ämpfang fon ju Anfroage. Fersäik jädden nochmoal.',
	'userrenametool-error-same-user' => 'Oolde un näie Benutsernoome sunt identisk.',
	'userrenametool-success' => 'Die Benutser "<nowiki>$1</nowiki>" wuude mäd Ärfoulch uumenaamd in "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Ju Siede $1 bestoant al un kon nit automatisk uurschrieuwen wäide.',
	'userrenametool-page-moved' => 'Ju Siede $1 wuude ätter $2 ferschäuwen.',
	'userrenametool-page-unmoved' => 'Ju Siede $1 kuude nit ätter $2 ferschäuwen wäide.',
	'userrenametool-logpage' => 'Benutsernoomenannerengs-Logbouk',
	'userrenametool-logpagetext' => 'In dit Logbouk wäide do Annerengen fon Benutsernoomen protokollierd.',
	'userrenametool-logentry' => 'häd "$1" in "$2" uumenaamd',
	'userrenametool-log' => '{{PLURAL:$1|1 Beoarbaidenge|$1 Beoarbaidengen}}. Gruund: $2',
	'userrenametool-move-log' => 'truch ju Uumbenaamenge fon „[[User:$1|$1]]“ ätter „[[User:$2|$2]]“ automatisk ferschäuwene Siede.',
	'right-renameuser' => 'Benutser uumenaame',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'renameuser' => 'Ganti ngaran pamaké',
	'userrenametool-desc' => "Ganti ngaran pamaké (perlu kawenangan ''renameuser'')",
	'userrenametool-old' => 'Ngaran pamaké ayeuna:',
	'userrenametool-new' => 'Ngaran pamaké anyar:',
	'userrenametool-reason' => 'Alesan ganti ngaran:',
	'userrenametool-move' => 'Pindahkeun kaca pamaké jeung obrolanna (jeung sub-kacanna) ka ngaran anyar',
	'userrenametool-submit' => 'Kirim',
	'userrenametool-errordoesnotexist' => 'Euweuh pamaké nu ngaranna "<nowiki>$1</nowiki>"',
	'userrenametool-errorexists' => 'Pamaké "<nowiki>$1</nowiki>" geus aya',
	'userrenametool-errorinvalid' => 'Ngaran pamaké "<nowiki>$1</nowiki>" teu sah',
	'userrenametool-errortoomany' => 'Pamaké "<nowiki>$1</nowiki>" boga $2 kontribusi, ngaganti ngaran pamaké nu boga kontribusi leuwih ti $3 bakal mangaruhan kinerja loka',
	'userrenametool-error-request' => 'Aya gangguan nalika nampa paménta. Coba balik deui, terus cobaan deui.',
	'userrenametool-error-same-user' => 'Anjeun teu bisa ngaganti ngaran pamaké ka ngaran nu éta-éta kénéh.',
	'userrenametool-success' => 'Pamaké "<nowiki>$1</nowiki>" geus diganti ngaranna jadi "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Kaca $1 geus aya sarta teu bisa ditimpah kitu baé.',
	'userrenametool-page-moved' => 'Kaca $1 geus dipindahkeun ka $2.',
	'userrenametool-page-unmoved' => 'Kaca $1 teu bisa dipindahkeun ka $2.',
	'userrenametool-logpage' => 'Log ganti ngaran',
	'userrenametool-logpagetext' => 'Ieu minangka log parobahan ngaran pamaké',
	'userrenametool-logentry' => 'geus ngaganti ngaran $1 jadi "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 édit|$1 édit}}. Alesan: $2',
	'userrenametool-move-log' => 'Otomatis mindahkeun kaca nalika ngaganti ngaran "[[User:$1|$1]]" jadi "[[User:$2|$2]]"',
);

/** Swedish (svenska)
 * @author Boivie
 * @author Habj
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'userrenametool' => 'Ändra en användares namn',
	'renameuser' => 'Byt användarnamn',
	'userrenametool-warning' => 'Innan du byter namn på en användare, vänligen se till att all information är korrekt, och se till att användaren vet att det kan ta tid att slutföra.
Se [[Special:Stafflog|personalloggen]] för loggar.',
	'userrenametool-desc' => "Lägger till en [[Special:Renameuser|specialsida]] för att byta namn på en användare (kräver behörigheten ''renameuser'')",
	'userrenametool-old' => 'Nuvarande användarnamn:',
	'userrenametool-new' => 'Nytt användarnamn:',
	'userrenametool-encoded' => 'URL-kodad:',
	'userrenametool-reason' => 'Anledning till namnbytet:',
	'userrenametool-move' => 'Flytta användarsidan och användardiskussionen (och deras undersidor) till det nya namnet',
	'userrenametool-reserve' => 'Reservera det gamla användarnamnet från framtida användning',
	'userrenametool-notify-renamed' => 'Skicka e-post till den omdöpta användaren när du är klar.',
	'userrenametool-warnings' => 'Varningar:',
	'userrenametool-requested-rename' => 'Användaren $1 begärde ett namnbyte',
	'userrenametool-did-not-request-rename' => 'Användaren $1 begärde inte ett namnbyte',
	'userrenametool-previously-renamed' => 'Användaren $1 har redan haft ett namnbyte',
	'userrenametool-phalanx-matches' => 'Phalanx-filter matchar $1:',
	'userrenametool-confirm' => 'Ja, byt namn på användaren',
	'userrenametool-submit' => 'Verkställ',
	'userrenametool-error-antispoof-conflict' => 'AntiSpoof-varning - det finns redan ett användarnamn som liknar "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof är inte installerat.',
	'userrenametool-errordoesnotexist' => 'Användaren "<nowiki>$1</nowiki>" finns inte',
	'userrenametool-errorexists' => 'Användaren "<nowiki>$1</nowiki>" finns redan.',
	'userrenametool-errorinvalid' => 'Användarnamnet "<nowiki>$1</nowiki>" är ogiltigt.',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>" är inte ett giltigt nytt användarnamn.',
	'userrenametool-errortoomany' => 'Användaren "<nowiki>$1</nowiki>" har $2 {{PLURAL:$2|redigering|redigeringar}}. Att byta namn på en användare som gjort mer än $3 {{PLURAL:$3|redigering|redigeringar}} kan påverka webbplatsens prestanda negativt.',
	'userrenametool-errorprocessing' => 'Processen för att byta namn på användare <nowiki>$1</nowiki> till <nowiki>$2</nowiki> pågår redan.',
	'userrenametool-errorblocked' => 'Användare <nowiki>$1</nowiki> blockeras av <nowiki>$2</nowiki> för $3.',
	'userrenametool-errorlocked' => 'Användaren <nowiki>$1</nowiki> är blockerad.',
	'userrenametool-errorbot' => 'Användare <nowiki>$1</nowiki> är en bot.',
	'userrenametool-error-request' => 'Ett problem inträffade i hanteringen av begäran. Gå tillbaks och försök igen.',
	'userrenametool-error-same-user' => 'Du kan inte byta namn på en användare till samma som tidigare.',
	'userrenametool-error-extension-abort' => 'En förlängning förhindrade namnbytningsprocessen.',
	'userrenametool-error-cannot-rename-account' => 'Att byta namn på användarkontot på den delade globala databasen misslyckades.',
	'userrenametool-error-cannot-create-block' => 'Misslyckades att skapa ett Phalanx-block.',
	'userrenametool-error-cannot-rename-unexpected' => 'Oväntat fel uppstod, kolla loggarna eller försök igen.',
	'userrenametool-warnings-characters' => 'Det nya användarnamnet innehåller ogiltiga tecken!',
	'userrenametool-warnings-maxlength' => 'Längden för det nya användarnamnet får inte överskrida 255 tecken!',
	'userrenametool-warn-repeat' => 'OBS! Användaren "<nowiki>$1</nowiki>" har redan byt namn till "<nowiki>$2</nowiki>".
Fortsätt endast om du behöver uppdatera saknad information.',
	'userrenametool-warn-table-missing' => 'Tabellen "<nowiki>$2</nowiki>" finns inte i databasen "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 började byta namn från $2 till $3 (loggar: $4).
Anledning: "$5".',
	'userrenametool-info-finished' => '$1 fullföljde namnbytet från $2 till $3 (loggar: $4).
Anledning: "$5".',
	'userrenametool-info-failed' => '$1 MISSLYCKADES att byta namn från $2 till $3 (loggar: $4).
Anledning: "$5".',
	'userrenametool-info-wiki-finished' => '$1 bytte namn från $2 till $3 den $4.
Anledning: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 bytte namn från $2 till $3, den $4, med fel.
Anledning: "$5".',
	'userrenametool-info-in-progress' => 'Namnbytningsprocessen pågår just nu.
Resten kommer att slutföras i bakgrunden.
Du kommer att meddelas via e-post när det är slutfört.',
	'userrenametool-success' => 'Användaren "<nowiki>$1</nowiki>" har fått sitt namn bytt till "<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => 'Vill du verkligen göra det här?',
	'userrenametool-confirm-yes' => 'Ja',
	'userrenametool-confirm-no' => 'Nej',
	'userrenametool-page-exists' => 'Sidan $1 finns redan och kan inte skrivas över automatiskt.',
	'userrenametool-page-moved' => 'Sidan $1 har flyttats till $2.',
	'userrenametool-page-unmoved' => 'Sidan $1 kunde inte flyttas till $2.',
	'userrenametool-finished-email-subject' => 'Namnbytningsprocessen är slutförd för [$1]',
	'userrenametool-finished-email-body-text' => 'Flyttningsprocessen för "<nowiki>$1</nowiki>" till "<nowiki>$2</nowiki>" har slutförts.',
	'userrenametool-finished-email-body-html' => 'Flyttningsprocessen för "<nowiki>$1</nowiki>" till "<nowiki>$2</nowiki>" har slutförts.',
	'userrenametool-logpage' => 'Logg över användarnamnsbyten',
	'userrenametool-logpagetext' => 'Detta är en logg över byten av användarnamn',
	'userrenametool-logentry' => 'bytte namn på $1 till "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 redigering|$1 redigeringar}}.
Anledning: $2',
	'userrenametool-move-log' => 'Flyttade automatiskt sidan när namnet byttes på användaren "[[User:$1|$1]]" till "[[User:$2|$2]]"',
	'right-renameuser' => 'Ändra användares namn',
	'action-renameuser' => 'byt namn på användare',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'renameuser' => 'వాడుకరి పేరుమార్చు',
	'userrenametool-desc' => "వాడుకరి పేరు మార్చండి (''renameuser'' అన్న అధికారం కావాలి)",
	'userrenametool-old' => 'ప్రస్తుత వాడుకరి పేరు:',
	'userrenametool-new' => 'కొత్త వాడుకరి పేరు:',
	'userrenametool-reason' => 'పేరు మార్చడానికి కారణం:',
	'userrenametool-move' => 'సభ్యుని పేజీ, చర్చాపేజీలను (వాటి ఉపపేజీలతో సహా) కొత్త పేరుకు తరలించండి',
	'userrenametool-reserve' => 'పాత వాడుకరిపేరుని భవిష్యత్తులో వాడకుండా నిరోధించు',
	'userrenametool-warnings' => 'హెచ్చరికలు:',
	'userrenametool-confirm' => 'అవును, వాడుకరి పేరు మార్చు',
	'userrenametool-submit' => 'పంపించు',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" పేరుగల వాడుకరి లేరు.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" పేరుతో వాడుకరి ఇప్పటికే ఉన్నారు.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" అనే వాడుకరిపేరు సరైనది కాదు.',
	'userrenametool-errortoomany' => 'వాడుకరి "<nowiki>$1</nowiki>" $2 {{PLURAL:$2|రచన|రచనలు}} చేసారు. $3 కంటే ఎక్కువ {{PLURAL:$3|రచన|రచనలు}} చేసిన వాడుకరి పేరు మార్చడం వలన సైటు పనితీరుపై ప్రతికూల ప్రభావం పడగలదు.',
	'userrenametool-error-request' => 'మీ అభ్యర్థనను స్వీకరించేటప్పుడు ఒక సమస్య తలెత్తింది. దయచేసి వెనక్కు వెళ్లి ఇంకోసారి ప్రయత్నించండి.',
	'userrenametool-error-same-user' => 'సభ్యనామాన్ని ఇంతకు ముందు ఉన్న సభ్యనామంతోనే మార్చడం కుదరదు.',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" అనే సభ్యనామాన్ని "<nowiki>$2</nowiki>"గా మార్చేసాం.',
	'userrenametool-confirm-yes' => 'అవును',
	'userrenametool-confirm-no' => 'కాదు',
	'userrenametool-page-exists' => '$1 పేజీ ఇప్పటికే ఉంది, కాబట్టి ఆటోమాటిగ్గా దానిపై కొత్తపేజీని రుద్దడం కుదరదు.',
	'userrenametool-page-moved' => '$1 పేజీని $2 పేజీకి తరలించాం.',
	'userrenametool-page-unmoved' => '$1 పేజీని $2 పేజీకి తరలించలేక పోయాం.',
	'userrenametool-logpage' => 'వాడుకరి పేరుమార్పుల చిట్టా',
	'userrenametool-logpagetext' => 'ఇది వాడుకరి పేర్లకి జరిగిన మార్పుల చిట్టా.',
	'userrenametool-logentry' => '$1ని "$2"గా పేరు మార్చారు',
	'userrenametool-log' => '{{PLURAL:$1|ఒక దిద్దుబాటు|$1 దిద్దుబాట్లు}}. కారణం: $2',
	'userrenametool-move-log' => '"[[User:$1|$1]]" పేరును "[[User:$2|$2]]"కు మార్చడంతో పేజీని ఆటోమాటిగ్గా తరలించాం',
	'right-renameuser' => 'వాడుకరుల పేరు మార్చడం',
);

/** Tetum (tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'renameuser' => "Fó naran foun ba uza-na'in sira",
	'userrenametool-desc' => "Fó naran foun ba uza-na'in sira (presiza priviléjiu ''renameuser'')",
	'userrenametool-old' => "Naran uza-na'in atuál:",
	'userrenametool-new' => "Naran uza-na'in foun:",
	'userrenametool-reason' => 'Motivu:',
	'userrenametool-move' => "Book pájina uza-na'in no diskusaun (no sub-pájina) ba naran foun",
	'userrenametool-confirm' => 'Sin, fó naran foun',
	'userrenametool-submit' => 'Fó naran foun',
	'userrenametool-errordoesnotexist' => 'Uza-na\'in "<nowiki>$1</nowiki>" la iha.',
	'userrenametool-page-moved' => 'Book tiha pájina $1 ba $2.',
	'userrenametool-page-unmoved' => 'La bele book pájina $1 ba $2.',
	'right-renameuser' => "Fó naran foun ba uza-na'in sira",
);

/** Tajik (Cyrillic script) (тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'renameuser' => 'Тағйири номи корбарӣ',
	'userrenametool-desc' => "Номи як корбарро тағйир медиҳад (ниёзманд ба ихтиёроти ''тағйирином'' аст)",
	'userrenametool-old' => 'Номи корбари феълӣ:',
	'userrenametool-new' => 'Номи корбари ҷадид:',
	'userrenametool-reason' => 'Иллати тағйири номи корбарӣ:',
	'userrenametool-move' => 'Саҳифаи корбарӣ ва саҳифаи баҳси корбар (ва зерсаҳифаҳои он)ро интиқол бидеҳ',
	'userrenametool-reserve' => 'Бастани номи корбарии кӯҳна аз истифодаи оянда',
	'userrenametool-warnings' => 'Ҳушдорҳо:',
	'userrenametool-confirm' => 'Бале, номи корбариро тағйир бидеҳ',
	'userrenametool-submit' => 'Сабт',
	'userrenametool-errordoesnotexist' => 'Номи корбарӣ "<nowiki>$1</nowiki>" вуҷуд надорад.',
	'userrenametool-errorexists' => 'Номи корбарӣ "<nowiki>$1</nowiki>" истифода шудааст.',
	'userrenametool-errorinvalid' => 'Номи корбарӣ "<nowiki>$1</nowiki>" ғайри миҷоз аст.',
	'userrenametool-errortoomany' => 'Корбар "<nowiki>$1</nowiki>" $2 ҳиссагузориҳо дорад, тағйири номи корбаре, ки беш аз $3 ҳиссагузориҳо дорад ва ба амал кардани сомона таъсире мушкилӣ метавонад расонад.',
	'userrenametool-error-request' => 'Дар дарёфти дархост мушкилие пеш омад. Лутфан ба саҳифаи қаблӣ бозгардед ва дубора талош кунед.',
	'userrenametool-error-same-user' => 'Шумо наметавонед номи як корбарро ба ҳамон номи қаблиаш тағйир диҳед.',
	'userrenametool-success' => 'Номи корбар "<nowiki>$1</nowiki>" ба "<nowiki>$2</nowiki>" тағйир ёфт.',
	'userrenametool-page-exists' => 'Саҳифаи $1 аллакай вуҷуд дорда ва ба таври худкор қобили бознависӣ нест.',
	'userrenametool-page-moved' => 'Саҳифаи $1 ба $2 кӯчонида шуд.',
	'userrenametool-page-unmoved' => 'Имкони кӯчонидани саҳифаи $1 ба $2 вуҷуд надорад.',
	'userrenametool-logpage' => 'Гузориши тағйири номи корбар',
	'userrenametool-logpagetext' => 'Ин гузориши тағйири номи корбарон аст',
	'userrenametool-logentry' => 'номи $1ро ба "$2" тағйир дод',
	'userrenametool-log' => '{{PLURAL:$1|1 вироиш|$1 вироишҳо}}. Далел: $2',
	'userrenametool-move-log' => 'Саҳифа дар вақти тағйири номи корбар "[[User:$1|$1]]" ба "[[User:$2|$2]]" ба таври худкор кӯчонида шуд',
	'right-renameuser' => 'Тағйири номи корбарон',
);

/** Tajik (Latin script) (tojikī)
 */
$messages['tg-latn'] = array(
	'renameuser' => 'Taƣjiri nomi korbarī',
	'right-renameuser' => 'Taƣjiri nomi korbaron',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'renameuser' => 'เปลี่ยนชื่อผู้ใช้',
	'userrenametool-error-request' => 'มีปัญหาเกิดขึ้นเกี่ยวกับการรับคำเรียกร้องของคุณ กรุณากลับไปที่หน้าเดิม และ พยายามอีกครั้ง',
	'userrenametool-success' => 'ผู้ใช้:<nowiki>$1</nowiki> ถูกเปลี่ยนชื่อเป็น ผู้ใช้:<nowiki>$2</nowiki> เรียบร้อยแล้ว',
	'right-renameuser' => 'เปลี่ยนชื่อผู้ใช้',
);

/** Turkmen (Türkmençe)
 */
$messages['tk'] = array(
	'renameuser' => 'Ulanyjy adyny üýtget',
	'right-renameuser' => 'Ulanyjylaryň adyny üýtget',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'userrenametool' => 'Palitan ang pangalan ng tagagamit',
	'renameuser' => 'Muling pangalanan ang tagagamit',
	'userrenametool-warning' => '<strong>Paki maingat na basahin ang sumusunod na kabatiran</strong>:<p>Bago muling pangalan ang isang tagagamit, paki gawing tinitiyak na <strong>ang lahat ng impormasyon ay tama</strong>, at tiyakin na <strong>alam ng tagagamit na maaaring ito ay mangailangan ng ilang mga oras bago makumpleto</strong>.
<br />Paki maging maalam na dahil sa ilang panlabas na mga kadahilanan ang unang bahagi ng proseso <strong>ay maaaring magresulta sa isang pahinang walang laman</strong>, hindi ibig sabihin nito na ang proseso ay hindi mabubuo nang tama.</p><p>Masusubaybayan mo ang progreso ng proseso sa pamamagitan ng [[Special:Stafflog|pagtatala ng Tauhan]], gayon din <strong>ang sistema ay magpapadala sa iyo ng isang e-liham kapag makukumpleto na ang kabuuan ng pagpapalit ng pangalan</strong>.</p>',
	'userrenametool-desc' => "Nagdaragdag ng isang [[Special:Renameuser|natatanging pahina]] para mapangalanang muli ang isang tagagamit (kailangang ang karapatang ''pangalanangmuliangtagagamit'')",
	'userrenametool-old' => 'Pangkasalukuyang pangalan ng tagagamit:',
	'userrenametool-new' => 'Bagong pangalan ng tagagamit:',
	'userrenametool-reason' => 'Dahil para sa muling pagpapangalan:',
	'userrenametool-move' => 'Ilipat ang mga pahina ng tagagamit at pangusapan (at mga kabahaging pahina nila) patungo sa bagong pangalan',
	'userrenametool-reserve' => 'Hadlangan ang dating pangalan ng tagagamit mula sa muling paggamit sa hinaharap',
	'userrenametool-notify-renamed' => 'Magpadala ng e-liham sa muling pinangalanang tagagamit kapag tapos na',
	'userrenametool-warnings' => 'Mga babala:',
	'userrenametool-requested-rename' => 'Humiling si $1 ng isang muling pagpapangalan',
	'userrenametool-did-not-request-rename' => 'Hindi humiling si $1 ng isang pagpapalit ng pangalan',
	'userrenametool-previously-renamed' => 'Ang tagagamit na si $1 ay nagkaroon na ng isang muling pagpapangalan',
	'userrenametool-phalanx-matches' => 'Mga pansala ng Phalanx na tumutugma sa $1:',
	'userrenametool-confirm' => 'Oo, pangalanang muli ang tagagamit',
	'userrenametool-submit' => 'Ipasa',
	'userrenametool-errordoesnotexist' => 'Hindi pa umiiral ang tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'Umiiral na ang tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalid' => 'Hindi tanggap ang pangalan ng tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalidnew' => 'Hindi katanggap-ttanggap ang bagong pangalan ng tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errortoomany' => 'Ang tagagamit na si "<nowiki>$1</nowiki>" ay mayroong $2 {{PLURAL:$2|ambag|mga ambag}}, ang muling pagpapangalan sa isang tagagamit na may mahigit sa $3 {{PLURAL:$3|ambag|mga ambag}} ay makakaapekto sa gawain ng sayt/sityo.',
	'userrenametool-errorprocessing' => 'Ang proseso ng muling pagpapangalan para sa tagagamit na si <nowiki>$1</nowiki> upang maging si <nowiki>$2</nowiki> ay isinasagawa na.',
	'userrenametool-errorblocked' => 'Ang tagagamit na si <nowiki>$1</nowiki> ay hinarang ni <nowiki>$2</nowiki> para sa $3.',
	'userrenametool-errorlocked' => 'Hinadlangan ang tagagamit na si <nowiki>$1</nowiki>.',
	'userrenametool-errorbot' => 'Isang bot ang tagagamit na <nowiki>$1</nowiki>.',
	'userrenametool-error-request' => 'Nagkaroon ng isang suliranin sa pagtanggap ng kahilingan.
Magbalik lamang at subukan uli.',
	'userrenametool-error-same-user' => 'Hindi mo maaaring pangalanang muli ang tagagamit patungo sa kaparehong bagay na katulad ng dati.',
	'userrenametool-error-extension-abort' => 'Hinadlangan ng isang dugtong ang pagsasagawa ng muling pagpapangalan.',
	'userrenametool-error-cannot-rename-account' => 'Nabigo ang muling pagpapangalan ng akawnt ng tagagamit na nasa ibabaw ng pinagsasaluhang pandaigdigang kalipunan ng dato.',
	'userrenametool-error-cannot-create-block' => 'Nabigo ang paglikha ng hadlang na Phalanx.',
	'userrenametool-warn-repeat' => 'Pansinin! Ang tagagamit na "<nowiki>$1</nowiki>" ay muli nang pinangalanan upang maging "<nowiki>$2</nowiki>".
Magpatuloy lamang sa pagsasagawa kung kailangan mong isapanahon ang ilang nawawalang mga kabatiran.',
	'userrenametool-warn-table-missing' => 'Hindi umiiral ang talangguhit na "<nowiki>$2</nowiki>" sa loob ng kalipunan ng datong "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => 'Sinimulan ni $1 na muling pangalanan ang: $2 upang maging $3 (mga pagtatala: $4).
Dahilan: "$5".',
	'userrenametool-info-finished' => 'Nakumpleto na ni $1 ang muling pagpapangalan: $2 upang maging $3 (mga pagtatala: $4).
Dahilan: "$5".',
	'userrenametool-info-failed' => 'NABIGO si $1 sa muling pagpapangalan: $2 upang maging $3 (mga pagtatala: $4).
Dahilan: "$5".',
	'userrenametool-info-wiki-finished' => 'Muling pinangalanan ni $1 si $2 upang maging $3 noong $4.
Dahilan: "$5".',
	'userrenametool-info-wiki-finished-problems' => 'Muling pinangalanan ni $1 ang $2 upang maging $3 noong $4 na may mga kamalian.
Dahilan: "$5".',
	'userrenametool-info-in-progress' => 'Isinasagawa ang muling pagpapangalan.
Ang natitira pa ay isasagawa sa likuran.
Pababatiran ka sa pamamagitan ng e-liham kapag nabuo na ito.',
	'userrenametool-success' => 'Ang tagagamit na "<nowiki>$1</nowiki>" ay muling napangalanan na patungong "<nowiki>$2</nowiki>".',
	'userrenametool-confirm-intro' => 'Talaga bang nais mong gawin ito?',
	'userrenametool-confirm-yes' => 'Oo',
	'userrenametool-confirm-no' => 'Hindi',
	'userrenametool-page-exists' => 'Umiiral na ang pahinang $1 at hindi maaaring kusang mapatungan.',
	'userrenametool-page-moved' => 'Ang pahinang $1 ay nailipat na patungo sa $2.',
	'userrenametool-page-unmoved' => 'Hindi mailipat ang pahinang $1 patungo sa $2.',
	'userrenametool-finished-email-subject' => 'Nabuo ang pagsasagawa ng muling pagpapangalan para sa [$1]',
	'userrenametool-finished-email-body-text' => 'Nabuo na ang pagsasagawa ng paglipat para sa "<nowiki>$1</nowiki>" papunta sa "<nowiki>$2</nowiki>".',
	'userrenametool-finished-email-body-html' => 'Nabuo na ang pagsasagawa ng paglipat para sa "<nowiki>$1</nowiki>" papunta sa "<nowiki>$2</nowiki>".',
	'userrenametool-logpage' => 'Talaan ng muling pagpapangalan ng tagagamit',
	'userrenametool-logpagetext' => 'Isa itong pagtatala/talaan ng mga pagbabago sa mga pangalan ng tagagamit.',
	'userrenametool-logentry' => 'muling pinangalan si $1 patungo sa "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 pagbabago|$1 mga pagbabago}}. Dahilan: $2',
	'userrenametool-move-log' => 'Kusang inilipat ang pahina habang muling pinapangalanan ang tagagamit na si "[[User:$1|$1]]" patungo sa "[[User:$2|$2]]"',
	'right-renameuser' => 'Muling pangalanan ang mga tagagamit',
);

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'userrenametool-confirm-yes' => 'Бәле',
	'userrenametool-confirm-no' => 'Не',
);

/** Tongan (lea faka-Tonga)
 */
$messages['to'] = array(
	'renameuser' => 'Liliu hingoa ʻo e ʻetita',
	'userrenametool-old' => 'Hingoa motuʻa ʻo e ʻetita:',
	'userrenametool-new' => 'Hingoa foʻou ʻo e ʻetita:',
	'userrenametool-submit' => 'Fai ā liliuhingoa',
	'userrenametool-errordoesnotexist' => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku ʻikai toka tuʻu ia',
	'userrenametool-errorexists' => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku toka tuʻu ia',
	'userrenametool-errorinvalid' => 'ʻOku taʻeʻaonga ʻa e hingoa fakaʻetita ko "<nowiki>$1</nowiki>"',
	'userrenametool-success' => 'Ko e ʻetita "<nowiki>$1</nowiki>" kuo liliuhingoa ia kia "<nowiki>$2</nowiki>"',
	'userrenametool-logpage' => 'Tohinoa ʻo e liliu he hingoa ʻo e ʻetita',
	'userrenametool-logpagetext' => 'Ko e tohinoa ʻeni ʻo e ngaahi liliu ki he hingoa ʻo e kau ʻetita',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Runningfridgesrule
 * @author Uğur Başak
 */
$messages['tr'] = array(
	'renameuser' => 'Kullanıcı adı değiştir',
	'userrenametool-desc' => "Kullanıcıyı yeniden adlandırmak için bir [[Special:Renameuser|özel sayfa]] ekler (''kullanıcıyıyenidenadlandır'' hakkı gerekir)",
	'userrenametool-old' => 'Şu anda ki kullanıcı adı:',
	'userrenametool-new' => 'Yeni kullanıcı adı:',
	'userrenametool-reason' => 'Neden:',
	'userrenametool-move' => 'Kullanıcı ve tartışma sayfalarını (ve alt sayfalarını) yeni isme taşı',
	'userrenametool-reserve' => 'Eski kullanıcı adını ilerdeki kullanımlar için engelle',
	'userrenametool-warnings' => 'Uyarılar:',
	'userrenametool-confirm' => 'Evet, kullanıcıyı yeniden adlandır',
	'userrenametool-submit' => 'Gönder',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" adlı kullanıcı bulunmamaktadır.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" kullanıcısı zaten mevcut.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" kullanıcı adı geçersiz.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" kullanıcısının $2 {{PLURAL:$2|katkısı|katkısı}} var, $3\'den fazla {{PLURAL:$3|değişikliğe|değişikliğe}} sahip bir kullanıcıyı yeniden adlandırmak site performansını kötü yönde etkileyecektir.',
	'userrenametool-error-request' => 'İsteğin alımıyla ilgili bir problem var.
Lütfen geri dönüp tekrar deneyin.',
	'userrenametool-error-same-user' => 'Bir kullanıcıyı eskiden olduğu isme yeniden adlandıramazsınız.',
	'userrenametool-success' => 'Daha önce "<nowiki>$1</nowiki>" olarak kayıtlı kullanıcının rumuzu "<nowiki>$2</nowiki>" olarak değiştirilmiştir.',
	'userrenametool-page-exists' => '$1 sayfası zaten mevcut ve otomatik olarak üstüne yazılamaz.',
	'userrenametool-page-moved' => '$1 sayfası $2 sayfasına taşındı.',
	'userrenametool-page-unmoved' => '$1 sayfası $2 sayfasına taşınamıyor.',
	'userrenametool-logpage' => 'Kullanıcı adı değişikliği kayıtları',
	'userrenametool-logpagetext' => 'Aşağıda bulunan liste adı değiştirilmiş kullanıcıları gösterir.',
	'userrenametool-logentry' => '$1, "$2" olarak yeniden adlandırıldı',
	'userrenametool-log' => '{{PLURAL:$1|1 düzenleme|$1 düzenleme}}. Neden: $2',
	'userrenametool-move-log' => 'Kullanıcıyı "[[User:$1|$1]]" isminden "[[User:$2|$2]]" ismine yeniden adlandırırken, sayfa otomatik olarak taşındı',
	'right-renameuser' => 'Kullanıcıların adlarını değiştirir',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'userrenametool-confirm-yes' => 'Әйе',
	'userrenametool-confirm-no' => 'Юк',
);

/** Ukrainian (українська)
 * @author A1
 * @author AS
 * @author Ahonc
 * @author Andriykopanytsia
 * @author EugeneZelenko
 * @author Тест
 */
$messages['uk'] = array(
	'userrenametool' => 'Зміна імені користувача',
	'renameuser' => 'Перейменувати користувача',
	'userrenametool-warning' => 'Перш ніж перейменовувати учасника, переконайтеся що вся інформація вірна, і повідомте про це учаснику, може знадобитися якийсь час для завершення.
Дивіться [[Special:Stafflog|журнал співробітників]] щоб отримати логи.',
	'userrenametool-desc' => "Додає [[Special:UserRenameTool|спеціальну сторінку]] для перейменування користувача (потрібні права ''renameuser'') і обробки всіх пов'язаних даних",
	'userrenametool-old' => "Поточне ім'я:",
	'userrenametool-new' => "Нове ім'я:",
	'userrenametool-encoded' => 'URL-адреса зашифрована:',
	'userrenametool-reason' => 'Причина перейменування:',
	'userrenametool-move' => 'Перейменувати також сторінку користувача, сторінку обговорення та їхні підсторінки',
	'userrenametool-reserve' => "Зарезервувати старе ім'я користувача для подальшого використання",
	'userrenametool-notify-renamed' => 'Надіслати повідомлення перейменованому учаснику після завершення',
	'userrenametool-warnings' => 'Попередження:',
	'userrenametool-requested-rename' => 'Користувач $1 запросив перейменування',
	'userrenametool-did-not-request-rename' => 'Користувач $1 не запрошував перейменування',
	'userrenametool-previously-renamed' => 'Користувач $1 вже переймонований',
	'userrenametool-phalanx-matches' => 'Фільтри Phalanx, які відповідають $1:',
	'userrenametool-confirm' => 'Так, перейменувати користувача',
	'userrenametool-submit' => 'Виконати',
	'userrenametool-error-antispoof-conflict' => 'Попередження AntiSpoof- уже існує ім\'я користувача схоже на "<nowiki>$1</nowiki>".',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof не встановлена.',
	'userrenametool-errordoesnotexist' => 'Користувач з іменем «<nowiki>$1</nowiki>» не зареєстрований.',
	'userrenametool-errorexists' => 'Користувач з іменем «<nowiki>$1</nowiki>» уже зареєстрований.',
	'userrenametool-errorinvalid' => "Недопустиме ім'я користувача: <nowiki>$1</nowiki>.",
	'userrenametool-errorinvalidnew' => "Недопустиме ім'я користувача: <nowiki>$1</nowiki>.",
	'userrenametool-errortoomany' => 'Користувач "<nowiki>$1</nowiki>" вніс $2 {{PLURAL:$2|редагування|редагування|редагувань}}, перейменування користувача з більш ніж $3 {{PLURAL:$3|редагуванням|редагуваннями}} може негативно вплинути на доступ до сайту.',
	'userrenametool-errorprocessing' => 'Перейменування користувача <nowiki>$1</nowiki> в <nowiki>$2</nowiki> вже триває.',
	'userrenametool-errorblocked' => 'Користувач <nowiki>$1</nowiki> заблокований <nowiki>$2</nowiki> на $3.',
	'userrenametool-errorlocked' => 'Користувач <nowiki>$1</nowiki> заблокований.',
	'userrenametool-errorbot' => 'Користувач <nowiki>$1</nowiki> — бот.',
	'userrenametool-error-request' => 'Виникли ускладнення з отриманням запиту. Будь ласка, поверніться назад і повторіть іще раз.',
	'userrenametool-error-same-user' => "Ви не можете змінити ім'я користувача на те саме, що було раніше.",
	'userrenametool-error-extension-abort' => 'Розширення запобігло процесу перейменування.',
	'userrenametool-error-cannot-rename-account' => 'Перейменування облікового запису користувача у спільній глобальній базі даних не вдалося.',
	'userrenametool-error-cannot-create-block' => 'Невдале створення блоку Phalanx.',
	'userrenametool-error-cannot-rename-unexpected' => 'Сталася неочікувана помилка, перевірте журнали або повторіть спробу.',
	'userrenametool-warnings-characters' => "Нове ім'я користувача містить неприпустимі символи!",
	'userrenametool-warnings-maxlength' => 'Довжина нового імені користувача не може перевищувати 255 символів!',
	'userrenametool-warn-repeat' => 'Увага! Учасник „<nowiki>$1</nowiki>“ вже перейменований у „<nowiki>$2</nowiki>“.
Продовжуйте обробку тільки, коли вам необхідно оновити деякі відсутні відомості.',
	'userrenametool-warn-table-missing' => 'Таблиця „<nowiki>$2</nowiki>“ не існує в базі даних "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 почав перейменування: $2 в $3 (записів: $4).
Причина: "$5".',
	'userrenametool-info-finished' => '$1 завершив перейменування: $2 в $3 (записів: $4).
Причина: "$5".',
	'userrenametool-info-failed' => '$1 не зумів перейменувати: $2 на $3 (записів: $4).
Причина: "$5".',
	'userrenametool-info-wiki-finished' => '$1 перейменував $2 в $3 на $4.
Причина: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 перейменував $2 на $3 у $4 з помилками.
Причина: "$5".',
	'userrenametool-info-in-progress' => 'Триває процес перейменування.
Решта виконується у фоновому режимі.
Ви будете повідомлені по електронній пошті, коли він буде завершений.',
	'userrenametool-success' => 'Користувач «<nowiki>$1</nowiki>» був перейменований на «<nowiki>$2</nowiki>».',
	'userrenametool-confirm-intro' => 'Ви дійсно хочете це зробити?',
	'userrenametool-confirm-yes' => 'Так',
	'userrenametool-confirm-no' => 'Ні',
	'userrenametool-page-exists' => 'Сторінка $1 вже існує і не може бути перезаписана автоматично.',
	'userrenametool-page-moved' => 'Сторінка $1 була перейменована на $2.',
	'userrenametool-page-unmoved' => 'Сторінка $1 не може бути перейменована на $2.',
	'userrenametool-finished-email-subject' => 'Процес перейменування користувача завершено для [$1]',
	'userrenametool-finished-email-body-text' => 'Процес переміщення для „<nowiki>$1</nowiki>“ на  „<nowiki>$2</nowiki>“ завершено.',
	'userrenametool-finished-email-body-html' => 'Процес переміщення для „<nowiki>$1</nowiki>“ на „<nowiki>$2</nowiki>“ завершено.',
	'userrenametool-logpage' => 'Журнал перейменувань користувачів',
	'userrenametool-logpagetext' => 'Це журнал здійснених перейменувань зареєстрованих користувачів.',
	'userrenametool-logentry' => 'перейменував $1 на «$2»',
	'userrenametool-log' => 'мав $1 {{PLURAL:$1|редагування|редагування|редагувань}}. Причина: $2',
	'userrenametool-move-log' => 'Автоматичне перейменування сторінки при перейменуванні користувача «[[User:$1|$1]]» на «[[User:$2|$2]]»',
	'right-renameuser' => 'Перейменування користувачів',
	'action-renameuser' => 'перейменувати користувачів',
);

/** Urdu (اردو)
 */
$messages['ur'] = array(
	'renameuser' => 'صارف کا نام تبدیل کریں',
	'userrenametool-log' => 'جن کی $1 ترامیم تھیں. $2',
);

/** vèneto (vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'renameuser' => 'Rinomina utente',
	'userrenametool-desc' => "Funsion par rinominar un utente (ghe vole i diriti de ''renameuser'')",
	'userrenametool-old' => 'Vecio nome utente:',
	'userrenametool-new' => 'Novo nome utente:',
	'userrenametool-reason' => 'Motivo del canbio nome',
	'userrenametool-move' => 'Rinomina anca la pagina utente, la pagina de discussion e le relative sotopagine',
	'userrenametool-reserve' => "Tien da conto el vecio nome utente par inpedir che'l vegna doparà in futuro",
	'userrenametool-warnings' => 'Avertimenti:',
	'userrenametool-confirm' => "Sì, rinomina l'utente",
	'userrenametool-submit' => 'Invia',
	'userrenametool-errordoesnotexist' => 'El nome utente "<nowiki>$1</nowiki>" no l\'esiste',
	'userrenametool-errorexists' => 'El nome utente "<nowiki>$1</nowiki>" l\'esiste de zà',
	'userrenametool-errorinvalid' => 'El nome utente "<nowiki>$1</nowiki>" no\'l xe mìa valido.',
	'userrenametool-errortoomany' => 'El nome utente "<nowiki>$1</nowiki>" el gà $2 {{PLURAL:$2|contributo|contributi}}. Modificar el nome de un utente con piassè de $3 {{PLURAL:$3|contributo|contributi}} podarìà conprométar le prestazion del sito.',
	'userrenametool-error-request' => 'Se gà verificà un problema ne la ricezion de la richiesta. Torna indrìo e ripróa da novo.',
	'userrenametool-error-same-user' => "No se pol rinominar un utente al stesso nome che'l gavea zà.",
	'userrenametool-success' => 'El nome utente "<nowiki>$1</nowiki>" el xe stà canbià in "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'La pagina $1 la esiste de zà; no se pole sovrascrìvarla automaticamente.',
	'userrenametool-page-moved' => 'La pagina $1 la xe stà spostà a $2.',
	'userrenametool-page-unmoved' => 'No se pole spostar la pagina $1 a $2.',
	'userrenametool-logpage' => 'Registro dei utenti rinominà',
	'userrenametool-logpagetext' => 'De seguito vien presentà el registro de le modifiche ai nomi utente',
	'userrenametool-logentry' => 'gà rinominà $1 in "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 contributo|$1 contributi}}. Motivo: $2',
	'userrenametool-move-log' => 'Spostamento automatico de la pagina - utente rinominà da "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Rinomina utenti',
);

/** Veps (vepsän kel’)
 */
$messages['vep'] = array(
	'right-renameuser' => 'Udesnimitada kävutajid',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'userrenametool' => 'Thay đổi tên của người dùng',
	'renameuser' => 'Đổi tên thành viên',
	'userrenametool-warning' => 'Trước khi đổi tên người dùng, hãy chắc chắn rằng tất cả các thông tin là chính xác, và đảm bảo người dùng biết nó có thể mất một thời gian để hoàn thành.
Xem [[Special:Stafflog|Staff log]]',
	'userrenametool-desc' => "Đổi tên thành viên (cần có quyền ''renameuser'')",
	'userrenametool-old' => 'Tên hiệu hiện nay:',
	'userrenametool-new' => 'Tên hiệu mới:',
	'userrenametool-reason' => 'Lý do đổi tên:',
	'userrenametool-move' => 'Di chuyển trang thành viên và thảo luận thành viên (cùng với trang con của nó) sang tên mới',
	'userrenametool-reserve' => 'Không cho phép ai lấy tên cũ',
	'userrenametool-notify-renamed' => 'Gửi e-mail cho người dùng khi việc đổi tên đã hoàn tất',
	'userrenametool-warnings' => 'Cảnh báo:',
	'userrenametool-confirm' => 'Đổi tên người dùng',
	'userrenametool-submit' => 'Thực hiện',
	'userrenametool-errordoesnotexist' => 'Thành viên “<nowiki>$1</nowiki>” không tồn tại.',
	'userrenametool-errorexists' => 'Thành viên “<nowiki>$1</nowiki>” đã hiện hữu.',
	'userrenametool-errorinvalid' => 'Tên thành viên “<nowiki>$1</nowiki>” không hợp lệ.',
	'userrenametool-errorinvalidnew' => 'Tên thành viên “<nowiki>$1</nowiki>” không hợp lệ.',
	'userrenametool-errortoomany' => 'Thành viên “<nowiki>$1</nowiki>” có $2 đóng góp, đổi tên thành viên có hơn $3 đóng góp có thể ảnh hưởng xấu đến hiệu năng của trang.',
	'userrenametool-errorprocessing' => 'Quá trình đổi tên cho người dùng <nowiki>$1</nowiki> thành <nowiki>$2</nowiki> là đã được tiến hành',
	'userrenametool-errorblocked' => 'Người dùng <nowiki>$1</nowiki> đã bị chặn bởi <nowiki>$2</nowiki> cho $3.',
	'userrenametool-errorlocked' => 'Thành viên <nowiki>$1</nowiki> đã bị cấm.',
	'userrenametool-errorbot' => 'Người dùng <nowiki>$1</nowiki> là một robot.',
	'userrenametool-error-request' => 'Có trục trặc trong tiếp nhận yêu cầu. Xin hãy quay lại và thử lần nữa.',
	'userrenametool-error-same-user' => 'Bạn không thể đổi tên thành viên sang tên y hệt như vậy.',
	'userrenametool-success' => 'Thành viên “<nowiki>$1</nowiki>” đã được đổi tên thành “<nowiki>$2</nowiki>”.',
	'userrenametool-confirm-yes' => 'Có',
	'userrenametool-confirm-no' => 'Không',
	'userrenametool-page-exists' => 'Trang $1 đã tồn tại và không thể bị tự động ghi đè.',
	'userrenametool-page-moved' => 'Trang $1 đã được di chuyển đến $2.',
	'userrenametool-page-unmoved' => 'Trang $1 không thể di chuyển đến $2.',
	'userrenametool-logpage' => 'Nhật trình đổi tên thành viên',
	'userrenametool-logpagetext' => 'Đây là nhật trình ghi lại các thay đổi đối với tên thành viên',
	'userrenametool-logentry' => 'đã đổi tên $1 thành “$2”',
	'userrenametool-log' => 'Đã có {{PLURAL:$1|1 sửa đổi|$1 sửa đổi}}. Lý do: $2',
	'userrenametool-move-log' => 'Đã tự động di chuyển trang khi đổi tên thành viên “[[User:$1|$1]]” thành “[[User:$2|$2]]”',
	'right-renameuser' => 'Đổi tên thành viên',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'renameuser' => 'Votanemön gebani',
	'userrenametool-desc' => "Votanemön gebani (gität: ''renameuser'' zesüdon)",
	'userrenametool-old' => 'Gebananem anuik:',
	'userrenametool-new' => 'Gebananem nulik:',
	'userrenametool-reason' => 'Kod votanemama:',
	'userrenametool-move' => 'Topätükön padi e bespikapadi gebana (e donapadis onsik) ad nem nulik',
	'userrenametool-reserve' => 'Neletön gebananemi rigik (pos votanemam) ad pagebön ün fütür',
	'userrenametool-warnings' => 'Nuneds:',
	'userrenametool-confirm' => 'Si, votanemolös gebani',
	'userrenametool-submit' => 'Sedön',
	'userrenametool-errordoesnotexist' => 'Geban: "<nowiki>$1</nowiki>" no dabinon.',
	'userrenametool-errorexists' => 'Geban: "<nowiki>$1</nowiki>" ya dabinon.',
	'userrenametool-errorinvalid' => 'Gebananem: "<nowiki>$1</nowiki>" no lonöfon.',
	'userrenametool-errortoomany' => 'Geban: "<nowiki>$1</nowiki>" labon {{PLURAL:$2|keblünoti|keblünotis}} $2. Votanemam gebana labü {{PLURAL:$3|keblünot|keblünots}} plu $3 ba oflunon negudiko jäfidi bevüresodatopäda at.',
	'userrenametool-error-request' => 'Ädabinon säkäd pö daget bega. Geikolös, begö! e steifülolös dönu.',
	'userrenametool-error-same-user' => 'No kanol votanemön gebani ad nem ot.',
	'userrenametool-success' => 'Geban: "<nowiki>$1</nowiki>" pevotanemon ad "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Pad: $1 ya dabinon e no kanon pamoükön itjäfidiko.',
	'userrenametool-page-moved' => 'Pad: $1 petopätükon ad pad: $2.',
	'userrenametool-page-unmoved' => 'No eplöpos ad topätükön padi: $1 ad pad: $2.',
	'userrenametool-logpage' => 'Jenotalised votanemamas',
	'userrenametool-logpagetext' => 'Is palisedons votükams gebananemas.',
	'userrenametool-logentry' => 'evotanemon eli $1 ad "$2"',
	'userrenametool-log' => '{{PLURAL:$1|redakam 1|redakams $1}}. Kod: $2',
	'userrenametool-move-log' => 'Pad petopätükon itjäfidiko dü votanemama gebana: "[[User:$1|$1]]" ad "[[User:$2|$2]]"',
	'right-renameuser' => 'Votanemön gebanis',
);

/** Walloon (walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'userrenametool' => "Candjî l' no d' èn uzeu",
	'renameuser' => 'Rilomer èn uzeu',
	'userrenametool-desc' => "Radjoute ene [[Special:UserRenameTool|pådje sipeciåle]] po pleur rilome èn uzeu (i fåt-st aveur li droet ''renameuser'') et d' traitî totes les dnêyes aloyeyes.",
	'userrenametool-old' => "No d' elodjaedje pol moumint:",
	'userrenametool-new' => "Novea no d' elodjaedje:",
	'userrenametool-reason' => 'Råjhon pol rilomaedje:',
	'userrenametool-move' => "Displaecî les pådjes d' uzeu et d' copene (eyet leus dzo-pådjes) viè l' novea no",
	'userrenametool-reserve' => "Espaitchî l' eployaedje do vî no",
	'userrenametool-notify-renamed' => "Evoyî èn emile a l' uzeu on côp k' c' est fwait",
	'userrenametool-warnings' => 'Adviertixhmints:',
	'userrenametool-requested-rename' => "L' uzeu $1 a dmandé a candjî s' no",
	'userrenametool-did-not-request-rename' => "L' uzeu $1 n' a nén dmandé po candjî s' no",
	'userrenametool-previously-renamed' => "L' uzeu $1 a ddja yeu on candjmint d' no",
	'userrenametool-phalanx-matches' => "Passetes ''phalanx'' ki corespondèt a $1:",
	'userrenametool-confirm' => "Oyi, candjî l' no d' l' uzeu",
	'userrenametool-submit' => 'Evoye',
	'userrenametool-errordoesnotexist' => "L' uzeu «<nowiki>$1</nowiki>» n' egzistêye nén",
	'userrenametool-errorexists' => "L' uzeu «<nowiki>$1</nowiki>» egzistêye dedja",
	'userrenametool-errorinvalid' => "Li no d' elodjaedje «<nowiki>$1</nowiki>» n' est nén on no valide",
	'userrenametool-errorinvalidnew' => "Li no d' elodjaedje «<nowiki>$1</nowiki>» n' est nén on no valide.",
	'userrenametool-errortoomany' => "L' uzeu «<nowiki>$1</nowiki>» a $2 contribouwaedjes, rilomer èn uzeu avou pus di $3 contribouwaedjes pout aveur des consecwinces sol performance del waibe",
	'userrenametool-success' => "L' uzeu «<nowiki>$1</nowiki>» a stî rlomé a «<nowiki>$2</nowiki>»",
	'userrenametool-confirm-intro' => 'El voloz vs vormint fé?',
	'userrenametool-confirm-yes' => 'Oyi',
	'userrenametool-confirm-no' => 'Neni',
	'userrenametool-page-exists' => "Li pådje $1 egzistêye dedja et n' pout nén esse otomaticmint spotcheye.",
	'userrenametool-page-moved' => 'Li pådje $1 a stî displaeceye viè $2.',
	'userrenametool-page-unmoved' => 'Li pådje $1 èn pout nén esse displaeceye viè $2.',
	'userrenametool-logpage' => "Djournå des candjmints d' no d' uzeus",
	'userrenametool-logpagetext' => "Chal pa dzo c' est ene djivêye des uzeus k' ont candjî leu no d' elodjaedje.",
	'userrenametool-logentry' => "a rlomé l' uzeu «$1» a «$2»",
	'userrenametool-log' => "k' aveut ddja fwait $1 candjmints. $2",
	'userrenametool-move-log' => "Pådje displaeceye otomaticmint tot rlomant l' uzeu «[[User:$1|$1]]» viè «[[User:$2|$2]]»",
	'right-renameuser' => 'Rilomer des uzeus',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'renameuser' => 'בײַטן באַניצער נאָמען',
	'userrenametool-old' => 'לויפיגער באניצער-נאמען:',
	'userrenametool-new' => 'נייער באניצער-נאמען',
	'userrenametool-errordoesnotexist' => 'דער באניצער "<nowiki>$1</nowiki>" עקסיסטירט נישט.',
	'userrenametool-errorexists' => 'דער באניצער "<nowiki>$1</nowiki>" עקסיסטירט שוין.',
	'userrenametool-errorinvalid' => 'דער באניצער נאמען "<nowiki>$1</nowiki>" איז נישט גילטיק.',
	'userrenametool-logpage' => 'באַניצער נאָמען-טויש לאָג-בוך',
	'right-renameuser' => 'בײַטן באַניצער נעמען',
);

/** Cantonese (粵語)
 */
$messages['yue'] = array(
	'renameuser' => '改用戶名',
	'userrenametool-desc' => "幫用戶改名 (需要 ''renameuser'' 權限)",
	'userrenametool-old' => '現時嘅用戶名:',
	'userrenametool-new' => '新嘅用戶名:',
	'userrenametool-reason' => '改名嘅原因:',
	'userrenametool-move' => '搬用戶頁同埋佢嘅對話頁（同埋佢哋嘅細頁）到新名',
	'userrenametool-warnings' => '警告:',
	'userrenametool-confirm' => '係，改呢個用戶名',
	'userrenametool-submit' => '遞交',
	'userrenametool-errordoesnotexist' => '用戶"<nowiki>$1</nowiki>"唔存在',
	'userrenametool-errorexists' => '用戶"<nowiki>$1</nowiki>"已經存在',
	'userrenametool-errorinvalid' => '用戶名"<nowiki>$1</nowiki>"唔正確',
	'userrenametool-errortoomany' => '用戶"<nowiki>$1</nowiki>"貢獻咗$2次，對改一個超過$3次的用戶名嘅用戶可能會影響網站嘅效能',
	'userrenametool-error-request' => '響收到請求嗰陣出咗問題。
請返去再試過。',
	'userrenametool-error-same-user' => '你唔可以改一位用戶係同之前嘅嘢一樣。',
	'userrenametool-success' => '用戶"<nowiki>$1</nowiki>"已經改咗名做"<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => '$1呢一版已經存在，唔可以自動重寫。',
	'userrenametool-page-moved' => '$1呢一版已經搬到去$2。',
	'userrenametool-page-unmoved' => '$1呢一版唔能夠搬到去$2。',
	'userrenametool-logpage' => '用戶改名日誌',
	'userrenametool-logpagetext' => '呢個係改用戶名嘅日誌',
	'userrenametool-logentry' => '已經幫 $1 改咗名做 "$2"',
	'userrenametool-log' => '擁有$1次編輯。 原因: $2',
	'userrenametool-move-log' => '當由"[[User:$1|$1]]"改名做"[[User:$2|$2]]"嗰陣已經自動搬咗用戶頁',
	'right-renameuser' => '改用戶名',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Gzdavidwong
 * @author Hydra
 * @author Hzy980512
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'userrenametool' => '更改一个用户的名称',
	'renameuser' => '用户重命名',
	'userrenametool-desc' => "为用户重命名 (需要 ''renameuser'' 权限)",
	'userrenametool-old' => '当前用户名:',
	'userrenametool-new' => '新用户名:',
	'userrenametool-reason' => '重命名的原因:',
	'userrenametool-move' => '移动用户页及其对话页（包括各子页）到新的名字',
	'userrenametool-reserve' => '封禁旧用户名，使之不能在日后使用',
	'userrenametool-notify-renamed' => '完成时发邮件给被重命名的用户',
	'userrenametool-warnings' => '警告:',
	'userrenametool-requested-rename' => '用户$1要求重命名',
	'userrenametool-did-not-request-rename' => '用户 $1 没有要求重命名',
	'userrenametool-previously-renamed' => '用户 $1 已经要求了重命名',
	'userrenametool-confirm' => '是，为用户重命名',
	'userrenametool-submit' => '提交',
	'userrenametool-error-antispoof-conflict' => 'AntiSpoof警告 - 现已有一个用户名和“<nowiki>$1</nowiki>”相似。',
	'userrenametool-error-antispoof-notinstalled' => 'AntiSpoof未安装。',
	'userrenametool-errordoesnotexist' => '用户"<nowiki>$1</nowiki>"不存在',
	'userrenametool-errorexists' => '用户"<nowiki>$1</nowiki>"已存在',
	'userrenametool-errorinvalid' => '用户名"<nowiki>$1</nowiki>"不可用',
	'userrenametool-errorinvalidnew' => '"<nowiki>$1</nowiki>"不是一个有效的新用户名。',
	'userrenametool-errortoomany' => '用户"<nowiki>$1</nowiki>"贡献了$2次，重命名一个超过$3次的用户会影响站点性能',
	'userrenametool-errorprocessing' => '用户<nowiki>$1</nowiki>重命名至<nowiki>$2</nowiki>过程已在进行中。',
	'userrenametool-errorlocked' => '用户 <nowiki>$1</nowiki> 已被封禁。',
	'userrenametool-errorbot' => '用户 <nowiki>$1</nowiki> 是一个机器人。',
	'userrenametool-error-request' => '在收到请求时出现问题。
请回去重试。',
	'userrenametool-error-same-user' => '您不可以更改一位用户是跟之前的东西一样。',
	'userrenametool-error-extension-abort' => '一个扩展阻碍了重命名进程。',
	'userrenametool-error-cannot-rename-account' => '在共享的全局数据库重命名用户失败。',
	'userrenametool-warnings-maxlength' => '新用户名长度不可超过255个字符！',
	'userrenametool-success' => '用户"<nowiki>$1</nowiki>"已经更名为"<nowiki>$2</nowiki>"',
	'userrenametool-confirm-intro' => '你真的想这样做呢？',
	'userrenametool-confirm-yes' => '是',
	'userrenametool-confirm-no' => '不',
	'userrenametool-page-exists' => '$1这一页己经存在，不能自动覆写。',
	'userrenametool-page-moved' => '$1这一页已经移动到$2。',
	'userrenametool-page-unmoved' => '$1这一页不能移动到$2。',
	'userrenametool-finished-email-subject' => '重命名用户 [$1] 的进程已完成',
	'userrenametool-finished-email-body-text' => '移动“<nowiki>$1</nowiki>”至“<nowiki>$2</nowiki>”已完成。',
	'userrenametool-finished-email-body-html' => '移动“<nowiki>$1</nowiki>”至“<nowiki>$2</nowiki>”的进程已完成。',
	'userrenametool-logpage' => '用户名变更日志',
	'userrenametool-logpagetext' => '这是用户名更改的日志',
	'userrenametool-logentry' => '已经把 $1 重命名为 "$2"',
	'userrenametool-log' => '拥有$1次编辑。 理由: $2',
	'userrenametool-move-log' => '当由"[[User:$1|$1]]"重命名作"[[User:$2|$2]]"时已经自动移动用户页',
	'right-renameuser' => '重新命名用户',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Lauhenry
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'userrenametool' => '更改用戶名稱',
	'renameuser' => '用戶重新命名',
	'userrenametool-desc' => "為用戶重新命名 (需要 ''renameuser'' 權限)",
	'userrenametool-old' => '現時用戶名:',
	'userrenametool-new' => '新用戶名:',
	'userrenametool-reason' => '重新命名的原因:',
	'userrenametool-move' => '移動用戶頁及其對話頁（包括各子頁）到新的名字',
	'userrenametool-reserve' => '封禁舊使用者名稱，使之不能在日後使用',
	'userrenametool-warnings' => '警告:',
	'userrenametool-confirm' => '是，為用戶重新命名',
	'userrenametool-submit' => '提交',
	'userrenametool-errordoesnotexist' => '用戶"<nowiki>$1</nowiki>"不存在',
	'userrenametool-errorexists' => '用戶"<nowiki>$1</nowiki>"已存在',
	'userrenametool-errorinvalid' => '用戶名"<nowiki>$1</nowiki>"不可用',
	'userrenametool-errortoomany' => '用戶"<nowiki>$1</nowiki>"貢獻了$2次，重新命名一個超過$3次的用戶會影響網站效能',
	'userrenametool-error-request' => '在收到請求時出現問題。
請回去重試。',
	'userrenametool-error-same-user' => '您不可以更改一位用戶是跟之前的東西一樣。',
	'userrenametool-success' => '用戶"<nowiki>$1</nowiki>"已經更名為"<nowiki>$2</nowiki>"',
	'userrenametool-confirm-yes' => '是',
	'userrenametool-confirm-no' => '否',
	'userrenametool-page-exists' => '$1這一頁己經存在，不能自動覆寫。',
	'userrenametool-page-moved' => '$1這一頁已經移動到$2。',
	'userrenametool-page-unmoved' => '$1這一頁不能移動到$2。',
	'userrenametool-logpage' => '用戶名變更日誌',
	'userrenametool-logpagetext' => '這是用戶名更改的日誌',
	'userrenametool-logentry' => '已經把 $1 重新命名為 "$2"',
	'userrenametool-log' => '擁有$1次編輯。 理由: $2',
	'userrenametool-move-log' => '當由"[[User:$1|$1]]"重新命名作"[[User:$2|$2]]"時已經自動移動用戶頁',
	'right-renameuser' => '重新命名用戶',
);

/** Zulu (isiZulu)
 */
$messages['zu'] = array(
	'userrenametool-submit' => 'Yisa',
);
