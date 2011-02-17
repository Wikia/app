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
	'scavengerhunt-label-starting-clue-text' => 'Popup text: <i>(text in &lt;span&gt; will have link color)</i>',
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
	'scavengerhunt-form-error-article-hidden-image' => 'Please enter image addresses for hidden.',
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
 */
$messages['de'] = array(
	'scavengerhunt-label-name' => 'Name:',
	'scavengerhunt-entry-form-name' => 'Dein Name:',
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
	'scavengerhunt-label-general' => 'Општо',
	'scavengerhunt-label-name' => 'Име:',
	'scavengerhunt-label-landing-title' => 'Име на целната страница:',
	'scavengerhunt-label-landing-button-text' => 'Текст на копчето на целната страница:',
	'scavengerhunt-label-starting-clue' => 'Скокачки прозорец за потсетки при почнување:',
	'scavengerhunt-label-starting-clue-title' => 'Наслов на скокачкиот прозорец:',
	'scavengerhunt-label-starting-clue-text' => 'Текст на скокачкиот прозорец: <i>(текстот во &lt;span&gt; ќе ја има бојата на врските)</i>',
	'scavengerhunt-label-starting-clue-image' => 'Слика за скокачкиот прозорец:',
	'scavengerhunt-label-starting-clue-button-text' => 'Текст на копчето на скокачкиот прозорец:',
	'scavengerhunt-label-starting-clue-button-target' => 'Одредница на копчето на скокачкиот процорец:',
	'scavengerhunt-label-article' => 'Страница во текот на играта',
	'scavengerhunt-label-article-title' => 'Наслов на страницата:',
	'scavengerhunt-label-article-hidden-image' => 'Скриена слика:',
	'scavengerhunt-label-article-clue-title' => 'Наслов на скокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-text' => 'Текст на скокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-image' => 'Слика на скокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-button-text' => 'Текст на копчето на сокачкиот прозорец за потсетка:',
	'scavengerhunt-label-article-clue-button-target' => 'Одредница на копчето на скокачкиот прозорец за потсетка:',
	'scavengerhunt-label-entry-form' => 'Пријава',
	'scavengerhunt-label-entry-form-title' => 'Наслов на скокачкиот прозорец:',
	'scavengerhunt-label-entry-form-text' => 'Текст на скокачкиот прозорец:',
	'scavengerhunt-label-entry-form-image' => 'Слика за скокачкиот прозорец:',
	'scavengerhunt-label-entry-form-question' => 'Прашање за скокачкиот прозорец:',
	'scavengerhunt-label-goodbye' => 'Скокачки прозорец за догледање',
	'scavengerhunt-label-goodbye-title' => 'Наслов за догледање:',
	'scavengerhunt-label-goodbye-text' => 'Порака на скокачкиот прозорец:',
	'scavengerhunt-label-goodbye-image' => 'Слика за скокачкиот прозорец:',
	'scavengerhunt-button-add' => 'Додај игра',
	'scavengerhunt-button-save' => 'Зачувај',
	'scavengerhunt-button-disable' => 'Оневозможи',
	'scavengerhunt-button-enable' => 'Овозможи',
	'scavengerhunt-button-delete' => 'Избриши',
	'scavengerhunt-button-export' => 'Извези во CSV',
	'scavengerhunt-form-error' => 'Исправете ги следниве грешки:',
	'scavengerhunt-game-has-been-created' => 'Создадена е нова игра „Потрага“.',
	'scavengerhunt-game-has-been-saved' => 'Оваа „Потрага“ е зачувана.',
	'scavengerhunt-game-has-been-enabled' => 'Одбраната „Потрага“ е овозможена.',
	'scavengerhunt-game-has-been-disabled' => 'Одбраната „Потрага“ е оневозможена.',
	'scavengerhunt-game-has-not-been-saved' => 'Оваа „Потрага“ не е зачувана.',
	'scavengerhunt-entry-form-name' => 'Вашето име:',
	'scavengerhunt-entry-form-email' => 'Ваша е-пошта:',
	'scavengerhunt-entry-form-submit' => 'Поднеси',
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
	'scavengerhunt-label-starting-clue-text' => 'Popuptekst: <i>(tekst in een &lt;span&gt; krijg de kleur van verwijzingen)</i>',
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
	'scavengerhunt-form-error-article-hidden-image' => "Voer de afbeeldingsadressen (URL's) in voor verborgen.",
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
	'scavengerhunt-label-article-title' => 'పుట శీర్షిక:',
	'scavengerhunt-button-save' => 'భద్రపరచు',
	'scavengerhunt-button-delete' => 'తొలగించు',
	'scavengerhunt-entry-form-name' => 'మీ పేరు:',
	'scavengerhunt-entry-form-email' => 'మీ ఈ-మెయిలు చిరునామా:',
);

