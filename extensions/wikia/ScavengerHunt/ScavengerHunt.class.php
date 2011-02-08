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
	 * @author wladek
	 */
	function onMakeGlobalVariablesScript( &$vars ) {
		wfProfileIn(__METHOD__);

		$title = WF::build('App')->getGlobal('wgTitle');
		$games = WF::build('ScavengerHuntGames');

		$triggers = $games->getTitleTriggers($title);
		if (is_array($triggers)) {
			if (is_array($triggers['start'])) {
				$vars['ScavengerHuntStart'] = json_encode(array_values($triggers['start']));
				$vars['ScavengerHuntStartMsg'] = wfMsg('scavengerhunt-button-play');
			}
			if (is_array($triggers['article'])) {
				$vars['ScavengerHuntArticles'] = json_encode(array_values($triggers['article']));
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}