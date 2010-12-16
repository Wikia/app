<?php
/**
 * Internationalisation file for extension UsageStatistics.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'specialuserstats'                => 'Usage statistics',
	'usagestatistics'                 => 'Usage statistics',
	'usagestatistics-desc'            => 'Show individual user and overall wiki usage statistics',
	'usagestatisticsfor'              => '<h2>Usage statistics for [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers'      => '<h2>Usage statistics for all users</h2>',
	'usagestatisticsinterval'         => 'Interval:',
	'usagestatisticsnamespace'		  => 'Namespace:',
	'usagestatisticsexcluderedirects' => 'Exclude redirects',
	'usagestatistics-namespace'       => 'These are statistics on the [[Special:Allpages/$1|$2]] namespace.',
	'usagestatistics-noredirects'     => '[[Special:ListRedirects|Redirects]] are not taken into account.',
	'usagestatisticstype'             => 'Type:',
	'usagestatisticsstart'            => 'Start date:',
	'usagestatisticsend'              => 'End date:',
	'usagestatisticssubmit'           => 'Generate statistics',
	'usagestatisticsnostart'          => 'Please specify a start date',
	'usagestatisticsnoend'            => 'Please specify an end date',
	'usagestatisticsbadstartend'      => '<b>Bad <i>start</i> and/or <i>end</i> date!</b>',
	'usagestatisticsintervalday'      => 'Day',
	'usagestatisticsintervalweek'     => 'Week',
	'usagestatisticsintervalmonth'    => 'Month',
	'usagestatisticsincremental'      => 'Incremental',
	'usagestatisticsincremental-text' => 'incremental',
	'usagestatisticscumulative'       => 'Cumulative',
	'usagestatisticscumulative-text'  => 'cumulative',
	'usagestatisticscalselect'        => 'Select',
	'usagestatistics-editindividual'  => 'Individual user $1 edits statistics',
	'usagestatistics-editpages'       => 'Individual user $1 pages statistics',
	'right-viewsystemstats'           => 'View [[Special:UserStats|wiki usage statistics]]',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Lejonel
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'specialuserstats' => '{{Identical|Usage statistics}}',
	'usagestatistics' => '{{Identical|Usage statistics}}',
	'usagestatistics-desc' => '{{desc}}',
	'usagestatisticsnamespace' => '{{Identical|Namespace}}',
	'usagestatisticstype' => '{{Identical|Type}}',
	'usagestatisticsstart' => '{{Identical|Start date}}',
	'usagestatisticsend' => '{{Identical|End date}}',
	'usagestatisticsintervalmonth' => '{{Identical|Month}}',
	'usagestatisticsincremental' => 'This message is used on [[Special:SpecialUserStats]] in a dropdown menu to choose to generate incremental statistics.

Incremental statistics means that for each interval the number of edits in that interval is counted, as opposed to cumulative statistics were the number of edits in the interval an all earlier intervals are counted.

{{Identical|Incremental}}',
	'usagestatisticsincremental-text' => 'This message is used as parameter $1 both in {{msg|Usagestatistics-editindividual}} and in {{msg|Usagestatistics-editpages}} ($1 can also be {{msg|Usagestatisticscumulative-text}}).

{{Identical|Incremental}}',
	'usagestatisticscumulative' => 'This message is used on [[Special:SpecialUserStats]] in a dropdown menu to choose to generate cumulative statistics.

Cumulative statistics means that for each interval the number of edits in that interval and all earlier intervals are counted, as opposed to incremental statistics were only the edits in the interval are counted.

{{Identical|Cumulative}}',
	'usagestatisticscumulative-text' => 'This message is used as parameter $1 both in {{msg|Usagestatistics-editindividual}} and in {{msg|Usagestatistics-editpages}} ($1 can also be {{msg|Usagestatisticsincremental-text}}).

{{Identical|Cumulative}}',
	'usagestatisticscalselect' => '{{Identical|Select}}',
	'usagestatistics-editindividual' => "Text in usage statistics graph. Parameter $1 can be either 'cumulative' ({{msg|Usagestatisticscumulative-text}}) or 'incremental' ({{msg|Usagestatisticsincremental-text}})",
	'usagestatistics-editpages' => "Text in usage statistics graph. Parameter $1 can be either 'cumulative' ({{msg|Usagestatisticscumulative-text}}) or 'incremental' ({{msg|Usagestatisticsincremental-text}})",
	'right-viewsystemstats' => '{{doc-right|viewsystemstats}}',
);

/** Laz (Laz)
 * @author Bombola
 */
$messages['lzz'] = array(
	'usagestatisticsintervalday' => 'Ndğa',
	'usagestatisticsintervalweek' => 'Doloni',
	'usagestatisticsintervalmonth' => 'Tuta',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'specialuserstats' => 'Gebruiksstatistieke',
	'usagestatistics' => 'Gebruiksstatistieke',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticsnamespace' => 'Naamruimte:',
	'usagestatisticstype' => 'Tipe',
	'usagestatisticsstart' => 'Begindatum:',
	'usagestatisticsend' => 'Einddatum:',
	'usagestatisticssubmit' => 'Genereer statistieke',
	'usagestatisticsnostart' => "Gee asseblief 'n begindatum",
	'usagestatisticsnoend' => "Spesifiseer 'n einddatum",
	'usagestatisticsbadstartend' => '<b>Slegte <i>begindatum</i> en/of <i>einddatum</i>!</b>',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Week',
	'usagestatisticsintervalmonth' => 'Maand',
	'usagestatisticsincremental' => 'Inkrementeel',
	'usagestatisticsincremental-text' => 'inkrementeel',
	'usagestatisticscumulative' => 'Kumulatief',
	'usagestatisticscumulative-text' => 'kumulatief',
	'usagestatisticscalselect' => 'Kies',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'usagestatisticsintervalday' => 'ቀን',
	'usagestatisticsintervalweek' => 'ሳምንት',
	'usagestatisticsintervalmonth' => 'ወር',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'usagestatisticsstart' => 'Calendata de prenzipio',
	'usagestatisticsend' => 'Calendata final',
	'usagestatisticsnoend' => 'Por fabor, escriba una calendata final',
	'usagestatisticsbadstartend' => '<b>As calendatas de <i>enzete</i> y/u <i>fin</i> no son conformes!</b>',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'specialuserstats' => 'إحصاءات الاستخدام',
	'usagestatistics' => 'إحصاءات الاستخدام',
	'usagestatistics-desc' => 'يعرض إحصاءات الاستخدام لمستخدم منفرد وللويكي ككل',
	'usagestatisticsfor' => '<h2>إحصاءات الاستخدام ل[[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>إحصاءات الاستخدام لكل المستخدمين</h2>',
	'usagestatisticsinterval' => 'المدة:',
	'usagestatisticsnamespace' => 'النطاق:',
	'usagestatisticsexcluderedirects' => 'استثن التحويلات',
	'usagestatistics-namespace' => 'هذه إحصاءات على نطاق [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|التحويلات]] لا تحسب.',
	'usagestatisticstype' => 'نوع',
	'usagestatisticsstart' => 'تاريخ البداية:',
	'usagestatisticsend' => 'تاريخ النهاية:',
	'usagestatisticssubmit' => 'توليد الإحصاءات',
	'usagestatisticsnostart' => 'من فضلك حدد تاريخا للبدء',
	'usagestatisticsnoend' => 'من فضلك حدد تاريخا للانتهاء',
	'usagestatisticsbadstartend' => '<b>تاريخ <i>بدء</i> و/أو <i>انتهاء</i> سيء!</b>',
	'usagestatisticsintervalday' => 'يوم',
	'usagestatisticsintervalweek' => 'أسبوع',
	'usagestatisticsintervalmonth' => 'شهر',
	'usagestatisticsincremental' => 'تزايدي',
	'usagestatisticsincremental-text' => 'تزايدي',
	'usagestatisticscumulative' => 'تراكمي',
	'usagestatisticscumulative-text' => 'تراكمي',
	'usagestatisticscalselect' => 'اختيار',
	'usagestatistics-editindividual' => 'إحصاءات تعديلات المستخدم المنفرد $1',
	'usagestatistics-editpages' => 'إحصاءات صفحات المستخدم المنفرد $1',
	'right-viewsystemstats' => 'رؤية [[Special:UserStats|إحصاءات استخدام الويكي]]',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'usagestatisticsnamespace' => 'ܚܩܠܐ:',
	'usagestatisticstype' => 'ܐܕܫܐ',
	'usagestatisticsintervalday' => 'ܝܘܡܐ',
	'usagestatisticsintervalweek' => 'ܫܒܘܥܐ',
	'usagestatisticsintervalmonth' => 'ܝܪܚܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'specialuserstats' => 'إحصاءات الاستخدام',
	'usagestatistics' => 'إحصاءات الاستخدام',
	'usagestatistics-desc' => 'يعرض إحصاءات الاستخدام ليوزر منفرد وللويكى ككل',
	'usagestatisticsfor' => '<h2>إحصاءات الاستخدام ل[[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>إحصاءات الاستخدام لكل اليوزرز</h2>',
	'usagestatisticsinterval' => 'مدة:',
	'usagestatisticsnamespace' => 'النطاق:',
	'usagestatisticsexcluderedirects' => 'ماتحسبش التحويلات',
	'usagestatisticstype' => 'نوع',
	'usagestatisticsstart' => 'تاريخ البدء:',
	'usagestatisticsend' => 'تاريخ الانتهاء:',
	'usagestatisticssubmit' => 'توليد الإحصاءات',
	'usagestatisticsnostart' => 'من فضلك حدد تاريخا للبدء',
	'usagestatisticsnoend' => 'من فضلك حدد تاريخا للانتهاء',
	'usagestatisticsbadstartend' => '<b>تاريخ <i>بدء</i> و/أو <i>انتهاء</i> سيء!</b>',
	'usagestatisticsintervalday' => 'يوم',
	'usagestatisticsintervalweek' => 'أسبوع',
	'usagestatisticsintervalmonth' => 'شهر',
	'usagestatisticsincremental' => 'تزايدي',
	'usagestatisticsincremental-text' => 'تزايدي',
	'usagestatisticscumulative' => 'تراكمي',
	'usagestatisticscumulative-text' => 'تراكمي',
	'usagestatisticscalselect' => 'اختيار',
	'usagestatistics-editindividual' => 'إحصاءات تعديلات اليوزر المنفرد $1',
	'usagestatistics-editpages' => 'إحصاءات صفحات اليوزر المنفرد $1',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'specialuserstats' => "Estadístiques d'usu",
	'usagestatistics' => "Estadístiques d'usu",
	'usagestatisticsfor' => "<h2>Estadístiques d'usu de [[User:$1|$1]]</h2>",
	'usagestatisticsinterval' => 'Intervalu',
	'usagestatisticstype' => 'Triba',
	'usagestatisticsstart' => 'Fecha inicial',
	'usagestatisticsend' => 'Fecha final',
	'usagestatisticssubmit' => 'Xenerar estadístiques',
	'usagestatisticsnostart' => 'Por favor especifica una fecha inicial',
	'usagestatisticsnoend' => 'Por favor especifica una fecha final',
	'usagestatisticsbadstartend' => '<b>¡Fecha <i>Inicial</i> y/o <i>Final</i> non válides!</b>',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'specialuserstats' => 'Faverenkopaceem',
	'usagestatistics' => 'Faverenkopaceem',
	'usagestatisticsfor' => '<h2>Faverenkopaceem ke [[User:$1|$1]]</h2>',
	'usagestatisticsinterval' => 'Waluk',
	'usagestatisticstype' => 'Ord',
	'usagestatisticsstart' => 'Tozevla',
	'usagestatisticsend' => 'Tenevla',
	'usagestatisticssubmit' => 'Nasbara va faverenkopaca',
	'usagestatisticsnostart' => 'Va tozevla vay bazel !',
	'usagestatisticsnoend' => 'Va tenevla vay bazel !',
	'usagestatisticsbadstartend' => '<b><i>Tozevlaja</i> ik <i>Tenevlaja</i> !</b>',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'specialuserstats' => 'Статыстыка выкарыстаньня',
	'usagestatistics' => 'Статыстыка выкарыстаньня',
	'usagestatistics-desc' => 'Паказвае статыстыку для індывідуальных удзельнікаў і статыстыку для ўсёй вікі',
	'usagestatisticsfor' => '<h2>Статыстыка выкарыстаньня для ўдзельніка [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Статыстыка выкарыстаньня для ўсіх удзельнікаў</h2>',
	'usagestatisticsinterval' => 'Пэрыяд:',
	'usagestatisticsnamespace' => 'Прастора назваў:',
	'usagestatisticsexcluderedirects' => 'Не ўлічваць перанакіраваньні',
	'usagestatistics-namespace' => 'Гэта статыстыка для прасторы назваў [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Перанакіраваньні]] не ўлічваюцца.',
	'usagestatisticstype' => 'Тып',
	'usagestatisticsstart' => 'Дата пачатку:',
	'usagestatisticsend' => 'Дата канца:',
	'usagestatisticssubmit' => 'Згенэраваць статыстыку',
	'usagestatisticsnostart' => 'Калі ласка, пазначце дату пачатку',
	'usagestatisticsnoend' => 'Калі ласка, пазначце дату канца',
	'usagestatisticsbadstartend' => '<b>Няслушная дата <i>пачатку</i> і/ці <i>канца</i>!</b>',
	'usagestatisticsintervalday' => 'Дзень',
	'usagestatisticsintervalweek' => 'Тыдзень',
	'usagestatisticsintervalmonth' => 'Месяц',
	'usagestatisticsincremental' => 'Павялічваючыся',
	'usagestatisticsincremental-text' => 'павялічваючыся',
	'usagestatisticscumulative' => 'Агульны',
	'usagestatisticscumulative-text' => 'агульны',
	'usagestatisticscalselect' => 'Выбраць',
	'usagestatistics-editindividual' => 'Індывідуальная статыстыка рэдагаваньняў удзельніка $1',
	'usagestatistics-editpages' => 'Індывідуальная статыстыка старонак удзельніка $1',
	'right-viewsystemstats' => 'прагляд [[Special:UserStats|статыстыкі выкарыстаньня {{GRAMMAR:родны|{{SITENAME}}}}]]',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'usagestatistics-desc' => 'Показване на статистика за отделни потребители или за цялото уики',
	'usagestatisticsinterval' => 'Интервал:',
	'usagestatisticsnamespace' => 'Именно пространство:',
	'usagestatisticstype' => 'Вид',
	'usagestatisticsstart' => 'Начална дата:',
	'usagestatisticsend' => 'Крайна дата:',
	'usagestatisticssubmit' => 'Генериране на статистиката',
	'usagestatisticsnostart' => 'Необходимо е да се посочи начална дата',
	'usagestatisticsnoend' => 'Необходимо е да се посочи крайна дата',
	'usagestatisticsbadstartend' => '<b>Невалидна <i>Начална</i> и/или <i>Крайна</i> дата!</b>',
	'usagestatisticsintervalday' => 'Ден',
	'usagestatisticsintervalweek' => 'Седмица',
	'usagestatisticsintervalmonth' => 'Месец',
	'usagestatisticscalselect' => 'Избиране',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'specialuserstats' => 'ব্যবহার পরিসংখ্যান',
	'usagestatistics' => 'ব্যবহার পরিসংখ্যান',
	'usagestatistics-desc' => 'একজন নির্দিষ্ট ব্যবহারকারী এবং সামগ্রিক উইকি ব্যবহার পরিসংখ্যান দেখানো হোক',
	'usagestatisticsfor' => '<h2>ব্যবহারকারী [[User:$1|$1]]-এর জন্য ব্যবহার পরিসংখ্যান</h2>',
	'usagestatisticsinterval' => 'ব্যবধান',
	'usagestatisticstype' => 'ধরন',
	'usagestatisticsstart' => 'শুরুর তারিখ',
	'usagestatisticsend' => 'শেষের তারিখ',
	'usagestatisticssubmit' => 'পরিসংখ্যান সৃষ্টি করা হোক',
	'usagestatisticsnostart' => 'অনুগ্রহ করে একটি শুরুর তারিখ দিন',
	'usagestatisticsnoend' => 'অনুগ্রহ করে একটি শেষের তারিখ দিন',
	'usagestatisticsbadstartend' => '<b>ভুল <i>শুরু</i> এবং/অথবা <i>শেষের</i> তারিখ!</b>',
	'usagestatisticsintervalday' => 'দিন',
	'usagestatisticsintervalweek' => 'সপ্তাহ',
	'usagestatisticsintervalmonth' => 'মাস',
	'usagestatisticsincremental' => 'বর্ধমান',
	'usagestatisticsincremental-text' => 'বর্ধমান',
	'usagestatisticscumulative' => 'ক্রমবর্ধমান',
	'usagestatisticscumulative-text' => 'ক্রমবর্ধমান',
	'usagestatisticscalselect' => 'নির্বাচন করুন',
	'usagestatistics-editindividual' => 'একক ব্যবহারকারী $1-এর সম্পাদনার পরিসংখ্যান',
	'usagestatistics-editpages' => 'একক ব্যবহারকারী $1-এর পাতাগুলির পরিসংখ্যান',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'specialuserstats' => 'Stadegoù implijout',
	'usagestatistics' => 'Stadegoù implijout',
	'usagestatistics-desc' => 'Diskouez a ra stadegoù personel an implijerien hag an implij war ar wiki en e bezh',
	'usagestatisticsfor' => '<h2>Stadegoù implijout evit [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Stadegoù implij evit an holl implijerien</h2>',
	'usagestatisticsinterval' => 'Esaouenn :',
	'usagestatisticsnamespace' => 'Esaouenn anv :',
	'usagestatisticsexcluderedirects' => 'Lezel an adkasoù er-maez',
	'usagestatistics-namespace' => 'Stadegoù war an esaouenn anv [[Special:Allpages/$1|$2]] eo ar re-mañ.',
	'usagestatistics-noredirects' => "N'eo ket kemeret an [[Special:ListRedirects|Adkasoù]] e kont.",
	'usagestatisticstype' => 'Seurt',
	'usagestatisticsstart' => 'Deiziad kregiñ :',
	'usagestatisticsend' => 'Deiziad echuiñ :',
	'usagestatisticssubmit' => 'Sevel ar stadegoù',
	'usagestatisticsnostart' => 'Merkit un deiziad kregiñ mar plij',
	'usagestatisticsnoend' => 'Merkit un deiziad echuiñ mar plij',
	'usagestatisticsbadstartend' => '<b>Fall eo furmad an deiziad <i>Kregiñ</i> pe/hag <i>Echuiñ</i> !</b>',
	'usagestatisticsintervalday' => 'Deiz',
	'usagestatisticsintervalweek' => 'Sizhun',
	'usagestatisticsintervalmonth' => 'Miz',
	'usagestatisticsincremental' => 'Azvuiadel',
	'usagestatisticsincremental-text' => 'azvuiadel',
	'usagestatisticscumulative' => 'Sammadel',
	'usagestatisticscumulative-text' => 'sammadel',
	'usagestatisticscalselect' => 'Dibab',
	'usagestatistics-editindividual' => 'Stadegoù savet $1 gant an implijer',
	'usagestatistics-editpages' => 'Stadegoù $1 ar pajennoù gant an implijer e-unan',
	'right-viewsystemstats' => 'Gwelet [[Special:UserStats|stadegoù implijout ar wiki]]',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'specialuserstats' => 'Statistike korištenja',
	'usagestatistics' => 'Statistike korištenja',
	'usagestatistics-desc' => 'Prikazuje pojedinačnog korisnika i njegovu ukupnu statistiku za sve wikije',
	'usagestatisticsfor' => '<h2>Statistike korištenja za [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistike korištenja za sve korisnike</h2>',
	'usagestatisticsinterval' => 'Period:',
	'usagestatisticsnamespace' => 'Imenski prostor:',
	'usagestatisticsexcluderedirects' => 'Isključi preusmjerenja',
	'usagestatistics-namespace' => 'Postoje statistike u [[Special:Allpages/$1|$2]] imenskom prostoru.',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Preusmjerenja]] nisu uzeta u obzir.',
	'usagestatisticstype' => 'Vrsta',
	'usagestatisticsstart' => 'Početni datum:',
	'usagestatisticsend' => 'Krajnji datum:',
	'usagestatisticssubmit' => 'Generiši statistike',
	'usagestatisticsnostart' => 'Molimo odredite početni datum',
	'usagestatisticsnoend' => 'Molimo odredite krajnji datum',
	'usagestatisticsbadstartend' => '<b>Pogrešan <i>početni</i> i/ili <i>krajnji</i> datum!</b>',
	'usagestatisticsintervalday' => 'dan',
	'usagestatisticsintervalweek' => 'sedmica',
	'usagestatisticsintervalmonth' => 'mjesec',
	'usagestatisticsincremental' => 'Inkrementalno',
	'usagestatisticsincremental-text' => 'inkrementalno',
	'usagestatisticscumulative' => 'Kumulativno',
	'usagestatisticscumulative-text' => 'kumulativno',
	'usagestatisticscalselect' => 'odaberi',
	'usagestatistics-editindividual' => '$1 statistike uređivanja pojedinačnog korisnika',
	'usagestatistics-editpages' => '$1 statistike stranica pojedinog korisnika',
	'right-viewsystemstats' => 'Pregledavanje [[Special:UserStats|statistika korištenja wikija]]',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author Qllach
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'specialuserstats' => "Estadístiques d'ús",
	'usagestatistics' => "Estadístiques d'ús",
	'usagestatistics-desc' => "Mostrar estadístiques d'ús d'usuaris individuals i globals del wiki",
	'usagestatisticsfor' => "<h2>Estadístiques d'ús de [[User:$1|$1]]</h2>",
	'usagestatisticsforallusers' => "<h2>Estadístiques d'ús per tots els usuaris</h2>",
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticsnamespace' => 'Espai de noms:',
	'usagestatisticsexcluderedirects' => 'Exclou-ne les redireccions',
	'usagestatistics-namespace' => "Aquestes estadístiques són de l'espai de noms [[Special:Allpages/$1|$2]].",
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Redirects]] no es tenen en compte.',
	'usagestatisticstype' => 'Tipus',
	'usagestatisticsstart' => "Data d'inici:",
	'usagestatisticsend' => "Data d'acabament:",
	'usagestatisticssubmit' => "Generació d'estadístiques",
	'usagestatisticsnostart' => "Si us plau, especifiqueu una data d'inici",
	'usagestatisticsnoend' => "Si us plau, especifiqueu una data d'acabament",
	'usagestatisticsbadstartend' => "<b>Data <i>d'inici</i> i/o <i>d'acabament</i> incorrecta!</b>",
	'usagestatisticsintervalday' => 'Dia',
	'usagestatisticsintervalweek' => 'Setmana',
	'usagestatisticsintervalmonth' => 'Mes',
	'usagestatisticsincremental' => 'Incrementals',
	'usagestatisticsincremental-text' => 'incrementals',
	'usagestatisticscumulative' => 'Acumulatives',
	'usagestatisticscumulative-text' => 'acumulatives',
	'usagestatisticscalselect' => 'Selecció',
	'usagestatistics-editindividual' => "Estadístiques $1 d'edicions de l'usuari",
	'usagestatistics-editpages' => "Estadístiques $1 de pàgines de l'usuari",
	'right-viewsystemstats' => "Veure [[Special:UserStats|estadístiques d'ús de la wiki]]",
);

