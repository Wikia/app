<?php
$messages = [];

$messages['en'] = [
	'content-review-desc' => 'This extension creates a process by which community JavaScript is manually reviewed before it goes live for visitors.',
	'right-content-review' => 'Allows access to content review tools',
	'right-content-review-test-mode' => 'Allows access to content review testing environment',
	'group-content-reviewer' => 'Content Reviewers',
	'content-review-module-title' => 'Custom JavaScript status',
	'content-review-module-header-latest' => 'Latest revision:',
	'content-review-module-header-last' => 'Last reviewed revision:',
	'content-review-module-header-live' => 'Live revision:',
	'content-review-module-header-pagename' => 'Page name',
	'content-review-module-header-actions' => 'Actions',
	'content-review-module-status-none' => 'None',
	'content-review-module-status-unsubmitted' => 'needs to be submitted',
	'content-review-module-status-live' => 'is live!',
	'content-review-module-status-awaiting' => 'is awaiting review',
	'content-review-module-status-approved' => 'was approved',
	'content-review-module-status-rejected' => 'was rejected',
	'content-review-rejection-reason-link' => 'Why?',
	'content-review-module-help' => '[[Help:CSS and JS customization|Help]]',
	'content-review-module-help-article' => 'Help:CSS and JS customization',
	'content-review-module-help-text' => 'Help',
	'content-review-module-jspages' => 'All JS pages',
	'content-review-module-submit' => 'Submit for review',
	'content-review-module-submit-success' => 'The changes have been successfully submitted for a review.',
	'content-review-module-submit-exception' => 'Unfortunately, we could not submit the changes for a review due to the following error: $1.',
	'content-review-module-submit-error' => 'Unfortunately, we could not submit the changes for a review.',
	'content-review-module-test-mode-enable' => 'Enter test mode',
	'content-review-module-test-mode-disable' => 'Exit test mode',
	'content-review-test-mode-error' => 'Something went wrong. Please try again later.',
	'content-review-test-mode-enabled' => 'You are currently using unreviewed versions of custom JavaScript files. ',
	'action-content-review' => 'Content Review',
	'content-review-restore-summary' => 'Reverting page to revision $1',
	'content-review-status-unreviewed' => 'Unreviewed',
	'content-review-status-in-review' => 'In review',
	'content-review-status-approved' => 'Approved',
	'content-review-status-rejected' => 'Rejected',
	'content-review-status-live' => 'Live',
	'content-review-status-autoapproved' => 'Auto-approved',
	'content-review-status-escalated' => 'Escalated',
	'content-review-rejection-explanation-title' => 'Submitted script change $1 rejected',
	'content-review-rejection-explanation' => '==$1==
The recently submitted change to this JavaScript page (revision [$2 $3]) was rejected by the Wikia review process. Please make sure you meet the [[Help:JavaScript review process|Custom JavaScript guidelines]]. --~~~~',
	'content-review-status-link-text' => 'Review status',
	'content-review-special-js-pages-title' => 'JavaScript pages',
	'content-review-special-js-description' => 'This page lists the current [[Help:JavaScript review process|review status]] of MediaWiki namespace scripts on this community.',
	'content-review-special-js-importjs-description' => 'Note: you can add and remove local and dev.wikia.com script imports without the review process via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Here, you can easily import scripts:
* from your local wikia by article name - e.g. MyScript.js
* from dev.wikia.com by article name, preceded by "dev:" - e.g. dev:Code.js
Names should not contain the MediaWiki namespace prefix. Write each script on a new line. See [[Help:Including additional CSS and JS]] for more information.
----
',
	'content-review-profile-tags-description' => 'To use this feature, you must import [[w:c:dev:ProfileTags|ProfileTags.js]] from dev.wikia.com. [[w:c:dev:ProfileTags|Learn more]].

Use this page to customize the tags that appear on user profiles. Separate usernames and tags by a pipe (|). To display multiple tags for a user, separate each tag text with commas. Write each username on a new line.

Examples:

 ExampleUsername | Trainee, Newbie
 ExampleUsername2 | Guru
----
',
];

$messages['qqq'] = [
	'content-review-desc' => '{{desc}}',
	'content-review-module-title' => 'Title of a the right rail module with information on a page status.',
	'content-review-module-header-latest' => 'Header of a section of the right rail module with information on the latest revision submitted for a review.',
	'content-review-module-header-last' => 'Header of a section of the right rail module with information on the last reviewed revision.',
	'content-review-module-header-live' => 'Header of a section of the right rail module with information on the revision that is currently live and served to users.',
	'content-review-module-header-pagename' => 'A column name for a Page name',
	'content-review-module-header-actions' => 'A column name for a Actions',
	'content-review-module-status-none' => "Message shown as a revision's status when there is no information on it.",
	'content-review-module-status-unsubmitted' => "Message shown as a revision's status when the latest made revision has not yet been sent for a review.",
	'content-review-module-status-live' => "Message shown as a revision's status when it is currently live and served to users.",
	'content-review-module-status-awaiting' => "Message shown as a revision's status when a revision is waiting for a review.",
	'content-review-module-status-approved' => "Message shown as a revision's status if a revision was approved.",
	'content-review-module-status-rejected' => "Message shown as a revision's status if a revision was rejected",
	'content-review-rejection-reason-link' => 'Text of a link that leads a users to a Talk page with an explanation on why their code was rejected.',
	'content-review-module-help' => 'A link to a Help page explaining how the review system works.',
	'content-review-module-help-article' => 'Article name to a Help page explaining how the review system works.',
	'content-review-module-help-text' => 'Text shown on a link a Help page explaining how the review system works.',
	'content-review-module-jspages' => 'Text shown on a link to page with all javascript pages.',
	'content-review-module-submit' => 'A text of a button that sends a given page for a review.',
	'content-review-module-submit-success' => 'A message shown to a user in a Banner Notification if a page has been added to review.',
	'content-review-module-submit-exception' => 'A message shown to a user in a Banner Notification if a known error happened. $1 is the error message.',
	'content-review-module-submit-error' => 'A message shown to a user in a Banner Notification if an unknown error happened.',
	'content-review-module-test-mode-enable' => 'A text of a button which clicked enables user to test unreviewed changes made in JavaScript articles.',
	'content-review-module-test-mode-disable' => 'A text of a link that disables serving unreviewed JavaScript to a user. Shown in a Banner Notification and right module.',
	'content-review-test-mode-error' => 'A message shown if there was a problem with enabling the test mode to a user.',
	'content-review-test-mode-enabled' => 'A message shown in Banner Notification with an information that a user is curently being served unreviewed JavaScript pages.',
	'action-content-review' => 'Title for permissions',
	'content-review-restore-summary' => 'A default, prefilled summary for an action of restoring a revision of a page. $1 is the ID number of the revision.',
	'content-review-status-unreviewed' => 'A name of a status of a revision that has not yet been reviewed.',
	'content-review-status-in-review' => 'A name of a status of a revision that is being reviewed.',
	'content-review-status-approved' => 'A name of a status of a revision that has been approved.',
	'content-review-status-rejected' => 'A name of a status of a revision that has been rejected.',
	'content-review-status-autoapproved' => 'A name of a status of a revision that was auto-approved',
	'content-review-status-live' => 'A name of a status of a revision that is currently live',
	'content-review-status-escalated' => 'The name of the status of a revision that has been escalated.',
	'content-review-rejection-explanation-title' => 'A title of a section with a rejection explanation. Became a separate message to allow extraction to a URL anchor of a Why? link.',
	'content-review-rejection-explanation' => 'Standard explanation response when script changes were rejected. This text is a prefill to script talk page when reviewer is redirected there to provide feedback on rejection. $1 is the title message, $2 is a URL to a view of a revision and $3 is the number of a revision that becomes a text of the link.',
	'content-review-status-link-text' => 'Text on entrypoint link to show content review module with review status info and submit for review buttons',
	'content-review-special-js-pages-title' => 'Title of special page which contains all JavaScript pages on given wiki',
	'content-review-special-js-description' => 'Text with description of this special page that contains lists with all scripts in MediaWiki namespace on that community with their review statuses and linking to help page.',
	'content-review-special-js-importjs-description' => 'Information that user can manage script imports from community or dev.wikia.com by editing  MediaWiki:ImportJS page.',
	'content-review-importjs-description' => 'Information for user how to add scripts. For scripts from local wikia, user should only add article name and from dev.wikia.com should preceded them by "dev:". Also user should add MediaWiki namespace and should add each script in separate line.',
	'content-review-profile-tags-description' => 'Inform user that to use this feature user must import ProfileTags.js script from dev.wikia.com. Then explain that user should use current page to customize user tags on their profiles by adding user name and tags separated by a pipe (|).
	 If a user wants to provide for more than one tag for a user, they should separate them by comma. Also each user name should be written on a new line. Examples:

    * ExampleUsername | Trainee, Newbie
    * ExampleUsername2 | Guru',
];

