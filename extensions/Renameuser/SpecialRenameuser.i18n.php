<?php
/**
 * Internationalisation file for extension Renameuser.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'renameuser'          => 'Rename user',
	'renameuser-desc'     => 'Adds a [[Special:Renameuser|special page]] to rename a user (need \'\'renameuser\'\' right)',
	'renameuserold'       => 'Current username:',
	'renameusernew'       => 'New username:',
	'renameuserreason'    => 'Reason for rename:',
	'renameusermove'      => 'Move user and talk pages (and their subpages) to new name',
	'renameuserwarnings'  => 'Warnings:',
	'renameuserconfirm'   => 'Yes, rename the user',
	'renameusersubmit'    => 'Submit',

	'renameusererrordoesnotexist' => 'The user "<nowiki>$1</nowiki>" does not exist.',
	'renameusererrorexists'       => 'The user "<nowiki>$1</nowiki>" already exists.',
	'renameusererrorinvalid'      => 'The username "<nowiki>$1</nowiki>" is invalid.',
	'renameusererrortoomany'      => 'The user "<nowiki>$1</nowiki>" has $2 contributions, renaming a user with more than $3 contributions could adversely affect site performance.',
	'renameuser-error-request'    => 'There was a problem with receiving the request.
Please go back and try again.',
	'renameuser-error-same-user'  => 'You cannot rename a user to the same thing as before.',
	'renameusersuccess'           => 'The user "<nowiki>$1</nowiki>" has been renamed to "<nowiki>$2</nowiki>".',

	'renameuser-page-exists'  => 'The page $1 already exists and cannot be automatically overwritten.',
	'renameuser-page-moved'   => 'The page $1 has been moved to $2.',
	'renameuser-page-unmoved' => 'The page $1 could not be moved to $2.',

	'renameuserlogpage'     => 'User rename log',
	'renameuserlogpagetext' => 'This is a log of changes to user names.',
	'renameuserlogentry'    => 'has renamed $1 to "$2"',
	'renameuser-log'        => '{{PLURAL:$1|1 edit|$1 edits}}. Reason: $2',
	'renameuser-move-log'   => 'Automatically moved page while renaming the user "[[User:$1|$1]]" to "[[User:$2|$2]]"',

	'right-renameuser'      => 'Rename users',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 * @author Naudefj
 */
