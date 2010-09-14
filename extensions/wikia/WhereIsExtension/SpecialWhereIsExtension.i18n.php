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
	'whereisextension-search-like-value' => 'Like:',
	'whereisextension-search-type' => 'Type:',
	'whereisextension-search-type-bool' => "Boolean",
	'whereisextension-search-type-full' => "Like",
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Siebrand
 */
$messages['qqq'] = array(
	'whereisextension-submit' => '{{Identical|Search}}',
	'whereisextension-filter' => 'Used as some kind of fieldset description.
{{Identical|Filter}}',
	'whereisextension-search-type' => '{{Identical|Type}}',
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

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'whereisextension-filter' => 'Filtrar',
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
	'whereisextension-search-like-value' => 'Падобна:',
	'whereisextension-search-type' => 'Тып:',
	'whereisextension-search-type-bool' => 'Лягічны',
	'whereisextension-search-type-full' => 'Падобна',
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
	'whereisextension-search-like-value' => 'Evel :',
	'whereisextension-search-type' => 'Seurt :',
	'whereisextension-search-type-full' => 'Evel',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'whereisextension' => "Extensió ''Where is''",
	'whereisextension-submit' => 'Cerca',
	'whereisextension-filter' => 'Filtre',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'whereisextension-submit' => 'گەڕان',
);

/** German (Deutsch)
 * @author LWChris
 * @author Laximilian scoken
 */
$messages['de'] = array(
	'whereisextension' => 'Wo ist die Erweiterung',
	'whereisextension-submit' => 'Suchen',
	'whereisextension-list' => 'Liste von Wikis mit zutreffenden Kriterien',
	'whereisextension-isset' => 'ist eingestellt auf',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alle Gruppen',
	'whereisextension-name-contains' => 'Variablenname enthält',
	'whereisextension-search-like-value' => 'Wie:',
	'whereisextension-search-type' => 'Typ:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Wie',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'whereisextension-submit' => 'Dii',
);

/** Spanish (Español)
 * @author Absay
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
	'whereisextension-search-like-value' => 'Semejante a:',
	'whereisextension-search-type' => 'Tipo:',
	'whereisextension-search-type-bool' => 'Expresión Booleana',
	'whereisextension-search-type-full' => 'Semejante a',
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
 * @author Peter17
 * @author Slamduck
 */
