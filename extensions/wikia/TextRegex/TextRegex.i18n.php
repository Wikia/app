<?php
/**
 * Internationalisation file for extension SpamRegex.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'textregex'                     => 'Text regex',
	'textregex-desc'                => '[[Special:textregex/XXXX|Filter]] out unwanted phrases in edited pages, based on regular expressions',
	'textregex-page-title'          => 'List of unwanted expressions',
	'textregex-error-unblocking' 	=> 'Error unblocking ($1). Try once again.',
	'textregex-currently-blocked' 	=> "'''Currently blocked phrases:'''",
	'textregex_nocurrently-blocked'	=> 'No blocked phrases found',
	'textregex-addedby-user'		=> 'added by $1 on $2',
	'textregex-remove-url'			=> '[{{SERVER}}$1&id=$2 remove]',
	'textregex-stats-url'			=> '[{{SERVER}}$1&id=$2 statistics]',
	'textregex-page-title-block'  	=> 'Block unwanted phrase using regex',
	'textregex-unblock-succ'  		=> 'Unblock succedeed',
	'textregex-block-succ'        	=> 'Block succedeed',
	'textregex-unblock-message'     => 'Phrase \'\'\'$1\'\'\' has been removed from unwanted expressions.',
	'textregex-block-message'       => 'Phrase \'\'\'$1\'\'\' has been added to unwanted expressions.',
	'textregex-regex-block' 		=> 'Phrase to block:',
	'textregex-regex-search'		=> 'Search phrases: ',
	'textregex-submit-regex'		=> 'Add phrase',
	'textregex-submit-showlist'		=> 'Show list',
	'textregex-empty-regex'			=> 'Give a proper phrase to block.',
	'textregex-invalid-regex'		=> 'Invalid regex.',
	'textregex-already-added'      	=> '"$1" is already added',
	'textregex-nodata-found'		=> 'No data found',
	'textregex-stats-record'		=> "word ''$1'' was used by $2 on $3 (''comment: $4'')",
	'textregex-select-subpage' 		=> 'Select one of list of phrases:',
	'textregex-select-default' 		=> '-- select --',
	'textregex-create-subpage' 		=> 'or create new list:',
	'textregex-select-regexlist'	=> 'go to the list',
	'textregex-invalid-regexid'		=> 'Invalid phrase.',
	'textregex-phrase-statistics'	=> 'Statistics for \'\'\'$1\'\'\' phrase (number of records: $2)',
	'textregex-return-mainpage'		=> '[{{SERVER}}$1 return to the list]',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'textregex-addedby-user' => 'If $2 is a time stamp, split date and time',
	'textregex-phrase-statistics' => 'Should support plural for $2',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'textregex' => 'Teks regex',
	'textregex-page-title' => 'Lys van ongewenste reguliere uitdrukkings',
	'textregex-error-unblocking' => "'n Fout het voorgekom met die deblokkade ($1).
Probeer asseblief weer.",
	'textregex-currently-blocked' => "'''Frases wat tans geblokkeer word:'''",
	'textregex_nocurrently-blocked' => 'Geen geblokkeerde frases gevind nie',
	'textregex-addedby-user' => 'bygevoeg deur $1 op $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 verwyder]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistieke]',
	'textregex-page-title-block' => 'Blokkeer ongewenste frases met behulp van reguliere uitdrukkings',
	'textregex-unblock-succ' => 'Die deblokkade is uitgevoer',
	'textregex-block-succ' => 'Die blokkade is uitgevoer',
	'textregex-regex-block' => 'Regex-frase om te blokkeer:',
	'textregex-regex-search' => 'Soek reguliere uitdrukkings:',
	'textregex-submit-regex' => 'Voeg regex by',
	'textregex-submit-showlist' => 'Wys lys',
	'textregex-empty-regex' => "Verskaf 'n behoorlike regex om te blokkeer.",
	'textregex-invalid-regex' => 'Ongeldige regex.',
	'textregex-already-added' => '"$1" is reeds bygevoeg',
	'textregex-nodata-found' => 'Geen data gevind nie',
	'textregex-stats-record' => 'die woord "$1" is gebruik deur $2 in $3 (\'\'opmerking: $4\'\')',
	'textregex-select-subpage' => "Kies uit 'n lys van reguliere uitdrukkings:",
	'textregex-select-default' => '-- kies --',
	'textregex-create-subpage' => "of skep 'n nuwe lys:",
	'textregex-select-regexlist' => 'gaan na die lys',
	'textregex-invalid-regexid' => 'Ongeldige ID of regex.',
	'textregex-phrase-statistics' => "Statistieke vir die frase '''$1''' (aantal rekords: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 terug na die lys]',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'textregex-error-unblocking' => "Ur fazi 'zo bet e-pad an distankañ ($1). Klaskit adarre.",
	'textregex-currently-blocked' => "'''Frazennoù stanket evit bremañ :'''",
	'textregex_nocurrently-blocked' => "N'eo bet kavet frazenn stanket ebet",
	'textregex-addedby-user' => "bet ouzhpennet gant $1 d'an $2",
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 dilemel]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 stadegoù]',
	'textregex-unblock-succ' => 'Graet eo an distankadur',
	'textregex-block-succ' => 'Graet eo ar stankadur',
	'textregex-unblock-message' => "Dilemet eo bet ar frazenn '''$1''' deus ar frazennoù ne vez ket c'hoant outo.",
	'textregex-block-message' => "Ouzhpennet eo bet ar frazenn '''$1''' d'ar frazennoù ne vez ket c'hoant outo.",
	'textregex-regex-block' => 'Frazenn da stankañ :',
	'textregex-regex-search' => 'Klask frazennoù :',
	'textregex-submit-regex' => 'Ouzhpennañ ur frazenn',
	'textregex-submit-showlist' => 'Diskouez ar roll',
	'textregex-already-added' => 'Ouzhpennet eo bet "$1" dija',
	'textregex-nodata-found' => "N'eus ket bet kavet roadennoù",
	'textregex-stats-record' => "ar ger''$1'' a oa bet implijet gant $2 war $3 (''displegadenn: $4'')",
	'textregex-select-subpage' => 'Dibab unan eus frazennoù al listenn :',
	'textregex-select-default' => '-- dibab --',
	'textregex-create-subpage' => 'pe krouit ur roll nevez :',
	'textregex-select-regexlist' => "mont d'ar roll",
	'textregex-invalid-regexid' => 'Frazenn fall.',
	'textregex-phrase-statistics' => "Stadegoù evit ar frazenn '''$1''' (niver a enrolladennoù : $2)",
	'textregex-return-mainpage' => "[{{SERVIJER}}$1 distreiñ d'ar roll.]",
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'textregex' => 'Expression rationnelle de texte',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtre]] des phrases indésirables dans les pages, basé sur des expression rationnelles',
	'textregex-page-title' => "Liste d'expressions indésirables",
	'textregex-error-unblocking' => 'Erreur lors du déblocage ($1). Essayez encore une fois.',
	'textregex-currently-blocked' => "'''Phrases actuellement bloqués :'''",
	'textregex_nocurrently-blocked' => 'Aucune phrase bloquée trouvée',
	'textregex-addedby-user' => 'ajouté par $1 le $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 supprimer]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistiques]',
	'textregex-page-title-block' => 'Bloquer des phrases indésirables en utilisant des expressions rationnelles',
	'textregex-unblock-succ' => 'Le déblocage a réussi',
	'textregex-block-succ' => 'Le blocage a réussi',
	'textregex-unblock-message' => "La phrase '''$1''' a été supprimée des expressions indésirables.",
	'textregex-block-message' => "La phrase '''$1''' a été ajoutée aux expressions indésirables.",
	'textregex-regex-block' => 'Expression rationnelle à bloquer :',
	'textregex-regex-search' => 'Rechercher des expressions rationnelles :',
	'textregex-submit-regex' => 'Ajouter une expression rationnelle',
	'textregex-submit-showlist' => 'Afficher la liste',
	'textregex-empty-regex' => 'Donnez une expression rationnelle à bloquer correcte.',
	'textregex-invalid-regex' => 'Expression rationnelle invalide.',
	'textregex-already-added' => '« $1 » a déjà été ajouté',
	'textregex-nodata-found' => "Aucune donnée n'a été trouvée",
	'textregex-stats-record' => "le mot ''$1'' a été utilisé par $2 le $3 (''commentaire : $4'')",
	'textregex-select-subpage' => 'Sélectionnez une expression rationnelle de la liste :',
	'textregex-select-default' => '-- sélectionner --',
	'textregex-create-subpage' => 'ou créez une nouvelle liste :',
	'textregex-select-regexlist' => 'aller à la dernière',
	'textregex-invalid-regexid' => "Identifiant d'expression rationnelle invalide.",
	'textregex-phrase-statistics' => "Statistiques pour la phrase '''$1''' (nombre d'enregistrements : $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 revenir à la liste]',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'textregex' => 'Expresión regular de texto',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtrar]] frases non desexadas nas páxinas editadas, baseándose en expresións regulares',
	'textregex-page-title' => 'Lista de expresións non desexadas',
	'textregex-error-unblocking' => 'Erro ao desbloquear ($1). Inténteo de novo.',
	'textregex-currently-blocked' => "'''Frases actualmente bloqueadas:'''",
	'textregex_nocurrently-blocked' => 'Non se atopou ningunha frase bloqueada',
	'textregex-addedby-user' => 'engadido por $1 o $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 eliminar]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 estatísticas]',
	'textregex-page-title-block' => 'Bloquear as frases non desexadas mediante o uso de expresións regulares',
	'textregex-unblock-succ' => 'O desbloqueo tivo éxito',
	'textregex-block-succ' => 'O bloqueo tivo éxito',
	'textregex-unblock-message' => "A frase \"'''\$1'''\" eliminouse das expresións non desexadas.",
	'textregex-block-message' => "A frase \"'''\$1'''\" engadiuse ás expresións non desexadas.",
	'textregex-regex-block' => 'Expresión regular a bloquear:',
	'textregex-regex-search' => 'Procurar expresións regulares:',
	'textregex-submit-regex' => 'Engadir unha expresión regular',
	'textregex-submit-showlist' => 'Mostrar a lista',
	'textregex-empty-regex' => 'Dea unha expresión regular axeitada para bloqueala.',
	'textregex-invalid-regex' => 'Expresión regular incorrecta.',
	'textregex-already-added' => '"$1" xa se engadiu',
	'textregex-nodata-found' => 'Non se atopou ningún dato',
	'textregex-stats-record' => "a palabra \"'''\$1'''\" foi empregada por \$2 o \$3 (''comentario: \$4'')",
	'textregex-select-subpage' => 'Seleccione unha expresión regular da lista:',
	'textregex-select-default' => '-- seleccione --',
	'textregex-create-subpage' => 'ou cree unha nova lista:',
	'textregex-select-regexlist' => 'ir á lista',
	'textregex-invalid-regexid' => 'O identificador da expresión regular non é válido.',
	'textregex-phrase-statistics' => "Estatísticas para a frase \"'''\$1'''\" (número de rexistros: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 voltar á lista]',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'textregex-page-title' => 'Nemkívánatos kifejezések listája',
	'textregex-addedby-user' => 'hozzáadta $1 ekkor: $2',
	'textregex-unblock-succ' => 'A blokk feloldása sikeres',
	'textregex-block-succ' => 'A blokk sikeres',
	'textregex-regex-search' => 'Reguláris kifejezések keresése:',
	'textregex-submit-regex' => 'Reguláris kifejezés hozzáadása',
	'textregex-submit-showlist' => 'Lista megjelenítése',
	'textregex-invalid-regex' => 'Érvénytelen reguláris kifejezés.',
	'textregex-nodata-found' => 'Nem található adat',
	'textregex-select-subpage' => 'Válassz egyet a reguláris kifejezések listájából:',
	'textregex-select-default' => '–– kiválasztás ––',
	'textregex-create-subpage' => 'vagy új lista készítése:',
	'textregex-select-regexlist' => 'ugrás a listára',
	'textregex-invalid-regexid' => 'Érvénytelen reguláris kifejezés azonosító',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'textregex' => 'Регуларен израз за текст',
	'textregex-desc' => '[[Special:textregex/XXXX|Филтрирање]] на непожелни изрази во уредуваните страници, на основа на регуларни изрази',
	'textregex-page-title' => 'Листа на непожелни изрази',
	'textregex-error-unblocking' => 'Грешка при одблокирањето ($1). Обидете се повторно.',
	'textregex-currently-blocked' => "'''Моментално блокирани изрази:'''",
	'textregex_nocurrently-blocked' => 'Нема пронајдено блокирани изрази',
	'textregex-addedby-user' => 'додадено од $1 на $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 отстрани]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статистики]',
	'textregex-page-title-block' => 'Блокирање на непожелни изрази со помош на регуларни изрази',
	'textregex-unblock-succ' => 'Одблокирањето успеа',
	'textregex-block-succ' => 'Блокирањето успеа',
	'textregex-unblock-message' => "Изразот '''$1''' е отстранет од листата на непожелни изрази.",
	'textregex-block-message' => "Изразот '''$1''' е додаден во листата на непожелни изрази.",
	'textregex-regex-block' => 'Регуларен израз за блокирање:',
	'textregex-regex-search' => 'Пребарај регуларни изрази:',
	'textregex-submit-regex' => 'Додај регуларен израз',
	'textregex-submit-showlist' => 'Прикажи листа',
	'textregex-empty-regex' => 'Назначете правилен регуларен израз за блокирање.',
	'textregex-invalid-regex' => 'Неважечки регуларен израз.',
	'textregex-already-added' => '„$1“ е веќе додадено',
	'textregex-nodata-found' => 'Нема пронајдено податоци',
	'textregex-stats-record' => "зборот ''$1'' е употребен од $2 на $3 (''коментар: $4'')",
	'textregex-select-subpage' => 'Одберете еден регуларен израз од листата:',
	'textregex-select-default' => '-- одберете --',
	'textregex-create-subpage' => 'или создајте нова листа:',
	'textregex-select-regexlist' => 'оди на листата',
	'textregex-invalid-regexid' => 'Неважечки идентификатор на регуларниот израз.',
	'textregex-phrase-statistics' => "Статистики за изразот '''$1''' (број на записи: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 назад кон листата]',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'textregex' => 'Tekst reguliere expressie',
	'textregex-desc' => "[[Special:textregex/XXXX|Ongewenste tekstdelen filteren]] in bewerkte pagina's, gebaseerd op reguliere expressies",
	'textregex-page-title' => 'Lijst met ongewenste reguliere expressies',
	'textregex-error-unblocking' => 'Er is een fout opgetreden bij het deblokkeren ($1).
Probeer het opnieuw.',
	'textregex-currently-blocked' => "'''Op dit moment geblokkeerde tekstdelen:'''",
	'textregex_nocurrently-blocked' => 'Er zijn geen geblokkeerde tekstdelen gevonden',
	'textregex-addedby-user' => 'toegevoegd door $1 op $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 verwijderen]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistieken]',
	'textregex-page-title-block' => 'Ongewenste tekstdelen blokkeren met behulp van reguliere expressies',
	'textregex-unblock-succ' => 'De deblokkade is uitgevoerd',
	'textregex-block-succ' => 'De blokkade is uitgevoerd',
	'textregex-unblock-message' => "Het tekstdeel '''$1''' is verwijderd van de lijst met ongewenste teksten.",
	'textregex-block-message' => "Het tekstdeel '''$1''' is toegevoegd aan de lijst met ongewenste teksten.",
	'textregex-regex-block' => 'Te blokkeren reguliere expressie:',
	'textregex-regex-search' => 'Reguliere expressie zoeken:',
	'textregex-submit-regex' => 'Reguliere expressie toevoegen',
	'textregex-submit-showlist' => 'Lijst weergeven',
	'textregex-empty-regex' => 'Geen een correcte te blokkeren reguliere expressie op.',
	'textregex-invalid-regex' => 'Ongeldige reguliere expressie',
	'textregex-already-added' => '"$1" is al toegevoegd',
	'textregex-nodata-found' => 'Geen gegevens gevonden',
	'textregex-stats-record' => 'het woord "$1" is gebruikt door $2 in $3 (\'\'opmerking: $4\'\')',
	'textregex-select-subpage' => 'Selecteer uit een lijst van reguliere expressies:',
	'textregex-select-default' => '-- selecteren --',
	'textregex-create-subpage' => 'of maak een nieuwe lijst:',
	'textregex-select-regexlist' => 'ga naar de lijst',
	'textregex-invalid-regexid' => 'Ongeldig herkenningsteken of ongeldige reguliere expressie.',
	'textregex-phrase-statistics' => "Statistieken voor het tekstdeel '''$1''' (aantal records: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 terug naar de lijst]',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'textregex' => 'Regex (Espression Regolar) ëd test',
	'textregex-desc' => "[[Special:textregex/XXXX|Filtra]] le fras pa vorsùe ant le pàgine modificà, basà dzora a d'espression regolar",
	'textregex-page-title' => "Lista dj'espression nen vorsùe",
	'textregex-error-unblocking' => "Eror an dësblocand ($1). Preuva n'àutra vira.",
	'textregex-currently-blocked' => "'''Fras blocà al moment:'''",
	'textregex_nocurrently-blocked' => 'Pa trovà gnun-e fras blocà',
	'textregex-addedby-user' => 'giontà da $1 su $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 gava]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statìstiche]',
	'textregex-page-title-block' => "Blòca fras pa vorsùe an dovrand d'espression regolar",
	'textregex-unblock-succ' => 'Dësblocagi andàit bin',
	'textregex-block-succ' => 'Blocagi andàit bin',
	'textregex-unblock-message' => "La fras '''$1''' a l'é stàita gavà da j'espression pa vorsùe.",
	'textregex-block-message' => "La fras '''$1''' a l'é stàita giontà a j'espression pa vorsùe.",
	'textregex-regex-block' => "Fras d'espression regolar da bloché:",
	'textregex-regex-search' => 'Serca espression regolar:',
	'textregex-submit-regex' => 'Gionta espression regolar',
	'textregex-submit-showlist' => 'Smon-e la lista',
	'textregex-empty-regex' => "Dà n'espression regolar bon-a da bloché.",
	'textregex-invalid-regex' => 'Espression regolar pa bon-a.',
	'textregex-already-added' => '"$1" a l\'é già giontà.',
	'textregex-nodata-found' => 'Pa gnun dat trovà',
	'textregex-stats-record' => "la paròla ''$1'' a l'era dovrà da $2 su $3 (''coment: $4'')",
	'textregex-select-subpage' => "Selession-a na lista d'espression regolar:",
	'textregex-select-default' => '-- selession-a --',
	'textregex-create-subpage' => 'o crea na lista neuva:',
	'textregex-select-regexlist' => 'va a la lista',
	'textregex-invalid-regexid' => "Identificator d'espression regolar pa bon.",
	'textregex-phrase-statistics' => "Statìstiche për la fras '''$1''' (nùmer d'argistrassion: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 artorna a la lista]',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'textregex' => 'Тестировать регулярное выражение',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статистика]',
	'textregex-page-title-block' => 'Блокирование нежелательных фраз с помощью регулярных выражений',
	'textregex-regex-search' => 'Поиск регулярных выражений:',
	'textregex-invalid-regex' => 'Неверное регулярное выражение.',
	'textregex-select-subpage' => 'Выберите из списка регулярных выражений:',
);

