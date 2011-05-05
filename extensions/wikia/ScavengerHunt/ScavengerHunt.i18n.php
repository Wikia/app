<?php
/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

$messages = array();

$messages['en'] = array(
	'scavengerhunt-desc' => 'Alows creation a scavenger hunt game on a wiki',
	'scavengerhunt' => 'Scavenger hunt interface',

	'scavengerhunt-list-header-name' => 'Game name',
	'scavengerhunt-list-header-is-enabled' => 'Enabled?',
	'scavengerhunt-list-header-actions' => 'Actions',
	'scavengerhunt-list-enabled' => 'Enabled',
	'scavengerhunt-list-disabled' => 'Disabled',
	'scavengerhunt-list-edit' => 'edit',

	'scavengerhunt-label-dialog-check' => '(show dialog)',
	'scavengerhunt-label-image-check' => '(show image)',
	'scavengerhunt-label-general' => 'General',
	'scavengerhunt-label-name' => 'Name:',
	'scavengerhunt-label-landing-title' => 'Landing page name (article title on this wiki):',
	'scavengerhunt-label-landing-button-text' => 'Landing page button text:',

	'scavengerhunt-label-starting-clue' => 'Starting Clue popup',
	'scavengerhunt-label-starting-clue-title' => 'Popup title:',
	'scavengerhunt-label-starting-clue-text' => 'Popup text: <i>(text in &lt;div&gt; will have link color)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Popup image (URL address):',
	'scavengerhunt-label-starting-clue-button-text' => 'Popup button text:',
	'scavengerhunt-label-starting-clue-button-target' => 'Popup button target (URL address):',

	'scavengerhunt-label-article' => 'In-game page',
	'scavengerhunt-label-article-title' => 'Page title (article title on this wiki):',
	'scavengerhunt-label-article-hidden-image' => 'Hidden image:',
	'scavengerhunt-label-article-clue-title' => 'Clue popup title:',
	'scavengerhunt-label-article-clue-text' => 'Clue popup text:',
	'scavengerhunt-label-article-clue-image' => 'Clue popup image (URL address):',
	'scavengerhunt-label-article-clue-button-text' => 'Clue popup button text:',
	'scavengerhunt-label-article-clue-button-target' => 'Clue popup button target (URL address):',

	'scavengerhunt-label-entry-form' => 'Entry form',
	'scavengerhunt-label-entry-form-title' => 'Popup title:',
	'scavengerhunt-label-entry-form-text' => 'Popup text:',
	'scavengerhunt-label-entry-form-image' => 'Popup image (URL address):',
	'scavengerhunt-label-entry-form-question' => 'Popup question:',

	'scavengerhunt-label-goodbye' => 'Goodbye popup',
	'scavengerhunt-label-goodbye-title' => 'Popup title:',
	'scavengerhunt-label-goodbye-text' => 'Popup message:',
	'scavengerhunt-label-goodbye-image' => 'Popup image (URL address):',

	'scavengerhunt-button-add' => 'Add a game',
	'scavengerhunt-button-save' => 'Save',
	'scavengerhunt-button-disable' => 'Disable',
	'scavengerhunt-button-enable' => 'Enable',
	'scavengerhunt-button-delete' => 'Delete',
	'scavengerhunt-button-export' => 'Export to CSV',

	'scavengerhunt-form-error' => 'Please correct the following errors:',
	'scavengerhunt-form-error-name' => '',
	'scavengerhunt-form-error-no-landing-title' => 'Please enter the starting page title.',
	'scavengerhunt-form-error-invalid-title' => 'The following page title was not found: "$1".',
	'scavengerhunt-form-error-landing-button-text' => 'Please enter the starting button text.',
	'scavengerhunt-form-error-starting-clue' => 'Please fill in all fields in the starting clue section.',
	'scavengerhunt-form-error-entry-form' => 'Please fill in all fields in the entry form section.',
	'scavengerhunt-form-error-goodbye' => 'Please fill in all fields in goodbye popup section.',
	'scavengerhunt-form-error-no-article-title' => 'Please enter all article titles.',
	'scavengerhunt-form-error-article-hidden-image' => 'Please enter all addresses for hidden images.',
	'scavengerhunt-form-error-article-clue' => 'Please fill in all information about article clues.',

	'scavengerhunt-game-has-been-created' => 'New Scavenger Hunt game has been created.',
	'scavengerhunt-game-has-been-saved' => 'Scavenger Hunt game has been saved.',
	'scavengerhunt-game-has-been-enabled' => 'Selected Scavenger Hunt game has been enabled.',
	'scavengerhunt-game-has-been-disabled' => 'Selected Scavenger Hunt game has been disabled.',
	'scavengerhunt-game-has-not-been-saved' => 'Scavenger Hunt game has not been saved.',

	'scavengerhunt-edit-token-mismatch' => 'Edit token mismatch - please try again.',

	'scavengerhunt-entry-form-name' => 'Your name:',
	'scavengerhunt-entry-form-email' => 'Your e-mail address:',
	'scavengerhunt-entry-form-submit' => 'Submit entry',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'scavengerhunt-desc' => '{{desc}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'scavengerhunt-button-save' => 'Stoor',
	'scavengerhunt-button-disable' => 'Afskakel',
	'scavengerhunt-button-enable' => 'Aanskakel',
	'scavengerhunt-button-delete' => 'Verwyder',
	'scavengerhunt-button-export' => 'Uitvoer na CSV',
	'scavengerhunt-entry-form-name' => 'U naam:',
	'scavengerhunt-entry-form-email' => 'U e-posadres:',
	'scavengerhunt-entry-form-submit' => 'Stuur inskrywing',
);

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = array(
	'scavengerhunt-list-edit' => 'عدل',
	'scavengerhunt-label-name' => 'الاسم:',
	'scavengerhunt-entry-form-name' => 'اسمك:',
	'scavengerhunt-entry-form-email' => 'عنوان بريدك الإلكتروني:',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'scavengerhunt-list-edit' => 'redaktə',
	'scavengerhunt-label-name' => 'Ad:',
	'scavengerhunt-button-save' => 'Qeyd et',
	'scavengerhunt-button-delete' => 'Sil',
	'scavengerhunt-entry-form-name' => 'Sizin adınız:',
	'scavengerhunt-entry-form-email' => 'Sizin e-poçt ünvanınız:',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'scavengerhunt-list-header-actions' => 'Действия',
	'scavengerhunt-label-name' => 'Име:',
	'scavengerhunt-button-save' => 'Съхраняване',
	'scavengerhunt-button-delete' => 'Изтриване',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'scavengerhunt-list-header-name' => "Anv ar c'hoari",
	'scavengerhunt-list-header-is-enabled' => 'Gweredekaet ?',
	'scavengerhunt-list-header-actions' => 'Oberoù',
	'scavengerhunt-list-enabled' => 'Gweredekaet',
	'scavengerhunt-list-disabled' => 'Diweredekaet',
	'scavengerhunt-list-edit' => 'kemmañ',
	'scavengerhunt-label-general' => 'Hollek',
	'scavengerhunt-label-name' => 'Anv :',
	'scavengerhunt-label-article-title' => 'Titl ar bajenn :',
	'scavengerhunt-label-article-hidden-image' => 'Skeudenn kuzhet :',
	'scavengerhunt-button-add' => "Ouzhpennañ ur c'hoari",
	'scavengerhunt-button-save' => 'Enrollañ',
	'scavengerhunt-button-disable' => 'Diweredekaat',
	'scavengerhunt-button-enable' => 'Gweredekaat',
	'scavengerhunt-button-delete' => 'Dilemel',
	'scavengerhunt-entry-form-name' => "Hoc'h anv :",
	'scavengerhunt-entry-form-email' => "Ho chomlec'h postel :",
);

