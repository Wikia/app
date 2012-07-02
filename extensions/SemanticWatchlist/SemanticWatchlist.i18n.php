<?php

/**
 * Internationalization file for the Semantic Watchlist extension.
 *
 * @since 0.1
 *
 * @file SemanticWatchlist.i18n.php
 * @ingroup SemanticWatchlist
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'semanticwatchlist-desc' => 'Lets users be notified of specific changes to Semantic MediaWiki data',

	'right-semanticwatch' => 'Use semantic watchlist',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Modify]] the semantic watchlist groups',

	'special-semanticwatchlist' => 'Semantic Watchlist',
	'special-watchlistconditions' => 'Semantic watchlist conditions',

	'group-swladmins' => 'Semantic Watchlist admins',
	'group-swladmins-member' => 'Semantic Watchlist admin',
	'grouppage-swladmins' => 'Project:Semantic_Watchlist_admins',

	// Special:WatchlistConditions
	'swl-group-name' => 'Group name:',
	'swl-group-properties' => 'Properties covered by this group:',
	'swl-group-remove-property' => 'Remove property',
	'swl-group-add-property' => 'Add property',
	'swl-group-page-selection' => 'Pages in',
	'swl-group-save' => 'Save',
	'swl-group-delete' => 'Delete',
	'swl-group-category' => 'category',
	'swl-group-namespace' => 'namespace',
	'swl-group-concept' => 'concept',
	'swl-group-confirmdelete' => 'Are you sure you want to delete the "$1" watchlist group?',
	'swl-group-save-all' => 'Save all',
	'swl-group-add-new-group' => 'Add a new group',
	'swl-group-add-group' => 'Add group',

	// Special:SemanticWatchlist
	'swl-watchlist-position' => "Showing '''$1''' of the last {{PLURAL:$1|change|changes}} starting with '''#$2'''.",
	'swl-watchlist-insertions' => 'New:',
	'swl-watchlist-deletions' => 'Old:',
	'swl-watchlist-pagincontrol' => 'View ($1) ($2)',
	'swl-watchlist-firstn' => 'first $1',
	'swl-watchlist-firstn-title' => 'First $1 {{PLURAL:$1|result|results}}',
	'swl-watchlist-no-items' => 'You have no items on your watchlist.',
	'swl-watchlist-can-mod-groups' => 'You can [[$1|modify the watchlist groups]].', 
	'swl-watchlist-can-mod-prefs' => 'You can [[$1|modify your watchlist preferences]], including setting which properties to watch.',
	'swl-watchlist-no-groups' => 'You are not yet watching any watchlist groups. [[$1|Modify your watchlist preferences]].',
	
	// Email
	'swl-email-propschanged' => 'Properties have changed at $1',
	'swl-email-propschanged-long' => "One or more properties you watch at '''$1''' have been changed by user '''$2''' at $4 on $5. You can view these and other changes on [$3 your semantic watchlist].",
	'swl-email-changes' => 'Property changes on [$2 $1]:',

	// Preferences
	'prefs-swl' => 'Semantic watchlist',
	'prefs-swlgroup' => 'Groups to watch',
	'prefs-swlglobal' => 'General options',
	'swl-prefs-emailnofity' => 'E-mail me on changes to properties I am watching',
	'swl-prefs-watchlisttoplink' => 'Show a link to the Semantic Watchlist on the top of the page',
	'swl-prefs-category-label' => "'''$1''': {{PLURAL:$2|property|properties}} $3 from category ''$4''",
	'swl-prefs-namespace-label' => "'''$1''': {{PLURAL:$2|property|properties}} $3 from namespace ''$4''",
	'swl-prefs-concept-label' => "'''$1''': {{PLURAL:$2|property|properties}} $3 from concept ''$4''",

	// API
	'swl-err-userid-xor-groupids' => 'Either the userid or the groupids parameter needs to be specified, but not both.',
);

/** Message documentation (Message documentation)
 * @author Jeroen De Dauw
 * @author Nemo bis
 */