$messages['de'] = [
	'content-review-desc' => 'Diese Erweiterung erzeugt einen Prozess, in dem das Community-JavaScript manuell überprüft wird, bevor Besucher es live sehen können.',
	'content-review-module-title' => 'Status des angepassten JavaScripts',
	'content-review-module-header-latest' => 'Letzte Überprüfung:',
	'content-review-module-header-last' => 'Letzte durchgesehene Überprüfung:',
	'content-review-module-header-live' => 'Live-Überprüfung:',
	'content-review-module-status-none' => 'Keine',
	'content-review-module-status-unsubmitted' => 'muss eingereicht werden',
	'content-review-module-status-live' => 'ist live!',
	'content-review-module-status-awaiting' => 'wartet auf die Überprüfung',
	'content-review-module-status-approved' => 'wurde zugelassen',
	'content-review-module-status-rejected' => 'wurde abgelehnt',
	'content-review-rejection-reason-link' => 'Warum?',
	'content-review-module-help' => '[[w:c:de:Hilfe:CSS-_und_JS-Anpassungen|Hilfe]]',
	'content-review-module-help-article' => 'Hilfe:CSS- und JS-Anpassungen',
	'content-review-module-help-text' => 'Hilfe',
	'content-review-module-submit' => 'Zur Überprüfung einreichen',
	'content-review-module-submit-success' => 'Die Änderungen wurden erfolgreich zur Überprüfung eingereicht.',
	'content-review-module-submit-exception' => 'Leider konnten wir die Änderungen aufgrund des folgenden Fehlers nicht zur Überprüfung einreichen: $1',
	'content-review-module-submit-error' => 'Leider konnten wir die Änderungen nicht zur Überprüfung einreichen.',
	'content-review-module-test-mode-enable' => 'Testmodus eingeben',
	'content-review-module-test-mode-disable' => 'Testmodus verlassen',
	'content-review-test-mode-error' => 'Es ist etwas schief gelaufen. Versuche es bitte später noch einmal.',
	'content-review-test-mode-enabled' => 'Du verwendest derzeit ungeprüfte Versionen benutzerdefinierter JavaScript-Dateien.',
	'action-content-review' => 'Überprüfung des Inhalts',
	'content-review-restore-summary' => 'Seite wird auf Revision $1 zurückgesetzt',
	'content-review-status-unreviewed' => 'Nicht überprüft',
	'content-review-status-in-review' => 'Wird überprüft',
	'content-review-status-approved' => 'Zugelassen',
	'content-review-status-rejected' => 'Abgelehnt',
	'content-review-status-live' => 'Live',
	'content-review-status-autoapproved' => 'Automatisch zugelassen',
	'content-review-rejection-explanation' => '==$1==
Die kürzlich eingereichte Änderung dieser JavaScript-Seite (Überprüfung [$2 $3]) wurde im Wikia- Überprüfungsprozess abgelehnt. Stelle bitte sicher, dass du die [[w:c:de:Hilfe:JavaScript-Überprüfungsprozess|Richtlinien für angepasstes Javascript]] erfüllst.--~~~~',
	'content-review-status-link-text' => 'Stand der Überprüfung',
	'content-review-rejection-explanation-title' => 'Die eingereichte Skript-Änderung $1 wurde abgelehnt',
	'content-review-special-js-pages-title' => 'JavaScript-Seiten',
	'content-review-module-header-pagename' => 'Seitenname',
	'content-review-module-header-actions' => 'Aktionen',
	'content-review-module-jspages' => 'Alle JS-Seiten',
	'content-review-special-js-description' => 'Auf dieser Seite wird der aktuelle [[w:c:de:Hilfe:JavaScript-Überprüfungsprozess|Überprüfungsprozess]] von MediaWiki-Namensräume-Skripten dieser Community aufgeführt.',
	'content-review-special-js-importjs-description' => 'Hinweis: du kannst lokale und dev.wikia.com-Skriptimporte ohne den Überprüfungsprozess über [[MediaWiki:ImportJS]] hinzufügen und entfernen.',
	'content-review-importjs-description' => 'Von hier kannst du ganz einfach Skripte importieren:
* aus deinem lokalen Wikia nach Artikelname - z. B. MyScript.js
* aus dev.wikia.com nach Artikelname mit vorangestelltem "dev:" - z. B. dev:Code.js
Namen sollten nicht das Wikia-Namensräume-Präfix enthalten. Verwende für jedes Skript eine neue Zeile. Weitere Informationen findest du unter [[Hilfe:Einbinden von zusätzlichem CSS und JS]].
----
',
	'content-review-user-badges-description' => 'Um diese Funktion nutzen zu können, musst du [[w:c:dev:UserBadges|UserBadges.js]] von dev.wikia.com importieren. [[w:c:dev:UserBadges|Erfahre mehr]].

    Verwende diese Seite, um die Abzeichen anzupassen, die in den Benutzerprofilen erscheinen. Benutzernamen und Abzeichen werden durch einen Doppelpunkt getrennt. Um für einen Benutzer mehrere Abzeichen anzuzeigen, trenne jeden Abzeichentext mit Kommas. Schreibe jeden Benutzernamen in eine neue Zeile.

    Beispiele:

    * BeispielBenutzername : Praktikant, Newbie
    * BeispielBenutzername2 : Guru
----
',
];

