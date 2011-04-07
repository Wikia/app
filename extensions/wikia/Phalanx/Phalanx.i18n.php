<?php

$messages = array();

$messages['en'] = array(
	'phalanx-desc' => 'Phalanx is an Integrated Spam Defense Mechanism',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrated Spam Defense Mechanism',
	'phalanx-type-content' => 'page content',
	'phalanx-type-summary' => 'page summary',
	'phalanx-type-title' => 'page title',
	'phalanx-type-user' => 'user',
	'phalanx-type-answers-question-title' => 'question title',
	'phalanx-type-answers-recent-questions' => 'recent questions',
	'phalanx-type-wiki-creation' => 'wiki creation',
	'phalanx-add-block' => 'Apply block',
	'phalanx-edit-block' => 'Save block',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Reason:',
	'phalanx-label-expiry' => 'Expiry:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Language:',
	'phalanx-view-type' => 'Type of block...',
	'phalanx-view-blocker' => 'Search by filter text:',
	'phalanx-view-blocks' => 'Search filters',
	'phalanx-view-id' => 'Get filter by ID:',
	'phalanx-view-id-submit' => 'Get filter',
	'phalanx-expire-durations' => '1 hour,2 hours,4 hours,6 hours,1 day,3 days,1 week,2 weeks,1 month,3 months,6 months,1 year,infinite', // FIXME: no L10n possible; see core block/protect implementations for proper solution.
	'phalanx-format-text' => 'plain text',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'case sensitive',
	'phalanx-format-exact' => 'exact',
	'phalanx-tab-main' => 'Manage Filters',
	'phalanx-tab-secondary' => 'Test Filters',

	'phalanx-block-success' => 'The block was successfully added',
	'phalanx-block-failure' => 'There was an error during adding the block',
	'phalanx-modify-success' => 'The block was successfully modified',
	'phalanx-modify-failure' => 'There was an error modifying the block',
	'phalanx-modify-warning' => 'You are editing block ID #$1.
Clicking "{{int:phalanx-add-block}}" will save your changes!',
	'phalanx-test-description' => 'Test provided text against current blocks.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Test results',
	'phalanx-display-row-blocks' => 'blocks: $1',
	'phalanx-display-row-created' => "created by '''$1''' on $2",

	'phalanx-link-unblock' => 'unblock',
	'phalanx-link-modify' => 'modify',
	'phalanx-link-stats' => 'stats',
	'phalanx-reset-form' => 'Reset form',

	'phalanx-legend-input' => 'Create or modify filter',
	'phalanx-legend-listing' => 'Currently applied filters',
	'phalanx-unblock-message' => 'Block ID #$1 was successfully removed',

	'phalanx-help-type-content' => 'This filter prevents an edit from being saved, if its content matches any of the blacklisted phrases.',
	'phalanx-help-type-summary' => 'This filter prevents an edit from being saved, if the summary given matches any of the blacklisted phrases.',
	'phalanx-help-type-title' => 'This filter prevents a page from being created, if its title matches any of the blacklisted phrases.

	 It does not prevent a pre-existing page from being edited.',
	'phalanx-help-type-user' => 'This filter blocks a user (exactly the same as a local MediaWiki block), if the name or IP address matches one of the blacklisted names or IP addresses.',
	'phalanx-help-type-wiki-creation' => 'This filter prevents a wiki from being created, if its name or URL matches any blacklisted phrase.',
	'phalanx-help-type-answers-question-title' => 'This filter blocks a question (page) from being created, if its title matches any of the blacklisted phrases.

Note: only works on Answers-type wikis.',
	'phalanx-help-type-answers-recent-questions' => 'This filter prevents questions (pages) from being displayed in a number of outputs (widgets, lists, tag-generated listings).
It does not prevent those pages from being created.

Note: works only on Answers-type wiks.',

	#block reason overrides, when no block reason was inputed (original usage)
	'phalanx-user-block-reason-ip' => 'This IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please [[Special:Contact|contact Wikia]].',
	'phalanx-user-block-reason-exact' => 'This username or IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption.
If you believe this is in error, please [[Special:Contact|contact Wikia]].',
	'phalanx-user-block-reason-similar' => 'This username is prevented from editing across the entire Wikia network due to vandalism or other disruption by a user with a similar name.
Please [[Special:Contact|contact Wikia]] about the problem.',

	#block reason overrides, worded to add the block reason
	'phalanx-user-block-withreason-ip' => 'This IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please [[Special:Contact|contact Wikia]].<br/>The blocker also gave this additional reason: $1.',
	'phalanx-user-block-withreason-exact' => 'This username or IP address is prevented from editing across the entire Wikia network due to vandalism or other disruption.
If you believe this is in error, please [[Special:Contact|contact Wikia]].<br/>The blocker also gave this additional reason: $1.',
	'phalanx-user-block-withreason-similar' => 'This username is prevented from editing across the entire Wikia network due to vandalism or other disruption by a user with a similar name.
Please [[Special:Contact|contact Wikia]] about the problem.<br/>The blocker also gave this additional reason: $1.',

	'phalanx-title-move-summary' => 'The reason you entered contained a blocked phrase.',
	'phalanx-content-spam-summary' => "The text was found in the page's summary.",

	'phalanx-stats-title' => 'Phalanx Stats',
	'phalanx-stats-block-notfound' => 'block ID not found',
	'phalanx-stats-table-id' => 'Block ID',
	'phalanx-stats-table-user' => 'Added by',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Created',
	'phalanx-stats-table-expire' => 'Expires',
	'phalanx-stats-table-exact' => 'Exact',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Case',
	'phalanx-stats-table-language' => 'Language',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Reason',
	'phalanx-stats-row' => "at $4, filter type '''$1''' blocked '''$2''' on $3",
	'phalanx-stats-row-per-wiki' => "user '''$2''' was blocked on '''$4''' by filter ID '''$3''' ($5) (type: '''$1''')",

	'phalanx-rule-log-name' => 'Phalanx rules log',
	'phalanx-rule-log-header' => 'This is a log of changes to phalanx rules.',
	'phalanx-rule-log-add' => 'Phalanx rule added: $1',
	'phalanx-rule-log-edit' => 'Phalanx rule edited: $1',
	'phalanx-rule-log-delete' => 'Phalanx rule deleted: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", type: "$2", reason: "$3"',

	'phalanx-stats-table-wiki-id' => 'Wiki ID',
	'phalanx-stats-table-wiki-name' => 'Wiki Name',
	'phalanx-stats-table-wiki-url' => 'Wiki URL',
	'phalanx-stats-table-wiki-last-edited' => 'Last edited',
	
	#permissions
	'right-phalanx' => 'Can manage global blocks and spam filters',
	'right-phalanxexempt' => 'Exempt from Phalanx rules',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'phalanx-type-title' => 'anv ar bajenn',
	'phalanx-type-user' => 'implijer',
	'phalanx-label-filter' => 'Sil :',
	'phalanx-label-reason' => 'Abeg :',
	'phalanx-label-expiry' => 'Termen :',
	'phalanx-label-type' => 'Seurt',
	'phalanx-label-lang' => 'Yezh :',
	'phalanx-test-submit' => 'Amprouiñ',
	'phalanx-link-unblock' => 'distankañ',
	'phalanx-link-modify' => 'kemmañ',
	'phalanx-link-stats' => 'stadegoù',
	'phalanx-stats-table-type' => 'Seurt',
	'phalanx-stats-table-create' => 'Krouet',
	'phalanx-stats-table-language' => 'Yezh',
	'phalanx-stats-table-text' => 'Testenn',
	'phalanx-stats-table-reason' => 'Abeg',
	'phalanx-stats-table-wiki-last-edited' => 'Kemmet da ziwezhañ',
);

