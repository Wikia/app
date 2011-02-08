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
				//varialbles when on starting page
				$vars['ScavengerHuntStart'] = json_encode(array_values($triggers['start']));
				$vars['ScavengerHuntStartMsg'] = wfMsgForContent('scavengerhunt-button-play');
				$vars['ScavengerHuntStartTitle'] = wfMsgForContent('scavengerhunt-starting-clue-title');
				$vars['ScavengerHuntStartClue'] = 'TODO: startingClue here';
				$vars['ScavengerHuntStartImg'] = 'TODO: startingImage here';
			}
			if (is_array($triggers['article'])) {
				//variables when on article page
				$vars['ScavengerHuntArticles'] = json_encode(array_values($triggers['article']));
				$vars['ScavengerHuntArticleImg'] = 'TODO: hiddenImage here';
			}

			//include JS (TODO: and CSS) when on any page connected to the game
//			$this->out->addScriptFile($this->app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-game.js');
			//TODO: change below to above style
			global $wgOut, $wgScriptPath;
			$wgOut->addScriptFile($wgScriptPath . '/extensions/wikia/ScavengerHunt/js/scavenger-game.js');
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}