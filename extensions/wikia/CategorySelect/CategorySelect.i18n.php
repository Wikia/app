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
		'tog-disablecategoryselect' => 'Disable Category Tagging'
	)
);