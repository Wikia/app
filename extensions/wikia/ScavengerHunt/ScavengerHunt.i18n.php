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
	'scavengerhunt-label-landing' => 'Landing page name',
	'scavengerhunt-label-starting-clue' => 'Starting Clue box text',
	'scavengerhunt-label-page-title' => 'Page title',
	'scavengerhunt-label-hidden-image' => 'Page picture (direct image url)',
	'scavengerhunt-label-clue-image' => 'Picture in a clue box (direct image url)',
	'scavengerhunt-label-clue' => 'Clue box text',
	'scavengerhunt-label-entry-form' => 'Entry form text',
	'scavengerhunt-label-final-question' => 'Final entry form question',
	'scavengerhunt-label-goodbye-msg' => 'Goodbye message',
	'scavengerhunt-button-add' => 'Add a game',
	'scavengerhunt-button-save' => 'Save',
	'scavengerhunt-button-disable' => 'Disable',
	'scavengerhunt-button-enable' => 'Enable',
	'scavengerhunt-button-delete' => 'Delete',
	'scavengerhunt-button-export' => 'Export to CSV',
);

$messages['qqq'] = array(
	'scavengerhunt-desc' => '{{desc}}',
);