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
	'scavengerhunt-desc' => 'Alows to create a scavenger hunt game on a wiki.',
	'scavengerhunt' => 'Scavenger hunt interface',
	'scavengerhunt-label-entry-info' => 'Entry:',
	'scavengerhunt-label-game-name' => 'Game name:',
	'scavengerhunt-label-landing' => 'Landing page name:',
	'scavengerhunt-label-starting-clue' => 'Starting Clue box text:',
	'scavengerhunt-label-starting-image' => 'Starting Clue box image:',
	'scavengerhunt-label-page-title' => 'Page title:',
	'scavengerhunt-label-hidden-image' => 'Page picture (direct image url):',
	'scavengerhunt-label-clue-image' => 'Picture in a clue box (direct image url):',
	'scavengerhunt-label-clue' => 'Clue box text:',
	'scavengerhunt-label-clue-link' => 'Clue box link:',
	'scavengerhunt-label-entry-form' => 'Entry form text:',
	'scavengerhunt-label-final-question' => 'Final entry form question:',
	'scavengerhunt-label-goodbye-msg' => 'Goodbye message:',
	'scavengerhunt-label-goodbye-image' => 'Goodbye image:',
	'scavengerhunt-button-add' => 'Add a game',
	'scavengerhunt-button-save' => 'Save',
	'scavengerhunt-button-disable' => 'Disable',
	'scavengerhunt-button-enable' => 'Enable',
	'scavengerhunt-button-delete' => 'Delete',
	'scavengerhunt-button-export' => 'Export to CSV',

	'scavengerhunt-form-error' => 'Please correct the following errors:',
	'scavengerhunt-form-invalid-landing-title' => 'Please enter an existing title as landing page.',
	'scavengerhunt-form-no-final-form-text' => 'Please enter a final form text.',
	'scavengerhunt-form-invalid-article-title' => 'Please enter existing titles as game articles.',
	'scavengerhunt-form-no-hidden-image' => 'Please enter hidden images addresses for every game article.',
	'scavengerhunt-form-no-clue-text' => 'Please enter clue texts for every game article.',

	'scavengerhunt-game-has-been-created' => 'New Scavenger Hunt game has been created.',
	'scavengerhunt-game-has-been-saved' => 'Scavenger Hunt game has been saved.',
	'scavengerhunt-game-has-been-enabled' => 'Selected Scavenger Hunt game has been enabled.',
	'scavengerhunt-game-has-been-disabled' => 'Selected Scavenger Hunt game has been disabled.',
	'scavengerhunt-game-has-not-been-saved' => 'Scavenger Hunt game has not been saved.',

	'scavengerhunt-button-play' => 'Play the game!',
);

$messages['qqq'] = array(
	'scavengerhunt-desc' => '{{desc}}',
);