$messages['af'] = array(
	'renameuser'                  => 'Hernoem gebruiker',
	'renameuser-desc'             => "Herdoop gebruikers (benodig ''renameuser'' regte)",
	'renameuserold'               => 'Huidige gebruikersnaam:',
	'renameusernew'               => 'Nuwe gebruikersnaam:',
	'renameuserreason'            => 'Rede vir hernoeming:',
	'renameuserwarnings'          => 'Waarskuwings:',
	'renameusersubmit'            => 'Hernoem',
	'renameusererrordoesnotexist' => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan nie',
	'renameusererrorexists'       => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan reeds',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" is \'n ongeldige gebruikernaam',
	'renameusersuccess'           => 'Die gebruiker "<nowiki>$1</nowiki>" is hernoem na "<nowiki>$2</nowiki>".',
	'renameuserlogpage'           => 'Logboek van gebruikershernoemings',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 * @author Siebrand
 * @author SMP
 */
$messages['an'] = array(
	'renameuser'                  => 'Renombrar un usuario',
	'renameuser-desc'             => "Renombrar un usuario (amenista os dreitos de ''renameuser'')",
	'renameuserold'               => 'Nombre autual:',
	'renameusernew'               => 'Nombre nuebo:',
	'renameuserreason'            => "Razón d'o cambeo de nombre:",
	'renameusermove'              => "Tresladar as pachinas d'usuario y de descusión (y as suyas sozpachinas) ta o nuebo nombre",
	'renameuserwarnings'          => 'Albertenzias:',
	'renameuserconfirm'           => "Sí, quiero cambiar o nombre de l'usuario",
	'renameusersubmit'            => 'Nimbiar',
	'renameusererrordoesnotexist' => 'L\'usuario "<nowiki>$1</nowiki>" no esiste.',
	'renameusererrorexists'       => 'L\'usuario "<nowiki>$1</nowiki>" ya esiste.',
	'renameusererrorinvalid'      => 'O nombre d\'usuario "<nowiki>$1</nowiki>" no ye conforme.',
	'renameusererrortoomany'      => 'L\'usuario "<nowiki>$1</nowiki>" tiene $2 contrebuzions. Renombrar un usuario con más de $3 contrebuzions podría afeutar t\'o funzionamiento d\'o sitio.',
	'renameuser-error-request'    => 'Bi abió un problema reculliendo a demanda. Por fabor, torne entazaga y prebe una atra begada.',
	'renameuser-error-same-user'  => 'No puede renombrar un usuario con o mesmo nombre que ya teneba.',
	'renameusersuccess'           => 'S\'ha renombrau l\'usuario "<nowiki>$1</nowiki>" como "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'A pachina $1 ya esiste y no puede estar sustituyita automaticament.',
	'renameuser-page-moved'       => "S'ha tresladato a pachina $1 ta $2.",
	'renameuser-page-unmoved'     => "A pachina $1 no s'ha puesto tresladar ta $2.",
	'renameuserlogpage'           => "Rechistro de cambios de nombre d'usuarios",
	'renameuserlogpagetext'       => "Isto ye un rechistro de cambios de nombres d'usuarios",
	'renameuserlogentry'          => 'Ha renombrato á $1 como "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 edizión|$1 edizions}}. Razón: $2',
	'renameuser-move-log'         => 'Pachina tresladata automaticament en renombrar o usuario "[[User:$1|$1]]" como "[[User:$2|$2]]"',
	'right-renameuser'            => 'Renombrar usuarios',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mido
 * @author Siebrand
 */
$messages['ar'] = array(
	'renameuser'                  => 'إعادة تسمية مستخدم',
	'renameuser-desc'             => "إعادة تسمية مستخدم (يحتاج إلى صلاحية ''renameuser'')",
	'renameuserold'               => 'اسم المستخدم الحالي:',
	'renameusernew'               => 'الاسم الجديد:',
	'renameuserreason'            => 'السبب لإعادة التسمية:',
	'renameusermove'              => 'انقل صفحات المستخدم ونقاشه (بالصفحات الفرعية) إلى الاسم الجديد',
	'renameuserwarnings'          => 'التحذيرات:',
	'renameuserconfirm'           => 'نعم، أعد تسمية المستخدم',
	'renameusersubmit'            => 'تنفيذ',
	'renameusererrordoesnotexist' => 'لا يوجد مستخدم بالاسم "<nowiki>$1</nowiki>"',
	'renameusererrorexists'       => 'المستخدم "<nowiki>$1</nowiki>" موجود بالفعل',
	'renameusererrorinvalid'      => 'اسم المستخدم "<nowiki>$1</nowiki>" غير صحيح',
	'renameusererrortoomany'      => 'يمتلك المستخدم "<nowiki>$1</nowiki>" $2 مساهمة، إعادة تسمية مستخدم يمتلك أكثر من $3 مساهمة قد يؤثر سلبا على أداء الموقع.',
	'renameuser-error-request'    => 'حدثت مشكلة أثناء استقبال الطلب. من فضلك عد وحاول مرة ثانية.',
	'renameuser-error-same-user'  => 'لا يمكنك إعادة تسمية مستخدم بنفس الاسم كما كان من قبل.',
	'renameusersuccess'           => 'تمت إعادة تسمية المستخدم "<nowiki>$1</nowiki>" إلى "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'الصفحة $1 موجودة بالفعل ولا يمكن إنشاء أخرى مكانها أوتوماتيكيا.',
	'renameuser-page-moved'       => 'تم نقل الصفحة $1 إلى $2.',
	'renameuser-page-unmoved'     => 'لم يتمكن من نقل الصفحة $1 إلى $2.',
	'renameuserlogpage'           => 'سجل إعادة تسمية المستخدمين',
	'renameuserlogpagetext'       => 'هذا سجل بالتغييرات في أسماء المستخدمين',
	'renameuserlogentry'          => 'أعاد تسمية $1 باسم "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 تعديل|$1 تعديل}}. السبب: $2',
	'renameuser-move-log'         => 'نقل الصفحة تلقائيا خلال إعادة تسمية المستخدم من "[[User:$1|$1]]" إلى "[[User:$2|$2]]"',
	'right-renameuser'            => 'إعادة تسمية المستخدمين',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author SPQRobin
 */
$messages['arc'] = array(
	'renameusersubmit' => 'ܡܨܝܘܬܐ',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Siebrand
 */
$messages['ast'] = array(
	'renameuser'                  => 'Renomar usuariu',
	'renameuser-desc'             => "Renoma un usuariu (necesita'l permisu ''renameuser'')",
	'renameuserold'               => "Nome d'usuariu actual:",
	'renameusernew'               => "Nome d'usuariu nuevu:",
	'renameuserreason'            => 'Motivu del cambéu de nome:',
	'renameusermove'              => "Treslladar les páxines d'usuariu y d'alderique (y toles subpáxines) al nome nuevu",
	'renameusersubmit'            => 'Executar',
	'renameusererrordoesnotexist' => 'L\'usuariu "<nowiki>$1</nowiki>" nun esiste.',
	'renameusererrorexists'       => 'L\'usuariu "<nowiki>$1</nowiki>" yá esiste.',
	'renameusererrorinvalid'      => 'El nome d\'usuariu "<nowiki>$1</nowiki>" nun ye válidu.',
	'renameusererrortoomany'      => 'L\'usuariu "<nowiki>$1</nowiki>" tien $2 contribuciones; renomar a un usuariu con más de $3 contribuciones podría afeutar al rindimientu del sitiu.',
	'renameuser-error-request'    => 'Hebo un problema al recibir el pidimientu. Por favor vuelve atrás y inténtalo otra vuelta.',
	'renameuser-error-same-user'  => 'Nun pues renomar un usuariu al mesmu nome que tenía.',
	'renameusersuccess'           => 'L\'usuariu "<nowiki>$1</nowiki>" foi renomáu como "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'La páxina $1 yá esiste y nun pue ser sobreescrita automáticamente.',
	'renameuser-page-moved'       => 'La páxina $1 treslladóse a $2.',
	'renameuser-page-unmoved'     => 'La páxina $1 nun pudo treslladase a $2.',
	'renameuserlogpage'           => "Rexistru de cambeos de nome d'usuariu",
	'renameuserlogpagetext'       => "Esti ye un rexistru de los cambeos de nomes d'usuariu",
	'renameuserlogentry'          => 'renomó a $1 como "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivu: $2',
	'renameuser-move-log'         => 'Treslladóse la páxina automáticamente al renomar al usuariu "[[User:$1|$1]]" como "[[User:$2|$2]]"',
	'right-renameuser'            => 'Renomar usuarios',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'renameuser'                  => 'کاربر نامی بدل کن',
	'renameuser-desc'             => "یک کاربر نامی بدیل کن(حق ''بدل نام''لازمن)",
	'renameuserold'               => 'هنوکین نام کاربری:',
	'renameusernew'               => 'نوکین نام کاربری:',
	'renameuserreason'            => 'دلیل په نام بدل کتن:',
	'renameusermove'              => 'صفحات گپ و کاربر (و آیانی زیر صفحات) په نوکین نام جاه په جاه کن',
	'renameuserwarnings'          => 'هوژاریان:',
	'renameuserconfirm'           => 'بله، کاربر نامی عوض کن',
	'renameusersubmit'            => 'دیم دی',
	'renameusererrordoesnotexist' => 'کاربر "<nowiki>$1</nowiki>" موجود نهنت.',
	'renameusererrorexists'       => 'کاربر "<nowiki>$1</nowiki>" هنو هستن.',
	'renameusererrorinvalid'      => 'نام کاربری "<nowiki>$1</nowiki>"  نامعتبر انت.',
	'renameuser-error-request'    => 'مشکلی گون دریافت درخواست هستت.
لطفا برگردیت و دگه تلاش کنیت.',
	'renameuser-error-same-user'  => 'شما نه تونیت یک کاربر په هما پیشگین چیزی نامی بدل کنیت',
	'renameusersuccess'           => 'کاربر "<nowiki>$1</nowiki>" نامی بدل بوتت په "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'صفحه $1 الان هست و اتوماتیکی اور آی نوسیگ نه بیت.',
	'renameuser-page-moved'       => 'صفحه $1 جاه په جاه بیت په $2.',
	'renameuser-page-unmoved'     => 'صفحه $1 نه تونیت په $2 جاه په جاه بیت.',
	'renameuserlogpage'           => 'آمار نام بدل کتن کاربر',
	'renameuserlogpagetext'       => 'شی آماری چه تغییرات نامان کاربران انت',
	'renameuserlogentry'          => 'نام بدل بوت  $1 په "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 اصلاح|$1 اصلاحلات}}. دلیل: $2',
	'renameuser-move-log'         => 'اتوماتیکی صفحه جاه په جاه بیت وهدی که کاربر نام بدل بی "[[User:$1|$1]]" به "[[User:$2|$2]]"',
	'right-renameuser'            => 'عوض کتن نام کابران',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'renameusersubmit'            => 'Isumitir',
	'renameusererrordoesnotexist' => 'An parágamit "<nowiki>$1</nowiki>" mayò man',
	'renameusererrorexists'       => 'An parágamit "<nowiki>$1</nowiki>" yaon na',
	'renameuser-page-moved'       => 'An páhinang $1 piglipat sa $2.',
	'renameuser-page-unmoved'     => 'An páhinang $1 dai mailipat sa $2.',
	'renameuser-log'              => '$1 mga hirá. Rasón: $2',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'renameusernew'      => 'Новае імя:',
	'renameuserreason'   => 'Прычына перайменаваньня:',
	'renameuserwarnings' => 'Папярэджаньні:',
	'renameuserconfirm'  => 'Так, перайменаваць удзельніка',
	'renameuserlogpage'  => 'Журнал перайменаваньняў удзельнікаў',
	'renameuser-log'     => '$1 {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}. Прычына: $2',
	'right-renameuser'   => 'перайменаваньне ўдзельнікаў',
);

/** Bulgarian (Български)
 * @author Spiritia
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'renameuser'                  => 'Преименуване на потребител',
	'renameuser-desc'             => 'Добавя възможност за преименуване на потребители',
	'renameuserold'               => 'Текущо потребителско име:',
	'renameusernew'               => 'Ново потребителско име:',
	'renameuserreason'            => 'Причина за преименуването:',
	'renameusermove'              => 'Преместване под новото име на потребителската лична страница и беседа (както и техните подстраници)',
	'renameuserwarnings'          => 'Предупреждения:',
	'renameuserconfirm'           => 'Да, преименуване на потребителя',
	'renameusersubmit'            => 'Изпълнение',
	'renameusererrordoesnotexist' => 'Потребителят „<nowiki>$1</nowiki>“ не съществува.',
	'renameusererrorexists'       => 'Потребителят „<nowiki>$1</nowiki>“ вече съществува.',
	'renameusererrorinvalid'      => 'Потребителското име „<nowiki>$1</nowiki>“ е невалидно.',
	'renameusererrortoomany'      => 'Потребителят „<nowiki>$1</nowiki>“ има $2 редакции. Преименуването на потребители, имащи повече от $3 редакции, може да се отрази лошо върху производителността на сайта.',
	'renameuser-error-request'    => 'Имаше проблем с приемането на заявката. Върнете се на предишната страница и опитайте отново!',
	'renameuser-error-same-user'  => 'Новото потребителско име е същото като старото.',
	'renameusersuccess'           => 'Потребителят „<nowiki>$1</nowiki>“ беше преименуван на „<nowiki>$2</nowiki>“',
	'renameuser-page-exists'      => 'Страницата $1 вече съществува и не може да бъде автоматично заместена.',
	'renameuser-page-moved'       => 'Страницата $1 беше преместена като $2.',
	'renameuser-page-unmoved'     => 'Страницата $1 не можа да бъде преместена като $2.',
	'renameuserlogpage'           => 'Дневник на преименуванията',
	'renameuserlogpagetext'       => 'В този дневник се записват преименуванията на потребители.',
	'renameuserlogentry'          => 'преименува $1 на „$2“',
	'renameuser-log'              => '{{PLURAL:$1|една редакция|$1 редакции}}. Причина: $2',
	'renameuser-move-log'         => 'Автоматично преместена страница при преименуването на потребител "[[User:$1|$1]]" като "[[User:$2|$2]]"',
	'right-renameuser'            => 'преименуване на потребители',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Siebrand
 */
$messages['bn'] = array(
	'renameuser'                  => 'ব্যবহারকারী নামান্তর করো',
	'renameuser-desc'             => "একজন ব্যবহারকারীকে নামান্তর করুন (''ব্যবহাকারী নামান্তর'' অধিকার প্রয়োজন)",
	'renameuserold'               => 'বর্তমান ব্যবহারকারী নাম:',
	'renameusernew'               => 'নতুন ব্যবহারকারী নাম:',
	'renameuserreason'            => 'নামান্তরের কারণ:',
	'renameusermove'              => 'ব্যবহারকারী এবং আলাপের পাতা (এবং তার উপপাতাসমূহ) নতুন নামে সরিয়ে নাও',
	'renameuserwarnings'          => 'সতর্কীকরণ:',
	'renameuserconfirm'           => 'হ্যা, ব্যবহারকারীর নাম পরিবর্তন করো',
	'renameusersubmit'            => 'জমা দিন',
	'renameusererrordoesnotexist' => '"<nowiki>$1</nowiki>" নামের কোন ব্যবহারকারী নাই।',
	'renameusererrorexists'       => '"<nowiki>$1</nowiki>" ব্যবহারকারী ইতিমধ্যে বিদ্যমান আছে।',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" ব্যবহারকারী নামটি ঠিক নয়।',
	'renameuser-error-request'    => 'এই অনুরোধ গ্রহণে সমস্যা ছিল। দয়াকরে পেছনে যান এবং আবার চেষ্টা করুন।',
	'renameuser-error-same-user'  => 'আপনি পূর্বের নামে নামান্তর করতে পারবেন না।',
	'renameusersuccess'           => 'ব্যবহারকারী "<nowiki>$1</nowiki>" থেকে "<nowiki>$2</nowiki>" তে নামান্তরিত করা হয়েছে।',
	'renameuser-page-exists'      => 'পাতা $1 বিদ্যমান এবং সয়ঙ্ক্রিয়ভাবে এটির উপর লেখা যাবে না',
	'renameuser-page-moved'       => 'পাতাটি $1 থেকে $2 তে সরিয়ে নেওয়া হয়েছে।',
	'renameuser-page-unmoved'     => 'পাতাটি $1 থেকে $2 তে সরিয়ে নেওয়া যাবে না।',
	'renameuserlogpage'           => 'ব্যবহারকারী নামান্তরের লগ',
	'renameuserlogpagetext'       => 'এটি ব্যাবহারকারী নামের পরিবর্তনের লগ',
	'renameuserlogentry'          => '$1 থেকে "$2" তে নামান্তর করা হয়েছে',
	'renameuser-log'              => '{{PLURAL:$1|1 সম্পাদনা|$1 সম্পাদনাসমূহ}}। কারণ: $2',
	'renameuser-move-log'         => 'যখন ব্যবহারকারী "[[User:$1|$1]]" থেকে "[[User:$2|$2]]" তে নামান্তরিত হবে তখন সয়ঙ্ক্রিয়ভাবে পাতা সরিয়ে নেওয়া হয়েছে',
	'right-renameuser'            => 'ব্যবহারকারীদের পুনরায় নাম দাও',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Siebrand
 */
$messages['br'] = array(
	'renameuser'                  => 'Adenvel an implijer',
	'renameuser-desc'             => "Adenvel un implijer (ret eo kaout ''gwirioù adenvel'')",
	'renameuserold'               => 'Anv a-vremañ an implijer :',
	'renameusernew'               => 'Anv implijer nevez :',
	'renameuserreason'            => 'Abeg evit adenvel :',
	'renameusermove'              => 'Kas ar pajennoù implijer ha kaozeal (hag o ispajennoù) betek o anv nevez',
	'renameusersubmit'            => 'Adenvel',
	'renameusererrordoesnotexist' => 'An implijer "<nowiki>$1</nowiki>" n\'eus ket anezhañ',
	'renameusererrorexists'       => 'Krouet eo bet an anv implijer "<nowiki>$1</nowiki>" dija',
	'renameusererrorinvalid'      => 'Faziek eo an anv implijer "<nowiki>$1</nowiki>"',
	'renameusererrortoomany'      => 'Deuet ez eus $2 degasadenn gant an implijer "<nowiki>$1</nowiki>"; adenvel un implijer degaset gantañ ouzhpenn $3 degasadenn a c\'hall noazout ouzh startijenn mont en-dro al lec\'hienn a-bezh',
	'renameuser-error-request'    => 'Ur gudenn zo bet gant degemer ar reked. Kit war-gil ha klaskit en-dro.',
	'renameuser-error-same-user'  => "N'haller ket adenvel un implijer gant an hevelep anv hag a-raok.",
	'renameusersuccess'           => 'Deuet eo an implijer "<nowiki>$1</nowiki>" da vezañ "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => "Bez' ez eus eus ar bajenn $1 dija, n'haller ket hec'h erlec'hiañ ent emgefreek.",
	'renameuser-page-moved'       => 'Adkaset eo bet ar bajenn $1 da $2.',
	'renameuser-page-unmoved'     => "N'eus ket bet gallet adkas ar bajenn $1 da $2.",
	'renameuserlogpage'           => 'Roll an implijerien bet adanvet',
	'renameuserlogpagetext'       => 'Setu istor an implijerien bet cheñchet o anv ganto',
	'renameuserlogentry'          => 'en deus adanvet $1 e "$2"',
	'renameuser-log'              => 'Ssavet gantañ $1 degasadenn. $2',
	'renameuser-move-log'         => 'Pajenn dilec\'hiet ent emgefreek e-ser adenvel an implijer "[[User:$1|$1]]" e "[[User:$2|$2]]"',
);

/** Catalan (Català)
 * @author Toniher
 * @author SMP
 * @author Juanpabl
 * @author Paucabot
 */
$messages['ca'] = array(
	'renameuser'                  => "Reanomena l'usuari",
	'renameuser-desc'             => "Reanomena un usuari (necessita drets de ''renameuser'')",
	'renameuserold'               => "Nom d'usuari actual:",
	'renameusernew'               => "Nou nom d'usuari:",
	'renameuserreason'            => 'Motiu pel canvi:',
	'renameusermove'              => "Reanomena la pàgina d'usuari, la de discussió i les subpàgines que tingui al nou nom",
	'renameusersubmit'            => 'Tramet',
	'renameusererrordoesnotexist' => "L'usuari «<nowiki>$1</nowiki>» no existeix",
	'renameusererrorexists'       => "L'usuari «<nowiki>$1</nowiki>» ja existeix",
	'renameusererrorinvalid'      => "El nom d'usuari «<nowiki>$1</nowiki>» no és vàlid",
	'renameusererrortoomany'      => "L'usuari «<nowiki>$1</nowiki>» té $2 contribucions. Canviar el nom a un usuari amb més de $3 contribucions pot causar problemes",
	'renameuser-error-same-user'  => 'No podeu reanomenar un usuari a un nom que ja tenia anteriorment.',
	'renameusersuccess'           => "L'usuari «<nowiki>$1</nowiki>» s'ha reanomenat com a «<nowiki>$2</nowiki>»",
	'renameuser-page-exists'      => 'La pàgina «$1» ja existeix i no pot ser sobreescrita automàticament',
	'renameuser-page-moved'       => "La pàgina «$1» s'ha reanomenat com a «$2».",
	'renameuser-page-unmoved'     => "La pàgina $1 no s'ha pogut reanomenar com a «$2».",
	'renameuserlogpage'           => "Registre del canvi de nom d'usuari",
	'renameuserlogpagetext'       => "Aquest és un registre dels canvis als noms d'usuari",
	'renameuserlogentry'          => 'ha canviat el nom de $1 a «$2»',
	'renameuser-log'              => '{{PLURAL:$1|Una contribució|$1 contribucions}}. Motiu: $2',
	'renameuser-move-log'         => "S'ha reanomenat automàticament la pàgina mentre es reanomenava l'usuari «[[User:$1|$1]]» com «[[User:$2|$2]]»",
	'right-renameuser'            => 'Reanomena els usuaris',
);

/** Chechen (Нохчийн)
 * @author SPQRobin
 */
$messages['ce'] = array(
	'renameuser' => 'Юзер цIе хийца',
);

/** Crimean Turkish (Latin) (Qırımtatarca (Latin))
 * @author Alessandro
 */
$messages['crh-latn'] = array(
	'renameuserlogpage'     => 'Qullanıcı adı deñişikligi jurnalı',
	'renameuserlogpagetext' => 'Aşağıda bulunğan cedvel adı deñiştirilgen qullanıcılarnı köstere',
	'renameuserlogentry'    => '$1 adını deñiştirdi, yañı ad: "$2"',
	'renameuser-log'        => '{{PLURAL:$1|1 deñişiklik|$1 deñişiklik}} yapqan. Sebep: $2',
);

/** Crimean Turkish (Cyrillic) (Qırımtatarca (Cyrillic))
 * @author Alessandro
 */
$messages['crh-cyrl'] = array(
	'renameuserlogpage'     => 'Къулланыджы ады денъишиклиги журналы',
	'renameuserlogpagetext' => 'Ашагъыда булунгъан джедвель ады денъиштирильген къулланыджыларны косьтере',
	'renameuserlogentry'    => '$1 адыны денъиштирди, янъы ад: "$2"',
	'renameuser-log'        => '{{PLURAL:$1|1 денъишиклик|$1 денъишиклик}} япкъан. Себеп: $2',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Martin Kozák
 * @author Danny B.
 * @author Siebrand
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'renameuser'                  => 'Přejmenovat uživatele',
	'renameuser-desc'             => "Přejmenování uživatele (vyžadováno oprávnění ''renameuser'')",
	'renameuserold'               => 'Stávající uživatelské jméno:',
	'renameusernew'               => 'Nové uživatelské jméno:',
	'renameuserreason'            => 'Důvod přejmenování:',
	'renameusermove'              => 'Přesunout uživatelské a diskusní stránky (a jejich podstránky) na nové jméno',
	'renameuserwarnings'          => 'Upozornění:',
	'renameuserconfirm'           => 'Ano, přejmenovat uživatele',
	'renameusersubmit'            => 'Přejmenovat',
	'renameusererrordoesnotexist' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ neexistuje',
	'renameusererrorexists'       => 'Uživatel se jménem „<nowiki>$1</nowiki>“ již existuje',
	'renameusererrorinvalid'      => 'Uživatelské jméno „<nowiki>$1</nowiki>“ nelze použít',
	'renameusererrortoomany'      => "Uživatel „<nowiki>$1</nowiki>“ má $2 příspěvků, přejmenování uživatelů s více než $3 příspěvky je zakázáno, neboť by příliš zatěžovalo systém.'",
	'renameuser-error-request'    => 'Při přijímání požadavku došlo k chybě. Vraťte se a zkuste to znovu.',
	'renameuser-error-same-user'  => 'Nové uživatelské jméno je stejné jako dosavadní.',
	'renameusersuccess'           => 'Uživatel „<nowiki>$1</nowiki>“ byl úspěšně přejmenován na „<nowiki>$2</nowiki>“',
	'renameuser-page-exists'      => 'Stránka $1 již existuje a nelze ji automaticky přepsat.',
	'renameuser-page-moved'       => 'Stránka $1 byla přesunuta na $2.',
	'renameuser-page-unmoved'     => 'Stránku $1 se nepodařilo přesunout na $2.',
	'renameuserlogpage'           => 'Kniha přejmenování uživatelů',
	'renameuserlogpagetext'       => 'Toto je záznam přejmenování uživatelů (změn uživatelského jména).',
	'renameuserlogentry'          => 'přejmenovává $1 na "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 editace|$1 editace|$1 editací}}. Zdůvodnění: $2',
	'renameuser-move-log'         => 'Automatický přesun při přejmenování uživatele „[[User:$1|$1]]“ na „[[User:$2|$2]]“',
	'right-renameuser'            => 'Přejmenovávání uživatelů',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author Svetko
 */
$messages['cu'] = array(
	'renameuser'                  => 'Прѣименѹи польѕевател҄ь',
	'renameuserold'               => 'Нынѣщьнѥѥ имѧ:',
	'renameusernew'               => 'Ново имѧ:',
	'renameuserreason'            => 'Какъ съмыслъ:',
	'renameusermove'              => 'Нарьци тако польѕевател страницѫ, бесѣдѫ и ихъ подъстраницѧ',
	'renameusersubmit'            => 'Еи',
	'renameusererrordoesnotexist' => 'Польѕевател «<nowiki>$1</nowiki>» нѣстъ',
	'renameusererrorexists'       => 'Польѕевател҄ь «<nowiki>$1</nowiki>» ѥстъ ю',
	'renameusererrorinvalid'      => 'Имѧ «<nowiki>$1</nowiki>» нѣстъ годѣ',
	'renameusererrortoomany'      => 'Польѕевател҄ь «<nowiki>$1</nowiki>» $2 {{PLURAL:$2|исправлѥниѥ|исправлѥнии|исправлѥни|исправлѥнии}} сътворилъ ѥстъ. Аще польѕевател прѣименѹѥши кыи болѥ $3 {{PLURAL:$3|исправлѥниѥ|исправлѥнии|исправлѥни|исправлѥнии}} сътворилъ ѥстъ, то зълѣ бѫдетъ.',
	'renameuserlogentry'          => 'нарече $1 именьмь "$2"',
);

/** German (Deutsch)
 */
$messages['de'] = array(
	'renameuser'                  => 'Benutzer umbenennen',
	'renameuser-desc'             => "Umbenennen eines Benutzers (erfordert das ''renameuser''-Recht)",
	'renameuserold'               => 'Bisheriger Benutzername:',
	'renameusernew'               => 'Neuer Benutzername:',
	'renameuserreason'            => 'Grund:',
	'renameusermove'              => 'Verschiebe Benutzer-/Diskussionsseite inkl. Unterseiten auf den neuen Benutzernamen',
	'renameuserwarnings'          => 'Warnungen:',
	'renameuserconfirm'           => 'Ja, Benutzer umbenennen',
	'renameusersubmit'            => 'Umbenennen',
	'renameusererrordoesnotexist' => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert nicht.',
	'renameusererrorexists'       => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert bereits.',
	'renameusererrorinvalid'      => 'Der Benutzername „<nowiki>$1</nowiki>“ ist ungültig.',
	'renameusererrortoomany'      => 'Der Benutzer „<nowiki>$1</nowiki>“ hat $2 Bearbeitungen. Die Namensänderung eines Benutzers mit mehr als $3 Bearbeitungen kann die Serverleistung nachteilig beeinflussen.',
	'renameuser-error-request'    => 'Es gab ein Problem beim Empfang der Anfrage. Bitte nochmal versuchen.',
	'renameuser-error-same-user'  => 'Alter und neuer Benutzername sind identisch.',
	'renameusersuccess'           => 'Der Benutzer „<nowiki>$1</nowiki>“ wurde erfolgreich in „<nowiki>$2</nowiki>“ umbenannt.',
	'renameuser-page-exists'      => 'Die Seite $1 existiert bereits und kann nicht automatisch überschrieben werden.',
	'renameuser-page-moved'       => 'Die Seite $1 wurde nach $2 verschoben.',
	'renameuser-page-unmoved'     => 'Die Seite $1 konnte nicht nach $2 verschoben werden.',
	'renameuserlogpage'           => 'Benutzernamenänderungs-Logbuch',
	'renameuserlogpagetext'       => 'In diesem Logbuch werden die Änderungen von Benutzernamen protokolliert.',
	'renameuserlogentry'          => 'hat „$1“ in „$2“ umbenannt',
	'renameuser-log'              => '{{PLURAL:$1|1 Bearbeitung|$1 Bearbeitungen}}. Grund: $2',
	'renameuser-move-log'         => 'durch die Umbenennung von „[[User:$1|$1]]“ nach „[[User:$2|$2]]“ automatisch verschobene Seite',
	'right-renameuser'            => 'Benutzer umbenennen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'renameuser'                  => 'Wužywarja pśemjeniś',
	'renameuser-desc'             => "Wužywarja pśemjeniś (pomina se pšawo ''renameuser'')",
	'renameuserold'               => 'Aktualne wužywarske mě:',
	'renameusernew'               => 'Nowe wužywarske mě:',
	'renameuserreason'            => 'Pśicyna za pśemjenjenje',
	'renameusermove'              => 'Wužywarski a diskusijny bok (a jich pódboki) do nowego mjenja pśesunuś',
	'renameuserwarnings'          => 'Warnowanja:',
	'renameuserconfirm'           => 'Jo, wužywarja pśemjeniś',
	'renameusersubmit'            => 'Pśemjeniś',
	'renameusererrordoesnotexist' => 'Wužywaŕ "<nowiki>$1</nowiki>" njeeksistujo.',
	'renameusererrorexists'       => 'Wužywaŕ "<nowiki>$1</nowiki>" južo eksistujo.',
	'renameusererrorinvalid'      => 'Wužywarske mě "<nowiki>$1</nowiki>" jo njepłaśiwe.',
	'renameusererrortoomany'      => 'Wužywaŕ "<nowiki>$1</nowiki>" ma $2 {{PLURAL:$2|pśinosk|pśinoska|pśinoski|pśinoskow}}. Pśemjenjenje wužywarja z wěcej nježli $3 {{PLURAL:$3|pśinoskom|pśinoskoma|pśinoskami|pśinoskami}} móžo wugbałosć serwera na škódu wobwliwowaś',
	'renameuser-error-request'    => 'Problem jo pśi dostawanju napšašanja wustupił.
Źi pšosym slědk a wopytaj hyšći raz.',
	'renameuser-error-same-user'  => 'Njamóžoš wužywarja do togo samogo mjenja pśemjeniś',
	'renameusersuccess'           => 'Wužywaŕ "<nowiki>$1</nowiki>" jo se do "<nowiki>$2</nowiki>" pśemjenił.',
	'renameuser-page-exists'      => 'Bok $1 južo eksistujo a njedajo se awtomatiski pśepisaś.',
	'renameuser-page-moved'       => 'Bok $1 jo se do $2 pśesunuł.',
	'renameuser-page-unmoved'     => 'Bok $1 njejo se do $2 pśesunuś dał.',
	'renameuserlogpage'           => 'Protokol wužywarskich pśemjenjenjow',
	'renameuserlogpagetext'       => 'Toś to jo protokol změnow na wužywarskich mjenjach.',
	'renameuserlogentry'          => 'jo $1 do "$2" pśemjenił',
	'renameuser-log'              => '{{PLURAL:&1|1 změna|$1 změnje|$1 změny|$1 změnow}}. Pśicyna: $2',
	'renameuser-move-log'         => 'Pśi pśemjenjowanju wužywarja "[[User:$1|$1]]" do "[[User:$2|$2]]" awtomatiski pśesunjony bok',
	'right-renameuser'            => 'Wužywarjow pśemjeniś',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 * @author Badseed
 * @author Consta
 * @author MF-Warburg
 * @author Siebrand
 */
$messages['el'] = array(
	'renameuser'                  => 'Μετονομασία χρήστη',
	'renameuserold'               => 'Τρέχον όνομα χρήστη:',
	'renameusernew'               => 'Νέο όνομα χρήστη:',
	'renameuserreason'            => 'Λόγος μετονομασίας:',
	'renameusermove'              => 'Μετακίνηση της σελίδας χρήστη και της σελίδας συζήτησης χρήστη (και των υποσελίδων τους) στο καινούργιο όνομα',
	'renameuserwarnings'          => 'Προειδοποιήσεις:',
	'renameusersubmit'            => 'Καταχώριση',
	'renameusererrordoesnotexist' => 'Ο χρήστης "<nowiki>$1</nowiki>" δεν υπάρχει',
	'renameusererrorexists'       => 'Ο χρήστης "<nowiki>$1</nowiki>" υπάρχει ήδη.',
	'renameusererrorinvalid'      => 'Το όνομα χρήστη "<nowiki>$1</nowiki>" είναι άκυρο.',
	'renameuser-error-request'    => 'Υπήρξε ένα πρόβλημα στην παραλαβή της αίτησης. Παρακαλούμε επιστρέψτε και ξαναδοκιμάστε.',
	'renameuser-error-same-user'  => 'Δεν μπορείτε να μετονομάσετε έναν χρήστη σε όνομα ίδιο με το προηγούμενο.',
	'renameuser-page-exists'      => 'Η σελίδα $1 υπάρχει ήδη και δεν μπορεί να αντικατασταθεί αυτόματα.',
	'renameuser-page-moved'       => 'Η σελίδα $1 μετακινήθηκε στο $2.',
	'renameuser-page-unmoved'     => 'Η σελίδα $1 δεν μπόρεσε να μετακινηθεί στο $2.',
	'renameuserlogpage'           => 'Αρχείο μετονομασίας χρηστών',
	'renameuserlogpagetext'       => 'Αυτό είναι ένα αρχείο καταγραφών αλλαγών σε ονόματα χρηστών',
	'renameuserlogentry'          => '$1 μετονομάστηκε σε "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 επεξεργασία|$1 επεξεργασίες}}. Λόγος: $2',
	'renameuser-move-log'         => 'Η σελίδα μετακινήθηκε αυτόματα κατά τη μετονομασία του χρήστη "[[User:$1|$1]]" σε "[[User:$2|$2]]"',
);

/** Esperanto (Esperanto)
 * @author Tlustulimu
 * @author Yekrats
 * @author Siebrand
 */
$messages['eo'] = array(
	'renameuser'                  => 'Alinomigu uzanton',
	'renameuser-desc'             => "Alinomigu uzanton (bezonas rajton ''renameuser'')",
	'renameuserold'               => 'Aktuala uzantonomo:',
	'renameusernew'               => 'Nova uzantonomo:',
	'renameuserreason'            => 'Kialo por alinomigo:',
	'renameusermove'              => 'Movu uzantan kaj diskutan paĝojn (kaj ties subpaĝojn) al la nova nomo',
	'renameuserwarnings'          => 'Avertoj:',
	'renameuserconfirm'           => 'Jes, renomigu la uzanton',
	'renameusersubmit'            => 'Ek',
	'renameusererrordoesnotexist' => 'La uzanto "<nowiki>$1</nowiki>" ne ekzistas',
	'renameusererrorexists'       => 'La uzanto "<nowiki>$1</nowiki>" jam ekzistas',
	'renameusererrorinvalid'      => 'La uzantonomo "<nowiki>$1</nowiki>" estas malvalida',
	'renameusererrortoomany'      => 'La uzanto "<nowiki>$1</nowiki>" havas $2 kontribuojn. Alinamigo de uzanto kun pli ol $3 kontribuoj povus malbone influi paĝaran funkciadon',
	'renameuser-error-request'    => 'Estis problemo recivante la peton.
Bonvolu retroigi kaj reprovi.',
	'renameuser-error-same-user'  => 'Vi ne povas alinomigi uzanton al la sama nomo.',
	'renameusersuccess'           => 'La uzanto "<nowiki>$1</nowiki>" estas alinomita al "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'La paĝo $1 jam ekzistas kaj ne povas esti aŭtomate anstataŭata.',
	'renameuser-page-moved'       => 'La paĝo $1 estis movita al $2.',
	'renameuser-page-unmoved'     => 'La paĝo $1 ne povis esti movita al $2.',
	'renameuserlogpage'           => 'Protokolo pri alinomigoj de uzantoj',
	'renameuserlogpagetext'       => 'Ĉi tio estas protokolo pri ŝanĝoj de uzantonomoj',
	'renameuserlogentry'          => 'estas renomigita $1 al "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 redakto|$1 redaktoj}}. Kialo: $2',
	'renameuser-move-log'         => 'Aŭtomate movis paĝon dum alinomigo de la uzanto "[[User:$1|$1]]" al "[[User:$2|$2]]"',
	'right-renameuser'            => 'Alinomu uzantojn',
);

/** Spanish (Español)
 * @author Icvav
 * @author Jatrobat
 * @author Siebrand
 * @author Spacebirdy
 * @author Alhen
 * @author Lin linao
 */
$messages['es'] = array(
	'renameuser'                  => 'Renombrar usuario',
	'renameuserold'               => 'Nombre actual:',
	'renameusernew'               => 'Nuevo nombre de usuario:',
	'renameuserreason'            => 'Motivo:',
	'renameusermove'              => 'Trasladar las páginas de usuario y de discusión (y sus subpáginas) al nuevo nombre',
	'renameusersubmit'            => 'Enviar',
	'renameusererrordoesnotexist' => 'El usuario «<nowiki>$1</nowiki>» no existe',
	'renameusererrorexists'       => 'El usuario «<nowiki>$1</nowiki>» ya existe',
	'renameusererrorinvalid'      => 'El nombre de usuario «<nowiki>$1</nowiki>» no es válido',
	'renameusererrortoomany'      => 'El usuario «<nowiki>$1</nowiki>» tiene $2 contribuciones, cambiar el nombre de un usuario con más de $3 contribuciones podría afectar notablemente al rendimiento del sitio',
	'renameuser-error-same-user'  => 'No puedes renombrar a un usuario con el nombre que ya tenía.',
	'renameusersuccess'           => 'El usuario «<nowiki>$1</nowiki>» ha sido renombrado a «<nowiki>$2</nowiki>»',
	'renameuser-page-exists'      => 'La página $1 ya existe y no puede ser reemplazada automáticamente.',
	'renameuser-page-moved'       => 'La página $1 ha sido trasladada a $2.',
	'renameuser-page-unmoved'     => 'La página $1 no pudo ser trasladada a $2.',
	'renameuserlogpage'           => 'Registro de cambios de nombre de usuarios',
	'renameuserlogpagetext'       => 'Este es un registro de cambios de nombres de usuarios',
	'renameuserlogentry'          => 'ha renombrado a $1 a "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivo: $2',
	'renameuser-move-log'         => 'Página trasladada automáticamente al renombrar al usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
);

/** Estonian (Eesti)
 * @author WikedKentaur
 * @author SPQRobin
 */
$messages['et'] = array(
	'renameuser'        => 'Muuda kasutajanime',
	'renameuserold'     => 'Praegune kasutajanimi:',
	'renameusernew'     => 'Uus kasutajanimi:',
	'renameuserreason'  => 'Muutmise põhjus:',
	'renameusermove'    => 'Nimeta ümber kasutajaleht, aruteluleht ja nende alamlehed.',
	'renameusersubmit'  => 'Muuda',
	'renameuserlogpage' => 'Kasutajanime muutmise logi',
);

/** Basque (Euskara)
 * @author SPQRobin
 */
$messages['eu'] = array(
	'renameuser'              => 'Lankide bati izena aldatu',
	'renameuserold'           => 'Oraingo lankide izena:',
	'renameusernew'           => 'Lankide izen berria:',
	'renameuserreason'        => 'Izena aldatzeko arrazoia:',
	'renameusersubmit'        => 'Bidali',
	'renameusererrorexists'   => '"<nowiki>$1</nowiki>" lankidea existitzen da',
	'renameusererrorinvalid'  => '"<nowiki>$1</nowiki>" lankide izena baliogabekoa da',
	'renameusererrortoomany'  => '"<nowiki>$1</nowiki>" lankideak $2 ekarpen ditu, $3 baino ekarpen gehiago dituen lankide baten izena aldatzeak gunearen errendimenduan eragin txarrak izan ditzake',
	'renameusersuccess'       => '"<nowiki>$1</nowiki>" lankidearen izen berria "<nowiki>$2</nowiki>" da',
	'renameuser-page-exists'  => 'Badago $1 orrialdea, eta ezin da automatikoki gainidatzi.',
	'renameuser-page-moved'   => '$1 orrialde $2(e)ra mugitu da.',
	'renameuser-page-unmoved' => 'Ezin izan da $1 orrialdea $2(e)ra mugitu.',
	'renameuserlogpage'       => 'Erabiltzaileen izen aldaketa erregistroa',
	'renameuserlogpagetext'   => 'Erabiltzaileen izen aldaketen erregistroa da hau',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'renameuser-page-moved' => 'S´á moviu la páhina $1 a $2.',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'renameuser'                  => 'تغییر نام کاربری',
	'renameuser-desc'             => "نام یک کاربر را تغییر می‌دهد (نیازمند برخورداری از اختیارات ''تغییرنام'' است)",
	'renameuserold'               => 'نام کاربری فعلی:',
	'renameusernew'               => 'نام کاربری جدید:',
	'renameuserreason'            => 'علت تغییر نام کاربری:',
	'renameusermove'              => 'صفحه کاربر و صفحه بحث کاربر (و زیر صفحه‌های آن‌ها) را به نام جدید انتقال بده',
	'renameusersubmit'            => 'ثبت',
	'renameusererrordoesnotexist' => 'نام کاربری «<nowiki>$1</nowiki>» وجود ندارد',
	'renameusererrorexists'       => 'نام کاربری «<nowiki>$1</nowiki>» استفاده شده‌است',
	'renameusererrorinvalid'      => 'نام کاربری «<nowiki>$1</nowiki>» غیر مجاز است',
	'renameusererrortoomany'      => 'کاربر «<nowiki>$1</nowiki>» دارای $2 مشارکت است؛ تغییر نام کاربران با بیش از $3 ویرایش ممکن است عملکرد وبگاه را دچار مشکل کند.',
	'renameuser-error-request'    => 'در دریافت درخواست مشکلی پیش آمد. لطفاً به صفحهٔ قبل بازگردید و دوباره تلاش کنید.',
	'renameuser-error-same-user'  => 'شما نمی‌توانید نام یک کاربر را به همان نام قبلی‌اش تغییر دهید.',
	'renameusersuccess'           => 'نام کاربر «<nowiki>$1</nowiki>» به «<nowiki>$2</nowiki>» تغییر یافت.',
	'renameuser-page-exists'      => 'صفحهٔ $1 از قبل وجود داشته و به طور خودکار قابل بازنویسی نیست.',
	'renameuser-page-moved'       => 'صفحهٔ $1 به $2 انتقال داده شد.',
	'renameuser-page-unmoved'     => 'امکان انتقال صفحهٔ $1 به $2 وجود ندارد.',
	'renameuserlogpage'           => 'سیاهه تغییر نام کاربر',
	'renameuserlogpagetext'       => 'این سیاههٔ تغییر نام کاربران است',
	'renameuserlogentry'          => 'نام $1 را به $2 تغییر داد',
	'renameuser-log'              => '{{PLURAL:$1|۱ ویرایش|$1 ویرایش}}. دلیل: $2',
	'renameuser-move-log'         => 'صفحه در ضمن تغییر نام «[[User:$1|$1]]» به «[[User:$2|$2]]» به طور خودکار انتقال داده شد.',
	'right-renameuser'            => 'تغییر نام کاربران',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Crt
 * @author Str4nd
 */
$messages['fi'] = array(
	'renameuser'                  => 'Käyttäjätunnuksen vaihto',
	'renameuser-desc'             => "Mahdollistaa käyttäjän uudelleennimeämisen (vaatii ''renameuser''-oikeudet).",
	'renameuserold'               => 'Nykyinen tunnus',
	'renameusernew'               => 'Uusi tunnus',
	'renameuserreason'            => 'Kommentti',
	'renameusermove'              => 'Siirrä käyttäjä- ja keskustelusivut alasivuineen uudelle nimelle',
	'renameuserwarnings'          => 'Varoitukset:',
	'renameuserconfirm'           => 'Kyllä, uudelleennimeä käyttäjä',
	'renameusersubmit'            => 'Nimeä',
	'renameusererrordoesnotexist' => 'Tunnusta ”<nowiki>$1</nowiki>” ei ole',
	'renameusererrorexists'       => 'Tunnus ”<nowiki>$1</nowiki>” on jo olemassa',
	'renameusererrorinvalid'      => 'Tunnus ”<nowiki>$1</nowiki>” ei ole kelvollinen',
	'renameusererrortoomany'      => 'Tunnuksella ”<nowiki>$1</nowiki>” on $2 muokkausta. Tunnuksen, jolla on yli $3 muokkausta, vaihtaminen voi haitata sivuston suorituskykyä.',
	'renameuser-error-request'    => 'Pyynnön vastaanottamisessa oli ongelma. Ole hyvä ja yritä uudelleen.',
	'renameuser-error-same-user'  => 'Et voi nimetä käyttäjää uudelleen samaksi kuin hän jo on.',
	'renameusersuccess'           => 'Käyttäjän ”<nowiki>$1</nowiki>” tunnus on nyt ”<nowiki>$2</nowiki>”.',
	'renameuser-page-exists'      => 'Sivu $1 on jo olemassa eikä sitä korvattu.',
	'renameuser-page-moved'       => 'Sivu $1 siirrettiin nimelle $2.',
	'renameuser-page-unmoved'     => 'Sivun $1 siirtäminen nimelle $2 ei onnistunut.',
	'renameuserlogpage'           => 'Tunnusten vaihdot',
	'renameuserlogpagetext'       => 'Tämä on loki käyttäjätunnuksien vaihdoista.',
	'renameuserlogentry'          => 'on nimennyt käyttäjän $1 käyttäjäksi ”$2”',
	'renameuser-log'              => 'Tehnyt {{PLURAL:$1|yhden muokkauksen|$1 muokkausta}}. $2',
	'renameuser-move-log'         => 'Siirretty automaattisesti tunnukselta ”[[User:$1|$1]]” tunnukselle ”[[User:$2|$2]]”',
	'right-renameuser'            => 'Nimetä käyttäjätunnuksia uudelleen',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'renameusernew' => 'Nýtt brúkaranavn:',
);

/** French (Français)
 * @author Siebrand
 * @author Urhixidur
 * @author Cedric31
 * @author IAlex
 * @author Grondin
 * @author Hégésippe Cormier
 */
$messages['fr'] = array(
	'renameuser'                  => 'Renommer l’utilisateur',
	'renameuser-desc'             => "Renomme un utilisateur (nécessite les droits de ''renameuser'')",
	'renameuserold'               => 'Nom actuel de l’utilisateur :',
	'renameusernew'               => 'Nouveau nom de l’utilisateur :',
	'renameuserreason'            => 'Motif du renommage :',
	'renameusermove'              => 'Déplacer toutes les pages de l’utilisateur vers le nouveau nom',
	'renameuserwarnings'          => 'Avertissements :',
	'renameuserconfirm'           => 'Oui, renommer l’utilisateur',
	'renameusersubmit'            => 'Soumettre',
	'renameusererrordoesnotexist' => 'L’utilisateur « <nowiki>$1</nowiki> » n’existe pas',
	'renameusererrorexists'       => 'L’utilisateur « <nowiki>$1</nowiki> » existe déjà',
	'renameusererrorinvalid'      => 'Le nom d’utilisateur « <nowiki>$1</nowiki> » n’est pas valide',
	'renameusererrortoomany'      => 'L’utilisateur « <nowiki>$1</nowiki> » a $2 contributions. Renommer un utilisateur ayant plus de $3 contributions à son actif peut momentanément affecter les performances du site.',
	'renameuser-error-request'    => 'Un problème existe avec la réception de la requête. Revenez en arrière et essayez à nouveau.',
	'renameuser-error-same-user'  => 'Vous ne pouvez pas renommer un utilisateur du même nom qu’auparavant.',
	'renameusersuccess'           => 'L’utilisateur « <nowiki>$1</nowiki> » a été renommé « <nowiki>$2</nowiki> »',
	'renameuser-page-exists'      => 'La page $1 existe déjà et ne peut pas être automatiquement remplacée.',
	'renameuser-page-moved'       => 'La page $1 a été déplacée vers $2.',
	'renameuser-page-unmoved'     => 'La page $1 ne peut pas être renommée en $2.',
	'renameuserlogpage'           => 'Historique des renommages d’utilisateur',
	'renameuserlogpagetext'       => "Ceci est l’historique des changements de noms d'utilisateur",
	'renameuserlogentry'          => 'a renommé $1 vers « $2 »',
	'renameuser-log'              => '$1 {{PLURAL:$1|édition|éditions}}. Motif : $2',
	'renameuser-move-log'         => 'Page automatiquement déplacée lors du renommage de l’utilisateur "[[User:$1|$1]]" en "[[User:$2|$2]]"',
	'right-renameuser'            => 'Renommer des utilisateurs',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'renameuser'                  => 'Renomar l’utilisator',
	'renameuser-desc'             => "Renome un utilisator (at fôta des drêts de ''renameuser'').",
	'renameuserold'               => 'Nom d’ora de l’utilisator :',
	'renameusernew'               => 'Novél nom de l’utilisator :',
	'renameuserreason'            => 'Rêson du renomâjo :',
	'renameusermove'              => 'Dèplaciér totes les pâges de l’utilisator vers lo novél nom',
	'renameusersubmit'            => 'Sometre',
	'renameusererrordoesnotexist' => 'L’utilisator « <nowiki>$1</nowiki> » ègziste pas.',
	'renameusererrorexists'       => 'L’utilisator « <nowiki>$1</nowiki> » ègziste ja.',
	'renameusererrorinvalid'      => 'Lo nom d’utilisator « <nowiki>$1</nowiki> » est envalido.',
	'renameusererrortoomany'      => 'L’utilisator « <nowiki>$1</nowiki> » at $2 contribucions. Renomar un utilisator povent sè prèvalêr de més de $3 contribucions pôt afèctar les pèrformences du seto.',
	'renameuser-error-request'    => 'Un problèmo ègziste avouéc la rècèpcion de la requéta. Tornâd arriér et pués tornâd èprovar.',
	'renameuser-error-same-user'  => 'Vos pouede pas renomar un utilisator avouéc la méma chousa dês devant.',
	'renameusersuccess'           => 'L’utilisator « <nowiki>$1</nowiki> » at étâ renomâ en « <nowiki>$2</nowiki> ».',
	'renameuser-page-exists'      => 'La pâge $1 ègziste ja et pôt pas étre ôtomaticament remplaciê.',
	'renameuser-page-moved'       => 'La pâge $1 at étâ dèplaciê vers $2.',
	'renameuser-page-unmoved'     => 'La pâge $1 pôt pas étre renomâ en $2.',
	'renameuserlogpage'           => 'Historico des renomâjos d’utilisator',
	'renameuserlogpagetext'       => 'Cen est l’historico des changements de noms d’utilisator.',
	'renameuserlogentry'          => 'at renomâ $1 en "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 èdicion|$1 èdicions}}. Rêson : $2',
	'renameuser-move-log'         => 'Pâge ôtomaticament dèplaciê pendent lo renomâjo de l’utilisator « [[User:$1|$1]] » en « [[User:$2|$2]] »',
);

/** Irish (Gaeilge)
 * @author SPQRobin
 */
$messages['ga'] = array(
	'renameuser'             => 'Athainmnigh úsáideoir',
	'renameuserold'          => 'Ainm reatha úsáideora:',
	'renameusernew'          => 'Ainm nua úsáideora:',
	'renameusersuccess'      => 'Athainmníodh úsáideoir "<nowiki>$1</nowiki>" mar "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Tá leathanach "$1" ann chean féin; ní féidir ábhar a scríobh thairis go huathoibríoch.',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Prevert
 */
$messages['gl'] = array(
	'renameuser'                  => 'Mudar o nome de usuario',
	'renameuser-desc'             => "Renomear un usuario (precisa dereito de ''renomear usuarios'')",
	'renameuserold'               => 'Nome de usuario actual:',
	'renameusernew'               => 'Novo nome de usuario:',
	'renameuserreason'            => 'Razón para mudar o nome:',
	'renameusermove'              => 'Mover usuario e páxinas de talk (e as súas subpáxinas) a un novo nome',
	'renameuserwarnings'          => 'Avisos:',
	'renameuserconfirm'           => 'Si, renomear este usuario',
	'renameusersubmit'            => 'Enviar',
	'renameusererrordoesnotexist' => 'O usuario "<nowiki>$1</nowiki>" non existe',
	'renameusererrorexists'       => 'O usuario "<nowiki>$1</nowiki>"  xa existe',
	'renameusererrorinvalid'      => 'O nome de usuario "<nowiki>$1</nowiki>" non é válido',
	'renameusererrortoomany'      => 'O usuario "<nowiki>$1</nowiki>" ten $2 contribucións, mudando o nome dun usuario con máis de $3 contribucións podería afectar negativamente á execución do sitio',
	'renameuser-error-request'    => 'Houbo un problema coa recepción da solitidude. Volte atrás e ténteo de novo.',
	'renameuser-error-same-user'  => 'Non pode renomear a un usuario ao mesmo nome que tiña antes.',
	'renameusersuccess'           => 'O usuario "<nowiki>$1</nowiki>" mudou o nome a "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'A páxina $1 xa existe e non pode ser automaticamente sobreescrita.',
	'renameuser-page-moved'       => 'A páxina $1 foi movida a $2.',
	'renameuser-page-unmoved'     => 'A páxina $1 non pode ser movida a $2.',
	'renameuserlogpage'           => 'Rexistro de usuarios que mudaron o nome',
	'renameuserlogpagetext'       => 'Este é un rexistro dos cambios dos nomes de usuarios',
	'renameuserlogentry'          => 'mudou o nome de "$1" a "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 edición|$1 edicións}}. Razón: $2',
	'renameuser-move-log'         => 'A páxina moveuse automaticamente cando se mudou o nome do usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser'            => 'Renomear usuarios',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'renameuser'                  => 'שינוי שם משתמש',
	'renameuser-desc'             => 'הוספת [[Special:Renameuser|דף מיוחד]] לשינוי שם משתמש (דרושה הרשאת "renameuser)',
	'renameuserold'               => 'שם משתמש נוכחי:',
	'renameusernew'               => 'שם משתמש חדש:',
	'renameuserreason'            => 'סיבה לשינוי השם:',
	'renameusermove'              => 'העברת דפי המשתמש והשיחה (כולל דפי המשנה שלהם) לשם החדש',
	'renameuserwarnings'          => 'אזהרות:',
	'renameuserconfirm'           => 'כן, שנה את שם המשתמש',
	'renameusersubmit'            => 'שינוי שם משתמש',
	'renameusererrordoesnotexist' => 'המשתמש "<nowiki>$1</nowiki>" אינו קיים.',
	'renameusererrorexists'       => 'המשתמש "<nowiki>$1</nowiki>" כבר קיים.',
	'renameusererrorinvalid'      => 'שם המשתמש "<nowiki>$1</nowiki>" אינו תקין.',
	'renameusererrortoomany'      => 'למשתמש "<nowiki>$1</nowiki>" יש $2 תרומות; שינוי שם משתמש של משתמש עם יותר מ־$3 תרומות עלול להשפיע לרעה על ביצועי האתר.',
	'renameuser-error-request'    => 'הייתה בעיה בקבלת הבקשה. אנא חזרו לדף הקודם ונסו שנית.',
	'renameuser-error-same-user'  => 'אינכם יכולים לשנות את שם המשתמש לשם זהה לשמו הישן.',
	'renameusersuccess'           => 'שם המשתמש של "<nowiki>$1</nowiki>" שונה ל"<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'הדף $1 כבר קיים ולא ניתן לדרוס אותו אוטומטית.',
	'renameuser-page-moved'       => 'הדף $1 הועבר ל$2.',
	'renameuser-page-unmoved'     => 'לא ניתן היה להעביר את הדף $1 ל$2.',
	'renameuserlogpage'           => 'יומן שינויי שמות משתמש',
	'renameuserlogpagetext'       => 'זהו יומן השינויים בשמות המשתמשים.',
	'renameuserlogentry'          => 'שינה את שם המשתמש "$1" ל-"$2"',
	'renameuser-log'              => '{{PLURAL:$1|עריכה אחת|$1 עריכות}}. סיבה: $2',
	'renameuser-move-log'         => 'העברה אוטומטית בעקבות שינוי שם המשתמש "[[User:$1|$1]]" ל-"[[User:$2|$2]]"',
	'right-renameuser'            => 'שינוי שמות משתמש',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'renameuser'                  => 'सदस्यनाम बदलें',
	'renameuser-desc'             => "सदस्यनाम बदलें (''सदस्यनाम बदलने अधिकार'' अनिवार्य)",
	'renameuserold'               => 'सद्य सदस्यनाम:',
	'renameusernew'               => 'नया सदस्यनाम:',
	'renameuserreason'            => 'नाम बदलने के कारण:',
	'renameusermove'              => 'सदस्य पृष्ठ और वार्ता पृष्ठ (और उनके सबपेज) नये नाम की ओर भेजें',
	'renameusersubmit'            => 'भेजें',
	'renameusererrordoesnotexist' => 'सदस्य "<nowiki>$1</nowiki>" अस्तित्वमें नहीं हैं।',
	'renameusererrorexists'       => 'सदस्य "<nowiki>$1</nowiki>" पहले से अस्तित्वमें हैं।',
	'renameusererrorinvalid'      => 'सदस्यनाम "<nowiki>$1</nowiki>" गलत हैं।',
	'renameusererrortoomany'      => 'सदस्य "<nowiki>$1</nowiki>" ने $2 बदलाव किये हैं, $3 से ज्यादा बदलाव किये हुए सदस्यका नाम बदलने से साईटमें समस्या निर्माण हो सकती हैं।',
	'renameuser-error-request'    => 'यह मांग पूरी करने मे समस्या आई हैं।
कृपया पीछे जाकर फिरसे यत्न करें।',
	'renameuser-error-same-user'  => 'आप सदस्यनाम को उसी नामसे बदल नहीं सकते हैं।',
	'renameusersuccess'           => '"<nowiki>$1</nowiki>" का सदस्यनाम "<nowiki>$2</nowiki>" कर दिया गया हैं।',
	'renameuser-page-exists'      => '$1 यह पन्ना पहले से अस्तित्वमें हैं और इसपर अपने आप पुनर्लेखन नहीं कर सकतें।',
	'renameuser-page-moved'       => '$1 का नाम बदलकर $2 कर दिया गया हैं।',
	'renameuser-page-unmoved'     => '$1 का नाम बदलकर $2 नहीं कर सकें हैं।',
	'renameuserlogpage'           => 'सदस्यनाम बदलाव सूची',
	'renameuserlogpagetext'       => 'यह सदस्यनामोंमें हुए बदलावोंकी सूची हैं',
	'renameuserlogentry'          => 'ने $1 को "$2" में बदल दिया हैं',
	'renameuser-log'              => '{{PLURAL:$1|1 बदलाव|$1 बदलाव}}. कारण: $2',
	'renameuser-move-log'         => '"[[User:$1|$1]]" को "[[User:$2|$2]]" करते वक्त अपने आप सदस्यपृष्ठ बदल दिया हैं',
	'right-renameuser'            => 'सदस्योंके नाम बदलें',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 * @author Dnik
 * @author Suradnik13
 * @author Siebrand
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'renameuser'                  => 'Promijeni ime suradnika',
	'renameuser-desc'             => "Preimenuj suradnika (potrebna su ''renameuser'' prava)",
	'renameuserold'               => 'Trenutno suradničko ime:',
	'renameusernew'               => 'Novo suradničko ime:',
	'renameuserreason'            => 'Razlog za promjenu imena:',
	'renameusermove'              => 'Premjesti suradnikove stranice (glavnu, stranicu za razgovor i podstranice, ako postoje) na novo ime',
	'renameuserwarnings'          => 'Upozorenja:',
	'renameuserconfirm'           => 'Da, preimenuj suradnika',
	'renameusersubmit'            => 'Potvrdi',
	'renameusererrordoesnotexist' => 'Suradnik "<nowiki>$1</nowiki>" ne postoji (suradničko ime nije zauzeto).',
	'renameusererrorexists'       => 'Suradničko ime "<nowiki>$1</nowiki>" već postoji',
	'renameusererrorinvalid'      => 'Suradničko ime "<nowiki>$1</nowiki>" nije valjano',
	'renameusererrortoomany'      => 'Suradnik "<nowiki>$1</nowiki>" ima $2 uređivanja, preimenovanje suradnika s više od $3 uređivanja moglo bi usporiti ovaj wiki',
	'renameuser-error-request'    => 'Pojavio se problem sa zaprimanjem zahtjeva. Molimo, vratite se i probajte ponovo.',
	'renameuser-error-same-user'  => 'Ne možete promijeniti ime suradnika u isto kao prethodno.',
	'renameusersuccess'           => 'Suradnik "<nowiki>$1</nowiki>" je preimenovan u "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Stranica $1 već postoji i ne može biti prepisana.',
	'renameuser-page-moved'       => 'Suradnikova stranica $1 je premještena, sad se zove: $2.',
	'renameuser-page-unmoved'     => 'Stranica $1 ne može biti preimenovana u $2.',
	'renameuserlogpage'           => 'Evidencija preimenovanja suradnika',
	'renameuserlogpagetext'       => 'Ovo je evidencija promjena suradničkih imena',
	'renameuserlogentry'          => 'je promijenio suradničko ime $1 u "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 uređivanje|$1 uređivanja}}. Razlog: $2',
	'renameuser-move-log'         => 'Stranica suradnika je premještena prilikom promjena imena iz "[[User:$1|$1]]" u "[[User:$2|$2]]"',
	'right-renameuser'            => 'Preimenuj suradnike',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 * @author Siebrand
 */
$messages['hsb'] = array(
	'renameuser'                  => 'Wužiwarja přemjenować',
	'renameuser-desc'             => "Wužiwarja přemjenować (požada prawo ''renameuser'')",
	'renameuserold'               => 'Tuchwilne wužiwarske mjeno:',
	'renameusernew'               => 'Nowe wužiwarske mjeno:',
	'renameuserreason'            => 'Přičina za přemjenowanje:',
	'renameusermove'              => 'Wužiwarsku stronu a wužiwarsku diskusiju (a jeju podstrony) na nowe mjeno přesunyć',
	'renameuserwarnings'          => 'Warnowanja:',
	'renameuserconfirm'           => 'Haj, wužiwarja přemjenować',
	'renameusersubmit'            => 'Składować',
	'renameusererrordoesnotexist' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeeksistuje.',
	'renameusererrorexists'       => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ hižo eksistuje.',
	'renameusererrorinvalid'      => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeje płaćiwe.',
	'renameusererrortoomany'      => 'Wužiwar „<nowiki>$1</nowiki>“ je $2 wobdźěłanjow sčinił. Přemjenowanje wužiwarja z wjace hač $3 wobdźěłanjemi móže so njepřihódnje na wukonitosć serwera wuskutkować.',
	'renameuser-error-request'    => 'Problem je při přijimanju požadanja wustupił. Prošu dźi wróćo a spytaj hišće raz.',
	'renameuser-error-same-user'  => 'Njemóžeš wužiwarja do samsneje wěcy kaž prjedy přemjenować.',
	'renameusersuccess'           => 'Wužiwar „<nowiki>$1</nowiki>“ bu wuspěšnje na „<nowiki>$2</nowiki>“ přemjenowany.',
	'renameuser-page-exists'      => 'Strona $1 hižo eksistuje a njemóže so awtomatisce přepisować.',
	'renameuser-page-moved'       => 'Strona $1 bu pod nowy titul $2 přesunjena.',
	'renameuser-page-unmoved'     => 'Njemóžno stronu $1 pod titul $2 přesunyć.',
	'renameuserlogpage'           => 'Protokol přemjenowanja wužiwarjow',
	'renameuserlogpagetext'       => 'Tu protokoluja so wšě přemjenowanja wužiwarjow.',
	'renameuserlogentry'          => 'je $1 do "$2" přemjenował',
	'renameuser-log'              => 'z $1 wobdźěłanjemi. $2',
	'renameuser-move-log'         => 'Přez přemjenowanje wužiwarja „[[User:$1|$1]]“ na „[[User:$2|$2]]“ awtomatisce přesunjena strona.',
	'right-renameuser'            => 'Wužiwarjow přemjenować',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Siebrand
 */
$messages['hu'] = array(
	'renameuser'                  => 'Szerkesztő átnevezése',
	'renameuser-desc'             => "Lehetővé teszi egy felhasználó átnevezését (''renameuser'' jog szükséges)",
	'renameuserold'               => 'Jelenlegi felhasználónév:',
	'renameusernew'               => 'Új felhasználónév:',
	'renameuserreason'            => 'Átnevezés oka:',
	'renameusermove'              => 'Felhasználói- és vitalapok (és azok allapjainak) áthelyezése az új név alá',
	'renameuserconfirm'           => 'Igen, nevezd át a szerkesztőt',
	'renameusersubmit'            => 'Elküld',
	'renameusererrordoesnotexist' => 'Nem létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'renameusererrorexists'       => 'Már létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'renameusererrorinvalid'      => 'A felhasználónév („<nowiki>$1</nowiki>”) érvénytelen',
	'renameusererrortoomany'      => '„<nowiki>$1</nowiki>” szerkesztőnek $2 szerkesztése van, $3 szerkesztésnél többel rendelkező felhasználók átnevezése rossz hatással lehet az oldal működésére',
	'renameuser-error-request'    => 'Hiba történt a lekérdezés küldése közben.  Menj vissza az előző oldalra és próbáld újra.',
	'renameuser-error-same-user'  => 'Nem nevezhetsz át egy felhasználót a meglévő nevére.',
	'renameusersuccess'           => '„<nowiki>$1</nowiki>” sikeresen át lett nevezve „<nowiki>$2</nowiki>” névre.',
	'renameuser-page-exists'      => '$1 már létezik, és nem lehet automatikusan felülírni.',
	'renameuser-page-moved'       => '$1 át lett nevezve $2 névre',
	'renameuser-page-unmoved'     => '$1-t nem sikerült $2 névre nevezi',
	'renameuserlogpage'           => 'Felhasználóátnevezési-napló',
	'renameuserlogpagetext'       => 'Ez a felhasználói nevek változtatásának naplója.',
	'renameuserlogentry'          => 'átnevezte $1 azonosítóját (az új név: "$2")',
	'renameuser-log'              => '$1 szerkesztése van. Indoklás: $2',
	'renameuser-move-log'         => '„[[User:$1|$1]]” „[[User:$2|$2]]” névre való átnevezése közben automatikusan átnevezett oldal',
	'right-renameuser'            => 'felhasználók átnevezése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'renameuser'                  => 'Renominar usator',
	'renameuser-desc'             => "Adde un [[Special:Renameuser|pagina special]] pro renominar un usator (require le privilegio ''renameuser'')",
	'renameuserold'               => 'Nomine de usator actual:',
	'renameusernew'               => 'Nove nomine de usator:',
	'renameuserreason'            => 'Motivo del renomination:',
	'renameusermove'              => 'Renominar etiam le paginas de usator e de discussion (e lor subpaginas) verso le nove nomine',
	'renameuserwarnings'          => 'Advertimentos:',
	'renameuserconfirm'           => 'Si, renomina le usator',
	'renameusersubmit'            => 'Submitter',
	'renameusererrordoesnotexist' => 'Le usator "<nowiki>$1</nowiki>" non existe.',
	'renameusererrorexists'       => 'Le usator ""<nowiki>$1</nowiki>"" existe ja.',
	'renameusererrorinvalid'      => 'Le nomine de usator "<nowiki>$1</nowiki>" es invalide.',
	'renameusererrortoomany'      => 'Le usator "<nowiki>$1</nowiki>" ha $2 contributiones. Le renomination de un usator con plus de $3 contributiones poterea afficer negativemente le prestationes del sito.',
	'renameuser-error-request'    => 'Il habeva un problema con le reception del requesta.
Per favor retorna e reprova.',
	'renameuser-error-same-user'  => 'Tu non pote renominar un usator al mesme nomine.',
	'renameusersuccess'           => 'Le usator "<nowiki>$1</nowiki>" ha essite renominate a "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'Le pagina $1 existe ja e non pote esser automaticamente superscribite.',
	'renameuser-page-moved'       => 'Le pagina $1 ha essite renominate a $2.',
	'renameuser-page-unmoved'     => 'Le pagina $1 non poteva esser renominate a $2.',
	'renameuserlogpage'           => 'Registro de renominationes de usatores',
	'renameuserlogpagetext'       => 'Isto es un registro de cambiamentos de nomines de usator.',
	'renameuserlogentry'          => 'ha renominate $1 a "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 modification|$1 modificationes}}. Motivo: $2',
	'renameuser-move-log'         => 'Le pagina ha essite automaticamente renominate con le renomination del usator "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser'            => 'Renominar usatores',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'renameuser'                  => 'Penggantian nama pengguna',
	'renameuser-desc'             => "Mengganti nama pengguna (perlu hak akses ''renameuser'')",
	'renameuserold'               => 'Nama sekarang:',
	'renameusernew'               => 'Nama baru:',
	'renameuserreason'            => 'Alasan penggantian nama:',
	'renameusermove'              => 'Pindahkan halaman pengguna dan pembicaraannya (berikut subhalamannya) ke nama baru',
	'renameuserwarnings'          => 'Peringatan:',
	'renameuserconfirm'           => 'Ya, ganti nama pengguna tersebut',
	'renameusersubmit'            => 'Simpan',
	'renameusererrordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak ada',
	'renameusererrorexists'       => 'Pengguna "<nowiki>$1</nowiki>" telah ada',
	'renameusererrorinvalid'      => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah',
	'renameusererrortoomany'      => 'Pengguna "<nowiki>$1</nowiki>" telah memiliki $2 suntingan. Penggantian nama pengguna dengan lebih dari $3 suntingan dapat mempengaruhi kinerja situs',
	'renameuser-error-request'    => 'Ada masalah dalam pemrosesan permintaan. Silakan kembali dan coba lagi.',
	'renameuser-error-same-user'  => 'Anda tak dapat mengganti nama pengguna sama seperti asalnya.',
	'renameusersuccess'           => 'Pengguna "<nowiki>$1</nowiki>" telah diganti namanya menjadi "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Halaman $1 telah ada dan tidak dapat ditimpa secara otomatis.',
	'renameuser-page-moved'       => 'Halaman $1 telah dipindah ke $2.',
	'renameuser-page-unmoved'     => 'Halaman $1 tidak dapat dipindah ke $2.',
	'renameuserlogpage'           => 'Log penggantian nama pengguna',
	'renameuserlogpagetext'       => 'Di bawah ini adalah log penggantian nama pengguna',
	'renameuserlogentry'          => 'telah mengganti nama $1 menjadi "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 suntingan|$1 suntingan}}. Alasan: $2',
	'renameuser-move-log'         => 'Secara otomatis memindahkan halaman sewaktu mengganti nama pengguna "[[User:$1|$1]]" menjadi "[[User:$2|$2]]"',
	'right-renameuser'            => 'Mengganti nama pengguna',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'renameusernew' => 'Nova uzantonomo:',
);

/** Icelandic (Íslenska)
 * @author Cessator
 * @author לערי ריינהארט
 * @author Spacebirdy
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'renameuser'                  => 'Breyta notandanafni',
	'renameuserold'               => 'Núverandi notandanafn:',
	'renameusernew'               => 'Nýja notandanafnið:',
	'renameusersubmit'            => 'Senda',
	'renameusererrordoesnotexist' => 'Notandinn „<nowiki>$1</nowiki>“ er ekki til',
	'renameusererrorexists'       => 'Notandinn „<nowiki>$1</nowiki>“ er nú þegar til',
	'renameusererrorinvalid'      => 'Notandanafnið „<nowiki>$1</nowiki>“ er ógilt',
	'renameuser-page-exists'      => 'Síða sem heitir $1 er nú þegar til og það er ekki hægt að búa til nýja grein með sama heiti.',
	'renameuser-page-moved'       => 'Síðan $1 hefur verið færð á $2.',
	'renameuser-page-unmoved'     => 'Ekki var hægt að færa síðuna $1 á $2.',
	'renameuserlogpage'           => 'Skrá yfir nafnabreytingar notenda',
	'renameuserlogpagetext'       => 'Þetta er skrá yfir nýlegar breytingar á notendanöfnum.',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author .anaconda
 * @author Gianfranco
 * @author Siebrand
 * @author Darth Kule
 */
$messages['it'] = array(
	'renameuser'                  => 'Modifica del nome utente',
	'renameuser-desc'             => "Funzione per rinominare un utente (richiede i diritti di ''renameuser'')",
	'renameuserold'               => 'Nome utente attuale:',
	'renameusernew'               => 'Nuovo nome utente:',
	'renameuserreason'            => 'Motivo del cambio nome',
	'renameusermove'              => 'Rinomina anche la pagina utente, la pagina di discussione e le relative sottopagine',
	'renameuserwarnings'          => 'Avvisi:',
	'renameuserconfirm'           => 'Sì, rinomina questo utente',
	'renameusersubmit'            => 'Invia',
	'renameusererrordoesnotexist' => 'Il nome utente "<nowiki>$1</nowiki>" non esiste',
	'renameusererrorexists'       => 'Il nome utente "<nowiki>$1</nowiki>" esiste già',
	'renameusererrorinvalid'      => 'Il nome utente "<nowiki>$1</nowiki>" non è valido',
	'renameusererrortoomany'      => 'Il nome utente "<nowiki>$1</nowiki>" ha $2 contributi. Modificare il nome di un utente con più di $3 contributi potrebbe incidere negativamente sulle prestazioni del sito',
	'renameuser-error-request'    => 'Si è verificato un problema nella ricezione della richiesta. Tornare indietro e riprovare.',
	'renameuser-error-same-user'  => 'Non è possibile rinominare un utente allo stesso nome che aveva già.',
	'renameusersuccess'           => 'Il nome utente "<nowiki>$1</nowiki>" è stato modificato in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'La pagina $1 esiste già; impossibile sovrascriverla automaticamente.',
	'renameuser-page-moved'       => 'La pagina $1 è stata spostata a $2.',
	'renameuser-page-unmoved'     => 'Impossibile spostare la pagina $1 a $2.',
	'renameuserlogpage'           => 'Utenti rinominati',
	'renameuserlogpagetext'       => 'Di seguito viene presentato il registro delle modifiche ai nomi utente',
	'renameuserlogentry'          => 'ha rinominato $1 in "$2"',
	'renameuser-log'              => 'Che ha {{PLURAL:$1|un contributo|$1 contributi}}. Motivo: $2',
	'renameuser-move-log'         => 'Spostamento automatico della pagina - utente rinominato da "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser'            => 'Rinomina gli utenti',
);

/** Japanese (日本語)
 * @author Suisui
 * @author Marine-Blue
 * @author Broad-Sky
 */
$messages['ja'] = array(
	'renameuser'                  => '利用者名の変更',
	'renameuser-desc'             => "利用者名変更 (''利用者名変更'' の権限が必要です)",
	'renameuserold'               => '現在の利用者名:',
	'renameusernew'               => '新しい利用者名:',
	'renameuserreason'            => '変更理由:',
	'renameusermove'              => '利用者ページと会話ページ及びそれらのサブページを新しい名前に移動する',
	'renameusersubmit'            => '変更',
	'renameusererrordoesnotexist' => '利用者 “<nowiki>$1</nowiki>” は存在しません。',
	'renameusererrorexists'       => '利用者 “<nowiki>$1</nowiki>” は既に存在しています。',
	'renameusererrorinvalid'      => '利用者名 “<nowiki>$1</nowiki>” は無効な値です。',
	'renameusererrortoomany'      => '利用者 "<nowiki>$1</nowiki>" には $2 件の投稿履歴があります。$3 件以上の投稿履歴がある利用者の名前を変更すると、サイトのパフォーマンスに悪影響を及ぼす可能性があります。',
	'renameuser-error-request'    => 'リクエストを正常に受け付けることが出来ませんでした。戻ってから再度お試しください。',
	'renameuser-error-same-user'  => '現在と同じユーザー名に変更することは出来ません。',
	'renameusersuccess'           => '利用者 "<nowiki>$1</nowiki>" を "<nowiki>$2</nowiki>" に変更しました。',
	'renameuser-page-exists'      => '$1 が既に存在しているため、自動で上書きできませんでした。',
	'renameuser-page-moved'       => '$1 を $2 に移動しました。',
	'renameuser-page-unmoved'     => '$1 を $2 に移動できませんでした。',
	'renameuserlogpage'           => '利用者名変更記録',
	'renameuserlogpagetext'       => 'これは、利用者名の変更を記録したものです。',
	'renameuserlogentry'          => '$1 を "$2" へ利用者名変更しました。',
	'renameuser-log'              => '投稿数 $1回. $2',
	'renameuser-move-log'         => '名前の変更と共に "[[User:$1|$1]]" を "[[User:$2|$2]]" へ移動しました。',
);

/** Jutish (Jysk)
 * @author Ælsån
 * @author Huslåke
 */
$messages['jut'] = array(
	'renameuser'                  => 'Gæf æ bruger en ny navn',
	'renameuser-desc'             => "Gæf en bruger en ny navn (''renameuser'' regt er nøteg)",
	'renameuserold'               => 'Nuværende brugernavn:',
	'renameusernew'               => 'Ny brugernavn:',
	'renameuserreason'            => "Før hvat dett'er dun:",
	'renameusermove'              => 'Flyt bruger og diskusje sider (og deres substrøk) til ny navn',
	'renameusersubmit'            => 'Gå til',
	'renameusererrordoesnotexist' => 'Æ bruger "<nowiki>$1</nowiki>" bestä ekke.',
	'renameusererrorexists'       => 'Æ bruger "<nowiki>$1</nowiki>" er ål.',
	'renameusererrorinvalid'      => 'Æ brugernavn "<nowiki>$1</nowiki>" er ogyldegt.',
	'renameusererrortoomany'      => 'Æ bruger "<nowiki>$1</nowiki>" har $2 biidråg, hernåmende en bruger ve mære als $3 biidråg ken æ site performans slektes hvinse gæve.',
	'renameuser-error-request'    => 'Her har en pråblæm ve enkriige der anfråge. Gå hen og pråbær nurmål.',
	'renameuser-error-same-user'  => 'Du kenst ekke hernåm æ bruger til æselbste nåm als dafør.',
	'renameusersuccess'           => 'Æ bruger "<nowiki>$1</nowiki>" er hernåmt til "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'Æ pæge $1 er ål og ken ekke åtåmatisk åverflyttet være.',
	'renameuser-page-moved'       => 'Æ pæge $1 er flyttet til $2.',
	'renameuser-page-unmoved'     => 'Æ pæge $1 kon ekke flyttet være til $2.',
	'renameuserlogpage'           => 'Bruger hernåm log',
	'renameuserlogpagetext'       => "Dett'er en log der ændrenger til brugernavner",
	'renameuserlogentry'          => 'har hernåmt $1 til "$2"',
	'renameuser-log'              => '{{PLURAL:$1|en redigærenge|$1 redigærenger}}. Resån: $2',
	'renameuser-move-log'         => 'Åtåmatisk flyttet pæge hviil hernåm der bruger "[[User:$1|$1]]" til "[[User:$2|$2]]"',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'renameuser'                  => 'Ngganti jeneng panganggo',
	'renameuser-desc'             => "Ngganti jeneng panganggo (perlu hak aksès ''renameuser'')",
	'renameuserold'               => 'Jeneng panganggo saiki:',
	'renameusernew'               => 'Jeneng panganggo anyar:',
	'renameuserreason'            => 'Alesan ganti jeneng:',
	'renameusermove'              => 'Mindhah kaca panganggo lan kaca dhiskusiné (sarta subkaca-kacané) menyang jeneng anyar',
	'renameusersubmit'            => 'Kirim',
	'renameusererrordoesnotexist' => 'Panganggo "<nowiki>$1</nowiki>" ora ana.',
	'renameusererrorexists'       => 'Panganggo "<nowiki>$1</nowiki>" wis ana.',
	'renameusererrorinvalid'      => 'Jeneng panganggo "<nowiki>$1</nowiki>" ora absah',
	'renameusererrortoomany'      => 'Panganggo "<nowiki>$1</nowiki>" wis duwé $2 suntingan. Yèn jeneng panganggoné diganti mawa luwih saka $3 suntingan bisa awèh pangaruh marang kinerja situs.',
	'renameuser-error-request'    => 'Wau ana masalah nalika prosès panyuwunan panjenengan.
Mangga balia lan dicoba manèh.',
	'renameuser-error-same-user'  => 'Panjenengan ora bisa ngganti jeneng panganggo dadi kaya jeneng asalé.',
	'renameusersuccess'           => 'Panganggo "<nowiki>$1</nowiki>" wis diganti jenengé dadi "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'Kaca $1 wis ana lan ora bisa ditimpa sacara otomatis.',
	'renameuser-page-moved'       => 'Kaca $1 wis dialihaké menyang $2.',
	'renameuser-page-unmoved'     => 'Kaca $1 ora bisa dialihaké menyang $2.',
	'renameuserlogpage'           => 'Log ganti jeneng panganggo',
	'renameuserlogpagetext'       => 'Iki log owah-owahan jeneng panganggo',
	'renameuserlogentry'          => 'wis ngganti jeneng $1 dadi "$2"',
	'renameuser-log'              => 'sing wis duwé $1 suntingan. Alesan: $2',
	'renameuser-move-log'         => 'Sacara otomatis mindhah kaca nalika ngganti jeneng panganggo "[[User:$1|$1]]" dadi "[[User:$2|$2]]"',
	'right-renameuser'            => 'Ganti jeneng panganggo-panganggo',
);

/** Georgian (ქართული)
 */
$messages['ka'] = array(
	'renameuser'                  => 'მომხმარებლის სახელის გამოცვლა',
	'renameuserold'               => 'ამჟამინდელი მომხმარებლის სახელი:',
	'renameusernew'               => 'ახალი მომხმარებლის სახელი:',
	'renameusermove'              => 'მომხმარებლისა და განხილვის გვერდების (და მათი დაქვემდებარებული გვერდების) გადატანა ახალ დასახელებაზე',
	'renameusersubmit'            => 'გაგზავნა',
	'renameusererrordoesnotexist' => 'მომხმარებელი "<nowiki>$1</nowiki>" არ არსებობს',
	'renameusererrorexists'       => 'მომხმარებელი "<nowiki>$1</nowiki>" უკვე არსებობს',
	'renameusererrorinvalid'      => 'მომხმარებლის სახელი "<nowiki>$1</nowiki>" არასწორია',
	'renameusererrortoomany'      => 'მომხმარებელს "<nowiki>$1</nowiki>" გაკეთებული აქვს $2 რედაქცია. სახელის შეცვლამ მომხმარებლისათვის, რომელიც $3-ზე მეტ რედაქციას ითვლის, შესაძლოა ზიანი მიაყენოს საიტის ქმედითობას',
	'renameusersuccess'           => 'მომხმარებლის სახელი - "<nowiki>$1</nowiki>", შეიცვალა "<nowiki>$2</nowiki>"-ით',
	'renameuser-page-exists'      => 'გვერდი $1 უკვე არსებობს და მისი ავტომატურად შენაცვლება შეუძლებელია.',
	'renameuser-page-moved'       => 'გვერდი $1 გადატანილია $2-ზე.',
	'renameuser-page-unmoved'     => 'არ მოხერხდა გვერდის $1 გადატანა $2-ზე.',
	'renameuserlogpage'           => 'მომხმარებლის სახელის გადარქმევის რეგისტრაციის ჟურნალი',
	'renameuserlogpagetext'       => 'ეს არის ჟურნალი, სადაც აღრიცხულია მომხმარებლის სახელთა ცვლილებები',
	'renameuser-log'              => 'რომელსაც გაკეთებული ჰქონდა $1 რედაქცია. $2',
	'renameuser-move-log'         => 'ავტომატურად იქნა გადატანილი გვერდი მომხმარებლის "[[User:$1|$1]]" სახელის შეცვლისას "[[User:$2|$2]]-ით"',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬)
 */
$messages['kk-arab'] = array(
	'renameuser'                  => 'قاتىسۋشىنى قايتا اتاۋ',
	'renameuserold'               => 'اعىمداعى قاتىسۋشى اتى:',
	'renameusernew'               => 'جاڭا قاتىسۋشى اتى:',
	'renameuserreason'            => 'قايتا اتاۋ سەبەبى:',
	'renameusermove'              => 'قاتىسۋشىنىڭ جەكە جانە تالقىلاۋ بەتتەرىن (جانە دە ولاردىڭ تومەنگى بەتتەرىن) جاڭا اتاۋعا جىلجىتۋ',
	'renameusersubmit'            => 'جىبەرۋ',
	'renameusererrordoesnotexist' => '«<nowiki>$1» دەگەن قاتىسۋشى جوق',
	'renameusererrorexists'       => '«$1» دەگەن قاتىسۋشى بار تۇگە ',
	'renameusererrorinvalid'      => '«$1» قاتىسۋشى اتى جارامسىز ',
	'renameusererrortoomany'      => '«$1» قاتىسۋشى $2 ۇلەس بەرگەن, $3 ارتا ۇلەسى بار قاتىسۋشىنى قايتا اتاۋى توراپ ونىمدىلىگىنە ىقپال ەتەدى',
	'renameusersuccess'           => '«$1» دەگەن قاتىسۋشى اتى «$2» دەگەنگە اۋىستىرىلدى',
	'renameuser-page-exists'      => '$1 دەگەن بەت بار تۇگە, جانە وزدىك تۇردە ونىڭ ۇستىنە ەشتەڭە جازىلمايدى.',
	'renameuser-page-moved'       => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلدى.',
	'renameuser-page-unmoved'     => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلمادى.',
	'renameuserlogpage'           => 'قاتىسۋشىنى قايتا اتاۋ جۋرنالى',
	'renameuserlogpagetext'       => 'بۇل قاتىسۋشى اتىنداعى وزگەرىستەر جۋرنالى',
	'renameuserlogentry'          => '$1 اتاۋىن $2 دەگەنگە وزگەرتتى',
	'renameuser-log'              => '$1 تۇزەتۋى بار. $2',
	'renameuser-move-log'         => '«[[User:$1|$1]]» دەگەن قاتىسۋشى اتىن «[[User:$2|$2]]» دەگەنگە اۋىسقاندا بەت وزدىك تۇردە جىلجىتىلدى',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic))
 */
$messages['kk-cyrl'] = array(
	'renameuser'                  => 'Қатысушыны қайта атау',
	'renameuserold'               => 'Ағымдағы қатысушы аты:',
	'renameusernew'               => 'Жаңа қатысушы аты:',
	'renameuserreason'            => 'Қайта атау себебі:',
	'renameusermove'              => 'Қатысушының жеке және талқылау беттерін (және де олардың төменгі беттерін) жаңа атауға жылжыту',
	'renameusersubmit'            => 'Жіберу',
	'renameusererrordoesnotexist' => '«<nowiki>$1</nowiki>» деген қатысушы жоқ',
	'renameusererrorexists'       => '«<nowiki>$1</nowiki>» деген қатысушы бар түге ',
	'renameusererrorinvalid'      => '«<nowiki>$1</nowiki>» қатысушы аты жарамсыз ',
	'renameusererrortoomany'      => '«<nowiki>$1</nowiki>» қатысушы $2 үлес берген, $3 арта үлесі бар қатысушыны қайта атауы торап өнімділігіне ықпал етеді',
	'renameusersuccess'           => '«<nowiki>$1</nowiki>» деген қатысушы аты «<nowiki>$2</nowiki>» дегенге ауыстырылды',
	'renameuser-page-exists'      => '$1 деген бет бар түге, және өздік түрде оның үстіне ештеңе жазылмайды.',
	'renameuser-page-moved'       => '$1 деген бет $2 деген бетке жылжытылды.',
	'renameuser-page-unmoved'     => '$1 деген бет $2 деген бетке жылжытылмады.',
	'renameuserlogpage'           => 'Қатысушыны қайта атау журналы',
	'renameuserlogpagetext'       => 'Бұл қатысушы атындағы өзгерістер журналы',
	'renameuserlogentry'          => '$1 атауын «$2» дегенге өзгертті',
	'renameuser-log'              => '$1 түзетуі бар. $2',
	'renameuser-move-log'         => '«[[User:$1|$1]]» деген қатысушы атын «[[User:$2|$2]]» дегенге ауысқанда бет өздік түрде жылжытылды',
);

/** Kazakh (Latin) (Қазақша (Latin))
 */
$messages['kk-latn'] = array(
	'renameuser'                  => 'Qatıswşını qaýta ataw',
	'renameuserold'               => 'Ağımdağı qatıswşı atı:',
	'renameusernew'               => 'Jaña qatıswşı atı:',
	'renameuserreason'            => 'Qaýta ataw sebebi:',
	'renameusermove'              => 'Qatıswşınıñ jeke jäne talqılaw betterin (jäne de olardıñ tömengi betterin) jaña atawğa jıljıtw',
	'renameusersubmit'            => 'Jiberw',
	'renameusererrordoesnotexist' => '«<nowiki>$1</nowiki>» degen qatıswşı joq',
	'renameusererrorexists'       => '«<nowiki>$1</nowiki>» degen qatıswşı bar tüge ',
	'renameusererrorinvalid'      => '«<nowiki>$1</nowiki>» qatıswşı atı jaramsız ',
	'renameusererrortoomany'      => '«<nowiki>$1</nowiki>» qatıswşı $2 üles bergen, $3 arta ülesi bar qatıswşını qaýta atawı torap önimdiligine ıqpal etedi',
	'renameusersuccess'           => '«<nowiki>$1</nowiki>» degen qatıswşı atı «<nowiki>$2</nowiki>» degenge awıstırıldı',
	'renameuser-page-exists'      => '$1 degen bet bar tüge, jäne özdik türde onıñ üstine eşteñe jazılmaýdı.',
	'renameuser-page-moved'       => '$1 degen bet $2 degen betke jıljıtıldı.',
	'renameuser-page-unmoved'     => '$1 degen bet $2 degen betke jıljıtılmadı.',
	'renameuserlogpage'           => 'Qatıswşını qaýta ataw jwrnalı',
	'renameuserlogpagetext'       => 'Bul qatıswşı atındağı özgerister jwrnalı',
	'renameuserlogentry'          => '$1 atawın «$2» degenge özgertti',
	'renameuser-log'              => '$1 tüzetwi bar. $2',
	'renameuser-move-log'         => '«[[User:$1|$1]]» degen qatıswşı atın «[[User:$2|$2]]» degenge awısqanda bet özdik türde jıljıtıldı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'renameuser'                  => 'ប្តូរឈ្មោះអ្នកប្រើប្រាស់',
	'renameuser-desc'             => "ប្តូរឈ្មោះអ្នកប្រើប្រាស់(ត្រូវការសិទ្ធិ ''ប្តូរឈ្មោះអ្នកប្រើប្រាស់'')",
	'renameuserold'               => 'ឈ្មោះអ្នកប្រើប្រាស់បច្ចុប្បន្ន ៖',
	'renameusernew'               => 'ឈ្មោះអ្នកប្រើប្រាស់ថ្មី៖',
	'renameuserreason'            => 'មូលហេតុ៖',
	'renameusermove'              => 'ប្តូរទីតាំងទំព័រអ្នកប្រើប្រាស់និងទំព័រពិភាក្សា(រួមទាំងទំព័ររងផងដែរ)ទៅឈ្មោះថ្មី',
	'renameuserwarnings'          => 'បំរាម:',
	'renameuserconfirm'           => 'បាទ/ចាស៎ សូមប្តូរឈ្មោះអ្នកប្រើប្រាស់នេះ',
	'renameusersubmit'            => 'ដាក់ស្នើ',
	'renameusererrordoesnotexist' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មិនមាន ។',
	'renameusererrorexists'       => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មានហើយ ។',
	'renameusererrorinvalid'      => 'ឈ្មោះអ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មិនត្រឹមត្រូវ ។',
	'renameuser-error-request'    => 'មានបញ្ហា ចំពោះការទទួលសំណើ។ សូមត្រលប់ក្រោយ ហើយព្យាយាមម្តងទៀត ។',
	'renameuser-error-same-user'  => 'អ្នកមិនអាច ប្តូរឈ្មោះអ្នកប្រើប្រាស់ ទៅជាឈ្មោះ ដូចមុន នោះទេ។',
	'renameusersuccess'           => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" ត្រូវបានប្តូរឈ្មោះទៅ "<nowiki>$2</nowiki>"។',
	'renameuser-page-exists'      => 'ទំព័រ $1 មានហើយ មិនអាចសរសេរជាន់ពីលើដោយស្វ័យប្រវត្តិទេ។',
	'renameuser-page-moved'       => 'ទំព័រ$1ត្រូវបានប្តូរទីតាំងទៅ$2ហើយ។',
	'renameuser-page-unmoved'     => 'ទំព័រ$1មិនអាចប្តូរទីតាំងទៅ$2បានទេ។',
	'renameuserlogpage'           => 'កំណត់ហេតុនៃការប្តូរឈ្មោះអ្នកប្រើប្រាស់',
	'renameuserlogpagetext'       => 'នេះជាកំណត់ហេតុនៃបំលាស់ប្តូរនៃឈ្មោះអ្នកប្រើប្រាស់',
	'renameuserlogentry'          => 'បានប្តូរឈ្មោះ $1 ទៅជា "$2" ហើយ',
	'renameuser-log'              => '{{PLURAL:$1|កំណែប្រែ}}។ ហេតុផល៖ $2',
	'renameuser-move-log'         => 'បានប្តូរទីតាំងទំព័រដោយស្វ័យប្រវត្តិក្នុងខណៈពេលប្តូរឈ្មោះអ្នកប្រើប្រាស់ "[[User:$1|$1]]" ទៅ "[[User:$2|$2]]"',
	'right-renameuser'            => 'ប្ដូរឈ្មោះអ្នកប្រើប្រាស់នានា',
);

/** Kannada (ಕನ್ನಡ)
 * @author Shushruth
 */
$messages['kn'] = array(
	'renameuser' => 'ಸದಸ್ಯರನ್ನು ಮರುನಾಮಕರಣ ಮಾಡಿ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author ToePeu
 * @author Kwj2772
 */
$messages['ko'] = array(
	'renameuser'                  => '사용자 이름 변경',
	'renameuserold'               => '기존 사용자 이름:',
	'renameusernew'               => '새 이름:',
	'renameuserreason'            => '바꾸는 이유:',
	'renameusermove'              => '사용자 문서와 토론 문서, 하위 문서를 새 사용자 이름으로 이동하기',
	'renameusersubmit'            => '변경',
	'renameusererrordoesnotexist' => '‘<nowiki>$1</nowiki>’ 사용자가 존재하지 않습니다.',
	'renameusererrorexists'       => '‘<nowiki>$1</nowiki>’ 사용자가 이미 존재합니다.',
	'renameusererrorinvalid'      => '‘<nowiki>$1</nowiki>’ 사용자 이름이 잘못되었습니다.',
	'renameusererrortoomany'      => '‘<nowiki>$1</nowiki>’ 사용자는 $2번의 기여를 했습니다. $3번을 넘는 기여를 한 사용자의 이름을 변경하는 것은 성능 저하를 일으킬 수 있습니다.',
	'renameuser-error-request'    => '요청을 정상적으로 전송하지 못했습니다.
뒤로 가서 다시 시도해주세요.',
	'renameusersuccess'           => '‘<nowiki>$1</nowiki>’ 사용자가 ‘<nowiki>$2</nowiki>’(으)로 변경되었습니다.',
	'renameuser-page-exists'      => '$1 문서가 이미 존재하여 자동으로 이동하지 못했습니다.',
	'renameuser-page-moved'       => '$1 문서를 $2(으)로 이동했습니다.',
	'renameuser-page-unmoved'     => '$1 문서를 $2(으)로 이동하지 못했습니다.',
	'renameuserlogpage'           => '이름 변경 기록',
	'renameuserlogpagetext'       => '사용자 이름 변경 기록입니다.',
	'renameuserlogentry'          => '$1에서 "$2"로 이름을 바꾸었습니다.',
	'renameuser-log'              => '$1개의 기여. 이유: $2',
	'renameuser-move-log'         => '‘[[User:$1|$1]]’ 사용자를 ‘[[User:$2|$2]]’(으)로 바꾸면서 문서를 자동으로 이동함',
	'right-renameuser'            => '사용자 이름 변경',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 * @author Siebrand
 */
$messages['ksh'] = array(
	'renameuser'                  => 'Metmaacher ömdäufe',
	'renameuser-desc'             => "Metmaacher ömdäufe — do buch mer et Rääsch (''renameuser'') för",
	'renameuserold'               => 'Dä ahle Metmaacher-Name',
	'renameusernew'               => 'Dä neue Metmaacher-Name',
	'renameuserreason'            => 'Jrund för et Ömdäufe:',
	'renameusermove'              => 'De Metmaachersigg met Klaaf- un Ungersigge op dä neue Metmaacher-Name ömstelle',
	'renameuserwarnings'          => 'Warnunge:',
	'renameuserconfirm'           => 'Jo, dunn dä Metmaacher ömbenenne un em singe Name ändere',
	'renameusersubmit'            => 'Ömdäufe!',
	'renameusererrordoesnotexist' => 'Ene Metmaacher „<nowiki>$1</nowiki>“ kenne mer nit.',
	'renameusererrorexists'       => 'Ene Metmaacher met däm Name „<nowiki>$1</nowiki>“ jit et ald.',
	'renameusererrorinvalid'      => 'Ene Metmaacher-Name eß „<nowiki>$1</nowiki>“ ävver nit, dä wöhr nit richtich.',
	'renameusererrortoomany'      => 'Dä Metmaacher „<nowiki>$1</nowiki>“ hät $2 Beidräch zom Wiki jemaat.

<strong>Opjepass:</strong> Esu ene Metmaacher, met mieh wi <strong>$3</strong> Beidräch, ömzedäufe, dat brems et Wiki womööchlesch kräftesch.',
	'renameuser-error-request'    => 'Mer hatte e Problem met Dingem Opdrach.
Bes esu joot un versöök et noch ens.',
	'renameuser-error-same-user'  => 'Do Tuppes! Der ahle un der neue Name es dersellve. Do bengk et Ömdäufe jaanix.',
	'renameusersuccess'           => 'Dä Metmaacher „<nowiki>$1</nowiki>“ es jetz op „<nowiki>$2</nowiki>“ ömjedäuf.',
	'renameuser-page-exists'      => 'De Sigg $1 es ald doh, un mer könne se nit automatesch övverschrieve',
	'renameuser-page-moved'       => 'De Sigg wood vun „$1“ op „$2“ ömjenannt.',
	'renameuser-page-unmoved'     => 'Di Sigg „$1“ kunnt nit op „$2“ ömjenannt wääde.',
	'renameuserlogpage'           => 'Logboch vum Metmaacher-Ömdäufe',
	'renameuserlogpagetext'       => 'Dat es et Logboch vun de ömjedäufte Metmaachere',
	'renameuserlogentry'          => 'hät dä Metmaacher „$1“ op „$2“ ömjedäuf',
	'renameuser-log'              => '{{PLURAL:$1|ein Beärbeidung|$1 Beärbeidung|kein Beärbeidung}}. Jrund: $2',
	'renameuser-move-log'         => 'Di Sigg weet automatesch ömjenannt weil mer dä Metmaacher „[[User:$1|$1]]“ op „[[User:$2|$2]]“ öm am däufe sin.',
	'right-renameuser'            => 'Metmaacher ömdäufe',
);

/** Kurdish (Latin) (Kurdî / كوردی (Latin)) */
$messages['ku-latn'] = array(
	'renameuser'        => 'Navî bikarhênerê biguherîne',
	'renameuserold'     => 'Navî niha:',
	'renameusernew'     => 'Navî nuh:',
	'renameusersubmit'  => 'Bike',
	'renameusersuccess' => 'Navî bikarhênerê "<nowiki>$1</nowiki>" bû "<nowiki>$2</nowiki>"',
	'renameuser-log'    => 'yê $1 beşdarîyên xwe hebû. $2',
);

/** Latin (Latina)
 * @author UV
 * @author SPQRobin
 * @author MF-Warburg
 * @author Siebrand
 */
$messages['la'] = array(
	'renameuser'                  => 'Usorem renominare',
	'renameuserold'               => 'Praesente nomen usoris:',
	'renameusernew'               => 'Novum nomen usoris:',
	'renameuserreason'            => 'Causa renominationis:',
	'renameusermove'              => 'Movere paginas usoris et disputationis (et subpaginae) in nomen novum',
	'renameusersubmit'            => 'Renominare',
	'renameusererrordoesnotexist' => 'Usor "<nowiki>$1</nowiki>" non existit',
	'renameusererrorexists'       => 'Usor "<nowiki>$1</nowiki>" iam existit',
	'renameusererrorinvalid'      => 'Nomen usoris "<nowiki>$1</nowiki>" irritum est',
	'renameusererrortoomany'      => 'Usor "<nowiki>$1</nowiki>" $2 recensiones fecit. Usorem plus quam $3 recensiones habentem renominando hoc vici lentescere potest.',
	'renameusersuccess'           => 'Usor "<nowiki>$1</nowiki>" renominatus est in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Pagina $1 iam existit et non potest automatice deleri.',
	'renameuser-page-moved'       => 'Pagina $1 mota est ad $2.',
	'renameuser-page-unmoved'     => 'Pagina $1 ad $2 moveri non potuit.',
	'renameuserlogpage'           => 'Index renominationum usorum',
	'renameuserlogpagetext'       => 'Hic est index renominationum usorum',
	'renameuserlogentry'          => 'renominavit $1 in "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 recensio|$1 recensiones}}. Causa: $2',
	'renameuser-move-log'         => 'movit paginam automatice in renominando usorem "[[User:$1|$1]]" in "[[User:$2|$2]]"',
	'right-renameuser'            => 'Usores renominare',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 * @author Siebrand
 */
$messages['lb'] = array(
	'renameuser'                  => 'Benotzernumm änneren',
	'renameuser-desc'             => "Benotzernumm änneren (Dir braucht dofir  ''renameuser''-Rechter)",
	'renameuserold'               => 'Aktuelle Benotzernumm:',
	'renameusernew'               => 'Neie Benotzernumm:',
	'renameuserreason'            => "Grond fir d'Ëmbenennung:",
	'renameusermove'              => 'Benotzer- an Diskussiounssäiten (an déi jeweileg Ënnersäiten) op den neie Benotzernumm réckelen',
	'renameuserwarnings'          => 'Warnungen:',
	'renameuserconfirm'           => 'Jo, Benotzer ëmbenennen',
	'renameusersubmit'            => 'Ëmbenennen',
	'renameusererrordoesnotexist' => 'De Benotzer "<nowiki>$1</nowiki>" gëtt et net.',
	'renameusererrorexists'       => 'De Benotzer "<nowiki>$1</nowiki>" gët et schonn.',
	'renameusererrorinvalid'      => 'De Benotzernumm "<nowiki>$1</nowiki>" kann net benotzt ginn.',
	'renameusererrortoomany'      => 'De benotzer "<nowiki>$1</nowiki>" huet $2 Ännerunge gemaach. D¨¨annerung vum Benotzernumm vun engem Benotzer mat méi wéi $3 Ännerungen kann d\'Vitesse vum Site staark beaflossen (De Server gëtt lues).',
	'renameuser-error-request'    => 'Et gouf e Problem mat ärer Ufro.
Gitt w.e.g. zréck a versicht et nach eng Kéier.',
	'renameuser-error-same-user'  => 'Dir kënnt kee Benotzernumm änneren, an him dee selweschte Numm erëmginn.',
	'renameusersuccess'           => 'De Benotzer "<nowiki>$1</nowiki>" gouf "<nowiki>$2</nowiki>" ëmbenannt.',
	'renameuser-page-exists'      => "D'Säit $1 gëtt et schonns a kann net automatesch iwwerschriwwe ginn.",
	'renameuser-page-moved'       => "D'Säit $1 gouf op $2 geréckelt.",
	'renameuser-page-unmoved'     => "D'Säit $1 konnt net op $2 geréckelt ginn.",
	'renameuserlogpage'           => 'Logbuch vun den Ännerungen vum Benotzernumm',
	'renameuserlogpagetext'       => "An dësem Logbuch ginn d'Ännerungen vum Benotzernumm festgehal.",
	'renameuserlogentry'          => 'huet de Benotzer $1 als Benotzer "$2" ëmbenannt',
	'renameuser-log'              => '{{PLURAL:$1|1 Ännerung|$1 Ännerungen}}. Grond: $2',
	'renameuser-move-log'         => 'Duerch d\'Réckele vum Benotzer  "[[User:$1|$1]]" op "[[User:$2|$2]]" goufen déi folgend Säiten automatesch matgeréckelt:',
	'right-renameuser'            => 'Benotzer ëmbenennen',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 * @author Matthias
 * @author Tibor
 * @author Siebrand
 */
$messages['li'] = array(
	'renameuser'                  => 'Hernöm gebroeker',
	'renameuser-desc'             => "Voog 'n [[Special:Renameuser|speciaal pazjwna]] toe óm 'ne gebroeker te hernömme (doe höbs hiej ''renameuser''-rech veur neudig)",
	'renameuserold'               => 'Hujige gebroekersnaam:',
	'renameusernew'               => 'Nuje gebroekersnaam:',
	'renameuserreason'            => 'Ree veur hernömme:',
	'renameusermove'              => "De gebroekerspazjena en euverlèkpazjena (en eventueel subpazjena's) hernömmme nao de nuje gebroekersnaam",
	'renameusersubmit'            => 'Hernöm',
	'renameusererrordoesnotexist' => 'De gebroeker "<nowiki>$1</nowiki>" besteit neet.',
	'renameusererrorexists'       => 'De gebroeker "<nowiki>$1</nowiki>" besteit al.',
	'renameusererrorinvalid'      => 'De gebroekersnaam "<nowiki>$1</nowiki>" is óngeljig.',
	'renameusererrortoomany'      => 'De gebroeker "<nowiki>$1</nowiki>" haet $2 bewèrkinge gedaon; \'t hernömme van \'ne gebroeker mit meer es $3 biedraag kan de perstasie van de site naodeilig beïnvloeje.',
	'renameuser-error-request'    => "d'r Woor 'n perbleem bie 't óntvange vanne aanvraog. Lèvver trök te gaon en opnuuj te perbere/",
	'renameuser-error-same-user'  => 'De kèns gein gebroekers herneume nao dezelfde naam.',
	'renameusersuccess'           => 'De gebroeker "<nowiki>$1</nowiki>" is hernömp nao "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'De pazjena $1 besteit al en kan neet automatisch euversjreve waere,',
	'renameuser-page-moved'       => 'De pagina $1 is hernömp nao $2.',
	'renameuser-page-unmoved'     => 'De pagina $1 kon neet hernömp waere nao $2.',
	'renameuserlogpage'           => 'Logbook gebroekersnaamwieziginge',
	'renameuserlogpagetext'       => 'Hiejónger staon gebroekersname die verangerdj zeen',
	'renameuserlogentry'          => 'haet $1 hernömp nao "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 bewerking|$1 bewerkinge}}. Ree: $2',
	'renameuser-move-log'         => 'Automatisch hernömp bie \'t wiezige van gebroeker "[[User:$1|$1]]" nao "[[User:$2|$2]]"',
	'right-renameuser'            => 'Gebroekers hernaome',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 * @author Hugo.arg
 * @author Siebrand
 */
$messages['lt'] = array(
	'renameuser'                  => 'Pervadinti naudotoją',
	'renameuser-desc'             => "Pervadinti naudotoją (reikia ''pervadintojo'' teisių)",
	'renameuserold'               => 'Esamas naudotojo vardas:',
	'renameusernew'               => 'Naujas naudotojo vardas:',
	'renameuserreason'            => 'Priežastis pervadinimui:',
	'renameusermove'              => 'Perkelti naudotoją ir aptarimo puslapius (bei jo subpuslapius) prie naujo vardo',
	'renameusersubmit'            => 'Patvirtinti',
	'renameusererrordoesnotexist' => 'Naudotojas "<nowiki>$1</nowiki>" neegzistuoja.',
	'renameusererrorexists'       => 'Naudotojas "<nowiki>$1</nowiki>" jau egzistuoja.',
	'renameusererrorinvalid'      => 'Naudotojo vardas "<nowiki>$1</nowiki>" netinkamas.',
	'renameusersuccess'           => 'Naudotojas "<nowiki>$1</nowiki>" buvo pervadintas į "<nowiki>$2</nowiki>".',
	'renameuserlogpage'           => 'Naudotojų pervadinimo sąrašas',
	'renameuserlogpagetext'       => 'Tai yra naudotojų vardų pakeitimų sąrašas',
	'renameuserlogentry'          => 'buvo pervadintas $1 į "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 redagavimas|$1 redagavimų(ai)}}. Priežastis: $2',
	'renameuser-move-log'         => 'Puslapis automatiškai perkeltas, kai buvo pervadinamas naudotojas "[[User:$1|$1]]" į "[[User:$2|$2]]"',
);

/** Latvian (Latviešu)
 * @author SPQRobin
 */
$messages['lv'] = array(
	'renameuserlogpage'     => 'Lietotāju pārdēvēšanas reģistrs',
	'renameuserlogpagetext' => 'Lietotājvārdu maiņas reģistrs',
);

/** Macedonian (Македонски)
 * @author Misos
 */
$messages['mk'] = array(
	'renameuser'                  => 'Преименувај корисник',
	'renameuserold'               => 'Сегашно корисничко име:',
	'renameusernew'               => 'Ново корисничко име:',
	'renameusersubmit'            => 'Внеси',
	'renameusererrordoesnotexist' => 'Корисникот "<nowiki>$1</nowiki>" не постои',
	'renameusererrorexists'       => 'Корисникот "<nowiki>$1</nowiki>" веќе постои',
	'renameusererrorinvalid'      => 'Корисничкото име "<nowiki>$1</nowiki>" не е валидно',
	'renameusererrortoomany'      => 'Корисникот "<nowiki>$1</nowiki>" има $2 придонеси, преименување на корисник со повеќе од $3 придонеси може негативно да се одрази на перформансите на сајтот',
	'renameusersuccess'           => 'Корисникот "<nowiki>$1</nowiki>" е преименуван во "<nowiki>$2</nowiki>"',
	'renameuserlogpage'           => 'Историја на преименувања на корисници',
	'renameuserlogpagetext'       => 'Ово е историја на преименувања на корисници',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'renameuser'                  => 'ഉപയോക്താവിനെ പുനര്‍നാമകരണം ചെയ്യുക',
	'renameuser-desc'             => "ഉപയോക്താവിനെ പുനര്‍നാമകരണം ചെയ്യുക (''പുനര്‍നാമകരണ'' അവകാശം വേണം)",
	'renameuserold'               => 'ഇപ്പോഴത്തെ ഉപയോക്തൃനാമം:',
	'renameusernew'               => 'പുതിയ ഉപയോക്തൃനാമം:',
	'renameuserreason'            => 'ഉപയോക്തൃനാമം മാറ്റാനുള്ള കാരണം:',
	'renameusermove'              => 'നിലവിലുള്ള ഉപയോക്തൃതാളും, ഉപയോക്താവിന്റെ സം‌വാദം താളും (സബ് പേജുകള്‍ അടക്കം) പുതിയ നാമത്തിലേക്കു മാറ്റുക.',
	'renameusersubmit'            => 'സമര്‍പ്പിക്കുക',
	'renameusererrordoesnotexist' => '"<nowiki>$1</nowiki>"  എന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'renameusererrorexists'       => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവ് നിലവിലുണ്ട്.',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്തൃനാമം അസാധുവാണ്‌.',
	'renameusererrortoomany'      => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനു ഈ വിക്കിയില്‍ $2 തിരുത്തലുകളുണ്ട്. $3 ക്കു മുകളില്‍ തിരുത്തലുകളുള്ള ഉപയോക്തൃനാമങ്ങളെ പുനര്‍നാമകരണം ചെയ്യുന്നതു ഈ സൈറ്റിന്റെ പ്രവര്‍ത്തനത്തെ ബാധിക്കും.',
	'renameuser-error-request'    => 'അപേക്ഷ സ്വീകരിക്കുമ്പോള്‍ പിഴവ് സം‌ഭവിച്ചു. ദയവായി തിരിച്ചു പോയി വീണ്ടും പരിശ്രമിക്കുക.',
	'renameuser-error-same-user'  => 'നിലവിലുള്ള ഒരു ഉപയോക്തൃനാമത്തിലേക്കു വേറൊരു ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തുവാന്‍ സാധിക്കില്ല.',
	'renameusersuccess'           => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനെ "<nowiki>$2</nowiki>" എന്ന നാമത്തിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'renameuser-page-exists'      => '$1 എന്ന താള്‍ നിലവിലുള്ളതിനാല്‍ അതിനെ യാന്ത്രികമായി മാറ്റാന്‍ കഴിയില്ല.',
	'renameuser-page-moved'       => '$1 എന്ന താള്‍ $2വിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'renameuser-page-unmoved'     => '$1 എന്ന താള്‍ $2 വിലേക്കു മാറ്റാന്‍ സാദ്ധ്യമല്ല.',
	'renameuserlogpage'           => 'ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തിയതിന്റെ പ്രവര്‍ത്തനരേഖ',
	'renameuserlogpagetext'       => 'ഈ പ്രവര്‍ത്തനരേഖ ഉപയോക്തൃനാമം പുനര്‍നാമകരണം നടത്തിയതിന്റേതാണ്‌.',
	'renameuserlogentry'          => '$1 എന്ന താള്‍ "$2" എന്ന താളിലേക്കു പുനര്‍നാമകരണം ചെയ്തിരിക്കുന്നു.',
	'renameuser-log'              => '{{PLURAL:$1|ഒരു തിരുത്തല്‍|$1 തിരുത്തലുകള്‍}}. കാരണം: $2',
	'renameuser-move-log'         => '"[[User:$1|$1]]" എന്ന ഉപയോക്താവിനെ "[[User:$2|$2]]" എന്നു പുനര്‍നാമകരണം ചെയ്തപ്പോള്‍ താള്‍ യാന്ത്രികമായി മാറ്റി.',
	'right-renameuser'            => 'ഉപയോക്താക്കളെ പുനഃര്‍നാമകരണം നടത്തുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'renameuser'                  => 'सदस्यनाम बदला',
	'renameuser-desc'             => "सदस्यनाम बदला (यासाठी तुम्हाला ''सदस्यनाम बदलण्याचे अधिकार'' असणे आवश्यक आहे)",
	'renameuserold'               => 'सध्याचे सदस्यनाम:',
	'renameusernew'               => 'नवीन सदस्यनाम:',
	'renameuserreason'            => 'नाम बदलण्याचे कारण:',
	'renameusermove'              => 'सदस्य तसेच सदस्य चर्चापान (तसेच त्यांची उपपाने) नवीन सदस्यनामाकडे स्थानांतरीत करा',
	'renameusersubmit'            => 'पाठवा',
	'renameusererrordoesnotexist' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अस्तित्वात नाही.',
	'renameusererrorexists'       => '"<nowiki>$1</nowiki>" नावाचा सदस्य अगोदरच अस्तित्वात आहे',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" हे नाव चुकीचे आहे.',
	'renameusererrortoomany'      => '"<nowiki>$1</nowiki>" या सदस्याने $2 संपादने केलेली आहेत, $3 पेक्षा जास्त संपादने केलेल्या सदस्यांचे नाव बदलल्यास संकेतस्थळावर प्रश्न निर्माण होऊ शकतात.',
	'renameuser-error-request'    => 'हे काम करताना त्रुटी आढळलेली आहे. कृपया मागे जाऊन परत प्रयत्न करा.',
	'renameuser-error-same-user'  => 'तुम्ही एखाद्या सदस्याला परत पूर्वीच्या नावाकडे बदलू शकत नाही',
	'renameusersuccess'           => '"<nowiki>$1</nowiki>" या सदस्याचे नाव "<nowiki>$2</nowiki>" ला बदललेले आहे.',
	'renameuser-page-exists'      => '$1 हे पान अगोदरच अस्तित्वात आहे व आपोआप पुनर्लेखन करता येत नाही.',
	'renameuser-page-moved'       => '$1 हे पान $2 मथळ्याखाली स्थानांतरीत केले.',
	'renameuser-page-unmoved'     => '$1 हे पान $2 मथळ्याखाली स्थानांतरीत करू शकत नाही.',
	'renameuserlogpage'           => 'सदस्यनाम बदल यादी',
	'renameuserlogpagetext'       => 'ही सदस्यनामांमध्ये केलेल्या बदलांची यादी आहे.',
	'renameuserlogentry'          => 'नी $1 ला "$2" केले',
	'renameuser-log'              => '{{PLURAL:$1|१ संपादन|$1 संपादने}}. कारण: $2',
	'renameuser-move-log'         => '"[[User:$1|$1]]" ला "[[User:$2|$2]]" बदलताना आपोआप सदस्य पान स्थानांतरीत केलेले आहे.',
	'right-renameuser'            => 'सदस्यांची नावे बदला',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'renameuser'                  => 'Tukar nama pengguna',
	'renameuser-desc'             => "Menukar nama pengguna (memerlukan hak ''renameuser'')",
	'renameuserold'               => 'Nama semasa:',
	'renameusernew'               => 'Nama baru:',
	'renameuserreason'            => 'Sebab tukar:',
	'renameusermove'              => 'Pindahkan laman pengguna dan laman perbincangannya (berserta semua sublaman yang ada) ke nama baru',
	'renameuserwarnings'          => 'Amaran:',
	'renameuserconfirm'           => 'Ya, tukar nama pengguna ini',
	'renameusersubmit'            => 'Serah',
	'renameusererrordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak wujud.',
	'renameusererrorexists'       => 'Pengguna "<nowiki>$1</nowiki>" telah pun wujud.',
	'renameusererrorinvalid'      => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah.',
	'renameusererrortoomany'      => 'Pengguna "<nowiki>$1</nowiki>" mempunyai $2 sumbangan. Penukaran nama pengguna yang mempunyai lebih daripada $3 sumbangan boleh menjejaskan prestasi tapak web ini.',
	'renameuser-error-request'    => 'Berlaku masalah ketika menerima permintaan anda.
Sila undur dan cuba lagi.',
	'renameuser-error-same-user'  => 'Anda tidak boleh menukar nama pengguna kepada nama yang sama.',
	'renameusersuccess'           => 'Nama "<nowiki>$1</nowiki>" telah ditukar menjadi "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'Laman $1 telah pun wujud dan tidak boleh ditulis ganti secara automatik.',
	'renameuser-page-moved'       => 'Laman $1 telah dipindahkan ke $2.',
	'renameuser-page-unmoved'     => 'Laman $1 tidak dapat dipindahkan ke $2.',
	'renameuserlogpage'           => 'Log penukaran nama pengguna',
	'renameuserlogpagetext'       => 'Ini ialah log penukaran nama pengguna.',
	'renameuserlogentry'          => 'telah menukar nama $1 menjadi "$2"',
	'renameuser-log'              => '$1 suntingan. Sebab: $2',
	'renameuser-move-log'         => 'Memindahkan laman secara automatik ketika menukar nama "[[User:$1|$1]]" menjadi "[[User:$2|$2]]"',
	'right-renameuser'            => 'Menukar nama pengguna',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'renameusersubmit' => 'Tiquihuāz',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'renameuser'            => 'Kái iōng-chiá ê miâ',
	'renameuser-page-moved' => '$1 í-keng sóa khì tī $2.',
	'renameuserlogpagetext' => 'Chit-ê log lia̍t-chhut kái-piàn iōng-chiá miâ-jī ê tōng-chok.',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 * @author Siebrand
 */
$messages['nds'] = array(
	'renameuser'                  => 'Brukernaam ännern',
	'renameuserold'               => 'Brukernaam nu:',
	'renameusernew'               => 'Nee Brukernaam:',
	'renameuserreason'            => 'Gründ för den ne’en Naam:',
	'renameusermove'              => 'Brukersieden op’n ne’en Naam schuven',
	'renameusersubmit'            => 'Ännern',
	'renameusererrordoesnotexist' => "Bruker ''<nowiki>$1</nowiki>'' gifft dat nich",
	'renameusererrorexists'       => "Bruker ''<nowiki>$1</nowiki>'' gifft dat al",
	'renameusererrorinvalid'      => "Brukernaam ''<nowiki>$1</nowiki>'' geiht nich",
	'renameusererrortoomany'      => "Bruker ''<nowiki>$1</nowiki>'' hett $2 Bidrääg. Den Naam ännern kann bi Brukers mit mehr as $3 Bidrääg de Software lahm maken",
	'renameusersuccess'           => "Brukernaam ''<nowiki>$1</nowiki>'' op ''<nowiki>$2</nowiki>'' ännert",
	'renameuser-page-exists'      => 'Siet $1 gifft dat al un kann nichautomaatsch överschreven warrn.',
	'renameuser-page-moved'       => 'Siet $1 schaven na $2.',
	'renameuser-page-unmoved'     => 'Siet $1 kunn nich na $2 schaven warrn.',
	'renameuserlogpage'           => 'Ännerte-Brukernaams-Logbook',
	'renameuserlogpagetext'       => 'Dit is dat Logbook för ännerte Brukernaams',
	'renameuserlogentry'          => 'hett „$1“ ne’en Naam „$2“ geven',
	'renameuser-log'              => '{{PLURAL:$1|1 Ännern|$1 Ännern}}. Grund: $2',
	'renameuser-move-log'         => "Siet bi dat Ännern vun’n Brukernaam ''[[User:$1|$1]]'' na ''[[User:$2|$2]]'' automaatsch schaven",
	'right-renameuser'            => 'Brukers ne’en Naam geven',
);

/** Nepali (नेपाली)
 * @author SPQRobin
 */
$messages['ne'] = array(
	'renameuserold' => 'अहिलेको प्रयोगकर्ता नाम:',
	'renameusernew' => 'नयाँ प्रयोगकर्ता नाम:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 * @author Effeietsanders
 */
$messages['nl'] = array(
	'renameuser'                  => 'Gebruiker hernoemen',
	'renameuser-desc'             => "Voegt een [[Special:Renameuser|speciale pagina]] toe om een gebruiker te hernoemen (u hebt hiervoor het recht ''renameuser'' nodig)",
	'renameuserold'               => 'Huidige gebruikersnaam:',
	'renameusernew'               => 'Nieuwe gebruikersnaam:',
	'renameuserreason'            => 'Reden voor hernoemen:',
	'renameusermove'              => "De gebruikerspagina en overlegpagina (en eventuele subpagina's) hernoemen naar de nieuwe gebruikersnaam",
	'renameuserwarnings'          => 'Waarschuwingen:',
	'renameuserconfirm'           => 'Ja, hernoem de gebruiker',
	'renameusersubmit'            => 'Hernoemen',
	'renameusererrordoesnotexist' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat niet.',
	'renameusererrorexists'       => 'De gebruiker "<nowiki>$1</nowiki>" bestaat al.',
	'renameusererrorinvalid'      => 'De gebruikersnaam "<nowiki>$1</nowiki>" is ongeldig.',
	'renameusererrortoomany'      => 'De gebruiker "<nowiki>$1</nowiki>" heeft $2 bewerkingen gedaan; het hernoemen van een gebruiker met meer dan $3 bijdragen kan de prestaties van de site nadelig beïnvloeden',
	'renameuser-error-request'    => 'Er was een probleem bij het ontvangen van de aanvraag.  Gelieve terug te gaan en opnieuwe te proberen.',
	'renameuser-error-same-user'  => 'U kunt geen gebruiker hernoemen naar dezelfde naam.',
	'renameusersuccess'           => 'De gebruiker "<nowiki>$1</nowiki>" is hernoemd naar "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'De pagina $1 bestaat al en kan niet automatisch overschreven worden.',
	'renameuser-page-moved'       => 'De pagina $1 is hernoemd naar $2.',
	'renameuser-page-unmoved'     => 'De pagina $1 kon niet hernoemd worden naar $2.',
	'renameuserlogpage'           => 'Logboek gebruikersnaamwijzigingen',
	'renameuserlogpagetext'       => 'Hieronder staan gebruikersnamen die gewijzigd zijn',
	'renameuserlogentry'          => 'heeft $1 hernoemd naar "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 bewerking|$1 bewerkingen}}. Reden: $2',
	'renameuser-move-log'         => 'Automatisch hernoemd bij het wijzigen van gebruiker "[[User:$1|$1]]" naar "[[User:$2|$2]]"',
	'right-renameuser'            => 'Gebruikers hernoemen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'renameuser'                  => 'Døp om bruker',
	'renameuser-desc'             => "Døp om en bruker (krever ''renameuser''-rettigheter)",
	'renameuserold'               => 'Nåværende navn:',
	'renameusernew'               => 'Nytt brukernavn:',
	'renameuserreason'            => 'Grunn for omdøping:',
	'renameusermove'              => 'Flytt bruker- og brukerdiskusjonssider (og deres undersider) til nytt navn',
	'renameuserwarnings'          => 'Advarsler:',
	'renameuserconfirm'           => 'Ja, endre navn på brukeren',
	'renameusersubmit'            => 'Døp om',
	'renameusererrordoesnotexist' => 'Brukeren «<nowiki>$1</nowiki>» finnes ikke',
	'renameusererrorexists'       => 'Brukeren «<nowiki>$1</nowiki>» finnes allerede',
	'renameusererrorinvalid'      => 'Brukernavnet «<nowiki>$1</nowiki>» er ugyldig',
	'renameusererrortoomany'      => 'Brukeren «<nowiki>$1</nowiki>» har $2&nbsp;redigeringer. Å døpe om brukere med mer enn $3&nbsp;redigeringer kan kunne påvirke sidens ytelse.',
	'renameuser-error-request'    => 'Det var et problem med å motte forespørselen. Gå tilbake og prøv igjen.',
	'renameuser-error-same-user'  => 'Du kan ikke gi en bruker samme navn som han/hun allerede har.',
	'renameusersuccess'           => 'Brukeren «<nowiki>$1</nowiki>» har blitt omdøpt til «<nowiki>$2</nowiki>»',
	'renameuser-page-exists'      => 'Siden $1 finnes allerede, og kunne ikke erstattes automatisk.',
	'renameuser-page-moved'       => 'Siden $1 har blitt flyttet til $2.',
	'renameuser-page-unmoved'     => 'Siden $1 kunne ikke flyttes til $2.',
	'renameuserlogpage'           => 'Omdøpingslogg',
	'renameuserlogpagetext'       => 'Dette er en logg over endringer i brukernavn.',
	'renameuserlogentry'          => 'endret navn på $1 til «$2»',
	'renameuser-log'              => '{{PLURAL:$1|Én redigering|$1 redigeringer}}. Grunn: $2',
	'renameuser-move-log'         => 'Flyttet side automatisk under omdøping av brukeren «[[User:$1|$1]]» til «[[User:$2|$2]]»',
	'right-renameuser'            => 'Omdøpe brukere',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'renameuser'            => 'Fetola leina la mošomiši',
	'renameuserold'         => 'Leina la bjale la mošomiši:',
	'renameusernew'         => 'Leina le lempsha la mošomiši:',
	'renameuserreason'      => 'Lebaka lago fetola leina:',
	'renameuser-page-moved' => 'Letlakala $1 le hudušitšwe go $2',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Siebrand
 */
$messages['oc'] = array(
	'renameuser'                  => "Tornar nomenar l'utilizaire",
	'renameuser-desc'             => "Torna nomenar un utilizaire (necessita los dreches de ''renameuser'')",
	'renameuserold'               => "Nom actual de l'utilizaire :",
	'renameusernew'               => "Nom novèl de l'utilizaire :",
	'renameuserreason'            => 'Motiu del cambiament de nom :',
	'renameusermove'              => 'Desplaçar totas las paginas de l’utilizaire vèrs lo nom novèl',
	'renameusersubmit'            => 'Sometre',
	'renameusererrordoesnotexist' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » es pas valid",
	'renameusererrorexists'       => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » existís ja",
	'renameusererrorinvalid'      => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » existís pas",
	'renameusererrortoomany'      => "L'utilizaire « <nowiki>$1</nowiki> » a $2 contribucions. Tornar nomenar un utilizaire qu'a mai de $3 contribucions a son actiu pòt afectar las performanças del sit.",
	'renameuser-error-request'    => 'Un problèma existís amb la recepcion de la requèsta. Tornatz en rèire e ensajatz tornamai.',
	'renameuser-error-same-user'  => 'Podètz pas tornar nomenar un utilizaire amb la meteissa causa deperabans.',
	'renameusersuccess'           => "L'utilizaire « <nowiki>$1</nowiki> » es plan estat renomenat en « <nowiki>$2</nowiki> »",
	'renameuser-page-exists'      => 'La pagina $1 existís ja e pòt pas èsser remplaçada automaticament.',
	'renameuser-page-moved'       => 'La pagina $1 es estada desplaçada vèrs $2.',
	'renameuser-page-unmoved'     => 'La pagina $1 pòt pas èsser renomenada en $2.',
	'renameuserlogpage'           => "Istoric dels cambiaments de nom d'utilizaire",
	'renameuserlogpagetext'       => "Aquò es l'istoric dels cambiaments de nom dels utilizaires",
	'renameuserlogentry'          => 'a renomenat $1 en "$2"',
	'renameuser-log'              => "qu'aviá $1 edicions a son actiu. $2",
	'renameuser-move-log'         => 'Pagina desplaçada automaticament al moment del cambiament de nom de l’utilizaire "[[User:$1|$1]]" en "[[User:$2|$2]]"',
	'right-renameuser'            => "Tornar nomenar d'utilizaires",
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author WarX
 * @author Derbeth
 * @author Wpedzich
 * @author Maikking
 */
$messages['pl'] = array(
	'renameuser'                  => 'Zmiana nazwy użytkownika',
	'renameuser-desc'             => "Zmiana nazwy użytkownika (wymaga posiadania uprawnień ''renameuser'')",
	'renameuserold'               => 'Obecna nazwa użytkownika',
	'renameusernew'               => 'Nowa nazwa użytkownika',
	'renameuserreason'            => 'Przyczyna zmiany nazwy',
	'renameusermove'              => 'Przeniesienie strony osobistej i strony dyskusji użytkownika (oraz ich podstron) pod nową nazwę użytkownika',
	'renameuserwarnings'          => 'Ostrzeżenia:',
	'renameuserconfirm'           => 'Zmień nazwę użytkownika',
	'renameusersubmit'            => 'Zmień',
	'renameusererrordoesnotexist' => 'Użytkownik „<nowiki>$1</nowiki>” nie istnieje',
	'renameusererrorexists'       => 'Użytkownik „<nowiki>$1</nowiki>” już istnieje',
	'renameusererrorinvalid'      => 'Niepoprawna nazwa użytkownika „<nowiki>$1</nowiki>”',
	'renameusererrortoomany'      => 'Użytkownik „<nowiki>$1</nowiki>” ma {{PLURAL:$2|1 edycję|$2 edycje|$2 edycji}}. Zmiana nazwy użytkownika mającego powyżej $3 edycji może wpłynąć na wydajność serwisu.',
	'renameuser-error-request'    => 'Wystąpił problem z odbiorem żądania. Cofnij się i spróbuj jeszcze raz.',
	'renameuser-error-same-user'  => 'Nie możesz zmienić nazwy użytkownika na taką samą jaka była wcześniej.',
	'renameusersuccess'           => 'Nazwa użytkownika „<nowiki>$1</nowiki>” została zmieniona na „<nowiki>$2</nowiki>”',
	'renameuser-page-exists'      => 'Strona „$1” już istnieje i nie może być automatycznie nadpisana.',
	'renameuser-page-moved'       => 'Strona „$1” została przeniesiona do „$2”.',
	'renameuser-page-unmoved'     => 'Strona „$1” nie mogła zostać przeniesiona do „$2”.',
	'renameuserlogpage'           => 'Zmiany nazw użytkowników',
	'renameuserlogpagetext'       => 'To jest rejestr zmian nazw użytkowników',
	'renameuserlogentry'          => 'zmienił nazwę użytkownika $1 na „$2”',
	'renameuser-log'              => '$1 {{PLURAL:$1|edycja|edycje|edycji}}. Powód: $2',
	'renameuser-move-log'         => 'Automatyczne przeniesienie stron użytkownika po zmianie nazwy konta z „[[User:$1|$1]]” na „[[User:$2|$2]]”',
	'right-renameuser'            => 'Zmiana nazw kont użytkowników',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'renameuser'                  => "Arbatié n'utent",
	'renameuserold'               => 'Stranòm corent:',
	'renameusernew'               => 'Stranòm neuv:',
	'renameuserreason'            => "Rason ch'as cambia stranòm:",
	'renameusermove'              => 'Tramuda ëdcò la pàgina utent e cola dle ciaciarade (con tute soe sotapàgine) a lë stranòm neuv',
	'renameusersubmit'            => 'Falo',
	'renameusererrordoesnotexist' => 'A-i é pa gnun utent ch\'as ës-ciama "<nowiki>$1</nowiki>"',
	'renameusererrorexists'       => 'N\'utent ch\'as ës-ciama "<nowiki>$1</nowiki>" a-i é già',
	'renameusererrorinvalid'      => 'Lë stranòm "<nowiki>$1</nowiki>" a l\'é nen bon',
	'renameusererrortoomany'      => "L'utent \"<nowiki>\$1</nowiki>\" a l'ha fait \$2 modìfiche, ch'a ten-a present che arbatié n'utent ch'a l'abia pì che \$3 modìfiche a podrìa feje un brut efet a le prestassion dël sit.",
	'renameusersuccess'           => 'L\'utent "<nowiki>$1</nowiki>" a l\'é stait arbatià an "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => "La pàgina $1 a-i é già e as peul nen passe-ie dzora n'aotomàtich.",
	'renameuser-page-moved'       => "La pàgina $1 a l'ha fait San Martin a $2.",
	'renameuser-page-unmoved'     => "La pàgina $1 a l'é pa podusse tramudé a $2.",
	'renameuserlogpage'           => "Registr dj'arbatiagi",
	'renameuserlogpagetext'       => "Sossì a l'é un registr dle modìfiche djë stranòm dj'utent",
	'renameuserlogentry'          => 'a l\'ha arbatià $1 coma "$2"',
	'renameuser-log'              => "ch'a l'avìa $1 modìfiche. $2",
	'renameuser-move-log'         => 'Pàgina utent tramudà n\'aotomàtich damëntrè ch\'as arbatiava "[[User:$1|$1]]" an "[[User:$2|$2]]"',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'renameuserold'     => 'اوسنی کارن-نوم:',
	'renameusernew'     => 'نوی کارن-نوم:',
	'renameuserlogpage' => 'د کارن-نوم يادښت',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author 555
 * @author Siebrand
 */
$messages['pt'] = array(
	'renameuser'                  => 'Renomear utilizador',
	'renameuser-desc'             => "Renomear um utilizador (requer privilégio ''renameuser'')",
	'renameuserold'               => 'Nome de utilizador actual:',
	'renameusernew'               => 'Novo nome de utilizador:',
	'renameuserreason'            => 'Motivo de renomear:',
	'renameusermove'              => 'Mover as páginas de utilizador, páginas de discussão de utilizador e sub-páginas para o novo nome',
	'renameuserwarnings'          => 'Alertas:',
	'renameuserconfirm'           => 'Sim, renomeie o utilizador',
	'renameusersubmit'            => 'Enviar',
	'renameusererrordoesnotexist' => 'O utilizador "<nowiki>$1</nowiki>" não existe',
	'renameusererrorexists'       => 'O utilizador "<nowiki>$1</nowiki>" já existe',
	'renameusererrorinvalid'      => 'O nome de utilizador "<nowiki>$1</nowiki>" é inválido',
	'renameusererrortoomany'      => 'O utilizador "<nowiki>$1</nowiki>" possui $2 contribuições. Renomear um utilizador com mais de $3 contribuições pode afectar o desempenho do site',
	'renameuser-error-request'    => 'Houve um problema ao receber este pedido. Por favor, volte atrás e tente de novo.',
	'renameuser-error-same-user'  => 'Não pode renomear um utilizador para o mesmo nome anterior.',
	'renameusersuccess'           => 'O utilizador "<nowiki>$1</nowiki>" foi renomeado para "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'A página $1 já existe e não poderá ser sobre-escrita automaticamente.',
	'renameuser-page-moved'       => 'A página $1 foi movida com sucesso para $2.',
	'renameuser-page-unmoved'     => 'Não foi possível mover a página $1 para $2.',
	'renameuserlogpage'           => 'Registo de renomeação de utilizadores',
	'renameuserlogpagetext'       => 'Este é um registo de alterações efectuadas a nomes de utilizadores',
	'renameuserlogentry'          => 'renomeou $1 para "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'renameuser-move-log'         => 'Foram movidas páginas de forma automática ao renomear o utilizador "[[User:$1|$1]]" para "[[User:$2|$2]]"',
	'right-renameuser'            => 'Renomear utilizadores',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'renameuser'                  => 'Ruraqpa sutinta hukchay',
	'renameuserold'               => 'Kunan ruraqpa sutin:',
	'renameusernew'               => 'Musuq ruraqpa sutin:',
	'renameuserreason'            => 'Imarayku ruraqpa sutinta hukchasqa:',
	'renameusermove'              => "Ruraqpa p'anqanta, rimachinanta (urin p'anqankunatapas) musuq sutinman astay",
	'renameusersubmit'            => 'Kachay',
	'renameusererrordoesnotexist' => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa manam kanchu.',
	'renameusererrorexists'       => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa kachkanñam.',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" nisqa sutiqa manam allinchu.',
	'renameusererrortoomany'      => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa $2 llamk\'apusqayuqmi. $3-manta aswan llamk\'apusqayuq ruraqpa sutinta hukchayqa llika tiyaypa rikch\'akuyninpaq mana allinchá kanman.',
	'renameuser-error-request'    => 'Manam atinichu mañasqaykita chaskiyta.  Ama hina kaspa, ñawpaqman kutimuspa musuqmanta ruraykachay.',
	'renameuser-error-same-user'  => 'Manam atinkichu ruraqpa sutinta ñawpaq suti hinalla sutinman hukchayta.',
	'renameusersuccess'           => 'Ruraqpa "<nowiki>$1</nowiki>" nisqa sutinqa "<nowiki>$2</nowiki>" nisqa sutinman hukchasqañam.',
	'renameuser-page-exists'      => '"<nowiki>$1</nowiki>" sutiyuq p\'anqaqa kachkanñam. Manam atinallachu kikinmanta huknachay.',
	'renameuser-page-moved'       => '"<nowiki>$1</nowiki>" ñawpa sutiyuq ruraqpa p\'anqanqa "<nowiki>$2</nowiki>" nisqa musuq p\'anqanman astasqañam.',
	'renameuser-page-unmoved'     => 'Manam atinichu "<nowiki>$1</nowiki>" ñawpa sutiyuq ruraqpa p\'anqanta "<nowiki>$2</nowiki>" nisqa musuq p\'anqanman astayta.',
	'renameuserlogpage'           => "Ruraqpa sutin hukchay hallch'a",
	'renameuserlogpagetext'       => "Kayqa ruraqkunap sutinkunata hukchaymanta hallch'am",
	'renameuserlogentry'          => 'hukchan $1-pa sutinta "$2" sutiman',
	'renameuser-log'              => "{{PLURAL:$1|1 llamk'apusqa|$1 llamk'apusqakuna}}, kayrayku: $2",
	'renameuser-move-log'         => '"[[User:$1|$1]]" ruraqpa sutinta "[[User:$2|$2]]" sutiman hukchaspa kikinmanta ruraqpa p\'anqatapas astan',
);

/** Romani (Romani)
 * @author Desiphral
 */
$messages['rmy'] = array(
	'renameusersubmit' => 'De le jeneske aver nav',
);

/** Romanian (Română)
 * @author Emily
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'renameuser'                  => 'Redenumeşte utilizator',
	'renameuserold'               => 'Numele de utilizator existent:',
	'renameusernew'               => 'Numele de utilizator nou:',
	'renameusermove'              => 'Mută pagina de utilizator şi pagina de discuţii (şi subpaginile lor) la noul nume',
	'renameusersubmit'            => 'Trimite',
	'renameusererrordoesnotexist' => 'Utilizatorul "$1" nu există',
	'renameusererrorexists'       => 'Utilizatorul "$1" există deja',
	'renameusererrorinvalid'      => 'Numele de utilizator "<nowiki>$1</nowiki>" este invalid',
	'renameusererrortoomany'      => 'Utilizatorul "<nowiki>$1</nowiki>" are $2 contribuţii, redenumirea unui utilizator cu mai mult de $3 contribuţii ar putea afecta performanţa sitului',
	'renameusersuccess'           => 'Utilizatorul "$1" a fost redenumit în "$2"',
	'renameuser-page-exists'      => 'Pagina $1 există deja şi nu poate fi suprascrisă automat.',
	'renameuser-page-moved'       => 'Pagina $1 a fost mutată la $2.',
	'renameuser-page-unmoved'     => 'Pagina $1 nu poate fi mutată la $2.',
	'renameuserlogpage'           => 'Raport redenumiri utilizatori',
	'renameuserlogpagetext'       => 'Acesta este un raport al modificărilor de nume de utilizator',
	'renameuser-move-log'         => 'Pagină mutată automat la redenumirea utilizatorului de la "[[Utilizator:$1|$1]]" la "[[Utilizator:$2|$2]]"',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Ahonc
 * @author Siebrand
 * @author Innv
 * @author EugeneZelenko
 */
$messages['ru'] = array(
	'renameuser'                  => 'Переименовать участника',
	'renameuser-desc'             => "Переименование участника (требуются права ''renameuser'')",
	'renameuserold'               => 'Имя в настоящий момент:',
	'renameusernew'               => 'Новое имя:',
	'renameuserreason'            => 'Причина переименования:',
	'renameusermove'              => 'Переименовать также страницу участника, личное обсуждение и их подстраницы',
	'renameuserwarnings'          => 'Предупреждения:',
	'renameuserconfirm'           => 'Да, переименовать участника',
	'renameusersubmit'            => 'Выполнить',
	'renameusererrordoesnotexist' => 'Участник с именем «<nowiki>$1</nowiki>» не зарегистрирован.',
	'renameusererrorexists'       => 'Участник с именем «<nowiki>$1</nowiki>» уже зарегистрирован.',
	'renameusererrorinvalid'      => 'Недопустимое имя участника: <nowiki>$1</nowiki>',
	'renameusererrortoomany'      => 'Участник <nowiki>$1</nowiki> внёс $2 правок, переименование участника с более чем $3 правками может оказать негативное влияние на доступ к сайту.',
	'renameuser-error-request'    => 'Возникли затруднения с получением запроса. Пожалуйста, вернитесь назад и повторите ещё раз.',
	'renameuser-error-same-user'  => 'Вы не можете переименовать участника в тоже имя, что и было раньше.',
	'renameusersuccess'           => 'Участник «<nowiki>$1</nowiki>» был переименован в «<nowiki>$2</nowiki>».',
	'renameuser-page-exists'      => 'Страница $1 уже существует и не может быть перезаписана автоматически.',
	'renameuser-page-moved'       => 'Страница $1 была переименована в $2.',
	'renameuser-page-unmoved'     => 'Страница $1 не может быть переименована в $2.',
	'renameuserlogpage'           => 'Журнал переименований участников',
	'renameuserlogpagetext'       => 'Это журнал произведённых переименований зарегистрированных участников.',
	'renameuserlogentry'          => '$1 переименован в «$2»',
	'renameuser-log'              => 'имеющий $1 {{PLURAL:$1|правку|правки|правок}}. Причина: $2',
	'renameuser-move-log'         => 'Автоматически в связи с переименованием учётной записи «[[User:$1|$1]]» в «[[User:$2|$2]]»',
	'right-renameuser'            => 'переименование участников',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 * @author Siebrand
 */
$messages['sah'] = array(
	'renameuser'                  => 'Кыттааччы аатын уларыт',
	'renameuser-desc'             => "Кыттааччы аатын уларытыы (''renameuser'' бырааба наада)",
	'renameuserold'               => 'Билиҥҥи аата:',
	'renameusernew'               => 'Саҥа аата:',
	'renameuserreason'            => 'Аатын уларыппыт төрүөтэ:',
	'renameusermove'              => 'Кыттааччы аатын кытта кэпсэтэр сирин, уонна атын сирэйдэрин ааттарын уларыт',
	'renameusersubmit'            => 'Толор',
	'renameusererrordoesnotexist' => 'Маннык ааттаах кыттааччы «<nowiki>$1</nowiki>» бэлиэтэммэтэх.',
	'renameusererrorexists'       => 'Маннык ааттаах кыттааччы "<nowiki>$1</nowiki>" номнуо баар.',
	'renameusererrorinvalid'      => 'Маннык аат "<nowiki>$1</nowiki>" көҥуллэммэт.',
	'renameusererrortoomany'      => '<nowiki>$1</nowiki> кыттааччы $2 көннөрүүнү киллэрбит, $3 тахса көннөрүүнү оҥорбут кыттааччы аатын уларытыы саайка киириини хааччахтыан сөп.',
	'renameuser-error-request'    => 'Запрос тутуута моһуоктанна. Бука диэн төнүн уонна хатылаа.',
	'renameuser-error-same-user'  => 'Кыттааччы аатын урукку аатыгар уларытар табыллыбат.',
	'renameusersuccess'           => '"<nowiki>$1</nowiki>" кыттааччы мантан ыла "<nowiki>$2</nowiki>" диэн ааттанна.',
	'renameuser-page-exists'      => '$1 сирэй номнуо баар онон аптамаатынан хат суруллар кыаҕа суох.',
	'renameuser-page-moved'       => '$1 сирэй маннык ааттаммыт $2.',
	'renameuser-page-unmoved'     => '$1 сирэй маннык $2 ааттанар кыаҕа суох.',
	'renameuserlogpage'           => 'Кыттааччылар ааттарын уларытыыларын сурунаала',
	'renameuserlogpagetext'       => 'Бу бэлиэтэммит кыттааччылар ааттарын уларытыыларын сурунаала',
	'renameuserlogentry'          => '$1 аата маннык буолла "$2"',
	'renameuser-log'              => '{{PLURAL:$1|Биирдэ|$1 төгүл}} уларыйбыт. Төрүөтэ: $2',
	'renameuser-move-log'         => '«[[User:$1|$1]]» аата «[[User:$2|$2]]» буолбутунан аптамаатынан',
	'right-renameuser'            => 'Кыттааччылар ааттарын уларытыы',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Siebrand
 * @author Andre Engels
 */
$messages['sk'] = array(
	'renameuser'                  => 'Premenovať používateľa',
	'renameuser-desc'             => "Premenovať používateľa (vyžaduje právo ''renameuser'')",
	'renameuserold'               => 'Súčasné používateľské meno:',
	'renameusernew'               => 'Nové používateľské meno:',
	'renameuserreason'            => 'Dôvod premenovania:',
	'renameusermove'              => 'Presunúť používateľské a diskusné stránky (a ich podstránky) na nový názov',
	'renameuserwarnings'          => 'Upozornenia:',
	'renameuserconfirm'           => 'Áno, premenovať používateľa',
	'renameusersubmit'            => 'Odoslať',
	'renameusererrordoesnotexist' => 'Používateľ „<nowiki>$1</nowiki>“  neexistuje',
	'renameusererrorexists'       => 'Používateľ „<nowiki>$1</nowiki>“ už existuje',
	'renameusererrorinvalid'      => 'Používateľské meno „<nowiki>$1</nowiki>“ je neplatné',
	'renameusererrortoomany'      => 'Používateľ „<nowiki>$1</nowiki>“ má $2 príspevkov, premenovanie používateľa s počtom príspevkov väčším ako $3 by sa mohlo nepriaznivo odraziť na výkone stránky',
	'renameuser-error-request'    => 'Pri prijímaní vašej požiadavky nastal problém. Prosím, vráťte sa a skúste to znova.',
	'renameuser-error-same-user'  => 'Nemôžete premenovať používateľa na rovnaké meno ako mal predtým.',
	'renameusersuccess'           => 'Používateľ „<nowiki>$1</nowiki>“ bol premenovaný na „<nowiki>$2</nowiki>“',
	'renameuser-page-exists'      => 'Stránka $1 už existuje a nie je možné ju automaticky prepísať.',
	'renameuser-page-moved'       => 'Stránka $1 bola presunutá na $2.',
	'renameuser-page-unmoved'     => 'Stránku $1 nebolo možné presunúť na $2.',
	'renameuserlogpage'           => 'Záznam premenovaní používateľov',
	'renameuserlogpagetext'       => 'Toto je záznam premenovaní používateľov',
	'renameuserlogentry'          => 'premenoval používateľa $1 na "$2"',
	'renameuser-log'              => 'mal {{PLURAL:$1|1 úpravu|$1 úpravy|$1 úprav}}. Dôvod: $2',
	'renameuser-move-log'         => 'Automaticky presunutá stránka počas premenovania používateľa „[[User:$1|$1]]“ na „[[User:$2|$2]]“',
	'right-renameuser'            => 'Premenovávať používateľov',
);

/** Albanian (Shqip) */
$messages['sq'] = array(
	'renameuser'                  => 'Ndërrim përdoruesi',
	'renameuserold'               => 'Emri i tanishëm',
	'renameusernew'               => 'Emri i ri',
	'renameusermove'              => 'Zhvendos faqet e përdoruesit dhe të diskutimit (dhe nën-faqet e tyre) tek emri i ri',
	'renameusersubmit'            => 'Ndryshoje',
	'renameusererrordoesnotexist' => 'Përdoruesi me emër "<nowiki>$1</nowiki>" nuk ekziston',
	'renameusererrorexists'       => 'Përdoruesi me emër "<nowiki>$1</nowiki>" ekziston',
	'renameusererrorinvalid'      => 'Emri "<nowiki>$1</nowiki>" nuk është i lejuar',
	'renameusererrortoomany'      => 'Përdoruesi "<nowiki>$1</nowiki>" ka dhënë $2 kontribute. Ndryshimi i emrit të një përdoruesi me më shumë se $3 kontribute mund të ndikojë rëndë tek rendimenti i shërbyesave.',
	'renameusersuccess'           => 'Përdoruesi "<nowiki>$1</nowiki>" u riemërua në "<nowiki>$2</nowiki>"',
	'renameuserlogpage'           => 'Regjistri i emër-ndryshimeve',
	'renameuserlogpagetext'       => 'Ky është një regjistër i ndryshimeve së emrave të përdoruesve',
	'renameuser-log'              => 'me $1 kontribute. $2',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'renameuser'                  => 'Преименуј корисника',
	'renameuserold'               => 'Тренутно корисничко име:',
	'renameusernew'               => 'Ново корисничко име:',
	'renameuserreason'            => 'Разлог преименовања:',
	'renameusermove'              => 'Премести корисничку страницу и страницу за разговор (и њихове подстранице) на ново име',
	'renameusersubmit'            => 'Прихвати',
	'renameusererrordoesnotexist' => 'Корисник "<nowiki>$1</nowiki>" не постоји',
	'renameusererrorexists'       => 'Корисник "<nowiki>$1</nowiki>" већ постоји',
	'renameusererrorinvalid'      => 'Погрешно корисничко име: "<nowiki>$1</nowiki>"',
	'renameusererrortoomany'      => 'Корисник "<nowiki>$1</nowiki>" има $2 прилога, преименовање корисника са више од $3 прилога може да утиче на перформансе сајта',
	'renameusersuccess'           => 'Корисник "<nowiki>$1</nowiki>" је преименован на "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Страница $1 већ постоји и не може бити аутоматски преснимљена.',
	'renameuser-page-moved'       => 'Страница $1 је премештена на $2.',
	'renameuser-page-unmoved'     => 'Страница $1 не може бити премештена на $2.',
	'renameuserlogpage'           => 'Историја преименовања корисника',
	'renameuserlogpagetext'       => 'Ово је историја измена преименовања корисника',
	'renameuserlogentry'          => 'је преименовао $1 у „$2“',
	'renameuser-log'              => '{{PLURAL:$1|1 измена|$1 измене|$1 измена}}. Разлог: $2',
);

/** Seeltersk (Seeltersk)
 * @author Maartenvdbent
 * @author Pyt
 */
$messages['stq'] = array(
	'renameuser'                  => 'Benutsernoome annerje',
	'renameuserold'               => 'Benutsernoomer bithäär:',
	'renameusernew'               => 'Näie Benutsernoome:',
	'renameuserreason'            => 'Gruund foar Uumenaame:',
	'renameusermove'              => 'Ferschuuwe Benutser-/Diskussionssiede inkl. Unnersieden ap dän näie Benutsernoome',
	'renameusersubmit'            => 'Uumbenaame',
	'renameusererrordoesnotexist' => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant nit',
	'renameusererrorexists'       => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant al',
	'renameusererrorinvalid'      => 'Die Benutsernoome "<nowiki>$1</nowiki>" is uungultich',
	'renameusererrortoomany'      => 'Die Benutser "<nowiki>$1</nowiki>" häd $2 Edits. Ju Noomensannerenge fon aan Benutser mäd moor as $3 Edits kon ju Serverlaistenge toun Ätterdeel beienfloudje.',
	'renameuser-error-request'    => 'Dät roat n Problem bie dän Ämpfang fon ju Anfroage. Fersäik jädden nochmoal.',
	'renameuser-error-same-user'  => 'Oolde un näie Benutsernoome sunt identisk.',
	'renameusersuccess'           => 'Die Benutser "<nowiki>$1</nowiki>" wuude mäd Ärfoulch uumenaamd in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Ju Siede $1 bestoant al un kon nit automatisk uurschrieuwen wäide.',
	'renameuser-page-moved'       => 'Ju Siede $1 wuude ätter $2 ferschäuwen.',
	'renameuser-page-unmoved'     => 'Ju Siede $1 kuude nit ätter $2 ferschäuwen wäide.',
	'renameuserlogpage'           => 'Benutsernoomenannerengs-Logbouk',
	'renameuserlogpagetext'       => 'In dit Logbouk wäide do Annerengen fon Benutsernoomen protokollierd.',
	'renameuserlogentry'          => 'Benutser "$1" uumenaamd in "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 Beoarbaidenge|$1 Beoarbaidengen}}. Gruund: $2',
	'renameuser-move-log'         => 'truch ju Uumbenaamenge fon „[[User:$1|$1]]“ ätter „[[User:$2|$2]]“ automatisk ferschäuwene Siede.',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 * @author Irwangatot
 */
$messages['su'] = array(
	'renameuser'                  => 'Ganti ngaran pamaké',
	'renameuser-desc'             => "Ganti ngaran pamaké (perlu kawenangan ''renameuser'')",
	'renameuserold'               => 'Ngaran pamaké ayeuna:',
	'renameusernew'               => 'Ngaran pamaké anyar:',
	'renameuserreason'            => 'Alesan ganti ngaran:',
	'renameusermove'              => 'Pindahkeun kaca pamaké jeung obrolanna (jeung sub-kacanna) ka ngaran anyar',
	'renameusersubmit'            => 'Kirim',
	'renameusererrordoesnotexist' => 'Euweuh pamaké nu ngaranna "<nowiki>$1</nowiki>"',
	'renameusererrorexists'       => 'Pamaké "<nowiki>$1</nowiki>" geus aya',
	'renameusererrorinvalid'      => 'Ngaran pamaké "<nowiki>$1</nowiki>" teu sah',
	'renameusererrortoomany'      => 'Pamaké "<nowiki>$1</nowiki>" boga $2 kontribusi, ngaganti ngaran pamaké nu boga kontribusi leuwih ti $3 bakal mangaruhan kinerja loka',
	'renameuser-error-request'    => 'Aya gangguan nalika nampa paménta. Coba balik deui, terus cobaan deui.',
	'renameuser-error-same-user'  => 'Anjeun teu bisa ngaganti ngaran pamaké ka ngaran nu éta-éta kénéh.',
	'renameusersuccess'           => 'Pamaké "<nowiki>$1</nowiki>" geus diganti ngaranna jadi "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Kaca $1 geus aya sarta teu bisa ditimpah kitu baé.',
	'renameuser-page-moved'       => 'Kaca $1 geus dipindahkeun ka $2.',
	'renameuser-page-unmoved'     => 'Kaca $1 teu bisa dipindahkeun ka $2.',
	'renameuserlogpage'           => 'Log ganti ngaran',
	'renameuserlogpagetext'       => 'Ieu minangka log parobahan ngaran pamaké',
	'renameuserlogentry'          => 'geus ngaganti ngaran $1 jadi "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 édit|$1 édit}}. Alesan: $2',
	'renameuser-move-log'         => 'Otomatis mindahkeun kaca nalika ngaganti ngaran "[[User:$1|$1]]" jadi "[[User:$2|$2]]"',
);

/** Swedish (Svenska)
 * @author Habj
 * @author Lejonel
 * @author Boivie
 */
$messages['sv'] = array(
	'renameuser'                  => 'Byt användarnamn',
	'renameuser-desc'             => "Ger möjlighet att döpa om användare (kräver behörigheten ''renameuser'')",
	'renameuserold'               => 'Nuvarande användarnamn:',
	'renameusernew'               => 'Nytt användarnamn:',
	'renameuserreason'            => 'Anledning till namnbytet:',
	'renameusermove'              => 'Flytta användarsidan och användardiskussionen (och deras undersidor) till det nya namnet',
	'renameuserwarnings'          => 'Varningar:',
	'renameuserconfirm'           => 'Ja, byt namn på användaren',
	'renameusersubmit'            => 'Byt',
	'renameusererrordoesnotexist' => 'Användaren "<nowiki>$1</nowiki>" finns inte',
	'renameusererrorexists'       => 'Användarnamnet "<nowiki>$1</nowiki>" finns redan',
	'renameusererrorinvalid'      => 'Användarnamnet "<nowiki>$1</nowiki>" är felaktigt',
	'renameusererrortoomany'      => 'Användaren "<nowiki>$1</nowiki>" har $2 redigeringar. Att byta namn på en användare som gjort mer än $3 redigeringar kan påverka webbplatsens prestanda negativt.',
	'renameuser-error-request'    => 'Ett problem inträffade i hanteringen av begäran. Gå tillbaks och försök igen.',
	'renameuser-error-same-user'  => 'Du kan inte döpa om en användare till det namn hon redan har.',
	'renameusersuccess'           => 'Användaren "<nowiki>$1</nowiki>" har döpts om till "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Sidan $1 finns redan och kan inte skrivas över automatiskt.',
	'renameuser-page-moved'       => 'Sidan $1 flyttades till $2.',
	'renameuser-page-unmoved'     => 'Sidan $1 kunde inte flyttas till $2.',
	'renameuserlogpage'           => 'Omdöpningslogg',
	'renameuserlogpagetext'       => 'Detta är en logg över byten av användarnamn',
	'renameuserlogentry'          => 'döpte om $1 till "$2"',
	'renameuser-log'              => 'som hade gjort $1 redigeringar. $2',
	'renameuser-move-log'         => 'Automatisk sidflytt när användaren "[[User:$1|$1]]" döptes om till "[[User:$2|$2]]"',
	'right-renameuser'            => 'Ändra användares namn',
);

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 * @author Siebrand
 */
$messages['te'] = array(
	'renameuser'                  => 'సభ్యనామం మార్పు',
	'renameuser-desc'             => "వాడుకరి పేరు మార్చండి (''renameuser'' అన్న అధికారం కావాలి)",
	'renameuserold'               => 'ప్రస్తుత వాడుకరి పేరు:',
	'renameusernew'               => 'కొత్త వాడుకరి పేరు:',
	'renameuserreason'            => 'పేరు మార్చడానికి కారణం:',
	'renameusermove'              => 'సభ్యుని పేజీ, చర్చాపేజీలను (వాటి ఉపపేజీలతో సహా) కొత్త పేరుకు తరలించండి',
	'renameuserwarnings'          => 'హెచ్చరికలు:',
	'renameusersubmit'            => 'పంపించు',
	'renameusererrordoesnotexist' => '"<nowiki>$1</nowiki>" పేరుగల వాడుకరి లేరు.',
	'renameusererrorexists'       => '"<nowiki>$1</nowiki>" పేరుతో వాడుకరి ఇప్పటికే ఉన్నారు.',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" అనే సభ్యనామం సరైనది కాదు.',
	'renameusererrortoomany'      => 'సభ్యులు "<nowiki>$1</nowiki>" $2 రచనలు చేసారు. $3 కంటే ఎక్కువ రచనలు చేసిన సభ్యుని పేరు మార్చడం వలన సైటు పనితీరుపై ప్రతికూల ప్రభావం పడగలదు.',
	'renameuser-error-request'    => 'మీ అభ్యర్థనను స్వీకరించేటప్పుడు ఒక సమస్య తలెత్తింది. దయచేసి వెనక్కు వెళ్లి ఇంకోసారి ప్రయత్నించండి.',
	'renameuser-error-same-user'  => 'సభ్యనామాన్ని ఇంతకు ముందు ఉన్న సభ్యనామంతోనే మార్చడం కుదరదు.',
	'renameusersuccess'           => '"<nowiki>$1</nowiki>" అనే సభ్యనామాన్ని "<nowiki>$2</nowiki>"గా మార్చేసాం.',
	'renameuser-page-exists'      => '$1 పేజీ ఇప్పటికే ఉంది, కాబట్టి ఆటోమాటిగ్గా దానిపై కొత్తపేజీని రుద్దడం కుదరదు.',
	'renameuser-page-moved'       => '$1 పేజీని $2 పేజీకి తరలించాం.',
	'renameuser-page-unmoved'     => '$1 పేజీని $2 పేజీకి తరలించలేక పోయాం.',
	'renameuserlogpage'           => 'సభ్యనామాల మార్పు లాగ్',
	'renameuserlogpagetext'       => 'సభ్యనామాల మార్పు లాగ్ ఇది',
	'renameuserlogentry'          => '$1ను "$2"గా పేరు మార్చారు',
	'renameuser-log'              => '{{PLURAL:$1|ఒక దిద్దుబాటు|$1 దిద్దుబాట్లు}}. కారణం: $2',
	'renameuser-move-log'         => '"[[సభ్యులు:$1|$1]]" పేరును "[[సభ్యులు:$2|$2]]"కు మార్చడంతో పేజీని ఆటోమాటిగ్గా తరలించాం',
	'right-renameuser'            => 'వాడుకరుల పేరు మార్చడం',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'renameuserold'           => "Naran uza-na'in atuál:",
	'renameusernew'           => "Naran uza-na'in foun:",
	'renameusermove'          => "Book pájina uza-na'in no diskusaun (no sub-pájina) ba naran foun",
	'renameuser-page-moved'   => 'Book tiha pájina $1 ba $2.',
	'renameuser-page-unmoved' => 'La bele book pájina $1 ba $2.',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 * @author Siebrand
 */
$messages['tg-cyrl'] = array(
	'renameuser'                  => 'Тағйири номи корбарӣ',
	'renameuser-desc'             => "Номи як корбарро тағйир медиҳад (ниёзманд ба ихтиёроти ''тағйирином'' аст)",
	'renameuserold'               => 'Номи корбари феълӣ:',
	'renameusernew'               => 'Номи корбари ҷадид:',
	'renameuserreason'            => 'Иллати тағйири номи корбарӣ:',
	'renameusermove'              => 'Саҳифаи корбарӣ ва саҳифаи баҳси корбар (ва зерсаҳифаҳои он)ро интиқол бидеҳ',
	'renameusersubmit'            => 'Сабт',
	'renameusererrordoesnotexist' => 'Номи корбарӣ "<nowiki>$1</nowiki>" вуҷуд надорад.',
	'renameusererrorexists'       => 'Номи корбарӣ "<nowiki>$1</nowiki>" истифода шудааст.',
	'renameusererrorinvalid'      => 'Номи корбарӣ "<nowiki>$1</nowiki>" ғайри миҷоз аст.',
	'renameusererrortoomany'      => 'Корбар "<nowiki>$1</nowiki>" $2 ҳиссагузориҳо дорад, тағйири номи корбаре, ки беш аз $3 ҳиссагузориҳо дорад ва ба амал кардани сомона таъсире мушкилӣ метавонад расонад.',
	'renameuser-error-request'    => 'Дар дарёфти дархост мушкилие пеш омад. Лутфан ба саҳифаи қаблӣ бозгардед ва дубора талош кунед.',
	'renameuser-error-same-user'  => 'Шумо наметавонед номи як корбарро ба ҳамон номи қаблиаш тағйир диҳед.',
	'renameusersuccess'           => 'Номи корбар "<nowiki>$1</nowiki>" ба "<nowiki>$2</nowiki>" тағйир ёфт.',
	'renameuser-page-exists'      => 'Саҳифаи $1 аллакай вуҷуд дорда ва ба таври худкор қобили бознависӣ нест.',
	'renameuser-page-moved'       => 'Саҳифаи $1 ба $2 кӯчонида шуд.',
	'renameuser-page-unmoved'     => 'Имкони кӯчонидани саҳифаи $1 ба $2 вуҷуд надорад.',
	'renameuserlogpage'           => 'Гузориши тағйири номи корбар',
	'renameuserlogpagetext'       => 'Ин гузориши тағйири номи корбарон аст',
	'renameuserlogentry'          => 'номи $1ро ба "$2" тағйир дод',
	'renameuser-log'              => '{{PLURAL:$1|1 вироиш|$1 вироишҳо}}. Далел: $2',
	'renameuser-move-log'         => 'Саҳифа дар вақти тағйири номи корбар  "[[User:$1|$1]]" ба "[[User:$2|$2]]" ба таври худкор кӯчонида шуд',
	'right-renameuser'            => 'Тағйири номи корбарон',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'renameuser-error-request' => 'มีปัญหาเกิดขึ้นเกี่ยวกับการรับคำเรียกร้องของคุณ กรุณากลับไปที่หน้าเดิม และ พยายามอีกครั้ง',
	'renameusersuccess'        => 'ผู้ใช้:<nowiki>$1</nowiki> ถูกเปลี่ยนชื่อเป็น ผู้ใช้:<nowiki>$2</nowiki> เรียบร้อยแล้ว',
);

/** Tonga (faka-Tonga)
 * @author SPQRobin
 */
$messages['to'] = array(
	'renameuser'                  => 'Liliu hingoa ʻo e ʻetita',
	'renameuserold'               => 'Hingoa motuʻa ʻo e ʻetita:',
	'renameusernew'               => 'Hingoa foʻou ʻo e ʻetita:',
	'renameusersubmit'            => 'Fai ā liliuhingoa',
	'renameusererrordoesnotexist' => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku ʻikai toka tuʻu ia',
	'renameusererrorexists'       => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku toka tuʻu ia',
	'renameusererrorinvalid'      => 'ʻOku taʻeʻaonga ʻa e hingoa fakaʻetita ko "<nowiki>$1</nowiki>"',
	'renameusersuccess'           => 'Ko e ʻetita "<nowiki>$1</nowiki>" kuo liliuhingoa ia kia "<nowiki>$2</nowiki>"',
	'renameuserlogpage'           => 'Tohinoa ʻo e liliu he hingoa ʻo e ʻetita',
	'renameuserlogpagetext'       => 'Ko e tohinoa ʻeni ʻo e ngaahi liliu ki he hingoa ʻo e kau ʻetita',
);

/** Turkish (Türkçe)
 * @author Uğur Başak
 * @author Karduelis
 * @author Runningfridgesrule
 * @author SPQRobin
 */
$messages['tr'] = array(
	'renameuser'                  => 'Kullanıcı adı değiştir',
	'renameuserold'               => 'Şu anda ki kullanıcı adı:',
	'renameusernew'               => 'Yeni kullanıcı adı:',
	'renameuserreason'            => 'Neden:',
	'renameusersubmit'            => 'Gönder',
	'renameusererrordoesnotexist' => '"<nowiki>$1</nowiki>" adlı kullanıcı bulunmamaktadır.',
	'renameusersuccess'           => 'Daha önce "<nowiki>$1</nowiki>" olarak kayıtlı kullanıcının rumuzu "<nowiki>$2</nowiki>" olarak değiştirilmiştir.',
	'renameuserlogpage'           => 'Kullanıcı adı değişikliği kayıtları',
	'renameuserlogpagetext'       => 'Aşağıda bulunan liste adı değiştirilmiş kullanıcıları gösterir.',
	'renameuserlogentry'          => '$1 → "$2" isim değişikliği yapıldı',
	'renameuser-log'              => '{{PLURAL:$1|1 düzenleme|$1 düzenleme}}. Neden: $2',
	'right-renameuser'            => 'Kullaıcılarının adlarını değiştir',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author EugeneZelenko
 */
$messages['uk'] = array(
	'renameuser'                  => 'Перейменувати користувача',
	'renameuser-desc'             => "Перейменування користувача (потрібні права ''renameuser'')",
	'renameuserold'               => "Поточне ім'я:",
	'renameusernew'               => "Нове ім'я:",
	'renameuserreason'            => 'Причина перейменування:',
	'renameusermove'              => 'Перейменувати також сторінку користувача, сторінку обговорення та їхні підсторінки',
	'renameusersubmit'            => 'Виконати',
	'renameusererrordoesnotexist' => 'Користувач з іменем «<nowiki>$1</nowiki>» не зареєстрований.',
	'renameusererrorexists'       => 'Користувач з іменем «<nowiki>$1</nowiki>» уже зареєстрований.',
	'renameusererrorinvalid'      => "Недопустиме ім'я користувача: <nowiki>$1</nowiki>.",
	'renameusererrortoomany'      => 'Користувач <nowiki>$1</nowiki> вніс $2 редагувань, перейменування користувача з більш ніж $3 редагуваннями може негативно вплинути на доступ до сайту.',
	'renameuser-error-request'    => 'Виникли ускладнення з отриманням запиту. Будь ласка, поверніться назад і повторіть іще раз.',
	'renameuser-error-same-user'  => "Ви не можете змінити ім'я користувача на те саме, що було раніше.",
	'renameusersuccess'           => 'Користувач «<nowiki>$1</nowiki>» був перейменований на «<nowiki>$2</nowiki>».',
	'renameuser-page-exists'      => 'Сторінка $1 вже існує і не може бути перезаписана автоматично.',
	'renameuser-page-moved'       => 'Сторінка $1 була перейменована на $2.',
	'renameuser-page-unmoved'     => 'Сторінка $1 не може бути перейменована на $2.',
	'renameuserlogpage'           => 'Журнал перейменувань користувачів',
	'renameuserlogpagetext'       => 'Це журнал здійснених перейменувань зареєстрованих користувачів.',
	'renameuserlogentry'          => 'перейменував $1 на «$2»',
	'renameuser-log'              => 'мав $1 {{PLURAL:$1|редагування|редагування|редагувань}}. Причина: $2',
	'renameuser-move-log'         => 'Автоматичне перейменування сторінки при перейменуванні користувача «[[User:$1|$1]]» на «[[User:$2|$2]]»',
	'right-renameuser'            => 'Перейменування користувачів',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'renameuser'     => 'صارف کا نام تبدیل کریں',
	'renameuser-log' => 'جن کی $1 ترامیم تھیں. $2',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Andre Engels
 */
$messages['vec'] = array(
	'renameuser'                  => 'Rinomina utente',
	'renameuser-desc'             => "Funsion par rinominar un utente (ghe vole i diriti de ''renameuser'')",
	'renameuserold'               => 'Vecio nome utente:',
	'renameusernew'               => 'Novo nome utente:',
	'renameuserreason'            => 'Motivo del canbio nome',
	'renameusermove'              => 'Rinomina anca la pagina utente, la pagina de discussion e le relative sotopagine',
	'renameuserwarnings'          => 'Avertimenti:',
	'renameuserconfirm'           => "Sì, rinomina l'utente",
	'renameusersubmit'            => 'Invia',
	'renameusererrordoesnotexist' => 'El nome utente "<nowiki>$1</nowiki>" no l\'esiste',
	'renameusererrorexists'       => 'El nome utente "<nowiki>$1</nowiki>" l\'esiste de zà',
	'renameusererrorinvalid'      => 'El nome utente "<nowiki>$1</nowiki>" no\'l xe mìa valido.',
	'renameusererrortoomany'      => 'El nome utente "<nowiki>$1</nowiki>" el gà $2 contributi. Modificar el nome de un utente con piassè de $3 contributi podarìà conprométar le prestazion del sito.',
	'renameuser-error-request'    => 'Se gà verificà un problema ne la ricezion de la richiesta. Torna indrìo e ripróa da novo.',
	'renameuser-error-same-user'  => "No se pol rinominar un utente al stesso nome che'l gavea zà.",
	'renameusersuccess'           => 'El nome utente "<nowiki>$1</nowiki>" el xe stà canbià in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'La pagina $1 la esiste de zà; no se pole sovrascrìvarla automaticamente.',
	'renameuser-page-moved'       => 'La pagina $1 la xe stà spostà a $2.',
	'renameuser-page-unmoved'     => 'No se pole spostar la pagina $1 a $2.',
	'renameuserlogpage'           => 'Registro dei utenti rinominà',
	'renameuserlogpagetext'       => 'De seguito vien presentà el registro de le modifiche ai nomi utente',
	'renameuserlogentry'          => 'gà rinominà $1 in "$2"',
	'renameuser-log'              => '{{PLURAL:$1|1 contributo|$1 contributi}}. Motivo: $2',
	'renameuser-move-log'         => 'Spostamento automatico de la pagina - utente rinominà da "[[User:$1|$1]]" a "[[User:$2|$2]]"',
	'right-renameuser'            => 'Rinomina utenti',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'renameuser'                  => 'Đổi tên thành viên',
	'renameuser-desc'             => "Đổi tên thành viên (cần có quyền ''renameuser'')",
	'renameuserold'               => 'Tên hiệu hiện nay:',
	'renameusernew'               => 'Tên hiệu mới:',
	'renameuserreason'            => 'Lý do đổi tên:',
	'renameusermove'              => 'Di chuyển trang thành viên và thảo luận thành viên (cùng với trang con của nó) sang tên mới',
	'renameuserwarnings'          => 'Cảnh báo:',
	'renameuserconfirm'           => 'Đổi tên người dùng',
	'renameusersubmit'            => 'Thực hiện',
	'renameusererrordoesnotexist' => 'Thành viên “<nowiki>$1</nowiki>” không tồn tại.',
	'renameusererrorexists'       => 'Thành viên “<nowiki>$1</nowiki>” đã hiện hữu.',
	'renameusererrorinvalid'      => 'Tên thành viên “<nowiki>$1</nowiki>” không hợp lệ.',
	'renameusererrortoomany'      => 'Thành viên “<nowiki>$1</nowiki>” có $2 đóng góp, đổi tên thành viên có hơn $3 đóng góp có thể ảnh hưởng xấu đến hiệu năng của trang.',
	'renameuser-error-request'    => 'Có trục trặc trong tiếp nhận yêu cầu. Xin hãy quay lại và thử lần nữa.',
	'renameuser-error-same-user'  => 'Bạn không thể đổi tên thành viên sang tên y hệt như vậy.',
	'renameusersuccess'           => 'Thành viên “<nowiki>$1</nowiki>” đã được đổi tên thành “<nowiki>$2</nowiki>”.',
	'renameuser-page-exists'      => 'Trang $1 đã tồn tại và không thể bị tự động ghi đè.',
	'renameuser-page-moved'       => 'Trang $1 đã được di chuyển đến $2.',
	'renameuser-page-unmoved'     => 'Trang $1 không thể di chuyển đến $2.',
	'renameuserlogpage'           => 'Nhật trình đổi tên thành viên',
	'renameuserlogpagetext'       => 'Đây là nhật trình ghi lại các thay đổi đối với tên thành viên',
	'renameuserlogentry'          => 'đã đổi tên $1 thành “$2”',
	'renameuser-log'              => '{{PLURAL:$1|1 sửa đổi|$1 sửa đổi}}. Lý do: $2',
	'renameuser-move-log'         => 'Đã tự động di chuyển trang khi đổi tên thành viên “[[User:$1|$1]]” thành “[[User:$2|$2]]”',
	'right-renameuser'            => 'Đổi tên thành viên',
);

/** Volapük (Volapük)
 * @author Smeira
 * @author Malafaya
 */
$messages['vo'] = array(
	'renameuser'                  => 'Votanemön gebani',
	'renameuser-desc'             => "Votanemön gebani (gität: ''renameuser'' zesüdon)",
	'renameuserold'               => 'Gebananem anuik:',
	'renameusernew'               => 'Gebananem nulik:',
	'renameuserreason'            => 'Kod votanemama:',
	'renameusermove'              => 'Topätükön padi e bespikapadi gebana (e donapadis onsik) ad nem nulik',
	'renameusersubmit'            => 'Sedön',
	'renameusererrordoesnotexist' => 'Geban: "<nowiki>$1</nowiki>" no dabinon.',
	'renameusererrorexists'       => 'Geban: "<nowiki>$1</nowiki>" ya dabinon.',
	'renameusererrorinvalid'      => 'Gebananem: "<nowiki>$1</nowiki>" no lonöfon.',
	'renameusererrortoomany'      => 'Geban: "<nowiki>$1</nowiki>" labon keblünotis $2. Votanemam gebana labü keblünots plu $3 ba oflunon negudiko jäfidi bevüresodatopäda at.',
	'renameuser-error-request'    => 'Ädabinon säkäd pö daget bega. Geikolös, begö! e steifülolös dönu.',
	'renameuser-error-same-user'  => 'No kanol votanemön gebani ad nem ot.',
	'renameusersuccess'           => 'Geban: "<nowiki>$1</nowiki>" pevotanemon ad "<nowiki>$2</nowiki>".',
	'renameuser-page-exists'      => 'Pad: $1 ya dabinon e no kanon pamoükön itjäfidiko.',
	'renameuser-page-moved'       => 'Pad: $1 petopätükon ad pad: $2.',
	'renameuser-page-unmoved'     => 'No eplöpos ad topätükön padi: $1 ad pad: $2.',
	'renameuserlogpage'           => 'Jenotalised votanemamas',
	'renameuserlogpagetext'       => 'Is palisedons votükams gebananemas.',
	'renameuserlogentry'          => 'evotanemon eli $1 ad "$2"',
	'renameuser-log'              => '{{PLURAL:$1|redakam 1|redakams $1}}. Kod: $2',
	'renameuser-move-log'         => 'Pad petopätükon itjäfidiko dü votanemama gebana: "[[User:$1|$1]]" ad "[[User:$2|$2]]"',
);

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'renameuser'                  => 'Rilomer èn uzeu',
	'renameuserold'               => "No d' elodjaedje pol moumint:",
	'renameusernew'               => "Novea no d' elodjaedje:",
	'renameuserreason'            => 'Råjhon pol rilomaedje:',
	'renameusermove'              => "Displaecî les pådjes d' uzeu et d' copene (eyet leus dzo-pådjes) viè l' novea no",
	'renameusersubmit'            => 'Evoye',
	'renameusererrordoesnotexist' => "L' uzeu «<nowiki>$1</nowiki>» n' egzistêye nén",
	'renameusererrorexists'       => "L' uzeu «<nowiki>$1</nowiki>» egzistêye dedja",
	'renameusererrorinvalid'      => "Li no d' elodjaedje «<nowiki>$1</nowiki>» n' est nén on no valide",
	'renameusererrortoomany'      => "L' uzeu «<nowiki>$1</nowiki>» a $2 contribouwaedjes, rilomer èn uzeu avou pus di $3 contribouwaedjes pout aveur des consecwinces sol performance del waibe",
	'renameusersuccess'           => "L' uzeu «<nowiki>$1</nowiki>» a stî rlomé a «<nowiki>$2</nowiki>»",
	'renameuser-page-exists'      => "Li pådje $1 egzistêye dedja et n' pout nén esse otomaticmint spotcheye.",
	'renameuser-page-moved'       => 'Li pådje $1 a stî displaeceye viè $2.',
	'renameuser-page-unmoved'     => 'Li pådje $1 èn pout nén esse displaeceye viè $2.',
	'renameuserlogpage'           => "Djournå des candjmints d' no d' uzeus",
	'renameuserlogpagetext'       => "Chal pa dzo c' est ene djivêye des uzeus k' ont candjî leu no d' elodjaedje.",
	'renameuser-log'              => "k' aveut ddja fwait $1 candjmints. $2",
	'renameuser-move-log'         => "Pådje displaeceye otomaticmint tot rlomant l' uzeu «[[User:$1|$1]]» viè «[[User:$2|$2]]»",
);

/** Yue (粵語) */
$messages['yue'] = array(
	'renameuser'                  => '改用戶名',
	'renameuser-desc'             => "幫用戶改名 (需要 ''renameuser'' 權限)",
	'renameuserold'               => '現時嘅用戶名:',
	'renameusernew'               => '新嘅用戶名:',
	'renameuserreason'            => '改名嘅原因:',
	'renameusermove'              => '搬用戶頁同埋佢嘅對話頁（同埋佢哋嘅細頁）到新名',
	'renameuserwarnings'          => '警告:',
	'renameuserconfirm'           => '係，改呢個用戶名',
	'renameusersubmit'            => '遞交',
	'renameusererrordoesnotexist' => '用戶"<nowiki>$1</nowiki>"唔存在',
	'renameusererrorexists'       => '用戶"<nowiki>$1</nowiki>"已經存在',
	'renameusererrorinvalid'      => '用戶名"<nowiki>$1</nowiki>"唔正確',
	'renameusererrortoomany'      => '用戶"<nowiki>$1</nowiki>"貢獻咗$2次，對改一個超過$3次的用戶名嘅用戶可能會影響網站嘅效能',
	'renameuser-error-request'    => '響收到請求嗰陣出咗問題。
請返去再試過。',
	'renameuser-error-same-user'  => '你唔可以改一位用戶係同之前嘅嘢一樣。',
	'renameusersuccess'           => '用戶"<nowiki>$1</nowiki>"已經改咗名做"<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => '$1呢一版已經存在，唔可以自動重寫。',
	'renameuser-page-moved'       => '$1呢一版已經搬到去$2。',
	'renameuser-page-unmoved'     => '$1呢一版唔能夠搬到去$2。',
	'renameuserlogpage'           => '用戶改名日誌',
	'renameuserlogpagetext'       => '呢個係改用戶名嘅日誌',
	'renameuserlogentry'          => '已經幫 $1 改咗名做 "$2"',
	'renameuser-log'              => '擁有$1次編輯。 原因: $2',
	'renameuser-move-log'         => '當由"[[User:$1|$1]]"改名做"[[User:$2|$2]]"嗰陣已經自動搬咗用戶頁',
	'right-renameuser'            => '改用戶名',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'renameuser'                  => '用户重命名',
	'renameuser-desc'             => "为用户重命名 (需要 ''renameuser'' 权限)",
	'renameuserold'               => '当前用户名:',
	'renameusernew'               => '新用户名:',
	'renameuserreason'            => '重命名的原因:',
	'renameusermove'              => '移动用户页及其对话页（包括各子页）到新的名字',
	'renameuserwarnings'          => '警告:',
	'renameuserconfirm'           => '是，为用户重命名',
	'renameusersubmit'            => '提交',
	'renameusererrordoesnotexist' => '用户"<nowiki>$1</nowiki>"不存在',
	'renameusererrorexists'       => '用户"<nowiki>$1</nowiki>"已存在',
	'renameusererrorinvalid'      => '用户名"<nowiki>$1</nowiki>"不可用',
	'renameusererrortoomany'      => '用户"<nowiki>$1</nowiki>"贡献了$2次，重命名一个超过$3次的用户会影响站点性能',
	'renameuser-error-request'    => '在收到请求时出现问题。
请回去重试。',
	'renameuser-error-same-user'  => '您不可以更改一位用户是跟之前的东西一样。',
	'renameusersuccess'           => '用户"<nowiki>$1</nowiki>"已经更名为"<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => '$1这一页己经存在，不能自动覆写。',
	'renameuser-page-moved'       => '$1这一页已经移动到$2。',
	'renameuser-page-unmoved'     => '$1这一页不能移动到$2。',
	'renameuserlogpage'           => '用户名变更日志',
	'renameuserlogpagetext'       => '这是用户名更改的日志',
	'renameuserlogentry'          => '已经把 $1 重命名为 "$2"',
	'renameuser-log'              => '拥有$1次编辑。 理由: $2',
	'renameuser-move-log'         => '当由"[[User:$1|$1]]"重命名作"[[User:$2|$2]]"时已经自动移动用户页',
	'right-renameuser'            => '重新命名用户',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'renameuser'                  => '用戶重新命名',
	'renameuser-desc'             => "為用戶重新命名 (需要 ''renameuser'' 權限)",
	'renameuserold'               => '現時用戶名:',
	'renameusernew'               => '新用戶名:',
	'renameuserreason'            => '重新命名的原因:',
	'renameusermove'              => '移動用戶頁及其對話頁（包括各子頁）到新的名字',
	'renameuserwarnings'          => '警告:',
	'renameuserconfirm'           => '是，為用戶重新命名',
	'renameusersubmit'            => '提交',
	'renameusererrordoesnotexist' => '用戶"<nowiki>$1</nowiki>"不存在',
	'renameusererrorexists'       => '用戶"<nowiki>$1</nowiki>"已存在',
	'renameusererrorinvalid'      => '用戶名"<nowiki>$1</nowiki>"不可用',
	'renameusererrortoomany'      => '用戶"<nowiki>$1</nowiki>"貢獻了$2次，重新命名一個超過$3次的用戶會影響網站效能',
	'renameuser-error-request'    => '在收到請求時出現問題。
請回去重試。',
	'renameuser-error-same-user'  => '您不可以更改一位用戶是跟之前的東西一樣。',
	'renameusersuccess'           => '用戶"<nowiki>$1</nowiki>"已經更名為"<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => '$1這一頁己經存在，不能自動覆寫。',
	'renameuser-page-moved'       => '$1這一頁已經移動到$2。',
	'renameuser-page-unmoved'     => '$1這一頁不能移動到$2。',
	'renameuserlogpage'           => '用戶名變更日誌',
	'renameuserlogpagetext'       => '這是用戶名更改的日誌',
	'renameuserlogentry'          => '已經把 $1 重新命名為 "$2"',
	'renameuser-log'              => '擁有$1次編輯。 理由: $2',
	'renameuser-move-log'         => '當由"[[User:$1|$1]]"重新命名作"[[User:$2|$2]]"時已經自動移動用戶頁',
	'right-renameuser'            => '重新命名用戶',
);

/** Zulu (isiZulu)
 * @author SPQRobin
 */
$messages['zu'] = array(
	'renameusersubmit' => 'Yisa',
);

