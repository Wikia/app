<?php
/**
 * Internationalisation file for GeoData extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Max Semenik
 */
$messages['en'] = array(
	'geodata-desc' => 'Adds geographical coordinates storage and retrieval functionality',
	'geodata-bad-input' => 'Invalid arguments have been passed to the <nowiki>{{#coordinates:}}</nowiki> function',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: invalid latitude',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: invalid longitude',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: unrecognised type "$1"',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: unrecognised globe "$1"',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: invalid region code format',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: cannot have more than one primary tag per page',
	'geodata-limit-exceeded' => 'The limit of $1 <nowiki>{{#coordinates:}}</nowiki> {{PLURAL:$1|tag|tags}} per page has been exceeded',
	'geodata-broken-tags-category' => 'Pages with malformed coordinate tags',
	'geodata-unknown-type-category' => 'Pages with unknown type of coordinates',
	'geodata-unknown-globe-category' => 'Pages with unknown globe value',
	'geodata-unknown-region-category' => 'Pages with invalid region value',
	'geodata-primary-coordinate' => 'primary',
);

/** Message documentation (Message documentation)
 * @author Max Semenik
 * @author SPQRobin
 */
$messages['qqq'] = array(
	'geodata-desc' => '{{desc}}',
	'geodata-bad-globe' => 'Terrestrial body on which the coordinate resides. By default, Earth is assumed. Other globes include earth, mercury, venus, moon, mars, ...',
	'geodata-limit-exceeded' => '$1 is a number',
	'geodata-broken-tags-category' => 'Name of the tracking category',
	'geodata-unknown-type-category' => 'Name of the tracking category',
	'geodata-unknown-globe-category' => 'Name of the tracking category',
	'geodata-unknown-region-category' => 'Name of the tracking category',
	'geodata-primary-coordinate' => "Localised name of parameter that makes <nowiki>{{#coordinates:}}</nowiki> tag primary (i.e. containing the primary coordinates of the page's subject)",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'geodata-desc' => 'Дадае функцыянальнасьць захаваньня і атрыманьня геаграфічных каардынатаў.',
	'geodata-bad-input' => 'У функцыю <nowiki>{{#coordinates:}}</nowiki> быў перададзены няслушны аргумэнт',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: няслушная шырата',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: няслушная даўгата',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: няслушны фармат коду рэгіёну',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: нельга мець больш за адну першасную метку на старонцы',
	'geodata-limit-exceeded' => 'Было перавышана абмежаваньне ў $1 {{PLURAL:$1|выклік|выклікі|выклікаў}} <nowiki>{{#coordinates:}}</nowiki> на старонку',
	'geodata-broken-tags-category' => 'Старонкі зь няслушнымі каардынатнымі меткамі',
	'geodata-primary-coordinate' => 'першасная',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'geodata-desc' => 'Ergänzt Funktionen zum Speichern und Abrufen geografischer Koordinaten',
	'geodata-bad-input' => 'Es wurden ungültige Argumente an die Funktion <code><nowiki>{{#coordinates:}}</nowiki></code> übergeben.',
	'geodata-bad-latitude' => '<code><nowiki>{{#coordinates:}}</nowiki></code>: ungültige Längenangabe',
	'geodata-bad-longitude' => '<code><nowiki>{{#coordinates:}}</nowiki></code>: ungültige Breitenangabe',
	'geodata-bad-type' => '<code><nowiki>{{#coordinates:}}</nowiki></code>: unbekannter Koordinatentyp „$1“',
	'geodata-bad-globe' => '<code><nowiki>{{#coordinates:}}</nowiki></code>: unbekannter Globus „$1“',
	'geodata-bad-region' => '<code><nowiki>{{#coordinates:}}</nowiki></code>: ungültiges Regionscodeformat',
	'geodata-multiple-primary' => '<code><nowiki>{{#coordinates:}}</nowiki></code>: Es kann nicht mehr als eine primäre Auszeichnung angegeben werden.',
	'geodata-limit-exceeded' => 'Die Begrenzung zur Funktion <code><nowiki>{{#coordinates:}}</nowiki></code> von {{PLURAL:$1|einer Auszeichnung|$1 Auszeichnungen}} je Seite, wurde überschritten.',
	'geodata-broken-tags-category' => 'Seiten mit fehlerhaften Auszeichnungen zu Koordinaten',
	'geodata-unknown-type-category' => 'Seiten mit unbekanntem Koordinatentyp',
	'geodata-unknown-globe-category' => 'Seiten mit unbekanntem Codewert für den Globus',
	'geodata-unknown-region-category' => 'Seiten mit unbekanntem Codewert für die Region',
	'geodata-primary-coordinate' => 'primäre',
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'geodata-desc' => "Ajoute la fonctionnalité de stockage et d'extraction des coordonnées géographiques.",
	'geodata-bad-input' => 'Des arguments non valides ont été transmis à la focntion <nowiki>{{#coordinates:}}</nowiki>',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: latitude invalide',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: longitude invalide',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: type "$1" non reconnu',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: globe "$1" non reconnu',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: format du code de région invalide',
	'geodata-multiple-primary' => "<nowiki>{{#coordinates:}}</nowiki>: impossible d'avoir plus d'une balise primaire par page",
	'geodata-limit-exceeded' => 'La limite de $1 {{PLURAL:$1|balise|balises}} <nowiki>{{#coordinates:}}</nowiki> par page a été dépassée',
	'geodata-broken-tags-category' => 'Pages avec des balises de coordonnées mal formées',
	'geodata-unknown-type-category' => 'Pages avec un type de coordonnées inconnu',
	'geodata-unknown-globe-category' => 'Pages avec une valeur de globe inconnue',
	'geodata-unknown-region-category' => 'Pages avec une valeur de région invalide',
	'geodata-primary-coordinate' => 'primaire',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'geodata-desc' => 'Engade unha funcionalidade de almacenamento e de extracción de coordenadas xeográficas.',
	'geodata-bad-input' => 'Pasáronselle argumentos incorrectos á función <nowiki>{{#coordinates:}}</nowiki>',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: Latitude incorrecta',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: Lonxitude incorrecta',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: Non se recoñece o tipo "$1"',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: Non se recoñece o globo "$1"',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: Formato do código de rexión incorrecto',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: Non pode haber máis dunha etiqueta primaria por páxina',
	'geodata-limit-exceeded' => 'Superouse o límite de $1 {{PLURAL:$1|etiqueta|etiquetas}} <nowiki>{{#coordinates:}}</nowiki> por páxina',
	'geodata-broken-tags-category' => 'Páxinas con etiquetas de coordenadas con formato incorrecto',
	'geodata-unknown-type-category' => 'Páxinas con coordenadas descoñecidas',
	'geodata-unknown-globe-category' => 'Páxinas con valores descoñecidos',
	'geodata-unknown-region-category' => 'Páxinas con valores de rexión incorrectos',
	'geodata-primary-coordinate' => 'primaria',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'geodata-desc' => 'Přidawa funkcije za składowanje a wotwołowanje geografiskich koordinatow.',
	'geodata-bad-input' => 'Njepłaćiwe argumenty su so funkciji <nowiki>{{#coordinates:}}</nowiki> přepodali',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: njepłaćiwa šěrina',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: njepłaćiwa dołhosć',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: Njespóznaty typ "$1"',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: Njespóznaty globus "$1"',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: njepłaćiwy format regionalneho koda',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: njemóže wjace hač jednu primarnu marku na stronu měć',
	'geodata-limit-exceeded' => 'Limit $1 <nowiki>{{#coordinates:}}</nowiki> {{PLURAL:$1|marki|markow|markow|markow}} na stronu je so překročił',
	'geodata-broken-tags-category' => 'Strony z deformowanymi koordinatowymi markami',
	'geodata-unknown-type-category' => 'Strony z njeznatym typom koordinatow',
	'geodata-unknown-globe-category' => 'Strony z njeznatej globusowej hódnotu',
	'geodata-unknown-region-category' => 'Strony z njepłaćiwej regionowej hódnotu',
	'geodata-primary-coordinate' => 'primarne',
);

