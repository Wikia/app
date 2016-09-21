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

$messages = [];

$messages['en'] = [
	'whereisextension-desc' => 'Provides a list of wikis with enabled extensions',
	'whereisextension' => 'Where is extension',    //the name displayed on Special:SpecialPages
	'whereisextension-submit' => 'Search',
	'whereisextension-list' => 'List of wikis with matched criteria ($1)',
	'whereisextension-isset' => 'is set to',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'All groups',
	'whereisextension-name-contains' => 'variable name contains',
	'whereisextension-search-like-value' => 'Like:',
	'whereisextension-search-type' => 'Type:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Like',
	'whereisextension-edit' => 'edit',
	'whereisextension-select-all' => 'select all',
	'whereisextension-deselect-all' => 'deselect all',
	'right-WhereIsExtension' => 'Allows access to Special:WhereIsExtension',
];

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Siebrand
 */
$messages['qqq'] = [
	'whereisextension-desc' => '{{desc}}',
	'whereisextension-submit' => '{{Identical|Search}}',
	'whereisextension-filter' => 'Used as some kind of fieldset description.
{{Identical|Filter}}',
	'whereisextension-search-type' => '{{Identical|Type}}',
	'whereisextension-edit' => 'A link to edit a value of a variable.',
	'whereisextension-select-all' => 'A link to select all wikis on a list with a given variable.',
	'whereisextension-deselect-all' => 'A link to deselect all wikis on a list with a given variable.',
];

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = [
	'whereisextension' => 'Waar is die uitbreiding',
	'whereisextension-submit' => 'Soek',
	'whereisextension-list' => "Lys van wiki's wat aan die kriteria voldoen",
	'whereisextension-isset' => 'is gestel na',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alle groepe',
	'whereisextension-name-contains' => 'veranderlike-naam bevat',
];

/** Aragonese (aragonés)
 * @author Juanpabl
 */
$messages['an'] = [
	'whereisextension-filter' => 'Filtrar',
];

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = [
	'whereisextension-filter' => 'مُرشِّح',
];

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = [
	'whereisextension-submit' => 'Axtar',
];

/** Belarusian (Taraškievica orthography) (‪беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = [
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
];

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = [
	'whereisextension-submit' => 'Търсене',
	'whereisextension-all-groups' => 'Всички групи',
	'whereisextension-search-type' => 'Тип:',
];

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = [
	'whereisextension' => "Pelec'h emañ an astenn",
	'whereisextension-submit' => 'Klask',
	'whereisextension-list' => 'Roll ar wikioù a glot gant an dezverkoù',
	'whereisextension-isset' => 'zo termenet e',
	'whereisextension-filter' => 'Sil',
	'whereisextension-all-groups' => 'An holl strolladoù',
	'whereisextension-name-contains' => 'Anv an argemmenn zo ennañ',
	'whereisextension-search-like-value' => 'Evel :',
	'whereisextension-search-type' => 'Seurt :',
	'whereisextension-search-type-bool' => 'Boulean',
	'whereisextension-search-type-full' => 'Evel',
];

/** Catalan (català)
 * @author Gemmaa
 * @author Paucabot
 */
$messages['ca'] = [
	'whereisextension' => "Extensió ''Where is''",
	'whereisextension-submit' => 'Cerca',
	'whereisextension-list' => 'Llista dels wikis amb criteris coincident',
	'whereisextension-isset' => "s'estableix a",
	'whereisextension-filter' => 'Filtre',
	'whereisextension-all-groups' => 'Tots els grups',
	'whereisextension-name-contains' => 'nom de la variable conté',
	'whereisextension-search-like-value' => 'Com:',
	'whereisextension-search-type' => 'Tipus:',
	'whereisextension-search-type-bool' => 'Booleà',
	'whereisextension-search-type-full' => 'Com',
];

/** Sorani Kurdish (کوردی) */
$messages['ckb'] = [
	'whereisextension-submit' => 'گەڕان',
];

/** Czech (česky)
 * @author Dontlietome7
 */
