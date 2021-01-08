<?php
$messages = array();

$messages['en'] = array(
	'content-review-desc' => 'This extension creates a process by which community JavaScript is manually reviewed before it goes live for visitors.',
	'content-review-importjs-desc' => 'This extension allows importing reviewed JS from other wikis using the MediaWiki page [[MediaWiki:ImportJS]].',
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
The recently submitted change to this JavaScript page (revision [$2 $3]) was rejected by the FANDOM review process. Please make sure you meet the [[Help:JavaScript review process|Custom JavaScript guidelines]]. --~~~~',
	'content-review-special-js-pages-title' => 'JavaScript pages',
	'content-review-special-js-description' => 'This page lists the current [[Help:JavaScript review process|review status]] of MediaWiki namespace scripts on this community.',
	'content-review-special-js-importjs-description' => 'Note: you can add and remove local and dev.wikia.com script imports without the review process via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Here, you can easily import scripts:
* from your local community by article name - e.g. MyScript.js
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
);

$messages['qqq'] = array(
	'content-review-desc' => '{{desc}}',
	'content-review-importjs-desc' => '{{desc}}',
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
	'content-review-special-js-pages-title' => 'Title of special page which contains all JavaScript pages on given wiki',
	'content-review-special-js-description' => 'Text with description of this special page that contains lists with all scripts in MediaWiki namespace on that community with their review statuses and linking to help page.',
	'content-review-special-js-importjs-description' => 'Information that user can manage script imports from community or dev.wikia.com by editing  MediaWiki:ImportJS page.',
	'content-review-importjs-description' => 'Information for user how to add scripts. For scripts from local wikia, user should only add article name and from dev.wikia.com should preceded them by "dev:". Also user should add MediaWiki namespace and should add each script in separate line.',
	'content-review-profile-tags-description' => 'Inform user that to use this feature user must import ProfileTags.js script from dev.wikia.com. Then explain that user should use current page to customize user tags on their profiles by adding user name and tags separated by a pipe (|).
	 If a user wants to provide for more than one tag for a user, they should separate them by comma. Also each user name should be written on a new line. Examples:

    * ExampleUsername | Trainee, Newbie
    * ExampleUsername2 | Guru',
);

$messages['de'] = array(
	'content-review-desc' => 'Diese Erweiterung setzt einen Prozess in Gang, während dessen der JavaScript-Code der Community manuell überprüft wird, bevor Besucher die Ergebnisse live sehen können.',
	'content-review-module-title' => 'Status des angepassten JavaScripts',
	'content-review-module-header-latest' => 'Letzte Änderung',
	'content-review-module-header-last' => 'Letzte überprüfte Änderung:',
	'content-review-module-header-live' => 'Aktuell freigegebene Version:',
	'content-review-module-status-none' => 'Keine',
	'content-review-module-status-unsubmitted' => 'muss eingereicht werden',
	'content-review-module-status-live' => 'ist live!',
	'content-review-module-status-awaiting' => 'wartet auf die Überprüfung',
	'content-review-module-status-approved' => 'wurde zugelassen',
	'content-review-module-status-rejected' => 'wurde abgelehnt',
	'content-review-rejection-reason-link' => 'Warum?',
	'content-review-module-help' => '[[w:c:de:Hilfe:CSS-_und_JS-Anpassungen|Hilfe]]',
	'content-review-module-help-article' => '[[w:c:de:Hilfe:CSS- und JS-Anpassungen|Hilfe]]',
	'content-review-module-help-text' => 'Hilfe',
	'content-review-module-submit' => 'Zur Überprüfung einreichen',
	'content-review-module-submit-success' => 'Die Änderungen wurden erfolgreich zur Überprüfung eingereicht.',
	'content-review-module-submit-exception' => 'Leider konnten wir die Änderungen aufgrund des folgenden Fehlers nicht zur Überprüfung einreichen: $1',
	'content-review-module-submit-error' => 'Leider konnten wir die Änderungen nicht zur Überprüfung einreichen.',
	'content-review-module-test-mode-enable' => 'Testmodus starten',
	'content-review-module-test-mode-disable' => 'Testmodus verlassen',
	'content-review-test-mode-error' => 'Es ist etwas schief gelaufen. Versuche es bitte später noch einmal.',
	'content-review-test-mode-enabled' => 'Du verwendest derzeit ungeprüfte Versionen benutzerdefinierter JavaScript-Dateien.',
	'action-content-review' => 'Überprüfung von Inhalten',
	'content-review-restore-summary' => 'Seite wird auf Version $1 zurückgesetzt',
	'content-review-status-unreviewed' => 'Nicht überprüft',
	'content-review-status-in-review' => 'Wird überprüft',
	'content-review-status-approved' => 'Zugelassen',
	'content-review-status-rejected' => 'Abgelehnt',
	'content-review-status-live' => 'Live',
	'content-review-status-autoapproved' => 'Automatisch zugelassen',
	'content-review-rejection-explanation' => '==$1==
Die kürzlich eingereichte Änderung dieser JavaScript-Seite (Überprüfung [$2 $3]) wurde im FANDOM-Überprüfungsprozess abgelehnt. Stelle bitte sicher, dass du die [[w:c:de:Hilfe:JavaScript-Überprüfungsprozess|Richtlinien für angepasstes JavaScript]] erfüllst.--~~~~',
	'content-review-rejection-explanation-title' => 'Die eingereichte Skript-Änderung $1 wurde abgelehnt',
	'content-review-special-js-pages-title' => 'JavaScript-Seiten',
	'content-review-module-header-pagename' => 'Seitenname',
	'content-review-module-header-actions' => 'Aktionen',
	'content-review-module-jspages' => 'Alle JavaScript-Seiten',
	'content-review-special-js-description' => 'Auf dieser Seite wird der aktuelle Stand im [[w:c:de:Hilfe:JavaScript-Überprüfungsprozess|Überprüfungsprozess]] von MediaWiki-Namensraum-Skripten dieser Community aufgeführt.',
	'content-review-special-js-importjs-description' => 'Hinweis: Du kannst lokale Importe und Skripte aus dem Fandom Developers Wiki [[w:c:dev|dev.fandom.com]] ohne den Überprüfungsprozess über [[MediaWiki:ImportJS]] hinzufügen und entfernen.',
	'content-review-importjs-description' => 'Von hier kannst du ganz einfach Skripte importieren:
* aus deinem Wiki nach Artikelname - z. B. MeinSkript.js
* aus [[w:c:dev|dev.fandom.com]] nach Artikelname mit vorangestelltem "dev:" - z. B. dev:Code.js
Namen sollten nicht das MediaWiki-Präfix enthalten. Verwende für jedes Skript eine neue Zeile. Weitere Informationen findest du unter [[w:c:de:Hilfe:Einbinden_von_zusätzlichem_CSS_und_JS|Einbinden von zusätzlichem CSS und JS]].
----
',
	'right-content-review' => 'Ermöglicht den Zugriff auf Werkzeuge zum Überprüfen von Inhalten',
	'right-content-review-test-mode' => 'Ermöglicht den Zugriff auf Testumgebungen zum Überprüfen von Inhalten',
	'group-content-reviewer' => 'Inhalts-Überprüfer',
	'content-review-status-escalated' => 'An zusätzlichen Prüfer weitergeleitet',
	'content-review-profile-tags-description' => 'Um diese Funktion nutzen zu können, musst du das Skript [[w:c:dev:ProfileTags|ProfileTags.js]] von dev.fandom.com importieren. [[w:c:dev:ProfileTags|Hier erfährst du mehr]].

Verwende diese Seite, um die Tags in den Benutzerprofilen anzupassen. Benutzernamen und Tags werden mit einem senkrechten Strich (|) getrennt. Um für einen Benutzer mehrere Tags anzuzeigen, trenne jeden Tag mit einem Komma ab. Schreibe jeden Benutzernamen in eine neue Zeile.

Beispiele:

BeispielBenutzername | Praktikant, Newbie
BeispielBenutzername2 | Guru
----
',
	'content-review-status-link-text' => 'Stand der Überprüfung',
);

