<?php

/**
 * Internationalization file for the Semantic Maps extension
 *
 * @file SemanticMaps.i18n.php
 * @ingroup Semantic Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 * @author Karsten Hoffmeyer (kghbln)
 */
$messages['en'] = array(
	// General
	'semanticmaps-desc' => "Provides the ability to view and edit coordinate data stored with the Semantic MediaWiki extension ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps more info...])",
	'semanticmaps-unrecognizeddistance' => 'The value $1 is not a valid distance.',
	'semanticmaps-kml-link' => 'View the KML file',
	'semanticmaps-kml' => 'KML',
	'semanticmaps-default-kml-pagelink' => 'View page $1',

	'semanticmaps-latitude' => 'Latitude: $1',
	'semanticmaps-longitude' => 'Longitude: $1',
	'semanticmaps-altitude' => 'Altitude: $1',

	// Forms
	'semanticmaps-loading-forminput'	=> 'Loading map form input...',
	'semanticmaps_lookupcoordinates' 	=> 'Look up coordinates',
	'semanticmaps_enteraddresshere' 	=> 'Enter address here',
	'semanticmaps-updatemap' 		=> 'Update map',
	'semanticmaps-forminput-remove'		=> 'Remove',
	'semanticmaps-forminput-add'		=> 'Add',
	'semanticmaps-forminput-locations'	=> 'Locations',
	
	// Parameter descriptions
	'semanticmaps-par-staticlocations'	=> 'A list of locations to add to the map together with the queried data. Like with display_points, you can add a title, description and icon per location using the tilde "~" as separator.',
	'semanticmaps-par-forceshow'		=> 'Show the map even when there are no locations to display?',
	'semanticmaps-par-showtitle'		=> 'Show a title in the marker info window or not. Disabling this is often usefull when using a template to format the info window content.',
	'semanticmaps-par-hidenamespace'	=> 'Show the namespace title in the marker info window',
	'semanticmaps-par-centre'		=> 'The centre of the map. When not provided, the map will automatically pick the optimal centre to display all markers on the map.',
	'semanticmaps-par-template'		=> 'A template to use to format the info window contents.',
	
	'semanticmaps-par-geocodecontrol'	=> 'Show the geocoding control.',

	'semanticmaps-kml-text' => 'The text associated with each page. Overriden by the additional queried properties if any.',
	'semanticmaps-kml-title' => 'The default title for results',
	'semanticmaps-kml-linkabsolute' => 'Should links be absolute (as opposed to relative)',
	'semanticmaps-kml-pagelinktext' => 'The text to use for the links to the page, in which $1 will be replaced by the page title',

	//Validation Errors
	'semanticmaps-shapes-improperformat' => 'Improper formatting of $1. Please see documentation for formatting',
	'semanticmaps-shapes-missingshape' => 'No shapes found for $1. Please see documentation for available shapes',

);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Lloffiwr
 * @author Purodha
 * @author Raymond
 * @author Shirayuki
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'semanticmaps-desc' => '{{desc|name=Semantic Maps|url=http://www.mediawiki.org/wiki/Extension:Semantic_Maps}}',
	'semanticmaps-kml' => '{{optional}}',
	'semanticmaps-default-kml-pagelink' => '$1 is probably a page title.',
	'semanticmaps-loading-forminput' => 'Message displayed during a computer action',
	'semanticmaps_lookupcoordinates' => 'Submit button next to input box. The box contains the hint {{msg-mw|Semanticmaps_enteraddresshere}}',
	'semanticmaps_enteraddresshere' => 'Hint provided in an input box. The submit button next to the input box is {{msg-mw|Semanticmaps_lookupcoordinates}}',
	'semanticmaps-updatemap' => 'Submit button label',
	'semanticmaps-forminput-remove' => '{{Identical|Remove}}',
	'semanticmaps-forminput-add' => '{{Identical|Add}}',
	'semanticmaps-forminput-locations' => '{{Identical|Location}}',
	'semanticmaps-shapes-improperformat' => 'Message displayed when the wikitext formatting of a shape is erroneous',
	'semanticmaps-shapes-missingshape' => 'Message displayed when there is no such defined shape as $1',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'semanticmaps-desc' => 'Bied die vermoë om koördinaatdata met behulp van die Semantiese MediaWiki-uitbreiding te sien en te wysig ([https://mapping.referata.com/wiki/Examples demo]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Die waarde "$1" is nie \'n geldige afstand nie.',
	'semanticmaps_lookupcoordinates' => 'Soek koördinate op',
	'semanticmaps_enteraddresshere' => 'Voer adres hier in',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'semanticmaps-desc' => 'يقدم إمكانية عرض وتعديل بيانات التنسيق التي خزنها امتداد سيمانتيك ميدياويكي ([https://mapping.referata.com/wiki/Examples تجربة]).', # Fuzzy
	'semanticmaps-kml' => 'كيه إم إل',
	'semanticmaps_lookupcoordinates' => 'ابحث عن الإحداثيات',
	'semanticmaps_enteraddresshere' => 'أدخل العنوان هنا',
	'semanticmaps-forminput-remove' => 'أزل',
	'semanticmaps-forminput-add' => 'أضف',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'semanticmaps_lookupcoordinates' => 'ابحث عن الإحداثيات',
	'semanticmaps_enteraddresshere' => 'أدخل العنوان هنا',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'semanticmaps-desc' => 'Ufre la capacidá de ver y editar los datos de coordenaes guardaos cola estensión Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps más información...]).',
	'semanticmaps-unrecognizeddistance' => 'El valor $1 nun ye una distancia válida.',
	'semanticmaps-kml-link' => 'Ver el ficheru KML',
	'semanticmaps-default-kml-pagelink' => 'Ver la páxina "$1"',
	'semanticmaps-latitude' => 'Llatitú: $1',
	'semanticmaps-longitude' => 'Llonxitú: $1',
	'semanticmaps-altitude' => 'Altitú: $1',
	'semanticmaps-loading-forminput' => "Cargando'l formulariu d'entrada del mapa...",
	'semanticmaps_lookupcoordinates' => 'Consultar les coordenaes',
	'semanticmaps_enteraddresshere' => 'Escribi la direición equí',
	'semanticmaps-updatemap' => 'Anovar el mapa',
	'semanticmaps-forminput-remove' => 'Desaniciar',
	'semanticmaps-forminput-add' => 'Amestar',
	'semanticmaps-forminput-locations' => 'Llugares',
	'semanticmaps-par-staticlocations' => 'Llista de llugares p\'amestar al mapa xunto colos datos consultaos. Como con display_points, pues amestar un títulu, una descripción y un iconu pa cada llugar usando\'l signu "~" como separador.',
	'semanticmaps-par-forceshow' => "¿Ver el mapa tamién cuando nun hai llugares qu'amosar?",
	'semanticmaps-par-showtitle' => "Amosar o non un títulu na ventana d'información del marcador. De vezu, desactivalo ye útil cuando s'utiliza una plantía pa dar formatu al conteníu de la ventana d'información.",
	'semanticmaps-par-hidenamespace' => "Amosar o non el títulu del espaciu de nomes na ventana d'información del marcador.",
	'semanticmaps-par-centre' => "El centru del mapa. Cuando nun se proporciona, el mapa escoyerá automáticamente'l meyor centru p'amosar tolos marcadores del mapa.",
	'semanticmaps-par-template' => "Una plantía que s'utiliza pa dar formatu al conteníu de la ventana d'información.",
	'semanticmaps-par-geocodecontrol' => 'Amosar el control de xeocodificación.',
	'semanticmaps-kml-text' => 'El testu asociáu con cada páxina. Sustituyíu poles otres propiedaes consultaes, si esisten.',
	'semanticmaps-kml-title' => 'El títulu predetermináu pa los resultaos',
	'semanticmaps-kml-linkabsolute' => 'Si los títulos tienen de ser absolutos o non (esto ye, relativos)',
	'semanticmaps-kml-pagelinktext' => 'El testu a usar pa los enllaces a la páxina, onde "$1" se sustituye pol títulu de la páxina',
	'semanticmaps-shapes-improperformat' => 'Formatu incorreutu de $1. Por favor, consulta la documentación sobre formatos',
	'semanticmaps-shapes-missingshape' => "Nun s'alcontraron formes pa $1. Por favor, consulta la documentación de les formes disponibles",
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'semanticmaps-forminput-add' => 'Əlavə et',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'semanticmaps-desc' => 'Забясьпечвае магчымасьць прагляду і рэдагаваньня зьвестак пра каардынаты, якія захоўваюцца з дапамогай пашырэньня Semantic MediaWiki ([https://mapping.referata.com/wiki/Examples дэманстрацыя]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Значэньне $1 — няслушная адлегласьць.',
	'semanticmaps-kml-link' => 'Паказаць KML-файл',
	'semanticmaps-default-kml-pagelink' => 'Паказаць старонку $1',
	'semanticmaps-loading-forminput' => 'Загрузка мапы…',
	'semanticmaps_lookupcoordinates' => 'Пошук каардынатаў',
	'semanticmaps_enteraddresshere' => 'Увядзіце тут адрас',
	'semanticmaps-updatemap' => 'Абнавіць мапу',
	'semanticmaps-forminput-remove' => 'Выдаліць',
	'semanticmaps-forminput-add' => 'Дадаць',
	'semanticmaps-forminput-locations' => 'Месцы',
	'semanticmaps-par-staticlocations' => 'Сьпіс месцазнаходжаньняў для даданьня на мапу разам з запытанымі зьвесткамі. Напрыклад, разам з «display_points», Вы можаце дадаць назву, апісаньне і мініятуру для месцазнаходжаньня з дапамогай сымбаля «~» у якасьці разьдзяляльніка.',
	'semanticmaps-par-forceshow' => 'Паказаць мапу, нават калі няма месцазнаходжаньняў для паказу?',
	'semanticmaps-par-showtitle' => 'Паказваць назву ў акне інфармацыі пра маркер ці не. Адключэньне гэтай функцыі часта карыснае падчас выкарыстаньня шаблёну для фарматаваньня зьместу акна інфармацыі.',
	'semanticmaps-par-centre' => 'Цэнтар мапы. Калі ён не пададзены, мапа будзе аўтаматычна выбіраць аптымальны цэнтар для паказу ўсіх маркераў.',
	'semanticmaps-par-template' => 'Шаблён для фарматаваньня зьместу акна інфармацыі.',
	'semanticmaps-par-geocodecontrol' => 'Паказаць элемэнты кіраваньня геаграфічным кадаваньнем.',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'semanticmaps-forminput-remove' => 'Премахване',
	'semanticmaps-forminput-add' => 'Добавяне',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'semanticmaps-kml-link' => 'কেএমএল ফাইল দেখাও',
	'semanticmaps-default-kml-pagelink' => '$1 পাতা প্রদর্শন করো',
	'semanticmaps_enteraddresshere' => 'এখানে ঠিকানা প্রবেশ করাও',
	'semanticmaps-updatemap' => 'মানচিত্র হালনাগাদ',
	'semanticmaps-forminput-remove' => 'অপসারণ',
	'semanticmaps-forminput-add' => 'যোগ',
	'semanticmaps-forminput-locations' => 'অবস্থান',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'semanticmaps-desc' => 'Talvezout a ra da welet ha da gemmañ roadennoù daveennoù stoket dre an astenn Semantic MediaWiki ([https://mapping.referata.com/wiki/Examples demo]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => "An talvoud $1 n'eo ket un hed reizh anezhañ.",
	'semanticmaps-kml-link' => 'Gwelet ar restr KML',
	'semanticmaps-default-kml-pagelink' => 'Gwelet ar pennad $1',
	'semanticmaps-latitude' => 'Ledred : $1',
	'semanticmaps-longitude' => 'Hedred : $1',
	'semanticmaps-altitude' => 'Uhelder : $1',
	'semanticmaps-loading-forminput' => 'O kargañ enmont furmskrid ar gartenn...',
	'semanticmaps_lookupcoordinates' => 'Istimañ an daveennoù',
	'semanticmaps_enteraddresshere' => "Merkit ar chomlec'h amañ",
	'semanticmaps-updatemap' => 'Hizivaat ar gartenn',
	'semanticmaps-forminput-remove' => 'Dilemel',
	'semanticmaps-forminput-add' => 'Ouzhpennañ',
	'semanticmaps-forminput-locations' => "Lec'hiadurioù",
	'semanticmaps-par-forceshow' => "Diskouez ar gartenn ha pa ne vefe lec'h ebet da welet ?",
	'semanticmaps-par-template' => "Ur patrom d'ober gantañ da furmadiñ boued ar prenestr titouriñ.",
);

/** Bosnian (bosanski)
 * @author CERminator
 * @author Palapa
 */
$messages['bs'] = array(
	'semanticmaps-desc' => 'Daje mogućnost pregleda i uređivanja podataka koordinata koji su spremljeni putem Semantic MediaWiki proširenja ([https://mapping.referata.com/wiki/Examples primjeri]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Vrijednost $1 nije ispravno odstojanje.',
	'semanticmaps-kml-link' => 'Pogledajte KML datoteku',
	'semanticmaps-default-kml-pagelink' => 'Pogledajte stranicu $1',
	'semanticmaps-loading-forminput' => 'Učitavam obrazac unosa za mapu...',
	'semanticmaps_lookupcoordinates' => 'Nađi koordinate',
	'semanticmaps_enteraddresshere' => 'Unesite adresu ovdje',
	'semanticmaps-updatemap' => 'Ažuriraj mapu',
	'semanticmaps-forminput-remove' => 'Ukloni',
	'semanticmaps-forminput-add' => 'Dodaj',
	'semanticmaps-forminput-locations' => 'Lokacije',
);

