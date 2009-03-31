<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright (C) 2008 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows for searching inside categories
 * Written for MixesDB <http://mixesdb.com> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the AdvancedSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdvancedSearch/AdvancedSearch.setup.php" );
EOT;
	exit(1);
}

$messages = array();

$messages['en'] = array(
	'advancedsearch' 			=> 'Advanced Search',
	'advancedsearch-toptext'		=> 'This is the advanced search, see [[Help:Search]] for more information',
	'advancedsearch-pagename' 		=> 'AdvancedSearch',
	'advancedsearch-title'			=> 'Advanced Search',
	'advancedsearch-contentsearch'		=> 'Search in page content',
	'advancedsearch-searchin'		=> 'Search in:',
	'advancedsearch-searchin-title'		=> 'titles',
	'advancedsearch-searchin-content'	=> 'content',
	'advancedsearch-content-include'	=> 'List articles that contain:',
	'advancedsearch-content-exclude'	=> 'Don\'t list articles that contain:',
	'advancedsearch-categorysearch'		=> 'Search in categories',
	'advancedsearch-category-include'	=> 'List articles in these categories:',
	'advancedsearch-category-exclude'	=> 'Don\'t list articles in these categories:',
	'advancedsearch-speedcats'		=> 'Common categories',
	'advancedsearch-speedcat-dropdown'	=> 'Choose a category:',
	'advancedsearch-namespaces'		=> 'Namespaces',
	'advancedsearch-selectall'		=> 'Select all',
	'advancedsearch-selectnone'		=> 'Deselect all',
	'advancedsearch-invertselection'	=> 'Invert selection',
	'advancedsearch-submit'			=> 'Search',
	'advancedsearch-keyword-and'		=> 'AND',
	'advancedsearch-keyword-or'		=> 'OR',
	'advancedsearch-permalink'		=> 'A permanent link to this search is $1.',
	'advancedsearch-permalink-text'		=> 'here',
	'advancedsearch-permalink-check'	=> 'Get a permanent link to this search',
	'advancedsearch-permalink-invalid'	=> 'The permanent link you clicked is invalid',
	'advancedsearch-parse-error-1'		=> 'Parse error: unexpected \'$2\': <i>$1 <b>$2</b> $3</i>',
	'advancedsearch-parse-error-2'		=> 'Parse error: found \')\' without matching \'(\': <i>$1 <b>$2</b> $3</i>',
	'advancedsearch-parse-error-3'		=> 'Parse error: found more \'(\' than \')\'',
	'advancedsearch-parse-error-4'		=> 'Parse error: unterminated "',
	'advancedsearch-parse-error-5'		=> '"$1" is shorter than four letters. Such short words are not allowed',
	'advancedsearch-parse-error-6'		=> '"$1" is a frequently-used word. Such words are not allowed',
	'advancedsearch-empty-result'		=> 'No matches were found for your search',
);
