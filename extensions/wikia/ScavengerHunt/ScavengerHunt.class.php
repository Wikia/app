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
 *     include("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class ScavengerHunt {

	/*
	 * hook handler
	 *
	 * @author Marooned
	 * @author wladek
	 */
	public function onMakeGlobalVariablesScript( &$vars ) {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$out = $app->getGlobal('wgOut');
		$title = $app->getGlobal('wgTitle');

		// skip the rest if the title does not have article id
		if (!$title->getArticleId()) {
			return true;
		}

		$games = WF::build('ScavengerHuntGames');

		//TODO: limit below code to content namespaces?
		$triggers = $games->getTitleTriggers($title);
		if (!empty($triggers)) {
			if (!empty($triggers['start'])) {
				$game = $games->findById(reset($triggers['start']));
				if (!empty($game)) {
					//variables for starting page
					$vars['ScavengerHuntStart'] = (int)$game->getId();
					$vars['ScavengerHuntStartMsg'] = $game->getLandingButtonText();
					$vars['ScavengerHuntStartTitle'] = $game->getStartingClueTitle();
					$vars['ScavengerHuntStartText'] = $game->getStartingClueText();
					$vars['ScavengerHuntStartImage'] = $game->getStartingClueImage();
					$vars['ScavengerHuntStartButtonText'] = $game->getStartingClueButtonText();
					$vars['ScavengerHuntStartButtonTarget'] = $game->getStartingClueButtonTarget();
				}
			}
			if (!empty($triggers['article'])) {
				$game = $games->findById(reset($triggers['article']));
				if (!empty($game)) {
					$article = $game->findArticleByTitle($title);
					if (!empty($article)) {
						//variables for article page
						$vars['ScavengerHuntArticleGameId'] = (int)$game->getId();
						$vars['ScavengerHuntArticleImg'] = $article->getHiddenImage();
					}
				}
			}

			//include JS and CSS when on any page connected to the game
			$out->addScriptFile($app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-game.js');
			$out->addStyle($app->runFunction('wfGetSassUrl', 'extensions/wikia/ScavengerHunt/css/scavenger-game.scss'));
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}