/** German (Deutsch)
 * @author George Animal
 * @author LWChris
 */
$messages['de'] = array(
	'phalanx-desc' => 'Phalanx ist ein integrierter Spam-Verteidigung-Mechanismus',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrierter Spam-Verteidigungs-Mechanismus',
	'phalanx-type-content' => 'Seiteninhalt',
	'phalanx-type-summary' => 'Zusammenfassung',
	'phalanx-type-title' => 'Seitentitel',
	'phalanx-type-user' => 'Benutzer',
	'phalanx-type-answers-question-title' => 'Frage-Titel',
	'phalanx-type-answers-recent-questions' => 'Kürzliche Fragen',
	'phalanx-type-wiki-creation' => 'Wiki-Erstellung',
	'phalanx-add-block' => 'Sperre anwenden',
	'phalanx-edit-block' => 'Sperre speichern',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Grund:',
	'phalanx-label-expiry' => 'Sperrdauer:',
	'phalanx-label-type' => 'Typ:',
	'phalanx-label-lang' => 'Sprache:',
	'phalanx-view-type' => 'Art der Sperre...',
	'phalanx-view-blocker' => 'Suche nach Filtertext:',
	'phalanx-view-blocks' => 'Suchfilter',
	'phalanx-view-id' => 'Filter nach ID:',
	'phalanx-view-id-submit' => 'Hole Filter',
	'phalanx-format-text' => 'Klartext',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'Groß- und Kleinschreibung',
	'phalanx-format-exact' => 'genau',
	'phalanx-tab-main' => 'Filter verwalten',
	'phalanx-tab-secondary' => 'Filter testen',
	'phalanx-block-success' => 'Die Sperre wurde erfolgreich hinzugefügt',
	'phalanx-block-failure' => 'Es gab einen Fehler beim Hinzufügen der Sperre',
	'phalanx-modify-success' => 'Die Sperre wurde erfolgreich geändert',
	'phalanx-modify-failure' => 'Es gab einen Fehler beim Ändern der Sperre',
	'phalanx-modify-warning' => 'Du bearbeitest die Sperre mit der ID #$1.
Ein Klick auf "{{int:phalanx-add-block}}" speichert deine Änderungen!',
	'phalanx-test-description' => 'Teste gegebenen Text mit aktuellen Sperren.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Testergebnisse',
	'phalanx-display-row-blocks' => 'Sperren: $1',
	'phalanx-display-row-created' => "erstellt von ''$1''' um $2",
	'phalanx-link-unblock' => 'entsperren',
	'phalanx-link-modify' => 'ändern',
	'phalanx-link-stats' => 'Statistiken',
	'phalanx-reset-form' => 'Formular leeren',
	'phalanx-legend-input' => 'Filter erstellen oder ändern',
	'phalanx-legend-listing' => 'Derzeit angewandte Filter',
	'phalanx-unblock-message' => 'Die Sperre mit der ID #$1 wurde erfolgreich entfernt',
	'phalanx-help-type-content' => 'Dieser Filter verhindert das Speichern einer Bearbeitung, falls ihr Inhalt auf einen Eintrag in der schwarzen Liste passt.',
	'phalanx-help-type-summary' => 'Dieser Filter verhindert das Speichern einer Bearbeitung, falls die Zusammenfassung auf einen Eintrag in der schwarzen Liste passt.',
	'phalanx-help-type-title' => 'Dieser Filter verhindert das Erstellen einer Seite, falls ihr Name auf einen Eintrag in der schwarzen Liste passt.

Er verhindert nicht die Bearbeitung einer bereits vorhandenen Seite.',
	'phalanx-help-type-user' => 'Dieser Filter blockiert einen Benutzer (genauso wie eine lokale MediaWiki-Sperre), wenn der Name oder die IP-Adresse mit einem Eintrag in der schwarzen Liste übereinstimmt.',
	'phalanx-help-type-wiki-creation' => 'Dieser Filter verhindert die Erstellung eines Wikis, falls sein Name oder seine URL auf einen Eintrag in der schwarzen Liste passt.',
	'phalanx-help-type-answers-question-title' => 'Dieser Filter verhindert die Erstellung einer Frage (Seite), falls ihr Titel auf einen Eintrag in der schwarzen Liste passt.

Anmerkung: funktioniert nur für Wikis vom Typ Answers.',
	'phalanx-help-type-answers-recent-questions' => 'Dieser Filter verhindert die Anzeige einer Frage (Seite) in einer Anzahl von Ausgängen (Widgets, Listen, Tag-generierte Auflistungen).

Anmerkung: funktioniert nur für Wikis vom Typ Answers.',
	'phalanx-user-block-reason-ip' => 'Dieser IP-Adresse ist es, aufgrund von Vandalismus oder anderem Störverhalten von dir oder jemandem mit derselben IP-Adresse, verboten zu bearbeiten.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[Special:Contact|kontaktiere Wikia]].',
	'phalanx-user-block-reason-exact' => 'Diesem Benutzernamen oder dieser IP-Adresse ist es, aufgrund von Vandalismus oder anderem Störverhalten, verboten zu bearbeiten.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[Special:Contact|kontaktiere Wikia]].',
	'phalanx-user-block-reason-similar' => 'Diesem Benutzernamen ist es, aufgrund von Vandalismus oder anderem Störverhalten von einem Benutzer mit ähnlichem Namen, verboten zu bearbeiten.
Wenn du denkst, dass es sich hierbei um einen Fehler handelt, [[Special:Contact|kontaktiere Wikia]].',
	'phalanx-title-move-summary' => 'Der von dir eingegebene Grund enthält eine gesperrte Phrase.',
	'phalanx-content-spam-summary' => 'Der Text wurde in der Zusammenfassung gefunden.',
	'phalanx-stats-title' => 'Phalanx Statistik',
	'phalanx-stats-block-notfound' => 'Sperr-ID nicht gefunden',
	'phalanx-stats-table-id' => 'Sperr-ID',
	'phalanx-stats-table-user' => 'Hinzugefügt von',
	'phalanx-stats-table-type' => 'Art',
	'phalanx-stats-table-create' => 'Erstellt',
	'phalanx-stats-table-expire' => 'Gültig bis',
	'phalanx-stats-table-exact' => 'Genau',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Groß-/Kleinschreibung',
	'phalanx-stats-table-language' => 'Sprache',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Grund',
	'phalanx-stats-row' => "$4 wurde '''$2''' auf '''$3''' von Filtertyp '''$1''' geblockt",
	'phalanx-stats-row-per-wiki' => "Benutzer '''$2''' wurde am '''$4''' von Filter ID '''$3''' ($5) geblockt (Typ: '''$1''')",
	'phalanx-rule-log-name' => 'Phalanx Regel-Log',
	'phalanx-rule-log-header' => 'Dies ist ein Logbuch der Änderungen an Phalanx Regeln.',
	'phalanx-rule-log-add' => 'Phalanx Regel hinzugefügt: $1',
	'phalanx-rule-log-edit' => 'Phalanx Regel bearbeitet: $1',
	'phalanx-rule-log-delete' => 'Phalanx Regel gelöscht: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", Typ: "$2", Grund: "$3"',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wikiname',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Zuletzt bearbeitet',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'phalanx-user-block-reason-exact' => 'Tämä käyttäjätunnus tai IP-osoite on estetty ilkivallan tai muunlaisen häiriköinnin vuoksi.
Jos tämä on mielestäsi virhe, ole hyvä ja [[Special:Contact|ota yhteyttä Wikiaan]].',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'phalanx-desc' => 'Phalanx es un systema anti-spam integrate',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Systema anti-spam integrate',
	'phalanx-type-content' => 'contento de pagina',
	'phalanx-type-summary' => 'summario de pagina',
	'phalanx-type-title' => 'titulo de pagina',
	'phalanx-type-user' => 'usator',
	'phalanx-type-answers-question-title' => 'titulo de question',
	'phalanx-type-answers-recent-questions' => 'questiones recente',
	'phalanx-type-wiki-creation' => 'creation de wiki',
	'phalanx-add-block' => 'Applicar blocada',
	'phalanx-edit-block' => 'Salveguardar blocada',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Expiration:',
	'phalanx-label-type' => 'Typo:',
	'phalanx-label-lang' => 'Lingua:',
	'phalanx-view-type' => 'Typo de blocada...',
	'phalanx-view-blocker' => 'Cercar per texto de filtro:',
	'phalanx-view-blocks' => 'Cercar in filtros',
	'phalanx-view-id' => 'Cercar filtro per ID:',
	'phalanx-view-id-submit' => 'Obtener filtro',
	'phalanx-format-text' => 'texto simple',
	'phalanx-format-regex' => 'expression regular',
	'phalanx-format-case' => 'sensibile al majusculas',
	'phalanx-format-exact' => 'exacte',
	'phalanx-tab-main' => 'Gerer filtros',
	'phalanx-tab-secondary' => 'Testar filtros',
	'phalanx-block-success' => 'Le blocada ha essite addite con successo',
	'phalanx-block-failure' => 'Un error occurreva durante le addition del blocada',
	'phalanx-modify-success' => 'Le blocada ha essite modificate con successo',
	'phalanx-modify-failure' => 'Un error occurreva durante le modification del blocada',
	'phalanx-modify-warning' => 'Tu modifica le blocada con ID #$1.
Un clic sur "{{int:phalanx-add-block}}" salveguardara le cambios!',
	'phalanx-test-description' => 'Verificar le texto fornite contra le blocadas actual.',
	'phalanx-test-submit' => 'Testar',
	'phalanx-test-results-legend' => 'Resultatos del test',
	'phalanx-display-row-blocks' => 'blocadas: $1',
	'phalanx-display-row-created' => "create per '''$1''' le $2",
	'phalanx-link-unblock' => 'disblocar',
	'phalanx-link-modify' => 'modificar',
	'phalanx-link-stats' => 'statisticas',
	'phalanx-reset-form' => 'Reinitialisar formulario',
	'phalanx-legend-input' => 'Crear o modificar filtro',
	'phalanx-legend-listing' => 'Filtros actualmente applicate',
	'phalanx-unblock-message' => 'Le blocada con ID #$1 ha essite removite con successo',
	'phalanx-help-type-content' => 'Iste filtro impedi le salveguarda de un modification si su contento corresponde a un phrase presente in le lista nigre.',
	'phalanx-help-type-summary' => 'Iste filtro impedi le salveguarda de un modification si le summario specificate corresponde a un phrase presente in le lista nigre.',
	'phalanx-help-type-title' => 'Iste filtro impedi le salveguarda de un modification si su titulo corresponde a un phrase presente in le lista nigre.

Illo non impedi le modification de un pagina pre-existente.',
	'phalanx-help-type-user' => 'Iste filtro bloca un usator (exactemente como un blocada local in MediaWiki), si le nomine o adresse IP es presente in le lista nigre de nomines o de adresses IP.',
	'phalanx-help-type-wiki-creation' => 'Iste filtro impedi le creation de un wiki si su nomine o URL es presente in le lista nigre.',
	'phalanx-help-type-answers-question-title' => 'Iste filtro bloca le creation de un question (pagina), si su titulo es presente in le lista nigre.

Nota: functiona solmente in wikis del typo Responsas.',
	'phalanx-help-type-answers-recent-questions' => 'Iste filtro impedi le visualisation de questiones (paginas) in un numero de formatos (widgets, listas, listages a base de etiquettas).
Illo non impedi le creation de tal paginas.

Nota: functiona solmente in wikis del typo Answers.',
	'phalanx-user-block-reason-ip' => 'Iste adresse IP es impedite de facer modificationes pro causa de vandalismo o de altere disruption per te o per alcuno altere qui usa un adresse IP in commun con te.
Si tu crede que isto sia un error, per favor [[Special:Contact|contacta Wikia]].',
	'phalanx-user-block-reason-exact' => 'Iste nomine de usator es impedite de facer modificationes pro causa de vandalismo o de altere disruption.
Si tu crede que isto sia un error, per favor [[Special:Contact|contacta Wikia]].',
	'phalanx-user-block-reason-similar' => 'Iste nomine de usator es impedite de facer modificationes pro causa de vandalismo o de altere disruption per un usator con un nomine similar.
Per favor crea un nomine de usator alternative o [[Special:Contact|contacta Wikia]] a proposito de iste problema.',
	'phalanx-title-move-summary' => 'Le motivo que tu entrava contineva un phrase blocate.',
	'phalanx-content-spam-summary' => 'Le texto esseva trovate in le summario del pagina.',
	'phalanx-stats-title' => 'Statisticas de Phalanx',
	'phalanx-stats-block-notfound' => 'ID de blocada non trovate',
	'phalanx-stats-table-id' => 'ID de blocada',
	'phalanx-stats-table-user' => 'Addite per',
	'phalanx-stats-table-type' => 'Typo',
	'phalanx-stats-table-create' => 'Create',
	'phalanx-stats-table-expire' => 'Expira',
	'phalanx-stats-table-exact' => 'Exacte',
	'phalanx-stats-table-regex' => 'Expression regular',
	'phalanx-stats-table-case' => 'Litteras',
	'phalanx-stats-table-language' => 'Lingua',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
	'phalanx-stats-row' => "a $4, le typo de filtro ''$1''' blocava '''$2''' in $3",
	'phalanx-stats-row-per-wiki' => "le usator '''$2''' esseva blocate a '''$4''' per le filtro con ID '''$3''' ($5) (typo: '''$1''')",
	'phalanx-rule-log-name' => 'Registro de regulas Phalanx',
	'phalanx-rule-log-header' => 'Isto es un registro de modificationes in le regulas de Phalanx.',
	'phalanx-rule-log-add' => 'Regula de Phalanx addite: $1',
	'phalanx-rule-log-edit' => 'Regula de Phalanx modificate: $1',
	'phalanx-rule-log-delete' => 'Regula de Phalanx delite: $1',
	'phalanx-rule-log-details' => 'Filtro: "$1", typo: "$2", motivo: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID del wiki',
	'phalanx-stats-table-wiki-name' => 'Nomine del wiki',
	'phalanx-stats-table-wiki-url' => 'URL del wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Ultime modification',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'phalanx-type-user' => 'Benotzer',
	'phalanx-test-submit' => 'Test',
	'phalanx-stats-table-language' => 'Sprooch',
	'phalanx-stats-table-text' => 'Text:',
	'phalanx-stats-table-reason' => 'Grond',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'phalanx-desc' => 'Phalanx е вграден систем за одбрана од спам',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - вграден систем за одбрана од спам',
	'phalanx-type-content' => 'содржина на страницата',
	'phalanx-type-summary' => 'опис на страницата',
	'phalanx-type-title' => 'наслов на страницата',
	'phalanx-type-user' => 'корисник',
	'phalanx-type-answers-question-title' => 'наслов на прашањето',
	'phalanx-type-answers-recent-questions' => 'скорешни прашања',
	'phalanx-type-wiki-creation' => 'создавање на вики',
	'phalanx-add-block' => 'Примени блок',
	'phalanx-edit-block' => 'Зачувај блок',
	'phalanx-label-filter' => 'Филтер:',
	'phalanx-label-reason' => 'Причина:',
	'phalanx-label-expiry' => 'Истекува:',
	'phalanx-label-type' => 'Тип:',
	'phalanx-label-lang' => 'Јазик:',
	'phalanx-view-type' => 'Тип на блок...',
	'phalanx-view-blocker' => 'Пребарај по филтриран текст:',
	'phalanx-view-blocks' => 'Пребарај филтри',
	'phalanx-view-id' => 'Дај филтер по назнака:',
	'phalanx-view-id-submit' => 'Дај филтер',
	'phalanx-format-text' => 'прост текст',
	'phalanx-format-regex' => 'рег. израз',
	'phalanx-format-case' => 'разликувај гол/мал букв.',
	'phalanx-format-exact' => 'точно',
	'phalanx-tab-main' => 'Раководење со филтри',
	'phalanx-tab-secondary' => 'Испробај филтри',
	'phalanx-block-success' => 'Блокот е успешо додаден',
	'phalanx-block-failure' => 'Се појави грешка при додавањето на блокот',
	'phalanx-modify-success' => 'Блокот е успешно изменет',
	'phalanx-modify-failure' => 'Се појави грешка при менувањето на блокот',
	'phalanx-modify-warning' => 'Го уредувате блокот со назнака бр. $1.
Ако стиснете на „{{int:phalanx-add-block}}“ ќе ги зачувате промените!',
	'phalanx-test-description' => 'Испробајте дали тековните блокови реагираат на даден текст',
	'phalanx-test-submit' => 'Испробај',
	'phalanx-test-results-legend' => 'Исход од испробувањето',
	'phalanx-display-row-blocks' => 'блокови: $1',
	'phalanx-display-row-created' => "создадено од '''$1''' на $2",
	'phalanx-link-unblock' => 'одблокирај',
	'phalanx-link-modify' => 'измени',
	'phalanx-link-stats' => 'статистики',
	'phalanx-reset-form' => 'Исчисти го образецот',
	'phalanx-legend-input' => 'Создај или измени филтер',
	'phalanx-legend-listing' => 'Филтри во тековна примена',
	'phalanx-unblock-message' => 'Блокот со назнака бр. $1 е успешно отстранет',
	'phalanx-help-type-content' => 'Овој филтер спречува зачувување на уредување ако неговата содржина одговара на некој израз наведен на црниот список.',
	'phalanx-help-type-summary' => 'Овој филтер спречува зачувување на уредување ако неговиот опис одговара на некој израз наведен на црниот список.',
	'phalanx-help-type-title' => 'Овој филтер спречува создавање на страница ако нејзиниот наслов одговара на некој израз наведен на црниот список.

Филтерот не спречува уредување на веќе постоечка страница.',
	'phalanx-help-type-user' => 'Овој филтер блокира корисник (сосем исто како локален блок на МедијаВики) ако неговото име или IP-адреса одговара на некое име или IP-адреса наведена на црниот список.',
	'phalanx-help-type-wiki-creation' => 'Овој филтер спречува создавање на вики ако неговото име или URL-адреса одговара на нешто од наведеното на црниот список.',
	'phalanx-help-type-answers-question-title' => 'Овој филтер блокира создавање на прашање (страница) ако насловот одговара на некој од изразите наведени на црниот список.

Напомена: работи само на викија за одговорање на прашања',
	'phalanx-help-type-answers-recent-questions' => 'Овој филтер спречува приказ на прашања (страници) во низа изводи (посреднички елементи, списоци, пописи направени со ознаки). 
Филтерот не спречува создавање на таквите страници.

Напомена: работи само на викија за одговорање на прашања',
	'phalanx-user-block-reason-ip' => 'Оваа IP-адреса е спречена да уредува поради вандализам или друго нарушување од страна на вас или некој што ја користи вашата IP-адреса.
Доколку сметате дека со ова правиме грешка, [[Special:Contact|контактирајте ја Викија]].',
	'phalanx-user-block-reason-exact' => 'Ова корисничко име или IP-адреса е спречена да уредува поради вандализам или друго нарушување.
Доколку сметате дека со ова правиме грешка, [[Special:Contact|контактирајте ја Викија]].',
	'phalanx-user-block-reason-similar' => 'Ова корисничко име е спречено да уредува поради вандализам или друго нарушување од страна на корисник со слично име.
Направете друго корисничко име, или пак [[Special:Contact|известете ја Викија]] за проблемот.',
	'phalanx-title-move-summary' => 'Причината е тоа што внесовте блокиран израз.',
	'phalanx-content-spam-summary' => 'Текстот е пронајден во описот на страницата.',
	'phalanx-stats-title' => 'Статистики за Phalanx',
	'phalanx-stats-block-notfound' => 'не е пронајдена таква назнака на блок',
	'phalanx-stats-table-id' => 'Назнака на блокот',
	'phalanx-stats-table-user' => 'Додадено од',
	'phalanx-stats-table-type' => 'Тип',
	'phalanx-stats-table-create' => 'Создадено',
	'phalanx-stats-table-expire' => 'Истекува',
	'phalanx-stats-table-exact' => 'Точно',
	'phalanx-stats-table-regex' => 'Рег. израз',
	'phalanx-stats-table-case' => 'Регистар',
	'phalanx-stats-table-language' => 'Јазик',
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-reason' => 'Причина',
	'phalanx-stats-row' => "во $4, филтерот од типот '''$1''' го блокирал корисникот '''$2''' на $3",
	'phalanx-stats-row-per-wiki' => "корисникот '''$2''' е блокиран на '''$4''' од филтерот со назнака '''$3''' ($5) (тип: '''$1''')",
	'phalanx-rule-log-name' => 'Дневник на правила за Phalanx',
	'phalanx-rule-log-header' => 'Ова е дневник на измените во правилата на Phalanx.',
	'phalanx-rule-log-add' => 'Додадено правилото: $1',
	'phalanx-rule-log-edit' => 'Изменето правилото: $1',
	'phalanx-rule-log-delete' => 'Избришано правилото: $1',
	'phalanx-rule-log-details' => 'Филтер: „$1“, тип: „$2“, причина: „$3“',
	'phalanx-stats-table-wiki-id' => 'Назнака на викито',
	'phalanx-stats-table-wiki-name' => 'Име на викито',
	'phalanx-stats-table-wiki-url' => 'URL на викито',
	'phalanx-stats-table-wiki-last-edited' => 'Последно уредување',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'phalanx-desc' => 'Phalanx  is een Geïntegreerd Spamafweersysteem',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Geïntegreerd Spamafweersysteem',
	'phalanx-type-content' => 'paginainhoud',
	'phalanx-type-summary' => 'paginasamenvatting',
	'phalanx-type-title' => 'paginanaam',
	'phalanx-type-user' => 'gebruiker',
	'phalanx-type-answers-question-title' => 'vraag',
	'phalanx-type-answers-recent-questions' => 'recente vragen',
	'phalanx-type-wiki-creation' => 'wikiaanmaak',
	'phalanx-add-block' => 'Blokkade toepassen',
	'phalanx-edit-block' => 'Blokkade opslaan',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Reden:',
	'phalanx-label-expiry' => 'Vervalt:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Taal:',
	'phalanx-view-type' => 'Type blokkade...',
	'phalanx-view-blocker' => 'Zoeken op filtertekst:',
	'phalanx-view-blocks' => 'Filters doorzoeken',
	'phalanx-view-id' => 'Filter op nummer zoeken:',
	'phalanx-view-id-submit' => 'Filter zoeken',
	'phalanx-format-text' => 'platte tekst',
	'phalanx-format-regex' => 'reguliere expressie',
	'phalanx-format-case' => 'hoofdlettergevoelig',
	'phalanx-format-exact' => 'precies',
	'phalanx-tab-main' => 'Filters beheren',
	'phalanx-tab-secondary' => 'Filters testen',
	'phalanx-block-success' => 'De blokkade is toegevoegd',
	'phalanx-block-failure' => 'Er is een fout opgetreden tijdens het toevoegen van de blokkade',
	'phalanx-modify-success' => 'De blokkade is aangepast',
	'phalanx-modify-failure' => 'Er is een fout opgetreden tijdens het aanpassen van de blokkade',
	'phalanx-modify-warning' => 'U bent blokkadenummer #$1 aan het bewerken.
Als u op "{{int:phalanx-add-block}}" klikt, worden uw wijzigingen opgeslagen.',
	'phalanx-test-description' => 'Opgegeven tekst tegen huidige blokkades testen.',
	'phalanx-test-submit' => 'Testen',
	'phalanx-test-results-legend' => 'Testresulaten',
	'phalanx-display-row-blocks' => 'blokkades: $1',
	'phalanx-display-row-created' => "aangemaakt door '''$1''' op $2",
	'phalanx-link-unblock' => 'blokkade opheffen',
	'phalanx-link-modify' => 'aanpassen',
	'phalanx-link-stats' => 'statistieken',
	'phalanx-reset-form' => 'Formulier opnieuw instellen',
	'phalanx-legend-input' => 'Filter aanmaken of aanpassen',
	'phalanx-legend-listing' => 'Huidige actieve filters',
	'phalanx-unblock-message' => 'Blokkadenummer #$1 is verwijderd',
	'phalanx-help-type-content' => 'Dit filter voorkomt dat een bewerking wordt opgeslagen als in de inhoud tekst voorkomt die op de zwarte lijst staat.',
	'phalanx-help-type-summary' => 'Dit filter voorkomt dat een bewerking wordt opgeslagen als in de samenvatting tekst voorkomt die op de zwarte lijst staat.',
	'phalanx-help-type-title' => 'Dit filter voorkomt dat een pagina wordt aangemaakt als in de paginanaam tekst voorkomt die op de zwarte lijst staat.

Dit filter voorkomt niet dat een bestaande pagina bewerkt kan worden.',
	'phalanx-help-type-user' => 'Dit filter blokkeert een gebruiker (net zoals lokale blokkades in MediaWiki) als de gebruikersnaam of het IP-adres voorkomt in de zwarte lijst met namen en IP-adressen.',
	'phalanx-help-type-wiki-creation' => 'Dit filter voorkomt dat een wiki wordt aangemaakt als tekst uit de naam of de URL op de zwarte lijst staat.',
	'phalanx-help-type-answers-question-title' => "Dit filter voorkomt dat een pagina wordt aangemaakt als tekst uit de paginanaam op de zwarte lijst staat.

Dit werkt alleen voor Antwoordwiki's.",
	'phalanx-help-type-answers-recent-questions' => "Dit filter voorkomt dat vragen (pagina's) worden weergegeven in een aantal lijsten (widgets, lijsten, labelgebaseerde lijsten).
Het voorkomt niet dat pagina's worden aangemaakt.

Dit werkt alleen voor Antwoordwiki's.",
	'phalanx-user-block-reason-ip' => 'Gebruikers vanaf dit IP-adres mogen niet bewerken wegens vandalisme of verstoring door u of door iemand met hetzelfde IP-adres.
Als u denk dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]].',
	'phalanx-user-block-reason-exact' => 'Deze (anonieme) gebruiker mag niet bewerken wegens vandalisme of verstoring.
