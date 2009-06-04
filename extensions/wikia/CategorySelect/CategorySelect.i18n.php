<?php

/**
 * CategorySelect
 *
 * A CategorySelect extension for MediaWiki
 * Provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-01-13
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CategorySelect/CategorySelect.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named CategorySelect.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'categoryselect-code-view' => 'Code view',
		'categoryselect-visual-view' => 'Visual view',
		'categoryselect-infobox-caption' => 'Category options',
		'categoryselect-infobox-category' => 'Provide the name of the category:',
		'categoryselect-infobox-sortkey' => 'Alphabetize this article on the "$1" category page under the name:',
		'categoryselect-addcategory-button' => 'Add category',
		'categoryselect-suggest-hint' => 'Press Enter when done',
		'categoryselect-tooltip' => "'''New!''' Category tagging toolbar. Try it out or see [[Help:CategorySelect|help]] to learn more",
		'categoryselect-unhandled-syntax' => 'Unhandled syntax detected - switching back to visual mode impossible.',
		'categoryselect-edit-summary' => 'Adding categories',
		'categoryselect-empty-name' => 'Provide category name (part before |)',
		'categoryselect-button-save' => 'Save',
		'categoryselect-button-cancel' => 'Cancel',
		'categoryselect-error-not-exist' => 'Article [id=$1] does not exist.',
		'categoryselect-error-user-rights' => 'User rights error.',
		'categoryselect-error-db-locked' => 'Database is locked.',
		'tog-disablecategoryselect' => 'Disable Category Tagging'
	),
	'fi' => array(
		'categoryselect-code-view' => 'Näytä koodi',
		'categoryselect-visual-view' => 'Näytä visuaalisena',
		'categoryselect-infobox-caption' => 'Luokan asetukset',
		'categoryselect-infobox-category' => 'Syötä luokan nimi:',
		'categoryselect-infobox-sortkey' => 'Aakkosta tämä artikkeli "$1" luokkasivulle nimellä:',
		'categoryselect-addcategory-button' => 'Lisää luokka',
		'categoryselect-suggest-hint' => 'Paina Enter, kun olet valmis',
		'categoryselect-tooltip' => "'''Uutuus!''' Luokan lisäystyökalurivi. Testaa sitä tai katso [[Ohje:CategorySelect|ohje]] saadaksesi lisätietoa.",
		'categoryselect-unhandled-syntax' => 'Käsittelemätön syntaksi havaittu - visuaalisen moodin takaisin kytkentä on mahdotonta.',
		'categoryselect-edit-summary' => 'Luokkien lisääminen',
		'categoryselect-empty-name' => 'Syötä luokan nimi (osaa ennen |)',
		'categoryselect-button-save' => 'Tallenna',
		'categoryselect-button-cancel' => 'Peruuta',
		'tog-disablecategoryselect' => 'peru luokkien lisäys'
	)
);
