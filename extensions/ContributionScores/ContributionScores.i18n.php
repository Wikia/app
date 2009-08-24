<?php
#coding: utf-8
/**
 * Internationalisation file for extension ContributionScores.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'contributionscores'                 => 'Contribution scores',
	'contributionscores-desc'            => 'Polls the wiki database for highest [[Special:ContributionScores|user contribution volume]]',
	'contributionscores-info'            => "Scores are calculated as follows:
*One (1) point for each unique page edited
*Square root of (total edits made) - (total unique pages) * 2
Scores calculated in this manner weight edit diversity over edit volume.
Basically, this score measures primarily unique pages edited, with consideration for high edit volume - assumed to be a higher quality page.",
	'contributionscores-top'             => '(Top $1)',
	'contributionscores-days'            => 'Last $1 days',
	'contributionscores-allrevisions'    => 'All revisions',
	'contributionscores-score'           => 'Score',
	'contributionscores-pages'           => 'Pages',
	'contributionscores-changes'         => 'Changes',
	'contributionscores-username'        => 'Username',
	'contributionscores-invalidusername' => 'Invalid username',
	'contributionscores-invalidmetric'   => 'Invalid metric',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author JtFuruhata
 * @author Kalan
 * @author Purodha
 */
$messages['qqq'] = array(
	'contributionscores-desc' => 'Extension description displayed on [[Special:Version]].',
	'contributionscores-info' => 'see http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/ContributionScores/ContributionScores_body.php?view=markup

:COUNT(DISTINCT rev_page) AS page_count
:COUNT(rev_id) AS rev_count
:page_count+SQRT(rev_count-page_count)*2 AS wiki_rank',
	'contributionscores-allrevisions' => 'Used as a header of [[Special:ContributionScores]]',
	'contributionscores-pages' => '{{Identical|Pages}}',
	'contributionscores-username' => '{{Identical|Username}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'contributionscores-username' => 'Asa',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'contributionscores-username' => 'Matahigoa he tagata',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'contributionscores' => 'Punte bygedra',
	'contributionscores-desc' => "Gee 'n oorsig van [[Special:ContributionScores|gebruikers met die meeste bydraes]] in die wiki",
	'contributionscores-info' => 'Punte word as volg bereken:
*Een (1) punt vir elke bladsy gewysig
*Wortel van (totale aantal wysigings) - (totale aantal unieke bladsye) * 2
Punte wat op die manier bereken word weeg die verskeidenheid van bladsye gewysig oor die aantal wysigings. Die punte meet hoofsaaklik unieke bladsye gewysig, met inagneming van hoë volume wysigings - wat veronderstel word om van hoër kwaliteit te wees.',
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Laaste $1 dae',
	'contributionscores-allrevisions' => 'Alle weergawes',
	'contributionscores-score' => 'Punte',
	'contributionscores-pages' => 'Bladsye',
	'contributionscores-changes' => 'Wysigings',
	'contributionscores-username' => 'Gebruikersnaam',
	'contributionscores-invalidusername' => 'Ongeldige gebruikersnaam',
	'contributionscores-invalidmetric' => 'Ongeldige eenheid',
);

/** Arabic (العربية)
 * @author Meno25
 * @author ترجمان05
 */
$messages['ar'] = array(
	'contributionscores' => 'نتائج المساهمات',
	'contributionscores-desc' => 'يسحب قاعدة بيانات الويكي لأعلى [[Special:ContributionScores|حجم لمساهمات المستخدم]]',
	'contributionscores-info' => 'النتائج تحسب كالتالي:
*1 نقطة لكل صفحة فريدة تحرر
*الجذر التربيعي ل(عدد التعديلات الكلية) - (عدد الصفحات الفريدة الكلية) * 2
النتائج المحسوبة بهذه الطريقة توزن انتثار التعديلات على حجم التعديلات.  أساسا، هذه النتيجة تقيس بشكل أساسي الصفحات الفريدة المحررة، مع الأخذ في الاعتبار أحجام التعديل الكبيرة - تفترض أنها تكون صفحة بجودة أعلى.',
	'contributionscores-top' => '(أعلى $1)',
	'contributionscores-days' => 'آخر $1 يوم',
	'contributionscores-allrevisions' => 'كل المراجعات',
	'contributionscores-score' => 'النتيجة',
	'contributionscores-pages' => 'الصفحات',
	'contributionscores-changes' => 'التغييرات',
	'contributionscores-username' => 'اسم المستخدم',
	'contributionscores-invalidusername' => 'اسم المستخدم غير صحيح',
	'contributionscores-invalidmetric' => 'المتري غير صحيح',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'contributionscores' => 'نتائج المساهمات',
	'contributionscores-desc' => 'يسحب قاعدة بيانات الويكى لأعلى [[Special:ContributionScores|حجم لمساهمات المستخدم]]',
	'contributionscores-info' => 'النتائج تحسب كالتالي:
*1 نقطة لكل صفحة فريدة تحرر
*الجذر التربيعى ل(عدد التعديلات الكلية) - (عدد الصفحات الفريدة الكلية) * 2
النتائج المحسوبة بهذه الطريقة توزن انتثار التعديلات على حجم التعديلات.  أساسا، هذه النتيجة تقيس بشكل أساسى الصفحات الفريدة المحررة، مع الأخذ فى الاعتبار أحجام التعديل الكبيرة - تفترض أنها تكون صفحة بجودة أعلى.',
	'contributionscores-top' => '(أعلى $1)',
	'contributionscores-days' => 'آخر $1 يوم',
	'contributionscores-allrevisions' => 'كل المراجعات',
	'contributionscores-score' => 'النتيجة',
	'contributionscores-pages' => 'الصفحات',
	'contributionscores-changes' => 'التغييرات',
	'contributionscores-username' => 'اسم المستخدم',
	'contributionscores-invalidusername' => 'اسم المستخدم غير صحيح',
	'contributionscores-invalidmetric' => 'المترى غير صحيح',
);

/** Kotava (Kotava)
 * @author Sab
 */
