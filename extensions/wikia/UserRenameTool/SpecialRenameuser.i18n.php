<?php
/**
 * Internationalisation file for extension Renameuser.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'userrenametool' => "Change a user's name",
	'renameuser'          => 'Rename user',
	'userrenametool-warning' => 'Before renaming a user, please make sure all the information is correct, and ensure the user knows it may take some time to complete. See the [[Special:Stafflog|Staff log]] for logs.',
	'userrenametool-desc'     => 'Adds a [[Special:UserRenameTool|special page]] to rename a user (need \'\'renameuser\'\' right) and process all the related data',
	'userrenametool-old'       => 'Current username:',
	'userrenametool-new'       => 'New username:',
	'userrenametool-reason'    => 'Reason for rename:',
	'userrenametool-move'      => 'Move user and talk pages (and their subpages) to new name',
	'userrenametool-reserve'   => 'Block the old username from future use',
	'userrenametool-warnings'  => 'Warnings:',
	'userrenametool-confirm'   => 'Yes, rename the user',
	'userrenametool-submit'    => 'Change username',

	'userrenametool-errordoesnotexist' => 'The user "<nowiki>$1</nowiki>" does not exist.',
	'userrenametool-errorexists'       => 'The user "<nowiki>$1</nowiki>" already exists.',
	'userrenametool-errorinvalid'      => '"<nowiki>$1</nowiki>" is not a valid username.',
	'userrenametool-errorinvalidnew'      => '"<nowiki>$1</nowiki>" is not a valid new username.',
	'userrenametool-errortoomany'      => 'The user "<nowiki>$1</nowiki>" has $2 {{PLURAL:$2|contribution|contributions}}, renaming a user with more than $3 {{PLURAL:$3|contribution|contributions}} could adversely affect site performance.',
	'userrenametool-errorprocessing' => 'The rename process for user <nowiki>$1</nowiki> to <nowiki>$2</nowiki> is already in progress.',
	'userrenametool-errorblocked' => 'User <nowiki>$1</nowiki> is blocked by <nowiki>$2</nowiki> for $3.',
	'userrenametool-errorlocked' => 'User <nowiki>$1</nowiki> is locked.',
	'userrenametool-errorbot' => 'User <nowiki>$1</nowiki> is a bot.',
	'userrenametool-error-request'    => 'There was a problem with receiving the request.
Please go back and try again.',
	'userrenametool-error-same-user'  => 'You cannot rename a user to the same thing as before.',
	'userrenametool-error-extension-abort' => 'Some of the installed extension prevented the rename process.',
	'userrenametool-error-cannot-rename-account' => 'Renaming the user account on the shared global DB failed.',
	'userrenametool-error-cannot-create-block' => 'Creation of a log in block failed.',
	'userrenametool-warn-repeat'      => 'Attention! The user "<nowiki>$1</nowiki>" has already been renamed to "<nowiki>$2</nowiki>".
Continue processing only if you need to update some missing information.',
	'userrenametool-warn-table-missing' => 'Table "<nowiki>$2</nowiki>" does not exist in database "<nowiki>$1</nowiki>."',
	'userrenametool-info-started' => '$1 started to rename: $2 to $3 (logs: $4). Reason: "$5".',
	'userrenametool-info-finished' => '$1 completed rename: $2 to $3 (logs: $4). Reason: "$5".',
	'userrenametool-info-failed' => '$1 FAILED rename: $2 to $3 (logs: $4). Reason: "$5".',
	'userrenametool-info-wiki-finished' => '$1 renamed $2 to $3 on $4. Reason: "$5".',
	'userrenametool-info-wiki-finished-problems' => '$1 renamed $2 to $3 on $4 with errors. Reason: "$5".',
	'userrenametool-info-in-progress' => 'Rename process is in progress.
The rest will be done in background. You will be notified via e-mail when it is completed.',
	'userrenametool-success'           => 'The user "$1" has been renamed to "$2".',

	'userrenametool-confirm-intro' => 'Do you really want to do this?',
	'userrenametool-confirm-yes' => 'Yes',
	'userrenametool-confirm-no' => 'No',

	'userrenametool-page-exists'  => 'The page $1 already exists and cannot be automatically overwritten.',
	'userrenametool-page-moved'   => 'The page $1 has been moved to $2.',
	'userrenametool-page-unmoved' => 'The page $1 could not be moved to $2.',

	'userrenametool-finished-email-subject' => 'User rename process completed for [$1]',
	'userrenametool-finished-email-body-text' => 'The move process for "<nowiki>$1</nowiki>" to "<nowiki>$2</nowiki>" has been completed.',
	'userrenametool-finished-email-body-html' => 'The move process for "<nowiki>$1</nowiki>" to "<nowiki>$2</nowiki>" has been completed.',
	
	'userrenametool-logpage'     => 'User rename log',
	'userrenametool-logpagetext' => 'This is a log of changes to user names.',
	'userrenametool-logentry'    => 'renamed $1 to "$2"',
	'userrenametool-log'        => '{{PLURAL:$1|1 edit|$1 edits}}. Reason: $2',
	'userrenametool-move-log'   => 'Automatically moved page while renaming the user "[[User:$1|$1]]" to "[[User:$2|$2]]"',

	'right-renameuser'      => 'Rename users',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Meno25
 * @author SPQRobin
 */