/** Catalan (català)
 * @author Dvdgmz
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'semanticmaps-desc' => "Ofereix l'habilitat de visualitzar i editar dades de coordenades emmagatzemades a través de l'extensió Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps més informació...]).",
	'semanticmaps-unrecognizeddistance' => 'El valor $1 no és un valor de distància.',
	'semanticmaps-kml-link' => 'Visualitza el fitxer KML',
	'semanticmaps-default-kml-pagelink' => 'Visualitza la pàgina $1',
	'semanticmaps-latitude' => 'Latitud: $1',
	'semanticmaps-longitude' => 'Longitud: $1',
	'semanticmaps-altitude' => 'Altitud: $1',
	'semanticmaps-loading-forminput' => "Carregant formulari d'entrada del mapa...",
	'semanticmaps_lookupcoordinates' => 'Consulta les coordenades',
	'semanticmaps_enteraddresshere' => 'Introduïu una adreça a continuació',
	'semanticmaps-updatemap' => 'Actualitza el mapa',
	'semanticmaps-forminput-remove' => 'Suprimeix',
	'semanticmaps-forminput-add' => 'Afegeix',
	'semanticmaps-forminput-locations' => 'Ubicacions',
	'semanticmaps-par-staticlocations' => "Una llista d'ubicacions per afegir al mapa juntament amb les dades consultades. Com amb 'display_points', s'hi pot afegir un títol, una descripció i una icona per a cada ubicació fent servir el signe \"~\" com a separador.",
	'semanticmaps-par-forceshow' => 'Es mostra el mapa fins i tot quan no hi ha ubicacions a mostrar?',
	'semanticmaps-par-showtitle' => "Es mostra o no un títol en la finestra d'informació del marcador. Inhabilitar-ho sovint és útil quan s'utilitza una plantilla per donar format al contingut de la finestra d'informació.",
	'semanticmaps-par-centre' => 'El centre del mapa. Quan no es proporciona, el map triarà automàticament el centre òptim per mostrar tots els marcadors al mapa.',
	'semanticmaps-par-template' => "Una plantilla que s'utilitza per dona format al contingut de la finestra d'informació.",
	'semanticmaps-par-geocodecontrol' => 'Mostra el control de geocodificació.',
);

/** Czech (česky)
 * @author Utar
 * @author XenoPheX
 */
$messages['cs'] = array(
	'semanticmaps-desc' => 'Poskytuje možnost zobrazit a upravovat data souřadnic uložená rozšířením Semantic MediaWiki ([https://mapping.referata.com/wiki/Examples demos]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Hodnota  $1  není platná vzdálenost.',
	'semanticmaps-kml-link' => 'Zobrazit soubor KML',
	'semanticmaps-default-kml-pagelink' => 'Zobrazit stránku $1',
	'semanticmaps-latitude' => 'Z. šířka: $1',
	'semanticmaps-longitude' => 'Z. délka: $1',
	'semanticmaps-altitude' => 'Nadm. výška: $1',
	'semanticmaps-loading-forminput' => 'Načítání mapy ze vstupu…',
	'semanticmaps_lookupcoordinates' => 'Vyhledat souřadnice',
	'semanticmaps_enteraddresshere' => 'Sem zadejte adresu',
	'semanticmaps-updatemap' => 'Aktualizovat mapu',
	'semanticmaps-forminput-remove' => 'Odebrat',
	'semanticmaps-forminput-add' => 'Přidat',
	'semanticmaps-forminput-locations' => 'Místa',
	'semanticmaps-par-staticlocations' => 'Seznam míst, která se přidají do mapy spolu s dotazovanými daty. Podobně jako u display_points můžete každé místo doplnit o titulek, popis a ikonu, za použití tildy „~“ jako oddělovače.',
	'semanticmaps-par-forceshow' => 'Zobrazit mapu i pokud nejsou žádná místa k zobrazení?',
	'semanticmaps-par-showtitle' => 'Zobrazovat název v info okně značky či ne. Vypnutí je často užitečné, pokud je obsah informačního okna formátován pomocí šablony.',
	'semanticmaps-par-centre' => 'Střed mapy. Není-li specifikován, mapa automaticky vybere optimální střed tak, aby byly zobrazeny všechny značky na ní.',
	'semanticmaps-par-template' => 'Šablona formátování obsahu informačního okna',
	'semanticmaps-par-geocodecontrol' => 'Zobrazit ovladač geocodingu.',
	'semanticmaps-kml-text' => 'Text je přidružený ke každé stránce. Je přepsán dodatečnými dotazovanými vlastnostmi, jsou-li nějaké.',
	'semanticmaps-kml-title' => 'Výchozí titulek pro výsledky',
	'semanticmaps-kml-linkabsolute' => 'Mají být odkazy absolutní či ne (tj. relativní)',
	'semanticmaps-kml-pagelinktext' => 'Text, který bude použit pro odkazy na stránku, ve kterém bude $1 nahrazeno názvem stránky',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'semanticmaps-unrecognizeddistance' => "Nid yw'r gwerth $1 yn bellter dilys.",
	'semanticmaps-kml-link' => 'Edrych ar y ffeil KML',
	'semanticmaps-default-kml-pagelink' => 'Edrych ar y dudalen $1',
	'semanticmaps-loading-forminput' => "Yn llwytho ffurflen mewnbynnu i'r map...",
	'semanticmaps_lookupcoordinates' => 'Canfydder y cyfesurynnau',
	'semanticmaps_enteraddresshere' => 'Ysgrifennwch y cyfeiriad yma',
	'semanticmaps-updatemap' => 'Diweddarer y map',
	'semanticmaps-forminput-remove' => 'Tynner oddi ar y map',
	'semanticmaps-forminput-add' => 'Ychwaneger',
	'semanticmaps-forminput-locations' => 'Lleoliadau',
	'semanticmaps-par-forceshow' => "Dangos y map, hyd yn oed pe nad oes mannau i'w dangos?",
);

/** German (Deutsch)
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author Metalhead64
 * @author Pill
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'semanticmaps-desc' => 'Ermöglicht das Anzeigen und Bearbeiten von Daten zu Koordinaten, die mit Semantic MediaWiki gespeichert werden ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps Weitere Informationen …]).',
	'semanticmaps-unrecognizeddistance' => 'Der Wert $1 ist keine gültige Distanz.',
	'semanticmaps-kml-link' => 'KML-Datei ansehen',
	'semanticmaps-kml' => 'Export (KML)',
	'semanticmaps-default-kml-pagelink' => 'Artikel $1 ansehen',
	'semanticmaps-latitude' => 'Breitengrad: $1',
	'semanticmaps-longitude' => 'Längengrad: $1',
	'semanticmaps-altitude' => 'Höhe: $1',
	'semanticmaps-loading-forminput' => 'Lade die Formulareingaben zur Karte …',
	'semanticmaps_lookupcoordinates' => 'Koordinaten nachschlagen',
	'semanticmaps_enteraddresshere' => 'Adresse hier eingeben',
	'semanticmaps-updatemap' => 'Karte aktualisieren',
	'semanticmaps-forminput-remove' => 'Entfernen',
	'semanticmaps-forminput-add' => 'Hinzufügen',
	'semanticmaps-forminput-locations' => 'Standort',
	'semanticmaps-par-staticlocations' => 'Die Listen von Standorten, die zusammen mit den abgefragten Daten, der Karte hinzugefügt werden sollen. Analog zu den Anzeigepunkten können je Standort Titel, Beschreibung und Symbol, unter Verwendung einer Tilde „~“ als Trennzeichen, hinzugefügt werden.',
	'semanticmaps-par-forceshow' => 'Die Karte auch dann anzeigen, wenn es keine anzuzeigenden Standorte gibt',
	'semanticmaps-par-showtitle' => 'Den Titel im Informationsfenster der Kennzeichnung anzeigen oder nicht. Diese Option zu deaktivieren ist oftmals dann nützlich, sofern eine Vorlage zur Formatierung des Informationsfensterinhalts verwendet wird.',
	'semanticmaps-par-hidenamespace' => 'Den Namen des Namensraums im Informationsfenster der Kennzeichnung anzeigen',
	'semanticmaps-par-centre' => 'Das Zentrum der Karte. Sofern nicht angegeben wird automatisch das optimale Zentrum zur Darstellung aller Kennzeichnungen auf der Karte gewählt.',
	'semanticmaps-par-template' => 'Die zur Formatierung des Informationsfensterinhalts zu verwendende Vorlage.',
	'semanticmaps-par-geocodecontrol' => 'Die Steuerungsseite zum Geokodieren anzeigen.',
	'semanticmaps-kml-text' => 'Der Text, der zu jeder Seite angezeigt wird. Wird im Fall zusätzlich abgefragter Attribute ersetzt.',
	'semanticmaps-kml-title' => 'Der Standardtitel für die Ergebnisse',
	'semanticmaps-kml-linkabsolute' => 'Die Links sollen absolut sein (anstatt relativ)',
	'semanticmaps-kml-pagelinktext' => 'Der Text, der für die Links zur Seite genutzt werden soll. $1 wird dabei durch den Namen der Seite ersetzt.',
	'semanticmaps-shapes-improperformat' => '$1 ist falsch formatiert. Siehe hierzu die Dokumentation bezüglich Formatierungen.',
	'semanticmaps-shapes-missingshape' => 'Für $1 wurden keine Formen gefunden. Siehe hierzu die Dokumentation bezüglich verfügbarer Formen.',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'semanticmaps-desc' => 'Bitujo zmóžnosć se koordinatowe daty pśez rozšyrjenje Semantic MediaWiki woglědaś a wobźěłaś ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps dalšne informacije...]).',
	'semanticmaps-unrecognizeddistance' => 'Gódnota $1 njejo płaśiwa distanca.',
	'semanticmaps-kml-link' => 'KML-dataju se woglědaś',
	'semanticmaps-default-kml-pagelink' => 'Bok $1 se woglědaś',
	'semanticmaps_lookupcoordinates' => 'Za koordinatami póglědaś',
	'semanticmaps_enteraddresshere' => 'Zapódaj how adresu',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 */