$messages['avk'] = array(
	'contributionscores' => 'Weberajorist',
	'contributionscores-top' => '(Taneaf $1)',
	'contributionscores-days' => 'Ironokaf $1 viel',
	'contributionscores-allrevisions' => 'Betakseem',
	'contributionscores-score' => 'Jorist',
	'contributionscores-pages' => 'Bu',
	'contributionscores-changes' => 'Betaks',
	'contributionscores-username' => 'Favesikyolt',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'contributionscores-username' => 'Імя ўдзельніка',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'contributionscores' => 'Потребителска класация',
	'contributionscores-top' => '(Най-добрите $1)',
	'contributionscores-days' => 'Последните $1 дни',
	'contributionscores-allrevisions' => 'Всички редакции',
	'contributionscores-score' => 'Точки',
	'contributionscores-pages' => 'Страници',
	'contributionscores-changes' => 'Редакции',
	'contributionscores-username' => 'Потребител',
	'contributionscores-invalidusername' => 'Невалидно потребителско име',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'contributionscores' => 'Rezultat doprinosa',
	'contributionscores-desc' => 'Upit u wiki bazu podataka za najveći [[Special:ContributionScores|količinski korisnički doprinos]]',
	'contributionscores-info' => 'Rezultati se računaju na slijedeći naćin:
*Jedan (1) bod za svaku pojedinu stranicu koja se uredi
*Drugi korijen od (ukupno načinjenih promjena) - (ukupno pojedinih stranica) * 2
Rezultati koji se dobiju na ovaj način naglašavaju raznolikost uređivanja više od količine uređivanja.
U osnovi, ovaj rezultat mjeri naročito broj uređivanja pojedinačnih stranica, sa utjecajem velike količine uređivanja - smatra se da utječe na bolji kvalitet stranice.',
	'contributionscores-top' => '(Najboljih $1)',
	'contributionscores-days' => '{{PLURAL:$1|Zadnji $1 dan|Zadnja $1 dana|Zadnjih $1 dana}}',
	'contributionscores-allrevisions' => 'Sve revizije',
	'contributionscores-score' => 'Rezultat',
	'contributionscores-pages' => 'Stranice',
	'contributionscores-changes' => 'Izmjene',
	'contributionscores-username' => 'Korisničko ime',
	'contributionscores-invalidusername' => 'Nevaljano korisničko ime',
	'contributionscores-invalidmetric' => 'Nevaljana mjera',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author SMP
 */
$messages['ca'] = array(
	'contributionscores' => 'Punts de contribució',
	'contributionscores-desc' => 'Valora les edicions en cerca dels [[Special:ContributionScores|usuaris amb més volum de contribucions]]',
	'contributionscores-info' => "La puntuació es calcula de la manera següent:
* Un punt per cada pàgina diferent editada, més
*El doble de l'arrel quadrada de: el total d'edicions fetes menys el total de pàgines diferents editades.
Aquesta fórmula premia la diversitat d'edicions més que no el seu volum.
Bàsicament, mesura el nombre de pàgines diferents editades, amb consideració per els alts volums d'edició considerats de pàgines de més qualitat.",
	'contributionscores-top' => '($1 millors)',
	'contributionscores-days' => 'Últims $1 dies',
	'contributionscores-allrevisions' => 'Totes les revisions',
	'contributionscores-score' => 'Puntuació',
	'contributionscores-pages' => 'Pàgines',
	'contributionscores-changes' => 'Canvis',
	'contributionscores-username' => "Nom d'usuari",
	'contributionscores-invalidusername' => "Nom d'usuari no vàlid",
	'contributionscores-invalidmetric' => 'Mètrica invàlida',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'contributionscores' => 'Skóre příspěvků',
	'contributionscores-desc' => 'Zjišťuje největší [[Special:ContributionScores|objem uživatelských příspěvků]] z databáze wiki',
	'contributionscores-info' => 'Skóre se počítá následovně:
* 1 bod za každou jedinečnou stránku, kterou uživatel upravoval
* Odmocnina z (celkem úprav) - (celkem jedinečných stránek) * 2
Skóre vypočítané tímto způsobem upřednostňuje rozmanitost úprav více než počet úprav.
V podstatě toto skóre měří hlavně počet upravovaných jedinečných stránek s přihlédnutím na velký počet úprav, což se pokládá za stránku vyšší kvality.',
	'contributionscores-top' => '($1 nejvyšších)',
	'contributionscores-days' => '{{PLURAL:$1|Poslední den|Poslední $1 dny|Posledních $1 dnů}}',
	'contributionscores-allrevisions' => 'Všechny revize',
	'contributionscores-score' => 'Skóre',
	'contributionscores-pages' => 'Stránky',
	'contributionscores-changes' => 'Změny',
	'contributionscores-username' => 'Uživatelské jméno',
	'contributionscores-invalidusername' => 'Neplatné uživatelské jméno',
	'contributionscores-invalidmetric' => 'Neplatná metrika',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'contributionscores-pages' => 'страни́цѧ',
	'contributionscores-username' => 'по́льꙃєватєлꙗ и́мѧ',
);

/** Danish (Dansk) */
$messages['da'] = array(
	'contributionscores-pages' => 'Sider',
	'contributionscores-username' => 'Brugernavn',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'contributionscores' => 'Benutzerbeiträge bewerten',
	'contributionscores-desc' => 'Abfrage der Wiki-Datenbank nach der Anzahl der [[Special:ContributionScores|Benutzerbeiträge]]',
	'contributionscores-info' => 'Bewertungsschema:
*1 Punkt für jede bearbeitete Seite
*Quadratwurzel aller (Bearbeitungen) - (Summe der bearbeiteten Seiten) * 2
Bewertungen auf dieser Grundlage wichten die Vielfalt der Beiträge höher als das Beitragsvolumen.',
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Letzte $1 Tage',
	'contributionscores-allrevisions' => 'Alle Versionen',
	'contributionscores-score' => 'Bewertung',
	'contributionscores-pages' => 'Seiten',
	'contributionscores-changes' => 'Änderungen',
	'contributionscores-username' => 'Benutzername',
	'contributionscores-invalidusername' => 'Ungültiger Benutzername',
	'contributionscores-invalidmetric' => 'Ungültige Metrik',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'contributionscores' => 'Pśinoski pógódnośiś',
	'contributionscores-desc' => 'Napšašujo se wikijoweje datoweje banki za nejwušeju [[Special:ContributionScores|licbu wužywarskich pśinoskow]]',
	'contributionscores-info' => 'Licba dypkow wulicyjo se kaž slědujo:
*Jaden (1) dypk za kuždy wobźěłany bok
*Kwadratny kórjeń (wšych cynjonych změnow) - (cełkowna licba bokow) * 2
Licba dypkow, kótaraž wulicyjo se za tym nałogom, gódnośi wšakosć změnow wušej ako licbu změnow.
Zasadnje tś ta licba dypkow měri pśedewšym wobźěłane změny pód źiwanim na wusoku licbu změnow - 
pód wuměnjenim až to by było bok z wušeju kwalitu.',
	'contributionscores-top' => '({{PLURAL:$1|Nejlěpšy $1|Nejlěpšej $1|Nejlěpše $1|Nejlěpšych $1}})',
	'contributionscores-days' => '{{PLURAL:$1|Slědny źeń|Slědnej $1 dnja|Slědne $1 dny|Slědnych $1 dnjow}}',
	'contributionscores-allrevisions' => 'Wše wersije',
	'contributionscores-score' => 'Pógódnośenje',
	'contributionscores-pages' => 'Boki',
	'contributionscores-changes' => 'Změny',
	'contributionscores-username' => 'Wužywarske mě',
	'contributionscores-invalidusername' => 'Njepłaśiwe wužywarske mě',
	'contributionscores-invalidmetric' => 'Njepłaśiwa metrika',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'contributionscores' => 'Αποτελέσματα Συνεισφοράς',
	'contributionscores-top' => '(Πρώτοι $1)',
	'contributionscores-days' => 'Τελευταίες $1 Ημέρες',
	'contributionscores-score' => 'Βαθμολογία',
	'contributionscores-pages' => 'Σελίδες',
	'contributionscores-changes' => 'Αλλαγές',
	'contributionscores-username' => 'Όνομα χρήστη',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'contributionscores' => 'Poentaro de Kontribuoj',
	'contributionscores-desc' => 'Informmendas la vikian datumbazon por la plej [[Special:ContributionScores|oftaj kontribuantoj]]',
	'contributionscores-info' => 'Poentaroj estas donataj jene:
*Unu (1) poento por ĉiu unika paĝo redaktata
*Kvadrata Radiko de (Tutaj Faritaj Redaktoj) - (Tutaj Unikaj Paĝoj) * 2
Poentaroj kalkulitaj laŭ ĉi tiu maniero pezos redaktan diversecon super redaktan volumon.
Baze, ĉi tiu poentaro mezuras ĉefe unikajn paĝojn redaktitajn, kun konsidero por altaj redakto-volumon - supozita esti pli altkvalita paĝo.',
	'contributionscores-top' => '(Plej alta $1)',
	'contributionscores-days' => 'Lastaj $1 Tagoj',
	'contributionscores-allrevisions' => 'Ĉiuj Revizioj',
	'contributionscores-score' => 'Poentaro',
	'contributionscores-pages' => 'Paĝoj',
	'contributionscores-changes' => 'Ŝanĝoj',
	'contributionscores-username' => 'Salutnomo',
	'contributionscores-invalidusername' => 'Nevalida salutnomo',
	'contributionscores-invalidmetric' => 'Nevalida parametro',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'contributionscores' => 'Puntuaciones por contribuir',
	'contributionscores-info' => 'Las puntuaciones son calculadas siguiendo:
*1 punto por cada página única editada
*Raíz cuadrada de (Ediciones totales efectuadas) - (Páginas totales únicas) x 2
Las puntuaciones son calculadas de esta manera considerando la diversidad sobre el volumen de edición. Básicamente, esta puntuación mide fundamentalmente las páginas únicas editadas, considerando que un alto volumen de edición supone que es un artículo de mayor calidad.',
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Últimos $1 días',
	'contributionscores-allrevisions' => 'Estadísticas globales',
	'contributionscores-pages' => 'Páginas',
	'contributionscores-changes' => 'Cambios',
	'contributionscores-username' => 'Nombre de usuario',
	'contributionscores-invalidusername' => 'Nombre de usuario no válido',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'contributionscores-days' => 'Úrtimus $1 dias',
);

/** Persian (فارسی)
 * @author Huji
 * @author Tofighi
 */
$messages['fa'] = array(
	'contributionscores' => 'امتیاز مشارکت',
	'contributionscores-desc' => 'سرشماری پایگاه داده ویکی برای بالاترین [[Special:ContributionScores|حجم مشارکت کاربر]]',
	'contributionscores-info' => 'امتیازات به شیوه زیر محاسبه می‌شود:
*یک (1) امتیاز برای هر صفحه یکتای ویرایش شده
جذر همه ویرایش‌ها (همه ویرایش‌های انجام‌شده) - (همه صفحه‌ها یکتا) * 2

محاسبه امتیازات در این حالت وزن گوناگونی ویرایشها بر حجم ویرایشها را می سنجد.
براین اساس، این امتیاز میزان صفحه‌ها ویرایش شده را با توجه به حجم ویرایش با فرض صفحه با کیفیت تر می سنجد.',
	'contributionscores-top' => '($1 برتر)',
	'contributionscores-days' => '$1 روز گذشته',
	'contributionscores-allrevisions' => 'همه نسخه‌ها',
	'contributionscores-score' => 'امتیاز',
	'contributionscores-pages' => 'صفحه‌ها',
	'contributionscores-changes' => 'تغییرات',
	'contributionscores-username' => 'نام کاربری',
	'contributionscores-invalidusername' => 'نام کاربری نامعتبر',
	'contributionscores-invalidmetric' => 'متریک نامعتبر',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'contributionscores' => 'Muokkauspisteet',
	'contributionscores-info' => 'Pisteet lasketaan seuraavalla kaavalla:
* Yksi piste jokaisesta muokatusta sivusta
* Neliöjuuri (muokkausten määrä) - (muokatut sivut) * 2

Näin laskettuna pisteet painottavat monipuolisuutta määrän sijaan. Käytännössä pisteet mittaavat muokattujen sivujen määrää, ottaen huomioon muutosten suuren määrän.',
	'contributionscores-top' => '(top $1)',
	'contributionscores-days' => '$1 päivän ajalta',
	'contributionscores-allrevisions' => 'Kaikki muutokset',
	'contributionscores-score' => 'Pisteet',
	'contributionscores-pages' => 'Sivuja',
	'contributionscores-changes' => 'Muutoksia',
	'contributionscores-username' => 'Käyttäjä',
	'contributionscores-invalidusername' => 'Virheellinen käyttäjätunnus',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'contributionscores' => 'Pointage des contributions',
	'contributionscores-desc' => 'Scrute la base de données wiki pour les [[Special:ContributionScores|utilisateurs contribuant le plus]]',
	'contributionscores-info' => 'Les pointages sont calculés de la manière suivante :
* 1 point pour chaque page modifiée ;
* racine carrée de (nombre de modifications) - (nombre de pages différentes) * 2.

De cette façon, les pointages ainsi calculés privilégient la diversité par rapport à la quantité. Écrits d’une autre façon, ils s’intéressent principalement à indiquer le nombre de modifications des pages différentes, puis leur nombre total.',
	'contributionscores-top' => '(Les $1 meilleures)',
	'contributionscores-days' => 'Dans {{PLURAL:$1|le dernier jour|les derniers $1 jours}}',
	'contributionscores-allrevisions' => 'Toutes les révisions',
	'contributionscores-score' => 'Pointage',
	'contributionscores-pages' => 'Pages',
	'contributionscores-changes' => 'Modifications',
	'contributionscores-username' => 'Pseudonyme',
	'contributionscores-invalidusername' => 'Nom d’utilisateur invalide',
	'contributionscores-invalidmetric' => 'Métrie incorrecte',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'contributionscores-username' => 'Meidoggernamme',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'contributionscores' => 'Puntuación das contribucións',
	'contributionscores-desc' => 'Escruta a base de datos do wiki para ver os maiores [[Special:ContributionScores|volumes de contribucións dos usuarios]]',
	'contributionscores-info' => 'As puntuacións calcúlanse do seguinte xeito:
*Un (1) punto por cada páxina única editada
*Raíz cadrada de (Total de edicións feitas) - (Total de páxinas únicas) * 2
As puntuacións calculadas deste xeito favorecen a diversidade de edicións sobre o volume.
Basicamente, esta puntuación mide, en principio, as páxinas únicas editadas, tendo en conta un volume alto de edicións (co que se asume que é unha páxina de calidade superior).',
	'contributionscores-top' => '(os $1 que máis)',
	'contributionscores-days' => 'Os últimos $1 días',
	'contributionscores-allrevisions' => 'Todas as revisións',
	'contributionscores-score' => 'Puntuación',
	'contributionscores-pages' => 'Páxinas',
	'contributionscores-changes' => 'Cambios',
	'contributionscores-username' => 'Nome do usuario',
	'contributionscores-invalidusername' => 'Nome de usuario inválido',
	'contributionscores-invalidmetric' => 'Métrica inválida',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'contributionscores-pages' => 'Δέλτοι',
	'contributionscores-username' => 'Ὄνομα χρωμένου',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'contributionscores' => 'Aazahl vu dr Benutzerbyyträg',
	'contributionscores-desc' => 'Abfrog vu dr Wiki-Datebank no dr Aazahl vu dr [[Special:ContributionScores|Benutzerbyyträg]]',
	'contributionscores-info' => 'Bewärtigsschema:
*1 Punkt fir jedi bearbeiteti Syte
*Quadratwurzle vu allene (Bearbeitige) - (Summe vu dr bearbeitete Syte) * 2
Bewärtigen uf däre Grundlag gän dr Viifalt vu dr Byyträg e hecher Gwicht wie dr Aazahl vu dr Änderige.',
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Letschti $1 Täg',
	'contributionscores-allrevisions' => 'Alli Versione',
	'contributionscores-score' => 'Wärt',
	'contributionscores-pages' => 'Syte',
	'contributionscores-changes' => 'Änderige',
	'contributionscores-username' => 'Benutzername',
	'contributionscores-invalidusername' => 'Nit giltige Benutzername',
	'contributionscores-invalidmetric' => 'Nit giltigi Metrik',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'contributionscores-score' => 'Skensh',
	'contributionscores-pages' => 'Duillagyn',
	'contributionscores-username' => 'Ennym yn ymmydeyr',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'contributionscores-username' => 'Yung-fu-miàng',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'contributionscores' => 'ניקוד תורמים',
	'contributionscores-desc' => 'בדיקת בסיס הנתונים של הוויקי למציאת [[Special:ContributionScores|נפח תרומת המשתמשים]] הגבוה ביותר',
	'contributionscores-info' => 'הנקודות מחושבות באופן הבא:
*נקודה אחת (1) עבור כל דף ייחודי שנערך
*שורש של (מספר העריכות הכללי) - (מספר הדפים הייחודיים) * 2
הנקודות המחושבות באופן זה מעניקות חשיבות גבוהה יותר לדפים הייחודיים שנערכים על פני כמות העריכות.
ברמת העיקרון, ניקוד זה מודד בעיקר את מספר הדפים הייחודיים שנערכו, עם התחשבות בכמות עריכות גדולה - מה שנחשב לדף יותר איכותי.',
	'contributionscores-top' => '($1 הגבוהים ביותר)',
	'contributionscores-days' => 'ב־$1 הימים האחרונים',
	'contributionscores-allrevisions' => 'כל הגרסאות',
	'contributionscores-score' => 'ניקוד',
	'contributionscores-pages' => 'דפים',
	'contributionscores-changes' => 'שינויים',
	'contributionscores-username' => 'שם משתמש',
	'contributionscores-invalidusername' => 'שם משתמש בלתי תקין',
	'contributionscores-invalidmetric' => 'מדידה בלתי תקינה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'contributionscores' => 'योगदान संख्या',
	'contributionscores-desc' => '[[Special:ContributionScores|सदस्य योगदान संख्या]]के अनुसार विकि डाटाबेस दर्शाता हैं',
	'contributionscores-top' => '(पहले $1)',
	'contributionscores-days' => 'आखिरी $1 दिन',
	'contributionscores-allrevisions' => 'सभी अवतरण',
	'contributionscores-score' => 'गुण',
	'contributionscores-pages' => 'पन्ने',
	'contributionscores-changes' => 'बदलाव',
	'contributionscores-username' => 'सदस्यनाम',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'contributionscores-username' => 'Ngalan sang Manog-gamit',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'contributionscores' => 'Najbolji suradnici',
	'contributionscores-desc' => 'Šalje upit bazi podataka za najveći [[Special:ContributionScores|broj suradničkih doprinosa]]',
	'contributionscores-info' => 'Rezultat se dobiva kao suma slijedećih stavki:
*1 bod za svaku stranicu koju ste uređivali
* (kvadratni) korijen iz (broja ukupnih uređivanja) - (broja stranica koje ste uređivali) * 2

Rezultat dobiven na ovaj način daje veću težinu broju uređivanja različitih stranica nego ukupnom broju uređivanja. U osnovi, ovakav rezultat mjeri prvenstveno broj različitih stranica koje ste uređivali, uzimajući u obzir broj uređivanja, jer veći broj uređivanja na nekom članku daje kvalitetniji članak.',
	'contributionscores-top' => '(Najboljih $1)',
	'contributionscores-days' => 'Zadnjih $1 dana',
	'contributionscores-allrevisions' => 'Sva uređivanja',
	'contributionscores-score' => 'Rezultat',
	'contributionscores-pages' => 'Stranica',
	'contributionscores-changes' => 'Uređivanja',
	'contributionscores-username' => 'Ime suradnika',
	'contributionscores-invalidusername' => 'Nevaljano suradničko ime',
	'contributionscores-invalidmetric' => 'Nevaljana metrika',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'contributionscores' => 'Wuhódnoćenje přinoškow',
	'contributionscores-desc' => 'Wuslědźi najwyši [[Special:ContributionScores|wobjim wužiwarskich přinoškow]] w datowej bance wikiprojekta',
	'contributionscores-info' => 'Ličba dypkow so takle wobličuje:
*1 dypk za kóždy wobdźěłanu jednotliwu stronu
*Kwadratny korjeń (wšěch sčinjenych změnow) - (cyłkowna ličba jednotliwych stronow) * 2
Ličba dypkow wuličena na tute wašnje pohódnoća wělakorosć změno wysě hač mnóstwo změnow. Zasadnje tute pohódnoćenje měri w prěnim rjedźe jednotliwe wobdźěłane strony dźiwajo na wysoke mnóstwo změnow - předpokładujo, zo to by nastawk z wyšej kwalitu było.',
	'contributionscores-top' => '(Najlěpšich $1)',
	'contributionscores-days' => '{{PLURAL:$1|Posledni dźeń|Poslednjej $1 dnjej|Poslednje $1 dny|Poslednich $1 dnjow}}',
	'contributionscores-allrevisions' => 'Wšě změny',
	'contributionscores-score' => 'Hódnoćenje',
	'contributionscores-pages' => 'Strony',
	'contributionscores-changes' => 'Změny',
	'contributionscores-username' => 'Wužiwarske mjeno',
	'contributionscores-invalidusername' => 'Njepłaćiwe wužiwarske mjeno',
	'contributionscores-invalidmetric' => 'Njepłaćiwa metrika',
);

/** Haitian (Kreyòl ayisyen)
 * @author Jvm
 */
$messages['ht'] = array(
	'contributionscores' => 'Kontribisyon analiz',
	'contributionscores-desc' => 'Sonde baz done wiki-a pou wo [[Special:ContributionScores|itilizatè kontribisyon volim]]',
	'contributionscores-info' => 'Rezilta yo kalkile konsa:
*Yon (1) pwen pou chak paj inik edite 
*Rasin Kare de (Total Edit Fè) - (Total Paj Inik) * 2
Rezilta trouve nan fason sa peze edit divèsite sou edit kantite.
Basikalman, rezilta sa mezire primèman paj inik ki te edite, avèk konsiderasyon pou wo edit volim – sa konsidere kòm yon paj de mèyè kalite.',
	'contributionscores-top' => '(Meyè $1 yo)',
	'contributionscores-days' => 'Denyè $1 jou yo',
	'contributionscores-allrevisions' => 'Tout revizion yo',
	'contributionscores-score' => 'Rezilta',
	'contributionscores-pages' => 'Paj',
	'contributionscores-changes' => 'Chanjman',
	'contributionscores-username' => 'Non-itilizatè',
	'contributionscores-invalidusername' => 'Non-itilizatè envalid',
	'contributionscores-invalidmetric' => 'Metrik envalid',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'contributionscores' => 'Szerkesztési pontszám',
	'contributionscores-desc' => 'Megjeleníti a [[Special:ContributionScores|szerkesztő közreműködéseinek súlyát]] a wiki adatbázisa alapján',
	'contributionscores-info' => 'A pontszámok az alábbi módon vannak kiszámolva:
*1 pont minden egyedi lap szerkesztése után
*(Az összes szerkesztés) - (Az összes egyedi lap) * 2 négyzetgyöke
Az így számolt pontszámok a szerkesztés sokszínűségét mutatják a szerkesztés mennyisége helyett. Alapjában véve a pontszám az egyedi szerkesztett lapok számát mutatja, figyelembe véve a nagy szerkesztési számokat – feltételezve a jobb minőségű lapokat.',
	'contributionscores-top' => '(legjobb $1)',
	'contributionscores-days' => 'Utolsó $1 nap',
	'contributionscores-allrevisions' => 'Összes szerkesztés',
	'contributionscores-score' => 'Pontszám',
	'contributionscores-pages' => 'Oldalak',
	'contributionscores-changes' => 'Változtatások',
	'contributionscores-username' => 'Felhasználó',
	'contributionscores-invalidusername' => 'Érvénytelen szerkesztői név',
	'contributionscores-invalidmetric' => 'Érvénytelen mértékrendszer',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'contributionscores' => 'Punctage de contributiones',
	'contributionscores-desc' => 'Consulta le base de datos wiki pro le [[Special:ContributionScores|usatores contribuente le plus]]',
	'contributionscores-info' => 'Le punctages se calcula del modo sequente:
*Un (1) puncto pro cata pagina unic modificate
*Radice quadrate de (total del modificationes facite) - (total del paginas unic) * 2
Le punctages calculate de iste modo privilegia le diversitate super le volumine de modificationes.
Dicite de altere modo, iste punctage mesura primarimente le paginas unic modificate, con consideration pro un alte volumine de modificationes – le qual es presumite a indicar un pagina de alte qualitate.',
	'contributionscores-top' => '(Le prime $1)',
	'contributionscores-days' => 'Ultime $1 dies',
	'contributionscores-allrevisions' => 'Tote le versiones',
	'contributionscores-score' => 'Punctage',
	'contributionscores-pages' => 'Paginas',
	'contributionscores-changes' => 'Modificationes',
	'contributionscores-username' => 'Nomine de usator',
	'contributionscores-invalidusername' => 'Nomine de usator invalide',
	'contributionscores-invalidmetric' => 'Metrica invalide',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'contributionscores' => 'Skor kontribusi',
	'contributionscores-desc' => 'Menghitung [[Special:ContributionScores|jumlah kontribusi pengguna]] terbanyak di basis data wiki',
	'contributionscores-info' => 'Skor dihitung dengan cara berikut:
* Satu (1) poin untuk setiap halaman tunggal yang disunting
* Akar kuadrat dari (total suntingan) - (total halaman tunggal) * 2
Skor dihitung dengan cara ini untuk menghasilkan jumlah tertimbang penyuntingan berbanding volume suntingan.
Pada dasarnya, skor ini menghitung jumlah halaman tunggal yang disunting, dengan pertimbangan di mana volume suntingan yang tinggi - diasumsikan sebagai halaman dengan kualitas lebih tinggi.',
	'contributionscores-top' => '($1 tertinggi)',
	'contributionscores-days' => '$1 hari terakhir',
	'contributionscores-allrevisions' => 'Semua revisi',
	'contributionscores-score' => 'Skor',
	'contributionscores-pages' => 'Halaman',
	'contributionscores-changes' => 'Perubahan',
	'contributionscores-username' => 'Nama pengguna',
	'contributionscores-invalidusername' => 'Nama pengguna tidak sah',
	'contributionscores-invalidmetric' => 'Metrik tidak sah',
);

/** Iloko (Ilokano)
 * @author Saluyot
 */
$messages['ilo'] = array(
	'contributionscores' => 'Dagiti Bilang ti Naaramidan',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'contributionscores' => 'Framleggjandastig',
	'contributionscores-desc' => 'Kannar wiki-gagnagrunninn eftir mesta [[Special:ContributionScores|magni framlaga notenda]]',
	'contributionscores-info' => 'Stigin eru reiknuð á eftirfarandi hátt:
* Eitt (1) stig fyrir hverja einkvæma síðu sem breytt er
* Ferningsrót (allra breytinga gerðra) - (allra breytinga gerðra á einkvæmum síðum) * 2
Stig reiknuð á þennan hátt íþyngja fjölbreyttni breytinga fremur en magn breytinga.
Í grundvallaratriðum mæla stigin aðallega út breytingar á einkvæmum síðum, með tilliti til hás magns breytinga - sem eru líklegri til að vera vandaðri síður.',
	'contributionscores-top' => '(Efstu $1)',
	'contributionscores-days' => 'Síðustu $1 dagana',
	'contributionscores-allrevisions' => 'Allar breytingar',
	'contributionscores-score' => 'Stigafjöldi',
	'contributionscores-pages' => 'Síður',
	'contributionscores-changes' => 'Breytingar',
	'contributionscores-username' => 'Notandanafn',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Gianfranco
 * @author Pietrodn
 */
$messages['it'] = array(
	'contributionscores' => 'Punteggi contributi',
	'contributionscores-desc' => 'Interroga il database wiki per il più alto [[Special:ContributionScores|volume di contributi utente]]',
	'contributionscores-info' => 'I punteggi vengono calcolati in questo modo: 
*1 punto per ciascuna pagina distinta modificata 
*Radice quadrata di (Tutte le modifiche effettuate) - (Totale pagine distinte) * 2 
Questo metodo di calcolo dei punteggi tiene in maggior conto la diversità delle modifiche rispetto al numero dei contributi. Di fondo, questo punteggio misura in primo luogo il numero di pagine distinte modificate, valutando anche un eventuale alto volume di contributi - ciò fa presumere una più elevata qualità della pagina modificata.',
	'contributionscores-top' => '(Migliori $1)',
	'contributionscores-days' => 'Ultimi $1 giorni',
	'contributionscores-allrevisions' => 'Tutte le revisioni',
	'contributionscores-score' => 'Punteggio',
	'contributionscores-pages' => 'Pagine',
	'contributionscores-changes' => 'Modifiche',
	'contributionscores-username' => 'Nome utente',
	'contributionscores-invalidusername' => 'Nome utente non valido',
	'contributionscores-invalidmetric' => 'Metrica non valida',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'contributionscores' => '貢献得点',
	'contributionscores-desc' => 'ウィキデータベースへの[[Special:ContributionScores|貢献度が高い利用者]]の統計',
	'contributionscores-info' => "得点は以下のように計算されます:
*編集したページ毎に、1ポイント
*[(変更回数) - (ページ数)]の平方根 * 2

:''得点 = (ページ数) + SQRT((変更回数)-(ページ数))*2''

この計算式では、編集量よりも編集の多様性が重要視されます。得点は、編集したページ数を基礎に、高い品質のページを維持するため多くの編集を行うことにも配慮した評価となっています。",
	'contributionscores-top' => '(上位$1名)',
	'contributionscores-days' => '最近の$1日間',
	'contributionscores-allrevisions' => '全履歴',
	'contributionscores-score' => '得点',
	'contributionscores-pages' => 'ページ数',
	'contributionscores-changes' => '変更回数',
	'contributionscores-username' => '利用者名',
	'contributionscores-invalidusername' => '無効な利用者名',
	'contributionscores-invalidmetric' => '無効な尺度',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'contributionscores' => 'Skor Kontribusi',
	'contributionscores-desc' => 'Nglakokaké polling (angkèt) ing basis data kanggo [[Special:ContributionScores|volume kontribusi panganggo]]',
	'contributionscores-info' => "Skoré diétung kaya mangkéné:
* Biji siji (1) per kaca unik sing disunting
* Oyot (bs. Indonesia ''akar'') saka (Gunggungé Suntingan) - (Gunggungé Kaca-KAca Unik) * 2
Skor sing diétung miturut cara iki bisa nyerminaké divèrsitas suntingan sadhuwuring volume suntingan.
Sacara dhasar, skor iki utamané ngétung kaca-kaca unik sing disunting, karo mélu nimbangaké volume suntingan dhuwur - diasumsèkaké kwalitas kacané luwih dhuwur.",
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => '$1 dina pungkasan',
	'contributionscores-allrevisions' => 'Kabèh Révisi',
	'contributionscores-score' => 'Skor',
	'contributionscores-pages' => 'Kaca-kaca',
	'contributionscores-changes' => 'Owah-owahan',
	'contributionscores-username' => 'Jeneng panganggo',
	'contributionscores-invalidusername' => 'Jeneng panganggo ora sah',
	'contributionscores-invalidmetric' => 'Metrik ora sah',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬)
 * @author Robby
 */
$messages['kk-arab'] = array(
	'contributionscores' => 'ٷلەس بەرۋ ەسەپتەرٸ',
	'contributionscores-info' => 'ەسەپتەر كەلەسٸ دەي سانالادى:
*1 ۇپاي ٵربٸر تٷزەتٸلگەن بٸرەگەي بەت ٷشٸن
*مىنانىڭ شارشى تٷبٸرٸ (بارلىق ٸستەلٸنگەن تٷزەتۋلەر) ‒ (بارلىق بٸرەگەي بەتتەر) * 2
وسى تٵسٸلمەن سانالعان ەسەپتەر تٷزەتۋ اۋقىمىنداعى ٶڭدەۋ ٵركەلكٸلٸگٸنٸڭ سالماعىن ٶلشەيدٸ. نەگٸزٸندە, بۇل ەسەپ الدىمەن تٷزەتٸلگەن بٸركەلكٸ بەتتەردٸ ٶلشەيدٸ, جوعارعى ٶڭدەۋ اۋقىمىمەن بٸرگە — جوعارى ساپالى بەت جاعدايىمەن ەسەپتەپ.',
	'contributionscores-top' => '(جوعارعى $1)',
	'contributionscores-days' => 'سوڭعى $1 كٷندە',
	'contributionscores-allrevisions' => 'بارلىق نۇسقالار',
	'contributionscores-score' => 'ەسەپ',
	'contributionscores-pages' => 'بەتتەر',
	'contributionscores-changes' => 'ٶزگەرٸستەر',
	'contributionscores-username' => 'قاتىسۋشى اتى',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'contributionscores' => 'Үлес беру есептері',
	'contributionscores-info' => 'Есептер келесі дей саналады:
*1 ұпай әрбір түзетілген бірегей бет үшін
*Мынаның шаршы түбірі (Барлық Істелінген Түзетулер) ‒ (Барлық Бірегей Беттер) * 2
Осы тәсілмен саналған есептер түзету ауқымындағы өңдеу әркелкілігінің салмағын өлшейді. Негізінде, бұл есеп алдымен түзетілген біркелкі беттерді өлшейді, жоғарғы өңдеу ауқымымен бірге — жоғары сапалы бет жағдайымен есептеп.',
	'contributionscores-top' => '(Жоғарғы $1)',
	'contributionscores-days' => 'Соңғы $1 күнде',
	'contributionscores-allrevisions' => 'Барлық нұсқалар',
	'contributionscores-score' => 'Есеп',
	'contributionscores-pages' => 'Беттер',
	'contributionscores-changes' => 'Өзгерістер',
	'contributionscores-username' => 'Қатысушы аты',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'contributionscores' => 'Üles berw esepteri',
	'contributionscores-info' => 'Esepter kelesi deý sanaladı:
*1 upaý ärbir tüzetilgen biregeý bet üşin
*Mınanıñ şarşı tübiri (Barlıq İstelingen Tüzetwler) ‒ (Barlıq Biregeý Better) * 2
Osı täsilmen sanalğan esepter tüzetw awqımındağı öñdew ärkelkiliginiñ salmağın ölşeýdi. Negizinde, bul esep aldımen tüzetilgen birkelki betterdi ölşeýdi, joğarğı öñdew awqımımen birge — joğarı sapalı bet jağdaýımen eseptep.',
	'contributionscores-top' => '(Joğarğı $1)',
	'contributionscores-days' => 'Soñğı $1 künde',
	'contributionscores-allrevisions' => 'Barlıq nusqalar',
	'contributionscores-score' => 'Esep',
	'contributionscores-pages' => 'Better',
	'contributionscores-changes' => 'Özgerister',
	'contributionscores-username' => 'Qatıswşı atı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'contributionscores' => 'តារាងពិន្ទុ​នៃការរួមចំណែក',
	'contributionscores-top' => '(លើគេទាំង $1 នាក់)',
	'contributionscores-days' => '$1 ថ្ងៃ​ចុងក្រោយ',
	'contributionscores-allrevisions' => 'គ្រប់កំណែ',
	'contributionscores-score' => 'ពិន្ទុ',
	'contributionscores-pages' => 'ទំព័រ​នានា',
	'contributionscores-changes' => 'បំលាស់ប្តូរ​នានា',
	'contributionscores-username' => 'ឈ្មោះអ្នកប្រើប្រាស់',
	'contributionscores-invalidusername' => 'ឈ្មោះអ្នកប្រើប្រាស់មិនត្រឹមត្រូវ',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'contributionscores' => 'Metmaacher ier Beidräsch verjlesche',
	'contributionscores-desc' => 'Fingk de Metmaacher met de
[[Special:ContributionScores|miihßte Beidrääsch]].',
	'contributionscores-info' => 'Ene Metmaacher kritt:
* eine Punk för jede Sigg, woh sei udder hä draan met jeschrevve hät, plus
* plus et Dubbelte fun de Quadrat-Woozel us däm Ongscheed fun de Jesampzahl aan Änderunge fun däm Metmaacher, un dä Aanzahl Sigge, wo sei udder hä draat jeschrevve hät.
De Punkte zälle esu de Fillfälteschkeit mieh wie der Ömfang vun dä Beidrääsch.
Dat es en de Houpsaach de övverhoup aanjepackte Zahl Sigge, ävver dann noch,
dat öff jet Schrieve am Eng besser Sigge jitt, als wie winnijer Schrieve.',
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Letzte $1 Dare',
	'contributionscores-allrevisions' => 'All Versione',
	'contributionscores-score' => 'Punkte',
	'contributionscores-pages' => 'Sigge',
	'contributionscores-changes' => 'Änderunge',
	'contributionscores-username' => 'Metmaacher Name',
	'contributionscores-invalidusername' => 'Verkeehte Metmaacher-Name',
	'contributionscores-invalidmetric' => 'Onjöltesch Mohß',
);

/** Cornish (Kernewek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'contributionscores-username' => 'Hanow-usyer',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'contributionscores' => 'Bewertung vun den Ännerungen',
	'contributionscores-desc' => "Ufro un d'Wiki-Datebank no den héichsten [[Special:ContributionScores|Benotzerscoren]]",
	'contributionscores-info' => "D'Bewertunge ginn esou gerechent:
* 1 Punkt fir all geännert Säit;
* D'Quadrawuerzel vun (allen Ännerungen) - (Zuel vun de geännerte Säiten) * 2.

Op déi Manéier gëtt der Zuel vun de geännerte Säiten méi eng Grouss Bedeitung zougedeelt, wéi der Zuel vun den Ännerungen.",
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => '{{PLURAL:$1|Leschten Dag|Lescht $1 Deeg}}',
	'contributionscores-allrevisions' => 'All Versiounen',
	'contributionscores-score' => 'Bewertung',
	'contributionscores-pages' => 'Säiten',
	'contributionscores-changes' => 'Ännerungen',
	'contributionscores-username' => 'Benotzernumm',
	'contributionscores-invalidusername' => 'Ongëltege Benotzernumm',
	'contributionscores-invalidmetric' => 'Ongëlteg Metrik',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'contributionscores' => 'Biedraaghuuegdjes',
	'contributionscores-desc' => "Guuef 'n euverzich van [[Special:ContributionScores|gebroekers mit de meiste biedraag]] inne wiki.",
	'contributionscores-info' => "Huuegdjes waere es vólg beraekendj:
* Ein (1) pöntj veur edere apaart bewèrkdje pazjena
* Wórtel van (totaal aantal gemaakdje bewèrkinger) - (totaal aantal apaarte pazjena's × 2
I huuegdjes die op dees wies beraekendj waere wäög divers bewèrkingsgedraag zwaorder es bewèrkingsvolume. In feite mèt dees huuegdje veurnamelik 't aantal apaarte pazjena's die zeen bewèrk, wiele 'n grót aantal bewèrkinger waal in ach wuuertj genaome, mit de aannaam det 't 'ne pazjena van 'n huuegere kwaliteit is.",
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Lètste $1 daag',
	'contributionscores-allrevisions' => 'Alle verzies',
	'contributionscores-score' => 'Pöntjer',
	'contributionscores-pages' => "Pazjena's",
	'contributionscores-changes' => 'Bewèrkinger',
	'contributionscores-username' => 'Gebroeker',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'contributionscores-allrevisions' => 'Visos revizijos',
	'contributionscores-score' => 'Rezultatas',
	'contributionscores-pages' => 'Puslapiai',
	'contributionscores-changes' => 'Pakeitimai',
	'contributionscores-username' => 'Naudotojo vardas',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'contributionscores-username' => 'Пайдаланышын лӱмжӧ',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'contributionscores-top' => '(ആദ്യത്തെ $1)',
	'contributionscores-days' => 'അവസാനത്തെ $1 ദിവസങ്ങള്‍',
	'contributionscores-allrevisions' => 'എല്ലാ പതിപ്പുകളും',
	'contributionscores-score' => 'സ്കോര്‍',
	'contributionscores-pages' => 'താളുകള്‍',
	'contributionscores-changes' => 'മാറ്റങ്ങള്‍',
	'contributionscores-username' => 'ഉപയോക്തൃനാമം',
	'contributionscores-invalidusername' => 'അസാധുവായ ഉപയോക്തൃനാമം',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'contributionscores' => 'योगदान संख्या',
	'contributionscores-desc' => '[[Special:ContributionScores|सदस्य योगदान संख्येनुसार]] विकि डाटाबेस दर्शवितो',
	'contributionscores-info' => 'गुण खालीलप्रमाणे मोजले जातील:
*प्रत्येक स्वतंत्र पानासाठी १ गुण
*(एकूण संपादने) - (एकूण स्वतंत्र पाने) * 2 चे वर्गमूळ
अशा प्रकारे मोजलेले गुण हे संपादन विविधतेला संपादन संख्येपेक्षा जास्त महत्व देतात. मुख्यत्वे, हे गुण जास्त संपादन संख्या मोजून स्वतंत्र पानांची संपादने काढतात.',
	'contributionscores-top' => '(पहिले $1)',
	'contributionscores-days' => 'शेवटचे $1 दिवस',
	'contributionscores-allrevisions' => 'सर्व आवर्तने',
	'contributionscores-score' => 'गुण',
	'contributionscores-pages' => 'पाने',
	'contributionscores-changes' => 'बदल',
	'contributionscores-username' => 'उपयोगकर्तानाव',
	'contributionscores-invalidusername' => 'चुकीचे सदस्यनाव',
	'contributionscores-invalidmetric' => 'चुकीचे मेट्रिक',
);

/** Malay (Bahasa Melayu)
 * @author Emrrans
 */
$messages['ms'] = array(
	'contributionscores' => 'Skor sumbangan',
);

/** Maltese (Malti)
 * @author Giangian15
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'contributionscores-pages' => 'Paġni',
	'contributionscores-username' => 'Isem l-utent',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'contributionscores-days' => 'Меельсе $1 чить',
	'contributionscores-pages' => 'Лопат',
	'contributionscores-changes' => 'Полавтнемат',
	'contributionscores-username' => 'Теицянь лем',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'contributionscores-changes' => 'Tlapatlaliztli',
	'contributionscores-username' => 'Tlatequitiltilīltōcāitl',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'contributionscores-days' => 'Letzte $1 Daag',
	'contributionscores-pages' => 'Sieden',
	'contributionscores-changes' => 'Ännern',
	'contributionscores-username' => 'Brukernaam',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'contributionscores' => 'Gebruikersstatistieken',
	'contributionscores-desc' => 'Geeft een overzicht van [[Special:ContributionScores|gebruikers met de meeste bijdragen]] in de wiki',
	'contributionscores-info' => "Scores worden als volgt berekend:
*1 punt voor iedere bewerkte pagina
*wortel van (totaal aantal gemaakte bewerkingen) - (totaal aantal unieke pagina's) * 2
In scores die op deze wijze berekend worden weegt divers bewerkingsgedrag zwaarder dan bewerkingsvolume. In feite meet deze score voornamelijk het aantal unieke pagina's dat is bewerkt, terwijl een groot aantal bewerkingen wel in acht wordt genomen, met de aanname dat het een pagina van een hogere kwaliteit is.",
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Laatste $1 dagen',
	'contributionscores-allrevisions' => 'Alle versies',
	'contributionscores-score' => 'Punten',
	'contributionscores-pages' => "Pagina's",
	'contributionscores-changes' => 'Bewerkingen',
	'contributionscores-username' => 'Gebruiker',
	'contributionscores-invalidusername' => 'Ongeldige gebruikersnaam',
	'contributionscores-invalidmetric' => 'Ongeldige eenheid',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'contributionscores' => 'Bidragspoeng',
	'contributionscores-desc' => 'Spør wikidatabasen etter det høgaste [[Special:ContributionScores|bidragsvolumet]]',
	'contributionscores-info' => 'Bidragspoeng blir rekna ut på følgjande måte:
* eitt poeng for kvar unik sida som har blitt endra
* Kvadratrota av (totalt tal på endringar) &minus; (unike sider endra) × 2
Poeng som blir rekna ut på denne måten set endringsmangfald høgare enn endringsvolum. Dette tyder til sist at dette primært måler kor mange forskjellige sider som har blitt endra, med omsyn til høgt endringsvolum &ndash; anteke å føra til sider av høgare kvalitet.',
	'contributionscores-top' => '(topp $1)',
	'contributionscores-days' => 'Dei $1 siste dagane',
	'contributionscores-allrevisions' => 'Alle versjonar',
	'contributionscores-score' => 'Poeng',
	'contributionscores-pages' => 'Sider',
	'contributionscores-changes' => 'Endringar',
	'contributionscores-username' => 'Brukarnamn',
	'contributionscores-invalidusername' => 'Ugyldig brukarnamn',
	'contributionscores-invalidmetric' => 'Ugyldig målemetode',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'contributionscores' => 'Bidragspoeng',
	'contributionscores-desc' => 'Spør wikidatabasen etter det høyeste [[Special:ContributionScores|bidragsvolumet]]',
	'contributionscores-info' => 'Bidragspoeng regnes ut på følgende måte:
* 1 poeng for hver unike side som er redigert
* Kvadratrota av (totalt antall redigeringer) &minus; (unike sider redigert) × 2
Poeng som regnes ut på denne måte veier redigeringsmangfold høyere enn redigeringsvolum. Dette betyr i bunn og grunn at dette primært måler hvor mange forskjellige sider som er redigert, med hensyn til høyt redigeringsvolum &ndash; antatt å føre til sider av høyere kvalitet.',
	'contributionscores-top' => '(Topp $1)',
	'contributionscores-days' => 'Siste $1 dager',
	'contributionscores-allrevisions' => 'Alle revisjoner',
	'contributionscores-score' => 'Poeng',
	'contributionscores-pages' => 'Sider',
	'contributionscores-changes' => 'Endringer',
	'contributionscores-username' => 'Brukernavn',
	'contributionscores-invalidusername' => 'Ugyldig brukernavn',
	'contributionscores-invalidmetric' => 'Ugyldig målemetode',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'contributionscores-pages' => 'Matlakala',
	'contributionscores-changes' => 'Diphetogo',
	'contributionscores-username' => 'Leina la mošomši',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'contributionscores' => 'Puntatge de las contribucions',
	'contributionscores-desc' => 'Espia la banca de donadas wiki pels [[Special:ContributionScores|utilizaires contribuissent mai]]',
	'contributionscores-info' => "Lo puntatge se calcula coma seguís : 
* 1 punt per cada pagina modificada
* raiç quadrada de (nombre de modificacions) - (nombre de paginas diferentas)
* 2. D'aqueste biais, lo puntatge calculat preferís la diversitat a la quantitat. Escrich d'un autre biais, aqueste puntatge s'interèssa principalament a mostrar lo nombre de modificacions de paginas diferentas, puèi la quantitat totala de modificacions.",
	'contributionscores-top' => '(Melhor $1)',
	'contributionscores-days' => 'Dins {{PLURAL:$1|lo darrièr jorn|los darrièrs $1 jorns}}',
	'contributionscores-allrevisions' => 'Totas las revisions',
	'contributionscores-score' => 'Puntatge',
	'contributionscores-pages' => 'Paginas',
	'contributionscores-changes' => 'Modificacions',
	'contributionscores-username' => "Nom d'utilizaire",
	'contributionscores-invalidusername' => "Nom d'utilizaire invalid",
	'contributionscores-invalidmetric' => 'Metria incorrècta',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'contributionscores-username' => 'Архайæджы ном',
);

/** Pampanga (Kapampangan)
 * @author Katimawan2005
 */
$messages['pam'] = array(
	'contributionscores-top' => '(Pekamatas a $1)',
	'contributionscores-days' => 'Tauling $1 Aldo',
	'contributionscores-allrevisions' => 'Eganaganang mibayu',
	'contributionscores-pages' => 'Bulung',
	'contributionscores-changes' => 'Miyalilan',
	'contributionscores-username' => 'Lagyungtalagamit (Username)',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'contributionscores-username' => 'Bruckernome',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author McMonster
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'contributionscores' => 'Punkty za edycje',
	'contributionscores-desc' => 'Wylicza [[Special:ContributionScores|punkty za edycje]] dla użytkowników',
	'contributionscores-info' => 'Punkty za edycje naliczane są następującą metodą:
*1 punkt za każdą edytowaną unikalną stronę
*pierwiastek kwadratowy z (ogólna liczba edycji) - (wszystkich unikalnych stron) * 2
Taki sposób naliczania pozwala wyważyć różnorodność edycji względem liczby edycji. Zasadniczo wynik uzależniony jest od liczby edytowanych unikalnych stron z uwzględnieniem dużej liczby edycji – zakładając wyższą wartość tworzenia nowych artykułów.',
	'contributionscores-top' => '($1 najlepszych)',
	'contributionscores-days' => 'Ostatnie $1 dni',
	'contributionscores-allrevisions' => 'Wszystkie edycje',
	'contributionscores-score' => 'Punktów',
	'contributionscores-pages' => 'Stron',
	'contributionscores-changes' => 'Zmian',
	'contributionscores-username' => 'Nazwa użytkownika',
	'contributionscores-invalidusername' => 'Zła nazwa użytkownika',
	'contributionscores-invalidmetric' => 'Nieprawidłowa metryka',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'contributionscores' => 'Classìfica dla contribussion',
	'contributionscores-info' => "La classìfica as càlcola parej: 
*1 pont për minca pàgina modificà 
*Rèis quadra ëd (Total dle Modìfiche Faite) - (Total dle Pàgine Ùniche) moltiplicà për 2 
Le classìfiche donca as peulo ten-se ën pèisand an manera diferenta ël nùmer dle modìfiche anvers al volum dle modìfiche mideme. Sta classìfica a l'amzura dzortut le pàgine ùniche ch'a ven-o modificà, e ën vorend a-j da n'euj ëd rësgoard a cole ch'a l'han n'àot volum ëd modìfica, ch'as pensa ch'a peula esse na marca ëd qualità dl'artìcol.",
	'contributionscores-top' => '(Ij $1 mej)',
	'contributionscores-days' => 'Ùltim $1 dì',
	'contributionscores-allrevisions' => 'Tute le revision',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'contributionscores-days' => 'وروستۍ $1 ورځې',
	'contributionscores-pages' => 'مخونه',
	'contributionscores-changes' => 'بدلونونه',
	'contributionscores-username' => 'کارن-نوم',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'contributionscores' => 'Pontuações de Contribuições',
	'contributionscores-desc' => 'Inquire a base de dados wiki sobre os [[Special:ContributionScores|volumes de contribuições de utilizadores]] mais altos',
	'contributionscores-info' => 'As pontuações são calculadas da seguinte forma:
*1 ponto por cada página única editada
*Raiz quadrada de (Total de Edições Feitas) - (Total de Páginas Únicas) * 2
Pontuações calculadas desta forma pesam a diversidade de edições relativamente ao volume de edições. Basicamente, esta pontuação mede primariamente páginas únicas editadas, com consideração por alto volume de edições - assumindo serem páginas de qualidade mais alta.',
	'contributionscores-top' => '(Primeiros $1)',
	'contributionscores-days' => 'Últimos $1 Dias',
	'contributionscores-allrevisions' => 'Todas As Revisões',
	'contributionscores-score' => 'Pontuação',
	'contributionscores-pages' => 'Páginas',
	'contributionscores-changes' => 'Alterações',
	'contributionscores-username' => 'Nome de utilizador',
	'contributionscores-invalidusername' => 'Nome de utilizador inválido',
	'contributionscores-invalidmetric' => 'Métrica inválida',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Brunoy Anastasiya Seryozhenko
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'contributionscores' => 'Pontuações de Contribuições',
	'contributionscores-desc' => 'Inquire a base de dados wiki sobre os [[{{ns:special}}:ContributionScores|volumes de contribuições dos usuários]] mais altos',
	'contributionscores-info' => 'As pontuações são calculadas da seguinte forma:
*1 ponto por cada página única editada
*Raiz quadrada de (Total de Edições Feitas) - (Total de Páginas Únicas) * 2
Pontuações calculadas desta forma pesam a diversidade de edições relativamente ao volume de edições. Basicamente, esta pontuação mede primariamente páginas únicas editadas, com consideração pelo alto volume de edições - assumindo serem páginas de qualidade mais alta.',
	'contributionscores-top' => '(Iniciais $1)',
	'contributionscores-days' => 'Últimos $1 Dias',
	'contributionscores-allrevisions' => 'Todas as revisões',
	'contributionscores-score' => 'Pontuação',
	'contributionscores-pages' => 'Páginas',
	'contributionscores-changes' => 'Mudanças',
	'contributionscores-username' => 'Nome de usuário',
	'contributionscores-invalidusername' => 'Nome de utilizador inválido',
	'contributionscores-invalidmetric' => 'Métrica inválida',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'contributionscores-top' => '(Top $1)',
	'contributionscores-days' => 'Ultimele $1 zile',
	'contributionscores-allrevisions' => 'Toate versiunile',
	'contributionscores-pages' => 'Pagini',
	'contributionscores-username' => 'Nume de utilizator',
	'contributionscores-invalidusername' => 'Nume de utilizator incorect',
	'contributionscores-invalidmetric' => 'Metrică incorectă',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'contributionscores' => 'Pundegge de le condrebbute',
	'contributionscores-desc' => "Le sondagge d'u database de Uicchi pe le cchiù ierte [[Special:ContributionScores|volume de condrebbuzione de l'utende]]",
	'contributionscores-info' => "Le pundegge sonde calculete accussì:
*'Nu (1) punde pe ogne pàgena uniche cangete
*'A radice quadrete de (totele de le cangiaminde fatte) - (totele de le pàggene uniche) * 2
Le pundegge calculete jndr'à stu mode tènene 'nu pese de cangiaminde diverse sus a 'u volume de le cangiaminde.
De base, stu pundegge mesure apprime de tutte, le pàggene uniche cangete, cu 'a conziderazzione pe le volume de cangiaminde ierte - se penze ca le pàggene tènene 'na qualitate cchiù ierte.",
	'contributionscores-top' => '(Le Prime $1)',
	'contributionscores-days' => 'Urteme $1 sciurne',
	'contributionscores-allrevisions' => 'Tutte le revisiune',
	'contributionscores-score' => 'Pundegge',
	'contributionscores-pages' => 'Pàggene',
	'contributionscores-changes' => 'Cangiaminde',
	'contributionscores-username' => "Nome de l'utende",
	'contributionscores-invalidusername' => "Nome de l'utende invalide",
	'contributionscores-invalidmetric' => 'Metriche invalide',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Kalan
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'contributionscores' => 'Оценка вклада',
	'contributionscores-desc' => 'Определяет из базы данных [[Special:ContributionScores|участников с наибольшим числом правок]]',
	'contributionscores-info' => 'Оценка рассчитывается сложением следующих слагаемых:
* 1 очко за редактирование каждой уникальной страницы;
* 2 * квадратный корень из разности: (общее количество правок) - (всего уникальных страниц).
При подсчёте оценки таким образом разнообразию правок придаётся больший вес, чем общему количеству правок.',
	'contributionscores-top' => '(лучшие $1)',
	'contributionscores-days' => '{{PLURAL:$1|Последний день|Последние $1 дня|Последние $1 дней}}',
	'contributionscores-allrevisions' => 'Все правки',
	'contributionscores-score' => 'Оценка',
	'contributionscores-pages' => 'Страниц',
	'contributionscores-changes' => 'Правок',
	'contributionscores-username' => 'Имя участника',
	'contributionscores-invalidusername' => 'Неправильное имя участника',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'contributionscores' => 'Skóre príspevkov',
	'contributionscores-desc' => 'Zisťuje naväčší [[Special:ContributionScores|objem používateľských príspevkov]] z databázy wiki',
	'contributionscores-info' => 'Skóre sa počíta nasledovne:
*1 bod za každú jedinečnú stránku, ktorú používateľ upravoval
*Odmocnina z (celkom úprav) - (celkom jedinečných stránok) * 2
Skóre vypočítané týmto spôsobom vážia diverzitu úprav viac ako objem úprav. V podstate toto skóre meria najmä počet upravovaných jedinečných stránok s prihliadnutím na vysoký objem úprav; čo sa pokladá za stránku vyššej kvality.',
	'contributionscores-top' => '(Najlepších $1)',
	'contributionscores-days' => 'Posledných $1 dní',
	'contributionscores-allrevisions' => 'Všetky revízie',
	'contributionscores-score' => 'Skóre',
	'contributionscores-pages' => 'Stránky',
	'contributionscores-changes' => 'Zmeny',
	'contributionscores-username' => 'Používateľské meno',
	'contributionscores-invalidusername' => 'Neplatné používateľské meno',
	'contributionscores-invalidmetric' => 'Neplatná metrika',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'contributionscores-top' => '(првих $1)',
	'contributionscores-days' => 'Последњих $1 дана',
	'contributionscores-allrevisions' => 'Све ревизије',
	'contributionscores-pages' => 'Странице',
	'contributionscores-changes' => 'Измене',
	'contributionscores-username' => 'Корисничко име',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'contributionscores' => 'Benutserbiedraage ouschätsje',
	'contributionscores-info' => 'Ouschätsschema:
*1 Punkt foar älke beoarbaidede Siede
*Quadroatwuttel fon aal do (Beoarbaidengen) - (Summe fon do beoarbaidede Sieden) * 2 
Ouschätsengen ap disse Gruundloage weege ju Fuulfoold fon do Biedraage swarrer as dät Biedraachsvolumen. Disse Ouschätsenge mät do apaate Sieden, man lukt uk wäls ganse Oarbaid in Reekenge.',
	'contributionscores-top' => '(Buppeste $1)',
	'contributionscores-days' => 'Lääste $1 Deege',
	'contributionscores-allrevisions' => 'Aal Versione',
	'contributionscores-score' => 'Schätsenge',
	'contributionscores-pages' => 'Sieden',
	'contributionscores-changes' => 'Annerengen',
	'contributionscores-username' => 'Benutsernoome',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'contributionscores' => 'Peunteun Kontribusi',
	'contributionscores-desc' => 'Jajal pamanggih pangkalan data wiki ngeunaan [[Special:ContributionScores|eusi kontribusi pamaké]] pangpunjulna',
	'contributionscores-info' => 'Peunteun diitung dumasar
*1 peunteun pikeun unggal éditan dina kaca nu unik
*Akar Kuadrat tina (Jumlah Éditan) - (Jumlah Kaca Unik) * 2
Peunteun nu diitung dumasar aturan di luhur ngukur karagaman éditan tina jumlah éditan. Ieu peunteun téh utamana ngukur éditan dina kaca nu unik, kalawan dirojong ku jumlah éditan anu loba - kalawan anggapan kacana jadi leuwih alus.',
	'contributionscores-top' => '(Punclut $1)',
	'contributionscores-days' => '$1 Poé Panungtung',
	'contributionscores-allrevisions' => 'Sadaya Révisi',
	'contributionscores-score' => 'Peunteun',
	'contributionscores-pages' => 'Kaca',
	'contributionscores-changes' => 'Parobahan',
	'contributionscores-username' => 'Landihan',
	'contributionscores-invalidusername' => 'Pamaké teu cocog',
	'contributionscores-invalidmetric' => 'matrik teu cocog',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'contributionscores' => 'Bidragspoäng',
	'contributionscores-desc' => 'Hämtar information från databasen om de användare som gjort [[Special:ContributionScores|flest bidrag]]',
	'contributionscores-info' => 'Poängen beräknas på följande vis:
* 1 poäng för varje unik sida som redigerats
* kvadratroten av (antal gjorda redigeringar) - (antal unika sidor) * 2
När poängen beräknas på detta sätt, så väger bidrag spridda över många olika sidor tyngre än många redigeringar på färre sidor. Det betyder att poängen huvudsakligen mäter hur många unika sidor som har redigerats, med hänsyn tagen till det totala antalet redigeringar som gjorts – eftersom många redigeringar antas ge sidor av högre kvalitet.',
	'contributionscores-top' => '(Topp $1)',
	'contributionscores-days' => 'Senaste $1 dagarna',
	'contributionscores-allrevisions' => 'Alla redigeringar',
	'contributionscores-score' => 'Poäng',
	'contributionscores-pages' => 'Sidor',
	'contributionscores-changes' => 'Ändringar',
	'contributionscores-username' => 'Användarnamn',
	'contributionscores-invalidusername' => 'Ogiltigt användarnamn',
	'contributionscores-invalidmetric' => 'Ogiltig metrisk',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 * @author Ulmo
 */
$messages['ta'] = array(
	'contributionscores-pages' => 'பக்கங்கள்',
	'contributionscores-username' => 'பயனர் பெயர்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'contributionscores-top' => '(పై $1)',
	'contributionscores-days' => 'చివరి $1 రోజులు',
	'contributionscores-allrevisions' => 'అన్ని కూర్పులు',
	'contributionscores-score' => 'స్కోరు',
	'contributionscores-pages' => 'పేజీలు',
	'contributionscores-changes' => 'మార్పులు',
	'contributionscores-username' => 'వాడుకరిపేరు',
	'contributionscores-invalidusername' => 'తప్పుడు వాడుకరిపేరు',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'contributionscores-days' => 'Охирин $1 Рӯз',
	'contributionscores-allrevisions' => 'Ҳамаи Нусхаҳо',
	'contributionscores-score' => 'Имтиёз',
	'contributionscores-pages' => 'Саҳифаҳо',
	'contributionscores-changes' => 'Тағйирот',
	'contributionscores-username' => 'Номи корбарӣ',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'contributionscores' => 'Mga puntos ng ambag',
	'contributionscores-desc' => 'Tinatarahan ang kalipunan ng dato ng wiki para sa pinakamataas na [[Special:ContributionScores|dami ng ambag ng tagagamit]]',
	'contributionscores-info' => 'Tinutuos ang mga puntos ayon sa sumusunod:
*Isang (1) puntos para sa bawat bukod-tanging pahinang binago
*Pariugat ng (kabuoang bilang ng mga pagbabagong ginawa) - (kabuoang bilang ng bukod-tanging mga pahina) * 2
Tinutuos ang mga puntos sa ganitong paraan: timbang ng pagkakaiba-iba ng pagbabago sa ibabaw ng dami ng pagbabago.
Sa kapayakan, pangunahing sinusukat ng puntos na ito ang binagong natatanging mga pahina, na may pagsasaalang-alang sa mataas na dami ng pagbago - na ipinapalagay bilang isang pahinang may mataas na uri.',
	'contributionscores-top' => '(Pinakatampok na $1)',
	'contributionscores-days' => 'Huling $1 mga araw',
	'contributionscores-allrevisions' => 'Lahat ng mga pagbabago',
	'contributionscores-score' => 'Puntos',
	'contributionscores-pages' => 'Mga pahina',
	'contributionscores-changes' => 'Mga pagbabago',
	'contributionscores-username' => 'Pangalan ng tagagamit',
	'contributionscores-invalidusername' => 'Hindi tanggap na pangalan ng tagagamit',
	'contributionscores-invalidmetric' => 'Hindi tanggap na metriko',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 */
$messages['tr'] = array(
	'contributionscores' => 'Katkı skorları',
	'contributionscores-days' => 'Son $1 gün',
	'contributionscores-allrevisions' => 'Tüm revizyonlar',
	'contributionscores-score' => 'Puan',
	'contributionscores-pages' => 'Sayfalar',
	'contributionscores-changes' => 'Değişiklikler',
	'contributionscores-username' => 'Kullanıcı adı',
	'contributionscores-invalidusername' => 'Geçersiz kullanıcı adı',
	'contributionscores-invalidmetric' => 'Geçersiz metrik',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'contributionscores-username' => 'ئىشلەتكۇچى ئىسمى',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'contributionscores-username' => 'Ishletkuchi ismi',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'contributionscores' => 'Оцінка внеску',
	'contributionscores-desc' => 'Визначає з бази даних [[Special:ContributionScores|користувачів з найбільшою кількістю редагувань]]',
	'contributionscores-info' => 'Оцінка обчислюється додаванням наступних величин:
* 1 очко за редагування кожної унікальної сторінки;
* 2 * квадратний корінь з різниці: (загальна кількість редагувань) − (усього унікальних сторінок).
При підрахунку оцінки таким чином розмаїттю редагувань надається більша вага, ніж загальній кількості редагувань.',
	'contributionscores-top' => '(кращі $1)',
	'contributionscores-days' => '{{PLURAL:$1|Останній день|Останні $1 дні|Останні $1 днів}}',
	'contributionscores-allrevisions' => 'Усі редагування',
	'contributionscores-score' => 'Оцінка',
	'contributionscores-pages' => 'Сторінок',
	'contributionscores-changes' => 'Редагувань',
	'contributionscores-username' => "Ім'я користувача",
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'contributionscores' => 'Puntegi contributi',
	'contributionscores-desc' => 'Intèroga el database de la wiki par el pi grando [[Special:ContributionScores|volume de contributi utente]]',
	'contributionscores-info' => 'I punti i vien calcolà come segue:
*Un (1) punto par ogni diversa pagina modificà
*Raìsa quadrata de (Tute le modifiche fate) - (Total de le pagine modificà) * 2
Fasendo i conti in sta maniera pesa piassè la diversità de le modifiche rispeto al nùmaro dei contributi. 
In sostansa, sto puntegio el tien conto sopratuto de le diverse pagine modificà, tegnendo in considerazion anca un alto volume de modifiche - che fa pensar a na pi alta qualità de la pagina modificà.',
	'contributionscores-top' => '(Ultimi $1)',
	'contributionscores-days' => 'Ultimi $1 giòrni',
	'contributionscores-allrevisions' => 'Tute le revision',
	'contributionscores-score' => 'Puntegio',
	'contributionscores-pages' => 'Pagine',
	'contributionscores-changes' => 'Canbiamenti',
	'contributionscores-username' => 'Nome utente',
	'contributionscores-invalidusername' => 'Nome utente mia valido',
	'contributionscores-invalidmetric' => 'Metrica mia valida',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'contributionscores' => 'Điểm số đóng góp',
	'contributionscores-desc' => 'Truy xuất cơ sở dữ liệu wiki để xem [[Special:ContributionScores|mức đóng góp]] cao nhất của thành viên',
	'contributionscores-info' => 'Điểm số được tính như sau:
*Một (1) điểm cho mỗi sửa đổi tại từng trang riêng lẻ
*Căn bậc hai của (Tổng số sửa đổi) - (Tổng số trang riêng lẻ) * 2
Điểm số được tính theo cách này sẽ nhé nhấn mạnh vào sự đa dạng khi sửa đổi hơn là mức độ sửa đổi.
Cơ bản, điểm số này đo lường số trang riêng lẻ được sửa đổi, có xét thêm mức độ sửa đổi cao - với giả thiết sẽ làm cho trang có chất lượng hơn.',
	'contributionscores-top' => '(Tốp $1)',
	'contributionscores-days' => '$1 ngày qua',
	'contributionscores-allrevisions' => 'Mọi phiên bản',
	'contributionscores-score' => 'Điểm số',
	'contributionscores-pages' => 'Trang',
	'contributionscores-changes' => 'Các thay đổi',
	'contributionscores-username' => 'Tên người dùng',
	'contributionscores-invalidusername' => 'Tên người dùng không hợp lệ',
	'contributionscores-invalidmetric' => 'Chuẩn đo không hợp lệ',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'contributionscores-days' => 'Dels Lätik $1',
	'contributionscores-allrevisions' => 'Revids valik',
	'contributionscores-pages' => 'Pads',
	'contributionscores-changes' => 'Votükams',
	'contributionscores-username' => 'Gebananem',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'contributionscores-pages' => 'בלעטער',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'contributionscores' => '貢獻分數',
	'contributionscores-info' => '分數會用下面嘅計法去計:
*每一個唯一一版編輯過嘅有1分
*(總編輯數)嘅平方根 - (總唯一頁數) * 2
響呢方面計嘅分數會睇編輯多樣性同編輯量相比。 基本噉講，呢個分數係會依主要嘅唯一編輯過嘅頁，同埋考慮高編輯量 - 假設係一篇高質量嘅文章。',
	'contributionscores-top' => '(最高$1名)',
	'contributionscores-days' => '最近$1日',
	'contributionscores-allrevisions' => '全部修訂',
	'contributionscores-score' => '分數',
	'contributionscores-pages' => '版',
	'contributionscores-changes' => '更改',
	'contributionscores-username' => '用戶名',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'contributionscores' => '贡献分数',
	'contributionscores-info' => '分数会用以下的的计分法去计算:
*每一个唯一页面编辑过的有1分
*(总编辑数)的平方根 - (总唯一页面数) * 2
在这方面计算的分数会参看编辑多的样性跟编辑量相比。 基本说，这个分数是会依主要的唯一编辑过?页面，以及考虑高编辑量 - 假设是一篇高质量的文章。',
	'contributionscores-top' => '(最高$1名)',
	'contributionscores-days' => '最近$1天',
	'contributionscores-allrevisions' => '全部修订',
	'contributionscores-score' => '分数',
	'contributionscores-pages' => '页面',
	'contributionscores-changes' => '更改',
	'contributionscores-username' => '用户名',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'contributionscores' => '貢獻分數',
	'contributionscores-info' => '分數會用以下的的計分法去計算:
*每一個唯一頁面編輯過的有1分
*(總編輯數)的平方根 - (總唯一頁面數) * 2
在這方面計算的分數會參看編輯多的樣性跟編輯量相比。 基本說，這個分數是會依主要的唯一編輯過嘅頁面，以及考慮高編輯量 - 假設是一篇高質量的文章。',
	'contributionscores-top' => '(最高$1名)',
	'contributionscores-days' => '最近$1天',
	'contributionscores-allrevisions' => '全部修訂',
	'contributionscores-score' => '分數',
	'contributionscores-pages' => '頁面',
	'contributionscores-changes' => '更改',
	'contributionscores-username' => '用戶名',
);

