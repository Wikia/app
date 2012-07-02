<?php
/**
 * Internationalisation file for extension mostrevisors.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'mostrevisors' => 'Pages with the most revisors',
	'mostrevisors-desc' => 'List [[Special:MostRevisors|pages with the most revisors]]',
	'mostrevisors-header' => "'''This page lists the {{PLURAL:$1|page|$1 pages}} with most revisors on the wiki.'''",
	'mostrevisors-limitlinks' => 'Show up to $1 pages',
	'mostrevisors-namespace' => 'Namespace:',
	'mostrevisors-none' => 'No entries were found.',
	'mostrevisors-ns-header' => "'''This page lists the {{PLURAL:$1|page|$1 pages}} with most revisors in the $2 namespace.'''",
	'mostrevisors-showing' => 'Listing {{PLURAL:$1|page|$1 pages}}:',
	'mostrevisors-submit' => 'Go',
	'mostrevisors-showredir' => 'Show redirect pages',
	'mostrevisors-hideredir' => 'Hide redirect pages',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editors}}',
	'mostrevisors-viewcontributors' => 'View main contributors',
	//'mostrevisors-text' => 'Show [[Special:MostRevisions|pages with the most revisors]], starting from [[MediaWiki:Mostrevisors-limit-few-revisors|{{MediaWiki:Mostrevisors-limit-few-revisors}} revisors]].',
	//'mostrevisors-text' => 'Show [[Special:MostRevisions|pages with the most revisors]], starting from [[MediaWiki:Mostrevisors-limit-few-revisors|{{MediaWiki:Mostrevisors-limit-few-revisors}} {{PLURAL:{{MediaWiki:Mostrevisors-limit-few-revisors}}|revisor|revisors}}]].',

	// Settings. Do not translate these messages.
	'mostrevisors-limit-few-revisors' => '1',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Fryed-peach
 * @author McDutchie
 * @author Purodha
 */
$messages['qqq'] = array(
	'mostrevisors' => 'The [http://www.mediawiki.org/wiki/Extension:MostRevisors documentation for this extension] seems to indicate that "revisor" here is another word for "editor" or "contributor".',
	'mostrevisors-desc' => '{{desc}}',
	'mostrevisors-limitlinks' => '* $1 is a series of links for different numbers, separated by {{msg-mw|pipe-separator}}',
	'mostrevisors-namespace' => '{{Identical|Namespace}}',
	'mostrevisors-submit' => '{{Identical|Go}}',
	'mostrevisors-users' => '* $1 is the number of contributors to a page, it supports PLURAL.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'mostrevisors-namespace' => 'Naamruimte:',
	'mostrevisors-none' => 'Geen bladsye gevind.',
	'mostrevisors-submit' => 'OK',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'mostrevisors-namespace' => 'Espacio de nombres:',
);

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = array(
	'mostrevisors' => 'الصفحات ذات المحررين الأكثر',
	'mostrevisors-desc' => 'تسرد [[Special:MostRevisors|الصفحات ذات المحررين الأكثر]]',
	'mostrevisors-header' => "'''تسرد هذه الصفحة {{PLURAL:$1||الصفحة ذات|الصفحتين ذواتي|$1 صفحات ذات|$1 صفحة ذات}} المحررين الأكثر على الويكي.'''",
	'mostrevisors-limitlinks' => 'أظهر إلى $1 صفحة',
	'mostrevisors-namespace' => 'النطاق:',
	'mostrevisors-none' => 'لم توجد مدخلات.',
	'mostrevisors-ns-header' => "'''تسرد هذه الصفحة {{PLURAL:$1||الصفحة ذات|الصفحتين ذواتي|$1 صفحات ذات|$1 صفحة ذات}} المحريين الأكثر في نطاق $2.'''",
	'mostrevisors-showing' => 'سرد {{PLURAL:$1||صفحة واحدة|صفحتين|$1 صفحات|$1 صفحة}}:',
	'mostrevisors-submit' => 'اذهب',
	'mostrevisors-showredir' => 'أظهر صفحات التحويل',
	'mostrevisors-hideredir' => 'أخفِ صفحات التحويل',
	'mostrevisors-users' => '- {{PLURAL:$1||محرّر واحد|محرّران|$1 محرّرين|$1 محرّرًا|$1 محرر}}',
	'mostrevisors-viewcontributors' => 'اعرض المساهمين الرئيسيين',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'mostrevisors-submit' => 'ܙܠ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'mostrevisors-namespace' => 'Adlar fəzası:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'mostrevisors' => 'Старонкі з найбольшай колькасьцю рэцэнзэнтаў',
	'mostrevisors-desc' => 'Сьпіс [[Special:MostRevisors|старонак з найбольшай колькасьцю рэцэнзэнтаў]]',
	'mostrevisors-header' => "'''На гэтай старонцы пададзены сьпіс $1 {{PLURAL:$1|старонкі|старонак|старонак}} з найбольшай колькасьцю рэцэнзэнтаў ва ўсёй {{GRAMMAR:месны|{{SITENAME}}}}.'''",
	'mostrevisors-limitlinks' => 'Паказваць да $1 {{PLURAL:$1|старонкі|старонак|старонак}}',
	'mostrevisors-namespace' => 'Прастора назваў:',
	'mostrevisors-none' => 'Запісы ня знойдзеныя.',
	'mostrevisors-ns-header' => "'''На гэтай старонцы пададзены сьпіс $1 {{PLURAL:$1|старонкі|старонак|старонак}} з самай вялікай колькасьцю рэцэнзэнтаў у прасторы назваў $2.'''",
	'mostrevisors-showing' => 'Утрымлівае $1 {{PLURAL:$1|старонку|старонкі|старонак}}:',
	'mostrevisors-submit' => 'Паказаць',
	'mostrevisors-showredir' => 'Паказаць перанакіраваньні',
	'mostrevisors-hideredir' => 'Схаваць перанакіраваньні',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|рэдактар|рэдактары|рэдактараў}}',
	'mostrevisors-viewcontributors' => 'Паказаць асноўных аўтараў',
);

