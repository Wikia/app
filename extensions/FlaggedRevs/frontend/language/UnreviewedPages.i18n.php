<?php
/**
 * Internationalisation file for FlaggedRevs extension, section UnreviewedPages
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'unreviewedpages' => 'Unreviewed pages',
	'unreviewedpages-legend' => 'List unreviewed content pages',
	'unreviewedpages-category' => 'Category:',
	'unreviewedpages-diff' => 'review',
	'unreviewedpages-unwatched' => '(unwatched)',
	'unreviewedpages-watched' => '($1 active {{PLURAL:$1|user|users}} watching)',
	'unreviewedpages-list' => 'This page lists content pages that have \'\'not\'\' yet been [[{{MediaWiki:Validationpage}}|reviewed]] to the specified level.',
	'unreviewedpages-none' => 'There are currently no pages meeting these criteria',
	'unreviewedpages-viewing' => '(under review)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hour|hours}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|day|days}})',
	'unreviewedpages-recent' => '(less than 1 hour)',
);

/** Message documentation (Message documentation)
 * @author Aaron Schulz
 * @author Darth Kule
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'unreviewedpages' => '{{Flagged Revs}}
Name of the [[Special:UnreviewedPages]] page, which lists out pages lacking a stable version.',
	'unreviewedpages-legend' => '{{Flagged Revs}}
{{Identical|Content page}}
Used on the page [[Special:UnreviewedPages]].
Note that "content pages" are any page that *can* be reviewed.',
	'unreviewedpages-category' => '{{Flagged Revs}}
{{Identical|Category}}
Used on the page [[Special:UnreviewedPages]].',
	'unreviewedpages-diff' => '{{Flagged Revs}}
{{Identical|Review}}
Used on the page [[Special:UnreviewedPages]].',
	'unreviewedpages-unwatched' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].',
	'unreviewedpages-watched' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].
* $1 is the number of active users that have the page on their watchlist
Note that "active" is based roughly on logging in and out',
	'unreviewedpages-list' => '{{Flagged Revs}}
{{Identical|Content page}}

Parameters:
* $1 - (optional) Number of items in the list, to be used with PLURAL, when unavoidable.',
	'unreviewedpages-none' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].',
	'unreviewedpages-viewing' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].
Message indicates that someone is looking at this pages for review right now.',
	'unreviewedpages-hours' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].
*$1 Number of hours',
	'unreviewedpages-days' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].
* $1 Number of days',
	'unreviewedpages-recent' => '{{Flagged Revs}}
Used on the page [[Special:UnreviewedPages]].',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'unreviewedpages' => 'Nie-beoordeelde bladsye',
	'unreviewedpages-legend' => 'Lys beoordeelde inhoud bladsye',
	'unreviewedpages-category' => 'Kategorie:',
	'unreviewedpages-diff' => 'kontrole',
	'unreviewedpages-unwatched' => '(op geen dophoulys nie)',
	'unreviewedpages-watched' => '($1 aktiewe {{PLURAL:$1|gebruiker het|gebruikers het}} hierdie bladsy op {{PLURAL:$1|sy|hul}} dophoulys)',
	'unreviewedpages-none' => 'Daar is tans geen bladsye wat aan die kriteria voldoen nie',
	'unreviewedpages-viewing' => '(onder hersiening)',
	'unreviewedpages-hours' => '({{PLURAL:$1|een uur|$1 ure}})',
	'unreviewedpages-days' => '({{PLURAL:$1|een dag|$1 dae}})',
	'unreviewedpages-recent' => '(minder as 1 uur)',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'unreviewedpages-viewing' => '(Në shqyrtim)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|orë|orë}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|ditë|ditët}})',
	'unreviewedpages-recent' => '(Më pak se 1 orë)',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'unreviewedpages-category' => 'መደብ:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'unreviewedpages' => 'Pachinas no revisatas',
	'unreviewedpages-legend' => 'Lista de pachinas de conteniu no revisatas',
	'unreviewedpages-category' => 'Categoría:',
	'unreviewedpages-diff' => 'revisar',
	'unreviewedpages-unwatched' => '(no cosirata)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|usuario|usuarios}} activos cosirando)',
	'unreviewedpages-list' => "Ista pachina amuestra os articlos que no s'han revisato dica o livel especificato.",
	'unreviewedpages-none' => 'No bi ha actualment garra pachina que cumpla ixos criterios',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'unreviewedpages' => 'صفحات غير مراجعة',
	'unreviewedpages-legend' => 'عرض صفحات المحتوى غير المراجعة',
	'unreviewedpages-category' => 'التصنيف:',
	'unreviewedpages-diff' => 'راجع',
	'unreviewedpages-unwatched' => '(غير مراقبة)',
	'unreviewedpages-watched' => '({{PLURAL:$1|لا مستخدمون نشطون يراقبون|مستخدم واحد نشط يراقب|مستخدمان نشطان يراقبان|$1 مستخدمين نشطين يراقبون|$1 مستخدمًا نشطًا يراقبون|$1 مستخدم نشط يراقبون}})',
	'unreviewedpages-list' => "تسرد هذه الصفحة صفحات المحتوى التي '''لم''' [[{{MediaWiki:Validationpage}}|تراجع]] بعد إلى المستوى المحدد.",
	'unreviewedpages-none' => 'لا توجد صفحات بهذه المواصفات حاليا',
	'unreviewedpages-viewing' => '(تحت المراجعة)',
	'unreviewedpages-hours' => '({{PLURAL:$1||ساعة واحد|ساعتان|$1 ساعات|$1 ساعة}})',
	'unreviewedpages-days' => '({{PLURAL:$1||يوم واحد|يومان|$1 أيام|$1 يومًا|$1 يوم}})',
	'unreviewedpages-recent' => '(أقل من ساعة واحدة)',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'unreviewedpages-category' => 'ܣܕܪܐ:',
	'unreviewedpages-diff' => 'ܬܢܝ',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ܫܥܬܐ|ܫܥܬ̈ܐ}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|ܝܘܡܐ|ܝܘܡܬ̈ܐ}})',
	'unreviewedpages-recent' => '(ܒܨܝܪ ܡܢ ܚܕܐ ܫܥܬܐ)',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'unreviewedpages' => 'صفحات غير مراجعة',
	'unreviewedpages-legend' => 'عرض صفحات المحتوى غير المراجعة',
	'unreviewedpages-category' => 'التصنيف:',
	'unreviewedpages-diff' => 'راجع',
	'unreviewedpages-unwatched' => '(غير مراقبة)',
	'unreviewedpages-watched' => '({{PLURAL:$1|لا مستخدمون نشطون يراقبون|مستخدم واحد نشط يراقب|مستخدمان نشطان يراقبان|$1 مستخدمين نشطين يراقبون|$1 مستخدمًا نشطًا يراقبون|$1 مستخدم نشط يراقبون}})',
	'unreviewedpages-list' => 'هذه الصفحه تعرض صفحات المحتوى التى لم تتم مراجعتها لمستوى المحدد.',
	'unreviewedpages-none' => 'لا توجد صفحات بهذه المواصفات حاليا',
	'unreviewedpages-viewing' => '(تحت المراجعة)',
	'unreviewedpages-hours' => '({{PLURAL:$1||ساعه واحد|ساعتان|$1 ساعات|$1 ساعة}})',
	'unreviewedpages-days' => '({{PLURAL:$1||يوم واحد|يومان|$1 أيام|$1 يومًا|$1 يوم}})',
	'unreviewedpages-recent' => '(أقل من ساعه واحدة)',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'unreviewedpages' => 'Páxines non revisaes',
	'unreviewedpages-category' => 'Categoría:',
	'unreviewedpages-diff' => 'revisar',
	'unreviewedpages-list' => "Esta páxina llista les páxines de conteníu qu'entá ''nun'' se [[{{MediaWiki:Validationpage}}|revisaron]] al nivel conseñáu.",
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'unreviewedpages-category' => 'Kateqoriya:',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'unreviewedpages' => 'صفحات بی بازبینی',
	'unreviewedpages-legend' => 'لیست کن صفحات محتوا بی بازبینی',
	'unreviewedpages-category' => 'دسته:',
	'unreviewedpages-diff' => 'بازبینی',
	'unreviewedpages-unwatched' => '(نه چارگ)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|user|کابران}} چارگ بیت)',
	'unreviewedpages-list' => 'ای صفحه مقالاتی که بازبینی نه بیتگن لیست کن.',
	'unreviewedpages-none' => 'هنو گو این معیارآن صفحه ای نیست',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'unreviewedpages-category' => 'Kategorya:',
	'unreviewedpages-diff' => 'Mga pagbabàgo',
);

/** Belarusian (Беларуская)
 * @author Хомелка
 */