$messages['cs'] = [
	'whereisextension' => 'Rozšíření Kde je',
	'whereisextension-submit' => 'Hledání',
	'whereisextension-list' => 'Seznam wiki s odpovídajícími kritérii',
	'whereisextension-isset' => 'je nastaveno na',
	'whereisextension-filter' => 'Filtr',
	'whereisextension-all-groups' => 'Všechny skupiny',
	'whereisextension-name-contains' => 'název proměnné obsahuje',
	'whereisextension-search-like-value' => 'Jako:',
	'whereisextension-search-type' => 'Typ:',
	'whereisextension-search-type-bool' => 'Logická hodnota',
	'whereisextension-search-type-full' => 'Jako',
];

/** German (Deutsch)
 * @author LWChris
 * @author Laximilian scoken
 */
$messages['de'] = [
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
];

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = [
	'whereisextension-submit' => 'Cı geyre',
	'whereisextension-isset' => 'Saz kerdiya',
	'whereisextension-filter' => 'Filtre',
	'whereisextension-all-groups' => 'Grubi pêro',
	'whereisextension-search-like-value' => 'Rındeni:',
	'whereisextension-search-type' => 'Babet:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Rındeni',
];

/** Ewe (eʋegbe) */
$messages['ee'] = [
	'whereisextension-submit' => 'Dii',
];

/** Spanish (español)
 * @author Absay
 * @author Crazymadlover
 * @author Pertile
 * @author Peter17
 */
$messages['es'] = [
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
];

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = [
	'whereisextension' => 'Non dagoen zehazteko luzapena',
	'whereisextension-submit' => 'Bilatu',
	'whereisextension-list' => 'Irizpideekin bat datozen wikien zerrenda',
	'whereisextension-isset' => 'ezarpen honekin dago:',
	'whereisextension-filter' => 'Irazi',
	'whereisextension-all-groups' => 'Talde guztiak',
	'whereisextension-name-contains' => 'aldagaiaren izenak hau dauka:',
	'whereisextension-search-like-value' => 'Honen antzekoa:',
	'whereisextension-search-type' => 'Mota:',
	'whereisextension-search-type-bool' => 'Boolearra',
	'whereisextension-search-type-full' => 'Honen antzekoa:',
];

/** Finnish (suomi)
 * @author Centerlink
 * @author Crt
 * @author Ilkea
 */
$messages['fi'] = [
	'whereisextension' => 'Missä on laajennus',
	'whereisextension-submit' => 'Haku',
	'whereisextension-list' => 'Luettelo wikisivuista täsmäävillä kriteereillä',
	'whereisextension-isset' => 'asetetaan',
	'whereisextension-filter' => 'Suodatin',
	'whereisextension-all-groups' => 'Kaikki ryhmät',
	'whereisextension-name-contains' => 'muuttujanimi sisältää',
	'whereisextension-search-like-value' => 'Kuten:',
	'whereisextension-search-type' => 'Tyyppi:',
	'whereisextension-search-type-bool' => 'Totuusarvo',
	'whereisextension-search-type-full' => 'Kuten',
];

/** French (français)
 * @author IAlex
 * @author Peter17
 * @author Slamduck
 */
$messages['fr'] = [
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
];

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = [
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
];

/** Hausa (هَوُسَ) */
$messages['ha'] = [
	'whereisextension-submit' => 'Nema',
];

/** Hungarian (magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = [
	'whereisextension' => '„Hol van” kiterjesztés',
	'whereisextension-submit' => 'Keresés',
	'whereisextension-list' => 'Wikik listája egyező kritériumokkal',
	'whereisextension-isset' => 'beállítása:',
	'whereisextension-filter' => 'Szűrő',
	'whereisextension-all-groups' => 'Összes csoport',
	'whereisextension-name-contains' => 'változónév tartalmazza:',
	'whereisextension-search-type' => 'Típus:',
	'whereisextension-search-type-bool' => 'Logikai érték',
];

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = [
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
];

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Irwangatot
 * @author Kenrick95
 */
$messages['id'] = [
	'whereisextension' => 'Di mana ekstensi',
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
];

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = [
	'whereisextension-submit' => 'Chọwa',
];

/** Italian (italiano) */
$messages['it'] = [
	'whereisextension-submit' => 'Ricerca',
	'whereisextension-all-groups' => 'Tutti i gruppi',
];