/** Sorani (Arabic script) (‫کوردی (عەرەبی)‬)
 * @author Marmzok
 */
$messages['ckb-arab'] = array(
	'usagestatisticstype' => 'جۆر',
	'usagestatisticsstart' => 'ڕێکەوتی دەستپێک',
	'usagestatisticsend' => 'ڕێکەوتی کۆتایی',
	'usagestatisticsnostart' => 'تکایە ڕێکەوتێکی دەستپێک دیاری بکە',
	'usagestatisticsnoend' => 'تکایە ڕێکەوتێکی کۆتایی دیاری بکە',
	'usagestatisticsbadstartend' => '<b>ڕێکەوتی <i>دەستپێک</i> یا \\ و <i>کۆتایی</i> ناساز!</b>',
	'usagestatisticsintervalday' => 'ڕۆژ',
	'usagestatisticsintervalweek' => 'حەوتوو',
	'usagestatisticsintervalmonth' => 'مانگ',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'specialuserstats' => 'Statistika uživatelů',
	'usagestatistics' => 'Statistika používanosti',
	'usagestatistics-desc' => 'Zobrazení statistik jednotlivého uživatele a celé wiki',
	'usagestatisticsfor' => '<h2>Statistika používanosti pro uživatele [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistika využití pro všechny uživatele</h2>',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticsnamespace' => 'Jmenný prostor:',
	'usagestatisticsexcluderedirects' => 'Vynechat přesměrování',
	'usagestatistics-namespace' => 'Toto jsou statistiky jmenného prostoru [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Přesměrování]] jsou vynechána.',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsstart' => 'Počáteční datum:',
	'usagestatisticsend' => 'Konečné datum:',
	'usagestatisticssubmit' => 'Vytvořit statistiku',
	'usagestatisticsnostart' => 'Prosím, uveďte počáteční datum',
	'usagestatisticsnoend' => 'Prosím, uveďte konečné datum',
	'usagestatisticsbadstartend' => '<b>Chybné <i>počáteční</i> a/nebo <i>konečné</i> datum!</b>',
	'usagestatisticsintervalday' => 'Den',
	'usagestatisticsintervalweek' => 'Týden',
	'usagestatisticsintervalmonth' => 'Měsíc',
	'usagestatisticsincremental' => 'Inkrementální',
	'usagestatisticsincremental-text' => 'inkrementální',
	'usagestatisticscumulative' => 'Kumulativní',
	'usagestatisticscumulative-text' => 'kumulativní',
	'usagestatisticscalselect' => 'Vybrat',
	'usagestatistics-editindividual' => 'Statistika úprav jednotlivého uživatele $1',
	'usagestatistics-editpages' => 'Statistika stránek jednotlivého uživatele $1',
	'right-viewsystemstats' => 'Prohlížení [[Special:UserStats|statistik využití wiki]]',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'usagestatisticsintervalmonth' => 'Måned',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Gnu1742
 * @author Katharina Wolkwitz
 * @author Melancholie
 * @author Pill
 * @author Purodha
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'specialuserstats' => 'Nutzungs-Statistik',
	'usagestatistics' => 'Nutzungs-Statistik',
	'usagestatistics-desc' => 'Zeigt individuelle Benutzer- und allgemeine Wiki-Nutzungsstatistiken an',
	'usagestatisticsfor' => '<h2>Nutzungs-Statistik für [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Nutzungs-Statistik für alle Benutzer</h2>',
	'usagestatisticsinterval' => 'Zeitraum:',
	'usagestatisticsnamespace' => 'Namensraum:',
	'usagestatisticsexcluderedirects' => 'Weiterleitungen ausschließen',
	'usagestatistics-namespace' => 'Dies sind Statistiken aus dem [[Special:Allpages/$1|$2]]-Namensraum.',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Weiterleitungsseiten]] werden nicht berücksichtigt.',
	'usagestatisticstype' => 'Berechnungsart',
	'usagestatisticsstart' => 'Start-Datum:',
	'usagestatisticsend' => 'End-Datum:',
	'usagestatisticssubmit' => 'Statistik generieren',
	'usagestatisticsnostart' => 'Start-Datum eingeben',
	'usagestatisticsnoend' => 'End-Datum eingeben',
	'usagestatisticsbadstartend' => '<b>Unpassendes/fehlerhaftes <i>Start-Datum</i> oder <i>End-Datum</i> !</b>',
	'usagestatisticsintervalday' => 'Tag',
	'usagestatisticsintervalweek' => 'Woche',
	'usagestatisticsintervalmonth' => 'Monat',
	'usagestatisticsincremental' => 'Inkrementell',
	'usagestatisticsincremental-text' => 'aufsteigend',
	'usagestatisticscumulative' => 'Kumulativ',
	'usagestatisticscumulative-text' => 'gehäuft',
	'usagestatisticscalselect' => 'Wähle',
	'usagestatistics-editindividual' => 'Individuelle Bearbeitungsstatistiken für Benutzer $1',
	'usagestatistics-editpages' => 'Individuelle Seitenstatistiken für Benutzer $1',
	'right-viewsystemstats' => '[[Special:UserStats|Benutzer-Nutzungsstatistiken]] sehen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'specialuserstats' => 'Wužywańska statistika',
	'usagestatistics' => 'Wužywańska statistika',
	'usagestatistics-desc' => 'Wužywańsku statistiku jadnotliwego wužywarja a cełego wikija pokazaś',
	'usagestatisticsfor' => '<h2>Wužywańska statistika za [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Wužywańska statistika za wšych wužywarjow</h2>',
	'usagestatisticsinterval' => 'Interwal:',
	'usagestatisticsnamespace' => 'Mjenjowy rum:',
	'usagestatisticsexcluderedirects' => 'Dalejpósrědnjenja wuzamknuś',
	'usagestatistics-namespace' => 'To jo statistika wó mjenjowem rumje [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Dalejpósrědnjenja]] njejsu zapśimjone.',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsstart' => 'Zachopny datum:',
	'usagestatisticsend' => 'Kóńcny datum:',
	'usagestatisticssubmit' => 'Statistiku napóraś',
	'usagestatisticsnostart' => 'Pódaj pšosym zachopny datum',
	'usagestatisticsnoend' => 'Pódaj pšosym kóńcny datum',
	'usagestatisticsbadstartend' => '<b>Zmólkaty <i>zachopny</i> a/abo <i>kóńcny</i> datum!</b>',
	'usagestatisticsintervalday' => 'Źeń',
	'usagestatisticsintervalweek' => 'Tyźeń',
	'usagestatisticsintervalmonth' => 'Mjasec',
	'usagestatisticsincremental' => 'Inkrementalna',
	'usagestatisticsincremental-text' => 'Inkrementalna',
	'usagestatisticscumulative' => 'Kumulatiwna',
	'usagestatisticscumulative-text' => 'kumulatiwna',
	'usagestatisticscalselect' => 'Wubraś',
	'usagestatistics-editindividual' => 'Statistika změnow jadnotliwego wužywarja $1',
	'usagestatistics-editpages' => 'Statistika bokow jadnotliwego wužywarja $1',
	'right-viewsystemstats' => '[[Special:UserStats|Wikijowu wužywańsku statistiku]] se woglědaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'specialuserstats' => 'Στατιστικά χρήσης',
	'usagestatistics' => 'Στατιστικά χρήσης',
	'usagestatistics-desc' => 'Προβολή στατιστικών χρήσης για το μεμονωμένο χρήστη αλλά και για το σύνολο του βίκι',
	'usagestatisticsfor' => '<h2>Στατιστικά χρήσης για τον [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Στατιστικά χρήσης για όλους τους χρήστες</h2>',
	'usagestatisticsinterval' => 'Διάστημα:',
	'usagestatisticsnamespace' => 'Περιοχή ονομάτων:',
	'usagestatisticsexcluderedirects' => 'Εξαίρεση ανακατευθύνσεων',
	'usagestatisticstype' => 'Τύπος',
	'usagestatisticsstart' => 'Ημερομηνία έναρξης:',
	'usagestatisticsend' => 'Ημερομηνία λήξης:',
	'usagestatisticssubmit' => 'Παραγωγή στατιστικών',
	'usagestatisticsnostart' => 'Παρακαλώ καταχωρήστε μια ημερομηνία έναρξης',
	'usagestatisticsnoend' => 'Παρακαλώ καταχωρήστε μια ημερομηνία λήξης',
	'usagestatisticsbadstartend' => '<b>Κακή ημερομηνία <i>έναρξης</i> και/ή <i>λήξης</i>!</b>',
	'usagestatisticsintervalday' => 'Ημέρα',
	'usagestatisticsintervalweek' => 'Εβδομάδα',
	'usagestatisticsintervalmonth' => 'Μήνας',
	'usagestatisticsincremental' => 'Επαυξητικό',
	'usagestatisticsincremental-text' => 'επαυξητικό',
	'usagestatisticscumulative' => 'Συσσωρευτικό',
	'usagestatisticscumulative-text' => 'συσσωρευτικό',
	'usagestatisticscalselect' => 'Επιλέξτε',
	'usagestatistics-editindividual' => 'Μεμονωμένα στατιστικά επεξεργασιών του χρήστη $1',
	'usagestatistics-editpages' => 'Μεμονωμένα στατιστικά σελίδων του χρήστη $1',
	'right-viewsystemstats' => 'Εμφάνιση [[Special:UserStats|στατιστικών χρήσης του βίκι]]',
);