$messages['qqq'] = array(
	'semanticwatchlist-desc' => '{{desc}}',
	'right-semanticwatch' => '{{doc-right|semanticwatch}}',
	'right-semanticwatchgroups' => '{{doc-right|semanticwatchgroups}}',
	'swl-watchlist-position' => "The message explains how many changes are displayed in the special page ($1) and what's the number of the first one shown ($2): the special page provides results in paginated format.",
	'swl-email-propschanged-long' => '$1: wiki name, $2: user name, $3: url, $4: time, $5: date',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'swl-group-save' => 'Съхраняване',
	'swl-group-delete' => 'Изтриване',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'swl-group-save' => 'Enrollañ',
	'swl-group-delete' => 'Dilemel',
	'swl-group-category' => 'rummad',
	'swl-group-namespace' => 'esaouenn anv',
	'swl-group-save-all' => 'Enrollañ pep tra',
	'swl-group-add-new-group' => 'Ouzhpennañ ur strollad nevez',
	'swl-group-add-group' => 'Ouzhpennañ ur strollad',
	'swl-watchlist-insertions' => 'Ouzhpennet :',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Purodha
 */
$messages['de'] = array(
	'semanticwatchlist-desc' => 'Ermöglicht die Benachrichtigung von Benutzern zu bestimmten Änderungen an semantischen Daten',
	'right-semanticwatch' => 'Semantische Beobachtungslisten verwenden',
	'right-semanticwatchgroups' => 'Semantische Beobachtungslisten [[Special:WatchlistConditions|anpassen]]',
	'special-semanticwatchlist' => 'Semantische Beobachtungsliste',
	'special-watchlistconditions' => 'Einstellungen zu semantischen Beobachtungslisten',
	'group-swladmins' => 'SWL-Administratoren',
	'group-swladmins-member' => 'SWL-Administrator',
	'grouppage-swladmins' => 'Project:SWL-Administratoren',
	'swl-group-name' => 'Gruppenname:',
	'swl-group-properties' => 'Attribute zu dieser Gruppe:',
	'swl-group-remove-property' => 'Attribut entfernen',
	'swl-group-add-property' => 'Attribut hinzufügen',
	'swl-group-page-selection' => 'Seiten in',
	'swl-group-save' => 'Speichern',
	'swl-group-delete' => 'Löschen',
	'swl-group-category' => 'Kategorie',
	'swl-group-namespace' => 'Namensraum',
	'swl-group-concept' => 'Konzept',
	'swl-group-confirmdelete' => 'Soll die Beobachtungsliste "$1" tatsächlich gelöscht werden?',
	'swl-group-save-all' => 'Alle speichern',
	'swl-group-add-new-group' => 'Eine neue Gruppe hinzufügen',
	'swl-group-add-group' => 'Eine Gruppe hinzufügen',
	'swl-watchlist-position' => "Anzeige der letzten '''$1''' Änderungen beginnend mit '''#$2'''.",
	'swl-watchlist-insertions' => 'Hinzugefügt:',
	'swl-watchlist-deletions' => 'Alt:',
	'swl-watchlist-pagincontrol' => 'Zeige ($1) ($2)',
	'swl-watchlist-firstn' => 'erstes $1',
	'swl-watchlist-firstn-title' => '{{PLURAL:$1|Das erste Ergebnis|Die ersten $1 Ergebnisse}}',
	'swl-watchlist-no-items' => 'Es befinden sich keine Einträge auf deiner Beobachtungsliste.',
	'swl-watchlist-can-mod-groups' => 'Du kannst [[$1|die Gruppen]] anpassen.',
	'swl-watchlist-can-mod-prefs' => 'Du kannst [[$1|die Einstellungen der semantischen Beobachtungsliste]], einschließlich der zu beobachtenden Attribute, anpassen.',
	'swl-watchlist-no-groups' => 'Du beobachtest bislang noch keine Gruppen. [[$1|Pass deine Einstellungen an]].',
	'swl-email-propschanged' => 'Attribute wurden auf $1 geändert',
	'swl-email-propschanged-long' => "Eines oder mehrere der auf '''$1''' beobachteten Attribute wurden von Benutzer '''$2''' am $4 um $5 Uhr geändert. Diese und andere Änderungen werden auf [$3 dieser semantischen Beobachtungsliste] angezeigt.",
	'swl-email-changes' => 'Attributänderungen auf [$2 $1]:',
	'prefs-swl' => 'Semantische Beobachtungsliste',
	'prefs-swlgroup' => 'Zu beobachtende Gruppen',
	'prefs-swlglobal' => 'Allgemeine Optionen',
	'swl-prefs-emailnofity' => 'Bei Änderungen an beobachteten Attributen E-Mails senden',
	'swl-prefs-watchlisttoplink' => 'Einen Link zur semantischen Beobachtungsliste oben auf der Seite im Benutzermenü anzeigen',
	'swl-prefs-category-label' => "'''$1''': {{PLURAL:$2|Attribut|Attribute}} $3 in Kategorie ''$4''",
	'swl-prefs-namespace-label' => "'''$1''': {{PLURAL:$2|Attribut|Attribute}} $3 im Namensraum ''$4''",
	'swl-prefs-concept-label' => "'''$1''': {{PLURAL:$2|Attribut|Attribute}} $3 im Konzept ''$4''",
	'swl-err-userid-xor-groupids' => 'Es muss entweder der Parameter für die Benutzerkennung oder für die Gruppenkennung angegeben werden, jedoch nicht beide gleichzeitig.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'swl-watchlist-no-items' => 'Es befinden sich keine Einträge auf Ihrer Beobachtungsliste.',
	'swl-watchlist-can-mod-groups' => 'Sie können [[$1|die Gruppen]] anpassen.',
	'swl-watchlist-can-mod-prefs' => 'Sie können [[$1|die Einstellungen der semantischen Beobachtungsliste]], einschließlich der zu beobachtenden Attribute, anpassen.',
	'swl-watchlist-no-groups' => 'Sie beobachten bislang noch keine Gruppen. [[$1|Passen Sie Ihre Einstellungen an]].',
);

/** Spanish (Español)
 * @author Mor
 */
$messages['es'] = array(
	'swl-group-name' => 'Nombre del grupo:',
	'swl-group-remove-property' => 'Quitar propiedad',
	'swl-group-add-property' => 'Añadir propiedad',
	'swl-group-save' => 'Guardar',
	'swl-group-delete' => 'Borrar',
	'swl-group-category' => 'categoría',
	'swl-watchlist-insertions' => 'Añadido:',
	'swl-watchlist-deletions' => 'Borrado:',
	'swl-prefs-emailnofity' => 'Enviarme un mensaje de correo electrónico sobre los cambios en las propiedades que estoy vigilando',
);

/** French (Français)
 * @author IAlex
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'semanticwatchlist-desc' => 'Permet de définir des groupes de propriétés sémantiques pour une ou plusieurs catégories / espaces de noms qui peuvent ensuite être inscrits sur la liste de suivi sémantique',
	'right-semanticwatch' => 'Utiliser la liste de suivi sémantique',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Modifier]] les groupes de la liste de suivi sémantique',
	'special-semanticwatchlist' => 'Liste de suivi sémantique',
	'special-watchlistconditions' => 'Paramètres de la liste de suivi sémantique',
	'swl-group-name' => 'Nom du groupe:',
	'swl-group-properties' => 'Propriétés de ce groupe :',
	'swl-group-remove-property' => 'Retirez la propriété',
	'swl-group-add-property' => 'Ajouter une propriété',
	'swl-group-page-selection' => 'Pages dans la',
	'swl-group-save' => 'Enregistrer',
	'swl-group-delete' => 'Supprimer',
	'swl-group-category' => 'catégorie',
	'swl-group-namespace' => 'espace de noms',
	'swl-group-concept' => 'concept',
	'swl-group-confirmdelete' => 'Etes-vous certain de vouloir supprimer le groupe de liste d\'alerte "$1" ?',
	'swl-group-save-all' => 'Enregistrer tout',
	'swl-group-add-new-group' => 'Ajouter un nouveau groupe',
	'swl-group-add-group' => 'Ajouter un groupe',
	'swl-watchlist-position' => "'''Afficher $1''' des derniers changements en commençant par '''#$2'''.",
	'swl-watchlist-insertions' => 'Ajouté :',
	'swl-watchlist-deletions' => 'Supprimé :',
	'swl-watchlist-pagincontrol' => 'Voir ($1) ($2)',
	'swl-watchlist-firstn' => '$1 premiers',
	'swl-watchlist-firstn-title' => '$1 {{PLURAL:$1|permier résultat|premiers résultats}}',
	'swl-email-propschanged' => 'Les propriétés ont changé à $1',
	'swl-email-propschanged-long' => "Une ou plusieurs propriétés que vous suivez à '''$1'' ont été modifiées par l'utilisateur '''$2''' à $4 sur $5 . Vous pouvez visualiser ces modifications et d'autres sur [$3 votre liste de suivi sémantique].",
	'swl-email-changes' => 'Changements de propriétés sur [$2 $1] :',
	'prefs-swl' => 'Liste de suivi sémantique',
	'prefs-swlgroup' => 'Groupes à suivre',
	'swl-prefs-emailnofity' => "Envoyez-moi un courriel sur les modifications apportées aux propriétés que j'ai en liste de suivi",
	'swl-prefs-category-label' => "'''$1''' : {{PLURAL:$2| propriété|propriétés}} $3 de la catégorie ''$4''",
	'swl-prefs-namespace-label' => "'''$1''' : {{PLURAL:$2|propriété|propriétés}} $3 de l'espace de noms ''$4''",
	'swl-prefs-concept-label' => "'''$1''' : {{PLURAL:$2|propriété|propriétés}} $3 du concept ''$4''",
	'swl-err-userid-xor-groupids' => 'Il faut spécifier <code>userid</code> ou <code>groupid</code>, mais pas les deux en même temps.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'right-semanticwatch' => 'Utilisar la lista de survelyence sèmantica',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Changiér]] les tropes de la lista de survelyence sèmantica',
	'special-semanticwatchlist' => 'Lista de survelyence sèmantica',
	'special-watchlistconditions' => 'Paramètres de la lista de survelyence sèmantica',
	'swl-group-name' => 'Nom de la tropa :',
	'swl-group-properties' => 'Propriètâts de ceta tropa :',
	'swl-group-remove-property' => 'Enlevar una propriètât',
	'swl-group-add-property' => 'Apondre una propriètât',
	'swl-group-page-selection' => 'Pâges dens la',
	'swl-group-save' => 'Encartar',
	'swl-group-delete' => 'Suprimar',
	'swl-group-category' => 'catègorie',
	'swl-group-namespace' => 'èspâço de noms',
	'swl-group-concept' => 'concèpte',
	'swl-group-confirmdelete' => 'Éte-vos de sûr de volêr suprimar la tropa de la lista de survelyence « $1 » ?',
	'swl-group-save-all' => 'Encartar tot',
	'swl-group-add-new-group' => 'Apondre una tropa novèla',
	'swl-group-add-group' => 'Apondre una tropa',
	'swl-watchlist-position' => "Fâre vêre '''$1''' des dèrriérs changements en comencient per '''#$2'''.",
	'swl-watchlist-insertions' => 'Apondu :',
	'swl-watchlist-deletions' => 'Suprimâ :',
	'swl-watchlist-pagincontrol' => 'Vêre ($1) ($2)',
	'swl-watchlist-firstn' => '$1 premiérs',
	'swl-watchlist-firstn-title' => '$1 {{PLURAL:$1|premiér rèsultat|premiérs rèsultats}}',
	'swl-email-propschanged' => 'Les propriètâts ont changiês a $1',
	'swl-email-changes' => 'Changements de propriètâts sur [$2 $1] :',
	'prefs-swl' => 'Lista de survelyence sèmantica',
	'prefs-swlgroup' => 'Tropes a siuvre',
	'swl-prefs-category-label' => "'''$1''' : propriètât{{PLURAL:$2||s}} $3 de la catègorie ''$4''",
	'swl-prefs-namespace-label' => "'''$1''' : propriètât{{PLURAL:$2||s}} $3 de l’èspâço de noms ''$4''",
	'swl-prefs-concept-label' => "'''$1''' : propriètât{{PLURAL:$2||s}} $3 du concèpte ''$4''",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'semanticwatchlist-desc' => 'Permite especificar grupos de propiedades semánticas para unha ou varias categorías ou espazos de nomes que poden ser vixiados despois',
	'right-semanticwatch' => 'Empregar a lista de vixilancia semántica',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Modificar]] os grupos da lista de vixilancia semántica',
	'special-semanticwatchlist' => 'Lista de vixilancia semántica',
	'special-watchlistconditions' => 'Condicións da lista de vixilancia semántica',
	'swl-group-name' => 'Nome do grupo:',
	'swl-group-properties' => 'Propiedades cubertas por este grupo:',
	'swl-group-remove-property' => 'Eliminar a propiedade',
	'swl-group-add-property' => 'Engadir a propiedade',
	'swl-group-page-selection' => 'Páxinas en',
	'swl-group-save' => 'Gardar',
	'swl-group-delete' => 'Borrar',
	'swl-group-category' => 'categoría',
	'swl-group-namespace' => 'espazo de nomes',
	'swl-group-concept' => 'concepto',
	'swl-group-confirmdelete' => 'Está seguro de querer borrar o grupo da lista de vixilancia "$1"?',
	'swl-group-save-all' => 'Gardar todos',
	'swl-group-add-new-group' => 'Engadir un novo grupo',
	'swl-group-add-group' => 'Engadir o grupo',
	'swl-watchlist-position' => "Mostrando '''$1''' dos últimos cambios, comezando polo '''nº $2'''.",
	'swl-watchlist-insertions' => 'Engadido:',
	'swl-watchlist-deletions' => 'Borrado:',
	'swl-watchlist-pagincontrol' => 'Ver ($1) ($2)',
	'swl-watchlist-firstn' => '$1 primeiras',
	'swl-watchlist-firstn-title' => '{{PLURAL:$1|Primeiro resultado|Primeiros $1 resultados}}',
	'swl-email-propschanged' => 'As propiedades cambiaron ás $1',
	'swl-email-propschanged-long' => "O usuario '''$2''' modificou unha ou máis propiedades que vixía en '''$1''' o $5 ás $4. Pode ollar estas e outras modificacións [$3 na súa lista de vixilancia semántica].",
	'swl-email-changes' => 'Cambio nas propiedades en [$2 $1]:',
	'prefs-swl' => 'Lista de vixilancia semántica',
	'prefs-swlgroup' => 'Grupos a vixiar',
	'swl-prefs-emailnofity' => 'Enviádeme un correo electrónico se hai cambios nas propiedades que vixío',
	'swl-prefs-category-label' => "'''$1:''' {{PLURAL:$2|propiedade|propiedades}} $3 da categoría ''$4''",
	'swl-prefs-namespace-label' => "'''$1:''' {{PLURAL:$2|propiedade|propiedades}} $3 do espazo de nomes ''$4''",
	'swl-prefs-concept-label' => "'''$1:''' {{PLURAL:$2|propiedade|propiedades}} $3 do concepto ''$4''",
	'swl-err-userid-xor-groupids' => 'Cómpre especificar ou ben o parámetro de identificación de usuario ou o parámetro de identificación de grupo, pero non os dous.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'semanticwatchlist-desc' => 'מאפשרת למשתמשים לקבל הודעה על שינויים מסוימים בנתונים של מדיה־ויקי סמנטית',
	'right-semanticwatch' => 'שימוש ברשימת מעקב סמנטית',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|שינוי]] קבוצות רשימת מעקב סמנטית',
	'special-semanticwatchlist' => 'רשימת מעקב סמנטית',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticwatchlist-desc' => 'Permitte specificar gruppos de proprietates semantic pro un o plus categorias o spatios de nomines, le quales pote alora esser observate pro modificationes',
	'right-semanticwatch' => 'Usar observatorio semantic',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Modificar]] le gruppos del observatorio semantic',
	'special-semanticwatchlist' => 'Observatorio semantic',
	'special-watchlistconditions' => 'Conditiones del observatorio semantic',
	'swl-group-name' => 'Nomine del gruppo:',
	'swl-group-properties' => 'Proprietates coperite per iste gruppo:',
	'swl-group-remove-property' => 'Remover proprietate',
	'swl-group-add-property' => 'Adder proprietate',
	'swl-group-page-selection' => 'Paginas in',
	'swl-group-save' => 'Salveguardar',
	'swl-group-delete' => 'Deler',
	'swl-group-category' => 'categoria',
	'swl-group-namespace' => 'spatio de nomines',
	'swl-group-concept' => 'concepto',
	'swl-group-confirmdelete' => 'Es tu secur de voler deler le gruppo "$1" del observatorio?',
	'swl-group-save-all' => 'Salveguardar totes',
	'swl-group-add-new-group' => 'Adder un nove gruppo',
	'swl-group-add-group' => 'Adder gruppo',
	'swl-watchlist-position' => "Presenta '''$1''' del ultime modificationes a partir del '''№ $2'''.",
	'swl-watchlist-insertions' => 'Addite:',
	'swl-watchlist-deletions' => 'Delite:',
	'swl-watchlist-pagincontrol' => 'Vider ($1) ($2)',
	'swl-watchlist-firstn' => 'prime $1',
	'swl-watchlist-firstn-title' => 'Le prime {{PLURAL:$1|resultato|$1 resultatos}}',
	'swl-email-propschanged' => 'Proprietates ha cambiate a $1',
	'swl-email-propschanged-long' => "Un o plus proprietates que tu observa a '''$1''' ha essite cambiate per le usator '''$2''' le $5 a $4. Tu pote vider iste e altere cambios in [$3 tu observatorio semantic].",
	'swl-email-changes' => 'Cambios de proprietate in [$2 $1]:',
	'prefs-swl' => 'Observatorio semantic',
	'prefs-swlgroup' => 'Gruppos a observar',
	'swl-prefs-emailnofity' => 'Inviar me e-mail in caso de modificationes in proprietates que io observa',
	'swl-prefs-category-label' => "'''$1''': {{PLURAL:$2|proprietate|proprietates}} $3 del categoria ''$4''",
	'swl-prefs-namespace-label' => "'''$1''': {{PLURAL:$2|proprietate|proprietates}} $3 del spatio de nomines ''$4''",
	'swl-prefs-concept-label' => "'''$1''': {{PLURAL:$2|proprietate|proprietates}} $3 del concepto ''$4''",
	'swl-err-userid-xor-groupids' => 'O le parametro "userid" o le "groupids" debe esser specificate, ma non ambes.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'semanticwatchlist-desc' => 'Memungkinkan penetapan kelompok properti semantik untuk satu atau lebih kategori/ruang nama yang kemudian dapat dipantau perubahannya',
	'right-semanticwatch' => 'Menggunakan daftar pantauan semantik',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Mengubah]] kelompok daftar pantauan semantik',
	'special-semanticwatchlist' => 'Daftar Pantau Semantik',
	'special-watchlistconditions' => 'Kriteria daftar pantau semantik',
	'swl-group-name' => 'Nama kelompok:',
	'swl-group-properties' => 'Properti yang dicakup oleh kelompok ini:',
	'swl-group-remove-property' => 'Hapus properti',
	'swl-group-page-selection' => 'Halaman dalam',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'semanticwatchlist-desc' => 'Määt et müjjelesch, Jroppe vun semantesche Eijeschaffte aanzjävve, för Saachjroppe un Appachtemangs, di dann op en Oppaßleß kumme un bewach wääde, för der Fall, dat se jeändert wääde.',
	'right-semanticwatch' => 'De semantesche Oppaßleß verwände',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Jroppe ändere]] för de semantesche Oppaßleßte',
	'special-semanticwatchlist' => 'Semantesch Oppaßleß',
	'special-watchlistconditions' => 'Enshtällonge för de semantesche Oppaßleßte',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'swl-group-save' => 'Tomar bike',
	'swl-group-category' => 'kategorî',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'right-semanticwatch' => 'Semantesch Iwwerwaachungslëscht benotzen',
	'special-semanticwatchlist' => 'Semantesch Iwwerwaachungslëscht',
	'special-watchlistconditions' => 'Astellunge vun der semantescher Iwwerwaachnugslëscht',
	'group-swladmins' => 'SWL-Administrateuren',
	'group-swladmins-member' => 'SWL-Administrateur',
	'grouppage-swladmins' => 'Project:SWL-Administrateuren',
	'swl-group-name' => 'Numm vum Grupp:',
	'swl-group-page-selection' => 'Säiten a(n)',
	'swl-group-save' => 'Späicheren',
	'swl-group-delete' => 'Läschen',
	'swl-group-category' => 'Kategorie',
	'swl-group-namespace' => 'Nummraum',
	'swl-group-concept' => 'Konzept',
	'swl-group-confirmdelete' => 'Sidd Dir sécher datt Dir de Grupp vun der Iwwerwaachungslëscht "$1" läsche wëllt?',
	'swl-group-save-all' => 'All späicheren',
	'swl-group-add-new-group' => 'Eng nei Grupp derbäisetzen',
	'swl-group-add-group' => 'Grupp derbäisetzen',
	'swl-watchlist-insertions' => 'Derbäigesat:',
	'swl-watchlist-deletions' => 'Al:',
	'swl-watchlist-pagincontrol' => '($1) ($2) weisen',
	'swl-watchlist-firstn' => 'éischt $1',
	'swl-watchlist-firstn-title' => '{{PLURAL:$1|Dat éischt Resultat|Déi éischt $1 Resultater}}',
	'swl-watchlist-no-items' => 'Dir hutt keng Objeten op Ärer Iwwerwaachungslëscht.',
	'swl-email-propschanged' => "D'Eegeschafte goufen op $1 geännert",
	'prefs-swl' => 'Semantesch Iwwerwaachungslëscht',
	'prefs-swlgroup' => "Gruppe fir z'iwwerwaachen",
	'prefs-swlglobal' => 'Allgemeng Optiounen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'semanticwatchlist-desc' => 'Овозможува известување на корисниците за одредени измени во податоците на Семантички МедијаВики',
	'right-semanticwatch' => 'Користење на семантички список на набљудувања',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Менување]] на групи од семантички списоци на набљудувања',
	'special-semanticwatchlist' => 'Семантички список на набљудувања',
	'special-watchlistconditions' => 'Услови за семантичкиот список на набљудувања',
	'group-swladmins' => 'Администратори на Семантичкиот список на набљудувања',
	'group-swladmins-member' => 'Администратор на Семантичкиот список на набљудувања',
	'grouppage-swladmins' => 'Project:Админи_на_Семантичкиот_список_на_набљудувања',
	'swl-group-name' => 'Име на групата:',
	'swl-group-properties' => 'Својства покриени со оваа група:',
	'swl-group-remove-property' => 'Отстрани својство',
	'swl-group-add-property' => 'Додај својство',
	'swl-group-page-selection' => 'Страници во',
	'swl-group-save' => 'Зачувај',
	'swl-group-delete' => 'Избриши',
	'swl-group-category' => 'категорија',
	'swl-group-namespace' => 'именски простор',
	'swl-group-concept' => 'концепт',
	'swl-group-confirmdelete' => 'Дали сте сигурни дека сакате да ја избришете групата „$1“ од списокот на набљудувања?',
	'swl-group-save-all' => 'Зачувај сè',
	'swl-group-add-new-group' => 'Додај нова група',
	'swl-group-add-group' => 'Додај група',
	'swl-watchlist-position' => "Приказ на '''$1''' од последните промени, почнувајќи од '''бр. $2'''.",
	'swl-watchlist-insertions' => 'Додадено:',
	'swl-watchlist-deletions' => 'Стари:',
	'swl-watchlist-pagincontrol' => 'Видете ($1) ($2)',
	'swl-watchlist-firstn' => 'први $1',
	'swl-watchlist-firstn-title' => '{{PLURAL:$1|Прв $1 резултат|Први $1 резултати}}',
	'swl-watchlist-no-items' => 'Немате ништо во списокот на набљудувања.',
	'swl-watchlist-can-mod-groups' => 'Можете да ги [[$1|измените групите на набљудувања]].',
	'swl-watchlist-can-mod-prefs' => 'Можете да ги [[$1|измените вашите нагодувања за набљудување]]., вклучувајќи кои својства да се набљудуваат.',
	'swl-watchlist-no-groups' => 'Сè уште не набљудувате ниедна група со списоци на набљудувања. [[$1|Измени нагодувања]].',
	'swl-email-propschanged' => 'Својствата на $1 се имаат изменето',
	'swl-email-propschanged-long' => "Едно или повеќе својства на '''$1''' што ги набљудувате се изменети од корисникот '''$2''' на $4 во $5 ч.. Можете да ги погледате овие и други промени на [$3 вашиот семантички список на набљудувања].",
	'swl-email-changes' => 'Измени во својства на [$2 $1]:',
	'prefs-swl' => 'Семантички список на набљудувања',
	'prefs-swlgroup' => 'Групи за набљудување',
	'prefs-swlglobal' => 'Општи наагодувања',
	'swl-prefs-emailnofity' => 'Испрати ми е-пошта кога ќе се изменат својствата што ги набљудувам',
	'swl-prefs-watchlisttoplink' => 'Прикажувај врска до Семантичкиот список на набљудувања најгоре на страницата',
	'swl-prefs-category-label' => "'''$1''': {{PLURAL:$2|својство|својства}} $3 од категоријата ''$4''",
	'swl-prefs-namespace-label' => "'''$1''': {{PLURAL:$2|својство|својства}} $3 од именскиот простор ''$4''",
	'swl-prefs-concept-label' => "'''$1''': {{PLURAL:$2|својство|својства}} $3 од концептот ''$4''",
	'swl-err-userid-xor-groupids' => 'Треба да ја наведете назнаката на корисникот или назнаките на групата (но не обете).',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'semanticwatchlist-desc' => 'Membolehkan penenetuan kumpulan-kumpulan sifat semantik untuk satu atau lebih kategori/ruang nama yang kemudiannya boleh dipantau untuk perubahan',
	'right-semanticwatch' => 'Menggunakan senarai pantau semantik',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Mengubah suai]] kumpulan senarai pantau semantik',
	'special-semanticwatchlist' => 'Senarai Pantau Semantik',
	'special-watchlistconditions' => 'Syarat-syarat senarai pantau semantik',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'semanticwatchlist-desc' => 'Maakt het mogelijk groepen van semantische eigenschappen aan te geven voor een of meer categorieën of naamruimten, zodat wijzigingen kunnen worden weergegeven',
	'right-semanticwatch' => 'Semantische volglijst gebruiken',
	'right-semanticwatchgroups' => 'De semantische volglijstgroepen [[Special:WatchlistConditions|aanpassen]]',
	'special-semanticwatchlist' => 'Semantische volglijst',
	'special-watchlistconditions' => 'Voorwaarden voor semantische volglijst',
	'swl-group-name' => 'Groepsnaam:',
	'swl-group-properties' => 'Eigenschappen die onder deze groep vallen:',
	'swl-group-remove-property' => 'Eigenschap verwijderen',
	'swl-group-add-property' => 'Eigenschap toevoegen',
	'swl-group-page-selection' => "Pagina's in",
	'swl-group-save' => 'Opslaan',
	'swl-group-delete' => 'Verwijderen',
	'swl-group-category' => 'categorie',
	'swl-group-namespace' => 'naamruimte',
	'swl-group-concept' => 'concept',
	'swl-group-confirmdelete' => 'Weet u zeker dat u de volglijstgroep "$1" wilt verwijderen?',
	'swl-group-save-all' => 'Allemaal opslaan',
	'swl-group-add-new-group' => 'Een nieuwe groep toevoegen',
	'swl-group-add-group' => 'Groep toevoegen',
	'swl-watchlist-position' => "Resultaat '''$1''' van de laatste wijzigingen beginnend met '''#$2'''.",
	'swl-watchlist-insertions' => 'Toegevoegd:',
	'swl-watchlist-deletions' => 'Verwijderd:',
	'swl-watchlist-pagincontrol' => 'Bekijken ($1) ($2)',
	'swl-watchlist-firstn' => 'eerste $1',
	'swl-watchlist-firstn-title' => 'Eerste $1 {{PLURAL:$1|resultaat|resultaten}}',
	'swl-email-propschanged' => 'Eigenschappen zijn veranderd op $1',
	'swl-email-propschanged-long' => "Een of meer eigenschappen die u volgt op '''$1''' zijn gewijzigd door gebruiker '''$2''' om $4 op $5. U kunt deze en andere wijzigingen bekijken op [$3 uw semantische volglijst].",
	'swl-email-changes' => 'Wijzigingen in eigenschappen op [$2 $1]:',
	'prefs-swl' => 'Semantische Volglijst',
	'prefs-swlgroup' => 'Te volgen groepen',
	'swl-prefs-emailnofity' => 'Mij e-mailen bij wijzigingen in eigenschappen die ik volg',
	'swl-prefs-category-label' => "'''$1''': {{PLURAL:$2|eigenschap|eigenschappen}} $3 van categorie ''$4''",
	'swl-prefs-namespace-label' => "'''$1''': {{PLURAL:$2|eigenschap|eigenschappen}} $3 van naamruimte ''$4''",
	'swl-prefs-concept-label' => "'''$1''': {{PLURAL:$2|eigenschap|eigenschappen}} $3 van concept ''$4''",
	'swl-err-userid-xor-groupids' => 'Geef de parameter "userid" of "groupids" op, maar niet beide.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'semanticwatchlist-desc' => 'Permite que os utilizadores sejam notificados de alterações específicas aos dados do MediaWiki Semântico',
	'right-semanticwatch' => 'Usar a lista de propriedades semânticas vigiadas',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Alterar]] os grupos de propriedades semânticas vigiadas',
	'special-semanticwatchlist' => 'Lista das Propriedades Semânticas Vigiadas',
	'special-watchlistconditions' => 'Condições da lista das propriedades semânticas vigiadas',
	'group-swladmins' => 'Administradores das Propriedades Semânticas Vigiadas',
	'group-swladmins-member' => 'Administrador das Propriedades Semânticas Vigiadas',
	'grouppage-swladmins' => 'Project:Administradores_das_Propriedades_Semânticas_Vigiadas',
	'swl-group-name' => 'Nome de grupo:',
	'swl-group-properties' => 'Propriedades abrangidas por este grupo:',
	'swl-group-remove-property' => 'Remover propriedade',
	'swl-group-add-property' => 'Adicionar propriedade',
	'swl-group-page-selection' => 'Páginas em',
	'swl-group-save' => 'Gravar',
	'swl-group-delete' => 'Eliminar',
	'swl-group-category' => 'categoria',
	'swl-group-namespace' => 'espaço nominal',
	'swl-group-concept' => 'conceito',
	'swl-group-confirmdelete' => 'Tem a certeza de que pretende eliminar o grupo de propriedades semântica vigiadas "$1"?',
	'swl-group-save-all' => 'Gravar todos',
	'swl-group-add-new-group' => 'Adicionar um grupo novo',
	'swl-group-add-group' => 'Adicionar grupo',
	'swl-watchlist-position' => "A mostrar '''$1''' das últimas alterações, começando pela '''$2ª'''.",
	'swl-watchlist-insertions' => 'Adições:',
	'swl-watchlist-deletions' => 'Antigas:',
	'swl-watchlist-pagincontrol' => 'Ver ($1) ($2)',
	'swl-watchlist-firstn' => 'primeiras $1',
	'swl-watchlist-firstn-title' => '{{PLURAL:$1|Primeiro resultado|Primeiros $1 results}}',
	'swl-watchlist-no-items' => 'A sua lista de propriedades semânticas vigiadas está vazia.',
	'swl-watchlist-can-mod-groups' => 'Pode [[$1|alterar os grupos de propriedades semânticas vigiadas]].',
	'swl-watchlist-can-mod-prefs' => 'Pode [[$1|alterar as suas preferências das propriedades semânticas vigiadas]], incluindo definir quais as propriedades que pretende vigiar.',
	'swl-watchlist-no-groups' => 'Ainda não está a vigiar nenhum grupo de propriedades semânticas vigiadas. [[$1|Alterar as suas preferências das propriedades semânticas vigiadas]].',
	'swl-email-propschanged' => 'Propriedades alteradas na $1',
	'swl-email-propschanged-long' => "Uma ou mais propriedades que está a vigiar na '''$1''' foram alteradas pelo utilizador '''$2''' às $4 de $5. Pode ver estas e outras alterações  na sua [$3 lista de propriedades semânticas vigiadas].",
	'swl-email-changes' => 'Alterações de propriedades em [$2 $1]:',
	'prefs-swl' => 'Lista das propriedades semânticas vigiadas',
	'prefs-swlgroup' => 'Grupos para vigiar',
	'prefs-swlglobal' => 'Opções gerais',
	'swl-prefs-emailnofity' => 'Notificar-me por correio electrónico das alterações de propriedades que estou a vigiar',
	'swl-prefs-watchlisttoplink' => 'Mostrar um link para a lista de propriedades semânticas vigiadas no topo da página',
	'swl-prefs-category-label' => "'''$1''': {{PLURAL:$2|Propriedade|Propriedades}} $3 da categoria ''$4''",
	'swl-prefs-namespace-label' => "'''$1''': {{PLURAL:$2|Propriedade|Propriedades}} $3 do espaço nominal ''$4''",
	'swl-prefs-concept-label' => "'''$1''': {{PLURAL:$2|propriedade|propriedades}} $3 do conceito ''$4''",
	'swl-err-userid-xor-groupids' => 'Deve ser especificado, ou o parâmetro de identificação do utilizador, ou o parâmetro de identificações de grupos, mas não ambos.',
);

/** Somali (Soomaaliga)
 * @author Maax
 */
$messages['so'] = array(
	'swl-group-category' => 'qeyb',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'semanticwatchlist-desc' => 'Nagpapahintulot ng pagtutukoy ng mga pangkat ng mga pag-aaring semantiko para sa isa o mas marami pang mga kategorya/mga puwang na pampangalan na maaari namang bantayan para sa mga pagbabago',
	'right-semanticwatch' => 'Gamitin ang semantikong talaan ng binabantayan',
	'right-semanticwatchgroups' => '[[Special:WatchlistConditions|Baguhin]] ang semantikong mga pangkat ng talaan ng binabantayan',
	'special-semanticwatchlist' => 'Semantikong Talaan ng Binabantayan',
	'special-watchlistconditions' => 'Mga kalagayan ng semantikong talaan ng binabantayan',
);