Als u denkt dat dit ten onrechte is, [[Special:Contact|neem dan contact op met Wikia]]',
	'phalanx-user-block-reason-similar' => 'Deze gebruiker mag niet bewerken wegens vandalisme of verstoring door een gebruiker met een gelijkluidende naam.
Kies een andere gebruikersnaam of [[Special:Contact|neem contact op met Wikia]] over het probleem.',
	'phalanx-title-move-summary' => 'De samenvatting die u hebt opgegeven bevat niet toegelaten tekst.',
	'phalanx-content-spam-summary' => 'De tekst is aangetroffen in de bewerkingssamenvatting.',
	'phalanx-stats-title' => 'Phalanx-statistieken',
	'phalanx-stats-block-notfound' => 'blokkadenummer niet gevonden',
	'phalanx-stats-table-id' => 'Blokkadenummer',
	'phalanx-stats-table-user' => 'Toegevoegd door',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Aangemaakt',
	'phalanx-stats-table-expire' => 'Vervalt',
	'phalanx-stats-table-exact' => 'Precies',
	'phalanx-stats-table-regex' => 'Reguliere expressie',
	'phalanx-stats-table-case' => 'Hoofd- of kleine letters',
	'phalanx-stats-table-language' => 'Taal',
	'phalanx-stats-table-text' => 'Tekst',
	'phalanx-stats-table-reason' => 'Reden',
	'phalanx-stats-row' => "om $4 heeft filtertype '''$1''' '''$2''' geblokkeerd op $3",
	'phalanx-stats-row-per-wiki' => "gebruiker '''$2''' is geblokkeerd op '''$4''' door filternummer '''$3''' ($5) (type '''$1''')",
	'phalanx-rule-log-name' => 'Logboek Phalanx-regels',
	'phalanx-rule-log-header' => 'Dit is een logboek met wijzigingen aan Phalanx-regels',
	'phalanx-rule-log-add' => 'Phalanx-regel toegevoegd: $1',
	'phalanx-rule-log-edit' => 'Phalanx-regel gewijzigd: $1',
	'phalanx-rule-log-delete' => 'Phalanx-regel verwijderd: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", type: "$2", reden: "$3"',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wikinaam',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Laatste bewerking',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'phalanx-desc' => 'Phalanx er en integrert mekanisme for forsvar mot spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Integrert mekanisme for forsvar mot spam',
	'phalanx-type-content' => 'sideinnhold',
	'phalanx-type-summary' => 'sidesammendrag',
	'phalanx-type-title' => 'sidetittel',
	'phalanx-type-user' => 'bruker',
	'phalanx-type-answers-question-title' => 'spørsmålstittel',
	'phalanx-type-answers-recent-questions' => 'siste spørsmål',
	'phalanx-type-wiki-creation' => 'wiki-opprettelse',
	'phalanx-add-block' => 'Utfør blokkering',
	'phalanx-edit-block' => 'Lagre blokkering',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Årsak:',
	'phalanx-label-expiry' => 'Utløpstid:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Språk:',
	'phalanx-view-type' => 'Blokkeringstype...',
	'phalanx-view-blocker' => 'Søk etter filtrert tekst:',
	'phalanx-view-blocks' => 'Søkefilter',
	'phalanx-view-id' => 'Hent filter etter ID:',
	'phalanx-view-id-submit' => 'Hent filter',
	'phalanx-format-text' => 'ren tekst',
	'phalanx-format-regex' => 'regulært uttrykk',
	'phalanx-format-case' => 'skiller mellom store og små bokstaver',
	'phalanx-format-exact' => 'nøyaktig',
	'phalanx-tab-main' => 'Administrer filtre',
	'phalanx-tab-secondary' => 'Test filtre',
	'phalanx-block-success' => 'Blokkeringen ble lagt til',
	'phalanx-block-failure' => 'Det oppstod en feil ved innleggingen av blokkeringen',
	'phalanx-modify-success' => 'Blokkeringen ble endret',
	'phalanx-modify-failure' => 'Det oppstod en feil under endring av blokkeringen',
	'phalanx-modify-warning' => 'Du redigerer blokkering ID #$1.