/** Bulgarian (Български) */
$messages['bg'] = array(
	'mostrevisors-submit' => 'Отваряне',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'mostrevisors-submit' => 'চলো',
	'mostrevisors-showredir' => 'পুনর্নির্দেশিত পাতাগুলো দেখাও',
	'mostrevisors-hideredir' => 'পুনর্নির্দেশিত পাতাগুলো লুকাও',
	'mostrevisors-users' => '- $1 জন {{PLURAL:$1|সম্পাদক|সম্পাদকসমূহ}}',
	'mostrevisors-viewcontributors' => 'মূল অবদানকারীকে দেখাও',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'mostrevisors' => 'Pennadoù savet gant ar muiañ a aozerien zisheñvel',
	'mostrevisors-desc' => 'Rollañ a ra ar [[Special:MostRevisors|pennadoù savet gant ar muiañ a aozerien zisheñvel]]',
	'mostrevisors-header' => "'''Rollañ a ra ar bajenn-mañ ar {{PLURAL:$1|pennad|$1 pennad}} eus ar wiki savet gant ar muiañ a aozerien zisheñvel.'''",
	'mostrevisors-limitlinks' => 'Diskwel betek $1 pajenn',
	'mostrevisors-namespace' => 'Esaouenn anv :',
	'mostrevisors-none' => 'Pajenn ebet kavet.',
	'mostrevisors-ns-header' => "'''Rollañ a ra ar bajenn-mañ ar {{PLURAL:$1|pennad|$1 pennad}} savet gant ar muiañ a aozerien zisheñvel en $2 esaouenn anv.'''",
	'mostrevisors-showing' => 'Roll {{PLURAL:$1|eus ar bajenn|eus an $1 pajenn}}:',
	'mostrevisors-submit' => 'Mont',
	'mostrevisors-showredir' => 'Diskouez ar pajennnoù adkas',
	'mostrevisors-hideredir' => 'kuzhat ar pajennoù adkas',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|aozer|aozer}}',
	'mostrevisors-viewcontributors' => 'Gwelet an aozerien bennañ',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'mostrevisors' => 'Stranice sa najviše revizora',
	'mostrevisors-desc' => 'Prikazuje [[Special:MostRevisors|stranice sa najviše revizora]]',
	'mostrevisors-header' => "'''Ova stranica prikazuje {{PLURAL:$1|stranicu|$1 stranice}} sa najviše revizora na wikiju.'''",
	'mostrevisors-limitlinks' => 'Prikazuj do $1 stranica',
	'mostrevisors-namespace' => 'Imenski prostor:',
	'mostrevisors-none' => 'Nijedna stavka nije pronađena.',
	'mostrevisors-ns-header' => "'''Ova stranica prikazuje {{PLURAL:$1|stranicu|$1 stranice}} sa najviše revizora u imenskom prostoru $2.'''",
	'mostrevisors-showing' => '{{PLURAL:$1|Prikazana je stranica|Prikazane su $1 stranice|Prikazano je $1 stranica}}:',
	'mostrevisors-submit' => 'Idi',
	'mostrevisors-showredir' => 'Prikaži stranice preusmjerenja',
	'mostrevisors-hideredir' => 'Sakrij stranice preusmjerenja',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|uređivač|uređivači}}',
	'mostrevisors-viewcontributors' => 'Vidi glavne urednike',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'mostrevisors-namespace' => 'Espai de noms:',
	'mostrevisors-submit' => 'Vés-hi!',
	'mostrevisors-showredir' => 'Mostra les redireccions',
	'mostrevisors-hideredir' => 'Oculta les redireccions',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editors}}',
	'mostrevisors-viewcontributors' => 'Mostra els editors principals',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'mostrevisors-submit' => 'بڕۆ',
);

/** Czech (Česky)
 * @author Kuvaly
 */
$messages['cs'] = array(
	'mostrevisors-namespace' => 'Jmenný prostor:',
	'mostrevisors-submit' => 'Přejít',
);

/** German (Deutsch)
 * @author Pill
 * @author Umherirrender
 */
$messages['de'] = array(
	'mostrevisors' => 'Seiten mit den meisten Bearbeitern',
	'mostrevisors-desc' => 'Zeigt die [[Special:MostRevisors|Seiten mit den meisten Bearbeitern]]',
	'mostrevisors-header' => "'''Diese Seite zeigt die {{PLURAL:$1|Seite|$1 Seiten}} mit den meisten Bearbeitern auf diesem Wiki an.'''",
	'mostrevisors-limitlinks' => 'Höchstens $1 Seiten anzeigen',
	'mostrevisors-namespace' => 'Namensraum:',
	'mostrevisors-none' => 'Es wurden keine Einträge gefunden.',
	'mostrevisors-ns-header' => "'''Diese Seite zeigt die {{PLURAL:$1|Seite|$1 Seiten}} mit den meisten Bearbeitern im Namensraum „$2“ an.'''",
	'mostrevisors-showing' => 'Zeige {{PLURAL:$1|Seite|$1 Seiten}}:',
	'mostrevisors-submit' => 'Los',
	'mostrevisors-showredir' => 'Weiterleitungen anzeigen',
	'mostrevisors-hideredir' => 'Weiterleitungen verstecken',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|Bearbeiter|Bearbeiter}}',
	'mostrevisors-viewcontributors' => 'Hauptautoren ansehen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'mostrevisors' => 'Boki z nejwěcej pśeglědarjami',
	'mostrevisors-desc' => '[[Special:MostRevisors|Boki z nejwěcej pśeglědarjami]] nalicyś',
	'mostrevisors-header' => "'''Toś ten bok nalicyjo {{PLURAL:$1|bok|$1 boka|$1 boki|$1 bokow}} z nejwěcej pśeglědarjami we wikiju.'''",
	'mostrevisors-limitlinks' => 'Až k $1 {{PLURAL:$1|bokoju|bokoma|bokam|bokam}} pokazaś',
	'mostrevisors-namespace' => 'Mjenjowy rum:',
	'mostrevisors-none' => 'Žedne zapiski namakane.',
	'mostrevisors-ns-header' => "'''Toś ten bok nalicyjo {{PLURAL:$1|bok|$1 boka|$1 boki|$1 bokow}} z nejwěcej pśeglědarjami w mjenjowem rumje $2.'''",
	'mostrevisors-showing' => '{{PLURAL:$1|Nalicyjo se bok|Nalicyjotej se $1 boka|Nalicyju se $1 boki|Nalicyjo se $1 bokow}}:',
	'mostrevisors-submit' => 'Wótpósłaś',
	'mostrevisors-showredir' => 'Dalejpósrědnjenja pokazaś',
	'mostrevisors-hideredir' => 'Dalejpósrědnjenja schowaś',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|wobźěłaŕ|wobźěłarja|wobźěłarje|wobźěłarjow}}',
	'mostrevisors-viewcontributors' => 'Głownych wobźěłarjow se woglědaś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'mostrevisors-submit' => 'Yi',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 */
$messages['el'] = array(
	'mostrevisors-limitlinks' => 'Εμφάνιση μέχρι και $1 σελίδες',
	'mostrevisors-namespace' => 'Περιοχή:',
	'mostrevisors-none' => 'Δεν βρέθηκαν καθόλου καταχωρήσεις.',
	'mostrevisors-submit' => 'Πήγαινε',
	'mostrevisors-showredir' => 'Εμφάνιση σελίδων ανακατεύθυνσης',
	'mostrevisors-hideredir' => 'Απόκρυψη σελίδων ανακατεύθυνσης',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|επεξεργαστής|επεξεργαστές}}',
	'mostrevisors-viewcontributors' => 'Εμφάνιση κύριων συνεισφέροντων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'mostrevisors-limitlinks' => 'Montri ĝis $1 paĝoj',
	'mostrevisors-namespace' => 'Nomspaco:',
	'mostrevisors-submit' => 'Ek',
	'mostrevisors-showredir' => 'Montri alidirektilojn',
	'mostrevisors-hideredir' => 'Kaŝi alidirektilojn',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|redaktanto|redaktantoj}}',
	'mostrevisors-viewcontributors' => 'Vidi ĉefajn kontribuantojn',
);

