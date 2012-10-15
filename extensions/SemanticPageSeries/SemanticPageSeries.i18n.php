<?php
/**
 * Language file for Semantic Page Series
 */

$messages = array();

/** English
 * @author F.trott
 */
$messages['en'] = array(
	'semanticpageseries-desc' => 'Creating a series of pages from one [https://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Form]',
	'spssuccesstitle' => 'Creating $1 pages',
	'spssuccess' => '{{PLURAL:$1|One page|$1 pages}} will be created.',
	'spssuccess-returntoorigin' => 'Return to $1',
	'spserror' => 'An error occurred',
	
	'spserror-diffnotsupported' => 'The diff action is not supported for page series.',
	'spserror-previewnotsupported' => 'The preview action is not supported for page series.',
	'spserror-noiteratorname' => 'No iterator specified. You have to set the parameter "iterator" in the #serieslink parser function call.',
	'spserror-iteratorunknown' => 'Iterator "$1" does not exist. You have to correct the parameter "iterator" in the #serieslink parser function call.',
	'spserror-noformname' => 'No form name given.  You have to set the parameter "form" in the #serieslink parser function.',
	'spserror-formunknown' => 'Form "$1" does not exist.',
	'spserror-notargetformname' => 'No target form name given. You have to set the parameter "target form" in the #serieslink parser function call.',
	'spserror-notargetfieldname' => 'No target field name given. You have to set the parameter "target field" in the #serieslink parser function call.',
	'spserror-iteratorparammissing' => "The following iterator parameters are missing in the #serieslink call:\n$1",
	'spserror-noiteratordata' => 'No iterator parameters found in the sent data.',
	'spserror-pagegenerationlimitexeeded' => 'You tried to generate {{PLURAL:$1|one page|$1 pages}}. This exeeds your allowed limit of {{PLURAL:$2|one page|$2 pages}}.',

	'spserror-date-startdatemissing' => 'The start date is missing.',
	'spserror-date-internalerror' => 'An error occurred while creating the dates. This could be due to a malformed start or end date.',
	
	'spserror-count-startvaluemalformed' => 'The start value is not a number.',
	'spserror-count-endvaluemalformed' => 'The end value is not a number.',
	'spserror-count-stepvaluemalformed' => 'The step value is not a number.',
	'spserror-count-digitsvaluemalformed' => 'The digits value is not a number.',
);

/** Message documentation (Message documentation)
 * @author F.trott
 * @author Raymond
 */
