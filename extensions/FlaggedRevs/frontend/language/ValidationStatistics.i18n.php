<?php
/**
 * Internationalisation file for FlaggedRevs extension, section ValidationStatistics
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'validationstatistics'        => 'Page review statistics',
	'validationstatistics-users'  => '\'\'\'{{SITENAME}}\'\'\' currently has \'\'\'[[Special:ListUsers/editor|$1]]\'\'\' {{PLURAL:$1|user|users}} with [[{{MediaWiki:Validationpage}}|Editor]] rights.

Editors are established users that can spot-check revisions to pages.',
    'validationstatistics-lastupdate' => '\'\'The following data was last updated on $1 at $2.\'\'',
	'validationstatistics-pndtime'   => 'Edits that have been checked by established users are considered \'\'reviewed\'\'.

The average review delay for [[Special:OldReviewedPages|pages with edits pending review]] is \'\'\'$1\'\'\'; the delay measures how long the oldest pending edit has gone unreviewed.',
    'validationstatistics-revtime'   => 'The average wait for edits by \'\'users that have not logged in\'\' to be reviewed is \'\'\'$1\'\'\'; the median is \'\'\'$2\'\'\'. 
$3',
	'validationstatistics-table'  => "Page review statistics for each namespace are shown below, ''excluding'' redirect pages. Pages are treated as ''outdated'' if they have edits pending review; pages are considered ''synced'' if there are no edits pending review.",
	'validationstatistics-ns'     => 'Namespace',
	'validationstatistics-total'  => 'Pages',
	'validationstatistics-stable' => 'Reviewed',
	'validationstatistics-latest' => 'Synced',
	'validationstatistics-synced' => 'Synced/Reviewed',
	'validationstatistics-old'    => 'Outdated',
	'validationstatistics-utable' => 'Below is a list of the {{PLURAL:$1|most active reviewer|$1 most active reviewers}} in the last {{PLURAL:$2|hour|$2 hours}}.',
	'validationstatistics-user'   => 'User',
	'validationstatistics-reviews' => 'Reviews',
);

/** Message documentation (Message documentation)
 * @author Aaron Schulz
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Raymond
 * @author Umherirrender
 * @author Yekrats
 */
$messages['qqq'] = array(
	'validationstatistics' => '{{Flagged Revs}}
Name of the [[Special:ValidationStatistics]] page, which contains review statistics.',
	'validationstatistics-users' => "{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
*$1 Number of users in the Editor group.
This message is likely customized per wiki as (a) some don't use an 'editor' group or (b) it called something else",
	'validationstatistics-lastupdate' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
* $1 = Date
* $2 = Time',
	'validationstatistics-pndtime' => '{{Flagged Revs}}
Provides the first informative paragraph in [[Special:ValidationStatistics]].
* $1 is the average wait time for page reviews at [[Special:PendingChanges]].',
	'validationstatistics-revtime' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
*$1 The duration of time that the average "anon" edit takes to get reviewed
*$2 The median duration of time that the average "anon" edit takes to get reviewed
*$3 A tabulation of the percentiles of the duration of time it takes to get "anon" edits reviewed. For example, if the P90 value is 1h33m then 90% of edits get reviewed within 1 hour, 33 minutes.',
	'validationstatistics-table' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].',
	'validationstatistics-ns' => '{{Flagged Revs}}
{{Identical|Namespace}}',
	'validationstatistics-total' => '{{Flagged Revs}}
{{Identical|Pages}}
Shown on the page [[Special:ValidationStatistics]].
Table header for all pages in a certain namespace.',
	'validationstatistics-stable' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
Table header for pages that that have a stable version',
	'validationstatistics-latest' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
Table header for pages that that have a stable version and no pending changes.',
	'validationstatistics-synced' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
Table header for the ratio of pages that that have a stable version and no pending changes *over* all pages with a stable version.',
	'validationstatistics-old' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
Table header for pages that have pending changes (edits newer than the stable version).',
	'validationstatistics-utable' => '{{Flagged Revs}}
Shown on the page [[Special:ValidationStatistics]].
$1 Number of users in the "top active reviewers" list.
$2 Number of hours of reviews the list is based on. The list includes items from $2 hours ago up to the present.',
	'validationstatistics-user' => '{{Flagged Revs}}
Shown on [[Special:ValidationStatistics]].
Used as the "user" table column header for the "users who made the most reviews recently" table.',
	'validationstatistics-reviews' => '{{Flagged Revs}}
Shown on [[Special:ValidationStatistics]].
Used as the "number of reviews" table column header for the "users who made the most reviews recently" table.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'validationstatistics' => 'Die statistiek van die bladsy oordeel',
	'validationstatistics-ns' => 'Naamruimte',
	'validationstatistics-total' => 'Bladsye',
	'validationstatistics-latest' => 'Gesinchroniseerd',
	'validationstatistics-old' => 'Verouderd',
	'validationstatistics-user' => 'Gebruiker',
	'validationstatistics-reviews' => 'Beoordelings',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'validationstatistics-ns' => 'ክፍለ-ዊኪ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'validationstatistics-ns' => 'Espacio de nombres',
);

/** Arabic (العربية)
 * @author ;Hiba;1
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'validationstatistics' => 'إحصاءات مراجعة الصفحة',
	'validationstatistics-users' => "على '''{{SITENAME}}''' حاليا {{PLURAL:$1||'''[[Special:ListUsers/editor|مستخدم واحد]]'''|'''[[Special:ListUsers/editor|مستخدمان]]'''|'''[[Special:ListUsers/editor|$1]]''' مستخدمين|'''[[Special:ListUsers/editor|$1]]''' مستخدمًا|'''[[Special:ListUsers/editor|$1]]''' مستخدم}} بصلاحية [[{{MediaWiki:Validationpage}}|محرر]].

المحررون هم مستخدمون موثوقون يمكنهم اعتماد مراجعات الصفحات.",
	'validationstatistics-lastupdate' => "''حدثت البيانات التالية آخر مرة يوم $1 عند $2.''",
	'validationstatistics-pndtime' => "تعتبر التعديلات التي فحصها مستخدمون معتمدون ''مراجعة''.

إن متوسط التأخير في المراجعة لل​​[[Special:OldReviewedPages|صفحات التي هي في انتظار مراجعة]] هو ''' $1 '''، إن التأخير يعبر عن مدى قدم أقدم تعديل لم تتم مراجعته.",
	'validationstatistics-revtime' => "معدل الانتظار للتعديل من قبل ''المستخدمين غير المسجلين'' ليتم مراجعتها هو '''$1'''، والوسيط هو '''$2'''. 
$3",
	'validationstatistics-table' => "إحصاءات مراجعة الصفحات لكل نطاق معروضة بالأسفل، ''باستثناء'' صفحات التحويل. تعتبر الصفحات ''غير محدثة'' إذا كان لها تعديلات معلقة للمراجعة؛ تعتبر الصفحات ''متزامنة'' إذا لم يكن لها تعديلات معلقة للمراجعة.",
	'validationstatistics-ns' => 'النطاق',
	'validationstatistics-total' => 'الصفحات',
	'validationstatistics-stable' => 'مراجع',
	'validationstatistics-latest' => 'محدث',
	'validationstatistics-synced' => 'تم تحديثه/تمت مراجعته',
	'validationstatistics-old' => 'قديمة',
	'validationstatistics-utable' => 'بالأسفل قائمة بأكثر {{PLURAL:$1||مراجع نشاطا|مراجعين نشاطا|$1 مراجعين نشاطا|$1 مراجع نشاطا|$1 مراجعا نشاطا}} في {{PLURAL:$2||الساعة الأخيرة|الساعتين الأخيرتين|ال$2 ساعات الأخيرة|ال$2 ساعة الأخيرة}}.',
	'validationstatistics-user' => 'المستخدم',
	'validationstatistics-reviews' => 'مراجعات',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author 334a
 * @author Basharh
 */
$messages['arc'] = array(
	'validationstatistics-ns' => 'ܚܩܠܐ',
	'validationstatistics-total' => 'ܦܐܬܬ̈ܐ',
	'validationstatistics-user' => 'ܡܦܠܚܢܐ',
	'validationstatistics-reviews' => 'ܬܢܝܬ̈ܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'validationstatistics' => 'إحصاءات التحقق',
	'validationstatistics-users' => "'''{{SITENAME}}''' دلوقتى فيه '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|يوزر|يوزر}} بحقوق [[{{MediaWiki:Validationpage}}|محرر]].

المحررين هما يوزرات متعيّنين و يقدرو يشوفو و يشيّكو على مراجعات الصفح.",
	'validationstatistics-table' => "الإحصاءات لكل نطاق معروضه بالأسفل، ''ولا يشمل ذلك'' صفحات التحويل.",
	'validationstatistics-ns' => 'النطاق',
	'validationstatistics-total' => 'الصفحات',
	'validationstatistics-stable' => 'مراجع',
	'validationstatistics-latest' => 'محدث',
	'validationstatistics-synced' => 'تم تحديثه/تمت مراجعته',
	'validationstatistics-old' => 'قديمة',
	'validationstatistics-utable' => 'بالأسفل قائمه بأعلى $1 مراجعين فى الساعه الأخيره.',
	'validationstatistics-user' => 'المستخدم',
	'validationstatistics-reviews' => 'مراجعات',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'validationstatistics-ns' => 'Espaciu de nomes',
	'validationstatistics-total' => 'Páxines',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'validationstatistics-ns' => 'Adlar fəzası',
	'validationstatistics-total' => 'Səhifələr',
	'validationstatistics-user' => 'İstifadəçi',
);

/** Belarusian (Беларуская)
 * @author Хомелка
 */