/** Spanish (Español)
 * @author Imre
 * @author Translationista
 */
$messages['es'] = array(
	'mostrevisors' => 'Páginas con más revisores',
	'mostrevisors-desc' => 'Lista [[Special:MostRevisors|páginas con la mayor cantidad de revisores]]',
	'mostrevisors-header' => "'''Esta página lista {{PLURAL:$1|la página|las $1 páginas}} con más revisores en el wiki.'''",
	'mostrevisors-limitlinks' => 'Mostrar hasta $1 páginas',
	'mostrevisors-namespace' => 'Espacio de nombres:',
	'mostrevisors-none' => 'No se encontró ninguna entrada.',
	'mostrevisors-ns-header' => "'''Esta página lista {{PLURAL:$1|la página|$1 las páginas}} con más revisores en el espacio de nombre $2.'''",
	'mostrevisors-showing' => 'Listando {{PLURAL:$1|página|$1 páginas}}:',
	'mostrevisors-submit' => 'Ir',
	'mostrevisors-showredir' => 'Mostrar página de redirección',
	'mostrevisors-hideredir' => 'Esconder páginas de redirección',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editores}}',
	'mostrevisors-viewcontributors' => 'Mostrar colaboradores principales',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'mostrevisors-namespace' => 'Nimeruum:',
	'mostrevisors-submit' => 'Mine',
	'mostrevisors-showredir' => 'Näita ümbersuunamislehekülgi',
	'mostrevisors-hideredir' => 'Peida ümbersuunamisleheküljed',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Str4nd
 */
$messages['fi'] = array(
	'mostrevisors' => 'Sivut, joilla on eniten muokkaajia',
	'mostrevisors-header' => "'''Tämä sivu luettelee tämän wikin {{PLURAL:$1|sivun, jolla|$1 sivua, joilla}} on eniten muokkaajia.'''",
	'mostrevisors-limitlinks' => 'Näytä enintään $1 sivua',
	'mostrevisors-namespace' => 'Nimiavaruus',
	'mostrevisors-none' => 'Sivuja ei löytynyt.',
	'mostrevisors-ns-header' => "'''Tällä sivulla esitetään $2 nimiavaruudessa {{PLURAL:$1|oleva sivu jolla|olevien $1 sivun luettelo sivuista}} joilla on eniten muokkaajia.'''",
	'mostrevisors-showing' => 'Esitetään {{PLURAL:$1|sivu|luettelo $1 sivusta}}:',
	'mostrevisors-submit' => 'Siirry',
	'mostrevisors-showredir' => 'Näytä ohjaussivut',
	'mostrevisors-hideredir' => 'Piilota ohjaussivut',
	'mostrevisors-users' => '– $1 {{PLURAL:$1|muokkaaja|muokkaajaa}}',
	'mostrevisors-viewcontributors' => 'Näytä päämuokkaajat',
);

/** French (Français)
 * @author IAlex
 * @author Verdy p
 */
