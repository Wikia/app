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

	'scavengerhunt-goodbye-button-text' => 'Bye',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'scavengerhunt-desc' => '{{desc}}',
);

/** German (Deutsch)
 * @author George Animal
 */
$messages['de'] = array(
	'scavengerhunt-label-name' => 'Name:',
	'scavengerhunt-entry-form-name' => 'Dein Name:',
);