$messages['qqq'] = array(
	'userrenametool-desc' => 'Short description of the Renameuser extension, shown on [[Special:Version]]. Do not translate or change links.',
	'userrenametool-reserve' => 'Option to block the old username (after it has been renamed) from being used again.',
	'userrenametool-submit' => '{{Identical|Submit}}',
	'userrenametool-logentry' => 'Used in [[Special:Log/renameuser]].
* Parameter $1 is the original username
* Parameter $2 is the new username',
	'right-renameuser' => '{{doc-right}}',
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

/** Aragonese (Aragonés)
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

/** Old English (Anglo-Saxon)
 * @author Spacebirdy
 */
$messages['ang'] = array(
	'renameuser' => 'Ednemnan brūcend',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mido
 */
$messages['ar'] = array(
	'renameuser' => 'إعادة تسمية مستخدم',
	'userrenametool-desc' => "يضيف [[Special:Renameuser|صفحة خاصة]] لإعادة تسمية مستخدم (يحتاج إلى صلاحية ''renameuser'')",
	'userrenametool-old' => 'اسم المستخدم الحالي:',
	'userrenametool-new' => 'الاسم الجديد:',
	'userrenametool-reason' => 'السبب لإعادة التسمية:',
	'userrenametool-move' => 'انقل صفحات المستخدم ونقاشه (بالصفحات الفرعية) إلى الاسم الجديد',
	'userrenametool-reserve' => 'احفظ اسم المستخدم القديم ضد الاستخدام',
	'userrenametool-warnings' => 'التحذيرات:',
	'userrenametool-confirm' => 'نعم، أعد تسمية المستخدم',
	'userrenametool-submit' => 'تنفيذ',
	'userrenametool-errordoesnotexist' => 'لا يوجد مستخدم بالاسم "<nowiki>$1</nowiki>"',
	'userrenametool-errorexists' => 'المستخدم "<nowiki>$1</nowiki>" موجود بالفعل',
	'userrenametool-errorinvalid' => 'اسم المستخدم "<nowiki>$1</nowiki>" غير صحيح',
	'userrenametool-errortoomany' => 'المستخدم "<nowiki>$1</nowiki>" لديه $2 {{PLURAL:$2|مساهمة|مساهمة}}، إعادة تسمية مستخدم لديه أكثر من $3 {{PLURAL:$3|مساهمة|مساهمة}} يمكن أن تؤثر سلبا على أداء الموقع.',
	'userrenametool-error-request' => 'حدثت مشكلة أثناء استقبال الطلب.
من فضلك عد وحاول مرة ثانية.',
	'userrenametool-error-same-user' => 'لا يمكنك إعادة تسمية مستخدم بنفس الاسم كما كان من قبل.',
	'userrenametool-success' => 'تمت إعادة تسمية المستخدم "<nowiki>$1</nowiki>" إلى "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'الصفحة $1 موجودة بالفعل ولا يمكن إنشاء أخرى مكانها أوتوماتيكيا.',
	'userrenametool-page-moved' => 'تم نقل الصفحة $1 إلى $2.',
	'userrenametool-page-unmoved' => 'لم يتمكن من نقل الصفحة $1 إلى $2.',
	'userrenametool-logpage' => 'سجل إعادة تسمية المستخدمين',
	'userrenametool-logpagetext' => 'هذا سجل بالتغييرات في أسماء المستخدمين',
	'userrenametool-logentry' => 'أعاد تسمية $1 باسم "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 تعديل|$1 تعديل}}. السبب: $2',
	'userrenametool-move-log' => 'نقل الصفحة تلقائيا خلال إعادة تسمية المستخدم من "[[User:$1|$1]]" إلى "[[User:$2|$2]]"',
	'right-renameuser' => 'إعادة تسمية المستخدمين',
);

/** Aramaic (ܐܪܡܝܐ) */
$messages['arc'] = array(
	'userrenametool-submit' => 'ܡܨܝܘܬܐ',
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
	'userrenametool-errortoomany' => 'اليوزر "<nowiki>$1</nowiki>" عنده {{PLURAL:$2|مساهمة|مساهمة}}, تغيير اسم يوزر عنده اكتر من {{PLURAL:$3|مساهمة|مساهمة}}  ممكن يأثر على اداء الموقع تاثير سلبي.',
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
	'userrenametool-move-log' => 'الصفحة اتنقلت اوتوماتيكى لما اليوزر  "[[User:$1|$1]]" اتغير اسمه لـ "[[User:$2|$2]]"',
	'right-renameuser' => 'غير اسم اليوزرز',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'renameuser' => 'Renomar usuariu',
	'userrenametool-desc' => "Renoma un usuariu (necesita'l permisu ''renameuser'')",
	'userrenametool-old' => "Nome d'usuariu actual:",
	'userrenametool-new' => "Nome d'usuariu nuevu:",
	'userrenametool-reason' => 'Motivu del cambéu de nome:',
	'userrenametool-move' => "Treslladar les páxines d'usuariu y d'alderique (y toles subpáxines) al nome nuevu",
	'userrenametool-reserve' => "Bloquiar el nome d'usuariu antiguu pa evitar usalu nun futuru",
	'userrenametool-warnings' => 'Avisos:',
	'userrenametool-confirm' => "Sí, renomar l'usuariu",
	'userrenametool-submit' => 'Executar',
	'userrenametool-errordoesnotexist' => 'L\'usuariu "<nowiki>$1</nowiki>" nun esiste.',
	'userrenametool-errorexists' => 'L\'usuariu "<nowiki>$1</nowiki>" yá esiste.',
	'userrenametool-errorinvalid' => 'El nome d\'usuariu "<nowiki>$1</nowiki>" nun ye válidu.',
	'userrenametool-errortoomany' => 'L\'usuariu "<nowiki>$1</nowiki>" tien $2 {{PLURAL:$2|contribución|contribuciones}}; renomar a un usuariu con más de $3 {{PLURAL:$3|contribución|contribuciones}} podría afeutar al rindimientu del sitiu.',
	'userrenametool-error-request' => 'Hebo un problema al recibir el pidimientu. Por favor vuelve atrás y inténtalo otra vuelta.',
	'userrenametool-error-same-user' => 'Nun pues renomar un usuariu al mesmu nome que tenía.',
	'userrenametool-success' => 'L\'usuariu "<nowiki>$1</nowiki>" foi renomáu como "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'La páxina $1 yá esiste y nun pue ser sobreescrita automáticamente.',
	'userrenametool-page-moved' => 'La páxina $1 treslladóse a $2.',
	'userrenametool-page-unmoved' => 'La páxina $1 nun pudo treslladase a $2.',
	'userrenametool-logpage' => "Rexistru de cambeos de nome d'usuariu",
	'userrenametool-logpagetext' => "Esti ye un rexistru de los cambeos de nomes d'usuariu",
	'userrenametool-logentry' => 'renomó a $1 como "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivu: $2',
	'userrenametool-move-log' => 'Treslladóse la páxina automáticamente al renomar al usuariu "[[User:$1|$1]]" como "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomar usuarios',
);

/** Samogitian (Žemaitėška)
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
	'userrenametool-errorinvalid' => 'نام کاربری "<nowiki>$1</nowiki>"  نامعتبر انت.',
	'userrenametool-error-request' => 'مشکلی گون دریافت درخواست هستت.
لطفا برگردیت و دگه تلاش کنیت.',
	'userrenametool-error-same-user' => 'شما نه تونیت یک کاربر په هما پیشگین چیزی نامی بدل کنیت',
	'userrenametool-success' => 'کاربر "<nowiki>$1</nowiki>" نامی بدل بوتت په "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'صفحه $1 الان هست و اتوماتیکی اور آی نوسیگ نه بیت.',
	'userrenametool-page-moved' => 'صفحه $1 جاه په جاه بیت په $2.',
	'userrenametool-page-unmoved' => 'صفحه $1 نه تونیت په $2 جاه په جاه بیت.',
	'userrenametool-logpage' => 'آمار نام بدل کتن کاربر',
	'userrenametool-logpagetext' => 'شی آماری چه تغییرات نامان کاربران انت',
	'userrenametool-logentry' => 'نام بدل بوت  $1 په "$2"',
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

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'renameuser' => 'Перайменаваць рахунак удзельніка',
	'userrenametool-desc' => "Дадае [[Special:Renameuser|спэцыяльную старонку]] для перайменаваньня рахунку ўдзельніка (неабходныя правы на ''перайменаваньне ўдзельніка'')",
	'userrenametool-old' => 'Цяперашняе імя ўдзельніка:',
	'userrenametool-new' => 'Новае імя:',
	'userrenametool-reason' => 'Прычына перайменаваньня:',
	'userrenametool-move' => 'Перайменаваць старонкі ўдзельніка і размоваў (і іх падстаронкі)',
	'userrenametool-reserve' => 'Заблякаваць старое імя ўдзельніка для выкарыстаньня ў будучыні',
	'userrenametool-warnings' => 'Папярэджаньні:',
	'userrenametool-confirm' => 'Так, перайменаваць удзельніка',
	'userrenametool-submit' => 'Перайменаваць',
	'userrenametool-errordoesnotexist' => 'Рахунак «<nowiki>$1</nowiki>» не існуе.',
	'userrenametool-errorexists' => 'Рахунак «<nowiki>$1</nowiki>» ужо існуе.',
	'userrenametool-errorinvalid' => 'Няслушнае імя ўдзельніка «<nowiki>$1</nowiki>».',
	'userrenametool-errortoomany' => 'Удзельнік «<nowiki>$1</nowiki>» зрабіў $2 {{PLURAL:$2|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}. Перайменаваньне рахунку ўдзельніка, які зрабіў болей за $3 {{PLURAL:$3|рэдагаваньне|рэдагаваньні|рэдагаваньняў}} можа нэгатыўна паўплываць на працу {{GRAMMAR:родны|{{SITENAME}}}}.',
	'userrenametool-error-request' => 'Узьніклі праблемы з атрыманьнем запыту.
Калі ласка, вярніцеся назад і паспрабуйце ізноў.',
	'userrenametool-error-same-user' => 'Немагчыма перайменаваць рахунак удзельніка ў тое ж самае імя.',
	'userrenametool-success' => 'Рахунак «<nowiki>$1</nowiki>» быў перайменаваны ў «<nowiki>$2</nowiki>».',
	'userrenametool-page-exists' => 'Старонка $1 ужо існуе і ня можа быць аўтаматычна перазапісаная.',
	'userrenametool-page-moved' => 'Старонка $1 была перайменаваная ў $2.',
	'userrenametool-page-unmoved' => 'Старонка $1 ня можа быць перайменаваная ў $2.',
	'userrenametool-logpage' => 'Журнал перайменаваньняў удзельнікаў',
	'userrenametool-logpagetext' => 'Гэта журнал перайменаваньняў рахункаў удзельнікаў.',
	'userrenametool-logentry' => 'перайменаваў $1 у «$2»',
	'userrenametool-log' => '$1 {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}. Прычына: $2',
	'userrenametool-move-log' => 'Аўтаматычнае перайменаваньне старонкі ў сувязі зь перайменаваньнем рахунку ўдзельніка з «[[User:$1|$1]]» у «[[User:$2|$2]]»',
	'right-renameuser' => 'перайменаваньне ўдзельнікаў',
);

/** Bulgarian (Български)
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

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'renameuser' => 'Adenvel an implijer',
	'userrenametool-desc' => "Adenvel un implijer (ret eo kaout ''gwirioù adenvel'')",
	'userrenametool-old' => 'Anv a-vremañ an implijer :',
	'userrenametool-new' => 'Anv implijer nevez :',
	'userrenametool-reason' => 'Abeg evit adenvel :',
	'userrenametool-move' => 'Kas ar pajennoù implijer ha kaozeal (hag o ispajennoù) betek o anv nevez',
	'userrenametool-submit' => 'Adenvel',
	'userrenametool-errordoesnotexist' => 'An implijer "<nowiki>$1</nowiki>" n\'eus ket anezhañ',
	'userrenametool-errorexists' => 'Krouet eo bet an anv implijer "<nowiki>$1</nowiki>" dija',
	'userrenametool-errorinvalid' => 'Faziek eo an anv implijer "<nowiki>$1</nowiki>"',
	'userrenametool-errortoomany' => 'Deuet ez eus $2 degasadenn gant an implijer "<nowiki>$1</nowiki>"; adenvel un implijer degaset gantañ ouzhpenn $3 degasadenn a c\'hall noazout ouzh startijenn mont en-dro al lec\'hienn a-bezh',
	'userrenametool-error-request' => 'Ur gudenn zo bet gant degemer ar reked. Kit war-gil ha klaskit en-dro.',
	'userrenametool-error-same-user' => "N'haller ket adenvel un implijer gant an hevelep anv hag a-raok.",
	'userrenametool-success' => 'Deuet eo an implijer "<nowiki>$1</nowiki>" da vezañ "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => "Bez' ez eus eus ar bajenn $1 dija, n'haller ket hec'h erlec'hiañ ent emgefreek.",
	'userrenametool-page-moved' => 'Adkaset eo bet ar bajenn $1 da $2.',
	'userrenametool-page-unmoved' => "N'eus ket bet gallet adkas ar bajenn $1 da $2.",
	'userrenametool-logpage' => 'Roll an implijerien bet adanvet',
	'userrenametool-logpagetext' => 'Setu istor an implijerien bet cheñchet o anv ganto',
	'userrenametool-logentry' => 'en deus adanvet $1 e "$2"',
	'userrenametool-log' => 'Ssavet gantañ $1 degasadenn. $2',
	'userrenametool-move-log' => 'Pajenn dilec\'hiet ent emgefreek e-ser adenvel an implijer "[[User:$1|$1]]" e "[[User:$2|$2]]"',
);

/** Bosnian (Bosanski)
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

/** Catalan (Català)
 * @author Juanpabl
 * @author Paucabot
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'renameuser' => "Reanomena l'usuari",
	'userrenametool-desc' => "Reanomena un usuari (necessita drets de ''renameuser'')",
	'userrenametool-old' => "Nom d'usuari actual:",
	'userrenametool-new' => "Nou nom d'usuari:",
	'userrenametool-reason' => 'Motiu pel canvi:',
	'userrenametool-move' => "Reanomena la pàgina d'usuari, la de discussió i les subpàgines que tingui al nou nom",
	'userrenametool-reserve' => "Bloca el nom d'usuari antic d'usos futurs",
	'userrenametool-warnings' => 'Advertències:',
	'userrenametool-confirm' => "Sí, reanomena l'usuari",
	'userrenametool-submit' => 'Tramet',
	'userrenametool-errordoesnotexist' => "L'usuari «<nowiki>$1</nowiki>» no existeix",
	'userrenametool-errorexists' => "L'usuari «<nowiki>$1</nowiki>» ja existeix",
	'userrenametool-errorinvalid' => "El nom d'usuari «<nowiki>$1</nowiki>» no és vàlid",
	'userrenametool-errortoomany' => "L'usuari «<nowiki>$1</nowiki>» té $2 {{PLURAL:$2|contribució|contribucions}}. Canviar el nom a un usuari amb més de $3 {{PLURAL:$3|contribució|contribucions}} pot causar problemes.",
	'userrenametool-error-request' => "Hi ha hagut un problema en la recepció de l'ordre.
Torneu enrere i torneu-ho a intentar.",
	'userrenametool-error-same-user' => 'No podeu reanomenar un usuari a un nom que ja tenia anteriorment.',
	'userrenametool-success' => "L'usuari «<nowiki>$1</nowiki>» s'ha reanomenat com a «<nowiki>$2</nowiki>»",
	'userrenametool-page-exists' => 'La pàgina «$1» ja existeix i no pot ser sobreescrita automàticament',
	'userrenametool-page-moved' => "La pàgina «$1» s'ha reanomenat com a «$2».",
	'userrenametool-page-unmoved' => "La pàgina $1 no s'ha pogut reanomenar com a «$2».",
	'userrenametool-logpage' => "Registre del canvi de nom d'usuari",
	'userrenametool-logpagetext' => "Aquest és un registre dels canvis als noms d'usuari",
	'userrenametool-logentry' => 'ha reanomenat $1 a "$2"',
	'userrenametool-log' => '{{PLURAL:$1|Una contribució|$1 contribucions}}. Motiu: $2',
	'userrenametool-move-log' => "S'ha reanomenat automàticament la pàgina mentre es reanomenava l'usuari «[[User:$1|$1]]» com «[[User:$2|$2]]»",
	'right-renameuser' => 'Reanomena els usuaris',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'renameuser' => 'Юзер цIе хийца',
);

/** Crimean Turkish (Latin) (Qırımtatarca (Latin))
 * @author Alessandro
 */
$messages['crh-latn'] = array(
	'userrenametool-logpage' => 'Qullanıcı adı deñişikligi jurnalı',
	'userrenametool-logpagetext' => 'Aşağıda bulunğan cedvel adı deñiştirilgen qullanıcılarnı köstere',
	'userrenametool-logentry' => '$1 qullanıcısınıñ adını "$2" оlaraq deñiştirdi',
	'userrenametool-log' => '{{PLURAL:$1|1 deñişiklik|$1 deñişiklik}} yapqan. Sebep: $2',
);

/** Crimean Turkish (Cyrillic) (Qırımtatarca (Cyrillic))
 * @author Alessandro
 */
$messages['crh-cyrl'] = array(
	'userrenametool-logpage' => 'Къулланыджы ады денъишиклиги журналы',
	'userrenametool-logpagetext' => 'Ашагъыда булунгъан джедвель ады денъиштирильген къулланыджыларны косьтере',
	'userrenametool-logentry' => '$1 къулланыджысынынъ адыны "$2" оларакъ денъиштирди',
	'userrenametool-log' => '{{PLURAL:$1|1 денъишиклик|$1 денъишиклик}} япкъан. Себеп: $2',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Martin Kozák
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'renameuser' => 'Přejmenovat uživatele',
	'userrenametool-desc' => "Přejmenování uživatele (vyžadováno oprávnění ''renameuser'')",
	'userrenametool-old' => 'Stávající uživatelské jméno:',
	'userrenametool-new' => 'Nové uživatelské jméno:',
	'userrenametool-reason' => 'Důvod přejmenování:',
	'userrenametool-move' => 'Přesunout uživatelské a diskusní stránky (a jejich podstránky) na nové jméno',
	'userrenametool-reserve' => 'Zabránit nové registraci původního uživatelského jména',
	'userrenametool-warnings' => 'Upozornění:',
	'userrenametool-confirm' => 'Ano, přejmenovat uživatele',
	'userrenametool-submit' => 'Přejmenovat',
	'userrenametool-errordoesnotexist' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ neexistuje',
	'userrenametool-errorexists' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ již existuje',
	'userrenametool-errorinvalid' => 'Uživatelské jméno „<nowiki>$1</nowiki>“ nelze použít',
	'userrenametool-errortoomany' => 'Uživatel „<nowiki>$1</nowiki>“ má $2 {{PLURAL:$2|příspěvek|příspěvky|příspěvků}}, přejmenování uživatele s více než $3 {{PLURAL:$3|příspěvkem|příspěvky|příspěvky}} by příliš zatěžovalo systém.',
	'userrenametool-error-request' => 'Při přijímání požadavku došlo k chybě. Vraťte se a zkuste to znovu.',
	'userrenametool-error-same-user' => 'Nové uživatelské jméno je stejné jako dosavadní.',
	'userrenametool-success' => 'Uživatel „<nowiki>$1</nowiki>“ byl úspěšně přejmenován na „<nowiki>$2</nowiki>“',
	'userrenametool-page-exists' => 'Stránka $1 již existuje a nelze ji automaticky přepsat.',
	'userrenametool-page-moved' => 'Stránka $1 byla přesunuta na $2.',
	'userrenametool-page-unmoved' => 'Stránku $1 se nepodařilo přesunout na $2.',
	'userrenametool-logpage' => 'Kniha přejmenování uživatelů',
	'userrenametool-logpagetext' => 'Toto je záznam přejmenování uživatelů (změn uživatelského jména).',
	爀攀渀愀洀攀甀猀攀爀氀logentry' => 'přejmenovává $1 na „$2“',
	'userrenametool-log' => '{{PLURAL:$1|1 editace|$1 editace|$1 editací}}. Zdůvodnění: $2',
	'userrenametool-move-log' => 'Automatický přesun při přejmenování uživatele „[[User:$1|$1]]“ na „[[User:$2|$2]]“',
	'right-renameuser' => 'Přejmenovávání uživatelů',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author Svetko
 * @author ОйЛ
 */
$messages['cu'] = array(
	'renameuser' => 'Прѣименѹи польѕевател҄ь',
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
	'userrenametool-desc' => "Yn ychwanegu [[Special:Renameuser|tudalen arbennig]] er mwyn gallu ail-enwi cyfrif defnyddiwr (sydd angen y gallu ''renameuser'')",
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

/** German (Deutsch)
 * @author Raimond Spekking
 * @author Spacebirdy
 * @author Umherirrender
 */
$messages['de'] = array(
	'renameuser' => 'Benutzer umbenennen',
	'userrenametool-desc' => "Ergänzt eine [[Special:Renameuser|Spezialseite]] zur Umbenennung eines Benutzers (erfordert das ''renameuser''-Recht)",
	'userrenametool-old' => 'Bisheriger Benutzername:',
	'userrenametool-new' => 'Neuer Benutzername:',
	'userrenametool-reason' => 'Grund:',
	'userrenametool-move' => 'Benutzer-/Diskussionsseite (inkl. Unterseiten) auf den neuen Benutzernamen verschieben',
	'userrenametool-reserve' => 'Alten Benutzernamen für eine Neuregistrierung blockieren',
	'userrenametool-warnings' => 'Warnungen:',
	'userrenametool-confirm' => 'Ja, Benutzer umbenennen',
	'userrenametool-submit' => 'Umbenennen',
	'userrenametool-errordoesnotexist' => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert nicht.',
	'userrenametool-errorexists' => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert bereits.',
	'userrenametool-errorinvalid' => 'Der Benutzername „<nowiki>$1</nowiki>“ ist ungültig.',
	'userrenametool-errortoomany' => 'Der Benutzer „<nowiki>$1</nowiki>“ hat $2 {{PLURAL:$2|Bearbeitung|Bearbeitungen}}. Die Namensänderung eines Benutzers mit mehr als $3 {{PLURAL:$3|Bearbeitung|Bearbeitungen}} kann die Serverleistung nachteilig beeinflussen.',
	'userrenametool-error-request' => 'Es gab ein Problem beim Empfang der Anfrage. Bitte nochmal versuchen.',
	'userrenametool-error-same-user' => 'Alter und neuer Benutzername sind identisch.',
	'userrenametool-success' => 'Der Benutzer „<nowiki>$1</nowiki>“ wurde erfolgreich in „<nowiki>$2</nowiki>“ umbenannt.',
	'userrenametool-page-exists' => 'Die Seite $1 existiert bereits und kann nicht automatisch überschrieben werden.',
	'userrenametool-page-moved' => 'Die Seite $1 wurde nach $2 verschoben.',
	'userrenametool-page-unmoved' => 'Die Seite $1 konnte nicht nach $2 verschoben werden.',
	'userrenametool-logpage' => 'Benutzernamenänderungs-Logbuch',
	'userrenametool-logpagetext' => 'In diesem Logbuch werden die Änderungen von Benutzernamen protokolliert.',
	'userrenametool-logentry' => 'hat „$1“ in „$2“ umbenannt',
	'userrenametool-log' => '{{PLURAL:$1|1 Bearbeitung|$1 Bearbeitungen}}. Grund: $2',
	'userrenametool-move-log' => 'durch die Umbenennung von „[[User:$1|$1]]“ nach „[[User:$2|$2]]“ automatisch verschobene Seite',
	'right-renameuser' => 'Benutzer umbenennen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'renameuser' => 'Wužywarja pśemjeniś',
	'userrenametool-desc' => "Wužywarja pśemjeniś (pomina se pšawo ''renameuser'')",
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

/** Spanish (Español)
 * @author Alhen
 * @author Icvav
 * @author Jatrobat
 * @author Lin linao
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 */
$messages['es'] = array(
	'renameuser' => 'Renombrar usuario',
	'userrenametool-desc' => "Añade una [[Special:Renameuser|página especial]] para renombrar a un usuario (necesita el derecho ''renameuser'')",
	'userrenametool-old' => 'Nombre actual:',
	'userrenametool-new' => 'Nuevo nombre de usuario:',
	'userrenametool-reason' => 'Motivo:',
	'userrenametool-move' => 'Trasladar las páginas de usuario y de discusión (y sus subpáginas) al nuevo nombre',
	'userrenametool-reserve' => 'Bloquea el antiguo nombre de usuario para evitar usarlo en el futuro',
	'userrenametool-warnings' => 'Avisos:',
	'userrenametool-confirm' => 'Sí, renombrar el usuario',
	'userrenametool-submit' => 'Enviar',
	'userrenametool-errordoesnotexist' => 'El usuario «<nowiki>$1</nowiki>» no existe',
	'userrenametool-errorexists' => 'El usuario «<nowiki>$1</nowiki>» ya existe',
	'userrenametool-errorinvalid' => 'El nombre de usuario «<nowiki>$1</nowiki>» no es válido',
	'userrenametool-errortoomany' => 'El usuario «<nowiki>$1</nowiki>» tiene $2 {{PLURAL:$2|contribución|contribuciones}}, renombrar a un usuario con más de $3 {{PLURAL:$3|contribución|contribuciones}} podría afectar negativamente al rendimiento del sitio.',
	'userrenametool-error-request' => 'Hubo un problema al recibir la solicitud.
Por favor, vuelve atrás e inténtalo de nuevo.',
	'userrenametool-error-same-user' => 'No puedes renombrar a un usuario con el nombre que ya tenía.',
	'userrenametool-success' => 'El usuario «<nowiki>$1</nowiki>» ha sido renombrado a «<nowiki>$2</nowiki>»',
	'userrenametool-page-exists' => 'La página $1 ya existe y no puede ser reemplazada automáticamente.',
	'userrenametool-page-moved' => 'La página $1 ha sido trasladada a $2.',
	'userrenametool-page-unmoved' => 'La página $1 no pudo ser trasladada a $2.',
	'userrenametool-logpage' => 'Registro de cambios de nombre de usuarios',
	'userrenametool-logpagetext' => 'Este es un registro de cambios de nombres de usuarios',
	'userrenametool-logentry' => 'ha renombrado a $1 a "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivo: $2',
	'userrenametool-move-log' => 'Página trasladada automáticamente al renombrar al usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Renombrar usuarios',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Jaan513
 * @author WikedKentaur
 */
$messages['et'] = array(
	'renameuser' => 'Muuda kasutajanime',
	'userrenametool-old' => 'Praegune kasutajanimi:',
	'userrenametool-new' => 'Uus kasutajanimi:',
	'userrenametool-reason' => 'Muutmise põhjus:',
	'userrenametool-move' => 'Nimeta ümber kasutajaleht, aruteluleht ja nende alamlehed.',
	'userrenametool-warnings' => 'Hoiatused:',
	'userrenametool-confirm' => 'Jah, nimeta kasutaja ümber',
	'userrenametool-submit' => 'Muuda',
	'userrenametool-logpage' => 'Kasutajanime muutmise logi',
	'userrenametool-log' => '{{PLURAL:$1|1 redaktsioon|$1 redaktsiooni}}. Põhjus: $2',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Theklan
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
	'userrenametool-page-moved' => '$1 orrialde $2(e)ra mugitu da.',
	'userrenametool-page-unmoved' => 'Ezin izan da $1 orrialdea $2(e)ra mugitu.',
	'userrenametool-logpage' => 'Erabiltzaileen izen aldaketa erregistroa',
	'userrenametool-logpagetext' => 'Erabiltzaileen izen aldaketen erregistroa da hau',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'userrenametool-page-moved' => 'S´á moviu la páhina $1 a $2.',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'renameuser' => 'تغییر نام کاربری',
	'userrenametool-desc' => "نام یک کاربر را تغییر می‌دهد (نیازمند برخورداری از اختیارات ''تغییرنام'' است)",
	'userrenametool-old' => 'نام کاربری فعلی:',
	'userrenametool-new' => 'نام کاربری جدید:',
	'userrenametool-reason' => 'علت تغییر نام کاربری:',
	'userrenametool-move' => 'صفحه کاربر و صفحه بحث کاربر (و زیر صفحه‌های آن‌ها) را به نام جدید انتقال بده',
	'userrenametool-reserve' => 'نام کاربری قبلی را در مقابل استفادهٔ مجدد حفظ کن',
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

/** Finnish (Suomi)
 * @author Agony
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'renameuser' => 'Käyttäjätunnuksen vaihto',
	'userrenametool-desc' => "Mahdollistaa käyttäjän uudelleennimeämisen (vaatii ''renameuser''-oikeudet).",
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
	'userrenametool-error-request' => 'Pyynnön vastaanottamisessa oli ongelma. Ole hyvä ja yritä uudelleen.',
	'userrenametool-error-same-user' => 'Et voi nimetä käyttäjää uudelleen samaksi kuin hän jo on.',
	'userrenametool-success' => 'Käyttäjän ”<nowiki>$1</nowiki>” tunnus on nyt ”<nowiki>$2</nowiki>”.',
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

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'userrenametool-new' => 'Nýtt brúkaranavn:',
);

/** French (Français)
 * @author Cedric31
 * @author Crochet.david
 * @author Grondin
 * @author Hégésippe Cormier
 * @author IAlex
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'renameuser' => 'Renommer l’utilisateur',
	'userrenametool-desc' => "Renomme un utilisateur (nécessite les droits de ''renameuser'')",
	'userrenametool-old' => 'Nom actuel de l’utilisateur :',
	'userrenametool-new' => 'Nouveau nom de l’utilisateur :',
	'userrenametool-reason' => 'Motif du renommage :',
	'userrenametool-move' => 'Renommer toutes les pages de l’utilisateur vers le nouveau nom',
	'userrenametool-reserve' => "Réserver l'ancien nom pour un usage futur",
	'userrenametool-warnings' => 'Avertissements :',
	'userrenametool-confirm' => 'Oui, renommer l’utilisateur',
	'userrenametool-submit' => 'Soumettre',
	'userrenametool-errordoesnotexist' => 'L’utilisateur « <nowiki>$1</nowiki> » n’existe pas',
	'userrenametool-errorexists' => 'L’utilisateur « <nowiki>$1</nowiki> » existe déjà',
	'userrenametool-errorinvalid' => 'Le nom d’utilisateur « <nowiki>$1</nowiki> » n’est pas valide',
	'userrenametool-errortoomany' => 'L’utilisateur « <nowiki>$1</nowiki> » a $2 contribution{{PLURAL:$2||s}} à son actif. Renommer un utilisateur ayant plus de $3 contribution{{PLURAL:$3||s}} pourrait affecter les performances du site.',
	'userrenametool-error-request' => 'Un problème existe avec la réception de la requête. Revenez en arrière et essayez à nouveau.',
	'userrenametool-error-same-user' => 'Vous ne pouvez pas renommer un utilisateur du même nom qu’auparavant.',
	'userrenametool-success' => 'L’utilisateur « <nowiki>$1</nowiki> » a été renommé « <nowiki>$2</nowiki> »',
	'userrenametool-page-exists' => 'La page $1 existe déjà et ne peut pas être automatiquement remplacée.',
	'userrenametool-page-moved' => 'La page $1 a été déplacée vers $2.',
	'userrenametool-page-unmoved' => 'La page $1 ne peut pas être renommée en $2.',
	'userrenametool-logpage' => 'Journal des renommages d’utilisateur',
	'userrenametool-logpagetext' => "Ceci est l’historique des changements de noms d'utilisateur",
	'userrenametool-logentry' => 'a renommé « $1 » en « $2 »',
	'userrenametool-log' => '$1 {{PLURAL:$1|modification|modifications}}. Motif : $2',
	'userrenametool-move-log' => 'Page automatiquement déplacée lors du renommage de l’utilisateur « [[User:$1|$1]] » en « [[User:$2|$2]] »',
	'right-renameuser' => 'Renommer des utilisateurs',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'renameuser' => 'Renomar l’utilisator',
	'userrenametool-desc' => "Renome un utilisator (at fôta des drêts de ''renameuser'').",
	'userrenametool-old' => 'Nom d’ora de l’utilisator :',
	'userrenametool-new' => 'Novél nom de l’utilisator :',
	'userrenametool-reason' => 'Rêson du renomâjo :',
	'userrenametool-move' => 'Dèplaciér totes les pâges de l’utilisator vers lo novél nom',
	'userrenametool-submit' => 'Sometre',
	'userrenametool-errordoesnotexist' => 'L’utilisator « <nowiki>$1</nowiki> » ègziste pas.',
	'userrenametool-errorexists' => 'L’utilisator « <nowiki>$1</nowiki> » ègziste ja.',
	'userrenametool-errorinvalid' => 'Lo nom d’utilisator « <nowiki>$1</nowiki> » est envalido.',
	'userrenametool-errortoomany' => 'L’utilisator « <nowiki>$1</nowiki> » at $2 contribucions. Renomar un utilisator povent sè prèvalêr de més de $3 contribucions pôt afèctar les pèrformences du seto.',
	'userrenametool-error-request' => 'Un problèmo ègziste avouéc la rècèpcion de la requéta. Tornâd arriér et pués tornâd èprovar.',
	'userrenametool-error-same-user' => 'Vos pouede pas renomar un utilisator avouéc la méma chousa dês devant.',
	'userrenametool-success' => 'L’utilisator « <nowiki>$1</nowiki> » at étâ renomâ en « <nowiki>$2</nowiki> ».',
	'userrenametool-page-exists' => 'La pâge $1 ègziste ja et pôt pas étre ôtomaticament remplaciê.',
	'userrenametool-page-moved' => 'La pâge $1 at étâ dèplaciê vers $2.',
	'userrenametool-page-unmoved' => 'La pâge $1 pôt pas étre renomâ en $2.',
	'userrenametool-logpage' => 'Historico des renomâjos d’utilisator',
	'userrenametool-logpagetext' => 'Cen est l’historico des changements de noms d’utilisator.',
	'userrenametool-logentry' => 'at renomâ $1 en "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 èdicion|$1 èdicions}}. Rêson : $2',
	'userrenametool-move-log' => 'Pâge ôtomaticament dèplaciê pendent lo renomâjo de l’utilisator « [[User:$1|$1]] » en « [[User:$2|$2]] »',
);

/** Friulian (Furlan)
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

/** Galician (Galego)
 * @author Alma
 * @author Prevert
 * @author Toliño
 */
$messages['gl'] = array(
	'renameuser' => 'Mudar o nome de usuario',
	'userrenametool-desc' => "Renomear un usuario (precisa dereito de ''renomear usuarios'')",
	'userrenametool-old' => 'Nome de usuario actual:',
	'userrenametool-new' => 'Novo nome de usuario:',
	'userrenametool-reason' => 'Razón para mudar o nome:',
	'userrenametool-move' => 'Mover usuario e páxinas de talk (e as súas subpáxinas) a un novo nome',
	'userrenametool-reserve' => 'Reservar o nome de usuario vello para un uso posterior',
	'userrenametool-warnings' => 'Avisos:',
	'userrenametool-confirm' => 'Si, renomear este usuario',
	'userrenametool-submit' => 'Enviar',
	'userrenametool-errordoesnotexist' => 'O usuario "<nowiki>$1</nowiki>" non existe',
	'userrenametool-errorexists' => 'O usuario "<nowiki>$1</nowiki>"  xa existe',
	'userrenametool-errorinvalid' => 'O nome de usuario "<nowiki>$1</nowiki>" non é válido',
	'userrenametool-errortoomany' => 'O usuario "<nowiki>$1</nowiki>" ten {{PLURAL:$2|unha contribución|$2 contribucións}}; mudar o nome dun usuario con máis {{PLURAL:$3|dunha contribución|de $3 contribucións}} podería afectar negativamente ao rendemento do sitio.',
	'userrenametool-error-request' => 'Houbo un problema coa recepción da solitidude. Volte atrás e ténteo de novo.',
	'userrenametool-error-same-user' => 'Non pode renomear a un usuario ao mesmo nome que tiña antes.',
	'userrenametool-success' => 'O usuario "<nowiki>$1</nowiki>" mudou o nome a "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'A páxina $1 xa existe e non pode ser automaticamente sobreescrita.',
	'userrenametool-page-moved' => 'A páxina $1 foi movida a $2.',
	'userrenametool-page-unmoved' => 'A páxina $1 non pode ser movida a $2.',
	'userrenametool-logpage' => 'Rexistro de usuarios que mudaron o nome',
	'userrenametool-logpagetext' => 'Este é un rexistro dos cambios nos nomes de usuario.',
	'userrenametool-logentry' => 'mudou o nome de "$1" a "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edición|$1 edicións}}. Razón: $2',
	'userrenametool-move-log' => 'A páxina moveuse automaticamente cando se mudou o nome do usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomear usuarios',
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
	'userrenametool-error-request' => 'הייתה בעיה בקבלת הבקשה. אנא חזרו לדף הקודם ונסו שנית.',
	'userrenametool-error-same-user' => 'אינכם יכולים לשנות את שם המשתמש לשם זהה לשמו הישן.',
	'userrenametool-success' => 'שם המשתמש של "<nowiki>$1</nowiki>" שונה ל"<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'הדף $1 כבר קיים ולא ניתן לדרוס אותו אוטומטית.',
	'userrenametool-page-moved' => 'הדף $1 הועבר ל$2.',
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

/** Fiji Hindi (Latin) (Fiji Hindi (Latin))
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'renameuser' => 'Sadasya ke naam badlo',
	'userrenametool-desc' => "[[Special:Renameuser|special panna]] ke jorro ek sadasya  ke naam badle ke khatir (''renameuser'' ke hak maange hai)",
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
	'userrenametool-move-log' => 'Automatically panna ke move kar diya hai jab ki sadasya ke naam  "[[User:$1|$1]]" se badal ke "[[User:$2|$2]]" kar dewa gais hai',
	'right-renameuser' => 'Sadasya log ke naam badlo',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author SpeedyGonsales
 * @author Suradnik13
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
	'right-renameuser' => 'Preimenuj suradnike',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'renameuser' => 'Wužiwarja přemjenować',
	'userrenametool-desc' => "Wužiwarja přemjenować (požada prawo ''renameuser'')",
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
	'userrenametool-errortoomany' => 'Wužiwar „<nowiki>$1</nowiki>“ je $2 {{PLURAL:$2|přinošk|přinoškaj|přinoški|přinoškow}} dodał. Přemjenowanje wužiwarja z wjace hač $3 {{PLURAL:$3|přinoškom|přinoškomaj|přinoškami|přinoškami}} móže so njepřihódnje na wukonitosć serwera wuskutkować.',
	'userrenametool-error-request' => 'Problem je při přijimanju požadanja wustupił. Prošu dźi wróćo a spytaj hišće raz.',
	'userrenametool-error-same-user' => 'Njemóžeš wužiwarja do samsneje wěcy kaž prjedy přemjenować.',
	'userrenametool-success' => 'Wužiwar „<nowiki>$1</nowiki>“ bu wuspěšnje na „<nowiki>$2</nowiki>“ přemjenowany.',
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

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'renameuser' => 'Szerkesztő átnevezése',
	'userrenametool-desc' => "Lehetővé teszi egy felhasználó átnevezését (''renameuser'' jog szükséges)",
	'userrenametool-old' => 'Jelenlegi felhasználónév:',
	'userrenametool-new' => 'Új felhasználónév:',
	'userrenametool-reason' => 'Átnevezés oka:',
	'userrenametool-move' => 'Felhasználói- és vitalapok (és azok allapjainak) áthelyezése az új név alá',
	'userrenametool-reserve' => 'Régi név blokkolása a jövőbeli használat megakadályozására',
	'userrenametool-warnings' => 'Figyelmeztetések:',
	'userrenametool-confirm' => 'Igen, nevezd át a szerkesztőt',
	'userrenametool-submit' => 'Elküld',
	'userrenametool-errordoesnotexist' => 'Nem létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'userrenametool-errorexists' => 'Már létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'userrenametool-errorinvalid' => 'A felhasználónév („<nowiki>$1</nowiki>”) érvénytelen',
	'userrenametool-errortoomany' => '„<nowiki>$1</nowiki>” szerkesztőnek {{PLURAL:$2|egy|$2}} szerkesztése van, $3 szerkesztésnél többel rendelkező felhasználók átnevezése rossz hatással lehet az oldal működésére',
	'userrenametool-error-request' => 'Hiba történt a lekérdezés küldése közben.  Menj vissza az előző oldalra és próbáld újra.',
	'userrenametool-error-same-user' => 'Nem nevezhetsz át egy felhasználót a meglévő nevére.',
	'userrenametool-success' => '„<nowiki>$1</nowiki>” sikeresen át lett nevezve „<nowiki>$2</nowiki>” névre.',
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

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'renameuser' => 'Renominar usator',
	'userrenametool-desc' => "Adde un [[Special:Renameuser|pagina special]] pro renominar un usator (require le privilegio ''renameuser'')",
	'userrenametool-old' => 'Nomine de usator actual:',
	'userrenametool-new' => 'Nove nomine de usator:',
	'userrenametool-reason' => 'Motivo del renomination:',
	'userrenametool-move' => 'Renominar etiam le paginas de usator e de discussion (e lor subpaginas) verso le nove nomine',
	'userrenametool-reserve' => 'Blocar le ancian nomine de usator de esser usate in le futuro',
	'userrenametool-warnings' => 'Advertimentos:',
	'userrenametool-confirm' => 'Si, renomina le usator',
	'userrenametool-submit' => 'Submitter',
	'userrenametool-errordoesnotexist' => 'Le usator "<nowiki>$1</nowiki>" non existe.',
	'userrenametool-errorexists' => 'Le usator ""<nowiki>$1</nowiki>"" existe ja.',
	'userrenametool-errorinvalid' => 'Le nomine de usator "<nowiki>$1</nowiki>" es invalide.',
	'userrenametool-errortoomany' => 'Le usator "<nowiki>$1</nowiki>" ha $2 {{PLURAL:$2|contribution|contributiones}}. Le renomination de un usator con plus de $3 {{PLURAL:$3|contribution|contributiones}} poterea afficer negativemente le prestationes del sito.',
	'userrenametool-error-request' => 'Il habeva un problema con le reception del requesta.
Per favor retorna e reprova.',
	'userrenametool-error-same-user' => 'Tu non pote renominar un usator al mesme nomine.',
	'userrenametool-success' => 'Le usator "<nowiki>$1</nowiki>" ha essite renominate a "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Le pagina $1 existe ja e non pote esser automaticamente superscribite.',
	'userrenametool-page-moved' => 'Le pagina $1 ha essite renominate a $2.',
	'userrenametool-page-unmoved' => 'Le pagina $1 non poteva esser renominate a $2.',
	'userrenametool-logpage' => 'Registro de renominationes de usatores',
	'userrenametool-logpagetext' => 'Isto es un registro de cambiamentos de nomines de usator.',
	'userrenametool-logentry' => 'renominava $1 verso "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 modification|$1 modificationes}}. Motivo: $2',
	'userrenametool-move-log' => 'Le pagina ha essite automaticamente renominate con le renomination del usator "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Renominar usatores',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'renameuser' => 'Penggantian nama pengguna',
	'userrenametool-desc' => "Mengganti nama pengguna (perlu hak akses ''renameuser'')",
	'userrenametool-old' => 'Nama sekarang:',
	'userrenametool-new' => 'Nama baru:',
	'userrenametool-reason' => 'Alasan penggantian nama:',
	'userrenametool-move' => 'Pindahkan halaman pengguna dan pembicaraannya (berikut subhalamannya) ke nama baru',
	'userrenametool-reserve' => 'Cadangkan nama pengguna lama sehingga tidak dapat digunakan lagi',
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
	'userrenametool-success' => 'Pengguna "<nowiki>$1</nowiki>" telah diganti namanya menjadi "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Halaman $1 telah ada dan tidak dapat ditimpa secara otomatis.',
	'userrenametool-page-moved' => 'Halaman $1 telah dipindah ke $2.',
	'userrenametool-page-unmoved' => 'Halaman $1 tidak dapat dipindah ke $2.',
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

/** Icelandic (Íslenska)
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

/** Italian (Italiano)
 * @author .anaconda
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
	'userrenametool-move-log' => 'Spostamento automatico della pagina - utente rinominato da "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser' => 'Rinomina gli utenti',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Broad-Sky
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Marine-Blue
 * @author Suisui
 */
$messages['ja'] = array(
	'renameuser' => '利用者名の変更',
	'userrenametool-desc' => '利用者名変更のための[[Special:Renameuser|特別ページ]]を追加する（renameuser権限が必要）',
	'userrenametool-old' => '現在の利用者名:',
	'userrenametool-new' => '新しい利用者名:',
	'userrenametool-reason' => '変更理由:',
	'userrenametool-move' => '利用者ページと会話ページ（およびそれらのサブページ）を新しい名前に移動する',
	'userrenametool-reserve' => '旧利用者名の今後の使用をブロックする',
	'userrenametool-warnings' => '警告:',
	'userrenametool-confirm' => 'はい、利用者名を変更します',
	'userrenametool-submit' => '変更',
	'userrenametool-errordoesnotexist' => '利用者 “<nowiki>$1</nowiki>” は存在しません。',
	'userrenametool-errorexists' => '利用者 “<nowiki>$1</nowiki>” は既に存在しています。',
	'userrenametool-errorinvalid' => '利用者名 “<nowiki>$1</nowiki>” は無効な値です。',
	'userrenametool-errortoomany' => '利用者 "<nowiki>$1</nowiki>" には $2 件の投稿記録があります。$3 件以上の投稿記録がある利用者の名前を変更すると、サイトのパフォーマンスに悪影響を及ぼす可能性があります。',
	'userrenametool-error-request' => '要求を正常に受け付けることができませんでした。戻ってから再度お試しください。',
	'userrenametool-error-same-user' => '現在と同じ利用者名に変更することは出来ません。',
	'userrenametool-success' => '利用者 "<nowiki>$1</nowiki>" を "<nowiki>$2</nowiki>" に変更しました。',
	'userrenametool-page-exists' => '$1 が既に存在しているため、自動で上書きできませんでした。',
	'userrenametool-page-moved' => '$1 を $2 に移動しました。',
	'userrenametool-page-unmoved' => '$1 を $2 に移動できませんでした。',
	'userrenametool-logpage' => '利用者名変更記録',
	'userrenametool-logpagetext' => 'これは、利用者名の変更を記録したものです。',
	'userrenametool-logentry' => '$1を "$2" へ利用者名変更しました。',
	'userrenametool-log' => '投稿数$1回。理由: $2',
	'userrenametool-move-log' => '名前の変更と共に "[[User:$1|$1]]" を "[[User:$2|$2]]" へ移動しました。',
	'right-renameuser' => '利用者名変更',
);

/** Jutish (Jysk)
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
	'userrenametool-errortoomany' => 'Panganggo "<nowiki>$1</nowiki>" wis duwé $2 {{PLURAL:$2|suntingan|suntingan}}, yèn jeneng panganggoné diganti mawa luwih saka $3 {{PLURAL:$3|suntingan|suntingan}}  bisa awèh pangaruh ala marang kinerja situs.',
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
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
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

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
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

/** Kazakh (Latin) (Қазақша (Latin)) */
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
 * @author Shushruth
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
 */
$messages['ko'] = array(
	'renameuser' => '계정 이름 변경',
	'userrenametool-desc' => "계정 이름 변경을 위한 [[Special:Renameuser|특수 문서]]를 추가 (''renameuser'' 권한이 필요합니다)",
	'userrenametool-old' => '기존 계정 이름:',
	'userrenametool-new' => '새 이름:',
	'userrenametool-reason' => '바꾸는 이유:',
	'userrenametool-move' => '사용자 문서와 토론 문서, 하위 문서를 새 사용자 이름으로 이동하기',
	'userrenametool-reserve' => '나중에 이전의 이름이 사용되지 않도록 차단하기',
	'userrenametool-warnings' => '경고:',
	'userrenametool-confirm' => '예, 이름을 변경합니다.',
	'userrenametool-submit' => '변경',
	'userrenametool-errordoesnotexist' => '‘<nowiki>$1</nowiki>’ 사용자가 존재하지 않습니다.',
	'userrenametool-errorexists' => '‘<nowiki>$1</nowiki>’ 사용자가 이미 존재합니다.',
	'userrenametool-errorinvalid' => '‘<nowiki>$1</nowiki>’ 사용자 이름이 잘못되었습니다.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" 사용자는 $2번의 기여를 했습니다. $3번을 넘는 기여를 한 사용자의 이름을 변경하는 것은 성능 저하를 일으킬 수 있습니다.',
	'userrenametool-error-request' => '요청을 정상적으로 전송하지 못했습니다.
뒤로 가서 다시 시도해주세요.',
	'userrenametool-error-same-user' => '이전의 이름과 같은 이름으로는 바꿀 수 없습니다.',
	'userrenametool-success' => '‘<nowiki>$1</nowiki>’ 사용자가 ‘<nowiki>$2</nowiki>’(으)로 변경되었습니다.',
	'userrenametool-page-exists' => '$1 문서가 이미 존재하여 자동으로 이동하지 못했습니다.',
	'userrenametool-page-moved' => '$1 문서를 $2(으)로 이동했습니다.',
	'userrenametool-page-unmoved' => '$1 문서를 $2(으)로 이동하지 못했습니다.',
	'userrenametool-logpage' => '이름 변경 기록',
	'userrenametool-logpagetext' => '계정 이름 변경 기록입니다.',
	'userrenametool-logentry' => '$1에서 "$2"(으)로 이름을 바꾸었습니다.',
	'userrenametool-log' => '$1개의 기여. 이유: $2',
	'userrenametool-move-log' => '‘[[User:$1|$1]]’ 사용자를 ‘[[User:$2|$2]]’(으)로 바꾸면서 문서를 자동으로 이동함',
	'right-renameuser' => '계정 이름 변경',
);

/** Ripoarisch (Ripoarisch)
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

/** Kurdish (Latin) (Kurdî / كوردی (Latin)) */
$messages['ku-latn'] = array(
	'renameuser' => 'Navî bikarhênerê biguherîne',
	'userrenametool-old' => 'Navî niha:',
	'userrenametool-new' => 'Navî nuh:',
	'userrenametool-submit' => 'Bike',
	'userrenametool-success' => 'Navî bikarhênerê "<nowiki>$1</nowiki>" bû "<nowiki>$2</nowiki>"',
	'userrenametool-log' => 'yê $1 beşdarîyên xwe hebû. $2',
);

/** Latin (Latina)
 * @author MF-Warburg
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
	'renameuser' => 'Benotzernumm änneren',
	'userrenametool-desc' => "Benotzernumm änneren (Dir braucht dofir  ''renameuser''-Rechter)",
	'userrenametool-old' => 'Aktuelle Benotzernumm:',
	'userrenametool-new' => 'Neie Benotzernumm:',
	'userrenametool-reason' => "Grond fir d'Ëmbenennung:",
	'userrenametool-move' => 'Benotzer- an Diskussiounssäiten (an déi jeweileg Ënnersäiten) op den neie Benotzernumm réckelen',
	'userrenametool-reserve' => 'Den ale Benotzernumm fir de weitere Gebrauch spären',
	'userrenametool-warnings' => 'Warnungen:',
	'userrenametool-confirm' => 'Jo, Benotzer ëmbenennen',
	'userrenametool-submit' => 'Ëmbenennen',
	'userrenametool-errordoesnotexist' => 'De Benotzer "<nowiki>$1</nowiki>" gëtt et net.',
	'userrenametool-errorexists' => 'De Benotzer "<nowiki>$1</nowiki>" gët et schonn.',
	'userrenametool-errorinvalid' => 'De Benotzernumm "<nowiki>$1</nowiki>" kann net benotzt ginn.',
	'userrenametool-errortoomany' => 'De Benotzer "<nowiki>$1</nowiki>" huet $2 {{PLURAL:$2|Ännerung|Ännerunge}} gemaach. D\'Ännerung vum Benotzernumm vun engem Benotzer mat méi wéi $3 {{PLURAL:$3|Ännerung|Ännerunge}} kann d\'Vitesse vum Site staark beaflossen.',
	'userrenametool-error-request' => 'Et gouf e Problem mat ärer Ufro.
Gitt w.e.g. zréck a versicht et nach eng Kéier.',
	'userrenametool-error-same-user' => 'Dir kënnt kee Benotzernumm änneren, an him dee selweschte Numm erëmginn.',
	'userrenametool-success' => 'De Benotzer "<nowiki>$1</nowiki>" gouf "<nowiki>$2</nowiki>" ëmbenannt.',
	'userrenametool-page-exists' => "D'Säit $1 gëtt et schonns a kann net automatesch iwwerschriwwe ginn.",
	'userrenametool-page-moved' => "D'Säit $1 gouf op $2 geréckelt.",
	'userrenametool-page-unmoved' => "D'Säit $1 konnt net op $2 geréckelt ginn.",
	'userrenametool-logpage' => 'Logbuch vun den Ännerunge vum Benotzernumm',
	'userrenametool-logpagetext' => 'An dësem Logbuch ginn Ännerunge vu Benotzernimm festgehal.',
	'userrenametool-logentry' => 'huet de Benotzer $1 op "$2" ëmbenannt',
	'userrenametool-log' => '{{PLURAL:$1|1 Ännerung|$1 Ännerungen}}. Grond: $2',
	'userrenametool-move-log' => 'Duerch d\'Réckele vum Benotzer  "[[User:$1|$1]]" op "[[User:$2|$2]]" goufen déi folgend Säiten automatesch matgeréckelt:',
	'right-renameuser' => 'Benotzer ëmbenennen',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Tibor
 */
$messages['li'] = array(
	'renameuser' => 'Hernöm gebroeker',
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

/** Lithuanian (Lietuvių)
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

/** Latvian (Latviešu)
 * @author Xil
 */
$messages['lv'] = array(
	'userrenametool-warnings' => 'Brīdinājumi:',
	'userrenametool-confirm' => 'Jā, pārdēvēt lietotāju',
	'userrenametool-errorexists' => 'Lietotājs "<nowiki>$1</nowiki>" jau ir.',
	'userrenametool-success' => 'Lietotājs "<nowiki>$1</nowiki>" pārdēvēts par "<nowiki>$2</nowiki>".',
	'userrenametool-logpage' => 'Lietotāju pārdēvēšanas reģistrs',
	'userrenametool-logpagetext' => 'Lietotājvārdu maiņas reģistrs',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'userrenametool-confirm' => 'Eny, soloy anarana ilay mpikambana',
);

/** Macedonian (Македонски)
 * @author Brest
 * @author Misos
 */
$messages['mk'] = array(
	'renameuser' => 'Преименувај корисник',
	'userrenametool-old' => 'Сегашно корисничко име:',
	'userrenametool-new' => 'Ново корисничко име:',
	'userrenametool-reason' => 'Образложение за преименување:',
	'userrenametool-move' => 'Премести корисничка страница и страници за разговор (и нивните подстраници) под новото име',
	'userrenametool-reserve' => 'Блокирање на старото корисничко име, да не може да се користи во иднина',
	'userrenametool-warnings' => 'Предупредувања:',
	'userrenametool-confirm' => 'Да, преименувај го корисникот',
	'userrenametool-submit' => 'Внеси',
	'userrenametool-errordoesnotexist' => 'Корисникот "<nowiki>$1</nowiki>" не постои',
	'userrenametool-errorexists' => 'Корисникот "<nowiki>$1</nowiki>" веќе постои',
	'userrenametool-errorinvalid' => 'Корисничкото име "<nowiki>$1</nowiki>" не е валидно',
	'userrenametool-errortoomany' => 'Корисникот "<nowiki>$1</nowiki>" има направено $2 {{PLURAL:$2|придонес|придонеси}},  преименување на корисник со повеќе од $3 {{PLURAL:$3|придонес|придонеси}} може негативно да влијае на перформансите на сајтот.',
	'userrenametool-success' => 'Корисникот "<nowiki>$1</nowiki>" е преименуван во "<nowiki>$2</nowiki>"',
	'userrenametool-logpage' => 'Дневник на преименувања на корисници',
	'userrenametool-logpagetext' => 'Ово е дневник на преименувања на корисници',
	'userrenametool-logentry' => 'преименуван $1 во "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 уредување|$1 уредувања}}. Образложение: $2',
	'userrenametool-move-log' => 'Автоматски преместена страница при преименување на корисникот "[[User:$1|$1]]" во "[[User:$2|$2]]"',
	'right-renameuser' => 'Преименување корисници',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'renameuser' => 'ഉപയോക്താവിനെ പുനര്‍നാമകരണം ചെയ്യുക',
	'userrenametool-desc' => "ഉപയോക്താവിനെ പുനര്‍നാമകരണം ചെയ്യുക (''പുനര്‍നാമകരണ'' അവകാശം വേണം)",
	'userrenametool-old' => 'ഇപ്പോഴത്തെ ഉപയോക്തൃനാമം:',
	'userrenametool-new' => 'പുതിയ ഉപയോക്തൃനാമം:',
	'userrenametool-reason' => 'ഉപയോക്തൃനാമം മാറ്റാനുള്ള കാരണം:',
	'userrenametool-move' => 'നിലവിലുള്ള ഉപയോക്തൃതാളും, ഉപയോക്താവിന്റെ സം‌വാദം താളും (സബ് പേജുകള്‍ അടക്കം) പുതിയ നാമത്തിലേക്കു മാറ്റുക.',
	'userrenametool-submit' => 'സമര്‍പ്പിക്കുക',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>"  എന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവ് നിലവിലുണ്ട്.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്തൃനാമം അസാധുവാണ്‌.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനു ഈ വിക്കിയില്‍ $2 തിരുത്തലുകളുണ്ട്. $3 ക്കു മുകളില്‍ തിരുത്തലുകളുള്ള ഉപയോക്തൃനാമങ്ങളെ പുനര്‍നാമകരണം ചെയ്യുന്നതു ഈ സൈറ്റിന്റെ പ്രവര്‍ത്തനത്തെ ബാധിക്കും.',
	'userrenametool-error-request' => 'അപേക്ഷ സ്വീകരിക്കുമ്പോള്‍ പിഴവ് സം‌ഭവിച്ചു. ദയവായി തിരിച്ചു പോയി വീണ്ടും പരിശ്രമിക്കുക.',
	'userrenametool-error-same-user' => 'നിലവിലുള്ള ഒരു ഉപയോക്തൃനാമത്തിലേക്കു വേറൊരു ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തുവാന്‍ സാധിക്കില്ല.',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനെ "<nowiki>$2</nowiki>" എന്ന നാമത്തിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'userrenametool-page-exists' => '$1 എന്ന താള്‍ നിലവിലുള്ളതിനാല്‍ അതിനെ യാന്ത്രികമായി മാറ്റാന്‍ കഴിയില്ല.',
	'userrenametool-page-moved' => '$1 എന്ന താള്‍ $2വിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'userrenametool-page-unmoved' => '$1 എന്ന താള്‍ $2 വിലേക്കു മാറ്റാന്‍ സാദ്ധ്യമല്ല.',
	'userrenametool-logpage' => 'ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തിയതിന്റെ പ്രവര്‍ത്തനരേഖ',
	'userrenametool-logpagetext' => 'ഈ പ്രവര്‍ത്തനരേഖ ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തിയതിന്റേതാണ്‌.',
	'userrenametool-logentry' => '$1 എന്ന താള്‍ "$2" എന്ന താളിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'userrenametool-log' => '{{PLURAL:$1|ഒരു തിരുത്തല്‍|$1 തിരുത്തലുകള്‍}}. കാരണം: $2',
	'userrenametool-move-log' => '"[[User:$1|$1]]" എന്ന ഉപയോക്താവിനെ "[[User:$2|$2]]" എന്നു പുനര്‍നാമകരണം ചെയ്തപ്പോള്‍ താള്‍ യാന്ത്രികമായി മാറ്റി.',
	'right-renameuser' => 'ഉപയോക്താക്കളെ പുനഃര്‍നാമകരണം നടത്തുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'renameuser' => 'सदस्यनाम बदला',
	'userrenametool-desc' => "सदस्यनाम बदला (यासाठी तुम्हाला ''सदस्यनाम बदलण्याचे अधिकार'' असणे आवश्यक आहे)",
	'userrenametool-old' => 'सध्याचे सदस्यनाम:',
	'userrenametool-new' => 'नवीन सदस्यनाम:',
	'userrenametool-reason' => 'नाम बदलण्याचे कारण:',
	'userrenametool-move' => 'सदस्य तसेच सदस्य चर्चापान (तसेच त्यांची उपपाने) नवीन सदस्यनामाकडे स्थानांतरीत करा',
	'userrenametool-submit' => 'पाठवा',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अस्तित्वात नाही.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अगोदरच अस्तित्वात आहे',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" हे नाव चुकीचे आहे.',
	'userrenametool-errortoomany' => '"<nowiki>$1</nowiki>" या सदस्याने $2 संपादने केलेली आहेत, $3 पेक्षा जास्त संपादने केलेल्या सदस्यांचे नाव बदलल्यास संकेतस्थळावर प्रश्न निर्माण होऊ शकतात.',
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
 * @author Aviator
 */
$messages['ms'] = array(
	'renameuser' => 'Tukar nama pengguna',
	'userrenametool-desc' => "Menukar nama pengguna (memerlukan hak ''renameuser'')",
	'userrenametool-old' => 'Nama semasa:',
	'userrenametool-new' => 'Nama baru:',
	'userrenametool-reason' => 'Sebab tukar:',
	'userrenametool-move' => 'Pindahkan laman pengguna dan laman perbincangannya (berserta semua sublaman yang ada) ke nama baru',
	'userrenametool-reserve' => 'Pelihara nama pengguna lama supaya tidak digunakan lagi',
	'userrenametool-warnings' => 'Amaran:',
	'userrenametool-confirm' => 'Ya, tukar nama pengguna ini',
	'userrenametool-submit' => 'Serah',
	'userrenametool-errordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak wujud.',
	'userrenametool-errorexists' => 'Pengguna "<nowiki>$1</nowiki>" telah pun wujud.',
	'userrenametool-errorinvalid' => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah.',
	'userrenametool-errortoomany' => 'Pengguna "<nowiki>$1</nowiki>" mempunyai $2 sumbangan. Penukaran nama pengguna yang mempunyai lebih daripada $3 sumbangan boleh menjejaskan prestasi tapak web ini.',
	'userrenametool-error-request' => 'Berlaku masalah ketika menerima permintaan anda.
Sila undur dan cuba lagi.',
	'userrenametool-error-same-user' => 'Anda tidak boleh menukar nama pengguna kepada nama yang sama.',
	'userrenametool-success' => 'Nama "<nowiki>$1</nowiki>" telah ditukar menjadi "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Laman $1 telah pun wujud dan tidak boleh ditulis ganti secara automatik.',
	'userrenametool-page-moved' => 'Laman $1 telah dipindahkan ke $2.',
	'userrenametool-page-unmoved' => 'Laman $1 tidak dapat dipindahkan ke $2.',
	'userrenametool-logpage' => 'Log penukaran nama pengguna',
	'userrenametool-logpagetext' => 'Ini ialah log penukaran nama pengguna.',
	'userrenametool-logentry' => 'telah menukar nama $1 menjadi "$2"',
	'userrenametool-log' => '$1 suntingan. Sebab: $2',
	'userrenametool-move-log' => 'Memindahkan laman secara automatik ketika menukar nama "[[User:$1|$1]]" menjadi "[[User:$2|$2]]"',
	'right-renameuser' => 'Menukar nama pengguna',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'userrenametool-confirm' => "Iva, erġa' semmi l-utent",
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'userrenametool-submit' => 'Tiquihuāz',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'renameuser' => 'Kái iōng-chiá ê miâ',
	'userrenametool-page-moved' => '$1 í-keng sóa khì tī $2.',
	'userrenametool-logpagetext' => 'Chit-ê log lia̍t-chhut kái-piàn iōng-chiá miâ-jī ê tōng-chok.',
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

/** Nepali (नेपाली) */
$messages['ne'] = array(
	'userrenametool-old' => 'अहिलेको प्रयोगकर्ता नाम:',
	'userrenametool-new' => 'नयाँ प्रयोगकर्ता नाम:',
);

/** Dutch (Nederlands)
 * @author Effeietsanders
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'renameuser' => 'Gebruiker hernoemen',
	'userrenametool-desc' => "Voegt een [[Special:Renameuser|speciale pagina]] toe om een gebruiker te hernoemen (u hebt hiervoor het recht ''renameuser'' nodig)",
	'userrenametool-old' => 'Huidige gebruikersnaam:',
	'userrenametool-new' => 'Nieuwe gebruikersnaam:',
	'userrenametool-reason' => 'Reden voor hernoemen:',
	'userrenametool-move' => "De gebruikerspagina en overlegpagina (en eventuele subpagina's) hernoemen naar de nieuwe gebruikersnaam",
	'userrenametool-reserve' => 'Voorkomen dat de oude gebruiker opnieuw wordt geregistreerd',
	'userrenametool-warnings' => 'Waarschuwingen:',
	'userrenametool-confirm' => 'Ja, hernoem de gebruiker',
	'userrenametool-submit' => 'Hernoemen',
	'userrenametool-errordoesnotexist' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat niet.',
	'userrenametool-errorexists' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat al.',
	'userrenametool-errorinvalid' => 'De gebruikersnaam "<nowiki>$1</nowiki>" is ongeldig.',
	'userrenametool-errortoomany' => 'De gebruiker "<nowiki>$1</nowiki>" heeft $2 {{PLURAL:$2|bewerking|bewerkingen}} gedaan; het hernoemen van een gebruiker met meer dan $3 {{PLURAL:$2|bewerking|bewerkingen}} kan de prestaties van de site nadelig beïnvloeden.',
	'userrenametool-error-request' => 'Er was een probleem bij het ontvangen van de aanvraag.  Gelieve terug te gaan en opnieuwe te proberen.',
	'userrenametool-error-same-user' => 'U kunt geen gebruiker hernoemen naar dezelfde naam.',
	'userrenametool-success' => 'De gebruiker "<nowiki>$1</nowiki>" is hernoemd naar "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'De pagina $1 bestaat al en kan niet automatisch overschreven worden.',
	'userrenametool-page-moved' => 'De pagina $1 is hernoemd naar $2.',
	'userrenametool-page-unmoved' => 'De pagina $1 kon niet hernoemd worden naar $2.',
	'userrenametool-logpage' => 'Logboek gebruikersnaamwijzigingen',
	'userrenametool-logpagetext' => 'Hieronder staan gebruikersnamen die gewijzigd zijn',
	'userrenametool-logentry' => 'heeft $1 hernoemd naar "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 bewerking|$1 bewerkingen}}. Reden: $2',
	'userrenametool-move-log' => 'Automatisch hernoemd bij het wijzigen van gebruiker "[[User:$1|$1]]" naar "[[User:$2|$2]]"',
	'right-renameuser' => 'Gebruikers hernoemen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'renameuser' => 'Døyp om brukar',
	'userrenametool-desc' => "Legg til ei [[Special:Renameuser|spesialsida]] for å døypa om ein brukar (krev ''renameuser''-rettar)",
	'userrenametool-old' => 'Noverande brukarnamn:',
	'userrenametool-new' => 'Nytt brukarnamn:',
	'userrenametool-reason' => 'Årsak for omdøyping:',
	'userrenametool-move' => 'Flytt brukar- og brukardiskusjonssider (og deira undersider) til nytt namn.',
	'userrenametool-reserve' => 'Blokker det gamle brukarnamnet for framtidig bruk',
	'userrenametool-warnings' => 'Åtvaringar:',
	'userrenametool-confirm' => 'Ja, endra namn på brukaren',
	'userrenametool-submit' => 'Utfør',
	'userrenametool-errordoesnotexist' => 'Brukaren «<nowiki>$1</nowiki>» finst ikkje.',
	'userrenametool-errorexists' => 'Brukaren «<nowiki>$1</nowiki>» finst allereie.',
	'userrenametool-errorinvalid' => 'Brukarnamnet «<nowiki>$1</nowiki>» er ikkje gyldig.',
	'userrenametool-errortoomany' => 'Brukaren «<nowiki>$1</nowiki>»  har {{PLURAL:$2|eitt bidrag|$2 bidrag}}. Å døypa om ein brukar med meir enn {{PLURAL:$3|eitt bidrag|$3 bidrag}} vil kunna påverka sida si yting negativt.',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'renameuser' => 'Døp om bruker',
	'userrenametool-desc' => "Døp om en bruker (krever ''renameuser''-rettigheter)",
	'userrenametool-old' => 'Nåværende navn:',
	'userrenametool-new' => 'Nytt brukernavn:',
	'userrenametool-reason' => 'Grunn for omdøping:',
	'userrenametool-move' => 'Flytt bruker- og brukerdiskusjonssider (og deres undersider) til nytt navn',
	'userrenametool-reserve' => 'Reserver det gamle brukernavnet mot framtidig bruk',
	'userrenametool-warnings' => 'Advarsler:',
	'userrenametool-confirm' => 'Ja, endre navn på brukeren',
	'userrenametool-submit' => 'Døp om',
	'userrenametool-errordoesnotexist' => 'Brukeren «<nowiki>$1</nowiki>» finnes ikke',
	'userrenametool-errorexists' => 'Brukeren «<nowiki>$1</nowiki>» finnes allerede',
	'userrenametool-errorinvalid' => 'Brukernavnet «<nowiki>$1</nowiki>» er ugyldig',
	'userrenametool-errortoomany' => 'Brukeren «<nowiki>$1</nowiki>» har $2&nbsp;{{PLURAL:$2|redigering|redigeringer}}. Å døpe om brukere med mer enn $3&nbsp;{{PLURAL:$3|redigering|redigeringer}} vil kunne påvirke sidens ytelse.',
	'userrenametool-error-request' => 'Det var et problem med å motte forespørselen. Gå tilbake og prøv igjen.',
	'userrenametool-error-same-user' => 'Du kan ikke gi en bruker samme navn som han/hun allerede har.',
	'userrenametool-success' => 'Brukeren «<nowiki>$1</nowiki>» har blitt omdøpt til «<nowiki>$2</nowiki>»',
	'userrenametool-page-exists' => 'Siden $1 finnes allerede, og kunne ikke erstattes automatisk.',
	'userrenametool-page-moved' => 'Siden $1 har blitt flyttet til $2.',
	'userrenametool-page-unmoved' => 'Siden $1 kunne ikke flyttes til $2.',
	'userrenametool-logpage' => 'Omdøpingslogg',
	'userrenametool-logpagetext' => 'Dette er en logg over endringer i brukernavn.',
	'userrenametool-logentry' => 'endret navn på $1 til «$2»',
	'userrenametool-log' => '{{PLURAL:$1|Én redigering|$1 redigeringer}}. Grunn: $2',
	'userrenametool-move-log' => 'Flyttet side automatisk under omdøping av brukeren «[[User:$1|$1]]» til «[[User:$2|$2]]»',
	'right-renameuser' => 'Omdøpe brukere',
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

/** Occitan (Occitan)
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

/** Ossetic (Иронау)
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

/** Pfälzisch (Pfälzisch)
 * @author SPS
 */
$messages['pfl'] = array(
	'userrenametool-submit' => 'Benutzer umbenenne',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 * @author WarX
 * @author Wpedzich
 */
$messages['pl'] = array(
	'renameuser' => 'Zmiana nazwy użytkownika',
	'userrenametool-desc' => "Zmiana nazwy użytkownika (wymaga posiadania uprawnień ''renameuser'')",
	'userrenametool-old' => 'Obecna nazwa użytkownika:',
	'userrenametool-new' => 'Nowa nazwa użytkownika:',
	'userrenametool-reason' => 'Przyczyna zmiany nazwy:',
	'userrenametool-move' => 'Przeniesienie strony osobistej i strony dyskusji użytkownika (oraz ich podstron) pod nową nazwę użytkownika',
	'userrenametool-reserve' => 'Zablokuj starą nazwę użytkownika przed możliwością użycia jej',
	'userrenametool-warnings' => 'Ostrzeżenia:',
	'userrenametool-confirm' => 'Zmień nazwę użytkownika',
	'userrenametool-submit' => 'Zmień',
	'userrenametool-errordoesnotexist' => 'Użytkownik „<nowiki>$1</nowiki>” nie istnieje',
	'userrenametool-errorexists' => 'Użytkownik „<nowiki>$1</nowiki>” już istnieje',
	'userrenametool-errorinvalid' => 'Niepoprawna nazwa użytkownika „<nowiki>$1</nowiki>”',
	'userrenametool-errortoomany' => 'Użytkownik „<nowiki>$1</nowiki>” ma {{PLURAL:$2|1 edycję|$2 edycje|$2 edycji}}. Zmiana nazwy użytkownika mającego powyżej $3 {{PLURAL:$3|edycji|edycji}} może wpłynąć na wydajność serwisu.',
	'userrenametool-error-request' => 'Wystąpił problem z odbiorem żądania.
Cofnij się i spróbuj jeszcze raz.',
	'userrenametool-error-same-user' => 'Nie możesz zmienić nazwy użytkownika na taką samą jaka była wcześniej.',
	'userrenametool-success' => 'Nazwa użytkownika „<nowiki>$1</nowiki>” została zmieniona na „<nowiki>$2</nowiki>”',
	'userrenametool-page-exists' => 'Strona „$1” już istnieje i nie może być automatycznie nadpisana.',
	'userrenametool-page-moved' => 'Strona „$1” została przeniesiona pod nazwę „$2”.',
	'userrenametool-page-unmoved' => 'Strona „$1” nie mogła zostać przeniesiona pod nazwę „$2”.',
	'userrenametool-logpage' => 'Zmiany nazw użytkowników',
	'userrenametool-logpagetext' => 'To jest rejestr zmian nazw użytkowników',
	'userrenametool-logentry' => 'zmienił nazwę użytkownika $1 na „$2”',
	'userrenametool-log' => '$1 {{PLURAL:$1|edycja|edycje|edycji}}. Powód: $2',
	'userrenametool-move-log' => 'Automatyczne przeniesienie stron użytkownika po zmianie nazwy konta z „[[User:$1|$1]]” na „[[User:$2|$2]]”',
	'right-renameuser' => 'Zmiana nazw kont użytkowników',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'renameuser' => "Arbatié n'utent",
	'userrenametool-old' => 'Stranòm corent:',
	'userrenametool-new' => 'Stranòm neuv:',
	'userrenametool-reason' => "Rason ch'as cambia stranòm:",
	'userrenametool-move' => 'Tramuda ëdcò la pàgina utent e cola dle ciaciarade (con tute soe sotapàgine) a lë stranòm neuv',
	'userrenametool-submit' => 'Falo',
	'userrenametool-errordoesnotexist' => 'A-i é pa gnun utent ch\'as ës-ciama "<nowiki>$1</nowiki>"',
	'userrenametool-errorexists' => 'N\'utent ch\'as ës-ciama "<nowiki>$1</nowiki>" a-i é già',
	'userrenametool-errorinvalid' => 'Lë stranòm "<nowiki>$1</nowiki>" a l\'é nen bon',
	'userrenametool-errortoomany' => "L'utent \"<nowiki>\$1</nowiki>\" a l'ha fait \$2 modìfiche, ch'a ten-a present che arbatié n'utent ch'a l'abia pì che \$3 modìfiche a podrìa feje un brut efet a le prestassion dël sit.",
	'userrenametool-success' => 'L\'utent "<nowiki>$1</nowiki>" a l\'é stait arbatià an "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => "La pàgina $1 a-i é già e as peul nen passe-ie dzora n'aotomàtich.",
	'userrenametool-page-moved' => "La pàgina $1 a l'ha fait San Martin a $2.",
	'userrenametool-page-unmoved' => "La pàgina $1 a l'é pa podusse tramudé a $2.",
	'userrenametool-logpage' => "Registr dj'arbatiagi",
	'userrenametool-logpagetext' => "Sossì a l'é un registr dle modìfiche djë stranòm dj'utent",
	'userrenametool-logentry' => 'a l\'ha arbatià $1 coma "$2"',
	'userrenametool-log' => "ch'a l'avìa $1 modìfiche. $2",
	'userrenametool-move-log' => 'Pàgina utent tramudà n\'aotomàtich damëntrè ch\'as arbatiava "[[User:$1|$1]]" an "[[User:$2|$2]]"',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'userrenametool-old' => 'اوسنی کارن-نوم:',
	'userrenametool-new' => 'نوی کارن-نوم:',
	'userrenametool-warnings' => 'ګواښنې:',
	'userrenametool-errordoesnotexist' => 'د "<nowiki>$1</nowiki>" په نامه کارونکی نه شته.',
	'userrenametool-errorexists' => 'د "<nowiki>$1</nowiki>" په نامه يو کارونکی له پخوا نه شته.',
	'userrenametool-error-request' => 'د غوښتنې په ترلاسه کولو کې يوه ستونزه راپېښه شوه.
مهرباني وکړی بېرته پرشا ولاړ شی او يو ځل بيا پرې کوښښ وکړی.',
	'userrenametool-logpage' => 'د کارن-نوم يادښت',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages['pt'] = array(
	'renameuser' => 'Renomear utilizador',
	'userrenametool-desc' => "Adiciona uma [[Special:Renameuser|página especial]] para renomear um utilizador (requer privilégio ''renameuser'')",
	'userrenametool-old' => 'Nome de utilizador actual:',
	'userrenametool-new' => 'Novo nome de utilizador:',
	'userrenametool-reason' => 'Motivo de renomear:',
	'userrenametool-move' => 'Mover as páginas de utilizador, páginas de discussão de utilizador e sub-páginas para o novo nome',
	'userrenametool-reserve' => 'Impedir novos usos do antigo nome de utilizador',
	'userrenametool-warnings' => 'Alertas:',
	'userrenametool-confirm' => 'Sim, renomeie o utilizador',
	'userrenametool-submit' => 'Enviar',
	'userrenametool-errordoesnotexist' => 'Não existe um utilizador "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'Já existe um utilizador "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalid' => 'O nome de utilizador "<nowiki>$1</nowiki>" é inválido.',
	'userrenametool-errortoomany' => 'O utilizador "<nowiki>$1</nowiki>" possui $2 {{PLURAL:$2|contribuição|contribuições}}. Renomear um utilizador com mais de $3 {{PLURAL:$3|contribuição|contribuições}} pode afectar o desempenho do site.',
	'userrenametool-error-request' => 'Houve um problema ao receber este pedido.
Retorne e tente de novo.',
	'userrenametool-error-same-user' => 'Não é possível renomear um utilizador para o nome anterior.',
	'userrenametool-success' => 'O utilizador "<nowiki>$1</nowiki>" foi renomeado para "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Já existe a página $1. Não é possível sobrescrever automaticamente.',
	'userrenametool-page-moved' => 'A página $1 foi movida com sucesso para $2.',
	'userrenametool-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'userrenametool-logpage' => 'Registo de renomeação de utilizadores',
	'userrenametool-logpagetext' => 'Este é um registo de alterações efectuadas a nomes de utilizadores.',
	'userrenametool-logentry' => 'renomeou $1 para "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'userrenametool-move-log' => 'Páginas foram movidas automaticamente ao renomear o utilizador "[[User:$1|$1]]" para "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomear utilizadores',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 */
$messages['pt-br'] = array(
	'renameuser' => 'Renomear usuário',
	'userrenametool-desc' => "Adiciona uma [[Special:Renameuser|página especial]] para renomear um usuário (requer privilégio ''renameuser'')",
	'userrenametool-old' => 'Nome de usuário atual:',
	'userrenametool-new' => 'Novo nome de usuário:',
	'userrenametool-reason' => 'Motivo de renomear:',
	'userrenametool-move' => 'Mover as páginas de usuário, páginas de discussão de usuário e sub-páginas para o novo nome',
	'userrenametool-reserve' => 'Impedir novos usos do antigo nome de usuário',
	'userrenametool-warnings' => 'Alertas:',
	'userrenametool-confirm' => 'Sim, renomeie o usuário',
	'userrenametool-submit' => 'Enviar',
	'userrenametool-errordoesnotexist' => 'Não existe um usuário "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'Já existe um usuário "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalid' => 'O nome de usuário "<nowiki>$1</nowiki>" é inválido.',
	'userrenametool-errortoomany' => 'O usuário "<nowiki>$1</nowiki>" possui $2 {{PLURAL:$2|contribuição|contribuições}}. Renomear um usuário com mais de $3 {{PLURAL:$3|contribuição|contribuições}} pode afetar o desempenho do site.',
	'userrenametool-error-request' => 'Houve um problema ao receber este pedido.
Retorne e tente novamente.',
	'userrenametool-error-same-user' => 'Não é possível renomear um usuário para o nome anterior.',
	'userrenametool-success' => 'O usuário "<nowiki>$1</nowiki>" foi renomeado para "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Já existe a página $1. Não é possível sobrescrever automaticamente.',
	'userrenametool-page-moved' => 'A página $1 foi movida com sucesso para $2.',
	'userrenametool-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'userrenametool-logpage' => 'Registro de renomeação de usuários',
	'userrenametool-logpagetext' => 'Este é um registro de alterações efetuadas em nomes de usuários.',
	'userrenametool-logentry' => 'renomeou $1 para "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'userrenametool-move-log' => 'Páginas foram movidas automaticamente ao renomear o usuário "[[User:$1|$1]]" para "[[User:$2|$2]]"',
	'right-renameuser' => 'Renomear usuários',
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
	'userrenametool-error-request' => 'Manam atinichu mañasqaykita chaskiyta.  Ama hina kaspa, ñawpaqman kutimuspa musuqmanta ruraykachay.',
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

/** Romanian (Română)
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'renameuser' => 'Redenumeşte utilizator',
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
	'userrenametool-page-exists' => 'Pagina $1 există deja şi nu poate fi suprascrisă automat.',
	'userrenametool-page-moved' => 'Pagina $1 a fost mutată la $2.',
	'userrenametool-page-unmoved' => 'Pagina $1 nu poate fi mutată la $2.',
	'userrenametool-logpage' => 'Raport redenumiri utilizatori',
	'userrenametool-logpagetext' => 'Acesta este un raport al modificărilor de nume de utilizator',
	'userrenametool-logentry' => 'a redenumit $1 în „$2”',
	'userrenametool-log' => '{{PLURAL:$1|o contribuţie|$1 contribuţii}}. Motiv: $2',
	'userrenametool-move-log' => 'Pagină mutată automat la redenumirea utilizatorului de la "[[User:$1|$1]]" la "[[User:$2|$2]]"',
	'right-renameuser' => 'Redenumeşte utilizatori',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'renameuser' => "Renomene l'utende",
	'userrenametool-submit' => 'Conferme',
);

/** Russian (Русский)
 * @author Ahonc
 * @author EugeneZelenko
 * @author Innv
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'renameuser' => 'Переименовать участника',
	'userrenametool-desc' => "Переименование участника (требуются права ''renameuser'')",
	'userrenametool-old' => 'Имя в настоящий момент:',
	'userrenametool-new' => 'Новое имя:',
	'userrenametool-reason' => 'Причина переименования:',
	'userrenametool-move' => 'Переименовать также страницу участника, личное обсуждение и их подстраницы',
	'userrenametool-reserve' => 'Зарезервировать старое имя участника для использования в будущем',
	'userrenametool-warnings' => 'Предупреждения:',
	'userrenametool-confirm' => 'Да, переименовать участника',
	'userrenametool-submit' => 'Выполнить',
	'userrenametool-errordoesnotexist' => 'Участник с именем «<nowiki>$1</nowiki>» не зарегистрирован.',
	'userrenametool-errorexists' => 'Участник с именем «<nowiki>$1</nowiki>» уже зарегистрирован.',
	'userrenametool-errorinvalid' => 'Недопустимое имя участника «<nowiki>$1</nowiki>»',
	'userrenametool-errortoomany' => 'Участник <nowiki>$1</nowiki> внёс $2 {{PLURAL:$2|правку|правки|правок}}, переименование участника с более чем $3 {{PLURAL:$3|правкой|правками|правками}} может оказать негативное влияние на доступ к сайту.',
	'userrenametool-error-request' => 'Возникли затруднения с получением запроса. Пожалуйста, вернитесь назад и повторите ещё раз.',
	'userrenametool-error-same-user' => 'Вы не можете переименовать участника в тоже имя, что и было раньше.',
	'userrenametool-success' => 'Участник «<nowiki>$1</nowiki>» был переименован в «<nowiki>$2</nowiki>».',
	'userrenametool-page-exists' => 'Страница $1 уже существует и не может быть перезаписана автоматически.',
	'userrenametool-page-moved' => 'Страница $1 была переименована в $2.',
	'userrenametool-page-unmoved' => 'Страница $1 не может быть переименована в $2.',
	'userrenametool-logpage' => 'Журнал переименований участников',
	'userrenametool-logpagetext' => 'Это журнал произведённых переименований зарегистрированных участников.',
	'userrenametool-logentry' => 'переименовал $1 в «$2»',
	'userrenametool-log' => '$1 {{PLURAL:$1|правка|правки|правок}}. Причина: $2',
	'userrenametool-move-log' => 'Автоматически в связи с переименованием учётной записи «[[User:$1|$1]]» в «[[User:$2|$2]]»',
	'right-renameuser' => 'переименование участников',
);

/** Yakut (Саха тыла)
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

/** Sicilian (Sicilianu)
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
	'userrenametool-move' => 'පරිශීලක හා සාකච්ඡා පිටු   (හා  ඒවායේ උපපිටු) නව නම වෙතට ගෙන යන්න',
	'userrenametool-reserve' => 'පැරණි පරිශීලක නම අනාගත භාවිතයෙන් වාරණය කරන්න',
	'userrenametool-warnings' => 'අවවාදයන්:',
	'userrenametool-confirm' => 'ඔව්, පරිශීලකයා යළි-නම්කරන්න',
	'userrenametool-errordoesnotexist' => '"<nowiki>$1</nowiki>" පරිශීලකයා නොපවතී.',
	'userrenametool-errorexists' => '"<nowiki>$1</nowiki>" පරිශීලකයා දැනටමත් පවතියි.',
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" පරිශීලක නාමය අනීතිකයි.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'renameuser' => 'Premenovať používateľa',
	'userrenametool-desc' => "Premenovať používateľa (vyžaduje právo ''renameuser'')",
	'userrenametool-old' => 'Súčasné používateľské meno:',
	'userrenametool-new' => 'Nové používateľské meno:',
	'userrenametool-reason' => 'Dôvod premenovania:',
	'userrenametool-move' => 'Presunúť používateľské a diskusné stránky (a ich podstránky) na nový názov',
	'userrenametool-reserve' => 'Vyhradiť staré používateľské meno (zabrániť ďalšiemu použitiu)',
	'userrenametool-warnings' => 'Upozornenia:',
	'userrenametool-confirm' => 'Áno, premenovať používateľa',
	'userrenametool-submit' => 'Odoslať',
	'userrenametool-errordoesnotexist' => 'Používateľ „<nowiki>$1</nowiki>“  neexistuje',
	'userrenametool-errorexists' => 'Používateľ „<nowiki>$1</nowiki>“ už existuje',
	'userrenametool-errorinvalid' => 'Používateľské meno „<nowiki>$1</nowiki>“ je neplatné',
	'userrenametool-errortoomany' => 'Používateľ „<nowiki>$1</nowiki>“ má $2 {{PLURAL:$2|príspevok|príspevky|príspevkov}}, premenovanie používateľa s viac ako $3 {{PLURAL:$3|príspevkom|príspevkami}} by sa mohlo nepriaznivo odraziť na výkone stránky.',
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

/** Albanian (Shqip)
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

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'renameuser' => 'Преименуј корисника',
	'userrenametool-desc' => "Додаје [[Special:Renameuser|посебу страну]] за преименовање сарадника (потребно право ''renameuser'').",
	'userrenametool-old' => 'Тренутно корисничко име:',
	'userrenametool-new' => 'Ново корисничко име:',
	'userrenametool-reason' => 'Разлог преименовања:',
	'userrenametool-move' => 'Премести корисничку страницу и страницу за разговор (и њихове подстранице) на ново име',
	'userrenametool-warnings' => 'Упозорења:',
	'userrenametool-confirm' => 'Да, преименуј сарадничко име.',
	'userrenametool-submit' => 'Прихвати',
	'userrenametool-errordoesnotexist' => 'Корисник "<nowiki>$1</nowiki>" не постоји',
	'userrenametool-errorexists' => 'Корисник "<nowiki>$1</nowiki>" већ постоји',
	'userrenametool-errorinvalid' => 'Погрешно корисничко име: "<nowiki>$1</nowiki>"',
	'userrenametool-errortoomany' => 'Корисник "<nowiki>$1</nowiki>" има $2 {{PLURAL:$2|прилог|прилога|прилога}}, преименовање корисника са више од $3 {{PLURAL:$3|прилог|прилога|прилога}} може да утиче на перформансе сајта.',
	'userrenametool-error-request' => 'Јавио се проблем приликом прихватања захтева. Иди назад и покушај поново.',
	'userrenametool-error-same-user' => 'Не можеш преименовати сарадничко име у исто као и претходно.',
	'userrenametool-success' => 'Корисник "<nowiki>$1</nowiki>" је преименован на "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Страница $1 већ постоји и не може бити аутоматски преснимљена.',
	'userrenametool-page-moved' => 'Страница $1 је премештена на $2.',
	'userrenametool-page-unmoved' => 'Страница $1 не може бити премештена на $2.',
	爀攀渀愀洀攀甀猀攀爀氀logpage' => 'Историја преименовања корисника',
	'userrenametool-logpagetext' => 'Ово је историја измена преименовања корисника',
	'userrenametool-logentry' => 'је преименовао $1 у „$2“',
	'userrenametool-log' => '{{PLURAL:$1|1 измена|$1 измене|$1 измена}}. Разлог: $2',
	'userrenametool-move-log' => 'Аутоматски померене стране приликом преименовања сарадничког имена: "[[User:$1|$1]]" у "[[User:$2|$2]]".',
	'right-renameuser' => 'Преименовање сарадничких имена',
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

/** Swedish (Svenska)
 * @author Boivie
 * @author Habj
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'renameuser' => 'Byt användarnamn',
	'userrenametool-desc' => "Lägger till en [[Special:Renameuser|specialsida]] för att byta namn på en användare (kräver behörigheten ''renameuser'')",
	'userrenametool-old' => 'Nuvarande användarnamn:',
	'userrenametool-new' => 'Nytt användarnamn:',
	'userrenametool-reason' => 'Anledning till namnbytet:',
	'userrenametool-move' => 'Flytta användarsidan och användardiskussionen (och deras undersidor) till det nya namnet',
	'userrenametool-reserve' => 'Reservera det gamla användarnamnet från framtida användning',
	'userrenametool-warnings' => 'Varningar:',
	'userrenametool-confirm' => 'Ja, byt namn på användaren',
	'userrenametool-submit' => 'Verkställ',
	'userrenametool-errordoesnotexist' => 'Användaren "<nowiki>$1</nowiki>" finns inte',
	'userrenametool-errorexists' => 'Användaren "<nowiki>$1</nowiki>" finns redan.',
	'userrenametool-errorinvalid' => 'Användarnamnet "<nowiki>$1</nowiki>" är ogiltigt.',
	'userrenametool-errortoomany' => 'Användaren "<nowiki>$1</nowiki>" har $2 {{PLURAL:$2|redigering|redigeringar}}. Att byta namn på en användare som gjort mer än $3 {{PLURAL:$3|redigering|redigeringar}} kan påverka webbplatsens prestanda negativt.',
	'userrenametool-error-request' => 'Ett problem inträffade i hanteringen av begäran. Gå tillbaks och försök igen.',
	'userrenametool-error-same-user' => 'Du kan inte byta namn på en användare till samma som tidigare.',
	'userrenametool-success' => 'Användaren "<nowiki>$1</nowiki>" har fått sitt namn bytt till "<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => 'Sidan $1 finns redan och kan inte skrivas över automatiskt.',
	'userrenametool-page-moved' => 'Sidan $1 har flyttats till $2.',
	'userrenametool-page-unmoved' => 'Sidan $1 kunde inte flyttas till $2.',
	'userrenametool-logpage' => 'Logg över användarnamnsbyten',
	'userrenametool-logpagetext' => 'Detta är en logg över byten av användarnamn',
	'userrenametool-logentry' => 'bytte namn på $1 till "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 redigering|$1 redigeringar}}. Anledning: $2',
	'userrenametool-move-log' => 'Flyttade automatiskt sidan när namnet byttes på användaren "[[User:$1|$1]]" till "[[User:$2|$2]]"',
	'right-renameuser' => 'Ändra användares namn',
);

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'renameuser' => 'సభ్యనామం మార్పు',
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
	'userrenametool-errorinvalid' => '"<nowiki>$1</nowiki>" అనే సభ్యనామం సరైనది కాదు.',
	'userrenametool-errortoomany' => 'వాడుకరి "<nowiki>$1</nowiki>" $2 {{PLURAL:$2|రచన|రచనలు}} చేసారు. $3 కంటే ఎక్కువ {{PLURAL:$3|రచన|రచనలు}} చేసిన వాడుకరి పేరు మార్చడం వలన సైటు పనితీరుపై ప్రతికూల ప్రభావం పడగలదు.',
	'userrenametool-error-request' => 'మీ అభ్యర్థనను స్వీకరించేటప్పుడు ఒక సమస్య తలెత్తింది. దయచేసి వెనక్కు వెళ్లి ఇంకోసారి ప్రయత్నించండి.',
	'userrenametool-error-same-user' => 'సభ్యనామాన్ని ఇంతకు ముందు ఉన్న సభ్యనామంతోనే మార్చడం కుదరదు.',
	'userrenametool-success' => '"<nowiki>$1</nowiki>" అనే సభ్యనామాన్ని "<nowiki>$2</nowiki>"గా మార్చేసాం.',
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

/** Tetum (Tetun)
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

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
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
	'userrenametool-move-log' => 'Саҳифа дар вақти тағйири номи корбар  "[[User:$1|$1]]" ба "[[User:$2|$2]]" ба таври худкор кӯчонида шуд',
	'right-renameuser' => 'Тағйири номи корбарон',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'userrenametool-error-request' => 'มีปัญหาเกิดขึ้นเกี่ยวกับการรับคำเรียกร้องของคุณ กรุณากลับไปที่หน้าเดิม และ พยายามอีกครั้ง',
	'userrenametool-success' => 'ผู้ใช้:<nowiki>$1</nowiki> ถูกเปลี่ยนชื่อเป็น ผู้ใช้:<nowiki>$2</nowiki> เรียบร้อยแล้ว',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'renameuser' => 'Muling pangalanan ang tagagamit',
	'userrenametool-desc' => "Nagdaragdag ng isang [[Special:Renameuser|natatanging pahina]] para mapangalanang muli ang isang tagagamit (kailangang ang karapatang ''pangalanangmuliangtagagamit'')",
	'userrenametool-old' => 'Pangkasalukuyang pangalan ng tagagamit:',
	'userrenametool-new' => 'Bagong pangalan ng tagagamit:',
	'userrenametool-reason' => 'Dahil para sa muling pagpapangalan:',
	'userrenametool-move' => 'Ilipat ang mga pahina ng tagagamit at pangusapan (at mga kabahaging pahina nila) patungo sa bagong pangalan',
	'userrenametool-reserve' => 'Hadlangan ang dating pangalan ng tagagamit mula sa muling paggamit sa hinaharap',
	'userrenametool-warnings' => 'Mga babala:',
	'userrenametool-confirm' => 'Oo, pangalanang muli ang tagagamit',
	'userrenametool-submit' => 'Ipasa',
	'userrenametool-errordoesnotexist' => 'Hindi pa umiiral ang tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errorexists' => 'Umiiral na ang tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errorinvalid' => 'Hindi tanggap ang pangalan ng tagagamit na "<nowiki>$1</nowiki>".',
	'userrenametool-errortoomany' => 'Ang tagagamit na si "<nowiki>$1</nowiki>" ay mayroong $2 {{PLURAL:$2|ambag|mga ambag}}, ang muling pagpapangalan sa isang tagagamit na may mahigit sa $3 {{PLURAL:$3|ambag|mga ambag}} ay makakaapekto sa gawain ng sayt/sityo.',
	'userrenametool-error-request' => 'Nagkaroon ng isang suliranin sa pagtanggap ng kahilingan.
Magbalik lamang at subukan uli.',
	'userrenametool-error-same-user' => 'Hindi mo maaaring pangalanang muli ang tagagamit patungo sa kaparehong bagay na katulad ng dati.',
	'userrenametool-success' => 'Ang tagagamit na "<nowiki>$1</nowiki>" ay muling napangalanan na patungong "<nowiki>$2</nowiki>".',
	'userrenametool-page-exists' => 'Umiiral na ang pahinang $1 at hindi maaaring kusang mapatungan.',
	'userrenametool-page-moved' => 'Ang pahinang $1 ay nailipat na patungo sa $2.',
	'userrenametool-page-unmoved' => 'Hindi mailipat ang pahinang $1 patungo sa $2.',
	'userrenametool-logpage' => 'Talaan ng muling pagpapangalan ng tagagamit',
	'userrenametool-logpagetext' => 'Isa itong pagtatala/talaan ng mga pagbabago sa mga pangalan ng tagagamit.',
	'userrenametool-logentry' => 'muling pinangalan si $1 patungo sa "$2"',
	'userrenametool-log' => '{{PLURAL:$1|1 pagbabago|$1 mga pagbabago}}. Dahilan: $2',
	'userrenametool-move-log' => 'Kusang inilipat ang pahina habang muling pinapangalanan ang tagagamit na si "[[User:$1|$1]]" patungo sa "[[User:$2|$2]]"',
	'right-renameuser' => 'Muling pangalanan ang mga tagagamit',
);

/** Tonga (faka-Tonga) */
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
	'right-renameuser' => 'Kullaıcılarının adlarını değiştir',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author EugeneZelenko
 */
$messages['uk'] = array(
	'renameuser' => 'Перейменувати користувача',
	'userrenametool-desc' => "Перейменування користувача (потрібні права ''renameuser'')",
	'userrenametool-old' => "Поточне ім'я:",
	'userrenametool-new' => "Нове ім'я:",
	'userrenametool-reason' => 'Причина перейменування:',
	'userrenametool-move' => 'Перейменувати також сторінку користувача, сторінку обговорення та їхні підсторінки',
	'userrenametool-reserve' => "Зарезервувати старе ім'я користувача для подальшого використання",
	'userrenametool-warnings' => 'Попередження:',
	'userrenametool-confirm' => 'Так, перейменувати користувача',
	'userrenametool-submit' => 'Виконати',
	'userrenametool-errordoesnotexist' => 'Користувач з іменем «<nowiki>$1</nowiki>» не зареєстрований.',
	'userrenametool-errorexists' => 'Користувач з іменем «<nowiki>$1</nowiki>» уже зареєстрований.',
	'userrenametool-errorinvalid' => "Недопустиме ім'я користувача: <nowiki>$1</nowiki>.",
	'userrenametool-errortoomany' => 'Користувач "<nowiki>$1</nowiki>" вніс $2 {{PLURAL:$2|редагування|редагування|редагувань}}, перейменування користувача з більш ніж $3 {{PLURAL:$3|редагуванням|редагуваннями}} може негативно вплинути на доступ до сайту.',
	'userrenametool-error-request' => 'Виникли ускладнення з отриманням запиту. Будь ласка, поверніться назад і повторіть іще раз.',
	'userrenametool-error-same-user' => "Ви не можете змінити ім'я користувача на те саме, що було раніше.",
	'userrenametool-success' => 'Користувач «<nowiki>$1</nowiki>» був перейменований на «<nowiki>$2</nowiki>».',
	'userrenametool-page-exists' => 'Сторінка $1 вже існує і не може бути перезаписана автоматично.',
	'userrenametool-page-moved' => 'Сторінка $1 була перейменована на $2.',
	'userrenametool-page-unmoved' => 'Сторінка $1 не може бути перейменована на $2.',
	'userrenametool-logpage' => 'Журнал перейменувань користувачів',
	'userrenametool-logpagetext' => 'Це журнал здійснених перейменувань зареєстрованих користувачів.',
	'userrenametool-logentry' => 'перейменував $1 на «$2»',
	'userrenametool-log' => 'мав $1 {{PLURAL:$1|редагування|редагування|редагувань}}. Причина: $2',
	'userrenametool-move-log' => 'Автоматичне перейменування сторінки при перейменуванні користувача «[[User:$1|$1]]» на «[[User:$2|$2]]»',
	'right-renameuser' => 'Перейменування користувачів',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'renameuser' => 'صارف کا نام تبدیل کریں',
	'userrenametool-log' => 'جن کی $1 ترامیم تھیں. $2',
);

/** Vèneto (Vèneto)
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

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'renameuser' => 'Đổi tên thành viên',
	'userrenametool-desc' => "Đổi tên thành viên (cần có quyền ''renameuser'')",
	'userrenametool-old' => 'Tên hiệu hiện nay:',
	'userrenametool-new' => 'Tên hiệu mới:',
	'userrenametool-reason' => 'Lý do đổi tên:',
	'userrenametool-move' => 'Di chuyển trang thành viên và thảo luận thành viên (cùng với trang con của nó) sang tên mới',
	'userrenametool-reserve' => 'Không cho phép ai lấy tên cũ',
	'userrenametool-warnings' => 'Cảnh báo:',
	'userrenametool-confirm' => 'Đổi tên người dùng',
	'userrenametool-submit' => 'Thực hiện',
	'userrenametool-errordoesnotexist' => 'Thành viên “<nowiki>$1</nowiki>” không tồn tại.',
	'userrenametool-errorexists' => 'Thành viên “<nowiki>$1</nowiki>” đã hiện hữu.',
	'userrenametool-errorinvalid' => 'Tên thành viên “<nowiki>$1</nowiki>” không hợp lệ.',
	'userrenametool-errortoomany' => 'Thành viên “<nowiki>$1</nowiki>” có $2 đóng góp, đổi tên thành viên có hơn $3 đóng góp có thể ảnh hưởng xấu đến hiệu năng của trang.',
	'userrenametool-error-request' => 'Có trục trặc trong tiếp nhận yêu cầu. Xin hãy quay lại và thử lần nữa.',
	'userrenametool-error-same-user' => 'Bạn không thể đổi tên thành viên sang tên y hệt như vậy.',
	'userrenametool-success' => 'Thành viên “<nowiki>$1</nowiki>” đã được đổi tên thành “<nowiki>$2</nowiki>”.',
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

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'renameuser' => 'Rilomer èn uzeu',
	'userrenametool-old' => "No d' elodjaedje pol moumint:",
	'userrenametool-new' => "Novea no d' elodjaedje:",
	'userrenametool-reason' => 'Råjhon pol rilomaedje:',
	'userrenametool-move' => "Displaecî les pådjes d' uzeu et d' copene (eyet leus dzo-pådjes) viè l' novea no",
	'userrenametool-submit' => 'Evoye',
	'userrenametool-errordoesnotexist' => "L' uzeu «<nowiki>$1</nowiki>» n' egzistêye nén",
	'userrenametool-errorexists' => "L' uzeu «<nowiki>$1</nowiki>» egzistêye dedja",
	'userrenametool-errorinvalid' => "Li no d' elodjaedje «<nowiki>$1</nowiki>» n' est nén on no valide",
	'userrenametool-errortoomany' => "L' uzeu «<nowiki>$1</nowiki>» a $2 contribouwaedjes, rilomer èn uzeu avou pus di $3 contribouwaedjes pout aveur des consecwinces sol performance del waibe",
	'userrenametool-success' => "L' uzeu «<nowiki>$1</nowiki>» a stî rlomé a «<nowiki>$2</nowiki>»",
	'userrenametool-page-exists' => "Li pådje $1 egzistêye dedja et n' pout nén esse otomaticmint spotcheye.",
	'userrenametool-page-moved' => 'Li pådje $1 a stî displaeceye viè $2.',
	'userrenametool-page-unmoved' => 'Li pådje $1 èn pout nén esse displaeceye viè $2.',
	'userrenametool-logpage' => "Djournå des candjmints d' no d' uzeus",
	'userrenametool-logpagetext' => "Chal pa dzo c' est ene djivêye des uzeus k' ont candjî leu no d' elodjaedje.",
	'userrenametool-log' => "k' aveut ddja fwait $1 candjmints. $2",
	'userrenametool-move-log' => "Pådje displaeceye otomaticmint tot rlomant l' uzeu «[[User:$1|$1]]» viè «[[User:$2|$2]]»",
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'renameuser' => 'בײַטן באַניצער נאָמען',
	'userrenametool-old' => 'לויפיגער באניצער-נאמען:',
	'userrenametool-new' => 'נייער באניצער-נאמען',
	'userrenametool-errordoesnotexist' => 'דער באניצער "<nowiki>$1</nowiki>" עקסיסטירט נישט.',
	'userrenametool-errorexists' => 'דער באניצער  "<nowiki>$1</nowiki>" עקסיסטירט שוין.',
	'userrenametool-errorinvalid' => 'דער באניצער נאמען  "<nowiki>$1</nowiki>" איז נישט גילטיק.',
	'userrenametool-logpage' => 'באַניצער נאָמען-טויש לאָג-בוך',
);

/** Yue (粵語) */
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

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'renameuser' => '用户重命名',
	'userrenametool-desc' => "为用户重命名 (需要 ''renameuser'' 权限)",
	'userrenametool-old' => '当前用户名:',
	'userrenametool-new' => '新用户名:',
	'userrenametool-reason' => '重命名的原因:',
	'userrenametool-move' => '移动用户页及其对话页（包括各子页）到新的名字',
	'userrenametool-reserve' => '封禁旧用户名，使之不能在日后使用',
	'userrenametool-warnings' => '警告:',
	'userrenametool-confirm' => '是，为用户重命名',
	'userrenametool-submit' => '提交',
	'userrenametool-errordoesnotexist' => '用户"<nowiki>$1</nowiki>"不存在',
	'userrenametool-errorexists' => '用户"<nowiki>$1</nowiki>"已存在',
	'userrenametool-errorinvalid' => '用户名"<nowiki>$1</nowiki>"不可用',
	'userrenametool-errortoomany' => '用户"<nowiki>$1</nowiki>"贡献了$2次，重命名一个超过$3次的用户会影响站点性能',
	'userrenametool-error-request' => '在收到请求时出现问题。
请回去重试。',
	'userrenametool-error-same-user' => '您不可以更改一位用户是跟之前的东西一样。',
	'userrenametool-success' => '用户"<nowiki>$1</nowiki>"已经更名为"<nowiki>$2</nowiki>"',
	'userrenametool-page-exists' => '$1这一页己经存在，不能自动覆写。',
	'userrenametool-page-moved' => '$1这一页已经移动到$2。',
	'userrenametool-page-unmoved' => '$1这一页不能移动到$2。',
	'userrenametool-logpage' => '用户名变更日志',
	'userrenametool-logpagetext' => '这是用户名更改的日志',
	'userrenametool-logentry' => '已经把 $1 重命名为 "$2"',
	'userrenametool-log' => '拥有$1次编辑。 理由: $2',
	'userrenametool-move-log' => '当由"[[User:$1|$1]]"重命名作"[[User:$2|$2]]"时已经自动移动用户页',
	'right-renameuser' => '重新命名用户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
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

/** Zulu (isiZulu) */
$messages['zu'] = array(
	'userrenametool-submit' => 'Yisa',
);

