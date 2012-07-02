<?php
/**
 * Internationalisation file for FeaturedFeeds extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Max Semenik
 */
$messages['en'] = array(
	'ffeed-desc' => "Adds syndication feeds of wiki's featured content",
	'ffeed-no-feed' => 'Feed not specified',
	'ffeed-feed-not-found' => 'Feed $1 not found',
	'ffeed-entry-not-found' => 'Feed entry for $1 not found',
	'ffeed-sidebar-section' => 'Featured content feeds',
	'ffeed-invalid-timestamp' => 'Invalid feed timestamp',
	'ffeed-enable-sidebar-links' => '-', # do not localise

	# Featured Article
	'ffeed-featured-page' => '', # do not localise
	'ffeed-featured-title' => '{{SITENAME}} featured articles feed',
	'ffeed-featured-short-title' => 'Featured articles',
	'ffeed-featured-desc' => 'Best articles {{SITENAME}} has to offer',
	'ffeed-featured-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} featured article',

	# Good Article
	'ffeed-good-page' => '', # do not localise
	'ffeed-good-title' => '{{SITENAME}} good articles feed',
	'ffeed-good-short-title' => 'Good articles',
	'ffeed-good-desc' => 'Good articles {{SITENAME}} has to offer',
	'ffeed-good-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} good article',

	# On this day...
	'ffeed-onthisday-page' => '', # do not localise
	'ffeed-onthisday-title' => '{{SITENAME}} "On this day..." feed',
	'ffeed-onthisday-short-title' => 'On this day...',
	'ffeed-onthisday-desc' => 'Historical events on this day',
	'ffeed-onthisday-entry' => 'On this day: {{LOCALMONTHNAME}} {{LOCALDAY}}',

	# Did You Know?
	'ffeed-dyk-page' => '', # do not localise
	'ffeed-dyk-title' => '{{SITENAME}} "Did You Know?" feed',
	'ffeed-dyk-short-title' => 'Did you know?',
	'ffeed-dyk-desc' => "From {{SITENAME}}'s newest content",
	'ffeed-dyk-entry' => 'Did you know?: {{LOCALMONTHNAME}} {{LOCALDAY}}',

	# Media Of The Day
	'ffeed-motd-page' => '', # do not localise
	'ffeed-motd-title' => '{{SITENAME}} media of the day feed',
	'ffeed-motd-short-title' => 'Media of the day',
	'ffeed-motd-desc' => 'Some of the finest media on {{SITENAME}}',
	'ffeed-motd-entry' => '{{SITENAME}} media of the day for {{LOCALMONTHNAME}} {{LOCALDAY}}',

	# Picture Of The Day
	'ffeed-potd-page' => '', # do not localise
	'ffeed-potd-title' => '{{SITENAME}} picture of the day feed',
	'ffeed-potd-short-title' => 'Picture of the day',
	'ffeed-potd-desc' => 'Some of the finest images on {{SITENAME}}',
	'ffeed-potd-entry' => '{{SITENAME}} picture of the day for {{LOCALMONTHNAME}} {{LOCALDAY}}',

	# Quote of the Day
	'ffeed-qotd-page' => '', # do not localise
	'ffeed-qotd-title' => '{{SITENAME}} quote of the day feed',
	'ffeed-qotd-short-title' => 'Quote of the day',
	'ffeed-qotd-desc' => 'Some of the finest quotes on {{SITENAME}}',
	'ffeed-qotd-entry' => '{{SITENAME}} quote of the day for {{LOCALMONTHNAME}} {{LOCALDAY}}',

	# Featured Text
	'ffeed-featuredtexts-page' => '', # do not localise
	'ffeed-featuredtexts-title' => '{{SITENAME}} featured texts feed',
	'ffeed-featuredtexts-short-title' => 'Featured texts',
	'ffeed-featuredtexts-desc' => 'Best texts {{SITENAME}} has to offer',
	'ffeed-featuredtexts-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} featured text',
);

/** Message documentation (Message documentation)
 * @author Max Semenik
 * @author Mormegil
 */
