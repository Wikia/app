<?php
/**
 * Internationalisation file for extension AntiSpoof.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'antispoof-desc'          => 'Blocks the creation of accounts with mixed-script, confusing and similar usernames',
	'antispoof-conflict-top'  => 'The name "$1" is too similar to {{PLURAL:$2|the existing account|the following $2 accounts}}:',
	'antispoof-conflict-item' => '$1', # do not translate or duplicate this message to other languages
	'antispoof-conflict-bottom' => 'Please choose another name.',
	'antispoof-name-illegal'  => 'The name "$1" is not allowed to prevent confusing or spoofed usernames: $2.
Please choose another name.',
	'antispoof-badtype'       => 'Bad data type',
	'antispoof-empty'         => 'Empty string',
	'antispoof-blacklisted'   => 'Contains blacklisted character',
	'antispoof-combining'     => 'Begins with combining mark',
	'antispoof-unassigned'    => 'Contains unassigned or deprecated character',
	'antispoof-noletters'     => 'Does not contain any letters',
	'antispoof-mixedscripts'  => 'Contains incompatible mixed scripts',
	'antispoof-tooshort'      => 'Canonicalized name too short',
	'antispoof-ignore'        => 'Ignore spoofing checks',

	'right-override-antispoof' => 'Override the spoofing checks',
);

/** Message documentation (Message documentation)
 * @author Beau
 * @author Titoxd
 */
$messages['qqq'] = array(
	'antispoof-desc' => 'Used in [[Special:Version]] as the description for [[mw:Extension:AntiSpoof|Extension:AntiSpoof]]',
	'antispoof-ignore' => 'This is a checkbox shown on [[Special:UserLogin|a signup page]] when a user with both [[MediaWiki:Right-createaccount/qqq|createaccount]] and [[MediaWiki:Right-override-antispoof/qqq|override-antispoof]] rights tries to register a new user account. It allows to register a username that would otherwise be blocked by the [[mw:Extension:AntiSpoof|AntiSpoof extension]].',
	'right-override-antispoof' => '{{doc-right}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'antispoof-badtype' => 'Verkeerde datatipe',
	'antispoof-empty' => 'Leë string',
	'antispoof-blacklisted' => 'Bevat verbode karakter',
	'antispoof-combining' => "Begin met 'n gekombineerde merker",
	'antispoof-unassigned' => 'Bevat nie toegekende of verouderde karakter',
	'antispoof-noletters' => 'Bevat geen letters nie',
	'antispoof-tooshort' => 'Afgekorte naam te kort',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'antispoof-desc' => "Bloqueya a creyazión de cuentas confusas, con tipografía mezclata y nombres d'usuario parellanos.",
	'antispoof-name-illegal' => 'No se premite rechistrar-se con o nombre "$1" ta pribar confusions y suplantazions con os nombres d\'usuario: $2. Por fabor, eslicha una atro nombre.',
	'antispoof-badtype' => 'Tipo de datos no conforme',
	'antispoof-empty' => 'Cadena bueda',
	'antispoof-blacklisted' => 'Contiene caráuters no premititos',
	'antispoof-combining' => 'Prenzipia con un siñal combinatorio',
	'antispoof-unassigned' => 'Contiene caráuters no conformes u obsoletos',
	'antispoof-noletters' => 'No contiene garra letra',
	'antispoof-mixedscripts' => 'Contiene un mezclallo incompatible de scripts',
	'antispoof-tooshort' => 'Nombre canonico masiau curto',
	'antispoof-ignore' => 'Innorar as comprebazions de spoofing',
	'right-override-antispoof' => "Inorar as prebas d'identidat",
);

/** Old English (Anglo-Saxon)
 * @author Wōdenhelm
 */