$messages['es'] = array(
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
	'content-review-module-help' => '[[w:c:comunidad:Ayuda:Personalización CSS y JS|Ayuda]]',
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
El cambio recientemente presentado a esta página de JavaScript (revisión [$2 $3]) fue rechazado por el proceso de revisión de FANDOM. Por favor, asegúrate de que cumple con las [[w:c:comunidad:Ayuda:Proceso de revisión de JavaScript|directrices de personalización de JavaScript]]. --~~~~',
	'content-review-rejection-explanation-title' => 'El cambio de script $1 presentado ha sido rechazado',
	'content-review-special-js-pages-title' => 'Páginas de JavaScript',
	'content-review-module-header-pagename' => 'Nombre de la página',
	'content-review-module-header-actions' => 'Acciones',
	'content-review-module-jspages' => 'Todas las páginas de JS',
	'content-review-special-js-description' => 'Esta página muestra [[w:c:comunidad:Ayuda:Proceso de revisión de JavaScript|el estado de revisión de JavaScript]] de los guiones de espacio para nombres de MediaWiki en esta comunidad.',
	'content-review-special-js-importjs-description' => 'Nota: puedes añadir y remover guiones locales e importados de dev.wikia.com sin el proceso de revisión vía [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Aquí, puedes importar fácilmente guiones:
* de tu wiki local por nombre de artículo - e.j. MiGuión.js
* de dev.wikia.com por nombre de artículo, precedido por "dev:" - e.j. dev:Código.js
Los nombres no deben contener el prefijo del espacio para nombres de MediaWiki. Escribe cada guión en una nueva línea. Ver [[w:c:comunidad:Ayuda:Incluyendo JavaScript y CSS adicional]] para más información.
----
',
	'right-content-review' => 'Permite el acceso a herramientas de revisión de contenido',
	'right-content-review-test-mode' => 'Permite el acceso a pruebas de revisión de contenido',
	'group-content-reviewer' => 'Revisores de contenido',
	'content-review-status-escalated' => 'Escalado',
	'content-review-profile-tags-description' => 'Para utilizar esta funcionalidad, debes importar [[w:c:dev:ProfileTags|ProfileTags.js]] de dev.wikia.com. [[w:c:dev:ProfileTags|Conoce más]].

Utiliza esta página para personalizar los cargos que aparecen en los perfiles de usuario. Separa los nombres de usuario y los cargos con (|). Para mostrar múltiples cargos para un usuario, separa cada texto de cargo con comas. Escribe cada nombre de usuario en una nueva línea.

 Ejemplos:

 * EjemploNombredeusuario | Aprendiz, Novato
 * EjemploNombredeusuario2 | Gurú
----
 
',
	'content-review-status-link-text' => 'Estado de la revisión',
);