$messages['be'] = array(
	'unreviewedpages' => 'Неправераныя старонкі',
	'unreviewedpages-legend' => 'Пералік неправераных старонак',
	'unreviewedpages-category' => 'Катэгорыя:',
	'unreviewedpages-diff' => 'праверыць',
	'unreviewedpages-unwatched' => '(не сочаць)',
	'unreviewedpages-watched' => '({{PLURAL:$1|сочыць $1 актыўны ўдзельнік|сочыць $1 актыўных удзельніка|сочаць $1 актыўных удзельнікаў}})',
	'unreviewedpages-list' => 'На гэтай старонцы пералічаны артыкулы, якія не былі ацэненыя на паказаны ўзровень.',
	'unreviewedpages-none' => 'У сапраўдны момант няма старонак, якія задавальняюць названым умовам',
	'unreviewedpages-viewing' => '(правяраецца)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|гадзіну|гадзіны|гадзін}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|дзень|дня|дзён}})',
	'unreviewedpages-recent' => '(Менш 1 гадзіны)',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'unreviewedpages' => 'Неправераныя старонкі',
	'unreviewedpages-legend' => 'Сьпіс неправераных старонак',
	'unreviewedpages-category' => 'Катэгорыя:',
	'unreviewedpages-diff' => 'праверыць',
	'unreviewedpages-unwatched' => '(не назіраецца)',
	'unreviewedpages-watched' => '({{PLURAL:$1|назірае $1 актыўны ўдзельнік|назіраюць $1 актыўных ўдзельніка|назіраюць $1 актыўных ўдзельнікаў}})',
	'unreviewedpages-list' => 'На гэтай старонцы пададзены сьпіс старонак са зьместам, якія не [[{{MediaWiki:Validationpage}}|рэцэнзаваліся]] на ўказаны ўзровень.',
	'unreviewedpages-none' => 'Зараз няма старонак, якія адпавядаюць гэтым крытэрам',
	'unreviewedpages-viewing' => '(праглядаюцца)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|гадзіна|гадзіны|гадзінаў}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|дзень|дні|дзён}})',
	'unreviewedpages-recent' => '(меней за 1 гадзіну таму)',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Turin
 */
$messages['bg'] = array(
	'unreviewedpages' => 'Нерецензирани страници',
	'unreviewedpages-category' => 'Категория:',
	'unreviewedpages-diff' => 'преглеждане',
	'unreviewedpages-unwatched' => '(ненаблюдавана)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|активен наблюдаващ потребител|активни наблюдаващи потребители}})',
	'unreviewedpages-none' => 'В момента не съществуват страници, отговарящи на дадените изисквания',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|час|часа}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|ден|дни}})',
	'unreviewedpages-recent' => '(по-малко от час)',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'unreviewedpages-category' => 'বিষয়শ্রেণী:',
	'unreviewedpages-diff' => 'পর্যালোচনা',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'unreviewedpages' => "Pajennoù n'int ket bet adwelet",
	'unreviewedpages-legend' => "Rollañ a ra ar pajennoù n'int ket bet adwelet",
	'unreviewedpages-category' => 'Rummad :',
	'unreviewedpages-diff' => 'adwelet',
	'unreviewedpages-unwatched' => '(dievezhiet)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|implijer|implijer}} oberiant o evezhiañ ar bajenn-mañ)',
	'unreviewedpages-list' => "Rollañ a ra ar bajenn-mañ ar pajennoù zo danvez enno ha n'int ket bet [[{{MediaWiki:Validationpage}}|adwelet]] d'al live rekis c'hoazh.",
	'unreviewedpages-none' => "Evit poent n'eus pajenn ebet a glotfe gant an dezverkoù-mañ",
	'unreviewedpages-viewing' => '(o vezañ adwelet)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|eurvezh|eurvezh}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|deiz|deiz}})',
	'unreviewedpages-recent' => "(nebeutoc'h eget 1 eurvezh)",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'unreviewedpages' => 'Neprovjerene stranice',
	'unreviewedpages-legend' => 'Spisak nepregledanih stranica sadržaja',
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'pregled',
	'unreviewedpages-unwatched' => '(nepraćeno)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktivni korisnik|aktivna korisnika|aktivnih korisnika}} pregleda)',
	'unreviewedpages-list' => "Ova stranica prikazuje stranice sadržaja koje još ''nisu'' [[{{MediaWiki:Validationpage}}|pregledane]] do određenog nivoa.",
	'unreviewedpages-none' => 'Trenutno nema stranica koje zadovoljavaju ove kriterije',
	'unreviewedpages-viewing' => '(u provjeri)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|sat|sata|sati}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dan|dana}})',
	'unreviewedpages-recent' => '(manje od 1 sata)',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Qllach
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'unreviewedpages' => 'Pàgines per revisar',
	'unreviewedpages-legend' => 'Llista de pàgines amb contingut no revisat',
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'revisió',
	'unreviewedpages-unwatched' => '(no vigilat)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|usuari|usuaris}} actius vigilant)',
	'unreviewedpages-list' => "Aquesta pàgina llista les pàgines de contingut que '''no''' han estat [[{{MediaWiki:Validationpage}}|revisades]] al nivell indicat.",
	'unreviewedpages-none' => 'En aquest moment no hi ha pàgines que compleixin aquests criteris',
	'unreviewedpages-viewing' => '(sota revisió)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hora|hores}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dia|dies}})',
	'unreviewedpages-recent' => "(menys d'una hora)",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'unreviewedpages-category' => 'Кадегар:',
	'unreviewedpages-diff' => 'хьажа',
	'unreviewedpages-unwatched' => '(терго йац)',
	'unreviewedpages-watched' => '({{PLURAL:$1|терго йеш $1 жигар декъашхо|терго йеш $1 жигар декъашхой}})',
	'unreviewedpages-viewing' => '(талламяхь йу)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|сахьат|сахьат}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|де|де}})',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'unreviewedpages-category' => 'پۆل:',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'unreviewedpages' => 'Neposouzené stránky',
	'unreviewedpages-legend' => 'Seznam neposouzených obsahových stránek',
	'unreviewedpages-category' => 'Kategorie:',
	'unreviewedpages-diff' => 'kontrola',
	'unreviewedpages-unwatched' => '(nesledované)',
	'unreviewedpages-watched' => '({{PLURAL:$1|sleduje|sledují|sleduje}} $1 {{PLURAL:$1|aktivní uživatel|aktivní uživatelé|aktivních uživatelů}})',
	'unreviewedpages-list' => 'Tato stránka obsahuje články, které nebyly posouzeny do určené úrovně.',
	'unreviewedpages-none' => 'Momentálně neexistují žádné stránky splňující tato kritéria.',
	'unreviewedpages-viewing' => '(kontroluje se)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hodina|hodiny|hodin}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|den|dny|dní}})',
	'unreviewedpages-recent' => '(méně něž hodina)',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'unreviewedpages-category' => 'катигорі́ꙗ :',
);

/** Danish (Dansk)
 * @author Froztbyte
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-unwatched' => '(uovervåget)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|time|timer}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dag|dage}})',
	'unreviewedpages-recent' => '(mindre end 1 time)',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Merlissimo
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'unreviewedpages' => 'Ungesichtete Seiten',
	'unreviewedpages-legend' => 'Liste ungesichteter Seiten',
	'unreviewedpages-category' => 'Kategorie:',
	'unreviewedpages-diff' => 'sichten',
	'unreviewedpages-unwatched' => '(unbeobachtet)',
	'unreviewedpages-watched' => '(von $1 {{PLURAL:$1|aktivem Benutzer|aktiven Benutzern}} beobachtet)',
	'unreviewedpages-list' => 'Diese Spezialseite zeigt Seiten, die bisher noch nicht in der angegebenen Stufe [[{{MediaWiki:Validationpage}}|markiert]] wurden.',
	'unreviewedpages-none' => 'Es gibt keine Seiten, die den eingegebenen Kriterien entsprechen.',
	'unreviewedpages-viewing' => '(wird gesichtet)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|Stunde|Stunden}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|Tag|Tage}})',
	'unreviewedpages-recent' => '(weniger als 1 Stunde)',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'unreviewedpages' => 'Ripelî ke kontrol nibiyê',
	'unreviewedpages-legend' => 'Listeyê tedeesteyî ke kontrol nibe',
	'unreviewedpages-category' => 'Kategorî:',
	'unreviewedpages-diff' => 'kontrol bike',
	'unreviewedpages-unwatched' => '(seyr nibiye)',
	'unreviewedpages-watched' => '($1 activ {{PLURAL:$1|karber|karberî}} ho seyr keno)',
	'unreviewedpages-list' => 'no pel, sewiyeya ke waziyaya goreyê aye sewiya. pelê muhtewayê ke çım ser nêçariyayê liste keno.',
	'unreviewedpages-none' => 'nê kriteran de peli çini',
	'unreviewedpages-viewing' => '(kontrol beno)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|seet|seeti}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|roc|roci}})',
	'unreviewedpages-recent' => '(1 seet ra kêm)',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'unreviewedpages' => 'Njepśeglědane boki',
	'unreviewedpages-legend' => 'Lisćina njepśeglědanych wopśimjeśowych bokow',
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'pśeglědaś',
	'unreviewedpages-unwatched' => '(njewobglědowany)',
	'unreviewedpages-watched' => '(wót $1 {{PLURAL:$1|aktiwnego wužywarja|aktiwneju wužywarjowu|aktiwnych wužywarjow|aktiwnych wužywarjow}} wobglědowany)',
	'unreviewedpages-list' => "Toś ten bok nalistujo wopśimjeśowe boki, kótarež hyšći ''njej''su se [[{{MediaWiki:Validationpage}}|pśeglědali]] na pódanej rowninje.",
	'unreviewedpages-none' => 'Njejsu tuchylu žedne boki, kótarež wótpówěduju toś tym kriterijam',
	'unreviewedpages-viewing' => '(pśeglědujo se)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|goźina|goźinje|goźiny|goźin}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|źeń|dnja|dny|dnjow}})',
	'unreviewedpages-recent' => '(mjenjej ako 1 goźina)',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Dead3y3
 * @author Omnipaedista
 */