$messages['es'] = [
	'content-review-desc' => 'Esta extensión crea un proceso en el que el JavaScript comunitario es revisado manualmente antes de que sea activo para los visitantes.',
	'content-review-module-title' => 'Estado del JavaScript personalizado',
	'content-review-module-header-latest' => 'Última revisión:',
	'content-review-module-header-last' => 'Última revisión revisada:',
	'content-review-module-header-live' => 'Revisión actual:',
	'content-review-module-status-none' => 'Ninguna',
	'content-review-module-status-unsubmitted' => 'necesita ser presentado',
	'content-review-module-status-live' => '¡activo!',
	'content-review-module-status-awaiting' => 'en espera de revisión',
	'content-review-module-status-approved' => 'fue aprobado',
	'content-review-module-status-rejected' => 'fue rechazado',
	'content-review-rejection-reason-link' => '¿Por qué?',
	'content-review-module-help' => '[[w:es:Ayuda:Personalización CSS y JS|Ayuda]]',
	'content-review-module-help-article' => 'Ayuda:Personalización CSS y JS',
	'content-review-module-help-text' => 'Ayuda',
	'content-review-module-submit' => 'Presentar para aprobación',
	'content-review-module-submit-success' => 'Los cambios se han presentado exitosamente para una revisión.',
	'content-review-module-submit-exception' => 'Desafortunadamente, no podemos presentar los cambios para una revisión debido al siguiente error: $1.',
	'content-review-module-submit-error' => 'Desafortunadamente, no podemos presentar los cambios para una revisión.',
	'content-review-module-test-mode-enable' => 'Ingresar al modo de prueba',
	'content-review-module-test-mode-disable' => 'Salir del modo de prueba',
	'content-review-test-mode-error' => 'Algo salió mal. Por favor inténtalo de nuevo más tarde.',
	'content-review-test-mode-enabled' => 'Actualmente estás utilizando versiones sin revisar de archivos JavaScript personalizados. ',
	'action-content-review' => 'Revisión de contenido',
	'content-review-restore-summary' => 'Revirtiendo página a revisión $1',
	'content-review-status-unreviewed' => 'Sin revisar',
	'content-review-status-in-review' => 'En revisión',
	'content-review-status-approved' => 'Aprobado',
	'content-review-status-rejected' => 'Rechazado',
	'content-review-status-live' => 'Activo',
	'content-review-status-autoapproved' => 'Auto-aprobado',
	'content-review-rejection-explanation' => '== $1==
El cambio recientemente presentado a esta página de JavaScript (revisión [$2 $3]) fue rechazada por el proceso de revisión de Wikia. Por favor, asegúrate de que cumple con las [[w:es:Ayuda:Proceso de revisión de JavaScript|directrices de personalización de JavaScript]]. --~~~~',
	'content-review-status-link-text' => 'Estado de revisión',
	'content-review-rejection-explanation-title' => 'El cambio de script $1 presentado ha sido rechazado',
	'content-review-special-js-pages-title' => 'Páginas de JavaScript',
	'content-review-module-header-pagename' => 'Nombre de la página',
	'content-review-module-header-actions' => 'Acciones',
	'content-review-module-jspages' => 'Todas las páginas de JS',
	'content-review-special-js-description' => 'Esta página muestra el actual [[w:es:Ayuda:Proceso de revisión de JavaScript|el estado de revisión de JavaScript]] de los guiones de espacio para nombres de MediaWiki en esta comunidad.',
	'content-review-special-js-importjs-description' => 'Nota: puedes añadir y remover guiones locales e importados de dev.wikia.com sin el proceso de revisión vía [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Aquí, puedes importar fácilmente guiones:
* de tu wikia local por nombre de artículo - e.j. MiGuión.js
* de dev.wikia.com por nombre de artículo, precedido por "dev:" - e.j. dev:Código.js
Los nombres no deben contener el prefijo del espacio para nombres de MediaWiki. Escribe cada guión en una nueva línea. Ver [[w:es:Ayuda:Incluyendo JavaScript y CSS adicional]] para más información.
----
',
	'content-review-user-badges-description' => 'Para utilizar esta función, debes importar [[w:c:dev:UserBadges|UserBadges.js]] de dev.wikia.com. [[w:c:dev:UserBadges|Conoce más]].

    Utiliza esta página para personalizar los logros que aparecen en los perfiles de usuario. Separa los nombres de usuario y los logros con dos puntos. Para mostrar múltiples logros para un usuario, separa cada texto de logro con comas. Escribe cada nombre de usuario en una nueva línea.

    Ejemplos:

    * EjemploNombredeusuario : Aprendiz, Novato
    * EjemploNombredeusuario2 : Gurú
----

',
];

$messages['fr'] = [
	'content-review-desc' => 'Cette extension permet de lancer un processus de vérification manuelle du JavaScript de la communauté avant sa publication.',
	'content-review-module-title' => 'État du JavaScript personnel',
	'content-review-module-header-latest' => 'Dernière version :',
	'content-review-module-header-last' => 'Dernière version vérifiée :',
	'content-review-module-header-live' => 'Version actuellement publiée :',
	'content-review-module-status-none' => 'Aucune',
	'content-review-module-status-unsubmitted' => 'doit être soumise',
	'content-review-module-status-live' => 'est publiée !',
	'content-review-module-status-awaiting' => 'doit être vérifiée',
	'content-review-module-status-approved' => 'a été approuvée',
	'content-review-module-status-rejected' => 'a été rejetée',
	'content-review-rejection-reason-link' => 'Pourquoi ?',
	'content-review-module-help' => '[[w:c:fr:Aide:Personnalisation_du_CSS_et_JS|Aide]]',
	'content-review-module-help-article' => 'Aide:Personnalisation du CSS et JS',
	'content-review-module-help-text' => 'Aide',
	'content-review-module-submit' => 'Soumettre pour approbation',
	'content-review-module-submit-success' => 'Une demande de vérification des modifications a été soumise.',
	'content-review-module-submit-exception' => "Impossible de soumettre les modifications pour approbation en raison de l'erreur suivante : $1.",
	'content-review-module-submit-error' => 'Impossible de soumettre les modifications pour approbation.',
	'content-review-module-test-mode-enable' => 'Activer le mode test',
	'content-review-module-test-mode-disable' => 'Quitter le mode test',
	'content-review-test-mode-error' => 'Un problème est survenu. Veuillez réessayer ultérieurement.',
	'content-review-test-mode-enabled' => "Vous utilisez actuellement des versions de fichiers JavaScript personnels n'ayant fait l'objet d'aucune vérification. ",
	'action-content-review' => 'Vérification du contenu',
	'content-review-restore-summary' => 'Rétablissement de la version $1',
	'content-review-status-unreviewed' => 'Non vérifiée',
	'content-review-status-in-review' => 'En cours de vérification',
	'content-review-status-approved' => 'Approuvée',
	'content-review-status-rejected' => 'Rejetée',
	'content-review-status-live' => 'Publiée',
	'content-review-status-autoapproved' => 'Approuvée automatiquement',
	'content-review-rejection-explanation' => '==$1==
Le processus de vérification Wikia a rejeté la modification soumise pour cette page JavaScript (révision [$2 $3]) . Assurez-vous de respecter les [[w:c:fr:Aide:Processus_de_vérification_du_JavaScript|instructions de personnalisation du JavaScript]]. --~~~~',
	'content-review-status-link-text' => 'État de la vérification',
	'content-review-rejection-explanation-title' => 'Modification $1 soumise pour le script rejetée',
	'content-review-special-js-pages-title' => 'Pages JavaScript',
	'content-review-module-header-pagename' => 'Nom de la page',
	'content-review-module-header-actions' => 'Actions',
	'content-review-module-jspages' => 'Toutes les pages JS',
	'content-review-special-js-description' => "Cette page indique [[w:c:fr:Aide:Processus_de_vérification_du_JavaScript| l'état de vérification]] des scripts de l'espace de noms MediaWiki relatifs à cette communauté.",
	'content-review-special-js-importjs-description' => 'Remarque : vous pouvez ajouter et supprimer les importations de scripts dev.wikia.com et locaux sans processus de vérification via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => "Vous pouvez ici facilement importer des scripts :
* de votre wikia local par nom d'article (par ex., MonScript.js) ;
* de dev.wikia.com par nom d'article précédé de \"dev:\" (par ex., dev:Code.js).
Les noms ne doivent pas comporter le préfixe d'espace de noms MediaWiki. Écrivez chaque script sur une nouvelle ligne. Pour plus d'informations, consultez la page [[Aide:Inclure_du_CSS_et_JS_supplémentaire]].
----
",
	'content-review-user-badges-description' => "Pour utiliser cette fonctionnalité, vous devez importer [[w:c:dev:UserBadges|UserBadges.js]] depuis dev.wikia.com. [[w:c:dev:UserBadges|En savoir plus]]

    Cette page permet de personnaliser les badges des profils utilisateur. Les noms d'utilisateur et les badges doivent être séparés par deux-points. Pour afficher plusieurs badges pour un utilisateur, séparez le texte de chaque badge par une virgule. Écrivez chaque nom d'utilisateur sur une nouvelle ligne.

    Exemples :

    * Nomutilisateur1 : Apprenti, Nouveau
    * Nomutilisateur2 : Gourou
----
",
];