$messages['fr'] = array(
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
Le processus de vérification FANDOM a rejeté la modification soumise pour cette page JavaScript (révision [$2 $3]) . Assurez-vous de respecter les [[w:c:fr:Aide:Processus_de_vérification_du_JavaScript|instructions de personnalisation du JavaScript]]. --~~~~',
	'content-review-rejection-explanation-title' => 'Modification $1 soumise pour le script rejetée',
	'content-review-special-js-pages-title' => 'Pages JavaScript',
	'content-review-module-header-pagename' => 'Nom de la page',
	'content-review-module-header-actions' => 'Actions',
	'content-review-module-jspages' => 'Toutes les pages JS',
	'content-review-special-js-description' => "Cette page indique [[w:c:fr:Aide:Processus_de_vérification_du_JavaScript| l'état de vérification]] des scripts de l'espace de noms MediaWiki relatifs à cette communauté.",
	'content-review-special-js-importjs-description' => 'Remarque : vous pouvez ajouter et supprimer les importations de scripts dev.wikia.com et locaux sans processus de vérification via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => "Vous pouvez ici facilement importer des scripts :
* de votre wiki local par nom d'article (par ex., MonScript.js) ;
* de dev.wikia.com par nom d'article précédé de \"dev:\" (par ex., dev:Code.js).
Les noms ne doivent pas comporter le préfixe d'espace de noms MediaWiki. Écrivez chaque script sur une nouvelle ligne. Pour plus d'informations, consultez la page [[w:c:fr:Aide:Inclure_du_CSS_et_JS_supplémentaire|Aide:Inclure du CSS et JS supplémentaire]].
----
",
	'right-content-review' => "Permet d'accéder aux outils de vérification du contenu",
	'right-content-review-test-mode' => "Permet d'accéder à l'environnement de test de vérification du contenu",
	'group-content-reviewer' => 'Vérification du contenu',
	'content-review-status-escalated' => 'Remontée',
	'content-review-profile-tags-description' => "Pour utiliser cette fonctionnalité, vous devez importer [[w:c:dev:ProfileTags|ProfileTags.js]] de dev.wikia.com. [[w:c:dev:ProfileTags|En savoir plus]]

Cette page permet de personnaliser les étiquettes apparaissant sur les profils utilisateur. Séparez les noms d'utilisateur et les étiquettes par une barre verticale (|). Pour afficher plusieurs étiquettes pour un même utilisateur, séparez chaque texte d'étiquette par des virgules. Écrivez chaque nom d'utilisateur sur une nouvelle ligne.

Exemples :

 Nomutilisateur1 | Apprenti, Nouveau
 Nomutilisateur2 | Gourou
----
",
	'content-review-status-link-text' => 'État de la vérification',
);

$messages['it'] = array(
	'content-review-desc' => 'Questa estensione crea un processo attraverso il quale il JavaScript della community è controllato manualmente prima che diventi visibile ai visitatori.',
	'content-review-module-title' => 'Stato del JavaScript personalizzato',
	'content-review-module-header-latest' => 'Ultima revisione:',
	'content-review-module-header-last' => 'Ultima revisione controllata:',
	'content-review-module-header-live' => 'Revisione in uso:',
	'content-review-module-status-none' => 'Nessuna',
	'content-review-module-status-unsubmitted' => 'deve essere inviata',
	'content-review-module-status-live' => 'è in uso!',
	'content-review-module-status-awaiting' => 'è in attesa di revisione',
	'content-review-module-status-approved' => 'è stata approvata',
	'content-review-module-status-rejected' => 'è stata respinta',
	'content-review-rejection-reason-link' => 'Perché?',
	'content-review-module-help' => '[[w:it:Aiuto:Personalizzare CSS e JS|Aiuto]]',
	'content-review-module-help-article' => 'Aiuto:Personalizzare CSS e JS',
	'content-review-module-help-text' => 'Aiuto',
	'content-review-module-submit' => 'Invia per revisione',
	'content-review-module-submit-success' => 'Le modifiche per la revisione sono state inviate con successo.',
	'content-review-module-submit-exception' => 'Sfortunatamente non abbiamo potuto inviare le modifiche per la revisione a causa del seguente errore: $1.',
	'content-review-module-submit-error' => 'Sfortunatamente non abbiamo potuto inviare le modifiche per la revisione.',
	'content-review-module-test-mode-enable' => 'Entra in modalità test',
	'content-review-module-test-mode-disable' => 'Esci dalla modalità test',
	'content-review-test-mode-error' => 'Qualcosa è andato storto. Riprova più tardi.',
	'content-review-test-mode-enabled' => 'Attualmente stai usando versioni non ancora controllate dei file in JavaScript personalizzato. ',
	'action-content-review' => 'Revisione dei contenuti',
	'content-review-restore-summary' => 'Ripristino pagina alla revisione $1',
	'content-review-status-unreviewed' => 'Non revisionata',
	'content-review-status-in-review' => 'In revisione',
	'content-review-status-approved' => 'Approvata',
	'content-review-status-rejected' => 'Respinta',
	'content-review-status-live' => 'In uso',
	'content-review-status-autoapproved' => 'Auto-approvata',
	'content-review-rejection-explanation' => '== $1 ==
La modifica inviata di recente per questa pagina JavaScript (revisione [$2 $3]) è stata respinta dal processo di revisione di FANDOM. Assicurati di seguire le [[w:it:Aiuto:Processo di revisione del JavaScript|linee guida del JavaScript personalizzato]]. --~~~~',
	'content-review-rejection-explanation-title' => 'La modifica $1 inviata per lo script è stata respinta',
	'content-review-special-js-pages-title' => 'Pagine JavaScript',
	'content-review-module-header-pagename' => 'Nome della pagina',
	'content-review-module-header-actions' => 'Azioni',
	'content-review-module-jspages' => 'Tutte le pagine JS',
	'content-review-special-js-description' => "Questa pagina indica l'attuale [[w:it:Aiuto:Processo di revisione del JavaScript|stato di revisione]] degli script delle pagine MediaWiki di questa wiki.",
	'content-review-special-js-importjs-description' => 'Nota: puoi aggiungere e rimuovere le importazioni degli script locali e da dev.wikia.com senza attendere il processo di revisione usando [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Potrai facilmente importare gli script:
* dalla tua wiki locale con il nome della pagina (per esempio: MyScript.js)
* da dev.wikia.com con il nome della pagina preceduto da "dev:" (per esempio: dev:Code.js)
I nomi delle pagine non devono includere il namespace MediaWiki. Aggiungi ogni script su una riga nuova. Per maggiori informazioni consulta [[w:it:Aiuto:Includere CSS e JS aggiuntivi|Aiuto:Includere CSS e JS aggiuntivi]].
----
',
	'right-content-review' => "Consente l'accesso agli strumenti di revisione dei contenuti",
	'right-content-review-test-mode' => "Consente l'accesso all'ambiente di test per la revisione dei contenuti",
	'group-content-reviewer' => 'Revisori dei contenuti',
	'content-review-status-escalated' => 'In revisione avanzata',
	'content-review-profile-tags-description' => 'Per usare questa funzione, è necessario importare [[w:c:dev:ProfileTags|ProfileTags.js]] da dev.wikia.com. [[w:c:dev:ProfileTags|Ulteriori informazioni]].

Usare questa pagina per personalizzare i tag visualizzate nei profili utente. Separare i nomi utenti e tag con un pipe (|). Per visualizzare diversi tag per un utente, separare il testo di ogni tag con delle virgole. Scrivere ogni nome utente su una nuova riga.

Esempi:

 ExampleUsername | Apprendista, Novellino
 ExampleUsername2 | Guru
----
',
	'content-review-status-link-text' => 'Stato della revisione',
);