$messages['el'] = array(
	'unreviewedpages' => 'Σελίδες χωρίς κριτική',
	'unreviewedpages-legend' => 'Απαρίθμηση σελίδων περιεχομένου χωρίς κριτική',
	'unreviewedpages-category' => 'Κατηγορία:',
	'unreviewedpages-diff' => 'κριτική',
	'unreviewedpages-unwatched' => '(δεν παρακολουθείται)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|ενεργός χρήστης παρακολουθεί|ενεργοί χρήστες παρακολουθούν}})',
	'unreviewedpages-list' => 'Αυτή η σελίδα απαριθμεί σελίδες περιεχομένων που δεν έχουν κριθεί στο καθορισμένο επίπεδο.',
	'unreviewedpages-none' => 'Αυτή τη στιγμή δεν υπάρχουν σελίδες που να ικανοποιούν αυτά τα κριτήρια',
	'unreviewedpages-viewing' => '(υπό κριτική)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ώρα|ώρες}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|ημέρα|ημέρες}})',
	'unreviewedpages-recent' => '(λιγότερο από 1 ώρα)',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'unreviewedpages' => 'Nereviziitaj paĝoj',
	'unreviewedpages-legend' => 'Listigi nereviziitajn enhavajn paĝojn',
	'unreviewedpages-category' => 'Kategorio:',
	'unreviewedpages-diff' => 'kontrolo',
	'unreviewedpages-unwatched' => '(malatentita)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktiva uzanto|aktivaj uzantoj}} atentas)',
	'unreviewedpages-list' => "Ĉi tiu paĝo montras enhavajn paĝojn kiuj ''ne'' estas [[{{MediaWiki:Validationpage}}|kontrolitaj]] al la petita nivelo.",
	'unreviewedpages-none' => 'Nune neniuj paĝoj kongruas tiun kriterion',
	'unreviewedpages-viewing' => '(kontrolata)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|horo|horoj}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|tago|tagoj}})',
	'unreviewedpages-recent' => '(malpli ol 1 horo)',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Drini
 * @author Locos epraix
 * @author Sanbec
 */
$messages['es'] = array(
	'unreviewedpages' => 'Páginas no revisadas',
	'unreviewedpages-legend' => 'Lista de páginas de contenido no revisadas',
	'unreviewedpages-category' => 'Categoría:',
	'unreviewedpages-diff' => 'revisar',
	'unreviewedpages-unwatched' => '(no vigilado)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|usuario|usuarios}} activos vigilando)',
	'unreviewedpages-list' => "Esta página lista páginas de contenido que aún ''no'' han sido [[{{MediaWiki:Validationpage}}|revisados]] al nivel especificado.",
	'unreviewedpages-none' => 'No hay actualmente páginas que cumplan estos criterios',
	'unreviewedpages-viewing' => '(bajo revisión)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hora|horas}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|día|días}})',
	'unreviewedpages-recent' => '(menos de 1 hora)',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'unreviewedpages' => 'Ülevaatamata leheküljed',
	'unreviewedpages-legend' => 'Ülevaatamata sisulehekülgede loetlemine',
	'unreviewedpages-category' => 'Kategooria:',
	'unreviewedpages-diff' => 'vaata üle',
	'unreviewedpages-unwatched' => '(jälgimata)',
	'unreviewedpages-watched' => '($1 aktiivse {{PLURAL:$1|kasutaja}} jälgitav)',
	'unreviewedpages-list' => 'See lehekülg loetleb sisuleheküljed, mis pole kindlaks määratud tasemeni [[{{MediaWiki:Validationpage}}|ülevaadatud]].',
	'unreviewedpages-none' => 'Sellistele kriteeriumitele vastavad leheküljed puuduvad praegu.',
	'unreviewedpages-viewing' => '(ülevaatusel)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|tund|tundi}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|päev|päeva}})',
	'unreviewedpages-recent' => '(alla 1 tunni)',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'unreviewedpages-category' => 'Kategoria:',
	'unreviewedpages-hours' => '({{PLURAL:$1|Ordu bat|$1 ordu}})',
	'unreviewedpages-days' => '({{PLURAL:$1|Egun bat|$1 egun}})',
	'unreviewedpages-recent' => '(ordu bat baino gutxiago)',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'Chambus',
);

/** Persian (فارسی)
 * @author Huji
 * @author Mardetanha
 * @author Mjbmr
 */
$messages['fa'] = array(
	'unreviewedpages' => 'صفحه‌های بررسی نشده',
	'unreviewedpages-legend' => 'فهرست صفحه‌های بازبینی نشده',
	'unreviewedpages-category' => 'رده:',
	'unreviewedpages-diff' => 'بازبینی',
	'unreviewedpages-unwatched' => '(پیگیری نشده)',
	'unreviewedpages-watched' => '(پیگیری فعال توسط $1 {{PLURAL:$1|کاربر|کاربر}})',
	'unreviewedpages-list' => 'این صفحه فهرستی از صفحاتی را نشان می‌دهد که هنوز تا سطح مشخص شده [[{{MediaWiki:Validationpage}}|بازبینی]] نشده‌اند.',
	'unreviewedpages-none' => 'در حال حاضر صفحه‌ای که با این معیارها سازگار باشد وجود ندارد',
	'unreviewedpages-viewing' => '(در حال بررسی)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ساعت|ساعت}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|روز|روز}})',
	'unreviewedpages-recent' => '(کمتر از ۱ ساعت)',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Mies
 * @author Nike
 * @author Pxos
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'unreviewedpages' => 'Arvioimattomat sivut',
	'unreviewedpages-legend' => 'Luettelo arvioimattomista sisältösivuista',
	'unreviewedpages-category' => 'Luokka',
	'unreviewedpages-diff' => 'arvioi',
	'unreviewedpages-unwatched' => '(tarkkailematon)',
	'unreviewedpages-watched' => '($1 aktiivisen {{PLURAL:$1|käyttäjän}} tarkkailema)',
	'unreviewedpages-list' => 'Tämä on luettelo sisältösivuista, joita ei ole vielä [[{{MediaWiki:Validationpage}}|arvioitu]] tietylle tasolle.',
	'unreviewedpages-none' => 'Tällä hetkellä ei ole sivuja, jotka täyttävät nämä ehdot',
	'unreviewedpages-viewing' => '(arvioitavana)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|tunti|tuntia}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|päivä|päivää}})',
	'unreviewedpages-recent' => '(alle yksi tunti)',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'unreviewedpages' => 'Pages non revues',
	'unreviewedpages-legend' => 'Liste des pages de contenu non révisées',
	'unreviewedpages-category' => 'Catégorie :',
	'unreviewedpages-diff' => 'révision',
	'unreviewedpages-unwatched' => '(non suivie)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|utilisateur actif suit|utilisateurs actifs suivent}} cette page)',
	'unreviewedpages-list' => "Cette page liste les pages de contenu qui n'ont ''pas'' été [[{{MediaWiki:Validationpage}}|révisées]] avec le niveau spécifié.",
	'unreviewedpages-none' => "Aucune page correspondant à ces critères n'a été trouvée",
	'unreviewedpages-viewing' => '(en révision)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|heure|heures}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|jour|jours}})',
	'unreviewedpages-recent' => "(moins d'une heure)",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'unreviewedpages' => 'Pâges pas revues',
	'unreviewedpages-legend' => 'Lista de les pâges de contegnu pas revues',
	'unreviewedpages-category' => 'Catègorie :',
	'unreviewedpages-diff' => 'revêre',
	'unreviewedpages-unwatched' => '(pas siuvua)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|usanciér actif siut|usanciérs actifs siuvont}} cela pâge)',
	'unreviewedpages-list' => "Ceta pâge liste les pâges de contegnu qu’ont ''pas'' étâ [[{{MediaWiki:Validationpage}}|revues]] avouéc lo nivél spècefiâ.",
	'unreviewedpages-none' => 'Ora, y at gins de pâge que corrèspond a cetos critèros',
	'unreviewedpages-viewing' => '(en rèvision)',
	'unreviewedpages-hours' => '($1 hor{{PLURAL:$1|a|es}})',
	'unreviewedpages-days' => '($1 jorn{{PLURAL:$1||s}})',
	'unreviewedpages-recent' => '(muens de yona hora)',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'unreviewedpages-category' => 'Kategory:',
);

/** Irish (Gaeilge)
 * @author Moilleadóir
 */
$messages['ga'] = array(
	'unreviewedpages-category' => 'Catagóir:',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'unreviewedpages' => 'Páxinas sen revisar',
	'unreviewedpages-legend' => 'Listar as páxinas con contido sen revisar',
	'unreviewedpages-category' => 'Categoría:',
	'unreviewedpages-diff' => 'revisión',
	'unreviewedpages-unwatched' => '(sen vixiar)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|usuario activo|usuarios activos}} vixiando)',
	'unreviewedpages-list' => "Esta páxina lista as páxinas de contido que aínda ''non'' foron [[{{MediaWiki:Validationpage}}|revisadas]] co nivel especificado.",
	'unreviewedpages-none' => 'Actualmente non hai páxinas que coincidan con ese criterio',
	'unreviewedpages-viewing' => '(en revisión)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hora|horas}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|día|días}})',
	'unreviewedpages-recent' => '(menos dunha hora)',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'unreviewedpages' => 'Ἀνεπιθεώρηται δέλτοι',
	'unreviewedpages-legend' => 'Κατάλογος ἀνεπισκοπήτων δέλτων περιεχομένων',
	'unreviewedpages-category' => 'Κατηγορία:',
	'unreviewedpages-diff' => 'ἐπισκόπησις',
	'unreviewedpages-unwatched' => '(ἀνεφορωμένη)',
	'unreviewedpages-viewing' => '(ὑπὸ ἐπισκόπησιν)',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'unreviewedpages' => 'Syte, wu nonig vum Fäldhieter gsäh sin',
	'unreviewedpages-legend' => 'Lischt vu Syte, wu nonig vum Fäldhieter gsäh sin',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'aaluege',
	'unreviewedpages-unwatched' => 'nid beobachtet',
	'unreviewedpages-watched' => '(vu $1 {{PLURAL:$1|Benutzer|Benutzer}} beobachtet)',
	'unreviewedpages-list' => 'Die Spezialsyte zeigt Syte, wu nonig [[{{MediaWiki:Validationpage}}|markiert]] wore sin uf däm Nivo, wu aagee isch.',
	'unreviewedpages-none' => 'S git kei Syte mit däne Kriterie, wu yygee wore sin.',
	'unreviewedpages-viewing' => '(wird prieft)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|Stund|Stunde}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|Tag|Täg}})',
	'unreviewedpages-recent' => '(weniger wie ei Stund)',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'unreviewedpages-category' => 'Rukuni:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'unreviewedpages-category' => 'Mahele:',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'unreviewedpages' => 'דפים שלא נסקרו',
	'unreviewedpages-legend' => 'רשימה של דפי תוכן שלא נסקרו',
	'unreviewedpages-category' => 'קטגוריה:',
	'unreviewedpages-diff' => 'לסקור',
	'unreviewedpages-unwatched' => 'לא במעקב',
	'unreviewedpages-watched' => '({{PLURAL:$1|משתמש פעיל אחד עוקב|$1 משתמשים פעילים עוקבים}})',
	'unreviewedpages-list' => 'רשימת דפי תוכן שטרם [[{{MediaWiki:Validationpage}}|נסקרו]] ברמה המוגדרת.',
	'unreviewedpages-none' => 'אין כרגע דפים המתאימים לאמות המידה האלו',
	'unreviewedpages-viewing' => '(במהלך סקירה)',
	'unreviewedpages-hours' => '({{PLURAL:$1|שעה|$1 שעות|שעתיים}})',
	'unreviewedpages-days' => '({{PLURAL:$1|יום|$1 ימים|יומיים}})',
	'unreviewedpages-recent' => '(פחות משעה)',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 */
$messages['hi'] = array(
	'unreviewedpages' => 'परिक्षण ना हुए पन्ने',
	'unreviewedpages-legend' => 'न देखें हुए लेखोंकी सूची बनायें',
	'unreviewedpages-category' => 'श्रेणी:',
	'unreviewedpages-diff' => 'जाँचे',
	'unreviewedpages-unwatched' => '(न देखे हुए)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|सदस्यने|सदस्योंने}} ध्यान रखा हैं)',
	'unreviewedpages-list' => 'यह पन्ना ऐसे लेख दर्शाता हैं जिन्हें जाँचा नहीं गया हैं।',
	'unreviewedpages-none' => 'इस क्राइटेरिआ से मिलने वाले पन्ने नहीं हैं',
	'unreviewedpages-viewing' => '(समिक्षा अंतर्गत)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|घंटा|घंटे}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|दिन|दिन}})',
	'unreviewedpages-recent' => '(१ घंटेसे कम समय)',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 * @author Excaliboor
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'unreviewedpages' => 'Neocijenjene stranice',
	'unreviewedpages-legend' => 'Popis neocijenjenih sadržaja stranica',
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'ocijeni',
	'unreviewedpages-unwatched' => '(nepraćeno)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktivni suradnik|aktivnih suradnika}} prati)',
	'unreviewedpages-list' => 'Ovdje se navode stranice sa sadržajem koje nisu pregledane do određene razine.',
	'unreviewedpages-none' => 'Trenutačno nema stranica koje zadovoljavaju ovim kriterijima',
	'unreviewedpages-viewing' => '(u ocijenjivanju)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|sat|sata|sati}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dan|dana}})',
	'unreviewedpages-recent' => '(manje od 1 sat)',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'unreviewedpages' => 'Njepruwowane nastawki',
	'unreviewedpages-legend' => 'Lisćina njepřehladanych wobsahowych stronow',
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'přepruwować',
	'unreviewedpages-unwatched' => '(njewobkedźbowany)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktiwny wužiwar wobkedźbuje|aktiwnaj wužiwarjej wobkedźbujetaj|aktiwni wužiwarjo wobkedźbuja|aktiwnych wužiwarjow wobkedźbuje}})',
	'unreviewedpages-list' => "Tuta strona nalistuje wobsahowe strony, kotrež hišće ''njej''su na podatej runinje [[{{MediaWiki:Validationpage}}|přepruwowane]].",
	'unreviewedpages-none' => 'Tuchwilu žane strony njejsu, kotrež tutym kriterijam wotpowěduja',
	'unreviewedpages-viewing' => '(pruwuje so)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hodźina|hodźinje|hodźiny|hodźin}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dźeń|dnjej|dny|dnjow}})',
	'unreviewedpages-recent' => '(mjenje hač 1 hodźina)',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dj
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Gondnok
 * @author KossuthRad
 * @author Misibacsi
 * @author Samat
 */
$messages['hu'] = array(
	'unreviewedpages' => 'Ellenőrizetlen lapok',
	'unreviewedpages-legend' => 'Nem ellenőrzött lapok listája',
	'unreviewedpages-category' => 'Kategória:',
	'unreviewedpages-diff' => 'ellenőrzés',
	'unreviewedpages-unwatched' => '(nem figyelt)',
	'unreviewedpages-watched' => '({{PLURAL:$1|egy|$1}} aktív szerkesztő figyeli)',
	'unreviewedpages-list' => "Azon lapok, amelyek még ''nem'' lettek [[{{MediaWiki:Validationpage}}| ellenőrizve]] a megadott szinten.",
	'unreviewedpages-none' => 'Jelenleg nincs ezeknek a feltételeknek megfelelő oldal.',
	'unreviewedpages-viewing' => '(ellenőrzés alatt)',
	'unreviewedpages-hours' => '({{PLURAL:$1|egy|$1}} óra)',
	'unreviewedpages-days' => '({{PLURAL:$1|egy|$1}} nap)',
	'unreviewedpages-recent' => '(kevesebb mint egy órája)',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'unreviewedpages' => 'Paginas non revidite',
	'unreviewedpages-legend' => 'Lista de paginas de contento non revidite',
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'revider',
	'unreviewedpages-unwatched' => '(non observate)',
	'unreviewedpages-watched' => '(observate per $1 {{PLURAL:$1|usator|usatores}} active)',
	'unreviewedpages-list' => "Iste pagina lista le paginas de contento que ''non'' ha ancora essite [[{{MediaWiki:Validationpage}}|revidite]] al nivello specificate.",
	'unreviewedpages-none' => 'Al momento il non ha paginas que corresponde a iste criterios',
	'unreviewedpages-viewing' => '(sub revision)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hora|horas}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|die|dies}})',
	'unreviewedpages-recent' => '(minus de un hora)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'unreviewedpages' => 'Halaman yang belum ditinjau',
	'unreviewedpages-legend' => 'Daftar halaman isi yang belum ditinjau',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'tinjau',
	'unreviewedpages-unwatched' => '(tidak dipantau)',
	'unreviewedpages-watched' => '(dipantau $1 {{PLURAL:$1|pengguna|pengguna}} aktif)',
	'unreviewedpages-list' => 'Halaman berikut berisi daftar halaman yang belum [[{{MediaWiki:Validationpage}}|ditinjau]] pada tingkat tertentu.',
	'unreviewedpages-none' => 'Tidak ada halaman yang sesuai dengan kriteria ini',
	'unreviewedpages-viewing' => '(sedang ditinjau)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|jam|jam}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|hari|hari}})',
	'unreviewedpages-recent' => '(kurang dari 1 jam)',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'unreviewedpages-category' => 'Ébéonọr:',
	'unreviewedpages-diff' => 'lèwárí',
	'unreviewedpages-unwatched' => '(ēléghịdị)',
	'unreviewedpages-hours' => '({{PLURAL:$1|àmànì|àmànì}} $1)',
	'unreviewedpages-days' => '({{PLURAL:$1|chi|chi}} $1)',
	'unreviewedpages-recent' => '(bènata àmànì 1)',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'unreviewedpages-category' => 'Kategorio:',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|horo|hori}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dio|dii}})',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'unreviewedpages' => 'Óendurskoðaðar síður',
	'unreviewedpages-category' => 'Flokkur:',
	'unreviewedpages-diff' => 'endurskoða',
	'unreviewedpages-unwatched' => '(án eftirlits)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|klukkustund|klukkustundir}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dagur|dagar}})',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 */
