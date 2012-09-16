<?php
/**
 * Internationalisation file for extension TextRegex.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'textregex' => 'Text regex',
	'textregex-desc' => '[[Special:textregex/XXXX|Filter]] out unwanted phrases in edited pages, based on regular expressions',
	'textregex-page-title' => 'List of unwanted expressions',
	'textregex-error-unblocking' => 'Error unblocking ($1).
Try once again.',
	'textregex-currently-blocked' => "'''Currently blocked phrases:'''",
	'textregex_nocurrently-blocked' => 'No blocked phrases found',
	'textregex-addedby-user' => 'added by $1 on $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 remove]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistics]',
	'textregex-unblock-succ' => 'Unblock succedeed',
	'textregex-block-succ' => 'Block succedeed',
	'textregex-unblock-message' => 'Phrase \'\'\'$1\'\'\' has been removed from unwanted expressions.',
	'textregex-block-message' => 'Phrase \'\'\'$1\'\'\' has been added to unwanted expressions.',
	'textregex-regex-block' => 'Phrase to block:',
	'textregex-submit-regex' => 'Add phrase',
	'textregex-empty-regex' => 'Give a proper phrase to block.',
	'textregex-invalid-regex' => 'Invalid regex.',
	'textregex-already-added' => '"$1" is already added',
	'textregex-nodata-found' => 'No data found',
	'textregex-stats-record' => "word ''$1'' was used by $2 on $3 (''comment: $4'')",
	'textregex-select-subpage' => 'Select one of list of phrases:',
	'textregex-select-default' => '-- select --',
	'textregex-create-subpage' => 'or create new list:',
	'textregex-select-regexlist' => 'go to the list',
	'textregex-invalid-regexid' => 'Invalid phrase.',
	'textregex-phrase-statistics' => 'Statistics for "\'\'\'$1\'\'\'" phrase (number of records: $2)',
	'textregex-return-mainpage' => '[{{SERVER}}$1 return to the list]',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Siebrand
 * @author Umherirrender
 * @author WikiPhoenix
 */