$messages['ja'] = array(
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
最近申請されたJavaScriptページへの変更（版[$2 $3]）は、FANDOMの審査プロセスにおいて却下されました。[[ヘルプ:JavaScriptの審査プロセス|カスタムJavaScriptのガイドライン]]を満たしていることをご確認ください。--~~~~',
	'content-review-rejection-explanation-title' => '申請したスクリプトの変更「$1」が拒否されました',
	'content-review-special-js-pages-title' => 'JavaScriptページ',
	'content-review-module-header-pagename' => 'ページ名',
	'content-review-module-header-actions' => '対処',
	'content-review-module-jspages' => 'すべてのJSページ',
	'content-review-special-js-description' => 'このページには、このコミュニティのMediaWiki名前空間スクリプトの現在の[[w:c:ja:ヘルプ:JavaScriptの審査プロセス|審査状況]]が一覧表示されています。',
	'content-review-special-js-importjs-description' => '注：ローカルとdev.wikia.comのスクリプトのインポートは、[[MediaWiki:ImportJS]]から審査プロセスを経ずに追加、削除できます。',
	'content-review-importjs-description' => 'ここでは、スクリプトを簡単にインポートすることができます：
* ローカルコミュニティからは記事名（例：MyScript.js）
* dev.wikia.comからは記事名の先頭に「dev:」を付ける（例：dev:Code.js）
MediaWikiの名前空間プレフィックスは名前に含めないでください。スクリプトごとに新しい行に記述します。詳しくは、[[ヘルプ:追加のJavaScriptとCSSをインクルードする]]をご覧ください。
----
',
	'right-content-review' => 'コンテンツ審査ツールへのアクセスを許可する',
	'right-content-review-test-mode' => 'コンテンツ審査のテストモードへのアクセスを許可する',
	'group-content-reviewer' => 'コンテンツの審査メンバー',
	'content-review-status-escalated' => '審査中',
	'content-review-profile-tags-description' => 'この機能を使用するには、dev.wikia.comから[[w:c:dev:ProfileTags|ProfileTags.js]]をインポートする必要があります。[[w:c:dev:ProfileTags|詳細]]

このページを使って、ユーザー・プロフィールに表示されるタグをカスタマイズしてください。ユーザー名とタグはパイプ（|）で区切り、1人のユーザーに対して複数のタグを表示する場合は、それぞれのタグテキストをカンマで区切ります。また、ユーザー名ごとに改行して記述します。

例：

 ユーザー名 | Trainee, Newbie
 ユーザー名2 | Guru
----
',
	'content-review-status-link-text' => '審査状況',
);