$messages['fr'] = array(
	'whereisextension' => "Où se trouve l'extension",
	'whereisextension-submit' => 'Rechercher',
	'whereisextension-list' => 'Liste des wikis qui correspondent aux critères',
	'whereisextension-isset' => 'est définie à',
	'whereisextension-filter' => 'Filtrer',
	'whereisextension-all-groups' => 'Tous les groupes',
	'whereisextension-name-contains' => 'le nom de la variable contient',
	'whereisextension-search-like-value' => 'Comme :',
	'whereisextension-search-type' => 'Type :',
	'whereisextension-search-type-bool' => 'Booléen',
	'whereisextension-search-type-full' => 'Comme',
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
	'whereisextension-search-like-value' => 'Semellante a:',
	'whereisextension-search-type' => 'Tipo:',
	'whereisextension-search-type-bool' => 'Booleano',
	'whereisextension-search-type-full' => 'Semellante a',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'whereisextension-submit' => 'Nema',
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
	'whereisextension-search-like-value' => 'Como:',
	'whereisextension-search-type' => 'Typo:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Como',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Irwangatot
 */
$messages['id'] = array(
	'whereisextension' => 'Dimana ekstensi',
	'whereisextension-submit' => 'Cari',
	'whereisextension-list' => 'Daftar wiki dengan kriteria yang cocok',
	'whereisextension-isset' => 'diatur ke',
	'whereisextension-filter' => 'Penyaring',
	'whereisextension-all-groups' => 'Semua kelompok',
	'whereisextension-name-contains' => 'nama variabel berisi',
	'whereisextension-search-like-value' => 'Seperti:',
	'whereisextension-search-type' => 'Tipe:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Seperti',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'whereisextension-submit' => 'Chöwá',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'whereisextension-submit' => 'Ricerca',
	'whereisextension-all-groups' => 'Tutti i gruppi',
);

/** Japanese (日本語)
 * @author Naohiro19
 * @author Yanajin66
 */
$messages['ja'] = array(
	'whereisextension' => '拡張子の場所',
	'whereisextension-submit' => '検索',
	'whereisextension-list' => 'ウィキに一致した基準の一覧',
	'whereisextension-filter' => 'フィルタ',
	'whereisextension-all-groups' => 'すべてのグループ',
	'whereisextension-search-like-value' => 'Like演算子:',
	'whereisextension-search-type' => 'タイプ:',
	'whereisextension-search-type-bool' => 'ブール値',
	'whereisextension-search-type-full' => 'Like演算子:',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'whereisextension-submit' => 'ಹುಡುಕು',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'whereisextension-submit' => 'Sichen',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'All Gruppen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'whereisextension' => 'Каде е додатокот',
	'whereisextension-submit' => 'Пребарај',
	'whereisextension-list' => 'Список на викија со совпаднати критериуми',
	'whereisextension-isset' => 'е наместено на',
	'whereisextension-filter' => 'Филтрирање',
	'whereisextension-all-groups' => 'Сите групи',
	'whereisextension-name-contains' => 'името на променливата содржи',
	'whereisextension-search-like-value' => 'Како:',
	'whereisextension-search-type' => 'Тип:',
	'whereisextension-search-type-bool' => 'Булов',
	'whereisextension-search-type-full' => 'Како',
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
	'whereisextension-search-like-value' => 'Zoals:',
	'whereisextension-search-type' => 'Type:',
	'whereisextension-search-type-bool' => 'Booleaanse operator',
	'whereisextension-search-type-full' => 'Zoals',
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
	'whereisextension-search-like-value' => 'Lik:',
	'whereisextension-search-type' => 'Type:',
	'whereisextension-search-type-bool' => 'Boolsk',
	'whereisextension-search-type-full' => 'Lik',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'whereisextension' => "Ont se tròba l'extension",
	'whereisextension-submit' => 'Recercar',
	'whereisextension-list' => 'Lista dels wikis que correspondon als critèris',
	'whereisextension-isset' => 'es definida a',
	'whereisextension-filter' => 'Filtrar',
	'whereisextension-all-groups' => 'Totes los gropes',
	'whereisextension-name-contains' => 'lo nom de la variabla conten',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'whereisextension-submit' => 'Uffgucke',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'whereisextension' => 'Rozszerzenie do wyszukiwania',
	'whereisextension-submit' => 'Szukaj',
	'whereisextension-list' => 'Lista wiki, które odpowiadają kryteriom',
	'whereisextension-isset' => 'jest ustawiona na',
	'whereisextension-filter' => 'Filtr',
	'whereisextension-all-groups' => 'Wszystkie grupy',
	'whereisextension-name-contains' => 'zawiera zmienną o takiej nazwie',
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
	'whereisextension-search-like-value' => 'Com:',
	'whereisextension-search-type' => 'Sòrt:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Com',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'whereisextension-submit' => 'پلټنه',
	'whereisextension-filter' => 'چاڼګر',
	'whereisextension-all-groups' => 'ټولې ډلې',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'whereisextension' => 'Onde está a extensão',
	'whereisextension-submit' => 'Pesquisar',
	'whereisextension-list' => 'Lista de wikis que correspondem aos critérios',
	'whereisextension-isset' => 'tem o valor',
	'whereisextension-filter' => 'Filtro',
	'whereisextension-all-groups' => 'Todos os grupos',
	'whereisextension-name-contains' => 'nome da variável contém',
	'whereisextension-search-like-value' => 'Semelhante a:',
	'whereisextension-search-type' => 'Tipo:',
	'whereisextension-search-type-bool' => 'Booleano',
	'whereisextension-search-type-full' => 'Semelhante a',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Daemorris
 * @author Giro720
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
	'whereisextension-search-like-value' => 'Semelhante a:',
	'whereisextension-search-type' => 'Tipo:',
	'whereisextension-search-type-bool' => 'Booleano',
	'whereisextension-search-type-full' => 'Semelhante a',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'whereisextension' => 'Где расширение',
	'whereisextension-submit' => 'Искать',
	'whereisextension-list' => 'Вывод списка вики-сайтов, согласно условиям',
	'whereisextension-isset' => 'установлен как',
	'whereisextension-filter' => 'Фильтр',
	'whereisextension-all-groups' => 'Все группы',
	'whereisextension-name-contains' => 'имя переменной содержит',
	'whereisextension-search-like-value' => 'Подобно:',
	'whereisextension-search-type' => 'Тип:',
	'whereisextension-search-type-bool' => 'Логический',
	'whereisextension-search-type-full' => 'Подобно',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'whereisextension' => 'Kje je razširitev',
	'whereisextension-submit' => 'Išči',
	'whereisextension-list' => 'Seznam wikijev, ki ustrezajo merilu',
	'whereisextension-isset' => 'je nastavljen na',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Vse skupine',
	'whereisextension-name-contains' => 'ime spremenljivke vsebuje',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Charmed94
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'whereisextension' => 'Где је екстензија',
	'whereisextension-submit' => 'Претрага',
	'whereisextension-list' => 'Листа викија са траженим критеријима',
	'whereisextension-isset' => 'је подешена на',
	'whereisextension-filter' => 'Филтар',
	'whereisextension-all-groups' => 'Све групе',
	'whereisextension-name-contains' => 'име променљиве садржи',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'whereisextension-submit' => 'వెతుకు',
	'whereisextension-all-groups' => 'అన్ని గుంపులు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'whereisextension' => 'Dugtong na nasaan',
	'whereisextension-submit' => 'Hanapin',
	'whereisextension-list' => 'Talaan ng mga wiking may magkakatugmang pamantayan',
	'whereisextension-isset' => 'ay nakatakda sa',
	'whereisextension-filter' => 'Pansala',
	'whereisextension-all-groups' => 'Lahat ng mga pangkat',
	'whereisextension-name-contains' => 'naglalaman ang pangalang nababago ng',
);