/** German (Deutsch)
 * @author George Animal
 * @author LWChris
 */
$messages['de'] = array(
	'scavengerhunt-desc' => 'Ermöglicht das Erstellen einer Schnitzeljagd in einem Wiki',
	'scavengerhunt' => 'Schnitzeljagd Schnittstelle',
	'scavengerhunt-list-header-name' => 'Spielname',
	'scavengerhunt-list-header-is-enabled' => 'Aktiviert?',
	'scavengerhunt-list-header-actions' => 'Aktionen',
	'scavengerhunt-list-enabled' => 'Aktiviert',
	'scavengerhunt-list-disabled' => 'Deaktiviert',
	'scavengerhunt-list-edit' => 'bearbeiten',
	'scavengerhunt-label-dialog-check' => '(Dialog anzeigen)',
	'scavengerhunt-label-image-check' => '(Bild anzeigen)',
	'scavengerhunt-label-general' => 'Allgemein',
	'scavengerhunt-label-name' => 'Name:',
	'scavengerhunt-label-landing-title' => 'Name der Zielseite (Titel des Artikels in diesem Wiki):',
	'scavengerhunt-label-landing-button-text' => 'Schaltflächentext der Zielseite:',
	'scavengerhunt-label-starting-clue' => 'Start-Hinweispopup',
	'scavengerhunt-label-starting-clue-title' => 'Popup Titel:',
	'scavengerhunt-label-starting-clue-text' => 'Popup Text: <i>(Text in &lt;div&gt; wird Linkfarbe haben)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Popup Bild (URL-Adresse):',
	'scavengerhunt-label-starting-clue-button-text' => 'Popup-Schaltflächentext:',
	'scavengerhunt-label-starting-clue-button-target' => 'Popup-Schaltflächenziel (URL-Adresse):',
	'scavengerhunt-label-article' => 'In-Game Seite',
	'scavengerhunt-label-article-title' => 'Seitentitel (Titel des Artikels in diesem Wiki):',
	'scavengerhunt-label-article-hidden-image' => 'Verstecktes Bild:',
	'scavengerhunt-label-article-clue-title' => 'Hinweispopup Titel:',
	'scavengerhunt-label-article-clue-text' => 'Hinweispopup-Text:',
	'scavengerhunt-label-article-clue-image' => 'Hinweispopup-Bild (URL-Adresse):',
	'scavengerhunt-label-article-clue-button-text' => 'Hinweispopup-Schaltflächentext:',
	'scavengerhunt-label-article-clue-button-target' => 'Hinweispopup-Schaltflächenziel (URL-Adresse):',
	'scavengerhunt-label-entry-form' => 'Eingabeformular',
	'scavengerhunt-label-entry-form-title' => 'Popup Titel:',
	'scavengerhunt-label-entry-form-text' => 'Popup Text:',
	'scavengerhunt-label-entry-form-image' => 'Popup Bild (URL-Adresse):',
	'scavengerhunt-label-entry-form-question' => 'Popup Frage:',
	'scavengerhunt-label-goodbye' => 'Goodbye Popup',
	'scavengerhunt-label-goodbye-title' => 'Popup Titel:',
	'scavengerhunt-label-goodbye-text' => 'Popup-Meldung:',
	'scavengerhunt-label-goodbye-image' => 'Popup Bild (URL-Adresse):',
	'scavengerhunt-button-add' => 'Ein Spiel hinzufügen',
	'scavengerhunt-button-save' => 'Speichern',
	'scavengerhunt-button-disable' => 'Deaktivieren',
	'scavengerhunt-button-enable' => 'Aktivieren',
	'scavengerhunt-button-delete' => 'Löschen',
	'scavengerhunt-button-export' => 'Nach CSV exportieren',
	'scavengerhunt-form-error' => 'Bitte korrigiere die folgenden Fehler:',
	'scavengerhunt-form-error-no-landing-title' => 'Bitte gib den Titel der Startseite ein.',
	'scavengerhunt-form-error-invalid-title' => 'Die folgende Seite wurde nicht gefunden: "$1".',
	'scavengerhunt-form-error-landing-button-text' => 'Bitte gib den Start-Schaltflächentext ein.',
	'scavengerhunt-form-error-starting-clue' => 'Bitte fülle alle Felder im Abschnitt Start-Hinweis aus.',
	'scavengerhunt-form-error-entry-form' => 'Bitte fülle alle Felder im Abschnitt Eingabeformular aus.',
	'scavengerhunt-form-error-goodbye' => 'Bitte fülle alle Felder im Abschnitt Goodbye-Popup aus.',
	'scavengerhunt-form-error-no-article-title' => 'Bitte gib alle Artikelnamen ein.',
	'scavengerhunt-form-error-article-hidden-image' => 'Bitte gib alle Adressen von versteckten Bildern ein.',
	'scavengerhunt-form-error-article-clue' => 'Bitte gib alle Informationen über Artikel-Hinweise ein.',
	'scavengerhunt-game-has-been-created' => 'Neues Schnitzeljagd Spiel wurde erstellt.',
	'scavengerhunt-game-has-been-saved' => 'Schnitzeljagd Spiel wurde gespeichert.',
	'scavengerhunt-game-has-been-enabled' => 'Ausgewähltes Schnitzeljagd Spiel wurde aktiviert.',
	'scavengerhunt-game-has-been-disabled' => 'Ausgewähltes Schnitzeljagd Spiel wurde deaktiviert.',
	'scavengerhunt-game-has-not-been-saved' => 'Schnitzeljagd Spiel wurde nicht gespeichert.',
	'scavengerhunt-edit-token-mismatch' => 'Bearbeitungstoken passt nicht - bitte versuche es erneut.',
	'scavengerhunt-entry-form-name' => 'Dein Name:',
	'scavengerhunt-entry-form-email' => 'Deine E-Mail-Adresse:',
	'scavengerhunt-entry-form-submit' => 'Eingabe absenden',
);

/** Spanish (Español)
 * @author Od1n
 * @author VegaDark
 */
$messages['es'] = array(
	'scavengerhunt-desc' => 'Permite crear un juego de búsqueda en un wiki',
	'scavengerhunt-list-header-name' => 'Nombre del juego',
	'scavengerhunt-list-header-is-enabled' => '¿Habilitado?',
	'scavengerhunt-list-header-actions' => 'Acciones',
	'scavengerhunt-list-enabled' => 'Habilitado',
	'scavengerhunt-list-disabled' => 'Deshabilitado',
	'scavengerhunt-list-edit' => 'editar',
	'scavengerhunt-label-dialog-check' => '(mostrar diálogo)',
	'scavengerhunt-label-image-check' => '(mostrar imagen)',
	'scavengerhunt-label-general' => 'General',
	'scavengerhunt-label-name' => 'Nombre:',
	'scavengerhunt-label-landing-title' => 'Nombre de la página de inicio (título de artículo en este wiki):',
	'scavengerhunt-label-landing-button-text' => 'Texto del botón de la página de inicio:',
	'scavengerhunt-label-starting-clue' => 'Comenzar pista emergente',
	'scavengerhunt-label-starting-clue-title' => 'Título emergente:',
	'scavengerhunt-button-save' => 'Guardar',
	'scavengerhunt-button-delete' => 'Borrar',
	'scavengerhunt-button-export' => 'Exportar a CSV',
	'scavengerhunt-entry-form-name' => 'Tu nombre:',
	'scavengerhunt-entry-form-email' => 'Tu dirección de correo electrónico:',
);