$messages['it'] = array(
	'unreviewedpages' => 'Pagine non revisionate',
	'unreviewedpages-legend' => 'Elenco delle pagine non revisionate',
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'revisiona',
	'unreviewedpages-unwatched' => '(non osservata)',
	'unreviewedpages-watched' => '(osservata da $1 {{PLURAL:$1|utente attivo|utenti attivi}})',
	'unreviewedpages-list' => 'Di seguito sono riportate le pagine che non sono state revisionate al livello specificato.',
	'unreviewedpages-none' => 'Al momento non ci sono pagine che soddisfino i criteri di ricerca.',
	'unreviewedpages-viewing' => '(sotto revisione)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ora|ore}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|giorno|giorni}})',
	'unreviewedpages-recent' => '(meno di 1 ora)',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Ohgi
 */
$messages['ja'] = array(
	'unreviewedpages' => '未査読ページ',
	'unreviewedpages-legend' => '未査読記事を一覧',
	'unreviewedpages-category' => 'カテゴリ:',
	'unreviewedpages-diff' => '査読',
	'unreviewedpages-unwatched' => '(未ウォッチ)',
	'unreviewedpages-watched' => '($1人の活動中の{{PLURAL:$1|利用者}}がウォッチ)',
	'unreviewedpages-list' => 'このページは、指定された水準に達する[[{{MediaWiki:Validationpage}}|査読]]をされていない記事の一覧です。',
	'unreviewedpages-none' => '現時点でこの基準に適合するページはありません',
	'unreviewedpages-viewing' => '(査読中)',
	'unreviewedpages-hours' => '($1 時間)',
	'unreviewedpages-days' => '($1 日)',
	'unreviewedpages-recent' => '(1時間未満)',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'unreviewedpages-category' => 'Klynge:',
	'unreviewedpages-diff' => 'Ændrenger',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'unreviewedpages-category' => 'Kategori',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'unreviewedpages' => 'შეუმოწმებელი გვერდები',
	'unreviewedpages-legend' => 'შეუმოწმებელი სტატიების სია',
	'unreviewedpages-category' => 'კატეგორია:',
	'unreviewedpages-diff' => 'შემოწმება',
	'unreviewedpages-unwatched' => '(არავის კონტროლის სიაში არ არის)',
	'unreviewedpages-watched' => '({{PLURAL:$1|აკონტროლებს $1 აქტიური მომხმარებელი|აკონტროლებენ $1 აქტიური მომხმარებლები}})',
	'unreviewedpages-list' => 'ამ გვერდებზე მოყვანილია შეუფასებელი სტატიევბი.',
	'unreviewedpages-none' => 'ამჟამად არ არის გვერდი, რომელიც შეესაბამება ამ კრიტერიუმებს',
	'unreviewedpages-viewing' => '(მიმდინარეობს შემოწმება)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|საათი|საათი}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|დღე|დღე}})',
	'unreviewedpages-recent' => '(1 საათზე ნაკლები)',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'unreviewedpages' => 'سىن بەرىلمەگەن بەتتەر',
	'unreviewedpages-category' => 'سانات:',
	'unreviewedpages-diff' => 'وزگەرىستەر',
	'unreviewedpages-list' => 'بۇل بەتتە سىن بەرىلمەگەن ماقالالار نە جاڭادان جاسالعان, سىن بەرىلمەگەن, نۇسقالارى بار ماقالار تىزىمدەلىنەدى.',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'unreviewedpages' => 'Сын берілмеген беттер',
	'unreviewedpages-category' => 'Санат:',
	'unreviewedpages-diff' => 'Өзгерістер',
	'unreviewedpages-list' => 'Бұл бетте сын берілмеген мақалалар не жаңадан жасалған, сын берілмеген, нұсқалары бар мақалар тізімделінеді.',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'unreviewedpages' => 'Sın berilmegen better',
	'unreviewedpages-category' => 'Sanat:',
	'unreviewedpages-diff' => 'Özgerister',
	'unreviewedpages-list' => 'Bul bette sın berilmegen maqalalar ne jañadan jasalğan, sın berilmegen, nusqaları bar maqalar tizimdelinedi.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'unreviewedpages' => 'ទំព័រ​ដែល​មិន​ត្រូវ​បាន​មើលឡើងវិញ',
	'unreviewedpages-category' => 'ចំណាត់ថ្នាក់ក្រុម ៖',
	'unreviewedpages-diff' => 'មើលឡើងវិញ',
	'unreviewedpages-unwatched' => '(មិន​ត្រូវ​បាន​តាមដាន)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|អ្នកប្រើប្រាស់|អ្នកប្រើប្រាស់}} កំពុង​តាមដាន)',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'unreviewedpages-category' => 'ವರ್ಗ:',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'unreviewedpages' => '검토되지 않은 문서',
	'unreviewedpages-legend' => '검토되지 않은 문서 목록',
	'unreviewedpages-category' => '분류:',
	'unreviewedpages-diff' => '검토',
	'unreviewedpages-unwatched' => '(주시되지 않음)',
	'unreviewedpages-watched' => '($1명의 활동중인 {{PLURAL:$1|사용자가|사용자들이}} 주시중)',
	'unreviewedpages-list' => '이 특수 문서는 특정한 등급으로 [[{{MediaWiki:Validationpage}}|검토]]되지 않은 문서의 목록을 보여 주고 있습니다.',
	'unreviewedpages-none' => '조건에 맞는 문서가 없습니다.',
	'unreviewedpages-viewing' => '(확인 중)',
	'unreviewedpages-hours' => '($1시간)',
	'unreviewedpages-days' => '($1일)',
	'unreviewedpages-recent' => '(1시간 미만)',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'unreviewedpages-category' => 'Kategorya:',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'unreviewedpages' => 'De noch nit aanjekikte Sigge',
	'unreviewedpages-legend' => 'Leß met de noch nit aanjekikte Sigge em Houp-Appachtemang',
	'unreviewedpages-category' => 'Saachjrupp:',
	'unreviewedpages-diff' => 'nohkike',
	'unreviewedpages-unwatched' => '(en keine Oppassleß)',
	'unreviewedpages-watched' => '({{PLURAL:$1|Eine Metmaacher hät|$1 Metmaacher han|Keine hät}} se en de Opassliß)',
	'unreviewedpages-list' => "Di Leß hee zeich {{PLURAL:$1|di Sigg|Sigge|kein Sigge}}, di noch '''nit''' op dämm aanjejovve Nivoh [[{{MediaWiki:Validationpage}}|nohjekik]] woode sen.",
	'unreviewedpages-none' => 'Mer han jrad kein Sigge för di Ußwahl.',
	'unreviewedpages-viewing' => '(weed nohjekik)',
	'unreviewedpages-hours' => '({{PLURAL:$1|ein Shtund|$1 Shtunde|nit ein Shtund}})',
	'unreviewedpages-days' => '({{PLURAL:$1|eine Daach|$1 Dääsch|nit ens ene Daach}})',
	'unreviewedpages-recent' => '(winnijer wie en Shtund)',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'unreviewedpages-category' => 'Kategorî:',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'unreviewedpages-category' => 'Class:',
);

/** Latin (Latina)
 * @author Omnipaedista
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'circumspectio',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'unreviewedpages' => 'Säit déi net nogekuckt ass',
	'unreviewedpages-legend' => 'Lëscht vun den net nogekuckte Säiten',
	'unreviewedpages-category' => 'Kategorie:',
	'unreviewedpages-diff' => 'iwwerkucken',
	'unreviewedpages-unwatched' => '(net iwwerwaacht)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|Benotzer iwwerwaacht|Benotzer iwwerwaachen}})',
	'unreviewedpages-list' => 'Op dëser Säit sti Säiten déi nach net mam Niveau den uginn ass [[{{MediaWiki:Validationpage}}|nogekuckt]] goufen.',
	'unreviewedpages-none' => 'Et gëtt keng Säiten, déi dene Critèren entspriechen déi Dir uginn hutt',
	'unreviewedpages-viewing' => '(gëtt nogekuckt)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|Stonn|Stonnen}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|Dag|Deeg}})',
	'unreviewedpages-recent' => '(manner wéi 1 Stonn)',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'unreviewedpages' => "Ónbekeke pazjena's",
	'unreviewedpages-legend' => 'Lies mit ónbekeke paasjes',
	'unreviewedpages-category' => 'Categorie:',
	'unreviewedpages-diff' => 'kiek nao',
	'unreviewedpages-unwatched' => '(neet oppe volglies)',
	'unreviewedpages-watched' => '($1 actieve {{PLURAL:$1|gebroeker|gebroekers}} kiekendj)',
	'unreviewedpages-list' => "Dees pazjena tuunt pazjena's die nag ónbekeke zeen toet t aangegaeve nivo.",
	'unreviewedpages-none' => "'t Göf gein paasjes die aan dees kriteria vóldoon",
	'unreviewedpages-viewing' => '(wörd bekeke)',
	'unreviewedpages-hours' => '$1 {{PLURAL:$1|oer|oer}}',
	'unreviewedpages-days' => '$1 {{PLURAL:$1|daag|daag}}',
	'unreviewedpages-recent' => '(mènder es 1 oer)',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Matasg
 */
$messages['lt'] = array(
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'peržiūrėti',
);

/** Literary Chinese (文言)
 * @author Itsmine
 */
$messages['lzh'] = array(
	'unreviewedpages' => '底本',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'unreviewedpages' => 'Непрегледани страници',
	'unreviewedpages-legend' => 'Список на непрегледани статии',
	'unreviewedpages-category' => 'Категорија:',
	'unreviewedpages-diff' => 'преглед',
	'unreviewedpages-unwatched' => '(ненабљудувана)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|активен корисник ја набљудува|активни корисници ја набљудуваат}})',
	'unreviewedpages-list' => "На оваа страница се наведени статии кои сè уште ''не'' се [[{{MediaWiki:Validationpage}}|оценети]] на назначеното ниво.",
	'unreviewedpages-none' => 'Во моментов не постојат страници кои ги задоволуваат овие критериуми',
	'unreviewedpages-viewing' => '(во фаза на проверување)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|час|часа}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|ден|дена}})',
	'unreviewedpages-recent' => '(помалку од 1 час)',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Praveenp
 * @author Sadik Khalid
 * @author Shijualex
 */
$messages['ml'] = array(
	'unreviewedpages' => 'സംശോധനം ചെയ്യാത്ത താളുകൾ',
	'unreviewedpages-legend' => 'ഉള്ളടക്കം സം‌ശോധനം ചെയ്തിട്ടില്ലാത്ത താളുകളുടെ പട്ടിക പ്രദർശിപ്പിക്കുക',
	'unreviewedpages-category' => 'വർഗ്ഗം:',
	'unreviewedpages-diff' => 'പരിശോധന',
	'unreviewedpages-unwatched' => '(ശ്രദ്ധിക്കാത്തവ)',
	'unreviewedpages-watched' => '({{PLURAL:$1|ഒരു സജീവ ഉപയോക്താവ്|$1 സജീവ ഉപയോക്താക്കൾ}} ശ്രദ്ധിക്കുന്നുണ്ട്)',
	'unreviewedpages-list' => "പ്രത്യേക തലം വരെ [[{{MediaWiki:Validationpage}}|സംശോധനം]] ''ചെയ്യാത്ത'' ഉള്ളടക്ക താളുകളുടെ പട്ടികയാണ് ഈ താളിൽ ഉള്ളത്.",
	'unreviewedpages-none' => 'ഈ മാനദണ്ഡം പാലിക്കുന്ന താളുകളൊന്നും നിലവിലില്ല',
	'unreviewedpages-viewing' => '(സംശോധനം ചെയ്യപ്പെടുന്നു)',
	'unreviewedpages-hours' => '({{PLURAL:$1|ഒരു മണിക്കൂർ|$1 മണിക്കൂറുകൾ}})',
	'unreviewedpages-days' => '({{PLURAL:$1|ഒരു ദിവസം|$1 ദിവസങ്ങൾ}})',
	'unreviewedpages-recent' => '(ഒരു മണിക്കൂറിൽ കുറവു സമയം)',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'unreviewedpages' => 'न तपासलेली पाने',
	'unreviewedpages-legend' => 'न तपासलेल्या लेखांची यादी तयार करा',
	'unreviewedpages-category' => 'वर्ग:',
	'unreviewedpages-diff' => 'तपासा',
	'unreviewedpages-unwatched' => '(न पाहिलेली)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|सदस्यानी|सदस्यांनी}} पहारा दिलेला आहे)',
	'unreviewedpages-list' => 'हे पान अशा पानांची यादी दर्शविते जी पाने तपासलेली नाहीत.',
	'unreviewedpages-none' => 'ह्या मानदंडांशी जुळणारी पाने नाहीत',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'unreviewedpages' => 'Halaman belum diperiksa',
	'unreviewedpages-legend' => 'Senarai laman kandungan yang belum diperiksa',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'kaji semula',
	'unreviewedpages-unwatched' => '(tidak dipantau)',
	'unreviewedpages-watched' => '(dipantau oleh {{PLURAL:$1|seorang|$1 orang}} pengguna aktif)',
	'unreviewedpages-list' => "Laman ini menyenaraikan laman-laman kandungan yang ''belum'' [[{{MediaWiki:Validationpage}}|dikaji semula]] pada tahap yang ditetapkan.",
	'unreviewedpages-none' => 'Tiada laman yang memenuhi kriteria ini',
	'unreviewedpages-viewing' => '(sedang dikaji semula)',
	'unreviewedpages-hours' => '({{PLURAL:$1|sejam|$1 jam}})',
	'unreviewedpages-days' => '($1 hari)',
	'unreviewedpages-recent' => '(kurang drpd. 1 jam)',
);

/** Erzya (Эрзянь)
 * @author Amdf
 */
$messages['myv'] = array(
	'unreviewedpages-category' => 'Категория:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'unreviewedpages-category' => 'Tlaìxmatkàtlàlilòtl:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'unreviewedpages' => 'Uanmeldte sider',
	'unreviewedpages-legend' => 'List uanmeldte innholdssider',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'anmeld',
	'unreviewedpages-unwatched' => '(uovervåket)',
	'unreviewedpages-watched' => '({{PLURAL:$1|én aktiv bruker|$1 aktive brukere}} overvåker)',
	'unreviewedpages-list' => "Denne siden lister opp innholdssider som ''ikke'' har blitt [[{{MediaWiki:Validationpage}}|vurdert]] til det spesifiserte nivået.",
	'unreviewedpages-none' => 'Det er ingen sider som passer med disse kriteriene',
	'unreviewedpages-viewing' => '(under vurdering)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|time|timer}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dag|dager}})',
	'unreviewedpages-recent' => '(under én time)',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'unreviewedpages-category' => 'Kategorie:',
	'unreviewedpages-diff' => 'as nakeken marken',
	'unreviewedpages-unwatched' => '(op keen Oppasslist)',
	'unreviewedpages-watched' => '($1 aktive {{PLURAL:$1|Bruker|Brukers}} passt op disse Sied op)',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'unreviewedpages' => "Ongecontroleerde pagina's",
	'unreviewedpages-legend' => "Lijst met ongecontroleerde pagina's",
	'unreviewedpages-category' => 'Categorie:',
	'unreviewedpages-diff' => 'controle',
	'unreviewedpages-unwatched' => '(niet op een volglijst)',
	'unreviewedpages-watched' => '($1 actieve {{PLURAL:$1|gebruiker heeft|gebruikers hebben}} deze pagina op {{PLURAL:$1|zijn|hun}} volglijst)',
	'unreviewedpages-list' => "Deze pagina geeft een overzicht van [[{{MediaWiki:Validationpage}}|ongecontroleerde]] pagina's tot het aangegeven niveau.",
	'unreviewedpages-none' => "Er zijn geen pagina's die aan deze criteria voldoen",
	'unreviewedpages-viewing' => '(wordt gecontroleerd)',
	'unreviewedpages-hours' => '({{PLURAL:$1|één uur|$1 uur}})',
	'unreviewedpages-days' => '({{PLURAL:$1|één dag|$1 dagen}})',
	'unreviewedpages-recent' => '(minder dan één uur)',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'unreviewedpages' => 'Sider som ikkje er vortne vurderte',
	'unreviewedpages-legend' => 'List opp innhaldssider som ikkje er vurderte',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'vurder',
	'unreviewedpages-unwatched' => '(uovervaka)',
	'unreviewedpages-watched' => '({{PLURAL:$1|éin aktiv brukar|$1 aktive brukarar}} overvakar)',
	'unreviewedpages-list' => 'Denne sida listar opp artiklar som manglar vurdering',
	'unreviewedpages-none' => 'Det finst ingen sider som svarer til søkekriteria',
	'unreviewedpages-viewing' => '(under vurdering)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|time|timar}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dag|dagar}})',
	'unreviewedpages-recent' => '(mindre enn éin time)',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'unreviewedpages-category' => 'Sehlopha:',
	'unreviewedpages-diff' => 'Poeletšo',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|iri|diiri}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|letšatši|matšatši}})',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'unreviewedpages' => 'Listar las paginas pas revisadas',
	'unreviewedpages-legend' => 'Lista dels contenguts de las paginas pas visats',
	'unreviewedpages-category' => 'Categoria :',
	'unreviewedpages-diff' => 'revision',
	'unreviewedpages-unwatched' => '(pas observat)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|utilizaire actiu seguís|utilizaires actius seguisson}} aquesta pagina)',
	'unreviewedpages-list' => 'Aquesta pagina fa la lista de las paginas que son pas estadas revisadas al nivèl especificat.',
	'unreviewedpages-none' => 'Actualament, existís pas cap de pagina respectant aquestes critèris',
	'unreviewedpages-viewing' => '(en revision)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ora|oras}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|jorn|jorns}})',
	'unreviewedpages-recent' => "(mens d'una ora)",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'unreviewedpages-category' => 'ଶ୍ରେଣୀ:',
	'unreviewedpages-diff' => 'ସମୀକ୍ଷା',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'unreviewedpages-legend' => 'Басгарын кæй хъæуы, уыцы фæрсты номхыгъд',
	'unreviewedpages-category' => 'Категори:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'unreviewedpages-category' => 'Abdeeling:',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|Schtund|Schtund}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|Daag|Daag}})',
	'unreviewedpages-recent' => '(wennicher ass 1 Schtund)',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'unreviewedpages' => 'Nieprzejrzane strony',
	'unreviewedpages-legend' => 'Lista nieprzejrzanych stron',
	'unreviewedpages-category' => 'Kategoria',
	'unreviewedpages-diff' => 'przejrzyj',
	'unreviewedpages-unwatched' => '(nieobserwowana)',
	'unreviewedpages-watched' => '(obserwowana przez $1 {{PLURAL:$1|aktywnego użytkownika|aktywnych użytkowników}})',
	'unreviewedpages-list' => 'Poniżej znajduje się {{PLURAL:$1|[[{{MediaWiki:Validationpage}}|nieprzejrzana]] strona|lista [[{{MediaWiki:Validationpage}}|nieprzejrzanych]] stron}}.',
	'unreviewedpages-none' => 'Obecnie nie ma stron spełniających podane kryteria',
	'unreviewedpages-viewing' => '(w trakcie przeglądania)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|godzinę|godziny|godzin}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dzień|dni}})',
	'unreviewedpages-recent' => '(mniej niż 1 godzinę)',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'unreviewedpages' => 'Pàgine dësrevisionà',
	'unreviewedpages-legend' => "Lista le pàgine 'd contnù pa revisionà",
	'unreviewedpages-category' => 'Categorìa:',
	'unreviewedpages-diff' => 'revision',
	'unreviewedpages-unwatched' => '(pa tùa sot euj)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|utent|utent}} ativ a la ten-o sot euj)',
	'unreviewedpages-list' => 'Sta pàgina-sì a lista le pàgine ëd contnù che a son pa ancó stàite [[{{MediaWiki:Validationpage}}|revisionà]] al livel spessificà.',
	'unreviewedpages-none' => 'Al moment a-i é pa gnun-e pàgine che a sodisfo sti criteri-sì',
	'unreviewedpages-viewing' => '(sota revision)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ora|ore}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|di|di}})',
	'unreviewedpages-recent' => "(men che n'ora)",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'unreviewedpages-category' => 'وېشنيزه:',
	'unreviewedpages-diff' => 'مخکتنه',
	'unreviewedpages-watched' => '($1 فعاله {{PLURAL:$1|کارن|کارنان}} يې ګوري)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ساعت|ساعتونه}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|ورځ|ورځې}})',
	'unreviewedpages-recent' => '(له 1 ساعت نه لږ وخت)',
);