/** Esperanto (Esperanto)
 * @author Lucas
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'specialuserstats' => 'Statistiko de uzado',
	'usagestatistics' => 'Statistiko de uzado',
	'usagestatistics-desc' => 'Montru individuan uzanton kaj ĉiun statistikon pri uzado de vikio',
	'usagestatisticsfor' => '<h2>Statistiko pri uzado por [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Uzadaj statistikoj por ĉiuj uzantoj</h2>',
	'usagestatisticsinterval' => 'Intervalo:',
	'usagestatisticsnamespace' => 'Nomspaco:',
	'usagestatisticsexcluderedirects' => 'Ekskluzivi alidirektilojn',
	'usagestatisticstype' => 'Speco',
	'usagestatisticsstart' => 'Komencodato:',
	'usagestatisticsend' => 'Findato:',
	'usagestatisticssubmit' => 'Generu statistikojn',
	'usagestatisticsnostart' => 'Bonvolu entajpi komenco-daton.',
	'usagestatisticsnoend' => 'Bonvolu entajpi fino-daton.',
	'usagestatisticsbadstartend' => '<b>Malbona <i>Komenca</i> kaj/aŭ <i>Fina</i> dato!</b>',
	'usagestatisticsintervalday' => 'Tago',
	'usagestatisticsintervalweek' => 'Semajno',
	'usagestatisticsintervalmonth' => 'Monato',
	'usagestatisticsincremental' => 'Krementa <!-- laŭ Komputada Leksikono -->',
	'usagestatisticsincremental-text' => 'Krementa <!-- laŭ Komputada Leksikono -->',
	'usagestatisticscumulative' => 'Akumulita',
	'usagestatisticscumulative-text' => 'akumulita',
	'usagestatisticscalselect' => 'Elektu',
	'usagestatistics-editindividual' => 'Individua uzanto $1 redaktoj statistikoj',
	'usagestatistics-editpages' => 'Individua uzanto $1 paĝoj statistikoj',
	'right-viewsystemstats' => 'Vidi [[Special:UserStats|statistikojn pri vikia uzado]]',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'specialuserstats' => 'Estadísticas de uso',
	'usagestatistics' => 'Estadísticas de uso',
	'usagestatistics-desc' => 'Mostrar usuario individual y vista general de estadísticas de uso del wiki',
	'usagestatisticsfor' => '<h2>Estadísticas de uso para [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Estadísticas de uso para todos los usuarios</h2>',
	'usagestatisticsinterval' => 'Intervalo:',
	'usagestatisticsnamespace' => 'Espacio de nombre:',
	'usagestatisticsexcluderedirects' => 'Excluir redirecionamientos',
	'usagestatistics-namespace' => 'Estas son estadísticas en el espacio de nombre [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Redireccionamientos]] no son tomados en cuenta.',
	'usagestatisticstype' => 'Tipo',
	'usagestatisticsstart' => 'Fecha de inicio:',
	'usagestatisticsend' => 'Fecha de fin:',
	'usagestatisticssubmit' => 'Generar estadísticas',
	'usagestatisticsnostart' => 'Por favor especifique una fecha de inicio',
	'usagestatisticsnoend' => 'Especifique una fecha de fin, por favor',
	'usagestatisticsbadstartend' => '<b>¡La fecha de <i>inicio</i> o la de <i>fin</i> es incorrecta!</b>',
	'usagestatisticsintervalday' => 'Día',
	'usagestatisticsintervalweek' => 'Semana',
	'usagestatisticsintervalmonth' => 'Mes',
	'usagestatisticsincremental' => 'Creciente',
	'usagestatisticsincremental-text' => 'creciente',
	'usagestatisticscumulative' => 'Acumulativo',
	'usagestatisticscumulative-text' => 'Acumulativo',
	'usagestatisticscalselect' => 'Seleccionar',
	'usagestatistics-editindividual' => 'Estadísticas de ediciones de usuario individual $1',
	'usagestatistics-editpages' => 'Estadísticas de páginas de usuario individual $1',
	'right-viewsystemstats' => 'Ver [[Special:UserStats|estadísticas de uso del wiki]]',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'specialuserstats' => 'Kasutuse statistika',
	'usagestatistics' => 'Kasutuse statistika',
	'usagestatisticsinterval' => 'Ajavahemik:',
	'usagestatisticsnamespace' => 'Nimeruum:',
	'usagestatisticsexcluderedirects' => 'Jäta ümbersuunamisleheküljed välja',
	'usagestatisticstype' => 'Tüüp',
	'usagestatisticsstart' => 'Alguse kuupäev:',
	'usagestatisticsend' => 'Lõpu kuupäev:',
	'usagestatisticsnostart' => 'Palun märgi alguse kuupäev',
	'usagestatisticsnoend' => 'Palun märgi lõpu kuupäev',
	'usagestatisticsintervalday' => 'Päev',
	'usagestatisticsintervalweek' => 'Nädal',
	'usagestatisticsintervalmonth' => 'Kuu',
	'usagestatisticsincremental' => 'Kuhjuv',
	'usagestatisticsincremental-text' => 'kuhjuvad',
	'usagestatisticscumulative' => 'Kogunenud',
	'usagestatisticscumulative-text' => 'kogunenud',
	'usagestatisticscalselect' => 'Vali',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'specialuserstats' => 'Erabilpen-estatistikak',
	'usagestatistics' => 'Erabilpen-estatistikak',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]] lankidearen erabilpen-estatistikak</h2>',
	'usagestatisticsforallusers' => '<h2>Lankide guztien erabilpen-estatistikak</h2>',
	'usagestatisticsinterval' => 'Denbora-tartea:',
	'usagestatisticstype' => 'Mota',
	'usagestatisticsstart' => 'Hasiera data:',
	'usagestatisticsend' => 'Amaiera data:',
	'usagestatisticssubmit' => 'Estatistikak sortu',
	'usagestatisticsnostart' => 'Hasierako data zehaztu, mesedez',
	'usagestatisticsnoend' => 'Amaierako data zehaztu, mesedez',
	'usagestatisticsbadstartend' => '<b><i>Hasiera</i> eta/edo <i>bukaera</i> data okerra!</b>',
	'usagestatisticsintervalday' => 'Eguna',
	'usagestatisticsintervalweek' => 'Astea',
	'usagestatisticsintervalmonth' => 'Hilabetea',
	'usagestatisticsincremental' => 'Inkrementala',
	'usagestatisticsincremental-text' => 'inkrementala',
	'usagestatisticscalselect' => 'Aukeratu',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Huji
 */
$messages['fa'] = array(
	'usagestatisticsstart' => 'تاریخ آغاز',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Japsu
 * @author Kulmalukko
 * @author Mobe
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'specialuserstats' => 'Käyttäjäkohtaiset tilastot',
	'usagestatistics' => 'Käyttäjäkohtaiset tilastot',
	'usagestatistics-desc' => 'Näyttää käyttötilastoja yksittäisestä käyttäjästä ja wikin kokonaisuudesta.',
	'usagestatisticsfor' => '<h2>Käyttäjäkohtaiset tilastot ([[User:$1|$1]])</h2>',
	'usagestatisticsforallusers' => '<h2>Käyttötilastot kaikilta käyttäjiltä</h2>',
	'usagestatisticsinterval' => 'Aikaväli',
	'usagestatisticsnamespace' => 'Nimiavaruus:',
	'usagestatisticsexcluderedirects' => 'Jätä pois ohjaukset',
	'usagestatistics-namespace' => 'Nämä ovat tilastot nimiavaruudessa [[Special:Allpages/$1|$2]].',
	'usagestatisticstype' => 'Tyyppi',
	'usagestatisticsstart' => 'Aloituspäivä',
	'usagestatisticsend' => 'Lopetuspäivä',
	'usagestatisticssubmit' => 'Hae tilastot',
	'usagestatisticsnostart' => 'Syötä aloituspäivä',
	'usagestatisticsnoend' => 'Syötä lopetuspäivä',
	'usagestatisticsbadstartend' => '<b>Aloitus- tai lopetuspäivä ei kelpaa! Tarkista päivämäärät.</b>',
	'usagestatisticsintervalday' => 'Päivä',
	'usagestatisticsintervalweek' => 'Viikko',
	'usagestatisticsintervalmonth' => 'Kuukausi',
	'usagestatisticsincremental' => 'kasvava',
	'usagestatisticsincremental-text' => 'kasvavat',
	'usagestatisticscumulative' => 'kasaantuva',
	'usagestatisticscumulative-text' => 'kasaantuvat',
	'usagestatisticscalselect' => 'Valitse',
	'usagestatistics-editindividual' => 'Yksittäisen käyttäjän $1 muokkaustilastot',
	'usagestatistics-editpages' => 'Yksittäisen käyttäjän $1 sivutilastot',
	'right-viewsystemstats' => 'Näytä [[Special:UserStats|wikin käyttötilastoja]]',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author PieRRoMaN
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'specialuserstats' => 'Statistiques d’utilisation',
	'usagestatistics' => 'Statistiques d’utilisation',
	'usagestatistics-desc' => 'Affiche les statistiques d’utilisation par utilisateur et pour l’ensemble du wiki',
	'usagestatisticsfor' => '<h2>Statistiques d’utilisation pour [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistiques d’utilisation pour tous les utilisateurs</h2>',
	'usagestatisticsinterval' => 'Intervalle :',
	'usagestatisticsnamespace' => 'Espace de noms :',
	'usagestatisticsexcluderedirects' => 'Exclure les redirections',
	'usagestatistics-namespace' => "Ces statistiques sont sur l'espace de noms [[Special:Allpages/$1|$2]].",
	'usagestatistics-noredirects' => 'Les [[Special:ListRedirects|redirections]] ne sont pas prises en compte.',
	'usagestatisticstype' => 'Type',
	'usagestatisticsstart' => 'Date de début :',
	'usagestatisticsend' => 'Date de fin :',
	'usagestatisticssubmit' => 'Générer les statistiques',
	'usagestatisticsnostart' => 'Veuillez spécifier une date de début',
	'usagestatisticsnoend' => 'Veuillez spécifier une date de fin',
	'usagestatisticsbadstartend' => '<b>Mauvais format de date de <i>début</i> ou de <i>fin</i> !</b>',
	'usagestatisticsintervalday' => 'Jour',
	'usagestatisticsintervalweek' => 'Semaine',
	'usagestatisticsintervalmonth' => 'Mois',
	'usagestatisticsincremental' => 'Incrémental',
	'usagestatisticsincremental-text' => 'incrémentales',
	'usagestatisticscumulative' => 'Cumulatif',
	'usagestatisticscumulative-text' => 'cumulatives',
	'usagestatisticscalselect' => 'Sélectionner',
	'usagestatistics-editindividual' => 'Statistiques $1 des modifications par utilisateur',
	'usagestatistics-editpages' => 'Statistiques $1 des pages par utilisateur',
	'right-viewsystemstats' => 'Voir les [[Special:UserStats|statistiques d’utilisation du wiki]]',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'usagestatisticsinterval' => 'Entèrvalo',
	'usagestatisticstype' => 'Tipo',
	'usagestatisticsstart' => 'Dâta de comencement',
	'usagestatisticsend' => 'Dâta de fin',
	'usagestatisticssubmit' => 'Fâre les statistiques',
	'usagestatisticsintervalday' => 'Jorn',
	'usagestatisticsintervalweek' => 'Semana',
	'usagestatisticsintervalmonth' => 'Mês',
	'usagestatisticsincremental' => 'Encrèmentâl',
	'usagestatisticsincremental-text' => 'encrèmentâles',
	'usagestatisticscumulative' => 'Cumulatif',
	'usagestatisticscumulative-text' => 'cumulatives',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'usagestatisticstype' => 'Saghas',
	'usagestatisticsintervalday' => 'Lá',
	'usagestatisticsintervalweek' => 'Seachtain',
	'usagestatisticsintervalmonth' => 'Mí',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'specialuserstats' => 'Estatísticas de uso',
	'usagestatistics' => 'Estatísticas de uso',
	'usagestatistics-desc' => 'Amosar as estatíticas de uso do usuario individual e mais as do wiki en xeral',
	'usagestatisticsfor' => '<h2>Estatísticas de uso de "[[User:$1|$1]]"</h2>',
	'usagestatisticsforallusers' => '<h2>Estatísticas de uso de todos os usuarios</h2>',
	'usagestatisticsinterval' => 'Intervalo:',
	'usagestatisticsnamespace' => 'Espazo de nomes:',
	'usagestatisticsexcluderedirects' => 'Excluír as redireccións',
	'usagestatistics-namespace' => 'Estas son as estatísticas do espazo de nomes [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'Non se teñen en conta as [[Special:ListRedirects|redireccións]].',
	'usagestatisticstype' => 'Clase',
	'usagestatisticsstart' => 'Data de comezo:',
	'usagestatisticsend' => 'Data de fin:',
	'usagestatisticssubmit' => 'Xerar as estatísticas',
	'usagestatisticsnostart' => 'Por favor, especifique unha data de comezo',
	'usagestatisticsnoend' => 'Por favor, especifique unha data de fin',
	'usagestatisticsbadstartend' => '<b>Data de <i>comezo</i> e/ou <i>fin</i> errónea!</b>',
	'usagestatisticsintervalday' => 'Día',
	'usagestatisticsintervalweek' => 'Semana',
	'usagestatisticsintervalmonth' => 'Mes',
	'usagestatisticsincremental' => 'Incremental',
	'usagestatisticsincremental-text' => 'incrementais',
	'usagestatisticscumulative' => 'Acumulativo',
	'usagestatisticscumulative-text' => 'acumulativas',
	'usagestatisticscalselect' => 'Seleccionar',
	'usagestatistics-editindividual' => 'Estatísticas das edicións $1 do usuario',
	'usagestatistics-editpages' => 'Páxinas das estatísticas $1 do usuario',
	'right-viewsystemstats' => 'Ver as [[Special:UserStats|estatísticas de uso do wiki]]',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'usagestatisticsnamespace' => 'Ὀνοματεῖον:',
	'usagestatisticstype' => 'Τύπος',
	'usagestatisticsintervalday' => 'Ἡμέρα',
	'usagestatisticsintervalmonth' => 'Μήν',
	'usagestatisticscalselect' => 'Ἐπιλέγειν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'specialuserstats' => 'Nutzigs-Statischtik',
	'usagestatistics' => 'Nutzigs-Statischtik',
	'usagestatistics-desc' => 'Zeigt individuälli Benutzer- un allgmeini Wiki-Nutzigsstatischtiken aa',
	'usagestatisticsfor' => '<h2>Nutzigs-Statischtik fir [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Nutzigs-Statischtik fir alli Benutzer</h2>',
	'usagestatisticsinterval' => 'Zytruum:',
	'usagestatisticsnamespace' => 'Namensruum:',
	'usagestatisticsexcluderedirects' => 'Wyterleitige uusschließe',
	'usagestatistics-namespace' => 'Des sin Statischtike iber dr [[Special:Allpages/$1|$2]]-Namensruum.',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Wyterleitige]] wäre nit zellt.',
	'usagestatisticstype' => 'Berächnigsart',
	'usagestatisticsstart' => 'Start-Datum:',
	'usagestatisticsend' => 'Änd-Datum:',
	'usagestatisticssubmit' => 'Statischtik generiere',
	'usagestatisticsnostart' => 'Start-Datum yygee',
	'usagestatisticsnoend' => 'Änd-Datum yygee',
	'usagestatisticsbadstartend' => '<b>Falsch <i>Start-Datum</i> oder <i>Änd-Datum</i> !</b>',
	'usagestatisticsintervalday' => 'Tag',
	'usagestatisticsintervalweek' => 'Wuche',
	'usagestatisticsintervalmonth' => 'Monet',
	'usagestatisticsincremental' => 'Inkrementell',
	'usagestatisticsincremental-text' => 'obsgi',
	'usagestatisticscumulative' => 'Kumulativ',
	'usagestatisticscumulative-text' => 'ghyflet',
	'usagestatisticscalselect' => 'Wehl',
	'usagestatistics-editindividual' => 'Individuälli Bearbeitigsstatischtike fir Benutzer $1',
	'usagestatistics-editpages' => 'Individuälli Sytestatischtike fir Benutzer $1',
	'right-viewsystemstats' => '[[Special:UserStats|Wiki-Nutzigs-Statischtik]] aaluege',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'specialuserstats' => 'વપરાશના આંકડા',
	'usagestatistics' => 'વપરાશના આંકડા',
	'usagestatistics-desc' => 'વ્યક્તિગત સભ્ય અને સમગ્ર વિકિ વપરાશના આંકડાઓ બતાવો',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]]ના વપરાશના આંકડાઓ</h2>',
	'usagestatisticsforallusers' => '<h2>બધા સભ્યોના વપરાશના આંકડાઓ</h2>',
	'usagestatisticsinterval' => 'વિરામ',
	'usagestatisticstype' => 'પ્રકાર',
	'usagestatisticsstart' => 'આરંભ તારીખ',
	'usagestatisticsend' => 'અંતિમ તારીખ',
	'usagestatisticssubmit' => 'આંકડાઓ દર્શાવો',
	'usagestatisticsnostart' => 'કૃપયા આરંભ તારીખ જણાવો',
	'usagestatisticsnoend' => 'કૃપયા અંતિમ તારીખ જણાવો',
	'usagestatisticsbadstartend' => '<b>અમાન્ય <i>આરંભ</i> અને/અથવા <i>અંતિમ</i> તારીખ!</b>',
	'usagestatisticsintervalday' => 'દિવસ',
	'usagestatisticsintervalweek' => 'સપ્તાહ',
	'usagestatisticsintervalmonth' => 'મહીનો',
	'usagestatisticsincremental' => 'ચઢતા ક્રમમાં',
	'usagestatisticsincremental-text' => 'ચઢતા ક્રમમાં',
	'usagestatisticscumulative' => 'સંચિત ક્રમમાં',
	'usagestatisticscumulative-text' => 'સંચિત ક્રમમાં',
	'usagestatisticscalselect' => 'પસંદ કરો',
	'usagestatistics-editindividual' => 'વ્યક્તિગત સભ્ય $1 સંપાદનના આંકડાઓ',
	'usagestatistics-editpages' => 'વ્યક્તિગત સભ્ય $1 પાનાઓના આંકડાઓ',
	'right-viewsystemstats' => 'જુઓ [[Special:UserStats|વિકિ વપરાશના આંકડા]]',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'specialuserstats' => 'סטטיסטיקות שימוש',
	'usagestatistics' => 'סטטיסטיקות שימוש',
	'usagestatistics-desc' => 'הצגת סטטיסטיקת השימוש של משתמש יחיד ושל כל האתר',
	'usagestatisticsfor' => '<h2>סטטיסטיקות השימוש של [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>סטטיסטיקות שימוש של כל המשתמשים</h2>',
	'usagestatisticsinterval' => 'מרווח:',
	'usagestatisticsnamespace' => 'מרחב שם:',
	'usagestatisticsexcluderedirects' => 'התעלמות מהפניות',
	'usagestatistics-namespace' => 'אלו סטטיסטיקות במרחב השם [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|הפניות]] אינן נלקחות בחשבון.',
	'usagestatisticstype' => 'סוג',
	'usagestatisticsstart' => 'תאריך ההתחלה:',
	'usagestatisticsend' => 'תאריך הסיום:',
	'usagestatisticssubmit' => 'יצירת סטטיסטיקות',
	'usagestatisticsnostart' => 'אנא ציינו תאריך התחלה',
	'usagestatisticsnoend' => 'אנא ציינו תאריך סיום',
	'usagestatisticsbadstartend' => '<b>תאריך <i>ההתחלה</i> ו/או תאריך <i>הסיום</i> בעייתיים!</b>',
	'usagestatisticsintervalday' => 'יום',
	'usagestatisticsintervalweek' => 'שבוע',
	'usagestatisticsintervalmonth' => 'חודש',
	'usagestatisticsincremental' => 'מתווספת',
	'usagestatisticsincremental-text' => 'מתווספת',
	'usagestatisticscumulative' => 'מצטברת',
	'usagestatisticscumulative-text' => 'מצטבר',
	'usagestatisticscalselect' => 'בחירה',
	'usagestatistics-editindividual' => 'סטטיסטיקת עריכות של המשתמש היחיד $1',
	'usagestatistics-editpages' => 'סטטיסטיקות הדפים של המשתמש היחיד $1',
	'right-viewsystemstats' => 'צפייה ב[[Special:UserStats|סטטיסטיקת השימוש בוויקי]]',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'usagestatisticstype' => 'प्रकार',
	'usagestatisticsintervalmonth' => 'महिना',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 */