$messages['be'] = array(
	'validationstatistics' => 'Статыстыка праверак старонак',
	'validationstatistics-users' => "У праекце {{SITENAME}} на дадзены момант '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|удзельнік мае|удзельнікі маюць|удзельнікаў маюць}} паўнамоцтвы [[{{MediaWiki:Validationpage}}|«рэдактара»]].

«Рэдактары» — гэта пэўныя ўдзельнікі, якія маюць магчымасць рабіць выбарачную праверку пэўных версій старонак.",
	'validationstatistics-lastupdate' => "''Наступныя дадзеныя былі апошні раз абноўленыя $1 у $2.''",
	'validationstatistics-pndtime' => "Праўкі, адзначаныя пэўнымі удзельнікамі, лічацца праверанымі.

Сярэдняя затрымка [[Special:OldReviewedPages|для старонак з неправеранымі зменамі]] — '''$1'''. 
Гэтыя старонкі лічацца ''састарэлымі''. Старонкі лічацца ''сінхранізаванымі'', калі няма правак, якія чакаюць праверкі.",
	'validationstatistics-revtime' => "Сярэдняя затрымка праверкі для зменаў, якія зрабілі ''ўдзельнікі, якія не прадставіліся'', складае '''$1'''; медыяна — '''$2'''. 
$3",
	'validationstatistics-table' => "Ніжэй прадстаўлена статыстыка праверак па кожнай прасторы імёнаў, ''выключаючы'' старонкі перанакіраванняў.",
	'validationstatistics-ns' => 'Прастора імёнаў',
	'validationstatistics-total' => 'Старонак',
	'validationstatistics-stable' => 'Правераныя',
	'validationstatistics-latest' => 'Пераправераныя',
	'validationstatistics-synced' => 'Доля пераправераных у правераных',
	'validationstatistics-old' => 'Састарэлыя',
	'validationstatistics-utable' => 'Ніжэй прыведзены пералік з $1 найбольш актыўных вывяраючых за апошнюю гадзіну.',
	'validationstatistics-user' => 'Удзельнік',
	'validationstatistics-reviews' => 'Праверкі',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'validationstatistics' => 'Статыстыка рэцэнзаваньня старонак',
	'validationstatistics-users' => "'''{{SITENAME}}''' цяпер налічвае '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|удзельніка|удзельнікаў|удзельнікаў}} з правамі «[[{{MediaWiki:Validationpage}}|рэдактара]]».

Рэдактары — асобныя удзельнікі, якія могуць правяраць вэрсіі старонак.",
	'validationstatistics-lastupdate' => "''Наступныя зьвесткі былі абноўленыя $1 у $2.''",
	'validationstatistics-pndtime' => "Рэдагаваньні, правераныя ўпаўнаважанымі ўдзельнікамі, лічацца ''рэцэнзаванымі''.

Сярэдняя затрымка для [[Special:OldReviewedPages|старонак, якія чакаюць рэцэнзаваньня]] складае '''$1''' і вымярае як доўга рэдагаваньне застаецца нерэцэнзаваным.",
	'validationstatistics-revtime' => "Сярэдняя затрымка для рэдагаваньняў для ''ананімных удзельнікаў'', якія чакаюць рэцэнзаваньня, складае '''$1'''; мэдыяна — '''$2'''.
$3",
	'validationstatistics-table' => "Статыстыка рэцэнзаваньняў старонак для кожнай прасторы назваў пададзеная ніжэй, ''за выключэньнем'' старонак-перанакіраваньняў. Старонкі лічацца ''састарэлымі'', калі яны маюць нерэцэнзаваныя рэдагаваньні; старонкі лічацца ''сынхранізаванымі'', калі яны ня маюць нерэцэнзаваных рэдагаваньняў.",
	'validationstatistics-ns' => 'Прастора назваў',
	'validationstatistics-total' => 'Старонак',
	'validationstatistics-stable' => 'Правераных',
	'validationstatistics-latest' => 'Сынхранізаваных',
	'validationstatistics-synced' => 'Паўторна правераных',
	'validationstatistics-old' => 'Састарэлых',
	'validationstatistics-utable' => 'Ніжэй пададзены сьпіс з $1 {{PLURAL:$1|самага актыўнага рэцэнзэнта|самых актыўных рэцэнзэнтаў|самых актыўных рэцэнзэнтаў}} за {{PLURAL:$2|$2 апошнюю гадзіну|$2 апошнія гадзіны|$2 апошніх гадзінаў}}.',
	'validationstatistics-user' => 'Удзельнік',
	'validationstatistics-reviews' => 'Рэцэнзіяў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'validationstatistics-lastupdate' => "''Следните данни за последно са актуализирани на $1 в $2.''",
	'validationstatistics-ns' => 'Именно пространство',
	'validationstatistics-total' => 'Страници',
	'validationstatistics-stable' => 'Рецензирани',
	'validationstatistics-utable' => 'По-долу е даден списък на {{PLURAL:$1|най-активния рецензент|най-активните $1 рецензенти}} през {{PLURAL:$2|последния един час|последните $2 часа}}.',
	'validationstatistics-user' => 'Потребител',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'validationstatistics-ns' => 'নামস্থান',
	'validationstatistics-total' => 'পাতা',
	'validationstatistics-stable' => 'পর্যালোচিত',
	'validationstatistics-user' => 'ব্যবহারকারী',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'validationstatistics' => 'Stadegoù adlenn ar pajennoù',
	'validationstatistics-users' => "Evit ar poent, war '''{{SITENAME}}''' ez eus '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|implijer gantañ|implijer ganto}} gwirioù [[{{MediaWiki:Validationpage}}|Aozer]]. 

An Aozerien hag an Adlennerien a zo implijerien staliet a c'hell gwiriañ adweladennoù ar pajennoù.",
	'validationstatistics-lastupdate' => "''Ar roadennoù da-heul a zo bet hizivaet d'an $1 da $2.''",
	'validationstatistics-pndtime' => "Sellet a reer ouzh ar c'hemmoù gwiriet gant an implijerien arroutet evel kemmoù ''adlennet''..

An dale keitat evit [[Special:OldReviewedPages|ar pajennoù a c'hortoz bezañ adlennet]] a sav da '''$1'''; Muzuliañ a ra an termen pegen pell eo chomet ar c'hemm diwezhañ hep bezañ gwiriet.",
	'validationstatistics-revtime' => "Sevel a ra an amzer gortoz keitat evit adlenn kemmoù graet gant \"implijerien dienroll\" da '''\$1''' ; ar geidenn zo '''\$2'''.
\$3",
	'validationstatistics-table' => "A-is emañ diskouezet ar stadegoù adwelout evit pep esaouenn anv, ''nemet'' evit ar pajennoù adkas. Sellet a reer ouzh ar pajennoù evel ''dispredet'' ma'z eus kemmoù enno a chom da vezañ aprouet; sellet a reer ouzh ar pajennoù evel ''sinkronelaet'' ma n'eus netra enno da vezañ aprouet.",
	'validationstatistics-ns' => 'Esaouenn anv',
	'validationstatistics-total' => 'Pajennoù',
	'validationstatistics-stable' => 'Adwelet',
	'validationstatistics-latest' => 'Sinkronelaet',
	'validationstatistics-synced' => 'Sinkronelaet/Adwelet',
	'validationstatistics-old' => 'Dispredet',
	'validationstatistics-utable' => 'A-is emañ {{PLURAL:$1|anv an adlenner oberiantañ|anv an $1 adlenner oberiantañ}} en {{PLURAL:$2|eurvezh|$2 eurvezh}} ziwezhañ.',
	'validationstatistics-user' => 'Implijer',
	'validationstatistics-reviews' => 'Adweladennoù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'validationstatistics' => 'Statistike provjera stranice',
	'validationstatistics-users' => "'''{{SITENAME}}''' trenutno ima '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|korisnika|korisnika}} sa pravima [[{{MediaWiki:Validationpage}}|urednika]].

Urednici su potvrđeni korisnici koji mogu izvršavati provjere revizija stranice.",
	'validationstatistics-lastupdate' => "''Slijedeći podaci su posljednji put ažurirani $1 u $2.''",
	'validationstatistics-pndtime' => "Izmjene koje su pregledali potvrđeni korisnici se smatraju ''pregledane''.

Prosječno čekanje za [[Special:OldReviewedPages|stranice sa nepregledanim izmjenama na čekanju]] je '''$1'''; čekanje mjeri koliko dugo najstarija izmjena na čekanju stoji nepregledana.",
	'validationstatistics-revtime' => "Prosječno čekanje izmjena od strane ''korisnika koji nisu prijavljeni'' za pregled je '''$1''';medijan je '''$2'''. 
$3",
	'validationstatistics-table' => "Statistike pregleda stranica za svaki imenski prostor su prikazane ispod, ''isključujući'' stranice preusmjeravanja. Stranice se smatraju ''neažurnim'' ako imaju izmjene na čekanju; stranice se smatraju ''ažurnim'' ako nemaju izmjena koje čekaju.",
	'validationstatistics-ns' => 'Imenski prostor',
	'validationstatistics-total' => 'Stranice',
	'validationstatistics-stable' => 'Provjereno',
	'validationstatistics-latest' => 'Sinhronizirano',
	'validationstatistics-synced' => 'Sinhronizirano/provjereno',
	'validationstatistics-old' => 'Zastarijelo',
	'validationstatistics-utable' => 'Ispod je spisak {{PLURAL:$1|najaktivnijeg provjerivača|$1 najaktivnija provjerivača|$1 najaktivnijih provjerivača}} u zadnjih {{PLURAL:$2|sat vremena|$2 sata|$2 sati}}.',
	'validationstatistics-user' => 'Korisnik',
	'validationstatistics-reviews' => 'Pregledi',
);

/** Catalan (Català)
 * @author Aleator
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'validationstatistics' => 'Estadístiques de validació',
	'validationstatistics-users' => "'''{{SITENAME}}''' té actualment '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usuari|usuaris}} amb drets d'[[{{MediaWiki:Validationpage}}|Editor]].

Els Editors són usuaris experimentats que poden validar les revisions de les pàgines.",
	'validationstatistics-ns' => 'Espai de noms',
	'validationstatistics-total' => 'Pàgines',
	'validationstatistics-stable' => "S'ha revisat",
	'validationstatistics-latest' => 'Sincronitzat',
	'validationstatistics-synced' => 'Sincronitzat/Revisat',
	'validationstatistics-user' => 'Usuari',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'validationstatistics-ns' => 'Цlерийн ана',
	'validationstatistics-total' => 'Агlонаш',
	'validationstatistics-stable' => 'Нийса йуй хаьжнарш',
	'validationstatistics-latest' => 'Йуха хьаьжинарш',
	'validationstatistics-user' => 'Декъашхо',
	'validationstatistics-reviews' => 'Нийса йуй хьажар',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'validationstatistics-user' => 'بەکارهێنەر',
);

/** Czech (Česky)
 * @author Jkjk
 * @author Kuvaly
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'validationstatistics' => 'Statistiky ověřování',
	'validationstatistics-users' => "'''{{SITENAME}}''' má práve teď '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|uživatele|uživatele|uživatelů}} s právy [[{{MediaWiki:Validationpage}}|editora]] a '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$1|uživatele|uživatele|uživatelů}} s právy [[{{MediaWiki:Validationpage}}|posuzovatele]].",
	'validationstatistics-lastupdate' => "''Následující údaje byly aktualizovány $1 $2.''",
	'validationstatistics-pndtime' => "Editace, který byly zkontrolovány důvěryhodnými uživateli se považují za posouzené.

Průměrné zpoždění [[Special:OldReviewedPages|stránek s čekajícími editacemi]] je '''$1'''.
Tyto stránky jsou považovány za ''zastaralé''. Podobně stránky jsou považovány za ''synchronizované'', pokud nemají žádné čekající změny.",
	'validationstatistics-revtime' => "Průměrná čekací doba editací od ''nepřihlášených uživatelů'' na posouzení je '''$1'''; medián je '''$2'''.
$3",
	'validationstatistics-table' => "Níže jsou zobrazeny statistiky pro každý jmenný prostor ''kromě'' přesměrování.",
	'validationstatistics-ns' => 'Jmenný prostor',
	'validationstatistics-total' => 'Stránky',
	'validationstatistics-stable' => 'Prověřeno',
	'validationstatistics-latest' => 'Synchronizováno',
	'validationstatistics-synced' => 'Synchronizováno/prověřeno',
	'validationstatistics-old' => 'Zastaralé',
	'validationstatistics-utable' => 'Níže je seznam $1 největších posuzovatelů za poslední hodinu.',
	'validationstatistics-user' => 'Uživatel',
	'validationstatistics-reviews' => 'Posouzení',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'validationstatistics-total' => 'страни́цѧ',
);

/** Danish (Dansk)
 * @author Froztbyte
 */
$messages['da'] = array(
	'validationstatistics-ns' => 'Navnerum',
	'validationstatistics-total' => 'Sider',
	'validationstatistics-stable' => 'Vurderet',
	'validationstatistics-old' => 'Forældet',
	'validationstatistics-user' => 'Bruger',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Kghbln
 * @author Melancholie
 * @author Merlissimo
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'validationstatistics' => 'Statistiken zu Versionsmarkierungen',
	'validationstatistics-users' => "'''{{SITENAME}}''' hat momentan '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Sichterrecht]].

Sichter sind anerkannte Benutzer, die Versionen einer Seite markieren können.",
	'validationstatistics-lastupdate' => "''Die folgenden Daten wurden zuletzt am $1 um $2 Uhr aktualisiert.''",
	'validationstatistics-pndtime' => "Bearbeitungen, die von anerkannten Benutzern bestätigt wurden, gelten als markiert.

Die durchschnittliche Wartezeit der [[Special:OldReviewedPages|Seiten mit unmarkierten Änderungen]] beträgt '''$1'''. Die Verzögerung misst wie lang die älteste unmarkierte Änderung unbestätigt blieb.",
	'validationstatistics-revtime' => "Die durchschnittliche Wartezeit bis zur Markierung, bei Bearbeitungen ''durch Benutzer, die nicht angemeldet waren''  beträgt '''$1'''; der Median ist '''$2'''. 
$3",
	'validationstatistics-table' => 'Die Statistiken zu den Versionsmarkierungen aller Seiten, mit Ausnahme von Weiterleitungsseiten, werden unten für jeden Namensraum angezeigt. Seiten werden als veraltet eingestuft, sofern sie unmarkierte Änderungen enthalten. Alle anderen Seiten werden als markiert und somit aktuell eingestuft.',
	'validationstatistics-ns' => 'Namensraum',
	'validationstatistics-total' => 'Seiten gesamt',
	'validationstatistics-stable' => 'Mindestens eine Version markiert',
	'validationstatistics-latest' => 'Anzahl Seiten, die in der aktuellen Version markiert sind',
	'validationstatistics-synced' => 'Prozentsatz an Seiten, die in der aktuellen Version markiert sind',
	'validationstatistics-old' => 'Seiten mit unmarkierten Änderungen',
	'validationstatistics-utable' => 'Nachfolgend die Anzeige {{PLURAL:$1|des aktivsten Sichters|der $1 aktivsten Sichter}} der letzten {{PLURAL:$2|Stunde|$2 Stunden}}.',
	'validationstatistics-user' => 'Benutzer',
	'validationstatistics-reviews' => 'Markierungen',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'validationstatistics' => 'Pele istatîstîksê onay biyayisi',
	'validationstatistics-users' => "'''{{SITENAME}}''' de nika '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|karber|karberan}} pê heqê [[{{MediaWiki:Validationpage}}|Editor]]î estê.

Editorî u kontrol kerdoğî karberanê kihanyerê ke eşkenî pelan revize bike.",
	'validationstatistics-lastupdate' => "''Ena data tewr peyên roca $1 seatê $2 de biya rocani.''",
	'validationstatistics-pndtime' => "Vurnayişan ke karberanê kihanan ra nişan biyo inan ma heseb keni qontrol biya.

Avaraj tehcil qey [[Special:OldReviewedPages|pages with unreviewed edits pending]] '''$1''' a.
Ena pelan ma ''kihanan'' ra hesebneni. Eka yew vuranayişan ciniyo, pelan ke ''sync'' kebul beno.",
	'validationstatistics-revtime' => "Avaraj tecil seba vurnayişan pê ''karberanê ke hama ci nikewta'' qontrol beno '''$1'''; mediyan '''$2''' ya. 
$3",
	'validationstatistics-table' => "Ser her cayênameyî rê îstatistiks bin de mucnayîyo, pelanê redreksiyonî ''nimucniyo\".",
	'validationstatistics-ns' => 'Cayênameyî',
	'validationstatistics-total' => 'Ripelî',
	'validationstatistics-stable' => 'Kontrol biyo',
	'validationstatistics-latest' => 'Rocaniye biyo',
	'validationstatistics-synced' => 'Rocaniye biyo/Kontrol biyo',
	'validationstatistics-old' => 'Hin nihebitiyeno',
	'validationstatistics-utable' => 'Cor de yew liste est ke seatê penî de panc kontrol kerdoğî mucneno.',
	'validationstatistics-user' => 'Karber',
	'validationstatistics-reviews' => 'Revizyonî',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'validationstatistics' => 'Statistika pśeglědowanja bokow',
	'validationstatistics-users' => "'''{{SITENAME}}''' ma tuchylu '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|wužywarja|wužywarjowu|wužywarjow|wužywarjow}} z [[{{MediaWiki:Validationpage}}|pšawami wobźěłowarja]].

Wobźěłowarje su etablěrowane wužiwarje, kótarež mógu wersije bokow pśeglědaś.",
	'validationstatistics-lastupdate' => "''Slědujuce daty su se $1 $2 zaktualizěrowali.''",
	'validationstatistics-pndtime' => "Změny, kótarež su se pśekontrolěrowali wót  nazgónitych wužywarjow by měli se ''pśeglědaś''.

Psérězne wokomuźenje pśeglědanja za [[Special:OldReviewedPages|boki z njepśeglědanymi změnami]] jo '''$1''';
wokomuźenje měri, kak dłujko nejstarša njepśeglědana změna jo južo njepśeglědana.",
	'validationstatistics-revtime' => "Pśerězny cakański cas za změny wót \"wužywarjow\", kótarež njejsu pśizjawjone\", kótarež muse se hyšći pśeglědaś, jo '''\$1'''; pśerězna gódnota jo '''\$2'''.
\$3",
	'validationstatistics-table' => "Statistika pśekontrolěrowanja bokow za kuždy mjenjowy rum pokazujo se dołojce, ''mimo'' dalejpósrědnjenjow. Boki maju za ''zestarjone'', jolic maju změny, kótarež cakaju na pśeglědanje; boki maju za ''synchronizowane'', jolic změny, kótarež cakaju na pśeglědanje, njejsu.",
	'validationstatistics-ns' => 'Mjenjowy rum',
	'validationstatistics-total' => 'Boki',
	'validationstatistics-stable' => 'Pśeglědane',
	'validationstatistics-latest' => 'Synchronizěrowany',
	'validationstatistics-synced' => 'Synchronizěrowane/Pśeglědane',
	'validationstatistics-old' => 'Zestarjone',
	'validationstatistics-utable' => 'Dołojce jo lisćina {{PLURAL:$1|nejaktiwnjejšego pśeglědarja|$1 nejaktiwnjejšeju pśeglědarjowu|$1 nejaktiwnjejšych pśeglědarjow|$1 nejaktiwnjejšych pśeglědarjow}} {{PLURAL:$2|pśejźoneje góźiny|pśejźoneju $2 góźinowu|pśejźonych $2 góźinow|pśejźonych $2 góźinow}}.',
	'validationstatistics-user' => 'Wužywaŕ',
	'validationstatistics-reviews' => 'Pśeglědanja',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Dead3y3
 * @author Glavkos
 * @author Omnipaedista
 */
$messages['el'] = array(
	'validationstatistics' => 'Στατιστικά επικύρωσης',
	'validationstatistics-users' => "Ο ιστότοπος '''{{SITENAME}}''' αυτή τη στιγμή έχει '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|χρήστη|χρήστες}} με δικαιώματα [[{{MediaWiki:Validationpage}}|Συντάκτη]]
και '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|χρήστη|χρήστες}} με δικαιώματα [[{{MediaWiki:Validationpage}}|Κριτικού]].

Οι Συντάκτες και οι Κριτικοί είναι καθιερωμένοι χρήστες που μπορούν να ελέγχουν τις αναθεωρήσεις μίας σελίδας.",
	'validationstatistics-lastupdate' => "''Τα παρακάτω στοιχεία ενημερώθηκαν  τελευταία φορά στις $1 του $2 .''",
	'validationstatistics-table' => "Τα στατιστικά για κάθε περιοχή ονομάτων εμφανίζονται παρακάτω, των σελίδων ανακατεύθυνσης ''εξαιρουμένων''.",
	'validationstatistics-ns' => 'Περιοχή ονομάτων',
	'validationstatistics-total' => 'Σελίδες',
	'validationstatistics-stable' => 'Κρίθηκαν',
	'validationstatistics-latest' => 'Συγχρονισμένος',
	'validationstatistics-synced' => 'Συγχρονισμένες/Κρίθηκαν',
	'validationstatistics-old' => 'Παρωχημένες',
	'validationstatistics-utable' => 'Παρακάτω είναι μια λίστα με τα  {{PLURAL:$1|most active reviewer|$1 most active reviewers}} στις τελευταίες   {{PLURAL:$2| hour| $2 hours}}.',
	'validationstatistics-user' => 'Χρήστης',
	'validationstatistics-reviews' => 'Επιθεωρήσεις',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'validationstatistics' => 'Statistikoj pri paĝkontrolado',
	'validationstatistics-users' => "'''{{SITENAME}}''' nun havas '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|uzanton|uzantojn}} kun rajto [[{{MediaWiki:Validationpage}}|Redaktanto]].

Redaktantoj estas daŭraj uzantoj kiuj povas iufoje kontroli paĝojn.",
	'validationstatistics-lastupdate' => "''La jenaj datenoj estis laste ĝisdatigitaj je $1, $2.''",
	'validationstatistics-pndtime' => "Redaktoj kontrolitaj de establitaj uzantoj estas konsiderataj kiel ''kontrolitaj''.

La averaĝa atendo-tempo por [[Special:OldReviewedPages|paĝoj kun kontrolendaj redaktoj]] estas '''$1'''. Ĉi tiu atendo-tempo mezuras tempon ekde la plej malnova kontrolenda redakto estis farita.",
	'validationstatistics-revtime' => "La averaĝa atendo por redaktoj de ''ne-ensalutitaj uzantoj'' por esti kontrolita estas '''$1'''; la mediano estas '''$2'''.
$3",
	'validationstatistics-table' => "Jen statistikoj pri paĝkontrolado por ĉiu nomspaco, ''eksklusivante'' alidirektilojn. Paĝoj estas konsiderataj kiel ''malfreŝaj'' se ili havas kontrolendajn redaktojn. Paĝoj estas konsiderataj kiel ''ĝisdataj'' se ne estas kontrolendaj redaktoj.",
	'validationstatistics-ns' => 'Nomspaco',
	'validationstatistics-total' => 'Paĝoj',
	'validationstatistics-stable' => 'Paĝoj kun almenaŭ unu revizio',
	'validationstatistics-latest' => 'Sinkronigita',
	'validationstatistics-synced' => 'Ĝisdatigitaj/Reviziitaj',
	'validationstatistics-old' => 'Malfreŝaj',
	'validationstatistics-utable' => 'Jen listo de la plej {{PLURAL:$1|aktiva kontrolanto|aktivaj kontrolantoj}} dum la {{PLURAL:$2|lasta horo|lastaj $2 horoj}}.',
	'validationstatistics-user' => 'Uzanto',
	'validationstatistics-reviews' => 'Kontrolaĵoj',
);

/** Spanish (Español)
 * @author Bola
 * @author Crazymadlover
 * @author Dferg
 * @author Imre
 * @author Jurock
 * @author Translationista
 */
$messages['es'] = array(
	'validationstatistics' => 'Estadísticas de revisión de páginas',
	'validationstatistics-users' => "En '''{{SITENAME}}''' actualmente hay '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usuario|usuarios}} con derechos de [[{{MediaWiki:Validationpage}}|Editor]].
Los editores son usuarios establecidos que pueden verificar las revisiones de las páginas.",
	'validationstatistics-lastupdate' => "''Los siguientes datos fueron actualizados por última vez el $1 a las $2.''",
	'validationstatistics-pndtime' => "Ediciones que han sido verificadas por usuarios establecidos son consideradas ''revisadas''.

La demora promedio para [[Special:OldReviewedPages|páginas con ediciones pendientes no revisadas]] es '''$1''';
La demora mide cuanto la edición pendiente más antigua ha estado sin revisar.",
	'validationstatistics-revtime' => "La espera promedio para las ediciones  hechas por ''usuarios que no han iniciado sesión'' a ser revisadas es '''$1'''; la media es '''$2'''. $3",
	'validationstatistics-table' => "Las estadísiticas de la revisión de páginas para cada espacio de nombres están mostradas debajo, ''excluyendo'' redirecciones. Las páginas son tratadas como ''desactualizadas'' si tiene ediciones pendientes de revisión; la páginas son consideradas ''sincronizadas'' si no tiene ediciones pendientes de revisión.",
	'validationstatistics-ns' => 'Espacio de nombres',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Revisado',
	'validationstatistics-latest' => 'Sincronizado',
	'validationstatistics-synced' => 'Sincronizado/Revisado',
	'validationstatistics-old' => 'desactualizado',
	'validationstatistics-utable' => 'Debajo hay un lista de {{PLURAL:$1|el revisor más activo|los $1 revisores más activos}} en las {{PLURAL:$2|hora|$2 horas}}.',
	'validationstatistics-user' => 'Usuario',
	'validationstatistics-reviews' => 'Revisiones',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author KalmerE.
 * @author Pikne
 */
$messages['et'] = array(
	'validationstatistics' => 'Ülevaatuse arvandmestik',
	'validationstatistics-users' => "Praegu on '''{{GRAMMAR:inessive|{{SITENAME}}}}''' '''[[Special:ListUsers/editor|$1]]''' [[{{MediaWiki:Validationpage}}|toimetaja]] õigustes {{PLURAL:$1|kasutaja|kasutajat}}.

Toimetajad on kohale määratud kasutajad, kes saavad lehekülgel tehtud muudatused põgusalt üle vaadata.",
	'validationstatistics-lastupdate' => "''Järgnevate andmete viimane uuendamisaeg: $1, kell $2.''",
	'validationstatistics-pndtime' => "Kohale määratud kasutajate tehtud muudatused arvatakse ''ülevaadatuks''.

Keskmine viitaeg [[Special:OldReviewedPages|ootel muudatustega lehekülgede ülevaatamiseks]] on '''$1'''; viiteaeg näitab kui kaua on vanim ootel muudatus ülevaatamata olnud.",
	'validationstatistics-revtime' => "''Sisselogimata kasutajate'' tehtud muudatuste ooteaeg ülevaatamiseks on keskmiselt '''$1'''; mediaan on '''$2'''.
$3",
	'validationstatistics-table' => "Allpool on toodud lehekülgede ülevaatamisarvandmed nimeruumiti, ''välja arvatud'' ümbersuunamisleheküljed. Lehekülg arvatakse ''iganenuks'', kui mõni sealne muudatus ootab ülevaatamist; lehekülg arvatakse ''ühtivaks'', kui ükski muudatus ei oota ülevaatamist.",
	'validationstatistics-ns' => 'Nimeruum',
	'validationstatistics-total' => 'Lehekülgi',
	'validationstatistics-stable' => 'Ülevaadatud',
	'validationstatistics-latest' => 'Ühtiv',
	'validationstatistics-synced' => 'Ühtiv või ülevaadatud',
	'validationstatistics-old' => 'Iganenud',
	'validationstatistics-utable' => 'Allpool on toodud viimase {{PLURAL:$2|tunni|$2 tunni}} {{PLURAL:$1|aktiivseim ülevaataja|$1 aktiivsemat ülevaatajat}}.',
	'validationstatistics-user' => 'Kasutaja',
	'validationstatistics-reviews' => 'Ülevaatamisi',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'validationstatistics' => 'Orrialde berrikuspen estatistikak',
	'validationstatistics-ns' => 'Izen-tartea',
	'validationstatistics-total' => 'Orrialdeak',
	'validationstatistics-old' => 'Deseguneratua',
	'validationstatistics-user' => 'Erabiltzailea',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Mjbmr
 * @author Sahim
 * @author Wayiran
 */
$messages['fa'] = array(
	'validationstatistics' => 'آمار بازبینی صفحه',
	'validationstatistics-users' => "'''{{SITENAME}}''' در حال حاضر '''[[Special:ListUsers/editor|$1]]''' کاربر با اختیارات [[{{MediaWiki:Validationpage}}|ویرایشگر]] دارد.

ویرایش‌گران کاربران محرزی هستند که می‌توانند نسخه‌های صفحات را بررسی سرسری کنند.",
	'validationstatistics-lastupdate' => "''داده‌های زیر آخرین بار در تاریخ $1 در $2 به‌روزرسانی شده است.''",
	'validationstatistics-pndtime' => "ویرایش‌هایی که توسط کاربران محرز بررسی شده‌اند برای بازبینی در نظر گرفته شده‌اند.

میانگین تأخیر برای [[Special:OldReviewedPages|صفحات با ویرایش‌های بازبینی‌نشدهٔ در حال انتظار]] '''$1''' است؛ این تاخیر نشان‌دهنده مدت زمانی است که قدیمی‌ترین نسخه بررسی نشده در انتظار بررسی باقی مانده است.",
	'validationstatistics-revtime' => "میانگین انتظار برای بازبینی ویرایش‌های ''کاربرانی که وارد نشده‌اند''، '''$1''' است؛ میانهٔ آن '''$2''' است.
$3",
	'validationstatistics-table' => "آمار بازبینی صفحه برای هر فضای‌نام که در زیر نشان داده‌شده، به ''استثنای'' صفحه‌های تغییر مسیر است. صفحه‌های که ویرایش‌های بررسی نشده داشته باشند ''تاریخ گذشته'' محسوب می‌شوند؛ صفحه‌هایی که ویرایش بررسی نشده نداشته باشند ''همزمان‌شده'' تلفی می‌شوند.",
	'validationstatistics-ns' => 'فضای نام',
	'validationstatistics-total' => 'صفحه‌ها',
	'validationstatistics-stable' => 'بازبینی شده',
	'validationstatistics-latest' => 'آخرین بازبینی',
	'validationstatistics-synced' => 'به روز شده/بازبینی شده',
	'validationstatistics-old' => 'تاریخ گذشته',
	'validationstatistics-utable' => 'در زیر فهرست {{PLURAL:$1|فعال‌ترین بازبین|$1 تا از فعال‌ترین بازبینان}} در آخرین {{PLURAL:$2|ساعت|$2 ساعات}} آمده است.',
	'validationstatistics-user' => 'کاربر',
	'validationstatistics-reviews' => 'بازبینی‌ها',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Mies
 * @author Nedergard
 * @author Olli
 * @author Pxos
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 * @author ZeiP
 */
$messages['fi'] = array(
	'validationstatistics' => 'Sivujen arviointitilastot',
	'validationstatistics-users' => "Sivustolla '''{{SITENAME}}''' on tällä hetkellä '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|käyttäjä, jolla|käyttäjää, joilla}} on [[{{MediaWiki:Validationpage}}|seulojan]] oikeudet.

Seulojat ovat luotettavia käyttäjiä, jotka voivat arvioida sivuille tehtyjä muutoksia ja merkitä ne hyväksytyiksi.",
	'validationstatistics-lastupdate' => "''Seuraavat tiedot päivitettiin viimeksi $1 kello $2.''",
	'validationstatistics-pndtime' => "Oikeutettujen käyttäjien (seulojien) katsomat muokkaukset ovat ''arvioituja''.

Keskimääräinen arviointiaika [[Special:OldReviewedPages|sivuilla, joilla on odottavia muutoksia]] on '''$1'''. Tämä viive kertoo sen, kuinka kauan sarjassa vanhin arviointia odottava muutos odottaa edelleen arviointia.",
	'validationstatistics-revtime' => "Keskimääräinen odotusaika ''sisäänkirjautumattomien käyttäjien'' muokkausten arviointiin on '''$1'''; mediaani on '''$2'''.
$3",
	'validationstatistics-table' => "Alla on kaikkien nimiavaruuksien arvioinnin tilastot ''lukuun ottamatta'' ohjaussivuja. Sivuja kohdellaan ''vanhentuneina'', jos niissä on arviointia odottavia muokkauksia, ja ne ovat ''synkronoituja'', mikäli niissä ei ole arviointia odottavia muokkauksia.",
	'validationstatistics-ns' => 'Nimiavaruus',
	'validationstatistics-total' => 'Sivuja yhteensä',
	'validationstatistics-stable' => 'Arvioitu',
	'validationstatistics-latest' => 'Synkronoitu',
	'validationstatistics-synced' => 'Synkronoitu/arvioitu',
	'validationstatistics-old' => 'Vanhentunut',
	'validationstatistics-utable' => 'Alla on lueteltu {{PLURAL:$1|aktiivisin arvioija|$1 aktiivisinta arvioijaa}} edellisen {{PLURAL:$2|tunnin|$2 tunnin}} ajalta.',
	'validationstatistics-user' => 'Käyttäjä',
	'validationstatistics-reviews' => 'Arviointeja',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Peter17
 * @author PieRRoMaN
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'validationstatistics' => 'Statistiques de relecture des pages',
	'validationstatistics-users' => "'''{{SITENAME}}''' dispose actuellement de '''[[Special:ListUsers/editor|$1]]''' utilisateur{{PLURAL:$1||s}} avec les droits de [[{{MediaWiki:Validationpage}}|contributeur]].

Les contributeurs et relecteurs sont des utilisateurs établis qui peuvent vérifier les révisions des pages.",
	'validationstatistics-lastupdate' => "''Les données suivantes ont été mises à jour le $1 sur $2.''",
	'validationstatistics-pndtime' => "Les modifications vérifiées par les utilisateurs confirmés sont considérées comme ''relues''.

Le retard de relecture moyen des [[Special:OldReviewedPages|pages contenant des modifications à relire]] est '''$1''', le retard mesure combien de temps les modifications les plus anciennes en attente sont restées non relues.",
	'validationstatistics-revtime' => "Le délai d’attente moyen pour la relecture des modifications faites par les ''utilisateurs non enregistrés'' est '''$1''' ; la médiane est '''$2'''.
$3",
	'validationstatistics-table' => "Les statistiques de relecture pour chaque espace de noms sont affichées ci-dessous, ''à l’exception'' des pages de redirection. Les pages sont traitées comme ''périmées'' si elles ont des modifications en attente et comme ''synchronisées'' si elle n'ont pas de modifications en attente.",
	'validationstatistics-ns' => 'Espace de noms',
	'validationstatistics-total' => 'Pages',
	'validationstatistics-stable' => 'Révisée',
	'validationstatistics-latest' => 'Synchronisée',
	'validationstatistics-synced' => 'Synchronisée/Révisée',
	'validationstatistics-old' => 'Périmée',
	'validationstatistics-utable' => 'Ci-dessous figure {{PLURAL:$1|le relecteur le plus actif|les $1 relecteurs les plus actifs}} dans {{PLURAL:$2|la dernière heure|les $2 dernières heures}}.',
	'validationstatistics-user' => 'Utilisateur',
	'validationstatistics-reviews' => 'Relecteurs',
);

/** Cajun French (Français cadien)
 * @author Ebe123
 */
$messages['frc'] = array(
	'validationstatistics-user' => 'Useur',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'validationstatistics' => 'Statistiques de rèvision de les pâges',
	'validationstatistics-users' => "'''{{SITENAME}}''' at ora '''[[Special:ListUsers/editor|$1]]''' usanciér{{PLURAL:$1||s}} avouéc los drêts de [[{{MediaWiki:Validationpage}}|contributor]].

Los contributors sont des usanciérs ètablis que pôvont controlar les vèrsions de les pâges.",
	'validationstatistics-lastupdate' => "''Cetes balyês ont étâ betâs a jorn lo $1 a $2.''",
	'validationstatistics-pndtime' => "Los changements controlâs per los utilisators confirmâs sont considèrâs coment ''revus''.

Lo retârd de rèvision moyen de les [[Special:OldReviewedPages|pâges que contegnont des changements en atenta de rèvision]] est '''$1''' ; lo retârd mesere comben de temps los changements los ples vielys en atenta sont réstâs pas revus.",
	'validationstatistics-revtime' => "Lo dèlê d’atenta moyen por la rèvision des changements fêts per los ''utilisators pas encartâs'' est '''$1''' ; la moyena est'''$2'''. 
$3",
	'validationstatistics-table' => "Les statistiques de rèvision de les pâges por châque èspâço de noms sont montrâs ce-desot, ''mas pas'' de les pâges de redirèccion. Les pâges sont trètâs coment ''dèpassâs'' s’els ont des changements en atenta de rèvision et coment ''sincronisâs'' s’els ont gins de changement en atenta de rèvision.",
	'validationstatistics-ns' => 'Èspâço de noms',
	'validationstatistics-total' => 'Pâges',
	'validationstatistics-stable' => 'Revua',
	'validationstatistics-latest' => 'Sincronisâ',
	'validationstatistics-synced' => 'Sincronisâ / Revua',
	'validationstatistics-old' => 'Dèpassâ',
	'validationstatistics-utable' => 'Vê-que la lista {{PLURAL:$1|du rèvisor lo ples actif|des $1 rèvisors los ples actifs}} dens {{PLURAL:$2|l’hora passâ|les $2 hores passâs}}.',
	'validationstatistics-user' => 'Usanciér',
	'validationstatistics-reviews' => 'Rèvisions',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'validationstatistics-ns' => 'Ainmspás',
	'validationstatistics-total' => 'Leathanaigh',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'validationstatistics' => 'Estatísticas de revisión das páxinas',
	'validationstatistics-users' => "Actualmente, '''{{SITENAME}}''' ten '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usuario|usuarios}} con
dereitos de [[{{MediaWiki:Validationpage}}|editor]].

Os editores son usuarios autoconfirmados que poden comprobar revisións de páxinas.",
	'validationstatistics-lastupdate' => "''Os seguintes datos actualizáronse o $1 ás $2.''",
	'validationstatistics-pndtime' => "As edicións que foron comprobadas por usuarios autoconfirmados considéranse ''revisadas''.

A media de atraso para as [[Special:OldReviewedPages|páxinas con edicións sen revisión]] é de '''$1'''; isto mide o tempo que as edicións pendentes levan á espera dunha revisión.",
	'validationstatistics-revtime' => "A media de espera de revisión para as edicións feitas polos ''usuarios que non accederon ao sistema'' é de '''$1'''; o valor medio é de '''$2'''.
$3",
	'validationstatistics-table' => "A continuación móstranse as estatísticas das revisións das páxinas para cada espazo de nomes, ''excluíndo'' as páxinas de redirección. As páxinas considéranse ''obsoletas'' se teñen edicións á espera dunha revisión; as páxinas atópanse ''sincronizadas'' se non hai edicións agardando por unha revisión.",
	'validationstatistics-ns' => 'Espazo de nomes',
	'validationstatistics-total' => 'Páxinas',
	'validationstatistics-stable' => 'Revisado',
	'validationstatistics-latest' => 'Sincronizado',
	'validationstatistics-synced' => 'Sincronizado/Revisado',
	'validationstatistics-old' => 'Obsoleto',
	'validationstatistics-utable' => 'A continuación está {{PLURAL:$1|o revisor máis activo|a lista cos $1 revisores máis activos}} {{PLURAL:$2|na última hora|nas últimas $2 horas}}.',
	'validationstatistics-user' => 'Usuario',
	'validationstatistics-reviews' => 'Revisións',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'validationstatistics' => 'Στατιστικὰ ἐπικυρώσεων',
	'validationstatistics-users' => "Τὸ '''{{SITENAME}}''' νῦν ἔχει '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|χρὠμενον|χρωμένους}} μετὰ δικαιωμάτων [[{{MediaWiki:Validationpage}}|μεταγραφέως]] 
καὶ '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|χρὠμενον|χρωμένους}} μετὰ δικαιωμάτων [[{{MediaWiki:Validationpage}}|ἐπιθεωρητοῦ]].

Μεταγραφεῖς καὶ ἐπιθεωρηταὶ καθιερωμένοι χρώμενοι εἰσὶν δυνάμενοι τὰς τῶν δέλτων ἀναθεωρήσεις ἐλέγχειν.",
	'validationstatistics-table' => "Στατιστικὰ δεδομένα διὰ πᾶν ὀνοματεῖον κάτωθι εἰσί, δέλτων ἀναδιευθύνσεως ''ἐξαιρουμένων''.",
	'validationstatistics-ns' => 'Ὀνοματεῖον',
	'validationstatistics-total' => 'Δέλτοι',
	'validationstatistics-stable' => 'Ἀνατεθεωρημένη',
	'validationstatistics-latest' => 'Συγκεχρονισμένη',
	'validationstatistics-synced' => 'Συγκεχρονισμένη/Ἐπιτεθεωρημένη',
	'validationstatistics-old' => 'Ἀπηρχαιωμένη',
	'validationstatistics-utable' => 'Κάτωθι ἐστὶ ὁ κατάλογος τῶν $1 κορυφαίων ἐπιθεωρητῶν τῇ ὑστάτη μίᾳ ὥρᾳ.',
	'validationstatistics-user' => 'Χρώμενος',
	'validationstatistics-reviews' => 'Ἐπιθεωρήσεις',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'validationstatistics' => 'Statischtik vu dr Sytepriefige',
	'validationstatistics-users' => "'''{{SITENAME}}''' het '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Sichterrächt]].

Sichter un Priefer sin Benutzer, wu Syte as prieft chenne markiere.",
	'validationstatistics-lastupdate' => "''Die Date sin s letscht Mol am $1 am $2 aktualisiert wore.''",
	'validationstatistics-pndtime' => 'Bearbeitige, wu vu etablierte Benutzer gmacht wore sin, wäre as iberprieft aagnuu.',
	'validationstatistics-revtime' => "Di durschnittli Wartezyt, bis Bearbeitige vu ''nit aagmäldete Benutzer'' iberprieft sin, lyt bi '''$1'''; dr Mittelwärt isch '''$2'''. 
$3",
	'validationstatistics-table' => 'D Versionsmarkierigsstatischtike vu allne Syte uuser dr Wyterleitige wäre do unte fir jede Namensruum zeigt. Syte wäre as veraltet aagsäh, wänn s uumarkierti Ädnerige din het. Alli andere Syte wäre as markiert un dodermit as aktuäll aagsäh.',
	'validationstatistics-ns' => 'Namensruum',
	'validationstatistics-total' => 'Syte insgsamt',
	'validationstatistics-stable' => 'Zmindescht ei Version isch vum Fäldhieter gsäh.',
	'validationstatistics-latest' => 'Zytglychi',
	'validationstatistics-synced' => 'Prozäntsatz vu dr Syte, wu vum Fäldhieter gsäh sin.',
	'validationstatistics-old' => 'Syte mit Versione, wu nit vum Fäldhieter gsäh sin.',
	'validationstatistics-utable' => 'Unte findsch e Lischt mit {{PLURAL:$1|em aktivschte Sichter|dr $1 aktivschte Sichter}} in dr letschten {{PLURAL:$2|Stund |$2 Stund}}.',
	'validationstatistics-user' => 'Benutzer',
	'validationstatistics-reviews' => 'Priefige',
);

/** Gujarati (ગુજરાતી)
 * @author Dineshjk
 */
$messages['gu'] = array(
	'validationstatistics-total' => 'પાનાં',
	'validationstatistics-stable' => 'પરામર્શિત',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'validationstatistics-ns' => 'Sararin suna',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Amire80
 * @author DoviJ
 * @author Erel Segal
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'validationstatistics' => 'סטטיסטיקות של סקירת דפים',
	'validationstatistics-users' => "באתר '''{{SITENAME}}''' יש כעת {{PLURAL:$1|משתמש '''[[Special:ListUsers/editor|אחד]]'''|'''[[Special:ListUsers/editor|$1]]''' משתמשים}} עם הרשאת [[{{MediaWiki:Validationpage}}|עורך]].

עורכים הם משתמשים ותיקים שיכולים לבצע בדיקה מהירה של גרסאות של דפים.",
	'validationstatistics-lastupdate' => "''הנתונים הבאים עודכנו לאחרונה ב־$1 בשעה $2.''",
	'validationstatistics-pndtime' => "עריכות שנבדקו על־ידי משתמשים מוּכָּרִים מוגדרות כעריכות ש'''נסקרו'''.

עיכוב ממוצע ל[[Special:OldReviewedPages|דפים עם עריכות שממתינות לסקירה]] הוא '''$1'''; העיכוב מודד כמה זמן העריכה הממתינה הישנה ביותר נשארה בלי סקירה.",
	'validationstatistics-revtime' => "זמן ההמתנה הממוצע לסקירת עריכות של '''משתמשים אלמוניים''' הוא '''$1'''; החציון הוא '''$2'''.
$3",
	'validationstatistics-table' => "דפים מוגדרים כ'''לא עדכניים''' אם יש בהם עריכות שממתינות לסקירה; דפים מוגדרים כ'''מסונכרנים''' אם אין בהם עריכות שממתינות לסקירה.",
	'validationstatistics-ns' => 'מרחב שם',
	'validationstatistics-total' => 'דפים',
	'validationstatistics-stable' => 'נסקרו',
	'validationstatistics-latest' => 'סונכרנו',
	'validationstatistics-synced' => 'סונכרנו/נסקרו',
	'validationstatistics-old' => 'לא עדכניים',
	'validationstatistics-utable' => '{{PLURAL:$1|הסוקר הפעיל|רשימת $1 הסוקרים הפעילים}} ביותר ב{{PLURAL:$2|שעה האחרונה|־$2 השעות האחרונות}}.',
	'validationstatistics-user' => 'משתמש',
	'validationstatistics-reviews' => 'סקירות',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'validationstatistics' => 'पृष्ठ समिक्षा आकलन',
	'validationstatistics-ns' => 'नामस्थान',
	'validationstatistics-total' => 'पृष्ठों',
	'validationstatistics-stable' => 'समीक्षा',
	'validationstatistics-old' => 'पुराना',
	'validationstatistics-user' => 'सदस्य',
	'validationstatistics-reviews' => 'समीक्षा',
);

/** Hiligaynon (Ilonggo)
 * @author Tagimata
 */
$messages['hil'] = array(
	'validationstatistics-total' => 'Mga Pahina',
	'validationstatistics-user' => 'Naga-Usar',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 * @author Herr Mlinka
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'validationstatistics' => 'Statistike pregledavanja stranice',
	'validationstatistics-users' => "{{SITENAME}}''' trenutačno ima '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|suradnika|suradnika}} s [[{{MediaWiki:Validationpage}}|uredničkim]] pravima.

Urednici su dokazani suradnici koji mogu provjeriti inačice stranice.",
	'validationstatistics-lastupdate' => "''Sljedeći podaci su posljednji put osvježeni $1 u $2.''",
	'validationstatistics-pndtime' => "Izmjene koje su pregledali potvrđeni suradnici smatraju se ''pregledanima''.

Prosječno čekanje za pregled [[Special:OldReviewedPages|stranica s nepregledanim izmjenama]] je '''$1'''. Navedeno čekanje označava koliko je dugo najstarija izmjena koja čeka pregled ostala nepregledanom.",
	'validationstatistics-revtime' => "Prosječno čekanje izmjena od strane ''suradnika koji nisu prijavljeni'' za pregled je '''$1'''; medijan je '''$2'''. 
$3",
	'validationstatistics-table' => "Statistike pregledavanja za svaki imenski prostor prikazane su u nastavku, ''ne uključujući'' stranice za preusmjeravanje. Stranice se smatraju ''neažurnim'' ako imaju izmjene koje čekaju pregled, odnosno ''sinkroniziranima'' ako nema izmjena koje čekaju pregled.",
	'validationstatistics-ns' => 'Imenski prostor',
	'validationstatistics-total' => 'Stranice',
	'validationstatistics-stable' => 'Ocijenjeno',
	'validationstatistics-latest' => 'Sinkronizirano',
	'validationstatistics-synced' => 'Usklađeno/Ocijenjeno',
	'validationstatistics-old' => 'Zastarjelo',
	'validationstatistics-utable' => 'Ispod je popis {{PLURAL:$1|najaktivnijeg|$1 najaktivnija|$1 najaktivnijih}} ocjenjivača u zadnjih {{PLURAL:$2|sat vremena|$2 sata|$2 sati}}.',
	'validationstatistics-user' => 'Suradnik',
	'validationstatistics-reviews' => 'Ocjene',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'validationstatistics' => 'Statistika přepruwowanja stronow',
	'validationstatistics-users' => "'''{{SITENAME}}''' ma tuchwilu '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|wužiwarja|wužiwarjow|wužiwarjow|wužiwarjow}} z [[{{MediaWiki:Validationpage}}|wobdźěłowarskimi prawami]].

Wobdźěłowarjo su nazhonići wužiwarjo, kotřiž móžeja wersije stronow kontrolować.",
	'validationstatistics-lastupdate' => "''Slědowace daty buchu $1 $2 posledni raz zaktualizowane.''",
	'validationstatistics-pndtime' => "Změny, kotrež buchu wot nazhonitych wužiwarjow skontrolowane, měli so ''přepruwować''.

Přerězny komdźenje za [[Special:OldReviewedPages|strony z njepřepruwowane změny]] je '''$1'''; komdźenje měri, kak dołho najstarša njekontrolowana změna wosta njepřepruwowana.",
	'validationstatistics-revtime' => "Přerězny čakanski čas za změny wot ''wužiwarjow, kotřiž njejsu přizjewjeni'' za přepruwowanje je '''\$1\"\"; přerězna hódnota je '''\$2'''.
\$3",
	'validationstatistics-table' => "Statistika přepruwowanja stronow za kóždy mjenowy rum so deleka pokazuje, ''nimo'' daleposrědkowanjow. Strony maja za ''zestarjene'', jeli maja změny, kotrež na přepruwowanje čakaja; strony maja za ''synchronizowane'', jeli změny, kotrež na přepruwowanje čakaja, njejsu.",
	'validationstatistics-ns' => 'Mjenowy rum',
	'validationstatistics-total' => 'Strony',
	'validationstatistics-stable' => 'Skontrolowane',
	'validationstatistics-latest' => 'Synchronizowany',
	'validationstatistics-synced' => 'Synchronizowane/Skontrolowane',
	'validationstatistics-old' => 'Zestarjene',
	'validationstatistics-utable' => 'Deleka je lisćina {{PLURAL:$1|najaktiwnišeho přepruwowarja|$1 najaktiwnišeju přepruwowarjow|$1 najaktiwnišich přepruwowarjow|$1 najaktiwnišich přepruwowarjow}} w {{PLURAL:$2|zańdźenej hodźinje|zańdźenymaj $2 hodźinomaj|zańdźenych $2 hodźinach|zańdźenych $2 hodźinach}}.',
	'validationstatistics-user' => 'Wužiwar',
	'validationstatistics-reviews' => 'Přepruwowanja',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author BáthoryPéter
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Hunyadym
 * @author Misibacsi
 * @author Samat
 */
$messages['hu'] = array(
	'validationstatistics' => 'Ellenőrzési statisztika',
	'validationstatistics-users' => "A(z) '''{{SITENAME}}''' wikinek jelenleg '''[[Special:ListUsers/editor|$1]]''' [[{{MediaWiki:Validationpage}}|járőrjoggal]]  rendelkező szerkesztője van.

A járőrök olyan tapasztalt szerkesztők, akik ellenőrizhetik a lapok változatait.",
	'validationstatistics-lastupdate' => "''Az alábbi adatokat legutóbb $1 $2-kor frissítették.''",
	'validationstatistics-pndtime' => "Azok a szerkesztések, amiket megerősített szerkesztők végeznek, ellenőrzöttnek minősülnek.

[[Special:OldReviewedPages|A nem ellenőrzött szerkesztésekkel rendelkező lapok]] átlagos várakozási ideje '''$1'''. A várakozási idő az ellenőrzésre váró legrégebbi módosítás óta értendő.",
	'validationstatistics-revtime' => "A ''nem bejelentkezett szerkesztőknek'' '''$1''' az átlagos várakozási idő az ellenőrzésig; a medián '''$2'''.
$3",
	'validationstatistics-table' => "Ezen az oldalon a névterekre bontott ellenőrzési statisztika látható, az átirányítások ''nélkül''. Egy oldal ''elavult'' lesz, ha ellenőrzésre váró módosítás történt rajta. ''Szinkronban van'', ha nincs ellenőrzésre váró módosítás.",
	'validationstatistics-ns' => 'Névtér',
	'validationstatistics-total' => 'Lapok',
	'validationstatistics-stable' => 'Ellenőrizve',
	'validationstatistics-latest' => 'Szinkronizálva',
	'validationstatistics-synced' => 'Szinkronizálva/ellenőrizve',
	'validationstatistics-old' => 'Elavult',
	'validationstatistics-utable' => 'A lista a(z) {{PLURAL:$1|legaktívabb járőrt|$1 legaktívabb járőrt}} mutatja az elmúlt {{PLURAL:$2|órában|$2 órában}}.',
	'validationstatistics-user' => 'Felhasználó',
	'validationstatistics-reviews' => 'Ellenőrzések',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'validationstatistics' => 'Statisticas de revision de paginas',
	'validationstatistics-users' => "'''{{SITENAME}}''' ha al momento '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usator|usatores}} con privilegios de [[{{MediaWiki:Validationpage}}|Redactor]].

Le Redactores es usatores establite qui pote selectivemente verificar versiones de paginas.",
	'validationstatistics-lastupdate' => "''Le sequente datos ha essite actualisate le $1 a $2.''",
	'validationstatistics-pndtime' => "Le modificationes que ha essite verificate per usatores stabilite es considerate como ''revidite''.

Le retardo medie de revision pro [[Special:OldReviewedPages|paginas con modificationes attendente revision]] es '''$1'''; iste retardo mesura le tempore durante que le modification pendente le plus vetule ha attendite revision.",
	'validationstatistics-revtime' => "Le retardo medie de revision pro modificationes per ''usatores que non ha aperite un session'' es '''$1'''; le mediana es '''$2'''.
$3",
	'validationstatistics-table' => "Le statisticas de revision de paginas pro cata spatio de nomines es monstrate hic infra, ''excludente'' le paginas de redirection. Paginas es tractate como ''obsolete'' si illos ha modificationes attendente revision; paginas es considerate ''synchronisate'' si il non ha modificationes attendente revision.",
	'validationstatistics-ns' => 'Spatio de nomines',
	'validationstatistics-total' => 'Paginas',
	'validationstatistics-stable' => 'Revidite',
	'validationstatistics-latest' => 'Synchronisate',
	'validationstatistics-synced' => 'Synchronisate/Revidite',
	'validationstatistics-old' => 'Obsolete',
	'validationstatistics-utable' => 'Infra es le {{PLURAL:$1|revisor|lista del $1 revisores}} le plus active del ultime {{PLURAL:$2|hora|$2 horas}}.',
	'validationstatistics-user' => 'Usator',
	'validationstatistics-reviews' => 'Revisiones',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Kenrick95
 * @author Rex
 */
$messages['id'] = array(
	'validationstatistics' => 'Statistik tinjauan halaman',
	'validationstatistics-users' => "'''{{SITENAME}}''' saat ini memiliki '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|pengguna|pengguna}} dengan hak akses [[{{MediaWiki:Validationpage}}|Penyunting]].

Penyunting adalah para pengguna tetap yang dapat melakukan pemeriksaan perbaikan di setiap halaman.",
	'validationstatistics-lastupdate' => "''Data berikut terakhir dimutakhirkan pada tanggal $1 pukul $2.''",
	'validationstatistics-pndtime' => "Suntingan yang telah diperiksa oleh pengguna mapan dianggap ''tertinjau''.

Lama penundaan tinjauan rata-rata untuk [[Special:OldReviewedPages|halaman dengan penundaan tinjauan suntingan]] adalah '''$1'''; penundaan menunjukkan lama waktu suntingan tunda terlama belum ditinjau.",
	'validationstatistics-revtime' => "Lama waktu rata-rata untuk suntingan oleh ''pengguna yang tidak masuk log'' agar ditinjau adalah '''$1'''; mediannya adalah '''$2'''.
$3",
	'validationstatistics-table' => "Statistik tinjauan halaman untuk setiap ruang nama ditampilkan di bawah ini, ''kecuali'' halaman pengalihan. Halaman dianggap ''kedaluwarsa'' jika memiliki tinjauan suntingan tertunda; halaman dianggap ''sinkron'' jika tidak memiliki tinjauan suntingan tertunda.",
	'validationstatistics-ns' => 'Ruang nama',
	'validationstatistics-total' => 'Halaman',
	'validationstatistics-stable' => 'Telah ditinjau',
	'validationstatistics-latest' => 'Tersinkron',
	'validationstatistics-synced' => 'Sinkron/Tertinjau',
	'validationstatistics-old' => 'Usang',
	'validationstatistics-utable' => 'Berikut adalah daftar {{PLURAL:$1|peninjau|peninjau}} teraktif selama {{PLURAL:$2|satu jam|$2 jam}} terakhir.',
	'validationstatistics-user' => 'Pengguna',
	'validationstatistics-reviews' => 'Tinjauan',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'validationstatistics' => 'Nlé màkà orüba ihü',
	'validationstatistics-ns' => 'Ámááhà',
	'validationstatistics-total' => 'Ihü',
	'validationstatistics-stable' => 'Hé léfùrù ya',
	'validationstatistics-user' => "Ọ'bànifé",
	'validationstatistics-reviews' => 'Nléfù',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'validationstatistics-ns' => 'Nomaro',
	'validationstatistics-total' => 'Pagini',
	'validationstatistics-user' => 'Uzanto',
);

/** Icelandic (Íslenska)
 * @author Spacebirdy
 */
$messages['is'] = array(
	'validationstatistics-ns' => 'Nafnrými',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Blaisorblade
 * @author Darth Kule
 * @author Gianfranco
 * @author Melos
 * @author OrbiliusMagister
 * @author Pietrodn
 */
$messages['it'] = array(
	'validationstatistics' => 'Statistiche di revisione',
	'validationstatistics-users' => "{{SITENAME}}''' ha attualmente '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utente|utenti}} con diritti di [[{{MediaWiki:Validationpage}}|Editore]] e '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|utente|utenti}} con diritti di [[{{MediaWiki:Validationpage}}|Revisore]].

Gli editori sono utenti stabili che possono convalidare le revisioni nelle pagine",
	'validationstatistics-table' => "Le statistiche di revisione per ciascun namespace sono mostrate di seguito, ''a esclusione'' delle pagine di redirect.",
	'validationstatistics-ns' => 'Namespace',
	'validationstatistics-total' => 'Pagine',
	'validationstatistics-stable' => 'Revisionate',
	'validationstatistics-latest' => 'Sincronizzate',
	'validationstatistics-synced' => 'Sincronizzate/Revisionate',
	'validationstatistics-old' => 'Non aggiornate',
	'validationstatistics-utable' => "Di seguito è riportato l'elenco dei primi $1 revisori nell'ultima ora.",
	'validationstatistics-user' => 'Utente',
	'validationstatistics-reviews' => 'Revisioni',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Ohgi
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'validationstatistics' => 'ページのレビュー統計',
	'validationstatistics-users' => "'''{{SITENAME}}''' には現在、[[{{MediaWiki:Validationpage}}|編集者]]権限をもつ利用者が '''[[Special:ListUsers/editor|$1]]'''{{PLURAL:$1|人}}います。

編集者とはページの各版に対して抜き取り検査を行うことを認められた利用者です。",
	'validationstatistics-lastupdate' => "''以下のデータは、$1の$2に最後に更新されました。''",
	'validationstatistics-pndtime' => "信頼されている利用者により確認された編集は、''査読済''とみなされます。

[[Special:OldReviewedPages|未査読の編集が保留となっているページ]]の平均遅延時間は'''$1'''です。この遅延時間は、保留中の最古の編集が査読待ちの状態を脱するのにかかった時間から測定されます。",
	'validationstatistics-revtime' => "''非ログイン利用者''による編集が査読されるまでの平均待ち時間は'''$1'''で、中央値は'''$2'''です。
$3",
	'validationstatistics-table' => "名前空間別のページの査読に関する統計を以下に表示します（リダイレクトページは''除外''）。ページに査読待ちの編集がある場合は、''最新版未査読''として扱われます。査読待ちの編集がない場合は、''最新版査読済''とみなされます。",
	'validationstatistics-ns' => '名前空間',
	'validationstatistics-total' => 'ページ数',
	'validationstatistics-stable' => '査読済',
	'validationstatistics-latest' => '最新版査読済',
	'validationstatistics-synced' => '最新版査読済/全査読済',
	'validationstatistics-old' => '最新版未査読',
	'validationstatistics-utable' => '以下は、最近$2{{PLURAL:$2|}}時間において最も活動的な査読者$1人{{PLURAL:$1|}}の一覧です。',
	'validationstatistics-user' => '利用者',
	'validationstatistics-reviews' => '査読回数',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'validationstatistics' => 'Statistik validasi',
	'validationstatistics-users' => "'''{{SITENAME}}''' wektu iki duwé '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|panganggo|panganggo}} kanthi hak aksès [[{{MediaWiki:Validationpage}}|Editor]] lan '''[[Special:ListUsers/pamriksa|$2]]''' {{PLURAL:$2|panganggo|panganggo}} kanthi hak aksès [[{{MediaWiki:Validationpage}}|Pamriksa]].

Editor lan Pamriksa iku panganggo mapan sing bisa mriksa langsung owah-owahan kaca.",
	'validationstatistics-table' => "Statistik kanggo saben bilik jeneng ditampilaké ing ngisor iki, ''kajaba'' kaca pangalihan.",
	'validationstatistics-ns' => 'Bilik jeneng',
	'validationstatistics-total' => 'Kaca',
	'validationstatistics-stable' => 'Wis dipriksa',
	'validationstatistics-latest' => 'Wis disinkronaké',
	'validationstatistics-synced' => 'Wis disinkronaké/Wis dipriksa',
	'validationstatistics-old' => 'Lawas',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author ITshnik
 * @author Nodar Kherkheulidze
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'validationstatistics' => 'გვერდების შემოწმების სტატისტიკა',
	'validationstatistics-users' => "პროექტ {{SITENAME}}ში ამ მომენტისთვის '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|მომხმარებელი|მომხმარებელს}} აქვს [[{{MediaWiki:Validationpage}}|„შემმოწმებლის“]] სტატუსი.


„შემმოწმებლები“ არიან მომხმარებლები, რომლებსაც შეუძლიათ სტატიის კონკრეტული ვერსიების შემოწმება.",
	'validationstatistics-table' => " ქვემოთ ნაჩვენებია სტატისტიკა თითოეული სახელთა სივრცისათვის, ''გარდა'' გადამისამართების გვერდებისა.",
	'validationstatistics-ns' => 'სახელთა სივრცე',
	'validationstatistics-total' => 'გვერდები',
	'validationstatistics-stable' => 'შემოწმებული',
	'validationstatistics-latest' => 'გადამოწმებული',
	'validationstatistics-synced' => 'გადამოწმებულებისა და შემოწმებულების რაოდენობა',
	'validationstatistics-old' => 'მოძველებული',
	'validationstatistics-utable' => 'ქვემოთ მოყვანილია ბოლო საათის განმავლობაში ტოპ $1 გადამმოწმებლის  ჩამონათვალი.',
	'validationstatistics-user' => 'მომხმარებელი',
	'validationstatistics-reviews' => 'გადამოწმებები',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'validationstatistics-ns' => 'លំហឈ្មោះ',
	'validationstatistics-total' => 'ទំព័រ',
	'validationstatistics-old' => 'ហួសសម័យ',
	'validationstatistics-user' => 'អ្នកប្រើប្រាស់​',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'validationstatistics-total' => 'ಪುಟಗಳು',
);

/** Korean (한국어)
 * @author Devunt
 * @author Gapo
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'validationstatistics' => '페이지의 검토 통계',
	'validationstatistics-users' => "'''{{SITENAME}}'''에는 [[Special:ListUsers/editor|$1]]명의 [[{{MediaWiki:Validationpage}}|편집자]] 권한을 가진 사용자가 있습니다.

편집자가 문서를 검토할 수 있습니다.",
	'validationstatistics-lastupdate' => "''다음과 같은 데이터가 마지막으로 $1 $2에 업데이트되었습니다. ''",
	'validationstatistics-pndtime' => "숙련된 사용자가 확인한 편집을 검토된 편집으로 간주합니다.

[[Special:OldReviewedPages|검토되지 않은 편집이 있는 문서]]의 검토 평균 대기 시간은 '''$1'''입니다.
이 문서는 오래 전에 검토되었으며, 검토를 기다리고 있는 편집이 없을 때 ''동기화''되었다고 표현합니다.",
	'validationstatistics-revtime' => "'''로그인하지 않은 사용자'''의 편집의 평균 대기 시간은 '''$1'''이고 중앙값은 '''$2'''입니다.
$3",
	'validationstatistics-table' => "넘겨주기 문서를 '''제외한''' 문서 검토 통계가 이름공간별로 보여지고 있습니다.",
	'validationstatistics-ns' => '이름공간',
	'validationstatistics-total' => '문서 수',
	'validationstatistics-stable' => '검토됨',
	'validationstatistics-latest' => '동기화됨',
	'validationstatistics-synced' => '동기화됨/검토됨',
	'validationstatistics-old' => '업데이트 필요함',
	'validationstatistics-utable' => '아래는 최근 1시간 동안의 최고 검토자 $1명의 목록입니다',
	'validationstatistics-user' => '사용자',
	'validationstatistics-reviews' => '검토',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 * @author Къарачайлы
 */
$messages['krc'] = array(
	'validationstatistics' => 'Бетлени сынауну статистикасы',
	'validationstatistics-users' => "{{SITENAME}}''' проектде бусагъатда [[{{MediaWiki:Validationpage}}|Редактор]] хакълагъа ие '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|къошулуучу|къошулуучу}} барды.

«Редакторла» —  бетлени белгили версияларын сайлама сынау бардырыргъа эркин къошулуучуладыла.",
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'validationstatistics' => 'Shtatistike vun de Beschtätijunge för Sigge',
	'validationstatistics-users' => "'''{{ucfirst:{{GRAMMAR:Mominativ|{{SITENAME}}}}}}''' hät em Momang [[Special:ListUsers/editor|{{PLURAL:$1|'''eine''' Metmaacher|'''$1''' Metmaacher|'''keine''' Metmaacher}}]] met däm Rääsch, der [[{{MediaWiki:Validationpage}}|{{int:group-editor-member}}]] ze maache.

{{int:group-editor}} sin doför aanerkannte un extra ußjesöhk Metmaacher, di Versione vun Sigge beshtäteje künne.",
	'validationstatistics-lastupdate' => "''De Daate heh henger sen et läz aam $1 öm $2 Uhr op der neuste Shtand jebraat woode.''",
	'validationstatistics-pndtime' => "Änderunge vun „aanerkannte“ Metmaacher wääde als ''nohjekik'' aanjesinn.

Em Schnett doohrd et '''$1''' för [[Special:OldReviewedPages|Sigge met Änderonge, di nit nohjekik sin]]. Jezallt weed dobei immer de Duur, bes de ählste Änderong nohjekik es.",
	'validationstatistics-revtime' => "De Duur beß de Änderonge vun ''naameloose Metmaacher'' nohjekik sen, es '''$1''' — der Median es '''$2'''.
$3",
	'validationstatistics-table' => 'Statistike vun de Beschtäätejunge för jedes Appachtemang wäädew onge jezeish, ävver oohne de Sigge met Ömleijdunge.
Sigge sen als övverhollt enjeschtoof, wann Änderonge doh sen, di noch nit nohjekik sin. All Sigge söns wääde als nohjekik un om aktoälle Shtand jezallt.',
	'validationstatistics-ns' => 'Appachtemang',
	'validationstatistics-total' => 'Sigge ensjesamp',
	'validationstatistics-stable' => 'Aanjekik',
	'validationstatistics-latest' => '<span style="white-space:nowrap">A-juur</span>',
	'validationstatistics-synced' => '{{int:validationstatistics-stable}} un {{int:validationstatistics-latest}}',
	'validationstatistics-old' => 'Övverhollt',
	'validationstatistics-utable' => 'Hee dronger shteiht {{PLURAL:$1|dä Aktievste|de Leß met de Aktievste $1|keine als Aktievste}} unger de {{int:reviewer}}e en {{PLURAL:$2|de läzte Shtond|de läzte $2 Shtonde|winnijer wi de läzte Shtond}}.',
	'validationstatistics-user' => 'Metmaacher',
	'validationstatistics-reviews' => 'Mohlde en Sigg beshtätesh',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'validationstatistics-user' => 'Bikarhêner',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'validationstatistics-total' => 'Folednow',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'validationstatistics' => 'Statistike vun denogekuckte Säiten',
	'validationstatistics-users' => "'''{{SITENAME}}''' huet elo '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|Benotzer|Benotzer}} mat [[{{MediaWiki:Validationpage}}|Editeursrechter]].

Editeure si confirméiert Benotzer déi nogekuckte Versioune vu Säiten derbäisetze kënnen.",
	'validationstatistics-lastupdate' => "''Dës Date goufe fir d'lescht den $1 ëm $2 Auer aktualiséiert.''",
	'validationstatistics-pndtime' => "Ännerungen déi vun engem confirméierte Benotzer nogekuckt si ginn als nogekuckt betruecht.

Den duerchschnëttlechen Delai fir [[Special:OldReviewedPages|Säite mat net nogekuckten Ännerungen am Suspens]] ass '''$1'''; den Delai moosst wéi laang déi eelst Ännerung am Suspens war ier se nogekuckt gouf.",
	'validationstatistics-revtime' => "Déi duerchschnëttlech Waardezäit fir Ännerunge vu ''Benotzer déi net ageloggt waren'' ier hier Ännerung nogekuckt ass ass '''$1'''; d'Median ass '''$2'''. 
$3",
	'validationstatistics-table' => "Statistike vun den nogekuckte Säite fir jiddwer Nummraum sinn hei drënner, Viruleedungssäite sinn ''net berücksichtegt''. Säiten ginn als vereelst (outdated) betruecht wann et Ännerunge gëtt déi nach musse nogekuckt ginn; Säite wou keng Ännerungen am Suspens si ginn als ''aktuell'' (synced) betruecht.",
	'validationstatistics-ns' => 'Nummraum',
	'validationstatistics-total' => 'Säiten',
	'validationstatistics-stable' => 'Validéiert',
	'validationstatistics-latest' => 'Synchroniséiert',
	'validationstatistics-synced' => 'Synchroniséiert/Nogekuckt',
	'validationstatistics-old' => 'Ofgelaf',
	'validationstatistics-utable' => "Hei ënnendrënner ass d'Lëscht mat {{PLURAL:$1|dem aktivste Benotzer|den aktivste(n) $1 Benotzer}}, an {{PLURAL:$2|der leschter Stonn|de leschten $2 Stonnen}}.",
	'validationstatistics-user' => 'Benotzer',
	'validationstatistics-reviews' => 'Bewäertungen',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'validationstatistics' => 'Paginacontrolestatistieke',
	'validationstatistics-revtime' => "De gemiddelde wachtied veur controle van bewirkinge door ''gebroekers die neet aangemeld zeen' is '''$1'''. De mediaan is '''$2'''.
$3",
	'validationstatistics-table' => "Controlestatistieke veur eder naamruumde, ''exclusief'' redireks waere hieónger getuind.",
	'validationstatistics-ns' => 'Naamruumde',
	'validationstatistics-total' => 'Paasj',
	'validationstatistics-stable' => 'Bekeke',
	'validationstatistics-latest' => 'Synchroniseerd',
	'validationstatistics-synced' => 'Synchroniseerd/bekeke',
	'validationstatistics-old' => 'Verajerd',
	'validationstatistics-utable' => "In de ongerstaonde lies {{PLURAL:$1|weurt de meis actieve eindredacteur|waere de $1 meis actieve eindredacteure}} getuind in {{PLURAL:$2|'t aafgeloupen oer|de afgeloupe $2 oer}}.",
	'validationstatistics-user' => 'Gebroeker',
	'validationstatistics-reviews' => 'Beoeardeilinge',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'validationstatistics-total' => 'Puslapiai',
	'validationstatistics-old' => 'Pasenęs',
	'validationstatistics-user' => 'Naudotojas',
	'validationstatistics-reviews' => 'Peržiūros',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'validationstatistics-ns' => 'Vuordu pluots',
	'validationstatistics-total' => 'Puslopys',
	'validationstatistics-user' => 'Lītuotuojs',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'validationstatistics-ns' => 'Лӱм-влакын кумдыкышт',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'validationstatistics' => 'Статистики за оценки',
	'validationstatistics-users' => "'''{{SITENAME}}''' моментално има '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|корисник|корисници}} со права на „[[{{MediaWiki:Validationpage}}|Уредник]]“.

Уредниците се докажани корисници кои можат да прават моментални проверки на ревизии на страници.",
	'validationstatistics-lastupdate' => "''Следниве податоци се последен пат подновени на $1 во $2 ч.''",
	'validationstatistics-pndtime' => "Уредувањата прегледани од докажани корисници се сметаат за проверени.

Просечното задоцнување за [[Special:OldReviewedPages|страници со непрегледани уредувања во исчекување]] изнесува '''$1'''. Задоцнувањето покажува колку време останало непроверено најстарото уредување во исчекување .",
	'validationstatistics-revtime' => "Просечното време на чекање за непроверени уредувања од ''ненајавени корисници'' е '''$1'''; средната вредност изнесува '''$2'''. 
$3",
	'validationstatistics-table' => "Подолу се прикажани статистиките за прегледувањата на секој именски простор, ''освен'' страниците за пренасочување. Страниците се сметаат за „застарени“ ако имаат уредувања што чекаат на проверка. За „усогласени“ се сметаат оние што немаат уредувања во исчекување.",
	'validationstatistics-ns' => 'Именски простор',
	'validationstatistics-total' => 'Страници',
	'validationstatistics-stable' => 'Оценето',
	'validationstatistics-latest' => 'Синхронизирано',
	'validationstatistics-synced' => 'Синхронизирани/Оценети',
	'validationstatistics-old' => 'Застарени',
	'validationstatistics-utable' => 'Подолу е наведен список на {{PLURAL:$1|најактивниот прегледувач|$1 најактивни прегледувачи}} {{PLURAL:$2|во последниов час|во последниве $2 часа}}.',
	'validationstatistics-user' => 'Корисник',
	'validationstatistics-reviews' => 'Оцени',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Sadik Khalid
 */
$messages['ml'] = array(
	'validationstatistics' => 'താൾ സംശോധനത്തിന്റെ സ്ഥിതിവിവരം',
	'validationstatistics-users' => "{{SITENAME}}''' പദ്ധതിയിൽ '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|ഉപയോക്താവിന്|ഉപയോക്താക്കൾക്ക്}} [[{{MediaWiki:Validationpage}}|എഡിറ്റർ]] പദവിയുണ്ട്.

താളുകളുടെ നാൾവഴികൾ പരിശോധിച്ച് തെറ്റുതിരുത്താൻ കഴിയുന്ന സ്ഥാപിത ഉപയോക്താക്കളാണ് എഡിറ്റർമാർ.",
	'validationstatistics-lastupdate' => "''താഴെ പറയുന്ന വിവരങ്ങൾ അവസാനം പുതുക്കിയത് $1 $2-നു ആണ്.''",
	'validationstatistics-pndtime' => "സ്ഥിരീകൃത ഉപയോക്താക്കൾ പരിശോധിക്കപ്പെട്ട തിരുത്തലുകൾ ''സംശോധനം ചെയ്തതായി'' കരുതപ്പെടും.


[[Special:OldReviewedPages|സംശോധനം ചെയ്യാൻ അവശേഷിക്കുന്ന താളുകൾ]] എടുക്കാനുള്ള ശരാശരി താമസം '''$1''' ആണ്; ഏറ്റവും പഴയ അവശേഷിക്കുന്ന തിരുത്തൽ എത്രനാൾ സംശോധനത്തിനായി കാത്തുകിടന്നു എന്നതുപയോഗിച്ചാണ് കാലതാമസം അളക്കുന്നത്.",
	'validationstatistics-revtime' => "''ലോഗിൻ ചെയ്യാത്ത ഉപയോക്താക്കളുടെ'' തിരുത്തലുകൾ സംശോധനം ചെയ്യാനുള്ള ശരാശരി കാലതാമസം '''$1''' ആണ്; മീഡിയൻ '''$2''' ആണ്.
$3",
	'validationstatistics-table' => "ഓരോ നാമമേഖലയിലേയും താൾ സംശോധന സ്ഥിതിവിവരക്കണക്കുകൾ താഴെ കൊടുക്കുന്നു, തിരിച്ചുവിടൽ താളുകൾ ''ഒഴിവാക്കുന്നു''. താളുകളിൽ തിരുത്തലുകൾ സംശോധനത്തിനവശേഷിക്കുന്നുൻടെങ്കിൽ അവ ''കാലഹരണപ്പെട്ടവ'' ആയി കണക്കാക്കുന്നു; താളുകളിൽ സംശോധനത്തിനു തിരുത്തലുകൾ ഒന്നുമില്ലെങ്കിൽ അവ ''യോജിപ്പിച്ചതായി'' കണക്കാക്കുന്നു.",
	'validationstatistics-ns' => 'നാമമേഖല',
	'validationstatistics-total' => 'താളുകൾ',
	'validationstatistics-stable' => 'സംശോധനം ചെയ്തവ',
	'validationstatistics-latest' => 'ഏകതാനമാക്കിയിരിക്കുന്നു',
	'validationstatistics-synced' => 'ഏകകാലികമാക്കിയവ/പരിശോധിച്ചവ',
	'validationstatistics-old' => 'കാലഹരണപ്പെട്ടവ',
	'validationstatistics-utable' => 'കഴിഞ്ഞ {{PLURAL:$2|മണിക്കൂറിൽ|$2 മണിക്കൂറുകളിൽ}} ഏറ്റവും സജീവമായി പ്രവർത്തിച്ച {{PLURAL:$1|സംശോധകന്റെ|$1 സംശോധകരുടെ}} പട്ടികയാണ് താഴെയുള്ളത്.',
	'validationstatistics-user' => 'ഉപയോക്താവ്',
	'validationstatistics-reviews' => 'സംശോധനങ്ങൾ',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'validationstatistics-ns' => 'Нэрний зай',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'validationstatistics' => 'Statistik kajian semula laman',
	'validationstatistics-users' => "'''{{SITENAME}}''' kini mempunyai '''[[Special:ListUsers/editor|$1]]''' orang pengguna yang mempunyai hak [[{{MediaWiki:Validationpage}}|Penyunting]].

Penyunting merupakan pengguna berpengalaman yang boleh membuat pemeriksaan mengejut pada laman-laman.",
	'validationstatistics-lastupdate' => "''Data berikut kali terakhir dikemas kini pada $1, $2.''",
	'validationstatistics-pndtime' => "Suntingan yang telah diperiksa oleh pengguna-pengguna yang mantap dianggap ''dikaji semula''.

Purata masa tangguhan kaji semula untuk [[Special:OldReviewedPages|laman-laman yang mempunyai suntingan yang menunggu untuk dikaji semula]] ialah '''$1'''; masa tangguhan diukur berdasarkan berapa lama suntingan tergantung yang terlama dibiarkan tanpa kaji semula.",
	'validationstatistics-revtime' => "Purata masa menunggu untuk suntingan oleh ''pengguna yang tidak log masuk'' untuk dikaji semula ialah '''$1'''; mediannya ialah '''$2'''. 
$3",
	'validationstatistics-table' => "Statistik kaji semula laman untuk setiap ruang nama ditunjukkan di bawah, ''tidak termasuk'' laman lencongan. Laman yang ada suntingan yang menunggu untuk dikaji semula dikira ''lapuk''; laman yang tiada suntingan yang menunggu untuk dikaji semula dikira ''diselaras''.",
	'validationstatistics-ns' => 'Ruang nama',
	'validationstatistics-total' => 'Laman',
	'validationstatistics-stable' => 'Dikaji semula',
	'validationstatistics-latest' => 'Diselaras',
	'validationstatistics-synced' => 'Diselaras/Dikaji Semula',
	'validationstatistics-old' => 'Lapuk',
	'validationstatistics-utable' => 'Berikut ialah {{PLURAL:$1|pengkaji semula paling aktif|senarai $1 pengkaji semula paling aktif}} dalam {{PLURAL:$2|sejam|$2 jam}} yang lalu.',
	'validationstatistics-user' => 'Pengguna',
	'validationstatistics-reviews' => 'Kajian semula',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'validationstatistics-ns' => 'Spazju tal-isem',
	'validationstatistics-total' => 'Paġni',
	'validationstatistics-user' => 'Utent',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'validationstatistics-ns' => 'Лем потмо',
	'validationstatistics-total' => 'Лопат',
);

/** Nahuatl (Nāhuatl)
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'validationstatistics-ns' => 'Tòkâyeyàntli',
	'validationstatistics-total' => 'Tlaìxtlapaltìn',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'validationstatistics' => 'Siderevideringsstatistikk',
	'validationstatistics-users' => "'''{{SITENAME}}''' har på nåværende tidspunkt '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|bruker|brukere}} med [[{{MediaWiki:Validationpage}}|skribentrettigheter]].

Skribenter er etablerte brukere som kan punktsjekke siderevisjoner.",
	'validationstatistics-lastupdate' => "''Følgende data ble sist oppdatert $1, $2.''",
	'validationstatistics-pndtime' => "Redigeringer som har blitt kontrollert av etablerte brukere anses å være ''revidert''.

Gjennomsnittsforsinkelsen for [[Special:OldReviewedPages|sider med ureviderte ventende endringer]] er '''$1'''; forsinkelsen måler hvor lenge den eldste ventende endringer har vært uvurdert.",
	'validationstatistics-revtime' => "Gjennomsnittsventetiden for endringer av ''brukere som ikke har logget inn'' å bli revidert er '''$1'''; medianen er '''$2'''.
$3",
	'validationstatistics-table' => "Siderevideringsstatistikk for hvert navnerom vises nedenfor, ''utenom'' omdirigeringssider. Sider behandles som ''utdaterte'' om de har uvurderte ventende endringer; sider anses å være ''synket'' dersom de har ingen uvurderte ventende endringer.",
	'validationstatistics-ns' => 'Navnerom',
	'validationstatistics-total' => 'Sider',
	'validationstatistics-stable' => 'Anmeldt',
	'validationstatistics-latest' => 'Synkronisert',
	'validationstatistics-synced' => 'Synkronisert/Anmeldt',
	'validationstatistics-old' => 'Foreldet',
	'validationstatistics-utable' => 'Under er en liste over {{PLURAL:$1|den mest aktive anmelderen|de $1 mest aktive anmelderne}} {{PLURAL:$2|den siste timen|de siste $2 timene}}.',
	'validationstatistics-user' => 'Bruker',
	'validationstatistics-reviews' => 'Anmeldelser',
);

/** Dutch (Nederlands)
 * @author Ooswesthoesbes
 * @author Siebrand
 */
$messages['nl'] = array(
	'validationstatistics' => 'Paginacontrolestatistieken',
	'validationstatistics-users' => "'''{{SITENAME}}''' heeft op het moment '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|gebruiker|gebruikers}} in de rol van [[{{MediaWiki:Validationpage}}|Redacteur]].

Redacteuren zijn gebruikers die zich bewezen hebben en versies van pagina's als gecontroleerd mogen markeren.",
	'validationstatistics-lastupdate' => "''Deze gegevens zijn bijgewerkt op $1 om $2.''",
	'validationstatistics-pndtime' => "Van bewerkingen die zijn ''gecontroleerd'' door gebruikers wordt aangenomen dat die in orde zijn. 

De gemiddelde vertraging voor de [[Special:OldReviewedPages|pagina's met ongecontroleerde bewerkingen]] is '''$1'''.
De vertraging geeft aan hoe lang het duurt voor een bewerking wordt gecontroleerd.",
	'validationstatistics-revtime' => "De gemiddelde wachttijd voor controle van bewerkingen door ''gebruikers die niet aangemeld zijn' is '''$1'''. De mediaan is '''$2'''.
$3",
	'validationstatistics-table' => "Controlestatistieken voor iedere naamruimte, ''exclusief'' doorverwijzingen worden hieronder weergegeven.",
	'validationstatistics-ns' => 'Naamruimte',
	'validationstatistics-total' => "Pagina's",
	'validationstatistics-stable' => 'Gecontroleerd',
	'validationstatistics-latest' => 'Gesynchroniseerd',
	'validationstatistics-synced' => 'Gesynchroniseerd/gecontroleerd',
	'validationstatistics-old' => 'Verouderd',
	'validationstatistics-utable' => 'In de onderstaande lijst {{PLURAL:$1|wordt de meest actieve eindredacteur|worden de $1 meest actieve eindredacteuren}} weergegeven in {{PLURAL:$2|het afgelopen uur|de afgelopen $2 uur}}.',
	'validationstatistics-user' => 'Gebruiker',
	'validationstatistics-reviews' => 'Beoordelingen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Ranveig
 */
$messages['nn'] = array(
	'validationstatistics' => 'Valideringsstatistikk',
	'validationstatistics-users' => "'''{{SITENAME}}''' har nett no {{PLURAL:$1|'''éin''' brukar|'''[[Special:ListUsers/editor|$1]]''' brukarar}} med [[{{MediaWiki:Validationpage}}|skriverettar]]. Skriverettar vil seie at ein kan sjekke endringar av sider.",
	'validationstatistics-table' => "Statistikk for kvart namnerom er synt nedanfor, ''utanom'' omdirigeringssider.",
	'validationstatistics-ns' => 'Namnerom',
	'validationstatistics-total' => 'Sider',
	'validationstatistics-stable' => 'Vurdert',
	'validationstatistics-latest' => 'Synkronisert',
	'validationstatistics-synced' => 'Synkronisert/Vurdert',
	'validationstatistics-old' => 'Utdatert',
	'validationstatistics-user' => 'Brukar',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'validationstatistics' => 'Estatisticas de relectura de las paginas',
	'validationstatistics-users' => "'''{{SITENAME}}''' dispausa actualament de '''[[Special:ListUsers/editor|$1]]''' utilizaire{{PLURAL:$1||s}} amb los dreches de [[{{MediaWiki:Validationpage}}|contributor]].

Los contributors e relectors son d'utilizaires establits que pòdon verificar las revisions de las paginas.",
	'validationstatistics-table' => "Las estatisticas per cada espaci de noms son afichadas çaijós, a ''l’exclusion'' de las paginas de redireccion.",
	'validationstatistics-ns' => 'Nom de l’espaci',
	'validationstatistics-total' => 'Paginas',
	'validationstatistics-stable' => 'Relegit',
	'validationstatistics-latest' => 'Sincronizada',
	'validationstatistics-synced' => 'Sincronizat/Relegit',
	'validationstatistics-old' => 'Desuet',
	'validationstatistics-utable' => 'Çaijós figuran los $1 melhors relectors dins la darrièra ora.',
	'validationstatistics-user' => 'Utilizaire',
	'validationstatistics-reviews' => 'Relectors',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'validationstatistics' => 'ପୃଷ୍ଠା ସମୀକ୍ଷା ଆକଳନ',
	'validationstatistics-ns' => 'ନେମସ୍ପେସ',
	'validationstatistics-total' => 'ପୃଷ୍ଠା',
	'validationstatistics-latest' => 'ସଜଡ଼ାହେବା',
	'validationstatistics-user' => 'ବ୍ୟବହାରକାରୀ',
	'validationstatistics-reviews' => 'ସମୀକ୍ଷାସବୁ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'validationstatistics-ns' => 'Blatznaame',
	'validationstatistics-total' => 'Bledder',
	'validationstatistics-user' => 'Yuuser',
);

/** Polish (Polski)
 * @author Fizykaa
 * @author Jwitos
 * @author Leinad
 * @author Sp5uhe
 * @author ToSter
 * @author Wpedzich
 */
$messages['pl'] = array(
	'validationstatistics' => 'Statystyka oznaczania stron',
	'validationstatistics-users' => "W '''{{GRAMMAR:MS.lp|{{SITENAME}}}}''' zarejestrowanych jest obecnie  '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|użytkownik|użytkowników}} z uprawnieniami [[{{MediaWiki:Validationpage}}|redaktora]].

Redaktorzy są doświadczonymi użytkownikami, którzy mogą oznaczać dowolne wersje stron.",
	'validationstatistics-lastupdate' => "''Poniższe dane uaktualnione zostały $1 o $2.''",
	'validationstatistics-pndtime' => "Zmiany, które zostały sprawdzone przez uprawnionych użytkowników są uznawane za ''oznaczone''.

Średnie opóźnienie dla [[Special:OldReviewedPages|stron ze zmianami oczekującymi na oznaczenie]] wynosi '''$1'''. Jest to czas przez który najstarsze edycje pozostawały nieprzejrzane.",
	'validationstatistics-revtime' => "Średni czas oczekiwania na oznaczenie edycji ''niezalogowanych użytkowników'' wynosi '''$1''', mediana – '''$2'''.
$3",
	'validationstatistics-table' => "Poniżej znajdują się statystyki przeglądania stron dla każdej przestrzeni nazw, ''z wyłączeniem'' przekierowań. Strony uznawane są za ''przestarzałe'' jeśli są zmiany ich treści oczekujące na przejrzenie. Strony uznawane są za ''przejrzane'' jeśli żadne zmiany ich treści nie oczekują na przejrzenie.",
	'validationstatistics-ns' => 'Przestrzeń nazw',
	'validationstatistics-total' => 'Stron',
	'validationstatistics-stable' => 'Przejrzanych',
	'validationstatistics-latest' => 'Z ostatnią edycją oznaczoną jako przejrzana',
	'validationstatistics-synced' => 'Zsynchronizowanych lub przejrzanych',
	'validationstatistics-old' => 'Zdezaktualizowane',
	'validationstatistics-utable' => 'Poniżej znajduje się {{PLURAL:$1|nazwa użytkownika najaktywniej oznaczającego|lista $1 użytkowników najaktywniej oznaczających}} strony w ciągu {{PLURAL:$2|ostatniej godziny|ostatnich $2 godzin}}.',
	'validationstatistics-user' => 'Użytkownik',
	'validationstatistics-reviews' => 'Liczba oznaczeń',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'validationstatistics' => 'Statìstiche ëd validassion ëd la pàgina',
	'validationstatistics-users' => "'''{{SITENAME}}''' al moment a l'ha '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utent|utent}} con drit d'[[{{MediaWiki:Validationpage}}|Editor]] 

J'Editor a son utent sicur che a peulo controlé le revision a le pàgine.",
	'validationstatistics-lastupdate' => "''Ij dat sota a son ëstàit modificà l'ùltima vira ël $1 a $2.''",
	'validationstatistics-pndtime' => "Modìfiche ch'a son ëstàite controlà da utent confermà a son considerà ''revisionà''.

Ël ritard medi për [[Special:OldReviewedPages|pàgine con modìfiche pa revisionà ch'a speto]] a l'é '''$1''';
ël ritard a mzura vàire che le modìfiche pi veje ch'a speto a son restà sensa esse revisionà.",
	'validationstatistics-revtime' => "L'atèisa pi àuta përchè le modìfiche dj'''utent anònim'' a sio revisionà a l'é '''$1''', la media a l'é '''$2'''.
$3",
	'validationstatistics-table' => "Le statìstiche ëd revision dle pàgine për minca spassi nominal a son mostrà sì-sota, ''gavà'' le pàgine ëd ridiression. Le pàgine a son tratà com ''veje'' se a l'han dle modìfiche ch'a speto na revision; le pàgine a son considerà ''sincronisà'' se a l'han pa ëd modìfiche ch'a speto na revision.",
	'validationstatistics-ns' => 'Spassi nominal',
	'validationstatistics-total' => 'Pàgine',
	'validationstatistics-stable' => 'Revisionà',
	'validationstatistics-latest' => 'Sincronisà',
	'validationstatistics-synced' => 'Sincronisà/Revisionà',
	'validationstatistics-old' => 'Veje',
	'validationstatistics-utable' => "Sota a-i é na lista {{PLURAL:$1|dël revisor pi ativ|dij $1 revisor pi ativ}} ant {{PLURAL:$2|l'ùltima ora|j'ùltime $2 ore}}.",
	'validationstatistics-user' => 'Utent',
	'validationstatistics-reviews' => 'Revisor',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'validationstatistics-ns' => 'نوم-تشيال',
	'validationstatistics-total' => 'مخونه',
	'validationstatistics-user' => 'کارن',
);

/** Portuguese (Português)
 * @author 555
 * @author Alchimista
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'validationstatistics' => 'Estatísticas da revisão de páginas',
	'validationstatistics-users' => "A '''{{SITENAME}}''' tem, neste momento, '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilizador|utilizadores}} com permissões de [[{{MediaWiki:Validationpage}}|Editor]].

Editores são utilizadores que podem rever as edições de páginas.",
	'validationstatistics-lastupdate' => "''Os seguintes dados foram actualizados pela última vez a $1 às $2.''",
	'validationstatistics-pndtime' => "As edições verificadas por utilizadores estabelecidos são consideras ''revistas''.

O atraso médio de revisão das [[Special:OldReviewedPages|páginas com edições à espera de revisão]] é '''$1'''; este atraso mede o tempo que a edição pendente mais antiga ficou à espera de revisão.",
	'validationstatistics-revtime' => "O tempo médio de espera para revisão das edições de ''utilizadores não autenticados'' é '''$1'''; a mediana é '''$2'''. 
$3",
	'validationstatistics-table' => "São apresentadas abaixo estatísticas das revisões em cada espaço nominal, '''excluindo''' páginas de redireccionamento. As páginas são consideradas ''desactualizadas'' se tiverem edições à espera de revisão, e ''sincronizadas'' se não tiverem edições em espera.",
	'validationstatistics-ns' => 'Espaço nominal',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Revistas',
	'validationstatistics-latest' => 'Sincronizadas',
	'validationstatistics-synced' => 'Sincronizadas/Revistas',
	'validationstatistics-old' => 'Desactualizadas',
	'validationstatistics-utable' => 'Abaixo está a lista {{PLURAL:$1|do revisor mais activo|dos $1 revisores mais activos}} {{PLURAL:$2|na última hora|nas últimas horas}}.',
	'validationstatistics-user' => 'Utilizador',
	'validationstatistics-reviews' => 'Revisões',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'validationstatistics' => 'Estatísticas da revisão de páginas',
	'validationstatistics-users' => "'''{{SITENAME}}''' possui, no momento, '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|Editor]] .

Editores são utilizadores estabelecidos que podem verificar detalhadamente revisões de páginas.",
	'validationstatistics-lastupdate' => "''Os seguintes dados foram atualizados pela última vez em $1 às $2.''",
	'validationstatistics-pndtime' => "As edições verificadas por usuários estabelecidos são consideras ''revisadas''.

O atraso médio de revisão das [[Special:OldReviewedPages|páginas com edições à espera de revisão]] é '''$1'''; este atraso mede o tempo que a edição pendente mais antiga ficou à espera de revisão.",
	'validationstatistics-revtime' => "O tempo médio de espera para revisão das edições de ''usuários não autenticados'' é '''$1'''; a mediana é '''$2'''. 
$3",
	'validationstatistics-table' => "São apresentadas abaixo estatísticas das revisões em cada espaço nominal, '''excluindo''' páginas de redirecionamento. As páginas são consideradas ''desatualizadas'' se tiverem edições à espera de revisão, e ''sincronizadas'' se não tiverem edições em espera.",
	'validationstatistics-ns' => 'Espaço nominal',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Analisadas',
	'validationstatistics-latest' => 'Sincronizada',
	'validationstatistics-synced' => 'Sincronizadas/Analisadas',
	'validationstatistics-old' => 'Desatualizadas',
	'validationstatistics-utable' => 'Abaixo está a lista {{PLURAL:$1|do revisor mais ativo|dos $1 revisores mais ativos}} {{PLURAL:$2|na última hora|nas últimas horas}}.',
	'validationstatistics-user' => 'Usuário',
	'validationstatistics-reviews' => 'Análises',
);

/** Romanian (Română)
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'validationstatistics' => 'Statistici revizuire pagină',
	'validationstatistics-users' => "'''{{SITENAME}}''' are în prezent '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilizator|utilizatori}} cu drepturi de [[{{MediaWiki:Validationpage}}|editare]].

Editorii și recenzorii sunt utilizatori stabiliți care pot verifica modificările din pagini.",
	'validationstatistics-lastupdate' => "''Următoarele date au fost ultima dată actualizate pe $1 la $2.''",
	'validationstatistics-ns' => 'Spațiu de nume',
	'validationstatistics-total' => 'Pagini',
	'validationstatistics-stable' => 'Revizualizată',
	'validationstatistics-latest' => 'Sincronizată',
	'validationstatistics-synced' => 'Sincronizată/Revizualizată',
	'validationstatistics-old' => 'Învechită',
	'validationstatistics-utable' => 'Mai jos se află {{PLURAL:$1|cel mai activ recenzent|lista cu cei mai activi $1 (de) recenzenți}} din {{PLURAL:$2|ultima oră|ultimele $2 ore}}.',
	'validationstatistics-user' => 'Utilizator',
	'validationstatistics-reviews' => 'Recenzii',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'validationstatistics' => "Statisteche d'a pàgene reviste",
	'validationstatistics-users' => "'''{{SITENAME}}''' jndr'à quiste mumende tène '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utende|utinde}} cu le deritte de [[{{MediaWiki:Validationpage}}|cangiatore]].

Le cangiature sonde utinde stabbelite ca ponne fà verifiche a cambione de le revisiune a le pàggene.",
	'validationstatistics-lastupdate' => "''Le seguende date onne state cangiate l'urtema vote 'u $1 a le $2.''",
	'validationstatistics-pndtime' => "Le cangiaminde onne state verificate da utinde stabbelite e sonde considerate ''reviste''.

'U ritarde medie pe [[Special:OldReviewedPages|le pàggene cu cangiaminde pendende none reviste]] jè '''$1'''; 'a mesure d'u ritarde parte da quanne 'u cangiamende pendende cchiù vecchie non g'a state reviste.",
	'validationstatistics-revtime' => "'A medie de attese pe le cangiaminde da ''utinde ca non ge s'onne collegate'' pe esseere reviste jè '''$1'''; 'a mediane jè '''$2'''.
$3",
	'validationstatistics-table' => "Le statisteche de le pàggene reviste pe ogne namespace avènene fatte vedè aqquà sotte, ''<nowiki>'</nowiki>scludenne'' le pàggene de le redirezionaminde. Le pàggene sonde trattate cumme ''none aggiornate'' ce lore onne cangiaminde appise pa revisione; le pàggene sonde conziderate ''aggiornate'' ce non ge tènene cangiaminde appise pa revisione.",
	'validationstatistics-ns' => 'Neimspeise',
	'validationstatistics-total' => 'Pàggene',
	'validationstatistics-stable' => 'Riviste',
	'validationstatistics-latest' => 'Singronizzate',
	'validationstatistics-synced' => 'Singronizzete/Riviste',
	'validationstatistics-old' => "Non g'è aggiornete",
	'validationstatistics-utable' => "Sotte ste 'n'elenghe de le {{PLURAL:$1|revisitatore cchiù attive|$1 revisitature cchiù attive}} jndr'à {{PLURAL:$2|l'urtema ore|$2 l'urteme ore}}.",
	'validationstatistics-user' => 'Utende',
	'validationstatistics-reviews' => 'Reviste',
);

/** Russian (Русский)
 * @author Ahonc
 * @author AlexSm
 * @author Claymore
 * @author Ferrer
 * @author Lockal
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'validationstatistics' => 'Статистика проверок страниц',
	'validationstatistics-users' => "В проекте {{SITENAME}} на данный момент '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|участник имееет|участника имеют|участников имеют}} полномочия [[{{MediaWiki:Validationpage}}|«редактора»]].

«Редакторы» — это определённые участники, имеющие возможность делать выборочную проверку конкретных версий страниц.",
	'validationstatistics-lastupdate' => "''Следующие данные были последний раз обновлены $1 в $2.''",
	'validationstatistics-pndtime' => "Правки, отмеченные определёнными участниками, считаются прошедшими проверку.

Средняя задержка [[Special:OldReviewedPages|для страниц с непроверенными правками]] — '''$1'''. Этот параметр показывает как долго последняя непроверенная версия правка остаётся без внимания проверяющих.",
	'validationstatistics-revtime' => "Средняя задержка проверки для правок ''непредставившихся участников'' составляет '''$1'''; медиана — '''$2'''. 
$3",
	'validationstatistics-table' => "Ниже представлена статистика проверок по каждому пространству имён, ''исключая'' страницы перенаправлений. Страницы считаются «устаревшими», если они имеют непроверенные правки; страницы считаются «синхронизироваными», если у них нет правок, ожидающих проверки.",
	'validationstatistics-ns' => 'Пространство',
	'validationstatistics-total' => 'Страниц',
	'validationstatistics-stable' => 'Проверенные',
	'validationstatistics-latest' => 'Перепроверенные',
	'validationstatistics-synced' => 'Доля перепроверенных в проверенных',
	'validationstatistics-old' => 'Устаревшие',
	'validationstatistics-utable' => 'Ниже приведён список из {{PLURAL:$1|$1 наиболее активного выверяющего|$1 наиболее активных выверяющих|$1 наиболее активных выверяющих}} за {{PLURAL:$2|последний $2 час|последние $2 часа|последние $2 часов}}.',
	'validationstatistics-user' => 'Участник',
	'validationstatistics-reviews' => 'Проверки',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'validationstatistics' => 'Штатістіка рецензовань сторінок',
	'validationstatistics-users' => "У проекті '''{{SITENAME}}''' зараз '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|хоснователь має|хоснователїв мають|хоснователїв мають}} права [[{{MediaWiki:Validationpage}}|«редактор»]].

«Редакторы» — становлены хоснователї, котры мають можность робити выберову перевірку конкретных верзій сторінок.",
	'validationstatistics-lastupdate' => "''Наступны дата были остатнїй раз обновлены $1 о $2.''",
	'validationstatistics-pndtime' => "Едітованя, котры были перевірены становленыма хоснователями ся поважують за ''перевірены''

Середня затримка про [[Special:OldReviewedPages|сторінок з управами, котры чекають на перевірку]] становить '''$1'''.
Тот параметер зображує як довго неперевірена сторінка ся зохабить без увагы рецензентів.",
	'validationstatistics-revtime' => "Середнїй час чеканя про едітованя од ''неприголошеных хоснователїв'' на посуджіня є '''$1'''; медіан є '''$2'''.
$3",
	'validationstatistics-table' => 'Штатістіка рецензовань сторінок про каждый простор назв указана ниже, "без" сторінок напрямлїня. Сторінкы ся поважують за "застаралы", кідь не мають едітованя,  котры чекають на перевірку.',
	'validationstatistics-ns' => 'Простор назв',
	'validationstatistics-total' => 'Сторінкы',
	'validationstatistics-stable' => 'Перевірены',
	'validationstatistics-latest' => 'Сінхронізовано',
	'validationstatistics-synced' => 'Сінхронізовано/перевірено',
	'validationstatistics-old' => 'Застарілы',
	'validationstatistics-utable' => 'Ниже є список {{PLURAL:$1|найвеце актівного рецензента|список $1 найвеце актівных рецензентів}} за {{PLURAL:$2|послїдню годину|$2 послїднї годины}}.',
	'validationstatistics-user' => 'Хоснователь',
	'validationstatistics-reviews' => 'Посуджіня',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'validationstatistics-user' => 'योजक',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'validationstatistics' => 'Сирэй тургутуутун статиистиката',
	'validationstatistics-table' => 'Аллара ааттар далларын тургутуу статиистиката бэриллибит (утаарыылартан \'\'ураты\'\'). Сирэйдэр тургутуллубатах көннөрүүлэрдээх буоллахтарына "эргэрбит" диэн ааҕыллаллар; сирэйдэр тургутуллуохтаах көннөрүүлэрэ суох буоллаҕына "тэҥнэммит" аатыраллар.',
	'validationstatistics-ns' => 'Аат дала',
	'validationstatistics-total' => 'Сирэй',
	'validationstatistics-stable' => 'Тургутуллубут',
	'validationstatistics-latest' => 'Хат тургутуллубут',
	'validationstatistics-synced' => 'Хат тургутуллубуттар тургутуллубуттар истэригэр бырыаннара',
	'validationstatistics-old' => 'Эргэрбит',
	'validationstatistics-utable' => 'Бүтэһик чааска ордук көхтөөх $1 тургутааччы тиһигэ көстөр.',
	'validationstatistics-user' => 'Кыттааччы',
	'validationstatistics-reviews' => 'Бэрэбиэркэ',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'validationstatistics-ns' => 'Nùmene-logu',
	'validationstatistics-total' => 'Pàginas',
	'validationstatistics-user' => 'Usuàriu',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'validationstatistics-total' => 'Pàggini',
	'validationstatistics-user' => 'Utenti',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 * @author බිඟුවා
 */
$messages['si'] = array(
	'validationstatistics' => 'පිටු නිරීක්ෂණ සංඛ්‍යා ලේඛන',
	'validationstatistics-lastupdate' => "''පහත දැක්වෙන දත්ත $1 දින $2 දිනදී අන්තිම වරට යාවත්කාලීන කර ඇත.''",
	'validationstatistics-ns' => 'නාම අවකාශය',
	'validationstatistics-total' => 'පිටු',
	'validationstatistics-stable' => 'නිරීක්ෂණය කෙරූ',
	'validationstatistics-old' => 'යල් පැන ගිය',
	'validationstatistics-user' => 'පරිශීලක',
	'validationstatistics-reviews' => 'නිරීක්ෂණ',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'validationstatistics' => 'Štatistiky overenia',
	'validationstatistics-users' => "'''{{SITENAME}}''' má momentálne '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|používateľa|používateľov}} s právami [[{{MediaWiki:Validationpage}}|redaktor]] a '''[[Special:ListUsers/reviewer|$2]]'' {{PLURAL:$2|používateľa|používateľov}} s právami [[{{MediaWiki:Validationpage}}|kontrolór]].",
	'validationstatistics-lastupdate' => "''Nasledujúce údaje boli naposledy aktualizované $1 $2.''",
	'validationstatistics-pndtime' => "Úpravy, ktoré boli overené dôveryhodnými používateľmi sú považované za skontrolované.

Priemerné čakanie na [[Special:OldReviewedPages|stránky s  čakajúcimi úpravami]] je '''$1'''.
Tieto stránky sú považované za ''zastarané''. Podobne, stránky sú považované za ''synchronizované'', ak nie sú k dispozícii žiadne úpravy čakajúce na kontrolu.",
	'validationstatistics-revtime' => "Priemerné čakanie na skontrolovanie úprav ''neprihlásených používateľov'' je '''$1''', medián je '''$2'''.",
	'validationstatistics-table' => "Dolu sú zobrazené štatistiky pre každý menný priestor ''okrem'' presmerovacích stránok.",
	'validationstatistics-ns' => 'Menný priestor',
	'validationstatistics-total' => 'Stránky',
	'validationstatistics-stable' => 'Skontrolované',
	'validationstatistics-latest' => 'Synchronizovaná',
	'validationstatistics-synced' => 'Synchronizované/skontrolované',
	'validationstatistics-old' => 'Zastaralé',
	'validationstatistics-utable' => 'Dolu je zoznam $1 naj kontrolórov za poslednú hodinu.',
	'validationstatistics-user' => 'Používateľ',
	'validationstatistics-reviews' => 'Kontroly',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'validationstatistics' => 'Statistika pregledov strani',
	'validationstatistics-users' => "'''{{SITENAME}}''' ima trenutno '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|uporabnika|uporabnika|uporabnike|uporabnikov}} s pravicami [[{{MediaWiki:Validationpage}}|Urednika]].

Uredniki so uveljavljeni uporabniki, ki lahko samodejno preverijo redakcije strani.",
	'validationstatistics-lastupdate' => "''Sledeči podatki so bili nazadnje posodobljeni dne $1 ob $2.''",
	'validationstatistics-pndtime' => "Urejanja, ki so jih preverili uveljavljeni uporabniki, se smatrajo kot ''pregledana''.

Povprečni zamik pregleda [[Special:OldReviewedPages|strani z urejanji, ki čakajo na pregled]], je '''$1'''; zakasnitev meri, kako dolgo je bilo nepregledano najstarejše urejanje, ki je čakalo na pregled.",
	'validationstatistics-revtime' => "Povprečna čakalna doba pregleda urejanj ''uporabnikov, ki niso prijavljeni''', je '''$1'''; mediana je '''$2'''.
$3",
	'validationstatistics-table' => "Statistika pregleda strani za posamezni imenski prostor je prikazana spodaj, ''brez'' preusmeritvenih strani. Srtrani se obravnavajo kot ''zastarele'', če imajo urejanja, ki čakajo na pregled; strani se štejejo kot ''usklajene'', če nobeno urejanje ne čaka na pregled.",
	'validationstatistics-ns' => 'Imenski prostor',
	'validationstatistics-total' => 'Strani',
	'validationstatistics-stable' => 'Pregledano',
	'validationstatistics-latest' => 'Usklajeno',
	'validationstatistics-synced' => 'Usklajeno/Pregledano',
	'validationstatistics-old' => 'Zastarelo',
	'validationstatistics-utable' => 'Spodaj se nahaja seznam {{PLURAL:$1|najdejavnejšega pregledovalca|$1 najdejavnejših pregledovalcev}} v {{PLURAL:$1|zadnji uri|zadnjih $2 urah}}.',
	'validationstatistics-user' => 'Uporabnik',
	'validationstatistics-reviews' => 'Pregledi',
);

/** Albanian (Shqip)
 * @author Puntori
 */
$messages['sq'] = array(
	'validationstatistics-total' => 'Faqet',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 * @author Обрадовић Горан
 */
$messages['sr-ec'] = array(
	'validationstatistics-table' => "Доле су приказане статистике за прегледање сваког именског простора, ''осим'' страница за преусмеравање. Странице се сматрају као „застареле“ ако имају измене које чекају на проверу. За „усклађене“ се сматрају оне странице које немају измене на чекању.",
	'validationstatistics-ns' => 'Именски простор',
	'validationstatistics-total' => 'Странице',
	'validationstatistics-stable' => 'Прегледано',
	'validationstatistics-latest' => 'Синхронизовано',
	'validationstatistics-synced' => 'Усклађено/прегледано',
	'validationstatistics-old' => 'Застарело',
	'validationstatistics-utable' => 'Испод је списак {{PLURAL:$1|најактивнијег|$1 најактивнија|$1 најактивнијих}} прегледача {{PLURAL:$2|у последњих сат времена|у последња $2 сата|у последњих $2 сати}}.',
	'validationstatistics-user' => 'Корисник',
	'validationstatistics-reviews' => 'Прегледи',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'validationstatistics-table' => "Dole su prikazane statistike za pregledanje svakog imenskog prostora, ''osim'' stranica za preusmeravanje. Stranice se smatraju kao „zastarele“ ako imaju izmene koje čekaju na proveru. Za „usklađene“ se smatraju one stranice koje nemaju izmene na čekanju.",
	'validationstatistics-ns' => 'Imenski prostor',
	'validationstatistics-total' => 'Stranice',
	'validationstatistics-stable' => 'Pregledano',
	'validationstatistics-latest' => 'Sinhronizovano',
	'validationstatistics-synced' => 'Sinhronizovan/Pregledan',
	'validationstatistics-old' => 'Zastarelo',
	'validationstatistics-utable' => 'Ispod je spisak {{PLURAL:$1|najaktivnijeg|$1 najaktivnija|$1 najaktivnijih}} pregledača {{PLURAL:$2|u poslednjih sat vremena|u poslednja $2 sata|u poslednjih $2 sati}}.',
	'validationstatistics-user' => 'Korisnik',
	'validationstatistics-reviews' => 'Pregledi',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Dafer45
 * @author M.M.S.
 * @author Rotsee
 * @author Skalman
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'validationstatistics' => 'Statistik över sidgranskning',
	'validationstatistics-users' => "'''{{SITENAME}}''' har just nu '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|användare|användare}} med [[{{MediaWiki:Validationpage}}|skribenträttigheter]].

Skribenter är etablerade användare som kan granska sidversioner.",
	'validationstatistics-lastupdate' => "''Följande uppgifter uppdaterades senast på $1 vid $2.''",
	'validationstatistics-pndtime' => "Redigeringar som har kollats av etablerade användare anses vara granskade.

Den genomsnittliga förseningen för [[Special:OldReviewedPages|sidor med väntande ogranskade redigeringar]] är '''$1'''; dröjsmålet mäter hur lång tid den äldsta väntande redigeringen blivit granskad.",
	'validationstatistics-revtime' => "Den genomsnittliga väntan för redigeringar av ''användare som inte har loggat in'' för att granskas är '''$1'''; medianen är '''$2'''. 
$3",
	'validationstatistics-table' => "Sidgranskningsstatistik för varje namnrymd visas nedan, ''förutom'' omdirigeringssidor. Sidor behandlas som föråldrade om de har redigeringar i väntan på granskning; sidor betraktas som ''synkroniserade'' om det inte finns några redigeringar i väntan på granskning.",
	'validationstatistics-ns' => 'Namnrymd',
	'validationstatistics-total' => 'Sidor',
	'validationstatistics-stable' => 'Granskad',
	'validationstatistics-latest' => 'Synkad',
	'validationstatistics-synced' => 'Synkad/Granskad',
	'validationstatistics-old' => 'Föråldrad',
	'validationstatistics-utable' => 'Nedan listas {{PLURAL:$1|den flitigaste granskaren|de $1 flitigaste granskarna}} {{PLURAL:$2|den senaste timmen|de senaste $2 timmarna}}.',
	'validationstatistics-user' => 'Användare',
	'validationstatistics-reviews' => 'Granskningar',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'validationstatistics-ns' => 'Eneo la wiki',
	'validationstatistics-total' => 'Kurasa',
	'validationstatistics-old' => 'Zilizopitwa na wakati',
	'validationstatistics-user' => 'Mtumiaji',
);

/** Tamil (தமிழ்)
 * @author Kanags
 * @author TRYPPN
 * @author Ulmo
 */
$messages['ta'] = array(
	'validationstatistics' => 'பக்கத்தின் மறுபார்வை பற்றிய புள்ளிவிவரங்கள்',
	'validationstatistics-ns' => 'பெயர்வெளி',
	'validationstatistics-total' => 'பக்கங்கள்',
	'validationstatistics-stable' => 'மீள்பார்வையிடப்பட்டது',
	'validationstatistics-old' => 'காலாவதியானது',
	'validationstatistics-user' => 'பயனர்',
	'validationstatistics-reviews' => 'மதிப்பீடுகள்',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'validationstatistics' => 'పేజీ సమీక్షల గణాంకాలు',
	'validationstatistics-users' => "'''{{SITENAME}}'''లో ప్రస్తుతం '''[[Special:ListUsers/editor|$1]]'''{{PLURAL:$1| వాడుకరి|గురు వాడుకరులు}} [[{{MediaWiki:Validationpage}}|సంపాదకుల]] హక్కులతోనూ మరియు '''[[Special:ListUsers/reviewer|$2]]'''{{PLURAL:$2| వాడుకరి|గురు వాడుకరులు}}  [[{{MediaWiki:Validationpage}}|సమీక్షకుల]] హక్కులతోనూ ఉన్నారు.

సంపాదకులు మరియు సమీక్షకులు అంటే పేజీలకు కూర్పులను ఎప్పటికప్పుడు సరిచూడగలిగిన నిర్ధారిత వాడుకరులు.",
	'validationstatistics-table' => "ప్రతీ పేరుబరి యొక్క గణాంకాలు క్రింద చూపించాం, దారిమార్పు పేజీలని ''మినహాయించి''.",
	'validationstatistics-ns' => 'పేరుబరి',
	'validationstatistics-total' => 'పేజీలు',
	'validationstatistics-stable' => 'రివ్యూడ్',
	'validationstatistics-latest' => 'సింకుడు',
	'validationstatistics-synced' => 'సింకుడు/రివ్యూడ్',
	'validationstatistics-old' => 'పాతవి',
	'validationstatistics-utable' => 'ఇది గడచిన గంటలో {{PLURAL:$1|ఒక|$1గురు}} అత్యంత క్రియాశీల సమీక్షకుల యొక్క జాబితా.',
	'validationstatistics-user' => 'వాడుకరి',
	'validationstatistics-reviews' => 'సమీక్షలు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'validationstatistics-ns' => 'Espasu pájina nian',
	'validationstatistics-total' => 'Pájina sira',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'validationstatistics-ns' => 'เนมสเปซ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'validationstatistics' => 'Barlama statistikalary',
	'validationstatistics-users' => "'''{{SITENAME}}''' saýtynda häzirki wagtda [[{{MediaWiki:Validationpage}}|Redaktor]] hukugyna eýe '''[[Special:ListUsers/editor|$1]]''' sany {{PLURAL:$1|ulanyjy|ulanyjy}} hem-de [[{{MediaWiki:Validationpage}}|Gözden geçiriji]] hukugyna eýe '''[[Special:ListUsers/reviewer|$2]]''' sany {{PLURAL:$2|ulanyjy|ulanyjy}} bardyr.

Redaktorlar we Gözden Geçirijiler sahypalara barlag wersiýasyny belläp bilýän kesgitli ulanyjylardyr.",
	'validationstatistics-lastupdate' => '"Aşakdaky maglumat soňky gezek $1, $2 senesinde täzelendi"',
	'validationstatistics-table' => "Her bir at giňişligi üçin statistikalar aşakda görkezilýär, gönükdirme sahypalary ''degişli däl''.",
	'validationstatistics-ns' => 'At giňişligi',
	'validationstatistics-total' => 'Sahypalar',
	'validationstatistics-stable' => 'Gözden geçirilen',
	'validationstatistics-latest' => 'Sinhronizirlenen',
	'validationstatistics-synced' => 'Sinhronizirlenen/Gözden geçirilen',
	'validationstatistics-old' => 'Möwriti geçen',
	'validationstatistics-utable' => 'Aşakdaky sanaw soňky bir sagadyň dowamyndaky iň işjeň $1 gözden geçirijiniň sanawydyr.',
	'validationstatistics-user' => 'Ulanyjy',
	'validationstatistics-reviews' => 'Barlaglar',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'validationstatistics' => 'Estadistika ng pagsusuri ng pahina',
	'validationstatistics-users' => "Ang '''{{SITENAME}}''' ay  pangkasalukuyang may '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|tagagamit|mga tagagamit}} na may karapatan bilang [[{{MediaWiki:Validationpage}}|Patnugot]] .

Ang mga patnugot ay mga matatagal nang mga tagagamit na makakasipat ng mga pagbabago sa mga pahina.",
	'validationstatistics-lastupdate' => "''Ang sumusunod na dato ay huling naisapanahon noong $1 noong $2.''",
	'validationstatistics-pndtime' => "Mga pagbabagong nasuri na ng matatag na mga tagagamit ay itinuturing bilang ''nasuri na''.

Ang karaniwang pagkabinbin para sa [[Special:OldReviewedPages|mga pahinang may nakabinbing mga pahinang hindi pa nasusuri]] ay '''$1''';
ang pagkakabinbin ay sumusukat sa kung gaano katagal ang pinakalumang naghihintay na mga pagbabago ay lumipas na hindi pa nasusuri.",
	'validationstatistics-revtime' => "Ang karaniwang paghihintay para sa mga susuriing mga pagbabago ng ''mga tagagamit na hindi lumalagda'' ay '''$1'''; ang panggitnaan ay '''$2'''. 
$3",
	'validationstatistics-table' => "Ipinapakita sa ibaba ang mga estadistika ng pagsusuri ng pahina para sa bawat puwang ng pangalan, ''hindi kasama'' ang mga pahinang pinapapunta sa iba.  Ang mga pahina ay itinuturing bilang ''wala na sa panahon'' kapag mayroon silang mga pagbabago na naghihintay muling pagsusuri; ang mga pahina ay itinuturing na ''nakaalinsabay'' kapag walang mga pagbabagong naghihintay ng muling pagsusuri.",
	'validationstatistics-ns' => 'Espasyo ng pangalan',
	'validationstatistics-total' => 'Mga pahina',
	'validationstatistics-stable' => 'Nasuri na',
	'validationstatistics-latest' => 'Napagsabay na',
	'validationstatistics-synced' => 'Pinagsabay-sabay/Nasuri nang muli',
	'validationstatistics-old' => 'Wala na sa panahon (luma)',
	'validationstatistics-utable' => 'Nasa ibaba ang talaan ng {{PLURAL:$1|pinakamasiglang tagapagsuri|$1 pinakamasisiglang mga tagapagsuri}} sa loob ng huling {{PLURAL:$2|oras|$2 mga oras}}.',
	'validationstatistics-user' => 'Tagagamit',
	'validationstatistics-reviews' => 'Mga pagsusuri',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Manco Capac
 * @author Srhat
 * @author Szoszv
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'validationstatistics' => 'Sayfa inceleme istatistikleri',
	'validationstatistics-users' => "'''{{SITENAME}}''' sitesinde şuanda [[{{MediaWiki:Validationpage}}|Editör]] yetkisine sahip '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|kullanıcı|kullanıcı}} bulunmaktadır.

Editörler, sayfalara kontrol revizyonu atayabilen belirli kullanıcılardır.",
	'validationstatistics-lastupdate' => '"Aşağıdaki veri en son $1, $2 tarihinde güncellendi"',
	'validationstatistics-pndtime' => "Belirlenmiş kullanıcılar tarafından kontrol edilmiş değişiklikler gözden geçirilmiş olarak kabul edilir.

[[Special:OldReviewedPages|Gözden geçirilmeyi bekleyen sayfalar]] için ortalama gecikme süresi: '''$1'''.",
	'validationstatistics-revtime' => "''Giriş yapmamış anonim kullanıcılar'' tarafından yapılmış girişler için ortalama bekleme süresi '''$1'''; medyanı ise '''$2''' biçimindedir.
$3",
	'validationstatistics-table' => "İsim alanları için sayfa inceleme istatistikleri, yönlendirme sayfaları ''dahil olmadan''  aşağıda gösterilmiştir. Bekleyen değişiklik içeren sayfalar ''güncelliğini yitirmiş'', bekleyen değişiklik içermeyen sayfalar ''senkronize'' kabul edilir.",
	'validationstatistics-ns' => 'İsim alanı',
	'validationstatistics-total' => 'Sayfalar',
	'validationstatistics-stable' => 'Gözden geçirilmiş',
	'validationstatistics-latest' => 'Senkronize edildi',
	'validationstatistics-synced' => 'Eşitlenmiş/Gözden geçirilmiş',
	'validationstatistics-old' => 'Eski',
	'validationstatistics-utable' => 'Aşağıda {{PLURAL:$2|saatte|$2 saatte}} en çok inceleme yapan $1 kullanıcı listelenmektedir.',
	'validationstatistics-user' => 'Kullanıcı',
	'validationstatistics-reviews' => 'İncelemeler',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author Alex Khimich
 * @author Dim Grits
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'validationstatistics' => 'Статистика рецензувань сторінок',
	'validationstatistics-users' => "У проекті '''{{SITENAME}}''' зараз '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|користувач має|користувачі мають|користувачів мають}} права [[{{MediaWiki:Validationpage}}|«редактор»]].

«Редактори» — визначені користувачі, що мають можливість робити вибіркову перевірку конкретних версій сторінок.",
	'validationstatistics-lastupdate' => "''Наступні дані востаннє оновлювались $1 о $2.''",
	'validationstatistics-pndtime' => "Правки, які були перевірені встановленими користувачами вважаються ''перевіреними''

Середня затримка для [[Special:OldReviewedPages|сторінок з правками, що очікують на перевірку]] становить '''$1'''.
Цей параметр відображає як довго неперевірена версія залишається без уваги перевіряльників.",
	'validationstatistics-revtime' => "Середній час очікування на рецензування для редагувань ''користувачів, що не увійшли до системи'' '''$1'''; медіана — '''$2'''. 
$3",
	'validationstatistics-table' => "Статистика рецензувань сторінок для кожного простору назв показана нижче, ''за виключенням'' сторінок перенаправлень. Сторінки вважаються «застарілими», якщо вони не мають неперевірених редагувань, сторінки вважаються «сінхронізованими», якщо вони не мають редагувань, що очікують на перевірку.",
	'validationstatistics-ns' => 'Простір назв',
	'validationstatistics-total' => 'Сторінок',
	'validationstatistics-stable' => 'Перевірені',
	'validationstatistics-latest' => 'Синхронізовані',
	'validationstatistics-synced' => 'Повторно перевірені',
	'validationstatistics-old' => 'Застарілі',
	'validationstatistics-utable' => 'Нижче представлено {{PLURAL:$1|найбільш активного редактора|список $1 найбільш активних редакторів}} за {{PLURAL:$2|останню $2 годину|останні $2 години|останніх $2 годин}}.',
	'validationstatistics-user' => 'Користувач',
	'validationstatistics-reviews' => 'Перевірок',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'validationstatistics' => 'Statìsteghe de revision',
	'validationstatistics-users' => "'''{{SITENAME}}''' el gà atualmente '''[[Special:ListUsers/editor|$1]]'''  {{PLURAL:$1|utente|utenti}} con diriti de [[{{MediaWiki:Validationpage}}|revisor]].

I revisori i xe utenti che pode verificar le revision de le pagine.",
	'validationstatistics-lastupdate' => "''Sti dati i xe agiornà al $1 a le $2.''",
	'validationstatistics-pndtime' => "Le modifiche che xe stà controlà da utenti afidabili le xe considerà verificà.

El ritardo medio par [[Special:OldReviewedPages|le pagine con canbiamenti in atesa]] el xe '''$1'''.
Ste pagine le xe considerà ''obsolete''. Le se considera ''agiornà'' se no ghe xe canbiamenti in atesa.",
	'validationstatistics-revtime' => "El tenpo medio da spetare par controlar le modifiche fate da ''utenti anonimi'' xe '''$1'''; la media xe '''$2'''.",
	'validationstatistics-table' => "Qua soto se cata le statìsteghe de revision par ogni namespace, ''escluse'' le pagine de redirect.",
	'validationstatistics-ns' => 'Namespace',
	'validationstatistics-total' => 'Pagine',
	'validationstatistics-stable' => 'Ricontrolà',
	'validationstatistics-latest' => 'Sincronizà',
	'validationstatistics-synced' => 'Sincronizà/Ricontrolà',
	'validationstatistics-old' => 'Mia ajornà',
	'validationstatistics-utable' => "Sto qua xe l'elenco dei primi $1 revisori ne l'ultima ora.",
	'validationstatistics-user' => 'Utente',
	'validationstatistics-reviews' => 'Revisioni',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'validationstatistics' => 'Lehtpoliden kodvindoiden statistik',
	'validationstatistics-users' => "{{SITENAME}}-projektas nügüd' '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|kävutajal|kävutajil}} 
oma [[{{MediaWiki:Validationpage}}|«redaktoran»]] oiktused.

Redaktorad oma mugomad kävutajad, kudambil om oiktuz kodvda valitud lehtseiden konkretižed versijad.",
	'validationstatistics-lastupdate' => '"Mugoižed andmused udestadihe $1, aig om $2."',
	'validationstatistics-pndtime' => "Toižetused, kudambad oma znamoinu märitud ühtnijad, lugedas \"kodvdud\".

Keskmäine pidestuz [[Special:OldReviewedPages|lehtpoliden kodvmatomiden toižetusidenke täht]] om '''\$1'''. Nece parametr ozutab, min aikte jäl'gmäine kodvmatoi versii jäb kodvijoiden tarkuseta.",
	'validationstatistics-revtime' => "Keiskmäine kodvindanaig \"tundmatomiden ühtnijoiden\" toižetusiden täht om '''\$1'''; median om '''\$2'''.
\$3",
	'validationstatistics-table' => "Alemba om kodvindan statistikad kaikuččen nimiavarusen täht. Läbioigendad oma heittud neciš statistikaspäi.
''Vanhtunuzikš'' kuctas lehtpolid, kudambiš om kodvmatomid toižetusid.
Ku lehtpolil ei ole kodvmatomid toižetusid, ka ne kucuse ''sinhroniziruidud''.",
	'validationstatistics-ns' => 'Nimiavaruz',
	'validationstatistics-total' => "Lehtpol't",
	'validationstatistics-stable' => 'Kodvdud',
	'validationstatistics-latest' => 'Tantoi kodvdud',
	'validationstatistics-synced' => 'Kodvdud udes',
	'validationstatistics-old' => 'Vanhtunuded',
	'validationstatistics-utable' => "Alemba om anttud nimikirjutez, kus {{PLURAL:$1|om $1 kaikiš aktivižemb arvostelii|oma $1 kaikiš aktivižembad arvostelijad}} {{PLURAL:$2|jäl'gmäižes časus|$2 jäl'gmäižiš časuiš}}.",
	'validationstatistics-user' => 'Kävutai',
	'validationstatistics-reviews' => 'Redakcijad',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'validationstatistics' => 'Thống kê duyệt trang',
	'validationstatistics-users' => "Hiện nay, có '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|thành viên|thành viên}} tại '''{{SITENAME}}''' có quyền [[{{MediaWiki:Validationpage}}|Biên tập viên]].

Biên tập viên là người dùng có kinh nghiệm có khả năng kiểm tra nhanh các thay đổi tại trang.",
	'validationstatistics-lastupdate' => "''Các dữ liệu sau được cập nhật lần cuối vào $1 lúc $2.''",
	'validationstatistics-pndtime' => "Những sửa đổi được ''duyệt'' khi được người dùng có kinh nghiệm xem qua.

[[Special:OldReviewedPages|Các trang có sửa đổi đang chờ duyệt]] đã chờ đợi '''$1''' trung bình, tính theo sửa đổi cũ nhất đang chờ duyệt.",
	'validationstatistics-revtime' => "Những sửa đổi của ''người dùng vô danh'' phải chờ đợi '''$1''' trung bình; thời gian trung vị là '''$2'''.
$3",
	'validationstatistics-table' => "Đây có thống kê duyệt trang về các không gian tên, ''trừ'' các trang đổi hướng. Mỗi trang ''lỗi thời'' có sửa đổi đang chờ duyệt, còn các trang ''cập nhật'' đã được duyệt tới sửa đổi gần đây nhất.",
	'validationstatistics-ns' => 'Không gian tên',
	'validationstatistics-total' => 'Số trang',
	'validationstatistics-stable' => 'Được duyệt',
	'validationstatistics-latest' => 'Đã đồng bộ',
	'validationstatistics-synced' => 'Cập nhật/Duyệt',
	'validationstatistics-old' => 'Lỗi thời',
	'validationstatistics-utable' => 'Đây là {{PLURAL:$1|người duyệt|danh sách $1 người duyệt}} tích cực nhất trong {{PLURAL:$2|giờ|$2 giờ}} qua.',
	'validationstatistics-user' => 'Người dùng',
	'validationstatistics-reviews' => 'Bản duyệt',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'validationstatistics-ns' => 'Nemaspad',
	'validationstatistics-total' => 'Pads',
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'validationstatistics-ns' => 'נאמענטייל',
	'validationstatistics-total' => 'בלעטער',
	'validationstatistics-old' => 'פֿאַרעלטערט',
	'validationstatistics-user' => 'באַניצער',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Gaoxuewei
 * @author Hydra
 * @author PhiLiP
 * @author Xiaomingyan
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'validationstatistics' => '页面复审统计信息',
	'validationstatistics-users' => "'''{{SITENAME}}'''目前有'''[[Special:ListUsers/editor|$1]]'''{{PLURAL:$1|个|个}}用户具有[[{{MediaWiki:Validationpage}}|编者]]权限。

编者是可以对页面修订作抽样检查的已确认用户。",
	'validationstatistics-lastupdate' => "''下列数据最后更新于$1$2。''",
	'validationstatistics-pndtime' => "已确认用户已经检查这些编辑，并认为它们是''已复审''的。

[[Special:OldReviewedPages|含有待复审编辑页面]]的平均复审延迟是'''$1'''；这一延迟可以确定最早待复审编辑会有多久处于未复审状态。",
	'validationstatistics-revtime' => "未登录用户等待编辑复审的平均时间为'''$1'''，中位数为'''$2'''。$3",
	'validationstatistics-table' => "每个名字空间的页面复审统计信息如下所示，其中'''不包括'''重定向页。含有待复审编辑的页面会被标记为“已过期”，不存在待复审编辑的页面会被标记为“已同步”。",
	'validationstatistics-ns' => '名字空间',
	'validationstatistics-total' => '页面',
	'validationstatistics-stable' => '已复审',
	'validationstatistics-latest' => '已同步',
	'validationstatistics-synced' => '已同步／已复审',
	'validationstatistics-old' => '已过期',
	'validationstatistics-utable' => '下面列出了最近{{PLURAL:$2|一小时|$2小时}}内{{PLURAL:$1|最活跃的复审员|最活跃的$1位复审员}}。',
	'validationstatistics-user' => '用户',
	'validationstatistics-reviews' => '复审',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Mark85296341
 * @author Tomchiukc
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'validationstatistics' => '審核統計',
	'validationstatistics-users' => "'''{{SITENAME}}'''現時有'''[[Special:ListUsers/editor|$1]]'''{{PLURAL:$1|個|個}}用戶具有[[{{MediaWiki:Validationpage}}|編輯]]的權限。

編輯及審定皆為已確認的用戶，並可以檢查各頁面的修定。",
	'validationstatistics-lastupdate' => "''以下數據最後更新於$1在$2。''",
	'validationstatistics-pndtime' => "已確認用戶已經檢查這些編輯，並認為它們是''已復審''的。

[[Special:OldReviewedPages|含有待複審編輯頁面]]的平均複審延遲是'''$1'''；這一延遲可以確定最早待複審編輯會有多久處於未復審狀態。",
	'validationstatistics-revtime' => "平均等待''未登入用戶''的編輯審核是'''$1'''；中位數是'''$2 '''。 
$3",
	'validationstatistics-table' => "每個名字空間的頁面複審統計信息如下所示，其中'''不包括'''重定向頁。含有待複審編輯的頁面會被標記為“已過期”，不存在待複審編輯的頁面會被標記為“已同步”。",
	'validationstatistics-ns' => '名稱空間',
	'validationstatistics-total' => '頁面',
	'validationstatistics-stable' => '已復審',
	'validationstatistics-latest' => '已同步',
	'validationstatistics-synced' => '已同步/已復審',
	'validationstatistics-old' => '已過期',
	'validationstatistics-utable' => '下面列出了最近{{PLURAL:$2|一小時|$2小時}}內{{PLURAL:$1|最活躍的複審員|最活躍的$1位複審員}}。',
	'validationstatistics-user' => '用戶',
	'validationstatistics-reviews' => '審核者',
);