/** Portuguese (Português)
 * @author 555
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'unreviewedpages' => 'Páginas não revistas',
	'unreviewedpages-legend' => 'Listar páginas de conteúdo não revistas',
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'rever',
	'unreviewedpages-unwatched' => '(não vigiada)',
	'unreviewedpages-watched' => '(vigiada por $1 {{PLURAL:$1|utilizador activo|utilizadores activos}})',
	'unreviewedpages-list' => "Esta página lista as páginas de conteúdo que ''ainda'' não foram [[{{MediaWiki:Validationpage}}|revistas]] até ao nível escolhido.",
	'unreviewedpages-none' => 'De momento, não há páginas que se enquadrem nestes critérios',
	'unreviewedpages-viewing' => '(em revisão)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hora|horas}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dia|dias}})',
	'unreviewedpages-recent' => '(menos de uma hora)',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'unreviewedpages' => 'Páginas não analisadas',
	'unreviewedpages-legend' => 'Lista páginas de conteúdo a serem analisadas',
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'analisar',
	'unreviewedpages-unwatched' => '(não-vigiada)',
	'unreviewedpages-watched' => '(vigiada por $1 {{PLURAL:$1|usuários ativo|usuários ativos}})',
	'unreviewedpages-list' => "Esta página lista as páginas de conteúdo que ''ainda'' não foram [[{{MediaWiki:Validationpage}}|revisadas]] até ao nível escolhido.",
	'unreviewedpages-none' => 'No momento não há páginas que se enquadrem nestes critérios',
	'unreviewedpages-viewing' => '(sob análise)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hora|horas}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dia|dias}})',
	'unreviewedpages-recent' => '(menos de 1 hora)',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'unreviewedpages' => 'Pagini nerevizuite',
	'unreviewedpages-legend' => 'Afișează pagini cu conținut nerevizuit',
	'unreviewedpages-category' => 'Categorie:',
	'unreviewedpages-diff' => 'recenzie',
	'unreviewedpages-unwatched' => '(neurmărit)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|utilizator activ  care urmărește|utilizatori activi care urmăresc}})',
	'unreviewedpages-none' => 'Nu există pagini în acest moment care să îndeplinească criteriile',
	'unreviewedpages-viewing' => '(în curs de revizuire)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|oră|ore}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|zi|zile}})',
	'unreviewedpages-recent' => '(mai puțin de 1 oră)',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'unreviewedpages' => 'Pàggene senza revisione',
	'unreviewedpages-legend' => 'Liste de le pàggene cu le condenute senza rivisitaziune',
	'unreviewedpages-category' => 'Categorije:',
	'unreviewedpages-diff' => 'reviste',
	'unreviewedpages-unwatched' => '(no condrollà)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|utende|utinde}} attive ca condrollene)',
	'unreviewedpages-list' => "Sta pàgene elenghe le vôsce ca non ge tènene angore [[{{MediaWiki:Validationpage}}|'na rivisitazione]] jndr'à 'u levèlle specificate.",
	'unreviewedpages-none' => "Non ge stonne pàggene ca soddisfecene 'u criterie de ricerche ca è mise",
	'unreviewedpages-viewing' => '(sotte a rivisitazione)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ore|ore}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|sciurne|sciurne}})',
	'unreviewedpages-recent' => "(mene de 'n'ore)",
);

/** Russian (Русский)
 * @author Ahonc
 * @author EugeneZelenko
 * @author Ferrer
 * @author Kaganer
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'unreviewedpages' => 'Непроверенные страницы',
	'unreviewedpages-legend' => 'Список непроверенных статей',
	'unreviewedpages-category' => 'Категория:',
	'unreviewedpages-diff' => 'проверить',
	'unreviewedpages-unwatched' => '(не следят)',
	'unreviewedpages-watched' => '({{PLURAL:$1|следит $1 активный участник|следят $1 активных участника|следят $1 активных участников}})',
	'unreviewedpages-list' => "На этой странице перечислены статьи, которые ещё ''не'' были [[{{MediaWiki:Validationpage}}|оценены]] на указанный уровень.",
	'unreviewedpages-none' => 'В настоящий момент нет страниц, удовлетворяющих указанным условиям',
	'unreviewedpages-viewing' => '(проверяется)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|час|часа|часов}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|день|дня|дней}})',
	'unreviewedpages-recent' => '(менее, чем 1 час)',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'unreviewedpages' => 'Неперевірены сторінкы',
	'unreviewedpages-legend' => 'Список неперевіреных статей',
	'unreviewedpages-category' => 'Катеґорія:',
	'unreviewedpages-diff' => 'перевірити',
	'unreviewedpages-unwatched' => '(неслїдованы)',
	'unreviewedpages-watched' => '({{PLURAL:$1|слїдує $1 актівный хоснователь|слїдують $1 актівны хоснователї|слїдує $1 актівных хоснователїв}})',
	'unreviewedpages-list' => 'На тій сторінцї перерахованы статї, як іщі не были [[{{MediaWiki:Validationpage}}|рецензованы]] на зазначеный рівень.',
	'unreviewedpages-none' => 'Теперь нїт сторінок одповідаючіх тым крітеріям',
	'unreviewedpages-viewing' => '(контролює ся)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|година|годины|годин}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|день|днї|днів}})',
	'unreviewedpages-recent' => '(менше 1 годины)',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'unreviewedpages-category' => 'वर्गः',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'unreviewedpages' => 'Ырытыллыбатах сирэйдэр',
	'unreviewedpages-legend' => 'Бэрэбиэркэлэммэтэх сирэйдэр тиһиктэрэ',
	'unreviewedpages-category' => 'Категория:',
	'unreviewedpages-diff' => 'тургутуу',
	'unreviewedpages-unwatched' => '(кэтээбэттэр)',
	'unreviewedpages-watched' => '($1 көхтөөх кыттааччы кэтиир)',
	'unreviewedpages-list' => 'Бу сирэйгэ этиллибит таһымынан сыаналамматах сирэйдэр көстөллөр.',
	'unreviewedpages-none' => 'Эппит таһымҥар эппиэттиир ыстатыйа билигин суох эбит',
	'unreviewedpages-viewing' => '(тургутуллаллар)',
	'unreviewedpages-hours' => '($1 чаас)',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|хонук|күн}})',
	'unreviewedpages-recent' => '(1 чаастан кылгас)',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'revisiona',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ora|oras}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|die|dies}})',
	'unreviewedpages-recent' => '(nemmancu 1 ora)',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'unreviewedpages' => 'නිරීක්ෂණය නොකළ පිටු',
	'unreviewedpages-legend' => 'නිරීක්ෂණය නොකළ අන්තර්ගතය සහිත පිටු ලැයිස්තුගත කරන්න',
	'unreviewedpages-category' => 'ප්‍රවර්ගය:',
	'unreviewedpages-diff' => 'නිරීක්ෂණය',
	'unreviewedpages-unwatched' => '(මුරනොකළ)',
	'unreviewedpages-viewing' => '(නිරීක්ෂණය යටතේ)',
	'unreviewedpages-hours' => '({{PLURAL:$1|පැය|පැය}} $1 ක්)',
	'unreviewedpages-days' => '({{PLURAL:$1|දින|දින}} $1 ක්)',
	'unreviewedpages-recent' => '(පැයකටත් වඩා අඩුවෙන්)',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'unreviewedpages' => 'Neskontrolované stránky',
	'unreviewedpages-legend' => 'Zoznam neskontrolovaných stránok s obsahom',
	'unreviewedpages-category' => 'Kategória:',
	'unreviewedpages-diff' => 'kontrola',
	'unreviewedpages-unwatched' => '(nesledovaná)',
	'unreviewedpages-watched' => '({{PLURAL:$1|sleduje $1 aktívny používateľ|sleduú $1 aktívni používatelia|sleduje $1 aktívnych používateľov}})',
	'unreviewedpages-list' => 'Táto stránka obsahuje zoznam článkov, ktoré neboli skontrolované do určenej úrovne.',
	'unreviewedpages-none' => 'Momentálne žiadne stránky nespĺňajú tieto kritériá',
	'unreviewedpages-viewing' => '(kontroluje sa)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|hodina|hodiny|hodín}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|deň|dni|dní}})',
	'unreviewedpages-recent' => '(menej ako 1 hodina)',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'unreviewedpages' => 'Nepregledane strani',
	'unreviewedpages-legend' => 'Seznam nepregledanih strani z vsebino',
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'preglej',
	'unreviewedpages-unwatched' => '(nespremljano)',
	'unreviewedpages-watched' => '({{PLURAL:$1|spremlja $1 dejavni uporabnik|spremljata $1 dejavna uporabnika|spremljajo $1 dejavni uporabniki|spremlja $1 dejavnih uporabnikov}})',
	'unreviewedpages-list' => "Ta seznam navaja strani z vsebino, ki še ''niso'' bile [[{{MediaWiki:Validationpage}}|pregledane]] do določene ravni.",
	'unreviewedpages-none' => 'Trenutno ni nobene strani, ki bi ustrezala izbranim merilom',
	'unreviewedpages-viewing' => '(v pregledu)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ura|uri|ure|ur}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dan|dneva|dnevi|dni}})',
	'unreviewedpages-recent' => '(manj kot 1 ura)',
);

/** Somali (Soomaaliga)
 * @author Maax
 */