$messages['ko'] = array(
	'content-review-module-submit-exception' => '다음 오류로 인해 검토를 요청하는 데 실패했습니다: $1',
	'content-review-module-header-actions' => '작업',
	'content-review-module-header-pagename' => '문서 이름',
	'content-review-rejection-reason-link' => '이유',
	'content-review-status-in-review' => '검토 중',
	'content-review-module-help-article' => '도움말:CSS 및 자바 스크립트',
	'content-review-test-mode-enabled' => '현재 검토되지 않은 자바 스크립트를 사용하고 있습니다. ',
	'content-review-module-status-approved' => '승인됨',
	'content-review-module-help-text' => '도움말',
	'content-review-module-help' => '[[도움말:CSS 및 자바 스크립트|도움말]]',
	'content-review-module-header-live' => '적용된 판:',
	'content-review-importjs-description' => '이곳에서 기존의 스크립트를 가져오실 수 있습니다.
* 문서 이름을 통해 귀하의 커뮤니티에서 스크립트를 가져오실 수 있습니다. - 예: MyScript.js
* “dev:문서 이름” 형식을 통해 dev.fandom.com에서 스크립트를 가져오실 수 있습니다. - 예: dev:Code.js
각 문서의 이름에서 미디어위키 이름공간을 제외하고 입력해야 합니다. 한 줄에 하나씩 입력해야 합니다. 보다 자세한 내용은 [[도움말:자바 스크립트 및 CSS 불러오기|이곳]]을 참고하시기 바랍니다.
----
',
	'content-review-module-header-latest' => '최신 판:',
	'content-review-module-status-awaiting' => '검토 대기 중',
	'action-content-review' => '콘텐츠 검토',
	'content-review-module-title' => '자바 스크립트 검토 상황',
	'content-review-rejection-explanation' => '==$1==
최근 검토 요청된 자바 스크립트([$2 $3] 판)는 팬덤 검토 시스템에 의해 승인 거부되었습니다. 해당 스크립트가 [[도움말:자바 스크립트 검토 시스템|자바 스크립트 승인 기준]]에 부합하는지 확인해 주시기 바랍니다.',
	'group-content-reviewer' => '콘텐츠 검토자',
	'content-review-status-autoapproved' => '자동 승인됨',
	'content-review-module-status-live' => '현재 적용 중',
	'content-review-module-submit-error' => '검토를 요청하는 데 실패했습니다.',
	'content-review-special-js-description' => '이 문서에서는 미디어위키 이름공간에 속한 스크립트들의 [[도움말:자바 스크립트 검토 시스템|검토 상황]]을 확인하실 수 있습니다.',
	'content-review-module-header-last' => '최근 검토된 판:',
	'content-review-module-status-none' => '없음',
	'content-review-restore-summary' => '$1 판으로 되돌림',
	'content-review-module-submit' => '검토 요청',
	'right-content-review' => '콘텐츠 검토 도구를 활성화합니다',
	'content-review-status-rejected' => '거부됨',
	'content-review-test-mode-error' => '오류가 발생했습니다. 잠시 후 다시 시도해 주십시오.',
	'content-review-special-js-pages-title' => '자바 스크립트 문서',
	'content-review-status-unreviewed' => '미검토',
	'content-review-module-jspages' => '모든 자바 스크립트 문서',
	'content-review-rejection-explanation-title' => '$1 판은 승인 거부되었습니다',
	'content-review-profile-tags-description' => '이 기능을 사용하시려면 dev.fandom.com으로부터 [[w:c:dev:ProfileTags|ProfileTags.js]] 스크립트를 가져오셔야 합니다. ([[w:c:dev:ProfileTags|자세히 알아보기]])

이 문서를 통해 사용자 프로필에 나타나는 태그를 수정하실 수 있습니다. 사용자 이름과 태그는 수직선(|)을 통해 구분합니다. 한 사용자에게 여러 태그를 표시하려면 각 태그를 쉼표로 구분하여 입력하십시오. 한 줄에 한 사용자씩 입력하십시오.

예시:

 사용자이름 | 연습생, 뉴비
 사용자이름2 | 전문가
----
',
	'content-review-status-approved' => '승인됨',
	'content-review-module-test-mode-enable' => '테스트 모드 활성화',
	'content-review-status-live' => '적용됨',
	'content-review-module-test-mode-disable' => '테스트 모드 비활성화',
	'right-content-review-test-mode' => '콘텐츠 검토용 테스트 환경을 활성화합니다',
	'content-review-module-status-unsubmitted' => '검토 요청 필요',
	'content-review-status-link-text' => '검토 상황',
	'content-review-special-js-importjs-description' => '참고: [[MediaWiki:ImportJS|ImportJS]] 기능을 통해 검토 단계를 생략하고 기존의 스크립트를 귀하의 위키 또는 dev.fandom.com으로부터 가져오실 수 있습니다.',
	'content-review-status-escalated' => '추가 검토 중',
	'content-review-module-submit-success' => '검토를 요청했습니다.',
	'content-review-desc' => '자바 스크립트가 커뮤니티에 적용되기 전에 미리 내용을 검토하는 절차를 추가합니다.',
	'content-review-module-status-rejected' => '거부됨',
);

$messages['nl'] = array(
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
The recently submitted change to this JavaScript page (revision [$2 $3]) was rejected by the FANDOM review process. Please make sure you meet the [[Help:JavaScript review process|Custom JavaScript guidelines]]. --~~~~',
	'content-review-rejection-explanation-title' => 'Submitted script change $1 rejected',
	'content-review-special-js-pages-title' => 'JavaScript pages',
	'content-review-module-header-pagename' => 'Page name',
	'content-review-module-header-actions' => 'Actions',
	'content-review-module-jspages' => 'All JS pages',
	'content-review-special-js-description' => 'This page lists the current [[Help:JavaScript review process review status]] of MediaWiki namespace scripts on this community.',
	'content-review-special-js-importjs-description' => 'Note: you can add and remove local and dev.wikia.com script imports without the review process via [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Here, you can easily import scripts:
* from your local community by article name - e.g. MyScript.js
* from dev.wikia.com by article name, preceded by "dev:" - e.g. dev:Code.js
Names should not contain the MediaWiki namespace prefix. Write each script on a new line. See [[Help:Including additional CSS and JS]] for more information.
----
',
	'right-content-review' => 'Allows access to content review tools',
	'right-content-review-test-mode' => 'Allows access to content review testing environment',
	'group-content-reviewer' => 'Content Reviewers',
	'content-review-status-escalated' => 'Escalated',
	'content-review-profile-tags-description' => 'To use this feature, you must import [[w:c:dev:ProfileTags|ProfileTags.js]] from dev.wikia.com. [[w:c:dev:ProfileTags|Learn more]].

Use this page to customize the tags that appear on user profiles. Separate usernames and tags by a pipe (|). To display multiple tags for a user, separate each tag text with commas. Write each username on a new line.

Examples:

 ExampleUsername | Trainee, Newbie
 ExampleUsername2 | Guru
----
',
);

