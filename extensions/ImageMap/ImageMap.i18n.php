<?php
/**
 * Internationalisation file for extension FindSpam.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Tim Starling
 */
$messages['en'] = array(
	'imagemap_desc'                 => 'Allows client-side clickable image maps using <code>&lt;imagemap&gt;</code> tag',
	'imagemap_no_image'             => 'Error: must specify an image in the first line',
	'imagemap_invalid_image'        => 'Error: image is invalid or non-existent',
	'imagemap_bad_image'            => 'Error: image is blacklisted on this page',
	'imagemap_no_link'              => 'Error: no valid link was found at the end of line $1',
	'imagemap_invalid_title'        => 'Error: invalid title in link at line $1',
	'imagemap_missing_coord'        => 'Error: not enough coordinates for shape at line $1',
	'imagemap_unrecognised_shape'   => 'Error: unrecognised shape at line $1, each line must start with one of: default, rect, circle or poly',
	'imagemap_invalid_coord'        => 'Error: invalid coordinate at line $1, must be a number',
	'imagemap_invalid_desc'         => 'Error: invalid desc specification, must be one of: <code>$1</code>',
	'imagemap_description'          => 'About this image',
	# Note to translators: keep the same order
	'imagemap_desc_types'           => 'top-right, bottom-right, bottom-left, top-left, none',
	'imagemap_poly_odd'             => 'Error: found poly with odd number of coordinates on line $1',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'imagemap_desc' => '{{desc}}',
	'imagemap_desc_types' => '{{optional}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'imagemap_no_image' => "Fout: moet 'n beeld op die eerste lyn spesifiseer",
	'imagemap_invalid_image' => 'Fout: beeld is ongeldig of bestaan nie',
	'imagemap_bad_image' => 'Fout: beeld is op die swartlys vir hierdie bladsy',
	'imagemap_no_link' => 'Fout: geen geldige skakel was aan die einde van lyn $1 gevind nie',
	'imagemap_invalid_title' => 'Fout: ongeldige titel in skakel op lyn $1',
	'imagemap_missing_coord' => 'Fout: nie genoeg koördinate vir vorm op lyn $1',
	'imagemap_description' => 'Beeldinligting',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'imagemap_desc' => "Premite mapas d'imachens punchables en o client fendo servir a etiqueta <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => "Error: ha d'endicar una imachen a primer ringlera",
	'imagemap_invalid_image' => 'Error: a imachen no ye conforme u no existe',
	'imagemap_bad_image' => 'Error: a imachen ye en a lista negra ta ista pachina',
	'imagemap_no_link' => "Error: no s'ha trobato garra vinclo conforme a la fin d'a ringlera $1",
	'imagemap_invalid_title' => "Error: títol no conforme en o vinclo d'a ringlera $1",
	'imagemap_missing_coord' => "Error: No bi'n ha prous de coordinadas ta definir a forma en a ringlera $1",
	'imagemap_unrecognised_shape' => "Error: no s'ha reconoixito a forma en a ringlera $1, cada linia ha de prencipiar con una d'as siguients espresions: default, rect, circle u poly",
	'imagemap_invalid_coord' => "Error: coordinada no conforme en a ringlera $1, ha d'estar un numero",
	'imagemap_invalid_desc' => "Error: A descripción (desc) especificata no ye conforme, ha d'estar una de: <code>$1</code>",
	'imagemap_description' => 'Información sobre ista imachen',
	'imagemap_poly_odd' => "Error: s'ha trobato un polinomio con un numero impar de coordinadas en a linia $1",
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'imagemap_desc' => 'يسمح بخرائط صور قابلة للضغط عليها من طرف العميل باستخدام وسم <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'خطأ: يجب تحديد صورة في السطر الأول',
	'imagemap_invalid_image' => 'خطأ: الصورة غير صحيحة أو غير موجودة',
	'imagemap_bad_image' => 'خطأ: الصورة في القائمة السوداء على هذه الصفحة',
	'imagemap_no_link' => 'خطأ: لم يتم العثور على وصلة صحيحة في نهاية السطر $1',
	'imagemap_invalid_title' => 'خطأ: عنوان غير صحيح في الوصلة عند السطر $1',
	'imagemap_missing_coord' => 'خطأ: إحداثيات غير كافية للشكل عند السطر $1',
	'imagemap_unrecognised_shape' => 'خطأ: شكل غير معروف عند السطر $1، كل سطر يجب أن يبدأ بواحد من: default، rect، circle أو poly',
	'imagemap_invalid_coord' => 'خطأ: إحداثي غير صحيح عند السطر $1، يجب أن يكون رقما',
	'imagemap_invalid_desc' => 'خطأ: محدد وصف غير صحيح، يجب أن يكون واحدا من: <code>$1</code>',
	'imagemap_description' => 'عن هذه الصورة',
	'imagemap_desc_types' => 'أعلى اليمين, أسفل اليمين, أسفل اليسار, أعلى اليسار, لا شيء',
	'imagemap_poly_odd' => 'خطأ: تم العثور على مضلع بعدد فردي من الأضلاع في السطر $1',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'imagemap_desc' => 'بيسمح بخرايط صور قابلة للضغط عليها من طرف العميل باستخدام تاج <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'غلط: لازم تحدد صورة فى السطر الاولانى.',
	'imagemap_invalid_image' => 'غلط:الصورة مش صحيحة او مش موجودة',
	'imagemap_bad_image' => 'غلط: الصورة فى البلاك ليست بتاعة الصفحة دى',
	'imagemap_no_link' => '$1 غلط:مفيش لينك شغالة فى اخر السطر',
	'imagemap_invalid_title' => 'غلط:عنوان مش صحيح فى اللينك عند السطر$1',
	'imagemap_missing_coord' => 'غلط: إحداثيات مش كافية للشكل عند السطر $1',
	'imagemap_unrecognised_shape' => 'غلط:شكل مش معروف عند السطر$1، كل سطر لازم يبتدى بواحد من دول: default, rect, circle او poly',
	'imagemap_invalid_coord' => 'غلط:احداثى مش صحيح عند السطر $1, لازم يكون رقم',
	'imagemap_invalid_desc' => 'غلط: محدد وصف مش صحيح, لازم يكون واحد من دول: <code>$1</code>',
	'imagemap_description' => 'عن الصورة دي',
	'imagemap_desc_types' => 'اليمين من فوق،اليمين من تحت،الشمال من تحت،الشمال من فوق، ولا حاجة',
	'imagemap_poly_odd' => 'خطأ: تم العثور على مضلع بعدد فردى من الأضلاع فى السطر $1',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'imagemap_desc' => "Permite los mapes d'imaxe clicables per aciu de la etiqueta <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => 'Error: ha especificase una imaxe na primer llinia',
	'imagemap_invalid_image' => 'Error: la imaxe nun ye válida o nun esiste',
	'imagemap_bad_image' => "Error: La imaxe ta na llista prieta d'esta páxina",
	'imagemap_no_link' => 'Error: atopóse un enllaz non válidu a lo cabero la llinia $1',
	'imagemap_invalid_title' => 'Error: títulu non válidu nel enllaz de la llinia $1',
	'imagemap_missing_coord' => 'Error: nun hai abondes coordenaes pa formar la figura de la llinia $1',
	'imagemap_unrecognised_shape' => "Error: figura non reconocida en llinia $1, cada llinia ha empecipiar con dalguna d'estes: default, rect, circle o poly",
	'imagemap_invalid_coord' => 'Error: coordenada non válida en llinia $1, ha ser un númberu',
	'imagemap_invalid_desc' => "Error: parámetru 'desc' non válidu, ha ser ún d'estos: <code>$1</code>",
	'imagemap_description' => 'Tocante a esta imaxe',
	'imagemap_poly_odd' => 'Error: atopóse un polígonu con un númberu impar de coordenaes na llinia $1',
);

/** Azerbaijani (Azərbaycanca)
 * @author Vago
 */
$messages['az'] = array(
	'imagemap_desc_types' => 'yuxarı-sağ, aşağı-sağ, aşağı-sol, yuxarı-sol, heç nə',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code> билдәһе ярҙамында килент яғында баҫмалы рәсемдәр картаһын күрһатеү мөмкинлеген бирә',
	'imagemap_no_image' => 'Хата: беренсе юлда рәсем билдәләнгән булырға тейеш',
	'imagemap_invalid_image' => 'Хата: рәсем дөрөҫ түгел йәки юҡ',
	'imagemap_bad_image' => 'Хата: рәсем был биттә ҡара исемлеккә керә',
	'imagemap_no_link' => 'Хата: $1 юлының аҙағында һылтанма дөрөҫ түгел',
	'imagemap_invalid_title' => 'Хата: $1 юлында һылтанманың исеме дөрөҫ түгел',
	'imagemap_missing_coord' => 'Хата: $1 юлында фигура өсөн координаталар етмәй',
	'imagemap_unrecognised_shape' => 'Хата: $1 юлында танылмаған фигура, һәр юл default, rect, circle йәки poly асҡыс һүҙҙәренең береһе менән башланырға тейеш',
	'imagemap_invalid_coord' => 'Хата: $1 юлында координата дөрөҫ түгел, һан булырға тейеш',
	'imagemap_invalid_desc' => 'Хата: desc дөрөҫ күрһәтелмәгән, түбәндәгеләрҙең береһе булырға тейеш: <code>$1</code>',
	'imagemap_description' => 'Рәсем тураһында',
	'imagemap_poly_odd' => 'Хата: $1 юлындағы күпмөйөштөң координаталар һаны — таҡ һан',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'imagemap_desc' => 'اجازت دن استفاده چه برچسپ<code>&lt;imagemap&gt;</code>نقشه یان تصاویر کلیکی کاربر-جهت',
	'imagemap_no_image' => '&lt;imagemap&gt;: بایدن یک تصویری ته خط اول مشخص کنیت',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: عکس نامعتبر یا موجود نهنت',
	'imagemap_no_link' => '&lt;imagemap&gt;: هچ معتبرین لینکی ته آهر خط$1پیداگ نه بوت',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: نامعتبراین عنوان ته لینک ته خط $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: کافی ان هماهنگی په شکل نیست ته خط $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: ناشناسین شکل ته خط $1، هر خط بایدن گون یکی چه شان شروه بیت:پیشفرض،مربع, گردیم یا باز',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: نامعتبراین هماهنگی ته خطا $1, بایدن یک شماره بیت',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: نامعتبراین مشخصه ای توضیح، بایدن یکی چه شان بیت: <code>$1</code>',
	'imagemap_description' => 'ای عکسء باره',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'imagemap_description' => 'Manónongod sa retratong ini',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'imagemap_desc' => 'Дазваляе стварэньне на старонцы кліента мапаў выявы з выкарыстаньнем тэгу <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Памылка: у першым радку мусіць быць пазначаная выява',
	'imagemap_invalid_image' => 'Памылка: няслушная выява альбо яна не існуе',
	'imagemap_bad_image' => 'Памылка: выява на гэтай старонцы ўваходзіць у чорны сьпіс',
	'imagemap_no_link' => 'Памылка: ня знойдзеная слушная спасылка ў канцы радку $1',
	'imagemap_invalid_title' => 'Памылка: няслушная назва ў спасылцы ў радку $1',
	'imagemap_missing_coord' => 'Памылка: недастаткова каардынатаў для фігуры ў радку $1',
	'imagemap_unrecognised_shape' => 'Памылка: нераспазнаная фігура ў радку $1, кожны радок павінен пачынацца з: default, rect, circle ці poly',
	'imagemap_invalid_coord' => 'Памылка: няправільная каардыната ў радку $1, павінна быць лічба',
	'imagemap_invalid_desc' => 'Памылка: няслушнае значэньне desc, павінна быць адно з: <code>$1</code>',
	'imagemap_description' => 'Апісаньне выявы',
	'imagemap_poly_odd' => 'Памылка: у радку $1 знойдзены шматкутнік зь няцотнай колькасьцю каардынатаў',
);

/** Bulgarian (Български)
 * @author Spiritia
 */
$messages['bg'] = array(
	'imagemap_no_image' => 'Error: трябва да се укаже изображение на първия ред',
	'imagemap_invalid_image' => 'Error: невалидно или липсващо изображение',
	'imagemap_bad_image' => 'Грешка: има забрана за включване на изображението в тази страница',
	'imagemap_no_link' => 'Error: липсва валидна препратка в края на ред $1',
	'imagemap_invalid_title' => 'Error: невалидно заглавие в препратка на ред $1',
	'imagemap_missing_coord' => 'Error: недостатъчно координати за фигура на ред $1',
	'imagemap_unrecognised_shape' => 'Error: неразпозната фигура на ред $1; всеки ред трябва да са започва с някое от следните: default (по подразбиране), rect (правоъгълник), circle (кръг) или poly (многоъгълник)',
	'imagemap_invalid_coord' => 'Error: невалидна координата на ред $1, трябва да бъде число',
	'imagemap_invalid_desc' => 'Грешка: невалидна спецификация на описанието (desc), което трябва да бъде някое от следните: <code>$1</code>',
	'imagemap_description' => 'Информация за изображението',
	'imagemap_poly_odd' => 'Грешка: открит е многоъгълник (poly) с нечетен брой координати на ред $1',
);

/** Banjar (Bahasa Banjar)
 * @author Alamnirvana
 */
$messages['bjn'] = array(
	'imagemap_invalid_coord' => 'Nyunyuk: koordinat kada sah pada baris ka $1, musti barupa angka',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'imagemap_no_image' => 'ত্রুটি:প্রথম লাইনে অবশ্যই একটি চিত্র নির্দিষ্ট করতে হবে',
	'imagemap_invalid_image' => 'ত্রুটি:চিত্রটি সঠিক নয় অথবা চিত্রটি নাই',
	'imagemap_bad_image' => 'ত্রুটি:এই পাতায় ছবি কালতালিকাভুক্ত করা হয়েছে',
	'imagemap_no_link' => 'ত্রুটি:লাইন নম্বর $1 এ শেষ কোন সঠিক লিঙ্ক পাওয়া যায় নি',
	'imagemap_invalid_title' => 'ত্রুটি:লাইন নম্বর $1 এ লিঙ্কে সঠিক শিরোনাম নাই',
	'imagemap_missing_coord' => 'ত্রুটি:লাইন নম্বর $1 এ আকারের জন্য যথেষ্ট স্থানাংক নাই',
	'imagemap_invalid_coord' => 'ত্রুটি:লাইন নম্বর $1 এ স্থানাংক সঠিক নয়, তা অবশ্যই সংখ্যা হবে',
	'imagemap_description' => 'এই চিত্র সম্পর্কে',
);

/** Tibetan (བོད་ཡིག)
 * @author Freeyak
 */
$messages['bo'] = array(
	'imagemap_description' => 'བརྙན་རིས་འདིའི་སྐོར།',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'imagemap_desc' => "Aotren a ra ar c'hartennoù skeudennoù arval klikadus, a-drugarez d'ar valizenn <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => 'Error: rankout a rit spisaat ur skeudenn el linenn gentañ',
	'imagemap_invalid_image' => "Error : direizh eo ar skeudenn pe n'eus ket anezhi",
	'imagemap_bad_image' => 'Fazi : emañ ar skeudenn war al listenn zu evit ar bajenn-mañ',
	'imagemap_no_link' => "Error: n'eus bet kavet liamm reizh ebet e dibenn al linenn $1",
	'imagemap_invalid_title' => 'Error: titl direizh el liamm el linenn $1',
	'imagemap_missing_coord' => 'Error: diouer a zaveennoù zo evit stumm al linenn $1',
	'imagemap_unrecognised_shape' => 'Fazi : Furm dianav el linenn $1, rankout a ra pep linenn kregiñ gant unan eus ar gerioù-mañ : default, rect, circle pe poly',
	'imagemap_invalid_coord' => 'Fazi : daveenn fall el linenn $1, ret eo e vije un niver',
	'imagemap_invalid_desc' => 'Fazi : arventenn desc direizh; setu an arventennoù aotreet : <code>$1</code>',
	'imagemap_description' => 'Diwar-benn ar skeudenn-mañ',
	'imagemap_poly_odd' => 'Fazi : kavet ez eus ul lieskorn dezhañ un niver daveennoù ampar el linenn $1',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'imagemap_desc' => 'Omogućuje mape slika na klijentskom računaru koje se mogu kliknuti koristeći oznaku <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Greška: morate odrediti sliku u prvom redu',
	'imagemap_invalid_image' => 'Greška: slika je nevaljana ili ne postoji',
	'imagemap_bad_image' => 'Greška: slika je nepoželjna na ovoj stranici',
	'imagemap_no_link' => 'Greška: nije pronađen valjan link na kraju reda $1',
	'imagemap_invalid_title' => 'Greška: nevaljan naslov u linku u redu $1',
	'imagemap_missing_coord' => 'Greška: nema dovoljno koordinata za iscrtavanje u redu $1',
	'imagemap_unrecognised_shape' => 'Greška: neprepoznat oblik u redu $1, svaki red mora počinjati sa jednim od: default, rect, circle ili poly',
	'imagemap_invalid_coord' => 'Greška: nevaljane koordinate u redu $1, treba biti broj',
	'imagemap_invalid_desc' => 'Greška: nevaljana specifikacija opisa, mora biti jedan od: <code>$1</code>',
	'imagemap_description' => 'O ovoj slici',
	'imagemap_desc_types' => 'gore-desno, dolje-desno, dolje-lijevo, gore-lijevo, nema',
	'imagemap_poly_odd' => 'Greška: pronađen poly sa neparnim brojem koordinata u redu $1',
);