$messages['so'] = array(
	'unreviewedpages-category' => 'Qeybta:',
);

/** Albanian (Shqip)
 * @author Puntori
 */
$messages['sq'] = array(
	'unreviewedpages-category' => 'Kategoria:',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'unreviewedpages' => 'Непрегледане стране.',
	'unreviewedpages-legend' => 'Списак непрегледаних страница са садржајем.',
	'unreviewedpages-category' => 'Категорија:',
	'unreviewedpages-diff' => 'преглед',
	'unreviewedpages-unwatched' => '(ненадзирано)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|активан корисник надгледа|акхивних корисника надгледају}})',
	'unreviewedpages-list' => "На овој страници су наведене странице са садржајем које још ''нису'' [[{{MediaWiki:Validationpage}}|прегледане]] до одређеног нивоа.",
	'unreviewedpages-none' => 'Не постоји ниједна страница која се поклапа са овим критеријумима.',
	'unreviewedpages-viewing' => '(под прегледом)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|сат|сати}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|дан|дана}})',
	'unreviewedpages-recent' => '(мање од једног сата)',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'unreviewedpages' => 'Nepregledane strane.',
	'unreviewedpages-legend' => 'Spisak nepregledanih sadržajnih strana.',
	'unreviewedpages-category' => 'Kategorija:',
	'unreviewedpages-diff' => 'pregled',
	'unreviewedpages-unwatched' => '(nenadzirano)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktivan korisnik nadgleda|akhivnih korisnika nadgledaju}})',
	'unreviewedpages-list' => "Na ovoj stranici su navedene stranice sa sadržajem koje još ''nisu'' [[{{MediaWiki:Validationpage}}|pregledane]] do određenog nivoa.",
	'unreviewedpages-none' => 'Ne postoji nijedna strana koja se poklapa sa ovim kriterijima.',
	'unreviewedpages-viewing' => '(pod pregledom)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|sat|sati}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dan|dana}})',
	'unreviewedpages-recent' => '(manje od sata)',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'unreviewedpages' => 'Nit wröigede Artikkele',
	'unreviewedpages-category' => 'Kategorie:',
	'unreviewedpages-diff' => 'sichtje',
	'unreviewedpages-list' => 'Disse Siede wiest Artikkele, do der noch sieläärge nit wröiged wuuden of nit wröigede Versione hääbe.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'Parobahan',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author MagnusA
 * @author Najami
 * @author Per
 * @author Rotsee
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'unreviewedpages' => 'Ogranskade sidor',
	'unreviewedpages-legend' => 'Lista ogranskade innehållssidor',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'granska',
	'unreviewedpages-unwatched' => '(obevakad)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktiv användare|aktiva användare}} bevakar)',
	'unreviewedpages-list' => "Den här sidan listar innehållssidor som ''inte'' har [[{{MediaWiki:Validationpage}}|granskats]] till den angivna nivån.",
	'unreviewedpages-none' => 'Det finns just nu inga sidor som matchar dessa kriterier',
	'unreviewedpages-viewing' => '(granskas)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|timme|timmar}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|dygn|dygn}})',
	'unreviewedpages-recent' => '(mindre än en timme)',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'unreviewedpages-category' => 'Jamii:',
);