$messages['hr'] = array(
	'specialuserstats' => 'Statistika upotrebe',
	'usagestatistics' => 'Statistika upotrebe',
	'usagestatistics-desc' => 'Pokazuje statistku upotrebe za pojedinog suradnika i cijele wiki',
	'usagestatisticsfor' => '<h2>Statistika upotrebe za suradnika [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistika upotrebe za sve suradnike</h2>',
	'usagestatisticsinterval' => 'Razdoblje',
	'usagestatisticstype' => 'Vrsta',
	'usagestatisticsstart' => 'Početni datum',
	'usagestatisticsend' => 'Završni datum',
	'usagestatisticssubmit' => 'Izračunaj statistiku',
	'usagestatisticsnostart' => 'Molimo, odaberite početni datum',
	'usagestatisticsnoend' => 'Molimo, odaberite završni datum',
	'usagestatisticsbadstartend' => '<b>Nevažeći <i>početni</i> i/ili <i>završni</i> datum!</b>',
	'usagestatisticsintervalday' => 'Dan',
	'usagestatisticsintervalweek' => 'Tjedan',
	'usagestatisticsintervalmonth' => 'Mjesec',
	'usagestatisticsincremental' => 'Inkrementalno',
	'usagestatisticsincremental-text' => 'inkrementalno',
	'usagestatisticscumulative' => 'Kumulativno',
	'usagestatisticscumulative-text' => 'kumulativno',
	'usagestatisticscalselect' => 'Odabir',
	'usagestatistics-editindividual' => 'Statistika uređivanja individualnog suradnika $1',
	'usagestatistics-editpages' => 'Statistika stranica individualnog suradnika $1',
	'right-viewsystemstats' => 'Pogledaj [[Special:UserStats|wiki statistike korištenja]]',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'specialuserstats' => 'Wužiwanska statistika',
	'usagestatistics' => 'Wužiwanska statistika',
	'usagestatistics-desc' => 'Statistika jednotliwych wužiwarja a cyłkownu wikijowu statistiku pokazać',
	'usagestatisticsfor' => '<h2>Wužiwanska statistika za [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Wužiwanska statistika za wšěch wužiwarjow</h2>',
	'usagestatisticsinterval' => 'Interwal:',
	'usagestatisticsnamespace' => 'Mjenowy rum:',
	'usagestatisticsexcluderedirects' => 'Dalesposrědkowanja wuzamknyć',
	'usagestatistics-namespace' => 'To je statistika wo mjenowym rumje [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Dalesposrědkowanja]] njejsu zapřijate.',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsstart' => 'Spočatny datum:',
	'usagestatisticsend' => 'Kónčny datum:',
	'usagestatisticssubmit' => 'Statistiku wutworić',
	'usagestatisticsnostart' => 'Podaj prošu spočatny datum',
	'usagestatisticsnoend' => 'Podaj prošu kónčny datum',
	'usagestatisticsbadstartend' => '<b>Njepłaćiwy <i>spočatny</i> a/abo <i>kónčny</i> datum!</b>',
	'usagestatisticsintervalday' => 'Dźeń',
	'usagestatisticsintervalweek' => 'Tydźeń',
	'usagestatisticsintervalmonth' => 'Měsac',
	'usagestatisticsincremental' => 'Inkrementalny',
	'usagestatisticsincremental-text' => 'inkrementalny',
	'usagestatisticscumulative' => 'Kumulatiwny',
	'usagestatisticscumulative-text' => 'kumulatiwny',
	'usagestatisticscalselect' => 'Wubrać',
	'usagestatistics-editindividual' => 'Indiwiduelna statistika změnow wužiwarja $1',
	'usagestatistics-editpages' => 'Indiwiduelna statistika stronow wužiwarja $1',
	'right-viewsystemstats' => '[[Special:UserStats|Wikijowu wužiwansku statistiku]] sej wobhladać',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'specialuserstats' => 'Használati statisztika',
	'usagestatistics' => 'Használati statisztika',
	'usagestatistics-desc' => 'Egyedi felhasználói és összesített wiki használati statisztika',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]] használati statisztikái</h2>',
	'usagestatisticsforallusers' => '<h2>Az összes felhasználó használati statisztikái</h2>',
	'usagestatisticsinterval' => 'Intervallum:',
	'usagestatisticsnamespace' => 'Névtér:',
	'usagestatisticsexcluderedirects' => 'Átirányítások kihagyása',
	'usagestatistics-namespace' => 'Ezek a(z) [[Special:Allpages/$1|$2]] névtér statisztikái.',
	'usagestatistics-noredirects' => 'Az [[Special:ListRedirects|átirányítások]] nem lettek beszámítva.',
	'usagestatisticstype' => 'Típus',
	'usagestatisticsstart' => 'Kezdődátum:',
	'usagestatisticsend' => 'Végdátum:',
	'usagestatisticssubmit' => 'Statisztikák elkészítése',
	'usagestatisticsnostart' => 'Adj meg egy kezdődátumot',
	'usagestatisticsnoend' => 'Adj meg egy végdátumot',
	'usagestatisticsbadstartend' => '<b>Hibás <i>kezdő-</i> és/vagy <i>vég</i>dátum!</b>',
	'usagestatisticsintervalday' => 'Nap',
	'usagestatisticsintervalweek' => 'Hét',
	'usagestatisticsintervalmonth' => 'Hónap',
	'usagestatisticsincremental' => 'Inkrementális',
	'usagestatisticsincremental-text' => 'inkrementális',
	'usagestatisticscumulative' => 'Kumulatív',
	'usagestatisticscumulative-text' => 'kumulatív',
	'usagestatisticscalselect' => 'Kiválaszt',
	'usagestatistics-editindividual' => '$1 felhasználó egyedi szerkesztési statisztikái',
	'usagestatistics-editpages' => '$1 felhasználó egyedi lapstatisztikái',
	'right-viewsystemstats' => 'A [[Special:UserStats|wiki használati statisztikáinak]] megjelenítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'specialuserstats' => 'Statisticas de uso',
	'usagestatistics' => 'Statisticas de uso',
	'usagestatistics-desc' => 'Monstra statisticas del usator individual e del uso general del wiki',
	'usagestatisticsfor' => '<h2>Statisticas de uso pro [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statisticas de uso pro tote le usatores</h2>',
	'usagestatisticsinterval' => 'Intervallo:',
	'usagestatisticsnamespace' => 'Spatio de nomines:',
	'usagestatisticsexcluderedirects' => 'Excluder redirectiones',
	'usagestatistics-namespace' => 'Iste statisticas es super le spatio de nomines [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'Le [[Special:ListRedirects|redirectiones]] non es prendite in conto.',
	'usagestatisticstype' => 'Typo',
	'usagestatisticsstart' => 'Data de initio:',
	'usagestatisticsend' => 'Data de fin:',
	'usagestatisticssubmit' => 'Generar statisticas',
	'usagestatisticsnostart' => 'Per favor specifica un data de initio',
	'usagestatisticsnoend' => 'Per favor specifica un data de fin',
	'usagestatisticsbadstartend' => '<b>Mal data de <i>initio</i> e/o de <i>fin</i>!</b>',
	'usagestatisticsintervalday' => 'Die',
	'usagestatisticsintervalweek' => 'Septimana',
	'usagestatisticsintervalmonth' => 'Mense',
	'usagestatisticsincremental' => 'Incremental',
	'usagestatisticsincremental-text' => 'incremental',
	'usagestatisticscumulative' => 'Cumulative',
	'usagestatisticscumulative-text' => 'cumulative',
	'usagestatisticscalselect' => 'Seliger',
	'usagestatistics-editindividual' => 'Statisticas $1 super le modificationes del usator individual',
	'usagestatistics-editpages' => 'Statisticas $1 super le paginas del usator individual',
	'right-viewsystemstats' => 'Vider [[Special:UserStats|statisticas de uso del wiki]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 */
$messages['id'] = array(
	'specialuserstats' => 'Statistik penggunaan',
	'usagestatistics' => 'Statistik penggunaan',
	'usagestatistics-desc' => 'Perlihatkan statistik pengguna individual dan keseluruhan wiki',
	'usagestatisticsfor' => '<h2>Statistik untuk [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistik untuk seluruh pengguna</h2>',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticsnamespace' => 'Ruangnama:',
	'usagestatisticsexcluderedirects' => 'Kecuali pengalihan',
	'usagestatistics-namespace' => 'Terdapat stistik pada ruangnama [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Pengalihan]] tidak diperhitungkan.',
	'usagestatisticstype' => 'Tipe',
	'usagestatisticsstart' => 'Tanggal mulai:',
	'usagestatisticsend' => 'Tanggal selesai:',
	'usagestatisticssubmit' => 'Tunjukkan statistik',
	'usagestatisticsnostart' => 'Masukkan tanggal mulai',
	'usagestatisticsnoend' => 'Masukkan tanggal selesai',
	'usagestatisticsbadstartend' => '<b>Tanggal <i>mulai</i> dan/atau <i>selesai</i> salah!</b>',
	'usagestatisticsintervalday' => 'Tanggal',
	'usagestatisticsintervalweek' => 'Minggu',
	'usagestatisticsintervalmonth' => 'Bulan',
	'usagestatisticsincremental' => 'Bertahap',
	'usagestatisticsincremental-text' => 'bertahap',
	'usagestatisticscumulative' => 'Kumulatif',
	'usagestatisticscumulative-text' => 'kumulatif',
	'usagestatisticscalselect' => 'Pilih',
	'usagestatistics-editindividual' => 'Statistik penyuntingan $1 pengguna individual',
	'usagestatistics-editpages' => 'Statistik halaman $1 pengguna individual',
	'right-viewsystemstats' => 'Lihat [[Special:UserStats|statistik wiki]]',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'usagestatisticsintervalday' => 'Dio',
);