$messages['fr'] = array(
	'mostrevisors' => 'Pages avec le plus des relecteurs',
	'mostrevisors-desc' => 'Liste les [[Special:MostRevisors|pages avec le plus de relecteurs]]',
	'mostrevisors-header' => "'''Cette page liste {{PLURAL:$1|la page|les $1 pages}} avec le plus de relecteurs sur ce wiki.'''",
	'mostrevisors-limitlinks' => "Afficher jusqu'à $1 pages",
	'mostrevisors-namespace' => 'Espace de noms :',
	'mostrevisors-none' => 'Aucune entrée trouvée.',
	'mostrevisors-ns-header' => "'''Cette page liste {{PLURAL:$1|la page|les $1 pages}} avec le plus de relecteurs sur ce wiki dans l'espace de noms $2.'''",
	'mostrevisors-showing' => 'Liste {{PLURAL:$1|de la page|des $1 pages}} :',
	'mostrevisors-submit' => 'Soumettre',
	'mostrevisors-showredir' => 'Afficher les pages de redirection',
	'mostrevisors-hideredir' => 'masquer les pages de redirection',
	'mostrevisors-users' => '– $1 modificateur{{PLURAL:$1||s}}',
	'mostrevisors-viewcontributors' => 'Voir les contributeurs principaux',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'mostrevisors' => 'Pâges avouéc lo més de rèvisors',
	'mostrevisors-limitlinks' => 'Fâre vêre tant qu’a $1 pâges',
	'mostrevisors-namespace' => 'Èspâço de noms :',
	'mostrevisors-none' => 'Gins d’entrâ trovâ.',
	'mostrevisors-showing' => 'Visualisacion de l{{PLURAL:$1|a pâge|es $1 pâges}} :',
	'mostrevisors-submit' => 'Sometre',
	'mostrevisors-showredir' => 'Fâre vêre les pâges de redirèccion',
	'mostrevisors-hideredir' => 'Cachiér les pâges de redirèccion',
	'mostrevisors-users' => '- $1 changior{{PLURAL:$1||s}}',
	'mostrevisors-viewcontributors' => 'Vêre los contributors principâls',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'mostrevisors' => 'Páxinas con máis revisores',
	'mostrevisors-desc' => 'Lista [[Special:MostRevisors|as páxinas co maior número de revisores]]',
	'mostrevisors-header' => "'''Esta páxina contén a lista {{PLURAL:$1|coa páxina|coas $1 páxinas}} con maior número de revisores do wiki.'''",
	'mostrevisors-limitlinks' => 'Mostrar ata $1 páxinas',
	'mostrevisors-namespace' => 'Espazo de nomes:',
	'mostrevisors-none' => 'Non se atopou ningunha entrada.',
	'mostrevisors-ns-header' => "'''Esta páxina contén a lista {{PLURAL:\$1|coa páxina|coas \$1 páxinas}} con maior número de revisores no espazo de nomes \"\$2\".'''",
	'mostrevisors-showing' => 'Lista {{PLURAL:$1|da páxina|das $1 páxinas}}:',
	'mostrevisors-submit' => 'Mostrar',
	'mostrevisors-showredir' => 'Mostrar as páxinas de redirección',
	'mostrevisors-hideredir' => 'Agochar as páxinas de redirección',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editores}}',
	'mostrevisors-viewcontributors' => 'Ver os principais colaboradores',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'mostrevisors-namespace' => 'Ὀνοματεῖον:',
	'mostrevisors-submit' => 'Ἰέναι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'mostrevisors' => 'Syte mit dr meischte Priefer',
	'mostrevisors-desc' => '[[Special:MostRevisors|Syte mit dr meischte Priefer]] uflischte',
	'mostrevisors-header' => "'''Die Syte lischtet d {{PLURAL:$1|Syte|$1 Syte}} uf mit dr meischte Priefer in däm Wiki.'''",
	'mostrevisors-limitlinks' => 'Zeig bis zue $1 Syte',
	'mostrevisors-namespace' => 'Namensruum:',
	'mostrevisors-none' => 'Kei Yytreg gfunde.',
	'mostrevisors-ns-header' => "'''Die Syte lischtet d {{PLURAL:$1|Syte|$1 Syte}} uf mit dr meischte Priefer im $2-Namensruum.'''",
	'mostrevisors-showing' => 'Lischtet {{PLURAL:$1|Syte|$1 Syte}} uf:',
	'mostrevisors-submit' => 'Gang',
	'mostrevisors-showredir' => 'Wyterleitigssyte zeige',
	'mostrevisors-hideredir' => 'Wyterleitigssyte verstecke',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|Bearbeiter|Bearbeiter}}',
	'mostrevisors-viewcontributors' => 'Hauptbyyträger zeige',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'mostrevisors-namespace' => 'Sararin suna:',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'mostrevisors' => 'דפים שנערכו על־ידי מספר גבוה ביותר של עורכים ייחודיים',
	'mostrevisors-desc' => 'רשימת [[Special:MostRevisors|דפים עם מספר העורכים הייחודיים הגבוה ביותר]]',
	'mostrevisors-header' => "'''בדף הזה {{PLURAL:$1|רשום הדף|רשומים $1 הדפים}} עם יותר עורכים ייחודיים מכל דף אחר בוויקי הזה.'''",
	'mostrevisors-limitlinks' => 'הצגת עד $1 דפים',
	'mostrevisors-namespace' => 'מרחב שם:',
	'mostrevisors-none' => 'לא נמצאו רשומות.',
	'mostrevisors-ns-header' => "'''בדף הזה {{PLURAL:$1|מופיע הדף|מופיעים $1 הדפים}} בעלי המספר הגבוה ביותר של עורכים ייחודיים במרחב השם $2.'''",
	'mostrevisors-showing' => 'הצגת {{PLURAL:$1|דף אחד|$1 דפים}}:',
	'mostrevisors-submit' => 'מעבר',
	'mostrevisors-showredir' => 'הצגת דפי הפניה',
	'mostrevisors-hideredir' => 'הסתרת דפי הפניה',
	'mostrevisors-users' => '- {{PLURAL:$1|עורך אחד|$1 עורכים}}',
	'mostrevisors-viewcontributors' => 'הצגת התורמים הראשיים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'mostrevisors' => 'Strony z najwjace kontrolerami',
	'mostrevisors-desc' => '[[Special:MostRevisors|Strony z najwjace kontrolerami]] nalistować',
	'mostrevisors-header' => "'''Tuta strona nalistuje {{PLURAL:$1|stronu|$1 stronje|$1 strony|$1 stronow}} z najwjace kontrolerami we wikiju.'''",
	'mostrevisors-limitlinks' => 'Hač k $1 {{PLURAL:$1|stronje|stronomaj|stronam|stronam}} pokazać',
	'mostrevisors-namespace' => 'Mjenowy rum:',
	'mostrevisors-none' => 'Žane zapiski namakane.',
	'mostrevisors-ns-header' => "'''Tuta strona nalistuje {{PLURAL:$1|stronu|$1 stronje|$1 strony|$1 stronow}} z najwjace kontrolerami w mjenowym rumje $2.'''",
	'mostrevisors-showing' => '{{PLURAL:$1|$1 strona so pokazuje|$1 stronje so pokazujetej|$1 strony so pokazuja|$1 stronow so pokazuje}}:',
	'mostrevisors-submit' => 'Wotpósłać',
	'mostrevisors-showredir' => 'Daleposrědkowanske strony pokazać',
	'mostrevisors-hideredir' => 'Daleposrědkowanske strony schować',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|wobdźěłar|wobdźěłarjej|wobdźěłarjo|wobdźěłarjow}}',
	'mostrevisors-viewcontributors' => 'Hłownych wobdźěłarjow sej wobhladać',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'mostrevisors' => 'A legtöbb hozzájárulóval rendelkező lapok',
	'mostrevisors-desc' => '[[Special:MostRevisors|Legtöbb hozzájárulóval rendelkező lapok]] listázása',
	'mostrevisors-header' => "'''Ezen a lapon a wiki legtöbb hozzájárulóval rendelkező {{PLURAL:$1|lapja|$1 lapja}} látható.'''",
	'mostrevisors-limitlinks' => '$1 lap mutatása',
	'mostrevisors-namespace' => 'Névtér:',
	'mostrevisors-none' => 'Nem találhatók bejegyzések.',
	'mostrevisors-ns-header' => "'''Ezen a lapon a wiki legtöbb hozzájárulóval rendelkező {{PLURAL:$1|lapja|$1 lapja}} látható a $2 névtérből.'''",
	'mostrevisors-showing' => '$1 lap:',
	'mostrevisors-submit' => 'Menj',
	'mostrevisors-showredir' => 'Átirányítás lapok megjelenítése',
	'mostrevisors-hideredir' => 'Átirányítás lapok elrejtése',
	'mostrevisors-users' => '– $1 szerkesztő',
	'mostrevisors-viewcontributors' => 'Fő közreműködők megtekintése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'mostrevisors' => 'Paginas con le plus contributores',
	'mostrevisors-desc' => 'Lista le [[Special:MostRevisors|paginas con le plus contributores]]',
	'mostrevisors-header' => "'''Iste pagina lista le {{PLURAL:$1|pagina|$1 paginas}} con le plus contributores in le wiki.'''",
	'mostrevisors-limitlinks' => 'Monstrar usque a $1 paginas',
	'mostrevisors-namespace' => 'Spatio de nomines:',
	'mostrevisors-none' => 'Nulle entrata ha essite trovate.',
	'mostrevisors-ns-header' => "'''Iste pagina lista le {{PLURAL:$1|pagina|$1 paginas}} con le plus contributores in le spatio de nomines $2.'''",
	'mostrevisors-showing' => 'Lista de {{PLURAL:$1|pagina|$1 paginas}}:',
	'mostrevisors-submit' => 'Va',
	'mostrevisors-showredir' => 'Revelar paginas de redirection',
	'mostrevisors-hideredir' => 'Celar paginas de redirection',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|contributor|contributores}}',
	'mostrevisors-viewcontributors' => 'Vider le contributores principal',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'mostrevisors' => 'Halaman dengan penyunting terbanyak',
	'mostrevisors-desc' => 'Daftar [[Special:MostRevisors|halaman dengan penyunting terbanyak]]',
	'mostrevisors-header' => "'''Halaman ini mendaftarkan {{PLURAL:$1||}}$1 halaman di wiki dengan penyunting terbanyak.'''",
	'mostrevisors-limitlinks' => 'Tunjukkan $1 halaman',
	'mostrevisors-namespace' => 'Ruang nama:',
	'mostrevisors-none' => 'Entri tidak ditemukan',
	'mostrevisors-ns-header' => "'''Halaman ini mendaftarkan {{PLURAL:$1||}}$1 halaman di ruang nama $2 dengan penyunting terbanyak.'''",
	'mostrevisors-showing' => 'Memperlihatkan {{PLURAL:$1||}}$1 halaman:',
	'mostrevisors-submit' => 'Tuju ke',
	'mostrevisors-showredir' => 'Tunjukkan halaman pengalihan',
	'mostrevisors-hideredir' => 'Sembunyikan halaman pengalihan',
	'mostrevisors-users' => '- $1 {{PLURAL:$1||}}penyunting',
	'mostrevisors-viewcontributors' => 'Tunjukkan penyunting utama',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author OrbiliusMagister
 */