$messages['it'] = [
	'content-review-desc' => 'Questa estensione crea un processo attraverso il quale il JavaScript della community è controllato manualmente prima che diventi visibile ai visitatori.',
	'content-review-module-title' => 'Stato del JavaScript personalizzato',
	'content-review-module-header-latest' => 'Ultima revisione:',
	'content-review-module-header-last' => 'Ultima revisione controllata:',
	'content-review-module-header-live' => 'Revisione live:',
	'content-review-module-status-none' => 'Nessuna',
	'content-review-module-status-unsubmitted' => 'deve essere inviata',
	'content-review-module-status-live' => 'è live!',
	'content-review-module-status-awaiting' => 'è in attesa di revisione',
	'content-review-module-status-approved' => 'è stata approvata',
	'content-review-module-status-rejected' => 'è stata respinta',
	'content-review-rejection-reason-link' => 'Perché?',
	'content-review-module-help' => '[[w:it:Aiuto:Processo di revisione del JavaScript|Guida]]',
	'content-review-module-help-article' => 'Aiuto:CSS',
	'content-review-module-help-text' => 'Guida',
	'content-review-module-submit' => 'Invia per revisione',
	'content-review-module-submit-success' => 'Le modifiche per la revisione sono state inviate con successo.',
	'content-review-module-submit-exception' => 'Sfortunatamente non abbiamo potuto inviare le modifiche per la revisione a causa del seguente errore: $1.',
	'content-review-module-submit-error' => 'Sfortunatamente non abbiamo potuto inviare le modifiche per la revisione.',
	'content-review-module-test-mode-enable' => 'Entra in modalità test',
	'content-review-module-test-mode-disable' => 'Esci dalla modalità test',
	'content-review-test-mode-error' => 'Qualcosa è andato storto. Riprova più tardi.',
	'content-review-test-mode-enabled' => 'Attualmente stai usando versioni non ancora controllate dei file in JavaScript personalizzato. ',
	'action-content-review' => 'Revisione contenuto',
	'content-review-restore-summary' => 'Ripristino pagina alla revisione $1',
	'content-review-status-unreviewed' => 'Non revisionata',
	'content-review-status-in-review' => 'In processo di revisione',
	'content-review-status-approved' => 'Approvata',
	'content-review-status-rejected' => 'Respinta',
	'content-review-status-live' => 'Live',
	'content-review-status-autoapproved' => 'Auto-approvata',
	'content-review-rejection-explanation' => '==$1==
La modifica inviata di recente per questa pagina in JavaScript (revisione [$2 $3]) è stata respinta dal processo di revisione di Wikia. Assicurati di seguire le [[Help:JavaScript review process|Linee guida del JavaScript personalizzato]]. --~~~~',
	'content-review-status-link-text' => 'Stato della revisione',
	'content-review-rejection-explanation-title' => 'La modifica $1 inviata per lo script è stata respinta',
	'content-review-special-js-pages-title' => 'Pagine in JavaScript',
	'content-review-module-header-pagename' => 'Titolo della pagina',
	'content-review-module-header-actions' => 'Azioni',
	'content-review-module-jspages' => 'Tutte le pagine JS',
	'content-review-special-js-description' => "Questa pagina indica l'attuale [[Aiuto:Processo di revisione del JavaScript|Processo di revisione]] degli script dello spazio dei nomi MediaWiki relativi a questa comunità.",
	'content-review-special-js-importjs-description' => 'Nota: puoi aggiungere e rimuovere le importazioni degli script dev.wikia.com e locali senza il processo di revisione via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Potrai facilmente importare gli script:
* dalla tua wikia locale con il nome dell\'articolo (per es., MyScript.js)
* da dev.wikia.com con il nome dell\'articolo preceduto da "dev:" (per es., dev:Code.js)
I nomi non devono contenere il prefisso dello spazio dei nomi MediaWiki. Scrivi ogni script su una riga nuova. Per maggiori informazioni consulta [[Aiuto:Includere CSS e JS]] supplementari.
----
',
	'content-review-user-badges-description' => 'Per usare questa funzione, occorre importare [[w:c:dev:UserBadges|UserBadges.js]] da dev.wikia.com. [[w:c:dev:UserBadges|Ulteriori informazioni]]

    Usare questa pagina per personalizzare le medaglie che sono visualizzate nei profili utente. Separare i nomi utente e le medaglie con un due punti. Per visualizzare diverse medaglie per  un utente, separare il testo di ogni medaglia con delle virgole. Scrivere il nome utente su una nuova riga.

    Esempi:

    *ExampleUsername : Trainee; Newbie
    *ExampleUsername2 : Guru
',
];