/** Japanese (日本語)
 * @author Naohiro19
 * @author Schu
 * @author Yanajin66
 */
$messages['ja'] = [
	'whereisextension' => '拡張子の場所',
	'whereisextension-submit' => '検索',
	'whereisextension-list' => 'ウィキに一致した基準の一覧',
	'whereisextension-isset' => '設定済',
	'whereisextension-filter' => 'フィルター',
	'whereisextension-all-groups' => 'すべてのグループ',
	'whereisextension-name-contains' => '変数名が含まれています',
	'whereisextension-search-like-value' => 'Like演算子:',
	'whereisextension-search-type' => 'タイプ:',
	'whereisextension-search-type-bool' => 'ブール値',
	'whereisextension-search-type-full' => 'Like演算子:',
];

/** Kalaallisut (kalaallisut)
 * @author Qaqqalik
 */
$messages['kl'] = [
	'whereisextension-submit' => 'Ujarlerit',
];

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = [
	'whereisextension-submit' => 'ಹುಡುಕು',
];

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = [
	'whereisextension-search-type' => 'Tüp:',
];

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = [
	'whereisextension-submit' => 'Lêbigere',
	'whereisextension-filter' => 'Fîltre',
	'whereisextension-search-type' => 'Cure:',
];

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = [
	'whereisextension-submit' => 'Sichen',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'All Gruppen',
];

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = [
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
];

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = [
	'whereisextension' => 'Sambungan di Mana',
	'whereisextension-submit' => 'Cari',
	'whereisextension-list' => 'Senarai wiki yang berpadan kriterianya',
	'whereisextension-isset' => 'ditetapkan kepada',
	'whereisextension-filter' => 'Penapis',
	'whereisextension-all-groups' => 'Semua kumpulan',
	'whereisextension-name-contains' => 'nama pembolehubah mengandungi',
	'whereisextension-search-like-value' => 'Seperti:',
	'whereisextension-search-type' => 'Jenis:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Seperti',
];

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = [
	'whereisextension-submit' => 'ရှာ​ဖွေ​ရန်​',
	'whereisextension-filter' => 'စိစစ်မှု',
	'whereisextension-search-type' => 'အမျိုးအစား :',
];

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = [
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
];

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = [
	'whereisextension-submit' => 'खोज्नुहोस्',
];

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = [
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
];

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = [
	'whereisextension' => "Ont se tròba l'extension",
	'whereisextension-submit' => 'Recercar',
	'whereisextension-list' => 'Lista dels wikis que correspondon als critèris',
	'whereisextension-isset' => 'es definida a',
	'whereisextension-filter' => 'Filtrar',
	'whereisextension-all-groups' => 'Totes los gropes',
	'whereisextension-name-contains' => 'lo nom de la variabla conten',
];

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = [
	'whereisextension-submit' => 'Uffgucke',
];

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sp5uhe
 */
$messages['pl'] = [
	'whereisextension' => 'Rozszerzenie do wyszukiwania',
	'whereisextension-submit' => 'Szukaj',
	'whereisextension-list' => 'Lista wiki, które odpowiadają kryteriom',
	'whereisextension-isset' => 'jest ustawiona na',
	'whereisextension-filter' => 'Filtr',
	'whereisextension-all-groups' => 'Wszystkie grupy',
	'whereisextension-name-contains' => 'zawiera zmienną o takiej nazwie',
	'whereisextension-search-like-value' => 'Podobnie do:',
	'whereisextension-search-type' => 'Typ:',
	'whereisextension-search-type-bool' => 'Wartość logiczna',
	'whereisextension-search-type-full' => 'Podobnie do',
];

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = [
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
];

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = [
	'whereisextension-submit' => 'پلټنه',
	'whereisextension-filter' => 'چاڼګر',
	'whereisextension-all-groups' => 'ټولې ډلې',
];

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = [
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
];

/** Brazilian Portuguese (português do Brasil)
 * @author Daemorris
 * @author Giro720
 * @author McDutchie
 */
$messages['pt-br'] = [
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
];

/** Russian (русский)
 * @author Eleferen
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = [
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
];

/** Sinhala (සිංහල) */
$messages['si'] = [
	'whereisextension-submit' => 'සොයන්න',
];

