<?php
/**
 * Internationalisation file for FlaggedRevs extension, section ReviewedVersions
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'reviewedversions' => 'Reviewed versions',
	'reviewedversions-leg1' => 'List reviewed revisions for a page',
	'reviewedversions-page' => 'Page name:',
	'reviewedversions-none' => '"[[:$1]]" has no reviewed revisions.',
	'reviewedversions-list' => 'The following is a list of {{PLURAL:$2|the only revision|revisions}} of [[:$1]] that {{PLURAL:$2|has|have}} been reviewed:',
	'reviewedversions-review' => 'Reviewed on <i>$1</i> by $2',
);

/** Message documentation (Message documentation)
 * @author Aaron Schulz
 * @author Jon Harald Søby
 * @author Siebrand
 */
$messages['qqq'] = array(
	'reviewedversions' => '{{Flagged Revs}}
Name of the Special:ReviewedVersions page, which lists all reviewed versions for specific pages.',
	'reviewedversions-leg1' => '{{Flagged Revs}}
Used on Special:ReviewedVersions.
The legend of the form used to select a page on Special:ReviewedVersions.',
	'reviewedversions-page' => '{{Flagged Revs}}
{{Identical|Page name}}
Used on Special:ReviewedVersions.',
	'reviewedversions-none' => '{{Flagged Revs}}
Message is displayed on Special:ReviewedVersions for pages that has no reviewed revisions.
* $1 The page name.',
	'reviewedversions-list' => '{{Flagged Revs}}
Used on Special:ReviewedVersions.
Parameter $1 is a page title,
Parameter $2 is the count of revisions following, to be used with PLURAL.',
	'reviewedversions-review' => '{{Flagged Revs}}
This message is used in the list of reviewed versions of a page (Special:ReviewedVersions) to specify who has reviewed each version.
* $1 is the date and time of the review
* $2 is the username of the reviewing user, followed by a series of links
* $3 is the date of the review (optional)
* $4 is the time of the review (optional)
* $5 is the raw user name to be used with GENDER (optional)',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'reviewedversions' => 'Bekyk stabiele weergawes',
	'reviewedversions-leg1' => "Lys hersien hersienings vir 'n bladsy",
	'reviewedversions-page' => 'Bladsynaam:',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'reviewedversions' => 'versionet shqyrtoi',
	'reviewedversions-leg1' => 'Lista shqyrtoi shqyrtime për një faqe të',
	'reviewedversions-page' => 'Emri i faqes:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'reviewedversions' => 'versions revisatas',
	'reviewedversions-leg1' => "Amostrar a lista de versions revisatas d'una pachina",
	'reviewedversions-page' => "Nombre d'a pachina:",
	'reviewedversions-none' => '"[[:$1]]" no tiene versions revisatas.',
	'reviewedversions-list' => "A siguient ye una lista con {{PLURAL:%2|a sola versión|as versions}} de [[:$1]] que s'han revisato:",
	'reviewedversions-review' => 'Revisata por $2 o <i>$1</i>',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'reviewedversions' => 'النسخ المُراجعة',
	'reviewedversions-leg1' => 'عرض المراجعات المراجعة لصفحة',
	'reviewedversions-page' => 'اسم الصفحة:',
	'reviewedversions-none' => '"[[:$1]]" لا يوجد بها مراجعات مراجعة.',
	'reviewedversions-list' => 'هذه قائمة {{PLURAL:$2||بمراجعة|بمراجعتي|بمراجعات}} الصفحة [[:$1]] {{PLURAL:$2||التي تمت مراجعتها|اللتين تمت مراجعتهما|التي تمت مراجعتها}}:',
	'reviewedversions-review' => '{{GENDER:$5|راجعها|راجعتها}} $2 في <i>$1</i>',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'reviewedversions-page' => 'ܫܡܐ ܕܦܐܬܐ:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'reviewedversions' => 'عرض النسخ المستقرة',
	'reviewedversions-leg1' => 'عرض المراجعات المراجعه لصفحة',
	'reviewedversions-page' => 'اسم الصفحة:',
	'reviewedversions-none' => '"[[:$1]]" لا يوجد بها مراجعات مراجعه.',
	'reviewedversions-list' => 'هذه قائمه {{PLURAL:$2||بمراجعة|بمراجعتي|بمراجعات}} الصفحه [[:$1]] {{PLURAL:$2||التى تمت مراجعتها|اللتين تمت مراجعتهما|التى تمت مراجعتها}}:',
	'reviewedversions-review' => '{{GENDER:$5|راجعها|راجعتها}} $2 فى <i>$1</i>',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'reviewedversions' => 'Versiones revisaes',
	'reviewedversions-leg1' => "Llista de les revisiones revisaes d'una páxina",
	'reviewedversions-page' => 'Nome de la páxina:',
	'reviewedversions-none' => '"[[:$1]]" nun tien revisiones revisaes.',
	'reviewedversions-list' => 'Darréu ta la llista de {{PLURAL:$2|la única revisión|les revisiones}} de [[:$1]] que se {{PLURAL:$2|revisó|revisaron}}:',
	'reviewedversions-review' => "Revisada'l <i>$1</i> por $2",
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'reviewedversions-page' => 'Səhifə adı:',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'reviewedversions' => 'به گند ثابتین نسخه یانء',
	'reviewedversions-leg1' => 'لیست کن اصلاحات بازبینی په ای صفحه',
	'reviewedversions-page' => 'نام صفحه:',
	'reviewedversions-none' => '"[[:$1]]" هچ نسخه بازبینیء نیست',
	'reviewedversions-list' => 'جهلیگین یک لیستی چه بازبینی آن [[:$1]] که دگه چارگ بوتگنت:',
	'reviewedversions-review' => 'بازبینی بیته ته <i>$1</i> گون $2',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'reviewedversions-page' => 'Pangaran kan pahina',
);

/** Belarusian (Беларуская)
 * @author Хомелка
 */