Å trykke «{{int:phalanx-add-block}}» vil lagre endringene!',
	'phalanx-test-description' => 'Testen ga tekst mot aktuelle blokkeringer.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Testresultater',
	'phalanx-display-row-blocks' => 'blokkeringer: $1',
	'phalanx-display-row-created' => "opprettet av '''$1''' på $2",
	'phalanx-link-unblock' => 'opphev blokkering',
	'phalanx-link-modify' => 'endre',
	'phalanx-link-stats' => 'statistikk',
	'phalanx-reset-form' => 'Tilbakestill skjema',
	'phalanx-legend-input' => 'Opprett eller endre filter',
	'phalanx-legend-listing' => 'For øyeblikket brukte filtre',
	'phalanx-unblock-message' => 'Blokkering ID #$1 ble fjernet',
	'phalanx-help-type-content' => 'Dette filteret hindrer en redigering fra å lagres om innholdet samsvarer med noen av de svartelistede setningene.',
	'phalanx-help-type-summary' => 'Dette filteret hindrer en redigering fra å lagres om det oppgitte sammendraget samsvarer med noen av de svartelistede setningene.',
	'phalanx-help-type-title' => 'Dette filteret hindrer en side fra å bli opprettet hvis tittelen samsvarer med noen av de svartelistede setningene.