$messages['it'] = array(
	'mostrevisors' => 'Pagine con più revisori',
	'mostrevisors-desc' => 'Elenca [[Special:MostRevisors|pagine con più revisori]]',
	'mostrevisors-header' => "'''In questa pagina {{PLURAL:$1|è elencata la pagina|sono elencate le $1 pagine}} con più revisori su questo sito.'''",
	'mostrevisors-limitlinks' => 'Mostra fino a $1 pagine',
	'mostrevisors-namespace' => 'Namespace:',
	'mostrevisors-none' => 'Nessuna pagina trovata.',
	'mostrevisors-ns-header' => "'''In questa pagina {{PLURAL:$1|è elencata la pagina|sono elencate le $1 pagine}} con più revisori nel namespace $2.'''",
	'mostrevisors-showing' => 'Elenco di {{PLURAL:$1|pagina|$1 pagine}}:',
	'mostrevisors-submit' => 'Vai',
	'mostrevisors-showredir' => 'Mostra redirect',
	'mostrevisors-hideredir' => 'Nascondi redirect',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|contributore|contributori}}',
	'mostrevisors-viewcontributors' => 'Visualizza principali contributori',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'mostrevisors' => '最も編集者の多いページ',
	'mostrevisors-desc' => '[[Special:MostRevisors|最も編集者の多いページ]]の一覧',
	'mostrevisors-header' => "'''このページは、ウィキ全体で最も編集者の多い$1ページの一覧です。'''",
	'mostrevisors-limitlinks' => '最大で$1件表示する',
	'mostrevisors-namespace' => '名前空間：',
	'mostrevisors-none' => 'ページは見つかりませんでした。',
	'mostrevisors-ns-header' => "'''このページは、$2名前空間の中で最も編集者の多い$1ページの一覧です。'''",
	'mostrevisors-showing' => '$1ページを列挙しています：',
	'mostrevisors-submit' => '表示',
	'mostrevisors-showredir' => 'リダイレクトページを表示',
	'mostrevisors-hideredir' => 'リダイレクトページを非表示',
	'mostrevisors-users' => '- $1{{PLURAL:$1|人の編集者}}',
	'mostrevisors-viewcontributors' => '主執筆者を見る',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'mostrevisors-namespace' => 'លំហឈ្មោះ៖',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'mostrevisors-namespace' => 'ನಾಮವರ್ಗ:',
	'mostrevisors-submit' => 'ಹೋಗು',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'mostrevisors' => 'Sigge met de miehßte Schriiver',
	'mostrevisors-desc' => 'Kann de [[Special:MostRevisors|Sigge met de miehßte Schriiver]] opleßte.',
	'mostrevisors-header' => "'''Heh di Sigg deiht {{PLURAL:$1|di Sigg|de $1 Sigge|kein Sigge}} ussem Wiki met de mihßte Schriiver opleste.'''",
	'mostrevisors-limitlinks' => 'Nit mieh wi $1 Sigge aanzeije',
	'mostrevisors-namespace' => 'Appachtemang:',
	'mostrevisors-none' => 'Kein Enndrääsch jefonge.',
	'mostrevisors-ns-header' => "'''Heh di Sigg deiht {{PLURAL:$1|di Sigg|de $1 Sigge|kein Sigg}} ussem Appachtemang „$2“ met de mihßte Schriiver opleßte.'''",
	'mostrevisors-showing' => 'Hee {{PLURAL:$1|kütt ein Sigg:|kumme $1 Sigge:|sen kei Sigge.}}',
	'mostrevisors-submit' => 'Lohß jonn!',
	'mostrevisors-showredir' => 'Ömleidunge zeije',
	'mostrevisors-hideredir' => 'Ömleidunge fottlohße',
	'mostrevisors-users' => ' - {{PLURAL:$1|$1 Schriiver}}',
	'mostrevisors-viewcontributors' => 'Houpschriiver',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'mostrevisors' => 'Säiten déi vun de meeschte Leit iwwerliest goufen',
	'mostrevisors-desc' => 'Weist [[Special:MostRevisors|Säiten mat de meeschte Benotzer déi iwwerliest hunn]]',
	'mostrevisors-header' => "'''Op dëser Säit {{PLURAL:$1|steet d'Säit|stinn déi $1 Säite}} mat de meeschte Benotzer déi un enger Säit vun dëser Wiki matgeschafft hunn.'''",
	'mostrevisors-limitlinks' => 'Bis zu $1 Säite weisen',
	'mostrevisors-namespace' => 'Nummraum:',
	'mostrevisors-none' => 'Näischt fonnt.',
	'mostrevisors-ns-header' => "'''Op dëser Säit {{PLURAL:$1|steet d'Säit|stinn déi $1 Säite}} mat de meeschte Benotzer déi un enger Säit am Nummraum $2 matgeschafft hunn.'''",
	'mostrevisors-showing' => '{{PLURAL:$1|Säit|$1 Säiten}} oplëschten:',
	'mostrevisors-submit' => 'Lass',
	'mostrevisors-showredir' => 'Viruleedungssäite weisen',
	'mostrevisors-hideredir' => 'Viruleedungssäite vestoppen',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|Benotzer|Benotzer}}',
	'mostrevisors-viewcontributors' => 'Weis déi Haaptmataarbechter',
);

/** Ganda (Luganda)
 * @author Kizito
 */
