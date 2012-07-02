<?php
/**
 * Language file for Semantic Forms Inputs
 */

$messages = array();

$messages['en'] = array(
	'semanticformsinputs-desc' => 'Additional input types for [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Wrong format.',
	'semanticformsinputs-close' => 'Close',
	'semanticformsinputs-prev' => 'Previous',
	'semanticformsinputs-next' => 'Next',
	'semanticformsinputs-today' => 'Today',
	'semanticformsinputs-dateformatlong' => 'd MM yy', // see http://docs.jquery.com/UI/Datepicker/formatDate
	'semanticformsinputs-dateformatshort' => 'dd/mm/yy', // see http://docs.jquery.com/UI/Datepicker/formatDate
	'semanticformsinputs-firstdayofweek' => '0', // 0 - sunday, 1 - monday...
	'semanticformsinputs-malformedregexp' => 'Malformed regular expression ($1).',

	'semanticformsinputs-datepicker-dateformat' => 'The date format string. See the [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters online documentation] for more information.',
	'semanticformsinputs-datepicker-weekstart' => 'The first day of the week (0 - Sunday, 1 - Monday, ...).',
	'semanticformsinputs-datepicker-firstdate' => 'The first date that can be chosen (in yyyy/mm/dd format).',
	'semanticformsinputs-datepicker-lastdate' => 'The last date that can be chosen (in yyyy/mm/dd format).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'A list of days that can not be selected (e.g. weekend: 6, 0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'A list of days that shall appear highlighted (e.g. weekend: 6, 0).',
	'semanticformsinputs-datepicker-disabledates' => 'A comma-separated list of disabled dates/date ranges (dates in yyyy/mm/dd format, ranges in yyyy/mm/dd-yyyy/mm/dd format).',
	'semanticformsinputs-datepicker-highlightdates' => 'A comma-separated list of dates/date ranges that shall appear highlighted (dates in yyyy/mm/dd format, ranges in yyyy/mm/dd-yyyy/mm/dd format).',
	'semanticformsinputs-datepicker-showweeknumbers' => 'Should week numbers be shown left of the week?',
	'semanticformsinputs-datepicker-enableinputfield' => 'Should the user be able to fill the input field directly or only via the date picker?',
	'semanticformsinputs-datepicker-showresetbutton' => 'Should a reset button be shown? This is the only way for the user to erase the input field if it is disabled for direct input.',
	
	'semanticformsinputs-timepicker-mintime' => 'The earliest time to show. Format: hh:mm',
	'semanticformsinputs-timepicker-maxtime' => 'The latest time to show. Format: hh:mm',
	'semanticformsinputs-timepicker-interval' => 'Interval between minutes. Number between 1 and 60.',
	'semanticformsinputs-timepicker-enableinputfield' => 'Should the user be able to fill the input field directly or only via the date picker?',
	'semanticformsinputs-timepicker-showresetbutton' => 'Should a reset button be shown? This is the only way for the user to erase the input field if it is disabled for direct input.',
	
	'semanticformsinputs-regexp-regexp' => 'The regular expression the input has to match to be valid. This must be given including the slashes! Defaults to "/.*/", i.e. any value.',
	'semanticformsinputs-regexp-basetype' => 'The base type to be used. May be any input type that generates an html form element of type input or select (e.g. text, listbox, datepicker) or another regexp. Defaults to "text".',
	'semanticformsinputs-regexp-baseprefix' => 'Prefix for the parameters of the base type.',
	'semanticformsinputs-regexp-orchar' => 'The OR-character to be used in the regular expression instead of |. Defaults to "!"',
	'semanticformsinputs-regexp-inverse' => 'If set, the input must NOT match the regular expression to be valid. I.e. the regular expression is inverted.',
	'semanticformsinputs-regexp-message' => 'The error message to be displayed if the match fails. Defaults to "Wrong format!" (or equivalent in the current locale)',

	'semanticformsinputs-menuselect-structure' => 'The menu structure as an unordered list.',
	'semanticformsinputs-menuselect-enableinputfield' => 'Should the user be able to fill the input field directly?',
	);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author F.trott
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'semanticformsinputs-desc' => '{{desc}}',
	'semanticformsinputs-close' => '{{Identical|Close}}',
	'semanticformsinputs-prev' => '{{Identical|Previous}}',
	'semanticformsinputs-next' => '{{Identical|Next}}',
	'semanticformsinputs-dateformatlong' => "{{doc-important|This is a machine-readable date format string!| <br>It is used by a function to format a date. It will not be read by a human user. Do not translate each letter literally! Instead insert the date format for your language using the english-based letters. See http://docs.jquery.com/UI/Datepicker/formatDate }}

{{doc-important|This is an ''optional'' message. Do not translate it, if it would remain unchanged in your language. }}",
	'semanticformsinputs-dateformatshort' => "{{doc-important|This is a machine-readable date format string!| <br>It is used by a function to format a date. It will not be read by a human user. Do not translate each letter literally! Instead insert the date format for your language using the english-based letters. See http://docs.jquery.com/UI/Datepicker/formatDate }}

{{doc-important|This is an ''optional'' message. Do not translate it, if it would remain unchanged in your language. }}",
	'semanticformsinputs-firstdayofweek' => '{{optional}}
0 - sunday, 1 - monday...',
	'semanticformsinputs-malformedregexp' => 'An error message.',

	'semanticformsinputs-datepicker-dateformat' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-weekstart' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-firstdate' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-lastdate' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-disabledates' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-highlightdates' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-showweeknumbers' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-enableinputfield' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-datepicker-showresetbutton' => 'This is a help text for the Special:CreateForm page.',
	
	'semanticformsinputs-timepicker-mintime' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-timepicker-maxtime' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-timepicker-interval' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-timepicker-enableinputfield' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-timepicker-showresetbutton' => 'This is a help text for the Special:CreateForm page.',
	
	'semanticformsinputs-regexp-regexp' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-regexp-basetype' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-regexp-baseprefix' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-regexp-orchar' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-regexp-inverse' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-regexp-message' => 'This is a help text for the Special:CreateForm page.',

	'semanticformsinputs-menuselect-structure' => 'This is a help text for the Special:CreateForm page.',
	'semanticformsinputs-menuselect-enableinputfield' => 'This is a help text for the Special:CreateForm page.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'semanticformsinputs-desc' => 'Ekstra invoertipes vir [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Verkeerde formaat.',
	'semanticformsinputs-close' => 'Sluit',
	'semanticformsinputs-prev' => 'Vorige',
	'semanticformsinputs-next' => 'Volgende',
	'semanticformsinputs-today' => 'Vandag',
);

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = array(
	'semanticformsinputs-next' => 'التالي',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'semanticformsinputs-close' => 'ܣܟܘܪ',
	'semanticformsinputs-prev' => 'ܩܕܡ',
	'semanticformsinputs-next' => 'ܒܬܪ',
	'semanticformsinputs-today' => 'ܝܘܡܢܐ',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'semanticformsinputs-desc' => "Más tribes d'entrada pa los [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formularios Semánticos]",
	'semanticformsinputs-wrongformat' => 'Formatu incorreutu.',
	'semanticformsinputs-close' => 'Zarrar',
	'semanticformsinputs-prev' => 'Anterior',
	'semanticformsinputs-next' => 'Siguiente',
	'semanticformsinputs-today' => 'Güei',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'semanticformsinputs-next' => 'Növbəti',
	'semanticformsinputs-today' => 'Bu gün',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'semanticformsinputs-desc' => 'Дадатковыя тыпы ўводу для [http://www.mediawiki.org/wiki/Extension:Semantic_Forms сэмантычных формаў]',
	'semanticformsinputs-wrongformat' => 'Няслушны фармат.',
	'semanticformsinputs-close' => 'Закрыць',
	'semanticformsinputs-prev' => 'Папярэдняе',
	'semanticformsinputs-next' => 'Наступнае',
	'semanticformsinputs-today' => 'Сёньня',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'semanticformsinputs-wrongformat' => 'Грешен формат.',
	'semanticformsinputs-close' => 'Затваряне',
	'semanticformsinputs-today' => 'Днес',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'semanticformsinputs-wrongformat' => 'ভুল বিন্যাস',
	'semanticformsinputs-close' => 'বন্ধ',
	'semanticformsinputs-prev' => 'পূর্ববর্তী',
	'semanticformsinputs-next' => 'পরবর্তী',
	'semanticformsinputs-today' => 'আজ',
);

/** Breton (Brezhoneg)
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'semanticformsinputs-desc' => 'Doareoù moned ouzhpenn evit [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Furmad fall.',
	'semanticformsinputs-close' => 'Serriñ',
	'semanticformsinputs-prev' => 'Kent',
	'semanticformsinputs-next' => "War-lerc'h",
	'semanticformsinputs-today' => 'Hiziv',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'semanticformsinputs-desc' => 'Dodatne vrste unosa za [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantičke forme]',
	'semanticformsinputs-wrongformat' => 'Pogrešan format.',
	'semanticformsinputs-close' => 'Zatvori',
	'semanticformsinputs-prev' => 'Prethodno',
	'semanticformsinputs-next' => 'Slijedeće',
	'semanticformsinputs-today' => 'Danas',
);

/** Catalan (Català)
 * @author Toniher
 */
$messages['ca'] = array(
	'semanticformsinputs-desc' => "Tipus d'entrada addicionals per al [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]",
	'semanticformsinputs-wrongformat' => 'Format incorrecte.',
	'semanticformsinputs-close' => 'Tanca',
	'semanticformsinputs-prev' => 'Anterior',
	'semanticformsinputs-next' => 'Següent',
	'semanticformsinputs-today' => 'Avui',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'semanticformsinputs-close' => 'Zavřít',
	'semanticformsinputs-prev' => 'Předchozí',
	'semanticformsinputs-next' => 'Další',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'semanticformsinputs-desc' => 'Ermöglicht zusätzliche Eingabearten für [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Falsches Format.',
	'semanticformsinputs-close' => 'Schließen',
	'semanticformsinputs-prev' => 'Voriger Monat',
	'semanticformsinputs-next' => 'Nächster Monat',
	'semanticformsinputs-today' => 'Heute',
	'semanticformsinputs-dateformatlong' => 'd. MM yy',
	'semanticformsinputs-dateformatshort' => 'dd.mm.yy',
	'semanticformsinputs-firstdayofweek' => '1',
	'semanticformsinputs-malformedregexp' => 'Fehlerhafter regulärer Ausdruck ($1)',
	'semanticformsinputs-datepicker-dateformat' => 'Die Zeichenfolge des Datumsformats. Siehe hierzu die [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters Online-Dokumentation] für weitere Informationen.',
	'semanticformsinputs-datepicker-weekstart' => 'Der erste Tag der Woche (0 - Sonntag, 1 - Montag, usw.)',
	'semanticformsinputs-datepicker-firstdate' => 'Das erste auswählbare Datum (im Format JJJJ/MM/TT).',
	'semanticformsinputs-datepicker-lastdate' => 'Das letzte auswählbare Datum (im Format JJJJ/MM/TT).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'Eine Liste der Tage, die nicht ausgewählt werden können (z. B. das Wochenende: 6,0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'Eine Liste der Tage, die hervorgehoben angezeigt werden sollen (z. B. das Wochenende: 6,0).',
	'semanticformsinputs-datepicker-disabledates' => 'Eine kommagetrennte Liste deaktivierter Tage/Zeiträume (Tage im Format JJJJ/MM/TT, Zeiträume im Format JJJJ/MM/TT-JJJJ/MM/TT).',
	'semanticformsinputs-datepicker-highlightdates' => 'Eine kommagetrennte Liste von Tagen/Zeiträumen, die hervorgehoben angezeigt werden sollen (Tage im Format JJJJ/MM/TT, Zeiträume im Format JJJJ/MM/TT-JJJJ/MM/TT).',
	'semanticformsinputs-datepicker-showweeknumbers' => 'Sollen die Wochennummern Links von der Woche angezeigt werden?',
	'semanticformsinputs-datepicker-enableinputfield' => 'Sollen die Benutzer die Eingabefelder direkt bearbeiten können, oder nur über die Datumsauswahl?',
	'semanticformsinputs-datepicker-showresetbutton' => 'Soll eine Schaltfläche zum Zurücksetzen angezeigt werden? Dies ist für die Benutzer die einzige Möglichkeit die Eingabe im Eingabefeld zu entfernen, sofern das direkte Bearbeiten deaktiviert wurde.',
	'semanticformsinputs-timepicker-mintime' => 'Die früheste anzuzeigende Zeit (im Format hh:mm).',
	'semanticformsinputs-timepicker-maxtime' => 'Die späteste anzuzeigende Zeit (im Format hh:mm).',
	'semanticformsinputs-timepicker-interval' => 'Der Intervall zwischen den Minuten (Zahlen zwischen 1 und 60).',
	'semanticformsinputs-timepicker-enableinputfield' => 'Sollen die Benutzer die Eingabefelder direkt bearbeiten können, oder nur über die Datumsauswahl?',
	'semanticformsinputs-timepicker-showresetbutton' => 'Soll eine Schaltfläche zum Zurücksetzen angezeigt werden? Dies ist für die Benutzer die einzige Möglichkeit die Eingabe im Eingabefeld zu entfernen, sofern das direkte Bearbeiten deaktiviert wurde.',
	'semanticformsinputs-regexp-regexp' => 'Der reguläre Ausdruck mit dem die Eingabe übereinstimmen muss, um gültig zu sein. Der Wert muss einschließlich der Schrägstriche angegeben werden. Der Standardwert ist „/.*/“ und bedeutet „alle Werte“.',
	'semanticformsinputs-regexp-basetype' => 'Der Basiseingabetyp der verwendet werden soll. Dies kann jeder Eingabetyp sein, der ein HTML-Formularelement für die Typen Eingabe oder Auswahl generieren kann (z. B. „text“, „listbox“, „datepicker“), oder ein anderer regulärer Ausdruck. Der Standardwert ist „text“.',
	'semanticformsinputs-regexp-baseprefix' => 'Das Präfix für die Parameter des Basiseingabetyps.',
	'semanticformsinputs-regexp-orchar' => 'Das OR-Zeichen, das bei regulären Ausdrücken, anstatt von „|“ verwendet werden soll. Der Standardwert ist „!“.',
	'semanticformsinputs-regexp-inverse' => 'Sofern festgelegt, darf die Eingabe nicht dem regulären Ausdruck entsprechen, um gültig zu sein. Dies bedeutet, dass der reguläre Ausdruck invertiert wird.',
	'semanticformsinputs-regexp-message' => 'Die Fehlermeldung, die angezeigt werden soll, sofern der Vergleich scheitert. Der Standardwert ist „Das Format ist falsch.“, oder das Äquivalent der zutreffenden Übersetzung.',
	'semanticformsinputs-menuselect-structure' => 'Die Menüstruktur als ungeordnete Liste.',
	'semanticformsinputs-menuselect-enableinputfield' => 'Sollen die Benutzer die Eingabefelder direkt bearbeiten können?',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'semanticformsinputs-desc' => 'Pśidatne zapódawańske typy [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Wopacny format',
	'semanticformsinputs-close' => 'Zacyniś',
	'semanticformsinputs-prev' => 'Pjerwjejšny',
	'semanticformsinputs-next' => 'Pśiducy',
	'semanticformsinputs-today' => 'Źinsa',
);

/** Spanish (Español)
 * @author Danke7
 * @author Translationista
 */
$messages['es'] = array(
	'semanticformsinputs-desc' => 'Tipos de entrada adicionales para [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formularios Semánticos]',
	'semanticformsinputs-wrongformat' => 'Formato incorrecto.',
	'semanticformsinputs-close' => 'Cerrar',
	'semanticformsinputs-prev' => 'Anterior',
	'semanticformsinputs-next' => 'Siguiente',
	'semanticformsinputs-today' => 'Hoy',
);

/** French (Français)
 * @author F.trott
 * @author Gomoko
 * @author IAlex
 */
$messages['fr'] = array(
	'semanticformsinputs-desc' => "Types d'entrées additionnelles pour [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formulaires sémantiques]",
	'semanticformsinputs-wrongformat' => 'Format erroné.',
	'semanticformsinputs-close' => 'Fermer',
	'semanticformsinputs-prev' => 'Précédent',
	'semanticformsinputs-next' => 'Suivant',
	'semanticformsinputs-today' => "Aujourd'hui",
	'semanticformsinputs-dateformatshort' => 'dd / mm / yy',
	'semanticformsinputs-datepicker-dateformat' => "La chaîne de format de date. Voyez la [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters documentation en ligne] pour plus d'information.",
	'semanticformsinputs-datepicker-weekstart' => 'Le premier jour de la semaine (0 - dimanche, 1 - lundi, ...).',
	'semanticformsinputs-datepicker-firstdate' => 'La première date qui peut être choisie (au format aaaa/mm/jj).',
	'semanticformsinputs-datepicker-lastdate' => 'La dernière date qui peut être choisie (au format aaaa/mm/jj).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'Une liste de jours qui ne peuvent pas être sélectionnés (par ex. week-end: 6, 0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'Une liste de jours qui doivent apparaître en surbrillance (par ex. week-end: 6, 0).',
	'semanticformsinputs-datepicker-disabledates' => 'Une liste séparée par des virgules de plages de date ou dates désactivées (dates au format aaaa/mm/jj, plages au format aaaa/mm/jj-aaaa/mm/jj).',
	'semanticformsinputs-datepicker-highlightdates' => 'Une liste séparée par des virgules de plages de dates ou dates qui doivent apparaître en surbrillance (dates au format aaaa/mm/jj, plages au format aaaa/mm/jj-aaaa/mm/jj).',
	'semanticformsinputs-datepicker-showweeknumbers' => 'Les numéros de semaine doivent-ils être affichés à gauche de la semaine ?',
	'semanticformsinputs-datepicker-enableinputfield' => "L'utilisateur doit-il pouvoir remplir le champ d'entrée directement ou seulement par l'intermédiaire du sélecteur de dates?",
	'semanticformsinputs-datepicker-showresetbutton' => "Faut-il afficher un bouton de réinitialisation? C'est la seule manière pour l'utilisateur d'effacer le champ d'entrée s'il est désactivé pour la saisie directe.",
	'semanticformsinputs-timepicker-mintime' => 'Le premier horaire à afficher. Format: hh:mm',
	'semanticformsinputs-timepicker-maxtime' => 'Le dernier horaire à afficher. Format: hh:mm',
	'semanticformsinputs-timepicker-interval' => 'Intervalle entre les minutes. Nombre entre 1 et 60.',
	'semanticformsinputs-timepicker-enableinputfield' => "L'utilisateur doit-il pouvoir remplir le champ d'entrée directement ou seulement par l'intermédiaire du sélecteur de dates?",
	'semanticformsinputs-timepicker-showresetbutton' => "Faut-il afficher un bouton de réinitialisation? C'est la seule manière pour l'utilisateur d'effacer le champ d'entrée s'il est désactivé pour la saisie directe.",
	'semanticformsinputs-regexp-regexp' => "L'expression régulière que l'entrée doit respecter pour être valide. Cela doit comprendre les barres obliques ! Par défaut, \"/.*/\", c'est-à-dire n'importe quelle valeur.",
	'semanticformsinputs-regexp-basetype' => 'Le type de base à utiliser. Peut être n\'importe quel type d\'entrée qui génère un élément de formulaire html de type input ou select (par ex., texte, liste déroulante, sélecteur de date) ou une autre expression régulière. Par défaut, "texte".',
	'semanticformsinputs-regexp-baseprefix' => 'Préfixe pour les paramètres du type de base.',
	'semanticformsinputs-regexp-orchar' => 'Le caractère OU à utiliser dans l\'expression régulière au lieu de |. Par défaut, "!"',
	'semanticformsinputs-regexp-inverse' => "S'il est activé, l'entrée ne doit PAS correspondre à l'expression régulière pour être valide. C'est-à-dire que l'expression régulière est inversée.",
	'semanticformsinputs-regexp-message' => "Le message d'erreur à afficher si la correspondance échoue. Par défaut, «Format incorrect!» (ou l'équivalent dans la langue locale)",
	'semanticformsinputs-menuselect-structure' => 'La structure du menu sous forme de liste non ordonnée.',
	'semanticformsinputs-menuselect-enableinputfield' => "L'utilisateur doit-il pouvoir remplir le champ d'entrée directement?",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'semanticformsinputs-wrongformat' => 'Crouyo format.',
	'semanticformsinputs-close' => 'Cllôre',
	'semanticformsinputs-prev' => 'Devant',
	'semanticformsinputs-next' => 'Aprés',
	'semanticformsinputs-today' => 'Houé',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'semanticformsinputs-desc' => 'Tipos de entrada adicionais para os [http://www.mediawiki.org/wiki/Extension:Semantic_Forms formularios semánticos]',
	'semanticformsinputs-wrongformat' => 'Formato incorrecto.',
	'semanticformsinputs-close' => 'Pechar',
	'semanticformsinputs-prev' => 'Anterior',
	'semanticformsinputs-next' => 'Seguinte',
	'semanticformsinputs-today' => 'Hoxe',
	'semanticformsinputs-datepicker-dateformat' => 'A cadea de formato de data. Olle a [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters documentación en liña] para obter máis información.',
	'semanticformsinputs-datepicker-weekstart' => 'O primeiro día da semana (0 = domingo, 1 = luns...).',
	'semanticformsinputs-datepicker-firstdate' => 'A primeira data que se pode elixir (en formato aaa/mm/dd).',
	'semanticformsinputs-datepicker-lastdate' => 'A última data que se pode elixir (en formato aaa/mm/dd).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'Unha lista de días que non se poden seleccionar (por exemplo, fin de semana: 6, 0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'Unha lista de días que deberían aparecer destacados (por exemplo, fin de semana: 6, 0).',
	'semanticformsinputs-datepicker-disabledates' => 'Unha lista de elementos separados por comas de rangos de data ou datas desactivados (datas en formato aaaa/mm/dd, rangos en formato aaaa/mm/dd-aaaa/mm/dd).',
	'semanticformsinputs-datepicker-highlightdates' => 'Unha lista de elementos separados por comas de rangos de data ou datas que deberían aparecer destacados (datas en formato aaaa/mm/dd, rangos en formato aaaa/mm/dd-aaaa/mm/dd).',
	'semanticformsinputs-datepicker-showweeknumbers' => 'Deben aparecer os números á esquerda da semana?',
	'semanticformsinputs-datepicker-enableinputfield' => 'Debe o usuario ser capaz de encher o campo de entrada directamente ou unicamente a través do selector de datas?',
	'semanticformsinputs-datepicker-showresetbutton' => 'Debe mostrarse un botón de restablecemento? Este é o único xeito que o usuario ten de limpar o campo de entrada se está desactivado para a entrada directa.',
	'semanticformsinputs-timepicker-mintime' => 'A primeira hora a mostrar. Formato: hh:mm',
	'semanticformsinputs-timepicker-maxtime' => 'A última hora a mostrar. Formato: hh:mm',
	'semanticformsinputs-timepicker-interval' => 'Intervalo entre os minutos. Número entre 1 e 60.',
	'semanticformsinputs-timepicker-enableinputfield' => 'Debe o usuario ser capaz de encher o campo de entrada directamente ou unicamente a través do selector de datas?',
	'semanticformsinputs-timepicker-showresetbutton' => 'Debe mostrarse un botón de restablecemento? Este é o único xeito que o usuario ten de limpar o campo de entrada se está desactivado para a entrada directa.',
	'semanticformsinputs-regexp-regexp' => 'A expresión regular que debe coincidir coa entrada para que sexa válida. Cómpre especificala coas barras inclunadas! Por defecto "/.*/", para calquera valor.',
	'semanticformsinputs-regexp-basetype' => 'O tipo de base a usar. Pode ser calquera tipo de entrada que xere un elemento de formulario HTML do tipo "input" ou "select" (por exemplo, texto, caixa de listas, selector de data) ou outra expresión regular. Por defecto é "texto".',
	'semanticformsinputs-regexp-baseprefix' => 'Prefixo para os parámetros do tipo de base.',
	'semanticformsinputs-regexp-orchar' => 'O carácter OU a usar na expresión regular no canto de "|". Por defecto é "!".',
	'semanticformsinputs-regexp-inverse' => 'En caso de estar definida, a entrada NON debe coincidir coa expresión regular para ser válida. Por exemplo, se a expresión regular está invertida.',
	'semanticformsinputs-regexp-message' => 'A mensaxe de erro a mostrar se falla a coincidencia. Por defecto é "Formato incorrecto!" (ou a forma equivalente na lingua local)',
	'semanticformsinputs-menuselect-structure' => 'A estrutura do menú como lista non ordenada.',
	'semanticformsinputs-menuselect-enableinputfield' => 'Debe o usuario ser capaz de encher o campo de entrada directamente?',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'semanticformsinputs-desc' => 'Mecht zuesätzligi Arte vu Yygabe megli fir [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Falsch Format.',
	'semanticformsinputs-close' => 'Zuemache',
	'semanticformsinputs-prev' => 'Vorigi',
	'semanticformsinputs-next' => 'Negschti',
	'semanticformsinputs-today' => 'Hit',
);

/** Hebrew (עברית)
 * @author YaronSh
 */
$messages['he'] = array(
	'semanticformsinputs-desc' => 'סוגי קלט נוספים עבור [http://www.mediawiki.org/wiki/Extension:Semantic_Forms טפסים סמנטיים]',
	'semanticformsinputs-wrongformat' => 'מבנה שגוי.',
	'semanticformsinputs-close' => 'סגירה',
	'semanticformsinputs-prev' => 'הקודם',
	'semanticformsinputs-next' => 'הבא',
	'semanticformsinputs-today' => 'היום',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'semanticformsinputs-desc' => 'Přidatne zapodawanske typy za [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Wopačny format',
	'semanticformsinputs-close' => 'Začinić',
	'semanticformsinputs-prev' => 'Předchadny',
	'semanticformsinputs-next' => 'Přichodny',
	'semanticformsinputs-today' => 'Dźensa',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'semanticformsinputs-wrongformat' => 'Hibás formátum.',
	'semanticformsinputs-close' => 'Bezárás',
	'semanticformsinputs-prev' => 'Előző',
	'semanticformsinputs-next' => 'Következő',
	'semanticformsinputs-today' => 'Ma',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticformsinputs-desc' => 'Additional typos de entrata pro [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formularios Semantic]',
	'semanticformsinputs-wrongformat' => 'Formato incorrecte.',
	'semanticformsinputs-close' => 'Clauder',
	'semanticformsinputs-prev' => 'Precedente',
	'semanticformsinputs-next' => 'Sequente',
	'semanticformsinputs-today' => 'Hodie',
	'semanticformsinputs-datepicker-dateformat' => 'Le specification del formato del data. Vide le [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters documentation in linea] pro plus information.',
	'semanticformsinputs-datepicker-weekstart' => 'Le prime die del septimana (0 - dominica, 1 - lunedi, ...).',
	'semanticformsinputs-datepicker-firstdate' => 'Le prime data que pote esser seligite (in formato aaaa/mm/dd).',
	'semanticformsinputs-datepicker-lastdate' => 'Le ultime data que pote esser seligite (in formato aaaa/mm/dd).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'Un lista de dies que non pote esser seligite (p.ex. fin de septimana: 6, 0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'Un lista de dies que debe apparer in forma accentuate (p.ex. fin de septimana: 6, 0).',
	'semanticformsinputs-datepicker-disabledates' => 'Un lista separate per commas de datas disactivate, o intervallos de datas disactivate (datas in formato aaaa/mm/dd, intervallos in formato aaaa/mm/dd-aaaa/mm/dd).',
	'semanticformsinputs-datepicker-highlightdates' => 'Un lista separate per commas de datas o intervallos de datas que debe apparer in forma accentuate (datas in formato aaaa/mm/dd, intervallos in formato aaaa/mm/dd-aaaa/mm/dd).',
	'semanticformsinputs-datepicker-showweeknumbers' => 'Monstrar le numeros de septimana a sinistra del septimana?',
	'semanticformsinputs-datepicker-enableinputfield' => 'Debe le usator poter plenar le campo de entrata directemente o solmente via le selector de data?',
	'semanticformsinputs-datepicker-showresetbutton' => 'Monstrar un button de reinitialisation? Isto es le sol maniera in que le usator pote rader le campo de entrata si illo es disactivate pro entrata directe.',
	'semanticformsinputs-timepicker-mintime' => 'Le prime hora a monstrar. Formato: hh:mm',
	'semanticformsinputs-timepicker-maxtime' => 'Le ultime hora a monstrar. Formato: hh:mm',
	'semanticformsinputs-timepicker-interval' => 'Intervallo inter minutas. Numero inter 1 e 60.',
	'semanticformsinputs-timepicker-enableinputfield' => 'Debe le usator poter plenar le campo de entrata directemente o solmente via le selector de data?',
	'semanticformsinputs-timepicker-showresetbutton' => 'Monstrar un button de reinitialisation? Isto es le sol maniera in que le usator pote rader le campo de entrata si illo es disactivate pro entrata directe.',
	'semanticformsinputs-regexp-regexp' => 'Le expression regular a que le entrata debe corresponder pro esser valide. Isto debe esser specificate includente le barras oblique! Le predefinition es "/.*/", i.e. omne valor.',
	'semanticformsinputs-regexp-basetype' => 'Le typo de base a usar. Pote esser omne typo de entrata que genera un elemento de formulario HTML del typo "input" o "select" (p.ex. texto, quadro de lista, selector de data) o un altere expression regular. Le predefinition es "text".',
	'semanticformsinputs-regexp-baseprefix' => 'Prefixo pro le parametros del typo de base.',
	'semanticformsinputs-regexp-orchar' => 'Le character pro separar alternativas a usar in le expression regular in loco de "|". Le predefinition es "!".',
	'semanticformsinputs-regexp-inverse' => 'Si definite, le entrata NON debe corresponder al expression regular pro esser valide. Isto vole dicer, le expression regular es invertite.',
	'semanticformsinputs-regexp-message' => 'Le message de error a presentar in caso de non-correspondentia. Le predefinition es "Formato incorrecte!" (o le equivalente in le lingua actualmente configurate)',
	'semanticformsinputs-menuselect-structure' => 'Le structura de menu como un lista non ordinate.',
	'semanticformsinputs-menuselect-enableinputfield' => 'Debe le usator poter plenar le campo de entrata directemente?',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'semanticformsinputs-desc' => 'Jenis masukan tambahan untuk [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Format salah.',
	'semanticformsinputs-close' => 'Penutup',
	'semanticformsinputs-prev' => 'Sebelumnya',
	'semanticformsinputs-next' => 'Selanjutnya',
	'semanticformsinputs-today' => 'Hari ini',
);

/** Japanese (日本語)
 * @author Yanajin66
 * @author 青子守歌
 */
$messages['ja'] = array(
	'semanticformsinputs-desc' => ' [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]のための追加の入力タイプ',
	'semanticformsinputs-wrongformat' => '間違った形式です。',
	'semanticformsinputs-close' => '閉じる',
	'semanticformsinputs-prev' => '前へ',
	'semanticformsinputs-next' => '次へ',
	'semanticformsinputs-today' => '今日',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'semanticformsinputs-close' => 'បិទ',
	'semanticformsinputs-prev' => 'មុន',
	'semanticformsinputs-next' => 'បន្ទាប់',
	'semanticformsinputs-today' => 'ថ្ងៃនេះ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'semanticformsinputs-desc' => 'Zohsäzlejje Zoote Einjabe för „[http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantesch Fommulaare]“.',
	'semanticformsinputs-wrongformat' => 'Dat Fommaat es verkiehrt',
	'semanticformsinputs-close' => 'Zohmaache',
	'semanticformsinputs-prev' => 'Vörijje',
	'semanticformsinputs-next' => 'Nächste',
	'semanticformsinputs-today' => 'Hück',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'semanticformsinputs-today' => 'Îro',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'semanticformsinputs-desc' => "Zousätzlech Manéieren fir d'Eraginn fir [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Formulairen]",
	'semanticformsinputs-wrongformat' => 'Falsche Format.',
	'semanticformsinputs-close' => 'Zoumaachen',
	'semanticformsinputs-prev' => 'Vireg',
	'semanticformsinputs-next' => 'Nächst',
	'semanticformsinputs-today' => 'Haut',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author F.trott
 */
$messages['mk'] = array(
	'semanticformsinputs-desc' => 'Дополнителни типови на внос за [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Семантички обрасци]',
	'semanticformsinputs-wrongformat' => 'Погрешен формат.',
	'semanticformsinputs-close' => 'Затвори',
	'semanticformsinputs-prev' => 'Претходно',
	'semanticformsinputs-next' => 'Следно',
	'semanticformsinputs-today' => 'Денес',
	'semanticformsinputs-malformedregexp' => 'Погрешно срочен регуларен израз ($1).',
	'semanticformsinputs-datepicker-dateformat' => 'Низа за датумски формат. За повеќе информации, погледајте ја [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters документацијата].',
	'semanticformsinputs-datepicker-weekstart' => 'Прв ден во седмицата (0 - недела, 1 - понеделник, ...).',
	'semanticformsinputs-datepicker-firstdate' => 'Првиот датум што ќе може да се избере (во форматот гггг/мм/дд).',
	'semanticformsinputs-datepicker-lastdate' => 'Последниот датум што може да се обере (во форматот гггг/мм/дд).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'Список на денови што не можат да се одберат (на пр. викенд, 6, 0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'Список на денови што ќе се истакнуваат (на пр. викенд, 6, 0).',
	'semanticformsinputs-datepicker-disabledates' => 'Список на оневозможени датуми/датумски опсези, одделени со запирка (датуми во форматот гггг/мм/дд, опсези во форматот гггг/мм/дд-гггг/мм/дд).',
	'semanticformsinputs-datepicker-highlightdates' => 'Список на датуми/датумски опсези одделени со запирка кои ќе се прикажуваат истакнати, т.е. обележани (датуми во форматот гггг/мм/дд, опсези во форматот гггг/мм/дд-гггг/мм/дд).',
	'semanticformsinputs-datepicker-showweeknumbers' => 'Дали лево од седмиците да стојат броеви (на седмици)?',
	'semanticformsinputs-datepicker-enableinputfield' => 'Дали корисникот да може да го пополни полето за внос директно или преку одбирачот на датуми?',
	'semanticformsinputs-datepicker-showresetbutton' => 'Дали да се прикажува копчето „одново“? Ова е единствениот начин корисникот да го избрише внесеното во полето ако за тоа поле е оневозможен директниот внос.',
	'semanticformsinputs-timepicker-mintime' => 'Најрано време за приказ. Формат: чч:мм',
	'semanticformsinputs-timepicker-maxtime' => 'Последно време за приказ. Формат: чч:мм',
	'semanticformsinputs-timepicker-interval' => 'Интервал помеѓу минутите. Број помеѓу 1 и 60.',
	'semanticformsinputs-timepicker-enableinputfield' => 'Дали корисникот да може да го пополни полето за внос директно или преку одбирачот на датуми?',
	'semanticformsinputs-timepicker-showresetbutton' => 'Дали да се прикажува копчето „одново“? Ова е единствениот начин корисникот да го избрише внесеното во полето ако за тоа поле е оневозможен директниот внос.',
	'semanticformsinputs-regexp-regexp' => 'Регуларниот израз на вносот мора да се совпаѓа за да биде важечки. Мора да се внесе заедно со косите црти. По основно: „/.*/“, т.е. било која вредност.',
	'semanticformsinputs-regexp-basetype' => 'Основен тип за употреба. Може да биде било кој тип на внос што создава html-елемент за образец од типот на внос или одбирање (на пр. текст, список, одбирач на датум) или некој друг регуларен израз. По основно: „текст“.',
	'semanticformsinputs-regexp-baseprefix' => 'Префикс за параметрите од основен тип.',
	'semanticformsinputs-regexp-orchar' => 'Знакот за ИЛИ што ќе се користи во регуларниот израз наместо |. По основно „!“',
	'semanticformsinputs-regexp-inverse' => 'Ако е зададено, вносот НЕ смее да се совпаѓа со регуларниот израз за да биде важечки, т.е. регуларниот израз станува обратен.',
	'semanticformsinputs-regexp-message' => 'Пораката за грешка што ќе се прикаже ако нема совпаѓање. По основно: „Погрешен формат!“',
	'semanticformsinputs-menuselect-structure' => 'Состав на менито како неподреден список.',
	'semanticformsinputs-menuselect-enableinputfield' => 'Дали корисникот да може директно да го пополни полето за внос?',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'semanticformsinputs-close' => 'അടയ്ക്കുക',
	'semanticformsinputs-prev' => 'മുൻപത്തേത്',
	'semanticformsinputs-next' => 'അടുത്തത്',
	'semanticformsinputs-today' => 'ഇന്ന്',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'semanticformsinputs-prev' => 'Sebelumnya',
	'semanticformsinputs-next' => 'Berikutnya',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'semanticformsinputs-desc' => 'Extra invoertypen voor [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Onjuiste opmaak.',
	'semanticformsinputs-close' => 'Sluiten',
	'semanticformsinputs-prev' => 'Vorige',
	'semanticformsinputs-next' => 'Volgende',
	'semanticformsinputs-today' => 'Vandaag',
	'semanticformsinputs-malformedregexp' => 'Ongeldige reguliere expressie ($1).',
	'semanticformsinputs-datepicker-dateformat' => 'De datumopmaak. Zie de [http://www.mediawiki.org/w/index.php?title=Extension:Semantic_Forms_Inputs&fromsection=Date_picker#Parameters online documentatie] voor meer informatie.',
	'semanticformsinputs-datepicker-weekstart' => 'De eerste dag van de week (0: zondag, 1: maandag, ...).',
	'semanticformsinputs-datepicker-firstdate' => 'De eerste datum die gekozen kan worden (in de opmaak jjjj/mm/dd).',
	'semanticformsinputs-datepicker-lastdate' => 'De laatste datum die gekozen kan worden (in de opmaak jjjj/mm/dd).',
	'semanticformsinputs-datepicker-disabledaysofweek' => 'Een lijst van dagen die niet kunnen worden geselecteerd (bijvoorbeeld weekend: 6, 0).',
	'semanticformsinputs-datepicker-highlightdaysofweek' => 'Een lijst van dagen die gemarkeerd worden (bijvoorbeeld weekend: 6, 0).',
	'semanticformsinputs-datepicker-disabledates' => "Een door komma's gescheiden lijst van uitgeschakelde datums of datumreeksen (datums in de opmaak jjjj/mm/dd, reeksen in de opmaak jjjj/mm/dd-jjjj/mm/dd).",
	'semanticformsinputs-datepicker-highlightdates' => "Een door komma's gescheiden lijst van datums of datumreeksen die gemarkeerd worden (datums in de opmaak jjjj/mm/dd formaat, reeksen in de opmaak jjjj/mm/dd-jjjj/mm/dd).",
	'semanticformsinputs-datepicker-showweeknumbers' => 'Weeknummers links van de week weergeven?',
	'semanticformsinputs-datepicker-enableinputfield' => 'Kan de gebruiker het invoerveld rechtstreeks bewerken, of alleen via de datumkiezer?',
	'semanticformsinputs-datepicker-showresetbutton' => 'Knop voor leegmaken weergeven? Dit is de enige manier voor de gebruiker om het invoerveld te wissen als directe invoer voor het veld is uitgeschakeld.',
	'semanticformsinputs-timepicker-mintime' => 'De vroegste tijd om weer te geven. Opmaak: uu:mm',
	'semanticformsinputs-timepicker-maxtime' => 'De laatste tijd om weer te geven. Opmaak: uu:mm.',
	'semanticformsinputs-timepicker-interval' => 'Interval tussen minuten. Getal tussen 1 en 60.',
	'semanticformsinputs-timepicker-enableinputfield' => 'Kan de gebruiker het invoerveld rechtstreeks bewerken, of alleen via de datumkiezer?',
	'semanticformsinputs-timepicker-showresetbutton' => 'Knop voor leegmaken weergeven? Dit is de enige manier voor de gebruiker om het invoerveld te wissen als directe invoer voor het veld is uitgeschakeld.',
	'semanticformsinputs-regexp-regexp' => 'De reguliere expressie waarmee de invoer moet overeenkomen om geldig te zijn. Dit moet worden opgegeven met inbegrip van de schraptekens (slashes)! Standaard ingesteld op "/. * /", ofwel een willekeurige waarde.',
	'semanticformsinputs-regexp-basetype' => 'Het basistype dat moet worden gebruikt. Dit kan elk invoertype zijn dat een HTML-formulierelement van het type "input" of "select" (bijvoorbeeld "text", "listbox" of "datepicker") of een andere reguliere expressie genereert. Standaard ingesteld op "text".',
	'semanticformsinputs-regexp-baseprefix' => 'Voorvoegsel voor de parameters van het basistype.',
	'semanticformsinputs-regexp-orchar' => 'Het OR-teken dat in de reguliere expressie wordt gebruikt in plaats van |. Standaard ingesteld op "!"',
	'semanticformsinputs-regexp-inverse' => 'Als dit is ingesteld moet de invoer NIET overeen komen met de reguliere expressie om geldig te zijn. Dat wil zeggen, de reguliere expressie is omgekeerd.',
	'semanticformsinputs-regexp-message' => 'Het foutbericht dat moet worden weergegeven als het vergelijken mislukt. De standaardinstelling is "Verkeerde opmaak!" (of het equivalent in de geldende landinstelling).',
	'semanticformsinputs-menuselect-structure' => 'De menustructuur als een ongeordende lijst.',
	'semanticformsinputs-menuselect-enableinputfield' => 'Moet de gebruiker het invoerveld rechtstreeks kunnen invullen?',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'semanticformsinputs-desc' => 'Ekstra inndatatyper for [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]',
	'semanticformsinputs-wrongformat' => 'Feil format.',
	'semanticformsinputs-close' => 'Lukk',
	'semanticformsinputs-prev' => 'Forrige',
	'semanticformsinputs-next' => 'Neste',
	'semanticformsinputs-today' => 'I dag',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'semanticformsinputs-next' => 'Neegschte',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'semanticformsinputs-prev' => 'Voriche',
	'semanticformsinputs-next' => 'Negschte',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'semanticformsinputs-desc' => 'Dodatkowe typy wejściowe dla [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formularzy Semantycznych]',
	'semanticformsinputs-wrongformat' => 'Niewłaściwy format.',
	'semanticformsinputs-close' => 'Zamknij',
	'semanticformsinputs-prev' => 'Poprzednie',
	'semanticformsinputs-next' => 'Następne',
	'semanticformsinputs-today' => 'Dziś',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'semanticformsinputs-desc' => "Sòrt d'intrade adissionaj për [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formolari Semàntich]",
	'semanticformsinputs-wrongformat' => 'Formà pa bon.',
	'semanticformsinputs-close' => 'Sara',
	'semanticformsinputs-prev' => 'Prima',
	'semanticformsinputs-next' => 'Apress',
	'semanticformsinputs-today' => 'Ancheuj',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'semanticformsinputs-desc' => 'Tipos de entrada adicionais para [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formulários Semânticos]',
	'semanticformsinputs-wrongformat' => 'Formato incorrecto.',
	'semanticformsinputs-close' => 'Fechar',
	'semanticformsinputs-prev' => 'Anterior',
	'semanticformsinputs-next' => 'Seguinte',
	'semanticformsinputs-today' => 'Hoje',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'semanticformsinputs-desc' => 'Tipos de entrada adicionais para [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Formulários Semânticos]',
	'semanticformsinputs-wrongformat' => 'Formato incorreto.',
	'semanticformsinputs-close' => 'Fechar',
	'semanticformsinputs-prev' => 'Anterior',
	'semanticformsinputs-next' => 'Seguinte',
	'semanticformsinputs-today' => 'Hoje',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'semanticformsinputs-desc' => 'Tipe de input aggiundive pe le [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Module Semandece]',
	'semanticformsinputs-wrongformat' => 'Formate sbagliate',
);

/** Russian (Русский)
 * @author F.trott
 * @author MaxSem
 * @author Александр Сигачёв
 * @author Сrower
 */
$messages['ru'] = array(
	'semanticformsinputs-desc' => 'Дополнительные входящие типы для [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Семантических Форм]',
	'semanticformsinputs-wrongformat' => 'Неверный формат.',
	'semanticformsinputs-close' => 'Закрыть',
	'semanticformsinputs-prev' => 'Предыдущая',
	'semanticformsinputs-next' => 'Следующая',
	'semanticformsinputs-today' => 'Сегодня',
	'semanticformsinputs-firstdayofweek' => '1',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'semanticformsinputs-firstdayofweek' => '1',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'semanticformsinputs-close' => 'మూసివేయి',
	'semanticformsinputs-prev' => 'గత',
	'semanticformsinputs-next' => 'తదుపరి',
	'semanticformsinputs-today' => 'ఈరోజు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'semanticformsinputs-desc' => 'Karagdagang mga tipo ng pagpasok para sa [http://www.mediawiki.org/wiki/Extension:Semantic_Forms Anyong Semantiko]',
	'semanticformsinputs-wrongformat' => 'Maling anyo.',
	'semanticformsinputs-close' => 'Isara',
	'semanticformsinputs-prev' => 'Nakaraan',
	'semanticformsinputs-next' => 'Susunod',
	'semanticformsinputs-today' => 'Ngayon',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'semanticformsinputs-close' => 'Закрити',
	'semanticformsinputs-prev' => 'Попередня',
	'semanticformsinputs-next' => 'Наступна',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'semanticformsinputs-wrongformat' => 'Định dạng sai',
	'semanticformsinputs-close' => 'Đóng',
	'semanticformsinputs-prev' => 'Trước',
	'semanticformsinputs-next' => 'Sau',
	'semanticformsinputs-today' => 'Hôm nay',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'semanticformsinputs-desc' => '用于[http://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms]的附加输入项类型',
	'semanticformsinputs-wrongformat' => '格式错误。',
	'semanticformsinputs-close' => '关闭',
	'semanticformsinputs-prev' => '向前',
	'semanticformsinputs-next' => '下一个',
	'semanticformsinputs-today' => '今天',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'semanticformsinputs-wrongformat' => '格式不正確。',
	'semanticformsinputs-close' => '關閉',
	'semanticformsinputs-prev' => '上一個',
	'semanticformsinputs-next' => '下一個',
	'semanticformsinputs-today' => '今天',
);