/** Icelandic (Íslenska) */
$messages['is'] = array(
	'usagestatisticsintervalday' => 'Dagur',
	'usagestatisticsintervalweek' => 'Vika',
	'usagestatisticsintervalmonth' => 'Mánuður',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'specialuserstats' => 'Statistiche di utilizzo',
	'usagestatistics' => 'Statistiche di utilizzo',
	'usagestatistics-desc' => 'Mostra le statistiche di utilizzo individuali per utente e globali per il sito',
	'usagestatisticsfor' => '<h2>Statistiche di utilizzo per [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistiche di utilizzo per tutti gli utenti</h2>',
	'usagestatisticsinterval' => 'Periodo:',
	'usagestatisticsnamespace' => 'Namespace:',
	'usagestatisticsexcluderedirects' => 'Escludi redirect',
	'usagestatistics-namespace' => 'Queste sono statistiche sul namespace [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'I [[Special:ListRedirects|redirect]] non sono presi in considerazione.',
	'usagestatisticstype' => 'Tipo',
	'usagestatisticsstart' => 'Data di inizio:',
	'usagestatisticsend' => 'Data di fine:',
	'usagestatisticssubmit' => 'Genera statistiche',
	'usagestatisticsnostart' => 'Specificare una data iniziale',
	'usagestatisticsnoend' => 'Specificare una data di fine',
	'usagestatisticsbadstartend' => '<b>Data <i>iniziale</i> o <i>finale</i> errata.</b>',
	'usagestatisticsintervalday' => 'Giorno',
	'usagestatisticsintervalweek' => 'Settimana',
	'usagestatisticsintervalmonth' => 'Mese',
	'usagestatisticsincremental' => 'Incrementali',
	'usagestatisticsincremental-text' => 'incrementali',
	'usagestatisticscumulative' => 'Cumulative',
	'usagestatisticscumulative-text' => 'cumulative',
	'usagestatisticscalselect' => 'Seleziona',
	'usagestatistics-editindividual' => 'Statistiche $1 sulle modifiche per singolo utente',
	'usagestatistics-editpages' => 'Statistiche $1 sulle pagine per singolo utente',
	'right-viewsystemstats' => 'Visualizza [[Special:UserStats|statistiche di uso del sito wiki]]',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'specialuserstats' => '利用統計',
	'usagestatistics' => '利用統計',
	'usagestatistics-desc' => '個々の利用者およびウィキ全体の利用統計を表示する',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]] の利用統計</h2>',
	'usagestatisticsforallusers' => '<h2>全利用者の利用統計</h2>',
	'usagestatisticsinterval' => '間隔:',
	'usagestatisticsnamespace' => '名前空間:',
	'usagestatisticsexcluderedirects' => 'リダイレクトを除く',
	'usagestatistics-namespace' => 'これは[[Special:Allpages/$1|$2]]名前空間における統計です。',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|リダイレクト]]は数に入っていません。',
	'usagestatisticstype' => 'タイプ',
	'usagestatisticsstart' => '開始日:',
	'usagestatisticsend' => '終了日:',
	'usagestatisticssubmit' => '統計を生成',
	'usagestatisticsnostart' => '開始日を指定してください',
	'usagestatisticsnoend' => '終了日を指定してください',
	'usagestatisticsbadstartend' => '<b><i>開始</i>および、あるいは<i>終了</i>の日付が不正です！</b>',
	'usagestatisticsintervalday' => '日',
	'usagestatisticsintervalweek' => '週',
	'usagestatisticsintervalmonth' => '月',
	'usagestatisticsincremental' => '漸進',
	'usagestatisticsincremental-text' => '漸進',
	'usagestatisticscumulative' => '累積',
	'usagestatisticscumulative-text' => '累積',
	'usagestatisticscalselect' => '選択',
	'usagestatistics-editindividual' => '利用者の$1編集統計',
	'usagestatistics-editpages' => '利用者の$1ページ統計',
	'right-viewsystemstats' => '[[Special:UserStats|ウィキの利用統計]]を見る',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'specialuserstats' => 'Statistik olèhé nganggo',
	'usagestatistics' => 'Statistik olèhé nganggo',
	'usagestatistics-desc' => 'Tampilaké statistik panganggo individu lan kabèh panggunaan wiki',
	'usagestatisticsfor' => '<h2>Statistik panggunan kanggo [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistik panggunaan kabèh panganggo</h2>',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticstype' => 'Jenis',
	'usagestatisticsstart' => 'Tanggal miwiti:',
	'usagestatisticsend' => 'Tanggal rampung:',
	'usagestatisticssubmit' => 'Nggawé statistik',
	'usagestatisticsnostart' => 'Temtokaké tanggal miwiti',
	'usagestatisticsnoend' => 'Temtokaké tanggal mungkasi',
	'usagestatisticsbadstartend' => '<b>Tanggal <i>miwiti</i> lan/utawa <i>mungkasi</i> kliru!</b>',
	'usagestatisticsintervalday' => 'Dina',
	'usagestatisticsintervalweek' => 'Minggu (saptawara)',
	'usagestatisticsintervalmonth' => 'Sasi',
	'usagestatisticsincremental' => "Undhak-undhakan (''incremental'')",
	'usagestatisticsincremental-text' => "undhak-undhakan (''incremental'')",
	'usagestatisticscumulative' => 'Kumulatif',
	'usagestatisticscumulative-text' => 'kumulatif',
	'usagestatisticscalselect' => 'Pilih',
	'usagestatistics-editindividual' => 'Statistik panyuntingan panganggo individual $1',
	'usagestatistics-editpages' => 'Statistik kaca panganggo individual $1',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'specialuserstats' => 'ស្ថិតិ​នៃ​ការប្រើប្រាស់',
	'usagestatistics' => 'ស្ថិតិ​នៃ​ការប្រើប្រាស់',
	'usagestatistics-desc' => 'បង្ហាញ​ស្ថិតិ​អ្នកប្រើប្រាស់​ជាឯកត្តៈបុគ្គល និង ការប្រើប្រាស់វិគីទាំងមូល',
	'usagestatisticsfor' => '<h2>ស្ថិតិ​នៃ​ការប្រើប្រាស់​របស់ [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>ស្ថិតិប្រើប្រាស់សម្រាប់គ្រប់អ្នកប្រើប្រាស់ទាំងអស់</h2>',
	'usagestatisticsinterval' => 'ចន្លោះ',
	'usagestatisticsnamespace' => 'ប្រភេទ៖',
	'usagestatisticstype' => 'ប្រភេទ',
	'usagestatisticsstart' => 'កាលបរិច្ឆេទចាប់ផ្តើម',
	'usagestatisticsend' => 'កាលបរិច្ឆេទបញ្ចប់',
	'usagestatisticsnostart' => 'សូម​ធ្វើការ​បញ្ជាក់​ដើម្បី​ចាប់ផ្ដើម​ទិន្នន័យ',
	'usagestatisticsnoend' => 'សូម​ធ្វើការ​បញ្ជាក់​ដើម្បី​បញ្ចប់​ទិន្នន័យ',
	'usagestatisticsintervalday' => 'ថ្ងៃ',
	'usagestatisticsintervalweek' => 'សប្តាហ៍',
	'usagestatisticsintervalmonth' => 'ខែ',
	'usagestatisticsincremental' => 'បន្ថែម',
	'usagestatisticsincremental-text' => 'បន្ថែម',
	'usagestatisticscumulative' => 'សន្សំ',
	'usagestatisticscumulative-text' => 'សន្សំ',
	'usagestatisticscalselect' => 'ជ្រើសយក',
	'usagestatistics-editindividual' => 'អ្នកប្រើប្រាស់​បុគ្គល $1 ស្ថិតិ​កែប្រែ',
	'usagestatistics-editpages' => 'អ្នកប្រើប្រាស់​បុគ្គល $1 ស្ថិតិ​ទំព័រ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'usagestatisticsintervalday' => 'ದಿನ',
	'usagestatisticsintervalweek' => 'ವಾರ',
	'usagestatisticsintervalmonth' => 'ತಿಂಗಳು',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'specialuserstats' => 'Statistike fum Metmaache',
	'usagestatistics' => 'Statistike fum Metmaache',
	'usagestatistics-desc' => 'Zeich Statistike övver Metmaacher un et janze Wiki.',
	'usagestatisticsfor' => '<h2>Statistike fum Metmaacher [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistike fun alle Metmaacher</h2>',
	'usagestatisticsinterval' => 'De Zick
<small>(fun/beß)</small>:',
	'usagestatisticsnamespace' => 'Appachtemang:',
	'usagestatisticsexcluderedirects' => 'Ußer Ömleidungssigge',
	'usagestatistics-namespace' => 'Shtatißtike övver et Appachtemang [[Special:Allpages/$1|$2]]',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Ömleidungssigge]] sin nit metjezallt.',
	'usagestatisticstype' => 'Aat ze rääschne',
	'usagestatisticsstart' => 'Et Aanfangs-Dattum:',
	'usagestatisticsend' => 'Et Dattum fun Engk:',
	'usagestatisticssubmit' => 'Statistike ußrääschne',
	'usagestatisticsnostart' => '* <span style="color:red">Dattum fum Aanfangs aanjevve</span>',
	'usagestatisticsnoend' => '* <span style="color:red">Dattum fum Engk aanjevve</span>',
	'usagestatisticsbadstartend' => '<b>Et Dattum fum <i>Aanfang</i> udder <i>Engk</i> es Kappes!</b>',
	'usagestatisticsintervalday' => 'Dach',
	'usagestatisticsintervalweek' => 'Woch',
	'usagestatisticsintervalmonth' => 'Mohnd',
	'usagestatisticsincremental' => 'schrettwies',
	'usagestatisticsincremental-text' => 'Schrettwies',
	'usagestatisticscumulative' => 'jesammt',
	'usagestatisticscumulative-text' => 'Jesammt',
	'usagestatisticscalselect' => 'Ußsöke',
	'usagestatistics-editindividual' => '$1 Änderungs-Statistike fun enem Metmaacher',
	'usagestatistics-editpages' => '$1 Sigge-Statistike fun enem Metmaacher',
	'right-viewsystemstats' => 'Dem [[Special:UserStats|Wiki sing Jebruchs_Shtatistike]] aanloore',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'specialuserstats' => 'Benotzungs-Statistiken',
	'usagestatistics' => 'Benotzungs-Statistiken',
	'usagestatistics-desc' => 'Weis Statistike vun den indivudelle Benotzer an der allgemenger Benotzung vun der Wiki',
	'usagestatisticsfor' => '<h2>Benotzungs-Statistik fir [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistike vun der Benotzung fir all Benotzer</h2>',
	'usagestatisticsinterval' => 'Intervall:',
	'usagestatisticsnamespace' => 'Nummraum:',
	'usagestatisticsexcluderedirects' => 'Viruleedungen ausschléissen',
	'usagestatistics-namespace' => 'Et gëtt keng Statistiken vum Nummraum [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Viruleedunge]] ginn net matgezielt.',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsstart' => 'Ufanksdatum:',
	'usagestatisticsend' => 'Schlussdatum:',
	'usagestatisticssubmit' => 'Statistik opstellen',
	'usagestatisticsnostart' => 'Gitt w.e.g een Ufanksdatum un',
	'usagestatisticsnoend' => 'Gitt w.e.g. ee Schlussdatum un',
	'usagestatisticsbadstartend' => '<b>Falsche Format vum <i>Ufanks-</i> oder vum <i>Schluss</i> Datum!</b>',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Woch',
	'usagestatisticsintervalmonth' => 'Mount',
	'usagestatisticsincremental' => 'Inkremental',
	'usagestatisticsincremental-text' => 'Inkremental',
	'usagestatisticscumulative' => 'Cumulativ',
	'usagestatisticscumulative-text' => 'cumulativ',
	'usagestatisticscalselect' => 'Auswielen',
	'usagestatistics-editindividual' => 'Individuell $1 Statistiken vun den Ännerunge pro Benotzer',
	'usagestatistics-editpages' => 'Individuell $1 Statistiken vun de Säite pro Benotzer',
	'right-viewsystemstats' => '[[Special:UserStats|Wiki Benotzerstatistike]] weisen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'specialuserstats' => 'Статистики на користење',
	'usagestatistics' => 'Статистики на користење',
	'usagestatistics-desc' => 'Приказ на статистики на користење поединечно за корисник и за целото вики',
	'usagestatisticsfor' => '<h2>Статистики на користење за [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Статистики на користење за сите корисници</h2>',
	'usagestatisticsinterval' => 'Интервал:',
	'usagestatisticsnamespace' => 'Именски простор:',
	'usagestatisticsexcluderedirects' => 'Без пренасочувања',
	'usagestatistics-namespace' => 'Ова се статистики за именскиот простор [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Пренасочувањата]] не се земаат во предвид.',
	'usagestatisticstype' => 'Тип',
	'usagestatisticsstart' => 'Почетен датум:',
	'usagestatisticsend' => 'Краен датум:',
	'usagestatisticssubmit' => 'Создај статистики',
	'usagestatisticsnostart' => 'Специфицирајте почетен датум',
	'usagestatisticsnoend' => 'Специфицирајте краен датум',
	'usagestatisticsbadstartend' => '<b>Лош <i>почетен</i> и/или <i>краен</i> датум!</b>',
	'usagestatisticsintervalday' => 'Ден',
	'usagestatisticsintervalweek' => 'Седмица',
	'usagestatisticsintervalmonth' => 'Месец',
	'usagestatisticsincremental' => 'Инкрементално',
	'usagestatisticsincremental-text' => 'инкрементално',
	'usagestatisticscumulative' => 'Кумулативно',
	'usagestatisticscumulative-text' => 'кумулативно',
	'usagestatisticscalselect' => 'Избери',
	'usagestatistics-editindividual' => 'Статистики на уредување за корисник $1',
	'usagestatistics-editpages' => 'Статистики на страници за корисник $1',
	'right-viewsystemstats' => 'Погледајте ги [[Special:UserStats|статистиките за употребата на викито]]',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'specialuserstats' => 'ഉപയോഗത്തിന്റെ സ്ഥിതിവിവരക്കണക്ക്',
	'usagestatistics' => 'ഉപയോഗത്തിന്റെ സ്ഥിതിവിവരക്കണക്ക്',
	'usagestatisticsinterval' => 'ഇടവേള',
	'usagestatisticstype' => 'തരം',
	'usagestatisticsstart' => 'തുടങ്ങുന്ന തീയ്യതി',
	'usagestatisticsend' => 'അവസാനിക്കുന്ന തീയ്യതി',
	'usagestatisticssubmit' => 'സ്ഥിതിവിവരക്കണക്ക് ഉത്പാദിപ്പിക്കുക',
	'usagestatisticsnostart' => 'ദയവായി ഒരു തുടക്ക തീയ്യതി ചേര്‍ക്കുക',
	'usagestatisticsnoend' => 'ദയവായി ഒരു ഒടുക്ക തീയ്യതി ചേര്‍ക്കുക',
	'usagestatisticsbadstartend' => '<b>അസാധുവായ <i>തുടക്ക</i> അല്ലെങ്കില്‍ <i>ഒടുക്ക</i> തീയ്യതി!</b>',
	'usagestatisticsintervalday' => 'ദിവസം',
	'usagestatisticsintervalweek' => 'ആഴ്ച',
	'usagestatisticsintervalmonth' => 'മാസം',
	'usagestatisticscalselect' => 'തിരഞ്ഞെടുക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'specialuserstats' => 'वापर सांख्यिकी',
	'usagestatistics' => 'वापर सांख्यिकी',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]] ची वापर सांख्यिकी</h2>',
	'usagestatisticsinterval' => 'मध्यंतर',
	'usagestatisticstype' => 'प्रकार',
	'usagestatisticsstart' => 'सुरुवातीचा दिनांक',
	'usagestatisticsend' => 'शेवटची तारीख',
	'usagestatisticssubmit' => 'सांख्यिकी तयार करा',
	'usagestatisticsnostart' => 'कृपया सुरुवातीची तारीख द्या',
	'usagestatisticsnoend' => 'कृपया शेवटची तारीख द्या',
	'usagestatisticsbadstartend' => '<b>चुकीची <i>सुरु</i> अथवा/किंवा <i>समाप्तीची</i> तारीख!</b>',
	'usagestatisticsintervalday' => 'दिवस',
	'usagestatisticsintervalweek' => 'आठवडा',
	'usagestatisticsintervalmonth' => 'महीना',
	'usagestatisticsincremental' => 'इन्क्रिमेंटल',
	'usagestatisticsincremental-text' => 'इन्क्रिमेंटल',
	'usagestatisticscumulative' => 'एकूण',
	'usagestatisticscumulative-text' => 'एकूण',
	'usagestatisticscalselect' => 'निवडा',
	'usagestatistics-editindividual' => 'एकटा सदस्य $1 संपादन सांख्यिकी',
	'usagestatistics-editpages' => 'एकटा सदस्य $1 पृष्ठ सांख्यिकी',
);

/** Malay (Bahasa Melayu)
 * @author Zamwan
 */
