<?php
/**
 * Internationalisation file for extension AntiSpoof.
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();

$messages['en'] = array(
	'antispoof-desc' => 'Blocks the creation of accounts with mixed-script, confusing and similar usernames',
	'antispoof-conflict-top' => 'The name "$1" is too similar to {{PLURAL:$2|the existing account|the following $2 accounts}}:',
	'antispoof-conflict-item' => '$1',
	'antispoof-conflict-bottom' => 'Please choose another name.',
	'antispoof-name-illegal' => 'The name "$1" is not allowed to prevent confusing or spoofed usernames: $2.
Please choose another name.',
	'antispoof-badtype' => 'Bad data type',
	'antispoof-empty' => 'Empty string',
	'antispoof-blacklisted' => 'Contains blacklisted character',
	'antispoof-combining' => 'Begins with combining mark',
	'antispoof-unassigned' => 'Contains unassigned or deprecated character',
	'antispoof-noletters' => 'Does not contain any letters',
	'antispoof-mixedscripts' => 'Contains incompatible mixed scripts',
	'antispoof-tooshort' => 'Canonicalized name too short',
	'antispoof-ignore' => 'Ignore spoofing checks',
	'right-override-antispoof' => 'Override the spoofing checks',
);

/** Message documentation (Message documentation)
 * @author Beau
 * @author Siebrand
 * @author Titoxd
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'antispoof-desc' => 'Used in [[Special:Version]] as the description for [[mw:Extension:AntiSpoof|Extension:AntiSpoof]]',
	'antispoof-conflict-top' => 'Account creation error message because attempted username is too similar to existing username(s). Parameters:
* $1 is the username that someone wanted to create
* $2 are the usernames that already existed that triggered the error.',
	'antispoof-conflict-bottom' => 'Suggestion for user that tried to create a user with a name that was not accepted.',
	'antispoof-name-illegal' => 'Account creation error message because a user account creation rule was violated. Parameters:
* $1 is the username that someone wanted to create
* $2 is the error message. One of {{msg-mw|antispoof-badtype}}, {{msg-mw|antispoof-empty}}, {{msg-mw|antispoof-blacklisted}} and others.',
	'antispoof-badtype' => 'Reason for failed account creation.',
	'antispoof-empty' => 'Reason for failed account creation.',
	'antispoof-blacklisted' => 'Reason for failed account creation.',
	'antispoof-combining' => 'Reason for failed account creation.',
	'antispoof-unassigned' => 'Reason for failed account creation.',
	'antispoof-noletters' => 'Reason for failed account creation.',
	'antispoof-mixedscripts' => 'Reason for failed account creation.',
	'antispoof-tooshort' => 'Reason for failed account creation.',
	'antispoof-ignore' => 'This is a checkbox shown on [[Special:UserLogin|a signup page]] when a user with both [[MediaWiki:Right-createaccount/qqq|createaccount]] and [[MediaWiki:Right-override-antispoof/qqq|override-antispoof]] rights tries to register a new user account. It allows to register a username that would otherwise be blocked by the [[mw:Extension:AntiSpoof|AntiSpoof extension]].',
	'right-override-antispoof' => '{{doc-right|override-antispoof}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'antispoof-desc' => 'Blokke van die skepping van rekeninge met gemengde-script, verwarrend en soortgelyke gebruikersname',
	'antispoof-conflict-top' => 'Die naam "$1" lyk te soortgelyk aan die van die volgende bestaande {{PLURAL:$2|gebruiker|$2 gebruikers}}:',
	'antispoof-conflict-bottom' => "Kies asseblief 'n ander naam.",
	'antispoof-badtype' => 'Verkeerde datatipe',
	'antispoof-empty' => 'Leë string',
	'antispoof-blacklisted' => 'Bevat verbode karakter',
	'antispoof-combining' => "Begin met 'n gekombineerde merker",
	'antispoof-unassigned' => 'Bevat nie toegekende of verouderde karakter',
	'antispoof-noletters' => 'Bevat geen letters nie',
	'antispoof-mixedscripts' => 'Bevat onverenigbaar gemengde skrifte',
	'antispoof-tooshort' => 'Afgekorte naam te kort',
	'antispoof-ignore' => 'Ignoreer spoofing tjeks',
	'right-override-antispoof' => 'Ignoreer die spoofing tjeks',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'antispoof-desc' => 'Bllokon krijimin e llogarive me script-të përziera, konfuze dhe të ngjashme përdoruesve',
	'antispoof-conflict-top' => 'Emrin "$1" është shumë e ngjashme me {{PLURAL:$2|llogari ekzistuese|mëposhtme $2 llogaritë}}:',
	'antispoof-conflict-bottom' => 'Ju lutem zgjidhni një tjetër.',
	'antispoof-name-illegal' => 'Emrin "$1" nuk është e lejuar për të parandaluar ose spoofed përdoruesve konfuze: $2. Ju lutem zgjidhni një tjetër.',
	'antispoof-badtype' => 'Bad dhënat lloj',
	'antispoof-empty' => 'string bosh',
	'antispoof-blacklisted' => 'Përmban në listën e zezë karakter',
	'antispoof-combining' => 'Fillon me shenjën e kombinuar',
	'antispoof-unassigned' => 'Përmban unassigned ose deprecated karakter',
	'antispoof-noletters' => 'Nuk përmban asnjë shkronja',
	'antispoof-mixedscripts' => 'Përmban Scripts papajtueshëm të përziera',
	'antispoof-tooshort' => 'Emri Canonicalized shumë i shkurtër',
	'antispoof-ignore' => 'Ignore spoofing kontrolle',
	'right-override-antispoof' => 'Refuzim spoofing kontrolle',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'antispoof-desc' => "Bloqueya a creyación de cuentas confusas, con tipografía mezclata y nombres d'usuario parellanos.",
	'antispoof-conflict-top' => "O nombre «$1» ye masiau semellant a o d'{{PLURAL:$2|ista cuenta existent|istas $2 cuentas existents}}:",
	'antispoof-conflict-bottom' => 'Esleiga belatro nombre, por favor.',
	'antispoof-name-illegal' => 'No se premite rechistrar-se con o nombre "$1" ta privar confusions y suplantacions con os nombres d\'usuario: $2. Por favor, esliya una atro nombre.',
	'antispoof-badtype' => 'Tipo de datos no conforme',
	'antispoof-empty' => 'Cadena vueda',
	'antispoof-blacklisted' => 'Contiene carácters no premititos',
	'antispoof-combining' => 'Prencipia con un sinyal combinatorio',
	'antispoof-unassigned' => 'Contiene carácters no conformes u obsoletos',
	'antispoof-noletters' => 'No contiene garra letra',
	'antispoof-mixedscripts' => 'Contiene un mezclallo incompatible de scripts',
	'antispoof-tooshort' => 'Nombre canonico masiau curto',
	'antispoof-ignore' => 'Ignorar as comprebacions de spoofing',
	'right-override-antispoof' => "Ignorar as prebas d'identidat",
);

/** Old English (Ænglisc)
 * @author Wōdenhelm
 */
