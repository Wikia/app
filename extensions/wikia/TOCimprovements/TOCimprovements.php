<?php

/**
 * TOCimprovements
 *
 * A TOCimprovements extension for MediaWiki
 * Tweaks for TOC
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-05-25
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/TOCimprovements/TOCimprovements.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named TOCimprovements.\n";
	exit(1) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'TOCimprovements',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'Tweaks for TOC.'
);

$wgExtensionFunctions[] = 'TOCimprovementsInit';

/**
 * Initialize hooks
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function TOCimprovementsInit() {
	global $wgHooks;
	$wgHooks['SkinGetPageClasses'][] = 'TOCimprovementsAddBodyClass';
	$wgHooks['BeforePageDisplay'][] = 'TOCcssfornoscript';
}

/**
 * Adds a script to a page that protects users without JavaScript from not being able
 * too see TOC (which is now hidden by default)
 */
function TOCcssfornoscript( OutputPage &$out, &$skin ) {
	$out->addHtml( '<noscript><link rel="stylesheet" href="' . F::app()->wg->ExtensionsPath . '/wikia/TOCimprovements/TOCNoScript.css" /></noscript>' );
	return true;
}

/**
 * add CSS class to <body> to hide TOC
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function TOCimprovementsAddBodyClass(&$classes) {
	global $wgUser;
	if( $wgUser->isLoggedIn() ) {
		if (isset($_COOKIE['mw_hidetoc']) && $_COOKIE['mw_hidetoc'] === '1') {
			$classes .= ' TOC_hide';
		}
	} else {
		$classes .= ' TOC_hide';
	}
	return true;
}