$messages['el'] = array(
	'semanticmaps_lookupcoordinates' => 'Επιθεώρηση συντεταγμένων',
	'semanticmaps_enteraddresshere' => 'Εισαγωγή διεύθυνσης εδώ',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'semanticmaps_lookupcoordinates' => 'Rigardi koordinatojn',
	'semanticmaps_enteraddresshere' => 'Enigu adreson ĉi tie',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Crazymadlover
 * @author Fitoschido
 * @author Imre
 * @author Locos epraix
 * @author Translationista
 */
$messages['es'] = array(
	'semanticmaps-desc' => 'Proporciona la posibilidad de ver y editar datos de coordenadas almacenados con la extensión Semantic MediaWiki (Más información.).',
	'semanticmaps-unrecognizeddistance' => 'El valor $1 no es una distancia válida.',
	'semanticmaps-kml-link' => 'Ver el archivo KML',
	'semanticmaps-default-kml-pagelink' => 'Ver página $1',
	'semanticmaps-latitude' => 'Latitud: $1',
	'semanticmaps-longitude' => 'Longitud: $1',
	'semanticmaps-altitude' => 'Altitud: $1',
	'semanticmaps-loading-forminput' => 'Cargando mapa de formulario de entrada...',
	'semanticmaps_lookupcoordinates' => 'Buscar coordenadas',
	'semanticmaps_enteraddresshere' => 'Introduce aquí la dirección',
	'semanticmaps-updatemap' => 'Actualizar mapa',
	'semanticmaps-forminput-remove' => 'Quitar',
	'semanticmaps-forminput-add' => 'Añadir',
	'semanticmaps-forminput-locations' => 'Ubicaciones',
	'semanticmaps-par-staticlocations' => 'Una lista de localizaciones para añadir al mapa junto a los datos consultados. De forma similar a display_points, puede añadir un título, una descripción o un icono por localización usando el signo "~" como separador.',
	'semanticmaps-par-forceshow' => '¿Mostrar el mapa incluso cuando no hay ubicaciones que mostrar?',
	'semanticmaps-par-showtitle' => 'Mostrar o no mostrar un título en la ventana de información del marcador. La desactivación de esto es frecuentemente útil al utilizar una plantilla para dar formato al contenido de la ventana de información.',
	'semanticmaps-par-hidenamespace' => 'Mostrar el título del espacio de nombres en la ventana de información del marcador.',
	'semanticmaps-par-centre' => 'El centro del mapa. Cuando no se proporciona, el mapa escogerá automáticamente el mejor centro para mostrar todos los marcadores en el mapa.',
	'semanticmaps-par-template' => 'Una plantilla a usar para dar formato al contenido de la ventana de información.',
	'semanticmaps-par-geocodecontrol' => 'Mostrar el control de geocodificación.',
	'semanticmaps-kml-text' => 'El texto asociado a cada página. Es substituído por las propiedades recuperadas adicionales, si existen.',
	'semanticmaps-kml-title' => 'El título por defecto para los resultados',
	'semanticmaps-kml-linkabsolute' => 'Los enlaces deberían ser absolutos (lo opuesto de relativos)',
	'semanticmaps-kml-pagelinktext' => 'El texto a usar para los enlaces a la página, en las que $1 será substituído por el título de la página',
	'semanticmaps-shapes-improperformat' => 'Formateo incorrecto de $1, por favor consulta la documentación sobre formateo',
	'semanticmaps-shapes-missingshape' => 'No se ha encontrado ninguna forma para $1, por favor consulta la documentación sobre formas disponibles',
);

/** Estonian (eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'semanticmaps-latitude' => 'Laiuskraad:$1',
	'semanticmaps-longitude' => 'Pikkuskraad:$1',
	'semanticmaps-updatemap' => 'Uuenda kaart',
	'semanticmaps-forminput-remove' => 'Eemalda',
	'semanticmaps-forminput-add' => 'Lisa',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'semanticmaps_lookupcoordinates' => 'Koordenatuak bilatu',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'semanticmaps-forminput-remove' => 'حذف',
	'semanticmaps-forminput-add' => 'افزودن',
	'semanticmaps-forminput-locations' => 'مکان‌ها',
);

/** Finnish (suomi)
 * @author Beluga
 * @author Crt
 * @author Nedergard
 * @author Str4nd
 */
$messages['fi'] = array(
	'semanticmaps-desc' => 'Mahdollistaa Semantic MediaWiki -laajennuksen avulla tallennettujen koordinaattitietojen näyttämisen ja muokkaamisen ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps lisätietoja]).',
	'semanticmaps-unrecognizeddistance' => 'Arvoa  $1  ei ole sallittu etäisyys.',
	'semanticmaps-kml-link' => 'Näytä KLM-tiedosto',
	'semanticmaps-default-kml-pagelink' => 'Näytä sivu $1',
	'semanticmaps-latitude' => 'Leveyspiiri: $1',
	'semanticmaps-longitude' => 'Pituuspiiri: $1',
	'semanticmaps-altitude' => 'Korkeus: $1',
	'semanticmaps-loading-forminput' => 'Ladataan kartan lomaketietoja...',
	'semanticmaps_lookupcoordinates' => 'Hae koordinaatit',
	'semanticmaps_enteraddresshere' => 'Kirjoita osoite tähän',
	'semanticmaps-updatemap' => 'Päivitä kartta',
	'semanticmaps-forminput-remove' => 'Poista',
	'semanticmaps-forminput-add' => 'Lisää',
	'semanticmaps-forminput-locations' => 'Sijainnit',
	'semanticmaps-par-staticlocations' => 'Sijaintien luettelo voidaan lisätä karttaan kyselydatan lisäksi. Kuten display_points-parametrissa voit lisätä sijaintikohtaisen otsikon, kuvauksen ja kuvakkeen; erottimena on "~".',
	'semanticmaps-par-forceshow' => 'Näytetäänkö kartta, jos näytettäviä sijainteja ei ole?',
	'semanticmaps-par-showtitle' => 'Näyttää kohdemerkin tietoikkunan otsikon tai ei. Käytöstä poisto on usein hyödyllistä, jos tietoikkunan sisältö muotoillaan mallineella.',
	'semanticmaps-par-hidenamespace' => 'Näytä nimiavaruuden otsikko kohdemerkin tietoikkunassa',
	'semanticmaps-par-centre' => 'Kartan keskus. Jos sitä ei määritetä, kartta laskee automaattisesti optimaalisen keskuksen kartalla olevien kohdemerkkien perusteella.',
	'semanticmaps-par-template' => 'Tietoikkunan sisällön muotoilussa käytettävä malline.',
	'semanticmaps-par-geocodecontrol' => 'Näytä geokoodausohjaimet.',
	'semanticmaps-kml-text' => 'Kuhunkin sivuun liittyvä teksti. Jos kyselyllä on lisäominaisuuksia, ne syrjäyttävät tämän.',
	'semanticmaps-kml-title' => 'Tulossivun oletusotsikko',
	'semanticmaps-kml-linkabsolute' => 'Ovatko linkit absoluuttisia (eivätkä suhteellisia)',
	'semanticmaps-kml-pagelinktext' => 'Sivulinkeissä käytettävä teksti, jossa $1 korvataan sivun otsikolla',
	'semanticmaps-shapes-improperformat' => '$1 on muotoiltu väärin. Katso muotoilun dokumentaatiota.',
	'semanticmaps-shapes-missingshape' => '$1: muotoja ei löytynyt. Dokumentaatiossa kerrotaan sallituista muodoista.',
);

/** French (français)
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author Jean-Frédéric
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Wyz
 */
$messages['fr'] = array(
	'semanticmaps-desc' => "Permet d'afficher et de modifier les données de coordonnées stockées par l'extension Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps more info...]).",
	'semanticmaps-unrecognizeddistance' => "La valeur $1 n'est pas une distance valide",
	'semanticmaps-kml-link' => 'Voir le fichier KML',
	'semanticmaps-default-kml-pagelink' => 'Voir l’article $1',
	'semanticmaps-latitude' => 'Latitude : $1',
	'semanticmaps-longitude' => 'Longitude : $1',
	'semanticmaps-altitude' => 'Altitude : $1',
	'semanticmaps-loading-forminput' => "Chargement du formulaire d'entrée de la carte...",
	'semanticmaps_lookupcoordinates' => 'Estimer les coordonnées',
	'semanticmaps_enteraddresshere' => 'Entrez ici l’adresse',
	'semanticmaps-updatemap' => 'Mise à jour de la carte',
	'semanticmaps-forminput-remove' => 'Enlever',
	'semanticmaps-forminput-add' => 'Ajouter',
	'semanticmaps-forminput-locations' => 'Emplacements',
	'semanticmaps-par-staticlocations' => 'Une liste des endroits à ajouter à la carte avec les données demandées. Comme avec display_points, vous pouvez ajouter un titre, une description et une icône par emplacement en utilisant le tilde « ~ » comme séparateur.',
	'semanticmaps-par-forceshow' => "Afficher la carte même quand il n'y a pas d'emplacement à afficher ?",
	'semanticmaps-par-showtitle' => "Afficher un titre dans la fenêtre d'informations des marqueurs ou non. La désactivation de ceci est souvent utile lorsque vous utilisez un modèle pour formater le contenu de la fenêtre d'informations.",
	'semanticmaps-par-hidenamespace' => 'Afficher ou non le titre de l’espace de noms dans la fenêtre d’information du marqueur.',
	'semanticmaps-par-centre' => "Le centre de la carte. Lorsqu'il n'est pas fourni, la carte va choisir automatiquement le centre optimal pour afficher tous les marqueurs sur la carte.",
	'semanticmaps-par-template' => "Un modèle à utiliser pour mettre en forme le contenu de la fenêtre d'informations.",
	'semanticmaps-par-geocodecontrol' => 'Afficher le contrôle de géocodage.',
	'semanticmaps-kml-text' => "Le texte associé avec chaque page. Remplacé par des propriétés récupérées supplémentaires s'il y en a.",
	'semanticmaps-kml-title' => 'Le titre par défaut pour les résultats',
	'semanticmaps-kml-linkabsolute' => 'Si les titres doivent être absolus ou non (c.à.d. relatifs)',
	'semanticmaps-kml-pagelinktext' => 'Le texte à utiliser pour les liens vers la page, dans lesquels $1 sera remplacé par le titre de la page',
	'semanticmaps-shapes-improperformat' => 'Format de $1 incorrect, veuillez vous reporter à la documentation pour le format attendu',
	'semanticmaps-shapes-missingshape' => 'Aucune forme trouvée pour $1; veuillez voir dans la documentation les formes disponibles',
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'semanticmaps-unrecognizeddistance' => 'La valor $1 est pas una distance valida.',
	'semanticmaps-kml-link' => 'Vêre lo fichiér KML',
	'semanticmaps-default-kml-pagelink' => 'Vêre la pâge $1',
	'semanticmaps-latitude' => 'Latituda : $1',
	'semanticmaps-longitude' => 'Longituda : $1',
	'semanticmaps-altitude' => 'Hôtior : $1',
	'semanticmaps-loading-forminput' => 'Chargement du formulèro d’entrâ de la mapa...',
	'semanticmaps_lookupcoordinates' => 'Èstimar les coordonâs',
	'semanticmaps_enteraddresshere' => 'Buchiéd l’adrèce ique',
	'semanticmaps-updatemap' => 'Misa a jorn de la mapa',
	'semanticmaps-forminput-remove' => 'Enlevar',
	'semanticmaps-forminput-add' => 'Apondre',
	'semanticmaps-forminput-locations' => 'Emplacements',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'semanticmaps-desc' => 'Proporciona a capacidade de ollar e modificar os datos de coordenadas gardados a través da extensión Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps máis información...]).',
	'semanticmaps-unrecognizeddistance' => 'O valor $1 non é unha distancia válida.',
	'semanticmaps-kml-link' => 'Ollar o ficheiro KML',
	'semanticmaps-default-kml-pagelink' => 'Ver a páxina "$1"',
	'semanticmaps-latitude' => 'Latitude: $1',
	'semanticmaps-longitude' => 'Lonxitude: $1',
	'semanticmaps-altitude' => 'Altitude: $1',
	'semanticmaps-loading-forminput' => 'Cargando o formulario de entrada do mapa...',
	'semanticmaps_lookupcoordinates' => 'Ver as coordenadas',
	'semanticmaps_enteraddresshere' => 'Introduza o enderezo aquí',
	'semanticmaps-updatemap' => 'Actualizar o mapa',
	'semanticmaps-forminput-remove' => 'Eliminar',
	'semanticmaps-forminput-add' => 'Engadir',
	'semanticmaps-forminput-locations' => 'Localizacións',
	'semanticmaps-par-staticlocations' => 'Unha lista de localizacións para engadir ao mapa xunto aos datos consultados. Como con display_points, pode engadir un título, unha descrición e mais unha icona por localización mediante o signo "~" como separador.',
	'semanticmaps-par-forceshow' => 'Quere mostrar o mapa, mesmo cando non haxa localizacións que presentar?',
	'semanticmaps-par-showtitle' => 'Mostrar ou non un título na ventá de información do marcador. Frecuentemente, desactivar isto é útil ao utilizar un modelo para dar formato ao contido da ventá de información.',
	'semanticmaps-par-hidenamespace' => 'Mostrar o título do espazo de nomes na ventá de información do marcador',
	'semanticmaps-par-centre' => 'O centro do mapa. Cando non se proporciona, o mapa ha escoller automaticamente o mellor centro para mostrar todos os marcadores no mapa.',
	'semanticmaps-par-template' => 'Un modelo a empregar para dar formato ao contido da ventá de información.',
	'semanticmaps-par-geocodecontrol' => 'Mostrar o control de xeocodificación.',
	'semanticmaps-kml-text' => 'O texto asociado a cada páxina. Substituído polas propiedades pescudadas adicionais, se existen.',
	'semanticmaps-kml-title' => 'O título por defecto para os resultados',
	'semanticmaps-kml-linkabsolute' => 'Se as ligazóns deberían ser absolutas (contrario a relativas)',
	'semanticmaps-kml-pagelinktext' => 'O texto a usar para as ligazóns cara á páxina, nas que "$1" será substituído polo título da páxina',
	'semanticmaps-shapes-improperformat' => 'Formato incorrecto de "$1"; consulte a documentación sobre os formatos',
	'semanticmaps-shapes-missingshape' => 'Non se atopou forma ningunha para "$1"; consulte a documentación sobre as formas dispoñibles',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'semanticmaps-desc' => 'Ergänzt e Megligkeit zum Aaluege un Bearbeite vu Koordinate, wu im Ramme vu dr Erwyterig „Semantisch MediaWiki“ gspycheret wore sin. [https://www.mediawiki.org/wiki/Extension:Semantic_Maps Dokumäntation]. [https://mapping.referata.com/wiki/Examples Demo]', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Dr Wert $1 isch kei giltigi Dischtanz.',
	'semanticmaps-kml-link' => 'KML-Datei aaluege',
	'semanticmaps-default-kml-pagelink' => 'Syte $1 aaluege',
	'semanticmaps-loading-forminput' => 'Am Lade vu dr Formularyygabe zue dr Charte …',
	'semanticmaps_lookupcoordinates' => 'Koordinate nooluege',
	'semanticmaps_enteraddresshere' => 'Doo Adräss yygee',
	'semanticmaps-updatemap' => 'Charte aktualisiere',
	'semanticmaps-forminput-remove' => 'Uuseneh',
	'semanticmaps-forminput-add' => 'Zuefiege',
	'semanticmaps-forminput-locations' => 'Standort',
	'semanticmaps-par-staticlocations' => 'E Lischt vo Standört, wo zämme mit de Date, wo aabgfrogt werde, uff de Charte dezuegno werde sölle. Analog zue de Aazeigpünkt, chönne zue jedem Standort mit de Tilde „~“ als Trennzeiche, e Titel, Beschrybig un Symbol dezuegno werde.',
	'semanticmaps-par-forceshow' => 'Die Charte au aazeige, wänn es kei Standört zum Aazeige git?',
	'semanticmaps-par-showtitle' => 'E Titel im Informationsfenschter vo de Kennzeichnig aazeige oder nit. Des z deaktiviere isch vilmool nützlig, wänn e Vorlag zur Formatierig vum Inhalt vum Informationsfenschter bruucht wird.',
	'semanticmaps-par-centre' => "S Zentrum vo de Chart. Wänn's nit andersch aagee isch, wird automatisch s optimali Zentrum zur Darstellig vo allene Kennzeichnige uff de Chart ussgwäält.",
	'semanticmaps-par-template' => 'E Vorlag, wo zur Formatierig vum Inhalt vum Informationsfenschter bruucht wird.',
	'semanticmaps-par-geocodecontrol' => 'D Stüürigssyte zum Geokodiere aazeige.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'semanticmaps-desc' => 'הוספת האפשרות לצפייה בנתוני הקואורדינטות המאוחסנים ולעריכתם באמצעות ההרחבה מדיה־ויקי סמנטית ([https://mapping.referata.com/wiki/Examples הדגמות]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'הערך $1 אינו מרחק תקין.',
	'semanticmaps-kml-link' => 'הצגת קובץ KML',
	'semanticmaps-default-kml-pagelink' => 'הצגת הדף $1',
	'semanticmaps-latitude' => 'קו־רוחב: $1',
	'semanticmaps-longitude' => 'קו־אורך: $1',
	'semanticmaps-altitude' => 'גובה: $1',
	'semanticmaps-loading-forminput' => 'טעינת המפה מהקלט...',
	'semanticmaps_lookupcoordinates' => 'חיפוש קואורדינטות',
	'semanticmaps_enteraddresshere' => 'כתבו כתובת כאן',
	'semanticmaps-updatemap' => 'עדכון מפה',
	'semanticmaps-forminput-remove' => 'הסרה',
	'semanticmaps-forminput-add' => 'הוספה',
	'semanticmaps-forminput-locations' => 'מיקומים',
	'semanticmaps-par-staticlocations' => 'רשימת מיקומים להוסיף למפה יחד עם הנתונים המבוקשים בשאילתה. כמו עם display_points, אפשר להוסיף כאן כותרת, תיאור וסמל לכל מיקום עם טילדה (~) בתור תו מפריד.',
	'semanticmaps-par-forceshow' => 'להציג מפה גם כשאין מיקומים להצגה?',
	'semanticmaps-par-showtitle' => 'להציג את הכותרת בחלון המידע על הסמן או לא. הכיבוי של זה שימושי לעתים קרובות כאשר נעשה שימוש בתבנית לעיצוב חלון המידע.',
	'semanticmaps-par-hidenamespace' => 'האם להציג את שם המרחב בחלון המידע על סמן.',
	'semanticmaps-par-centre' => 'מרכז המפה. אם לא ניתן, המפה תבחר בעצמה את המרכז המיטבי להצגת כל הסמנים על המפה.',
	'semanticmaps-par-template' => 'תבנית לעיצוב תוכן חלון המידע.',
	'semanticmaps-par-geocodecontrol' => 'הצגת בקר קידוד גאוגרפי.',
	'semanticmaps-kml-text' => 'הטקסט משויך לכל עמוד ועמוד. נדרס במאפיינים אחרים שנעשית עליהם שאילתה, אם יש כאלה.',
	'semanticmaps-kml-title' => 'כותרת לתוצאות לפי בררת המחדל.',
	'semanticmaps-kml-linkabsolute' => 'האם הקישורים צריכים להיות מוחלטים (או יחסיים)',
	'semanticmaps-kml-pagelinktext' => 'הטקסט שישמש לקישורים לדף, כאשר $1 יוחלף בכותרת הדף',
);

/** Croatian (hrvatski)
 * @author Tivek
 */
$messages['hr'] = array(
	'semanticmaps-desc' => "Pruža pregledavanje i uređivanje koordinata spremljenih koristeći Semantic MediaWiki ekstenziju ([https://mapping.referata.com/wiki/Examples demo's]).", # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Vrijednost $1 nije valjana udaljenost.',
	'semanticmaps_lookupcoordinates' => 'Potraži koordinate',
	'semanticmaps_enteraddresshere' => 'Unesite adresu ovdje',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'semanticmaps-desc' => 'Zmóžnja zwobraznjenje a wobdźěłanje koordinatowych datow, kotrež su so z rozšěrjenjom Semantic MediaWiki składowali ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps dalše informacije...]).',
	'semanticmaps-unrecognizeddistance' => 'Hódnota $1 płaćiwa distanca njeje.',
	'semanticmaps-kml-link' => 'KML-dataju sej wobhladać',
	'semanticmaps-default-kml-pagelink' => 'Nastawk $1 sej wobhladać',
	'semanticmaps-latitude' => 'Šěrokostnik: $1',
	'semanticmaps-longitude' => 'Dołhostnik: $1',
	'semanticmaps-altitude' => 'Wysokosć: $1',
	'semanticmaps-loading-forminput' => 'Formularne zapodawanske polo karty so začituje...',
	'semanticmaps_lookupcoordinates' => 'Za koordinatami hladać',
	'semanticmaps_enteraddresshere' => 'Zapodaj tu adresu',
	'semanticmaps-updatemap' => 'Kartu aktualizować',
	'semanticmaps-forminput-remove' => 'Wotstronić',
	'semanticmaps-forminput-add' => 'Přidać',
	'semanticmaps-forminput-locations' => 'Městna',
	'semanticmaps-par-staticlocations' => 'Lisćina městnow, kotrež maja so zhromadnje z naprašowanymi datami karće přidać. Kaž pola zwobraznjenskich dypkow móžeš titul. wopisanje a symbol na městno z pomocu tildy "~" jako dźělatko přidać.',
	'semanticmaps-par-forceshow' => 'Kartu tež potom pokazać, hdyž městna za zwobraznjenje njejsu?',
	'semanticmaps-par-showtitle' => 'Titul w iformaciskim woknje woznamjenjenja pokazać abo nic. Je husto wužitne, tutu opciju znjemóžnić, hdyž so předłoha wužiwa, zo by so wobsah informaciskeho wokna formatował.',
	'semanticmaps-par-hidenamespace' => 'Mjeno mjenoweho ruma w informaciskim woknje woznamjenjenja pokazać abo nic.',
	'semanticmaps-par-centre' => 'Srjedźišćo karty. Jeli je njepodate, budźe so karta awtomatisce optimalne srjedźišćo wuběrać, zo bychu so wšě woznamjenjenja na karće pokazali.',
	'semanticmaps-par-template' => 'Předłoha, kotraž ma so za formatowanje wobsaha infowokna wužiwać,',
	'semanticmaps-par-geocodecontrol' => 'Geokodowanske wodźenje pokazać',
	'semanticmaps-kml-text' => 'Tekst, kotryž je z kóždej stronu zwjazany.  Naruna so přez přidatne naprašowane kajkosće, jeli tajke su.',
	'semanticmaps-kml-title' => 'Standardny titul za wuslědki',
	'semanticmaps-kml-linkabsolute' => 'Hač wotkazy maja absolutne być abo nic (t.r. relatiwne)',
	'semanticmaps-kml-pagelinktext' => 'Tekst, kotryž ma so za wotkazy k tej stronje wužiwać, w kotrejž $1 so přez titul strony naruna',
	'semanticmaps-shapes-improperformat' => '$1 je so wopak formatował. Prošu hlej dokumentaciju za formatowanje',
	'semanticmaps-shapes-missingshape' => 'Žane formy njejsu za $1 namakałi. Prošu hlej dokumentaciju za k dispoziciji stejace formy.',
);

/** Hungarian (magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'semanticmaps-desc' => 'Lehetővé teszi a szemantikus MediaWiki kiterjesztéssel tárolt koordinátaadatok megtekintését és szerkesztését ([https://mapping.referata.com/wiki/Examples bemutató]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'A(z) $1 érték nem egy érvényes távolság.',
	'semanticmaps-kml-link' => 'KML fájl megtekintése',
	'semanticmaps-default-kml-pagelink' => 'A(z) $1 lap megtekintése',
	'semanticmaps-latitude' => 'Szélesség: $1',
	'semanticmaps-longitude' => 'Hosszúság: $1',
	'semanticmaps-altitude' => 'Tengerszint feletti magasság: $1',
	'semanticmaps-loading-forminput' => 'Térkép űrlapjának betöltése&hellip;',
	'semanticmaps_lookupcoordinates' => 'Koordináták felkeresése',
	'semanticmaps_enteraddresshere' => 'Add meg a címet itt',
	'semanticmaps-updatemap' => 'Térkép frissítése',
	'semanticmaps-forminput-remove' => 'Eltávolítás',
	'semanticmaps-forminput-add' => 'Hozzáadás',
	'semanticmaps-forminput-locations' => 'Helyszínek',
	'semanticmaps-par-staticlocations' => 'A térképre a lekérdezett adatok mellett felveendő helyek listája. Akárcsak a megjelenítési pontokkal, minden helyhez megadhatsz címet, leírást és ikont hullámvonal ("~") elválasztóval.',
	'semanticmaps-par-forceshow' => 'Megjelenítsem a térképet akkor is, ha nincsenek megjeleníthető helyek?',
	'semanticmaps-par-showtitle' => 'Megjelenítse a címet a jelző információs ablakában, vagy ne? Ennek kikapcsolás hasznos lehet, ha sablonnal formázod az információs ablak tartalmát.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticmaps-desc' => 'Forni le capacitate de vider e modificar datos de coordinatas immagazinate con le extension Semantic MediaWiki ([https://mapping.referata.com/wiki/Examples demonstrationes]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Le valor $1 non es un distantia valide.',
	'semanticmaps-kml-link' => 'Vider le file KML',
	'semanticmaps-default-kml-pagelink' => 'Vider articulo $1',
	'semanticmaps-latitude' => 'Latitude: $1',
	'semanticmaps-longitude' => 'Longitude: $1',
	'semanticmaps-altitude' => 'Altitude: $1',
	'semanticmaps-loading-forminput' => 'Carga datos entrate in formulario...',
	'semanticmaps_lookupcoordinates' => 'Cercar coordinatas',
	'semanticmaps_enteraddresshere' => 'Entra adresse hic',
	'semanticmaps-updatemap' => 'Actualisar carta',
	'semanticmaps-forminput-remove' => 'Remover',
	'semanticmaps-forminput-add' => 'Adder',
	'semanticmaps-forminput-locations' => 'Locos',
	'semanticmaps-par-staticlocations' => 'Un lista de locos a adder al carta con le datos resultante del consulta. Como con display_points, tu pote adder un titulo, description e icone per loco usante le tilde "~" como separator.',
	'semanticmaps-par-forceshow' => 'Monstrar le carta mesmo si il non ha locos a monstrar?',
	'semanticmaps-par-showtitle' => 'Monstrar un titulo in le fenestra de information de marcator o non. Disactivar isto es sovente utile si un patrono es usate pro formatar le contento del fenestra de information.',
	'semanticmaps-par-hidenamespace' => 'Monstrar o celar le titulo del spatio de nomines in le fenestra de information del marcator.',
	'semanticmaps-par-centre' => 'Le centro del carta. Si non specificate, le systema selige automaticamente le centro optimal pro monstrar tote le marcatores in le carta.',
	'semanticmaps-par-template' => 'Un patrono a usar pro formatar le contento del fenestra de information.',
	'semanticmaps-par-geocodecontrol' => 'Monstrar le controlo de geocodification.',
	'semanticmaps-kml-text' => 'Le texto associate con cata pagina. Es supplantate per le additional proprietates consultate, si existe.',
	'semanticmaps-kml-title' => 'Le titulo predefinite pro resultatos',
	'semanticmaps-kml-linkabsolute' => 'Debe ligamines esser absolute o non (i.e. relative)',
	'semanticmaps-kml-pagelinktext' => 'Le texto a usar pro le ligamines al pagina, in le quales $1 essera reimplaciate per le titulo de pagina',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'semanticmaps-desc' => 'Memberikan kemampuan untuk melihat dan menyunting data koordinat yang disimpan melalui pengaya MediaWiki Semantic
([https://mapping.referata.com/wiki/Examples demo]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Nilai $1 bukan jarak yang sah.',
	'semanticmaps-kml-link' => 'Lihat berkas KML',
	'semanticmaps-default-kml-pagelink' => 'Lihat halaman $1',
	'semanticmaps-loading-forminput' => 'Memuat masukan bentuk peta...',
	'semanticmaps_lookupcoordinates' => 'Cari koordinat',
	'semanticmaps_enteraddresshere' => 'Masukkan alamat di sini',
	'semanticmaps-updatemap' => 'Pembaruan peta',
	'semanticmaps-forminput-remove' => 'Hapus',
	'semanticmaps-forminput-add' => 'Tambah',
	'semanticmaps-forminput-locations' => 'Lokasi',
	'semanticmaps-par-staticlocations' => 'Daftar lokasi yang akan ditambahkan ke dalam peta, berikut data kueri. Seperti halnya display_points, Anda dapat menambahkan judul, deskripsi, dan ikon per lokasi dengan menggunakan tanda tilde "~" sebagai pemisah.',
	'semanticmaps-par-forceshow' => 'Tampilkan peta bahkan ketika tidak ada lokasi untuk ditampilkan?',
	'semanticmaps-par-showtitle' => 'Tampilkan judul di jendela info penanda. Penonaktifan judul sering berguna ketika menggunakan templat untuk memformat isi jendela info.',
	'semanticmaps-par-centre' => 'Pusat peta. Jika tidak disediakan, peta secara otomatis akan memilih pusat optimal untuk menampilkan semua penanda di peta.',
	'semanticmaps-par-template' => 'Ttemplat yang digunakan untuk memformat isi jendela info.',
);

/** Italian (italiano)
 * @author Beta16
 * @author Civvì
 * @author Darth Kule
 * @author HalphaZ
 */
$messages['it'] = array(
	'semanticmaps-desc' => "Fornisce la possibilità di visualizzare e modificare le coordinate memorizzate con l'estensione Semantic MediaWiki  ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps ulteriori informazioni]).",
	'semanticmaps-unrecognizeddistance' => 'Il valore $1 non è una distanza valida.',
	'semanticmaps-kml-link' => 'Visualizza il file KML',
	'semanticmaps-default-kml-pagelink' => 'Visualizza la pagina $1',
	'semanticmaps-latitude' => 'Latitudine: $1',
	'semanticmaps-longitude' => 'Longitudine: $1',
	'semanticmaps-altitude' => 'Altitudine: $1',
	'semanticmaps-loading-forminput' => 'Caricamento del modulo input per mappe...',
	'semanticmaps_lookupcoordinates' => 'Cerca coordinate',
	'semanticmaps_enteraddresshere' => 'Inserisci indirizzo qui',
	'semanticmaps-updatemap' => 'Aggiorna mappa',
	'semanticmaps-forminput-remove' => 'Rimuovi',
	'semanticmaps-forminput-add' => 'Aggiungi',
	'semanticmaps-forminput-locations' => 'Luoghi',
	'semanticmaps-par-staticlocations' => 'Un elenco di luoghi da aggiungere alla mappa unitamente ai dati interrogati. Come con display_points, si può aggiungere un titolo, la descrizione e l\'icona per ogni posizione utilizzando la tilde "~" come separatore.',
	'semanticmaps-par-forceshow' => "Mostra la mappa anche quando non c'è alcun luogo da visualizzare?",
	'semanticmaps-par-showtitle' => "Mostrare oppure no un titolo nella finestra informazioni per l'indicatore. Disattivarlo è spesso utile quando si utilizza un template per la formattazione del contenuto della finestra informazioni.",
	'semanticmaps-par-hidenamespace' => "Mostrare oppure no il namespace del titolo nella finestra informazioni per l'indicatore.",
	'semanticmaps-par-centre' => 'Il centro della mappa. Quando non indicato, la mappa sceglierà automaticamente il centro ottimale per visualizzare tutti gli indicatori sulla mappa.',
	'semanticmaps-par-template' => 'Un template da utilizzare per formattare il contenuto della finestra informazioni.',
	'semanticmaps-par-geocodecontrol' => 'Mostra il controllo per geocodifica.',
	'semanticmaps-kml-text' => "Il testo associato per ogni pagina. Sovrascritto dall'eventuale proprietà dell'interrogazione aggiuntiva.",
	'semanticmaps-kml-title' => 'Il titolo predefinito per i risultati',
	'semanticmaps-kml-linkabsolute' => 'I collegamenti dovranno essere assoluti o no (ovvero relativi)',
	'semanticmaps-kml-pagelinktext' => 'Il testo da utilizzare per i collegamenti alla pagina, in cui $1 verrà sostituito dal titolo della pagina',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Mizusumashi
 * @author Schu
 * @author Shirayuki
 * @author 青子守歌
 */
$messages['ja'] = array(
	'semanticmaps-desc' => 'Semantic MediaWiki 拡張機能で格納された座標データを表示・編集する機能を提供する ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps 詳細情報...])',
	'semanticmaps-unrecognizeddistance' => '値$1は有効な距離ではありません。',
	'semanticmaps-kml-link' => 'KMLファイルを閲覧',
	'semanticmaps-default-kml-pagelink' => 'ページ$1を表示',
	'semanticmaps-latitude' => '緯度: $1',
	'semanticmaps-longitude' => '経度: $1',
	'semanticmaps-altitude' => '高度: $1',
	'semanticmaps-loading-forminput' => 'フォーム入力からマップを読み込んでいます...',
	'semanticmaps_lookupcoordinates' => '座標を検索',
	'semanticmaps_enteraddresshere' => '住所をここに入力',
	'semanticmaps-updatemap' => '地図を更新',
	'semanticmaps-forminput-remove' => '除去',
	'semanticmaps-forminput-add' => '追加',
	'semanticmaps-forminput-locations' => '場所',
	'semanticmaps-par-staticlocations' => '問い合わせたデータと共に地図に追加する場所の列挙です。display_points と同様に、区切り文字としてチルダ "~" を使用して、場所ごとにタイトル、説明、アイコンを追加できます。',
	'semanticmaps-par-forceshow' => '表示する場所がない場合でも、地図を表示しますか？',
	'semanticmaps-par-showtitle' => 'マーカーの情報ウィンドウのタイトルを表示するかどうか。情報ウィンドウのコンテンツをフォーマットするためにテンプレートを使用するとき、これを無効にすると便利です。',
	'semanticmaps-par-hidenamespace' => 'マーカー情報ウィンドウに名前空間名を表示する',
	'semanticmaps-par-centre' => '地図の中心。提供されていないときは、自動的に地図上のすべてのマーカーを表示するための最適な中心が選択されます。',
	'semanticmaps-par-template' => '情報ウィンドウのコンテンツの整形に使用するテンプレートです。',
	'semanticmaps-par-geocodecontrol' => 'ジオコーディングコントロールを表示します。',
	'semanticmaps-kml-text' => '各ページに関連付けられたテキストです。クエリに追加的なプロパティがある場合は上書きされます。',
	'semanticmaps-kml-title' => '結果の既定のタイトル',
	'semanticmaps-kml-linkabsolute' => 'リンクは絶対表記 (= 相対表記の対義語) にしてください。',
	'semanticmaps-kml-pagelinktext' => 'ページへのリンクに使用するテキスト ($1 はページ名に置換される)',
	'semanticmaps-shapes-improperformat' => '$1 を不適切な形式に整形しようとしました。整形のドキュメントを参照してください。',
	'semanticmaps-shapes-missingshape' => '$1 の図形が見つかりません。利用できる図形についてドキュメントを参照してください。',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'semanticmaps-kml-link' => 'KML ფაილის ხილვა',
	'semanticmaps-default-kml-pagelink' => 'გვერდი $1 ხილვა',
	'semanticmaps-latitude' => 'განედი: $1',
	'semanticmaps-longitude' => 'გრძედი: $1',
	'semanticmaps-altitude' => 'სიმაღლე: $1',
	'semanticmaps_enteraddresshere' => 'შეიყვანეთ მისამართი',
	'semanticmaps-updatemap' => 'რუკის განახლება',
	'semanticmaps-forminput-remove' => 'წაშლა',
	'semanticmaps-forminput-add' => 'დამატება',
	'semanticmaps-forminput-locations' => 'მდებარეობები',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'semanticmaps_lookupcoordinates' => 'ក្រឡេក​មើល​កូអរដោនេ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'semanticmaps-desc' => 'Määt et müjjelesch, Koodinaate ze beloore un ze ändere, di mem „Semantesch Mediawiki“ faßjehallde woode sin. ([https://mapping.referata.com/wiki/Examples Beijshpöll för et vörzemaache])', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Dä Wäät „$1“ es keine jölteje Afschtand.',
	'semanticmaps-kml-link' => 'De KML-Dattei belooere',
	'semanticmaps-kml' => 'Äxpoot als KML',
	'semanticmaps-default-kml-pagelink' => 'De Sigg „$1“ belooere',
	'semanticmaps-latitude' => 'Dä Breedejrad om Jloobos: $1',
	'semanticmaps-longitude' => 'Dä Längejraad om Jloobos: $1',
	'semanticmaps-altitude' => 'De Hühde: $1',
	'semanticmaps-loading-forminput' => 'Mer sin de Enjaabe vum Fommulaa for die Kaat aam laade&nbsp;…',
	'semanticmaps_lookupcoordinates' => 'Koordinate nohkike',
	'semanticmaps_enteraddresshere' => 'Donn hee de Address enjäve',
	'semanticmaps-updatemap' => 'De Kaad op der neue Shtand bränge',
	'semanticmaps-forminput-remove' => 'Fottnämme',
	'semanticmaps-forminput-add' => 'Dobei donn',
	'semanticmaps-forminput-locations' => 'Oote',
	'semanticmaps-par-staticlocations' => 'En Leß met Pläz, di zosamme met dä nohjefrochte Aanjabe op di Kaat sulle. Wi bei <code lang="en">display_points</code> kam_mer ene Tittel, ene Täx doh zoh, un e Minni_Belldsche
för jeede Plaz aanjävve, med enem Schlängelsche (~) doh zwesche.',
	'semanticmaps-par-forceshow' => 'Donn de Kaat aanzeije, selvs wann kein Pläz drop ze zeije sin?',
	'semanticmaps-par-showtitle' => 'Donn en Övverschreff en däm Finster met Infomazjuhne övver de Makeerong aanzeije udder nit. De Övverschreff afzeschallde es öff joot, wam_mer en Schabloon nemmp för dä Enhallt vum Finster zerääsch ze possumenteere.',
	'semanticmaps-par-hidenamespace' => 'Zeisch dä Name vum Appachtemang em  marker info Finster udder nit.',
	'semanticmaps-par-centre' => 'Der Meddelpunk vun dä Kaat. Wann keine aanjejovve_n_es jeiht dä automattesch op der optesche Meddelpunk vun all dä Makeerunge en dä Kaat.',
	'semanticmaps-par-template' => 'En Schabloon för der Enhalt vum Finster met de Enfommazjuhne ze jeschtallte',
	'semanticmaps-par-geocodecontrol' => "Donn dat Bedeenelemänt aanzeije för de Ko'odinaate op de Ääd ze beärbeide",
	'semanticmaps-kml-text' => 'Dä Täx, dä met jeder Sigg aanjezeisch weed. Wann extra Eijeschaffte afjefroocht wääde, kumme di schtatt däm Täx.',
	'semanticmaps-kml-title' => 'Dä Schtandatttittel för wad eruß küt.',
	'semanticmaps-kml-linkabsolute' => 'Sulle Lenks absoluud udder relatief sin?',
	'semanticmaps-kml-pagelinktext' => 'Ene Täx, dä för Lenks op di Sigg jebuch weed. $1 schteiht dobei för dä Sigg iere Tittel.',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'semanticmaps-forminput-remove' => 'Jê bibe',
	'semanticmaps-forminput-locations' => 'Cih',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'semanticmaps-unrecognizeddistance' => 'De Wäert $1 ass keng valabel Distanz.',
	'semanticmaps-kml-link' => 'KML-Fichier weisen',
	'semanticmaps-default-kml-pagelink' => 'Säit $1 weisen',
	'semanticmaps-altitude' => 'Héicht: $1',
	'semanticmaps_lookupcoordinates' => 'Koordinaten nokucken',
	'semanticmaps_enteraddresshere' => 'Adress hei aginn',
	'semanticmaps-updatemap' => 'Kaart aktualiséieren',
	'semanticmaps-forminput-remove' => 'Ewechhuelen',
	'semanticmaps-forminput-add' => 'Derbäisetzen',
	'semanticmaps-forminput-locations' => 'Plazen',
	'semanticmaps-kml-title' => 'De Standard-Titel fir Resultater',
	'semanticmaps-kml-linkabsolute' => 'Solle Linken absolut sinn oder net (d.h. relativ)',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'semanticmaps-desc' => 'Овозможува прегледување и уредување на координатни податоци складирани со додатокот Семантички МедијаВики ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps?uselang=mk повеќе информации...]).',
	'semanticmaps-unrecognizeddistance' => 'Вредноста $1 не претставува важечко растојание.',
	'semanticmaps-kml-link' => 'Преглед на KML-податотеката',
	'semanticmaps-default-kml-pagelink' => 'Преглед на статијата $1',
	'semanticmaps-latitude' => 'Геог. ширина: $1',
	'semanticmaps-longitude' => 'Геог. должина: $1',
	'semanticmaps-altitude' => 'Надм. вис: $1',
	'semanticmaps-loading-forminput' => 'Вчитувам карти од внесеното...',
	'semanticmaps_lookupcoordinates' => 'Дај координати',
	'semanticmaps_enteraddresshere' => 'Внесете адреса',
	'semanticmaps-updatemap' => 'Поднови карта',
	'semanticmaps-forminput-remove' => 'Отстрани',
	'semanticmaps-forminput-add' => 'Додај',
	'semanticmaps-forminput-locations' => 'Места',
	'semanticmaps-par-staticlocations' => 'Список на места за додавање во картатата заедно со побараните податоци. Како и со „display_points“, тука можете да додадете наслов, опис и икона за секое место, користејќи тилда (~) како одделувач.',
	'semanticmaps-par-forceshow' => 'Да ја прикажувам картата дури и ако нема места за приказ?',
	'semanticmaps-par-showtitle' => 'Дали да се прикажува насловот на инфопрозорецот на ознаката. Оневозможете го кога користите шаблон за форматирање на содржината на инфопрозорецот.',
	'semanticmaps-par-hidenamespace' => 'Дали да се прикажува називот на именскиот простор во инфопрозорецот за ознаката.',
	'semanticmaps-par-centre' => 'Средиштето на картата. Ако не е укажано, картата автоматски ќе го одбере средиштето кајшто оптимално ќе се прикажат сите одбележувачи на картата.',
	'semanticmaps-par-template' => 'Шаблон за форматирање на содржината на инфопрозорецот.',
	'semanticmaps-par-geocodecontrol' => 'Прикажи геокодни котроли.',
	'semanticmaps-kml-text' => 'Текстот на секоја страница. Се презапишува ако има дополнителни барани својства.',
	'semanticmaps-kml-title' => 'Стандарден наслов за резултатите',
	'semanticmaps-kml-linkabsolute' => 'Дали врските да бидат апсолутни',
	'semanticmaps-kml-pagelinktext' => 'Текстот на врските на страницата, каде $1 ќе се замени со насловот на страницата',
	'semanticmaps-shapes-improperformat' => 'Несоодветно форматирање на $1. Погледајте во документацијата како треба да се форматира.',
	'semanticmaps-shapes-missingshape' => 'Не пронајдов облици за $1. Погледајте во документацијата кои облици ви се на располагање.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'semanticmaps_enteraddresshere' => 'വിലാസം നൽകുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'semanticmaps-forminput-remove' => 'Buang',
	'semanticmaps-forminput-add' => 'Tambahkan',
	'semanticmaps-forminput-locations' => 'Lokasi',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'semanticmaps-kml-link' => 'Ara l-fajl KML',
	'semanticmaps-latitude' => 'Latitudni: $1',
	'semanticmaps-longitude' => 'Lonġitudini: $1',
	'semanticmaps-altitude' => 'Altitudni: $1',
	'semanticmaps_lookupcoordinates' => 'Fittex il-koordinati',
	'semanticmaps_enteraddresshere' => 'Daħħal l-indirizz hawnhekk',
	'semanticmaps-updatemap' => 'Aġġorna l-mappa',
	'semanticmaps-forminput-remove' => 'Neħħi',
	'semanticmaps-forminput-add' => 'Żid',
	'semanticmaps-forminput-locations' => 'Postijiet',
	'semanticmaps-par-forceshow' => "Uri l-mappa anke jekk m'hemm l-ebda post x'turi?",
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Event
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'semanticmaps-desc' => 'Tilbyr muligheten til å se på og endre koordinatdata lagret ved hjelp av Semantic MediaWiki-utvidelsen ([https://mapping.referata.com/wiki/Examples demo]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Verdien $1 er ikke en gyldig avstand.',
	'semanticmaps-kml-link' => 'Vis KML-filen',
	'semanticmaps-default-kml-pagelink' => 'Vis siden $1',
	'semanticmaps-latitude' => 'Breddegrad: $1',
	'semanticmaps-longitude' => 'Lengdegrad: $1',
	'semanticmaps-altitude' => 'Høyde over havet: $1',
	'semanticmaps-loading-forminput' => 'Laster inndata for kartskjema...',
	'semanticmaps_lookupcoordinates' => 'Sjekk koordinater',
	'semanticmaps_enteraddresshere' => 'Skriv inn adressen her',
	'semanticmaps-updatemap' => 'Oppdater kart',
	'semanticmaps-forminput-remove' => 'Fjern',
	'semanticmaps-forminput-add' => 'Legg til',
	'semanticmaps-forminput-locations' => 'Lokasjoner',
	'semanticmaps-par-staticlocations' => 'En lokasjonsliste til å legge inn i kartet sammen med data fra spørringen. Som med display_points, kan du legge inn en tittel, en beskrivelse og et ikon per lokasjon med tilde "~" som skilletegn.',
	'semanticmaps-par-forceshow' => 'Vil du vise kartet selv når det ikke er noen lokasjoner med?',
	'semanticmaps-par-showtitle' => 'Vise tittel i markørinfovinduet eller ikke. Deaktivering er ofte nyttig når en bruker en mal for å formatere innholdet i infovinduet.',
	'semanticmaps-par-centre' => 'Kartets sentrum. Hvis dette ikke er angitt, vil kartet automatisk velge det optimale senteret for å vise alle kartmarkørene.',
	'semanticmaps-par-template' => 'Mal som brukes for å formatere innholdet i infovinduet.',
	'semanticmaps-par-geocodecontrol' => 'Vis geokodingsstyringen',
	'semanticmaps-kml-text' => 'Teksten knyttes til hver side. Overstyrt av spørringer på ekstra egenskaper, om noen.',
	'semanticmaps-kml-title' => 'Standard resultatoverskrift',
	'semanticmaps-kml-linkabsolute' => 'Skal lenker være absolutte eller ikke (dvs. relative)',
	'semanticmaps-kml-pagelinktext' => 'Teksten som skal brukes for lenker til siden, der $1 erstattes av sidetittelen',
);

/** Dutch (Nederlands)
 * @author Jeroen De Dauw
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'semanticmaps-desc' => 'Biedt de mogelijkheid om locatiegegevens die opgeslagen zijn in Semantic MediaWiki te bewerken en te bekijken ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps meer informatie])',
	'semanticmaps-unrecognizeddistance' => 'De waarde "$1" is geen geldige afstand.',
	'semanticmaps-kml-link' => 'KML-bestand bekijken',
	'semanticmaps-default-kml-pagelink' => 'Pagina $1 bekijken',
	'semanticmaps-latitude' => 'Breedtegraad: $1',
	'semanticmaps-longitude' => 'Lengtegraad: $1',
	'semanticmaps-altitude' => 'Hoogte: $1',
	'semanticmaps-loading-forminput' => 'Bezig met het laden van de kaart formulierinvoer...',
	'semanticmaps_lookupcoordinates' => 'Coördinaten opzoeken',
	'semanticmaps_enteraddresshere' => 'Voer hier het adres in',
	'semanticmaps-updatemap' => 'Kaart bijwerken',
	'semanticmaps-forminput-remove' => 'Verwijderen',
	'semanticmaps-forminput-add' => 'Toevoegen',
	'semanticmaps-forminput-locations' => 'Locaties',
	'semanticmaps-par-staticlocations' => 'Een lijst met aan de kaart toe te voegen locaties samen met de opgevraagde gegevens. Zoals bij display_points, kunt u een naam, beschrijving en icoon per locatie toevoegen door de tilde ("~") als scheidingsteken te gebruiken.',
	'semanticmaps-par-forceshow' => 'De kaart zelfs weergeven als er geen weer te geven locaties zijn?',
	'semanticmaps-par-showtitle' => 'Een naam weergeven in het gegevensvenster van de markering of niet. Dit uitschakelen is vaak handig als er een sjabloon wordt gebruikt om de inhoud van het gegevensvenster vorm te geven.',
	'semanticmaps-par-hidenamespace' => 'De naamruimtenaam in het informatievenster van de marker weergeven',
	'semanticmaps-par-centre' => 'Het centrum van de kaart. Als deze waarde niet wordt opgegeven, wordt automatisch een keuze gemaakt voor een centrum op basis van alle markeringen op de kaart.',
	'semanticmaps-par-template' => 'Een te gebruiken sjabloon om de inhoud van het gegevensvenster op te maken.',
	'semanticmaps-par-geocodecontrol' => 'Besturingselement voor geocodering weergeven.',
	'semanticmaps-kml-text' => 'De tekst die gekoppeld is aan iedere pagina. Als er extra opgevraagde eigenschappen zijn, wordt deze tekst daardoor overschreven.',
	'semanticmaps-kml-title' => 'De standaard titel voor resultaten',
	'semanticmaps-kml-linkabsolute' => 'Moeten verwijzingen absoluut zijn (in tegenstelling tot relatief)',
	'semanticmaps-kml-pagelinktext' => 'De tekst om te gebruiken voor de verwijzingen naar de pagina, waarin $1 vervangen wordt door de paginatitel',
	'semanticmaps-shapes-improperformat' => 'Onjuiste opmaak van  $1. Raadpleeg de documentatie voor de juiste opmaak',
	'semanticmaps-shapes-missingshape' => 'Geen vormen gevonden voor $1. Raadpleeg de documentatie voor beschikbare vormen',
);

/** Norwegian Nynorsk (norsk (nynorsk)‎)
 * @author Harald Khan
 * @author Njardarlogar
 */
$messages['nn'] = array(
	'semanticmaps-kml-link' => 'Sjå KML-fila',
	'semanticmaps-default-kml-pagelink' => 'Sjå sida $1',
	'semanticmaps_lookupcoordinates' => 'Sjekk koordinatar',
	'semanticmaps_enteraddresshere' => 'Skriv inn adressa her',
	'semanticmaps-updatemap' => 'Oppdater kart',
	'semanticmaps-forminput-remove' => 'Fjerna',
	'semanticmaps-forminput-add' => 'Legg til',
	'semanticmaps-forminput-locations' => 'Stader',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'semanticmaps-desc' => "Permet de veire e modificar las donadas de coordenadas estocadas a travèrs l'extension Semantic MediaWiki. [https://www.mediawiki.org/wiki/Extension:Semantic_Maps Documentacion]. [https://mapping.referata.com/wiki/Examples Demo]", # Fuzzy
	'semanticmaps_lookupcoordinates' => 'Estimar las coordenadas',
	'semanticmaps_enteraddresshere' => 'Picatz aicí l’adreça',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Deejay1
 * @author Derbeth
 * @author Leinad
 * @author Odder
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'semanticmaps-desc' => 'Umożliwia przeglądanie oraz edytowanie współrzędnych zapisanych przez rozszerzenie Semantic MediaWiki ([https://mapping.referata.com/wiki/Examples dema]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Wartość $1 nie jest poprawną odległością.',
	'semanticmaps-kml-link' => 'Wyświetla plik KML',
	'semanticmaps-default-kml-pagelink' => 'Pokaż stronę $1',
	'semanticmaps-latitude' => 'Szerokość geograficzna: $1',
	'semanticmaps-longitude' => 'Długość geograficzna: $1',
	'semanticmaps-altitude' => 'Wysokość: $1',
	'semanticmaps-loading-forminput' => 'Ładowanie mapy formularza wprowadzania danych...',
	'semanticmaps_lookupcoordinates' => 'Wyszukaj współrzędne',
	'semanticmaps_enteraddresshere' => 'Podaj adres',
	'semanticmaps-updatemap' => 'Aktualizacja mapy',
	'semanticmaps-forminput-remove' => 'Usuń',
	'semanticmaps-forminput-add' => 'Dodaj',
	'semanticmaps-forminput-locations' => 'Miejsca',
	'semanticmaps-par-forceshow' => 'Wyświetlać mapę nawet wtedy, gdy nie ma miejsc do pokazania?',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'semanticmaps-desc' => "A dà la possibilità ëd vardé e modifiché ij dat ëd le coordinà memorisà con l'estension Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps për savèjne ëd pì...])",
	'semanticmaps-unrecognizeddistance' => "Ël valor $1 a l'é pa na distansa bon-a.",
	'semanticmaps-kml-link' => "Vëdde l'archivi KML",
	'semanticmaps-default-kml-pagelink' => 'Lese la pàgina $1',
	'semanticmaps-latitude' => 'Latitùdin: $1',
	'semanticmaps-longitude' => 'Longitùdin: $1',
	'semanticmaps-altitude' => 'Autitùdin: $1',
	'semanticmaps-loading-forminput' => 'Carié ël formolari për anserì la carta...',
	'semanticmaps_lookupcoordinates' => 'Serca coordinà',
	'semanticmaps_enteraddresshere' => 'Ansëriss adrëssa sì',
	'semanticmaps-updatemap' => 'Agiornament ëd la carta',
	'semanticmaps-forminput-remove' => 'Gava',
	'semanticmaps-forminput-add' => 'Gionta',
	'semanticmaps-forminput-locations' => 'Locassion',
	'semanticmaps-par-staticlocations' => 'Na lista ëd locassion da gionté a la carta ansema ai dat ciamà. Com con dispay_points, a peul gionté un tìtol, na descrission e na plancia për locassion an dovrand la tilde "~" com separator.',
	'semanticmaps-par-forceshow' => 'Mostré la carta ëdcò quand a-i son pa ëd locassion da mostré?',
	'semanticmaps-par-showtitle' => "Smon-e un tìtol ant la fnesta d'anformassion dël marcator opura nò. La disabilitassion ëd sòn a l'é soens ùtil quand as deuvra në stamp për formaté ël contnù dla fnesta d'anformassion.",
	'semanticmaps-par-hidenamespace' => "Mostré ël tìtol dlë spassi nominal ant la fnestra d'anformassion dël marcador.",
	'semanticmaps-par-centre' => "Ël sènter ëd la carta. Quand a l'é pa dàit, la carta a trovrà automaticament ël sènter otimal për smon-e tùit ij marcador an sla carta.",
	'semanticmaps-par-template' => "Në stamp da dovré deje a forma ai contnù dla fnesta d'anformassion.",
	'semanticmaps-par-geocodecontrol' => 'Smon-e ël contròl ëd geocodìfica.',
	'semanticmaps-kml-text' => "Ël test associà con minca pagina. Coatà da le propietà adissionaj ciamà s'a-i në j'é.",
	'semanticmaps-kml-title' => "Ël tìtol predefinì për j'arzultà",
	'semanticmaps-kml-linkabsolute' => 'Si le liure a devo esse assolùe o nò (visadì relativ)',
	'semanticmaps-kml-pagelinktext' => "Ël test da dovré për le liure a la pàgina, dont $1 a sarà rimpiassà da 'l tìtol ëd la pàgina",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'semanticmaps-forminput-remove' => 'غورځول',
	'semanticmaps-forminput-add' => 'ورګډول',
	'semanticmaps-forminput-locations' => 'استوګنځي',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Indech
 * @author Luckas Blade
 * @author Malafaya
 */
$messages['pt'] = array(
	'semanticmaps-desc' => 'Permite ver e editar dados de coordenadas, armazenados através da extensão MediaWiki Semântico ([https://mapping.referata.com/wiki/Examples demonstração]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'O valor $1 não é uma distância válida.',
	'semanticmaps-kml-link' => 'Ver o ficheiro KML',
	'semanticmaps-default-kml-pagelink' => 'Ver a página $1',
	'semanticmaps-latitude' => 'Latitude: $1',
	'semanticmaps-longitude' => 'Longitude: $1',
	'semanticmaps-altitude' => 'Altitude: $1',
	'semanticmaps-loading-forminput' => 'A carregar o formulário de entrada do mapa...',
	'semanticmaps_lookupcoordinates' => 'Pesquisar coordenadas',
	'semanticmaps_enteraddresshere' => 'Introduza um endereço aqui',
	'semanticmaps-updatemap' => 'Actualizar mapa',
	'semanticmaps-forminput-remove' => 'Remover',
	'semanticmaps-forminput-add' => 'Adicionar',
	'semanticmaps-forminput-locations' => 'Locais',
	'semanticmaps-par-staticlocations' => 'Uma lista de localizações para acrescentar ao mapa em conjunto com os dados consultados. Tal como nos pontos a apresentar ("display_points"), pode adicionar um título, descrição e ícone por localização, usando o til "~" como separador.',
	'semanticmaps-par-forceshow' => 'Mostrar o mapa mesmo quando não existem localizações para apresentar?',
	'semanticmaps-par-showtitle' => 'Mostrar, ou não, um título na janela informativa do marcador. É frequentemente desejável desactivar esta funcionalidade quando usar uma predefinição para formatar o conteúdo da janela informativa.',
	'semanticmaps-par-centre' => 'O centro do mapa. Quando este não for fornecido, o mapa escolherá automaticamente o centro óptimo para apresentar todos os marcadores do mapa.',
	'semanticmaps-par-template' => 'Uma predefinição que será usada para formatar o conteúdo da janela informativa.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Luckas Blade
 * @author 555
 */
$messages['pt-br'] = array(
	'semanticmaps-desc' => 'Permite ver e editar dados de coordenadas armazenados através da extensão Semantic MediaWiki. ([https://mapping.referata.com/wiki/Examples exemplos]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'O valor $1 não é uma distância válida.',
	'semanticmaps-kml-link' => 'Ver o arquivo KML',
	'semanticmaps-default-kml-pagelink' => 'Ver a página $1',
	'semanticmaps-latitude' => 'Latitude: $1',
	'semanticmaps-longitude' => 'Longitude: $1',
	'semanticmaps-altitude' => 'Altitude: $1',
	'semanticmaps-loading-forminput' => 'Abrindo formulário de entrada de dados no mapa...',
	'semanticmaps_lookupcoordinates' => 'Pesquisar coordenadas',
	'semanticmaps_enteraddresshere' => 'Insira aqui um endereço',
	'semanticmaps-updatemap' => 'Atualizar o mapa',
	'semanticmaps-forminput-remove' => 'Remover',
	'semanticmaps-forminput-add' => 'Adicionar',
	'semanticmaps-forminput-locations' => 'Locais',
	'semanticmaps-par-staticlocations' => 'Uma lista de localizações para adicionar ao mapa junto aos dados consultados. Assim como nos pontos a serem exibidos ("display_points"), você pode adicionar um título, descrição e ícone por localização, usando o til ("~") como separador.',
	'semanticmaps-par-forceshow' => 'Mostrar o mapa mesmo quando não existirem localizações para exibir?',
	'semanticmaps-par-showtitle' => 'Mostrar, ou não, um título na janela informativa do marcador. É frequentemente desejável desativar este recurso quando estiver usando uma predefinição para formatar o conteúdo da janela informativa.',
	'semanticmaps-par-centre' => 'O centro do mapa. Quando este não for definido, o mapa escolherá automaticamente o centro ideal para apresentar todos os marcadores do mapa.',
	'semanticmaps-par-template' => 'Uma predefinição que será usada para formatar o conteúdo da janela informativa.',
	'semanticmaps-par-geocodecontrol' => 'Exibir o controle de geocodificação.',
	'semanticmaps-kml-text' => 'O texto associado a cada página. Será substituído quando propriedades adicionais consultadas existirem.',
	'semanticmaps-kml-title' => 'O título padrão para os resultados',
	'semanticmaps-kml-linkabsolute' => 'Se os links deverão ser absolutos ou relativos',
	'semanticmaps-kml-pagelinktext' => 'O texto a ser usado nos links para a página, onde  $1 será substituído pelo título da página',
);

/** Romanian (română)
 * @author Firilacroco
 * @author Minisarm
 */
$messages['ro'] = array(
	'semanticmaps-desc' => 'Permite vizualizarea și modificarea datelor despre coordonate stocate cu extensia Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps mai multe informații...]).',
	'semanticmaps_enteraddresshere' => 'Introduceți adresa aici',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'semanticmaps-desc' => "Dèje l'abbilità a fà vedè e cangià le coordinate reggistrate cu l'estenzione Semandiche de MediaUicchi ([https://mapping.referata.com/wiki/Examples demo]).", # Fuzzy
	'semanticmaps-default-kml-pagelink' => "Vide 'a pàgene $1",
	'semanticmaps_lookupcoordinates' => 'Ingroce le coordinate',
	'semanticmaps_enteraddresshere' => "Scaffe l'indirizze aqquà",
	'semanticmaps-updatemap' => "Aggiorne 'a mappe",
	'semanticmaps-forminput-remove' => 'Live',
	'semanticmaps-forminput-add' => 'Aggiunge',
);

/** Russian (русский)
 * @author Eugene Mednikov
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'semanticmaps-desc' => 'Обеспечивает возможность просмотра и редактирования координатных данных, хранящихся в семантическом расширении MediaWiki ([https://mapping.referata.com/wiki/Examples примеры]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Значение $1 не является допустимым расстоянием.',
	'semanticmaps-kml-link' => 'Просмотреть файл KML',
	'semanticmaps-default-kml-pagelink' => 'Просмотреть страницу $1',
	'semanticmaps-loading-forminput' => 'Загрузка карты…',
	'semanticmaps_lookupcoordinates' => 'Найти координаты',
	'semanticmaps_enteraddresshere' => 'Введите адрес',
	'semanticmaps-updatemap' => 'Обновить карту',
	'semanticmaps-forminput-remove' => 'Удалить',
	'semanticmaps-forminput-add' => 'Добавить',
	'semanticmaps-forminput-locations' => 'Места',
	'semanticmaps-par-staticlocations' => 'Список мест для добавления на карту вместе с запрашиваемыми данными. Например, к display_points можно добавить название, описание и значок, используя тильду ~ в качестве разделителя.',
	'semanticmaps-par-forceshow' => 'Показывать карту даже тогда, когда нет мест для отображения?',
	'semanticmaps-par-template' => 'Шаблон для форматирования содержимого окна информация.',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'semanticmaps-forminput-remove' => 'ඉවත් කරන්න',
	'semanticmaps-forminput-add' => 'එක් කරන්න',
	'semanticmaps-forminput-locations' => 'ස්ථාන',
);

/** Slovak (slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'semanticmaps-desc' => 'Poskytuje schopnosť zobrazovať a upravovať údaje súradníc uložené prostredníctvom rozšírenia Semantic MediaWiki ([https://mapping.referata.com/wiki/Examples demo]).', # Fuzzy
	'semanticmaps_lookupcoordinates' => 'Vyhľadať súradnice',
	'semanticmaps_enteraddresshere' => 'Sem zadajte emailovú adresu',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 * @author Lesko987
 */
$messages['sl'] = array(
	'semanticmaps-desc' => 'Omogoča ogled in urejanje podatkov o lokaciji, shranjenih z razširitvijo Semantic MediaWiki ([https://www.semantic-mediawiki.org/wiki/Semantic_Maps več informacij ...]).',
	'semanticmaps-unrecognizeddistance' => 'Vrednost $1 ni pravilna razdalja.',
	'semanticmaps-kml-link' => 'Ogled datoteke KML',
	'semanticmaps-default-kml-pagelink' => 'Poglej stran $1',
	'semanticmaps-latitude' => 'Zemljepisna širina: $1',
	'semanticmaps-longitude' => 'Zemljepisna dolžina: $1',
	'semanticmaps-altitude' => 'Nadmorska višina: $1',
	'semanticmaps-loading-forminput' => 'Nalaganje zemljevida iz vira...',
	'semanticmaps_lookupcoordinates' => 'Poišči koordinate',
	'semanticmaps_enteraddresshere' => 'Tukaj vnesite naslov',
	'semanticmaps-updatemap' => 'Osvežite zemljevid',
	'semanticmaps-forminput-remove' => 'Odstrani',
	'semanticmaps-forminput-add' => 'Dodaj',
	'semanticmaps-forminput-locations' => 'Lokacije',
	'semanticmaps-par-staticlocations' => 'Seznam lokacij za dodajanje na zemljevid skupaj z rezultati poizvedb. Tako kot z display_points, lahko dodate naslov, opis in ikono za vsako lokacijo z uporabo "~" kot ločilo.',
	'semanticmaps-par-forceshow' => 'Prikaži zemljevid tudi če ni lokacij za prikaz?',
	'semanticmaps-par-showtitle' => 'Prikaži naslov v oknu ali ne. Onemogočanje tega je pogosto uporabno, če uporabljate predloge za oblikovanje vsebine info okno.',
	'semanticmaps-par-hidenamespace' => 'Ali naj prikaže naslov imenskega prostora v označevalnem informacijskem oknu.',
	'semanticmaps-par-centre' => 'Sredini zemljevida. Če ne podana, bo zemljevid samodejno izbral optimalno lokacijo za prikaz vseh oznak na zemljevidu.',
	'semanticmaps-par-template' => 'Predloga za oblikovanje vsebine info okna.',
	'semanticmaps-par-geocodecontrol' => 'Prikaži nadzor geokodiranja.',
	'semanticmaps-kml-text' => 'Besedilo, povezano z vsako stranjo. Preglašeno z dodatnimi možnostmi poizvedbe, če obstajajo.',
	'semanticmaps-kml-title' => 'Privzeti naslov za rezultate',
	'semanticmaps-kml-linkabsolute' => 'Naj bodo povezave absolutne ali ne (tj. relativne)',
	'semanticmaps-kml-pagelinktext' => 'Besedilo za povezave do strani, v katerih bo $1 zamenjan z naslovom strani',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'semanticmaps-unrecognizeddistance' => 'Вредност $1 није исправно растојање.',
	'semanticmaps-kml' => 'KML',
	'semanticmaps_enteraddresshere' => 'Унеси адресу овде',
);

/** Serbian (Latin script) (srpski (latinica)‎)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'semanticmaps-unrecognizeddistance' => 'Vrednost $1 nije ispravno rastojanje.',
	'semanticmaps-kml' => 'KML',
	'semanticmaps_enteraddresshere' => 'Unesi adresu ovde',
);

/** Swedish (svenska)
 * @author Boivie
 * @author Martinwiss
 * @author Najami
 * @author Per
 * @author Rotsee
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'semanticmaps-desc' => 'Ger möjlighet att se och redigera koordinatdata som sparats med Semantic MediaWiki-utvidgningen ([https://mapping.referata.com/wiki/Examples Demo]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Värdet $1 är inte ett giltigt avstånd.',
	'semanticmaps-kml-link' => 'Visa KML-filen',
	'semanticmaps-default-kml-pagelink' => 'Visa sida $1',
	'semanticmaps-latitude' => 'Breddgrad: $1',
	'semanticmaps-longitude' => 'Längdgrad: $1',
	'semanticmaps-altitude' => 'Höjd över havet: $1',
	'semanticmaps-loading-forminput' => 'Läser in karta från indata...',
	'semanticmaps_lookupcoordinates' => 'Kolla upp koordinater',
	'semanticmaps_enteraddresshere' => 'Skriv in adress här',
	'semanticmaps-updatemap' => 'Uppdatera karta',
	'semanticmaps-forminput-remove' => 'Ta bort',
	'semanticmaps-forminput-add' => 'Lägg till',
	'semanticmaps-forminput-locations' => 'Platser',
	'semanticmaps-par-staticlocations' => 'En lista med platser som man kan placera på kartan tillsammans med efterfrågad data. Precis som för display_points, så kan du lägga till en titel, en beskrivning och en ikon för varje plats med hjälp av tilde "~" som avgränsare.',
	'semanticmaps-par-forceshow' => 'Visa kartan även om det inte finns några platser att visa?',
	'semanticmaps-par-showtitle' => 'Visa en titel i markörens informationsruta eller inte. Det är ofta lämpligt att inte använda denna funktion när en mall används för informationsrutans innehåll.',
	'semanticmaps-par-hidenamespace' => 'Visa namnrymdens titel i markörens informationsruta eller inte.',
	'semanticmaps-par-centre' => 'Kartans mitt. Om inte angiven så kommer kartan automatiskt att hitta markörernas mittpunkt.',
	'semanticmaps-par-template' => 'En mall som ska användas för informationsrutorna.',
	'semanticmaps-par-geocodecontrol' => 'Visa formulär för geokodning.',
	'semanticmaps-kml-text' => 'Texten som hör ihop med varje sida. Om det finns efterfrågade egenskaper så tar de överhand.',
	'semanticmaps-kml-title' => 'Förvald titel för resultaten',
	'semanticmaps-kml-linkabsolute' => 'Ska länkar vara absoluta eller relativa',
	'semanticmaps-kml-pagelinktext' => 'Texten som ska användas för länkar till sidan, där $1 kommer att bytas ut med sidtiteln',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'semanticmaps-kml-link' => 'Tazama faili la KML', # Fuzzy
	'semanticmaps-default-kml-pagelink' => 'Tazama ukurasa $1', # Fuzzy
	'semanticmaps-loading-forminput' => 'Fomu ya kuingiza ramani inapakiwa...', # Fuzzy
	'semanticmaps_enteraddresshere' => 'Ingiza anwani hapa',
	'semanticmaps-updatemap' => 'Sasisha ramani', # Fuzzy
	'semanticmaps-forminput-remove' => 'Ondoa',
	'semanticmaps-forminput-add' => 'Ongeza',
	'semanticmaps-forminput-locations' => 'Mahali',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'semanticmaps_enteraddresshere' => 'இங்கு முகவரியை உள்ளிடவும்',
	'semanticmaps-updatemap' => 'வரைபடத்தை புதுப்பி',
	'semanticmaps-forminput-remove' => 'நீக்குக',
	'semanticmaps-forminput-add' => 'சேர்',
	'semanticmaps-forminput-locations' => 'இடங்கள்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'semanticmaps-latitude' => 'అక్షాంశం: $1',
	'semanticmaps-longitude' => 'రేఖాంశం: $1',
	'semanticmaps-altitude' => 'సముద్రమట్టం: $1',
	'semanticmaps_enteraddresshere' => 'చిరునామాని ఇక్కడ ఇవ్వండి',
	'semanticmaps-forminput-add' => 'చేర్చు',
);

/** Tetum (tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'semanticmaps-forminput-remove' => 'Hasai',
	'semanticmaps-forminput-add' => 'Tau tan',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'semanticmaps-desc' => 'Nagbibigay ng kakayahang matingnan at baguhin ang dato ng tugmaang pampook na nakaimbak sa pamamagitan ng dugtong ng Semantikong MediaWiki ([https://mapping.referata.com/wiki/Examples pagpapamalas]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Hindi isang tanggap na layo ang halagang $1.',
	'semanticmaps-kml-link' => 'Tingnan ang talaksang KML',
	'semanticmaps-kml' => 'KML',
	'semanticmaps-default-kml-pagelink' => 'Tingnan ang pahinang $1',
	'semanticmaps-latitude' => 'Latitud: $1',
	'semanticmaps-longitude' => 'Longhitud: $1',
	'semanticmaps-altitude' => 'Altitud: $1',
	'semanticmaps-loading-forminput' => 'Ikinakarga ang pagpapasok ng anyo ng mapa...',
	'semanticmaps_lookupcoordinates' => "Hanapin ang mga tugmaang-pampook (''coordinate'')",
	'semanticmaps_enteraddresshere' => 'Ipasok ang adres dito',
	'semanticmaps-updatemap' => 'Isapanahon ang mapa',
	'semanticmaps-forminput-remove' => 'Tanggalin',
	'semanticmaps-forminput-add' => 'Idagdag',
	'semanticmaps-forminput-locations' => 'Mga kinalalagyan',
	'semanticmaps-par-staticlocations' => 'Isang listahan ng mga lokasyon na idaragdag sa mapa na kasama ng inusisang dato. Katulad ng sa tuldok_ng_pagpapakita, makapagdaragdag ka ng isang pamagat, paglalarawan at kinatawang larawan sa bawat lokasyon na ginagamit ang tilde "~" bilang panghiwalay.',
	'semanticmaps-par-forceshow' => 'Ipakita ang mapa kahit na walang mga lokasyon na ipapakita?',
	'semanticmaps-par-showtitle' => 'Magpapakita o hindi magpapakita ng isang pamagat sa loob ng pangmarkang bintana ng impormasyon. Ang hindi pagpapagana nito ay kadasalang mas kapakipakinabang kapag gumagamit ng isang suleras upang maiayos ang nilalaman ng bintana ng kabatiran.',
	'semanticmaps-par-hidenamespace' => 'Ipakita o huwag ipakita ang pamagat ng puwang na pampangalan sa loob ng pangmarkang bintana ng impormasyon.',
	'semanticmaps-par-centre' => 'Ang gitna ng mapa. Kapag hindi ibinigay, kusang pipiliin ng mapa ang pinakamabuting gitna na pagpapakitaan ng lahat ng mga pangmarka',
	'semanticmaps-par-template' => 'Isang suleras na gagamit upang iayos ang mga nilalaman ng bintana ng kabatiran.',
	'semanticmaps-par-geocodecontrol' => 'Ipakita ang pantaban ng pagkokodigong pangheograpiya.',
	'semanticmaps-kml-text' => 'Umuugnay ang teksto sa bawat isang pahina. Pinangingibabawan ng karagdagang sinisiyasat na mga katangiang angkin kung mayroon.',
	'semanticmaps-kml-title' => 'Ang likas na nakatakdang pamagat para sa mga resulta',
	'semanticmaps-kml-linkabsolute' => 'Kung ang mga kawing ay magiging lubos o hindi (iyong nauukol)',
	'semanticmaps-kml-pagelinktext' => 'Ang tekstong gagamitin para sa mga kawing sa pahina, kung saan ang $1 ay mapapalitan ng pamagat ng pahina',
);

/** Turkish (Türkçe)
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'semanticmaps_lookupcoordinates' => 'Koordinat ara',
	'semanticmaps_enteraddresshere' => 'Adresi buraya girin',
	'semanticmaps-forminput-add' => 'Ekle',
);

/** Urdu (اردو)
 * @author පසිඳු කාවින්ද
 */
$messages['ur'] = array(
	'semanticmaps-forminput-remove' => 'حذف کریں',
	'semanticmaps-forminput-add' => 'شامل کریں',
	'semanticmaps-forminput-locations' => 'مقامات',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'semanticmaps-desc' => 'Cung cấp khả năng xem và sửa đổi dữ liệu tọa độ được lưu bởi phần mở rộng MediaWiki Ngữ nghĩa ([https://mapping.referata.com/wiki/Examples?uselang=vi xem thử]).', # Fuzzy
	'semanticmaps-unrecognizeddistance' => 'Giá trị $1 không phải là tầm hợp lệ.',
	'semanticmaps-kml-link' => 'Xem tập tin KML',
	'semanticmaps-default-kml-pagelink' => 'Xem trang $1',
	'semanticmaps-loading-forminput' => 'Đang tải dữ liệu biểu mẫu bản đồ…',
	'semanticmaps_lookupcoordinates' => 'Tra tọa độ',
	'semanticmaps_enteraddresshere' => 'Nhập địa chỉ vào đây',
	'semanticmaps-updatemap' => 'Cập nhật bản đồ',
	'semanticmaps-forminput-remove' => 'Dời',
	'semanticmaps-forminput-add' => 'Thêm',
	'semanticmaps-forminput-locations' => 'Các vị trí',
	'semanticmaps-par-staticlocations' => 'Danh sách các vị trí để thêm vào bản đồ cùng với dữ liệu được truy vấn. Giống như với display_points, bạn có thể đặt tên, miêu tả, và hình tượng cho mỗi đánh dấu bằng cách phân tách dùng dấu ngã (~).',
	'semanticmaps-par-forceshow' => 'Hiển thị bản đồ ngay cả khi không có vị trí nào để hiển thị?',
	'semanticmaps-par-showtitle' => 'Tên tùy chọn của cửa sổ thông tin đánh dấu. Có thể để trống để định dạng nội dung cửa sổ thông tin dùng bản mẫu.',
	'semanticmaps-par-centre' => 'Trung tâm của bản đồ. Nếu không có, bản đồ sẽ tự động chọn trung tâm tối ưu bao gồm tất cả các dấu trên bản đồ.',
	'semanticmaps-par-template' => 'Bản đồ dùng để định dạng nội dung của cửa sổ thông tin.',
	'semanticmaps-par-geocodecontrol' => 'Hiện điều khiển mã hóa địa lý.',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'semanticmaps_lookupcoordinates' => 'Tuvön koordinatis',
);

/** Yiddish (ייִדיש)
 * @author පසිඳු කාවින්ද
 */
$messages['yi'] = array(
	'semanticmaps-forminput-remove' => 'אַראָפּנעמען',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Gzdavidwong
 * @author Linforest
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'semanticmaps-desc' => '提供对采用Semantic MediaWiki扩展所存储坐标数据的查看和编辑能力（[https://mapping.referata.com/wiki/Examples 演示]）。', # Fuzzy
	'semanticmaps-unrecognizeddistance' => '取值$1不是有效的距离。',
	'semanticmaps-kml-link' => '查看KML文件',
	'semanticmaps-default-kml-pagelink' => '检视页面 $1',
	'semanticmaps-latitude' => '纬度：$1',
	'semanticmaps-longitude' => '经度：$1',
	'semanticmaps-altitude' => '绝对海拔高度：$1',
	'semanticmaps-loading-forminput' => '加载地图表单输入……',
	'semanticmaps_lookupcoordinates' => '查找坐标',
	'semanticmaps_enteraddresshere' => '在此处输入地址',
	'semanticmaps-updatemap' => '更新地图',
	'semanticmaps-forminput-remove' => '删除',
	'semanticmaps-forminput-add' => '添加',
	'semanticmaps-forminput-locations' => '位置',
	'semanticmaps-par-staticlocations' => '要与所查询数据一起添加到地图的一系列位置。就像display_points那样，可以采用波浪号"~"作为分隔符，为每个位置添加标题、描述及图标。',
	'semanticmaps-par-forceshow' => '甚至在没有要显示的位置的情况下也显示地图吗？',
	'semanticmaps-par-showtitle' => '是否在标记信息窗口之中显示标题。当采用模板对信息窗口内容进行格式编排的时候，关闭此项往往会有所帮助。',
	'semanticmaps-par-centre' => '地图的中心。当未加提供的时候，地图会自动挑选最佳的中心，从而在地图上显示所有的标记。',
	'semanticmaps-par-template' => '用来对信息窗口内容进行格式编排的模板。',
	'semanticmaps-par-geocodecontrol' => '显示地理编码控件。',
	'semanticmaps-kml-text' => '与每个页面相关联的文本。会被额外的查询属性（如果有的话）所覆盖。',
	'semanticmaps-kml-title' => '结果的默认标题',
	'semanticmaps-kml-linkabsolute' => '链接究竟应当是绝对地址还是相对地址',
	'semanticmaps-kml-pagelinktext' => '用于那些指向该页面的链接的文本；其中，页面标题将取代$1',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Gzdavidwong
 * @author Justincheng12345
 * @author Mark85296341
 * @author Oapbtommy
 * @author Sheepy
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'semanticmaps-desc' => '提供對採用Semantic MediaWiki擴展所存儲坐標數據的查看和編輯能力（[https://www.semantic-mediawiki.org/wiki/Semantic_Maps 更多資訊]）。',
	'semanticmaps-unrecognizeddistance' => '取值$1不是有效的距離。',
	'semanticmaps-kml-link' => '查看KML文件',
	'semanticmaps-default-kml-pagelink' => '檢視頁面 $1',
	'semanticmaps-latitude' => '緯度：$1',
	'semanticmaps-longitude' => '經度：$1',
	'semanticmaps-altitude' => '絕對海拔高度：$1',
	'semanticmaps-loading-forminput' => '加載地圖表單輸入……',
	'semanticmaps_lookupcoordinates' => '尋找座標',
	'semanticmaps_enteraddresshere' => '在此處輸入地址',
	'semanticmaps-updatemap' => '更新地圖',
	'semanticmaps-forminput-remove' => '刪除',
	'semanticmaps-forminput-add' => '新增',
	'semanticmaps-forminput-locations' => '位置',
	'semanticmaps-par-staticlocations' => '要與所查詢數據一起添加到地圖的一系列位置。就像display_points那樣，可以採用波浪號"~"作為分隔符，為每個位置添加標題、描述及圖標。',
	'semanticmaps-par-forceshow' => '甚至在沒有要顯示的位置的情況下也顯示地圖嗎？',
	'semanticmaps-par-showtitle' => '是否在標記信息窗口之中顯示標題。當採用模板對信息窗口內容進行格式編排的時候，關閉此項往往會有所幫助。',
	'semanticmaps-par-centre' => '地圖的中心。當未加提供的時候，地圖會自動挑選最佳的中心，從而在地圖上顯示所有的標記。',
	'semanticmaps-par-template' => '用來對信息窗口內容進行格式編排的模板。',
	'semanticmaps-par-geocodecontrol' => '顯示地理編碼控件。',
	'semanticmaps-kml-text' => '與每個頁面相關聯的文本。會被額外的查詢屬性（如果有的話）所覆蓋。',
	'semanticmaps-kml-title' => '結果的默認標題',
	'semanticmaps-kml-linkabsolute' => '鏈接究竟應當是絕對地址還是相對地址',
	'semanticmaps-kml-pagelinktext' => '用於那些指向該頁面的鏈接的文本；其中，頁面標題將取代$1',
);
