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
	global $wgHooks, $wgUser;

	// do not touch skins other than Monaco
	// init only for anons
	$skinName = get_class($wgUser->getSkin());
	if ($skinName != 'SkinMonaco' || !$wgUser->isAnon()) {
		return true;
	}
	$wgHooks['MakeGlobalVariablesScript'][] = 'TOCimprovementsSetupVars';
	$wgHooks['SkinGetPageClasses'][] = 'TOCimprovementsAddBodyClass';
}

/**
 * Set variables for JS usage
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function TOCimprovementsSetupVars($vars) {
	//used in wikibits.js to enable anon handling
	$vars['TOCimprovementsEnabled'] = '1';

	return true;
}

/**
 * add CSS class to <body> to hide TOC
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function TOCimprovementsAddBodyClass($classes) {
	global $wgUser;
	if (!isset($_COOKIE['hidetoc']) || $_COOKIE['hidetoc'] == '1') {
		$classes .= ' TOCimprovements';
	}
	return true;
}