$messages['ms'] = array(
	'usagestatisticsinterval' => 'Selang',
	'usagestatisticstype' => 'Jenis',
	'usagestatisticsstart' => 'Tarikh mula',
	'usagestatisticsend' => 'Tarikh tamat',
	'usagestatisticssubmit' => 'Jana statistik',
	'usagestatisticsnostart' => 'Sila tentukan tarikh mula',
	'usagestatisticsnoend' => 'Sila tentukan tarikh tamat',
	'usagestatisticsintervalday' => 'Hari',
	'usagestatisticsintervalweek' => 'Minggu',
	'usagestatisticsintervalmonth' => 'Bulan',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'usagestatisticsinterval' => 'Йутко',
	'usagestatisticstype' => 'Тип',
	'usagestatisticsstart' => 'Ушодома чи',
	'usagestatisticsend' => 'Прядома чи',
	'usagestatisticsbadstartend' => '<b>Аволь истямо <i>ушодома</i> ды/эли <i>прядома</i> ковчи!</b>',
	'usagestatisticsintervalday' => 'Чи',
	'usagestatisticsintervalweek' => 'Тарго',
	'usagestatisticsintervalmonth' => 'Ковось',
	'usagestatisticscumulative' => 'Весемезэ',
	'usagestatisticscumulative-text' => 'весемезэ',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'usagestatisticsinterval' => 'Tiedruum',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Week',
	'usagestatisticsintervalmonth' => 'Maand',
	'usagestatisticscalselect' => 'Utwählen',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'specialuserstats' => 'Gebruiksstatistieken',
	'usagestatistics' => 'Gebruiksstatistieken',
	'usagestatistics-desc' => 'Individuele en totaalstatistieken van wikigebruik weergeven',
	'usagestatisticsfor' => '<h2>Gebruikersstatistieken voor [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Gebruiksstatistieken voor alle gebruikers</h2>',
	'usagestatisticsinterval' => 'Onderbreking:',
	'usagestatisticsnamespace' => 'Naamruimte:',
	'usagestatisticsexcluderedirects' => 'Doorverwijzingen uitsluiten',
	'usagestatistics-namespace' => 'Dit zijn statistieken over de naamruimte [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'Over [[Special:ListRedirects|doorverwijzingen]] wordt niet gerapporteerd.',
	'usagestatisticstype' => 'Type',
	'usagestatisticsstart' => 'Begindatum:',
	'usagestatisticsend' => 'Einddatum:',
	'usagestatisticssubmit' => 'Statistieken weergeven',
	'usagestatisticsnostart' => 'Geef een begindatum op',
	'usagestatisticsnoend' => 'Geef een einddatum op',
	'usagestatisticsbadstartend' => '<b>Slechte <i>begindatum</i> en/of <i>einddatum</i>!</b>',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Week',
	'usagestatisticsintervalmonth' => 'Maand',
	'usagestatisticsincremental' => 'Incrementeel',
	'usagestatisticsincremental-text' => 'incrementeel',
	'usagestatisticscumulative' => 'Cumulatief',
	'usagestatisticscumulative-text' => 'cumulatief',
	'usagestatisticscalselect' => 'Selecteren',
	'usagestatistics-editindividual' => '$1 bewerkingsstatistieken voor enkele gebruiker',
	'usagestatistics-editpages' => '$1 paginastatistieken voor enkele gebruiker',
	'right-viewsystemstats' => '[[Special:UserStats|Wikigebruiksstatistieken]] bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Frokor
 * @author Gunnernett
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'specialuserstats' => 'Statistikk over bruk',
	'usagestatistics' => 'Statistikk over bruk',
	'usagestatistics-desc' => 'Vis statistikk for individuelle brukarar og for heile wikien',
	'usagestatisticsfor' => '<h2>Statistikk over bruk for [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Bruksstatistikk for alle brukarar</h2>',
	'usagestatisticsinterval' => 'Intervall:',
	'usagestatisticsnamespace' => 'Namnerom:',
	'usagestatisticsexcluderedirects' => 'Ta ikkje med omdirigeringar',
	'usagestatisticstype' => 'Type',
	'usagestatisticsstart' => 'Startdato:',
	'usagestatisticsend' => 'Sluttdato:',
	'usagestatisticssubmit' => 'Lag statistikk',
	'usagestatisticsnostart' => 'Ver venleg og oppgje startdato',
	'usagestatisticsnoend' => 'Ver venleg og oppgje sluttdato',
	'usagestatisticsbadstartend' => '<b>Ugyldig <i>start</i>– og/eller <i>slutt</i>dato!</b>',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Veke',
	'usagestatisticsintervalmonth' => 'Månad',
	'usagestatisticsincremental' => 'Veksande',
	'usagestatisticsincremental-text' => 'veksande',
	'usagestatisticscumulative' => 'Kumulativ',
	'usagestatisticscumulative-text' => 'kumulativ',
	'usagestatisticscalselect' => 'Velg',
	'usagestatistics-editindividual' => 'Redigeringsstatistikk for $1',
	'usagestatistics-editpages' => 'Sidestatistikk for $1',
	'right-viewsystemstats' => 'Vis [[Special:UserStats|wikibrukarstatistikk]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'specialuserstats' => 'Bruksstatistikk',
	'usagestatistics' => 'Bruksstatistikk',
	'usagestatistics-desc' => 'Vis statistikk for individuelle brukere og for hele wikien',
	'usagestatisticsfor' => '<h2>Bruksstatistikk for [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Bruksstatistikk for alle brukere</h2>',
	'usagestatisticsinterval' => 'Intervall:',
	'usagestatisticsnamespace' => 'Navnerom:',
	'usagestatisticsexcluderedirects' => 'Ikke ta med omdirigeringer',
	'usagestatistics-namespace' => 'Dette er statistikk for navnerommet [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Omdirigeringer]] har ikke blitt medregnet.',
	'usagestatisticstype' => 'Type',
	'usagestatisticsstart' => 'Startdato:',
	'usagestatisticsend' => 'Sluttdato:',
	'usagestatisticssubmit' => 'Generer statistikk',
	'usagestatisticsnostart' => 'Vennligst angi en starttid',
	'usagestatisticsnoend' => 'Vennligst angi en sluttid',
	'usagestatisticsbadstartend' => '<b>Ugyldig <i>start-</i> og/eller <i>slutttid</i>!</b>',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Uke',
	'usagestatisticsintervalmonth' => 'Måned',
	'usagestatisticsincremental' => 'Økende',
	'usagestatisticsincremental-text' => 'økende',
	'usagestatisticscumulative' => 'Kumulativ',
	'usagestatisticscumulative-text' => 'kumulativ',
	'usagestatisticscalselect' => 'Velg',
	'usagestatistics-editindividual' => 'Redigeringsstatistikk for $1',
	'usagestatistics-editpages' => 'Sidestatistikk for $1',
	'right-viewsystemstats' => 'Vis [[Special:UserStats|wikibrukerstatistikk]]',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'specialuserstats' => "Estatisticas d'utilizacion",
	'usagestatistics' => 'Estatisticas Utilizacion',
	'usagestatistics-desc' => 'Aficha las estatisticas individualas dels utilizaires e mai l’utilizacion sus l’ensemble del wiki.',
	'usagestatisticsfor' => '<h2>Estatisticas Utilizacion per [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => "<h2>Estatisticas d'utilizacion per totes los utilizaires</h2>",
	'usagestatisticsinterval' => 'Interval :',
	'usagestatisticsnamespace' => 'Espaci de nom :',
	'usagestatisticsexcluderedirects' => 'Exclure las redireccions',
	'usagestatistics-namespace' => "Aquestas estatisticas son sus l'espaci de noms [[Special:Allpages/$1|$2]].",
	'usagestatistics-noredirects' => 'Las [[Special:ListRedirects|redireccions]] son pas presas en compte.',
	'usagestatisticstype' => 'Tipe :',
	'usagestatisticsstart' => 'Data de començament :',
	'usagestatisticsend' => 'Data de fin :',
	'usagestatisticssubmit' => 'Generir las estatisticas',
	'usagestatisticsnostart' => 'Picar una data de començament',
	'usagestatisticsnoend' => 'Picar una data de fin',
	'usagestatisticsbadstartend' => '<b>Format de data de <i>començament</i> o de <i>fin</i> marrit !</b>',
	'usagestatisticsintervalday' => 'Jorn',
	'usagestatisticsintervalweek' => 'Setmana',
	'usagestatisticsintervalmonth' => 'Mes',
	'usagestatisticsincremental' => 'Incremental',
	'usagestatisticsincremental-text' => 'incrementalas',
	'usagestatisticscumulative' => 'Cumulatiu',
	'usagestatisticscumulative-text' => 'cumulativas',
	'usagestatisticscalselect' => 'Seleccionar',
	'usagestatistics-editindividual' => 'Edicions estatisticas $1 per utilizaire',
	'usagestatistics-editpages' => 'Estatisticas $1 de las paginas per utilizaire individual',
	'right-viewsystemstats' => "Vejatz las [[Special:UserStats|estatisticas d'utilizacion del wiki]]",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'usagestatisticstype' => 'Тип',
	'usagestatisticsstart' => 'Кæдæй',
	'usagestatisticsend' => 'Кæдмæ',
	'usagestatisticsintervalday' => 'Бон',
	'usagestatisticsintervalweek' => 'Къуыри',
	'usagestatisticsintervalmonth' => 'Мæй',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'usagestatisticsintervalday' => 'Daag',
	'usagestatisticsintervalweek' => 'Woch',
	'usagestatisticsintervalmonth' => 'Munet',
);

