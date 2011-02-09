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

		$app = WF::build('App');
		$out = $app->getGlobal('wgOut');
		$title = $app->getGlobal('wgTitle');
		$games = WF::build('ScavengerHuntGames');

		//TODO: limit below code to content namespaces?
		$triggers = $games->getTitleTriggers($title);
		if (is_array($triggers)) {
			if (isset($triggers['start']) && is_array($triggers['start'])) {
				//varialbles when on starting page
				$vars['ScavengerHuntStart'] = (int)reset(array_values($triggers['start']));
				$vars['ScavengerHuntStartMsg'] = wfMsgForContent('scavengerhunt-button-play');
				$vars['ScavengerHuntStartTitle'] = wfMsgForContent('scavengerhunt-starting-clue-title');
				$vars['ScavengerHuntStartClue'] = 'TODO: startingClue here';
				$vars['ScavengerHuntStartImg'] = 'TODO: startingImage here';
			}
			if (isset($triggers['article']) && is_array($triggers['article'])) {
				//variables when on article page
				$vars['ScavengerHuntArticleGameId'] = (int)reset(array_values($triggers['article']));
				$vars['ScavengerHuntArticleImg'] = 'http://img844.imageshack.us/img844/5619/piggy2.png';
			}

			//include JS (TODO: and CSS) when on any page connected to the game
			$out->addScriptFile($app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-game.js');
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}