$messages['pl'] = array(
	'content-review-desc' => 'To rozszerzenie tworzy proces, dzięki któremu kod JavaScript tworzony przez społeczność jest ręcznie sprawdzany zanim zobaczą go odwiedzający.',
	'content-review-module-title' => 'Status przeglądu JavaScript',
	'content-review-module-header-latest' => 'Ostatnia wersja:',
	'content-review-module-header-last' => 'Ostatnia sprawdzona wersja:',
	'content-review-module-header-live' => 'Aktywna wersja:',
	'content-review-module-status-none' => 'brak',
	'content-review-module-status-unsubmitted' => 'wymaga sprawdzenia',
	'content-review-module-status-live' => 'jest aktywna!',
	'content-review-module-status-awaiting' => 'oczekuje na sprawdzenie',
	'content-review-module-status-approved' => 'została zaakceptowana',
	'content-review-module-status-rejected' => 'została odrzucona',
	'content-review-rejection-reason-link' => 'Dlaczego?',
	'content-review-module-help' => '[[w:pl:Pomoc:Dostosowywanie CSS i JS|Pomoc]]',
	'content-review-module-help-article' => 'w:pl:Pomoc:Dostosowywanie CSS i JS',
	'content-review-module-help-text' => 'Pomoc',
	'content-review-module-submit' => 'Prześlij do sprawdzenia',
	'content-review-module-submit-success' => 'Zmiany zostały pomyślnie przesłane do sprawdzenia.',
	'content-review-module-submit-exception' => 'Niestety, nie udało się przesłać zmian do sprawdzenia z powodu następującego błędu: $1.',
	'content-review-module-submit-error' => 'Niestety nie udało się przesłać zmian do sprawdzenia.',
	'content-review-module-test-mode-enable' => 'Włącz tryb testowy',
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
	'content-review-rejection-explanation' => '== $1 ==
Niedawno przesłana edycja tej strony JavaScript (wersja [$2 $3]) została odrzucona przez FANDOM. Proszę upewnij się, że spełniasz [[w:pl:Pomoc:Proces przeglądu kodu JavaScript|kryteria własnego kodu JavaScript]]. --~~~~',
	'content-review-rejection-explanation-title' => 'Przesłana modyfikacja skryptu $1 została odrzucona',
	'content-review-special-js-pages-title' => 'Strony JavaScript',
	'content-review-module-header-pagename' => 'Nazwa strony',
	'content-review-module-header-actions' => 'Działania',
	'content-review-module-jspages' => 'Wszystkie strony JS',
	'content-review-special-js-description' => 'Ta strona przedstawia aktualny [[w:pl:Pomoc:Proces przeglądu kodu JavaScript|status przeglądu]] skryptów w przestrzeni nazw MediaWiki na tej społeczności.',
	'content-review-special-js-importjs-description' => 'Uwaga: istnieje możliwość dodawania i usuwania skryptów importowanych lokalnie i z dev.fandom.com bez procesu przeglądu poprzez [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Tutaj z łatwością zaimportujesz skrypty:
* z tej wiki, podając nazwę artykułu (np. <code>MójSkrypt.js</code>);
* z [[w:c:dev|dev.fandom.com]], dodając „dev:” na początku nazwy artykułu (np. <code>dev:Code.js</code>).
Nazwy nie powinny zawierać przedrostka przestrzeni nazw MediaWiki. Każdy skrypt należy zapisywać w nowej linii. Zobacz [[w:pl:Pomoc:Importowanie CSS i JS|stronę pomocy]], aby uzyskać więcej informacji.
----
',
	'right-content-review' => 'Udostępnia narzędzia przeglądu treści',
	'right-content-review-test-mode' => 'Udostępnia środowisko testowe przeglądu treści',
	'group-content-reviewer' => 'Sprawdzający treść',
	'content-review-status-escalated' => 'Przekazana',
	'content-review-profile-tags-description' => 'Aby móc używać tej funkcji, musisz zaimportować [[w:c:dev:ProfileTags/pl|ProfileTags.js]] z dev.fandom.com. [[w:c:dev:ProfileTags/pl|Tutaj znajdziesz więcej informacji]].

Użyj tej strony, aby dostosować plakietki widoczne w profilach użytkowników. Oddziel nazwę użytkownika od plakietek za pomocą pionowej kreski („|”). Aby wyświetlić kilka plakietek, oddziel je przecinkami. Dodaj jednego użytkownika na linię.

Przykłady:
 PrzykładowyUżytkownik  | Rekrut, Nowy
 PrzykładowyUżytkownik2 | Guru
----
',
	'content-review-status-link-text' => 'Status przeglądu',
);