$messages['ja'] = [
	'content-review-desc' => 'この拡張機能により、コミュニティのJavaScriptが公開前に手動で審査されるようになります。',
	'content-review-module-title' => 'カスタムJavaScriptの状況',
	'content-review-module-header-latest' => '最新版：',
	'content-review-module-header-last' => '審査済みの最新版：',
	'content-review-module-header-live' => '公開版：',
	'content-review-module-status-none' => 'なし',
	'content-review-module-status-unsubmitted' => '申請する必要があります',
	'content-review-module-status-live' => '公開されています',
	'content-review-module-status-awaiting' => '審査待ちです',
	'content-review-module-status-approved' => '承認されました',
	'content-review-module-status-rejected' => '拒否されました',
	'content-review-rejection-reason-link' => '理由',
	'content-review-module-help' => '[[ヘルプ:CSSとJavaScriptのカスタマイゼーション|ヘルプ]]',
	'content-review-module-help-article' => 'ヘルプ:CSSとJavaScriptのカスタマイゼーション',
	'content-review-module-help-text' => 'ヘルプ',
	'content-review-module-submit' => '申請する',
	'content-review-module-submit-success' => '変更内容を申請しました。',
	'content-review-module-submit-exception' => '申し訳ありませんが、次のエラーのため変更内容を申請できませんでした：$1。',
	'content-review-module-submit-error' => '申し訳ありませんが、変更内容を申請できませんでした。',
	'content-review-module-test-mode-enable' => 'テストモードを開始',
	'content-review-module-test-mode-disable' => 'テストモードを終了',
	'content-review-test-mode-error' => '問題が発生したようです。しばらくしてから、もう一度お試しください。',
	'content-review-test-mode-enabled' => '現在、未審査版のカスタムJavaScriptファイルを使用しています。 ',
	'action-content-review' => 'コンテンツの審査',
	'content-review-restore-summary' => 'ページを$1の版に戻しています',
	'content-review-status-unreviewed' => '未審査',
	'content-review-status-in-review' => '審査中',
	'content-review-status-approved' => '承認済み',
	'content-review-status-rejected' => '拒否済み',
	'content-review-status-live' => '公開中',
	'content-review-status-autoapproved' => '自動承認済み',
	'content-review-rejection-explanation' => '==$1==
最近申請したこのJavaScriptページへの変更（版[$2 $3]）は、ウィキアの審査プロセスにおいて拒否されました。[[ヘルプ:JavaScriptの審査プロセス|カスタムJavaScriptのガイドライン]]を満たしていることをご確認ください。--~~~~',
	'content-review-status-link-text' => '審査状況',
	'content-review-rejection-explanation-title' => '申請したスクリプトの変更「$1」が拒否されました',
	'content-review-special-js-pages-title' => 'JavaScriptページ',
	'content-review-module-header-pagename' => 'ページ名',
	'content-review-module-header-actions' => '対処',
	'content-review-module-jspages' => 'すべてのJSページ',
	'content-review-special-js-description' => 'このページには、このコミュニティのMediaWiki名前空間スクリプトの現在の[[w:c:ja:ヘルプ:JavaScriptの審査プロセス|審査状況]]が一覧表示されています。',
	'content-review-special-js-importjs-description' => '注：ローカルとdev.wikia.comのスクリプトのインポートは、[[MediaWiki:ImportJS]]から審査プロセスを経ずに追加、削除できます。',
	'content-review-importjs-description' => 'ここでは、スクリプトを簡単にインポートしていただけます：
* ローカルウィキアからは記事名（例：MyScript.js）
* dev.wikia.comからは記事名の先頭に「dev:」を付ける（例：dev:Code.js）
MediaWikiの名前空間プレフィックスは名前に含めないでください。スクリプトごとに新しい行に記述します。詳しくは、[[ヘルプ:追加のJavaScriptとCSSをインクルードする]]をご覧ください。
----
',
	'content-review-user-badges-description' => 'この機能を使用するには、dev.wikia.comから[[w:c:dev:UserBadges|UserBadges.js]]を読み込む必要があります。詳しくは、[[w:c:dev:UserBadges|こちら]]をご覧ください。

    このページを使用すると、ユーザー・プロフィールに表示するバッジをカスタマイズできます。ユーザー名とバッジはコロンで区切り、1人のユーザーに複数のバッジを表示する場合は各バッジのテキストをカンマで区切ります。また、ユーザー名ごとに改行してください。

    例：

    * ユーザー名1 : 見習い, 新人
    * ユーザー名2 : グル
----
',
];

$messages['nl'] = [
	'content-review-desc' => 'This extension creates a process by which community JavaScript is manually reviewed before it goes live for visitors.',
	'content-review-module-title' => 'Custom JavaScript status',
	'content-review-module-header-latest' => 'Latest revision:',
	'content-review-module-header-last' => 'Last reviewed revision:',
	'content-review-module-header-live' => 'Live revision:',
	'content-review-module-status-none' => 'None',
	'content-review-module-status-unsubmitted' => 'needs to be submitted',
	'content-review-module-status-live' => 'is live!',
	'content-review-module-status-awaiting' => 'is awaiting review',
	'content-review-module-status-approved' => 'was approved',
	'content-review-module-status-rejected' => 'was rejected',
	'content-review-rejection-reason-link' => 'Why?',
	'content-review-module-help' => '[[Help:CSS and JS customization|Help]]',
	'content-review-module-help-article' => 'Help:CSS and JS customization',
	'content-review-module-help-text' => 'Help',
	'content-review-module-submit' => 'Submit for review',
	'content-review-module-submit-success' => 'The changes have been successfully submitted for a review.',
	'content-review-module-submit-exception' => 'Unfortunately, we could not submit the changes for a review due to the following error: $1.',
	'content-review-module-submit-error' => 'Unfortunately, we could not submit the changes for a review.',
	'content-review-module-test-mode-enable' => 'Enter test mode',
	'content-review-module-test-mode-disable' => 'Exit test mode',
	'content-review-test-mode-error' => 'Something went wrong. Please try again later.',
	'content-review-test-mode-enabled' => 'You are currently using unreviewed versions of custom JavaScript files. ',
	'action-content-review' => 'Content Review',
	'content-review-restore-summary' => 'Reverting page to revision $1',
	'content-review-status-unreviewed' => 'Unreviewed',
	'content-review-status-in-review' => 'In review',
	'content-review-status-approved' => 'Approved',
	'content-review-status-rejected' => 'Rejected',
	'content-review-status-live' => 'Live',
	'content-review-status-autoapproved' => 'Auto-approved',
	'content-review-rejection-explanation' => '==$1==
The recently submitted change to this JavaScript page (revision [$2 $3]) was rejected by the Wikia review process. Please make sure you meet the [[Help:JavaScript review process|Custom JavaScript guidelines]]. --~~~~',
	'content-review-status-link-text' => 'Review status',
	'content-review-rejection-explanation-title' => 'Submitted script change $1 rejected',
	'content-review-special-js-pages-title' => 'JavaScript pages',
	'content-review-module-header-pagename' => 'Page name',
	'content-review-module-header-actions' => 'Actions',
	'content-review-module-jspages' => 'All JS pages',
	'content-review-special-js-description' => 'This page lists the current [[Help:JavaScript review process review status]] of MediaWiki namespace scripts on this community.',
	'content-review-special-js-importjs-description' => 'Note: you can add and remove local and dev.wikia.com script imports without the review process via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Here, you can easily import scripts:
* from your local wikia by article name - e.g. MyScript.js
* from dev.wikia.com by article name, preceded by "dev:" - e.g. dev:Code.js
Names should not contain the MediaWiki namespace prefix. Write each script on a new line. See [[Help:Including additional CSS and JS]] for more information.
----
',
	'content-review-user-badges-description' => 'To use this feature, you must import [[w:c:dev:UserBadges|UserBadges.js]] from dev.wikia.com. [[w:c:dev:UserBadges|Learn more]].

    Use this page to customize the badges that appear on user profiles. Separate usernames and badges by a colon. To display multiple badges for a user, separate each badge text with commas. Write each username on a new line.

    Examples:

    * ExampleUsername : Trainee, Newbie
    * ExampleUsername2 : Guru
----
',
];