Det hindrer ikke en allerede eksisterende side i å redigeres.',
	'phalanx-help-type-user' => 'Dette filteret blokkerer en bruker (nøyaktig det samme som en lokal MediaWiki-blokkering) dersom navnet eller IP-adressen samsvarer et av de svartelistede navnene eller IP-adressene.',
	'phalanx-help-type-wiki-creation' => 'Dette filteret hindrer en wiki i å opprettes om navnet eller URL-en samsvarer med noen av de svartelistede setningene.',
	'phalanx-help-type-answers-question-title' => 'Dette filteret blokkerer et spørsmål (en side) fra å opprettes dersom tittelen samsvarer med noen av de svartelistede setningene.

Note: fungerer kun på Svar-wikier.',
	'phalanx-help-type-answers-recent-questions' => 'Dette filteret hindrer spørsmål (sider) fra å vises i en rekke kanaler (skjermelementer, lister, tag-genererte lister).
Det hindrer ikke disse sidene i å opprettes.

Note: fungerer kun på Svar-wikier.',
	'phalanx-user-block-reason-ip' => 'Denne IP-adressen er forhindret i å redigere grunnet vandalisme eller annt hærverk fra deg eller noen som deler din IP-adresse.
Om du mener dette er en feil, vennligst [[Special:Contact|kontakt Wikia]].',
	'phalanx-user-block-reason-exact' => 'Dette brukernavnet eller IP-adressen er forhindret i år redigere grunnet vandalisme eller annet hærverk. 
