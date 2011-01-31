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

class ScavengerHunt {
	/*
	 * hook handler
	 *
	 * @author Marooned
	 */
	static function onMakeGlobalVariablesScript(&$vars) {
		global $wgTitle;
		wfProfileIn(__METHOD__);

		//TODO: if wgTitle is in game, add some information (gameID, numbers of al articles to be found)
		if (false) {
			$vars['scavengerhunt'] = 1;
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}