$messages['lg'] = array(
	'mostrevisors-namespace' => 'Kuŋaanyizo:',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'mostrevisors-namespace' => 'Vuordu pluots:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'mostrevisors' => 'Страници со највеќе уредници',
	'mostrevisors-desc' => 'Список на [[Special:MostRevisors|страници со највеќе уредници]]',
	'mostrevisors-header' => "'''На оваа страница {{PLURAL:$1|е наведена страница|се наведени $1 страници}} со највеќе уредници.'''",
	'mostrevisors-limitlinks' => 'Прикажи $1 страници',
	'mostrevisors-namespace' => 'Именски простор:',
	'mostrevisors-none' => 'Нема пронајдено записи.',
	'mostrevisors-ns-header' => "'''На оваа страница {{PLURAL:$1|е наведена страницасе наведени |$1 страници}} со највеќе уредници во именскиот простор $2.'''",
	'mostrevisors-showing' => 'Содржи {{PLURAL:$1|1 страница|$1 страници}}:',
	'mostrevisors-submit' => 'Оди',
	'mostrevisors-showredir' => 'Прикажи страници за пренасочување',
	'mostrevisors-hideredir' => 'Скриј пренасочувања',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|уредник|уредници}}',
	'mostrevisors-viewcontributors' => 'Прикажи ги главните уредници',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'mostrevisors-namespace' => 'Нэрний зай:',
	'mostrevisors-submit' => 'Явах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'mostrevisors-submit' => 'Pergi',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'mostrevisors-submit' => 'Mur',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'mostrevisors' => 'Sider med flest bidragsytere',
	'mostrevisors-desc' => 'List opp [[Special:MostRevisors|sider med flest bidragsytere]]',
	'mostrevisors-header' => "'''Denne siden lister opp {{PLURAL:$1|den siden|de $1 sidene}} med flest bidragsytere på denne wikien.'''",
	'mostrevisors-limitlinks' => 'Vis inntil $1 sider',
	'mostrevisors-namespace' => 'Navnerom:',
	'mostrevisors-none' => 'Ingen oppføringer ble funnet.',
	'mostrevisors-ns-header' => "'''Denne siden lister opp {{PLURAL:$1|den siden|de $1 sidene}} med flest bidragsytere i navnerommet $2.'''",
	'mostrevisors-showing' => 'Lister opp {{PLURAL:$1|én side|$1 sider}}:',
	'mostrevisors-submit' => 'Gå',
	'mostrevisors-showredir' => 'Vis omdirigeringssider',
	'mostrevisors-hideredir' => 'Gjem omdirigeringssider',
	'mostrevisors-users' => '- {{PLURAL:$1|én bidragsyter|$1 bidragsytere}}',
	'mostrevisors-viewcontributors' => 'Vis hovedbidragsytere',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'mostrevisors' => 'सबैभन्दा बढी संशोधनकर्ता भएका लेखहरू',
	'mostrevisors-limitlinks' => '$1 वटा सम्म पृष्ठहरू देखाउ',
	'mostrevisors-namespace' => 'नामस्थान:',
	'mostrevisors-none' => 'कुनैपनि प्रविष्ठि पाइएन।',
	'mostrevisors-ns-header' => "'''यस पृष्ठमा $2 नामस्थानमा सबैभन्दा बढी संशोधनकर्ता भएका {{PLURAL:$1|पृष्ठ|$1 पृष्ठहरू}} रहेका छन् ।'''",
	'mostrevisors-showing' => '{{PLURAL:$1|पृष्ठ|$1 पृष्ठहरू}} को लिस्ट देखाउँदै:',
	'mostrevisors-submit' => 'जाउ',
	'mostrevisors-showredir' => 'रिडाइरेक्ट पृष्ठहरू देखाउ',
	'mostrevisors-hideredir' => 'रिडाइरेक्ट पृष्ठहरू लुकाउ',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|सम्पादक|सम्पादकहरु}}',
	'mostrevisors-viewcontributors' => 'मुख्य योगदानकर्ताहरूलाइ देखाउनुहोस।',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'mostrevisors' => "Pagina's met de meeste bewerkers",
	'mostrevisors-desc' => "Geeft [[Special:MostRevisors|pagina's met de meeste bewerkers]] weer",
	'mostrevisors-header' => "'''Deze pagina bevat een lijst met de {{PLURAL:$1|pagina|$1 pagina's}} met de meeste bewerkers.'''",
	'mostrevisors-limitlinks' => "Maximaal $1 pagina's weergeven",
	'mostrevisors-namespace' => 'Naamruimte:',
	'mostrevisors-none' => "Geen pagina's gevonden.",
	'mostrevisors-ns-header' => "'''Deze pagina bevat een lijst met de {{PLURAL:$1|pagina|$1 pagina's}} met de meeste bewerkers in de naamruimte $2.'''",
	'mostrevisors-showing' => "Er {{PLURAL:$1|wordt één pagina|worden $1 pagina's}} weergegeven:",
	'mostrevisors-submit' => 'OK',
	'mostrevisors-showredir' => "Doorverwijspagina's weergeven",
	'mostrevisors-hideredir' => "Doorverwijspagina's verbergen",
	'mostrevisors-users' => '- $1 {{PLURAL:$1|bewerker|bewerkers}}',
	'mostrevisors-viewcontributors' => 'De grootste bijdragers bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'mostrevisors-limitlinks' => 'Vis opptil $1 sider',
	'mostrevisors-namespace' => 'Namnerom:',
	'mostrevisors-submit' => 'Gå',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'mostrevisors' => 'Paginas amb lo mai de relectors',
	'mostrevisors-desc' => 'Fa la lista de las [[Special:MostRevisors|paginas amb lo mai de relectors]]',
	'mostrevisors-header' => "'''Aquesta pagina fa la lista de {{PLURAL:$1|la pagina|las $1 paginas}} amb lo mai de relectors sus aqueste wiki.'''",
	'mostrevisors-limitlinks' => 'Afichar fins a $1 paginas',
	'mostrevisors-namespace' => 'Espaci de noms :',
	'mostrevisors-none' => "Cap d'entrada pas trobada.",
	'mostrevisors-ns-header' => "'''Aquesta pagina fa la lista de {{PLURAL:$1|la pagina|las $1 paginas}} amb lo mai de relectors sus aqueste wiki dins l'espaci de noms $2.'''",
	'mostrevisors-showing' => 'Lista {{PLURAL:$1|de la pagina|de las $1 paginas}} :',
	'mostrevisors-submit' => 'Sometre',
	'mostrevisors-showredir' => 'Afichar las paginas de redireccion',
	'mostrevisors-hideredir' => 'amagar las paginas de redireccion',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editors}}',
	'mostrevisors-viewcontributors' => 'Veire los contributors principals',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'mostrevisors-submit' => 'Geh los',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|Schreiwer|Schreiwer}}',
);