/** Slovenian (slovenščina)
 * @author Dbc334
 */
$messages['sl'] = [
	'whereisextension' => 'Kje je razširitev',
	'whereisextension-submit' => 'Išči',
	'whereisextension-list' => 'Seznam wikijev, ki ustrezajo merilu',
	'whereisextension-isset' => 'je nastavljen na',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Vse skupine',
	'whereisextension-name-contains' => 'ime spremenljivke vsebuje',
	'whereisextension-search-like-value' => 'Kot:',
	'whereisextension-search-type' => 'Vrsta:',
	'whereisextension-search-type-bool' => 'Logična vrednost',
	'whereisextension-search-type-full' => 'Kot',
];

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Charmed94
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = [
	'whereisextension' => 'Где је проширење',
	'whereisextension-submit' => 'Претражи',
	'whereisextension-list' => 'Списак викија са поклапањима',
	'whereisextension-isset' => 'је подешена на',
	'whereisextension-filter' => 'Филтер',
	'whereisextension-all-groups' => 'Све групе',
	'whereisextension-name-contains' => 'назив променљиве садржи',
	'whereisextension-search-like-value' => 'Како:',
	'whereisextension-search-type' => 'Врста:',
	'whereisextension-search-type-bool' => 'Булова',
	'whereisextension-search-type-full' => 'Како',
];

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = [
	'whereisextension' => 'Var är tillägg',
	'whereisextension-submit' => 'Sök',
	'whereisextension-list' => 'Lista över wikis med matchade kriterier',
	'whereisextension-isset' => 'är inställd på',
	'whereisextension-filter' => 'Filter',
	'whereisextension-all-groups' => 'Alla grupper',
	'whereisextension-name-contains' => 'variabelnamn innehåller',
	'whereisextension-search-like-value' => 'Gilla:',
	'whereisextension-search-type' => 'Typ:',
	'whereisextension-search-type-bool' => 'Boolesk',
	'whereisextension-search-type-full' => 'Gilla',
];

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = [
	'whereisextension-submit' => 'వెతుకు',
	'whereisextension-all-groups' => 'అన్ని గుంపులు',
];

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = [
	'whereisextension' => 'Dugtong na nasaan',
	'whereisextension-submit' => 'Hanapin',
	'whereisextension-list' => 'Talaan ng mga wiking may magkakatugmang pamantayan',
	'whereisextension-isset' => 'ay nakatakda sa',
	'whereisextension-filter' => 'Pansala',
	'whereisextension-all-groups' => 'Lahat ng mga pangkat',
	'whereisextension-name-contains' => 'naglalaman ang pangalang nababago ng',
	'whereisextension-search-like-value' => 'Wangis:',
	'whereisextension-search-type' => 'Uri:',
	'whereisextension-search-type-bool' => 'Booleano',
	'whereisextension-search-type-full' => 'Wangis',
];

/** Ukrainian (українська)
 * @author Тест
 */
$messages['uk'] = [
	'whereisextension-submit' => 'Шукати',
	'whereisextension-filter' => 'Фільтр',
	'whereisextension-all-groups' => 'Всі групи',
	'whereisextension-search-type' => 'Тип:',
];

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = [
	'whereisextension' => 'Đâu là phần mở rộng',
	'whereisextension-submit' => 'Tìm kiếm',
	'whereisextension-list' => 'Danh sách wiki phù hợp với tiêu chí',
	'whereisextension-isset' => 'được thiết lập để',
	'whereisextension-filter' => 'Bộ lọc',
	'whereisextension-all-groups' => 'Tất cả các nhóm',
	'whereisextension-name-contains' => 'tên biến có chứa',
	'whereisextension-search-like-value' => 'Giống như:',
	'whereisextension-search-type' => 'Kiểu:',
	'whereisextension-search-type-bool' => 'Boolean',
	'whereisextension-search-type-full' => 'Giống như',
];

/** Simplified Chinese (‪中文（简体）‬)
 * @author Hydra
 */
$messages['zh-hans'] = [
	'whereisextension-submit' => '搜寻',
	'whereisextension-search-type' => '类型：',
	'whereisextension-search-type-full' => '喜欢',
];