/** Finnish (Suomi)
 * @author Tofu II
 */
$messages['fi'] = array(
	'scavengerhunt-label-image-check' => '(näytä kuva)',
);

/** French (Français)
 * @author Brunoperel
 * @author Iketsi
 * @author Od1n
 */
$messages['fr'] = array(
	'scavengerhunt-list-header-name' => 'Nom de la partie',
	'scavengerhunt-list-header-is-enabled' => 'Activé?',
	'scavengerhunt-list-header-actions' => 'Actions',
	'scavengerhunt-list-enabled' => 'Activé',
	'scavengerhunt-list-disabled' => 'Désactivé',
	'scavengerhunt-list-edit' => 'modifier',
	'scavengerhunt-label-dialog-check' => '(afficher la boîte de dialogue)',
	'scavengerhunt-label-image-check' => "(voir l'image)",
	'scavengerhunt-label-general' => 'Général',
	'scavengerhunt-label-name' => 'Nom :',
	'scavengerhunt-label-starting-clue-title' => 'Titre du popup :',
	'scavengerhunt-label-starting-clue-button-text' => 'Texte du bouton du popup :',
	'scavengerhunt-label-article-title' => "Titre de la page (titre de l'article sur ce wiki):",
	'scavengerhunt-label-article-hidden-image' => 'Image cachée:',
	'scavengerhunt-label-article-clue-title' => 'Titre du popup d’indice :',
	'scavengerhunt-label-article-clue-text' => 'Texte du popup d’indice :',
	'scavengerhunt-label-article-clue-button-text' => 'Texte du bouton du popup d’indice :',
	'scavengerhunt-label-entry-form-title' => 'Titre du popup :',
	'scavengerhunt-label-entry-form-text' => 'Texte du popup :',
	'scavengerhunt-label-entry-form-image' => 'Image de popup (adresse URL) :',
	'scavengerhunt-label-entry-form-question' => 'Question du popup :',
	'scavengerhunt-label-goodbye' => 'Popup d’au revoir',
	'scavengerhunt-label-goodbye-title' => 'Titre du popup :',
	'scavengerhunt-label-goodbye-text' => 'Message de popup:',
	'scavengerhunt-button-add' => 'Ajouter une partie',
	'scavengerhunt-button-save' => 'Enregistrer',
	'scavengerhunt-button-disable' => 'Désactiver',
	'scavengerhunt-button-enable' => 'Activer',
	'scavengerhunt-button-delete' => 'Supprimer',
	'scavengerhunt-button-export' => 'Exporter en CSV',
	'scavengerhunt-form-error' => 'Veuillez corriger les erreurs suivantes :',
	'scavengerhunt-form-error-no-landing-title' => 'Veuillez entrer le titre de la page de départ.',
	'scavengerhunt-form-error-no-article-title' => 'Veuillez entrer tous les titres d’articles.',
	'scavengerhunt-form-error-article-hidden-image' => 'Veuillez entrer toutes les adresses des images cachées.',
	'scavengerhunt-entry-form-name' => 'Votre nom :',
	'scavengerhunt-entry-form-email' => 'Votre adresse de courriel :',
	'scavengerhunt-entry-form-submit' => 'Soumettre l’entrée',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'scavengerhunt-list-header-name' => 'Játék neve',
	'scavengerhunt-list-header-actions' => 'Műveletek',
	'scavengerhunt-list-enabled' => 'Engedélyezve',
	'scavengerhunt-list-disabled' => 'Letiltva',
	'scavengerhunt-list-edit' => 'szerkesztés',
	'scavengerhunt-label-dialog-check' => '(párbeszédablak megjelenítése)',
	'scavengerhunt-label-image-check' => '(kép megjelenítése)',
	'scavengerhunt-label-general' => 'Általános',
	'scavengerhunt-label-name' => 'Név:',
	'scavengerhunt-button-add' => 'Játék hozzáadása',
	'scavengerhunt-button-save' => 'Mentés',
	'scavengerhunt-button-disable' => 'Letiltás',
	'scavengerhunt-button-enable' => 'Engedélyezés',
	'scavengerhunt-button-delete' => 'Törlés',
	'scavengerhunt-button-export' => 'Kimentés CSV-be',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'scavengerhunt-desc' => 'Permitte le creation de un joco de chassa al tresor in un wiki',
	'scavengerhunt' => 'Interfacie de chassa al tresor',
	'scavengerhunt-list-header-name' => 'Nomine del joco',
	'scavengerhunt-list-header-is-enabled' => 'Activate?',
	'scavengerhunt-list-header-actions' => 'Actiones',
	'scavengerhunt-list-enabled' => 'Activate',
	'scavengerhunt-list-disabled' => 'Disactivate',
	'scavengerhunt-list-edit' => 'modificar',
	'scavengerhunt-label-dialog-check' => '(monstrar dialogo)',
	'scavengerhunt-label-image-check' => '(monstrar imagine)',
	'scavengerhunt-label-general' => 'General',
	'scavengerhunt-label-name' => 'Nomine:',
	'scavengerhunt-label-landing-title' => 'Nomine del pagina de arrivata (le titulo del articulo in iste wiki):',
	'scavengerhunt-label-landing-button-text' => 'Texto del button pro le pagina de arrivata:',
	'scavengerhunt-label-starting-clue' => 'Pop-up pro le prime indicio',
	'scavengerhunt-label-starting-clue-title' => 'Titulo del pop-up:',
	'scavengerhunt-label-starting-clue-text' => 'Texto del pop-up: <i>(texto inter &lt;div&gt; habera le color de un ligamine)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Imagine del pop-up (adresse URL):',
	'scavengerhunt-label-starting-clue-button-text' => 'Texto del button del pop-up:',
	'scavengerhunt-label-starting-clue-button-target' => 'Destination del button del pop-up (adresse URL):',
	'scavengerhunt-label-article' => 'Pagina in joco',
	'scavengerhunt-label-article-title' => 'Titulo del pagina (titulo del articulo in iste wiki):',
	'scavengerhunt-label-article-hidden-image' => 'Imagine celate:',
	'scavengerhunt-label-article-clue-title' => 'Titulo del pop-up de indicio:',
	'scavengerhunt-label-article-clue-text' => 'Texto del pop-up de indicio:',
	'scavengerhunt-label-article-clue-image' => 'Imagine del pop-up de indicio (adresse URL):',
	'scavengerhunt-label-article-clue-button-text' => 'Texto del button de pop-up de indicio:',
	'scavengerhunt-label-article-clue-button-target' => 'Destination del button del pop-up de indicio (adresse URL):',
	'scavengerhunt-label-entry-form' => 'Formulario de entrata',
	'scavengerhunt-label-entry-form-title' => 'Titulo del pop-up:',
	'scavengerhunt-label-entry-form-text' => 'Texto del pop-up:',
	'scavengerhunt-label-entry-form-image' => 'Imagine del pop-up (adresse URL):',
	'scavengerhunt-label-entry-form-question' => 'Question del pop-up:',
	'scavengerhunt-label-goodbye' => 'Pop-up de adeo',
	'scavengerhunt-label-goodbye-title' => 'Titulo del pop-up:',
	'scavengerhunt-label-goodbye-text' => 'Message del pop-up:',
	'scavengerhunt-label-goodbye-image' => 'Imagine del pop-up (adresse URL):',
	'scavengerhunt-button-add' => 'Adder un joco',
	'scavengerhunt-button-save' => 'Salveguardar',
	'scavengerhunt-button-disable' => 'Disactivar',
	'scavengerhunt-button-enable' => 'Activar',
	'scavengerhunt-button-delete' => 'Deler',
	'scavengerhunt-button-export' => 'Exportar a CSV',
	'scavengerhunt-form-error' => 'Per favor corrige le sequente errores:',
	'scavengerhunt-form-error-no-landing-title' => 'Per favor entra le titulo del pagina de initio.',
	'scavengerhunt-form-error-invalid-title' => 'Le titulo del pagina sequente non esseva trovate: "$1".',
	'scavengerhunt-form-error-landing-button-text' => 'Per favor entra le texto del button de initio.',
	'scavengerhunt-form-error-starting-clue' => 'Per favor completa tote le campos in le section del indicio initial.',
	'scavengerhunt-form-error-entry-form' => 'Per favor completa tote le campos in le section del formulario de entrata.',
	'scavengerhunt-form-error-goodbye' => 'Per favor completa tote le campos in le section del pop-up de adeo.',
	'scavengerhunt-form-error-no-article-title' => 'Per favor entra tote le titulos del articulos.',
	'scavengerhunt-form-error-article-hidden-image' => 'Per favor entra tote le adresses pro imagines celate.',
	'scavengerhunt-form-error-article-clue' => 'Per favor entra tote le informationes pro indicios de articulos.',
	'scavengerhunt-game-has-been-created' => 'Un nove joco de chassa al tresor ha essite create.',
	'scavengerhunt-game-has-been-saved' => 'Le joco de chassa al tresor ha essite salveguardate.',
	'scavengerhunt-game-has-been-enabled' => 'Le joco seligite de chassa al tresor ha essite activate.',
	'scavengerhunt-game-has-been-disabled' => 'Le joco seligite de chassa al tresor ha essite disactivate.',
	'scavengerhunt-game-has-not-been-saved' => 'Le joco de chassa al tresor non ha essite salveguardate.',
	'scavengerhunt-edit-token-mismatch' => 'Non-correspondentia del indicio de modification - per favor reproba.',
	'scavengerhunt-entry-form-name' => 'Tu nomine:',
	'scavengerhunt-entry-form-email' => 'Tu adresse de e-mail:',
	'scavengerhunt-entry-form-submit' => 'Submitter entrata',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'scavengerhunt-list-header-name' => 'Navê lîstikê',
	'scavengerhunt-list-edit' => 'biguherîne',
	'scavengerhunt-label-name' => 'Nav:',
	'scavengerhunt-button-save' => 'Qeyd bike',
	'scavengerhunt-button-delete' => 'Jê bibe',
	'scavengerhunt-entry-form-name' => 'Navê te:',
	'scavengerhunt-entry-form-submit' => 'Gotarê qeyd bike',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'scavengerhunt-label-name' => 'Numm:',
	'scavengerhunt-button-save' => 'Späicheren',
	'scavengerhunt-button-delete' => 'Läschen',
	'scavengerhunt-entry-form-name' => 'Ären Numm:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'scavengerhunt-desc' => 'Овозможува создавање на игра „Потрага“ на вики',
	'scavengerhunt' => 'Посредник за „Потрага“',
	'scavengerhunt-list-header-name' => 'Име на играта',
	'scavengerhunt-list-header-is-enabled' => 'Овозможено?',
	'scavengerhunt-list-header-actions' => 'Дејства',
	'scavengerhunt-list-enabled' => 'Овозможено',
	'scavengerhunt-list-disabled' => 'Оневозможено',
	'scavengerhunt-list-edit' => 'уреди',
	'scavengerhunt-label-dialog-check' => '(прикажи дијалог)',
	'scavengerhunt-label-image-check' => '(прикажи слика)',
	'scavengerhunt-label-general' => 'Општо',
	'scavengerhunt-label-name' => 'Име:',
	'scavengerhunt-label-landing-title' => 'Име на целната страница (наслов на статија на ова вики):',
	'scavengerhunt-label-landing-button-text' => 'Текст на копчето на целната страница:',
	'scavengerhunt-label-starting-clue' => 'Скокачки прозорец за потсетки при почнување:',
	'scavengerhunt-label-starting-clue-title' => 'Наслов на скокачкиот прозорец:',
	'scavengerhunt-label-starting-clue-text' => 'Текст на скокачкиот прозорец: <i>(текстот во &lt;div&gt; ќе ја има бојата на врските)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Слика за скокачкиот прозорец (URL-адреса):',
	'scavengerhunt-label-starting-clue-button-text' => 'Текст на копчето на скокачкиот прозорец:',
	'scavengerhunt-label-starting-clue-button-target' => 'Одредница на копчето на скокачкиот процорец (URL-адреса):',
	'scavengerhunt-label-article' => 'Страница во текот на играта',
	'scavengerhunt-label-article-title' => 'Наслов на страницата (наслов на статија на ова вики):',
	'scavengerhunt-label-article-hidden-image' => 'Скриена слика:',
	'scavengerhunt-label-article-clue-title' => 'Наслов на скокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-text' => 'Текст на скокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-image' => 'Слика на скокачкиот прозорец за потсетка (URL-адреса):',
	'scavengerhunt-label-article-clue-button-text' => 'Текст на копчето на сокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-button-target' => 'Одредница на копчето на скокачкиот прозорец за потсетка (URL-адреса):',
	'scavengerhunt-label-entry-form' => 'Пријава',
	'scavengerhunt-label-entry-form-title' => 'Наслов на скокачкиот прозорец:',
	'scavengerhunt-label-entry-form-text' => 'Текст на скокачкиот прозорец:',
	'scavengerhunt-label-entry-form-image' => 'Слика за скокачкиот прозорец (URL-адреса):',
	'scavengerhunt-label-entry-form-question' => 'Прашање за скокачкиот прозорец:',
	'scavengerhunt-label-goodbye' => 'Скокачки прозорец за догледање',
	'scavengerhunt-label-goodbye-title' => 'Наслов на скокачкиот прозорец:',
	'scavengerhunt-label-goodbye-text' => 'Порака на скокачкиот прозорец:',
	'scavengerhunt-label-goodbye-image' => 'Слика за скокачкиот прозорец (URL-адреса):',
	'scavengerhunt-button-add' => 'Додај игра',
	'scavengerhunt-button-save' => 'Зачувај',
	'scavengerhunt-button-disable' => 'Оневозможи',
	'scavengerhunt-button-enable' => 'Овозможи',
	'scavengerhunt-button-delete' => 'Избриши',
	'scavengerhunt-button-export' => 'Извези во CSV',
	'scavengerhunt-form-error' => 'Исправете ги следниве грешки:',
	'scavengerhunt-form-error-no-landing-title' => 'Внесете го насловот на почетната страница',
	'scavengerhunt-form-error-invalid-title' => 'Следнава страница не е најдена: „$1“.',
	'scavengerhunt-form-error-landing-button-text' => 'Внесете текст за почетното копче.',
	'scavengerhunt-form-error-starting-clue' => 'Пополнете ги сите полиња во делот за почетната потсетка.',
	'scavengerhunt-form-error-entry-form' => 'Пополнете ги сите полиња во делот за пријавницата.',
	'scavengerhunt-form-error-goodbye' => 'Пополнете ги сите полиња во делот на за скокачкиот прозорец за догледање.',
	'scavengerhunt-form-error-no-article-title' => 'Пополнете ги сите наслови на статиите.',
	'scavengerhunt-form-error-article-hidden-image' => 'Внесете ги сите адреси на скриените слики.',
	'scavengerhunt-form-error-article-clue' => 'Пополнете ги сите информации за потсетките за статиите.',
	'scavengerhunt-game-has-been-created' => 'Создадена е нова игра „Потрага“.',
	'scavengerhunt-game-has-been-saved' => 'Оваа „Потрага“ е зачувана.',
	'scavengerhunt-game-has-been-enabled' => 'Одбраната „Потрага“ е овозможена.',
	'scavengerhunt-game-has-been-disabled' => 'Одбраната „Потрага“ е оневозможена.',
	'scavengerhunt-game-has-not-been-saved' => 'Оваа „Потрага“ не е зачувана.',
	'scavengerhunt-edit-token-mismatch' => 'Несовпаѓање во жетонот на уредувањето - обидете се повторно',
	'scavengerhunt-entry-form-name' => 'Вашето име:',
	'scavengerhunt-entry-form-email' => 'Ваша е-пошта:',
	'scavengerhunt-entry-form-submit' => 'Поднеси',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'scavengerhunt-list-header-name' => 'Nama permainan',
	'scavengerhunt-list-header-is-enabled' => 'Dihidupkan?',
	'scavengerhunt-list-header-actions' => 'Tindakan',
	'scavengerhunt-list-enabled' => 'Dihidupkan',
	'scavengerhunt-list-disabled' => 'Dimatikan',
	'scavengerhunt-list-edit' => 'sunting',
	'scavengerhunt-label-dialog-check' => '(tunjukkan dialog)',
	'scavengerhunt-label-image-check' => '(tunjukkan imej)',
	'scavengerhunt-label-general' => 'Umum',
	'scavengerhunt-label-name' => 'Nama:',
	'scavengerhunt-label-starting-clue-title' => 'Tajuk tetimbul:',
	'scavengerhunt-label-article-title' => 'Tajuk laman (tajuk rencana di wiki ini):',
	'scavengerhunt-label-article-hidden-image' => 'Imej tersembunyi:',
	'scavengerhunt-label-entry-form' => 'Borang penyertaan',
	'scavengerhunt-label-entry-form-title' => 'Tajuk tetimbul:',
	'scavengerhunt-label-entry-form-text' => 'Teks tetimbul:',
	'scavengerhunt-label-goodbye-title' => 'Tajuk tetimbul:',
	'scavengerhunt-label-goodbye-text' => 'Pesanan tetimbul:',
	'scavengerhunt-label-goodbye-image' => 'Imej tetimbil (alamat URL):',
	'scavengerhunt-button-add' => 'Tambahkan permainan',
	'scavengerhunt-button-save' => 'Simpan',
	'scavengerhunt-button-disable' => 'Matikan',
	'scavengerhunt-button-enable' => 'Hidupkan',
	'scavengerhunt-button-delete' => 'Hapuskan',
	'scavengerhunt-button-export' => 'Eksport ke CSV',
	'scavengerhunt-form-error-no-article-title' => 'Sila isikan semua tajuk rencana.',
	'scavengerhunt-entry-form-name' => 'Nama anda:',
	'scavengerhunt-entry-form-email' => 'Alamat e-mel anda:',
	'scavengerhunt-entry-form-submit' => 'Hantar penyertaan',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'scavengerhunt-desc' => 'Maakt het mogelijk een speurtocht uit te zetten in een wiki',
	'scavengerhunt' => 'Speurtochtinterface',
	'scavengerhunt-list-header-name' => 'Spelnaam',
	'scavengerhunt-list-header-is-enabled' => 'Ingeschakeld?',
	'scavengerhunt-list-header-actions' => 'Handelingen',
	'scavengerhunt-list-enabled' => 'Ingeschakeld',
	'scavengerhunt-list-disabled' => 'Uitgeschakeld',
	'scavengerhunt-list-edit' => 'bewerken',
	'scavengerhunt-label-dialog-check' => '(dialoog weergeven)',
	'scavengerhunt-label-image-check' => '(afbeelding weergeven)',
	'scavengerhunt-label-general' => 'Algemeen',
	'scavengerhunt-label-name' => 'Naam:',
	'scavengerhunt-label-landing-title' => 'Landingspagina (paginanaam in deze wiki):',
	'scavengerhunt-label-landing-button-text' => 'Knoptekst voor landingspagina:',
	'scavengerhunt-label-starting-clue' => 'Popup voor eerste aanwijzing',
	'scavengerhunt-label-starting-clue-title' => 'Popupnaam:',
	'scavengerhunt-label-starting-clue-text' => 'Popuptekst: <i>(tekst in een &lt;div&gt; krijg de kleur van verwijzingen)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Popupafbeelding (URL):',
	'scavengerhunt-label-starting-clue-button-text' => 'Popupknoptekst:',
	'scavengerhunt-label-starting-clue-button-target' => 'Popupknopdoelpagina (URL):',
	'scavengerhunt-label-article' => 'In-gamepagina',
	'scavengerhunt-label-article-title' => 'Paginanaam (op deze wiki):',
	'scavengerhunt-label-article-hidden-image' => 'Verborgen afbeelding:',
	'scavengerhunt-label-article-clue-title' => 'Naam voor aanwijzingspopup:',
	'scavengerhunt-label-article-clue-text' => 'Tekst voor aanwijzingspopup:',
	'scavengerhunt-label-article-clue-image' => 'Afbeelding voor aanwijzingspopup (URL):',
	'scavengerhunt-label-article-clue-button-text' => 'Knoptekst voor aanwijzingspopup:',
	'scavengerhunt-label-article-clue-button-target' => 'Knopdoelpagina voor aanwijzingspopup (URL):',
	'scavengerhunt-label-entry-form' => 'Inschrijfformulier',
	'scavengerhunt-label-entry-form-title' => 'Popupnaam:',
	'scavengerhunt-label-entry-form-text' => 'Popuptekst:',
	'scavengerhunt-label-entry-form-image' => 'Popupafbeelding (URL):',
	'scavengerhunt-label-entry-form-question' => 'Popupvraag:',
	'scavengerhunt-label-goodbye' => 'Popup voor tot ziens',
	'scavengerhunt-label-goodbye-title' => 'Popupnaam:',
	'scavengerhunt-label-goodbye-text' => 'Popupbericht:',
	'scavengerhunt-label-goodbye-image' => 'Popupafbeelding (URL):',
	'scavengerhunt-button-add' => 'Spel toevoegen',
	'scavengerhunt-button-save' => 'Opslaan',
	'scavengerhunt-button-disable' => 'Uitschakelen',
	'scavengerhunt-button-enable' => 'Inschakelen',
	'scavengerhunt-button-delete' => 'Verwijderen',
	'scavengerhunt-button-export' => 'Exporteren naar CSV',
	'scavengerhunt-form-error' => 'Corrigeer de volgende fouten:',
	'scavengerhunt-form-error-no-landing-title' => 'Voer de naam in van de beginpagina.',
	'scavengerhunt-form-error-invalid-title' => 'De volgende pagina bestaat niet: "$1".',
	'scavengerhunt-form-error-landing-button-text' => 'Voer tekst in voor de beginknop.',
	'scavengerhunt-form-error-starting-clue' => 'Voer alle velden in voor de eerste aanwijzing.',
	'scavengerhunt-form-error-entry-form' => 'Voer alle velden in voor het deelnameformulier.',
	'scavengerhunt-form-error-goodbye' => 'Voer alle velden in voor het de "Tot ziens" popup.',
	'scavengerhunt-form-error-no-article-title' => 'Voer alle paginanamen in.',
	'scavengerhunt-form-error-article-hidden-image' => "Voer alle adressen (URL's) in voor verborgen afbeeldingen.",
	'scavengerhunt-form-error-article-clue' => 'Voer alle gegevens in over pagina-aanwijzingen.',
	'scavengerhunt-game-has-been-created' => 'Er is een nieuwe speurtocht aangemaakt.',
	'scavengerhunt-game-has-been-saved' => 'De speurtocht is opgeslagen.',
	'scavengerhunt-game-has-been-enabled' => 'De aangegeven speurtocht is ingeschakeld.',
	'scavengerhunt-game-has-been-disabled' => 'De aangegeven speurtocht is uitgeschakeld.',
	'scavengerhunt-game-has-not-been-saved' => 'De speurtocht is niet opgeslagen.',
	'scavengerhunt-edit-token-mismatch' => 'Er is een probleem opgetreden met uw bewerkingstoken. Probeer het opnieuw.',
	'scavengerhunt-entry-form-name' => 'Uw naam:',
	'scavengerhunt-entry-form-email' => 'Uw e-mailadres:',
	'scavengerhunt-entry-form-submit' => 'Inschrijvingsformulier opslaan',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'scavengerhunt-entry-form-name' => 'Je naam:',
	'scavengerhunt-entry-form-email' => 'Je e-mailadres:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'scavengerhunt-desc' => 'Tillater opprettelse av et skattejakt-spill på en wiki',
	'scavengerhunt' => 'Grensesnitt for Skattejakt',
	'scavengerhunt-list-header-name' => 'Spillnavn',
	'scavengerhunt-list-header-is-enabled' => 'Aktivert?',
	'scavengerhunt-list-header-actions' => 'Handlinger',
	'scavengerhunt-list-enabled' => 'Aktivert',
	'scavengerhunt-list-disabled' => 'Deaktivert',
	'scavengerhunt-list-edit' => 'rediger',
	'scavengerhunt-label-dialog-check' => '(vis dialog)',
	'scavengerhunt-label-image-check' => '(vis bilde)',
	'scavengerhunt-label-general' => 'Generelt',
	'scavengerhunt-label-name' => 'Navn:',
	'scavengerhunt-label-landing-title' => 'Navn på destinasjonsside (artikkeltittel på denne wikien):',
	'scavengerhunt-label-landing-button-text' => 'Tekst for knapp på destinasjonsside:',
	'scavengerhunt-label-starting-clue' => 'Startsledetråd-popup',
	'scavengerhunt-label-starting-clue-title' => 'Popup-tittel:',
	'scavengerhunt-label-starting-clue-text' => 'Popup-tekst: <i>(tekst i &lt;div&gt; vil ha lenkefarge)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Popup-bilde (URL-adresse):',
	'scavengerhunt-label-starting-clue-button-text' => 'Tekst på popup-knapp:',
	'scavengerhunt-label-starting-clue-button-target' => 'Mål for popup-knapp (URL-adresse):',
	'scavengerhunt-label-article' => 'Side i spillet',
	'scavengerhunt-label-article-title' => 'Sidetittel (artikkeltittel på denne wikien):',
	'scavengerhunt-label-article-hidden-image' => 'Skjult bilde:',
	'scavengerhunt-label-article-clue-title' => 'Tittel for popup-ledetråd:',
	'scavengerhunt-label-article-clue-text' => 'Tekst for popup-ledetråd:',
	'scavengerhunt-label-article-clue-image' => 'Bilde for popup-ledetråd (URL-adresse):',
	'scavengerhunt-label-article-clue-button-text' => 'Tekst på knapp for popup-ledetråd:',
	'scavengerhunt-label-article-clue-button-target' => 'Mål for knapp for popup-ledetråd (URL-adresse):',
	'scavengerhunt-label-entry-form' => 'Påmeldingsskjema',
	'scavengerhunt-label-entry-form-title' => 'Popup-tittel:',
	'scavengerhunt-label-entry-form-text' => 'Popup-tekst:',
	'scavengerhunt-label-entry-form-image' => 'Popup-bilde (URL-adresse):',
	'scavengerhunt-label-entry-form-question' => 'Popup-spørsmål:',
	'scavengerhunt-label-goodbye' => 'Farvel-popup',
	'scavengerhunt-label-goodbye-title' => 'Popup-tittel:',
	'scavengerhunt-label-goodbye-text' => 'Popup-melding:',
	'scavengerhunt-label-goodbye-image' => 'Popup-bilde (URL-adresse):',
	'scavengerhunt-button-add' => 'Legg til et spill',
	'scavengerhunt-button-save' => 'Lagre',
	'scavengerhunt-button-disable' => 'Deaktiver',
	'scavengerhunt-button-enable' => 'Aktiver',
	'scavengerhunt-button-delete' => 'Slett',
	'scavengerhunt-button-export' => 'Eksporter til CSV',
	'scavengerhunt-form-error' => 'Vennligst korriger følgende feil:',
	'scavengerhunt-form-error-no-landing-title' => 'Vennligst oppgi tittelen på startsiden.',
	'scavengerhunt-form-error-invalid-title' => 'Følgende sidetittel ble ikke funnet: «$1».',
	'scavengerhunt-form-error-landing-button-text' => 'Vennligst oppgi teksten på startknappen.',
	'scavengerhunt-form-error-starting-clue' => 'Vennligst fyll ut alle feltene i seksjonen for startsledetråden.',
	'scavengerhunt-form-error-entry-form' => 'Vennligst fyll ut alle feltene i påmeldingsskjemaet.',
	'scavengerhunt-form-error-goodbye' => 'Vennligst fyll ut alle feltene i seksjonen for farvel-popup.',
	'scavengerhunt-form-error-no-article-title' => 'Vennligst oppgi alle artikkeltitler.',
	'scavengerhunt-form-error-article-hidden-image' => 'Vennligst oppgi alle adresser for skjulte bilder.',
	'scavengerhunt-form-error-article-clue' => 'Vennligst fyll ut all informasjom om artikkelledetråder.',
	'scavengerhunt-game-has-been-created' => 'Nytt Skattejakt-spill har blitt opprettet.',
	'scavengerhunt-game-has-been-saved' => 'Skattejakt-spillet har blitt lagret.',
	'scavengerhunt-game-has-been-enabled' => 'Valgte Skattejakt-spill har blitt aktivert.',
	'scavengerhunt-game-has-been-disabled' => 'Valgte Skattejakt-spill har blitt deaktivert.',
	'scavengerhunt-game-has-not-been-saved' => 'Skattejakt-spill har ikke blitt lagret.',
	'scavengerhunt-edit-token-mismatch' => 'Redigeringskoden samsvarte ikke - vennligst prøv igjen.',
	'scavengerhunt-entry-form-name' => 'Ditt navn:',
	'scavengerhunt-entry-form-email' => 'Din e-postadresse:',
	'scavengerhunt-entry-form-submit' => 'Send inn oppføring',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'scavengerhunt-list-edit' => 'سمول',
	'scavengerhunt-label-name' => 'نوم:',
	'scavengerhunt-button-save' => 'خوندي کول',
	'scavengerhunt-button-delete' => 'ړنګول',
	'scavengerhunt-entry-form-name' => 'ستاسې نوم:',
	'scavengerhunt-entry-form-email' => 'ستاسې برېښليک پته:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author SandroHc
 */
$messages['pt'] = array(
	'scavengerhunt-desc' => 'Permite a criação de um jogo de Caça ao Tesouro numa wiki',
	'scavengerhunt' => 'Interface da Caça ao Tesouro',
	'scavengerhunt-list-header-name' => 'Nome do jogo',
	'scavengerhunt-list-header-is-enabled' => 'Activado?',
	'scavengerhunt-list-header-actions' => 'Acções',
	'scavengerhunt-list-enabled' => 'Activado',
	'scavengerhunt-list-disabled' => 'Desactivado',
	'scavengerhunt-list-edit' => 'editar',
	'scavengerhunt-label-dialog-check' => '(mostrar diálogo)',
	'scavengerhunt-label-image-check' => '(mostrar imagem)',
	'scavengerhunt-label-general' => 'Geral',
	'scavengerhunt-label-name' => 'Nome:',
	'scavengerhunt-label-landing-title' => 'Nome da página de destino (título do artigo nesta wiki):',
	'scavengerhunt-label-landing-button-text' => 'Texto do botão da página de destino:',
	'scavengerhunt-label-starting-clue' => 'Janela da Pista Inicial',
	'scavengerhunt-label-starting-clue-title' => 'Título da janela:',
	'scavengerhunt-label-starting-clue-text' => 'Texto da janela <i>(o texto enter &lt;div&gt; terá a cor de um link)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Imagem da janela (endereço URL):',
	'scavengerhunt-label-starting-clue-button-text' => 'Texto do botão da janela:',
	'scavengerhunt-label-starting-clue-button-target' => 'Destino do botão da janela (endereço URL):',
	'scavengerhunt-label-article' => 'Página incluída no jogo',
	'scavengerhunt-label-article-title' => 'Título da página (título do artigo nesta wiki):',
	'scavengerhunt-label-article-hidden-image' => 'Imagem oculta:',
	'scavengerhunt-label-article-clue-title' => 'Título da janela da pista:',
	'scavengerhunt-label-article-clue-text' => 'Texto da janela da pista:',
	'scavengerhunt-label-article-clue-image' => 'Imagem da janela da pista (endereço URL):',
	'scavengerhunt-label-article-clue-button-text' => 'Texto do botão da janela da pista:',
	'scavengerhunt-label-article-clue-button-target' => 'Destino do botão da janela da pista (endereço URL):',
	'scavengerhunt-label-entry-form' => 'Formulário de entrada',
	'scavengerhunt-label-entry-form-title' => 'Título da janela:',
	'scavengerhunt-label-entry-form-text' => 'Texto da janela:',
	'scavengerhunt-label-entry-form-image' => 'Imagem da janela (endereço URL):',
	'scavengerhunt-label-entry-form-question' => 'Pergunta da janela:',
	'scavengerhunt-label-goodbye' => 'Janela de despedida',
	'scavengerhunt-label-goodbye-title' => 'Título da janela:',
	'scavengerhunt-label-goodbye-text' => 'Mensagem da janela:',
	'scavengerhunt-label-goodbye-image' => 'Imagem da janela (endereço URL):',
	'scavengerhunt-button-add' => 'Adicionar um jogo',
	'scavengerhunt-button-save' => 'Gravar',
	'scavengerhunt-button-disable' => 'Desactivar',
	'scavengerhunt-button-enable' => 'Activar',
	'scavengerhunt-button-delete' => 'Eliminar',
	'scavengerhunt-button-export' => 'Exportar para CSV',
	'scavengerhunt-form-error' => 'Corrija os seguintes erros, por favor:',
	'scavengerhunt-form-error-no-landing-title' => 'Introduza o título da página inicial, por favor.',
	'scavengerhunt-form-error-invalid-title' => 'O título de página "$1" não foi encontrado.',
	'scavengerhunt-form-error-landing-button-text' => 'Introduza o texto do botão de início.',
	'scavengerhunt-form-error-starting-clue' => 'Preencha todos os campos da secção da pista inicial, por favor.',
	'scavengerhunt-form-error-entry-form' => 'Preencha todos os campos da secção do formulário de entrada.',
	'scavengerhunt-form-error-goodbye' => 'Preencha todos os campos da secção da janela de despedida, por favor.',
	'scavengerhunt-form-error-no-article-title' => 'Introduza todos os títulos de artigos, por favor.',
	'scavengerhunt-form-error-article-hidden-image' => 'Introduza todos os endereços das imagens ocultas, por favor.',
	'scavengerhunt-form-error-article-clue' => 'Introduza todas as informações sobre as pistas dos artigos, por favor.',
	'scavengerhunt-game-has-been-created' => 'Foi criado um jogo novo de Caça ao Tesouro.',
	'scavengerhunt-game-has-been-saved' => 'O jogo da Caça ao Tesouro foi gravado.',
	'scavengerhunt-game-has-been-enabled' => 'O jogo seleccionado de Caça ao Tesouro foi activado.',
	'scavengerhunt-game-has-been-disabled' => 'O jogo seleccionado de Caça ao Tesouro foi desactivado.',
	'scavengerhunt-game-has-not-been-saved' => 'O jogo da Caça ao Tesouro não foi gravado.',
	'scavengerhunt-edit-token-mismatch' => 'Foi detectada uma incompatibilidade nas etiquetas de edição - tente novamente, por favor.',
	'scavengerhunt-entry-form-name' => 'O seu nome:',
	'scavengerhunt-entry-form-email' => 'Correio electrónico:',
	'scavengerhunt-entry-form-submit' => 'Enviar entrada',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'scavengerhunt-list-header-name' => 'Numele jocului',
	'scavengerhunt-list-header-is-enabled' => 'Activat?',
	'scavengerhunt-label-general' => 'General',
	'scavengerhunt-label-name' => 'Nume:',
	'scavengerhunt-button-add' => 'Adaugă un joc',
	'scavengerhunt-entry-form-name' => 'Numele tău:',
	'scavengerhunt-entry-form-email' => 'Adresa ta de e-mail:',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'scavengerhunt-list-enabled' => 'Омогућено',
	'scavengerhunt-list-disabled' => 'Онемогућено',
	'scavengerhunt-list-edit' => 'уреди',
	'scavengerhunt-label-dialog-check' => '(прикажи прозорче)',
	'scavengerhunt-label-general' => 'Опште',
	'scavengerhunt-label-name' => 'Име:',
	'scavengerhunt-label-starting-clue-image' => 'Искачућа слика:',
	'scavengerhunt-label-article-title' => 'Наслов странице:',
	'scavengerhunt-label-article-hidden-image' => 'Сакривена слика:',
	'scavengerhunt-button-save' => 'Сачувај',
	'scavengerhunt-button-disable' => 'Онемогући',
	'scavengerhunt-button-enable' => 'Омогући',
	'scavengerhunt-button-delete' => 'Обриши',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'scavengerhunt-list-header-name' => 'ఆట పేరు',
	'scavengerhunt-list-header-actions' => 'చర్యలు',
	'scavengerhunt-label-name' => 'పేరు:',
	'scavengerhunt-label-article-title' => 'పుట శీర్షిక (ఈ వికీ లోని వ్యాసపు శీర్షిక):',
	'scavengerhunt-button-save' => 'భద్రపరచు',
	'scavengerhunt-button-delete' => 'తొలగించు',
	'scavengerhunt-entry-form-name' => 'మీ పేరు:',
	'scavengerhunt-entry-form-email' => 'మీ ఈ-మెయిలు చిరునామా:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'scavengerhunt-desc' => 'Nagpapahintulot sa paglikha ng isang laro ng tagapaghanap ng mga mapapakinabangan sa isang wiki',
	'scavengerhunt' => 'Ugnayang mukha ng pangangaso ng tagapaghanap ng mga mapapakinabangan',
	'scavengerhunt-list-header-name' => 'Pangalan ng laro',
	'scavengerhunt-list-header-is-enabled' => 'Pinagagana ba?',
	'scavengerhunt-list-header-actions' => 'Mga galaw',
	'scavengerhunt-list-enabled' => 'Pinagana na',
	'scavengerhunt-list-disabled' => 'Hindi pinagagana',
	'scavengerhunt-list-edit' => 'baguhin',
	'scavengerhunt-label-dialog-check' => '(ipakita ang diyalogo)',
	'scavengerhunt-label-image-check' => '(ipakita ang larawan)',
	'scavengerhunt-label-general' => 'Pangkalahatan',
	'scavengerhunt-label-name' => 'Pangalan:',
	'scavengerhunt-label-landing-title' => 'Pangalan ng pahinang lapagan (pamagat ng artikulo sa wiking ito):',
	'scavengerhunt-label-landing-button-text' => 'Teksto ng pindutan ng pahinang lapagan:',
	'scavengerhunt-label-starting-clue' => 'Biglang-litaw na Pansimulang Pahiwatig',
	'scavengerhunt-label-starting-clue-title' => 'Pamagat ng biglang-litaw:',
	'scavengerhunt-label-starting-clue-text' => 'Teksto ng biglang-litaw: <i>(ang tekstong nasa &lt;div&gt; ay magkakaroon ng kulay ng kawing)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Larawan ng biglang-litaw (tirahan ng URL):',
	'scavengerhunt-label-starting-clue-button-text' => 'Teksto ng pindutan ng biglang-litaw:',
	'scavengerhunt-label-starting-clue-button-target' => 'Puntirya ng pindutan ng biglang-litaw (tirahan ng URL):',
	'scavengerhunt-label-article' => 'Pahina sa loob ng laro',
	'scavengerhunt-label-article-title' => 'Pamagat ng pahina (pamagat ng artikulo sa wiking ito):',
	'scavengerhunt-label-article-hidden-image' => 'Nakatagong larawan:',
	'scavengerhunt-label-article-clue-title' => 'Biglang-litaw na pamagat ng pahiwatig:',
	'scavengerhunt-label-article-clue-text' => 'Biglang-litaw na pamagat ng pahiwatig:',
	'scavengerhunt-label-article-clue-image' => 'Biglang-litaw na larawan ng pahiwatig (tirahan ng URL):',
	'scavengerhunt-label-article-clue-button-text' => 'Teksto ng biglang-litaw na pahiwatig:',
	'scavengerhunt-label-article-clue-button-target' => 'Puntirya ng biglang-litaw na pindutan ng pahiwatig (tirahan ng URL):',
	'scavengerhunt-label-entry-form' => 'Pormularyong pasukan',
	'scavengerhunt-label-entry-form-title' => 'Pamagat ng biglang-litaw:',
	'scavengerhunt-label-entry-form-text' => 'Teksto ng biglang-litaw:',
	'scavengerhunt-label-entry-form-image' => 'Larawan ng biglang-litaaw (tirahan ng URL):',
	'scavengerhunt-label-entry-form-question' => 'Biglang-litaw na tanong:',
	'scavengerhunt-label-goodbye' => 'Biglang-litaw na pamamaalam',
	'scavengerhunt-label-goodbye-title' => 'Pamagat ng biglang-litaw:',
	'scavengerhunt-label-goodbye-text' => 'Biglang-litaw na mensahe:',
	'scavengerhunt-label-goodbye-image' => 'Biglang-litaw na larawan (tirahan ng URL):',
	'scavengerhunt-button-add' => 'Magdagdag ng isang laro',
	'scavengerhunt-button-save' => 'Sagipin',
	'scavengerhunt-button-disable' => 'Huwag paganahin',
	'scavengerhunt-button-enable' => 'Paganahin',
	'scavengerhunt-button-delete' => 'Burahin',
	'scavengerhunt-button-export' => 'Iluwas sa CSV',
	'scavengerhunt-form-error' => 'Pakitama ang sumusunod na mga kamalian:',
	'scavengerhunt-form-error-no-landing-title' => 'Pakipasok ang pamagat ng pahina ng pagsisimula.',
	'scavengerhunt-form-error-invalid-title' => 'Hindi natagpuan ang sumusunod na pamagat ng pahina: "$1".',
	'scavengerhunt-form-error-landing-button-text' => 'Pakipasok ang teksto ng pindutan ng pagsisimula.',
	'scavengerhunt-form-error-starting-clue' => 'Pakipunuan ang lahat ng mga hanay na nasa loob ng bahagi ng pansimulang pahiwatig.',
	'scavengerhunt-form-error-entry-form' => 'Pakipunuan ang lahat ng mga hanay na nasa loob ng bahagi ng pormularyong pasukan.',
	'scavengerhunt-form-error-goodbye' => 'Pakipunuan ang lahat ng mga hanay na nasa bahagi ng biglang-litaw na pamamaalam.',
	'scavengerhunt-form-error-no-article-title' => 'Pakipasok ang lahat ng mga pamagat ng artikulo.',
	'scavengerhunt-form-error-article-hidden-image' => 'Pakipasok ang lahat ng mga tirahan para sa nakatagong mga larawan.',
	'scavengerhunt-form-error-article-clue' => 'Pakipasok ang lahat ng kabatiran tungkol sa mga pahiwatig ng artikulo.',
	'scavengerhunt-game-has-been-created' => 'Nalikha ang bagong laro ng Paghahanap ng mga Mapapakinabangan.',
	'scavengerhunt-game-has-been-saved' => 'Nasagip na ang laro ng Paghahanap ng mga Mapapakinabangan.',
	'scavengerhunt-game-has-been-enabled' => 'Pinagana ang napiling laro ng Paghahanap ng mga Mapapakinabangan.',
	'scavengerhunt-game-has-been-disabled' => 'Hindi pinagana ang napiling laro ng Paghahanap ng Mapapakinabangan.',
	'scavengerhunt-game-has-not-been-saved' => 'Hindi pa nasasagip ang laro ng Paghahanap ng Mapapakinabangan.',
	'scavengerhunt-edit-token-mismatch' => 'Hindi pagtutugma ng kahalip ng pagbago - mangyaring subukan uli.',
	'scavengerhunt-entry-form-name' => 'Pangalan mo:',
	'scavengerhunt-entry-form-email' => 'Tirahan ng e-liham mo:',
	'scavengerhunt-entry-form-submit' => 'Ipasa ang ipinasok',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'scavengerhunt-list-header-name' => '游戏名',
	'scavengerhunt-label-name' => '名：',
	'scavengerhunt-button-add' => '添加一个游戏',
	'scavengerhunt-button-save' => '保存',
	'scavengerhunt-button-delete' => '删除',
	'scavengerhunt-entry-form-name' => '您的名字：',
	'scavengerhunt-entry-form-email' => '您的电子邮件地址：',
);