/** Polish (Polski)
 * @author Equadus
 * @author Leinad
 * @author McMonster
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'specialuserstats' => 'Statystyki',
	'usagestatistics' => 'Statystyki',
	'usagestatistics-desc' => 'Pokazuje statystyki indywidualne użytkownika oraz statystyki wiki',
	'usagestatisticsfor' => '<h2>Statystyki użytkownika [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statystyki wykorzystania dla wszystkich użytkowników</h2>',
	'usagestatisticsinterval' => 'Okres',
	'usagestatisticsnamespace' => 'Przestrzeń nazw',
	'usagestatisticsexcluderedirects' => 'Wyklucz przekierowania',
	'usagestatistics-namespace' => 'Dane statystyczne dotyczą przestrzeni nazw „[[Special:Allpages/$1|$2]]”.',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Przekierowania]] nie są brane pod uwagę.',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsstart' => 'Data początkowa',
	'usagestatisticsend' => 'Data końcowa',
	'usagestatisticssubmit' => 'Generuj statystyki',
	'usagestatisticsnostart' => 'Podaj datę początkową',
	'usagestatisticsnoend' => 'Podaj datę końcową',
	'usagestatisticsbadstartend' => '<b>Nieprawidłowa data <i>początkowa</i> i/lub <i>końcowa</i>!</b>',
	'usagestatisticsintervalday' => 'Dzień',
	'usagestatisticsintervalweek' => 'Tydzień',
	'usagestatisticsintervalmonth' => 'Miesiąc',
	'usagestatisticsincremental' => 'Przyrostowe',
	'usagestatisticsincremental-text' => 'przyrostowe',
	'usagestatisticscumulative' => 'Skumulowane',
	'usagestatisticscumulative-text' => 'skumulowane',
	'usagestatisticscalselect' => 'Wybierz',
	'usagestatistics-editindividual' => '$1 statystyki edycji pojedynczego użytkownika',
	'usagestatistics-editpages' => '$1 statystyki stron pojedynczego użytkownika',
	'right-viewsystemstats' => 'Podgląd [[Special:UserStats|statystyk wykorzystania wiki]]',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'specialuserstats' => "Statìstiche d'utilisassion",
	'usagestatistics' => "Statìstiche d'utilisassion",
	'usagestatistics-desc' => "Mostra le statìstiche d'utilisassion dj'utent andividuaj e dl'ansem dla wiki",
	'usagestatisticsfor' => "<h2>Statìstiche d'utilisassion për [[User:$1|$1]]</h2>",
	'usagestatisticsforallusers' => "<h2>Statìstiche d'utilisassion për tuti j'utent</h2>",
	'usagestatisticsinterval' => 'Antërval:',
	'usagestatisticsnamespace' => 'Spassi nominal:',
	'usagestatisticsexcluderedirects' => 'Lassé fòra le ridiression',
	'usagestatistics-namespace' => 'Coste a son dë statìstiche an slë spassi nominal [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'Le [[Special:ListRedirects|ridiression]] a son nen pijà an cont.',
	'usagestatisticstype' => 'Tipo:',
	'usagestatisticsstart' => 'Dàita ëd prinsipi:',
	'usagestatisticsend' => 'Dàita ëd fin:',
	'usagestatisticssubmit' => 'Generé le statìstiche',
	'usagestatisticsnostart' => 'Për piasì specìfica na data ëd partensa',
	'usagestatisticsnoend' => 'Për piasì specìfica na data ëd fin',
	'usagestatisticsbadstartend' => '<b>Data <i>inissial</i> e/o <i>final</i> pa bon-a!</b>',
	'usagestatisticsintervalday' => 'Di',
	'usagestatisticsintervalweek' => 'Sman-a',
	'usagestatisticsintervalmonth' => 'Mèis',
	'usagestatisticsincremental' => 'Ancremental',
	'usagestatisticsincremental-text' => 'ancremental',
	'usagestatisticscumulative' => 'Cumulativ',
	'usagestatisticscumulative-text' => 'cumulativ',
	'usagestatisticscalselect' => 'Selession-a',
	'usagestatistics-editindividual' => "Statìstiche $1 dle modìfiche dj'utent andividuaj",
	'usagestatistics-editpages' => "Statìstiche $1 dle pàgine dj'utent andividuaj",
	'right-viewsystemstats' => "Varda [[Special:UserStats|statìstiche d'usagi dla wiki]]",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'specialuserstats' => 'د کارونې شمار',
	'usagestatistics' => 'د کارونې شمار',
	'usagestatisticstype' => 'ډول',
	'usagestatisticsstart' => 'د پيل نېټه:',
	'usagestatisticsend' => 'د پای نېټه:',
	'usagestatisticsbadstartend' => '<b>بد <i>پيل</i> او/يا <i>پای </i> نېټه!</b>',
	'usagestatisticsintervalday' => 'ورځ',
	'usagestatisticsintervalweek' => 'اوونۍ',
	'usagestatisticsintervalmonth' => 'مياشت',
	'usagestatisticscalselect' => 'ټاکل',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'specialuserstats' => 'Estatísticas de uso',
	'usagestatistics' => 'Estatísticas de uso',
	'usagestatistics-desc' => 'Mostrar estatísticas de utilizadores individuais e de uso geral da wiki',
	'usagestatisticsfor' => '<h2>Estatísticas de utilização para [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Estatísticas de utilização para todos os utilizadores</h2>',
	'usagestatisticsinterval' => 'Intervalo:',
	'usagestatisticsnamespace' => 'Domínio:',
	'usagestatisticsexcluderedirects' => 'Excluir redireccionamentos',
	'usagestatistics-namespace' => 'Estas são as estatísticas do espaço nominal [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Redireccionamentos]] não são tomados em conta.',
	'usagestatisticstype' => 'Tipo',
	'usagestatisticsstart' => 'Data de início:',
	'usagestatisticsend' => 'Data de fim:',
	'usagestatisticssubmit' => 'Gerar Estatísticas',
	'usagestatisticsnostart' => 'Por favor indique uma data de início',
	'usagestatisticsnoend' => 'Por favor indique uma data de término',
	'usagestatisticsbadstartend' => '<b>Datas de <i>início</i> e/ou <i>término</i> inválidas!</b>',
	'usagestatisticsintervalday' => 'Dia',
	'usagestatisticsintervalweek' => 'Semana',
	'usagestatisticsintervalmonth' => 'Mês',
	'usagestatisticsincremental' => 'Incremental',
	'usagestatisticsincremental-text' => 'incrementais',
	'usagestatisticscumulative' => 'Cumulativo',
	'usagestatisticscumulative-text' => 'cumulativas',
	'usagestatisticscalselect' => 'Escolher',
	'usagestatistics-editindividual' => 'Estatísticas $1 de edição de utilizador individual',
	'usagestatistics-editpages' => 'Estatísticas $1 de páginas de utilizador individual',
	'right-viewsystemstats' => 'Ver [[Special:UserStats|estatísticas de utilização da wiki]]',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'specialuserstats' => 'Estatísticas de uso',
	'usagestatistics' => 'Estatísticas de uso',
	'usagestatistics-desc' => 'Mostrar estatísticas de utilizadores individuais e de uso geral da wiki',
	'usagestatisticsfor' => '<h2>Estatísticas de utilização para [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Estatísticas de utilização para todos os utilizadores</h2>',
	'usagestatisticsinterval' => 'Intervalo:',
	'usagestatisticsnamespace' => 'Domínio:',
	'usagestatisticsexcluderedirects' => 'Excluir redirecionamentos',
	'usagestatisticstype' => 'Tipo',
	'usagestatisticsstart' => 'Data de início:',
	'usagestatisticsend' => 'Data de fim:',
	'usagestatisticssubmit' => 'Gerar Estatísticas',
	'usagestatisticsnostart' => 'Por favor indique uma data de início',
	'usagestatisticsnoend' => 'Por favor indique uma data de término',
	'usagestatisticsbadstartend' => '<b>Datas de <i>início</i> e/ou <i>término</i> inválidas!</b>',
	'usagestatisticsintervalday' => 'Dia',
	'usagestatisticsintervalweek' => 'Semana',
	'usagestatisticsintervalmonth' => 'Mês',
	'usagestatisticsincremental' => 'Incremental',
	'usagestatisticsincremental-text' => 'incrementais',
	'usagestatisticscumulative' => 'Cumulativo',
	'usagestatisticscumulative-text' => 'cumulativas',
	'usagestatisticscalselect' => 'Escolher',
	'usagestatistics-editindividual' => 'Estatísticas $1 de edição de utilizador individual',
	'usagestatistics-editpages' => 'Estatísticas $1 de páginas de utilizador individual',
	'right-viewsystemstats' => 'Ver [[Special:UserStats|estatísticas de utilização do wiki]]',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'specialuserstats' => 'Statistici de utilizare',
	'usagestatistics' => 'Statistici de utilizare',
	'usagestatisticsinterval' => 'Interval',
	'usagestatisticsnamespace' => 'Spaţiu de nume:',
	'usagestatisticstype' => 'Tip',
	'usagestatisticsstart' => 'Dată început',
	'usagestatisticsend' => 'Dată sfârşit',
	'usagestatisticssubmit' => 'Generează statistici',
	'usagestatisticsintervalday' => 'Zi',
	'usagestatisticsintervalweek' => 'Săptămână',
	'usagestatisticsintervalmonth' => 'Lună',
	'usagestatisticsincremental' => 'Incremental',
	'usagestatisticsincremental-text' => 'incremental',
	'usagestatisticscumulative' => 'Cumulativ',
	'usagestatisticscumulative-text' => 'cumulativ',
	'usagestatisticscalselect' => 'Selectaţi',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'specialuserstats' => "Statisteche d'use",
	'usagestatistics' => "Statisteche d'use",
	'usagestatistics-desc' => "Face vedè le statisteche d'use de le utinde individuale e de tutte l'utinde de Uicchi",
	'usagestatisticsfor' => "<h2>Statisteche d'use pe [[User:$1|$1]]</h2>",
	'usagestatisticsforallusers' => "<h2>Statisteche d'use pe tutte l'utinde</h2>",
	'usagestatisticsinterval' => 'Indervalle:',
	'usagestatisticsnamespace' => 'Namespace:',
	'usagestatisticsexcluderedirects' => 'Esclude le redirezionaminde',
	'usagestatistics-namespace' => 'Chiste so le statisteche sus a [[Special:Allpages/$1|$2]] namespace.',
	'usagestatistics-noredirects' => "[[Special:ListRedirects|Redirezionaminde]] non ge sò purtate jndr'à 'u cunde utende.",
	'usagestatisticstype' => 'Tipe',
	'usagestatisticsstart' => 'Date de inizie:',
	'usagestatisticsend' => 'Date de fine:',
	'usagestatisticssubmit' => 'Ccreje le statisteche',
	'usagestatisticsnostart' => "Pe piacere mitte 'na date de inizie",
	'usagestatisticsnoend' => "Pe piacere mitte 'na date de fine",
	'usagestatisticsbadstartend' => "<b>Date de <i>inizie</i> e/o <i>fine</i> cu l'errore!</b>",
	'usagestatisticsintervalday' => 'Sciúrne',
	'usagestatisticsintervalweek' => 'Sumáne',
	'usagestatisticsintervalmonth' => 'Mese',
	'usagestatisticsincremental' => 'Ingremendele',
	'usagestatisticsincremental-text' => 'ingremendele',
	'usagestatisticscumulative' => 'Cumulative',
	'usagestatisticscumulative-text' => 'cumulative',
	'usagestatisticscalselect' => 'Selezzione',
	'usagestatistics-editindividual' => "Statisteche sus a le cangiaminde de l'utende $1",
	'usagestatistics-editpages' => "Statisteche sus a le pàggene de l'utende $1",
	'right-viewsystemstats' => 'Vide le [[Special:UserStats|statisteche de utilizze de Uicchi]]',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'specialuserstats' => 'Статистика использования',
	'usagestatistics' => 'Статистика использования',
	'usagestatistics-desc' => 'Показывает индивидуальную для участника и общую для вики статистику использования',
	'usagestatisticsfor' => '<h2>Статистика использования для участника [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Статистика использования для всех участников</h2>',
	'usagestatisticsinterval' => 'Интервал:',
	'usagestatisticsnamespace' => 'Пространство имён:',
	'usagestatisticsexcluderedirects' => 'Исключить перенаправления',
	'usagestatistics-namespace' => 'Эти статистические данные относятся к пространству имён [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Перенаправления]] не принимаются во внимание.',
	'usagestatisticstype' => 'Тип',
	'usagestatisticsstart' => 'Начальная дата:',
	'usagestatisticsend' => 'Конечная дата:',
	'usagestatisticssubmit' => 'Сформировать статистику',
	'usagestatisticsnostart' => 'Пожалуйста, укажите начальную дату',
	'usagestatisticsnoend' => 'Пожалуйста, укажите конечную дату',
	'usagestatisticsbadstartend' => '<b>Неправильная <i>начальная</i> и/или <i>конечная</i> дата!</b>',
	'usagestatisticsintervalday' => 'День',
	'usagestatisticsintervalweek' => 'Неделя',
	'usagestatisticsintervalmonth' => 'Месяц',
	'usagestatisticsincremental' => 'Возрастающая',
	'usagestatisticsincremental-text' => 'возростающая',
	'usagestatisticscumulative' => 'Совокупная',
	'usagestatisticscumulative-text' => 'совокупная',
	'usagestatisticscalselect' => 'Выбрать',
	'usagestatistics-editindividual' => 'Статистика $1 для индивидуальных правок',
	'usagestatistics-editpages' => 'Статистика $1 для страниц участника',
	'right-viewsystemstats' => 'просмотр [[Special:UserStats|статистики использования вики]]',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'specialuserstats' => 'භාවිතයේ සංඛ්‍යා දත්ත',
	'usagestatistics' => 'භාවිතයේ සංඛ්‍යා දත්ත',
	'usagestatistics-desc' => 'තනි වශයෙන් පරිශීලකයිනිගේ හා සමස්ථයක් වශයෙන් විකි භාවිතාවේ සංඛ්‍යා දත්ත පෙන්වන්න',
	'usagestatisticsfor' => '<h2> [[User:$1|$1]] සඳහා භාවිතා සංඛ්‍යා දත්ත</h2>',
	'usagestatisticsforallusers' => '<h2>සියලුම පරිශීලකයින් සඳහා භාවිතා සංඛ්‍යා දත්ත</h2>',
	'usagestatisticsinterval' => 'විවේකය:',
	'usagestatisticsnamespace' => 'නාමඅවකාශය:',
	'usagestatisticsexcluderedirects' => 'ආපසු හැරවීම් බැහැර කරන්න',
	'usagestatistics-namespace' => 'මේ [[Special:Allpages/$1|$2]] නාමඅවකාශය මත සංඛ්‍යා දත්තය.',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Redirects]] ගිණුමට ගෙන නැත.',
	'usagestatisticstype' => 'වර්ගය:',
	'usagestatisticsstart' => 'ආරම්භක දිනය:',
	'usagestatisticsend' => 'අවසන් දිනය:',
	'usagestatisticssubmit' => 'සංඛ්‍යා දත්ත ජනනය',
	'usagestatisticsnostart' => 'කරුණාකර ආරම්භක දිනයක් සඳහන් කරන්න',
	'usagestatisticsnoend' => 'කරුණාකර අවසන් දිනයක් සඳහන් කරන්න',
	'usagestatisticsbadstartend' => '<b>අයහපත් <i>ආරම්භය</i> සහ/හෝ <i>අවසානය</i>දිනය!</b>',
	'usagestatisticsintervalday' => 'දිනය',
	'usagestatisticsintervalweek' => 'සතිය',
	'usagestatisticsintervalmonth' => 'මාසය',
	'usagestatisticsincremental' => 'වෘද්ධී',
	'usagestatisticsincremental-text' => 'වෘද්ධි',
	'usagestatisticscumulative' => 'සමුච්ඡිත',
	'usagestatisticscumulative-text' => 'සමුච්ඡිත',
	'usagestatisticscalselect' => 'තෝරන්න',
	'usagestatistics-editindividual' => '$1 තනි පරිශීලකයා සංඛ්‍යා දත්ත සංස්කරණය කරයි',
	'usagestatistics-editpages' => '$1 තනි පරිශීලකයා සංඛ්‍යා දත්ත පිටු ලකුණු කරයි',
	'right-viewsystemstats' => '[[Special:UserStats|විකි භාවිතා සංඛ්‍යා දත්ත]] බලන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'specialuserstats' => 'Štatistika používanosti',
	'usagestatistics' => 'Štatistika používanosti',
	'usagestatistics-desc' => 'Zobrazenie štatistík jednotlivého používateľa a celej wiki',
	'usagestatisticsfor' => '<h2>Štatistika používanosti pre používateľa [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Štatistika využitia pre všetkých používateľov</h2>',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticsnamespace' => 'Menný priestor:',
	'usagestatisticsexcluderedirects' => 'Vynechať presmerovania',
	'usagestatistics-namespace' => 'Toto je štatistika menného priestoru [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Presmerovania]] sa neberú do úvahy.',
	'usagestatisticstype' => 'Typ',
	'usagestatisticsstart' => 'Dátum začiatku:',
	'usagestatisticsend' => 'Dátum konca:',
	'usagestatisticssubmit' => 'Vytvoriť štatistiku',
	'usagestatisticsnostart' => 'Prosím, uveďte dátum začiatku',
	'usagestatisticsnoend' => 'Prosím, uveďte dátum konca',
	'usagestatisticsbadstartend' => '<b>Chybný dátum <i>začiatku</i> a/alebo <i>konca</i>!</b>',
	'usagestatisticsintervalday' => 'Deň',
	'usagestatisticsintervalweek' => 'Týždeň',
	'usagestatisticsintervalmonth' => 'Mesiac',
	'usagestatisticsincremental' => 'Inkrementálna',
	'usagestatisticsincremental-text' => 'inkrementálna',
	'usagestatisticscumulative' => 'Kumulatívna',
	'usagestatisticscumulative-text' => 'kumulatívna',
	'usagestatisticscalselect' => 'Vybrať',
	'usagestatistics-editindividual' => 'Štatistika úprav jednotlivého používateľa $1',
	'usagestatistics-editpages' => 'Štatistika stránok jednotlivého používateľa $1',
	'right-viewsystemstats' => 'Zobraziť [[Special:UserStats|štatistiku použitia wiki]]',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'specialuserstats' => 'Статистике коришћења',
	'usagestatistics' => 'Статистике коришћења',
	'usagestatistics-desc' => 'Покажи појединачне кориснике и укупну статистику коришћења Викија',
	'usagestatisticsfor' => '<h2>Статистике коришћења за [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Статистике коришћења за све кориснике</h2>',
	'usagestatisticsinterval' => 'Интервал:',
	'usagestatisticstype' => 'Тип',
	'usagestatisticsstart' => 'Почетни датум:',
	'usagestatisticsend' => 'Завршни датум:',
	'usagestatisticssubmit' => 'Генериши статистике',
	'usagestatisticsnostart' => 'Молимо Вас да задате почетни датум',
	'usagestatisticsnoend' => 'Молимо Вас да задате завршни датум',
	'usagestatisticsbadstartend' => '<b>Лош <i>почетни</i> и/или <i>завршни</i> датум!</b>',
	'usagestatisticsintervalday' => 'Дан',
	'usagestatisticsintervalweek' => 'Недеља',
	'usagestatisticsintervalmonth' => 'Месец',
	'usagestatisticsincremental' => 'Инкрементално',
	'usagestatisticsincremental-text' => 'инкрементално',
	'usagestatisticscumulative' => 'Кумулативно',
	'usagestatisticscumulative-text' => 'кумулативно',
	'usagestatisticscalselect' => 'Изабери',
	'usagestatistics-editindividual' => 'Статистике измена појединачног корисника $1',
	'usagestatistics-editpages' => 'Статистике страна индивидуалних корисника $1',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'specialuserstats' => 'Statistike korišćenja',
	'usagestatistics' => 'Statistike korišćenja',
	'usagestatistics-desc' => 'Pokaži pojedinačne korisnike i ukupnu statistiku korišćenja Vikija',
	'usagestatisticsfor' => '<h2>Statistike korišćenja za [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Statistike korišćenja za sve korisnike</h2>',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticstype' => 'Tip',
	'usagestatisticsstart' => 'Početni datum:',
	'usagestatisticsend' => 'Završni datum:',
	'usagestatisticssubmit' => 'Generiši statistike',
	'usagestatisticsnostart' => 'Molimo Vas da zadate početni datum',
	'usagestatisticsnoend' => 'Molimo Vas da zadate završni datum',
	'usagestatisticsbadstartend' => '<b>Loš <i>početni</i> i/ili <i>završni</i> datum!</b>',
	'usagestatisticsintervalday' => 'Dan',
	'usagestatisticsintervalweek' => 'Nedelja',
	'usagestatisticsintervalmonth' => 'Mesec',
	'usagestatisticsincremental' => 'Inkrementalno',
	'usagestatisticsincremental-text' => 'inkrementalno',
	'usagestatisticscumulative' => 'Kumulativno',
	'usagestatisticscumulative-text' => 'kumulativno',
	'usagestatisticscalselect' => 'Izaberi',
	'usagestatistics-editindividual' => 'Statistike izmena pojedinačnog korisnika $1',
	'usagestatistics-editpages' => 'Statistike strana individualnih korisnika $1',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'specialuserstats' => 'Nutsengs-Statistik',
	'usagestatistics' => 'Nutsengs-Statistik',
	'usagestatistics-desc' => 'Wiest individuelle Benutser- un algemeene Wiki-Nutsengsstatistiken an',
	'usagestatisticsfor' => '<h2>Nutsengs-Statistik foar [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Nutsengs-Statistik foar aal Benutsere</h2>',
	'usagestatisticsinterval' => 'Tiedruum',
	'usagestatisticstype' => 'Bereekenengsoard',
	'usagestatisticsstart' => 'Start-Doatum',
	'usagestatisticsend' => 'Eend-Doatum',
	'usagestatisticssubmit' => 'Statistik generierje',
	'usagestatisticsnostart' => 'Start-Doatum ienreeke',
	'usagestatisticsnoend' => 'Eend-Doatum ienreeke',
	'usagestatisticsbadstartend' => '<b>Uunpaasend/failerhaft <i>Start-Doatum</i> of <i>Eend-Doatum</i> !</b>',
	'usagestatisticsintervalday' => 'Dai',
	'usagestatisticsintervalweek' => 'Wiek',
	'usagestatisticsintervalmonth' => 'Mound',
	'usagestatisticsincremental' => 'Inkrementell',
	'usagestatisticsincremental-text' => 'apstiegend',
	'usagestatisticscumulative' => 'Kumulativ',
	'usagestatisticscumulative-text' => 'hööped',
	'usagestatisticscalselect' => 'Wääl',
	'usagestatistics-editindividual' => 'Individuelle Beoarbaidengsstatistike foar Benutser $1',
	'usagestatistics-editpages' => 'Individuelle Siedenstatistike foar Benutser $1',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author Poxnar
 * @author Sannab
 */
$messages['sv'] = array(
	'specialuserstats' => 'Användarstatistik',
	'usagestatistics' => 'Användarstatistik',
	'usagestatistics-desc' => 'Visar användningsstatistik för enskilda användare och för wikin som helhet',
	'usagestatisticsfor' => '<h2>Användarstatistik för [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Användarstatistik för alla användare</h2>',
	'usagestatisticsinterval' => 'Intervall:',
	'usagestatisticsnamespace' => 'Namnrymd:',
	'usagestatisticsexcluderedirects' => 'Exkludera omdirigeringar',
	'usagestatistics-namespace' => 'Detta är statistik för namnrymden [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'Det har inte tagits hänsyn till [[Special:ListRedirects|omdirigeringar]].',
	'usagestatisticstype' => 'Typ:',
	'usagestatisticsstart' => 'Startdatum:',
	'usagestatisticsend' => 'Slutdatum:',
	'usagestatisticssubmit' => 'Visa statistik',
	'usagestatisticsnostart' => 'Ange ett startdatum',
	'usagestatisticsnoend' => 'Ange ett slutdatum',
	'usagestatisticsbadstartend' => '<b>Felaktigt <i>start-</i> eller <i>slutdatum!</i></b>',
	'usagestatisticsintervalday' => 'Dag',
	'usagestatisticsintervalweek' => 'Vecka',
	'usagestatisticsintervalmonth' => 'Månad',
	'usagestatisticsincremental' => 'Intervallvis',
	'usagestatisticsincremental-text' => 'Intervallvis',
	'usagestatisticscumulative' => 'Kumulativ',
	'usagestatisticscumulative-text' => 'kumulativ',
	'usagestatisticscalselect' => 'Välj',
	'usagestatistics-editindividual' => '$1 statistik över antal redigeringar för enskilda användare',
	'usagestatistics-editpages' => '$1 statistik över antal redigerade sidor för enskilda användare',
	'right-viewsystemstats' => 'Visa [[Special:UserStats|wikianvändningsstatistik]]',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'specialuserstats' => 'వాడుక గణాంకాలు',
	'usagestatistics' => 'వాడుక గణాంకాలు',
	'usagestatistics-desc' => 'వ్యక్తిగత వాడుకరి మరియు మొత్తం వికీ వాడుక గణాంకాలను చూపిస్తుంది',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]] కు వాడుక గణాంకాలు</h2>',
	'usagestatisticsforallusers' => '<h2>అందరు వాడుకరుల వాడుక గణాంకాలు</h2>',
	'usagestatisticsinterval' => 'సమయాంతరం:',
	'usagestatisticsnamespace' => 'పేరుబరి:',
	'usagestatisticsexcluderedirects' => 'దారిమార్పులను మినహాయించు',
	'usagestatistics-namespace' => 'ఇవి [[Special:Allpages/$1|$2]] పేరుబరిలోని గణాంకాలు.',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|దారిమార్పల]]ని పరిగణన లోనికి తీసుకోలేదు.',
	'usagestatisticstype' => 'రకం',
	'usagestatisticsstart' => 'ప్రారంభ తేదీ:',
	'usagestatisticsend' => 'ముగింపు తేదీ:',
	'usagestatisticssubmit' => 'గణాంకాలను సృష్టించు',
	'usagestatisticsnostart' => 'ప్రారంభ తేదీ ఇవ్వండి',
	'usagestatisticsnoend' => 'ముగింపు తేదీ ఇవ్వండి',
	'usagestatisticsbadstartend' => '<b><i>ప్రారంభ</i> మరియు/లేదా <i>ముగింపు</i> తేదీ సరైనది కాదు!</b>',
	'usagestatisticsintervalday' => 'రోజు',
	'usagestatisticsintervalweek' => 'వారం',
	'usagestatisticsintervalmonth' => 'నెల',
	'usagestatisticscumulative' => 'సంచిత',
	'usagestatisticscumulative-text' => 'సంచిత',
	'usagestatisticscalselect' => 'ఎంచుకోండి',
	'usagestatistics-editindividual' => 'వ్యక్తిగత వాడుకరి $1 మార్పుల గణాంకాలు',
	'usagestatistics-editpages' => 'వ్యక్తిగత వాడుకరి $1 పేజీల గణాంకాలు',
	'right-viewsystemstats' => '[[Special:UserStats|వికీ వాడుక గణాంకాల]]ని చూడగలగటం',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'specialuserstats' => 'Омори истифода',
	'usagestatistics' => 'Омори истифода',
	'usagestatisticsinterval' => 'Фосила',
	'usagestatisticstype' => 'Навъ',
	'usagestatisticsstart' => 'Таърихи оғоз',
	'usagestatisticsend' => 'Таърихи хотима',
	'usagestatisticssubmit' => 'Ҳосил кардани омор',
	'usagestatisticsnostart' => 'Лутфан таърихи оғозро мушаххас кунед',
	'usagestatisticsnoend' => 'Лутфан таърихи хотимаро мушаххас кунед',
	'usagestatisticsbadstartend' => '<b>Таърихи <i>оғози</i> ва/ё <i>хотимаи</i> номусоид!</b>',
	'usagestatisticsintervalday' => 'Рӯз',
	'usagestatisticsintervalweek' => 'Ҳафта',
	'usagestatisticsintervalmonth' => 'Моҳ',
	'usagestatisticsincremental' => 'Афзоишӣ',
	'usagestatisticsincremental-text' => 'афзоишӣ',
	'usagestatisticscumulative' => 'Анбошта',
	'usagestatisticscumulative-text' => 'анбошта',
	'usagestatisticscalselect' => 'Интихоб кардан',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'specialuserstats' => 'Omori istifoda',
	'usagestatistics' => 'Omori istifoda',
	'usagestatisticstype' => "Nav'",
	'usagestatisticssubmit' => 'Hosil kardani omor',
	'usagestatisticsnostart' => "Lutfan ta'rixi oƣozro muşaxxas kuned",
	'usagestatisticsnoend' => "Lutfan ta'rixi xotimaro muşaxxas kuned",
	'usagestatisticsbadstartend' => "<b>Ta'rixi <i>oƣozi</i> va/jo <i>xotimai</i> nomusoid!</b>",
	'usagestatisticsintervalday' => 'Rūz',
	'usagestatisticsintervalweek' => 'Hafta',
	'usagestatisticsintervalmonth' => 'Moh',
	'usagestatisticsincremental' => 'Afzoişī',
	'usagestatisticsincremental-text' => 'afzoişī',
	'usagestatisticscumulative' => 'Anboşta',
	'usagestatisticscumulative-text' => 'anboşta',
	'usagestatisticscalselect' => 'Intixob kardan',
);