/** Catalan (Català)
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'imagemap_desc' => "Permet mapes d'imatges clicables des del costat del client fent servir l'etiqueta <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => 'Error: cal especificar una imatge en la primera línia',
	'imagemap_invalid_image' => 'Error: la imatge no es vàlida o no existeix',
	'imagemap_bad_image' => 'Error: la imatge està en la llista negra',
	'imagemap_no_link' => "Error: no s'ha trobat cap enllaç vàlid al final de la línia $1",
	'imagemap_invalid_title' => "Error: el títol no és vàlid a l'enllaç de la línia $1",
	'imagemap_missing_coord' => 'Error: no hi ha coordenades suficients per a la forma de la línia $1',
	'imagemap_unrecognised_shape' => 'Error: la forma de la línia $1 no és reconeixible, cada línia ha de començar amb una de les opcions següents: default, rect, circle or poly',
	'imagemap_invalid_coord' => 'Error: la coordenada a la línia $1 no és vàlida, ha de ser un nombre',
	'imagemap_invalid_desc' => "Error: l'especificació de descripció no és vàlida, ha de ser una de: <code>$1</code>",
	'imagemap_description' => 'Quant a la imatge',
	'imagemap_poly_odd' => 'Error: poly amb un nombre senar de coordenades a la línia $1',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'imagemap_invalid_image' => 'Гlалат: нийса дац йа ишта сурт дац кху чохь',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'imagemap_description' => "À prupositu d'issa imagine",
);

/** Czech (Česky)
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'imagemap_desc' => 'Umožňuje vytvoření klikací mapy obrázku na straně klienta pomocí značky <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Error: na první řádce musí být určen obrázek',
	'imagemap_invalid_image' => 'Error: soubor není platný nebo neexistuje',
	'imagemap_bad_image' => 'Chyba: obrázek se nachází na černé listině',
	'imagemap_no_link' => 'Error: nebyl nalezen žádný platný odkaz na konci řádku $1',
	'imagemap_invalid_title' => 'Error: neplatný název v odkazu na řádku $1',
	'imagemap_missing_coord' => 'Error: chybějící souřadnice tvaru na řádku $1',
	'imagemap_unrecognised_shape' => 'Error: nerozpoznaný tvar na řádku $1, každá řádka musí začínat definicí tvaru: default, rect, circle nebo poly',
	'imagemap_invalid_coord' => 'Error: neplatné souřadnice na řádku $1, je očekáváno číslo',
	'imagemap_invalid_desc' => 'Error: neplatné určení oblasti desc, je očekávána jedna z možností: <code>$1</code>',
	'imagemap_description' => 'O tomto obrázku',
	'imagemap_poly_odd' => 'Chyba: na řádku $1 nalezen mnohoúhelník s lichým počtem souřadnic',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'imagemap_description' => "Ynglŷn â'r ddelwedd hon",
);

/** Danish (Dansk)
 * @author Byrial
 * @author Peter Alberti
 */
$messages['da'] = array(
	'imagemap_desc' => 'Muliggør klikbare billeder med brug af <code>&lt;imagemap&gt;</code>-tagget.',
	'imagemap_no_image' => '&lt;imagemap&gt;: Der skal angives et billednavn i første linje',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: Billedet er ugyldigt eller findes ikke',
	'imagemap_bad_image' => 'Fejl: billedet er sortlistet på denne side',
	'imagemap_no_link' => '&lt;imagemap&gt;: Fandt ikke en brugbar henvisning i slutningen af linje $1',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: Ugyldig titel i henvisning på linje $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: Utilstrækkeligt antal koordinater til omridset i linje $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: Ukendt omridstype i linje $1. Alle linjer skal starte med en af:default, rect, circle or poly',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: Ugyldig koordinat på linje $1, koordinater skal være tal',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: Ugyldig specifikation af desc, skal være en af: <code>$1</code>',
	'imagemap_description' => 'Om dette billede',
	'imagemap_desc_types' => 'top-højre, bund-højre, bund-venstre, top-venstre, ingen',
	'imagemap_poly_odd' => 'Fejl: fandt polygon med et ulige antal koordinater på linje $1',
);

/** German (Deutsch)
 * @author Kghbln
 * @author LWChris
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'imagemap_desc' => 'Ergänzt das Tag <code>&lt;imagemap&gt;</code> zum Erstellen verweissensitiver Grafiken',
	'imagemap_no_image' => '&lt;imagemap&gt;-Fehler: In der ersten Zeile muss ein Bild angegeben werden',
	'imagemap_invalid_image' => '&lt;imagemap&gt;-Fehler: Bild ist ungültig oder nicht vorhanden',
	'imagemap_bad_image' => 'Fehler: Das Bild steht auf der Liste unerwünschter Bilder',
	'imagemap_no_link' => '&lt;imagemap&gt;-Fehler: Am Ende von Zeile $1 wurde kein gültiger Link gefunden',
	'imagemap_invalid_title' => '&lt;imagemap&gt;-Fehler: ungültiger Titel im Link in Zeile $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;-Fehler: Zu wenige Koordinaten in Zeile $1 für den Umriss',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;-Fehler: Unbekannte Umrissform in Zeile $1. Jede Zeile muss mit einem dieser Parameter beginnen: <tt>default</tt>, <tt>rect</tt>, <tt>circle</tt> oder <tt>poly</tt>',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;-Fehler: Ungültige Koordinate in Zeile $1: es sind nur Zahlen erlaubt',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;-Fehler: Ungültiger „desc“-Parameter, möglich sind: <code>$1</code>',
	'imagemap_description' => 'Über dieses Bild',
	'imagemap_desc_types' => 'oben rechts, unten rechts, unten links, oben links, keine',
	'imagemap_poly_odd' => 'Fehler: Polygon mit ungerader Anzahl an Koordinaten in Zeile $1',
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'imagemap_desc' => 'pê şuxulnayişê etiketê <code>&lt;imagemap&gt;</code>i destur dano gırewtox xeritayê resmi bıtıkın',
	'imagemap_no_image' => 'xeta: şıma gani satıro ewwil de yew resm nişan bıkeri',
	'imagemap_invalid_image' => 'xeta: resım ya çino ya zi meqbul niyo',
	'imagemap_bad_image' => 'xeta: no pel de resım biyo qereliste',
	'imagemap_no_link' => 'xeta: peyniyê satıro $1. de yew gıreyo meqbul çino.',
	'imagemap_invalid_title' => 'xeta:satıro $1. de gıre de sernameyo nemeqbul esto.',
	'imagemap_missing_coord' => 'xeta:satıro $1. de qey şekli koordinat tayê',
	'imagemap_unrecognised_shape' => 'xeta:satıro $1. de şeklo netemam esto, her satır gani pê her yew ninan destpêbıkero: default, rect, cirle ya zi poly',
	'imagemap_invalid_coord' => 'xeta: satıro $1. de koordinato nemeqbul, gani yew amar bıbo',
	'imagemap_invalid_desc' => 'xeta: diyarikerdışê desci yo nemeqbul, gani ninan ra yew bıbo: <code>$1</code>',
	'imagemap_description' => 'Derheqê resmi de',
	'imagemap_poly_odd' => 'xeta: satıro $1. de poliyo ke wayirê yew koordinat diya',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'imagemap_desc' => 'Zmóžnja klikajobne wobraze wót boka klienta z pomocu toflicki <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Zmólka: musyš wobraz w prědnej zmužce pódaś',
	'imagemap_invalid_image' => 'Zmólka: wobraz jo njepłaśiwy abo njeeksistěrujo',
	'imagemap_bad_image' => 'Zmólka: wobraz stoj na cornej lisćinje',
	'imagemap_no_link' => 'Zmólka: žeden płaśiwy wótkaz na kóńcu smužki $1 namakany',
	'imagemap_invalid_title' => 'Zmólka: njepłaśiwy titel we wótkazu w smužce $1',
	'imagemap_missing_coord' => 'Zmólka: nic dosć koordinatow za formu w smužce $1',
	'imagemap_unrecognised_shape' => 'Zmólka: njespóznata forma w smužce $1, kužda smužka musy se z jadnym z toś tych parametrow zachopiś: default, rect, circle abo poly',
	'imagemap_invalid_coord' => 'Zmólka: njepłaśiwa koordinata w smužce $1, musy to licba byś',
	'imagemap_invalid_desc' => 'Zmólka: njepłaśiwy parameter "desc", móžno su: <code>$1</code>',
	'imagemap_description' => 'Wó toś tom wobrazu',
	'imagemap_poly_odd' => 'Zmólka: polygon z njerowneju licbu koordinatow w smužce $1',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Dead3y3
 */