$messages['pt'] = array(
	'content-review-desc' => 'Esta extensão cria um processo no qual o JavaScript da comunidae é revisado manualmente antes do lançamento para os visitantes.',
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
	'content-review-module-help' => '[[w:c:pt.community:Ajuda:Personalização_de_CSS_e_JS|Ajuda]]',
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
A recente alteração enviada para esta página JavaScript (revisão [$2 $3]) foi rejeitada pelo processo de revisão do FANDOM. Por favor, certifique-se de estar seguindo [[w:c:pt.community:Ajuda:Processo_de_revisão_de_JavaScript|as diretrizes personalizadas JavaScript]]. --˜˜˜˜ ',
	'content-review-rejection-explanation-title' => 'A alteração do script $1 enviado foi rejeitada',
	'content-review-special-js-pages-title' => 'Páginas JavaScript',
	'content-review-module-header-pagename' => 'Título da página',
	'content-review-module-header-actions' => 'Ações',
	'content-review-module-jspages' => 'Todas as páginas JS',
	'content-review-special-js-description' => 'Esta página indica o atual [[w:c:pt.community:Ajuda:Processo de revisão de JavaScript|status de revisão]] dos scripts namespace MediaWiki nesta comunidade.',
	'content-review-special-js-importjs-description' => 'Nota: você pode adicionar e remover os scripts importados local e dev.wikia.com sem o processo de revisão em [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'Aqui, você pode importar scripts facilmente:
* da sua wiki local pelo nome do artigo - por exemplo, MyScript.js
* de dev.wikia.com pelo nome do artigo, precedido por "dev:"- por exemplo, dev:Code.js
Nomes não devem conter o prefixo de namespace MediaWiki. Escreva cada script em uma nova linha. Veja [[w:c:comunidade:Ajuda:Incluindo CSS e JS adicionais]] para obter mais informações.
----
',
	'right-content-review' => 'Permite o acesso a ferramentas de revisão de conteúdo',
	'right-content-review-test-mode' => 'Permite o acesso ao modo de teste de revisão de conteúdo',
	'group-content-reviewer' => 'Revisores de conteúdo',
	'content-review-status-escalated' => 'Escalado',
	'content-review-profile-tags-description' => 'Para usar este recurso, você deve importar [[w:c:dev:ProfileTags|ProfileTags.js]] da dev.wikia.com. [[w:c:dev:ProfileTags|Saiba mais]].

Use esta página para personalizar as etiquetas que aparecem nos perfis de usuário. Separe os nomes de usuários das etiquetas com a barra vertical (|). Para exibir várias etiquetas para um usuário, separe cada texto de etiqueta com vírgulas. Escreva o nome de cada usuário em uma nova linha.

 Exemplos:

 ExampleUsername | Estagiário, Novato
 ExampleUsername2 | Guru
',
	'content-review-status-link-text' => 'Status da revisão',
);

$messages['ru'] = array(
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
	'content-review-module-help' => '[[Справка:CSS и JS локальные|Справка]]',
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
Отправленные недавно изменения этой страницы (версия [$2 $3]) были отклонены после проверки кода. Проверьте, соответствует ли ваш код [[w:c:ru.community:Справка:Проверка JavaScript|политике ФЭНДОМА в отношении пользовательского JavaScript]]. --~~~~',
	'content-review-rejection-explanation-title' => 'Отправленная версия $1 была отклонена',
	'content-review-special-js-pages-title' => 'Страницы JavaScript',
	'content-review-module-header-pagename' => 'Название страницы',
	'content-review-module-header-actions' => 'Действия',
	'content-review-module-jspages' => 'Все страницы с JavaScript',
	'content-review-special-js-description' => 'На этой странице указан текущий [[Справка:Проверка JavaScript|статус проверки JS]] для всех страниц с общим JS на этой вики.',
	'content-review-special-js-importjs-description' => 'Примечание. Вы можете добавлять и удалять локальные скрипты без проверки с помощью страницы [[MediaWiki:ImportJS]].',
	'content-review-importjs-description' => 'С помощью этой страницы вы можете с лёгкостью добавлять скрипты: 
* с локального сообщества путём добавления названия страницы — например MyScript.js
* с dev.wikia.com при помощи добавления названия страницы с префиксом dev — например dev:Code.js
Названия не должны содержать префикс «MediaWiki». Указывайте название каждого отдельного скрипта новой строкой.
См. [[Справка:Включение дополнительных JS и CSS]] для получения дополнительной информации.
----
',
	'right-content-review' => 'Даёт доступ к инструментам проверки содержания',
	'right-content-review-test-mode' => 'Даёт доступ к тестовому режиму для проверки содержания',
	'group-content-reviewer' => 'Проверяющие содержание',
	'content-review-status-escalated' => 'Отправлено на проверку',
	'content-review-profile-tags-description' => 'Чтобы использовать эту функцию, необходимо импортировать [[w:c:dev:ProfileTags|ProfileTags.js]] из dev.wikia.com. [[w:c:dev:ProfileTags|Подробнее]].
На этой странице вы можете настроить теги, содержащиеся в профилях участников. Между именем участника и тегом используйте вертикальную линию (|). Чтобы добавить несколько тегов, разделите их запятыми. Каждое имя участника вводится с новой строки.

Примеры:

*ПримерИмяучастника | Ученик, Новичок
*ПримерИмяучастника | Специалист
',
	'content-review-status-link-text' => 'Статус проверки',
);