$messages['qqq'] = array(
	'ffeed-desc' => '{{desc}}',
	'ffeed-feed-not-found' => '$1 is feed name',
	'ffeed-entry-not-found' => '$1 is date',
	'ffeed-featured-title' => 'Title of the Featured Articles [[w:web feed|syndication feed]]',
	'ffeed-featured-desc' => 'Description of the Featured Articles [[w:web feed|syndication feed]]',
	'ffeed-featured-entry' => "Title of day's entry in the Featured Articles [[w:web feed|syndication feed]]",
	'ffeed-good-title' => 'Title of the Good Articles [[w:web feed|syndication feed]]',
	'ffeed-good-desc' => 'Description of the Good Articles [[w:web feed|syndication feed]]',
	'ffeed-good-entry' => "Title of day's entry in the Good Articles [[w:web feed|syndication feed]]",
	'ffeed-onthisday-title' => 'Title of the "On this day..." [[w:web feed|syndication feed]]',
	'ffeed-onthisday-desc' => 'Description of the "On this day..." [[w:web feed|syndication feed]]',
	'ffeed-onthisday-entry' => 'Title of day\'s entry in the "On this day..." [[w:Web feed|syndication feeds]]',
	'ffeed-dyk-title' => 'Title of the "Did you know?" [[w:web feed|syndication feed]]',
	'ffeed-dyk-desc' => 'Description of the "Did you know?" [[w:web feed|syndication feed]]',
	'ffeed-dyk-entry' => 'Title of day\'s entry in the "Did you know?" [[w:Web feed|syndication feeds]]',
	'ffeed-motd-title' => 'Title of the Media of the Day [[w:web feed|syndication feed]]',
	'ffeed-motd-desc' => 'Description of the Media of the Day [[w:web feed|syndication feed]]',
	'ffeed-motd-entry' => "Title of day's entry in the Media of the Day [[w:web feed|syndication feed]]",
	'ffeed-potd-title' => 'Title of the Picture Of The Day [[w:web feed|syndication feed]]',
	'ffeed-potd-desc' => 'Description of the Picture Of The Day [[w:web feed|syndication feed]]',
	'ffeed-potd-entry' => "Title of day's entry in the Media of the Day [[w:web feed|syndication feed]]",
	'ffeed-featuredtexts-title' => 'Title of the Featured Texts [[w:web feed|syndication feed]]',
	'ffeed-featuredtexts-desc' => 'Description of the Featured Texts [[w:web feed|syndication feed]]',
	'ffeed-featuredtexts-entry' => "Title of day's entry in the Featured Texts [[w:web feed|syndication feed]]",
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'ffeed-desc' => "Amiesta canales d'agregación del conteníu destacáu de la wiki",
	'ffeed-no-feed' => 'Nun se conseñó la canal',
	'ffeed-feed-not-found' => "Nun s'alcontró la canal $1",
	'ffeed-entry-not-found' => "Nun s'alcontró la entrada de la canal del $1",
	'ffeed-sidebar-section' => 'Canales de conteníu destacáu',
	'ffeed-invalid-timestamp' => "Marca d'hora de la canal inválida",
	'ffeed-featured-title' => 'Canal de los artículos destacaos de {{SITENAME}}',
	'ffeed-featured-short-title' => 'Artículos destacaos',
	'ffeed-featured-desc' => "Los meyores artículos qu'ufre {{SITENAME}}",
	'ffeed-featured-entry' => 'Artículu destacáu de {{SITENAME}} del {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Canal de los artículos bonos de {{SITENAME}}',
	'ffeed-good-short-title' => 'Artículos bonos',
	'ffeed-good-desc' => "Los artículos bonos qu'ufre {{SITENAME}}",
	'ffeed-good-entry' => 'Artículu bono de {{SITENAME}} del {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Canal «Tal día como güei...» de {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'Tal día como güei...',
	'ffeed-onthisday-desc' => "Socesos históricos d'esti día",
	'ffeed-onthisday-entry' => 'Tal día como güei: {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Canal "Sabíes que...?" de {{SITENAME}}',
	'ffeed-dyk-short-title' => '¿Sabíes que...?',
	'ffeed-dyk-desc' => 'Del conteníu más nuevu de {{SITENAME}}',
	'ffeed-dyk-entry' => '¿Sabíes que...?: {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Canal multimedia del día de {{SITENAME}}',
	'ffeed-motd-short-title' => 'Multimedia del día',
	'ffeed-motd-desc' => 'Esbilla de la meyor multimedia de {{SITENAME}}',
	'ffeed-motd-entry' => 'Multimedia del día de {{SITENAME}} del {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'Canal imaxe del día de {{SITENAME}}',
	'ffeed-potd-short-title' => 'Imaxe del día',
	'ffeed-potd-desc' => 'Esbilla de les meyores imaxes de {{SITENAME}}',
	'ffeed-potd-entry' => 'Imaxe del día de {{SITENAME}} del {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Canal cita del día de {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Cita del día',
	'ffeed-qotd-desc' => 'Esbilla de les meyores cites de {{SITENAME}}',
	'ffeed-qotd-entry' => 'Cita del día de {{SITENAME}} del {{LOCALDAY}} de {{LOCALMONTHNAME}}',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'ffeed-desc' => 'Дадае сындыкаваныя стужкі лепшага зьместу вікі',
	'ffeed-no-feed' => 'Стужка не пазначаная',
	'ffeed-feed-not-found' => 'Стужка $1 ня знойдзеная',
	'ffeed-entry-not-found' => 'Запіс ў стужцы за $1 ня знойдзены',
	'ffeed-sidebar-section' => 'Стужкі абранага зьместу',
	'ffeed-invalid-timestamp' => 'Няслушны(ая) дата/час стужкі',
	'ffeed-featured-title' => 'Стужка з абранымі артыкуламі {{GRAMMAR:родны|{{SITENAME}}}}',
	'ffeed-featured-short-title' => 'Абраныя артыкулы',
	'ffeed-featured-desc' => 'Найлепшыя артыкулы ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'ffeed-featured-entry' => 'Абраны артыкул {{GRAMMAR:родны|{{SITENAME}}}} за {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
	'ffeed-good-title' => 'Стужка з добрымі артыкуламі {{GRAMMAR:родны|{{SITENAME}}}}',
	'ffeed-good-short-title' => 'Добрыя артыкулы',
	'ffeed-good-desc' => 'Добрыя артыкулы ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'ffeed-good-entry' => 'Добры артыкул {{GRAMMAR:родны|{{SITENAME}}}} за {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
	'ffeed-onthisday-title' => 'Стужка {{GRAMMAR:родны|{{SITENAME}}}} «Гэты дзень у гісторыі»',
	'ffeed-onthisday-short-title' => 'У гэты дзень…',
	'ffeed-onthisday-desc' => 'Гістарычныя падзеі, якія адбыліся ў гэты дзень',
	'ffeed-onthisday-entry' => 'У гэты дзень, {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
	'ffeed-dyk-title' => 'Стужка {{GRAMMAR:родны|{{SITENAME}}}} «Ці ведаеце Вы?»',
	'ffeed-dyk-short-title' => 'Ці ведаеце Вы?',
	'ffeed-dyk-desc' => 'З новых артыкулаў {{GRAMMAR:родны|{{SITENAME}}}}',
	'ffeed-dyk-entry' => 'Ці ведаеце Вы? ({{LOCALDAY}} {{LOCALMONTHNAMEGEN}})',
	'ffeed-motd-title' => 'Стужка {{GRAMMAR:родны|{{SITENAME}}}} «Мэдыя дня»',
	'ffeed-motd-short-title' => 'Мэдыя дня',
	'ffeed-motd-desc' => 'Некаторыя найлепшыя мэдыя ў {{GRAMMAR:родны|{{SITENAME}}}}',
	'ffeed-motd-entry' => 'Мэдыя дня ў {{GRAMMAR:месны|{{SITENAME}}}} за {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
	'ffeed-potd-title' => 'Стужка {{GRAMMAR:родны|{{SITENAME}}}} «Выява дня»',
	'ffeed-potd-short-title' => 'Выява дня',
	'ffeed-potd-desc' => 'Некаторыя найлепшыя выявы ў {{GRAMMAR:родны|{{SITENAME}}}}',
	'ffeed-potd-entry' => 'Выява дня ў {{GRAMMAR:месны|{{SITENAME}}}} за {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
	'ffeed-qotd-title' => 'Стужка {{GRAMMAR:родны|{{SITENAME}}}} «Цытата дня»',
	'ffeed-qotd-short-title' => 'Цытата дня',
	'ffeed-qotd-desc' => 'Некаторыя з найлепшых цытатаў у {{GRAMMAR:месны|{{SITENAME}}}}',
	'ffeed-qotd-entry' => 'Цытата дня ў {{GRAMMAR:месны|{{SITENAME}}}} за {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
	'ffeed-featuredtexts-title' => 'Стужка з абранымі тэкстамі {{GRAMMAR:родны|{{SITENAME}}}}',
	'ffeed-featuredtexts-short-title' => 'Абраныя тэксты',
	'ffeed-featuredtexts-desc' => 'Найлепшыя тэксты ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'ffeed-featuredtexts-entry' => 'Найлепшы тэкст {{GRAMMAR:родны|{{SITENAME}}}} за {{LOCALDAY}} {{LOCALMONTHNAMEGEN}}',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'ffeed-desc' => 'Ouzhpennañ a ra gwazhioù embann danvez o tont eus ar wiki',
	'ffeed-no-feed' => "N'eo ket bet resisaet ar vammenn",
	'ffeed-feed-not-found' => "N'eo ket bet kavet ar vammenn $1",
	'ffeed-entry-not-found' => "N'eo ket bet kavet enmont ar wazh evit $1",
	'ffeed-sidebar-section' => 'Gwazhioù web evit danvez a-feson',
	'ffeed-invalid-timestamp' => 'Direizh eo ar vammenn web evit an eur hag an deiz',
	'ffeed-featured-title' => 'Gwazh web evit ar pennadoù a-feson eus {{SITENAME}}',
	'ffeed-featured-desc' => 'Ar pennadoù wellañ a gaver war {{SITENAME}}',
	'ffeed-good-short-title' => 'Pennadoù mat',
	'ffeed-good-desc' => "Pennadoù mat a c'hall {{SITENAME}} kinnig deoc'h",
	'ffeed-good-entry' => 'Pennad mat e {{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}}',
	'ffeed-onthisday-title' => '{{SITENAME}} Steudad "An devezh-se..."',
	'ffeed-onthisday-short-title' => "D'an deiz-se...",
	'ffeed-onthisday-desc' => 'Darvoudoù istorel evit an devezh-mañ',
	'ffeed-onthisday-entry' => 'An deiz-se : {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => '{{SITENAME}} Neudennad "Ha gouzout a rit ?"',
	'ffeed-dyk-short-title' => "Ha gouzout a raec'h ?",
	'ffeed-dyk-desc' => 'Deus danvez nevesañ {{SITENAME}}',
	'ffeed-dyk-entry' => 'Ha gouzout a rit ? :  {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Mediaoù an deiz {{SITENAME}}',
	'ffeed-motd-short-title' => 'Mediaoù an deiz',
	'ffeed-motd-desc' => 'Un dibab eus gwellañ mediaoù {{SITENAME}}',
	'ffeed-motd-entry' => 'Media an deiz eus {{SITENAME}} evit {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => '{{SITENAME}} steudad skeudenn an devezh',
	'ffeed-potd-short-title' => 'Skeudenn an deiz',
	'ffeed-potd-desc' => 'Un nebeut re deus skeudennoù wellañ {{SITENAME}}',
	'ffeed-potd-entry' => 'Skeudenn an deiz eus {{SITENAME}} evit {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Mammenn web arroudenn an deiz e {{SITENAME}}',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'ffeed-desc' => 'Přidává syndikační kanály pro výběr z obsahu wiki',
	'ffeed-no-feed' => 'Nebyl uveden kanál',
	'ffeed-feed-not-found' => 'Kanál $1 nenalezen',
	'ffeed-entry-not-found' => 'Záznam kanálu pro $1 nenalezen',
	'ffeed-sidebar-section' => 'Kanály s vybraným obsahem',
	'ffeed-invalid-timestamp' => 'Neplatná časová značka kanálu',
	'ffeed-featured-title' => 'Kanál nejlepších článků {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-featured-short-title' => 'Nejlepší články',
	'ffeed-featured-desc' => 'Nejlepší články, které může {{SITENAME}} nabídnout',
	'ffeed-featured-entry' => 'Článek dne {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}} na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-good-title' => 'Kanál dobrých článků {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-good-short-title' => 'Dobré články',
	'ffeed-good-desc' => 'Dobré články, které může {{SITENAME}} nabídnout',
	'ffeed-good-entry' => 'Dobrý článek na den {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}} na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-onthisday-title' => 'Kanál „Dnešek v minulosti“ na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-onthisday-short-title' => 'Dnešek v minulosti',
	'ffeed-onthisday-desc' => 'Historické události tento den',
	'ffeed-onthisday-entry' => '{{LOCALDAY}}. {{LOCALMONTHNAME}} v minulosti',
	'ffeed-dyk-title' => 'Kanál „Víte, že…?“ {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-dyk-short-title' => 'Víte, že…?',
	'ffeed-dyk-desc' => 'Ze zajímavého obsahu {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-dyk-entry' => '„Víte, že…?“ {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-motd-title' => 'Kanál souborů dne {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-motd-short-title' => 'Soubor dne',
	'ffeed-motd-desc' => 'Nejlepší multimédia na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-motd-entry' => 'Soubor dne {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}} na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-potd-title' => 'Kanál obrázků dne {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-potd-short-title' => 'Obrázek dne',
	'ffeed-potd-desc' => 'Nejlepší obrázky na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-potd-entry' => 'Obrázek dne {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}} na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-qotd-title' => 'Kanál citátů dne {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-qotd-short-title' => 'Citát dne',
	'ffeed-qotd-desc' => 'Nejlepší citáty na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-qotd-entry' => 'Citát dne {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}} na {{grammar:6sg|{{SITENAME}}}}',
	'ffeed-featuredtexts-title' => 'Kanál vybraných textů {{grammar:2sg|{{SITENAME}}}}',
	'ffeed-featuredtexts-short-title' => 'Vybrané texty',
	'ffeed-featuredtexts-desc' => 'Nejlepší texty, které může {{SITENAME}} nabídnout',
	'ffeed-featuredtexts-entry' => 'Vybraný text na {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}} na {{grammar:6sg|{{SITENAME}}}}',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'ffeed-desc' => 'Ermöglicht gesonderte Feeds zu bestimmten Inhalten des Wikis',
	'ffeed-no-feed' => 'Es wurde kein Feed angegeben',
	'ffeed-feed-not-found' => 'Feed $1 wurde nicht gefunden',
	'ffeed-entry-not-found' => 'Feedeintrag $1 wurde nicht gefunden',
	'ffeed-sidebar-section' => 'Feeds zu empfohlenen Inhalten',
	'ffeed-invalid-timestamp' => 'Ungültiger Feed-Zeitstempel',
	'ffeed-featured-title' => 'Feed zu exzellenten Artikeln auf {{SITENAME}}',
	'ffeed-featured-short-title' => 'Exzellente Artikel',
	'ffeed-featured-desc' => 'Die exzellenten Artikel auf {{SITENAME}}',
	'ffeed-featured-entry' => 'Am {{LOCALDAY}}. {{LOCALMONTHNAME}} auf {{SITENAME}} exzellenter Artikel',
	'ffeed-good-title' => 'Feed zu den lesenswerten Artikeln auf {{SITENAME}}',
	'ffeed-good-short-title' => 'Lesenswerte Artikel',
	'ffeed-good-desc' => 'Die lesenswerten Artikel auf {{SITENAME}}',
	'ffeed-good-entry' => 'Am {{LOCALDAY}}. {{LOCALMONTHNAME}} auf {{SITENAME}} lesenswerter Artikel',
	'ffeed-onthisday-title' => 'Feed zu „An diesem Tag …“ auf {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'An diesem Tag …',
	'ffeed-onthisday-desc' => 'Historische Ereignisse dieses Tages',
	'ffeed-onthisday-entry' => 'An diesem Tag: {{LOCALDAY}}. {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Feed zu „Schon gewusst?“ auf {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Schon gewusst?',
	'ffeed-dyk-desc' => 'Die neuesten Inhalte auf {{SITENAME}}',
	'ffeed-dyk-entry' => '„Schon gewusst?“: {{LOCALDAY}}. {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Feed zur Mediendatei des Tages auf {{SITENAME}}',
	'ffeed-motd-short-title' => 'Mediendatei des Tages',
	'ffeed-motd-desc' => 'Einige der besten Mediendateien auf {{SITENAME}}',
	'ffeed-motd-entry' => 'Mediendatei des Tages am {{LOCALDAY}}. {{LOCALMONTHNAME}} auf {{SITENAME}}',
	'ffeed-potd-title' => 'Feed zum Bild des Tages auf {{SITENAME}}',
	'ffeed-potd-short-title' => 'Bild des Tages',
	'ffeed-potd-desc' => 'Einige der besten Bilder auf {{SITENAME}}',
	'ffeed-potd-entry' => 'Bild des Tages am {{LOCALDAY}}. {{LOCALMONTHNAME}} auf {{SITENAME}}',
	'ffeed-qotd-title' => 'Feed zum Zitat des Tages auf {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Zitat des Tages',
	'ffeed-qotd-desc' => 'Einige der besten Zitate auf {{SITENAME}}',
	'ffeed-qotd-entry' => 'Zitat des Tages am {{LOCALDAY}}. {{LOCALMONTHNAME}} auf {{SITENAME}}',
	'ffeed-featuredtexts-title' => 'Feed zu exzellenten Texten auf {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Exzellente Texte',
	'ffeed-featuredtexts-desc' => 'Die besten Texte auf {{SITENAME}}',
	'ffeed-featuredtexts-entry' => 'Am {{LOCALDAY}}. {{LOCALMONTHNAME}} auf {{SITENAME}} exzellenter Text',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'ffeed-desc' => 'Dodawa syndikaciske kanale wuběrnego wikiwopśimjeśa.',
	'ffeed-no-feed' => 'Kanal njepódany',
	'ffeed-feed-not-found' => 'Kanal $1 njenamakany',
	'ffeed-entry-not-found' => 'Kanalowy zapisk za $1 njenamakany',
	'ffeed-sidebar-section' => 'Kanale dopóruconych wopśimjeśow',
	'ffeed-invalid-timestamp' => 'Njepłaśiwy kanalowy casowy kołk',
	'ffeed-featured-title' => '{{SITENAME}} - kanal wuběrnych nastawkow',
	'ffeed-featured-short-title' => 'Dopórucone nastawki',
	'ffeed-featured-desc' => 'Nejlěpše nastawki, kótarež {{SITENAME}} póbitujo',
	'ffeed-featured-entry' => '{{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}  {{SITENAME}} - wuběrny nastawk',
	'ffeed-good-title' => '{{SITENAME}} - kanal dobrych nastawkow',
	'ffeed-good-short-title' => 'Dobre nastawki',
	'ffeed-good-desc' => 'Dobre nastawki, kótarež {{SITENAME}} póbitujo',
	'ffeed-good-entry' => '{{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}  {{SITENAME}} - dobry nastawk',
	'ffeed-onthisday-title' => '{{SITENAME}} - kanal "Toś ten źeń..."',
	'ffeed-onthisday-short-title' => 'Toś ten źeń...',
	'ffeed-onthisday-desc' => 'Historiske tšojenja na toś ten źeń',
	'ffeed-onthisday-entry' => 'Toś ten źeń: {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-dyk-title' => '{{SITENAME}} - kanal "Sćo wěželi, až...?"',
	'ffeed-dyk-short-title' => 'Sy južo wěźeł?',
	'ffeed-dyk-desc' => 'Nejnowše wopśimjeśe z {{GRAMMAR:genitiw|{{SITENAME}}}}',
	'ffeed-dyk-entry' => 'Sćo wěźeli, až...?: {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-motd-title' => 'Kanal mediuma dnja na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-motd-short-title' => 'Medium dnja',
	'ffeed-motd-desc' => 'Někotare z nejlěpšych mediumow na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-motd-entry' => '{{SITENAME}} - medium dnja za {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-potd-title' => '{{SITENAME}} - kanal wobraz dnja',
	'ffeed-potd-short-title' => 'Wobraz dnja',
	'ffeed-potd-desc' => 'Někotare z nejlěpšych wobrazow na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-potd-entry' => '{{SITENAME}} - wobraz dnja za {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-qotd-title' => 'Kanal citata dnja na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-qotd-short-title' => 'Citat dnja',
	'ffeed-qotd-desc' => 'Někotare z nejlěpšych citatow na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-qotd-entry' => '{{SITENAME}} - citat dnja za {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-featuredtexts-title' => '{{SITENAME}} - kanal wuběrnych tekstow',
	'ffeed-featuredtexts-short-title' => 'Wuběrne teksty',
	'ffeed-featuredtexts-desc' => 'Nejlěpše teksty, kótarež {{SITENAME}} póbitujo',
	'ffeed-featuredtexts-entry' => '{{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}  {{SITENAME}} - wuběrny tekst',
);

/** Spanish (Español)
 * @author Armando-Martin
 */
$messages['es'] = array(
	'ffeed-desc' => 'Agrega fuentes web (feeds) de sindicación de contenido destacado del wiki',
	'ffeed-no-feed' => 'Fuente web (feed) no especificada',
	'ffeed-feed-not-found' => 'Fuente web (feed) $1 no encontrada',
	'ffeed-entry-not-found' => 'Entrada de fuente web (feed) para $1 no encontrada',
	'ffeed-sidebar-section' => 'Fuentes web (feed) de contenido destacado',
	'ffeed-invalid-timestamp' => 'Fecha y hora de la fuente web (feed) inválida',
	'ffeed-featured-title' => 'Fuente web (feed) de artículos destacados de {{SITENAME}}',
	'ffeed-featured-short-title' => 'Artículos destacados',
	'ffeed-featured-desc' => 'Mejores artículos que {{SITENAME}} puede ofrecer',
	'ffeed-featured-entry' => 'Artículo destacado de {{SITENAME}} el {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Fuente web (feed) de artículos buenos de {{SITENAME}}',
	'ffeed-good-short-title' => 'Artículos buenos',
	'ffeed-good-desc' => 'Artículos buenos que {{SITENAME}} puede ofrecer',
	'ffeed-good-entry' => 'Artículo bueno de {{SITENAME}} el {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Fuente web (feed) "De este día..." en {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'En este día...',
	'ffeed-onthisday-desc' => 'Acontecimientos históricos en este día',
	'ffeed-onthisday-entry' => 'En este día: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Fuente web (feed) "¿Sabía Vd. que..." en {{SITENAME}}',
	'ffeed-dyk-short-title' => '¿Sabía usted?',
	'ffeed-dyk-desc' => 'Del contenido más reciente de {{SITENAME}}',
	'ffeed-dyk-entry' => '¿Sabía usted?: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Fuente web (feed) de Medios de comunicación del día en {{SITENAME}}',
	'ffeed-motd-short-title' => 'Medios de comunicación del día',
	'ffeed-motd-desc' => 'Algunos de los mejores medios de comunicación en {{SITENAME}}',
	'ffeed-motd-entry' => 'Medios de comunicación del día {{LOCALDAY}} {{LOCALMONTHNAME}} en {{SITENAME}}',
	'ffeed-potd-title' => 'Fuente web (feed) de Imagen del día en {{SITENAME}}',
	'ffeed-potd-short-title' => 'Imagen del día',
	'ffeed-potd-desc' => 'Algunas de las mejores imágenes en {{SITENAME}}',
	'ffeed-potd-entry' => 'Imagen del día {{LOCALDAY}} {{LOCALMONTHNAME}} en {{SITENAME}}',
	'ffeed-qotd-title' => 'Fuente web (feed) de Cita del día en {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Cita del día',
	'ffeed-qotd-desc' => 'Algunas de las mejores citas en {{SITENAME}}',
	'ffeed-qotd-entry' => 'Cita del día {{LOCALDAY}} {{LOCALMONTHNAME}} en {{SITENAME}}',
	'ffeed-featuredtexts-title' => 'Fuente web (feed) de textos destacados de {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Textos destacados',
	'ffeed-featuredtexts-desc' => 'Mejores textos {{SITENAME}} puede ofrecer',
	'ffeed-featuredtexts-entry' => 'Texto destacado de {{SITENAME}} el {{LOCALDAY}} {{LOCALMONTHNAME}}',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'ffeed-potd-short-title' => 'Päivän kuva',
);

/** French (Français)
 * @author Gomoko
 * @author Jean-Frédéric
 * @author Tpt
 */
$messages['fr'] = array(
	'ffeed-desc' => 'Ajoute des flux de publication du contenu du wiki',
	'ffeed-no-feed' => 'Source non spécifiée',
	'ffeed-feed-not-found' => 'Source $1 non trouvée',
	'ffeed-entry-not-found' => 'Entrée du flux pour $1 non trouvée',
	'ffeed-sidebar-section' => 'Alimentations de contenu caractéristique',
	'ffeed-invalid-timestamp' => "Horodatage d'alimentation invalide",
	'ffeed-featured-title' => "Liste d'articles labellisés de {{SITENAME}}",
	'ffeed-featured-short-title' => 'Articles en vedette',
	'ffeed-featured-desc' => 'Meilleurs articles que {{SITENAME}} peut offrir',
	'ffeed-featured-entry' => 'Article vedette de {{SITENAME}} le {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Alimentation des bons articles de {{SITENAME}}',
	'ffeed-good-short-title' => 'Bons articles',
	'ffeed-good-desc' => 'Bons articles que {{SITENAME}} peut offrir',
	'ffeed-good-entry' => 'Bon article de {{SITENAME}} {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-onthisday-title' => 'Flux "Ce jour-là..." de {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'Ce jour-là...',
	'ffeed-onthisday-desc' => 'Événements historiques sur cette journée',
	'ffeed-onthisday-entry' => 'Ce jour-là: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Le savez-vous ? de {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Le saviez-vous?',
	'ffeed-dyk-desc' => 'Du contenu le plus récent de {{SITENAME}}',
	'ffeed-dyk-entry' => 'Le saviez-vous ? {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Médias du jour de {{SITENAME}}',
	'ffeed-motd-short-title' => 'Les médias du jour.',
	'ffeed-motd-desc' => 'Quelques-uns des meilleurs médias sur {{SITENAME}}',
	'ffeed-motd-entry' => 'Média du jour de {{SITENAME}} pour le {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'Images du jour de {{SITENAME}}',
	'ffeed-potd-short-title' => 'Image du jour',
	'ffeed-potd-desc' => 'Quelques-unes des meilleures images de {{SITENAME}}',
	'ffeed-potd-entry' => 'Image du jour de {{SITENAME}} pour le {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Alimentation de la citation de {{SITENAME}} du jour',
	'ffeed-qotd-short-title' => 'Citation du jour',
	'ffeed-qotd-desc' => 'Quelques-unes de meilleurs citations sur {{SITENAME}}',
	'ffeed-qotd-entry' => 'Citation du jour de {{SITENAME}} pour le {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-featuredtexts-title' => 'Liste de textes mis en valeur de {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Textes mis en valeur',
	'ffeed-featuredtexts-desc' => 'Meilleurs textes que {{SITENAME}} peut offrir',
	'ffeed-featuredtexts-entry' => 'Texte de {{SITENAME}} mis en valeur le {{LOCALDAY}} {{LOCALMONTHNAME}}',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'ffeed-desc' => 'Engade fontes de novas dos contidos destacados do wiki',
	'ffeed-no-feed' => 'Non se especificou a fonte de novas',
	'ffeed-feed-not-found' => 'Non se atopou a fonte de novas "$1"',
	'ffeed-entry-not-found' => 'Non se atopou a entrada da fonte de novas do día $1',
	'ffeed-sidebar-section' => 'Fontes de novas dos contidos destacados',
	'ffeed-invalid-timestamp' => 'A data e a hora da fonte de novas son incorrectas',
	'ffeed-featured-title' => 'Fonte de novas dos artigos destacados de {{SITENAME}}',
	'ffeed-featured-short-title' => 'Artigos destacados',
	'ffeed-featured-desc' => 'Os mellores artigos que ofrece {{SITENAME}}',
	'ffeed-featured-entry' => 'Artigo destacado de {{SITENAME}} o {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Fonte de novas dos artigos bos de {{SITENAME}}',
	'ffeed-good-short-title' => 'Artigos bos',
	'ffeed-good-desc' => 'Os bos artigos que ofrece {{SITENAME}}',
	'ffeed-good-entry' => 'Artigo bo de {{SITENAME}} o {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Fonte de novas "Tal día como hoxe no ano..." de {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'Tal día como hoxe no ano...',
	'ffeed-onthisday-desc' => 'Acontecementos históricos deste día',
	'ffeed-onthisday-entry' => 'Tal día como hoxe: {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Fonte de novas "Sabía que...?" de {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Sabía que...?',
	'ffeed-dyk-desc' => 'Dos contidos máis recentes de {{SITENAME}}',
	'ffeed-dyk-entry' => 'Sabía que...?: {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Fonte de novas do ficheiro multimedia do día de {{SITENAME}}',
	'ffeed-motd-short-title' => 'Ficheiro multimedia do día',
	'ffeed-motd-desc' => 'Un dos mellores ficheiros multimedia de {{SITENAME}}',
	'ffeed-motd-entry' => 'Ficheiro multimedia do día de {{SITENAME}} o {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'Fonte de novas da imaxe do día de {{SITENAME}}',
	'ffeed-potd-short-title' => 'Imaxe do día',
	'ffeed-potd-desc' => 'Unha das mellores imaxes de {{SITENAME}}',
	'ffeed-potd-entry' => 'Imaxe do día de {{SITENAME}} o {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Fonte de novas da cita do día de {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Cita do día',
	'ffeed-qotd-desc' => 'Unha das mellores citas de {{SITENAME}}',
	'ffeed-qotd-entry' => 'Cita do día de {{SITENAME}} o {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-featuredtexts-title' => 'Fonte de novas dos textos destacados de {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Textos destacados',
	'ffeed-featuredtexts-desc' => 'Os mellores textos que ofrece {{SITENAME}}',
	'ffeed-featuredtexts-entry' => 'Texto destacado de {{SITENAME}} o {{LOCALDAY}} de {{LOCALMONTHNAME}}',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'ffeed-no-feed' => 'ફીડ સ્પષ્ટ કરેલ નથી',
	'ffeed-feed-not-found' => 'ફીડ $1 મળી નહી',
	'ffeed-entry-not-found' => '$1 માટે ફીડ દાખલો મળ્યો નથી',
	'ffeed-sidebar-section' => 'ઉમદા માહિતીની ફીડ',
	'ffeed-invalid-timestamp' => 'અયોગ્ય ફીડ સમયછાપ',
	'ffeed-featured-title' => '{{SITENAME}} ઉમદા લેખોની ફીડ',
	'ffeed-featured-short-title' => 'નિર્વાચીત લેખ',
	'ffeed-featured-desc' => '{{SITENAME}} ના આદર્શ લેખ',
	'ffeed-featured-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} ઉમદા લેખ',
	'ffeed-good-title' => '{{SITENAME}} ઉમદા લેખોની ફીડ',
	'ffeed-good-short-title' => 'ઉમદા લેખો',
	'ffeed-good-desc' => '{{SITENAME}} ના આદર્શ લેખ',
	'ffeed-good-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} ઉમદા લેખ',
	'ffeed-onthisday-title' => '{{SITENAME}} "આ દિવસે..." ફીડ',
	'ffeed-onthisday-short-title' => 'આ દિવસે...',
	'ffeed-onthisday-desc' => 'આ દિવસની ઐતહાસિક ઘટનાઓ',
	'ffeed-onthisday-entry' => 'આ દિવસે: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-dyk-title' => '{{SITENAME}} "શું તમે જાણો છો?" ફીડ',
	'ffeed-dyk-short-title' => 'શું તમે જાણો છો?',
	'ffeed-dyk-desc' => '{{SITENAME}} ની નવીનત્તમ ઉમેરો',
	'ffeed-dyk-entry' => 'શું તમે જાણો છો?: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-motd-title' => '{{SITENAME}} નું આજની મીડિયા',
	'ffeed-motd-short-title' => 'આજનું માધ્યમ',
	'ffeed-motd-desc' => '{{SITENAME}} પરની શ્રેષ્ઠ મીડિયા',
	'ffeed-motd-entry' => '{{SITENAME}} નું {{LOCALMONTHNAME}} {{LOCALDAY}} માટેનું આજનું મિડિયા',
	'ffeed-potd-title' => 'આજ નું ચિત્ર નો સ્ત્રોત {{SITENAME}} પરથી',
	'ffeed-potd-short-title' => 'આજનું ચિત્ર',
	'ffeed-potd-desc' => '{{SITENAME}} પરની શ્રેષ્ઠ ચિત્રો',
	'ffeed-potd-entry' => '{{SITENAME}} નું {{LOCALMONTHNAME}} {{LOCALDAY}} માટે આજનું ચિત્ર',
	'ffeed-qotd-title' => '{{SITENAME}} નું આજનું મુક્તક',
	'ffeed-qotd-short-title' => 'આજનું અવતરણ',
	'ffeed-qotd-desc' => '{{SITENAME}} પરનાં કેટલાંક શ્રેષ્ઠ અવતરણો',
	'ffeed-qotd-entry' => '{{SITENAME}} નું {{LOCALMONTHNAME}} {{LOCALDAY}} માટે આજનું અવતરણ',
	'ffeed-featuredtexts-title' => '{{SITENAME}} નો નિર્વાચિત લેખ',
	'ffeed-featuredtexts-short-title' => 'વિશિષ્ટ લેખ',
	'ffeed-featuredtexts-desc' => '{{SITENAME}} ના આદર્શ લેખ',
	'ffeed-featuredtexts-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} ઉમદા લેખ',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Nirofir
 */
$messages['he'] = array(
	'ffeed-desc' => 'הוספת הזנה לתוכן מומלץ בוויקי',
	'ffeed-no-feed' => 'לא צוינה הזנה',
	'ffeed-feed-not-found' => 'ההזנה $1 לא נמצאה',
	'ffeed-entry-not-found' => 'לא נמצאה הזנה עבור $1',
	'ffeed-sidebar-section' => 'הזנות תוכן מומלץ',
	'ffeed-invalid-timestamp' => 'חותם זמן לא תקין להזנה',
	'ffeed-featured-title' => 'הזנת ערכים מומלצים ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-featured-short-title' => 'ערכים מומלצים',
	'ffeed-featured-desc' => 'הערכים הטובים ביותר שיש ל{{GRAMMAR:תחילית|{{SITENAME}}}} להציע',
	'ffeed-featured-entry' => 'ערך מומלץ ב{{GRAMMAR:תחילית|{{SITENAME}}}} ב־{{LOCALDAY}} ב{{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'הזנת ערכים טובים ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-good-short-title' => 'ערכים טובים',
	'ffeed-good-desc' => 'ערכים טובים שיש ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-good-entry' => 'ערך טוב ב{{GRAMMAR:תחילית|{{SITENAME}}}} ב־{{LOCALDAY}} ב{{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'הזנת "היום בהיסטוריה" ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-onthisday-short-title' => 'היום בהיסטוריה',
	'ffeed-onthisday-desc' => 'אירועים היסטוריים ביום הזה',
	'ffeed-onthisday-entry' => 'היום בהיסטוריה: {{LOCALDAY}} ב־{{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'הזנת "הידעת?" של {{SITENAME}}',
	'ffeed-dyk-short-title' => 'הידעת?',
	'ffeed-dyk-desc' => 'מבחר מהתוכן החדש ביותר באתר {{SITENAME}}',
	'ffeed-dyk-entry' => 'הידעת? – {{LOCALDAY}} ב{{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'הזנת קובץ המדיה של היום ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-motd-short-title' => 'קובץ המדיה הטוב של היום',
	'ffeed-motd-desc' => 'קובצי המדיה הטובים ביותר ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-motd-entry' => 'הזנת קובץ היום ב{{GRAMMAR:תחילית|{{SITENAME}}}} ב־{{LOCALDAY}} ב{{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'הזנת תמונת היום ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-potd-short-title' => 'תמונת היום',
	'ffeed-potd-desc' => 'מבחר מהתמונות הטובות ביותר ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-potd-entry' => 'תמונת היום ב{{GRAMMAR:תחילית|{{SITENAME}}}} עבור {{LOCALDAY}} ב{{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'ציטוט היום ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-qotd-short-title' => 'ציטוט היום',
	'ffeed-qotd-desc' => 'הציטוטים הטובים ביותר ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-qotd-entry' => 'ציטוט היום ב{{GRAMMAR:תחילית|{{SITENAME}}}} ב־{{LOCALDAY}} ב{{LOCALMONTHNAME}}',
	'ffeed-featuredtexts-title' => 'טקסטים מומלצים ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-featuredtexts-short-title' => 'טקסטים מומלצים',
	'ffeed-featuredtexts-desc' => 'הטקסטים הטובים ביותר ב{{GRAMMAR:תחילית|{{SITENAME}}}}',
	'ffeed-featuredtexts-entry' => 'טקסט מומלץ ב{{GRAMMAR:תחילית|{{SITENAME}}}} ב־{{LOCALDAY}} ב{{LOCALMONTHNAME}}',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'ffeed-desc' => 'Přidawa syndikaciske kanale wuběrneho wikiwobsaha.',
	'ffeed-no-feed' => 'Kanal njepodaty',
	'ffeed-feed-not-found' => 'Kanal $1 njenamakany',
	'ffeed-entry-not-found' => 'Kanalowy zapisk za $1 njenamakany',
	'ffeed-sidebar-section' => 'Kanale doporučenych wobsahow',
	'ffeed-invalid-timestamp' => 'Njepłaćiwy kanalowy časowy kołk',
	'ffeed-featured-title' => '{{SITENAME}} - kanal wuběrnych nastawkow',
	'ffeed-featured-short-title' => 'Doporučene nastawki',
	'ffeed-featured-desc' => 'Najlěpše nastawki, kotrež {{SITENAME}} poskića',
	'ffeed-featured-entry' => '{{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}  {{SITENAME}} wuběrny nastawk',
	'ffeed-good-title' => '{{SITENAME}} - kanal dobrych nastawkow',
	'ffeed-good-short-title' => 'Dobre nastawki',
	'ffeed-good-desc' => 'Dobre nastawki, kotrež {{SITENAME}} poskića',
	'ffeed-good-entry' => '{{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}  {{SITENAME}} dobry nastawk',
	'ffeed-onthisday-title' => '{{SITENAME}} - kanal "Tutón dźeń..."',
	'ffeed-onthisday-short-title' => 'Tutón dźeń...',
	'ffeed-onthisday-desc' => 'Historiske podawki na tutón dźeń',
	'ffeed-onthisday-entry' => 'Tutón dźeń: {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-dyk-title' => '{{SITENAME}} - kanal "Wěš ty, zo...?"',
	'ffeed-dyk-short-title' => 'Sy hižo wědźał?',
	'ffeed-dyk-desc' => 'Najnowši wobsah z {{GRAMMAR:genitiw|{{SITENAME}}}}',
	'ffeed-dyk-entry' => 'Wěš ty, zo...?: {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-motd-title' => 'Kanal medija dnja na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-motd-short-title' => 'Medij dnja',
	'ffeed-motd-desc' => 'Někotre z najlěpšich medijow na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-motd-entry' => '{{SITENAME}} - medij dnja za {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-potd-title' => '{{SITENAME}} - kanal wobraz dnja',
	'ffeed-potd-short-title' => 'Wobraz dnja',
	'ffeed-potd-desc' => 'Někotre z najlěpšich wobrazow na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-potd-entry' => '{{SITENAME}} - wobraz dnja za {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-qotd-title' => 'Kanal citata dnja na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-qotd-short-title' => 'Citat dnja',
	'ffeed-qotd-desc' => 'Někotre z najlěpšich citatow na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'ffeed-qotd-entry' => '{{SITENAME}} - medij dnja za {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
	'ffeed-featuredtexts-title' => '{{SITENAME}} - kanal wuběrnych nastawkow',
	'ffeed-featuredtexts-short-title' => 'Wuběrne teksty',
	'ffeed-featuredtexts-desc' => 'Najlěpše teksty, kotrež {{SITENAME}} poskića',
	'ffeed-featuredtexts-entry' => 'Wuběrny tekst na {{GRAMMAR:lokatiw|{{SITENAME}}}} {{LOCALDAY}}. {{LOCALMONTHNAMEGEN}}',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 */
$messages['hu'] = array(
	'ffeed-featured-short-title' => 'Kiemelt szócikkek',
	'ffeed-featured-desc' => 'A {{SITENAME}} legjobb szócikkei',
	'ffeed-featured-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}}-kiemelt szócikk',
	'ffeed-potd-short-title' => 'A nap képe',
	'ffeed-qotd-short-title' => 'A nap idézete',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'ffeed-desc' => 'Adde fluxos de syndication del contento eminente de iste wiki',
	'ffeed-no-feed' => 'Syndication non specificate',
	'ffeed-feed-not-found' => 'Syndication $1 non trovate',
	'ffeed-entry-not-found' => 'Entrata de syndication pro $1 non trovate',
	'ffeed-sidebar-section' => 'Syndicationes de contento eminente',
	'ffeed-invalid-timestamp' => 'Data e hora de syndication invalide',
	'ffeed-featured-title' => 'Syndication de articulos eminente de {{SITENAME}}',
	'ffeed-featured-short-title' => 'Articulos eminente',
	'ffeed-featured-desc' => 'Le melior articulos que {{SITENAME}} pote offerer',
	'ffeed-featured-entry' => 'Articulo eminente de {{SITENAME}} le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Syndication de bon articulos de {{SITENAME}}',
	'ffeed-good-short-title' => 'Bon articulos',
	'ffeed-good-desc' => 'Bon articulos que {{SITENAME}} pote offerer',
	'ffeed-good-entry' => 'Bon articulo de {{SITENAME}} le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Syndication "In iste die..." de {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'In iste die...',
	'ffeed-onthisday-desc' => 'Eventos historic in iste die',
	'ffeed-onthisday-entry' => 'In iste die: le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Syndication "Sapeva tu?" de {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Sapeva tu?',
	'ffeed-dyk-desc' => 'Del contento le plus recente de {{SITENAME}}',
	'ffeed-dyk-entry' => 'Sapeva tu?: le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Syndication "Multimedia del die" de {{SITENAME}}',
	'ffeed-motd-short-title' => 'Multimedia del die',
	'ffeed-motd-desc' => 'Alcunes del melior materiales in {{SITENAME}}',
	'ffeed-motd-entry' => 'Material del die de {{SITENAME}} le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'Syndication "Imagine del die" de {{SITENAME}}',
	'ffeed-potd-short-title' => 'Imagine del die',
	'ffeed-potd-desc' => 'Alcunes del melior imagines in {{SITENAME}}',
	'ffeed-potd-entry' => 'Imagine del die de {{SITENAME}} le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Syndication "Citation del die" de {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Citation del die',
	'ffeed-qotd-desc' => 'Alcunes del melior citationes in {{SITENAME}}',
	'ffeed-qotd-entry' => 'Citation del die de {{SITENAME}} le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
	'ffeed-featuredtexts-title' => 'Syndication de textos eminente de {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Textos eminente',
	'ffeed-featuredtexts-desc' => 'Le melior textos que {{SITENAME}} pote offerer',
	'ffeed-featuredtexts-entry' => 'Texto eminente de {{SITENAME}} le {{LOCALDAY}} de {{LOCALMONTHNAME}}',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'ffeed-desc' => '위키의 알찬 컨텐츠에 대한 피드를 제공',
	'ffeed-no-feed' => '피드가 제시되지 않았습니다.',
	'ffeed-feed-not-found' => '$1 피드가 없습니다',
	'ffeed-entry-not-found' => '$1 피드 항목이 없습니다.',
	'ffeed-sidebar-section' => '알찬 컨텐츠 피드',
	'ffeed-invalid-timestamp' => '피드 타임스탬프가 잘못되었습니다.',
	'ffeed-featured-title' => '{{SITENAME}} 알찬 글 피드',
	'ffeed-featured-short-title' => '알찬 글',
	'ffeed-featured-desc' => '{{SITENAME}}이(가) 제공하는 최고의 문서',
	'ffeed-featured-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}}일 {{SITENAME}} 알찬 글',
	'ffeed-good-title' => '{{SITENAME}} 좋은 글 피드',
	'ffeed-good-short-title' => '좋은 글',
	'ffeed-good-desc' => '{{SITENAME}}에 등재된 고품질 문서',
	'ffeed-good-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}}일 {{SITENAME}} 좋은 글',
	'ffeed-onthisday-title' => '{{SITENAME}} "오늘의 역사..." 피드',
	'ffeed-onthisday-short-title' => '오늘의 역사...',
	'ffeed-onthisday-desc' => '이 날에 있었던 역사적 사건',
	'ffeed-onthisday-entry' => '오늘의 역사: {{LOCALMONTHNAME}} {{LOCALDAY}}일',
	'ffeed-dyk-title' => '{{SITENAME}} "알고 계십니까?" 피드',
	'ffeed-dyk-short-title' => '알고 계십니까?',
	'ffeed-dyk-desc' => '{{SITENAME}}의 최신 정보에서 가져온 것입니다.',
	'ffeed-dyk-entry' => '알고 계십니까?: {{LOCALMONTHNAME}} {{LOCALDAY}}일',
	'ffeed-motd-title' => '{{SITENAME}} 오늘의 미디어 피드',
	'ffeed-motd-short-title' => '오늘의 미디어',
	'ffeed-motd-desc' => '{{SITENAME}}의 가장 좋은 미디어 자료',
	'ffeed-motd-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}}일 {{SITENAME}} 오늘의 미디어',
	'ffeed-potd-title' => '{{SITENAME}} 오늘의 그림 피드',
	'ffeed-potd-short-title' => '오늘의 그림',
	'ffeed-potd-desc' => '{{SITENAME}}의 가장 좋은 그림',
	'ffeed-potd-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}}일 {{SITENAME}} 오늘의 그림',
	'ffeed-qotd-title' => '{{SITENAME}} 오늘의 명언 피드',
	'ffeed-qotd-short-title' => '오늘의 명언',
	'ffeed-qotd-desc' => '{{SITENAME}}에서 가장 좋은 명언 인용',
	'ffeed-qotd-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}}일 {{SITENAME}} 오늘의 명언',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ffeed-no-feed' => 'Feed net spezifizéiert',
	'ffeed-feed-not-found' => 'De Feed $1 gouf net fonnt',
	'ffeed-featured-title' => 'Feed vun de recommandéierten Artikelen op {{SITENAME}}',
	'ffeed-featured-short-title' => 'Recommandéiert Artikelen',
	'ffeed-featured-desc' => 'Déi bescht Artikelen déi {{SITENAME}} ze bidden huet',
	'ffeed-featured-entry' => 'Den  {{LOCALDAY}} {{LOCALMONTHNAME}} op {{SITENAME}} ausgezeechenten Artikel',
	'ffeed-good-short-title' => 'Gutt Artikelen',
	'ffeed-good-desc' => 'Gutt Artikelen déi {{SITENAME}} ze bidden huet',
	'ffeed-onthisday-short-title' => 'Um Dag vun haut...',
	'ffeed-onthisday-desc' => 'Historesch Evenementer op dësem Dag',
	'ffeed-onthisday-entry' => 'Op dësem Dag: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-dyk-title' => '{{SITENAME}} "Vosst Dir schonn" Feed',
	'ffeed-dyk-short-title' => 'Wosst Dir?',
	'ffeed-dyk-desc' => 'De rezensten Inhalt op {{SITENAME}}',
	'ffeed-dyk-entry' => 'Wosst Dir schonn?:  {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-motd-title' => '{{SITENAME}} Feed mam Medie-Fichier vum Dag',
	'ffeed-motd-short-title' => 'Medie-Fichier vum Dag',
	'ffeed-motd-desc' => 'E puer vun de beschte Medie-Fichieren op {{SITENAME}}',
	'ffeed-potd-short-title' => 'Bild vum Dag',
	'ffeed-potd-desc' => 'E puer vun de beschte Biller op {{SITENAME}}',
	'ffeed-qotd-title' => 'Feed vum Zitat vum Dag op {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Zitat vum Dag',
	'ffeed-featuredtexts-desc' => 'Déi bescht Texter déi {{SITENAME}} ze bidden huet',
	'ffeed-featuredtexts-entry' => 'Den  {{LOCALDAY}} {{LOCALMONTHNAME}} op {{SITENAME}} ausgezeechenten Text',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'ffeed-desc' => 'Додава канали за избрани содржини на викито.',
	'ffeed-no-feed' => 'Каналот не е укажан',
	'ffeed-feed-not-found' => 'Каналот $1 не е пронајден',
	'ffeed-entry-not-found' => 'Каналскиот запис за $1 не е пронајден',
	'ffeed-sidebar-section' => 'Канали за избрани содржини',
	'ffeed-invalid-timestamp' => 'Неважечки датум и време за емитувањето',
	'ffeed-featured-title' => 'Канал на избрани статии на {{SITENAME}}',
	'ffeed-featured-short-title' => 'Избрани статии',
	'ffeed-featured-desc' => 'Најдобрите статии на {{SITENAME}}',
	'ffeed-featured-entry' => 'Избрана статија на {{SITENAME}} за {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Канал на добри статии на {{SITENAME}}',
	'ffeed-good-short-title' => 'Добри статии',
	'ffeed-good-desc' => 'Добрите статии на {{SITENAME}}',
	'ffeed-good-entry' => 'Добра статија на {{SITENAME}} за {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Канал „На денешен ден...“ на {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'На денешен ден...',
	'ffeed-onthisday-desc' => 'Историски настани што се случиле на денешен ден',
	'ffeed-onthisday-entry' => 'На денешен ден: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Канал „Дали сте знаеле?“ на {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Дали сте знаеле?',
	'ffeed-dyk-desc' => 'Од најновите содржини на {{SITENAME}}',
	'ffeed-dyk-entry' => 'Дали сте знаеле?: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Канал за снимка на денот на {{SITENAME}}',
	'ffeed-motd-short-title' => 'Снимка на денот',
	'ffeed-motd-desc' => 'Најубавите снимки на {{SITENAME}}',
	'ffeed-motd-entry' => 'Снимка на денот за {{LOCALDAY}} {{LOCALMONTHNAME}} на {{SITENAME}}',
	'ffeed-potd-title' => 'Канал за слика на денот на {{SITENAME}}',
	'ffeed-potd-short-title' => 'Слика на денот',
	'ffeed-potd-desc' => 'Најдобрите слики на {{SITENAME}}',
	'ffeed-potd-entry' => 'Слика на денот за {{LOCALDAY}} {{LOCALMONTHNAME}} на {{SITENAME}}',
	'ffeed-qotd-title' => 'Канал за мисла на денот на {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Мисла на денот',
	'ffeed-qotd-desc' => 'Наијнтересните мисли на {{SITENAME}}',
	'ffeed-qotd-entry' => 'Мисла на денот за {{LOCALDAY}} {{LOCALMONTHNAME}} на {{SITENAME}}',
	'ffeed-featuredtexts-title' => 'Канал на избрани текстови на {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Избрани текстови',
	'ffeed-featuredtexts-desc' => 'Најдобрите текстови на {{SITENAME}}',
	'ffeed-featuredtexts-entry' => 'Избран текст на {{SITENAME}} за {{LOCALDAY}} {{LOCALMONTHNAME}}',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'ffeed-no-feed' => 'ഫീഡ് വ്യക്തമാക്കിയിട്ടില്ല',
	'ffeed-feed-not-found' => '$1 എന്ന ഫീഡ് കണ്ടെത്താനായില്ല',
	'ffeed-entry-not-found' => '$1-നുള്ള ഫീഡ് ഇനം കണ്ടെത്താനായില്ല',
	'ffeed-sidebar-section' => 'തിരഞ്ഞെടുക്കപ്പെട്ട ഉള്ളടക്കങ്ങളുടെ ഫീഡ്',
	'ffeed-invalid-timestamp' => 'അസാധുവായ ഫീഡ് സമയമുദ്ര',
	'ffeed-featured-title' => '{{SITENAME}} സംരംഭത്തിലെ തിരഞ്ഞെടുക്കപ്പെട്ട ലേഖനങ്ങളുടെ ഫീഡ്',
	'ffeed-featured-short-title' => 'തിരഞ്ഞെടുക്കപ്പെട്ട ലേഖനങ്ങൾ',
	'ffeed-featured-desc' => '{{SITENAME}} നൽകുന്ന മികച്ച ലേഖനങ്ങൾ',
	'ffeed-featured-entry' => '{{SITENAME}} സംരംഭത്തിൽ {{LOCALMONTHNAME}} {{LOCALDAY}} -ലെ തിരഞ്ഞെടുക്കപ്പെട്ട ലേഖനം',
	'ffeed-good-title' => '{{SITENAME}} സംരംഭത്തിലെ നല്ല ലേഖനങ്ങളുടെ ഫീഡ്',
	'ffeed-good-short-title' => 'നല്ല ലേഖനങ്ങൾ',
	'ffeed-onthisday-short-title' => 'ഇന്നേ ദിവസം...',
	'ffeed-onthisday-desc' => 'ഈ ദിവസത്തിലുണ്ടായിട്ടുള്ള ചരിത്ര സംഭവങ്ങൾ',
	'ffeed-onthisday-entry' => 'ഇന്നേ ദിവസം: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-dyk-title' => '{{SITENAME}} "താങ്കൾക്കറിയാമോ?" ഫീഡ്',
	'ffeed-dyk-short-title' => 'താങ്കൾക്കറിയാമോ?',
	'ffeed-motd-short-title' => 'ഇന്നത്തെ മീഡിയ',
	'ffeed-potd-short-title' => 'ഇന്നത്തെ ചിത്രം',
);

/** Marathi (मराठी)
 * @author Mahitgar
 * @author Rahuldeshmukh101
 */
$messages['mr'] = array(
	'ffeed-desc' => 'विकिच्या विशेष मजकुरांची सिंडीकेशन रसद जोडते (सिंडिकेशन शब्द कुठे दिसतो ते अभ्यासून ट्रांसलेटविकिवर जाऊन शब्दाचा सुयोग्य अनुवाद करण्यात सहाय्य करा)',
	'ffeed-no-feed' => 'विशीष्ट रसद नमुद नाही केली',
	'ffeed-feed-not-found' => ' $1 रसद मिळाली नाही',
	'ffeed-entry-not-found' => '$1 करिता रसद नोंद आढळली नाही',
	'ffeed-sidebar-section' => 'विशेष मजकुरांची रसद',
	'ffeed-invalid-timestamp' => 'अग्राह्य रसद नोंदणीची वेळ:',
	'ffeed-featured-title' => '{{SITENAME}}  विशेष लेखांची रसद',
	'ffeed-featured-short-title' => 'विशेष लेख',
	'ffeed-featured-desc' => '{{SITENAME}} वर उपलब्ध असलेले सर्वोत्कृउष्ट लेख',
	'ffeed-featured-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} विशेष लेख',
	'ffeed-good-title' => '{{SITENAME}} चांगल्या लेखांची रसद',
	'ffeed-good-short-title' => 'उत्तम  लेख',
	'ffeed-good-desc' => '{{SITENAME}}  वर उपलब्ध चांगले लेख',
	'ffeed-good-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} चांगले लेख',
	'ffeed-onthisday-title' => '{{SITENAME}} "दिनविशेष..." रसद',
	'ffeed-onthisday-short-title' => 'ह्या  दिवशी ...',
	'ffeed-onthisday-desc' => 'ह्या दिवशीच्या ऐतिहासिक घटना',
	'ffeed-onthisday-entry' => 'ह्या दिवशी : {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-dyk-title' => '{{SITENAME}} "आणि हे आपणास माहीत आहे का?" रसद',
	'ffeed-dyk-short-title' => 'आपणास माहित आहे का ?',
	'ffeed-dyk-desc' => " {{SITENAME}}'च्या अतीअलिकडील मजकुरातून",
	'ffeed-dyk-entry' => 'आपणास माहित आहे का ?: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-motd-title' => '{{SITENAME}} आजची बहुमाध्यमी क्लिपची रसद',
	'ffeed-motd-short-title' => 'आजचे    चलचित्र',
	'ffeed-motd-desc' => '{{SITENAME}}वरील काही  अत्युत्त्म  बहुमाध्यमी क्लिप',
	'ffeed-motd-entry' => '{{SITENAME}} आजची बहुमाध्यमी क्लिप  {{LOCALMONTHNAME}} {{LOCALDAY}} करिता',
	'ffeed-potd-title' => '{{SITENAME}} आजचे छायाचित्र रसद',
	'ffeed-potd-short-title' => 'आजचे चित्र',
	'ffeed-potd-desc' => 'काही  उत्तम चित्रे  {{SITENAME}} येथे आहेत',
	'ffeed-potd-entry' => '{{SITENAME}} आजचे छायाचित्र  {{LOCALMONTHNAME}} {{LOCALDAY}} करिता',
	'ffeed-qotd-title' => '{{SITENAME}} आजचे अवतरणची रसद',
	'ffeed-qotd-short-title' => 'आजचा सुविचार',
	'ffeed-qotd-desc' => 'काही  उत्तम विचार सुमने {{SITENAME}} येथे आहेत',
	'ffeed-qotd-entry' => '{{SITENAME}} आजचे अवतरण  {{LOCALMONTHNAME}} {{LOCALDAY}} करिता',
	'ffeed-featuredtexts-title' => '{{SITENAME}} विशेष मजकुराची रसद',
	'ffeed-featuredtexts-short-title' => 'विशेष मजकुर',
	'ffeed-featuredtexts-desc' => '{{SITENAME}}कडे असलेला सर्वोत्कृष्ट मजकुर',
	'ffeed-featuredtexts-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} विशेष  मजकुर',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'ffeed-desc' => 'Menambahkan suapan sindiket kandungan pilihan wiki',
	'ffeed-no-feed' => 'Suapan tidak dinyatakan',
	'ffeed-feed-not-found' => 'Suapan $1 tidak dijumpai',
	'ffeed-entry-not-found' => 'Entri suapan pada $1 tidak dijumpai',
	'ffeed-sidebar-section' => 'Suapan kandungan pilihan',
	'ffeed-invalid-timestamp' => 'Cop masa suapan tidak sah',
	'ffeed-featured-title' => 'Suapan rencana pilihan {{SITENAME}}',
	'ffeed-featured-short-title' => 'Rencana pilihan',
	'ffeed-featured-desc' => 'Rencana-rencana terbaik yang ditawarkan oleh {{SITENAME}}',
	'ffeed-featured-entry' => 'Rencana pilihan {{SITENAME}} {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Suapan rencana berkualiti {{SITENAME}}',
	'ffeed-good-short-title' => 'Rencana berkualiti',
	'ffeed-good-desc' => 'Rencana-rencana berkualti yang ditawarkan oleh {{SITENAME}}',
	'ffeed-good-entry' => 'Rencana berkualiti {{SITENAME}} {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Suapan "Hari ini dalam sejarah" {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'Hari ini dalam sejarah',
	'ffeed-onthisday-desc' => 'Peristiwa-peristiwa bersejarah pada hari ini',
	'ffeed-onthisday-entry' => 'Pada hari ini: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Suapan "Tahukah anda..." {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Tahukah anda...',
	'ffeed-dyk-desc' => 'Dari kandungan terbaru {{SITENAME}}',
	'ffeed-dyk-entry' => 'Tahukah anda...: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Suapan media pilihan {{SITENAME}}',
	'ffeed-motd-short-title' => 'Media pilihan',
	'ffeed-motd-desc' => 'Bahan-bahan media yang terbaik di {{SITENAME}}',
	'ffeed-motd-entry' => 'Bahan media pilihan {{SITENAME}} pada {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'Suapan gambar pilihan {{SITENAME}}',
	'ffeed-potd-short-title' => 'Gambar pilihan',
	'ffeed-potd-desc' => 'Gambar-gambar yang terbaik di {{SITENAME}}',
	'ffeed-potd-entry' => 'Gambar pilihan {{SITENAME}} pada {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Suapan petikan pilihan {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Petikan pilihan',
	'ffeed-qotd-desc' => 'Petikan-petikan yang paling menarik di {{SITENAME}}',
	'ffeed-qotd-entry' => 'Petikan pilihan {{SITENAME}} pada {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-featuredtexts-title' => 'suapan teks pilihan {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Teks pilihan',
	'ffeed-featuredtexts-desc' => 'Teks-teks terbaik yang ditawarkan oleh {{SITENAME}}',
	'ffeed-featuredtexts-entry' => 'Teks pilihan {{SITENAME}} {{LOCALDAY}} {{LOCALMONTHNAME}}',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'ffeed-desc' => 'Voegt feeds toe voor de uitgelichte inhoud van een wiki',
	'ffeed-no-feed' => 'Er is geen feed opgegeven',
	'ffeed-feed-not-found' => 'De feed $1 bestaat niet',
	'ffeed-entry-not-found' => 'De feedvermelding $1 is niet gevonden',
	'ffeed-sidebar-section' => 'Feeds met uitgelichte inhoud',
	'ffeed-invalid-timestamp' => 'Ongeldige tijdstempel voor feed',
	'ffeed-featured-title' => 'Feed voor uitgelichte artikelen van {{SITENAME}}',
	'ffeed-featured-short-title' => 'Uitgelichte artikelen',
	'ffeed-featured-desc' => 'De beste artikelen van {{SITENAME}}',
	'ffeed-featured-entry' => 'Uitgelicht artikel van {{SITENAME}} op {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-good-title' => "Feed met goede pagina's voor {{SITENAME}}",
	'ffeed-good-short-title' => "Goede pagina's",
	'ffeed-good-desc' => "Goede pagina's die {{SITENAME}} te bieden heeft",
	'ffeed-good-entry' => 'Goede pagina van {{LOCALDAY}} {{LOCALMONTHNAME}} van {{SITENAME}}',
	'ffeed-onthisday-title' => 'Feed voor "Op deze dag..." van {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'Op deze dag...',
	'ffeed-onthisday-desc' => 'Historische gebeurtenissen op deze dag',
	'ffeed-onthisday-entry' => 'Op deze dag: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Feed voor "Wist u dat" van {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Wist u dat?',
	'ffeed-dyk-desc' => 'De nieuwste inhoud van {{SITENAME}}',
	'ffeed-dyk-entry' => 'Wist u dat?: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Feed voor media van de dag van {{SITENAME}}',
	'ffeed-motd-short-title' => 'Media van de dag',
	'ffeed-motd-desc' => 'De beste media van {{SITENAME}}',
	'ffeed-motd-entry' => 'Media van de dag voor van {{LOCALDAY}} {{LOCALMONTHNAME}} van {{SITENAME}}',
	'ffeed-potd-title' => 'Feed voor afbeelding van de dag van {{SITENAME}}',
	'ffeed-potd-short-title' => 'Foto van de dag',
	'ffeed-potd-desc' => 'De beste afbeeldingen van {{SITENAME}}',
	'ffeed-potd-entry' => 'Afbeelding van de dag voor van {{LOCALDAY}} {{LOCALMONTHNAME}} van {{SITENAME}}',
	'ffeed-qotd-title' => 'Feed voor uitspraak van de dag van {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Citaat van de dag',
	'ffeed-qotd-desc' => 'De beste uitspraken van {{SITENAME}}',
	'ffeed-qotd-entry' => 'Uitspraak van de dag voor van {{LOCALDAY}} {{LOCALMONTHNAME}} van {{SITENAME}}',
	'ffeed-featuredtexts-desc' => 'De beste teksten die {{SITENAME}} te bieden heeft',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'ffeed-desc' => 'وکی دے فیچرڈ لکھتاں چ سنڈیکیشن رلاؤ',
	'ffeed-no-feed' => 'فیڈ نئیں دسی گئی۔',
	'ffeed-feed-not-found' => 'فیڈ 1$ نئیں لبی',
	'ffeed-entry-not-found' => 'تریخ 1$ لئی نئیں لبی۔',
	'ffeed-sidebar-section' => 'فیچرڈ کونٹنٹ فیڈز',
	'ffeed-invalid-timestamp' => 'ناں منی جان والی فیڈ ٹائیمسٹیمپ',
	'ffeed-featured-title' => '{{SITENAME}} فیچرڈ آرٹیکل فیڈ',
	'ffeed-featured-short-title' => 'ودیا آرٹیکل',
	'ffeed-featured-desc' => 'ودیا آرٹیکل {{SITENAME}} دین پین کے۔',
	'ffeed-featured-entry' => '{{معینہناں}} {{دن}} {{SITENAME}} فیچرڈ آرٹیکل',
	'ffeed-good-title' => '{{SITENAME}} چنگے ارٹیکل بارے',
	'ffeed-good-short-title' => 'چنکے ارٹیکل',
	'ffeed-good-desc' => 'چنکے ارٹیکل {{SITENAME}} دسنے پیسن۔',
	'ffeed-good-entry' => '{{معینہناں}} {{دن}} {{SITENAME}} چنکے آرٹیکل',
	'ffeed-onthisday-title' => '{{SITENAME}} "اس دن نوں..." فیڈ',
	'ffeed-onthisday-short-title' => 'اس دن نوں۔۔۔۔۔',
	'ffeed-onthisday-desc' => 'ایس دن دیاں تریخی گلاں',
	'ffeed-onthisday-entry' => 'اس دن نوں: {{معینہ}} {{دن}}',
	'ffeed-dyk-title' => '{{SITENAME}} "کیا تسین جاندے سی?" دسو',
	'ffeed-dyk-short-title' => 'کیاتسی جاندے سی ؟',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'ffeed-good-short-title' => 'நல்ல கட்டுரைகள்',
	'ffeed-good-entry' => '{{LOCALMONTHNAME}} {{LOCALDAY}} {{SITENAME}} நல்ல கட்டுரை',
	'ffeed-onthisday-short-title' => 'இந்த நாளில்...',
	'ffeed-onthisday-desc' => 'இந்த நாளில் வரலாற்று நிகழ்வுகள்',
	'ffeed-onthisday-entry' => 'இந்த நாளில்: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-dyk-short-title' => 'உங்களுக்கு தெரியுமா?',
	'ffeed-dyk-desc' => '{{SITENAME}} லிருந்து புதிய உள்ளடக்கம்',
	'ffeed-dyk-entry' => 'உங்களுக்கு தெரியுமா?: {{LOCALMONTHNAME}} {{LOCALDAY}}',
	'ffeed-potd-short-title' => 'இன்றைய சிறப்புப்படம்',
	'ffeed-potd-desc' => 'சில சிறந்த படங்கள்  {{SITENAME}}ல்',
	'ffeed-potd-entry' => '{{SITENAME}}இன்றைய சிறப்புப்படம்  {{LOCALMONTHNAME}} {{LOCALDAY}}க்கு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'ffeed-featured-short-title' => 'విశేష వ్యాసాలు',
	'ffeed-onthisday-short-title' => 'ఈ రోజున&hellip;',
	'ffeed-onthisday-desc' => 'ఈ రోజు జరిగిన చారిత్రక ఘటనలు',
	'ffeed-dyk-short-title' => 'మీకు తెలుసా?',
	'ffeed-potd-short-title' => 'నేటి చిత్రం',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'ffeed-desc' => 'Thêm các nguồn tin có nội dung chọn lọc của wiki',
	'ffeed-no-feed' => 'Không định rõ nguồn tin',
	'ffeed-feed-not-found' => 'Không tìm thấy nguồn tin $1',
	'ffeed-entry-not-found' => 'Không tìm thấy mục $1 trong nguồn tin',
	'ffeed-sidebar-section' => 'Nguồn tin có nội dung chọn lọc',
	'ffeed-invalid-timestamp' => 'Dấu thời gian nguồn tin không hợp lệ',
	'ffeed-featured-title' => 'Nguồn tin bài viết chọn lọc {{SITENAME}}',
	'ffeed-featured-short-title' => 'Bài viết chọn lọc',
	'ffeed-featured-desc' => 'Các bài viết nổi bật nhất của {{SITENAME}}',
	'ffeed-featured-entry' => 'Bài viết chọn lọc tại {{SITENAME}} ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-good-title' => 'Nguồn tin bài chất lượng tốt {{SITENAME}}',
	'ffeed-good-short-title' => 'Bài chất lượng tốt',
	'ffeed-good-desc' => 'Các bài có chất lượng tốt tại {{SITENAME}}',
	'ffeed-good-entry' => 'Bài chất lượng tốt tại {{SITENAME}} ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-onthisday-title' => 'Nguồn tin “Ngày này năm xưa” tại {{SITENAME}}',
	'ffeed-onthisday-short-title' => 'Ngày này năm xưa',
	'ffeed-onthisday-desc' => 'Các sự kiện xảy ra ngày này năm xưa',
	'ffeed-onthisday-entry' => 'Vào ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-dyk-title' => 'Nguồn tin “Bạn có biết” tại {{SITENAME}}',
	'ffeed-dyk-short-title' => 'Bạn có biết',
	'ffeed-dyk-desc' => 'Được lấy từ những nội dung mới của {{SITENAME}}',
	'ffeed-dyk-entry' => 'Bạn có biết: {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-motd-title' => 'Nguồn tin tư liệu trong ngày tại {{SITENAME}}',
	'ffeed-motd-short-title' => 'Tư liệu trong ngày',
	'ffeed-motd-desc' => 'Những tư liệu xuất sắc nhất tại {{SITENAME}}',
	'ffeed-motd-entry' => 'Tư liệu trong ngày tại {{SITENAME}} ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-potd-title' => 'Nguồn tin hình ảnh trong ngày tại {{SITENAME}}',
	'ffeed-potd-short-title' => 'Hình ảnh trong ngày',
	'ffeed-potd-desc' => 'Những hình ảnh xuất sắc nhất tại {{SITENAME}}',
	'ffeed-potd-entry' => 'Hình ảnh trong ngày tại {{SITENAME}} ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-qotd-title' => 'Nguồn tin danh ngôn trong ngày tại {{SITENAME}}',
	'ffeed-qotd-short-title' => 'Danh ngôn trong ngày',
	'ffeed-qotd-desc' => 'Những danh ngôn hay nhất tại {{SITENAME}}',
	'ffeed-qotd-entry' => 'Danh ngôn trong ngày tại {{SITENAME}} ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
	'ffeed-featuredtexts-title' => 'Nguồn tin văn kiện chọn lọc {{SITENAME}}',
	'ffeed-featuredtexts-short-title' => 'Văn kiện chọn lọc',
	'ffeed-featuredtexts-desc' => 'Các văn kiện nổi bật nhất củA {{SITENAME}}',
	'ffeed-featuredtexts-entry' => 'Văn kiện chọn lọc tại {{SITENAME}} ngày {{LOCALDAY}} {{LOCALMONTHNAME}}',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'ffeed-desc' => '为wiki的特色内容提供联合供稿',
	'ffeed-no-feed' => '没有指定供稿',
	'ffeed-feed-not-found' => '没有找到供稿$1',
	'ffeed-entry-not-found' => '找不到$1的供稿项目',
	'ffeed-sidebar-section' => '特色内容供稿',
	'ffeed-invalid-timestamp' => '无效时间戳',
	'ffeed-featured-title' => '{{SITENAME}}特色条目供稿',
	'ffeed-featured-short-title' => '特色条目',
	'ffeed-featured-desc' => '{{SITENAME}}上最佳的条目',
	'ffeed-featured-entry' => '{{SITENAME}}{{LOCALMONTHNAME}}{{LOCALDAY}}日特色条目',
	'ffeed-good-title' => '{{SITENAME}}优良条目供稿',
	'ffeed-good-short-title' => '优良条目',
	'ffeed-good-desc' => '{{SITENAME}}上较好的条目',
	'ffeed-good-entry' => '{{SITENAME}}{{LOCALMONTHNAME}}{{LOCALDAY}}日特色条目',
	'ffeed-onthisday-title' => '{{SITENAME}}“历史上的今天”供稿',
	'ffeed-onthisday-short-title' => '历史上的今天',
	'ffeed-onthisday-desc' => '这一天的历史事件',
	'ffeed-onthisday-entry' => '历史上的今天：{{LOCALMONTHNAME}}{{LOCALDAY}}日',
	'ffeed-dyk-title' => '{{SITENAME}}“你知道吗？”供稿',
	'ffeed-dyk-short-title' => '你知道吗？',
	'ffeed-dyk-desc' => '来自{{SITENAME}}的最新内容',
	'ffeed-dyk-entry' => '你知道吗？：{{LOCALMONTHNAME}}{{LOCALDAY}}日',
	'ffeed-motd-title' => '{{SITENAME}}每日媒体供稿',
	'ffeed-motd-short-title' => '每日媒体',
	'ffeed-motd-desc' => '{{SITENAME}}上最佳的一些媒体',
	'ffeed-motd-entry' => '{{SITENAME}}{{LOCALMONTHNAME}}{{LOCALDAY}}日的每日媒体',
	'ffeed-potd-title' => '{{SITENAME}}每日图片供稿',
	'ffeed-potd-short-title' => '每日图片',
	'ffeed-potd-desc' => '{{SITENAME}}上最佳的一些图片',
	'ffeed-potd-entry' => '{{SITENAME}}{{LOCALMONTHNAME}}{{LOCALDAY}}日的每日图片',
	'ffeed-qotd-title' => '{{SITENAME}}每日名言供稿',
	'ffeed-qotd-short-title' => '每日名言',
	'ffeed-qotd-desc' => '{{SITENAME}}上最佳的一些名言',
	'ffeed-qotd-entry' => '{{SITENAME}}{{LOCALMONTHNAME}}{{LOCALDAY}}日的每日名言',
);