$messages['el'] = array(
	'imagemap_desc' => 'Επιτρέπει από την πλευρά-του-πελάτη επιλέξιμους εικονοχάρτες χρησιμοποιώντας την ετικέτα <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Σφάλμα: πρέπει να ορίσετε μια εικόνα στην πρώτη γραμμή',
	'imagemap_invalid_image' => 'Σφάλμα: η εικόνα είναι άκυρη ή ανύπαρκτη',
	'imagemap_bad_image' => 'Σφάλμα: η εικόνα βρίσκεται στη μαύρη λίστα σε αυτή τη σελίδα',
	'imagemap_no_link' => 'Σφάλμα: δεν βρέθηκε κανένας έγκυρος σύνδεσμος στο τέλος της γραμμής $1',
	'imagemap_invalid_title' => 'Σφάλμα: άκυρος τίτλος σε σύνδεσμο στη γραμμή $1',
	'imagemap_missing_coord' => 'Σφάλμα: όχι αρκετές συντεταγμένες για σχήμα στη γραμμή $1',
	'imagemap_unrecognised_shape' => 'Σφάλμα: μη αναγνωρίσιμο σχήμα στη γραμμή $1, κάθε γραμμή πρέπει να αρχίζει με μία από τις λέξεις: default, rect, circle ή poly',
	'imagemap_invalid_coord' => 'Σφάλμα: άκυρη συντεταγμένη στη γραμμή $1, πρέπει να είναι αριθμός',
	'imagemap_invalid_desc' => 'Σφάλμα: άκυρος ορισμός desc, πρέπει να είναι ένας από τους: <code>$1</code>',
	'imagemap_description' => 'Σχετικά με αυτήν την εικόνα',
	'imagemap_poly_odd' => 'Σφάλμα: βρέθηκε πολύγωνο με περιττό αριθμό συντεταγμένων στη γραμμή $1',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'imagemap_desc' => 'Permesas klientflankajn klakeblajn bildmapojn uzante etikedon <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Eraro: devas specifi bildon en la unua linio',
	'imagemap_invalid_image' => 'Eraro: bildo estas aŭ malvalida aŭ neekzista',
	'imagemap_bad_image' => 'Eraro: bildo estas nigralistigita en ĉi tiu paĝo',
	'imagemap_no_link' => 'Eraro: neniu valida ligilo estis trovita ĉe fino de linio $1',
	'imagemap_invalid_title' => 'Eraro: malvalida titolo en ligilo ĉe linio $1',
	'imagemap_missing_coord' => 'Eraro: mankas sufiĉaj koordinatoj por formo ĉe linio $1',
	'imagemap_unrecognised_shape' => 'Eraro: nekonata formo ĉe linio $1; ĉiu linio devas komenci kun unu el: default, rect, circle aŭ poly',
	'imagemap_invalid_coord' => 'Eraro: Malvalida koordinato ĉe linio $1; ĝi nepre estu nombro',
	'imagemap_invalid_desc' => 'Eraro: malvalida deklarado de desc, devas esti unu el: <code>$1</code>',
	'imagemap_description' => 'Pri ĉi tiu bildo',
	'imagemap_poly_odd' => 'Eraro: troviĝis poligono kun malpara nombro de koordinatoj en linio $1',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Drini
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'imagemap_desc' => "Permite ''image-maps'' dinámicos usando la etiqueta <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => 'Error: hay que especificar un imagen en la línea primera',
	'imagemap_invalid_image' => 'Error: la imagen no es válida o no existe',
	'imagemap_bad_image' => 'Error: la imagen esta en la lista negra en esta página',
	'imagemap_no_link' => 'Error: no se encontró ningún enlace válido al final de la línea $1',
	'imagemap_invalid_title' => 'Error: título no válido en un enlace de la linea $1',
	'imagemap_missing_coord' => 'Error: no hay bastante coordinates para la figura a la linea $1',
	'imagemap_unrecognised_shape' => 'Error: figura no reconocida a la linea $1, cada linea debe comenzar con uno de default, rect, circle o poly',
	'imagemap_invalid_coord' => 'Error: hay una coordenada no válida en la línea $1, debe ser un número',
	'imagemap_invalid_desc' => 'Error: especificación de desc no válido, debe ser uno de: <code>$1</code>',
	'imagemap_description' => 'Acerca de esta imagen',
	'imagemap_poly_odd' => 'Error: se encontró un polígono con un número de coordinates impar en la linea $1',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'imagemap_desc' => 'Lubab kliendipoolse klõpsatava pildi ala, mis kasutab <code>&lt;imagemap&gt;</code>-märgendit.',
	'imagemap_no_image' => 'Tõrge: Esimesel real peab määrama pildi.',
	'imagemap_invalid_image' => 'Tõrge: Pilt on vigane või teda pole olemas.',
	'imagemap_bad_image' => 'Tõrge: Pilt on siin lehel mustas nimekirjas.',
	'imagemap_no_link' => 'Tõrge: Rea $1 lõpust ei leitud sobivat linki',
	'imagemap_invalid_title' => 'Tõrge: Real $1 lingis vigane pealkiri',
	'imagemap_missing_coord' => 'Tõrge: Real $1 pole kujundi jaoks piisavalt koordinaate',
	'imagemap_unrecognised_shape' => 'Tõrge: Real $1 on tundmatu kujund; rida peab algama ühega neist: <tt>default</tt>, <tt>rect</tt>, <tt>circle</tt> või <tt>poly</tt>.',
	'imagemap_invalid_coord' => 'Tõrge: Real $1 on vigane koordinaat; see peab olema number',
	'imagemap_invalid_desc' => 'Tõrge: Vigane "desc"-parameeter; peab olema üks järgmistest: <code>$1</code>',
	'imagemap_description' => 'Info pildi kohta',
	'imagemap_poly_odd' => 'Tõrge: Real $1 on polügoon paaritu arvu koordinaatidega.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'imagemap_no_image' => 'Errorea: lehen lerroan irudia zehaztu behar da',
	'imagemap_invalid_image' => 'Errorea: irudia baliogabea da edo ez da existitzen',
	'imagemap_invalid_coord' => 'Errorea: baliogabeko koordenatua $1. lerroan, zenbaki bat izan behar du',
	'imagemap_description' => 'Irudi honen inguruan',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'imagemap_description' => 'Al tentu esta imahin',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'imagemap_desc' => 'امکان ایجاد نقشه‌های تصویری قابل کلیک کردن در سمت کاربر را با استفاده از برچسب <code>&lt;imagemap&gt;</code> فراهم می‌آورد',
	'imagemap_no_image' => '<imagemap>: باید در اولین سطر یک تصویر را مشخص کنید',
	'imagemap_invalid_image' => '<imagemap>: تصویر غیرمجاز است یا وجود ندارد',
	'imagemap_bad_image' => 'خطا: تصویر در این صفحه در فهرست سیاه قرار دارد',
	'imagemap_no_link' => '<imagemap>: هیچ پیوند مجازی تا انتهای سطر $1 پیدا نشد',
	'imagemap_invalid_title' => '<imagemap>: عنوان غیرمجاز در پیوند سطر $1',
	'imagemap_missing_coord' => '<imagemap>: تعداد مختصات در سطر $1 برای شکل کافی نیست',
	'imagemap_unrecognised_shape' => '<imagemap>: شکل ناشناخته در سطر $1، هر سطر باید با یکی از این دستورات آغاز شود: default، rect، circle یا poly',
	'imagemap_invalid_coord' => '<imagemap>: مختصات غیرمجاز در سطر $1، مختصات باید عدد باشد',
	'imagemap_invalid_desc' => '<imagemap>: توضیحات غیرمجاز، باید یکی از این موارد باشد: <code>$1</code>',
	'imagemap_description' => 'دربارهٔ این تصویر',
	'imagemap_poly_odd' => 'خطا: چند ضلعی با تعداد فرعی از مختصات در سطر $1 پیدا شد',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Nike
 * @author Str4nd
 * @author Tarmo
 */
$messages['fi'] = array(
	'imagemap_desc' => 'Mahdollistaa napsautettavien kuvakarttojen tekemisen <code>&lt;imagemap&gt;</code>-elementillä.',
	'imagemap_no_image' => 'Error: kuva pitää määritellä ensimmäisellä rivillä.',
	'imagemap_invalid_image' => 'Error: kuva ei kelpaa tai sitä ei ole olemassa',
	'imagemap_bad_image' => 'Virhe: Kuva kuuluu sivuston estolistalle',
	'imagemap_no_link' => 'Virhe: rivin $1 lopusta ei löytynyt kelvollista linkkiä',
	'imagemap_invalid_title' => 'Virhe: kelvoton otsikko linkissä rivillä $1',
	'imagemap_missing_coord' => 'Virhe: rivin $1 muodolle ei ole määritelty riittävästi koordinaatteja',
	'imagemap_unrecognised_shape' => 'Virhe: rivin $1 muotoa ei tunnistettu, jokaisen rivin tulee alkaa jollakin seuraavista: default, rect, circle tai poly',
	'imagemap_invalid_coord' => 'Error: kelpaamaton koordinaatti rivillä $1. Koordinaatin täytyy olla numero.',
	'imagemap_invalid_desc' => 'Virhe: virheellinen kohdemäärittely, kohdemäärittelyn tulee olla yksi seuraavista: <code>$1</code>',
	'imagemap_description' => 'Kuvan tiedot',
	'imagemap_poly_odd' => 'Virhe: löytyi polygoni, jossa pariton määrä koordinaatteja rivillä $1',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'imagemap_no_image' => 'Feilur: tú mást skriva eitt myndanavn á fyrstu linju',
	'imagemap_invalid_image' => 'Feilur: Myndin er ógyldug ella er ikki til',
	'imagemap_bad_image' => 'Feilur: Myndin er á svartalista á hesi síðu',
	'imagemap_no_link' => 'Feilur: ongin galdandi slóð var funnin fyri endan á linju $1',
	'imagemap_invalid_title' => 'Feilur: skeivt heiti á leinkjuni á linju $1',
	'imagemap_description' => 'Um hesa myndina',
);

/** French (Français)
 * @author Grondin
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'imagemap_desc' => 'Permet les cartes images clientes cliquables, grâce à la balise <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => '&lt;imagemap&gt; : vous devez spécifier une image dans la première ligne',
	'imagemap_invalid_image' => '&lt;imagemap&gt; : l’image est invalide ou n’existe pas',
	'imagemap_bad_image' => '&lt;imagemap&gt; : l’image est en liste noire sur cette page',
	'imagemap_no_link' => '&lt;imagemap&gt; : aucun lien valide n’a été trouvé à la fin de la ligne $1',
	'imagemap_invalid_title' => '&lt;imagemap&gt; : titre invalide dans le lien à la ligne  $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt; : pas assez de coordonnées pour la forme à la ligne  $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt; : forme non reconnue à la ligne $1, chaque ligne doit débuter par un des mots suivants : default, rect, circle ou poly',
	'imagemap_invalid_coord' => '&lt;imagemap&gt; : coordonnée invalide à la ligne $1, doit être un nombre',
	'imagemap_invalid_desc' => '&lt;imagemap&gt; : paramètre « desc » invalide, les paramètres possibles sont : $1',
	'imagemap_description' => 'À propos de cette image',
	'imagemap_poly_odd' => 'Erreur : trouvé un polygone avec un nombre impair de coordonnées à la ligne $1',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'imagemap_desc' => 'Pèrmèt les mapes émâges cliantes clicâbles, grâce a la balisa <code>&lt;imagemap&gt;</code>.',
	'imagemap_no_image' => 'Èrror : vos dête spècefiar una émâge dens la premiére legne',
	'imagemap_invalid_image' => 'Èrror : l’émâge est envalida ou ben ègziste pas',
	'imagemap_bad_image' => 'Èrror : l’émâge est en lista nêre sur ceta pâge',
	'imagemap_no_link' => 'Èrror : nion lim valido at étâ trovâ a la fin de la legne $1',
	'imagemap_invalid_title' => 'Èrror : titro envalido dens lo lim a la legne $1',
	'imagemap_missing_coord' => 'Èrror : pas prod de coordonâs por la fôrma a la legne $1',
	'imagemap_unrecognised_shape' => 'Èrror : fôrma pas recognua a la legne $1, châque legne dêt comenciér per yon de cetos mots : default, rect, circle ou ben poly',
	'imagemap_invalid_coord' => 'Èrror : coordonâ envalida a la legne $1, dêt étre un nombro',
	'imagemap_invalid_desc' => 'Èrror : paramètre « dèsc » envalido, los paramètres possiblos sont : <code>$1</code>',
	'imagemap_description' => 'A propôs de ceta émâge',
	'imagemap_desc_types' => 'd’amont a drêta, d’avâl a drêta, d’avâl a gôche, d’amont a gôche, nion',
	'imagemap_poly_odd' => 'Èrror : trovâ un poligono avouéc un nombro mâl-par de coordonâs a la legne $1',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'imagemap_desc' => 'Permite mapas de imaxe nos que se poden facer clic usando a etiqueta <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Erro: debe especificar unha imaxe na primeira liña',
	'imagemap_invalid_image' => 'Erro: a imaxe non é válida ou non existe',
	'imagemap_bad_image' => 'Erro: a imaxe atópase na lista negra desta páxina',
	'imagemap_no_link' => 'Erro: non se atopou ningunha ligazón válida ao final da liña $1',
	'imagemap_invalid_title' => 'Erro: título non válido na ligazón na liña $1',
	'imagemap_missing_coord' => 'Erro: non abondan as coordenadas para crear un polígono, na liña $1',
	'imagemap_unrecognised_shape' => 'Erro: forma descoñecida na liña $1, cada liña debe comezar con un dos seguintes: por defecto, rectángulo, círculo ou polígono',
	'imagemap_invalid_coord' => 'Erro: coordenada non válida na liña $1, debe ser un número',
	'imagemap_invalid_desc' => 'Erro: especificación da descrición non válida, debe ser unha de: <code>$1</code>',
	'imagemap_description' => 'Acerca desta imaxe',
	'imagemap_poly_odd' => 'Erro: atopouse un polígono cun número impar de coordenadas na liña $1',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'imagemap_description' => 'Περὶ τῆσδε τῆς εἰκόνος',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'imagemap_desc' => "Macht s Aalege vu verwyys-sensitive Grafike ''(image maps)'' megli mit dr Hilf vu dr <code>&lt;imagemap&gt;</code>-Syntax",
	'imagemap_no_image' => 'Fähler: in dr erschte Zyylete muess e Bild aagee wäre',
	'imagemap_invalid_image' => 'Fähler: Bild ist nit giltig oder s git s nit',
	'imagemap_bad_image' => 'Fähler: S Bild stoht uf dr Lischt vu nit gwinschte Bilder',
	'imagemap_no_link' => 'Fähler: Am Änd vu Zyyle $1 isch kei giltig Gleich gfunde wore',
	'imagemap_invalid_title' => 'Fähler: uugiltiger Titel im Gleich in dr Zyyle $1',
	'imagemap_missing_coord' => 'Fähler: Z wenig Koordinate in dr Zyyle $1 fir dr Umriss',
	'imagemap_unrecognised_shape' => 'Fähler: Nit bekannti Umrissform in dr Zyyle $1. Jedi Zyyle muess mit eim vu däne Parameter aafange: <tt>default, rect, circle</tt> oder <tt>poly</tt>',
	'imagemap_invalid_coord' => 'Fähler: Uugiltigi Koordinate in dr Zyyle $1: s sin nume Zahle erlaubt',
	'imagemap_invalid_desc' => 'Fähler: Uugiltige „desc“-Parameter, megli sin: <code>$1</code>',
	'imagemap_description' => 'Iber des Bild',
	'imagemap_poly_odd' => 'Fähler: Polygon mit ere uugrade Anzahl vu Koordinate in dr Zyyle $1',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'imagemap_no_image' => 'ત્રુટિ: પહેલી લીટીમાં ચિત્રની સ્પષ્ટાતા કરેલી હોવી જ જોઈએ',
	'imagemap_invalid_image' => 'ત્રુટી: ચિત્ર યાતો અવૈધ છે અથવાતો અસ્તિત્વમાં નથી',
	'imagemap_bad_image' => 'ત્રુટી: આ પાના પર ચિત્ર પર પ્રતિબંધ મુકેલો છે',
	'imagemap_no_link' => 'ત્રુટી : $1મી હરોળ ના અંતે કોઈ પણ વૈધ કડી ન મળી',
	'imagemap_invalid_title' => 'ત્રુટી: $1 મી લાઈનમાં અયોગ્ય શીર્ષક',
	'imagemap_missing_coord' => 'ત્રુટી: $1મી હરોળમાં પૂરતાં આકાર માટે અક્ષાંસ રેખાંશ ન મળ્યાં',
	'imagemap_unrecognised_shape' => 'ત્રુટી: $1મી હરોળમાં અયોગ્ય અક્ષર, દરેક હરોળ : default, rect, circle or poly થી શરૂ થવી જોઈએ.',
	'imagemap_invalid_coord' => 'ક્ષતિ: લીટી $1 પર અયોગ્ય કો-ઓર્ડિનેટ, સંખ્યા જ હોવી જોઈએ.',
	'imagemap_invalid_desc' => 'Error: અયોગ્ય વર્ણન વિગત, આમાંનું એક હોવુ જોઈએ: <code>$1</code>',
	'imagemap_description' => 'આ ચિત્ર વિષે',
	'imagemap_poly_odd' => 'ત્રુટી:  $1 મી હરોળમાં વિસંગત ક્રમાંકના નિર્દેશકો મળી આવ્યાં',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotem Liss
 */
$messages['he'] = array(
	'imagemap_desc' => 'אפשרות למפות תמונה עם קישורים בצד הלקוח באמצעות התגית <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'שגיאה: יש לציין תמונה בשורה הראשונה',
	'imagemap_invalid_image' => 'שגיאה: התמונה שגויה או שאינה קיימת',
	'imagemap_bad_image' => 'שגיאה: התמונה אסורה לשימוש בדף זה',
	'imagemap_no_link' => 'שגיאה: לא נמצא קישור תקף בסוף שורה $1',
	'imagemap_invalid_title' => 'שגיאה: כותרת שגויה בקישור בשורה $1',
	'imagemap_missing_coord' => 'שגיאה: לא מספיק קוארדינאטות לצורה בשורה $1',
	'imagemap_unrecognised_shape' => 'שגיאה: צורה בלתי מזוהה בשורה $1, כל שורה חייבת להתחיל עם אחת האפשרויות הבאות: default, rect, circle or poly',
	'imagemap_invalid_coord' => 'שגיאה;: קוארדינאטה שגויה בשורה $1, היא חייבת להיות מספר',
	'imagemap_invalid_desc' => 'שגיאה: הגדרת פרמטר desc שגויה, צריך להיות אחד מהבאים: $1',
	'imagemap_description' => 'אודות התמונה',
	'imagemap_poly_odd' => 'שגיאה: איזור poly עם מספר אי־זוגי של קואורדינטות בשורה $1',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 */
$messages['hi'] = array(
	'imagemap_desc' => 'क्लायंटके चित्रनक्शे <code>&lt;imagemap&gt;</code> टॅग देकर इस्तेमाल किये जा सकतें हैं',
	'imagemap_no_image' => 'Error: पहली कतारमें चित्र देना जरूरी हैं',
	'imagemap_invalid_image' => 'Error: गलत या अस्तित्वमें ना होने वाला चित्र',
	'imagemap_bad_image' => 'त्रुटि: छबि को इस पृष्ठ पे ब्लाकलिस्ट किया गया है',
	'imagemap_no_link' => 'Error: $1 कतार के आखिर में वैध कड़ी मिली नहीं',
	'imagemap_invalid_title' => 'Error: $1 कतारमें दिये कड़ीका अवैध शीर्षक',
	'imagemap_missing_coord' => 'Error: $1 कतारपर आकार के लिये जरूरी कोऑर्डिनेट्स नहीं हैं',
	'imagemap_unrecognised_shape' => 'Error: $1 कतारमें गलत आकार, हर कतार: default, rect, circle अथवा poly से शुरू होनी चाहियें',
	'imagemap_invalid_coord' => 'Error: $1 कतार में गलत कोऑर्डिनेट्स, संख्या चाहिये',
	'imagemap_invalid_desc' => 'Error: गलत ज़ानकारी, इसमेंसे एक होनी चाहिये: <code>$1</code>',
	'imagemap_description' => 'इस चित्र के बारे में',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'imagemap_desc' => 'Omogućava strani klijenta klikabilne slike karata korištenjem <code>&lt;imagemap&gt;</code> oznake',
	'imagemap_no_image' => 'Error: morate navesti ime slike koju rabite u prvom retku',
	'imagemap_invalid_image' => 'Error: slika ne postoji ili je krivog tipa',
	'imagemap_bad_image' => 'Greška: slika je na crnom popisu na ovoj stranici',
	'imagemap_no_link' => 'Error: nema (ispravne) poveznice na kraju retka $1',
	'imagemap_invalid_title' => 'Error: loš naziv u poveznici u retku $1',
	'imagemap_missing_coord' => 'Error: nedovoljan broj koordinata za oblik u retku $1',
	'imagemap_unrecognised_shape' => 'Error: oblik u retku $1 nije prepoznat, svaki redak mora početi s jednim od oblika: default, rect, circle ili poly',
	'imagemap_invalid_coord' => 'Error: nevaljane koordinate u retku $1, mora biti broj',
	'imagemap_invalid_desc' => 'Error: nevaljan opis, mora biti jedan od: <code>$1</code>',
	'imagemap_description' => "Ovo je slika/karta s poveznicama (''imagemap'')",
	'imagemap_poly_odd' => 'Greška: pronađen poly s neobičnim brojem koordinata u redu $1',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'imagemap_desc' => 'Zmóžnja klikajomne wobrazowe mapy na klientowej stronje z pomocu taflički <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => '&lt;imagemap&gt; zmylk: Dyrbiš w prěnjej lince wobraz podać',
	'imagemap_invalid_image' => '&lt;imagemap&gt; zmylk: Wobraz je njepłaćiwy abo njeeksistuje',
	'imagemap_bad_image' => 'Zmylk: wobraz na tutej stronje je na čornej lisćinje',
	'imagemap_no_link' => '&lt;imagemap&gt; zmylk: Na kóncu linki $1 njebu płaćiwy wotkaz namakany',
	'imagemap_invalid_title' => '&lt;imagemap&gt; zmylk: njepłaćiwy titul we wotkazu w lince $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt; zmylk: Přemało koordinatow w lince $1 za podobu',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt; zmylk: Njeznata podoba w lince $1, kóžda linka dyrbi so z jednym z tutych parametrow započeć: <tt>default, rect, circle</tt> abo <tt>poly</tt>',
	'imagemap_invalid_coord' => '&lt;imagemap&gt; zmylk: njepłaćiwa koordinata w lince $1: su jenož ličby dowolene',
	'imagemap_invalid_desc' => '&lt;imagemap&gt; zmylk: Njepłaćiwy parameter "desc", móžne su: <code>$1</code>',
	'imagemap_description' => 'Wo tutym wobrazu',
	'imagemap_poly_odd' => 'Zmylk: polygon z njerunej ličbu koordinatow na lince $1',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 * @author Tgr
 */
$messages['hu'] = array(
	'imagemap_desc' => 'Lehetővé teszi kliensoldali imagemap-ek létrehozását a <code>&lt;imagemap&gt;</code> tag segítségével',
	'imagemap_no_image' => 'Error: kell egy előírt kép az első sorban',
	'imagemap_invalid_image' => 'Error: érvénytelen vagy nem létező kép',
	'imagemap_bad_image' => 'Hiba: a kép feketelistán van ezen az oldalon',
	'imagemap_no_link' => 'Error: nincs érvényes link a(z) $1. sor végén',
	'imagemap_invalid_title' => 'Hiba: érvénytelen cím a linkben, a(z) $1. sorban',
	'imagemap_missing_coord' => 'Error: nincs elég koordináta az alakításhoz a $1 sorban',
	'imagemap_unrecognised_shape' => 'Error: ismeretlen alakzat a(z) $1. sorban, mindegyiknek ezek valamelyikével kell kezdődnie: default, rect, circle vagy poly',
	'imagemap_invalid_coord' => 'Hiba: érvénytelen koordináta a(z) $1. sorban, számnak kell lennie',
	'imagemap_invalid_desc' => 'Error: hibás desc leírás, ezek egyike kell: <code>$1</code>',
	'imagemap_description' => 'Kép leírása',
	'imagemap_poly_odd' => 'Hiba: az $1. sorban páratlan számú koordináta található',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'imagemap_desc' => 'Permitte le mappas de imagines cliccabile al latere del cliente, usante le etiquetta <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Error: debe specificar un imagine in le prime linea',
	'imagemap_invalid_image' => 'Error: imagine es invalide o non existe',
	'imagemap_bad_image' => 'Error: le imagine es in le lista nigre de iste pagina',
	'imagemap_no_link' => 'Error: necun ligamine valide esseva trovate al fin del linea $1',
	'imagemap_invalid_title' => 'Error: titulo invalide in ligamine al linea $1',
	'imagemap_missing_coord' => 'Error: non bastante coordinatas pro le forma al linea $1',
	'imagemap_unrecognised_shape' => 'Error: forma non recognoscite al linea $1; cata linea debe comenciar con un del sequentes: default, rect, circle, poly',
	'imagemap_invalid_coord' => 'Error: coordinata invalide al linea $1, debe esser un numero',
	'imagemap_invalid_desc' => 'Error: specification "desc" invalide, debe esser un del sequentes: <code>$1</code>',
	'imagemap_description' => 'A proposito de iste imagine',
	'imagemap_poly_odd' => 'Error: se trova un polygono con un numero impar de coordinatas in linea $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'imagemap_desc' => 'Menyediakan peta gambar yang dapat diklik dari klien dengan menggunakan tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => '&lt;imagemap&gt;: harus memberikan suatu gambar di baris pertama',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: gambar tidak sah atau tidak ditemukan',
	'imagemap_bad_image' => 'Kesalahan: berkas tidak diperbolehkan pada halaman ini',
	'imagemap_no_link' => '&lt;imagemap&gt;: tidak ditemukan pranala yang sah di akhir baris ke $1',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: judul tidak sah pada pranala di baris ke $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: tidak cukup koordinat untuk bentuk pada baris ke $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: bentuk tak dikenali pada baris ke $1, tiap baris harus dimulai dengan salah satu dari: default, rect, circle atau poly',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: koordinat tidak sah pada baris ke $1, haruslah berupa angka',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: spesifikasi desc tidak sah, harus salah satu dari: $1',
	'imagemap_description' => 'Tentang gambar ini',
	'imagemap_poly_odd' => 'Kesalahan: terdapat poligon dengan nomor koordinat salah pada baris $1',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'imagemap_desc' => 'Palubusan ti kliente-a bangir nga agpabalin ti agtakla kadagiti imahen ti mapa nga agusar ti <code>&lt;imagemap&gt;</code> nga etiketa',
	'imagemap_no_image' => 'Biddut: masapul nga inaganan ti imahen iti umuna a linia',
	'imagemap_invalid_image' => 'Biddut: ti imahen ket imbalido wenn awan',
	'imagemap_bad_image' => 'Biddut: ti imahen ket naiparit iti daytoy a panid',
	'imagemap_no_link' => 'Biddut: awan ti nabirukan nga umisu a panilpo idiay lippasan ti linia $1',
	'imagemap_invalid_title' => 'Biddut: imbalido a titulo iti panilpo idiay linia $1',
	'imagemap_missing_coord' => 'Biddut: awan ti umanay a nagsasabtan para iti tabas idiay linia $1',
	'imagemap_unrecognised_shape' => 'Biddut: saan a malasing a tabas idiay linia $1, tunggal maysa a linia ket masapul a mangrugi iti maysa nga: kinasigud, rektanggilo, nagtimbukel wenno poly',
	'imagemap_invalid_coord' => 'Biddut: imbalido a nagsasabtan idiay linia $1, masapul a numero',
	'imagemap_invalid_desc' => 'Biddut: imbalido a nainaganan a panagipalpalawag, masapul a maysa iti: <code>$1</code>',
	'imagemap_description' => 'Maipanggep daytoy ngaimahen',
	'imagemap_poly_odd' => 'Biddut: nabirukan ti poly nga addaan ti pangis a numero iti nagsasabtan idiay linia $1',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'imagemap_description' => 'Pri ca imajo',
);

/** Icelandic (Íslenska) */
$messages['is'] = array(
	'imagemap_description' => 'Um þessa mynd',
);

/** Italian (Italiano)
 * @author Anyfile
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'imagemap_desc' => "Consente di realizzare ''image map'' cliccabili lato client con il tag <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => "Errore: si deve specificare un'immagine nella prima riga",
	'imagemap_invalid_image' => "&lt;imagemap&gt;: l'immagine non è valida o non esiste",
	'imagemap_bad_image' => "Errore: l'immagine si trova nella blacklist per questa pagina",
	'imagemap_no_link' => '&lt;imagemap&gt;: non è stato trovato alcun collegamento valido alla fine della riga $1',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: titolo del collegamento non valido nella riga $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: non ci sono abbastanza coordinate per la forma specificata nella riga $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: Forma (shape) non riconosciuta nella riga $1, ogni riga deve iniziare con uno dei seguenti: default, rect, circle o poly',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: coordinata non valida nella riga $1, deve essere un numero',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: Valore non valido per il parametro desc, deve essere uno dei seguenti: $1',
	'imagemap_description' => "Informazioni sull'immagine",
	'imagemap_poly_odd' => 'Errore: trovato poligono con un numero dispari di coordinate nella riga $1',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Kahusi
 * @author Mizusumashi
 */
$messages['ja'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code>タグによるクライアントサイドのクリッカブルマップ機能を有効にする',
	'imagemap_no_image' => 'エラー: 最初の行で画像を指定して下さい。',
	'imagemap_invalid_image' => 'エラー: 画像が無効であるか、存在しません。',
	'imagemap_bad_image' => 'エラー: このページでは画像が排除されています',
	'imagemap_no_link' => 'エラー: 有効なリンクが$1行目の最後に存在しません。',
	'imagemap_invalid_title' => 'エラー: $1行目のリンクのタイトルが無効です。',
	'imagemap_missing_coord' => 'エラー: $1行目にある図形の座標指定が不足しています。',
	'imagemap_unrecognised_shape' => 'エラー: $1行目の図形は認められません。各行は次のどれかで始まる必要があります: default, rect, circle, poly',
	'imagemap_invalid_coord' => 'エラー: $1行目の座標が無効です。数字を指定して下さい。',
	'imagemap_invalid_desc' => 'エラー: 無効なdescの指定です。次のどれかを指定して下さい: <code>$1</code>',
	'imagemap_description' => '画像の詳細',
	'imagemap_poly_odd' => 'エラー: $1行目に、奇数個の座標値が指定されたpolyがあります。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'imagemap_desc' => 'Nyedyakaké péta gambar sing bisa diklik saka klièn mawa nganggo tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Error: kudu mènèhi sawijining gambar ing baris kapisan',
	'imagemap_invalid_image' => 'Error: gambar ora absah utawa ora ditemokaké',
	'imagemap_bad_image' => 'Kasalahan: berkas ora diidinaké ing kaca iki',
	'imagemap_no_link' => 'Kasalahan: ora ditemokaké pranala sing absah ing pungkasan baris kaping $1',
	'imagemap_invalid_title' => 'Error: irah-irahan ora absah ing pranala ing baris kaping $1',
	'imagemap_missing_coord' => 'Error: ora cukup koordinat kanggo wujud ing baris kaping $1',
	'imagemap_unrecognised_shape' => 'Error: wujud ora ditepungi ing baris kaping $1, saben baris kudu diwiwiti mawa salah siji saka: default, rect, circle utawa poly',
	'imagemap_invalid_coord' => 'Error: koordinat ora absah ing baris kaping $1, kudu awujud angka',
	'imagemap_invalid_desc' => 'Error: spésifikasi desc ora absah, kudu salah siji saka: $1',
	'imagemap_description' => 'Prekara gambar iki',
	'imagemap_poly_odd' => 'Kasalahan: ana poligon kanthi nomer koordinat kliru ing larikan $1',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author ITshnik
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'imagemap_no_image' => 'შეცდომა: პირველ ხაზზე უნდა მიუთითოთ სურათი',
	'imagemap_invalid_image' => 'შეცდომა: სურათი მცდარია ან არ არსებობს',
	'imagemap_bad_image' => 'შეცდომა: სურათი შავ სიაშია ამ გვერდზე',
	'imagemap_no_link' => 'შეცდომა: არასწორი ბმული $1 ხაზის ბოლოს',
	'imagemap_invalid_title' => 'შეცდომა: არასწორი სათაური ბმულში ხაზზე $1',
	'imagemap_missing_coord' => 'შეცდომა: ხაზ $1 არ არის საკმარისი რაოდენობის კოორდინატები',
	'imagemap_unrecognised_shape' => 'შეცდომა: გაურკვეველი ფიგურა ხაზ $1-ში, ყველა ახალი ხაზი უნდა იწყებოდეს ერთ-ერთი ძირითადი სიტყვით: default, rect, circle ან  poly',
	'imagemap_invalid_coord' => 'შეცდომა:არასწორი კოორდინატი ხაზ $1-ში, მოლოდინშია ციფრი',
	'imagemap_invalid_desc' => 'შეცდომა: არასწორი მნიშვნელობა desc,  მოლოდინშია ერთ-ერთი მნიშვნელობა  <code>$1</code>.',
	'imagemap_description' => 'ამ სურათის შესახებ',
	'imagemap_poly_odd' => 'შეცდომა: $1 ხაზში არის შეცდომით აღწერილი მრავალკუთხედით ზედმეტი კორდინატებით.',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬)
 * @author AlefZet
 */
$messages['kk-arab'] = array(
	'imagemap_no_image' => '&lt;imagemap&gt;: بٸرٸنشٸ جولدا سۋرەتتٸ كٶرسەتۋ قاجەت',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: سۋرەت جارامسىز نەمەسە جوق',
	'imagemap_no_link' => '&lt;imagemap&gt;: $1 جول اياعىندا جارامدى سٸلتەمە تابىلمادى',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: $1 جول اياعىنداعى سٸلتەمەدە جارامسىز اتاۋ',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: $1 جولداعى كەسكٸن ٷشٸن كوورديناتتار جەتٸكسٸز',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: $1 جولداعى كەسكٸن جارامسىز, ٵربٸر جول مىنانىڭ بٸرەۋٸنەن باستالۋ قاجەت:',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: $1 جولىندا جارامسىز كوورديناتا, سان بولۋى قاجەت',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: جارامسىز سيپاتتاما ماماندانىمى, مىنانىڭ بٸرەۋٸ بولۋى قاجەت: $1',
	'imagemap_description' => 'بۇل سۋرەت تۋرالى',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬)
 * @author AlefZet
 */
$messages['kk-cyrl'] = array(
	'imagemap_no_image' => '&lt;imagemap&gt;: бірінші жолда суретті көрсету қажет',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: сурет жарамсыз немесе жоқ',
	'imagemap_no_link' => '&lt;imagemap&gt;: $1 жол аяғында жарамды сілтеме табылмады',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: $1 жол аяғындағы сілтемеде жарамсыз атау',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: $1 жолдағы кескін үшін координаттар жетіксіз',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: $1 жолдағы кескін жарамсыз, әрбір жол мынаның біреуінен басталу қажет:',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: $1 жолында жарамсыз координата, сан болуы қажет',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: жарамсыз сипаттама маманданымы, мынаның біреуі болуы қажет: $1',
	'imagemap_description' => 'Бұл сурет туралы',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬)
 * @author AlefZet
 */
$messages['kk-latn'] = array(
	'imagemap_no_image' => '&lt;imagemap&gt;: birinşi jolda swretti körsetw qajet',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: swret jaramsız nemese joq',
	'imagemap_no_link' => '&lt;imagemap&gt;: $1 jol ayağında jaramdı silteme tabılmadı',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: $1 jol ayağındağı siltemede jaramsız ataw',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: $1 joldağı keskin üşin koordïnattar jetiksiz',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: $1 joldağı keskin jaramsız, ärbir jol mınanıñ birewinen bastalw qajet:',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: $1 jolında jaramsız koordïnata, san bolwı qajet',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: jaramsız sïpattama mamandanımı, mınanıñ birewi bolwı qajet: $1',
	'imagemap_description' => 'Bul swret twralı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'imagemap_no_image' => 'កំហុស៖ ត្រូវបញ្ជាក់​រូបភាពមួយនៅក្នុង​បន្ទាត់ទីមួយ​',
	'imagemap_invalid_image' => 'កំហុស៖ រូបភាព​មិនត្រឹមត្រូវ ឬមិនមាន​',
	'imagemap_bad_image' => 'កំហុស៖ រូបភាពត្រូវបានហាមឃាត់ក្នុងបញ្ជី​ខ្មៅ​ លើ​ទំព័រនេះ​',
	'imagemap_invalid_title' => 'កំហុស:ចំណងជើងមិនត្រឹមត្រូវក្នុងតំណភ្ជាប់នៅបន្ទាត់ទី$1',
	'imagemap_description' => 'អំពីរូបភាពនេះ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'imagemap_desc' => '사용자가 이미지맵을 사용할 수 있도록 <code>&lt;imagemap&gt;</code> 태그를 추가',
	'imagemap_no_image' => '오류: 첫 줄에 그림이 제시되어야 합니다.',
	'imagemap_invalid_image' => '오류: 그림이 잘못되었거나 존재하지 않습니다.',
	'imagemap_bad_image' => '오류: 이 그림은 이 문서에서 사용이 금지되어 있습니다.',
	'imagemap_no_link' => '오류: $1번째 줄에서 유효한 링크를 찾을 수 없습니다',
	'imagemap_invalid_title' => '오류: $1번째 줄의 링크 제목이 잘못되었습니다',
	'imagemap_missing_coord' => '오류: $1줄에 정의된 도형의 좌표 값이 충분하지 않습니다.',
	'imagemap_unrecognised_shape' => '오류: $1줄에서 도형을 인식할 수 없음, 각 줄은 다음으로 시작해야 합니다: default, rect, circle, poly',
	'imagemap_invalid_coord' => '오류: $1번째 줄에서 좌표가 잘못되었습니다. 좌표는 반드시 숫자여야 합니다.',
	'imagemap_invalid_desc' => '오류: 질못된 desc 설정. 다음 중 하나가 되어야 함: <code>$1</code>',
	'imagemap_description' => '이 그림에 대한 정보',
	'imagemap_poly_odd' => '오류: $1번째 줄에 정의된 좌표 값의 수가 홀수 개입니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'imagemap_desc' => 'Brengk dä Befäähl <code>&lt;imagemap&gt;</code> en et Wiki, un med em Belldsche, wo mer op Anndeile fun klecke kann, wo dann Lengks henger lijje.',
	'imagemap_no_image' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: En de eetzte Reih mööt e Beld shtonn.',
	'imagemap_invalid_image' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: dat Beld jidd_et nit, odder dä Name es verkeeht',
	'imagemap_bad_image' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: Dat Beld es op dä Sigg nit äloup.',
	'imagemap_no_link' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: En de {{PLURAL:$1|eetzte|$1-te|nullte}} Reih eß am Engk keine Lengk jefonge woode.',
	'imagemap_invalid_title' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: Dä Tittel em Lengk en de {{PLURAL:$1|eetzte|$1-te|nullte}} Reih eß verkeeht.',
	'imagemap_missing_coord' => "Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: En dä {{PLURAL:$1|eetzte|$1-te|nullte}} Reih sin nit jenooch Ko'oddinate förr_ene komplätte Ömreß.",
	'imagemap_unrecognised_shape' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: Dä Name förr_enne Ömreß en de {{PLURAL:$1|eetzte|$1-te|nullte}} Reih eß verkeeht. Et mööt „<tt>rect</tt>“, „<tt>circle</tt>“, „<tt>poly</tt>“, udder „<tt>default</tt>“ do shtonn.',
	'imagemap_invalid_coord' => "Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: En de {{PLURAL:$1|eetzte|$1-te|nullte}} Reih eß jet verkeeht met de Ko'oddinate. Do mööte luuter Zahle shtonn, es äver nit esu.",
	'imagemap_invalid_desc' => 'Do es ene Fääler met <code>&lt;imagemap&gt;</code> opjefalle: Dä Parammeeter „<tt><nowiki>desc</nowiki></tt>“ eß verkeeht aanjejovve. Bruche kanns De nor ein fun dänne hee: <code>$1</code>',
	'imagemap_description' => 'Övver dat Beld hee',
	'imagemap_desc_types' => 'bovve räähß, unge räähß, unge lengkß, bovve lengkß, nix',
	'imagemap_poly_odd' => 'Do es ene Fääler met <imagemap> opjefalle: De Parammeeter för „poly“ möße Zahle-Päärche sin, ävver hee es ei Zahl zovill udder zowinnisch
en dä Reih: $1.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'imagemap_description' => 'Derbarê vî wêneyî de',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'imagemap_description' => 'De hac imagine',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'imagemap_desc' => 'Erlaabt et Biller ze benotzen déi een uklicke ka mat Hëllef vum Tag <code>&lt;imagemap&gt;</code>.',
	'imagemap_no_image' => 'Feeler: Dir musst an der éischter Linn e Bild uginn',
	'imagemap_invalid_image' => "Feeler: d'Bild ass ongëltig oder net do",
	'imagemap_bad_image' => "Feeler: D'Bild steet op der Lëscht vun den onerwënschte Biller",
	'imagemap_no_link' => 'Feeler: Um Enn vun der Zeil $1 gouf kee gëltege Link fonnt',
	'imagemap_invalid_title' => 'Feeler: ongëltigen Titel am Link an der Zeil $1',
	'imagemap_missing_coord' => 'Feeler: Ze wéineg Koordinaten an der Zeil $1 fir den Ëmress',
	'imagemap_unrecognised_shape' => 'Feeler: Onbekannte Form an der Zeil $1. All Zeile muss matt engem vun dëse Parameter ufänken: <tt>default, rect, circle</tt> oder <tt>poly</tt>',
	'imagemap_invalid_coord' => 'Feeler: Ongëlteg Koordinaten an der Zeil $1: et sinn nëmmen Zuelen erlaabt',
	'imagemap_invalid_desc' => 'Feeler: Ongëltegen „desc“-Parameter, méiglech sinn: <code>$1</code>',
	'imagemap_description' => 'Iwwert dëst Bild',
	'imagemap_desc_types' => 'uewe-riets, ënne-riets, ënne-lénks, uewe-lénks, keen',
	'imagemap_poly_odd' => 'Feeler: e Polygon mat enger ongerueder Zuel vu Koordinate gouf an der Linn $1 fonnt',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'imagemap_desc' => 'Maakt aanklikbare imagemaps meugelijk met de tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => "Error: geef 'n afbeelding op in de eerste regel",
	'imagemap_invalid_image' => 'Error: de afbeelding is corrupt of bestaat neet',
	'imagemap_bad_image' => 'Fout: de afbeelding steit op de zwarte lies voor deze pagina',
	'imagemap_no_link' => 'Error: er is geen geldige link aangetroffen aan het einde van regel $1',
	'imagemap_invalid_title' => 'Error: er staat een ongeldige titel in de verwijzing op regel $1',
	'imagemap_missing_coord' => 'Error: neet genoeg coördinaten veur vorm in regel $1',
	'imagemap_unrecognised_shape' => "Error: neet herkende vorm in regel $1, iedere regel mot beginne met éin van de commando's: default, rect, circle of poly",
	'imagemap_invalid_coord' => 'Error: ongeldige coördinaten in regel $1, moet een getal zien',
	'imagemap_invalid_desc' => 'Error: ongeldige beschrijvingsspecificatie, dit moet er één zijn uit de volgende lijst: $1',
	'imagemap_description' => 'Euver deze aafbeelding',
	'imagemap_poly_odd' => 'Fout: polygoon gevonje met een oneven aantal coördinate op regel $1',
);

/** Lithuanian (Lietuvių)
 * @author Garas
 * @author Matasg
 */
$messages['lt'] = array(
	'imagemap_no_image' => 'Error: privalote nurodyti paveikslėlį pirmoje linijoje',
	'imagemap_invalid_image' => 'Error: blogas arba neegzistuojantis paveikslėlis',
	'imagemap_no_link' => 'Error: nerasta tinkama nuoroda eilutės $1 pabaigoje',
	'imagemap_invalid_title' => 'Error: blogas pavadinimas nuorodoje $1 eilutėje',
	'imagemap_missing_coord' => 'Error: nėra pakankamai koordinačių figūrai $1 eilutėje',
	'imagemap_unrecognised_shape' => 'Error: neatpažįstama figūra $1 eilutėje, kiekviena eilutė privalo prasidėti su vienu iš šių žodžių: default, rect, circle arba poly',
	'imagemap_invalid_coord' => 'Error: netinkama koordinatė $1 eilutėje, privalo būti skaičius',
	'imagemap_invalid_desc' => 'Error: bloga aprašymo specifikacija, privalo būti viena iš: <code>$1</code>',
	'imagemap_description' => 'Apie šį paveikslėlį',
);

/** Latvian (Latviešu)
 * @author Xil
 */
$messages['lv'] = array(
	'imagemap_no_image' => 'Kļūda: pirmajā rindiņā jānorāda attēls',
	'imagemap_invalid_image' => 'Kļūda: attēls nav derīgs vai nepastāv',
	'imagemap_no_link' => 'Kļūda: rindiņas $1 beigās netika atrasta derīga saite',
	'imagemap_description' => 'Par šo attēlu',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'imagemap_desc' => 'Дава картографски слики кои можат да се кликаат од клиентот користејќи ја ознаката <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Грешка: мора да се назначи слика во првиот ред',
	'imagemap_invalid_image' => 'Грешка: сликата е неважечка или не постои',
	'imagemap_bad_image' => 'Грешка: сликата е на црн список за оваа страница',
	'imagemap_no_link' => 'Грешка: не беше пронајдена важечка врска на крајот на редот $1',
	'imagemap_invalid_title' => 'Грешка: погрешен наслов во врската на ред $1',
	'imagemap_missing_coord' => 'Грешка: нема доволно координати за обликот на ред $1',
	'imagemap_unrecognised_shape' => 'Грешка: непризнат ред $1, секој ред мора да почне со едно од: default, rect, circle или poly',
	'imagemap_invalid_coord' => 'Грешка: погрешни координати на ред $1, мора да биде со бројки',
	'imagemap_invalid_desc' => 'Грешка: неважечко напатствие за опис, мора да биде едно од: <code>$1</code>',
	'imagemap_description' => 'За сликава',
	'imagemap_desc_types' => 'најгоре-десно, најдолу-десно, најдолу-лево, најгоре-лево, нема',
	'imagemap_poly_odd' => 'Грешка: пронајден е многуаголник (poly) со непарен број на координати во ред $1',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'imagemap_desc' => 'സ്വീകർത്താവിന് ചിത്രത്തിലെ അടയാളപ്പെടുത്തലുകളിൽ ഞെക്കി ഗമിക്കാവുന്ന സൗകര്യം <code>&lt;imagemap&gt;</code> റ്റാഗ് ഉപയോഗിച്ച് സാദ്ധ്യമാക്കുന്നു',
	'imagemap_no_image' => 'പിഴവ്: ഒന്നാമത്തെ വരിയിൽ ഒരു ചിത്രത്തിന്റെ പേരു വേണം',
	'imagemap_invalid_image' => 'പിഴവ്: ചിത്രം അസാധുവാണ്‌ അല്ലെങ്കിൽ നിലവിലില്ല',
	'imagemap_bad_image' => 'പിഴവ്: ഈ താളിൽ ചിത്രം കരിമ്പട്ടികയിലാണ്',
	'imagemap_no_link' => 'പിഴവ്: വരി $1-ന്റെ അവസാനം സാധുവായ കണ്ണി കാണുന്നില്ല',
	'imagemap_invalid_title' => 'പിഴവ്: വരി $1-ൽ അസാധുവായ തലക്കെട്ട്',
	'imagemap_missing_coord' => 'പിഴവ്: വരി $1-ൽ രൂപത്തിന് ആവശ്യമുള്ളത്ര നിർദ്ദേശാങ്കങ്ങൾ നിർവചിച്ചിട്ടില്ല.',
	'imagemap_unrecognised_shape' => 'പിഴവ്: വരി $1-ൽ മനസ്സിലാക്കാൻ പറ്റാത്ത രൂപം. ഓരോ വരിയും ഇനി പറയുന്ന ഒന്നു കൊണ്ടു വേണം തുടങ്ങാൻ: default, rect, circle അഥവാ poly',
	'imagemap_invalid_coord' => 'പിഴവ്: വരി $1-ൽ അസാധുവായ നിർദ്ദേശാങ്കം. നിർബന്ധമായും അത് ഒരു സംഖ്യയായിരിക്കണം.',
	'imagemap_invalid_desc' => 'പിഴവ്: അസാധുവായ വിവരണ നിർദ്ദേശം. ഇനി പറയുന്ന ഇനങ്ങളിൽ ഒന്നായിരിക്കണം: <code>$1</code>',
	'imagemap_description' => 'ഈ ചിത്രത്തെ കുറിച്ച്',
	'imagemap_poly_odd' => 'പിഴവ്: വിവിധ ഒറ്റയായുള്ള സംഖ്യകൾ ഉപയോഗിച്ചുള്ള നിർദ്ദേശാങ്കങ്ങൾ വരി $1-ൽ കണ്ടെത്തി',
);

/** Marathi (मराठी)
 * @author Kaajawa
 * @author Kaustubh
 * @author Rahuldeshmukh101
 */
$messages['mr'] = array(
	'imagemap_desc' => 'क्लायंटकडील चित्रनकाशे <code>&lt;imagemap&gt;</code> टॅग देऊन वापरता येऊ शकतात.',
	'imagemap_no_image' => 'Error: पहिल्या ओळीत चित्र देणे गरजेचे आहे',
	'imagemap_invalid_image' => 'Error: चुकीचे अथवा अस्तित्वात नसलेले चित्र',
	'imagemap_bad_image' => 'त्रूटी: ह्या पानावरील  चित्र काळ्या यादीत टाकले  आहे',
	'imagemap_no_link' => 'Error: $1 ओळीच्या शेवटी योग्य दुवा सापडलेला नाही',
	'imagemap_invalid_title' => 'Error: $1 ओळीतील दुव्याचे चुकीचे शीर्षक',
	'imagemap_missing_coord' => 'Error: $1 ओळीवरील आकारासाठी पुरेसे कोऑर्डिनेट्स नाहीत',
	'imagemap_unrecognised_shape' => 'Error: $1 ओळीमध्ये चुकीचा आकार, प्रत्येक ओळ ही: default, rect, circle अथवा poly पासून सुरु व्हायला पाहिजे.',
	'imagemap_invalid_coord' => 'Error:  $1 ओळीवर चुकीचे कोऑर्डिनेट्स, संख्या हवी',
	'imagemap_invalid_desc' => 'Error: चुकीची माहिती, यापैकी एक असायला हवी: <code>$1</code>',
	'imagemap_description' => 'या चित्राबद्दल माहिती',
	'imagemap_poly_odd' => 'त्रुटी: रेष क्र. $1 मधे विषम संख्येचे गुणक असलेला बहुभुजक आकार सापडला',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'imagemap_desc' => 'Membenarkan peta imej boleh klik menggunakan tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Ralat: sila nyatakan imej dalam baris pertama',
	'imagemap_invalid_image' => 'Imej: imej tidak sah atau tidak wujud',
	'imagemap_bad_image' => 'Ralat: imej disenaraihitamkan di laman ini',
	'imagemap_no_link' => 'Ralat: tiada pautan sah dijumpai pada akhir baris $1',
	'imagemap_invalid_title' => 'Ralat: tajuk tidak sah dalam pautan pada baris $1',
	'imagemap_missing_coord' => 'Ralat: koordinat bagi bentuk tidak cukup pada baris $1',
	'imagemap_unrecognised_shape' => 'Ralat: bentuk tidak dikenali pada baris $1, setiap baris hendaklah dimulakan dengan salah satu daripada: default, rect, circle atau poly',
	'imagemap_invalid_coord' => 'Ralat: koordinat tidak sah pada baris $1, hanya nombor dibenarkan',
	'imagemap_invalid_desc' => 'Ralat: spesifikasi keterangan tidak sah, hendaklah salah satu daripada: <code>$1</code>',
	'imagemap_description' => 'Perihal imej ini',
	'imagemap_desc_types' => 'atas-kanan, bawah-kanan, bawah-kiri, atas-kiri, tiada',
	'imagemap_poly_odd' => 'Ralat: terdapat poligon dengan bilangan koordinat yang ganjil dalam baris $1',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'imagemap_description' => 'Те артовкстонть',
);

/** Norwegian Bokmål (‪Norsk (bokmål)‬) */
$messages['nb'] = array(
	'imagemap_desc' => 'Gjør at man kan bruke klikkbare bilder ved hjelp av <code>&lt;imagemap&gt;</code>.',
	'imagemap_no_image' => 'Error: må angi et bilde i første linje',
	'imagemap_invalid_image' => 'Error: bilde er ugyldig eller ikke-eksisterende',
	'imagemap_bad_image' => 'Feil: bildet er svartelistet på denne siden',
	'imagemap_no_link' => 'Error: ingen gyldig lenke ble funnet i slutten av linje $1',
	'imagemap_invalid_title' => 'Error: ugyldig tittel i lenke på linje $1',
	'imagemap_missing_coord' => 'Error: ikke nok koordinater for form på linje $1',
	'imagemap_unrecognised_shape' => 'Error: ugjenkjennelig form på linje $1; hver linje må starte med enten: default, rect, circle eller poly',
	'imagemap_invalid_coord' => 'Error: ugyldig koordinat i slutten av linje $1, må være et tall',
	'imagemap_invalid_desc' => 'Error: ugyldig desc-spesifisering, må være enten: <code>$1</code>',
	'imagemap_description' => 'Om dette bildet',
	'imagemap_poly_odd' => 'Feil: fant poly med et oddetall koordinater på rad $1',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'imagemap_desc' => 'Verlöövt dat Instellen vun Lenken op Biller över den Tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Error: in de eerste Reeg mutt en Bild angeven wesen',
	'imagemap_invalid_image' => 'Error: Bild geiht nich oder dat gifft dat gornich',
	'imagemap_bad_image' => 'Fehler: Dat Bild steiht op de swarte List för disse Sied',
	'imagemap_no_link' => 'Error: an dat Enn vun Reeg $1 weer keen Lenk',
	'imagemap_invalid_title' => 'Error: in Reeg $1 is de Titel in’n Lenk nich bi de Reeg',
	'imagemap_missing_coord' => 'Error: Form in Reeg $1 hett nich noog Koordinaten',
	'imagemap_unrecognised_shape' => "Error: Form in Reeg $1 nich kennt, jede Reeg mutt mit ''default'', ''rect'', ''circle'' oder ''poly'' anfangen",
	'imagemap_invalid_coord' => 'Error: Koordinaat in Reeg $1 nich bi de Reeg, mutt en Tall wesen',
	'imagemap_invalid_desc' => 'Error: Beschrieven nich bi de Reeg, mutt een vun disse wesen: <code>$1</code>',
	'imagemap_description' => 'Över dit Bild',
	'imagemap_poly_odd' => 'Fehler: Polygon mit unevene Tall Koordinaten in Reeg $1',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'imagemap_no_image' => 'Fout: geef n aofbeelding op in de eerste regel',
	'imagemap_invalid_image' => 'Fout: aofbeelding is ongeldig of besteet niet',
	'imagemap_no_link' => 'Fout: der is gien geldige verwiezing evunnen an t einde van regel $1',
	'imagemap_invalid_title' => 'Fout: ongeldige titel in de verwiezing op regel $1',
	'imagemap_missing_coord' => 'Fout: niet genog koördinaoten veur vorm op regel $1',
	'imagemap_unrecognised_shape' => 'Fout: onherkenbaore vorm op regel $1, elke regel mut beginnen mit één van de volgende vormen: standard, dreehoek, sirkel of n veulhoek',
	'imagemap_invalid_coord' => 'Fout: ongeldige koördinaot in regel $1, mut n getal ween',
	'imagemap_invalid_desc' => 'Fout: ongeldige beschrievingsspesifikasie, mut n van: <code>$1</code> ween',
	'imagemap_description' => 'Over disse aofbeelding',
);

/** Nepali (नेपाली) */
$messages['ne'] = array(
	'imagemap_description' => 'यो चित्रको बारेमा',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'imagemap_desc' => 'Maakt aanklikbare imagemaps mogelijk met de tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => '&lt;imagemap&gt;: geef een afbeelding op in de eerste regel',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: de afbeelding is corrupt of bestaat niet',
	'imagemap_bad_image' => 'Fout: de afbeelding staat op de zwarte lijst voor deze pagina',
	'imagemap_no_link' => '&lt;imagemap&gt;: er is geen geldige verwijzing aangetroffen aan het einde van regel $1',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: er staat een ongeldige titel in de verwijzing op regel $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: niet genoeg coördinaten voor vorm in regel $1',
	'imagemap_unrecognised_shape' => "&lt;imagemap&gt;: niet herkende vorm in regel $1, iedere regel moet beginnen met één van de commando's: default, rect, circle of poly",
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: ongeldige coördinaten in regel $1, moet een getal zijn',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: ongeldige beschrijvingsspecificatie, dit moet er één zijn uit de volgende lijst: $1',
	'imagemap_description' => 'Over deze afbeelding',
	'imagemap_poly_odd' => 'Fout: polygoon gevonden met een oneven aantal coördinaten op regel $1',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 */
$messages['nn'] = array(
	'imagemap_desc' => 'Gjer at ein kan nytte klikkbare bilete ved hjelp av <code>&lt;imagemap&gt;</code>.',
	'imagemap_no_image' => 'Feil: må gje eit bilete i første linja',
	'imagemap_invalid_image' => 'Fil: biletet er ugyldig eller eksisterer ikkje',
	'imagemap_bad_image' => 'Feil: biletet er svartelista på denne sida',
	'imagemap_no_link' => 'Feil: fann ingen gyldig lenke i slutten av linje $1',
	'imagemap_invalid_title' => 'Feil: ugyldig tittel i lenke på linje $1',
	'imagemap_missing_coord' => 'Feil: ikkje nok koordinatar for form på linje $1',
	'imagemap_unrecognised_shape' => 'Feil: ukjend form på linje $1; kvar linje må starte med anten: default, rect, circle eller poly',
	'imagemap_invalid_coord' => 'Feil: ugyldig koordinat i slutten av linje $1, må vere eit tal',
	'imagemap_invalid_desc' => 'Feil: ugyldig desc-spesifisering, må vere ein av: <code>$1</code>',
	'imagemap_description' => 'Om dette bilete',
	'imagemap_poly_odd' => 'Feil: fann poly med eit oddetal koordinatar på rad $1',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'imagemap_desc' => "Permet qu'una mapa imatge clienta siá clicabla en utilizant la balisa <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => 'Error : vos cal especificar un imatge dins la primièra linha',
	'imagemap_invalid_image' => 'Error : l’imatge es invalid o existís pas',
	'imagemap_bad_image' => 'Error : l’imatge es sus la tièra negra sus aquesta pagina',
	'imagemap_no_link' => 'Error : cap de ligam valid es pas estat trobat a la fin de la linha $1',
	'imagemap_invalid_title' => 'Error : títol invalid dins lo ligam a la linha $1',
	'imagemap_missing_coord' => 'Error : pas pro de coordenadas per la forma a la linha $1',
	'imagemap_unrecognised_shape' => 'Error : forma pas reconeguda a la linha $1, cada linha deu començar amb un dels mots seguents : default, rect, circle o poly',
	'imagemap_invalid_coord' => 'Error : coordenada invalida a la linha $1, deu èsser un nombre',
	'imagemap_invalid_desc' => 'Error : paramètre « desc » invalid, los paramètres possibles son : $1',
	'imagemap_description' => "A prepaus d'aqueste imatge",
	'imagemap_poly_odd' => 'Error : trobat un poligòn amb un nombre impar de coordenadas a la linha $1',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code> ଚିହ୍ନ ବ୍ୟବହାର କରି କ୍ଲାଏଣ୍ଟ ଭାଗର କ୍ଲିକ କଲାଭଳି ଛବିର ମାନଚିତ୍ର ତିଆରି କରିଥାଏ ।',
	'imagemap_no_image' => 'ଭୁଲ: ପ୍ରଥମ ଧାଡ଼ିରେ ଏକ ଛବି ଉଲ୍ଲେଖ କରିବା ଜରୁରୀ',
	'imagemap_invalid_image' => 'ଭୁଲ: ଛବିଟି ଅବୈଧ ବା ନାହିଁ',
	'imagemap_bad_image' => 'ଭୁଲ: ଏହି ପୃଷ୍ଠାରେ ଛବିଟି ବାସନ୍ଦ କରାଯାଇଅଛି',
	'imagemap_no_link' => 'ଭୁଲ:$1 ଧାଡ଼ିର ଶେଷରେ କୌଣସିଟି ବୈଧ ଲିଙ୍କ ଦିଆଯାଇନାହିଁ',
	'imagemap_invalid_title' => 'ଭୁଲ:$1ତମ ଧାଡ଼ିରେ ଭୁଲ ନାମଟିଏ ଦିଆଯାଇଅଛି',
	'imagemap_missing_coord' => 'ଭୁଲ: ଆକୃତି ପାଇଁ $1 ଧାଡ଼ିରେ ସେତେ ଅଧିକ ଦିଗବରେଣି ନାହିଁ',
	'imagemap_unrecognised_shape' => 'ଭୁଲ: $1ମ ଧାଡ଼ିରେ ଅଚିହ୍ନା ଆକୃତି, ସବୁଯାକ ଧାଡ଼ି ଏହି ସବୁ ନାମରୁ ଆରମ୍ଭ ହେବ ଉଚିତ: ଆପେଆପେ, ଆୟତକ୍ଷେତ୍ର, ବୃତ୍ତ ବ ବହୁଭୂଜ',
	'imagemap_invalid_coord' => 'ଭୁଲ: $1 ଧାଡ଼ିରେ ଥିବା ଅବୈଧ ଦିଗବାରେଣି, ସଂଖ୍ୟାଟିଏ ନିହାତି ହୋଇପାରେ',
	'imagemap_invalid_desc' => 'ଭୁଲ: ଅବୈଧ ବଖାଣ ନିର୍ଦିଷ୍ଟତା, ଏହି ସବୁ ଭିତରୁ ଗୋଟିଏ ହୋଇପାରେ: <code>$1</code>',
	'imagemap_description' => 'ଏହି ଛବି ବାବଦରେ',
	'imagemap_poly_odd' => 'ଭୁଲ: $1 ତମ ଧାଡ଼ିରେ ଏକ ବିସମ କୋଣଥିବା ବହୁଭୂଜ ପାଇଲୁଁ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'imagemap_description' => 'Ацы нывы тыххæй',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'imagemap_description' => 'Iwwer sell Pikder',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'imagemap_desc' => 'Umożliwia utworzenie obrazka zawierającego klikalną mapę, z użyciem znacznika <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Błąd – należy wpisać grafikę w pierwszej linii',
	'imagemap_invalid_image' => 'Błąd – grafika jest niepoprawna lub nie istnieje',
	'imagemap_bad_image' => 'Błąd – ta grafika jest zakazana w tym serwisie',
	'imagemap_no_link' => 'Błąd – nie znaleziono poprawnego linku na końcu linii $1',
	'imagemap_invalid_title' => 'Błąd – niepoprawny tytuł linku w linii $1',
	'imagemap_missing_coord' => 'Błąd – niewystarczająca liczba współrzędnych dla kształtu zdefiniowanego w linii $1',
	'imagemap_unrecognised_shape' => 'Błąd – nierozpoznany kształt w linii $1; każda linia musi zawierać tekst: default, rect, circle lub poly',
	'imagemap_invalid_coord' => 'Błąd – nieprawidłowa współrzędna w linii $1; należy podać liczbę',
	'imagemap_invalid_desc' => 'Błąd – nieprawidłowa specyfikacja opisu; należy wpisać jeden z wariantów: <code>$1</code>',
	'imagemap_description' => 'Informacje o tej grafice',
	'imagemap_poly_odd' => 'Błąd – w linii $1 znaleziono wielokąt z nieparzystą liczbą współrzędnych',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'imagemap_desc' => 'A përmëtt "image map" client-side clicàbij an dovrand ël tag <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => "Error: ant la prima riga a venta ch'a-i sia la specìfica ëd na figura",
	'imagemap_invalid_image' => "Error: la figura ò ch'a l'ha chèich-còs ch'a va nen, ò ch'a-i é nen d'autut",
	'imagemap_bad_image' => "Eror: la figura a l'é ant la blacklist ëd costa pàgina",
	'imagemap_no_link' => 'Error: pa gnun-a anliura bon-a a la fin dla riga $1',
	'imagemap_invalid_title' => "Error: tìtol nen bon ant l'anliura dla riga $1",
	'imagemap_missing_coord' => 'Error: pa basta ëd coordinà për fé na forma a la riga $1',
	'imagemap_unrecognised_shape' => 'Error: forma nen arconossùa a la riga $1, minca riga a la dev anandiesse con un ëd: default, rect, circle ò poly',
	'imagemap_invalid_coord' => "Error: coordinà nen bon-a a la riga $1, a l'ha da esse un nùmer",
	'imagemap_invalid_desc' => "Error: specìfica dla descrission nen bon-a, a l'ha da esse un-a ëd coste-sì: <code>$1</code>",
	'imagemap_description' => 'Rësgoard a sta figura-sì',
	'imagemap_poly_odd' => 'Eror: trovà un polìgon con un nùmer dìspar ëd coordinà an sla linia $1',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'imagemap_desc' => 'اجازت دیندا اے کلائینٹ سائیڈ کلکایبل امیج نقشے <code>&lt;imagemap&gt;</code> ٹیگ ورتدیاں ہویاں۔',
	'imagemap_no_image' => 'غلطی: پہلی لائن چ مورت بارے دسو',
	'imagemap_invalid_image' => 'مسئلہ: اے فوٹو غلط اے یا نئیں ہیگی',
	'imagemap_bad_image' => 'مسئلہ: فوٹو اس صفے واسطے بلیک لسٹ اے',
	'imagemap_no_link' => 'مسئلہ: $1 دی لائن دے انت تے کوئی ٹردا جوڑ نئیں',
	'imagemap_invalid_title' => 'مسئلہ:  $1 لائن دے جوڑ تے غلط ناں اے',
	'imagemap_missing_coord' => 'غلطی: کافی کووارڈینیٹ لکیر $1 تے مورت لئی نئیں دتے گۓ۔',
	'imagemap_unrecognised_shape' => 'غلطی:لکیر $1 تے مورت نئیں پچھانی جاندی، ہر لکیر ایناں چوں کسے نال شروع ہووے: ڈیفالٹ، ریکٹ، چکر، یا پولی',
	'imagemap_invalid_coord' => 'غلطی: ناں منے جان والے کووارڈینیٹ لکیر $1، لازمی اک نمبر ہووے۔',
	'imagemap_invalid_desc' => 'غلطی: ناں منی جان والی ڈیسک سپیسیفیکیشن، لازمی ایناں چوں ہووے: <کوڈ>$1</کوڈ>',
	'imagemap_description' => 'ایس مورت بارے',
	'imagemap_poly_odd' => 'غلطی: لکیر $1 تے پولی لبی وکھے نمبراں دے کوورڈینیٹ نال',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'imagemap_description' => 'ددې انځور په اړه',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'imagemap_desc' => 'Permite mapas de imagem clicáveis no lado do cliente usando a "tag" <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Erro: é necessário especificar uma imagem na primeira linha',
	'imagemap_invalid_image' => 'Erro: imagem inválida ou inexistente',
	'imagemap_bad_image' => 'Erro: a imagem está na lista negra para esta página',
	'imagemap_no_link' => 'Erro: não foi encontrada nenhum link válido, ao final da linha $1',
	'imagemap_invalid_title' => 'Erro: título inválido num link, na linha $1',
	'imagemap_missing_coord' => 'Erro: coordenadas insuficientes para formar uma figura, na linha $1',
	'imagemap_unrecognised_shape' => 'Erro: figura não reconhecida, na linha $1 - cada linha tem de começar por: default, rect, circle ou poly',
	'imagemap_invalid_coord' => 'Erro: coordenada inválida, na linha $1 - tem de ser um número',
	'imagemap_invalid_desc' => 'Erro: especificação desc inválida - tem de ser uma destas: <code>$1</code>',
	'imagemap_description' => 'Sobre esta imagem',
	'imagemap_poly_odd' => 'Erro: encontrado polígono com número ímpar de coordenadas na linha $1',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Carla404
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'imagemap_desc' => 'Permite mapas de imagem clicáveis no lado do cliente usando a marca <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Erro: deve ser especificada uma imagem na primeira linha',
	'imagemap_invalid_image' => 'Erro: imagem inválida ou inexistente',
	'imagemap_bad_image' => 'Erro: a imagem está na lista negra para esta página',
	'imagemap_no_link' => 'Erro: não foi encontrada uma ligação válida ao final da linha $1',
	'imagemap_invalid_title' => 'Erro: título inválido na ligação da linha $1',
	'imagemap_missing_coord' => 'Erro: coordenadas insuficientes para formar uma figura na linha $1',
	'imagemap_unrecognised_shape' => 'Erro: figura não reconhecida na linha $1. Cada linha precisa iniciar com: default, rect, circle ou poly',
	'imagemap_invalid_coord' => 'Erro: coordenada inválida na linha $1, é necessário que seja um número',
	'imagemap_invalid_desc' => 'Erro: especificação desc inválida, é necessário que seja uma dentre: <code>$1</code>',
	'imagemap_description' => 'Sobre esta imagem',
	'imagemap_desc_types' => 'superior-direito, inferior-direito, inferior-esquerdo, superior-esquerdo, nenhum',
	'imagemap_poly_odd' => 'Erro: encontrado polígono com número ímpar de coordenadas na linha $1',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'imagemap_description' => 'Kay rikchamanta',
);

/** Romanian (Română)
 * @author Cin
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 */
$messages['ro'] = array(
	'imagemap_desc' => 'Permite realizarea unei imagini hartă, cu ajutorul etichetei <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Eroare: trebuie specificată o imagine pe prima linie',
	'imagemap_invalid_image' => 'Eroare: imaginea este incorectă sau nu există',
	'imagemap_bad_image' => 'Eroare: imaginea este pe o listă neagră pentru această pagină',
	'imagemap_no_link' => 'Eroare: nu a fost găsită nici o legătură validă la sfârșitul liniei $1',
	'imagemap_invalid_title' => 'Eroare: titlu invalid în legătură în linia $1',
	'imagemap_missing_coord' => 'Eroare: coordonate insuficiente pentru forma de la linia $1',
	'imagemap_unrecognised_shape' => 'Eroare: formă nerecunoscută în linia $1, fiecare linie trebuie să înceapă cu unul din parametrii: default, rect, circle or poly',
	'imagemap_invalid_coord' => 'Eroare: coordonată incorectă la linia $1, trebuie să fie număr',
	'imagemap_invalid_desc' => 'Eroare: parametru "desc" invalid, trebuie să fie unul din următorii: <code>$1</code>',
	'imagemap_description' => 'Despre această imagine',
	'imagemap_poly_odd' => 'Eroare: a fost găsit un poligon cu un număr impar de coordonate în linia $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'imagemap_desc' => "Permette le mappe de immaggine cazzabbele late cliende ausanne 'u tag <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => "Errore: a specifià 'n'immaggine jndr'à prima righe",
	'imagemap_invalid_image' => "Errore: l'immaggine jè invalide o non g'esiste",
	'imagemap_bad_image' => "Errore: l'immaggine sus a sta pàgene jè jndr'à lista gnore",
	'imagemap_no_link' => "Errore: nisciune collegamende valide ha state acchiate a fine d'a linèe $1",
	'imagemap_invalid_title' => "Errore: titele invalide jndr'à 'u collegamende a 'a linèe $1",
	'imagemap_missing_coord' => "Errore: non ge stonne abbastanze coordinate pa figure a 'a linèe $1",
	'imagemap_unrecognised_shape' => "Errore: figure none recanusciute a 'a linèe $1, ogne linèe adda accumenzà cu une de quiste: default, rect, circle o poly",
	'imagemap_invalid_coord' => "Errore: coordinate invalide a 'a linèe $1, adda essere 'nu numere",
	'imagemap_invalid_desc' => "Errore: specificazione d'a descrizione (desc) invalide, adda essere une de <code>$1</code>",
	'imagemap_description' => "Sus a st'immaggine",
	'imagemap_poly_odd' => "Errore: acchiate 'nu poligone cu numere dispare de coordinate sus a linèe $1",
);

/** Russian (Русский)
 * @author Dim Grits
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'imagemap_desc' => 'Позволяет указывать срабатывающие на нажатие карты изображений на стороне клиента с помощью тега <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Ошибка: в первой строке должно быть задано изображение',
	'imagemap_invalid_image' => 'Ошибка: неверное или отсутствующее изображение',
	'imagemap_bad_image' => 'Ошибка. Изображение входит в чёрный список на этой странице.',
	'imagemap_no_link' => 'Ошибка: неверная ссылка в конце строки $1',
	'imagemap_invalid_title' => 'Ошибка: неверный заголовок ссылки в строке $1',
	'imagemap_missing_coord' => 'Ошибка: недостаточно координат для фигуры в строке $1',
	'imagemap_unrecognised_shape' => 'Ошибка: неопознанная фигура в строке $1, каждая строка должна начинаться одним из ключевых слов: default, rect, circle или poly',
	'imagemap_invalid_coord' => 'Ошибка: ошибочная координата в строке $1, ожидается число',
	'imagemap_invalid_desc' => 'Ошибка: некорректное значение desc, ожидается одно из следующих значений: <code>$1</code>',
	'imagemap_description' => 'Описание изображения',
	'imagemap_desc_types' => 'верхний правый, нижний правый, нижний левый, верхний левый, ни один',
	'imagemap_poly_odd' => 'Ошибка: в строке $1 обнаружено описание многоугольника с лишними координатами',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'imagemap_desc' => 'Доволює створёвати кликачу мапу образку на боцї кліента за помочі значкы <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Хыба: на першім рядку мусить быти заданый образок',
	'imagemap_invalid_image' => 'Хыба: файл не є платный або не єствує',
	'imagemap_bad_image' => 'Хыба: образок ся находить на чорнім списку',
	'imagemap_no_link' => 'Хыба: не нашов ся жаден платный одказ на кінцї рядку $1',
	'imagemap_invalid_title' => 'Хыба: неправилна назва в одказї на рядку $1',
	'imagemap_missing_coord' => 'Хыба: хыблячі коордінаты про твар на рядку $1',
	'imagemap_unrecognised_shape' => 'Хыба: нероспознаный твар на рядку $1, каждый рядок мусить зачінати дефініціов твару: default, rect, circle або poly',
	'imagemap_invalid_coord' => 'Хыба: неправилны коордінаты на рядку $1, має быти чісло',
	'imagemap_invalid_desc' => 'Хыба: неправилне заданя области desc, має быти єдна з такых можностей: <code>$1</code>',
	'imagemap_description' => 'О образку',
	'imagemap_poly_odd' => 'Хыба: на рядку $1 найденый многокутник з непарным чіслом коордінат',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'imagemap_desc' => 'Бу <code>&lt;imagemap&gt;</code> тиэги туһанан клиент өттүгэр каартаны баттааһын үлэлиирин көҥүллүүр',
	'imagemap_no_image' => 'Error: бастакы строкатыгар ойуу баар буолуохтаах',
	'imagemap_invalid_image' => 'Error: ойуу сыыһа бэриллибит, эбэтэр отой суох',
	'imagemap_bad_image' => 'Алҕас: ойуу бу сирэй хара испииһэгэр киирэр',
	'imagemap_no_link' => 'Error: $1 строка бүтэһигэр сыыһа ыйынньык турбут',
	'imagemap_invalid_title' => 'Error: $1 строкаҕа ыйынньык баһа сыыһа суруллубут',
	'imagemap_missing_coord' => 'Error: недостаточно координат для фигуры в строке $1',
	'imagemap_unrecognised_shape' => 'Error: неопознанная фигура в строке $1, каждая строка должна начинаться одним из ключевых слов: default, rect, circle или poly',
	'imagemap_invalid_coord' => 'Error: $1 строкаҕа сыыһа координата суруллубут, чыыһыла буолуохтаах',
	'imagemap_invalid_desc' => 'Error: desc суолтата сыыһа турбут, мантан талыахха наада: <code>$1</code>',
	'imagemap_description' => 'Ойуу туһунан',
	'imagemap_poly_odd' => 'Алҕас: $1 строкааҕа наһаа элбэх координааталаах многоугольник туһунан булулунна',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'imagemap_desc' => "Pirmetti di rializzari ''image map'' cliccàbbili latu client cô tag <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => "Sbàgghiu: s'hà spicificari na mmàggini ntâ prima riga",
	'imagemap_invalid_image' => "Sbàgghiu: la mmàggini nun è vàlida o non c'è",
	'imagemap_bad_image' => "Sbàgghiu: la mmàggini s'attrova ntâ blacklist pi sta pàggina",
	'imagemap_no_link' => '
Sbàgghiu: non vinni attruvatu nuddu lijami vàlidu a la fini dâ riga $1',
	'imagemap_invalid_title' => 'Sbàgghiu: tìtulu dû lijami non vàlidu ntâ riga $1',
	'imagemap_missing_coord' => 'Sbàgghiu: non ci sunnu abbastanza cuurdinati pi la furma spicificata nti la tiga $1',
	'imagemap_unrecognised_shape' => 'Sbàgghiu: Furma (shape) non canusciuta nti la riga $1, ogniduna di li righi hà accuminciari cu unu di li furmi ccà di sècutu:  default, rect, circle o poly',
	'imagemap_invalid_coord' => 'Sbàgghiu: cuurdinata non vàlida ntâ riga $1, idda hà èssiri nu nùmmiru',
	'imagemap_invalid_desc' => 'Sbàgghiu: valuri non vàlidu pô paràmitru desc, hà èssiri unu di chisti: <code>$1</code>',
	'imagemap_description' => "Nfumazzioni supr'a â mmàggini",
	'imagemap_desc_types' => 'top-right (susu-a manu dritta), bottom-right (jusu-a manu dritta) , bottom-left (jusu-a manu manca), top-left (susu-a manu manca), none (nenti)',
	'imagemap_poly_odd' => "Sbàgghiu: attruvatu pulìgunu c'un nùmmiru sparu di cuurdinati nti la riga $1",
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code> ටැගය භාවිතයෙන් සේවාලාභි-අන්තයෙහි ක්ලික්කලහැකි රූප සිතියම් වලට ඉඩ සලසයි',
	'imagemap_no_image' => 'දෝෂය: ඔබ විසින්, පළමු පේලියෙහි රූපයක් හුවාදැක්වියයුතුය',
	'imagemap_invalid_image' => 'දෝෂය: රූපය අනීතිකයි නැතිනම් නොපවතියි',
	'imagemap_bad_image' => 'දෝෂය: රූපය මෙම පටුවෙහි අපලේඛණය කොට ඇත',
	'imagemap_no_link' => 'දෝෂය: $1 පේළිය කෙළවර කිසිදු නීතික සබැඳියක් හමුනොවිණි',
	'imagemap_invalid_title' => 'දෝෂය: $1 පේළියෙහි සබැඳියෙහි ශීර්ෂය අනීතිකයි',
	'imagemap_missing_coord' => 'දෝෂය: $1 පේළියෙහි හැඩය සඳහා අවශ්‍ය තරමට ඛණ්ඩාංක සපයා නොමැත',
	'imagemap_unrecognised_shape' => 'දෝෂය: $1 පේළියෙහි හැඩය හඳුනාගතනොහැකි විය, සෑම පේළියක්ම මෙයින් එකකික් ඇරඹිය යුතුය: default, rect, circle හෝ poly',
	'imagemap_invalid_coord' => 'දෝෂය: $1 පේළියෙහි අනීතික ඛණ්ඩාංකයකි, එය සංඛ්‍යාවක් විය යුතුය',
	'imagemap_invalid_desc' => 'දෝෂය: desc පිරිවිතරය අනීතිකයි, මෙයින් එකක් විය යුතුය: <code>$1</code>',
	'imagemap_description' => 'මෙම රූපය පිළිබඳ',
	'imagemap_desc_types' => 'ඉහළ-දකුණ, පහළ-දකුණ, පහළ-වම, ඉහළ-වම, කිසිවක් නැත',
	'imagemap_poly_odd' => 'දෝෂය: $1 පේළියෙහි ඛණ්ඩාංක ඔත්තේ ගණනක් සමග poly හමුවිය',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'imagemap_desc' => 'Poskytuje klikateľné obrázkové mapy spracúvané na strane klienta pomocou značky <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => '&lt;imagemap&gt;: musí mať na prvom riadku uvedený obrázok',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: obrázok je neplatný alebo neexistuje',
	'imagemap_bad_image' => 'Chyba: obrázok na tejto stránke sa nachádza na čiernej listine',
	'imagemap_no_link' => '&lt;imagemap&gt;: na konci riadka $1 nebol nájdený platný odkaz',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: neplatný nadpis v odkaze na riadku $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: nedostatok súradníc na vytvorenie tvaru na riadku $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: nerozpoznaný tvar na riadku $1, každý riadok musí začínať jedným z: default, rect, circle alebo poly',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: neplatná súradnica na riadku $1, musí to byť číslo',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: neplatný popis, musí byť jedno z nasledovných: $1',
	'imagemap_description' => 'O tomto obrázku',
	'imagemap_poly_odd' => 'Chyba: nájdený mnohouholník s nepárnym počtom súradníc na riadku $1',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'imagemap_desc' => 'Omogoča klikljive zemljevide slik na odjemalski strani z uporabo oznake <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Napaka: v prvi vrstici morate navesti sliko',
	'imagemap_invalid_image' => 'Napaka: slika je neveljavna ali ne obstaja',
	'imagemap_bad_image' => 'Napaka: slika je na tej strani na črnem seznamu',
	'imagemap_no_link' => 'Napaka: na koncu vrstice $1 ni bila najdena veljavna povezava',
	'imagemap_invalid_title' => 'Napaka: neveljaven naslov v povezavi v vrstici $1',
	'imagemap_missing_coord' => 'Napaka: ni dovolj koordinat za obliko v vrstici $1',
	'imagemap_unrecognised_shape' => 'Napaka: nerazpoznavna oblika v vrsici $1; vsaka vrstica se mora začeti z enim od: default, rect, circle ali poly',
	'imagemap_invalid_coord' => 'Napaka: neveljavna koordinata v vrstici $1, mora biti število',
	'imagemap_invalid_desc' => 'Napaka: neveljavno določilo desc, mora biti eno izmed: <code>$1</code>',
	'imagemap_description' => 'O tej sliki',
	'imagemap_poly_odd' => 'Napaka: najden večkotnik z lihim številom koordinat v vrstici $1',
);

/** Albanian (Shqip)
 * @author Olsi
 */
$messages['sq'] = array(
	'imagemap_desc' => 'Lejon klientin-side klikueshme harta figure duke përdorur etiketën <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Gabim: duhet të specifikohet një figurë në rreshtin e parë',
	'imagemap_invalid_image' => 'Gabim: figura është e pavlefshme ose joekzistente',
	'imagemap_bad_image' => 'Gabim: figura është në listën e zezë në këtë faqe',
	'imagemap_no_link' => 'Gabim: nuk u gjet asnjë lidhje në fund të rreshtit $1',
	'imagemap_invalid_title' => 'Gabim: titull i pavlefshëm në lidhjen tek rreshti $1',
	'imagemap_missing_coord' => 'Gabim: nuk ka mjaftueshëm koordinata për formën tek rreshti $1',
	'imagemap_unrecognised_shape' => 'Gabim: formë e papranuar tek rreshti $1, çdo rresht duhet të fillojë me një: default, rect, cicrcle ose poly',
	'imagemap_invalid_coord' => 'Gabim: koordinatë e pavlefshme tek rreshti $1, duhet të jetë një numër',
	'imagemap_invalid_desc' => 'Gabim: desc specifikim i pavlefshëm, duhet të jetë një nga: <code>$1</code>',
	'imagemap_description' => 'Rreth kësaj figure',
	'imagemap_poly_odd' => 'Gabim: u gjet poli me numër tek i koordinatave në rreshtin $1',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'imagemap_desc' => 'Омогућава клијентској страни кликабилну мапу коришћњењм ознаке <code>&lt;imagemap&gt;</code>.',
	'imagemap_no_image' => 'Грешка: Неопходно је одредити слику у првој линији.',
	'imagemap_invalid_image' => 'Грешка: Слика је лоша или непостојећа.',
	'imagemap_bad_image' => 'Грешка: слика се налази на црном списку за ову страну',
	'imagemap_no_link' => 'Грешка: Није пронађена ниједна ваљана веза на крају линије $1.',
	'imagemap_invalid_title' => 'Грешка: Лош наслов у вези у линији $1.',
	'imagemap_missing_coord' => 'Грешка: Нема довољно координата за криву у линији $1.',
	'imagemap_unrecognised_shape' => 'Грешка: Непрепозната крива у линији $1, свака линија мора почети једном од: default, rect, circle или poly.',
	'imagemap_invalid_coord' => 'Грешка: Лоше координате у линији $1; морају бити број.',
	'imagemap_invalid_desc' => 'Грешка: Лоше desc одређење, мора бити једно од: <code>$1</code>.',
	'imagemap_description' => 'О овој слици',
	'imagemap_desc_types' => 'горе-десно, доле-десно, доле-лево, горе-лево, нема',
	'imagemap_poly_odd' => 'Грешка: нађен је полигон са непарним бројем координата у линији $1',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'imagemap_desc' => 'Omogućava klijentskoj strani klikabilnu mapu korišćnjenjm oznake <code>&lt;imagemap&gt;</code>.',
	'imagemap_no_image' => 'Greška: Neophodno je odrediti sliku u prvoj liniji.',
	'imagemap_invalid_image' => 'Greška: Slika je loša ili nepostojeća.',
	'imagemap_bad_image' => 'Greška: slika se nalazi na crnom spisku za ovu stranu',
	'imagemap_no_link' => 'Greška: Nije pronađena nijedna valjana veza na kraju linije $1.',
	'imagemap_invalid_title' => 'Greška: Loš naslov u vezi u liniji $1.',
	'imagemap_missing_coord' => 'Greška: Nema dovoljno koordinata za krivu u liniji $1.',
	'imagemap_unrecognised_shape' => 'Greška: Neprepoznata kriva u liniji $1, svaka linija mora početi jednom od: default, rect, circle ili poly.',
	'imagemap_invalid_coord' => 'Greška: Loše koordinate u liniji $1; moraju biti broj.',
	'imagemap_invalid_desc' => 'Greška: Loše desc određenje, mora biti jedno od: <code>$1</code>.',
	'imagemap_description' => 'O ovoj slici',
	'imagemap_desc_types' => 'gore-desno, dole-desno, dole-levo, gore-levo, nema',
	'imagemap_poly_odd' => 'Greška: nađen je poligon sa neparnim brojem koordinata u liniji $1',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'imagemap_desc' => "Moaket dät muugelk ferwies-sensitive Grafike ''(image maps)'' tou moakjen mäd Hälpe fon ju <code>&lt;imagemap&gt;</code>-Syntax",
	'imagemap_no_image' => 'Failer: In ju eerste Riege mout ne Bielde ounroat wäide',
	'imagemap_invalid_image' => 'Failer: Bielde is uungultich of is nit deer',
	'imagemap_bad_image' => 'Failer: Ju Bielde stoant ap ju Lieste fon nit wonskede Bielden',
	'imagemap_no_link' => 'Failer: Ap Eende fon Riege $1 wuude neen gultige Link fuunen',
	'imagemap_invalid_title' => 'Failer: uungultigen Tittel in dän Link in Riege $1',
	'imagemap_missing_coord' => 'Failer: Tou min Koordinate in Riege $1 foar dän Uumriet',
	'imagemap_unrecognised_shape' => 'Failer: Uunbekoande Uumrietfoarm in Riege $1. Älke Riege mout mäd aan fon disse Parametere ounfange: <tt>default, rect, circle</tt> of <tt>poly</tt>',
	'imagemap_invalid_coord' => 'Failer: Uungultige Koordinate in Riege $1: der sunt bloot Taale toulät',
	'imagemap_invalid_desc' => 'Failer: Uungultigen „desc“-Parameter, muugelk sunt: <code>$1</code>',
	'imagemap_description' => 'Uur disse Bielde',
	'imagemap_poly_odd' => 'Failer: Polygon mäd uunpooren Antaal an Koordinoaten in Riege $1',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'imagemap_description' => 'Ngeunaan ieu gambar',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'imagemap_desc' => 'Lägger till taggen <code>&lt;imagemap&gt;</code> för klickbara bilder',
	'imagemap_no_image' => '&lt;imagemap&gt;: en bild måste anges på första raden',
	'imagemap_invalid_image' => '&lt;imagemap&gt;: bilden är ogiltig eller existerar inte',
	'imagemap_bad_image' => 'Fel: bilden är svartlistad på den här sidan',
	'imagemap_no_link' => '&lt;imagemap&gt;: ingen giltig länk fanns i slutet av rad $1',
	'imagemap_invalid_title' => '&lt;imagemap&gt;: felaktig titel i länken på rad $1',
	'imagemap_missing_coord' => '&lt;imagemap&gt;: koordinater saknas för området på rad $1',
	'imagemap_unrecognised_shape' => '&lt;imagemap&gt;: okänd områdesform på rad $1, varje rad måste börja med något av följande: <tt>default, rect, circle, poly</tt>',
	'imagemap_invalid_coord' => '&lt;imagemap&gt;: ogiltig koordinat på rad $1, koordinater måste vara tal',
	'imagemap_invalid_desc' => '&lt;imagemap&gt;: ogiltig specifikation av desc, den måste var en av följande: <code>$1</code>',
	'imagemap_description' => 'Bildinformation',
	'imagemap_poly_odd' => 'Fel: hittade poly med udda antal koordinater på rad $1',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'imagemap_no_image' => 'பிழை:ஒரு படத்தை முதல் வரியில் கண்டிப்பாக குறிப்பிடவேண்டும்.',
	'imagemap_invalid_image' => 'பிழை:படம் செல்லத்தக்கதல்ல அல்லது இல்லாத ஒன்று',
	'imagemap_bad_image' => 'பிழை:படம் இந்த பக்கத்தில் ஏற்கத்தகாதது என பட்டியலிடப்பட்டுள்ளது.',
	'imagemap_invalid_title' => 'பிழை:செல்லத்தகாத தலைப்பு இணைப்பின் வரி $1ல்',
	'imagemap_description' => 'இந்த படத்தை பற்றி',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code> ట్యాగును వాడటం ద్వారా క్లిక్కదగ్గ క్లయంటు-వైపు ఇమేజి మ్యాపులను అనుమతిస్తుంది',
	'imagemap_no_image' => 'Error: తప్పనిసరిగా మొదటి లైనులో ఓ బొమ్మని ఇవ్వాలి',
	'imagemap_invalid_image' => 'Error: తప్పుడు లేదా ఉనికిలో లేని బొమ్మ',
	'imagemap_no_link' => 'Error: $1వ లైను చివర సరియైన లింకు కనబడలేదు',
	'imagemap_invalid_title' => 'Error: $1వ లైనులో ఉన్న లింకులో తప్పుడు శీర్షిక',
	'imagemap_missing_coord' => 'Error: ఆకృతికి తగినన్ని నిరూపకాలు $1వ లైనులో లేవు',
	'imagemap_invalid_coord' => 'Error: $1వ లైనులో తప్పుడు నిరూపకం, అది ఖచ్చితంగా సంఖ్య అయివుండాలి.',
	'imagemap_invalid_desc' => 'Error: descని తప్పుగా ఇచ్చారు, అది వీటిల్లో ఏదో ఒకటి అయివుండాలి: <code>$1</code>',
	'imagemap_description' => 'ఈ బొమ్మ గురించి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'imagemap_description' => "Kona-ba imajen ne'e",
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'imagemap_desc' => 'Имкони эҷоди нақшаҳои тасвирӣ қобили клик кардан дар самти корбарро бо истифода аз барчасби  <code>&lt;imagemap&gt;</code> фароҳам меоварад',
	'imagemap_no_image' => 'Error: бояд дар сатри аввал як аксро мушаххас кунед',
	'imagemap_invalid_image' => 'Error: акс ғайримиҷоз аст ё вуҷуд надорад',
	'imagemap_no_link' => 'Error: ҳеҷ пайванди миҷозе то интиҳои сатри $1 пайдо нашуд',
	'imagemap_invalid_title' => 'Error: унвони ғайримиҷоз дар пайванди сатри $1',
	'imagemap_missing_coord' => 'Error: теъдоди ҳамоҳангӣ дар сатри $1 барои шакл кофӣ нест',
	'imagemap_unrecognised_shape' => 'Error: шакли ношинохта дар сатри $1, ҳар сатр бояд бо яке аз ин дастурот оғоз шавад: default, rect, circle ё poly',
	'imagemap_invalid_coord' => 'Error: баробарии ғайримиҷоз дар сатри $1, бояд адад бошад',
	'imagemap_invalid_desc' => 'Error: тавзеҳоти ғайримиҷоз, бояд яке аз ин маворид бошад: <code>$1</code>',
	'imagemap_description' => 'Дар бораи ин акс',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'imagemap_desc' => 'Imkoni eçodi naqşahoi tasvirī qobili klik kardan dar samti korbarro bo istifoda az barcasbi  <code>&lt;imagemap&gt;</code> faroham meovarad',
	'imagemap_no_image' => 'Error: bojad dar satri avval jak aksro muşaxxas kuned',
	'imagemap_invalid_image' => 'Error: aks ƣajrimiçoz ast jo vuçud nadorad',
	'imagemap_no_link' => 'Error: heç pajvandi miçoze to intihoi satri $1 pajdo naşud',
	'imagemap_invalid_title' => 'Error: unvoni ƣajrimiçoz dar pajvandi satri $1',
	'imagemap_missing_coord' => "Error: te'dodi hamohangī dar satri $1 baroi şakl kofī nest",
	'imagemap_unrecognised_shape' => 'Error: şakli noşinoxta dar satri $1, har satr bojad bo jake az in dasturot oƣoz şavad: default, rect, circle jo poly',
	'imagemap_invalid_coord' => 'Error: barobariji ƣajrimiçoz dar satri $1, bojad adad boşad',
	'imagemap_invalid_desc' => 'Error: tavzehoti ƣajrimiçoz, bojad jake az in mavorid boşad: <code>$1</code>',
	'imagemap_description' => 'Dar borai in aks',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code> tegini ulanyp, müşderi tarapyndan tyklanyp boljak surat kartalaryna rugsat berýär',
	'imagemap_no_image' => 'Säwlik: birinji setirde bir surat görkezmeli',
	'imagemap_invalid_image' => 'Säwlik: surat nädogry ýa-da ýok',
	'imagemap_bad_image' => 'Säwlik: surat bu sahypada gara sanawda',
	'imagemap_no_link' => 'Säwlik: $1 setiriň ahyrynda dogry çykgyt tapylmady',
	'imagemap_invalid_title' => 'Säwlik: $1 setirdäki çykgytda nädogry at',
	'imagemap_missing_coord' => 'Säwlik: $1 setirde surat üçin ýeterlik koordinata ýok',
	'imagemap_unrecognised_shape' => 'Säwlik: $1 setirde ykrar edilmedik şekil, her setir şulardan biri bilen başlamaly: default, rect, cirle ýa-da poly',
	'imagemap_invalid_coord' => 'Säwlik: $1 setirde nädogry koordinata, san bolmaly',
	'imagemap_invalid_desc' => 'Säwlik: nädogry desc bahasy, şulardan biri bolmaly: <code>$1</code>',
	'imagemap_description' => 'Bu surat hakda',
	'imagemap_poly_odd' => 'Säwlik: $1 setirde täk sanly koordinata eýe poly tapyldy',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'imagemap_desc' => 'Nagpapahintulot ng napipindot na mga larawang mapa sa panig ng mga kliyente na ginagamitan ng tatak na <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Kamalian: dapat tumukoy ng isang larawan sa unang guhit/hanay',
	'imagemap_invalid_image' => 'Kamalian: hindi tanggap o hindi umiiral ang isang larawan',
	'imagemap_bad_image' => 'Kamalian: ipinagbabawal (nasa "itim na talaan") sa pahinang ito ang larawan',
	'imagemap_no_link' => 'Kamalian: walang natagpuang tanggap na kawing sa hulihan ng guhit/hanay na $1',
	'imagemap_invalid_title' => 'Kamalian: may hindi tanggap na pamagat sa kawing sa guhit/hanay na $1',
	'imagemap_missing_coord' => 'Kamalian: walang sapat na tugmaang pampook para sa hugis sa guhit/hanay na $1',
	'imagemap_unrecognised_shape' => "Kamalian: hindi nakikilalang hugis sa guhit/hanay na \$1, bawat guhit ay dapat na nagsisimula sa kahit na isang: nakatakda, parihaba, bilog o \"poli\" (''poly'')",
	'imagemap_invalid_coord' => 'Kamalian: hindi tanggap na tugmaang pampook sa guhit/hanay na $1, dapat na isang bilang',
	'imagemap_invalid_desc' => 'Kamalian: hindi tanggap na pagtukoy sa paglalarawan, dapat na isa sa: <code>$1</code>',
	'imagemap_description' => 'Tungkol sa larawang ito',
	'imagemap_desc_types' => 'pang-itaas na kanan, pang-ibabang kanan, pang-ibabang kaliwa, pang-itaas na kaliwa, wala',
	'imagemap_poly_odd' => "Kamalian: nakatagpo ng isang \"poli\" (''poly'') na mayroong bilang na may butal na pang-pagtutugmang pampook na nasa guhit/hanay na \$1",
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'imagemap_desc' => '<code>&lt;imagemap&gt;</code> etiketini kullanarak, alıcı-tarafında tıklanabilir resim haritalarına izin verir',
	'imagemap_no_image' => 'Hata: ilk satırda bir resim belirtmelisiniz',
	'imagemap_invalid_image' => 'Hata: resim geçersiz ya da mevcut değil',
	'imagemap_bad_image' => 'Hata: resim bu sayfada karalistelenmiş',
	'imagemap_no_link' => 'Hata: $1. satırın sonunda geçerli bir bağlantı bulunamadı',
	'imagemap_invalid_title' => 'Hata: $1. satırdaki bağlantıda geçersiz başlık',
	'imagemap_missing_coord' => 'Hata: $1. satırda şekil için yeterli koordinat yok',
	'imagemap_unrecognised_shape' => 'Hata: $1. satırda tanımlanmamış şekil, her satır şunlardan biriyle başlamalı: default, rect, cirle ya da poly',
	'imagemap_invalid_coord' => 'Hata: $1. satırda geçersiz koordinat, bir sayı olmalı',
	'imagemap_invalid_desc' => 'Hata: geçersiz desc belirlemesi, şunlardan biri olmalı: <code>$1</code>',
	'imagemap_description' => 'Resim hakkında',
	'imagemap_poly_odd' => 'Hata: $1. satırda tek sayıda koordinata sahip poly bulundu',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Alex Khimich
 * @author Dim Grits
 */
$messages['uk'] = array(
	'imagemap_desc' => 'Дозволяє створювати на боці клієнта карти зображень, які спрацьовують при натисканні, за допомогою тегу <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Помилка: у першому рядку має бути задане зображення',
	'imagemap_invalid_image' => 'Помилка: неправильне або відсутнє зображення',
	'imagemap_bad_image' => 'Помилка: зображення на цій сторінці присутнє у чорному списку',
	'imagemap_no_link' => 'Помилка: неправильне посилання в кінці рядка $1',
	'imagemap_invalid_title' => 'Помилка: неправильний заголовок в посиланні в рядку $1',
	'imagemap_missing_coord' => 'Помилка: недостатньо координат для фігури в рядку $1',
	'imagemap_unrecognised_shape' => 'Помилка: нерозпізнана фігура в рядку $1, кожен рядок повинен починатися з одного з ключових слів: default, rect, circle або poly',
	'imagemap_invalid_coord' => 'Помилка: помилкова координата в рядку $1, має бути число',
	'imagemap_invalid_desc' => 'Помилка: помилкове значення desc, має бути одне з таких значень: <code>$1</code>',
	'imagemap_description' => 'Опис зображення',
	'imagemap_desc_types' => 'угорі праворуч, унизу праворуч, унизу ліворуч, угорі ліворуч, ніде',
	'imagemap_poly_odd' => 'Помилка: в рядку $1 знайдений многокутник із непарною кількістю координат',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'imagemap_desc' => "Parméte de realizar ''image map'' clicàbili lato client col tag <code>&lt;imagemap&gt;</code>",
	'imagemap_no_image' => 'Error: se gà da specificar na imagine ne la prima riga',
	'imagemap_invalid_image' => "Error: l'imagine no la xe valida o no la esiste",
	'imagemap_bad_image' => "Eror: l'imagine la se cata su la lista nera de sta pagina",
	'imagemap_no_link' => 'Error: no xe stà catà nissun colegamento valido a la fine de la riga $1',
	'imagemap_invalid_title' => 'Error: titolo del colegamento mìa valido ne la riga $1',
	'imagemap_missing_coord' => 'Error: no ghe xe coordinate in bisogno par la forma speçificada ne la riga $1',
	'imagemap_unrecognised_shape' => 'Error: Forma (shape) mìa riconossiùa ne la riga $1, ogni riga la ga da scuminsiar con uno dei seguenti: default, rect, circle o poly',
	'imagemap_invalid_coord' => 'Error: coordinata mìa valida ne la riga $1, la gà da èssar un nùmaro',
	'imagemap_invalid_desc' => 'Error: Valor mìa valido par el parametro desc, el gà da èssar uno dei seguenti: $1',
	'imagemap_description' => 'Informazion su sta imagine',
	'imagemap_poly_odd' => "Erór: gò catà un polìgono co' un nùmaro dispari de coordinate in te la riga $1",
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'imagemap_description' => 'Necen kuvan polhe',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'imagemap_desc' => 'Thêm những bản đồ hình có liên kết dùng thẻ <code>&lt;imagemap&gt;</code>',
	'imagemap_no_image' => 'Lỗi: phải đưa tên hình vào dòng đầu tiên',
	'imagemap_invalid_image' => 'Lỗi: hình không hợp lệ hay không tồn tại',
	'imagemap_bad_image' => 'Lỗi: cấm nhúng hình đó vào trang này',
	'imagemap_no_link' => 'Lỗi: không có liên kết hợp lệ ở cuối dòng $1',
	'imagemap_invalid_title' => 'Lỗi: văn bản liên kết không hợp lệ ở dòng $1',
	'imagemap_missing_coord' => 'Lỗi: không có đủ tọa độ cho vùng ở dòng $1',
	'imagemap_unrecognised_shape' => 'Lỗi: không hiểu hình dạng ở dòng $1, mỗi dòng phải bắt đầu với một trong: default, rect, circle, hay poly',
	'imagemap_invalid_coord' => 'Lỗi: tọa độ không hợp lệ ở dòng $1, phải là số',
	'imagemap_invalid_desc' => 'Lỗi: chọn desc không hợp lệ, phải là một trong: $1',
	'imagemap_description' => 'Thông tin về hình này',
	'imagemap_poly_odd' => 'Lỗi: đa giác có tọa độ không đầy đủ ở dòng $1',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'imagemap_no_image' => 'Error: lien balid muton keninükön magodanemi',
	'imagemap_invalid_image' => 'Error: magod no lonöfon u no dabinon',
	'imagemap_bad_image' => 'Pöl: magod binon in blägalised',
	'imagemap_no_link' => 'Error: yüm lonöföl no petuvon finü lien: $1',
	'imagemap_invalid_title' => 'Error: tiäd no lonöföl pö yüm su lien: $1',
	'imagemap_invalid_coord' => 'Error: koordinats no lonöföls su lien $1: mutons binön num',
	'imagemap_description' => 'Tefü magod at',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'imagemap_invalid_image' => 'טעות: בילד איז אומגילטיק אָדער נישט פֿאַרהאַנען',
	'imagemap_invalid_title' => 'טעות: אומגילטיקער טיטל אין פֿאַרבינדונג אין שורה $1',
	'imagemap_description' => 'וועגן דעם בילד',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'imagemap_no_image' => 'Àsìṣe: àwòrán gbọ́dọ̀ jẹ́ títọ́kasí ní inú ìlà àkọ́kọ́',
	'imagemap_missing_coord' => 'Àsìṣe: àwọn ajọfọ̀nàkò kò tó fún síṣerí ní ìlà $1',
	'imagemap_description' => 'Nípa àwòrán yìí',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'imagemap_desc' => '容許客戶端可以用<code>&lt;imagemap&gt;</code>標籤整可撳圖像地圖',
	'imagemap_no_image' => '錯誤: 一定要響第一行指定一幅圖像',
	'imagemap_invalid_image' => '錯誤: 圖像唔正確或者唔存在',
	'imagemap_bad_image' => '錯誤: 圖像響呢一版已經列入咗黑名單度',
	'imagemap_no_link' => '錯誤: 響第$1行結尾度搵唔到一個正式嘅連結',
	'imagemap_invalid_title' => '錯誤: 響第$1行度嘅標題連結唔正確',
	'imagemap_missing_coord' => '錯誤: 響第$1行度未有足夠嘅座標組成一個形狀',
	'imagemap_unrecognised_shape' => '錯誤: 響第$1行度有未能認出嘅形狀，每一行一定要用以下其中一樣開始: default, rect, circle 或者係 poly',
	'imagemap_invalid_coord' => '錯誤: 響第$1行度有唔正確嘅座標，佢一定係一個數字',
	'imagemap_invalid_desc' => '錯誤: 唔正確嘅 desc 參數，一定係要以下嘅其中之一: $1',
	'imagemap_description' => '關於呢幅圖像',
	'imagemap_desc_types' => '右上, 右下, 左下, 左上, 無',
	'imagemap_poly_odd' => '錯誤: 響第$1行搵到單數嘅多邊坐標',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'imagemap_desc' => '容许客户端可以使用<code>&lt;imagemap&gt;</code>标签整可点击图像地图',
	'imagemap_no_image' => '错误: 必须要在第一行指定一幅图像',
	'imagemap_invalid_image' => '错误: 图像不正确或者不存在',
	'imagemap_bad_image' => '错误: 图像已被本页列入黑名单内',
	'imagemap_no_link' => '错误: 在第$1行结尾中找不到一个正式的链接',
	'imagemap_invalid_title' => '错误: 在第$1行中的标题链接不正确',
	'imagemap_missing_coord' => '错误: 在第$1行中未有足够的座标组成一个形状',
	'imagemap_unrecognised_shape' => '错误: 在第$1行中有未能认出的形状，每一行必须使用以下其中一组字开始: default, rect, circle 或者是 poly',
	'imagemap_invalid_coord' => '错误: 在第$1行中有不正确的座标，它必须是一个数字',
	'imagemap_invalid_desc' => '错误: 不正确的 desc 参数，必须是以下的其中之一: $1',
	'imagemap_description' => '关于这幅图像',
	'imagemap_desc_types' => '右上, 右下, 左下, 左上, 无',
	'imagemap_poly_odd' => '错误: 在第$1行找到单数的多边坐标',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Shinjiman
 * @author Tomchiukc
 */
$messages['zh-hant'] = array(
	'imagemap_desc' => '容許客戶端可以使用<code>&lt;imagemap&gt;</code>標籤整可點擊圖片地圖',
	'imagemap_no_image' => '錯誤：必須要在第一行指定一幅圖片',
	'imagemap_invalid_image' => '錯誤：圖片不正確或者不存在',
	'imagemap_bad_image' => '錯誤：圖片已被本頁列入黑名單內',
	'imagemap_no_link' => '錯誤：在第 $1 行結尾中找不到一個正式的連結',
	'imagemap_invalid_title' => '錯誤：在第 $1 行中的標題連結不正確',
	'imagemap_missing_coord' => '錯誤：在第 $1 行中未有足夠的座標組成一個形狀',
	'imagemap_unrecognised_shape' => '錯誤：在第 $1 行中有未能認出的形狀，每一行必須使用以下其中一組字開始：default, rect, circle 或者是 poly',
	'imagemap_invalid_coord' => '錯誤：在第 $1 行中有不正確的座標，它必須是一個數字',
	'imagemap_invalid_desc' => '錯誤：不正確的 desc 參數，必須是以下的其中之一：$1',
	'imagemap_description' => '關於這幅圖片',
	'imagemap_desc_types' => '右上, 右下, 左下, 左上, 無',
	'imagemap_poly_odd' => '錯誤：在第 $1 行找到單數的多邊坐標',
);