$messages['be'] = array(
	'reviewedversions' => 'Правераныя версіі',
	'reviewedversions-leg1' => 'Пералік правераных версій старонкі',
	'reviewedversions-page' => 'Назва старонкі:',
	'reviewedversions-none' => '«[[:$1]]» не мае правераных версій.',
	'reviewedversions-list' => '{{PLURAL:$2|Была праверана наступная версія|Былі правераны наступныя версіі}} старонкі «[[:$1]]»:',
	'reviewedversions-review' => 'Праверана <i>$1</i> ўдзельнікам $2',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'reviewedversions' => 'Рэцэнзаваныя вэрсіі',
	'reviewedversions-leg1' => 'Сьпіс правераных вэрсіяў старонкі',
	'reviewedversions-page' => 'Назва старонкі:',
	'reviewedversions-none' => '«[[:$1]]» ня мае правераных вэрсіяў.',
	'reviewedversions-list' => '{{PLURAL:$2|Наступная вэрсія|Наступныя вэрсіі}} старонкі [[:$1]] {{PLURAL:$2|была правераная|былі правераныя}}:',
	'reviewedversions-review' => 'Правераная <i>$1</i> {{GENDER:$2|удзельнікам|удзельніцай}} $2',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'reviewedversions' => 'Преглед на устойчивите версии',
	'reviewedversions-leg1' => 'Преглед на рецензираните версии на страницата',
	'reviewedversions-page' => 'Име на страницата:',
	'reviewedversions-none' => 'Страницата „[[:$1]]“ няма рецензирани версии.',
	'reviewedversions-list' => 'Следва {{PLURAL:$2|единствената версия|списък на версиите}} на [[:$1]], {{PLURAL:$2|която е била рецензирана|които са били рецензирани}}:',
	'reviewedversions-review' => 'Рецензирана на <i>$1</i> от $2',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'reviewedversions' => 'পর্যালোচিত সংস্করণ',
	'reviewedversions-page' => 'পাতার নাম:',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'reviewedversions' => 'Stummoù adwelet',
	'reviewedversions-leg1' => 'Adweladennoù diwezhañ ur bajenn',
	'reviewedversions-page' => 'Anv ar bajenn :',
	'reviewedversions-none' => '"[[:$1]]" n\'eus stumm adwelet ebet dioutañ',
	'reviewedversions-list' => 'War ar roll da-heul emañ {{PLURAL:$2|an adweladenn nemeti|eus an adweladennoù}} eus [[:$1]] hag {{PLURAL:$2|a zo bet|a zo bet}} adwelet :',
	'reviewedversions-review' => "Adwelet d'an <i>$1</i> gant $2",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'reviewedversions' => 'Pregledane verzije',
	'reviewedversions-leg1' => 'Spisak pregledanih revizija stranice',
	'reviewedversions-page' => 'Naslov stranice:',
	'reviewedversions-none' => '"[[:$1]]" nema pregledanih revizija.',
	'reviewedversions-list' => 'Ovo je spisak {{PLURAL:$2|jedne verzije|verzije|verzija}} od [[:$1]] {{PLURAL:$2|koja je pregledana|koje su pregledane}}:',
	'reviewedversions-review' => 'Pregledano dana <i>$1</i> od strane $2',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Ssola
 * @author Toniher
 */
$messages['ca'] = array(
	'reviewedversions' => 'Versions estables',
	'reviewedversions-leg1' => "Llista d'edicions revisades per una pàgina",
	'reviewedversions-page' => 'Nom de la pàgina:',
	'reviewedversions-none' => '«[[:$1]]» no té edicions revisades.',
	'reviewedversions-list' => "A continuació hi ha la llista de {{PLURAL:$2|l'única modificació|les modificacions}} de [[:$1]] que {{PLURAL:$2|s'ha|s'han}} revisat:",
	'reviewedversions-review' => 'Revisat el <em>$1</em> per $2',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'reviewedversions' => 'Хьаьжина варсийш',
	'reviewedversions-page' => 'Агlон цlе:',
	'reviewedversions-review' => 'Хьаьжна  <i>$1</i> декъашхо $2',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'reviewedversions' => 'Zobrazit stabilní verze',
	'reviewedversions-leg1' => 'Přehled posouzených verzí stránky',
	'reviewedversions-page' => 'Jméno stránky',
	'reviewedversions-none' => '[[:$1]] nemá žádné posouzené verze.',
	'reviewedversions-list' => 'Toto je seznam {{PLURAL:$2|jediné revize|revizí}} stránky [[:$1]], {{PLURAL:$2|která nebyla|které nebyly}} posouzeny:',
	'reviewedversions-review' => 'Posouzeno <i>$1</i> uživatelem $2',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'reviewedversions-page' => 'страни́цѧ и́мѧ',
);

/** Danish (Dansk)
 * @author Froztbyte
 */
$messages['da'] = array(
	'reviewedversions-page' => 'Sidenavn:',
);

/** German (Deutsch)
 * @author Giftpflanze
 * @author Imre
 * @author Merlissimo
 * @author Umherirrender
 */
$messages['de'] = array(
	'reviewedversions' => 'Markierte Versionen',
	'reviewedversions-leg1' => 'Liste der markierten Versionen für eine Seite',
	'reviewedversions-page' => 'Seitenname:',
	'reviewedversions-none' => '„[[:$1]]“ hat keine markierten Versionen.',
	'reviewedversions-list' => 'Dies ist die Liste der {{PLURAL:$2|einzigen Version|Versionen}} von [[:$1]], die markiert {{PLURAL:$2|wurde|wurden}}:',
	'reviewedversions-review' => 'Markiert am <i>$1</i> durch $2',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'reviewedversions' => 'Versiyonan ke kontrol biye',
	'reviewedversions-leg1' => 'qey yew peli revizyonê kontrol biyayeyan liste bıker',
	'reviewedversions-page' => 'nameyê peli:',
	'reviewedversions-none' => '"[[:$1]]" wayirê revizyonê konrol biyayeyan niyo.',
	'reviewedversions-list' => 'Sıradaki, [[:$1]] için gözden geçirilmiş {{PLURAL:$2|tek revizyonun|revizyonların}} bir listesidir:',
	'reviewedversions-review' => 'hetê $2 ra <i>$1</i> tarix de kontrol bı',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'reviewedversions' => 'Pśeglědane wersiej',
	'reviewedversions-leg1' => 'Lisćina pśeglědanych wersijow za bok',
	'reviewedversions-page' => 'Mě boka:',
	'reviewedversions-none' => '"[[:$1]]" njama pśeglědane wersije.',
	'reviewedversions-list' => 'To jo lisćina {{PLURAL:$2|jadnučkeje wersije|wersijowu|wersijow|wersijow}} wót [[:$1]], {{PLURAL:$2|kótaraž jo se pśeglědała|kótarejž stej se pśeglědałej|kótarež su se pśeglědali|kótarež su se pśeglědali}}:',
	'reviewedversions-review' => 'Pśeglědany <i>$1</i> wót $2',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Dead3y3
 * @author Glavkos
 * @author Omnipaedista
 */
$messages['el'] = array(
	'reviewedversions' => 'Αναθεωρημένες εκδόσεις',
	'reviewedversions-leg1' => 'Απαρίθμηση κριθέντων αναθεωρήσεων για μια σελίδα',
	'reviewedversions-page' => 'Όνομα σελίδας:',
	'reviewedversions-none' => 'Η "[[:$1]]" δεν έχει αναθεωρήσεις που να έχουν κριθεί.',
	'reviewedversions-list' => 'Ο ακόλουθος είναι ένας κατάλογος {{PLURAL:$2|της μοναδικής αναθεώρησης|των αναθεωρήσεων}} της σελίδας [[:$1]] που {{PLURAL:$2|έχει|έχουν}} κριθεί:',
	'reviewedversions-review' => 'Κρίθηκε στις <i>$1</i> από τον/την $2',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'reviewedversions' => 'Kontrolitaj versioj',
	'reviewedversions-leg1' => 'Listigi kontrolitajn versiojn por paĝo',
	'reviewedversions-page' => 'Nomo de paĝo:',
	'reviewedversions-none' => '"[[:$1]]" havas neniujn kontrolitajn revizojn.',
	'reviewedversions-list' => 'Jen listo de {{PLURAL:$2|la sola revizio|revizioj}} de [[:$1]] {{PLURAL:$2|kiu estas kontrolita|kiuj estis kontrolitaj}}:',
	'reviewedversions-review' => 'Kontrolita <i>$1</i> de $2',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 */
$messages['es'] = array(
	'reviewedversions' => 'Versiones revisadas',
	'reviewedversions-leg1' => 'lista de revisiones verificadas para una página',
	'reviewedversions-page' => 'Nombre de la página:',
	'reviewedversions-none' => '"[[:$1]]" no tiene revisiones verificadas.',
	'reviewedversions-list' => 'La siguiente es una lista de {{PLURAL:$2|la única revisión|revisiones}} de [[:$1]] que {{PLURAL:$2|ha|han}} sido verificadas:',
	'reviewedversions-review' => 'Revisada en <i>$1</i> por $2',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'reviewedversions' => 'Ülevaadatud versioonid',
	'reviewedversions-leg1' => 'Lehekülje ülevaadatud redaktsioonide loetlemine',
	'reviewedversions-page' => 'Lehekülje nimi:',
	'reviewedversions-none' => 'Leheküljel "[[:$1]]" pole ülevaadatud redaktsioone.',
	'reviewedversions-list' => 'Järgnev on {{PLURAL:$2|ainus lehekülje [[:$1]] redaktsioon|loend lehekülje [[:$1]] redaktsioonidest}}, mis on ülevaadatud:',
	'reviewedversions-review' => '$2 vaatas lehekülje üle kuupäeval <i>$1</i>',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'reviewedversions' => 'Berrikusitako bertsioak',
	'reviewedversions-page' => 'Orrialdearen izenburua:',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'reviewedversions-page' => 'Nombri la páhina:',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Sahim
 * @author Wayiran
 */
$messages['fa'] = array(
	'reviewedversions' => 'نسخهٔ بازبینی شده',
	'reviewedversions-leg1' => 'فهرست کردن نسخه‌های بررسی شده یک صفحه',
	'reviewedversions-page' => 'نام صفحه:',
	'reviewedversions-none' => '«[[:$1]]» هیچ نسخه بررسی‌ شده‌ای ندارد.',
	'reviewedversions-list' => 'در زیر فهرستی از {{PLURAL:$2|تنها نسخهٔ|نسخه‌های}} [[:$1]] که بازبینی {{PLURAL:$2|شده‌است|شده‌اند}} می‌باشد:',
	'reviewedversions-review' => 'بررسی شده در <i>$1</i> توسط $2',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jaakonam
 * @author Nike
 * @author Pxos
 */
$messages['fi'] = array(
	'reviewedversions' => 'Arvioidut versiot',
	'reviewedversions-leg1' => 'Näytä luettelona sivun arvioidut versiot',
	'reviewedversions-page' => 'Sivun nimi',
	'reviewedversions-none' => 'Sivusta [[:$1]] ei ole arvioituja versioita.',
	'reviewedversions-list' => 'Tämä on {{PLURAL:$2|ainoa versio, joka|luettelo versioista, jotka}} on arvioitu kohteesta [[:$1]]:',
	'reviewedversions-review' => '$2 arvioi sivun <i>$1</i>',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'reviewedversions' => 'Versions passées en revue',
	'reviewedversions-leg1' => "Dernières révisions revues d'une page",
	'reviewedversions-page' => 'Nom de la page :',
	'reviewedversions-none' => "« [[:$1]] » n'a pas de version révisée.",
	'reviewedversions-list' => 'La liste qui suit contient {{PLURAL:$2|de la seule version|des versions}} de « [[:$1]] » qui {{PLURAL:$2|a été révisée|ont été révisées}} :',
	'reviewedversions-review' => 'Révisée le <i>$1</i> par $2',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'reviewedversions' => 'Vèrsions revues',
	'reviewedversions-leg1' => 'Montre una lista de les dèrriéres vèrsions revues d’una pâge.',
	'reviewedversions-page' => 'Nom de la pâge :',
	'reviewedversions-none' => '« [[:$1]] » at gins de vèrsion revua.',
	'reviewedversions-list' => 'La lista que siut contint {{PLURAL:$2|la solèta vèrsion|des vèrsions}} de « [[:$1]] » qu’{{PLURAL:$2|at étâ revua|ont étâ revues}} :',
	'reviewedversions-review' => 'Revua lo <i>$1</i> per $2',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'reviewedversions-page' => 'Sidenamme:',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'reviewedversions' => 'Versións revisadas',
	'reviewedversions-leg1' => 'Listar as revisións revisadas dunha páxina',
	'reviewedversions-page' => 'Nome da páxina:',
	'reviewedversions-none' => '"[[:$1]]" non ten revisións examinadas.',
	'reviewedversions-list' => 'A continuación hai unha lista {{PLURAL:$2|coa única revisión|coas revisións}} de "[[:$1]]" que {{PLURAL:$2|foi revisada|foron revisadas}}:',
	'reviewedversions-review' => 'Revisado o <i>$1</i> por $2',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'reviewedversions' => 'Ὁρᾶν τὰς σταθερὰς ἐκδόσεις',
	'reviewedversions-leg1' => 'Ὕσταται ἐπιθεωρημέναι ἀναθεωρήσεις δέλτου τινός',
	'reviewedversions-page' => 'Ὄνομα δέλτου:',
	'reviewedversions-none' => 'Τὸ "[[:$1]]" οὐκ ἔχει ἐπιθεωρημένας ἀναθεωρήσεις.',
	'reviewedversions-list' => 'Ἀκολουθεῖ κατάλογος {{PLURAL:$2|τῆς μεταγραφῆς|μεταγραφῶν}} {{PLURAL:$2|τῆς ἐπιτεθεωρημένης|ἐπιτεθεωρημένων}} τῆς [[:$1]]:',
	'reviewedversions-review' => 'Ἐπιθεωρημένη τὴν <i>$1</i> ἐκ τοῦ $2',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'reviewedversions' => 'Priefti Versione',
	'reviewedversions-leg1' => 'Lischt vu dr Versione fir e Artikel, wu vum Fäldhieter gsäh sin',
	'reviewedversions-page' => 'Artikelname:',
	'reviewedversions-none' => '„[[:$1]]“ het kei Versione, wu vum Fäldhieter gsäh sin.',
	'reviewedversions-list' => 'Des isch d Lischt vu dr {{PLURAL:$2|Version|Versione}} vu [[:$1]], wu vum Fäldhieter aagluegt {{PLURAL:$2|isch|sin}}:',
	'reviewedversions-review' => 'aagluegt <i>$1</i> dur $2',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author DoviJ
 * @author Rotemliss
 * @author דניאל ב.
 */
$messages['he'] = array(
	'reviewedversions' => 'גרסאות שנסקרו',
	'reviewedversions-leg1' => 'רשימת גרסאות הדף שנסקרו',
	'reviewedversions-page' => 'שם הדף:',
	'reviewedversions-none' => 'בדף "[[:$1]]" אין גרסאות שנסקרו.',
	'reviewedversions-list' => 'להלן {{PLURAL:$2|הגרסה היחידה|רשימת הגרסאות}} של [[:$1]] {{PLURAL:$2|שנסקרה|שנסקרו}}:',
	'reviewedversions-review' => 'נסקרה ב־<i>$1</i> על ידי $2',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'reviewedversions' => 'स्थिर अवतरण देखें',
	'reviewedversions-leg1' => 'पन्नेके परीक्षण हुए अवतरणोंकी सूची देखें',
	'reviewedversions-page' => 'लेख शीर्षक:',
	'reviewedversions-none' => '"[[:$1]]" को एकभी परिक्षण किया हुआ अवतरण नहीं हैं।',
	'reviewedversions-list' => 'नीचे [[:$1]] के परिक्षण हुए अवतरणोंकी सूची हैं:',
	'reviewedversions-review' => '$2 द्वारा <i>$1</i> को परिक्षण हुआ',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'reviewedversions' => 'Pregledane inačice',
	'reviewedversions-leg1' => 'Popis ocijenjenih inačica stranice',
	'reviewedversions-page' => 'Ime stranice:',
	'reviewedversions-none' => 'Članak "[[:$1]]" nema ocijenjenih inačica.',
	'reviewedversions-list' => 'Slijedi popis {{PLURAL:$2|jedne inačice|inačica}} od [[:$1]] {{PLURAL:$2|koja je ocijenjena|koje su ocijenjene}}:',
	'reviewedversions-review' => 'Ocijenjeno <i>$1</i> od suradnika $2',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'reviewedversions' => 'Přepruwowane wersije',
	'reviewedversions-leg1' => 'Přepruwowane wersije za nastawk nalistować',
	'reviewedversions-page' => 'Mjeno nastawka',
	'reviewedversions-none' => '[[:$1]] přepruwowane wersije nima.',
	'reviewedversions-list' => 'Slědowaca lisćina je lisćina {{PLURAL:$2|jeničkeje wersije|wersijow|wersijow|wersijow}} [[:$1]], {{PLURAL:$2|bu přepruwowana|buštej přepruwowanej|buchu přepruwowane|buchu přepruwowane}}:',
	'reviewedversions-review' => 'Dnja <i>$1</i> wot $2 přepruwowany',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Samat
 */
$messages['hu'] = array(
	'reviewedversions' => 'Ellenőrzött változatok',
	'reviewedversions-leg1' => 'Oldal ellenőrzött változatainak listája',
	'reviewedversions-page' => 'A lap címe:',
	'reviewedversions-none' => 'A(z) „[[:$1]]” lapnak nincsenek ellenőrzött változatai.',
	'reviewedversions-list' => 'Alább a(z) „[[:$1]]” lap azon {{PLURAL:$2|változata látható|változatai láthatóak}}, {{PLURAL:$2|amelyet|amelyeket}} ellenőriztek:',
	'reviewedversions-review' => 'Ellenőrizte $2, <i>$1</i>-kor',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'reviewedversions' => 'Versiones revidite',
	'reviewedversions-leg1' => 'Listar le versiones revidite de un pagina',
	'reviewedversions-page' => 'Nomine del pagina:',
	'reviewedversions-none' => '"[[:$1]]" non ha versiones revidite.',
	'reviewedversions-list' => 'Ecce {{PLURAL:$2|le sol version|le lista del versiones}} de [[:$1]] que ha essite revidite:',
	'reviewedversions-review' => 'Revidite le <i>$1</i> per $2',
);

/** Indonesian (Bahasa Indonesia)
 * @author Iwan Novirion
 * @author Rex
 */
$messages['id'] = array(
	'reviewedversions' => 'Versi yang telah ditinjau',
	'reviewedversions-leg1' => 'Menampilkan revisi tertinjau dari suatu halaman',
	'reviewedversions-page' => 'Nama halaman:',
	'reviewedversions-none' => '"[[:$1]]" tidak memiliki revisi tertinjau.',
	'reviewedversions-list' => 'Berikut adalah daftar {{PLURAL:$2|revisi|revisi-revisi}} dari [[:$1]] yang {{PLURAL:$2|telah|telah}} ditinjau:',
	'reviewedversions-review' => 'Ditinjau pada <i>$1</i> oleh $2',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'reviewedversions-leg1' => 'Dètú orübà hé lèrè màkà ótù ihü',
	'reviewedversions-page' => 'Áhà ihü:',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'reviewedversions' => 'Stöðugar útgáfur',
	'reviewedversions-page' => 'Titill síðu:',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 */
$messages['it'] = array(
	'reviewedversions' => 'Versioni revisionate',
	'reviewedversions-leg1' => 'Elenco delle versioni revisionate per una pagina',
	'reviewedversions-page' => 'Nome della pagina:',
	'reviewedversions-none' => '"[[:$1]]" non ha versioni revisionate.',
	'reviewedversions-list' => "Di seguito è riportato un elenco {{PLURAL:$2|dell'unica versione|delle versioni}} di [[:$1]] che {{PLURAL:$2|è stata revisionata|sono state revisionate}}:",
	'reviewedversions-review' => 'Revisionata il <i>$1</i> da $2',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Schu
 */
$messages['ja'] = array(
	'reviewedversions' => '査読済みの版',
	'reviewedversions-leg1' => 'ページの査読済み版を一覧表示する',
	'reviewedversions-page' => 'ページ名：',
	'reviewedversions-none' => '「[[:$1]]」には査読済みの版がありません。',
	'reviewedversions-list' => '以下は「[[:$1]]」の査読済みの{{PLURAL:$2|唯一の版|版の一覧}}です:',
	'reviewedversions-review' => '査読日: <i>$1</i>、査読者: $2',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'reviewedversions' => 'Stabiil versje',
	'reviewedversions-page' => 'Pægenavn:',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Nodar Kherkheulidze
 */
$messages['ka'] = array(
	'reviewedversions' => 'შემოწმებული ვერსიები',
	'reviewedversions-page' => 'გვერდის სახელი:',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'reviewedversions' => 'تىياناقتى نۇسقالار',
	'reviewedversions-leg1' => 'سىن بەرىلگەن بەتتىڭ نۇسقا ٴتىزىمى',
	'reviewedversions-page' => 'بەت اتاۋى:',
	'reviewedversions-none' => '«[[:$1]]» بەتىندە سىن بەرىلگەن ەش نۇسقا جوق.',
	'reviewedversions-list' => 'كەلەسى تىزىمدە [[:$1]] بەتىنىڭ سىن بەرىلگەن نۇسقالارى كەلتىرىلەدى:',
	'reviewedversions-review' => '$2 <i>$1</i> كەزىندە سىن بەردى',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'reviewedversions' => 'Тиянақты нұсқалар',
	'reviewedversions-leg1' => 'Сын берілген беттің нұсқа тізімі',
	'reviewedversions-page' => 'Бет атауы:',
	'reviewedversions-none' => '«[[:$1]]» бетінде сын берілген еш нұсқа жоқ.',
	'reviewedversions-list' => 'Келесі тізімде [[:$1]] бетінің сын берілген нұсқалары келтіріледі:',
	'reviewedversions-review' => '$2 <i>$1</i> кезінде сын берді',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'reviewedversions' => 'Tïyanaqtı nusqalar',
	'reviewedversions-leg1' => 'Sın berilgen bettiñ nusqa tizimi',
	'reviewedversions-page' => 'Bet atawı:',
	'reviewedversions-none' => '«[[:$1]]» betinde sın berilgen eş nusqa joq.',
	'reviewedversions-list' => 'Kelesi tizimde [[:$1]] betiniñ sın berilgen nusqaları keltiriledi:',
	'reviewedversions-review' => '$2 <i>$1</i> kezinde sın berdi',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'reviewedversions-page' => 'ឈ្មោះទំព័រ៖',
);

/** Korean (한국어)
 * @author Devunt
 * @author Kwj2772
 */
$messages['ko'] = array(
	'reviewedversions' => '검토된 버전',
	'reviewedversions-leg1' => '문서의 검토된 판의 목록',
	'reviewedversions-page' => '문서 이름:',
	'reviewedversions-none' => '"[[:$1]]"의 검토된 판이 없습니다.',
	'reviewedversions-list' => '다음은 [[:$1]] 문서의 검토된 {{PLURAL:$2|편집}}의 목록입니다:',
	'reviewedversions-review' => '<i>$1</i>에 $2에게 검토됨',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'reviewedversions' => 'Nohjekik Versione',
	'reviewedversions-leg1' => 'De Leß met de nohjekik Versione för en Sigg.',
	'reviewedversions-page' => 'Sigge-Tittel:',
	'reviewedversions-none' => 'De Sigg „[[:$1]]“ hät kei nohjekik Versione.',
	'reviewedversions-list' => 'Hee kütt {{PLURAL:$2|de|en Leß met dä|kei nohjekik Version vun dä}} Sigg „[[:$1]]“ {{PLURAL:$2|ier einzije nohjekk Version:|ier nohjekik Versione:|}}',
	'reviewedversions-review' => 'Nohjekik {{GENDER:$5|vum|vum|vun däm Metmaacher|vun däm|vun dä}} $2 aam $3 öm $4 Uhr.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'reviewedversions-page' => 'Navê rûpelê:',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'reviewedversions-page' => 'Nomen paginae:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'reviewedversions' => 'nogekuckte Versiounen',
	'reviewedversions-leg1' => 'Lëscht vun den nogekuckte Versioune vun enger Säit',
	'reviewedversions-page' => 'Säitenumm:',
	'reviewedversions-none' => '"[[:$1]]" huet keng nogekuckte Versiounen.',
	'reviewedversions-list' => 'Dëst ass eng Lëscht vun {{PLURAL:$2|der Versioun|de Verioune}} vun [[:$1]] déi nogekuckt {{PLURAL:$2|ginn ass|gi sinn}}:',
	'reviewedversions-review' => 'Nogekuckt den <i>$1</i> vum $2',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'reviewedversions' => 'Gecontroleerde versies',
	'reviewedversions-leg1' => 'Lijst van beoordeelde versies voor een pagina',
	'reviewedversions-page' => 'Pazjenanaam:',
	'reviewedversions-none' => '[[:$1]] haet gein beoordeilde versies.',
	'reviewedversions-list' => "Hieonger steit {{PLURAL:$2|de versie|'n lies mit gecontroleerde versies}} van [[:$1]]:",
	'reviewedversions-review' => 'Beoordeiling oetgeveurd op <i>$1</i> door $2',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'reviewedversions-page' => 'Puslapio pavadinimas:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'reviewedversions-page' => 'Лаштыкын лӱмжӧ:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'reviewedversions' => 'Проверени верзии',
	'reviewedversions-leg1' => 'Список на прегледани ревизии за страница',
	'reviewedversions-page' => 'Наслов на страница:',
	'reviewedversions-none' => '"[[:$1]]" нема прегледани ревизии.',
	'reviewedversions-list' => 'Ова е список на {{PLURAL:$2|единствената ревизија|ревизиите}} на [[:$1]] {{PLURAL:$2|која е прегледана|кои се прегледани}}:',
	'reviewedversions-review' => 'Прегледано на <i>$1</i> од страна на $2',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'reviewedversions' => 'സംശോധനം ചെയ്ത പതിപ്പുകൾ',
	'reviewedversions-leg1' => 'ഒരു താളിന്റെ സം‌ശോധനം ചെയ്യപ്പെട്ട പതിപ്പുകള്‍ പ്രദര്‍ശിപ്പിക്കുക',
	'reviewedversions-page' => 'താളിന്റെ പേര്‌:',
	'reviewedversions-none' => '"[[:$1]]"നു സംശോധനം നിർവഹിച്ച പതിപ്പുകൾ ഒന്നുമില്ല.',
	'reviewedversions-list' => '[[:$1]] എന്ന താളിന്റെ സം‌ശോധനം ചെയ്യപ്പെട്ട {{PLURAL:$2|ഒരു നാൾപ്പതിപ്പിന്റെ|നാൾപ്പതിപ്പുകളുടെ}} പട്ടികയാണ് താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്നത്:',
	'reviewedversions-review' => "''$1''നു $2 സം‌ശോധനം നിർവ്വഹിച്ചു",
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 */
$messages['mr'] = array(
	'reviewedversions' => 'स्थिर आवृत्त्या पहा',
	'reviewedversions-leg1' => 'एखाद्या पानाच्या तपासलेल्या आवृत्त्यांची यादी',
	'reviewedversions-page' => 'पृष्ठ नाव',
	'reviewedversions-none' => '"[[:$1]]" ला कुठल्याही तपासलेल्या आवृत्त्या नाहीत.',
	'reviewedversions-list' => 'खाली [[:$1]] च्या तपासलेल्या आवृत्त्यांची यादी आहे:',
	'reviewedversions-review' => '$2 द्वारा <i>$1</i> रोजी तपासली गेली',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'reviewedversions' => 'Versi-versi dikaji semula',
	'reviewedversions-leg1' => 'Senaraikan semakan yang dikaji semula bagi satu halaman',
	'reviewedversions-page' => 'Nama halaman:',
	'reviewedversions-none' => '"[[:$1]]" tiada versi dikaji semula.',
	'reviewedversions-list' => 'Berikut ialah {{PLURAL:$2|satu-satunya semakan|senarai semakan}} [[:$1]] yang telah dikaji semula:',
	'reviewedversions-review' => 'Diperiksa pada <i>$1</i> oleh $2',
);

/** Erzya (Эрзянь)
 * @author Amdf
 */
$messages['myv'] = array(
	'reviewedversions-page' => 'Лопань лем:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'reviewedversions-page' => 'Zāzanilli ītōcā:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'reviewedversions' => 'Reviderte versjoner',
	'reviewedversions-leg1' => 'List anmeldte versjoner av en side',
	'reviewedversions-page' => 'Sidenavn:',
	'reviewedversions-none' => '«[[:$1]]» har ingen anmeldte versjoner.',
	'reviewedversions-list' => 'Følgende er en liste over {{PLURAL:$2|den eneste versjonen|versjonene}} av [[:$1]] som har blitt gjennomgått:',
	'reviewedversions-review' => 'Anmeldt <i>$1</i> av $2',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'reviewedversions-page' => 'Siedennaam:',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'reviewedversions' => 'Gecontroleerde versies',
	'reviewedversions-leg1' => 'Lijst van gecontroleerde versies voor een pagina',
	'reviewedversions-page' => 'Paginanaam:',
	'reviewedversions-none' => '"[[:$1]]" heeft geen gecontroleerde versies',
	'reviewedversions-list' => 'Hieronder staat {{PLURAL:$2|de versie|een lijst met gecontroleerde versies}} van [[:$1]]:',
	'reviewedversions-review' => 'Gecontroleerd op <i>$1</i> door $2',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'reviewedversions' => 'Sjå stabile versjonar',
	'reviewedversions-leg1' => 'List opp vurderte versjonar av ei sida',
	'reviewedversions-page' => 'Sidenamn',
	'reviewedversions-none' => '«[[:$1]]» har ingen vurderte versjonar.',
	'reviewedversions-list' => 'Fylgjande er ei lista over vurderte versjonar av [[:$1]]:',
	'reviewedversions-review' => 'Vurdert den <i>$1</i> av $2',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'reviewedversions-page' => 'Leina la letlakala:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'reviewedversions' => 'Versions repassadas',
	'reviewedversions-leg1' => "Darrièras revisions revistas d'una pagina",
	'reviewedversions-page' => 'Nom de la pagina :',
	'reviewedversions-none' => 'La lista que seguís conten de versions de « [[:$1]] » que son estadas revisadas :',
	'reviewedversions-list' => "La lista que seguís conten {{PLURAL:$2|la sola version|de versions}} de « [[:$1]] » {{PLURAL:$2|qu'es estada revisada|que son estadas revisadas}} :",
	'reviewedversions-review' => "Revisada lo ''$1'' per $2",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'reviewedversions-page' => 'ପୃଷ୍ଠା ନାମ:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'reviewedversions-page' => 'Blatt-Naame:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'reviewedversions' => 'Wersje oznaczone',
	'reviewedversions-leg1' => 'Pokaż oznaczone wersje strony',
	'reviewedversions-page' => 'Nazwa strony:',
	'reviewedversions-none' => '„[[:$1]]” nie posiada wersji oznaczonych.',
	'reviewedversions-list' => '{{PLURAL:$2|Wersja|Wersje}} strony „[[:$1]]”, {{PLURAL:$2|która została oznaczona|które zostały oznaczone:}}',
	'reviewedversions-review' => '<i>$1</i>, oznaczona przez $2',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'reviewedversions' => 'Version revisionà',
	'reviewedversions-leg1' => 'Fé na lista dle version aprovà ëd na pàgina',
	'reviewedversions-page' => 'Nòm dla pàgina',
	'reviewedversions-none' => "[[:$1]] a l'ha pa gnun-a version revisionà.",
	'reviewedversions-list' => "Costa-sì a l'é na lista ëd version ëd {{PLURAL:$2|na revision|le revision}} ëd [[:$1]] ch'a {{PLURAL:$2|l'é stàita|son ëstàite}}  revisionà:",
	'reviewedversions-review' => 'Revisionà dël <i>$1</i> da $2',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'reviewedversions-page' => 'د مخ نوم:',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'reviewedversions' => 'Edições revistas',
	'reviewedversions-leg1' => 'Listar as edições revistas de uma página',
	'reviewedversions-page' => 'Nome da página:',
	'reviewedversions-none' => '[[:$1]] não tem edições revistas.',
	'reviewedversions-list' => 'Encontra abaixo {{PLURAL:$2|a única edição|uma lista das edições}} da página [[:$1]], que {{PLURAL:$2|foi revista|foram revistas}}:',
	'reviewedversions-review' => 'Revista às <i>$1</i> por $2',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'reviewedversions' => 'Versões revisadas',
	'reviewedversions-leg1' => 'Listar as edições analisadas de uma página',
	'reviewedversions-page' => 'Título da página:',
	'reviewedversions-none' => '[[:$1]] não possui edições analisadas.',
	'reviewedversions-list' => 'A seguir, uma lista {{PLURAL:$2|da única edição de|das edições de}} "[[:$1]]" que {{PLURAL:$2|foi analisada|foram analisadas}}:',
	'reviewedversions-review' => 'Analisada às <i>$1</i> por $2',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'reviewedversions' => 'Versiuni revizuite',
	'reviewedversions-leg1' => 'Afișează reviziile revizuite pentru o pagină',
	'reviewedversions-page' => 'Numele paginii:',
	'reviewedversions-none' => '"[[:$1]]" nu are revizii revizuite.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'reviewedversions' => 'Revisiune reviste',
	'reviewedversions-leg1' => "Liste de le revisiune riviste pe 'na pàgene",
	'reviewedversions-page' => "Nome d'a vôsce:",
	'reviewedversions-none' => '"[[:$1]]" non ge tène revisiune de rivisitaminde.',
	'reviewedversions-list' => "'A seguende jè 'a liste de {{PLURAL:$2|'na sola revisione|revisiune}} de [[:$1]] ca {{PLURAL:$2|ha|onne}} state reviste:",
	'reviewedversions-review' => 'Riviste sus a <i>$1</i> da $2',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'reviewedversions' => 'Проверенные версии',
	'reviewedversions-leg1' => 'Список проверенных версий страницы',
	'reviewedversions-page' => 'Название страницы:',
	'reviewedversions-none' => '«[[:$1]]» не имеет проверенных версий.',
	'reviewedversions-list' => '{{PLURAL:$2|Была проверена следующая версия|Были проверены следующие версии}} страницы «[[:$1]]»:',
	'reviewedversions-review' => 'Проверена <i>$1</i> участником $2',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'reviewedversions' => 'Рецензованы верзії',
	'reviewedversions-leg1' => 'Список перевіреных ревізій сторінкы',
	'reviewedversions-page' => 'Назва сторінкы:',
	'reviewedversions-none' => '«[[:$1]]» не має перевіреных ревізій.',
	'reviewedversions-list' => 'Тото є список {{PLURAL:$2|єдина ревізія|ревізій}} сторінкы [[:$1]], {{PLURAL:$2|котра не была|котры не были}} перевірены:',
	'reviewedversions-review' => 'Перевірена <i>$1</i> хоснователём $2',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'reviewedversions-page' => 'पृष्ठ-नाम :',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'reviewedversions' => 'Тургутуллубут барыллара',
	'reviewedversions-leg1' => 'Сирэй ырытыллыбыт торумнарын испииһэгэ',
	'reviewedversions-page' => 'Сирэй аата:',
	'reviewedversions-none' => '"[[:$1]]" көрүллүбүт/бэрэбиэркэлэммит торумнара суох.',
	'reviewedversions-list' => '"[[:$1]]" сирэй {{PLURAL:$2|бу барыла ырытыллыбыт|бу барыллара ырытыллыбыттар}}:',
	'reviewedversions-review' => '$2 кыттааччы ырыппыт <i>$1</i>',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'reviewedversions-page' => 'Nùmene pàgina:',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'reviewedversions-page' => 'Nnomu dâ pàggina:',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'reviewedversions' => 'නිරීක්ෂණය කෙරූ අනුවාද',
	'reviewedversions-leg1' => 'පිටුවක් සඳහා නිරීක්ෂණය කෙරූ සංශෝධන ලැයිස්තුගත කරන්න',
	'reviewedversions-page' => 'පිටු නාමය:',
	'reviewedversions-none' => '"[[:$1]]" සතුව නිරීක්ෂණය කෙරූ සංශෝධන නොමැත.',
	'reviewedversions-review' => '<i>$1</i>හීදී $2 විසින් නිරීක්ෂණය කරන ලදී',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'reviewedversions' => 'Zobraziť stabilné verzie',
	'reviewedversions-leg1' => 'Zoznam skontrolovaných verzií stránky',
	'reviewedversions-page' => 'Názov stránky',
	'reviewedversions-none' => '[[:$1]] nemá skontrolované verzie.',
	'reviewedversions-list' => 'Nasleduje zoznam {{PLURAL:$2|s jedinou revíziou|revízií}} stránky [[:$1]], {{PLURAL:$2|ktorá bola skontrolovaná|ktoré boli skontrolované}}:',
	'reviewedversions-review' => 'Skontroloval <i>$1</i> $2',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'reviewedversions' => 'Pregledane različice',
	'reviewedversions-leg1' => 'Navedi pregledane redakcije za stran',
	'reviewedversions-page' => 'Naslov strani:',
	'reviewedversions-none' => '»[[:$1]]« nima pregledanih redakcij.',
	'reviewedversions-list' => 'Sledi seznam {{PLURAL:$2|redakcije|redakcij}} strani [[:$1]], ki {{PLURAL:$2|je bila pregledana|sta bili pregledani|so bile pregledane}}:',
	'reviewedversions-review' => 'Pregledano <i>$1</i> s strani $2',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Charmed94
 * @author Millosh
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'reviewedversions' => 'Прегледана издања',
	'reviewedversions-leg1' => 'Списак прегледаних ревизија за страну',
	'reviewedversions-page' => 'Назив странице:',
	'reviewedversions-none' => '"[[:$1]]" нема прегледаних ревизија.',
	'reviewedversions-list' => 'Следи списак {{PLURAL:$2|једине ревизије|ревизија}} из [[:$1]], {{PLURAL:$2|која је прегледана|које су прегледане}}:',
	'reviewedversions-review' => 'Прегледано на <i>$1</i> од стране $2',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'reviewedversions' => 'Pregledana izdanja',
	'reviewedversions-leg1' => 'Spisak pregledanih verzija za stranu.',
	'reviewedversions-page' => 'Ime stranice:',
	'reviewedversions-none' => '"[[:$1]]" nema pregledanih verzija.',
	'reviewedversions-list' => 'Sledi spisak {{PLURAL:$2|jedine revizije|revizija}} iz [[:$1]], {{PLURAL:$2|koja je pregledana|koje su pregledane}}:',
	'reviewedversions-review' => 'Pregledano na <i>$1</i> od strane saradnika $2.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'reviewedversions' => 'Stoabile Versione bekiekje',
	'reviewedversions-leg1' => 'Lieste fon do wröigede Versione foar n Artikkel',
	'reviewedversions-page' => 'Artikkelnoome:',
	'reviewedversions-none' => '„[[:$1]]“ häd neen wröigede Versione.',
	'reviewedversions-list' => 'Dit is ju Lieste fon {{PLURAL:$2|ju eenpelde Version|do Versione}} fon [[:$1]], {{PLURAL:$2|ju der wröiged wuude|do der wröiged wuuden}}:',
	'reviewedversions-review' => 'wröiged ap n <i>$1</i> truch $2',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'reviewedversions' => 'Témbongkeun vérsi stabil',
	'reviewedversions-page' => 'Judul kaca:',
);

/** Swedish (Svenska)
 * @author Dafer45
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'reviewedversions' => 'Granskade versioner',
	'reviewedversions-leg1' => 'Lista granskade versioner av en sida',
	'reviewedversions-page' => 'Sidnamn:',
	'reviewedversions-none' => '"[[:$1]]" har inga granskade versioner.',
	'reviewedversions-list' => 'Följande är en lista av {{PLURAL:$2|den enda versionen|versioner}} av [[:$1]] som har granskats:',
	'reviewedversions-review' => 'Granskad den <i>$1</i> av $2',
);

/** Tamil (தமிழ்)
 * @author Ulmo
 */
$messages['ta'] = array(
	'reviewedversions-page' => 'பக்கப் பெயர்:',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'reviewedversions' => 'సమీక్షిత కూర్పులు',
	'reviewedversions-leg1' => 'పేజీ యొక్క సమీక్షిత కూర్పులను చూపించు',
	'reviewedversions-page' => 'పేజీ పేరు:',
	'reviewedversions-none' => '"[[:$1]]"కి సమీక్షిత కూర్పులేమీ లేవు.',
	'reviewedversions-list' => 'క్రింద ఇచ్చిన {{PLURAL:$2|కూర్పు|కూర్పులు}}  "[[:$1]]" యొక్క సమీక్షించబడిన {{PLURAL:$2|కూర్పు|కూర్పుల జాబితా}}:',
	'reviewedversions-review' => '<i>$1</i> నాడు $2 సమీక్షించారు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'reviewedversions-page' => 'Naran pájina nian:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'reviewedversions' => 'Нигаристани нусхаҳои пойдор',
	'reviewedversions-leg1' => 'Феҳрист кардани нусхаҳои баррасишудаи як саҳифа',
	'reviewedversions-page' => 'Номи саҳифа:',
	'reviewedversions-none' => '"[[:$1]]" ҳеҷ нусхаи баррасишудае надорад.',
	'reviewedversions-list' => 'Дар зер феҳристи аз нусхаҳои баррасишуда аз [[:$1]]ро мебинед:',
	'reviewedversions-review' => 'Дар <i>$1</i> аз тарафи $2 барраси шудааст',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'reviewedversions' => 'Nigaristani nusxahoi pojdor',
	'reviewedversions-leg1' => 'Fehrist kardani nusxahoi barrasişudai jak sahifa',
	'reviewedversions-page' => 'Nomi sahifa:',
	'reviewedversions-none' => '"[[:$1]]" heç nusxai barrasişudae nadorad.',
	'reviewedversions-list' => 'Dar zer fehristi az nusxahoi barrasişuda az [[:$1]]ro mebined:',
	'reviewedversions-review' => 'Dar <i>$1</i> az tarafi $2 barrasi şudaast',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'reviewedversions-page' => 'ชื่อหน้า:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'reviewedversions' => 'Gözden geçirilen wersiýalary görkez',
	'reviewedversions-leg1' => 'Sahypa üçin gözden geçirilen wersiýalary sanawla',
	'reviewedversions-page' => 'Sahypa ady:',
	'reviewedversions-none' => '"[[:$1]]" sahypasynda hiç hili gözden geçirilen wersiýa ýok.',
	'reviewedversions-list' => 'Aşakdaky sanaw [[:$1]] üçin gözden geçirilen {{PLURAL:$2|ýeke-täk wersiýanyň|wersiýalaryň}} sanawydyr:',
	'reviewedversions-review' => '$2 tarapyndan <i>$1</i> senesinde gözden geçirildi',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'reviewedversions' => 'Nasuring mga bersyon',
	'reviewedversions-leg1' => 'Talaan ng nasuring mga pagbabago para sa isang pahina',
	'reviewedversions-page' => 'Pangalan ng pahina:',
	'reviewedversions-none' => 'Wala pang nasusuring mga pagbabago sa/ang "[[:$1]]".',
	'reviewedversions-list' => 'Ang sumusunod ay isang talaan ng {{PLURAL:$2|nag-iisang pagbabago|mga pagbabago}} sa [[:$1]] na {{PLURAL:$2|may|may mga}} nasuri na:',
	'reviewedversions-review' => 'Nasuri na noong <i>$1</i> ni $2',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'reviewedversions' => 'Gözden geçirilmiş sürümler',
	'reviewedversions-leg1' => 'Bir sayfa için gözden geçirilmiş revizyonları listele',
	'reviewedversions-page' => 'Sayfa adı:',
	'reviewedversions-none' => '"[[:$1]]" hiç gözden geçirilmiş revizyona sahip değil.',
	'reviewedversions-list' => 'Sıradaki, [[:$1]] için gözden geçirilmiş {{PLURAL:$2|tek revizyonun|revizyonların}} bir listesidir:',
	'reviewedversions-review' => '$2 tarafından <i>$1</i> tarihinde gözden geçirildi',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'reviewedversions' => 'Рецензовані версії',
	'reviewedversions-leg1' => 'Список перевірених версій сторінки',
	'reviewedversions-page' => 'Назва сторінки:',
	'reviewedversions-none' => '«[[:$1]]» не має перевірених версій.',
	'reviewedversions-list' => '{{PLURAL:$2|Лише одна версія сторінки «[[:$1]]» була перевірена|Такі версії сторінки «[[:$1]]» були перевірені}}:',
	'reviewedversions-review' => 'Перевірена <i>$1</i> користувачем $2',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'reviewedversions' => 'Version riesaminà',
	'reviewedversions-leg1' => 'Elenca le version riesaminà de na pagina',
	'reviewedversions-page' => 'Nome de la pagina:',
	'reviewedversions-none' => '"[[:$1]]" no la gà version riesaminà.',
	'reviewedversions-list' => "Qua soto ghe xe {{PLURAL:$2|l'unica version|la lista de le version}} de [[:$1]] che {{PLURAL:$2|la|le}} xe stà riesaminà:",
	'reviewedversions-review' => 'Riesaminà el <i>$1</i> da $2',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'reviewedversions' => 'kodvdud versijad',
	'reviewedversions-leg1' => 'Lehtpolen kodvdud versijoiden nimikirjutez',
	'reviewedversions-page' => 'Lehtpolen nimi:',
	'reviewedversions-none' => '"[[:$1]]"-lehtpolel ei ole kodvdud versijoid',
	'reviewedversions-list' => 'Naku om nimikirjutez, kudambas om [[:$1]]-lehtpolen {{PLURAL:$2|üksjäine kodvdud redakcii|kodvdud redakcijoid}}',
	'reviewedversions-review' => 'Om kodvdud datal <i>$1</i> $2-arvostelijal',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'reviewedversions' => 'Phiên bản đã duyệt',
	'reviewedversions-leg1' => 'Liệt kê những bản đã được duyệt của một trang',
	'reviewedversions-page' => 'Tên trang:',
	'reviewedversions-none' => '"[[:$1]]" không có bản nào được duyệt.',
	'reviewedversions-list' => 'Dưới đây là danh sách {{PLURAL:$2|phiên bản|các phiên bản}} của [[:$1]] đã được duyệt:',
	'reviewedversions-review' => 'Đã được $2 duyệt vào <i>$1</i>',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'reviewedversions' => 'Logön fomamis fümöfik',
	'reviewedversions-leg1' => 'Lisedön padafomamis pekrütöl',
	'reviewedversions-page' => 'Nem pada:',
	'reviewedversions-none' => '"[[:$1]]" no labon fomamis pekrütöl.',
	'reviewedversions-list' => 'Ekö! lised fomamas ya pekrütölas pada: [[:$1]]:',
	'reviewedversions-review' => 'Pekrüton tü <i>$1</i> fa geban: $2',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'reviewedversions-page' => 'בלאט נאמען:',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'reviewedversions' => '穩定版',
	'reviewedversions-leg1' => '列示一版複審過嘅修訂',
	'reviewedversions-page' => '版名',
	'reviewedversions-none' => '[[:$1]]無複審過嘅修訂。',
	'reviewedversions-list' => '下面係[[:$1]]已經複審過嘅修訂一覽:',
	'reviewedversions-review' => '響<i>$1</i>複審過',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Hydra
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'reviewedversions' => '已复审版本',
	'reviewedversions-leg1' => '列出一个页面的已复审修订',
	'reviewedversions-page' => '页面名称：',
	'reviewedversions-none' => '“[[:$1]]”没有已复审的修订。',
	'reviewedversions-list' => '下面列出了[[:$1]]的{{PLURAL:$2|已|已}}复审{{PLURAL:$2|修订|修订}}：',
	'reviewedversions-review' => '由$2在$1时复审',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Horacewai2
 * @author Liangent
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'reviewedversions' => '穩定版本',
	'reviewedversions-leg1' => '列示一版已複審的修訂',
	'reviewedversions-page' => '頁面名',
	'reviewedversions-none' => '[[:$1]]沒有已複審過的修訂。',
	'reviewedversions-list' => '以下是[[:$1]]的{{PLURAL:$2|此唯一|此}}版本{{PLURAL:$2|已|已}}複審的修訂列表：',
	'reviewedversions-review' => '由$2於<i>$1</i>進行了複審',
);