/** Polish (Polski)
 * @author Leinad
 * @author Odder
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'mostrevisors' => 'Strony z największą liczbą odwiedzających',
	'mostrevisors-desc' => 'Lista [[Special:MostRevisors|stron z największą liczbą odwiedzających]]',
	'mostrevisors-header' => "'''Ta strona zawiera {{PLURAL:$1|stronę|listę $1 stron}} z największa liczbą odwiedzających na tej wiki.'''",
	'mostrevisors-limitlinks' => 'Pokaż nie więcej stron niż $1',
	'mostrevisors-namespace' => 'Przestrzeń nazw',
	'mostrevisors-none' => 'Nie odnaleziono wpisów.',
	'mostrevisors-ns-header' => "'''Ta strona zawiera {{PLURAL:$1|stronę|listę $1 stron}} z największa liczbą rewizorów dla przestrzeni nazw $2.'''",
	'mostrevisors-showing' => '{{PLURAL:$1|Jedna strona|Spis $1 stron:}}',
	'mostrevisors-submit' => 'Dalej',
	'mostrevisors-showredir' => 'Pokaż przekierowania',
	'mostrevisors-hideredir' => 'Ukryj przekierowania',
	'mostrevisors-users' => '– $1 {{PLURAL:$1|edytujący|edytujących}}',
	'mostrevisors-viewcontributors' => 'Najważniejsi współautorzy',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'mostrevisors' => 'Pàgine con pì revisor',
	'mostrevisors-desc' => 'Lista le [[Special:MostRevisors|pàgine con pì revisor]]',
	'mostrevisors-header' => "'''Sta pàgina-sì a lista {{PLURAL:$1|la pàgina|le $1 pàgine}} con pì revisor an sla wiki'''.",
	'mostrevisors-limitlinks' => 'Mosta fin a $1 pàgine',
	'mostrevisors-namespace' => 'Spassi nominal:',
	'mostrevisors-none' => 'Pa trovà gnun-e pàgine.',
	'mostrevisors-ns-header' => "'''Sta pàgina-sì a lista {{PLURAL:$1|la pàgina|le $1 pàgine}} con pì revisor ant lë spassi nominal $2.'''",
	'mostrevisors-showing' => 'Listé {{PLURAL:$1|la pàgina|$1 pàgine}}:',
	'mostrevisors-submit' => 'Va',
	'mostrevisors-showredir' => 'Mosta le pàgine ëd rediression',
	'mostrevisors-hideredir' => 'Stërma le pàgine ëd rediression:',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editor}}',
	'mostrevisors-viewcontributors' => 'Varda ij contribudor prinsipaj',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'mostrevisors-limitlinks' => 'تر $1 پورې مخونه ښکاره کړی',
	'mostrevisors-namespace' => 'نوم-تشيال:',
	'mostrevisors-submit' => 'ورځه',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'mostrevisors' => 'Páginas com mais editores',
	'mostrevisors-desc' => 'Lista as [[Special:MostRevisors|páginas com mais editores]]',
	'mostrevisors-header' => "'''Esta página lista {{PLURAL:$1|a página|as $1 páginas}} com mais editores desta wiki.'''",
	'mostrevisors-limitlinks' => 'Mostrar até $1 páginas',
	'mostrevisors-namespace' => 'Espaço nominal:',
	'mostrevisors-none' => 'Nenhuma entrada encontrada.',
	'mostrevisors-ns-header' => "'''Esta página lista {{PLURAL:$1|a página|as $1 páginas}} com mais editores no espaço nominal $2.'''",
	'mostrevisors-showing' => 'Listando {{PLURAL:$1|uma página|$1 páginas}}:',
	'mostrevisors-submit' => 'Submeter',
	'mostrevisors-showredir' => 'Mostrar páginas de redireccionamento',
	'mostrevisors-hideredir' => 'Esconder páginas de redireccionamento',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editores}}',
	'mostrevisors-viewcontributors' => 'Ver os principais editores',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'mostrevisors' => 'Páginas com mais editores',
	'mostrevisors-desc' => 'Lista [[Special:MostRevisors|páginas com mais editores]]',
	'mostrevisors-header' => "'''Esta página lista {{PLURAL:$1|a página|as $1 pages}} com mais editores nesta wiki.'''",
	'mostrevisors-limitlinks' => 'Exibir até $1 {{PLURAL:$1|página|páginas}}',
	'mostrevisors-namespace' => 'Domínio:',
	'mostrevisors-none' => 'Nenhuma entrada encontrada.',
	'mostrevisors-ns-header' => "'''Esta página lista {{PLURAL:$1|a página|as $1 páginas}} com mais editores no domínio $2.'''",
	'mostrevisors-showing' => 'Listando $1 {{PLURAL:$1|página|páginas}}:',
	'mostrevisors-submit' => 'Ir',
	'mostrevisors-showredir' => 'Exibir páginas de redirecionamento',
	'mostrevisors-hideredir' => 'Esconder páginas de redirecionamento',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|editor|editores}}',
	'mostrevisors-viewcontributors' => 'Ver principais contribuidores',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'mostrevisors-namespace' => 'Spațiu de nume:',
	'mostrevisors-submit' => 'Mergeți',
	'mostrevisors-showredir' => 'Arată paginile de redirecționare',
	'mostrevisors-hideredir' => 'Ascunde paginile de redirecționare',
);

/** Russian (Русский)
 * @author EugeneZelenko
 * @author Ferrer
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'mostrevisors' => 'Страницы с наибольшим количеством редакторов',
	'mostrevisors-desc' => 'Список [[Special:MostRevisors|страниц с наибольшим количеством редакторов]]',
	'mostrevisors-header' => "'''На этой странице {{PLURAL:$1|приведена $1 страница|приведено $1 страницы|приведено $1 страниц}} с наибольшим количеством редакторов.'''",
	'mostrevisors-limitlinks' => 'Показать $1 страниц',
	'mostrevisors-namespace' => 'Пространство имён:',
	'mostrevisors-none' => 'Записей не найдено.',
	'mostrevisors-ns-header' => "'''На этой странице {{PLURAL:$1|приведена $1 страница|приведено $1 страницы|приведено $1 страниц}} с наибольшим количеством редакторов из пространства имён $2.'''",
	'mostrevisors-showing' => 'Содержит $1 {{PLURAL:$1|страницу|страницы|страниц}}:',
	'mostrevisors-submit' => 'Перейти',
	'mostrevisors-showredir' => 'Показать страницы перенаправлений',
	'mostrevisors-hideredir' => 'Скрыть страницы перенаправлений',
	'mostrevisors-users' => '— $1 {{PLURAL:$1|редактор|редактора|редакторов}}',
	'mostrevisors-viewcontributors' => 'Показать основных редакторов',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'mostrevisors-submit' => 'Перейти',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'mostrevisors' => 'Stránky s najväčším počtom kontrolórov',
	'mostrevisors-desc' => 'Zoznam [[Special:MostRevisors|stránok s najväčším počtom kontrolórov]]',
	'mostrevisors-header' => "'''Táto stránka obsahuje {{PLURAL:$1|stránku|$1 stránky|$1 stránok}} na wiki s najväčším počtom kontrolórov.'''",
	'mostrevisors-limitlinks' => 'Zobraziť najviac $1 stránok',
	'mostrevisors-namespace' => 'Menný priestor:',
	'mostrevisors-none' => 'Neboli nájdené žiadne záznamy.',
	'mostrevisors-ns-header' => "'''Táto stránka obsahuje {{PLURAL:$1|stránku|$1 stránky|$1 stránok}} na wiki s najväčším počtom kontrolórov v mennom priestore $2.'''",
	'mostrevisors-showing' => 'Zoznam {{PLURAL:$1|$1 stránky|$1 stránok}}:',
	'mostrevisors-submit' => 'Vykonať',
	'mostrevisors-showredir' => 'Zobraziť presmerovacie stránky',
	'mostrevisors-hideredir' => 'Skryť presmerovacie stránky',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|používateľ|používatelia|používateľov}}',
	'mostrevisors-viewcontributors' => 'Zobraziť hlavných prispievateľov',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'mostrevisors-namespace' => 'Именски простор:',
	'mostrevisors-submit' => 'Иди',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'mostrevisors-namespace' => 'Imenski prostor:',
	'mostrevisors-submit' => 'Idi',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'mostrevisors' => 'Sidor med flest bidragsgivare',
	'mostrevisors-desc' => 'Lista [[Special:MostRevisors|sidor med flest bidragsgivare]]',
	'mostrevisors-header' => "'''Denna sida listar {{PLURAL:$1|den sida|de $1 sidor}} med flest bidragsgivare på wikin.'''",
	'mostrevisors-limitlinks' => 'Visa upp till $1 sidor',
	'mostrevisors-namespace' => 'Namnrymd:',
	'mostrevisors-none' => 'Inga inlägg hittades',
	'mostrevisors-ns-header' => "'''Denna sida listar {{PLURAL:$1|den sida|de $1 sidor}} med flest bidragsgivare i namnrymden $2.'''",
	'mostrevisors-showing' => 'Listar {{PLURAL:$1|sida|$1 sidor}}:',
	'mostrevisors-submit' => 'Kör',
	'mostrevisors-showredir' => 'Visa omdirigeringssidor',
	'mostrevisors-hideredir' => 'Dölj omdirigeringssidor',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|bidragsgivare|bidragsgivare}}',
	'mostrevisors-viewcontributors' => 'Se huvudbidragsgivarna',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'mostrevisors-header' => "'''ఈ వికీలో ఎక్కువమంది కూర్పురులున్న {{PLURAL:$1|పుటని|$1 పుటలను}} ఈ పుట చూపిస్తుంది.'''",
	'mostrevisors-limitlinks' => '$1 పుటల వరకు చూపించు',
	'mostrevisors-namespace' => 'పేరుబరి:',
	'mostrevisors-ns-header' => "'''ఈ పుట ఎక్కువమంది కూర్పురులున్న $2 పేరుబరిలోని {{PLURAL:$1|పుటని|$1 పుటలను}} చూపిస్తుంది.'''",
	'mostrevisors-showing' => '{{PLURAL:$1|పేజీని|$1 పేజీలను}} చూపిస్తున్నాం:',
	'mostrevisors-submit' => 'వెళ్ళు',
	'mostrevisors-showredir' => 'దారిమార్పు పేజీలను చూపించు',
	'mostrevisors-hideredir' => 'దారిమార్పు పేజీలను దాచు',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|కూర్పరి|కూర్పరులు}}',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'mostrevisors-submit' => 'OK',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'mostrevisors-namespace' => 'เนมสเปซ:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'mostrevisors-submit' => 'Git',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'mostrevisors' => 'Mga pahinang may pinakamaraming mga tagapagbago',
	'mostrevisors-desc' => 'Itala ang [[Special:MostRevisors|mga pahinang may pinakamaraming mga tagapagbago]]',
	'mostrevisors-header' => "'''Nagtatala ang pahinang ito ng {{PLURAL:$1|pahina|$1 mga pahina}} na may pinakamaraming mga tagapagbago sa wiki.'''",
	'mostrevisors-limitlinks' => 'Magpakita ng hanggang sa $1 mga pahina',
	'mostrevisors-namespace' => 'Puwang na pampangalan:',
	'mostrevisors-none' => 'Walang natagpuang mga ipinasok.',
	'mostrevisors-ns-header' => "'''Nagtatala ang pahinang ito ng {{PLURAL:$1|pahina|$1 mga pahina}} na may pinakamaraming mga tagapagbago sa $2 na puwang na pampangalan.'''",
	'mostrevisors-showing' => 'Itinatala ang {{PLURAL:$1|pahina|$1 mga pahina}}:',
	'mostrevisors-submit' => 'Gawin',
	'mostrevisors-showredir' => 'Ipakita ang mga pahinang naglilipat ng pupuntahan',
	'mostrevisors-hideredir' => 'Itago ang mga pahinang nagpapalit ng pupuntahan',
	'mostrevisors-users' => '- $1 {{PLURAL:$1|patnugot|mga patnugot}}',
	'mostrevisors-viewcontributors' => 'Tingnan ang pangunahing mga tagapag-ambag',
);

/** Turkish (Türkçe)
 * @author Srhat
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'mostrevisors-namespace' => 'Ad alanı:',
	'mostrevisors-none' => 'Girdi bulunamadı.',
	'mostrevisors-submit' => 'Git',
	'mostrevisors-showredir' => 'Yönlendirme sayfalarını göster',
	'mostrevisors-hideredir' => 'Yönlendirme sayfalarını gizle',
	'mostrevisors-viewcontributors' => 'Ana katkı sahiplerini göster',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'mostrevisors-namespace' => 'Простір назв:',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'mostrevisors-namespace' => 'Nimiavaruz:',
	'mostrevisors-submit' => 'Tehta',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'mostrevisors' => 'Trang có nhiều người sửa đổi nhất',
	'mostrevisors-desc' => 'Liệt kê [[Special:MostRevisors|những trang có nhiều người sửa đổi nhất]]',
	'mostrevisors-namespace' => 'Không gian tên:',
	'mostrevisors-submit' => 'Xem',
	'mostrevisors-showredir' => 'Hiện trang đổi hướng',
	'mostrevisors-hideredir' => 'Ẩn trang đổi hướng',
	'mostrevisors-users' => '– $1 người sửa đổi',
	'mostrevisors-viewcontributors' => 'Xem các người đóng góp chính',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'mostrevisors-limitlinks' => 'ווײַזן ביז $1 בלעטער',
	'mostrevisors-namespace' => 'נאָמענטייל:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author PhiLiP
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'mostrevisors-limitlinks' => '显示 $1 个页面',
	'mostrevisors-namespace' => '名字空间：',
	'mostrevisors-submit' => '提交',
	'mostrevisors-showredir' => '显示重定向页面',
	'mostrevisors-hideredir' => '隐藏重定向页面',
	'mostrevisors-users' => '$1 次{{PLURAL:$1|编辑|编辑}}',
	'mostrevisors-viewcontributors' => '检视主要贡献者',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'mostrevisors-limitlinks' => '顯示 $1 個頁面',
	'mostrevisors-namespace' => '名字空間：',
	'mostrevisors-submit' => '提交',
	'mostrevisors-showredir' => '顯示重定向頁面',
	'mostrevisors-hideredir' => '隱藏重定向頁面',
	'mostrevisors-users' => '$1 次{{PLURAL:$1|編輯|編輯}}',
	'mostrevisors-viewcontributors' => '檢視主要貢獻者',
);