/** Tamil (தமிழ்)
 * @author Kanags
 * @author TRYPPN
 */
$messages['ta'] = array(
	'unreviewedpages' => 'பார்வையிடப்படாத பக்கங்கள்',
	'unreviewedpages-legend' => 'மீள்பார்வையிடப்படாத பகுதிகளைக் கொண்ட பக்கங்கள்',
	'unreviewedpages-category' => 'பகுப்பு:',
	'unreviewedpages-diff' => 'மதிப்பிடு',
	'unreviewedpages-unwatched' => '(கவனிக்கப்படமாட்டாது)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|பயனர்|பயனர்கள்}} பார்வையிடுகிறார்கள்)',
	'unreviewedpages-list' => 'இங்கே கொடுக்கப்பட்ட பக்கங்களின் உள்ளடக்கங்களை குறிப்பிடப்பட்ட அளவுக்கு இன்னும் பரிசீலனை செய்யப்படவில்லை.',
	'unreviewedpages-none' => 'தாங்கள் குறிப்பிட்ட விதிமுறைகளுக்கு உட்பட்ட பக்கங்கள் தற்சமயம் ஏதுமில்லை.',
	'unreviewedpages-viewing' => '(மீள் பார்வைக்காக)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|மணி|மணிகள்}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|நாள்|நாட்கள்}})',
	'unreviewedpages-recent' => '(1 மணித்தியாலத்துக்குள்)',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'unreviewedpages' => 'సమీక్షించని పేజీలు',
	'unreviewedpages-legend' => 'సమీక్షించని పాఠ్య పేజీల జాబితా',
	'unreviewedpages-category' => 'వర్గం:',
	'unreviewedpages-diff' => 'సమీక్షించండి',
	'unreviewedpages-unwatched' => '(వీక్షణలో లేనివి)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|క్రియాశీల వాడుకరి|గురు క్రియాశీల వాడుకరులు}} వీక్షిస్తున్నారు)',
	'unreviewedpages-list' => 'ఈ పేజీలో పేర్కొన్న స్థాయి వరకు సమీక్షించని వ్యాసాల జాబితా ప్రదర్సింపబడుతోంది.',
	'unreviewedpages-none' => 'ఈ నియమాలకు సరిపోలుతున్న పేజీలు ఏమీ ప్రస్తుతం లేవు',
	'unreviewedpages-viewing' => '(సమీక్షలో ఉంది)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|గంట|గంటలు}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|రోజు|రోజులు}})',
	'unreviewedpages-recent' => '(ఒక గంట కంటే తక్కువ)',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'unreviewedpages-category' => 'Kategoria:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'unreviewedpages' => 'Саҳифаҳои баррасӣ нашуда',
	'unreviewedpages-category' => 'Гурӯҳ:',
	'unreviewedpages-diff' => 'Тағйирот',
	'unreviewedpages-list' => 'Ин саҳифа мақолаҳои баррасинашуда, мақолаҳои ҷадид, нусхаҳои ҷадид ё баррасинашударо феҳрист мекунад.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'unreviewedpages' => 'Sahifahoi barrasī naşuda',
	'unreviewedpages-category' => 'Gurūh:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'unreviewedpages' => 'Gözden geçirilmedik sahypalar',
	'unreviewedpages-legend' => 'Gözden geçirilmedik mazmunly sahypalary sanawla',
	'unreviewedpages-category' => 'Kategoriýa:',
	'unreviewedpages-diff' => 'gözden geçir',
	'unreviewedpages-unwatched' => '(gözegçilikde däl)',
	'unreviewedpages-watched' => '($1 işjeň {{PLURAL:$1|ulanyjy|ulanyjy}} gözegçilik edýär)',
	'unreviewedpages-list' => 'Bu sahypa görkezilen derejä çenli gözden geçirilmedik mazmunly sahypalary sanawlaýar.',
	'unreviewedpages-none' => 'Häzirki wagtda bu şertlere gabat gelýän hiç hili sahypa ýok.',
	'unreviewedpages-viewing' => '(gözden geçirilýär)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|sagat|sagat}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|gün|gün}})',
	'unreviewedpages-recent' => '(1 sagatdan az)',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'unreviewedpages' => 'Hindi pa nasusuring mga pahina',
	'unreviewedpages-legend' => 'Itala ang hindi pa nasusuring mga pahina ng nilalaman',
	'unreviewedpages-category' => 'Kaurian:',
	'unreviewedpages-diff' => 'suriing muli',
	'unreviewedpages-unwatched' => '(hindi binabantayan)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|tagagamit|mga tagagamit}} na nagmamasid)',
	'unreviewedpages-list' => "Nagtatala ang pahinang ito ng mga pahina ng nilalaman na ''hindi'' pa [[{{MediaWiki:Validationpage}}|nasusuring muli]] para sa tinukoy na antas.",
	'unreviewedpages-none' => 'Sa ngayon, wala pang mga pahinang nakakaabot sa ganitong mga kaurian (kategorya).',
	'unreviewedpages-viewing' => '(nasa ilalim ng pagsusuri)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|oras|mga oras}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|araw|mga araw}})',
	'unreviewedpages-recent' => '(mas mababa kaysa 1 oras)',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Runningfridgesrule
 */
$messages['tr'] = array(
	'unreviewedpages' => 'Gözden geçirilmemiş sayfalar',
	'unreviewedpages-legend' => 'Gözden geçirilmemiş içerik sayfalarını listele',
	'unreviewedpages-category' => 'Kategori:',
	'unreviewedpages-diff' => 'gözden geçir',
	'unreviewedpages-unwatched' => '(izlenmiyor)',
	'unreviewedpages-watched' => '($1 etkin {{PLURAL:$1|kullanıcı|kullanıcı}} izliyor)',
	'unreviewedpages-list' => 'Bu sayfa, belirlenen seviyeye göre gözden geçirilmemiş içerik sayfalarını listeler.',
	'unreviewedpages-none' => 'Şu anda bu kriterleri karşılayan bir sayfa bulunmamaktadır',
	'unreviewedpages-viewing' => '(gözden geçiriliyor)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|saat|saat}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|gün|gün}})',
	'unreviewedpages-recent' => '(1 saatten az)',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'unreviewedpages' => 'Неперевірені сторінки',
	'unreviewedpages-legend' => 'Список неперевірених статей',
	'unreviewedpages-category' => 'Категорія:',
	'unreviewedpages-diff' => 'перевірити',
	'unreviewedpages-unwatched' => '(не спостерігають)',
	'unreviewedpages-watched' => '({{PLURAL:$1|спостерігає $1 активний користувач|спостерігають $1 активних користувачі|спостерігають $1 активних користувачів}})',
	'unreviewedpages-list' => "На цій сторінці перераховані статті, що ще ''не'' були [[{{MediaWiki:Validationpage}}|рецензовані]] на зазначений рівень.",
	'unreviewedpages-none' => 'Зараз нема сторінок, що відповідають зазначеним критеріям',
	'unreviewedpages-viewing' => '(перевіряється)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|година|години|годин}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|день|дні|днів}})',
	'unreviewedpages-recent' => '(менше 1 години)',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'unreviewedpages' => 'Pagine non riesaminà',
	'unreviewedpages-legend' => 'Elenca le pagine non riesaminà',
	'unreviewedpages-category' => 'Categoria:',
	'unreviewedpages-diff' => 'esamina',
	'unreviewedpages-unwatched' => '(non osservà)',
	'unreviewedpages-watched' => "($1 {{PLURAL:$1|utente el|utenti i}} tien d'ocio sta pagina)",
	'unreviewedpages-list' => 'Sta pagina la elenca le pagine che no le xe stà gnancora riesaminà fin al livèl indicà.',
	'unreviewedpages-none' => 'No ghe xe atualmente pagine che sodisfa sti criteri',
	'unreviewedpages-viewing' => '(in corso de revision)',
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|ora|ore}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|zorno|zorni}})',
	'unreviewedpages-recent' => "(manco de un'ora)",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'unreviewedpages' => 'Lehtpoled, kudambad ei olgoi kodvdud',
	'unreviewedpages-legend' => 'Niiden lehtpoliden nimikirjutez, kudambad ei olgoi kodvdud ende',
	'unreviewedpages-category' => 'Kategorii:',
	'unreviewedpages-diff' => 'kodvda',
	'unreviewedpages-unwatched' => '(ei ole kaceltud)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|aktivine kävutai|aktivišt kävutajad}} kaceltas)',
	'unreviewedpages-list' => 'Necil lehtpolel om kodvmatomiden märitud pindhasai lehtpoliden nimikirjutez.',
	'unreviewedpages-none' => "Nügüd' ei ole lehtpolid, kudambad sättudas ningoižiden arvoimižidenke.",
	'unreviewedpages-viewing' => "(lehtpoled, kudambad nügüd' kodvdas)",
	'unreviewedpages-hours' => '($1 {{PLURAL:$1|čas|časud}})',
	'unreviewedpages-days' => '($1 {{PLURAL:$1|päiv|päiväd}})',
	'unreviewedpages-recent' => '(vähemb časud)',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'unreviewedpages' => 'Các trang chưa được duyệt',
	'unreviewedpages-legend' => 'Liệt kê các trang có nội dung chưa được duyệt',
	'unreviewedpages-category' => 'Thể loại:',
	'unreviewedpages-diff' => 'duyệt',
	'unreviewedpages-unwatched' => '(chưa theo dõi)',
	'unreviewedpages-watched' => '($1 {{PLURAL:$1|thành viên|thành viên}} tích cực đang theo dõi)',
	'unreviewedpages-list' => "Trang này liệt kê những trang nội dung ''chưa'' được [[{{MediaWiki:Validationpage}}|duyệt]] tới mức chỉ định.",
	'unreviewedpages-none' => 'Hiện không có trang nào thỏa mãn tiêu chí này',
	'unreviewedpages-viewing' => '(đang duyệt)',
	'unreviewedpages-hours' => '($1 tiếng){{PLURAL:$1||}}',
	'unreviewedpages-days' => '($1 ngày){{PLURAL:$1||}}',
	'unreviewedpages-recent' => '(ít hơn 1 tiếng)',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'unreviewedpages' => 'Pads no pekrütöls',
	'unreviewedpages-category' => 'Klad:',
	'unreviewedpages-diff' => 'Votükams',
	'unreviewedpages-list' => 'Su pad at palisedons yegeds no pekrütöls u labü fomams nulik no pekrütöls',
	'unreviewedpages-hours' => '({{PLURAL:$1|düp|düps}} $1)',
	'unreviewedpages-days' => '({{PLURAL:$1|del|dels}} $1)',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'unreviewedpages-category' => 'קאטעגאריע:',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'unreviewedpages' => '未複審嘅版',
	'unreviewedpages-legend' => '列示未複審嘅內容頁',
	'unreviewedpages-category' => '分類:',
	'unreviewedpages-diff' => '更改',
	'unreviewedpages-unwatched' => '(未睇)',
	'unreviewedpages-watched' => '($1{{PLURAL:$1|位用戶|位用戶}}睇緊)',
	'unreviewedpages-list' => '呢一版列示出重未複審或視察過嘅文章修訂。',
	'unreviewedpages-none' => '呢度現時無版合乎呢啲條件',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Gaoxuewei
 * @author PhiLiP
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'unreviewedpages' => '未复审页面',
	'unreviewedpages-legend' => '未复审内容页面列表',
	'unreviewedpages-category' => '分类：',
	'unreviewedpages-diff' => '复审',
	'unreviewedpages-unwatched' => '（未被监视）',
	'unreviewedpages-watched' => '（$1位活跃{{PLURAL:$1|用户|用户}}正在监视）',
	'unreviewedpages-list' => "本页面列出了'''尚未'''达到指定[[{{MediaWiki:Validationpage}}|复审]]级别的内容页面。",
	'unreviewedpages-none' => '目前没有页面符合这些条件',
	'unreviewedpages-viewing' => '（正在复审）',
	'unreviewedpages-hours' => '（$1 {{PLURAL:$1|小时|小时}}）',
	'unreviewedpages-days' => '（$1 {{PLURAL:$1|天|天}}）',
	'unreviewedpages-recent' => '（少于1小时）',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Gaoxuewei
 */
$messages['zh-hant'] = array(
	'unreviewedpages' => '未複審頁面',
	'unreviewedpages-legend' => '未復審內容頁面列表',
	'unreviewedpages-category' => '分類：',
	'unreviewedpages-diff' => '審核',
	'unreviewedpages-unwatched' => '（未被監視）',
	'unreviewedpages-watched' => '（$1位活躍{{PLURAL:$1|用戶|用戶}}正在監視）',
	'unreviewedpages-list' => "本頁面列出了'''尚未'''達到指定[[{{MediaWiki:Validationpage}}|複審]]級別的內容頁面。",
	'unreviewedpages-none' => '目前沒有頁面合乎這些條件',
	'unreviewedpages-viewing' => '（正在審核）',
	'unreviewedpages-hours' => '（$1 {{PLURAL:$1|小時|小時}}）',
	'unreviewedpages-days' => '（$1 {{PLURAL:$1|天|天}}）',
	'unreviewedpages-recent' => '（小於1小時）',
);

