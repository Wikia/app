<?php

/**
 * WhereIsExtension
 *
 * A WhereIsExtension extension for MediaWiki
 * Provides a list of wikis with enabled selected extension
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-07-02
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WhereIsExtension/SpecialWhereIsExtension.php");
 */

$messages = array();

$messages['en'] = array(
	'whereisextension'			=> 'Where is extension',	//the name displayed on Special:SpecialPages
	'whereisextension-submit'	=> 'Search',
	'whereisextension-list'		=> 'List of wikis with matched criteria',
	'whereisextension-isset'	=> 'is set to',
	'whereisextension-filter'	=> 'Filter',
	'whereisextension-all-groups'	=> 'All groups',
	'whereisextension-name-contains'	=> 'variable name contains',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Siebrand
 */
$messages['qqq'] = array(
	'whereisextension-submit' => '{{Identical|Search}}',
	'whereisextension-filter' => 'Used as some kind of fieldset description.
{{Identical|Filter}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'whereisextension' => 'Waar is die uitbreiding',
	'whereisextension-submit' => 'Soek',
	'whereisextension-list' => "Lys van wiki's wat aan die kriteria voldoen",
	'whereisextension-isset' => 'is gestel na',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alle groepe',
	'whereisextension-name-contains' => 'veranderlike-naam bevat',
);

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = array(
	'whereisextension-filter' => 'مُرشِّح',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'whereisextension' => 'Дзе пашырэньне',
	'whereisextension-submit' => 'Шукаць',
	'whereisextension-list' => 'Сьпіс вікі, якія адпавядаюць умовам',
	'whereisextension-isset' => 'усталяваны як',
	'whereisextension-filter' => 'Фільтар',
	'whereisextension-all-groups' => 'Усе групы',
	'whereisextension-name-contains' => 'назва зьменнай утрымлівае',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'whereisextension' => "Pelec'h emañ an astenn",
	'whereisextension-submit' => 'Klask',
	'whereisextension-list' => 'Roll ar wikioù a glot gant an dezverkoù',
	'whereisextension-isset' => 'zo termenet e',
	'whereisextension-filter' => 'Sil',
	'whereisextension-all-groups' => 'An holl strolladoù',
	'whereisextension-name-contains' => 'Anv an argemmenn zo ennañ',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'whereisextension' => "Extensió ''Where is''",
	'whereisextension-submit' => 'Cerca',
	'whereisextension-filter' => 'Filtre',
);

/** German (Deutsch)
 * @author LWChris
 */
$messages['de'] = array(
	'whereisextension' => 'Wo ist Erweiterung',
	'whereisextension-submit' => 'Suchen',
	'whereisextension-list' => 'Liste von Wikis mit zutreffenden Kriterien',
	'whereisextension-isset' => 'ist eingestellt auf',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alle Gruppen',
	'whereisextension-name-contains' => 'Variablenname enthält',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'whereisextension' => 'Wo ist Erweiterung',
	'whereisextension-submit' => 'Suchen',
	'whereisextension-list' => 'Liste von Wikis mit zutreffenden Kriterien',
	'whereisextension-isset' => 'ist eingestellt auf',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alle Gruppen',
	'whereisextension-name-contains' => 'Variablenname enthält',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Pertile
 * @author Peter17
 */
$messages['es'] = array(
	'whereisextension' => 'Dónde está la extensión',
	'whereisextension-submit' => 'Buscar',
	'whereisextension-list' => 'Lista de wikis con criterios coincidentes',
	'whereisextension-isset' => 'está fijado en',
	'whereisextension-filter' => 'Filtro',
	'whereisextension-all-groups' => 'Todos los grupos',
	'whereisextension-name-contains' => 'Nombre de variable contiene',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'whereisextension-submit' => 'Bilatu',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'whereisextension' => 'Missä on laajennus',
	'whereisextension-submit' => 'Haku',
	'whereisextension-list' => 'Luettelo wikisivuista täsmäävillä kriteereillä',
	'whereisextension-isset' => 'asetetaan',
	'whereisextension-filter' => 'Suodatin',
	'whereisextension-all-groups' => 'Kaikki ryhmät',
	'whereisextension-name-contains' => 'muuttujanimi sisältää',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'whereisextension' => "Où se trouve l'extension",
	'whereisextension-submit' => 'Rechercher',
	'whereisextension-list' => 'Liste des wikis qui correspondent au critères',
	'whereisextension-isset' => 'est définie à',
	'whereisextension-filter' => 'Filtrer',
	'whereisextension-all-groups' => 'Tous les groupes',
	'whereisextension-name-contains' => 'le nom de la variable contient',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'whereisextension' => 'Onde está a extensión',
	'whereisextension-submit' => 'Procurar',
	'whereisextension-list' => 'Lista dos wikis que coinciden cos criterios',
	'whereisextension-isset' => 'está definido a',
	'whereisextension-filter' => 'Filtrar',
	'whereisextension-all-groups' => 'Todos os grupos',
	'whereisextension-name-contains' => 'o nome da variable contén',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'whereisextension' => '„Hol van” kiterjesztés',
	'whereisextension-submit' => 'Keresés',
	'whereisextension-list' => 'Wikik listája egyező kritériumokkal',
	'whereisextension-isset' => 'beállítása:',
	'whereisextension-filter' => 'Szűrő',
	'whereisextension-all-groups' => 'Összes csoport',
	'whereisextension-name-contains' => 'változónév tartalmazza:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'whereisextension' => 'Ubi es le extension',
	'whereisextension-submit' => 'Cercar',
	'whereisextension-list' => 'Lista de wikis correspondente al criterios',
	'whereisextension-isset' => 'es configurate como',
	'whereisextension-filter' => 'Filtro',
	'whereisextension-all-groups' => 'Tote le gruppos',
	'whereisextension-name-contains' => 'nomine de variabile contine',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'whereisextension-submit' => 'Ricerca',
	'whereisextension-all-groups' => 'Tutti i gruppi',
);

/** Japanese (日本語)
 * @author Naohiro19
 */
$messages['ja'] = array(
	'whereisextension-submit' => '検索',
	'whereisextension-list' => 'ウィキに一致した基準の一覧',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'whereisextension' => 'Проширување Where is',
	'whereisextension-submit' => 'Пребарај',
	'whereisextension-list' => 'Листа на викија со совпаднати критериуми',
	'whereisextension-isset' => 'е наместено на',
	'whereisextension-filter' => 'Филтрирање',
	'whereisextension-all-groups' => 'Сите групи',
	'whereisextension-name-contains' => 'името на променливата содржи',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'whereisextension' => 'Waar is de uitbreiding',
	'whereisextension-submit' => 'Zoeken',
	'whereisextension-list' => "Lijst met wiki's die aan de voorwaarden voldoen",
	'whereisextension-isset' => 'is ingesteld op',
	'whereisextension-filter' => 'Filteren',
	'whereisextension-all-groups' => 'Alle groepen',
	'whereisextension-name-contains' => 'variabelenaam bevat',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'whereisextension' => 'Hvor er utvidelsen',
	'whereisextension-submit' => 'Søk',
	'whereisextension-list' => 'Liste over wikier med matchende kriterier',
	'whereisextension-isset' => 'er satt til',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alle grupper',
	'whereisextension-name-contains' => 'variabelnavn inneholder',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'whereisextension' => "Anté ch'a l'é l'estension",
	'whereisextension-submit' => 'Serca',
	'whereisextension-list' => 'Lista ëd wiki con criteri spetà',
	'whereisextension-isset' => "a l'é ampostà a",
	'whereisextension-filter' => 'Filtr',
	'whereisextension-all-groups' => 'Tute le partìe',
	'whereisextension-name-contains' => 'ël nòm ëd variàbil a conten',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'whereisextension-submit' => 'پلټنه',
	'whereisextension-filter' => 'چاڼګر',
	'whereisextension-all-groups' => 'ټولې ډلې',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Daemorris
 * @author McDutchie
 */
$messages['pt-br'] = array(
	'whereisextension' => 'Extensão onde está',
	'whereisextension-submit' => 'Pesquisar',
	'whereisextension-list' => 'Lista de wikis com critério correspondente',
	'whereisextension-isset' => 'está configurado como',
	'whereisextension-filter' => 'Filtro',
	'whereisextension-all-groups' => 'Todos os grupos',
	'whereisextension-name-contains' => 'nome de variável contêm',
);

/** Russian (Русский)
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'whereisextension' => 'Где расширение',
	'whereisextension-submit' => 'Искать',
	'whereisextension-list' => 'Вывод список вики-сайтов, согласно условиям',
	'whereisextension-isset' => 'установлен как',
	'whereisextension-filter' => 'Фильтр',
	'whereisextension-all-groups' => 'Все группы',
	'whereisextension-name-contains' => 'имя переменной содержит',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'whereisextension-submit' => 'Претрага',
	'whereisextension-list' => 'Листа викија са траженим критеријима',
	'whereisextension-filter' => 'Филтар',
	'whereisextension-all-groups' => 'Све групе',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'whereisextension-submit' => 'వెతుకు',
	'whereisextension-all-groups' => 'అన్ని గుంపులు',
);