$messages['zh-hans'] = array(
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
	'content-review-module-help' => '[[Help:CSS and JS customization|帮助]]',
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
JavaScript页面最近提交的变更请求(版本[$2 $3]) 未通过FANDOM审核。请确保您的变更符合[[Help:JavaScript review process|JavaScript审核流程]]。--~~~~',
	'content-review-rejection-explanation-title' => '提交的脚本更改$1被拒绝',
	'content-review-special-js-pages-title' => 'JavaScript页面',
	'content-review-module-header-pagename' => '页面名称',
	'content-review-module-header-actions' => '操作',
	'content-review-module-jspages' => '所有的JS页面',
	'content-review-special-js-description' => '此页面列出这个社区当前Mediawiki命名空间脚本的[[Help:JavaScript review process|审核状态]]。',
	'content-review-special-js-importjs-description' => '注意：通过[[MediaWiki:ImportJS]]，您可以不需要经过审查流程就可以添加和删除来自本地以及dev.wikia.com的脚本导入。',
	'content-review-importjs-description' => '在这里，您可以通过以下途径轻松地导入脚本:
* 在您的本地社区通过文章名称进行导入 - 例如：MyScript.js 
* 从dev.wikia.com通过文章名称，前缀"dev:"进行导入 - 例如：dev:Code.js
名称不应包含MediaWiki命名空间前缀。请在新的一行上逐个输入脚本。请点击[[Help:Including additional CSS and JS|帮助页]]了解详细信息。
----',
	'right-content-review' => '允许访问内容审核工具',
	'right-content-review-test-mode' => '允许访问内容审核测试环境',
	'group-content-reviewer' => '内容审核者',
	'content-review-status-escalated' => '已送出审查',
	'content-review-profile-tags-description' => '若要使用此功能，您必须从dev.wikia.com导入[[w:c:dev:ProfileTags|ProfileTags.js]]。[[w:c:dev:ProfileTags|点击这里了解更多]]。

使用此页可以自定义出现在用户设定界面上的标签。使用"|"分隔用户名和标签。若要为用户显示多个标签，请用逗号分隔每个标签名称。您可以在新的一行上写每个用户名。     

例如: 
    
用户名例子 |见习，新手 
用户名例子2 | 大师
----',
	'content-review-status-link-text' => '审核状态',
);

$messages['zh-hant'] = array(
	'content-review-desc' => '此擴展功能讓社區的JavaScript在完全開放給使用者之前，先經過人工的審核。',
	'content-review-module-title' => '自訂JavaScript狀態',
	'content-review-module-header-latest' => '最新版本：',
	'content-review-module-header-last' => '上次審核版本：',
	'content-review-module-header-live' => '現在使用版本：',
	'content-review-module-status-none' => '無',
	'content-review-module-status-unsubmitted' => '需要提交',
	'content-review-module-status-live' => '已發佈！',
	'content-review-module-status-awaiting' => '正在等待審核',
	'content-review-module-status-approved' => '已通過審核',
	'content-review-module-status-rejected' => '未能通過',
	'content-review-rejection-reason-link' => '為什麼？',
	'content-review-module-help' => '[[w:c:zh.community:Help:CSS and JS customization|幫助]]',
	'content-review-module-help-article' => 'Help:CSS and JS customization',
	'content-review-module-help-text' => '幫助',
	'content-review-module-submit' => '送出審核',
	'content-review-module-submit-success' => '所做的更改已成功提交供審核。',
	'content-review-module-submit-exception' => '很抱歉，由於以下錯誤，我們無法送出更改的審核請求: $1。',
	'content-review-module-submit-error' => '很抱歉，我們無法送出更改的審查請求。',
	'content-review-module-test-mode-enable' => '進入測試模式',
	'content-review-module-test-mode-disable' => '離開測試模式',
	'content-review-test-mode-error' => '出錯了。請稍後再試。',
	'content-review-test-mode-enabled' => '您目前使用自訂JavaScript的未審核版本。',
	'action-content-review' => '內容審核',
	'content-review-restore-summary' => '回退頁面到版本$1',
	'content-review-status-unreviewed' => '未審核',
	'content-review-status-in-review' => '審核中',
	'content-review-status-approved' => '已通過',
	'content-review-status-rejected' => '未通過',
	'content-review-status-live' => '已發佈',
	'content-review-status-autoapproved' => '已自動批准',
	'content-review-rejection-explanation' => '==$1==
JavaScript頁最近提交的變更請求(版本[$2 $3]) 未通過FANDOM的審核。 請確保您的變更符合[[Help:JavaScript review process|JavaScript審核規則]]。 --~~~~',
	'content-review-rejection-explanation-title' => '提交的腳本更改$1未能通過',
	'content-review-special-js-pages-title' => 'JavaScript頁面',
	'content-review-module-header-pagename' => '頁面名稱',
	'content-review-module-header-actions' => '操作',
	'content-review-module-jspages' => '所有的JS頁面',
	'content-review-special-js-description' => '此頁面列出這個社區當前Mediawiki命名空間腳本的[[w:c:zh.community:Help:JavaScript review process|審核狀態]]。',
	'content-review-special-js-importjs-description' => '注意：通過使用[[MediaWiki:ImportJS]]，您可以不需要通過審查流程就可以添加和刪除來自Wiki內以及dev.wikia.com的腳本導入。',
	'content-review-importjs-description' => '在這裡，您可以通過以下途徑輕鬆地導入腳本：
* 從您的Wiki社區通過文章名稱進行導入 - 例如：MyScript.js
* 從dev.wikia.com通過文章名稱，加上前綴"dev:"進行導入 - 例如：dev:Code.js
名稱不應包含MediaWiki命名空間。請在新的一行上輸入不同的腳本。請進入[[Help:Including additional CSS and JS|幫助頁]]參閱詳細資訊。
----',
	'right-content-review' => '允許訪問內容審核工具',
	'right-content-review-test-mode' => '允許訪問內容審核測試模式狀態',
	'group-content-reviewer' => '內容審核者',
	'content-review-status-escalated' => '已送出審查',
	'content-review-profile-tags-description' => '若要使用此功能，您必須從dev.wikia.com導入[[w:c:dev:ProfileTags|ProfileTags.js]]。[[w:c:dev:ProfileTags|按這裡瞭解更多]]。

使用此頁可以自訂出現在使用者頁面的標籤。使用 | 來分隔使用者名和標籤。若要為使用者顯示多個標籤，請用逗號分隔每個標籤名稱。請在新的一行上來寫每個使用者名稱。

例如:

使用者名稱例子 |見習，新手
使用者名稱例子2 | 大師
----',
	'content-review-status-link-text' => '審核狀態',
);