$messages['qqq'] = array(
	'textregex' => '"Regex" is a abbreviation for "regular expression".',
	'textregex-desc' => '{{desc}}',
	'textregex-addedby-user' => 'If $2 is a time stamp, split date and time',
	'textregex-remove-url' => '{{Identical|Remove}}',
	'textregex-stats-url' => '{{Identical|Statistics}}',
	'textregex-select-default' => '{{Identical|Select}}',
	'textregex-phrase-statistics' => 'Parameters:
* $1 is the regular expression text
* $2 is the number of records (can be used for plural support)',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'textregex' => 'Teks regex',
	'textregex-desc' => '[[Special:textregex/XXXX|Filter]] ongewensde frases uit gewysigde bladsye, gebaseer op reguliere uitdrukkings',
	'textregex-page-title' => 'Lys van ongewenste reguliere uitdrukkings',
	'textregex-error-unblocking' => "'n Fout het voorgekom met die deblokkade ($1).
Probeer asseblief weer.",
	'textregex-currently-blocked' => "'''Frases wat tans geblokkeer word:'''",
	'textregex_nocurrently-blocked' => 'Geen geblokkeerde frases gevind nie',
	'textregex-addedby-user' => 'bygevoeg deur $1 op $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 verwyder]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistieke]',
	'textregex-unblock-succ' => 'Die deblokkade is uitgevoer',
	'textregex-block-succ' => 'Die blokkade is uitgevoer',
	'textregex-unblock-message' => "Sinsnede '''$1''' is van die lys met ongewenste uitdrukkings verwyder.",
	'textregex-block-message' => "Sinsnede '''$1''' is by die lys van ongewenste uitdrukkings gevoeg.",
	'textregex-regex-block' => 'Regex-frase om te blokkeer:',
	'textregex-submit-regex' => 'Voeg regex by',
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

/** Belarusian (беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статыстыка]',
);

/** Belarusian (Taraškievica orthography) (‪беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'textregex' => 'Тэкставыя рэгулярныя выразы',
	'textregex-desc' => '[[Special:textregex/XXXX|Фільтар]] непажаданых фразаў на рэдагуемых старонках, заснаваны на рэгулярных выразах',
	'textregex-page-title' => 'Сьпіс непажаданых выразаў',
	'textregex-error-unblocking' => 'Памылка разблякаваньня ($1).
Паспрабуйце яшчэ раз.',
	'textregex-currently-blocked' => "'''Заблякаваныя цяпер фразы:'''",
	'textregex_nocurrently-blocked' => 'Заблякаваныя фразы ня знойдзеныя',
	'textregex-addedby-user' => 'дададзены $1 у $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 выдаліць]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статыстыка]',
	'textregex-unblock-succ' => 'Разблякаваньне пасьпяховае',
	'textregex-block-succ' => 'Блякаваньне пасьпяховае',
	'textregex-unblock-message' => "Фраза '''$1''' была выдаленая са сьпісу непажаданых выразаў.",
	'textregex-block-message' => "Фраза '''$1''' была дададзеная да сьпісу непажаданых выразаў.",
	'textregex-regex-block' => 'Фраза да блякаваньня:',
	'textregex-submit-regex' => 'Дадаць фразу',
	'textregex-empty-regex' => 'Падайце слушную фразу для блякаваньня.',
	'textregex-invalid-regex' => 'Няслушны рэгулярны выраз.',
	'textregex-already-added' => '«$1» ужо дададзеная',
	'textregex-nodata-found' => 'Нічога ня знойдзена',
	'textregex-stats-record' => "слова ''$1'' было выкарыстанае $2 у $3 (''камэнтар: $4'')",
	'textregex-select-subpage' => 'Выберыце са сьпісу фразаў:',
	'textregex-select-default' => '-- выбраць --',
	'textregex-create-subpage' => 'ці стварыце новы сьпіс:',
	'textregex-select-regexlist' => 'перайсьці да сьпісу',
	'textregex-invalid-regexid' => 'Няслушная фраза.',
	'textregex-phrase-statistics' => "Статыстыка для фразы «'''$1'''» (колькасьць запісаў: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 вярнуцца да сьпісу]',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'textregex-select-default' => '-- избиране --',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'textregex' => 'Regex testenn',
	'textregex-desc' => "[[Special:textregex/XXXX|Sil]] ar frazennoù dic'hoantaus er pajennoù, diazezet war eztaoladennoù poellel",
	'textregex-page-title' => 'Roll an eztaoladennoù strobus',
	'textregex-error-unblocking' => "Ur fazi 'zo bet e-pad an distankañ ($1). Klaskit adarre.",
	'textregex-currently-blocked' => "'''Frazennoù stanket evit bremañ :'''",
	'textregex_nocurrently-blocked' => "N'eo bet kavet frazenn stanket ebet",
	'textregex-addedby-user' => "bet ouzhpennet gant $1 d'an $2",
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 dilemel]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 stadegoù]',
	'textregex-unblock-succ' => 'Graet eo an distankadur',
	'textregex-block-succ' => 'Graet eo ar stankadur',
	'textregex-unblock-message' => "Dilamet eo bet ar frazenn '''$1''' eus roll ar frazennoù da argas.",
	'textregex-block-message' => "Ouzhpennet eo bet ar frazenn '''$1''' d'ar frazennoù ne vez ket c'hoant outo.",
	'textregex-regex-block' => 'Frazenn da stankañ :',
	'textregex-submit-regex' => 'Ouzhpennañ ur frazenn',
	'textregex-empty-regex' => 'Reiñ un eztaoladenn da stankañ.',
	'textregex-invalid-regex' => "N'eo ket mat ar regex.",
	'textregex-already-added' => 'Ouzhpennet eo bet "$1" dija',
	'textregex-nodata-found' => "N'eus ket bet kavet roadennoù",
	'textregex-stats-record' => "ar ger''$1'' a oa bet implijet gant $2 war $3 (''displegadenn: $4'')",
	'textregex-select-subpage' => 'Dibab unan eus frazennoù al listenn :',
	'textregex-select-default' => '-- diuzañ --',
	'textregex-create-subpage' => 'pe krouit ur roll nevez :',
	'textregex-select-regexlist' => "mont d'ar roll",
	'textregex-invalid-regexid' => 'Frazenn fall.',
	'textregex-phrase-statistics' => "Stadegoù evit ar frazenn '''$1''' (niver a enrolladennoù : $2)",
	'textregex-return-mainpage' => "[{{SERVIJER}}$1 distreiñ d'ar roll.]",
);

/** Catalan (català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'textregex-submit-regex' => "Afegiu l'expressió",
	'textregex-select-default' => '-- Seleccioneu --',
	'textregex-select-regexlist' => 'vés a la llista',
	'textregex-invalid-regexid' => 'Expressió no vàlida.',
);

/** Czech (česky)
 * @author Chmee2
 */
$messages['cs'] = array(
	'textregex-submit-regex' => 'Přidat frázi',
	'textregex-select-default' => '--vyberte--',
	'textregex-create-subpage' => 'nebo vytvořit nový seznam:',
);

/** German (Deutsch)
 * @author Kghbln
 * @author LWChris
 * @author SVG
 * @author The Evil IP address
 */
$messages['de'] = array(
	'textregex' => 'Text Regex',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtere]] ungewollte Phrasen, basierend auf regulären Ausdrücken, aus geänderten Seiten aus',
	'textregex-page-title' => 'Liste von unerwünschten Ausdrücken',
	'textregex-error-unblocking' => 'Fehler bei Entsperrung ($1).
Versuche es noch einmal.',
	'textregex-currently-blocked' => "'''Derzeit gesperrte Phrasen:'''",
	'textregex_nocurrently-blocked' => 'Keine gesperrten Phrasen gefunden',
	'textregex-addedby-user' => 'hinzugefügt von $1 am $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 entfernen]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 Statistiken]',
	'textregex-unblock-succ' => 'Entsperrung erfolgreich',
	'textregex-block-succ' => 'Sperrung erfolgreich',
	'textregex-unblock-message' => "Phrase '''$1''' ist aus den unerwünschten Ausdrücken entfernt worden.",
	'textregex-block-message' => "Phrase '''$1''' wurde zu den unerwünschten Ausdrücken hinzugefügt.",
	'textregex-regex-block' => 'Zu sperrende Phrase:',
	'textregex-submit-regex' => 'Phrase hinzufügen',
	'textregex-empty-regex' => 'Gib eine korrekte Phrase zum Sperren an.',
	'textregex-invalid-regex' => 'Ungültiger regulärer Ausdruck.',
	'textregex-already-added' => '„$1“ wurde bereits hinzugefügt',
	'textregex-nodata-found' => 'Keine Daten gefunden',
	'textregex-stats-record' => "Wort ''$1'' wurde von $2 auf $3 verwendet (''Kommentar: $4'')",
	'textregex-select-subpage' => 'Wähle eine Liste von Phrasen:',
	'textregex-select-default' => '-- auswählen --',
	'textregex-create-subpage' => 'oder neue Liste erstellen:',
	'textregex-select-regexlist' => 'gehe zur Liste',
	'textregex-invalid-regexid' => 'Ungültige Phrase.',
	'textregex-phrase-statistics' => "Statistiken für „'''$1'''“ Phrase (Anzahl von Aufzeichnungen: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 zurück zur Liste]',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'textregex-desc' => '[[Special:textregex/XXXX|Filtern]] Sie ungewollte Phrasen, basierend auf regulären Ausdrücken, aus geänderten Seiten aus',
	'textregex-error-unblocking' => 'Fehler bei Entsperrung ($1).