$messages['ang'] = array(
	'antispoof-noletters' => 'Ġehæfþ nān stafas',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mido
 * @author Mimouni
 * @author محمد الجداوي
 */
$messages['ar'] = array(
	'antispoof-desc' => 'يمنع إنشاء الحسابات بسكريبت مختلط، وبأسماء مشابهة ومربكة',
	'antispoof-conflict-top' => 'الاسم "$1" شديد الشبه ب{{PLURAL:$2|الحساب الموجود|ال$2 حساب التالية}}:',
	'antispoof-conflict-bottom' => 'من فضلك اختر اسما آخر.',
	'antispoof-name-illegal' => 'الاسم "$1" غير مسموح به لمنع الخلط وانتحال أسماء المستخدمين: $2.
من فضلك اختر اسم آخر.',
	'antispoof-badtype' => 'نوع بيانات خاطئ',
	'antispoof-empty' => 'سلسلة فارغة',
	'antispoof-blacklisted' => 'يحتوي على حرف في القائمة السوداء',
	'antispoof-combining' => 'يبدأ بعلامة مختلطة',
	'antispoof-unassigned' => 'يحتوي على حرف غير مخصص أو غير مقبول',
	'antispoof-noletters' => 'لا يحتوي على أية حروف',
	'antispoof-mixedscripts' => 'يحتوي على سكريبتات غير متوافقة مختلطة',
	'antispoof-tooshort' => 'الاسم المستخدم قصير جدًا',
	'antispoof-ignore' => 'تجاهل التحقق من التشابه',
	'right-override-antispoof' => 'تجاوز التحقق من سبوفينج',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Man2fly2002
 */
$messages['arc'] = array(
	'antispoof-conflict-bottom' => 'ܦܝܣܐ ܡܢܟ ܓܒܝ ܚܕ ܫܡܐ ܐܚܪܝܢܐ.',
	'antispoof-noletters' => 'ܠܐ ܚܒܫ ܐܬܘܬܐ ܡܕܡ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'antispoof-desc' => 'بيمنع فتح حسابات بأسامى يوزرز متشابهة،و بتلخبط أو بسكريبت متخلط',
	'antispoof-conflict-top' => 'الاسم "$1" شديد الشبه ب{{PLURAL:$2|الحساب الموجود|ال$2 حساب التالية}}:',
	'antispoof-conflict-bottom' => 'من فضلك اختر اسما آخر.',
	'antispoof-name-illegal' => 'الاسم "$1"  مش مسموح علشان نمنع اللخبطة أوانتحال أسماء اليوزرز: $2. لو سمحت تختار اسم تانى.',
	'antispoof-badtype' => 'نوع البيانات غلط',
	'antispoof-empty' => 'سلسلة فاضية',
	'antispoof-blacklisted' => 'بيحتوى على علامة من البلاك ليست',
	'antispoof-combining' => 'بيبتدى بعلامة مختلطة',
	'antispoof-unassigned' => 'بيحتوى على علامة مش مخصصة أو مش مقبولة',
	'antispoof-noletters' => 'ما بيحتويش على اى حروف',
	'antispoof-mixedscripts' => 'بيحتوى على سكريبتات مخلوطة مش متوافقة',
	'antispoof-tooshort' => 'الاسم المستعمل قصير خالص',
	'antispoof-ignore' => 'اتجاهل التشييك على سبوفينج',
	'right-override-antispoof' => 'اتجاوز التشييك على سبوفينج',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'antispoof-desc' => "Bloquea la creación de cuentes con script mistu que tengan nomes d'usuariu asemeyaos o confusos",
	'antispoof-conflict-top' => 'El nome "$1" ye demasiao asemeyáu a {{PLURAL:$2|la cuenta esistente|les siguientes $2 cuentes}}:',
	'antispoof-conflict-bottom' => 'Por favor escueyi otru nome.',
	'antispoof-name-illegal' => 'Nun se permite\'l nome "$1" pa evitar nomes d\'usuariu confusos o paródicos: $2. Por favor escueyi otru nome.',
	'antispoof-badtype' => 'Triba de datos incorreuta',
	'antispoof-empty' => 'Testu vaciu',
	'antispoof-blacklisted' => 'Contién un caráuter prohibíu',
	'antispoof-combining' => 'Empecipia con una marca combinada',
	'antispoof-unassigned' => 'Contién un caráuter non asignáu o obsoletu',
	'antispoof-noletters' => 'Nun contién nenguna lletra',
	'antispoof-mixedscripts' => 'Contién munchos scripts incompatibles',
	'antispoof-tooshort' => 'Nome canónicu demasiao curtiu',
	'antispoof-ignore' => "Inorar les comprobaciones d'engañu (spoofing)",
	'right-override-antispoof' => "Saltase les comprobaciones d'engañu (spoofing)",
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'antispoof-badtype' => 'Origordaj',
	'antispoof-empty' => 'Vlardafa roda',
	'antispoof-noletters' => 'Va mek eltay ruldar',
);

/** Azerbaijani (Azərbaycanca)
 * @author Vugar 1981
 */
$messages['az'] = array(
	'antispoof-desc' => 'Digər hesablarla qarışmamamq üçün fərqli yazı sistemindən ibarət olan simvollarla yaradılmış hesabların açılması qadağandır',
	'antispoof-conflict-top' => '«$1» adı {{PLURAL:$2|$2 mövcud hesab|$2 mövcud hesab|$2 mövcud hesaba}} çox bənzəyir:',
	'antispoof-conflict-bottom' => 'Zəhmət olmasa başqa ad seçin.',
	'antispoof-name-illegal' => '$2 hesabıyla qarışmaması üçün "$1" adına icazə verilmir. Zəhmət olmasa başqa istifadəçi adını seçin.',
	'antispoof-badtype' => 'Yanlış məlumat',
	'antispoof-empty' => 'Boş sətir',
	'antispoof-blacklisted' => 'Qadağan edilmiş siyahının simvollarından istifadə edilmişdir',
	'antispoof-combining' => 'Birləşdirmə işarəsindən başlayır',
	'antispoof-unassigned' => 'Qeyri-müəyyən yaxud dəstəklənməyən simvollardan istifadə edilir',
	'antispoof-noletters' => 'Heç bir hərf yoxdur',
	'antispoof-mixedscripts' => 'Qəbul edilməz yazı sistemi işlədilir',
	'antispoof-tooshort' => 'Normallaşdırılmış ad çox qısadır',
	'antispoof-ignore' => 'Oxşar adlar yoxlanmasına məhəl qoymamaq',
	'right-override-antispoof' => 'Oxşar adlar yoxlanmasına məhəl qoymamaq',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'antispoof-desc' => 'Төрлө яҙма системаларының хәрефтәренән торған, яңылыштырырлыҡ һәм башҡа ҡатнашыусы исемдәренән оҡшаш исемле иҫәп яҙмаларҙы булдырыуҙы тыя.',
	'antispoof-conflict-top' => '"$1" исеме түбәндәге {{PLURAL:$2|иҫәп яҙмаһына|$2 иҫәп яҙмаһына }} бигерәк оҡшаш:',
	'antispoof-conflict-bottom' => 'Зинһар, башҡа исем һайлағыҙ.',
	'antispoof-name-illegal' => '"$1" исемен ҡүлланыу түбәндәге оҡшаш исемдәр менән бутамау өсөн тыйылған: $2.
Зинһар, башҡа исем һайлағыҙ.',
	'antispoof-badtype' => 'Мәғлүмәт төрө дөрөҫ түгел',
	'antispoof-empty' => 'Буш юл',
	'antispoof-blacklisted' => 'Тыйылған хәрефтәр исемлегенән хәреф бар.',
	'antispoof-combining' => 'Берләштереү билдәһе менән башлана',
	'antispoof-unassigned' => 'Билдәһеҙ йәки рөхсәт ителмәгән хәреф бар',
	'antispoof-noletters' => 'Бер хәреф тә юҡ',
	'antispoof-mixedscripts' => 'Берләштереү мөмкин булмаған яҙма системаларының хәрефтәре бар',
	'antispoof-tooshort' => 'Ҡанунлаштырылған исем бигерәк ҡыҫҡа',
	'antispoof-ignore' => 'Оҡшаш исемдәргә тикшереүҙе иғтибарға алмаҫҡа',
	'right-override-antispoof' => 'Оҡшаш исемдәргә тикшереүҙе иғтибарһыҙ ҡалдырыу',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'antispoof-desc' => "Vahindert d' Erstöung voh Benutzerkontos mid gmischte Zeichenseetz, vawirrende und änliche Benutzernåmen",
	'antispoof-conflict-top' => "Da Nåm „$1“ ist {{PLURAL:$2|'m existiarerten Benutzerkonto|de foigenden $2 Benutzerkontos}} z' änle:",
	'antispoof-conflict-bottom' => 'Bittschee suach da an åndern Nåm aus',
	'antispoof-name-illegal' => 'Da ausgsuachte Benutzernåm „$1“ is ned dalaabt. Grund: $2<br />Bittschee an åndern Benutzernåmen aussuachen.',
	'antispoof-badtype' => 'Ungütiger Daatentyp',
	'antispoof-empty' => 'Laars Föd',
	'antispoof-blacklisted' => 'Es san ned dalaabte Zeichen enthoiden.',
	'antispoof-combining' => "Kombinazionszeichen z' Beginn.",
	'antispoof-unassigned' => 'Es san ned zuagordnate oder unerwynschte Zeichen enthoiden.',
	'antispoof-noletters' => 'Es san koane Buachstom enthoiden.',
	'antispoof-mixedscripts' => 'Es san Zeichen voh unterschiadliche Schriftsysteme enthoiden.',
	'antispoof-tooshort' => "Da kanonisiarde Nåm is z' kurz.",
	'antispoof-ignore' => "D' Änlichkeitspriaffung ignorirn",
	'right-override-antispoof' => "D' Benutzernåm-Änlichkeitspriaffung ausschoiden",
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'antispoof-desc' => 'شرکتن حساب گون پیچیدگین اسکریپ،  پیچیدگین و ساده این نام کاربری محدود کنت',
	'antispoof-name-illegal' => 'نام "$1" مجاز په بوتن په خاطر جلوگرگ چه پیچیدگین نام شرکتن نهنت$2.
لطفا یک دگه نامی انتخاب کنیت.',
	'antispoof-badtype' => 'بدین نوع دیتا',
	'antispoof-empty' => 'رشتگ حالیکین',
	'antispoof-blacklisted' => 'شامل لیست سیاهی کاراکتر',
	'antispoof-combining' => 'شروع بیت همراه گون علامت',
	'antispoof-unassigned' => 'شامل نامشخص یا کدیمی کاراکتریء',
	'antispoof-noletters' => 'شامل هچ حرفی نهنت',
	'antispoof-mixedscripts' => 'شامل نا سازین جمع اسکریپتانء',
	'antispoof-tooshort' => 'استاندارد این نام باز هوردن',
	'antispoof-ignore' => 'ندید گرگ کنترل په کلاهبرداری',
	'right-override-antispoof' => 'چه کنترلان کلاهبرداری رد بوت',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'antispoof-name-illegal' => 'An parágamit na "$1" dai tinotogotan tangarig maibitaran an pagparibong o pag-arog sa "$2". Paki pilî tabî nin ibang pangaran.',
	'antispoof-blacklisted' => 'Igwang blacklisted na karakter',
	'antispoof-combining' => 'Nagpopoon sa nagsasalak na marka',
	'antispoof-unassigned' => 'Igwang dai naka-assign o deprecated na karakter',
	'antispoof-noletters' => 'Mayong nakakaag na mga letra',
	'antispoof-mixedscripts' => 'Igwang dai angay na mga halong script',
);

/** Belarusian (Беларуская)
 * @author Хомелка
 */
$messages['be'] = array(
	'antispoof-desc' => 'Блакуе стварэнне рахункаў з імёнамі карыстальнікаў са змяшанымі раскладкамі, падобных ці тых, якія можна зблытаць',
	'antispoof-conflict-top' => 'Назва рахунку «$1» занадта падобная на $2 {{PLURAL:$2|існуючы рахунак|існуючыя рахункі|існуючых рахункаў}}:',
	'antispoof-conflict-bottom' => 'Калі ласка, выберыце іншую назву рахунку.',
	'antispoof-name-illegal' => 'Імя «$1» не дазволенае, каб прадухіліць блытаніну ці падробку імені ўдзельніка: $2. Калі ласка, абярыце іншае імя.',
	'antispoof-badtype' => 'Няслушны тып звестак',
	'antispoof-empty' => 'Пусты радок',
	'antispoof-blacklisted' => 'Утрымлівае забаронены сімвал',
	'antispoof-combining' => "Пачынаецца з аб'яднальнага знаку",
	'antispoof-unassigned' => 'Утрымлівае нявызначаны ці састарэлы сімвал',
	'antispoof-noletters' => 'Не ўтрымлівае ніводнай літары',
	'antispoof-mixedscripts' => 'Утрымлівае несумяшчальныя змяшаныя альфавіты',
	'antispoof-tooshort' => 'Нармалізаванае імя занадта кароткае',
	'antispoof-ignore' => 'Ігнараваць праверкі на падобнасць імёнаў',
	'right-override-antispoof' => 'ігнараванне праверак на падобныя назвы рахункаў',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'antispoof-desc' => 'Блякуе стварэньне рахункаў зь імёнамі карыстальнікаў са зьмяшаных альфабэтаў, падобных ці тых, якія можна зблытаць',
	'antispoof-conflict-top' => 'Назва рахунку «$1» занадта падобная на $2 {{PLURAL:$2|існуючы рахунак|існуючыя рахункі|існуючых рахункаў}}:',
	'antispoof-conflict-bottom' => 'Калі ласка, выберыце іншую назву рахунку.',
	'antispoof-name-illegal' => 'Імя «$1» не дазволенае, каб прадухіліць блытаніну ці падробку імені ўдзельніка: $2. Калі ласка, абярыце іншае імя.',
	'antispoof-badtype' => 'Няслушны тып зьвестак',
	'antispoof-empty' => 'Пусты радок',
	'antispoof-blacklisted' => 'Утрымлівае забаронены сымбаль',
	'antispoof-combining' => "Пачынаецца з аб'яднальнага знаку",
	'antispoof-unassigned' => 'Утрымлівае нявызначаны ці састарэлы сымбаль',
	'antispoof-noletters' => 'Ня ўтрымлівае ніводнай літары',
	'antispoof-mixedscripts' => 'Утрымлівае несумяшчальныя зьмяшаныя альфабэты',
	'antispoof-tooshort' => 'Нармалізаванае імя занадта кароткае',
	'antispoof-ignore' => 'Ігнараваць праверкі на падобнасьць імёнаў',
	'right-override-antispoof' => 'ігнараваньне праверак на падобныя назвы рахункаў',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'antispoof-desc' => 'Блокиране на създаването на сметки, изписани с различни писмени системи, объркващи или подобни на други потребителски имена',
	'antispoof-conflict-top' => 'Името „$1“ е твърде сходно с {{PLURAL:$2|вече съществуваща сметка|вече съществуващите $2 сметки}}:',
	'antispoof-conflict-bottom' => 'Изберете друго име.',
	'antispoof-name-illegal' => 'Името „$1“ не е разрешено за защита от объркване или злоупотреби с имена: $2. Моля, изберете друго име!',
	'antispoof-badtype' => 'Грешен тип на данните',
	'antispoof-empty' => 'Празен низ',
	'antispoof-blacklisted' => 'Съдържа забранен знак',
	'antispoof-combining' => 'Започва със съставен знак',
	'antispoof-unassigned' => 'Съдържа неопределен или нежелан знак',
	'antispoof-noletters' => 'Не съдържа букви',
	'antispoof-mixedscripts' => 'Съдържа несъвместими писмени системи',
	'antispoof-tooshort' => 'Каноничното име е твърде кратко',
);

/** Bihari (भोजपुरी)
 * @author Ganesh
 */
$messages['bh'] = array(
	'antispoof-conflict-bottom' => 'कृपया कउनो दुसर नाम चुनीं',
);

/** Bhojpuri (भोजपुरी)
 * @author Ganesh
 */
$messages['bho'] = array(
	'antispoof-conflict-bottom' => 'कृपया कउनो दुसर नाम चुनीं',
);

/** Banjar (Bahasa Banjar)
 * @author J Subhi
 */
$messages['bjn'] = array(
	'antispoof-desc' => 'Blukir paulahan akun bangaran pamuruk awan hurup-bacampur, mambingungakan, wan mirip',
	'antispoof-conflict-top' => 'Si ngaran "$1" kamiripan awan {{PLURAL:$2|akun nang sudah ada|$2 akun barikut}}:',
	'antispoof-conflict-bottom' => 'Muhun pilih ngaran nang lain.',
	'antispoof-name-illegal' => 'Si ngaran "$1" kada dibulihakan hagan mancagah kabingungan atawa ngaran tipuan: $2.
Muhun pilih ngaran nang lain.',
	'antispoof-badtype' => 'Janis data buruk',
	'antispoof-empty' => 'String kusung',
	'antispoof-blacklisted' => 'Mangandung karaktir daptar-hirang',
	'antispoof-combining' => 'Bamula awan ciri kumbinasi',
	'antispoof-unassigned' => 'Mangandung karaktir kada dibariakan atawa kada dipuruk pulang',
	'antispoof-noletters' => 'Kada baisi sa-asa hurup gin',
	'antispoof-mixedscripts' => 'Mangandung hurup-bacampur kada kumpatibal',
	'antispoof-tooshort' => 'Ngaran kanunicalisa kahandapan',
	'antispoof-ignore' => 'Abaiakan pamariksaan panipuan akun',
	'right-override-antispoof' => 'Abaiakan pamariksaan panipuan',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'antispoof-desc' => 'মিশ্র-লিপিতে লেখা, কিংবা অস্পষ্ট ও একই রকম ব্যবহারকারী নাম দিয়ে অ্যাকাউন্ট সৃষ্টিতে বাধা দেবে',
	'antispoof-conflict-top' => '"$1" নামটি  {{PLURAL:$2|অ্যাকাউন্টের| $2 অ্যাকাউন্টের}} সাথে বেশ মিলে যায়',
	'antispoof-conflict-bottom' => 'অনুগ্রহ করে অন্য নাম পছন্দ করুন।',
	'antispoof-name-illegal' => '"$1" নামটি, বিভ্রান্তিকর বা ধাপ্পাবাজ ব্যবহারকারী নাম: $2 কে রোধ করার অনুমতি নাই। দয়া করে অন্য নাম পছন্দ করুন।',
	'antispoof-badtype' => 'তথ্যের ধরণ ঠিক নাই',
	'antispoof-empty' => 'খালি স্ট্রিং',
	'antispoof-blacklisted' => 'নিষিদ্ধ বর্ণ বা অক্ষর রয়েছে',
	'antispoof-combining' => 'সংযোগসূচক চিহ্ন দিয়ে শুরু হয়েছে',
	'antispoof-unassigned' => 'অপ্রযুক্ত বা অননুমোদিত ক্যারেক্টার ধারণ করে',
	'antispoof-noletters' => 'কোন অক্ষর বা বর্ণ নাই',
	'antispoof-mixedscripts' => 'বেমানান স্ক্রিপ্টের মিশ্রণ ধারণ করে',
	'antispoof-tooshort' => 'সূত্রায়িত নাম খুব সংক্ষিপ্ত',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'antispoof-desc' => "Stankañ a ra, dre ur skript kemmesk, krouidigezh kontoù dezho anvioù implijer heñvel pe a c'hall sevel amjestregezh diwarno",
	'antispoof-conflict-top' => 'Heñvel betek re eo an anv "$1" da hini {{PLURAL:$2|ar gont zo anezhi|d\'an $2 anv kont da-heul}}:',
	'antispoof-conflict-bottom' => 'Dibabit un anv all mar plij.',
	'antispoof-name-illegal' => 'N\'eo ket aotreet ober gant an anv "$1" kuit da gemmeskañ gant un anv all pe da implijout an anv : $2. Grit gant un anv all mar plij.',
	'antispoof-badtype' => 'Seurt roadennoù fall',
	'antispoof-empty' => 'Neudennad goullo',
	'antispoof-blacklisted' => 'Arouezennoù berzet zo e-barzh',
	'antispoof-combining' => 'Kregiñ a ra gant ur merk kenaozet',
	'antispoof-unassigned' => 'Un arouezenn dispredet pe dispisaet zo e-barzh',
	'antispoof-noletters' => 'Lizherenn ebet e-barzh',
	'antispoof-mixedscripts' => 'Meur a skript digenglotus zo e-barzh',
	'antispoof-tooshort' => 'Anv kanonek re verr',
	'antispoof-ignore' => "Chom hep gwiriañ hag-eñ n'eus ket un implijer all gantañ un anv damheñvel",
	'right-override-antispoof' => 'Chom hep gwiriañ ha touellerezh zo',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'antispoof-desc' => 'Blokira pravljenje računa sa miješanim slovima, zbunjujućim i sličnim korisničkim imenima',
	'antispoof-conflict-top' => 'Ime "$1" je previše slično {{PLURAL:$2|slijedećem postojećem računu|sa slijedeća $2 postojeća  računa|sa slijedećih $2 postojećih računa}}:',
	'antispoof-conflict-bottom' => 'Molimo izaberite drugo ime.',
	'antispoof-name-illegal' => 'Ime "$1" nije dopušteno da bi se izbjegla zbunjujuća ili slična korisnička imena: $2.
Molimo Vas da odaberete drugo ime.',
	'antispoof-badtype' => 'Pogrešna vrsta podataka',
	'antispoof-empty' => 'Prazan unos',
	'antispoof-blacklisted' => 'Sadrži nepoželjni znak',
	'antispoof-combining' => 'Počinje sa znakom kombinacije',
	'antispoof-unassigned' => 'Sadrži nepoželjene ili neodobrene znakove',
	'antispoof-noletters' => 'Ne sadrži ni jedno slovo',
	'antispoof-mixedscripts' => 'Sadrži miješana slova koja nisu podržana',
	'antispoof-tooshort' => 'Normalizirano ime je prekratko',
	'antispoof-ignore' => 'Ignoriraj provjeru sličnosti',
	'right-override-antispoof' => 'Zaobilaženje provjera korisničkog imena',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'antispoof-desc' => "Bloca la creació de comptes amb alfabets barrejats i noms d'usuari similars o que portin a confusió",
	'antispoof-conflict-top' => 'El nom «$1» és massa similar {{PLURAL:$2|al compte existent|als següents $2 comptes}}:',
	'antispoof-conflict-bottom' => 'Escolliu si us plau un altre nom.',
	'antispoof-name-illegal' => "No està permès usar el nom «$1» per evitar confusions o falsificacions amb els noms d'usuari: $2. Si us plau, escolliu un altre nom d'usuari.",
	'antispoof-badtype' => 'Tipus de dades incorrecte',
	'antispoof-empty' => 'Cadena buida',
	'antispoof-blacklisted' => 'Conté caràcters no permesos',
	'antispoof-combining' => 'Comença amb un caràcter combinatori',
	'antispoof-unassigned' => 'Conté caràcters invàlids o obsolets',
	'antispoof-noletters' => 'No conté cap lletra',
	'antispoof-mixedscripts' => "Conté una mescla incompatible d'escriptures",
	'antispoof-tooshort' => 'Nom canònic massa curt',
	'antispoof-ignore' => 'Ignorar controls antispoof',
	'right-override-antispoof' => "Evitar el control de noms d'usuari",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'antispoof-ignore' => 'Терго ма йе цхьатерра цlераш йуй хьажарна',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'antispoof-badtype' => 'Tipu gattivu di dati',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'antispoof-desc' => 'Brání vytváření účtů, jejichž jména jsou matoucí, podobná jiným uživatelům, nebo kombinují několik druhů písem',
	'antispoof-conflict-top' => 'Jméno „$1“ je příliš podobné {{PLURAL:$2|následujícímu již existujícímu uživatelskému jménu|následujícím již existujícím uživatelským jménům}}:',
	'antispoof-conflict-bottom' => 'Zvolte si jiné jméno.',
	'antispoof-name-illegal' => 'Jméno „$1“ není povoleno vytvořit, aby se nepletlo nebo nesloužilo k napodobování cizích uživatelských jmen: $2.
Zvolte si prosím jiné jméno.',
	'antispoof-badtype' => 'Špatný datový typ',
	'antispoof-empty' => 'Prázdný řetězec',
	'antispoof-blacklisted' => 'Obsahuje zakázaný znak',
	'antispoof-combining' => 'Začíná kombinujícím diakritickým znakem',
	'antispoof-unassigned' => 'Obsahuje nepřiřazený nebo zavržený znak',
	'antispoof-noletters' => 'Neobsahuje žádné písmeno',
	'antispoof-mixedscripts' => 'Obsahuje nepřípustnou kombinaci druhů písem',
	'antispoof-tooshort' => 'Jméno je po normalizaci příliš krátké',
	'antispoof-ignore' => 'Neprovádět kontrolu matoucích jmen',
	'right-override-antispoof' => 'Potlačení kontroly podobnosti uživatelských jmen',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'antispoof-desc' => "Yn atal creu cyfrifon ag iddynt enwau o wyddorau cymysg, neu enwau dryslyd, neu enwau sy'n rhy debyg i enwau eraill",
	'antispoof-conflict-top' => 'Mae\'r enw "$1" yn rhy debyg i\'r {{PLURAL:$2||cyfrif|$2 gyfrif|$2 chyfrif|$2 chyfrif|$2 cyfrif}} canlynol:',
	'antispoof-conflict-bottom' => 'Dewiswch enw arall os gwelwch yn dda.',
	'antispoof-name-illegal' => 'Ni chaniateir yr enw "$1" er mwyn osgoi cael enwau dryslyd neu gellweirus ar ddefnyddwyr: $2. Byddwch gystal â dewis enw gwahanol.',
	'antispoof-badtype' => 'Math data gwallus',
	'antispoof-empty' => 'Llinyn gwag',
	'antispoof-blacklisted' => 'Yn cynnwys nod gwaharddedig',
	'antispoof-combining' => 'Yn dechrau gyda marc cyfuno',
	'antispoof-unassigned' => "Yn cynnwys nod sydd heb ei bennu neu nad yw'n gymeradwy",
	'antispoof-noletters' => "Nid yw'r enw'n cynnwys unrhyw lythyren",
	'antispoof-mixedscripts' => 'Yn cynnwys gwyddorau cymysg anghydweddol',
	'antispoof-tooshort' => "Mae'r enw, ar ôl ei normaleiddio gan y meddalwedd, yn rhy fyr i'w drin a'i drafod.",
	'antispoof-ignore' => 'Anwybydder gwirio am enwau gwallus',
	'right-override-antispoof' => 'Anwybydder gwirio am enwau gwallus',
);

/** Danish (Dansk)
 * @author Froztbyte
 * @author Jan Friberg
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'antispoof-desc' => 'Blokerer for oprettelse af konti med blandede tegnsæt, forvirrende eller lignende brugernavne',
	'antispoof-conflict-top' => 'Navnet "$1" er for ens med {{PLURAL:$2|den eksisterende konto|de følgende $2 konti}}:',
	'antispoof-conflict-bottom' => 'Vælg et andet navn.',
	'antispoof-name-illegal' => 'Navnet "$1" er ikke tilladt for at forhindre forvirrende eller efterlignede brugernavne: $2. Vælg venligst et andet navn.',
	'antispoof-badtype' => 'Forkert datatype',
	'antispoof-empty' => 'Tom streng',
	'antispoof-blacklisted' => 'Indeholder sortlistet tegn',
	'antispoof-combining' => 'Begynder med et kombinationsbogstav',
	'antispoof-unassigned' => 'Indeholder ubrugte bogstaver',
	'antispoof-noletters' => 'Indeholder ikke bogstaver',
	'antispoof-mixedscripts' => 'Indeholder inkompatible, blandede tegnsæt',
	'antispoof-tooshort' => 'Navnet er for kort',
	'antispoof-ignore' => 'Ignorer spoofing kontrol',
	'right-override-antispoof' => 'Omgå kontrollerne af brugernavne',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'antispoof-desc' => 'Verhindert die Erstellung von Benutzerkonten mit gemischten Zeichensätzen, verwirrenden und ähnlichen Benutzernamen',
	'antispoof-conflict-top' => 'Der Name „$1“ ist {{PLURAL:$2|dem existierenden Benutzerkonto|den folgenden $2 Benutzerkonten}} zu ähnlich:',
	'antispoof-conflict-bottom' => 'Bitte wähle einen anderen Namen.',
	'antispoof-name-illegal' => 'Der gewünschte Benutzername „$1“ ist nicht erlaubt. Grund: $2<br />Bitte einen anderen Benutzernamen wählen.',
	'antispoof-badtype' => 'Ungültiger Datentyp',
	'antispoof-empty' => 'Leeres Feld',
	'antispoof-blacklisted' => 'Es sind unerlaubte Zeichen enthalten.',
	'antispoof-combining' => 'Kombinationszeichen zu Beginn.',
	'antispoof-unassigned' => 'Es sind nicht zugeordnete oder unerwünschte Zeichen enthalten.',
	'antispoof-noletters' => 'Es sind keine Buchstaben enthalten.',
	'antispoof-mixedscripts' => 'Es sind Zeichen unterschiedlicher Schriftsysteme enthalten.',
	'antispoof-tooshort' => 'Der kanonisierte Name ist zu kurz.',
	'antispoof-ignore' => 'Ähnlichkeitsprüfung ignorieren',
	'right-override-antispoof' => 'Außer Kraft setzen der Benutzernamens-Ähnlichkeitsprüfung',
	'antispoof-conflict-item' => '$1',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'antispoof-conflict-bottom' => 'Bitte wählen Sie einen anderen Namen.',
);

/** Zazaki (Zazaki)
 * @author Xoser
 */
$messages['diq'] = array(
	'antispoof-desc' => 'Hesaban pê skriptê mîxî, nameyê munaneyî bloke keno',
	'antispoof-conflict-top' => 'Ena nameyê "$1"î ena {{PLURAL:$2|the existing account|the following $2 accounts}} rê zaf nizdiyo:',
	'antispoof-conflict-bottom' => 'Ma rica keno ke yewno nameyê karberî mucneno.',
	'antispoof-name-illegal' => 'Nameyê "$1"î nieşkeno nameyê karberî ke şweş keno înan vindarne: $2.
Yewna name weçine.',
	'antispoof-badtype' => 'Tipê data yê xirabî',
	'antispoof-empty' => 'Stringê vengî',
	'antispoof-blacklisted' => 'Karakterê listeyê siyayî mucneno',
	'antispoof-combining' => 'Îşaretê combinasyonî ra dest beno',
	'antispoof-unassigned' => 'Karekterê destur-ne-diyaye ya zi deprecatedî mucneno',
	'antispoof-noletters' => 'Yew zi herf çini yo',
	'antispoof-mixedscripts' => 'Te de skriptanê xeripîyaye esto',
	'antispoof-tooshort' => 'Ena name zaf kilm o',
	'antispoof-ignore' => 'Kontrolê spoofî rê diket meke',
	'right-override-antispoof' => 'Kontrolanê spoofî override bike',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'antispoof-desc' => 'Blokěrujo napóranje kontow z měšanym pismom, mjerwjece a pódobne wužywarske mjenja',
	'antispoof-conflict-top' => 'Mě "$1" jo pśepódobny {{PLURAL:$2|eksistěrujucemu kontoju|slědujucyma $2 kontoma|slědujucym kontam|slědujucym kontam}}:',
	'antispoof-conflict-bottom' => 'Pšosym wubjeŕ druge mě.',
	'antispoof-name-illegal' => 'Mě "$1" se njedowólujo, aby se mjerwjece abo manipulěrowane wužywarske mjenja wopinuli: $2. Wubjeŕ pšosym druge mě.',
	'antispoof-badtype' => 'Wopacny datowy typ',
	'antispoof-empty' => 'Prozne pólo',
	'antispoof-blacklisted' => 'Wopśimjejo njedowólene znamješka',
	'antispoof-combining' => 'Zachopina se z kombinaciskim znamješkom',
	'antispoof-unassigned' => 'Wopśimjejo njepśirědowane abo njewitane znamješka',
	'antispoof-noletters' => 'Njewopśimjejo pismiki',
	'antispoof-mixedscripts' => 'Wopśimjejo znamješka z njekompatibelnych rozdźělnych pismow',
	'antispoof-tooshort' => 'Kanonizěrowane mě jo pśekrotko.',
	'antispoof-ignore' => 'Torjeńsku kontrolu ignorěrowaś',
	'right-override-antispoof' => 'Kontrole pódobnosći wužywarskich mjenjow pódtłocyś',
);

/** Central Dusun (Dusun Bundu-liwan)
 * @author FRANELYA
 */
$messages['dtp'] = array(
	'antispoof-conflict-bottom' => 'Mangai alanai do suai ngaran.',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Dead3y3
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'antispoof-desc' => 'Μπλοκάρει τη δημιουργία λογαριασμών με χαρακτήρες μικτής γραφής, συγχεχυμένα και παρόμοια ονόματα χρηστών.',
	'antispoof-conflict-top' => 'Το όνομα "$1" είναι υπερβολικά όμοιο με {{PLURAL:$2|τον υπάρχοντα λογαριασμό|τους ακόλουθους $2 λογαριασμούς}}:',
	'antispoof-conflict-bottom' => 'Διαλέξτε ένα διαφορετικό όνομα.',
	'antispoof-name-illegal' => 'Το όνομα "$1" δεν επιτρέπεται, για την αποτροπή συγκεχυμένων ή απατηλών ονομάτων χρηστών: $2. Παρακαλώ διαλέξτε ένα άλλο όνομα.',
	'antispoof-badtype' => 'Εσφαλμένος τύπος δεδομένων',
	'antispoof-empty' => 'Κενή συμβολοσειρά',
	'antispoof-blacklisted' => 'Περιέχει χαρακτήρα στη «μαύρη λίστα»',
	'antispoof-combining' => 'Ξεκινάει με συνδυαστικό σημάδι',
	'antispoof-unassigned' => 'Περιέχει μη καταχωρημένο χαρακτήρα ή χαρακτήρα του οποίου η χρήση αποθαρρύνεται',
	'antispoof-noletters' => 'Δεν περιέχει καθόλου γράμματα',
	'antispoof-mixedscripts' => 'Περιέχει ανεμιγμένους ασύμβατους χαρακτήρες γραπτού κειμένου',
	'antispoof-tooshort' => 'Κανονικοποιημένο όνομα πολύ μικρό',
	'antispoof-ignore' => 'Αγνόησε ελέγχους spoofing',
	'right-override-antispoof' => 'Υπερκάλυψη των ελέγχων εξαπάτησης',
);

/** Esperanto (Esperanto)
 * @author Tlustulimu
 * @author Yekrats
 */
$messages['eo'] = array(
	'antispoof-desc' => 'Blokas la kreadon de kontoj kun miksitaj alfabetaj, konfuzemaj, kaj similaj salutnomoj',
	'antispoof-conflict-top' => 'La nomo "$1" tro similas {{PLURAL:$2|la ekzistantan konton|la jenajn $2 kontojn}}:',
	'antispoof-conflict-bottom' => 'Bonvolu elekti alian nomon.',
	'antispoof-name-illegal' => 'La nomo "$1" ne estas permesita por preventi konfuzigemajn aŭ trompajn uzantnomojn: $2. Bonvolu elekti alian nomon.',
	'antispoof-badtype' => 'Malvalida datumtipo',
	'antispoof-empty' => 'Malplena bitĉeno',
	'antispoof-blacklisted' => 'Enhavas literojn el nigra listo',
	'antispoof-combining' => 'Komencas kun kuniga marko',
	'antispoof-unassigned' => 'Enhavas nedonatan aŭ evitindan signon',
	'antispoof-noletters' => 'Ne enhavas iujn literojn',
	'antispoof-mixedscripts' => 'Enhavas nekompatibilajn miksajn skriptojn',
	'antispoof-tooshort' => 'Ordigita nomo estas tro mallonga',
	'antispoof-ignore' => 'Ignori kontroladon de trompado',
	'right-override-antispoof' => 'Superebligi la artifikajn kontrolojn.',
);

/** Spanish (Español)
 * @author Cvmontuy
 * @author Icvav
 * @author Locos epraix
 * @author Platonides
 * @author Remember the dot
 * @author Sanbec
 * @author Titoxd
 */
$messages['es'] = array(
	'antispoof-desc' => 'Previene la creación de cuentas de usuario nuevas que tengan nombres confusos, similares a nombres existentes, o con alfabetos mixtos.',
	'antispoof-conflict-top' => 'El nombre «$1» es muy similar al de {{PLURAL:$2|la siguiente cuenta|las siguientes $2 cuentas}}:',
	'antispoof-conflict-bottom' => 'Elige otro nombre, por favor.',
	'antispoof-name-illegal' => 'El nombre «$1» no está permitido para evitar nombres de usuario confusos o suplantaciones: $2. Por favor, elige otro nombre.',
	'antispoof-badtype' => 'Tipo de dato erróneo',
	'antispoof-empty' => 'Texto vacío',
	'antispoof-blacklisted' => 'Contiene caracteres no permitidos',
	'antispoof-combining' => 'Comienza por una marca de combinación',
	'antispoof-unassigned' => 'Contiene caracteres obsoletos o no asignados',
	'antispoof-noletters' => 'No contiene letras',
	'antispoof-mixedscripts' => 'Contiene una mezcla incompatible de alfabetos',
	'antispoof-tooshort' => 'Nombre en forma canónica demasiado corto',
	'antispoof-ignore' => 'Ignorar comprobaciones contra suplantaciones',
	'right-override-antispoof' => 'Anula las comprobaciones de suplantación',
	'antispoof-conflict-item' => '$1',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'antispoof-desc' => 'Blokeerib erinevaid kirjasüsteeme kasutavate, eksitavate ja sarnaste kasutajanimedega kontode loomise.',
	'antispoof-conflict-top' => 'Nimi "$1" on liiga sarnane {{PLURAL:$2|olemasoleva|järgneva $2}} kontoga:',
	'antispoof-conflict-bottom' => 'Palun vali teine nimi.',
	'antispoof-name-illegal' => 'Nimi "$1" ei ole lubatud, et vältida eksitavaid või pilavaid kasutajanimesid. Põhjus: $2<br />
Palun vali teine nimi.',
	'antispoof-badtype' => 'Halb andmetüüp',
	'antispoof-empty' => 'Tühi sõne',
	'antispoof-blacklisted' => 'Sisaldab mustas nimekirjas olevat märki',
	'antispoof-combining' => 'Algab kombineeruva märgiga',
	'antispoof-noletters' => 'Ei sisalda ühtegi tähte',
	'antispoof-mixedscripts' => 'Sisaldab ühildumatuid kirjasüsteeme',
	'antispoof-tooshort' => 'Kanooniline nimi on liiga lühike',
	'antispoof-ignore' => 'Eira sarnasuskontrolle',
	'right-override-antispoof' => 'Mööduda kasutajanimede sarnasuse testist',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'antispoof-conflict-bottom' => 'Mesedez, beste izen bat aukeratu.',
	'antispoof-name-illegal' => '"$1" izena ez dago onartuta gaizkiulertuak saihesteko: $2. Beste izen bat hautatu mesedez.',
	'antispoof-badtype' => 'Datu mota ezegokia',
	'antispoof-empty' => 'Kate hutsa',
	'antispoof-noletters' => 'Ez dauka letrarik',
);

/** Persian (فارسی)
 * @author Huji
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'antispoof-desc' => 'از ایجاد حساب‌های کاربری با حروف مختلط، گیج‌کننده یا مشابه با دیگر حساب‌های کاربری جلوگیری می‌کند',
	'antispoof-conflict-top' => 'نام «$1» خیلی به {{PLURAL:$2|این حساب کاربری|این $2 حساب کاربری}} شباهت دارد:',
	'antispoof-conflict-bottom' => 'لطفاً نام دیگری انتخاب کنید.',
	'antispoof-name-illegal' => 'نام «$1» به دلیل جلوگیری از نام‌های کاربری سردرگم‌کننده یا مسخره مجاز نیست: $2. لطفاً نام دیگری انتخاب کنید.',
	'antispoof-badtype' => 'داده با نوع نامناسب',
	'antispoof-empty' => 'رشتهٔ خالی',
	'antispoof-blacklisted' => 'حاوی نویسه‌هایی است که در فهرست سیاه قرار دارند',
	'antispoof-combining' => 'با علامت جمع شروع می‌شود',
	'antispoof-unassigned' => 'دارای نویسه‌های تعیین‌نشده یا نامناسب است',
	'antispoof-noletters' => 'دربردارندهٔ هیچ حرفی نیست.',
	'antispoof-mixedscripts' => 'حاوی نویسه‌های مختلط ناسازگار است',
	'antispoof-tooshort' => 'نام متعارف خیلی کوتاه است',
	'antispoof-ignore' => 'نادیده گرفتن بررسی عبارات سردرگم کننده',
	'right-override-antispoof' => 'گذر از بررسی عبارات سردرگم کننده',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'antispoof-desc' => 'Estää käyttäjätunnusten luonnin, jos ne sisältävät eri kirjoitusjärjestelmiä, harhaanjohtavia tai samankaltaisia käyttäjätunnuksia.',
	'antispoof-conflict-top' => 'Tunnus ”$1” on liian samankaltainen kuin {{PLURAL:$2|olemassa oleva tunnus|seuraavat $2 tunnusta}}:',
	'antispoof-conflict-bottom' => 'Valitse toinen tunnus.',
	'antispoof-name-illegal' => 'Tunnusta ”$1” ei sallita, koska $2. Hämäävien tai huijaustarkoitukseen sopivien tunnusten luonti on estetty. Valitse toinen tunnus.',
	'antispoof-badtype' => 'se on virheellistä tietotyyppiä',
	'antispoof-empty' => 'se on tyhjä',
	'antispoof-blacklisted' => 'se sisältää kielletyn merkin',
	'antispoof-combining' => 'se alkaa yhdistyvällä merkillä',
	'antispoof-unassigned' => 'se sisältää määräämättömiä tai käytöstä poistuvia merkkejä',
	'antispoof-noletters' => 'se ei sisällä kirjaimia',
	'antispoof-mixedscripts' => 'se sisältää yhteensopimattomia kirjoitusjärjestelmiä',
	'antispoof-tooshort' => 'sen kanonisoitu muoto on liian lyhyt',
	'antispoof-ignore' => 'Älä käytä hämäävien tunnusten tarkistusta',
	'right-override-antispoof' => 'Ohittaa tarkastukset samankaltaisista tai epäilyttävistä käyttäjätunnuksista',
	'antispoof-conflict-item' => '$1',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'antispoof-desc' => 'Blokkerar fyri upprættan av konti við blandaðum teknum, forvirrandi ella líknandi brúkaranøvnum',
	'antispoof-conflict-top' => 'Navnið "$1" líkist ov nógv {{PLURAL:$2|verandi konto|hesum $2 kontum}}:',
	'antispoof-conflict-bottom' => 'Vinarliga vel eitt annað navn.',
	'antispoof-name-illegal' => 'Navnið "$1" er ikki loyvt til tess at fyribyrgja følsk ella forvirrandi brúkaranøvn: $2.',
	'antispoof-badtype' => 'Ringt slag av data.',
	'antispoof-empty' => 'Tøm strongin',
	'antispoof-blacklisted' => 'Inniheldur tekn sum eru á svaralista',
	'antispoof-combining' => 'Byrjar við kombinatións tekni',
	'antispoof-unassigned' => 'Inniheldur óbrúktar bókstavar',
	'antispoof-noletters' => 'Inniheldur ikki nakran bókstav',
	'antispoof-tooshort' => 'Navnið er ov stutt',
	'antispoof-ignore' => 'Síggj burtur frá "spoofing" kanning',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Louperivois
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'antispoof-desc' => 'Bloque la création de comptes ayant des noms d’utilisateur similaires, utilisant diverses écritures, ou pouvant prêter à confusion',
	'antispoof-conflict-top' => 'Le nom « $1 » est trop similaire {{PLURAL:$2|au compte existant|aux $2 comptes suivants}} :',
	'antispoof-conflict-bottom' => 'Veuillez choisir un autre nom.',
	'antispoof-name-illegal' => 'Le nom d’utilisateur « $1 » n’est pas autorisé pour la raison suivante : « $2 ».
Veuillez choisir un autre nom.',
	'antispoof-badtype' => 'Mauvais type de données',
	'antispoof-empty' => 'Chaîne vide',
	'antispoof-blacklisted' => 'Contient un caractère interdit',
	'antispoof-combining' => 'Commence avec une marque combinatoire',
	'antispoof-unassigned' => 'Contient un caractère non assigné ou désuet',
	'antispoof-noletters' => 'Ne contient aucune lettre',
	'antispoof-mixedscripts' => 'Contient plusieurs écritures incompatibles',
	'antispoof-tooshort' => 'Nom canonique trop court',
	'antispoof-ignore' => 'Ignorer la vérification de similitude avec les utilisateurs existants',
	'right-override-antispoof' => 'Court-circuiter les vérifications de tromperie',
	'antispoof-conflict-item' => '$1',
);

/** Cajun French (Français cadien)
 * @author JeanVoisin
 */
$messages['frc'] = array(
	'antispoof-name-illegal' => 'Le nom "$1" est pas permit pour empêcher de confondre ou d\'user le nom "$2".  Choisissez donc un autre nom.',
	'antispoof-badtype' => "Mauvaise qualité d'information",
	'antispoof-empty' => 'Chaîne vide',
	'antispoof-blacklisted' => 'Contient un caractère pas permit',
	'antispoof-combining' => 'Commence avec une marque combinée',
	'antispoof-unassigned' => 'Contient un caractère pas assigné ou désapprouvé',
	'antispoof-noletters' => 'Contient pas de lettres',
	'antispoof-mixedscripts' => "Contient plusieurs scripts qui s'adonnont pas",
	'antispoof-tooshort' => 'Le nom choisi est trop court',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'antispoof-desc' => 'Dèfend la crèacion de comptos qu’utilisont un mouél d’ècritures avouéc des noms d’utilisator semblâblos, ou ben que pôvont prétar a confusion.',
	'antispoof-conflict-top' => 'Lo nom « $1 » est trop pariér {{PLURAL:$2|u compto ègzistent|a cetos $2 comptos}} :',
	'antispoof-conflict-bottom' => 'Volyéd chouèsir un ôtro nom.',
	'antispoof-name-illegal' => 'Lo nom d’utilisator « $1 » est pas ôtorisâ por empachiér de confondre ou ben d’utilisar lo nom « $2 ».
Volyéd chouèsir un ôtro nom.',
	'antispoof-badtype' => 'Crouyo tipo de balyês',
	'antispoof-empty' => 'Chêna voueda',
	'antispoof-blacklisted' => 'Contint un caractèro dèfendu.',
	'antispoof-combining' => 'Comence avouéc una mârca combinâ.',
	'antispoof-unassigned' => 'Contint un caractèro pas assignê ou ben dèpassâ.',
	'antispoof-noletters' => 'Contint gins de lètra.',
	'antispoof-mixedscripts' => 'Contint un mouél d’ècritures que vont pas avouéc.',
	'antispoof-tooshort' => 'Nom canonico trop côrt',
	'antispoof-ignore' => 'Ignorar los contrôlos de frôda',
	'right-override-antispoof' => 'Ignorar los contrôlos de frôda',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'antispoof-desc' => 'Bloquea a creación de contas con escrituras mesturadas, confusas ou con nomes de usuario similares',
	'antispoof-conflict-top' => 'O nome "$1" é moi similar {{PLURAL:$2|á seguinte conta que xa existe|ás seguintes $2 contas}}:',
	'antispoof-conflict-bottom' => 'Por favor, escolla outro nome.',
	'antispoof-name-illegal' => 'O nome "$1" non está permitido para evitar confusións ou enganos cos seguintes nomes de usuario: $2. Por favor, escolla outro nome.',
	'antispoof-badtype' => 'Tipo de datos incorrecto',
	'antispoof-empty' => 'Cadea baleira',
	'antispoof-blacklisted' => 'Inclúe un carácter prohibido',
	'antispoof-combining' => 'Principia cun carácter de combinación',
	'antispoof-unassigned' => 'Contén un carácter sen asignar ou desaconsellado',
	'antispoof-noletters' => 'Non contén ningunha letra',
	'antispoof-mixedscripts' => 'Contén guións incompatibles mesturados',
	'antispoof-tooshort' => 'Nome curto de máis',
	'antispoof-ignore' => 'Ignorar as comprobacións parodia (spoofing)',
	'right-override-antispoof' => 'Ignorar as comprobacións parodia (spoofing)',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'antispoof-conflict-bottom' => 'Ἐπίλεξαι ἕτερον ὄνομα.',
	'antispoof-badtype' => 'Κακὸς τύπος δεδομένων',
	'antispoof-empty' => 'Κενὴ συμβολοσειρά',
	'right-override-antispoof' => 'Ὑπερκάλυψις τῶν ἐλέγχων ἐξαπατήσεως',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Hendergassler
 */
$messages['gsw'] = array(
	'antispoof-desc' => 'Verhinderet s Aalege vu Benutzerkonte mit gmischlete Zeichesätz, Benutzernäme wu verwirre oder ähnligs',
	'antispoof-conflict-top' => 'Dr Name „$1“ isch {{PLURAL:$2|däm Benutzerkonto|däne $2 Benutzerkonte}} zue ähnli:',
	'antispoof-conflict-bottom' => 'Bitte wehl e andere Name.',
	'antispoof-name-illegal' => 'Dr Name "$1" isch nit gstattet, wel s e Problem chennt gee mit "$2". <br />Nimm e andre Name.',
	'antispoof-badtype' => 'Datetyp isch nit giltig.',
	'antispoof-empty' => 'Läär Fäld',
	'antispoof-blacklisted' => 'S het Zeiche din, wo nit gstattet sin.',
	'antispoof-combining' => 'Fangt a mit Kombinationszeiche.',
	'antispoof-unassigned' => 'S het Zeiche, wo nit zuegordnet oder nit gwinscht sin.',
	'antispoof-noletters' => 'S sin kaini Buechstabe din.',
	'antispoof-mixedscripts' => 'S sin Zeiche vo unterschidlige Schriftsyschtem din enthalte.',
	'antispoof-tooshort' => 'Dr kanonisiert Name isch z churz.',
	'antispoof-ignore' => 'Ignorier d Ähnlichkeitspriefig',
	'right-override-antispoof' => 'D Benutzernäme-Ähnligkeitspriefig usser Chraft setze',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author KartikMistry
 */
$messages['gu'] = array(
	'antispoof-desc' => 'મિક્સ્ડ-સ્ક્રિપ્ટ, ગૂંચવણ અને સમાન સભ્યનામો વાળા ખાતાં ખોલવા પર પ્રતિબંધ મુકે છે',
	'antispoof-conflict-top' => 'ઈચ્છિત સભ્યનામ "$1" {{PLURAL:$2|પહેલેથી અસ્તિત્વમાં હોય તેવા સભ્યનામ|નીચેના $2 સભ્યનામ}} સાથે ઘણું મળતું આવે છે:',
	'antispoof-conflict-bottom' => 'મહેરબાની કરી બીજું નામ પસંદ કરો.',
	'antispoof-name-illegal' => 'સંભવત: ગૂંચવણ કે છેતરામણી જનક સભ્યનામ $2 અટકાવવાના હેતુથી સભ્યનામ "$1"ની છૂટ નથી.
કૃપા કરી અન્ય નામ પસંદ કરો.',
	'antispoof-badtype' => 'ખરાબ માહિતી પ્રકાર',
	'antispoof-empty' => 'ખાલી વાક્ય',
	'antispoof-blacklisted' => 'પ્રતિબંધિત અક્ષર/ચિહ્ન ધરાવે છે',
	'antispoof-combining' => 'સંયોજક અક્ષર/ચિહ્નથી શરૂ થાય છે',
	'antispoof-unassigned' => 'અનિર્દિષ્ટ કે નાપસંદ અક્ષર/ચિહ્ન ધરાવે છે.',
	'antispoof-noletters' => 'આમાં એકપણ અક્ષર નથી',
	'antispoof-mixedscripts' => 'અસંગત મિક્સ્ડ સ્ક્રિપ્ટ્સ ધરાવે છે',
	'antispoof-tooshort' => 'સંક્ષિપ્ત કરેલું નામ ખૂબ નાનું છે',
	'antispoof-ignore' => 'છેતરામણી પરિક્ષણને અવગણો',
	'right-override-antispoof' => 'છેતરામણી પરિક્ષણની ઉપરવટ જાવ',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'antispoof-name-illegal' => 'Yung-fu-miàng "$1" yi-lâu Yung-fu-miàng "$2" fun-chha̍p, yí-kîn pûn kim-chṳ́ sṳ́-yung. Chhiáng sṳ́-yung khì-thâ ke yung-fu-miàng.',
	'antispoof-badtype' => 'Chho-ngu ke chṳ̂-liau lui-hìn',
	'antispoof-empty' => 'Khûng-pha̍k sṳ-chhon',
	'antispoof-blacklisted' => 'Pâu-hàm chhai het-miàng-tân song ke sṳ-ngièn',
	'antispoof-combining' => 'Chhut-yì kiet-ha̍p phêu-ki khôi-sṳ́',
	'antispoof-unassigned' => 'Pâu-hàm mò chṳ́-thin fe̍t-he put-chai sṳ́-yung ke sṳ-ngièn',
	'antispoof-noletters' => 'Mò pâu-hàm ngim-hò sṳ-ngièn',
	'antispoof-mixedscripts' => 'Pâu-hàm mò siong-yùng fun-ha̍p ke chṳ́-lin',
	'antispoof-tooshort' => 'Ha̍p-fù phêu-chún ke miàng-chhṳ̂n thai-tón',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'antispoof-desc' => 'לא מאפשר יצירה של חשבונות עם סוגי כתב מעורבים, חשבונות עם שמות מבלבלים ושמות משתמש דומים',
	'antispoof-conflict-top' => 'השם "$1" דומה מדי {{PLURAL:$2|לחשבון הקיים הבא|ל־$2 החשבונות הקיימים הבאים}}:',
	'antispoof-conflict-bottom' => 'אנא בחרו שם אחר.',
	'antispoof-name-illegal' => 'לא ניתן לבחור את שם המשתמש "$1" כדי למנוע שמות משתמש מבלבלים: $2.
אנא בחרו שם משתמש אחר.',
	'antispoof-badtype' => 'סוג מידע בעייתי',
	'antispoof-empty' => 'מחרוזת ריקה',
	'antispoof-blacklisted' => 'כולל תו אסור בשימוש',
	'antispoof-combining' => 'מתחיל בסימן צירוף',
	'antispoof-unassigned' => 'כולל תו לא מוקצה או מיושן',
	'antispoof-noletters' => 'לא כולל אותיות',
	'antispoof-mixedscripts' => 'כולל סוגי כתב מעורבים שאינם תואמים זה לזה',
	'antispoof-tooshort' => 'השם המנורמל קצר מדי',
	'antispoof-ignore' => 'התעלמות מבדיקת ההתחזות',
	'right-override-antispoof' => 'עקיפת בדיקות ההתחזות',
);

/** Hindi (हिन्दी)
 * @author Kannankumar
 * @author Kaustubh
 * @author Knight Samar
 * @author Pooja.srivastava
 * @author Shyam123.ckp
 */
$messages['hi'] = array(
	'antispoof-desc' => 'मिश्र भाषा और संभ्रम पैदा करनेवाली तथा एकसरीके सदस्यनाम के इस्तेमाल पर रोक हैं।',
	'antispoof-conflict-top' => 'धोखा-संघर्ष टॉप विरोधी',
	'antispoof-conflict-bottom' => 'कृपया कोई अन्य नाम चुनिये ।',
	'antispoof-name-illegal' => 'नाम " $1  faltu है:  $2 .!एन!कृपया kuch aur chuniye',
	'antispoof-badtype' => 'गलत डाटा प्रकार',
	'antispoof-empty' => 'खाली स्ट्रिंग',
	'antispoof-blacklisted' => 'इसमें ब्लैकलिस्टेड अक्षर हैं',
	'antispoof-combining' => 'एकत्रिकरण चिन्हसे शुरु होता हैं',
	'antispoof-unassigned' => 'इसमें गलत अक्षर हैं',
	'antispoof-noletters' => 'इसमें कोईभी अक्षर नहीं हैं',
	'antispoof-mixedscripts' => 'इसमें अन्य मिश्र लिपीयां हैं',
	'antispoof-tooshort' => 'अधिकारयुक्त नाम बहुत छोटा हैं',
	'antispoof-ignore' => 'उपेक्षा स्पूफिंग चेक',
	'right-override-antispoof' => 'स्पूफिंग चेक्स को नजर अंदाज करें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'antispoof-desc' => 'Sprečava stvaranje sličnih i nepravilnih suradničkih računa',
	'antispoof-conflict-top' => 'Ime "$1" je previše slično već {{PLURAL:$2|postojećem imenu|$2 postojećih imena}}:',
	'antispoof-conflict-bottom' => 'Molimo odaberite drugo ime.',
	'antispoof-name-illegal' => 'Ime "$1" nije dozvoljeno da se spriječi moguća zamjena suradničkih nadimaka: $2. Molimo izaberite drugo ime/nadimak.',
	'antispoof-badtype' => 'Krivi tip podataka',
	'antispoof-empty' => 'Prazan string',
	'antispoof-blacklisted' => 'Sadrži nedozvoljeno slovo (karakter)',
	'antispoof-combining' => 'Počinje s znakom spajanja',
	'antispoof-unassigned' => 'Sadrži nedodijeljen ili zastarjeli znak (karakter)',
	'antispoof-noletters' => 'Prekratko',
	'antispoof-mixedscripts' => 'Nekompatibilna pisma',
	'antispoof-tooshort' => 'Prekratko ime',
	'antispoof-ignore' => 'Ignoriraj provjeru nevaljanih imena (antispoof)',
	'right-override-antispoof' => 'Premošćivanje spoofing provjere',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'antispoof-desc' => 'Blokuje wutworjenje kontow z měšanymi pismami, skonfuznjacymi a podobnymi wužiwarskimi mjenami',
	'antispoof-conflict-top' => 'Mjeno "$1" je {{PLURAL:$2|eksistowacemu kontu|slědowacymaj $2 kontomaj|slědowacym $2 kontam|slědowacym kontam}} přepodobne:',
	'antispoof-conflict-bottom' => 'Prošu wubjer druhe mjeno.',
	'antispoof-name-illegal' => 'Požadane wužiwarske mjeno „$1” njeje dowolene. Přičina: $2<br />Prošu wubjer druhe wužiwarske mjeno.',
	'antispoof-badtype' => 'Njepłaćiwy datowy typ',
	'antispoof-empty' => 'Prózdne polo',
	'antispoof-blacklisted' => 'Su njedowolene znamješka wobsahowane.',
	'antispoof-combining' => 'Započina so z kombinaciskim znamješkom.',
	'antispoof-unassigned' => 'Su njepřirjadowane abo njewitane znamješka wobsahowane.',
	'antispoof-noletters' => 'Njejsu pismiki wobsahowane.',
	'antispoof-mixedscripts' => 'Su znamješka rozdźělnych njekompatibelnych pismow wobsahowane',
	'antispoof-tooshort' => 'Kanonizowane mjeno je překrótke.',
	'antispoof-ignore' => 'Zamylensku kontrolu ignorować',
	'right-override-antispoof' => 'Kontrole podobnosće wužiwarskich mjenow potłóčić',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 * @author Masterches
 */
$messages['ht'] = array(
	'antispoof-desc' => 'Bloke kreyasyon kont ki genyen diferan alfabèt, ki ka mennen nan konfizyon oubyen ki genyen non itilizatè ki sanble trop',
	'antispoof-name-illegal' => 'Non itilizatè "$1" pa otorize pou anpeche li konfonn ak non itilizatè: "$2"
Tanpri chwazi yon lòt non.',
	'antispoof-badtype' => 'Tip done sa yo move',
	'antispoof-empty' => 'Chèn vid',
	'antispoof-blacklisted' => 'Kontni yon karaktè ki pa otorize',
	'antispoof-combining' => 'Ap koumanse avèk yon mak konbine',
	'antispoof-unassigned' => 'Kontni yon karaktè ki pa asiyen oubyen ki pa itilize ankò',
	'antispoof-noletters' => 'Pa kontni pyès lèt',
	'antispoof-mixedscripts' => 'Kontni plizyè alfabèt ki pa konpatib',
	'antispoof-tooshort' => 'Non kanonik an two kout',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'antispoof-desc' => 'Letiltja a kevert szövegű, zavaró és hasonló nevű felhasználói fiókok készítését',
	'antispoof-conflict-top' => 'A megadott név „$1” túl hasonló a következő {{PLURAL:$2|azonosítóhoz|$2 azonosítóhoz}}:',
	'antispoof-conflict-bottom' => 'Kérlek válassz egy másik nevet.',
	'antispoof-name-illegal' => 'A név, „$1”, nem engedélyezett a zavaró vagy becsapó felhasználónevek megelőzése érdekében: $2.',
	'antispoof-badtype' => 'Hibás adattípus',
	'antispoof-empty' => 'Üres szöveg',
	'antispoof-blacklisted' => 'Nem használható karaktert tartalmaz',
	'antispoof-combining' => 'Összekapcsoló jellel kezdődik',
	'antispoof-unassigned' => 'Még nem kijelölt vagy nem használt karaktert tartalmaz',
	'antispoof-noletters' => 'Nem tartalmaz egyetlen betűt sem',
	'antispoof-mixedscripts' => 'Összeférhetetlen kevert szöveget tartalmaz',
	'antispoof-tooshort' => 'A kanonizált változat túl rövid',
	'antispoof-ignore' => 'Névellenőrzés figyelmen kívül hagyása',
	'right-override-antispoof' => 'felhasználói nevek ellenőrzésének figyelmen kívül hagyása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'antispoof-desc' => 'Bloca le creation de contos con alphabetos mixte, e nomines de utilisator similar o confundente',
	'antispoof-conflict-top' => 'Le nomine "$1" es troppo similar al {{PLURAL:$2|conto existente|sequente $2 contos}}:',
	'antispoof-conflict-bottom' => 'Per favor selige un altere nomine.',
	'antispoof-name-illegal' => 'Le nomine "$1" non es permittite pro evitar le nomines de usator confundente o falsificate: $2.
Per favor selige un altere nomine.',
	'antispoof-badtype' => 'Mal typo de datos',
	'antispoof-empty' => 'Serie de characteres vacue',
	'antispoof-blacklisted' => 'Contine un character prohibite',
	'antispoof-combining' => 'Comencia con un marca combinatori',
	'antispoof-unassigned' => 'Contine un character non assignate o obsolete',
	'antispoof-noletters' => 'Non contine alcun litteras',
	'antispoof-mixedscripts' => 'Contine un mixtura incompatibile de alphabetos',
	'antispoof-tooshort' => 'Nomine canonic troppo curte',
	'antispoof-ignore' => 'Ignorar le verificationes contra falsification',
	'right-override-antispoof' => 'Ignorar le verificationes contra falsification',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Meursault2004
 * @author Rex
 */
$messages['id'] = array(
	'antispoof-desc' => 'Menghalangi pembuatan akun dengan nama pengguna aksara campuran, membingungkan, dan yang mirip',
	'antispoof-conflict-top' => 'Nama "$1" terlalu mirip dengan {{PLURAL:$2|akun yang telah ada|$2 akun berikut}}:',
	'antispoof-conflict-bottom' => 'Silakan memilih nama lain.',
	'antispoof-name-illegal' => 'Nama "$1" tidak diijinkan untuk mencegah kebingungan atau penipuan nama: $2. Harap pilih nama lain.',
	'antispoof-badtype' => 'Tipe data salah',
	'antispoof-empty' => 'Data kosong',
	'antispoof-blacklisted' => 'Mengandung karakter yang tak diizinkan',
	'antispoof-combining' => 'Dimulai dengan tanda kombinasi',
	'antispoof-unassigned' => 'Mengandung karakter yang tak diberikan atau tak digunakan lagi',
	'antispoof-noletters' => 'Tidak mengandung huruf apa pun',
	'antispoof-mixedscripts' => 'Mengandung huruf campuran yang tak kompatibel',
	'antispoof-tooshort' => 'Nama kanonikalisasi terlalu pendek',
	'antispoof-ignore' => 'Abaikan pemeriksaan penipuan akun',
	'right-override-antispoof' => 'Mengabaikan pengecekan penipuan nama pengguna',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'antispoof-empty' => 'Cháfù érírí',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'antispoof-desc' => 'Serraan na ti panagaramid kadagiti pakabilangan nga addaan ti naglalaok-a panagsurat, maka-allilaw ken dagiti agpapada a nagan ti agar-aramat',
	'antispoof-conflict-top' => 'Ti nagan a "$1" ket agpadpada unay {{PLURAL:$2|idiay addaan a pakabilangan|kadagidiay sumaganad $2 a pakabilangan}}:',
	'antispoof-conflict-bottom' => 'Pangaasi ta agpili ka ti sabali nga nagan.',
	'antispoof-name-illegal' => 'Ti nagan a "$1" ket saan a mabalin tapno pawilan ti maka-allilaw wenno dagiti naanigaas a nagan ti agararamat: $2.
Pangngaasi ti agpili iti sabali a nagan.',
	'antispoof-badtype' => 'Dakes a kita a linaon',
	'antispoof-empty' => 'Awan ti nagyan na a kuerdas',
	'antispoof-blacklisted' => 'Nagyan kadagiti naiparit a karakter',
	'antispoof-combining' => 'Nangrugi iti pinagtipon ti marka',
	'antispoof-unassigned' => 'Nagyan iti saan a nainaganan wenno naikkaten a karakter',
	'antispoof-noletters' => 'Awan ti nagyan na a dagiti ania man a letra',
	'antispoof-mixedscripts' => 'Nagyan iti saan a mabalin nga aglalaok a panagsurat',
	'antispoof-tooshort' => 'Ti nakanonikal a nagan ket nababa unay',
	'antispoof-ignore' => 'Saan nga ikaskaso dagiti kinita nga aningaas',
	'right-override-antispoof' => 'Parabawan ti pinagkita nga aningaas',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'antispoof-desc' => 'Óheimilar gerð aðganga með blandað skrifletur, ruglandi og svipuð notandanöfn',
	'antispoof-name-illegal' => 'Nafnið „$1“ er ekki leyft til að koma í veg fyrir ruglandi eða skopstæld notendanöfn: „$2“. Gerðu svo vel og veldu annað nafn.',
	'antispoof-badtype' => 'Lélegt gagnatag',
	'antispoof-empty' => 'Tómur strengur',
	'antispoof-blacklisted' => 'Inniheldur bönnuð rittákn',
	'antispoof-combining' => 'Byrjar á samsetningartákni',
	'antispoof-unassigned' => 'Inniheldur óúthlutað eða úrelt tákn',
	'antispoof-noletters' => 'Inniheldur enga stafi',
	'antispoof-mixedscripts' => 'Inniheldur ósamhæfðar skriftur',
	'antispoof-tooshort' => 'Nafn of stutt',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'antispoof-desc' => 'Impedisce la creazione di account con caratteri misti, nomi utente che generano confusione o troppo simili tra loro.',
	'antispoof-conflict-top' => 'Il nome "$1" è troppo simile {{PLURAL:$2|all\'account esistente|ai seguenti $2 account}}:',
	'antispoof-conflict-bottom' => 'Scegliere un altro nome.',
	'antispoof-name-illegal' => 'Il nome utente "$1" non è consentito, per evitare confusione o utilizzi fraudolenti: $2. Scegliere un altro nome.',
	'antispoof-badtype' => 'Tipo di dati errato',
	'antispoof-empty' => 'Stringa vuota',
	'antispoof-blacklisted' => 'Uso di caratteri non consentiti',
	'antispoof-combining' => 'Primo carattere di combinazione',
	'antispoof-unassigned' => 'Uso di caratteri non assegnati o deprecati',
	'antispoof-noletters' => 'Assenza di lettere',
	'antispoof-mixedscripts' => 'Combinazione di sistemi di scrittura non compatibili',
	'antispoof-tooshort' => 'Nome in forma canonica troppo corto',
	'antispoof-ignore' => 'Ignora i controlli per spoofing',
	'right-override-antispoof' => 'Ignora i controlli spoofing',
	'antispoof-conflict-item' => '$1',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Mizusumashi
 * @author Muttley
 */
$messages['ja'] = array(
	'antispoof-desc' => '文字体系が混在している利用者名、既存の利用者名と紛らわしい類似する利用者名のアカウント作成をブロックする',
	'antispoof-conflict-top' => '指定した名前 "$1" は{{PLURAL:$2|既存のアカウント|以下の$2アカウント}}と類似しすぎています:',
	'antispoof-conflict-bottom' => '別の名前を使用してください。',
	'antispoof-name-illegal' => '指定した名前 "$1" は成りすまし防止のため使用できません: $2。別の名前を使用してください。',
	'antispoof-badtype' => 'データタイプが異常です。',
	'antispoof-empty' => '文字列が空です',
	'antispoof-blacklisted' => '許可されていない文字が含まれています。',
	'antispoof-combining' => '結合記号で開始しています',
	'antispoof-unassigned' => '廃止予定または未割り当ての文字が含まれています',
	'antispoof-noletters' => '文字を含んでいません',
	'antispoof-mixedscripts' => '一緒に使うことできない複数の文字体系が混在しています',
	'antispoof-tooshort' => '正規化した名前が短すぎます',
	'antispoof-ignore' => 'なりすましチェックを無効にします。',
	'right-override-antispoof' => 'なりすましチェックを無視する',
	'antispoof-conflict-item' => '$1',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'antispoof-desc' => 'Blokerer før åprettelse af konti ve blandede tegnsæt, forvirrende eller lignende brugernavne',
	'antispoof-name-illegal' => 'Navnet "$1" er ikke tilladt for at forhindre forvirrende eller efterlignede brugernavne: $2. Vælg venligst et andet navn.',
	'antispoof-badtype' => 'Førkært datatype',
	'antispoof-empty' => 'Tom streng',
	'antispoof-blacklisted' => 'Indeholder sortlistet tegn',
	'antispoof-combining' => 'Begynder ve et kombinationsbogstav',
	'antispoof-unassigned' => 'Indeholder ubrugte bogstaver',
	'antispoof-noletters' => "Indeholder ig'n bogstaver",
	'antispoof-mixedscripts' => 'Indeholder inkompatible, blandede tegnsæt',
	'antispoof-tooshort' => 'Kanonisaliset navn til kårt',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'antispoof-desc' => 'Menggak nggawé akun utawa rékening mawa jeneng panganggo aksara campuran, mbingungaké lan sing mèmper',
	'antispoof-conflict-top' => 'Jeneng "$1" mèmper banget karo {{PLURAL:$2|akun sing wis ana|$2 akun iki}}:',
	'antispoof-conflict-bottom' => 'Mangga milih jeneng liya',
	'antispoof-name-illegal' => 'Jeneng "$1" ora diidinaké supaya wong ora bingung utawa menggak ngapi-api jeneng panganggo sing wis ana: $2.
Mangga pilihen jeneng liya.',
	'antispoof-badtype' => 'Tipe data salah',
	'antispoof-empty' => 'Data kosong',
	'antispoof-blacklisted' => 'Ngandhut karakter sing ora diidinaké',
	'antispoof-combining' => 'Diwiwiti karo tandha kombinasi',
	'antispoof-unassigned' => 'Ngandhut karakter sing ora ditunjuk utawa ora dienggo manèh',
	'antispoof-noletters' => 'Ora ngandhut aksara babar belas',
	'antispoof-mixedscripts' => 'Ngandhut aksara campuran sing ora kompatibel',
	'antispoof-tooshort' => 'Jeneng kanonikalisasi kecendhaken',
	'antispoof-ignore' => "Lirwakaké pamrikasaan panipuan akun (''spoofing'')",
	'right-override-antispoof' => "''Override'' pamriksan palècèhan",
);

/** Georgian (ქართული)
 * @author Alsandro
 * @author BRUTE
 * @author Nodar Kherkheulidze
 */
$messages['ka'] = array(
	'antispoof-desc' => 'ბლოკავს ახალი ანგარიშების გახსნას შერეული სკრიპტით, შეცდომითი და ერთიდაიგივე მომხმარებლის სახელების შეთხვევაში',
	'antispoof-conflict-top' => 'სახელი „$1“ ძალიან ჰგავს {{PLURAL:$2|არსებულ ანგარიშს|შემდეგ $2 ანგარიშს}}:',
	'antispoof-conflict-bottom' => 'გთხოვთ სხვა სახელი გამოიყენოთ.',
	'antispoof-name-illegal' => 'სახელი „$1“ არაა ნებადართული, რათა არ იყოს არეული სხვა სახელთან: $2.
გთხოვთ აირჩიოთ სხვა სახელი.',
	'antispoof-badtype' => 'არასწორი მონაცემთა ტიპი',
	'antispoof-empty' => 'ცარიელი სტრიქონი',
	'antispoof-blacklisted' => 'შეიცავს სიმბოლოს შავი სიიდან',
	'antispoof-combining' => 'იწყება კომბინაციის სიმბოლოთი',
	'antispoof-unassigned' => 'შეიცავს მიუკუთვნებელ ან დაუშვებელ სიმბოლოებს',
	'antispoof-noletters' => 'არ შეიცავს ასოებს',
	'antispoof-mixedscripts' => 'შეიცავს შეუთავსებელ შერეულ სცენარებს',
	'antispoof-tooshort' => 'ნორმალიზებული სახელი ძალიან მოკლეა',
	'antispoof-ignore' => 'მსგავს სახელებზე შემოწმების ინგნორირება',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'antispoof-name-illegal' => 'قاتىسۋشى اتى شاتاقتاۋىن نەمەسە قالجىنداۋىن بٶگەۋ ٷشٸن «$1» اتاۋى رۇقسات ەتٸلمەيدٸ: $2. باسقا اتاۋ تاڭداڭىز.',
	'antispoof-badtype' => 'جارامسىز دەرەك تٷرٸ',
	'antispoof-empty' => 'بوس جول',
	'antispoof-blacklisted' => 'قارا تٸزٸمگە كٸرگەن ٵرٸپ بار',
	'antispoof-combining' => 'قۇرامدى بەلگٸمەن باستالعان',
	'antispoof-unassigned' => 'تاعايىندالماعان نەمەسە تىيىلعان ٵرٸپ بار',
	'antispoof-noletters' => 'ٸشٸندە ەشبٸر ٵرٸپ جوق',
	'antispoof-mixedscripts' => 'ٸشٸندە سيىسپايتىن ارالاس جازۋ تٷرلەرٸ بار',
	'antispoof-tooshort' => 'ەرەجەلەنگەن اتاۋى تىم قىسقا',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'antispoof-name-illegal' => 'Қатысушы аты шатақтауын немесе қалжындауын бөгеу үшін «$1» атауы рұқсат етілмейді: $2. Басқа атау таңдаңыз.',
	'antispoof-badtype' => 'Жарамсыз дерек түрі',
	'antispoof-empty' => 'Бос жол',
	'antispoof-blacklisted' => 'Қара тізімге кірген әріп бар',
	'antispoof-combining' => 'Құрамды белгімен басталған',
	'antispoof-unassigned' => 'Тағайындалмаған немесе тыйылған әріп бар',
	'antispoof-noletters' => 'Ішінде ешбір әріп жоқ',
	'antispoof-mixedscripts' => 'Ішінде сиыспайтын аралас жазу түрлері бар',
	'antispoof-tooshort' => 'Ережеленген атауы тым қысқа',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'antispoof-name-illegal' => 'Qatıswşı atı şataqtawın nemese qaljındawın bögew üşin «$1» atawı ruqsat etilmeýdi: $2. Basqa ataw tañdañız.',
	'antispoof-badtype' => 'Jaramsız derek türi',
	'antispoof-empty' => 'Bos jol',
	'antispoof-blacklisted' => 'Qara tizimge kirgen ärip bar',
	'antispoof-combining' => 'Quramdı belgimen bastalğan',
	'antispoof-unassigned' => 'Tağaýındalmağan nemese tıýılğan ärip bar',
	'antispoof-noletters' => 'İşinde eşbir ärip joq',
	'antispoof-mixedscripts' => 'İşinde sïıspaýtın aralas jazw türleri bar',
	'antispoof-tooshort' => 'Erejelengen atawı tım qısqa',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'antispoof-conflict-top' => 'ឈ្មោះ "$1"គឺស្រដៀងគ្នានឹង {{PLURAL:$2|គណនីដែលមាន|គណនីចំនួន $2 ខាងក្រោម}} ពេកហើយ ៖',
	'antispoof-conflict-bottom' => 'សូមជ្រើសរើសឈ្មោះផ្សេងទៀត។',
	'antispoof-name-illegal' => 'ឈ្មោះ "$1" មិនត្រូវបានឱ្យបង្កើតទេ ដើម្បីកុំឱ្យច្រឡំជាមួយនឹងអត្តនាម៖ $2។

សូមជ្រើសរើសអត្តនាមផ្សេងមួយទៀត។',
	'antispoof-badtype' => 'ប្រភេទទិន្នន័យអន់',
	'antispoof-empty' => 'ខ្សែអក្សរទទេ',
	'antispoof-blacklisted' => 'មាន​អក្សរ​ដែល​ត្រូវបាន​ចាត់ចូលទៅក្នុងបញ្ជីខ្មៅ',
	'antispoof-noletters' => 'គ្មានផ្ទុក​អក្សរណាមួយ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Abhirama
 */
$messages['kn'] = array(
	'antispoof-conflict-bottom' => 'ಇನ್ನೊಂದು ಹೆಸರನ್ನು ಆಯ್ಕೆ ಮಾಡಿ.',
	'antispoof-name-illegal' => '$ 2: ಹೆಸರು "$ 1" ಗೊಂದಲ ಅಥವಾ ವಂಚಕ ಬಳಕೆದಾರರ ಹೆಸರುಗಳನ್ನು ತಡೆಯಲು ಅವಕಾಶವಿಲ್ಲ.
ಇನ್ನೊಂದು ಹೆಸರನ್ನು ಆಯ್ಕೆ ಮಾಡಿ.',
	'antispoof-badtype' => 'ಕೆಟ್ಟ ಮಾಹಿತಿ ರೀತಿ',
	'antispoof-empty' => 'ಖಾಲಿ ಸ್ಟ್ರಿನ್ಗ್',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'antispoof-desc' => '여러 문자 체계를 섞은 이름이나, 혼동될 수 있고 비슷한 이름의 계정 생성을 막음',
	'antispoof-conflict-top' => '계정 이름 "$1"은 {{PLURAL:$2|다음 계정|다음 $2개의 계정}}과 너무 비슷합니다:',
	'antispoof-conflict-bottom' => '다른 이름을 선택해주세요.',
	'antispoof-name-illegal' => '‘$1’ 사용자 이름은 다음의 이유로 인해 가입이 금지되었습니다: $2. 다른 이름으로 가입해주세요.',
	'antispoof-badtype' => '잘못된 자료형',
	'antispoof-empty' => '빈 문자열',
	'antispoof-blacklisted' => '사용이 금지된 문자를 포함하고 있습니다.',
	'antispoof-combining' => '혼합된 문자로 시작됩니다.',
	'antispoof-unassigned' => '코드가 부여되지 않거나 잘못된 문자를 포함하고 있습니다.',
	'antispoof-noletters' => '어떤 문자도 포함하고 있지 않습니다.',
	'antispoof-mixedscripts' => '여러 문자 체계가 섞여 있습니다.',
	'antispoof-tooshort' => '고유 이름이 너무 짧습니다.',
	'antispoof-ignore' => '안티스푸프 검사를 무시',
	'right-override-antispoof' => '혼란을 줄 수 있는 계정 이름 금지(안티스푸프)를 무시',
	'antispoof-conflict-item' => '$1',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'antispoof-desc' => 'Dat ongerdröck neu Name für Metmaacher met jemeschte Zeichensätz, neu Name, wo mer jeck von weed, un zo ähnlije Name.',
	'antispoof-conflict-top' => 'Dä Name „$1“ eß zoh ähnlesch met {{PLURAL:$2|däm Name, dä&32;|dä Name, di_j_|nix wadd_}}et ald jitt:',
	'antispoof-conflict-bottom' => 'Nemm ene andere Name.',
	'antispoof-name-illegal' => 'Dä Name „$1“ es nit zojelohße, domet mer kein nohjemahte Name krije, un keine Durjenein met Schrefte: $2. Sök Der jet anders als Dinge Name us.',
	'antispoof-badtype' => 'Verkierte Zoot Date',
	'antispoof-empty' => 'En dem Feld is nix dren',
	'antispoof-blacklisted' => 'Do sin Zeiche dren, die nit zojeloße sin.',
	'antispoof-combining' => 'Dat fängk med ennem kombineerende Zeiche aan.',
	'antispoof-unassigned' => 'Do sen Zeiche dren, die mer nit han welle, odder wo mer der Zeichesatz ja nit kenne.',
	'antispoof-noletters' => 'Do es nit eine Bochstabe dren.',
	'antispoof-mixedscripts' => 'He sin Zeichesätz jemesch.',
	'antispoof-tooshort' => 'Dä vereinheitlechte Name es zo koot.',
	'antispoof-ignore' => 'Donn de Prööfonge jäje et Name-Nohmaache övverjonn',
	'right-override-antispoof' => 'Prööfonge jäje et Name-Nohmaache (<i lang="en">Anti-Spoofing</i>) övverjonn',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'antispoof-name-illegal' => 'Non licet uti nomine "$1" ad nominum usorum simulationem prohibendam: $2. Selige nomen alterum.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'antispoof-desc' => "Verhënnert d'Opmaache vu Benotzerkonte mat gemëschten Zeechesätz, mat gelungene Benotzernimm oder mat Benotzernimm déi zu Verwiesselunge féiere kéinten.",
	'antispoof-conflict-top' => 'Den Numm "$1" ass ze ähnlech mat {{PLURAL:$2|dem Benotzerkont|dëse(n) $2 Benotzerkonten}}:',
	'antispoof-conflict-bottom' => 'Wielt w.e.g. en aneren Numm.',
	'antispoof-name-illegal' => 'De gewënschte Benotzernumm "$1" ass net erlaabt. Grond: $2<br />
Sicht iech w.e.g. een anere Benotzernumm.',
	'antispoof-badtype' => 'Ongültegt Fichiers-Format (bad data type)',
	'antispoof-empty' => 'Eidelt Feld',
	'antispoof-blacklisted' => 'Et si verbueden Zeechen (Caractèren) dran.',
	'antispoof-combining' => 'Fänkt mat engem Kombinatiounszeechen un.',
	'antispoof-unassigned' => 'Et sinn net zougeuerdnet oder onerwënschten Zeechen (Caractèren) dran.',
	'antispoof-noletters' => 'Et si keng Buschtawen dran.',
	'antispoof-mixedscripts' => 'Et si gemëschte Skripten dran, déi net kompatibel sinn',
	'antispoof-tooshort' => 'De kanoniséierten Numm ass ze kuerz.',
	'antispoof-ignore' => 'Keng Kontroll op ähnlech Benotzernimm',
	'right-override-antispoof' => "D'Resultat vun der Iwwerpréifung no ähnleche Benotzernimm ignoréieren",
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'antispoof-desc' => "Blokkeert 't aanmake van gebroekers mit miedere sjrifte, verwarrende en geliekmakende gebroekersname",
	'antispoof-conflict-top' => 'De naam "$1" liek te zeer op de volgende zeendje {{PLURAL:$2|gebroeker|$2 gebroekers}}:',
	'antispoof-conflict-bottom' => "Kees 'ne angere naam.",
	'antispoof-name-illegal' => 'De naam "$1" is net toegestaon óm verwarring of vervörmdje gebroekersname te veurkómme: $2. Kees estebleef \'ne angere naam.',
	'antispoof-badtype' => 'Verkeerd datatype',
	'antispoof-empty' => 'Laege string',
	'antispoof-blacklisted' => 'Bevat verbaoje karakter',
	'antispoof-combining' => "Begint mit 'n gecombineerd merkteike",
	'antispoof-unassigned' => 'Bevat neet toegeweze of verajerdj karakter',
	'antispoof-noletters' => 'Bevat gein letters',
	'antispoof-mixedscripts' => 'Bevat neet compatibele sjrifter.',
	'antispoof-tooshort' => 'Aafgekorte naam te kort',
	'antispoof-ignore' => 'Spoofcontroles negere',
	'right-override-antispoof' => 'Spoofkonträöl negere',
);

/** Lao (ລາວ) */
$messages['lo'] = array(
	'antispoof-name-illegal' => 'ບໍ່ສາມາດອະນຸຍາດ ຊື່ "$1" ໄດ້ ເພີ່ມຫຼີກລ້ຽງ ການສັບສົນ ກັບ : $2. ກະລຸນາເລືອກຊື່ອື່ນ.',
	'antispoof-badtype' => 'ປະເພດ ຂໍ້ມູນ ບໍ່ຖືກຕ້ອງ',
	'antispoof-empty' => 'ບໍ່ມີໂຕໜັງສື',
	'antispoof-blacklisted' => 'ມີໂຕໜັງສືໃນບັນຊີດຳ',
	'antispoof-combining' => 'ເລີ່ມຕົ້ນດ້ວຍເຄື່ອງໝາຍປະສົມ',
	'antispoof-noletters' => 'ບໍ່ມີໂຕໜັງສື',
	'antispoof-mixedscripts' => 'ມີສະກຣິບປະປົນແບບບໍ່ຖືກຕ້ອງ',
	'antispoof-tooshort' => 'ຊື່ຫຍໍ້ສັ້ນໂພດ',
);

$messages['lol'] = array(
	'antispoof-desc' => 'crwdns64958:0crwdne64958:0',
	'antispoof-conflict-top' => 'crwdns64959:0{PLURAL:$2|the existing account|the following $2 accounts}crwdne64959:0',
	'antispoof-conflict-item' => 'crwdns64960:0crwdne64960:0',
	'antispoof-conflict-bottom' => 'crwdns64961:0crwdne64961:0',
	'antispoof-name-illegal' => 'crwdns64962:0crwdne64962:0',
	'antispoof-badtype' => 'crwdns64963:0crwdne64963:0',
	'antispoof-empty' => 'crwdns64964:0crwdne64964:0',
	'antispoof-blacklisted' => 'crwdns64965:0crwdne64965:0',
	'antispoof-combining' => 'crwdns64966:0crwdne64966:0',
	'antispoof-unassigned' => 'crwdns64967:0crwdne64967:0',
	'antispoof-noletters' => 'crwdns64968:0crwdne64968:0',
	'antispoof-mixedscripts' => 'crwdns64969:0crwdne64969:0',
	'antispoof-tooshort' => 'crwdns64970:0crwdne64970:0',
	'antispoof-ignore' => 'crwdns64971:0crwdne64971:0',
	'right-override-antispoof' => 'crwdns64972:0crwdne64972:0',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Ignas693
 * @author Perkunas
 */
$messages['lt'] = array(
	'antispoof-desc' => 'Blokuoja kūrimą paskyrų, turinčių maišyto scenarijaus, klaidinančius ar panašius naudotojų vardus',
	'antispoof-conflict-top' => 'Vardas "$1" yra per daug panašus į {{PLURAL:$2|esamų paskyra|su $2 paskyromis}}:',
	'antispoof-conflict-bottom' => 'Prašome pasirinkti kitą vardą.',
	'antispoof-name-illegal' => 'Vardas "$1" neleidžiamas, kad būtų apsisaugota nuo apgaulingų ar parodijuotų naudotojų vardų: $2. Prašome pasirinkti kitą vardą.',
	'antispoof-badtype' => 'Blogas duomenų tipas',
	'antispoof-empty' => 'Tuščias tekstas',
	'antispoof-blacklisted' => 'Turi uždraustų simbolių',
	'antispoof-combining' => 'Prasideda kombinavimo ženklu',
	'antispoof-unassigned' => 'Yra nepaskirtų arba nebenaudotinų simbolių',
	'antispoof-noletters' => 'Nėra nei vienos raidės',
	'antispoof-mixedscripts' => 'Turi nepalaikomų įvairių rašmenų',
	'antispoof-tooshort' => 'Kanonizuotas vardas per trumpas',
	'antispoof-ignore' => 'Nepaisyti spoofing patikrinimai',
	'right-override-antispoof' => 'Nepaisyti spoofing patikrinimai',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 * @author Papuass
 */
$messages['lv'] = array(
	'antispoof-desc' => 'Bloķē kontu izveidi ar jauktas rakstības, mulsinošiem un līdzīgiem lietotājvārdiem',
	'antispoof-conflict-top' => 'Nosaukums "$1" ir pārāk līdzīgs {{PLURAL:$2|esošajam kontam|šiem $2 kontiem}}:',
	'antispoof-conflict-bottom' => 'Lūdzu, izvēlieties citu faila nosaukumu.',
	'antispoof-badtype' => 'Nederīgs datu tips',
	'antispoof-empty' => 'Tukša virkne',
	'antispoof-blacklisted' => 'Satur aizliegtu simbolu',
	'antispoof-unassigned' => 'Satur nepiešķirtu vai novecojušu rakstzīmi',
	'antispoof-noletters' => 'Nesatur nevienu burtu',
	'antispoof-mixedscripts' => 'Satur nesavietojamas jauktas rakstu zīmes',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'antispoof-desc' => 'Menggak nggawé akun sing jeneng panganggone nganggo aksara campuran, mbingungna lan sing mèmper',
	'antispoof-conflict-top' => 'Jeneng "$1" mèmper banget karo {{PLURAL:$2|akun sing wis ana|$2 akun kiye}}:',
	'antispoof-conflict-bottom' => 'Monggo milih jeneng liyane.',
	'antispoof-name-illegal' => 'Jeneng "$1" ora olih dinggo supaya wong ora bingung utawa menggak ngapi-api jeneng panganggo sing wis ana: $2.
Monggo pilihen jeneng liyane baen.',
	'antispoof-badtype' => 'Tipe data salah',
	'antispoof-empty' => 'Data kosong',
	'antispoof-blacklisted' => 'Ngandhut karakter sing ora olih dienggo',
	'antispoof-combining' => 'Diwiwiti karo tandha kombinasi',
	'antispoof-unassigned' => 'Ngandhut karakter sing ora ditunjuk utawa uwis ora dienggo maning',
	'antispoof-noletters' => 'Ora ngandhut aksara babar belas',
	'antispoof-mixedscripts' => 'Ngandhut aksara campuran sing ora kompatibel',
	'antispoof-tooshort' => 'Jeneng kanonikalisasi kecendhaken',
	'antispoof-ignore' => "Lirwakaké pamrikasaan panipuan akun (''spoofing'')",
	'right-override-antispoof' => "''Override'' pamriksan palècèhan",
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'antispoof-desc' => 'Manakana ny fanokafana kaonty miaraka amina anaram-pikambana mitovy, mampiasa fomba fanoratana samihafa, na mety azo afangaron.',
	'antispoof-name-illegal' => 'Tsy mahazo alalana ny anaram-pikambana "$1" noho ny fanakekezany amin\'ny anarana "$2".
Misafidia anarana hafa.',
	'antispoof-badtype' => 'Tsy izy ny karazana fampahalalàna',
	'antispoof-empty' => 'fitohitohizan-tsoratra (string) foàna',
	'antispoof-blacklisted' => 'Misy tarehintsoratra voarara',
	'antispoof-combining' => 'Manomboka amina mari-pitambatambarana (marque combinatoire)',
	'antispoof-noletters' => 'Tsy misy tarehintsoratra',
	'antispoof-mixedscripts' => 'Misy endri-tsoratra maro samihafa tsy zaka',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'antispoof-desc' => 'Блокира создавање на сметки со имиња од мешани писма/азбуки, кои личат на други кориснички имиња и со тоа создаваат забуни',
	'antispoof-conflict-top' => 'Името „$1“ е премногу слично на {{PLURAL:$2|постоечката сметка|следниве $2 сметки}}:',
	'antispoof-conflict-bottom' => 'Одберете друго име',
	'antispoof-name-illegal' => 'Името „$1“ не е дозволено за да сес пречат збунувачки имиња кои се злоупотребливо слични: $2.
Одберете друго име.',
	'antispoof-badtype' => 'Грешен тип на податоци',
	'antispoof-empty' => 'Празна низа',
	'antispoof-blacklisted' => 'Содржи забранет знак',
	'antispoof-combining' => 'Започнува со составен знак',
	'antispoof-unassigned' => 'Содржи неопределен или застарен знак',
	'antispoof-noletters' => 'Не содржи букви',
	'antispoof-mixedscripts' => 'Содржи нескладни мешани писма/азбуки',
	'antispoof-tooshort' => 'Нормализираното име е премногу кратко',
	'antispoof-ignore' => 'Занемарување на меѓусебно слични имиња',
	'right-override-antispoof' => 'Прескокнување на проверките за меѓусебно слични имиња',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'antispoof-desc' => 'സങ്കരലിപി, തെറ്റിദ്ധാരണ ഉളവാക്കുന്ന നാമം, ഒരേ തരത്തിലുള്ള ഉപയോക്തൃനാമം എന്നിവ ഉപയോഗിച്ചുള്ള അംഗത്വസൃഷ്ടി തടയൽ',
	'antispoof-conflict-top' => '"$1" എന്ന നാമം {{PLURAL:$2|നിലവിലുള്ള അംഗത്വത്തിനോടു|താഴെ പറയുന്ന $2 അംഗത്വങ്ങളോടു}} വളരെ സാമ്യമുള്ളതാണ്:',
	'antispoof-conflict-bottom' => 'മറ്റൊരു പേരു തിരഞ്ഞെടുക്കുക.',
	'antispoof-name-illegal' => 'ഉപയോക്തൃനാമത്തിലെ തെറ്റിദ്ധാരണയും സ്പൂഫിങ്ങും ഒഴിവാക്കാൻ "$1" എന്ന ഉപയോക്തൃനാമം അനുവദനീയമല്ല: $2.
ദയവായി മറ്റൊരു നാമം തിരഞ്ഞെടുക്കുക.',
	'antispoof-badtype' => 'മോശം ഡേറ്റാ തരം',
	'antispoof-empty' => 'ശൂന്യമായ അക്ഷരക്കൂട്ടം',
	'antispoof-blacklisted' => 'കരിമ്പട്ടികയിൽ പെട്ട അക്ഷരങ്ങളുണ്ട്',
	'antispoof-combining' => 'യോജിപ്പിക്കാനുള്ള അടയാളത്തോടെ തുടങ്ങുന്നു',
	'antispoof-unassigned' => 'നിർദ്ദേശിക്കപ്പെടാത്തതോ പിന്തള്ളപ്പെട്ടതോ ആയ അക്ഷരം ഉൾക്കൊള്ളുന്നു',
	'antispoof-noletters' => 'അക്ഷരങ്ങൾ ഒന്നും തന്നെ ഇല്ല',
	'antispoof-mixedscripts' => 'പൊരുത്തക്കേടുള്ള സങ്കരലിപികൾ ഉൾപ്പെടുന്നു',
	'antispoof-tooshort' => 'ചട്ടപ്പടിയാക്കിയ പേര് വളരെ ചെറുതാണ്',
	'antispoof-ignore' => 'സ്പൂഫിങ് പരിശോധനകൾ അവഗണിക്കുക',
	'right-override-antispoof' => 'സ്പൂഫിങ് പരിശോധനകൾ അതിലംഘിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'antispoof-desc' => 'Олон тэмдэгтийн системүүдийг хольсон, будилж болох, ойролцоо хэрэглэгчийн нэрийг үүсгэхээс сэргийлдэг.',
	'antispoof-conflict-top' => '"$1" гэсэн нэр нь одоо оршиж буй {{PLURAL:$2|дараах|дараах $2}} бүртгэлтэй хэтэрхий төстэй байна:',
	'antispoof-conflict-bottom' => 'Өөр нэр сонгоно уу.',
	'antispoof-name-illegal' => '"$1" гэсэн нэр нь андуурагдаж болохуйц, хуурмаг хэрэглэгчийн нэрнүүдээс сэргийлэхийн тулд зөвшөөрөгдөхгүй: $2.
Өөр нэр сонгоно уу.',
	'antispoof-badtype' => 'Буруу өгөгдлийн төрөл',
	'antispoof-empty' => 'Хоосон цуваа',
	'antispoof-blacklisted' => 'Хар дансанд орсон тэмдэгт агуулагдаж байна',
	'antispoof-combining' => 'Холбох тэмдэгээр эхлэж байна',
	'antispoof-unassigned' => 'Тогтоогоогүй эсвэл хуучирсан тэмдэгт агуулагдаж байна',
	'antispoof-noletters' => 'Ямар ч тэмдэгт агуулагдаагүй байна',
	'antispoof-mixedscripts' => 'Хоорондоо нийцэхгүй холилдсон бичилтүүд агуулагдаж байна',
	'antispoof-tooshort' => 'Албан ёсны нэр хэт богино байна',
	'antispoof-ignore' => 'Ойролцоо нэрний шалгуурыг үл тоомсорлох',
	'right-override-antispoof' => 'Ойролцоо нэрний шалгуурыг няцаах',
);

/** Marathi (मराठी)
 * @author Balaji
 * @author Dnyanesh325
 * @author Kaustubh
 * @author Mahitgar
 * @author Mvkulkarni23
 * @author Saleelk
 * @author प्रणव कुलकर्णी
 */
$messages['mr'] = array(
	'antispoof-desc' => 'मिश्र भाषा तसेच संभ्रमित करणारी व सारखी असणारी सदस्य नामे वापरण्यास बंदी आहे.',
	'antispoof-conflict-top' => '"$1" नाव {{PLURAL:$2|या अस्तित्वातील खात्याशी|निम्नलिखीत  $2 खात्यांशी}} मिळतेजुळते आहे:',
	'antispoof-conflict-bottom' => 'कृपया दुसरे नाव निवडा.',
	'antispoof-name-illegal' => '"$1" हे नाव वापरण्यास बंदी आहे कारण हे नाव इतर नावांशी साम्य राखते: $2.
त्यामुळे कृपया वेगळे नाव वापरा.',
	'antispoof-badtype' => 'वाईट विदा (डाटा) प्रकार',
	'antispoof-empty' => 'रिकामा धागा',
	'antispoof-blacklisted' => 'मान्यताप्राप्त यादीत नसलेले अक्षर',
	'antispoof-combining' => 'एकत्रीकरण चिन्हाने सुरुवात केलेली आहे.',
	'antispoof-unassigned' => 'यामध्ये चुकीची चिन्हे आहेत.',
	'antispoof-noletters' => 'कोणत्याही अक्षराचा समावेश नाही',
	'antispoof-mixedscripts' => 'यामध्ये इतर मिश्र लिपी आहेत.',
	'antispoof-tooshort' => 'अधिकारयुक्त नाव खूप छोटे आहे',
	'antispoof-ignore' => 'नकली चिन्हे विसरा',
	'right-override-antispoof' => 'स्पूफिंग चेक्स कडे दुर्लक्ष करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'antispoof-desc' => 'Menyekat pembukaan akaun dengan nama pengguna yang mengelirukan, menyerupai orang lain, atau terdiri daripada campuran sistem-sistem tulisan yang berlainan',
	'antispoof-conflict-top' => 'Nama "$1" menyerupai {{PLURAL:$2|akaun berikut|$2 akaun berikut}}:',
	'antispoof-conflict-bottom' => 'Sila pilih nama lain.',
	'antispoof-name-illegal' => 'Nama "$1" tidak dibenarkan kerana mengelirukan atau menipu: $2. Sila pilih nama lain.',
	'antispoof-badtype' => 'Jenis data salah',
	'antispoof-empty' => 'Rentetan kosong',
	'antispoof-blacklisted' => 'Mengandungi aksara yang telah disenaraihitamkan',
	'antispoof-combining' => 'Bermula dengan tanda penggabung',
	'antispoof-unassigned' => 'Mengandungi aksara yang tidak sah atau yang telah dimansuhkan',
	'antispoof-noletters' => 'Tidak mengandungi huruf',
	'antispoof-mixedscripts' => 'Mengandungi campuran sistem-sistem tulisan yang tidak bersesuaian',
	'antispoof-tooshort' => 'Nama berkanun terlalu pendek',
	'antispoof-ignore' => 'Abaikan pemeriksaan penipuan',
	'right-override-antispoof' => 'Mengatasi pemeriksaan penipuan',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'antispoof-desc' => "Jimblokka l-ħolqien ta' kontijiet b'karattri mħawwda, ismijiet tal-utent li joħolqu konfużjoni jew huma wisq simili ma' xulxin.",
	'antispoof-conflict-top' => 'L-isem "$1" huwa wisq simili {{PLURAL:$2|għall-kont eżistenti|għal $2 kontijiet segwenti}}:',
	'antispoof-conflict-bottom' => 'Jekk jogħġbok agħżel isem ieħor.',
	'antispoof-name-illegal' => 'L-isem "$1" mhuwiex permess sabiex jiġi evitat kwalunkwe konfużjoni jew użu qarrieq: $2. Agħżel isem ieħor.',
	'antispoof-empty' => 'Stringa vojta',
	'antispoof-blacklisted' => 'Jinkludi karattri li mhumiex permessi',
	'antispoof-combining' => "Jibda b'karattru ta' kombinazzjoni",
	'antispoof-noletters' => 'Ma jinkludix ittri',
);

/** Erzya (Эрзянь)
 * @author Amdf
 */
$messages['myv'] = array(
	'antispoof-empty' => 'Чаво пикске',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'antispoof-badtype' => 'Ahcualli tlahcuilōliztli',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'antispoof-desc' => 'Hindrer oppretting av kontoer med lignende eller forvirrende brukernavn, eller brukernavn som inneholder to forskjellige alfabettyper',
	'antispoof-conflict-top' => 'Navnet «$1» er for likt følgende {{PLURAL:$2|konto|kontoer}}:',
	'antispoof-conflict-bottom' => 'Velg et annet navn.',
	'antispoof-name-illegal' => 'Navnet «$1» er ikke tillatt for å forhindre sammenblanding: $2. Vennligst velg et annet navn.',
	'antispoof-badtype' => 'Ugyldig datatype',
	'antispoof-empty' => 'Tom streng',
	'antispoof-blacklisted' => 'Inneholder svartelistede tegn',
	'antispoof-combining' => 'Begynner med kombinasjonstegn',
	'antispoof-unassigned' => 'Inneholder ugyldig eller foreldet tegn.',
	'antispoof-noletters' => 'Inneholder ingen bokstaver',
	'antispoof-mixedscripts' => 'Inneholder blanding av skriftsystemer',
	'antispoof-tooshort' => 'Navnet er for kort',
	'antispoof-ignore' => 'Ignorer misbrukssjekk',
	'right-override-antispoof' => 'Overkjøre sjekk av brukernavn',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'antispoof-desc' => 'Verhinnert dat Opstellen vun Brukerkonten mit mischte Tekensätz un Brukernaams, de verwirrt oder liek utseht as annere Brukernaams',
	'antispoof-conflict-top' => 'De Naam „$1“ is to ähnlich to {{PLURAL:$2|dat Brukerkonto|de $2 Brukerkonten}}, de dat al gifft:',
	'antispoof-conflict-bottom' => 'Söök di en annern Naam ut.',
	'antispoof-name-illegal' => 'De Brukernaam „$1“ is nich verlöövt. Grund: $2<br />Söök di en annern Brukernaam ut.',
	'antispoof-badtype' => 'Leeg Datentyp',
	'antispoof-empty' => 'Feld leddig',
	'antispoof-blacklisted' => 'In’n Text sünd nich verlöövte Teken binnen',
	'antispoof-combining' => 'Kombinatschoonsteken to Anfang',
	'antispoof-unassigned' => 'In’n Text sünd nich toornte oder nich wünschte Teken binnen',
	'antispoof-noletters' => 'Dor sünd kene Bookstaven in.',
	'antispoof-mixedscripts' => 'in’n Text sünd Teken ut verschedene Schriftsystemen binnen',
	'antispoof-tooshort' => 'De kanoniseerte Naam is to kort.',
	'antispoof-ignore' => 'Nich op ähnliche Brukernaams pröfen',
	'right-override-antispoof' => 'De Kuntrull op ähnliche Brukernaams ümgahn',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'antispoof-desc' => 'Blokkeert t anmaken van gebrukers mit meerdere schriften, verwarrende en soortgelieke gebrukersnamen',
	'antispoof-conflict-top' => 'De naam "$1" lik te veule op de volgende bestaonde {{PLURAL:$2|gebruker|$2 gebrukers}}:',
	'antispoof-conflict-bottom' => 'Kies n aandere naam.',
	'antispoof-name-illegal' => 'De naam "$1" is niet toe-estaon, um verwarring of lelike gebrukersnamen te veurkoemen: $2. Kies n aandere naam.',
	'antispoof-badtype' => 'Ongeldig datatype',
	'antispoof-empty' => 'Leeg veld',
	'antispoof-blacklisted' => "Bevat tekens die'j niet gebruken maggen",
	'antispoof-combining' => 'Begint mit n ekombineerd markteken',
	'antispoof-unassigned' => 'Bevat n niet toe-ewezen of ongewunst teken',
	'antispoof-noletters' => 'Bevat gien letters',
	'antispoof-mixedscripts' => 'Bevat onverenigbaore schriftsystemen',
	'antispoof-tooshort' => "De naam die'j in-evoerd hebben is te kort.",
	'antispoof-ignore' => 'Kontrole op soortgelieke gebrukersnamen negeren',
	'right-override-antispoof' => 'Fopkontroles negeren',
);

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author Bhawani Gautam Rhk
 */
$messages['ne'] = array(
	'antispoof-desc' => 'भ्रामक तथा एकै प्रकारका प्रयोगकर्ता नामहरु, मिश्रित-स्क्रिप्ट भएका खाताहरु बनाउनमाथि रोक लगाउने',
	'antispoof-conflict-top' => ' "$1" नाम  {{PLURAL:$2|वर्तमान खाता|निम्नलिखित  $2 खाताहरु}}सित मेल खाँदैछ:',
	'antispoof-conflict-bottom' => 'कृपया अर्को नाम छान्नुहोस्।',
	'antispoof-name-illegal' => '$2 भ्रामक र जाली प्रयोगकर्ता नामको रोकथामको निम्ति "$1" नामलाई अनुमति छैन।
कृपया अर्को नाम छान्नुहोस्।',
	'antispoof-badtype' => 'अमान्य आँकड़ा प्रकार',
	'antispoof-empty' => 'रिक्त रज्जु (string)',
	'antispoof-blacklisted' => 'कालो सूचीकृत चरित्र भएको',
	'antispoof-combining' => 'संयोजन चिन्हबाट सुरु हुने',
	'antispoof-noletters' => 'कुनै अक्षरहरु नभएको',
	'antispoof-mixedscripts' => 'असंगत मिश्रित लिपिहरु सम्मिलित गरिएको',
	'antispoof-tooshort' => 'संक्षिप्त साह्रै छोटो नाम',
	'antispoof-ignore' => 'धोका रोकाईलाई अन्देखा गर्ने',
);

/** Dutch (Nederlands)
 * @author Erwin
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'antispoof-desc' => 'Blokkeert het aanmaken van gebruikersnamen in meerdere schriften, en verwarrende en gelijkende gebruikersnamen',
	'antispoof-conflict-top' => 'De naam "$1" lijkt te veel op de volgende bestaande {{PLURAL:$2|gebruiker|$2 gebruikers}}:',
	'antispoof-conflict-bottom' => 'Kies een andere naam.',
	'antispoof-name-illegal' => 'De naam "$1" is niet toegestaan om verwarring of gefingeerde gebruikersnamen te voorkomen: $2.
Kies een andere naam.',
	'antispoof-badtype' => 'Ongeldig gegevenstype',
	'antispoof-empty' => 'Lege string',
	'antispoof-blacklisted' => 'Bevat verboden karakter',
	'antispoof-combining' => 'Begint met een gecombineerd merkteken',
	'antispoof-unassigned' => 'Bevat niet toegewezen of verouderd karakter',
	'antispoof-noletters' => 'Bevat geen letters',
	'antispoof-mixedscripts' => 'Bevat niet compatibele schriften',
	'antispoof-tooshort' => 'Afgekorte naam te kort',
	'antispoof-ignore' => 'Controle op gelijkende gebruikersnamen negeren',
	'right-override-antispoof' => 'Spoofcontroles negeren',
	'antispoof-conflict-item' => '$1',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'antispoof-desc' => 'Blokkerer for oppretting av konti med liknande eller forvirrande brukarnamn, eller brukarnamn som inneheld forskjellige alfabettypar',
	'antispoof-conflict-top' => 'Namnet «$1» er for likt følgjande {{PLURAL:$2|konto|kontoar}}:',
	'antispoof-conflict-bottom' => 'Vel eit anna namn.',
	'antispoof-name-illegal' => 'Namnet «$1» er ikkje tillate for å hindra samanblanding: $2.
Ver venleg og vel eit anna namn.',
	'antispoof-badtype' => 'Ugyldig datatype',
	'antispoof-empty' => 'Tom streng',
	'antispoof-blacklisted' => 'Inneheld svartelista teikn',
	'antispoof-combining' => 'Byrjar med eit kombinasjonsteikn',
	'antispoof-unassigned' => 'Inneheld ugyldige eller forelda teikn',
	'antispoof-noletters' => 'Inneheld ingen bokstavar',
	'antispoof-mixedscripts' => 'Inneheld blanding av ikkje-kompatible skriftsystem',
	'antispoof-tooshort' => 'Namnet er for kort',
	'antispoof-ignore' => 'Ignorer misbrukssjekk',
	'right-override-antispoof' => 'Overkøyra sjekk av brukarnamn',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'antispoof-conflict-bottom' => 'Ka kgopelo, kgetha leina le lengwe.',
	'antispoof-name-illegal' => 'Leina le "$1", ga la dumelwa go thibela go rarakana: $2. Ka kgopelo, kgetha leina le lengwe.',
	'antispoof-badtype' => "Mohuta o mobe wa 'data'",
	'antispoof-blacklisted' => 'E nale dihlaka tšeo di sego tša dumelwa',
	'antispoof-noletters' => 'Ga e na dihlaka',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'antispoof-desc' => "Blòca, amb un escript mixt, la creacion dels comptes per de noms d'utilizaires similars o podent prestar a confusion.",
	'antispoof-conflict-top' => 'Lo nom « $1 » es tròp similar {{PLURAL:$2|al compte existent|als $2 comptes seguents}} :',
	'antispoof-conflict-bottom' => 'Causissètz un autre nom.',
	'antispoof-name-illegal' => 'Lo nom « $1 » es pas autorizat per empachar de confondre o d’utilizar lo nom « $2 ». Causissètz un autre nom.',
	'antispoof-badtype' => 'Marrit tipe de donadas',
	'antispoof-empty' => 'Cadena voida',
	'antispoof-blacklisted' => 'Conten un caractèr interdich',
	'antispoof-combining' => 'Comença amb una marca combinada',
	'antispoof-unassigned' => 'Conten un caractèr non assignat o obsolèt',
	'antispoof-noletters' => 'Conten pas cap de letra',
	'antispoof-mixedscripts' => 'Conten mantun escript incompatible',
	'antispoof-tooshort' => 'Nom canonic tròp cort',
	'antispoof-ignore' => "Ignorar las verificacions d'engana",
	'right-override-antispoof' => 'Espotís de pseudoverificacions',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'antispoof-desc' => 'ମିଶା-ସ୍କ୍ରିପ୍ଟ, ଭ୍ରମାତ୍ମକ ଓ ଏକା ଇଉଜର ନାଆଁ ତିଆରିକୁ ବନ୍ଦ କରିଥାଏ',
	'antispoof-conflict-top' => '"$1"  ନାଆଁଟି {{PLURAL:$2|ଆଗରୁ ଥିବା ଖାତା|$2 ଖାତାଗୁଡ଼ିକ}} ସହିତ ବହୁତ ସମାନ:',
	'antispoof-conflict-bottom' => 'ଦୟାକରି ଆଉ ଗୋଟେ ନାଆଁ ବାଛନ୍ତୁ ।',
	'antispoof-name-illegal' => 'ସନ୍ଦେହ ହେଲାଭଳି ନାଆଁପାଇଁ "$1" ନାଆଁଟିକୁ ଅନୁମତି ଦେଇପାରୁନାହୁଁ: $2 ।
ଦୟାକରି ଆଉଗୋଟିଏ ନାଆଁ ବାଛନ୍ତୁ ।',
	'antispoof-badtype' => 'ଖରାପ ତଥ୍ୟ',
	'antispoof-empty' => 'ଖାଲି ଘର',
	'antispoof-blacklisted' => 'ଏହା ଭିତରେ ବାରଣ କରାଯାଇଥିବା ନାଆଁ ଅଛି',
	'antispoof-combining' => 'ମିଶାଇବା ଚିହ୍ନସହ ଆରମ୍ଭ ହୁଏ',
	'antispoof-unassigned' => 'ଏଥିରେ ଏବେଯାଏଁ ଦିଆ ଯାଇନଥିବା ବା ବାରଣ କରାଯାଇଥିବା ନାଆଁ ଅଛି',
	'antispoof-noletters' => 'ଏଥିରେ କିଛି ବି ଲେଖା ନାହିଁ',
	'antispoof-mixedscripts' => 'ଏଥିରେ ମିଶୁନଥିବା ଅଜଣା ଲେଖା ଅଛି',
	'antispoof-tooshort' => 'ମୂଳ ନାଆଁଟି ଖୁବ ସାନ',
	'antispoof-ignore' => 'ଖରାପ ନାଆଁକୁ ଦେଖନ୍ତୁ ନାହିଁ',
	'right-override-antispoof' => 'ଜାଣିଶୁଣି କରାଯିଇଥିବା ଭୁଲସବୁକୁ ଅଣଦେଖା କରିବେ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 * @author Amire80
 */
$messages['os'] = array(
	'antispoof-empty' => 'Афтид рæнхъ',
	'antispoof-noletters' => 'Иу дамгъæ дæр нæй',
);

/** Pangasinan (Pangasinan) */
$messages['pag'] = array(
	'antispoof-empty' => 'String ya Andilugan',
	'antispoof-blacklisted' => 'Walay laman ton bawal ya character',
	'antispoof-noletters' => 'Anggapoy laman ton letra',
);

/** Pampanga (Kapampangan)
 * @author Katimawan2005
 */
$messages['pam'] = array(
	'antispoof-desc' => 'Sabatan na ing pamaglalang kareng account a maki misasamut a kulit (mixed-script), makabaligo ampong miwawangis a lagyungtalagamit (username).',
	'antispoof-name-illegal' => 'E malyaring gamitan ing  "$1" uling bawal la reng username a mákabaligo o balamu piglocu: $2. Sana mamili kang aliwang lagyu.',
	'antispoof-badtype' => 'Marauak a uri ning data',
	'antispoof-blacklisted' => 'Makit kulit (character) yang mibawal',
	'antispoof-combining' => 'Maki tatak yang mangabaldugang pamituglung',
	'antispoof-noletters' => 'Ala yang letra',
	'antispoof-mixedscripts' => 'Misamut la reng sulat a e malyaring piyabe',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'antispoof-desc' => 'Blokuje tworzenie kont użytkowników o nazwach podobnych do już istniejących lub dezorientujących',
	'antispoof-conflict-top' => 'Nazwa „$1” jest zbyt podobna do {{PLURAL:$2|nazwy istniejącego konta|nazw następujących $2 kont}}:',
	'antispoof-conflict-bottom' => 'Proszę wybrać inną nazwę.',
	'antispoof-name-illegal' => 'Wybierz inną nazwę, ponieważ „$1” nie może być użyta ze względu na podobieństwo do nazwy innego użytkownika „$2”.',
	'antispoof-badtype' => 'Zły typ danych',
	'antispoof-empty' => 'Pusty ciąg znaków',
	'antispoof-blacklisted' => 'Zawiera niedozwolone znaki',
	'antispoof-combining' => 'Zaczyna się od łącznika',
	'antispoof-unassigned' => 'Zawiera nieprzypisany lub wycofany znak',
	'antispoof-noletters' => 'Nie zawiera liter',
	'antispoof-mixedscripts' => 'Zawiera przemieszane znaki niezgodnych ze sobą pism',
	'antispoof-tooshort' => 'Zbyt krótka nazwa użytkownika',
	'antispoof-ignore' => 'Ignoruj podobieństwo do istniejących nazw',
	'right-override-antispoof' => 'Brak ograniczenia przed zakładaniem kont o podobnych nazwach do już istniejących',
	'antispoof-conflict-item' => '$1',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'antispoof-desc' => 'A blòca la creassion ëd cont con nòm utent mës-cià a script, confundent e via parèj',
	'antispoof-conflict-top' => 'Ël nòm "$1" a smija tròp {{PLURAL:$2|al cont esistent|a sti $2 cont-sì}}:',
	'antispoof-conflict-bottom' => "Për piasì sern n'àutr nòm.",
	'antispoof-name-illegal' => 'Lë stranòm "$1" as peul nen dovresse për evité confusion e/ò che cheidun as fassa passé për: $2. Për piasì, ch\'as në sërna n\'àotr.',
	'antispoof-badtype' => 'Sòrt ëd dat nen bon-a',
	'antispoof-empty' => 'Espression veujda',
	'antispoof-blacklisted' => "A-i é ëd caràter ch'as peulo pa dovresse",
	'antispoof-combining' => 'As anandia con na combinassion',
	'antispoof-unassigned' => "A son dovrasse dij caràter nen assignà, ò pura ch'as dovrìo pì nen dovresse",
	'antispoof-noletters' => "A l'ha pa gnun caràter",
	'antispoof-mixedscripts' => "Combinassion ëd sistema dë scritura ch'as peulo pa butesse ansema",
	'antispoof-tooshort' => 'Butà an forma canònica lë stranòm a resta esagerà curt',
	'antispoof-ignore' => 'Sàuta ij controj dë spoofing',
	'right-override-antispoof' => 'Ignora ij controj dë spoofing',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'antispoof-desc' => 'ایدے توں ملے جلے، سر پھرے تے رلدے خط آلے ورتن ناں بنن توں رک جاندے نیں',
	'antispoof-conflict-top' => 'اے ناں "$1" پہلاں توں بنے ہوۓ {{PLURAL:$2|اس ورتن ناں|ایناں ورتن ناواں}} دے نال بوت رلدا اے:',
	'antispoof-conflict-bottom' => 'مہربنی کرکے ہور ناں چنو',
	'antispoof-name-illegal' => 'اس ناں "$1" توں ورتن ناں نئیں بنایا جا سکدا کیونجے انجان تے مزاحیہ دے اتے روک اے: $2
مہربانی کر کے کوئی دوجا ناں چنو۔',
	'antispoof-badtype' => 'ڈیٹا ٹھیک نیں',
	'antispoof-empty' => 'خالی سلسلہ',
	'antispoof-blacklisted' => 'ایدے چ بنا اجازت والیاں چیزاں نیں۔',
	'antispoof-combining' => 'جوڑن والے نشان نال ٹردا اے',
	'antispoof-unassigned' => 'ایدے کج کیریکٹر پھیک نیں',
	'antispoof-noletters' => 'ایدے چ کوئی اکرا نیں۔',
	'antispoof-mixedscripts' => 'ایدے چ رلے ملے تے ناں ملن والے کیریکٹر نیں',
	'antispoof-tooshort' => 'وڈے ناں بعوت نکے نیں',
	'antispoof-ignore' => 'بے تکیاں چیزاں ناں چیک کرو',
	'right-override-antispoof' => 'بےتکیاں چیزاں نوں چھڈو',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'antispoof-conflict-bottom' => 'لطفاُ يو بل نوم وټاکۍ.',
	'antispoof-badtype' => 'ناسمه مالوماتي بڼه',
	'antispoof-blacklisted' => 'د تور لړليک توري لري',
	'antispoof-noletters' => 'هېڅ کوم توری نه شته',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Helder.wiki
 * @author Heldergeovane
 */
$messages['pt'] = array(
	'antispoof-desc' => 'Impede a criação de contas com escrita mista, e nomes de utilizador confusos e semelhantes',
	'antispoof-conflict-top' => 'O nome "$1" é demasiado semelhante {{PLURAL:$2|ao da seguinte conta já existente|aos das seguintes $2 contas}}',
	'antispoof-conflict-bottom' => 'Por favor, escolha outro nome.',
	'antispoof-name-illegal' => 'O nome "$1" não é permitido para prevenir que seja confundido com outro (ou que seja feito algum trocadilho): já existe $2.
Por favor, escolha outro nome.',
	'antispoof-badtype' => 'Formato de dados incorreto',
	'antispoof-empty' => 'Linha vazia',
	'antispoof-blacklisted' => 'Contém caracteres proibidos',
	'antispoof-combining' => 'Inicia com um caractere de combinação',
	'antispoof-unassigned' => 'Contém caracteres não reconhecidos ou depreciados',
	'antispoof-noletters' => 'Não contém nenhuma letra',
	'antispoof-mixedscripts' => 'Contém scripts de escrita incompatíveis mesclados',
	'antispoof-tooshort' => 'Nome canônico curto demais',
	'antispoof-ignore' => 'Ignorar verificações de "spoofing"',
	'right-override-antispoof' => 'Sobrepor verificações de spoofing',
	'antispoof-conflict-item' => '$1',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'antispoof-desc' => "Chaqrusqa sananchayuq, pantachiq, musphachiq rakiquna suti kamariyta hark'an",
	'antispoof-conflict-top' => '"$1" nisqa sutiqa {{PLURAL:$2|kay kachkaqña rakiqunapman|kay $2 kachkaqña rakiqunakunapman}} nisyu kaqllam kachkan:',
	'antispoof-conflict-bottom' => 'Ama hina kaspa, huk hina sutita akllakuy.',
	'antispoof-name-illegal' => 'Nisqayki "$1" sutiqa manam saqillasqachu, suti pantachiyta hark\'anapaq: "$2". Ama hina kaspa, huk sutita akllay.',
	'antispoof-badtype' => 'Willa layaqa manam allinchu',
	'antispoof-empty' => "Ch'usaq qillqa",
	'antispoof-blacklisted' => 'Mana allin sutisuyupi sananchayuq',
	'antispoof-combining' => "T'inkinakuy sananchawanmi qallarin",
	'antispoof-unassigned' => 'Mana allin sananchayuq',
	'antispoof-noletters' => 'Manam ima sanampayuqchu',
	'antispoof-mixedscripts' => 'Mana allin chaqrusqa qillqayuq',
	'antispoof-tooshort' => 'Kanunikuchasqa sutiqa nisyu pisillam',
	'antispoof-ignore' => 'Kaqlla kay llanchiyta ama ruraychu',
	'right-override-antispoof' => 'Kaqlla kay llanchiyta ama atichiychu',
);

/** Romanian (Română)
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 * @author Stelistcristi
 * @author Strainu
 */
$messages['ro'] = array(
	'antispoof-desc' => 'Blochează crearea de conturi cu nume de utilizator cu LiTeRe AmEsTeCate, confuzante sau similare',
	'antispoof-conflict-top' => 'Numele „$1” este prea asemănător cu {{PLURAL:$2|următorul cont deja existent|următoarele $2 conturi}}:',
	'antispoof-conflict-bottom' => 'Vă rugăm să alegeți alt nume.',
	'antispoof-name-illegal' => 'Numele „$1” nu este permis pentru a preveni confuziile cu numele: $2. Vă rugăm să alegeți un alt nume de utilizator.',
	'antispoof-badtype' => 'Tip de date greșit',
	'antispoof-empty' => 'Șir gol',
	'antispoof-blacklisted' => 'Conține un caracter interzis',
	'antispoof-combining' => 'Începe cu marcajul de combinare',
	'antispoof-unassigned' => 'Conține un caracter neatribuit sau învechit',
	'antispoof-noletters' => 'Nu conține nici o literă',
	'antispoof-mixedscripts' => 'Conține mai multe scripturi incompatibile',
	'antispoof-tooshort' => 'Nume canonizat prea scurt',
	'antispoof-ignore' => 'Nu verifica existența unor nume de cont similare',
	'right-override-antispoof' => 'Asuprește verificările spoofing',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'antispoof-desc' => "Bluècche 'a ccrejazione de cunde utende cu script-misckate, confuse e cu nome de l'utinde ca s'assomigliane",
	'antispoof-conflict-top' => '\'U nome "$1" s\'assomigghie assaije a {{PLURAL:$2|\'u cunde esistende|le seguende $2 cunde}}:',
	'antispoof-conflict-bottom' => "Se preghe de scacchià n'otre nome.",
	'antispoof-name-illegal' => "'U nome \"\$1\" non g'è permesse pe prevenìe casine o 'mbruegghie de nome utinde: \$2.
Pe piacere scacchie 'n'otre nome.",
	'antispoof-badtype' => 'Tipe de date errate',
	'antispoof-empty' => 'stringa vacande',
	'antispoof-blacklisted' => "Condène carattere jndr'à liste gnure",
	'antispoof-combining' => "Accumenze cu 'nu marche combinate",
	'antispoof-unassigned' => 'Condène carattere non assignate o deprecate',
	'antispoof-noletters' => 'Non ge condène nisciune lettere',
	'antispoof-mixedscripts' => 'Condène script miste incompatibbele',
	'antispoof-tooshort' => 'Canonicizze nome assaje piccenne',
	'antispoof-ignore' => "Ignore verifeche sus a le 'mbruegghie",
	'right-override-antispoof' => "Sovrascrive le verifeche sus a le 'mbruegghie",
);

/** Russian (Русский)
 * @author Kaganer
 * @author Van de Bugger
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'antispoof-desc' => 'Запрещает создание учётных записей с именами, содержащими символы из разных алфавитов, вводящих в заблуждение и похожих на имена других участников.',
	'antispoof-conflict-top' => 'Имя «$1» слишком похоже на {{PLURAL:$2|уже существующее|уже существующие|уже существующие}}:',
	'antispoof-conflict-bottom' => 'Пожалуйста, выберите другое имя.',
	'antispoof-name-illegal' => 'Использование имени «$1» запрещено, так как оно $2. Пожалуйста, выберите другое имя.',
	'antispoof-badtype' => 'Неправильный тип данных',
	'antispoof-empty' => 'не содержит ни одного символа',
	'antispoof-blacklisted' => 'содержит символы из запрещённого списка',
	'antispoof-combining' => 'начинается с модифицирующего символа Юникода',
	'antispoof-unassigned' => 'содержит запрещённый или устаревший символ',
	'antispoof-noletters' => 'не содержит ни одной буквы',
	'antispoof-mixedscripts' => 'использует символы из разных алфавитов',
	'antispoof-tooshort' => 'слишком короткое',
	'antispoof-ignore' => 'Игнорировать проверки на схожие имена',
	'right-override-antispoof' => 'игнорирование проверок на схожие имена',
	'antispoof-conflict-item' => '$1',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'antispoof-desc' => 'Заборонює створіня контї котрых мена суть подобны іншым хоснователям, што комбінують різны тіпы писма, або што нароком хотять ошалїти.',
	'antispoof-conflict-top' => 'Мено „$1“ є дуже подобне {{PLURAL:$2|наступному уже єствуючому хосновательскому мену|наступным уже єствуючім хосновательскым менам}}:',
	'antispoof-conflict-bottom' => 'Просиме, звольте собі інше мено.',
	'antispoof-name-illegal' => 'Мено „$1“ не є поволено створити, жебы ся не плело або ся не ужывало про наподобнёваня чуджіх хосновательскых мен: $2.
Просиме, звольте собі інше мено.',
	'antispoof-badtype' => 'Планый датовый тіп',
	'antispoof-empty' => 'Порожнїй рядок',
	'antispoof-blacklisted' => 'Обсягує недоволеный сімбол',
	'antispoof-combining' => 'Зачінать комбінуючім діакрітічным сімболом',
	'antispoof-unassigned' => 'Обсягує невызначеный або непідпорованый знак',
	'antispoof-noletters' => 'Не обсягує жадну літеру',
	'antispoof-mixedscripts' => 'Обсягує недоволену комбінацію тіпів писма',
	'antispoof-tooshort' => 'Мено є по нормалізації дуже курте',
	'antispoof-ignore' => 'Іґноровати перевіркы на ошалюючі імена',
	'right-override-antispoof' => 'Іґнорованя перевірок на подобны імена',
);

/** Sanskrit (संस्कृतम्)
 * @author Shreekant Hegde
 * @author Vibhijain
 */
$messages['sa'] = array(
	'antispoof-name-illegal' => 'अवैध नाम',
	'antispoof-badtype' => 'स्वस्थाननिर्माणे विपन्नतायाः कारणम् ।',
	'antispoof-empty' => 'स्वस्थाननिर्माणे विपन्नतायाः कारणम् ।',
	'antispoof-blacklisted' => 'स्वस्थाननिर्माणे विपन्नतायाः हेतुः ।',
);

/** Sakha (Саха тыла)
 * @author Bert Jickty
 * @author HalanTul
 */
$messages['sah'] = array(
	'antispoof-desc' => 'Атын дьону булкуйар уонна атын дьон ааттарыгар майгынныыр хас да омук суругун-бичигин туһанан ааттанары бобор.',
	'antispoof-conflict-top' => '"$1" диэн аат урут бэлиэтэммит {{PLURAL:$2|аакка|$2 аакка}} наһаа майгынныыр:',
	'antispoof-conflict-bottom' => 'Бука диэн, атын ааты тал эрэ.',
	'antispoof-name-illegal' => '"$1" диэн аат $2 диэн ааттары кытта буккулубаттарын туһугар бобуллар. Онон атын ааты толкуйдаа.',
	'antispoof-badtype' => 'Сыыһа тииптээх дааннайдар',
	'antispoof-empty' => 'Кураанах устуруока',
	'antispoof-blacklisted' => 'Бобуллубут бэлиэлэр бааллар',
	'antispoof-combining' => 'Уларытар бэлиэттэн саҕаланар',
	'antispoof-unassigned' => 'Биллибэт эбэтэр өйөммөт бэлиэлэр бааллар',
	'antispoof-noletters' => 'Биир даҕаны буукуба суох',
	'antispoof-mixedscripts' => 'Сөп түбэһиспэт атын-атын суруктарынан суруллубут',
	'antispoof-tooshort' => 'Каноннаммыт тыл наһаа кылгас',
	'antispoof-ignore' => 'Майгынныыр ааттары бэрэбиэркэлээһини оҥорума',
	'right-override-antispoof' => 'Майгынныыр ааттары тэҥнээмэ',
);

/** Sicilian (Sicilianu)
 * @author Santu
 * @author Tonyfroio
 */
$messages['scn'] = array(
	'antispoof-desc' => "Blocca la criazzioni di account cu carattirìstichi ammiscati, noma utenti ca fannu cunfusioni troppu simigghiati ntra d'iddi",
	'antispoof-conflict-top' => 'Lu nomu "$1" è troppu simigghianti {{PLURAL:$2|a l\'account ca c\'è già|a li account $2 ca si sunnu già}}:',
	'antispoof-conflict-bottom' => "Circari n'àutru nomu.",
	'antispoof-name-illegal' => 'Lu nomu utenti "$1" nun è pirmessu, pi scanzari confusioni o utilizzi non lèciti: $2. Scègghiri n\'àutru nomu.',
	'antispoof-badtype' => 'Tipu di dati erratu',
	'antispoof-empty' => 'Stringa vacanti',
	'antispoof-blacklisted' => 'Usu di carattiri nun cunzintiti',
	'antispoof-combining' => 'Primu carattiri di cumminazzioni',
	'antispoof-unassigned' => 'Cunteni carattiri nun assignati o dipricati',
	'antispoof-noletters' => 'Nun cunteni nudda lìttira',
	'antispoof-mixedscripts' => 'Cumminazzioni di sistemi di scrittura nun cumpatibbili',
	'antispoof-tooshort' => "Nomu 'n forma canonica troppu curtu",
	'antispoof-ignore' => 'Trascura li cuntolli pi spoofing',
	'right-override-antispoof' => 'Trascura li cuntrolli spoofing',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'antispoof-desc' => 'Blokira pravljenje računa sa miješanim slovima, zbunjujućim i sličnim korisničkim imenima',
	'antispoof-conflict-top' => 'Ime "$1" je previše slično {{PLURAL:$2|slijedećem postojećem računu|sa slijedeća $2 postojeća  računa|sa slijedećih $2 postojećih računa}}:',
	'antispoof-conflict-bottom' => 'Molimo izaberite drugo ime.',
	'antispoof-name-illegal' => 'Ime "$1" nije dopušteno da bi se izbjegla zbunjujuća ili slična korisnička imena: $2.
Molimo Vas da odaberete drugo ime.',
	'antispoof-badtype' => 'Krivi tip podataka',
	'antispoof-empty' => 'Prazan unos',
	'antispoof-blacklisted' => 'Sadrži nedozvoljeno slovo (karakter)',
	'antispoof-combining' => 'Počinje sa znakom kombinacije',
	'antispoof-unassigned' => 'Sadrži nedodijeljen ili zastarjeli znak (karakter)',
	'antispoof-noletters' => 'Ne sadrži ni jedno slovo',
	'antispoof-mixedscripts' => 'Sadrži neusklađena miješana pisma.',
	'antispoof-tooshort' => 'Normalizirano ime je prekratko',
	'antispoof-ignore' => 'Ignoriraj provjeru nevaljanih imena (antispoof)',
	'right-override-antispoof' => 'Zaobilaženje provjera korisničkog imena',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 * @author Thameera123
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'antispoof-desc' => 'අකුරු වර්ග මිශ්‍ර, ව්‍යාකූල සහ සමාන ලෙස පෙනෙන පරිශීලක නම් වාරණය කරයි',
	'antispoof-conflict-top' => '"$1" යන නම {{PLURAL:$2|දැනට පවතින ගිණුමට|පහත ගිණුම් $2 ට}} බෙහෙවින් සමානය:',
	'antispoof-conflict-bottom' => 'කරුණාකර වෙනත් නමක් තෝරාගන්න',
	'antispoof-name-illegal' => 'ව්‍යාකූල පරිශීලක නම් වැළැක්වීම සඳහා "$1" යන නමට අවසර දිය නොහැකිය: $2.',
	'antispoof-badtype' => 'අවලංගු දත්ත වර්ගයකි',
	'antispoof-empty' => 'හිස් ස්ට්‍රිංඑකකි',
	'antispoof-blacklisted' => 'වලංගු නැති සංඛේතයක් අඩංගුවේ.',
	'antispoof-combining' => 'සම්බන්ධක ලකුණකින් ආරම්භවේ.',
	'antispoof-unassigned' => 'නොපවරන ලද හෝ විරුද්ධත්වය ප්‍රකාශ කරන ලද අක්ෂරයක් අඩංගු වේ',
	'antispoof-noletters' => 'අකුරු කිසිවක් අඩංගු නොවේ',
	'antispoof-mixedscripts' => 'නොගැළපෙන මිශ්‍ර විධානාවලි අඩංගු වේ',
	'antispoof-tooshort' => 'ප්‍රමතකරණය කරන ලද නම කෙටි වැඩිය',
	'antispoof-ignore' => 'අනවශ්‍ය පිරික්සුම් නොසළකා හරින්න',
	'right-override-antispoof' => 'අනවශ්‍ය පිරික්සුම් ප්‍රතික්ෂේප කරන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'antispoof-desc' => 'Blokuje tvorbu účtov so zmiešanými písmami, mätúce a podobné mená.',
	'antispoof-conflict-top' => 'Meno „$1” je príliš podobné {{PLURAL:$2|existujúcemu účtu|nasledovným $2 účtom}}:',
	'antispoof-conflict-bottom' => 'Prosím, vyberte si iné meno.',
	'antispoof-name-illegal' => 'Meno „$1“ nie je povolené, aby sa zabránilo náhodnému alebo zámernému pomýleniu mien používateľov: $2. Zvoľte si prosím iné meno.',
	'antispoof-badtype' => 'Nesprávny typ dát',
	'antispoof-empty' => 'Prázdny reťazec',
	'antispoof-blacklisted' => 'Obsahuje znak zo zoznamu zakázaných',
	'antispoof-combining' => 'Začína kombinačným znakom',
	'antispoof-unassigned' => 'Obsahuje nepriradený alebo zavrhovaný znak',
	'antispoof-noletters' => 'Neobsahuje žiadne písmená',
	'antispoof-mixedscripts' => 'Obsahuje nekompatibilné zmiešané písma',
	'antispoof-tooshort' => 'Meno prevedené do kanonického tvaru je príliš krátke',
	'antispoof-ignore' => 'Ignorovať kontroly klamania',
	'right-override-antispoof' => 'Prekonať kontroly klamania',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'antispoof-desc' => 'Prepreči ustvarjanje računov z mešanimi pisavami ter begajočimi in podobnimi uporabniškimi imeni',
	'antispoof-conflict-top' => 'Ime »$1« je preveč podobno {{PLURAL:$2|$2 obsoječemu računu|$2 obstoječima računoma|naslednjim $2 obstoječim računom}}:',
	'antispoof-conflict-bottom' => 'Prosimo, izberite drugačno ime.',
	'antispoof-name-illegal' => 'Ime »$1« ni dovoljeno, saj se lahko zamenja oz. norčuje iz »$2«.
Prosimo, izberite drugo ime.',
	'antispoof-badtype' => 'Napačen podatkovni tip',
	'antispoof-empty' => 'Prazen niz',
	'antispoof-blacklisted' => 'Vsebuje znak, ki je na črni listi',
	'antispoof-combining' => 'Začne se z združevalnim znakom',
	'antispoof-unassigned' => 'Vsebuje nepripisan ali nedovoljen znak',
	'antispoof-noletters' => 'Ne vsebuje nobenih črk',
	'antispoof-mixedscripts' => 'Vsebuje nezdružljive mešane skripte',
	'antispoof-tooshort' => 'Poenoteno ime je prekratko',
	'antispoof-ignore' => 'Prezri preverjanja prevare',
	'right-override-antispoof' => 'Preskoči preverjanja prevar',
);

/** Albanian (Shqip)
 * @author Olsi
 */
$messages['sq'] = array(
	'antispoof-desc' => 'Bllokon krijimin e llogarive me shkrime të përziera, duke çrregulluar edhe emrat e ngjashëm të përdorusve',
	'antispoof-conflict-top' => 'Emri "$1" është shumë i ngjashëm me {{PLURAL:$2||llogarinë ekzistuese|me $2 llogaritë e mëposhtme}}:',
	'antispoof-conflict-bottom' => 'Ju lutemi zgjidhni një emër tjetër.',
	'antispoof-name-illegal' => 'Emri "$1" nuk është i lejuar për të shmangur emrat e ngatërrueshëm apo të rremë: $2.',
	'antispoof-badtype' => 'Shtypje e keqe e të dhënave',
	'antispoof-empty' => 'Fushë boshe',
	'antispoof-blacklisted' => 'Përmban karaktere të palejuara',
	'antispoof-combining' => 'Fillon me shenjën e kombinuar',
	'antispoof-unassigned' => 'Përmban karakter të papërcaktuar ose të palejuar',
	'antispoof-noletters' => 'Nuk përmban asnjë shkronjë',
	'antispoof-mixedscripts' => 'Përmban shkrime të përziera të papajtueshme',
	'antispoof-tooshort' => 'Emri Canonicalized shumë i shkurtër',
	'antispoof-ignore' => 'Tejkaloni kontrollet për emra të rremë',
	'right-override-antispoof' => 'Refuzoni kontrollet për emra të rremë',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Јованвб
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'antispoof-desc' => 'Спречава отварање налога с мешаним писмима, збуњујућим и сличним корисничким именима',
	'antispoof-conflict-top' => 'Име „$1“ је превише слично с {{PLURAL:$2|именом постојећег налога|именима следећа $2 налога|именима следећих $2 налога}}:',
	'antispoof-conflict-bottom' => 'Изаберите друго име.',
	'antispoof-name-illegal' => 'Име „$1“ није дозвољено да би се избегла збуњујућа или лажирана корисничка имена: $2.
Изаберите друго име.',
	'antispoof-badtype' => 'Погрешна врста података',
	'antispoof-empty' => 'Празна ниска',
	'antispoof-blacklisted' => 'Садржи забрањени знак',
	'antispoof-combining' => 'Почиње са саставним знаком',
	'antispoof-unassigned' => 'Садржи недодељен или застарели знак',
	'antispoof-noletters' => 'Не садржи ниједно слово',
	'antispoof-mixedscripts' => 'Садржи несагласна мешана писма',
	'antispoof-tooshort' => 'Нормализовано име је прекратко',
	'antispoof-ignore' => 'Занемари међусобно слична имена',
	'right-override-antispoof' => 'заобилажење провера за међусобно слична имена',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'antispoof-desc' => 'Sprečava otvaranje naloga s mešanim pismima, zbunjujućim i sličnim korisničkim imenima',
	'antispoof-conflict-top' => 'Ime „$1“ je previše slično s {{PLURAL:$2|imenom postojećeg naloga|imenima sledeća $2 naloga|imenima sledećih $2 naloga}}:',
	'antispoof-conflict-bottom' => 'Izaberite drugo ime.',
	'antispoof-name-illegal' => 'Ime „$1“ nije dozvoljeno da bi se izbegla zbunjujuća ili lažirana korisnička imena: $2.
Izaberite drugo ime.',
	'antispoof-badtype' => 'Pogrešna vrsta podataka',
	'antispoof-empty' => 'Prazna niska',
	'antispoof-blacklisted' => 'Sadrži zabranjeni znak',
	'antispoof-combining' => 'Počinje sa sastavnim znakom',
	'antispoof-unassigned' => 'Sadrži nedodeljen ili zastareli znak',
	'antispoof-noletters' => 'Ne sadrži nijedno slovo',
	'antispoof-mixedscripts' => 'Sadrži nesaglasna mešana pisma',
	'antispoof-tooshort' => 'Normalizovano ime je prekratko',
	'antispoof-ignore' => 'Zanemari međusobno slična imena',
	'right-override-antispoof' => 'zaobilaženje provera za međusobno slična imena',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'antispoof-desc' => 'Ferhinnert dät Moakjen fon Benutserkonten mäd miskede Teekensatse, fertoogede un äänelke Benutsernoomen',
	'antispoof-conflict-top' => 'Die Noome „$1“ is {{PLURAL:$2|dät existierjende Benutserkonto|do foulgjende $2 Benutserkonten}} tou äänelk:',
	'antispoof-conflict-bottom' => 'Wääl n uur Noome.',
	'antispoof-name-illegal' => 'Die wonskede Benutsernoome „$1“ is nit ferlööwed. Gruund: $2<br />Wääl n uur Benutsernoome.',
	'antispoof-badtype' => 'Ungultigen Doatentyp',
	'antispoof-empty' => 'Loos Fäild',
	'antispoof-blacklisted' => 'Änthaalt nit tousteene Teekene.',
	'antispoof-combining' => 'Kombinationsteeken toun Ounfang.',
	'antispoof-unassigned' => 'Änthaalt nit tou-oardnede of nit wonskede Teekene.',
	'antispoof-noletters' => 'Änthaalt neen Bouksteeuwe.',
	'antispoof-mixedscripts' => 'Änthaalt Teekene fon uunglieke Skriftsysteme.',
	'antispoof-tooshort' => 'Die kanonisierde Noome is tou kuut.',
	'antispoof-ignore' => 'Ignorierje Äänelkhaidswröich',
	'right-override-antispoof' => 'Buute Kraft sätten fon ju Benutsernoome-Äänelkhaidswröige',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'antispoof-desc' => 'Peungpeuk dijieunna rekening nu landihanana skrip campuran, ngaco, atawa sarupa',
	'antispoof-conflict-top' => 'Ngaran "$1" mirip teuing jeung {{PLURAL:$2|rekening nu geus aya|$2 rekening ieu}}:',
	'antispoof-conflict-bottom' => 'Mangga pilih ngaran séjén.',
	'antispoof-name-illegal' => 'Landihan "$1" teu diwenangkeun ngarah teu pahili jeung landihan: $2. Mangga pilih landihan séjén.',
	'antispoof-badtype' => 'Tipeu datana awon',
	'antispoof-empty' => 'String kosong',
	'antispoof-blacklisted' => 'Ngandung karakter nu dicaram',
	'antispoof-combining' => 'Dimimitian ku tanda gabungan',
	'antispoof-unassigned' => 'Ngandung karakter nu teu dipaké ayawa teu didaptar',
	'antispoof-noletters' => 'Kosong',
	'antispoof-mixedscripts' => 'Ngandung tulisan campuran nu teu kompatibel',
	'antispoof-tooshort' => 'Landihan kanonikna pondok teuing',
	'right-override-antispoof' => 'Abeykeun pangecekan panipuan ngaran pamaké',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'antispoof-desc' => 'Förhindrar att konton med olika typer av förvirrande namn registreras',
	'antispoof-conflict-top' => 'Namnet "$1" är för likt {{PLURAL:$2|kontot|följande $2 konton}}:',
	'antispoof-conflict-bottom' => 'Välj ett annat namn.',
	'antispoof-name-illegal' => 'För att förhindra förvirrande eller felaktiga användarnamn, så är namnet "$1" inte tillåtet. Anledning: $2. Välj ett annat namn istället.',
	'antispoof-badtype' => 'Felaktig datatyp',
	'antispoof-empty' => 'Tom sträng',
	'antispoof-blacklisted' => 'Innehåller otillåtna tecken',
	'antispoof-combining' => 'Börjar med ett kombinationstecken',
	'antispoof-unassigned' => 'Innehåller obsoleta eller icke-tilldelade tecken',
	'antispoof-noletters' => 'Innehåller inga bokstäver',
	'antispoof-mixedscripts' => 'Innehåller tecken från flera inkompatibla skriftsystem',
	'antispoof-tooshort' => 'Det kanoniserade namnet är för kort',
	'antispoof-ignore' => 'Ignorera missbrukskontroll',
	'right-override-antispoof' => 'Slipper kontroller mot förvirrande användarnamn',
);

/** Silesian (Ślůnski)
 * @author Przemub
 */
$messages['szl'] = array(
	'antispoof-badtype' => 'Felerny typ danych',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 * @author Shanmugamp7
 * @author TRYPPN
 */
$messages['ta'] = array(
	'antispoof-desc' => 'கலப்பு படிவம், குழப்பமான மற்றும் ஒரேமாதிரியான பயனர்பெயர்களை கொண்ட கணக்குகளை உருவாக்குவதை தடுக்கும்.',
	'antispoof-conflict-top' => 'இந்த பெயர்  "$1" ஆனது இது மாதிரியாக உள்ளது {{PLURAL:$2|ஏற்கனவே உள்ள கணக்கு|கீழ்காணும்  $2 கணக்குகள்}}:',
	'antispoof-conflict-bottom' => 'தயவு செய்து மற்றொரு பெயரைத் தேர்ந்தெடுக்கவும்.',
	'antispoof-name-illegal' => "இந்த பெயர் ''$1'' அனுமதிக்கப்படவில்லை ஏனெனில் குழப்பமான அல்லது போலியான பயனர்பெயர்களை தடுப்பதற்காக:$2
தயவுகூர்ந்து வேறு பெயரை தேர்ந்தெடு.",
	'antispoof-badtype' => 'மோசமான தரவு வகை',
	'antispoof-empty' => 'வெற்றுச் சொற்றொடர்',
	'antispoof-blacklisted' => 'தடுக்கப்பட்ட எழுத்து உள்ளது',
	'antispoof-combining' => 'ஒருங்கிணைக்கும் குறியுடன் ஆரம்பிக்கும்.',
	'antispoof-unassigned' => 'வகுத்தமைக்கப்படாத அல்லது நீக்கப்பட்ட எழுத்தை கொண்டுள்ளது',
	'antispoof-noletters' => 'எந்த எழுத்தையும் கொண்டிருக்கவில்லை',
	'antispoof-mixedscripts' => 'பொருந்தாத கலந்த உரையை (scripts) கொண்டுள்ளது',
	'antispoof-tooshort' => 'Canonicalized பெயர் மிக குறுகியதாக உள்ளது.',
	'antispoof-ignore' => 'ஏமாற்றுதல் சரிபார்த்தலை புறக்கணி.',
	'right-override-antispoof' => 'ஏமாற்றுதல் சரிபார்த்தலை ரத்துசெய்',
);

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'antispoof-desc' => 'మిశ్రమ లిపులతో, అయోమయపు మరియు సామీప్యపు పేర్లతో ఖాతాలను సృష్టించడాన్ని నిరోధిస్తుంది',
	'antispoof-conflict-top' => '"$1" అన్న పేరు {{PLURAL:$2|ఈ ప్రస్తుత ఖాతాకి|ఈ $2 ఖాతాలకు}} చాలా దగ్గరగా ఉంది:',
	'antispoof-conflict-bottom' => 'దయచేసి మరో పేరుని ఎంచుకోండి.',
	'antispoof-name-illegal' => '"$1" అనే పేరును అనుమతించము; అయోమయాన్ని, ఎగతాళి చేయడాన్ని నివారించేందుకు: $2. దయచేసి మరో పేరును ఎంచుకోండి.',
	'antispoof-badtype' => 'తప్పుడు డాటా రకం',
	'antispoof-empty' => 'ఖాళీ వాక్యం',
	'antispoof-blacklisted' => 'అనుమానాస్పద అక్షరాన్ని కలిగివుంది',
	'antispoof-combining' => 'సంయుత గుర్తుతో మొదలయ్యింది',
	'antispoof-unassigned' => 'ఇంతవరకూ ఆపాదించబడని లేదా ఉపయోగంలోంచి తీసేయాలనుకుంటున్న అక్షరం కలిగి ఉంది',
	'antispoof-noletters' => 'ఎటువంటి అక్షరాలూ లేవు',
	'antispoof-mixedscripts' => 'అసంగత మిశ్రమ లిపులు ఉన్నాయి',
	'antispoof-tooshort' => 'విహితమైన పేరు మరీ చిన్నగా ఉంది',
	'right-override-antispoof' => 'స్పూఫింగ్ తనిఖీలను అధిక్రమించు',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'antispoof-desc' => 'Аз эҷоди ҳисобҳои корбарӣ бо ҳуруфҳои гиҷкунанда ё мушобеҳ бо дигар ҳисобҳои корбарӣ ҷилавгирӣ мекунад.',
	'antispoof-name-illegal' => 'Номи "$1" ба далели ҷилавгирӣ аз номҳои корбарии сардардкунанда ё масхара миҷоз нест: $2. Лутфан номи дигареро интихоб кунед.',
	'antispoof-badtype' => 'Навъи додаи номуносиб',
	'antispoof-empty' => 'Риштаи холӣ',
	'antispoof-blacklisted' => 'Аломатҳои дар феҳристи сиёҳ қарордоштаро дар бар мегирад',
	'antispoof-combining' => 'Бо аломати ҷамъ шурӯъ мешавад.',
	'antispoof-unassigned' => 'Аломати таъйиннашуда ё номуносиб аст',
	'antispoof-noletters' => 'Ягон ҳарфҳо надорад',
	'antispoof-mixedscripts' => 'Скриптҳои омехтаи носозгарро дар бар мегирад',
	'antispoof-tooshort' => 'Номи мӯътариф хеле кӯтоҳ аст',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'antispoof-desc' => 'Az eçodi hisobhoi korbarī bo hurufhoi giçkunanda jo muşobeh bo digar hisobhoi korbarī çilavgirī mekunad.',
	'antispoof-name-illegal' => 'Nomi "$1" ba daleli çilavgirī az nomhoi korbariji sardardkunanda jo masxara miçoz nest: $2. Lutfan nomi digarero intixob kuned.',
	'antispoof-badtype' => "Nav'i dodai nomunosib",
	'antispoof-empty' => 'Riştai xolī',
	'antispoof-blacklisted' => 'Alomathoi dar fehristi sijoh qarordoştaro dar bar megirad',
	'antispoof-combining' => "Bo alomati çam' şurū' meşavad.",
	'antispoof-unassigned' => "Alomati ta'jinnaşuda jo nomunosib ast",
	'antispoof-noletters' => 'Jagon harfho nadorad',
	'antispoof-mixedscripts' => 'Skripthoi omextai nosozgarro dar bar megirad',
	'antispoof-tooshort' => "Nomi mū'tarif xele kūtoh ast",
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'antispoof-desc' => 'Garyşyk şriftli, bulaşyklyk dörediji we çalymdaş ulanyjy atlarynyň döredilmegini blokirleýär.',
	'antispoof-conflict-top' => '"$1" diýen at {{PLURAL:$2|bar bolan şu hasaba|aşakdaky $2 hasaba}} örän çalymdaş:',
	'antispoof-conflict-bottom' => 'Başga bir at saýlaň.',
	'antispoof-name-illegal' => 'Ulanyjy atlarynyň  garjaşmagynyň ýa-da bulaşdyrylmagynyň öňüni almak "$1" adyna rugsat berilmeýär: $2. Başga bir ulanyjy adyny saýlaň.',
	'antispoof-badtype' => 'Näsaz maglumat tipi',
	'antispoof-empty' => 'Boş setir',
	'antispoof-blacklisted' => 'Gara sanawa goşulan simwoly öz içine alýar',
	'antispoof-combining' => 'Birleşdiriş belligi bilen başlaýar',
	'antispoof-unassigned' => 'Bellenilmedik ýa-da tassyklanmadyk simwoly öz içine alýar',
	'antispoof-noletters' => 'Hiç hili harpy ýok',
	'antispoof-mixedscripts' => 'Laýyk däl garjaşyk şriftleri öz içine alýar',
	'antispoof-tooshort' => 'Kadalaşdyrylan at örän gysga',
	'antispoof-ignore' => 'Bulaşyklyk barlaglaryna üns berme',
	'right-override-antispoof' => 'Bulaşyklyk barlagyny pisint etme',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'antispoof-desc' => 'Humahadlang sa paglikha ng mga akawnt/kuwentang may pinaghalong panitik, nakakalito at magkakatulad na mga pangalan ng tagagamit',
	'antispoof-conflict-top' => 'Ang pangalang "$1" ay may labis na pagkakatulad sa {{PLURAL:$2|umiiral na kuwenta/akawnt| sumusunod na $2 mga kuwenta/akawnt}}:',
	'antispoof-conflict-bottom' => 'Mangyaring pumili lamang ng iba pang pangalan.',
	'antispoof-name-illegal' => 'Hindi pinapayagan ang pangalang "$1" upang maiwasan ang nakalilito o mapanlilang na mga pangalan ng tagagamit: $2.
Mangyaring pumili ng iba pang pangalan.',
	'antispoof-badtype' => 'Masamang uri ng dato',
	'antispoof-empty' => "Bagting (''string'') na walang laman",
	'antispoof-blacklisted' => 'Naglalaman ng pinagbabawal na panitik (karakter)',
	'antispoof-combining' => 'Nagsisimula sa panandang pambuklod',
	'antispoof-unassigned' => 'Naglalaman ng walang katakdaan o tinututulang panitik (karakter)',
	'antispoof-noletters' => 'Hindi naglalaman ng anumang mga titik',
	'antispoof-mixedscripts' => 'Naglalaman ng hindi magkakatugmang pinaghalong mga panitik',
	'antispoof-tooshort' => 'Napakamaikli ng naging panuntunang pangalan',
	'antispoof-ignore' => "Balewalain ang mga pagsusuring pangpanlilinlang (''spoof'')",
	'right-override-antispoof' => "Daigin ang mga pagsusuring pangpanlilinlang (''spoof'')",
);

/** Tongan (lea faka-Tonga)
 * @author Tauʻolunga
 */
$messages['to'] = array(
	'antispoof-name-illegal' => 'Ko e hingoa "$1" ʻoku ʻikai ngofua ia koeʻuhi ko e "$2" ʻoku loi. Fakamolemole fili ha hingoa kehe.',
	'antispoof-empty' => 'ʻOtutohi maha',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Srhat
 */
$messages['tr'] = array(
	'antispoof-desc' => 'Karışık-betikli, kafa karıştırıcı ve benzer kullanıcı adlarıyla hesap oluşturulmasını engeller',
	'antispoof-conflict-top' => '"$1" adı, şu {{PLURAL:$2|mevcut hesaba|$2 hesaba}} çok benziyor:',
	'antispoof-conflict-bottom' => 'Lütfen başka bir isim seçin.',
	'antispoof-name-illegal' => '$2 hesabıyla karışmaması için "$1" ismine izin verilmemektedir. Lütfen başka bir kullanıcı adı seçiniz.',
	'antispoof-badtype' => 'Bozuk veri tipi',
	'antispoof-empty' => 'Boş dizi',
	'antispoof-blacklisted' => 'Karalisteye alınmış karakter içerir.',
	'antispoof-combining' => 'Kaynaştırma işaretiyle başlıyor',
	'antispoof-unassigned' => 'Atanmamış ya da onaylanmamış karakter içeriyor',
	'antispoof-noletters' => 'Hiç harf içermez',
	'antispoof-mixedscripts' => 'Uyumsuz karışık betikler içeriyor',
	'antispoof-tooshort' => 'Standartlaştırılmış isim çok kısa',
	'antispoof-ignore' => 'Aldatıcı kontrolleri ihmal et',
	'right-override-antispoof' => 'Aldatıcı kontrolleri gerçersiz kıl',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'antispoof-desc' => 'Забороняє створення облікових записів з іменами, подібними або схожими на імена інших облікових записів, та іменами, що містять символи з різних систем письма.',
	'antispoof-conflict-top' => "Ім'я «$1» дуже схоже на {{PLURAL:$2|існуюче ім'я|такі існуючі імена}}:",
	'antispoof-conflict-bottom' => "Будь ласка, оберіть інше ім'я.",
	'antispoof-name-illegal' => "Не дозволене використання імені «$1» з метою запобігання плутанню з занадто схожими на нього іменами: $2. Будь ласка, виберіть інше ім'я.",
	'antispoof-badtype' => 'Невірний тип даних',
	'antispoof-empty' => 'Порожній рядок',
	'antispoof-blacklisted' => 'Містить заборонені символи',
	'antispoof-combining' => "Починається з об'єднувальної мітки",
	'antispoof-unassigned' => 'Містить невизначений або непідтримуваний символ',
	'antispoof-noletters' => 'Не містить жодної літери',
	'antispoof-mixedscripts' => 'Використовуються несумісні системи письма',
	'antispoof-tooshort' => "Канонічне ім'я надто коротке",
	'antispoof-ignore' => 'Ігнорувати перевірки на схожі імена',
	'right-override-antispoof' => 'Ігнорування перевірок на схожі імена',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'antispoof-desc' => 'Inpedisse la creazion de account con carateri missià, nomi utente che genera confusion o che se someja massa tra de lori.',
	'antispoof-conflict-top' => 'El nome "$1" el xe someja massa {{PLURAL:$2|a l\'utensa esistente|a le seguenti $2 utense}}:',
	'antispoof-conflict-bottom' => "Sièglite n'antro nome.",
	'antispoof-name-illegal' => 'El nome "$1" no\'l xe mìa permesso, par evitar confusion o utilizi fraudolenti: $2.
Siegli n\'altro nome, par piaser.',
	'antispoof-badtype' => 'Tipo de dati mìa giusto.',
	'antispoof-empty' => 'Stringa voda',
	'antispoof-blacklisted' => 'Contien carateri mìa consentìi',
	'antispoof-combining' => 'Scuminsia con un caratere de conbinazion',
	'antispoof-unassigned' => 'Contien carateri non assegnà o deprecà',
	'antispoof-noletters' => 'No ghe xe letere',
	'antispoof-mixedscripts' => 'Conbinazion de sistemi de scritura mìa conpatibili',
	'antispoof-tooshort' => 'Nome in forma canonica massa curto',
	'antispoof-ignore' => 'Ignora i contròli del spoofing',
	'right-override-antispoof' => 'Ignora le verifiche de spoofing',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'antispoof-conflict-bottom' => 'Olgat hüväd, valikat toine nimi.',
	'antispoof-badtype' => 'Vär andmusidentip',
	'antispoof-empty' => "Pall'az rivi",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'antispoof-desc' => 'Cấm không được mở tài khoản dưới tên người dùng sử dụng hơn một hệ thống chữ viết, gây nhầm lẫn, và tương tự với tên người dùng khác',
	'antispoof-conflict-top' => 'Tên “$1” giống {{PLURAL:$2||$2}} tài khoản sau quá:',
	'antispoof-conflict-bottom' => 'Xin hãy chọn tên khác.',
	'antispoof-name-illegal' => 'Không được phép dùng tên “$1” để tránh tên người dùng $2 dễ gây lầm lẫn hoặc lừa gạt. Xin hãy chọn tên khác.',
	'antispoof-badtype' => 'Kiểu dữ liệu không hợp lệ',
	'antispoof-empty' => 'Chuỗi trống',
	'antispoof-blacklisted' => 'Có chứa các ký tự bị cấm',
	'antispoof-combining' => 'Bắt đầu bằng dấu kết hợp',
	'antispoof-unassigned' => 'Có chứa ký tự chưa gán hoặc không được phép',
	'antispoof-noletters' => 'Không có bất kỳ chữ nào',
	'antispoof-mixedscripts' => 'Có trộn lẫn script không tương thích',
	'antispoof-tooshort' => 'Tên chuẩn hóa quá ngắn',
	'antispoof-ignore' => 'Không kiểm tra tên có gây nhầm lẫn',
	'right-override-antispoof' => 'Bỏ qua kiểm tra tên',
	'antispoof-conflict-item' => '$1',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'antispoof-desc' => 'Blokön jafi kalas labü gebananems kofudik, tu sümiks u labü lafabs distik',
	'antispoof-conflict-top' => 'Nem: "$1" binon tu sümik äs {{PLURAL:$1|nem kala ya dabinöla|nems kalas ya dabinölas}}:',
	'antispoof-conflict-bottom' => 'Välolös nemi votik.',
	'antispoof-name-illegal' => 'Nem: „$1“ no padälon, ad vitön gebananemis kofudik u smilöfikis: $2. Välolös, begö! nemi votik.',
	'antispoof-badtype' => 'Nünasot badik',
	'antispoof-empty' => 'Vödem vagik',
	'antispoof-blacklisted' => 'Keninükon malatis no pedälölis.',
	'antispoof-combining' => 'Primon me malat kobüköl',
	'antispoof-unassigned' => 'Keninükon malatis no lonöfölis u vorädikis',
	'antispoof-noletters' => 'No ninädon tonatis alseimik',
	'antispoof-mixedscripts' => 'Keninükon migi penamasitas no balabikas',
	'antispoof-tooshort' => 'Nem valemik tu brefik',
	'antispoof-ignore' => 'Nedemön sümikontrolis',
	'right-override-antispoof' => 'Nefägükon sümikontrolis',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'antispoof-desc' => 'בלאקירט שאפֿן קאנטעס מיט געמישטע שריפֿטן, פֿארפלאנטערטע און ענלעכע באניצער נעמען',
	'antispoof-conflict-top' => 'דער נאָמען "$1" איז צו ענלעך צו {{PLURAL:$2|דער עקזיסטירנטער קאנטע|די פֿאלגנדע $2 קאנטעס}}:',
	'antispoof-conflict-bottom' => 'ביטע קלויבט אויס אן אנדער נאָמען.',
	'antispoof-badtype' => 'שלעכטער דאַטן טיפ',
	'antispoof-empty' => 'ליידיג שנירל',
	'antispoof-blacklisted' => "כולל א געאסר'טן צייכן",
	'antispoof-noletters' => 'אַנטהאַלט ניט קײַן בוכשטאַבן.',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'antispoof-conflict-top' => "Orúkọ ''$1'' jọ {{PLURAL:$2|àpamọ́ tó wà yìí|àwọn àpamọ́ $2 wọ̀nyí}} jù:",
	'antispoof-conflict-bottom' => 'Ẹ jọ̀wọ́ ẹ yan orúkọ míràn.',
	'antispoof-name-illegal' => "Orúkọ ''$1'' kò ṣe é gbà ní àyè láti dínà ìdojúrú tàbí ìtànjẹ orúkọ oníṣe: $2.
Ẹ jọ̀wọ́ ẹ yan orúkọ míràn.",
	'antispoof-badtype' => 'Irú dátà burúkú',
	'antispoof-noletters' => 'Kò ní lẹ́tà kankan nínú',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'antispoof-desc' => '封鎖一啲對於有混合程序、混淆同埋相似嘅用戶名嘅開戶口動作',
	'antispoof-name-illegal' => '呢個名"$1"唔畀用，以預防撈亂或者冒充："$2"。請揀過個名。',
	'antispoof-badtype' => '錯誤嘅資料類型',
	'antispoof-empty' => '空白字串',
	'antispoof-blacklisted' => '有列響黑名單度嘅字元',
	'antispoof-combining' => '以結合標記開始',
	'antispoof-unassigned' => '包含未指定或者唔再用嘅字元',
	'antispoof-noletters' => '唔包含任何字元',
	'antispoof-mixedscripts' => '包含唔相容嘅混合碼',
	'antispoof-tooshort' => '正規化嘅名太短',
	'antispoof-ignore' => '略過欺詐檢查',
	'right-override-antispoof' => '無視欺詐檢查',
);

/** Zeeuws (Zeêuws)
 * @author NJ
 * @author Ooswesthoesbes
 */
$messages['zea'] = array(
	'antispoof-desc' => "Blokkeer 't anmaeken van gebrukers mie meêdere schriffen, verwarr'nde en heliekende gebrukersnaemen",
	'antispoof-name-illegal' => 'De naem "$1" is nie toehestaen om verwarrieng of gefinheerde gebrukersnaemen te voorkomm\'n: $2. Kies asjeblieft een aore naem.',
	'antispoof-badtype' => 'Verkeêrd datatype',
	'antispoof-empty' => 'Lehe strieng',
	'antispoof-blacklisted' => "Bevat verbood'n karakter",
	'antispoof-combining' => 'Behun mie een hecombineerd merkteêken',
	'antispoof-unassigned' => 'Bevat nie toehewezen of verouwerd karakter',
	'antispoof-noletters' => 'Bevat hin letters',
	'antispoof-mixedscripts' => 'Bevat nie compatibele schriffen',
	'antispoof-tooshort' => 'Afekorte naem te kort',
	'antispoof-ignore' => 'Controle op geliekende gebrukersnaemen negeren',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hzy980512
 * @author Jimmy xu wrk
 * @author Liangent
 * @author PhiLiP
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'antispoof-desc' => '禁止创建用户名使用混合文字、容易混淆或与已存在用户名过于相似的帐户',
	'antispoof-conflict-top' => '用户名“$1”与{{PLURAL:$2|这个已存在的账户|下列$2个账户}}过于相似：',
	'antispoof-conflict-bottom' => '请选择其他名称。',
	'antispoof-name-illegal' => '为了防止混淆或欺诈性使用用户名“$2”，用户名“$1”已被禁止使用。请使用其他用户名。',
	'antispoof-badtype' => '错误的数据类型',
	'antispoof-empty' => '空白字串',
	'antispoof-blacklisted' => '包含黑名单上的字符',
	'antispoof-combining' => '以结合标记开始',
	'antispoof-unassigned' => '包含未指定或不再使用的字符',
	'antispoof-noletters' => '未包含任何字符',
	'antispoof-mixedscripts' => '包含不兼容的混合文字',
	'antispoof-tooshort' => '标准化后的用户名过短',
	'antispoof-ignore' => '忽略欺诈检查',
	'right-override-antispoof' => '无视欺诈检查',
	'antispoof-conflict-item' => '$1',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'antispoof-desc' => '封鎖以含有程式碼或是容易混淆、與已存在使用者相似的名稱建立使用者',
	'antispoof-conflict-top' => '名稱「$1」與{{PLURAL:$2|以下用戶|以下$2個用戶}}太相似：',
	'antispoof-conflict-bottom' => '請選擇其他名稱。',
	'antispoof-name-illegal' => '使用者名稱"$1"容易與"$2"混淆，已被禁止使用。請使用其他使用者名稱。',
	'antispoof-badtype' => '錯誤的數據類型',
	'antispoof-empty' => '空白字串',
	'antispoof-blacklisted' => '包含黑名單上的字符',
	'antispoof-combining' => '以結合標記開始',
	'antispoof-unassigned' => '包含未指定或不再使用的字元',
	'antispoof-noletters' => '不包含任何字元',
	'antispoof-mixedscripts' => '包含不相容混合的程式碼',
	'antispoof-tooshort' => '標準化後的用戶名過短',
	'antispoof-ignore' => '略過欺詐檢查',
	'right-override-antispoof' => '無視欺詐檢查',
	'antispoof-conflict-item' => '$1',
);