$messages['ang'] = array(
	'antispoof-noletters' => 'Ġehæfþ nān stafas',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mido
 * @author Mimouni
 */
$messages['ar'] = array(
	'antispoof-desc' => 'يمنع إنشاء الحسابات بسكريبت مختلط، أسماء مشابهة ومربكة',
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
	'antispoof-tooshort' => 'الاسم المستخدم قصير جدا',
	'antispoof-ignore' => 'تجاهل التحقق من التشابه',
	'right-override-antispoof' => 'تجاوز التحقق من سبوفينج',
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
	'antispoof-name-illegal' => 'الاسم "$1"  مش مسموح علشان نمنع اللخبطة أوانتحال أسماء اليوزرز: $2. لو سمحت تختار اسم تاني.',
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

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
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

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'antispoof-desc' => 'মিশ্র-লিপিতে লেখা, কিংবা অস্পষ্ট ও একই রকম ব্যবহারকারী নাম দিয়ে অ্যাকাউন্ট সৃষ্টিতে বাধা দেবে',
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
	'antispoof-name-illegal' => 'N\'eo ket aotreet ober gant an anv "$1" kuit da gemmeskañ gant un anv all pe da implijout an anv : $2. Grit gant un anv all mar plij.',
	'antispoof-badtype' => 'Seurt roadennoù fall',
	'antispoof-empty' => 'Neudennad goullo',
	'antispoof-blacklisted' => 'Arouezennoù berzet zo e-barzh',
	'antispoof-combining' => 'Kregiñ a ra gant ur merk kenaozet',
	'antispoof-unassigned' => 'Un arouezenn dispredet pe dispisaet zo e-barzh',
	'antispoof-noletters' => 'Lizherenn ebet e-barzh',
	'antispoof-mixedscripts' => 'Meur a skript digenglotus zo e-barzh',
	'antispoof-tooshort' => 'Anv kanonek re verr',
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
	'antispoof-empty' => 'Prazan string',
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
 * @author Jan Friberg
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'antispoof-desc' => 'Blokerer for oprettelse af konti med blandede tegnsæt, forvirrende eller lignende brugernavne',
	'antispoof-name-illegal' => 'Navnet "$1" er ikke tilladt for at forhindre forvirrende eller efterlignede brugernavne: $2. Vælg venligst et andet navn.',
	'antispoof-badtype' => 'Forkert datatype',
	'antispoof-empty' => 'Tom streng',
	'antispoof-blacklisted' => 'Indeholder sortlistet tegn',
	'antispoof-combining' => 'Begynder med et kombinationsbogstav',
	'antispoof-unassigned' => 'Indeholder ubrugte bogstaver',
	'antispoof-noletters' => 'Indeholder ikke bogstaver',
	'antispoof-mixedscripts' => 'Indeholder inkompatible, blandede tegnsæt',
	'antispoof-tooshort' => 'Navnet er for kort',
	'right-override-antispoof' => 'Omgå kontrollerne af brugernavne',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Raimond Spekking
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
	'antispoof-ignore' => 'Ignoriere Ähnlichkeitsprüfung',
	'right-override-antispoof' => 'Außer Kraft setzen der Benutzernamens-Ähnlichkeitsprüfung',
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

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Dead3y3
 * @author ZaDiak
 */
$messages['el'] = array(
	'antispoof-desc' => 'Μπλοκάρει τη δημιουργία λογαριασμών με χαρακτήρες μικτής γραφής, συγχεχυμένα και παρόμοια ονόματα χρηστών.',
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
	'antispoof-badtype' => 'Nevalida datumtipo',
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
 * @author Platonides
 * @author Remember the dot
 * @author Sanbec
 * @author Titoxd
 */
$messages['es'] = array(
	'antispoof-desc' => 'Previene la creación de cuentas de usuario nuevas que tengan nombres confusos, similares a nombres existentes, o con alfabetos mixtos.',
	'antispoof-conflict-top' => 'El nombre «$1» es muy similar al de {{PLURAL:$2|la siguiente cuenta|las siguientes $2 cuentas}}:',
	'antispoof-conflict-bottom' => 'Elije otro nombre, por favor.',
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
);

/** Basque (Euskara) */
$messages['eu'] = array(
	'antispoof-name-illegal' => '"$1" izena ez dago onartuta gaizkiulertuak saihesteko: $2. Beste izen bat hautatu mesedez.',
	'antispoof-badtype' => 'Datu mota ezegokia',
	'antispoof-empty' => 'Kate hutsa',
	'antispoof-noletters' => 'Ez dauka letrarik',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'antispoof-desc' => 'از ایجاد حساب‌های کاربری با حروف مختلط، گیج‌کننده یا مشابه با دیگر حساب‌های کاربری جلوگیری می‌کند',
	'antispoof-conflict-top' => 'نام «$1» خیلی به {{PLURAL:$2|این حساب کاربری|این $2 حساب کاربری}} شباهت دارد:',
	'antispoof-conflict-bottom' => 'لطفاً یک نام دیگر انتخاب کنید.',
	'antispoof-name-illegal' => 'نام «$1» به دلیل جلوگیری از نام‌های کاربری سردرگم‌کننده یا مسخره مجاز نیست: $2. لطفاً نام دیگری انتخاب کنید.',
	'antispoof-badtype' => 'نوع داده نامناسب',
	'antispoof-empty' => 'رشته خالی',
	'antispoof-blacklisted' => 'حاوی نویسه‌هایی است که در فهرست سیاه قرار دارند',
	'antispoof-combining' => 'با علامت جمع شروع می‌شود',
	'antispoof-unassigned' => 'حاوی نویسه‌های تعیین نشده یا نامناسب است',
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
);

/** French (Français)
 * @author Grondin
 * @author Louperivois
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'antispoof-desc' => "Bloque, avec un script mixte, la création des comptes par des noms d'utilisateur similaires ou pouvant prêter à confusion",
	'antispoof-conflict-top' => 'Le nom « $1 » est trop similaire {{PLURAL:$2|au compte existant|aux $2 comptes suivants}} :',
	'antispoof-conflict-bottom' => 'Veuillez choisir un autre nom.',
	'antispoof-name-illegal' => "Le nom d'utilisateur « $1 » n’est pas autorisé à cause de sa ressemblance avec « $2 ». Veuillez choisir un autre nom.",
	'antispoof-badtype' => 'Mauvais type de données',
	'antispoof-empty' => 'Chaîne vide',
	'antispoof-blacklisted' => 'Contient un caractère interdit',
	'antispoof-combining' => 'Commence avec une marque combinatoire',
	'antispoof-unassigned' => 'Contient un caractère non assigné ou désuet',
	'antispoof-noletters' => 'Ne contient aucune lettre',
	'antispoof-mixedscripts' => 'Contient plusieurs scripts incompatibles',
	'antispoof-tooshort' => 'Nom canonique trop court',
	'antispoof-ignore' => 'Ignorer les vérifications de tromperie',
	'right-override-antispoof' => "Court-circuiter les vérifications contre le ''spoofing''",
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
	'antispoof-desc' => 'Bloque, avouéc un script mècllo, la crèacion des comptos per des noms d’utilisator semblâblos ou povent prétar a confusion.',
	'antispoof-name-illegal' => 'Lo nom d’utilisator « $1 » est pas ôtorisâ por empachiér de confondre ou d’utilisar lo nom « $2 ». Volyéd chouèsir/cièrdre un ôtro nom.',
	'antispoof-badtype' => 'Môvés tipo de balyês',
	'antispoof-empty' => 'Chêna voueda',
	'antispoof-blacklisted' => 'Contint un caractèro dèfendu.',
	'antispoof-combining' => 'Comence avouéc una mârca combinâ.',
	'antispoof-unassigned' => 'Contint un caractèro pas assignê ou pas més utilisâ.',
	'antispoof-noletters' => 'Contint gins de lètra.',
	'antispoof-mixedscripts' => 'Contint plusiors scripts que vont pas avouéc.',
	'antispoof-tooshort' => 'Nom canonico trop côrt',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'antispoof-desc' => 'Bloquear a creación de contas con guións, confusas ou con nomes de usuarios similares.',
	'antispoof-conflict-top' => 'O nome "$1" é moi similar {{PLURAL:$2|á seguinte conta que xa existe|ás seguintes $2 contas}}:',
	'antispoof-conflict-bottom' => 'Por favor, escolla outro nome.',
	'antispoof-name-illegal' => 'O nome "$1" non está permitido para evitar confusións ou enganos cos seguintes nomes de usuario: $2. Por favor escolla outro nome.',
	'antispoof-badtype' => 'Tipo de datos incorrecto',
	'antispoof-empty' => 'Cadea baleira',
	'antispoof-blacklisted' => 'Inclúe un carácter prohibido',
	'antispoof-combining' => 'Principia cun carácter de combinación',
	'antispoof-unassigned' => 'Contén un carácter sen asignar ou desaconsellado',
	'antispoof-noletters' => 'Non contén ningunha letra',
	'antispoof-mixedscripts' => 'Contén guións mesturados incompatíbeis',
	'antispoof-tooshort' => 'Nome curto de máis',
	'antispoof-ignore' => 'Ignorar as comprobacións parodia (spoofing)',
	'right-override-antispoof' => 'Ignorar as comprobacións parodia (spoofing)',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'antispoof-badtype' => 'Κακὸς τύπος δεδομένων',
	'antispoof-empty' => 'Κενὴ συμβολοσειρά',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Hendergassler
 */
$messages['gsw'] = array(
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
);

/** Gujarati (ગુજરાતી) */
$messages['gu'] = array(
	'antispoof-noletters' => 'આમાં એકપણ અક્ષર નથી',
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
 * @author Kaustubh
 */
$messages['hi'] = array(
	'antispoof-desc' => 'मिश्र भाषा और संभ्रम पैदा करनेवाली तथा एकसरीके सदस्यनाम के इस्तेमाल पर रोक हैं।',
	'antispoof-name-illegal' => '"$1" यह नाम इस्तेमाल करने से रोका गया हैं क्योंकी यह अन्य नामोंसे मिलताजुलता हैं। कॄपया दूसरे नाम का प्रयोग करें।',
	'antispoof-badtype' => 'गलत डाटा प्रकार',
	'antispoof-empty' => 'खाली स्ट्रिंग',
	'antispoof-blacklisted' => 'इसमें ब्लैकलिस्टेड अक्षर हैं',
	'antispoof-combining' => 'एकत्रिकरण चिन्हसे शुरु होता हैं',
	'antispoof-unassigned' => 'इसमें गलत अक्षर हैं',
	'antispoof-noletters' => 'इसमें कोईभी अक्षर नहीं हैं',
	'antispoof-mixedscripts' => 'इसमें अन्य मिश्र लिपीयां हैं',
	'antispoof-tooshort' => 'अधिकारयुक्त नाम बहुत छोटा हैं',
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
 * @author Masterches
 */
$messages['ht'] = array(
	'antispoof-desc' => 'Bloke kreyasyon kont ki genyen Eskript ki mikse, ki ap mennen konfizyon oubyen ki genyen menm non',
	'antispoof-name-illegal' => 'non itilizatè "$1" pa otorize pou anpeche li konfonn aknon "$2" oubyen itilize li. Souple chwazi yon lòt non.',
	'antispoof-badtype' => 'Tip done sa yo move',
	'antispoof-empty' => 'Chèn vid',
	'antispoof-blacklisted' => 'Kontni yon karaktè ki pa otorize',
	'antispoof-combining' => 'Ap koumanse avèk yon mak konbine',
	'antispoof-unassigned' => 'Kontni yon karaktè ki pa asiyen oubyen ki pa itilize ankò',
	'antispoof-noletters' => 'Pa kontni pyès lèt',
	'antispoof-mixedscripts' => 'Kontni plizyè eskript ki pa konpatib',
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
	'antispoof-unassigned' => 'Contine un character non assignate o deprecate',
	'antispoof-noletters' => 'Non contine alcun litteras',
	'antispoof-mixedscripts' => 'Contine un mixtura incompatibile de alphabetos',
	'antispoof-tooshort' => 'Nomine canonic troppo curte',
	'antispoof-ignore' => 'Ignorar le verificationes contra falsification',
	'right-override-antispoof' => 'Ultrapassar le verificationes contra falsification',
);

/** Indonesian (Bahasa Indonesia)
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
	'antispoof-noletters' => 'Tidak mengandung huruf apapun',
	'antispoof-mixedscripts' => 'Mengandung huruf campuran yang tak kompatibel',
	'antispoof-tooshort' => 'Nama kanonikalisasi terlalu pendek',
	'antispoof-ignore' => 'Abaikan pemeriksaan penipuan akun',
	'right-override-antispoof' => 'Abaikan pengecekan penipuan nama pengguna',
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
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
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
	'antispoof-mixedscripts' => '互換性のない文字体系の混在があります',
	'antispoof-tooshort' => '正規化した名前が短すぎます',
	'antispoof-ignore' => 'なりすましチェックを無効にします。',
	'right-override-antispoof' => 'なりすましチェックを無視する',
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
 */
$messages['ka'] = array(
	'antispoof-badtype' => 'არასწორი მონაცემთა ტიპი',
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

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
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

/** Kazakh (Latin) (Қазақша (Latin)) */
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
	'antispoof-conflict-bottom' => 'សូមជ្រើសរើសឈ្មោះផ្សេងទៀត។',
	'antispoof-name-illegal' => 'ឈ្មោះ "$1" មិនត្រូវបានឱ្យបង្កើតទេ ដើម្បីកុំឱ្យច្រឡំជាមួយនឹងឈ្មោះអ្នកប្រើប្រាស់៖ $2។

សូមជ្រើសរើសឈ្មោះផ្សេងមួយទៀត។',
	'antispoof-badtype' => 'ប្រភេទទិន្នន័យអន់',
	'antispoof-empty' => 'ខ្សែអក្សរទទេ',
	'antispoof-blacklisted' => 'មាន​អក្សរ​ដែល​ត្រូវបាន​ចាត់ចូលទៅក្នុងបញ្ជីខ្មៅ',
	'antispoof-noletters' => 'គ្មានផ្ទុក​អក្សរណាមួយ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'antispoof-conflict-top' => '계정 이름 "$1"은 {{PLURAL:$2|다음 계정|다음 $2개의 계정}}과 너무 비슷합니다:',
	'antispoof-conflict-bottom' => '다른 이름을 선택해주세요.',
	'antispoof-name-illegal' => '‘$1’ 사용자 이름은 다음의 이유로 인해 가입이 금지되었습니다: $2. 다른 이름으로 가입해주세요.',
	'antispoof-badtype' => '잘못된 자료형',
	'antispoof-empty' => '빈 문자열',
	'antispoof-blacklisted' => '사용이 금지된 문자를 포함하고 있습니다.',
	'antispoof-ignore' => '안티스푸프 검사를 무시',
	'right-override-antispoof' => '혼란을 줄 수 있는 계정 이름 금지(안티스푸프)를 무시',
);

/** Ripoarisch (Ripoarisch)
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
 * @author Robby
 */
$messages['lb'] = array(
	'antispoof-desc' => "Verhënnert d'Opmaache vu Benotzerkonten matt gemeschten Zeechesätz, mat bizare Benotzernimm oder mat Benotzernimm déi zu Verwiesselunge féiere kéinten.",
	'antispoof-conflict-top' => 'Den Numm "$1" ass ze ähnlech mat {{PLURAL:$2|dem Benotzerkont|dëse(n) $2 Benotzerkonten}}:',
	'antispoof-conflict-bottom' => 'Wielt w.e.g. en anere Numm.',
	'antispoof-name-illegal' => 'De gewënschte Benotzernumm "$1" ass net erlaabt. Grond: $2<br />
Sicht iech w.e.g. een anere Benotzernumm.',
	'antispoof-badtype' => 'Ongültegt Fichiers-Format (bad data type)',
	'antispoof-empty' => 'Eidelt Feld',
	'antispoof-blacklisted' => 'Et si verbueden Zeechen (Caractèren) dran.',
	'antispoof-combining' => 'Fängt mat engem Kombinatiounszeechen un.',
	'antispoof-unassigned' => 'Et sinn nët zougeuerdent oder onerwéinschten Zeechen (Caractèren) dran.',
	'antispoof-noletters' => 'Et si keng Buschstawen dran.',
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

/** Lithuanian (Lietuvių) */
$messages['lt'] = array(
	'antispoof-name-illegal' => 'Vardas "$1" neleidžiamas, kad būtų apsisaugota nuo apgaulingų ar parodijuotų naudotojų vardų: $2. Prašome pasirinkti kitą vardą.',
	'antispoof-badtype' => 'Blogas duomenų tipas',
	'antispoof-empty' => 'Tuščias tekstas',
	'antispoof-blacklisted' => 'Turi uždraustų simbolių',
	'antispoof-combining' => 'Prasideda kombinavimo ženklu',
	'antispoof-unassigned' => 'Yra nepaskirtų arba nebenaudotinų simbolių',
	'antispoof-noletters' => 'Nėra nei vienos raidės',
	'antispoof-mixedscripts' => 'Turi nepalaikomų įvairių rašmenų',
	'antispoof-tooshort' => 'Kanonizuotas vardas per trumpas',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'antispoof-desc' => 'സങ്കര ലിപി, തെറ്റിദ്ധാരണ ഉളവാക്കുന്ന നാമം, ഒരേ തരത്തിലുള്ള ഉപയോക്തൃനാമം എന്നിവ ഉപയോഗിച്ചുള്ള അക്കൗണ്ട് സൃഷ്ടിക്കല്‍ തടയുന്നു',
	'antispoof-name-illegal' => 'ഉപയോക്തൃനാമത്തിലെ തെറ്റിദ്ധാരണയും സ്പൂഫിങ്ങും ഒഴിവാക്കാന്‍ "$1" എന്ന ഉപയോക്തൃനാമം അനുവദനീയമല്ല.
ദയവായി മറ്റൊരു നാമം തിരഞ്ഞെടുക്കുക.',
	'antispoof-empty' => 'ശൂന്യമായ സ്ട്രിംങ്ങ്',
	'antispoof-blacklisted' => 'കരിമ്പട്ടികയില്‍ പെട്ട അക്ഷരങ്ങളുണ്ട്',
	'antispoof-noletters' => 'അക്ഷരങ്ങള്‍ ഒന്നും തന്നെ ഇല്ല',
	'antispoof-mixedscripts' => 'പൊരുത്തക്കേടുള്ള സങ്കരലിപികള്‍ ഉള്‍പ്പെടുന്നു',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 * @author प्रणव कुलकर्णी
 */
$messages['mr'] = array(
	'antispoof-desc' => 'मिश्र भाषा तसेच संभ्रमित करणारी व सारखी असणारी सदस्य नामे वापरण्यास बंदी आहे.',
	'antispoof-name-illegal' => '"$1" हे नाव वापरण्यास बंदी आहे कारण हे नाव इतर नावांशी साम्य राखते: $2.
त्यामुळे कृपया वेगळे नाव वापरा.',
	'antispoof-badtype' => 'वाईट विदा प्रकार',
	'antispoof-empty' => 'रिकामा तंतु',
	'antispoof-blacklisted' => 'मान्यताप्राप्त यादीत नसलेले अक्षर',
	'antispoof-combining' => 'एकत्रीकरण चिन्हाने सुरुवात केलेली आहे.',
	'antispoof-unassigned' => 'यामध्ये चुकीची चिन्हे आहेत.',
	'antispoof-noletters' => 'कोणत्याही अक्षराचा समावेश नाही',
	'antispoof-mixedscripts' => 'यामध्ये इतर मिश्र लिपी आहेत.',
	'antispoof-tooshort' => 'अधिकारयुक्त नाव खूप छोटे आहे',
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

/** Dutch (Nederlands)
 * @author Erwin85
 * @author Siebrand
 */
$messages['nl'] = array(
	'antispoof-desc' => 'Blokkeert het aanmaken van gebruikers met meerdere schriften, verwarrende en gelijkende gebruikersnamen',
	'antispoof-conflict-top' => 'De naam "$1" lijkt te veel op de volgende bestaande {{PLURAL:$2|gebruiker|$2 gebruikers}}:',
	'antispoof-conflict-bottom' => 'Kies een andere naam.',
	'antispoof-name-illegal' => 'De naam "$1" is niet toegestaan om verwarring of gefingeerde gebruikersnamen te voorkomen: $2.
Kies een andere naam.',
	'antispoof-badtype' => 'Verkeerd datatype',
	'antispoof-empty' => 'Lege string',
	'antispoof-blacklisted' => 'Bevat verboden karakter',
	'antispoof-combining' => 'Begint met een gecombineerd merkteken',
	'antispoof-unassigned' => 'Bevat niet toegewezen of verouderd karakter',
	'antispoof-noletters' => 'Bevat geen letters',
	'antispoof-mixedscripts' => 'Bevat niet compatibele schriften',
	'antispoof-tooshort' => 'Afgekorte naam te kort',
	'antispoof-ignore' => 'Controle op gelijkende gebruikersnamen negeren',
	'right-override-antispoof' => 'Spoofcontroles negeren',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
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

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
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

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'antispoof-empty' => 'Афтид рæнхъ',
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
	'right-override-antispoof' => 'Wyłącza ograniczenia nakładane przez rozszerzenie AntiSpoof, które blokuje zakładanie kont o podobnych nazwach do już istniejących',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'antispoof-name-illegal' => 'Lë stranòm "$1" as peul nen dovresse për evité confusion e/ò che cheidun as fassa passé për: $2. Për piasì, ch\'as në sërna n\'àotr.',
	'antispoof-badtype' => 'Sòrt ëd dat nen bon-a',
	'antispoof-empty' => 'Espression veujda',
	'antispoof-blacklisted' => "A-i é ëd caràter ch'as peulo pa dovresse",
	'antispoof-combining' => 'As anandia con na combinassion',
	'antispoof-unassigned' => "A son dovrasse dij caràter nen assignà, ò pura ch'as dovrìo pì nen dovresse",
	'antispoof-noletters' => "A l'ha pa gnun caràter",
	'antispoof-mixedscripts' => "Combinassion ëd sistema dë scritura ch'as peulo pa butesse ansema",
	'antispoof-tooshort' => 'Butà an forma canònica lë stranòm a resta esagerà curt',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'antispoof-badtype' => 'ناسمه مالوماتي بڼه',
	'antispoof-noletters' => 'هېڅ کوم توری نه شته',
);

/** Portuguese (Português)
 * @author Brunoy Anastasiya Seryozhenko
 * @author Malafaya
 */
$messages['pt'] = array(
	'antispoof-desc' => 'Impede a criação de contas com escrita mista, e nomes de utilizador confusos e semelhantes',
	'antispoof-conflict-top' => 'O nome "$1" é demasiado semelhante {{PLURAL:$2|ao da seguinte conta já existente|aos das seguintes $2 contas}}:',
	'antispoof-conflict-bottom' => 'Por favor, escolha outro nome.',
	'antispoof-name-illegal' => 'O nome "$1" não é permitido para prevenir que seja confundido com outro (ou que seja feito algum trocadilho): já existe $2. Por favor, escolha outro nome.',
	'antispoof-badtype' => 'Formato de dados incorreto',
	'antispoof-empty' => 'Linha vazia',
	'antispoof-blacklisted' => 'Contém caracteres proibidos',
	'antispoof-combining' => 'Inicia com um caractere de combinação',
	'antispoof-unassigned' => 'Contém caracteres não reconhecidos ou depreciados',
	'antispoof-noletters' => 'Não inclui nenhuma letra',
	'antispoof-mixedscripts' => 'Contém scripts de escrita incompatíveis mesclados',
	'antispoof-tooshort' => 'Nome canónico demasiado curto',
	'antispoof-ignore' => 'Ignorar verificações de "spoofing"',
	'right-override-antispoof' => 'Sobrepor verificações de spoofing',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'antispoof-tooshort' => 'Nome canônico curto demais',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'antispoof-desc' => "Chaqrusqa sananchayuq, pantachiq, musphachiq rakiquna suti kamariyta hark'an",
	'antispoof-name-illegal' => 'Nisqayki "$1" sutiqa manam saqillasqachu, suti pantachiyta hark\'anapaq: "$2". Ama hina kaspa, huk sutita akllay.',
	'antispoof-badtype' => 'Willa layaqa manam allinchu',
	'antispoof-empty' => "Ch'usaq qillqa",
	'antispoof-blacklisted' => 'Mana allin sutisuyupi sananchayuq',
	'antispoof-combining' => "T'inkinakuy sananchawanmi qallarin",
	'antispoof-unassigned' => 'Mana allin sananchayuq',
	'antispoof-noletters' => 'Manam ima sanampayuqchu',
	'antispoof-mixedscripts' => 'Mana allin chaqrusqa qillqayuq',
	'antispoof-tooshort' => 'Kanunikuchasqa sutiqa nisyu pisillam',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'antispoof-conflict-bottom' => 'Vă rugăm să alegeţi alt nume.',
	'antispoof-name-illegal' => 'Numele "$1" nu este permis pentru a preveni confuziile cu numele: $2. Vă rugăm să alegeţi alt nume de utilizator.',
	'antispoof-badtype' => 'Tip de date greşit',
	'antispoof-empty' => 'Şir vid',
	'antispoof-noletters' => 'Nu conţine nici o literă',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'antispoof-empty' => 'stringa vacande',
);

/** Russian (Русский)
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'antispoof-desc' => 'Запрещает создание учётных записей с именами, содержащими символы из разных систем письма, вводящих в заблуждение и похожих на имена других учётных записей.',
	'antispoof-conflict-top' => 'Имя «$1» слишком похоже на {{PLURAL:$2|$2 уже существующую учётную запись|$2 уже существующие учётные записи|$2 уже существующих учётных записей}}:',
	'antispoof-conflict-bottom' => 'Пожалуйста, выберите другое имя.',
	'antispoof-name-illegal' => 'Не разрешено использование имени «$1» в целях предотвращения смешения со следующими похожими именами: $2. Пожалуйста, выберите другое имя.',
	'antispoof-badtype' => 'Неправильный тип данных',
	'antispoof-empty' => 'Пустая строка',
	'antispoof-blacklisted' => 'Содержит символы из запрещённого списка',
	'antispoof-combining' => 'Начинается с объединительной пометки',
	'antispoof-unassigned' => 'Содержит неопределённый или неподдерживаемый символ',
	'antispoof-noletters' => 'Не содержит ни одной буквы',
	'antispoof-mixedscripts' => 'Используются несовместимые системы письменности',
	'antispoof-tooshort' => 'Нормализованное имя слишком короткое',
	'antispoof-ignore' => 'Игнорировать проверки на схожие имена',
	'right-override-antispoof' => 'игнорирование проверок на схожие имена',
);

/** Yakut (Саха тыла)
 * @author Bert Jickty
 * @author HalanTul
 */
$messages['sah'] = array(
	'antispoof-desc' => 'Атын дьону булкуйар уонна атын дьон ааттарыгар майгынныыр хас да омук суругун-бичигин туһанан ааттанары бобор.',
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

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'antispoof-desc' => 'Blokuje tvorbu účtov s názvami obsahujúcimi viacero druhov písma, mätúcimi alebo podobnými existujúcim názvom',
	'antispoof-conflict-top' => 'Meno „$1” je príliš podobné {{PLURAL:$2|existujúcemu účtu|nasledovným $2 účtom}}:',
	'antispoof-conflict-bottom' => 'Prosím, vyberte si iné meno.',
	'antispoof-name-illegal' => 'Meno „$1“ nie je povolené, aby sa zabránilo náhodnému alebo zámernému pomýleniu mien používateľov: $2. Zvoľte si prosím iné meno.',
	'antispoof-badtype' => 'Nesprávny typ dát',
	'antispoof-empty' => 'Prázdny reťazec',
	'antispoof-blacklisted' => 'Obsahuje znak zo zoznamu zakázaných',
	'antispoof-combining' => 'Začína kombinačným znakom',
	'antispoof-unassigned' => 'Obsahuje nepriradený alebo zastaralý znak',
	'antispoof-noletters' => 'Neobsahuje žiadne písmená',
	'antispoof-mixedscripts' => 'Obsahuje nekompatibilné zmiešané písma',
	'antispoof-tooshort' => 'Meno prevedené do kanonického tvaru je príliš krátke',
	'antispoof-ignore' => 'Ignorovať kontroly klamania',
	'right-override-antispoof' => 'Prekonať kontroly klamania',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Sasa Stefanovic
 * @author Јованвб
 */
$messages['sr-ec'] = array(
	'antispoof-desc' => 'Онемогућава стварање налога с мешаним писмима, збуњујућим и сличним сарадничким именима.',
	'antispoof-conflict-top' => 'Име је превише слично са {{PLURAL:$2|постојећим налогом|постојећа $2 налога|постојеих $2 налога}}:',
	'antispoof-conflict-bottom' => 'Молимо изаберите друго име.',
	'antispoof-name-illegal' => 'Име "$1" није дозвољено како би се спречиле забуне или лажирања корисничких имена: $2. Молимо изаберите неко друго име.',
	'antispoof-badtype' => 'Лош тип податка.',
	'antispoof-empty' => 'Празан стринг.',
	'antispoof-blacklisted' => 'Садржи онемогућене карактере.',
	'antispoof-combining' => 'Почиње с комбинованом ознаком.',
	'antispoof-unassigned' => 'Садржи недодељене или потиснуте карактере.',
	'antispoof-noletters' => 'Не садржи ни једно слово',
	'antispoof-mixedscripts' => 'Садржи неусклађена мешана писма.',
	'antispoof-tooshort' => 'Каноничко име превише кратко.',
	'antispoof-ignore' => 'Занемари провере на бесмислице.',
	'right-override-antispoof' => 'Препиши провере на бесмислице.',
);

/** latinica (latinica) */
$messages['sr-el'] = array(
	'antispoof-name-illegal' => 'Ime "$1" nije dozvoljeno kako bi se sprečile zabune ili lažiranja korisničkih imena: $2. Molimo izaberite neko drugo ime.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'antispoof-desc' => 'Ferhinnert dät Moakjen fon Benutserkonten mäd miskede Teekensatse, fertoogede un äänelke Benutsernoomen',
	'antispoof-name-illegal' => 'Die wonskede Benutsernoome „$1“ is nit ferlööwed. Gruund: $2<br />Wääl n uur Benutsernoome.',
	'antispoof-badtype' => 'Ungultigen Doatentyp',
	'antispoof-empty' => 'Loos Fäild',
	'antispoof-blacklisted' => 'Änthaalt nit tousteene Teekene.',
	'antispoof-combining' => 'Kombinationsteeken toun Ounfang.',
	'antispoof-unassigned' => 'Änthaalt nit tou-oardnede of nit wonskede Teekene.',
	'antispoof-noletters' => 'Änthaalt neen Bouksteeuwe.',
	'antispoof-mixedscripts' => 'Änthaalt Teekene fon uunglieke Schriftsysteme.',
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

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'antispoof-desc' => 'మిశ్రమ లిపులతో, అయోమయపు మరియు సామీప్యపు పేర్లతో ఖాతాలను సృష్టించడాన్ని నిరోధిస్తుంది',
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

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
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

/** Tonga (faka-Tonga)
 * @author Tauʻolunga
 */
$messages['to'] = array(
	'antispoof-name-illegal' => 'Ko e hingoa "$1" ʻoku ʻikai ngofua ia koeʻuhi ko e "$2" ʻoku loi. Fakamolemole fili ha hingoa kehe.',
	'antispoof-empty' => 'ʻOtutohi maha',
);

/** Turkish (Türkçe)
 * @author Srhat
 */
$messages['tr'] = array(
	'antispoof-name-illegal' => '$2 hesabıyla karışmaması için "$1" ismine izin verilmemektedir. Lütfen başka bir kullanıcı adı seçiniz.',
	'antispoof-badtype' => 'Bozuk veri tipi',
	'antispoof-empty' => 'Boş dizi',
	'antispoof-blacklisted' => 'Karalisteye alınmış karakter içerir.',
	'antispoof-noletters' => 'Hiç harf içermez',
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

/** Yue (粵語) */
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
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'antispoof-desc' => '封锁以含有程式码或是容易混淆、与已存在用户相似的名称建立用户',
	'antispoof-conflict-top' => '名称“$1”与以下$2个账户太相似：',
	'antispoof-conflict-bottom' => '请选择其他名称。',
	'antispoof-name-illegal' => '用户名"$1"易与用户名"$2"混淆，已被禁止使用。请使用其他用户名。',
	'antispoof-badtype' => '错误的数据类型',
	'antispoof-empty' => '空白字串',
	'antispoof-blacklisted' => '包含在黑名单上的字元',
	'antispoof-combining' => '以结合标记开始',
	'antispoof-unassigned' => '包含未指定或不再使用的字元',
	'antispoof-noletters' => '不包含任何字元',
	'antispoof-mixedscripts' => '包含不相容混合的脚本',
	'antispoof-tooshort' => '合符标准的名称太短',
	'antispoof-ignore' => '略过欺诈检查',
	'right-override-antispoof' => '无视欺诈检查',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'antispoof-desc' => '封鎖以含有程式碼或是容易混淆、與已存在使用者相似的名稱建立使用者',
	'antispoof-conflict-top' => '名稱「$1」與{{PLURAL:$2|以下戶口|以下$2個戶口}}太相似：',
	'antispoof-conflict-bottom' => '請選擇其他名稱。',
	'antispoof-name-illegal' => '使用者名稱"$1"容易與"$2"混淆，已被禁止使用。請使用其他使用者名稱。',
	'antispoof-badtype' => '錯誤的資料類型',
	'antispoof-empty' => '空白字串',
	'antispoof-blacklisted' => '包含在黑名單上的字元',
	'antispoof-combining' => '以結合標記開始',
	'antispoof-unassigned' => '包含未指定或不再使用的字元',
	'antispoof-noletters' => '不包含任何字元',
	'antispoof-mixedscripts' => '包含不相容混合的程式碼',
	'antispoof-tooshort' => '合符標準的名稱太短',
	'antispoof-ignore' => '略過欺詐檢查',
	'right-override-antispoof' => '無視欺詐檢查',
);