Versuchen Sie es noch einmal.',
	'textregex-empty-regex' => 'Geben Sie eine korrekte Phrase zum Sperren an.',
	'textregex-select-subpage' => 'Wählen Sie eine Liste von Phrasen:',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 wedarnê]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 istatistiki]',
	'textregex-nodata-found' => 'Melumat nêvineya',
	'textregex-select-default' => '-- weçine --',
);

/** Spanish (español)
 * @author Crazymadlover
 * @author Locos epraix
 * @author Mor
 * @author Pertile
 */
$messages['es'] = array(
	'textregex' => 'Texto de expresión regular',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtrar]] frases no deseadas en páginas editadas, basadas en expresiones regulares',
	'textregex-page-title' => 'Lista de expresiones no deseadas',
	'textregex-error-unblocking' => 'Error al desbloquear ($1).
Por favor intente nuevamente.',
	'textregex-currently-blocked' => "'''Frases actualmente bloqueadas:'''",
	'textregex_nocurrently-blocked' => 'No se encontraron frases bloqueada',
	'textregex-addedby-user' => 'agregado por $1 en $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 quitar]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 estadísticas]',
	'textregex-unblock-succ' => 'Desbloqueo exitoso',
	'textregex-block-succ' => 'Bloqueo exitoso',
	'textregex-unblock-message' => "La frase '''$1''' ha sido eliminada de las expresiones indeseadas.",
	'textregex-block-message' => "Frase '''$1''' ha sido agregado a las expresiones indeseadas.",
	'textregex-regex-block' => 'Frase a bloquear:',
	'textregex-submit-regex' => 'Agregar frase',
	'textregex-empty-regex' => 'Dar una frase apropiada para bloquear.',
	'textregex-invalid-regex' => 'Expresión regular inválida.',
	'textregex-already-added' => '"$1" ya esta agregada',
	'textregex-nodata-found' => 'Sin datos encontrados',
	'textregex-stats-record' => "la palabra ''$1'' fue usada por $2 en $3 (''comentario: $4'')",
	'textregex-select-subpage' => 'Seleccione una de las listas de frases:',
	'textregex-select-default' => '-- seleccionar --',
	'textregex-create-subpage' => 'o crear nueva lista:',
	'textregex-select-regexlist' => 'ir a la lsita',
	'textregex-invalid-regexid' => 'Frase inválida',
	'textregex-phrase-statistics' => "Estadísticas de \"'''\$1'''\"frase (número de registros: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 regresar a la lista]',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Silvonen
 */
$messages['fi'] = array(
	'textregex-page-title' => 'Luettelo ei-toivotuista lausekkeista',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 poista]',
	'textregex-submit-regex' => 'Lisää fraasi',
	'textregex-invalid-regex' => 'Virheellinen säännöllinen lauseke.',
	'textregex-select-default' => '-- valitse --',
	'textregex-create-subpage' => 'tai luo uusi luettelo:',
	'textregex-select-regexlist' => 'siirry luetteloon',
	'textregex-invalid-regexid' => 'Virheellinen fraasi.',
);