Om du mener dette er en feil, vennligst [[Special:Contact|kontakt Wikia]].',
	'phalanx-user-block-reason-similar' => 'Dette brukernavnet er forhindret i å redigere grunnet vandalisme eller annet hærverk av en bruker med lignende navn.
Vennligst opprett et alternativt brukernavn eller [[Special:Contact|kontakt Wikia]] om problemet.',
	'phalanx-title-move-summary' => 'Årsaken du angav inneholdt en blokkert setning.',
	'phalanx-content-spam-summary' => 'Teksten ble funnet i sidens sammendrag.',
	'phalanx-stats-title' => 'Phalanx-statistikk',
	'phalanx-stats-block-notfound' => 'blokkerings-ID ikke funnet',
	'phalanx-stats-table-id' => 'Blokkerings-ID',
	'phalanx-stats-table-user' => 'Lagt til av',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Opprettet',
	'phalanx-stats-table-expire' => 'Utløper',
	'phalanx-stats-table-exact' => 'Nøyaktig',
	'phalanx-stats-table-regex' => 'Regulært uttrykk',
	'phalanx-stats-table-case' => 'Sak',
	'phalanx-stats-table-language' => 'Språk',
	'phalanx-stats-table-text' => 'Tekst',
	'phalanx-stats-table-reason' => 'Årsak',
	'phalanx-stats-row' => "på $4, filtertype '''$1''' blokkerte '''$2''' på $3",
	'phalanx-stats-row-per-wiki' => "bruker '''$2''' ble blokkert på '''$4''' av filter ID '''$3''' ($5) (type: '''$1''')",
	'phalanx-rule-log-name' => 'Logg for Phalanx-regler',
	'phalanx-rule-log-header' => 'Dette er en logg over endringer i phalanx-reglene.',
	'phalanx-rule-log-add' => 'Phalanx-regel lagt til: $1',
	'phalanx-rule-log-edit' => 'Phalanx-regel redigert: $1',
	'phalanx-rule-log-delete' => 'Phalanx-regel slettet: $1',
	'phalanx-rule-log-details' => 'Filter: «$1», type: «$2», årsak: «$3»',
	'phalanx-stats-table-wiki-id' => 'Wiki-ID',
	'phalanx-stats-table-wiki-name' => 'Wiki-navn',
	'phalanx-stats-table-wiki-url' => 'Wiki-URL',
	'phalanx-stats-table-wiki-last-edited' => 'Sist redigert',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author SandroHc
 */