$messages['pl'] = [
	'content-review-desc' => 'To rozszerzenie tworzy proces, dzięki któremu kod JavaScript tworzony przez społeczność jest sprawdzany ręcznie zanim zobaczą go odwiedzający.',
	'content-review-module-title' => 'Status dostosowanego kodu JavaScript',
	'content-review-module-header-latest' => 'Ostatnia wersja:',
	'content-review-module-header-last' => 'Ostatnia sprawdzona wersja:',
	'content-review-module-header-live' => 'Aktywna wersja:',
	'content-review-module-status-none' => 'Brak',
	'content-review-module-status-unsubmitted' => 'wymaga sprawdzenia',
	'content-review-module-status-live' => 'jest aktywna!',
	'content-review-module-status-awaiting' => 'oczekuje na sprawdzenie',
	'content-review-module-status-approved' => 'została zaakceptowana',
	'content-review-module-status-rejected' => 'została odrzucona',
	'content-review-rejection-reason-link' => 'Dlaczego?',
	'content-review-module-help' => '[[Pomoc:Dostosowywanie CSS i JS|Pomoc]]',
	'content-review-module-help-article' => 'Pomoc:Dostosowywanie CSS i JS',
	'content-review-module-help-text' => 'Pomoc',
	'content-review-module-submit' => 'Prześlij do sprawdzenia',
	'content-review-module-submit-success' => 'Zmiany zostały pomyślnie przesłane do sprawdzenia.',
	'content-review-module-submit-exception' => 'Niestety, nie udało się przesłać zmian do sprawdzenia z powodu następującego błędu: $1.',
	'content-review-module-submit-error' => 'Niestety nie udało się przesłać zmian do sprawdzenia.',
	'content-review-module-test-mode-enable' => 'Przejdź do trybu testowego',
	'content-review-module-test-mode-disable' => 'Opuść tryb testowy',
	'content-review-test-mode-error' => 'Coś poszło nie tak. Spróbuj ponownie później.',
	'content-review-test-mode-enabled' => 'Obecnie korzystasz z niesprawdzonych wersji plików JavaScript. ',
	'action-content-review' => 'Sprawdzenie treści',
	'content-review-restore-summary' => 'Przywracanie strony do wersji $1',
	'content-review-status-unreviewed' => 'Niesprawdzona',
	'content-review-status-in-review' => 'Sprawdzana',
	'content-review-status-approved' => 'Zatwierdzona',
	'content-review-status-rejected' => 'Odrzucona',
	'content-review-status-live' => 'Aktywna',
	'content-review-status-autoapproved' => 'Zatwierdzona automatycznie',
	'content-review-rejection-explanation' => '==$1==
Niedawno przesłana zmiana tej strony JavaScript (wersja [$2 $3]) została odrzucona przez Wikię w sprawdzania kodu. Proszę upewnij się, że spełniasz [[Help:JavaScript review process|wytyczne własnego kodu JavaScript]]. --~~~~',
	'content-review-status-link-text' => 'Status przeglądu',
	'content-review-rejection-explanation-title' => 'Przesłana zmiana skryptu $1 została odrzucona',
	'content-review-special-js-pages-title' => 'Strony JavaScript',
	'content-review-module-header-pagename' => 'Nazwa strony',
	'content-review-module-header-actions' => 'Działania',
	'content-review-module-jspages' => 'Wszystkie strony JS',
	'content-review-special-js-description' => 'Ta strona przedstawia aktualny [[Help:JavaScript review process|status przeglądu]] skryptów obszaru nazw MediaWiki na tej społeczności.',
	'content-review-special-js-importjs-description' => 'Uwaga: istnieje możliwość dodawania i usuwania skryptów importowanych lokalnie i na dev.wikia.com bez procesu przeglądu poprzez [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Tutaj z łatwością zaimportujesz skrypty:
* z lokalnej wikii według nazwy artykułu - np. MyScript.js
* z dev.wikia.com według nazwy artykułu dodając "dev:" na początku nazwy - np. dev:Code.js
Nazwy nie powinny zawierać przedrostka obszaru nazw MediaWiki. Każdy skrypt należy zapisywać w nowej linii. Zobacz [[Help:Including additional CSS and JS]], aby uzyskać więcej informacji.
----
',
	'content-review-user-badges-description' => 'Jeśli chcesz korzystać z tej funkcji, musisz zaimportować [[w:c:dev:UserBadges|UserBadges.js]] ze strony dev.wikia.com. [[w:c:dev:UserBadges|Dowiedz się więcej]].

    Skorzystaj z tej strony, aby dostosować odznaczenia widoczne na profilach użytkowników. Rozdziel nazwę użytkownika i odznaczenie dwukropkiem. Jeśli chcesz wyświetlać wiele odznaczeń na jednym profilu użytkownika, oddziel tekst każdego oznaczenia przecinkiem. Każdą kolejną nazwę użytkownika napisz w nowej linii.

    Przykłady:

    * PrzykładowaNazwaUżytkownika : Praktykant, Nowy
    * PrzykładowaNazwaUżytkownika2 : Guru
----
',
];

$messages['pt'] = [
	'content-review-desc' => 'Esta extensão cria um processo que é revisado manualmente pela comunidade JavaScript antes do lançamento para os visitantes.',
	'content-review-module-title' => 'Status do JavaScript personalizado',
	'content-review-module-header-latest' => 'Revisão mais recente:',
	'content-review-module-header-last' => 'Última revisão:',
	'content-review-module-header-live' => 'Revisão ao vivo:',
	'content-review-module-status-none' => 'Nenhuma',
	'content-review-module-status-unsubmitted' => 'necessita ser submetida',
	'content-review-module-status-live' => 'ao vivo!',
	'content-review-module-status-awaiting' => 'aguardando revisão',
	'content-review-module-status-approved' => 'foi aprovada',
	'content-review-module-status-rejected' => 'foi rejeitada',
	'content-review-rejection-reason-link' => 'Por que?',
	'content-review-module-help' => '[[w:c:pt:Ajuda:Personalização_de_CSS_e_JS|Ajuda]]',
	'content-review-module-help-article' => 'Ajuda:Personalização_de_CSS_e_JS',
	'content-review-module-help-text' => 'Ajuda',
	'content-review-module-submit' => 'Enviar para revisão',
	'content-review-module-submit-success' => 'As alterações foram submetidas para revisão com êxito.',
	'content-review-module-submit-exception' => 'Infelizmente não foi possível submeter as alterações para revisão devido ao seguinte erro: $1.',
	'content-review-module-submit-error' => 'Infelizmente não foi possível submeter as alterações para revisão.',
	'content-review-module-test-mode-enable' => 'Entrar no modo de teste',
	'content-review-module-test-mode-disable' => 'Sair do modo de teste',
	'content-review-test-mode-error' => 'Algo deu errado. Por favor, tente novamente.',
	'content-review-test-mode-enabled' => 'Você está usando versões de arquivos personalizados JavaScript que não foram revisadas.',
	'action-content-review' => 'Revisão de conteúdo',
	'content-review-restore-summary' => 'Revertendo a página para a revisão $1',
	'content-review-status-unreviewed' => 'Não revisadas',
	'content-review-status-in-review' => 'Em revisão',
	'content-review-status-approved' => 'Aprovada',
	'content-review-status-rejected' => 'Rejeitada',
	'content-review-status-live' => 'Ao vivo',
	'content-review-status-autoapproved' => 'Auto-aprovada',
	'content-review-rejection-explanation' => '==$1==
A recente alteração enviada para esta página JavaScript (revisão [$2 $3]) foi rejeitada pelo processo de revisão da Wikia. Por favor, certifique-se de estar seguindo [[w:c:pt:Ajuda:Processo_de_revisão_de_JavaScript|as diretrizes personalizadas JavaScript]]. --˜˜˜˜ ',
	'content-review-status-link-text' => 'Status da revisão',
	'content-review-rejection-explanation-title' => 'A alteração do script $1 enviado foi rejeitada',
	'content-review-special-js-pages-title' => 'Páginas JavaScript',
	'content-review-module-header-pagename' => 'Título da página',
	'content-review-module-header-actions' => 'Ações',
	'content-review-module-jspages' => 'Todas as páginas JS',
	'content-review-special-js-description' => 'Esta página indica o atual [[Ajuda:Processo de revisão de JavaScript |status de revisão]] dos scripts namespace MediaWiki nesta comunidade.',
	'content-review-special-js-importjs-description' => 'Nota: você pode adicionar e remover os scripts importados local e dev.wikia.com sem o processo de revisão em [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Aqui, você pode importar scripts facilmente:
* da sua wikia local pelo nome do artigo - por exemplo, MyScript.js
* de dev.wikia.com pelo nome do artigo, precedido por "dev:"- por exemplo, dev:Code.js
Nomes não devem conter o prefixo de namespace MediaWiki. Escreva cada script em uma nova linha. Veja [[Ajuda: incluindo CSS e JS adicionais]] para obter mais informações. ---- ',
	'content-review-user-badges-description' => 'Para usar este recurso, você deve importar [[w:c:dev:UserBadges| UserBadges.js]] de dev.wikia.com. [[w:c:dev:UserBadges|Saiba mais]].

  Use esta página para personalizar as medalhas que aparecem nos perfis de usuário. Os nomes de usuários e as medalhas devem ser separados por dois-pontos. Para exibir várias medalhas para um usuário, separe cada texto com vírgulas. Escreva cada nome de usuário em uma nova linha.

  Exemplos:

  * ExemploNomedeusuário: estagiário, novato
  * ExemploNomedeusuário2: guru',
];