$messages['qqq'] = array(
	'semanticpageseries-desc' => '{{desc}}',
	'spssuccesstitle' => 'The title of a page containing a success message. The parameter will contain the category of pages to be created, e.g. Event',
	'spssuccess' => 'A success message. The parameter will contain a number.',
	'spssuccess-returntoorigin' => 'Provides navigation back to the origin page. The parameter is the link.',
	'spserror' => 'The title of en error page',
	'spserror-diffnotsupported' => 'An error message',
	'spserror-previewnotsupported' => 'An error message',
	'spserror-noiteratorname' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. The name of the parameter in quotes should not be translated!',
	'spserror-iteratorunknown' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. The name of the parameter in quotes should not be translated!',
	'spserror-noformname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror-formunknown' => 'An error message',
	'spserror-notargetformname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror-notargetfieldname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror-iteratorparammissing' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. Do not translate <code>#serieslink</code>.',
	'spserror-noiteratordata' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator.',
	'spserror-pagegenerationlimitexeeded' => 'An error message',
	'spserror-date-startdatemissing' => 'An error message',
	'spserror-date-internalerror' => 'An error message',
	'spserror-count-startvaluemalformed' => 'An error message',
	'spserror-count-endvaluemalformed' => 'An error message',
	'spserror-count-stepvaluemalformed' => 'An error message',
	'spserror-count-digitsvaluemalformed' => 'An error message',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'semanticpageseries-desc' => 'Ermöglicht das Erstellen einer Abfolge von Seiten mit einem von [https://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms] bereitgestellten Formular',
	'spssuccesstitle' => '$1 Seiten werden erstellt …',
	'spssuccess' => '{{PLURAL:$1|Eine Seite wird|$1 Seiten werden}} erstellt.',
	'spssuccess-returntoorigin' => 'Zurück zu $1',
	'spserror' => 'Ein Fehler ist aufgetreten',
	'spserror-diffnotsupported' => 'Die Aktion „diff“ wird nicht unterstützt.',
	'spserror-previewnotsupported' => 'Die Seitenvorschau wird nicht unterstützt.',
	'spserror-noiteratorname' => 'Der Seitenfolgebezeichner wurde nicht angegeben. Der Parameter „iterator“ muss zur Funktion #serieslink angegeben werden.',
	'spserror-iteratorunknown' => 'Der Seitenfolgebezeichner „$1“ ist nicht vorhanden. Der Parameter „iterator“ der Funktion #serieslink muss berichtigt werden.',
	'spserror-noformname' => 'Der Name des Formulars wurde nicht angegeben.',
	'spserror-formunknown' => 'Das Formular „$1“ ist nicht vorhanden.',
	'spserror-notargetformname' => 'Der Name des Zielformulars wurde nicht angegeben. Der Parameter „target form“ muss zur Funktion #serieslink angegeben werden.',
	'spserror-notargetfieldname' => 'Der Name des Zielfeldes wurde nicht angegeben. Der Parameter „target field“ muss zur Funktion #serieslink angegeben werden.',
	'spserror-iteratorparammissing' => 'Die folgenden Parameter zum Seitenfolgebezeichner fehlen beim Aufruf der Funktion #serieslink:
$1',
	'spserror-noiteratordata' => 'Die gesendeten Daten enthalten keine Parameter zum Seitenfolgebezeichner.',
	'spserror-pagegenerationlimitexeeded' => 'Es {{PLURAL:$1|sollte eine Seite|sollten $1 Seiten}} erstellt werden. Diese Anzahl übertrifft den zulässigen Grenzwert von {{PLURAL:$2|einer Seite|$2 Seiten}}.',
	'spserror-date-startdatemissing' => 'Es fehlt das Startdatum.',
	'spserror-date-internalerror' => 'Beim Erstellen der Daten ist ein Fehler aufgetreten. Der Grund könnte ein falsches Start- oder Enddatum sein.',
	'spserror-count-startvaluemalformed' => 'Der Startwert ist keine Zahl.',
	'spserror-count-endvaluemalformed' => 'Der Endwert ist keine Zahl.',
	'spserror-count-stepvaluemalformed' => 'Der Schrittwert ist keine Zahl.',
	'spserror-count-digitsvaluemalformed' => 'Der Ziffernwert ist keine Zahl.',
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'semanticpageseries-desc' => 'Créer une série de pages depuis un [https://www.mediawiki.org/wiki/Extension:Semantic_Forms formulaire sémantique]',
	'spssuccesstitle' => 'Créer $1 pages',
	'spssuccess' => '{{PLURAL:$1|Une page sera créée|$1 pages seront créées}}.',
	'spssuccess-returntoorigin' => 'Revenir à $1',
	'spserror' => 'Une erreur est survenue',
	'spserror-diffnotsupported' => "L'action diff n'est pas supportée pour les séries de page.",
	'spserror-previewnotsupported' => "L'action de prévisualisation n'est pas supportée pour les séries de page.",
	'spserror-noiteratorname' => "Aucun itérateur n'a été spécifié. Vous devez définir le paramètre \"iterator\" dans l'appel à la fonction #serieslink de l'analyseur.",
	'spserror-iteratorunknown' => 'L\'itérateur "$1" n\'existe pas. Vous devez corriger le paramètre "iterator" dans l\'appel à la fonction #serieslink de l\'analyseur.',
	'spserror-noformname' => 'Aucun nom de formulaire n\'a été fourni. Vous devez définir le paramètre "form" dans la fonction #serieslink de l\'analyseur.',
	'spserror-formunknown' => 'Le formulaire "$1" n\'existe pas.',
	'spserror-notargetformname' => "Aucun nom de formulaire cible n'a été fourni. Vous devez définir le paramètre \"target form\" dans l'appel à la fonction #serieslink de l'analyseur.",
	'spserror-notargetfieldname' => "Aucun nom de champ cible n'a été fourni. Vous devez définir le paramètre \"target field\" dans l'appel à la fonction #serieslink de l'analyseur.",
	'spserror-iteratorparammissing' => "Les paramètres suivants de l'itérateur sont absents dans l'appel à #serieslink:
$1",
	'spserror-noiteratordata' => "Aucun paramètre de l'itérateur n'a été trouvé dans les données envoyées.",
	'spserror-pagegenerationlimitexeeded' => 'Vous avez essayé de générer {{PLURAL:$1|une page|$1 pages}}. Cela dépasse votre limite autorisée de {{PLURAL:$2|une page|$2 pages}}.',
	'spserror-date-startdatemissing' => 'La date de début est manquante.',
	'spserror-date-internalerror' => "Une erreur s'est produite lors de la création des dates. Cela pourrait être dû à une date de début ou de fin mal formée.",
	'spserror-count-startvaluemalformed' => "La valeur de départ n'est pas un nombre.",
	'spserror-count-endvaluemalformed' => "La valeur de fin n'est pas un nombre.",
	'spserror-count-stepvaluemalformed' => "La valeur de l'incrément n'est pas un nombre.",
	'spserror-count-digitsvaluemalformed' => "La valeur des chiffres n'est pas un nombre.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'semanticpageseries-desc' => 'Crear unha serie de páxinas a partir dun [https://www.mediawiki.org/wiki/Extension:Semantic_Forms formulario semántico]',
	'spssuccesstitle' => 'Creando páxinas do tipo $1',
	'spssuccess' => '{{PLURAL:$1|Vaise crear unha páxina.|Vanse crear $1 páxinas.}}',
	'spssuccess-returntoorigin' => 'Volver a "$1"',
	'spserror' => 'Houbo un erro',
	'spserror-diffnotsupported' => 'As series de páxinas non soportan a acción de diferenzas.',
	'spserror-previewnotsupported' => 'As series de páxinas non soportan a acción de vista previa.',
	'spserror-noiteratorname' => 'Non se especificou iterador ningún. Cómpre definir o parámetro "iterator" na función analítica de chamada #serieslink.',
	'spserror-iteratorunknown' => 'Non existe o iterador "$1". Cómpre corrixir o parámetro "iterator" na función analítica de chamada #serieslink.',
	'spserror-noformname' => 'Non se deu formulario ningún. Cómpre definir o parámetro "form" na función analítica #serieslink.',
	'spserror-formunknown' => 'O formulario "$1" non existe.',
	'spserror-notargetformname' => 'Non se deu nome de formulario de destino ningún. Cómpre definir o parámetro "target form" na función analítica de chamada #serieslink.',
	'spserror-notargetfieldname' => 'Non se deu campo de destino ningún. Cómpre definir o parámetro "target field" na función analítica de chamada #serieslink.',
	'spserror-iteratorparammissing' => 'Faltan os seguintes parámetros do iterador na chamada a #serieslink:
$1',
	'spserror-noiteratordata' => 'Non se atopou parámetro do iterador ningún nos datos enviados.',
	'spserror-pagegenerationlimitexeeded' => 'Intentou xerar {{PLURAL:$1|unha páxina|$1 páxinas}}. Isto supera o límite {{PLURAL:$2|dunha páxina|de $2 páxinas}}.',
	'spserror-date-startdatemissing' => 'Falta a data de inicio.',
	'spserror-date-internalerror' => 'Houbo un erro ao crear as datas. Se cadra é porque algunha das datas ten un formato incorrecto.',
	'spserror-count-startvaluemalformed' => 'O valor de inicio non é un número.',
	'spserror-count-endvaluemalformed' => 'O valor de fin non é un número.',
	'spserror-count-stepvaluemalformed' => 'O valor do paso non é un número.',
	'spserror-count-digitsvaluemalformed' => 'O valor dos díxitos non é un número.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'semanticpageseries-desc' => 'Wutworjenje slěda stronow ze [https://www.mediawiki.org/wiki/Extension:Semantic_Forms semantiskim formularom]',
	'spssuccesstitle' => '$1 stronow so wutwarja',
	'spssuccess' => '{{PLURAL:$1|Jedna strona so wutwori|$1 stronje so wutworitej|$1 strony so wutworja|$1 stronow so wutwori}}.',
	'spssuccess-returntoorigin' => 'Wróćo k $1',
	'spserror' => 'Zmylk je wustupił',
	'spserror-diffnotsupported' => 'Akcija "diff" so za slědy stronow njepodpěruje.',
	'spserror-previewnotsupported' => 'Přehlad so za slědow stronow njepodpěruje.',
	'spserror-noiteratorname' => 'Žane iteratorowe mjeno njepodate. Parameter "iterator" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror-iteratorunknown' => 'Iterator "$1" njeeksistuje. Parameter "iterator" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror-noformname' => 'Žane formularne mjeno njepodate.',
	'spserror-formunknown' => 'Formular "$1" njeeksistuje.',
	'spserror-notargetformname' => 'Žadyn cilowy formular njepodaty. Parameter "target form" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror-notargetfieldname' => 'Žane cilowe polo njepodate. Parameter "target field" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror-iteratorparammissing' => 'Slědowace iteratorowe parametry při wołanju funkcije #serieslink faluja: $1',
	'spserror-noiteratordata' => 'Žane iteratorowe parametry w pósłanych datach namakane.',
	'spserror-pagegenerationlimitexeeded' => 'Sy spytał {{PLURAL:$1|jednu stronu|$1 stronje|$1 strony|$1 stronow}} płodźić. To překročuje dowoleny limit wot {{PLURAL:$2|jedneje strony|$2 stronow|$2 stronow|$1 stronow}}.',
	'spserror-date-startdatemissing' => 'Startowy datum faluje.',
	'spserror-date-internalerror' => 'Při wutworjenju datumow je zmylk wustupił. Přičina móhła njepłaćiwy startowy abo kónčny datum  być.',
	'spserror-count-startvaluemalformed' => 'Startowa hódnota ličba njeje.',
	'spserror-count-endvaluemalformed' => 'Kónčna hódnota ličba njeje.',
	'spserror-count-stepvaluemalformed' => 'Kročelowa hódnota ličba njeje.',
	'spserror-count-digitsvaluemalformed' => 'Cyfrowa hódnota ličba njeje.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticpageseries-desc' => 'Crea un serie de paginas ab un sol [https://www.mediawiki.org/wiki/Extension:Semantic_Forms formulario semantic]',
	'spssuccesstitle' => 'Crea $1 paginas',
	'spssuccess' => '{{PLURAL:$1|Un pagina|$1 paginas}} essera create.',
	'spssuccess-returntoorigin' => 'Retornar a $1',
	'spserror' => 'Un error ha occurrite',
	'spserror-diffnotsupported' => 'Le action "diff" non es supportate pro series de paginas.',
	'spserror-previewnotsupported' => 'Le action de previsualisation non es supportate pro series de paginas.',
	'spserror-noiteratorname' => 'Nulle iterator specificate. Es necessari specificar le parametro "iterator" in le appello al function analysator #serieslink.',
	'spserror-iteratorunknown' => 'Le iterator "$1" non existe. Es necessari corriger le parametro "iterator" in le appello al function analysator #serieslink.',
	'spserror-noformname' => 'Nulle nomine de formulario specificate.',
	'spserror-formunknown' => 'Le formulario "$1" non existe.',
	'spserror-notargetformname' => 'Nulle nomine de formulario de destination specificate. Es necessari specificar le parametro "target form" in le appello al function analysator #serieslink.',
	'spserror-notargetfieldname' => 'Nulle nomine de campo de destination specificate. Es necessari specificar le parametro "target field" in le appello al function analysator #serieslink.',
	'spserror-iteratorparammissing' => 'Le sequente parametros de iterator manca in le appello #serieslink:
$1',
	'spserror-noiteratordata' => 'Nulle parametro de iterator trovate in le datos inviate.',
	'spserror-pagegenerationlimitexeeded' => 'Tu tentava generar {{PLURAL:$1|un pagina|$1 paginas}}. Isto excede tu limite autorisate de {{PLURAL:$2|un pagina|$2 paginas}}.',
	'spserror-date-startdatemissing' => 'Le data de initio es mancante.',
	'spserror-date-internalerror' => 'Un error occurreva durante le creation del datas. Isto pote esser causate per un data de initio o de fin mal formate.',
	'spserror-count-startvaluemalformed' => 'Le valor de initio non es un numero.',
	'spserror-count-endvaluemalformed' => 'Le valor de fin non es un numero.',
	'spserror-count-stepvaluemalformed' => 'Le valor de incremento non es un numero.',
	'spserror-count-digitsvaluemalformed' => 'Le valor de cifras non es un numero.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'spssuccess-returntoorigin' => 'Zréck op $1',
	'spserror' => 'Et ass e Feeler geschitt',
	'spserror-formunknown' => 'De Formulaire "$1" gëtt et net.',
	'spserror-date-startdatemissing' => 'Den Ufanksdatum feelt.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'semanticpageseries-desc' => 'Создавање на низа страници од еден [https://www.mediawiki.org/wiki/Extension:Semantic_Forms?uselang=mk Семантички образец]',
	'spssuccesstitle' => 'Создате $1 страници',
	'spssuccess' => '{{PLURAL:$1|Ќе биде создадена една страница|Ќе бидат создадени $1 страници}}',
	'spssuccess-returntoorigin' => 'Назад на $1',
	'spserror' => 'Се појави грешка',
	'spserror-diffnotsupported' => 'Функцијата „разлика“ не е достапна за цели низи од страници.',
	'spserror-previewnotsupported' => 'Функцијата „преглед“ не е достапна за цели низи од страници.',
	'spserror-noiteratorname' => 'Нема укажано повторувач. Треба да зададете параметар „iterator“ во повикот #serieslink на парсерската функција.',
	'spserror-iteratorunknown' => 'Повторувачот „$1“ не постои. Ќе треба да го исправите параметарот „iterator“ во повикот #serieslink на парсерската функција.',
	'spserror-noformname' => 'Нема укажано име на образецот.',
	'spserror-formunknown' => 'Образецот „$1“ не постои.',
	'spserror-notargetformname' => 'Нема укажано име на целниот образец. Треба да зададете параметар „target form“ во повикот #serieslink на парсерската функција.',
	'spserror-notargetfieldname' => 'Нема укажано име на целното поле. Треба да зададете параметар „target field“ во повикот #serieslink на парсерската функција.',
	'spserror-iteratorparammissing' => 'Следниве параметри за повторувачот недостасуваат во повикот #serieslink call:
$1',
	'spserror-noiteratordata' => 'Не пронајдов параметри за повторувачот во испратените податоци.',
	'spserror-pagegenerationlimitexeeded' => 'Се обидовте да создадете {{PLURAL:$1|една страница|$1 страници}}. Со тоа ја надминувате дозволената граница од {{PLURAL:$2|една страница|$2 страници}}.',
	'spserror-date-startdatemissing' => 'Недостасува почетниот датум.',
	'spserror-date-internalerror' => 'Се појави грешка при создавањето на датумите. Ова може да се должи на погрешно внесен почетен или краен датум.',
	'spserror-count-startvaluemalformed' => 'Почетната вредност не е број.',
	'spserror-count-endvaluemalformed' => 'Крајната вредност не е број.',
	'spserror-count-stepvaluemalformed' => 'Вредноста на чекорот не е број.',
	'spserror-count-digitsvaluemalformed' => 'Вредноста на цифрите не е број.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Saruman
 */
$messages['nl'] = array(
	'semanticpageseries-desc' => "Een reeks pagina's aanmaken vanuit één [https://www.mediawiki.org/wiki/Extension:Semantic_Forms semantisch formulier]",
	'spssuccesstitle' => "$1 pagina's aanmaken",
	'spssuccess' => "{{PLURAL:$1|Eén pagina zal|$1 pagina's zullen}} aangemaakt worden.",
	'spssuccess-returntoorigin' => 'Terugkeren naar $1',
	'spserror' => 'Er is een fout opgetreden',
	'spserror-diffnotsupported' => 'De diff actie wordt niet ondersteund voor paginareeksen.',
	'spserror-previewnotsupported' => 'De preview actie wordt niet ondersteund voor paginareeksen.',
	'spserror-noiteratorname' => 'Geen iterator opgegeven. U moet de parameter "iterator" instellen in de #serieslink functieaanroep.',
	'spserror-iteratorunknown' => 'Iterator " $1 " bestaat niet. U moet de parameter "iterator" in de #serieslink functieaanroep corrigeren.',
	'spserror-noformname' => 'Geen formuliernaam opgegeven.  U moet de parameter "formulier" in de #serieslink functieaanroep opgeven.',
	'spserror-formunknown' => 'Formulier "$1" bestaat niet.',
	'spserror-notargetformname' => 'Geen doelformuliernaam opgegeven. U dient de parameter "target form" op te geven in de #serieslink functieaanroep .',
	'spserror-notargetfieldname' => 'Geen doelveldnaam gegeven. U dient de parameter "target field" op te geven in de #serieslink functieaanroep.',
	'spserror-iteratorparammissing' => 'De volgende iterator-parameters ontbreken in de #serieslink aanroep:
$1',
	'spserror-noiteratordata' => 'Geen iterator parameters gevonden in de verzonden gegevens.',
	'spserror-pagegenerationlimitexeeded' => "U hebt geprobeerd {{PLURAL:$1| een pagina| $1 pagina's}} te genereren. Dit overschrijdt de toegestane limiet van {{PLURAL:$2| een pagina| $2  pagina's}}.",
	'spserror-date-startdatemissing' => 'De begindatum ontbreekt.',
	'spserror-date-internalerror' => 'Er is een fout opgetreden tijdens het aanmaken van de data. Dit kan zijn veroorzaakt door een ongeldige begin- of einddatum.',
	'spserror-count-startvaluemalformed' => 'De beginwaarde is geen getal.',
	'spserror-count-endvaluemalformed' => 'De eindwaarde is geen getal.',
	'spserror-count-stepvaluemalformed' => 'De stapwaarde is geen getal.',
	'spserror-count-digitsvaluemalformed' => 'De cijferwaarde is geen getal.',
);