$messages['pt'] = array(
	'phalanx-desc' => 'Phalanx é um Mecanismo Integrado Anti-Spam',
	'phalanx' => 'Phalanx',
	'phalanx-title' => 'Phalanx - Mecanismo Integrado Anti-Spam',
	'phalanx-type-content' => 'conteúdo da página',
	'phalanx-type-summary' => 'resumo da página',
	'phalanx-type-title' => 'título da página',
	'phalanx-type-user' => 'utilizador',
	'phalanx-type-answers-question-title' => 'título da pergunta',
	'phalanx-type-answers-recent-questions' => 'perguntas recentes',
	'phalanx-type-wiki-creation' => 'criação de wikis',
	'phalanx-add-block' => 'Aplicar bloco',
	'phalanx-edit-block' => 'Gravar bloco',
	'phalanx-label-filter' => 'Filtro:',
	'phalanx-label-reason' => 'Motivo:',
	'phalanx-label-expiry' => 'Expiração:',
	'phalanx-label-type' => 'Tipo:',
	'phalanx-label-lang' => 'Língua:',
	'phalanx-view-type' => 'Tipo de bloco...',
	'phalanx-view-blocker' => 'Pesquisar o texto de filtro:',
	'phalanx-view-blocks' => 'Procurar filtros',
	'phalanx-view-id' => 'Obter filtro por ID:',
	'phalanx-tab-main' => 'Gerir Filtros',
	'phalanx-display-row-created' => "criado por '''$1''' em $2",
	'phalanx-link-modify' => 'modificar',
	'phalanx-stats-table-type' => 'Tipo',
	'phalanx-stats-table-create' => 'Criado',
	'phalanx-stats-table-expire' => 'Expira',
	'phalanx-stats-table-exact' => 'Exato',
	'phalanx-stats-table-regex' => 'Expressão regular',
	'phalanx-stats-table-language' => 'Língua',
	'phalanx-stats-table-text' => 'Texto',
	'phalanx-stats-table-reason' => 'Motivo',
	'phalanx-rule-log-details' => 'Filtro: "$1", tipo: "$2", motivo: "$3"',
	'phalanx-stats-table-wiki-id' => 'ID da Wiki',
	'phalanx-stats-table-wiki-name' => 'Nome da Wiki',
	'phalanx-stats-table-wiki-url' => 'URL da Wiki',
	'phalanx-stats-table-wiki-last-edited' => 'Última edição',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'phalanx-type-content' => 'садржај странице',
	'phalanx-type-summary' => 'сажетак странице',
	'phalanx-type-title' => 'наслов странице',
	'phalanx-type-user' => 'корисник',
	'phalanx-type-answers-recent-questions' => 'скорашња питања',
	'phalanx-add-block' => 'Примени забрану',
	'phalanx-edit-block' => 'Сачувај забрану',
	'phalanx-label-filter' => 'Филтер:',
	'phalanx-label-expiry' => 'Истек:',
	'phalanx-label-type' => 'Врста:',
	'phalanx-label-lang' => 'Језик:',
	'phalanx-view-type' => 'Врста забране...',
	'phalanx-view-blocks' => 'Претражи филтере',
	'phalanx-format-text' => 'чист текст',
	'phalanx-link-modify' => 'измени',
	'phalanx-stats-table-user' => 'Додао/-ла',
	'phalanx-stats-table-type' => 'Врста',
	'phalanx-stats-table-language' => 'Језик',
	'phalanx-stats-table-text' => 'Текст',
	'phalanx-stats-table-reason' => 'Разлог',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'phalanx-type-content' => 'పుట విషయం',
	'phalanx-type-summary' => 'పుట సారాంశం',
	'phalanx-type-title' => 'పుట శీర్షిక',
	'phalanx-type-user' => 'వాడుకరి',
	'phalanx-type-answers-recent-questions' => 'ఇటీవలి ప్రశ్నలు',
	'phalanx-label-reason' => 'కారణం:',
	'phalanx-label-type' => 'రకం:',
	'phalanx-label-lang' => 'భాష:',
	'phalanx-test-results-legend' => 'పరీక్షా ఫలితాలు',
	'phalanx-link-stats' => 'గణాంకాలు',
	'phalanx-stats-table-language' => 'భాష',
	'phalanx-stats-table-text' => 'పాఠ్యం',
	'phalanx-stats-table-reason' => 'కారణం',
	'phalanx-stats-table-wiki-name' => 'వికీ పేరు',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'phalanx-label-reason' => 'Причина:',
	'phalanx-label-lang' => 'Мова:',
);