$messages['ru'] = [
	'content-review-desc' => 'Это расширение позволяет проверять пользовательский JavaScript википроекта перед тем, как он будет применён для посетителей вики.',
	'content-review-module-title' => 'Статус пользовательского JavaScript',
	'content-review-module-header-latest' => 'Последняя версия:',
	'content-review-module-header-last' => 'Последняя проверенная версия:',
	'content-review-module-header-live' => 'Рабочая версия:',
	'content-review-module-status-none' => 'Нет данных',
	'content-review-module-status-unsubmitted' => 'ожидается отправка',
	'content-review-module-status-live' => 'подключена!',
	'content-review-module-status-awaiting' => 'ожидается проверка',
	'content-review-module-status-approved' => 'одобрена',
	'content-review-module-status-rejected' => 'отклонена',
	'content-review-rejection-reason-link' => 'Почему?',
	'content-review-module-help' => '[[Справка:Использование CSS и JS|Справка]]',
	'content-review-module-help-article' => 'Справка:Проверка JavaScript',
	'content-review-module-help-text' => 'Справка',
	'content-review-module-submit' => 'Отправить на проверку',
	'content-review-module-submit-success' => 'Правки были успешно отправлены на проверку.',
	'content-review-module-submit-exception' => 'К сожалению, во время отправки последних правок на проверку произошла следующая ошибка: $1.',
	'content-review-module-submit-error' => 'К сожалению, отправка последних правок на проверку не удалась.',
	'content-review-module-test-mode-enable' => 'Войти в тестовый режим',
	'content-review-module-test-mode-disable' => 'Выйти из тестового режима',
	'content-review-test-mode-error' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже.',
	'content-review-test-mode-enabled' => 'В настоящее время вы используете непроверенные версии пользовательских файлов JavaScript. ',
	'action-content-review' => 'Проверка контента',
	'content-review-restore-summary' => 'Возврат страницы к версии $1',
	'content-review-status-unreviewed' => 'Не проверено',
	'content-review-status-in-review' => 'В процессе проверки',
	'content-review-status-approved' => 'Одобрено',
	'content-review-status-rejected' => 'Отклонено',
	'content-review-status-live' => 'Используется',
	'content-review-status-autoapproved' => 'Одобрено автоматически',
	'content-review-rejection-explanation' => '==$1==
Отправленные недавно изменения этой страницы (версия [$2 $3]) были отклонены после проверки кода. Проверьте, соответствует ли ваш код [[w:c:ru:Справка:Проверка JavaScript|политике Викия в отношении пользовательского JavaScript]]. --~~~~',
	'content-review-status-link-text' => 'Статус проверки',
	'content-review-rejection-explanation-title' => 'Отправленная версия $1 была отклонена',
	'content-review-special-js-pages-title' => 'Страницы JavaScript',
	'content-review-module-header-pagename' => 'Название страницы',
	'content-review-module-header-actions' => 'Действия',
	'content-review-module-jspages' => 'Все страницы с JavaScript',
	'content-review-special-js-description' => 'На этой странице указан текущий [[Справка:Проверка JavaScript|статус проверки JS]] для всех страниц с общим JS на этой вики.',
	'content-review-special-js-importjs-description' => "''Примечание''. Вы можете добавлять и удалять локальные скрипты без проверки с помощью страницы [[MediaWiki:ImportJS]].",
	'content-review-importjs-description' => 'С помощью этой страницы вы можете с лёгкостью добавлять скрипты:
* с локальной вики путём добавления названия страницы — например MyScript.js
* с dev.wikia.com при помощи добавления названия страницы с префиксом dev — например dev:Code.js
Названия не должны содержать префикс «MediaWiki». Указывайте название каждого отдельного скрипта новой строкой.
См. [[Справка:Включение дополнительных JS и CSS]] для получения дополнительной информации.
----
',
	'content-review-user-badges-description' => 'Чтобы использовать эту функцию, вы должны импортировать [[w:c:dev:UserBadges|UserBadges.js]] from dev.wikia.com. [[w:c:dev:UserBadges|Подробнее о UserBadges]].

    Используйте эту страницу, чтобы добавить пользовательские таблички, аналогичные табличкам со статусами, в профайлы участников. Чтобы добавить несколько табличек сразу, просто разделите их запятыми.

    Пример:

    * Участник1 : Новенький
    * ОпытныйУчастник2 : Гуру, Мастер шаблонов
----
',
];