/** Hungarian (Magyar)
 * @author Dj
 */
$messages['hu'] = array(
	'geodata-desc' => 'Földrajzi koordináták tárolásának és visszakeresésének lehetősége',
	'geodata-bad-input' => 'Érvénytelen argumentumok átadva a <nowiki>{{#coordinates:}}</nowiki> függvénynek',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: érvénytelen szélesség',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: érvénytelen hosszúság',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: ismeretlen típus "$1"',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: érvénytelen régiókód formátum',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: nem lehet egynél több elsődleges címke oldalanként',
	'geodata-limit-exceeded' => 'Meghaladta a laponként megengedett $1 <nowiki>{{#coordinates:}}</nowiki> {{PLURAL:$1|címkét}}.',
	'geodata-broken-tags-category' => 'Hibás koordináta címkékkel rendelkező oldalak',
	'geodata-unknown-type-category' => 'Ismeretlen típusú koordinátákat tartalmazó oldalak',
	'geodata-unknown-region-category' => 'Érvénytelen régió értéket tartalmazó oldalak',
	'geodata-primary-coordinate' => 'elsődleges',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'geodata-desc' => 'Adde functionalitate pro immagazinage e recuperation de coordinatas geographic.',
	'geodata-bad-input' => 'Parametros invalide ha essite passate al function <nowiki>{{#coordinates:}}</nowiki>',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: latitude invalide',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: longitude invalide',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: typo "$1" non recognoscite',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: globo "$1" non recognoscite',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: formato de codice de region invalide',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: non pote haber plus de un etiquetta primari per pagina',
	'geodata-limit-exceeded' => 'Le limite de $1 <nowiki>{{#coordinates:}}</nowiki> {{PLURAL:$1|etiquetta|etiquettas}} per pagina ha essite excedite',
	'geodata-broken-tags-category' => 'Paginas con etiquettas mal formate de coordinatas',
	'geodata-unknown-type-category' => 'Paginas con typo incognite de coordinatas',
	'geodata-unknown-globe-category' => 'Paginas con valor de globo incognite',
	'geodata-unknown-region-category' => 'Paginas con valor de region incognite',
	'geodata-primary-coordinate' => 'primari',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'geodata-broken-tags-category' => 'Säite mat Koordinaten, wou e Feeler an de Koordinaten ass',
	'geodata-unknown-type-category' => 'Säite mat engem onbekannten Typ vu Koordinaten',
	'geodata-unknown-globe-category' => 'Säite mat engem onbekannte Wäert fir de Globus',
	'geodata-unknown-region-category' => "Säite mat engem onbekannte Wäert fir d'Regioun",
	'geodata-primary-coordinate' => 'primaire',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'geodata-desc' => 'Додава можност за складирање и повикување на географски координати',
	'geodata-bad-input' => 'На функцијата <nowiki>{{#coordinates:}}</nowiki> ѝ се дадени неважечки аргументи',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>: неважечка геог. ширина',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>: неважечка геог. должина',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: непрепознаен тип „$1“',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: непрепознаен глобус „$1“',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: неважечки коден формат за регион',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: не може да има повеќе од една главна ознака по страница',
	'geodata-limit-exceeded' => 'Ја надминавте границата од $1 {{PLURAL:$1|ознака|ознаки}} <nowiki>{{#coordinates:}}</nowiki> по страница',
	'geodata-broken-tags-category' => 'Страници со неправилно напишани координатни ознаки',
	'geodata-unknown-type-category' => 'Страници со непознат тип на координати',
	'geodata-unknown-globe-category' => 'Страници со непозната вредност за глобус',
	'geodata-unknown-region-category' => 'Страници со непозната вредност за регион',
	'geodata-primary-coordinate' => 'главна',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'geodata-desc' => 'Voegt geografische coördinatenopslag en weergavefunctionaliteit toe',
	'geodata-bad-input' => 'Er zijn ongeldige argumenten in de <nowiki>{{#coordinates:}}</nowiki>-functie opgegeven',
	'geodata-bad-latitude' => '<nowiki>{{#coordinates:}}</nowiki>:ongeldige breedtegraad',
	'geodata-bad-longitude' => '<nowiki>{{#coordinates:}}</nowiki>:ongeldige lengtegraad',
	'geodata-bad-type' => '<nowiki>{{#coordinates:}}</nowiki>: type "$1" niet herkend',
	'geodata-bad-globe' => '<nowiki>{{#coordinates:}}</nowiki>: wereldbol "$1" niet herkend',
	'geodata-bad-region' => '<nowiki>{{#coordinates:}}</nowiki>: ongeldig formaat van de regiocode',
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: er kan niet meer dan één primaire tag per pagina zijn',
	'geodata-limit-exceeded' => 'De limiet van $1 <nowiki>{{#coordinates:}}</nowiki>-{{PLURAL:$1|tag|tags}} per pagina is overschreden',
	'geodata-broken-tags-category' => "Pagina's met onjuiste coördinatenlabels",
	'geodata-unknown-type-category' => "Pagina's met onbekend type coördinaten",
	'geodata-unknown-globe-category' => "Pagina's met onbekende waarde voor wereldbol",
	'geodata-unknown-region-category' => "Pagina's met ongeldige waarde voor regio",
	'geodata-primary-coordinate' => 'primair',
);

/** Russian (Русский)
 * @author Max Semenik
 */
$messages['ru'] = array(
	'geodata-multiple-primary' => '<nowiki>{{#coordinates:}}</nowiki>: нельзя иметь более одной первичной метки на странице',
);