/** French (français)
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
	'textregex-unblock-succ' => 'Le déblocage a réussi',
	'textregex-block-succ' => 'Le blocage a réussi',
	'textregex-unblock-message' => "La phrase '''$1''' a été supprimée des expressions indésirables.",
	'textregex-block-message' => "La phrase '''$1''' a été ajoutée aux expressions indésirables.",
	'textregex-regex-block' => 'Expression rationnelle à bloquer :',
	'textregex-submit-regex' => 'Ajouter une expression rationnelle',
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

/** Galician (galego)
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
	'textregex-unblock-succ' => 'O desbloqueo tivo éxito',
	'textregex-block-succ' => 'O bloqueo tivo éxito',
	'textregex-unblock-message' => "A frase \"'''\$1'''\" eliminouse das expresións non desexadas.",
	'textregex-block-message' => "A frase \"'''\$1'''\" engadiuse ás expresións non desexadas.",
	'textregex-regex-block' => 'Expresión regular a bloquear:',
	'textregex-submit-regex' => 'Engadir unha expresión regular',
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
	'textregex-return-mainpage' => '[{{SERVER}}$1 volver á lista]',
);

/** Hungarian (magyar)
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'textregex' => 'Szövegbeli regex',
	'textregex-desc' => 'Nem kívánt kifejezések [[Special:textregex/XXXX|szűrése]] a szerkesztett oldalakon, reguláris kifejezések alkalmazásával',
	'textregex-page-title' => 'Nemkívánatos kifejezések listája',
	'textregex-error-unblocking' => 'Hiba történt a(z) ($1) blokkolásának megszüntetése közben.
Próbáld meg újra.',
	'textregex-currently-blocked' => "'''Jelenleg blokkolt kifejezések:'''",
	'textregex_nocurrently-blocked' => 'Nem találhatóak blokkolt kifejezések',
	'textregex-addedby-user' => 'hozzáadta $1 ekkor: $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 eltávolítás]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statisztikák]',
	'textregex-unblock-succ' => 'A blokk feloldása sikeres',
	'textregex-block-succ' => 'A blokk sikeres',
	'textregex-unblock-message' => "A(z) '''$1''' kifejezést eltávolítottuk a nemkívánatos kifejezések közül.",
	'textregex-block-message' => "A(z) '''$1''' kifejezés bekerült a nemkívánatos kifejezések közé.",
	'textregex-regex-block' => 'Blokkolandó kifejezés:',
	'textregex-submit-regex' => 'Reguláris kifejezés hozzáadása',
	'textregex-empty-regex' => 'Adj meg egy megfelelő blokkolandó kifejezést.',
	'textregex-invalid-regex' => 'Érvénytelen reguláris kifejezés.',
	'textregex-already-added' => '„$1” már hozzáadva',
	'textregex-nodata-found' => 'Nem található adat',
	'textregex-stats-record' => "a(z) ''$1'' szót $2 használta a(z) $3 lapon (''megjegyzés: $4'')",
	'textregex-select-subpage' => 'Válassz egyet a reguláris kifejezések listájából:',
	'textregex-select-default' => '–– kiválasztás ––',
	'textregex-create-subpage' => 'vagy új lista készítése:',
	'textregex-select-regexlist' => 'ugrás a listára',
	'textregex-invalid-regexid' => 'Érvénytelen reguláris kifejezés azonosító',
	'textregex-phrase-statistics' => "Statisztikák a(z) \"'''\$1'''\" kifejezésre (előfordulások száma: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 visszatérés a listához]',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'textregex' => 'Regex texto',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtrar]] phrases indesirabile in paginas modificate, a base de expressiones regular',
	'textregex-page-title' => 'Lista de expressiones indesirabile',
	'textregex-error-unblocking' => 'Error durante le disblocada ($1). Proba lo de novo.',
	'textregex-currently-blocked' => "'''Phrases actualmente blocate:'''",
	'textregex_nocurrently-blocked' => 'Nulle phrase blocate trovate',
	'textregex-addedby-user' => 'addite per $1 a $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 remover]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statisticas]',
	'textregex-unblock-succ' => 'Disblocada succedite',
	'textregex-block-succ' => 'Blocada succedite',
	'textregex-unblock-message' => "Le phrase '''$1''' ha essite removite del expressiones indesirabile.",
	'textregex-block-message' => "Le phrase '''$1''' ha essite addite al phrases indesirabile.",
	'textregex-regex-block' => 'Phrase a blocar:',
	'textregex-submit-regex' => 'Adder phrase',
	'textregex-empty-regex' => 'Da un phrase appropriate a blocar.',
	'textregex-invalid-regex' => 'Regex invalide.',
	'textregex-already-added' => '"$1" ha ja essite addite',
	'textregex-nodata-found' => 'Nulle datos trovate',
	'textregex-stats-record' => "le parola ''$1'' esseva usate per $2 le $3 (''commento: $4'')",
	'textregex-select-subpage' => 'Selige un phrase del lista:',
	'textregex-select-default' => '-- seliger --',
	'textregex-create-subpage' => 'o crea un nove lista:',
	'textregex-select-regexlist' => 'ir al lista',
	'textregex-invalid-regexid' => 'Phrase invalide.',
	'textregex-phrase-statistics' => "Statisticas pro le phrase '''$1''' (numero de registros: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 retornar al lista]',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 hapus]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistik]',
	'textregex-unblock-succ' => 'Pembukaan blokir berhasil',
	'textregex-block-succ' => 'Pemblokiran berhasil',
	'textregex-select-default' => '-- pilih --',
);

/** Japanese (日本語)
 * @author Naohiro19
 * @author Shirayuki
 */