$messages['zh-hans'] = [
	'content-review-desc' => '这个扩展功能让社区的JavaScript在完全开放给用户之前需要通过人工审核。',
	'content-review-module-title' => '自定义JavaScript状态',
	'content-review-module-header-latest' => '最新版本:',
	'content-review-module-header-last' => '上次审核版本:',
	'content-review-module-header-live' => '现在使用版本:',
	'content-review-module-status-none' => '无',
	'content-review-module-status-unsubmitted' => '需要提交',
	'content-review-module-status-live' => '已发布！',
	'content-review-module-status-awaiting' => '正在等待审核',
	'content-review-module-status-approved' => '已被批准',
	'content-review-module-status-rejected' => '已被拒绝',
	'content-review-rejection-reason-link' => '为什么?',
	'content-review-module-help' => '[[Help:自訂CSS與JS|帮助]]',
	'content-review-module-help-article' => '帮助: CSS和JS定制化',
	'content-review-module-help-text' => '帮助',
	'content-review-module-submit' => '提交等待审核',
	'content-review-module-submit-success' => '所做的更改已成功提交等待审核。',
	'content-review-module-submit-exception' => '很抱歉，由于以下错误我们无法提交对所做更改的审核请求: $1。',
	'content-review-module-submit-error' => '很抱歉，我们无法提交对所做更改的审核请求。',
	'content-review-module-test-mode-enable' => '进入测试模式',
	'content-review-module-test-mode-disable' => '退出测试模式',
	'content-review-test-mode-error' => '出错了。请稍后再试。',
	'content-review-test-mode-enabled' => '您当前使用未通过审核的自定义JavaScript脚本。',
	'action-content-review' => '内容审核',
	'content-review-restore-summary' => '回退页面到版本$1',
	'content-review-status-unreviewed' => '未审核',
	'content-review-status-in-review' => '正在审核中',
	'content-review-status-approved' => '已批准',
	'content-review-status-rejected' => '已被拒绝',
	'content-review-status-live' => '已发布',
	'content-review-status-autoapproved' => '自动批准',
	'content-review-rejection-explanation' => '==$1==
JavaScript页面最近提交的变更请求(版本[$2 $3]) 未通过Wikia审核。请确保您的变更符合[[Help:JavaScript審核流程|JavaScript审核流程]]。--~~~~',
	'content-review-status-link-text' => '审核状态',
	'content-review-rejection-explanation-title' => '提交的脚本更改$1被拒绝',
	'content-review-special-js-pages-title' => 'JavaScript页面',
	'content-review-module-header-pagename' => '页面名称',
	'content-review-module-header-actions' => '操作',
	'content-review-module-jspages' => '所有的JS页面',
	'content-review-special-js-description' => '此页面列出这个社区当前Mediawiki命名空间脚本的[[Help:JavaScript審核流程|审核状态]]。',
	'content-review-special-js-importjs-description' => '注意: 您可以不需要通过[[MediaWiki:ImportJS]]审查流程就可以添加和删除本地以及dev.wikia.com的脚本输入。',
	'content-review-importjs-description' => '在这里，您可以通过以下途径轻松地导入脚本:
* 在您的Wikia社区通过文章名称进行导入 - 例如：MyScript.js
* 从dev.wikia.com通过文章名称，前缀"dev:"进行导入 - 例如：dev:Code.js
名称不应包含MediaWiki命名空间前缀。请在新的一行上逐个输入脚本。请点击[[Help:Including additional CSS and JS|帮助页]]了解详细信息。
----',
	'content-review-user-badges-description' => '若要使用此功能，您必须从dev.wikia.com导入[[w:c:dev:UserBadges|UserBadges.js]]。[[w:c:dev:UserBadges|点击这里了解更多]]。

    使用此页可以自定义出现在用户设定界面上的徽章。使用冒号分隔用户名和徽章。若要为用户显示多枚徽章，请用逗号分隔每个徽章名称。您可以在新的一行上写每个用户名。

    例如:
    * 用户名例子1: 见习，新手
    * 用户名例子2: 大师
----',
];

$messages['zh-hant'] = [
	'content-review-desc' => '此擴展功能讓社區的JavaScript在完全開放給使用者之前需要通過人工審核。',
	'content-review-module-title' => '自訂JavaScript狀態',
	'content-review-module-header-latest' => '最新版本:',
	'content-review-module-header-last' => '上次審核版本:',
	'content-review-module-header-live' => '現在使用版本:',
	'content-review-module-status-none' => '無',
	'content-review-module-status-unsubmitted' => '需要提交',
	'content-review-module-status-live' => '已發佈！',
	'content-review-module-status-awaiting' => '正在等待審核',
	'content-review-module-status-approved' => '已通過審核',
	'content-review-module-status-rejected' => '被拒絕了',
	'content-review-rejection-reason-link' => '為什麼?',
	'content-review-module-help' => '[[Help:自訂CSS與JS|幫助]]',
	'content-review-module-help-article' => '幫助:自訂CSS與JS',
	'content-review-module-help-text' => '幫助',
	'content-review-module-submit' => '送出審核',
	'content-review-module-submit-success' => '所做的更改已成功提交供審核。',
	'content-review-module-submit-exception' => '很抱歉，由於以下錯誤我們無法送出對所做更改的審核請求: $1。',
	'content-review-module-submit-error' => '很抱歉，我們無法送出對所做更改的審查請求。',
	'content-review-module-test-mode-enable' => '進入測試模式',
	'content-review-module-test-mode-disable' => '離開測試模式',
	'content-review-test-mode-error' => '出錯了。請稍後再試。',
	'content-review-test-mode-enabled' => '您當前使用自訂JavaScript的未審核版本。',
	'action-content-review' => '內容審核',
	'content-review-restore-summary' => '回退頁面到版本$1',
	'content-review-status-unreviewed' => '未審核',
	'content-review-status-in-review' => '審核中',
	'content-review-status-approved' => '已通過',
	'content-review-status-rejected' => '未通過',
	'content-review-status-live' => '已發佈',
	'content-review-status-autoapproved' => '已自動批准',
	'content-review-rejection-explanation' => '==$1==
JavaScript頁最近提交的變更請求(版本[$2 $3]) 未通過Wikia審核。 請確保您的變更符合[[Help:JavaScript審核流程|JavaScript審核流程]]。 --~~~~',
	'content-review-status-link-text' => '審核狀態',
	'content-review-rejection-explanation-title' => '提交的腳本更改$1被拒絕',
	'content-review-special-js-pages-title' => 'JavaScript頁',
	'content-review-module-header-pagename' => '頁面名稱',
	'content-review-module-header-actions' => '操作',
	'content-review-module-jspages' => '所有的JS頁面',
	'content-review-special-js-description' => '此頁面列出這個社區當前Mediawiki命名空間腳本的[[Help:JavaScript審核流程|審核狀態]]。',
	'content-review-special-js-importjs-description' => '注意: 您可以不需要通過[[MediaWiki:ImportJS]]審查流程就可以添加和刪除本地以及dev.wikia.com的腳本輸入。',
	'content-review-importjs-description' => '在這裡，您可以通過以下途徑輕鬆地導入腳本:
* 在您的Wikia社區通過文章名稱進行導入 - 例如：MyScript.js
* 從dev.wikia.com通過文章名稱，首碼"dev:"進行導入 - 例如：dev:Code.js
名稱不應包含MediaWiki命名空間首碼。請在新的一行上逐個輸入腳本。請點擊[[Help:Including additional CSS and JS|説明頁]]參閱詳細資訊。
----',
	'content-review-user-badges-description' => '若要使用此功能，您必須從dev.wikia.com導入[[w:c:dev:UserBadges|UserBadges.js]]。[[w:c:dev:UserBadges|點擊這裡查閱更多]]。

使用此頁可以自訂出現在用户設定介面上的徽章。 使用冒號分隔用户名和徽章。若要為用户顯示多枚徽章，請用逗號分隔每個徽章名稱。您可以在新的一行上寫上每個用户名。

例如:
* 用户名例子1: 見習，新手
* 用户名例子2: 大師
----',
];