/** Thai (ไทย)
 * @author Ans
 * @author Horus
 * @author Manop
 * @author Octahedron80
 */
$messages['th'] = array(
	'specialuserstats' => 'สถิติการใช้งาน',
	'usagestatistics' => 'สถิติการใช้งาน',
	'usagestatistics-desc' => 'แสดงชื่อผู้ใช้เฉพาะบุคคลและสถิติการใช้งานวิกิโดยรวม',
	'usagestatisticsfor' => '<h2>สถิติการใช้งานสำหรับ[[ผู้ใช้:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>สถิติการใช้งานสำหรับผู้ใช้ทุกคน</h2>',
	'usagestatisticsnamespace' => 'เนมสเปซ:',
	'usagestatisticsexcluderedirects' => 'ไม่รวมการเปลี่ยนทาง',
	'usagestatisticsstart' => 'วันที่เริ่มต้น:',
	'usagestatisticsend' => 'วันที่สิ้นสุด:',
	'usagestatisticsintervalday' => 'วัน',
	'usagestatisticsintervalweek' => 'อาทิตย์',
	'usagestatisticsintervalmonth' => 'เดือน',
	'usagestatisticscalselect' => 'เลือก',
	'usagestatistics-editindividual' => 'สถิติการแก้ไขเฉพาะผู้ใช้ $1',
	'right-viewsystemstats' => 'ดู [[Special:UserStats|สถิติการใช้วิกิ]]',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'usagestatisticsintervalday' => 'Gün',
	'usagestatisticsintervalweek' => 'Hepde',
	'usagestatisticsintervalmonth' => 'Aý',
	'usagestatisticsincremental' => 'inkremental',
	'usagestatisticsincremental-text' => 'inkremental',
	'usagestatisticscumulative' => 'Kumulýatiw',
	'usagestatisticscumulative-text' => 'kumulýatiw',
	'usagestatisticscalselect' => 'Saýla',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'specialuserstats' => 'Mga estadistika ng paggamit',
	'usagestatistics' => 'Mga estadistika ng paggamit',
	'usagestatistics-desc' => 'Ipakita ang isang (indibiduwal na) tagagamit at pangkalahatang mga estadistika ng paggamit ng wiki',
	'usagestatisticsfor' => '<h2>Mga estadistika ng paggamit para kay [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Mga estadistika ng paggamit para sa lahat ng mga tagagamit</h2>',
	'usagestatisticsinterval' => 'Agwat sa pagitan',
	'usagestatisticstype' => 'Uri (tipo)',
	'usagestatisticsstart' => 'Petsa ng simula',
	'usagestatisticsend' => 'Petsa ng pagwawakas',
	'usagestatisticssubmit' => 'Lumikha ng mga palaulatan (estadistika)',
	'usagestatisticsnostart' => 'Pakitukoy ang isang petsa ng pagsisimula',
	'usagestatisticsnoend' => 'Pakitukoy ang isang petsa ng pagwawakas',
	'usagestatisticsbadstartend' => '<b>Maling petsa ng <i>pagsisimula</i> at/o <i>pagwawakas</i>!</b>',
	'usagestatisticsintervalday' => 'Araw',
	'usagestatisticsintervalweek' => 'Linggo',
	'usagestatisticsintervalmonth' => 'Buwan',
	'usagestatisticsincremental' => 'Unti-unting dagdag (may inkremento)',
	'usagestatisticsincremental-text' => 'unti-unting dagdag (may inkremento)',
	'usagestatisticscumulative' => 'Maramihang dagdag (kumulatibo)',
	'usagestatisticscumulative-text' => 'maramihang dagdag (kumulatibo)',
	'usagestatisticscalselect' => 'Piliin',
	'usagestatistics-editindividual' => '$1 mga estadistika ng paggamit para sa indibidwal o isang tagagamit',
	'usagestatistics-editpages' => '$1 mga estadistika ng pahina para sa isang indibidwal o isang tagagamit',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'specialuserstats' => 'Kullanım istatistikleri',
	'usagestatistics' => 'Kullanım istatistikleri',
	'usagestatisticsinterval' => 'Aralık:',
	'usagestatisticsnamespace' => 'İsim alanı:',
	'usagestatisticsexcluderedirects' => 'Yönlendirmeleri kapsam dışında bırak',
	'usagestatisticstype' => 'Tür:',
	'usagestatisticsstart' => 'Başlangıç tarihi:',
	'usagestatisticsend' => 'Bitiş tarihi:',
	'usagestatisticssubmit' => 'İstatistik oluştur',
	'usagestatisticsnostart' => 'Lütfen bir başlangıç tarihi girin',
	'usagestatisticsnoend' => 'Lütfen bir bitiş tarihi girin',
	'usagestatisticsintervalday' => 'Gün',
	'usagestatisticsintervalweek' => 'Hafta',
	'usagestatisticsintervalmonth' => 'Ay',
	'usagestatisticsincremental' => 'Artımlı',
	'usagestatisticscumulative' => 'Kümülatif',
	'usagestatisticscalselect' => 'Seç',
);

/** Ukrainian (Українська)
 * @author A1
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'specialuserstats' => 'Статистика використання',
	'usagestatistics' => 'Статистика використання',
	'usagestatistics-desc' => 'Показує індивідуальну для користувача і загальну для вікі статистику використання',
	'usagestatisticsfor' => '<h2>Статистика використання для користувача [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Статистика використання для всіх користувачів</h2>',
	'usagestatisticsinterval' => 'Інтервал:',
	'usagestatisticsnamespace' => 'Простір назв:',
	'usagestatisticsexcluderedirects' => 'Виключити перенаправлення',
	'usagestatistics-namespace' => 'Ці статистичні дані щодо простору назв [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => '[[Special:ListRedirects|Перенаправлення]] не беруться до уваги.',
	'usagestatisticstype' => 'Тип',
	'usagestatisticsstart' => 'Дата початку:',
	'usagestatisticsend' => 'Дата закінчення:',
	'usagestatisticssubmit' => 'Згенерувати статистику',
	'usagestatisticsnostart' => 'Будь ласка, зазначте дату початку',
	'usagestatisticsnoend' => 'Будь ласка, зазначте дату закінчення',
	'usagestatisticsbadstartend' => '<b>Невірна дата <i>початку</i> та/або <i>закінчення</i>!</b>',
	'usagestatisticsintervalday' => 'День',
	'usagestatisticsintervalweek' => 'Тиждень',
	'usagestatisticsintervalmonth' => 'Місяць',
	'usagestatisticsincremental' => 'Приріст',
	'usagestatisticsincremental-text' => 'приріст',
	'usagestatisticscumulative' => 'Сукупна',
	'usagestatisticscumulative-text' => 'сукупна',
	'usagestatisticscalselect' => 'Вибрати',
	'usagestatistics-editindividual' => 'Статистика $1 для індивідуальних редагувань',
	'usagestatistics-editpages' => 'Статистика $1 для сторінок користувача',
	'right-viewsystemstats' => 'перегляд [[Special:UserStats|статистики використання вікі]]',
);

/** Veps (Vepsan kel')
 * @author Triple-ADHD-AS
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'specialuserstats' => 'Kävutamižen statistik',
	'usagestatistics' => 'Kävutamižen statistik',
	'usagestatistics-desc' => 'Ozutada kut individualižen kävutajan, muga globalšt wikin kävutamižen statistikad',
	'usagestatisticsfor' => '<h2>Kävutamižen statistik [[User:$1|$1]]-kävutajan täht</h2>',
	'usagestatisticsforallusers' => '<h2>Kävutamižen statistik kaikiden kävutjiden täht</h2>',
	'usagestatisticsinterval' => 'Interval:',
	'usagestatisticsnamespace' => 'Nimiavaruz:',
	'usagestatisticsexcluderedirects' => 'Heitta udesoigendused',
	'usagestatistics-namespace' => 'Nened statistižed andmused oma [[Special:Allpages/$1|$2]]-nimiavarusespäi.',
	'usagestatistics-noredirects' => "[[Special:ListRedirects|Udesoigendamižid]] ei ottas sil'mnägubale.",
	'usagestatisticstype' => 'Tip',
	'usagestatisticsstart' => 'Augotiždat:',
	'usagestatisticsend' => 'Lopdat:',
	'usagestatisticssubmit' => 'Generiruida statistikad',
	'usagestatisticsnostart' => 'Olgat hüväd, kirjutagat augotiždat',
	'usagestatisticsnoend' => 'Olgat hüväd, kirjutagat lopdat',
	'usagestatisticsbadstartend' => '<b>Vär <i>augotiždat </i>vai <i>lopdat!</b>',
	'usagestatisticsintervalday' => 'Päiv',
	'usagestatisticsintervalweek' => 'Nedal’',
	'usagestatisticsintervalmonth' => 'Ku',
	'usagestatisticsincremental' => 'Kazvai',
	'usagestatisticsincremental-text' => 'kazvai',
	'usagestatisticscumulative' => 'Ühthine',
	'usagestatisticscumulative-text' => 'ühthine',
	'usagestatisticscalselect' => 'Valita',
	'usagestatistics-editindividual' => 'Individualižen kävutajan $1 statistik',
	'usagestatistics-editpages' => 'Individualižen kävutajan lehtpoliden $1 statistik',
	'right-viewsystemstats' => 'Ozutada [[Special:UserStats|wikin kävutamižen statistikad]]',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'specialuserstats' => 'Thống kê sử dụng',
	'usagestatistics' => 'Thống kê sử dụng',
	'usagestatistics-desc' => 'Hiển thị thông kế sử dụng của từng cá nhân và toàn wiki',
	'usagestatisticsfor' => '<h2>Thống kê sử dụng về [[User:$1|$1]]</h2>',
	'usagestatisticsforallusers' => '<h2>Thống kê sử dụng của mọi người dùng</h2>',
	'usagestatisticsinterval' => 'Khoảng thời gian:',
	'usagestatisticsnamespace' => 'Không gian tên:',
	'usagestatisticsexcluderedirects' => 'Trừ trang đổi hướng',
	'usagestatistics-namespace' => 'Đây là những số liệu thống kê trong không gian tên [[Special:Allpages/$1|$2]].',
	'usagestatistics-noredirects' => 'Không tính [[Special:ListRedirects|trang đổi hướng]].',
	'usagestatisticstype' => 'Loại',
	'usagestatisticsstart' => 'Ngày đầu:',
	'usagestatisticsend' => 'Ngày cùng:',
	'usagestatisticssubmit' => 'Tính ra thống kê',
	'usagestatisticsnostart' => 'Xin ghi rõ ngày bắt đầu',
	'usagestatisticsnoend' => 'Xin hãy định rõ ngày kết thúc',
	'usagestatisticsbadstartend' => '<b>Ngày <i>bắt đầu</i> và/hoặc <i>kết thúc</i> không hợp lệ!</b>',
	'usagestatisticsintervalday' => 'Ngày',
	'usagestatisticsintervalweek' => 'Tuần',
	'usagestatisticsintervalmonth' => 'Tháng',
	'usagestatisticsincremental' => 'Tăng dần',
	'usagestatisticsincremental-text' => 'tăng dần',
	'usagestatisticscumulative' => 'Tổng cộng',
	'usagestatisticscumulative-text' => 'tổng cộng',
	'usagestatisticscalselect' => 'Chọn',
	'usagestatistics-editindividual' => 'Thống kê sửa đổi $1 của cá nhân người dùng',
	'usagestatistics-editpages' => 'Thống kê trang $1 của cá nhân người dùng',
	'right-viewsystemstats' => 'Xem [[Special:UserStats|thống kê sử dụng wiki]]',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'specialuserstats' => 'Gebamastatits',
	'usagestatistics' => 'Gebamastatits',
	'usagestatisticstype' => 'Sot',
	'usagestatisticsstart' => 'Primadät',
	'usagestatisticsend' => 'Finadät',
	'usagestatisticssubmit' => 'Jafön Statitis',
	'usagestatisticsnostart' => 'Penolös primadäti',
	'usagestatisticsnoend' => 'Penolös finadäti',
	'usagestatisticsintervalday' => 'Del',
	'usagestatisticsintervalweek' => 'Vig',
	'usagestatisticsintervalmonth' => 'Mul',
	'usagestatisticscalselect' => 'Välön',
	'usagestatistics-editindividual' => 'Redakamastatits tefü geban: $1',
	'usagestatistics-editpages' => 'Padastatits tefü geban: $1',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'usagestatisticstype' => 'טיפ:',
	'usagestatisticsintervalday' => 'טאָג',
	'usagestatisticsintervalweek' => 'וואך',
	'usagestatisticsintervalmonth' => 'מאנאַט',
	'usagestatisticscalselect' => 'אויסוויילן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'specialuserstats' => '使用分析',
	'usagestatistics' => '使用分析',
	'usagestatistics-desc' => '显示每个用户与整个维基的使用分析',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]]的使用分析</h2>',
	'usagestatisticsforallusers' => '<h2>所有用户的使用分析</h2>',
	'usagestatisticsinterval' => '区间',
	'usagestatisticstype' => '类型',
	'usagestatisticsstart' => '开始日期',
	'usagestatisticsend' => '结束日期',
	'usagestatisticssubmit' => '生成统计',
	'usagestatisticsnostart' => '请选择开始日期',
	'usagestatisticsnoend' => '请选择结束日期',
	'usagestatisticsbadstartend' => '<b><i>开始</i>或者<i>结束</i>日期错误！</b>',
	'usagestatisticsintervalday' => '日',
	'usagestatisticsintervalweek' => '周',
	'usagestatisticsintervalmonth' => '月',
	'usagestatisticsincremental' => '增量',
	'usagestatisticsincremental-text' => '增量',
	'usagestatisticscumulative' => '累积',
	'usagestatisticscumulative-text' => '累积',
	'usagestatisticscalselect' => '选择',
	'usagestatistics-editindividual' => '用户$1编辑统计分析',
	'usagestatistics-editpages' => '用户$1统计分析',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'specialuserstats' => '使用分析',
	'usagestatistics' => '使用分析',
	'usagestatistics-desc' => '顯示每個用戶與整個維基的使用分析',
	'usagestatisticsfor' => '<h2>[[User:$1|$1]]的使用分析</h2>',
	'usagestatisticsforallusers' => '<h2>所有用戶的使用分析</h2>',
	'usagestatisticsinterval' => '區間',
	'usagestatisticstype' => '類型',
	'usagestatisticsstart' => '開始日期',
	'usagestatisticsend' => '結束日期',
	'usagestatisticssubmit' => '生成統計',
	'usagestatisticsnostart' => '請選擇開始日期',
	'usagestatisticsnoend' => '請選擇結束日期',
	'usagestatisticsbadstartend' => '<b><i>開始</i>或者<i>結束</i>日期錯誤！</b>',
	'usagestatisticsintervalday' => '日',
	'usagestatisticsintervalweek' => '周',
	'usagestatisticsintervalmonth' => '月',
	'usagestatisticsincremental' => '增量',
	'usagestatisticsincremental-text' => '增量',
	'usagestatisticscumulative' => '累積',
	'usagestatisticscumulative-text' => '累積',
	'usagestatisticscalselect' => '選擇',
	'usagestatistics-editindividual' => '用戶$1編輯統計分析',
	'usagestatistics-editpages' => '用戶$1統計分析',
);