$messages['ja'] = array(
	'textregex' => 'テキストの正規表現',
	'textregex-currently-blocked' => "'''現在投稿ブロックされているフレーズ:'''",
	'textregex-regex-block' => 'ブロックするフレーズ:',
	'textregex-submit-regex' => 'フレーズを追加',
	'textregex-already-added' => '"$1" は追加済みです',
	'textregex-select-default' => '-- 選択 --',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'textregex-select-default' => '-- ußwähle --',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'textregex-page-title' => 'Lëscht vun den onerwënschten Ausdréck',
	'textregex_nocurrently-blocked' => 'Keng gespaarte Phrase fonnt',
	'textregex-nodata-found' => 'Keng Date fonnt',
	'textregex-select-default' => '-- eraussichen --',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'textregex' => 'Регуларен израз за текст',
	'textregex-desc' => '[[Special:textregex/XXXX|Филтрирање]] на непожелни изрази во уредуваните страници, на основа на регуларни изрази',
	'textregex-page-title' => 'Список на непожелни изрази',
	'textregex-error-unblocking' => 'Грешка при одблокирањето ($1). Обидете се повторно.',
	'textregex-currently-blocked' => "'''Моментално блокирани изрази:'''",
	'textregex_nocurrently-blocked' => 'Нема пронајдено блокирани изрази',
	'textregex-addedby-user' => 'додадено од $1 на $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 отстрани]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статистики]',
	'textregex-unblock-succ' => 'Одблокирањето успеа',
	'textregex-block-succ' => 'Блокирањето успеа',
	'textregex-unblock-message' => "Изразот '''$1''' е отстранет од списокот на непожелни изрази.",
	'textregex-block-message' => "Изразот '''$1''' е додаден во списокот на непожелни изрази.",
	'textregex-regex-block' => 'Регуларен израз за блокирање:',
	'textregex-submit-regex' => 'Додај регуларен израз',
	'textregex-empty-regex' => 'Назначете правилен регуларен израз за блокирање.',
	'textregex-invalid-regex' => 'Неважечки регуларен израз.',
	'textregex-already-added' => '„$1“ е веќе додадено',
	'textregex-nodata-found' => 'Нема пронајдено податоци',
	'textregex-stats-record' => "зборот ''$1'' е употребен од $2 на $3 (''коментар: $4'')",
	'textregex-select-subpage' => 'Одберете еден регуларен израз од списокот:',
	'textregex-select-default' => '-- одберете --',
	'textregex-create-subpage' => 'или создајте нов список:',
	'textregex-select-regexlist' => 'оди на списокот',
	'textregex-invalid-regexid' => 'НеважечкА назнака на регуларниот израз.',
	'textregex-phrase-statistics' => "Статистики за изразот '''$1''' (број на записи: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 назад кон списокот]',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'textregex' => 'Ungkapan nalar (regex) teks',
	'textregex-desc' => '[[Special:textregex/XXXX|Tapiskan]] ungkapan-ungkapan yang tidak dikehendaki dalam laman yang disunting, berdasarkan ungkapan nalar',
	'textregex-page-title' => 'Senarai ungkapan yang tidak diingini',
	'textregex-error-unblocking' => 'Ralat ketika menyahsekat ($1).
Sila cuba lagi.',
	'textregex-currently-blocked' => "'''Ungkapan yang disekat sekarang:'''",
	'textregex_nocurrently-blocked' => 'Ungkapan yang disekat tidak dijumpai',
	'textregex-addedby-user' => 'ditambahkan oleh $1 pada $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 buang]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistik]',
	'textregex-unblock-succ' => 'Sekatan dapat ditarik balik',
	'textregex-block-succ' => 'Dapat disekat',
	'textregex-unblock-message' => "Ungkapan '''$1''' telah digugurkan daripada ungkapan yang tidak diingini.",
	'textregex-block-message' => "Ungkapan '''$1''' telah ditambahkan ke dalam ungkapan yang tidak diingini.",
	'textregex-regex-block' => 'Ungkapan untuk disekat:',
	'textregex-submit-regex' => 'Tambahkan ungkapan',
	'textregex-empty-regex' => 'Nyatakan ungkapan yang betul untuk disekat.',
	'textregex-invalid-regex' => 'Ungkapan nalar tidak sah.',
	'textregex-already-added' => '"$1" sudah ditambahkan',
	'textregex-nodata-found' => 'Data tidak dijumpai',
	'textregex-stats-record' => "perkataan ''$1'' digunakan oleh $2 di $3 (''ulasan: $4'')",
	'textregex-select-subpage' => 'Pilih satu senarai ungkapan:',
	'textregex-select-default' => '-- pilih --',
	'textregex-create-subpage' => 'atau cipta senarai baru:',
	'textregex-select-regexlist' => 'pergi ke senarai',
	'textregex-invalid-regexid' => 'Ungkapan tidak sah.',
	'textregex-phrase-statistics' => "Statistik untuk ungkapan \"'''\$1'''\" (bilangan rekod: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 kembali ke senarai]',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'textregex' => 'Regulære uttrykk for tekst',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtrer]] ut uønskede fraser fra redigerte sider basert på regulære uttrykk',
	'textregex-page-title' => 'Liste over uønskede uttrykk',
	'textregex-error-unblocking' => 'Feil ved oppheving av blokkering ($1).
Prøv igjen.',
	'textregex-currently-blocked' => "'''Nåværende blokkerte fraser:'''",
	'textregex_nocurrently-blocked' => 'Ingen blokkerte fraser funnet',
	'textregex-addedby-user' => 'lagt til av $1, $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 fjern]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistikk]',
	'textregex-unblock-succ' => 'Oppheving av blokkering lyktes',
	'textregex-block-succ' => 'Blokkering lyktes',
	'textregex-unblock-message' => "Frasen '''$1''' har blitt fjernet fra uønskede uttrykk.",
	'textregex-block-message' => "Frasen '''$1''' har blitt lagt til uønskede uttrykk.",
	'textregex-regex-block' => 'Frase som skal blokkeres:',
	'textregex-submit-regex' => 'Legg til frase',
	'textregex-empty-regex' => 'Oppgi en ordentlig frase som skal blokkeres.',
	'textregex-invalid-regex' => 'Ugyldig regulært uttrykk.',
	'textregex-already-added' => '«$1» er allerede lagt til',
	'textregex-nodata-found' => 'Ingen data funnet',
	'textregex-stats-record' => "ordet ''$1'' ble brukt av $2, $3 (''kommentar: $4'')",
	'textregex-select-subpage' => 'Velg en liste med fraser:',
	'textregex-select-default' => '-- velg --',
	'textregex-create-subpage' => 'eller opprett en ny liste:',
	'textregex-select-regexlist' => 'gå til listen',
	'textregex-invalid-regexid' => 'Ugyldig frase.',
	'textregex-phrase-statistics' => "Statistikk for «'''$1'''»-frasen (antall treff: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 gå tilbake til listen]',
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
	'textregex-unblock-succ' => 'De deblokkade is uitgevoerd',
	'textregex-block-succ' => 'De blokkade is uitgevoerd',
	'textregex-unblock-message' => "Het tekstdeel '''$1''' is verwijderd van de lijst met ongewenste teksten.",
	'textregex-block-message' => "Het tekstdeel '''$1''' is toegevoegd aan de lijst met ongewenste teksten.",
	'textregex-regex-block' => 'Te blokkeren reguliere expressie:',
	'textregex-submit-regex' => 'Reguliere expressie toevoegen',
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

/** Polish (polski)
 * @author Sovq
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'textregex' => 'Wyrażenia regularne dla tekstu',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtr]] usuwający niechciane frazy z edytowanych stron, oparty o wyrażenia regularne',
	'textregex-page-title' => 'Lista niepożądanych wyrażeń',
	'textregex-error-unblocking' => 'Błąd odblokowania ($1). 
Spróbuj jeszcze raz.',
	'textregex-currently-blocked' => "'''Obecnie zablokowane wyrażenia:'''",
	'textregex_nocurrently-blocked' => 'Nie znaleziono zablokowanych wyrażeń',
	'textregex-addedby-user' => 'dodane przez $1 o $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 usuń]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statystyki]',
	'textregex-unblock-succ' => 'Odblokowano',
	'textregex-block-succ' => 'Zablokowano',
	'textregex-unblock-message' => "Z niepożądanych wyrażeń usunięto '''$1'''.",
	'textregex-block-message' => "Do niepożądanych wyrażeń dodano '''$1'''.",
	'textregex-regex-block' => 'Wyrażenie do zablokowania',
	'textregex-submit-regex' => 'Dodaj wyrażenie',
	'textregex-empty-regex' => 'Podaj wyrażenie do zablokowania.',
	'textregex-invalid-regex' => 'Nieprawidłowe wyrażenie regularne.',
	'textregex-already-added' => '„$1” jest już dodane',
	'textregex-nodata-found' => 'Nie odnaleziono danych',
	'textregex-stats-record' => "słowo ''$1'' zostało użyte przez $2 o $3 (''komentarz – $4'')",
	'textregex-select-subpage' => 'Wybierz jedną z list wyrażeń',
	'textregex-select-default' => '– wybierz –',
	'textregex-create-subpage' => 'lub utwórz nową listę',
	'textregex-select-regexlist' => 'przejdź do listy',
	'textregex-invalid-regexid' => 'Nieprawidłowe wyrażenie.',
	'textregex-phrase-statistics' => "Statystyki dla wyrażenia „'''$1'''” (liczba rekordów: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 wróć do listy]',
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
	'textregex-unblock-succ' => 'Dësblocagi andàit bin',
	'textregex-block-succ' => 'Blocagi andàit bin',
	'textregex-unblock-message' => "La fras '''$1''' a l'é stàita gavà da j'espression pa vorsùe.",
	'textregex-block-message' => "La fras '''$1''' a l'é stàita giontà a j'espression pa vorsùe.",
	'textregex-regex-block' => "Fras d'espression regolar da bloché:",
	'textregex-submit-regex' => 'Gionta espression regolar',
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

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'textregex-select-default' => '-- ټاکل --',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'textregex' => 'Expressões regulares em textos',
	'textregex-desc' => "[[Special:textregex/XXXX|Filtrar]] expressões indesejadas nas edições de páginas, usando expressões regulares ''(regex)''",
	'textregex-page-title' => 'Lista das expressões indesejadas',
	'textregex-error-unblocking' => 'Ocorreu um erro no desbloqueio de ($1).
Tente outra vez.',
	'textregex-currently-blocked' => "'''Expressões bloqueadas nesta altura:'''",
	'textregex_nocurrently-blocked' => 'Não foram encontradas expressões bloqueadas',
	'textregex-addedby-user' => 'adicionada por $1 a $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 remover]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 estatísticas]',
	'textregex-unblock-succ' => 'Desbloqueada',
	'textregex-block-succ' => 'Bloqueada',
	'textregex-unblock-message' => "A expressão '''$1''' foi removida das expressões indesejadas.",
	'textregex-block-message' => "A expressão '''$1''' foi adicionada às expressões indesejadas.",
	'textregex-regex-block' => 'Expressão a bloquear:',
	'textregex-submit-regex' => 'Adicionar expressão',
	'textregex-empty-regex' => 'Introduza uma expressão correcta para bloquear:',
	'textregex-invalid-regex' => 'Expressão regular inválida.',
	'textregex-already-added' => '"$1" já foi adicionada',
	'textregex-nodata-found' => 'Não foram encontrados dados',
	'textregex-stats-record' => "a palavra ''$1'' foi usada por $2 a $3 (''comentário: $4'')",
	'textregex-select-subpage' => 'Seleccionar uma lista de expressões:',
	'textregex-select-default' => '-- seleccionar --',
	'textregex-create-subpage' => 'ou criar uma lista nova:',
	'textregex-select-regexlist' => 'ir para a lista',
	'textregex-invalid-regexid' => 'Expressão inválida.',
	'textregex-phrase-statistics' => "Estatísticas para a expressão \"'''\$1'''\" (número de registos: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 voltar à lista]',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Jesielt
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'textregex' => 'Texto regex (expressões regulares)',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtrar]] frases indesejadas em páginas editadas, baseado em expressões regulares',
	'textregex-page-title' => 'Lista de expressões indesejadas',
	'textregex-error-unblocking' => 'Erro ao desbloquear ($1).
Tente novamente.',
	'textregex-currently-blocked' => "'''Frases atualmente bloqueadas:'''",
	'textregex_nocurrently-blocked' => 'Nenhuma frase bloqueada encontrada',
	'textregex-addedby-user' => 'adicionado por $1 em $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 remover]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 estatísticas]',
	'textregex-unblock-succ' => 'Desbloqueio efetuado',
	'textregex-block-succ' => 'Bloqueio efetuado',
	'textregex-unblock-message' => "A frase '''$1''' foi removida da list ade expressões indesejadas.",
	'textregex-block-message' => "A frase '''$1''' foi adicionada à lista de expressões indesejadas.",
	'textregex-regex-block' => 'Frase a bloquear:',
	'textregex-submit-regex' => 'Adicionar frase',
	'textregex-empty-regex' => 'Forneça uma frase a bloquear.',
	'textregex-invalid-regex' => 'Regex (expressão regular) inválida.',
	'textregex-already-added' => '"$1" já está bloqueado',
	'textregex-nodata-found' => 'Nenhum dado encontrado',
	'textregex-stats-record' => "A palavra ''$1'' foi usada por $2 em $3 (''comentário: $4'')",
	'textregex-select-subpage' => 'Selecione uma da lista de frases:',
	'textregex-select-default' => '-- selecionar --',
	'textregex-create-subpage' => 'ou crie uma nova lista:',
	'textregex-select-regexlist' => 'ir para a lista',
	'textregex-invalid-regexid' => 'Frase inválida.',
	'textregex-phrase-statistics' => "Estatísticas para a frase \"'''\$1'''\" (número de gravações: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 retornar à lista]',
);

/** Russian (русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'textregex' => 'Регулярные выражения для текста',
	'textregex-desc' => '[[Special:textregex/XXXX|Фильтрация]] фраз на редактируемых страницах, основанная на регулярных выражениях',
	'textregex-page-title' => 'Список нежелательных выражений',
	'textregex-error-unblocking' => 'Ошибка при разблокировании ($1). Попробуйте ещё раз.',
	'textregex-currently-blocked' => "'''В настоящий момент блокируются фразы:'''",
	'textregex_nocurrently-blocked' => 'Заблокированные фразы не найдены',
	'textregex-addedby-user' => 'добавлена $1 в $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 удалить]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статистика]',
	'textregex-unblock-succ' => 'Разблокировка выполнена успешно',
	'textregex-block-succ' => 'Блокировка выполнена успешно',
	'textregex-unblock-message' => "Фраза '''$1''' удалена из списка нежелательных регулярных выражений.",
	'textregex-block-message' => "Фраза '''$1''' добавлена в список нежелательных регулярных выражений.",
	'textregex-regex-block' => 'Блокировать фразу:',
	'textregex-submit-regex' => 'Добавить фразу',
	'textregex-empty-regex' => 'Задайте подходящую фразу для блокировки.',
	'textregex-invalid-regex' => 'Неверное регулярное выражение.',
	'textregex-already-added' => '«$1» уже добавлена',
	'textregex-nodata-found' => 'Ничего не найдено',
	'textregex-stats-record' => "слово ''$1'' использовано $2 в $3 (''комментарий: $4'')",
	'textregex-select-subpage' => 'Выберите из списка фраз:',
	'textregex-select-default' => '-- выбрать --',
	'textregex-create-subpage' => 'или создайте новый список:',
	'textregex-select-regexlist' => 'перейти к списку',
	'textregex-invalid-regexid' => 'Неверное фраза.',
	'textregex-phrase-statistics' => "Статистика для фразы '''$1''' (число записей: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 Возврат к списку]',
);

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'textregex-page-title' => 'Списак непожељних израза',
	'textregex-currently-blocked' => "'''Забрањене фразе:'''",
	'textregex_nocurrently-blocked' => 'Нема забрањених фраза',
	'textregex-addedby-user' => 'додао/-ла $1 у $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 уклони]',
	'textregex-unblock-succ' => 'Приступ је враћен',
	'textregex-block-succ' => 'Блокирање је успело',
	'textregex-unblock-message' => "Израз '''$1''' је уклоњен са списка непожељних фраза.",
	'textregex-block-message' => "Израз '''$1''' је додат на списак непожељних фраза.",
	'textregex-regex-block' => 'Забрањена фраза:',
	'textregex-submit-regex' => 'Додај регуларни израз',
	'textregex-empty-regex' => 'Унесите фразу коју желите да забраните.',
	'textregex-already-added' => '„$1“ је већ додато',
	'textregex-nodata-found' => 'Подаци нису пронађени',
	'textregex-select-subpage' => 'Изаберите један од спискова фраза:',
	'textregex-select-default' => 'изабери',
	'textregex-create-subpage' => 'или направите нови списак:',
	'textregex-select-regexlist' => 'пређи на списак',
	'textregex-invalid-regexid' => 'Неисправна фраза.',
	'textregex-phrase-statistics' => "Статистика за „'''$1'''“  фразу (број појављивања: $2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 назад на списак]',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'textregex' => 'Reguljära uttryck för text',
	'textregex-desc' => '[[Special:textregex/XXXX|Filtrera ut]] oönskade fraser i redigerade sidor, baserade på reguljära uttryck',
	'textregex-page-title' => 'Lista över oönskade uttryck',
	'textregex-error-unblocking' => 'Fel med avblockeringen ($1).
Försök igen.',
	'textregex-currently-blocked' => "'''Nuvarande blockerande fraser:'''",
	'textregex_nocurrently-blocked' => 'Inga blockerade fraser hittades',
	'textregex-addedby-user' => 'lades till av $1 den $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 ta bort]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 statistik]',
	'textregex-unblock-succ' => 'Avblockering lyckades',
	'textregex-block-succ' => 'Blockering lyckades',
	'textregex-unblock-message' => "Fras '''$1''' har tagits bort från de oönskade uttrycken.",
	'textregex-block-message' => "Fras '''$1''' ha lagts till de oönskade uttrycken.",
	'textregex-regex-block' => 'Fras att blockera:',
	'textregex-submit-regex' => 'Lägg till fras',
	'textregex-empty-regex' => 'Ge en bra fras att blockera.',
	'textregex-invalid-regex' => 'Ogiltig regex.',
	'textregex-already-added' => '"$1" är redan tillagd',
	'textregex-nodata-found' => 'Hittade ingen data',
	'textregex-stats-record' => "ordet ''$1'' användes av $2 den $3 (''kommentar: $4'')",
	'textregex-select-subpage' => 'Välj en lista av fraser:',
	'textregex-select-default' => '-- välj --',
	'textregex-create-subpage' => 'eller skapa en ny lista:',
	'textregex-select-regexlist' => 'gå till listan',
	'textregex-invalid-regexid' => 'Ogiltig fras.',
	'textregex-phrase-statistics' => "Statistik för frasen \"'''\$1'''\" (antal poster: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 gå tillbaka till listan]',
);

/** Tetum (tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 hasai]',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'textregex' => 'Iteks ang regex',
	'textregex-desc' => '[[Special:textregex/XXXX|Salain]] palabas ang mga pariralang hindi nais na nasa loob ng mga pahinang binago, batay sa pangkaraniwang mga pagsasaad.',
	'textregex-page-title' => 'Talaan ng hindi nais na mga pagsasaad',
	'textregex-error-unblocking' => 'Hindi paghaharang ng kamalian  ($1).
Subukan uli.',
	'textregex-currently-blocked' => "'''Pangkasalukuyang hinahadlangang mga parirala:'''",
	'textregex_nocurrently-blocked' => 'Walang natagpuang hinadlangang mga parirala',
	'textregex-addedby-user' => 'idinagdag ni $1 noong $2',
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 tanggalin]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 estadistika]',
	'textregex-unblock-succ' => 'Nagtagumpay ang pagtanggal ng paghadlang',
	'textregex-block-succ' => 'Nagtagumpay ang paghadlang',
	'textregex-unblock-message' => "Tinanggal ang pariralang '''$1''' mula sa hindi nais na mga pagsasaad.",
	'textregex-block-message' => "Idinagdag ang pariralang '''$1''' sa hindi nais na mga pagsasaad.",
	'textregex-regex-block' => 'Pariralang hahadlangan:',
	'textregex-submit-regex' => 'Idagdag ang parirala',
	'textregex-empty-regex' => 'Magbigay ng isang angkop na pariralang hahadlangan.',
	'textregex-invalid-regex' => 'Hindi tanggap na regex.',
	'textregex-already-added' => 'Naidagdag na ang "$1"',
	'textregex-nodata-found' => 'Walang natagpuang dato',
	'textregex-stats-record' => "ang salitang ''$1'' ay ginamit ni $2 noong $3 (''puna: $4'')",
	'textregex-select-subpage' => 'Pumili ng isa sa talaan ng mga parirala:',
	'textregex-select-default' => '-- pumili --',
	'textregex-create-subpage' => 'o lumikha ng bagong talaan:',
	'textregex-select-regexlist' => 'pumunta sa talaan',
	'textregex-invalid-regexid' => 'Hindi tanggap na parirala.',
	'textregex-phrase-statistics' => "Estadistika para sa pariralang \"'''\$1'''\" (bilang ng mga talaan: \$2)",
	'textregex-return-mainpage' => '[{{SERVER}}$1 bumalik sa talaan]',
);

/** Ukrainian (українська)
 * @author Тест
 */
$messages['uk'] = array(
	'textregex-remove-url' => '[{{SERVER}}$1&id=$2 вилучити]',
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 статистика]',
	'textregex-submit-regex' => 'Додати фразу',
	'textregex-select-regexlist' => 'перейти до списку',
	'textregex-return-mainpage' => '[{{SERVER}}$1 повернутися до списку]',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'textregex-stats-url' => '[{{SERVER}}$1&id=$2 סטאַטיסטיק]',
);

/** Simplified Chinese (‪中文（简体）‬)
 * @author Dimension
 */
$messages['zh-hans'] = array(
	'textregex-select-default' => '-- 选择 --',
);

